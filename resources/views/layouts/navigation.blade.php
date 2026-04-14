{{-- ============================================================
     navigation.blade.php
     Sidebar kiri + topbar — menu berubah sesuai role user
     Role: admin | guru | guru_piket | siswa | orang_tua
     ============================================================ --}}

<style>
    /* ── Fonts ── */
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --sidebar-w: 256px;
        --topbar-h: 60px;
        --brand-900: #0d1f4e;
        --brand-800: #132651;
        --brand-700: #1750c0;
        --brand-600: #1f63db;
        --brand-500: #3582f0;
        --brand-400: #59a3f8;
        --brand-100: #d9ebff;
        --brand-50:  #eef6ff;
        --green-500: #0a6b4a;
        --sidebar-bg: #0f1f4a;
        --sidebar-text: rgba(255,255,255,.65);
        --sidebar-hover: rgba(255,255,255,.08);
        --sidebar-active-bg: rgba(53,130,240,.18);
        --sidebar-active-text: #93c5fd;
        --topbar-bg: #fff;
        --topbar-border: #e2e8f0;
    }

    * { box-sizing: border-box; }

    /* ── Layout shell ── */
    body {
        font-family: 'DM Sans', sans-serif;
        background: #f1f5f9;
        margin: 0;
    }

    .layout-shell {
        display: flex;
        min-height: 100vh;
    }

    /* ══════════════════════════════
       SIDEBAR
    ══════════════════════════════ */
    .sidebar {
        width: var(--sidebar-w);
        background: var(--sidebar-bg);
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0; left: 0; bottom: 0;
        z-index: 40;
        overflow-y: auto;
        overflow-x: hidden;
        scrollbar-width: thin;
        scrollbar-color: rgba(255,255,255,.08) transparent;
        transition: transform .28s cubic-bezier(.4,0,.2,1);
    }
    .sidebar::-webkit-scrollbar { width: 4px; }
    .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.08); border-radius: 99px; }

    /* brand */
    .sb-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 18px 18px 14px;
        border-bottom: 1px solid rgba(255,255,255,.07);
        text-decoration: none;
        flex-shrink: 0;
    }
    .sb-brand-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.18);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .sb-brand-icon span {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800; font-size: 16px; color: #fff;
    }
    .sb-brand-name {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800; font-size: 14px; color: #fff;
        line-height: 1;
    }
    .sb-brand-sub {
        font-size: 10.5px; color: rgba(255,255,255,.4); margin-top: 2px;
    }

    /* role badge */
    .sb-role-badge {
        margin: 12px 14px 8px;
        padding: 8px 12px;
        background: rgba(255,255,255,.05);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 10px;
        display: flex; align-items: center; gap: 9px;
        flex-shrink: 0;
    }
    .sb-role-avatar {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800; font-size: 13px; color: #fff;
        flex-shrink: 0;
    }
    .sb-role-name {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px; font-weight: 700; color: #fff;
        line-height: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .sb-role-tag {
        font-size: 10px; color: rgba(255,255,255,.4); margin-top: 2px;
        text-transform: uppercase; letter-spacing: .05em;
    }

    /* section label */
    .sb-section {
        padding: 16px 18px 5px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 9.5px; font-weight: 800;
        letter-spacing: .1em; text-transform: uppercase;
        color: rgba(255,255,255,.25);
        flex-shrink: 0;
    }

    /* nav item */
    .sb-item {
        display: flex; align-items: center; gap: 9px;
        padding: 8px 18px;
        margin: 1px 8px;
        border-radius: 9px;
        text-decoration: none;
        color: var(--sidebar-text);
        font-family: 'DM Sans', sans-serif;
        font-size: 13.5px; font-weight: 500;
        transition: background .15s, color .15s;
        cursor: pointer;
        border: none; background: transparent; width: calc(100% - 16px);
        text-align: left;
    }
    .sb-item:hover { background: var(--sidebar-hover); color: rgba(255,255,255,.9); }
    .sb-item.active {
        background: var(--sidebar-active-bg);
        color: var(--sidebar-active-text);
        font-weight: 600;
    }
    .sb-item svg { flex-shrink: 0; opacity: .75; }
    .sb-item.active svg { opacity: 1; }
    .sb-item span.badge {
        margin-left: auto;
        font-size: 10px; font-weight: 700;
        background: rgba(53,130,240,.3);
        color: #93c5fd;
        padding: 1px 7px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* collapsible group */
    .sb-group { flex-shrink: 0; }
    .sb-group-header {
        display: flex; align-items: center; gap: 9px;
        padding: 8px 18px; margin: 1px 8px;
        border-radius: 9px;
        color: var(--sidebar-text);
        font-family: 'DM Sans', sans-serif;
        font-size: 13.5px; font-weight: 500;
        cursor: pointer;
        user-select: none;
        transition: background .15s, color .15s;
        list-style: none;
    }
    .sb-group-header:hover { background: var(--sidebar-hover); color: rgba(255,255,255,.9); }
    .sb-group-header svg.chevron {
        margin-left: auto; flex-shrink: 0; opacity: .5;
        transition: transform .2s;
    }
    details[open] .sb-group-header svg.chevron { transform: rotate(180deg); }
    .sb-sub { padding-left: 14px; }
    .sb-sub .sb-item {
        font-size: 12.5px;
        color: rgba(255,255,255,.5);
        padding: 6px 14px;
    }
    .sb-sub .sb-item:hover { color: rgba(255,255,255,.85); }
    .sb-sub .sb-item.active { color: #93c5fd; }

    /* bottom spacer */
    .sb-bottom {
        margin-top: auto;
        padding: 12px 8px;
        border-top: 1px solid rgba(255,255,255,.07);
        flex-shrink: 0;
    }

    /* ══════════════════════════════
       TOPBAR
    ══════════════════════════════ */
    .topbar {
        position: fixed;
        top: 0; right: 0;
        left: var(--sidebar-w);
        height: var(--topbar-h);
        background: var(--topbar-bg);
        border-bottom: 1px solid var(--topbar-border);
        display: flex; align-items: center;
        padding: 0 24px;
        gap: 12px;
        z-index: 30;
        transition: left .28s cubic-bezier(.4,0,.2,1);
    }

    .topbar-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700; font-size: 15px; color: #0f172a;
        flex: 1;
    }

    .topbar-actions { display: flex; align-items: center; gap: 8px; }

    .tb-btn {
        width: 36px; height: 36px;
        border-radius: 9px;
        border: 1px solid #e2e8f0;
        background: transparent;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; color: #64748b;
        transition: background .15s, color .15s;
        position: relative;
    }
    .tb-btn:hover { background: #f8fafc; color: #0f172a; }
    .tb-notif-dot {
        position: absolute; top: 7px; right: 7px;
        width: 7px; height: 7px;
        background: #ef4444; border-radius: 50%;
        border: 1.5px solid #fff;
    }

    .tb-user {
        display: flex; align-items: center; gap: 9px;
        padding: 5px 10px 5px 6px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        cursor: pointer;
        background: transparent;
        transition: background .15s;
        position: relative;
    }
    .tb-user:hover { background: #f8fafc; }
    .tb-avatar {
        width: 28px; height: 28px;
        border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800; font-size: 11px; color: #fff;
    }
    .tb-uname {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px; font-weight: 700; color: #0f172a;
        max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .tb-urole {
        font-size: 11px; color: #64748b; line-height: 1;
        font-family: 'DM Sans', sans-serif;
    }

    /* dropdown */
    .tb-dropdown {
        position: absolute;
        top: calc(100% + 8px); right: 0;
        min-width: 190px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        box-shadow: 0 8px 32px rgba(15,23,42,.12);
        padding: 6px;
        display: none; z-index: 100;
    }
    .tb-dropdown.open { display: block; }
    .tb-dd-item {
        display: flex; align-items: center; gap: 9px;
        padding: 8px 10px;
        border-radius: 8px;
        text-decoration: none;
        font-family: 'DM Sans', sans-serif;
        font-size: 13.5px; color: #334155;
        transition: background .12s;
        cursor: pointer; border: none; background: transparent; width: 100%; text-align: left;
    }
    .tb-dd-item:hover { background: #f8fafc; }
    .tb-dd-item.danger { color: #dc2626; }
    .tb-dd-item.danger:hover { background: #fef2f2; }
    .tb-dd-sep { height: 1px; background: #f1f5f9; margin: 4px 0; }

    /* ══════════════════════════════
       MAIN CONTENT AREA
    ══════════════════════════════ */
    .main-wrap {
        margin-left: var(--sidebar-w);
        padding-top: var(--topbar-h);
        min-height: 100vh;
        flex: 1;
        transition: margin-left .28s cubic-bezier(.4,0,.2,1);
    }

    /* ══════════════════════════════
       MOBILE OVERLAY
    ══════════════════════════════ */
    .sb-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(15,31,74,.55);
        backdrop-filter: blur(3px);
        z-index: 39;
    }

    .mobile-toggle {
        display: none;
        width: 36px; height: 36px;
        align-items: center; justify-content: center;
        border-radius: 9px; border: 1px solid #e2e8f0;
        background: transparent; cursor: pointer; color: #334155;
        transition: background .15s;
    }
    .mobile-toggle:hover { background: #f8fafc; }

    @media (max-width: 768px) {
        .sidebar { transform: translateX(-100%); }
        .sidebar.open { transform: translateX(0); }
        .sb-overlay.open { display: block; }
        .topbar { left: 0; }
        .main-wrap { margin-left: 0; }
        .mobile-toggle { display: flex; }
        .topbar-title { font-size: 14px; }
    }

    /* ══════════════════════════════
       ROLE COLOR MAP
    ══════════════════════════════ */
    .role-admin    { background: #1f63db; }
    .role-guru     { background: #be185d; }
    .role-piket    { background: #d97706; }
    .role-siswa    { background: #059669; }
    .role-ortu     { background: #7c3aed; }
</style>

{{-- ─── Sidebar overlay (mobile) ─── --}}
<div class="sb-overlay" id="sbOverlay" onclick="closeSidebar()"></div>

{{-- ══════════ SIDEBAR ══════════ --}}
<aside class="sidebar" id="sidebar">

    {{-- Brand --}}
    <a href="{{ route('dashboard') }}" class="sb-brand">
        <div class="sb-brand-icon"><span>B</span></div>
        <div>
            <p class="sb-brand-name">SmartSchool</p>
            <p class="sb-brand-sub">SMK Bustanul Ulum</p>
        </div>
    </a>

    {{-- User badge --}}
    @php $user = Auth::user(); $role = $user->role ?? 'siswa'; @endphp
    <div class="sb-role-badge">
        <div class="sb-role-avatar role-{{ $role === 'guru_piket' ? 'piket' : $role }}">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div style="overflow:hidden;">
            <p class="sb-role-name">{{ $user->name }}</p>
            <p class="sb-role-tag">
                @switch($role)
                    @case('admin')       Administrator @break
                    @case('guru')        Guru @break
                    @case('guru_piket')  Guru Piket @break
                    @case('siswa')       Siswa @break
                    @case('orang_tua')   Orang Tua @break
                    @default             {{ ucfirst($role) }}
                @endswitch
            </p>
        </div>
    </div>

    {{-- ═══════ ADMIN MENU ═══════ --}}
    @if($role === 'admin')

    <p class="sb-section">Utama</p>
    <a href="{{ route('dashboard') }}" class="sb-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
        Dashboard
    </a>

    <p class="sb-section">Manajemen</p>
    <details class="sb-group" {{ request()->routeIs(
        'admin.teachers.*',
        'admin.students.*',
        'admin.parents.*',
        'admin.piket-teachers.*',
        'admin.users',
        'admin.roles.*',
        'admin.permissions.*',
        'admin.role-permission.*') ? 'open' : '' }}>
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            Manajemen User
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M6 9l6 6 6-6"/>
            </svg>
        </summary>
        <div class="sb-sub">
            <a href="{{ route('admin.teachers.index') }}"
               class="sb-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                Data Guru
            </a>
            <a href="{{ route('admin.students.index') }}"
               class="sb-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                Data Siswa
            </a>
            <a href="{{ route('admin.parents.index') }}"
               class="sb-item {{ request()->routeIs('admin.parents.*') ? 'active' : '' }}">
                Data Orang Tua
            </a>
            <a href="{{ route('admin.piket-teachers.index') }}"
               class="sb-item {{ request()->routeIs('admin.piket-teachers.*') ? 'active' : '' }}">
                Data Guru Piket
            </a>
            <a href="{{ route('admin.users') }}"
               class="sb-item {{ request()->routeIs(
                   'admin.users',
                   'admin.roles.*',
                   'admin.permissions.*',
                   'admin.role-permission.*'
               ) ? 'active' : '' }}">
                Role &amp; Permission
            </a>
        </div>
    </details>

    <details class="sb-group" {{ request()->routeIs(
            'admin.classes.*',
            'admin.subjects.*',
            'admin.academic-years.*',
            'admin.schedules.*') ? 'open' : '' }}>
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            Manajemen Akademik
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M6 9l6 6 6-6"/>
            </svg>
        </summary>
        <div class="sb-sub">
            <a href="{{ route('admin.classes.index') }}"
            class="sb-item {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
                Data Kelas
            </a>
            <a href="{{ route('admin.subjects.index') }}"
            class="sb-item {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}">
                Data Mata Pelajaran
            </a>
            <a href="{{ route('admin.academic-years.index') }}"
            class="sb-item {{ request()->routeIs('admin.academic-years.*') ? 'active' : '' }}">
                Tahun Ajaran
            </a>
            <a href="{{ route('admin.schedules.index') }}"
            class="sb-item {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                Jadwal Pelajaran
            </a>
        </div>
    </details>

    <details class="sb-group" {{ Request::is(
        'admin/materials*',
        'admin/assignments*',
        'admin/assignment-submissions*',
        'admin/exams*',
        'admin/grades*',
        'admin/lms*') ? 'open' : '' }}>
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            LMS Management
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="{{ route('admin.materials.index') }}"
               class="sb-item {{ Request::is('admin/materials*') ? 'active' : '' }}">
                Semua Materi
            </a>
            <a href="{{ route('admin.assignments.index') }}"
               class="sb-item {{ Request::is('admin/assignments') || request()->routeIs('admin.assignments.*') && !Request::is('admin/assignment-submissions*') ? 'active' : '' }}">
                Semua Tugas
            </a>
            {{-- ★ BARU: Submission Tugas ★ --}}
            <a href="{{ route('admin.assignment-submissions.index') }}"
               class="sb-item {{ Request::is('admin/assignment-submissions*') ? 'active' : '' }}">
                Submission Tugas
            </a>
            <a href="{{ route('admin.exams.index') }}"
               class="sb-item {{ Request::is('admin/exams*') ? 'active' : '' }}">
                Semua Ujian
            </a>
            <a href="{{ route('admin.grades.index') }}"
               class="sb-item {{ Request::is('admin/grades*') ? 'active' : '' }}">
                Nilai Siswa
            </a>
            <a href="{{ route('admin.lms.monitoring') }}"
               class="sb-item {{ Request::is('admin/lms*') ? 'active' : '' }}">
                Monitoring LMS
            </a>
        </div>
    </details>

    <details class="sb-group">
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Manajemen Absensi
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="#" class="sb-item">Data Absensi Siswa</a>
            <a href="#" class="sb-item">Rekap Absensi</a>
            <a href="#" class="sb-item">Setting QR Code</a>
            <a href="#" class="sb-item">Riwayat Scan QR</a>
        </div>
    </details>

    <details class="sb-group">
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            Monitoring Kedisiplinan
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="#" class="sb-item">Data Pelanggaran</a>
            <a href="#" class="sb-item">Kategori Pelanggaran</a>
            <a href="#" class="sb-item">Poin Pelanggaran</a>
            <a href="#" class="sb-item">Rekap Pelanggaran</a>
        </div>
    </details>

    <p class="sb-section">Laporan</p>
    <details class="sb-group">
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            Laporan &amp; Analytics
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="#" class="sb-item">Laporan Absensi</a>
            <a href="#" class="sb-item">Laporan Nilai</a>
            <a href="#" class="sb-item">Laporan Pelanggaran</a>
            <a href="#" class="sb-item">Grafik &amp; Insight</a>
        </div>
    </details>

    <p class="sb-section">Sistem</p>
    <a href="#" class="sb-item">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        Notifikasi <span class="badge">Broadcast</span>
    </a>
    <details class="sb-group">
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
            Pengaturan
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="#" class="sb-item">Pengaturan Sistem</a>
            <a href="#" class="sb-item">Backup &amp; Restore</a>
            <a href="#" class="sb-item">API Settings</a>
        </div>
    </details>

    {{-- ═══════ GURU MENU ═══════ --}}
    @elseif($role === 'guru')

    <p class="sb-section">Utama</p>
    <a href="{{ route('dashboard') }}" class="sb-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
        Dashboard
    </a>

    <p class="sb-section">Pembelajaran</p>
    <details class="sb-group" open>
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            LMS
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="#" class="sb-item">Materi Saya</a>
            <a href="#" class="sb-item">Tugas</a>
            <a href="#" class="sb-item">Ujian / Quiz</a>
            <a href="#" class="sb-item">Penilaian</a>
        </div>
    </details>

    <a href="#" class="sb-item">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        Absensi Kelas
    </a>
    <a href="#" class="sb-item">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        Jurnal Mengajar
    </a>

    <p class="sb-section">Nilai &amp; Siswa</p>
    <details class="sb-group">
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            Nilai Siswa
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="#" class="sb-item">Input Nilai</a>
            <a href="#" class="sb-item">Rekap Nilai</a>
        </div>
    </details>
    <details class="sb-group">
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            Data Siswa
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="#" class="sb-item">Daftar Siswa Kelas</a>
            <a href="#" class="sb-item">Detail Siswa</a>
        </div>
    </details>
    <a href="#" class="sb-item">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        Notifikasi
    </a>

    {{-- ═══════ GURU PIKET MENU ═══════ --}}
    @elseif($role === 'guru_piket')

    <p class="sb-section">Utama</p>
    <a href="{{ route('dashboard') }}" class="sb-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
        Dashboard
    </a>

    <p class="sb-section">Kedisiplinan</p>
    <details class="sb-group" open>
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            Pelanggaran Siswa
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="#" class="sb-item">Input Pelanggaran</a>
            <a href="#" class="sb-item">Riwayat Pelanggaran</a>
            <a href="#" class="sb-item">Detail Pelanggaran</a>
        </div>
    </details>
    <details class="sb-group">
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            Monitoring Siswa
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="#" class="sb-item">Siswa Bermasalah</a>
            <a href="#" class="sb-item">Ranking Pelanggaran</a>
        </div>
    </details>
    <details class="sb-group">
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Monitoring Kelas
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="#" class="sb-item">Kelas Kosong</a>
            <a href="#" class="sb-item">Aktivitas Kelas</a>
        </div>
    </details>

    <p class="sb-section">Laporan</p>
    <details class="sb-group">
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Laporan Harian
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="#" class="sb-item">Input Laporan</a>
            <a href="#" class="sb-item">Riwayat Laporan</a>
        </div>
    </details>
    <a href="#" class="sb-item">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        Notifikasi
    </a>

    {{-- ═══════ SISWA MENU ═══════ --}}
    @elseif($role === 'siswa')

    <p class="sb-section">Utama</p>
    <a href="{{ route('dashboard') }}" class="sb-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
        Beranda
    </a>

    <p class="sb-section">Pembelajaran</p>
    <details class="sb-group" open>
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            Pembelajaran
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="#" class="sb-item">Materi</a>
            <a href="#" class="sb-item">Tugas</a>
            <a href="#" class="sb-item">Ujian / Quiz</a>
        </div>
    </details>
    <details class="sb-group">
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Absensi
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="#" class="sb-item">Scan QR Code</a>
            <a href="#" class="sb-item">Riwayat Absensi</a>
        </div>
    </details>

    <p class="sb-section">Akademik</p>
    <details class="sb-group">
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            Nilai
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="#" class="sb-item">Nilai per Mapel</a>
            <a href="#" class="sb-item">Rekap Nilai</a>
        </div>
    </details>
    <a href="#" class="sb-item">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>
        Kedisiplinan
    </a>
    <a href="#" class="sb-item">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        Notifikasi
    </a>

    {{-- ═══════ ORANG TUA MENU ═══════ --}}
    @elseif($role === 'orang_tua')

    <p class="sb-section">Utama</p>
    <a href="{{ route('dashboard') }}" class="sb-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
        Beranda
    </a>

    <p class="sb-section">Pantau Anak</p>
    <details class="sb-group" open>
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            Akademik Anak
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="#" class="sb-item">Nilai</a>
            <a href="#" class="sb-item">Progress Belajar</a>
        </div>
    </details>
    <details class="sb-group">
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Absensi Anak
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="#" class="sb-item">Riwayat Kehadiran</a>
            <a href="#" class="sb-item">Status Harian</a>
        </div>
    </details>
    <details class="sb-group">
        <summary class="sb-group-header">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>
            Kedisiplinan Anak
            <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="sb-sub">
            <a href="#" class="sb-item">Riwayat Pelanggaran</a>
            <a href="#" class="sb-item">Total Poin</a>
            <a href="#" class="sb-item">Status Anak</a>
        </div>
    </details>
    <a href="#" class="sb-item">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        Notifikasi
    </a>

    @endif

    {{-- Bottom: Profile & Logout ── selalu tampil semua role --}}
    <div class="sb-bottom">
        <a href="{{ route('profile.edit') }}" class="sb-item">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            Profil Saya
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb-item" style="color:rgba(248,113,113,.75);">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Keluar
            </button>
        </form>
    </div>

</aside>

{{-- ══════════ TOPBAR ══════════ --}}
<div class="topbar" id="topbar">

    {{-- Mobile hamburger --}}
    <button class="mobile-toggle" onclick="openSidebar()">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>

    <p class="topbar-title" id="topbarTitle">Dashboard</p>

    <div class="topbar-actions">

        {{-- Notif --}}
        <button class="tb-btn">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            <span class="tb-notif-dot"></span>
        </button>

        {{-- User dropdown --}}
        <div style="position:relative;">
            <button class="tb-user" onclick="toggleDropdown()">
                @php $role = Auth::user()->role ?? 'siswa'; @endphp
                <div class="tb-avatar role-{{ $role === 'guru_piket' ? 'piket' : $role }}">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="tb-uname">{{ Auth::user()->name }}</p>
                    <p class="tb-urole">
                        @switch($role)
                            @case('admin') Admin @break
                            @case('guru') Guru @break
                            @case('guru_piket') Guru Piket @break
                            @case('siswa') Siswa @break
                            @case('orang_tua') Orang Tua @break
                            @default {{ ucfirst($role) }}
                        @endswitch
                    </p>
                </div>
                <svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </button>

            <div class="tb-dropdown" id="userDropdown">
                <a href="{{ route('profile.edit') }}" class="tb-dd-item">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    Profil Saya
                </a>
                <div class="tb-dd-sep"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="tb-dd-item danger">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function openSidebar()  { document.getElementById('sidebar').classList.add('open'); document.getElementById('sbOverlay').classList.add('open'); }
    function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sbOverlay').classList.remove('open'); }

    function toggleDropdown() {
        document.getElementById('userDropdown').classList.toggle('open');
    }
    document.addEventListener('click', function(e) {
        const dd = document.getElementById('userDropdown');
        if (!e.target.closest('.tb-user') && !e.target.closest('#userDropdown')) {
            dd.classList.remove('open');
        }
    });

    // Auto-set topbar title from active sidebar item
    document.addEventListener('DOMContentLoaded', () => {
        const active = document.querySelector('.sb-item.active');
        if (active) document.getElementById('topbarTitle').textContent = active.textContent.trim();

        document.querySelectorAll('.sb-item:not(.active)').forEach(item => {
            item.addEventListener('click', () => {
                document.getElementById('topbarTitle').textContent = item.textContent.trim();
            });
        });
    });
</script>