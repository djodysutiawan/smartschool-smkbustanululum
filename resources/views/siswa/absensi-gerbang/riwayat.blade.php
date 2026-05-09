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
    }

    * { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Instrument Sans', sans-serif; }

    .page { padding:24px 28px 64px; max-width:2000px; }

    /* ── Page header ── */
    .page-header { margin-bottom:24px; }
    .page-title {
        font-family:'Outfit',sans-serif; font-size:22px; font-weight:800;
        color:var(--text); letter-spacing:-.02em; line-height:1.2;
    }
    .page-subtitle { font-size:13px; color:var(--text3); margin-top:4px; }

    /* ── Rekap strip ── */
    .rekap-strip { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:20px; }
    .rekap-card {
        border-radius:var(--radius); padding:16px 20px;
        display:flex; align-items:center; gap:14px;
        border:1px solid var(--border); background:var(--surface); box-shadow:var(--shadow-sm);
    }
    .rekap-icon {
        width:40px; height:40px; border-radius:10px;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .rekap-icon-masuk  { background:var(--s-50); }
    .rekap-icon-pulang { background:var(--g-50); }
    .rekap-label {
        font-size:11px; font-weight:700; color:var(--text4);
        text-transform:uppercase; letter-spacing:.06em; margin-bottom:3px;
    }
    .rekap-val {
        font-family:'Outfit',sans-serif; font-size:22px; font-weight:900;
        color:var(--text); line-height:1;
    }
    .rekap-unit { font-size:12px; color:var(--text4); margin-top:2px; }

    /* ── Filter card ── */
    .filter-card {
        background:var(--surface); border:1px solid var(--border);
        border-radius:var(--radius); box-shadow:var(--shadow-sm);
        margin-bottom:16px; overflow:hidden;
    }
    .filter-header {
        display:flex; align-items:center; justify-content:space-between;
        padding:13px 18px; border-bottom:1px solid var(--border);
        background:var(--surface2); cursor:pointer; user-select:none;
    }
    .filter-header-left { display:flex; align-items:center; gap:8px; }
    .filter-title {
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:700; color:var(--text2);
    }
    .filter-active-badge {
        font-family:'Outfit',sans-serif; font-size:11px; font-weight:700;
        background:var(--s-600); color:#fff; padding:2px 8px; border-radius:99px;
    }
    .filter-chevron { transition:transform .2s; color:var(--text4); }
    .filter-chevron.open { transform:rotate(180deg); }
    .filter-body { padding:16px 18px; }
    .filter-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px; }
    .filter-group { display:flex; flex-direction:column; gap:5px; }
    .filter-label {
        font-size:11.5px; font-weight:700; color:var(--text3);
        text-transform:uppercase; letter-spacing:.05em;
    }
    .filter-input, .filter-select {
        font-family:'Instrument Sans',sans-serif; font-size:13px;
        padding:8px 12px; border:1px solid var(--border); border-radius:var(--radius-xs);
        background:var(--surface); color:var(--text); outline:none; transition:border-color .15s;
        -webkit-appearance:none; appearance:none;
    }
    .filter-input:focus, .filter-select:focus { border-color:var(--s-400); }
    .filter-actions { display:flex; gap:8px; justify-content:flex-end; }

    /* ── Tipe tab ── */
    .tipe-tabs { display:flex; gap:6px; margin-bottom:16px; flex-wrap:wrap; }
    .tipe-tab {
        display:inline-flex; align-items:center; gap:6px;
        font-family:'Outfit',sans-serif; font-size:12px; font-weight:700;
        padding:6px 14px; border-radius:99px; border:1px solid var(--border);
        background:var(--surface); color:var(--text3); text-decoration:none;
        cursor:pointer; transition:all .15s;
    }
    .tipe-tab:hover { border-color:var(--s-300); color:var(--s-600); }
    .tipe-tab.active-all    { background:var(--text); color:#fff; border-color:var(--text); }
    .tipe-tab.active-masuk  { background:var(--s-600); color:#fff; border-color:var(--s-600); }
    .tipe-tab.active-pulang { background:var(--g-500); color:#fff; border-color:var(--g-500); }

    /* ── Entry list ── */
    .entry-group { margin-bottom:8px; }
    .entry-date-label {
        font-family:'Outfit',sans-serif; font-size:11.5px; font-weight:700;
        color:var(--text4); text-transform:uppercase; letter-spacing:.08em;
        padding:0 4px 8px;
    }
    .entry-card {
        background:var(--surface); border:1px solid var(--border);
        border-radius:var(--radius); box-shadow:var(--shadow-sm);
        display:flex; align-items:center; gap:0;
        text-decoration:none; color:inherit;
        transition:box-shadow .15s, border-color .15s;
        overflow:hidden; margin-bottom:8px;
    }
    .entry-card:hover { box-shadow:var(--shadow-md); border-color:var(--s-300); }
    .entry-strip { width:4px; align-self:stretch; flex-shrink:0; }
    .entry-strip-masuk  { background:var(--s-500); }
    .entry-strip-pulang { background:var(--g-500); }
    .entry-body { flex:1; display:flex; align-items:center; gap:14px; padding:14px 16px; }
    .entry-icon {
        width:38px; height:38px; border-radius:10px; flex-shrink:0;
        display:flex; align-items:center; justify-content:center;
    }
    .entry-icon-masuk  { background:var(--s-50); }
    .entry-icon-pulang { background:var(--g-50); }
    .entry-info { flex:1; min-width:0; }
    .entry-tipe {
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:700; color:var(--text);
    }
    .entry-meta {
        font-size:12px; color:var(--text3); margin-top:2px;
        white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
    }
    .entry-right { display:flex; flex-direction:column; align-items:flex-end; gap:4px; flex-shrink:0; }
    .entry-jam {
        font-family:'Outfit',sans-serif; font-size:16px; font-weight:800;
        color:var(--text); line-height:1;
    }
    .entry-status-badge {
        font-family:'Outfit',sans-serif; font-size:10px; font-weight:700;
        padding:2px 8px; border-radius:99px; text-transform:uppercase; letter-spacing:.04em;
    }
    .badge-normal   { background:var(--g-50);  color:var(--g-500);  border:1px solid var(--g-100); }
    .badge-manual   { background:var(--a-50);  color:#92400e;       border:1px solid var(--a-100); }
    .badge-koreksi  { background:var(--v-50);  color:var(--v-500);  border:1px solid var(--v-100); }
    .badge-duplikat { background:var(--r-50);  color:var(--r-500);  border:1px solid var(--r-100); }
    .entry-arrow { color:var(--text4); margin-left:4px; }

    /* ── Empty state ── */
    .empty-state {
        text-align:center; padding:52px 24px;
        background:var(--surface); border:1px solid var(--border);
        border-radius:var(--radius); box-shadow:var(--shadow-sm);
    }
    .empty-icon {
        width:56px; height:56px; border-radius:16px;
        background:var(--surface3); display:flex; align-items:center; justify-content:center;
        margin:0 auto 16px;
    }
    .empty-title {
        font-family:'Outfit',sans-serif; font-size:15px; font-weight:700;
        color:var(--text2); margin-bottom:6px;
    }
    .empty-desc { font-size:13px; color:var(--text4); line-height:1.6; }

    /* ── Pagination ── */
    .pagination-wrap {
        display:flex; align-items:center; justify-content:space-between;
        margin-top:20px; gap:12px; flex-wrap:wrap;
    }
    .pagination-info { font-size:12.5px; color:var(--text3); }
    .pagination-links { display:flex; gap:4px; }
    .page-link {
        display:inline-flex; align-items:center; justify-content:center;
        width:34px; height:34px; border-radius:var(--radius-xs);
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:700;
        color:var(--text2); border:1px solid var(--border); background:var(--surface);
        text-decoration:none; transition:all .15s;
    }
    .page-link:hover { border-color:var(--s-300); color:var(--s-600); }
    .page-link.active { background:var(--s-600); color:#fff; border-color:var(--s-600); }
    .page-link.disabled { opacity:.35; pointer-events:none; }

    /* ── Btn ── */
    .btn {
        display:inline-flex; align-items:center; gap:7px;
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:700;
        padding:9px 18px; border-radius:var(--radius-xs);
        text-decoration:none; border:none; cursor:pointer; transition:all .15s;
    }
    .btn-primary   { background:var(--s-600); color:#fff; }
    .btn-primary:hover { background:var(--s-700); }
    .btn-ghost { background:transparent; color:var(--text3); border:1px solid var(--border); }
    .btn-ghost:hover { background:var(--surface3); color:var(--text); }
    .btn-sm { padding:7px 14px; font-size:12px; }

    /* ── Status hari ini shortcut ── */
    .today-shortcut {
        display:flex; align-items:center; justify-content:space-between; gap:12px;
        background:linear-gradient(135deg, var(--s-800) 0%, var(--s-700) 100%);
        border-radius:var(--radius); padding:14px 18px; margin-bottom:20px;
        text-decoration:none;
    }
    .today-left { display:flex; align-items:center; gap:10px; }
    .today-dot {
        width:8px; height:8px; border-radius:50%;
        background:#4ade80; box-shadow:0 0 0 3px rgba(74,222,128,.25);
        flex-shrink:0; animation:pulse 2s infinite;
    }
    @keyframes pulse {
        0%,100%{ box-shadow:0 0 0 3px rgba(74,222,128,.25); }
        50%    { box-shadow:0 0 0 6px rgba(74,222,128,.1); }
    }
    .today-text {
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:700; color:#fff;
    }
    .today-sub { font-size:11.5px; color:rgba(255,255,255,.55); margin-top:1px; }

    @media(max-width:640px){
        .page { padding:14px 14px 56px; }
        .rekap-strip { grid-template-columns:1fr 1fr; gap:8px; }
        .filter-grid { grid-template-columns:1fr; }
        .entry-body { padding:12px 12px; }
    }
</style>

<div class="page">

    {{-- ── PAGE HEADER ── --}}
    <div class="page-header">
        <h1 class="page-title">Riwayat Absensi Gerbang</h1>
        <p class="page-subtitle">Semua catatan scan masuk &amp; pulang milik {{ $siswa->nama_lengkap }}</p>
    </div>

    {{-- ── STATUS HARI INI shortcut ── --}}
    <a href="{{ route('siswa.absensi-gerbang.status-hari-ini') }}" class="today-shortcut">
        <div class="today-left">
            <span class="today-dot"></span>
            <div>
                <p class="today-text">Status Hari Ini</p>
                <p class="today-sub">Lihat scan masuk &amp; pulang hari ini</p>
            </div>
        </div>
        <svg width="16" height="16" fill="none" stroke="rgba(255,255,255,.6)" stroke-width="2.5" viewBox="0 0 24 24">
            <polyline points="9 18 15 12 9 6"/>
        </svg>
    </a>

    {{-- ── REKAP STRIP ── --}}
    <div class="rekap-strip">
        <div class="rekap-card">
            <div class="rekap-icon rekap-icon-masuk">
                <svg width="20" height="20" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/>
                </svg>
            </div>
            <div>
                <p class="rekap-label">Total Masuk</p>
                <p class="rekap-val">{{ $totalHariMasuk }}</p>
                <p class="rekap-unit">hari hadir</p>
            </div>
        </div>
        <div class="rekap-card">
            <div class="rekap-icon rekap-icon-pulang">
                <svg width="20" height="20" fill="none" stroke="var(--g-500)" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/>
                </svg>
            </div>
            <div>
                <p class="rekap-label">Total Pulang</p>
                <p class="rekap-val">{{ $totalHariPulang }}</p>
                <p class="rekap-unit">hari tercatat</p>
            </div>
        </div>
    </div>

    {{-- ── FILTER CARD ── --}}
    @php
        $hasFilter  = request()->filled('tanggal_dari') || request()->filled('tanggal_sampai');
        $hasTipe    = request()->filled('tipe');
        $filterOpen = $hasFilter || $hasTipe;
        $activeFilter = (int)$hasFilter; // hanya count filter tanggal
    @endphp

    <div class="filter-card">
        <div class="filter-header" onclick="toggleFilter()">
            <div class="filter-header-left">
                <svg width="14" height="14" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                </svg>
                <span class="filter-title">Filter Riwayat</span>
                @if($activeFilter)
                    <span class="filter-active-badge">{{ $activeFilter }} aktif</span>
                @endif
            </div>
            <svg class="filter-chevron {{ $filterOpen ? 'open' : '' }}"
                 id="filter-chevron"
                 width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <polyline points="6 9 12 15 18 9"/>
            </svg>
        </div>

        <div class="filter-body" id="filter-body" style="{{ $filterOpen ? '' : 'display:none' }}">
            <form method="GET" action="{{ route('siswa.absensi-gerbang.riwayat') }}">
                {{-- Preserve tipe di filter form jika ada --}}
                @if($hasTipe)
                    <input type="hidden" name="tipe" value="{{ request('tipe') }}">
                @endif
                <div class="filter-grid">
                    <div class="filter-group">
                        <label class="filter-label">Tanggal Dari</label>
                        <input type="date" name="tanggal_dari" class="filter-input"
                               value="{{ request('tanggal_dari') }}">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Tanggal Sampai</label>
                        <input type="date" name="tanggal_sampai" class="filter-input"
                               value="{{ request('tanggal_sampai') }}">
                    </div>
                </div>
                <div class="filter-actions">
                    @if($filterOpen)
                        <a href="{{ route('siswa.absensi-gerbang.riwayat') }}" class="btn btn-ghost btn-sm">
                            Reset
                        </a>
                    @endif
                    <button type="submit" class="btn btn-primary btn-sm">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        Terapkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── TIPE TABS ── --}}
    @php $activeTipe = request('tipe', ''); @endphp
    <div class="tipe-tabs">
        {{-- FIX: gunakan except() lalu merge agar query string bersih & konsisten --}}
        <a href="{{ route('siswa.absensi-gerbang.riwayat', request()->except(['tipe', 'page'])) }}"
           class="tipe-tab {{ $activeTipe === '' ? 'active-all' : '' }}">
            Semua
        </a>
        <a href="{{ route('siswa.absensi-gerbang.riwayat', array_merge(request()->except('page'), ['tipe' => 'masuk'])) }}"
           class="tipe-tab {{ $activeTipe === 'masuk' ? 'active-masuk' : '' }}">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/>
            </svg>
            Masuk
        </a>
        <a href="{{ route('siswa.absensi-gerbang.riwayat', array_merge(request()->except('page'), ['tipe' => 'pulang'])) }}"
           class="tipe-tab {{ $activeTipe === 'pulang' ? 'active-pulang' : '' }}">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/>
            </svg>
            Pulang
        </a>
    </div>

    {{-- ── ENTRY LIST ── --}}
    @if($riwayat->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="24" height="24" fill="none" stroke="var(--text4)" stroke-width="1.8" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
            <p class="empty-title">Tidak ada data ditemukan</p>
            <p class="empty-desc">
                @if($hasFilter || $hasTipe)
                    Coba ubah filter pencarian atau reset filter untuk melihat semua riwayat.
                @else
                    Belum ada catatan scan absensi gerbang untuk akun ini.
                @endif
            </p>
            @if($hasFilter || $hasTipe)
                <a href="{{ route('siswa.absensi-gerbang.riwayat') }}" class="btn btn-ghost btn-sm" style="margin-top:16px">
                    Reset Filter
                </a>
            @endif
        </div>
    @else
        {{--
            FIX: Group by date — gunakan tanggal_scan jika tersedia (sudah di-cast ke date),
            fallback ke waktu_scan. Cegah error jika keduanya null dengan null-safe check.
        --}}
        @php
            $grouped = $riwayat->groupBy(function ($r) {
                // tanggal_scan di-cast ke 'date' (Carbon), waktu_scan ke 'datetime'
                if (! is_null($r->tanggal_scan)) {
                    return $r->tanggal_scan->format('Y-m-d');
                }
                if (! is_null($r->waktu_scan)) {
                    return $r->waktu_scan->format('Y-m-d');
                }
                return 'unknown';
            });
        @endphp

        @foreach($grouped as $date => $entries)
            @php
                $carbonDate = $date !== 'unknown'
                    ? \Carbon\Carbon::createFromFormat('Y-m-d', $date)
                    : null;
            @endphp
            <div class="entry-group">
                <p class="entry-date-label">
                    @if($carbonDate)
                        {{ $carbonDate->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        @if($carbonDate->isToday()) &nbsp;&middot; Hari ini @endif
                        @if($carbonDate->isYesterday()) &nbsp;&middot; Kemarin @endif
                    @else
                        Tanggal tidak diketahui
                    @endif
                </p>

                @foreach($entries as $item)
                    @php
                        $tipe   = $item->tipe   ?? 'masuk';
                        $status = $item->status ?? 'normal';
                        // waktu_scan sudah di-cast datetime, tapi defensive check tetap perlu
                        $waktu  = $item->waktu_scan instanceof \Carbon\Carbon
                            ? $item->waktu_scan
                            : \Carbon\Carbon::parse($item->waktu_scan);
                        $badgeLabel = match($status) {
                            'manual'   => 'Manual',
                            'koreksi'  => 'Koreksi',
                            'duplikat' => 'Duplikat',
                            default    => 'Valid',
                        };
                        $metode      = $item->metode ?? 'barcode';
                        $metodeLabel = match($metode) {
                            'barcode' => 'Scan Barcode',
                            'manual'  => 'Input Manual',
                            'koreksi' => 'Koreksi Admin',
                            default   => ucfirst($metode),
                        };
                        $sesiNama = $item->sesiGerbang->nama ?? null;
                    @endphp

                    <a href="{{ route('siswa.absensi-gerbang.show', $item->id) }}" class="entry-card">
                        <div class="entry-strip entry-strip-{{ $tipe }}"></div>
                        <div class="entry-body">
                            <div class="entry-icon entry-icon-{{ $tipe }}">
                                @if($tipe === 'masuk')
                                    <svg width="18" height="18" fill="none" stroke="var(--s-500)" stroke-width="2.2" viewBox="0 0 24 24">
                                        <line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/>
                                    </svg>
                                @else
                                    <svg width="18" height="18" fill="none" stroke="var(--g-500)" stroke-width="2.2" viewBox="0 0 24 24">
                                        <line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="entry-info">
                                <p class="entry-tipe">
                                    {{ $tipe === 'masuk' ? 'Scan Masuk' : 'Scan Pulang' }}
                                </p>
                                <p class="entry-meta">
                                    {{ $metodeLabel }}
                                    @if($sesiNama) &nbsp;&middot;&nbsp; {{ $sesiNama }} @endif
                                </p>
                            </div>
                            <div class="entry-right">
                                <span class="entry-jam">{{ $waktu->format('H:i') }}</span>
                                <span class="entry-status-badge badge-{{ $status }}">{{ $badgeLabel }}</span>
                            </div>
                            <svg class="entry-arrow" width="14" height="14" fill="none" stroke="currentColor"
                                 stroke-width="2.5" viewBox="0 0 24 24">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        @endforeach

        {{-- ── PAGINATION ── --}}
        @if($riwayat->hasPages())
            <div class="pagination-wrap">
                <span class="pagination-info">
                    Menampilkan {{ $riwayat->firstItem() }}–{{ $riwayat->lastItem() }}
                    dari {{ $riwayat->total() }} entri
                </span>
                <div class="pagination-links">
                    {{-- Prev --}}
                    @if($riwayat->onFirstPage())
                        <span class="page-link disabled">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <polyline points="15 18 9 12 15 6"/>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $riwayat->previousPageUrl() }}" class="page-link">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <polyline points="15 18 9 12 15 6"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Page numbers --}}
                    @foreach($riwayat->getUrlRange(max(1, $riwayat->currentPage() - 2), min($riwayat->lastPage(), $riwayat->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}" class="page-link {{ $page === $riwayat->currentPage() ? 'active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    {{-- Next --}}
                    @if($riwayat->hasMorePages())
                        <a href="{{ $riwayat->nextPageUrl() }}" class="page-link">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </a>
                    @else
                        <span class="page-link disabled">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </span>
                    @endif
                </div>
            </div>
        @else
            {{--
                FIX: $riwayat->total() aman karena ini adalah LengthAwarePaginator
                (di-return controller dengan ->paginate()), bukan Collection biasa.
                Tetap guard dengan pengecekan eksplisit.
            --}}
            <p style="font-size:12.5px;color:var(--text4);margin-top:16px;text-align:center">
                Total {{ $riwayat->total() }} entri
            </p>
        @endif
    @endif

</div>

<script>
    function toggleFilter() {
        const body    = document.getElementById('filter-body');
        const chevron = document.getElementById('filter-chevron');
        const isHidden = body.style.display === 'none' || body.style.display === '';
        body.style.display = isHidden ? 'block' : 'none';
        chevron.classList.toggle('open', isHidden);
    }
</script>
</x-app-layout>