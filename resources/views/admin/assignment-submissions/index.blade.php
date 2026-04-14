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
        --purple:     #7c3aed;
        --purple-50:  #f3e8ff;
        --purple-100: #e9d5ff;
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
    .btn-success { background: var(--success-50); color: var(--success); border: 1px solid var(--success-100); }
    .btn-success:hover { background: var(--success-100); }
    .btn-edit-sm { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit-sm:hover { background: var(--brand-100); }
    .btn-del-sm  { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .btn-del-sm:hover { background: var(--danger-100); }
    .btn-grade-sm { background: var(--success-50); color: var(--success); border: 1px solid var(--success-100); }
    .btn-grade-sm:hover { background: var(--success-100); }
    .btn-dl-sm   { background: var(--purple-50); color: var(--purple); border: 1px solid var(--purple-100); }
    .btn-dl-sm:hover { background: var(--purple-100); }
    .btn-sm   { padding: 5px 11px; font-size: 12px; }
    .btn-icon { padding: 6px 10px; }

    /* Stats */
    .stats-row { display: grid; grid-template-columns: repeat(5,1fr); gap: 12px; margin-bottom: 20px; }
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
    .stat-icon.purple { background: var(--purple-50); }
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

    /* Submission cell */
    .sub-cell { display: flex; align-items: center; gap: 10px; }
    .sub-icon {
        width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        background: var(--purple-50); border: 1px solid var(--purple-100);
    }
    .sub-link {
        font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
        color: var(--text); font-size: 13.5px; text-decoration: none; transition: color .15s;
    }
    .sub-link:hover { color: var(--brand); }
    .sub-meta { font-size: 12px; color: var(--text3); margin-top: 1px; }

    /* Student mini */
    .student-mini { display: flex; align-items: center; gap: 7px; }
    .student-avatar {
        width: 28px; height: 28px; border-radius: 7px; flex-shrink: 0;
        background: var(--surface3); border: 1px solid var(--border2);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 10px;
        font-weight: 800; color: var(--text2); overflow: hidden;
    }
    .student-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .student-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .student-nisn { font-size: 11.5px; color: var(--text3); font-family: 'DM Sans', sans-serif; }

    /* Badges */
    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
    }
    .badge-assignment { background: var(--orange-50); color: var(--orange); border: 1px solid var(--orange-100); }

    /* Nilai pill */
    .nilai-pill {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 46px; padding: 4px 10px; border-radius: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 800;
    }
    .nilai-a  { background: var(--success-50); color: var(--success); border: 1px solid var(--success-100); }
    .nilai-b  { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .nilai-c  { background: var(--warning-50); color: var(--warning); border: 1px solid var(--warning-100); }
    .nilai-d  { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .nilai-na { background: var(--surface3); color: var(--text3); border: 1px solid var(--border2); font-size: 11.5px; }

    /* Status badge */
    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
    }
    .status-badge .dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .status-submitted { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .status-submitted .dot { background: var(--brand); }
    .status-graded   { background: var(--success-50); color: var(--success); border: 1px solid var(--success-100); }
    .status-graded .dot { background: var(--success); }
    .status-returned { background: var(--warning-50); color: var(--warning); border: 1px solid var(--warning-100); }
    .status-returned .dot { background: var(--warning); }

    /* File chip */
    .file-chip {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: 6px; padding: 3px 9px;
        font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text2);
    }

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

    /* Grade modal */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(15,23,42,.45); z-index: 1000;
        align-items: center; justify-content: center;
    }
    .modal-overlay.open { display: flex; }
    .modal-box {
        background: var(--surface); border-radius: 14px;
        padding: 28px; width: 100%; max-width: 420px;
        box-shadow: 0 20px 60px rgba(15,23,42,.18);
    }
    .modal-title {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px;
        font-weight: 800; color: var(--text); margin-bottom: 18px;
    }
    .form-group { margin-bottom: 14px; }
    .form-label {
        display: block; font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px; font-weight: 700; color: var(--text2);
        margin-bottom: 6px; text-transform: uppercase; letter-spacing: .05em;
    }
    .form-input {
        width: 100%; font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text);
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 9px 12px;
        outline: none; transition: border-color .15s; box-sizing: border-box;
    }
    .form-input:focus { border-color: var(--brand); }
    .modal-actions { display: flex; gap: 8px; justify-content: flex-end; margin-top: 20px; }

    /* Responsive */
    @media (max-width: 1100px) { .stats-row { grid-template-columns: repeat(3,1fr); } }
    @media (max-width: 900px)  { .stats-row { grid-template-columns: repeat(2,1fr); } }
    @media (max-width: 600px)  { .page { padding: 16px 16px 40px; } }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.assignments.index') }}">Tugas</a>
        <span class="sep">›</span>
        <span class="current">Submission Tugas</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Submission Tugas</h1>
            <p class="page-sub">Kelola dan nilai semua pengumpulan tugas dari siswa</p>
        </div>
        <div class="header-actions">
            <button id="btnBulkDelete" style="display:none" class="btn btn-danger btn-sm" onclick="confirmBulkDelete()">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6m4-6v6M9 6V4h6v2"/>
                </svg>
                Hapus Terpilih
            </button>
            <button id="btnBulkGrade" style="display:none" class="btn btn-success btn-sm" onclick="openBulkGrade()">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Nilai Terpilih
            </button>
        </div>
    </div>

    {{-- Stats --}}
    @php
        $total     = $submissions->total();
        $submitted = $submissions->getCollection()->where('status','submitted')->count();
        $graded    = $submissions->getCollection()->where('status','graded')->count();
        $returned  = $submissions->getCollection()->where('status','returned')->count();
        $avgNilai  = $submissions->getCollection()->whereNotNull('nilai')->avg('nilai');
    @endphp
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $total }}</p>
                <p class="stat-label">Total Submission</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $submissions->getCollection()->where('status','submitted')->count() }}</p>
                <p class="stat-label">Menunggu Nilai</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $submissions->getCollection()->where('status','graded')->count() }}</p>
                <p class="stat-label">Sudah Dinilai</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="1 4 1 10 7 10"/>
                    <path d="M3.51 15a9 9 0 1 0 .49-3.51"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $submissions->getCollection()->where('status','returned')->count() }}</p>
                <p class="stat-label">Dikembalikan</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#ea580c" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="20" x2="18" y2="10"/>
                    <line x1="12" y1="20" x2="12" y2="4"/>
                    <line x1="6"  y1="20" x2="6"  y2="14"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $avgNilai ? number_format($avgNilai,1) : '—' }}</p>
                <p class="stat-label">Rata-rata Nilai</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.assignment-submissions.index') }}" class="filter-card">
        <svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
        </svg>
        <input type="text" name="search" class="filter-input"
               placeholder="Cari nama siswa atau judul tugas…"
               value="{{ request('search') }}">
        <div class="filter-sep"></div>
        <select name="assignment_id" class="filter-select">
            <option value="">Semua Tugas</option>
            @foreach($assignments as $assignment)
                <option value="{{ $assignment->id }}" {{ request('assignment_id') == $assignment->id ? 'selected' : '' }}>
                    {{ $assignment->judul }}
                </option>
            @endforeach
        </select>
        <select name="status" class="filter-select">
            <option value="">Semua Status</option>
            <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
            <option value="graded"    {{ request('status') === 'graded'    ? 'selected' : '' }}>Graded</option>
            <option value="returned"  {{ request('status') === 'returned'  ? 'selected' : '' }}>Returned</option>
        </select>
        <button type="submit" class="btn btn-ghost btn-sm">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            Terapkan
        </button>
        @if(request()->hasAny(['search','assignment_id','status']))
            <a href="{{ route('admin.assignment-submissions.index') }}" class="btn btn-ghost btn-sm">Reset</a>
        @endif
    </form>

    {{-- Bulk Form --}}
    <form id="bulkForm" method="POST" action="{{ route('admin.assignment-submissions.bulkDelete') }}">
        @csrf @method('DELETE')

        <div id="bulkBar" class="bulk-bar">
            <svg width="14" height="14" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span class="bulk-bar-text"><span id="bulkCount">0</span> submission dipilih</span>
            <div style="flex:1"></div>
            <button type="button" class="btn btn-success btn-sm" onclick="openBulkGrade()">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Nilai Terpilih
            </button>
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
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
                <p class="table-title">Daftar Submission Tugas</p>
                @if($submissions->total())
                    <span class="table-badge">{{ $submissions->total() }} submission</span>
                @endif
            </div>

            @if($submissions->count())
                <table class="main-table">
                    <thead>
                        <tr>
                            <th style="width:40px">
                                <input type="checkbox" class="cb" id="cbAll" onchange="toggleAll(this)">
                            </th>
                            <th>Siswa</th>
                            <th>Judul Tugas</th>
                            <th>File</th>
                            <th class="center">Nilai</th>
                            <th class="center">Status</th>
                            <th>Dikumpulkan</th>
                            <th class="center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $submission)
                            @php
                                $nilai = $submission->nilai;
                                if (is_null($nilai)) {
                                    $nilaiClass = 'nilai-na';
                                    $nilaiText  = 'Belum';
                                } elseif ($nilai >= 90) {
                                    $nilaiClass = 'nilai-a';
                                    $nilaiText  = $nilai;
                                } elseif ($nilai >= 75) {
                                    $nilaiClass = 'nilai-b';
                                    $nilaiText  = $nilai;
                                } elseif ($nilai >= 60) {
                                    $nilaiClass = 'nilai-c';
                                    $nilaiText  = $nilai;
                                } else {
                                    $nilaiClass = 'nilai-d';
                                    $nilaiText  = $nilai;
                                }

                                $statusMap = [
                                    'submitted' => ['class' => 'status-submitted', 'label' => 'Submitted'],
                                    'graded'    => ['class' => 'status-graded',    'label' => 'Graded'],
                                    'returned'  => ['class' => 'status-returned',  'label' => 'Returned'],
                                ];
                                $statusInfo = $statusMap[$submission->status] ?? ['class' => 'status-submitted', 'label' => ucfirst($submission->status)];
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" class="cb row-cb" name="ids[]"
                                           value="{{ $submission->id }}" onchange="updateBulk()">
                                </td>

                                {{-- Siswa --}}
                                <td>
                                    @if($submission->student)
                                        <div class="student-mini">
                                            <div class="student-avatar">
                                                @if($submission->student->foto ?? null)
                                                    <img src="{{ asset('storage/'.$submission->student->foto) }}" alt="">
                                                @else
                                                    {{ strtoupper(substr($submission->student->nama_lengkap, 0, 1)) }}
                                                @endif
                                            </div>
                                            <div>
                                                <p class="student-name">{{ $submission->student->nama_lengkap }}</p>
                                                <p class="student-nisn">{{ $submission->student->nisn ?? '—' }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <span style="color:var(--text3);font-style:italic;font-size:13px">—</span>
                                    @endif
                                </td>

                                {{-- Judul Tugas --}}
                                <td>
                                    @if($submission->assignment)
                                        <div class="sub-cell">
                                            <div class="sub-icon">
                                                <svg width="15" height="15" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                                    <polyline points="14 2 14 8 20 8"/>
                                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <a href="{{ route('admin.assignment-submissions.show', $submission->id) }}" class="sub-link">
                                                    {{ Str::limit($submission->assignment->judul, 32) }}
                                                </a>
                                                @if($submission->assignment->subject)
                                                    <p class="sub-meta">{{ $submission->assignment->subject->nama_mapel }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <span style="color:var(--text3);font-style:italic;font-size:13px">—</span>
                                    @endif
                                </td>

                                {{-- File --}}
                                <td>
                                    @if($submission->file_path)
                                        <span class="file-chip">
                                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                                <polyline points="14 2 14 8 20 8"/>
                                            </svg>
                                            {{ pathinfo($submission->file_path, PATHINFO_EXTENSION) ? strtoupper(pathinfo($submission->file_path, PATHINFO_EXTENSION)) : 'File' }}
                                        </span>
                                    @else
                                        <span style="color:var(--text3);font-style:italic;font-size:13px">Tidak ada</span>
                                    @endif
                                </td>

                                {{-- Nilai --}}
                                <td class="center">
                                    <span class="nilai-pill {{ $nilaiClass }}">{{ $nilaiText }}</span>
                                </td>

                                {{-- Status --}}
                                <td class="center">
                                    <span class="status-badge {{ $statusInfo['class'] }}">
                                        <span class="dot"></span>
                                        {{ $statusInfo['label'] }}
                                    </span>
                                </td>

                                {{-- Dikumpulkan --}}
                                <td>
                                    @if($submission->submitted_at)
                                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)">
                                            {{ \Carbon\Carbon::parse($submission->submitted_at)->translatedFormat('d M Y') }}
                                        </span>
                                        <p style="font-size:11.5px;color:var(--text3);margin-top:1px">
                                            {{ \Carbon\Carbon::parse($submission->submitted_at)->translatedFormat('H:i') }} WIB
                                        </p>
                                    @else
                                        <span style="color:var(--text3);font-style:italic;font-size:13px">—</span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="center">
                                    <div class="actions-cell">
                                        {{-- Detail --}}
                                        <a href="{{ route('admin.assignment-submissions.show', $submission->id) }}"
                                           class="btn btn-ghost btn-sm btn-icon" title="Detail">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                        </a>

                                        {{-- Beri Nilai --}}
                                        <button type="button"
                                                class="btn btn-grade-sm btn-sm btn-icon" title="Beri Nilai"
                                                data-id="{{ $submission->id }}"
                                                data-nama="{{ $submission->student->nama_lengkap ?? '' }}"
                                                data-nilai="{{ $submission->nilai ?? '' }}"
                                                onclick="openGradeModal(this)">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                        </button>

                                        {{-- Download --}}
                                        @if($submission->file_path)
                                            <a href="{{ route('admin.assignment-submissions.download', $submission->id) }}"
                                               class="btn btn-dl-sm btn-sm btn-icon" title="Download">
                                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                                    <polyline points="7 10 12 15 17 10"/>
                                                    <line x1="12" y1="15" x2="12" y2="3"/>
                                                </svg>
                                            </a>
                                        @endif

                                        {{-- Hapus --}}
                                        <button type="button"
                                                class="btn btn-del-sm btn-sm btn-icon" title="Hapus"
                                                data-id="{{ $submission->id }}"
                                                data-nama="{{ $submission->student->nama_lengkap ?? 'submission ini' }}"
                                                onclick="confirmDelete(this)">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6l-1 14H6L5 6"/>
                                                <path d="M10 11v6m4-6v6M9 6V4h6v2"/>
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Hidden delete form --}}
                                    <form id="del-{{ $submission->id }}" method="POST"
                                          action="{{ route('admin.assignment-submissions.destroy', $submission->id) }}" style="display:none">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if($submissions->hasPages())
                    <div class="pagination-wrap">
                        <p class="pagination-info">
                            Menampilkan {{ $submissions->firstItem() }}–{{ $submissions->lastItem() }}
                            dari {{ $submissions->total() }} submission
                        </p>
                        <div class="pagination-links">
                            @if($submissions->onFirstPage())
                                <span class="page-link disabled">‹</span>
                            @else
                                <a class="page-link" href="{{ $submissions->previousPageUrl() }}">‹</a>
                            @endif
                            @foreach($submissions->getUrlRange(1, $submissions->lastPage()) as $page => $url)
                                <a class="page-link {{ $page == $submissions->currentPage() ? 'active' : '' }}"
                                   href="{{ $url }}">{{ $page }}</a>
                            @endforeach
                            @if($submissions->hasMorePages())
                                <a class="page-link" href="{{ $submissions->nextPageUrl() }}">›</a>
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
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                    </div>
                    <p class="empty-title">Tidak ada submission ditemukan</p>
                    <p class="empty-sub">
                        @if(request()->hasAny(['search','assignment_id','status']))
                            Coba ubah kata kunci atau filter pencarian
                        @else
                            Belum ada siswa yang mengumpulkan tugas
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </form>

