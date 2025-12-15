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
    <!-- SAMBUTAN UTAMA -->
    <div class="content-section">
        <div class="section-header">
            <div class="header-line"></div>
            <h2 class="section-title">Kata Sambutan</h2>
        </div>
        <div class="section-body">
            <!-- GREETING -->
            <p class="greeting-text">
                <span class="greeting-arabic">Assalamu'alaikum Wr. Wb.</span>
            </p>
            <p class="main-text">
                Selamat datang dalam <strong>Portal Karya Seniman Budaya Sumbawa</strong>.
            </p>
            <p class="main-text">
                Kami dengan bangga mempersembahkan platform digital yang dirancang khusus untuk mendokumentasikan, melestarikan, dan menampilkan kekayaan warisan budaya Sumbawa kepada seluruh masyarakat.
            </p>
            <p class="main-text">
                Portal Karya Seniman Budaya Sumbawa merupakan hasil dari inisiatif pelestarian budaya lokal yang bertujuan untuk menciptakan arsip digital komprehensif mengenai kesenian tradisional dan kontemporer yang ada di Sumbawa.
            </p>
            <p class="main-text">
                Dengan memanfaatkan teknologi informasi terkini, portal ini menyediakan platform interaktif yang memungkinkan masyarakat untuk menjelajahi, mempelajari, dan menghargai karya-karya luar biasa dari para seniman Sumbawa.
            </p>

            <!-- VISI & MISI -->
            <div style="margin-top: 2rem;">
                <h3 style="font-size: 1.2rem; color: var(--primary-blue); font-weight: 700; margin-bottom: 1rem;">Visi & Misi</h3>
                <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
                    <div>
                        <h4 style="font-size: 1rem; color: var(--primary-blue); font-weight: 700; margin: 0 0 0.75rem 0;">Visi</h4>
                        <p style="font-size: 0.95rem; line-height: 1.6; color: var(--text-dark); margin: 0;">{{ $sambutan->visi_text }}</p>
                    </div>
                    <div>
                        <h4 style="font-size: 1rem; color: var(--primary-blue); font-weight: 700; margin: 0 0 0.75rem 0;">Misi</h4>
                        <ul style="font-size: 0.95rem; line-height: 1.6; color: var(--text-dark); margin: 0; padding-left: 1.5rem;">
                            @foreach(explode("\n", $sambutan->misi_text) as $item)
                                @if(trim($item))
                                    <li style="margin-bottom: 0.75rem;">{{ trim(preg_replace('/^\d+\.\s*/', '', $item)) }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- TUJUAN PORTAL -->
            <div style="margin-top: 2rem;">
                <h3 style="font-size: 1.2rem; color: var(--primary-blue); font-weight: 700; margin-bottom: 1rem;">Tujuan Portal</h3>
                <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
                    <div>
                        
                        <h4 style="font-size: 1.1rem; color: var(--primary-blue); font-weight: 700; margin: 0 0 0.75rem 0;">{{ $sambutan->obj1_title }}</h4>
                        <p style="font-size: 0.9rem; line-height: 1.5; color: var(--text-dark); margin: 0;">{{ $sambutan->obj1_deskripsi }}</p>
                    </div>
                    <div>
                        <h4 style="font-size: 1.1rem; color: var(--primary-blue); font-weight: 700; margin: 0 0 0.75rem 0;">{{ $sambutan->obj2_title }}</h4>
                        <p style="font-size: 0.9rem; line-height: 1.5; color: var(--text-dark); margin: 0;">{{ $sambutan->obj2_deskripsi }}</p>
                    </div>
                    <div>
                        <h4 style="font-size: 1.1rem; color: var(--primary-blue); font-weight: 700; margin: 0 0 0.75rem 0;">{{ $sambutan->obj3_title }}</h4>
                        <p style="font-size: 0.9rem; line-height: 1.5; color: var(--text-dark); margin: 0;">{{ $sambutan->obj3_deskripsi }}</p>
                    </div>
                    <div>
                        <h4 style="font-size: 1.1rem; color: var(--primary-blue); font-weight: 700; margin: 0 0 0.75rem 0;">{{ $sambutan->obj4_title }}</h4>
                        <p style="font-size: 0.9rem; line-height: 1.5; color: var(--text-dark); margin: 0;">{{ $sambutan->obj4_deskripsi }}</p>
                    </div>
                </div>
            </div>

            <!-- UCAPAN TERIMA KASIH -->
            <div style="margin-top: 2rem;">
                <h3 style="font-size: 1.2rem; color: var(--primary-blue); font-weight: 700; margin-bottom: 1rem;">Ucapan Terima Kasih</h3>
                <p style="font-size: 0.95rem; line-height: 1.6; color: var(--text-dark); margin-bottom: 1.5rem;">
                    Kami mengucapkan terima kasih yang sebesar-besarnya kepada semua pihak yang telah memberikan dukungan, inspirasi, dan kontribusi dalam mewujudkan portal ini:
                </p>
                <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <h5 style="font-size: 0.95rem; color: var(--primary-blue); font-weight: 700; margin: 0 0 0.4rem 0;">Pemerintah Daerah Kabupaten Sumbawa</h5>
                        <p style="font-size: 0.9rem; color: var(--text-dark); margin: 0;">Atas dukungan dan komitmen dalam pelestarian budaya lokal</p>
                    </div>
                    <div>
                        <h5 style="font-size: 0.95rem; color: var(--primary-blue); font-weight: 700; margin: 0 0 0.4rem 0;">Para Seniman dan Budayawan Sumbawa</h5>
                        <p style="font-size: 0.9rem; color: var(--text-dark); margin: 0;">Yang telah berdedikasi melestarikan dan mengembangkan warisan budaya kita</p>
                    </div>
                    <div>
                        <h5 style="font-size: 0.95rem; color: var(--primary-blue); font-weight: 700; margin: 0 0 0.4rem 0;">Lembaga Adat dan Kebudayaan</h5>
                        <p style="font-size: 0.9rem; color: var(--text-dark); margin: 0;">Atas peran penting dalam menjaga keaslian dan integritas budaya Sumbawa</p>
                    </div>
                    <div>
                        <h5 style="font-size: 0.95rem; color: var(--primary-blue); font-weight: 700; margin: 0 0 0.4rem 0;">Masyarakat Sumbawa</h5>
                        <p style="font-size: 0.9rem; color: var(--text-dark); margin: 0;">Atas partisipasi aktif dan dukungan moral dalam pengembangan portal ini</p>
                    </div>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.6; color: var(--text-dark);">
                    Kritik dan saran konstruktif sangat kami harapkan untuk terus menyempurnakan portal ini. Semoga Portal Karya Seniman Budaya Sumbawa dapat menjadi jembatan yang menghubungkan generasi muda dengan kekayaan warisan budaya nenek moyang kita.
                </p>
            </div>
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


@endsection
