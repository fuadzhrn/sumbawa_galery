@extends('layouts.app')

@section('title', $karyaSeni->judul . ' - Biografi - Portal Karya Seniman Budaya Sumbawa')

@section('extra-css')
    <style>
        .karya-biography-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Back Button */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background-color: #1e88e5;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            margin-bottom: 2rem;
        }

        .btn-back:hover {
            background-color: #1565c0;
            transform: translateX(-2px);
            color: white;
            text-decoration: none;
        }

        /* Main Content Grid */
        .karya-biography-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: start;
        }

        /* Karya Section */
        .karya-section {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .karya-image-wrapper {
            background-color: #f5f5f5;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            aspect-ratio: 3 / 4;
            width: 100%;
        }

        .karya-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .karya-image-wrapper video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .karya-image-wrapper iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .karya-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e88e5;
        }

        .karya-kategori {
            color: #666;
            font-size: 0.95rem;
        }

        /* Biography Section */
        .seniman-biography-section {
            background: white;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 2rem;
        }

        .seniman-header {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #1e88e5;
        }

        .seniman-nama {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e88e5;
            margin-bottom: 0.5rem;
        }

        .seniman-info {
            display: flex;
            gap: 1.5rem;
            font-size: 0.95rem;
            color: #666;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-weight: 600;
            color: #333;
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
        }

        .info-value {
            color: #555;
        }

        .biography-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e88e5;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .biography-text {
            font-size: 0.95rem;
            line-height: 1.8;
            color: #555;
            text-align: justify;
        }

        .biography-empty {
            text-align: center;
            padding: 2rem;
            color: #999;
            font-style: italic;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .karya-biography-container {
                padding: 1rem;
            }

            .karya-biography-content {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .karya-image-wrapper {
                aspect-ratio: 3 / 4;
            }

            .seniman-info {
                flex-direction: column;
                gap: 0.75rem;
            }

            .seniman-nama {
                font-size: 1.5rem;
            }

            .karya-title {
                font-size: 1.2rem;
            }
        }
    </style>
@endsection

@section('content')
<div class="karya-biography-container">
    <!-- Main Content -->
    <div class="karya-biography-content">
        <!-- Karya Section (Left) -->
        <div class="karya-section">
            <!-- Gambar Karya -->
            <div class="karya-image-wrapper">
                @if($karyaSeni->media_type === 'image')
                    @if($karyaSeni->thumbnail)
                        <img src="{{ asset($karyaSeni->thumbnail) }}" alt="{{ $karyaSeni->judul }}">
                    @else
                        <img src="{{ asset($karyaSeni->media_path) }}" alt="{{ $karyaSeni->judul }}">
                    @endif
                @elseif($karyaSeni->media_type === 'video')
                    <video controls>
                        <source src="{{ asset($karyaSeni->media_path) }}" type="video/mp4">
                        Browser Anda tidak mendukung video HTML5
                    </video>
                @elseif($karyaSeni->media_type === 'youtube')
                    <iframe src="https://www.youtube.com/embed/{{ $karyaSeni->media_path }}" allowfullscreen></iframe>
                @else
                    <img src="{{ asset('assets/images/img1.png') }}" alt="{{ $karyaSeni->judul }}">
                @endif
            </div>

            <!-- Judul dan Kategori Karya -->
            <div>
                <h2 class="karya-title">{{ $karyaSeni->judul }}</h2>
                <p class="karya-kategori">
                    <strong>Kategori:</strong> {{ $karyaSeni->kategori->nama }}
                </p>
            </div>
        </div>

        <!-- Biography Section (Right) -->
        <div class="seniman-biography-section">
            <!-- Seniman Header -->
            <div class="seniman-header">
                <h1 class="seniman-nama">{{ $seniman->nama }}</h1>
                <div class="seniman-info">
                    <div class="info-item">
                        <span class="info-label">Kategori Seni</span>
                        <span class="info-value">{{ $seniman->kategori->nama }}</span>
                    </div>
                </div>
            </div>

            <!-- Biography -->
            <h3 class="biography-title">Deskripsi Karya</h3>
            @if($karyaSeni->deskripsi)
                <div class="biography-text">
                    {{ $karyaSeni->deskripsi }}
                </div>
            @else
                <div class="biography-empty">
                    <p>Belum ada deskripsi untuk karya ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
