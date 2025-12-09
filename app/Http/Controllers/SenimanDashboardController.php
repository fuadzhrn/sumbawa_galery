<?php

namespace App\Http\Controllers;

use App\Models\KaryaSeni;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SenimanDashboardController extends Controller
{
    /**
     * Display seniman dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $karyaSeni = $user->karyaSeni()->paginate(10);
        $kategoris = Kategori::all();
        
        // Calculate stats
        $totalKarya = $user->karyaSeni()->count();
        $totalPending = $user->karyaSeni()->where('status', 'pending')->count();
        $totalApproved = $user->karyaSeni()->where('status', 'approved')->count();
        $totalRejected = $user->karyaSeni()->where('status', 'rejected')->count();

        return view('seniman.dashboard', [
            'karyaSeni' => $karyaSeni,
            'kategoris' => $kategoris,
            'totalKarya' => $totalKarya,
            'totalPending' => $totalPending,
            'totalApproved' => $totalApproved,
            'totalRejected' => $totalRejected,
        ]);
    }

    /**
     * Show upload form
     */
    public function upload()
    {
        $kategoris = Kategori::all();
        return view('seniman.upload', [
            'kategoris' => $kategoris,
        ]);
    }

    /**
     * Show status page
     */
    public function status()
    {
        $user = Auth::user();
        // Get only approved karya
        $karyaSeni = $user->karyaSeni()
            ->where('status', 'approved')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        
        return view('seniman.status', [
            'karyaSeni' => $karyaSeni,
        ]);
    }

    /**
     * Show accepted works
     */
    public function accepted()
    {
        $user = Auth::user();
        $karyaSeni = $user->karyaSeni()->where('status', 'approved')->paginate(10);
        
        return view('seniman.accepted', [
            'karyaSeni' => $karyaSeni,
        ]);
    }

    /**
     * Show profile page
     */
    public function profile()
    {
        $user = Auth::user();
        $seniman = $user->seniman;
        $totalKarya = $user->karyaSeni()->count();
        $totalViews = $user->karyaSeni()->sum('views') ?? 0;
        $totalLikes = $user->karyaSeni()->sum('likes') ?? 0;

        return view('seniman.profile', [
            'user' => $user,
            'seniman' => $seniman,
            'totalKarya' => $totalKarya,
            'totalViews' => $totalViews,
            'totalLikes' => $totalLikes,
        ]);
    }

    /**
     * Show karya page (list all user's karya)
     */
    public function karya()
    {
        $user = Auth::user();
        $karyaSeni = $user->karyaSeni()->paginate(10);

        return view('seniman.karya-list', [
            'karyaSeni' => $karyaSeni,
        ]);
    }

    /**
     * Show settings page
     */
    public function settings()
    {
        return view('seniman.settings');
    }

    /**
     * Store new karya seni
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'media_type' => 'required|in:image,video,youtube_link',
            'media_file' => 'nullable|file|max:102400', // 100MB for video
            'media_url' => 'nullable|string', // For YouTube links
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        try {
            $validated['user_id'] = Auth::id();
            $validated['status'] = 'pending';

            // Handle media file upload or URL
            if ($request->hasFile('media_file')) {
                $mediaFile = $request->file('media_file');
                $userDir = Auth::id();
                $mediaDir = public_path("assets/karya_seni/{$userDir}");
                
                // Create user directory if it doesn't exist
                if (!is_dir($mediaDir)) {
                    mkdir($mediaDir, 0755, true);
                }
                
                // Generate unique filename
                $timestamp = time();
                $random = substr(uniqid(), -8);
                $extension = strtolower($mediaFile->getClientOriginalExtension());
                $filename = "karya-{$timestamp}-{$random}.{$extension}";
                
                // Move file directly to public/assets
                $moved = $mediaFile->move($mediaDir, $filename);
                if (!$moved) {
                    throw new \Exception('Gagal memindahkan file media ke direktori karya seni');
                }
                $validated['media_path'] = "assets/karya_seni/{$userDir}/{$filename}";
            } elseif ($request->filled('media_url')) {
                // Accept URL for any media type (image, video, youtube)
                $validated['media_path'] = $request->input('media_url');
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $userDir = Auth::id();
                $thumbDir = public_path("assets/thumbnails/{$userDir}");
                
                // Create user directory if it doesn't exist
                if (!is_dir($thumbDir)) {
                    mkdir($thumbDir, 0755, true);
                }
                
                $thumbFilename = "thumb-" . time() . "-" . substr(uniqid(), -8) . ".jpg";
                $moved = $thumbnail->move($thumbDir, $thumbFilename);
                if (!$moved) {
                    throw new \Exception('Gagal memindahkan file thumbnail');
                }
                $validated['thumbnail'] = "assets/thumbnails/{$userDir}/{$thumbFilename}";
            }

            $karya = KaryaSeni::create($validated);
            
            if (!$karya) {
                throw new \Exception('Gagal menyimpan data karya seni ke database');
            }

            return redirect()->route('seniman.dashboard')->with('success', 'Karya berhasil diajukan! Tunggu persetujuan admin.');
        } catch (\Exception $e) {
            Log::error('Karya Seni Upload Error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()->back()
                ->with('error', 'Gagal mengajukan karya: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Get karya detail via JSON
     */
    public function getKarya(KaryaSeni $karyaSeni)
    {
        // Check if user owns this karya
        if ($karyaSeni->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $karya = $karyaSeni->load(['user', 'kategori']);

        // Build response matching admin structure
        return response()->json([
            'id' => $karya->id,
            'judul' => $karya->judul,
            'deskripsi' => $karya->deskripsi,
            'media_type' => $karya->media_type,
            'media_path' => $karya->media_path,
            'thumbnail' => $karya->thumbnail ? asset($karya->thumbnail) : null,
            'status' => $karya->status,
            'alasan_penolakan' => $karya->alasan_penolakan,
            'views' => $karya->views,
            'likes' => $karya->likes,
            'created_at' => $karya->created_at,
            'user' => [
                'id' => $karya->user->id,
                'name' => $karya->user->name,
                'email' => $karya->user->email,
            ],
            'kategori' => [
                'id' => $karya->kategori->id,
                'nama' => $karya->kategori->nama,
            ],
        ]);
    }

    /**
     * Delete karya seni (only if pending)
     */
    public function deleteKarya(KaryaSeni $karyaSeni)
    {
        // Check if user owns this karya
        if ($karyaSeni->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        // Only allow delete if pending
        if ($karyaSeni->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya karya yang belum disetujui yang bisa dihapus');
        }

        // Delete media files if they exist (not URLs)
        if ($karyaSeni->media_path && !filter_var($karyaSeni->media_path, FILTER_VALIDATE_URL)) {
            $mediaFilePath = public_path($karyaSeni->media_path);
            if (file_exists($mediaFilePath)) {
                unlink($mediaFilePath);
            }
        }

        // Delete thumbnail if it exists
        if ($karyaSeni->thumbnail) {
            $thumbFilePath = public_path($karyaSeni->thumbnail);
            if (file_exists($thumbFilePath)) {
                unlink($thumbFilePath);
            }
        }

        $karyaSeni->delete();

        return redirect()->back()->with('success', 'Karya berhasil dihapus');
    }

    /**
     * Update profile (biografi, nama, dan foto)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        // Validation
        $validated = $request->validate([
            'nama' => 'nullable|string|max:255',
            'biografi' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|max:2048',
        ], [
            'nama.max' => 'Nama maksimal 255 karakter',
            'biografi.max' => 'Biografi maksimal 1000 karakter',
            'foto.image' => 'File harus berupa gambar',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Get or create seniman
        $seniman = $user->seniman ?? new \App\Models\Seniman(['user_id' => $user->id]);

        // Update nama
        if ($request->filled('nama')) {
            $seniman->nama = $validated['nama'];
        }

        // Update biografi
        if ($request->filled('biografi')) {
            $seniman->biografi = $validated['biografi'];
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto if exists
            if ($seniman->foto && file_exists(public_path($seniman->foto))) {
                unlink(public_path($seniman->foto));
            }

            // Create avatars folder if not exists
            $avatarsDir = 'assets/avatars';
            if (!is_dir(public_path($avatarsDir))) {
                mkdir(public_path($avatarsDir), 0755, true);
            }

            // Generate unique filename
            $timestamp = time();
            $random = substr(uniqid(), -8);
            $extension = strtolower($request->file('foto')->getClientOriginalExtension());
            $filename = "user-{$user->id}-{$timestamp}-{$random}.{$extension}";

            // Store file
            $request->file('foto')->move(public_path($avatarsDir), $filename);
            $seniman->foto = "$avatarsDir/$filename";
        }

        // Save seniman
        $seniman->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
}
