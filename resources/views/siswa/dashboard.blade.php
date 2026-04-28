<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Instrument+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');

    :root {
        /* Brand */
        --s-900:#0a1628;--s-800:#0f2044;--s-700:#1a3a6b;
        --s-600:#1d4ed8;--s-500:#2563eb;--s-400:#3b82f6;
        --s-300:#93c5fd;--s-100:#dbeafe;--s-50:#eff6ff;

        /* Accent — amber for deadlines/warnings */
        --a-500:#f59e0b;--a-100:#fef3c7;--a-50:#fffbeb;

        /* Success */
        --g-500:#10b981;--g-100:#d1fae5;--g-50:#ecfdf5;

        /* Danger */
        --r-500:#ef4444;--r-100:#fee2e2;--r-50:#fff5f5;

        /* Neutral */
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#334155;--text3:#64748b;--text4:#94a3b8;

        --radius:12px;--radius-sm:8px;--radius-xs:6px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.08),0 1px 2px rgba(0,0,0,.04);
        --shadow-md:0 4px 16px rgba(0,0,0,.08),0 2px 6px rgba(0,0,0,.04);
        --shadow-lg:0 10px 32px rgba(0,0,0,.1),0 4px 12px rgba(0,0,0,.05);
    }

    /* ── Base ── */
    .page { padding: 24px 28px 56px; font-family: 'Instrument Sans', sans-serif; }

    /* ── Hero greeting ── */
    .hero {
        background: linear-gradient(135deg, var(--s-800) 0%, var(--s-600) 60%, var(--s-400) 100%);
        border-radius: var(--radius);
        padding: 28px 32px;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
        color: #fff;
    }
    .hero::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 220px; height: 220px;
        background: rgba(255,255,255,.06);
        border-radius: 50%;
    }
    .hero::after {
        content: '';
        position: absolute;
        bottom: -60px; right: 80px;
        width: 160px; height: 160px;
        background: rgba(255,255,255,.04);
        border-radius: 50%;
    }
    .hero-inner { position: relative; z-index: 1; display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap; }
    .hero-text {}
    .hero-greeting { font-family: 'Outfit', sans-serif; font-size: 13px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; opacity: .7; margin-bottom: 5px; }
    .hero-name { font-family: 'Outfit', sans-serif; font-size: 26px; font-weight: 800; line-height: 1.15; margin-bottom: 6px; }
    .hero-meta { font-size: 13.5px; opacity: .75; display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
    .hero-meta-item { display: flex; align-items: center; gap: 5px; }
    .hero-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.2);
        border-radius: 99px; padding: 6px 14px;
        font-family: 'Outfit', sans-serif; font-size: 12px; font-weight: 700;
        backdrop-filter: blur(8px);
        flex-shrink: 0;
    }
    .hero-absen {
        display: flex; flex-direction: column; align-items: flex-end; gap: 6px; flex-shrink: 0;
    }
    .absen-status {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Outfit', sans-serif; font-size: 13px; font-weight: 700;
        border: 1.5px solid rgba(255,255,255,.3);
    }
    .absen-status.hadir  { background:rgba(16,185,129,.25); border-color:rgba(16,185,129,.5); }
    .absen-status.telat  { background:rgba(245,158,11,.25); border-color:rgba(245,158,11,.5); }
    .absen-status.izin   { background:rgba(59,130,246,.25); border-color:rgba(59,130,246,.5); }
    .absen-status.sakit  { background:rgba(168,85,247,.25); border-color:rgba(168,85,247,.5); }
    .absen-status.alfa   { background:rgba(239,68,68,.25); border-color:rgba(239,68,68,.5); }
    .absen-status.belum  { background:rgba(255,255,255,.1); }
    .absen-scan-link { font-size:12px; opacity:.7; text-decoration:underline; color:#fff; text-underline-offset:3px; }
    .absen-scan-link:hover { opacity:1; }

    /* ── Quick stats ── */
    .stats-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 20px; }
    .stat-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 16px 18px;
        display: flex; align-items: center; gap: 13px;
        box-shadow: var(--shadow-sm); transition: box-shadow .2s, transform .2s;
        text-decoration: none;
    }
    .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-1px); }
    .stat-icon { width: 42px; height: 42px; border-radius: 11px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .si-blue { background: var(--s-50); }
    .si-green { background: var(--g-50); }
    .si-amber { background: var(--a-50); }
    .si-red { background: var(--r-50); }
    .si-slate { background: var(--surface3); }
    .stat-label { font-family: 'Outfit', sans-serif; font-size: 11px; font-weight: 700; color: var(--text4); letter-spacing: .05em; text-transform: uppercase; }
    .stat-val { font-family: 'Outfit', sans-serif; font-size: 24px; font-weight: 800; color: var(--text); line-height: 1.1; margin-top: 1px; }
    .stat-sub { font-size: 11.5px; color: var(--text4); margin-top: 1px; }

    /* ── Main grid ── */
    .main-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
    .full-width { grid-column: 1 / -1; }

    /* ── Cards ── */
    .card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .card-hd {
        display: flex; align-items: center; justify-content: space-between;
        padding: 14px 18px; border-bottom: 1px solid var(--border);
        background: var(--surface);
    }
    .card-title {
        font-family: 'Outfit', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--text);
        display: flex; align-items: center; gap: 7px;
    }
    .card-link {
        font-family: 'Outfit', sans-serif; font-size: 12px; font-weight: 700;
        color: var(--s-500); text-decoration: none;
        display: flex; align-items: center; gap: 3px;
        transition: color .15s;
    }
    .card-link:hover { color: var(--s-700); }

    /* ── Pill / count badge ── */
    .pill {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 2px 8px; border-radius: 99px;
        font-family: 'Outfit', sans-serif; font-size: 11px; font-weight: 700;
    }
    .pill-red { background: var(--r-100); color: var(--r-500); }
    .pill-blue { background: var(--s-100); color: var(--s-600); }
    .pill-green { background: var(--g-100); color: var(--g-500); }
    .pill-amber { background: var(--a-100); color: var(--a-500); }
    .pill-slate { background: var(--surface3); color: var(--text3); }

    /* ── Jadwal items ── */
    .jadwal-list { padding: 0; }
    .jadwal-item {
        display: flex; align-items: center; gap: 13px;
        padding: 11px 18px; border-bottom: 1px solid var(--border);
        transition: background .1s;
    }
    .jadwal-item:last-child { border-bottom: none; }
    .jadwal-item:hover { background: var(--surface2); }
    .jadwal-time {
        flex-shrink: 0; min-width: 72px; text-align: center;
        background: var(--s-50); border: 1px solid var(--s-100);
        border-radius: var(--radius-xs); padding: 5px 8px;
    }
    .jadwal-time .jam { font-family: 'Outfit', sans-serif; font-size: 12px; font-weight: 700; color: var(--s-600); }
    .jadwal-time .dur { font-size: 10.5px; color: var(--text4); margin-top: 1px; font-family: 'Instrument Sans', sans-serif; }
    .jadwal-dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; background: var(--s-400); }
    .jadwal-dot.active { background: var(--g-500); box-shadow: 0 0 0 4px rgba(16,185,129,.15); animation: blink 2s ease-in-out infinite; }
    @keyframes blink { 0%,100%{opacity:1}50%{opacity:.5} }
    .jadwal-mapel { font-family: 'Outfit', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--text); }
    .jadwal-guru { font-size: 12px; color: var(--text4); margin-top: 1px; }
    .jadwal-ruang { flex-shrink: 0; font-family: 'Outfit', sans-serif; font-size: 11px; font-weight: 700; color: var(--text3); background: var(--surface3); padding: 3px 9px; border-radius: 99px; }

    /* ── Tugas items ── */
    .tugas-item {
        display: flex; align-items: flex-start; gap: 12px;
        padding: 12px 18px; border-bottom: 1px solid var(--border);
        transition: background .1s; text-decoration: none;
    }
    .tugas-item:last-child { border-bottom: none; }
    .tugas-item:hover { background: var(--surface2); }
    .tugas-urgency {
        width: 4px; flex-shrink: 0; border-radius: 99px; align-self: stretch; min-height: 36px;
    }
    .urg-red { background: var(--r-500); }
    .urg-amber { background: var(--a-500); }
    .urg-blue { background: var(--s-400); }
    .tugas-main { flex: 1; }
    .tugas-judul { font-family: 'Outfit', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--text); margin-bottom: 3px; }
    .tugas-mapel { font-size: 12px; color: var(--text4); }
    .tugas-deadline {
        flex-shrink: 0; text-align: right;
    }
    .deadline-label { font-family: 'Outfit', sans-serif; font-size: 11.5px; font-weight: 700; }
    .deadline-red { color: var(--r-500); }
    .deadline-amber { color: var(--a-500); }
    .deadline-blue { color: var(--s-500); }
    .deadline-sub { font-size: 11px; color: var(--text4); margin-top: 1px; }

    /* ── Ujian items ── */
    .ujian-item {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 18px; border-bottom: 1px solid var(--border);
        text-decoration: none; transition: background .1s;
    }
    .ujian-item:last-child { border-bottom: none; }
    .ujian-item:hover { background: var(--surface2); }
    .ujian-icon { width: 38px; height: 38px; border-radius: 10px; background: var(--r-50); border: 1px solid var(--r-100); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .ujian-icon.mendatang { background: var(--a-50); border-color: var(--a-100); }
    .ujian-nama { font-family: 'Outfit', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--text); }
    .ujian-meta { font-size: 12px; color: var(--text4); margin-top: 2px; }
    .ujian-action { flex-shrink: 0; }
    .btn-ujian {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 14px; border-radius: var(--radius-xs);
        font-family: 'Outfit', sans-serif; font-size: 12px; font-weight: 700;
        background: var(--r-500); color: #fff; text-decoration: none;
        transition: background .15s;
    }
    .btn-ujian:hover { background: #dc2626; }
    .btn-ujian.mendatang { background: var(--a-500); }
    .btn-ujian.mendatang:hover { background: #d97706; }

    /* ── Materi items ── */
    .materi-item {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 18px; border-bottom: 1px solid var(--border);
        text-decoration: none; transition: background .1s;
    }
    .materi-item:last-child { border-bottom: none; }
    .materi-item:hover { background: var(--surface2); }
    .materi-icon { width: 36px; height: 36px; border-radius: 9px; background: var(--g-50); border: 1px solid var(--g-100); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .materi-judul { font-family: 'Outfit', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .materi-mapel { font-size: 11.5px; color: var(--text4); margin-top: 1px; }
    .materi-date { font-size: 11px; color: var(--text4); flex-shrink: 0; }

    /* ── Nilai items ── */
    .nilai-item {
        display: flex; align-items: center; gap: 13px;
        padding: 11px 18px; border-bottom: 1px solid var(--border);
        transition: background .1s;
    }
    .nilai-item:last-child { border-bottom: none; }
    .nilai-item:hover { background: var(--surface2); }
    .nilai-score {
        width: 44px; height: 44px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Outfit', sans-serif; font-size: 16px; font-weight: 800;
        flex-shrink: 0;
    }
    .ns-a { background: var(--g-50); color: var(--g-500); border: 1.5px solid var(--g-100); }
    .ns-b { background: var(--s-50); color: var(--s-600); border: 1.5px solid var(--s-100); }
    .ns-c { background: var(--a-50); color: var(--a-500); border: 1.5px solid var(--a-100); }
    .ns-d { background: var(--r-50); color: var(--r-500); border: 1.5px solid var(--r-100); }
    .nilai-mapel { font-family: 'Outfit', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--text); }
    .nilai-jenis { font-size: 12px; color: var(--text4); margin-top: 2px; }
    .nilai-date { font-size: 11px; color: var(--text4); flex-shrink: 0; margin-left: auto; }

    /* ── Progress attendance ── */
    .attend-wrap { padding: 16px 18px; }
    .attend-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 10px; margin-bottom: 14px; }
    .attend-box { text-align: center; padding: 10px 8px; border-radius: var(--radius-sm); }
    .ab-hadir { background: var(--g-50); border: 1px solid var(--g-100); }
    .ab-izin  { background: var(--s-50); border: 1px solid var(--s-100); }
    .ab-sakit { background: #faf5ff; border: 1px solid #e9d5ff; }
    .ab-alfa  { background: var(--r-50); border: 1px solid var(--r-100); }
    .ab-val { font-family: 'Outfit', sans-serif; font-size: 22px; font-weight: 800; line-height: 1; }
    .ab-hadir .ab-val { color: var(--g-500); }
    .ab-izin  .ab-val { color: var(--s-600); }
    .ab-sakit .ab-val { color: #7c3aed; }
    .ab-alfa  .ab-val { color: var(--r-500); }
    .ab-label { font-family: 'Outfit', sans-serif; font-size: 11px; font-weight: 700; color: var(--text4); text-transform: uppercase; letter-spacing: .04em; margin-top: 3px; }
    .progress-row { display: flex; align-items: center; gap: 10px; }
    .progress-bar { flex: 1; height: 8px; background: var(--surface3); border-radius: 99px; overflow: hidden; }
    .progress-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, var(--g-500), #34d399); transition: width .8s ease; }
    .progress-pct { font-family: 'Outfit', sans-serif; font-size: 13px; font-weight: 800; color: var(--g-500); flex-shrink: 0; }
    .progress-label { font-size: 11.5px; color: var(--text4); margin-top: 4px; }

    /* ── Empty state ── */
    .empty { padding: 32px 16px; text-align: center; }
    .empty-icon { width: 44px; height: 44px; background: var(--surface3); border-radius: 11px; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; }
    .empty p { font-size: 13px; color: var(--text4); font-family: 'Instrument Sans', sans-serif; }

    /* ── Notifikasi items ── */
    .notif-item {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 11px 18px; border-bottom: 1px solid var(--border);
        transition: background .1s; text-decoration: none;
    }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: var(--surface2); }
    .notif-item.unread { background: var(--s-50); }
    .notif-item.unread:hover { background: var(--s-100); }
    .notif-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--s-500); flex-shrink: 0; margin-top: 5px; }
    .notif-dot.read { background: var(--border); }
    .notif-title { font-family: 'Outfit', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); margin-bottom: 2px; }
    .notif-time { font-size: 11.5px; color: var(--text4); }

    /* ── Responsive ── */
    @media (max-width: 900px) { .main-grid { grid-template-columns: 1fr; } }
    @media (max-width: 700px) { .stats-row { grid-template-columns: 1fr 1fr; } .hero-absen { display: none; } }
    @media (max-width: 480px) { .page { padding: 14px 14px 48px; } .hero { padding: 20px; } .hero-name { font-size: 20px; } }
