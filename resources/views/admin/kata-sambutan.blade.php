@extends('layouts.app')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1><i class="ri-edit-2-line"></i> Edit Kata Sambutan</h1>
        <p class="subtitle">Kelola konten halaman Kata Sambutan dengan tampilan yang kreatif</p>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 20px;">
            <i class="fas fa-exclamation-circle"></i>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success" style="margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i>
            <p style="margin: 0;">{{ session('success') }}</p>
        </div>
    @endif

    <form class="edit-sambutan-form" method="POST" action="{{ route('sambutan.update') }}" enctype="multipart/form-data">
        @csrf

        <!-- Bagian Foto Hero -->
        <div class="form-section hero-section">
            <div class="section-header">
                <h2><i class="ri-image-add-line"></i> Foto Hero Section</h2>
                <span class="section-badge">Gambar Utama</span>
            </div>
            <div class="form-group">
                <label>Foto Saat Ini</label>
                <div class="current-image preview-large">
                    <img src="{{ asset($sambutan->hero_image) }}" alt="Hero Sambutan">
                </div>
            </div>
            <div class="form-group">
                <label for="hero_image">Ganti Foto Hero</label>
                <div class="file-input-wrapper">
                    <input type="file" id="hero_image" name="hero_image" accept="image/*">
                    <span class="file-label">Klik untuk pilih foto baru</span>
                </div>
            </div>
        </div>

        <!-- Bagian Visi -->
        <div class="form-section visi-section">
            <div class="section-header">
                <h2><i class="ri-eye-line"></i> Visi</h2>
                <span class="section-badge">Visi Kami</span>
            </div>
            <div class="two-column-layout">
                <div class="column-left">
                    <div class="form-group">
                        <label for="foto_visi">Foto Visi</label>
                        <div class="current-image preview-medium">
                            <img src="{{ asset($sambutan->visi_image) }}" alt="Visi">
                        </div>
                        <div class="file-input-wrapper" style="margin-top: 15px;">
                            <input type="file" id="foto_visi" name="visi_image" accept="image/*">
                            <span class="file-label">Ganti foto</span>
                        </div>
                    </div>
                </div>
                <div class="column-right">
                    <div class="form-group">
                        <label for="teks_visi">Teks Visi</label>
                        <textarea id="teks_visi" name="visi_text" rows="6" class="form-control" placeholder="Masukkan teks visi">{{ $sambutan->visi_text }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian Misi -->
        <div class="form-section misi-section">
            <div class="section-header">
                <h2><i class="ri-rocket-2-line"></i> Misi</h2>
                <span class="section-badge">Tujuan Kami</span>
            </div>
            <div class="two-column-layout">
                <div class="column-left">
                    <div class="form-group">
                        <label for="foto_misi">Foto Misi</label>
                        <div class="current-image preview-medium">
                            <img src="{{ asset($sambutan->misi_image) }}" alt="Misi">
                        </div>
                        <div class="file-input-wrapper" style="margin-top: 15px;">
                            <input type="file" id="foto_misi" name="misi_image" accept="image/*">
                            <span class="file-label">Ganti foto</span>
                        </div>
                    </div>
                </div>
                <div class="column-right">
                    <div class="form-group">
                        <label for="teks_misi">Teks Misi (pisahkan dengan line break untuk setiap poin)</label>
                        <textarea id="teks_misi" name="misi_text" rows="6" class="form-control" placeholder="Masukkan teks misi">{{ $sambutan->misi_text }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian Objectives -->
        <div class="form-section objectives-section">
            <div class="section-header">
                <h2><i class="ri-lightbulb-line"></i> Objectives (Tujuan)</h2>
                <span class="section-badge">4 Pilar Utama</span>
            </div>

            <!-- Objective 1 -->
            <div class="objective-edit-item">
                <div class="objective-header">
                    <h3>Objective 1: {{ $sambutan->obj1_title }}</h3>
                </div>
                <div class="objective-layout">
                    <div class="objective-image">
                        <label>Foto</label>
                        <div class="current-image preview-small">
                            <img src="{{ asset($sambutan->obj1_image) }}" alt="Objective 1">
                        </div>
                        <div class="file-input-wrapper">
                            <input type="file" id="obj1_foto" name="obj1_image" accept="image/*">
                            <span class="file-label">Ganti foto</span>
                        </div>
                    </div>
                    <div class="objective-content">
                        <div class="form-group">
                            <label for="obj1_title">Judul</label>
                            <input type="text" id="obj1_title" name="obj1_title" class="form-control" placeholder="Judul objective" value="{{ $sambutan->obj1_title }}">
                        </div>
                        <div class="form-group">
                            <label for="obj1_deskripsi">Deskripsi</label>
                            <textarea id="obj1_deskripsi" name="obj1_deskripsi" rows="4" class="form-control" placeholder="Deskripsi objective">{{ $sambutan->obj1_deskripsi }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Objective 2 -->
            <div class="objective-edit-item">
                <div class="objective-header">
                    <h3>Objective 2: {{ $sambutan->obj2_title }}</h3>
                </div>
                <div class="objective-layout">
                    <div class="objective-image">
                        <label>Foto</label>
                        <div class="current-image preview-small">
                            <img src="{{ asset($sambutan->obj2_image) }}" alt="Objective 2">
                        </div>
                        <div class="file-input-wrapper">
                            <input type="file" id="obj2_foto" name="obj2_image" accept="image/*">
                            <span class="file-label">Ganti foto</span>
                        </div>
                    </div>
                    <div class="objective-content">
                        <div class="form-group">
                            <label for="obj2_title">Judul</label>
                            <input type="text" id="obj2_title" name="obj2_title" class="form-control" placeholder="Judul objective" value="{{ $sambutan->obj2_title }}">
                        </div>
                        <div class="form-group">
                            <label for="obj2_deskripsi">Deskripsi</label>
                            <textarea id="obj2_deskripsi" name="obj2_deskripsi" rows="4" class="form-control" placeholder="Deskripsi objective">{{ $sambutan->obj2_deskripsi }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Objective 3 -->
            <div class="objective-edit-item">
                <div class="objective-header">
                    <h3>Objective 3: {{ $sambutan->obj3_title }}</h3>
                </div>
                <div class="objective-layout">
                    <div class="objective-image">
                        <label>Foto</label>
                        <div class="current-image preview-small">
                            <img src="{{ asset($sambutan->obj3_image) }}" alt="Objective 3">
                        </div>
                        <div class="file-input-wrapper">
                            <input type="file" id="obj3_foto" name="obj3_image" accept="image/*">
                            <span class="file-label">Ganti foto</span>
                        </div>
                    </div>
                    <div class="objective-content">
                        <div class="form-group">
                            <label for="obj3_title">Judul</label>
                            <input type="text" id="obj3_title" name="obj3_title" class="form-control" placeholder="Judul objective" value="{{ $sambutan->obj3_title }}">
                        </div>
                        <div class="form-group">
                            <label for="obj3_deskripsi">Deskripsi</label>
                            <textarea id="obj3_deskripsi" name="obj3_deskripsi" rows="4" class="form-control" placeholder="Deskripsi objective">{{ $sambutan->obj3_deskripsi }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Objective 4 -->
            <div class="objective-edit-item">
                <div class="objective-header">
                    <h3>Objective 4: {{ $sambutan->obj4_title }}</h3>
                </div>
                <div class="objective-layout">
                    <div class="objective-image">
                        <label>Foto</label>
                        <div class="current-image preview-small">
                            <img src="{{ asset($sambutan->obj4_image) }}" alt="Objective 4">
                        </div>
                        <div class="file-input-wrapper">
                            <input type="file" id="obj4_foto" name="obj4_image" accept="image/*">
                            <span class="file-label">Ganti foto</span>
                        </div>
                    </div>
                    <div class="objective-content">
                        <div class="form-group">
                            <label for="obj4_title">Judul</label>
                            <input type="text" id="obj4_title" name="obj4_title" class="form-control" placeholder="Judul objective" value="{{ $sambutan->obj4_title }}">
                        </div>
                        <div class="form-group">
                            <label for="obj4_deskripsi">Deskripsi</label>
                            <textarea id="obj4_deskripsi" name="obj4_deskripsi" rows="4" class="form-control" placeholder="Deskripsi objective">{{ $sambutan->obj4_deskripsi }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-save"><i class="ri-save-line"></i> Simpan Perubahan</button>
            <button type="reset" class="btn btn-secondary btn-reset"><i class="ri-refresh-line"></i> Reset Form</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Animasi centang saat gambar dipilih
    document.addEventListener('DOMContentLoaded', function() {
        const fileInputs = document.querySelectorAll('input[type="file"]');
        
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const wrapper = this.closest('.file-input-wrapper');
                const label = wrapper.querySelector('.file-label');
                const fileName = this.files[0]?.name || '';
                
                if (fileName) {
                    // Tambahkan kelas untuk animasi
                    wrapper.classList.add('file-selected');
                    
                    // Update label dengan nama file dan centang
                    label.innerHTML = `<i class="ri-check-line"></i> ${fileName}`;
                    
                    // Auto remove effect setelah 3 detik jika user tidak submit
                    setTimeout(() => {
                        if (wrapper.classList.contains('file-selected')) {
                            label.innerHTML = `<i class="ri-check-line" style="color: #27ae60;"></i> Siap diunggah`;
                        }
                    }, 2000);
                }
            });
        });
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css">
<link rel="stylesheet" href="{{ asset('css/admin-sambutan.css') }}">
<style>
    /* Enhanced Creative Styling */
    .admin-header h1 {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 2.5em;
        margin-bottom: 10px;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 3px solid #f0f0f0;
    }

    .section-header h2 {
        font-size: 1.8em;
        color: #333;
        margin: 0;
    }

    .section-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 600;
    }

    .form-section {
        background: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-left: 5px solid #667eea;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .form-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .visi-section {
        border-left-color: #20c997;
    }

    .misi-section {
        border-left-color: #ffc107;
    }

    .objectives-section {
        border-left-color: #e74c3c;
    }

    .two-column-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        align-items: start;
    }

    @media (max-width: 768px) {
        .two-column-layout {
            grid-template-columns: 1fr;
        }
    }

    .preview-large {
        max-height: 400px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }

    .preview-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .preview-medium {
        max-height: 300px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .preview-medium img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .preview-small {
        max-height: 180px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .preview-small img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .objective-edit-item {
        background: #f9f9f9;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 20px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .objective-edit-item:hover {
        background: #fff;
        border-color: #667eea;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
    }

    .objective-header {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e0e0e0;
    }

    .objective-header h3 {
        margin: 0;
        color: #667eea;
        font-size: 1.1em;
    }

    .objective-layout {
        display: grid;
        grid-template-columns: 200px 1fr;
        gap: 25px;
        align-items: start;
    }

    @media (max-width: 768px) {
        .objective-layout {
            grid-template-columns: 1fr;
        }
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 40px;
        padding-top: 30px;
        border-top: 3px solid #f0f0f0;
    }

    .btn-save, .btn-reset {
        padding: 12px 30px;
        font-size: 1em;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-save {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
    }

    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-reset {
        background: #e0e0e0;
        border: none;
        color: #666;
    }

    .btn-reset:hover {
        background: #d0d0d0;
        transform: translateY(-3px);
    }

    /* Remix Icon Styling */
    .section-header h2 i {
        margin-right: 10px;
        font-size: 1.3em;
    }

    .admin-header h1 i {
        margin-right: 8px;
        font-size: 1.2em;
    }

    .btn-save i,
    .btn-reset i {
        margin-right: 8px;
        font-size: 1.1em;
    }

    /* Alert Styling */
    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        border-left: 4px solid;
    }

    .alert-danger {
        background-color: #fee;
        border-left-color: #e74c3c;
        color: #c0392b;
    }

    .alert-danger i {
        margin-right: 10px;
    }

    .alert-success {
        background-color: #efe;
        border-left-color: #27ae60;
        color: #229954;
    }

    .alert-success i {
        margin-right: 10px;
    }

    /* File Input Animation */
    .file-input-wrapper {
        position: relative;
        overflow: hidden;
    }

    .file-label {
        display: inline-block;
        padding: 12px 20px;
        background: #f8f9fa;
        border: 2px dashed #667eea;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        color: #666;
        width: 100%;
        text-align: center;
    }

    .file-input-wrapper:hover .file-label {
        background: #f0f1ff;
        border-color: #764ba2;
        color: #764ba2;
    }

    .file-input-wrapper.file-selected .file-label {
        background: #f0fff4;
        border-color: #27ae60;
        border-style: solid;
        color: #27ae60;
        animation: slideIn 0.4s ease-out;
    }

    .file-label i {
        margin-right: 8px;
        font-size: 1.1em;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes checkmark {
        0% {
            transform: scale(0) rotate(-45deg);
            opacity: 0;
        }
        50% {
            transform: scale(1.2) rotate(0deg);
        }
        100% {
            transform: scale(1) rotate(0deg);
            opacity: 1;
        }
    }

    .file-label i.ri-check-line {
        animation: checkmark 0.5s ease-out;
    }
</style>
@endpush
