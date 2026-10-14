tampilan yang saya mau sudah sesuai,  ada beberapa catatan dari saya yaitu:

- saat perpindahan antar menu loadingnya kenapa lama ya?
- menu master karyawan, 
    saat tambah data, inputan tanggal lahir datepickernya belum muncul, inputan jam masuk timepickernya belum muncul, saat checklist skill, toogle checkbox, dan checklist "saya menyetujui kebijakan perusahaan" tiba tiba langsung scroll kebawah padahal saat menampilkan checklist skill itu scroll paling bawah, saat klik tombol tambah beri jeda 3 detik dan beri animasi "loading" seperti saat edit data, dan saat klik tombol edit data beri jeda 3 detik juga, dan jelaskan code mana untuk mengatur jedanya, saat simpan data (tambah data baru / edit) atau hapus data loadingnya jangan loading halaman, tapi loading tabelnya saja
- menu master supplier, 
    saat tambah/edit data sudah ada animasi loading tapi tambahkan teks "loading...", saat pop up simpan data? dan saya klik "ya, simpan" apakah bisa tidak perlu loading halaman, tapi langsung loading content nya, saat inputannya kosong dan wajib diisi, maka beri pesan wajib diisi, seperti di master karyawan "Kode wajib diisi." (berwarna merah)
- pop up yang ada di kanan atas jangan dihapus


VERSI DI PROMPT KAN CHAT GPT

# PROMPT — PERBAIKAN UX, LOADING, FORM, VALIDASI & AJAX MASTER DATA
## ROLE
Bertindak sebagai:
* Senior Frontend Engineer
* Senior UI/UX Engineer
* JavaScript/jQuery Expert
* AJAX & Asynchronous Interaction Specialist
* CodeIgniter 3 Expert
* Bootstrap Expert
* DataTable Expert
* Form Validation Specialist

Anda bekerja pada project existing yang **sudah memiliki desain/tampilan yang sesuai dengan kebutuhan**.
## TUJUAN UTAMA
Lakukan perbaikan pada:
1. Loading perpindahan antar menu
2. Loading tabel saat CRUD
3. Datepicker dan timepicker pada form Master Karyawan
4. Perilaku scroll pada checkbox, toggle, dan checklist
5. Animasi loading pada tombol Tambah dan Edit
6. Validasi input wajib
7. Loading pada modal konfirmasi simpan
8. Toast/pop-up kanan atas
9. Optimasi AJAX agar tidak melakukan full page reload
10. Menjaga seluruh tampilan yang saat ini sudah sesuai

## ATURAN PALING PENTING
### 1. JANGAN MERUSAK DESAIN YANG SUDAH ADA
Tampilan aplikasi saat ini **SUDAH SESUAI**.
Jangan melakukan redesign besar-besaran.
Jangan mengubah:
* layout utama
* sidebar
* navbar
* warna
* typography
* card
* modal
* button style
* DataTable style
* responsive layout
* tema dark/light
* struktur menu
kecuali memang diperlukan untuk memperbaiki bug yang disebutkan dalam prompt ini.
Fokus hanya pada:
> BUG FIX + UX IMPROVEMENT + PERFORMANCE + AJAX INTERACTION

# 2. WAJIB ANALISIS PROJECT TERLEBIH DAHULU
Sebelum mengubah kode, lakukan analisis terhadap project existing.
Cari dan pahami terlebih dahulu:
* struktur Controller
* struktur Model
* View
* JavaScript
* CSS
* helper
* konfigurasi AJAX
* konfigurasi DataTable
* konfigurasi modal
* konfigurasi notification/toast
* event handler tombol tambah
* event handler tombol edit
* event handler tombol simpan
* event handler tombol hapus
* event handler checkbox
* event handler toggle
* datepicker
* timepicker
* loading overlay
* loading button
* AJAX request
* AJAX response
* reload DataTable
* reload halaman
Jangan langsung mengedit banyak file.
Identifikasi terlebih dahulu:
1. File yang menangani Master Karyawan
2. File yang menangani Master Supplier
3. File JavaScript terkait
4. File CSS terkait
5. Komponen/modal reusable
6. Komponen loading reusable
7. Komponen notification/toast
8. DataTable configuration
9. AJAX utility/helper jika tersedia
Setelah menemukan lokasi kode yang relevan, gunakan struktur existing sebanyak mungkin.

