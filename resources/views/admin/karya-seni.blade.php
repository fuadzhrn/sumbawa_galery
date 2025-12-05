@extends('layouts.app')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Manajemen Karya Seni</h1>
        <p class="subtitle">Kelola karya seni yang diajukan seniman</p>
    </div>

    <!-- Filter dan Search -->
    <div class="filter-section">
        <div class="search-box">
            <input type="text" placeholder="Cari karya..." class="form-control" id="searchKarya">
            <i class="fas fa-search"></i>
        </div>
        <select class="form-control" style="width: 150px;" id="filterStatus">
            <option value="">Semua Status</option>
            <option value="pending">Menunggu</option>
            <option value="approved">Diterima</option>
            <option value="rejected">Ditolak</option>
        </select>
        <select class="form-control" style="width: 150px;" id="filterKategori">
            <option value="">Semua Kategori</option>
            @foreach(\App\Models\Kategori::all() as $kategori)
            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
            @endforeach
        </select>
    </div>

    <!-- Tabel Karya Seni -->
    <div class="table-section">
        @if($karyaSeni->count() > 0)
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Seniman</th>
                        <th>Judul Karya</th>
                        <th>Kategori</th>
                        <th>Tanggal Diajukan</th>
                        <th>Preview</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyaSeni as $key => $karya)
                    <tr>
                        <td>{{ ($karyaSeni->currentPage() - 1) * $karyaSeni->perPage() + $key + 1 }}</td>
                        <td>{{ $karya->user->name }}</td>
                        <td>{{ $karya->judul }}</td>
                        <td><span class="badge" style="background-color: #667eea; color: white;">{{ $karya->kategori->nama }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($karya->created_at)->format('d M Y') }}</td>
                        <td class="preview-cell">
                            <button type="button" class="btn-preview btn-preview-modal" title="Lihat Preview" data-karya-id="{{ $karya->id }}">
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
                                <span class="status-badge status-pending">Menunggu</span>
                            @elseif($karya->status === 'approved')
                                <span class="status-badge status-approved">Diterima</span>
                            @else
                                <span class="status-badge status-rejected">Ditolak</span>
                            @endif
                        </td>
                        <td class="action-cell">
                            <button type="button" class="btn-action-text btn-view btn-detail-modal" data-karya-id="{{ $karya->id }}"><i class="fas fa-eye"></i> Lihat</button>
                            @if($karya->status === 'pending')
                                <form method="POST" action="{{ route('admin.karya-seni.approve', $karya->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-action-text btn-approve"><i class="fas fa-check"></i> Terima</button>
                                </form>
                                <button type="button" class="btn-action-text btn-reject btn-reject-modal" data-karya-id="{{ $karya->id }}"><i class="fas fa-times"></i> Tolak</button>
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
        <div class="pagination">
            @if($karyaSeni->onFirstPage())
                <button class="btn btn-sm btn-secondary" disabled>← Sebelumnya</button>
            @else
                <a href="{{ $karyaSeni->previousPageUrl() }}" class="btn btn-sm btn-secondary">← Sebelumnya</a>
            @endif
            <span class="page-info">Halaman {{ $karyaSeni->currentPage() }} dari {{ $karyaSeni->lastPage() }}</span>
            @if($karyaSeni->hasMorePages())
                <a href="{{ $karyaSeni->nextPageUrl() }}" class="btn btn-sm btn-secondary">Selanjutnya →</a>
            @else
                <button class="btn btn-sm btn-secondary" disabled>Selanjutnya →</button>
            @endif
        </div>
        @endif
        @else
        <div style="padding: 60px 20px; text-align: center; color: #9ca3af;">
            <p style="font-size: 16px; margin: 0;">Belum ada karya seni yang diajukan</p>
        </div>
        @endif
    </div>
</div>

