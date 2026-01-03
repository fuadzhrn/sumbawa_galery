@extends('layouts.app')

@section('title', $seniman->nama . ' - Biografi - Portal Karya Seniman Budaya Sumbawa')

@section('extra-css')
    <style>
        .biography-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
        }

        .biography-header {
            display: flex;
            gap: 3rem;
            margin-bottom: 3rem;
            align-items: flex-start;
        }

        .biography-foto {
            flex-shrink: 0;
        }

        .biography-foto img {
            width: 300px;
            height: 400px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            border: 4px solid #1e88e5;
        }

        .biography-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .biography-nama {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e88e5;
            margin-bottom: 0.5rem;
        }

        .biography-kategori {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 1.5rem;
        }

        .biography-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-box {
            background: linear-gradient(135deg, #1e88e5 0%, #42a5f5 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            display: block;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .biography-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #1e88e5, transparent);
            margin: 2rem 0;
        }

        .biography-content {
            margin-top: 2rem;
        }

        .biography-text-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e88e5;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .biography-text {
            font-size: 1rem;
            line-height: 1.8;
            color: #444;
            text-align: justify;
            background: #f9f9f9;
            padding: 2rem;
            border-radius: 8px;
            border-left: 4px solid #1e88e5;
        }

        .biography-empty {
            text-align: center;
            padding: 2rem;
            color: #999;
            font-style: italic;
        }

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

        /* Responsive */
        @media (max-width: 768px) {
            .biography-container {
                padding: 1rem;
            }

            .biography-header {
                flex-direction: column;
                gap: 1.5rem;
            }

            .biography-foto img {
                width: 100%;
                height: auto;
                max-width: 250px;
                margin: 0 auto;
                display: block;
            }

            .biography-nama {
                font-size: 1.8rem;
            }

            .biography-stats {
                grid-template-columns: 1fr;
            }

            .biography-text {
                text-align: left;
                padding: 1.5rem;
            }
        }
    </style>
@endsection

@section('content')
<div class="biography-container">
    <!-- Back Button -->
    <a href="javascript:history.back()" class="btn-back">
        <span>←</span> Kembali
    </a>

    <!-- Header Section -->
    <div class="biography-header">
        <!-- Foto -->
        <div class="biography-foto">
            <img src="{{ $seniman->foto ? asset($seniman->foto) : asset('assets/avatars/default-avatar.svg') }}" 
                 alt="{{ $seniman->nama }}" class="biography-image">
        </div>

        <!-- Info -->
        <div class="biography-info">
            <h1 class="biography-nama">{{ $seniman->nama }}</h1>
            <p class="biography-kategori">
                <strong>Kategori Seni:</strong> {{ $seniman->kategori->nama }}
            </p>

            <!-- Stats -->
            <div class="biography-stats">
                <div class="stat-box">
                    <span class="stat-number">{{ $seniman->jumlah_karya ?? 0 }}</span>
                    <span class="stat-label">Karya Dipublikasikan</span>
                </div>
                <div class="stat-box">
                    <span class="stat-number">{{ \Carbon\Carbon::parse($seniman->created_at)->format('Y') }}</span>
                    <span class="stat-label">Tahun Bergabung</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Divider -->
    <div class="biography-divider"></div>

    <!-- Biography Content -->
    <div class="biography-content">
        <h2 class="biography-text-title">Biografi</h2>
        
        @if($seniman->biografi)
            <div class="biography-text">
                {{ $seniman->biografi }}
            </div>
        @else
            <div class="biography-empty">
                <p>Belum ada biografi untuk seniman ini.</p>
            </div>
        @endif
    </div>
</div>
@endsection
