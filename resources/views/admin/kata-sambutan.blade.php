@extends('layouts.admin')

@section('title', 'Manajemen Kata Sambutan')
@section('page_title', 'Manajemen Kata Sambutan')

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Alert Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Error!</h4>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('sambutan.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- Hero Image Section -->
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title m-0"><i class="fas fa-image"></i> Foto Hero Section</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="hero_image" class="font-weight-bold">Ganti Foto Hero</label>
                            <div class="text-center mb-3">
                                <img src="{{ asset($sambutan->hero_image) }}" alt="Hero" class="img-fluid rounded" style="max-height: 300px; object-fit: cover; width: 100%;">
                            </div>
                            <button type="button" class="btn btn-primary btn-block mb-2" onclick="document.getElementById('hero_image').click()">
                                <i class="fas fa-cloud-upload-alt"></i> Pilih Gambar
                            </button>
                            <div class="custom-file-input" style="display:none;">
                                <input type="file" class="form-control-file" id="hero_image" name="hero_image" accept="image/*" onchange="previewFile(this, 'heroPreview')">
                            </div>
                            <div id="heroPreview" class="mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visi Section -->
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title m-0"><i class="fas fa-eye"></i> Visi</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="visi_text" class="font-weight-bold">Teks Visi</label>
                        <textarea id="visi_text" name="visi_text" rows="6" class="form-control" placeholder="Masukkan teks visi">{{ $sambutan->visi_text }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Misi Section -->
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title m-0"><i class="fas fa-bullseye"></i> Misi</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="misi_text" class="font-weight-bold">Teks Misi</label>
                        <textarea id="misi_text" name="misi_text" rows="6" class="form-control" placeholder="Masukkan teks misi">{{ $sambutan->misi_text }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Objectives Section -->
            <div class="card mb-3">
                <div class="card-header bg-warning">
                    <h3 class="card-title m-0"><i class="fas fa-lightbulb"></i> Objectives (Tujuan)</h3>
                </div>
                <div class="card-body">
                    @php
                        $borderColors = ['primary', 'info', 'success', 'danger'];
                    @endphp
                    
                    <!-- Objective 1 -->
                    <div class="card border-left-primary mb-3">
                        <div class="card-header">
                            <h5 class="m-0">Objective 1: <strong id="obj1_title_display">{{ $sambutan->obj1_title }}</strong></h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="obj1_title" class="font-weight-bold">Judul</label>
                                <input type="text" id="obj1_title" name="obj1_title" class="form-control" placeholder="Judul objective" value="{{ $sambutan->obj1_title }}" onchange="updateObjTitle(1)">
                            </div>
                            <div class="form-group">
                                <label for="obj1_deskripsi" class="font-weight-bold">Deskripsi</label>
                                <textarea id="obj1_deskripsi" name="obj1_deskripsi" rows="4" class="form-control" placeholder="Deskripsi objective">{{ $sambutan->obj1_deskripsi }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Objective 2 -->
                    <div class="card border-left-info mb-3">
                        <div class="card-header">
                            <h5 class="m-0">Objective 2: <strong id="obj2_title_display">{{ $sambutan->obj2_title }}</strong></h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="obj2_title" class="font-weight-bold">Judul</label>
                                <input type="text" id="obj2_title" name="obj2_title" class="form-control" placeholder="Judul objective" value="{{ $sambutan->obj2_title }}" onchange="updateObjTitle(2)">
                            </div>
                            <div class="form-group">
                                <label for="obj2_deskripsi" class="font-weight-bold">Deskripsi</label>
                                <textarea id="obj2_deskripsi" name="obj2_deskripsi" rows="4" class="form-control" placeholder="Deskripsi objective">{{ $sambutan->obj2_deskripsi }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Objective 3 -->
                    <div class="card border-left-success mb-3">
                        <div class="card-header">
                            <h5 class="m-0">Objective 3: <strong id="obj3_title_display">{{ $sambutan->obj3_title }}</strong></h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="obj3_title" class="font-weight-bold">Judul</label>
                                <input type="text" id="obj3_title" name="obj3_title" class="form-control" placeholder="Judul objective" value="{{ $sambutan->obj3_title }}" onchange="updateObjTitle(3)">
                            </div>
                            <div class="form-group">
                                <label for="obj3_deskripsi" class="font-weight-bold">Deskripsi</label>
                                <textarea id="obj3_deskripsi" name="obj3_deskripsi" rows="4" class="form-control" placeholder="Deskripsi objective">{{ $sambutan->obj3_deskripsi }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Objective 4 -->
                    <div class="card border-left-danger mb-3">
                        <div class="card-header">
                            <h5 class="m-0">Objective 4: <strong id="obj4_title_display">{{ $sambutan->obj4_title }}</strong></h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="obj4_title" class="font-weight-bold">Judul</label>
                                <input type="text" id="obj4_title" name="obj4_title" class="form-control" placeholder="Judul objective" value="{{ $sambutan->obj4_title }}" onchange="updateObjTitle(4)">
                            </div>
                            <div class="form-group">
                                <label for="obj4_deskripsi" class="font-weight-bold">Deskripsi</label>
                                <textarea id="obj4_deskripsi" name="obj4_deskripsi" rows="4" class="form-control" placeholder="Deskripsi objective">{{ $sambutan->obj4_deskripsi }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.custom-file-input {
    position: relative;
    display: block;
    margin-bottom: 1rem;
}

.custom-file-input input[type="file"] {
    position: absolute;
    left: 0;
    top: 0;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.custom-file-input::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 0.25rem;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
}

.custom-file-input:hover::before {
    opacity: 0.1;
}

.card.border-left-primary {
    border-left: 0.25rem solid #1e40af !important;
}

.card.border-left-info {
    border-left: 0.25rem solid #0ea5e9 !important;
}

.card.border-left-success {
    border-left: 0.25rem solid #10b981 !important;
}

.card.border-left-danger {
    border-left: 0.25rem solid #ef4444 !important;
}
</style>

<script>
function previewFile(input, previewId) {
    const file = input.files[0];
    const preview = document.getElementById(previewId);
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded" style="max-height: 200px; object-fit: cover; width: 100%;">';
        };
        reader.readAsDataURL(file);
    }
}

function updateObjTitle(num) {
    const titleInput = document.getElementById('obj' + num + '_title');
    const titleDisplay = document.getElementById('obj' + num + '_title_display');
    titleDisplay.textContent = titleInput.value || 'Objective ' + num;
}
</script>
@endsection
