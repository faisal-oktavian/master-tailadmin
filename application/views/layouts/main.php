<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title><?= html_escape($title) ?> | Master Backend</title>
    <meta name="csrf-name" content="<?= $this->security->get_csrf_token_name() ?>" />
    <meta name="csrf-hash" content="<?= $this->security->get_csrf_hash() ?>" />
    <meta name="base-url" content="<?= site_url() ?>" />
    <link rel="icon" href="<?= base_url('assets/images/favicon.ico') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>?v=<?= (int) @filemtime(FCPATH . 'assets/css/style.css') ?>" />
    <style>
      /* Loading konten saat pindah menu (tidak bergantung pada hasil build Tailwind) */
      .mn-loading{position:absolute;inset:0;z-index:30;display:flex;justify-content:center;background:rgba(255,255,255,.7)}
      .mn-loading[hidden]{display:none}
      .dark .mn-loading{background:rgba(17,24,39,.7)}
      .mn-loading-box{position:sticky;top:30vh;align-self:flex-start;display:flex;flex-direction:column;align-items:center;gap:.75rem}
      .mn-spinner{width:3rem;height:3rem;border:4px solid #465fff;border-top-color:transparent;border-radius:9999px;animation:mn-spin .8s linear infinite}
      .mn-loading-text{margin:0;font-size:.875rem;font-weight:500;color:#475467}
      .dark .mn-loading-text{color:#d0d5dd}
      @keyframes mn-spin{to{transform:rotate(360deg)}}
    </style>
    <script>
      window.__flash = <?= json_encode([
        'success' => $this->session->flashdata('success'),
        'error'   => $this->session->flashdata('error'),
      ], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
      <?php if (!empty($page_data)): ?>
      window.__pageData = <?= json_encode($page_data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
      <?php endif; ?>
    </script>
    <script defer src="<?= base_url('assets/js/bundle.js') ?>?v=<?= (int) @filemtime(FCPATH . 'assets/js/bundle.js') ?>"></script>
    <script defer src="<?= base_url('static/js/menu-nav.js') ?>?v=<?= (int) @filemtime(FCPATH . 'static/js/menu-nav.js') ?>"></script>
  </head>
  <body
    x-data="{ page: '<?= $page ?>', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}"
  >
    <!-- ===== Preloader Start ===== -->
    <?php $this->load->view('layouts/preloader'); ?>
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
      <!-- ===== Sidebar Start ===== -->
      <?php $this->load->view('layouts/sidebar'); ?>
      <!-- ===== Sidebar End ===== -->

      <!-- ===== Content Area Start ===== -->
      <div
        class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto"
      >
        <!-- Small Device Overlay Start -->
        <?php $this->load->view('layouts/overlay'); ?>
        <!-- Small Device Overlay End -->

        <!-- ===== Header Start ===== -->
        <?php $this->load->view('layouts/header'); ?>
        <!-- ===== Header End ===== -->

        <!-- ===== Main Content Start ===== -->
        <main class="relative flex-1">
          <!-- Loading konten: tampil saat pindah menu. Hanya menutup area konten,
               sidebar dan header tetap terlihat (lihat static/js/menu-nav.js) -->
          <div id="content-loading" class="mn-loading" hidden role="status" aria-live="polite">
            <div class="mn-loading-box">
              <span class="mn-spinner"></span>
              <p class="mn-loading-text">Loading...</p>
            </div>
          </div>

          <!-- #page-root = bagian yang diganti saat pindah menu (breadcrumb + isi halaman) -->
          <div id="page-root" class="<?= $main_class ?>">
            <?php $this->load->view('layouts/page'); ?>
          </div>
        </main>
        <!-- ===== Main Content End ===== -->
      </div>
      <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->
  </body>
</html>
