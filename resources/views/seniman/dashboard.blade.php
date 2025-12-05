@extends('layouts.app')

@section('title', 'Seniman Dashboard - Portal Karya Seniman Budaya Sumbawa')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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

        .modal-footer {
            padding: 20px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
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

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background-color: #5568d3;
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
        }

        .btn-small {
            padding: 8px 16px;
            font-size: 13px;
        }

        .works-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .works-table thead tr {
            background-color: #f3f4f6;
            border-bottom: 2px solid #e5e7eb;
        }

        .works-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            font-size: 13px;
            text-transform: uppercase;
        }

        .works-table td {
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }

        .works-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .btn-action {
            background: none;
            border: 1px solid #e5e7eb;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 4px;
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            background-color: #f3f4f6;
        }

        .btn-action.btn-view {
            color: #3b82f6;
        }

        .btn-action.btn-danger {
            color: #ef4444;
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

        .btn-action-text.btn-delete {
            color: #ef4444;
            border-color: #fca5a5;
        }

        .btn-action-text.btn-delete:hover {
            background-color: #fef2f2;
            border-color: #f87171;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
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
        .detail-preview video,
        .detail-preview iframe {
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

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 30px;
        }

        .page-info {
            padding: 0 15px;
            font-size: 14px;
            color: #6b7280;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 13px;
        }
    </style>
@endsection

@section('content')
<!-- PAGE HEADER -->
<div class="dashboard-header">
    <div class="header-top">
        <div>
            <h1 class="dashboard-title">Dashboard Seniman</h1>
            <p class="dashboard-subtitle">Kelola profil dan karya Anda</p>
        </div>
        <div class="user-info">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <span class="user-role">Seniman</span>
        </div>
    </div>
</div>

<!-- SUCCESS MESSAGE -->
@if (session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <p>{{ session('success') }}</p>
    </div>
@endif

<!-- DASHBOARD CONTENT -->
<div class="dashboard-content">
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                <i class="fas fa-image"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $totalKarya }}</h3>
                <p class="stat-label">Total Karya</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(34, 197, 94, 0.1); color: #22c55e;">
                <i class="fas fa-eye"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $totalViews }}</h3>
                <p class="stat-label">Total Views</p>
            </div>
        </div>

      

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(249, 115, 22, 0.1); color: #f97316;">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ Auth::user()->created_at->format('d M Y') }}</h3>
                <p class="stat-label">Bergabung Sejak</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <button type="button" class="btn btn-primary" id="btnUploadKarya">
            <i class="fas fa-plus"></i>
            Upload Karya Baru
        </button>
        <a href="#" class="btn btn-secondary">
            <i class="fas fa-user-circle"></i>
            Edit Profil
        </a>
        
    </div>

    <!-- Profile Card -->
    <div class="section-card">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="profile-info">
                    <h2>{{ Auth::user()->name }}</h2>
                    <p>{{ Auth::user()->email }}</p>
                    <div class="profile-stats">
                        <span><strong>{{ $totalKarya }}</strong> Karya</span>
                        <span><strong>{{ $totalViews }}</strong> Views</span>
                        <span><strong>{{ $totalLikes }}</strong> Likes</span>
                    </div>
                </div>
            </div>
            <button class="btn btn-secondary">
                <i class="fas fa-edit"></i>
                Edit Profil
            </button>
        </div>
    </div>

    <!-- Recent Works -->
    <div class="section-card">
        <div class="section-header">
            <h2>Karya Saya</h2>
            <button type="button" class="btn btn-small" id="btnTambahKarya">
                <i class="fas fa-plus"></i>
                Tambah Karya
            </button>
        </div>

        @if($karyaSeni->count() > 0)
        <div class="table-responsive">
            <table class="works-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Likes</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyaSeni as $key => $karya)
                    <tr>
                        <td>{{ ($karyaSeni->currentPage() - 1) * $karyaSeni->perPage() + $key + 1 }}</td>
                        <td>{{ $karya->judul }}</td>
                        <td><span class="badge" style="background-color: #667eea; color: white;">{{ $karya->kategori->nama }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($karya->created_at)->format('d M Y') }}</td>
                        <td>
                            @if($karya->status === 'pending')
                                <span class="status-badge status-pending">Menunggu</span>
                            @elseif($karya->status === 'approved')
                                <span class="status-badge status-approved">Diterima</span>
                            @else
                                <span class="status-badge status-rejected">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ $karya->views ?? 0 }}</td>
                        <td>{{ $karya->likes ?? 0 }}</td>
                        <td style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <button type="button" class="btn-action-text btn-view btn-detail-karya" data-karya-id="{{ $karya->id }}"><i class="fas fa-eye"></i> Lihat</button>
                            @if($karya->status === 'pending')
                                <form method="POST" action="{{ route('seniman.karya.delete', $karya->id) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-text btn-delete"><i class="fas fa-trash"></i> Hapus</button>
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
        <div class="pagination" style="margin-top: 20px;">
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
        <div class="empty-state">
            <i class="fas fa-image"></i>
            <h3>Belum Ada Karya</h3>
            <p>Mulai bagikan karya seni Anda dengan memulai upload karya pertama</p>
            <button type="button" class="btn btn-primary" id="btnUploadPertama">
                <i class="fas fa-plus"></i>
                Upload Karya Pertama
            </button>
        </div>
        @endif
    </div>
