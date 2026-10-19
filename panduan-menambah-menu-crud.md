# Panduan Menambah Menu CRUD

Panduan ini menjelaskan dua pola CRUD yang sudah dipakai project:

1. **Modal/AJAX** seperti Master Karyawan. Form tambah/edit muncul sebagai popup; simpan, ubah, hapus, dan refresh tabel dilakukan tanpa memuat ulang seluruh halaman.
2. **Halaman form** seperti Master Supplier. Tombol Tambah/Edit membuka halaman form tersendiri; navigasi dan submit dapat menggunakan partial loader agar layout utama tidak dimuat ulang.

Contoh utama di bawah adalah membuat **Master User dengan pola modal Karyawan**.

## Peta File

| Bagian            | Pola modal Karyawan                               | Pola halaman Supplier                     | Tujuan                                            |
|---                |---                                                |---                                        |---                                                |
| Controller        | `application/controllers/Karyawan.php`            | `application/controllers/Supplier.php`    | Ambil data, validasi, dan jalankan CRUD           |
| Model             | `application/models/Karyawan_model.php`           | `application/models/Supplier_model.php`   | Query database                                    |
| View              | `application/views/karyawan/index.php`            | `application/views/supplier/index.php`    | Tabel, form, modal/halaman                        |
                        dan `_rows.php`                                     dan `form.php`
| Alpine component  | `karyawanCrud` di `src/js/app.js`                 | `supplierList` dan handler                | Interaksi browser dan request AJAX                |
                                                                            form di `src/js/app.js`
| Menu/sidebar      | `application/views/layouts/sidebar.php`           | Sama                                      | Link menu dan status menu aktif                   |
| Hak akses menu    | `User_role::$modules`, `User::MENUS`, `Role_model` | Sama                                      | Daftar menu dan izin role/user                    |
| Route             | `application/config/routes.php`                   | Sama                                      | URL; controller CI3 juga mendukung auto-routing   |
| Database          | `master_tailadmin.sql`                            | Sama                                      | Skema awal dan data contoh                        |
| Hasil build       | `assets/js/bundle.js`, `assets/css/style.css`     | Sama                                      | Dibuat dari `src/`; jangan edit manual            |

`application/core/MY_Controller.php`, `application/views/layouts/main.php`, `application/views/layouts/page.php`, dan `static/js/menu-nav.js` adalah infrastruktur bersama. Biasanya file-file ini **tidak perlu diduplikasi** saat menambah menu.

## Memilih Pola

### Modal/AJAX

Pilih pola ini jika form bisa ditampilkan di modal dan setelah simpan/hapus tabel cukup diperbarui. Mulai dengan membandingkan:

- `application/controllers/Karyawan.php`
- `application/models/Karyawan_model.php`
- `application/views/karyawan/index.php`
- `application/views/karyawan/_rows.php`
- komponen `karyawanCrud` pada `src/js/app.js`

View Karyawan menempatkan tabel dan modal dalam satu file. `_rows.php` berisi markup baris tabel yang digunakan saat render awal dan endpoint refresh.

### Halaman Form

Pilih pola ini bila form lebih cocok sebagai halaman tersendiri:

- `application/controllers/Supplier.php`
- `application/models/Supplier_model.php`
- `application/views/supplier/index.php`
- `application/views/supplier/form.php`
- komponen `supplierList` dan handler `form[data-confirm-save]` pada `src/js/app.js`

Link yang harus memakai navigasi konten diberi `data-menu-nav`. Link form dapat menggunakan `data-loading-title` jika memerlukan SweetAlert loader. Submit form Supplier menggunakan `window.__submitPartialForm`, dan redirect server kembali ke daftar tetap ditampilkan lewat partial navigation.

## Contoh: Master User dengan Modal Karyawan

### 1. Pastikan Tabel yang Akan Dikelola

