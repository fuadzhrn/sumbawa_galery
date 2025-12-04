@extends('layouts.app')

@section('title', 'Musik - Portal Karya Seniman Budaya Sumbawa')

@section('url-dummy', 'https://sumbawa-portal.local/musik')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/musik.css') }}">
@endsection

@section('content')
<!-- PAGE TITLE -->
<div class="page-header" id="pageHeader">
    <h2 class="page-title">Seniman Musik</h2>
    <p class="page-subtitle">Jelajahi karya-karya musik dari seniman budaya Sumbawa</p>
</div>

<!-- MUSIC ARTISTS GRID -->
<section class="musik-section" id="musikSection">
    <div class="musik-grid">
        <!-- Card 1 -->
        <div class="musik-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img1.png') }}" alt="Seniman 1">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">Adi Santoso</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">1.2K</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="Adi Santoso" data-kategori="Seniman Musik Tradisional" data-foto="{{ asset('assets/images/img1.png') }}">Biografi</button>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="musik-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img2.png') }}" alt="Seniman 2">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">Siti Nurhaliza</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">2.5K</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="Siti Nurhaliza" data-kategori="Penyanyi Tradisional" data-foto="{{ asset('assets/images/img2.png') }}">Biografi</button>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="musik-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img3.png') }}" alt="Seniman 3">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">Budi Handoko</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">892</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="Budi Handoko" data-kategori="Musisi Perkusi Tradisional" data-foto="{{ asset('assets/images/img3.png') }}">Biografi</button>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="musik-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img1.png') }}" alt="Seniman 4">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">Dewi Lestari</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">3.1K</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="Dewi Lestari" data-kategori="Penari Tradisional" data-foto="{{ asset('assets/images/img1.png') }}">Biografi</button>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="musik-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img2.png') }}" alt="Seniman 5">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">Rudi Anggara</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">1.8K</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="Rudi Anggara" data-kategori="Komposer Musik Tradisional" data-foto="{{ asset('assets/images/img2.png') }}">Biografi</button>
            </div>
        </div>

        <!-- Card 6 -->
        <div class="musik-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img3.png') }}" alt="Seniman 6">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">Maya Putri</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">2.7K</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="Maya Putri" data-kategori="Seniman Vokal Tradisional" data-foto="{{ asset('assets/images/img3.png') }}">Biografi</button>
            </div>
        </div>

        <!-- Card 7 -->
        <div class="musik-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img1.png') }}" alt="Seniman 7">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">Ahmad Wijaya</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">945</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="Ahmad Wijaya" data-kategori="Pengajar Musik Tradisional" data-foto="{{ asset('assets/images/img1.png') }}">Biografi</button>
            </div>
        </div>

        <!-- Card 8 -->
        <div class="musik-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img2.png') }}" alt="Seniman 8">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">Citra Dewi</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">2.2K</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="Citra Dewi" data-kategori="Seniman Musik Kontemporer Tradisional" data-foto="{{ asset('assets/images/img2.png') }}">Biografi</button>
            </div>
        </div>

        <!-- Card 9 -->
        <div class="musik-card">
            <div class="card-image">
                <img src="{{ asset('assets/images/img3.png') }}" alt="Seniman 9">
                <div class="artist-name-overlay">
                    <h3 class="artist-name">Endra Kusuma</h3>
                </div>
                <div class="views-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--primary-blue);"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    <span class="views-count">1.6K</span>
                </div>
            </div>
            <div class="card-body">
                <button class="btn-biography" data-nama="Endra Kusuma" data-kategori="Arranger Musik Tradisional" data-foto="{{ asset('assets/images/img3.png') }}">Biografi</button>
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
                        Adi Santoso adalah seorang seniman musik tradisional yang berasal dari Sumbawa. Sejak usia dini, beliau telah mendalami berbagai instrumen musik tradisional Sumbawa yang kaya dan bernilai budaya tinggi. Dengan dedikasi penuh, Adi telah berkontribusi dalam melestarikan warisan budaya musik Sumbawa di era modern.
                    </p>
                </section>

                <section class="modal-karya-section">
                    <h3>Daftar Karya</h3>
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
                                <a href="#" class="karya-title">Harmoni Budaya Sumbawa</a>
                                <p class="karya-desc">Kolaborasi musik dengan seniman internasional yang menampilkan keunikan budaya lokal</p>
                            </div>
                            <button class="btn-lihat-karya">Lihat Karya</button>
                        </li>
                        <li class="karya-item">
                            <div class="karya-info">
                                <a href="#" class="karya-title">Festival Musik Tradisional 2023</a>
                                <p class="karya-desc">Penyelenggaraan festival besar yang menampilkan berbagai seniman musik dari Sumbawa</p>
                            </div>
                            <button class="btn-lihat-karya">Lihat Karya</button>
                        </li>
                        <li class="karya-item">
                            <div class="karya-info">
                                <a href="#" class="karya-title">Dokumentasi Musik Kuno Sumbawa</a>
                                <p class="karya-desc">Proyek penelitian dan dokumentasi musik tradisional untuk generasi mendatang</p>
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
            document.getElementById('musikSection').style.display = 'none';
            document.getElementById('biografiModal').classList.remove('hidden');
            document.getElementById('biografiNama').textContent = nama;
            document.getElementById('biografiKategori').textContent = kategori;
            document.getElementById('biografiFoto').src = foto;
            console.log('Showing biografi for:', nama);
        }

        function hideBiografi() {
            document.getElementById('pageHeader').style.display = 'block';
            document.getElementById('musikSection').style.display = 'block';
            document.getElementById('biografiModal').classList.add('hidden');
            console.log('Hiding biografi');
        }
    </script>
@endsection
@endsection
