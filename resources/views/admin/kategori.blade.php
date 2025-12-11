@extends('layouts.admin')

@section('title', 'Manajemen Kategori')
@section('page_title', 'Manajemen Kategori')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title">Tambah Kategori Baru</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('kategori.store') }}" class="form-horizontal">
                    @csrf
                    <div class="form-group row">
                        <label for="nama_kategori" class="col-sm-2 col-form-label">Nama Kategori</label>
                        <div class="col-sm-10">
                            <input type="text" 
                                class="form-control @error('nama_kategori') is-invalid @enderror" 
                                id="nama_kategori" 
                                name="nama_kategori" 
                                placeholder="Contoh: Tari Tradisional"
                                value="{{ old('nama_kategori') }}"
                                required>
                            @error('nama_kategori')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Kategori
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title">Daftar Kategori Seni</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Nama Kategori</th>
                            <th style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $key => $kategori)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $kategori->nama }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info btn-edit" 
                                    data-kategori-id="{{ $kategori->id }}" 
                                    data-kategori-nama="{{ $kategori->nama }}"
                                    onclick="editKategori({{ $kategori->id }}, '{{ $kategori->nama }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form method="POST" action="{{ route('kategori.destroy', $kategori->id) }}" style="display: inline;" 
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada kategori. Silakan tambahkan kategori baru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <!-- Pagination -->
                @if($kategoris->hasPages())
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm m-0">
                        @if($kategoris->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">← Sebelumnya</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $kategoris->previousPageUrl() }}">← Sebelumnya</a></li>
                        @endif

                        <li class="page-item disabled">
                            <span class="page-link">Hal {{ $kategoris->currentPage() }} dari {{ $kategoris->lastPage() }}</span>
                        </li>

                        @if($kategoris->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $kategoris->nextPageUrl() }}">Selanjutnya →</a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link">Selanjutnya →</span></li>
                        @endif
                    </ul>
                </nav>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editKategoriModal" tabindex="-1" role="dialog" aria-labelledby="editKategoriLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKategoriLabel">Edit Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="editKategoriForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_nama">Nama Kategori</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama_kategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editKategori(id, nama) {
    document.getElementById('edit_nama').value = nama;
    document.getElementById('editKategoriForm').action = '/admin/kategori/' + id;
    $('#editKategoriModal').modal('show');
}
</script>
@endsection
