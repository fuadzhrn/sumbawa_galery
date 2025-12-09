@extends('layouts.seniman')

@section('title', 'Upload Karya - Seniman')

@section('extra-css')
    <style>
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .file-input-wrapper input[type=file] {
            position: absolute;
            left: -9999px;
        }

        .file-input-label {
            display: block;
            padding: 15px 20px;
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
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
            margin-top: 15px;
            text-align: center;
        }

        .file-preview img,
        .file-preview video {
            max-width: 100%;
            max-height: 300px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .media-type-info {
            padding: 10px 15px;
            background-color: #e7f3ff;
            border-left: 4px solid #1e40af;
            border-radius: 3px;
            margin-top: 10px;
            font-size: 13px;
            color: #0c5ba1;
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Upload Karya Baru</h3>
                <p class="text-muted" style="margin: 5px 0 0 0; font-size: 13px;">Bagikan karya seni Anda dengan komunitas</p>
            </div>
            <div class="card-body">
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5><i class="fas fa-exclamation-circle"></i> Terjadi Kesalahan!</h5>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('seniman.karya.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Judul Karya -->
                    <div class="form-group">
                        <label for="judul" class="font-weight-bold">Judul Karya <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" name="judul" 
                               placeholder="Masukkan judul karya Anda" 
                               value="{{ old('judul') }}" required>
                        @error('judul')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div class="form-group">
                        <label for="kategori_id" class="font-weight-bold">Kategori <span class="text-danger">*</span></label>
                        <select class="form-control @error('kategori_id') is-invalid @enderror" 
                                id="kategori_id" name="kategori_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <span class="invalid-feedback" style="display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group">
                        <label for="deskripsi" class="font-weight-bold">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" 
                                  rows="4" placeholder="Jelaskan tentang karya Anda...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <span class="invalid-feedback" style="display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tipe Media -->
                    <div class="form-group">
                        <label for="media_type" class="font-weight-bold">Tipe Media <span class="text-danger">*</span></label>
                        <select class="form-control @error('media_type') is-invalid @enderror" 
                                id="media_type" name="media_type" required onchange="updateMediaInput()">
                            <option value="">-- Pilih Tipe Media --</option>
                            <option value="image" {{ old('media_type') == 'image' ? 'selected' : '' }}>Gambar / Foto</option>
                            <option value="video" {{ old('media_type') == 'video' ? 'selected' : '' }}>Video File</option>
                            <option value="youtube_link" {{ old('media_type') == 'youtube_link' ? 'selected' : '' }}>Link YouTube</option>
                        </select>
                        @error('media_type')
                            <span class="invalid-feedback" style="display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Upload Method -->
                    <div class="form-group">
                        <label class="font-weight-bold">Pilih Cara Upload <span class="text-danger">*</span></label>
                        <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                            <label class="btn btn-outline-primary active" style="flex: 1;">
                                <input type="radio" name="upload_method" value="file" onchange="updateMediaInput()" checked> 
                                <i class="fas fa-file-upload"></i> Upload File
                            </label>
                            <label class="btn btn-outline-primary" style="flex: 1;">
                                <input type="radio" name="upload_method" value="url" onchange="updateMediaInput()"> 
                                <i class="fas fa-link"></i> Paste Link
                            </label>
                        </div>
                    </div>

                    <!-- File Upload Input -->
                    <div class="form-group" id="fileInputGroup">
                        <label class="font-weight-bold">Upload Media File <span class="text-danger" id="fileRequired">*</span></label>
                        <div class="file-input-wrapper w-100">
                            <input type="file" id="media_file" name="media_file" 
                                   accept="image/*,video/*" onchange="previewFile(this)">
                            <label for="media_file" class="file-input-label">
                                <div>
                                    <i class="fas fa-cloud-upload-alt" style="font-size: 24px; color: #6c757d; display: block; margin-bottom: 8px;"></i>
                                    <span>Drag and drop file di sini atau klik untuk memilih</span>
                                </div>
                            </label>
                        </div>
                        <div class="file-preview" id="filePreview"></div>
                        <div class="media-type-info" id="fileHelp" style="display: none;">
                            <strong>Format yang didukung:</strong> JPG, PNG (max 5MB) atau MP4 (max 100MB)
                        </div>
                    </div>

                    <!-- URL Input -->
                    <div class="form-group" id="urlInputGroup" style="display: none;">
                        <label for="media_url" class="font-weight-bold">URL Media <span class="text-danger" id="urlRequired">*</span></label>
                        <input type="url" class="form-control @error('media_url') is-invalid @enderror" 
                               id="media_url" name="media_url" 
                               placeholder="https://..." value="{{ old('media_url') }}">
                        <div class="media-type-info" id="urlHelp" style="display: none;">
                            <strong>Contoh YouTube:</strong> https://www.youtube.com/watch?v=dQw4w9WgXcQ
                        </div>
                        @error('media_url')
                            <span class="invalid-feedback" style="display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Thumbnail -->
                    <div class="form-group">
                        <label for="thumbnail" class="font-weight-bold">Thumbnail (Opsional)</label>
                        <div class="file-input-wrapper w-100">
                            <input type="file" id="thumbnail" name="thumbnail" 
                                   accept="image/*" onchange="previewThumbnail(this)">
                            <label for="thumbnail" class="file-input-label">
                                <div>
                                    <i class="fas fa-image" style="font-size: 24px; color: #6c757d; display: block; margin-bottom: 8px;"></i>
                                    <span>Pilih thumbnail untuk preview (JPG/PNG, max 2MB)</span>
                                </div>
                            </label>
                        </div>
                        <div class="file-preview" id="thumbnailPreview"></div>
                    </div>

                    <hr>

                    <!-- Submit Buttons -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane"></i> Upload Karya
                        </button>
                        <a href="{{ route('seniman.dashboard') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
    <script>
        function updateMediaInput() {
            const mediaType = document.getElementById('media_type').value;
            const uploadMethod = document.querySelector('input[name="upload_method"]:checked');
            const fileInputGroup = document.getElementById('fileInputGroup');
            const urlInputGroup = document.getElementById('urlInputGroup');
            const fileHelp = document.getElementById('fileHelp');
            const urlHelp = document.getElementById('urlHelp');
            const fileRequired = document.getElementById('fileRequired');
            const urlRequired = document.getElementById('urlRequired');
            const mediaFile = document.getElementById('media_file');
            const mediaUrl = document.getElementById('media_url');

            // Reset
            fileInputGroup.style.display = 'none';
            urlInputGroup.style.display = 'none';
            fileHelp.style.display = 'none';
            urlHelp.style.display = 'none';

            if (!mediaType) return;

            let method = uploadMethod ? uploadMethod.value : 'file';

            // YouTube link only supports URL
            if (mediaType === 'youtube_link') {
                method = 'url';
                document.querySelector('input[name="upload_method"][value="url"]').checked = true;
                document.querySelector('input[name="upload_method"][value="file"]').disabled = true;
            } else {
                document.querySelector('input[name="upload_method"][value="file"]').disabled = false;
            }

            if (method === 'file') {
                fileInputGroup.style.display = 'block';
                fileHelp.style.display = 'block';
                mediaFile.required = true;
                mediaUrl.required = false;

                if (mediaType === 'image') {
                    document.querySelector('label[for="media_file"]').textContent = 'Upload Gambar';
                    fileHelp.textContent = 'Format yang didukung: JPG, PNG (max 5MB)';
                    mediaFile.accept = 'image/*';
                } else if (mediaType === 'video') {
                    document.querySelector('label[for="media_file"]').textContent = 'Upload Video';
                    fileHelp.textContent = 'Format yang didukung: MP4 (max 100MB)';
                    mediaFile.accept = 'video/*';
                }
            } else {
                urlInputGroup.style.display = 'block';
                urlHelp.style.display = 'block';
                mediaFile.required = false;
                mediaUrl.required = true;

                if (mediaType === 'youtube_link') {
                    urlHelp.textContent = 'Contoh: https://www.youtube.com/watch?v=dQw4w9WgXcQ';
                } else if (mediaType === 'image') {
                    urlHelp.textContent = 'Paste URL lengkap gambar dari internet';
                } else if (mediaType === 'video') {
                    urlHelp.textContent = 'Paste URL lengkap video dari internet';
                }
            }
        }

        function previewFile(input) {
            const preview = document.getElementById('filePreview');
            preview.innerHTML = '';

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const mediaType = document.getElementById('media_type').value;

                // Show file info
                const fileInfo = document.createElement('div');
                fileInfo.style.marginTop = '10px';
                fileInfo.style.fontSize = '13px';
                fileInfo.style.color = '#666';
                fileInfo.innerHTML = `<strong>File:</strong> ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                preview.appendChild(fileInfo);

                // Show preview if image
                if (mediaType === 'image') {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            }
        }

        function previewThumbnail(input) {
            const preview = document.getElementById('thumbnailPreview');
            preview.innerHTML = '';

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }

        // Drag and drop
        const fileInputs = document.querySelectorAll('.file-input-wrapper');
        fileInputs.forEach(wrapper => {
            const label = wrapper.querySelector('.file-input-label');
            const input = wrapper.querySelector('input[type="file"]');

            label.addEventListener('dragover', (e) => {
                e.preventDefault();
                label.classList.add('active');
            });

            label.addEventListener('dragleave', () => {
                label.classList.remove('active');
            });

            label.addEventListener('drop', (e) => {
                e.preventDefault();
                label.classList.remove('active');
                if (e.dataTransfer.files.length > 0) {
                    input.files = e.dataTransfer.files;
                    if (input.onchange) {
                        input.onchange();
                    }
                }
            });
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateMediaInput();
        });
    </script>
@endsection
