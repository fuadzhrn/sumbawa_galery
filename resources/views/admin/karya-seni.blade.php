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
            <input type="text" placeholder="Cari karya..." class="form-control">
            <i class="fas fa-search"></i>
        </div>
        <select class="form-control" style="width: 150px;">
            <option value="">Semua Status</option>
            <option value="pending">Menunggu</option>
            <option value="approved">Diterima</option>
            <option value="rejected">Ditolak</option>
        </select>
        <select class="form-control" style="width: 150px;">
            <option value="">Semua Kategori</option>
            <option value="musik">Musik</option>
            <option value="rupa">Rupa</option>
            <option value="film">Film</option>
            <option value="tari">Tari Tradisional</option>
            <option value="kerajinan">Kerajinan Tangan</option>
        </select>
    </div>

    <!-- Tabel Karya Seni -->
    <div class="table-section">
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
                    <tr>
                        <td>1</td>
                        <td>Budi Santoso</td>
                        <td>Gambus Sumbawa Klasik</td>
                        <td><span class="badge badge-info">Musik</span></td>
                        <td>2024-03-01</td>
                        <td class="preview-cell">
                            <button class="btn-preview" title="Lihat Preview">
                                <i class="fas fa-image"></i>
                            </button>
                        </td>
                        <td><span class="status-badge status-pending">Menunggu</span></td>
                        <td>
                            <button class="btn-action btn-approve" title="Terima"><i class="fas fa-check"></i></button>
                            <button class="btn-action btn-view" title="Lihat"><i class="fas fa-eye"></i></button>
                            <button class="btn-action btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Siti Nurhaliza</td>
                        <td>Lukisan Pemandangan Pantai Kuta</td>
                        <td><span class="badge badge-success">Rupa</span></td>
                        <td>2024-02-28</td>
                        <td class="preview-cell">
                            <button class="btn-preview" title="Lihat Preview">
                                <i class="fas fa-image"></i>
                            </button>
                        </td>
                        <td><span class="status-badge status-approved">Diterima</span></td>
                        <td>
                            <button class="btn-action btn-view" title="Lihat"><i class="fas fa-eye"></i></button>
                            <button class="btn-action btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Ahmad Wijaya</td>
                        <td>Dokumenter Festival Bau Nyale</td>
                        <td><span class="badge badge-warning">Film</span></td>
                        <td>2024-02-25</td>
                        <td class="preview-cell">
                            <button class="btn-preview" title="Lihat Preview">
                                <i class="fas fa-video"></i>
                            </button>
                        </td>
                        <td><span class="status-badge status-approved">Diterima</span></td>
                        <td>
                            <button class="btn-action btn-view" title="Lihat"><i class="fas fa-eye"></i></button>
                            <button class="btn-action btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Dewi Lestari</td>
                        <td>Tarian Gandrung Sasak</td>
                        <td><span class="badge badge-secondary">Tari Tradisional</span></td>
                        <td>2024-02-20</td>
                        <td class="preview-cell">
                            <button class="btn-preview" title="Lihat Preview">
                                <i class="fas fa-video"></i>
                            </button>
                        </td>
                        <td><span class="status-badge status-pending">Menunggu</span></td>
                        <td>
                            <button class="btn-action btn-approve" title="Terima"><i class="fas fa-check"></i></button>
                            <button class="btn-action btn-view" title="Lihat"><i class="fas fa-eye"></i></button>
                            <button class="btn-action btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Rudi Hermawan</td>
                        <td>Batik Khas Sumbawa Motif Bulan Bintang</td>
                        <td><span class="badge badge-danger">Kerajinan Tangan</span></td>
                        <td>2024-02-18</td>
                        <td class="preview-cell">
                            <button class="btn-preview" title="Lihat Preview">
                                <i class="fas fa-image"></i>
                            </button>
                        </td>
                        <td><span class="status-badge status-approved">Diterima</span></td>
                        <td>
                            <button class="btn-action btn-view" title="Lihat"><i class="fas fa-eye"></i></button>
                            <button class="btn-action btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Maya Putri</td>
                        <td>Koleksi Lagu Tradisional Sumbawa</td>
                        <td><span class="badge badge-info">Musik</span></td>
                        <td>2024-02-15</td>
                        <td class="preview-cell">
                            <button class="btn-preview" title="Lihat Preview">
                                <i class="fas fa-music"></i>
                            </button>
                        </td>
                        <td><span class="status-badge status-pending">Menunggu</span></td>
                        <td>
                            <button class="btn-action btn-approve" title="Terima"><i class="fas fa-check"></i></button>
                            <button class="btn-action btn-view" title="Lihat"><i class="fas fa-eye"></i></button>
                            <button class="btn-action btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <button class="btn btn-sm btn-secondary">← Sebelumnya</button>
        <span class="page-info">Halaman 1 dari 2</span>
        <button class="btn btn-sm btn-secondary">Selanjutnya →</button>
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
                <div class="detail-preview">
                    <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="Preview Karya">
                </div>
                <div class="detail-info">
                    <div class="detail-row">
                        <div class="detail-field">
                            <label>Judul Karya</label>
                            <p>Gambus Sumbawa Klasik</p>
                        </div>
                        <div class="detail-field">
                            <label>Seniman</label>
                            <p>Budi Santoso</p>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-field">
                            <label>Kategori</label>
                            <p>Musik</p>
                        </div>
                        <div class="detail-field">
                            <label>Tanggal Diajukan</label>
                            <p>01 Maret 2024</p>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-field full-width">
                            <label>Deskripsi</label>
                            <p>Koleksi musik gambus tradisional Sumbawa yang indah, menampilkan keahlian saya dalam memainkan alat musik tradisional.</p>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-field">
                            <label>Status</label>
                            <p><span class="status-badge status-pending">Menunggu</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-success">Terima Karya</button>
            <button type="button" class="btn btn-danger">Tolak Karya</button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-karya-seni.css') }}">
@endpush
