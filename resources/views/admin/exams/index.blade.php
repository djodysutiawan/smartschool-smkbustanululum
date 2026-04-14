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
        Swal.fire({
            icon: 'error', title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 3000, showConfirmButton: false,
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
        --success:    #16a34a;
        --success-50: #dcfce7;
        --success-100:#bbf7d0;
        --warning:    #d97706;
        --warning-50: #fef9c3;
        --warning-100:#fef08a;
        --orange:     #ea580c;
        --orange-50:  #ffedd5;
        --orange-100: #fed7aa;
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
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { background: var(--brand-h); }
    .btn-danger  { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .btn-danger:hover { background: var(--danger-100); }
    .btn-ghost   { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }
    .btn-edit-sm { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit-sm:hover { background: var(--brand-100); }
    .btn-del-sm  { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .btn-del-sm:hover { background: var(--danger-100); }
    .btn-sm   { padding: 5px 11px; font-size: 12px; }
    .btn-icon { padding: 6px 10px; }

    /* Stats */
    .stats-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 20px; }
    .stat-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 16px 18px;
        display: flex; align-items: center; gap: 14px;
    }
    .stat-icon { width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
    .stat-icon.blue   { background: var(--brand-50); }
    .stat-icon.green  { background: #dcfce7; }
    .stat-icon.yellow { background: #fef9c3; }
    .stat-icon.orange { background: #ffedd5; }
    .stat-icon.red    { background: #fee2e2; }
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
    .filter-input  { min-width: 200px; }
    .filter-select { min-width: 150px; }
    .filter-sep    { width: 1px; height: 24px; background: var(--border); margin: 0 4px; }
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
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
        color: var(--text3); letter-spacing: .07em; text-transform: uppercase;
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
        font-weight: 700; color: var(--text3); letter-spacing: .06em; text-transform: uppercase;
        background: var(--surface2); border-bottom: 1px solid var(--border);
    }
    .main-table th.center, .main-table td.center { text-align: center; }
    .main-table td {
        padding: 12px 14px; font-family: 'DM Sans', sans-serif;
        font-size: 13.5px; color: var(--text);
        border-bottom: 1px solid var(--border); vertical-align: middle;
    }
    .main-table tr:last-child td { border-bottom: none; }
    .main-table tr:hover td { background: var(--surface2); }

    /* Exam cell */
    .exam-cell { display: flex; align-items: center; gap: 10px; }
    .exam-icon {
        width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        background: var(--orange-50); border: 1px solid var(--orange-100);
    }
    .exam-link {
        font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
        color: var(--text); font-size: 13.5px; text-decoration: none; transition: color .15s;
    }
    .exam-link:hover { color: var(--brand); }
    .exam-meta { font-size: 12px; color: var(--text3); margin-top: 1px; }

    /* Teacher mini */
    .teacher-mini { display: flex; align-items: center; gap: 7px; }
    .teacher-mini-avatar {
        width: 26px; height: 26px; border-radius: 6px; flex-shrink: 0;
        background: var(--surface3); border: 1px solid var(--border2);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 10px;
        font-weight: 800; color: var(--text2); overflow: hidden;
    }
    .teacher-mini-avatar img { width: 100%; height: 100%; object-fit: cover; }

    /* Badges */
    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
    }
    .badge-class   { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .badge-subject { background: #f3e8ff; color: #7c3aed; border: 1px solid #e9d5ff; }

    /* Status badge */
    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
    }
    .status-badge .dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .status-upcoming { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .status-upcoming .dot { background: var(--brand); }
    .status-today    { background: var(--success-50); color: var(--success); border: 1px solid var(--success-100); }
    .status-today .dot { background: var(--success); }
    .status-past     { background: var(--surface3); color: var(--text3); border: 1px solid var(--border2); }
    .status-past .dot { background: var(--text3); }

    /* Actions */
    .actions-cell { display: flex; gap: 6px; justify-content: center; }

    /* Checkbox */
    .cb { width: 15px; height: 15px; cursor: pointer; accent-color: var(--brand); }

    /* Empty state */
    .empty-state { display: flex; flex-direction: column; align-items: center; padding: 48px 16px; gap: 10px; }
    .empty-icon { width: 48px; height: 48px; border-radius: 14px; background: var(--surface3); display: flex; align-items: center; justify-content: center; }
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
    @media (max-width: 600px) { .page { padding: 16px 16px 40px; } }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <span class="current">Jadwal Ujian</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Jadwal Ujian</h1>
            <p class="page-sub">Kelola jadwal ujian seluruh kelas dan mata pelajaran</p>
        </div>
        <div class="header-actions">
            <button id="btnBulkDelete" style="display:none" class="btn btn-danger btn-sm" onclick="confirmBulkDelete()">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6m4-6v6M9 6V4h6v2"/>
                </svg>
                Hapus Terpilih
            </button>
            <a href="{{ route('admin.exams.create') }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Ujian
            </a>
        </div>
    </div>

    {{-- Stats --}}
    @php
        $totalUjian   = $exams->total();
        $totalGuru    = $teachers->count();
        $totalMapel   = $subjects->count();
        $totalKelas   = $classes->count();
    @endphp
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#ea580c" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $totalUjian }}</p>
                <p class="stat-label">Total Ujian</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                    <polyline points="9 16 11 18 15 14"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $exams->getCollection()->filter(fn($e) => \Carbon\Carbon::parse($e->tanggal)->isFuture())->count() }}</p>
                <p class="stat-label">Ujian Mendatang</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $exams->getCollection()->filter(fn($e) => \Carbon\Carbon::parse($e->tanggal)->isToday())->count() }}</p>
                <p class="stat-label">Ujian Hari Ini</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $totalGuru }}</p>
                <p class="stat-label">Total Guru</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.exams.index') }}" class="filter-card">
        <svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
        </svg>
        <input type="text" name="search" class="filter-input"
               placeholder="Cari judul ujian…"
               value="{{ request('search') }}">
        <div class="filter-sep"></div>
        <select name="subject_id" class="filter-select">
            <option value="">Semua Mapel</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                    {{ $subject->nama_mapel }}
                </option>
            @endforeach
        </select>
        <select name="class_id" class="filter-select">
            <option value="">Semua Kelas</option>
            @foreach($classes as $cls)
                <option value="{{ $cls->id }}" {{ request('class_id') == $cls->id ? 'selected' : '' }}>
                    {{ $cls->nama_kelas }}
                </option>
            @endforeach
        </select>
        <select name="teacher_id" class="filter-select">
            <option value="">Semua Guru</option>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                    {{ $teacher->nama_lengkap }}
                </option>
            @endforeach
        </select>
        <select name="status" class="filter-select">
            <option value="">Semua Status</option>
            <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Mendatang</option>
            <option value="today"    {{ request('status') === 'today'    ? 'selected' : '' }}>Hari Ini</option>
            <option value="past"     {{ request('status') === 'past'     ? 'selected' : '' }}>Sudah Lewat</option>
        </select>
        <button type="submit" class="btn btn-ghost btn-sm">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            Terapkan
        </button>
        @if(request()->hasAny(['search','subject_id','class_id','teacher_id','status']))
            <a href="{{ route('admin.exams.index') }}" class="btn btn-ghost btn-sm">Reset</a>
        @endif
    </form>

    {{-- Bulk Form --}}
    <form id="bulkForm" method="POST" action="{{ route('admin.exams.bulkDelete') }}">
        @csrf @method('DELETE')

        <div id="bulkBar" class="bulk-bar">
            <svg width="14" height="14" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span class="bulk-bar-text"><span id="bulkCount">0</span> ujian dipilih</span>
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
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <p class="table-title">Daftar Jadwal Ujian</p>
                @if($exams->total())
                    <span class="table-badge">{{ $exams->total() }} ujian</span>
                @endif
            </div>

            @if($exams->count())
                <table class="main-table">
                    <thead>
                        <tr>
                            <th style="width:40px">
                                <input type="checkbox" class="cb" id="cbAll" onchange="toggleAll(this)">
                            </th>
                            <th>Judul Ujian</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Guru</th>
                            <th>Tanggal Ujian</th>
                            <th class="center">Status</th>
                            <th class="center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exams as $exam)
                            @php
                                $tanggal = \Carbon\Carbon::parse($exam->tanggal);
                                if ($tanggal->isToday()) {
                                    $statusClass = 'status-today';
                                    $statusLabel = 'Hari Ini';
                                } elseif ($tanggal->isFuture()) {
                                    $statusClass = 'status-upcoming';
                                    $statusLabel = 'Mendatang';
                                } else {
                                    $statusClass = 'status-past';
                                    $statusLabel = 'Selesai';
                                }
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" class="cb row-cb" name="ids[]"
                                           value="{{ $exam->id }}" onchange="updateBulk()">
                                </td>

                                {{-- Judul Ujian --}}
                                <td>
                                    <div class="exam-cell">
                                        <div class="exam-icon">
                                            <svg width="16" height="16" fill="none" stroke="#ea580c" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                                <polyline points="14 2 14 8 20 8"/>
                                                <line x1="16" y1="13" x2="8" y2="13"/>
                                                <line x1="16" y1="17" x2="8" y2="17"/>
                                                <polyline points="10 9 9 9 8 9"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.exams.show', $exam->id) }}" class="exam-link">
                                                {{ $exam->judul }}
                                            </a>
                                            <p class="exam-meta">Dibuat {{ $exam->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Mata Pelajaran --}}
                                <td>
                                    @if($exam->subject)
                                        <span class="badge badge-subject">{{ $exam->subject->nama_mapel }}</span>
                                    @else
                                        <span style="color:var(--text3);font-style:italic;font-size:13px">—</span>
                                    @endif
                                </td>

                                {{-- Kelas --}}
                                <td>
                                    @if($exam->class)
                                        <span class="badge badge-class">{{ $exam->class->nama_kelas }}</span>
                                    @else
                                        <span style="color:var(--text3);font-style:italic;font-size:13px">—</span>
                                    @endif
                                </td>

                                {{-- Guru --}}
                                <td>
                                    @if($exam->teacher)
                                        <div class="teacher-mini">
                                            <div class="teacher-mini-avatar">
                                                @if($exam->teacher->foto)
                                                    <img src="{{ asset('storage/'.$exam->teacher->foto) }}" alt="">
                                                @else
                                                    {{ strtoupper(substr($exam->teacher->nama_lengkap, 0, 1)) }}
                                                @endif
                                            </div>
                                            <span style="font-size:13px;color:var(--text)">
                                                {{ $exam->teacher->nama_lengkap }}
                                            </span>
                                        </div>
                                    @else
                                        <span style="color:var(--text3);font-style:italic;font-size:13px">—</span>
                                    @endif
                                </td>

                                {{-- Tanggal --}}
                                <td>
                                    <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)">
                                        {{ $tanggal->translatedFormat('d M Y') }}
                                    </span>
                                    <p style="font-size:11.5px;color:var(--text3);margin-top:1px">
                                        {{ $tanggal->translatedFormat('l') }}
                                    </p>
                                </td>

                                {{-- Status --}}
                                <td class="center">
                                    <span class="status-badge {{ $statusClass }}">
                                        <span class="dot"></span>
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="center">
                                    <div class="actions-cell">
                                        <a href="{{ route('admin.exams.show', $exam->id) }}"
                                           class="btn btn-ghost btn-sm btn-icon" title="Detail"
                                           aria-label="Detail ujian">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                        </a>

                                        <a href="{{ route('admin.exams.edit', $exam->id) }}"
                                           class="btn btn-edit-sm btn-sm btn-icon" title="Edit"
                                           aria-label="Edit ujian">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </a>

                                        <button type="button"
                                                class="btn btn-del-sm btn-sm btn-icon" title="Hapus"
                                                aria-label="Hapus ujian"
                                                data-id="{{ $exam->id }}"
                                                data-judul="{{ $exam->judul }}"
                                                onclick="confirmDelete(this)">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6l-1 14H6L5 6"/>
                                                <path d="M10 11v6m4-6v6M9 6V4h6v2"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <form id="del-{{ $exam->id }}" method="POST"
                                          action="{{ route('admin.exams.destroy', $exam->id) }}" style="display:none">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if($exams->hasPages())
                    <div class="pagination-wrap">
                        <p class="pagination-info">
                            Menampilkan {{ $exams->firstItem() }}–{{ $exams->lastItem() }}
                            dari {{ $exams->total() }} ujian
                        </p>
                        <div class="pagination-links">
                            @if($exams->onFirstPage())
                                <span class="page-link disabled">‹</span>
                            @else
                                <a class="page-link" href="{{ $exams->previousPageUrl() }}">‹</a>
                            @endif
                            @foreach($exams->getUrlRange(1, $exams->lastPage()) as $page => $url)
                                <a class="page-link {{ $page == $exams->currentPage() ? 'active' : '' }}"
                                   href="{{ $url }}">{{ $page }}</a>
                            @endforeach
                            @if($exams->hasMorePages())
                                <a class="page-link" href="{{ $exams->nextPageUrl() }}">›</a>
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
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <p class="empty-title">Tidak ada ujian ditemukan</p>
                    <p class="empty-sub">
                        @if(request()->hasAny(['search','subject_id','class_id','teacher_id','status']))
                            Coba ubah kata kunci atau filter pencarian
                        @else
                            Klik "Tambah Ujian" untuk menambahkan jadwal ujian baru
                        @endif
                    </p>
                    @if(!request()->hasAny(['search','subject_id','class_id','teacher_id','status']))
                        <a href="{{ route('admin.exams.create') }}" class="btn btn-primary btn-sm" style="margin-top:8px">
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

    function confirmDelete(btn) {
        const id    = btn.dataset.id;
        const judul = btn.dataset.judul;
        Swal.fire({
            title: 'Hapus Ujian?',
            html: `Ujian <b>${judul}</b> akan dihapus permanen.`,
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
            title: 'Hapus ' + count + ' Ujian?',
            text: 'Semua data ujian yang dipilih akan dihapus permanen.',
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