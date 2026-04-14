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
        --warning:    #d97706;
        --warning-50: #fffbeb;
        --warning-100:#fde68a;
        --success:    #16a34a;
        --success-50: #f0fdf4;
        --success-100:#dcfce7;
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
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .view-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--brand-50); color: var(--brand-700);
        border: 1px solid var(--brand-100); border-radius: 20px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
        padding: 3px 10px; margin-top: 6px; letter-spacing: .04em; text-transform: uppercase;
    }

    /* ── Buttons ── */
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: background .15s; white-space: nowrap;
    }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { background: var(--brand-h); }
    .btn-ghost   { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }
    .btn-warn    { background: var(--warning-50); color: var(--warning); border: 1px solid var(--warning-100); }
    .btn-warn:hover { background: var(--warning-100); }
    .btn-danger  { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .btn-danger:hover { background: var(--danger-100); }
    .actions { display: flex; gap: 8px; flex-wrap: wrap; }

    /* ── Hero banner ── */
    .hero-card {
        background: linear-gradient(135deg, var(--brand) 0%, var(--brand-h) 100%);
        border-radius: var(--radius); padding: 24px 28px; margin-bottom: 16px;
        display: flex; align-items: center; justify-content: space-between;
        gap: 20px; flex-wrap: wrap;
    }
    .hero-left  { display: flex; align-items: center; gap: 18px; }
    .hero-icon  {
        width: 64px; height: 64px; border-radius: 14px; flex-shrink: 0;
        background: rgba(255,255,255,.2); border: 1.5px solid rgba(255,255,255,.3);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 18px; font-weight: 800;
        color: #fff; letter-spacing: .02em;
    }
    .hero-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: #fff; }
    .hero-meta { display: flex; gap: 8px; margin-top: 8px; flex-wrap: wrap; }
    .hero-chip  {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
        border-radius: 20px; padding: 3px 10px;
        font-family: 'DM Sans', sans-serif; font-size: 12px; color: rgba(255,255,255,.9);
    }
    .hero-stats { display: flex; gap: 28px; flex-wrap: wrap; }
    .hs { text-align: center; }
    .hs-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 28px; font-weight: 800; color: #fff; }
    .hs-lbl { font-family: 'DM Sans', sans-serif; font-size: 12px; color: rgba(255,255,255,.7); margin-top: 2px; }

    /* ── Card ── */
    .card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 16px;
    }
    .card:last-child { margin-bottom: 0; }
    .card-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 13px 18px; border-bottom: 1px solid var(--border); background: var(--surface2);
    }
    .card-header-left { display: flex; align-items: center; gap: 8px; }
    .card-title {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
        color: var(--text3); letter-spacing: .07em; text-transform: uppercase;
    }
    .card-body { padding: 22px 24px; }

    /* ── Info grid ── */
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .info-item { display: flex; flex-direction: column; gap: 5px; }
    .info-label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
        color: var(--text3); text-transform: uppercase; letter-spacing: .05em;
    }
    .info-value { font-family: 'DM Sans', sans-serif; font-size: 14px; color: var(--text); font-weight: 500; }

    /* ── Count badge ── */
    .count-badge {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
        color: var(--text3); background: var(--surface3); border: 1px solid var(--border);
        border-radius: 20px; padding: 2px 10px;
    }

    /* ── Kode display ── */
    .kode-display {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--surface3); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 5px 12px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px;
        font-weight: 800; color: var(--text2); letter-spacing: .06em;
    }

    /* ── Table ── */
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-family: 'DM Sans', sans-serif; font-size: 13px; }
    th {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
        color: var(--text3); text-transform: uppercase; letter-spacing: .06em;
        padding: 10px 16px; text-align: left;
        background: var(--surface2); border-bottom: 1px solid var(--border);
    }
    td { padding: 12px 16px; border-bottom: 1px solid var(--border); color: var(--text2); vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: var(--surface2); }

    /* ── Teacher cell ── */
    .t-cell   { display: flex; align-items: center; gap: 10px; }
    .t-avatar {
        width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
        background: var(--brand-50); border: 1px solid var(--brand-100);
        display: inline-flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 10.5px; font-weight: 800;
        color: var(--brand-700);
    }
    .t-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .t-sub  { font-family: 'DM Sans', sans-serif; font-size: 11.5px; color: var(--text3); }

    /* ── Class pill ── */
    .class-pill {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--brand-50); border: 1px solid var(--brand-100);
        border-radius: 6px; padding: 3px 9px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px;
        font-weight: 700; color: var(--brand-700); text-decoration: none;
        transition: background .15s;
    }
    .class-pill:hover { background: var(--brand-100); }

    /* ── Day badge ── */
    .day-badge {
        display: inline-flex; align-items: center;
        border-radius: 6px; padding: 2px 9px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
        background: var(--surface3); color: var(--text2); border: 1px solid var(--border);
    }

    /* ── Time chip ── */
    .time-chip {
        display: inline-flex; align-items: center; gap: 4px;
        font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3);
    }

    /* ── Table footer ── */
    .table-footer {
        display: flex; align-items: center; justify-content: space-between;
        padding: 11px 16px; border-top: 1px solid var(--border);
        background: var(--surface2); flex-wrap: wrap; gap: 8px;
    }
    .table-footer-info { font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--text3); }

    /* ── Empty state ── */
    .empty-state { padding: 40px 20px; text-align: center; }
    .empty-icon  {
        width: 44px; height: 44px; border-radius: 11px;
        background: var(--surface3); border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 12px; color: var(--text3);
    }
    .empty-text { font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text3); }

    @media (max-width: 768px) {
        .page { padding: 16px 14px 40px; }
        .info-grid { grid-template-columns: 1fr; }
        .hero-stats { gap: 16px; }
    }
