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
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}', confirmButtonColor: '#1f63db' });
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
        --red:        #dc2626;
        --red-bg:     #fee2e2;
        --red-border: #fecaca;
        --radius:     10px;
        --radius-sm:  7px;
    }

    /* ── Layout ── */
    .page { padding: 28px 28px 60px; max-width: 2000px; margin: 0 auto; }

    /* ── Breadcrumb ── */
    .breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600;
        color: var(--text3); margin-bottom: 20px;
    }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    /* ── Page header ── */
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .header-actions { display: flex; gap: 8px; flex-wrap: wrap; }

    /* ── Buttons ── */
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: filter .15s, background .15s; white-space: nowrap;
    }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { filter: brightness(.93); }
    .btn-danger  { background: var(--red-bg); color: var(--red); border: 1px solid var(--red-border); }
    .btn-danger:hover { background: #fecaca; }
    .btn-danger:disabled { opacity: .5; cursor: not-allowed; }
    .btn-outline { background: var(--surface); color: var(--text2); border: 1px solid var(--border); }
    .btn-outline:hover { background: var(--surface3); }

    /* ── Stats row ── */
    .stats-row { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 20px; }
    .stat-card {
        flex: 1; min-width: 140px;
        background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius);
        padding: 14px 18px; display: flex; align-items: center; gap: 12px;
    }
    .stat-icon {
        width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .stat-icon-blue   { background: var(--brand-50); }
    .stat-icon-green  { background: #dcfce7; }
    .stat-icon-red    { background: #fee2e2; }
    .stat-icon-yellow { background: #fef9c3; }
    .stat-val  { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: var(--text); line-height: 1; }
    .stat-lbl  { font-size: 11.5px; color: var(--text3); font-family: 'DM Sans', sans-serif; margin-top: 2px; }

    /* ── Filter bar ── */
    .filter-bar {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 14px 18px;
        display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
        margin-bottom: 16px;
    }
    .filter-bar input,
    .filter-bar select {
        height: 36px; padding: 0 12px;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text);
        background: var(--surface2); outline: none;
        transition: border-color .15s, background .15s;
    }
    .filter-bar input { min-width: 220px; flex: 1; }
    .filter-bar input:focus,
    .filter-bar select:focus { border-color: var(--brand-h); background: #fff; box-shadow: 0 0 0 3px rgba(53,130,240,.1); }
    .filter-bar input::placeholder { color: var(--text3); }
    .filter-bar .filter-sep { width: 1px; height: 24px; background: var(--border); flex-shrink: 0; }

    /* ── Table card ── */
    .table-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
    }
    .table-toolbar {
        display: flex; align-items: center; justify-content: space-between;
        padding: 14px 18px; border-bottom: 1px solid var(--border);
        background: var(--surface2); gap: 10px; flex-wrap: wrap;
    }
    .table-toolbar-left  { display: flex; align-items: center; gap: 10px; }
    .table-count {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px;
        font-weight: 700; color: var(--text3);
    }
    .table-count strong { color: var(--text2); }
    .bulk-actions {
        display: none; align-items: center; gap: 8px;
        padding: 6px 12px; background: var(--brand-50);
        border-radius: var(--radius-sm); border: 1px solid var(--brand-100);
    }
    .bulk-actions.show { display: flex; }
    .bulk-info {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px;
        font-weight: 700; color: var(--brand-700);
    }

    /* ── Table ── */
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        padding: 10px 14px; text-align: left;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px;
        font-weight: 700; color: var(--text3);
        letter-spacing: .06em; text-transform: uppercase;
        background: var(--surface2); border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }
    thead th.th-check { width: 40px; text-align: center; }
    thead th.th-actions { text-align: right; }
    tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: var(--surface2); }
    tbody tr.selected { background: var(--brand-50); }
    tbody td { padding: 12px 14px; font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); }
    tbody td.td-check { text-align: center; }
    tbody td.td-actions { text-align: right; white-space: nowrap; }

    /* ── Checkbox ── */
    input[type="checkbox"] {
        width: 15px; height: 15px; accent-color: var(--brand); cursor: pointer;
    }

    /* ── Avatar ── */
    .avatar {
        width: 36px; height: 36px; border-radius: 10px; overflow: hidden;
        background: var(--brand-50); flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .avatar img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-initial {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px; font-weight: 800; color: var(--brand);
    }
    .teacher-cell { display: flex; align-items: center; gap: 10px; }
    .teacher-name {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px;
        font-weight: 700; color: var(--text); text-decoration: none;
        transition: color .15s;
    }
    .teacher-name:hover { color: var(--brand); }
    .teacher-nip { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; }

    /* ── Badges ── */
    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
    }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-aktif      { background: #dcfce7; color: #15803d; }
    .badge-aktif      .badge-dot { background: #15803d; }
    .badge-tidak_aktif { background: #fee2e2; color: #dc2626; }
    .badge-tidak_aktif .badge-dot { background: #dc2626; }
    .badge-gender-l   { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .badge-gender-p   { background: #fdf2f8; color: #9d174d; border: 1px solid #fbcfe8; }

    /* ── Action buttons ── */
    .action-btn {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 5px 10px; border-radius: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: background .15s; white-space: nowrap;
    }
    .action-view   { background: var(--surface3); color: var(--text2); }
    .action-view:hover { background: var(--border2); }
    .action-edit   { background: var(--brand-50); color: var(--brand-700); }
    .action-edit:hover { background: var(--brand-100); }
    .action-delete { background: var(--red-bg); color: var(--red); }
    .action-delete:hover { background: #fecaca; }

    /* ── Empty state ── */
    .empty-state {
        display: flex; flex-direction: column; align-items: center;
        padding: 60px 24px; gap: 12px;
    }
    .empty-icon {
        width: 56px; height: 56px; border-radius: 16px;
        background: var(--surface3); display: flex; align-items: center; justify-content: center;
    }
    .empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 700; color: var(--text2); }
    .empty-sub   { font-size: 13px; color: var(--text3); font-family: 'DM Sans', sans-serif; }

    /* ── Pagination ── */
    .pagination-wrap {
        display: flex; align-items: center; justify-content: space-between;
        padding: 14px 18px; border-top: 1px solid var(--border);
        background: var(--surface2); gap: 10px; flex-wrap: wrap;
    }
    .pagination-info {
        font-size: 12.5px; color: var(--text3);
        font-family: 'DM Sans', sans-serif;
    }
    .pagination-links { display: flex; gap: 4px; align-items: center; }
    .page-link {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 32px; height: 32px; padding: 0 8px;
        border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px; font-weight: 700; text-decoration: none; transition: background .15s;
        border: 1px solid transparent; color: var(--text2);
    }
    .page-link:hover    { background: var(--surface3); }
    .page-link.active   { background: var(--brand); color: #fff; border-color: var(--brand); }
    .page-link.disabled { opacity: .4; pointer-events: none; }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .page { padding: 16px 16px 40px; }
        .stats-row .stat-card { min-width: 120px; }
        thead th.th-hide,
        tbody td.td-hide { display: none; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <span class="current">Manajemen Guru</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Guru</h1>
            <p class="page-sub">Kelola data seluruh guru yang terdaftar di sistem</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Guru
            </a>
        </div>
    </div>

    {{-- Stats --}}
    @php
        $total   = $teachers->total();
        $aktif   = $teachers->getCollection()->where('status', 'aktif')->count();
        $nonaktif = $teachers->getCollection()->where('status', 'tidak_aktif')->count();
        $lakiLaki = $teachers->getCollection()->where('jenis_kelamin', 'L')->count();
    @endphp
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon stat-icon-blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div>
                <p class="stat-val">{{ $total }}</p>
                <p class="stat-lbl">Total Guru</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon-green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <div>
                <p class="stat-val">{{ $teachers->getCollection()->where('status','aktif')->count() }}</p>
                <p class="stat-lbl">Guru Aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon-red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </div>
            <div>
                <p class="stat-val">{{ $teachers->getCollection()->where('status','tidak_aktif')->count() }}</p>
                <p class="stat-lbl">Tidak Aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon-yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
            </div>
            <div>
                <p class="stat-val">{{ $teachers->getCollection()->where('jenis_kelamin','L')->count() }}</p>
                <p class="stat-lbl">Laki-laki</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.teachers.index') }}" id="filterForm">
        <div class="filter-bar">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama atau NIP…">
            <div class="filter-sep"></div>
            <select name="status" onchange="document.getElementById('filterForm').submit()">
                <option value="">Semua Status</option>
                <option value="aktif"       {{ request('status') == 'aktif'       ? 'selected' : '' }}>Aktif</option>
                <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            <select name="jenis_kelamin" onchange="document.getElementById('filterForm').submit()">
                <option value="">Semua Jenis Kelamin</option>
                <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            <button type="submit" class="btn btn-outline">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Cari
            </button>
            @if(request()->hasAny(['search','status','jenis_kelamin']))
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- Table --}}
    <form method="POST" action="{{ route('admin.teachers.bulkDelete') }}" id="bulkForm">
        @csrf
        @method('DELETE')

        <div class="table-card">
            <div class="table-toolbar">
                <div class="table-toolbar-left">
                    <p class="table-count">
                        Menampilkan <strong>{{ $teachers->count() }}</strong>
                        dari <strong>{{ $teachers->total() }}</strong> guru
                    </p>
                    <div class="bulk-actions" id="bulkActions">
                        <span class="bulk-info" id="bulkInfo">0 dipilih</span>
                        <button type="submit" class="btn btn-danger" style="padding:5px 12px;font-size:12px"
                            onclick="return confirmBulkDelete()">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                                <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                            </svg>
                            Hapus Dipilih
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th class="th-check">
                                <input type="checkbox" id="checkAll" title="Pilih semua">
                            </th>
                            <th>Guru</th>
                            <th class="th-hide">Jenis Kelamin</th>
                            <th class="th-hide">Mengajar Kelas</th>
                            <th>Status</th>
                            <th class="th-actions">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                            <tr id="row-{{ $teacher->id }}">
                                <td class="td-check">
                                    <input type="checkbox" name="ids[]" value="{{ $teacher->id }}"
                                        class="row-check" onchange="updateBulk()">
                                </td>
                                <td>
                                    <div class="teacher-cell">
                                        <div class="avatar">
                                            @if($teacher->foto)
                                                <img src="{{ asset('storage/' . $teacher->foto) }}" alt="{{ $teacher->nama_lengkap }}">
                                            @else
                                                <span class="avatar-initial">{{ strtoupper(substr($teacher->nama_lengkap, 0, 1)) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.teachers.show', $teacher->id) }}" class="teacher-name">
                                                {{ $teacher->nama_lengkap }}
                                            </a>
                                            <p class="teacher-nip">NIP: {{ $teacher->nip }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="th-hide">
                                    <span class="badge {{ $teacher->jenis_kelamin === 'L' ? 'badge-gender-l' : 'badge-gender-p' }}">
                                        {{ $teacher->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                </td>
                                <td class="th-hide">
                                    @if($teacher->classes && $teacher->classes->count())
                                        <div style="display:flex;gap:4px;flex-wrap:wrap">
                                            @foreach($teacher->classes->take(3) as $class)
                                                <span class="badge" style="background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)">
                                                    {{ $class->nama_kelas }}
                                                </span>
                                            @endforeach
                                            @if($teacher->classes->count() > 3)
                                                <span class="badge" style="background:var(--surface3);color:var(--text2)">
                                                    +{{ $teacher->classes->count() - 3 }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span style="color:var(--text3);font-size:13px;font-style:italic">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $teacher->status }}">
                                        <span class="badge-dot"></span>
                                        {{ $teacher->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td class="td-actions">
                                    <a href="{{ route('admin.teachers.show', $teacher->id) }}" class="action-btn action-view">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="action-btn action-edit">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <button type="button" class="action-btn action-delete"
                                        onclick="confirmDelete({{ $teacher->id }}, '{{ addslashes($teacher->nama_lengkap) }}')">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                                            <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                                        </svg>
                                        Hapus
                                    </button>

                                    {{-- Hidden single-delete form --}}
                                    <form id="deleteForm-{{ $teacher->id }}"
                                        action="{{ route('admin.teachers.destroy', $teacher->id) }}"
                                        method="POST" style="display:none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                                <circle cx="9" cy="7" r="4"/>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                            </svg>
                                        </div>
                                        <p class="empty-title">Tidak ada data guru</p>
                                        <p class="empty-sub">
                                            @if(request()->hasAny(['search','status','jenis_kelamin']))
                                                Coba ubah filter pencarian Anda
                                            @else
                                                Klik "Tambah Guru" untuk menambahkan guru baru
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($teachers->hasPages())
                <div class="pagination-wrap">
                    <p class="pagination-info">
                        Halaman {{ $teachers->currentPage() }} dari {{ $teachers->lastPage() }}
                    </p>
                    <div class="pagination-links">
                        <a href="{{ $teachers->previousPageUrl() }}"
                            class="page-link {{ $teachers->onFirstPage() ? 'disabled' : '' }}">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <polyline points="15 18 9 12 15 6"/>
                            </svg>
                        </a>
                        @foreach($teachers->getUrlRange(max(1, $teachers->currentPage()-2), min($teachers->lastPage(), $teachers->currentPage()+2)) as $page => $url)
                            <a href="{{ $url }}" class="page-link {{ $page == $teachers->currentPage() ? 'active' : '' }}">
                                {{ $page }}
                            </a>
                        @endforeach
                        <a href="{{ $teachers->nextPageUrl() }}"
                            class="page-link {{ !$teachers->hasMorePages() ? 'disabled' : '' }}">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </form>

</div>{{-- /.page --}}

<script>
    /* ── Check all / row check ── */
    const checkAll   = document.getElementById('checkAll');
    const rowChecks  = () => document.querySelectorAll('.row-check');

    checkAll.addEventListener('change', function () {
        rowChecks().forEach(cb => {
            cb.checked = this.checked;
            cb.closest('tr').classList.toggle('selected', this.checked);
        });
        updateBulk();
    });

    function updateBulk() {
        const checked = [...rowChecks()].filter(cb => cb.checked);
        const bulk    = document.getElementById('bulkActions');
        const info    = document.getElementById('bulkInfo');

        // update row highlight
        rowChecks().forEach(cb => cb.closest('tr').classList.toggle('selected', cb.checked));

        // update "check all" indeterminate state
        checkAll.indeterminate = checked.length > 0 && checked.length < rowChecks().length;
        checkAll.checked       = checked.length > 0 && checked.length === rowChecks().length;

        bulk.classList.toggle('show', checked.length > 0);
        info.textContent = checked.length + ' dipilih';
    }

    /* ── Single delete ── */
    function confirmDelete(id, name) {
        Swal.fire({
            icon: 'warning',
            title: 'Hapus Guru?',
            html: `Data <strong>${name}</strong> akan dihapus permanen.`,
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
        }).then(result => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm-' + id).submit();
            }
        });
    }

    /* ── Bulk delete ── */
    function confirmBulkDelete() {
        const count = [...rowChecks()].filter(cb => cb.checked).length;
        Swal.fire({
            icon: 'warning',
            title: `Hapus ${count} Guru?`,
            text: 'Data yang dihapus tidak dapat dipulihkan.',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Hapus Semua',
            cancelButtonText: 'Batal',
        }).then(result => {
            if (result.isConfirmed) document.getElementById('bulkForm').submit();
        });
        return false;
    }
</script>

</x-app-layout>