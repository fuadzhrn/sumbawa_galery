<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\KaryaSeni;
use App\Models\SliderImage;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalSeniman = User::where('role', 'seniman')->count();
        $totalSenimanAktif = User::where('role', 'seniman')->where('is_active', 1)->count();
        $totalKarya = KaryaSeni::where('status', 'approved')->count();
        $totalSlider = SliderImage::count();

        return view('admin.dashboard', compact('totalSeniman', 'totalSenimanAktif', 'totalKarya', 'totalSlider'));
    }
}
