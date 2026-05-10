<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Instrument+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');

    :root {
        --s-800:#0f2044;--s-700:#1a3a6b;--s-600:#1d4ed8;--s-500:#2563eb;
        --s-400:#3b82f6;--s-300:#93c5fd;--s-100:#dbeafe;--s-50:#eff6ff;
        --g-500:#10b981;--g-400:#34d399;--g-100:#d1fae5;--g-50:#ecfdf5;
        --a-500:#f59e0b;--a-100:#fef3c7;--a-50:#fffbeb;
        --r-500:#ef4444;--r-100:#fee2e2;--r-50:#fff5f5;
        --v-500:#8b5cf6;--v-100:#ede9fe;--v-50:#f5f3ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#334155;--text3:#64748b;--text4:#94a3b8;
        --radius:12px;--radius-sm:8px;--radius-xs:6px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.07);
        --shadow-md:0 4px 16px rgba(0,0,0,.08);
        --shadow-lg:0 8px 32px rgba(0,0,0,.12);
    }

    * { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Instrument Sans',sans-serif; }
    .page { padding:24px 28px 64px; }

    /* ── Header ── */
    .page-header { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:24px; flex-wrap:wrap; }
    .page-title { font-family:'Outfit',sans-serif; font-size:21px; font-weight:800; color:var(--text); }
    .page-sub { font-size:12.5px; color:var(--text4); margin-top:3px; }
    .header-actions { display:flex; gap:8px; align-items:center; }

    /* ── Grid layout ── */
    .main-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; align-items:start; }
    .col-full { grid-column:1/-1; }

    /* ── Section label ── */
    .section-label {
        font-family:'Outfit',sans-serif; font-size:11px; font-weight:800;
        letter-spacing:.08em; text-transform:uppercase; color:var(--text4);
        margin-bottom:10px;
    }

    /* ── Card base ── */
    .card {
        background:var(--surface); border:1px solid var(--border);
        border-radius:var(--radius); box-shadow:var(--shadow-sm); overflow:hidden;
    }
    .card-header {
        display:flex; align-items:center; justify-content:space-between;
        padding:16px 20px; border-bottom:1px solid var(--border);
    }
    .card-header-title {
        font-family:'Outfit',sans-serif; font-size:14px; font-weight:700; color:var(--text);
        display:flex; align-items:center; gap:8px;
    }
    .card-body { padding:20px; }

    /* ── Barcode Card ── */
    .barcode-card {
        background:linear-gradient(145deg,var(--s-800) 0%,var(--s-700) 60%,#1e3a8a 100%);
        border:none; box-shadow:var(--shadow-lg); position:relative; overflow:hidden;
    }
    .barcode-card::before {
        content:''; position:absolute; top:-40px; right:-40px;
        width:180px; height:180px; border-radius:50%;
        background:rgba(255,255,255,.04); pointer-events:none;
    }
    .barcode-card::after {
        content:''; position:absolute; bottom:-30px; left:-20px;
        width:120px; height:120px; border-radius:50%;
        background:rgba(255,255,255,.03); pointer-events:none;
    }
    .barcode-card-header {
        display:flex; align-items:center; justify-content:space-between;
        padding:18px 20px 0; position:relative; z-index:1;
    }
    .barcode-card-title {
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:700;
        color:rgba(255,255,255,.7); display:flex; align-items:center; gap:8px;
    }
    .barcode-status {
        display:flex; align-items:center; gap:5px;
        font-family:'Outfit',sans-serif; font-size:11px; font-weight:700;
        padding:4px 10px; border-radius:99px;
    }
    .barcode-status.aktif { background:rgba(16,185,129,.2); color:#6ee7b7; border:1px solid rgba(16,185,129,.3); }
    .barcode-status.kosong { background:rgba(239,68,68,.2); color:#fca5a5; border:1px solid rgba(239,68,68,.3); }
    .barcode-status.menunggu { background:rgba(245,158,11,.2); color:#fcd34d; border:1px solid rgba(245,158,11,.3); }
    .barcode-status-dot { width:6px; height:6px; border-radius:50%; }
    .barcode-status.aktif .barcode-status-dot { background:#6ee7b7; animation:pulse-dot 1.4s ease-in-out infinite; }
    .barcode-status.kosong .barcode-status-dot { background:#fca5a5; }
    .barcode-status.menunggu .barcode-status-dot { background:#fcd34d; animation:pulse-dot 1.4s ease-in-out infinite; }
    @keyframes pulse-dot { 0%,100%{opacity:1}50%{opacity:.4} }

    .barcode-display { padding:24px 20px 20px; display:flex; flex-direction:column; align-items:center; position:relative; z-index:1; }
    .barcode-wrap {
        background:#fff; border-radius:10px; padding:16px 20px 12px;
        width:100%; max-width:280px; text-align:center;
        box-shadow:0 4px 20px rgba(0,0,0,.3);
    }
    .barcode-wrap svg { width:100%; height:auto; }
    .barcode-kode {
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:700;
        color:var(--text2); margin-top:8px; letter-spacing:.06em;
    }
    .barcode-siswa { margin-top:14px; text-align:center; }
    .barcode-nama { font-family:'Outfit',sans-serif; font-size:15px; font-weight:800; color:#fff; }
    .barcode-info {
        font-size:12px; color:rgba(255,255,255,.55); margin-top:4px;
        display:flex; align-items:center; justify-content:center; gap:8px;
    }
    .barcode-info span { display:flex; align-items:center; gap:4px; }
    .barcode-dot-sep { width:3px; height:3px; border-radius:50%; background:rgba(255,255,255,.3); }

    .barcode-actions { display:flex; gap:8px; width:100%; max-width:280px; margin-top:16px; }
    .btn-barcode {
        flex:1; height:38px; border-radius:var(--radius-xs);
        font-family:'Outfit',sans-serif; font-size:12.5px; font-weight:700;
        display:flex; align-items:center; justify-content:center; gap:6px;
        cursor:pointer; border:none; text-decoration:none; transition:all .15s;
    }
    .btn-barcode-primary { background:rgba(255,255,255,.15); color:#fff; border:1px solid rgba(255,255,255,.2); }
    .btn-barcode-primary:hover { background:rgba(255,255,255,.25); }
    .btn-barcode-secondary { background:rgba(255,255,255,.08); color:rgba(255,255,255,.7); border:1px solid rgba(255,255,255,.1); }
    .btn-barcode-secondary:hover { background:rgba(255,255,255,.15); color:#fff; }

    .barcode-empty { padding:36px 20px; text-align:center; position:relative; z-index:1; }
    .barcode-empty-icon { width:64px; height:64px; background:rgba(255,255,255,.08); border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }
    .barcode-empty-title { font-family:'Outfit',sans-serif; font-size:15px; font-weight:700; color:#fff; margin-bottom:6px; }
    .barcode-empty-sub { font-size:12.5px; color:rgba(255,255,255,.5); line-height:1.5; }

    /* ── Sesi Mapel Card ── */
    .sesi-list { display:flex; flex-direction:column; }
    .sesi-item {
        display:flex; align-items:center; gap:14px;
        padding:14px 20px; border-bottom:1px solid rgba(255,255,255,.08);
        transition:background .12s;
    }
    .sesi-item:last-child { border-bottom:none; }
    .sesi-item:hover { background:rgba(255,255,255,.05); }
    .sesi-icon {
        width:42px; height:42px; border-radius:10px; flex-shrink:0;
        display:flex; align-items:center; justify-content:center;
        background:rgba(255,255,255,.1);
    }
    .sesi-body { flex:1; min-width:0; }
    .sesi-mapel { font-family:'Outfit',sans-serif; font-size:13.5px; font-weight:700; color:#fff; }
    .sesi-meta { font-size:11.5px; color:rgba(255,255,255,.45); margin-top:3px; display:flex; align-items:center; gap:8px; }
    .sesi-right { flex-shrink:0; text-align:right; }
    .sesi-countdown {
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:800;
        color:var(--g-400); display:flex; align-items:center; gap:4px;
    }
    .sesi-countdown.expiring { color:var(--a-500); }
    .sesi-badge {
        font-size:10.5px; font-weight:700; font-family:'Outfit',sans-serif;
        padding:3px 8px; border-radius:99px; margin-top:4px; display:inline-block;
    }
    .sesi-badge.aktif { background:rgba(16,185,129,.2); color:#6ee7b7; border:1px solid rgba(16,185,129,.3); }
    .sesi-badge.belum { background:rgba(255,255,255,.1); color:rgba(255,255,255,.5); border:1px solid rgba(255,255,255,.15); }

    .sesi-empty { padding:40px 20px; text-align:center; }
    .sesi-empty-title { font-family:'Outfit',sans-serif; font-size:13.5px; font-weight:700; color:var(--text2); margin-bottom:4px; }
    .sesi-empty-sub { font-size:12px; color:var(--text4); line-height:1.5; }

    /* ── Sesi Gerbang banner ── */
    .gerbang-banner {
        display:flex; align-items:center; gap:12px;
        padding:12px 20px; margin-bottom:0;
        border-top:1px solid rgba(255,255,255,.08);
        background:rgba(255,255,255,.04);
        position:relative; z-index:1;
    }
    .gerbang-banner-icon {
        width:36px; height:36px; border-radius:8px; flex-shrink:0;
        display:flex; align-items:center; justify-content:center;
    }
    .gerbang-banner-icon.masuk { background:rgba(16,185,129,.15); }
    .gerbang-banner-icon.pulang { background:rgba(245,158,11,.15); }
    .gerbang-banner-text { flex:1; }
    .gerbang-banner-title { font-family:'Outfit',sans-serif; font-size:12.5px; font-weight:700; }
    .gerbang-banner-title.masuk { color:#6ee7b7; }
    .gerbang-banner-title.pulang { color:#fcd34d; }
    .gerbang-banner-sub { font-size:11.5px; color:rgba(255,255,255,.4); margin-top:2px; }

    /* ── Jadwal ── */
    .jadwal-list { display:flex; flex-direction:column; }
    .jadwal-row {
        display:grid; grid-template-columns:60px 3px 1fr auto;
        align-items:stretch; border-bottom:1px solid var(--border);
    }
    .jadwal-row:last-child { border-bottom:none; }
    .jadwal-row.now { background:linear-gradient(90deg,rgba(37,99,235,.04),transparent); }
    .jadwal-time {
        padding:12px 10px; display:flex; flex-direction:column;
        align-items:center; justify-content:center; border-right:1px solid var(--border);
    }
    .jadwal-time .jam { font-family:'Outfit',sans-serif; font-size:12.5px; font-weight:800; color:var(--text2); }
    .jadwal-time .durasi { font-size:10px; color:var(--text4); margin-top:3px; }
    .jadwal-stripe { width:3px; flex-shrink:0; }
    .jadwal-body { padding:12px 14px; display:flex; flex-direction:column; justify-content:center; }
    .jadwal-mapel { font-family:'Outfit',sans-serif; font-size:13px; font-weight:700; color:var(--text); }
    .jadwal-guru { font-size:11.5px; color:var(--text4); margin-top:2px; }
    .jadwal-right { padding:12px 14px; display:flex; align-items:center; }
    .now-pill {
        font-family:'Outfit',sans-serif; font-size:10.5px; font-weight:700;
        background:var(--g-50); color:var(--g-500); border:1px solid var(--g-100);
        padding:3px 8px; border-radius:99px; display:flex; align-items:center; gap:4px;
        white-space:nowrap;
    }
    .now-dot-sm { width:5px; height:5px; border-radius:50%; background:var(--g-500); animation:pulse-dot 1.4s infinite; }

    .stripe-0{background:#2563eb}.stripe-1{background:#10b981}.stripe-2{background:#f59e0b}
    .stripe-3{background:#ef4444}.stripe-4{background:#8b5cf6}.stripe-5{background:#ec4899}
    .stripe-6{background:#0891b2}.stripe-7{background:#65a30d}

    /* ── Live badge ── */
    .live-badge {
        display:inline-flex; align-items:center; gap:5px;
        background:var(--r-50); border:1px solid var(--r-100); color:var(--r-500);
        font-family:'Outfit',sans-serif; font-size:11px; font-weight:700;
        padding:3px 9px; border-radius:99px;
    }
    .live-dot { width:6px; height:6px; border-radius:50%; background:var(--r-500); animation:pulse-dot 1.4s infinite; }

    /* ── Alert flash ── */
    .alert {
        display:flex; align-items:center; gap:10px;
        padding:12px 16px; border-radius:var(--radius-sm); margin-bottom:18px;
        font-size:13px;
    }
    .alert-warning { background:var(--a-50); border:1px solid var(--a-100); color:#92400e; }
    .alert-success { background:var(--g-50); border:1px solid var(--g-100); color:#065f46; }
    .alert-info    { background:var(--s-50); border:1px solid var(--s-100); color:#1e40af; }

    @media(max-width:768px) {
        .page { padding:14px 14px 56px; }
        .main-grid { grid-template-columns:1fr; }
        .col-full { grid-column:1; }
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Barcode Saya</h1>
            <p class="page-sub">{{ $siswa->nama_lengkap }} &nbsp;·&nbsp; {{ $siswa->kelas->nama_kelas ?? '—' }}</p>
        </div>
        <div class="header-actions">
            @if($sesiQrAktif->count() > 0)
                <span class="live-badge">
                    <span class="live-dot"></span>
                    {{ $sesiQrAktif->count() }} Mapel Aktif
                </span>
            @endif
        </div>
    </div>

    {{-- Flash messages --}}
    @foreach(['warning' => 'alert-warning', 'success' => 'alert-success', 'info' => 'alert-info', 'error' => 'alert-warning'] as $key => $cls)
        @if(session($key))
            <div class="alert {{ $cls }}">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session($key) }}
            </div>
        @endif
    @endforeach

    <div class="main-grid">

        {{-- ══ BARCODE GERBANG ══ --}}
        <div>
            <p class="section-label">Barcode Gerbang</p>
            <div class="card barcode-card">
                <div class="barcode-card-header">
                    <span class="barcode-card-title">
                        <svg width="14" height="14" fill="none" stroke="rgba(255,255,255,.7)" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9V5a2 2 0 0 1 2-2h4M3 15v4a2 2 0 0 0 2 2h4M21 9V5a2 2 0 0 0-2-2h-4M21 15v4a2 2 0 0 1-2 2h-4"/></svg>
                        Scan Masuk &amp; Pulang
                    </span>
                    @if($barcodeGerbang)
                        <span class="barcode-status aktif">
                            <span class="barcode-status-dot"></span>
                            Aktif
                        </span>
                    @else
                        <span class="barcode-status kosong">
                            <span class="barcode-status-dot"></span>
                            Belum Ada
                        </span>
                    @endif
                </div>

                @if($barcodeGerbang)
                    <div class="barcode-display">
                        <div class="barcode-wrap">
                            <svg id="barcode-gerbang-svg"></svg>
                            <p class="barcode-kode">{{ $barcodeGerbang->kode }}</p>
                        </div>

                        <div class="barcode-siswa">
                            <p class="barcode-nama">{{ $siswa->nama_lengkap }}</p>
                            <div class="barcode-info">
                                <span>
                                    <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    {{ $siswa->nisn ?? 'NISN —' }}
                                </span>
                                <span class="barcode-dot-sep"></span>
                                <span>{{ $siswa->kelas->nama_kelas ?? '—' }}</span>
                                @if($barcodeGerbang->berlaku_sampai)
                                    <span class="barcode-dot-sep"></span>
                                    <span>s/d {{ $barcodeGerbang->berlaku_sampai->format('d M Y') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="barcode-actions">
                            <a href="{{ route('siswa.barcode.gerbang') }}" class="btn-barcode btn-barcode-primary">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/></svg>
                                Tampilkan Besar
                            </a>
                            <a href="{{ route('siswa.barcode.downloadGerbang') }}" class="btn-barcode btn-barcode-secondary">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                Unduh Kode
                            </a>
                        </div>
                    </div>

                    {{-- Info sesi gerbang aktif --}}
                    @if($sesiGerbangAktif)
                        <div class="gerbang-banner">
                            <div class="gerbang-banner-icon {{ $sesiGerbangAktif->tipe }}">
                                @if($sesiGerbangAktif->tipe === 'masuk')
                                    <svg width="18" height="18" fill="none" stroke="#6ee7b7" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                                @else
                                    <svg width="18" height="18" fill="none" stroke="#fcd34d" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                @endif
                            </div>
                            <div class="gerbang-banner-text">
                                <p class="gerbang-banner-title {{ $sesiGerbangAktif->tipe }}">
                                    Sesi {{ $sesiGerbangAktif->tipe === 'masuk' ? 'Masuk' : 'Pulang' }} Sedang Aktif
                                </p>
                                <p class="gerbang-banner-sub">Scan barcode ini di gerbang sekarang</p>
                            </div>
                        </div>
                    @endif

                @else
                    <div class="barcode-empty">
                        <div class="barcode-empty-icon">
                            <svg width="28" height="28" fill="none" stroke="rgba(255,255,255,.5)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 9V5a2 2 0 0 1 2-2h4M3 15v4a2 2 0 0 0 2 2h4M21 9V5a2 2 0 0 0-2-2h-4M21 15v4a2 2 0 0 1-2 2h-4"/></svg>
                        </div>
                        <p class="barcode-empty-title">Barcode Belum Tersedia</p>
                        <p class="barcode-empty-sub">Barcode gerbang Anda belum diterbitkan.<br>Hubungi admin atau TU sekolah.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ══ BARCODE MAPEL ══ --}}
        <div>
            <p class="section-label">Barcode Mapel</p>
            <div class="card barcode-card">
                <div class="barcode-card-header">
                    <span class="barcode-card-title">
                        <svg width="14" height="14" fill="none" stroke="rgba(255,255,255,.7)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 14h.01M14 17h3M17 14v3M20 14h.01M20 17h.01"/></svg>
                        Absensi Per Pelajaran
                    </span>
                    {{-- Badge status: aktif hanya jika ada sesi, menunggu jika ada barcode tapi tidak ada sesi, kosong jika tidak ada barcode --}}
                    @if($kodeBarcodeMapel && $sesiQrAktif->count() > 0)
                        <span class="barcode-status aktif">
                            <span class="barcode-status-dot"></span>
                            Aktif
                        </span>
                    @elseif($kodeBarcodeMapel && $sesiQrAktif->count() === 0)
                        <span class="barcode-status menunggu">
                            <span class="barcode-status-dot"></span>
                            Menunggu Sesi
                        </span>
                    @else
                        <span class="barcode-status kosong">
                            <span class="barcode-status-dot"></span>
                            Belum Ada
                        </span>
                    @endif
                </div>

                {{-- KONDISI 1: Ada barcode DAN ada sesi aktif → tampilkan barcode --}}
                @if($kodeBarcodeMapel && $sesiQrAktif->count() > 0)
                    <div class="barcode-display">
                        <div class="barcode-wrap">
                            <svg id="barcode-mapel-svg"></svg>
                            <p class="barcode-kode">{{ $kodeBarcodeMapel }}</p>
                        </div>

                        <div class="barcode-siswa">
                            <p class="barcode-nama">{{ $siswa->nama_lengkap }}</p>
                            <div class="barcode-info">
                                <span>{{ $siswa->kelas->nama_kelas ?? '—' }}</span>
                                <span class="barcode-dot-sep"></span>
                                <span>{{ $sesiQrAktif->count() }} mapel aktif</span>
                            </div>
                        </div>

                        <div class="barcode-actions">
                            <a href="{{ route('siswa.barcode.mapel') }}" class="btn-barcode btn-barcode-primary">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/></svg>
                                Tampilkan Besar
                            </a>
                            <a href="{{ route('siswa.barcode.downloadMapel') }}" class="btn-barcode btn-barcode-secondary">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                Unduh Kode
                            </a>
                        </div>
                    </div>

                    {{-- Daftar sesi mapel aktif --}}
                    <div class="sesi-list">
                        @foreach($sesiQrAktif as $sesi)
                            <div class="sesi-item">
                                <div class="sesi-icon">
                                    <svg width="20" height="20" fill="none" stroke="rgba(255,255,255,.7)" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                </div>
                                <div class="sesi-body">
                                    <p class="sesi-mapel">{{ $sesi->mataPelajaran->nama_mapel ?? '—' }}</p>
                                    <div class="sesi-meta">
                                        <span>{{ \Carbon\Carbon::parse($sesi->berlaku_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($sesi->kadaluarsa_pada)->format('H:i') }}</span>
                                    </div>
                                </div>
                                <div class="sesi-right">
                                    <div class="sesi-countdown" data-expires="{{ \Carbon\Carbon::parse($sesi->kadaluarsa_pada)->timestamp }}">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span class="countdown-text">—</span>
                                    </div>
                                    <span class="sesi-badge aktif">Scan Sekarang</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                {{-- KONDISI 2: Ada barcode TAPI tidak ada sesi aktif → tampilkan pesan tunggu --}}
                @elseif($kodeBarcodeMapel && $sesiQrAktif->count() === 0)
                    <div class="barcode-empty">
                        <div class="barcode-empty-icon">
                            <svg width="28" height="28" fill="none" stroke="rgba(255,255,255,.5)" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <p class="barcode-empty-title">Tidak Ada Sesi Aktif</p>
                        <p class="barcode-empty-sub">Barcode mapel Anda siap digunakan.<br>Tunggu guru membuka sesi absensi pelajaran.</p>
                    </div>

                {{-- KONDISI 3: Tidak ada barcode sama sekali --}}
                @else
                    <div class="barcode-empty">
                        <div class="barcode-empty-icon">
                            <svg width="28" height="28" fill="none" stroke="rgba(255,255,255,.5)" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                        </div>
                        <p class="barcode-empty-title">Barcode Mapel Belum Tersedia</p>
                        <p class="barcode-empty-sub">Barcode mapel Anda belum diterbitkan.<br>Hubungi admin sekolah.</p>
                    </div>
                @endif

            </div>
        </div>

        {{-- ══ JADWAL HARI INI ══ --}}
        <div class="col-full">
            @php
                $jamSekarang = now()->format('H:i');
                $mapelColors = [];
                $ci = 0;
                foreach($jadwalHariIni->pluck('mata_pelajaran_id')->unique() as $mpId) {
                    $mapelColors[$mpId] = $ci++ % 8;
                }
            @endphp
            <p class="section-label">Jadwal Hari Ini &nbsp;·&nbsp; {{ ucfirst(\Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y')) }}</p>
            <div class="card">
                <div class="card-header">
                    <span class="card-header-title">
                        <svg width="14" height="14" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/></svg>
                        Pelajaran Hari Ini
                    </span>
                    <a href="{{ route('siswa.jadwal.index') }}" style="font-family:'Outfit',sans-serif;font-size:12px;font-weight:700;color:var(--s-500);text-decoration:none;">
                        Jadwal Lengkap →
                    </a>
                </div>

                <div class="jadwal-list">
                    @forelse($jadwalHariIni as $j)
                        @php
                            $mulai   = \Carbon\Carbon::parse($j->jam_mulai);
                            $selesai = \Carbon\Carbon::parse($j->jam_selesai);
                            $durasi  = $mulai->diffInMinutes($selesai);
                            $isNow   = $jamSekarang >= $j->jam_mulai && $jamSekarang <= $j->jam_selesai;
                            $cIdx    = $mapelColors[$j->mata_pelajaran_id] ?? 0;
                        @endphp
                        <div class="jadwal-row {{ $isNow ? 'now' : '' }}">
                            <div class="jadwal-time">
                                <span class="jam">{{ $mulai->format('H:i') }}</span>
                                <span class="durasi">{{ $durasi }}m</span>
                            </div>
                            <div class="jadwal-stripe stripe-{{ $cIdx }}"></div>
                            <div class="jadwal-body">
                                <p class="jadwal-mapel">{{ $j->mataPelajaran->nama_mapel ?? '—' }}</p>
                                <p class="jadwal-guru">{{ $j->guru->nama_lengkap ?? '—' }}
                                    @if($j->ruang) &nbsp;·&nbsp; {{ $j->ruang->nama_ruang ?? '' }} @endif
                                </p>
                            </div>
                            <div class="jadwal-right">
                                @if($isNow)
                                    <span class="now-pill">
                                        <span class="now-dot-sm"></span>
                                        Berlangsung
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div style="padding:40px 20px;text-align:center">
                            <svg width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 10px;display:block"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <p style="font-family:'Outfit',sans-serif;font-weight:700;font-size:13.5px;color:var(--text2);margin-bottom:4px">Tidak ada pelajaran hari ini</p>
                            <p style="font-size:12.5px;color:var(--text4)">Selamat beristirahat!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>{{-- /main-grid --}}
</div>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script>
// ── Render barcode gerbang ────────────────────────────────────────────────
@if($barcodeGerbang)
try {
    JsBarcode('#barcode-gerbang-svg', '{{ $barcodeGerbang->kode }}', {
        format: 'CODE128', width: 1.8, height: 60, displayValue: false, margin: 0,
    });
} catch(e) { console.warn('JsBarcode gerbang error:', e); }
@endif

// ── Render barcode mapel (hanya jika ada sesi aktif, elemen SVG ada di DOM) ──
@if($kodeBarcodeMapel && $sesiQrAktif->count() > 0)
try {
    const elMapel = document.getElementById('barcode-mapel-svg');
    if (elMapel) {
        JsBarcode('#barcode-mapel-svg', '{{ $kodeBarcodeMapel }}', {
            format: 'CODE128', width: 1.8, height: 60, displayValue: false, margin: 0,
        });
    }
} catch(e) { console.warn('JsBarcode mapel error:', e); }
@endif

// ── Countdown sesi mapel ──────────────────────────────────────────────────
function updateCountdowns() {
    document.querySelectorAll('.sesi-countdown[data-expires]').forEach(el => {
        const expires = parseInt(el.dataset.expires, 10) * 1000;
        const diff    = expires - Date.now();
        const span    = el.querySelector('.countdown-text');
        if (diff <= 0) {
            span.textContent = 'Habis';
            el.style.color   = 'var(--r-500)';
            return;
        }
        const mnt = Math.floor(diff / 60000);
        const sec = Math.floor((diff % 60000) / 1000);
        span.textContent = `${mnt}:${String(sec).padStart(2,'0')}`;
        el.classList.toggle('expiring', mnt < 5);
    });
}
updateCountdowns();
setInterval(updateCountdowns, 1000);

// ── Auto-refresh tiap 30 detik ────────────────────────────────────────────
let refreshTimer = setInterval(() => window.location.reload(), 30000);

document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        clearInterval(refreshTimer);
    } else {
        window.location.reload();
    }
});
</script>
</x-app-layout>