<?php
$current_uri = $_SERVER['REQUEST_URI'];
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu">
  <div class="app-brand demo">
    <a href="dashboard" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="/assets/img/logo.png" alt="" style="height: 50px;">
      </span>
      <span class="app-brand-text demo menu-text fw-bold ms-3">CODEZILLA</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i>
      <i class="icon-base ti tabler-x d-block d-xl-none"></i>
    </a>
  </div>


  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">

    <!-- Dashboards -->
    <li class="menu-item <?php echo strpos($current_uri,'student/myclass') ? 'active' : ''?>">
      <a href="/student/dashboard" class="menu-link">
        <i class="menu-icon icon-base fa-solid fa-graduation-cap"></i>
        <div data-i18n="Dashboard" class="mx-4">Dashboard</div>
      </a>
    </li>
    <li class="menu-item <?php echo strpos($current_uri,'student/playground') ? 'active' : ''?>">
      <a href="/student/playground"  class="menu-link">
        <i class="menu-icon icon-base fa-solid fa-code"></i>
        <div data-i18n="playground" class="mx-4">playground</div>
      </a>
    </li>
    <li class="menu-item  <?php echo strpos($current_uri,'student/problems') ? 'active' : ''?>">
      <a href="/student/problems"  class="menu-link">
        <i class="menu-icon icon-base fa-solid fas fa-brain"></i>
        <div data-i18n="Problems" class="mx-4">Problems</div>
      </a>
    </li>
</aside>