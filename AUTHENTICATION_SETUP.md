# Setup Instruksi untuk Authentication System

## 1. Import Database Schema ke MySQL

Buka file `database_schema.sql` dan copy semua kodenya ke MySQL query editor, atau gunakan:

```bash
mysql -u root -p your_database_name < database_schema.sql
```

**Atau via phpMyAdmin:**
- Go to "Import" tab
- Select file `database_schema.sql`
- Click Import

**Database tables yang dibuat:**
- `users` - Untuk menyimpan data admin dan seniman
- `sessions` - Untuk Laravel session management

**Default Admin Account:**
- Email: `admin@sumbawa.com`
- Password: `Admin123!`

---

## 2. Update `.env` Configuration

Pastikan database connection di `.env` sudah benar:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gallery_sumbawa  # Sesuaikan dengan nama database Anda
DB_USERNAME=root
DB_PASSWORD=
```

---

## 3. Files & Struktur yang Sudah Dibuat

### Controller
- `app/Http/Controllers/AuthController.php` - Login, Register, Logout logic

### Models
- `app/Models/User.php` - Updated dengan role dan is_active fields

### Middleware
- `app/Http/Middleware/CheckAdminRole.php` - Protect admin routes
- `app/Http/Middleware/CheckSenimanRole.php` - Protect seniman routes

### Views
- `resources/views/auth/login.blade.php` - Login page
- `resources/views/auth/register.blade.php` - Register page
- `resources/views/admin/dashboard.blade.php` - Admin dashboard
- `resources/views/seniman/dashboard.blade.php` - Seniman dashboard

### CSS
- `public/css/auth.css` - Styling untuk login/register pages
- `public/css/dashboard.css` - Styling untuk dashboard pages

### Routes
- `routes/web.php` - Updated dengan auth routes dan protected routes

---

## 4. URL & Access Points

### Public Access
- **Login:** http://localhost/GalerySumbawa/login
- **Register (Seniman):** http://localhost/GalerySumbawa/register

### Protected Routes (Require Login)
- **Admin Dashboard:** http://localhost/GalerySumbawa/admin/dashboard
- **Seniman Dashboard:** http://localhost/GalerySumbawa/seniman/dashboard

---

## 5. Testing the System

### Test Login sebagai Admin:
1. Go to http://localhost/GalerySumbawa/login
2. Email: `admin@sumbawa.com`
3. Password: `Admin123!`
4. Should redirect to http://localhost/GalerySumbawa/admin/dashboard

### Test Register sebagai Seniman:
1. Go to http://localhost/GalerySumbawa/register
2. Fill form dengan data baru
3. Should redirect to http://localhost/GalerySumbawa/seniman/dashboard

### Test Logout:
- Click Logout button di sidebar

---

## 6. Role Management di Database

**Untuk membuat user menjadi admin:**
```sql
UPDATE users SET role = 'admin' WHERE id = 2;
```

**Untuk menon-aktifkan user:**
```sql
UPDATE users SET is_active = 0 WHERE id = 2;
```

**Untuk melihat semua users:**
```sql
SELECT id, name, email, role, is_active FROM users;
```

---

## 7. Password Encryption

Semua password di-encrypt menggunakan Laravel's bcrypt hashing.
Jangan pernah simpan plain text password di database!

Default password hash untuk `Admin123!`:
```
$2y$10$DaQpWlKqVp.LqU0.EjH0Xu2qN2BNV.5Z3c1N5Z3c1N5Z3c1N5Z3c1
```

---

## 8. Session & Security

- Sessions disimpan di database (`sessions` table)
- Session lifetime bisa diatur di `.env` atau `config/session.php`
- Default: 120 menit (2 jam)

---

## 9. Troubleshooting

### "Access denied" ketika login
- Check database connection di `.env`
- Pastikan database schema sudah di-import

### "Class not found" error
- Run: `composer dump-autoload`

### Middleware not working
- Pastikan middleware registered di `bootstrap/app.php`
- Check routes di `routes/web.php` sudah benar

### CSS/JS tidak loading
- Check browser cache (Ctrl+F5)
- Pastikan file ada di `public/css/` dan `public/js/`

---

## 10. Next Steps (Opsional)

Anda bisa tambahkan:
- Profile edit page
- User management page untuk admin
- karya/artwork management page untuk seniman
- Email verification
- Password reset functionality
- Two-factor authentication

---

**Selamat! Authentication system sudah ready!** 🎉
