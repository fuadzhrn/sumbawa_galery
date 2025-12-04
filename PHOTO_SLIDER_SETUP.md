# Setup Database untuk Photo Slider Integration

## Langkah-Langkah Setup

### 1. Import Database Schema

Buka phpMyAdmin atau gunakan command line MySQL:

```bash
# Via Command Line
mysql -h 127.0.0.1 -u root sumbawa < database_setup.sql

# Atau copy-paste isi database_setup.sql ke phpMyAdmin
```

### 2. Clear Cache Laravel

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 3. Test Aplikasi

Akses: `http://localhost/GalerySumbawa`

### 4. Login Admin

- **Email**: admin@sumbawa.com
- **Password**: Admin123!

### 5. Upload Photo Slider

- Pergi ke: `/admin/photo-slider`
- Upload foto dengan format JPG/PNG (max 5MB)
- Foto akan langsung muncul di halaman beranda

---

## Testing Photo Slider Integration

### Test 1: Upload Photo Slider
1. Login sebagai admin
2. Akses `/admin/photo-slider`
3. Upload foto baru
4. ✅ Verifikasi foto muncul di grid
5. ✅ Verifikasi total foto terupdate
6. ✅ Akses halaman beranda (/) - foto harus muncul di slider

### Test 2: Hapus Photo Slider
1. Di halaman `/admin/photo-slider`
2. Klik tombol delete pada salah satu foto
3. ✅ Verifikasi foto hilang dari grid
4. ✅ Verifikasi total foto berkurang
5. ✅ Refresh halaman beranda - slider harus terupdate

### Test 3: Edit Deskripsi Foto
1. Di halaman `/admin/photo-slider`
2. Klik tombol edit pada foto
3. Masukkan deskripsi
4. Klik "Simpan Perubahan"
5. ✅ Verifikasi deskripsi tersimpan

### Test 4: Drag & Drop Upload
1. Di halaman `/admin/photo-slider`
2. Drag foto ke area "Klik atau drag foto di sini"
3. ✅ Verifikasi foto terupload otomatis

### Test 5: Slider Auto-Update
1. Upload foto slider admin (minimal 3 foto untuk melihat slider)
2. Akses halaman beranda di browser lain/tab lain
3. ✅ Verifikasi slider menampilkan foto yang baru diupload
4. Hapus foto di admin
5. ✅ Verifikasi slider terupdate tanpa perlu refresh (jika menggunakan API)

---

## File Structure

```
GalerySumbawa/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── SliderController.php (NEW)
│   │       ├── HomeController.php (NEW)
│   │       └── AuthController.php
│   └── Models/
│       ├── SliderImage.php (NEW)
│       └── User.php
├── public/
│   ├── assets/
│   │   └── slider/ (NEW - untuk menyimpan gambar slider)
│   ├── css/
│   │   └── admin-photo-slider.css (UPDATED)
│   └── storage/ (pastikan writable)
├── resources/
│   └── views/
│       ├── admin/
│       │   └── photo-slider.blade.php (UPDATED)
│       ├── index.blade.php (UPDATED)
│       └── layouts/
│           └── app.blade.php (UPDATED)
├── routes/
│   └── web.php (UPDATED)
└── database/
    ├── migrations/
    │   ├── 2025_12_04_062651_create_slider_images_table.php (NEW)
    │   ├── 2025_12_04_063334_add_role_and_is_active_to_users_table.php (NEW)
    │   └── ...
    ├── seeders/
    │   └── AdminSeeder.php (NEW)
    └── database_setup.sql (NEW)
```

---

## API Endpoints

### Public API
- `GET /api/sliders` - Ambil semua slider yang aktif (JSON response)

### Admin Routes (Protected)
- `GET /admin/photo-slider` - Halaman manajemen slider
- `POST /admin/photo-slider` - Upload foto baru
- `DELETE /admin/photo-slider/{id}` - Hapus foto
- `PUT /admin/photo-slider/{id}/description` - Update deskripsi
- `POST /admin/photo-slider/reorder` - Reorder slider

---

## Database Tables

### slider_images
```sql
- id: bigint (PK)
- filename: varchar - nama file di server
- original_name: varchar - nama original file saat upload
- file_path: varchar - path ke file di storage
- mime_type: varchar - tipe file (image/jpeg, etc)
- file_size: bigint - ukuran file dalam bytes
- description: varchar - deskripsi foto (opsional)
- order: int - urutan tampil di slider
- is_active: boolean - apakah foto aktif ditampilkan
- created_at, updated_at: timestamp
```

### users
```sql
- id: bigint (PK)
- name: varchar
- email: varchar (UNIQUE)
- email_verified_at: timestamp
- password: varchar (bcrypt hashed)
- role: enum('admin', 'seniman')
- is_active: boolean
- remember_token: varchar
- created_at, updated_at: timestamp
```

---

## Default Users

### Admin
- **Email**: admin@sumbawa.com
- **Password**: Admin123!
- **Role**: admin

### Seniman (Sample)
- **Email**: budi.santoso@email.com / **Password**: password123
- **Email**: siti.nurhaliza@email.com / **Password**: password123
- **Email**: ahmad.wijaya@email.com / **Password**: password123

---

## Features

✅ Upload foto slider dengan drag & drop  
✅ Auto-sync slider di halaman user  
✅ Edit deskripsi foto  
✅ Hapus foto dengan konfirmasi  
✅ Responsive design  
✅ Smooth hover effects  
✅ File validation (JPG/PNG, max 5MB)  
✅ Beautiful UI dengan modern CSS  
✅ CRUD operations via controller  
✅ Database-driven slider management  

---

## Troubleshooting

### Foto tidak muncul di slider
1. Pastikan file sudah terupload ke `public/storage/assets/slider/`
2. Jalankan `php artisan storage:link` jika belum
3. Clear cache: `php artisan cache:clear`
4. Check database untuk memastikan `slider_images` record sudah ada

### Error "Column not found"
1. Jalankan migration: `php artisan migrate`
2. Atau import `database_setup.sql` jika migration error

### Upload gagal
1. Check permission folder `public/assets/slider/` (harus writable)
2. Check max upload size di `php.ini`: `upload_max_filesize = 20M`
3. Check storage link: `php artisan storage:link`

### Slider tidak auto-update
1. Refresh halaman beranda (F5)
2. Check browser console untuk error
3. Verify API endpoint: `/api/sliders` returns JSON

---

## Performance Tips

- Optimize image size sebelum upload (max 5MB)
- Gunakan format JPG untuk foto besar
- Gunakan PNG untuk gambar dengan transparansi
- Clear cache secara berkala
- Monitor database size

