@extends('layouts.seniman')

@section('title', 'Karya Saya - Seniman')
@section('page_title', 'Karya Saya')

@section('extra_css')
    <style>
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5) !important;
        }

        .modal-content {
            border-radius: 8px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            border-bottom: none;
            border-radius: 8px 8px 0 0;
        }

        .modal-header .close {
            color: white;
            opacity: 0.8;
        }

        .modal-header .close:hover {
            opacity: 1;
        }

        .media-preview {
            max-width: 100%;
            max-height: 400px;
            border-radius: 8px;
            object-fit: cover;
        }

        .media-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .detail-row {
            margin-bottom: 15px;
        }

        .detail-label {
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 5px;
        }

        .detail-value {
            color: #666;
            line-height: 1.6;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #7f1d1d;
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Semua Karya Saya</h3>
                <div class="card-tools">
                    <a href="{{ route('seniman.upload') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> Upload Karya Baru
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($karyaSeni->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Views</th>
                              
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($karyaSeni as $key => $karya)
                            <tr>
                                <td>{{ ($karyaSeni->currentPage() - 1) * $karyaSeni->perPage() + $key + 1 }}</td>
                                <td>{{ $karya->judul }}</td>
                                <td><span class="badge badge-primary">{{ $karya->kategori->nama }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($karya->created_at)->format('d M Y') }}</td>
                                <td>
                                    @if($karya->status === 'pending')
                                        <span class="badge badge-warning">Menunggu</span>
                                    @elseif($karya->status === 'approved')
                                        <span class="badge badge-success">Diterima</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td><span class="badge badge-info">{{ $karya->views ?? 0 }}</span></td>
                               
                                <td>
                                    <button type="button" class="btn btn-sm btn-info btn-detail-karya" data-karya-id="{{ $karya->id }}">
                                        <i class="fas fa-eye"></i> Lihat
                                    </button>
                                    @if($karya->status === 'pending')
                                        <form method="POST" action="{{ route('seniman.karya.delete', $karya->id) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($karyaSeni->hasPages())
                <nav aria-label="Page navigation" style="margin-top: 20px;">
                    <ul class="pagination justify-content-center">
                        @if($karyaSeni->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">← Sebelumnya</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $karyaSeni->previousPageUrl() }}">← Sebelumnya</a>
                            </li>
                        @endif

                        <li class="page-item disabled">
                            <span class="page-link">Halaman {{ $karyaSeni->currentPage() }} dari {{ $karyaSeni->lastPage() }}</span>
                        </li>

                        @if($karyaSeni->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $karyaSeni->nextPageUrl() }}">Selanjutnya →</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Selanjutnya →</span>
                            </li>
                        @endif
                    </ul>
                </nav>
                @endif
                @else
                <div class="text-center py-5">
                    <i class="fas fa-image" style="font-size: 48px; color: #ccc; margin-bottom: 20px; display: block;"></i>
                    <h5>Belum Ada Karya</h5>
                    <p class="text-muted">Mulai bagikan karya seni Anda dengan memulai upload karya pertama</p>
                    <a href="{{ route('seniman.upload') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Upload Karya Pertama
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Detail Karya Modal -->
<div class="modal fade" id="detailKaryaModal" tabindex="-1" role="dialog" aria-labelledby="detailKaryaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailKaryaModalLabel">Detail Karya Seni</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBodyContent">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_js')
    <script>
        // Ensure jQuery and Bootstrap are loaded
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded');
        }
        if (typeof $ === 'undefined') {
            console.error('$ is not defined');
        }

        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, searching for detail buttons...');
            const detailButtons = document.querySelectorAll('.btn-detail-karya');
            console.log('Found ' + detailButtons.length + ' detail buttons');

            detailButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const karyaId = this.getAttribute('data-karya-id');
                    console.log('Button clicked, karya ID:', karyaId);
                    fetchKaryaDetail(karyaId);
                });
            });
        });

        function fetchKaryaDetail(karyaId) {
            const modalBodyContent = document.getElementById('modalBodyContent');
            console.log('fetchKaryaDetail called with ID:', karyaId);
            console.log('Modal body element:', modalBodyContent);
            
            // Show loading
            modalBodyContent.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            `;

            // Fetch data
            const fetchUrl = `/seniman/karya/${karyaId}`;
            console.log('Fetching from URL:', fetchUrl);
            
            fetch(fetchUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Failed to fetch karya detail - Status: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                renderKaryaDetail(data);
                // Use native Bootstrap modal
                if (typeof $ !== 'undefined' && $.fn.modal) {
                    console.log('Showing modal with jQuery');
                    $('#detailKaryaModal').modal('show');
                } else {
                    // Fallback for Bootstrap 5 or if jQuery not available
                    const modalEl = document.getElementById('detailKaryaModal');
                    if (modalEl && typeof bootstrap !== 'undefined') {
                        console.log('Showing modal with Bootstrap 5');
                        new bootstrap.Modal(modalEl).show();
                    } else {
                        console.log('No modal library available');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                modalBodyContent.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> Gagal memuat detail karya<br>
                        <small>${error.message}</small>
                    </div>
                `;
            });
        }

        function renderKaryaDetail(data) {
            console.log('renderKaryaDetail called with:', data);
            const modalBodyContent = document.getElementById('modalBodyContent');
            const modalTitle = document.getElementById('detailKaryaModalLabel');

            // Update modal title
            modalTitle.textContent = data.judul;

            // Determine status badge
            let statusClass = '';
            let statusText = '';
            if (data.status === 'pending') {
                statusClass = 'status-pending';
                statusText = 'Menunggu Persetujuan';
            } else if (data.status === 'approved') {
                statusClass = 'status-approved';
                statusText = 'Diterima';
            } else if (data.status === 'rejected') {
                statusClass = 'status-rejected';
                statusText = 'Ditolak';
            }

            // Build media preview
            let mediaPreview = '';
            const baseUrl = window.location.origin + '/';
            
            console.log('Media type:', data.media_type);
            console.log('Media path:', data.media_path);
            
            if (data.media_type === 'image' && data.media_path) {
                const imageSrc = baseUrl + data.media_path;
                console.log('Image src:', imageSrc);
                mediaPreview = `<img src="${imageSrc}" alt="${data.judul}" class="media-preview" onerror="console.log('Image load error'); this.src='{{ asset('assets/images/placeholder.jpg') }}'">`;
            } else if (data.media_type === 'video' && data.media_path) {
                const videoSrc = baseUrl + data.media_path;
                console.log('Video src:', videoSrc);
                mediaPreview = `<video width="100%" height="400" controls class="media-preview">
                    <source src="${videoSrc}" type="video/mp4">
                    Browser Anda tidak mendukung video.
                </video>`;
            } else if (data.media_type === 'youtube_link' && data.media_path) {
                try {
                    const url = new URL(data.media_path);
                    const videoId = url.searchParams.get('v') || data.media_path.split('/').pop();
                    console.log('YouTube ID:', videoId);
                    mediaPreview = `<iframe width="100%" height="400" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
                } catch (e) {
                    console.error('YouTube URL parse error:', e);
                    mediaPreview = `<p class="alert alert-danger">URL YouTube tidak valid</p>`;
                }
            } else {
                console.warn('No media preview available');
            }

            // Build HTML content
            const content = `
                <div class="media-container">
                    ${mediaPreview || '<span class="text-muted">Tidak ada media</span>'}
                </div>

                <div class="detail-row">
                    <div class="detail-label">Judul</div>
                    <div class="detail-value">${data.judul}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Kategori</div>
                    <div class="detail-value">${data.kategori.nama}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        <span class="status-badge ${statusClass}">${statusText}</span>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Deskripsi</div>
                    <div class="detail-value">${data.deskripsi || '-'}</div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="detail-row">
                            <div class="detail-label">Views</div>
                            <div class="detail-value">
                                <span class="badge badge-info">${data.views || 0}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-row">
                            <div class="detail-label">Likes</div>
                            <div class="detail-value">
                                <span class="badge badge-danger">${data.likes || 0}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-row">
                            <div class="detail-label">Tanggal</div>
                            <div class="detail-value">${formatDate(data.created_at)}</div>
                        </div>
                    </div>
                </div>

                ${data.alasan_penolakan ? `
                    <div class="alert alert-danger" style="margin-top: 20px;">
                        <strong>Alasan Penolakan:</strong><br>
                        ${data.alasan_penolakan}
                    </div>
                ` : ''}
            `;

            modalBodyContent.innerHTML = content;
        }

        function extractYoutubeId(url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            const match = url.match(regExp);
            return (match && match[2].length === 11) ? match[2] : '';
        }

        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }
    </script>
@endsection
