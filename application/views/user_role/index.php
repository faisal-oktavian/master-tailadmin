<?php
$notice = isset($notice) ? $notice : null;
$users = isset($users) ? $users : array();
$selected_user = isset($selected_user) ? $selected_user : null;
$permissions = isset($permissions) ? $permissions : array();
$modules = isset($modules) ? $modules : array();
?>
<section class="space-y-6">
  <?php if ($notice): ?>
    <div role="status" class="rounded-lg border border-brand-200 bg-brand-50 px-4 py-3 text-sm text-brand-700 dark:border-brand-800 dark:bg-brand-900/20 dark:text-brand-300"><?= html_escape($notice) ?></div>
  <?php endif; ?>

  <div class="border-b border-gray-200 pb-5 dark:border-gray-800">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">Hak Akses User</h2>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Atur izin menu untuk setiap akun secara terpisah.</p>
  </div>

  <section class="max-w-3xl">
    <h3 class="mb-3 text-sm font-semibold text-gray-800 dark:text-white/90">Pilih User</h3>
    <form method="get" action="<?= site_url('user_role') ?>">
      <select name="user_id" onchange="var u = this.form.action + '?user_id=' + encodeURIComponent(this.value); window.__navigateMenu ? window.__navigateMenu(u, true, { minimumLoadingMs: window.__modalLoadingDelay || 800 }) : (location.href = u)" class="h-11 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
        <?php foreach ($users as $user): ?>
          <option value="<?= (int) $user['id'] ?>" <?= $selected_user && (int) $selected_user['id'] === (int) $user['id'] ? 'selected' : '' ?>><?= html_escape($user['nama']) ?> (<?= html_escape($user['email']) ?>)</option>
        <?php endforeach; ?>
      </select>
    </form>
  </section>

  <?php if ($selected_user): ?>
    <section class="max-w-3xl">
      <div class="mb-4 border-b border-gray-200 pb-3 dark:border-gray-800">
        <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">Izin menu: <?= html_escape($selected_user['nama']) ?></h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400"><?= html_escape($selected_user['email']) ?> · <?= html_escape($selected_user['role_title'] ?: 'Tanpa role') ?></p>
      </div>

      <?php if (in_array(strtolower($selected_user['role_name']), array('administrator', 'superadmin'), TRUE)): ?>
        <p class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-600 dark:border-gray-800 dark:bg-white/3 dark:text-gray-300">Akun Administrator selalu memiliki akses penuh ke semua menu.</p>
      <?php else: ?>
        <?= form_open('user_role/save_permissions') ?>
          <input type="hidden" name="user_id" value="<?= (int) $selected_user['id'] ?>" />
          <div class="divide-y divide-gray-200 border-y border-gray-200 dark:divide-gray-800 dark:border-gray-800">
            <?php foreach ($modules as $menu_name => $label): ?>
              <label class="flex min-h-12 items-center justify-between gap-4 py-2 text-sm text-gray-700 dark:text-gray-300">
                <span><?= html_escape($label) ?></span>
                <input type="checkbox" name="permissions[<?= html_escape($menu_name) ?>]" value="1" <?= !empty($permissions[$menu_name]) ? 'checked' : '' ?> class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500" />
              </label>
            <?php endforeach; ?>
          </div>
          <button type="submit" class="mt-4 inline-flex h-11 items-center rounded-lg bg-brand-500 px-4 text-sm font-medium text-white hover:bg-brand-600">Simpan Hak Akses</button>
        <?= form_close() ?>
      <?php endif; ?>
    </section>
  <?php elseif (!$users): ?>
    <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada user untuk diatur.</p>
  <?php endif; ?>
</section>