@extends('layouts.app')

@section('title', 'Beranda - Portal Karya Seniman Budaya Sumbawa')

@section('url-dummy', 'https://sumbawa-portal.local/gallery')

@section('content')
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

                <!-- GALLERY SECTION -->
                <section class="gallery-section">
                    <h2 class="section-title">Galeri Karya Terbaru</h2>
                    <div class="gallery-grid">
                        <div class="gallery-item">
                            <img src="{{ asset('assets/images/img1.png') }}" alt="Karya 1">
                            <div class="gallery-info">
                                <h3>Karya Seni 1</h3>
                                <p>Rupa Kontemporer - 2024</p>
                            </div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('assets/images/img2.png') }}" alt="Karya 2">
                            <div class="gallery-info">
                                <h3>Karya Seni 2</h3>
                                <p>Musik Visual - 2024</p>
                            </div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('assets/images/img3.png') }}" alt="Karya 3">
                            <div class="gallery-info">
                                <h3>Karya Seni 3</h3>
                                <p>Film Pendek - 2024</p>
                            </div>
                        </div>
                    </div>
                </section>
@endsection
