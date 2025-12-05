<?php

namespace App\Http\Controllers;

use App\Models\KaryaSeni;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $totalViews = $user->karyaSeni()->sum('views') ?? 0;
        $totalLikes = $user->karyaSeni()->sum('likes') ?? 0;

        return view('seniman.dashboard', [
            'karyaSeni' => $karyaSeni,
            'kategoris' => $kategoris,
            'totalKarya' => $totalKarya,
            'totalViews' => $totalViews,
            'totalLikes' => $totalLikes,
        ]);
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

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        // Handle media file upload or URL
        if ($request->hasFile('media_file')) {
            $mediaFile = $request->file('media_file');
            $mediaDir = 'karya_seni/' . Auth::id();
            
            // Generate unique filename
            $timestamp = time();
            $random = substr(uniqid(), -8);
            $extension = strtolower($mediaFile->getClientOriginalExtension());
            $filename = "karya-{$timestamp}-{$random}.{$extension}";
            
            // Store file
            $mediaPath = $mediaFile->storeAs($mediaDir, $filename, 'public');
            $validated['media_path'] = 'storage/' . $mediaPath;
        } elseif ($request->filled('media_url')) {
            // Accept URL for any media type (image, video, youtube)
            $validated['media_path'] = $request->input('media_url');
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbDir = 'thumbnails/' . Auth::id();
            $thumbFilename = "thumb-" . time() . "-" . substr(uniqid(), -8) . ".jpg";
            $thumbnailPath = $thumbnail->storeAs($thumbDir, $thumbFilename, 'public');
            $validated['thumbnail'] = 'storage/' . $thumbnailPath;
        }

        KaryaSeni::create($validated);

        return redirect()->route('seniman.dashboard')->with('success', 'Karya berhasil diajukan! Tunggu persetujuan admin.');
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

        return response()->json($karyaSeni->load(['user', 'kategori']));
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

        $karyaSeni->delete();

        return redirect()->back()->with('success', 'Karya berhasil dihapus');
    }
}
