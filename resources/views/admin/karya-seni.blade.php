@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manajemen Karya Seni</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Filter dan Search -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari karya..." id="searchKarya">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="approved">Diterima</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="filterKategori">
                    <option value="">Semua Kategori</option>
                    @foreach(\App\Models\Kategori::all() as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Card Tabel Karya Seni -->
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">Daftar Karya Seni</h3>
                <div class="card-tools">
                    <span class="badge badge-primary" id="totalKaryaBadge">{{ $karyaSeni->total() }} Karya</span>
                </div>
            </div>
            <div class="card-body">
                @if($karyaSeni->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Seniman</th>
                                <th>Judul Karya</th>
                                <th>Kategori</th>
                                <th>Diajukan</th>
                                <th style="width: 80px;">Media</th>
                                <th>Status</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($karyaSeni as $key => $karya)
                            <tr>
                                <td>{{ ($karyaSeni->currentPage() - 1) * $karyaSeni->perPage() + $key + 1 }}</td>
                                <td><strong>{{ $karya->user->name }}</strong></td>
                                <td>{{ Str::limit($karya->judul, 25) }}</td>
                                <td><span class="badge badge-info">{{ $karya->kategori->nama }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($karya->created_at)->format('d M Y') }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-preview-modal" data-karya-id="{{ $karya->id }}">
                                        @if($karya->media_type === 'image')
                                            <i class="fas fa-image"></i>
                                        @elseif($karya->media_type === 'youtube_link')
                                            <i class="fas fa-video"></i>
                                        @else
                                            <i class="fas fa-file"></i>
                                        @endif
                                    </button>
                                </td>
                                <td>
                                    @if($karya->status === 'pending')
                                        <span class="badge badge-warning">Menunggu</span>
                                    @elseif($karya->status === 'approved')
                                        <span class="badge badge-success">Diterima</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info btn-detail-modal" data-karya-id="{{ $karya->id }}">
                                        <i class="fas fa-eye"></i> Lihat
                                    </button>
                                    @if($karya->status === 'pending')
                                        <form method="POST" action="{{ route('admin.karya-seni.approve', $karya->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-danger btn-reject-modal" data-karya-id="{{ $karya->id }}">
                                            <i class="fas fa-times"></i>
                                        </button>
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
                <nav>
                    <ul class="pagination pagination-sm m-0 float-right">
                        @if($karyaSeni->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">← Sebelumnya</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $karyaSeni->previousPageUrl() }}">← Sebelumnya</a></li>
                        @endif

                        <li class="page-item disabled">
                            <span class="page-link">Hal {{ $karyaSeni->currentPage() }} dari {{ $karyaSeni->lastPage() }}</span>
                        </li>

                        @if($karyaSeni->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $karyaSeni->nextPageUrl() }}">Selanjutnya →</a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link">Selanjutnya →</span></li>
                        @endif
                    </ul>
                </nav>
                @endif
                @else
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle"></i> Belum ada karya seni yang diajukan
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Karya -->
<div class="modal fade" id="detailKaryaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detail Karya Seni</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="text-center">
                            <img id="modal-preview" src="" alt="Preview" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small">Judul Karya</label>
                            <p class="font-weight-bold" id="modal-judul"></p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Seniman</label>
                            <p class="font-weight-bold" id="modal-seniman"></p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Kategori</label>
                            <p><span class="badge badge-info" id="modal-kategori"></span></p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Diajukan</label>
                            <p class="font-weight-bold" id="modal-tanggal"></p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Status</label>
                            <p id="modal-status"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="text-muted small">Deskripsi</label>
                        <p id="modal-deskripsi"></p>
                    </div>
                </div>
                <div class="row" id="modal-alasan-section" style="display: none;">
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            <label class="text-muted small">Alasan Penolakan</label>
                            <p id="modal-alasan" class="mb-0"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Media -->
<div class="modal fade" id="previewMediaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Preview Media</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="preview-content" style="padding: 30px; text-align: center;">
                <!-- Preview content akan di-load di sini -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Tolak Karya Seni</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="rejectForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="alasan_penolakan">Alasan Penolakan</label>
                        <textarea id="alasan_penolakan" name="alasan_penolakan" class="form-control" rows="5" placeholder="Berikan alasan mengapa karya ini ditolak..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Karya</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// View Detail
document.querySelectorAll('.btn-detail-modal').forEach(button => {
    button.addEventListener('click', function() {
        const karyaId = this.getAttribute('data-karya-id');
        fetch(`/admin/karya-seni/${karyaId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modal-judul').textContent = data.judul;
                document.getElementById('modal-seniman').textContent = data.user.name;
                document.getElementById('modal-kategori').textContent = data.kategori.nama;
                document.getElementById('modal-tanggal').textContent = new Date(data.created_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
                document.getElementById('modal-deskripsi').textContent = data.deskripsi || 'Tidak ada deskripsi';
                
                if (data.status === 'rejected' && data.alasan_penolakan) {
                    document.getElementById('modal-alasan-section').style.display = 'block';
                    document.getElementById('modal-alasan').textContent = data.alasan_penolakan;
                } else {
                    document.getElementById('modal-alasan-section').style.display = 'none';
                }
                
                let statusBadge = '';
                if (data.status === 'pending') {
                    statusBadge = '<span class="badge badge-warning">Menunggu</span>';
                } else if (data.status === 'approved') {
                    statusBadge = '<span class="badge badge-success">Diterima</span>';
                } else {
                    statusBadge = '<span class="badge badge-danger">Ditolak</span>';
                }
                document.getElementById('modal-status').innerHTML = statusBadge;
                
                // Set preview image
                const baseUrl = window.location.origin + '/';
                if (data.media_type === 'image' && data.media_path) {
                    document.getElementById('modal-preview').src = baseUrl + data.media_path;
                } else if (data.thumbnail) {
                    document.getElementById('modal-preview').src = baseUrl + data.thumbnail;
                } else {
                    document.getElementById('modal-preview').src = "{{ asset('assets/images/placeholder.jpg') }}";
                }
                
                $('#detailKaryaModal').modal('show');
            })
            .catch(error => {
                console.error('Error fetching karya:', error);
                alert('Gagal memuat detail karya');
            });
    });
});

// Preview Media
document.querySelectorAll('.btn-preview-modal').forEach(button => {
    button.addEventListener('click', function() {
        const karyaId = this.getAttribute('data-karya-id');
        fetch(`/admin/karya-seni/${karyaId}`)
            .then(response => response.json())
            .then(data => {
                let content = '';
                const baseUrl = window.location.origin + '/';
                
                if (data.media_type === 'image') {
                    const imageSrc = baseUrl + data.media_path;
                    content = `<img src="${imageSrc}" alt="${data.judul}" class="img-fluid rounded" style="max-width: 100%;" onerror="this.src='{{ asset('assets/images/placeholder.jpg') }}'">`;
                } else if (data.media_type === 'youtube_link') {
                    try {
                        const url = new URL(data.media_path);
                        const videoId = url.searchParams.get('v') || data.media_path.split('/').pop();
                        content = `<iframe width="100%" height="600" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>`;
                    } catch (e) {
                        content = `<p class="alert alert-danger">URL YouTube tidak valid</p>`;
                    }
                } else if (data.media_type === 'video') {
                    const videoSrc = baseUrl + data.media_path;
                    content = `<video width="100%" height="600" controls><source src="${videoSrc}"></video>`;
                } else {
                    const fileSrc = baseUrl + data.media_path;
                    content = `<p><a href="${fileSrc}" target="_blank" class="btn btn-primary"><i class="fas fa-download"></i> Unduh ${data.judul}</a></p>`;
                }
                document.getElementById('preview-content').innerHTML = content;
                $('#previewMediaModal').modal('show');
            })
            .catch(error => {
                console.error('Error fetching karya:', error);
                alert('Gagal memuat preview media');
            });
    });
});

// Reject Modal
document.querySelectorAll('.btn-reject-modal').forEach(button => {
    button.addEventListener('click', function() {
        const karyaId = this.getAttribute('data-karya-id');
        document.getElementById('rejectForm').action = `/admin/karya-seni/${karyaId}/reject`;
        $('#rejectModal').modal('show');
    });
});
</script>
@endsection