# 3. PERBAIKI LOADING SAAT PERPINDAHAN MENU
Saat berpindah antar menu, loading terasa terlalu lama.
Lakukan investigasi terlebih dahulu.
Cari tahu apakah penyebabnya:
* full page reload
* AJAX request yang terlalu lama
* script JavaScript dieksekusi berulang
* DataTable initialization terlalu berat
* asset CSS/JS dimuat ulang
* request API/query terlalu banyak
* loading overlay menunggu terlalu lama
* event handler terduplikasi
* request terjadi lebih dari satu kali
* AJAX request berjalan secara synchronous
* halaman menunggu resource yang tidak diperlukan

## ATURAN
Jangan sekadar mengurangi waktu loading secara artificial.
Jangan menggunakan:
```javascript
setTimeout()
```
untuk menyamarkan masalah loading halaman.
Cari akar masalahnya.
Jika perpindahan menu memang menggunakan AJAX, optimalkan mekanisme AJAX.
Jika halaman memang menggunakan full page navigation, jangan mengubah arsitektur aplikasi secara besar-besaran tanpa alasan.

## TARGET
Perpindahan menu harus terasa:
* cepat
* smooth
* tidak freeze
* tidak blank terlalu lama
* tidak menampilkan loading berlebihan
Jika loading indicator memang diperlukan, tampilkan hanya selama proses benar-benar berjalan.

# 4. MASTER KARYAWAN — FORM TAMBAH DATA
Perbaiki form tambah data pada Master Karyawan.

## 4.1 DATEPICKER TANGGAL LAHIR
Saat klik Tambah Data:
Input:
```text
Tanggal Lahir
```
saat ini datepicker belum muncul.
Perbaiki sehingga:
* datepicker muncul ketika input diklik
* datepicker juga dapat dibuka melalui icon jika tersedia
* format tanggal konsisten dengan aplikasi
* tidak keluar dari modal
* tidak tertutup di belakang modal
* z-index benar
* responsive
* dapat digunakan dengan mouse
* dapat digunakan dengan keyboard jika library mendukung

## PENTING
Jangan mengganti library datepicker jika library existing sebenarnya sudah tersedia dan hanya salah konfigurasi.
Cari terlebih dahulu apakah project sudah menggunakan:
* Bootstrap Datepicker
* jQuery UI Datepicker
* Flatpickr
* library lain
Gunakan library existing jika memungkinkan.

# 5. MASTER KARYAWAN — TIMEPICKER JAM MASUK
Input:
```text
Jam Masuk
```
saat ini timepicker belum muncul.
Perbaiki sehingga:
* timepicker muncul ketika input diklik
* dapat memilih jam dan menit
* tampil dengan benar di dalam modal
* tidak tertutup modal
* z-index benar
* tidak menyebabkan scroll otomatis
* format waktu mengikuti format aplikasi
Jika browser native time input memang digunakan, jangan mengganti tanpa alasan.
Jika project menggunakan plugin timepicker, perbaiki konfigurasi existing.

# 6. MASTER KARYAWAN — MASALAH SCROLL CHECKBOX / TOGGLE
Saat user melakukan:
* checklist skill
* klik toggle checkbox
* checklist "Saya menyetujui kebijakan perusahaan"
terjadi masalah:
> halaman tiba-tiba otomatis scroll ke bawah.
Ini harus diperbaiki.

## ANALISIS WAJIB
Cari penyebabnya.
Kemungkinan:
* `.focus()`
* `.scrollIntoView()`
* anchor `href`
* event click
* event change
* DOM re-render
* modal reposition
* Bootstrap modal focus trap
* collapse/accordion
* plugin checkbox
* plugin switch/toggle
* AJAX callback
* element ID duplicate
* browser native focus behavior
Jangan sekadar menggunakan:
```javascript
window.scrollTo(0, 0);
```
atau
```javascript
$('html, body').animate(...)
```
untuk menutupi masalah.
Cari dan perbaiki sumber masalahnya.

