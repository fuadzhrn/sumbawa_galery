@extends('layouts.app')

@section('title', 'Profil Seniman - Portal Karya Seniman Budaya Sumbawa')

@section('extra-css')
<style>
    .seniman-profile-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .seniman-profile-header {
        display: flex;
        gap: 2rem;
        margin-bottom: 2.5rem;
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .seniman-profile-photo {
        flex: 0 0 220px;
    }

    .seniman-profile-photo img {
        width: 100%;
        height: 220px;
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

    /* KARYA GRID SECTION */
    .karya-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 3.5rem;
        margin-bottom: 3rem;
        width: 100%;
        padding: 0 1rem;
    }

    .kategori-card {
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .kategori-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 24px rgba(30, 136, 229, 0.2);
    }

    .card-image {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
        background-color: #f5f5f5;
    }

    .card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .kategori-card:hover .card-img {
        transform: scale(1.05);
    }

    .views-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .kategori-card:hover .views-overlay {
        opacity: 1;
    }

    .views-icon {
        color: white;
        width: 20px;
        height: 20px;
    }

    .views-text {
        color: white;
        font-size: 1rem;
        font-weight: 600;
    }

    .card-content {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        flex: 1;
    }

    .card-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--primary-blue);
        margin: 0;
        line-height: 1.3;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .btn-card {
        background-color: var(--primary-blue);
        color: white;
        border: none;
        padding: 0.65rem 1.2rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        margin-top: auto;
    }

    .btn-card:hover {
        background-color: #1565c0;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(30, 136, 229, 0.3);
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
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.25rem;
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
        height: 130px;
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
        padding: 0.75rem;
    }

    .karya-card-title {
        font-size: 0.95rem;
        color: var(--primary-blue);
        margin-bottom: 0.3rem;
        font-weight: 600;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .karya-card-category {
        font-size: 0.75rem;
        color: var(--text-light);
        margin-bottom: 0.5rem;
        display: inline-block;
        background-color: #f0f0f0;
        padding: 0.15rem 0.5rem;
        border-radius: 3px;
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

    /* Karya List Styles */
    .karya-list {
        background: transparent;
        border-radius: 0;
        padding: 1.5rem 0 0 0;
        box-shadow: none;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 2px solid #f0f0f0;
    }

    .karya-list-title {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .karya-list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.6rem 0;
        border-bottom: none;
    }

    .karya-list-item:last-child {
        border-bottom: none;
    }

    .karya-list-item-number {
        flex: 0 0 30px;
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.9rem;
    }

    .karya-list-item-title {
        flex: 1;
        font-weight: 500;
        color: var(--text-dark);
        margin-left: 0.5rem;
        font-size: 0.9rem;
    }

    .karya-list-item-actions {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-left: auto;
    }

    .karya-link-button {
        display: inline-flex;
        align-items: center;
        gap: 0.2rem;
        padding: 0.3rem 0.6rem;
        background-color: #f0f0f0;
        color: var(--primary-blue);
        text-decoration: none;
        border-radius: 3px;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
        white-space: nowrap;
    }

    .karya-link-button:hover {
        background-color: var(--primary-blue);
        color: white;
        text-decoration: none;
    }

    .karya-view-button {
        padding: 0.3rem 0.6rem;
        background-color: var(--primary-blue);
        color: white;
        text-decoration: none;
        border-radius: 3px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        white-space: nowrap;
    }

    .karya-view-button:hover {
        background-color: #1565c0;
        text-decoration: none;
        color: white;
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

    @media (max-width: 1200px) {
        .karya-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            padding: 0;
        }
    }

    @media (max-width: 1024px) {
        .karya-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
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
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .card-image {
            height: 200px;
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

        <!-- Karya Seni Section - TERPISAH DI BAWAH -->
        @if($karyaSeni && count($karyaSeni) > 0)
        <div style="margin-top: 3rem;">
            <h2 style="font-size: 1.5rem; color: var(--primary-blue); margin-bottom: 2rem; font-weight: 700;">Karya Seni</h2>
            <div class="karya-grid">
                @foreach($karyaSeni as $karya)
                <div class="kategori-card">
                    <div class="card-image">
                        @if($karya->media_type === 'image' && $karya->thumbnail)
                            <img src="{{ asset($karya->thumbnail) }}" alt="{{ $karya->judul }}" class="card-img">
                        @elseif($karya->media_type === 'image' && $karya->media_path)
                            <img src="{{ asset($karya->media_path) }}" alt="{{ $karya->judul }}" class="card-img">
                        @elseif($karya->media_type === 'youtube_link')
                            <img src="https://img.youtube.com/vi/{{ str_contains($karya->media_path, 'v=') ? explode('v=', $karya->media_path)[1] : $karya->media_path }}/maxresdefault.jpg" alt="{{ $karya->judul }}" class="card-img">
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
                        <a href="{{ route('karya.biography', $karya->id) }}" class="btn-card">Lihat Karya</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @else
        <div class="not-found">
            <p><i class="fas fa-user-slash"></i> Seniman tidak ditemukan</p>
        </div>
    @endif
</div>
@endsection
