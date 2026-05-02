<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Prestasi — {{ $profil->nama_sekolah ?? 'SmartSchool' }}</title>
  <meta name="description" content="Daftar prestasi dan penghargaan {{ $profil->nama_sekolah ?? 'SmartSchool' }}">

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
            fadeUp: { from:{opacity:'0',transform:'translateY(24px)'}, to:{opacity:'1',transform:'translateY(0)'} },
            fadeIn: { from:{opacity:'0'}, to:{opacity:'1'} },
          },
          animation: {
            'fade-up': 'fadeUp 0.6s cubic-bezier(.22,.68,0,1.2) both',
            'fade-in': 'fadeIn 0.5s ease both',
          },
        }
      }
    }
  </script>
  <style>
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'DM Sans',sans-serif; }
    h1,h2,h3,h4,.font-display { font-family:'Plus Jakarta Sans',sans-serif; }

    .page-hero {
      background: linear-gradient(140deg,#1a0a3e 0%,#3b1f8c 45%,#0a4a2e 100%);
      position:relative; overflow:hidden;
    }
    .page-hero::before {
      content:''; position:absolute; inset:0; pointer-events:none;
      background:
        radial-gradient(ellipse 600px 400px at 80% -5%, rgba(251,191,36,.18) 0%,transparent 70%),
        radial-gradient(ellipse 400px 400px at 5% 95%,  rgba(167,139,250,.22) 0%,transparent 65%);
    }
    .page-hero::after {
      content:''; position:absolute; inset:0; pointer-events:none;
      background-image:radial-gradient(circle,rgba(255,255,255,.03) 1px,transparent 1px);
      background-size:44px 44px;
    }

    .glass { background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.14); backdrop-filter:blur(14px); }

    .nav-scrolled {
      background:rgba(255,255,255,.96) !important; backdrop-filter:blur(18px) !important;
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

    /* Tingkat badge */
    .badge-sekolah       { background:#dbeafe; color:#1d4ed8; border-color:#bfdbfe; }
    .badge-kecamatan     { background:#dcfce7; color:#166534; border-color:#bbf7d0; }
    .badge-kabupaten     { background:#fef9c3; color:#854d0e; border-color:#fde68a; }
    .badge-provinsi      { background:#fce7f3; color:#9d174d; border-color:#fbcfe8; }
    .badge-nasional      { background:#ede9fe; color:#6d28d9; border-color:#ddd6fe; }
    .badge-internasional { background:#fee2e2; color:#991b1b; border-color:#fecaca; }

    .tingkat-icon-sekolah       { background:#dbeafe; color:#1d4ed8; }
    .tingkat-icon-kecamatan     { background:#dcfce7; color:#166534; }
    .tingkat-icon-kabupaten     { background:#fef9c3; color:#854d0e; }
    .tingkat-icon-provinsi      { background:#fce7f3; color:#9d174d; }
    .tingkat-icon-nasional      { background:#ede9fe; color:#6d28d9; }
    .tingkat-icon-internasional { background:#fee2e2; color:#991b1b; }

    /* Cards */
    .pcard { transition:transform .22s ease,box-shadow .22s ease,border-color .22s ease; }
    .pcard:hover { transform:translateY(-4px); box-shadow:0 8px 40px rgba(0,0,0,.10); }

    /* Gold shimmer untuk nasional/internasional */
    .pcard-gold {
      border-color: #fbbf24 !important;
      background: linear-gradient(135deg, #fffbeb 0%, #ffffff 60%);
    }
    .pcard-gold:hover { box-shadow:0 8px 40px rgba(251,191,36,.25); }

    .rpill {
      display:inline-flex; align-items:center; gap:3px;
      font-size:10px; font-weight:700; letter-spacing:.05em; text-transform:uppercase;
      padding:2px 9px; border-radius:99px;
    }

    .section-label {
      display:inline-block; text-transform:uppercase; letter-spacing:.12em;
      font-size:11px; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif;
    }

    .text-grad-gold {
      background:linear-gradient(120deg,#fbbf24 0%,#f59e0b 50%,#d97706 100%);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
    }
    .text-grad {
      background:linear-gradient(120deg,#c4b5fd 0%,#a5f3fc 50%,#6ee7b7 100%);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
    }

    /* Select styling */
    .form-select {
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 0.75rem center;
      background-size: 1rem;
      padding-right: 2.5rem;
    }

    .sr { opacity:0; transform:translateY(20px); }
    #mmenu { display:none; }
    #mmenu.open { display:flex; }

    ::-webkit-scrollbar { width:5px; }
    ::-webkit-scrollbar-track { background:#f1f5f9; }
    ::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:99px; }
  </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

{{-- ═══════ NAVBAR ═══════ --}}
<header id="nav" class="fixed inset-x-0 top-0 z-50 transition-all duration-300">
  <div class="max-w-7xl mx-auto px-5 h-16 flex items-center justify-between gap-4">
    <a href="{{ url('/') }}" class="flex items-center gap-2.5 shrink-0">
      <div class="nring w-9 h-9 rounded-xl border border-white/20 bg-white/10 flex items-center justify-center transition-all duration-300 overflow-hidden">
        @if($profil->logo_path)
          <img src="{{ asset('storage/'.$profil->logo_path) }}" alt="Logo" class="w-full h-full object-contain">
        @else
          <span class="nrtext font-display font-extrabold text-white text-sm">{{ substr($profil->singkatan ?? 'B', 0, 1) }}</span>
        @endif
      </div>
      <div>
        <p class="nbrand font-display font-bold text-white text-sm leading-none transition-all duration-300">SmartSchool</p>
        <p class="nsubb text-white/55 text-[11px] transition-all duration-300">{{ $profil->singkatan ?? 'SMK' }}</p>
      </div>
    </a>

    <nav class="hidden md:flex items-center gap-0.5">
      <a href="{{ url('/') }}"                    class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Beranda</a>
      <a href="{{ route('jurusan.index') }}"       class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Jurusan</a>
      <a href="{{ url('/#berita') }}"              class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Berita</a>
      <a href="{{ route('prestasi.index') }}"      class="nl text-white font-semibold text-sm px-3 py-2 rounded-lg bg-white/10 transition-all">Prestasi</a>
      <a href="{{ url('/#kontak') }}"              class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Kontak</a>
    </nav>

    <a href="{{ route('login') }}" class="ncta hidden md:inline-flex items-center gap-1.5 text-sm font-semibold font-display text-white border border-white/30 hover:border-white/60 hover:bg-white/12 px-5 py-2 rounded-xl transition-all duration-200">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
      Masuk
    </a>

    <button class="md:hidden p-2 flex flex-col gap-1.5" onclick="toggleMenu()">
      <span class="hbar w-5 h-0.5 bg-white rounded transition-all"></span>
      <span class="hbar w-5 h-0.5 bg-white rounded transition-all"></span>
      <span class="hbar w-5 h-0.5 bg-white rounded transition-all"></span>
    </button>
  </div>

  <div id="mmenu" class="flex-col md:hidden bg-brand-950/95 backdrop-blur-xl border-t border-white/10 px-5 py-4 gap-1">
    <a href="{{ url('/') }}" class="text-white/75 hover:text-white text-sm px-3 py-2.5 rounded-lg hover:bg-white/10 flex items-center transition-all">Beranda</a>
    <a href="{{ route('jurusan.index') }}" onclick="toggleMenu()" class="text-white/75 hover:text-white text-sm px-3 py-2.5 rounded-lg hover:bg-white/10 flex items-center transition-all">Jurusan</a>
    <a href="{{ url('/#berita') }}" onclick="toggleMenu()" class="text-white/75 hover:text-white text-sm px-3 py-2.5 rounded-lg hover:bg-white/10 flex items-center transition-all">Berita</a>
    <a href="{{ route('prestasi.index') }}" onclick="toggleMenu()" class="text-white font-semibold text-sm px-3 py-2.5 rounded-lg bg-white/10 flex items-center transition-all">Prestasi</a>
    <a href="{{ url('/#kontak') }}" onclick="toggleMenu()" class="text-white/75 hover:text-white text-sm px-3 py-2.5 rounded-lg hover:bg-white/10 flex items-center transition-all">Kontak</a>
    <a href="{{ route('login') }}" class="mt-2 bg-brand-500 hover:bg-brand-600 text-white font-display font-semibold text-sm py-2.5 rounded-xl flex items-center justify-center gap-2 transition-all">Masuk ke Sistem</a>
  </div>
</header>

{{-- ═══════ PAGE HERO ═══════ --}}
<section class="page-hero pt-16">
  <div class="max-w-4xl mx-auto px-5 py-20 relative z-10 text-center">

    <nav class="animate-fade-up flex items-center justify-center gap-2 text-white/50 text-xs mb-8">
      <a href="{{ url('/') }}" class="hover:text-white transition-colors">Beranda</a>
      <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
      <span class="text-white/80">Prestasi</span>
    </nav>

    <span class="animate-fade-up inline-flex items-center gap-2 glass text-white/85 text-[11px] font-display font-semibold px-4 py-2 rounded-full mb-6 tracking-wider uppercase">
      🏆 Capaian & Penghargaan
    </span>

    <h1 class="animate-fade-up [animation-delay:.1s] font-display font-extrabold text-4xl sm:text-5xl text-white mb-4 leading-tight">
      Prestasi <span class="text-grad">Membanggakan</span>
    </h1>
    <p class="animate-fade-up [animation-delay:.2s] text-white/60 text-base leading-relaxed max-w-lg mx-auto mb-10">
      Meraih kejuaraan dari tingkat sekolah hingga internasional — bukti nyata semangat dan kerja keras siswa-siswi kami.
    </p>

    {{-- Stats --}}
    <div class="animate-fade-up [animation-delay:.3s] grid grid-cols-2 sm:grid-cols-4 glass rounded-2xl overflow-hidden divide-x divide-white/10">
      <div class="py-4 px-3 text-center">
        <p class="font-display font-extrabold text-2xl text-white">{{ $stats['total'] }}</p>
        <p class="text-white/45 text-xs mt-0.5">Total Prestasi</p>
      </div>
      <div class="py-4 px-3 text-center">
        <p class="font-display font-extrabold text-2xl text-grad-gold">{{ $stats['nasional'] }}</p>
        <p class="text-white/45 text-xs mt-0.5">Nasional / Internasional</p>
      </div>
      <div class="py-4 px-3 text-center">
        <p class="font-display font-extrabold text-2xl text-white">{{ $stats['provinsi'] }}</p>
        <p class="text-white/45 text-xs mt-0.5">Tingkat Provinsi</p>
      </div>
      <div class="py-4 px-3 text-center">
        <p class="font-display font-extrabold text-2xl text-white">{{ $stats['tahun_ini'] }}</p>
        <p class="text-white/45 text-xs mt-0.5">Tahun {{ date('Y') }}</p>
      </div>
    </div>
  </div>

  <div class="-mb-px">
    <svg viewBox="0 0 1440 72" xmlns="http://www.w3.org/2000/svg" class="w-full block">
      <path d="M0,36 C360,72 720,0 1080,36 C1260,54 1380,24 1440,36 L1440,72 L0,72 Z" fill="#f8fafc"/>
    </svg>
  </div>
</section>

{{-- ═══════ FILTER + GRID ═══════ --}}
<section class="bg-slate-50 py-14">
  <div class="max-w-7xl mx-auto px-5">

    {{-- Filter bar --}}
    <form method="GET" action="{{ route('prestasi.index') }}"
          class="sr bg-white rounded-2xl border border-slate-200 shadow-sm p-4 mb-8 flex flex-col sm:flex-row gap-3 items-end">

      {{-- Tingkat --}}
      <div class="flex-1 min-w-0">
        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tingkat</label>
        <select name="tingkat" class="form-select w-full text-sm text-slate-700 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 font-display font-semibold focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-100">
          <option value="">Semua Tingkat</option>
          @foreach($tingkatList as $val => $label)
          <option value="{{ $val }}" {{ request('tingkat') == $val ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
      </div>

      {{-- Tahun --}}
      <div class="flex-1 min-w-0">
        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tahun</label>
        <select name="tahun" class="form-select w-full text-sm text-slate-700 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 font-display font-semibold focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-100">
          <option value="">Semua Tahun</option>
          @foreach($tahunList as $t)
          <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
          @endforeach
        </select>
      </div>

      {{-- Jurusan --}}
      @if($jurusanList->count() > 0)
      <div class="flex-1 min-w-0">
        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jurusan</label>
        <select name="jurusan" class="form-select w-full text-sm text-slate-700 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 font-display font-semibold focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-100">
          <option value="">Semua Jurusan</option>
          @foreach($jurusanList as $j)
          <option value="{{ $j->id }}" {{ request('jurusan') == $j->id ? 'selected' : '' }}>{{ $j->singkatan }}</option>
          @endforeach
        </select>
      </div>
      @endif

      <div class="flex gap-2 shrink-0">
        <button type="submit" class="inline-flex items-center gap-1.5 bg-brand-600 hover:bg-brand-700 text-white font-display font-bold text-sm px-5 py-2.5 rounded-xl transition-all">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          Filter
        </button>
        @if(request()->hasAny(['tingkat','tahun','jurusan']))
        <a href="{{ route('prestasi.index') }}" class="inline-flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-display font-semibold text-sm px-4 py-2.5 rounded-xl transition-all">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
          Reset
        </a>
        @endif
      </div>
    </form>

    {{-- Result info --}}
    @if(request()->hasAny(['tingkat','tahun','jurusan']))
    <p class="text-slate-500 text-sm mb-6 sr">
      Menampilkan <span class="font-semibold text-slate-700">{{ $prestasi->total() }}</span> prestasi
      @if(request('tingkat')) dengan tingkat <span class="font-semibold text-slate-700">{{ $tingkatList[request('tingkat')] ?? request('tingkat') }}</span> @endif
      @if(request('tahun')) tahun <span class="font-semibold text-slate-700">{{ request('tahun') }}</span> @endif
    </p>
    @endif

    {{-- Prestasi Grid --}}
    @if($prestasi->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">
      @foreach($prestasi as $p)
      @php
        $isTop = in_array($p->tingkat, ['nasional','internasional']);
        $tingkatClass = match($p->tingkat) {
          'sekolah'       => 'badge-sekolah',
          'kecamatan'     => 'badge-kecamatan',
          'kabupaten'     => 'badge-kabupaten',
          'provinsi'      => 'badge-provinsi',
          'nasional'      => 'badge-nasional',
          'internasional' => 'badge-internasional',
          default         => 'badge-sekolah',
        };
        $iconTingkat = match($p->tingkat) {
          'sekolah'       => 'tingkat-icon-sekolah',
          'kecamatan'     => 'tingkat-icon-kecamatan',
          'kabupaten'     => 'tingkat-icon-kabupaten',
          'provinsi'      => 'tingkat-icon-provinsi',
          'nasional'      => 'tingkat-icon-nasional',
          'internasional' => 'tingkat-icon-internasional',
          default         => 'tingkat-icon-sekolah',
        };
        $emoji = match($p->tingkat) {
          'internasional' => '🌍',
          'nasional'      => '🏆',
          'provinsi'      => '🗺️',
          'kabupaten'     => '🏛️',
          'kecamatan'     => '🏡',
          default         => '🏫',
        };
      @endphp

      <div class="pcard sr bg-white rounded-2xl border {{ $isTop ? 'pcard-gold border-amber-200' : 'border-slate-200' }} shadow-sm overflow-hidden">

        {{-- Top strip untuk nasional/internasional --}}
        @if($isTop)
        <div class="h-1 bg-gradient-to-r from-amber-400 via-yellow-300 to-amber-500"></div>
        @endif

        {{-- Foto / Icon header --}}
        <div class="relative">
          @if($p->foto_path || $p->foto_url)
          <div class="h-40 overflow-hidden bg-slate-100">
            <img src="{{ $p->foto_path ? asset('storage/'.$p->foto_path) : $p->foto_url }}"
                 alt="{{ $p->judul }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
          </div>
          @endif

          {{-- Badge tingkat --}}
          <div class="absolute top-3 left-3">
            <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1 rounded-full border {{ $tingkatClass }}">
              {{ $emoji }} {{ $p->tingkat_label }}
            </span>
          </div>

          @if($p->is_featured)
          <div class="absolute top-3 right-3">
            <span class="inline-flex items-center gap-1 bg-amber-400 text-amber-900 text-[10px] font-bold px-2.5 py-1 rounded-full">
              ⭐ Unggulan
            </span>
          </div>
          @endif
        </div>

        {{-- Content --}}
        <div class="p-5">

          {{-- Icon + Judul --}}
          <div class="flex items-start gap-3 mb-3">
            @if(!$p->foto_path && !$p->foto_url)
            <div class="w-12 h-12 rounded-xl {{ $iconTingkat }} flex items-center justify-center text-2xl shrink-0">
              {{ $emoji }}
            </div>
            @endif
            <div class="flex-1 min-w-0">
              <h3 class="font-display font-bold text-slate-900 text-sm leading-snug mb-1">{{ $p->judul }}</h3>
              @if($p->nama_event)
              <p class="text-slate-500 text-xs">{{ $p->nama_event }}</p>
              @endif
            </div>
          </div>

          {{-- Peringkat --}}
          @if($p->peringkat)
          <div class="inline-flex items-center gap-1.5 bg-amber-50 border border-amber-100 text-amber-700 text-xs font-bold px-3 py-1.5 rounded-lg mb-3">
            🥇 {{ $p->peringkat }}
          </div>
          @endif

          {{-- Deskripsi singkat --}}
          @if($p->deskripsi)
          <p class="text-slate-500 text-xs leading-relaxed mb-4 line-clamp-2">{{ $p->deskripsi }}</p>
          @endif

          {{-- Meta info --}}
          <div class="border-t border-slate-100 pt-3 space-y-1.5">
            @if($p->nama_penerima)
            <div class="flex items-center gap-2 text-xs text-slate-500">
              <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
              <span class="font-semibold text-slate-700 truncate">{{ $p->nama_penerima }}</span>
              <span class="text-slate-300">·</span>
              <span class="capitalize text-slate-400">{{ $p->tipe_penerima }}</span>
            </div>
            @endif

            <div class="flex items-center justify-between gap-2">
              <div class="flex items-center gap-3 text-xs text-slate-400">
                @if($p->tanggal)
                <span class="flex items-center gap-1">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                  {{ $p->tanggal->locale('id')->isoFormat('D MMM Y') }}
                </span>
                @elseif($p->tahun)
                <span>{{ $p->tahun }}</span>
                @endif

                @if($p->penyelenggara)
                <span class="truncate max-w-[100px]" title="{{ $p->penyelenggara }}">{{ $p->penyelenggara }}</span>
                @endif
              </div>

              @if($p->jurusan)
              <span class="inline-flex items-center gap-1 bg-brand-50 text-brand-700 border border-brand-100 text-[10px] font-bold px-2 py-0.5 rounded-full shrink-0">
                {{ $p->jurusan->singkatan }}
              </span>
              @endif
            </div>
          </div>

        </div>
      </div>
      @endforeach
    </div>

    {{-- Pagination --}}
    @if($prestasi->hasPages())
    <div class="flex justify-center sr">
      <div class="inline-flex items-center gap-1 bg-white border border-slate-200 rounded-2xl px-3 py-2 shadow-sm">

        {{-- Prev --}}
        @if($prestasi->onFirstPage())
        <span class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-300 cursor-not-allowed">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
        </span>
        @else
        <a href="{{ $prestasi->previousPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-800 transition-all">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
        </a>
        @endif

        {{-- Pages --}}
        @foreach($prestasi->getUrlRange(max(1, $prestasi->currentPage()-2), min($prestasi->lastPage(), $prestasi->currentPage()+2)) as $page => $url)
        @if($page == $prestasi->currentPage())
        <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-brand-600 text-white font-display font-bold text-sm">{{ $page }}</span>
        @else
        <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-600 hover:bg-slate-100 font-display font-semibold text-sm transition-all">{{ $page }}</a>
        @endif
        @endforeach

        {{-- Next --}}
        @if($prestasi->hasMorePages())
        <a href="{{ $prestasi->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-800 transition-all">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
        </a>
        @else
        <span class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-300 cursor-not-allowed">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
        </span>
        @endif
      </div>
    </div>
    @endif

    @else
    {{-- Empty state --}}
    <div class="text-center py-24 text-slate-400 sr">
      <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center text-4xl mx-auto mb-4">🏆</div>
      <p class="font-display font-semibold text-slate-500 text-lg mb-1">Tidak Ada Prestasi</p>
      <p class="text-sm mb-6">
        @if(request()->hasAny(['tingkat','tahun','jurusan']))
          Tidak ditemukan prestasi dengan filter yang dipilih.
        @else
          Belum ada prestasi yang dipublikasikan.
        @endif
      </p>
      @if(request()->hasAny(['tingkat','tahun','jurusan']))
      <a href="{{ route('prestasi.index') }}" class="inline-flex items-center gap-2 text-brand-600 font-display font-semibold text-sm hover:text-brand-800 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        Hapus Filter
      </a>
      @endif
    </div>
    @endif

  </div>
</section>

{{-- ═══════ FOOTER MINI ═══════ --}}
<footer class="bg-slate-900 text-white py-8 mt-4">
  <div class="max-w-7xl mx-auto px-5 flex flex-col sm:flex-row items-center justify-between gap-3">
    <p class="text-slate-500 text-xs">© {{ date('Y') }} SmartSchool {{ $profil->nama_sekolah ?? '' }}</p>
    <div class="flex gap-5">
      <a href="{{ url('/') }}"               class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Beranda</a>
      <a href="{{ route('jurusan.index') }}"  class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Jurusan</a>
      <a href="{{ route('prestasi.index') }}" class="text-slate-300 text-xs">Prestasi</a>
      <a href="{{ route('login') }}"          class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Login Admin</a>
    </div>
  </div>
</footer>

<script>
  const nav = document.getElementById('nav');
  window.addEventListener('scroll', () => {
    nav.classList.toggle('nav-scrolled', window.scrollY > 56);
  });

  function toggleMenu() {
    document.getElementById('mmenu').classList.toggle('open');
  }

  const io = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        setTimeout(() => {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
        }, entry.target.dataset.delay || 0);
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.07 });

  document.querySelectorAll('.sr').forEach((el, i) => {
    el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    el.dataset.delay = (i % 6) * 80;
    io.observe(el);
  });
</script>
</body>
</html>