## PERILAKU YANG DIINGINKAN
Ketika user:
* checklist skill
* toggle checkbox
* checklist persetujuan kebijakan
posisi scroll harus tetap pada posisi user saat ini.
Tidak boleh:
* lompat ke bawah
* lompat ke atas
* reload halaman
* kehilangan posisi form

# 7. CHECKLIST SKILL
Ketika section:
```text
Skill
```
ditampilkan dan user berada pada posisi tersebut, scroll harus tetap berada di area Skill.
Jika Skill menggunakan:
* checkbox
* toggle
* collapse
* accordion
* dynamic content
pastikan perubahan state tidak menyebabkan browser melakukan scroll otomatis.
Jika tinggi modal berubah setelah Skill dibuka, pastikan modal tetap stabil.

# 8. TOMBOL TAMBAH — LOADING 3 DETIK
Saat user klik tombol:
```text
Tambah
```
berikan simulasi proses loading selama **3 detik** sebelum form/modal benar-benar ditampilkan.
Tujuannya untuk simulasi UX loading.

## PERILAKU
Contoh:
```text
Klik Tambah
↓
Button disabled
↓
Loading animation
↓
Tunggu 3 detik
↓
Form tampil
↓
Button kembali normal
```
Gunakan animasi loading yang **sama atau konsisten dengan loading Edit Data**.
Jangan membuat desain loading baru jika komponen loading existing sudah tersedia.

# 9. TOMBOL EDIT — LOADING 3 DETIK
Saat user klik:
```text
Edit
```
berikan jeda **3 detik** sebelum form edit ditampilkan.
Flow:
```text
Klik Edit
↓
Button disabled
↓
Loading animation
↓
3 detik
↓
Data edit ditampilkan

## PENTING
Jika data edit sebenarnya diambil menggunakan AJAX:
```text
GET detail data
jangan menggunakan setTimeout untuk menggantikan AJAX.
Jika ingin simulasi delay UX, lakukan delay hanya pada UI setelah/bersamaan proses yang sesuai.

# 10. LOKASI PENGATURAN DELAY HARUS JELAS
Setelah implementasi selesai, jelaskan kepada developer:

### File:
```text
nama/file.js
```
### Function:
```javascript
namaFunction()
```

### Bagian:
```javascript
const ADD_LOADING_DELAY = 3000;
const EDIT_LOADING_DELAY = 3000;
```
atau pendekatan konfigurasi yang paling sesuai dengan struktur project.
Gunakan **satu konfigurasi terpusat** jika memungkinkan.
Contoh:
```javascript
const FORM_LOADING_DELAY = 3000;
```
sehingga developer mudah mengubah:
```javascript
3000
```
menjadi:
```javascript
1000
```
atau:
```javascript
5000
```

## JANGAN
Menyebarkan angka:
```javascript
3000
```
ke banyak tempat tanpa konfigurasi.

# 11. SIMPAN DATA — JANGAN FULL PAGE LOADING
Saat user melakukan:
* Tambah data baru
* Edit data
dan kemudian klik:
```text
Simpan
```
JANGAN melakukan full page reload.
Jangan menggunakan pola:
```javascript
location.reload();
```
atau:
```javascript
window.location.reload();
```
jika tujuan hanya memperbarui DataTable.

## YANG DIINGINKAN
Flow:
```text
Klik Simpan
↓
Validasi
↓
Modal konfirmasi
↓
Klik "Ya, Simpan"
↓
Button/Content loading
↓
AJAX request
↓
Server memproses
↓
Success
↓
Modal ditutup
↓
DataTable reload
↓
Toast success
```
Halaman utama tetap berada pada kondisi yang sama.

# 12. LOADING HANYA PADA TABEL
Saat:
* tambah data
* edit data
* hapus data
jangan loading seluruh halaman.
Yang loading cukup:
```text
DataTable / content tabel
```

## CONTOH UX
Saat AJAX berjalan:
```text
+--------------------------------------+
|              DataTable               |
|                                      |
|          Loading data...              |
|             spinner                  |
|                                      |
+--------------------------------------+
```
Sidebar:
```text
TETAP AKTIF
```
Navbar:
```text
TETAP AKTIF
```
Page:
```text
TIDAK RELOAD
```
Modal:
```text
DITUTUP SETELAH SUCCESS
```

