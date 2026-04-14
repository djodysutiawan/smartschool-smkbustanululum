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
        --warn:       #d97706;
        --warn-50:    #fef3c7;
        --warn-100:   #fde68a;
        --purple:     #7c3aed;
        --purple-50:  #f3e8ff;
        --purple-100: #e9d5ff;
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

    /* Stats Row */
    .stats-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 20px; }
    .stat-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 16px 18px;
        display: flex; align-items: center; gap: 14px;
    }
    .stat-icon { width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
    .stat-icon.blue   { background: var(--brand-50); }
    .stat-icon.green  { background: var(--success-50); }
    .stat-icon.yellow { background: var(--warn-50); }
    .stat-icon.purple { background: var(--purple-50); }
    .stat-icon.red    { background: var(--danger-50); }
    .stat-num   { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: var(--text); line-height: 1; }
    .stat-label { font-size: 12px; color: var(--text3); margin-top: 3px; font-family: 'DM Sans', sans-serif; }

    /* Sub stats row */
    .sub-stats-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 24px; }
    .sub-stat-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 13px 16px;
        display: flex; align-items: center; justify-content: space-between;
    }
    .sub-stat-label { font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--text2); }
    .sub-stat-val   { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-weight: 800; }
    .sub-stat-val.blue   { color: var(--brand); }
    .sub-stat-val.green  { color: var(--success); }
    .sub-stat-val.yellow { color: var(--warn); }
    .sub-stat-val.red    { color: var(--danger); }

    /* Grid layout */
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
    .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px; }

    /* Card */
    .card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
    }
    .card-header {
        display: flex; align-items: center; gap: 10px;
        padding: 13px 18px; border-bottom: 1px solid var(--border);
        background: var(--surface2);
    }
    .card-title {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
        color: var(--text3); letter-spacing: .07em; text-transform: uppercase; flex: 1;
    }
    .card-badge {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
        border-radius: 99px; padding: 2px 8px;
    }
    .badge-blue   { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .badge-green  { background: var(--success-50); color: var(--success); border: 1px solid var(--success-100); }
    .badge-yellow { background: var(--warn-50); color: var(--warn); border: 1px solid var(--warn-100); }
    .badge-red    { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .badge-purple { background: var(--purple-50); color: var(--purple); border: 1px solid var(--purple-100); }

    /* List items */
    .list-item {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 18px; border-bottom: 1px solid var(--border);
        transition: background .12s;
    }
    .list-item:last-child { border-bottom: none; }
    .list-item:hover { background: var(--surface2); }

    .item-icon {
        width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .item-icon.blue   { background: var(--brand-50); border: 1px solid var(--brand-100); }
    .item-icon.green  { background: var(--success-50); border: 1px solid var(--success-100); }
    .item-icon.yellow { background: var(--warn-50); border: 1px solid var(--warn-100); }
    .item-icon.purple { background: var(--purple-50); border: 1px solid var(--purple-100); }
    .item-icon.red    { background: var(--danger-50); border: 1px solid var(--danger-100); }

    .item-main { flex: 1; min-width: 0; }
    .item-title {
        font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
        font-size: 13px; color: var(--text); white-space: nowrap;
        overflow: hidden; text-overflow: ellipsis;
    }
    .item-title a { color: inherit; text-decoration: none; }
    .item-title a:hover { color: var(--brand); }
    .item-sub { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: 2px; }

    .item-meta { text-align: right; flex-shrink: 0; }
    .item-meta-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text2); }
    .item-meta-sub { font-size: 11px; color: var(--text3); font-family: 'DM Sans', sans-serif; margin-top: 1px; }

    /* Status badges */
    .status-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
    }
    .status-graded    { background: var(--success-50); color: var(--success); border: 1px solid var(--success-100); }
    .status-submitted { background: var(--warn-50); color: var(--warn); border: 1px solid var(--warn-100); }
    .status-late      { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }

    /* Progress bar */
    .progress-wrap { width: 100%; margin-top: 6px; }
    .progress-bar-bg { width: 100%; height: 5px; background: var(--surface3); border-radius: 99px; overflow: hidden; }
    .progress-bar-fill { height: 100%; border-radius: 99px; transition: width .3s; }
    .progress-bar-fill.blue   { background: var(--brand); }
    .progress-bar-fill.green  { background: var(--success); }
    .progress-bar-fill.yellow { background: var(--warn); }

    /* Exam date badge */
    .date-badge {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        width: 40px; height: 40px; border-radius: 8px; flex-shrink: 0;
        background: var(--brand-50); border: 1px solid var(--brand-100);
    }
    .date-badge-day  { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 800; color: var(--brand); line-height: 1; }
    .date-badge-mon  { font-family: 'DM Sans', sans-serif; font-size: 10px; color: var(--brand-700); text-transform: uppercase; letter-spacing: .04em; }
    .date-badge.today { background: var(--success-50); border-color: var(--success-100); }
    .date-badge.today .date-badge-day,
    .date-badge.today .date-badge-mon { color: var(--success); }

    /* Teacher avatar */
    .avatar-sm {
        width: 24px; height: 24px; border-radius: 6px; flex-shrink: 0;
        background: var(--surface3); border: 1px solid var(--border2);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 10px;
        font-weight: 800; color: var(--text2); overflow: hidden;
    }
    .avatar-sm img { width: 100%; height: 100%; object-fit: cover; }

    /* Empty */
    .empty-mini {
        display: flex; flex-direction: column; align-items: center;
        padding: 28px 16px; gap: 6px;
    }
    .empty-mini p { font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text3); }

    /* Pending table */
    .main-table { width: 100%; border-collapse: collapse; }
    .main-table th {
        padding: 9px 14px; text-align: left;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px;
        font-weight: 700; color: var(--text3); letter-spacing: .06em; text-transform: uppercase;
        background: var(--surface2); border-bottom: 1px solid var(--border);
    }
    .main-table td {
        padding: 11px 14px; font-family: 'DM Sans', sans-serif;
        font-size: 13px; color: var(--text);
        border-bottom: 1px solid var(--border); vertical-align: middle;
    }
    .main-table tr:last-child td { border-bottom: none; }
    .main-table tr:hover td { background: var(--surface2); }

    /* Btn */
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 14px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: background .15s; white-space: nowrap;
    }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { background: var(--brand-h); }
    .btn-ghost   { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }
    .btn-sm { padding: 5px 11px; font-size: 12px; }
    .btn-warn { background: var(--warn-50); color: var(--warn); border: 1px solid var(--warn-100); }
    .btn-warn:hover { background: var(--warn-100); }
    .btn-success { background: var(--success-50); color: var(--success); border: 1px solid var(--success-100); }
    .btn-success:hover { background: var(--success-100); }

    /* View all link */
    .view-all {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
        color: var(--brand); text-decoration: none; transition: color .15s;
    }
    .view-all:hover { color: var(--brand-h); }

    @media (max-width: 1100px) { .grid-3 { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 900px)  { .stats-row, .sub-stats-row { grid-template-columns: repeat(2,1fr); } .grid-2, .grid-3 { grid-template-columns: 1fr; } }
    @media (max-width: 600px)  { .page { padding: 16px 16px 40px; } }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <span class="current">Monitoring LMS</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Monitoring LMS</h1>
            <p class="page-sub">Pantau aktivitas pembelajaran — materi, tugas, ujian, dan nilai siswa</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
            <a href="{{ route('admin.materials.index') }}" class="btn btn-ghost btn-sm">Materi</a>
            <a href="{{ route('admin.assignments.index') }}" class="btn btn-ghost btn-sm">Tugas</a>
            <a href="{{ route('admin.exams.index') }}" class="btn btn-ghost btn-sm">Ujian</a>
            <a href="{{ route('admin.grades.index') }}" class="btn btn-primary btn-sm">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                </svg>
                Nilai
            </a>
        </div>
    </div>

    {{-- Main Stats --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $stats['total_materi'] }}</p>
                <p class="stat-label">Total Materi</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $stats['total_tugas'] }}</p>
                <p class="stat-label">Total Tugas</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $stats['total_ujian'] }}</p>
                <p class="stat-label">Total Ujian</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $stats['total_submission'] }}</p>
                <p class="stat-label">Total Pengumpulan</p>
            </div>
        </div>
    </div>

    {{-- Sub Stats --}}
    <div class="sub-stats-row">
        <div class="sub-stat-card">
            <div>
                <p class="sub-stat-label">Sudah Dinilai</p>
                @php $pct = $stats['total_submission'] > 0 ? round($stats['submission_graded']/$stats['total_submission']*100) : 0; @endphp
                <div class="progress-wrap">
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill green" style="width:{{ $pct }}%"></div>
                    </div>
                </div>
            </div>
            <p class="sub-stat-val green">{{ $stats['submission_graded'] }}</p>
        </div>
        <div class="sub-stat-card">
            <div>
                <p class="sub-stat-label">Tugas Aktif</p>
                <div class="progress-wrap">
                    <div class="progress-bar-bg">
                        @php $pctAktif = $stats['total_tugas'] > 0 ? round($stats['tugas_aktif']/$stats['total_tugas']*100) : 0; @endphp
                        <div class="progress-bar-fill blue" style="width:{{ $pctAktif }}%"></div>
                    </div>
                </div>
            </div>
            <p class="sub-stat-val blue">{{ $stats['tugas_aktif'] }}</p>
        </div>
        <div class="sub-stat-card">
            <div>
                <p class="sub-stat-label">Tugas Kadaluarsa</p>
                <div class="progress-wrap">
                    <div class="progress-bar-bg">
                        @php $pctExp = $stats['total_tugas'] > 0 ? round($stats['tugas_expired']/$stats['total_tugas']*100) : 0; @endphp
                        <div class="progress-bar-fill yellow" style="width:{{ $pctExp }}%"></div>
                    </div>
                </div>
            </div>
            <p class="sub-stat-val yellow">{{ $stats['tugas_expired'] }}</p>
        </div>
        <div class="sub-stat-card">
            <div>
                <p class="sub-stat-label">Ujian Hari Ini</p>
                <div class="progress-wrap">
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill blue" style="width:{{ $stats['ujian_today'] > 0 ? 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
            <p class="sub-stat-val {{ $stats['ujian_today'] > 0 ? 'blue' : 'yellow' }}">{{ $stats['ujian_today'] }}</p>
        </div>
    </div>

    {{-- Row 1: Latest Assignments + Upcoming Exams --}}
    <div class="grid-2">

        {{-- Tugas Terbaru --}}
        <div class="card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                </svg>
                <p class="card-title">Tugas Terbaru</p>
                <a href="{{ route('admin.assignments.index') }}" class="view-all">Lihat semua →</a>
            </div>

            @forelse($latestAssignments as $assignment)
                <div class="list-item">
                    <div class="item-icon {{ $assignment->deadline >= now() ? 'blue' : 'red' }}">
                        <svg width="15" height="15" fill="none" stroke="{{ $assignment->deadline >= now() ? '#1f63db' : '#dc2626' }}" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 11l3 3L22 4"/>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                        </svg>
                    </div>
                    <div class="item-main">
                        <p class="item-title">
                            <a href="{{ route('admin.assignments.show', $assignment->id) }}">{{ $assignment->judul }}</a>
                        </p>
                        <div style="display:flex;align-items:center;gap:6px;margin-top:3px">
                            @if($assignment->teacher)
                                <div class="avatar-sm">
                                    @if($assignment->teacher->foto)
                                        <img src="{{ asset('storage/'.$assignment->teacher->foto) }}" alt="">
                                    @else
                                        {{ strtoupper(substr($assignment->teacher->nama_lengkap, 0, 1)) }}
                                    @endif
                                </div>
                                <span class="item-sub" style="margin-top:0">{{ $assignment->teacher->nama_lengkap }}</span>
                            @endif
                            <span class="item-sub" style="margin-top:0">·</span>
                            <span class="item-sub" style="margin-top:0">
                                Deadline: {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="item-meta">
                        <p class="item-meta-val">{{ $assignment->submissions_count }}</p>
                        <p class="item-meta-sub">pengumpulan</p>
                    </div>
                </div>
            @empty
                <div class="empty-mini">
                    <p>Belum ada tugas</p>
                </div>
            @endforelse
        </div>

        {{-- Ujian Mendatang --}}
        <div class="card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <p class="card-title">Ujian Mendatang</p>
                <span class="card-badge badge-purple">{{ $stats['ujian_upcoming'] }} ujian</span>
                <a href="{{ route('admin.exams.index') }}" class="view-all" style="margin-left:4px">Lihat semua →</a>
            </div>

            @forelse($upcomingExams as $exam)
                @php
                    $isToday = \Carbon\Carbon::parse($exam->tanggal)->isToday();
                @endphp
                <div class="list-item">
                    <div class="date-badge {{ $isToday ? 'today' : '' }}">
                        <span class="date-badge-day">{{ \Carbon\Carbon::parse($exam->tanggal)->format('d') }}</span>
                        <span class="date-badge-mon">{{ \Carbon\Carbon::parse($exam->tanggal)->format('M') }}</span>
                    </div>
                    <div class="item-main">
                        <p class="item-title">
                            <a href="{{ route('admin.exams.show', $exam->id) }}">{{ $exam->judul }}</a>
                        </p>
                        <div style="display:flex;align-items:center;gap:6px;margin-top:3px;flex-wrap:wrap">
                            @if($exam->subject)
                                <span class="status-badge badge-purple" style="font-size:10.5px;padding:2px 7px">{{ $exam->subject->nama_mapel }}</span>
                            @endif
                            @if($exam->class)
                                <span class="status-badge badge-blue" style="font-size:10.5px;padding:2px 7px">{{ $exam->class->nama_kelas }}</span>
                            @endif
                            @if($isToday)
                                <span class="status-badge status-graded" style="font-size:10.5px;padding:2px 7px">Hari ini</span>
                            @endif
                        </div>
                    </div>
                    @if($exam->teacher)
                        <div class="avatar-sm" title="{{ $exam->teacher->nama_lengkap }}">
                            @if($exam->teacher->foto)
                                <img src="{{ asset('storage/'.$exam->teacher->foto) }}" alt="">
                            @else
                                {{ strtoupper(substr($exam->teacher->nama_lengkap, 0, 1)) }}
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty-mini">
                    <p>Tidak ada ujian mendatang</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Row 2: Latest Materials + Pending Submissions --}}
    <div class="grid-2">

        {{-- Materi Terbaru --}}
        <div class="card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
                <p class="card-title">Materi Terbaru</p>
                <a href="{{ route('admin.materials.index') }}" class="view-all">Lihat semua →</a>
            </div>

            @forelse($latestMaterials as $material)
                @php
                    $ext = $material->file_path ? strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION)) : null;
                    $fileType = match(true) {
                        $ext === 'pdf'                       => 'pdf',
                        in_array($ext, ['doc','docx'])       => 'doc',
                        in_array($ext, ['ppt','pptx'])       => 'ppt',
                        in_array($ext, ['xls','xlsx'])       => 'xls',
                        $ext === 'zip'                       => 'zip',
                        in_array($ext, ['jpg','jpeg','png']) => 'img',
                        $ext !== null                        => 'other',
                        default                              => null,
                    };
                    $iconColors = ['pdf'=>'#b91c1c','doc'=>'#1d4ed8','ppt'=>'#c2410c','xls'=>'#15803d','zip'=>'#a16207','img'=>'#7c3aed','other'=>'#94a3b8'];
                    $iconColor  = $iconColors[$fileType] ?? '#94a3b8';
                @endphp
                <div class="list-item">
                    <div class="item-icon {{ $fileType ?? 'other' }}" style="background:{{ $fileType === 'pdf' ? '#fee2e2' : ($fileType === 'doc' ? '#dbeafe' : ($fileType === 'ppt' ? '#ffedd5' : ($fileType === 'xls' ? '#dcfce7' : ($fileType === 'img' ? '#f3e8ff' : 'var(--surface3)')))) }};border-color:{{ $fileType === 'pdf' ? '#fecaca' : ($fileType === 'doc' ? '#bfdbfe' : ($fileType === 'ppt' ? '#fed7aa' : ($fileType === 'xls' ? '#bbf7d0' : ($fileType === 'img' ? '#e9d5ff' : 'var(--border2)')))) }}">
                        <svg width="15" height="15" fill="none" stroke="{{ $iconColor }}" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                    </div>
                    <div class="item-main">
                        <p class="item-title">
                            <a href="{{ route('admin.materials.show', $material->id) }}">{{ $material->judul }}</a>
                        </p>
                        <div style="display:flex;align-items:center;gap:6px;margin-top:3px;flex-wrap:wrap">
                            @if($material->subject)
                                <span class="status-badge badge-purple" style="font-size:10.5px;padding:2px 7px">{{ $material->subject->nama_mapel }}</span>
                            @endif
                            @if($material->class)
                                <span class="status-badge badge-blue" style="font-size:10.5px;padding:2px 7px">{{ $material->class->nama_kelas }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="item-meta">
                        <p class="item-meta-sub">{{ $material->created_at->format('d M Y') }}</p>
                        @if($ext)
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:{{ $iconColor }};text-align:right;margin-top:2px;text-transform:uppercase">{{ $ext }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-mini">
                    <p>Belum ada materi diunggah</p>
                </div>
            @endforelse
        </div>

        {{-- Pengumpulan Belum Dinilai --}}
        <div class="card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 9.5-9.5z"/>
                </svg>
                <p class="card-title">Belum Dinilai</p>
                @php $pendingCount = $pendingSubmissions->count(); @endphp
                @if($pendingCount > 0)
                    <span class="card-badge badge-yellow">{{ $pendingCount }} menunggu</span>
                @endif
                <a href="{{ route('admin.assignment-submissions.index') }}" class="view-all" style="margin-left:4px">Lihat semua →</a>
            </div>

            @forelse($pendingSubmissions as $sub)
                <div class="list-item">
                    <div class="item-icon yellow">
                        <svg width="15" height="15" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                        </svg>
                    </div>
                    <div class="item-main">
                        <p class="item-title">
                            {{ $sub->student->nama_lengkap ?? '—' }}
                        </p>
                        <p class="item-sub">
                            {{ $sub->assignment->judul ?? '—' }}
                            @if($sub->submitted_at)
                                · {{ \Carbon\Carbon::parse($sub->submitted_at)->format('d M Y, H:i') }}
                            @endif
                        </p>
                    </div>
                    <div style="flex-shrink:0">
                        <a href="{{ route('admin.assignment-submissions.show', $sub->id) }}"
                           class="btn btn-warn btn-sm">Nilai</a>
                    </div>
                </div>
            @empty
                <div class="empty-mini">
                    <svg width="28" height="28" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    <p>Semua pengumpulan sudah dinilai</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
</x-app-layout>