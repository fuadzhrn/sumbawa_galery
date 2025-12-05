@extends('layouts.app')

@section('title', 'Film - Portal Karya Seniman Budaya Sumbawa')

@section('url-dummy', 'https://sumbawa-portal.local/film')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/kategori-detail.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="page-header">
    <h2 class="page-title">Seniman Film</h2>
    <p class="page-subtitle">Jelajahi karya-karya film dari seniman budaya Sumbawa</p>
</div>

<section class="kategori-section">
    <div class="kategori-grid">
        @forelse($karyaSeni as $karya)
        <div class="kategori-card">
            <div class="card-image">
                @if($karya->media_type === 'image' && $karya->thumbnail)
                    <img src="{{ asset($karya->thumbnail) }}" alt="{{ $karya->judul }}" class="card-img">
                @elseif($karya->media_type === 'image' && $karya->media_path)
                    <img src="{{ asset($karya->media_path) }}" alt="{{ $karya->judul }}" class="card-img">
                @else
                    <img src="{{ asset('assets/images/img1.png') }}" alt="{{ $karya->judul }}" class="card-img">
                @endif
                <div class="views-overlay">
                    <svg class="views-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    <span class="views-text">{{ $karya->views ?? 0 }}</span>
                </div>
            </div>
            <div class="card-content">
                <h3 class="card-title">{{ $karya->judul }}</h3>
                <p class="card-artist">{{ $karya->user->name }}</p>
                <button class="btn-biografi" 
                    data-karya-id="{{ $karya->id }}"
                    data-seniman-id="{{ $karya->user->seniman?->id }}"
                    data-nama="{{ $karya->user->name }}" 
                    data-kategori="{{ $karya->kategori->nama }}"
                    data-foto="{{ $karya->user->seniman?->foto ? asset($karya->user->seniman->foto) : asset('assets/images/img1.png') }}">
                    Lihat Biografi
                </button>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #999;">
            <p style="font-size: 16px;">Belum ada karya film</p>
        </div>
        @endforelse
    </div>
</section>

<!-- Modal -->
<div id="biographyModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Profil Seniman</h2>
            <button class="modal-close" onclick="closeBiographyModal()">&times;</button>
        </div>
        <div class="seniman-info">
            <img id="senimanFoto" src="{{ asset('assets/images/img1.png') }}" alt="Seniman" class="seniman-foto">
            <div class="seniman-nama" id="senimanNama"></div>
            <div class="seniman-kategori"><strong>Kategori:</strong> <span id="senimanKategori"></span></div>
            
            <div class="biografi-section">
                <div class="biografi-title">Biografi</div>
                <p class="biografi-text" id="senimanBiografi"></p>
            </div>

            <div class="karya-section">
                <div class="karya-title">Karya Seni</div>
                <ul class="karya-list" id="karyaList">
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Attach click listeners to all biografi buttons
    document.querySelectorAll('.btn-biografi').forEach(button => {
        button.addEventListener('click', function() {
            const karyaId = this.getAttribute('data-karya-id');
            const senimanId = this.getAttribute('data-seniman-id');

            console.log('Biografi button clicked:', { karyaId, senimanId });

            if (!senimanId) {
                console.error('Seniman ID tidak ditemukan');
                alert('Seniman tidak ditemukan');
                return;
            }

            // Fetch seniman profile
            fetch(`/api/seniman/${senimanId}/profile`)
                .then(response => {
                    console.log('API Response Status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Seniman data:', data);
                    console.log('Foto URL:', data.foto);
                    console.log('Biografi:', data.biografi);
                    console.log('Nama:', data.nama);
                    console.log('Kategori:', data.kategori);
                    
                    // Populate modal
                    document.getElementById('senimanNama').textContent = data.nama || 'Nama tidak tersedia';
                    document.getElementById('senimanKategori').textContent = data.kategori || 'Kategori tidak tersedia';
                    document.getElementById('senimanFoto').src = data.foto || '{{ asset("assets/images/img1.png") }}';
                    document.getElementById('senimanBiografi').textContent = data.biografi || 'Deskripsi tidak tersedia';

                    // Populate karya list
                    const karyaList = document.getElementById('karyaList');
                    karyaList.innerHTML = '';
                    
                    if (data.karya && data.karya.length > 0) {
                        data.karya.forEach(karya => {
                            const li = document.createElement('li');
                            li.className = 'karya-item';
                            li.innerHTML = `
                                <a href="/karya/${karya.id}" class="karya-link">${karya.judul}</a>
                                <div class="karya-kategori">${karya.kategori}</div>
                            `;
                            karyaList.appendChild(li);
                        });
                    } else {
                        const li = document.createElement('li');
                        li.className = 'no-karya';
                        li.textContent = 'Belum ada karya lainnya';
                        karyaList.appendChild(li);
                    }

                    // Show modal
                    document.getElementById('biographyModal').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error fetching seniman:', error);
                    alert('Gagal memuat data seniman: ' + error.message);
                });

            // Increment views
            fetch(`/karya-seni/${karyaId}/increment-views`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update views count in the UI
                const button = document.querySelector(`.btn-biografi[data-karya-id="${karyaId}"]`);
                if (button) {
                    const card = button.closest('.kategori-card');
                    const viewsText = card.querySelector('.views-text');
                    if (viewsText) {
                        viewsText.textContent = data.views;
                    }
                }
            })
            .catch(error => console.error('Error incrementing views:', error));
        });
    });

    function closeBiographyModal() {
        document.getElementById('biographyModal').style.display = 'none';
    }

    window.closeBiographyModal = closeBiographyModal;

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('biographyModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>
@endsection
