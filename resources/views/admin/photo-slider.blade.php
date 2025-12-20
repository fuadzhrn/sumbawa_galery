@extends('layouts.admin')

@section('title', 'Manajemen Photo Slider')
@section('page_title', 'Photo Slider')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
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
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<!-- Gallery -->
<div class="row">
    <div class="col-12">
        <div class="mb-3">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahFotoModal">
                <i class="fas fa-plus"></i> Tambahkan Foto
            </button>
        </div>
        
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title">
                    <i class="fas fa-gallery"></i> Galeri Foto Slider
                </h3>
            </div>
            <div class="card-body">
                @if ($sliders->count() > 0)
                    <div class="table-responsive" id="sliderGallery">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">NO</th>
                                    <th style="width: 80px;">Preview</th>
                                    <th style="width: 120px;">Ukuran</th>
                                    <th style="width: 120px;">Upload</th>
                                    <th style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="sliderTableBody">
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3" id="paginationContainer">
                        <small id="pageInfo" class="text-muted"></small>
                        <div>
                            <button id="prevBtn" class="btn btn-sm btn-outline-secondary" onclick="previousPage()">
                                <i class="fas fa-chevron-left"></i> Sebelumnya
                            </button>
                            <button id="nextBtn" class="btn btn-sm btn-outline-primary" onclick="nextPage()">
                                Selanjutnya <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
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

<!-- Tambah Foto Modal -->
<div class="modal fade" id="tambahFotoModal" tabindex="-1" role="dialog" aria-labelledby="tambahFotoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahFotoLabel">Tambahkan Foto Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="foto">Pilih Foto</label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*" required>
                        <small class="form-text text-muted d-block mt-2">JPG, PNG, max 5MB</small>
                        @error('foto')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="progress" style="height: 25px; display: none;" id="uploadProgress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" id="progressBar" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Upload Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const ITEMS_PER_PAGE = 5;
    let allSliders = {!! json_encode($sliders->toArray()) !!};
    let currentPage = 1;
    const baseDeleteUrl = "{{ route('slider.destroy', '__ID__') }}".replace('__ID__', '');
    const csrfToken = "{{ csrf_token() }}";

    console.log('All Sliders:', allSliders);
    console.log('Sliders length:', allSliders.length);

    // Langsung render tanpa menunggu jQuery ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            renderPage(1);
        });
    } else {
        renderPage(1);
    }

    function renderPage(page) {
        console.log('renderPage called with page:', page);
        console.log('allSliders:', allSliders);
        console.log('allSliders.length:', allSliders.length);
        
        const totalPages = Math.ceil(allSliders.length / ITEMS_PER_PAGE);
        
        if (page < 1) page = 1;
        if (page > totalPages) page = totalPages;
        
        currentPage = page;

        const startIndex = (page - 1) * ITEMS_PER_PAGE;
        const endIndex = startIndex + ITEMS_PER_PAGE;
        const pageSliders = allSliders.slice(startIndex, endIndex);

        console.log('pageSliders for page', page, ':', pageSliders);
        console.log('totalPages:', totalPages, 'currentPage:', currentPage);

        let html = '';
        pageSliders.forEach((slider, index) => {
            const rowNumber = startIndex + index + 1;
            const deleteUrl = baseDeleteUrl + slider.id;
            const imagePath = "{{ asset('') }}" + slider.file_path;
            const fileName = slider.original_name.length > 30 ? slider.original_name.substring(0, 30) + '...' : slider.original_name;
            const fileSize = slider.formatted_file_size || 'N/A';
            const uploadDate = new Date(slider.created_at).toLocaleDateString('id-ID', {day: '2-digit', month: 'short', year: 'numeric'});
            
            console.log('Processing slider:', slider);
            
            html += `
                <tr data-slider-id="${slider.id}">
                    <td>${rowNumber}</td>
                    <td>
                        <img src="${imagePath}" alt="${slider.original_name}" style="width: 70px; height: 50px; object-fit: cover; border-radius: 4px; cursor: pointer;" onclick="viewImage('${imagePath}')">
                    </td>
                    <td>
                        <small class="text-muted">${fileSize}</small>
                    </td>
                    <td>
                        <small class="text-muted">${uploadDate}</small>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="deleteSlider(${slider.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        console.log('HTML content:', html);
        console.log('Trying to insert into #sliderTableBody');
        
        $('#sliderTableBody').html(html);

        console.log('Content inserted, current HTML:', $('#sliderTableBody').html());

        // Update pagination info
        $('#pageInfo').text(`Halaman ${currentPage} dari ${totalPages} (${allSliders.length} total)`);

        // Update button states - FIX: ensure buttons are properly disabled/enabled
        const isPrevDisabled = currentPage === 1 || allSliders.length === 0;
        const isNextDisabled = currentPage === totalPages || allSliders.length === 0;
        
        $('#prevBtn').prop('disabled', isPrevDisabled).css('opacity', isPrevDisabled ? '0.5' : '1');
        $('#nextBtn').prop('disabled', isNextDisabled).css('opacity', isNextDisabled ? '0.5' : '1');
        
        console.log('prevBtn disabled:', isPrevDisabled, 'nextBtn disabled:', isNextDisabled);
        console.log('renderPage completed');
    }

    function deleteSlider(sliderId) {
        console.log('deleteSlider called with sliderId:', sliderId);
        console.log('baseDeleteUrl:', baseDeleteUrl);
        
        if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
            const deleteUrl = baseDeleteUrl + sliderId;
            console.log('Delete URL:', deleteUrl);
            
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    console.log('Delete success:', response);
                    location.reload();
                },
                error: function(xhr) {
                    console.error('Delete error:', xhr);
                    console.error('Response status:', xhr.status);
                    console.error('Response text:', xhr.responseText);
                    alert('Gagal menghapus foto! Status: ' + xhr.status);
                }
            });
        }
    }

    function nextPage() {
        const totalPages = Math.ceil(allSliders.length / ITEMS_PER_PAGE);
        if (currentPage < totalPages) {
            console.log('Going to page:', currentPage + 1, 'of', totalPages);
            renderPage(currentPage + 1);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            console.log('Already at last page');
        }
    }

    function previousPage() {
        if (currentPage > 1) {
            console.log('Going to page:', currentPage - 1);
            renderPage(currentPage - 1);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            console.log('Already at first page');
        }
    }

    // Upload form handler dengan AJAX
    $('#uploadForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        let submitBtn = $('#submitBtn');
        let uploadProgress = $('#uploadProgress');
        let progressBar = $('#progressBar');

        submitBtn.prop('disabled', true);
        uploadProgress.show();
        progressBar.css('width', '0%').attr('aria-valuenow', 0);

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
            error: function(xhr) {
                uploadProgress.hide();
                submitBtn.prop('disabled', false);
                alert('Upload gagal! Silakan coba lagi.');
            }
        });
    });

    // View image modal
    function viewImage(imagePath) {
        if ($('#imageModal').length === 0) {
            $('body').append(`
                <div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <img id="modalImage" src="" class="w-100">
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }
        $('#modalImage').attr('src', imagePath);
        $('#imageModal').modal('show');
    }
</script>
@endsection
