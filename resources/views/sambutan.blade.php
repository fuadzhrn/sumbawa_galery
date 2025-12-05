@extends('layouts.app')

@section('title', 'Kata Sambutan - Portal Karya Seniman Budaya Sumbawa')

@section('url-dummy', 'https://sumbawa-portal.local/sambutan')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/sambutan.css') }}">
@endsection

@section('content')
<!-- HERO SECTION -->
<section class="sambutan-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1 class="hero-title">Kata Sambutan</h1>
            <p class="hero-subtitle">Portal Karya Seniman Budaya Sumbawa</p>
        </div>
        <div class="hero-image">
            <img src="{{ asset($sambutan->hero_image) }}" alt="Portal Karya Seniman">
        </div>
    </div>
</section>

<!-- MAIN CONTENT -->
<section class="sambutan-content">
    <!-- SALAM PEMBUKA -->
    <div class="content-section">
        <div class="section-header">
            <div class="header-line"></div>
            <h2 class="section-title">Salam Pembuka</h2>
        </div>
        <div class="section-body">
            <p class="greeting-text">
                <span class="greeting-arabic">Assalamu'alaikum Wr. Wb.</span>
            </p>
            <p class="main-text">
                Selamat datang dalam <strong>Portal Karya Seniman Budaya Sumbawa</strong>.
            </p>
            <p class="main-text">
                Kami dengan bangga mempersembahkan platform digital yang dirancang khusus untuk mendokumentasikan, melestarikan, dan menampilkan kekayaan warisan budaya Sumbawa kepada seluruh masyarakat.
            </p>
        </div>
    </div>

    <!-- TENTANG PORTAL -->
    <div class="content-section">
        <div class="section-header">
            <div class="header-line"></div>
            <h2 class="section-title">Tentang Portal Ini</h2>
        </div>
        <div class="section-body">
            <p class="main-text">
                Portal Karya Seniman Budaya Sumbawa merupakan hasil dari inisiatif pelestarian budaya lokal yang bertujuan untuk menciptakan arsip digital komprehensif mengenai kesenian tradisional dan kontemporer yang ada di Sumbawa.
            </p>
            <p class="main-text">
                Dengan memanfaatkan teknologi informasi terkini, portal ini menyediakan platform interaktif yang memungkinkan masyarakat untuk menjelajahi, mempelajari, dan menghargai karya-karya luar biasa dari para seniman Sumbawa.
            </p>
        </div>
    </div>

    <!-- VISI DAN MISI -->
    <div class="content-section">
        <div class="section-header">
            <div class="header-line"></div>
            <h2 class="section-title">Visi & Misi</h2>
        </div>
        <div class="visi-misi-grid">
            <div class="visi-misi-card">
                <div class="card-image">
                    <img src="{{ asset($sambutan->visi_image) }}" alt="Visi">
                </div>
                <div class="card-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </div>
                <h3 class="card-title">Visi</h3>
                <p class="card-text">{{ $sambutan->visi_text }}</p>
            </div>
            <div class="visi-misi-card">
                <div class="card-image">
                    <img src="{{ asset($sambutan->misi_image) }}" alt="Misi">
                </div>
                <div class="card-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                    </svg>
                </div>
                <h3 class="card-title">Misi</h3>
                <ul class="card-list">
                    @foreach(explode("\n", $sambutan->misi_text) as $item)
                        @if(trim($item))
                            <li>{{ trim(preg_replace('/^\d+\.\s*/', '', $item)) }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- TUJUAN PORTAL -->
    <div class="content-section">
        <div class="section-header">
            <div class="header-line"></div>
            <h2 class="section-title">Tujuan Portal</h2>
        </div>
        <div class="objectives-grid">
            <div class="objective-item">
                <div class="objective-image">
                    <img src="{{ asset($sambutan->obj1_image) }}" alt="{{ $sambutan->obj1_title }}">
                </div>
                <div class="objective-number">01</div>
                <h3>{{ $sambutan->obj1_title }}</h3>
                <p>{{ $sambutan->obj1_deskripsi }}</p>
            </div>
            <div class="objective-item">
                <div class="objective-image">
                    <img src="{{ asset($sambutan->obj2_image) }}" alt="{{ $sambutan->obj2_title }}">
                </div>
                <div class="objective-number">02</div>
                <h3>{{ $sambutan->obj2_title }}</h3>
                <p>{{ $sambutan->obj2_deskripsi }}</p>
            </div>
            <div class="objective-item">
                <div class="objective-image">
                    <img src="{{ asset($sambutan->obj3_image) }}" alt="{{ $sambutan->obj3_title }}">
                </div>
                <div class="objective-number">03</div>
                <h3>{{ $sambutan->obj3_title }}</h3>
                <p>{{ $sambutan->obj3_deskripsi }}</p>
            </div>
            <div class="objective-item">
                <div class="objective-image">
                    <img src="{{ asset($sambutan->obj4_image) }}" alt="{{ $sambutan->obj4_title }}">
                </div>
                <div class="objective-number">04</div>
                <h3>{{ $sambutan->obj4_title }}</h3>
                <p>{{ $sambutan->obj4_deskripsi }}</p>
            </div>
        </div>
    </div>

    <!-- KATEGORI SENI -->
    <div class="content-section">
        <div class="section-header">
            <div class="header-line"></div>
            <h2 class="section-title">Kategori Seni</h2>
        </div>
        <p class="intro-text">Portal ini menampilkan berbagai kategori seni tradisional dan kontemporer dari Sumbawa:</p>
        <div class="categories-grid">
            <div class="category-card">
                <div class="category-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm-5-9h10v2H7z"></path>
                    </svg>
                </div>
                <h3>Musik</h3>
                <p>Instrumen tradisional, komposisi, dan pertunjukan musik Sumbawa</p>
            </div>
            <div class="category-card">
                <div class="category-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                    </svg>
                </div>
                <h3>Rupa</h3>
                <p>Lukisan, patung, keramik, dan karya seni visual lainnya</p>
            </div>
            <div class="category-card">
                <div class="category-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 6h-1V5a1 1 0 00-2 0v1H8V5a1 1 0 00-2 0v1H5a3 3 0 00-3 3v12a3 3 0 003 3h14a3 3 0 003-3V9a3 3 0 00-3-3zm0 15H5a1 1 0 01-1-1v-8h16v8a1 1 0 01-1 1z"></path>
                    </svg>
                </div>
                <h3>Film</h3>
                <p>Produksi film, dokumenter, dan karya sinematik budaya</p>
            </div>
        </div>
    </div>

    <!-- UCAPAN TERIMA KASIH -->
    <div class="content-section gratitude-section">
        <div class="section-header">
            <div class="header-line"></div>
            <h2 class="section-title">Ucapan Terima Kasih</h2>
        </div>
        <div class="section-body">
            <p class="gratitude-intro">
                Kami mengucapkan terima kasih yang sebesar-besarnya kepada semua pihak yang telah memberikan dukungan, inspirasi, dan kontribusi dalam mewujudkan portal ini:
            </p>
            
            <div class="gratitude-list">
                <div class="gratitude-item">
                    <h4>Pemerintah Daerah Kabupaten Sumbawa</h4>
                    <p>Atas dukungan dan komitmen dalam pelestarian budaya lokal</p>
                </div>
                <div class="gratitude-item">
                    <h4>Para Seniman dan Budayawan Sumbawa</h4>
                    <p>Yang telah berdedikasi melestarikan dan mengembangkan warisan budaya kita</p>
                </div>
                <div class="gratitude-item">
                    <h4>Lembaga Adat dan Kebudayaan</h4>
                    <p>Atas peran penting dalam menjaga keaslian dan integritas budaya Sumbawa</p>
                </div>
                <div class="gratitude-item">
                    <h4>Masyarakat Sumbawa</h4>
                    <p>Atas partisipasi aktif dan dukungan moral dalam pengembangan portal ini</p>
                </div>
            </div>

            <p class="closing-text">
                Kritik dan saran konstruktif sangat kami harapkan untuk terus menyempurnakan portal ini. Semoga Portal Karya Seniman Budaya Sumbawa dapat menjadi jembatan yang menghubungkan generasi muda dengan kekayaan warisan budaya nenek moyang kita.
            </p>
        </div>
    </div>

    <!-- PENUTUP -->
    <div class="content-section">
        <div class="section-body closing-section">
            <p class="closing-greeting">
                <span class="greeting-arabic">Wassalamu'alaikum Wr. Wb.</span>
            </p>
            <p class="closing-date">
                Hormat kami,<br>
                <strong>Tim Portal Karya Seniman Budaya Sumbawa</strong>
            </p>
        </div>
    </div>
</section>

<style>
    .objective-image {
        width: 100%;
        height: 150px;
        margin-bottom: 15px;
        border-radius: 8px;
        overflow: hidden;
    }

    .objective-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-image {
        width: 100%;
        height: 200px;
        margin-bottom: 15px;
        border-radius: 8px;
        overflow: hidden;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

@endsection
