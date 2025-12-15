@extends('layouts.admin')

@section('title', 'Manajemen Photo Slider')
@section('page_title', 'Photo Slider')

@section('content')
<div class="row">
    <!-- Upload Card -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title">
                    <i class="fas fa-cloud-upload-alt"></i> Upload Foto Baru
                </h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong>
                        <ul class="mb-0 mt-2">
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

                <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    <div class="form-group">
                        <label for="foto">Pilih Foto</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*" required>
                            <label class="custom-file-label" for="foto" data-browse="Browse">Pilih File...</label>
                        </div>
                        <small class="form-text text-muted">JPG, PNG, max 5MB</small>
                        @error('foto')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="progress" style="height: 25px; display: none;" id="uploadProgress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" id="progressBar" role="progressbar" style="width: 0%"></div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block mt-3">
                        <i class="fas fa-upload"></i> Upload Foto
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Stats Card -->
    
</div>

<!-- Gallery -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title">
                    <i class="fas fa-gallery"></i> Galeri Foto Slider
                </h3>
            </div>
            <div class="card-body">
                @if ($sliders->count() > 0)
                    <div class="row" id="sliderGallery">
                        @foreach ($sliders as $slider)
                            <div class="col-md-4 col-sm-6 mb-4" data-slider-id="{{ $slider->id }}">
                                <div class="card border">
                                    <img src="{{ asset($slider->file_path) }}" class="card-img-top" alt="{{ $slider->original_name }}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body p-2">
                                        <h6 class="card-title text-truncate" title="{{ $slider->original_name }}">
                                            {{ $slider->original_name }}
                                        </h6>
                                        <small class="text-muted d-block">{{ $slider->formatted_file_size }}</small>
                                        <small class="text-muted d-block">{{ $slider->created_at->format('d M Y') }}</small>
                                    </div>
                                    <div class="card-footer bg-white">
                                        <form method="POST" action="{{ route('slider.destroy', $slider->id) }}" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-block">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-images" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-muted mt-3">Belum ada foto slider. Silakan upload foto untuk memulai!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // File input label update
    $(document).on('change', '#foto', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });

    // Upload form handler
    $('#uploadForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        let uploadBtn = $(this).find('button[type="submit"]');
        let uploadProgress = $('#uploadProgress');
        let progressBar = $('#progressBar');

        uploadBtn.prop('disabled', true);
        uploadProgress.show();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        let percent = (e.loaded / e.total) * 100;
                        progressBar.css('width', percent + '%').attr('aria-valuenow', percent);
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                progressBar.css('width', '100%').attr('aria-valuenow', 100);
                setTimeout(() => {
                    location.reload();
                }, 1000);
            },
            error: function() {
                uploadProgress.hide();
                uploadBtn.prop('disabled', false);
                alert('Upload gagal! Silakan coba lagi.');
            }
        });
    });
</script>
@endsection
