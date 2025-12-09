@extends('layouts.seniman')

@section('title', 'Status Approval - Seniman')

@section('extra_css')
    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .badge {
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
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
            background-color: #d1fae5;
            color: #065f46;
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Karya yang Diterima</h3>
                <div class="card-tools">
                    <span class="badge badge-success">
                        <i class="fas fa-check-circle"></i> Total: {{ $karyaSeni->total() }}
                    </span>
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
                                <th>Tanggal Diajukan</th>
                                <th>Tanggal Diterima</th>
                                <th>Views</th>
                               
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($karyaSeni as $key => $karya)
                            <tr>
                                <td>{{ ($karyaSeni->currentPage() - 1) * $karyaSeni->perPage() + $key + 1 }}</td>
                                <td>
                                    <strong>{{ $karya->judul }}</strong>
                                </td>
                                <td><span class="badge badge-primary">{{ $karya->kategori->nama }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($karya->created_at)->format('d M Y') }}</td>
                                <td>
                                    @if($karya->updated_at && $karya->updated_at != $karya->created_at)
                                        <span class="badge badge-success">
                                            <i class="fas fa-calendar-check"></i> {{ \Carbon\Carbon::parse($karya->updated_at)->format('d M Y') }}
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">-</span>
                                    @endif
                                </td>
                                <td><span class="badge badge-info">{{ $karya->views ?? 0 }}</span></td>
                              
                                <td>
                                    <button type="button" class="btn btn-sm btn-info btn-detail-karya" data-karya-id="{{ $karya->id }}" title="Lihat Detail">
                                        <i class="fas fa-eye"></i> Lihat
                                    </button>
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
                    <i class="fas fa-check-circle" style="font-size: 48px; color: #ccc; margin-bottom: 20px; display: block;"></i>
                    <h5>Belum Ada Karya yang Diterima</h5>
                    <p class="text-muted">Tunggu persetujuan admin untuk karya Anda</p>
                    <a href="{{ route('seniman.karya') }}" class="btn btn-primary">
                        <i class="fas fa-list"></i> Lihat Semua Karya
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
                        <span class="status-badge">Diterima</span>
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
                            <div class="detail-label">Diajukan</div>
                            <div class="detail-value">${formatDate(data.created_at)}</div>
                        </div>
                    </div>
                </div>
            `;

            modalBodyContent.innerHTML = content;
        }

        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }
    </script>
@endsection
