@extends('layouts.app')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Manajemen Kategori Seni</h1>
        <p class="subtitle">Kelola kategori seni yang tersedia di portal</p>
    </div>

    <!-- Form Tambah Kategori -->
    <div class="form-section">
        <h2>Tambah Kategori Baru</h2>
        <form class="kategori-form" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="nama_kategori">Nama Kategori</label>
                    <input type="text" id="nama_kategori" name="nama_kategori" class="form-control" placeholder="Contoh: Tari Tradisional" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi (Opsional)</label>
                    <input type="text" id="deskripsi" name="deskripsi" class="form-control" placeholder="Penjelasan singkat kategori">
                </div>
                <button type="submit" class="btn btn-primary" style="align-self: flex-end;">Tambah Kategori</button>
            </div>
        </form>
    </div>

    <!-- Daftar Kategori -->
    <div class="table-section">
        <h2>Daftar Kategori Seni</h2>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Karya</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Musik</td>
                        <td>Karya seni musik tradisional dan kontemporer Sumbawa</td>
                        <td class="text-center"><span class="badge badge-primary">12</span></td>
                        <td>2024-01-15</td>
                        <td>
                            <button class="btn-action btn-edit" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn-action btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Rupa</td>
                        <td>Seni rupa, lukisan, dan patung dari seniman Sumbawa</td>
                        <td class="text-center"><span class="badge badge-primary">18</span></td>
                        <td>2024-01-15</td>
                        <td>
                            <button class="btn-action btn-edit" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn-action btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Film</td>
                        <td>Dokumenter dan film cerita tentang budaya Sumbawa</td>
                        <td class="text-center"><span class="badge badge-primary">5</span></td>
                        <td>2024-01-15</td>
                        <td>
                            <button class="btn-action btn-edit" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn-action btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Tari Tradisional</td>
                        <td>Tarian budaya dan pertunjukan tradisional Sumbawa</td>
                        <td class="text-center"><span class="badge badge-primary">8</span></td>
                        <td>2024-02-20</td>
                        <td>
                            <button class="btn-action btn-edit" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn-action btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Kerajinan Tangan</td>
                        <td>Produk kerajinan dan batik khas Sumbawa</td>
                        <td class="text-center"><span class="badge badge-primary">15</span></td>
                        <td>2024-02-22</td>
                        <td>
                            <button class="btn-action btn-edit" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn-action btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div class="modal" id="editKategoriModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Kategori</h2>
            <button class="modal-close" data-dismiss="modal">&times;</button>
        </div>
        <form class="modal-body" method="POST">
            @csrf
            <div class="form-group">
                <label for="edit_nama">Nama Kategori</label>
                <input type="text" id="edit_nama" name="nama_kategori" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_deskripsi">Deskripsi</label>
                <textarea id="edit_deskripsi" name="deskripsi" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-kategori.css') }}">
@endpush
