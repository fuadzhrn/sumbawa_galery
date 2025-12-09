@extends('layouts.app')

@section('title', 'Profil Seniman - Portal Karya Seniman Budaya Sumbawa')

@section('content')
<div class="container my-5">
    @if($seniman)
    <div class="seniman-header mb-5">
        <h1>{{ $seniman->nama }}</h1>
    </div>

    <div class="row mb-5">
        <!-- Foto Seniman -->
        <div class="col-md-4 mb-4">
            @if($seniman->foto)
                <img src="{{ asset($seniman->foto) }}" alt="{{ $seniman->nama }}" class="img-fluid rounded">
            @else
                <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="{{ $seniman->nama }}" class="img-fluid rounded">
            @endif
        </div>

        <!-- Info Seniman -->
        <div class="col-md-8">
            @if($seniman->kategori)
                <span class="badge badge-primary mb-3">{{ $seniman->kategori->nama }}</span>
            @endif

            <h3>Tentang Seniman</h3>
            <p class="text-justify">
                {{ $seniman->biografi ?? 'Seniman berbakat dari Sumbawa yang berdedikasi dalam mengembangkan karya seni budaya lokal.' }}
            </p>
        </div>
    </div>

    <!-- Karya Seni -->
    <div class="karya-section mt-5">
        <h3 class="mb-4">Karya Seni</h3>

        @if($karyaSeni && count($karyaSeni) > 0)
        <div class="row">
            @foreach($karyaSeni as $karya)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-img-container" style="height: 250px; overflow: hidden;">
                        @if($karya->media_type === 'image' && $karya->thumbnail)
                            <img src="{{ asset($karya->thumbnail) }}" class="card-img-top" alt="{{ $karya->judul }}" style="object-fit: cover; height: 100%;">
                        @elseif($karya->media_type === 'image' && $karya->media_path)
                            <img src="{{ asset($karya->media_path) }}" class="card-img-top" alt="{{ $karya->judul }}" style="object-fit: cover; height: 100%;">
                        @else
                            <img src="{{ asset('assets/images/placeholder.jpg') }}" class="card-img-top" alt="{{ $karya->judul }}" style="object-fit: cover; height: 100%;">
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $karya->judul }}</h5>
                        @if($karya->kategori)
                            <p class="card-text text-muted small">{{ $karya->kategori->nama }}</p>
                        @endif
                        <div class="d-flex justify-content-between align-items-center">
                            <small><i class="fas fa-eye"></i> {{ $karya->views ?? 0 }}</small>
                            <a href="{{ route('karya.view', $karya) }}" class="btn btn-sm btn-primary">Lihat</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="alert alert-info">Belum ada karya yang disetujui dari seniman ini</div>
        @endif
    </div>

    @else
    <div class="alert alert-warning">Seniman tidak ditemukan</div>
    @endif
</div>
@endsection