</style>

<div class="page">

    {{-- ── Breadcrumb ── --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.subjects.index') }}">Data Mata Pelajaran</a>
        <span class="sep">›</span>
        <span class="current">{{ $subject->nama_mapel }}</span>
    </nav>

    {{-- ── Page header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Mata Pelajaran</h1>
            <p class="page-sub">Informasi lengkap mata pelajaran dan penggunaan di jadwal</p>
            <span class="view-badge">
                <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
                Detail Mata Pelajaran
            </span>
        </div>
        <div class="actions">
            <a href="{{ route('admin.subjects.index') }}" class="btn btn-ghost">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali
            </a>
            <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn btn-warn">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit
            </a>
            <form method="POST" action="{{ route('admin.subjects.destroy', $subject->id) }}"
                  onsubmit="return confirm('Hapus mata pelajaran {{ addslashes($subject->nama_mapel) }}? Tindakan ini tidak dapat dibatalkan.')"
                  style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14H6L5 6"/>
                        <path d="M10 11v6"/><path d="M14 11v6"/>
                        <path d="M9 6V4h6v2"/>
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- ── Hero banner ── --}}
    @php
        $totalJadwal    = $subject->schedules->count();
        $uniqueClasses  = $subject->schedules->pluck('class.id')->unique()->filter()->count();
        $uniqueTeachers = $subject->schedules->pluck('teacher.id')->unique()->filter()->count();
    @endphp

    <div class="hero-card">
        <div class="hero-left">
            <div class="hero-icon">
                {{ strtoupper(substr($subject->kode_mapel, 0, 3)) }}
            </div>
            <div>
                <p class="hero-name">{{ $subject->nama_mapel }}</p>
                <div class="hero-meta">
                    <span class="hero-chip">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="16 18 22 12 16 6"/>
                            <polyline points="8 6 2 12 8 18"/>
                        </svg>
                        {{ $subject->kode_mapel }}
                    </span>
                    <span class="hero-chip">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        {{ $totalJadwal }} jadwal aktif
                    </span>
                    <span class="hero-chip">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                        {{ $uniqueTeachers }} guru pengampu
                    </span>
                </div>
            </div>
        </div>
        <div class="hero-stats">
            <div class="hs">
                <div class="hs-val">{{ $totalJadwal }}</div>
                <div class="hs-lbl">Total Jadwal</div>
            </div>
            <div class="hs">
                <div class="hs-val">{{ $uniqueClasses }}</div>
                <div class="hs-lbl">Kelas</div>
            </div>
            <div class="hs">
                <div class="hs-val">{{ $uniqueTeachers }}</div>
                <div class="hs-lbl">Guru</div>
            </div>
        </div>
    </div>

    {{-- ── Informasi Mata Pelajaran ── --}}
    <div class="card">
        <div class="card-header">
            <div class="card-header-left">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <p class="card-title">Informasi Mata Pelajaran</p>
            </div>
        </div>
        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Mata Pelajaran</span>
                    <span class="info-value"
                          style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:16px">
                        {{ $subject->nama_mapel }}
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Kode Mata Pelajaran</span>
                    <div style="margin-top:4px">
                        <span class="kode-display">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <polyline points="16 18 22 12 16 6"/>
                                <polyline points="8 6 2 12 8 18"/>
                            </svg>
                            {{ $subject->kode_mapel }}
                        </span>
                    </div>
                </div>
                <div class="info-item">
                    <span class="info-label">Digunakan di Jadwal</span>
                    <span class="info-value">{{ $totalJadwal }} sesi jadwal</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Ditambahkan</span>
                    <span class="info-value">
                        {{ $subject->created_at->translatedFormat('d F Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Jadwal Penggunaan ── --}}
    {{-- Data dari: Subject::with('schedules.teacher', 'schedules.class') --}}
    <div class="card" style="margin-bottom:0">
        <div class="card-header">
            <div class="card-header-left">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <p class="card-title">Jadwal Penggunaan</p>
            </div>
            <span class="count-badge">{{ $totalJadwal }} jadwal</span>
        </div>

        @if($subject->schedules->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <p class="empty-text">Mata pelajaran ini belum digunakan di jadwal manapun.</p>
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width:40px">#</th>
                            <th>Kelas</th>
                            <th>Guru Pengampu</th>
                            <th>Hari</th>
                            <th>Waktu</th>
                            <th>Ruangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subject->schedules as $i => $schedule)
                            @php
                                // ── Guru dari relasi schedules.teacher ──
                                $teacher     = $schedule->teacher;
                                $teacherName = $teacher?->name ?? '—';
                                $initials    = $teacher
                                    ? strtoupper(substr($teacher->name, 0, 1))
                                      . strtoupper(substr(strrchr($teacher->name, ' ') ?: $teacher->name, 1, 1))
                                    : '?';

                                // ── Kelas dari relasi schedules.class ──
                                $kelas     = $schedule->class;
                                $kelasName = $kelas?->nama_kelas ?? '—';

                                // ── Waktu ──
                                $timeStart = isset($schedule->jam_mulai)
                                    ? \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i')
                                    : null;
                                $timeEnd   = isset($schedule->jam_selesai)
                                    ? \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i')
                                    : null;

                                // ── Hari & Ruangan ──
                                $hari    = $schedule->hari    ?? '—';
                                $ruangan = $schedule->ruangan ?? $schedule->room ?? '—';
                            @endphp
                            <tr>
                                <td style="color:var(--text3);font-size:12px">{{ $i + 1 }}</td>

                                {{-- Kelas --}}
                                <td>
                                    @if($kelas)
                                        <a href="{{ route('admin.classes.show', $kelas->id) }}"
                                           class="class-pill">
                                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                                            </svg>
                                            {{ $kelasName }}
                                        </a>
                                    @else
                                        <span style="color:var(--text3)">—</span>
                                    @endif
                                </td>

                                {{-- Guru --}}
                                <td>
                                    <div class="t-cell">
                                        <div class="t-avatar">{{ $initials }}</div>
                                        <div>
                                            <p class="t-name">{{ $teacherName }}</p>
                                            @if($teacher && isset($teacher->nip))
                                                <p class="t-sub">NIP: {{ $teacher->nip }}</p>
                                            @elseif($teacher && isset($teacher->email))
                                                <p class="t-sub">{{ $teacher->email }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Hari --}}
                                <td>
                                    <span class="day-badge">{{ $hari }}</span>
                                </td>

                                {{-- Waktu --}}
                                <td>
                                    @if($timeStart && $timeEnd)
                                        <span class="time-chip">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="10"/>
                                                <polyline points="12 6 12 12 16 14"/>
                                            </svg>
                                            {{ $timeStart }} – {{ $timeEnd }}
                                        </span>
                                    @else
                                        <span style="color:var(--text3)">—</span>
                                    @endif
                                </td>

                                {{-- Ruangan --}}
                                <td style="color:var(--text3)">{{ $ruangan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <span class="table-footer-info">
                    {{ $totalJadwal }} jadwal &mdash;
                    {{ $uniqueClasses }} kelas &middot;
                    {{ $uniqueTeachers }} guru pengampu
                </span>
            </div>
        @endif
    </div>

</div>
</x-app-layout>