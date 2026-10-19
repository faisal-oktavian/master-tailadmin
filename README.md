# Master Backend — CodeIgniter 3 + TailAdmin (PHP 8.2)

Project master backend dengan layout **TailAdmin (versi HTML, Tailwind v4 + Alpine.js)**.
Layout (sidebar, header, breadcrumb, kartu, tabel, form, modal, dark mode) memakai markup asli template.

## Fitur

| Halaman | URL | Keterangan |
|---|---|---|
| Login | `/login` | Form sign-in TailAdmin, password di-hash (`password_hash`), CSRF aktif |
| Dashboard | `/dashboard` | Kartu statistik, grafik karyawan bergabung per bulan, % karyawan aktif, karyawan terbaru |
| **Master Karyawan** | `/karyawan` | CRUD memakai **popup modal** (AJAX). Semua tipe input ada di modal |
| **Master Supplier** | `/supplier` | CRUD memakai **halaman baru** (`/supplier/create`, `/supplier/edit/ID`) |
| **User** | `/user` | CRUD dengan DataTables dan modal (AJAX) pada tabel `users` |
| **Hak Akses** | `/user_role` | Atur izin menu secara langsung untuk setiap user |

SweetAlert2 dipakai untuk: notifikasi sukses/gagal (toast dari flashdata), konfirmasi hapus,
konfirmasi simpan (Master Supplier), konfirmasi logout, dan peringatan validasi.

### Tipe input di modal Master Karyawan
text, email, password, tel, url, number, date, time, datetime-local, color, range, select,
select multiple, radio, checkbox (grup + tunggal), switch, textarea, file (upload foto + pratinjau).

## Kebutuhan
- PHP 8.2, MySQL/MariaDB, Apache (mod_rewrite) atau Nginx
- Node.js 18+ (hanya untuk build CSS/JS)
- CodeIgniter **3.1.13** (folder `system/`)

## Instalasi

1. **Taruh framework CodeIgniter 3.1.13**
   Unduh dari https://codeigniter.com/userguide3/installation/downloads.html lalu salin ke root project ini:
   - folder `system/` (wajib)
   - file `application/config/mimes.php` (opsional; project sudah menyertakan versi minimal)

   Project ini sudah berisi `application/` lengkap (config, controller, model, view, view error),
   jadi **jangan menimpa** isi `application/` dengan milik CI.

2. **Database**
   ```bash
   mysql -u root -p < master_tailadmin.sql
   ```
   Lalu sesuaikan `application/config/database.php` (hostname, username, password, database).
   Jalankan kedua migrasi berikut setelah import dump:
   ```bash
   mysql -u root -p master_tailadmin < database_role_access.sql
   mysql -u root -p master_tailadmin < database_user_access.sql
   ```
   Migrasi pertama membuat role Administrator dan Operator serta menghubungkan pengguna pertama sebagai Administrator.
   Migrasi kedua menyalin izin role awal menjadi izin per user. Untuk database yang sudah berjalan, jangan impor ulang dump contoh;
   jalankan hanya migrasi yang belum diterapkan.

3. **Build aset TailAdmin**
   ```bash
   npm install
   npm run build        # menghasilkan assets/css/style.css, assets/js/bundle.js, assets/images/
   ```
   Saat mengembangkan: `npm run watch`.
   > Jika Anda menambah class Tailwind baru di `application/views` atau `src/js`, jalankan build lagi.

4. **Izin tulis folder**
   `uploads/karyawan/`, `application/cache/`, dan `application/logs/` harus bisa ditulis web server.

5. **Base URL**
   Dideteksi otomatis di `application/config/config.php`. Jika project ada di subfolder
   (mis. `http://localhost/master-backend/`) pastikan `.htaccess` aktif (mod_rewrite + `AllowOverride All`).

6. **Ganti `encryption_key`** di `application/config/config.php`.

## Login awal
- Email: `admin@example.com`
- Password: `admin123`

**Segera ganti** setelah instalasi (ubah baris di tabel `users` dengan hash dari `password_hash()`).

## Struktur penting
```
application/
   controllers/  Auth, Dashboard, Karyawan (modal/AJAX), Supplier, User, User_role
  core/         MY_Controller.php (MY_Controller + Admin_Controller)
  libraries/    MY_Form_validation.php (edit_unique, url_opsional)
   models/       User_model, Role_model, Karyawan_model, Supplier_model
  views/
    layouts/    main, header, sidebar, overlay, preloader  (dari partial TailAdmin)
    auth/       login
    dashboard/  index
    karyawan/   index (tabel + modal)
   supplier/   index, form
   user/       index, form
   user_role/  index (izin per-user)
src/            sumber CSS/JS/gambar TailAdmin (dibuild webpack ke assets/)
assets/         hasil build (dibuat oleh npm run build)
uploads/        foto karyawan (eksekusi script dimatikan lewat .htaccess)
master_tailadmin.sql data contoh
database_role_access.sql, database_user_access.sql migrasi role dan izin
```

## Endpoint Master Karyawan (modal, JSON)
| Method | URL | Fungsi |
|---|---|---|
| GET | `/karyawan/get/{id}` | ambil data untuk modal edit |
| POST | `/karyawan/store` | tambah |
| POST | `/karyawan/update/{id}` | ubah (password/foto kosong = tidak diubah) |
| POST | `/karyawan/delete/{id}` | hapus |

## Endpoint User (DataTables, modal, JSON)
| Method | URL | Fungsi |
|---|---|---|
| GET | `/user/table` | data user untuk DataTables |
| GET | `/user/get/{id}` | data user untuk modal edit |
| POST | `/user/store` | tambah user |
| POST | `/user/update/{id}` | ubah user (password kosong = tidak diubah) |
| POST | `/user/delete/{id}` | hapus user |

## Catatan
- CI 3.1.13 memakai dynamic property, sehingga PHP 8.2 mengeluarkan `E_DEPRECATED`.
  `index.php` sudah menyembunyikannya (`error_reporting(E_ALL & ~E_DEPRECATED ...)`).
- Daftar notifikasi di dropdown header masih contoh statis bawaan template.
- Menu "Edit profile / Account settings / Support" di dropdown user masih `#` (belum ada halamannya).
- CSRF memakai `csrf_regenerate = FALSE` supaya request AJAX modal tetap sederhana.
