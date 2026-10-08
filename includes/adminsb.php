<?php
$pageTitle = $pageTitle ?? 'DentaFlow | Admin';
$pageContentFile = $pageContentFile ?? null;
$activeNav = $activeNav ?? null;
$currentDoctorName = !empty($_SESSION['name']) ? $_SESSION['name'] : 'Sarah Chen';
$currentDoctorTitle = 'Dr. ' . (strpos($currentDoctorName, 'Dr.') === 0 ? substr($currentDoctorName, 3) : $currentDoctorName);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
<style>
  * {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
  }

  body {
    background: #f4f6fa;
    color: #1e293b;
    opacity: 1;
    transition: opacity 180ms ease;
  }

  body.is-leaving {
    opacity: 0.92;
  }

  /* Custom Sleek Dark Sidebar */
  .df-sidebar {
    background-color: #0c1729;
    border-right: 1px solid rgba(255, 255, 255, 0.05);
  }

  .sidebar-link {
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    color: #94a3b8;
  }

  .sidebar-link:hover {
    background-color: rgba(255, 255, 255, 0.06);
    color: #ffffff;
  }

  .sidebar-link.is-active {
    background-color: rgba(255, 255, 255, 0.08);
    color: #ffffff;
    font-weight: 500;
  }

  .sidebar-link.is-active i {
    color: #38bdf8;
  }

  /* Sidebar Collapsed Modes */
  .sidebar-collapsed .sidebar-text,
  .sidebar-collapsed .sidebar-badge,
  .sidebar-collapsed .sidebar-section-title {
    display: none !important;
  }

  .sidebar-collapsed .sidebar-link {
    justify-content: center;
    padding-left: 0.75rem;
    padding-right: 0.75rem;
  }

  .sidebar-collapsed .df-logo-text {
    display: none !important;
  }

  /* Custom scrollbar */
  .df-scrollbar::-webkit-scrollbar {
    width: 4px;
  }
  .df-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
  }

  @media print {
    body {
      background: #ffffff !important;
      opacity: 1 !important;
    }
    #sidebar,
    #topHeader,
    #mobileOverlay {
      display: none !important;
    }
    #contentCanvas {
      margin-left: 0 !important;
      padding-top: 0 !important;
      background: #ffffff !important;
    }
  }
</style>
</head>
<body class="min-h-screen antialiased">

<!-- Sidebar -->
<aside
  id="sidebar"
  class="df-sidebar fixed left-0 top-0 z-40 flex h-screen w-[260px] flex-col overflow-hidden text-slate-300 transition-all duration-300 -translate-x-full md:translate-x-0"
