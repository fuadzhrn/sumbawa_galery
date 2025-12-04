@extends('layouts.app')

@section('title', 'Rupa - Portal Karya Seniman Budaya Sumbawa')

@section('url-dummy', 'https://sumbawa-portal.local/rupa')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/rupa.css') }}">
@endsection

@section('content')
<!-- PAGE TITLE -->
<div class="page-header" id="pageHeader">
    <h2 class="page-title">Seniman Rupa</h2>
    <p class="page-subtitle">Jelajahi karya-karya seni rupa dari seniman budaya Sumbawa</p>
</div>

<!-- RUPA ARTISTS GRID -->
<section class="rupa-section" id="rupaSection">
    <div class="rupa-grid">
        <!-- Card 1 -->
        <div class="rupa-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img1.png') }}" alt="Seniman 1">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">Wayan Sudarta</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">1.2K</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="Wayan Sudarta" data-kategori="Pelukis Tradisional" data-foto="{{ asset('assets/images/img1.png') }}">Biografi</button>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="rupa-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img2.png') }}" alt="Seniman 2">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">Ketut Astawan</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">2.5K</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="Ketut Astawan" data-kategori="Pematung Tradisional" data-foto="{{ asset('assets/images/img2.png') }}">Biografi</button>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="rupa-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img3.png') }}" alt="Seniman 3">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">I Nyoman Sudana</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">892</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="I Nyoman Sudana" data-kategori="Pengrajin Kayu Tradisional" data-foto="{{ asset('assets/images/img3.png') }}">Biografi</button>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="rupa-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img1.png') }}" alt="Seniman 4">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">Siti Rohayah</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">3.1K</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="Siti Rohayah" data-kategori="Pelukis Batik Tradisional" data-foto="{{ asset('assets/images/img1.png') }}">Biografi</button>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="rupa-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img2.png') }}" alt="Seniman 5">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">Hendra Santoso</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">1.8K</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="Hendra Santoso" data-kategori="Pengrajin Keramik Tradisional" data-foto="{{ asset('assets/images/img2.png') }}">Biografi</button>
            </div>
        </div>

        <!-- Card 6 -->
        <div class="rupa-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img3.png') }}" alt="Seniman 6">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">Nur Azizah</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">2.7K</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="Nur Azizah" data-kategori="Seniman Tenun Tradisional" data-foto="{{ asset('assets/images/img3.png') }}">Biografi</button>
            </div>
        </div>

        <!-- Card 7 -->
        <div class="rupa-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img1.png') }}" alt="Seniman 7">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">Bambang Hartoyo</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">945</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="Bambang Hartoyo" data-kategori="Pematung Batu Tradisional" data-foto="{{ asset('assets/images/img1.png') }}">Biografi</button>
            </div>
        </div>

        <!-- Card 8 -->
        <div class="rupa-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img2.png') }}" alt="Seniman 8">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">Lina Kusumawati</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">2.2K</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="Lina Kusumawati" data-kategori="Pelukis Kontemporer Tradisional" data-foto="{{ asset('assets/images/img2.png') }}">Biografi</button>
            </div>
        </div>

        <!-- Card 9 -->
        <div class="rupa-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img3.png') }}" alt="Seniman 9">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">Suryanto Wijaya</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">1.6K</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="Suryanto Wijaya" data-kategori="Pengrajin Perhiasan Tradisional" data-foto="{{ asset('assets/images/img3.png') }}">Biografi</button>
            </div>
        </div>
    </div>
</section>

