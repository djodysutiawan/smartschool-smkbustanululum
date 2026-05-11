<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
        --yellow-bg:#fefce8;--yellow-border:#fde68a;--yellow-text:#b45309;
        --green-bg:#f0fdf4;--green-border:#bbf7d0;--green-text:#15803d;
        --red-bg:#fef2f2;--red-border:#fecaca;--red-text:#dc2626;
        --orange-bg:#fff7ed;--orange-border:#fed7aa;--orange-text:#c2410c;
    }

    *, *::before, *::after { box-sizing: border-box; }
    .page { padding: 28px 28px 56px; }

    /* ── Header ── */
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2; }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; font-family: 'DM Sans', sans-serif; }
    .header-actions { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }

    /* ── Buttons ── */
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s, background .15s; white-space: nowrap; }
    .btn:hover { filter: brightness(.93); }
    .btn-primary   { background: var(--brand-600); color: #fff; }
    .btn-secondary { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-secondary:hover { background: var(--surface3); filter: none; }
    .btn-danger    { background: var(--red-bg); color: var(--red-text); border: 1px solid var(--red-border); }
    .btn-danger:hover { background: #fee2e2; filter: none; }
    .btn-sm { padding: 5px 11px; font-size: 12px; border-radius: 6px; }

    /* ── Stat cards ── */
    .stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 16px 18px; position: relative; overflow: hidden; }
    .stat-card::before { content: ''; position: absolute; inset: 0; opacity: .04; }
    .stat-card.danger  { border-color: var(--red-border);    background: var(--red-bg); }
    .stat-card.success { border-color: var(--green-border);  background: var(--green-bg); }
    .stat-card.warning { border-color: var(--yellow-border); background: var(--yellow-bg); }
    .stat-card.info    { border-color: var(--brand-100);     background: var(--brand-50); }
    .stat-label { font-family: 'DM Sans', sans-serif; font-size: 11.5px; font-weight: 600; color: var(--text3); text-transform: uppercase; letter-spacing: .05em; margin-bottom: 6px; }
    .stat-value { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 26px; font-weight: 800; color: var(--text); line-height: 1; }
    .stat-card.danger  .stat-value { color: var(--red-text); }
    .stat-card.success .stat-value { color: var(--green-text); }
    .stat-card.warning .stat-value { color: var(--yellow-text); }
    .stat-card.info    .stat-value { color: var(--brand-700); }
    .stat-sub  { font-family: 'DM Sans', sans-serif; font-size: 11.5px; color: var(--text3); margin-top: 4px; }

    /* Progress bar */
    .progress-wrap { margin-top: 10px; height: 5px; background: var(--surface3); border-radius: 99px; overflow: hidden; }
    .progress-bar  { height: 100%; border-radius: 99px; background: var(--green-text); transition: width .5s ease; }

    /* ── Filter bar ── */
    .filter-bar { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px 18px; margin-bottom: 16px; display: flex; align-items: flex-end; gap: 12px; flex-wrap: wrap; }
    .filter-group { display: flex; flex-direction: column; gap: 5px; flex: 1; min-width: 140px; }
    .filter-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .05em; }
    .filter-control { height: 38px; padding: 0 10px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text); background: var(--surface2); outline: none; transition: border-color .15s; }
    .filter-control:focus { border-color: var(--brand-500); background: #fff; }
    .filter-search { flex: 2; min-width: 220px; }
    .filter-search .filter-control { width: 100%; padding-left: 36px; }
    .filter-search-wrap { position: relative; }
    .filter-search-icon { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); pointer-events: none; }

    /* ── Table card ── */
    .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .table-card-head { padding: 14px 18px; border-bottom: 1px solid var(--border); background: var(--surface2); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .table-card-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .table-card-meta  { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); }

    .tbl { width: 100%; border-collapse: collapse; }
    .tbl thead th { padding: 10px 16px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .05em; text-align: left; background: var(--surface2); border-bottom: 1px solid var(--border); white-space: nowrap; }
    .tbl tbody tr { border-bottom: 1px solid var(--surface3); transition: background .1s; }
    .tbl tbody tr:last-child { border-bottom: none; }
    .tbl tbody tr:hover { background: #fafbff; }
    .tbl tbody td { padding: 11px 16px; font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text2); vertical-align: middle; }

    /* Avatar + name combo */
    .siswa-cell { display: flex; align-items: center; gap: 10px; }
    .siswa-avatar { width: 34px; height: 34px; border-radius: 9px; background: linear-gradient(135deg,#3582f0,#1750c0); display: flex; align-items: center; justify-content: center; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 800; color: #fff; flex-shrink: 0; }
    .siswa-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .siswa-nis  { font-family: 'DM Sans', sans-serif; font-size: 11.5px; color: var(--text3); margin-top: 1px; }

    /* Badge kelas */
    .badge-kelas { display: inline-flex; align-items: center; padding: 2px 9px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); white-space: nowrap; }

    /* Empty state */
    .empty-state { padding: 56px 24px; text-align: center; }
    .empty-icon { width: 56px; height: 56px; border-radius: 16px; background: var(--green-bg); border: 1px solid var(--green-border); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
    .empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 800; color: var(--text); margin-bottom: 6px; }
    .empty-sub   { font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text3); }

    /* Pagination */
    .pagination-wrap { display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border-top: 1px solid var(--border); background: var(--surface2); flex-wrap: wrap; gap: 10px; }
    .pagination-info { font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--text3); }
    .pagination-links { display: flex; gap: 4px; align-items: center; }
    .page-link { display: inline-flex; align-items: center; justify-content: center; min-width: 32px; height: 32px; padding: 0 8px; border-radius: 7px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--text2); background: var(--surface); border: 1px solid var(--border); text-decoration: none; transition: background .1s, color .1s; }
    .page-link:hover { background: var(--surface3); }
    .page-link.active { background: var(--brand-600); color: #fff; border-color: var(--brand-600); }
    .page-link.disabled { opacity: .4; pointer-events: none; }

    /* Alert */
    .alert { display: flex; align-items: flex-start; gap: 10px; padding: 12px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; margin-bottom: 16px; }
    .alert.success { background: var(--green-bg); border: 1px solid var(--green-border); color: var(--green-text); }
    .alert.error   { background: var(--red-bg);   border: 1px solid var(--red-border);   color: var(--red-text); }

    /* No filter indicator */
    .tanggal-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 99px; background: var(--orange-bg); border: 1px solid var(--orange-border); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--orange-text); }

    @media (max-width: 900px) { .stat-row { grid-template-columns: repeat(2,1fr); } }
    @media (max-width: 600px) { .stat-row { grid-template-columns: 1fr 1fr; } .page { padding: 16px; } .filter-bar { gap: 8px; } }
