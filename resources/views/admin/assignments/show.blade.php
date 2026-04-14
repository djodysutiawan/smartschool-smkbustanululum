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
        --green:      #15803d;
        --green-50:   #dcfce7;
        --green-100:  #bbf7d0;
        --yellow:     #a16207;
        --yellow-50:  #fef9c3;
        --yellow-100: #fef08a;
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
    .btn-green    { background: var(--green-50); color: var(--green); border: 1px solid var(--green-100); }
    .btn-green:hover    { background: var(--green-100); }
    .btn-sm  { padding: 5px 11px; font-size: 12px; }
    .btn-icon{ padding: 6px 10px; }

    /* Layout grid */
    .layout-grid {
        display: grid;
        grid-template-columns: 340px 1fr;
        gap: 16px;
        align-items: start;
    }

    /* ── Left column ── */
    .left-col { display: flex; flex-direction: column; gap: 14px; }

    /* Info card */
    .info-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
    }
    .info-card-header {
        display: flex; align-items: center; gap: 10px;
        padding: 14px 18px; border-bottom: 1px solid var(--border); background: var(--surface2);
    }
    .info-card-title {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
        color: var(--text3); letter-spacing: .07em; text-transform: uppercase;
    }
    .info-card-body { padding: 18px; display: flex; flex-direction: column; gap: 14px; }

    .info-row { display: flex; flex-direction: column; gap: 4px; }
    .info-label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
        color: var(--text3); letter-spacing: .06em; text-transform: uppercase;
    }
    .info-value {
        font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text);
    }
    .info-value.bold {
        font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 14px;
    }
    .info-divider { height: 1px; background: var(--border); margin: 0 -18px; }

    /* Deskripsi / description box */
    .desc-box {
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 12px 14px;
        font-family: 'DM Sans', sans-serif; font-size: 13px;
        color: var(--text2); line-height: 1.65;
        white-space: pre-wrap; word-break: break-word;
    }
    .desc-empty { font-style: italic; color: var(--text3); font-size: 13px; }

    /* Deadline hero */
    .deadline-hero {
        border-radius: var(--radius); padding: 16px 18px;
        display: flex; align-items: center; gap: 14px;
        border: 1px solid;
    }
    .deadline-hero.active  { background: var(--green-50); border-color: var(--green-100); }
    .deadline-hero.expired { background: var(--danger-50); border-color: var(--danger-100); }
    .deadline-hero-icon { width: 40px; height: 40px; border-radius: 9px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
    .deadline-hero.active  .deadline-hero-icon { background: #bbf7d0; }
    .deadline-hero.expired .deadline-hero-icon { background: var(--danger-100); }
    .dl-date {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 800;
        line-height: 1;
    }
    .deadline-hero.active  .dl-date { color: var(--green); }
    .deadline-hero.expired .dl-date { color: var(--danger); }
    .dl-sub {
        font-family: 'DM Sans', sans-serif; font-size: 12px; margin-top: 3px;
    }
    .deadline-hero.active  .dl-sub { color: var(--green); opacity: .8; }
    .deadline-hero.expired .dl-sub { color: var(--danger); opacity: .8; }

    /* Teacher card */
    .teacher-card {
        display: flex; align-items: center; gap: 12px;
        padding: 14px 18px;
    }
    .teacher-avatar {
        width: 42px; height: 42px; border-radius: 10px; flex-shrink: 0;
        background: var(--surface3); border: 1px solid var(--border2);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px;
        font-weight: 800; color: var(--text2); overflow: hidden;
    }
    .teacher-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .teacher-name { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 13.5px; color: var(--text); }
    .teacher-role { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: 2px; }

    /* Badges */
    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
    }
    .badge-active  { background: var(--green-50); color: var(--green); }
    .badge-expired { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .badge-class   { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .badge-subject { background: var(--purple-50); color: var(--purple); border: 1px solid var(--purple-100); }
    .badge-graded  { background: var(--green-50); color: var(--green); }
    .badge-submitted { background: var(--yellow-50); color: var(--yellow); }
    .badge-pending { background: var(--surface3); color: var(--text3); }

    /* ── Right column ── */
    .right-col { display: flex; flex-direction: column; gap: 14px; }

    /* Stats row */
    .stats-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; }
    .stat-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 16px 18px;
        display: flex; align-items: center; gap: 14px;
    }
    .stat-icon { width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
    .stat-icon.blue   { background: var(--brand-50); }
    .stat-icon.green  { background: var(--green-50); }
    .stat-icon.yellow { background: var(--yellow-50); }
    .stat-icon.purple { background: var(--purple-50); }
    .stat-num   { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: var(--text); line-height: 1; }
    .stat-label { font-size: 12px; color: var(--text3); margin-top: 3px; font-family: 'DM Sans', sans-serif; }

    /* Progress ring */
    .progress-ring-wrap {
        display: flex; align-items: center; gap: 10px;
    }
    .ring-label {
        font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3);
    }

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

    /* Student cell */
    .student-cell { display: flex; align-items: center; gap: 9px; }
    .student-avatar {
        width: 30px; height: 30px; border-radius: 7px; flex-shrink: 0;
        background: var(--surface3); border: 1px solid var(--border2);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px;
        font-weight: 800; color: var(--text2); overflow: hidden;
    }
    .student-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .student-name { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 13px; color: var(--text); }
    .student-id   { font-family: 'DM Sans', sans-serif; font-size: 11.5px; color: var(--text3); }

    /* Grade form inline */
    .grade-form { display: flex; align-items: center; gap: 6px; }
    .grade-input {
        width: 64px; padding: 5px 8px; border-radius: var(--radius-sm);
        border: 1px solid var(--border); background: var(--surface2);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        color: var(--text); outline: none; text-align: center; transition: border-color .15s;
    }
    .grade-input:focus { border-color: var(--brand); }
    .grade-select {
        padding: 5px 8px; border-radius: var(--radius-sm);
        border: 1px solid var(--border); background: var(--surface2);
        font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--text);
        outline: none; cursor: pointer; transition: border-color .15s;
    }
    .grade-select:focus { border-color: var(--brand); }

    /* Nilai display */
    .nilai-badge {
        display: inline-flex; align-items: center; justify-content: center;
        width: 40px; height: 40px; border-radius: 9px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 800;
    }
    .nilai-badge.excellent { background: var(--green-50); color: var(--green); }
    .nilai-badge.good      { background: var(--brand-50); color: var(--brand-700); }
    .nilai-badge.average   { background: var(--yellow-50); color: var(--yellow); }
    .nilai-badge.poor      { background: var(--danger-50); color: var(--danger); }
    .nilai-badge.none      { background: var(--surface3); color: var(--text3); font-size: 12px; }

    /* File link */
    .file-link {
        display: inline-flex; align-items: center; gap: 5px;
        font-family: 'DM Sans', sans-serif; font-size: 12.5px; font-weight: 500;
        color: var(--brand); text-decoration: none; background: var(--brand-50);
        padding: 4px 10px; border-radius: var(--radius-sm);
        border: 1px solid var(--brand-100); transition: background .15s;
        max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .file-link:hover { background: var(--brand-100); }

    /* Submitted at */
    .submitted-at { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); }
    .submitted-at b { font-weight: 600; color: var(--text2); }

    /* Empty state */
    .empty-state { display: flex; flex-direction: column; align-items: center; padding: 48px 16px; gap: 10px; }
    .empty-icon  { width: 48px; height: 48px; border-radius: 14px; background: var(--surface3); display: flex; align-items: center; justify-content: center; }
    .empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700; color: var(--text2); }
    .empty-sub   { font-size: 13px; color: var(--text3); font-family: 'DM Sans', sans-serif; }

    /* Progress bar wide */
    .progress-bar-wrap { display: flex; flex-direction: column; gap: 6px; }
    .progress-bar-bg { height: 6px; background: var(--surface3); border-radius: 99px; overflow: hidden; }
    .progress-bar-fill { height: 100%; border-radius: 99px; transition: width .5s ease; }
    .progress-bar-fill.green  { background: var(--green); }
    .progress-bar-fill.blue   { background: var(--brand); }
    .progress-bar-fill.yellow { background: #ca8a04; }
    .progress-bar-label {
        display: flex; justify-content: space-between;
        font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3);
    }

    @media (max-width: 1100px) {
        .layout-grid { grid-template-columns: 1fr; }
        .stats-row { grid-template-columns: repeat(2,1fr); }
    }
    @media (max-width: 600px) { .page { padding: 16px 16px 40px; } }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.assignments.index') }}">Manajemen Tugas</a>
        <span class="sep">›</span>
        <span class="current">Detail Tugas</span>
    </nav>

    {{-- Header --}}
    @php $isExpired = $assignment->deadline < now(); @endphp
    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $assignment->judul }}</h1>
            <p class="page-sub">
                Detail tugas · dibuat {{ \Carbon\Carbon::parse($assignment->created_at)->translatedFormat('d M Y, H:i') }}
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.assignments.index') }}" class="btn btn-ghost">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali
            </a>
            <a href="{{ route('admin.assignments.edit', $assignment->id) }}" class="btn btn-edit-sm">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit Tugas
            </a>
            <button class="btn btn-del-sm" onclick="confirmDelete({{ $assignment->id }}, '{{ addslashes($assignment->judul) }}')">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6m4-6v6M9 6V4h6v2"/>
                </svg>
                Hapus
            </button>
            <form id="delForm" method="POST" action="{{ route('admin.assignments.destroy', $assignment->id) }}" style="display:none">
                @csrf @method('DELETE')
            </form>
        </div>
    </div>

    {{-- Main layout --}}
    <div class="layout-grid">

        {{-- ══ LEFT COLUMN ══ --}}
        <div class="left-col">

            {{-- Deadline Hero --}}
            <div class="deadline-hero {{ $isExpired ? 'expired' : 'active' }}">
                <div class="deadline-hero-icon">
                    @if($isExpired)
                        <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                        </svg>
                    @else
                        <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <p class="dl-date">
                        {{ \Carbon\Carbon::parse($assignment->deadline)->translatedFormat('d M Y, H:i') }} WIB
                    </p>
                    <p class="dl-sub">
                        @if($isExpired)
                            Deadline sudah lewat · {{ \Carbon\Carbon::parse($assignment->deadline)->diffForHumans() }}
                        @else
                            Masih aktif · {{ \Carbon\Carbon::parse($assignment->deadline)->diffForHumans() }}
                        @endif
                    </p>
                </div>
            </div>

            {{-- Info Tugas --}}
            <div class="info-card">
                <div class="info-card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <p class="info-card-title">Informasi Tugas</p>
                </div>
                <div class="info-card-body">
                    <div class="info-row">
                        <span class="info-label">Mata Pelajaran</span>
                        @if($assignment->subject)
                            <span class="badge badge-subject" style="width:fit-content">{{ $assignment->subject->nama_mapel }}</span>
                        @else
                            <span class="info-value" style="color:var(--text3);font-style:italic">—</span>
                        @endif
                    </div>
                    <div class="info-divider"></div>
                    <div class="info-row">
                        <span class="info-label">Kelas</span>
                        @if($assignment->class)
                            <span class="badge badge-class" style="width:fit-content">{{ $assignment->class->nama_kelas }}</span>
                        @else
                            <span class="info-value" style="color:var(--text3);font-style:italic">—</span>
                        @endif
                    </div>
                    <div class="info-divider"></div>
                    <div class="info-row">
                        <span class="info-label">Status Deadline</span>
                        @if($isExpired)
                            <span class="badge badge-expired" style="width:fit-content">
                                <svg width="8" height="8" fill="currentColor" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5"/></svg>
                                Lewat Deadline
                            </span>
                        @else
                            <span class="badge badge-active" style="width:fit-content">
                                <svg width="8" height="8" fill="currentColor" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5"/></svg>
                                Aktif
                            </span>
                        @endif
                    </div>
                    <div class="info-divider"></div>
                    <div class="info-row">
                        <span class="info-label">Deskripsi Tugas</span>
                        @if($assignment->deskripsi)
                            <div class="desc-box">{{ $assignment->deskripsi }}</div>
                        @else
                            <span class="desc-empty">Tidak ada deskripsi</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Guru --}}
            <div class="info-card">
                <div class="info-card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <p class="info-card-title">Guru Pembuat</p>
                </div>
                @if($assignment->teacher)
                    <div class="teacher-card">
                        <div class="teacher-avatar">
                            @if($assignment->teacher->foto)
                                <img src="{{ asset('storage/'.$assignment->teacher->foto) }}" alt="">
                            @else
                                {{ strtoupper(substr($assignment->teacher->nama_lengkap, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <p class="teacher-name">{{ $assignment->teacher->nama_lengkap }}</p>
                            <p class="teacher-role">Guru Pengajar</p>
                        </div>
                    </div>
                @else
                    <div style="padding:14px 18px">
                        <span class="info-value" style="color:var(--text3);font-style:italic">—</span>
                    </div>
                @endif
            </div>

            {{-- Progress Penilaian --}}
            @if($stats['total'] > 0)
            <div class="info-card">
                <div class="info-card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/>
                        <line x1="6" y1="20" x2="6" y2="14"/>
                    </svg>
                    <p class="info-card-title">Progres Penilaian</p>
                </div>
                <div class="info-card-body">
                    @php
                        $pctGraded    = $stats['total'] > 0 ? round($stats['graded'] / $stats['total'] * 100) : 0;
                        $pctSubmitted = $stats['total'] > 0 ? round($stats['submitted'] / $stats['total'] * 100) : 0;
                    @endphp
                    <div class="progress-bar-wrap">
                        <div class="progress-bar-label">
                            <span>Sudah Dinilai</span>
                            <span>{{ $stats['graded'] }} / {{ $stats['total'] }} ({{ $pctGraded }}%)</span>
                        </div>
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill green" style="width:{{ $pctGraded }}%"></div>
                        </div>
                    </div>
                    <div class="progress-bar-wrap">
                        <div class="progress-bar-label">
                            <span>Belum Dinilai</span>
                            <span>{{ $stats['submitted'] }} / {{ $stats['total'] }} ({{ $pctSubmitted }}%)</span>
                        </div>
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill yellow" style="width:{{ $pctSubmitted }}%"></div>
                        </div>
                    </div>
                    @if($stats['avg_nilai'])
                        <div class="info-divider"></div>
                        <div class="info-row">
                            <span class="info-label">Rata-rata Nilai</span>
                            <span class="info-value bold" style="font-size:22px;color:var(--brand)">
                                {{ number_format($stats['avg_nilai'], 1) }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
            @endif

        </div>

        {{-- ══ RIGHT COLUMN ══ --}}
        <div class="right-col">

            {{-- Stats --}}
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <div>
                        <p class="stat-num">{{ $stats['total'] }}</p>
                        <p class="stat-label">Total Pengumpulan</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">
                        <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <div>
                        <p class="stat-num">{{ $stats['graded'] }}</p>
                        <p class="stat-label">Sudah Dinilai</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon yellow">
                        <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <div>
                        <p class="stat-num">{{ $stats['submitted'] }}</p>
                        <p class="stat-label">Menunggu Penilaian</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
                            <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/>
                            <line x1="6" y1="20" x2="6" y2="14"/>
                        </svg>
                    </div>
                    <div>
                        <p class="stat-num">{{ $stats['avg_nilai'] ? number_format($stats['avg_nilai'],1) : '—' }}</p>
                        <p class="stat-label">Rata-rata Nilai</p>
                    </div>
                </div>
            </div>

            {{-- Tabel Submissions --}}
            <div class="table-card">
                <div class="table-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <p class="table-title">Daftar Pengumpulan Siswa</p>
                    @if($stats['total'])
                        <span class="table-badge">{{ $stats['total'] }} siswa</span>
                    @endif
                </div>

                @if($assignment->submissions->count())
                    <table class="main-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Siswa</th>
                                <th>File / Jawaban</th>
                                <th>Dikumpulkan</th>
                                <th class="center">Status</th>
                                <th class="center">Nilai</th>
                                <th class="center">Aksi Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assignment->submissions as $i => $sub)
                                @php
                                    $nilai = $sub->nilai;
                                    $nilaiClass = 'none';
                                    if ($nilai !== null) {
                                        if ($nilai >= 85)      $nilaiClass = 'excellent';
                                        elseif ($nilai >= 70)  $nilaiClass = 'good';
                                        elseif ($nilai >= 55)  $nilaiClass = 'average';
                                        else                   $nilaiClass = 'poor';
                                    }
                                @endphp
                                <tr>
                                    <td style="color:var(--text3);font-size:12.5px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">
                                        {{ $i + 1 }}
                                    </td>

                                    {{-- Siswa --}}
                                    <td>
                                        <div class="student-cell">
                                            <div class="student-avatar">
                                                @if($sub->student && $sub->student->foto)
                                                    <img src="{{ asset('storage/'.$sub->student->foto) }}" alt="">
                                                @else
                                                    {{ strtoupper(substr($sub->student->nama_lengkap ?? '?', 0, 1)) }}
                                                @endif
                                            </div>
                                            <div>
                                                <p class="student-name">{{ $sub->student->nama_lengkap ?? '—' }}</p>
                                                <p class="student-id">{{ $sub->student->nis ?? '' }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- File --}}
                                    <td>
                                        @if($sub->file_path)
                                            <a href="{{ asset('storage/'.$sub->file_path) }}"
                                               target="_blank" class="file-link">
                                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66L9.41 17.41a2 2 0 0 1-2.83-2.83l8.49-8.48"/>
                                                </svg>
                                                Lihat File
                                            </a>
                                        @elseif($sub->jawaban)
                                            <span style="font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text2);
                                                display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;max-width:180px">
                                                {{ $sub->jawaban }}
                                            </span>
                                        @else
                                            <span style="font-style:italic;color:var(--text3);font-size:12.5px">—</span>
                                        @endif
                                    </td>

                                    {{-- Dikumpulkan --}}
                                    <td>
                                        <div class="submitted-at">
                                            <b>{{ \Carbon\Carbon::parse($sub->created_at)->translatedFormat('d M Y') }}</b><br>
                                            {{ \Carbon\Carbon::parse($sub->created_at)->format('H:i') }} WIB
                                        </div>
                                    </td>

                                    {{-- Status --}}
                                    <td class="center">
                                        @if($sub->status === 'graded')
                                            <span class="badge badge-graded">
                                                <svg width="8" height="8" fill="currentColor" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5"/></svg>
                                                Dinilai
                                            </span>
                                        @elseif($sub->status === 'submitted')
                                            <span class="badge badge-submitted">
                                                <svg width="8" height="8" fill="currentColor" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5"/></svg>
                                                Dikumpulkan
                                            </span>
                                        @else
                                            <span class="badge badge-pending">
                                                <svg width="8" height="8" fill="currentColor" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5"/></svg>
                                                {{ $sub->status ?? 'Pending' }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Nilai --}}
                                    <td class="center">
                                        <div class="nilai-badge {{ $nilaiClass }}">
                                            {{ $nilai !== null ? $nilai : '—' }}
                                        </div>
                                    </td>

                                    {{-- Aksi nilai --}}
                                    <td class="center">
                                        <button type="button"
                                                class="btn btn-ghost btn-sm"
                                                onclick="openGradeModal({{ $sub->id }}, '{{ addslashes($sub->student->nama_lengkap ?? '-') }}', {{ $nilai ?? 'null' }}, '{{ $sub->status }}')">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                            Beri Nilai
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                            </svg>
                        </div>
                        <p class="empty-title">Belum ada pengumpulan</p>
                        <p class="empty-sub">Siswa belum mengumpulkan tugas ini</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

</div>

{{-- ══════════ GRADE MODAL ══════════ --}}
<div id="gradeModalOverlay" style="
    display:none; position:fixed; inset:0; z-index:9999;
    background: rgba(15,23,42,.45); backdrop-filter: blur(4px);
    align-items:center; justify-content:center;
">
    <div style="
        background: var(--surface); border-radius: 14px;
        border: 1px solid var(--border); width: 100%; max-width: 420px; margin: 16px;
        box-shadow: 0 20px 60px rgba(0,0,0,.18);
        font-family: 'Plus Jakarta Sans', sans-serif;
    ">
        {{-- Modal header --}}
        <div style="padding:18px 22px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
            <div>
                <p style="font-size:14px;font-weight:800;color:var(--text)">Beri Nilai</p>
                <p id="gradeModalStudent" style="font-size:12px;color:var(--text3);margin-top:2px"></p>
            </div>
            <button onclick="closeGradeModal()" style="
                width:30px;height:30px;border-radius:7px;border:1px solid var(--border);
                background:var(--surface2);cursor:pointer;display:flex;align-items:center;justify-content:center;
            ">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Modal body --}}
        <form id="gradeForm" method="POST" style="padding:22px">
            @csrf @method('PATCH')
            <div style="display:flex;flex-direction:column;gap:16px">

                {{-- Nilai input --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.06em;text-transform:uppercase;margin-bottom:6px">
                        Nilai (0 – 100)
                    </label>
                    <input type="number" name="nilai" id="gradeInputNilai"
                           min="0" max="100" step="1"
                           placeholder="Masukkan nilai…"
                           style="
                               width:100%; padding:10px 14px; border-radius:var(--radius-sm);
                               border:1px solid var(--border); background:var(--surface2);
                               font-family:'Plus Jakarta Sans',sans-serif; font-size:16px; font-weight:800;
                               color:var(--text); outline:none; box-sizing:border-box;
                           ">
                </div>

                {{-- Status --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.06em;text-transform:uppercase;margin-bottom:6px">
                        Status
                    </label>
                    <select name="status" id="gradeInputStatus" style="
                        width:100%; padding:10px 14px; border-radius:var(--radius-sm);
                        border:1px solid var(--border); background:var(--surface2);
                        font-family:'DM Sans',sans-serif; font-size:13.5px; color:var(--text);
                        outline:none; cursor:pointer; box-sizing:border-box; appearance:none;
                    ">
                        <option value="graded">Dinilai (Graded)</option>
                        <option value="returned">Dikembalikan (Returned)</option>
                    </select>
                </div>

                {{-- Quick score buttons --}}
                <div>
                    <p style="font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.06em;text-transform:uppercase;margin-bottom:8px">
                        Nilai Cepat
                    </p>
                    <div style="display:flex;gap:6px;flex-wrap:wrap">
                        @foreach([100,95,90,85,80,75,70,65,60,55,50] as $quick)
                            <button type="button" onclick="setQuickScore({{ $quick }})"
                                    style="
                                        padding:5px 12px; border-radius:var(--radius-sm);
                                        border:1px solid var(--border); background:var(--surface2);
                                        font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700;
                                        color:var(--text2); cursor:pointer; transition:all .15s;
                                    "
                                    onmouseover="this.style.background='var(--brand-50)';this.style.color='var(--brand-700)';this.style.borderColor='var(--brand-100)'"
                                    onmouseout="this.style.background='var(--surface2)';this.style.color='var(--text2)';this.style.borderColor='var(--border)'">
                                {{ $quick }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div style="display:flex;gap:8px;margin-top:20px;padding-top:18px;border-top:1px solid var(--border)">
                <button type="button" onclick="closeGradeModal()" class="btn btn-ghost" style="flex:1;justify-content:center">
                    Batal
                </button>
                <button type="submit" class="btn btn-primary" style="flex:2;justify-content:center">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Simpan Nilai
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // ── Grade modal ──
    function openGradeModal(subId, studentName, currentNilai, currentStatus) {
        const overlay = document.getElementById('gradeModalOverlay');
        document.getElementById('gradeModalStudent').textContent = studentName;
        document.getElementById('gradeInputNilai').value = currentNilai ?? '';
        document.getElementById('gradeInputStatus').value = currentStatus === 'graded' ? 'graded' : 'graded';
        document.getElementById('gradeForm').action = `/admin/assignments/submissions/${subId}/grade`;
        overlay.style.display = 'flex';
        document.getElementById('gradeInputNilai').focus();
    }

    function closeGradeModal() {
        document.getElementById('gradeModalOverlay').style.display = 'none';
    }

    function setQuickScore(val) {
        document.getElementById('gradeInputNilai').value = val;
    }

    // Close on overlay click
    document.getElementById('gradeModalOverlay').addEventListener('click', function(e) {
        if (e.target === this) closeGradeModal();
    });

    // ── Delete confirm ──
    function confirmDelete(id, judul) {
        Swal.fire({
            title: 'Hapus Tugas?',
            html: `Tugas <b>${judul}</b> beserta semua pengumpulan akan dihapus permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
        }).then(r => { if (r.isConfirmed) document.getElementById('delForm').submit(); });
    }
</script>
</x-app-layout>