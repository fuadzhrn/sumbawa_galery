@extends('layouts.seniman')

@section('title', 'Profile Saya - Seniman')

@section('extra_css')
    <style>
        .profile-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            padding: 40px 20px;
            border-radius: 8px;
            color: white;
            margin-bottom: 30px;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .profile-info h2 {
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 700;
        }

        .profile-info p {
            margin: 5px 0;
            font-size: 16px;
            opacity: 0.95;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .stat-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 14px;
            color: #666;
            font-weight: 500;
        }

        .form-card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .form-section-title {
            font-size: 20px;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e7ff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-input-wrapper input[type=file] {
            position: absolute;
            left: -9999px;
        }

        .file-input-label {
            display: block;
            padding: 20px;
            background-color: #f8f9fa;
            border: 2px dashed #ddd;
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .file-input-label:hover {
            background-color: #e9ecef;
            border-color: #1e40af;
        }

        .file-input-label.active {
            background-color: #eff6ff;
            border-color: #1e40af;
        }

        .file-preview {
            margin-top: 20px;
            text-align: center;
        }

        .file-preview img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background-color: #1e40af;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1e3a8a;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #7f1d1d;
            border-left: 4px solid #ef4444;
        }

        .alert-info {
            background-color: #dbeafe;
            color: #0c2d6b;
            border-left: 4px solid #3b82f6;
        }

        .current-avatar {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .current-avatar img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }

        .current-avatar-info p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }

        .current-avatar-info strong {
            color: #333;
        }
    </style>
@endsection

@section('content')
<!-- Profile Header -->
<div class="profile-header">
    <div style="display: flex; align-items: center; max-width: 600px;">
        <img src="{{ $seniman && $seniman->foto ? asset($seniman->foto) : asset('assets/avatars/default-avatar.svg') }}" 
             alt="Profile" class="profile-avatar">
        <div class="profile-info">
            <h2>{{ $seniman && $seniman->nama ? $seniman->nama : Auth::user()->name }}</h2>
            <p><i class="fas fa-envelope"></i> {{ Auth::user()->email }}</p>
            @if($seniman)
                <p><i class="fas fa-user-tag"></i> Seniman Terdaftar</p>
            @else
                <p><i class="fas fa-info-circle"></i> Belum terdaftar sebagai seniman</p>
            @endif
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-number">{{ $totalKarya }}</div>
            <div class="stat-label">Total Karya</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $totalViews }}</div>
            <div class="stat-label">Total Views</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $totalLikes }}</div>
            <div class="stat-label">Total Likes</div>
        </div>
    </div>
</div>

<!-- Content -->
<div class="row">
    <div class="col-md-8">
        <!-- Success Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Edit Profile Form -->
        <div class="form-card">
            <form method="POST" action="{{ route('seniman.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Photo Section -->
                <h3 class="form-section-title">Foto Profil</h3>
                
                @if($seniman && $seniman->foto)
                    <div class="current-avatar">
                        <img src="{{ asset($seniman->foto) }}" alt="Current Avatar">
                        <div class="current-avatar-info">
                            <p><strong>Foto Saat Ini:</strong></p>
                            <p>Unggah foto baru untuk menggantinya</p>
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <label for="foto">Foto Profil (Opsional)</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="foto" name="foto" accept="image/*" onchange="previewFoto(this)">
                        <label for="foto" class="file-input-label">
                            <div>
                                <i class="fas fa-image" style="font-size: 24px; color: #6c757d; display: block; margin-bottom: 8px;"></i>
                                <span>Klik atau drag foto di sini (JPG/PNG, max 2MB)</span>
                            </div>
                        </label>
                    </div>
                    <div class="file-preview" id="fotoPreview"></div>
                    @error('foto')
                        <small style="color: #ef4444;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Name Section -->
                <h3 class="form-section-title">Nama Seniman</h3>

                <div class="form-group">
                    <label for="nama">Nama Seniman</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                           id="nama" name="nama" 
                           placeholder="Masukkan nama seniman Anda"
                           value="{{ $seniman ? $seniman->nama : old('nama') }}">
                    <small style="color: #666; display: block; margin-top: 8px;">Nama panggilan atau nama profesional Anda sebagai seniman</small>
                    @error('nama')
                        <small style="color: #ef4444;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Biography Section -->
                <h3 class="form-section-title">Biografi</h3>

                <div class="form-group">
                    <label for="biografi">Biografi Anda</label>
                    <textarea class="form-control @error('biografi') is-invalid @enderror" 
                              id="biografi" name="biografi" 
                              placeholder="Ceritakan tentang Anda, karya Anda, dan pengalaman Anda...">{{ $seniman ? $seniman->biografi : old('biografi') }}</textarea>
                    <small style="color: #666; display: block; margin-top: 8px;">Maksimal 1000 karakter</small>
                    @error('biografi')
                        <small style="color: #ef4444;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('seniman.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Sidebar -->
    <div class="col-md-4">
        <div class="form-card">
            <h3 class="form-section-title">Informasi Akun</h3>
            
            <div style="margin-bottom: 20px;">
                <p style="color: #666; margin: 0 0 5px 0;"><strong>Email</strong></p>
                <p style="margin: 0; word-break: break-all;">{{ Auth::user()->email }}</p>
            </div>

            <div style="margin-bottom: 20px;">
                <p style="color: #666; margin: 0 0 5px 0;"><strong>Nama Lengkap</strong></p>
                <p style="margin: 0;">{{ Auth::user()->name }}</p>
            </div>

            <div style="margin-bottom: 20px;">
                <p style="color: #666; margin: 0 0 5px 0;"><strong>Status</strong></p>
                <p style="margin: 0;">
                    @if(Auth::user()->is_active)
                        <span class="badge" style="background-color: #d1fae5; color: #065f46; padding: 6px 12px; border-radius: 20px;">Aktif</span>
                    @else
                        <span class="badge" style="background-color: #fee2e2; color: #7f1d1d; padding: 6px 12px; border-radius: 20px;">Nonaktif</span>
                    @endif
                </p>
            </div>

            <div style="padding-top: 20px; border-top: 1px solid #e5e7eb;">
                <p style="color: #999; font-size: 12px; margin: 0;">
                    Terakhir diperbarui: {{ Auth::user()->updated_at->format('d M Y H:i') }}
                </p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_js')
    <script>
        function previewFoto(input) {
            const preview = document.getElementById('fotoPreview');
            preview.innerHTML = '';

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    const fileInfo = document.createElement('div');
                    fileInfo.style.marginTop = '10px';
                    fileInfo.style.fontSize = '13px';
                    fileInfo.style.color = '#666';
                    fileInfo.innerHTML = `<strong>File:</strong> ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.marginTop = '10px';
                    
                    preview.appendChild(fileInfo);
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }

        // Drag and drop
        const fileLabel = document.querySelector('.file-input-label');
        const fileInput = document.getElementById('foto');

        if (fileLabel) {
            fileLabel.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileLabel.classList.add('active');
            });

            fileLabel.addEventListener('dragleave', () => {
                fileLabel.classList.remove('active');
            });

            fileLabel.addEventListener('drop', (e) => {
                e.preventDefault();
                fileLabel.classList.remove('active');
                if (e.dataTransfer.files.length > 0) {
                    fileInput.files = e.dataTransfer.files;
                    previewFoto(fileInput);
                }
            });
        }
    </script>
@endsection
