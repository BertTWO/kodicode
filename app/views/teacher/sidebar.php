<?php
$current_uri = $_SERVER['REQUEST_URI'];
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu">
  <div class="app-brand demo">
    <a href="index.html" class="app-brand-link">
      <span class="app-brand-logo demo">
        <span class="text-primary">
          <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="currentColor" />
            <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
            <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="currentColor" />
          </svg>
        </span>
      </span>
      <span class="app-brand-text demo menu-text fw-bold ms-3">Teacher Dashboard</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i>
      <i class="icon-base ti tabler-x d-block d-xl-none"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard Section -->
    <li class="menu-item <?php echo strpos($current_uri,'student/myclass') ? 'active' : ''?>">
      <a href="/teacher/dashboard" class="menu-link">
        <i class="menu-icon icon-base fa-solid fa-graduation-cap"></i>
        <div data-i18n="Dashboard" class="mx-4">Dashboard</div>
      </a>
    </li>


    <!-- Manage Contests Section -->
    <li class="menu-item <?php echo strpos($current_uri, 'teacher/manage-contests') ? 'active' : '' ?>">
      <a href="/teacher/manage-contests" class="menu-link">
        <i class="menu-icon icon-base fa-solid fa-trophy"></i>
        <div data-i18n="Manage Contests" class="mx-4">Manage Contests</div>
      </a>
    </li>

    <!-- Manage Problems Section -->
    <li class="menu-item <?php echo strpos($current_uri, 'teacher/manage-problems') ? 'active' : '' ?>">
      <a href="/teacher/manage-problems" class="menu-link">
        <i class="menu-icon icon-base fa-solid fa-brain"></i>
        <div data-i18n="Manage Problems" class="mx-4">Manage Problems</div>
      </a>
    </li>

    <!-- Other Sections can be added below -->
  </ul>
</aside>
