<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Jurusan — {{ $profil->nama_sekolah ?? 'SmartSchool' }}</title>
  <meta name="description" content="Temukan program keahlian unggulan di {{ $profil->nama_sekolah ?? 'SmartSchool' }}">

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

    /* Hero */
    .page-hero {
      background: linear-gradient(140deg,#0d1f4e 0%,#1750c0 48%,#0a6b4a 100%);
      position:relative; overflow:hidden;
    }
    .page-hero::before {
      content:''; position:absolute; inset:0; pointer-events:none;
      background:
        radial-gradient(ellipse 600px 400px at 80% -5%, rgba(89,163,248,.28) 0%,transparent 70%),
        radial-gradient(ellipse 400px 400px at 5% 95%,  rgba(16,185,129,.20) 0%,transparent 65%);
    }
    .page-hero::after {
      content:''; position:absolute; inset:0; pointer-events:none;
      background-image:radial-gradient(circle,rgba(255,255,255,.03) 1px,transparent 1px);
      background-size:44px 44px;
    }

    /* Glass */
    .glass { background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.14); backdrop-filter:blur(14px); }

    /* Navbar scroll */
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

    /* Cards */
    .jcard { transition:transform .22s ease,box-shadow .22s ease,border-color .22s ease; }
    .jcard:hover { transform:translateY(-5px); box-shadow:0 8px 40px rgba(31,99,219,.14); border-color:#93c5fd; }

    /* Role pill */
    .rpill {
      display:inline-flex; align-items:center; gap:3px;
      font-size:10px; font-weight:700; letter-spacing:.05em; text-transform:uppercase;
      padding:2px 9px; border-radius:99px;
    }

    /* Section label */
    .section-label {
      display:inline-block; text-transform:uppercase; letter-spacing:.12em;
      font-size:11px; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif;
    }

    /* Scroll reveal */
    .sr { opacity:0; transform:translateY(24px); }

    /* Mobile menu */
    #mmenu { display:none; }
    #mmenu.open { display:flex; }

    /* Filter tabs */
    .filter-tab { transition:all .18s ease; cursor:pointer; }
    .filter-tab.active {
      background:#1f63db; color:#fff; border-color:#1f63db;
    }

    /* Gradient text */
    .text-grad {
      background:linear-gradient(120deg,#93c5fd 0%,#a5f3fc 50%,#6ee7b7 100%);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
    }

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
          <span class="nrtext font-display font-extrabold text-white text-sm transition-all duration-300">{{ substr($profil->singkatan ?? 'B', 0, 1) }}</span>
        @endif
      </div>
      <div>
        <p class="nbrand font-display font-bold text-white text-sm leading-none transition-all duration-300">SmartSchool</p>
        <p class="nsubb text-white/55 text-[11px] transition-all duration-300">{{ $profil->singkatan ?? 'SMK' }}</p>
      </div>
    </a>

    <nav class="hidden md:flex items-center gap-0.5">
      <a href="{{ url('/') }}" class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Beranda</a>
      <a href="{{ route('jurusan.index') }}" class="nl text-white font-semibold text-sm px-3 py-2 rounded-lg bg-white/10 transition-all">Jurusan</a>
      <a href="{{ url('/#berita') }}" class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Berita</a>
      <a href="{{ url('/#prestasi') }}" class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Prestasi</a>
      <a href="{{ url('/#kontak') }}" class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Kontak</a>
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
    <a href="{{ route('jurusan.index') }}" onclick="toggleMenu()" class="text-white font-semibold text-sm px-3 py-2.5 rounded-lg bg-white/10 flex items-center transition-all">Jurusan</a>
    <a href="{{ url('/#berita') }}" onclick="toggleMenu()" class="text-white/75 hover:text-white text-sm px-3 py-2.5 rounded-lg hover:bg-white/10 flex items-center transition-all">Berita</a>
    <a href="{{ url('/#kontak') }}" onclick="toggleMenu()" class="text-white/75 hover:text-white text-sm px-3 py-2.5 rounded-lg hover:bg-white/10 flex items-center transition-all">Kontak</a>
    <a href="{{ route('login') }}" class="mt-2 bg-brand-500 hover:bg-brand-600 text-white font-display font-semibold text-sm py-2.5 rounded-xl flex items-center justify-center gap-2 transition-all">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
      Masuk ke Sistem
    </a>
  </div>
</header>

{{-- ═══════ PAGE HERO ═══════ --}}
<section class="page-hero pt-16">
  <div class="max-w-4xl mx-auto px-5 py-20 relative z-10 text-center">

    {{-- Breadcrumb --}}
    <nav class="animate-fade-up flex items-center justify-center gap-2 text-white/50 text-xs mb-8">
      <a href="{{ url('/') }}" class="hover:text-white transition-colors">Beranda</a>
      <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
      <span class="text-white/80">Jurusan</span>
    </nav>

    <span class="animate-fade-up inline-flex items-center gap-2 glass text-white/85 text-[11px] font-display font-semibold px-4 py-2 rounded-full mb-6 tracking-wider uppercase">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
      Program Keahlian
    </span>

    <h1 class="animate-fade-up [animation-delay:.1s] font-display font-extrabold text-4xl sm:text-5xl text-white mb-4 leading-tight">
      Jurusan <span class="text-grad">Unggulan</span>
    </h1>
    <p class="animate-fade-up [animation-delay:.2s] text-white/60 text-base leading-relaxed max-w-lg mx-auto mb-10">
      Pilih program keahlian yang sesuai dengan minat dan bakatmu untuk masa depan yang cerah dan profesional.
    </p>

    {{-- Stats bar --}}
    <div class="animate-fade-up [animation-delay:.3s] grid grid-cols-2 sm:grid-cols-4 glass rounded-2xl overflow-hidden divide-x divide-white/10">
      <div class="py-4 px-3 text-center">
        <p class="font-display font-extrabold text-xl text-white">{{ $stats['total_jurusan'] }}</p>
        <p class="text-white/45 text-xs mt-0.5">Jurusan</p>
      </div>
      <div class="py-4 px-3 text-center">
        <p class="font-display font-extrabold text-xl text-white">{{ $stats['penerimaan_buka'] }}</p>
        <p class="text-white/45 text-xs mt-0.5">Penerimaan Buka</p>
      </div>
      <div class="py-4 px-3 text-center">
        <p class="font-display font-extrabold text-xl text-white">{{ $stats['total_kelas_aktif'] }}</p>
        <p class="text-white/45 text-xs mt-0.5">Kelas Aktif</p>
      </div>
      <div class="py-4 px-3 text-center">
        <p class="font-display font-extrabold text-xl text-white">{{ $stats['total_siswa'] ?: '–' }}</p>
        <p class="text-white/45 text-xs mt-0.5">Total Siswa</p>
      </div>
    </div>
  </div>

  {{-- Wave --}}
  <div class="-mb-px">
    <svg viewBox="0 0 1440 72" xmlns="http://www.w3.org/2000/svg" class="w-full block">
      <path d="M0,36 C360,72 720,0 1080,36 C1260,54 1380,24 1440,36 L1440,72 L0,72 Z" fill="#f8fafc"/>
    </svg>
  </div>
</section>

{{-- ═══════ DAFTAR JURUSAN ═══════ --}}
<section class="bg-slate-50 py-16">
  <div class="max-w-7xl mx-auto px-5">

    @if($jurusan->count() > 0)

    {{-- Filter penerimaan --}}
    @if($jurusan->where('is_penerimaan_buka', true)->count() > 0)
    <div class="flex items-center gap-2 mb-10 flex-wrap sr">
      <span class="text-slate-500 text-xs font-semibold mr-1">Filter:</span>
      <button onclick="filterJurusan('semua')"
              class="filter-tab active text-xs font-display font-semibold px-4 py-1.5 rounded-full border border-slate-200 text-slate-600 bg-white">
        Semua Jurusan
      </button>
      <button onclick="filterJurusan('buka')"
              class="filter-tab text-xs font-display font-semibold px-4 py-1.5 rounded-full border border-slate-200 text-slate-600 bg-white">
        🟢 Penerimaan Buka
      </button>
    </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="jurusanGrid">
      @foreach($jurusan as $j)
      <div class="jcard sr bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-[0_1px_3px_rgba(0,0,0,.05),0_4px_16px_rgba(0,0,0,.06)]"
           data-penerimaan="{{ $j->is_penerimaan_buka ? 'buka' : 'tutup' }}">

        {{-- Cover --}}
        <div class="relative h-48 bg-gradient-to-br from-brand-700 to-brand-900 overflow-hidden">
          @if($j->foto_cover_path)
            <img src="{{ asset('storage/'.$j->foto_cover_path) }}" alt="{{ $j->nama }}" class="w-full h-full object-cover opacity-80">
          @elseif($j->foto_cover_url)
            <img src="{{ $j->foto_cover_url }}" alt="{{ $j->nama }}" class="w-full h-full object-cover opacity-80">
          @else
            <div class="absolute inset-0 flex items-center justify-center">
              <svg class="w-20 h-20 text-white/15" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
              </svg>
            </div>
          @endif
          <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>

          @if($j->is_penerimaan_buka)
          <div class="absolute top-3 right-3 inline-flex items-center gap-1.5 bg-emerald-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow">
            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
            Penerimaan Buka
          </div>
          @endif

          @if($j->akreditasi)
          <div class="absolute top-3 left-3 bg-white/15 backdrop-blur-sm border border-white/20 text-white text-[10px] font-bold px-2.5 py-1 rounded-full">
            Akreditasi {{ $j->akreditasi }}
          </div>
          @endif

          <div class="absolute bottom-3 left-4 flex items-center gap-2.5">
            @if($j->logo_path || $j->logo_url)
            <div class="w-11 h-11 rounded-xl bg-white border-2 border-white/60 overflow-hidden shadow-lg shrink-0">
              <img src="{{ $j->logo_path ? asset('storage/'.$j->logo_path) : $j->logo_url }}"
                   alt="Logo {{ $j->singkatan }}" class="w-full h-full object-contain p-0.5">
            </div>
            @endif
            <div>
              <p class="text-white font-display font-bold text-base leading-tight">{{ $j->singkatan }}</p>
              @if($j->kode_jurusan)
              <p class="text-white/55 text-[10px]">{{ $j->kode_jurusan }}</p>
              @endif
            </div>
          </div>
        </div>

        {{-- Content --}}
        <div class="p-5">
          <h3 class="font-display font-bold text-slate-900 text-base mb-1.5 leading-snug">{{ $j->nama }}</h3>

          @if($j->deskripsi_singkat)
          <p class="text-slate-500 text-sm leading-relaxed mb-4 line-clamp-2">{{ $j->deskripsi_singkat }}</p>
          @endif

          {{-- Quick stats --}}
          @if($j->lama_belajar || $j->kapasitas_per_kelas || $j->jumlah_kelas_aktif)
          <div class="grid grid-cols-3 gap-2 mb-4">
            @if($j->lama_belajar)
            <div class="bg-slate-50 rounded-xl p-2.5 text-center border border-slate-100">
              <p class="font-display font-extrabold text-slate-800 text-sm">{{ $j->lama_belajar }} Th</p>
              <p class="text-slate-400 text-[10px] mt-0.5">Lama Belajar</p>
            </div>
            @endif
            @if($j->kapasitas_per_kelas)
            <div class="bg-slate-50 rounded-xl p-2.5 text-center border border-slate-100">
              <p class="font-display font-extrabold text-slate-800 text-sm">{{ $j->kapasitas_per_kelas }}</p>
              <p class="text-slate-400 text-[10px] mt-0.5">Kapasitas</p>
            </div>
            @endif
            @if($j->jumlah_kelas_aktif)
            <div class="bg-slate-50 rounded-xl p-2.5 text-center border border-slate-100">
              <p class="font-display font-extrabold text-slate-800 text-sm">{{ $j->jumlah_kelas_aktif }}</p>
              <p class="text-slate-400 text-[10px] mt-0.5">Kelas Aktif</p>
            </div>
            @endif
          </div>
          @endif

          {{-- Kompetensi pills --}}
          @if($j->kompetensi->count() > 0)
          <div class="flex flex-wrap gap-1.5 mb-4">
            @foreach($j->kompetensi->take(3) as $k)
            <span class="rpill bg-brand-50 text-brand-700 border border-brand-100">{{ $k->nama_kompetensi }}</span>
            @endforeach
            @if($j->kompetensi->count() > 3)
            <span class="rpill bg-slate-100 text-slate-500 border border-slate-200">+{{ $j->kompetensi->count() - 3 }} lainnya</span>
            @endif
          </div>
          @endif

          {{-- Prospek kerja --}}
          @if($j->prospekKerja->count() > 0)
          <div class="border-t border-slate-100 pt-3 mb-4">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Prospek Kerja</p>
            <div class="flex flex-wrap gap-1">
              @foreach($j->prospekKerja->take(3) as $p)
              <span class="text-[10px] bg-emerald-50 text-emerald-700 border border-emerald-100 px-2 py-0.5 rounded-full font-semibold">{{ $p->jabatan }}</span>
              @endforeach
              @if($j->prospekKerja->count() > 3)
              <span class="text-[10px] bg-slate-50 text-slate-500 border border-slate-200 px-2 py-0.5 rounded-full font-semibold">+{{ $j->prospekKerja->count() - 3 }}</span>
              @endif
            </div>
          </div>
          @endif

          {{-- Kajur --}}
          @if($j->nama_kajur)
          <div class="flex items-center gap-2 border-t border-slate-100 pt-3 mb-4">
            @if($j->foto_kajur_path || $j->foto_kajur_url)
            <img src="{{ $j->foto_kajur_path ? asset('storage/'.$j->foto_kajur_path) : $j->foto_kajur_url }}"
                 alt="{{ $j->nama_kajur }}" class="w-7 h-7 rounded-full object-cover border border-slate-200 shrink-0">
            @else
            <div class="w-7 h-7 rounded-full bg-brand-100 flex items-center justify-center text-[10px] font-bold text-brand-700 shrink-0">
              {{ substr($j->nama_kajur, 0, 1) }}
            </div>
            @endif
            <div>
              <p class="text-[10px] text-slate-400">Kepala Jurusan</p>
              <p class="text-xs font-semibold text-slate-700">{{ $j->nama_kajur }}</p>
            </div>
          </div>
          @endif

          {{-- CTA --}}
          <a href="{{ route('jurusan.show', $j->slug) }}"
             class="flex items-center justify-center gap-2 w-full bg-brand-600 hover:bg-brand-700 text-white font-display font-semibold text-sm py-2.5 rounded-xl transition-all duration-200 group">
            Lihat Detail
            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
      </div>
      @endforeach
    </div>

    @else
    <div class="text-center py-24 text-slate-400">
      <svg class="w-16 h-16 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
        <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
      </svg>
      <p class="font-display font-semibold text-slate-500 text-lg mb-1">Belum Ada Jurusan</p>
      <p class="text-sm">Jurusan akan ditampilkan setelah dipublikasikan oleh admin.</p>
    </div>
    @endif

  </div>
</section>

{{-- ═══════ CTA BANNER ═══════ --}}
<section class="bg-white border-t border-slate-100 py-16">
  <div class="max-w-2xl mx-auto px-5 text-center">
    <p class="font-display font-bold text-slate-400 text-xs uppercase tracking-widest mb-3">Masih Bingung?</p>
    <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 mb-3">Hubungi Kami untuk Konsultasi</h2>
    <p class="text-slate-500 text-sm mb-8 leading-relaxed">Tim kami siap membantu kamu memilih jurusan yang tepat sesuai minat dan bakat.</p>
    <div class="flex flex-col sm:flex-row gap-3 justify-center">
      <a href="{{ url('/#kontak') }}" class="inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-display font-bold text-sm px-8 py-3.5 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        Hubungi Kami
      </a>
      @if($profil->whatsapp)
      <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$profil->whatsapp) }}" target="_blank"
         class="inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-display font-bold text-sm px-8 py-3.5 rounded-xl transition-all duration-200">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
        Chat WhatsApp
      </a>
      @endif
    </div>
  </div>
