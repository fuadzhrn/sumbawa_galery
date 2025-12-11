@extends('layouts.app')

@section('title', $karyaSeni->judul . ' - Portal Karya Seniman Budaya Sumbawa')

@section('extra-css')
    <style>
        .karya-detail-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .karya-detail-header {
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #eee;
        }

        .karya-detail-title {
            font-size: 2rem;
            color: #1e88e5;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .karya-detail-meta {
            display: flex;
            gap: 2rem;
            color: #666;
            font-size: 0.95rem;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .meta-label {
            font-weight: 600;
            color: #333;
        }

        .karya-detail-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .karya-media {
            background-color: #f5f5f5;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 500px;
        }

        .karya-media img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .karya-media video {
            width: 100%;
            height: 100%;
            max-height: 600px;
        }

        .karya-media iframe {
            width: 100%;
            height: 500px;
            border: none;
        }

        .karya-sidebar {
            background-color: #fff;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 1.5rem;
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .sidebar-card {
            margin-bottom: 2rem;
        }

        .sidebar-card:last-child {
            margin-bottom: 0;
        }

        .sidebar-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: #1e88e5;
            text-transform: uppercase;
            margin-bottom: 1rem;
            letter-spacing: 0.5px;
        }

        .seniman-card {
            text-align: center;
        }

        .seniman-foto {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 1rem;
            border: 3px solid #1e88e5;
        }

        .seniman-nama {
            font-size: 1.1rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .seniman-kategori {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1rem;
        }

        .btn-back {
            display: inline-block;
            background-color: #1e88e5;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-top: 1rem;
            border: none;
            cursor: pointer;
        }

        .btn-back:hover {
            background-color: #1565c0;
            transform: translateY(-2px);
            color: #fff;
            text-decoration: none;
        }

        .karya-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background-color: #f9f9f9;
            border-radius: 6px;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e88e5;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #666;
            margin-top: 0.5rem;
        }

        .karya-deskripsi {
            background-color: #f9f9f9;
            padding: 1.5rem;
            border-radius: 8px;
            line-height: 1.8;
            color: #555;
            margin-top: 2rem;
        }

        .karya-deskripsi-title {
            font-size: 1rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .karya-detail-content {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .karya-sidebar {
                position: static;
            }

            .karya-detail-title {
                font-size: 1.5rem;
            }

            .karya-media {
                min-height: 300px;
            }

            .karya-media iframe {
                height: 300px;
            }
        }
    </style>
@endsection

@section('content')
<div class="karya-detail-container">
    <!-- HEADER -->
    <div class="karya-detail-header">
        <h1 class="karya-detail-title">{{ $karyaSeni->judul }}</h1>
        <div class="karya-detail-meta">
            <div class="meta-item">
                <span class="meta-label">Kategori:</span>
                <span><a href="/{{ $karyaSeni->kategori->slug }}" style="color: #1e88e5; text-decoration: none;">{{ $karyaSeni->kategori->nama }}</a></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Seniman:</span>
                <span>{{ $karyaSeni->user->name }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Tanggal Upload:</span>
                <span>{{ $karyaSeni->created_at->format('d M Y') }}</span>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="karya-detail-content">
        <!-- MEDIA -->
        <div>
            <div class="karya-media">
                @if($karyaSeni->media_type === 'image')
                    <img src="{{ asset($karyaSeni->media_path) }}" alt="{{ $karyaSeni->judul }}">
                @elseif($karyaSeni->media_type === 'video')
                    <video controls>
                        <source src="{{ asset($karyaSeni->media_path) }}" type="video/mp4">
                        Browser Anda tidak mendukung video HTML5
                    </video>
                @elseif($karyaSeni->media_type === 'youtube')
                    <iframe src="https://www.youtube.com/embed/{{ $karyaSeni->media_path }}" allowfullscreen></iframe>
                @endif
            </div>

            <!-- DESKRIPSI -->
            <div class="karya-deskripsi">
                <div class="karya-deskripsi-title">Deskripsi Karya</div>
                <p>{{ $karyaSeni->deskripsi }}</p>
            </div>
        </div>

        <!-- SIDEBAR -->
        <div class="karya-sidebar">
            <!-- SENIMAN CARD -->
            <div class="sidebar-card">
                <div class="sidebar-title">Seniman</div>
                <div class="seniman-card">
                    <img src="{{ $karyaSeni->user->seniman?->foto ? asset($karyaSeni->user->seniman->foto) : asset('assets/avatars/default-avatar.svg') }}" 
                         alt="{{ $karyaSeni->user->name }}" class="seniman-foto">
                    <div class="seniman-nama">{{ $karyaSeni->user->name }}</div>
                    <div class="seniman-kategori">{{ $karyaSeni->kategori->nama }}</div>
                </div>
            </div>

            <!-- STATS -->
            <div class="sidebar-card">
                <div class="sidebar-title">Statistik</div>
                <div class="karya-stats">
                    <div class="stat-item">
                        <div class="stat-number">{{ $karyaSeni->views ?? 0 }}</div>
                        <div class="stat-label">Penayangan</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $karyaSeni->likes ?? 0 }}</div>
                        <div class="stat-label">Suka</div>
                    </div>
                </div>
            </div>

            <!-- KEMBALI -->
            <div class="sidebar-card">
                <button onclick="history.back()" class="btn-back" style="width: 100%; text-align: center;">← Kembali</button>
            </div>
        </div>
    </div>
</div>
@endsection
