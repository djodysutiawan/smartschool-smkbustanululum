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

    /* ── Buttons ── */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-detail:hover{background:#dcfce7;filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}
    .btn-warn{background:#fffbeb;color:#a16207;border:1px solid #fde68a}
    .btn-warn:hover{background:#fef9c3;filter:none}
    .btn-purple{background:#faf5ff;color:#7c3aed;border:1px solid #e9d5ff}
    .btn-purple:hover{background:#f3e8ff;filter:none}

    /* ── Dropdown ── */
    .dropdown{position:relative;display:inline-flex}
    .dropdown-menu{display:none;position:absolute;top:calc(100% + 6px);right:0;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);box-shadow:0 8px 28px rgba(0,0,0,.1);min-width:190px;z-index:200;overflow:hidden}
    .dropdown.open .dropdown-menu{display:block}
    .dropdown-item{display:flex;align-items:center;gap:8px;padding:9px 14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text2);text-decoration:none;background:none;border:none;width:100%;cursor:pointer;transition:background .12s;text-align:left}
    .dropdown-item:hover{background:var(--surface2);color:var(--text)}
    .dropdown-divider{border:none;border-top:1px solid var(--border);margin:4px 0}
    .dropdown-section-label{padding:6px 14px 3px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:700;color:var(--text3);letter-spacing:.06em;text-transform:uppercase}

    /* ── Active session banner ── */
    .sesi-banner{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:14px 20px;border-radius:var(--radius);border:1px solid #6ee7b7;background:linear-gradient(135deg,#ecfdf5,#d1fae5);margin-bottom:20px;flex-wrap:wrap}
    .sesi-banner-left{display:flex;align-items:center;gap:12px}
    .sesi-banner-right{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
    .sesi-banner-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:#065f46}
    .sesi-banner-meta{font-size:12px;color:#059669;margin-top:2px}
    .live-dot{display:inline-block;width:8px;height:8px;border-radius:50%;background:#22c55e;flex-shrink:0;animation:pulse-live 1.4s ease-in-out infinite}
    @keyframes pulse-live{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.45;transform:scale(1.5)}}

    /* ── Stats strip ── */
    .stats-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.green{background:#f0fdf4}
    .stat-icon.blue{background:#eff6ff}
    .stat-icon.orange{background:#fff7ed}
    .stat-icon.purple{background:#faf5ff}
    .stat-icon.gray{background:var(--surface2)}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    /* ── Filter ── */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select,.filter-row input[type=date]{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row input[type=date]{width:148px}
    .filter-row select:focus,.filter-row input:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s}
    .btn-filter:hover{background:var(--brand-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:background .15s}
    .btn-reset:hover{background:var(--surface3)}

    /* ── Table ── */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:8px}
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
    tbody tr.row-aktif{background:#f0fdf4}
    tbody tr.row-aktif:hover{background:#dcfce7}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    td.muted{color:var(--text3)}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}

    /* ── Badges ── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-aktif   {background:#dcfce7;color:#15803d}  .badge-aktif    .badge-dot{background:#15803d}
    .badge-ditutup {background:#f1f5f9;color:#475569}  .badge-ditutup  .badge-dot{background:#94a3b8}
    .badge-masuk   {background:#dbeafe;color:#1d4ed8}  .badge-masuk    .badge-dot{background:#1d4ed8}
    .badge-pulang  {background:#ede9fe;color:#6d28d9}  .badge-pulang   .badge-dot{background:#6d28d9}

    /* ── Two-line cell ── */
    .two-line .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .two-line .secondary{font-size:12px;color:var(--text3);margin-top:1px}

    /* ── Scan bar (mini progress) ── */
    .scan-bar-wrap{display:flex;align-items:center;gap:8px}
    .scan-bar-bg{flex:1;max-width:80px;height:5px;background:var(--surface3);border-radius:99px;overflow:hidden}
    .scan-bar-fill{height:100%;border-radius:99px;background:var(--brand-500);transition:width .3s}
    .scan-bar-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text);min-width:28px}

    /* ── Duration chip ── */
    .duration-chip{display:inline-flex;align-items:center;gap:5px;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text2);background:var(--surface2);border:1px solid var(--border);padding:3px 9px;border-radius:6px}

    /* ── Action group ── */
    .action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap}

    /* ── Empty state ── */
    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    /* ── Pagination ── */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px;align-items:center}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2);border-color:var(--border2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}

    @media(max-width:1100px){.stats-strip{grid-template-columns:repeat(3,1fr)}}
    @media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr};.page{padding:16px};.header-actions{width:100%}}
</style>

<div class="page">

    {{-- ── Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Sesi Gerbang</h1>
            <p class="page-sub">Kelola sesi buka &amp; tutup gerbang untuk scanner absensi</p>
        </div>
        <div class="header-actions">

            <a href="{{ route('admin.sesi-gerbang.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buka Sesi Baru
            </a>

            <div class="dropdown" id="exportDropdown">
                <button type="button" class="btn btn-secondary" onclick="toggleDropdown('exportDropdown')">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="dropdown-menu">
                    <div class="dropdown-section-label">Daftar Sesi</div>
                    <a href="{{ route('admin.sesi-gerbang.export.pdf', request()->query()) }}" class="dropdown-item">
                        <svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Export PDF
                    </a>
                    <a href="{{ route('admin.sesi-gerbang.export.excel', request()->query()) }}" class="dropdown-item">
                        <svg width="14" height="14" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Export Excel
                    </a>
                </div>
            </div>

            <a href="{{ route('admin.absensi-gerbang.index') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                Log Absensi
            </a>

        </div>
    </div>

    {{-- ── Sesi Aktif Banner ── --}}
    @if($sesiAktif)
    <div class="sesi-banner">
        <div class="sesi-banner-left">
            <span class="live-dot"></span>
            <div>
                <p class="sesi-banner-title">Sesi {{ $sesiAktif->label_tipe }} sedang aktif sekarang</p>
                <p class="sesi-banner-meta">
                    Dibuka pukul {{ $sesiAktif->dibuka_pada->format('H:i') }}
                    &middot; oleh {{ $sesiAktif->dibukaOleh->name }}
                    &middot; {{ $sesiAktif->absensiGerbang()->whereIn('status', ['normal','manual','koreksi'])->count() }} scan valid
                </p>
            </div>
        </div>
        <div class="sesi-banner-right">
            <a href="{{ route('admin.sesi-gerbang.show', $sesiAktif) }}" class="btn btn-sm btn-detail">Lihat Detail</a>
            <form method="POST" action="{{ route('admin.sesi-gerbang.tutup', $sesiAktif) }}" id="formTutupBanner" style="display:inline">
                @csrf @method('PATCH')
                <button type="button" class="btn btn-sm btn-del" onclick="confirmTutup({{ $sesiAktif->id }}, '{{ addslashes($sesiAktif->label_tipe) }}', 'formTutupBanner')">Tutup Sesi</button>
            </form>
        </div>
    </div>
    @endif

    {{-- ── Stats Strip ── --}}
    @php
        $totalSesi    = $sesiList->total();
        $totalAktif   = \App\Models\SesiGerbang::where('status','aktif')->count();
        $totalDitutup = \App\Models\SesiGerbang::where('status','ditutup')->count();
        $totalMasuk   = \App\Models\SesiGerbang::where('tipe','masuk')->count();
        $totalPulang  = \App\Models\SesiGerbang::where('tipe','pulang')->count();
    @endphp
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Sesi</p>
                <p class="stat-val">{{ $totalSesi }}</p>
                <p class="stat-sub">semua waktu</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Sedang Aktif</p>
                <p class="stat-val">{{ $totalAktif }}</p>
                <p class="stat-sub">sesi berjalan</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon gray">
                <svg width="18" height="18" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="9" y1="9" x2="15" y2="15"/><line x1="15" y1="9" x2="9" y2="15"/></svg>
            </div>
            <div>
                <p class="stat-label">Ditutup</p>
                <p class="stat-val">{{ $totalDitutup }}</p>
                <p class="stat-sub">sesi selesai</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
            </div>
            <div>
                <p class="stat-label">Sesi Masuk</p>
                <p class="stat-val">{{ $totalMasuk }}</p>
                <p class="stat-sub">pagi / masuk</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </div>
            <div>
                <p class="stat-label">Sesi Pulang</p>
                <p class="stat-val">{{ $totalPulang }}</p>
                <p class="stat-sub">sore / pulang</p>
            </div>
        </div>
    </div>

    {{-- ── Filter ── --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.sesi-gerbang.index') }}">
            <div class="filter-row">
                <input type="date" name="tanggal_dari"   value="{{ request('tanggal_dari') }}"   placeholder="Dari tanggal">
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" placeholder="Sampai tanggal">
                <select name="tipe" onchange="this.form.submit()">
                    <option value="">Semua Tipe</option>
                    <option value="masuk"  @selected(request('tipe') === 'masuk')>Masuk</option>
                    <option value="pulang" @selected(request('tipe') === 'pulang')>Pulang</option>
                </select>
                <select name="status" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="aktif"   @selected(request('status') === 'aktif')>Aktif</option>
                    <option value="ditutup" @selected(request('status') === 'ditutup')>Ditutup</option>
                </select>
                <div class="filter-sep"></div>
                @if(request()->hasAny(['tanggal_dari','tanggal_sampai','tipe','status']))
                    <a href="{{ route('admin.sesi-gerbang.index') }}" class="btn-reset">Reset</a>
                @endif
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- ── Table ── --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Sesi
                @if($sesiList->total() > 0)
                    <span>— menampilkan {{ $sesiList->firstItem() }}–{{ $sesiList->lastItem() }} dari {{ $sesiList->total() }} sesi</span>
                @else
                    <span>— tidak ada data</span>
                @endif
            </p>
            <a href="{{ route('admin.sesi-gerbang.create') }}" class="btn btn-sm btn-primary">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buka Sesi
            </a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Tanggal</th>
                        <th class="center">Tipe</th>
                        <th class="center">Status</th>
                        <th>Dibuka Pukul</th>
                        <th>Ditutup Pukul</th>
                        <th>Durasi</th>
                        <th>Dibuka Oleh</th>
                        <th class="center">Jumlah Scan</th>
                        <th class="center" style="width:200px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sesiList as $index => $sesi)
                    <tr class="{{ $sesi->status === 'aktif' ? 'row-aktif' : '' }}" data-id="{{ $sesi->id }}">
                        <td><span class="no-col">{{ $sesiList->firstItem() + $index }}</span></td>

                        {{-- Tanggal --}}
                        <td>
                            <div class="two-line">
                                <p class="primary">{{ \Carbon\Carbon::parse($sesi->tanggal)->isoFormat('D MMM Y') }}</p>
                                <p class="secondary">{{ \Carbon\Carbon::parse($sesi->tanggal)->isoFormat('dddd') }}</p>
                            </div>
                        </td>

                        {{-- Tipe --}}
                        <td class="center">
                            <span class="badge badge-{{ $sesi->tipe }}">
                                <span class="badge-dot"></span>
                                {{ $sesi->label_tipe }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td class="center">
                            <span class="badge badge-{{ $sesi->status }}">
                                @if($sesi->status === 'aktif')
                                    <span class="live-dot" style="width:5px;height:5px;margin-right:2px"></span>
                                @else
                                    <span class="badge-dot"></span>
                                @endif
                                {{ ucfirst($sesi->status) }}
                            </span>
                        </td>

                        {{-- Dibuka Pukul --}}
                        <td>
                            <div class="two-line">
                                <p class="primary" style="font-family:'DM Sans',sans-serif;font-variant-numeric:tabular-nums">
                                    {{ $sesi->dibuka_pada->format('H:i') }}
                                </p>
                                <p class="secondary">{{ $sesi->dibuka_pada->format('d/m/Y') }}</p>
                            </div>
                        </td>

                        {{-- Ditutup Pukul --}}
                        <td>
                            @if($sesi->ditutup_pada)
                            <div class="two-line">
                                <p class="primary" style="font-family:'DM Sans',sans-serif;font-variant-numeric:tabular-nums">
                                    {{ $sesi->ditutup_pada->format('H:i') }}
                                </p>
                                <p class="secondary">{{ $sesi->ditutup_pada->format('d/m/Y') }}</p>
                            </div>
                            @else
                            <span class="muted" style="font-size:12.5px">— Belum ditutup</span>
                            @endif
                        </td>

                        {{-- Durasi --}}
                        <td>
                            @if($sesi->ditutup_pada)
                                @php
                                    $menit = $sesi->dibuka_pada->diffInMinutes($sesi->ditutup_pada);
                                    $jam   = intdiv($menit, 60);
                                    $sisa  = $menit % 60;
                                @endphp
                                <span class="duration-chip">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    {{ $jam > 0 ? $jam.'j ' : '' }}{{ $sisa }}m
                                </span>
                            @elseif($sesi->status === 'aktif')
                                <span class="duration-chip" style="border-color:#6ee7b7;color:#059669;background:#ecfdf5">
                                    <span class="live-dot" style="width:5px;height:5px"></span>
                                    Sedang berjalan
                                </span>
                            @else
                                <span class="muted" style="font-size:12.5px">—</span>
                            @endif
                        </td>

                        {{-- Dibuka Oleh --}}
                        <td>
                            <div class="two-line">
                                <p class="primary" style="font-size:13px">{{ $sesi->dibukaOleh?->name ?? '—' }}</p>
                                @if($sesi->ditutupOleh && $sesi->ditutupOleh->id !== $sesi->dibukaOleh?->id)
                                <p class="secondary">Ditutup: {{ $sesi->ditutupOleh->name }}</p>
                                @endif
                            </div>
                        </td>

                        {{-- Jumlah Scan --}}
                        <td class="center">
                            @php $maxScan = $sesiList->max('jumlah_scan') ?: 1; @endphp
                            <div class="scan-bar-wrap" style="justify-content:center">
                                <div class="scan-bar-bg">
                                    <div class="scan-bar-fill" style="width:{{ min(100, round(($sesi->jumlah_scan / $maxScan) * 100)) }}%"></div>
                                </div>
                                <span class="scan-bar-val">{{ $sesi->jumlah_scan }}</span>
                            </div>
                        </td>

                        {{-- Aksi --}}
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.sesi-gerbang.show', $sesi) }}" class="btn btn-sm btn-detail">Detail</a>

                                @if($sesi->status === 'aktif')
                                <form method="POST" action="{{ route('admin.sesi-gerbang.tutup', $sesi) }}"
                                      id="tutup-{{ $sesi->id }}" style="display:inline">
                                    @csrf @method('PATCH')
                                    <button type="button" class="btn btn-sm btn-warn"
                                            onclick="confirmTutup({{ $sesi->id }}, '{{ addslashes($sesi->label_tipe) }}', 'tutup-{{ $sesi->id }}')">
                                        Tutup
                                    </button>
                                </form>
                                @endif

                                @if(!$sesi->absensiGerbang()->exists())
                                <form action="{{ route('admin.sesi-gerbang.destroy', $sesi) }}" method="POST"
                                      id="del-{{ $sesi->id }}" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                            onclick="confirmHapus({{ $sesi->id }}, '{{ addslashes($sesi->label_tipe) }}', '{{ \Carbon\Carbon::parse($sesi->tanggal)->isoFormat('D MMM Y') }}')">
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                </div>
                                <p class="empty-title">Belum ada sesi gerbang</p>
                                <p class="empty-sub">Buka sesi baru untuk mulai menerima scan dari alat</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($sesiList->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $sesiList->firstItem() }}–{{ $sesiList->lastItem() }} dari {{ $sesiList->total() }} sesi</p>
            <div class="pag-btns">
                @if($sesiList->onFirstPage())
                    <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $sesiList->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif

                @php
                    $current   = $sesiList->currentPage();
                    $last      = $sesiList->lastPage();
                    $showLeft  = false;
                    $showRight = false;
                @endphp

                @foreach($sesiList->getUrlRange(1, $last) as $page => $url)
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

                @if($sesiList->hasMorePages())
                    <a href="{{ $sesiList->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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

    function confirmTutup(id, label, formId) {
        Swal.fire({
            title: 'Tutup Sesi ' + label + '?',
            text: 'Alat scanner tidak akan menerima scan baru setelah sesi ini ditutup.',
            icon: 'question', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Tutup Sesi', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById(formId).submit(); });
    }

    function confirmHapus(id, label, tanggal) {
        Swal.fire({
            title: 'Hapus Sesi?',
            html: `Sesi <strong>${label}</strong> tanggal <strong>${tanggal}</strong> akan dihapus permanen.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('del-' + id).submit(); });
    }

    {{-- Live-refresh jumlah scan di baris sesi aktif setiap 10 detik --}}
    @if($sesiAktif)
    (function () {
        setInterval(async function () {
            try {
                const res  = await fetch('{{ route('admin.sesi-gerbang.ajax.aktif') }}');
                const data = await res.json();
                if (!data.ada_sesi_aktif) return;

                data.sesi.forEach(function (s) {
                    const row = document.querySelector(`tr[data-id="${s.id}"]`);
                    if (!row) return;
                    const valEl = row.querySelector('.scan-bar-val');
                    if (valEl) valEl.textContent = s.jumlah_scan;
                });
            } catch (e) { /* silent */ }
        }, 10000);
    })();
    @endif
</script>
</x-app-layout>