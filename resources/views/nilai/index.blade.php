<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cek Nilai — {{ optional($profil)->singkatan ?? 'SMK Bustanul Ulum' }}</title>
  <meta name="description" content="Cek nilai rapor siswa {{ optional($profil)->nama_sekolah ?? 'SMK Bustanul Ulum' }} secara online menggunakan NIS.">

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
            fadeUp:    { from:{opacity:'0',transform:'translateY(24px)'}, to:{opacity:'1',transform:'translateY(0)'} },
            fadeIn:    { from:{opacity:'0'}, to:{opacity:'1'} },
            livePulse: { '0%,100%':{boxShadow:'0 0 0 0 rgba(74,222,128,0.55)'},'50%':{boxShadow:'0 0 0 8px rgba(74,222,128,0)'} },
            slideUp:   { from:{opacity:'0',transform:'translateY(40px)'}, to:{opacity:'1',transform:'translateY(0)'} },
          },
          animation: {
            'fade-up':    'fadeUp 0.6s cubic-bezier(.22,.68,0,1.2) both',
            'fade-in':    'fadeIn 0.5s ease both',
            'live-pulse': 'livePulse 2.2s ease-in-out infinite',
            'slide-up':   'slideUp 0.65s cubic-bezier(.22,.68,0,1.2) both',
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
    .nilai-hero {
      background: linear-gradient(140deg, #1e1b4b 0%, #3730a3 48%, #0a6b4a 100%);
      position: relative; overflow: hidden;
    }
    .nilai-hero::before {
      content:''; position:absolute; inset:0; pointer-events:none;
      background:
        radial-gradient(ellipse 600px 400px at 80% 0%,  rgba(139,92,246,.30) 0%, transparent 65%),
        radial-gradient(ellipse 400px 400px at 5% 100%, rgba(16,185,129,.20) 0%, transparent 65%);
    }
    .nilai-hero::after {
      content:''; position:absolute; inset:0; pointer-events:none;
      background-image: radial-gradient(circle, rgba(255,255,255,.03) 1px, transparent 1px);
      background-size: 44px 44px;
    }

    /* ── Glass ── */
    .glass { background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.14); backdrop-filter:blur(14px); }

    /* ── Gradient text ── */
    .text-grad-violet {
      background: linear-gradient(120deg, #c4b5fd 0%, #a5f3fc 50%, #6ee7b7 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
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
    .nav-scrolled .nring    { background:#eef6ff !important; border-color:#bfdbfe !important; }
    .nav-scrolled .nrtext   { color:#1750c0 !important; }
    .nav-scrolled .ncta     { background:#1f63db !important; color:#fff !important; border-color:#1f63db !important; }
    .nav-scrolled .hbar     { background:#334155 !important; }

    /* ── Form inputs ── */
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
      border-color: #6d28d9;
      box-shadow: 0 0 0 3px rgba(109,40,217,.1);
    }
    .form-input.error { border-color:#ef4444; box-shadow:0 0 0 3px rgba(239,68,68,.1); }
    .form-label {
      display: block; font-size: 0.75rem; font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: #475569; margin-bottom: 0.375rem; letter-spacing: .02em;
    }
    .form-error { font-size:0.7rem; color:#ef4444; margin-top:0.25rem; font-weight:600; }

    /* ── Predikat colors ── */
    .pred-A { background:#dcfce7; color:#166534; border-color:#bbf7d0; }
    .pred-B { background:#dbeafe; color:#1d4ed8; border-color:#bfdbfe; }
    .pred-C { background:#fef9c3; color:#854d0e; border-color:#fef08a; }
    .pred-D { background:#fed7aa; color:#9a3412; border-color:#fdba74; }
    .pred-E { background:#fee2e2; color:#991b1b; border-color:#fecaca; }

    /* ── Nilai bar ── */
    .nilai-bar-wrap { background:#f1f5f9; border-radius:99px; height:6px; overflow:hidden; }
    .nilai-bar      { height:6px; border-radius:99px; transition:width 1s cubic-bezier(.22,.68,0,1.2); }

    /* ── Table ── */
    .nilai-table th { font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; }
    .nilai-row { transition:background .15s ease; }
    .nilai-row:hover { background:#f8fafc; }

    /* scroll reveal */
    .sr { opacity:0; transform:translateY(22px); transition: opacity .5s ease, transform .5s ease; }

    .section-label {
      display:inline-block; text-transform:uppercase; letter-spacing:.12em;
      font-size:11px; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif;
    }

    /* Print styles */
    @media print {
      header, .no-print { display:none !important; }
      .nilai-hero { background:#3730a3 !important; -webkit-print-color-adjust:exact; }
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
          <span class="nrtext font-display font-extrabold text-white text-sm">
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
      <a href="{{ url('/') }}"           class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Beranda</a>
      <a href="{{ url('/ppdb') }}"       class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">PPDB</a>
      <a href="{{ url('/elearning') }}"  class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">E-Learning</a>
      <a href="#"                        class="nl text-white font-semibold text-sm px-3 py-2 rounded-lg bg-white/10 transition-all">Cek Nilai</a>
      <a href="{{ url('/') }}#kontak"    class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Kontak</a>
    </nav>

    <a href="{{ route('login') }}" class="ncta hidden md:inline-flex items-center gap-1.5 text-sm font-semibold font-display text-white border border-white/30 hover:border-white/60 hover:bg-white/12 px-5 py-2 rounded-xl transition-all duration-200">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
      Masuk
    </a>
  </div>
</header>

{{-- ═══════ HERO ═══════ --}}
<section class="nilai-hero pt-16">
  <div class="max-w-3xl mx-auto px-5 py-20 relative z-10 text-center">

    <div class="animate-fade-up inline-flex items-center gap-2 glass text-white/85 text-[11px] font-display font-semibold px-4 py-2 rounded-full mb-6 tracking-wider uppercase">
      <span class="animate-live-pulse w-2 h-2 rounded-full bg-violet-400 shrink-0"></span>
      Portal Nilai Siswa
    </div>

    <h1 class="animate-fade-up [animation-delay:.1s] font-display font-extrabold text-4xl sm:text-5xl leading-[1.15] text-white mb-4">
      Cek Nilai <span class="text-grad-violet">Rapor Online</span>
    </h1>

    <p class="animate-fade-up [animation-delay:.2s] text-white/60 text-base leading-relaxed mb-10 max-w-lg mx-auto">
      Masukkan NIS dan pilih tahun ajaran untuk melihat rekap nilai lengkap Anda secara real-time.
    </p>

    {{-- ── Form Pencarian ── --}}
    <div class="animate-fade-up [animation-delay:.3s] bg-white rounded-2xl shadow-[0_8px_40px_rgba(0,0,0,.15)] p-6 sm:p-8 text-left">

      @if($errors->has('nis'))
      <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-5">
        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <p class="text-sm font-semibold">{{ $errors->first('nis') }}</p>
      </div>
      @endif

      <form action="{{ route('nilai.cek') }}" method="POST" id="nilaiForm">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">

          {{-- NIS --}}
          <div class="sm:col-span-1">
            <label class="form-label" for="nis">
              NIS Siswa <span class="text-red-500">*</span>
            </label>
            <input type="text"
                   id="nis"
                   name="nis"
                   value="{{ old('nis') }}"
                   placeholder="Contoh: 2024001"
                   class="form-input {{ $errors->has('nis') ? 'error' : '' }}"
                   required
                   autocomplete="off">
          </div>

          {{-- Tahun Ajaran --}}
          {{--
            FIX: Gunakan $tahunAjaranList (Collection) untuk looping dropdown.
                 Gunakan $tahunAjaran (single Model, hanya ada setelah submit) untuk nilai selected.
                 Dengan begitu tidak ada risiko memanggil ->id pada Collection.
          --}}
          <div class="sm:col-span-1">
            <label class="form-label" for="tahun_ajaran_id">
              Tahun Ajaran <span class="text-red-500">*</span>
            </label>
            @php
              // $tahunAjaranList  → Collection (selalu ada, dari index() maupun cek())
              // $tahunAjaran      → Model single (hanya ada setelah cek() berhasil)
              $selectedTaId = old(
                  'tahun_ajaran_id',
                  isset($tahunAjaran) ? $tahunAjaran->id : ''
              );
            @endphp
            <select id="tahun_ajaran_id"
                    name="tahun_ajaran_id"
                    class="form-input {{ $errors->has('tahun_ajaran_id') ? 'error' : '' }}"
                    required>
              <option value="">-- Pilih --</option>
              @foreach($tahunAjaranList as $ta)
              <option value="{{ $ta->id }}" {{ $selectedTaId == $ta->id ? 'selected' : '' }}>
                {{ $ta->label }}{{ $ta->isAktif() ? ' (Aktif)' : '' }}
              </option>
              @endforeach
            </select>
          </div>

          {{-- Submit --}}
          <div>
            <button type="submit"
                    id="cekBtn"
                    class="w-full inline-flex items-center justify-center gap-2 bg-violet-600 hover:bg-violet-700 active:bg-violet-800 text-white font-display font-bold text-sm px-6 py-[0.625rem] rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
              <svg class="w-4 h-4" id="cekIcon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
              <svg class="w-4 h-4 animate-spin hidden" id="cekSpinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
              <span id="cekLabel">Cek Nilai</span>
            </button>
          </div>
        </div>
      </form>

      <p class="text-slate-400 text-xs mt-4 flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5 text-violet-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        Data nilai bersifat pribadi. Pastikan Anda memasukkan NIS yang benar.
      </p>
    </div>
  </div>

  {{-- Wave --}}
  <div class="-mb-px">
    <svg viewBox="0 0 1440 56" xmlns="http://www.w3.org/2000/svg" class="w-full block">
      <path d="M0,28 C360,56 720,0 1080,28 C1260,42 1380,14 1440,28 L1440,56 L0,56 Z" fill="#f8fafc"/>
    </svg>
  </div>
</section>

{{-- ═══════ HASIL NILAI ═══════ --}}
@isset($siswa)
<section class="bg-slate-50 py-12" id="hasil">
  <div class="max-w-5xl mx-auto px-5">

    {{-- Header identitas siswa --}}
    <div class="sr bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6 flex flex-col sm:flex-row items-start sm:items-center gap-5">

      {{-- Foto --}}
      <div class="shrink-0">
        <img src="{{ $siswa->foto_url }}"
             alt="{{ $siswa->nama_lengkap }}"
             class="w-16 h-16 rounded-2xl object-cover border-2 border-violet-100 shadow-sm">
      </div>

      {{-- Info --}}
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
            <svg class="w-3 h-3 text-violet-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M7 8h.01M11 8h6M7 12h.01M11 12h6M7 16h.01M11 16h6"/></svg>
            NIS: <strong class="text-slate-700">{{ $siswa->nis }}</strong>
          </span>
          @if($siswa->nisn)
          <span class="flex items-center gap-1">
            <svg class="w-3 h-3 text-violet-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
            NISN: <strong class="text-slate-700">{{ $siswa->nisn }}</strong>
          </span>
          @endif
          @if($siswa->kelas)
          <span class="flex items-center gap-1">
            <svg class="w-3 h-3 text-violet-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
            Kelas: <strong class="text-slate-700">{{ $siswa->kelas->nama_kelas ?? $siswa->kelas->nama }}</strong>
          </span>
          @endif
        </div>
      </div>

      {{-- Tahun Ajaran badge --}}
      <div class="shrink-0 bg-violet-50 border border-violet-100 rounded-xl px-4 py-3 text-center">
        <p class="text-[10px] font-bold text-violet-500 uppercase tracking-wider">Tahun Ajaran</p>
        <p class="font-display font-extrabold text-violet-800 text-sm mt-0.5">
          {{ $tahunAjaran->label }}
        </p>
      </div>
    </div>

    @if($nilaiList->count() > 0)

    {{-- Ringkasan stats --}}
    <div class="sr grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
      <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm text-center">
        <p class="font-display font-extrabold text-2xl text-violet-600">{{ number_format($rataRata, 1) }}</p>
        <p class="text-slate-500 text-xs mt-1">Rata-rata Nilai</p>
      </div>
      <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm text-center">
        <p class="font-display font-extrabold text-2xl text-emerald-600">{{ number_format($nilaiTertinggi, 1) }}</p>
        <p class="text-slate-500 text-xs mt-1">Nilai Tertinggi</p>
      </div>
      <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm text-center">
        <p class="font-display font-extrabold text-2xl text-amber-600">{{ number_format($nilaiTerendah, 1) }}</p>
        <p class="text-slate-500 text-xs mt-1">Nilai Terendah</p>
      </div>
      <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm text-center">
        <p class="font-display font-extrabold text-2xl text-brand-600">{{ $jumlahLulus }}/{{ $nilaiList->count() }}</p>
        <p class="text-slate-500 text-xs mt-1">Mata Pelajaran Lulus</p>
      </div>
    </div>

    {{-- Tabel nilai --}}
    <div class="sr bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
      <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
        <div>
          <h3 class="font-display font-bold text-slate-900">Rekap Nilai Lengkap</h3>
          <p class="text-slate-400 text-xs mt-0.5">{{ $nilaiList->count() }} mata pelajaran</p>
        </div>
        <button onclick="window.print()"
                class="no-print inline-flex items-center gap-1.5 text-xs font-semibold font-display text-violet-600 border border-violet-200 bg-violet-50 px-4 py-2 rounded-lg hover:bg-violet-100 transition-all">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
          Cetak / PDF
        </button>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full nilai-table">
          <thead class="bg-slate-50 border-b border-slate-100">
            <tr>
              <th class="text-left px-5 py-3 text-slate-500">No</th>
              <th class="text-left px-5 py-3 text-slate-500">Mata Pelajaran</th>
              <th class="text-center px-4 py-3 text-slate-500">Tugas<br><span class="font-normal normal-case tracking-normal text-[10px]">(20%)</span></th>
              <th class="text-center px-4 py-3 text-slate-500">Harian<br><span class="font-normal normal-case tracking-normal text-[10px]">(30%)</span></th>
              <th class="text-center px-4 py-3 text-slate-500">UTS<br><span class="font-normal normal-case tracking-normal text-[10px]">(20%)</span></th>
              <th class="text-center px-4 py-3 text-slate-500">UAS<br><span class="font-normal normal-case tracking-normal text-[10px]">(30%)</span></th>
              <th class="text-center px-4 py-3 text-slate-500">Akhir</th>
              <th class="text-center px-4 py-3 text-slate-500">Predikat</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-50">
            @foreach($nilaiList as $i => $n)
            @php
              $pct      = min(100, ($n->nilai_akhir ?? 0));
              $barColor = $pct >= 80 ? '#22c55e' : ($pct >= 70 ? '#3b82f6' : ($pct >= 60 ? '#f59e0b' : '#ef4444'));
              $predClass = 'pred-'.($n->predikat ?? 'E');
            @endphp
            <tr class="nilai-row">
              <td class="px-5 py-4 text-slate-400 text-sm">{{ $i + 1 }}</td>
              <td class="px-5 py-4">
                <p class="font-display font-semibold text-slate-800 text-sm">
                  {{ optional($n->mataPelajaran)->nama_mapel ?? '-' }}
                </p>
                @if($n->guru)
                <p class="text-slate-400 text-xs mt-0.5">{{ optional($n->guru)->nama_lengkap ?? optional($n->guru)->nama }}</p>
                @endif
                <div class="nilai-bar-wrap mt-2 max-w-[140px]">
                  <div class="nilai-bar" style="width:{{ $pct }}%; background:{{ $barColor }};"></div>
                </div>
              </td>
              <td class="px-4 py-4 text-center text-sm text-slate-700">{{ $n->nilai_tugas  ?? '-' }}</td>
              <td class="px-4 py-4 text-center text-sm text-slate-700">{{ $n->nilai_harian ?? '-' }}</td>
              <td class="px-4 py-4 text-center text-sm text-slate-700">{{ $n->nilai_uts    ?? '-' }}</td>
              <td class="px-4 py-4 text-center text-sm text-slate-700">{{ $n->nilai_uas    ?? '-' }}</td>
              <td class="px-4 py-4 text-center">
                <span class="font-display font-extrabold text-base {{ $pct >= 70 ? 'text-emerald-600' : 'text-red-500' }}">
                  {{ number_format($n->nilai_akhir ?? 0, 1) }}
                </span>
              </td>
              <td class="px-4 py-4 text-center">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg border font-display font-extrabold text-sm {{ $predClass }}">
                  {{ $n->predikat ?? '-' }}
                </span>
              </td>
            </tr>
            @endforeach
          </tbody>

          {{-- Footer rata-rata --}}
          <tfoot class="bg-violet-50 border-t-2 border-violet-100">
            <tr>
              <td colspan="6" class="px-5 py-3 font-display font-bold text-violet-700 text-sm">Rata-rata Keseluruhan</td>
              <td class="px-4 py-3 text-center font-display font-extrabold text-violet-700 text-base">
                {{ number_format($rataRata, 1) }}
              </td>
              <td class="px-4 py-3 text-center">
                @php
                  $predRata = match(true) {
                    $rataRata >= 90 => 'A',
                    $rataRata >= 80 => 'B',
                    $rataRata >= 70 => 'C',
                    $rataRata >= 60 => 'D',
                    default         => 'E',
                  };
                @endphp
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg border font-display font-extrabold text-sm pred-{{ $predRata }}">
                  {{ $predRata }}
                </span>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    {{-- Catatan per mapel --}}
    @php $adaCatatan = $nilaiList->filter(fn($n) => $n->catatan)->count(); @endphp
    @if($adaCatatan > 0)
    <div class="sr bg-amber-50 border border-amber-100 rounded-2xl p-5 mb-6">
      <h4 class="font-display font-bold text-amber-800 text-sm mb-3 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        Catatan Guru
      </h4>
      <div class="space-y-2">
        @foreach($nilaiList->filter(fn($n) => $n->catatan) as $n)
        <div class="flex gap-3 text-sm">
          <span class="shrink-0 font-display font-bold text-amber-700 min-w-[140px]">
            {{ optional($n->mataPelajaran)->nama_mapel ?? '-' }}:
          </span>
          <span class="text-amber-800">{{ $n->catatan }}</span>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    {{-- Keterangan predikat --}}
    <div class="sr grid grid-cols-5 gap-2 text-center text-xs">
      @foreach(['A'=>['≥ 90','text-emerald-700','bg-emerald-50 border-emerald-200'],'B'=>['80–89','text-blue-700','bg-blue-50 border-blue-200'],'C'=>['70–79','text-amber-700','bg-amber-50 border-amber-200'],'D'=>['60–69','text-orange-700','bg-orange-50 border-orange-200'],'E'=>['< 60','text-red-700','bg-red-50 border-red-200']] as $p => [$range, $tc, $bg])
      <div class="rounded-xl border p-3 {{ $bg }}">
        <p class="font-display font-extrabold text-lg {{ $tc }}">{{ $p }}</p>
        <p class="{{ $tc }} opacity-70 text-[10px] mt-0.5">{{ $range }}</p>
      </div>
      @endforeach
    </div>

    @else
    {{-- Tidak ada nilai --}}
    <div class="sr text-center py-16 bg-white rounded-2xl border border-slate-200 shadow-sm">
      <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
      </div>
      <h3 class="font-display font-bold text-slate-700 text-lg mb-2">Belum Ada Nilai</h3>
      <p class="text-slate-400 text-sm">
        Nilai untuk tahun ajaran <strong>{{ $tahunAjaran->label }}</strong> belum diinput oleh guru.
      </p>
    </div>
    @endif

  </div>
</section>
@endisset

{{-- ═══════ INFO ═══════ --}}
@unless(isset($siswa))
<section class="bg-white border-t border-slate-100 py-16">
  <div class="max-w-3xl mx-auto px-5">
    <div class="text-center mb-10 sr">
      <span class="section-label text-violet-600 bg-violet-50 border border-violet-100 px-4 py-1.5 rounded-full mb-3 inline-block">Panduan</span>
      <h2 class="font-display font-extrabold text-2xl text-slate-900">Cara Cek Nilai</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
      @foreach([
        ['1','Masukkan NIS','Masukkan Nomor Induk Siswa (NIS) yang tertera di kartu pelajar atau buku rapor Anda.','🔢'],
        ['2','Pilih Tahun Ajaran','Pilih tahun ajaran yang ingin Anda lihat rekap nilainya dari dropdown yang tersedia.','📅'],
        ['3','Lihat Hasil','Klik tombol Cek Nilai dan rekap nilai lengkap Anda akan ditampilkan secara detail.','📊'],
      ] as [$no, $judul, $desk, $ikon])
      <div class="sr bg-slate-50 rounded-2xl border border-slate-100 p-5 text-center">
        <div class="w-12 h-12 rounded-2xl bg-violet-100 border border-violet-200 flex items-center justify-center mx-auto mb-4 text-2xl">
          {{ $ikon }}
        </div>
        <p class="font-display font-extrabold text-xs text-violet-500 uppercase tracking-widest mb-1">Langkah {{ $no }}</p>
        <h4 class="font-display font-bold text-slate-800 text-sm mb-2">{{ $judul }}</h4>
        <p class="text-slate-500 text-xs leading-relaxed">{{ $desk }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endunless

{{-- ═══════ FOOTER MINI ═══════ --}}
<footer class="bg-slate-900 border-t border-slate-800 py-6 no-print">
  <div class="max-w-7xl mx-auto px-5 flex flex-col sm:flex-row items-center justify-between gap-3">
    <p class="text-slate-500 text-xs">
      © {{ date('Y') }} SmartSchool {{ optional($profil)->nama_sekolah ?? 'SMK Bustanul Ulum' }}
    </p>
    <div class="flex gap-5">
      <a href="{{ url('/') }}"          class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Beranda</a>
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

  // Submit loading state
  const nilaiForm = document.getElementById('nilaiForm');
  if (nilaiForm) {
    nilaiForm.addEventListener('submit', () => {
      const btn     = document.getElementById('cekBtn');
      const icon    = document.getElementById('cekIcon');
      const spinner = document.getElementById('cekSpinner');
      const label   = document.getElementById('cekLabel');
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
    el.dataset.delay = (i % 6) * 80;
    io.observe(el);
  });

  // Auto scroll ke hasil setelah submit
  @isset($siswa)
  window.addEventListener('load', () => {
    const hasil = document.getElementById('hasil');
    if (hasil) setTimeout(() => hasil.scrollIntoView({ behavior: 'smooth', block: 'start' }), 300);
  });
  @endisset
</script>
</body>
</html>