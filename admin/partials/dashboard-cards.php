<?php
// Formatting values with fallbacks matching the mockup
$displayPatients = $totalPatientsCount > 0 ? number_format($totalPatientsCount) : '3,142';
$displayNewToday = $newTodayCount > 0 ? $newTodayCount : '8';
$displayAppointmentsToday = $todayAppointmentsCount > 0 ? $todayAppointmentsCount : '16';
$displayRevenue = $totalRevenueAmount > 0 ? '$' . number_format($totalRevenueAmount) : '$62,800';

$greetingDoctor = !empty($_SESSION['name']) ? 'Dr. ' . $_SESSION['name'] : 'Dr. Chen';
?>
<section class="px-4 py-6 sm:px-8">
  <div class="mx-auto max-w-[1400px]">

    <!-- Welcome Header & Top Controls -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
          Welcome, <?= htmlspecialchars($greetingDoctor, ENT_QUOTES, 'UTF-8') ?>
        </h1>
        <p class="mt-1 text-xs sm:text-sm font-medium text-slate-500">
          Today: <?= date('D, M j, Y') ?>
        </p>
      </div>

      <div class="flex items-center gap-2.5 sm:gap-3">
        <!-- Monthly trend dropdown -->
        <div class="relative">
          <button
            id="periodFilterBtn"
            type="button"
            class="flex items-center gap-2 rounded-xl border border-slate-200/90 bg-white px-3.5 py-2 text-xs sm:text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 hover:border-slate-300"
          >
            <span>Monthly trend</span>
            <i data-feather="chevron-down" class="h-3.5 w-3.5 text-slate-400"></i>
          </button>
        </div>

        <!-- Settings Cog button -->
        <button
          type="button"
          class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200/90 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50 hover:border-slate-300"
          title="Dashboard Preferences"
        >
          <i data-feather="settings" class="h-4 w-4"></i>
        </button>

        <!-- + Add New Primary Button -->
        <button
          id="openQuickAddBtn"
          type="button"
          class="flex items-center gap-1.5 rounded-xl bg-[#1d6ee5] px-4 py-2 text-xs sm:text-sm font-semibold text-white shadow-sm shadow-blue-600/25 transition hover:bg-[#1558b8]"
        >
          <i data-feather="plus" class="h-4 w-4"></i>
          <span>Add New</span>
        </button>
      </div>
    </div>

    <!-- Row 1: Four Stat Cards -->
    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
      
      <!-- Card 1: Total Patients -->
      <article class="rounded-2xl border border-slate-200/70 bg-white p-5 shadow-[0_4px_20px_-4px_rgba(15,23,42,0.04)] transition hover:shadow-md">
        <div class="flex items-center justify-between">
          <p class="text-xs sm:text-sm font-medium text-slate-500">Total Patients</p>
          <i data-feather="users" class="h-4 w-4 text-slate-400"></i>
        </div>
        <div class="mt-4 flex items-baseline justify-between">
          <div class="flex items-baseline gap-2">
            <span class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?= $displayPatients ?></span>
            <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-600">+15%</span>
          </div>
          <!-- Sparkline Wave -->
          <svg class="h-6 w-16 sm:w-20 text-[#1d6ee5]" viewBox="0 0 80 24" fill="none">
            <path d="M2 18 C 15 17, 25 19, 40 12 C 55 5, 65 9, 78 4" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </article>

      <!-- Card 2: New Today -->
      <article class="rounded-2xl border border-slate-200/70 bg-white p-5 shadow-[0_4px_20px_-4px_rgba(15,23,42,0.04)] transition hover:shadow-md">
        <div class="flex items-center justify-between">
          <p class="text-xs sm:text-sm font-medium text-slate-500">New Today</p>
          <i data-feather="info" class="h-4 w-4 text-slate-400"></i>
        </div>
        <div class="mt-4 flex items-baseline justify-between">
          <span class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?= $displayNewToday ?></span>
          <!-- Sparkline Wave -->
          <svg class="h-6 w-16 sm:w-20 text-[#1d6ee5]" viewBox="0 0 80 24" fill="none">
            <path d="M2 19 C 18 19, 25 21, 38 15 C 50 8, 62 10, 78 5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </article>

      <!-- Card 3: Appointments Today -->
      <article class="rounded-2xl border border-slate-200/70 bg-white p-5 shadow-[0_4px_20px_-4px_rgba(15,23,42,0.04)] transition hover:shadow-md">
        <div class="flex items-center justify-between">
          <p class="text-xs sm:text-sm font-medium text-slate-500">Appointments Today</p>
          <i data-feather="calendar" class="h-4 w-4 text-slate-400"></i>
        </div>
        <div class="mt-4 flex items-baseline justify-between">
          <span class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?= $displayAppointmentsToday ?></span>
          <!-- Sparkline Wave -->
          <svg class="h-6 w-16 sm:w-20 text-[#1d6ee5]" viewBox="0 0 80 24" fill="none">
            <path d="M2 18 C 14 18, 22 17, 34 14 C 46 11, 58 13, 78 4" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </article>

      <!-- Card 4: Total Revenue This Month -->
      <article class="rounded-2xl border border-slate-200/70 bg-white p-5 shadow-[0_4px_20px_-4px_rgba(15,23,42,0.04)] transition hover:shadow-md">
        <div class="flex items-center justify-between">
          <p class="text-xs sm:text-sm font-medium text-slate-500">Total Revenue This Month</p>
          <i data-feather="credit-card" class="h-4 w-4 text-slate-400"></i>
        </div>
        <div class="mt-4 flex items-baseline justify-between">
          <div class="flex items-baseline gap-2">
            <span class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?= $displayRevenue ?></span>
            <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-600">+8.5%</span>
          </div>
          <!-- Sparkline Wave -->
          <svg class="h-6 w-16 sm:w-20 text-[#1d6ee5]" viewBox="0 0 80 24" fill="none">
            <path d="M2 19 C 16 19, 28 17, 42 12 C 56 7, 68 10, 78 5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </article>

    </div>

    <!-- Row 2: Today's Appointment Schedule & Treatment Revenue -->
    <div class="mt-6 grid grid-cols-1 gap-5 lg:grid-cols-12">
      
      <!-- Left: Today's Appointment Schedule (Timeline) -->
      <section class="rounded-2xl border border-slate-200/70 bg-white p-5 sm:p-6 shadow-[0_4px_20px_-4px_rgba(15,23,42,0.04)] lg:col-span-5">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
          <h2 class="text-base font-semibold text-slate-900">Today's Appointment Schedule</h2>
          <button type="button" class="text-slate-400 hover:text-slate-600" title="Options">
            <i data-feather="more-horizontal" class="h-4 w-4"></i>
          </button>
        </div>

        <div class="mt-5 space-y-4">
          <!-- 9 AM -->
          <div class="flex items-start gap-4">
            <span class="w-12 pt-1 text-xs font-medium text-slate-400 shrink-0">9 AM</span>
            <div class="flex-1 rounded-xl border-l-[3px] border-[#1d6ee5] bg-[#edf4fc] p-3 transition hover:bg-[#e4effb]">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-xs font-semibold text-slate-900">Emily R.</p>
                  <p class="text-[11px] text-slate-500">Checkup</p>
                </div>
                <span class="rounded-md bg-[#d8eafb] px-2.5 py-1 text-[11px] font-semibold text-[#1d6ee5]">Confirmed</span>
              </div>
            </div>
          </div>

          <!-- 10 AM -->
          <div class="flex items-start gap-4">
            <span class="w-12 pt-1 text-xs font-medium text-slate-400 shrink-0">10 AM</span>
            <div class="flex-1 rounded-xl border-l-[3px] border-[#ef4444] bg-[#fef2f2] p-3 transition hover:bg-[#fee7e7]">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-xs font-semibold text-slate-900">John D.</p>
                  <p class="text-[11px] text-slate-500">Checkup</p>
                </div>
                <span class="rounded-md bg-[#fee2e2] px-2.5 py-1 text-[11px] font-semibold text-[#dc2626]">Arrived</span>
              </div>
            </div>
          </div>

          <!-- 11 AM -->
          <div class="flex items-start gap-4">
            <span class="w-12 pt-1 text-xs font-medium text-slate-400 shrink-0">11 AM</span>
            <div class="flex-1 rounded-xl border-l-[3px] border-[#3b82f6] bg-[#eff6ff] p-3 transition hover:bg-[#e6f0fd]">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-xs font-semibold text-slate-900">John D.</p>
                  <p class="text-[11px] text-slate-500">Root Canal</p>
                </div>
                <span class="rounded-md bg-[#dbeafe] px-2.5 py-1 text-[11px] font-semibold text-[#2563eb]">Arrived</span>
              </div>
            </div>
          </div>

          <!-- 12 PM -->
          <div class="flex items-start gap-4">
            <span class="w-12 pt-1 text-xs font-medium text-slate-400 shrink-0">12 PM</span>
            <div class="flex-1 rounded-xl border-l-[3px] border-[#f59e0b] bg-[#fffbeb] p-3 transition hover:bg-[#fef3c7]">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-xs font-semibold text-slate-900">Sarah L.</p>
                  <p class="text-[11px] text-slate-500">Crown</p>
                </div>
                <span class="rounded-md bg-[#fef3c7] px-2.5 py-1 text-[11px] font-semibold text-[#d97706]">In Progress</span>
              </div>
            </div>
          </div>

          <!-- 1 PM Slot -->
          <div class="flex items-center gap-4">
            <span class="w-12 text-xs font-medium text-slate-400 shrink-0">1 PM</span>
            <div class="flex-1 border-t border-slate-100"></div>
          </div>

          <!-- 3 PM -->
          <div class="flex items-start gap-4">
            <span class="w-12 pt-1 text-xs font-medium text-slate-400 shrink-0">3 PM</span>
            <div class="flex-1 rounded-xl border-l-[3px] border-[#10b981] bg-[#f0fdf4] p-3 transition hover:bg-[#e0f9e8]">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-xs font-semibold text-slate-900">Mike P.</p>
                  <p class="text-[11px] text-slate-500">Crown</p>
                </div>
                <span class="rounded-md bg-[#dcfce7] px-2.5 py-1 text-[11px] font-semibold text-[#16a34a]">Completed</span>
              </div>
            </div>
          </div>

          <!-- 4 PM Slot -->
          <div class="flex items-center gap-4">
            <span class="w-12 text-xs font-medium text-slate-400 shrink-0">4 PM</span>
            <div class="flex-1 border-t border-slate-100"></div>
          </div>

          <!-- 5 PM Slot -->
          <div class="flex items-center gap-4">
            <span class="w-12 text-xs font-medium text-slate-400 shrink-0">5 PM</span>
            <div class="flex-1 border-t border-slate-100"></div>
          </div>
        </div>
      </section>

      <!-- Right: Treatment Revenue (Bar Chart) -->
      <section class="rounded-2xl border border-slate-200/70 bg-white p-5 sm:p-6 shadow-[0_4px_20px_-4px_rgba(15,23,42,0.04)] lg:col-span-7 flex flex-col justify-between">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
          <h2 class="text-base font-semibold text-slate-900">Treatment Revenue</h2>
          <button type="button" class="text-slate-400 hover:text-slate-600" title="Options">
            <i data-feather="more-horizontal" class="h-4 w-4"></i>
          </button>
        </div>

        <div class="mt-4 flex-1">
          <!-- Chart Grid & Bars -->
          <div class="relative flex h-[280px] sm:h-[300px] w-full items-end pb-8 pt-4 pl-14 sm:pl-16 pr-3">
            
            <!-- Y-Axis Rotated Title -->
            <div class="absolute -left-3 sm:-left-2 top-1/2 -translate-y-1/2 -rotate-90 text-[11px] font-medium text-slate-400 whitespace-nowrap">
              Revenue vs
            </div>

            <!-- Y-Axis Labels -->
            <div class="absolute left-6 sm:left-7 top-4 bottom-8 flex flex-col justify-between text-[11px] font-medium text-slate-400 text-right pr-2">
              <span>$80,000</span>
              <span>$60,000</span>
              <span>$40,000</span>
              <span>$20,000</span>
              <span>0</span>
            </div>

            <!-- Background Grid Lines -->
            <div class="absolute left-14 sm:left-16 right-3 top-4 bottom-8 flex flex-col justify-between pointer-events-none">
              <div class="w-full border-b border-slate-100"></div>
              <div class="w-full border-b border-slate-100"></div>
              <div class="w-full border-b border-slate-100"></div>
              <div class="w-full border-b border-slate-100"></div>
              <div class="w-full border-b border-slate-200"></div>
            </div>

            <!-- Bars Container -->
            <div class="relative z-10 flex h-full w-full items-end justify-between gap-2 sm:gap-4 px-2">
              
              <!-- Checkups -->
              <div class="group flex flex-1 flex-col items-center h-full justify-end">
                <div class="relative w-full max-w-[42px] rounded-t-lg bg-[#1d6ee5] transition-all duration-300 group-hover:bg-[#1558b8]" style="height: 84%;">
                  <span class="absolute -top-7 left-1/2 -translate-x-1/2 hidden rounded-md bg-slate-900 px-1.5 py-0.5 text-[10px] font-semibold text-white group-hover:block whitespace-nowrap shadow-md">$67,200</span>
                </div>
                <span class="mt-2 text-[11px] sm:text-xs font-medium text-slate-600 truncate max-w-full text-center">Checkups</span>
              </div>

              <!-- Fillings -->
              <div class="group flex flex-1 flex-col items-center h-full justify-end">
                <div class="relative w-full max-w-[42px] rounded-t-lg bg-[#1d6ee5] transition-all duration-300 group-hover:bg-[#1558b8]" style="height: 54%;">
                  <span class="absolute -top-7 left-1/2 -translate-x-1/2 hidden rounded-md bg-slate-900 px-1.5 py-0.5 text-[10px] font-semibold text-white group-hover:block whitespace-nowrap shadow-md">$43,100</span>
                </div>
                <span class="mt-2 text-[11px] sm:text-xs font-medium text-slate-600 truncate max-w-full text-center">Fillings</span>
              </div>

              <!-- Crowns -->
              <div class="group flex flex-1 flex-col items-center h-full justify-end">
                <div class="relative w-full max-w-[42px] rounded-t-lg bg-[#1d6ee5] transition-all duration-300 group-hover:bg-[#1558b8]" style="height: 66%;">
                  <span class="absolute -top-7 left-1/2 -translate-x-1/2 hidden rounded-md bg-slate-900 px-1.5 py-0.5 text-[10px] font-semibold text-white group-hover:block whitespace-nowrap shadow-md">$53,400</span>
                </div>
                <span class="mt-2 text-[11px] sm:text-xs font-medium text-slate-600 truncate max-w-full text-center">Crowns</span>
              </div>

              <!-- Root Canal -->
              <div class="group flex flex-1 flex-col items-center h-full justify-end">
                <div class="relative w-full max-w-[42px] rounded-t-lg bg-[#1d6ee5] transition-all duration-300 group-hover:bg-[#1558b8]" style="height: 94%;">
                  <span class="absolute -top-7 left-1/2 -translate-x-1/2 hidden rounded-md bg-slate-900 px-1.5 py-0.5 text-[10px] font-semibold text-white group-hover:block whitespace-nowrap shadow-md">$75,200</span>
                </div>
                <span class="mt-2 text-[11px] sm:text-xs font-medium text-slate-600 truncate max-w-full text-center">Root Canal</span>
              </div>

              <!-- Orthodontics -->
              <div class="group flex flex-1 flex-col items-center h-full justify-end">
                <div class="relative w-full max-w-[42px] rounded-t-lg bg-[#1d6ee5] transition-all duration-300 group-hover:bg-[#1558b8]" style="height: 42%;">
                  <span class="absolute -top-7 left-1/2 -translate-x-1/2 hidden rounded-md bg-slate-900 px-1.5 py-0.5 text-[10px] font-semibold text-white group-hover:block whitespace-nowrap shadow-md">$33,600</span>
                </div>
                <span class="mt-2 text-[11px] sm:text-xs font-medium text-slate-600 truncate max-w-full text-center">Orthodontics</span>
              </div>

              <!-- Hygiene -->
              <div class="group flex flex-1 flex-col items-center h-full justify-end">
                <div class="relative w-full max-w-[42px] rounded-t-lg bg-[#1d6ee5] transition-all duration-300 group-hover:bg-[#1558b8]" style="height: 56%;">
                  <span class="absolute -top-7 left-1/2 -translate-x-1/2 hidden rounded-md bg-slate-900 px-1.5 py-0.5 text-[10px] font-semibold text-white group-hover:block whitespace-nowrap shadow-md">$45,000</span>
                </div>
                <span class="mt-2 text-[11px] sm:text-xs font-medium text-slate-600 truncate max-w-full text-center">Hygiene</span>
              </div>

            </div>
          </div>

          <div class="mt-2 text-center">
            <span class="text-xs font-medium text-slate-500">Treatment Type</span>
          </div>
        </div>
      </section>

    </div>

    <!-- Row 3: Patient Chart Overview & Recent Activity -->
    <div class="mt-6 grid grid-cols-1 gap-5 lg:grid-cols-12">
      
      <!-- Left: Patient Chart Overview (Visual Tooth Indicators) -->
      <section class="rounded-2xl border border-slate-200/70 bg-white p-5 sm:p-6 shadow-[0_4px_20px_-4px_rgba(15,23,42,0.04)] lg:col-span-7">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
          <h2 class="text-base font-semibold text-slate-900">Patient Chart Overview</h2>
          <button type="button" class="text-slate-400 hover:text-slate-600" title="Options">
            <i data-feather="more-horizontal" class="h-4 w-4"></i>
          </button>
        </div>

        <div class="mt-4 overflow-x-auto">
          <!-- Tooth Rows Container -->
          <div class="min-w-[520px] py-2">
            
            <!-- Row 1 Numbers (Upper Arch) -->
            <div class="flex justify-between px-2 text-[11px] font-semibold text-slate-400">
              <?php foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14] as $n): ?>
                <span class="w-6 text-center"><?= $n ?></span>
              <?php endforeach; ?>
            </div>

            <!-- Row 1 Teeth Icons -->
            <div class="my-2 flex justify-between px-2">
              <?php 
              $topTeeth = [
                1 => 'healthy', 2 => 'healthy', 3 => 'healthy', 4 => 'healthy', 5 => 'healthy',
                6 => 'healthy', 7 => 'healthy', 8 => 'healthy', 9 => 'healthy', 10 => 'healthy',
                11 => 'progress', 12 => 'crown', 13 => 'extracted', 14 => 'healthy'
              ];
              foreach ($topTeeth as $tNum => $status): 
                $fillColor = '#1d6ee5'; // healthy
                $hasX = false;
                if ($status === 'progress') $fillColor = '#10b981';
                elseif ($status === 'crown') $fillColor = '#475569';
                elseif ($status === 'extracted') { $fillColor = '#94a3b8'; $hasX = true; }
              ?>
                <div class="relative flex w-6 justify-center">
                  <svg class="h-8 w-5 transition-transform hover:scale-110" viewBox="0 0 24 38" fill="<?= $fillColor ?>">
                    <path d="M12 2C8 2 4 4.5 4 10C4 16 5 22 7 30C8 34 9 37 10 37C11 37 11.5 33 12 29C12.5 33 13 37 14 37C15 37 16 34 17 30C19 22 20 16 20 10C20 4.5 16 2 12 2Z"/>
                  </svg>
                  <?php if ($hasX): ?>
                    <span class="absolute inset-0 flex items-center justify-center font-bold text-white text-xs">✕</span>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>

            <!-- Row 2 Numbers (Lower Primary / Permanent) -->
            <div class="mt-4 flex justify-between px-2 text-[11px] font-semibold text-slate-400">
              <?php foreach (['33', '13', '11', 'D', 'E', '4', '5', '6', '7', '8', '19', '10', '21', '32'] as $lbl): ?>
                <span class="w-6 text-center"><?= $lbl ?></span>
              <?php endforeach; ?>
            </div>

            <!-- Row 2 Teeth Icons -->
            <div class="my-2 flex justify-between px-2">
              <?php 
              $bottomTeeth = [
                '33' => 'healthy', '13' => 'healthy', '11' => 'healthy', 'D' => 'healthy', 'E' => 'treatment',
                '4' => 'healthy', '5' => 'healthy', '6' => 'healthy', '7' => 'healthy', '8' => 'healthy',
                '19' => 'progress', '10' => 'crown', '21' => 'healthy', '32' => 'extracted'
              ];
              foreach ($bottomTeeth as $tKey => $status): 
                $fillColor = '#1d6ee5'; // healthy
                $hasX = false;
                if ($status === 'treatment') $fillColor = '#f97316';
                elseif ($status === 'progress') $fillColor = '#10b981';
                elseif ($status === 'crown') $fillColor = '#475569';
                elseif ($status === 'extracted') { $fillColor = '#94a3b8'; $hasX = true; }
              ?>
                <div class="relative flex w-6 justify-center">
                  <svg class="h-8 w-5 transition-transform hover:scale-110" viewBox="0 0 24 38" fill="<?= $fillColor ?>">
                    <path d="M12 2C8 2 4 4.5 4 10C4 16 5 22 7 30C8 34 9 37 10 37C11 37 11.5 33 12 29C12.5 33 13 37 14 37C15 37 16 34 17 30C19 22 20 16 20 10C20 4.5 16 2 12 2Z"/>
                  </svg>
                  <?php if ($hasX): ?>
                    <span class="absolute inset-0 flex items-center justify-center font-bold text-white text-xs">✕</span>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>

            <!-- Bottom Row Numbers Position -->
            <div class="flex justify-between px-2 text-[10px] text-slate-400">
              <?php foreach ([1, 2, 3, 4, 5, 6, 7, 8, 10, 12, 13, 20, 31, 32] as $idx): ?>
                <span class="w-6 text-center"><?= $idx ?></span>
              <?php endforeach; ?>
            </div>

          </div>

          <!-- Color Status Legend matching mockup -->
          <div class="mt-4 flex flex-wrap items-center justify-start sm:justify-center gap-3 sm:gap-5 border-t border-slate-100 pt-3 text-[11px] text-slate-600">
            <div class="flex items-center gap-1.5">
              <span class="h-2.5 w-2.5 rounded-sm bg-[#1d6ee5]"></span>
              <span>Healthy</span>
            </div>
            <div class="flex items-center gap-1.5">
              <span class="h-2.5 w-2.5 rounded-sm bg-[#f97316]"></span>
              <span>Treatment Needed</span>
            </div>
            <div class="flex items-center gap-1.5">
              <span class="h-2.5 w-2.5 rounded-sm bg-[#10b981]"></span>
              <span>In Progress</span>
            </div>
            <div class="flex items-center gap-1.5">
              <span class="h-2.5 w-2.5 rounded-sm bg-[#475569]"></span>
              <span>Crown</span>
            </div>
            <div class="flex items-center gap-1.5">
              <span class="flex h-3.5 w-3.5 items-center justify-center rounded-sm bg-slate-300 text-[10px] font-bold text-slate-700 leading-none">✕</span>
              <span>Extracted</span>
            </div>
          </div>
        </div>
      </section>

      <!-- Right: Recent Activity Feed -->
      <section class="rounded-2xl border border-slate-200/70 bg-white p-5 sm:p-6 shadow-[0_4px_20px_-4px_rgba(15,23,42,0.04)] lg:col-span-5 flex flex-col justify-between">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
          <h2 class="text-base font-semibold text-slate-900">Recent Activity</h2>
          <button type="button" class="text-slate-400 hover:text-slate-600" title="Options">
            <i data-feather="more-horizontal" class="h-4 w-4"></i>
          </button>
        </div>

        <div class="mt-4 space-y-4">
          <!-- Activity Item 1: Alert Check up -->
          <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
              <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-500">
                <i data-feather="alert-triangle" class="h-4 w-4"></i>
              </div>
              <div class="min-w-0">
                <p class="text-xs sm:text-sm font-semibold text-slate-900 truncate">Alerts Check up</p>
                <p class="text-[11px] text-slate-400 truncate">Alert in your new Dr. Chen...</p>
              </div>
            </div>
            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white">1</span>
          </div>

          <!-- Activity Item 2: Upcoming Tasks -->
          <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
              <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-500">
                <i data-feather="calendar" class="h-4 w-4"></i>
              </div>
              <div class="min-w-0">
                <p class="text-xs sm:text-sm font-semibold text-slate-900 truncate">Upcoming Tasks</p>
                <p class="text-[11px] text-slate-400 truncate">Upcoming tasks reconciliation...</p>
              </div>
            </div>
            <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold text-emerald-700">5am</span>
          </div>

          <!-- Activity Item 3: Patient Check-in -->
          <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
              <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-500">
                <i data-feather="user-check" class="h-4 w-4"></i>
              </div>
              <div class="min-w-0">
                <p class="text-xs sm:text-sm font-semibold text-slate-900 truncate">Patient Check-in</p>
                <p class="text-[11px] text-slate-400 truncate">Carried 14 hours ago</p>
              </div>
            </div>
          </div>

          <!-- Activity Item 4: Patient Check-in -->
          <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
              <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-500">
                <i data-feather="user-check" class="h-4 w-4"></i>
              </div>
              <div class="min-w-0">
                <p class="text-xs sm:text-sm font-semibold text-slate-900 truncate">Patient Check-in</p>
                <p class="text-[11px] text-slate-400 truncate">Carried 14 hours ago</p>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-4 pt-3 border-t border-slate-100 text-right">
          <a href="appointments.php" class="text-xs font-semibold text-[#1d6ee5] hover:underline">View all activity &rarr;</a>
        </div>
      </section>

    </div>

  </div>
