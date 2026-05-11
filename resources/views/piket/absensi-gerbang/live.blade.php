<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
        --yellow-bg:#fefce8;--yellow-border:#fde68a;--yellow-text:#92400e;
        --green-bg:#f0fdf4;--green-border:#bbf7d0;--green-text:#15803d;
        --red-bg:#fef2f2;--red-border:#fecaca;--red-text:#dc2626;
    }

    .page { padding: 28px 28px 48px; }
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2; }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; font-family: 'DM Sans', sans-serif; }

    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s, background .15s; white-space: nowrap; }
    .btn:hover { filter: brightness(.93); }
    .btn-primary { background: var(--brand-600); color: #fff; }
    .btn-secondary { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-secondary:hover { background: var(--surface3); filter: none; }
    .btn-sm { padding: 5px 11px; font-size: 12px; border-radius: 6px; }
    .btn-danger { background: var(--red-bg); color: var(--red-text); border: 1px solid var(--red-border); }
    .btn-danger:hover { background: #fee2e2; filter: none; }
    .btn-success { background: var(--green-bg); color: var(--green-text); border: 1px solid var(--green-border); }
    .btn-success:hover { background: #dcfce7; filter: none; }
    .btn-yellow { background: var(--yellow-bg); color: var(--yellow-text); border: 1px solid var(--yellow-border); }
    .btn-yellow:hover { background: #fef9c3; filter: none; }

    /* ── Banner tidak ada sesi ── */
    .alert-banner { display: flex; align-items: flex-start; gap: 12px; padding: 14px 18px; border-radius: var(--radius); margin-bottom: 20px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; line-height: 1.5; }
    .alert-banner.warning { background: var(--yellow-bg); border: 1px solid var(--yellow-border); color: var(--yellow-text); }
    .alert-banner.success { background: var(--green-bg); border: 1px solid var(--green-border); color: var(--green-text); }
    .alert-banner svg { flex-shrink: 0; margin-top: 1px; }

    /* ── Sesi info strip ── */
    .sesi-strip { display: flex; align-items: center; gap: 12px; padding: 12px 18px; background: var(--green-bg); border: 1px solid var(--green-border); border-radius: var(--radius); margin-bottom: 20px; flex-wrap: wrap; }
    .sesi-strip-dot { width: 9px; height: 9px; border-radius: 50%; background: var(--green-text); flex-shrink: 0; animation: pulse-dot 1.8s ease-in-out infinite; }
    @keyframes pulse-dot { 0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(.85)} }
    .sesi-strip-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--green-text); }
    .sesi-strip-meta { font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: #166534; }
    .sesi-strip-actions { margin-left: auto; display: flex; gap: 8px; flex-wrap: wrap; }

    /* ── Stats ── */
    .stats-strip { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px 18px; display: flex; align-items: center; gap: 12px; transition: box-shadow .2s; }
    .stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.06); }
    .stat-icon { width: 38px; height: 38px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .stat-icon.blue { background: #eff6ff; }
    .stat-icon.green { background: var(--green-bg); }
    .stat-icon.yellow { background: var(--yellow-bg); }
    .stat-icon.red { background: var(--red-bg); }
    .stat-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; color: var(--text3); letter-spacing: .04em; text-transform: uppercase; }
    .stat-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: var(--text); line-height: 1.1; margin-top: 1px; }
    .stat-sub { font-size: 11px; color: var(--text3); margin-top: 1px; font-family: 'DM Sans', sans-serif; }

    /* ── Live feed ── */
    .live-grid { display: grid; grid-template-columns: 1fr 320px; gap: 16px; }

    /* Feed table */
    .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .table-topbar { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--border); gap: 8px; flex-wrap: wrap; }
    .table-info { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .table-info span { font-weight: 400; color: var(--text3); margin-left: 6px; }
    .live-indicator { display: flex; align-items: center; gap: 6px; font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--green-text); font-weight: 600; }
    .live-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--green-text); animation: pulse-dot 1.4s ease-in-out infinite; }
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    thead tr { background: var(--surface2); border-bottom: 1px solid var(--border); }
    thead th { padding: 11px 14px; text-align: left; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; color: var(--text3); letter-spacing: .05em; text-transform: uppercase; white-space: nowrap; }
    thead th.center { text-align: center; }
    tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .1s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fafbff; }
    td { padding: 10px 14px; color: var(--text); vertical-align: middle; }
    td.center { text-align: center; }
    td.muted { color: var(--text3); font-size: 12.5px; }
    .no-col { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text3); }

    /* Badge */
    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; white-space: nowrap; }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .badge-normal   { background: var(--green-bg); color: var(--green-text); } .badge-normal .badge-dot   { background: var(--green-text); }
    .badge-manual   { background: #eff6ff; color: #1d4ed8; }               .badge-manual .badge-dot   { background: #1d4ed8; }
    .badge-duplikat { background: var(--yellow-bg); color: var(--yellow-text); } .badge-duplikat .badge-dot { background: #a16207; }
    .badge-koreksi  { background: #fdf4ff; color: #7c3aed; }               .badge-koreksi .badge-dot  { background: #7c3aed; }
    .badge-tidak_dikenal { background: var(--surface3); color: var(--text2); } .badge-tidak_dikenal .badge-dot { background: var(--text3); }

    .badge-tipe-masuk  { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); padding: 2px 9px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; }
    .badge-tipe-pulang { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; padding: 2px 9px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; }

    /* Two-line cell */
    .two-line .primary   { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 13.5px; color: var(--text); }
    .two-line .secondary { font-size: 12px; color: var(--text3); margin-top: 1px; font-family: 'DM Sans', sans-serif; }

    /* ── Sidebar sesi ── */
    .sidebar-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .sidebar-head { padding: 14px 18px; border-bottom: 1px solid var(--border); background: var(--surface2); }
    .sidebar-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .sidebar-body { padding: 14px 18px; }

    .sesi-item { padding: 10px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); margin-bottom: 8px; background: var(--surface2); }
    .sesi-item:last-child { margin-bottom: 0; }
    .sesi-item.aktif { border-color: var(--green-border); background: var(--green-bg); }
    .sesi-item-head { display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 4px; }
    .sesi-item-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text); }
    .sesi-item-meta { font-family: 'DM Sans', sans-serif; font-size: 11.5px; color: var(--text3); margin-top: 2px; }
    .sesi-badge-aktif { background: var(--green-bg); color: var(--green-text); border: 1px solid var(--green-border); padding: 2px 8px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 10.5px; font-weight: 700; }
    .sesi-badge-tutup { background: var(--surface3); color: var(--text3); padding: 2px 8px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 10.5px; font-weight: 700; }

    /* Buka sesi form */
    .buka-sesi-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px; margin-bottom: 16px; }
    .buka-sesi-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 12px; }
    .form-group { margin-bottom: 12px; }
    .form-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--text2); margin-bottom: 5px; display: block; letter-spacing: .02em; }
    .form-control { width: 100%; height: 38px; padding: 0 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text); background: var(--surface2); outline: none; transition: border-color .15s; box-sizing: border-box; }
    .form-control:focus { border-color: var(--brand-500); background: #fff; }

    /* Timestamp */
    .timestamp-bar { display: flex; align-items: center; gap: 8px; padding: 8px 14px; background: var(--surface2); border-top: 1px solid var(--border); }
    .timestamp-text { font-family: 'DM Sans', sans-serif; font-size: 11.5px; color: var(--text3); }
    #live-clock { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: var(--text2); }

    /* Empty state */
    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-icon { width: 56px; height: 56px; background: var(--surface2); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; border: 1px solid var(--border); }
    .empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 15px; color: var(--text); margin-bottom: 5px; }
    .empty-sub { font-size: 13px; color: var(--text3); font-family: 'DM Sans', sans-serif; }

    /* Row baru animation */
    @keyframes rowFlash { from { background: #dbeafe; } to { background: transparent; } }
    .row-new { animation: rowFlash 1.8s ease-out forwards; }

    @media (max-width: 900px) {
        .live-grid { grid-template-columns: 1fr; }
        .stats-strip { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 640px) {
        .page { padding: 16px; }
        .stats-strip { grid-template-columns: 1fr 1fr; }
    }
</style>

<div class="page">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Live Monitor Gerbang</h1>
            <p class="page-sub">Pantau scan masuk & pulang secara real-time</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
            <a href="{{ route('piket.absensi-gerbang.scan-manual') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
                Scan Manual
            </a>
            <a href="{{ route('piket.absensi-gerbang.rekap') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                    <rect x="9" y="3" width="6" height="4" rx="1"/>
                </svg>
                Rekap
            </a>
        </div>
    </div>

    {{-- ── Sesi aktif strip / banner tidak ada sesi ── --}}
    @if($sesiAktif)
        <div class="sesi-strip">
            <div class="sesi-strip-dot"></div>
            <div>
                <p class="sesi-strip-label">
                    Sesi Aktif: {{ $sesiAktif->label_tipe ?? ucfirst($sesiAktif->tipe) }}
                </p>
                <p class="sesi-strip-meta">
                    Dibuka {{ $sesiAktif->dibuka_pada->format('H:i') }} WIB
                    &mdash; oleh {{ $sesiAktif->dibukaOleh->name ?? '-' }}
                </p>
            </div>
            <div class="sesi-strip-actions">
                {{-- Tutup sesi --}}
                <form action="{{ route('piket.sesi-gerbang.tutup', $sesiAktif->id) }}" method="POST"
                      onsubmit="return confirm('Tutup sesi ini? Scanner tidak bisa merekam scan setelah sesi ditutup.')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-danger">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                        </svg>
                        Tutup Sesi
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="alert-banner warning" role="alert">
            <svg width="16" height="16" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>
                Tidak ada sesi gerbang yang aktif. Scanner tidak akan bisa merekam scan.
                Buka sesi baru terlebih dahulu untuk memulai pencatatan kehadiran.
            </span>
        </div>
    @endif

    {{-- ── Statistik Harian ── --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Total Siswa</p>
                <p class="stat-val" id="stat-total-siswa">{{ $statistik['total_siswa'] }}</p>
                <p class="stat-sub">siswa aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24">
                    <polyline points="9 11 12 14 22 4"/>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Sudah Masuk</p>
                <p class="stat-val" id="stat-masuk">{{ $statistik['total_masuk'] }}</p>
                <p class="stat-sub" id="stat-persen">{{ $statistik['persentase_hadir'] }}% hadir</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Belum Hadir</p>
                <p class="stat-val" id="stat-belum">{{ $statistik['belum_hadir'] }}</p>
                <p class="stat-sub">perlu dikonfirmasi</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Tidak Dikenal</p>
                <p class="stat-val" id="stat-tidak-dikenal">{{ $statistik['tidak_dikenal'] }}</p>
                <p class="stat-sub">perlu identifikasi</p>
            </div>
        </div>
    </div>

    {{-- ── Main grid: feed + sidebar ── --}}
    <div class="live-grid">

        {{-- Feed scan terbaru --}}
        <div class="table-card">
            <div class="table-topbar">
                <p class="table-info">
                    Scan Terbaru
                    <span id="feed-count">
                        @if($sesiAktif)
                            — {{ $scanTerakhir->count() }} scan
                        @else
                            — belum ada sesi
                        @endif
                    </span>
                </p>
                @if($sesiAktif)
                    <div class="live-indicator">
                        <span class="live-dot"></span>
                        <span id="last-update">memuat…</span>
                    </div>
                @endif
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width:44px">#</th>
                            <th>Nama</th>
                            <th>NIS / NIP</th>
                            <th>Kelas</th>
                            <th class="center">Tipe</th>
                            <th class="center">Status</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody id="scan-tbody">
                        @forelse($scanTerakhir as $i => $scan)
                        <tr data-id="{{ $scan->id }}">
                            <td><span class="no-col">{{ $i + 1 }}</span></td>
                            <td>
                                <div class="two-line">
                                    <p class="primary">
                                        @if($scan->siswa_id)
                                            {{ $scan->siswa->nama_lengkap ?? '—' }}
                                        @elseif($scan->guru_id)
                                            {{ $scan->guru->nama_lengkap ?? '—' }}
                                        @else
                                            <span style="color:var(--text3);font-style:italic">Tidak dikenal</span>
                                        @endif
                                    </p>
                                    <p class="secondary">{{ $scan->kode_scan }}</p>
                                </div>
                            </td>
                            <td class="muted">
                                @if($scan->siswa_id)
                                    {{ $scan->siswa->nis ?? '—' }}
                                @elseif($scan->guru_id)
                                    {{ $scan->guru->nip ?? '—' }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="muted">
                                @if($scan->siswa_id)
                                    {{ $scan->siswa->kelas->nama_kelas ?? '—' }}
                                @elseif($scan->guru_id)
                                    Guru
                                @else
                                    —
                                @endif
                            </td>
                            <td class="center">
                                <span class="badge-tipe-{{ $scan->tipe }}">
                                    {{ ucfirst($scan->tipe) }}
                                </span>
                            </td>
                            <td class="center">
                                <span class="badge badge-{{ $scan->status }}">
                                    <span class="badge-dot"></span>
                                    {{ ucfirst($scan->status) }}
                                </span>
                            </td>
                            <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px;white-space:nowrap">
                                {{ $scan->waktu_scan->format('H:i:s') }}
                            </td>
                        </tr>
                        @empty
                        <tr id="empty-row">
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                                            <rect x="3" y="3" width="7" height="7" rx="1"/>
                                            <rect x="14" y="3" width="7" height="7" rx="1"/>
                                            <rect x="3" y="14" width="7" height="7" rx="1"/>
                                        </svg>
                                    </div>
                                    <p class="empty-title">
                                        @if($sesiAktif)
                                            Belum ada scan
                                        @else
                                            Tidak ada sesi aktif
                                        @endif
                                    </p>
                                    <p class="empty-sub">
                                        @if($sesiAktif)
                                            Scan pertama akan muncul di sini secara otomatis.
                                        @else
                                            Buka sesi gerbang terlebih dahulu.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Timestamp bar --}}
            <div class="timestamp-bar">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                <span class="timestamp-text">Waktu server: <span id="live-clock">—</span></span>
                @if($sesiAktif)
                    <span class="timestamp-text" style="margin-left:auto">Auto-refresh setiap 4 detik</span>
                @endif
            </div>
        </div>

        {{-- Sidebar sesi hari ini --}}
        <div>
            {{-- Buka sesi baru --}}
            @if(!$sesiAktif)
            <div class="buka-sesi-card" style="margin-bottom:16px">
                <p class="buka-sesi-title">Buka Sesi Gerbang Baru</p>
                <form action="{{ route('piket.sesi-gerbang.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Tipe Sesi</label>
                        <select name="tipe" class="form-control" required>
                            <option value="masuk">Masuk (Pagi)</option>
                            <option value="pulang">Pulang (Siang/Sore)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catatan (opsional)</label>
                        <input type="text" name="catatan" class="form-control" maxlength="200"
                               placeholder="Mis: Sesi masuk shift pagi">
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Buka Sesi Baru
                    </button>
                </form>
            </div>
            @endif

            {{-- Daftar sesi hari ini --}}
            <div class="sidebar-card">
                <div class="sidebar-head">
                    <p class="sidebar-title">Sesi Hari Ini</p>
                </div>
                <div class="sidebar-body">
                    @forelse($sesiHariIni as $sesi)
                    <div class="sesi-item {{ $sesi->status === 'aktif' ? 'aktif' : '' }}">
                        <div class="sesi-item-head">
                            <span class="sesi-item-name">
                                {{ $sesi->label_tipe ?? ucfirst($sesi->tipe) }}
                            </span>
                            @if($sesi->status === 'aktif')
                                <span class="sesi-badge-aktif">Aktif</span>
                            @else
                                <span class="sesi-badge-tutup">Tutup</span>
                            @endif
                        </div>
                        <p class="sesi-item-meta">
                            Dibuka {{ $sesi->dibuka_pada->format('H:i') }}
                            @if($sesi->ditutup_pada)
                                &mdash; Tutup {{ $sesi->ditutup_pada->format('H:i') }}
                            @endif
                        </p>
                        <p class="sesi-item-meta">oleh {{ $sesi->dibukaOleh->name ?? '-' }}</p>
                    </div>
                    @empty
                    <div style="text-align:center;padding:24px 0">
                        <p style="font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text3)">
                            Belum ada sesi hari ini
                        </p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Link rekap & belum hadir --}}
            <div style="display:flex;flex-direction:column;gap:8px;margin-top:12px">
                <a href="{{ route('piket.absensi-gerbang.belum-hadir') }}" class="btn btn-yellow" style="justify-content:center">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <line x1="23" y1="11" x2="17" y2="11"/>
                    </svg>
                    Daftar Belum Hadir
                </a>
                <a href="{{ route('piket.absensi-gerbang.rekap') }}" class="btn btn-secondary" style="justify-content:center">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                        <rect x="9" y="3" width="6" height="4" rx="1"/>
                        <line x1="9" y1="12" x2="15" y2="12"/>
                        <line x1="9" y1="16" x2="13" y2="16"/>
                    </svg>
                    Lihat Rekap Lengkap
                </a>
            </div>
        </div>

    </div>{{-- /.live-grid --}}

</div>{{-- /.page --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({
        icon:'success', title:'Berhasil!',
        text: @json(session('success')),
        timer:2800, showConfirmButton:false,
        toast:true, position:'top-end'
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon:'error', title:'Gagal!',
        text: @json(session('error')),
        confirmButtonColor:'#1f63db'
    });
    @endif

    // ── Live Clock ──────────────────────────────────────────
    function tickClock() {
        const el = document.getElementById('live-clock');
        if (el) el.textContent = new Date().toLocaleTimeString('id-ID', { hour12: false });
    }
    tickClock();
    setInterval(tickClock, 1000);

    // ── Polling ─────────────────────────────────────────────
    @if($sesiAktif)
    let lastId = {{ $scanTerakhir->isNotEmpty() ? $scanTerakhir->first()->id : 0 }};
    let rowCounter = {{ $scanTerakhir->count() }};
    const MAX_ROWS = 30;

    function statusBadge(status) {
        const map = {
            'normal':        ['badge-normal',        'Normal'],
            'manual':        ['badge-manual',         'Manual'],
            'duplikat':      ['badge-duplikat',       'Duplikat'],
            'koreksi':       ['badge-koreksi',        'Koreksi'],
            'tidak_dikenal': ['badge-tidak_dikenal',  'Tidak Dikenal'],
        };
        const [cls, label] = map[status] ?? ['badge-tidak_dikenal', status];
        return `<span class="badge ${cls}"><span class="badge-dot"></span>${label}</span>`;
    }

    function tipeBadge(tipe) {
        return `<span class="badge-tipe-${tipe}">${tipe.charAt(0).toUpperCase() + tipe.slice(1)}</span>`;
    }

    function buildRow(scan, no) {
        const namaCell = scan.dikenal
            ? `<p class="primary">${scan.nama}</p><p class="secondary">${scan.kode_scan}</p>`
            : `<p class="primary" style="color:var(--text3);font-style:italic">Tidak dikenal</p><p class="secondary">${scan.kode_scan}</p>`;

        return `<tr data-id="${scan.id}" class="row-new">
            <td><span class="no-col">${no}</span></td>
            <td><div class="two-line">${namaCell}</div></td>
            <td class="muted">${scan.identitas}</td>
            <td class="muted">${scan.kelas}</td>
            <td class="center">${tipeBadge(scan.tipe)}</td>
            <td class="center">${statusBadge(scan.status)}</td>
            <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px;white-space:nowrap">
                ${scan.waktu_scan}
            </td>
        </tr>`;
    }

    async function pollLive() {
        try {
            const res = await fetch(`{{ route('piket.absensi-gerbang.ajax-live') }}?last_id=${lastId}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!res.ok) return;
            const data = await res.json();

            // Update timestamp
            const lastUpEl = document.getElementById('last-update');
            if (lastUpEl) lastUpEl.textContent = 'diperbarui ' + data.timestamp;

            if (!data.ada_sesi_aktif) return;

            // Update statistik
            if (data.statistik) {
                const s = data.statistik;
                const totalSiswa = parseInt(document.getElementById('stat-total-siswa')?.textContent || '0');
                setEl('stat-masuk', s.total_masuk);
                setEl('stat-belum', Math.max(0, totalSiswa - s.total_masuk));
                setEl('stat-tidak-dikenal', s.tidak_dikenal);
                const persen = totalSiswa > 0 ? Math.round((s.total_masuk / totalSiswa) * 100 * 10) / 10 : 0;
                setEl('stat-persen', persen + '% hadir');
                lastId = s.last_id > lastId ? s.last_id : lastId;
            }

            // Tambah baris baru
            if (data.scan_baru && data.scan_baru.length > 0) {
                const tbody = document.getElementById('scan-tbody');
                const emptyRow = document.getElementById('empty-row');
                if (emptyRow) emptyRow.remove();

                // Scan dari server sudah desc, balik agar urutan no benar
                const newScans = [...data.scan_baru].reverse();
                newScans.forEach(scan => {
                    rowCounter++;
                    const html = buildRow(scan, rowCounter);
                    tbody.insertAdjacentHTML('afterbegin', html);
                });

                // Trim agar tidak terlalu panjang
                const rows = tbody.querySelectorAll('tr[data-id]');
                if (rows.length > MAX_ROWS) {
                    for (let i = MAX_ROWS; i < rows.length; i++) {
                        rows[i].remove();
                    }
                }

                // Update count label
                const countEl = document.getElementById('feed-count');
                if (countEl) {
                    const visibleRows = tbody.querySelectorAll('tr[data-id]').length;
                    countEl.textContent = `— ${visibleRows} scan`;
                }

                // Notif toast untuk duplikat
                data.scan_baru.forEach(scan => {
                    if (scan.status === 'duplikat') {
                        Swal.fire({
                            icon:'warning', title:'Scan Duplikat',
                            text: `${scan.nama} sudah tercatat ${scan.tipe}`,
                            timer:3000, showConfirmButton:false,
                            toast:true, position:'bottom-end'
                        });
                    }
                });
            }

        } catch (e) {
            // Diam-diam gagal, coba lagi berikutnya
        }
    }

    function setEl(id, val) {
        const el = document.getElementById(id);
        if (el) el.textContent = val;
    }

    // Polling setiap 4 detik
    setInterval(pollLive, 4000);
    @endif
</script>
</x-app-layout>