<!-- BIOGRAFI MODAL -->
<div id="biografiModal" class="biografi-modal hidden">
    <div class="modal-overlay" onclick="hideBiografi()"></div>
    <div class="modal-content">
        <button class="btn-close" onclick="hideBiografi()">&times;</button>
        <div class="modal-body">
            <div class="modal-left">
                <img id="biografiFoto" src="" alt="Foto Seniman" class="modal-foto">
            </div>
            <div class="modal-right">
                <h2 id="biografiNama" class="modal-nama">Nama Seniman</h2>
                <p id="biografiKategori" class="modal-kategori">Kategori</p>
                
                <section class="modal-biografi-section">
                    <h3>Biografi</h3>
                    <p id="biografiText" class="biografi-text">
                        Wayan Sudarta adalah seorang seniman rupa tradisional yang berasal dari Sumbawa. Sejak usia dini, beliau telah mendalami berbagai teknik seni rupa tradisional Sumbawa yang kaya dan bernilai budaya tinggi. Dengan dedikasi penuh, Wayan telah berkontribusi dalam melestarikan warisan budaya seni rupa Sumbawa di era modern.
                    </p>
                </section>

                <section class="modal-karya-section">
                    <h3>Daftar Karya</h3>
                    <ol class="karya-list">
                        <li class="karya-item">
                            <div class="karya-info">
                                <a href="#" class="karya-title">Lukisan Lanskap Sumbawa Kuno</a>
                                <p class="karya-desc">Karya seni rupa tradisional yang menggabungkan teknik lokal dengan estetika modern</p>
                            </div>
                            <button class="btn-lihat-karya">Lihat Karya</button>
                        </li>
                        <li class="karya-item">
                            <div class="karya-info">
                                <a href="#" class="karya-title">Patung Tokoh Legendaris Sumbawa</a>
                                <p class="karya-desc">Karya seni pahat tradisional yang menampilkan karakter budaya setempat</p>
                            </div>
                            <button class="btn-lihat-karya">Lihat Karya</button>
                        </li>
                        <li class="karya-item">
                            <div class="karya-info">
                                <a href="#" class="karya-title">Keramik Hiasan Tradisional</a>
                                <p class="karya-desc">Kolaborasi seni dengan pengrajin lokal yang menampilkan keunikan budaya Sumbawa</p>
                            </div>
                            <button class="btn-lihat-karya">Lihat Karya</button>
                        </li>
                        <li class="karya-item">
                            <div class="karya-info">
                                <a href="#" class="karya-title">Pameran Seni Rupa Tradisional 2023</a>
                                <p class="karya-desc">Penyelenggaraan pameran besar yang menampilkan berbagai karya seniman rupa dari Sumbawa</p>
                            </div>
                            <button class="btn-lihat-karya">Lihat Karya</button>
                        </li>
                        <li class="karya-item">
                            <div class="karya-info">
                                <a href="#" class="karya-title">Dokumentasi Seni Rupa Kuno Sumbawa</a>
                                <p class="karya-desc">Proyek penelitian dan dokumentasi seni rupa tradisional untuk generasi mendatang</p>
                            </div>
                            <button class="btn-lihat-karya">Lihat Karya</button>
                        </li>
                    </ol>
                </section>
            </div>
        </div>
    </div>
</div>

@section('extra-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tambah event listener ke semua biography buttons
            const biographyButtons = document.querySelectorAll('.btn-biography');
            biographyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const nama = this.getAttribute('data-nama');
                    const kategori = this.getAttribute('data-kategori');
                    const foto = this.getAttribute('data-foto');
                    showBiografi(nama, kategori, foto);
                });
            });
        });

        function showBiografi(nama, kategori, foto) {
            document.getElementById('pageHeader').style.display = 'none';
            document.getElementById('rupaSection').style.display = 'none';
            document.getElementById('biografiModal').classList.remove('hidden');
            document.getElementById('biografiNama').textContent = nama;
            document.getElementById('biografiKategori').textContent = kategori;
            document.getElementById('biografiFoto').src = foto;
            console.log('Showing biografi for:', nama);
        }

        function hideBiografi() {
            document.getElementById('pageHeader').style.display = 'block';
            document.getElementById('rupaSection').style.display = 'block';
            document.getElementById('biografiModal').classList.add('hidden');
            console.log('Hiding biografi');
        }
    </script>
@endsection
@endsection
