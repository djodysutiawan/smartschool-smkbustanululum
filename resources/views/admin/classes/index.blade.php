<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success', title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500, showConfirmButton: false,
            toast: true, position: 'top-end',
        });
    @endif
</script>

<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand:      #1f63db;
        --brand-h:    #3582f0;
        --brand-50:   #eef6ff;
        --brand-100:  #d9ebff;
        --brand-700:  #1750c0;
        --surface:    #fff;
        --surface2:   #f8fafc;
        --surface3:   #f1f5f9;
        --border:     #e2e8f0;
        --border2:    #cbd5e1;
        --text:       #0f172a;
        --text2:      #475569;
        --text3:      #94a3b8;
        --radius:     10px;
        --radius-sm:  7px;
        --danger:     #dc2626;
        --danger-50:  #fee2e2;
        --danger-100: #fecaca;
    }

    .page { padding: 28px 28px 60px; max-width: 2000px; margin: 0 auto; }

    /* Breadcrumb */
    .breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600;
        color: var(--text3); margin-bottom: 20px;
    }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    /* Page header */
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .header-actions { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }

    /* Buttons */
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: background .15s; white-space: nowrap;
    }
    .btn-primary  { background: var(--brand); color: #fff; }
    .btn-primary:hover  { background: var(--brand-h); }
    .btn-danger   { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .btn-danger:hover   { background: var(--danger-100); }
    .btn-ghost    { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover    { background: var(--surface3); }
    .btn-edit-sm  { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit-sm:hover  { background: var(--brand-100); }
    .btn-del-sm   { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .btn-del-sm:hover   { background: var(--danger-100); }
    .btn-sm   { padding: 5px 11px; font-size: 12px; }
    .btn-icon { padding: 6px 10px; }

    /* Stats */
    .stats-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 20px; }
    .stat-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 16px 18px;
        display: flex; align-items: center; gap: 14px;
    }
    .stat-icon {
        width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .stat-icon.blue   { background: var(--brand-50); }
    .stat-icon.green  { background: #dcfce7; }
    .stat-icon.yellow { background: #fef9c3; }
    .stat-icon.purple { background: #f3e8ff; }
    .stat-num   { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: var(--text); line-height: 1; }
    .stat-label { font-size: 12px; color: var(--text3); margin-top: 3px; font-family: 'DM Sans', sans-serif; }

    /* Filter */
    .filter-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 14px 18px;
        display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
        margin-bottom: 16px;
    }
    .filter-input, .filter-select {
        font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text);
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 7px 12px;
        outline: none; transition: border-color .15s;
    }
    .filter-input:focus, .filter-select:focus { border-color: var(--brand); }
    .filter-input   { min-width: 220px; }
    .filter-select  { min-width: 140px; }
    .filter-sep     { width: 1px; height: 24px; background: var(--border); margin: 0 4px; }
    select.filter-select {
        appearance: none; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg width='12' height='12' fill='none' stroke='%2394a3b8' stroke-width='2' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 10px center; padding-right: 28px;
    }

    /* Bulk bar */
    .bulk-bar {
        display: none; align-items: center; gap: 10px;
        background: var(--brand-50); border: 1px solid var(--brand-100);
        border-radius: var(--radius-sm); padding: 10px 16px; margin-bottom: 14px;
    }
    .bulk-bar.visible { display: flex; }
    .bulk-bar-text { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--brand-700); }

    /* Table card */
    .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .table-header {
        display: flex; align-items: center; gap: 10px;
        padding: 14px 18px; border-bottom: 1px solid var(--border); background: var(--surface2);
    }
    .table-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px; font-weight: 700; color: var(--text3);
        letter-spacing: .07em; text-transform: uppercase;
    }
    .table-badge {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
        color: var(--brand-700); background: var(--brand-50);
        border: 1px solid var(--brand-100); border-radius: 99px; padding: 2px 8px;
    }

    .main-table { width: 100%; border-collapse: collapse; }
    .main-table th {
        padding: 9px 14px; text-align: left;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px;
        font-weight: 700; color: var(--text3);
        letter-spacing: .06em; text-transform: uppercase;
        background: var(--surface2); border-bottom: 1px solid var(--border);
    }
    .main-table th.center, .main-table td.center { text-align: center; }
    .main-table td {
        padding: 12px 14px;
        font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text);
        border-bottom: 1px solid var(--border); vertical-align: middle;
    }
    .main-table tr:last-child td { border-bottom: none; }
    .main-table tr:hover td { background: var(--surface2); }

    /* Class name cell */
    .class-icon {
        width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
        background: var(--brand-50); border: 1px solid var(--brand-100);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px;
        font-weight: 800; color: var(--brand-700);
    }
    .class-cell { display: flex; align-items: center; gap: 10px; }
    .class-link {
        font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
        color: var(--text); font-size: 13.5px; text-decoration: none; transition: color .15s;
    }
    .class-link:hover { color: var(--brand); }
    .class-meta { font-size: 12px; color: var(--text3); margin-top: 1px; }

    /* Badges */
    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
    }
    .badge-tingkat { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .badge-jurusan { background: #f3e8ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .badge-neutral { background: var(--surface3); color: var(--text2); }

    /* Student count pill */
    .student-pill {
        display: inline-flex; align-items: center; gap: 5px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700;
        color: var(--text2);
    }

    /* Actions */
    .actions-cell { display: flex; gap: 6px; justify-content: center; }

    /* Checkbox */
    .cb { width: 15px; height: 15px; cursor: pointer; accent-color: var(--brand); }

    /* Empty state */
    .empty-state {
        display: flex; flex-direction: column; align-items: center;
        padding: 48px 16px; gap: 10px;
    }
    .empty-icon {
        width: 48px; height: 48px; border-radius: 14px;
        background: var(--surface3); display: flex; align-items: center; justify-content: center;
    }
    .empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700; color: var(--text2); }
    .empty-sub   { font-size: 13px; color: var(--text3); font-family: 'DM Sans', sans-serif; }

    /* Pagination */
    .pagination-wrap {
        display: flex; align-items: center; justify-content: space-between;
        padding: 14px 18px; border-top: 1px solid var(--border); flex-wrap: wrap; gap: 10px;
    }
    .pagination-info { font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--text3); }
    .pagination-links { display: flex; gap: 4px; }
    .page-link {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700;
        color: var(--text2); text-decoration: none; border: 1px solid var(--border);
        transition: all .15s; background: var(--surface);
    }
    .page-link:hover  { background: var(--brand-50); border-color: var(--brand-100); color: var(--brand); }
    .page-link.active { background: var(--brand); border-color: var(--brand); color: #fff; }
    .page-link.disabled { opacity: .4; pointer-events: none; }

    /* Responsive */
    @media (max-width: 900px) { .stats-row { grid-template-columns: repeat(2,1fr); } }
    @media (max-width: 600px) {
        .page { padding: 16px 16px 40px; }
        .filter-input { min-width: 100%; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <span class="current">Manajemen Kelas</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Data Kelas</h1>
            <p class="page-sub">Kelola data kelas dan wali kelas</p>
        </div>
        <div class="header-actions">
            <button id="btnBulkDelete" style="display:none" class="btn btn-danger btn-sm" onclick="confirmBulkDelete()">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6m4-6v6M9 6V4h6v2"/>
                </svg>
                Hapus Terpilih
            </button>
            <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Kelas
            </a>
        </div>
    </div>

    {{-- Stats --}}
    @php
        $totalKelas    = $classes->total();
        $totalSiswa    = $classes->sum(fn($c) => $c->students->count());
        $totalWali     = $classes->filter(fn($c) => $c->waliKelas)->count();
        $tingkatList   = $classes->pluck('tingkat')->unique()->filter()->values();
    @endphp
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $totalKelas }}</p>
                <p class="stat-label">Total Kelas</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $totalSiswa }}</p>
                <p class="stat-label">Total Siswa</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $totalWali }}</p>
                <p class="stat-label">Ada Wali Kelas</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $tingkatList->count() }}</p>
                <p class="stat-label">Tingkat Aktif</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.classes.index') }}" class="filter-card">
        <svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input
            type="text" name="search"
            placeholder="Cari nama kelas…"
            value="{{ request('search') }}"
            class="filter-input"
        >
        <div class="filter-sep"></div>
        <select name="tingkat" class="filter-select">
            <option value="">Semua Tingkat</option>
            @foreach(['X','XI','XII'] as $t)
                <option value="{{ $t }}" {{ request('tingkat') == $t ? 'selected' : '' }}>Tingkat {{ $t }}</option>
            @endforeach
        </select>
        <select name="jurusan" class="filter-select">
            <option value="">Semua Jurusan</option>
            @foreach($classes->pluck('jurusan')->unique()->filter()->sort()->values() as $j)
                <option value="{{ $j }}" {{ request('jurusan') == $j ? 'selected' : '' }}>{{ $j }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-ghost btn-sm">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
            </svg>
            Filter
        </button>
        @if(request()->hasAny(['search','tingkat','jurusan']))
            <a href="{{ route('admin.classes.index') }}" class="btn btn-ghost btn-sm">Reset</a>
        @endif
    </form>

    {{-- Bulk form --}}
    <form id="bulkForm" method="POST" action="{{ route('admin.classes.bulkDelete') }}">
        @csrf @method('DELETE')

        <div id="bulkBar" class="bulk-bar">
            <svg width="14" height="14" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span class="bulk-bar-text"><span id="bulkCount">0</span> kelas dipilih</span>
            <div style="flex:1"></div>
            <button type="button" class="btn btn-danger btn-sm" onclick="confirmBulkDelete()">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                </svg>
                Hapus Terpilih
            </button>
            <button type="button" class="btn btn-ghost btn-sm" onclick="clearSelection()">Batal</button>
        </div>

        {{-- Table --}}
        <div class="table-card">
            <div class="table-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                <p class="table-title">Daftar Kelas</p>
                @if($classes->total())
                    <span class="table-badge">{{ $classes->total() }} kelas</span>
                @endif
            </div>

            @if($classes->count())
                <table class="main-table">
                    <thead>
                        <tr>
                            <th style="width:40px">
                                <input type="checkbox" class="cb" id="cbAll" onchange="toggleAll(this)">
                            </th>
                            <th>Nama Kelas</th>
                            <th>Tingkat</th>
                            <th>Jurusan</th>
                            <th>Wali Kelas</th>
                            <th class="center">Jumlah Siswa</th>
                            <th class="center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classes as $class)
                            <tr>
                                <td>
                                    <input type="checkbox" class="cb row-cb" name="ids[]"
                                           value="{{ $class->id }}" onchange="updateBulk()">
                                </td>
                                <td>
                                    <div class="class-cell">
                                        <div class="class-icon">
                                            {{ strtoupper(substr($class->nama_kelas, 0, 2)) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.classes.show', $class->id) }}" class="class-link">
                                                {{ $class->nama_kelas }}
                                            </a>
                                            @if($class->jurusan)
                                                <p class="class-meta">{{ $class->jurusan }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-tingkat">{{ $class->tingkat }}</span>
                                </td>
                                <td>
                                    @if($class->jurusan)
                                        <span class="badge badge-jurusan">{{ $class->jurusan }}</span>
                                    @else
                                        <span style="color:var(--text3);font-style:italic;font-size:13px">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($class->waliKelas)
                                        <div style="display:flex;align-items:center;gap:8px">
                                            <div style="width:28px;height:28px;border-radius:7px;background:var(--surface3);
                                                        display:flex;align-items:center;justify-content:center;
                                                        font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;
                                                        font-weight:800;color:var(--text2);flex-shrink:0">
                                                {{ strtoupper(substr($class->waliKelas->nama_lengkap, 0, 1)) }}
                                            </div>
                                            <span style="font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text)">
                                                {{ $class->waliKelas->nama_lengkap }}
                                            </span>
                                        </div>
                                    @else
                                        <span style="color:var(--text3);font-style:italic;font-size:13px">Belum ditentukan</span>
                                    @endif
                                </td>
                                <td class="center">
                                    <span class="student-pill">
                                        <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                        </svg>
                                        {{ $class->students->count() }} siswa
                                    </span>
                                </td>
                                <td class="center">
                                    <div class="actions-cell">
                                        <a href="{{ route('admin.classes.show', $class->id) }}"
                                           class="btn btn-ghost btn-sm btn-icon" title="Detail">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.classes.edit', $class->id) }}"
                                           class="btn btn-edit-sm btn-sm btn-icon" title="Edit">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </a>
                                        <button type="button"
                                                class="btn btn-del-sm btn-sm btn-icon"
                                                title="Hapus"
                                                onclick="confirmDelete({{ $class->id }}, '{{ addslashes($class->nama_kelas) }}')">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6l-1 14H6L5 6"/>
                                                <path d="M10 11v6m4-6v6M9 6V4h6v2"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <form id="del-{{ $class->id }}" method="POST"
                                          action="{{ route('admin.classes.destroy', $class->id) }}" style="display:none">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if($classes->hasPages())
                    <div class="pagination-wrap">
                        <p class="pagination-info">
                            Menampilkan {{ $classes->firstItem() }}–{{ $classes->lastItem() }}
                            dari {{ $classes->total() }} kelas
                        </p>
                        <div class="pagination-links">
                            @if($classes->onFirstPage())
                                <span class="page-link disabled">‹</span>
                            @else
                                <a class="page-link" href="{{ $classes->previousPageUrl() }}">‹</a>
                            @endif

                            @foreach($classes->getUrlRange(1, $classes->lastPage()) as $page => $url)
                                <a class="page-link {{ $page == $classes->currentPage() ? 'active' : '' }}"
                                   href="{{ $url }}">{{ $page }}</a>
                            @endforeach

                            @if($classes->hasMorePages())
                                <a class="page-link" href="{{ $classes->nextPageUrl() }}">›</a>
                            @else
                                <span class="page-link disabled">›</span>
                            @endif
                        </div>
                    </div>
                @endif

            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </div>
                    <p class="empty-title">Tidak ada kelas ditemukan</p>
                    <p class="empty-sub">
                        @if(request()->hasAny(['search','tingkat','jurusan']))
                            Coba ubah filter pencarian
                        @else
                            Klik "Tambah Kelas" untuk menambahkan kelas baru
                        @endif
                    </p>
                    @if(!request()->hasAny(['search','tingkat','jurusan']))
                        <a href="{{ route('admin.classes.create') }}" class="btn btn-primary btn-sm" style="margin-top:8px">
                            Tambah Sekarang
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </form>

</div>

<script>
    function updateBulk() {
        const cbs     = document.querySelectorAll('.row-cb');
        const checked = document.querySelectorAll('.row-cb:checked');
        document.getElementById('cbAll').indeterminate = checked.length > 0 && checked.length < cbs.length;
        document.getElementById('cbAll').checked = checked.length === cbs.length && cbs.length > 0;

        const bar = document.getElementById('bulkBar');
        const btn = document.getElementById('btnBulkDelete');
        if (checked.length > 0) {
            bar.classList.add('visible');
            if (btn) btn.style.display = 'inline-flex';
        } else {
            bar.classList.remove('visible');
            if (btn) btn.style.display = 'none';
        }
        document.getElementById('bulkCount').textContent = checked.length;
    }

    function toggleAll(el) {
        document.querySelectorAll('.row-cb').forEach(cb => cb.checked = el.checked);
        updateBulk();
    }

    function clearSelection() {
        document.querySelectorAll('.row-cb, #cbAll').forEach(cb => cb.checked = false);
        updateBulk();
    }

    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Hapus Kelas?',
            html: `Kelas <b>${nama}</b> akan dihapus permanen beserta semua data terkait.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
        }).then(r => { if (r.isConfirmed) document.getElementById('del-' + id).submit(); });
    }

    function confirmBulkDelete() {
        const count = document.querySelectorAll('.row-cb:checked').length;
        if (!count) return;
        Swal.fire({
            title: 'Hapus ' + count + ' Kelas?',
            text: 'Data yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus Semua',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
        }).then(r => { if (r.isConfirmed) document.getElementById('bulkForm').submit(); });
    }
</script>

</x-app-layout>