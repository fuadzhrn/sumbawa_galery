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
        <form class="upload-form" id="uploadForm" method="POST" action="{{ route('slider.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="foto">Pilih Foto (JPG, PNG, max 5MB)</label>
                <div class="file-input-wrapper" id="dropZone">
                    <input type="file" id="foto" name="foto" accept="image/*" required>
                    <span class="file-label" id="fileLabel">Klik atau drag foto di sini</span>
                    <div class="file-check" id="fileCheck">
                        <svg class="checkmark" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="45" class="circle"></circle>
                            <polyline class="check-mark" points="30 50 45 65 70 35"></polyline>
                        </svg>
                        <p class="file-name" id="fileName"></p>
                    </div>
                </div>
            </div>
            <div class="upload-progress" id="uploadProgress" style="display: none;">
                <div class="progress-bar" id="progressBar"></div>
                <p id="progressText">Uploading...</p>
            </div>
            <button type="submit" class="btn btn-primary" id="uploadBtn">
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

    /* Upload Progress Animation */
    .upload-progress {
        margin: 20px 0;
        padding: 15px;
        background: #f3f4f6;
        border-radius: 8px;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .progress-bar {
        width: 0%;
        height: 8px;
        background: linear-gradient(90deg, #3b82f6, #1d4ed8);
        border-radius: 4px;
        transition: width 0.3s ease, background 0.4s ease;
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
    }

    #progressText {
        margin-top: 10px;
        font-size: 14px;
        color: #374151;
        font-weight: 500;
        text-align: center;
    }

    /* Gallery Item Animation */
    .gallery-item {
        animation: fadeInUp 0.5s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* File Check Animation */
    .file-check {
        display: none;
        text-align: center;
        animation: scaleIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .file-check.show {
        display: block;
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.5) rotate(-10deg);
        }
        to {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }
    }

    .checkmark {
        width: 80px;
        height: 80px;
        margin: 20px auto;
    }

    .checkmark .circle {
        stroke: #10b981;
        stroke-width: 2;
        fill: none;
        stroke-dasharray: 282.6;
        stroke-dashoffset: 282.6;
        animation: circleDraw 0.6s ease-out forwards;
        animation-delay: 0.2s;
    }

    @keyframes circleDraw {
        to {
            stroke-dashoffset: 0;
        }
    }

    .checkmark .check-mark {
        stroke: #10b981;
        stroke-width: 3;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: checkDraw 0.5s ease-out forwards;
        animation-delay: 0.6s;
    }

    @keyframes checkDraw {
        to {
            stroke-dashoffset: 0;
        }
    }

    .file-name {
        margin-top: 15px;
        color: #10b981;
        font-weight: 600;
        font-size: 14px;
        animation: fadeIn 0.5s ease-out;
        animation-delay: 0.8s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .file-input-wrapper.file-selected {
        border-color: #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(16, 185, 129, 0.1));
    }

    #fileLabel {
        transition: opacity 0.3s ease;
    }

    .file-input-wrapper.file-selected #fileLabel {
        opacity: 0;
        display: none;
    }
</style>
@endpush

@push('scripts')
<script>
    // Drag and Drop
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('foto');
    const uploadForm = document.getElementById('uploadForm');
    const uploadBtn = document.getElementById('uploadBtn');
    const uploadProgress = document.getElementById('uploadProgress');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const fileCheck = document.getElementById('fileCheck');
    const fileLabel = document.getElementById('fileLabel');
    const fileName = document.getElementById('fileName');

    // Show checkmark animation on file select
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            const file = this.files[0];
            fileName.textContent = file.name;
            fileCheck.classList.add('show');
            dropZone.classList.add('file-selected');
        }
    });

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
            
            // Trigger change event to show checkmark
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        });
    }

    // Upload Animation
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            // Show progress bar
            uploadProgress.style.display = 'block';
            progressBar.style.width = '0%';
            uploadBtn.disabled = true;

            // Simulate progress
            let progress = 0;
            const interval = setInterval(() => {
                progress += Math.random() * 30;
                if (progress > 90) progress = 90;
                progressBar.style.width = progress + '%';
                progressText.textContent = `Uploading... ${Math.floor(progress)}%`;
            }, 200);

            // Handle form submission with XMLHttpRequest for better control
            e.preventDefault();
            
            const formData = new FormData(uploadForm);
            const xhr = new XMLHttpRequest();

            xhr.upload.addEventListener('progress', (event) => {
                if (event.lengthComputable) {
                    const percentComplete = (event.loaded / event.total) * 100;
                    progressBar.style.width = percentComplete + '%';
                    progressText.textContent = `Uploading... ${Math.floor(percentComplete)}%`;
                }
            });

            xhr.addEventListener('load', () => {
                clearInterval(interval);
                
                if (xhr.status === 200) {
                    // Success animation
                    progressBar.style.width = '100%';
                    progressBar.style.background = 'linear-gradient(90deg, #10b981, #059669)';
                    progressText.textContent = '✓ Upload Selesai!';
                    
                    // Show success message
                    setTimeout(() => {
                        uploadProgress.style.display = 'none';
                        uploadForm.reset();
                        uploadBtn.disabled = false;
                        progressBar.style.background = 'linear-gradient(90deg, #3b82f6, #1d4ed8)';
                        fileCheck.classList.remove('show');
                        dropZone.classList.remove('file-selected');
                        
                        // Reload page to show new image
                        location.reload();
                    }, 1500);
                } else {
                    // Error
                    progressBar.style.width = '100%';
                    progressBar.style.background = 'linear-gradient(90deg, #ef4444, #dc2626)';
                    progressText.textContent = '✗ Upload Gagal!';
                    
                    setTimeout(() => {
                        uploadProgress.style.display = 'none';
                        uploadBtn.disabled = false;
                        progressBar.style.background = 'linear-gradient(90deg, #3b82f6, #1d4ed8)';
                    }, 1500);
                }
            });

            xhr.addEventListener('error', () => {
                clearInterval(interval);
                progressBar.style.width = '100%';
                progressBar.style.background = 'linear-gradient(90deg, #ef4444, #dc2626)';
                progressText.textContent = '✗ Upload Gagal!';
                
                setTimeout(() => {
                    uploadProgress.style.display = 'none';
                    uploadBtn.disabled = false;
                    progressBar.style.background = 'linear-gradient(90deg, #3b82f6, #1d4ed8)';
                }, 1500);
            });

            xhr.open('POST', uploadForm.action);
            xhr.send(formData);
        });
    }
</script>
@endpush
