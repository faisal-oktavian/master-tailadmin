<?php foreach ($rows as $r): ?>
<tr data-row class="border-b border-gray-100 dark:border-gray-800">
  <td class="px-5 py-4 sm:px-6">
    <div class="flex items-center gap-3">
      <div class="h-10 w-10 overflow-hidden rounded-full">
        <img
          src="<?= !empty($r['foto']) ? base_url('uploads/karyawan/' . $r['foto']) : base_url('assets/images/user/user-01.jpg') ?>"
          alt="Foto"
          class="h-full w-full object-cover"
        />
      </div>
      <div>
        <span class="text-theme-sm block font-medium text-gray-800 dark:text-white/90"><?= html_escape($r['nama']) ?></span>
        <span class="text-theme-xs block text-gray-500 dark:text-gray-400"><?= html_escape($r['kode']) ?></span>
      </div>
    </div>
  </td>
  <td class="px-5 py-4 sm:px-6">
    <p class="text-theme-sm text-gray-500 dark:text-gray-400"><?= html_escape($r['email']) ?></p>
    <p class="text-theme-xs text-gray-400 dark:text-gray-500"><?= html_escape($r['telepon']) ?></p>
  </td>
  <td class="px-5 py-4 sm:px-6">
    <span class="inline-flex items-center gap-2 text-theme-sm text-gray-500 dark:text-gray-400">
      <span class="inline-block h-2.5 w-2.5 rounded-full" style="background-color: <?= html_escape($r['warna']) ?>"></span>
      <?= html_escape($r['departemen']) ?>
    </span>
  </td>
  <td class="px-5 py-4 sm:px-6"><p class="text-theme-sm text-gray-500 dark:text-gray-400">Rp <?= number_format((float) $r['gaji'], 0, ',', '.') ?></p></td>
  <td class="px-5 py-4 sm:px-6"><p class="text-theme-sm text-gray-500 dark:text-gray-400"><?= html_escape(substr($r['jam_masuk'], 0, 5)) ?></p></td>
  <td class="px-5 py-4 sm:px-6">
    <?php if ($r['aktif']): ?>
    <p class="bg-success-50 text-theme-xs text-success-700 dark:bg-success-500/15 dark:text-success-500 inline-block rounded-full px-2 py-0.5 font-medium">Aktif</p>
    <?php else: ?>
    <p class="bg-error-50 text-theme-xs text-error-600 dark:bg-error-500/15 dark:text-error-500 inline-block rounded-full px-2 py-0.5 font-medium">Nonaktif</p>
    <?php endif; ?>
  </td>
  <td class="px-5 py-4 sm:px-6">
    <div class="flex items-center gap-2">
      <button type="button" title="Edit" @click="openEdit(<?= (int) $r['id'] ?>)" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-200">
        <svg class="stroke-current" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.862 3.487a2.25 2.25 0 1 1 3.182 3.182L7.5 19.213 3 21l1.787-4.5L16.862 3.487Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
      <button type="button" title="Hapus" data-id="<?= (int) $r['id'] ?>" data-nama="<?= html_escape($r['nama']) ?>" @click="remove($el.dataset.id, $el.dataset.nama)" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-error-500 hover:bg-error-50 dark:border-gray-800 dark:hover:bg-error-500/15">
        <svg class="stroke-current" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 7h12M9 7V5.5A1.5 1.5 0 0 1 10.5 4h3A1.5 1.5 0 0 1 15 5.5V7m2 0-.7 11a2 2 0 0 1-2 1.9H9.7a2 2 0 0 1-2-1.9L7 7m3 4v5m4-5v5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
    </div>
  </td>
</tr>
<?php endforeach; ?>
