@extends('layouts.app')

@section('title', 'Beranda - Portal Karya Seniman Budaya Sumbawa')

@section('url-dummy', 'https://sumbawa-portal.local/gallery')

@section('extra-css')
    <style>
        /* Sidebar fixed di kiri */
        .kategori-sidebar {
            width: 200px;
            position: fixed;
            left: 0;
            top: 80px;
            height: auto;
            max-height: calc(100vh - 80px);
            background: white;
            border-right: 1px solid #ddd;
            overflow-y: auto;
            padding: 0;
            margin: 0;
            z-index: 100;
        }

        .kategori-sidebar-card {
            background: white;
            border: none;
            border-radius: 0;
            overflow: visible;
            box-shadow: none;
            margin: 0;
        }

        .kategori-sidebar-header {
            background: #1e88e5;
            color: white;
            padding: 1rem;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: none;
        }

        .kategori-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .kategori-item {
            border-bottom: 1px solid #f0f0f0;
        }

        .kategori-item:last-child {
            border-bottom: none;
        }

        .kategori-link {
            display: block;
            padding: 1rem;
            color: #333;
            text-decoration: none;
            transition: all 0.2s ease;
            font-weight: 500;
            font-size: 13px;
            background: white;
            border-left: none;
        }

        .kategori-link:hover {
            background: #f5f5f5;
            color: #1e88e5;
            border-left: none;
        }

        .kategori-link.active {
            background: #1e88e5;
            color: white;
            border-left: none;
        }

        /* HIDE KATEGORI SIDEBAR IN MOBILE - WILL BE IN MAIN SIDEBAR */
        @media (max-width: 991px) {
            .kategori-sidebar {
                display: none;
            }
        }
    </style>
@endsection

@section('content')
                    <!-- SIDEBAR KATEGORI -->
                    <aside class="kategori-sidebar">
                        <div class="kategori-sidebar-card">
                            <div class="kategori-sidebar-header">Kategori Seni</div>
                            <ul class="kategori-list">
                                @forelse ($kategoris as $kategori)
                                    <li class="kategori-item">
                                        <a href="/{{ $kategori->slug }}" class="kategori-link">
                                            {{ $kategori->nama }}
                                        </a>
                                    </li>
                                @empty
                                    <li style="padding: 1rem; color: #999; text-align: center;">
                                        Belum ada kategori
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </aside>

                <!-- SLIDER SECTION -->
                <section class="slider-section">
                    <div class="slider-container">
                        <div class="slider-wrapper">
                            <div class="slider" id="mainSlider">
                                @forelse ($sliders as $slider)
                                    <div class="slide @if ($loop->first) active @endif">
                                        <img src="{{ asset($slider->file_path) }}" alt="{{ $slider->description ?? $slider->original_name }}">
                                    </div>
                                @empty
                                    <div class="slide active" style="display: flex; align-items: center; justify-content: center; min-height: 400px; background: #f0f0f0;">
                                        <p style="color: #999; font-size: 18px;">Belum ada foto slider. Admin silakan upload foto di panel admin.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- SLIDER CONTROLS -->
                        <button class="slider-btn slider-btn-prev" id="sliderPrev">
                            <span class="arrow">&lsaquo;</span>
                        </button>
                        <button class="slider-btn slider-btn-next" id="sliderNext">
                            <span class="arrow">&rsaquo;</span>
                        </button>

                        <!-- SLIDER INDICATORS -->
                        <div class="slider-indicators" id="sliderIndicators">
                            @forelse ($sliders as $slider)
                                <span class="indicator @if ($loop->first) active @endif" data-slide="{{ $loop->index }}"></span>
                            @empty
                            @endforelse
                        </div>
                    </div>
                  
                </section>
                
@endsection
