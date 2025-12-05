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
            <input type="text" placeholder="Cari seniman..." class="form-control" id="searchSeniman">
            <i class="fas fa-search"></i>
        </div>
        <select class="form-control" style="width: 150px;" id="filterKategori">
            <option value="">Semua Kategori</option>
            @foreach(\App\Models\Kategori::all() as $kategori)
            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
            @endforeach
        </select>
    </div>

    <!-- Tabel Seniman -->
    <div class="table-section">
        @if($seniman->count() > 0)
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Seniman</th>
                        <th>Email</th>
                        <th>Kategori</th>
                        <th>Tanggal Bergabung</th>
                        <th>Jumlah Karya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($seniman as $key => $item)
                    <tr>
                        <td>{{ ($seniman->currentPage() - 1) * $seniman->perPage() + $key + 1 }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->user->email }}</td>
                        <td><span class="badge" style="background-color: #667eea; color: white;">{{ $item->kategori->nama }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                        <td class="text-center"><strong>{{ $item->jumlah_karya }}</strong></td>
                        <td>
                            <button type="button" class="btn-action btn-view btn-view-seniman" title="Lihat Detail" data-seniman-id="{{ $item->id }}" data-seniman-nama="{{ $item->nama }}" data-seniman-email="{{ $item->user->email }}" data-seniman-kategori="{{ $item->kategori->nama }}" data-seniman-joined="{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}" data-seniman-karya="{{ $item->jumlah_karya }}" data-seniman-biografi="{{ $item->biografi }}">Lihat</button>
                            <form method="POST" action="{{ route('admin.seniman.destroy', $item->id) }}" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seniman ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-danger" title="Hapus">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($seniman->hasPages())
        <div class="pagination">
            @if($seniman->onFirstPage())
                <button class="btn btn-sm btn-secondary" disabled>← Sebelumnya</button>
            @else
                <a href="{{ $seniman->previousPageUrl() }}" class="btn btn-sm btn-secondary">← Sebelumnya</a>
            @endif
            <span class="page-info">Halaman {{ $seniman->currentPage() }} dari {{ $seniman->lastPage() }}</span>
            @if($seniman->hasMorePages())
                <a href="{{ $seniman->nextPageUrl() }}" class="btn btn-sm btn-secondary">Selanjutnya →</a>
            @else
                <button class="btn btn-sm btn-secondary" disabled>Selanjutnya →</button>
            @endif
        </div>
        @endif
        @else
        <div style="padding: 60px 20px; text-align: center; color: #9ca3af;">
            <p style="font-size: 16px; margin: 0;">Belum ada data seniman</p>
        </div>
        @endif
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
                        <p id="modal-nama"></p>
                    </div>
                    <div class="detail-field">
                        <label>Email</label>
                        <p id="modal-email"></p>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-field">
                        <label>Kategori</label>
                        <p id="modal-kategori"></p>
                    </div>
                    <div class="detail-field">
                        <label>Tanggal Bergabung</label>
                        <p id="modal-joined"></p>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-field full-width">
                        <label>Biodata</label>
                        <p id="modal-biografi"></p>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-field">
                        <label>Total Karya</label>
                        <p><strong id="modal-karya"></strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.btn-view-seniman').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-seniman-id');
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

        document.getElementById('detailSenimanModal').style.display = 'block';
    });
});

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('detailSenimanModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

// Close modal when clicking close button
document.querySelectorAll('[data-dismiss="modal"]').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('detailSenimanModal').style.display = 'none';
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
    overflow: auto;
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
    width: 600px;
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

.seniman-detail {
    margin: 0;
}

.detail-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
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
</style>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-seniman.css') }}">
@endpush
