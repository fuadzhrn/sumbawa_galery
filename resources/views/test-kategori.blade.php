@extends('layouts.app')

@section('title', 'Test Kategori - Portal Karya Seniman Budaya Sumbawa')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/kategori-detail.css') }}?v={{ time() }}">
@endsection

@section('content')
<div style="background: red; padding: 20px; color: white; text-align: center;">
    <h1>CONTENT TEST - This should be inside main.content-area</h1>
    <p>If you see this in red box inside the content area, then Blade is working correctly.</p>
</div>

<div class="page-header">
    <h2 class="page-title">Tes Kategori</h2>
    <p class="page-subtitle">Ini adalah halaman test untuk kategori</p>
</div>

<section class="kategori-section">
    <div class="kategori-grid">
        @forelse($karyaSeni as $karya)
        <div class="kategori-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img1.png') }}" alt="{{ $karya->judul }}" class="card-img">
                <div class="views-overlay">
                    <svg class="views-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    <span class="views-text">{{ $karya->views ?? 0 }}</span>
                </div>
            </div>
            <div class="card-content">
                <h3 class="card-title">{{ $karya->judul }}</h3>
                <p class="card-artist">{{ $karya->user->name }}</p>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #999;">
            <p style="font-size: 16px;">Belum ada karya</p>
        </div>
        @endforelse
    </div>
</section>
@endsection