# 13. JANGAN MENGGUNAKAN FULL PAGE LOADING UNTUK CRUD
Cari dan hilangkan pola seperti:
```javascript
showPageLoading();
```
yang digunakan untuk:
* save
* update
* delete
Jika memang digunakan secara global, jangan langsung hapus komponen tersebut karena mungkin digunakan oleh menu lain.
Buat mekanisme:
```javascript
showTableLoading();
hideTableLoading();
```
atau gunakan komponen existing yang paling sesuai.

# 14. MASTER SUPPLIER — LOADING
Pada Master Supplier, saat:
* tambah data
* edit data
sudah terdapat animasi loading.
Pertahankan animasi tersebut.
Tambahkan teks:
```text
Loading...
```
atau:
```text
loading...
```
secara konsisten dengan desain existing.
Contoh:
```text
[ spinner ] Loading...
```
Pastikan:
* spinner tetap berjalan
* text terlihat jelas
* button disabled selama proses
* user tidak dapat melakukan double click
* setelah selesai button kembali normal

# 15. MASTER SUPPLIER — KONFIRMASI SIMPAN
Saat user klik:
```text
Simpan
```
dan muncul popup konfirmasi:
```text
Apakah data akan disimpan?
```
kemudian user klik:
```text
Ya, Simpan
```
JANGAN loading seluruh halaman.
Gunakan AJAX.
Flow:
```text
Klik Simpan
↓
Validasi
↓
Popup konfirmasi
↓
Klik "Ya, Simpan"
↓
Popup/content menunjukkan loading
↓
AJAX request
↓
Success
↓
Popup ditutup
↓
DataTable reload
↓
Toast success
```

# 16. MASTER SUPPLIER — VALIDASI WAJIB DIISI
Jika input wajib masih kosong, jangan mengirim AJAX request.
Tampilkan pesan validasi di dekat input.
Contoh:
```text
Kode
[________________]

Kode wajib diisi.
```
Pesan:
```text
Kode wajib diisi.
```
harus:
* berwarna merah
* jelas
* berada dekat input
* tidak menggeser layout secara berlebihan
* hilang setelah input valid
* konsisten dengan Master Karyawan

## CONTOH FIELD
Jika field wajib:
```text
Kode
Nama Supplier
Alamat
No. Telepon
```
maka validasi harus dilakukan sebelum request AJAX.

# 17. KONSISTENSI VALIDASI
Master Supplier harus mengikuti pola validasi Master Karyawan yang sudah ada jika mekanismenya sudah benar.
Jangan membuat dua sistem validasi berbeda tanpa alasan.
Cari implementasi:
```text
Kode wajib diisi.
```
pada Master Karyawan.
Pelajari:
* HTML structure
* class error
* JavaScript validation
* positioning
* styling
Kemudian gunakan pola yang sama pada Master Supplier.

# 18. POPUP / TOAST KANAN ATAS — JANGAN DIHAPUS
Ini sangat penting.
Semua popup/notifikasi yang saat ini muncul di kanan atas:
> JANGAN DIHAPUS.
Jangan mengganti seluruh sistem notification.
Jangan menghilangkan:
* success notification
* error notification
* warning notification
* info notification
jika sudah digunakan.
Pertahankan:
```text
Top Right Notification
```
dan pastikan tetap muncul setelah AJAX selesai.
Contoh:

### Success
```text
Data berhasil disimpan.
```

### Update
```text
Data berhasil diperbarui.
```

### Delete
```text
Data berhasil dihapus.
```

### Error
```text
Terjadi kesalahan saat menyimpan data.
```

# 19. HINDARI DUPLIKASI EVENT HANDLER
Periksa kemungkinan event handler didaftarkan berkali-kali.
Contoh masalah:
```javascript
$(document).on('click', '#btn-save', function () {
    ...
});
```
kemudian script dijalankan kembali dan event terdaftar lagi.
Akibatnya:
```text
1 klik
↓
2 AJAX request
```
atau:
```text
1 klik
↓
2 loading
↓
2 notification
```
Pastikan event handler tidak terduplikasi.
Gunakan pola yang aman jika diperlukan:
```javascript
$(document)
    .off('click', '#btn-save')
    .on('click', '#btn-save', function () {
        ...
    });
```
Sesuaikan dengan arsitektur project.

