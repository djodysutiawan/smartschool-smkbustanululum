<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $profil->nama_sekolah ?? 'SmartSchool' }} — {{ $profil->singkatan ?? 'SMK Bustanul Ulum' }}</title>
  <meta name="description" content="{{ $profil->meta_description ?? $profil->deskripsi_singkat ?? 'Platform informasi digital sekolah' }}">
  <meta name="keywords" content="{{ $profil->meta_keywords ?? '' }}">

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet" />
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
              50:'#eef6ff',100:'#d9ebff',200:'#bbdaff',
              300:'#8ec3ff',400:'#59a3f8',500:'#3582f0',
              600:'#1f63db',700:'#1750c0',800:'#18429b',
              900:'#193b7a',950:'#132651',
            },
          },
          keyframes: {
            fadeUp:   { from:{opacity:'0',transform:'translateY(28px)'}, to:{opacity:'1',transform:'translateY(0)'} },
            fadeIn:   { from:{opacity:'0'}, to:{opacity:'1'} },
            slideLeft:{ from:{opacity:'0',transform:'translateX(40px)'}, to:{opacity:'1',transform:'translateX(0)'} },
            livePulse:{ '0%,100%':{boxShadow:'0 0 0 0 rgba(74,222,128,0.55)'},'50%':{boxShadow:'0 0 0 8px rgba(74,222,128,0)'} },
            float:    { '0%,100%':{transform:'translateY(0px)'},'50%':{transform:'translateY(-10px)'} },
            shimmer:  { from:{backgroundPosition:'-200% 0'}, to:{backgroundPosition:'200% 0'} },
          },
          animation: {
            'fade-up':    'fadeUp 0.65s cubic-bezier(.22,.68,0,1.2) both',
            'fade-in':    'fadeIn 0.5s ease both',
            'slide-left': 'slideLeft 0.6s cubic-bezier(.22,.68,0,1.2) both',
            'live-pulse': 'livePulse 2.2s ease-in-out infinite',
            'float':      'float 4s ease-in-out infinite',
          },
        }
      }
    }
  </script>
  <style>
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'DM Sans',sans-serif; }
    h1,h2,h3,h4,.font-display { font-family:'Plus Jakarta Sans',sans-serif; }

    /* ── Hero ── */
    .hero-bg {
      background: linear-gradient(140deg,#0d1f4e 0%,#1750c0 48%,#0a6b4a 100%);
      position:relative; overflow:hidden;
    }
    .hero-bg::before {
      content:''; position:absolute; inset:0; pointer-events:none;
      background:
        radial-gradient(ellipse 700px 500px at 80% -5%, rgba(89,163,248,.30) 0%,transparent 70%),
        radial-gradient(ellipse 450px 450px at 5% 95%,  rgba(16,185,129,.22) 0%,transparent 65%);
    }
    .hero-bg::after {
      content:''; position:absolute; inset:0; pointer-events:none;
      background-image:radial-gradient(circle,rgba(255,255,255,.035) 1px,transparent 1px);
      background-size:44px 44px;
    }

    /* ── Glass ── */
    .glass { background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.14); backdrop-filter:blur(14px); }
    .glass-dark { background:rgba(0,0,0,.25); border:1px solid rgba(255,255,255,.1); backdrop-filter:blur(14px); }

    /* ── Gradient text ── */
    .text-grad {
      background:linear-gradient(120deg,#93c5fd 0%,#a5f3fc 50%,#6ee7b7 100%);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
    }
    .text-grad-gold {
      background:linear-gradient(120deg,#fbbf24 0%,#f59e0b 50%,#d97706 100%);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
    }

    /* ── Navbar ── */
    .nav-scrolled {
      background:rgba(255,255,255,.96) !important;
      backdrop-filter:blur(18px) !important;
      border-bottom:1px solid #e2e8f0 !important;
    }
    .nav-scrolled .nl     { color:#1e293b !important; }
    .nav-scrolled .nl:hover { background:#f1f5f9 !important; }
    .nav-scrolled .nbrand { color:#1e293b !important; }
    .nav-scrolled .nsubb  { color:#64748b !important; }
    .nav-scrolled .nring  { background:#eef6ff !important; border-color:#bfdbfe !important; }
    .nav-scrolled .nrtext { color:#1750c0 !important; }
    .nav-scrolled .ncta   { background:#1f63db !important; color:#fff !important; border-color:#1f63db !important; }
    .nav-scrolled .hbar   { background:#334155 !important; }

    /* ── Cards ── */
    .fcard { transition:transform .22s ease,box-shadow .22s ease,border-color .22s ease; }
    .fcard:hover { transform:translateY(-5px); box-shadow:0 8px 40px rgba(31,99,219,.13); border-color:#93c5fd; }
    .fcard:hover .arrow { transform:translateX(5px); }
    .arrow { transition:transform .18s ease; display:inline-block; }

    /* ── Role pill ── */
    .rpill {
      display:inline-flex; align-items:center; gap:3px;
      font-size:10px; font-weight:700; letter-spacing:.05em; text-transform:uppercase;
      padding:2px 9px; border-radius:99px;
    }

    /* ── Slider ── */
    .slider-wrapper { position:relative; overflow:hidden; }
    .slider-track { display:flex; transition:transform .6s cubic-bezier(.4,0,.2,1); }
    .slider-slide { min-width:100%; }

    /* ── News card hover ── */
    .news-card { transition:transform .2s ease,box-shadow .2s ease; }
    .news-card:hover { transform:translateY(-4px); box-shadow:0 12px 40px rgba(0,0,0,.1); }
    .news-card:hover .news-img { transform:scale(1.06); }
    .news-img { transition:transform .45s ease; }

    /* ── Prestasi badge ── */
    .prestasi-badge {
      display:inline-flex; align-items:center; gap:4px;
      padding:3px 10px; border-radius:99px; font-size:11px; font-weight:700;
    }

    /* ── Section heading ── */
    .section-label {
      display:inline-block; text-transform:uppercase; letter-spacing:.12em;
      font-size:11px; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif;
    }

    /* ── Galeri ── */
    .galeri-item { overflow:hidden; border-radius:12px; cursor:pointer; }
    .galeri-item img { transition:transform .45s ease; width:100%; height:100%; object-fit:cover; }
    .galeri-item:hover img { transform:scale(1.08); }
    .galeri-overlay {
      position:absolute; inset:0; background:linear-gradient(to top,rgba(0,0,0,.7) 0%,transparent 50%);
      opacity:0; transition:opacity .3s ease;
    }
    .galeri-item:hover .galeri-overlay { opacity:1; }

    /* ── Mobile menu ── */
    #mmenu { display:none; }
    #mmenu.open { display:flex; }

    /* ── Wave divider ── */
    .wave-divider svg { display:block; }

    /* ── CTA ── */
    .cta-bg {
      background:linear-gradient(140deg,#0d1f4e 0%,#1750c0 50%,#0a6b4a 100%);
      position:relative; overflow:hidden;
    }
    .cta-bg::before {
      content:''; position:absolute; inset:0; pointer-events:none;
      background:
        radial-gradient(ellipse 500px 350px at 85% 40%,rgba(255,255,255,.06) 0%,transparent 70%),
        radial-gradient(ellipse 350px 350px at 10% 60%,rgba(16,185,129,.15) 0%,transparent 70%);
    }

    /* ── Info strip ── */
    .info-bg { background:linear-gradient(100deg,#f8fafc 0%,#eef6ff 55%,#ecfdf5 100%); }

    /* ── Agenda timeline ── */
    .agenda-dot { width:12px; height:12px; border-radius:50%; flex-shrink:0; margin-top:4px; }

    /* Tingkat badge colors */
    .tingkat-sekolah       { background:#dbeafe; color:#1d4ed8; }
    .tingkat-kecamatan     { background:#dcfce7; color:#166534; }
    .tingkat-kabupaten     { background:#fef9c3; color:#854d0e; }
    .tingkat-provinsi      { background:#fce7f3; color:#9d174d; }
    .tingkat-nasional      { background:#ede9fe; color:#6d28d9; }
    .tingkat-internasional { background:#fee2e2; color:#991b1b; }

    /* scroll reveal */
    .sr { opacity:0; transform:translateY(26px); }

    /* scrollbar */
    ::-webkit-scrollbar { width:5px; }
    ::-webkit-scrollbar-track { background:#f1f5f9; }
    ::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:99px; }

    /* Lightbox */
    #lightbox { display:none; position:fixed; inset:0; background:rgba(0,0,0,.92); z-index:1000; align-items:center; justify-content:center; }
    #lightbox.open { display:flex; }
    #lightbox img { max-width:90vw; max-height:90vh; border-radius:12px; object-fit:contain; }

    /* ── Kontak Form ── */
    .kontak-bg {
      background: linear-gradient(135deg, #f8fafc 0%, #eef6ff 50%, #ecfdf5 100%);
      position: relative;
    }
    .kontak-bg::before {
      content:''; position:absolute; inset:0; pointer-events:none;
      background-image: radial-gradient(circle, rgba(31,99,219,.04) 1px, transparent 1px);
      background-size: 32px 32px;
    }
    .form-input {
      width: 100%;
      padding: 0.625rem 0.875rem;
      border-radius: 0.75rem;
      border: 1.5px solid #e2e8f0;
      background: #fff;
      font-size: 0.875rem;
      color: #1e293b;
      font-family: 'DM Sans', sans-serif;
      transition: border-color .18s ease, box-shadow .18s ease;
      outline: none;
    }
    .form-input:focus {
      border-color: #3582f0;
      box-shadow: 0 0 0 3px rgba(53,130,240,.12);
    }
    .form-input.error {
      border-color: #ef4444;
      box-shadow: 0 0 0 3px rgba(239,68,68,.1);
    }
    .form-label {
      display: block;
      font-size: 0.75rem;
      font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: #475569;
      margin-bottom: 0.375rem;
      letter-spacing: .02em;
    }
    .form-error {
      font-size: 0.7rem;
      color: #ef4444;
      margin-top: 0.25rem;
      font-weight: 600;
    }
  </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

{{-- ═══════ NAVBAR ═══════ --}}
<header id="nav" class="fixed inset-x-0 top-0 z-50 transition-all duration-300">
  <div class="max-w-7xl mx-auto px-5 h-16 flex items-center justify-between gap-4">

    {{-- Brand --}}
    <a href="{{ url('/') }}" class="flex items-center gap-2.5 shrink-0">
      <div class="nring w-9 h-9 rounded-xl border border-white/20 bg-white/10 flex items-center justify-center transition-all duration-300 overflow-hidden">
        @if($profil->logo_path)
          <img src="{{ asset('storage/'.$profil->logo_path) }}" alt="Logo" class="w-full h-full object-contain">
        @elseif($profil->logo_url)
          <img src="{{ $profil->logo_url }}" alt="Logo" class="w-full h-full object-contain">
        @else
          <span class="nrtext font-display font-extrabold text-white text-sm transition-all duration-300">
            {{ substr($profil->singkatan ?? 'B', 0, 1) }}
          </span>
        @endif
      </div>
      <div>
        <p class="nbrand font-display font-bold text-white text-sm leading-none transition-all duration-300">SmartSchool</p>
        <p class="nsubb text-white/55 text-[11px] transition-all duration-300">{{ $profil->singkatan ?? 'SMK Bustanul Ulum' }}</p>
      </div>
    </a>

    {{-- Desktop links --}}
    <nav class="hidden md:flex items-center gap-0.5">
      <a href="#" class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Beranda</a>
      <a href="#jurusan" class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Jurusan</a>
      <a href="#berita" class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Berita</a>
      <a href="#prestasi" class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Prestasi</a>
      <a href="#galeri" class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Galeri</a>
      <a href="#kontak" class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Kontak</a>
    </nav>

    {{-- CTA --}}
    <a href="{{ route('login') }}" class="ncta hidden md:inline-flex items-center gap-1.5 text-sm font-semibold font-display text-white border border-white/30 hover:border-white/60 hover:bg-white/12 px-5 py-2 rounded-xl transition-all duration-200">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
      Masuk
    </a>

    {{-- Hamburger --}}
    <button class="md:hidden p-2 flex flex-col gap-1.5" onclick="toggleMenu()">
      <span class="hbar w-5 h-0.5 bg-white rounded transition-all"></span>
      <span class="hbar w-5 h-0.5 bg-white rounded transition-all"></span>
      <span class="hbar w-5 h-0.5 bg-white rounded transition-all"></span>
    </button>
  </div>

  {{-- Mobile menu --}}
  <div id="mmenu" class="flex-col md:hidden bg-brand-950/95 backdrop-blur-xl border-t border-white/10 px-5 py-4 gap-1">
    <a href="#" class="text-white/75 hover:text-white text-sm px-3 py-2.5 rounded-lg hover:bg-white/10 flex items-center transition-all">Beranda</a>
    <a href="#jurusan" onclick="toggleMenu()" class="text-white/75 hover:text-white text-sm px-3 py-2.5 rounded-lg hover:bg-white/10 flex items-center transition-all">Jurusan</a>
    <a href="#berita" onclick="toggleMenu()" class="text-white/75 hover:text-white text-sm px-3 py-2.5 rounded-lg hover:bg-white/10 flex items-center transition-all">Berita</a>
    <a href="#prestasi" onclick="toggleMenu()" class="text-white/75 hover:text-white text-sm px-3 py-2.5 rounded-lg hover:bg-white/10 flex items-center transition-all">Prestasi</a>
    <a href="#galeri" onclick="toggleMenu()" class="text-white/75 hover:text-white text-sm px-3 py-2.5 rounded-lg hover:bg-white/10 flex items-center transition-all">Galeri</a>
    <a href="#kontak" onclick="toggleMenu()" class="text-white/75 hover:text-white text-sm px-3 py-2.5 rounded-lg hover:bg-white/10 flex items-center transition-all">Kontak</a>
    <a href="{{ route('login') }}" class="mt-2 bg-brand-500 hover:bg-brand-600 text-white font-display font-semibold text-sm py-2.5 rounded-xl flex items-center justify-center gap-2 transition-all">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
      Masuk ke Sistem
    </a>
  </div>
</header>

{{-- ═══════ HERO / SLIDER ═══════ --}}
<section class="hero-bg min-h-screen flex flex-col justify-center pt-16">

  @if($sliders->count() > 0)
  {{-- Slider mode --}}
  <div class="slider-wrapper flex-1 flex flex-col justify-center" id="heroSlider">
    <div class="slider-track" id="sliderTrack">
      @foreach($sliders as $i => $slide)
      <div class="slider-slide relative z-10">

        {{-- Background image overlay --}}
        @if($slide->foto_path || $slide->foto_url)
        <div class="absolute inset-0 z-0">
          <img src="{{ $slide->foto_path ? asset('storage/'.$slide->foto_path) : $slide->foto_url }}"
               alt="{{ $slide->foto_alt ?? $slide->judul }}"
               class="w-full h-full object-cover opacity-25">
          <div class="absolute inset-0 bg-gradient-to-t from-[#0d1f4e]/80 via-transparent to-transparent"></div>
        </div>
        @endif

        <div class="max-w-4xl mx-auto px-5 py-28 relative z-10 text-center">
          <div class="animate-fade-up inline-flex items-center gap-2 glass text-white/85 text-[11px] font-display font-semibold px-4 py-2 rounded-full mb-8 tracking-wider uppercase">
            <span class="animate-live-pulse w-2 h-2 rounded-full bg-emerald-400 shrink-0"></span>
            Platform Aktif · Tahun Ajaran 2025/2026
          </div>

          <h1 class="animate-fade-up [animation-delay:.1s] font-display font-extrabold text-4xl sm:text-5xl md:text-6xl leading-[1.15] text-white mb-5">
            {{ $slide->judul }}
          </h1>

          @if($slide->subjudul)
          <p class="animate-fade-up [animation-delay:.2s] text-white/65 text-base sm:text-lg leading-relaxed mb-10 max-w-xl mx-auto">
            {{ $slide->subjudul }}
          </p>
          @endif

          <div class="animate-fade-up [animation-delay:.3s] flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 bg-white text-brand-700 font-display font-bold text-sm px-8 py-3.5 rounded-xl hover:bg-blue-50 shadow-[0_8px_40px_rgba(19,38,81,.4)] transition-all duration-200">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
              Masuk ke Sistem
            </a>
            @if($slide->tombol_url && $slide->tombol_label)
            <a href="{{ $slide->tombol_url }}" class="inline-flex items-center justify-center gap-2 glass text-white font-display font-semibold text-sm px-8 py-3.5 rounded-xl hover:bg-white/15 transition-all duration-200">
              {{ $slide->tombol_label }}
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            @else
            <a href="#jurusan" class="inline-flex items-center justify-center gap-2 glass text-white font-display font-semibold text-sm px-8 py-3.5 rounded-xl hover:bg-white/15 transition-all duration-200">
              Lihat Jurusan
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </a>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>

    {{-- Slider controls --}}
    @if($sliders->count() > 1)
    <div class="absolute bottom-28 left-1/2 -translate-x-1/2 flex items-center gap-3 z-20">
      @foreach($sliders as $i => $slide)
      <button onclick="goSlide({{ $i }})"
              class="slider-dot w-2 h-2 rounded-full bg-white/40 hover:bg-white transition-all duration-200 {{ $i === 0 ? '!bg-white !w-6' : '' }}"
              data-index="{{ $i }}"></button>
      @endforeach
    </div>
    <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 glass w-10 h-10 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
    </button>
    <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 glass w-10 h-10 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
    </button>
    @endif
  </div>

  @else
  {{-- Default hero tanpa slider --}}
  <div class="max-w-4xl mx-auto px-5 py-28 relative z-10 text-center">
    <div class="animate-fade-up inline-flex items-center gap-2 glass text-white/85 text-[11px] font-display font-semibold px-4 py-2 rounded-full mb-8 tracking-wider uppercase">
      <span class="animate-live-pulse w-2 h-2 rounded-full bg-emerald-400 shrink-0"></span>
      Platform Aktif · Tahun Ajaran 2025/2026
    </div>
    <h1 class="animate-fade-up [animation-delay:.1s] font-display font-extrabold text-4xl sm:text-5xl md:text-6xl leading-[1.15] text-white mb-5">
      Sistem Informasi Digital<br>
      <span class="text-grad">{{ $profil->nama_sekolah ?? 'SMK Bustanul Ulum' }}</span>
    </h1>
    <p class="animate-fade-up [animation-delay:.2s] text-white/60 text-base sm:text-lg leading-relaxed mb-10 max-w-xl mx-auto">
      {{ $profil->deskripsi_singkat ?? 'Satu platform terpadu untuk pembelajaran, absensi, monitoring kedisiplinan, dan komunikasi sekolah yang lebih cerdas.' }}
    </p>
    <div class="animate-fade-up [animation-delay:.3s] flex flex-col sm:flex-row gap-3 justify-center mb-16">
      <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 bg-white text-brand-700 font-display font-bold text-sm px-8 py-3.5 rounded-xl hover:bg-blue-50 shadow-[0_8px_40px_rgba(19,38,81,.4)] transition-all duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        Masuk ke Sistem
      </a>
      <a href="#jurusan" class="inline-flex items-center justify-center gap-2 glass text-white font-display font-semibold text-sm px-8 py-3.5 rounded-xl hover:bg-white/15 transition-all duration-200">
        Lihat Jurusan
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
      </a>
    </div>
  </div>
  @endif

  {{-- Stats bar --}}
  <div class="max-w-4xl mx-auto px-5 pb-8 w-full relative z-10">
    <div class="animate-fade-up [animation-delay:.45s] grid grid-cols-2 sm:grid-cols-4 glass rounded-2xl overflow-hidden divide-x divide-white/10">
      <div class="py-5 px-4 text-center">
        <p class="font-display font-extrabold text-2xl text-white">{{ $stats['jurusan'] }}</p>
        <p class="text-white/45 text-xs mt-1">Jurusan Aktif</p>
      </div>
      <div class="py-5 px-4 text-center">
        <p class="font-display font-extrabold text-2xl text-white">{{ $stats['pengguna_aktif'] }}+</p>
        <p class="text-white/45 text-xs mt-1">Pengguna Aktif</p>
      </div>
      <div class="py-5 px-4 text-center">
        <p class="font-display font-extrabold text-2xl text-white">{{ $stats['prestasi'] }}</p>
        <p class="text-white/45 text-xs mt-1">Total Prestasi</p>
      </div>
      <div class="py-5 px-4 text-center">
        <p class="font-display font-extrabold text-xl text-white">Real-time</p>
        <p class="text-white/45 text-xs mt-1">Monitoring</p>
      </div>
    </div>
  </div>

  {{-- Wave --}}
  <div class="wave-divider -mb-px">
    <svg viewBox="0 0 1440 72" xmlns="http://www.w3.org/2000/svg" class="w-full">
      <path d="M0,36 C360,72 720,0 1080,36 C1260,54 1380,24 1440,36 L1440,72 L0,72 Z" fill="#f8fafc"/>
    </svg>
  </div>
</section>

{{-- ═══════ LINK CEPAT ═══════ --}}
@if($linkCepat->count() > 0)
<section class="bg-white border-b border-slate-100 py-4">
  <div class="max-w-7xl mx-auto px-5">
    <div class="flex items-center gap-3 overflow-x-auto pb-1 scrollbar-hide">
      <span class="text-slate-400 text-xs font-semibold shrink-0">Link Cepat:</span>
      @foreach($linkCepat as $link)
      <a href="{{ $link->url }}"
         @if($link->buka_tab_baru) target="_blank" rel="noopener" @endif
         class="shrink-0 inline-flex items-center gap-1.5 text-xs font-semibold font-display px-4 py-2 rounded-lg border transition-all hover:shadow-md"
         style="{{ $link->warna ? 'border-color:'.($link->warna).'40; color:'.$link->warna.'; background:'.$link->warna.'12;' : 'border-color:#e2e8f0; color:#475569; background:#f8fafc;' }}">
        @if($link->ikon)
          <span>{{ $link->ikon }}</span>
        @endif
        {{ $link->label }}
        @if($link->buka_tab_baru)
        <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        @endif
      </a>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ═══════ JURUSAN ═══════ --}}
<section id="jurusan" class="bg-slate-50 py-24">
  <div class="max-w-7xl mx-auto px-5">

    <div class="text-center mb-14 sr">
      <span class="section-label text-brand-600 bg-brand-50 border border-brand-100 px-4 py-1.5 rounded-full mb-4 inline-block">Program Keahlian</span>
      <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-slate-900 mb-3">Jurusan Unggulan</h2>
      <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">Pilih program keahlian yang sesuai dengan minat dan bakatmu untuk masa depan yang cerah.</p>
    </div>

    @if($jurusan->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($jurusan as $j)
      <div class="fcard sr bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-[0_1px_3px_rgba(0,0,0,.05),0_4px_16px_rgba(0,0,0,.06)]">

        {{-- Cover Image --}}
        <div class="relative h-44 bg-gradient-to-br from-brand-700 to-brand-900 overflow-hidden">
          @if($j->foto_cover_path)
            <img src="{{ asset('storage/'.$j->foto_cover_path) }}" alt="{{ $j->nama }}" class="w-full h-full object-cover opacity-80">
          @elseif($j->foto_cover_url)
            <img src="{{ $j->foto_cover_url }}" alt="{{ $j->nama }}" class="w-full h-full object-cover opacity-80">
          @else
            <div class="absolute inset-0 flex items-center justify-center">
              <svg class="w-20 h-20 text-white/20" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
              </svg>
            </div>
          @endif
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

          @if($j->is_penerimaan_buka)
          <div class="absolute top-3 right-3 inline-flex items-center gap-1.5 bg-emerald-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full">
            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
            Penerimaan Buka
          </div>
          @endif

          @if($j->akreditasi)
          <div class="absolute top-3 left-3 glass text-white text-[10px] font-bold px-2.5 py-1 rounded-full">
            Akreditasi {{ $j->akreditasi }}
          </div>
          @endif

          <div class="absolute bottom-3 left-4 flex items-center gap-2">
            @if($j->logo_path || $j->logo_url)
            <div class="w-10 h-10 rounded-xl bg-white border-2 border-white/50 overflow-hidden shadow-lg">
              <img src="{{ $j->logo_path ? asset('storage/'.$j->logo_path) : $j->logo_url }}"
                   alt="Logo {{ $j->singkatan }}" class="w-full h-full object-contain">
            </div>
            @endif
            <div>
              <p class="text-white font-display font-bold text-sm leading-none">{{ $j->singkatan }}</p>
              @if($j->kode_jurusan)
              <p class="text-white/60 text-[10px]">{{ $j->kode_jurusan }}</p>
              @endif
            </div>
          </div>
        </div>

        {{-- Content --}}
        <div class="p-5">
          <h3 class="font-display font-bold text-slate-900 text-base mb-1.5">{{ $j->nama }}</h3>

          @if($j->deskripsi_singkat)
          <p class="text-slate-500 text-sm leading-relaxed mb-4 line-clamp-2">{{ $j->deskripsi_singkat }}</p>
          @endif

          <div class="grid grid-cols-3 gap-2 mb-4">
            @if($j->lama_belajar)
            <div class="bg-slate-50 rounded-xl p-2.5 text-center">
              <p class="font-display font-extrabold text-slate-800 text-sm">{{ $j->lama_belajar }} Th</p>
              <p class="text-slate-400 text-[10px]">Lama Belajar</p>
            </div>
            @endif
            @if($j->kapasitas_per_kelas)
            <div class="bg-slate-50 rounded-xl p-2.5 text-center">
              <p class="font-display font-extrabold text-slate-800 text-sm">{{ $j->kapasitas_per_kelas }}</p>
              <p class="text-slate-400 text-[10px]">Kapasitas</p>
            </div>
            @endif
            @if($j->jumlah_kelas_aktif)
            <div class="bg-slate-50 rounded-xl p-2.5 text-center">
              <p class="font-display font-extrabold text-slate-800 text-sm">{{ $j->jumlah_kelas_aktif }}</p>
              <p class="text-slate-400 text-[10px]">Kelas Aktif</p>
            </div>
            @endif
          </div>

          @if($j->kompetensi->count() > 0)
          <div class="flex flex-wrap gap-1.5 mb-4">
            @foreach($j->kompetensi->take(3) as $k)
            <span class="rpill bg-brand-50 text-brand-700 border border-brand-100">{{ $k->nama_kompetensi }}</span>
            @endforeach
            @if($j->kompetensi->count() > 3)
            <span class="rpill bg-slate-100 text-slate-500 border border-slate-200">+{{ $j->kompetensi->count() - 3 }}</span>
            @endif
          </div>
          @endif

          @if($j->prospekKerja->count() > 0)
          <div class="border-t border-slate-100 pt-3 mb-4">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Prospek Kerja</p>
            <div class="flex flex-wrap gap-1">
              @foreach($j->prospekKerja->take(3) as $p)
              <span class="text-[10px] bg-emerald-50 text-emerald-700 border border-emerald-100 px-2 py-0.5 rounded-full font-semibold">{{ $p->jabatan }}</span>
              @endforeach
            </div>
          </div>
          @endif

          @if($j->nama_kajur)
          <div class="flex items-center gap-2 pt-3 border-t border-slate-100">
            @if($j->foto_kajur_path || $j->foto_kajur_url)
            <img src="{{ $j->foto_kajur_path ? asset('storage/'.$j->foto_kajur_path) : $j->foto_kajur_url }}"
                 alt="{{ $j->nama_kajur }}" class="w-7 h-7 rounded-full object-cover border border-slate-200">
            @else
            <div class="w-7 h-7 rounded-full bg-brand-100 flex items-center justify-center text-[10px] font-bold text-brand-700">
              {{ substr($j->nama_kajur, 0, 1) }}
            </div>
            @endif
            <div>
              <p class="text-[10px] text-slate-400">Kepala Jurusan</p>
              <p class="text-xs font-semibold text-slate-700">{{ $j->nama_kajur }}</p>
            </div>
          </div>
          @endif
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div class="text-center py-16 text-slate-400">
      <svg class="w-16 h-16 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
      <p class="text-sm">Belum ada jurusan yang dipublikasikan.</p>
    </div>
    @endif
  </div>
</section>

{{-- ═══════ BERITA ═══════ --}}
@if($beritaFeatured || $berita->count() > 0)
<section id="berita" class="bg-white py-24">
  <div class="max-w-7xl mx-auto px-5">

    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12 sr">
      <div>
        <span class="section-label text-emerald-700 bg-emerald-50 border border-emerald-100 px-4 py-1.5 rounded-full mb-3 inline-block">Berita & Informasi</span>
        <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-slate-900">Kabar Terbaru</h2>
      </div>
      <a href="#" class="inline-flex items-center gap-1.5 text-brand-600 font-display font-semibold text-sm hover:gap-2.5 transition-all">
        Semua Berita <span class="arrow">→</span>
      </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- Featured berita --}}
      @if($beritaFeatured)
      <a href="#" class="lg:col-span-1 news-card group block bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm sr">
        <div class="relative h-64 overflow-hidden bg-slate-100">
          @if($beritaFeatured->thumbnail_path)
            <img src="{{ asset('storage/'.$beritaFeatured->thumbnail_path) }}" alt="{{ $beritaFeatured->thumbnail_alt ?? $beritaFeatured->judul }}" class="news-img w-full h-full object-cover">
          @elseif($beritaFeatured->thumbnail_url)
            <img src="{{ $beritaFeatured->thumbnail_url }}" alt="{{ $beritaFeatured->judul }}" class="news-img w-full h-full object-cover">
          @else
            <div class="flex items-center justify-center h-full bg-gradient-to-br from-brand-100 to-brand-200">
              <svg class="w-16 h-16 text-brand-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </div>
          @endif
          <div class="absolute top-3 left-3">
            <span class="rpill bg-white text-brand-700">⭐ Unggulan</span>
          </div>
        </div>
        <div class="p-5">
          @if($beritaFeatured->kategori)
          <span class="rpill mb-3 inline-block" style="background:{{ $beritaFeatured->kategori->warna ?? '#dbeafe' }}22; color:{{ $beritaFeatured->kategori->warna ?? '#1d4ed8' }}; border:1px solid {{ $beritaFeatured->kategori->warna ?? '#dbeafe' }};">
            {{ $beritaFeatured->kategori->nama }}
          </span>
          @endif
          <h3 class="font-display font-bold text-slate-900 text-lg mb-2 line-clamp-2 group-hover:text-brand-700 transition-colors">{{ $beritaFeatured->judul }}</h3>
          @if($beritaFeatured->ringkasan)
          <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 mb-4">{{ $beritaFeatured->ringkasan }}</p>
          @endif
          <div class="flex items-center gap-3 text-slate-400 text-xs">
            <span>{{ $beritaFeatured->nama_penulis ?? 'Tim Redaksi' }}</span>
            <span>·</span>
            <span>{{ $beritaFeatured->published_at?->diffForHumans() ?? '-' }}</span>
          </div>
        </div>
      </a>
      @endif

      {{-- Berita grid --}}
      @if($berita->count() > 0)
      <div class="{{ $beritaFeatured ? 'lg:col-span-2' : 'lg:col-span-3' }} grid grid-cols-1 sm:grid-cols-2 gap-5">
        @foreach($berita as $b)
        <a href="#" class="news-card group block bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm sr">
          <div class="relative h-36 overflow-hidden bg-slate-100">
            @if($b->thumbnail_path)
              <img src="{{ asset('storage/'.$b->thumbnail_path) }}" alt="{{ $b->judul }}" class="news-img w-full h-full object-cover">
            @elseif($b->thumbnail_url)
              <img src="{{ $b->thumbnail_url }}" alt="{{ $b->judul }}" class="news-img w-full h-full object-cover">
            @else
              <div class="flex items-center justify-center h-full bg-gradient-to-br from-slate-100 to-slate-200">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
              </div>
            @endif
          </div>
          <div class="p-4">
            @if($b->kategori)
            <span class="rpill mb-2 inline-block" style="background:{{ $b->kategori->warna ?? '#dbeafe' }}22; color:{{ $b->kategori->warna ?? '#1d4ed8' }}; border:1px solid {{ $b->kategori->warna ?? '#dbeafe' }};">
              {{ $b->kategori->nama }}
            </span>
            @endif
            <h4 class="font-display font-bold text-slate-800 text-sm leading-snug mb-2 line-clamp-2 group-hover:text-brand-700 transition-colors">{{ $b->judul }}</h4>
            <p class="text-slate-400 text-xs">{{ $b->published_at?->diffForHumans() ?? '-' }}</p>
          </div>
        </a>
        @endforeach
      </div>
      @endif
    </div>
  </div>
</section>
@endif

{{-- ═══════ AGENDA + PRESTASI ROW ═══════ --}}
<section class="info-bg border-y border-slate-200 py-20">
  <div class="max-w-7xl mx-auto px-5 grid grid-cols-1 lg:grid-cols-2 gap-12">

    {{-- Agenda --}}
    <div>
      <div class="mb-8 sr">
        <span class="section-label text-violet-700 bg-violet-50 border border-violet-100 px-4 py-1.5 rounded-full mb-3 inline-block">Kalender Kegiatan</span>
        <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900">Agenda Mendatang</h2>
      </div>

      @if($agenda->count() > 0)
      <div class="space-y-4">
        @foreach($agenda as $ag)
        @php
          $tipeColor = [
            'akademik' => ['bg'=>'#dbeafe','text'=>'#1d4ed8'],
            'olahraga' => ['bg'=>'#dcfce7','text'=>'#166534'],
            'seni'     => ['bg'=>'#fce7f3','text'=>'#9d174d'],
            'rapat'    => ['bg'=>'#fef9c3','text'=>'#854d0e'],
            'libur'    => ['bg'=>'#fee2e2','text'=>'#991b1b'],
            'ujian'    => ['bg'=>'#ede9fe','text'=>'#6d28d9'],
            'lainnya'  => ['bg'=>'#f1f5f9','text'=>'#475569'],
          ][$ag->tipe ?? 'lainnya'] ?? ['bg'=>'#f1f5f9','text'=>'#475569'];
        @endphp
        <div class="sr flex items-start gap-4 bg-white rounded-xl p-4 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
          <div class="shrink-0 w-14 h-14 rounded-xl flex flex-col items-center justify-center text-center"
               style="background:{{ $ag->warna ?? '#1f63db' }}18; border: 1.5px solid {{ $ag->warna ?? '#1f63db' }}30;">
            <p class="font-display font-extrabold text-lg leading-none" style="color:{{ $ag->warna ?? '#1f63db' }}">
              {{ \Carbon\Carbon::parse($ag->tanggal_mulai)->format('d') }}
            </p>
            <p class="text-[10px] font-bold uppercase" style="color:{{ $ag->warna ?? '#1f63db' }}; opacity:0.7;">
              {{ \Carbon\Carbon::parse($ag->tanggal_mulai)->locale('id')->isoFormat('MMM') }}
            </p>
          </div>

          <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between gap-2">
              <h4 class="font-display font-bold text-slate-800 text-sm leading-snug">{{ $ag->judul }}</h4>
              @if($ag->tipe)
              <span class="rpill shrink-0" style="background:{{ $tipeColor['bg'] }}; color:{{ $tipeColor['text'] }}; border:1px solid {{ $tipeColor['bg'] }};">
                {{ ucfirst($ag->tipe) }}
              </span>
              @endif
            </div>

            @if($ag->deskripsi)
            <p class="text-slate-500 text-xs leading-relaxed mt-1 line-clamp-2">{{ $ag->deskripsi }}</p>
            @endif

            <div class="flex items-center gap-3 mt-2 text-slate-400 text-[11px]">
              @if($ag->jam_mulai)
              <span class="flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ \Carbon\Carbon::parse($ag->jam_mulai)->format('H:i') }}
                @if($ag->jam_selesai) – {{ \Carbon\Carbon::parse($ag->jam_selesai)->format('H:i') }} @endif
              </span>
              @endif
              @if($ag->lokasi)
              <span class="flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                {{ $ag->lokasi }}
              </span>
              @endif
              @if($ag->tanggal_selesai && $ag->tanggal_selesai != $ag->tanggal_mulai)
              <span>s/d {{ \Carbon\Carbon::parse($ag->tanggal_selesai)->locale('id')->isoFormat('D MMM') }}</span>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @else
      <div class="bg-white rounded-xl border border-dashed border-slate-200 p-10 text-center text-slate-400">
        <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        <p class="text-sm">Belum ada agenda mendatang.</p>
      </div>
      @endif
    </div>

    {{-- Prestasi --}}
    <div id="prestasi">
      <div class="mb-8 sr">
        <span class="section-label text-amber-700 bg-amber-50 border border-amber-100 px-4 py-1.5 rounded-full mb-3 inline-block">Capaian & Penghargaan</span>
        <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900">Prestasi Terbaik</h2>
      </div>

      <div class="grid grid-cols-2 gap-3 mb-6 sr">
        <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm text-center">
          <p class="font-display font-extrabold text-3xl text-amber-500">{{ $stats['prestasi'] }}</p>
          <p class="text-slate-500 text-xs mt-1">Total Prestasi</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm text-center">
          <p class="font-display font-extrabold text-3xl text-violet-500">{{ $stats['prestasi_nasional'] }}</p>
          <p class="text-slate-500 text-xs mt-1">Tingkat Nasional/Internasional</p>
        </div>
      </div>

      @if($prestasi->count() > 0)
      <div class="space-y-3">
        @foreach($prestasi as $p)
        @php
          $tingkatClass = [
            'sekolah'       => 'tingkat-sekolah',
            'kecamatan'     => 'tingkat-kecamatan',
            'kabupaten'     => 'tingkat-kabupaten',
            'provinsi'      => 'tingkat-provinsi',
            'nasional'      => 'tingkat-nasional',
            'internasional' => 'tingkat-internasional',
          ][$p->tingkat] ?? 'tingkat-lainnya';
          $tingkatIcon = [
            'sekolah'=>'🏫','kecamatan'=>'🏡','kabupaten'=>'🏛️',
            'provinsi'=>'🗺️','nasional'=>'🏆','internasional'=>'🌍',
          ][$p->tingkat] ?? '🎖️';
        @endphp
        <div class="sr flex items-center gap-4 bg-white rounded-xl p-4 border border-slate-100 shadow-sm">
          <div class="shrink-0 w-12 h-12 rounded-xl overflow-hidden bg-amber-50 border border-amber-100 flex items-center justify-center text-2xl">
            @if($p->foto_path)
              <img src="{{ asset('storage/'.$p->foto_path) }}" alt="{{ $p->judul }}" class="w-full h-full object-cover">
            @elseif($p->foto_url)
              <img src="{{ $p->foto_url }}" alt="{{ $p->judul }}" class="w-full h-full object-cover">
            @else
              {{ $tingkatIcon }}
            @endif
          </div>

          <div class="flex-1 min-w-0">
            <div class="flex items-start gap-2">
              <div class="flex-1">
                <h4 class="font-display font-bold text-slate-800 text-sm leading-snug line-clamp-1">{{ $p->judul }}</h4>
                @if($p->nama_event)
                <p class="text-slate-500 text-xs">{{ $p->nama_event }}</p>
                @endif
              </div>
              <div class="shrink-0 flex flex-col items-end gap-1">
                <span class="prestasi-badge {{ $tingkatClass }}">{{ ucfirst($p->tingkat) }}</span>
                @if($p->peringkat)
                <span class="text-[10px] font-bold text-amber-600">{{ $p->peringkat }}</span>
                @endif
              </div>
            </div>
            <div class="flex items-center gap-2 mt-1.5 text-slate-400 text-[11px]">
              @if($p->nama_penerima)
              <span>{{ $p->nama_penerima }}</span>
              @endif
              @if($p->tahun)
              <span>· {{ $p->tahun }}</span>
              @endif
              @if($p->jurusan)
              <span class="rpill bg-brand-50 text-brand-700 border border-brand-100">{{ $p->jurusan->singkatan }}</span>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @else
      <div class="bg-white rounded-xl border border-dashed border-slate-200 p-10 text-center text-slate-400">
        <p class="text-sm">Belum ada prestasi yang ditampilkan.</p>
      </div>
      @endif
    </div>
  </div>
</section>

{{-- ═══════ GALERI ═══════ --}}
@if($galeri->count() > 0)
<section id="galeri" class="bg-slate-50 py-24">
  <div class="max-w-7xl mx-auto px-5">

    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12 sr">
      <div>
        <span class="section-label text-pink-700 bg-pink-50 border border-pink-100 px-4 py-1.5 rounded-full mb-3 inline-block">Dokumentasi</span>
        <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-slate-900">Galeri Foto</h2>
      </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-3">
      @foreach($galeri as $i => $foto)
      @php
        $heights = ['h-80','h-36','h-36','h-36','h-36','h-36'];
        $h = $heights[$i % 6] ?? 'h-40';
      @endphp
      <div class="galeri-item sr relative {{ $h }} {{ $i % 6 === 0 ? 'lg:col-span-2 lg:row-span-2 lg:h-full' : '' }}"
           onclick="openLightbox('{{ $foto->foto_path ? asset('storage/'.$foto->foto_path) : $foto->foto_url }}', '{{ addslashes($foto->judul) }}')">
        @if($foto->foto_path)
          <img src="{{ asset('storage/'.$foto->foto_path) }}" alt="{{ $foto->alt_text ?? $foto->judul }}" class="w-full h-full object-cover">
        @elseif($foto->foto_url)
          <img src="{{ $foto->foto_url }}" alt="{{ $foto->judul }}" class="w-full h-full object-cover">
        @else
          <div class="w-full h-full bg-slate-200 flex items-center justify-center">
            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          </div>
        @endif
        <div class="galeri-overlay rounded-xl">
          <div class="absolute bottom-0 left-0 right-0 p-3">
            <p class="text-white text-xs font-semibold line-clamp-1">{{ $foto->judul }}</p>
            @if($foto->kategori)
            <p class="text-white/60 text-[10px]">{{ $foto->kategori->nama }}</p>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ═══════ VISI MISI + PROFIL ═══════ --}}
@if($profil->visi || $profil->misi || $profil->sambutan_kepsek)
<section class="bg-white py-24">
  <div class="max-w-7xl mx-auto px-5">

    <div class="text-center mb-14 sr">
      <span class="section-label text-brand-600 bg-brand-50 border border-brand-100 px-4 py-1.5 rounded-full mb-4 inline-block">Tentang Kami</span>
      <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-slate-900 mb-3">Profil Sekolah</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

      @if($profil->visi)
      <div class="sr bg-gradient-to-br from-brand-50 to-blue-50 rounded-2xl p-6 border border-brand-100">
        <div class="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center mb-4">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        </div>
        <h3 class="font-display font-bold text-slate-900 text-lg mb-3">Visi</h3>
        <p class="text-slate-600 text-sm leading-relaxed">{{ $profil->visi }}</p>
      </div>
      @endif

      @if($profil->misi)
      <div class="sr bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-6 border border-emerald-100">
        <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center mb-4">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <h3 class="font-display font-bold text-slate-900 text-lg mb-3">Misi</h3>
        <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $profil->misi }}</p>
      </div>
      @endif

      @if($profil->sambutan_kepsek || $profil->nama_kepsek)
      <div class="sr bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 border border-amber-100">
        <div class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center mb-4">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
        @if($profil->nama_kepsek)
        <div class="flex items-center gap-3 mb-4">
          @if($profil->foto_kepsek_path || $profil->foto_kepsek_url)
          <img src="{{ $profil->foto_kepsek_path ? asset('storage/'.$profil->foto_kepsek_path) : $profil->foto_kepsek_url }}"
               alt="{{ $profil->nama_kepsek }}" class="w-12 h-12 rounded-full object-cover border-2 border-amber-200">
          @else
          <div class="w-12 h-12 rounded-full bg-amber-200 flex items-center justify-center text-amber-700 font-bold text-lg">
            {{ substr($profil->nama_kepsek, 0, 1) }}
          </div>
          @endif
          <div>
            <p class="font-display font-bold text-slate-800 text-sm">{{ $profil->nama_kepsek }}</p>
            @if($profil->nip_kepsek)
            <p class="text-slate-500 text-xs">NIP: {{ $profil->nip_kepsek }}</p>
            @endif
            <p class="text-amber-700 text-xs font-semibold">Kepala Sekolah</p>
          </div>
        </div>
        @endif
        @if($profil->sambutan_kepsek)
        <h3 class="font-display font-bold text-slate-900 text-sm mb-2">Sambutan</h3>
        <p class="text-slate-600 text-sm leading-relaxed line-clamp-5">{{ $profil->sambutan_kepsek }}</p>
        @endif
      </div>
      @endif
    </div>
  </div>
</section>
@endif

{{-- ═══════ KEUNGGULAN ═══════ --}}
<section class="info-bg border-y border-slate-200 py-20">
  <div class="max-w-7xl mx-auto px-5">
    <div class="text-center mb-12 sr">
      <span class="section-label text-slate-600 bg-white border border-slate-200 px-4 py-1.5 rounded-full mb-4 inline-block">Mengapa SmartSchool?</span>
      <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900">Platform yang Andal & Terpercaya</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="sr flex items-start gap-4 bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-brand-50 border border-brand-100 flex items-center justify-center shrink-0">
          <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <div>
          <h4 class="font-display font-bold text-slate-900 text-sm mb-1">Aman & Terenkripsi</h4>
          <p class="text-slate-500 text-xs leading-relaxed">Autentikasi berlapis dengan role-based access control untuk setiap pengguna.</p>
        </div>
      </div>

      <div class="sr flex items-start gap-4 bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center shrink-0">
          <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
        </div>
        <div>
          <h4 class="font-display font-bold text-slate-900 text-sm mb-1">Responsive & Mobile</h4>
          <p class="text-slate-500 text-xs leading-relaxed">Diakses dari komputer maupun smartphone dengan tampilan optimal di semua layar.</p>
        </div>
      </div>

      <div class="sr flex items-start gap-4 bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-violet-50 border border-violet-100 flex items-center justify-center shrink-0">
          <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </div>
        <div>
          <h4 class="font-display font-bold text-slate-900 text-sm mb-1">Real-time Monitoring</h4>
          <p class="text-slate-500 text-xs leading-relaxed">Data kehadiran, nilai, dan pelanggaran tersaji secara langsung tanpa jeda waktu.</p>
        </div>
      </div>

      <div class="sr flex items-start gap-4 bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center shrink-0">
          <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
        </div>
        <div>
          <h4 class="font-display font-bold text-slate-900 text-sm mb-1">Backup Otomatis</h4>
          <p class="text-slate-500 text-xs leading-relaxed">Data tersimpan aman dengan mekanisme backup berkala yang konsisten dan terjamin.</p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ═══════ CTA ═══════ --}}
<section class="cta-bg py-24">
  <div class="max-w-2xl mx-auto px-5 text-center relative z-10">
    <span class="inline-block text-emerald-300 text-[11px] font-display font-bold tracking-widest uppercase glass px-4 py-1.5 rounded-full mb-6">Mulai Sekarang</span>
    <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-white mb-4 leading-tight">
      Siap memulai era digital<br>{{ $profil->singkatan ?? 'SMK Bustanul Ulum' }}?
    </h2>
    <p class="text-white/60 text-sm mb-10 leading-relaxed">Masuk menggunakan akun yang telah disiapkan oleh administrator sekolah Anda.</p>
    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-white text-brand-700 font-display font-bold text-sm px-10 py-4 rounded-xl shadow-[0_8px_40px_rgba(19,38,81,.4)] hover:bg-blue-50 hover:shadow-[0_0_40px_rgba(53,130,240,.3)] transition-all duration-200">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
      Masuk ke Sistem
    </a>
  </div>
</section>

{{-- ═══════ KONTAK ═══════ --}}
<section id="kontak" class="kontak-bg py-24 relative overflow-hidden">
  <div class="max-w-7xl mx-auto px-5 relative z-10">

    <div class="text-center mb-14 sr">
      <span class="section-label text-brand-600 bg-brand-50 border border-brand-100 px-4 py-1.5 rounded-full mb-4 inline-block">Hubungi Kami</span>
      <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-slate-900 mb-3">Ada yang Ingin Ditanyakan?</h2>
      <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">Kirimkan pesan Anda dan tim kami akan segera merespons dalam waktu 1×24 jam.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 items-start">

      {{-- Info Kontak --}}
      <div class="lg:col-span-2 space-y-5 sr">

        {{-- Alert sukses --}}
        @if(session('kontak_success'))
        <div class="flex items-start gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-4">
          <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <div>
            <p class="font-display font-bold text-sm">Pesan Terkirim!</p>
            <p class="text-xs mt-0.5 text-emerald-700">{{ session('kontak_success') }}</p>
          </div>
        </div>
        @endif

        {{-- Info cards --}}
        @if($profil->alamat_lengkap)
        <div class="flex items-start gap-4 bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
          <div class="w-10 h-10 rounded-xl bg-brand-50 border border-brand-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          </div>
          <div>
            <p class="font-display font-bold text-slate-800 text-sm mb-1">Alamat</p>
            <p class="text-slate-500 text-xs leading-relaxed">{{ $profil->alamat_lengkap }}{{ $profil->kabupaten_kota ? ', '.$profil->kabupaten_kota : '' }}</p>
          </div>
        </div>
        @endif

        @if($profil->telepon || $profil->whatsapp)
        <div class="flex items-start gap-4 bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
          <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.18H6.6a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.91a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.73 16.92z"/></svg>
          </div>
          <div>
            <p class="font-display font-bold text-slate-800 text-sm mb-1">Telepon / WhatsApp</p>
            @if($profil->telepon)
            <a href="tel:{{ $profil->telepon }}" class="text-slate-500 text-xs hover:text-brand-600 transition-colors block">{{ $profil->telepon }}</a>
            @endif
            @if($profil->whatsapp)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$profil->whatsapp) }}" target="_blank"
               class="inline-flex items-center gap-1 text-xs text-emerald-600 font-semibold hover:text-emerald-700 transition-colors mt-1">
              <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
              Chat WhatsApp
            </a>
            @endif
          </div>
        </div>
        @endif

        @if($profil->email_sekolah)
        <div class="flex items-start gap-4 bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
          <div class="w-10 h-10 rounded-xl bg-violet-50 border border-violet-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </div>
          <div>
            <p class="font-display font-bold text-slate-800 text-sm mb-1">Email</p>
            <a href="mailto:{{ $profil->email_sekolah }}" class="text-slate-500 text-xs hover:text-brand-600 transition-colors">{{ $profil->email_sekolah }}</a>
          </div>
        </div>
        @endif

        {{-- Jam operasional --}}
        <div class="flex items-start gap-4 bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
          <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
          <div>
            <p class="font-display font-bold text-slate-800 text-sm mb-1">Jam Operasional</p>
            <p class="text-slate-500 text-xs">Senin – Sabtu: 07.00 – 16.00 WIB</p>
            <p class="text-slate-400 text-xs mt-0.5">Minggu & Libur Nasional: Tutup</p>
          </div>
        </div>
      </div>

      {{-- Form Kontak --}}
      <div class="lg:col-span-3 sr">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
          <h3 class="font-display font-bold text-slate-900 text-lg mb-6">Kirim Pesan</h3>

          @if($errors->any())
          <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-6">
            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>
              <p class="font-display font-bold text-sm">Mohon perbaiki kesalahan berikut:</p>
              <ul class="mt-1 space-y-0.5">
                @foreach($errors->all() as $error)
                <li class="text-xs">• {{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
          @endif

          <form action="{{ route('kontak.kirim') }}" method="POST" class="space-y-5" id="kontakForm">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              {{-- Nama --}}
              <div>
                <label class="form-label" for="nama_pengirim">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text"
                       id="nama_pengirim"
                       name="nama_pengirim"
                       value="{{ old('nama_pengirim') }}"
                       placeholder="Nama Anda"
                       class="form-input {{ $errors->has('nama_pengirim') ? 'error' : '' }}"
                       required>
                @error('nama_pengirim')
                <p class="form-error">{{ $message }}</p>
                @enderror
              </div>

              {{-- Email --}}
              <div>
                <label class="form-label" for="email_pengirim">Alamat Email <span class="text-red-500">*</span></label>
                <input type="email"
                       id="email_pengirim"
                       name="email_pengirim"
                       value="{{ old('email_pengirim') }}"
                       placeholder="email@contoh.com"
                       class="form-input {{ $errors->has('email_pengirim') ? 'error' : '' }}"
                       required>
                @error('email_pengirim')
                <p class="form-error">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              {{-- No. Telepon --}}
              <div>
                <label class="form-label" for="no_telepon">No. Telepon <span class="text-slate-400 font-normal normal-case tracking-normal">(opsional)</span></label>
                <input type="tel"
                       id="no_telepon"
                       name="no_telepon"
                       value="{{ old('no_telepon') }}"
                       placeholder="08xxxxxxxxxx"
                       class="form-input {{ $errors->has('no_telepon') ? 'error' : '' }}">
                @error('no_telepon')
                <p class="form-error">{{ $message }}</p>
                @enderror
              </div>

              {{-- Subjek --}}
              <div>
                <label class="form-label" for="subjek">Subjek <span class="text-red-500">*</span></label>
                <input type="text"
                       id="subjek"
                       name="subjek"
                       value="{{ old('subjek') }}"
                       placeholder="Topik pesan Anda"
                       class="form-input {{ $errors->has('subjek') ? 'error' : '' }}"
                       required>
                @error('subjek')
                <p class="form-error">{{ $message }}</p>
                @enderror
              </div>
            </div>

            {{-- Pesan --}}
            <div>
              <label class="form-label" for="pesan">Pesan <span class="text-red-500">*</span></label>
              <textarea id="pesan"
                        name="pesan"
                        rows="5"
                        placeholder="Tuliskan pesan atau pertanyaan Anda di sini..."
                        class="form-input resize-none {{ $errors->has('pesan') ? 'error' : '' }}"
                        required>{{ old('pesan') }}</textarea>
              @error('pesan')
              <p class="form-error">{{ $message }}</p>
              @enderror
              <p class="text-slate-400 text-[11px] mt-1.5" id="pesanCount">0 / 3000 karakter</p>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-between pt-1">
              <p class="text-slate-400 text-xs">
                <span class="text-red-400">*</span> Wajib diisi
              </p>
              <button type="submit"
                      id="submitBtn"
                      class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 active:bg-brand-800 text-white font-display font-bold text-sm px-7 py-3 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md disabled:opacity-60 disabled:cursor-not-allowed">
                <svg class="w-4 h-4" id="submitIcon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                <svg class="w-4 h-4 animate-spin hidden" id="submitSpinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                <span id="submitLabel">Kirim Pesan</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    {{-- Maps embed --}}
    @if($profil->embed_maps_url)
    <div class="mt-12 sr rounded-2xl overflow-hidden border border-slate-200 shadow-sm" style="height:280px">
      <iframe src="{{ $profil->embed_maps_url }}" width="100%" height="280" style="border:0" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    @endif

  </div>
</section>

{{-- ═══════ FOOTER ═══════ --}}
<footer class="bg-slate-900 text-white">
  <div class="max-w-7xl mx-auto px-5 py-16">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-10">

      <div class="md:col-span-2">
        <div class="flex items-center gap-2.5 mb-5">
          <div class="w-10 h-10 rounded-xl bg-brand-700 flex items-center justify-center overflow-hidden">
            @if($profil->logo_path)
              <img src="{{ asset('storage/'.$profil->logo_path) }}" alt="Logo" class="w-full h-full object-contain">
            @else
              <span class="font-display font-extrabold text-white text-sm">{{ substr($profil->singkatan ?? 'B', 0, 1) }}</span>
            @endif
          </div>
          <div>
            <p class="font-display font-bold text-white text-sm leading-none">SmartSchool</p>
            <p class="text-slate-500 text-xs">{{ $profil->nama_sekolah ?? 'SMK Bustanul Ulum' }}</p>
          </div>
        </div>
        <p class="text-slate-400 text-sm leading-relaxed mb-5 max-w-sm">
          {{ $profil->deskripsi_singkat ?? 'Platform informasi manajemen sekolah berbasis web yang dikembangkan untuk mendukung pendidikan digital.' }}
        </p>

        <div class="flex items-center gap-3">
          @if($profil->instagram_url)
          <a href="{{ $profil->instagram_url }}" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-pink-600 flex items-center justify-center transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
          </a>
          @endif
          @if($profil->facebook_url)
          <a href="{{ $profil->facebook_url }}" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-blue-600 flex items-center justify-center transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          </a>
          @endif
          @if($profil->youtube_url)
          <a href="{{ $profil->youtube_url }}" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-red-600 flex items-center justify-center transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
          </a>
          @endif
          @if($profil->twitter_url)
          <a href="{{ $profil->twitter_url }}" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-sky-500 flex items-center justify-center transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          </a>
          @endif
          @if($profil->tiktok_url)
          <a href="{{ $profil->tiktok_url }}" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-slate-600 flex items-center justify-center transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
          </a>
          @endif
        </div>
      </div>

      <div>
        <h4 class="font-display font-bold text-white text-sm mb-4">Navigasi</h4>
        <ul class="space-y-2.5">
          <li><a href="#" class="text-slate-400 hover:text-white text-sm transition-colors">Beranda</a></li>
          <li><a href="#jurusan" class="text-slate-400 hover:text-white text-sm transition-colors">Jurusan</a></li>
          <li><a href="#berita" class="text-slate-400 hover:text-white text-sm transition-colors">Berita</a></li>
          <li><a href="#prestasi" class="text-slate-400 hover:text-white text-sm transition-colors">Prestasi</a></li>
          <li><a href="#galeri" class="text-slate-400 hover:text-white text-sm transition-colors">Galeri</a></li>
          <li><a href="#kontak" class="text-slate-400 hover:text-white text-sm transition-colors">Kontak</a></li>
          <li><a href="{{ route('login') }}" class="text-slate-400 hover:text-white text-sm transition-colors">Masuk</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-display font-bold text-white text-sm mb-4">Kontak & Info</h4>
        <ul class="space-y-3">
          @if($profil->alamat_lengkap)
          <li class="flex items-start gap-2 text-slate-400 text-sm">
            <svg class="w-4 h-4 shrink-0 text-slate-600 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            {{ $profil->alamat_lengkap }}{{ $profil->kabupaten_kota ? ', '.$profil->kabupaten_kota : '' }}
          </li>
          @endif
          @if($profil->telepon)
          <li class="flex items-center gap-2 text-slate-400 text-sm">
            <svg class="w-4 h-4 shrink-0 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.18H6.6a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.91a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.73 16.92z"/></svg>
            <a href="tel:{{ $profil->telepon }}" class="hover:text-white transition-colors">{{ $profil->telepon }}</a>
          </li>
          @endif
          @if($profil->whatsapp)
          <li class="flex items-center gap-2 text-slate-400 text-sm">
            <svg class="w-4 h-4 shrink-0 text-slate-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$profil->whatsapp) }}" target="_blank" class="hover:text-white transition-colors">{{ $profil->whatsapp }}</a>
          </li>
          @endif
          @if($profil->email_sekolah)
          <li class="flex items-center gap-2 text-slate-400 text-sm">
            <svg class="w-4 h-4 shrink-0 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <a href="mailto:{{ $profil->email_sekolah }}" class="hover:text-white transition-colors">{{ $profil->email_sekolah }}</a>
          </li>
          @endif
          @if($profil->website)
          <li class="flex items-center gap-2 text-slate-400 text-sm">
            <svg class="w-4 h-4 shrink-0 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
            <a href="{{ $profil->website }}" target="_blank" class="hover:text-white transition-colors">{{ $profil->website }}</a>
          </li>
          @endif
        </ul>
      </div>
    </div>

    <div class="border-t border-slate-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
      <p class="text-slate-500 text-xs">
        © {{ date('Y') }} SmartSchool {{ $profil->nama_sekolah ?? 'SMK Bustanul Ulum' }} · Dikembangkan oleh Mahasiswa Universitas Cipasung Tasikmalaya.
      </p>
      <div class="flex gap-5">
        <a href="#" class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Kebijakan Privasi</a>
        <a href="{{ route('login') }}" class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Login Admin</a>
      </div>
    </div>
  </div>
</footer>

{{-- ═══════ LIGHTBOX ═══════ --}}
<div id="lightbox" onclick="closeLightbox()">
  <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white/60 hover:text-white">
    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
  </button>
  <div class="text-center" onclick="event.stopPropagation()">
    <img id="lightboxImg" src="" alt="" class="max-w-[90vw] max-h-[80vh] object-contain rounded-xl mb-3">
    <p id="lightboxCaption" class="text-white/70 text-sm"></p>
  </div>
</div>

{{-- ═══════ SCRIPTS ═══════ --}}
<script>
  // Navbar scroll
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
      if (t) { e.preventDefault(); t.scrollIntoView({ behavior:'smooth' }); }
    });
  });

  // Scroll reveal
  const io = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
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
  }, { threshold: 0.07 });

  document.querySelectorAll('.sr').forEach((el, i) => {
    el.style.transition = 'opacity 0.55s ease, transform 0.55s ease';
    el.dataset.delay = (i % 8) * 80;
    io.observe(el);
  });

  // ── Slider ──────────────────────────────────────────────
  let currentSlide = 0;
  const totalSlides = {{ $sliders->count() }};

  function updateSlider() {
    const track = document.getElementById('sliderTrack');
    if (!track) return;
    track.style.transform = `translateX(-${currentSlide * 100}%)`;
    document.querySelectorAll('.slider-dot').forEach((dot, i) => {
      dot.classList.toggle('!bg-white', i === currentSlide);
      dot.classList.toggle('!w-6',     i === currentSlide);
      dot.classList.toggle('bg-white/40', i !== currentSlide);
    });
  }

  function nextSlide() { currentSlide = (currentSlide + 1) % totalSlides; updateSlider(); }
  function prevSlide() { currentSlide = (currentSlide - 1 + totalSlides) % totalSlides; updateSlider(); }
  function goSlide(i) { currentSlide = i; updateSlider(); }

  if (totalSlides > 1) { setInterval(nextSlide, 5500); }

  // ── Lightbox ─────────────────────────────────────────────
  function openLightbox(src, caption) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxCaption').textContent = caption;
    document.getElementById('lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    document.getElementById('lightbox').classList.remove('open');
    document.body.style.overflow = '';
  }

  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });

  // ── Kontak Form ──────────────────────────────────────────
  const pesanField = document.getElementById('pesan');
  const pesanCount = document.getElementById('pesanCount');

  if (pesanField && pesanCount) {
    const updateCount = () => {
      const len = pesanField.value.length;
      pesanCount.textContent = `${len} / 3000 karakter`;
      pesanCount.classList.toggle('text-red-400', len > 2800);
      pesanCount.classList.toggle('text-slate-400', len <= 2800);
    };
    pesanField.addEventListener('input', updateCount);
    updateCount();
  }

  // Submit loading state
  const kontakForm = document.getElementById('kontakForm');
  if (kontakForm) {
    kontakForm.addEventListener('submit', () => {
      const btn    = document.getElementById('submitBtn');
      const icon   = document.getElementById('submitIcon');
      const spinner = document.getElementById('submitSpinner');
      const label  = document.getElementById('submitLabel');
      if (btn && icon && spinner && label) {
        btn.disabled = true;
        icon.classList.add('hidden');
        spinner.classList.remove('hidden');
        label.textContent = 'Mengirim...';
      }
    });
  }

  // Auto-scroll ke #kontak jika ada flash success
  @if(session('kontak_success'))
  window.addEventListener('load', () => {
    const el = document.getElementById('kontak');
    if (el) { setTimeout(() => el.scrollIntoView({ behavior: 'smooth' }), 300); }
  });
  @endif
</script>
</body>
</html>