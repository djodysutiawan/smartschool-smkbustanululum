<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cek Absensi — {{ optional($profil)->singkatan ?? 'SMK Bustanul Ulum' }}</title>
  <meta name="description" content="Cek rekap absensi siswa {{ optional($profil)->nama_sekolah ?? 'SMK Bustanul Ulum' }} secara online menggunakan NIS.">

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
          keyframes: {
            fadeUp:    { from:{opacity:'0',transform:'translateY(24px)'}, to:{opacity:'1',transform:'translateY(0)'} },
            fadeIn:    { from:{opacity:'0'}, to:{opacity:'1'} },
            livePulse: { '0%,100%':{boxShadow:'0 0 0 0 rgba(56,189,248,0.55)'},'50%':{boxShadow:'0 0 0 8px rgba(56,189,248,0)'} },
          },
          animation: {
            'fade-up':    'fadeUp 0.6s cubic-bezier(.22,.68,0,1.2) both',
            'fade-in':    'fadeIn 0.5s ease both',
            'live-pulse': 'livePulse 2.2s ease-in-out infinite',
          },
        }
      }
    }
  </script>
  <style>
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'DM Sans',sans-serif; }
    h1,h2,h3,h4,.font-display { font-family:'Plus Jakarta Sans',sans-serif; }

    /* ── Hero — cyan/teal/emerald ── */
    .abs-hero {
      background: linear-gradient(140deg, #0c4a6e 0%, #0e7490 48%, #065f46 100%);
      position: relative; overflow: hidden;
    }
    .abs-hero::before {
      content:''; position:absolute; inset:0; pointer-events:none;
      background:
        radial-gradient(ellipse 600px 400px at 80% 0%,  rgba(56,189,248,.28) 0%, transparent 65%),
        radial-gradient(ellipse 400px 400px at 5% 100%, rgba(16,185,129,.20) 0%, transparent 65%);
    }
    .abs-hero::after {
      content:''; position:absolute; inset:0; pointer-events:none;
      background-image: radial-gradient(circle, rgba(255,255,255,.03) 1px, transparent 1px);
      background-size: 44px 44px;
    }

    .glass { background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.14); backdrop-filter:blur(14px); }

    .text-grad-cyan {
      background: linear-gradient(120deg, #7dd3fc 0%, #a7f3d0 50%, #86efac 100%);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
    }

    /* ── Navbar ── */
    .nav-scrolled {
      background:rgba(255,255,255,.96) !important;
      backdrop-filter:blur(18px) !important;
      border-bottom:1px solid #e2e8f0 !important;
    }
    .nav-scrolled .nl       { color:#1e293b !important; }
    .nav-scrolled .nl:hover { background:#f1f5f9 !important; }
    .nav-scrolled .nbrand   { color:#1e293b !important; }
    .nav-scrolled .nsubb    { color:#64748b !important; }
    .nav-scrolled .nring    { background:#ecfeff !important; border-color:#a5f3fc !important; }
    .nav-scrolled .ncta     { background:#0e7490 !important; color:#fff !important; }

    /* ── Form inputs ── */
    .form-input {
      width:100%; padding:0.625rem 0.875rem; border-radius:0.75rem;
      border:1.5px solid #e2e8f0; background:#fff;
      font-size:0.875rem; color:#1e293b; font-family:'DM Sans',sans-serif;
      transition:border-color .18s ease, box-shadow .18s ease; outline:none;
    }
    .form-input:focus { border-color:#0e7490; box-shadow:0 0 0 3px rgba(14,116,144,.1); }
    .form-input.error { border-color:#ef4444; box-shadow:0 0 0 3px rgba(239,68,68,.1); }
    .form-label {
      display:block; font-size:0.75rem; font-weight:700;
      font-family:'Plus Jakarta Sans',sans-serif;
      color:#475569; margin-bottom:0.375rem; letter-spacing:.02em;
    }

    /* ── Status badges ── */
    .badge-hadir  { background:#dcfce7; color:#166534; border-color:#bbf7d0; }
    .badge-telat  { background:#fef9c3; color:#854d0e; border-color:#fef08a; }
    .badge-sakit  { background:#dbeafe; color:#1d4ed8; border-color:#bfdbfe; }
    .badge-izin   { background:#e0f2fe; color:#075985; border-color:#bae6fd; }
    .badge-alfa   { background:#fee2e2; color:#991b1b; border-color:#fecaca; }

    /* ── Progress ring ── */
    .ring-track { stroke:#e2e8f0; }
    .ring-fill  { stroke-linecap:round; transform:rotate(-90deg); transform-origin:50% 50%; transition:stroke-dashoffset 1.2s cubic-bezier(.22,.68,0,1.2); }

    /* ── Tabel ── */
    .abs-table th { font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; }
    .abs-row { transition:background .15s ease; }
    .abs-row:hover { background:#f0fdfa; }

    /* scroll reveal */
    .sr { opacity:0; transform:translateY(22px); transition:opacity .5s ease, transform .5s ease; }

    .section-label {
      display:inline-block; text-transform:uppercase; letter-spacing:.12em;
      font-size:11px; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif;
    }

    @media print {
      header, .no-print { display:none !important; }
      .abs-hero { background:#0e7490 !important; -webkit-print-color-adjust:exact; }
      body { background:#fff; }
    }
  </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

{{-- ═══════ NAVBAR ═══════ --}}
<header id="nav" class="fixed inset-x-0 top-0 z-50 transition-all duration-300 no-print">
  <div class="max-w-7xl mx-auto px-5 h-16 flex items-center justify-between gap-4">

    <a href="{{ url('/') }}" class="flex items-center gap-2.5 shrink-0">
      <div class="nring w-9 h-9 rounded-xl border border-white/20 bg-white/10 flex items-center justify-center transition-all duration-300 overflow-hidden">
        @if(optional($profil)->logo_path)
          <img src="{{ asset('storage/'.$profil->logo_path) }}" alt="Logo" class="w-full h-full object-contain">
        @elseif(optional($profil)->logo_url)
          <img src="{{ $profil->logo_url }}" alt="Logo" class="w-full h-full object-contain">
        @else
          <span class="font-display font-extrabold text-white text-sm">
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
<section class="abs-hero pt-16">
  <div class="max-w-3xl mx-auto px-5 py-20 relative z-10 text-center">

    <div class="animate-fade-up inline-flex items-center gap-2 glass text-white/85 text-[11px] font-display font-semibold px-4 py-2 rounded-full mb-6 tracking-wider uppercase">
      <span class="animate-live-pulse w-2 h-2 rounded-full bg-cyan-400 shrink-0"></span>
      Portal Absensi Siswa
    </div>

    <h1 class="animate-fade-up [animation-delay:.1s] font-display font-extrabold text-4xl sm:text-5xl leading-[1.15] text-white mb-4">
      Cek Rekap <span class="text-grad-cyan">Absensi Online</span>
    </h1>

    <p class="animate-fade-up [animation-delay:.2s] text-white/60 text-base leading-relaxed mb-10 max-w-lg mx-auto">
      Masukkan NIS, pilih tahun ajaran, dan filter bulan untuk melihat rekap kehadiran lengkap Anda.
    </p>

    {{-- Form Pencarian --}}
    <div class="animate-fade-up [animation-delay:.3s] bg-white rounded-2xl shadow-[0_8px_40px_rgba(0,0,0,.15)] p-6 sm:p-8 text-left">

      @if($errors->has('nis'))
      <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-5">
        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <p class="text-sm font-semibold">{{ $errors->first('nis') }}</p>
      </div>
      @endif

      <form action="{{ route('absensi.cek') }}" method="POST" id="absForm">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">

          {{-- NIS --}}
          <div class="sm:col-span-1">
            <label class="form-label" for="nis">NIS Siswa <span class="text-red-500">*</span></label>
            <input type="text" id="nis" name="nis"
                   value="{{ old('nis') }}"
                   placeholder="Contoh: 2024001"
                   class="form-input {{ $errors->has('nis') ? 'error' : '' }}"
                   required autocomplete="off">
          </div>

          {{-- Tahun Ajaran --}}
          @php
            $selectedTaId = old('tahun_ajaran_id', isset($tahunAjaran) ? $tahunAjaran->id : '');
          @endphp
          <div class="sm:col-span-1">
            <label class="form-label" for="tahun_ajaran_id">Tahun Ajaran <span class="text-red-500">*</span></label>
            <select id="tahun_ajaran_id" name="tahun_ajaran_id"
                    class="form-input {{ $errors->has('tahun_ajaran_id') ? 'error' : '' }}" required>
              <option value="">-- Pilih --</option>
              @foreach($tahunAjaranList as $ta)
              <option value="{{ $ta->id }}" {{ $selectedTaId == $ta->id ? 'selected' : '' }}>
                {{ $ta->label }}{{ $ta->isAktif() ? ' (Aktif)' : '' }}
              </option>
              @endforeach
            </select>
          </div>

          {{-- Filter Bulan (opsional) --}}
          <div class="sm:col-span-1">
            <label class="form-label" for="bulan">Filter Bulan <span class="text-slate-400 font-normal">(opsional)</span></label>
            <select id="bulan" name="bulan" class="form-input">
              <option value="">Semua Bulan</option>
              @isset($bulanList)
                @foreach($bulanList as $bl)
                <option value="{{ $bl['value'] }}" {{ old('bulan', $bulanDipilih ?? '') == $bl['value'] ? 'selected' : '' }}>
                  {{ $bl['label'] }}
                </option>
                @endforeach
              @else
                @foreach(['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $v => $l)
                <option value="{{ $v }}" {{ old('bulan', $bulanDipilih ?? '') == $v ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
              @endisset
            </select>
          </div>

          {{-- Submit --}}
          <div>
            <button type="submit" id="absBtn"
                    class="w-full inline-flex items-center justify-center gap-2 bg-cyan-700 hover:bg-cyan-800 active:bg-cyan-900 text-white font-display font-bold text-sm px-6 py-[0.625rem] rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
              <svg class="w-4 h-4" id="absIcon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
              <svg class="w-4 h-4 animate-spin hidden" id="absSpinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
              <span id="absLabel">Cek Absensi</span>
            </button>
          </div>
        </div>
      </form>

      <p class="text-slate-400 text-xs mt-4 flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        Data absensi bersifat pribadi. Pastikan Anda memasukkan NIS yang benar.
      </p>
    </div>
  </div>

  <div class="-mb-px">
    <svg viewBox="0 0 1440 56" xmlns="http://www.w3.org/2000/svg" class="w-full block">
      <path d="M0,28 C360,56 720,0 1080,28 C1260,42 1380,14 1440,28 L1440,56 L0,56 Z" fill="#f8fafc"/>
    </svg>
  </div>
</section>

{{-- ═══════ HASIL ABSENSI ═══════ --}}
@isset($siswa)
<section class="bg-slate-50 py-12" id="hasil">
  <div class="max-w-5xl mx-auto px-5">

    {{-- Identitas siswa --}}
    <div class="sr bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6 flex flex-col sm:flex-row items-start sm:items-center gap-5">
      <div class="shrink-0">
        <img src="{{ $siswa->foto_url }}" alt="{{ $siswa->nama_lengkap }}"
             class="w-16 h-16 rounded-2xl object-cover border-2 border-cyan-100 shadow-sm">
      </div>
      <div class="flex-1 min-w-0">
        <div class="flex flex-wrap items-center gap-2 mb-1">
          <h2 class="font-display font-extrabold text-xl text-slate-900">{{ $siswa->nama_lengkap }}</h2>
          <span class="inline-flex items-center text-[10px] font-bold px-2.5 py-1 rounded-full
            {{ $siswa->status === 'aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
            {{ $siswa->label_status }}
          </span>
        </div>
        <div class="flex flex-wrap gap-x-5 gap-y-1 text-slate-500 text-xs">
          <span class="flex items-center gap-1">
            <svg class="w-3 h-3 text-cyan-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M7 8h.01M11 8h6M7 12h.01M11 12h6"/></svg>
            NIS: <strong class="text-slate-700">{{ $siswa->nis }}</strong>
          </span>
          @if($siswa->kelas)
          <span class="flex items-center gap-1">
            <svg class="w-3 h-3 text-cyan-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
            Kelas: <strong class="text-slate-700">{{ $siswa->kelas->nama_kelas ?? $siswa->kelas->nama }}</strong>
          </span>
          @endif
        </div>
      </div>
      <div class="shrink-0 bg-cyan-50 border border-cyan-100 rounded-xl px-4 py-3 text-center">
        <p class="text-[10px] font-bold text-cyan-600 uppercase tracking-wider">Tahun Ajaran</p>
        <p class="font-display font-extrabold text-cyan-900 text-sm mt-0.5">{{ $tahunAjaran->label }}</p>
        @if($bulanDipilih)
        <p class="text-[10px] text-cyan-500 mt-0.5">
          {{ collect($bulanList ?? [])->firstWhere('value', $bulanDipilih)['label'] ?? '' }}
        </p>
        @endif
      </div>
    </div>

    @if($totalHari > 0)

    {{-- Ringkasan statistik + ring --}}
    <div class="sr grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

      {{-- Ring persentase --}}
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col items-center justify-center">
        <div class="relative w-28 h-28">
          @php
            $r = 46; $circ = 2 * M_PI * $r;
            $offset = $circ - ($persentase / 100) * $circ;
            $ringColor = $persentase >= 85 ? '#22c55e' : ($persentase >= 70 ? '#f59e0b' : '#ef4444');
          @endphp
          <svg viewBox="0 0 100 100" class="w-full h-full">
            <circle class="ring-track" cx="50" cy="50" r="{{ $r }}" fill="none" stroke-width="8"/>
            <circle class="ring-fill" cx="50" cy="50" r="{{ $r }}" fill="none" stroke-width="8"
                    stroke="{{ $ringColor }}"
                    stroke-dasharray="{{ $circ }}"
                    stroke-dashoffset="{{ $offset }}"
                    id="ringCircle"/>
          </svg>
          <div class="absolute inset-0 flex flex-col items-center justify-center">
            <span class="font-display font-extrabold text-xl" style="color:{{ $ringColor }}">{{ $persentase }}%</span>
          </div>
        </div>
        <p class="font-display font-bold text-slate-700 text-sm mt-3">Kehadiran</p>
        @php
          $statusKehadiran = $persentase >= 85 ? ['Baik','text-emerald-600','bg-emerald-50 border-emerald-200']
                          : ($persentase >= 70 ? ['Cukup','text-amber-600','bg-amber-50 border-amber-200']
                          :                      ['Perlu Perhatian','text-red-600','bg-red-50 border-red-200']);
        @endphp
        <span class="mt-1.5 text-[10px] font-bold px-2.5 py-1 rounded-full border {{ $statusKehadiran[2] }} {{ $statusKehadiran[1] }}">
          {{ $statusKehadiran[0] }}
        </span>
      </div>

      {{-- Grid rekap --}}
      <div class="sm:col-span-2 grid grid-cols-2 sm:grid-cols-3 gap-3">
        @foreach([
          ['Hadir',  $totalHadir,  'text-emerald-600','bg-emerald-50','border-emerald-100','M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
          ['Telat',  $totalTelat,  'text-amber-600',  'bg-amber-50',  'border-amber-100',  'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
          ['Sakit',  $totalSakit,  'text-blue-600',   'bg-blue-50',   'border-blue-100',   'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
          ['Izin',   $totalIzin,   'text-sky-600',    'bg-sky-50',    'border-sky-100',    'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
          ['Alfa',   $totalAlfa,   'text-red-600',    'bg-red-50',    'border-red-100',    'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
          ['Total',  $totalHari,   'text-slate-700',  'bg-slate-50',  'border-slate-200',  'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ] as [$label, $val, $tc, $bg, $border, $icon])
        <div class="rounded-xl border p-4 {{ $bg }} {{ $border }}">
          <svg class="w-5 h-5 {{ $tc }} mb-2" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="{{ $icon }}"/></svg>
          <p class="font-display font-extrabold text-2xl {{ $tc }}">{{ $val }}</p>
          <p class="text-slate-500 text-xs mt-0.5">{{ $label }}</p>
        </div>
        @endforeach
      </div>
    </div>

    {{-- Rekap per bulan (jika tampil semua) --}}
    @if(! $bulanDipilih && $perBulan->count() > 1)
    <div class="sr bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
      <div class="px-6 py-4 border-b border-slate-100">
        <h3 class="font-display font-bold text-slate-900">Rekap Per Bulan</h3>
        <p class="text-slate-400 text-xs mt-0.5">Ringkasan kehadiran per bulan dalam tahun ajaran ini</p>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full abs-table">
          <thead class="bg-slate-50 border-b border-slate-100">
            <tr>
              <th class="text-left px-5 py-3 text-slate-500">Bulan</th>
              <th class="text-center px-3 py-3 text-emerald-600">Hadir</th>
              <th class="text-center px-3 py-3 text-amber-600">Telat</th>
              <th class="text-center px-3 py-3 text-blue-600">Sakit</th>
              <th class="text-center px-3 py-3 text-sky-600">Izin</th>
              <th class="text-center px-3 py-3 text-red-600">Alfa</th>
              <th class="text-center px-3 py-3 text-slate-500">Total</th>
              <th class="text-center px-3 py-3 text-slate-500">%</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-50">
            @foreach($perBulan as $pb)
            @php
              $pctBulan = $pb['total'] > 0
                ? round((($pb['hadir'] + $pb['telat']) / $pb['total']) * 100, 1)
                : 0;
              $pctColor = $pctBulan >= 85 ? 'text-emerald-600' : ($pctBulan >= 70 ? 'text-amber-600' : 'text-red-500');
            @endphp
            <tr class="abs-row">
              <td class="px-5 py-3 font-display font-semibold text-slate-800 text-sm">{{ $pb['label'] }}</td>
              <td class="px-3 py-3 text-center text-sm font-semibold text-emerald-600">{{ $pb['hadir'] }}</td>
              <td class="px-3 py-3 text-center text-sm font-semibold text-amber-600">{{ $pb['telat'] }}</td>
              <td class="px-3 py-3 text-center text-sm font-semibold text-blue-600">{{ $pb['sakit'] }}</td>
              <td class="px-3 py-3 text-center text-sm font-semibold text-sky-600">{{ $pb['izin'] }}</td>
              <td class="px-3 py-3 text-center text-sm font-semibold text-red-600">{{ $pb['alfa'] }}</td>
              <td class="px-3 py-3 text-center text-sm text-slate-500">{{ $pb['total'] }}</td>
              <td class="px-3 py-3 text-center font-display font-bold text-sm {{ $pctColor }}">{{ $pctBulan }}%</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif

    {{-- Tabel detail harian --}}
    <div class="sr bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
      <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
        <div>
          <h3 class="font-display font-bold text-slate-900">Detail Kehadiran Harian</h3>
          <p class="text-slate-400 text-xs mt-0.5">{{ $totalHari }} hari tercatat</p>
        </div>
        <button onclick="window.print()"
                class="no-print inline-flex items-center gap-1.5 text-xs font-semibold font-display text-cyan-700 border border-cyan-200 bg-cyan-50 px-4 py-2 rounded-lg hover:bg-cyan-100 transition-all">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
          Cetak / PDF
        </button>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full abs-table">
          <thead class="bg-slate-50 border-b border-slate-100">
            <tr>
              <th class="text-left px-5 py-3 text-slate-500">No</th>
              <th class="text-left px-5 py-3 text-slate-500">Tanggal</th>
              <th class="text-center px-4 py-3 text-slate-500">Hari</th>
              <th class="text-center px-4 py-3 text-slate-500">Status</th>
              <th class="text-center px-4 py-3 text-slate-500">Jam Masuk</th>
              <th class="text-center px-4 py-3 text-slate-500">Jam Keluar</th>
              <th class="text-left px-4 py-3 text-slate-500">Keterangan</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-50">
            @foreach($absensiList as $i => $ab)
            @php
              $badgeClass = match($ab->status) {
                'hadir'  => 'badge-hadir',
                'telat'  => 'badge-telat',
                'sakit'  => 'badge-sakit',
                'izin'   => 'badge-izin',
                default  => 'badge-alfa',
              };
              $labelStatus = match($ab->status) {
                'hadir' => 'Hadir',
                'telat' => 'Telat',
                'sakit' => 'Sakit',
                'izin'  => 'Izin',
                'alfa'  => 'Alfa',
                default => ucfirst($ab->status),
              };
            @endphp
            <tr class="abs-row">
              <td class="px-5 py-3 text-slate-400 text-sm">{{ $i + 1 }}</td>
              <td class="px-5 py-3">
                <p class="font-display font-semibold text-slate-800 text-sm">
                  {{ $ab->tanggal->translatedFormat('d F Y') }}
                </p>
              </td>
              <td class="px-4 py-3 text-center text-sm text-slate-500">
                {{ $ab->tanggal->translatedFormat('l') }}
              </td>
              <td class="px-4 py-3 text-center">
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg border text-xs font-bold {{ $badgeClass }}">
                  {{ $labelStatus }}
                </span>
              </td>
              <td class="px-4 py-3 text-center text-sm text-slate-600">
                {{ $ab->jam_masuk ? \Carbon\Carbon::parse($ab->jam_masuk)->format('H:i') : '-' }}
              </td>
              <td class="px-4 py-3 text-center text-sm text-slate-600">
                {{ $ab->jam_keluar ? \Carbon\Carbon::parse($ab->jam_keluar)->format('H:i') : '-' }}
              </td>
              <td class="px-4 py-3 text-sm text-slate-500 max-w-[180px] truncate">
                {{ $ab->keterangan ?: '-' }}
                @if($ab->surat_izin_url)
                <a href="{{ $ab->surat_izin_url }}" target="_blank"
                   class="ml-1 text-cyan-600 hover:underline text-xs font-semibold">Surat</a>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    {{-- Keterangan status --}}
    <div class="sr grid grid-cols-2 sm:grid-cols-5 gap-2 text-center text-xs">
      @foreach([
        ['Hadir', 'Masuk tepat waktu', 'badge-hadir'],
        ['Telat', 'Masuk terlambat',   'badge-telat'],
        ['Sakit', 'Tidak masuk sakit', 'badge-sakit'],
        ['Izin',  'Tidak masuk izin',  'badge-izin'],
        ['Alfa',  'Tanpa keterangan',  'badge-alfa'],
      ] as [$s, $desc, $cls])
      <div class="rounded-xl border p-3 {{ $cls }}">
        <p class="font-display font-extrabold text-sm">{{ $s }}</p>
        <p class="opacity-70 text-[10px] mt-0.5">{{ $desc }}</p>
      </div>
      @endforeach
    </div>

    @else
    {{-- Tidak ada data --}}
    <div class="sr text-center py-16 bg-white rounded-2xl border border-slate-200 shadow-sm">
      <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      </div>
      <h3 class="font-display font-bold text-slate-700 text-lg mb-2">Belum Ada Data Absensi</h3>
      <p class="text-slate-400 text-sm">
        Data absensi untuk tahun ajaran
        <strong>{{ $tahunAjaran->label }}</strong>
        @if($bulanDipilih)
        pada bulan yang dipilih
        @endif
        belum tersedia.
      </p>
    </div>
    @endif

  </div>
</section>
@endisset

{{-- ═══════ INFO (jika belum ada hasil) ═══════ --}}
@unless(isset($siswa))
<section class="bg-white border-t border-slate-100 py-16">
  <div class="max-w-3xl mx-auto px-5">
    <div class="text-center mb-10 sr">
      <span class="section-label text-cyan-700 bg-cyan-50 border border-cyan-100 px-4 py-1.5 rounded-full mb-3 inline-block">Panduan</span>
      <h2 class="font-display font-extrabold text-2xl text-slate-900">Cara Cek Absensi</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
      @foreach([
        ['1','Masukkan NIS','Masukkan Nomor Induk Siswa (NIS) yang tertera di kartu pelajar Anda.','🔢'],
        ['2','Pilih Tahun Ajaran','Pilih tahun ajaran dan opsional filter bulan tertentu.','📅'],
        ['3','Lihat Rekap','Rekap kehadiran lengkap beserta persentase akan ditampilkan.','📋'],
      ] as [$no, $judul, $desk, $ikon])
      <div class="sr bg-slate-50 rounded-2xl border border-slate-100 p-5 text-center">
        <div class="w-12 h-12 rounded-2xl bg-cyan-100 border border-cyan-200 flex items-center justify-center mx-auto mb-4 text-2xl">{{ $ikon }}</div>
        <p class="font-display font-extrabold text-xs text-cyan-600 uppercase tracking-widest mb-1">Langkah {{ $no }}</p>
        <h4 class="font-display font-bold text-slate-800 text-sm mb-2">{{ $judul }}</h4>
        <p class="text-slate-500 text-xs leading-relaxed">{{ $desk }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endunless

{{-- ═══════ FOOTER ═══════ --}}
<footer class="bg-slate-900 border-t border-slate-800 py-6 no-print">
  <div class="max-w-7xl mx-auto px-5 flex flex-col sm:flex-row items-center justify-between gap-3">
    <p class="text-slate-500 text-xs">© {{ date('Y') }} SmartSchool {{ optional($profil)->nama_sekolah ?? 'SMK Bustanul Ulum' }}</p>
    <div class="flex gap-5">
      <a href="{{ url('/') }}"          class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Beranda</a>
      <a href="{{ url('/nilai') }}"     class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Cek Nilai</a>
      <a href="{{ url('/elearning') }}" class="text-slate-500 hover:text-slate-300 text-xs transition-colors">E-Learning</a>
      <a href="{{ route('login') }}"    class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Login</a>
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

  // Submit loading
  const absForm = document.getElementById('absForm');
  if (absForm) {
    absForm.addEventListener('submit', () => {
      const btn     = document.getElementById('absBtn');
      const icon    = document.getElementById('absIcon');
      const spinner = document.getElementById('absSpinner');
      const label   = document.getElementById('absLabel');
      if (btn) {
        btn.disabled = true;
        icon.classList.add('hidden');
        spinner.classList.remove('hidden');
        label.textContent = 'Mencari...';
      }
    });
  }

  // Scroll reveal
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (e.isIntersecting) {
        const el = e.target;
        setTimeout(() => {
          el.style.opacity = '1';
          el.style.transform = 'translateY(0)';
        }, el.dataset.delay || 0);
        io.unobserve(el);
      }
    });
  }, { threshold: 0.07 });
  document.querySelectorAll('.sr').forEach((el, i) => {
    el.dataset.delay = (i % 6) * 80;
    io.observe(el);
  });

  // Auto scroll ke hasil
  @isset($siswa)
  window.addEventListener('load', () => {
    const hasil = document.getElementById('hasil');
    if (hasil) setTimeout(() => hasil.scrollIntoView({ behavior:'smooth', block:'start' }), 300);
  });
  @endisset
</script>
</body>
</html>