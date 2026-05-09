<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;--brand-100:#d9ebff;--brand-50:#eef6ff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;}
    *{box-sizing:border-box;}
    .page{padding:28px 28px 48px;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-outline{background:var(--surface);color:var(--text2);border:1px solid var(--border);}
    .btn-outline:hover{background:var(--surface2);filter:none;}
    .btn-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-pdf:hover{background:#fee2e2;filter:none;}
    .btn-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-excel:hover{background:#dcfce7;filter:none;}
    .btn-sm{padding:5px 11px;font-size:11.5px;border-radius:6px;}

    /* Stats */
    .stats-strip{display:grid;grid-template-columns:repeat(6,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:13px 15px;display:flex;align-items:center;gap:10px;}
    .stat-icon{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .stat-note{font-size:10.5px;color:var(--text3);margin-top:2px;font-family:'DM Sans',sans-serif;}

    /* Charts */
    .charts-row{display:grid;grid-template-columns:1fr 300px;gap:16px;margin-bottom:16px;}
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .card-header{padding:12px 18px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between;}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .card-sub{font-size:11.5px;color:var(--text3);}
    .card-body{padding:14px 18px;}
    .chart-wrap{position:relative;height:210px;}

    /* Filter */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;margin-bottom:14px;}
    .filter-grid{display:grid;grid-template-columns:1fr 1fr 1fr 1fr auto auto;gap:10px;align-items:end;}
    .filter-row-2{display:grid;grid-template-columns:140px 140px 1fr 1fr;gap:10px;margin-top:10px;align-items:end;}
    .field{display:flex;flex-direction:column;gap:5px;}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text2);}
    .field input,.field select{height:36px;padding:0 10px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;}
    .field input:focus,.field select:focus{border-color:var(--brand-500);background:#fff;}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;align-self:end;}
    .btn-filter:hover{background:var(--brand-700);}
    .btn-reset{height:36px;padding:0 13px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;align-self:end;}
    .btn-reset:hover{background:var(--surface3);}

    /* Table */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:12px 18px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:8px;}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px;}
    .table-actions{display:flex;gap:7px;}
    .table-wrap{overflow-x:auto;}
    table{width:100%;border-collapse:collapse;font-size:13px;}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    thead th{padding:10px 13px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
    thead th.center{text-align:center;}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:#fafbff;}
    tbody tr.row-manual{background:#fdf4ff;}
    tbody tr.row-manual:hover{background:#fae8ff;}
    tbody tr.row-duplikat{background:#fffbeb;}
    tbody tr.row-duplikat:hover{background:#fef9c3;}
    tbody tr.row-error{background:#fff0f0;}
    td{padding:9px 13px;color:var(--text);vertical-align:middle;}
    td.center{text-align:center;}
    td.muted{color:var(--text3);font-size:12px;}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);}

    /* Badges */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0;}
    .badge-normal  {background:#dcfce7;color:#15803d;} .badge-normal   .badge-dot{background:#15803d;}
    .badge-manual  {background:#f3e8ff;color:#7c3aed;} .badge-manual   .badge-dot{background:#7c3aed;}
    .badge-koreksi {background:#dbeafe;color:#1d4ed8;} .badge-koreksi  .badge-dot{background:#1d4ed8;}
    .badge-duplikat{background:#fef9c3;color:#a16207;} .badge-duplikat .badge-dot{background:#a16207;}
    .badge-error   {background:#fee2e2;color:#dc2626;} .badge-error    .badge-dot{background:#dc2626;}
    .badge-masuk   {background:#dbeafe;color:#1d4ed8;} .badge-masuk    .badge-dot{background:#1d4ed8;}
    .badge-pulang  {background:#ede9fe;color:#6d28d9;} .badge-pulang   .badge-dot{background:#6d28d9;}

    .tag-manual{display:inline-flex;align-items:center;gap:3px;padding:1px 6px;border-radius:4px;font-size:10.5px;font-weight:700;background:#f3e8ff;color:#6d28d9;margin-left:4px;vertical-align:middle;}

    /* Empty */
    .empty-state{padding:50px 20px;text-align:center;}
    .empty-icon{width:52px;height:52px;background:var(--surface2);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--text);margin-bottom:4px;}
    .empty-sub{font-size:13px;color:var(--text3);}

    /* Filter notice */
    .filter-notice{display:flex;align-items:center;gap:8px;padding:8px 14px;background:#fffbeb;border:1px solid #fde68a;border-radius:var(--radius-sm);font-size:12.5px;color:#92400e;margin-bottom:12px;}

    /* Pagination */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:12px 18px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .pag-info{font-size:12px;color:var(--text3);}
    .pag-btns{display:flex;gap:4px;}
    .pag-btn{height:31px;min-width:31px;padding:0 7px;border-radius:6px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none;}
    .pag-btn:hover{background:var(--surface2);}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff;}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 3px;display:flex;align-items:center;}

    @media(max-width:1200px){.stats-strip{grid-template-columns:repeat(3,1fr)};.charts-row{grid-template-columns:1fr}}
    @media(max-width:900px){.filter-grid{grid-template-columns:1fr 1fr};.filter-row-2{grid-template-columns:1fr 1fr};.page{padding:16px}}
    @media(max-width:600px){.stats-strip{grid-template-columns:1fr 1fr}}
</style>

<div class="page">

    {{-- ══ HEADER ══ --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Absensi Gerbang</h1>
            <p class="page-sub">Log scan RFID masuk &amp; pulang dari alat gerbang — filter, rekap, dan ekspor</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.absensi-gerbang.index') }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                Live Monitor
            </a>
        </div>
    </div>

    {{-- ══ FILTER NOTICE ══ --}}
    @if(request()->hasAny(['tanggal_dari','tanggal_sampai','tipe','status','kelas_id','sesi_gerbang_id','search']))
    <div class="filter-notice">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Statistik di bawah dihitung berdasarkan filter yang aktif.
    </div>
    @endif

    {{-- ══ STATS STRIP ══ --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff">
                <svg width="16" height="16" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Scan</p>
                <p class="stat-val">{{ number_format($rekap['total']) }}</p>
                <p class="stat-note">semua status</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#dbeafe">
                <svg width="16" height="16" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
            </div>
            <div>
                <p class="stat-label">Masuk Valid</p>
                <p class="stat-val">{{ number_format($rekap['scan_masuk']) }}</p>
                <p class="stat-note">normal+manual+koreksi</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#ede9fe">
                <svg width="16" height="16" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </div>
            <div>
                <p class="stat-label">Pulang Valid</p>
                <p class="stat-val">{{ number_format($rekap['scan_pulang']) }}</p>
                <p class="stat-note">normal+manual+koreksi</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef9c3">
                <svg width="16" height="16" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div>
                <p class="stat-label">Duplikat</p>
                <p class="stat-val">{{ number_format($rekap['duplikat']) }}</p>
                <p class="stat-note">scan lebih dari sekali</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#f3e8ff">
                <svg width="16" height="16" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div>
                <p class="stat-label">Input Manual</p>
                <p class="stat-val">{{ number_format($rekap['manual']) }}</p>
                <p class="stat-note">diinput oleh admin</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff0f0">
                <svg width="16" height="16" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
                <p class="stat-label">Tdk Dikenal</p>
                <p class="stat-val">{{ number_format($rekap['tidak_dikenal']) }}</p>
                <p class="stat-note">kartu tidak terdaftar</p>
            </div>
        </div>
    </div>

    {{-- ══ CHARTS ══ --}}
    <div class="charts-row">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Tren Scan Gerbang 14 Hari Terakhir</span>
                <span class="card-sub">Masuk vs Pulang (scan valid)</span>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="trendChart"></canvas></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <span class="card-title">Komposisi Status</span>
                <span class="card-sub">Distribusi global</span>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="statusChart"></canvas></div>
            </div>
        </div>
    </div>

    {{-- ══ FILTER ══ --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.laporan.absensi-gerbang') }}">
            <div class="filter-grid">
                <div class="field">
                    <label>Kelas</label>
                    <select name="kelas_id">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}" @selected(request('kelas_id') == $k->id)>
                                {{ $k->tingkat }} {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Tipe Scan</label>
                    <select name="tipe">
                        <option value="">Masuk &amp; Pulang</option>
                        <option value="masuk"  @selected(request('tipe') === 'masuk')>Masuk</option>
                        <option value="pulang" @selected(request('tipe') === 'pulang')>Pulang</option>
                    </select>
                </div>
                <div class="field">
                    <label>Status Scan</label>
                    <select name="status">
                        <option value="">Semua Status</option>
                        <option value="normal"   @selected(request('status') === 'normal')>Normal</option>
                        <option value="manual"   @selected(request('status') === 'manual')>Manual</option>
                        <option value="koreksi"  @selected(request('status') === 'koreksi')>Koreksi</option>
                        <option value="duplikat" @selected(request('status') === 'duplikat')>Duplikat</option>
                        <option value="error"    @selected(request('status') === 'error')>Error</option>
                    </select>
                </div>
                <div class="field">
                    <label>Sesi Gerbang</label>
                    <select name="sesi_gerbang_id">
                        <option value="">Semua Sesi</option>
                        @foreach($sesiList as $sesi)
                            <option value="{{ $sesi->id }}" @selected(request('sesi_gerbang_id') == $sesi->id)>
                                {{ \Carbon\Carbon::parse($sesi->tanggal)->isoFormat('D MMM') }} — {{ $sesi->label_tipe }}
                                @if($sesi->status === 'aktif') 🟢 @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <a href="{{ route('admin.laporan.absensi-gerbang') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Filter</button>
            </div>
            <div class="filter-row-2">
                <div class="field">
                    <label>Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari', now()->toDateString()) }}">
                </div>
                <div class="field">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai', now()->toDateString()) }}">
                </div>
                <div class="field">
                    <label>Cari Nama / NIS / Kode</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama siswa, NIS, atau kode scan...">
                </div>
                <div></div>{{-- spacer --}}
            </div>
        </form>
    </div>

    {{-- ══ TABEL ══ --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Log Scan Gerbang
                @if($scanList->total() > 0)
                    <span>— {{ $scanList->firstItem() }}–{{ $scanList->lastItem() }} dari {{ number_format($scanList->total()) }} record</span>
                @else
                    <span>— Tidak ada data</span>
                @endif
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.laporan.absensi-gerbang.export.pdf', request()->query()) }}"
                   class="btn btn-sm btn-pdf" target="_blank">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.laporan.absensi-gerbang.export.excel', request()->query()) }}"
                   class="btn btn-sm btn-excel">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M3 15h18M9 3v18"/></svg>
                    Export Excel
                </a>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:42px">#</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th class="center">Tipe</th>
                        <th class="center">Status</th>
                        <th>Sesi Gerbang</th>
                        <th>Waktu Scan</th>
                        <th>Input Oleh</th>
                        <th>Kode Scan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($scanList as $i => $scan)
                    @php
                        $rowClass = match($scan->status) {
                            'duplikat' => 'row-duplikat',
                            'error'    => 'row-error',
                            default    => $scan->is_manual ? 'row-manual' : '',
                        };
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td><span class="no-col">{{ $scanList->firstItem() + $i }}</span></td>

                        {{-- Siswa --}}
                        <td>
                            @if($scan->siswa)
                                <p style="font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;line-height:1.3">
                                    {{ $scan->siswa->nama_lengkap }}
                                    @if($scan->is_manual)
                                        <span class="tag-manual">Manual</span>
                                    @endif
                                </p>
                                @if($scan->siswa->nis)
                                    <p style="font-size:11.5px;color:var(--text3)">NIS: {{ $scan->siswa->nis }}</p>
                                @endif
                            @else
                                <p style="font-weight:700;font-size:13px;color:#dc2626">Tidak Dikenal</p>
                                <p style="font-size:11.5px;color:var(--text3)">{{ $scan->kode_scan ?? '—' }}</p>
                            @endif
                        </td>

                        {{-- Kelas --}}
                        <td class="muted">
                            {{ $scan->siswa?->kelas ? $scan->siswa->kelas->tingkat . ' ' . $scan->siswa->kelas->nama_kelas : '—' }}
                        </td>

                        {{-- Tipe --}}
                        <td class="center">
                            <span class="badge badge-{{ $scan->tipe }}">
                                <span class="badge-dot"></span>
                                {{ ucfirst($scan->tipe) }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td class="center">
                            <span class="badge badge-{{ $scan->status }}">
                                <span class="badge-dot"></span>
                                {{ ucfirst($scan->status) }}
                            </span>
                        </td>

                        {{-- Sesi --}}
                        <td>
                            @if($scan->sesiGerbang)
                                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700">
                                    {{ $scan->sesiGerbang->label_tipe }}
                                </p>
                                <p style="font-size:11.5px;color:var(--text3)">
                                    {{ \Carbon\Carbon::parse($scan->sesiGerbang->tanggal)->isoFormat('D MMM Y') }}
                                </p>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>

                        {{-- Waktu scan --}}
                        <td>
                            <span style="font-family:'DM Sans',sans-serif;font-variant-numeric:tabular-nums;font-size:13px;font-weight:600">
                                {{ $scan->waktu_scan->format('H:i:s') }}
                            </span>
                            <p style="font-size:11.5px;color:var(--text3)">{{ $scan->waktu_scan->format('d/m/Y') }}</p>
                        </td>

                        {{-- Input oleh --}}
                        <td class="muted" style="font-size:12px">
                            {{ $scan->inputOleh?->name ?? 'Sistem' }}
                        </td>

                        {{-- Kode scan --}}
                        <td>
                            <code style="font-size:11.5px;background:var(--surface2);padding:2px 6px;border-radius:4px;border:1px solid var(--border);color:var(--text2)">
                                {{ Str::limit($scan->kode_scan, 16) ?? '—' }}
                            </code>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                                </div>
                                <p class="empty-title">Tidak ada data scan gerbang</p>
                                <p class="empty-sub">Coba ubah rentang tanggal atau reset filter</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($scanList->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $scanList->firstItem() }}–{{ $scanList->lastItem() }} dari {{ number_format($scanList->total()) }} data</p>
            <div class="pag-btns">
                @if($scanList->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $scanList->previousPageUrl() }}" class="pag-btn"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif

                @foreach($scanList->getUrlRange(1, $scanList->lastPage()) as $page => $url)
                    @if($page == $scanList->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $scanList->lastPage() || abs($page - $scanList->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $scanList->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                @if($scanList->hasMorePages())
                    <a href="{{ $scanList->nextPageUrl() }}" class="pag-btn"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif

    Chart.defaults.font.family = "'DM Sans', sans-serif";
    Chart.defaults.color = '#94a3b8';

    // Tren 14 hari — Masuk vs Pulang
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: @json($trendLabels ?? []),
            datasets: [
                {
                    label: 'Masuk',
                    data: @json($trendMasuk ?? []),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,.1)',
                    tension: .4,
                    fill: true,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                },
                {
                    label: 'Pulang',
                    data: @json($trendPulang ?? []),
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139,92,246,.07)',
                    tension: .4,
                    fill: true,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                },
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: { boxWidth: 10, font: { family:"'Plus Jakarta Sans'", weight:'700', size:11 } }
                },
                tooltip: { callbacks: { label: ctx => ` ${ctx.dataset.label}: ${ctx.raw} scan` } }
            },
            scales: {
                y: { beginAtZero: true, grid: { color:'#f1f5f9' }, ticks: { stepSize:1 } },
                x: { grid: { display:false } }
            }
        }
    });

    // Komposisi status
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Normal', 'Manual', 'Koreksi', 'Duplikat', 'Error'],
            datasets: [{
                data: [
                    {{ $statusCount['normal']   ?? 0 }},
                    {{ $statusCount['manual']   ?? 0 }},
                    {{ $statusCount['koreksi']  ?? 0 }},
                    {{ $statusCount['duplikat'] ?? 0 }},
                    {{ $statusCount['error']    ?? 0 }},
                ],
                backgroundColor: ['#22c55e', '#a855f7', '#3b82f6', '#f59e0b', '#ef4444'],
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    display: true, position: 'right',
                    labels: { boxWidth: 10, padding: 8, font: { family:"'Plus Jakarta Sans'", weight:'700', size:11 } }
                },
                tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.raw}` } }
            }
        }
    });
</script>
</x-app-layout>