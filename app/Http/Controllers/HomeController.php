<?php

namespace App\Http\Controllers;

use App\Models\SliderImage;
use App\Models\Kategori;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     */
    public function index(): View
    {
        $sliders = SliderImage::where('is_active', true)
            ->orderBy('order')
            ->get();

        $kategoris = Kategori::orderBy('nama')->get();

        return view('index', compact('sliders', 'kategoris'));
    }
}
