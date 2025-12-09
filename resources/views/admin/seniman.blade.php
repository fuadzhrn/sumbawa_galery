@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manajemen Seniman</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Filter dan Search -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari seniman..." id="searchSeniman">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <select class="form-control" id="filterKategori">
                    <option value="">Semua Kategori</option>
                    @foreach(\App\Models\Kategori::all() as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Card Tabel Seniman -->
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">Daftar Seniman</h3>
                <div class="card-tools">
                    <span class="badge badge-primary" id="totalSenimanBadge">{{ $seniman->total() }} Seniman</span>
                </div>
            </div>
            <div class="card-body">
                @if($seniman->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Seniman</th>
                                <th>Email</th>
                                <th>Kategori</th>
                                <th>Bergabung</th>
                                <th style="width: 80px;">Karya</th>
                                <th style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($seniman as $key => $item)
                            <tr>
                                <td>{{ ($seniman->currentPage() - 1) * $seniman->perPage() + $key + 1 }}</td>
                                <td>
                                    <strong>{{ $item->nama }}</strong>
                                </td>
                                <td>{{ $item->user->email }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $item->kategori->nama }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                                <td class="text-center">
                                    <span class="badge badge-success">{{ $item->jumlah_karya }}</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info btn-view-seniman" data-seniman-id="{{ $item->id }}" data-seniman-nama="{{ $item->nama }}" data-seniman-email="{{ $item->user->email }}" data-seniman-kategori="{{ $item->kategori->nama }}" data-seniman-joined="{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}" data-seniman-karya="{{ $item->jumlah_karya }}" data-seniman-biografi="{{ $item->biografi }}">
                                        <i class="fas fa-eye"></i> Lihat
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger btn-delete-seniman" data-seniman-id="{{ $item->id }}" data-seniman-nama="{{ $item->nama }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($seniman->hasPages())
                <nav>
                    <ul class="pagination pagination-sm m-0 float-right">
                        @if($seniman->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">← Sebelumnya</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $seniman->previousPageUrl() }}">← Sebelumnya</a></li>
                        @endif

                        <li class="page-item disabled">
                            <span class="page-link">Hal {{ $seniman->currentPage() }} dari {{ $seniman->lastPage() }}</span>
                        </li>

                        @if($seniman->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $seniman->nextPageUrl() }}">Selanjutnya →</a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link">Selanjutnya →</span></li>
                        @endif
                    </ul>
                </nav>
                @endif
                @else
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle"></i> Belum ada data seniman
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Seniman -->
<div class="modal fade" id="detailSenimanModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detail Seniman</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Nama</label>
                        <p class="font-weight-bold" id="modal-nama"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Email</label>
                        <p class="font-weight-bold" id="modal-email"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Kategori</label>
                        <p><span class="badge badge-info" id="modal-kategori"></span></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Bergabung</label>
                        <p class="font-weight-bold" id="modal-joined"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="text-muted small">Biodata</label>
                        <p id="modal-biografi"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="text-muted small">Total Karya</label>
                        <p><span class="badge badge-success badge-lg" id="modal-karya" style="font-size: 16px;"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete Confirmation -->
<div class="modal fade" id="deleteSenimanModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Hapus Seniman</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus seniman <strong id="delete-nama"></strong>?</p>
                <p class="text-danger"><i class="fas fa-exclamation-triangle"></i> Tindakan ini tidak dapat dibatalkan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// View Detail
document.querySelectorAll('.btn-view-seniman').forEach(button => {
    button.addEventListener('click', function() {
        const nama = this.getAttribute('data-seniman-nama');
        const email = this.getAttribute('data-seniman-email');
        const kategori = this.getAttribute('data-seniman-kategori');
        const joined = this.getAttribute('data-seniman-joined');
        const karya = this.getAttribute('data-seniman-karya');
        const biografi = this.getAttribute('data-seniman-biografi');

        document.getElementById('modal-nama').textContent = nama;
        document.getElementById('modal-email').textContent = email;
        document.getElementById('modal-kategori').textContent = kategori;
        document.getElementById('modal-joined').textContent = joined;
        document.getElementById('modal-karya').textContent = karya;
        document.getElementById('modal-biografi').textContent = biografi || 'Belum ada biodata';

        $('#detailSenimanModal').modal('show');
    });
});

// Delete
document.querySelectorAll('.btn-delete-seniman').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-seniman-id');
        const nama = this.getAttribute('data-seniman-nama');

        document.getElementById('delete-nama').textContent = nama;
        document.getElementById('deleteForm').action = `/admin/seniman/${id}`;

        $('#deleteSenimanModal').modal('show');
    });
});
</script>
@endsection
