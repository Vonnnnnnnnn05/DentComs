<?php
$pageTitle = $pageTitle ?? 'Dentcoms | Admin';
$pageContentFile = $pageContentFile ?? null;
$activeNav = $activeNav ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
<style>
  * {
    font-family: 'Inter', sans-serif;
  }

  body {
    background: #f3f6fb;
    opacity: 1;
    transition: opacity 180ms ease;
  }

  body.is-leaving {
    opacity: 0.92;
  }

  .sidebar-shell {
    background: #ffffff;
    box-shadow: 10px 0 28px -24px rgba(15, 23, 42, 0.28);
  }

  .sidebar-link {
    transition: background-color 0.2s ease, color 0.2s ease, transform 0.14s ease, box-shadow 0.18s ease;
  }

  .sidebar-link:hover {
    background-color: #f4f8fd;
  }

  .sidebar-link:active,
  .sidebar-link.is-pressed {
    transform: scale(0.985);
    box-shadow: inset 0 0 0 1px rgba(47, 137, 220, 0.08);
  }

  .sidebar-link.is-active {
    background-color: #dbe8f7;
    color: #1976d2;
  }

  .sidebar-link.is-active i {
    color: #1976d2;
  }

  .sidebar-collapsed .sidebar-text,
  .sidebar-collapsed .sidebar-section,
  .sidebar-collapsed .sidebar-profile {
    display: none;
  }

  .sidebar-collapsed .sidebar-link {
    justify-content: center;
  }

  .sidebar-collapsed .sidebar-text,
  .sidebar-collapsed .sidebar-section,
  .sidebar-collapsed .sidebar-profile {
    display: none;
  }

  @media print {
    body {
      background: #ffffff !important;
      opacity: 1 !important;
    }

    #sidebar,
    #mobileOpen,
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

<button
  id="mobileOpen"
  type="button"
  class="fixed left-3 top-3 z-30 inline-flex items-center justify-center rounded-lg bg-[#2f89dc] p-2.5 text-white shadow-lg md:hidden"
  aria-label="Open sidebar"
>
  <i data-feather="menu" class="h-4.5 w-4.5"></i>
</button>

<aside
  id="sidebar"
  class="sidebar-shell fixed left-0 top-0 z-40 flex h-screen w-[288px] flex-col overflow-hidden text-slate-800 transition-all duration-300 md:translate-x-0"
>
  <div class="flex items-center justify-between bg-[#2f89dc] px-3 py-2.5 text-white">
    <div class="flex items-center gap-3 min-w-0">
      <button
        id="desktopToggle"
        type="button"
        class="hidden rounded-lg p-1.5 text-white transition hover:bg-white/10 md:inline-flex"
        aria-label="Toggle sidebar"
      >
        <i data-feather="menu" class="h-4 w-4"></i>
      </button>
      <div class="flex h-8 w-8 items-center justify-center bg-white shadow-sm">
        <i data-feather="activity" class="h-4 w-4 text-[#2f89dc]"></i>
      </div>
      <div class="sidebar-text min-w-0">
        <p class="truncate text-[20px] font-medium tracking-tight text-white">DentcomsDental</p>
      </div>
    </div>
    <button
      id="mobileClose"
      type="button"
      class="rounded-lg p-1.5 text-white transition hover:bg-white/10 md:hidden"
      aria-label="Close sidebar"
    >
      <i data-feather="x" class="h-3.5 w-3.5"></i>
    </button>
  </div>

  <div class="flex-1 overflow-y-auto bg-white px-3 py-3">
    <nav class="space-y-1.5">
      <a href="dashboard.php" class="sidebar-link flex items-center gap-3.5 rounded-full px-3.5 py-3 text-[15px] font-normal text-black">
        <i data-feather="home" class="h-5 w-5 text-slate-500"></i>
        <span class="sidebar-text">Dashboard</span>
      </a>
      <a href="patients.php" class="sidebar-link flex items-center gap-3.5 rounded-full px-3.5 py-3 text-[15px] font-normal text-black">
        <i data-feather="users" class="h-5 w-5 text-slate-500"></i>
        <span class="sidebar-text">patients</span>
      </a>
      <a href="treatments.php" class="sidebar-link flex items-center gap-3.5 rounded-full px-3.5 py-3 text-[15px] font-normal text-black">
        <i data-feather="heart" class="h-5 w-5 text-slate-500"></i>
        <span class="sidebar-text">Treatments Plans</span>
      </a>
      <a href="appointments.php" class="side  bar-link flex items-center gap-3.5 rounded-full px-3.5 py-3 text-[15px] font-normal text-black">
        <i data-feather="calendar" class="h-5 w-5 text-slate-500"></i>
        <span class="sidebar-text">Appointment Calendar</span>
      </a>
      <a href="analytics.php" class="sidebar-link flex items-center gap-3.5 rounded-full px-3.5 py-3 text-[15px] font-normal text-black">
        <i data-feather="bar-chart-2" class="h-5 w-5 text-slate-500"></i>
        <span class="sidebar-text">Analytics</span>
      </a>
      <a href="dental-chart.php" class="sidebar-link flex items-center gap-3.5 rounded-full px-3.5 py-3 text-[15px] font-normal text-black">
        <i data-feather="grid" class="h-5 w-5 text-slate-500"></i>
        <span class="sidebar-text">Dental Chart</span>
      </a>
      <a href="payments.php" class="sidebar-link flex items-center gap-3.5 rounded-full px-3.5 py-3 text-[15px] font-normal text-black">
        <i data-feather="dollar-sign" class="h-5 w-5 text-slate-500"></i>
        <span class="sidebar-text">Payments</span>
      </a>
      <a href="treatment-rooms.php" class="sidebar-link flex items-center gap-3.5 rounded-full px-3.5 py-3 text-[15px] font-normal text-black">
        <i data-feather="sidebar" class="h-5 w-5 text-slate-500"></i>
        <span class="sidebar-text">Treatment Rooms</span>
      </a>
      <a href="map.php" class="sidebar-link flex items-center gap-3.5 rounded-full px-3.5 py-3 text-[15px] font-normal text-black">
        <i data-feather="map-pin" class="h-5 w-5 text-slate-500"></i>
        <span class="sidebar-text">Map</span>
      </a>
    </nav>

    <div class="mx-2.5 my-2.5 border-t border-slate-200"></div>

    <nav class="space-y-1.5">
      <a href="about.php" class="sidebar-link flex items-center gap-3.5 rounded-full px-3.5 py-3 text-[15px] font-normal text-black">
        <i data-feather="info" class="h-5 w-5 text-slate-500"></i>
        <span class="sidebar-text">About</span>
      </a>
      <a href="feedback.php" class="sidebar-link flex items-center gap-3.5 rounded-full px-3.5 py-3 text-[15px] font-normal text-black">
        <i data-feather="message-square" class="h-5 w-5 text-slate-500"></i>
        <span class="sidebar-text">Feedback</span>
      </a>
    </nav>

    <div class="mx-2.5 my-2.5 border-t border-slate-200"></div>

    <nav class="space-y-1.5">
      <a href="#" class="sidebar-link flex items-center gap-3.5 rounded-full px-3.5 py-3 text-[15px] font-normal text-black">
        <i data-feather="grid" class="h-5 w-5 text-slate-500"></i>
        <span class="sidebar-text">App Gallery</span>
      </a>
    <nav class="space-y-1.5">
      <a href="logout.php" class="sidebar-link flex items-center gap-3.5 rounded-full px-3.5 py-3 text-[15px] font-normal text-black">
        <i data-feather="log-out" class="h-5 w-5 text-slate-500"></i>
        <span class="sidebar-text">Logout</span>
      </a>
    </nav>
  </div>
</aside>

<main
  id="contentCanvas"
  class="min-h-screen bg-[#f4f7fc] pt-16 md:ml-[288px] md:block md:pt-0"
>
  <?php if ($pageContentFile && file_exists($pageContentFile)) { include $pageContentFile; } ?>
</main>

<div
  id="mobileOverlay"
  class="fixed inset-0 z-30 hidden bg-slate-950/35 backdrop-blur-[2px] md:hidden"
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
  const sidebarStateKey = 'dentcoms-admin-sidebar-collapsed';

  function setActiveSidebarLink() {
    const currentPath = <?= json_encode($activeNav) ?> || window.location.pathname.split('/').pop() || 'dashboard.php';

    sidebarLinks.forEach(link => {
      const linkPath = (link.getAttribute('href') || '').split('/').pop();
      const isActive = linkPath && linkPath !== '#' && linkPath === currentPath;
      link.classList.toggle('is-active', isActive);
    });
  }

  function enableSmoothSidebarNavigation() {
    sidebarLinks.forEach(link => {
      const href = link.getAttribute('href') || '';
      if (!href || href === '#') return;

      link.addEventListener('click', (e) => {
        if (
          e.defaultPrevented ||
          e.button !== 0 ||
          e.metaKey ||
          e.ctrlKey ||
          e.shiftKey ||
          e.altKey
        ) {
          return;
        }

        e.preventDefault();
        link.classList.add('is-pressed');
        document.body.classList.add('is-leaving');

        window.setTimeout(() => {
          window.location.href = href;
        }, 140);
      });
    });
  }

  function applyDesktopSidebarState(isCollapsed) {
    sidebar.classList.toggle('sidebar-collapsed', isCollapsed);
    sidebar.classList.toggle('w-[288px]', !isCollapsed);
    sidebar.classList.toggle('w-20', isCollapsed);
    contentCanvas.classList.toggle('md:ml-[288px]', !isCollapsed);
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
      sidebar.classList.remove('sidebar-collapsed');
      sidebar.classList.remove('w-20');
      sidebar.classList.add('w-[288px]');
      contentCanvas.classList.remove('md:ml-20');
      contentCanvas.classList.add('md:ml-[288px]');
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
      sidebar.classList.add('overflow-hidden');
      const shouldCollapse = !sidebar.classList.contains('sidebar-collapsed');
      applyDesktopSidebarState(shouldCollapse);
      window.localStorage.setItem(sidebarStateKey, shouldCollapse ? 'true' : 'false');
    }
  }

  mobileOpen.addEventListener('click', openMobileSidebar);
  mobileClose.addEventListener('click', closeMobileSidebar);
  mobileOverlay.addEventListener('click', closeMobileSidebar);
  desktopToggle.addEventListener('click', toggleDesktopSidebar);
  window.addEventListener('resize', setDesktopState);

  setActiveSidebarLink();
  enableSmoothSidebarNavigation();
  setDesktopState();
</script>

</body>
</html>