</style>

<div class="page">

    {{-- ── Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Siswa Belum Hadir</h1>
            <p class="page-sub">Daftar siswa yang belum melakukan scan masuk hari ini</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('piket.absensi-gerbang.live') }}" class="btn btn-secondary btn-sm">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                Live Monitor
            </a>
            <a href="{{ route('piket.absensi-gerbang.rekap') }}" class="btn btn-secondary btn-sm">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                    <rect x="9" y="3" width="6" height="4" rx="1"/>
                </svg>
                Rekap
            </a>
            <a href="{{ route('piket.absensi-gerbang.belum-hadir-export-pdf', request()->query()) }}"
               class="btn btn-danger btn-sm" target="_blank">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="12" y1="18" x2="12" y2="12"/>
                    <line x1="9" y1="15" x2="15" y2="15"/>
                </svg>
                Export PDF
            </a>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="alert success">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert error">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Stat cards ── --}}
    <div class="stat-row">
        <div class="stat-card danger">
            <p class="stat-label">Belum Hadir</p>
            <p class="stat-value">{{ $statistik['belum_hadir'] }}</p>
            <p class="stat-sub">dari {{ $statistik['total_siswa'] }} siswa aktif</p>
        </div>
        <div class="stat-card success">
            <p class="stat-label">Sudah Hadir</p>
            <p class="stat-value">{{ $statistik['sudah_hadir'] }}</p>
            <p class="stat-sub">{{ $statistik['persentase'] }}% kehadiran</p>
            <div class="progress-wrap">
                <div class="progress-bar" style="width:{{ $statistik['persentase'] }}%"></div>
            </div>
        </div>
        <div class="stat-card info">
            <p class="stat-label">Total Siswa</p>
            <p class="stat-value">{{ $statistik['total_siswa'] }}</p>
            <p class="stat-sub">siswa aktif terdaftar</p>
        </div>
        <div class="stat-card warning">
            <p class="stat-label">Tanggal</p>
            <p class="stat-value" style="font-size:18px;margin-top:2px">
                {{ \Carbon\Carbon::parse($tanggal)->isoFormat('D MMM Y') }}
            </p>
            <p class="stat-sub">{{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd') }}</p>
        </div>
    </div>

    {{-- ── Filter bar ── --}}
    <form method="GET" action="{{ route('piket.absensi-gerbang.belum-hadir') }}" class="filter-bar" id="filter-form">

        <div class="filter-group" style="max-width:160px">
            <label class="filter-label" for="f-tanggal">Tanggal</label>
            <input type="date" id="f-tanggal" name="tanggal" class="filter-control"
                   value="{{ $tanggal }}" max="{{ now()->toDateString() }}"
                   onchange="this.form.submit()">
        </div>

        <div class="filter-group" style="max-width:200px">
            <label class="filter-label" for="f-kelas">Kelas</label>
            <select id="f-kelas" name="kelas_id" class="filter-control" onchange="this.form.submit()">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $kelas)
                    <option value="{{ $kelas->id }}"
                        {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                        {{ $kelas->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group filter-search">
            <label class="filter-label" for="f-cari">Cari Nama / NIS</label>
            <div class="filter-search-wrap">
                <svg class="filter-search-icon" width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="f-cari" name="cari" class="filter-control"
                       placeholder="Nama siswa atau NIS…"
                       value="{{ request('cari') }}">
            </div>
        </div>

        <div style="display:flex;gap:8px;padding-bottom:1px">
            <button type="submit" class="btn btn-primary btn-sm">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Cari
            </button>
            @if(request()->hasAny(['kelas_id','cari']) || $tanggal !== now()->toDateString())
                <a href="{{ route('piket.absensi-gerbang.belum-hadir') }}" class="btn btn-secondary btn-sm">Reset</a>
            @endif
        </div>
    </form>

    {{-- ── Table ── --}}
    <div class="table-card">
        <div class="table-card-head">
            <div>
                <p class="table-card-title">Daftar Siswa Belum Hadir</p>
                <p class="table-card-meta">
                    Total {{ $belumHadirList->total() }} siswa
                    @if(request('kelas_id'))
                        &bull; Filter: {{ $kelasList->firstWhere('id', request('kelas_id'))?->nama_kelas }}
                    @endif
                </p>
            </div>
            @if($tanggal !== now()->toDateString())
                <span class="tanggal-badge">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    {{ \Carbon\Carbon::parse($tanggal)->isoFormat('D MMM Y') }}
                </span>
            @endif
        </div>

        @if($belumHadirList->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="24" height="24" fill="none" stroke="var(--green-text)" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </div>
                <p class="empty-title">Semua Siswa Sudah Hadir!</p>
                <p class="empty-sub">
                    @if(request()->hasAny(['kelas_id','cari']))
                        Tidak ada siswa yang cocok dengan filter pencarian.
                    @else
                        Seluruh siswa sudah melakukan scan masuk hari ini.
                    @endif
                </p>
            </div>
        @else
            <div style="overflow-x:auto">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th style="width:40px">#</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($belumHadirList as $i => $siswa)
                            <tr>
                                <td style="color:var(--text3);font-size:12px;font-weight:700">
                                    {{ $belumHadirList->firstItem() + $i }}
                                </td>
                                <td>
                                    <div class="siswa-cell">
                                        <div class="siswa-avatar">
                                            {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="siswa-name">{{ $siswa->nama_lengkap }}</p>
                                            <p class="siswa-nis">{{ $siswa->nis }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text)">
                                    {{ $siswa->nis }}
                                </td>
                                <td>
                                    <span class="badge-kelas">{{ $siswa->kelas?->nama_kelas ?? '—' }}</span>
                                </td>
                                <td>
                                    {{-- Shortcut: langsung ke form input manual untuk siswa ini --}}
                                    <a href="{{ route('piket.absensi-gerbang.scan-manual') }}?siswa_id={{ $siswa->id }}"
                                       class="btn btn-secondary btn-sm">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <polyline points="9 11 12 14 22 4"/>
                                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                                        </svg>
                                        Input Manual
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($belumHadirList->hasPages())
                <div class="pagination-wrap">
                    <p class="pagination-info">
                        Menampilkan {{ $belumHadirList->firstItem() }}–{{ $belumHadirList->lastItem() }}
                        dari {{ $belumHadirList->total() }} siswa
                    </p>
                    <div class="pagination-links">
                        @if($belumHadirList->onFirstPage())
                            <span class="page-link disabled">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                            </span>
                        @else
                            <a href="{{ $belumHadirList->previousPageUrl() }}" class="page-link">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                            </a>
                        @endif

                        @foreach($belumHadirList->getUrlRange(max(1,$belumHadirList->currentPage()-2), min($belumHadirList->lastPage(),$belumHadirList->currentPage()+2)) as $page => $url)
                            <a href="{{ $url }}" class="page-link {{ $page == $belumHadirList->currentPage() ? 'active' : '' }}">
                                {{ $page }}
                            </a>
                        @endforeach

                        @if($belumHadirList->hasMorePages())
                            <a href="{{ $belumHadirList->nextPageUrl() }}" class="page-link">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            </a>
                        @else
                            <span class="page-link disabled">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        @endif
    </div>

</div>
</x-app-layout>