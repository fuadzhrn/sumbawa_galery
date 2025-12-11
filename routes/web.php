<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SambutanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KategoriDetailController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SenimanController;
use App\Http\Controllers\SenimanDetailController;
use App\Http\Controllers\KaryaSeniController;
use App\Http\Controllers\SenimanDashboardController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index']);

Route::get('/sambutan', [SambutanController::class, 'show'])->name('sambutan.show');

// Authentication Routes (MUST BE BEFORE CATCH-ALL ROUTES)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.handle')->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show')->middleware('guest');
Route::post('/register', [AuthController::class, 'handleRegister'])->name('register.handle')->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// API Routes (Public)
Route::get('/api/sliders', [SliderController::class, 'getActive'])->name('api.sliders');
Route::post('/karya-seni/{karyaSeni}/increment-views', [KategoriDetailController::class, 'incrementViews'])->name('karya-seni.increment-views');
Route::get('/api/seniman/{senimanId}/profile', [KategoriDetailController::class, 'getSenimanProfile'])->name('api.seniman.profile');
Route::get('/api/seniman/{userId}/karya/{kategoriSlug}', [KategoriDetailController::class, 'getSenimanKaryaByKategori'])->name('api.seniman.karya.kategori');

// Test route for kategori-detail debugging
Route::get('/test-kategori', function () {
    $kategori = \App\Models\Kategori::where('slug', 'tari-tradisional')->firstOrFail();
    $karyaSeni = \App\Models\KaryaSeni::where('kategori_id', $kategori->id)
        ->where('status', 'approved')
        ->with(['user.seniman', 'kategori'])
        ->get();
    
    return view('test-kategori', compact('kategori', 'karyaSeni'));
})->name('test.kategori');

Route::get('/musik', [KategoriDetailController::class, 'show'])->defaults('slug', 'musik');

Route::get('/rupa', [KategoriDetailController::class, 'show'])->defaults('slug', 'rupa');

Route::get('/film', [KategoriDetailController::class, 'show'])->defaults('slug', 'film');

// Protected Routes
// Admin Dashboard
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/photo-slider', [SliderController::class, 'index'])->name('admin.photo-slider');
    Route::post('/admin/photo-slider', [SliderController::class, 'store'])->name('slider.store');
    Route::delete('/admin/photo-slider/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');
    Route::put('/admin/photo-slider/{id}/description', [SliderController::class, 'updateDescription'])->name('slider.updateDescription');
    Route::post('/admin/photo-slider/reorder', [SliderController::class, 'reorder'])->name('slider.reorder');

    Route::get('/admin/kata-sambutan', [SambutanController::class, 'edit'])->name('sambutan.edit');
    Route::post('/admin/kata-sambutan', [SambutanController::class, 'update'])->name('sambutan.update');

    // Kategori Routes
    Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('admin.kategori');
    Route::post('/admin/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/admin/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/admin/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Seniman Routes
    Route::get('/admin/seniman', [SenimanController::class, 'index'])->name('admin.seniman');
    Route::get('/admin/seniman/{seniman}', [SenimanController::class, 'show'])->name('admin.seniman.show');
    Route::delete('/admin/seniman/{seniman}', [SenimanController::class, 'destroy'])->name('admin.seniman.destroy');

    // Karya Seni Routes
    Route::get('/admin/karya-seni', [KaryaSeniController::class, 'index'])->name('admin.karya-seni');
    Route::get('/admin/karya-seni/{karyaSeni}', [KaryaSeniController::class, 'show'])->name('admin.karya-seni.show');
    Route::post('/admin/karya-seni/{karyaSeni}/approve', [KaryaSeniController::class, 'approve'])->name('admin.karya-seni.approve');
    Route::post('/admin/karya-seni/{karyaSeni}/reject', [KaryaSeniController::class, 'reject'])->name('admin.karya-seni.reject');
});

// Seniman Dashboard
Route::middleware(['auth', 'seniman'])->group(function () {
    Route::get('/seniman/dashboard', [SenimanDashboardController::class, 'index'])->name('seniman.dashboard');
    Route::get('/seniman/karya', [SenimanDashboardController::class, 'karya'])->name('seniman.karya');
    Route::get('/seniman/upload', [SenimanDashboardController::class, 'upload'])->name('seniman.upload');
    Route::get('/seniman/status', [SenimanDashboardController::class, 'status'])->name('seniman.status');
    Route::get('/seniman/accepted', [SenimanDashboardController::class, 'accepted'])->name('seniman.accepted');
    Route::get('/seniman/profile', [SenimanDashboardController::class, 'profile'])->name('seniman.profile');
    Route::put('/seniman/profile', [SenimanDashboardController::class, 'updateProfile'])->name('seniman.profile.update');
    Route::get('/seniman/settings', [SenimanDashboardController::class, 'settings'])->name('seniman.settings');
    Route::post('/seniman/karya', [SenimanDashboardController::class, 'store'])->name('seniman.karya.store');
    Route::get('/seniman/karya/{karyaSeni}', [SenimanDashboardController::class, 'getKarya'])->name('seniman.karya.get');
    Route::delete('/seniman/karya/{karyaSeni}', [SenimanDashboardController::class, 'deleteKarya'])->name('seniman.karya.delete');
});

// Dynamic Kategori Routes (MUST BE LAST - catches all remaining slugs)
Route::get('/karya/{karyaSeni}', [KaryaSeniController::class, 'show'])->name('karya.show');
Route::get('/seniman/{seniman}', [SenimanDetailController::class, 'show'])->name('seniman.show');
Route::get('/{slug}', [KategoriDetailController::class, 'show'])->name('kategori.show');