</div>

<!-- Modal Upload Karya -->
<div class="modal" id="uploadKaryaModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Upload Karya Baru</h2>
            <button class="modal-close" data-dismiss="modal">&times;</button>
        </div>
        <form method="POST" action="{{ route('seniman.karya.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="judul">Judul Karya *</label>
                    <input type="text" id="judul" name="judul" class="form-control" required placeholder="Masukkan judul karya Anda">
                </div>

                <div class="form-group">
                    <label for="kategori_id">Kategori *</label>
                    <select id="kategori_id" name="kategori_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" placeholder="Jelaskan tentang karya Anda"></textarea>
                </div>

                <div class="form-group">
                    <label for="media_type">Tipe Media *</label>
                    <select id="media_type" name="media_type" class="form-control" required onchange="updateMediaInput()">
                        <option value="">Pilih Tipe Media</option>
                        <option value="image">Gambar / Foto</option>
                        <option value="video">Video File</option>
                        <option value="youtube_link">Link YouTube</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Pilih Cara Upload *</label>
                    <div style="display: flex; gap: 15px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-weight: normal; cursor: pointer;">
                            <input type="radio" name="upload_method" value="file" onchange="updateMediaInput()"> Upload File
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; font-weight: normal; cursor: pointer;">
                            <input type="radio" name="upload_method" value="url" onchange="updateMediaInput()"> Paste Link
                        </label>
                    </div>
                </div>

                <div class="form-group" id="fileInputGroup" style="display: none;">
                    <label for="media_file" id="fileLabel">Upload File Media</label>
                    <input type="file" id="media_file" name="media_file" class="form-control">
                    <small style="color: #999;" id="fileHelp">Max 100MB untuk video, format: jpg/png untuk gambar, mp4 untuk video</small>
                </div>

                <div class="form-group" id="urlInputGroup" style="display: none;">
                    <label for="media_url" id="urlLabel">URL Media</label>
                    <input type="url" id="media_url" name="media_url" class="form-control" placeholder="https://...">
                    <small style="color: #999;" id="urlHelp">Paste URL lengkap media Anda</small>
                </div>

                <div class="form-group">
                    <label for="thumbnail">Thumbnail Gambar</label>
                    <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*">
                    <small style="color: #999;">Opsional - Ukuran max 2MB, untuk preview</small>
                </div>
            </div>
            <div class="modal-footer" style="padding: 20px; border-top: 1px solid #e5e7eb; display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Upload Karya</button>
            </div>
        </form>
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
                    <!-- Preview akan di-load -->
                </div>
                <div class="detail-info">
                    <div class="detail-row">
                        <div class="detail-field">
                            <label>Judul</label>
                            <p id="modal-judul"></p>
                        </div>
                        <div class="detail-field">
                            <label>Kategori</label>
                            <p id="modal-kategori"></p>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-field">
                            <label>Tanggal Diajukan</label>
                            <p id="modal-tanggal"></p>
                        </div>
                        <div class="detail-field">
                            <label>Status</label>
                            <p id="modal-status"></p>
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
                            <p id="modal-alasan" style="color: #dc2626;"></p>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-field">
                            <label>Views</label>
                            <p id="modal-views"></p>
                        </div>
                        <div class="detail-field">
                            <label>Likes</label>
                            <p id="modal-likes"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Logout Button di Sidebar -->
