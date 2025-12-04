@extends('layouts.app')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Manajemen Photo Slider</h1>
        <p class="subtitle">Kelola foto untuk hero section halaman beranda dengan mudah</p>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-times-circle"></i>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Statistik Slider -->
    <div class="slider-stats">
        <div class="stat-box">
            <span class="stat-number">{{ $sliders->count() }}</span>
            <span class="stat-label">Total Foto Slider</span>
        </div>
    </div>

    <!-- Form Tambah Foto -->
    <div class="form-section">
        <h2>Tambah Foto Baru</h2>
        <form class="upload-form" method="POST" action="{{ route('slider.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="foto">Pilih Foto (JPG, PNG, max 5MB)</label>
                <div class="file-input-wrapper" id="dropZone">
                    <input type="file" id="foto" name="foto" accept="image/*" required>
                    <span class="file-label">Klik atau drag foto di sini</span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="ri-upload-cloud-line"></i> Upload
            </button>
        </form>
    </div>

    <!-- Daftar Foto Slider -->
    <div class="slider-gallery">
        <h2>Galeri Foto Slider</h2>
        
        @if ($sliders->count() > 0)
            <div class="gallery-grid" id="galleryGrid">
                @foreach ($sliders as $slider)
                    <div class="gallery-item" data-slider-id="{{ $slider->id }}">
                        <div class="gallery-image">
                            <img src="{{ asset($slider->file_path) }}" alt="{{ $slider->original_name }}">
                            <div class="gallery-overlay">
                                <form method="POST" action="{{ route('slider.destroy', $slider->id) }}" style="display: inline;" onsubmit="return confirm('Yakin hapus foto ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-icon btn-danger" type="submit" title="Hapus">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="gallery-info">
                            <p class="gallery-name" title="{{ $slider->original_name }}">{{ $slider->original_name }}</p>
                            <p class="gallery-size">{{ $slider->formatted_file_size }}</p>
                            <p class="gallery-date">{{ $slider->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📸</div>
                <p>Belum ada foto slider. Silakan upload foto pertama Anda untuk memulai!</p>
            </div>
        @endif
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-photo-slider.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.min.css">
<style>
    /* Ensure icons display correctly */
    .btn-icon i {
        line-height: 1;
        display: inline-block;
    }

    .ri-edit-line::before,
    .ri-delete-bin-line::before,
    .ri-upload-cloud-line::before {
        font-size: 1.2em;
    }
    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .alert i {
        font-size: 18px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .alert p, .alert ul {
        margin: 0;
        font-size: 14px;
    }

    .alert-success {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #86efac;
    }

    .alert-danger {
        background: #fee2e2;
        color: #7f1d1d;
        border: 1px solid #fca5a5;
    }

    .file-input-wrapper.drag-over {
        border-color: #1d4ed8;
        background: linear-gradient(135deg, #bfdbfe 0%, #7dd3fc 100%);
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.25);
    }
</style>
@endpush

@push('scripts')
<script>
    // Drag and Drop
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('foto');

    if (dropZone) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('drag-over');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('drag-over');
            });
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
        });
    }
</script>
@endpush
