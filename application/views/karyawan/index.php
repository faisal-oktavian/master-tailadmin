<?php
// Kelas input standar TailAdmin (disalin dari form-elements)
$input_cls  = 'dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
$select_cls = 'dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
$area_cls   = 'dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
$file_cls   = 'focus:border-ring-brand-300 shadow-theme-xs focus:file:ring-brand-300 h-11 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:file:border-gray-800 dark:file:bg-white/3 dark:file:text-gray-400 dark:placeholder:text-gray-400';
$label_cls  = 'mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400';
$opt_cls    = 'text-gray-700 dark:bg-gray-900 dark:text-gray-400';
$err        = '<p class="text-theme-xs mt-1.5 text-error-500" data-error-for="%s"></p>';
$chevron    = '<span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400"><svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.79175 7.39551L10.0001 12.6038L15.2084 7.39551" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg></span>';
$th_cls     = 'px-5 py-3 text-left sm:px-6 rtl:text-right';
$th_p       = 'text-theme-xs font-medium text-gray-500 dark:text-gray-400';
?>
<div x-data="karyawanCrud()" class="space-y-5 sm:space-y-6">
  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
    <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 sm:py-5">
      <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Daftar Karyawan</h3>
      <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
        <input
          type="text"
          x-model.debounce.200ms="query"
          @input="page = 1"
          placeholder="Cari karyawan..."
          class="<?= $input_cls ?> sm:w-64"
        />
        <button
          type="button"
          @click="openCreate()"
          class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition"
        >
          <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 3.75C10.4142 3.75 10.75 4.08579 10.75 4.5V9.25H15.5C15.9142 9.25 16.25 9.58579 16.25 10C16.25 10.4142 15.9142 10.75 15.5 10.75H10.75V15.5C10.75 15.9142 10.4142 16.25 10 16.25C9.58579 16.25 9.25 15.9142 9.25 15.5V10.75H4.5C4.08579 10.75 3.75 10.4142 3.75 10C3.75 9.58579 4.08579 9.25 4.5 9.25H9.25V4.5C9.25 4.08579 9.58579 3.75 10 3.75Z" fill=""/></svg>
          Tambah Karyawan
        </button>
      </div>
    </div>

    <div class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
      <div class="relative overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
        <div class="custom-scrollbar max-w-full overflow-x-auto">
          <table class="w-full min-w-275.5">
            <thead>
              <tr class="border-b border-gray-100 dark:border-gray-800">
                <th class="<?= $th_cls ?>"><p class="<?= $th_p ?>">Karyawan</p></th>
                <th class="<?= $th_cls ?>"><p class="<?= $th_p ?>">Kontak</p></th>
                <th class="<?= $th_cls ?>"><p class="<?= $th_p ?>">Departemen</p></th>
                <th class="<?= $th_cls ?>"><p class="<?= $th_p ?>">Gaji</p></th>
                <th class="<?= $th_cls ?>"><p class="<?= $th_p ?>">Jam Masuk</p></th>
                <th class="<?= $th_cls ?>"><p class="<?= $th_p ?>">Status</p></th>
                <th class="<?= $th_cls ?>"><p class="<?= $th_p ?>">Aksi</p></th>
              </tr>
            </thead>
            <tbody>
              <?php $this->load->view('karyawan/_rows', array('rows' => $rows)); ?>
              <tr x-show="filteredCount === 0" x-cloak>
                <td colspan="7" class="px-5 py-8 text-center text-theme-sm text-gray-500 sm:px-6 dark:text-gray-400">Data karyawan tidak ditemukan.</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div x-show="tableLoading" x-cloak class="absolute inset-0 z-10 flex items-center justify-center gap-3 bg-white/75 text-sm font-medium text-gray-700 dark:bg-gray-900/75 dark:text-gray-200">
          <span class="h-5 w-5 animate-spin rounded-full border-2 border-gray-300 border-t-brand-500"></span>
          Memuat data tabel...
        </div>
      </div>

      <div class="mt-4 flex flex-col items-center justify-between gap-3 sm:flex-row" x-show="filteredCount > 0">
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">
          Menampilkan <span x-text="from"></span>&ndash;<span x-text="to"></span> dari <span x-text="filteredCount"></span> data
        </p>
        <div class="flex items-center gap-2">
          <button type="button" @click="prev()" :disabled="page <= 1" class="text-theme-sm shadow-theme-xs rounded-lg border border-gray-300 bg-white px-4 py-2 font-medium text-gray-700 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/3">Sebelumnya</button>
          <span class="text-theme-sm text-gray-500 dark:text-gray-400"><span x-text="page"></span> / <span x-text="totalPages"></span></span>
          <button type="button" @click="next()" :disabled="page >= totalPages" class="text-theme-sm shadow-theme-xs rounded-lg border border-gray-300 bg-white px-4 py-2 font-medium text-gray-700 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/3">Berikutnya</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ===================== MODAL CREATE / EDIT ===================== -->
  <div
    x-show="open"
    x-cloak
    @keydown.escape.window="close()"
    class="fixed inset-0 z-99999 flex items-center justify-center overflow-y-auto p-5"
  >
    <div class="modal-close-btn fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]" @click="close()"></div>
    <div class="no-scrollbar relative w-full max-w-175 overflow-y-auto rounded-3xl bg-white p-4 lg:p-11 dark:bg-gray-900">
      <button
        type="button"
        @click="close()"
        class="transition-color absolute top-5 right-5 z-999 flex h-11 w-11 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-white/5 dark:text-gray-400 dark:hover:bg-white/[0.07] dark:hover:text-gray-300"
      >
        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z" fill=""/></svg>
      </button>

      <div class="px-2 pr-14">
        <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90" x-text="editId ? 'Edit Karyawan' : 'Tambah Karyawan'"></h4>
        <p class="mb-6 text-sm text-gray-500 lg:mb-7 dark:text-gray-400">Lengkapi data karyawan di bawah ini, lalu simpan.</p>
      </div>

      <form x-ref="form" @submit.prevent="submit()" enctype="multipart/form-data" class="flex flex-col" novalidate autocomplete="off">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />

        <div class="custom-scrollbar h-112.5 overflow-y-auto px-2">
          <!-- ========== Data Akun ========== -->
          <div class="mb-6">
            <h4 class="mb-5 text-lg font-medium text-gray-800 lg:mb-6 dark:text-white/90">Data Akun</h4>
            <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
              <div class="col-span-2 lg:col-span-1">
                <label class="<?= $label_cls ?>">Kode<span class="text-error-500">*</span></label>
                <input type="text" name="kode" maxlength="20" placeholder="KRY-004" class="<?= $input_cls ?>" />
                <?= sprintf($err, 'kode') ?>
              </div>
              <div class="col-span-2 lg:col-span-1">
                <label class="<?= $label_cls ?>">Nama Lengkap<span class="text-error-500">*</span></label>
                <input type="text" name="nama" maxlength="100" placeholder="Nama karyawan" class="<?= $input_cls ?>" />
                <?= sprintf($err, 'nama') ?>
              </div>
              <div class="col-span-2 lg:col-span-1">
                <label class="<?= $label_cls ?>">Email<span class="text-error-500">*</span></label>
                <input type="email" name="email" maxlength="100" placeholder="nama@perusahaan.com" class="<?= $input_cls ?>" />
                <?= sprintf($err, 'email') ?>
              </div>
              <div class="col-span-2 lg:col-span-1">
                <label class="<?= $label_cls ?>">Password<span class="text-error-500" x-show="!editId">*</span></label>
                <div class="relative">
                  <input :type="passwordVisible ? 'text' : 'password'" name="password" autocomplete="new-password" :placeholder="editId ? 'Kosongkan jika tidak diubah' : 'Minimal 6 karakter'" class="<?= $input_cls ?> pr-11" />
                  <button type="button" @click="togglePassword()" :aria-label="passwordVisible ? 'Sembunyikan password' : 'Tampilkan password'" class="absolute top-1/2 right-3 -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <svg x-show="!passwordVisible" aria-hidden="true" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2.25 12s3.5-6 9.75-6 9.75 6 9.75 6-3.5 6-9.75 6-9.75-6-9.75-6Z" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="2.75"/></svg>
                    <svg x-show="passwordVisible" x-cloak aria-hidden="true" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m3 3 18 18M10.58 10.58a2 2 0 0 0 2.83 2.83M9.88 5.1A10.7 10.7 0 0 1 12 4.88c6.25 0 9.75 7.12 9.75 7.12a16.5 16.5 0 0 1-3.12 3.83M6.18 6.18C3.62 7.9 2.25 12 2.25 12s3.5 7.12 9.75 7.12c1.12 0 2.14-.25 3.06-.68" stroke-linecap="round" stroke-linejoin="round"/></svg>
                  </button>
                </div>
                <?= sprintf($err, 'password') ?>
              </div>
            </div>
          </div>

          <!-- ========== Kontak ========== -->
          <div class="mb-6">
            <h4 class="mb-5 text-lg font-medium text-gray-800 lg:mb-6 dark:text-white/90">Kontak</h4>
            <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
              <div class="col-span-2 lg:col-span-1">
                <label class="<?= $label_cls ?>">Telepon<span class="text-error-500">*</span></label>
                <input type="tel" name="telepon" maxlength="20" placeholder="0812xxxxxxxx" class="<?= $input_cls ?>" />
                <?= sprintf($err, 'telepon') ?>
              </div>
              <div class="col-span-2 lg:col-span-1">
                <label class="<?= $label_cls ?>">Website</label>
                <input type="url" name="website" maxlength="150" placeholder="https://contoh.com" class="<?= $input_cls ?>" />
                <?= sprintf($err, 'website') ?>
              </div>
            </div>
          </div>

          <!-- ========== Data Pribadi ========== -->
          <div class="mb-6">
            <h4 class="mb-5 text-lg font-medium text-gray-800 lg:mb-6 dark:text-white/90">Data Pribadi</h4>
            <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
              <div class="col-span-2 lg:col-span-1">
                <label class="<?= $label_cls ?>">Tanggal Lahir<span class="text-error-500">*</span></label>
                <input type="date" name="tgl_lahir" class="<?= $input_cls ?> cursor-pointer" />
                <?= sprintf($err, 'tgl_lahir') ?>
              </div>
              <div class="col-span-2 lg:col-span-1">
                <label class="<?= $label_cls ?>">Jenis Kelamin<span class="text-error-500">*</span></label>
                <div class="flex h-11 items-center gap-6">
                  <label class="relative flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                    <input type="radio" name="jenis_kelamin" value="L" class="peer custom-radio-input" />
                    <span class="mb-radio"><span></span></span>
                    Laki-laki
                  </label>
                  <label class="relative flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                    <input type="radio" name="jenis_kelamin" value="P" class="peer custom-radio-input" />
                    <span class="mb-radio"><span></span></span>
                    Perempuan
                  </label>
                </div>
                <?= sprintf($err, 'jenis_kelamin') ?>
              </div>
              <div class="col-span-2">
                <label class="<?= $label_cls ?>">Alamat<span class="text-error-500">*</span></label>
                <textarea name="alamat" rows="3" maxlength="500" placeholder="Alamat lengkap..." class="<?= $area_cls ?>"></textarea>
                <?= sprintf($err, 'alamat') ?>
              </div>
            </div>
          </div>

          <!-- ========== Kepegawaian ========== -->
          <div class="mb-6">
            <h4 class="mb-5 text-lg font-medium text-gray-800 lg:mb-6 dark:text-white/90">Kepegawaian</h4>
            <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
              <div class="col-span-2 lg:col-span-1">
                <label class="<?= $label_cls ?>">Departemen<span class="text-error-500">*</span></label>
                <div class="relative z-20 bg-transparent">
                  <select name="departemen" class="<?= $select_cls ?>">
                    <option value="" class="<?= $opt_cls ?>">Pilih departemen</option>
                    <?php foreach ($departemen as $d): ?>
                    <option value="<?= html_escape($d) ?>" class="<?= $opt_cls ?>"><?= html_escape($d) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?= $chevron ?>
                </div>
                <?= sprintf($err, 'departemen') ?>
              </div>
              <div class="col-span-2 lg:col-span-1">
                <label class="<?= $label_cls ?>">Gaji (Rp)<span class="text-error-500">*</span></label>
                <input type="text" name="gaji" inputmode="numeric" placeholder="Contoh: 5.000.000" @input="formatGaji($event)" class="<?= $input_cls ?>" />
                <?= sprintf($err, 'gaji') ?>
              </div>
              <div class="col-span-2 lg:col-span-1">
                <label class="<?= $label_cls ?>">Jam Masuk<span class="text-error-500">*</span></label>
                <input type="time" name="jam_masuk" class="<?= $input_cls ?> cursor-pointer" />
                <?= sprintf($err, 'jam_masuk') ?>
              </div>
              <div class="col-span-2 lg:col-span-1">
                <label class="<?= $label_cls ?>">Tanggal &amp; Waktu Bergabung<span class="text-error-500">*</span></label>
                <input type="datetime-local" name="tgl_bergabung" class="<?= $input_cls ?>" />
                <?= sprintf($err, 'tgl_bergabung') ?>
              </div>
              <div class="col-span-2 lg:col-span-1">
                <label class="<?= $label_cls ?>">Warna Label<span class="text-error-500">*</span></label>
                <input type="color" name="warna" value="#465fff" class="shadow-theme-xs h-11 w-full cursor-pointer rounded-lg border border-gray-300 bg-transparent p-1 dark:border-gray-700 dark:bg-gray-900" />
                <?= sprintf($err, 'warna') ?>
              </div>
              <div class="col-span-2 lg:col-span-1">
                <label class="<?= $label_cls ?>">Level Skill: <span class="text-brand-500 font-semibold" x-text="level"></span> / 10</label>
                <input type="range" name="level_skill" min="1" max="10" step="1" value="5" x-model="level" class="accent-brand-500 h-11 w-full cursor-pointer" />
                <?= sprintf($err, 'level_skill') ?>
              </div>
              <div class="col-span-2">
                <label class="<?= $label_cls ?>">Skill<span class="text-error-500">*</span></label>
                <div class="flex flex-wrap gap-x-6 gap-y-3">
                  <?php foreach ($skills as $s): ?>
                  <label class="relative flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                    <input type="checkbox" name="skills[]" value="<?= html_escape($s) ?>" class="peer custom-check-input" />
                    <span class="mb-check"></span>
                    <?= html_escape($s) ?>
                  </label>
                  <?php endforeach; ?>
                </div>
                <?= sprintf($err, 'skills[]') ?>
              </div>
              <div class="col-span-2">
                <label class="<?= $label_cls ?>">Bahasa yang Dikuasai</label>
                <div class="flex flex-wrap gap-x-6 gap-y-3">
                  <?php foreach ($bahasa as $b): ?>
                  <label class="relative flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                    <input type="checkbox" name="bahasa[]" value="<?= html_escape($b) ?>" class="peer custom-check-input" />
                    <span class="mb-check"></span>
                    <?= html_escape($b) ?>
                  </label>
                  <?php endforeach; ?>
                </div>
                <?= sprintf($err, 'bahasa[]') ?>
              </div>
              <div class="col-span-2 lg:col-span-1">
                <label class="<?= $label_cls ?>">Status Karyawan</label>
                <label class="relative flex h-11 cursor-pointer items-center gap-3 text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                  <input type="checkbox" name="aktif" value="1" checked class="peer custom-switch-input" />
                  <span class="mb-switch"></span>
                  Aktif
                </label>
              </div>
              <div class="col-span-2 lg:col-span-1">
                <label class="<?= $label_cls ?>">Foto <span class="text-theme-xs font-normal text-gray-400">(JPG/PNG, maks. 2 MB)</span></label>
                <input type="file" name="foto" accept=".jpg,.jpeg,.png" @change="previewFoto($event)" class="<?= $file_cls ?>" />
                <?= sprintf($err, 'foto') ?>
                <img x-show="fotoUrl" x-cloak :src="fotoUrl" alt="Pratinjau foto" class="mt-3 h-20 w-20 rounded-xl object-cover" />
              </div>
              <div class="col-span-2">
                <label class="relative flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                  <input type="checkbox" name="setuju" value="1" class="peer custom-check-input" />
                  <span class="mb-check"></span>
                  Saya menyetujui kebijakan perusahaan<span class="text-error-500">*</span>
                </label>
                <?= sprintf($err, 'setuju') ?>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-6 flex items-center gap-3 px-2 lg:justify-end">
          <button type="button" @click="close()" class="shadow-theme-xs flex w-full justify-center rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition ring-inset hover:bg-gray-50 sm:w-auto dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/3">Batal</button>
          <button type="submit" :disabled="saving" class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 flex w-full justify-center rounded-lg px-4 py-3 text-sm font-medium text-white transition disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto">
            <span x-text="saving ? 'Menyimpan...' : 'Simpan'"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
