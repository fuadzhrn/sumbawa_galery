@extends('layouts.app')

@section('title', 'Profil Seniman - Portal Karya Seniman Budaya Sumbawa')

@section('extra-css')
<style>
    .seniman-profile-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .seniman-profile-header {
        display: flex;
        gap: 3rem;
        margin-bottom: 3rem;
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .seniman-profile-photo {
        flex: 0 0 300px;
    }

    .seniman-profile-photo img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .seniman-profile-info {
        flex: 1;
    }

    .seniman-profile-info h1 {
        font-size: 2rem;
        color: var(--primary-blue);
        margin-bottom: 0.5rem;
        font-weight: 700;
    }

    .seniman-profile-info .kategori-badge {
        display: inline-block;
        background-color: var(--primary-blue);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .seniman-profile-info h3 {
        font-size: 1.1rem;
        color: var(--text-dark);
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .seniman-profile-info p {
        color: var(--text-light);
        line-height: 1.8;
        text-align: justify;
        margin: 0;
    }

    .karya-section {
        margin-top: 3rem;
    }

    .karya-section h2 {
        font-size: 1.5rem;
        color: var(--primary-blue);
        margin-bottom: 2rem;
        font-weight: 700;
    }

    .karya-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
    }

    .karya-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .karya-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 16px rgba(30, 136, 229, 0.15);
    }

    .karya-card-image {
        width: 100%;
        height: 200px;
        overflow: hidden;
        position: relative;
    }

    .karya-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .karya-card:hover .karya-card-image img {
        transform: scale(1.05);
    }

    .karya-card-body {
        padding: 1.5rem;
    }

    .karya-card-title {
        font-size: 1.1rem;
        color: var(--primary-blue);
        margin-bottom: 0.5rem;
        font-weight: 600;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .karya-card-category {
        font-size: 0.85rem;
        color: var(--text-light);
        margin-bottom: 1rem;
        display: inline-block;
        background-color: #f0f0f0;
        padding: 0.25rem 0.75rem;
        border-radius: 4px;
    }

    .karya-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.5rem;
    }

    .karya-card-stats {
        font-size: 0.9rem;
        color: var(--text-light);
    }

    .karya-card-stats i {
        margin-right: 0.25rem;
    }

    .karya-card-button {
        padding: 0.5rem 1rem;
        background-color: var(--primary-blue);
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .karya-card-button:hover {
        background-color: var(--primary-blue-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 136, 229, 0.3);
        color: white;
        text-decoration: none;
    }

    .empty-state {
        background: white;
        padding: 3rem 2rem;
        border-radius: 8px;
        text-align: center;
        color: var(--text-light);
    }

    .empty-state i {
        font-size: 3rem;
        color: #ccc;
        margin-bottom: 1rem;
        display: block;
    }

    .not-found {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        text-align: center;
        color: var(--text-light);
    }

    @media (max-width: 768px) {
        .seniman-profile-header {
            flex-direction: column;
            gap: 1.5rem;
        }

        .seniman-profile-photo {
            flex: 0 0 auto;
        }

        .karya-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="seniman-profile-container">
    @if($seniman)
        <!-- Profile Header -->
        <div class="seniman-profile-header">
            <!-- Foto Seniman -->
            <div class="seniman-profile-photo">
                @if($seniman->foto)
                    <img src="{{ asset($seniman->foto) }}" alt="{{ $seniman->nama }}" loading="lazy">
                @else
                    <img src="{{ asset('assets/avatars/default-avatar.svg') }}" alt="{{ $seniman->nama }}" loading="lazy">
                @endif
            </div>

            <!-- Info Seniman -->
            <div class="seniman-profile-info">
                <h1>{{ $seniman->nama }}</h1>
                
                @if($seniman->kategori)
                    <span class="kategori-badge">{{ $seniman->kategori->nama }}</span>
                @endif

                <h3>Tentang Seniman</h3>
                <p>
                    {{ $seniman->biografi ?? 'Seniman berbakat dari Sumbawa yang berdedikasi dalam mengembangkan karya seni budaya lokal.' }}
                </p>
            </div>
        </div>

        <!-- Karya Seni Section -->
        <div class="karya-section">
            <h2>Karya Seni</h2>

            @if($karyaSeni && count($karyaSeni) > 0)
                <div class="karya-grid">
                    @foreach($karyaSeni as $karya)
                    <div class="karya-card">
                        <div class="karya-card-image">
                            @if($karya->thumbnail)
                                <img src="{{ asset($karya->thumbnail) }}" alt="{{ $karya->judul }}" loading="lazy">
                            @elseif($karya->media_path)
                                <img src="{{ asset($karya->media_path) }}" alt="{{ $karya->judul }}" loading="lazy">
                            @else
                                <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="{{ $karya->judul }}" loading="lazy">
                            @endif
                        </div>
                        <div class="karya-card-body">
                            <h3 class="karya-card-title">{{ $karya->judul }}</h3>
                            @if($karya->kategori)
                                <span class="karya-card-category">{{ $karya->kategori->nama }}</span>
                            @endif
                            <div class="karya-card-footer">
                                <div class="karya-card-stats">
                                    <i class="fas fa-eye"></i> {{ $karya->views ?? 0 }}
                                </div>
                                <a href="{{ route('karya.show', $karya->id) }}" class="karya-card-button">Lihat Karya</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-images"></i>
                    <p>Belum ada karya yang disetujui dari seniman ini</p>
                </div>
            @endif
        </div>
    @else
        <div class="not-found">
            <p><i class="fas fa-user-slash"></i> Seniman tidak ditemukan</p>
        </div>
    @endif
</div>
@endsection
