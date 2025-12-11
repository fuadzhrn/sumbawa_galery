<?php

namespace App\Http\Controllers;

use App\Models\KaryaSeni;
use App\Models\Seniman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KaryaSeniController extends Controller
{
    /**
     * Display a listing of karya seni (admin)
     */
    public function index()
    {
        $karyaSeni = KaryaSeni::with(['user', 'kategori'])->paginate(5);
        return view('admin.karya-seni', compact('karyaSeni'));
    }

    /**
     * Show karya seni detail
     */
    public function show(KaryaSeni $karyaSeni)
    {
        $karyaSeni->load(['user', 'kategori']);
        
        // Check if it's an API request (from AJAX)
        if (request()->expectsJson() || request()->wantsJson()) {
            return response()->json([
                'id' => $karyaSeni->id,
                'judul' => $karyaSeni->judul,
                'deskripsi' => $karyaSeni->deskripsi,
                'media_type' => $karyaSeni->media_type,
                'media_path' => asset($karyaSeni->media_path),
                'thumbnail' => $karyaSeni->thumbnail ? asset($karyaSeni->thumbnail) : null,
                'status' => $karyaSeni->status,
                'alasan_penolakan' => $karyaSeni->alasan_penolakan,
                'views' => $karyaSeni->views,
                'likes' => $karyaSeni->likes,
                'created_at' => $karyaSeni->created_at,
                'user' => [
                    'id' => $karyaSeni->user->id,
                    'name' => $karyaSeni->user->name,
                    'email' => $karyaSeni->user->email,
                ],
                'kategori' => [
                    'id' => $karyaSeni->kategori->id,
                    'nama' => $karyaSeni->kategori->nama,
                ],
            ]);
        }

        // Otherwise, display full page view (only if approved)
        if ($karyaSeni->status !== 'approved') {
            abort(404, 'Karya seni tidak ditemukan atau belum disetujui');
        }

        $karyaSeni->load(['user.seniman', 'kategori']);
        
        // Increment views
        $karyaSeni->increment('views');
        
        return view('karya-detail', compact('karyaSeni'));
    }

    /**
     * Approve karya seni
     */
    public function approve(KaryaSeni $karyaSeni)
    {
        $karyaSeni->update(['status' => 'approved']);

        // Auto-create or update Seniman
        $this->createOrUpdateSeniman($karyaSeni);

        return redirect()->route('admin.karya-seni')->with('success', 'Karya seni berhasil disetujui. Seniman ditambahkan ke daftar.');
    }

    /**
     * Reject karya seni
     */
    public function reject(Request $request, KaryaSeni $karyaSeni)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:500',
        ]);

        $karyaSeni->update([
            'status' => 'rejected',
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        return redirect()->route('admin.karya-seni')->with('success', 'Karya seni berhasil ditolak.');
    }

    /**
     * Create or update Seniman when karya is approved
     */
    private function createOrUpdateSeniman(KaryaSeni $karyaSeni)
    {
        $user = $karyaSeni->user;
        $kategori = $karyaSeni->kategori;

        // Check if seniman already exists
        $seniman = Seniman::where('user_id', $user->id)->first();

        if ($seniman) {
            // Update: increment jumlah_karya
            $seniman->increment('jumlah_karya');
        } else {
            // Create new seniman
            Seniman::create([
                'user_id' => $user->id,
                'kategori_id' => $kategori->id,
                'nama' => $user->name,
                'jumlah_karya' => 1,
            ]);
        }
    }
}