>
  <!-- Brand / Logo Area -->
  <div class="flex h-[72px] items-center justify-between px-5 border-b border-white/[0.06]">
    <a href="dashboard.php" class="flex items-center gap-3">
      <!-- DF Icon mark -->
      <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-[#1d6ee5] via-[#2563eb] to-[#38bdf8] text-white shadow-lg shadow-blue-500/30">
        <span class="text-sm font-black tracking-wider">DF</span>
      </div>
      <div class="df-logo-text">
        <span class="text-[20px] font-bold tracking-tight text-white">DentaFlow</span>
      </div>
    </a>
    
    <div class="flex items-center gap-1">
      <button
        id="desktopToggle"
        type="button"
        class="hidden rounded-lg p-1.5 text-slate-400 transition hover:bg-white/10 hover:text-white md:inline-flex"
        aria-label="Toggle sidebar"
        title="Toggle sidebar collapse"
      >
        <i data-feather="sidebar" class="h-4 w-4"></i>
      </button>
      <button
        id="mobileClose"
        type="button"
        class="rounded-lg p-1.5 text-slate-400 transition hover:bg-white/10 hover:text-white md:hidden"
        aria-label="Close sidebar"
      >
        <i data-feather="x" class="h-4 w-4"></i>
      </button>
    </div>
  </div>

  <!-- Navigation Menu -->
  <div class="df-scrollbar flex-1 overflow-y-auto px-3.5 py-4">
    <nav class="space-y-1">
      <!-- Dashboard -->
      <a href="dashboard.php" class="sidebar-link flex items-center justify-between rounded-xl px-3.5 py-3 text-[14px]">
        <div class="flex items-center gap-3.5">
          <i data-feather="home" class="h-[18px] w-[18px]"></i>
          <span class="sidebar-text">Dashboard</span>
        </div>
        <span class="sidebar-badge rounded-md bg-[#1d6ee5] px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white shadow-sm shadow-blue-500/20">Active</span>
      </a>

      <!-- Schedule -->
      <a href="appointments.php" class="sidebar-link flex items-center justify-between rounded-xl px-3.5 py-3 text-[14px]">
        <div class="flex items-center gap-3.5">
          <i data-feather="calendar" class="h-[18px] w-[18px]"></i>
          <span class="sidebar-text">Schedule</span>
        </div>
      </a>

      <!-- Patients -->
      <a href="patients.php" class="sidebar-link flex items-center justify-between rounded-xl px-3.5 py-3 text-[14px]">
        <div class="flex items-center gap-3.5">
          <i data-feather="users" class="h-[18px] w-[18px]"></i>
          <span class="sidebar-text">Patients</span>
        </div>
      </a>

      <!-- Billing -->
      <a href="treatments.php" class="sidebar-link flex items-center justify-between rounded-xl px-3.5 py-3 text-[14px]">
        <div class="flex items-center gap-3.5">
          <i data-feather="credit-card" class="h-[18px] w-[18px]"></i>
          <span class="sidebar-text">Billing</span>
        </div>
      </a>

      <!-- Reporting / Analytics -->
      <a href="analytics.php" class="sidebar-link flex items-center justify-between rounded-xl px-3.5 py-3 text-[14px]">
        <div class="flex items-center gap-3.5">
          <i data-feather="bar-chart-2" class="h-[18px] w-[18px]"></i>
          <span class="sidebar-text">Reporting</span>
        </div>
      </a>

      <!-- Treatment / Dental Chart -->
      <a href="dental-chart.php" class="sidebar-link flex items-center justify-between rounded-xl px-3.5 py-3 text-[14px]">
        <div class="flex items-center gap-3.5">
          <i data-feather="activity" class="h-[18px] w-[18px]"></i>
          <span class="sidebar-text">Treatment</span>
        </div>
      </a>
    </nav>

    <!-- Secondary clinical section -->
    <div class="my-4 border-t border-white/[0.06] pt-3">
      <p class="sidebar-section-title px-3.5 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">Clinical Tools</p>
      <nav class="space-y-1">
        <a href="treatments.php" class="sidebar-link flex items-center gap-3.5 rounded-xl px-3.5 py-2.5 text-[13px]">
          <i data-feather="file-text" class="h-4 w-4"></i>
          <span class="sidebar-text">Treatment Plans</span>
        </a>
        <a href="dental-chart.php" class="sidebar-link flex items-center gap-3.5 rounded-xl px-3.5 py-2.5 text-[13px]">
          <i data-feather="grid" class="h-4 w-4"></i>
          <span class="sidebar-text">Dental Chart</span>
        </a>
      </nav>
    </div>
  </div>

  <!-- Bottom Settings & Logout Area -->
  <div class="p-3 border-t border-white/[0.06]">
    <div class="space-y-1">
      <a href="about.php" class="sidebar-link flex items-center gap-3.5 rounded-xl px-3.5 py-2.5 text-[14px]">
        <i data-feather="settings" class="h-[18px] w-[18px]"></i>
        <span class="sidebar-text">settings</span>
      </a>
      <a href="logout.php" class="sidebar-link flex items-center gap-3.5 rounded-xl px-3.5 py-2.5 text-[14px] text-red-400/80 hover:text-red-300">
        <i data-feather="log-out" class="h-[18px] w-[18px]"></i>
        <span class="sidebar-text">Sign out</span>
      </a>
    </div>
  </div>
</aside>

<!-- Content Canvas -->
<main
  id="contentCanvas"
  class="min-h-screen bg-[#f4f6fa] transition-all duration-300 md:ml-[260px]"
>
  <!-- Top Navigation Bar -->
  <header
    id="topHeader"
    class="sticky top-0 z-30 flex h-[72px] items-center justify-between border-b border-slate-200/80 bg-white/95 px-5 sm:px-8 backdrop-blur-md"
  >
    <!-- Left: Mobile toggle + Global Search Input -->
    <div class="flex items-center gap-3 flex-1 max-w-lg">
      <button
        id="mobileOpen"
        type="button"
        class="inline-flex md:hidden items-center justify-center rounded-xl p-2 text-slate-600 hover:bg-slate-100 transition"
        aria-label="Open navigation"
      >
        <i data-feather="menu" class="h-5 w-5"></i>
      </button>

      <div class="relative w-full max-w-sm">
        <i data-feather="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
        <input
          type="text"
          id="globalSearchInput"
          placeholder="Search"
          class="w-full rounded-xl border border-slate-200 bg-slate-50/70 py-2 pl-10 pr-4 text-sm text-slate-800 placeholder:text-slate-400 transition hover:border-slate-300 focus:border-[#1d6ee5] focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100"
        >
      </div>
    </div>

    <!-- Right: Action Icons & Doctor Profile -->
    <div class="flex items-center gap-2.5 sm:gap-4">
      <!-- Notes / Bookmarks -->
      <button
        type="button"
        class="relative flex h-9 w-9 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-100 hover:text-slate-800"
        title="Quick Notes"
      >
        <i data-feather="bookmark" class="h-4.5 w-4.5"></i>
      </button>

      <!-- Notifications with Red Alert Dot -->
      <div class="relative">
        <button
          id="notifButton"
          type="button"
          class="relative flex h-9 w-9 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-100 hover:text-slate-800"
          title="Notifications"
        >
          <i data-feather="bell" class="h-4.5 w-4.5"></i>
          <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
        </button>
      </div>

      <div class="hidden sm:block h-6 w-px bg-slate-200"></div>

      <!-- Doctor Profile -->
      <div class="relative">
        <button
          id="profileDropdownBtn"
          type="button"
          class="flex items-center gap-2.5 rounded-xl p-1.5 transition hover:bg-slate-100"
        >
          <img
            src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&q=80&w=140&h=140"
            alt="<?= htmlspecialchars($currentDoctorTitle, ENT_QUOTES, 'UTF-8') ?>"
            class="h-9 w-9 rounded-full object-cover ring-2 ring-blue-500/20"
          >
          <div class="hidden sm:block text-left">
            <p class="text-sm font-semibold leading-tight text-slate-900"><?= htmlspecialchars($currentDoctorTitle, ENT_QUOTES, 'UTF-8') ?></p>
            <p class="text-[11px] font-medium text-slate-400">Admin</p>
          </div>
          <i data-feather="chevron-down" class="h-3.5 w-3.5 text-slate-400 hidden sm:block"></i>
        </button>

        <!-- Dropdown menu -->
        <div
          id="profileMenu"
          class="absolute right-0 top-full mt-2 hidden w-48 rounded-2xl border border-slate-100 bg-white py-2 shadow-xl shadow-slate-200/50 z-50"
        >
          <div class="px-4 py-2 border-b border-slate-100 sm:hidden">
            <p class="text-xs font-semibold text-slate-900"><?= htmlspecialchars($currentDoctorTitle, ENT_QUOTES, 'UTF-8') ?></p>
            <p class="text-[10px] text-slate-400">Admin</p>
          </div>
          <a href="patients.php" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">
            <i data-feather="user" class="h-3.5 w-3.5 text-slate-400"></i> My Profile
          </a>
          <a href="appointments.php" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">
            <i data-feather="calendar" class="h-3.5 w-3.5 text-slate-400"></i> My Schedule
          </a>
          <div class="my-1 border-t border-slate-100"></div>
          <a href="logout.php" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-red-600 hover:bg-red-50">
            <i data-feather="log-out" class="h-3.5 w-3.5 text-red-500"></i> Log out
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- Page Content Container -->
  <div>
    <?php if ($pageContentFile && file_exists($pageContentFile)) { include $pageContentFile; } ?>
  </div>
</main>

<!-- Mobile Overlay Backdrop -->
<div
  id="mobileOverlay"
  class="fixed inset-0 z-30 hidden bg-slate-950/40 backdrop-blur-sm transition-opacity md:hidden"
></div>

<script>
  feather.replace();

  const sidebar = document.getElementById('sidebar');
  const mobileOpen = document.getElementById('mobileOpen');
  const mobileClose = document.getElementById('mobileClose');
  const desktopToggle = document.getElementById('desktopToggle');
  const mobileOverlay = document.getElementById('mobileOverlay');
  const contentCanvas = document.getElementById('contentCanvas');
  const sidebarLinks = Array.from(document.querySelectorAll('.sidebar-link'));
  const sidebarStateKey = 'dentaflow-admin-sidebar-collapsed';
  const profileDropdownBtn = document.getElementById('profileDropdownBtn');
  const profileMenu = document.getElementById('profileMenu');

  // Toggle profile menu
  if (profileDropdownBtn && profileMenu) {
    profileDropdownBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      profileMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', () => {
      profileMenu.classList.add('hidden');
    });
  }

  function setActiveSidebarLink() {
    const currentPath = <?= json_encode($activeNav) ?> || window.location.pathname.split('/').pop() || 'dashboard.php';

    sidebarLinks.forEach(link => {
      const linkPath = (link.getAttribute('href') || '').split('/').pop();
      const isActive = linkPath && linkPath !== '#' && linkPath === currentPath;
      link.classList.toggle('is-active', isActive);

      // Manage active badge pill: only show on currently active link
      const badge = link.querySelector('.sidebar-badge');
      if (badge) {
        badge.classList.toggle('hidden', !isActive);
      }
    });
  }

  function applyDesktopSidebarState(isCollapsed) {
    sidebar.classList.toggle('sidebar-collapsed', isCollapsed);
    sidebar.classList.toggle('w-[260px]', !isCollapsed);
    sidebar.classList.toggle('w-20', isCollapsed);
    contentCanvas.classList.toggle('md:ml-[260px]', !isCollapsed);
    contentCanvas.classList.toggle('md:ml-20', isCollapsed);
  }

  function setDesktopState() {
    if (window.innerWidth >= 768) {
      sidebar.classList.remove('-translate-x-full');
      mobileOverlay.classList.add('hidden');
      const isCollapsed = window.localStorage.getItem(sidebarStateKey) === 'true';
      applyDesktopSidebarState(isCollapsed);
    } else {
      sidebar.classList.add('-translate-x-full');
      sidebar.classList.remove('sidebar-collapsed', 'w-20');
      sidebar.classList.add('w-[260px]');
      contentCanvas.classList.remove('md:ml-20');
      contentCanvas.classList.add('md:ml-[260px]');
    }
  }

  function openMobileSidebar() {
    sidebar.classList.remove('-translate-x-full');
    mobileOverlay.classList.remove('hidden');
  }

  function closeMobileSidebar() {
    if (window.innerWidth < 768) {
      sidebar.classList.add('-translate-x-full');
      mobileOverlay.classList.add('hidden');
    }
  }

  function toggleDesktopSidebar() {
    if (window.innerWidth >= 768) {
      const shouldCollapse = !sidebar.classList.contains('sidebar-collapsed');
      applyDesktopSidebarState(shouldCollapse);
      window.localStorage.setItem(sidebarStateKey, shouldCollapse ? 'true' : 'false');
    }
  }

  if (mobileOpen) mobileOpen.addEventListener('click', openMobileSidebar);
  if (mobileClose) mobileClose.addEventListener('click', closeMobileSidebar);
  if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileSidebar);
  if (desktopToggle) desktopToggle.addEventListener('click', toggleDesktopSidebar);
  window.addEventListener('resize', setDesktopState);

  setActiveSidebarLink();
  setDesktopState();
</script>

</body>
</html>
