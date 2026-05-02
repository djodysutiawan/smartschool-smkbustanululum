<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>E-Learning — {{ optional($profil)->singkatan ?? 'SMK Bustanul Ulum' }}</title>
  <meta name="description" content="Portal materi pembelajaran digital {{ optional($profil)->nama_sekolah ?? 'SMK Bustanul Ulum' }}">

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
            fadeUp:   { from:{opacity:'0',transform:'translateY(24px)'}, to:{opacity:'1',transform:'translateY(0)'} },
            fadeIn:   { from:{opacity:'0'}, to:{opacity:'1'} },
            livePulse:{ '0%,100%':{boxShadow:'0 0 0 0 rgba(74,222,128,0.55)'},'50%':{boxShadow:'0 0 0 8px rgba(74,222,128,0)'} },
          },
          animation: {
            'fade-up':   'fadeUp 0.6s cubic-bezier(.22,.68,0,1.2) both',
            'fade-in':   'fadeIn 0.5s ease both',
            'live-pulse':'livePulse 2.2s ease-in-out infinite',
          },
        }
      }
    }
  </script>
  <style>
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'DM Sans',sans-serif; }
    h1,h2,h3,h4,.font-display { font-family:'Plus Jakarta Sans',sans-serif; }

    /* ── Hero — sedikit berbeda: lebih teal/emerald ── */
    .el-hero {
      background: linear-gradient(140deg, #0d2b3e 0%, #0e4f6e 45%, #0a6b4a 100%);
      position: relative; overflow: hidden;
    }
    .el-hero::before {
      content:''; position:absolute; inset:0; pointer-events:none;
      background:
        radial-gradient(ellipse 600px 400px at 75% 0%,   rgba(16,185,129,.25) 0%, transparent 65%),
        radial-gradient(ellipse 400px 400px at 10% 100%, rgba(56,189,248,.18) 0%, transparent 65%);
    }
    .el-hero::after {
      content:''; position:absolute; inset:0; pointer-events:none;
      background-image: radial-gradient(circle, rgba(255,255,255,.03) 1px, transparent 1px);
      background-size: 44px 44px;
    }

    /* ── Glass ── */
    .glass { background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.14); backdrop-filter:blur(14px); }

    /* ── Gradient text ── */
    .text-grad-teal {
      background: linear-gradient(120deg, #6ee7b7 0%, #67e8f9 50%, #93c5fd 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    }

    /* ── Navbar ── */
    .nav-scrolled {
      background:rgba(255,255,255,.96) !important;
      backdrop-filter:blur(18px) !important;
      border-bottom:1px solid #e2e8f0 !important;
    }
    .nav-scrolled .nl      { color:#1e293b !important; }
    .nav-scrolled .nl:hover{ background:#f1f5f9 !important; }
    .nav-scrolled .nbrand  { color:#1e293b !important; }
    .nav-scrolled .nsubb   { color:#64748b !important; }
    .nav-scrolled .nring   { background:#eef6ff !important; border-color:#bfdbfe !important; }
    .nav-scrolled .nrtext  { color:#1750c0 !important; }
    .nav-scrolled .ncta    { background:#1f63db !important; color:#fff !important; border-color:#1f63db !important; }
    .nav-scrolled .hbar    { background:#334155 !important; }

    /* ── Materi card ── */
    .mcard {
      transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
      cursor: pointer;
    }
    .mcard:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 32px rgba(14,79,110,.12);
      border-color: #6ee7b7;
    }
    .mcard:hover .mcard-thumb img { transform: scale(1.06); }
    .mcard-thumb img { transition: transform .4s ease; }

    /* ── Jenis badge colors ── */
    .jenis-video    { background:#fce7f3; color:#9d174d; }
    .jenis-pdf      { background:#fee2e2; color:#991b1b; }
    .jenis-dokumen  { background:#dbeafe; color:#1d4ed8; }
    .jenis-link     { background:#dcfce7; color:#166534; }
    .jenis-gambar   { background:#fef9c3; color:#854d0e; }
    .jenis-lainnya  { background:#f1f5f9; color:#475569; }

    /* ── Filter pills ── */
    .fpill {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 6px 14px; border-radius: 99px; font-size: 12px;
      font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif;
      border: 1.5px solid; cursor: pointer; transition: all .18s ease;
      text-decoration: none;
    }
    .fpill-active {
      background: #0e4f6e; color: #fff; border-color: #0e4f6e;
    }
    .fpill-inactive {
      background: #fff; color: #475569; border-color: #e2e8f0;
    }
    .fpill-inactive:hover {
      border-color: #6ee7b7; color: #0e4f6e;
    }

    /* ── Search ── */
    .search-input {
      background: rgba(255,255,255,.1);
      border: 1.5px solid rgba(255,255,255,.2);
      border-radius: 12px;
      padding: 10px 16px 10px 42px;
      color: #fff;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      outline: none;
      transition: border-color .18s, background .18s;
      width: 100%;
    }
    .search-input::placeholder { color: rgba(255,255,255,.4); }
    .search-input:focus {
      border-color: rgba(255,255,255,.5);
      background: rgba(255,255,255,.14);
    }

    /* scroll reveal */
    .sr { opacity:0; transform:translateY(22px); transition: opacity .5s ease, transform .5s ease; }

    /* scrollbar */
    ::-webkit-scrollbar { width:5px; }
    ::-webkit-scrollbar-track { background:#f1f5f9; }
    ::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:99px; }

    .section-label {
      display:inline-block; text-transform:uppercase; letter-spacing:.12em;
      font-size:11px; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif;
    }
  </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

{{-- ═══════ NAVBAR ═══════ --}}
<header id="nav" class="fixed inset-x-0 top-0 z-50 transition-all duration-300">
  <div class="max-w-7xl mx-auto px-5 h-16 flex items-center justify-between gap-4">

    <a href="{{ url('/') }}" class="flex items-center gap-2.5 shrink-0">
      <div class="nring w-9 h-9 rounded-xl border border-white/20 bg-white/10 flex items-center justify-center transition-all duration-300 overflow-hidden">
        @if(optional($profil)->logo_path)
          <img src="{{ asset('storage/'.$profil->logo_path) }}" alt="Logo" class="w-full h-full object-contain">
        @elseif(optional($profil)->logo_url)
          <img src="{{ $profil->logo_url }}" alt="Logo" class="w-full h-full object-contain">
        @else
          <span class="nrtext font-display font-extrabold text-white text-sm transition-all duration-300">
            {{ substr(optional($profil)->singkatan ?? 'B', 0, 1) }}
          </span>
        @endif
      </div>
      <div>
        <p class="nbrand font-display font-bold text-white text-sm leading-none transition-all duration-300">SmartSchool</p>
        <p class="nsubb text-white/55 text-[11px] transition-all duration-300">{{ optional($profil)->singkatan ?? 'SMK Bustanul Ulum' }}</p>
      </div>
    </a>

    <nav class="hidden md:flex items-center gap-0.5">
      <a href="{{ url('/ppdb') }}"      class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all {{ request()->is('ppdb*') ? 'bg-white/15 text-white border border-white/25' : '' }}">PPDB</a>
      <a href="{{ url('/elearning') }}" class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all {{ request()->is('elearning*') ? 'bg-white/15 text-white border border-white/25' : '' }}">E-Learning</a>
      <a href="{{ url('/nilai') }}"     class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all {{ request()->is('nilai*') ? 'bg-white/15 text-white border border-white/25' : '' }}">Nilai</a>
      <a href="{{ url('/absensi') }}"   class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all {{ request()->is('absensi*') ? 'bg-white/15 text-white border border-white/25' : '' }}">Absensi</a>
      <a href="{{ url('/') }}#kontak"   class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Kontak</a>
    </nav>

    <a href="{{ route('login') }}" class="ncta hidden md:inline-flex items-center gap-1.5 text-sm font-semibold font-display text-white border border-white/30 hover:border-white/60 hover:bg-white/12 px-5 py-2 rounded-xl transition-all duration-200">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
      Masuk
    </a>
  </div>
</header>

{{-- ═══════ HERO ═══════ --}}
<section class="el-hero pt-16">
  <div class="max-w-7xl mx-auto px-5 py-20 relative z-10">
    <div class="max-w-2xl">

      <div class="animate-fade-up inline-flex items-center gap-2 glass text-white/85 text-[11px] font-display font-semibold px-4 py-2 rounded-full mb-6 tracking-wider uppercase">
        <span class="animate-live-pulse w-2 h-2 rounded-full bg-emerald-400 shrink-0"></span>
        Portal Pembelajaran Digital
      </div>

      <h1 class="animate-fade-up [animation-delay:.1s] font-display font-extrabold text-4xl sm:text-5xl leading-[1.15] text-white mb-4">
        E-Learning<br><span class="text-grad-teal">{{ optional($profil)->singkatan ?? 'SMK Bustanul Ulum' }}</span>
      </h1>

      <p class="animate-fade-up [animation-delay:.2s] text-white/60 text-base leading-relaxed mb-8 max-w-lg">
        Akses materi pembelajaran digital kapan saja dan di mana saja. Video, dokumen, dan sumber belajar terkurasi dari guru terbaik.
      </p>

      {{-- Search bar --}}
      <form method="GET" action="{{ url('/elearning') }}" class="animate-fade-up [animation-delay:.3s]">
        <div class="flex gap-2 max-w-xl">
          <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-white/40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="Cari materi, mata pelajaran..."
                   class="search-input">
          </div>
          <button type="submit"
                  class="shrink-0 bg-emerald-500 hover:bg-emerald-600 text-white font-display font-bold text-sm px-6 py-2.5 rounded-xl transition-all">
            Cari
          </button>
        </div>
        {{-- Pertahankan filter lain saat search --}}
        @if(request('jenis')) <input type="hidden" name="jenis" value="{{ request('jenis') }}"> @endif
        @if(request('mapel')) <input type="hidden" name="mapel" value="{{ request('mapel') }}"> @endif
      </form>
    </div>

    {{-- Stats --}}
    <div class="animate-fade-up [animation-delay:.4s] grid grid-cols-2 sm:grid-cols-4 gap-3 mt-12 max-w-2xl">
      <div class="glass rounded-xl px-4 py-3 text-center">
        <p class="font-display font-extrabold text-2xl text-white">{{ $stats['total'] }}</p>
        <p class="text-white/45 text-xs mt-0.5">Total Materi</p>
      </div>
      <div class="glass rounded-xl px-4 py-3 text-center">
        <p class="font-display font-extrabold text-2xl text-white">{{ $stats['video'] }}</p>
        <p class="text-white/45 text-xs mt-0.5">Video</p>
      </div>
      <div class="glass rounded-xl px-4 py-3 text-center">
        <p class="font-display font-extrabold text-2xl text-white">{{ $stats['dokumen'] }}</p>
        <p class="text-white/45 text-xs mt-0.5">Dokumen / PDF</p>
      </div>
      <div class="glass rounded-xl px-4 py-3 text-center">
        <p class="font-display font-extrabold text-2xl text-white">{{ $stats['link'] }}</p>
        <p class="text-white/45 text-xs mt-0.5">Link Eksternal</p>
      </div>
    </div>
  </div>

  {{-- Wave --}}
  <div class="-mb-px">
    <svg viewBox="0 0 1440 56" xmlns="http://www.w3.org/2000/svg" class="w-full block">
      <path d="M0,28 C360,56 720,0 1080,28 C1260,42 1380,14 1440,28 L1440,56 L0,56 Z" fill="#f8fafc"/>
    </svg>
  </div>
</section>

{{-- ═══════ FILTER + MATERI ═══════ --}}
<section class="bg-slate-50 py-12">
  <div class="max-w-7xl mx-auto px-5">

    {{-- Filter row --}}
    <div class="sr flex flex-wrap items-center gap-2 mb-8">
      <span class="text-slate-400 text-xs font-semibold shrink-0 mr-1">Filter:</span>

      {{-- Jenis --}}
      @php
        $jenisOptions = [
          ''        => ['label'=>'Semua',    'icon'=>'📚'],
          'video'   => ['label'=>'Video',    'icon'=>'🎬'],
          'pdf'     => ['label'=>'PDF',      'icon'=>'📄'],
          'dokumen' => ['label'=>'Dokumen',  'icon'=>'📝'],
          'link'    => ['label'=>'Link',     'icon'=>'🔗'],
          'gambar'  => ['label'=>'Gambar',   'icon'=>'🖼️'],
        ];
        $activeJenis = request('jenis', '');
        $activeMapel = request('mapel', '');
        $activeQ     = request('q', '');
      @endphp

      @foreach($jenisOptions as $val => $opt)
      <a href="{{ url('/elearning') }}?{{ http_build_query(array_filter(['jenis'=>$val, 'mapel'=>$activeMapel, 'q'=>$activeQ])) }}"
         class="fpill {{ $activeJenis === $val ? 'fpill-active' : 'fpill-inactive' }}">
        <span>{{ $opt['icon'] }}</span> {{ $opt['label'] }}
      </a>
      @endforeach

      {{-- Mapel dropdown --}}
      @if($mapelList->count() > 0)
      <div class="relative ml-1">
        <select onchange="window.location = this.value"
                class="fpill fpill-inactive appearance-none pr-8 cursor-pointer">
          <option value="{{ url('/elearning') }}?{{ http_build_query(array_filter(['jenis'=>$activeJenis, 'q'=>$activeQ])) }}">
            Semua Mapel
          </option>
          @foreach($mapelList as $mp)
          <option value="{{ url('/elearning') }}?{{ http_build_query(array_filter(['jenis'=>$activeJenis, 'mapel'=>$mp->id, 'q'=>$activeQ])) }}"
                  {{ $activeMapel == $mp->id ? 'selected' : '' }}>
            {{ $mp->nama_mapel }}
          </option>
          @endforeach
        </select>
        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3 h-3 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
      </div>
      @endif

      {{-- Reset --}}
      @if($activeJenis || $activeMapel || $activeQ)
      <a href="{{ url('/elearning') }}" class="fpill fpill-inactive text-red-500 border-red-200 hover:border-red-400">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        Reset
      </a>
      @endif

      <span class="ml-auto text-slate-400 text-xs">{{ $materi->total() }} materi ditemukan</span>
    </div>

    {{-- Materi Grid --}}
    @if($materi->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 mb-10">
      @foreach($materi as $m)
      @php
        $jenisClass = [
          'video'   => 'jenis-video',
          'pdf'     => 'jenis-pdf',
          'dokumen' => 'jenis-dokumen',
          'link'    => 'jenis-link',
          'gambar'  => 'jenis-gambar',
        ][$m->jenis] ?? 'jenis-lainnya';

        $jenisIcon = [
          'video'   => '🎬',
          'pdf'     => '📄',
          'dokumen' => '📝',
          'link'    => '🔗',
          'gambar'  => '🖼️',
        ][$m->jenis] ?? '📚';

        $fileUrl = $m->file_url;
      @endphp

      <a href="{{ $fileUrl ?? '#' }}"
         @if($m->jenis === 'link' || $fileUrl) target="_blank" rel="noopener" @endif
         class="mcard sr group block bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-[0_1px_3px_rgba(0,0,0,.05),0_4px_16px_rgba(0,0,0,.05)]">

        {{-- Thumbnail --}}
        <div class="mcard-thumb relative h-40 overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200">
          @if($m->thumbnail)
            <img src="{{ asset('storage/'.$m->thumbnail) }}" alt="{{ $m->judul }}" class="w-full h-full object-cover">
          @else
            <div class="w-full h-full flex items-center justify-center">
              <span class="text-5xl opacity-30">{{ $jenisIcon }}</span>
            </div>
          @endif

          {{-- Jenis badge --}}
          <div class="absolute top-3 left-3">
            <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1 rounded-full {{ $jenisClass }}">
              {{ $jenisIcon }} {{ ucfirst($m->jenis) }}
            </span>
          </div>

          {{-- Play overlay untuk video --}}
          @if($m->jenis === 'video')
          <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black/30">
            <div class="w-12 h-12 rounded-full bg-white/90 flex items-center justify-center shadow-lg">
              <svg class="w-5 h-5 text-slate-800 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            </div>
          </div>
          @endif
        </div>

        {{-- Content --}}
        <div class="p-4">
          <h3 class="font-display font-bold text-slate-900 text-sm leading-snug mb-1.5 line-clamp-2 group-hover:text-teal-700 transition-colors">
            {{ $m->judul }}
          </h3>

          @if($m->deskripsi)
          <p class="text-slate-500 text-xs leading-relaxed mb-3 line-clamp-2">{{ $m->deskripsi }}</p>
          @endif

          <div class="flex items-center justify-between mt-auto pt-3 border-t border-slate-100">
            <div class="flex items-center gap-2 min-w-0">
              {{-- Avatar guru --}}
              <div class="w-6 h-6 rounded-full bg-teal-100 flex items-center justify-center text-[10px] font-bold text-teal-700 shrink-0">
                {{ substr(optional($m->guru)->nama ?? 'G', 0, 1) }}
              </div>
              <span class="text-slate-500 text-[11px] truncate">{{ optional($m->guru)->nama ?? 'Guru' }}</span>
            </div>

            @if($m->mataPelajaran)
            <span class="shrink-0 text-[10px] font-bold bg-teal-50 text-teal-700 border border-teal-100 px-2 py-0.5 rounded-full ml-2">
              {{ $m->mataPelajaran->nama_mapel }}
            </span>
            @endif
          </div>

          @if($m->dipublikasikan_pada)
          <p class="text-slate-400 text-[10px] mt-2">{{ $m->dipublikasikan_pada->diffForHumans() }}</p>
          @endif
        </div>
      </a>
      @endforeach
    </div>

    {{-- Pagination --}}
    @if($materi->hasPages())
    <div class="flex justify-center sr">
      {{ $materi->links('vendor.pagination.simple-tailwind') }}
    </div>
    @endif

    @else
    {{-- Empty state --}}
    <div class="sr text-center py-20">
      <div class="w-20 h-20 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-5">
        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
      </div>
      <h3 class="font-display font-bold text-slate-700 text-lg mb-2">Materi tidak ditemukan</h3>
      <p class="text-slate-400 text-sm mb-6">
        @if($activeQ)
          Tidak ada materi yang cocok dengan "<strong>{{ $activeQ }}</strong>".
        @else
          Belum ada materi yang dipublikasikan untuk filter ini.
        @endif
      </p>
      <a href="{{ url('/elearning') }}" class="inline-flex items-center gap-2 text-teal-700 font-display font-semibold text-sm border border-teal-200 bg-teal-50 px-5 py-2.5 rounded-xl hover:bg-teal-100 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Tampilkan semua materi
      </a>
    </div>
    @endif

  </div>
</section>

{{-- ═══════ CTA LOGIN ═══════ --}}
<section class="bg-white border-t border-slate-100 py-16">
  <div class="max-w-xl mx-auto px-5 text-center sr">
    <div class="w-14 h-14 rounded-2xl bg-teal-50 border border-teal-100 flex items-center justify-center mx-auto mb-5">
      <svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
    </div>
    <h2 class="font-display font-extrabold text-2xl text-slate-900 mb-3">Akses Lebih Lengkap?</h2>
    <p class="text-slate-500 text-sm leading-relaxed mb-7">
      Login ke sistem untuk mengakses seluruh materi, tugas, dan fitur e-learning secara penuh sesuai kelas dan jurusan Anda.
    </p>
    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-display font-bold text-sm px-8 py-3.5 rounded-xl transition-all shadow-sm hover:shadow-md">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
      Masuk ke Sistem
    </a>
  </div>
</section>

{{-- ═══════ FOOTER MINI ═══════ --}}
<footer class="bg-slate-900 border-t border-slate-800 py-6">
  <div class="max-w-7xl mx-auto px-5 flex flex-col sm:flex-row items-center justify-between gap-3">
    <p class="text-slate-500 text-xs">
      © {{ date('Y') }} SmartSchool {{ optional($profil)->nama_sekolah ?? 'SMK Bustanul Ulum' }}
    </p>
    <div class="flex gap-5">
      <a href="{{ url('/') }}"      class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Beranda</a>
      <a href="{{ url('/ppdb') }}"  class="text-slate-500 hover:text-slate-300 text-xs transition-colors">PPDB</a>
      <a href="{{ route('login') }}" class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Login</a>
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
    el.dataset.delay = (i % 8) * 70;
    io.observe(el);
  });
</script>
</body>
</html>