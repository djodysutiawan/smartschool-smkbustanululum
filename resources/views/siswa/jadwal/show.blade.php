<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Instrument+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');

    :root {
        --s-800:#0f2044;--s-700:#1a3a6b;--s-600:#1d4ed8;--s-500:#2563eb;
        --s-400:#3b82f6;--s-100:#dbeafe;--s-50:#eff6ff;
        --g-500:#10b981;--g-100:#d1fae5;--g-50:#ecfdf5;
        --a-500:#f59e0b;--a-50:#fffbeb;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#334155;--text3:#64748b;--text4:#94a3b8;
        --radius:12px;--radius-sm:8px;--radius-xs:6px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.07);
        --shadow-md:0 4px 16px rgba(0,0,0,.08);
    }

    .page { padding:24px 28px 56px; font-family:'Instrument Sans',sans-serif; max-width:2000px; }

    /* ── Breadcrumb ── */
    .breadcrumb { display:flex; align-items:center; gap:6px; margin-bottom:20px; font-size:13px; color:var(--text4); flex-wrap:wrap; }
    .breadcrumb a { color:var(--text3); text-decoration:none; font-family:'Outfit',sans-serif; font-weight:600; }
    .breadcrumb a:hover { color:var(--s-500); }
    .breadcrumb svg { flex-shrink:0; }
    .breadcrumb .current { color:var(--text2); font-weight:700; font-family:'Outfit',sans-serif; }

    /* ── Hero card ── */
    .hero-card {
        border-radius:var(--radius);
        overflow:hidden;
        margin-bottom:20px;
        box-shadow:var(--shadow-md);
    }
    .hero-top {
        padding:28px 32px;
        position:relative;
        overflow:hidden;
        color:#fff;
    }
    .hero-top::before {
        content:'';
        position:absolute; top:-50px; right:-50px;
        width:200px; height:200px;
        background:rgba(255,255,255,.07); border-radius:50%;
    }
    .hero-top::after {
        content:'';
        position:absolute; bottom:-60px; left:60px;
        width:150px; height:150px;
        background:rgba(255,255,255,.04); border-radius:50%;
    }
    .hero-inner { position:relative; z-index:1; }
    .hero-hari {
        display:inline-flex; align-items:center; gap:5px;
        background:rgba(255,255,255,.18); border:1px solid rgba(255,255,255,.25);
        border-radius:99px; padding:4px 12px;
        font-family:'Outfit',sans-serif; font-size:12px; font-weight:700;
        margin-bottom:10px;
    }
    .hero-mapel { font-family:'Outfit',sans-serif; font-size:26px; font-weight:900; line-height:1.2; margin-bottom:8px; }
    .hero-meta { display:flex; align-items:center; gap:14px; flex-wrap:wrap; opacity:.85; font-size:13.5px; }
    .hero-meta-item { display:flex; align-items:center; gap:5px; }

    /* Now indicator */
    .now-strip {
        background:var(--g-50); border-top:2px solid var(--g-500);
        padding:10px 32px;
        display:flex; align-items:center; gap:8px;
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:700; color:var(--g-500);
    }
    .now-dot { width:8px; height:8px; border-radius:50%; background:var(--g-500); animation:pulse-dot 1.4s ease-in-out infinite; }
    @keyframes pulse-dot { 0%,100%{opacity:1}50%{opacity:.4} }

    /* ── Info grid ── */
    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:16px; }
    .info-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:18px 20px; }
    .info-card-title {
        font-family:'Outfit',sans-serif; font-size:11px; font-weight:700;
        color:var(--text4); text-transform:uppercase; letter-spacing:.06em;
        margin-bottom:12px; display:flex; align-items:center; gap:6px;
    }
    .info-row { display:flex; align-items:center; gap:12px; padding:8px 0; border-bottom:1px solid var(--surface3); }
    .info-row:last-child { border-bottom:none; padding-bottom:0; }
    .info-row-icon { width:30px; height:30px; border-radius:7px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .info-row-label { font-size:11.5px; color:var(--text4); margin-bottom:1px; }
    .info-row-val { font-family:'Outfit',sans-serif; font-size:14px; font-weight:700; color:var(--text); }

    /* ── Time visual ── */
    .time-visual { display:flex; align-items:center; gap:12px; padding:14px 20px; background:var(--surface2); border-radius:var(--radius); margin-bottom:14px; }
    .time-block { text-align:center; }
    .time-block .lbl { font-size:11px; color:var(--text4); font-family:'Outfit',sans-serif; font-weight:700; letter-spacing:.04em; text-transform:uppercase; margin-bottom:3px; }
    .time-block .val { font-family:'Outfit',sans-serif; font-size:28px; font-weight:800; color:var(--text); line-height:1; }
    .time-arrow { flex:1; display:flex; align-items:center; gap:6px; }
    .time-bar { flex:1; height:4px; background:var(--border); border-radius:99px; overflow:hidden; }
    .time-fill { height:100%; background:linear-gradient(90deg,var(--s-500),var(--s-400)); border-radius:99px; }
    .time-dur { font-family:'Outfit',sans-serif; font-size:13px; font-weight:700; color:var(--text3); white-space:nowrap; }

    /* ── Guru card ── */
    .guru-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:18px 20px; margin-bottom:14px; display:flex; align-items:center; gap:16px; }
    .guru-avatar {
        width:54px; height:54px; border-radius:14px;
        background:linear-gradient(135deg,var(--s-600),var(--s-400));
        display:flex; align-items:center; justify-content:center;
        font-family:'Outfit',sans-serif; font-size:20px; font-weight:800; color:#fff;
        flex-shrink:0; text-transform:uppercase;
    }
    .guru-name { font-family:'Outfit',sans-serif; font-size:16px; font-weight:800; color:var(--text); }
    .guru-nip { font-size:13px; color:var(--text4); margin-top:2px; }
    .guru-mapel-tag {
        display:inline-flex; align-items:center; gap:5px; margin-top:6px;
        background:var(--s-50); border:1px solid var(--s-100);
        color:var(--s-600); padding:3px 10px; border-radius:99px;
        font-family:'Outfit',sans-serif; font-size:12px; font-weight:700;
    }

    /* ── Jadwal sama section ── */
    .same-section { margin-top:16px; }
    .same-title { font-family:'Outfit',sans-serif; font-size:13px; font-weight:700; color:var(--text2); margin-bottom:10px; display:flex; align-items:center; gap:7px; }
    .same-item {
        display:flex; align-items:center; gap:12px;
        background:var(--surface); border:1px solid var(--border);
        border-radius:var(--radius-sm); padding:12px 16px;
        margin-bottom:8px; text-decoration:none;
        transition:box-shadow .15s, transform .15s;
    }
    .same-item:hover { box-shadow:var(--shadow-md); transform:translateY(-1px); }
    .same-hari-badge {
        font-family:'Outfit',sans-serif; font-size:11.5px; font-weight:800;
        background:var(--s-50); color:var(--s-600); border:1px solid var(--s-100);
        padding:4px 10px; border-radius:6px; flex-shrink:0;
    }
    .same-jam { font-family:'Outfit',sans-serif; font-size:13.5px; font-weight:700; color:var(--text); }
    .same-ruang { font-size:12px; color:var(--text4); margin-top:1px; }
    .same-arrow { margin-left:auto; color:var(--text4); }

    /* ── Back button ── */
    .btn-back {
        display:inline-flex; align-items:center; gap:6px;
        padding:8px 16px; border-radius:var(--radius-xs);
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:700;
        background:var(--surface2); color:var(--text2);
        border:1px solid var(--border); text-decoration:none; transition:all .15s;
    }
    .btn-back:hover { background:var(--surface3); }

    @media(max-width:700px){ .info-grid{grid-template-columns:1fr} .page{padding:14px 14px 48px} .hero-mapel{font-size:20px} }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('siswa.dashboard') }}">Beranda</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <a href="{{ route('siswa.jadwal.index') }}">Jadwal Pelajaran</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <span class="current">{{ $jadwal->mataPelajaran->nama ?? 'Detail' }}</span>
    </div>

    @php
        $mulai   = \Carbon\Carbon::parse($jadwal->jam_mulai);
        $selesai = \Carbon\Carbon::parse($jadwal->jam_selesai);
        $durasi  = $mulai->diffInMinutes($selesai);
        $hariIniStr = strtolower(\Carbon\Carbon::now()->locale('id')->isoFormat('dddd'));
        $jamSkrg    = \Carbon\Carbon::now()->format('H:i:s');
        $isNow  = $jadwal->hari === $hariIniStr
                  && $jamSkrg >= $jadwal->jam_mulai
                  && $jamSkrg <= $jadwal->jam_selesai;

        // Progress untuk time bar (hanya kalau sedang berlangsung)
        $pct = 0;
        if ($isNow) {
            $elapsed = $mulai->diffInMinutes(\Carbon\Carbon::now());
            $pct     = min(100, round(($elapsed / $durasi) * 100));
        }

        // Warna mapel
        $colors = ['#2563eb','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899','#0891b2','#65a30d'];
        $color  = $colors[$jadwal->mata_pelajaran_id % 8];
    @endphp

    {{-- Hero card --}}
    <div class="hero-card">
        <div class="hero-top" style="background:linear-gradient(135deg, {{ $color }}dd, {{ $color }}99)">
            <div class="hero-inner">
                <div class="hero-hari">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ ucfirst($jadwal->hari) }}
                </div>
                <h1 class="hero-mapel">{{ $jadwal->mataPelajaran->nama ?? '—' }}</h1>
                <div class="hero-meta">
                    <span class="hero-meta-item">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        {{ $mulai->format('H:i') }} – {{ $selesai->format('H:i') }} ({{ $durasi }} menit)
                    </span>
                    @if($jadwal->ruang)
                    <span class="hero-meta-item">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        {{ $jadwal->ruang->nama_ruang ?? '' }}
                    </span>
                    @endif
                    <span class="hero-meta-item">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/></svg>
                        {{ $jadwal->kelas->nama_kelas ?? $siswa->kelas->nama_kelas ?? '—' }}
                    </span>
                </div>
            </div>
        </div>

        @if($isNow)
        <div class="now-strip">
            <span class="now-dot"></span>
            Pelajaran ini sedang berlangsung · Sudah {{ $pct }}% selesai
        </div>
        @endif
    </div>

    {{-- Time visual --}}
    <div class="time-visual">
        <div class="time-block">
            <p class="lbl">Mulai</p>
            <p class="val">{{ $mulai->format('H:i') }}</p>
        </div>
        <div class="time-arrow">
            <div class="time-bar">
                <div class="time-fill" style="width:{{ $isNow ? $pct : 0 }}%"></div>
            </div>
            <span class="time-dur">{{ $durasi }}m</span>
        </div>
        <div class="time-block">
            <p class="lbl">Selesai</p>
            <p class="val">{{ $selesai->format('H:i') }}</p>
        </div>
    </div>

    {{-- Info grid --}}
    <div class="info-grid">
        {{-- Informasi Jadwal --}}
        <div class="info-card">
            <p class="info-card-title">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Informasi Jadwal
            </p>
            <div class="info-row">
                <div class="info-row-icon" style="background:var(--s-50)">
                    <svg width="14" height="14" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div>
                    <p class="info-row-label">Hari</p>
                    <p class="info-row-val">{{ ucfirst($jadwal->hari) }}</p>
                </div>
            </div>
            <div class="info-row">
                <div class="info-row-icon" style="background:var(--a-50)">
                    <svg width="14" height="14" fill="none" stroke="var(--a-500)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div>
                    <p class="info-row-label">Waktu</p>
                    <p class="info-row-val">{{ $mulai->format('H:i') }} – {{ $selesai->format('H:i') }}</p>
                </div>
            </div>
            <div class="info-row">
                <div class="info-row-icon" style="background:var(--g-50)">
                    <svg width="14" height="14" fill="none" stroke="var(--g-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                </div>
                <div>
                    <p class="info-row-label">Ruang</p>
                    <p class="info-row-val">{{ $jadwal->ruang->nama_ruang ?? 'Belum ditentukan' }}</p>
                </div>
            </div>
            @if($jadwal->tahunAjaran)
            <div class="info-row">
                <div class="info-row-icon" style="background:var(--surface3)">
                    <svg width="14" height="14" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/></svg>
                </div>
                <div>
                    <p class="info-row-label">Tahun Ajaran</p>
                    <p class="info-row-val">{{ $jadwal->tahunAjaran->nama ?? '—' }}</p>
                </div>
            </div>
            @endif
        </div>

        {{-- Informasi Mata Pelajaran --}}
        <div class="info-card">
            <p class="info-card-title">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                Mata Pelajaran
            </p>
            <div class="info-row">
                <div class="info-row-icon" style="background:{{ $color }}22">
                    <svg width="14" height="14" fill="none" stroke="{{ $color }}" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
                <div>
                    <p class="info-row-label">Nama</p>
                    <p class="info-row-val">{{ $jadwal->mataPelajaran->nama ?? '—' }}</p>
                </div>
            </div>
            @if($jadwal->mataPelajaran?->kode)
            <div class="info-row">
                <div class="info-row-icon" style="background:var(--surface3)">
                    <svg width="14" height="14" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                </div>
                <div>
                    <p class="info-row-label">Kode</p>
                    <p class="info-row-val">{{ $jadwal->mataPelajaran->kode }}</p>
                </div>
            </div>
            @endif
            <div class="info-row">
                <div class="info-row-icon" style="background:var(--s-50)">
                    <svg width="14" height="14" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div>
                    <p class="info-row-label">Durasi per Sesi</p>
                    <p class="info-row-val">{{ $durasi }} menit</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Guru card --}}
    <div class="guru-card">
        <div class="guru-avatar">
            {{ mb_strtoupper(mb_substr($jadwal->guru->nama_lengkap ?? 'G', 0, 2)) }}
        </div>
        <div>
            <p class="guru-name">{{ $jadwal->guru->nama_lengkap ?? '—' }}</p>
            <p class="guru-nip">NIP: {{ $jadwal->guru->nip ?? 'Tidak tersedia' }}</p>
            <span class="guru-mapel-tag">
                <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/></svg>
                {{ $jadwal->mataPelajaran->nama ?? '—' }}
            </span>
        </div>
    </div>

    {{-- Jadwal mapel sama di hari lain --}}
    @if($jadwalSamMapel->count() > 0)
    <div class="same-section">
        <p class="same-title">
            <svg width="13" height="13" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Pertemuan lain — {{ $jadwal->mataPelajaran->nama ?? '' }}
        </p>
        @foreach($jadwalSamMapel as $j)
        <a href="{{ route('siswa.jadwal.show', $j->id) }}" class="same-item">
            <span class="same-hari-badge">{{ ucfirst($j->hari) }}</span>
            <div>
                <p class="same-jam">
                    {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} –
                    {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                </p>
                @if($j->ruang)
                    <p class="same-ruang">{{ $j->ruang->nama_ruang }}</p>
                @endif
            </div>
            <svg class="same-arrow" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        @endforeach
    </div>
    @endif

    {{-- Back --}}
    <div style="margin-top:20px">
        <a href="{{ route('siswa.jadwal.index') }}" class="btn-back">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali ke Jadwal
        </a>
    </div>

</div>
</x-app-layout>