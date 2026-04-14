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
        --radius:     10px;
        --radius-sm:  7px;
        --danger:     #dc2626;
        --danger-50:  #fee2e2;
        --danger-100: #fecaca;
        --success:    #16a34a;
        --success-50: #f0fdf4;
        --success-100:#dcfce7;
        --warn:       #d97706;
        --warn-50:    #fffbeb;
        --warn-100:   #fef3c7;
    }

    .page { padding: 28px 28px 60px; max-width: 5000px; margin: 0 auto; }

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
        gap: 16px; margin-bottom: 20px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .header-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }

    /* ── Stat cards ── */
    .stats-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 20px; }
    .stat-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 16px 18px;
    }
    .stat-label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
        color: var(--text3); text-transform: uppercase; letter-spacing: .06em; margin-bottom: 6px;
    }
    .stat-value { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 24px; font-weight: 800; color: var(--text); line-height: 1; }
    .stat-sub   { font-size: 11.5px; color: var(--text3); margin-top: 4px; }

    /* ── Buttons ── */
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 14px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: background .15s; white-space: nowrap;
    }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { background: var(--brand-h); }
    .btn-ghost   { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }
    .btn-info    { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-info:hover { background: var(--brand-100); }
    .btn-danger  { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .btn-danger:hover { background: var(--danger-100); }

    /* ── Filter card ── */
    .filter-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); margin-bottom: 16px; overflow: hidden; }
    .filter-header {
        display: flex; align-items: center; gap: 8px;
        padding: 11px 16px; border-bottom: 1px solid var(--border); background: var(--surface2);
    }
    .filter-header-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .07em; }
    .filter-body { padding: 14px 16px; display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 10px; align-items: end; }
    .f-group { display: flex; flex-direction: column; gap: 5px; }
    .f-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--text2); }
    .f-input, .f-select {
        font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text);
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 8px 11px; outline: none; width: 100%;
        transition: border-color .15s;
    }
    .f-input:focus, .f-select:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(31,99,219,.08); }
    .f-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg width='11' height='11' fill='none' stroke='%2394a3b8' stroke-width='2' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 10px center; padding-right: 28px; cursor: pointer;
    }

    /* ── Table card ── */
    .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .table-top {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 16px; border-bottom: 1px solid var(--border); background: var(--surface2); gap: 10px; flex-wrap: wrap;
    }
    .table-top-left { display: flex; align-items: center; gap: 8px; }
    .table-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .07em; }
    .table-count {
        background: var(--brand-50); color: var(--brand-700);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
        padding: 2px 8px; border-radius: 20px; border: 1px solid var(--brand-100);
    }
    .bulk-bar { display: none; align-items: center; gap: 8px; }
    .bulk-bar.visible { display: flex; }
    .bulk-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2); }

    table { width: 100%; border-collapse: collapse; }
    thead tr { background: var(--surface2); border-bottom: 1px solid var(--border); }
    thead th {
        padding: 10px 14px; text-align: left;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3);
        white-space: nowrap;
    }
    thead th.center { text-align: center; }
    tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: var(--surface2); }
    tbody td { padding: 11px 14px; color: var(--text); font-family: 'DM Sans', sans-serif; font-size: 13px; vertical-align: middle; }
    tbody td.center { text-align: center; }

    .student-info { display: flex; align-items: center; gap: 10px; }
    .avatar {
        width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
        background: var(--brand-50); border: 1px solid var(--brand-100);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 800; color: var(--brand-700);
    }
    .student-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .student-nisn { font-size: 11.5px; color: var(--text3); }
    .student-class {
        display: inline-block; margin-top: 2px;
        background: var(--surface3); color: var(--text2);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 10.5px; font-weight: 700;
        padding: 1px 6px; border-radius: 4px; border: 1px solid var(--border);
    }

    .score-cell { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 13.5px; }
    .score-a { color: var(--success); }
    .score-b { color: var(--brand); }
    .score-c { color: var(--warn); }
    .score-d { color: var(--danger); }

    .badge {
        display: inline-flex; align-items: center;
        padding: 3px 9px; border-radius: 20px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
    }
    .badge-success { background: var(--success-50); color: var(--success); border: 1px solid var(--success-100); }
    .badge-danger  { background: var(--danger-50);  color: var(--danger);  border: 1px solid var(--danger-100); }
    .badge-warn    { background: var(--warn-50);    color: var(--warn);    border: 1px solid var(--warn-100); }

    .action-btns { display: flex; gap: 5px; align-items: center; }
    .icon-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: 7px;
        border: 1px solid var(--border); background: var(--surface2);
        cursor: pointer; transition: background .15s; text-decoration: none; color: var(--text2);
    }
    .icon-btn:hover { background: var(--surface3); }
    .icon-btn.view:hover { background: var(--brand-50); border-color: var(--brand-100); color: var(--brand); }
    .icon-btn.edit:hover { background: var(--warn-50); border-color: var(--warn-100); color: var(--warn); }
    .icon-btn.del:hover  { background: var(--danger-50); border-color: var(--danger-100); color: var(--danger); }

    .cb { width: 15px; height: 15px; accent-color: var(--brand); cursor: pointer; }

    /* ── Empty state ── */
    .empty-state { padding: 56px 20px; text-align: center; }
    .empty-icon {
        width: 52px; height: 52px; border-radius: 14px;
        background: var(--surface2); border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;
    }
    .empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 800; color: var(--text); margin-bottom: 6px; }
    .empty-sub   { font-size: 13px; color: var(--text3); margin-bottom: 18px; }

    /* ── Pagination ── */
    .pagination {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 16px; border-top: 1px solid var(--border); background: var(--surface2); flex-wrap: wrap; gap: 10px;
    }
    .page-info { font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--text3); }

    @media(max-width:900px) {
        .stats-row { grid-template-columns: repeat(2,1fr); }
        .filter-body { grid-template-columns: 1fr 1fr; }
    }
    @media(max-width:600px) {
        .stats-row { grid-template-columns: 1fr 1fr; }
        .filter-body { grid-template-columns: 1fr; }
        .page { padding: 16px 16px 40px; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <span>LMS</span>
        <span class="sep">›</span>
        <span class="current">Nilai Siswa</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Nilai Siswa</h1>
            <p class="page-sub">Kelola data nilai tugas, UTS, dan UAS seluruh siswa</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.grades.monitoring') }}" class="btn btn-info">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                </svg>
                Monitoring
            </a>
            <a href="{{ route('admin.grades.create') }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Nilai
            </a>
        </div>
    </div>

    {{-- Stats --}}
    @php
        $total     = $grades->total();
        $allGrades = \App\Models\Grade::when(request('subject_id'), fn($q)=>$q->where('subject_id',request('subject_id')))->when(request('class_id'), fn($q)=>$q->whereHas('student',fn($s)=>$s->where('class_id',request('class_id'))))->get();
        $avgAkhir  = round($allGrades->avg('nilai_akhir'), 1);
        $lulus     = $allGrades->where('nilai_akhir','>=',75)->count();
        $tkLulus   = $allGrades->where('nilai_akhir','<',75)->count();
    @endphp
    <div class="stats-row">
        <div class="stat-card">
            <p class="stat-label">Total Nilai</p>
            <p class="stat-value">{{ $total }}</p>
            <p class="stat-sub">entri data</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Rata-rata Akhir</p>
            <p class="stat-value" style="color:var(--brand)">{{ $avgAkhir ?: '—' }}</p>
            <p class="stat-sub">dari 100</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Lulus (≥75)</p>
            <p class="stat-value" style="color:var(--success)">{{ $lulus }}</p>
            <p class="stat-sub">{{ $total ? round($lulus/$total*100,1) : 0 }}% siswa</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Tidak Lulus</p>
            <p class="stat-value" style="color:var(--danger)">{{ $tkLulus }}</p>
            <p class="stat-sub">{{ $total ? round($tkLulus/$total*100,1) : 0 }}% siswa</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <div class="filter-header">
            <svg width="12" height="12" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
            </svg>
            <p class="filter-header-title">Filter & Pencarian</p>
        </div>
        <form method="GET" action="{{ route('admin.grades.index') }}">
            <div class="filter-body">
                <div class="f-group">
                    <label class="f-label">Cari Siswa</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="f-input" placeholder="Nama atau NISN siswa…">
                </div>
                <div class="f-group">
                    <label class="f-label">Mata Pelajaran</label>
                    <select name="subject_id" class="f-select">
                        <option value="">— Semua Mapel —</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="f-group">
                    <label class="f-label">Kelas</label>
                    <select name="class_id" class="f-select">
                        <option value="">— Semua Kelas —</option>
                        @foreach($classes as $cls)
                            <option value="{{ $cls->id }}" {{ request('class_id') == $cls->id ? 'selected' : '' }}>
                                {{ $cls->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="f-group">
                    <label class="f-label">Guru</label>
                    <select name="teacher_id" class="f-select">
                        <option value="">— Semua Guru —</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="f-group">
                    <button type="submit" class="btn btn-primary" style="height:37px">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <form method="POST" action="{{ route('admin.grades.bulkDelete') }}" id="bulkForm">
        @csrf @method('DELETE')

        <div class="table-card">
            <div class="table-top">
                <div class="table-top-left">
                    <p class="table-title">Daftar Nilai</p>
                    <span class="table-count">{{ $total }} data</span>
                </div>
                <div class="bulk-bar" id="bulkBar">
                    <span class="bulk-label" id="bulkCount">0 dipilih</span>
                    <button type="button" class="btn btn-danger" onclick="confirmBulkDelete()">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        </svg>
                        Hapus Terpilih
                    </button>
                </div>
            </div>

            @if($grades->count())
            <table>
                <thead>
                    <tr>
                        <th style="width:40px">
                            <input type="checkbox" class="cb" id="cbAll" onchange="toggleAll(this)">
                        </th>
                        <th>#</th>
                        <th>Siswa</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru</th>
                        <th class="center">Tugas</th>
                        <th class="center">UTS</th>
                        <th class="center">UAS</th>
                        <th class="center">Nilai Akhir</th>
                        <th class="center">Status</th>
                        <th class="center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grades as $i => $grade)
                    @php
                        $na     = $grade->nilai_akhir ?? 0;
                        $cls    = $na >= 90 ? 'score-a' : ($na >= 75 ? 'score-b' : ($na >= 60 ? 'score-c' : 'score-d'));
                        $initials = collect(explode(' ', $grade->student->name ?? 'S'))->map(fn($w)=>strtoupper($w[0]))->take(2)->implode('');
                    @endphp
                    <tr>
                        <td>
                            <input type="checkbox" class="cb cb-row" name="ids[]" value="{{ $grade->id }}" onchange="updateBulk()">
                        </td>
                        <td style="color:var(--text3); font-size:12px; font-weight:700">
                            {{ ($grades->currentPage()-1) * $grades->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <div class="student-info">
                                <div class="avatar">{{ $initials }}</div>
                                <div>
                                    <p class="student-name">{{ $grade->student->name ?? '—' }}</p>
                                    <p class="student-nisn">{{ $grade->student->nisn ?? '—' }}</p>
                                    @if($grade->student->class)
                                        <span class="student-class">{{ $grade->student->class->nama_kelas }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="font-weight:600; color:var(--text2)">
                            {{ $grade->subject->nama_mapel ?? '—' }}
                        </td>
                        <td style="color:var(--text2)">
                            {{ $grade->teacher->nama_lengkap ?? '—' }}
                        </td>
                        <td class="center">
                            <span class="score-cell {{ $grade->nilai_tugas >= 75 ? 'score-b' : 'score-c' }}">
                                {{ $grade->nilai_tugas ?? '—' }}
                            </span>
                        </td>
                        <td class="center">
                            <span class="score-cell {{ $grade->nilai_uts >= 75 ? 'score-b' : 'score-c' }}">
                                {{ $grade->nilai_uts ?? '—' }}
                            </span>
                        </td>
                        <td class="center">
                            <span class="score-cell {{ $grade->nilai_uas >= 75 ? 'score-b' : 'score-c' }}">
                                {{ $grade->nilai_uas ?? '—' }}
                            </span>
                        </td>
                        <td class="center">
                            <span class="score-cell {{ $cls }}" style="font-size:15px">
                                {{ number_format($na, 2) }}
                            </span>
                        </td>
                        <td class="center">
                            @if($na >= 75)
                                <span class="badge badge-success">Lulus</span>
                            @else
                                <span class="badge badge-danger">Tidak Lulus</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-btns" style="justify-content:center">
                                <a href="{{ route('admin.grades.show', $grade->id) }}" class="icon-btn view" title="Detail">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.grades.edit', $grade->id) }}" class="icon-btn edit" title="Edit">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </a>
                                <button type="button" class="icon-btn del" title="Hapus"
                                    onclick="confirmDelete({{ $grade->id }})">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                        <path d="M10 11v6M14 11v6"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </div>
                <p class="empty-title">Belum ada data nilai</p>
                <p class="empty-sub">Mulai tambah nilai siswa untuk ditampilkan di sini.</p>
                <a href="{{ route('admin.grades.create') }}" class="btn btn-primary">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Tambah Nilai
                </a>
            </div>
            @endif

            {{-- Pagination --}}
            @if($grades->hasPages())
            <div class="pagination">
                <p class="page-info">
                    Menampilkan {{ $grades->firstItem() }}–{{ $grades->lastItem() }} dari {{ $grades->total() }} data
                </p>
                {{ $grades->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </form>

    {{-- Hidden delete form --}}
    <form method="POST" id="deleteForm" style="display:none">
        @csrf @method('DELETE')
    </form>

</div>

<script>
    function toggleAll(cb) {
        document.querySelectorAll('.cb-row').forEach(c => c.checked = cb.checked);
        updateBulk();
    }

    function updateBulk() {
        const checked = document.querySelectorAll('.cb-row:checked').length;
        const bar = document.getElementById('bulkBar');
        bar.classList.toggle('visible', checked > 0);
        document.getElementById('bulkCount').textContent = checked + ' dipilih';
        document.getElementById('cbAll').indeterminate =
            checked > 0 && checked < document.querySelectorAll('.cb-row').length;
    }

    function confirmBulkDelete() {
        const count = document.querySelectorAll('.cb-row:checked').length;
        Swal.fire({
            icon: 'warning',
            title: `Hapus ${count} data nilai?`,
            text: 'Tindakan ini tidak dapat dibatalkan.',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('bulkForm').submit(); });
    }

    function confirmDelete(id) {
        Swal.fire({
            icon: 'warning',
            title: 'Hapus data nilai?',
            text: 'Tindakan ini tidak dapat dibatalkan.',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
        }).then(r => {
            if (r.isConfirmed) {
                const f = document.getElementById('deleteForm');
                f.action = `/admin/grades/${id}`;
                f.submit();
            }
        });
    }
</script>
</x-app-layout>