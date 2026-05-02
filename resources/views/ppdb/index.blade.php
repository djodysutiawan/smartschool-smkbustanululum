<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PPDB {{ date('Y') }}/{{ date('Y')+1 }} — {{ $profil->singkatan ?? 'SMK Bustanul Ulum' }}</title>
  <meta name="description" content="Pendaftaran Peserta Didik Baru (PPDB) {{ $profil->nama_sekolah ?? 'SMK Bustanul Ulum' }} segera dibuka.">

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
            fadeUp:    { from:{opacity:'0',transform:'translateY(28px)'}, to:{opacity:'1',transform:'translateY(0)'} },
            fadeIn:    { from:{opacity:'0'}, to:{opacity:'1'} },
            livePulse: { '0%,100%':{boxShadow:'0 0 0 0 rgba(74,222,128,0.55)'},'50%':{boxShadow:'0 0 0 8px rgba(74,222,128,0)'} },
            float:     { '0%,100%':{transform:'translateY(0px)'},'50%':{transform:'translateY(-10px)'} },
            rotateSlow:{ from:{transform:'rotate(0deg)'}, to:{transform:'rotate(360deg)'} },
            countUp:   { from:{opacity:'0',transform:'scale(.8)'}, to:{opacity:'1',transform:'scale(1)'} },
          },
          animation: {
            'fade-up':     'fadeUp 0.65s cubic-bezier(.22,.68,0,1.2) both',
            'fade-in':     'fadeIn 0.5s ease both',
            'live-pulse':  'livePulse 2.2s ease-in-out infinite',
            'float':       'float 4s ease-in-out infinite',
            'rotate-slow': 'rotateSlow 18s linear infinite',
            'count-up':    'countUp 0.6s cubic-bezier(.22,.68,0,1.2) both',
          },
        }
      }
    }
  </script>
  <style>
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'DM Sans',sans-serif; }
    h1,h2,h3,h4,.font-display { font-family:'Plus Jakarta Sans',sans-serif; }

    /* ── Hero BG (sama persis dengan welcome) ── */
    .hero-bg {
      background: linear-gradient(140deg,#0d1f4e 0%,#1750c0 48%,#0a6b4a 100%);
      position:relative; overflow:hidden; min-height:100vh;
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

    /* ── Gradient text ── */
    .text-grad {
      background:linear-gradient(120deg,#93c5fd 0%,#a5f3fc 50%,#6ee7b7 100%);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
    }

    /* ── Navbar (sama dgn welcome) ── */
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

    /* ── Countdown boxes ── */
    .cbox {
      background:rgba(255,255,255,.1);
      border:1px solid rgba(255,255,255,.18);
      backdrop-filter:blur(14px);
      border-radius:16px;
      padding:16px 12px;
      min-width:76px;
      text-align:center;
    }
    .cbox-num {
      font-family:'Plus Jakarta Sans',sans-serif;
      font-weight:900;
      font-size:2.25rem;
      line-height:1;
      color:#fff;
      display:block;
    }
    .cbox-label {
      font-size:10px;
      font-weight:700;
      text-transform:uppercase;
      letter-spacing:.1em;
      color:rgba(255,255,255,.5);
      margin-top:4px;
      display:block;
    }

    /* ── Orbit ring ── */
    .orbit-ring {
      position:absolute;
      border-radius:50%;
      border:1px solid rgba(255,255,255,.07);
      pointer-events:none;
    }

    /* ── Notify form ── */
    .notify-input {
      background:rgba(255,255,255,.1);
      border:1.5px solid rgba(255,255,255,.2);
      border-radius:12px;
      padding:12px 16px;
      color:#fff;
      font-family:'DM Sans',sans-serif;
      font-size:14px;
      outline:none;
      transition:border-color .18s ease, background .18s ease;
      width:100%;
    }
    .notify-input::placeholder { color:rgba(255,255,255,.4); }
    .notify-input:focus {
      border-color:rgba(255,255,255,.5);
      background:rgba(255,255,255,.14);
    }

    /* scroll reveal */
    .sr { opacity:0; transform:translateY(26px); transition:opacity .55s ease, transform .55s ease; }
  </style>
</head>
<body class="bg-slate-900 antialiased">

{{-- ═══════ NAVBAR ═══════ --}}
<header id="nav" class="fixed inset-x-0 top-0 z-50 transition-all duration-300">
  <div class="max-w-7xl mx-auto px-5 h-16 flex items-center justify-between gap-4">

    {{-- Brand --}}
    <a href="{{ url('/') }}" class="flex items-center gap-2.5 shrink-0">
      <div class="nring w-9 h-9 rounded-xl border border-white/20 bg-white/10 flex items-center justify-center transition-all duration-300 overflow-hidden">
        @if(isset($profil) && $profil->logo_path)
          <img src="{{ asset('storage/'.$profil->logo_path) }}" alt="Logo" class="w-full h-full object-contain">
        @elseif(isset($profil) && $profil->logo_url)
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

    {{-- Desktop links --}}
  <nav class="hidden md:flex items-center gap-0.5">
    <a href="{{ url('/ppdb') }}" 
      class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all {{ request()->is('ppdb') ? 'bg-white/15 text-white border border-white/25' : '' }}">PPDB</a>
    <a href="{{ url('/elearning') }}" 
      class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all {{ request()->is('elearning') ? 'bg-white/15 text-white border border-white/25' : '' }}">E-Learning</a>
    <a href="{{ url('/nilai') }}" 
      class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all {{ request()->is('nilai') ? 'bg-white/15 text-white border border-white/25' : '' }}">Nilai</a>
    <a href="{{ url('/absensi') }}" 
      class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all {{ request()->is('absensi') ? 'bg-white/15 text-white border border-white/25' : '' }}">Absensi</a>
    <a href="{{ url('/') }}#kontak" 
      class="nl text-white/75 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">Kontak</a>
  </nav>

    {{-- CTA --}}
    <a href="{{ route('login') }}" class="ncta hidden md:inline-flex items-center gap-1.5 text-sm font-semibold font-display text-white border border-white/30 hover:border-white/60 hover:bg-white/12 px-5 py-2 rounded-xl transition-all duration-200">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
      Masuk
    </a>
  </div>
</header>

{{-- ═══════ MAIN CONTENT ═══════ --}}
<main class="hero-bg flex items-center justify-center min-h-screen">

  {{-- Orbit decorative rings --}}
  <div class="orbit-ring w-[500px] h-[500px] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>
  <div class="orbit-ring w-[700px] h-[700px] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>
  <div class="orbit-ring w-[900px] h-[900px] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>

  {{-- Floating gear SVG (decorative) --}}
  <div class="absolute top-1/4 right-[8%] opacity-[0.06] animate-rotate-slow hidden lg:block">
    <svg width="160" height="160" viewBox="0 0 24 24" fill="white"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
  </div>

  {{-- Floating book SVG (decorative) --}}
  <div class="absolute bottom-1/4 left-[6%] opacity-[0.06] animate-float hidden lg:block">
    <svg width="120" height="120" viewBox="0 0 24 24" fill="white"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
  </div>

  <div class="relative z-10 max-w-3xl mx-auto px-5 py-28 text-center">

    {{-- Badge --}}
    <div class="animate-fade-up inline-flex items-center gap-2 glass text-white/85 text-[11px] font-display font-semibold px-4 py-2 rounded-full mb-8 tracking-wider uppercase">
      <span class="animate-live-pulse w-2 h-2 rounded-full bg-amber-400 shrink-0"></span>
      PPDB {{ date('Y') }}/{{ date('Y')+1 }} · Segera Hadir
    </div>

    {{-- Heading --}}
    <h1 class="animate-fade-up [animation-delay:.1s] font-display font-extrabold text-4xl sm:text-5xl md:text-6xl leading-[1.15] text-white mb-5">
      Pendaftaran Peserta<br>
      Didik Baru <span class="text-grad">Segera Dibuka</span>
    </h1>

    <p class="animate-fade-up [animation-delay:.2s] text-white/60 text-base sm:text-lg leading-relaxed mb-12 max-w-xl mx-auto">
      Kami sedang mempersiapkan sistem PPDB online untuk <strong class="text-white/80">{{ optional($profil)->nama_sekolah ?? 'SMK Bustanul Ulum' }}</strong>.
      Pantau terus halaman ini untuk mendapatkan informasi terbaru.
    </p>

    {{-- Countdown --}}
    <div class="animate-fade-up [animation-delay:.3s] flex items-center justify-center gap-3 sm:gap-4 mb-12 flex-wrap" id="countdown">
      <div class="cbox">
        <span class="cbox-num" id="cd-hari">00</span>
        <span class="cbox-label">Hari</span>
      </div>
      <span class="text-white/30 font-extrabold text-3xl font-display pb-4">:</span>
      <div class="cbox">
        <span class="cbox-num" id="cd-jam">00</span>
        <span class="cbox-label">Jam</span>
      </div>
      <span class="text-white/30 font-extrabold text-3xl font-display pb-4">:</span>
      <div class="cbox">
        <span class="cbox-num" id="cd-menit">00</span>
        <span class="cbox-label">Menit</span>
      </div>
      <span class="text-white/30 font-extrabold text-3xl font-display pb-4">:</span>
      <div class="cbox">
        <span class="cbox-num" id="cd-detik">00</span>
        <span class="cbox-label">Detik</span>
      </div>
    </div>

    {{-- Notify form --}}
    <div class="animate-fade-up [animation-delay:.4s] max-w-md mx-auto mb-12">
      <p class="text-white/50 text-xs font-semibold uppercase tracking-widest mb-3">Ingin diberitahu saat PPDB dibuka?</p>
      <div class="flex gap-2">
        <input type="email" id="notifyEmail" class="notify-input" placeholder="Masukkan email Anda...">
        <button onclick="handleNotify()"
                class="shrink-0 inline-flex items-center gap-1.5 bg-white text-brand-700 font-display font-bold text-sm px-5 py-3 rounded-xl hover:bg-blue-50 transition-all duration-200 whitespace-nowrap">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
          Beritahu Saya
        </button>
      </div>
      <p id="notifyMsg" class="text-emerald-400 text-xs font-semibold mt-2 hidden">✓ Berhasil! Kami akan menghubungi Anda segera.</p>
    </div>

    {{-- Back to home --}}
    <div class="animate-fade-up [animation-delay:.5s] flex flex-col sm:flex-row items-center justify-center gap-3">
      <a href="{{ url('/') }}" class="inline-flex items-center gap-2 glass text-white font-display font-semibold text-sm px-7 py-3.5 rounded-xl hover:bg-white/15 transition-all duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Beranda
      </a>
      @if(optional($profil)->whatsapp)
      <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',optional($profil)->whatsapp) }}?text=Halo,%20saya%20ingin%20menanyakan%20informasi%20PPDB%20{{ date('Y') }}"
         target="_blank"
         class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-display font-semibold text-sm px-7 py-3.5 rounded-xl transition-all duration-200 shadow-[0_4px_20px_rgba(16,185,129,.35)]">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
        Tanya via WhatsApp
      </a>
      @endif
    </div>

    {{-- Info jurusan mini --}}
    @if(isset($jurusan) && $jurusan->count() > 0)
    <div class="animate-fade-up [animation-delay:.6s] mt-16 pt-10 border-t border-white/10">
      <p class="text-white/40 text-xs font-semibold uppercase tracking-widest mb-4">Program Keahlian Tersedia</p>
      <div class="flex flex-wrap justify-center gap-2">
        @foreach($jurusan as $j)
        <span class="glass text-white/75 text-xs font-display font-semibold px-4 py-2 rounded-full">
          {{ $j->singkatan }} · {{ $j->nama }}
        </span>
        @endforeach
      </div>
    </div>
    @endif

  </div>
</main>

{{-- ═══════ FOOTER MINI ═══════ --}}
<footer class="bg-slate-950 border-t border-slate-800 py-6">
  <div class="max-w-7xl mx-auto px-5 flex flex-col sm:flex-row items-center justify-between gap-3">
    <p class="text-slate-500 text-xs">
      © {{ date('Y') }} SmartSchool {{ optional($profil)->nama_sekolah ?? 'SMK Bustanul Ulum' }}
    </p>
    <a href="{{ url('/') }}" class="text-slate-500 hover:text-slate-300 text-xs transition-colors inline-flex items-center gap-1">
      <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      Beranda
    </a>
  </div>
</footer>

{{-- ═══════ SCRIPTS ═══════ --}}
<script>
  // Navbar scroll
  const nav = document.getElementById('nav');
  window.addEventListener('scroll', () => {
    nav.classList.toggle('nav-scrolled', window.scrollY > 56);
  });

  // ── Countdown ke tanggal target PPDB ──────────────────
  // Ganti tanggal ini sesuai jadwal buka PPDB
  const targetDate = new Date('{{ date("Y") }}-07-01T07:00:00').getTime();

  function updateCountdown() {
    const now  = Date.now();
    const diff = targetDate - now;

    if (diff <= 0) {
      document.getElementById('cd-hari').textContent  = '00';
      document.getElementById('cd-jam').textContent   = '00';
      document.getElementById('cd-menit').textContent = '00';
      document.getElementById('cd-detik').textContent = '00';
      return;
    }

    const hari  = Math.floor(diff / (1000 * 60 * 60 * 24));
    const jam   = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const menit = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const detik = Math.floor((diff % (1000 * 60)) / 1000);

    document.getElementById('cd-hari').textContent  = String(hari).padStart(2,'0');
    document.getElementById('cd-jam').textContent   = String(jam).padStart(2,'0');
    document.getElementById('cd-menit').textContent = String(menit).padStart(2,'0');
    document.getElementById('cd-detik').textContent = String(detik).padStart(2,'0');
  }

  updateCountdown();
  setInterval(updateCountdown, 1000);

  // ── Notify mock ────────────────────────────────────────
  function handleNotify() {
    const email = document.getElementById('notifyEmail').value.trim();
    const msg   = document.getElementById('notifyMsg');
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      document.getElementById('notifyEmail').style.borderColor = 'rgba(239,68,68,.7)';
      return;
    }
    document.getElementById('notifyEmail').style.borderColor = '';
    msg.classList.remove('hidden');
    document.getElementById('notifyEmail').value = '';
    setTimeout(() => msg.classList.add('hidden'), 4000);
  }

  // Enter key notify
  document.getElementById('notifyEmail')?.addEventListener('keydown', e => {
    if (e.key === 'Enter') handleNotify();
  });

  // Scroll reveal
  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.07 });
  document.querySelectorAll('.sr').forEach(el => io.observe(el));
</script>
</body>
</html>