<!-- Modal Detail Karya -->
<div class="modal" id="detailKaryaModal">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <h2>Detail Karya Seni</h2>
            <button class="modal-close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="karya-detail">
                <div class="detail-preview" id="modal-preview">
                    <!-- Preview akan di-load oleh JavaScript -->
                </div>
                <div class="detail-info">
                    <div class="detail-row">
                        <div class="detail-field">
                            <label>Judul Karya</label>
                            <p id="modal-judul"></p>
                        </div>
                        <div class="detail-field">
                            <label>Seniman</label>
                            <p id="modal-seniman"></p>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-field">
                            <label>Kategori</label>
                            <p id="modal-kategori"></p>
                        </div>
                        <div class="detail-field">
                            <label>Tanggal Diajukan</label>
                            <p id="modal-tanggal"></p>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-field full-width">
                            <label>Deskripsi</label>
                            <p id="modal-deskripsi"></p>
                        </div>
                    </div>
                    <div class="detail-row" id="modal-alasan-section" style="display: none;">
                        <div class="detail-field full-width">
                            <label>Alasan Penolakan</label>
                            <p id="modal-alasan"></p>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-field">
                            <label>Status</label>
                            <p id="modal-status"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Media -->
<div class="modal" id="previewMediaModal">
    <div class="modal-content modal-preview">
        <div class="modal-header">
            <h2>Preview Media</h2>
            <button class="modal-close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" id="preview-content">
            <!-- Preview content akan di-load di sini -->
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div class="modal" id="rejectModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tolak Karya Seni</h2>
            <button class="modal-close" data-dismiss="modal">&times;</button>
        </div>
        <form method="POST" id="rejectForm">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="alasan_penolakan">Alasan Penolakan</label>
                    <textarea id="alasan_penolakan" name="alasan_penolakan" class="form-control" rows="5" placeholder="Berikan alasan mengapa karya ini ditolak..." required></textarea>
                </div>
            </div>
            <div class="modal-footer" style="padding: 20px; border-top: 1px solid #e5e7eb; display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Tolak Karya</button>
            </div>
        </form>
    </div>
</div>

<script>
// Open detail modal
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
                    statusBadge = '<span class="status-badge status-pending">Menunggu</span>';
                } else if (data.status === 'approved') {
                    statusBadge = '<span class="status-badge status-approved">Diterima</span>';
                } else {
                    statusBadge = '<span class="status-badge status-rejected">Ditolak</span>';
                }
                document.getElementById('modal-status').innerHTML = statusBadge;
                
                // Load preview thumbnail
                let preview = '';
                if (data.media_type === 'image' && data.thumbnail) {
                    preview = `<img src="{{ asset('') }}${data.thumbnail}" alt="${data.judul}" style="max-width: 100%; max-height: 300px; margin: 0 auto; display: block;" onerror="this.src='{{ asset('assets/images/placeholder.jpg') }}';">`;
                } else if (data.media_type === 'image' && data.media_path) {
                    preview = `<img src="{{ asset('') }}${data.media_path}" alt="${data.judul}" style="max-width: 100%; max-height: 300px; margin: 0 auto; display: block;" onerror="this.src='{{ asset('assets/images/placeholder.jpg') }}';">`;
                }
                document.getElementById('modal-preview').innerHTML = preview || '<p style="text-align: center; color: #999;">Tidak ada preview</p>';
                
                document.getElementById('detailKaryaModal').style.display = 'block';
            });
    });
});

// Open preview modal
document.querySelectorAll('.btn-preview-modal').forEach(button => {
    button.addEventListener('click', function() {
        const karyaId = this.getAttribute('data-karya-id');
        fetch(`/admin/karya-seni/${karyaId}`)
            .then(response => response.json())
            .then(data => {
                let content = '';
                if (data.media_type === 'image') {
                    content = `<img src="{{ asset('') }}${data.media_path}" alt="${data.judul}" style="max-width: 100%; max-height: 70vh; margin: 0 auto; display: block;" onerror="this.src='{{ asset('assets/images/placeholder.jpg') }}';">`;
                } else if (data.media_type === 'youtube_link') {
                    const url = new URL(data.media_path);
                    const videoId = url.searchParams.get('v') || data.media_path.split('/').pop();
                    content = `<iframe width="100%" height="600" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>`;
                } else if (data.media_type === 'video') {
                    content = `<video width="100%" height="600" controls><source src="{{ asset('') }}${data.media_path}"></video>`;
                } else {
                    content = `<p style="text-align: center; padding: 40px;">File: <a href="{{ asset('') }}${data.media_path}" target="_blank">${data.judul}</a></p>`;
                }
                document.getElementById('preview-content').innerHTML = content;
                document.getElementById('previewMediaModal').style.display = 'block';
            });
    });
});

