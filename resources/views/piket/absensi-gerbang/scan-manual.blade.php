<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
        --yellow-bg:#fefce8;--yellow-border:#fde68a;--yellow-text:#92400e;
        --green-bg:#f0fdf4;--green-border:#bbf7d0;--green-text:#15803d;
        --red-bg:#fef2f2;--red-border:#fecaca;--red-text:#dc2626;
        --purple-bg:#fdf4ff;--purple-border:#e9d5ff;--purple-text:#7c3aed;
    }

    .page { padding: 28px 28px 48px; }
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2; }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; font-family: 'DM Sans', sans-serif; }

    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s, background .15s; white-space: nowrap; }
    .btn:hover { filter: brightness(.93); }
    .btn-primary { background: var(--brand-600); color: #fff; }
    .btn-secondary { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-secondary:hover { background: var(--surface3); filter: none; }
    .btn-sm { padding: 5px 11px; font-size: 12px; border-radius: 6px; }
    .btn:disabled { opacity: .45; cursor: not-allowed; filter: none; }

    /* Alert banner */
    .alert-banner { display: flex; align-items: flex-start; gap: 12px; padding: 14px 18px; border-radius: var(--radius); margin-bottom: 20px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; line-height: 1.5; }
    .alert-banner.warning { background: var(--yellow-bg); border: 1px solid var(--yellow-border); color: var(--yellow-text); }
    .alert-banner.info    { background: var(--brand-50);  border: 1px solid var(--brand-100);   color: var(--brand-700); }
    .alert-banner.success { background: var(--green-bg);  border: 1px solid var(--green-border); color: var(--green-text); }
    .alert-banner svg { flex-shrink: 0; margin-top: 1px; }

    /* Sesi strip */
    .sesi-strip { display: flex; align-items: center; gap: 12px; padding: 12px 18px; background: var(--green-bg); border: 1px solid var(--green-border); border-radius: var(--radius); margin-bottom: 20px; flex-wrap: wrap; }
    .sesi-strip-dot { width: 9px; height: 9px; border-radius: 50%; background: var(--green-text); flex-shrink: 0; animation: pulse-dot 1.8s ease-in-out infinite; }
    @keyframes pulse-dot { 0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(.85)} }
    .sesi-strip-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--green-text); }
    .sesi-strip-meta  { font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: #166534; }

    /* Main layout */
    .main-grid { display: grid; grid-template-columns: 1fr 360px; gap: 16px; align-items: start; }

    /* Scanner card */
    .scanner-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .scanner-card-head { padding: 16px 20px; border-bottom: 1px solid var(--border); background: var(--surface2); display: flex; align-items: center; gap: 10px; }
    .scanner-card-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700; color: var(--text); }
    .scanner-card-sub { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: 2px; }
    .scanner-card-body { padding: 24px 20px; }

    /* Scan input area */
    .scan-input-wrap { position: relative; margin-bottom: 20px; }
    .scan-input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); pointer-events: none; }
    .scan-input { width: 100%; height: 56px; padding: 0 20px 0 46px; border: 2px solid var(--border); border-radius: var(--radius); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-weight: 700; color: var(--text); background: var(--surface2); outline: none; transition: border-color .15s, box-shadow .15s, background .15s; box-sizing: border-box; letter-spacing: .04em; }
    .scan-input:focus { border-color: var(--brand-500); background: #fff; box-shadow: 0 0 0 4px rgba(53,130,240,.12); }
    .scan-input.scanning { border-color: var(--brand-500); background: #fff; animation: scanPulse .3s ease; }
    .scan-input.success  { border-color: var(--green-text); background: var(--green-bg); }
    .scan-input.error    { border-color: var(--red-text);   background: var(--red-bg); }
    @keyframes scanPulse { 0%{transform:scale(1)}50%{transform:scale(1.01)}100%{transform:scale(1)} }

    .scan-input-hint { display: flex; align-items: center; gap: 6px; font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: 8px; }
    .scan-ready-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--green-text); animation: pulse-dot 1.4s ease-in-out infinite; display: inline-block; }
    .scan-ready-dot.off { background: var(--text3); animation: none; }

    /* Result card */
    .result-card { border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; min-height: 120px; transition: border-color .2s; }
    .result-card.show-success { border-color: var(--green-border); }
    .result-card.show-error   { border-color: var(--red-border); }
    .result-card.show-warning { border-color: var(--yellow-border); }

    .result-placeholder { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; padding: 32px 20px; color: var(--text3); }
    .result-placeholder-icon { width: 48px; height: 48px; border-radius: 12px; background: var(--surface2); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; }
    .result-placeholder-text { font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text3); text-align: center; }

    .result-body { display: none; padding: 16px 18px; }
    .result-body.visible { display: flex; gap: 14px; align-items: flex-start; }
    .result-avatar { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 18px; font-weight: 800; color: #fff; flex-shrink: 0; }
    .result-avatar.siswa   { background: linear-gradient(135deg,#3582f0,#1750c0); }
    .result-avatar.guru    { background: linear-gradient(135deg,#8b5cf6,#6d28d9); }
    .result-avatar.unknown { background: linear-gradient(135deg,#94a3b8,#64748b); }
    .result-avatar.error   { background: linear-gradient(135deg,#f87171,#dc2626); }
    .result-info { flex: 1; }
    .result-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 800; color: var(--text); }
    .result-meta { font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .result-tipe { margin-top: 8px; display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }

    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; white-space: nowrap; }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .badge-normal        { background: var(--green-bg); color: var(--green-text); }   .badge-normal .badge-dot        { background: var(--green-text); }
    .badge-duplikat      { background: var(--yellow-bg); color: var(--yellow-text); } .badge-duplikat .badge-dot      { background: #a16207; }
    .badge-tidak_dikenal { background: var(--surface3); color: var(--text2); }        .badge-tidak_dikenal .badge-dot { background: var(--text3); }
    .badge-error         { background: var(--red-bg); color: var(--red-text); }       .badge-error .badge-dot         { background: var(--red-text); }
    .badge-tipe-masuk    { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); padding: 2px 9px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; }
    .badge-tipe-pulang   { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; padding: 2px 9px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; }

    /* Form manual */
    .form-group { margin-bottom: 14px; }
    .form-group:last-child { margin-bottom: 0; }
    .form-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--text2); margin-bottom: 6px; display: block; letter-spacing: .02em; }
    .form-label .req { color: var(--red-text); }
    .form-control { width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text); background: var(--surface2); outline: none; transition: border-color .15s; box-sizing: border-box; }
    .form-control:focus { border-color: var(--brand-500); background: #fff; }
    select.form-control { height: 40px; }
    textarea.form-control { min-height: 72px; resize: vertical; padding: 9px 12px; line-height: 1.5; }
    .form-hint  { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: 4px; }
    .form-error { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--red-text); margin-top: 4px; }

    /* Autocomplete dropdown */
    .autocomplete-wrap { position: relative; }
    .autocomplete-list { position: absolute; top: calc(100% + 4px); left: 0; right: 0; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-sm); box-shadow: 0 8px 24px rgba(0,0,0,.1); z-index: 100; max-height: 240px; overflow-y: auto; display: none; }
    .autocomplete-list.open { display: block; }
    .autocomplete-item { display: flex; align-items: center; gap: 10px; padding: 9px 12px; cursor: pointer; transition: background .1s; border-bottom: 1px solid var(--surface3); }
    .autocomplete-item:last-child { border-bottom: none; }
    .autocomplete-item:hover, .autocomplete-item.highlighted { background: var(--surface2); }
    .autocomplete-avatar { width: 30px; height: 30px; border-radius: 8px; background: linear-gradient(135deg,#3582f0,#1750c0); display: flex; align-items: center; justify-content: center; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 800; color: #fff; flex-shrink: 0; }
    .autocomplete-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .autocomplete-sub  { font-family: 'DM Sans', sans-serif; font-size: 11.5px; color: var(--text3); margin-top: 1px; }
    .autocomplete-empty { padding: 14px 12px; font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text3); text-align: center; }
    .autocomplete-loading { padding: 14px 12px; font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text3); text-align: center; display: flex; align-items: center; justify-content: center; gap: 6px; }

    /* Sidebar */
    .sidebar-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .sidebar-head { padding: 14px 18px; border-bottom: 1px solid var(--border); background: var(--surface2); display: flex; align-items: center; justify-content: space-between; }
    .sidebar-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .sidebar-count { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--text3); background: var(--surface3); border: 1px solid var(--border); padding: 2px 8px; border-radius: 99px; }
    .sidebar-body  { max-height: 520px; overflow-y: auto; }

    .scan-item { display: flex; align-items: flex-start; gap: 10px; padding: 11px 16px; border-bottom: 1px solid var(--surface3); transition: background .1s; }
    .scan-item:last-child { border-bottom: none; }
    .scan-item:hover { background: #fafbff; }
    .scan-item-avatar { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 800; color: #fff; flex-shrink: 0; }
    .scan-item-avatar.siswa   { background: linear-gradient(135deg,#3582f0,#1750c0); }
    .scan-item-avatar.guru    { background: linear-gradient(135deg,#8b5cf6,#6d28d9); }
    .scan-item-avatar.unknown { background: linear-gradient(135deg,#94a3b8,#64748b); }
    .scan-item-avatar.dup     { background: linear-gradient(135deg,#fbbf24,#d97706); }
    .scan-item-body { flex: 1; min-width: 0; }
    .scan-item-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .scan-item-meta { font-family: 'DM Sans', sans-serif; font-size: 11.5px; color: var(--text3); margin-top: 2px; }
    .scan-item-time { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); white-space: nowrap; flex-shrink: 0; }

    .sidebar-empty { padding: 32px 20px; text-align: center; }
    .sidebar-empty-text { font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text3); }

    /* Form actions */
    .form-actions { display: flex; align-items: center; gap: 10px; padding-top: 16px; flex-wrap: wrap; }

    @keyframes slideIn { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:translateY(0); } }
    .slide-in { animation: slideIn .25s ease forwards; }
    @keyframes spin { to { transform: rotate(360deg); } }

    @media (max-width: 900px) { .main-grid { grid-template-columns: 1fr; } }
    @media (max-width: 640px) { .page { padding: 16px; } }
</style>

<div class="page">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Input Absensi Manual</h1>
            <p class="page-sub">Scan barcode kartu siswa / guru atau cari manual jika kartu tidak terbaca</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
            <a href="{{ route('piket.absensi-gerbang.live') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                Live Monitor
            </a>
            <a href="{{ route('piket.absensi-gerbang.rekap') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                    <rect x="9" y="3" width="6" height="4" rx="1"/>
                </svg>
                Rekap
            </a>
        </div>
    </div>

    {{-- ── Sesi aktif strip ── --}}
    @if($sesiAktif)
        <div class="sesi-strip">
            <div class="sesi-strip-dot"></div>
            <div>
                <p class="sesi-strip-label">
                    Sesi Aktif: {{ $sesiAktif->label_tipe ?? ucfirst($sesiAktif->tipe) }}
                </p>
                <p class="sesi-strip-meta">
                    Dibuka {{ $sesiAktif->dibuka_pada->format('H:i') }} WIB
                    &mdash; Scan akan dicatat ke sesi ini secara otomatis
                </p>
            </div>
        </div>
    @else
        <div class="alert-banner warning" role="alert">
            <svg width="16" height="16" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>
                Tidak ada sesi aktif. Pilih sesi hari ini secara manual di bawah,
                atau <a href="{{ route('piket.absensi-gerbang.live') }}" style="color:inherit;text-decoration:underline">buka sesi baru dari Live Monitor</a>.
            </span>
        </div>
    @endif

    {{-- ── Main grid ── --}}
    <div class="main-grid">

        {{-- Kolom kiri: scanner + form manual --}}
        <div>

            {{-- CARD 1: Barcode Scanner --}}
            <div class="scanner-card" style="margin-bottom:16px">
                <div class="scanner-card-head">
                    <svg width="18" height="18" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="3" height="3" rx=".5"/>
                        <rect x="19" y="14" width="2" height="7" rx=".5"/>
                        <rect x="14" y="19" width="5" height="2" rx=".5"/>
                    </svg>
                    <div>
                        <p class="scanner-card-title">Scan Barcode</p>
                        <p class="scanner-card-sub">Arahkan scanner ke barcode kartu siswa atau guru</p>
                    </div>
                </div>
                <div class="scanner-card-body">
                    @unless($sesiAktif)
                        {{--
                            FIX: Jika tidak ada sesi aktif, scanner tidak bisa digunakan.
                            Tampilkan pesan informatif dan nonaktifkan input.
                        --}}
                        <div class="alert-banner warning" role="alert" style="margin-bottom:0">
                            <svg width="16" height="16" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            <span>Scanner tidak aktif — tidak ada sesi yang sedang berjalan.</span>
                        </div>
                    @else
                        <div class="scan-input-wrap">
                            <div class="scan-input-icon">
                                <svg width="18" height="18" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24">
                                    <line x1="3" y1="4" x2="3" y2="20"/><line x1="6" y1="4" x2="6" y2="20"/>
                                    <line x1="9" y1="4" x2="9" y2="20"/><line x1="13" y1="4" x2="13" y2="20"/>
                                    <line x1="16" y1="4" x2="16" y2="20"/><line x1="20" y1="4" x2="20" y2="20"/>
                                </svg>
                            </div>
                            <input type="text" id="scan-input" class="scan-input"
                                   placeholder="Scan barcode kartu di sini…"
                                   autocomplete="off" spellcheck="false"
                                   aria-label="Input barcode scanner">
                        </div>
                        <div class="scan-input-hint">
                            <span class="scan-ready-dot" id="scan-dot"></span>
                            <span id="scan-hint-text">Siap menerima scan — klik field jika tidak aktif</span>
                        </div>

                        <div style="margin-top:20px">
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:8px">Hasil Scan</p>
                            <div class="result-card" id="result-card">
                                <div class="result-placeholder" id="result-placeholder">
                                    <div class="result-placeholder-icon">
                                        <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                                            <line x1="3" y1="4" x2="3" y2="20"/><line x1="6" y1="4" x2="6" y2="20"/>
                                            <line x1="9" y1="4" x2="9" y2="20"/><line x1="13" y1="4" x2="13" y2="20"/>
                                            <line x1="16" y1="4" x2="16" y2="20"/><line x1="20" y1="4" x2="20" y2="20"/>
                                        </svg>
                                    </div>
                                    <p class="result-placeholder-text">Hasil scan akan muncul di sini</p>
                                </div>
                                <div class="result-body" id="result-body">
                                    <div class="result-avatar" id="result-avatar">?</div>
                                    <div class="result-info">
                                        <p class="result-name" id="result-name">—</p>
                                        <p class="result-meta" id="result-meta">—</p>
                                        <div class="result-tipe" id="result-tipe"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endunless
                </div>
            </div>

            {{-- CARD 2: Input Manual --}}
            <div class="scanner-card">
                <div class="scanner-card-head">
                    <svg width="18" height="18" fill="none" stroke="var(--purple-text)" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/>
                    </svg>
                    <div>
                        <p class="scanner-card-title">Input Manual</p>
                        <p class="scanner-card-sub">Cari siswa manual jika barcode tidak terbaca atau kartu tertinggal</p>
                    </div>
                </div>
                <div class="scanner-card-body">
                    <form action="{{ route('piket.absensi-gerbang.proses-scan-manual') }}"
                          method="POST" id="form-manual">
                        @csrf

                        {{--
                            FIX: Sesi — pakai sesiAktif jika ada, atau tampilkan dropdown pilih sesi.
                            Controller prosesScanManual() memvalidasi 'sesi_gerbang_id' wajib ada.
                        --}}
                        @if($sesiAktif)
                            <input type="hidden" name="sesi_gerbang_id" value="{{ $sesiAktif->id }}">
                            <div class="alert-banner info" role="alert" style="margin-bottom:16px">
                                <svg width="14" height="14" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                <span style="font-size:12.5px">
                                    Akan dicatat ke sesi:
                                    <strong>{{ $sesiAktif->label_tipe ?? ucfirst($sesiAktif->tipe) }}</strong>
                                    ({{ $sesiAktif->dibuka_pada->format('H:i') }} WIB)
                                </span>
                            </div>
                        @else
                            <div class="form-group">
                                <label class="form-label" for="sesi_gerbang_id">
                                    Pilih Sesi <span class="req">*</span>
                                </label>
                                <select name="sesi_gerbang_id" id="sesi_gerbang_id" class="form-control" required>
                                    <option value="">— Pilih sesi —</option>
                                    @forelse($sesiHariIni as $sesi)
                                        {{--
                                            FIX: Controller prosesScanManual() memvalidasi
                                            sesi->status === 'aktif' setelah form dikirim.
                                            Di sini kita disable sesi non-aktif agar UX lebih jelas.
                                        --}}
                                        <option value="{{ $sesi->id }}"
                                            {{ old('sesi_gerbang_id') == $sesi->id ? 'selected' : '' }}
                                            {{ $sesi->status !== 'aktif' ? 'disabled' : '' }}>
                                            {{ $sesi->label_tipe ?? ucfirst($sesi->tipe) }}
                                            ({{ $sesi->dibuka_pada->format('H:i') }})
                                            {{ $sesi->status !== 'aktif' ? '— Tutup' : '' }}
                                        </option>
                                    @empty
                                        <option value="" disabled>Belum ada sesi hari ini</option>
                                    @endforelse
                                </select>
                                @error('sesi_gerbang_id')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        {{--
                            FIX: Autocomplete menggunakan route piket.absensi-gerbang.ajax-live
                            bukan 'piket.siswa.cari' yang tidak terdefinisi di routes.
                            Data siswa difetch via endpoint khusus yang perlu ditambahkan,
                            atau gunakan route yang sudah ada. Untuk sementara endpoint autocomplete
                            dikonfigurasi via variabel JS CARI_SISWA_URL yang bisa diubah sesuai
                            route yang benar di backend.

                            CATATAN UNTUK DEVELOPER: Tambahkan route berikut di web.php:
                            Route::get('/absensi-gerbang/cari-siswa', [..., 'cariSiswa'])->name('cari-siswa');
                            yang mengembalikan JSON [{id, nama_lengkap, nis, kelas}]
                        --}}
                        <div class="form-group">
                            <label class="form-label" for="cari-siswa">
                                Nama / NIS Siswa <span class="req">*</span>
                            </label>
                            <div class="autocomplete-wrap">
                                {{-- Isi ulang field cari jika ada old input (setelah validasi gagal) --}}
                                <input type="text" id="cari-siswa" class="form-control"
                                       placeholder="Ketik nama atau NIS siswa…"
                                       autocomplete="off" spellcheck="false"
                                       value="{{ old('_cari_siswa_display', '') }}">
                                <input type="hidden" name="siswa_id" id="siswa_id"
                                       value="{{ old('siswa_id') }}">
                                <div class="autocomplete-list" id="autocomplete-list"></div>
                            </div>
                            <p class="form-hint">Ketik minimal 2 karakter untuk mencari.</p>
                            @error('siswa_id')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="tipe">Tipe Absensi</label>
                            <select name="tipe" id="tipe" class="form-control">
                                <option value="">— Ikuti tipe sesi (otomatis) —</option>
                                <option value="masuk"  {{ old('tipe') === 'masuk'  ? 'selected' : '' }}>Masuk</option>
                                <option value="pulang" {{ old('tipe') === 'pulang' ? 'selected' : '' }}>Pulang</option>
                            </select>
                            <p class="form-hint">Kosongkan untuk mengikuti tipe sesi aktif.</p>
                            @error('tipe')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="catatan">Catatan (opsional)</label>
                            <textarea name="catatan" id="catatan" class="form-control" maxlength="500"
                                      placeholder="Alasan input manual: kartu tertinggal, barcode rusak, dll…">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-actions">
                            {{--
                                FIX: Tombol disabled jika siswa_id kosong.
                                Jika ada old('siswa_id') dari redirect withInput(), tombol harus enabled.
                            --}}
                            <button type="submit" class="btn btn-primary" id="btn-submit-manual"
                                    {{ old('siswa_id') ? '' : 'disabled' }}>
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <polyline points="9 11 12 14 22 4"/>
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                                </svg>
                                Simpan Absensi Manual
                            </button>
                            <span style="font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text3)" id="selected-siswa-info">
                                {{ old('siswa_id') ? 'Siswa dipilih dari sesi sebelumnya' : 'Pilih siswa terlebih dahulu' }}
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Kolom kanan: riwayat scan sesi ini --}}
        <div>
            <div class="sidebar-card">
                <div class="sidebar-head">
                    <p class="sidebar-title">Scan Sesi Ini</p>
                    {{--
                        FIX: Hitung count langsung dari query (method), bukan dari properti/relasi lazy
                        agar tidak error "call to undefined method on Collection".
                    --}}
                    <span class="sidebar-count" id="sidebar-count">
                        {{ $sesiAktif ? $sesiAktif->absensiGerbang()->count() : 0 }}
                    </span>
                </div>
                <div class="sidebar-body" id="scan-history">
                    @if($sesiAktif)
                        @php
                            /*
                                FIX: Gunakan method (query builder) bukan properti (collection)
                                sehingga bisa chaining orderByDesc()->limit()->get() dengan benar.
                                Sebelumnya: $sesiAktif->absensiGerbang()->with([...])->orderByDesc()->...
                                ini sudah benar, tapi di template asli ada inkonsistensi di beberapa
                                tempat yang mengakses properti tanpa tanda kurung.
                            */
                            $riwayatScan = $sesiAktif->absensiGerbang()
                                ->with(['siswa:id,nama_lengkap,nis', 'guru:id,nama_lengkap,nip'])
                                ->orderByDesc('id')
                                ->limit(50)
                                ->get();
                        @endphp
                        @forelse($riwayatScan as $scan)
                            @php
                                $avatarClass = match(true) {
                                    $scan->status === 'duplikat'                          => 'dup',
                                    $scan->siswa_id !== null                              => 'siswa',
                                    $scan->guru_id  !== null                              => 'guru',
                                    default                                               => 'unknown',
                                };
                                $inisial = match(true) {
                                    $scan->siswa_id !== null => strtoupper(substr($scan->siswa->nama_lengkap ?? 'S', 0, 1)),
                                    $scan->guru_id  !== null => strtoupper(substr($scan->guru->nama_lengkap  ?? 'G', 0, 1)),
                                    default                  => '?',
                                };
                            @endphp
                            <div class="scan-item">
                                <div class="scan-item-avatar {{ $avatarClass }}">{{ $inisial }}</div>
                                <div class="scan-item-body">
                                    <p class="scan-item-name">
                                        @if($scan->siswa_id)
                                            {{ $scan->siswa->nama_lengkap ?? '—' }}
                                        @elseif($scan->guru_id)
                                            {{ $scan->guru->nama_lengkap ?? '—' }}
                                        @else
                                            <span style="color:var(--text3);font-style:italic">Tidak dikenal</span>
                                        @endif
                                    </p>
                                    <p class="scan-item-meta">
                                        {{ ucfirst($scan->tipe) }}
                                        &bull; {{ ucfirst(str_replace('_', ' ', $scan->status)) }}
                                        @if($scan->is_manual)
                                            &bull; <em>Manual</em>
                                        @endif
                                    </p>
                                </div>
                                <span class="scan-item-time">{{ $scan->waktu_scan->format('H:i') }}</span>
                            </div>
                        @empty
                            <div class="sidebar-empty" id="sidebar-empty-placeholder">
                                <p class="sidebar-empty-text">Belum ada scan di sesi ini</p>
                            </div>
                        @endforelse
                    @else
                        <div class="sidebar-empty" id="sidebar-empty-placeholder">
                            <p class="sidebar-empty-text">Tidak ada sesi aktif</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>{{-- /.main-grid --}}
</div>{{-- /.page --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ── Session flash ──────────────────────────────────────────────────────────────
@if(session('success'))
Swal.fire({
    icon:'success', title:'Berhasil!',
    text: @json(session('success')),
    timer:2800, showConfirmButton:false,
    toast:true, position:'top-end'
});
@endif

@if(session('error'))
Swal.fire({
    icon:'error', title:'Gagal!',
    text: @json(session('error')),
    confirmButtonColor:'#1f63db'
});
@endif

// ── Konstanta ──────────────────────────────────────────────────────────────────
const SESI_AKTIF_ID  = {{ $sesiAktif?->id ?? 'null' }};

/* FIX: Route 'piket.siswa.cari' tidak terdefinisi di web.php.
    Gunakan route yang ada atau definisikan endpoint baru.
    Untuk autocomplete siswa, perlu route:
    Route::get('/absensi-gerbang/cari-siswa', [AbsensiGerbangController::class, 'cariSiswa'])
        ->name('absensi-gerbang.cari-siswa');
    
    Sementara ini pakai URL yang bisa disesuaikan: */
const CARI_SISWA_URL = "{{ url('/piket/absensi-gerbang/cari-siswa') }}"; // Ganti ke endpoint cariSiswa yang benar

// ── 1. BARCODE SCANNER ────────────────────────────────────────────────────────
@if($sesiAktif)
const scanInput    = document.getElementById('scan-input');
const resultCard   = document.getElementById('result-card');
const resultBody   = document.getElementById('result-body');
const resultPh     = document.getElementById('result-placeholder');
const resultAvatar = document.getElementById('result-avatar');
const resultName   = document.getElementById('result-name');
const resultMeta   = document.getElementById('result-meta');
const resultTipe   = document.getElementById('result-tipe');
const scanDot      = document.getElementById('scan-dot');
const scanHint     = document.getElementById('scan-hint-text');

// Auto-focus saat halaman dimuat
setTimeout(() => scanInput.focus(), 300);

// FIX: Refocus timer hanya jalan jika sesi aktif ada, dan TIDAK mengganggu
// field form manual. Daftar id field yang boleh aktif tanpa dipaksa refocus.
const MANUAL_FIELD_IDS = new Set(['cari-siswa', 'catatan', 'sesi_gerbang_id', 'tipe']);

setInterval(() => {
    const activeId = document.activeElement?.id;
    if (!MANUAL_FIELD_IDS.has(activeId)) {
        scanInput.focus();
    }
}, 5000);

scanInput.addEventListener('focus', () => {
    scanDot.classList.remove('off');
    scanHint.textContent = 'Siap menerima scan — scanner aktif';
});
scanInput.addEventListener('blur', () => {
    scanDot.classList.add('off');
    scanHint.textContent = 'Scanner tidak aktif — klik field di atas untuk mengaktifkan';
});

let scanTimer = null;

scanInput.addEventListener('input', () => {
    scanInput.classList.add('scanning');
    clearTimeout(scanTimer);
    scanTimer = setTimeout(() => {
        const kode = scanInput.value.trim();
        if (kode.length >= 3) kirimScan(kode);
    }, 120);
});

scanInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        e.preventDefault();
        const kode = scanInput.value.trim();
        if (kode.length >= 3) {
            clearTimeout(scanTimer);
            kirimScan(kode);
        }
    }
});

async function kirimScan(kode) {
    scanHint.textContent = 'Memproses scan…';

    try {
        const res = await fetch("{{ route('piket.absensi-gerbang.webhook') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({
                kode_scan: kode,
                sesi_gerbang_id: SESI_AKTIF_ID,
            }),
        });

        const data = await res.json();

        // FIX: Webhook mengembalikan 201 untuk normal, 200 untuk duplikat, 422 untuk error.
        // Periksa berdasarkan field 'status' di response, bukan hanya HTTP status.
        if (res.status === 201 || res.status === 200) {
            const isDuplikat   = data.status === 'duplikat';
            const isTidakKenal = data.status === 'tidak_dikenal';
            const statusClass  = isDuplikat ? 'duplikat' : (isTidakKenal ? 'tidak_dikenal' : 'normal');

            // FIX: Key dari webhook adalah 'tipe_scan' untuk tipe pemilik (siswa/guru),
            // dan 'tipe' untuk masuk/pulang. Pastikan mapping konsisten.
            const avatarType = data.kelas === 'Guru' ? 'guru'
                             : (data.nama && !data.nama.startsWith('Tidak') ? 'siswa' : 'unknown');

            const metaParts = [];
            if (data.identitas && data.identitas !== '-') {
                metaParts.push((data.kelas === 'Guru' ? 'NIP: ' : 'NIS: ') + data.identitas);
            }
            if (data.kelas && data.kelas !== '-') metaParts.push(data.kelas);

            showResult(statusClass, avatarType, data.nama || 'Tidak Dikenal', metaParts.join(' · '), data.tipe_scan, data.status);

            if (isDuplikat) {
                scanInput.classList.add('error');
                playBeep('dup');
            } else {
                scanInput.classList.add('success');
                playBeep('ok');
                if (!isTidakKenal) prependSidebarItem(data);
            }
        } else {
            // FIX: Tampilkan pesan error dari server (mis. "Tidak ada sesi aktif")
            showResult('error', 'error', 'Gagal', data.message || 'Terjadi kesalahan', '', 'error');
            scanInput.classList.add('error');
            playBeep('err');
        }
    } catch (err) {
        showResult('error', 'error', 'Koneksi Error', 'Periksa koneksi internet atau server', '', 'error');
        scanInput.classList.add('error');
        playBeep('err');
    }

    setTimeout(() => {
        scanInput.value = '';
        scanInput.classList.remove('scanning', 'success', 'error');
        scanHint.textContent = 'Siap menerima scan — scanner aktif';
    }, 1200);
}

function showResult(statusClass, avatarType, nama, meta, tipe, status) {
    resultPh.style.display = 'none';
    resultBody.classList.add('visible');

    resultAvatar.textContent = nama ? nama.charAt(0).toUpperCase() : '?';
    resultAvatar.className   = `result-avatar ${avatarType}`;
    resultName.textContent   = nama;
    resultMeta.textContent   = meta;

    resultTipe.innerHTML = '';
    if (tipe) {
        const tipeBadge = document.createElement('span');
        tipeBadge.className   = `badge-tipe-${tipe}`;
        tipeBadge.textContent = tipe.charAt(0).toUpperCase() + tipe.slice(1);
        resultTipe.appendChild(tipeBadge);
    }
    if (status) {
        const statusMap = {
            'normal':        ['badge-normal',        'Normal'],
            'duplikat':      ['badge-duplikat',       'Duplikat'],
            'tidak_dikenal': ['badge-tidak_dikenal',  'Tidak Dikenal'],
            'error':         ['badge-error',          'Error'],
        };
        const [cls, label] = statusMap[statusClass] ?? statusMap['error'];
        const stBadge = document.createElement('span');
        stBadge.className   = `badge ${cls}`;
        stBadge.innerHTML   = `<span class="badge-dot"></span>${label}`;
        resultTipe.appendChild(stBadge);
    }

    resultCard.className = `result-card show-${
        statusClass === 'normal'   ? 'success' :
        statusClass === 'duplikat' ? 'warning'  : 'error'
    }`;
}

function prependSidebarItem(data) {
    const history = document.getElementById('scan-history');
    // FIX: Hapus placeholder (baik empty state maupun "tidak ada sesi") jika ada
    const emptyEl = history.querySelector('.sidebar-empty');
    if (emptyEl) emptyEl.remove();

    const avatarType = (data.kelas === 'Guru') ? 'guru'
                     : (data.nama && !data.nama.startsWith('Tidak')) ? 'siswa' : 'unknown';
    const inisial = data.nama ? data.nama.charAt(0).toUpperCase() : '?';
    const now = new Date().toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit', hour12:false });
    const tipeLabel = data.tipe ? (data.tipe.charAt(0).toUpperCase() + data.tipe.slice(1)) : '—';

    const html = `<div class="scan-item slide-in">
        <div class="scan-item-avatar ${avatarType}">${inisial}</div>
        <div class="scan-item-body">
            <p class="scan-item-name">${escapeHtml(data.nama || 'Tidak dikenal')}</p>
            <p class="scan-item-meta">${tipeLabel} &bull; Normal</p>
        </div>
        <span class="scan-item-time">${now}</span>
    </div>`;
    history.insertAdjacentHTML('afterbegin', html);

    // FIX: Sidebar count sudah dihitung dari PHP saat render, tinggal tambah 1
    const counter = document.getElementById('sidebar-count');
    counter.textContent = parseInt(counter.textContent || '0') + 1;
}

function escapeHtml(str) {
    const d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
}

function playBeep(type) {
    try {
        const ctx  = new (window.AudioContext || window.webkitAudioContext)();
        const osc  = ctx.createOscillator();
        const gain = ctx.createGain();
        osc.connect(gain); gain.connect(ctx.destination);
        if (type === 'ok')  { osc.frequency.value = 880; gain.gain.value = .15; }
        if (type === 'dup') { osc.frequency.value = 400; gain.gain.value = .20; }
        if (type === 'err') { osc.frequency.value = 220; gain.gain.value = .20; }
        osc.start(); osc.stop(ctx.currentTime + .15);
    } catch (_) { /* autoplay blocked */ }
}
@endif

// ── 2. AUTOCOMPLETE CARI SISWA ────────────────────────────────────────────────
const cariInput    = document.getElementById('cari-siswa');
const siswaIdInput = document.getElementById('siswa_id');
const aList        = document.getElementById('autocomplete-list');
const btnSubmit    = document.getElementById('btn-submit-manual');
const selectedInfo = document.getElementById('selected-siswa-info');

let acTimer = null;

// FIX: Jika ada old('siswa_id') dari redirect withInput(), anggap sudah ada siswa terpilih
// sehingga tombol submit langsung enabled (sudah di-handle via Blade disabled attribute)
let siswaSelected = {{ old('siswa_id') ? 'true' : 'false' }};

cariInput.addEventListener('input', () => {
    const q = cariInput.value.trim();
    // Reset pilihan ketika user mengetik ulang
    siswaIdInput.value = '';
    siswaSelected      = false;
    btnSubmit.disabled = true;
    selectedInfo.textContent = 'Pilih siswa terlebih dahulu';

    if (q.length < 2) { closeAc(); return; }

    clearTimeout(acTimer);
    aList.innerHTML = `<div class="autocomplete-loading">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
             style="animation:spin .6s linear infinite">
            <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
        </svg>
        Mencari…</div>`;
    aList.classList.add('open');

    acTimer = setTimeout(() => fetchSiswa(q), 300);
});

async function fetchSiswa(q) {
    try {
        // FIX: Gunakan endpoint yang benar. Endpoint ini perlu ditambahkan di controller & routes.
        // Contoh: GET /piket/absensi-gerbang/cari-siswa?q=xxx → [{id, nama_lengkap, nis, kelas}]
        // Untuk sementara jika endpoint belum ada, tampilkan pesan informatif.
        const url = `{{ url('/piket/absensi-gerbang/cari-siswa') }}?q=${encodeURIComponent(q)}`;
        const res = await fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });

        if (res.status === 404) {
            aList.innerHTML = `<div class="autocomplete-empty">
                Endpoint belum tersedia — tambahkan route <code>cari-siswa</code> di controller.
            </div>`;
            return;
        }

        if (!res.ok) { closeAc(); return; }

        const list = await res.json();

        if (!Array.isArray(list) || list.length === 0) {
            aList.innerHTML = `<div class="autocomplete-empty">Tidak ada siswa ditemukan</div>`;
            return;
        }

        aList.innerHTML = list.map(s => `
            <div class="autocomplete-item" data-id="${s.id}"
                 data-nama="${escStr(s.nama_lengkap)}" data-nis="${escStr(s.nis)}">
                <div class="autocomplete-avatar">${s.nama_lengkap.charAt(0).toUpperCase()}</div>
                <div>
                    <p class="autocomplete-name">${escStr(s.nama_lengkap)}</p>
                    <p class="autocomplete-sub">NIS: ${escStr(s.nis)} &middot; ${escStr(s.kelas ?? '—')}</p>
                </div>
            </div>
        `).join('');

        aList.querySelectorAll('.autocomplete-item').forEach(item => {
            item.addEventListener('click', () => selectSiswa(item));
        });
    } catch (_) {
        aList.innerHTML = `<div class="autocomplete-empty">Gagal memuat data siswa</div>`;
    }
}

function escStr(str) {
    // Escape untuk dipakai dalam HTML attribute data-* dan innerHTML
    return String(str ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

function selectSiswa(item) {
    const id   = item.dataset.id;
    const nama = item.dataset.nama;
    const nis  = item.dataset.nis;

    siswaIdInput.value       = id;
    cariInput.value          = nama;
    siswaSelected            = true;
    btnSubmit.disabled       = false;
    selectedInfo.textContent = `NIS: ${nis}`;
    closeAc();
}

function closeAc() {
    aList.classList.remove('open');
    aList.innerHTML = '';
}

document.addEventListener('click', e => {
    if (!e.target.closest('.autocomplete-wrap')) closeAc();
});

cariInput.addEventListener('keydown', e => {
    const items   = aList.querySelectorAll('.autocomplete-item');
    if (!items.length) return;
    const current = aList.querySelector('.highlighted');
    const idx     = [...items].indexOf(current);

    if (e.key === 'ArrowDown') {
        e.preventDefault();
        current?.classList.remove('highlighted');
        items[Math.min(idx + 1, items.length - 1)].classList.add('highlighted');
    } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        current?.classList.remove('highlighted');
        items[Math.max(idx - 1, 0)].classList.add('highlighted');
    } else if (e.key === 'Enter') {
        e.preventDefault();
        if (current) selectSiswa(current);
    } else if (e.key === 'Escape') {
        closeAc();
    }
});

// FIX: Cegah submit jika siswa belum dipilih (guard tambahan selain disabled attribute)
document.getElementById('form-manual').addEventListener('submit', function(e) {
    if (!siswaIdInput.value) {
        e.preventDefault();
        cariInput.focus();
        Swal.fire({
            icon: 'warning',
            title: 'Pilih Siswa',
            text: 'Pilih siswa dari daftar autocomplete terlebih dahulu.',
            confirmButtonColor: '#1f63db',
            timer: 3000,
        });
    }
});
</script>
</x-app-layout>