</section>

{{-- ═══════ FOOTER MINI ═══════ --}}
<footer class="bg-slate-900 text-white py-8">
  <div class="max-w-7xl mx-auto px-5 flex flex-col sm:flex-row items-center justify-between gap-3">
    <p class="text-slate-500 text-xs">© {{ date('Y') }} SmartSchool {{ $profil->nama_sekolah ?? '' }}</p>
    <div class="flex gap-5">
      <a href="{{ url('/') }}" class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Beranda</a>
      <a href="{{ route('jurusan.index') }}" class="text-slate-300 text-xs">Jurusan</a>
      <a href="{{ route('login') }}" class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Login Admin</a>
    </div>
  </div>
</footer>

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

  // Scroll reveal
  const io = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const el = entry.target;
        setTimeout(() => {
          el.style.opacity = '1';
          el.style.transform = 'translateY(0)';
        }, (el.dataset.delay || 0));
        io.unobserve(el);
      }
    });
  }, { threshold: 0.07 });

  document.querySelectorAll('.sr').forEach((el, i) => {
    el.style.transition = 'opacity 0.55s ease, transform 0.55s ease';
    el.dataset.delay = (i % 6) * 90;
    io.observe(el);
  });

  // Filter jurusan
  function filterJurusan(filter) {
    document.querySelectorAll('.filter-tab').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');

    document.querySelectorAll('#jurusanGrid > div').forEach(card => {
      if (filter === 'semua') {
        card.style.display = '';
      } else {
        card.style.display = card.dataset.penerimaan === filter ? '' : 'none';
      }
    });
  }
</script>
</body>
</html>