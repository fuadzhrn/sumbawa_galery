<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SambutanController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index']);

Route::get('/sambutan', [SambutanController::class, 'show'])->name('sambutan.show');

Route::get('/musik', function () {
    return view('musik');
});

Route::get('/rupa', function () {
    return view('rupa');
});

Route::get('/film', function () {
    return view('film');
});

Route::get('/biografi', function () {
    return view('biografi');
});

// API Routes (Public)
Route::get('/api/sliders', [SliderController::class, 'getActive'])->name('api.sliders');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.handle')->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show')->middleware('guest');
Route::post('/register', [AuthController::class, 'handleRegister'])->name('register.handle')->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
// Admin Dashboard
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/photo-slider', [SliderController::class, 'index'])->name('admin.photo-slider');
    Route::post('/admin/photo-slider', [SliderController::class, 'store'])->name('slider.store');
    Route::delete('/admin/photo-slider/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');
    Route::put('/admin/photo-slider/{id}/description', [SliderController::class, 'updateDescription'])->name('slider.updateDescription');
    Route::post('/admin/photo-slider/reorder', [SliderController::class, 'reorder'])->name('slider.reorder');

    Route::get('/admin/kata-sambutan', [SambutanController::class, 'edit'])->name('sambutan.edit');
    Route::post('/admin/kata-sambutan', [SambutanController::class, 'update'])->name('sambutan.update');

    Route::get('/admin/kategori', function () {
        return view('admin.kategori');
    })->name('admin.kategori');

    Route::get('/admin/seniman', function () {
        return view('admin.seniman');
    })->name('admin.seniman');

    Route::get('/admin/karya-seni', function () {
        return view('admin.karya-seni');
    })->name('admin.karya-seni');
});

// Seniman Dashboard
Route::middleware(['auth', 'seniman'])->group(function () {
    Route::get('/seniman/dashboard', function () {
        return view('seniman.dashboard');
    })->name('seniman.dashboard');
});
