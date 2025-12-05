@extends('layouts.app')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Manajemen Kategori Seni</h1>
        <p class="subtitle">Kelola kategori seni yang tersedia di portal</p>
    </div>

    <!-- Form Tambah Kategori -->
    <div class="form-section" style="background: white; padding: 40px; border-radius: 15px; margin-bottom: 40px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.15); border-left: 6px solid #667eea;">
        <h2 style="font-size: 22px; font-weight: 800; color: #1f2937; margin: 0 0 30px 0; display: flex; align-items: center;"><span style="display: inline-block; width: 5px; height: 26px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 3px; margin-right: 15px;"></span>Tambah Kategori Baru</h2>
        <form class="kategori-form" method="POST" action="{{ route('kategori.store') }}">
            @csrf
            <div class="form-row" style="display: grid; grid-template-columns: 1fr auto; gap: 25px; align-items: flex-end;">
                <div class="form-group">
                    <label for="nama_kategori" style="font-size: 13px; font-weight: 800; color: #374151; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px; display: block;">Nama Kategori</label>
                    <input type="text" id="nama_kategori" name="nama_kategori" class="form-control" placeholder="Contoh: Tari Tradisional" required style="padding: 14px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; background: #f9fafb; transition: all 0.3s ease; width: 100%;" onfocus="this.style.borderColor='#667eea'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(102, 126, 234, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb'; this.style.boxShadow='none';">
                    @error('nama_kategori')
                        <span style="color: #dc2626; font-size: 12px; display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary" style="padding: 14px 32px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-size: 14px; font-weight: 800; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; transition: all 0.3s ease; white-space: nowrap;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(102, 126, 234, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">Tambah Kategori</button>
            </div>
        </form>
    </div>

    <!-- Daftar Kategori -->
    <div class="table-section" style="background: #f8f9ff; padding: 40px; border-radius: 15px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.15);">
        <h2 style="font-size: 24px; font-weight: 800; color: #1f2937; margin: 0 0 30px 0; padding-bottom: 20px; border-bottom: 4px solid #667eea;">Daftar Kategori Seni</h2>
        <div class="table-responsive" style="border-radius: 12px; overflow: hidden; border: 2px solid #667eea;">
            <table class="admin-table" style="width: 100%; border-collapse: collapse;">
                <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-bottom: 3px solid #667eea;">
                    <tr>
                        <th style="padding: 20px 18px; text-align: center; font-weight: 800; color: white; text-transform: uppercase; font-size: 13px; letter-spacing: 1px; width: 80px;">No</th>
                        <th style="padding: 20px 18px; text-align: left; font-weight: 800; color: white; text-transform: uppercase; font-size: 13px; letter-spacing: 1px;">Nama Kategori</th>
                        <th style="padding: 20px 18px; text-align: center; font-weight: 800; color: white; text-transform: uppercase; font-size: 13px; letter-spacing: 1px; width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $key => $kategori)
                    <tr style="border-bottom: 2px solid #e5e7eb; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#f0f4ff'; this.style.boxShadow='inset 4px 0 0 #667eea';" onmouseout="this.style.backgroundColor='white'; this.style.boxShadow='none';">
                        <td style="padding: 18px 18px; border-bottom: 2px solid #e5e7eb; color: #1f2937; text-align: center; font-weight: 600;">{{ $key + 1 }}</td>
                        <td style="padding: 18px 18px; border-bottom: 2px solid #e5e7eb; color: #1f2937; font-weight: 600;">{{ $kategori->nama }}</td>
                        <td style="padding: 18px 18px; border-bottom: 2px solid #e5e7eb; text-align: center;">
                            <button type="button" class="btn-action btn-edit" data-kategori-id="{{ $kategori->id }}" data-kategori-nama="{{ $kategori->nama }}" title="Edit" style="padding: 8px 30px; border: 1px solid #90caf9; border-radius: 6px; background: #dbeafe; color: #0c4a6e; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; margin-right: 6px; transition: all 0.3s ease; font-weight: 600; box-sizing: border-box; white-space: nowrap;" onmouseover="this.style.background='#bfdbfe'; this.style.borderColor='#64b5f6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(11, 142, 228, 0.3)';" onmouseout="this.style.background='#dbeafe'; this.style.borderColor='#90caf9'; this.style.transform='translateY(0)'; this.style.boxShadow='none';"><i class="fas fa-edit" style="margin-right: 5px;"></i>Edit</button>
                            <form method="POST" action="{{ route('kategori.destroy', $kategori->id) }}" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-danger" title="Hapus" style="padding: 8px 30px; border: 1px solid #f8b4b4; border-radius: 6px; background: #fee2e2; color: #7f1d1d; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; transition: all 0.3s ease; font-weight: 600; box-sizing: border-box; white-space: nowrap;" onmouseover="this.style.background='#fecaca'; this.style.borderColor='#f59e9e'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(239, 68, 68, 0.3)';" onmouseout="this.style.background='#fee2e2'; this.style.borderColor='#f8b4b4'; this.style.transform='translateY(0)'; this.style.boxShadow='none';"><i class="fas fa-trash" style="margin-right: 5px;"></i>Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="padding: 30px 18px; text-align: center; color: #9ca3af;">Belum ada kategori. Silakan tambahkan kategori baru.</td>
                    </tr>
                    @endforelse
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
        <form class="modal-body" method="POST" id="editKategoriForm">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_nama">Nama Kategori</label>
                <input type="text" id="edit_nama" name="nama_kategori" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-kategori-id');
        const nama = this.getAttribute('data-kategori-nama');
        openEditModal(id, nama);
    });
});

function openEditModal(id, nama) {
    document.getElementById('edit_nama').value = nama;
    document.getElementById('editKategoriForm').action = '/admin/kategori/' + id;
    document.getElementById('editKategoriModal').style.display = 'block';
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('editKategoriModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

// Close modal when clicking close button
document.querySelectorAll('[data-dismiss="modal"]').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('editKategoriModal').style.display = 'none';
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
}

.modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 400px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.modal-close {
    background: none;
    border: none;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    color: #aaa;
}

.modal-close:hover {
    color: #000;
}

.btn-secondary {
    background-color: #6b7280;
    color: white;
    padding: 10px 20px;
    margin-left: 10px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.btn-secondary:hover {
    background-color: #4b5563;
}
</style>
@endsection
