<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-detail:hover{background:#dcfce7;filter:none}
    .btn-warn{background:#fffbeb;color:#a16207;border:1px solid #fde68a}
    .btn-warn:hover{background:#fef9c3;filter:none}

    .dropdown{position:relative;display:inline-flex}
    .dropdown-menu{display:none;position:absolute;top:calc(100% + 6px);right:0;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);box-shadow:0 8px 28px rgba(0,0,0,.1);min-width:200px;z-index:200;overflow:hidden}
    .dropdown.open .dropdown-menu{display:block}
    .dropdown-item{display:flex;align-items:center;gap:8px;padding:9px 14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text2);text-decoration:none;background:none;border:none;width:100%;cursor:pointer;transition:background .12s;text-align:left}
    .dropdown-item:hover{background:var(--surface2);color:var(--text)}
    .dropdown-divider{border:none;border-top:1px solid var(--border);margin:4px 0}
    .dropdown-section-label{padding:6px 14px 3px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:700;color:var(--text3);letter-spacing:.06em;text-transform:uppercase}

    .sesi-banner{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:14px 20px;border-radius:var(--radius);border:1px solid #6ee7b7;background:linear-gradient(135deg,#ecfdf5,#d1fae5);margin-bottom:16px;flex-wrap:wrap}
    .sesi-banner.inactive{background:var(--surface2);border-color:var(--border)}
    .sesi-banner-left{display:flex;align-items:center;gap:12px}
    .sesi-banner-right{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
    .sesi-banner-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:#065f46}
    .sesi-banner.inactive .sesi-banner-title{color:var(--text2)}
    .sesi-banner-meta{font-size:12px;color:#059669;margin-top:2px}
    .sesi-banner.inactive .sesi-banner-meta{color:var(--text3)}

    .live-dot{display:inline-block;width:8px;height:8px;border-radius:50%;background:#22c55e;flex-shrink:0;animation:pulse-live 1.4s ease-in-out infinite}
    @keyframes pulse-live{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.45;transform:scale(1.5)}}

    .stats-strip{display:grid;grid-template-columns:repeat(6,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.green{background:#f0fdf4}
    .stat-icon.blue{background:#eff6ff}
    .stat-icon.orange{background:#fff7ed}
    .stat-icon.red{background:#fff0f0}
    .stat-icon.purple{background:#faf5ff}
    .stat-icon.gray{background:var(--surface2)}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row input[type=date],.filter-row input[type=text]{height:36px;padding:0 10px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none}
    .filter-row input[type=date]{width:148px}
    .filter-row input[type=text]{min-width:180px}
    .filter-row select:focus,.filter-row input:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s}
    .btn-filter:hover{background:var(--brand-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:background .15s}
    .btn-reset:hover{background:var(--surface3)}

    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border)}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    tbody tr.row-flash td{animation:flash-new .9s ease}
    @keyframes flash-new{0%{background:#bbf7d0}100%{background:transparent}}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    td.muted{color:var(--text3)}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-masuk   {background:#dcfce7;color:#15803d} .badge-masuk    .badge-dot{background:#15803d}
    .badge-pulang  {background:#dbeafe;color:#1d4ed8} .badge-pulang   .badge-dot{background:#1d4ed8}
    .badge-normal  {background:#f0fdf4;color:#166534} .badge-normal   .badge-dot{background:#166534}
    .badge-duplikat{background:#fefce8;color:#854d0e} .badge-duplikat .badge-dot{background:#854d0e}
    .badge-koreksi {background:#ede9fe;color:#6d28d9} .badge-koreksi  .badge-dot{background:#6d28d9}
    .badge-manual  {background:#fff7ed;color:#c2410c} .badge-manual   .badge-dot{background:#c2410c}
    .badge-unknown {background:var(--surface2);color:var(--text3)} .badge-unknown .badge-dot{background:var(--text3)}

    .two-line .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .two-line .secondary{font-size:12px;color:var(--text3);margin-top:1px}
    .action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap}

    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px;align-items:center}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2);border-color:var(--border2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}

    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:300;align-items:center;justify-content:center}
    .modal-overlay.active{display:flex}
    .modal{background:var(--surface);border-radius:var(--radius);width:420px;max-width:calc(100vw - 32px);box-shadow:0 20px 60px rgba(0,0,0,.15);overflow:hidden}
    .modal-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border)}
    .modal-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text)}
    .modal-close{width:28px;height:28px;display:flex;align-items:center;justify-content:center;border:none;background:var(--surface2);border-radius:6px;cursor:pointer;color:var(--text3)}
    .modal-close:hover{background:var(--surface3);color:var(--text)}
    .modal-body{padding:20px}
    .modal-footer{display:flex;gap:8px;justify-content:flex-end;padding:14px 20px;border-top:1px solid var(--border);background:var(--surface2)}
    .field{display:flex;flex-direction:column;gap:4px;margin-bottom:14px}
    .field:last-child{margin-bottom:0}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text2)}
    .field select,.field input,.field textarea{padding:8px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .field select:focus,.field input:focus,.field textarea:focus{border-color:var(--brand-500);background:#fff}
    .field textarea{resize:vertical;min-height:72px}
    .info-block{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:10px 14px;margin-bottom:16px;font-size:12.5px;color:var(--text2);line-height:1.6}
    .info-block strong{font-weight:700;color:var(--text)}

    @media(max-width:900px){.stats-strip{grid-template-columns:repeat(3,1fr)}}
    @media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr};.page{padding:16px};.header-actions{width:100%}}
</style>

<div class="page">

    {{-- ── Header ──────────────────────────────────────────────────────── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Log Absensi Gerbang</h1>
            <p class="page-sub">Scan masuk &amp; pulang siswa — {{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM Y') }}</p>
        </div>
        <div class="header-actions">

            @if($sesiAktif)
            <a href="{{ route('admin.absensi-gerbang.input-manual') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Input Manual
            </a>
            @endif

            <div class="dropdown" id="exportDropdown">
                <button type="button" class="btn btn-secondary" onclick="toggleDropdown('exportDropdown')">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="dropdown-menu">
                    <div class="dropdown-section-label">Log Harian</div>
                    <a href="{{ route('admin.absensi-gerbang.export.pdf', request()->query()) }}" class="dropdown-item">
                        <svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Export PDF
                    </a>
                    <a href="{{ route('admin.absensi-gerbang.export.excel', request()->query()) }}" class="dropdown-item">
                        <svg width="14" height="14" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Export Excel
                    </a>
                    <hr class="dropdown-divider">
                    <div class="dropdown-section-label">Rekap Periode</div>
                    <a href="{{ route('admin.absensi-gerbang.rekap.export.pdf', request()->query()) }}" class="dropdown-item">
                        <svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                        Export Rekap PDF
                    </a>
                    <a href="{{ route('admin.absensi-gerbang.rekap.export.excel', request()->query()) }}" class="dropdown-item">
                        <svg width="14" height="14" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                        Export Rekap Excel
                    </a>
                </div>
            </div>

            <div class="dropdown" id="menuDropdown">
                <button type="button" class="btn btn-secondary" onclick="toggleDropdown('menuDropdown')">
                    Menu Lain
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="dropdown-menu">
                    <div class="dropdown-section-label">Laporan</div>
                    <a href="{{ route('admin.absensi-gerbang.rekap') }}" class="dropdown-item">
                        <svg width="14" height="14" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                        Rekap Kehadiran
                    </a>
                    <a href="{{ route('admin.absensi-gerbang.belum-hadir') }}" class="dropdown-item">
                        <svg width="14" height="14" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/><line x1="17" y1="11" x2="22" y2="11"/></svg>
                        Siswa Belum Hadir
                    </a>
                    <hr class="dropdown-divider">
                    <div class="dropdown-section-label">Manajemen Sesi</div>
                    <a href="{{ route('admin.sesi-gerbang.index') }}" class="dropdown-item">
                        <svg width="14" height="14" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Kelola Sesi Gerbang
                    </a>
                    <a href="{{ route('admin.sesi-gerbang.create') }}" class="dropdown-item">
                        <svg width="14" height="14" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Buka Sesi Baru
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- ── Sesi Aktif Banner ────────────────────────────────────────────── --}}
    @if($sesiAktif)
    <div class="sesi-banner">
        <div class="sesi-banner-left">
            <span class="live-dot"></span>
            <div>
                <p class="sesi-banner-title">Sesi {{ $sesiAktif->label_tipe }} sedang aktif</p>
                <p class="sesi-banner-meta">
                    Dibuka pukul {{ $sesiAktif->dibuka_pada->format('H:i') }}
                    &middot; oleh {{ $sesiAktif->dibukaOleh->name }}
                    &middot; <span id="live-timestamp">–</span>
                </p>
            </div>
        </div>
        <div class="sesi-banner-right">
            <span class="badge badge-masuk">
                <span class="badge-dot"></span>
                <span id="stat-live-masuk">{{ $statistik['total_masuk'] }}</span> masuk
            </span>
            <a href="{{ route('admin.sesi-gerbang.show', $sesiAktif) }}" class="btn btn-sm btn-detail">Detail Sesi</a>
            <form method="POST" action="{{ route('admin.sesi-gerbang.tutup', $sesiAktif) }}" id="formTutupSesi" style="display:inline">
                @csrf @method('PATCH')
                <button type="button" class="btn btn-sm btn-del" onclick="confirmTutupSesi()">Tutup Sesi</button>
            </form>
        </div>
    </div>
    @else
    <div class="sesi-banner inactive">
        <div class="sesi-banner-left">
            <svg width="18" height="18" fill="none" stroke="var(--text3)" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>
                <p class="sesi-banner-title">Tidak ada sesi aktif hari ini</p>
                <p class="sesi-banner-meta">Buka sesi baru agar alat scanner dapat menerima scan</p>
            </div>
        </div>
        <a href="{{ route('admin.sesi-gerbang.create') }}" class="btn btn-primary btn-sm">Buka Sesi</a>
    </div>
    @endif

    {{-- ── Statistik ────────────────────────────────────────────────────── --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Masuk</p>
                {{-- BUG FIX #3: ID diperbaiki agar sesuai dengan yang diupdate JS (stat-masuk) --}}
                <p class="stat-val" id="stat-masuk">{{ $statistik['total_masuk'] }}</p>
                <p class="stat-sub">tercatat masuk</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </div>
            <div>
                <p class="stat-label">Pulang</p>
                {{-- BUG FIX #4: ID ditambahkan agar bisa diupdate JS --}}
                <p class="stat-val" id="stat-pulang">{{ $statistik['total_pulang'] }}</p>
                <p class="stat-sub">tercatat pulang</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/><line x1="17" y1="11" x2="22" y2="11"/></svg>
            </div>
            <div>
                <p class="stat-label">Belum Hadir</p>
                <p class="stat-val">{{ $statistik['belum_hadir'] }}</p>
                <p class="stat-sub">dari {{ $statistik['total_siswa'] }} siswa</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
            </div>
            <div>
                <p class="stat-label">Manual</p>
                <p class="stat-val">{{ $statistik['scan_manual'] }}</p>
                <p class="stat-sub">input piket</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div>
                <p class="stat-label">Tdk Dikenal</p>
                <p class="stat-val">{{ $statistik['tidak_dikenal'] }}</p>
                <p class="stat-sub">barcode asing</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon gray">
                <svg width="18" height="18" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            </div>
            <div>
                <p class="stat-label">Kehadiran</p>
                <p class="stat-val">{{ $statistik['persentase_hadir'] }}%</p>
                <p class="stat-sub">tingkat hadir</p>
            </div>
        </div>
    </div>

    {{-- ── Filter ───────────────────────────────────────────────────────── --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.absensi-gerbang.index') }}">
            <div class="filter-row">
                <input type="date" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()">
                <select name="tipe" onchange="this.form.submit()">
                    <option value="">Semua Tipe</option>
                    <option value="masuk"  @selected(request('tipe') === 'masuk')>Masuk</option>
                    <option value="pulang" @selected(request('tipe') === 'pulang')>Pulang</option>
                </select>
                <select name="status" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="normal"   @selected(request('status') === 'normal')>Normal</option>
                    <option value="duplikat" @selected(request('status') === 'duplikat')>Duplikat</option>
                    <option value="koreksi"  @selected(request('status') === 'koreksi')>Koreksi</option>
                    <option value="manual"   @selected(request('status') === 'manual')>Manual</option>
                </select>
                <select name="kelas_id" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" @selected(request('kelas_id') == $k->id)>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama / NIS…">
                <div class="filter-sep"></div>
                @if(request()->hasAny(['tipe','status','kelas_id','cari']) || request('tanggal') !== now()->toDateString())
                    <a href="{{ route('admin.absensi-gerbang.index') }}" class="btn-reset">Reset</a>
                @endif
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- ── Table ────────────────────────────────────────────────────────── --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Log Scan
                @if($scanList->total() > 0)
                    <span>— menampilkan {{ $scanList->firstItem() }}–{{ $scanList->lastItem() }} dari {{ $scanList->total() }} record</span>
                @else
                    <span>— tidak ada data</span>
                @endif
            </p>
            @if($sesiAktif)
            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;color:#059669;display:flex;align-items:center;gap:6px">
                <span class="live-dot" style="width:6px;height:6px"></span>
                Live update aktif
            </span>
            @endif
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Waktu</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th class="center">Tipe</th>
                        <th class="center">Status</th>
                        <th>Sesi</th>
                        <th>Kode Scan</th>
                        <th class="center" style="width:170px">Aksi</th>
                    </tr>
                </thead>
                <tbody id="scan-tbody">
                    @forelse($scanList as $index => $scan)
                    <tr data-id="{{ $scan->id }}">
                        <td><span class="no-col">{{ $scanList->firstItem() + $index }}</span></td>
                        <td style="font-variant-numeric:tabular-nums;white-space:nowrap;font-family:'DM Sans',sans-serif;font-size:13px">
                            {{ $scan->waktu_scan->format('H:i:s') }}
                        </td>
                        <td>
                            @if($scan->siswa)
                            <div class="two-line">
                                <p class="primary">{{ $scan->siswa->nama_lengkap }}</p>
                                <p class="secondary">NIS: {{ $scan->siswa->nis }}</p>
                            </div>
                            @else
                            <div class="two-line">
                                <p class="primary" style="color:var(--text3)">— Tidak Dikenal —</p>
                                <p class="secondary">barcode tidak terdaftar</p>
                            </div>
                            @endif
                        </td>
                        <td class="muted" style="font-size:12.5px">{{ $scan->siswa?->kelas?->nama_kelas ?? '—' }}</td>
                        <td class="center">
                            <span class="badge badge-{{ $scan->tipe }}">
                                <span class="badge-dot"></span>
                                {{ $scan->label_tipe }}
                            </span>
                        </td>
                        <td class="center">
                            @php $sc = in_array($scan->status, ['normal','duplikat','koreksi','manual']) ? $scan->status : 'unknown'; @endphp
                            <span class="badge badge-{{ $sc }}">
                                <span class="badge-dot"></span>
                                {{ $scan->label_status }}
                            </span>
                        </td>
                        <td style="font-size:12.5px">
                            @if($scan->sesiGerbang)
                            <a href="{{ route('admin.sesi-gerbang.show', $scan->sesiGerbang) }}"
                               style="color:var(--brand-600);text-decoration:none;font-weight:600">
                                {{ $scan->sesiGerbang->label_tipe }}
                            </a>
                            @else
                            <span class="muted">—</span>
                            @endif
                        </td>
                        <td>
                            <code style="font-family:'DM Sans',sans-serif;font-size:11.5px;color:var(--text3);background:var(--surface2);padding:3px 8px;border-radius:5px;border:1px solid var(--border)">{{ $scan->kode_scan }}</code>
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.absensi-gerbang.show', $scan) }}" class="btn btn-sm btn-detail">Detail</a>

                                @if($scan->is_valid && !$scan->hasilKoreksi)
                                <button type="button" class="btn btn-sm btn-warn"
                                        onclick="openKoreksiModal({{ $scan->id }}, '{{ addslashes($scan->siswa?->nama_lengkap ?? '—') }}', '{{ $scan->tipe }}', '{{ $scan->label_tipe }}')">
                                    Koreksi
                                </button>
                                @endif

                                @if(!$scan->hasilKoreksi)
                                <form action="{{ route('admin.absensi-gerbang.destroy', $scan) }}" method="POST"
                                      id="del-{{ $scan->id }}" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                            onclick="confirmHapus({{ $scan->id }}, '{{ addslashes($scan->siswa?->nama_lengkap ?? 'record ini') }}')">
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M8 7h8M8 12h5"/></svg>
                                </div>
                                <p class="empty-title">Belum ada data scan</p>
                                <p class="empty-sub">Coba ubah filter atau tanggal yang dipilih</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- BUG FIX #6: Pagination menggunakan logika ellipsis yang benar agar tidak duplikat --}}
        @if($scanList->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $scanList->firstItem() }}–{{ $scanList->lastItem() }} dari {{ $scanList->total() }} record</p>
            <div class="pag-btns">
                @if($scanList->onFirstPage())
                    <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $scanList->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif

                @php
                    $current  = $scanList->currentPage();
                    $last     = $scanList->lastPage();
                    $showLeft = false;
                    $showRight = false;
                @endphp

                @foreach($scanList->getUrlRange(1, $last) as $page => $url)
                    @php
                        $nearCurrent = abs($page - $current) <= 1;
                        $isEdge      = $page === 1 || $page === $last;
                        $show        = $isEdge || $nearCurrent;
                    @endphp

                    @if($show)
                        @if($page === $current)
                            <span class="pag-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                        @endif
                        @php $showLeft = false; $showRight = false; @endphp
                    @else
                        @if($page < $current && !$showLeft)
                            <span class="pag-ellipsis">…</span>
                            @php $showLeft = true; @endphp
                        @elseif($page > $current && !$showRight)
                            <span class="pag-ellipsis">…</span>
                            @php $showRight = true; @endphp
                        @endif
                    @endif
                @endforeach

                @if($scanList->hasMorePages())
                    <a href="{{ $scanList->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>

{{-- ── Modal Koreksi ────────────────────────────────────────────────────── --}}
<div class="modal-overlay" id="koreksiModal">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Koreksi Tipe Scan</span>
            <button type="button" class="modal-close" onclick="closeKoreksiModal()">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        {{-- BUG FIX #5: action diset via JS menggunakan route() helper yang dirender server-side
             dengan placeholder __ID__ agar tidak hardcode path prefix --}}
        <form method="POST" id="koreksiForm" action="">
            @csrf @method('PATCH')
            <div class="modal-body">
                <div class="info-block" id="koreksiInfo"></div>
                <div class="field">
                    <label>Tipe Baru <span style="color:#dc2626">*</span></label>
                    <select name="tipe_baru" id="koreksiTipeBaru" required>
                        <option value="masuk">Masuk</option>
                        <option value="pulang">Pulang</option>
                    </select>
                </div>
                <div class="field">
                    <label>Catatan (opsional)</label>
                    <textarea name="catatan" placeholder="Alasan koreksi…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeKoreksiModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Koreksi</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    {{-- BUG FIX #7: Gunakan @json() untuk semua nilai yang masuk ke JS agar aman dari XSS
         dan karakter khusus (backtick, quote) pada pesan error --}}
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif
    @if($errors->any())
    Swal.fire({ icon:'warning', title:'Perhatian!', html:@json(implode('<br>', $errors->all())), confirmButtonColor:'#1f63db' });
    @endif

    function toggleDropdown(id) {
        const el = document.getElementById(id);
        const isOpen = el.classList.contains('open');
        document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
        if (!isOpen) el.classList.add('open');
    }
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
    });

    function confirmHapus(id, nama) {
        Swal.fire({
            title: 'Hapus Record Scan?',
            html: `Record scan <strong>${nama}</strong> akan dihapus.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('del-' + id).submit(); });
    }

    function confirmTutupSesi() {
        Swal.fire({
            title: 'Tutup Sesi Gerbang?',
            text: 'Alat scanner tidak akan menerima scan baru setelah sesi ditutup.',
            icon: 'question', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Tutup Sesi', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('formTutupSesi').submit(); });
    }

    {{-- BUG FIX #5: Route koreksi dirender oleh Blade menggunakan placeholder ID
         sehingga prefix route tidak perlu ditulis manual di JS --}}
    const koreksiRouteTemplate = @json(route('admin.absensi-gerbang.koreksi', ['absensiGerbang' => '__ID__']));

    function openKoreksiModal(id, nama, tipe, labelTipe) {
        document.getElementById('koreksiForm').action = koreksiRouteTemplate.replace('__ID__', id);
        document.getElementById('koreksiInfo').innerHTML =
            `Siswa: <strong>${nama}</strong><br>Tipe saat ini: <strong>${labelTipe}</strong>`;
        document.getElementById('koreksiTipeBaru').innerHTML = tipe === 'masuk'
            ? '<option value="pulang">Pulang</option>'
            : '<option value="masuk">Masuk</option>';
        document.getElementById('koreksiModal').classList.add('active');
    }
    function closeKoreksiModal() {
        document.getElementById('koreksiModal').classList.remove('active');
    }
    document.getElementById('koreksiModal').addEventListener('click', function(e) {
        if (e.target === this) closeKoreksiModal();
    });

    @if($sesiAktif)
    (function() {
        const INTERVAL = 8000;

        {{-- BUG FIX #1: lastId diinisialisasi dari max ID sesi aktif (bukan dari scanList
             yang mungkin sudah difilter), sehingga polling tidak menghasilkan duplikat
             meski ada filter kelas/tipe/status yang aktif --}}
        let lastId = {{ $sesiAktif->absensiGerbang()->max('id') ?? 0 }};

        const statusBadgeMap = {
            normal:   'badge-normal',
            duplikat: 'badge-duplikat',
            koreksi:  'badge-koreksi',
            manual:   'badge-manual',
        };

        function buildRow(scan) {
            const siswa = scan.dikenal
                ? `<div class="two-line"><p class="primary">${scan.nama_siswa}</p><p class="secondary">NIS: ${scan.nis}</p></div>`
                : `<div class="two-line"><p class="primary" style="color:var(--text3)">— Tidak Dikenal —</p><p class="secondary">barcode tidak terdaftar</p></div>`;
            const statusClass = statusBadgeMap[scan.status] ?? 'badge-unknown';
            return `<tr class="row-flash" data-id="${scan.id}">
                <td><span class="no-col">${scan.id}</span></td>
                <td style="font-variant-numeric:tabular-nums;white-space:nowrap;font-family:'DM Sans',sans-serif;font-size:13px">${scan.waktu_scan}</td>
                <td>${siswa}</td>
                <td class="muted" style="font-size:12.5px">${scan.kelas}</td>
                <td class="center"><span class="badge badge-${scan.tipe}"><span class="badge-dot"></span>${scan.label_tipe}</span></td>
                <td class="center"><span class="badge ${statusClass}"><span class="badge-dot"></span>${scan.label_status}</span></td>
                <td style="font-size:12.5px">—</td>
                <td><code style="font-family:'DM Sans',sans-serif;font-size:11.5px;color:var(--text3);background:var(--surface2);padding:3px 8px;border-radius:5px;border:1px solid var(--border)">${scan.kode_scan}</code></td>
                <td class="center"><div class="action-group"><a href="/admin/absensi-gerbang/${scan.id}" class="btn btn-sm btn-detail">Detail</a></div></td>
            </tr>`;
        }

        async function poll() {
            try {
                const res  = await fetch(`{{ route('admin.absensi-gerbang.ajax.live') }}?last_id=${lastId}`);
                const data = await res.json();

                if (!data.ada_sesi_aktif) return;

                const ts = document.getElementById('live-timestamp');
                if (ts) ts.textContent = 'update ' + data.timestamp;

                if (data.statistik) {
                    {{-- BUG FIX #1 + #3 + #4: lastId, masuk, dan pulang semua diupdate dari statistik --}}
                    lastId = Math.max(lastId, data.statistik.last_id);

                    const elMasuk  = document.getElementById('stat-masuk');
                    const elPulang = document.getElementById('stat-pulang');
                    const elBanner = document.getElementById('stat-live-masuk');

                    if (elMasuk)  elMasuk.textContent  = data.statistik.total_masuk;
                    if (elPulang) elPulang.textContent  = data.statistik.total_pulang;
                    if (elBanner) elBanner.textContent  = data.statistik.total_masuk;
                }

                if (data.scan_baru && data.scan_baru.length) {
                    const tbody = document.getElementById('scan-tbody');

                    {{-- BUG FIX #2: Cek duplikat sebelum insert —
                         hanya tambahkan baris yang belum ada di DOM --}}
                    const existingIds = new Set(
                        [...tbody.querySelectorAll('tr[data-id]')].map(r => Number(r.dataset.id))
                    );

                    data.scan_baru.forEach(s => {
                        if (!existingIds.has(s.id)) {
                            tbody.insertAdjacentHTML('afterbegin', buildRow(s));
                            existingIds.add(s.id);
                        }
                    });

                    setTimeout(() => {
                        tbody.querySelectorAll('tr.row-flash').forEach(r => r.classList.remove('row-flash'));
                    }, 1000);
                }
            } catch(e) { console.warn('Poll error:', e); }
        }

        setInterval(poll, INTERVAL);
    })();
    @endif
</script>
</x-app-layout>