@section('extra-js')
    <script>
        // Open upload modal
        document.getElementById('btnUploadKarya')?.addEventListener('click', () => {
            document.getElementById('uploadKaryaModal').style.display = 'block';
        });
        document.getElementById('btnTambahKarya')?.addEventListener('click', () => {
            document.getElementById('uploadKaryaModal').style.display = 'block';
        });
        document.getElementById('btnUploadPertama')?.addEventListener('click', () => {
            document.getElementById('uploadKaryaModal').style.display = 'block';
        });

        // Update media input based on type
        function updateMediaInput() {
            const mediaType = document.getElementById('media_type').value;
            const uploadMethod = document.querySelector('input[name="upload_method"]:checked');
            const fileInputGroup = document.getElementById('fileInputGroup');
            const urlInputGroup = document.getElementById('urlInputGroup');
            const fileLabel = document.getElementById('fileLabel');
            const urlLabel = document.getElementById('urlLabel');
            const urlHelp = document.getElementById('urlHelp');

            // Reset visibility
            fileInputGroup.style.display = 'none';
            urlInputGroup.style.display = 'none';

            if (!mediaType) return;

            // Determine upload method (default to file for image/video, url for youtube)
            let method = uploadMethod ? uploadMethod.value : (mediaType === 'youtube_link' ? 'url' : 'file');
            
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
                urlInputGroup.style.display = 'none';
                
                if (mediaType === 'image') {
                    fileLabel.textContent = 'Upload Gambar';
                    document.getElementById('fileHelp').textContent = 'Format: JPG, PNG, max 5MB';
                    document.getElementById('media_file').accept = 'image/*';
                } else if (mediaType === 'video') {
                    fileLabel.textContent = 'Upload Video';
                    document.getElementById('fileHelp').textContent = 'Format: MP4, max 100MB';
                    document.getElementById('media_file').accept = 'video/*';
                }
                document.getElementById('media_file').required = true;
                document.getElementById('media_url').required = false;
            } else {
                fileInputGroup.style.display = 'none';
                urlInputGroup.style.display = 'block';
                
                if (mediaType === 'youtube_link') {
                    urlLabel.textContent = 'URL YouTube';
                    urlHelp.textContent = 'Contoh: https://www.youtube.com/watch?v=dQw4w9WgXcQ';
                } else if (mediaType === 'image') {
                    urlLabel.textContent = 'URL Gambar';
                    urlHelp.textContent = 'Paste URL gambar dari internet';
                } else if (mediaType === 'video') {
                    urlLabel.textContent = 'URL Video';
                    urlHelp.textContent = 'Paste URL video dari internet';
                }
                document.getElementById('media_file').required = false;
                document.getElementById('media_url').required = true;
            }
        }

        // Open detail modal
        document.querySelectorAll('.btn-detail-karya').forEach(button => {
            button.addEventListener('click', function() {
                const karyaId = this.getAttribute('data-karya-id');
                fetch(`/seniman/karya/${karyaId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('modal-judul').textContent = data.judul;
                        document.getElementById('modal-kategori').textContent = data.kategori.nama;
                        document.getElementById('modal-tanggal').textContent = new Date(data.created_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
                        document.getElementById('modal-deskripsi').textContent = data.deskripsi || 'Tidak ada deskripsi';
                        document.getElementById('modal-views').textContent = data.views || 0;
                        document.getElementById('modal-likes').textContent = data.likes || 0;

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

                        let preview = '';
                        if (data.media_type === 'image' && data.media_path) {
                            preview = `<img src="{{ asset('') }}${data.media_path}" alt="${data.judul}" style="max-width: 100%; max-height: 300px; margin: 0 auto; display: block;" onerror="this.src='{{ asset('assets/images/placeholder.jpg') }}';">`;
                        } else if (data.media_type === 'youtube_link' && data.media_path) {
                            const url = new URL(data.media_path);
                            const videoId = url.searchParams.get('v') || data.media_path.split('/').pop();
                            preview = `<iframe width="100%" height="300" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>`;
                        } else if (data.media_type === 'video' && data.media_path) {
                            preview = `<video width="100%" height="300" controls><source src="{{ asset('') }}${data.media_path}"></video>`;
                        } else {
                            preview = '<p style="text-align: center; color: #999;">Tidak ada preview</p>';
                        }
                        document.getElementById('modal-preview').innerHTML = preview;

                        document.getElementById('detailKaryaModal').style.display = 'block';
                    });
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

        // Tambahkan logout button ke sidebar jika belum ada
        document.addEventListener('DOMContentLoaded', function() {
            const navMenu = document.querySelector('.nav-menu');
            if (navMenu && !navMenu.querySelector('.logout-item')) {
                const logoutItem = document.createElement('li');
                logoutItem.className = 'nav-item logout-item';
                logoutItem.style.marginTop = 'auto';
                logoutItem.style.borderTop = '1px solid var(--border-color)';
                logoutItem.innerHTML = `
                    <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                        @csrf
                        <button type="submit" class="nav-link" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                            <i class="fas fa-sign-out-alt" style="margin-right: 0.5rem;"></i>
                            Logout
                        </button>
                    </form>
                `;
                navMenu.appendChild(logoutItem);
            }
        });
    </script>
@endsection
@endsection