</div>

{{-- Grade Modal --}}
<div class="modal-overlay" id="gradeModal">
    <div class="modal-box">
        <p class="modal-title">Beri Nilai Submission</p>
        <form id="gradeForm" method="POST">
            @csrf @method('PATCH')
            <div class="form-group">
                <label class="form-label">Siswa</label>
                <p id="gradeStudentName" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text);"></p>
            </div>
            <div class="form-group">
                <label class="form-label" for="inputNilai">Nilai (0–100)</label>
                <input type="number" id="inputNilai" name="nilai" min="0" max="100"
                       class="form-input" placeholder="Masukkan nilai…">
            </div>
            <div class="form-group">
                <label class="form-label" for="inputStatus">Status</label>
                <select name="status" id="inputStatus" class="form-input" style="appearance:none;cursor:pointer;">
                    <option value="graded">Graded</option>
                    <option value="returned">Returned</option>
                </select>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-ghost btn-sm" onclick="closeGradeModal()">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan Nilai</button>
            </div>
        </form>
    </div>
</div>

{{-- Bulk Grade Modal --}}
<div class="modal-overlay" id="bulkGradeModal">
    <div class="modal-box">
        <p class="modal-title">Nilai Submission Terpilih</p>
        <form id="bulkGradeForm" method="POST" action="{{ route('admin.assignment-submissions.bulkGrade') }}">
            @csrf
            <div id="bulkGradeIds"></div>
            <div class="form-group">
                <label class="form-label" for="bulkNilai">Nilai (0–100)</label>
                <input type="number" id="bulkNilai" name="nilai" min="0" max="100"
                       class="form-input" placeholder="Masukkan nilai…">
            </div>
            <div class="form-group">
                <label class="form-label" for="bulkStatus">Status</label>
                <select name="status" id="bulkStatus" class="form-input" style="appearance:none;cursor:pointer;">
                    <option value="graded">Graded</option>
                    <option value="returned">Returned</option>
                </select>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-ghost btn-sm" onclick="closeBulkGrade()">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan Semua</button>
            </div>
        </form>
    </div>
