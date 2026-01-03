<?php

namespace App\Http\Controllers;

use App\Models\Seniman;
use App\Models\KaryaSeni;
use Illuminate\Http\Request;

class SenimanDetailController extends Controller
{
    /**
     * Display seniman detail page with their approved karya seni
     */
    public function show(Seniman $seniman)
    {
        // Get all approved karya seni from this seniman
        $karyaSeni = $seniman->user->karyaSeni()
            ->where('status', 'approved')
            ->with(['kategori'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('seniman-detail', compact('seniman', 'karyaSeni'));
    }

    /**
     * Display seniman biography page
     */
    public function biography(Seniman $seniman)
    {
        return view('seniman-biography', compact('seniman'));
    }

    /**
     * Display karya dengan biography seniman
     */
    public function biographyWithKarya(KaryaSeni $karyaSeni)
    {
        $seniman = $karyaSeni->user->seniman;
        return view('karya-biography', compact('karyaSeni', 'seniman'));
    }
}
