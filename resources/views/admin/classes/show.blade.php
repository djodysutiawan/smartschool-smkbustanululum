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
        --warning:    #d97706;
        --warning-50: #fffbeb;
        --warning-100:#fde68a;
    }

    .page { padding: 28px 28px 60px; max-width: 5000px; margin: 0 auto; }

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
    .page-header-left { display: flex; align-items: center; gap: 16px; }

    /* Hero class icon */
    .hero-icon {
        width: 56px; height: 56px; border-radius: 14px; flex-shrink: 0;
        background: var(--brand-50); border: 1.5px solid var(--brand-100);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 18px;
        font-weight: 800; color: var(--brand-700);
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }

    /* Badges */
    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 20px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
        letter-spacing: .04em; text-transform: uppercase;
    }
    .badge-brand   { background: var(--brand-50);   color: var(--brand-700);  border: 1px solid var(--brand-100); }
    .badge-success { background: var(--success-50);  color: var(--success);    border: 1px solid var(--success-100); }
    .badge-warning { background: var(--warning-50);  color: var(--warning);    border: 1px solid var(--warning-100); }
    .badge-neutral { background: var(--surface3);    color: var(--text2);      border: 1px solid var(--border); }

    /* Action buttons */
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: background .15s; white-space: nowrap;
    }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { background: var(--brand-h); }
    .btn-ghost { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }
    .btn-danger { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .btn-danger:hover { background: var(--danger-100); }
    .btn-actions { display: flex; gap: 8px; flex-wrap: wrap; }

    /* Stats row */
    .stats-row {
        display: grid; grid-template-columns: repeat(3, 1fr);
        gap: 12px; margin-bottom: 20px;
    }
    .stat-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 16px 18px;
        display: flex; align-items: center; gap: 14px;
    }
    .stat-icon {
        width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .stat-icon.blue   { background: var(--brand-50);   border: 1px solid var(--brand-100); }
    .stat-icon.green  { background: var(--success-50);  border: 1px solid var(--success-100); }
    .stat-icon.orange { background: var(--warning-50);  border: 1px solid var(--warning-100); }
    .stat-value {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: var(--text);
        line-height: 1;
    }
    .stat-label { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: 3px; }

    /* Layout: 2 kolom */
    .detail-layout {
        display: grid; grid-template-columns: 1fr 2fr; gap: 16px; align-items: start;
    }

    /* Info card */
    .info-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 16px;
    }
    .card-header {
        display: flex; align-items: center; gap: 8px;
        padding: 14px 18px; border-bottom: 1px solid var(--border); background: var(--surface2);
    }
    .card-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px; font-weight: 700; color: var(--text3);
        letter-spacing: .07em; text-transform: uppercase; flex: 1;
    }
    .card-body { padding: 0; }

    /* Info rows */
    .info-row {
        display: flex; align-items: flex-start;
        padding: 13px 18px; border-bottom: 1px solid var(--border);
        gap: 12px;
    }
    .info-row:last-child { border-bottom: none; }
    .info-key {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px;
        font-weight: 700; color: var(--text3); letter-spacing: .04em;
        text-transform: uppercase; white-space: nowrap; min-width: 110px; padding-top: 1px;
    }
    .info-val {
        font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); flex: 1;
    }
    .info-val.muted { color: var(--text3); font-style: italic; }

    /* Wali kelas card dalam info */
    .wali-inline {
        display: flex; align-items: center; gap: 10px;
    }
    .wali-avatar {
        width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
        background: var(--surface3); border: 1px solid var(--border2);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px;
        font-weight: 800; color: var(--text2);
    }
    .wali-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .wali-nip  { font-family: 'DM Sans', sans-serif; font-size: 11.5px; color: var(--text3); }

    /* Table card */
    .table-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 16px;
    }
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        padding: 11px 16px; text-align: left;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px;
        font-weight: 700; color: var(--text3); letter-spacing: .06em; text-transform: uppercase;
        background: var(--surface2); border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }
    tbody td {
        padding: 11px 16px; font-family: 'DM Sans', sans-serif;
        font-size: 13.5px; color: var(--text);
        border-bottom: 1px solid var(--border);
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: var(--surface2); }

    /* Avatar inisial di tabel */
    .tbl-avatar {
        width: 30px; height: 30px; border-radius: 7px; flex-shrink: 0;
        background: var(--brand-50); border: 1px solid var(--brand-100);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px;
        font-weight: 800; color: var(--brand-700);
    }
    .tbl-with-avatar { display: flex; align-items: center; gap: 10px; }
    .tbl-name  { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .tbl-sub   { font-family: 'DM Sans', sans-serif; font-size: 11.5px; color: var(--text3); margin-top: 1px; }
    .tbl-num   { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 600; color: var(--text3); }

    /* Empty state */
    .empty-state {
        padding: 40px 24px; text-align: center;
    }
    .empty-icon {
        width: 48px; height: 48px; border-radius: 12px;
        background: var(--surface3); border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 12px;
    }
    .empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700; color: var(--text2); }
    .empty-sub   { font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--text3); margin-top: 4px; }

    /* Schedule pill */
    .schedule-pill {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 6px;
        background: var(--surface3); border: 1px solid var(--border);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 600; color: var(--text2);
    }
    .schedule-pill .day {
        font-weight: 800; color: var(--brand);
    }

    /* Delete modal */
    .modal-overlay {
        display: none; position: fixed; inset: 0; z-index: 100;
        background: rgba(15,23,42,.45); backdrop-filter: blur(3px);
        align-items: center; justify-content: center;
    }
    .modal-overlay.open { display: flex; }
    .modal {
        background: var(--surface); border-radius: var(--radius);
        border: 1px solid var(--border); padding: 28px 28px 24px;
        width: 100%; max-width: 400px; margin: 16px;
        box-shadow: 0 20px 40px rgba(0,0,0,.12);
    }
    .modal-icon {
        width: 48px; height: 48px; border-radius: 12px; margin-bottom: 16px;
        background: var(--danger-50); border: 1px solid var(--danger-100);
        display: flex; align-items: center; justify-content: center;
    }
    .modal-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-weight: 800; color: var(--text); }
    .modal-body  { font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text2); margin-top: 8px; line-height: 1.6; }
    .modal-body strong { color: var(--text); }
    .modal-footer { display: flex; gap: 10px; justify-content: flex-end; margin-top: 22px; }

    /* Responsive */
    @media (max-width: 768px) {
        .page { padding: 16px 16px 40px; }
        .stats-row { grid-template-columns: 1fr 1fr; }
        .detail-layout { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
        .stats-row { grid-template-columns: 1fr; }
        .page-header-left { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.classes.index') }}">Data Kelas</a>
        <span class="sep">›</span>
        <span class="current">{{ $class->nama_kelas }}</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div class="page-header-left">
            <div class="hero-icon">{{ strtoupper(substr($class->nama_kelas, 0, 2)) }}</div>
            <div>
                <h1 class="page-title">{{ $class->nama_kelas }}</h1>
                <p class="page-sub">
                    @if($class->tingkat) Tingkat {{ $class->tingkat }} @endif
                    @if($class->jurusan) · {{ $class->jurusan }} @endif
                </p>
                <div style="display:flex;gap:6px;margin-top:8px;flex-wrap:wrap;">
                    @if($class->tingkat)
                        <span class="badge badge-brand">{{ $class->tingkat }}</span>
                    @endif
                    @if($class->jurusan)
                        <span class="badge badge-neutral">{{ $class->jurusan }}</span>
                    @endif
                    @if($class->waliKelas)
                        <span class="badge badge-success">Ada Wali Kelas</span>
                    @else
                        <span class="badge badge-warning">Belum Ada Wali</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="btn-actions">
            <a href="{{ route('admin.classes.index') }}" class="btn btn-ghost">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali
            </a>
            <a href="{{ route('admin.classes.edit', $class->id) }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit Kelas
            </a>
            <button class="btn btn-danger" onclick="openModal()">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    <path d="M10 11v6M14 11v6"/>
                </svg>
                Hapus
            </button>
        </div>
    </div>

    {{-- Stats row --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div>
                <p class="stat-value">{{ $class->students->count() }}</p>
                <p class="stat-label">Total Siswa</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8"  y1="2" x2="8"  y2="6"/>
                    <line x1="3"  y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div>
                <p class="stat-value">{{ $class->schedules->count() }}</p>
                <p class="stat-label">Jadwal Pelajaran</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
            </div>
            <div>
                <p class="stat-value">{{ $class->waliKelas ? 1 : 0 }}</p>
                <p class="stat-label">Wali Kelas</p>
            </div>
        </div>
    </div>

    {{-- Main layout --}}
    <div class="detail-layout">

        {{-- Kolom kiri: info kelas --}}
        <div>
            {{-- Informasi Kelas --}}
            <div class="info-card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    <p class="card-title">Informasi Kelas</p>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <span class="info-key">Nama Kelas</span>
                        <span class="info-val">{{ $class->nama_kelas }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-key">Tingkat</span>
                        <span class="info-val">
                            @if($class->tingkat)
                                <span class="badge badge-brand">{{ $class->tingkat }}</span>
                            @else
                                <span class="info-val muted">Tidak ditentukan</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-key">Jurusan</span>
                        <span class="info-val">
                            @if($class->jurusan)
                                {{ $class->jurusan }}
                            @else
                                <span class="muted">Tidak ada jurusan</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-key">Total Siswa</span>
                        <span class="info-val">{{ $class->students->count() }} siswa</span>
                    </div>
                    <div class="info-row">
                        <span class="info-key">Dibuat</span>
                        <span class="info-val">{{ $class->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-key">Diperbarui</span>
                        <span class="info-val">{{ $class->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            {{-- Wali Kelas --}}
            <div class="info-card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                    <p class="card-title">Wali Kelas</p>
                </div>
                <div class="card-body">
                    @if($class->waliKelas)
                        <div class="info-row" style="border:none">
                            <div class="wali-inline">
                                <div class="wali-avatar">
                                    {{ strtoupper(substr($class->waliKelas->nama_lengkap, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="wali-name">{{ $class->waliKelas->nama_lengkap }}</p>
                                    <p class="wali-nip">NIP: {{ $class->waliKelas->nip ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="info-row">
                            <span class="info-key">NIP</span>
                            <span class="info-val">{{ $class->waliKelas->nip ?? '-' }}</span>
                        </div>
                        @if(isset($class->waliKelas->email))
                        <div class="info-row">
                            <span class="info-key">Email</span>
                            <span class="info-val">{{ $class->waliKelas->email }}</span>
                        </div>
                        @endif
                        @if(isset($class->waliKelas->no_telp))
                        <div class="info-row">
                            <span class="info-key">Telepon</span>
                            <span class="info-val">{{ $class->waliKelas->no_telp }}</span>
                        </div>
                        @endif
                    @else
                        <div class="empty-state" style="padding:24px">
                            <div class="empty-icon" style="margin:0 auto 10px">
                                <svg width="20" height="20" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                                </svg>
                            </div>
                            <p class="empty-title">Belum ada wali kelas</p>
                            <p class="empty-sub">Klik "Edit Kelas" untuk menetapkan wali kelas.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kolom kanan: siswa & jadwal --}}
        <div>

            {{-- Daftar Siswa --}}
            <div class="table-card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                    </svg>
                    <p class="card-title">Daftar Siswa</p>
                    <span class="badge badge-brand" style="margin-left:auto">{{ $class->students->count() }} siswa</span>
                </div>
                <div class="table-wrap">
                    @if($class->students->count())
                        <table>
                            <thead>
                                <tr>
                                    <th style="width:40px">#</th>
                                    <th>Nama Siswa</th>
                                    <th>NIS / NISN</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($class->students as $i => $student)
                                    <tr>
                                        <td class="tbl-num">{{ $i + 1 }}</td>
                                        <td>
                                            <div class="tbl-with-avatar">
                                                <div class="tbl-avatar">
                                                    {{ strtoupper(substr($student->nama_lengkap, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <p class="tbl-name">{{ $student->nama_lengkap }}</p>
                                                    @if(isset($student->email))
                                                        <p class="tbl-sub">{{ $student->email }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="tbl-name" style="font-size:12.5px">{{ $student->nis ?? '-' }}</p>
                                            @if(isset($student->nisn))
                                                <p class="tbl-sub">NISN: {{ $student->nisn }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            @php $jk = $student->jenis_kelamin ?? null; @endphp
                                            @if($jk === 'L' || $jk === 'Laki-laki')
                                                <span class="badge badge-brand">Laki-laki</span>
                                            @elseif($jk === 'P' || $jk === 'Perempuan')
                                                <span class="badge badge-success">Perempuan</span>
                                            @else
                                                <span class="badge badge-neutral">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-success">Aktif</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                </svg>
                            </div>
                            <p class="empty-title">Belum ada siswa</p>
                            <p class="empty-sub">Siswa yang terdaftar di kelas ini akan muncul di sini.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Jadwal Pelajaran --}}
            <div class="table-card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8"  y1="2" x2="8"  y2="6"/>
                        <line x1="3"  y1="10" x2="21" y2="10"/>
                    </svg>
                    <p class="card-title">Jadwal Pelajaran</p>
                    <span class="badge badge-neutral" style="margin-left:auto">{{ $class->schedules->count() }} jadwal</span>
                </div>
                <div class="table-wrap">
                    @if($class->schedules->count())
                        <table>
                            <thead>
                                <tr>
                                    <th style="width:40px">#</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Guru</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($class->schedules->sortBy(['hari', 'jam_mulai']) as $i => $schedule)
                                    <tr>
                                        <td class="tbl-num">{{ $i + 1 }}</td>
                                        <td>
                                            <span class="schedule-pill">
                                                <span class="day">{{ $schedule->hari ?? '-' }}</span>
                                            </span>
                                        </td>
                                        <td>
                                            <p class="tbl-name" style="font-size:12.5px">
                                                {{ $schedule->jam_mulai ?? '-' }} – {{ $schedule->jam_selesai ?? '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            @if(isset($schedule->subject))
                                                <p class="tbl-name">{{ $schedule->subject->nama_mapel ?? '-' }}</p>
                                            @elseif(isset($schedule->mata_pelajaran))
                                                <p class="tbl-name">{{ $schedule->mata_pelajaran }}</p>
                                            @else
                                                <span class="badge badge-neutral">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($schedule->teacher))
                                                <div class="tbl-with-avatar">
                                                    <div class="tbl-avatar" style="background:var(--surface3);color:var(--text2);border-color:var(--border2)">
                                                        {{ strtoupper(substr($schedule->teacher->nama_lengkap ?? '?', 0, 1)) }}
                                                    </div>
                                                    <p class="tbl-name" style="font-size:12.5px">{{ $schedule->teacher->nama_lengkap }}</p>
                                                </div>
                                            @else
                                                <span class="badge badge-neutral">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8"  y1="2" x2="8"  y2="6"/>
                                    <line x1="3"  y1="10" x2="21" y2="10"/>
                                </svg>
                            </div>
                            <p class="empty-title">Belum ada jadwal</p>
                            <p class="empty-sub">Jadwal pelajaran untuk kelas ini belum ditambahkan.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-icon">
            <svg width="22" height="22" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                <path d="M10 11v6M14 11v6"/>
                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
            </svg>
        </div>
        <p class="modal-title">Hapus Kelas?</p>
        <p class="modal-body">
            Anda akan menghapus kelas <strong>{{ $class->nama_kelas }}</strong>.
            @if($class->students->count())
                Kelas ini memiliki <strong>{{ $class->students->count() }} siswa</strong> yang terdaftar.
            @endif
            Tindakan ini tidak dapat dibatalkan.
        </p>
        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal()">Batal</button>
            <form method="POST" action="{{ route('admin.classes.destroy', $class->id) }}" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Ya, Hapus Kelas</button>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal()  { document.getElementById('deleteModal').classList.add('open'); }
    function closeModal() { document.getElementById('deleteModal').classList.remove('open'); }

    /* Tutup modal saat klik backdrop */
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>

</x-app-layout>