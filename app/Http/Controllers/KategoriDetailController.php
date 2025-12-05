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

        // Use category-specific views untuk kategori yang sudah ada
        $viewMap = [
            'musik' => 'musik',
            'rupa' => 'rupa',
            'film' => 'film',
        ];
        
        // Gunakan view spesifik jika ada, otherwise gunakan kategori-detail
        $viewName = $viewMap[$slug] ?? 'kategori-detail';
        
        // Jika view tidak ditemukan, gunakan view kategori-detail sebagai fallback
        // Pastikan view kategori-detail ada atau buat view yang generic
        if (!view()->exists($viewName)) {
            $viewName = 'kategori-detail';
        }
        
        return view($viewName, compact('kategori', 'karyaSeni'));
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
        ]);
    }
}
