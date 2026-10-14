<?php if (!empty($breadcrumb)): ?>
<!-- Breadcrumb Start -->
<div class="flex flex-wrap items-center justify-between gap-3 pb-6">
  <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90"><?= html_escape($breadcrumb[count($breadcrumb) - 1]) ?></h2>
  <nav>
    <ol class="flex items-center gap-1.5">
      <li>
        <a
          class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
          href="<?= site_url('dashboard') ?>"
        >
          Home
          <svg class="stroke-current rtl:rotate-180" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </a>
      </li>
      <?php foreach ($breadcrumb as $i => $crumb): ?>
        <?php if ($i < count($breadcrumb) - 1): ?>
      <li>
        <a
          class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
          href="<?= site_url($breadcrumb_links[$i] ?? '#') ?>"
        >
          <?= html_escape($crumb) ?>
          <svg class="stroke-current rtl:rotate-180" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </a>
      </li>
        <?php else: ?>
      <li class="text-sm text-gray-800 dark:text-white/90"><?= html_escape($crumb) ?></li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ol>
  </nav>
</div>
<!-- Breadcrumb End -->
<?php endif; ?>

<?php $this->load->view($content); ?>
