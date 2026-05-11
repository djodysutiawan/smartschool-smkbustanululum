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
    .btn-edit { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover { background: var(--brand-100); filter: none; }
    .btn-danger-sm { background: var(--red-bg); color: var(--red-text); border: 1px solid var(--red-border); }
    .btn-danger-sm:hover { background: #fee2e2; filter: none; }

    /* Stats */
    .stats-strip { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px 18px; display: flex; align-items: center; gap: 12px; transition: box-shadow .2s; }
    .stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.06); }
    .stat-icon { width: 38px; height: 38px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .stat-icon.blue   { background: #eff6ff; }
    .stat-icon.green  { background: var(--green-bg); }
    .stat-icon.yellow { background: var(--yellow-bg); }
    .stat-icon.purple { background: #faf5ff; }
    .stat-icon.red    { background: var(--red-bg); }
    .stat-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; color: var(--text3); letter-spacing: .04em; text-transform: uppercase; }
    .stat-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: var(--text); line-height: 1.1; margin-top: 1px; }
    .stat-sub { font-size: 11px; color: var(--text3); margin-top: 1px; font-family: 'DM Sans', sans-serif; }

    /* Progress bar kehadiran */
    .hadir-bar-wrap { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px 20px; margin-bottom: 16px; }
    .hadir-bar-label { display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; }
    .hadir-bar-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .hadir-bar-pct { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 800; color: var(--brand-600); }
    .hadir-bar-track { height: 8px; background: var(--surface3); border-radius: 99px; overflow: hidden; }
    .hadir-bar-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #3582f0, #1f63db); transition: width .6s ease; }

    /* Filter */
    .filter-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px 20px; margin-bottom: 16px; }
    .filter-row { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
    .filter-control { height: 36px; padding: 0 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text); background: var(--surface2); outline: none; transition: border-color .15s; }
    .filter-control:focus { border-color: var(--brand-500); background: #fff; }
    .filter-control[type=date]  { width: 148px; }
    .filter-control[type=text]  { min-width: 200px; }
    .filter-sep { flex: 1; }
    .btn-filter { height: 36px; padding: 0 18px; background: var(--brand-600); color: #fff; border: none; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; transition: filter .15s; }
    .btn-filter:hover { filter: brightness(.9); }
    .btn-reset { height: 36px; padding: 0 14px; background: var(--surface2); color: var(--text2); border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: background .15s; }
    .btn-reset:hover { background: var(--surface3); }
    .btn-export { height: 36px; padding: 0 14px; background: var(--green-bg); color: var(--green-text); border: 1px solid var(--green-border); border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: background .15s; }
    .btn-export:hover { background: #dcfce7; }

    /* Table */
    .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .table-topbar { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--border); gap: 8px; flex-wrap: wrap; }
    .table-info { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .table-info span { font-weight: 400; color: var(--text3); margin-left: 6px; }
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

    /* Badges */
    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; white-space: nowrap; }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .badge-normal        { background: var(--green-bg); color: var(--green-text); }     .badge-normal .badge-dot        { background: var(--green-text); }
    .badge-manual        { background: #eff6ff; color: #1d4ed8; }                       .badge-manual .badge-dot        { background: #1d4ed8; }
    .badge-duplikat      { background: var(--yellow-bg); color: var(--yellow-text); }   .badge-duplikat .badge-dot      { background: #a16207; }
    .badge-koreksi       { background: #fdf4ff; color: #7c3aed; }                       .badge-koreksi .badge-dot       { background: #7c3aed; }
    .badge-tidak_dikenal { background: var(--surface3); color: var(--text2); }          .badge-tidak_dikenal .badge-dot { background: var(--text3); }

    .badge-tipe-masuk  { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); padding: 2px 9px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; }
    .badge-tipe-pulang { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; padding: 2px 9px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; }

    /* Two-line cell */
    .two-line .primary   { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 13.5px; color: var(--text); }
    .two-line .secondary { font-size: 12px; color: var(--text3); margin-top: 1px; font-family: 'DM Sans', sans-serif; }

    .action-group { display: flex; align-items: center; gap: 5px; justify-content: center; flex-wrap: wrap; }

    /* Empty state */
    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-icon { width: 56px; height: 56px; background: var(--surface2); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; border: 1px solid var(--border); }
    .empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 15px; color: var(--text); margin-bottom: 5px; }
    .empty-sub { font-size: 13px; color: var(--text3); font-family: 'DM Sans', sans-serif; }

    /* Pagination */
    .pag-wrap { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-top: 1px solid var(--border); flex-wrap: wrap; gap: 10px; background: var(--surface2); }
    .pag-info { font-size: 12.5px; color: var(--text3); font-family: 'DM Sans', sans-serif; }
    .pag-btns { display: flex; gap: 4px; flex-wrap: wrap; align-items: center; }
    .pag-btn { height: 32px; min-width: 32px; padding: 0 8px; border-radius: 7px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border); background: var(--surface); color: var(--text2); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; cursor: pointer; transition: all .15s; text-decoration: none; }
    .pag-btn:hover { background: var(--surface3); border-color: var(--border2); }
    .pag-btn.active { background: var(--brand-600); border-color: var(--brand-600); color: #fff; }
    .pag-btn.disabled { opacity: .35; cursor: not-allowed; pointer-events: none; }
    .pag-ellipsis { color: var(--text3); font-size: 13px; padding: 0 4px; line-height: 32px; }

    @media (max-width: 768px) {
        .stats-strip { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 640px) {
        .page { padding: 16px; }
        .filter-control[type=text] { min-width: 100%; }
    }
</style>

<div class="page">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Rekap Absensi Gerbang</h1>
            <p class="page-sub">
                Data scan masuk &amp; pulang — {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
            </p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
            <a href="{{ route('piket.absensi-gerbang.live') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                Live Monitor
            </a>
            {{-- Export PDF — bawa query string saat ini --}}
            <a href="{{ route('piket.absensi-gerbang.export-pdf', request()->only(['tanggal','tipe','kelas_id'])) }}"
               class="btn btn-primary" target="_blank">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Export PDF
            </a>
        </div>
    </div>

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
                <p class="stat-val">{{ $statistik['total_siswa'] }}</p>
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
                <p class="stat-val">{{ $statistik['total_masuk'] }}</p>
                <p class="stat-sub">{{ $statistik['persentase_hadir'] }}% hadir</p>
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
                <p class="stat-val">{{ $statistik['belum_hadir'] }}</p>
                <p class="stat-sub">dari total siswa</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Scan Manual</p>
                <p class="stat-val">{{ $statistik['scan_manual'] }}</p>
                <p class="stat-sub">input piket</p>
            </div>
        </div>
    </div>

    {{-- ── Progress kehadiran ── --}}
    <div class="hadir-bar-wrap">
        <div class="hadir-bar-label">
            <span class="hadir-bar-title">Tingkat Kehadiran Hari Ini</span>
            <span class="hadir-bar-pct">{{ $statistik['persentase_hadir'] }}%</span>
        </div>
        <div class="hadir-bar-track">
            <div class="hadir-bar-fill" style="width: {{ $statistik['persentase_hadir'] }}%"></div>
        </div>
    </div>

    {{-- ── Filter ── --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('piket.absensi-gerbang.rekap') }}">
            <div class="filter-row">
                <input type="date" name="tanggal" class="filter-control"
                       value="{{ $tanggal }}" max="{{ now()->format('Y-m-d') }}">

                <select name="tipe" class="filter-control">
                    <option value="">Semua Tipe</option>
                    <option value="masuk"  {{ request('tipe') === 'masuk'  ? 'selected' : '' }}>Masuk</option>
                    <option value="pulang" {{ request('tipe') === 'pulang' ? 'selected' : '' }}>Pulang</option>
                </select>

                <select name="status" class="filter-control">
                    <option value="">Semua Status</option>
                    @foreach(['normal','manual','duplikat','koreksi','tidak_dikenal'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $s)) }}
                        </option>
                    @endforeach
                </select>

                <select name="kelas_id" class="filter-control">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <input type="text" name="cari" class="filter-control"
                       value="{{ request('cari') }}" placeholder="Cari nama / NIS / NIP…">

                <div class="filter-sep"></div>

                @if(request()->hasAny(['tipe','status','kelas_id','cari']) || request('tanggal') !== now()->toDateString())
                    <a href="{{ route('piket.absensi-gerbang.rekap') }}" class="btn-reset">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                        Reset
                    </a>
                @endif

                <a href="{{ route('piket.absensi-gerbang.belum-hadir', ['tanggal' => $tanggal]) }}"
                   class="btn-export">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <line x1="23" y1="11" x2="17" y2="11"/>
                    </svg>
                    Belum Hadir
                </a>

                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- ── Tabel ── --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Scan
                @if($scanList->total() > 0)
                    <span>— {{ $scanList->firstItem() }}–{{ $scanList->lastItem() }} dari {{ $scanList->total() }} scan</span>
                @else
                    <span>— tidak ada data</span>
                @endif
            </p>
            @if($sesiAktif)
                <div style="display:flex;align-items:center;gap:6px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--green-text);font-weight:600">
                    <span style="width:7px;height:7px;border-radius:50%;background:var(--green-text);display:inline-block;animation:pulse-dot 1.4s ease-in-out infinite"></span>
                    Sesi Aktif
                </div>
            @endif
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:44px">#</th>
                        <th>Nama</th>
                        <th>Identitas</th>
                        <th>Kelas</th>
                        <th class="center">Tipe</th>
                        <th class="center">Status</th>
                        <th>Waktu Scan</th>
                        <th>Sesi</th>
                        <th>Input Oleh</th>
                        <th class="center" style="width:150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($scanList as $index => $scan)
                    <tr>
                        <td><span class="no-col">{{ $scanList->firstItem() + $index }}</span></td>

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
                                NIS: {{ $scan->siswa->nis ?? '—' }}
                            @elseif($scan->guru_id)
                                NIP: {{ $scan->guru->nip ?? '—' }}
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
                                {{ ucfirst(str_replace('_', ' ', $scan->status)) }}
                            </span>
                        </td>

                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px;white-space:nowrap">
                            {{ $scan->waktu_scan->format('H:i:s') }}
                        </td>

                        <td class="muted" style="white-space:nowrap">
                            {{ $scan->sesiGerbang?->label_tipe ?? ucfirst($scan->sesiGerbang?->tipe ?? '—') }}
                        </td>

                        <td class="muted" style="white-space:nowrap">
                            @if($scan->is_manual)
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;color:var(--brand-600)">
                                    {{ $scan->inputOleh->name ?? '—' }}
                                </span>
                            @else
                                <span style="color:var(--text3);font-size:12px">Scanner</span>
                            @endif
                        </td>

                        <td class="center">
                            <div class="action-group">
                                {{-- Edit catatan --}}
                                <a href="{{ route('piket.absensi-gerbang.edit', $scan->id) }}"
                                   class="btn btn-sm btn-edit">
                                    Edit
                                </a>

                                {{-- Hapus — hanya untuk manual atau tidak dikenal --}}
                                @if($scan->is_manual || ($scan->siswa_id === null && $scan->guru_id === null))
                                    @if(!$scan->hasilKoreksi()->exists())
                                    <form action="{{ route('piket.absensi-gerbang.destroy', $scan->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus record scan ini? Tindakan tidak bisa dibatalkan.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger-sm">Hapus</button>
                                    </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                                        <rect x="9" y="3" width="6" height="4" rx="1"/>
                                    </svg>
                                </div>
                                <p class="empty-title">Tidak ada data scan</p>
                                <p class="empty-sub">
                                    @if(request()->hasAny(['tipe','status','kelas_id','cari']))
                                        Tidak ada scan yang cocok dengan filter ini.
                                        <a href="{{ route('piket.absensi-gerbang.rekap', ['tanggal' => $tanggal]) }}"
                                           style="color:var(--brand-600);font-weight:700;text-decoration:none">
                                            Hapus filter
                                        </a>
                                    @else
                                        Belum ada scan tercatat untuk tanggal ini.
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($scanList->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">
                Menampilkan {{ $scanList->firstItem() }} – {{ $scanList->lastItem() }}
                dari {{ $scanList->total() }} scan
            </p>
            <div class="pag-btns">
                @if($scanList->onFirstPage())
                    <span class="pag-btn disabled">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $scanList->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                @php
                    $current      = $scanList->currentPage();
                    $last         = $scanList->lastPage();
                    $prevEllipsis = false;
                    $nextEllipsis = false;
                @endphp

                @foreach($scanList->getUrlRange(1, $last) as $page => $url)
                    @php $show = ($page === 1) || ($page === $last) || (abs($page - $current) <= 1); @endphp
                    @if($show)
                        @php $prevEllipsis = false; $nextEllipsis = false; @endphp
                        @if($page === $current)
                            <span class="pag-btn active">{{ $page }}</span>
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

                @if($scanList->hasMorePages())
                    <a href="{{ $scanList->nextPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                @else
                    <span class="pag-btn disabled">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </span>
                @endif
            </div>
        </div>
        @endif

    </div>{{-- /.table-card --}}

</div>{{-- /.page --}}

<style>
    @keyframes pulse-dot { 0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(.85)} }
</style>

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
</script>
</x-app-layout>