Project sudah mempunyai tabel `users` di `master_tailadmin.sql` dengan kolom dasar `id`, `nama`, `email`, `password`, dan `created_at`. Tabel itu juga dipakai proses login. Migrasi role menambahkan `idrole`; lihat bagian [Daftarkan Menu dan Hak Akses](#9-daftarkan-menu-dan-hak-akses) sebelum mengubah CRUD User.

Penting:

- Jangan menimpa `application/models/User_model.php`; `Auth.php` memakainya untuk mencari akun berdasarkan email.
- Buat model CRUD terpisah bernama `Master_user_model.php`, tetapi model itu boleh mengelola tabel `users` yang sama.
- Password tidak boleh ditampilkan pada tabel, response detail, log, atau pesan validasi.
- Saat tambah atau ganti password, selalu simpan `password_hash($password, PASSWORD_DEFAULT)`, bukan teks password asli.
- Pada Edit, password kosong berarti password lama tidak diubah. Jangan pernah menampilkan hash lama ke input form.
- Menghapus akun dari menu ini juga menghapus kemampuan akun tersebut untuk login. Tambahkan perlindungan agar admin yang sedang login tidak menghapus akunnya sendiri atau akun admin terakhir.
- Kalau kebutuhan Master User memerlukan kolom baru seperti role/status, ubah skema dan tambahkan migrasi/SQL untuk database yang sudah berjalan. Jangan menganggap kolom tersebut sudah tersedia.

### 2. Salin dan Ganti Nama File

Buat salinan berikut:

1. `application/controllers/Karyawan.php` menjadi `application/controllers/Master_user.php`.
2. `application/models/Karyawan_model.php` menjadi `application/models/Master_user_model.php`.
3. `application/views/karyawan/index.php` menjadi `application/views/master_user/index.php`.
4. `application/views/karyawan/_rows.php` menjadi `application/views/master_user/_rows.php`.

Buat folder `application/views/master_user/` bila belum ada.

Jangan menyalin isi Karyawan mentah tanpa mengubah nama class, tabel, endpoint, field form, dan kolom tabel. Jangan menyalin `User_model.php` sebagai model CRUD baru karena file itu sudah punya tanggung jawab autentikasi.

### 3. Sesuaikan Model

Di `User_model.php`:

- Ubah nama class menjadi `User_model`.
- Gunakan `$table = 'users'`.
- Tambahkan method `all()`, `find($id)`, `insert($data)`, `update($id, $data)`, dan `delete($id)` mengikuti bentuk `Karyawan_model`.
- Gunakan daftar kolom eksplisit tanpa `password` untuk `all()` dan data yang dipakai tabel.
- `find()` boleh mengambil hash untuk kebutuhan internal update, tetapi controller jangan pernah mengirimkannya ke browser.
- Jangan mengubah method `get_by_email()` yang dimiliki `User_model`.

### 4. Sesuaikan Controller

Di `Master_user.php`:

- Ubah class menjadi `Master_user extends Admin_Controller`.
- Load `User_model`.
- Pada `index()`, ambil data aman dari model dan render `master_user/index` dengan opsi konsisten:
  - `title`: `Master User`
  - `page`: `master_user`
  - `breadcrumb`: `array('Master Data', 'Master User')`
  - `breadcrumb_links`: `array('master_user')`
- Tambahkan endpoint `table()` yang me-render `master_user/_rows.php` untuk refresh tabel.
- Tambahkan `get($id)`, `store()`, `update($id)`, dan `delete($id)` seperti endpoint di Karyawan, dengan response JSON.
- Untuk `get()`, hapus kolom password sebelum mengembalikan JSON, misalnya `unset($row['password'])`.
- `store()` harus menolak method selain POST, menjalankan validasi, membuat hash password, lalu mengembalikan JSON sukses.
- `update()` harus membaca record dahulu, memvalidasi email unik kecuali ID saat ini, dan hanya memanggil `password_hash()` bila password baru tidak kosong.
- `delete()` harus menolak selain POST, memastikan record ada, menjalankan perlindungan akun aktif/admin terakhir, lalu mengembalikan JSON.

Pola endpoint yang dipakai browser:

| Method | URL | Fungsi |
|---|---|---|
| GET | `/master_user` | Halaman daftar dan modal |
| GET | `/master_user/table` | HTML baris tabel terbaru |
| GET | `/master_user/get/{id}` | Detail aman untuk mengisi modal Edit |
| POST | `/master_user/store` | Tambah user |
| POST | `/master_user/update/{id}` | Ubah user |
| POST | `/master_user/delete/{id}` | Hapus user |

Controller CI3 biasanya otomatis menyediakan rute berdasarkan nama controller/method. Jika ingin URL alias yang berbeda, tambahkan pemetaan secara eksplisit di `application/config/routes.php`.

### 5. Atur Validasi

Gunakan `$this->form_validation` seperti `Karyawan::apply_rules()` dan pesan bersama dari `MY_Controller::set_validation_messages()` di `application/core/MY_Controller.php`.

Untuk tabel `users` saat ini, aturan umumnya mencakup:

- `nama`: wajib, maksimum 100 karakter.
- `email`: wajib, valid, unik pada saat tambah.
- `password`: wajib dan minimal 6 karakter pada tambah; saat Edit boleh kosong, tetapi jika diisi minimal 6 karakter.

Aturan unik Edit menggunakan helper `edit_unique` di `application/libraries/MY_Form_validation.php`, contohnya `edit_unique[users.email.ID]`. Pesan wajib, format email, dan nilai unik sudah ditetapkan pada `MY_Controller`; tambahkan aturan khusus hanya bila field yang dibuat membutuhkannya.

Untuk response AJAX gagal, ikuti `Karyawan::validation_failed()`:

```php
return $this->json(array(
    'status'  => false,
    'message' => 'Periksa kembali isian Anda.',
    'errors'  => $this->form_validation->error_array(),
), 422);
```

Validasi harus tetap dilakukan server-side. Validasi HTML/JavaScript hanya membantu UX, bukan pengganti validasi controller.

### 6. Sesuaikan View Tabel dan Modal

Di `application/views/master_user/index.php`:

- Ganti `x-data="karyawanCrud()"` menjadi `x-data="masterUserCrud()"`.
- Ganti judul, placeholder pencarian, kolom tabel, dan field form menjadi field Master User.
- Pertahankan pola tombol Tambah `@click="openCreate()"` dan Edit `@click="openEdit(id)"`.
- Pertahankan `tbody` awal dengan memuat `master_user/_rows.php`, lalu sediakan baris kosong yang dikontrol `filteredCount`.
- Pertahankan area overlay tabel dengan state `tableLoading` jika ingin loading lokal saat CRUD.
- Input password Tambah/Edit perlu memakai aturan: wajib saat Tambah; opsional saat Edit. Jangan isi input Edit dengan password atau hash lama.
- Gunakan `data-error-for="nama_field"` untuk placeholder error agar `showErrors()` bisa menampilkan pesan per field.

Di `master_user/_rows.php`:

- Render hanya field aman seperti nama, email, dan waktu dibuat.
- Ganti semua referensi `karyawan` menjadi `master_user` dan semua `@click` agar memakai ID Master User.
- Jangan pernah mencetak `$row['password']`.

### 7. Daftarkan Komponen JavaScript

Di `src/js/app.js`, duplikasi komponen Alpine `karyawanCrud` sebagai `masterUserCrud` di dalam `registerApp(Alpine)`. Ini satu bagian yang memang perlu disalin lalu disesuaikan:

- Ganti semua URL `karyawan/...` menjadi `master_user/...`.
- Ubah `resetForm()`, `fill()`, `showErrors()`, dan submit sesuai field Master User.
- Hapus kode khusus Karyawan yang tidak relevan, misalnya foto, gaji, bahasa, skill, departemen, dan tanggal.
- Pertahankan `tableState()`, `refreshTable()`, state pencarian/paginasi, toast, dan helper request `post()`.
- Setelah simpan sukses, tutup modal, aktifkan loading tabel, panggil `refreshTable()`, lalu tampilkan toast. Jangan reload seluruh halaman.
- Setelah hapus sukses, gunakan helper `deleteRecord()` dengan `onLoading`, `onSuccess`, dan `onFinish` agar loading hanya pada tabel.
- Tetap gunakan `MODAL_LOADING_DELAY` untuk loader Tambah/Edit; konstanta ini sudah dipakai bersama dan tidak perlu dibuat ulang.

`src/js/index.js` sudah memanggil `registerApp(Alpine)`, jadi komponen baru yang didaftarkan di `registerApp()` tidak memerlukan perubahan di `index.js`.

### 8. Tambahkan Link Sidebar

Edit `application/views/layouts/sidebar.php` dengan menyalin satu item menu Master Karyawan atau Supplier:

- `href`: `site_url('master_user')`.
- Teks: `Master User`.
- Ubah kondisi menu dan ikon menjadi `page === 'master_user'`.
- Untuk menu yang dibatasi hak akses, tampilkan item hanya jika `!empty($menu_access['master_user'])`.

Nilai `page` pada controller harus sama persis dengan nilai di sidebar. Link sidebar sudah ditangani oleh `static/js/menu-nav.js`; tidak perlu menggandakan handler navigasi.

### 9. Daftarkan Menu dan Hak Akses

Menu yang dilindungi harus memakai satu kunci konsisten (contoh: `master_user`) di controller, sidebar, dan data izin. Sidebar hanya menyembunyikan link; akses URL tetap harus diperiksa di server. Pola proyek saat ini:

Menu administrasi yang sudah ada memakai kunci `user` untuk controller `User` dan `user_role` untuk controller `User_role`. Contoh `master_user` pada panduan ini hanya berlaku bila membuat menu baru dengan nama tersebut; jangan mengganti kunci fitur yang sudah ada secara sebagian.

- Di controller, panggil `$this->require_access('master_user')` pada constructor agar seluruh endpoint controller terlindungi, atau panggil pada setiap endpoint yang perlu dibatasi.
- Di `application/views/layouts/sidebar.php`, gunakan `!empty($menu_access['master_user'])` untuk menampilkan link dan `page === 'master_user'` untuk status aktif.
- Tambahkan pasangan kunci dan label ke `User_role::$modules` pada `application/controllers/User_role.php`, agar menu muncul di halaman Hak Akses.
- Tambahkan kunci ke `User::MENUS` pada `application/controllers/User.php`. Daftar ini dipakai untuk membuat izin awal user baru dari izin role.
- Saat menambah menu pada instalasi baru, tambahkan kuncinya ke daftar menu pada `database_role_access.sql` dan `database_user_access.sql`, serta tentukan izin default role yang sesuai.

Izin role disimpan di `user_role` dan menjadi template/default saat user dibuat. Izin yang benar-benar diperiksa untuk user non-administrator disimpan terpisah di `user_access`; halaman Hak Akses mengubah izin individual tersebut. Perubahan izin role tidak otomatis mengubah izin user yang sudah ada. Role bernama `administrator` selalu lolos pemeriksaan akses, sementara kunci izin yang belum tersedia akan dianggap tidak diizinkan untuk user lain.

Untuk database yang sudah terpasang, buat migrasi SQL baru untuk menambahkan kunci menu ke `user_role` dan `user_access` bagi data yang sudah ada, dengan nilai default yang disengaja. Jangan hanya mengubah file SQL instalasi awal atau menjalankan ulang migrasi skema. Setelah perubahan, uji sebagai administrator dan user non-administrator: link harus sesuai izinnya dan URL langsung yang tidak diizinkan harus menghasilkan HTTP 403.

### 10. Opsi URL Eksplisit

Rute sederhana mengikuti konvensi controller/method CI3. Jika ingin nama URL lain, daftarkan di `application/config/routes.php`, misalnya:

```php
$route['master-user'] = 'master_user/index';
$route['master-user/table'] = 'master_user/table';
$route['master-user/get/(:num)'] = 'master_user/get/$1';
$route['master-user/store'] = 'master_user/store';
$route['master-user/update/(:num)'] = 'master_user/update/$1';
$route['master-user/delete/(:num)'] = 'master_user/delete/$1';
```

Jika memakai alias ini, semua URL di view dan `src/js/app.js` harus memakai alias yang sama. Tanpa alias, gunakan `/master_user/...` secara konsisten.

### 11. Bangun dan Uji

Setelah perubahan:

1. Periksa PHP: `php -l application/controllers/Master_user.php`, `php -l application/models/Master_user_model.php`, dan lint kedua view.
2. Build frontend: `npm run build`. Edit hanya `src/js/app.js` dan `src/css/style.css`; jangan edit manual hasil di `assets/`.
3. Uji daftar, pencarian, paginasi, Tambah, validasi kosong, email duplikat, Edit, password kosong saat Edit, password baru, Hapus, serta refresh setelah perubahan.
4. Pastikan JSON detail tidak berisi password/hash.
5. Pastikan klik link sidebar tetap hanya mengganti konten dan menu aktif memakai `page` yang benar.
6. Untuk menu yang dilindungi, uji visibilitas sidebar dan akses langsung URL untuk user dengan izin dan tanpa izin.
7. Uji akun login yang ada setelah perubahan. Jangan sampai CRUD menghapus akun admin atau merusak `password_hash`.

## Daftar Ringkas File

**Disalin untuk pola modal Master User:**

- `application/controllers/Karyawan.php` -> `application/controllers/Master_user.php`
- `application/models/Karyawan_model.php` -> `application/models/Master_user_model.php`
- `application/views/karyawan/index.php` -> `application/views/master_user/index.php`
- `application/views/karyawan/_rows.php` -> `application/views/master_user/_rows.php`
- Komponen `karyawanCrud` di `src/js/app.js` -> `masterUserCrud`

**Diedit untuk menghubungkan menu:**

- `application/views/layouts/sidebar.php`
- `application/config/routes.php` hanya jika perlu alias rute eksplisit
- `master_tailadmin.sql` hanya jika struktur tabel memang perlu berubah

**Jangan diduplikasi untuk menu biasa:**

- `application/core/MY_Controller.php`
- `application/views/layouts/main.php` dan `page.php`
- `static/js/menu-nav.js`
- `application/models/User_model.php` untuk contoh Master User ini
- File hasil build di `assets/`
