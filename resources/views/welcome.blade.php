<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SmartSchool — SMK Bustanul Ulum</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet" />
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            display: ['Plus Jakarta Sans', 'sans-serif'],
            body:    ['DM Sans', 'sans-serif'],
          },
          colors: {
            brand: {
              50:  '#eef6ff', 100: '#d9ebff', 200: '#bbdaff',
              300: '#8ec3ff', 400: '#59a3f8', 500: '#3582f0',
              600: '#1f63db', 700: '#1750c0', 800: '#18429b',
              900: '#193b7a', 950: '#132651',
            },
          },
          keyframes: {
            fadeUp:  { from: { opacity: '0', transform: 'translateY(28px)' }, to: { opacity: '1', transform: 'translateY(0)' } },
            fadeIn:  { from: { opacity: '0' }, to: { opacity: '1' } },
            livePulse: {
              '0%,100%': { boxShadow: '0 0 0 0 rgba(74,222,128,0.55)' },
              '50%':     { boxShadow: '0 0 0 7px rgba(74,222,128,0)' },
            },
          },
          animation: {
            'fade-up':    'fadeUp 0.65s cubic-bezier(.22,.68,0,1.2) both',
            'fade-in':    'fadeIn 0.5s ease both',
            'live-pulse': 'livePulse 2.2s ease-in-out infinite',
          },
        }
      }
    }
  </script>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; }
    .font-display, h1, h2, h3, h4 { font-family: 'Plus Jakarta Sans', sans-serif; }

    /* ── Hero background ── */
    .hero-bg {
      background: linear-gradient(140deg, #0d1f4e 0%, #1750c0 48%, #0a6b4a 100%);
      position: relative; overflow: hidden;
    }
    .hero-bg::before {
      content: '';
      position: absolute; inset: 0; pointer-events: none;
      background:
        radial-gradient(ellipse 700px 500px at 80% -5%,  rgba(89,163,248,.30) 0%, transparent 70%),
        radial-gradient(ellipse 450px 450px at  5% 95%, rgba(16,185,129,.22) 0%, transparent 65%);
    }
    .hero-bg::after {
      content: '';
      position: absolute; inset: 0; pointer-events: none;
      background-image: radial-gradient(circle, rgba(255,255,255,.035) 1px, transparent 1px);
      background-size: 44px 44px;
    }

    /* ── Glass ── */
    .glass {
      background: rgba(255,255,255,.07);
      border: 1px solid rgba(255,255,255,.13);
      backdrop-filter: blur(14px);
    }

    /* ── Gradient text ── */
    .text-grad {
      background: linear-gradient(120deg, #93c5fd 0%, #a5f3fc 50%, #6ee7b7 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* ── Wave divider ── */
    .wave-divider svg { display: block; }

    /* ── Navbar scroll ── */
    .nav-scrolled {
      background: rgba(255,255,255,.96) !important;
      backdrop-filter: blur(18px) !important;
      border-bottom: 1px solid #e2e8f0 !important;
    }
    .nav-scrolled .nl  { color: #1e293b !important; }
    .nav-scrolled .nl:hover { background: #f1f5f9 !important; }
    .nav-scrolled .nbrand  { color: #1e293b !important; }
    .nav-scrolled .nsubb   { color: #64748b !important; }
    .nav-scrolled .nring   { background: #eef6ff !important; border-color: #bfdbfe !important; }
    .nav-scrolled .nrtext  { color: #1750c0 !important; }
    .nav-scrolled .ncta    { background: #1f63db !important; color: #fff !important; border-color: #1f63db !important; }
    .nav-scrolled .hbar    { background: #334155 !important; }

    /* ── Feature card ── */
    .fcard { transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease; }
    .fcard:hover { transform: translateY(-5px); box-shadow: 0 8px 40px rgba(31,99,219,.13); border-color: #93c5fd; }
    .fcard:hover .arrow { transform: translateX(5px); }
    .arrow { transition: transform .18s ease; display: inline-block; }

    /* ── Role pill ── */
    .rpill {
      display: inline-flex; align-items: center; gap: 3px;
      font-size: 10px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase;
      padding: 2px 9px; border-radius: 99px;
    }

    /* ── Mobile menu ── */
    #mmenu { display: none; }
    #mmenu.open { display: flex; }

    /* ── Scrollbar ── */
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: #f1f5f9; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }

    /* ── CTA section ── */
    .cta-bg {
      background: linear-gradient(140deg, #0d1f4e 0%, #1750c0 50%, #0a6b4a 100%);
      position: relative; overflow: hidden;
    }
    .cta-bg::before {
      content: '';
      position: absolute; inset: 0; pointer-events: none;
      background:
        radial-gradient(ellipse 500px 350px at 85% 40%, rgba(255,255,255,.06) 0%, transparent 70%),
        radial-gradient(ellipse 350px 350px at 10% 60%, rgba(16,185,129,.15) 0%, transparent 70%);
    }

    /* ── Info strip ── */
    .info-bg { background: linear-gradient(100deg, #f8fafc 0%, #eef6ff 55%, #ecfdf5 100%); }

    /* scroll reveal initial state */
    .sr { opacity: 0; transform: translateY(26px); }
  </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

<!-- ═══════ NAVBAR ═══════ -->
<header id="nav" class="fixed inset-x-0 top-0 z-50 transition-all duration-300">
  <div class="max-w-7xl mx-auto px-5 h-16 flex items-center justify-between gap-4">

    <!-- Brand -->
    <a href="index.html" class="flex items-center gap-2.5 shrink-0">
      <div class="nring w-9 h-9 rounded-xl border border-white/20 bg-white/10 flex items-center justify-center transition-all duration-300">
        <span class="nrtext font-display font-extrabold text-white text-sm transition-all duration-300">B</span>
      </div>
      <div>
        <p class="nbrand font-display font-bold text-white text-sm leading-none transition-all duration-300">SmartSchool</p>
        <p class="nsubb text-white/55 text-[11px] transition-all duration-300">SMK Bustanul Ulum</p>
      </div>
    </a>

    <!-- Desktop links -->
    <nav class="hidden md:flex items-center gap-0.5">
      <a href="#"      class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Beranda</a>
      <a href="#fitur" class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Fitur</a>
      <a href="#info"  class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Tentang</a>
      <a href="#footer" class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Kontak</a>
    </nav>

    <!-- CTA -->
    <a href="{{ route('login') }}" class="ncta hidden md:inline-flex items-center gap-1.5 text-sm font-semibold font-display text-white border border-white/30 hover:border-white/60 hover:bg-white/12 px-5 py-2 rounded-xl transition-all duration-200">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
      Masuk
    </a>

    <!-- Hamburger -->
    <button class="md:hidden p-2 flex flex-col gap-1.5" onclick="toggleMenu()">
      <span class="hbar w-5 h-0.5 bg-white rounded transition-all"></span>
      <span class="hbar w-5 h-0.5 bg-white rounded transition-all"></span>
      <span class="hbar w-5 h-0.5 bg-white rounded transition-all"></span>
    </button>
  </div>

  <!-- Mobile menu -->
  <div id="mmenu" class="flex-col md:hidden bg-brand-950/95 backdrop-blur-xl border-t border-white/10 px-5 py-4 gap-1">
    <a href="#" class="text-white/75 hover:text-white text-sm px-3 py-2.5 rounded-lg hover:bg-white/10 flex items-center transition-all">Beranda</a>
    <a href="#fitur" onclick="toggleMenu()" class="text-white/75 hover:text-white text-sm px-3 py-2.5 rounded-lg hover:bg-white/10 flex items-center transition-all">Fitur</a>
    <a href="#info" onclick="toggleMenu()" class="text-white/75 hover:text-white text-sm px-3 py-2.5 rounded-lg hover:bg-white/10 flex items-center transition-all">Tentang</a>
    <a href="#footer" onclick="toggleMenu()" class="text-white/75 hover:text-white text-sm px-3 py-2.5 rounded-lg hover:bg-white/10 flex items-center transition-all">Kontak</a>
    <a href="{{ route('login') }}" class="mt-2 bg-brand-500 hover:bg-brand-600 text-white font-display font-semibold text-sm py-2.5 rounded-xl flex items-center justify-center gap-2 transition-all">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
      Masuk ke Sistem
    </a>
  </div>
</header>

<!-- ═══════ HERO ═══════ -->
<section class="hero-bg min-h-screen flex flex-col justify-center pt-16">
  <div class="max-w-4xl mx-auto px-5 py-28 relative z-10 text-center">

    <!-- Badge -->
    <div class="animate-fade-up inline-flex items-center gap-2 glass text-white/85 text-[11px] font-display font-semibold px-4 py-2 rounded-full mb-8 tracking-wider uppercase">
      <span class="animate-live-pulse w-2 h-2 rounded-full bg-emerald-400 shrink-0"></span>
      Platform Aktif · Tahun Ajaran 2025/2026
    </div>

    <!-- Title -->
    <h1 class="animate-fade-up [animation-delay:.1s] font-display font-extrabold text-4xl sm:text-5xl md:text-6xl leading-[1.15] text-white mb-5">
      Sistem Informasi Digital<br>
      <span class="text-grad">SMK Bustanul Ulum</span>
    </h1>

    <p class="animate-fade-up [animation-delay:.2s] text-white/60 text-base sm:text-lg leading-relaxed mb-10 max-w-xl mx-auto">
      Satu platform terpadu untuk pembelajaran, absensi, monitoring kedisiplinan, dan komunikasi sekolah yang lebih cerdas.
    </p>

    <!-- Buttons -->
    <div class="animate-fade-up [animation-delay:.3s] flex flex-col sm:flex-row gap-3 justify-center mb-16">
      <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 bg-white text-brand-700 font-display font-bold text-sm px-8 py-3.5 rounded-xl hover:bg-blue-50 shadow-[0_8px_40px_rgba(19,38,81,.4)] hover:shadow-[0_0_40px_rgba(53,130,240,.35)] transition-all duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        Masuk ke Sistem
      </a>
      <a href="#fitur" class="inline-flex items-center justify-center gap-2 glass text-white font-display font-semibold text-sm px-8 py-3.5 rounded-xl hover:bg-white/15 transition-all duration-200">
        Lihat Fitur
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
      </a>
    </div>

    <!-- Stats bar -->
    <div class="animate-fade-up [animation-delay:.45s] grid grid-cols-2 sm:grid-cols-4 glass rounded-2xl overflow-hidden divide-x divide-white/10">
      <div class="py-5 px-4 text-center">
        <p class="font-display font-extrabold text-2xl text-white">6</p>
        <p class="text-white/45 text-xs mt-1">Modul Fitur</p>
      </div>
      <div class="py-5 px-4 text-center">
        <p class="font-display font-extrabold text-2xl text-white">500+</p>
        <p class="text-white/45 text-xs mt-1">Pengguna Aktif</p>
      </div>
      <div class="py-5 px-4 text-center">
        <p class="font-display font-extrabold text-2xl text-white">5</p>
        <p class="text-white/45 text-xs mt-1">Jenis Role</p>
      </div>
      <div class="py-5 px-4 text-center">
        <p class="font-display font-extrabold text-xl text-white">Real-time</p>
        <p class="text-white/45 text-xs mt-1">Monitoring</p>
      </div>
    </div>
  </div>

  <!-- Wave -->
  <div class="wave-divider -mb-px">
    <svg viewBox="0 0 1440 72" xmlns="http://www.w3.org/2000/svg" class="w-full">
      <path d="M0,36 C360,72 720,0 1080,36 C1260,54 1380,24 1440,36 L1440,72 L0,72 Z" fill="#f8fafc"/>
    </svg>
  </div>
</section>

<!-- ═══════ FEATURES ═══════ -->
<section id="fitur" class="bg-slate-50 py-24">
  <div class="max-w-7xl mx-auto px-5">

    <!-- Header -->
    <div class="text-center mb-14 sr">
      <span class="inline-block text-brand-600 text-[11px] font-display font-bold tracking-widest uppercase bg-brand-50 border border-brand-100 px-4 py-1.5 rounded-full mb-4">Fitur Unggulan</span>
      <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-slate-900 mb-3">Semua kebutuhan sekolah<br class="hidden sm:block"> dalam satu platform</h2>
      <p class="text-slate-500 text-sm max-w-sm mx-auto leading-relaxed">Klik kartu untuk langsung masuk ke modul yang Anda butuhkan.</p>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

      <!-- ① LMS -->
      <a href="login.html" class="fcard sr bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-5 shadow-[0_1px_3px_rgba(0,0,0,.05),0_4px_16px_rgba(0,0,0,.06)] relative overflow-hidden">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-brand-500 to-brand-400 rounded-t-2xl"></div>
        <span class="absolute top-4 right-4 rpill bg-brand-50 text-brand-700 border border-brand-100">Utama</span>

        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center shadow-lg shadow-brand-500/30">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
          </svg>
        </div>

        <div class="flex-1">
          <h3 class="font-display font-bold text-slate-900 text-lg mb-1.5">LMS System</h3>
          <p class="text-slate-500 text-sm leading-relaxed mb-4">Kelola materi pembelajaran, tugas interaktif, dan ujian daring dalam satu ruang belajar digital yang terstruktur.</p>
          <div class="flex flex-wrap gap-1.5">
            <span class="rpill bg-brand-50 text-brand-700 border border-brand-100">Materi</span>
            <span class="rpill bg-emerald-50 text-emerald-700 border border-emerald-100">Tugas Online</span>
            <span class="rpill bg-violet-50 text-violet-700 border border-violet-100">Ujian Daring</span>
          </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
          <div class="flex items-center gap-2">
            <div class="flex -space-x-1.5">
              <div class="w-6 h-6 rounded-full bg-brand-100 border-2 border-white flex items-center justify-center text-[9px] font-bold text-brand-700">G</div>
              <div class="w-6 h-6 rounded-full bg-emerald-100 border-2 border-white flex items-center justify-center text-[9px] font-bold text-emerald-700">S</div>
            </div>
            <span class="text-slate-400 text-xs">Guru & Siswa</span>
          </div>
          <span class="text-brand-600 text-sm font-semibold font-display flex items-center gap-1">Buka <span class="arrow">→</span></span>
        </div>
      </a>

      <!-- ② Absensi -->
      <a href="login.html" class="fcard sr bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-5 shadow-[0_1px_3px_rgba(0,0,0,.05),0_4px_16px_rgba(0,0,0,.06)] relative overflow-hidden">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-emerald-500 to-teal-400 rounded-t-2xl"></div>

        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            <path d="M8 14h.01M12 14h.01M16 14h.01"/>
          </svg>
        </div>

        <div class="flex-1">
          <h3 class="font-display font-bold text-slate-900 text-lg mb-1.5">Absensi Hybrid</h3>
          <p class="text-slate-500 text-sm leading-relaxed mb-4">Sistem kehadiran kombinasi manual dan QR Code dengan rekap otomatis per kelas dan mata pelajaran.</p>
          <div class="flex flex-wrap gap-1.5">
            <span class="rpill bg-emerald-50 text-emerald-700 border border-emerald-100">QR Code</span>
            <span class="rpill bg-emerald-50 text-emerald-700 border border-emerald-100">Manual</span>
            <span class="rpill bg-amber-50 text-amber-700 border border-amber-100">IoT Ready</span>
          </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
          <div class="flex items-center gap-2">
            <div class="flex -space-x-1.5">
              <div class="w-6 h-6 rounded-full bg-amber-100 border-2 border-white flex items-center justify-center text-[9px] font-bold text-amber-700">P</div>
              <div class="w-6 h-6 rounded-full bg-emerald-100 border-2 border-white flex items-center justify-center text-[9px] font-bold text-emerald-700">S</div>
            </div>
            <span class="text-slate-400 text-xs">Piket & Siswa</span>
          </div>
          <span class="text-emerald-600 text-sm font-semibold font-display flex items-center gap-1">Buka <span class="arrow">→</span></span>
        </div>
      </a>

      <!-- ③ Guru Piket -->
      <a href="login.html" class="fcard sr bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-5 shadow-[0_1px_3px_rgba(0,0,0,.05),0_4px_16px_rgba(0,0,0,.06)] relative overflow-hidden">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-amber-500 to-orange-400 rounded-t-2xl"></div>

        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/30">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
          </svg>
        </div>

        <div class="flex-1">
          <h3 class="font-display font-bold text-slate-900 text-lg mb-1.5">Guru Piket</h3>
          <p class="text-slate-500 text-sm leading-relaxed mb-4">Dashboard kendali harian untuk memantau kedisiplinan, mencatat pelanggaran, dan melaporkan kelas kosong secara real-time.</p>
          <div class="flex flex-wrap gap-1.5">
            <span class="rpill bg-amber-50 text-amber-700 border border-amber-100">Monitoring</span>
            <span class="rpill bg-amber-50 text-amber-700 border border-amber-100">Pelanggaran</span>
            <span class="rpill bg-orange-50 text-orange-700 border border-orange-100">Laporan Harian</span>
          </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
          <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-amber-100 border-2 border-white flex items-center justify-center text-[9px] font-bold text-amber-700">P</div>
            <span class="text-slate-400 text-xs">Guru Piket</span>
          </div>
          <span class="text-amber-600 text-sm font-semibold font-display flex items-center gap-1">Buka <span class="arrow">→</span></span>
        </div>
      </a>

      <!-- ④ Portal Ortu -->
      <a href="login.html" class="fcard sr bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-5 shadow-[0_1px_3px_rgba(0,0,0,.05),0_4px_16px_rgba(0,0,0,.06)] relative overflow-hidden">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-violet-500 to-purple-500 rounded-t-2xl"></div>

        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center shadow-lg shadow-violet-500/30">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </div>

        <div class="flex-1">
          <h3 class="font-display font-bold text-slate-900 text-lg mb-1.5">Portal Ortu &amp; Siswa</h3>
          <p class="text-slate-500 text-sm leading-relaxed mb-4">Hubungkan orang tua dengan perkembangan akademik anak secara real-time — nilai, absensi, dan pengumuman sekolah.</p>
          <div class="flex flex-wrap gap-1.5">
            <span class="rpill bg-violet-50 text-violet-700 border border-violet-100">Real-time</span>
            <span class="rpill bg-violet-50 text-violet-700 border border-violet-100">Notifikasi</span>
            <span class="rpill bg-emerald-50 text-emerald-700 border border-emerald-100">Transparan</span>
          </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
          <div class="flex items-center gap-2">
            <div class="flex -space-x-1.5">
              <div class="w-6 h-6 rounded-full bg-violet-100 border-2 border-white flex items-center justify-center text-[9px] font-bold text-violet-700">O</div>
              <div class="w-6 h-6 rounded-full bg-emerald-100 border-2 border-white flex items-center justify-center text-[9px] font-bold text-emerald-700">S</div>
            </div>
            <span class="text-slate-400 text-xs">Orang Tua & Siswa</span>
          </div>
          <span class="text-violet-600 text-sm font-semibold font-display flex items-center gap-1">Buka <span class="arrow">→</span></span>
        </div>
      </a>

      <!-- ⑤ Aplikasi Guru -->
      <a href="login.html" class="fcard sr bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-5 shadow-[0_1px_3px_rgba(0,0,0,.05),0_4px_16px_rgba(0,0,0,.06)] relative overflow-hidden">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-pink-500 to-rose-400 rounded-t-2xl"></div>

        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center shadow-lg shadow-pink-500/30">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 2v5M12 2v5M8 2v5"/>
          </svg>
        </div>

        <div class="flex-1">
          <h3 class="font-display font-bold text-slate-900 text-lg mb-1.5">Aplikasi Guru</h3>
          <p class="text-slate-500 text-sm leading-relaxed mb-4">Asisten digital untuk mengelola jurnal mengajar, penilaian siswa, rekap nilai, dan perangkat ajar dalam satu aplikasi efisien.</p>
          <div class="flex flex-wrap gap-1.5">
            <span class="rpill bg-pink-50 text-pink-700 border border-pink-100">Jurnal Mengajar</span>
            <span class="rpill bg-violet-50 text-violet-700 border border-violet-100">Input Nilai</span>
            <span class="rpill bg-brand-50 text-brand-700 border border-brand-100">Rekap Otomatis</span>
          </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
          <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-pink-100 border-2 border-white flex items-center justify-center text-[9px] font-bold text-pink-700">G</div>
            <span class="text-slate-400 text-xs">Guru</span>
          </div>
          <span class="text-pink-600 text-sm font-semibold font-display flex items-center gap-1">Buka <span class="arrow">→</span></span>
        </div>
      </a>

      <!-- ⑥ Manajemen -->
      <a href="login.html" class="fcard sr bg-white rounded-2xl border border-slate-200 p-6 flex flex-col gap-5 shadow-[0_1px_3px_rgba(0,0,0,.05),0_4px_16px_rgba(0,0,0,.06)] relative overflow-hidden">
        <div class="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-slate-600 to-slate-500 rounded-t-2xl"></div>

        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center shadow-lg shadow-slate-700/30">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/>
            <path d="M15.54 8.46a5 5 0 0 1 0 7.07M8.46 8.46a5 5 0 0 0 0 7.07"/>
          </svg>
        </div>

        <div class="flex-1">
          <h3 class="font-display font-bold text-slate-900 text-lg mb-1.5">Manajemen Sekolah</h3>
          <p class="text-slate-500 text-sm leading-relaxed mb-4">Pusat kendali administrasi sekolah — data master, pengaturan pengguna, role akses, dan konfigurasi sistem secara menyeluruh.</p>
          <div class="flex flex-wrap gap-1.5">
            <span class="rpill bg-slate-100 text-slate-600 border border-slate-200">Admin Panel</span>
            <span class="rpill bg-slate-100 text-slate-600 border border-slate-200">Data Master</span>
            <span class="rpill bg-slate-100 text-slate-600 border border-slate-200">Role Akses</span>
          </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
          <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-slate-200 border-2 border-white flex items-center justify-center text-[9px] font-bold text-slate-700">A</div>
            <span class="text-slate-400 text-xs">Admin</span>
          </div>
          <span class="text-slate-600 text-sm font-semibold font-display flex items-center gap-1">Buka <span class="arrow">→</span></span>
        </div>
      </a>

    </div>
  </div>
</section>

<!-- ═══════ INFO STRIP ═══════ -->
<section id="info" class="info-bg border-y border-slate-200">
  <div class="max-w-7xl mx-auto px-5 py-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

    <div class="sr flex items-start gap-4">
      <div class="w-10 h-10 rounded-xl bg-brand-50 border border-brand-100 flex items-center justify-center shrink-0">
        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
      </div>
      <div>
        <h4 class="font-display font-bold text-slate-900 text-sm mb-1">Aman &amp; Terenkripsi</h4>
        <p class="text-slate-500 text-xs leading-relaxed">Autentikasi berlapis dengan role-based access control untuk setiap pengguna.</p>
      </div>
    </div>

    <div class="sr flex items-start gap-4">
      <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center shrink-0">
        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
      </div>
      <div>
        <h4 class="font-display font-bold text-slate-900 text-sm mb-1">Responsive &amp; Mobile</h4>
        <p class="text-slate-500 text-xs leading-relaxed">Diakses dari komputer maupun smartphone dengan tampilan optimal di semua ukuran layar.</p>
      </div>
    </div>

    <div class="sr flex items-start gap-4">
      <div class="w-10 h-10 rounded-xl bg-violet-50 border border-violet-100 flex items-center justify-center shrink-0">
        <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
      </div>
      <div>
        <h4 class="font-display font-bold text-slate-900 text-sm mb-1">Real-time Monitoring</h4>
        <p class="text-slate-500 text-xs leading-relaxed">Data kehadiran, nilai, dan pelanggaran tersaji secara langsung tanpa jeda waktu.</p>
      </div>
    </div>

    <div class="sr flex items-start gap-4">
      <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center shrink-0">
        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
      </div>
      <div>
        <h4 class="font-display font-bold text-slate-900 text-sm mb-1">Backup Otomatis</h4>
        <p class="text-slate-500 text-xs leading-relaxed">Data tersimpan aman dengan mekanisme backup berkala yang konsisten dan terjamin.</p>
      </div>
    </div>

  </div>
</section>

<!-- ═══════ CTA ═══════ -->
<section class="cta-bg py-24">
  <div class="max-w-2xl mx-auto px-5 text-center relative z-10">
    <span class="inline-block text-emerald-300 text-[11px] font-display font-bold tracking-widest uppercase glass px-4 py-1.5 rounded-full mb-6">Mulai Sekarang</span>
    <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-white mb-4 leading-tight">Siap memulai era digital<br>SMK Bustanul Ulum?</h2>
    <p class="text-white/60 text-sm mb-10 leading-relaxed">Masuk menggunakan akun yang telah disiapkan oleh administrator sekolah Anda.</p>
    <a href="login.html" class="inline-flex items-center gap-2 bg-white text-brand-700 font-display font-bold text-sm px-10 py-4 rounded-xl shadow-[0_8px_40px_rgba(19,38,81,.4)] hover:bg-blue-50 hover:shadow-[0_0_40px_rgba(53,130,240,.3)] transition-all duration-200">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
      Masuk ke Sistem
    </a>
  </div>
</section>

<!-- ═══════ FOOTER ═══════ -->
<footer id="footer" class="bg-slate-900 text-white">
  <div class="max-w-7xl mx-auto px-5 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10">

      <div>
        <div class="flex items-center gap-2.5 mb-4">
          <div class="w-9 h-9 rounded-xl bg-brand-700 flex items-center justify-center">
            <span class="font-display font-extrabold text-white text-sm">B</span>
          </div>
          <div>
            <p class="font-display font-bold text-white text-sm leading-none">SmartSchool</p>
            <p class="text-slate-500 text-xs">SMK Bustanul Ulum</p>
          </div>
        </div>
        <p class="text-slate-400 text-sm leading-relaxed">Platform informasi manajemen sekolah berbasis web yang dikembangkan oleh mahasiswa Universitas Cipasung Tasikmalaya.</p>
      </div>

      <div>
        <h4 class="font-display font-bold text-white text-sm mb-4">Navigasi</h4>
        <ul class="space-y-2.5">
          <li><a href="#" class="text-slate-400 hover:text-white text-sm transition-colors">Beranda</a></li>
          <li><a href="#fitur" class="text-slate-400 hover:text-white text-sm transition-colors">Fitur</a></li>
          <li><a href="login.html" class="text-slate-400 hover:text-white text-sm transition-colors">Masuk</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-display font-bold text-white text-sm mb-4">Kontak &amp; Info</h4>
        <ul class="space-y-2.5">
          <li class="flex items-center gap-2 text-slate-400 text-sm">
            <svg class="w-4 h-4 shrink-0 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            Tasikmalaya, Jawa Barat
          </li>
          <li class="flex items-center gap-2 text-slate-400 text-sm">
            <svg class="w-4 h-4 shrink-0 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Universitas Cipasung Tasikmalaya
          </li>
          <li class="flex items-center gap-2 text-slate-400 text-sm">
            <svg class="w-4 h-4 shrink-0 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            rpl@cipasung.ac.id
          </li>
        </ul>
      </div>
    </div>

    <div class="border-t border-slate-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
      <p class="text-slate-500 text-xs">© 2026 SmartSchool SMK Bustanul Ulum · Sutiawan Djody, Nizar Aminur Rohman, Abdul Basit.</p>
      <div class="flex gap-5">
        <a href="#" class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Kebijakan Privasi</a>
        <a href="#" class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Bantuan</a>
      </div>
    </div>
  </div>
</footer>

<!-- ═══════ SCRIPTS ═══════ -->
<script>
  // Navbar scroll effect
  const nav = document.getElementById('nav');
  window.addEventListener('scroll', () => {
    nav.classList.toggle('nav-scrolled', window.scrollY > 56);
  });

  // Mobile menu
  function toggleMenu() {
    document.getElementById('mmenu').classList.toggle('open');
  }

  // Smooth scroll
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const t = document.querySelector(a.getAttribute('href'));
      if (t) { e.preventDefault(); t.scrollIntoView({ behavior: 'smooth' }); }
    });
  });

  // Scroll reveal
  const io = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const delay = el.dataset.delay || 0;
        setTimeout(() => {
          el.style.opacity = '1';
          el.style.transform = 'translateY(0)';
        }, delay);
        io.unobserve(el);
      }
    });
  }, { threshold: 0.08 });

  document.querySelectorAll('.sr').forEach((el, i) => {
    el.style.transition = 'opacity 0.55s ease, transform 0.55s ease';
    el.dataset.delay = i * 80;
    io.observe(el);
  });
</script>

</body>
</html>