// Open reject modal
document.querySelectorAll('.btn-reject-modal').forEach(button => {
    button.addEventListener('click', function() {
        const karyaId = this.getAttribute('data-karya-id');
        document.getElementById('rejectForm').action = `/admin/karya-seni/${karyaId}/reject`;
        document.getElementById('rejectModal').style.display = 'block';
    });
});

// Close modals
document.querySelectorAll('[data-dismiss="modal"]').forEach(button => {
    button.addEventListener('click', function() {
        document.querySelectorAll('.modal').forEach(modal => {
            modal.style.display = 'none';
        });
    });
});

// Close modal when clicking outside
document.querySelectorAll('.modal').forEach(modal => {
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>

<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    overflow-y: auto;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 0;
    border: 1px solid #888;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    width: 500px;
    max-height: 80vh;
    overflow-y: auto;
}

.modal-content.modal-lg {
    width: 700px;
}

.modal-content.modal-preview {
    width: 90%;
    max-width: 1000px;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #e5e7eb;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.modal-header h2 {
    margin: 0;
    font-size: 20px;
}

.modal-close {
    background: none;
    border: none;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    color: white;
}

.modal-close:hover {
    opacity: 0.8;
}

.modal-body {
    padding: 20px;
}

.karya-detail {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.detail-preview {
    background: #f3f4f6;
    border-radius: 8px;
    overflow: hidden;
    min-height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.detail-preview img,
.detail-preview video {
    max-width: 100%;
    max-height: 100%;
}

.detail-info {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.detail-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.detail-field {
    flex: 1;
}

.detail-field.full-width {
    grid-column: 1 / -1;
}

.detail-field label {
    display: block;
    font-weight: 600;
    color: #667eea;
    font-size: 13px;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.detail-field p {
    margin: 0;
    color: #374151;
    font-size: 14px;
    line-height: 1.5;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 12px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    font-size: 14px;
    font-family: inherit;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.status-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-pending {
    background-color: #fef08a;
    color: #854d0e;
}

.status-approved {
    background-color: #dcfce7;
    color: #166534;
}

.status-rejected {
    background-color: #fee2e2;
    color: #7f1d1d;
}

.action-cell {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.btn-action-text {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border: 1px solid #e5e7eb;
    background-color: #ffffff;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.btn-action-text:hover {
    background-color: #f9fafb;
    border-color: #d1d5db;
}

.btn-action-text.btn-view {
    color: #3b82f6;
    border-color: #93c5fd;
}

.btn-action-text.btn-view:hover {
    background-color: #eff6ff;
    border-color: #60a5fa;
}

.btn-action-text.btn-approve {
    color: #22c55e;
    border-color: #86efac;
}

.btn-action-text.btn-approve:hover {
    background-color: #f0fdf4;
    border-color: #4ade80;
}

.btn-action-text.btn-reject {
    color: #ef4444;
    border-color: #fca5a5;
}

.btn-action-text.btn-reject:hover {
    background-color: #fef2f2;
    border-color: #f87171;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-secondary {
    background-color: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background-color: #4b5563;
}

.btn-danger {
    background-color: #ef4444;
    color: white;
}

.btn-danger:hover {
    background-color: #dc2626;
}

.modal-footer {
    padding: 20px;
    border-top: 1px solid #e5e7eb;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}
</style>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-karya-seni.css') }}">
@endpush