</style>

<div class="page">

    {{-- ════════════════════════════════ HERO ════════════════════════════════ --}}
    <div class="hero">
        <div class="hero-inner">
            <div class="hero-text">
                <p class="hero-greeting">
                    {{ now()->hour < 12 ? 'Selamat Pagi' : (now()->hour < 17 ? 'Selamat Siang' : 'Selamat Sore') }},
                </p>
                <h1 class="hero-name">{{ $siswa->nama_lengkap }}</h1>
                <div class="hero-meta">
                    <span class="hero-meta-item">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                        {{ $siswa->kelas->nama_kelas ?? 'Kelas -' }}
                    </span>
                    <span class="hero-meta-item">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        NIS: {{ $siswa->nis ?? '-' }}
                    </span>
                    <span class="hero-meta-item">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </span>
                </div>
            </div>

            {{-- Absensi status --}}
            <div class="hero-absen">
                @if($absensiHariIni)
                    <div class="absen-status {{ $absensiHariIni->status }}">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Absen: {{ ucfirst($absensiHariIni->status) }}
                        @if($absensiHariIni->jam_masuk)
                            · {{ \Carbon\Carbon::parse($absensiHariIni->jam_masuk)->format('H:i') }}
                        @endif
                    </div>
                @else
                    <div class="absen-status belum">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Belum Absen Hari Ini
                    </div>
                    <a href="{{ route('siswa.absensi.scan') }}" class="absen-scan-link">Scan QR Sekarang →</a>
                @endif
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════ QUICK STATS ════════════════════════════════ --}}
    <div class="stats-row">
        {{-- Kehadiran bulan ini --}}
        <div class="stat-card">
            <div class="stat-icon si-green">
                <svg width="20" height="20" fill="none" stroke="#10b981" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Kehadiran</p>
                <p class="stat-val">{{ $persentaseHadir }}<span style="font-size:14px;font-weight:600">%</span></p>
                <p class="stat-sub">bulan {{ now()->locale('id')->isoFormat('MMMM') }}</p>
            </div>
        </div>

        {{-- Tugas belum dikumpul --}}
        <a href="{{ route('siswa.tugas.index') }}" class="stat-card">
            <div class="stat-icon si-amber">
                <svg width="20" height="20" fill="none" stroke="#f59e0b" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <div>
                <p class="stat-label">Tugas Pending</p>
                <p class="stat-val">{{ $tugasBelumDikumpulkan->count() }}</p>
                <p class="stat-sub">belum dikumpulkan</p>
            </div>
        </a>

        {{-- Ujian aktif --}}
        <a href="{{ route('siswa.ujian.index') }}" class="stat-card">
            <div class="stat-icon si-red">
                <svg width="20" height="20" fill="none" stroke="#ef4444" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            <div>
                <p class="stat-label">Ujian Aktif</p>
                <p class="stat-val">{{ $ujianAktif->count() }}</p>
                <p class="stat-sub">sedang berlangsung</p>
            </div>
        </a>

        {{-- Rata-rata nilai --}}
        <a href="{{ route('siswa.nilai.index') }}" class="stat-card">
            <div class="stat-icon si-blue">
                <svg width="20" height="20" fill="none" stroke="#2563eb" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
            <div>
                <p class="stat-label">Rata-rata Nilai</p>
                <p class="stat-val">{{ number_format($rataRataNilai, 0) }}</p>
                <p class="stat-sub">bulan ini</p>
            </div>
        </a>
    </div>

    {{-- ════════════════════════════════ MAIN GRID ════════════════════════════════ --}}
    <div class="main-grid">

        {{-- ── Jadwal Hari Ini ── --}}
        <div class="card">
            <div class="card-hd">
                <span class="card-title">
                    <svg width="14" height="14" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Jadwal Hari Ini
                    <span class="pill pill-blue">{{ $jadwalHariIni->count() }}</span>
                </span>
                <a href="{{ route('siswa.jadwal.index') }}" class="card-link">
                    Semua <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
            <div class="jadwal-list">
                @forelse($jadwalHariIni as $j)
                @php
                    $jamMulai   = \Carbon\Carbon::parse($j->jam_mulai);
                    $jamSelesai = \Carbon\Carbon::parse($j->jam_selesai);
                    $isNow      = now()->between($jamMulai, $jamSelesai);
                    $durasi     = $jamMulai->diffInMinutes($jamSelesai);
                @endphp
                <div class="jadwal-item">
                    <div class="jadwal-time">
                        <p class="jam">{{ $jamMulai->format('H:i') }}</p>
                        <p class="dur">{{ $durasi }}m</p>
                    </div>
                    <div class="jadwal-dot {{ $isNow ? 'active' : '' }}"></div>
                    <div style="flex:1">
                        <p class="jadwal-mapel">{{ $j->mataPelajaran->nama ?? '—' }}</p>
                        <p class="jadwal-guru">{{ $j->guru->nama_lengkap ?? '—' }}</p>
                    </div>
                    @if($j->ruang)
                        <span class="jadwal-ruang">{{ $j->ruang->nama_ruang ?? '' }}</span>
                    @endif
                </div>
                @empty
                <div class="empty">
                    <div class="empty-icon">
                        <svg width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <p>Tidak ada jadwal hari ini</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- ── Kehadiran Bulan Ini ── --}}
        <div class="card">
            <div class="card-hd">
                <span class="card-title">
                    <svg width="14" height="14" fill="none" stroke="var(--g-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Kehadiran {{ now()->locale('id')->isoFormat('MMMM Y') }}
                </span>
                <a href="{{ route('siswa.absensi.rekap') }}" class="card-link">
                    Rekap <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
            <div class="attend-wrap">
                <div class="attend-grid">
                    <div class="attend-box ab-hadir">
                        <p class="ab-val">{{ $rekapBulanIni['hadir'] }}</p>
                        <p class="ab-label">Hadir</p>
                    </div>
                    <div class="attend-box ab-izin">
                        <p class="ab-val">{{ $rekapBulanIni['izin'] }}</p>
                        <p class="ab-label">Izin</p>
                    </div>
                    <div class="attend-box ab-sakit">
                        <p class="ab-val">{{ $rekapBulanIni['sakit'] }}</p>
                        <p class="ab-label">Sakit</p>
                    </div>
                    <div class="attend-box ab-alfa">
                        <p class="ab-val">{{ $rekapBulanIni['alfa'] }}</p>
                        <p class="ab-label">Alfa</p>
                    </div>
                </div>
                <div class="progress-row">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width:{{ $persentaseHadir }}%"></div>
                    </div>
                    <span class="progress-pct">{{ $persentaseHadir }}%</span>
                </div>
                <p class="progress-label">
                    Tingkat kehadiran dari {{ $totalHariEfektif }} hari efektif tercatat
                </p>
            </div>
        </div>

        {{-- ── Tugas Belum Dikumpulkan ── --}}
        <div class="card">
            <div class="card-hd">
                <span class="card-title">
                    <svg width="14" height="14" fill="none" stroke="var(--a-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Tugas Pending
                    @if($tugasBelumDikumpulkan->count() > 0)
                        <span class="pill pill-amber">{{ $tugasBelumDikumpulkan->count() }}</span>
                    @endif
                </span>
                <a href="{{ route('siswa.tugas.index') }}" class="card-link">
                    Semua <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
            @forelse($tugasBelumDikumpulkan as $t)
            @php
                $deadline    = $t->batas_waktu;
                $diffHours   = now()->diffInHours($deadline, false);
                $urgClass    = $diffHours < 0 ? 'urg-red' : ($diffHours < 24 ? 'urg-amber' : 'urg-blue');
                $deadClass   = $diffHours < 0 ? 'deadline-red' : ($diffHours < 24 ? 'deadline-amber' : 'deadline-blue');
                $deadLabel   = $diffHours < 0
                    ? 'Terlambat ' . abs(round($diffHours)) . 'j'
                    : ($diffHours < 24
                        ? 'Sisa ' . round($diffHours) . ' jam'
                        : $deadline->locale('id')->isoFormat('D MMM'));
            @endphp
            <a href="{{ route('siswa.tugas.show', $t->id) }}" class="tugas-item">
                <div class="tugas-urgency {{ $urgClass }}"></div>
                <div class="tugas-main">
                    <p class="tugas-judul">{{ $t->judul }}</p>
                    <p class="tugas-mapel">{{ $t->mataPelajaran->nama ?? '—' }} · {{ $t->guru->nama_lengkap ?? '—' }}</p>
                </div>
                <div class="tugas-deadline">
                    <p class="deadline-label {{ $deadClass }}">{{ $deadLabel }}</p>
                    <p class="deadline-sub">{{ $deadline->format('H:i') }}</p>
                </div>
            </a>
            @empty
            <div class="empty">
                <div class="empty-icon">
                    <svg width="18" height="18" fill="none" stroke="#10b981" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <p style="color:#10b981;font-weight:700;font-family:'Outfit',sans-serif">Semua tugas sudah dikumpulkan!</p>
            </div>
            @endforelse
        </div>

        {{-- ── Ujian Aktif & Mendatang ── --}}
        <div class="card">
            <div class="card-hd">
                <span class="card-title">
                    <svg width="14" height="14" fill="none" stroke="var(--r-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    Ujian
                    @if($ujianAktif->count() > 0)
                        <span class="pill pill-red">{{ $ujianAktif->count() }} berlangsung</span>
                    @endif
                </span>
                <a href="{{ route('siswa.ujian.index') }}" class="card-link">
                    Semua <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>

            {{-- Ujian sedang berlangsung --}}
            @foreach($ujianAktif as $u)
            <a href="{{ route('siswa.ujian.mulai', $u->id) }}" class="ujian-item">
                <div class="ujian-icon">
                    <svg width="16" height="16" fill="none" stroke="#ef4444" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div style="flex:1">
                    <p class="ujian-nama">{{ $u->judul }}</p>
                    <p class="ujian-meta">{{ $u->mataPelajaran->nama ?? '—' }} · Selesai {{ $u->waktu_berakhir?->format('H:i') ?? '-' }}</p>
                </div>
                <div class="ujian-action">
                    <span class="btn-ujian">
                        Mulai
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </span>
                </div>
            </a>
            @endforeach

            {{-- Ujian mendatang --}}
            @foreach($ujianMendatang as $u)
            <div class="ujian-item">
                <div class="ujian-icon mendatang">
                    <svg width="16" height="16" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div style="flex:1">
                    <p class="ujian-nama">{{ $u->judul }}</p>
                    <p class="ujian-meta">{{ $u->mataPelajaran->nama ?? '—' }} · {{ $u->waktu_mulai?->locale('id')->isoFormat('D MMM, H:i') ?? '-' }}</p>
                </div>
                <span class="pill pill-amber">Mendatang</span>
            </div>
            @endforeach

            @if($ujianAktif->isEmpty() && $ujianMendatang->isEmpty())
            <div class="empty">
                <div class="empty-icon">
                    <svg width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/></svg>
                </div>
                <p>Tidak ada ujian berlangsung</p>
            </div>
            @endif
        </div>

        {{-- ── Materi Terbaru ── --}}
        <div class="card">
            <div class="card-hd">
                <span class="card-title">
                    <svg width="14" height="14" fill="none" stroke="var(--g-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    Materi Terbaru
                </span>
                <a href="{{ route('siswa.materi.index') }}" class="card-link">
                    Semua <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
            @forelse($materiTerbaru as $m)
            <a href="{{ route('siswa.materi.show', $m->id) }}" class="materi-item">
                <div class="materi-icon">
                    <svg width="16" height="16" fill="none" stroke="#10b981" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div style="flex:1">
                    <p class="materi-judul">{{ $m->judul }}</p>
                    <p class="materi-mapel">{{ $m->mataPelajaran->nama ?? '—' }}</p>
                </div>
                <span class="materi-date">{{ $m->created_at->locale('id')->isoFormat('D MMM') }}</span>
            </a>
            @empty
            <div class="empty">
                <div class="empty-icon">
                    <svg width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/></svg>
                </div>
                <p>Belum ada materi tersedia</p>
            </div>
            @endforelse
        </div>

        {{-- ── Nilai Terbaru ── --}}
        <div class="card">
            <div class="card-hd">
                <span class="card-title">
                    <svg width="14" height="14" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Nilai Terbaru
                </span>
                <a href="{{ route('siswa.nilai.index') }}" class="card-link">
                    Semua <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
            @forelse($nilaiTerbaru as $n)
            @php
                $score = $n->nilai_akhir ?? 0;
                $ns = $score >= 90 ? 'ns-a' : ($score >= 75 ? 'ns-b' : ($score >= 60 ? 'ns-c' : 'ns-d'));
            @endphp
            <div class="nilai-item">
                <div class="nilai-score {{ $ns }}">{{ round($score) }}</div>
                <div>
                    <p class="nilai-mapel">{{ $n->mataPelajaran->nama ?? '—' }}</p>
                    <p class="nilai-jenis">Predikat: {{ $n->predikat ?? '—' }}</p>
                </div>
                <span class="nilai-date">{{ $n->created_at->locale('id')->isoFormat('D MMM') }}</span>
            </div>
            @empty
            <div class="empty">
                <div class="empty-icon">
                    <svg width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
                <p>Belum ada nilai tersedia</p>
            </div>
            @endforelse
        </div>

        {{-- ── Notifikasi Terbaru ── --}}
        <div class="card">
            <div class="card-hd">
                <span class="card-title">
                    <svg width="14" height="14" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    Notifikasi
                    @if($unreadNotifikasi > 0)
                        <span class="pill pill-red">{{ $unreadNotifikasi }} baru</span>
                    @endif
                </span>
                <a href="{{ route('siswa.notifikasi.index') }}" class="card-link">
                    Semua <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
            @forelse($notifikasiTerbaru as $notif)
            <a href="{{ route('siswa.notifikasi.show', $notif->id) }}" class="notif-item {{ !$notif->sudah_dibaca ? 'unread' : '' }}">
                <div class="notif-dot {{ $notif->sudah_dibaca ? 'read' : '' }}"></div>
                <div>
                    <p class="notif-title">{{ $notif->judul ?? $notif->pesan }}</p>
                    <p class="notif-time">{{ $notif->created_at->diffForHumans() }}</p>
                </div>
            </a>
            @empty
            <div class="empty">
                <div class="empty-icon">
                    <svg width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/></svg>
                </div>
                <p>Tidak ada notifikasi terbaru</p>
            </div>
            @endforelse
        </div>

    </div>{{-- /main-grid --}}

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2800,showConfirmButton:false,toast:true,position:'top-end'});
@endif
@if(session('error'))
Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#2563eb'});
@endif

/* ── Auto-refresh absensi status setiap 60 detik ── */
@if(!$absensiHariIni)
setTimeout(() => location.reload(), 60000);
@endif
</script>
</x-app-layout>