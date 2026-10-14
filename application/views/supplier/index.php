<?php
$th_cls = 'px-5 py-3 text-left sm:px-6 rtl:text-right';
$th_p   = 'text-theme-xs font-medium text-gray-500 dark:text-gray-400';
$input_cls = 'dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
?>
<div x-data="supplierList()" class="space-y-5 sm:space-y-6">
  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
    <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 sm:py-5">
      <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Daftar Supplier</h3>
      <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
        <input type="text" x-model.debounce.200ms="query" @input="page = 1" placeholder="Cari supplier..." class="<?= $input_cls ?> sm:w-64" />
        <a
          href="<?= site_url('supplier/create') ?>"
          data-menu-nav
          data-loading-title="Menyiapkan form..."
          class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition"
        >
          <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 3.75C10.4142 3.75 10.75 4.08579 10.75 4.5V9.25H15.5C15.9142 9.25 16.25 9.58579 16.25 10C16.25 10.4142 15.9142 10.75 15.5 10.75H10.75V15.5C10.75 15.9142 10.4142 16.25 10 16.25C9.58579 16.25 9.25 15.9142 9.25 15.5V10.75H4.5C4.08579 10.75 3.75 10.4142 3.75 10C3.75 9.58579 4.08579 9.25 4.5 9.25H9.25V4.5C9.25 4.08579 9.58579 3.75 10 3.75Z" fill=""/></svg>
          Tambah Supplier
        </a>
      </div>
    </div>

    <div class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
      <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
        <div class="custom-scrollbar max-w-full overflow-x-auto">
          <table class="w-full min-w-225">
            <thead>
              <tr class="border-b border-gray-100 dark:border-gray-800">
                <th class="<?= $th_cls ?>"><p class="<?= $th_p ?>">Supplier</p></th>
                <th class="<?= $th_cls ?>"><p class="<?= $th_p ?>">Kontak</p></th>
                <th class="<?= $th_cls ?>"><p class="<?= $th_p ?>">Kota</p></th>
                <th class="<?= $th_cls ?>"><p class="<?= $th_p ?>">Status</p></th>
                <th class="<?= $th_cls ?>"><p class="<?= $th_p ?>">Aksi</p></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $r): ?>
              <tr data-row class="border-b border-gray-100 dark:border-gray-800">
                <td class="px-5 py-4 sm:px-6">
                  <span class="text-theme-sm block font-medium text-gray-800 dark:text-white/90"><?= html_escape($r['nama']) ?></span>
                  <span class="text-theme-xs block text-gray-500 dark:text-gray-400"><?= html_escape($r['kode']) ?></span>
                </td>
                <td class="px-5 py-4 sm:px-6">
                  <p class="text-theme-sm text-gray-500 dark:text-gray-400"><?= html_escape($r['email']) ?></p>
                  <p class="text-theme-xs text-gray-400 dark:text-gray-500"><?= html_escape($r['telepon']) ?></p>
                </td>
                <td class="px-5 py-4 sm:px-6"><p class="text-theme-sm text-gray-500 dark:text-gray-400"><?= html_escape($r['kota']) ?></p></td>
                <td class="px-5 py-4 sm:px-6">
                  <?php if ($r['aktif']): ?>
                  <p class="bg-success-50 text-theme-xs text-success-700 dark:bg-success-500/15 dark:text-success-500 inline-block rounded-full px-2 py-0.5 font-medium">Aktif</p>
                  <?php else: ?>
                  <p class="bg-error-50 text-theme-xs text-error-600 dark:bg-error-500/15 dark:text-error-500 inline-block rounded-full px-2 py-0.5 font-medium">Nonaktif</p>
                  <?php endif; ?>
                </td>
                <td class="px-5 py-4 sm:px-6">
                  <div class="flex items-center gap-2">
                    <a href="<?= site_url('supplier/edit/' . (int) $r['id']) ?>" data-menu-nav data-loading-title="Memuat data..." title="Edit" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-200">
                      <svg class="stroke-current" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.862 3.487a2.25 2.25 0 1 1 3.182 3.182L7.5 19.213 3 21l1.787-4.5L16.862 3.487Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                    <button type="button" title="Hapus" data-id="<?= (int) $r['id'] ?>" data-nama="<?= html_escape($r['nama']) ?>" @click="remove($el.dataset.id, $el.dataset.nama)" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-error-500 hover:bg-error-50 dark:border-gray-800 dark:hover:bg-error-500/15">
                      <svg class="stroke-current" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 7h12M9 7V5.5A1.5 1.5 0 0 1 10.5 4h3A1.5 1.5 0 0 1 15 5.5V7m2 0-.7 11a2 2 0 0 1-2 1.9H9.7a2 2 0 0 1-2-1.9L7 7m3 4v5m4-5v5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
              <tr x-show="filteredCount === 0" x-cloak>
                <td colspan="5" class="px-5 py-8 text-center text-theme-sm text-gray-500 sm:px-6 dark:text-gray-400">Data supplier tidak ditemukan.</td>
              </tr>
            </tbody>
          </table>
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
</div>
