<?php
$input_cls  = 'dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
$input_err  = 'dark:bg-dark-900 shadow-theme-xs focus:ring-error-500/10 h-11 w-full rounded-lg border border-error-500 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-error-500 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
$select_cls = 'dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
$area_cls   = 'dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30';
$label_cls  = 'mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400';
$opt_cls    = 'text-gray-700 dark:bg-gray-900 dark:text-gray-400';

// nilai: input lama (jika validasi gagal) > data record > default
$val = function ($field, $default = '') use ($row) {
    $old = set_value($field, '', FALSE);
    if ($old !== '') { return $old; }
    if (is_array($row) && isset($row[$field])) { return $row[$field]; }
    return $default;
};
$cls = function ($field) use ($input_cls, $input_err) {
    return form_error($field) ? $input_err : $input_cls;
};
$err = '<p class="text-theme-xs mt-1.5 text-error-500" data-error-for="%s"></p>';
$aktif = (string) $val('aktif', '1');
?>
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
  <div class="px-5 py-4 sm:px-6 sm:py-5">
    <h3 class="text-base font-medium text-gray-800 dark:text-white/90"><?= $is_edit ? 'Edit Supplier' : 'Tambah Supplier' ?></h3>
  </div>

  <form action="<?= $action ?>" method="post" id="supplier-form" data-confirm-save novalidate>
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />

    <div class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
      <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
        <div>
          <label class="<?= $label_cls ?>">Kode<span class="text-error-500">*</span></label>
          <input type="text" name="kode" maxlength="20" value="<?= html_escape($val('kode')) ?>" placeholder="SUP-004" class="<?= $cls('kode') ?>" />
          <?= sprintf($err, 'kode') ?>
        </div>
        <div>
          <label class="<?= $label_cls ?>">Nama Supplier<span class="text-error-500">*</span></label>
          <input type="text" name="nama" maxlength="100" value="<?= html_escape($val('nama')) ?>" placeholder="PT Contoh Sejahtera" class="<?= $cls('nama') ?>" />
          <?= sprintf($err, 'nama') ?>
        </div>
        <div>
          <label class="<?= $label_cls ?>">Email<span class="text-error-500">*</span></label>
          <input type="email" name="email" maxlength="100" value="<?= html_escape($val('email')) ?>" placeholder="sales@contoh.com" class="<?= $cls('email') ?>" />
          <?= sprintf($err, 'email') ?>
        </div>
        <div>
          <label class="<?= $label_cls ?>">Telepon<span class="text-error-500">*</span></label>
          <input type="tel" name="telepon" maxlength="20" value="<?= html_escape($val('telepon')) ?>" placeholder="031xxxxxxx" class="<?= $cls('telepon') ?>" />
          <?= sprintf($err, 'telepon') ?>
        </div>
        <div>
          <label class="<?= $label_cls ?>">Kota<span class="text-error-500">*</span></label>
          <input type="text" name="kota" maxlength="60" value="<?= html_escape($val('kota')) ?>" placeholder="Surabaya" class="<?= $cls('kota') ?>" />
          <?= sprintf($err, 'kota') ?>
        </div>
        <div>
          <label class="<?= $label_cls ?>">Status<span class="text-error-500">*</span></label>
          <div class="relative z-20 bg-transparent">
            <select name="aktif" class="<?= $select_cls ?>">
              <option value="1" class="<?= $opt_cls ?>" <?= $aktif === '1' ? 'selected' : '' ?>>Aktif</option>
              <option value="0" class="<?= $opt_cls ?>" <?= $aktif === '0' ? 'selected' : '' ?>>Nonaktif</option>
            </select>
            <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
              <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.79175 7.39551L10.0001 12.6038L15.2084 7.39551" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg>
            </span>
          </div>
          <?= sprintf($err, 'aktif') ?>
        </div>
        <div class="lg:col-span-2">
          <label class="<?= $label_cls ?>">Alamat<span class="text-error-500">*</span></label>
          <textarea name="alamat" rows="4" maxlength="500" placeholder="Alamat lengkap supplier..." class="<?= $area_cls ?><?= form_error('alamat') ? ' border-error-500 dark:border-error-500' : '' ?>"><?= html_escape($val('alamat')) ?></textarea>
          <?= sprintf($err, 'alamat') ?>
        </div>
      </div>

      <div class="mt-6 flex items-center gap-3 lg:justify-end">
        <a href="<?= site_url('supplier') ?>" data-menu-nav class="shadow-theme-xs flex w-full justify-center rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition ring-inset hover:bg-gray-50 sm:w-auto dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/3">Batal</a>
        <button type="submit" class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 flex w-full justify-center rounded-lg px-4 py-3 text-sm font-medium text-white transition sm:w-auto">Simpan</button>
      </div>
    </div>
  </form>
</div>