# 20. CEGAH DOUBLE SUBMIT
Ketika user klik:
```text
Ya, Simpan
```
button harus langsung disabled.
User tidak boleh melakukan:
```text
double click
```
yang menghasilkan dua request.
Contoh state:
```text
[ Ya, Simpan ]
```
menjadi:
```text
[ spinner Loading... ]
```
selama request berjalan.
Setelah request selesai:
```text
[ Ya, Simpan ]
```
kembali normal jika terjadi error.

# 21. ERROR HANDLING AJAX
Semua AJAX CRUD harus memiliki minimal:
```text
beforeSend
success
error
complete
```
atau struktur setara yang digunakan project.
Pastikan:

### beforeSend
* disable button
* tampilkan loading

### success
* tampilkan success notification
* tutup modal
* reload DataTable

### error
* tampilkan error notification
* jangan reload halaman
* button dapat digunakan kembali

### complete
* restore loading state
* restore button state

# 22. DATATABLE RELOAD
Setelah:

### INSERT
reload DataTable.

### UPDATE
reload DataTable.

### DELETE
reload DataTable.
Tetapi:
> JANGAN reload browser.
Jika menggunakan DataTables API, prioritaskan:
```javascript
table.ajax.reload(null, false);
```
agar posisi pagination tetap jika sesuai kebutuhan.
Jangan selalu kembali ke halaman pertama kecuali memang desain existing mengharuskannya.

# 23. MODAL
Saat modal dibuka:
* pastikan focus benar
* jangan menyebabkan scroll halaman
* datepicker/timepicker harus berada di atas modal
* dropdown harus berada di area yang benar
* modal tidak boleh menyebabkan body scroll secara aneh
Setelah modal ditutup:
* body harus kembali normal
* class Bootstrap modal/backdrop tidak boleh tertinggal
* tidak boleh ada overlay yang membuat halaman tidak bisa diklik

# 24. JANGAN MENGUBAH BACKEND TANPA ALASAN
Prioritas perbaikan:
```text
Frontend
↓
JavaScript
↓
AJAX
↓
UI state
```
Jangan mengubah:
* Controller
* Model
* database
* business logic
kecuali memang ditemukan bug backend yang secara langsung menyebabkan masalah yang diminta.
Jika backend harus diubah:
1. jelaskan penyebabnya
2. jelaskan file yang diubah
3. jelaskan dampaknya
4. jangan mengubah business logic yang tidak berkaitan

# 25. JANGAN MEMBUAT FILE BARU JIKA TIDAK DIPERLUKAN
Sebelum membuat file:
```text
new.js
loading.js
validation.js
```
cek apakah fungsi tersebut sebenarnya sudah tersedia.
Prioritaskan reuse.
Jika perlu membuat utility baru, buat hanya jika benar-benar membantu dan sesuai struktur project.

# 26. PRIORITAS IMPLEMENTASI
Kerjakan dengan urutan:

## PRIORITY 1
Master Karyawan:
* datepicker
* timepicker
* scroll bug
* tambah loading 3 detik
* edit loading 3 detik
* table-only loading
* AJAX save
* AJAX update
* AJAX delete

## PRIORITY 2
Master Supplier:
* loading text
* AJAX save
* AJAX update
* AJAX delete
* validasi required
* error message merah
* table-only loading

## PRIORITY 3
Global:
* optimasi perpindahan menu
* cek duplicate AJAX
* cek duplicate event
* cek full page reload
* pertahankan top-right notification

# 27. ACCEPTANCE CRITERIA
Implementasi dianggap berhasil apabila:

### Master Karyawan
[ ] Klik Tambah → loading 3 detik
[ ] Setelah 3 detik → form muncul
[ ] Klik Edit → loading 3 detik
[ ] Setelah 3 detik → form edit muncul
[ ] Tanggal Lahir → datepicker muncul
[ ] Jam Masuk → timepicker muncul
[ ] Checklist Skill → tidak menyebabkan scroll ke bawah
[ ] Toggle checkbox → tidak menyebabkan scroll
[ ] Checklist persetujuan → tidak menyebabkan scroll
[ ] Save → tidak reload halaman
[ ] Update → tidak reload halaman
[ ] Delete → tidak reload halaman
[ ] Save/update/delete → hanya DataTable yang loading
[ ] Success → top-right notification tetap muncul
[ ] Error → top-right notification tetap muncul
[ ] Tidak ada double submit

