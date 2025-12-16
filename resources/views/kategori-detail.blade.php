@extends('layouts.app')

@section('title', $kategori->nama . ' - Portal Karya Seniman Budaya Sumbawa')

@section('url-dummy', 'https://sumbawa-portal.local/' . $kategori->slug)

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/kategori-detail.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="page-header">
    <h2 class="page-title">Seniman {{ $kategori->nama }}</h2>
    <p class="page-subtitle">Jelajahi karya-karya {{ strtolower($kategori->nama) }} dari seniman budaya Sumbawa</p>
</div>

<section class="kategori-section">
    <div class="kategori-grid">
        @forelse($karyaSeni as $karya)
        <div class="kategori-card">
            <div class="card-image">
                @if($karya->media_type === 'image' && $karya->thumbnail)
                    <img src="{{ asset($karya->thumbnail) }}" alt="{{ $karya->judul }}" class="card-img">
                @elseif($karya->media_type === 'image' && $karya->media_path)
                    <img src="{{ asset($karya->media_path) }}" alt="{{ $karya->judul }}" class="card-img">
                @else
                    <img src="{{ asset('assets/images/img1.png') }}" alt="{{ $karya->judul }}" class="card-img">
                @endif
                <div class="views-overlay">
                    <svg class="views-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    <span class="views-text">{{ $karya->views ?? 0 }}</span>
                </div>
            </div>
            <div class="card-content">
                <h3 class="card-title">{{ $karya->judul }}</h3>
                <p class="card-artist">{{ $karya->user->name }}</p>
                @if($karya->user->seniman)
                    <a href="{{ route('seniman.show', $karya->user->seniman->id) }}" class="btn-biografi">
                        Biografi
                    </a>
                @else
                    <button class="btn-biografi" disabled style="opacity: 0.5; cursor: not-allowed;">
                        Biografi
                    </button>
                @endif
            </div>
                </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #999;">
            <p style="font-size: 16px;">Belum ada karya {{ strtolower($kategori->nama) }}</p>
        </div>
        @endforelse
    </div>
</section>

@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Increment views when page loads
    const karyaSeniIds = document.querySelectorAll('[data-karya-id-increment]');
    karyaSeniIds.forEach(element => {
        const karyaId = element.getAttribute('data-karya-id-increment');
        if (karyaId) {
            fetch(`/karya-seni/${karyaId}/increment-views`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .catch(error => console.error('Error incrementing views:', error));
        }
    });
});
</script>
@endsection
