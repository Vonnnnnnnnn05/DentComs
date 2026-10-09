<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>DentaFlow | Smart Dental Clinic System</title>
  <!-- Tailwind CSS v3 + Font Awesome Icons -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Google Font: Plus Jakarta Sans & Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    * {
      font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    }
    html {
      scroll-behavior: smooth;
    }
    body {
      background-color: #ffffff;
      color: #1e293b;
      overflow-x: hidden;
    }

    /* Ambient Hero Gradient */
    .hero-gradient-bg {
      background: radial-gradient(ellipse at 75% 35%, rgba(219, 234, 254, 0.65), rgba(255, 255, 255, 0) 70%);
    }

    /* Floating Keyframe for Hero Dashboard - slow, serene, weightless float */
    @keyframes dfHeroFloat {
      0%, 100% {
        transform: translateY(0px) rotate(0deg);
        box-shadow: 0 25px 50px -12px rgba(29, 110, 229, 0.12), 0 10px 20px -5px rgba(0, 0, 0, 0.03);
      }
      50% {
        transform: translateY(-6px) rotate(0.12deg);
        box-shadow: 0 35px 60px -15px rgba(29, 110, 229, 0.18), 0 16px 28px -6px rgba(0, 0, 0, 0.04);
      }
    }

    /* Counter-Float for Badge - ultra-smooth & graceful */
    @keyframes dfBadgeFloat {
      0%, 100% {
        transform: translateY(0px);
      }
      50% {
        transform: translateY(5px);
      }
    }

    /* Ambient Pulsing Orb - deeply calm & organic ambient drift */
    @keyframes dfOrbPulse {
      0%, 100% {
        transform: scale(1) translate(0, 0);
        opacity: 0.30;
      }
      50% {
        transform: scale(1.12) translate(-16px, 12px);
        opacity: 0.55;
      }
    }

    /* Fade-In-Up Stagger Entrance - slow & luxurious */
    @keyframes dfFadeUp {
      from {
        opacity: 0;
        transform: translateY(24px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Subtle Button Pulse Glow - slow, calm breathing halo */
    @keyframes dfPulseGlow {
      0%, 100% {
        box-shadow: 0 0 0 0 rgba(29, 110, 229, 0.3);
      }
      50% {
        box-shadow: 0 0 0 14px rgba(29, 110, 229, 0);
      }
    }

    /* Shimmer Effect */
    @keyframes dfShimmer {
      0% {
        background-position: -200% 0;
      }
      100% {
        background-position: 200% 0;
      }
    }

    .animate-hero-float {
      animation: dfHeroFloat 22s cubic-bezier(0.42, 0, 0.58, 1) infinite;
    }

    .animate-badge-float {
      animation: dfBadgeFloat 18s cubic-bezier(0.42, 0, 0.58, 1) infinite;
    }

    .animate-orb {
      animation: dfOrbPulse 30s ease-in-out infinite alternate;
    }

    .animate-btn-pulse {
      animation: dfPulseGlow 8s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Slow & ultra-smooth staggered entrance */
    .hero-fade-1 { animation: dfFadeUp 1.6s cubic-bezier(0.16, 1, 0.3, 1) 0.12s both; }
    .hero-fade-2 { animation: dfFadeUp 1.6s cubic-bezier(0.16, 1, 0.3, 1) 0.32s both; }
    .hero-fade-3 { animation: dfFadeUp 1.6s cubic-bezier(0.16, 1, 0.3, 1) 0.52s both; }
    .hero-fade-4 { animation: dfFadeUp 1.6s cubic-bezier(0.16, 1, 0.3, 1) 0.72s both; }
    .hero-fade-image { animation: dfFadeUp 1.8s cubic-bezier(0.16, 1, 0.3, 1) 0.38s both; }

    /* Scroll Reveal Classes - slow, gentle easing */
    .reveal-on-scroll {
      opacity: 0;
      transform: translateY(26px);
      transition: opacity 1.5s cubic-bezier(0.16, 1, 0.3, 1), transform 1.5s cubic-bezier(0.16, 1, 0.3, 1);
      will-change: opacity, transform;
    }

    .reveal-on-scroll.is-revealed {
      opacity: 1;
      transform: translateY(0);
    }

    /* Modern Card Hover Effects - smooth and gentle */
    .hover-card {
      transition: transform 0.65s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.65s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.65s ease;
      border: 1px solid rgba(226, 232, 240, 0.8);
    }

    .hover-card:hover {
      transform: translateY(-5px) scale(1.008);
      box-shadow: 0 20px 32px -10px rgba(29, 110, 229, 0.1), 0 8px 16px -6px rgba(0, 0, 0, 0.03);
      border-color: rgba(59, 130, 246, 0.3);
    }

    .hover-card:hover .icon-box {
      transform: scale(1.06) rotate(2deg);
      background-color: #dbeafe;
      color: #1d4ed8;
    }

    .icon-box {
      transition: transform 0.65s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.65s ease, color 0.65s ease;
    }

    /* Button Primary Hover - gentle glide */
    .btn-primary {
      transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.5s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.35s ease;
    }
    .btn-primary:hover {
      transform: translateY(-2px) scale(1.012);
      box-shadow: 0 14px 28px -6px rgba(29, 110, 229, 0.28);
    }
    .btn-primary:active {
      transform: translateY(0) scale(0.99);
    }

    /* Logo Shimmer On Hover */
    .brand-logo-icon {
      transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .brand-logo:hover .brand-logo-icon {
      transform: scale(1.08) rotate(-4deg);
    }

    /* Hero Mockup Card Smoothed Transition */
    #heroMockupCard {
      transition: transform 0.75s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.75s ease;
    }

    input:focus, textarea:focus {
      outline: none;
      ring: 2px solid #3b82f6;
      border-color: #3b82f6;
    }

    #loginModal {
      transition: opacity 320ms ease, visibility 320ms ease;
    }
    #loginModal .modal-panel {
      transition: opacity 320ms ease, transform 320ms cubic-bezier(0.16, 1, 0.3, 1);
    }
  </style>
</head>
<body class="text-gray-800 antialiased selection:bg-blue-100 selection:text-blue-900">

  <!-- Navigation Bar - clean white with glassmorphism & mobile drawer -->
  <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-xs transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12 py-3.5 sm:py-4 flex justify-between items-center">
      <!-- Brand / Logo -->
      <a href="index.php" class="brand-logo flex items-center gap-2 sm:gap-2.5 transition">
        <i class="fas fa-tooth text-2xl sm:text-3xl text-[#1d6ee5] brand-logo-icon"></i>
        <span class="font-extrabold text-xl sm:text-2xl tracking-tight text-slate-900">DentaFlow<span class="text-[#1d6ee5]">.</span></span>
      </a>

      <!-- Desktop Links -->
      <div class="hidden md:flex gap-8 text-slate-600 font-medium text-sm">
        <a href="#features" class="hover:text-[#1d6ee5] transition-colors py-1">Features</a>
        <a href="#how-it-works" class="hover:text-[#1d6ee5] transition-colors py-1">How it works</a>
        <a href="#testimonials" class="hover:text-[#1d6ee5] transition-colors py-1">Reviews</a>
        <a href="#contact" class="hover:text-[#1d6ee5] transition-colors py-1">Contact</a>
      </div>

      <!-- Right Action Bar: Quick Log in button + Hamburger on mobile -->
      <div class="flex items-center gap-2 sm:gap-3">
        <button
          type="button"
          class="open-login-trigger border border-slate-200 text-slate-700 px-3.5 py-1.5 sm:px-5 sm:py-2 rounded-full text-xs sm:text-sm font-semibold hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50/50 transition-all flex items-center gap-1.5 shadow-xs"
        >
          <i class="fas fa-arrow-right-to-bracket text-blue-600 text-xs"></i>
          <span>Log in</span>
        </button>

        <!-- Mobile Hamburger Button -->
        <button
          id="mobileMenuToggle"
          type="button"
          class="md:hidden inline-flex items-center justify-center h-9 w-9 sm:h-10 sm:w-10 rounded-xl text-slate-600 hover:text-[#1d6ee5] hover:bg-blue-50/80 transition focus:outline-none"
          aria-label="Toggle navigation menu"
          aria-expanded="false"
        >
          <i id="mobileMenuIcon" class="fas fa-bars text-lg sm:text-xl transition-transform duration-200"></i>
        </button>
      </div>
    </div>

    <!-- Mobile Dropdown Navigation Menu -->
    <div
      id="mobileNavMenu"
      class="md:hidden max-h-0 overflow-hidden border-b border-transparent bg-white/95 backdrop-blur-md transition-all duration-300 ease-in-out opacity-0"
    >
      <div class="px-4 sm:px-6 pt-2 pb-6 space-y-1.5 border-t border-slate-100">
        <a
          href="#features"
          class="mobile-nav-link flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-700 font-semibold hover:text-[#1d6ee5] hover:bg-blue-50/70 transition-colors"
        >
          <i class="fas fa-cogs w-5 text-[#1d6ee5]"></i>
          <span>Features</span>
        </a>
        <a
          href="#how-it-works"
          class="mobile-nav-link flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-700 font-semibold hover:text-[#1d6ee5] hover:bg-blue-50/70 transition-colors"
        >
          <i class="fas fa-rocket w-5 text-[#1d6ee5]"></i>
          <span>How it works</span>
        </a>
        <a
          href="#testimonials"
          class="mobile-nav-link flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-700 font-semibold hover:text-[#1d6ee5] hover:bg-blue-50/70 transition-colors"
        >
          <i class="fas fa-star w-5 text-[#1d6ee5]"></i>
          <span>Reviews</span>
        </a>
        <a
          href="#contact"
          class="mobile-nav-link flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-700 font-semibold hover:text-[#1d6ee5] hover:bg-blue-50/70 transition-colors"
        >
          <i class="fas fa-envelope w-5 text-[#1d6ee5]"></i>
          <span>Contact</span>
        </a>

        <!-- Mobile Drawer CTA Buttons -->
        <div class="pt-3 border-t border-slate-100 space-y-2.5">
          <button
            type="button"
            class="open-login-trigger w-full flex items-center justify-center gap-2 border border-slate-200 text-slate-700 px-5 py-3 rounded-2xl text-sm font-semibold hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50/50 transition-all shadow-xs"
          >
            <i class="fas fa-lock text-blue-600 text-xs"></i>
            <span>Sign in to Clinic Portal</span>
          </button>
          <button
            type="button"
            class="start-trial-trigger w-full flex items-center justify-center gap-2 bg-[#1d6ee5] hover:bg-[#1558b8] text-white px-5 py-3 rounded-2xl text-sm font-semibold shadow-md shadow-blue-600/25 transition-all"
          >
            <i class="fas fa-calendar-check text-xs"></i>
            <span>Start Free Trial</span>
          </button>
        </div>
      </div>
    </div>
  </nav>

  <!-- Login Modal -->
  <div id="loginModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-950/60 backdrop-blur-xs px-4 opacity-0 invisible transition-all duration-300">
    <div class="absolute inset-0" data-close-login-modal></div>
    <div class="modal-panel relative w-full max-w-md translate-y-4 scale-[0.98] rounded-3xl border border-slate-200 bg-white p-6 sm:p-7 opacity-0 shadow-2xl transition-all duration-300 max-h-[95vh] overflow-y-auto">
      <button
        id="closeLoginModal"
        type="button"
        class="absolute right-4 top-4 h-10 w-10 rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-slate-700 flex items-center justify-center"
        aria-label="Close login modal"
      >
        <i class="fas fa-times text-base"></i>
      </button>
      <div class="mb-6">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#1d6ee5]">Secure Portal</p>
        <h2 class="mt-2 text-2xl sm:text-3xl font-bold text-slate-900">Welcome to DentaFlow</h2>
        <p class="mt-2 text-sm text-slate-500">Sign in with your clinic credentials to continue.</p>
      </div>
      <form id="loginForm" method="POST" action="login_process.php" class="space-y-4">
        <div>
          <label for="loginEmail" class="mb-2 block text-sm font-semibold text-slate-700">Email Address</label>
          <input
            id="loginEmail"
            name="email"
            type="email"
            inputmode="email"
            autocomplete="email"
            placeholder="admin@gmail.com"
            required
            class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-base text-slate-800 placeholder:text-slate-400 focus:border-[#1d6ee5] focus:ring-2 focus:ring-blue-100 transition"
          >
        </div>
        <div>
          <label for="loginPassword" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
          <input
            id="loginPassword"
            name="password"
            type="password"
            autocomplete="current-password"
            placeholder="Enter your password"
            required
            class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-base text-slate-800 placeholder:text-slate-400 focus:border-[#1d6ee5] focus:ring-2 focus:ring-blue-100 transition"
          >
        </div>
        <button type="submit" class="w-full rounded-2xl bg-[#1d6ee5] px-5 py-3.5 font-semibold text-white shadow-md shadow-blue-600/25 transition hover:bg-[#1558b8]">
          Log in
        </button>
      </form>
    </div>
  </div>

  <!-- Hero Section with Ambient Glow and Floating Animations -->
  <section class="relative overflow-hidden pt-10 pb-16 sm:pt-16 sm:pb-24 md:pt-20 md:pb-28 lg:pt-24">
    <!-- Ambient Animated Glow Orbs -->
    <div class="hero-gradient-bg absolute inset-0 pointer-events-none"></div>
    <div class="absolute -top-24 right-10 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl pointer-events-none animate-orb"></div>
    <div class="absolute top-48 left-10 w-80 h-80 bg-sky-300/15 rounded-full blur-3xl pointer-events-none animate-orb" style="animation-delay: -3s;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12 relative z-10">
      <div class="grid md:grid-cols-2 gap-10 md:gap-12 items-center">
        
        <!-- Left Hero Copy with Staggered Fade Up -->
        <div>
          <h1 class="hero-fade-1 text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-[1.14]">
            Modernize your <span class="text-[#1d6ee5] bg-gradient-to-r from-[#1d6ee5] to-[#38bdf8] bg-clip-text text-transparent">dental practice</span> with one intelligent system.
          </h1>
          
          <p class="hero-fade-2 text-slate-500 text-base sm:text-lg mt-4 sm:mt-6 max-w-lg leading-relaxed">
            DentaFlow streamlines appointments, patient records, billing, and analytics — all in a clean, secure platform built for modern clinics.
          </p>

          <div class="hero-fade-3 flex flex-col sm:flex-row gap-3.5 sm:gap-4 mt-6 sm:mt-8 w-full sm:w-auto">
            <button class="btn-primary animate-btn-pulse bg-[#1d6ee5] hover:bg-[#1558b8] text-white font-semibold px-7 py-3.5 rounded-full shadow-lg shadow-blue-600/30 transition flex items-center justify-center gap-2 w-full sm:w-auto">
              <i class="fas fa-calendar-check"></i> Start free trial
            </button>
            <button class="border border-slate-200 bg-white text-slate-700 font-medium px-7 py-3.5 rounded-full hover:bg-slate-50 hover:border-slate-300 transition flex items-center justify-center gap-2 w-full sm:w-auto">
              <i class="fas fa-play-circle text-blue-600"></i> Watch demo
            </button>
          </div>

          <div class="hero-fade-4 flex flex-wrap items-center gap-4 sm:gap-6 mt-6 sm:mt-8 text-xs sm:text-sm text-slate-500">
            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle text-blue-500"></i> <span>No credit card</span></div>
            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle text-blue-500"></i> <span>14-day free</span></div>
            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle text-blue-500"></i> <span>GDPR ready</span></div>
          </div>
        </div>

        <!-- Right: Animated Floating Dashboard Mockup with Interactive Tilt -->
        <div class="relative flex justify-center hero-fade-image mt-4 md:mt-0">
          <div id="heroMockupWrapper" class="relative group animate-hero-float transition-transform duration-300 w-full max-w-lg md:max-w-none">
            
            <!-- Main Mockup Container -->
            <div id="heroMockupCard" class="bg-white p-2 sm:p-2.5 rounded-2xl sm:rounded-3xl shadow-xl sm:shadow-2xl border border-slate-100 transition-all duration-300">
              <img 
                src="assets/images/dentaflow-dashboard-preview.jpg" 
                alt="DentaFlow dashboard preview" 
                class="rounded-xl sm:rounded-2xl w-full object-cover shadow-sm transition-transform duration-500"
              >
            </div>

            <!-- Floating Efficiency Badge -->
            <div class="absolute -bottom-5 -left-6 hidden lg:block animate-badge-float">
              <div class="bg-white/95 backdrop-blur-md rounded-2xl p-3.5 shadow-xl border border-slate-100 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                  <i class="fas fa-chart-line text-lg"></i>
                </div>
                <div>
                  <p class="text-sm font-bold text-slate-900">+37% efficiency</p>
                  <p class="text-[11px] font-medium text-slate-400">Adopted clinics</p>
                </div>
              </div>
            </div>

            <!-- Floating Active Patient Badge -->
            <div class="absolute -top-4 -right-4 hidden lg:block animate-badge-float" style="animation-delay: -2.5s;">
              <div class="bg-white/95 backdrop-blur-md rounded-2xl px-4 py-2.5 shadow-xl border border-slate-100 flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-blue-600 animate-ping"></span>
                <span class="text-xs font-bold text-slate-800">Live Practice Analytics</span>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Trusted by / Stats Bar with Dynamic Number Animation -->
  <div class="border-y border-slate-100 bg-slate-50/60 py-6 sm:py-7 reveal-on-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12 grid grid-cols-1 sm:grid-cols-3 gap-6 sm:gap-8 items-center text-center sm:text-left">
      
      <div class="flex items-center justify-center sm:justify-start gap-3.5">
        <div class="flex h-11 w-11 sm:h-10 sm:w-10 items-center justify-center rounded-xl bg-blue-100 text-[#1d6ee5]">
          <i class="fas fa-tooth text-xl"></i>
        </div>
        <div class="text-left">
          <p class="font-extrabold text-2xl sm:text-xl text-slate-900 leading-tight">
            <span class="stat-counter" data-target="500">0</span>+
          </p>
          <p class="text-xs text-slate-500 font-medium">Clinics onboarded</p>
        </div>
      </div>

      <div class="flex items-center justify-center sm:justify-start gap-3.5">
        <div class="flex h-11 w-11 sm:h-10 sm:w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
          <i class="fas fa-chart-simple text-xl"></i>
        </div>
        <div class="text-left">
          <p class="font-extrabold text-2xl sm:text-xl text-slate-900 leading-tight">
            <span class="stat-counter" data-target="98">0</span>%
          </p>
          <p class="text-xs text-slate-500 font-medium">Patient satisfaction</p>
        </div>
      </div>

      <div class="flex items-center justify-center sm:justify-start gap-3.5">
        <div class="flex h-11 w-11 sm:h-10 sm:w-10 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
          <i class="fas fa-clock text-xl"></i>
        </div>
        <div class="text-left">
          <p class="font-extrabold text-2xl sm:text-xl text-slate-900 leading-tight">24/7</p>
          <p class="text-xs text-slate-500 font-medium">Secure cloud uptime</p>
        </div>
      </div>

    </div>
  </div>

  <!-- Features Section with Scroll Reveal & Hover Lift -->
  <section id="features" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
      
      <div class="text-center max-w-2xl mx-auto mb-16 reveal-on-scroll">
        <span class="text-[#1d6ee5] font-bold tracking-wider text-xs uppercase flex justify-center items-center gap-1.5">
          <i class="fas fa-cogs"></i> Core Capabilities
        </span>
        <h2 class="text-3xl md:text-4xl font-extrabold mt-3 text-slate-900 tracking-tight">Everything your clinic needs, unified.</h2>
        <p class="text-slate-500 mt-4 leading-relaxed">Designed for dentists, by healthcare experts. No complexity — just seamless clinical workflows.</p>
      </div>

      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
        
        <div class="bg-white p-7 rounded-3xl border border-slate-100 shadow-sm hover-card transition reveal-on-scroll" style="transition-delay: 50ms;">
          <div class="icon-box w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-[#1d6ee5] text-2xl mb-6 shadow-xs">
            <i class="fas fa-calendar-alt"></i>
          </div>
          <h3 class="text-lg font-bold mb-2 text-slate-900">Smart Scheduling</h3>
          <p class="text-slate-500 text-sm leading-relaxed">Automated booking, double-booking checks, and calendar sync that eliminate scheduling overhead.</p>
        </div>

        <div class="bg-white p-7 rounded-3xl border border-slate-100 shadow-sm hover-card transition reveal-on-scroll" style="transition-delay: 150ms;">
          <div class="icon-box w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-[#1d6ee5] text-2xl mb-6 shadow-xs">
            <i class="fas fa-notes-medical"></i>
          </div>
          <h3 class="text-lg font-bold mb-2 text-slate-900">Digital Charting</h3>
          <p class="text-slate-500 text-sm leading-relaxed">Interactive tooth-by-tooth condition tracking, pediatric/adult charts, and comprehensive medical histories.</p>
        </div>

        <div class="bg-white p-7 rounded-3xl border border-slate-100 shadow-sm hover-card transition reveal-on-scroll" style="transition-delay: 250ms;">
          <div class="icon-box w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-[#1d6ee5] text-2xl mb-6 shadow-xs">
            <i class="fas fa-credit-card"></i>
          </div>
          <h3 class="text-lg font-bold mb-2 text-slate-900">Billing & Ledgers</h3>
          <p class="text-slate-500 text-sm leading-relaxed">Automated procedure invoicing, itemized treatment plans, and real-time payment collection tracking.</p>
        </div>

        <div class="bg-white p-7 rounded-3xl border border-slate-100 shadow-sm hover-card transition reveal-on-scroll" style="transition-delay: 350ms;">
          <div class="icon-box w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-[#1d6ee5] text-2xl mb-6 shadow-xs">
            <i class="fas fa-chart-pie"></i>
          </div>
          <h3 class="text-lg font-bold mb-2 text-slate-900">Analytics Hub</h3>
          <p class="text-slate-500 text-sm leading-relaxed">Real-time KPI reports, chair occupancy metrics, departmental breakdowns, and revenue growth pacing.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- How it works with Staggered Steps -->
  <section id="how-it-works" class="py-24 bg-slate-50/70 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
      
      <div class="text-center mb-16 reveal-on-scroll">
        <span class="text-[#1d6ee5] font-bold text-xs uppercase tracking-wider flex justify-center gap-1.5 items-center">
          <i class="fas fa-rocket"></i> Fast Deployment
        </span>
        <h2 class="text-3xl md:text-4xl font-extrabold mt-2 text-slate-900 tracking-tight">Get live in days, not months</h2>
        <p class="text-slate-500 max-w-xl mx-auto mt-3">Streamlined onboarding that empowers your front desk and dental staff immediately.</p>
      </div>

      <div class="grid md:grid-cols-3 gap-10">
        
        <div class="text-center bg-white p-8 rounded-3xl border border-slate-200/70 shadow-xs hover-card transition reveal-on-scroll" style="transition-delay: 50ms;">
          <div class="icon-box bg-blue-50 w-16 h-16 rounded-2xl flex items-center justify-center text-[#1d6ee5] text-2xl shadow-xs mx-auto mb-6">
            <i class="fas fa-user-plus"></i>
          </div>
          <div class="font-extrabold text-[#1d6ee5] text-xs tracking-wider mb-2">STEP 1</div>
          <h3 class="text-xl font-bold text-slate-900">Setup Clinic Profile</h3>
          <p class="text-slate-500 mt-2 text-sm leading-relaxed">Configure clinic hours, treatment chairs, and staff accounts with tailored permission levels.</p>
        </div>

        <div class="text-center bg-white p-8 rounded-3xl border border-slate-200/70 shadow-xs hover-card transition reveal-on-scroll" style="transition-delay: 150ms;">
          <div class="icon-box bg-blue-50 w-16 h-16 rounded-2xl flex items-center justify-center text-[#1d6ee5] text-2xl shadow-xs mx-auto mb-6">
            <i class="fas fa-database"></i>
          </div>
          <div class="font-extrabold text-[#1d6ee5] text-xs tracking-wider mb-2">STEP 2</div>
          <h3 class="text-xl font-bold text-slate-900">Import Patient Records</h3>
          <p class="text-slate-500 mt-2 text-sm leading-relaxed">Easily import legacy patients or start scheduling fresh appointments right from the calendar.</p>
        </div>

        <div class="text-center bg-white p-8 rounded-3xl border border-slate-200/70 shadow-xs hover-card transition reveal-on-scroll" style="transition-delay: 250ms;">
          <div class="icon-box bg-blue-50 w-16 h-16 rounded-2xl flex items-center justify-center text-[#1d6ee5] text-2xl shadow-xs mx-auto mb-6">
            <i class="fas fa-chart-line"></i>
          </div>
          <div class="font-extrabold text-[#1d6ee5] text-xs tracking-wider mb-2">STEP 3</div>
          <h3 class="text-xl font-bold text-slate-900">Optimize & Scale</h3>
          <p class="text-slate-500 mt-2 text-sm leading-relaxed">Enjoy intuitive treatment tracking, clear dental histories, and comprehensive analytics.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section id="testimonials" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
      
      <div class="text-center mb-16 reveal-on-scroll">
        <i class="fas fa-quote-right text-blue-200 text-4xl mb-2"></i>
        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Trusted by dental leaders</h2>
        <p class="text-slate-500 mt-2">Real reviews from practice managers and clinic owners.</p>
      </div>

      <div class="grid md:grid-cols-3 gap-8">
        
        <div class="bg-slate-50/80 rounded-3xl p-7 border border-slate-100 shadow-xs hover-card transition reveal-on-scroll" style="transition-delay: 50ms;">
          <div class="flex gap-1 text-amber-400 mb-4"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
          <p class="text-slate-700 italic text-sm leading-relaxed">“DentaFlow reduced no-shows by 45% and saved our front desk 10+ hours weekly. The dental chart interface is exceptionally clean.”</p>
          <div class="flex items-center gap-3.5 mt-6 pt-4 border-t border-slate-200/60">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-[#1d6ee5] font-bold"><i class="fas fa-user-md"></i></div>
            <div><p class="font-bold text-sm text-slate-900">Dr. Sarah Chen</p><p class="text-xs text-slate-400">BrightSmile Dental</p></div>
          </div>
        </div>

        <div class="bg-slate-50/80 rounded-3xl p-7 border border-slate-100 shadow-xs hover-card transition reveal-on-scroll" style="transition-delay: 150ms;">
          <div class="flex gap-1 text-amber-400 mb-4"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
          <p class="text-slate-700 italic text-sm leading-relaxed">“Incredible billing workflows and patient balance visibility. Finally a practice system designed intuitively around dentistry.”</p>
          <div class="flex items-center gap-3.5 mt-6 pt-4 border-t border-slate-200/60">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-[#1d6ee5] font-bold"><i class="fas fa-briefcase"></i></div>
            <div><p class="font-bold text-sm text-slate-900">Michael Torres</p><p class="text-xs text-slate-400">Practice Manager, SmileHub</p></div>
          </div>
        </div>

        <div class="bg-slate-50/80 rounded-3xl p-7 border border-slate-100 shadow-xs hover-card transition reveal-on-scroll" style="transition-delay: 250ms;">
          <div class="flex gap-1 text-amber-400 mb-4"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
          <p class="text-slate-700 italic text-sm leading-relaxed">“The reporting and revenue analytics module gave us visibility into procedure production and boosted our practice collections significantly.”</p>
          <div class="flex items-center gap-3.5 mt-6 pt-4 border-t border-slate-200/60">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-[#1d6ee5] font-bold"><i class="fas fa-hospital-user"></i></div>
            <div><p class="font-bold text-sm text-slate-900">Dr. James Park</p><p class="text-xs text-slate-400">Elite Dentistry Group</p></div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- CTA Banner with Vibrant Glow -->
  <section class="py-14 sm:py-20 reveal-on-scroll">
    <div class="max-w-6xl mx-auto px-4 sm:px-8">
      <div class="relative overflow-hidden bg-gradient-to-tr from-[#1d6ee5] via-[#2563eb] to-[#38bdf8] rounded-3xl p-7 sm:p-10 md:p-14 text-center text-white shadow-2xl shadow-blue-500/25">
        <div class="relative z-10">
          <i class="fas fa-tooth text-3xl sm:text-4xl mb-4 text-white/90"></i>
          <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight">Ready to elevate your dental practice?</h2>
          <p class="text-blue-50 max-w-xl mx-auto mt-3 text-sm sm:text-base">Join modern dental clinics that run on DentaFlow. Start your 14-day free trial today.</p>
          <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4 mt-6 sm:mt-8 w-full sm:w-auto">
            <button class="start-trial-trigger bg-white text-[#1d6ee5] hover:bg-slate-100 font-bold px-7 sm:px-8 py-3.5 rounded-full shadow-lg transition-transform hover:scale-105 flex items-center justify-center gap-2 w-full sm:w-auto">
              <i class="fas fa-arrow-right"></i> Request free demo
            </button>
            <button class="border border-white/40 hover:bg-white/10 text-white px-7 sm:px-8 py-3.5 rounded-full font-medium transition flex items-center justify-center gap-2 w-full sm:w-auto">
              <i class="fas fa-headset"></i> Talk to sales
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="py-16 sm:py-20 border-t border-slate-100 bg-white reveal-on-scroll">
    <div class="max-w-5xl mx-auto px-4 sm:px-8">
      <div class="grid md:grid-cols-2 gap-10 items-center">
        <div>
          <h3 class="text-2xl font-bold text-slate-900 flex items-center gap-2">
            <i class="fas fa-envelope-open-text text-[#1d6ee5]"></i> Stay in the loop
          </h3>
          <p class="text-slate-500 mt-2 text-sm leading-relaxed">Receive product updates, dental software features, and best practices.</p>
          <div class="flex mt-6 flex-col sm:flex-row gap-3">
            <input type="email" placeholder="Your email address" class="border border-slate-200 rounded-full px-5 py-3 w-full sm:w-72 focus:ring-2 focus:ring-blue-100 focus:border-[#1d6ee5] transition text-sm">
            <button class="btn-primary bg-[#1d6ee5] hover:bg-[#1558b8] text-white px-6 py-3 rounded-full font-semibold transition text-sm w-full sm:w-auto flex items-center justify-center gap-1.5">
              <span>Subscribe</span> <i class="fas fa-paper-plane text-xs"></i>
            </button>
          </div>
          <p class="text-xs text-slate-400 mt-3">No spam. Unsubscribe anytime.</p>
        </div>
        
        <div class="flex flex-col gap-3.5 text-slate-600 text-sm">
          <div class="flex items-center gap-3"><i class="fas fa-phone-alt w-6 text-[#1d6ee5] shrink-0"></i> <span>+1 (888) 234-5678</span></div>
          <div class="flex items-center gap-3"><i class="fas fa-envelope w-6 text-[#1d6ee5] shrink-0"></i> <a href="mailto:von.vergara.399@gmail.com" class="hover:text-[#1d6ee5] transition-colors break-all">von.vergara.399@gmail.com</a></div>
          <div class="flex items-center gap-3"><i class="fas fa-map-marker-alt w-6 text-[#1d6ee5] shrink-0"></i> <span>Sto. Nino South Cotabato, Philippines</span></div>
          <div class="flex gap-4 mt-2 text-[#1d6ee5] text-lg">
            <i class="fab fa-linkedin-in hover:scale-115 transition-transform cursor-pointer"></i>
            <i class="fab fa-twitter hover:scale-115 transition-transform cursor-pointer"></i>
            <i class="fab fa-instagram hover:scale-115 transition-transform cursor-pointer"></i>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-white border-t border-slate-100 py-8 sm:py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12">
      <div class="flex flex-col md:flex-row justify-between items-center gap-5 text-center md:text-left">
        <div class="flex flex-col sm:flex-row items-center gap-2">
          <div class="flex items-center gap-2">
            <i class="fas fa-tooth text-[#1d6ee5] text-xl"></i>
            <span class="font-extrabold text-slate-900 text-lg">DentaFlow</span>
          </div>
          <span class="text-slate-400 text-xs sm:ml-2">© <?= date('Y') ?> — Intelligent Dental Operating System</span>
        </div>
        <div class="flex flex-wrap justify-center gap-5 sm:gap-8 text-slate-500 text-xs">
          <a href="#" class="hover:text-[#1d6ee5] transition">Privacy</a>
          <a href="#" class="hover:text-[#1d6ee5] transition">Terms</a>
          <a href="#" class="hover:text-[#1d6ee5] transition">Security</a>
          <a href="#" class="hover:text-[#1d6ee5] transition">Status</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Toast notification element -->
  <div id="toastNotification" class="fixed bottom-6 right-6 z-50 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
    <div class="bg-slate-900/95 backdrop-blur-md text-white px-5 py-3 rounded-2xl shadow-2xl flex items-center gap-3 border border-slate-800 text-sm font-medium">
      <span id="toastIcon">✨</span>
      <span id="toastMessage">Notification</span>
    </div>
  </div>

  <script>
    (function() {
      // Toast notification helper
      const toast = document.getElementById('toastNotification');
      const toastMsg = document.getElementById('toastMessage');
      const toastIcon = document.getElementById('toastIcon');
      let toastTimer = null;

      function showMessage(msg, isSuccess = true) {
        if(!toast) return;
        toastMsg.textContent = msg;
        toastIcon.textContent = isSuccess ? '✨' : '⚠️';
        toast.classList.remove('translate-y-20', 'opacity-0');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => {
          toast.classList.add('translate-y-20', 'opacity-0');
        }, 3600);
      }

      // Mobile menu toggle functionality
      const mobileMenuToggle = document.getElementById('mobileMenuToggle');
      const mobileNavMenu = document.getElementById('mobileNavMenu');
      const mobileMenuIcon = document.getElementById('mobileMenuIcon');
      let isMobileMenuOpen = false;

      function toggleMobileMenu(openState) {
        if (!mobileNavMenu) return;
        isMobileMenuOpen = openState !== undefined ? openState : !isMobileMenuOpen;
        if (isMobileMenuOpen) {
          mobileNavMenu.style.maxHeight = mobileNavMenu.scrollHeight + 50 + 'px';
          mobileNavMenu.classList.remove('opacity-0', 'border-transparent');
          mobileNavMenu.classList.add('opacity-100', 'border-slate-100');
          if (mobileMenuIcon) {
            mobileMenuIcon.classList.remove('fa-bars');
            mobileMenuIcon.classList.add('fa-times');
          }
          mobileMenuToggle?.setAttribute('aria-expanded', 'true');
        } else {
          mobileNavMenu.style.maxHeight = '0px';
          mobileNavMenu.classList.add('opacity-0', 'border-transparent');
          mobileNavMenu.classList.remove('opacity-100', 'border-slate-100');
          if (mobileMenuIcon) {
            mobileMenuIcon.classList.remove('fa-times');
            mobileMenuIcon.classList.add('fa-bars');
          }
          mobileMenuToggle?.setAttribute('aria-expanded', 'false');
        }
      }

      mobileMenuToggle?.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleMobileMenu();
      });

      // Close mobile menu when clicking any nav link
      document.querySelectorAll('.mobile-nav-link').forEach(link => {
        link.addEventListener('click', () => toggleMobileMenu(false));
      });

      // Close mobile menu on click outside
      document.addEventListener('click', (e) => {
        if (isMobileMenuOpen && mobileNavMenu && !mobileNavMenu.contains(e.target) && !mobileMenuToggle?.contains(e.target)) {
          toggleMobileMenu(false);
        }
      });

      // 1. Scroll-Reveal Intersection Observer
      const revealElements = document.querySelectorAll('.reveal-on-scroll');
      if ('IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries, observer) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add('is-revealed');
              observer.unobserve(entry.target);
            }
          });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        revealElements.forEach(el => revealObserver.observe(el));
      } else {
        revealElements.forEach(el => el.classList.add('is-revealed'));
      }

      // 2. Animated Number Counter for Stats Bar - slow, liquid smooth ease-out
      const counters = document.querySelectorAll('.stat-counter');
      let countersStarted = false;

      function easeOutCubic(t) {
        return 1 - Math.pow(1 - t, 3);
      }

      function runCounters() {
        const duration = 2800;
        const startTime = performance.now();

        function step(now) {
          const elapsed = now - startTime;
          const progress = Math.min(elapsed / duration, 1);
          const eased = easeOutCubic(progress);

          counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const val = Math.floor(eased * target);
            counter.textContent = val;
          });

          if (progress < 1) {
            requestAnimationFrame(step);
          } else {
            counters.forEach(counter => {
              const target = +counter.getAttribute('data-target');
              counter.textContent = target;
            });
          }
        }
        requestAnimationFrame(step);
      }

      if ('IntersectionObserver' in window && counters.length > 0) {
        const counterObserver = new IntersectionObserver((entries) => {
          if (entries[0].isIntersecting && !countersStarted) {
            countersStarted = true;
            runCounters();
          }
        }, { threshold: 0.5 });
        const statsBar = document.querySelector('.border-y.bg-slate-50\\/60');
        if (statsBar) counterObserver.observe(statsBar);
      } else {
        runCounters();
      }

      // 3. 3D Perspective Tilt on Hero Mockup - only on large desktop screens
      const heroCard = document.getElementById('heroMockupCard');
      const heroWrapper = document.getElementById('heroMockupWrapper');

      if (heroWrapper && heroCard && window.innerWidth >= 1024) {
        let tiltFrame = null;
        heroWrapper.addEventListener('mousemove', (e) => {
          if (tiltFrame) cancelAnimationFrame(tiltFrame);
          tiltFrame = requestAnimationFrame(() => {
            const rect = heroWrapper.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = ((y - centerY) / centerY) * -2.5;
            const rotateY = ((x - centerX) / centerX) * 2.5;

            heroCard.style.transform = `perspective(1200px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) scale(1.012)`;
          });
        });

        heroWrapper.addEventListener('mouseleave', () => {
          if (tiltFrame) cancelAnimationFrame(tiltFrame);
          heroCard.style.transform = 'perspective(1200px) rotateX(0deg) rotateY(0deg) scale(1)';
        });
      }

      // 4. CTA and Demo Button Handlers
      const trialTriggers = document.querySelectorAll('.start-trial-trigger');
      trialTriggers.forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.preventDefault();
          toggleMobileMenu(false);
          showMessage('🎉 Welcome to DentaFlow! Sign in with your demo admin account or contact sales.', true);
          setTimeout(openLoginModal, 600);
        });
      });

      const demoBtns = Array.from(document.querySelectorAll('button')).filter(btn => 
        btn.innerText.includes('Start free trial') || btn.innerText.includes('Request free demo')
      );
      demoBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.preventDefault();
          toggleMobileMenu(false);
          showMessage('🎉 Welcome to DentaFlow! Sign in with your demo admin account or contact sales.', true);
          setTimeout(openLoginModal, 600);
        });
      });

      const watchBtn = Array.from(document.querySelectorAll('button')).find(btn => btn.innerText.includes('Watch demo'));
      if(watchBtn) {
        watchBtn.addEventListener('click', () => {
          toggleMobileMenu(false);
          showMessage('🎬 Interactive walkthrough: log in with admin@gmail.com / password123!', true);
          setTimeout(openLoginModal, 600);
        });
      }

      // 5. Login Modal Controls
      const loginModal = document.getElementById('loginModal');
      const loginModalPanel = loginModal?.querySelector('.modal-panel');
      const closeLoginModalBtn = document.getElementById('closeLoginModal');
      const loginEmail = document.getElementById('loginEmail');
      let isLoginModalClosing = false;

      function openLoginModal() {
        if(!loginModal || isLoginModalClosing) return;
        toggleMobileMenu(false);
        loginModal.classList.remove('hidden');
        loginModal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
        requestAnimationFrame(() => {
          loginModal.classList.remove('opacity-0', 'invisible');
          loginModalPanel?.classList.remove('translate-y-4', 'scale-[0.98]', 'opacity-0');
        });
        setTimeout(() => loginEmail?.focus(), 180);
      }

      function closeLoginModal() {
        if(!loginModal || loginModal.classList.contains('hidden') || isLoginModalClosing) return;
        isLoginModalClosing = true;
        loginModal.classList.add('opacity-0', 'invisible');
        loginModalPanel?.classList.add('translate-y-4', 'scale-[0.98]', 'opacity-0');
        setTimeout(() => {
          loginModal.classList.add('hidden');
          loginModal.classList.remove('flex');
          document.body.classList.remove('overflow-hidden');
          isLoginModalClosing = false;
        }, 240);
      }

      // Wire all login triggers (header, mobile drawer, etc.)
      document.querySelectorAll('.open-login-trigger, #openLoginModal').forEach(btn => {
        btn.addEventListener('click', openLoginModal);
      });

      closeLoginModalBtn?.addEventListener('click', closeLoginModal);

      loginModal?.querySelectorAll('[data-close-login-modal]').forEach(element => {
        element.addEventListener('click', closeLoginModal);
      });

      document.addEventListener('keydown', (e) => {
        if(e.key === 'Escape') {
          if (loginModal && !loginModal.classList.contains('hidden')) {
            closeLoginModal();
          } else if (isMobileMenuOpen) {
            toggleMobileMenu(false);
          }
        }
      });

      // Smooth scroll for internal anchor links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
          const targetId = this.getAttribute('href');
          if(targetId && targetId !== '#') {
            const targetElem = document.querySelector(targetId);
            if(targetElem) {
              e.preventDefault();
              targetElem.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
          }
        });
      });
    })();
  </script>
</body>
</html>
