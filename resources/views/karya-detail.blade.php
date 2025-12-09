@extends('layouts.app')

@section('title', 'Detail Karya - Portal Karya Seniman Budaya Sumbawa')

@section('content')
<div class="container my-5">
    @if($karyaSeni)
    <div class="row">
        <!-- Media Section -->
        <div class="col-lg-8 mb-4">
            <div class="karya-media-container">
                @if($karyaSeni->media_type === 'image')
                    <img src="{{ asset($karyaSeni->media_path) }}" alt="{{ $karyaSeni->judul }}" class="img-fluid rounded">
                @elseif($karyaSeni->media_type === 'video')
                    <video width="100%" controls class="rounded">
                        <source src="{{ asset($karyaSeni->media_path) }}" type="video/mp4">
                        Browser Anda tidak support video.
                    </video>
                @else
                    <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="{{ $karyaSeni->judul }}" class="img-fluid rounded">
                @endif
            </div>
        </div>

        <!-- Info Section -->
        <div class="col-lg-4">
            <div class="karya-info-box p-4 bg-light rounded">
                <h2>{{ $karyaSeni->judul }}</h2>
                <p class="text-muted">{{ $karyaSeni->deskripsi }}</p>
                
                @if($karyaSeni->kategori)
                <div class="mb-3">
                    <span class="badge badge-primary">{{ $karyaSeni->kategori->nama }}</span>
                </div>
                @endif

                <div class="karya-stats mb-3">
                    <div class="stat-item">
                        <i class="fas fa-eye"></i>
                        <span>{{ $karyaSeni->views ?? 0 }} views</span>
                    </div>
                </div>

                @if($karyaSeni->user && $karyaSeni->user->seniman)
                <div class="seniman-info p-3 bg-white rounded">
                    <h5>Oleh: {{ $karyaSeni->user->name }}</h5>
                    <a href="{{ route('seniman.show', $karyaSeni->user) }}" class="btn btn-sm btn-primary">
                        Lihat Profil Seniman
                    </a>
                </div>
                @endif

                <button class="btn btn-outline-secondary w-100 mt-3" onclick="history.back()">
                    <i class="fas fa-arrow-left"></i> Kembali
                </button>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-warning">Karya seni tidak ditemukan</div>
    @endif
</div>
@endsection
