<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Dentcoms | Smart Dental Clinic System</title>
  <!-- Tailwind CSS v3 + Font Awesome Icons -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Google Font: Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
  <style>
    * {
      font-family: 'Inter', sans-serif;
    }
    body {
      background-color: #ffffff;
      scroll-behavior: smooth;
    }
    .hover-card {
      transition: all 0.25s ease-in-out;
    }
    .hover-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.08), 0 4px 8px -4px rgba(0, 0, 0, 0.02);
    }
    .btn-primary {
      transition: all 0.2s ease;
    }
    .btn-primary:hover {
      transform: scale(1.02);
      background-color: #1e3a8a;
    }
    .hero-gradient-bg {
      background: radial-gradient(ellipse at 80% 30%, rgba(219, 234, 254, 0.5), rgba(255,255,255,0));
    }
    input:focus, textarea:focus {
      outline: none;
      ring: 2px solid #3b82f6;
      border-color: #3b82f6;
    }
    #loginModal {
      transition: opacity 240ms ease, visibility 240ms ease;
    }
    #loginModal .modal-panel {
      transition: opacity 240ms ease, transform 240ms cubic-bezier(0.22, 1, 0.36, 1);
    }
  </style>
</head>
<body class="text-gray-800 antialiased">

  <!-- Navigation Bar - clean white -->
  <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-4 flex justify-between items-center">
      <div class="flex items-center gap-2">
        <i class="fas fa-tooth text-3xl text-blue-600"></i>
        <span class="font-bold text-2xl tracking-tight text-gray-800">Dentcoms<span class="text-blue-600">.</span></span>
      </div>
      <div class="hidden md:flex gap-8 text-gray-600 font-medium">
        <a href="#features" class="hover:text-blue-600 transition">Features</a>
        <a href="#how-it-works" class="hover:text-blue-600 transition">How it works</a>
        <a href="#testimonials" class="hover:text-blue-600 transition">Reviews</a>
        <a href="#contact" class="hover:text-blue-600 transition">Contact</a>
      </div>
      <div class="flex gap-3">
        <button id="openLoginModal" type="button" class="hidden sm:inline-block border border-gray-300 text-gray-700 px-5 py-2 rounded-full text-sm font-semibold hover:bg-gray-50 transition">Log in</button>
      </div>
    </div>
  </nav>

  <div id="loginModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-950/55 px-4 opacity-0 invisible">
    <div class="absolute inset-0" data-close-login-modal></div>
    <div class="modal-panel relative w-full max-w-md translate-y-4 scale-[0.98] rounded-3xl border border-slate-200 bg-white p-7 opacity-0 shadow-2xl">
      <button
        id="closeLoginModal"
        type="button"
        class="absolute right-4 top-4 h-10 w-10 rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-slate-700"
        aria-label="Close login modal"
      >
        <i class="fas fa-times"></i>
      </button>
      <div class="mb-6">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Secure Login</p>
        <h2 class="mt-2 text-3xl font-bold text-slate-900">Welcome back</h2>
        <p class="mt-2 text-sm text-slate-500">Enter your Gmail and password to continue.</p>
      </div>
      <form id="loginForm" method="POST" action="login_process.php" class="space-y-4">
        <div>
          <label for="loginEmail" class="mb-2 block text-sm font-semibold text-slate-700">Gmail Address</label>
          <input
            id="loginEmail"
            name="email"
            type="email"
            inputmode="email"
            autocomplete="email"
            placeholder="name@gmail.com"
            required
            class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-slate-800 placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
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
            class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-slate-800 placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
          >
        </div>
        <button type="submit" class="w-full rounded-2xl bg-blue-700 px-5 py-3 font-semibold text-white shadow-md transition hover:bg-blue-800">
          Log in
        </button>
      </form>
    </div>
  </div>

  <!-- Hero Section -->
  <section class="relative overflow-hidden pt-12 pb-20 md:pt-20 md:pb-28 lg:pt-28">
    <div class="hero-gradient-bg absolute inset-0 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 relative z-2">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <div>
          <div class="inline-flex items-center gap-2 bg-blue-50 rounded-full px-4 py-1.5 text-blue-800 text-sm font-medium mb-6">
            <i class="fas fa-microchip text-blue-600 text-xs"></i>
            <span>AI-powered dental suite</span>
          </div>
          <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 leading-tight">
            Modernize your <span class="text-blue-600">dental practice</span> with one intelligent system.
          </h1>
          <p class="text-gray-500 text-lg mt-6 max-w-lg leading-relaxed">
            Dentcoms streamlines appointments, patient records, billing, and analytics — all in a clean, secure platform built for modern clinics.
          </p>
          <div class="flex flex-wrap gap-4 mt-8">
            <button class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-7 py-3 rounded-full shadow-md transition flex items-center gap-2">
              <i class="fas fa-calendar-check"></i> Start free trial
            </button>
            <button class="border border-gray-300 bg-white text-gray-700 font-medium px-7 py-3 rounded-full hover:bg-gray-50 transition flex items-center gap-2">
              <i class="fas fa-play-circle"></i> Watch demo
            </button>
          </div>
          <div class="flex items-center gap-6 mt-8 text-sm text-gray-500">
            <div class="flex items-center gap-1"><i class="fas fa-check-circle text-blue-500"></i> <span>No credit card</span></div>
            <div class="flex items-center gap-1"><i class="fas fa-check-circle text-blue-500"></i> <span>14-day free</span></div>
            <div class="flex items-center gap-1"><i class="fas fa-check-circle text-blue-500"></i> <span>GDPR ready</span></div>
          </div>
        </div>
        <div class="relative flex justify-center">
          <div class="bg-white p-2 rounded-2xl shadow-2xl border border-gray-100">
            <img src="https://placehold.co/600x450/DBEAFE/1E40AF?text=Dentcoms+Dashboard+Preview" alt="Dentcoms dashboard preview" class="rounded-xl w-full object-cover shadow-sm">
          </div>
          <div class="absolute -bottom-4 -left-6 hidden lg:block">
            <div class="bg-white rounded-xl p-3 shadow-lg border border-gray-100 flex items-center gap-2">
              <i class="fas fa-chart-line text-blue-500 text-xl"></i>
              <div><p class="text-xs font-semibold">+37% efficiency</p><p class="text-[10px] text-gray-400">adopted clinics</p></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Trusted by / stats bar -->
  <div class="border-y border-gray-100 bg-gray-50/40 py-5">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 flex flex-wrap justify-between items-center gap-6 text-center md:text-left">
      <div class="flex items-center gap-3"><i class="fas fa-tooth text-blue-500 text-2xl"></i><span class="font-semibold text-gray-700">Trusted by 500+ clinics</span></div>
      <div class="flex items-center gap-3"><i class="fas fa-chart-simple text-blue-500 text-2xl"></i><span class="font-semibold text-gray-700">98% patient satisfaction</span></div>
      <div class="flex items-center gap-3"><i class="fas fa-clock text-blue-500 text-2xl"></i><span class="font-semibold text-gray-700">24/7 secure cloud</span></div>
    </div>
  </div>

  <!-- Features Section -->
  <section id="features" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
      <div class="text-center max-w-2xl mx-auto mb-14">
        <span class="text-blue-600 font-semibold tracking-wide text-sm uppercase flex justify-center items-center gap-1"><i class="fas fa-cogs"></i> Core Capabilities</span>
        <h2 class="text-3xl md:text-4xl font-bold mt-3 text-gray-800">Everything your clinic needs, unified.</h2>
        <p class="text-gray-500 mt-4">Designed for dentists, by healthcare experts. No complexity — just smart workflows.</p>
      </div>
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover-card transition">
          <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-700 text-2xl mb-5"><i class="fas fa-calendar-alt"></i></div>
          <h3 class="text-xl font-bold mb-2">Smart Scheduling</h3>
          <p class="text-gray-500 leading-relaxed">Automated booking, reminders, and double-booking prevention with calendar sync.</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover-card">
          <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-700 text-2xl mb-5"><i class="fas fa-notes-medical"></i></div>
          <h3 class="text-xl font-bold mb-2">Digital Records</h3>
          <p class="text-gray-500 leading-relaxed">Secure EHR, treatment history, X-ray integration &amp; e-prescriptions.</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover-card">
          <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-700 text-2xl mb-5"><i class="fas fa-credit-card"></i></div>
          <h3 class="text-xl font-bold mb-2">Billing & Insurance</h3>
          <p class="text-gray-500 leading-relaxed">Automated invoicing, insurance claims, and real-time payment tracking.</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover-card">
          <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-700 text-2xl mb-5"><i class="fas fa-chart-pie"></i></div>
          <h3 class="text-xl font-bold mb-2">Analytics Hub</h3>
          <p class="text-gray-500 leading-relaxed">Track KPIs, revenue insights, chair utilization &amp; patient retention.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- How it works -->
  <section id="how-it-works" class="py-20 bg-gray-50/60">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
      <div class="text-center mb-12">
        <span class="text-blue-600 font-semibold text-sm uppercase flex justify-center gap-1 items-center"><i class="fas fa-rocket"></i> Simple Setup</span>
        <h2 class="text-3xl font-bold mt-2">Get live in days, not months</h2>
        <p class="text-gray-500 max-w-xl mx-auto mt-3">Streamlined onboarding that empowers your front desk and dentists instantly.</p>
      </div>
      <div class="grid md:grid-cols-3 gap-10">
        <div class="text-center">
          <div class="bg-white w-16 h-16 rounded-2xl flex items-center justify-center text-blue-600 text-2xl shadow-sm border border-gray-100 mx-auto mb-5"><i class="fas fa-user-plus"></i></div>
          <div class="font-bold text-blue-600 text-sm mb-2">STEP 1</div>
          <h3 class="text-xl font-semibold">Onboard clinic</h3>
          <p class="text-gray-500 mt-2 text-sm">Import staff, providers, and customize your working hours & services.</p>
        </div>
        <div class="text-center">
          <div class="bg-white w-16 h-16 rounded-2xl flex items-center justify-center text-blue-600 text-2xl shadow-sm border border-gray-100 mx-auto mb-5"><i class="fas fa-database"></i></div>
          <div class="font-bold text-blue-600 text-sm mb-2">STEP 2</div>
          <h3 class="text-xl font-semibold">Migrate patients</h3>
          <p class="text-gray-500 mt-2 text-sm">Secure data migration or manual entry — our team supports you 24/7.</p>
        </div>
        <div class="text-center">
          <div class="bg-white w-16 h-16 rounded-2xl flex items-center justify-center text-blue-600 text-2xl shadow-sm border border-gray-100 mx-auto mb-5"><i class="fas fa-chalkboard-user"></i></div>
          <div class="font-bold text-blue-600 text-sm mb-2">STEP 3</div>
          <h3 class="text-xl font-semibold">Go live & grow</h3>
          <p class="text-gray-500 mt-2 text-sm">Real-time support, training videos, and continuous updates.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section id="testimonials" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
      <div class="text-center mb-12">
        <i class="fas fa-quote-right text-blue-200 text-4xl mb-2"></i>
        <h2 class="text-3xl font-bold">Trusted by dental leaders</h2>
        <p class="text-gray-500">Real reviews from clinic owners & practice managers.</p>
      </div>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 shadow-sm">
          <div class="flex gap-1 text-yellow-400 mb-3"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
          <p class="text-gray-700 italic">“Dentcoms reduced no-shows by 45% and saved our front desk 10+ hours weekly. The interface is clean and intuitive.”</p>
          <div class="flex items-center gap-3 mt-5">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-700"><i class="fas fa-user-md"></i></div>
            <div><p class="font-semibold">Dr. Sarah Chen</p><p class="text-xs text-gray-400">BrightSmile Dental</p></div>
          </div>
        </div>
        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 shadow-sm">
          <div class="flex gap-1 text-yellow-400 mb-3"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
          <p class="text-gray-700 italic">“Incredible billing automation and insurance claim tracking. Finally a system that understands dental workflows.”</p>
          <div class="flex items-center gap-3 mt-5">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-700"><i class="fas fa-chart-line"></i></div>
            <div><p class="font-semibold">Michael Torres</p><p class="text-xs text-gray-400">Practice Manager, SmileHub</p></div>
          </div>
        </div>
        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 shadow-sm">
          <div class="flex gap-1 text-yellow-400 mb-3"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
          <p class="text-gray-700 italic">“The analytics dashboard gave us visibility into chair utilization and boosted revenue by 22% in 3 months.”</p>
          <div class="flex items-center gap-3 mt-5">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-700"><i class="fas fa-chart-simple"></i></div>
            <div><p class="font-semibold">Dr. James Park</p><p class="text-xs text-gray-400">Elite Dentistry Group</p></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Banner -->
  <section class="py-16">
    <div class="max-w-6xl mx-auto px-6 sm:px-8">
      <div class="bg-blue-50 rounded-3xl p-10 md:p-14 text-center border border-blue-100 shadow-sm">
        <i class="fas fa-cloud-upload-alt text-blue-600 text-4xl mb-4"></i>
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Ready to elevate your dental practice?</h2>
        <p class="text-gray-600 max-w-xl mx-auto mt-3">Join hundreds of modern clinics that switched to Dentcoms. Start your 14-day free trial today.</p>
        <div class="flex flex-wrap justify-center gap-4 mt-8">
          <button class="bg-blue-700 text-white font-semibold px-8 py-3 rounded-full shadow-md hover:bg-blue-800 transition flex items-center gap-2"><i class="fas fa-arrow-right"></i> Request free demo</button>
          <button class="border border-blue-300 bg-white text-blue-800 px-8 py-3 rounded-full font-medium hover:bg-blue-50 transition flex items-center gap-2"><i class="fas fa-headset"></i> Talk to sales</button>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="py-16 border-t border-gray-100 bg-white">
    <div class="max-w-5xl mx-auto px-6 sm:px-8">
      <div class="grid md:grid-cols-2 gap-10 items-center">
        <div>
          <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-2"><i class="fas fa-envelope-open-text text-blue-500"></i> Stay in the loop</h3>
          <p class="text-gray-500 mt-2">Get product updates, dental tech insights, and exclusive offers.</p>
          <div class="flex mt-6 flex-col sm:flex-row gap-3">
            <input type="email" placeholder="Your email address" class="border border-gray-200 rounded-full px-5 py-3 w-full sm:w-72 focus:ring-1 focus:ring-blue-300">
            <button class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-3 rounded-full font-medium transition">Subscribe <i class="fas fa-paper-plane ml-1"></i></button>
          </div>
          <p class="text-xs text-gray-400 mt-3">No spam, unsubscribe anytime.</p>
        </div>
        <div class="flex flex-col gap-3 text-gray-600">
          <div class="flex items-center gap-3"><i class="fas fa-phone-alt w-6 text-blue-500"></i> +1 (888) 234-5678</div>
          <div class="flex items-center gap-3"><i class="fas fa-envelope w-6 text-blue-500"></i> hello@dentcoms.com</div>
          <div class="flex items-center gap-3"><i class="fas fa-map-marker-alt w-6 text-blue-500"></i> 450 Sutter St, San Francisco, CA</div>
          <div class="flex gap-5 mt-2 text-blue-600 text-xl">
            <i class="fab fa-linkedin-in hover:scale-110 transition cursor-pointer"></i>
            <i class="fab fa-twitter hover:scale-110 transition cursor-pointer"></i>
            <i class="fab fa-instagram hover:scale-110 transition cursor-pointer"></i>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-white border-t border-gray-100 py-10">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
      <div class="flex flex-col md:flex-row justify-between items-center gap-5">
        <div class="flex items-center gap-1">
          <i class="fas fa-tooth text-blue-600 text-xl"></i>
          <span class="font-bold text-gray-700 text-lg">Dentcoms</span>
          <span class="text-gray-400 text-sm ml-2">© 2025 — Intelligent Dental OS</span>
        </div>
        <div class="flex gap-8 text-gray-500 text-sm">
          <a href="#" class="hover:text-blue-600">Privacy</a>
          <a href="#" class="hover:text-blue-600">Terms</a>
          <a href="#" class="hover:text-blue-600">Security</a>
          <a href="#" class="hover:text-blue-600">Status</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- JS for interactivity -->
  <script>
    (function() {
      function showMessage(msg, isSuccess = true) {
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-6 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white px-5 py-3 rounded-full shadow-lg flex items-center gap-2 z-50 text-sm font-medium';
        toast.style.animation = 'fadeUp 0.3s ease-out';
        toast.innerHTML = `<i class="fas ${isSuccess ? 'fa-check-circle' : 'fa-info-circle'} text-blue-300"></i> ${msg}`;
        document.body.appendChild(toast);
        setTimeout(() => {
          toast.style.opacity = '0';
          setTimeout(() => toast.remove(), 300);
        }, 2800);
      }
      
      const styleSheet = document.createElement("style");
      styleSheet.textContent = `@keyframes fadeUp { from { opacity:0; transform: translateY(20px) translateX(-50%); } to { opacity:1; transform: translateY(0px) translateX(-50%); } }`;
      document.head.appendChild(styleSheet);
      
      const demoBtns = Array.from(document.querySelectorAll('button')).filter(btn => 
        btn.innerText.includes('Get demo') || btn.innerText.includes('Start free trial') || btn.innerText.includes('Request free demo')
      );
      
      demoBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.preventDefault();
          showMessage('✨ Thanks for your interest! Our team will contact you shortly.', true);
        });
      });
      
      const watchBtn = Array.from(document.querySelectorAll('button')).find(btn => btn.innerText.includes('Watch demo'));
      if(watchBtn) {
        watchBtn.addEventListener('click', () => {
          showMessage('🎬 Demo preview — schedule a full walkthrough? Contact us!', true);
        });
      }
      
      const newsletterBtn = document.querySelector('button:has(.fa-paper-plane)');
      if(newsletterBtn) {
        newsletterBtn.addEventListener('click', () => {
          const emailInput = document.querySelector('input[type="email"]');
          const email = emailInput?.value.trim();
          if(email && email.includes('@') && email.includes('.')) {
            showMessage(`📧 Subscribed with ${email}. Thanks!`, true);
            if(emailInput) emailInput.value = '';
          } else {
            showMessage('Please enter a valid email address.', false);
          }
        });
      }
      
      const loginBtn = document.getElementById('legacyLoginButton');
      if(loginBtn && loginBtn.innerText.includes('Log in')) {
        loginBtn.addEventListener('click', () => showMessage('🔐 Demo login: demo@dentcoms.com / demo123', true));
      }
      
      const loginModal = document.getElementById('loginModal');
      const openLoginModalBtn = document.getElementById('openLoginModal');
      const loginModalPanel = loginModal?.querySelector('.modal-panel');
      const closeLoginModalBtn = document.getElementById('closeLoginModal');
      const loginForm = document.getElementById('loginForm');
      const loginEmail = document.getElementById('loginEmail');
      const loginPassword = document.getElementById('loginPassword');
      let isLoginModalClosing = false;

      function openLoginModal() {
        if(!loginModal || isLoginModalClosing) return;
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

      openLoginModalBtn?.addEventListener('click', openLoginModal);
      closeLoginModalBtn?.addEventListener('click', closeLoginModal);

      loginModal?.querySelectorAll('[data-close-login-modal]').forEach(element => {
        element.addEventListener('click', closeLoginModal);
      });

      loginForm?.addEventListener('submit', (e) => {
        const email = loginEmail?.value.trim() || '';
        const password = loginPassword?.value || '';

        if(!email.toLowerCase().endsWith('@gmail.com')) {
          e.preventDefault();
          showMessage('Please enter a valid Gmail address.', false);
          loginEmail?.focus();
          return;
        }

        if(!password) {
          e.preventDefault();
          showMessage('Please enter your password.', false);
          loginPassword?.focus();
          return;
        }

        closeLoginModal();
      });

      document.addEventListener('keydown', (e) => {
        if(e.key === 'Escape' && loginModal && !loginModal.classList.contains('hidden')) {
          closeLoginModal();
        }
      });

      const talkSales = Array.from(document.querySelectorAll('button')).find(btn => btn.innerText.includes('Talk to sales'));
      if(talkSales) talkSales.addEventListener('click', () => showMessage('📞 Request a call — we’ll reply in 24h', true));
      
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
