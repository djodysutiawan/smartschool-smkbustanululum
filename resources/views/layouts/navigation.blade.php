{{--
    resources/views/components/navigation.blade.php
    Sidebar + Topbar — role-based menu
    Roles: admin | guru | guru_piket | siswa | orang_tua
--}}

@php
    $user    = Auth::user();
    $role    = $user->role ?? 'siswa';
    $unread  = $user->notifikasiTidakTerbaca()->count();
    $notifs  = $user->notifikasi()->latest()->take(5)->get();

    // Avatar: foto dari profil masing-masing role, fallback ke User avatar, fallback ke inisial
    $fotoUrl = match($role) {
        'guru'       => $user->guru?->foto_url ?? $user->avatar_url,
        'siswa'      => $user->siswa?->foto_url ?? $user->avatar_url,
        'orang_tua'  => $user->avatar_url,
        'guru_piket' => $user->guru?->foto_url ?? $user->avatar_url,
        default      => $user->avatar_url,
    };

    $namaLengkap = match($role) {
        'guru'      => $user->guru?->nama_lengkap ?? $user->name,
        'siswa'     => $user->siswa?->nama_lengkap ?? $user->name,
        'orang_tua' => $user->orangTua?->nama_lengkap ?? $user->name,
        default     => $user->name,
    };

    $labelRole = match($role) {
        'admin'      => 'Administrator',
        'guru'       => 'Guru',
        'guru_piket' => 'Guru Piket',
        'siswa'      => 'Siswa',
        'orang_tua'  => 'Orang Tua',
        default      => ucfirst($role),
    };

    $inisial = strtoupper(substr($namaLengkap, 0, 1));

    $warnaBadge = match($role) {
        'admin'      => '#1f63db',
        'guru'       => '#be185d',
        'guru_piket' => '#d97706',
        'siswa'      => '#059669',
        'orang_tua'  => '#7c3aed',
        default      => '#64748b',
    };

    $iconJenis = [
        'info'        => '💬',
        'peringatan'  => '⚠️',
        'pelanggaran' => '🚨',
        'absensi'     => '📅',
        'nilai'       => '📊',
        'pengumuman'  => '📢',
        'tugas'       => '📝',
        'ujian'       => '📋',
    ];
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');

    :root {
        --sb-w: 256px;
        --tb-h: 60px;
        --sb-bg: #0f1f4a;
        --sb-text: rgba(255,255,255,.62);
        --sb-hover: rgba(255,255,255,.07);
        --sb-active-bg: rgba(53,130,240,.17);
        --sb-active-text: #93c5fd;
        --brand: #1f63db;
    }

    *, *::before, *::after { box-sizing: border-box; }

    body { font-family: 'DM Sans', sans-serif; background: #f1f5f9; margin: 0; }

    .layout-shell { display: flex; min-height: 100vh; }

    /* ── Sidebar ── */
    .sidebar {
        width: var(--sb-w); background: var(--sb-bg);
        display: flex; flex-direction: column;
        position: fixed; inset: 0 auto 0 0;
        z-index: 40; overflow-y: auto; overflow-x: hidden;
        scrollbar-width: thin; scrollbar-color: rgba(255,255,255,.07) transparent;
        transition: transform .26s cubic-bezier(.4,0,.2,1);
    }
    .sidebar::-webkit-scrollbar { width: 3px; }
    .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.08); border-radius: 99px; }

    .sb-brand {
        display: flex; align-items: center; gap: 10px;
        padding: 17px 17px 13px; border-bottom: 1px solid rgba(255,255,255,.07);
        text-decoration: none; flex-shrink: 0;
    }
    .sb-brand-icon {
        width: 35px; height: 35px; border-radius: 9px;
        background: rgba(255,255,255,.11); border: 1px solid rgba(255,255,255,.16);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .sb-brand-icon span { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 15px; color: #fff; }
    .sb-brand-name { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 13.5px; color: #fff; line-height: 1; }
    .sb-brand-sub  { font-size: 10px; color: rgba(255,255,255,.38); margin-top: 2px; }

    .sb-user {
        margin: 11px 13px 7px;
        padding: 8px 10px;
        background: rgba(255,255,255,.05);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 10px;
        display: flex; align-items: center; gap: 9px;
        flex-shrink: 0;
    }
    .sb-user-avatar {
        width: 33px; height: 33px; border-radius: 8px;
        object-fit: cover; flex-shrink: 0;
        border: 1.5px solid rgba(255,255,255,.15);
    }
    .sb-user-avatar-fallback {
        width: 33px; height: 33px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800; font-size: 13px; color: #fff; flex-shrink: 0;
    }
    .sb-user-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: #fff; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .sb-user-role { font-size: 10px; color: rgba(255,255,255,.38); text-transform: uppercase; letter-spacing: .06em; }

    .sb-section {
        padding: 15px 17px 4px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 9px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase;
        color: rgba(255,255,255,.22); flex-shrink: 0;
    }

    .sb-item {
        display: flex; align-items: center; gap: 8px;
        padding: 7.5px 17px; margin: 1px 7px;
        border-radius: 8px; text-decoration: none;
        color: var(--sb-text); font-size: 13px; font-weight: 500;
        transition: background .13s, color .13s;
        cursor: pointer; border: none; background: transparent;
        width: calc(100% - 14px); text-align: left;
    }
    .sb-item:hover { background: var(--sb-hover); color: rgba(255,255,255,.88); }
    .sb-item.active { background: var(--sb-active-bg); color: var(--sb-active-text); font-weight: 600; }
    .sb-item svg { flex-shrink: 0; opacity: .72; }
    .sb-item.active svg { opacity: 1; }
    .sb-badge-count {
        margin-left: auto; font-size: 9.5px; font-weight: 700;
        background: #dc2626; color: #fff;
        padding: 1px 6px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .sb-group { flex-shrink: 0; }
    .sb-group-header {
        display: flex; align-items: center; gap: 8px;
        padding: 7.5px 17px; margin: 1px 7px; border-radius: 8px;
        color: var(--sb-text); font-size: 13px; font-weight: 500;
        cursor: pointer; user-select: none; list-style: none;
        transition: background .13s, color .13s;
    }
    .sb-group-header:hover { background: var(--sb-hover); color: rgba(255,255,255,.88); }
    .sb-group-header svg { flex-shrink: 0; opacity: .7; }
    .sb-chevron { margin-left: auto; flex-shrink: 0; opacity: .45; transition: transform .18s; }
    details[open] .sb-chevron { transform: rotate(180deg); }

    .sb-sub { padding-left: 12px; }
    .sb-sub .sb-item { font-size: 12.5px; color: rgba(255,255,255,.48); padding: 6px 13px; }
    .sb-sub .sb-item:hover { color: rgba(255,255,255,.82); }
    .sb-sub .sb-item.active { color: #93c5fd; }

    .sb-bottom {
        margin-top: auto; padding: 10px 7px;
        border-top: 1px solid rgba(255,255,255,.07); flex-shrink: 0;
    }
    .sb-divider { height: 1px; background: rgba(255,255,255,.07); margin: 6px 17px; }

    /* ── Topbar ── */
    .topbar {
        position: fixed; top: 0; right: 0; left: var(--sb-w);
        height: var(--tb-h); background: #fff; border-bottom: 1px solid #e2e8f0;
        display: flex; align-items: center; padding: 0 22px; gap: 10px;
        z-index: 30; transition: left .26s cubic-bezier(.4,0,.2,1);
    }
    .topbar-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 14.5px; color: #0f172a; flex: 1; }
    .topbar-actions { display: flex; align-items: center; gap: 7px; }

    .tb-btn {
        width: 35px; height: 35px; border-radius: 8px;
        border: 1px solid #e2e8f0; background: transparent;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; color: #64748b; position: relative;
        transition: background .13s, color .13s;
    }
    .tb-btn:hover { background: #f8fafc; color: #0f172a; }
    .tb-notif-dot {
        position: absolute; top: 6px; right: 6px;
        width: 7px; height: 7px; background: #ef4444;
        border-radius: 50%; border: 1.5px solid #fff;
    }

    .tb-user-btn {
        display: flex; align-items: center; gap: 8px;
        padding: 4px 10px 4px 5px; border: 1px solid #e2e8f0;
        border-radius: 9px; cursor: pointer; background: transparent;
        transition: background .13s; position: relative;
    }
    .tb-user-btn:hover { background: #f8fafc; }
    .tb-avatar-img  { width: 27px; height: 27px; border-radius: 6px; object-fit: cover; }
    .tb-avatar-text {
        width: 27px; height: 27px; border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 11px; color: #fff;
    }
    .tb-uname { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: #0f172a; max-width: 110px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; line-height: 1.2; }
    .tb-urole { font-size: 10.5px; color: #64748b; }

    /* Dropdown generic */
    .tb-dropdown {
        position: absolute; top: calc(100% + 7px); right: 0;
        background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
        box-shadow: 0 8px 28px rgba(15,23,42,.1); padding: 5px;
        display: none; z-index: 100; min-width: 190px;
    }
    .tb-dropdown.open { display: block; }

    .tb-dd-item {
        display: flex; align-items: center; gap: 8px;
        padding: 7.5px 10px; border-radius: 7px;
        text-decoration: none; font-size: 13px; color: #334155;
        transition: background .11s; cursor: pointer;
        border: none; background: transparent; width: 100%; text-align: left;
    }
    .tb-dd-item:hover { background: #f8fafc; }
    .tb-dd-item.danger { color: #dc2626; }
    .tb-dd-item.danger:hover { background: #fef2f2; }
    .tb-dd-sep { height: 1px; background: #f1f5f9; margin: 3px 0; }

    /* Notif dropdown */
    .notif-dropdown {
        position: absolute; top: calc(100% + 7px); right: 0;
        width: 320px; background: #fff; border: 1px solid #e2e8f0;
        border-radius: 13px; box-shadow: 0 8px 28px rgba(15,23,42,.1);
        display: none; z-index: 100; overflow: hidden;
    }
    .notif-dropdown.open { display: block; }
    .notif-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 14px 10px; border-bottom: 1px solid #f1f5f9;
    }
    .notif-header-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 13px; color: #0f172a; }
    .notif-mark-all { font-size: 11.5px; color: #1f63db; cursor: pointer; border: none; background: none; padding: 0; }
    .notif-mark-all:hover { text-decoration: underline; }
    .notif-list { max-height: 280px; overflow-y: auto; }
    .notif-item {
        display: flex; gap: 10px; padding: 10px 14px;
        border-bottom: 1px solid #f8fafc; transition: background .12s;
        text-decoration: none;
    }
    .notif-item:hover { background: #f8fafc; }
    .notif-item.unread { background: #eff6ff; }
    .notif-item.unread:hover { background: #dbeafe; }
    .notif-icon { font-size: 17px; flex-shrink: 0; margin-top: 1px; }
    .notif-judul { font-size: 12.5px; font-weight: 600; color: #0f172a; line-height: 1.3; }
    .notif-pesan { font-size: 11.5px; color: #64748b; margin-top: 2px; line-height: 1.4; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 230px; }
    .notif-waktu { font-size: 10.5px; color: #94a3b8; margin-top: 3px; }
    .notif-unread-dot { width: 7px; height: 7px; background: #1f63db; border-radius: 50%; flex-shrink: 0; margin-top: 5px; }
    .notif-empty { padding: 28px 14px; text-align: center; font-size: 12.5px; color: #94a3b8; }
    .notif-footer { padding: 9px 14px; border-top: 1px solid #f1f5f9; text-align: center; }
    .notif-footer a { font-size: 12px; color: #1f63db; text-decoration: none; font-weight: 600; }
    .notif-footer a:hover { text-decoration: underline; }

    /* Main wrap */
    .main-wrap {
        margin-left: var(--sb-w); padding-top: var(--tb-h);
        min-height: 100vh; flex: 1;
        transition: margin-left .26s cubic-bezier(.4,0,.2,1);
    }

    /* Mobile */
    .sb-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(15,31,74,.5); backdrop-filter: blur(2px); z-index: 39;
    }
    .mobile-toggle {
        display: none; width: 35px; height: 35px;
        align-items: center; justify-content: center;
        border-radius: 8px; border: 1px solid #e2e8f0;
        background: transparent; cursor: pointer; color: #334155;
    }
    @media (max-width: 768px) {
        .sidebar { transform: translateX(-100%); }
        .sidebar.open { transform: translateX(0); }
        .sb-overlay.open { display: block; }
        .topbar { left: 0; }
        .main-wrap { margin-left: 0; }
        .mobile-toggle { display: flex; }
    }
</style>

{{-- Overlay mobile --}}
<div class="sb-overlay" id="sbOverlay" onclick="closeSidebar()"></div>

{{-- ══ SIDEBAR ══ --}}
<aside class="sidebar" id="sidebar">

    @php $profil = \App\Models\ProfilSekolah::instance(); @endphp

    <a href="{{ route('dashboard') }}" class="sb-brand">
        <div class="sb-brand-icon">
            @if($profil->logo_path)
                <img src="{{ Storage::url($profil->logo_path) }}" alt="Logo" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;">
            @elseif($profil->logo_url)
                <img src="{{ $profil->logo_url }}" alt="Logo" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;">
            @else
                <span>S</span>
            @endif
        </div>
        <div>
            <p class="sb-brand-name">SmartSchool</p>
            <p class="sb-brand-sub">{{ $profil->nama_sekolah ?? 'SMK Bustanul Ulum' }}</p>
        </div>
    </a>

    {{-- User info real-time dari DB --}}
    <div class="sb-user">
        @if($user->avatar)
            <img src="{{ $user->avatar_url }}" alt="{{ $namaLengkap }}" class="sb-user-avatar">
        @else
            <div class="sb-user-avatar-fallback" style="background:{{ $warnaBadge }}">{{ $inisial }}</div>
        @endif
        <div style="overflow:hidden; min-width:0;">
            <p class="sb-user-name">{{ $namaLengkap }}</p>
            <p class="sb-user-role">{{ $labelRole }}</p>
        </div>
    </div>


    {{-- ════════════════════════════════════════════════════════
        ADMIN
    ════════════════════════════════════════════════════════ --}}
    @if($role === 'admin')

        {{-- ── UTAMA ─────────────────────────────────────────── --}}
        <p class="sb-section">Utama</p>

        <a href="{{ route('admin.dashboard') }}"
        class="sb-item {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
            </svg>
            Dashboard
        </a>

        {{-- ── MANAJEMEN ─────────────────────────────────────── --}}
        <p class="sb-section">Manajemen</p>

        {{-- Pengguna & SDM --}}
        <details class="sb-group" {{ request()->routeIs('admin.users.*','admin.guru.*','admin.siswa.*','admin.orang-tua.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Pengguna & SDM
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('admin.users.index') }}"     class="sb-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Semua Pengguna</a>
                <a href="{{ route('admin.guru.index') }}"      class="sb-item {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">Data Guru</a>
                <a href="{{ route('admin.siswa.index') }}"     class="sb-item {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">Data Siswa</a>
                <a href="{{ route('admin.orang-tua.index') }}" class="sb-item {{ request()->routeIs('admin.orang-tua.*') ? 'active' : '' }}">Data Orang Tua</a>
            </div>
        </details>

        {{-- ── AKADEMIK ──────────────────────────────────────── --}}
        <p class="sb-section">Akademik</p>

        {{-- Akademik Umum --}}
        <details class="sb-group" {{ request()->routeIs('admin.tahun-ajaran.*','admin.kelas.*','admin.mata-pelajaran.*','admin.gedung.*','admin.ruang.*','admin.jadwal-pelajaran.*','admin.ketersediaan-guru.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Akademik
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('admin.tahun-ajaran.index') }}"      class="sb-item {{ request()->routeIs('admin.tahun-ajaran.*') ? 'active' : '' }}">Tahun Ajaran</a>
                <a href="{{ route('admin.kelas.index') }}"             class="sb-item {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">Data Kelas</a>
                <a href="{{ route('admin.mata-pelajaran.index') }}"    class="sb-item {{ request()->routeIs('admin.mata-pelajaran.*') ? 'active' : '' }}">Mata Pelajaran</a>
                <a href="{{ route('admin.gedung.index') }}"            class="sb-item {{ request()->routeIs('admin.gedung.*') ? 'active' : '' }}">Gedung & Ruang</a>
                <a href="{{ route('admin.ruang.index') }}"             class="sb-item {{ request()->routeIs('admin.ruang.*') ? 'active' : '' }}">Data Ruang</a>
                <a href="{{ route('admin.jadwal-pelajaran.index') }}"  class="sb-item {{ request()->routeIs('admin.jadwal-pelajaran.*') ? 'active' : '' }}">Jadwal Pelajaran</a>
                <a href="{{ route('admin.ketersediaan-guru.index') }}" class="sb-item {{ request()->routeIs('admin.ketersediaan-guru.*') ? 'active' : '' }}">Ketersediaan Guru</a>
            </div>
        </details>

        {{-- Jurusan --}}
        <details class="sb-group" {{ request()->routeIs('admin.jurusan.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                </svg>
                Jurusan
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('admin.jurusan.index') }}"  class="sb-item {{ request()->routeIs('admin.jurusan.index') ? 'active' : '' }}">Daftar Jurusan</a>
                <a href="{{ route('admin.jurusan.create') }}" class="sb-item {{ request()->routeIs('admin.jurusan.create') ? 'active' : '' }}">+ Tambah Jurusan</a>

                {{-- Sub-menu jurusan aktif (muncul saat sedang di dalam jurusan tertentu) --}}
                @if(request()->route('jurusan'))
                    @php $jrs = request()->route('jurusan') @endphp
                    <details class="sb-group sb-group--nested" open>
                        <summary class="sb-group-header sb-group-header--nested">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                            </svg>
                            {{ $jrs->singkatan ?? Str::limit($jrs->nama, 18) }}
                            <svg class="sb-chevron" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                        </summary>
                        <div class="sb-sub sb-sub--nested">
                            <a href="{{ route('admin.jurusan.show', $jrs) }}"
                            class="sb-item {{ request()->routeIs('admin.jurusan.show') ? 'active' : '' }}">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                                Overview
                            </a>
                            <a href="{{ route('admin.jurusan.kurikulum.index', $jrs) }}"
                            class="sb-item {{ request()->routeIs('admin.jurusan.kurikulum.*') ? 'active' : '' }}">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h10"/></svg>
                                Kurikulum
                            </a>
                            <a href="{{ route('admin.jurusan.kompetensi.index', $jrs) }}"
                            class="sb-item {{ request()->routeIs('admin.jurusan.kompetensi.*') ? 'active' : '' }}">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                                Kompetensi
                            </a>
                            <a href="{{ route('admin.jurusan.prospek-kerja.index', $jrs) }}"
                            class="sb-item {{ request()->routeIs('admin.jurusan.prospek-kerja.*') ? 'active' : '' }}">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
                                Prospek Kerja
                            </a>
                            <a href="{{ route('admin.jurusan.fasilitas.index', $jrs) }}"
                            class="sb-item {{ request()->routeIs('admin.jurusan.fasilitas.*') ? 'active' : '' }}">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                Fasilitas
                            </a>
                        </div>
                    </details>
                @endif
            </div>
        </details>

        {{-- LMS / Pembelajaran --}}
        <details class="sb-group" {{ request()->routeIs('admin.materi.*','admin.tugas.*','admin.pengumpulan-tugas.*','admin.ujian.*','admin.nilai.*','admin.jurnal-mengajar.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/>
                    <path d="M2 12l10 5 10-5"/>
                </svg>
                LMS / Pembelajaran
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('admin.materi.index') }}"            class="sb-item {{ request()->routeIs('admin.materi.*') ? 'active' : '' }}">Materi</a>
                <a href="{{ route('admin.tugas.index') }}"             class="sb-item {{ request()->routeIs('admin.tugas.*') && !request()->routeIs('admin.pengumpulan-tugas.*') ? 'active' : '' }}">Tugas</a>
                <a href="{{ route('admin.pengumpulan-tugas.index') }}" class="sb-item {{ request()->routeIs('admin.pengumpulan-tugas.*') ? 'active' : '' }}">Pengumpulan Tugas</a>
                <a href="{{ route('admin.ujian.index') }}"             class="sb-item {{ request()->routeIs('admin.ujian.*') ? 'active' : '' }}">Ujian</a>
                <a href="{{ route('admin.nilai.index') }}"             class="sb-item {{ request()->routeIs('admin.nilai.*') ? 'active' : '' }}">Nilai Siswa</a>
                <a href="{{ route('admin.jurnal-mengajar.index') }}"   class="sb-item {{ request()->routeIs('admin.jurnal-mengajar.*') ? 'active' : '' }}">Jurnal Mengajar</a>
            </div>
        </details>

        {{-- Kedisiplinan --}}
        <details class="sb-group" {{ request()->routeIs('admin.pelanggaran.*','admin.kategori-pelanggaran.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                Kedisiplinan
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('admin.pelanggaran.index') }}"          class="sb-item {{ request()->routeIs('admin.pelanggaran.*') ? 'active' : '' }}">Data Pelanggaran</a>
                <a href="{{ route('admin.kategori-pelanggaran.index') }}" class="sb-item {{ request()->routeIs('admin.kategori-pelanggaran.*') ? 'active' : '' }}">Kategori Pelanggaran</a>
            </div>
        </details>

        {{-- ── ABSENSI & KEHADIRAN ───────────────────────────── --}}
        <p class="sb-section">Absensi & Kehadiran</p>

        {{-- Absensi Siswa --}}
        <details class="sb-group" {{ request()->routeIs('admin.absensi.*','admin.sesi-qr.*','admin.riwayat-scan.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                Absensi Siswa
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('admin.absensi.index') }}"      class="sb-item {{ request()->routeIs('admin.absensi.index','admin.absensi.create','admin.absensi.edit','admin.absensi.show') ? 'active' : '' }}">Data Absensi</a>
                <a href="{{ route('admin.sesi-qr.index') }}"      class="sb-item {{ request()->routeIs('admin.sesi-qr.*') ? 'active' : '' }}">Sesi QR Code</a>
                <a href="{{ route('admin.riwayat-scan.index') }}" class="sb-item {{ request()->routeIs('admin.riwayat-scan.*') ? 'active' : '' }}">Riwayat Scan</a>
            </div>
        </details>

        {{-- Absensi Guru --}}
        <details class="sb-group" {{ request()->routeIs('admin.absensi-guru.*','admin.absensi-guru-piket.*','admin.sesi-qr-guru.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M9 14v8"/>
                    <path d="M13 18h8"/>
                    <path d="M17 14v8"/>
                </svg>
                Absensi Guru
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('admin.absensi-guru.index') }}"           class="sb-item {{ request()->routeIs('admin.absensi-guru.index','admin.absensi-guru.create','admin.absensi-guru.show','admin.absensi-guru.edit') ? 'active' : '' }}">Data Absensi Guru</a>
                <a href="{{ route('admin.absensi-guru.rekap') }}"           class="sb-item {{ request()->routeIs('admin.absensi-guru.rekap') ? 'active' : '' }}">Rekap per Guru</a>
                <a href="{{ route('admin.absensi-guru-piket.dashboard') }}" class="sb-item {{ request()->routeIs('admin.absensi-guru-piket.*') ? 'active' : '' }}">Dashboard Piket Guru</a>
                <a href="{{ route('admin.sesi-qr-guru.index') }}"           class="sb-item {{ request()->routeIs('admin.sesi-qr-guru.*') ? 'active' : '' }}">Sesi QR Guru</a>
            </div>
        </details>

        {{-- Izin Keluar Siswa --}}
        <details class="sb-group" {{ request()->routeIs('admin.izin-keluar-siswa.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Izin Keluar Siswa
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('admin.izin-keluar-siswa.index') }}"
                class="sb-item {{ request()->routeIs('admin.izin-keluar-siswa.index') && !request('status') ? 'active' : '' }}">
                    Semua Izin
                </a>
                <a href="{{ route('admin.izin-keluar-siswa.index', ['status' => 'menunggu']) }}"
                class="sb-item {{ request()->routeIs('admin.izin-keluar-siswa.index') && request('status') === 'menunggu' ? 'active' : '' }}">
                    Menunggu Proses
                </a>
                <a href="{{ route('admin.izin-keluar-siswa.index', ['status' => 'disetujui']) }}"
                class="sb-item {{ request()->routeIs('admin.izin-keluar-siswa.index') && request('status') === 'disetujui' ? 'active' : '' }}">
                    Sedang Keluar
                </a>
                <a href="{{ route('admin.izin-keluar-siswa.create') }}"
                class="sb-item {{ request()->routeIs('admin.izin-keluar-siswa.create') ? 'active' : '' }}">
                    + Buat Izin Baru
                </a>
            </div>
        </details>

        {{-- ── MONITORING PIKET ──────────────────────────────── --}}
        <p class="sb-section">Monitoring Piket</p>

        {{-- Piket Guru --}}
        <details class="sb-group" {{ request()->routeIs('admin.jadwal-piket-guru.*','admin.log-piket.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                Piket Guru
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('admin.jadwal-piket-guru.index') }}" class="sb-item {{ request()->routeIs('admin.jadwal-piket-guru.*') ? 'active' : '' }}">Jadwal Piket</a>
                <a href="{{ route('admin.log-piket.index') }}"         class="sb-item {{ request()->routeIs('admin.log-piket.*') ? 'active' : '' }}">Log Piket</a>
            </div>
        </details>

        {{-- Laporan Harian Piket --}}
        <details class="sb-group" {{ request()->routeIs('admin.laporan-harian-piket.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <line x1="10" y1="9" x2="8" y2="9"/>
                </svg>
                Laporan Harian Piket
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('admin.laporan-harian-piket.index') }}"
                class="sb-item {{ request()->routeIs('admin.laporan-harian-piket.index') && !request('tanggal_dari') ? 'active' : '' }}">
                    Semua Laporan
                </a>
                <a href="{{ route('admin.laporan-harian-piket.index', ['tanggal_dari' => today()->toDateString(), 'tanggal_sampai' => today()->toDateString()]) }}"
                class="sb-item {{ request()->routeIs('admin.laporan-harian-piket.index') && request('tanggal_dari') === today()->toDateString() ? 'active' : '' }}">
                    Laporan Hari Ini
                </a>
                <a href="{{ route('admin.laporan-harian-piket.export-pdf', request()->query()) }}" class="sb-item">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    Export PDF
                </a>
            </div>
        </details>

        {{-- ── LAPORAN ───────────────────────────────────────── --}}
        <p class="sb-section">Laporan</p>

        <details class="sb-group" {{ request()->routeIs('admin.laporan.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                </svg>
                Laporan & Analytics
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('admin.laporan.index') }}"       class="sb-item {{ request()->routeIs('admin.laporan.index') ? 'active' : '' }}">Grafik & Insight</a>
                <a href="{{ route('admin.laporan.absensi') }}"     class="sb-item {{ request()->routeIs('admin.laporan.absensi') ? 'active' : '' }}">Laporan Absensi</a>
                <a href="{{ route('admin.laporan.nilai') }}"       class="sb-item {{ request()->routeIs('admin.laporan.nilai') ? 'active' : '' }}">Laporan Nilai</a>
                <a href="{{ route('admin.laporan.pelanggaran') }}" class="sb-item {{ request()->routeIs('admin.laporan.pelanggaran') ? 'active' : '' }}">Laporan Pelanggaran</a>
                <a href="{{ route('admin.laporan.siswa') }}"       class="sb-item {{ request()->routeIs('admin.laporan.siswa') ? 'active' : '' }}">Laporan Siswa</a>
                <a href="{{ route('admin.laporan.guru') }}"        class="sb-item {{ request()->routeIs('admin.laporan.guru') ? 'active' : '' }}">Laporan Guru</a>
            </div>
        </details>

        {{-- ── WEBSITE SEKOLAH ───────────────────────────────── --}}
        <p class="sb-section">Website Sekolah</p>

        {{-- Profil Sekolah --}}
        <a href="{{ route('admin.profil-sekolah.edit') }}"
        class="sb-item {{ request()->routeIs('admin.profil-sekolah.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
            </svg>
            Profil Sekolah
        </a>

        {{-- Berita & Konten --}}
        <details class="sb-group" {{ request()->routeIs('admin.berita.*','admin.berita-kategori.*','admin.agenda.*','admin.slider.*','admin.link-cepat.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 0-2 2zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/>
                    <path d="M18 14h-8"/>
                    <path d="M15 18h-5"/>
                    <path d="M10 6h8v4h-8z"/>
                </svg>
                Berita & Konten
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('admin.berita.index') }}"          class="sb-item {{ request()->routeIs('admin.berita.index','admin.berita.create','admin.berita.edit','admin.berita.show') ? 'active' : '' }}">Semua Berita</a>
                <a href="{{ route('admin.berita.create') }}"         class="sb-item {{ request()->routeIs('admin.berita.create') ? 'active' : '' }}">+ Tulis Berita</a>
                <a href="{{ route('admin.berita-kategori.index') }}" class="sb-item {{ request()->routeIs('admin.berita-kategori.*') ? 'active' : '' }}">Kategori Berita</a>
                <a href="{{ route('admin.agenda.index') }}"          class="sb-item {{ request()->routeIs('admin.agenda.*') ? 'active' : '' }}">Agenda Sekolah</a>
                <a href="{{ route('admin.slider.index') }}"          class="sb-item {{ request()->routeIs('admin.slider.*') ? 'active' : '' }}">Slider Beranda</a>
                <a href="{{ route('admin.link-cepat.index') }}"      class="sb-item {{ request()->routeIs('admin.link-cepat.*') ? 'active' : '' }}">Link Cepat</a>
            </div>
        </details>

        {{-- Gallery --}}
        <details class="sb-group" {{ request()->routeIs('admin.galeri.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <polyline points="21 15 16 10 5 21"/>
                </svg>
                Gallery
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('admin.galeri.kategori.index') }}" class="sb-item {{ request()->routeIs('admin.galeri.kategori.*') ? 'active' : '' }}">Kategori / Album</a>
                <a href="{{ route('admin.galeri.foto.index') }}"     class="sb-item {{ request()->routeIs('admin.galeri.foto.*') ? 'active' : '' }}">Gallery Foto</a>
                <a href="{{ route('admin.galeri.video.index') }}"    class="sb-item {{ request()->routeIs('admin.galeri.video.*') ? 'active' : '' }}">Gallery Video</a>
            </div>
        </details>

        {{-- Prestasi --}}
        <details class="sb-group" {{ request()->routeIs('admin.prestasi.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="6"/>
                    <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                </svg>
                Prestasi
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('admin.prestasi.index') }}"  class="sb-item {{ request()->routeIs('admin.prestasi.index','admin.prestasi.show','admin.prestasi.edit') ? 'active' : '' }}">Daftar Prestasi</a>
                <a href="{{ route('admin.prestasi.create') }}" class="sb-item {{ request()->routeIs('admin.prestasi.create') ? 'active' : '' }}">+ Tambah Prestasi</a>
            </div>
        </details>

        {{-- Pesan Masuk --}}
        <a href="{{ route('admin.kontak-pesan.index') }}"
        class="sb-item {{ request()->routeIs('admin.kontak-pesan.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
            Pesan Masuk
            @php $pesanBaru = \App\Models\KontakPesan::baru()->count(); @endphp
            @if($pesanBaru > 0)
                <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none">
                    {{ $pesanBaru > 99 ? '99+' : $pesanBaru }}
                </span>
            @endif
        </a>

        {{-- ── SISTEM ────────────────────────────────────────── --}}
        <p class="sb-section">Sistem</p>

        <a href="{{ route('admin.notifikasi.index') }}"
        class="sb-item {{ request()->routeIs('admin.notifikasi.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            Notifikasi
        </a>

        <a href="{{ route('admin.pengumuman.index') }}"
        class="sb-item {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
            Pengumuman
        </a>


    {{-- ════════════════════════════════════════════════════════
        GURU
    ════════════════════════════════════════════════════════ --}}
    @elseif($role === 'guru')

        {{-- ── UTAMA ─────────────────────────────────────────── --}}
        <p class="sb-section">Utama</p>

        <a href="{{ route('guru.dashboard') }}"
        class="sb-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('guru.jadwal.index') }}"
        class="sb-item {{ request()->routeIs('guru.jadwal.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Jadwal Mengajar
        </a>

        <a href="{{ route('guru.ketersediaan.index') }}"
        class="sb-item {{ request()->routeIs('guru.ketersediaan.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
            Ketersediaan Saya
        </a>

        {{-- ── KELAS & PEMBELAJARAN ──────────────────────────── --}}
        <p class="sb-section">Kelas & Pembelajaran</p>

        {{-- Materi & Tugas --}}
        <details class="sb-group" {{ request()->routeIs('guru.materi.*','guru.tugas.*','guru.pengumpulan-tugas.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/>
                    <path d="M2 12l10 5 10-5"/>
                </svg>
                Materi & Tugas
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('guru.materi.index') }}"            class="sb-item {{ request()->routeIs('guru.materi.*') ? 'active' : '' }}">Materi Pelajaran</a>
                <a href="{{ route('guru.tugas.index') }}"             class="sb-item {{ request()->routeIs('guru.tugas.*') ? 'active' : '' }}">Buat Tugas</a>
                <a href="{{ route('guru.pengumpulan-tugas.index') }}" class="sb-item {{ request()->routeIs('guru.pengumpulan-tugas.*') ? 'active' : '' }}">Nilai Pengumpulan</a>
            </div>
        </details>

        {{-- Ujian & Nilai --}}
        <details class="sb-group" {{ request()->routeIs('guru.ujian.*','guru.nilai.*','guru.jurnal-mengajar.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                Ujian & Nilai
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('guru.ujian.index') }}"           class="sb-item {{ request()->routeIs('guru.ujian.index') ? 'active' : '' }}">Kelola Ujian</a>
                <a href="{{ route('guru.nilai.index') }}"           class="sb-item {{ request()->routeIs('guru.nilai.*') ? 'active' : '' }}">Input Nilai</a>
                <a href="{{ route('guru.jurnal-mengajar.index') }}" class="sb-item {{ request()->routeIs('guru.jurnal-mengajar.*') ? 'active' : '' }}">Jurnal Mengajar</a>
            </div>
        </details>

        {{-- Absensi Kelas --}}
        <details class="sb-group" {{ request()->routeIs('guru.absensi.*','guru.sesi-qr.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                Absensi Kelas
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('guru.absensi.index') }}" class="sb-item {{ request()->routeIs('guru.absensi.index') ? 'active' : '' }}">Catat Absensi</a>
                <a href="{{ route('guru.absensi.rekap') }}" class="sb-item {{ request()->routeIs('guru.absensi.rekap') ? 'active' : '' }}">Rekap Kehadiran</a>
                <a href="{{ route('guru.sesi-qr.index') }}" class="sb-item {{ request()->routeIs('guru.sesi-qr.*') ? 'active' : '' }}">Buat Sesi QR</a>
            </div>
        </details>

        {{-- ── MONITORING KELAS ──────────────────────────────── --}}
        <p class="sb-section">Monitoring Kelas</p>

        <a href="{{ route('guru.izin-keluar-siswa.index') }}"
        class="sb-item {{ request()->routeIs('guru.izin-keluar-siswa.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                <polyline points="10 17 15 12 10 7"/>
                <line x1="15" y1="12" x2="3" y2="12"/>
            </svg>
            Izin Keluar Siswa
        </a>

        {{-- ── SISTEM ────────────────────────────────────────── --}}
        <p class="sb-section">Sistem</p>

        <a href="{{ route('guru.notifikasi.index') }}"
        class="sb-item {{ request()->routeIs('guru.notifikasi.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            Notifikasi
            @if($unread > 0) <span class="sb-badge-count">{{ $unread }}</span> @endif
        </a>

        <a href="{{ route('guru.pengumuman.index') }}"
        class="sb-item {{ request()->routeIs('guru.pengumuman.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
            Pengumuman
        </a>


    {{-- ════════════════════════════════════════════════════════
        GURU PIKET
    ════════════════════════════════════════════════════════ --}}
    @elseif($role === 'guru_piket')

        {{-- ── UTAMA ─────────────────────────────────────────── --}}
        <p class="sb-section">Utama</p>

        <a href="{{ route('piket.dashboard') }}"
        class="sb-item {{ request()->routeIs('piket.dashboard') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('piket.jadwal.index') }}"
        class="sb-item {{ request()->routeIs('piket.jadwal.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Jadwal Piket Saya
        </a>

        <a href="{{ route('piket.log.checkin') }}"
        class="sb-item {{ request()->routeIs('piket.log.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            Check-In Piket
        </a>

        {{-- ── TUGAS PIKET ───────────────────────────────────── --}}
        <p class="sb-section">Tugas Piket</p>

        {{-- Pelanggaran Siswa --}}
        <details class="sb-group" {{ request()->routeIs('piket.pelanggaran.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                Pelanggaran Siswa
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('piket.pelanggaran.create') }}" class="sb-item {{ request()->routeIs('piket.pelanggaran.create') ? 'active' : '' }}">Input Pelanggaran</a>
                <a href="{{ route('piket.pelanggaran.index') }}"  class="sb-item {{ request()->routeIs('piket.pelanggaran.index') ? 'active' : '' }}">Riwayat Pelanggaran</a>
            </div>
        </details>

        {{-- Izin Keluar Siswa --}}
        <details class="sb-group" {{ request()->routeIs('piket.izin-keluar-siswa.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Izin Keluar Siswa
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('piket.izin-keluar-siswa.index', ['status' => 'menunggu']) }}"
                class="sb-item {{ request()->routeIs('piket.izin-keluar-siswa.index') && request('status') === 'menunggu' ? 'active' : '' }}">
                    Menunggu Proses
                </a>
                <a href="{{ route('piket.izin-keluar-siswa.index', ['status' => 'disetujui']) }}"
                class="sb-item {{ request()->routeIs('piket.izin-keluar-siswa.index') && request('status') === 'disetujui' ? 'active' : '' }}">
                    Sedang Keluar
                </a>
                <a href="{{ route('piket.izin-keluar-siswa.index') }}"
                class="sb-item {{ request()->routeIs('piket.izin-keluar-siswa.index') && !request('status') ? 'active' : '' }}">
                    Semua Riwayat
                </a>
                <a href="{{ route('piket.izin-keluar-siswa.create') }}"
                class="sb-item {{ request()->routeIs('piket.izin-keluar-siswa.create') ? 'active' : '' }}">
                    + Buat Izin Baru
                </a>
            </div>
        </details>

        {{-- Laporan Harian --}}
        <details class="sb-group" {{ request()->routeIs('piket.laporan.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                Laporan Harian
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('piket.laporan.harian') }}"  class="sb-item {{ request()->routeIs('piket.laporan.harian') ? 'active' : '' }}">Buat Laporan</a>
                <a href="{{ route('piket.laporan.riwayat') }}" class="sb-item {{ request()->routeIs('piket.laporan.riwayat') ? 'active' : '' }}">Riwayat Laporan</a>
            </div>
        </details>

        {{-- ── ABSENSI GURU ──────────────────────────────────── --}}
        <p class="sb-section">Absensi Guru</p>

        <a href="{{ route('piket.absensi-guru.dashboard') }}"
        class="sb-item {{ request()->routeIs('piket.absensi-guru.dashboard') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
            </svg>
            Dashboard Absensi
        </a>

        <details class="sb-group" {{ request()->routeIs('piket.absensi-guru.massal*','piket.absensi-guru.riwayat') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                </svg>
                Input Absensi
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('piket.absensi-guru.massal.form') }}" class="sb-item {{ request()->routeIs('piket.absensi-guru.massal*') ? 'active' : '' }}">Absen Massal</a>
                <a href="{{ route('piket.absensi-guru.riwayat') }}"     class="sb-item {{ request()->routeIs('piket.absensi-guru.riwayat') ? 'active' : '' }}">Riwayat Saya</a>
            </div>
        </details>

        <a href="{{ route('piket.absensi-guru.scan-qr') }}"
        class="sb-item {{ request()->routeIs('piket.absensi-guru.scan-qr') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <rect x="3" y="3" width="5" height="5"/>
                <rect x="16" y="3" width="5" height="5"/>
                <rect x="3" y="16" width="5" height="5"/>
                <path d="M21 16h-3v3"/>
                <path d="M21 21h-3"/>
                <path d="M16 21v-3"/>
            </svg>
            Scan QR Guru
        </a>

        {{-- ── SISTEM ────────────────────────────────────────── --}}
        <p class="sb-section">Sistem</p>

        <a href="{{ route('piket.notifikasi.index') }}"
        class="sb-item {{ request()->routeIs('piket.notifikasi.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            Notifikasi
            @if($unread > 0) <span class="sb-badge-count">{{ $unread }}</span> @endif
        </a>

        <a href="{{ route('piket.pengumuman.index') }}"
        class="sb-item {{ request()->routeIs('piket.pengumuman.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
            Pengumuman
        </a>


    {{-- ════════════════════════════════════════════════════════
        SISWA
    ════════════════════════════════════════════════════════ --}}
    @elseif($role === 'siswa')

        {{-- ── UTAMA ─────────────────────────────────────────── --}}
        <p class="sb-section">Utama</p>

        <a href="{{ route('siswa.dashboard') }}"
        class="sb-item {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
            </svg>
            Beranda
        </a>

        <a href="{{ route('siswa.jadwal.index') }}"
        class="sb-item {{ request()->routeIs('siswa.jadwal.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Jadwal Pelajaran
        </a>

        {{-- ── PEMBELAJARAN ──────────────────────────────────── --}}
        <p class="sb-section">Pembelajaran</p>

        {{-- Materi & Tugas --}}
        <details class="sb-group" {{ request()->routeIs('siswa.materi.*','siswa.tugas.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/>
                    <path d="M2 12l10 5 10-5"/>
                </svg>
                Materi & Tugas
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('siswa.materi.index') }}" class="sb-item {{ request()->routeIs('siswa.materi.*') ? 'active' : '' }}">Materi Pelajaran</a>
                <a href="{{ route('siswa.tugas.index') }}"  class="sb-item {{ request()->routeIs('siswa.tugas.*') ? 'active' : '' }}">Tugas Saya</a>
            </div>
        </details>

        {{-- Ujian Online --}}
        <details class="sb-group" {{ request()->routeIs('siswa.ujian.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                Ujian Online
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('siswa.ujian.index') }}"   class="sb-item {{ request()->routeIs('siswa.ujian.index') ? 'active' : '' }}">Ujian Tersedia</a>
                <a href="{{ route('siswa.ujian.riwayat') }}" class="sb-item {{ request()->routeIs('siswa.ujian.riwayat') ? 'active' : '' }}">Riwayat Ujian</a>
            </div>
        </details>

        {{-- Absensi Saya --}}
        <details class="sb-group" {{ request()->routeIs('siswa.absensi.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                Absensi Saya
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('siswa.absensi.scan') }}"    class="sb-item {{ request()->routeIs('siswa.absensi.scan') ? 'active' : '' }}">Scan QR Hadir</a>
                <a href="{{ route('siswa.absensi.riwayat') }}" class="sb-item {{ request()->routeIs('siswa.absensi.riwayat') ? 'active' : '' }}">Riwayat Kehadiran</a>
            </div>
        </details>

        {{-- ── AKADEMIK ──────────────────────────────────────── --}}
        <p class="sb-section">Akademik</p>

        {{-- Nilai & Rapor --}}
        <details class="sb-group" {{ request()->routeIs('siswa.nilai.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                </svg>
                Nilai & Rapor
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('siswa.nilai.index') }}" class="sb-item {{ request()->routeIs('siswa.nilai.index') ? 'active' : '' }}">Nilai per Mapel</a>
                <a href="{{ route('siswa.nilai.rapor') }}" class="sb-item {{ request()->routeIs('siswa.nilai.rapor') ? 'active' : '' }}">Rekap / Rapor</a>
            </div>
        </details>

        <a href="{{ route('siswa.pelanggaran.index') }}"
        class="sb-item {{ request()->routeIs('siswa.pelanggaran.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            Kedisiplinan Saya
        </a>

        {{-- ── SISTEM ────────────────────────────────────────── --}}
        <p class="sb-section">Sistem</p>

        <a href="{{ route('siswa.notifikasi.index') }}"
        class="sb-item {{ request()->routeIs('siswa.notifikasi.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            Notifikasi
            @if($unread > 0) <span class="sb-badge-count">{{ $unread }}</span> @endif
        </a>

        <a href="{{ route('siswa.pengumuman.index') }}"
        class="sb-item {{ request()->routeIs('siswa.pengumuman.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
            Pengumuman
        </a>


    {{-- ════════════════════════════════════════════════════════
        ORANG TUA
    ════════════════════════════════════════════════════════ --}}
    @elseif($role === 'orang_tua')

        {{-- ── UTAMA ─────────────────────────────────────────── --}}
        <p class="sb-section">Utama</p>

        <a href="{{ route('ortu.dashboard') }}"
        class="sb-item {{ request()->routeIs('ortu.dashboard') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
            </svg>
            Beranda
        </a>

        <a href="{{ route('ortu.profil-anak.index') }}"
        class="sb-item {{ request()->routeIs('ortu.profil-anak.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            Profil Anak
        </a>

        {{-- ── PANTAU ANAK ───────────────────────────────────── --}}
        <p class="sb-section">Pantau Anak</p>

        {{-- Akademik Anak --}}
        <details class="sb-group" {{ request()->routeIs('ortu.akademik.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                </svg>
                Akademik Anak
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('ortu.akademik.nilai') }}" class="sb-item {{ request()->routeIs('ortu.akademik.nilai') ? 'active' : '' }}">Nilai per Mapel</a>
                <a href="{{ route('ortu.akademik.rapor') }}" class="sb-item {{ request()->routeIs('ortu.akademik.rapor') ? 'active' : '' }}">Rekap / Rapor</a>
                <a href="{{ route('ortu.akademik.tugas') }}" class="sb-item {{ request()->routeIs('ortu.akademik.tugas') ? 'active' : '' }}">Progress Tugas</a>
            </div>
        </details>

        {{-- Kehadiran Anak --}}
        <details class="sb-group" {{ request()->routeIs('ortu.absensi.*') ? 'open' : '' }}>
            <summary class="sb-group-header">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                Kehadiran Anak
                <svg class="sb-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </summary>
            <div class="sb-sub">
                <a href="{{ route('ortu.absensi.status-hari-ini') }}" class="sb-item {{ request()->routeIs('ortu.absensi.status-hari-ini') ? 'active' : '' }}">Status Hari Ini</a>
                <a href="{{ route('ortu.absensi.riwayat') }}"         class="sb-item {{ request()->routeIs('ortu.absensi.riwayat') ? 'active' : '' }}">Riwayat Kehadiran</a>
                <a href="{{ route('ortu.absensi.rekap') }}"           class="sb-item {{ request()->routeIs('ortu.absensi.rekap') ? 'active' : '' }}">Rekap Bulanan</a>
            </div>
        </details>

        <a href="{{ route('ortu.kedisiplinan.riwayat') }}"
        class="sb-item {{ request()->routeIs('ortu.kedisiplinan.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            Kedisiplinan Anak
        </a>

        {{-- ── KOMUNIKASI ────────────────────────────────────── --}}
        <p class="sb-section">Komunikasi</p>

        <a href="{{ route('ortu.notifikasi.index') }}"
        class="sb-item {{ request()->routeIs('ortu.notifikasi.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            Notifikasi
            @if($unread > 0) <span class="sb-badge-count">{{ $unread }}</span> @endif
        </a>

        <a href="{{ route('ortu.pengumuman.index') }}"
        class="sb-item {{ request()->routeIs('ortu.pengumuman.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
            Pengumuman
        </a>

    @endif

    {{-- Bottom: Profile & Logout semua role --}}
    <div class="sb-bottom">
        <a href="{{ route('profile.edit') }}" class="sb-item">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg> Profil Saya
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb-item" style="color:rgba(248,113,113,.75);">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg> Keluar
            </button>
        </form>
    </div>

</aside>

{{-- ══ TOPBAR ══ --}}
<div class="topbar" id="topbar">

    <button class="mobile-toggle" onclick="openSidebar()">
        <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>

    <p class="topbar-title" id="topbarTitle">Dashboard</p>

    <div class="topbar-actions">

        {{-- ── Notifikasi Dropdown ── --}}
        <div style="position:relative;">
            <button class="tb-btn" id="notifBtn" onclick="togglePanel('notifDropdown','userDropdown')">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                @if($unread > 0) <span class="tb-notif-dot"></span> @endif
            </button>

            <div class="notif-dropdown" id="notifDropdown">
                <div class="notif-header">
                    <span class="notif-header-title">Notifikasi</span>
                    @if($unread > 0)
                        @php
                            $markAllReadRoute = match($role) {
                                'admin'      => 'admin.notifikasi.mark-all-read',
                                'guru'       => 'guru.notifikasi.mark-all-read',
                                'guru_piket' => 'piket.notifikasi.mark-all-read',
                                'siswa'      => 'siswa.notifikasi.mark-all-read',
                                'orang_tua'  => 'ortu.notifikasi.mark-all-read',
                                default      => 'piket.notifikasi.mark-all-read',
                            };
                        @endphp
                        <form method="POST" action="{{ route($markAllReadRoute) }}" style="display:inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="notif-mark-all">Tandai semua dibaca</button>
                        </form>
                    @endif
                </div>

                <div class="notif-list">
                    @forelse($notifs as $notif)
                        <a href="{{ $notif->url_tujuan ?? '#' }}" class="notif-item {{ !$notif->sudah_dibaca ? 'unread' : '' }}">
                            <span class="notif-icon">{{ $iconJenis[$notif->jenis] ?? '🔔' }}</span>
                            <div style="flex:1; min-width:0;">
                                <p class="notif-judul">{{ $notif->judul }}</p>
                                <p class="notif-pesan">{{ $notif->pesan }}</p>
                                <p class="notif-waktu">{{ $notif->created_at->diffForHumans() }}</p>
                            </div>
                            @if(!$notif->sudah_dibaca)
                                <span class="notif-unread-dot"></span>
                            @endif
                        </a>
                    @empty
                        <p class="notif-empty">Tidak ada notifikasi</p>
                    @endforelse
                </div>

                <div class="notif-footer">
                    @php
                        $notifRoute = match($role) {
                            'admin'      => 'admin.notifikasi.index',
                            'guru'       => 'guru.notifikasi.index',
                            'guru_piket' => 'piket.notifikasi.index',
                            'siswa'      => 'siswa.notifikasi.index',
                            'orang_tua'  => 'ortu.notifikasi.index',
                            default      => '#',
                        };
                    @endphp
                    <a href="{{ route($notifRoute) }}">Lihat semua notifikasi →</a>
                </div>
            </div>
        </div>

        {{-- ── User Dropdown ── --}}
        <div style="position:relative;">
            <button class="tb-user-btn" id="userBtn" onclick="togglePanel('userDropdown','notifDropdown')">
                @if($user->avatar)
                    <img src="{{ $user->avatar_url }}" class="tb-avatar-img" alt="{{ $namaLengkap }}">
                @else
                    <div class="tb-avatar-text" style="background:{{ $warnaBadge }}">{{ $inisial }}</div>
                @endif
                <div>
                    <p class="tb-uname">{{ $namaLengkap }}</p>
                    <p class="tb-urole">{{ $labelRole }}</p>
                </div>
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
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
    function openSidebar()  {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sbOverlay').classList.add('open');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sbOverlay').classList.remove('open');
    }

    function togglePanel(show, hide) {
        document.getElementById(hide).classList.remove('open');
        document.getElementById(show).classList.toggle('open');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#notifBtn') && !e.target.closest('#notifDropdown')) {
            document.getElementById('notifDropdown').classList.remove('open');
        }
        if (!e.target.closest('#userBtn') && !e.target.closest('#userDropdown')) {
            document.getElementById('userDropdown').classList.remove('open');
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const active = document.querySelector('.sidebar .sb-item.active, .sidebar .sb-sub .sb-item.active');
        if (active) document.getElementById('topbarTitle').textContent = active.textContent.trim().replace(/\s+/g, ' ');
    });
</script>