<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Instrument+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');

    :root {
        --s-800:#0f2044;--s-700:#1a3a6b;--s-600:#1d4ed8;--s-500:#2563eb;
        --s-400:#3b82f6;--s-300:#93c5fd;--s-100:#dbeafe;--s-50:#eff6ff;
        --g-500:#10b981;--g-400:#34d399;--g-100:#d1fae5;--g-50:#ecfdf5;
        --a-500:#f59e0b;--a-100:#fef3c7;--a-50:#fffbeb;
        --r-500:#ef4444;--r-400:#f87171;--r-100:#fee2e2;--r-50:#fff5f5;
        --v-500:#8b5cf6;--v-100:#ede9fe;--v-50:#f5f3ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#334155;--text3:#64748b;--text4:#94a3b8;
        --radius:12px;--radius-sm:8px;--radius-xs:6px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.07);
        --shadow-md:0 4px 16px rgba(0,0,0,.08);
    }

    * { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Instrument Sans', sans-serif; }

    .page { padding:24px 28px 64px; max-width:2000px; }

    /* ── Header ── */
    .page-header {
        display:flex; align-items:flex-start; justify-content:space-between;
        gap:16px; margin-bottom:24px; flex-wrap:wrap;
    }
    .page-title {
        font-family:'Outfit',sans-serif; font-size:21px; font-weight:800;
        color:var(--text); letter-spacing:-.01em;
    }
    .page-sub { font-size:12.5px; color:var(--text4); margin-top:3px; }
    .header-actions { display:flex; gap:8px; align-items:center; flex-shrink:0; }

    /* ── Breadcrumb ── */
    .breadcrumb {
        display:flex; align-items:center; gap:6px; margin-bottom:20px; flex-wrap:wrap;
    }
    .breadcrumb a {
        font-size:12.5px; color:var(--s-500); text-decoration:none;
        font-family:'Outfit',sans-serif; font-weight:600; transition:color .15s;
    }
    .breadcrumb a:hover { color:var(--s-700); }
    .breadcrumb-sep     { font-size:12px; color:var(--text4); }
    .breadcrumb-current { font-size:12.5px; color:var(--text4); font-family:'Outfit',sans-serif; }

    /* ── Date badge ── */
    .date-badge {
        display:inline-flex; align-items:center; gap:6px;
        background:var(--s-50); border:1px solid var(--s-100); color:var(--s-600);
        font-family:'Outfit',sans-serif; font-size:12px; font-weight:700;
        padding:5px 12px; border-radius:99px;
    }

    /* ── Section label ── */
    .section-label {
        font-family:'Outfit',sans-serif; font-size:11px; font-weight:800;
        letter-spacing:.08em; text-transform:uppercase; color:var(--text4); margin-bottom:10px;
    }

    /* ── Card base ── */
    .card {
        background:var(--surface); border:1px solid var(--border);
        border-radius:var(--radius); box-shadow:var(--shadow-sm); overflow:hidden;
    }
    .card-header {
        display:flex; align-items:center; justify-content:space-between;
        padding:14px 20px; border-bottom:1px solid var(--border); background:var(--surface2);
    }
    .card-header-title {
        font-family:'Outfit',sans-serif; font-size:14px; font-weight:700; color:var(--text);
        display:flex; align-items:center; gap:8px;
    }

    /* ── Summary bar ── */
    .summary-bar {
        display:grid; grid-template-columns:repeat(3,1fr); gap:0;
        border:1px solid var(--border); border-radius:var(--radius);
        overflow:hidden; background:var(--surface); box-shadow:var(--shadow-sm);
        margin-bottom:20px;
    }
    .summary-item {
        padding:16px 18px; text-align:center; border-right:1px solid var(--border);
    }
    .summary-item:last-child { border-right:none; }
    .summary-val {
        font-family:'Outfit',sans-serif; font-size:22px; font-weight:900;
        color:var(--text); display:block; line-height:1.1;
    }
    .summary-val.green   { color:var(--g-500); }
    .summary-val.blue    { color:var(--s-500); }
    .summary-val.neutral { color:var(--text4); }
    .summary-lbl {
        font-size:11px; color:var(--text4); font-family:'Outfit',sans-serif;
        font-weight:600; margin-top:4px; display:block;
    }
    .summary-icon { display:flex; align-items:center; justify-content:center; margin:0 auto 2px; }

    /* ── Status cards ── */
    .status-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px; }
    .status-card {
        border-radius:var(--radius); padding:22px 20px;
        position:relative; overflow:hidden; border:1px solid var(--border);
    }
    .status-card.masuk  {
        background:linear-gradient(135deg, var(--g-50) 0%, #f0fdf4 100%);
        border-color:var(--g-100);
    }
    .status-card.pulang {
        background:linear-gradient(135deg, var(--s-50) 0%, #f0f7ff 100%);
        border-color:var(--s-100);
    }
    .status-card.empty  { background:var(--surface2); border-color:var(--border); border-style:dashed; }
    .status-card-icon {
        width:44px; height:44px; border-radius:12px;
        display:flex; align-items:center; justify-content:center; margin-bottom:14px;
    }
    .status-card.masuk  .status-card-icon { background:rgba(16,185,129,.15); }
    .status-card.pulang .status-card-icon { background:rgba(37,99,235,.12); }
    .status-card.empty  .status-card-icon { background:var(--surface3); }
    .status-card-label {
        font-family:'Outfit',sans-serif; font-size:11px; font-weight:800;
        letter-spacing:.08em; text-transform:uppercase; margin-bottom:6px;
    }
    .status-card.masuk  .status-card-label { color:var(--g-500); }
    .status-card.pulang .status-card-label { color:var(--s-500); }
    .status-card.empty  .status-card-label { color:var(--text4); }
    .status-card-time {
        font-family:'Outfit',sans-serif; font-size:28px; font-weight:900; line-height:1; margin-bottom:6px;
    }
    .status-card.masuk  .status-card-time { color:var(--g-500); }
    .status-card.pulang .status-card-time { color:var(--s-600); }
    .status-card.empty  .status-card-time { color:var(--text4); font-size:20px; font-weight:700; }
    .status-card-meta {
        font-size:12px; color:var(--text3);
        display:flex; align-items:center; gap:6px; flex-wrap:wrap; margin-top:4px;
    }

    /* ── Status pill ── */
    .status-pill {
        display:inline-flex; align-items:center; gap:4px;
        font-family:'Outfit',sans-serif; font-size:10.5px; font-weight:700;
        padding:3px 9px; border-radius:99px; margin-top:10px;
    }
    .pill-hadir  { background:var(--g-50);     color:var(--g-500); border:1px solid var(--g-100); }
    .pill-manual { background:var(--a-50);     color:#92400e;      border:1px solid var(--a-100); }
    .pill-koreksi { background:var(--v-50);    color:var(--v-500); border:1px solid var(--v-100); }
    .pill-belum  { background:var(--surface3); color:var(--text4); border:1px solid var(--border); }

    /* ── Scan log ── */
    .scan-log { display:flex; flex-direction:column; }
    .scan-row {
        display:flex; align-items:center; gap:14px;
        padding:14px 20px; border-bottom:1px solid var(--border);
    }
    .scan-row:last-child { border-bottom:none; }
    .scan-dot { width:10px; height:10px; border-radius:50%; flex-shrink:0; }
    .scan-dot.masuk  { background:var(--g-500); }
    .scan-dot.pulang { background:var(--s-500); }
    .scan-body { flex:1; min-width:0; }
    .scan-title {
        font-family:'Outfit',sans-serif; font-size:13.5px; font-weight:700; color:var(--text);
    }
    .scan-meta {
        font-size:11.5px; color:var(--text4); margin-top:2px;
        display:flex; align-items:center; gap:8px; flex-wrap:wrap;
    }

    /* ── Status badge ── */
    .status-badge {
        display:inline-flex; align-items:center; gap:4px;
        font-family:'Outfit',sans-serif; font-size:10.5px; font-weight:700;
        padding:3px 9px; border-radius:99px; flex-shrink:0;
    }
    .badge-normal   { background:var(--g-50);  color:var(--g-500);  border:1px solid var(--g-100); }
    .badge-manual   { background:var(--v-50);  color:var(--v-500);  border:1px solid var(--v-100); }
    .badge-koreksi  { background:var(--a-50);  color:var(--a-500);  border:1px solid var(--a-100); }
    .badge-duplikat { background:var(--r-50);  color:var(--r-500);  border:1px solid var(--r-100); }

    .scan-time {
        font-family:'Outfit',sans-serif; font-size:15px; font-weight:800;
        color:var(--text2); flex-shrink:0;
    }
    .scan-time a {
        color:inherit; text-decoration:none;
        display:inline-flex; align-items:center; gap:3px; transition:color .15s;
    }
    .scan-time a:hover { color:var(--s-500); }

    /* ── Empty state ── */
    .empty-state { padding:48px 20px; text-align:center; }
    .empty-icon {
        width:64px; height:64px; background:var(--surface3); border-radius:16px;
        display:flex; align-items:center; justify-content:center; margin:0 auto 14px;
    }
    .empty-title {
        font-family:'Outfit',sans-serif; font-size:15px; font-weight:700;
        color:var(--text2); margin-bottom:5px;
    }
    .empty-sub { font-size:12.5px; color:var(--text4); line-height:1.6; }

    /* ── Alert ── */
    .alert {
        display:flex; align-items:flex-start; gap:10px;
        padding:12px 16px; border-radius:var(--radius-sm);
        font-size:12.5px; line-height:1.6;
    }
    .alert svg { flex-shrink:0; margin-top:1px; }
    .alert-info { background:var(--s-50); border:1px solid var(--s-100); color:var(--s-700); }

    /* ── Btn ── */
    .btn {
        display:inline-flex; align-items:center; gap:6px;
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:700;
        padding:9px 16px; border-radius:var(--radius-xs);
        text-decoration:none; transition:all .15s; cursor:pointer; border:none;
    }
    .btn-outline { background:transparent; border:1px solid var(--border); color:var(--text2); }
    .btn-outline:hover { border-color:var(--s-300); color:var(--s-600); background:var(--s-50); }
    .btn-primary { background:var(--s-500); color:#fff; border:1px solid var(--s-500); }
    .btn-primary:hover { background:var(--s-600); }

    @media(max-width:640px) {
        .page { padding:14px 14px 56px; }
        .status-grid { grid-template-columns:1fr; }
        .summary-bar { grid-template-columns:1fr; }
        .summary-item { border-right:none; border-bottom:1px solid var(--border); }
        .summary-item:last-child { border-bottom:none; }
        .page-header { flex-direction:column; gap:10px; }
    }
</style>

<div class="page">

    {{-- ── BREADCRUMB ── --}}
    {{--
        FIX: Route::has() digunakan sebelum memanggil route() agar tidak error
        jika nama route dashboard tidak terdaftar di aplikasi.
    --}}
    <nav class="breadcrumb">
        @if(\Illuminate\Support\Facades\Route::has('siswa.dashboard'))
            <a href="{{ route('siswa.dashboard') }}">Dashboard</a>
        @else
            <a href="{{ url('/') }}">Beranda</a>
        @endif
        <span class="breadcrumb-sep">/</span>
        <span class="breadcrumb-current">Status Absensi Hari Ini</span>
    </nav>

    {{-- ── HEADER ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Status Absensi Gerbang</h1>
            <p class="page-sub">
                {{ $siswa->nama_lengkap }}
                &nbsp;&middot;&nbsp;
                {{ $siswa->kelas->nama_kelas ?? '—' }}
            </p>
        </div>
        <div class="header-actions">
            <span class="date-badge">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                </svg>
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </span>
            <a href="{{ route('siswa.absensi-gerbang.riwayat') }}" class="btn btn-outline">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
                Riwayat
            </a>
        </div>
    </div>

    {{-- ── SUMMARY BAR ── --}}
    {{--
        FIX: $scanHariIni, $scanMasuk, $scanPulang dijamin dikirim controller.
        FIX: Gunakan SVG icon — tidak pakai unicode karakter (✓ / —) yang bisa
             rendering berbeda tergantung font.
    --}}
    @php
        $jumlahScanHariIni = $scanHariIni->count();
        $sudahMasuk        = $scanMasuk  !== null;
        $sudahPulang       = $scanPulang !== null;
    @endphp

    <div class="summary-bar">
        <div class="summary-item">
            <span class="summary-val {{ $jumlahScanHariIni > 0 ? 'green' : 'neutral' }}">
                {{ $jumlahScanHariIni }}
            </span>
            <span class="summary-lbl">Scan Hari Ini</span>
        </div>
        <div class="summary-item">
            <div class="summary-icon">
                @if($sudahMasuk)
                    <svg width="28" height="28" fill="none" stroke="var(--g-500)" stroke-width="2.5" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="8 12 11 15 16 9"/>
                    </svg>
                @else
                    <svg width="28" height="28" fill="none" stroke="var(--text4)" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-dasharray="3 3"/>
                    </svg>
                @endif
            </div>
            <span class="summary-lbl">Scan Masuk</span>
        </div>
        <div class="summary-item">
            <div class="summary-icon">
                @if($sudahPulang)
                    <svg width="28" height="28" fill="none" stroke="var(--s-500)" stroke-width="2.5" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="8 12 11 15 16 9"/>
                    </svg>
                @else
                    <svg width="28" height="28" fill="none" stroke="var(--text4)" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-dasharray="3 3"/>
                    </svg>
                @endif
            </div>
            <span class="summary-lbl">Scan Pulang</span>
        </div>
    </div>

    {{-- ── STATUS CARDS ── --}}
    <p class="section-label">Status Scan</p>
    <div class="status-grid">

        {{-- MASUK --}}
        @if($scanMasuk)
            @php
                $statusMasuk = $scanMasuk->status ?? 'normal';
                // waktu_scan di-cast datetime — pastikan Carbon
                $waktuMasuk = $scanMasuk->waktu_scan instanceof \Carbon\Carbon
                    ? $scanMasuk->waktu_scan
                    : \Carbon\Carbon::parse($scanMasuk->waktu_scan);
            @endphp
            <div class="status-card masuk">
                <div class="status-card-icon">
                    <svg width="22" height="22" fill="none" stroke="var(--g-500)" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                </div>
                <p class="status-card-label">Masuk</p>
                <p class="status-card-time">{{ $waktuMasuk->format('H:i') }}</p>
                <div class="status-card-meta">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    {{ $waktuMasuk->format('d M Y') }}
                    @if($scanMasuk->sesiGerbang)
                        &nbsp;&middot;&nbsp; {{ $scanMasuk->sesiGerbang->nama ?? '' }}
                    @endif
                </div>
                {{--
                    FIX: Label status mencerminkan nilai kolom status secara akurat.
                    Tidak ada asumsi "Tepat Waktu vs Terlambat" karena info itu
                    tidak ada di model — harus ditambah field terpisah di controller.
                --}}
                @if($statusMasuk === 'manual')
                    <span class="status-pill pill-manual">Input Manual</span>
                @elseif($statusMasuk === 'koreksi')
                    <span class="status-pill pill-koreksi">Koreksi Admin</span>
                @else
                    <span class="status-pill pill-hadir">Hadir</span>
                @endif
            </div>
        @else
            <div class="status-card empty">
                <div class="status-card-icon">
                    <svg width="22" height="22" fill="none" stroke="var(--text4)" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                </div>
                <p class="status-card-label">Masuk</p>
                <p class="status-card-time">Belum Scan</p>
                <div class="status-card-meta">Belum ada rekaman masuk hari ini</div>
                <span class="status-pill pill-belum">Belum Tercatat</span>
            </div>
        @endif

        {{-- PULANG --}}
        @if($scanPulang)
            @php
                $statusPulang = $scanPulang->status ?? 'normal';
                $waktuPulang  = $scanPulang->waktu_scan instanceof \Carbon\Carbon
                    ? $scanPulang->waktu_scan
                    : \Carbon\Carbon::parse($scanPulang->waktu_scan);
            @endphp
            <div class="status-card pulang">
                <div class="status-card-icon">
                    <svg width="22" height="22" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </div>
                <p class="status-card-label">Pulang</p>
                <p class="status-card-time">{{ $waktuPulang->format('H:i') }}</p>
                <div class="status-card-meta">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    {{ $waktuPulang->format('d M Y') }}
                    @if($scanPulang->sesiGerbang)
                        &nbsp;&middot;&nbsp; {{ $scanPulang->sesiGerbang->nama ?? '' }}
                    @endif
                </div>
                @if($statusPulang === 'manual')
                    <span class="status-pill pill-manual">Input Manual</span>
                @elseif($statusPulang === 'koreksi')
                    <span class="status-pill pill-koreksi">Koreksi Admin</span>
                @else
                    <span class="status-pill pill-hadir">Sudah Pulang</span>
                @endif
            </div>
        @else
            <div class="status-card empty">
                <div class="status-card-icon">
                    <svg width="22" height="22" fill="none" stroke="var(--text4)" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </div>
                <p class="status-card-label">Pulang</p>
                <p class="status-card-time">Belum Scan</p>
                <div class="status-card-meta">Belum ada rekaman pulang hari ini</div>
                <span class="status-pill pill-belum">Belum Tercatat</span>
            </div>
        @endif

    </div>

    {{-- ── LOG SCAN HARI INI ── --}}
    <p class="section-label">Log Scan Hari Ini</p>

    @if($scanHariIni->isNotEmpty())
        <div class="card" style="margin-bottom:16px">
            <div class="card-header">
                <span class="card-header-title">
                    <svg width="14" height="14" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 9V5a2 2 0 0 1 2-2h4M3 15v4a2 2 0 0 0 2 2h4M21 9V5a2 2 0 0 0-2-2h-4M21 15v4a2 2 0 0 1-2 2h-4"/>
                    </svg>
                    Semua Scan Valid Hari Ini
                </span>
                <span style="font-family:'Outfit',sans-serif;font-size:12px;font-weight:700;color:var(--text4)">
                    {{ $scanHariIni->count() }} entri
                </span>
            </div>
            <div class="scan-log">
                @foreach($scanHariIni as $scan)
                    @php
                        $statusStr = $scan->status ?? 'normal';
                        // FIX: defensive cast — waktu_scan sudah di-cast di model, tapi
                        // tetap aman jika entah bagaimana nilai masih string
                        $waktuScan = $scan->waktu_scan instanceof \Carbon\Carbon
                            ? $scan->waktu_scan
                            : \Carbon\Carbon::parse($scan->waktu_scan);
                    @endphp
                    <div class="scan-row">
                        <span class="scan-dot {{ $scan->tipe ?? 'masuk' }}"></span>
                        <div class="scan-body">
                            <p class="scan-title">
                                {{ ($scan->tipe ?? 'masuk') === 'masuk' ? 'Scan Masuk' : 'Scan Pulang' }}
                            </p>
                            <div class="scan-meta">
                                @if($scan->sesiGerbang)
                                    <span>Sesi: {{ $scan->sesiGerbang->nama ?? '—' }}</span>
                                    <span>&middot;</span>
                                @endif
                                <span>{{ $waktuScan->format('H:i:s') }} WIB</span>
                                @if(filled($scan->catatan ?? null))
                                    <span>&middot;</span>
                                    <span>{{ $scan->catatan }}</span>
                                @endif
                            </div>
                        </div>

                        <span class="status-badge badge-{{ $statusStr }}">
                            {{ match($statusStr) {
                                'manual'   => 'Manual',
                                'koreksi'  => 'Koreksi',
                                'duplikat' => 'Duplikat',
                                default    => 'Normal',
                            } }}
                        </span>

                        {{--
                            FIX: ?from= harus di-append sebelum fragment/anchor —
                            gunakan http_build_query atau route() + querystring manual.
                            Cara paling aman: append ke URL via route() lalu tambah param.
                        --}}
                        <span class="scan-time">
                            <a href="{{ route('siswa.absensi-gerbang.show', $scan->id) . '?from=status-hari-ini' }}">
                                {{ $waktuScan->format('H:i') }}
                                <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <polyline points="9 18 15 12 9 6"/>
                                </svg>
                            </a>
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="card" style="margin-bottom:16px">
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="28" height="28" fill="none" stroke="var(--text4)" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M3 9V5a2 2 0 0 1 2-2h4M3 15v4a2 2 0 0 0 2 2h4M21 9V5a2 2 0 0 0-2-2h-4M21 15v4a2 2 0 0 1-2 2h-4"/>
                    </svg>
                </div>
                <p class="empty-title">Belum ada scan hari ini</p>
                <p class="empty-sub">
                    Scan barcode Anda di gerbang sekolah<br>
                    untuk mencatatkan kehadiran.
                </p>
            </div>
        </div>
    @endif

    {{-- ── INFO NOTE ── --}}
    <div class="alert alert-info">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <span>
            Hanya scan dengan status <strong>normal, manual,</strong> dan <strong>koreksi</strong>
            yang ditampilkan di halaman ini. Scan duplikat disembunyikan dari tampilan siswa.
        </span>
    </div>

</div>
</x-app-layout>