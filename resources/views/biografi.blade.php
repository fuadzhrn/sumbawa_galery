@extends('layouts.app')

@section('title', 'Biografi Seniman - Portal Karya Seniman Budaya Sumbawa')

@section('url-dummy', 'https://sumbawa-portal.local/biografi')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/biografi.css') }}">
@endsection

@section('content')
<!-- SENIMAN NAME HEADER -->
<div class="biografi-header">
    <h1 class="seniman-name">Adi Santoso</h1>
    <p class="seniman-kategori">Seniman Musik Tradisional</p>
</div>

<!-- BIOGRAFI CONTAINER -->
<div class="biografi-container">
    <!-- LEFT COLUMN - FOTO -->
    <div class="biografi-left">
        <div class="seniman-photo">
            <img src="{{ asset('assets/images/img1.png') }}" alt="Adi Santoso">
        </div>
    </div>

    <!-- RIGHT COLUMN - BIOGRAFI & KARYA -->
    <div class="biografi-right">
        <!-- BIOGRAFI SECTION -->
        <section class="biografi-section">
            <h2 class="section-title">Biografi</h2>
            <p class="biografi-text">
                Adi Santoso adalah seorang seniman musik tradisional yang berasal dari Sumbawa. Sejak usia dini, beliau telah mendalami berbagai instrumen musik tradisional Sumbawa yang kaya dan bernilai budaya tinggi. Dengan dedikasi penuh, Adi telah berkontribusi dalam melestarikan warisan budaya musik Sumbawa di era modern.
            </p>
            <p class="biografi-text">
                Perjalanan artistiknya dimulai dari pembelajaran intensif dengan para maestro musik tradisional. Beliau telah tampil di berbagai festival budaya nasional dan internasional, membawa nama Sumbawa ke panggung dunia. Karya-karyanya mencerminkan kedalaman emosi dan keindahan musik tradisional yang autentik.
            </p>
            <p class="biografi-text">
                Selain sebagai performer, Adi juga aktif dalam mentransfer ilmu kepada generasi muda. Beliau percaya bahwa musik tradisional harus terus hidup dan berkembang melalui pembelajaran berkelanjutan. Komitmennya terhadap seni budaya Sumbawa telah menginspirasi banyak musisi muda untuk menggali dan mengembangkan bakat mereka.
            </p>
        </section>

        <!-- KARYA SECTION -->
        <section class="karya-section">
            <h2 class="section-title">Daftar Karya</h2>
            <ol class="karya-list">
                <li class="karya-item">
                    <div class="karya-info">
                        <a href="#" class="karya-title">Melodi Sumbawa Kuno</a>
                        <p class="karya-desc">Komposisi musik tradisional yang menggabungkan instrumen lokal dengan harmoni modern</p>
                    </div>
                    <button class="btn-lihat-karya">Lihat Karya</button>
                </li>
                <li class="karya-item">
                    <div class="karya-info">
                        <a href="#" class="karya-title">Nyanyian Lelaki Sumbawa</a>
                        <p class="karya-desc">Lagu rakyat tradisional yang diperindah dengan aransemen kontemporer</p>
                    </div>
                    <button class="btn-lihat-karya">Lihat Karya</button>
                </li>
                <li class="karya-item">
                    <div class="karya-info">
                        <a href="#" class="karya-title">Simfoni Budaya Nusantara</a>
                        <p class="karya-desc">Orkestra musik yang menampilkan kolaborasi berbagai seniman tradisional Sumbawa</p>
                    </div>
                    <button class="btn-lihat-karya">Lihat Karya</button>
                </li>
                <li class="karya-item">
                    <div class="karya-info">
                        <a href="#" class="karya-title">Ritme Malam Pulau</a>
                        <p class="karya-desc">Musik intrumental yang menginspirasi ketenangan dan kontemplasi</p>
                    </div>
                    <button class="btn-lihat-karya">Lihat Karya</button>
                </li>
                <li class="karya-item">
                    <div class="karya-info">
                        <a href="#" class="karya-title">Harmoni Antar Generasi</a>
                        <p class="karya-desc">Proyek kolaborasi antara seniman senior dan musisi muda berbakat</p>
                    </div>
                    <button class="btn-lihat-karya">Lihat Karya</button>
                </li>
            </ol>
        </section>
    </div>
</div>
@endsection