### Master Supplier
[ ] Tambah → loading animation + teks "Loading..."
[ ] Edit → loading animation + teks "Loading..."
[ ] Save → tidak reload halaman
[ ] Update → tidak reload halaman
[ ] Delete → tidak reload halaman
[ ] Save → DataTable saja yang loading
[ ] Field wajib kosong → pesan error merah
[ ] Validasi mengikuti pola Master Karyawan
[ ] Setelah success → DataTable reload
[ ] Top-right notification tetap muncul

### Global
[ ] Tidak ada `location.reload()` yang tidak diperlukan
[ ] Tidak ada full page loading saat CRUD
[ ] Tidak ada duplicate AJAX request
[ ] Tidak ada duplicate event handler
[ ] Tidak ada double submit
[ ] Tidak ada perubahan desain besar
[ ] Tidak ada perubahan business logic yang tidak diperlukan
[ ] Tidak ada notification kanan atas yang dihapus
[ ] Tidak ada error JavaScript di browser console
[ ] Tidak ada error AJAX

# 28. HASIL YANG WAJIB DIBERIKAN SETELAH IMPLEMENTASI
Setelah selesai, jangan hanya mengatakan:
```text
Done.
```
Berikan laporan perubahan dengan format:

## A. FILE YANG DIUBAH
Contoh:
```text
1. application/views/...
2. assets/js/...
3. assets/css/...
```
Untuk setiap file jelaskan perubahan.

## B. PERBAIKAN YANG DILAKUKAN
Contoh:
```text
1. Datepicker Master Karyawan diperbaiki
2. Timepicker Master Karyawan diperbaiki
3. Scroll jumping diperbaiki
4. Loading Tambah = 3 detik
5. Loading Edit = 3 detik
6. CRUD menggunakan AJAX
7. DataTable menggunakan reload tanpa full page reload
8. Validasi Supplier diperbaiki
9. Loading Supplier ditambahkan teks Loading...
```

## C. LOKASI PENGATURAN DELAY
Tunjukkan secara spesifik:
```text
File:
...
Function:
...
Variable:
...
Nilai:
3000 ms
```
Jelaskan bahwa:
```text
3000 ms = 3 detik
```
dan bagaimana mengubahnya.

## D. ALUR AJAX
Jelaskan flow:
```text
User
 ↓
Validation
 ↓
Confirmation
 ↓
Loading
 ↓
AJAX
 ↓
Server
 ↓
Success/Error
 ↓
DataTable reload
 ↓
Notification
```

## E. FILE YANG TIDAK DIUBAH
Sebutkan file penting yang sengaja tidak diubah karena tidak diperlukan.

# 29. FINAL CHECK
Sebelum menyatakan selesai:
1. Periksa browser console.
2. Pastikan tidak ada JavaScript error.
3. Pastikan tidak ada AJAX request ganda.
4. Pastikan tidak ada full page reload saat CRUD.
5. Pastikan DataTable reload dengan benar.
6. Pastikan notification kanan atas tetap berfungsi.
7. Pastikan modal tidak meninggalkan backdrop.
8. Pastikan datepicker berfungsi.
9. Pastikan timepicker berfungsi.
10. Pastikan scroll tidak jumping.
11. Pastikan button tidak dapat double submit.
12. Pastikan validasi required tampil merah.
13. Pastikan desain existing tetap dipertahankan.

## ATURAN FINAL
Jangan melakukan perubahan di luar scope prompt ini.
Jika menemukan masalah lain yang tidak berkaitan, **jangan langsung diperbaiki**.
Catat sebagai:
```text
Potential issue found but not modified:
...
```
Tujuan utama adalah:
> MEMPERBAIKI UX DAN PERFORMA INTERAKSI MASTER KARYAWAN & MASTER SUPPLIER TANPA MERUSAK DESAIN, BUSINESS LOGIC, DAN SISTEM NOTIFICATION YANG SUDAH ADA.