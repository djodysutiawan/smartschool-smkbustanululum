<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand-700: #1750c0;
        --brand-600: #1f63db;
        --brand-500: #3582f0;
        --brand-100: #d9ebff;
        --brand-50:  #eef6ff;
        --surface:   #fff;
        --surface2:  #f8fafc;
        --surface3:  #f1f5f9;
        --border:    #e2e8f0;
        --border2:   #cbd5e1;
        --text:      #0f172a;
        --text2:     #475569;
        --text3:     #94a3b8;
        --radius:    10px;
        --radius-sm: 7px;
    }

    .page { padding: 28px 28px 40px; }
    .page-header { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:24px; flex-wrap:wrap; }
    .page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:20px; font-weight:800; color:var(--text); line-height:1.2; }
    .page-sub { font-size:12.5px; color:var(--text3); margin-top:3px; }
    .header-actions { display:flex; gap:8px; flex-wrap:wrap; }

    .btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; border:none; text-decoration:none; transition:filter .15s; white-space:nowrap; }
    .btn:hover { filter:brightness(.93); }
    .btn-primary { background:var(--brand-600); color:#fff; }
    .btn-sm { padding:6px 12px; font-size:12px; border-radius:6px; }
    .btn-edit { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
    .btn-edit:hover { background:var(--brand-100); filter:none; }
    .btn-del { background:#fff0f0; color:#dc2626; border:1px solid #fecaca; }
    .btn-del:hover { background:#fee2e2; filter:none; }
    .btn-detail { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
    .btn-detail:hover { background:#dcfce7; filter:none; }

    .stats-strip { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:20px; }
    .stat-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:14px 18px; display:flex; align-items:center; gap:12px; }
    .stat-icon { width:38px; height:38px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .stat-icon.blue   { background:var(--brand-50); }
    .stat-icon.green  { background:#f0fdf4; }
    .stat-icon.yellow { background:#fefce8; }
    .stat-icon.red    { background:#fff0f0; }
    .stat-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:600; color:var(--text3); letter-spacing:.03em; text-transform:uppercase; }
    .stat-val { font-family:'Plus Jakarta Sans',sans-serif; font-size:22px; font-weight:800; color:var(--text); line-height:1.1; margin-top:1px; }

    .filter-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:16px 20px; margin-bottom:16px; }
    .filter-row { display:flex; flex-wrap:wrap; gap:10px; align-items:center; }
    .filter-row input, .filter-row select { height:36px; padding:0 12px; border:1px solid var(--border); border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:13px; color:var(--text); background:var(--surface2); outline:none; transition:border-color .15s; }
    .filter-row input { width:210px; }
    .filter-row input:focus, .filter-row select:focus { border-color:var(--brand-500); background:#fff; }
    .filter-row input::placeholder { color:var(--text3); }
    .filter-sep { flex:1; }
    .btn-filter { height:36px; padding:0 18px; background:var(--brand-600); color:#fff; border:none; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; }
    .btn-filter:hover { background:var(--brand-700); }
    .btn-reset { height:36px; padding:0 14px; background:var(--surface2); color:var(--text2); border:1px solid var(--border); border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; }
    .btn-reset:hover { background:var(--surface3); }

    .table-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; }
    .table-topbar { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-bottom:1px solid var(--border); gap:12px; flex-wrap:wrap; }
    .table-info { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; color:var(--text); }
    .table-info span { font-weight:400; color:var(--text3); margin-left:6px; }
    .table-actions { display:flex; gap:8px; align-items:center; flex-wrap:wrap; }
    .table-wrap { overflow-x:auto; }

    .btn-export-pdf   { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; cursor:pointer; text-decoration:none; background:#fff0f0; color:#dc2626; border:1px solid #fecaca; transition:background .15s; }
    .btn-export-pdf:hover { background:#fee2e2; }
    .btn-export-excel { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; cursor:pointer; text-decoration:none; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; transition:background .15s; }
    .btn-export-excel:hover { background:#dcfce7; }
    .btn-import       { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; cursor:pointer; text-decoration:none; background:#fefce8; color:#92400e; border:1px solid #fde68a; transition:background .15s; }
    .btn-import:hover { background:#fef3c7; }

    table { width:100%; border-collapse:collapse; font-size:13.5px; }
    thead tr { background:var(--surface2); border-bottom:1px solid var(--border); }
    thead th { padding:11px 14px; text-align:left; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; color:var(--text3); letter-spacing:.05em; text-transform:uppercase; white-space:nowrap; }
    thead th.center { text-align:center; }
    tbody tr { border-bottom:1px solid #f1f5f9; transition:background .1s; }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:#fafbff; }
    td { padding:10px 14px; color:var(--text); vertical-align:middle; }
    td.center { text-align:center; }
    td.muted { color:var(--text3); }
    .no-col { font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; color:var(--text3); }
    .kode-pill { font-family:'DM Sans',sans-serif; font-size:12px; font-weight:600; background:var(--surface3); color:var(--text2); padding:2px 8px; border-radius:5px; }

    .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:99px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; white-space:nowrap; }
    .badge-dot { width:5px; height:5px; border-radius:50%; }
    .badge-tersedia     { background:#dcfce7; color:#15803d; } .badge-tersedia .badge-dot     { background:#15803d; }
    .badge-tidak_tersedia { background:#fef3c7; color:#92400e; } .badge-tidak_tersedia .badge-dot { background:#d97706; }
    .badge-perbaikan    { background:#fee2e2; color:#dc2626; } .badge-perbaikan .badge-dot    { background:#dc2626; }

    .jenis-pill { display:inline-block; padding:2px 9px; border-radius:5px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; white-space:nowrap; }
    .jenis-kelas                 { background:#eef2ff; color:#4338ca; border:1px solid #c7d2fe; }
    .jenis-laboratorium_komputer { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
    .jenis-laboratorium_ipa      { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
    .jenis-laboratorium_bahasa   { background:#fdf4ff; color:#7c3aed; border:1px solid #e9d5ff; }
    .jenis-aula                  { background:#fff7ed; color:#c2410c; border:1px solid #fed7aa; }
    .jenis-perpustakaan          { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
    .jenis-ruang_praktik         { background:#fefce8; color:#92400e; border:1px solid #fde68a; }
    .jenis-lainnya               { background:var(--surface3); color:var(--text2); border:1px solid var(--border2); }

    .fasilitas-icons { display:flex; gap:5px; flex-wrap:wrap; }
    .fas-icon { display:inline-flex; align-items:center; justify-content:center; width:22px; height:22px; border-radius:5px; background:var(--surface3); }
    .fas-icon.on { background:var(--brand-50); }
    .fas-icon.on svg { stroke:#1f63db; }
    .fas-icon svg { stroke:var(--border2); }

    .action-group { display:flex; align-items:center; gap:5px; justify-content:center; flex-wrap:wrap; }

    .empty-state { padding:60px 20px; text-align:center; }
    .empty-icon { width:56px; height:56px; background:var(--surface2); border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }
    .empty-title { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:15px; color:var(--text); margin-bottom:5px; }
    .empty-sub { font-size:13px; color:var(--text3); }

    .pag-wrap { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-top:1px solid var(--border); flex-wrap:wrap; gap:10px; }
    .pag-info { font-size:12.5px; color:var(--text3); }
    .pag-btns { display:flex; gap:4px; align-items:center; }
    .pag-btn { height:32px; min-width:32px; padding:0 8px; border-radius:7px; display:flex; align-items:center; justify-content:center; border:1px solid var(--border); background:var(--surface); color:var(--text2); font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; cursor:pointer; transition:all .15s; text-decoration:none; }
    .pag-btn:hover { background:var(--surface2); border-color:var(--border2); }
    .pag-btn.active { background:var(--brand-600); border-color:var(--brand-600); color:#fff; }
    .pag-ellipsis { color:var(--text3); font-size:13px; padding:0 4px; }

    .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:1000; align-items:center; justify-content:center; }
    .modal-overlay.open { display:flex; }
    .modal-box { background:#fff; border-radius:12px; padding:28px; width:100%; max-width:420px; box-shadow:0 20px 60px rgba(0,0,0,.2); }
    .modal-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:16px; font-weight:800; color:var(--text); margin-bottom:16px; }
    .modal-field { display:flex; flex-direction:column; gap:6px; margin-bottom:16px; }
    .modal-field label { font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; color:var(--text2); }
    .modal-field input[type="file"] { border:1.5px dashed var(--border2); border-radius:var(--radius-sm); padding:10px 12px; font-size:13px; background:var(--surface2); cursor:pointer; }
    .modal-hint { font-size:12px; color:var(--text3); }
    .modal-footer { display:flex; gap:10px; justify-content:flex-end; }
    .btn-modal-cancel { padding:8px 18px; background:var(--surface2); color:var(--text2); border:1px solid var(--border); border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; }
    .btn-modal-submit { padding:8px 18px; background:var(--brand-600); color:#fff; border:none; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; }

    @media (max-width:640px) {
        .stats-strip { grid-template-columns:1fr 1fr; }
        .page { padding:16px; }
        .filter-row input { width:100%; }
    }
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Ruang</h1>
            <p class="page-sub">Kelola data ruangan per gedung — tambah, edit, dan hapus</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.ruang.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Ruang
            </a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Ruang</p>
                <p class="stat-val">{{ $ruang->total() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Tersedia</p>
                <p class="stat-val">{{ \App\Models\Ruang::where('status','tersedia')->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
                <p class="stat-label">Tidak Tersedia</p>
                <p class="stat-val">{{ \App\Models\Ruang::where('status','tidak_tersedia')->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
            </div>
            <div>
                <p class="stat-label">Perbaikan</p>
                <p class="stat-val">{{ \App\Models\Ruang::where('status','perbaikan')->count() }}</p>
            </div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.ruang.index') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau kode ruang...">
                <select name="gedung_id">
                    <option value="">Semua Gedung</option>
                    @foreach($gedungs as $g)
                        <option value="{{ $g->id }}" {{ request('gedung_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_gedung }}</option>
                    @endforeach
                </select>
                <select name="jenis_ruang">
                    <option value="">Semua Jenis</option>
                    @foreach(['kelas','laboratorium_komputer','laboratorium_ipa','laboratorium_bahasa','aula','perpustakaan','ruang_praktik','lainnya'] as $j)
                        <option value="{{ $j }}" {{ request('jenis_ruang') == $j ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$j)) }}</option>
                    @endforeach
                </select>
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="tersedia"      {{ request('status')=='tersedia'      ? 'selected' : '' }}>Tersedia</option>
                    <option value="tidak_tersedia"{{ request('status')=='tidak_tersedia'? 'selected' : '' }}>Tidak Tersedia</option>
                    <option value="perbaikan"     {{ request('status')=='perbaikan'     ? 'selected' : '' }}>Perbaikan</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.ruang.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Ruang
                <span>— menampilkan {{ $ruang->firstItem() }}–{{ $ruang->lastItem() }} dari {{ $ruang->total() }} data</span>
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.ruang.export.pdf', request()->query()) }}" class="btn-export-pdf">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    PDF
                </a>
                <a href="{{ route('admin.ruang.export.excel', request()->query()) }}" class="btn-export-excel">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Excel
                </a>
                <button type="button" class="btn-import" onclick="document.getElementById('importModal').classList.add('open')">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                    Import
                </button>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Kode</th>
                        <th>Nama Ruang</th>
                        <th>Gedung</th>
                        <th>Jenis</th>
                        <th class="center">Lantai</th>
                        <th class="center">Kapasitas</th>
                        <th class="center">Fasilitas</th>
                        <th>Status</th>
                        <th class="center" style="width:180px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ruang as $index => $r)
                    <tr>
                        <td><span class="no-col">{{ $ruang->firstItem() + $index }}</span></td>
                        <td><span class="kode-pill">{{ $r->kode_ruang }}</span></td>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:13.5px">{{ $r->nama_ruang }}</td>
                        <td class="muted" style="font-size:12.5px">{{ $r->gedung->nama_gedung ?? '-' }}</td>
                        <td>
                            <span class="jenis-pill jenis-{{ $r->jenis_ruang }}">{{ ucfirst(str_replace('_',' ',$r->jenis_ruang)) }}</span>
                        </td>
                        <td class="center muted">{{ $r->lantai }}</td>
                        <td class="center" style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700">{{ $r->kapasitas }}</td>
                        <td class="center">
                            <div class="fasilitas-icons">
                                <span class="fas-icon {{ $r->ada_proyektor ? 'on' : '' }}" title="Proyektor">
                                    <svg width="12" height="12" fill="none" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="13" rx="2"/><path d="M12 3v4M8 3h8"/></svg>
                                </span>
                                <span class="fas-icon {{ $r->ada_ac ? 'on' : '' }}" title="AC">
                                    <svg width="12" height="12" fill="none" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v20M2 12h20M4.93 4.93l14.14 14.14M19.07 4.93 4.93 19.07"/></svg>
                                </span>
                                <span class="fas-icon {{ $r->ada_wifi ? 'on' : '' }}" title="WiFi">
                                    <svg width="12" height="12" fill="none" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12.55a11 11 0 0 1 14.08 0M1.42 9a16 16 0 0 1 21.16 0M8.53 16.11a6 6 0 0 1 6.95 0"/><circle cx="12" cy="20" r="1" fill="currentColor"/></svg>
                                </span>
                                <span class="fas-icon {{ $r->ada_komputer ? 'on' : '' }}" title="Komputer">
                                    <svg width="12" height="12" fill="none" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                                </span>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-{{ $r->status }}">
                                <span class="badge-dot"></span>{{ ucfirst(str_replace('_',' ',$r->status)) }}
                            </span>
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.ruang.show', $r->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('admin.ruang.edit', $r->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('admin.ruang.destroy', $r->id) }}" method="POST" id="delForm-{{ $r->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delForm-{{ $r->id }}'), '{{ addslashes($r->nama_ruang) }}')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                                </div>
                                <p class="empty-title">Ruang tidak ditemukan</p>
                                <p class="empty-sub">Coba ubah filter atau tambah ruang baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($ruang->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $ruang->firstItem() }} – {{ $ruang->lastItem() }} dari {{ $ruang->total() }} ruang</p>
            <div class="pag-btns">
                @if($ruang->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $ruang->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($ruang->getUrlRange(1, $ruang->lastPage()) as $page => $url)
                    @if($page == $ruang->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $ruang->lastPage() || abs($page - $ruang->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $ruang->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($ruang->hasMorePages())
                    <a href="{{ $ruang->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<div class="modal-overlay" id="importModal">
    <div class="modal-box">
        <p class="modal-title">Import Data Ruang</p>
        <form action="{{ route('admin.ruang.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-field">
                <label>File Excel / CSV <span style="color:#1f63db">*</span></label>
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required>
                <span class="modal-hint">Format: .xlsx, .xls, atau .csv. Maks 2 MB.</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="document.getElementById('importModal').classList.remove('open')">Batal</button>
                <button type="submit" class="btn-modal-submit">Upload & Import</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif

    function confirmDelete(form, nama) {
        Swal.fire({
            title: 'Hapus Ruang?',
            text: `Ruang "${nama}" akan dihapus secara permanen.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }

    document.getElementById('importModal').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });
</script>
</x-app-layout>