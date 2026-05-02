<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $jurusan->nama }} — {{ $profil->nama_sekolah ?? 'SmartSchool' }}</title>
  <meta name="description" content="{{ $jurusan->deskripsi_singkat ?? 'Detail jurusan '.$jurusan->nama }}">

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
      background: linear-gradient(140deg,#0d1f4e 0%,#1750c0 48%,#0a6b4a 100%);
      position:relative; overflow:hidden;
    }
    .page-hero::before {
      content:''; position:absolute; inset:0; pointer-events:none;
      background:
        radial-gradient(ellipse 600px 400px at 85% 10%, rgba(89,163,248,.28) 0%,transparent 70%),
        radial-gradient(ellipse 400px 400px at 5% 90%,  rgba(16,185,129,.20) 0%,transparent 65%);
    }
    .page-hero::after {
      content:''; position:absolute; inset:0; pointer-events:none;
      background-image:radial-gradient(circle,rgba(255,255,255,.03) 1px,transparent 1px);
      background-size:44px 44px;
    }

    .glass { background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.14); backdrop-filter:blur(14px); }

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

    .rpill {
      display:inline-flex; align-items:center; gap:3px;
      font-size:10px; font-weight:700; letter-spacing:.05em; text-transform:uppercase;
      padding:2px 9px; border-radius:99px;
    }

    .section-label {
      display:inline-block; text-transform:uppercase; letter-spacing:.12em;
      font-size:11px; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif;
    }

    /* Tab navigation */
    .tab-btn { transition:all .18s ease; border-bottom:2px solid transparent; }
    .tab-btn.active { color:#1f63db; border-bottom-color:#1f63db; }
    .tab-content { display:none; }
    .tab-content.active { display:block; }

    /* Sidebar sticky */
    .sidebar-sticky { position:sticky; top:88px; }

    /* Card */
    .jcard-sm { transition:transform .2s ease,box-shadow .2s ease; }
    .jcard-sm:hover { transform:translateY(-3px); box-shadow:0 6px 24px rgba(31,99,219,.12); }

    /* Scroll reveal */
    .sr { opacity:0; transform:translateY(20px); }

    /* Mobile menu */
    #mmenu { display:none; }
    #mmenu.open { display:flex; }

    .text-grad {
      background:linear-gradient(120deg,#93c5fd 0%,#a5f3fc 50%,#6ee7b7 100%);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
    }

    /* Kurikulum table */
    .kur-row:hover { background:#f8fafc; }

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
    <a href="{{ route('login') }}" class="mt-2 bg-brand-500 hover:bg-brand-600 text-white font-display font-semibold text-sm py-2.5 rounded-xl flex items-center justify-center gap-2 transition-all">Masuk ke Sistem</a>
  </div>
</header>

{{-- ═══════ HERO JURUSAN ═══════ --}}
<section class="page-hero pt-16">

  {{-- Cover image background --}}
  @if($jurusan->foto_cover_path || $jurusan->foto_cover_url)
  <div class="absolute inset-0 z-0">
    <img src="{{ $jurusan->foto_cover_path ? asset('storage/'.$jurusan->foto_cover_path) : $jurusan->foto_cover_url }}"
         alt="{{ $jurusan->nama }}" class="w-full h-full object-cover opacity-20">
    <div class="absolute inset-0 bg-gradient-to-t from-[#0d1f4e]/90 via-[#1750c0]/50 to-transparent"></div>
  </div>
  @endif

  <div class="max-w-7xl mx-auto px-5 py-16 sm:py-20 relative z-10">

    {{-- Breadcrumb --}}
    <nav class="animate-fade-up flex items-center gap-2 text-white/50 text-xs mb-8">
      <a href="{{ url('/') }}" class="hover:text-white transition-colors">Beranda</a>
      <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
      <a href="{{ route('jurusan.index') }}" class="hover:text-white transition-colors">Jurusan</a>
      <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
      <span class="text-white/80">{{ $jurusan->singkatan }}</span>
    </nav>

    <div class="flex flex-col lg:flex-row lg:items-end gap-8">
      <div class="flex-1">
        <div class="flex items-center gap-3 mb-5 flex-wrap">
          @if($jurusan->logo_path || $jurusan->logo_url)
          <div class="w-16 h-16 rounded-2xl bg-white border-2 border-white/40 overflow-hidden shadow-xl shrink-0">
            <img src="{{ $jurusan->logo_path ? asset('storage/'.$jurusan->logo_path) : $jurusan->logo_url }}"
                 alt="Logo {{ $jurusan->singkatan }}" class="w-full h-full object-contain p-1">
          </div>
          @endif
          <div>
            @if($jurusan->akreditasi)
            <span class="glass text-white/80 text-[10px] font-bold px-2.5 py-1 rounded-full mr-2">Akreditasi {{ $jurusan->akreditasi }}</span>
            @endif
            @if($jurusan->is_penerimaan_buka)
            <span class="inline-flex items-center gap-1.5 bg-emerald-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full">
              <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
              Penerimaan Buka
            </span>
            @endif
          </div>
        </div>

        <h1 class="animate-fade-up font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white mb-2 leading-tight">
          {{ $jurusan->nama }}
        </h1>
        <p class="animate-fade-up [animation-delay:.1s] text-white/60 text-lg font-display font-semibold mb-4">
          {{ $jurusan->singkatan }}
          @if($jurusan->kode_jurusan) · <span class="text-white/40 text-base font-normal">{{ $jurusan->kode_jurusan }}</span> @endif
        </p>

        @if($jurusan->deskripsi_singkat)
        <p class="animate-fade-up [animation-delay:.15s] text-white/65 text-sm sm:text-base leading-relaxed max-w-xl mb-6">
          {{ $jurusan->deskripsi_singkat }}
        </p>
        @endif

        {{-- Kompetensi pills --}}
        @if($jurusan->kompetensi->count() > 0)
        <div class="animate-fade-up [animation-delay:.2s] flex flex-wrap gap-2">
          @foreach($jurusan->kompetensi->take(5) as $k)
          <span class="glass text-white/80 text-[11px] font-semibold px-3 py-1 rounded-full">{{ $k->nama_kompetensi }}</span>
          @endforeach
        </div>
        @endif
      </div>

      {{-- Quick stats --}}
      <div class="animate-fade-up [animation-delay:.25s] lg:shrink-0">
        <div class="glass rounded-2xl p-5 grid grid-cols-2 gap-4 min-w-[220px]">
          @if($jurusan->lama_belajar)
          <div class="text-center">
            <p class="font-display font-extrabold text-2xl text-white">{{ $jurusan->lama_belajar }}</p>
            <p class="text-white/45 text-xs mt-0.5">Tahun Belajar</p>
          </div>
          @endif
          @if($jurusan->kapasitas_per_kelas)
          <div class="text-center">
            <p class="font-display font-extrabold text-2xl text-white">{{ $jurusan->kapasitas_per_kelas }}</p>
            <p class="text-white/45 text-xs mt-0.5">Kapasitas/Kelas</p>
          </div>
          @endif
          @if($jurusan->jumlah_kelas_aktif)
          <div class="text-center">
            <p class="font-display font-extrabold text-2xl text-white">{{ $jurusan->jumlah_kelas_aktif }}</p>
            <p class="text-white/45 text-xs mt-0.5">Kelas Aktif</p>
          </div>
          @endif
          @if($jurusan->total_siswa)
          <div class="text-center">
            <p class="font-display font-extrabold text-2xl text-white">{{ $jurusan->total_siswa }}</p>
            <p class="text-white/45 text-xs mt-0.5">Total Siswa</p>
          </div>
          @endif
        </div>
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

{{-- ═══════ CONTENT ═══════ --}}
<section class="bg-slate-50 py-12">
  <div class="max-w-7xl mx-auto px-5">
    <div class="flex flex-col lg:flex-row gap-8 items-start">

      {{-- ── MAIN CONTENT ── --}}
      <div class="flex-1 min-w-0">

        {{-- Tab Navigation --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-6 overflow-hidden">
          <div class="flex border-b border-slate-100 overflow-x-auto">
            @if($jurusan->deskripsi_lengkap || $jurusan->tujuan_jurusan)
            <button onclick="switchTab('deskripsi')" class="tab-btn active text-sm font-display font-semibold px-5 py-4 whitespace-nowrap text-slate-600 hover:text-brand-600" data-tab="deskripsi">
              Deskripsi
            </button>
            @endif
            @if($jurusan->kompetensi->count() > 0)
            <button onclick="switchTab('kompetensi')" class="tab-btn text-sm font-display font-semibold px-5 py-4 whitespace-nowrap text-slate-600 hover:text-brand-600" data-tab="kompetensi">
              Kompetensi
            </button>
            @endif
            @if($jurusan->prospekKerja->count() > 0)
            <button onclick="switchTab('prospek')" class="tab-btn text-sm font-display font-semibold px-5 py-4 whitespace-nowrap text-slate-600 hover:text-brand-600" data-tab="prospek">
              Prospek Kerja
            </button>
            @endif
            @if($kurikulumPerKelas->count() > 0)
            <button onclick="switchTab('kurikulum')" class="tab-btn text-sm font-display font-semibold px-5 py-4 whitespace-nowrap text-slate-600 hover:text-brand-600" data-tab="kurikulum">
              Kurikulum
            </button>
            @endif
            @if($jurusan->fasilitas->count() > 0)
            <button onclick="switchTab('fasilitas')" class="tab-btn text-sm font-display font-semibold px-5 py-4 whitespace-nowrap text-slate-600 hover:text-brand-600" data-tab="fasilitas">
              Fasilitas
            </button>
            @endif
          </div>

          {{-- Tab: Deskripsi --}}
          @if($jurusan->deskripsi_lengkap || $jurusan->tujuan_jurusan)
          <div class="tab-content active p-6" id="tab-deskripsi">
            @if($jurusan->deskripsi_lengkap)
            <div class="prose prose-sm max-w-none text-slate-600 leading-relaxed mb-6">
              {!! nl2br(e($jurusan->deskripsi_lengkap)) !!}
            </div>
            @endif

            @if($jurusan->tujuan_jurusan)
            <div class="bg-brand-50 border border-brand-100 rounded-xl p-5">
              <h4 class="font-display font-bold text-brand-800 text-sm mb-2 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                Tujuan Jurusan
              </h4>
              <p class="text-brand-700 text-sm leading-relaxed">{{ $jurusan->tujuan_jurusan }}</p>
            </div>
            @endif
          </div>
          @endif

          {{-- Tab: Kompetensi --}}
          @if($jurusan->kompetensi->count() > 0)
          <div class="tab-content p-6" id="tab-kompetensi">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              @foreach($jurusan->kompetensi as $k)
              <div class="flex items-start gap-3 bg-slate-50 rounded-xl p-4 border border-slate-100">
                <div class="w-9 h-9 rounded-lg bg-brand-100 flex items-center justify-center text-lg shrink-0">
                  {{ $k->ikon ?? '📚' }}
                </div>
                <div>
                  <p class="font-display font-bold text-slate-800 text-sm">{{ $k->nama_kompetensi }}</p>
                  @if($k->deskripsi)
                  <p class="text-slate-500 text-xs mt-1 leading-relaxed">{{ $k->deskripsi }}</p>
                  @endif
                </div>
              </div>
              @endforeach
            </div>
          </div>
          @endif

          {{-- Tab: Prospek Kerja --}}
          @if($jurusan->prospekKerja->count() > 0)
          <div class="tab-content p-6" id="tab-prospek">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              @foreach($jurusan->prospekKerja as $p)
              <div class="flex items-start gap-3 bg-emerald-50 rounded-xl p-4 border border-emerald-100">
                <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center text-lg shrink-0">
                  {{ $p->ikon ?? '💼' }}
                </div>
                <div>
                  <p class="font-display font-bold text-slate-800 text-sm">{{ $p->jabatan }}</p>
                  @if($p->bidang_industri)
                  <p class="text-emerald-600 text-[11px] font-semibold mt-0.5">{{ $p->bidang_industri }}</p>
                  @endif
                  @if($p->deskripsi)
                  <p class="text-slate-500 text-xs mt-1 leading-relaxed">{{ $p->deskripsi }}</p>
                  @endif
                </div>
              </div>
              @endforeach
            </div>
          </div>
          @endif

          {{-- Tab: Kurikulum --}}
          @if($kurikulumPerKelas->count() > 0)
          <div class="tab-content p-6" id="tab-kurikulum">
            @foreach($kurikulumPerKelas as $kelas => $mapel)
            <div class="mb-6 last:mb-0">
              <h4 class="font-display font-bold text-slate-800 text-sm mb-3 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-brand-100 text-brand-700 flex items-center justify-center text-xs font-extrabold">{{ $kelas }}</span>
                Kelas {{ $kelas }}
              </h4>
              <div class="overflow-x-auto rounded-xl border border-slate-100">
                <table class="w-full text-xs">
                  <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                      <th class="text-left px-4 py-2.5 font-display font-bold text-slate-500 uppercase tracking-wider">Mata Pelajaran</th>
                      <th class="text-left px-4 py-2.5 font-display font-bold text-slate-500 uppercase tracking-wider">Kelompok</th>
                      <th class="text-center px-4 py-2.5 font-display font-bold text-slate-500 uppercase tracking-wider">Sem</th>
                      <th class="text-center px-4 py-2.5 font-display font-bold text-slate-500 uppercase tracking-wider">Jam/Mgg</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-50 bg-white">
                    @foreach($mapel->sortBy('semester') as $m)
                    <tr class="kur-row">
                      <td class="px-4 py-2.5 font-semibold text-slate-700">{{ $m->nama_mapel }}</td>
                      <td class="px-4 py-2.5 text-slate-500">{{ $m->kelompok ?? '–' }}</td>
                      <td class="px-4 py-2.5 text-center text-slate-500">{{ $m->semester ?? '–' }}</td>
                      <td class="px-4 py-2.5 text-center font-semibold text-brand-600">{{ $m->jam_per_minggu ?? '–' }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            @endforeach
          </div>
          @endif

          {{-- Tab: Fasilitas --}}
          @if($jurusan->fasilitas->count() > 0)
          <div class="tab-content p-6" id="tab-fasilitas">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              @foreach($jurusan->fasilitas as $f)
              <div class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm">
                @if($f->foto_path || $f->foto_url)
                <div class="h-36 overflow-hidden bg-slate-100">
                  <img src="{{ $f->foto_path ? asset('storage/'.$f->foto_path) : $f->foto_url }}"
                       alt="{{ $f->nama_fasilitas }}" class="w-full h-full object-cover">
                </div>
                @endif
                <div class="p-4">
                  <p class="font-display font-bold text-slate-800 text-sm">{{ $f->nama_fasilitas }}</p>
                  @if($f->jumlah)
                  <p class="text-brand-600 text-xs font-semibold mt-0.5">{{ $f->jumlah }} unit</p>
                  @endif
                  @if($f->deskripsi)
                  <p class="text-slate-500 text-xs mt-1 leading-relaxed">{{ $f->deskripsi }}</p>
                  @endif
                </div>
              </div>
              @endforeach
            </div>
          </div>
          @endif

        </div>{{-- end tab card --}}
      </div>

      {{-- ── SIDEBAR ── --}}
      <div class="lg:w-72 xl:w-80 shrink-0 space-y-5">

        {{-- Kepala Jurusan --}}
        @if($jurusan->nama_kajur)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sr">
          <p class="section-label text-slate-400 mb-4">Kepala Jurusan</p>
          <div class="flex items-center gap-3">
            @if($jurusan->foto_kajur_path || $jurusan->foto_kajur_url)
            <img src="{{ $jurusan->foto_kajur_path ? asset('storage/'.$jurusan->foto_kajur_path) : $jurusan->foto_kajur_url }}"
                 alt="{{ $jurusan->nama_kajur }}" class="w-14 h-14 rounded-xl object-cover border border-slate-200">
            @else
            <div class="w-14 h-14 rounded-xl bg-brand-100 flex items-center justify-center font-display font-extrabold text-brand-700 text-xl">
              {{ substr($jurusan->nama_kajur, 0, 1) }}
            </div>
            @endif
            <div>
              <p class="font-display font-bold text-slate-800 text-sm">{{ $jurusan->nama_kajur }}</p>
              <p class="text-brand-600 text-xs font-semibold">Kepala Jurusan</p>
            </div>
          </div>
        </div>
        @endif

        {{-- Info Tambahan --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sr">
          <p class="section-label text-slate-400 mb-4">Informasi</p>
          <ul class="space-y-3">
            @if($jurusan->bidang_keahlian)
            <li class="flex items-start gap-2.5">
              <svg class="w-4 h-4 text-brand-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg>
              <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Bidang Keahlian</p>
                <p class="text-slate-700 text-xs font-semibold mt-0.5">{{ $jurusan->bidang_keahlian }}</p>
              </div>
            </li>
            @endif
            @if($jurusan->program_keahlian)
            <li class="flex items-start gap-2.5">
              <svg class="w-4 h-4 text-brand-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 17l10 5 10-5"/></svg>
              <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Program Keahlian</p>
                <p class="text-slate-700 text-xs font-semibold mt-0.5">{{ $jurusan->program_keahlian }}</p>
              </div>
            </li>
            @endif
            @if($jurusan->kompetensi_keahlian)
            <li class="flex items-start gap-2.5">
              <svg class="w-4 h-4 text-brand-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 12l10 5 10-5"/></svg>
              <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Kompetensi Keahlian</p>
                <p class="text-slate-700 text-xs font-semibold mt-0.5">{{ $jurusan->kompetensi_keahlian }}</p>
              </div>
            </li>
            @endif
          </ul>
        </div>

        {{-- CTA Daftar --}}
        @if($jurusan->is_penerimaan_buka)
        <div class="bg-gradient-to-br from-brand-600 to-brand-800 rounded-2xl p-5 text-white sr">
          <p class="font-display font-extrabold text-base mb-1">Daftar Sekarang!</p>
          <p class="text-white/70 text-xs mb-4 leading-relaxed">Penerimaan peserta didik baru untuk jurusan ini sedang dibuka.</p>
          <a href="{{ url('/#kontak') }}" class="block w-full bg-white text-brand-700 font-display font-bold text-sm py-2.5 rounded-xl text-center hover:bg-blue-50 transition-colors">
            Hubungi Kami
          </a>
        </div>
        @endif

        {{-- Jurusan Lainnya --}}
        @if($jurusanLain->count() > 0)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sr">
          <p class="section-label text-slate-400 mb-4">Jurusan Lainnya</p>
          <div class="space-y-3">
            @foreach($jurusanLain as $jl)
            <a href="{{ route('jurusan.show', $jl->slug) }}"
               class="jcard-sm flex items-center gap-3 p-3 rounded-xl border border-slate-100 bg-slate-50 hover:border-brand-200 hover:bg-brand-50 transition-all block">
              <div class="w-10 h-10 rounded-xl overflow-hidden bg-brand-100 shrink-0">
                @if($jl->logo_path || $jl->logo_url)
                  <img src="{{ $jl->logo_path ? asset('storage/'.$jl->logo_path) : $jl->logo_url }}" alt="{{ $jl->singkatan }}" class="w-full h-full object-contain p-1">
                @else
                  <div class="w-full h-full flex items-center justify-center font-display font-extrabold text-brand-600 text-xs">{{ substr($jl->singkatan, 0, 2) }}</div>
                @endif
              </div>
              <div class="min-w-0">
                <p class="font-display font-bold text-slate-800 text-xs leading-snug">{{ $jl->singkatan }}</p>
                <p class="text-slate-500 text-[10px] truncate">{{ $jl->nama }}</p>
              </div>
              <svg class="w-3.5 h-3.5 text-slate-300 shrink-0 ml-auto" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            </a>
            @endforeach
          </div>
          <a href="{{ route('jurusan.index') }}" class="block text-center text-brand-600 text-xs font-display font-semibold mt-4 hover:text-brand-800 transition-colors">
            Lihat Semua Jurusan →
          </a>
        </div>
        @endif

      </div>{{-- end sidebar --}}
    </div>
  </div>
</section>

{{-- ═══════ FOOTER MINI ═══════ --}}
<footer class="bg-slate-900 text-white py-8 mt-4">
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

  // Tab switching
  function switchTab(tabId) {
    // Update buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
      btn.classList.toggle('active', btn.dataset.tab === tabId);
    });
    // Update content panels
    document.querySelectorAll('.tab-content').forEach(panel => {
      panel.classList.toggle('active', panel.id === 'tab-' + tabId);
    });
  }

  // Auto-activate first available tab
  const firstTab = document.querySelector('.tab-btn');
  if (firstTab) {
    firstTab.classList.add('active');
    const firstContent = document.getElementById('tab-' + firstTab.dataset.tab);
    if (firstContent) firstContent.classList.add('active');
  }

  // Scroll reveal
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
    el.dataset.delay = (i % 4) * 80;
    io.observe(el);
  });
</script>
</body>
</html>