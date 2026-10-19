<aside :class="sidebarToggle ? 'translate-x-0 xl:w-22.5' : '-translate-x-full rtl:translate-x-full'" class="sidebar fixed top-0 left-0 z-9999 flex h-screen w-72.5 flex-col overflow-y-auto border-r border-gray-200 bg-white px-5 transition-all duration-300 xl:static xl:translate-x-0 rtl:right-0 rtl:left-auto rtl:border-r-0 rtl:border-l dark:border-gray-800 dark:bg-black" @click.outside="if (window.innerWidth < 1280) sidebarToggle = false">
  <!-- SIDEBAR HEADER -->
    <div :class="sidebarToggle ? 'justify-center' : 'justify-between'" class="sidebar-header flex items-center gap-2 pt-8 pb-7" >
      <a href="<?= site_url('dashboard') ?>">
        <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
          <img class="dark:hidden" src="<?= base_url('assets/images/') ?>logo/logo.svg" alt="Logo" />
          <img class="hidden dark:block" src="<?= base_url('assets/images/') ?>logo/logo-dark.svg" alt="Logo" />
        </span>

        <img class="logo-icon" :class="sidebarToggle ? 'lg:block' : 'hidden'" src="<?= base_url('assets/images/') ?>logo/logo-icon.svg" alt="Logo" />
      </a>
    </div>
  <!-- SIDEBAR HEADER -->

  <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear" >
    <!-- Sidebar Menu -->
      <nav>
        <!-- DASHBOARD -->
        <div>
          <h3 class="mb-4 text-xs leading-5 text-gray-400 uppercase">
            <span class="menu-group-title" :class="sidebarToggle ? 'xl:hidden' : ''">
              MENU
            </span>

            <svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'" class="mx-auto fill-current menu-group-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" >
              <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z" fill="" />
            </svg>
          </h3>

          <ul class="mb-6 flex flex-col gap-1">
            <?php if (!empty($menu_access['dashboard'])): ?>
              <li>
                <a href="<?= site_url('dashboard') ?>" class="menu-item group" :class="page === 'dashboard' ? 'menu-item-active' : 'menu-item-inactive'" >
                  <svg :class="page === 'dashboard' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" >
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V8.99998C3.25 10.2426 4.25736 11.25 5.5 11.25H9C10.2426 11.25 11.25 10.2426 11.25 8.99998V5.5C11.25 4.25736 10.2426 3.25 9 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H9C9.41421 4.75 9.75 5.08579 9.75 5.5V8.99998C9.75 9.41419 9.41421 9.74998 9 9.74998H5.5C5.08579 9.74998 4.75 9.41419 4.75 8.99998V5.5ZM5.5 12.75C4.25736 12.75 3.25 13.7574 3.25 15V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H9C10.2426 20.75 11.25 19.7427 11.25 18.5V15C11.25 13.7574 10.2426 12.75 9 12.75H5.5ZM4.75 15C4.75 14.5858 5.08579 14.25 5.5 14.25H9C9.41421 14.25 9.75 14.5858 9.75 15V18.5C9.75 18.9142 9.41421 19.25 9 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V15ZM12.75 5.5C12.75 4.25736 13.7574 3.25 15 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V8.99998C20.75 10.2426 19.7426 11.25 18.5 11.25H15C13.7574 11.25 12.75 10.2426 12.75 8.99998V5.5ZM15 4.75C14.5858 4.75 14.25 5.08579 14.25 5.5V8.99998C14.25 9.41419 14.5858 9.74998 15 9.74998H18.5C18.9142 9.74998 19.25 9.41419 19.25 8.99998V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H15ZM15 12.75C13.7574 12.75 12.75 13.7574 12.75 15V18.5C12.75 19.7426 13.7574 20.75 15 20.75H18.5C19.7426 20.75 20.75 19.7427 20.75 18.5V15C20.75 13.7574 19.7426 12.75 18.5 12.75H15ZM14.25 15C14.25 14.5858 14.5858 14.25 15 14.25H18.5C18.9142 14.25 19.25 14.5858 19.25 15V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15C14.5858 19.25 14.25 18.9142 14.25 18.5V15Z" fill="currentColor" />
                  </svg>
                  <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">Dashboard</span>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </div>

        <!-- MASTER DATA -->
        <div>
          <h3 class="mb-4 text-xs leading-5 text-gray-400 uppercase">
            <span class="menu-group-title" :class="sidebarToggle ? 'xl:hidden' : ''">MASTER DATA</span>
            <svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'" class="mx-auto fill-current menu-group-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z" fill=""/></svg>
          </h3>

          <ul class="mb-6 flex flex-col gap-1">
            <?php if (!empty($menu_access['karyawan'])): ?>
              <li>
                <a href="<?= site_url('karyawan') ?>" class="menu-item group" :class="page === 'karyawan' ? 'menu-item-active' : 'menu-item-inactive'" >
                  <svg :class="page === 'karyawan' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" >
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H18.5001C19.7427 20.75 20.7501 19.7426 20.7501 18.5V5.5C20.7501 4.25736 19.7427 3.25 18.5001 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H18.5001C18.9143 4.75 19.2501 5.08579 19.2501 5.5V18.5C19.2501 18.9142 18.9143 19.25 18.5001 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V5.5ZM6.25005 9.7143C6.25005 9.30008 6.58583 8.9643 7.00005 8.9643L17 8.96429C17.4143 8.96429 17.75 9.30008 17.75 9.71429C17.75 10.1285 17.4143 10.4643 17 10.4643L7.00005 10.4643C6.58583 10.4643 6.25005 10.1285 6.25005 9.7143ZM6.25005 14.2857C6.25005 13.8715 6.58583 13.5357 7.00005 13.5357H17C17.4143 13.5357 17.75 13.8715 17.75 14.2857C17.75 14.6999 17.4143 15.0357 17 15.0357H7.00005C6.58583 15.0357 6.25005 14.6999 6.25005 14.2857Z" fill="currentColor" />
                  </svg>
                  <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">Master Karyawan</span>
                </a>
              </li>
            <?php endif; ?>

            <?php if (!empty($menu_access['supplier'])): ?>
              <li>
                <a href="<?= site_url('supplier') ?>" class="menu-item group" :class="page === 'supplier' ? 'menu-item-active' : 'menu-item-inactive'">
                  <svg :class="page === 'supplier' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" >
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.25 5.5C3.25 4.25736 4.25736 3.25 5.5 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V18.5C20.75 19.7426 19.7426 20.75 18.5 20.75H5.5C4.25736 20.75 3.25 19.7426 3.25 18.5V5.5ZM5.5 4.75C5.08579 4.75 4.75 5.08579 4.75 5.5V8.58325L19.25 8.58325V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H5.5ZM19.25 10.0833H15.416V13.9165H19.25V10.0833ZM13.916 10.0833L10.083 10.0833V13.9165L13.916 13.9165V10.0833ZM8.58301 10.0833H4.75V13.9165H8.58301V10.0833ZM4.75 18.5V15.4165H8.58301V19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5ZM10.083 19.25V15.4165L13.916 15.4165V19.25H10.083ZM15.416 19.25V15.4165H19.25V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15.416Z" fill="currentColor" />
                  </svg>
                  <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">Master Supplier</span>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </div>

        <!-- ADMINISTRATOR -->
        <?php if (!empty($menu_access['user']) || !empty($menu_access['user_role'])): ?>
          <div>
            <h3 class="mb-4 text-xs leading-5 text-gray-400 uppercase">
              <span class="menu-group-title" :class="sidebarToggle ? 'xl:hidden' : ''">ADMINISTRASI</span>
              <svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'" class="mx-auto fill-current menu-group-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2.75a4.25 4.25 0 0 0-4.25 4.25v1.25H6.5A2.75 2.75 0 0 0 3.75 11v8A2.75 2.75 0 0 0 6.5 21.75h11A2.75 2.75 0 0 0 20.25 19v-8a2.75 2.75 0 0 0-2.75-2.75h-1.25V7A4.25 4.25 0 0 0 12 2.75ZM9.25 7a2.75 2.75 0 0 1 5.5 0v1.25h-5.5V7Zm-2.75 2.75h11c.69 0 1.25.56 1.25 1.25v8c0 .69-.56 1.25-1.25 1.25h-11c-.69 0-1.25-.56-1.25-1.25v-8c0-.69.56-1.25 1.25-1.25Zm5.5 2a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75Z" fill=""/></svg>
            </h3>

            <ul class="mb-6 flex flex-col gap-1">
              <?php if (!empty($menu_access['user'])): ?>
                <li>
                  <a href="<?= site_url('user') ?>" data-menu-nav class="menu-item group" :class="page === 'user' ? 'menu-item-active' : 'menu-item-inactive'">
                    <svg :class="page === 'user' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 3.5a4 4 0 1 0 0 8 4 4 0 0 0 0-8ZM9.5 7.5a2.5 2.5 0 1 1 5 0 2.5 2.5 0 0 1-5 0ZM12 13.25c-4.06 0-7.25 2.2-7.25 5.25v.25c0 .83.67 1.5 1.5 1.5h11.5c.83 0 1.5-.67 1.5-1.5v-.25c0-3.05-3.19-5.25-7.25-5.25ZM6.25 18.5c0-1.9 2.2-3.75 5.75-3.75s5.75 1.85 5.75 3.75H6.25Z" fill="currentColor"/></svg>
                    <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">User</span>
                  </a>
                </li>
              <?php endif; ?>
              
              <?php if (!empty($menu_access['user_role'])): ?>
                <li>
                  <a href="<?= site_url('user_role') ?>" data-menu-nav class="menu-item group" :class="page === 'user_role' ? 'menu-item-active' : 'menu-item-inactive'">
                    <svg :class="page === 'user_role' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2.75a4.25 4.25 0 0 0-4.25 4.25v1.25H6.5A2.75 2.75 0 0 0 3.75 11v8A2.75 2.75 0 0 0 6.5 21.75h11A2.75 2.75 0 0 0 20.25 19v-8a2.75 2.75 0 0 0-2.75-2.75h-1.25V7A4.25 4.25 0 0 0 12 2.75ZM9.25 7a2.75 2.75 0 0 1 5.5 0v1.25h-5.5V7Zm-2.75 2.75h11c.69 0 1.25.56 1.25 1.25v8c0 .69-.56 1.25-1.25 1.25h-11c-.69 0-1.25-.56-1.25-1.25v-8c0-.69.56-1.25 1.25-1.25Zm5.5 2a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75Z" fill="currentColor"/></svg>
                    <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">Hak Akses</span>
                  </a>
                </li>
              <?php endif; ?>
            </ul>
          </div>
        <?php endif; ?>

      </nav>
    <!-- Sidebar Menu -->
  </div>
</aside>
