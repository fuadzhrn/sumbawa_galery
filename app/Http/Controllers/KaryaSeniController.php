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
        $karyaSeni = KaryaSeni::with(['user', 'kategori'])->paginate(10);
        return view('admin.karya-seni', compact('karyaSeni'));
    }

    /**
     * Show karya seni detail
     */
    public function show(KaryaSeni $karyaSeni)
    {
        return response()->json($karyaSeni->load(['user', 'kategori']));
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
