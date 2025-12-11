<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\KaryaSeni;
use App\Models\Seniman;
use Illuminate\Http\Request;

class KategoriDetailController extends Controller
{
    /**
     * Display kategori detail page with approved karya seni
     */
    public function show($slug)
    {
        $kategori = Kategori::where('slug', $slug)->firstOrFail();
        
        // Get all approved karya seni for this kategori
        $karyaSeni = KaryaSeni::where('kategori_id', $kategori->id)
            ->where('status', 'approved')
            ->with(['user.seniman', 'kategori'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get all seniman who have at least one approved karya in this kategori
        $senimanList = Seniman::whereHas('user.karyaSeni', function ($query) use ($kategori) {
            $query->where('kategori_id', $kategori->id)
                ->where('status', 'approved');
        })
        ->with('user')
        ->orderBy('nama', 'asc')
        ->get();

        // Gunakan template dinamis untuk semua kategori
        return view('kategori-detail', compact('kategori', 'karyaSeni', 'senimanList'));
    }

    /**
     * Increment views for a karya seni
     */
    public function incrementViews(KaryaSeni $karyaSeni)
    {
        $karyaSeni->increment('views');
        return response()->json(['views' => $karyaSeni->views]);
    }

    /**
     * Get seniman profile with their approved karya
     */
    public function getSenimanProfile($senimanId)
    {
        try {
            $seniman = Seniman::with('user', 'kategori')->findOrFail($senimanId);
            
            // Get all approved karya seni for this seniman
            $karya = KaryaSeni::where('user_id', $seniman->user_id)
                ->where('status', 'approved')
                ->with(['kategori'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'judul' => $item->judul,
                        'kategori' => $item->kategori->nama,
                    ];
                });

            return response()->json([
                'nama' => $seniman->user->name,
                'foto' => $seniman->foto ? asset($seniman->foto) : asset('assets/images/placeholder.jpg'),
                'kategori' => $seniman->kategori->nama,
                'biografi' => $seniman->biografi ?? 'Deskripsi tidak tersedia',
                'karya' => $karya,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Seniman tidak ditemukan',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Get seniman's karya for specific kategori
     */
    public function getSenimanKaryaByKategori($userId, $kategoriSlug)
    {
        try {
            $kategori = Kategori::where('slug', $kategoriSlug)->firstOrFail();
            
            // Get approved karya seni for this user in this kategori
            $karya = KaryaSeni::where('user_id', $userId)
                ->where('kategori_id', $kategori->id)
                ->where('status', 'approved')
                ->with(['kategori'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'judul' => $item->judul,
                        'kategori' => $item->kategori->nama,
                    ];
                });

            return response()->json([
                'karya' => $karya,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Data tidak ditemukan',
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