</section>

<!-- Quick Add Modal -->
<div id="quickAddModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/40 p-4 backdrop-blur-sm">
  <div class="w-full max-w-md rounded-2xl border border-slate-100 bg-white p-6 shadow-2xl">
    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
      <h3 class="text-base font-bold text-slate-900">Quick Actions</h3>
      <button id="closeQuickAddBtn" type="button" class="text-slate-400 hover:text-slate-600">
        <i data-feather="x" class="h-4 w-4"></i>
      </button>
    </div>
    <div class="mt-4 space-y-2.5">
      <a href="appointments.php" class="flex items-center gap-3 rounded-xl border border-slate-200/80 p-3 transition hover:border-blue-400 hover:bg-blue-50/50">
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
          <i data-feather="calendar" class="h-5 w-5"></i>
        </div>
        <div>
          <p class="text-sm font-semibold text-slate-900">Book Appointment</p>
          <p class="text-xs text-slate-500">Schedule a patient visit on the calendar</p>
        </div>
      </a>
      <a href="patients.php" class="flex items-center gap-3 rounded-xl border border-slate-200/80 p-3 transition hover:border-blue-400 hover:bg-blue-50/50">
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
          <i data-feather="user-plus" class="h-5 w-5"></i>
        </div>
        <div>
          <p class="text-sm font-semibold text-slate-900">Register New Patient</p>
          <p class="text-xs text-slate-500">Add personal details and medical history</p>
        </div>
      </a>
      <a href="treatments.php" class="flex items-center gap-3 rounded-xl border border-slate-200/80 p-3 transition hover:border-blue-400 hover:bg-blue-50/50">
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
          <i data-feather="activity" class="h-5 w-5"></i>
        </div>
        <div>
          <p class="text-sm font-semibold text-slate-900">Record Treatment Plan</p>
          <p class="text-xs text-slate-500">Assign procedures, costs, and teeth numbers</p>
        </div>
      </a>
    </div>
  </div>
</div>

<script>
  // Quick Add Modal toggle
  const openQuickAddBtn = document.getElementById('openQuickAddBtn');
  const closeQuickAddBtn = document.getElementById('closeQuickAddBtn');
  const quickAddModal = document.getElementById('quickAddModal');

  if (openQuickAddBtn && quickAddModal) {
    openQuickAddBtn.addEventListener('click', () => {
      quickAddModal.classList.remove('hidden');
      quickAddModal.classList.add('flex');
    });
  }

  if (closeQuickAddBtn && quickAddModal) {
    closeQuickAddBtn.addEventListener('click', () => {
      quickAddModal.classList.add('hidden');
      quickAddModal.classList.remove('flex');
    });
  }

  if (quickAddModal) {
    quickAddModal.addEventListener('click', (e) => {
      if (e.target === quickAddModal) {
        quickAddModal.classList.add('hidden');
        quickAddModal.classList.remove('flex');
      }
    });
  }
</script>
