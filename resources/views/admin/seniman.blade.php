@extends('layouts.app')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Manajemen Seniman</h1>
        <p class="subtitle">Kelola data seniman yang terdaftar di portal</p>
    </div>

    <!-- Filter dan Search -->
    <div class="filter-section">
        <div class="search-box">
            <input type="text" placeholder="Cari seniman..." class="form-control">
            <i class="fas fa-search"></i>
        </div>
        <select class="form-control" style="width: 150px;">
            <option value="">Semua Kategori</option>
            <option value="musik">Musik</option>
            <option value="rupa">Rupa</option>
            <option value="film">Film</option>
            <option value="tari">Tari Tradisional</option>
            <option value="kerajinan">Kerajinan Tangan</option>
        </select>
    </div>

    <!-- Tabel Seniman -->
    <div class="table-section">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Seniman</th>
                        <th>Email/Username</th>
                        <th>Kategori</th>
                        <th>Tanggal Bergabung</th>
                        <th>Jumlah Karya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Budi Santoso</td>
                        <td>budi.santoso@email.com</td>
                        <td><span class="badge badge-info">Musik</span></td>
                        <td>2024-01-10</td>
                        <td class="text-center"><strong>5</strong></td>
                        <td>
                            <button class="btn-action btn-view" title="Lihat Detail"><i class="fas fa-eye"></i></button>
                            <button class="btn-action btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Siti Nurhaliza</td>
                        <td>siti.nurhaliza@email.com</td>
                        <td><span class="badge badge-success">Rupa</span></td>
                        <td>2024-01-12</td>
                        <td class="text-center"><strong>8</strong></td>
                        <td>
                            <button class="btn-action btn-view" title="Lihat Detail"><i class="fas fa-eye"></i></button>
                            <button class="btn-action btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Ahmad Wijaya</td>
                        <td>ahmad.wijaya@email.com</td>
                        <td><span class="badge badge-warning">Film</span></td>
                        <td>2024-01-20</td>
                        <td class="text-center"><strong>3</strong></td>
                        <td>
                            <button class="btn-action btn-view" title="Lihat Detail"><i class="fas fa-eye"></i></button>
                            <button class="btn-action btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Dewi Lestari</td>
                        <td>dewi.lestari@email.com</td>
                        <td><span class="badge badge-secondary">Tari Tradisional</span></td>
                        <td>2024-02-05</td>
                        <td class="text-center"><strong>6</strong></td>
                        <td>
                            <button class="btn-action btn-view" title="Lihat Detail"><i class="fas fa-eye"></i></button>
                            <button class="btn-action btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Rudi Hermawan</td>
                        <td>rudi.hermawan@email.com</td>
                        <td><span class="badge badge-danger">Kerajinan Tangan</span></td>
                        <td>2024-02-15</td>
                        <td class="text-center"><strong>4</strong></td>
                        <td>
                            <button class="btn-action btn-view" title="Lihat Detail"><i class="fas fa-eye"></i></button>
                            <button class="btn-action btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Maya Putri</td>
                        <td>maya.putri@email.com</td>
                        <td><span class="badge badge-info">Musik</span></td>
                        <td>2024-02-18</td>
                        <td class="text-center"><strong>7</strong></td>
                        <td>
                            <button class="btn-action btn-view" title="Lihat Detail"><i class="fas fa-eye"></i></button>
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
        <span class="page-info">Halaman 1 dari 1</span>
        <button class="btn btn-sm btn-secondary">Selanjutnya →</button>
    </div>
</div>

<!-- Modal Detail Seniman -->
<div class="modal" id="detailSenimanModal">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <h2>Detail Seniman</h2>
            <button class="modal-close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="seniman-detail">
                <div class="detail-row">
                    <div class="detail-field">
                        <label>Nama</label>
                        <p>Budi Santoso</p>
                    </div>
                    <div class="detail-field">
                        <label>Email</label>
                        <p>budi.santoso@email.com</p>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-field">
                        <label>Kategori</label>
                        <p>Musik</p>
                    </div>
                    <div class="detail-field">
                        <label>Tanggal Bergabung</label>
                        <p>10 Januari 2024</p>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-field full-width">
                        <label>Biodata</label>
                        <p>Seorang musisi berbakat yang khusus dalam musik tradisional Sumbawa. Telah memenangkan berbagai penghargaan nasional.</p>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-field">
                        <label>Total Karya</label>
                        <p><strong>5</strong></p>
                    </div>
                    <div class="detail-field">
                        <label>Status</label>
                        <p><span class="badge badge-success">Aktif</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-seniman.css') }}">
@endpush