</div>

<script>
    /* ---- Bulk selection ---- */
    function updateBulk() {
        const cbs     = document.querySelectorAll('.row-cb');
        const checked = document.querySelectorAll('.row-cb:checked');
        document.getElementById('cbAll').indeterminate = checked.length > 0 && checked.length < cbs.length;
        document.getElementById('cbAll').checked = checked.length === cbs.length && cbs.length > 0;
        const bar  = document.getElementById('bulkBar');
        const bDel = document.getElementById('btnBulkDelete');
        const bGr  = document.getElementById('btnBulkGrade');
        if (checked.length > 0) {
            bar.classList.add('visible');
            if (bDel) bDel.style.display = 'inline-flex';
            if (bGr)  bGr.style.display  = 'inline-flex';
        } else {
            bar.classList.remove('visible');
            if (bDel) bDel.style.display = 'none';
            if (bGr)  bGr.style.display  = 'none';
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

    /* ---- Delete single ---- */
    function confirmDelete(btn) {
        const id   = btn.dataset.id;
        const nama = btn.dataset.nama;
        Swal.fire({
            title: 'Hapus Submission?',
            html: `Submission dari <b>${nama}</b> akan dihapus permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
        }).then(r => { if (r.isConfirmed) document.getElementById('del-' + id).submit(); });
    }

    /* ---- Bulk delete ---- */
    function confirmBulkDelete() {
        const count = document.querySelectorAll('.row-cb:checked').length;
        if (!count) return;
        Swal.fire({
            title: 'Hapus ' + count + ' Submission?',
            text: 'Semua submission yang dipilih akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus Semua',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
        }).then(r => { if (r.isConfirmed) document.getElementById('bulkForm').submit(); });
    }

    /* ---- Grade single modal ---- */
    function openGradeModal(btn) {
        const id    = btn.dataset.id;
        const nama  = btn.dataset.nama;
        const nilai = btn.dataset.nilai;
        document.getElementById('gradeStudentName').textContent = nama;
        document.getElementById('inputNilai').value  = nilai || '';
        document.getElementById('gradeForm').action  =
            '{{ url("admin/assignment-submissions") }}/' + id + '/grade';
        document.getElementById('gradeModal').classList.add('open');
    }
    function closeGradeModal() {
        document.getElementById('gradeModal').classList.remove('open');
    }
    document.getElementById('gradeModal').addEventListener('click', function(e) {
        if (e.target === this) closeGradeModal();
    });

    /* ---- Bulk grade modal ---- */
    function openBulkGrade() {
        const checked = document.querySelectorAll('.row-cb:checked');
        if (!checked.length) return;
        const container = document.getElementById('bulkGradeIds');
        container.innerHTML = '';
        checked.forEach(cb => {
            const input = document.createElement('input');
            input.type  = 'hidden';
            input.name  = 'ids[]';
            input.value = cb.value;
            container.appendChild(input);
        });
        document.getElementById('bulkNilai').value = '';
        document.getElementById('bulkGradeModal').classList.add('open');
    }
    function closeBulkGrade() {
        document.getElementById('bulkGradeModal').classList.remove('open');
    }
    document.getElementById('bulkGradeModal').addEventListener('click', function(e) {
        if (e.target === this) closeBulkGrade();
    });
</script>

</x-app-layout>