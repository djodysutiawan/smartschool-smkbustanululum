<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');

    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
        --green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fff0f0;--red-border:#fecaca;
        --orange:#c2410c;--orange-bg:#fff7ed;--orange-border:#fed7aa;
    }

    /* ── Layout ── */
    .page { padding: 28px 28px 56px; max-width: 900px; margin: 0 auto; }
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2; }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; font-family: 'DM Sans', sans-serif; }
    .header-actions { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }

    /* ── Buttons ── */
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 15px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s, background .15s, opacity .15s; white-space: nowrap; line-height: 1; }
    .btn:hover { filter: brightness(.93); }
    .btn-sm { padding: 5px 10px; font-size: 12px; border-radius: 6px; }
    .btn-secondary { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-secondary:hover { background: var(--surface3); filter: none; }
    .btn-primary { background: var(--brand-600); color: #fff; }
    .btn-primary:hover { filter: brightness(.9); }
    .btn-danger { background: var(--red-bg); color: var(--red); border: 1px solid var(--red-border); }
    .btn-danger:hover { background: #fee2e2; filter: none; }
    .btn-warning { background: var(--orange-bg); color: var(--orange); border: 1px solid var(--orange-border); }
    .btn-warning:hover { background: #ffedd5; filter: none; }

    /* ── Alert ── */
    .alert { display: flex; align-items: center; gap: 10px; padding: 11px 16px; border-radius: var(--radius-sm); margin-bottom: 16px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; }
    .alert svg { flex-shrink: 0; }
    .alert-success { background: var(--green-bg); border: 1px solid var(--green-border); color: var(--green); }
    .alert-dismiss { margin-left: auto; background: none; border: none; cursor: pointer; color: inherit; opacity: .6; padding: 2px; line-height: 1; }
    .alert-dismiss:hover { opacity: 1; }

    /* ── Stats strip ── */
    .stats-strip { display: flex; gap: 8px; margin-bottom: 16px; flex-wrap: wrap; }
    .stat-pill { display: inline-flex; align-items: center; gap: 6px; padding: 6px 13px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; border: 1px solid var(--border); background: var(--surface); color: var(--text2); }
    .stat-pill.unread { background: var(--red-bg); border-color: var(--red-border); color: var(--red); }
    .stat-pill.read-count { background: var(--green-bg); border-color: var(--green-border); color: var(--green); }

    /* ── Filter card ── */
    .filter-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px 18px; margin-bottom: 16px; }
    .filter-row { display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-end; }
    .filter-field { display: flex; flex-direction: column; gap: 4px; }
    .filter-field label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text2); }
    .filter-field select {
        height: 34px; padding: 0 10px; border: 1px solid var(--border);
        border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif;
        font-size: 13px; color: var(--text); background: var(--surface2);
        outline: none; min-width: 150px; cursor: pointer;
    }
    .filter-field select:focus { border-color: var(--brand-500); background: #fff; }
    .btn-filter { height: 34px; padding: 0 16px; background: var(--brand-600); color: #fff; border: none; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; transition: filter .15s; }
    .btn-filter:hover { filter: brightness(.9); }
    .btn-reset { height: 34px; padding: 0 12px; background: var(--surface2); color: var(--text2); border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: background .15s; }
    .btn-reset:hover { background: var(--surface3); }

    /* Active filter indicator */
    .filter-active-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 9px; border-radius: 99px; background: var(--brand-50);
        border: 1px solid var(--brand-100); color: var(--brand-600);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
        margin-left: 4px;
    }

    /* ── Notifikasi panel ── */
    .notif-panel { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; margin-bottom: 16px; }
    .notif-panel-header { display: flex; align-items: center; justify-content: space-between; padding: 12px 18px; border-bottom: 1px solid var(--border); background: var(--surface2); gap: 8px; flex-wrap: wrap; }
    .notif-panel-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 800; color: var(--text); }
    .notif-panel-info { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; }

    /* ── Notif item ── */
    .notif-item {
        display: flex; align-items: flex-start; gap: 12px;
        padding: 14px 18px; border-bottom: 1px solid #f1f5f9;
        transition: background .12s; position: relative;
    }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: var(--surface2); }
    .notif-item.unread { background: #eff6ff; }
    .notif-item.unread:hover { background: #dbeafe; }

    .notif-icon-wrap {
        width: 40px; height: 40px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; flex-shrink: 0; background: var(--surface3);
        border: 1px solid var(--border);
    }
    .notif-item.unread .notif-icon-wrap { background: #dbeafe; border-color: #bfdbfe; }

    .notif-content { flex: 1; min-width: 0; padding-right: 20px; /* ruang untuk unread-dot */ }
    .notif-judul { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--text); line-height: 1.35; margin-bottom: 4px; }
    .notif-item.unread .notif-judul { font-weight: 800; }
    .notif-pesan {
        font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text2);
        line-height: 1.55; display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 6px;
    }
    .notif-meta { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .notif-waktu { font-size: 11.5px; color: var(--text3); font-family: 'DM Sans', sans-serif; }
    .notif-jenis-badge {
        display: inline-flex; padding: 2px 8px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
    }

    /* Unread dot — absolute positioned terhadap .notif-item (position:relative) */
    .unread-dot {
        position: absolute; top: 18px; right: 18px;
        width: 8px; height: 8px; border-radius: 50%;
        background: var(--brand-500); flex-shrink: 0;
        animation: pulse-dot 2s ease-in-out infinite;
    }
    @keyframes pulse-dot {
        0%, 100% { box-shadow: 0 0 0 0 rgba(53,130,240,.4); }
        50%       { box-shadow: 0 0 0 5px rgba(53,130,240,0); }
    }

    .notif-actions { display: flex; gap: 5px; align-items: center; flex-shrink: 0; }

    /* ── Empty state ── */
    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-icon { width: 54px; height: 54px; background: var(--surface2); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; border: 1px solid var(--border); }
    .empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 15px; color: var(--text); margin-bottom: 5px; }
    .empty-sub { font-size: 13px; color: var(--text3); font-family: 'DM Sans', sans-serif; }

    /* ── Pagination ── */
    .pag-wrap { display: flex; align-items: center; justify-content: space-between; padding: 12px 18px; border-top: 1px solid var(--border); background: var(--surface2); flex-wrap: wrap; gap: 8px; }
    .pag-info { font-size: 12.5px; color: var(--text3); font-family: 'DM Sans', sans-serif; }
    .pag-btns { display: flex; gap: 4px; flex-wrap: wrap; }
    .pag-btn {
        height: 30px; min-width: 30px; padding: 0 7px; border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid var(--border); background: var(--surface);
        color: var(--text2); font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px; font-weight: 700; cursor: pointer;
        transition: all .15s; text-decoration: none;
    }
    .pag-btn:hover { background: var(--surface3); }
    .pag-btn.active { background: var(--brand-600); border-color: var(--brand-600); color: #fff; }
    .pag-btn.disabled { opacity: .35; pointer-events: none; cursor: default; }
    .pag-ellipsis { color: var(--text3); padding: 0 4px; line-height: 30px; font-size: 13px; }

    /* ── Responsive ── */
    @media (max-width: 640px) {
        .page { padding: 14px 14px 40px; }
        .notif-actions { flex-direction: column; }
        .filter-field select { min-width: 130px; }
    }
</style>

<div class="page">

    {{-- ── Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Notifikasi</h1>
            <p class="page-sub">Semua notifikasi untuk akun Anda</p>
        </div>
        <div class="header-actions">
            @if($readCount > 0)
                <form method="POST" action="{{ route('piket.notifikasi.destroy-all-read') }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-warning"
                        onclick="return confirm('Hapus {{ $readCount }} notifikasi yang sudah dibaca?')">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        </svg>
                        Hapus Sudah Dibaca
                    </button>
                </form>
            @endif
            @if($unreadCount > 0)
                <form method="POST" action="{{ route('piket.notifikasi.mark-all-read') }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-primary">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Tandai Semua Dibaca
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- ── Alert ── --}}
    @if(session('success'))
    <div class="alert alert-success" id="alert-msg">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
        {{ session('success') }}
        <button class="alert-dismiss" onclick="this.closest('.alert').remove()" aria-label="Tutup">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>
    @endif

    {{-- ── Stats strip ── --}}
    <div class="stats-strip">
        <span class="stat-pill">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            {{ $notifikasi->total() }} total
        </span>
        @if($unreadCount > 0)
        <span class="stat-pill unread">
            <svg width="9" height="9" fill="currentColor" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5"/></svg>
            {{ $unreadCount }} belum dibaca
        </span>
        @endif
        @if($readCount > 0)
        <span class="stat-pill read-count">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            {{ $readCount }} sudah dibaca
        </span>
        @endif

        {{-- Filter aktif indicator --}}
        @if(request()->hasAny(['jenis','sudah_dibaca']))
        <span class="filter-active-badge">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
            </svg>
            Filter aktif
        </span>
        @endif
    </div>

    {{-- ── Filter ── --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('piket.notifikasi.index') }}">
            <div class="filter-row">
                <div class="filter-field">
                    <label for="filter-jenis">Jenis</label>
                    <select name="jenis" id="filter-jenis">
                        <option value="">Semua Jenis</option>
                        @foreach($jenisList as $j)
                            <option value="{{ $j }}" {{ request('jenis') === $j ? 'selected' : '' }}>
                                {{ ucfirst($j) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-field">
                    <label for="filter-status">Status</label>
                    <select name="sudah_dibaca" id="filter-status">
                        <option value="">Semua Status</option>
                        <option value="tidak" {{ request('sudah_dibaca') === 'tidak' ? 'selected' : '' }}>Belum Dibaca</option>
                        <option value="ya"    {{ request('sudah_dibaca') === 'ya'    ? 'selected' : '' }}>Sudah Dibaca</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter">Terapkan</button>
                @if(request()->hasAny(['jenis','sudah_dibaca']))
                    <a href="{{ route('piket.notifikasi.index') }}" class="btn-reset">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- ── Definisi helper variabel ── --}}
    @php
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
        $warnaBadge = [
            'info'        => 'background:#eff6ff;color:#1d4ed8',
            'peringatan'  => 'background:#fefce8;color:#a16207',
            'pelanggaran' => 'background:#fff0f0;color:#dc2626',
            'absensi'     => 'background:#f0fdf4;color:#15803d',
            'nilai'       => 'background:#fdf4ff;color:#7c3aed',
            'pengumuman'  => 'background:#fff7ed;color:#c2410c',
            'tugas'       => 'background:#f0fdf4;color:#15803d',
            'ujian'       => 'background:#eff6ff;color:#1d4ed8',
        ];
    @endphp

    {{-- ── Daftar notifikasi ── --}}
    <div class="notif-panel">
        <div class="notif-panel-header">
            <p class="notif-panel-title">Daftar Notifikasi</p>
            @if($notifikasi->count())
            <span class="notif-panel-info">
                {{ $notifikasi->firstItem() }}–{{ $notifikasi->lastItem() }} dari {{ $notifikasi->total() }}
            </span>
            @endif
        </div>

        @forelse($notifikasi as $notif)
        <div class="notif-item {{ !$notif->sudah_dibaca ? 'unread' : '' }}">

            {{-- Ikon jenis --}}
            <div class="notif-icon-wrap" aria-hidden="true">
                {{ $iconJenis[$notif->jenis] ?? '🔔' }}
            </div>

            {{-- Konten --}}
            <div class="notif-content">
                <p class="notif-judul">{{ $notif->judul }}</p>
                <p class="notif-pesan">{{ $notif->pesan }}</p>
                <div class="notif-meta">
                    <span class="notif-waktu" title="{{ $notif->created_at->locale('id')->isoFormat('D MMMM Y, H:mm') }}">
                        {{ $notif->created_at->locale('id')->diffForHumans() }}
                    </span>
                    <span class="notif-jenis-badge"
                          style="{{ $warnaBadge[$notif->jenis] ?? 'background:var(--surface3);color:var(--text2)' }}">
                        {{ ucfirst($notif->jenis) }}
                    </span>
                </div>
            </div>

            {{-- Aksi --}}
            <div class="notif-actions">
                <a href="{{ route('piket.notifikasi.show', $notif->id) }}" class="btn btn-sm btn-secondary">
                    Buka
                </a>

                @if(!$notif->sudah_dibaca)
                    <form method="POST" action="{{ route('piket.notifikasi.mark-read', $notif->id) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-secondary" title="Tandai sudah dibaca">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </button>
                    </form>
                @endif

                <form method="POST" action="{{ route('piket.notifikasi.destroy', $notif->id) }}"
                    onsubmit="return confirm('Hapus notifikasi ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6"/><path d="M14 11v6"/>
                        </svg>
                    </button>
                </form>
            </div>

            {{-- Dot indikator belum dibaca --}}
            @if(!$notif->sudah_dibaca)
                <span class="unread-dot" aria-label="Belum dibaca"></span>
            @endif

        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
            </div>
            <p class="empty-title">Tidak ada notifikasi</p>
            <p class="empty-sub">
                @if(request()->hasAny(['jenis','sudah_dibaca']))
                    Tidak ada notifikasi yang cocok dengan filter ini.
                    <a href="{{ route('piket.notifikasi.index') }}" style="color:var(--brand-600);font-weight:700;text-decoration:none">Hapus filter</a>
                @else
                    Belum ada notifikasi masuk untuk akun Anda.
                @endif
            </p>
        </div>
        @endforelse

        {{-- ── Pagination ── --}}
        @if($notifikasi->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">
                Halaman {{ $notifikasi->currentPage() }} dari {{ $notifikasi->lastPage() }}
            </p>
            <div class="pag-btns">
                {{-- Prev --}}
                @if($notifikasi->onFirstPage())
                    <span class="pag-btn disabled" aria-disabled="true">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $notifikasi->previousPageUrl() }}" class="pag-btn" aria-label="Halaman sebelumnya">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                {{-- Nomor halaman dengan ellipsis yang benar --}}
                @php
                    $current  = $notifikasi->currentPage();
                    $last     = $notifikasi->lastPage();
                    $window   = 1; // halaman di kiri & kanan current
                    $prevEllipsis = false;
                    $nextEllipsis = false;
                @endphp

                @foreach($notifikasi->getUrlRange(1, $last) as $page => $url)
                    @php
                        $isFirst   = $page === 1;
                        $isLast    = $page === $last;
                        $inWindow  = abs($page - $current) <= $window;
                        $show      = $isFirst || $isLast || $inWindow;
                    @endphp

                    @if($show)
                        @php $prevEllipsis = false; $nextEllipsis = false; @endphp
                        @if($page === $current)
                            <span class="pag-btn active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                        @endif
                    @else
                        @if($page < $current && !$prevEllipsis)
                            <span class="pag-ellipsis">…</span>
                            @php $prevEllipsis = true; @endphp
                        @elseif($page > $current && !$nextEllipsis)
                            <span class="pag-ellipsis">…</span>
                            @php $nextEllipsis = true; @endphp
                        @endif
                    @endif
                @endforeach

                {{-- Next --}}
                @if($notifikasi->hasMorePages())
                    <a href="{{ $notifikasi->nextPageUrl() }}" class="pag-btn" aria-label="Halaman berikutnya">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                @else
                    <span class="pag-btn disabled" aria-disabled="true">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </span>
                @endif
            </div>
        </div>
        @endif

    </div>{{-- /.notif-panel --}}

</div>{{-- /.page --}}

{{-- Auto-dismiss alert setelah 4 detik --}}
<script>
    (function () {
        const el = document.getElementById('alert-msg');
        if (el) setTimeout(() => el.remove(), 4000);
    })();
</script>
</x-app-layout>