<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand: #1f63db; --brand-h: #3582f0; --brand-50: #eef6ff; --brand-100: #d9ebff; --brand-700: #1750c0;
        --surface: #fff; --surface2: #f8fafc; --surface3: #f1f5f9;
        --border: #e2e8f0; --border2: #cbd5e1;
        --text: #0f172a; --text2: #475569; --text3: #94a3b8;
        --red: #dc2626; --red-bg: #fee2e2; --red-border: #fecaca;
        --green: #15803d; --green-bg: #dcfce7; --green-border: #bbf7d0;
        --radius: 10px; --radius-sm: 7px;
    }
    .page { padding: 28px 28px 40px; }
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2; }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .header-actions { display: flex; gap: 8px; flex-wrap: wrap; }

    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s; white-space: nowrap; }
    .btn:hover { filter: brightness(.93); }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 6px; }
    .btn-edit { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover { background: var(--brand-100); filter: none; }
    .btn-del { background: #fff0f0; color: #dc2626; border: 1px solid #fecaca; }
    .btn-del:hover { background: #fee2e2; filter: none; }
    .btn-detail { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .btn-detail:hover { background: #dcfce7; filter: none; }
    .btn-toggle-on { background: #fef9c3; color: #a16207; border: 1px solid #fde68a; }
    .btn-toggle-on:hover { background: #fef08a; filter: none; }
    .btn-toggle-off { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .btn-toggle-off:hover { background: #dcfce7; filter: none; }
    .btn-outline { background: var(--surface); color: var(--text2); border: 1px solid var(--border); }
    .btn-outline:hover { background: var(--surface2); filter: none; }
    .btn-green { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .btn-green:hover { background: #dcfce7; filter: none; }

    .stats-strip { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px 18px; display: flex; align-items: center; gap: 12px; }
    .stat-icon { width: 38px; height: 38px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .stat-icon.blue { background: var(--brand-50); }
    .stat-icon.green { background: #f0fdf4; }
    .stat-icon.red { background: #fff0f0; }
    .stat-icon.purple { background: #faf5ff; }
    .stat-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 600; color: var(--text3); letter-spacing: .03em; text-transform: uppercase; }
    .stat-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: var(--text); line-height: 1.1; margin-top: 1px; }

    .filter-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 16px 20px; margin-bottom: 16px; }
    .filter-row { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
    .filter-row input, .filter-row select { height: 36px; padding: 0 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text); background: var(--surface2); outline: none; transition: border-color .15s; }
    .filter-row input { width: 220px; }
    .filter-row input:focus, .filter-row select:focus { border-color: var(--brand-h); background: #fff; }
    .filter-row input::placeholder { color: var(--text3); }
    .filter-sep { flex: 1; }
    .btn-filter { height: 36px; padding: 0 18px; background: var(--brand); color: #fff; border: none; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; }
    .btn-filter:hover { background: var(--brand-700); }
    .btn-reset { height: 36px; padding: 0 14px; background: var(--surface2); color: var(--text2); border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; }
    .btn-reset:hover { background: var(--surface3); }

    .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .table-topbar { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 10px; }
    .table-info { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .table-info span { font-weight: 400; color: var(--text3); margin-left: 6px; }
    .table-actions { display: flex; gap: 8px; flex-wrap: wrap; }
    .table-wrap { overflow-x: auto; }

    table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    thead tr { background: var(--surface2); border-bottom: 1px solid var(--border); }
    thead th { padding: 11px 14px; text-align: left; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); letter-spacing: .05em; text-transform: uppercase; white-space: nowrap; }
    thead th.center { text-align: center; }
    tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .1s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fafbff; }
    td { padding: 10px 14px; color: var(--text); vertical-align: middle; }
    td.center { text-align: center; }
    td.muted { color: var(--text3); }
    .no-col { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text3); }

    .mapel-wrap .mname { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 13.5px; color: var(--text); }
    .mapel-wrap .mcode { font-size: 11.5px; color: var(--text3); margin-top: 1px; font-family: 'DM Sans', sans-serif; }

    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; white-space: nowrap; }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-aktif { background: #dcfce7; color: #15803d; }
    .badge-aktif .badge-dot { background: #15803d; }
    .badge-nonaktif { background: #fee2e2; color: #dc2626; }
    .badge-nonaktif .badge-dot { background: #dc2626; }

    .kelompok-pill { display: inline-block; padding: 2px 9px; border-radius: 5px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .perlu-lab-yes { display: inline-flex; align-items: center; gap: 4px; font-size: 12px; font-weight: 600; color: #7c3aed; font-family: 'Plus Jakarta Sans', sans-serif; }
    .perlu-lab-no { color: var(--text3); font-size: 12px; font-family: 'DM Sans', sans-serif; }

    .action-group { display: flex; align-items: center; gap: 5px; justify-content: center; flex-wrap: wrap; }

    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-icon { width: 56px; height: 56px; background: var(--surface2); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
    .empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 15px; color: var(--text); margin-bottom: 5px; }
    .empty-sub { font-size: 13px; color: var(--text3); }

    .pag-wrap { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-top: 1px solid var(--border); flex-wrap: wrap; gap: 10px; }
    .pag-info { font-size: 12.5px; color: var(--text3); }
    .pag-btns { display: flex; gap: 4px; align-items: center; }
    .pag-btn { height: 32px; min-width: 32px; padding: 0 8px; border-radius: 7px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border); background: var(--surface); color: var(--text2); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; cursor: pointer; transition: all .15s; text-decoration: none; }
    .pag-btn:hover { background: var(--surface2); border-color: var(--border2); }
    .pag-btn.active { background: var(--brand); border-color: var(--brand); color: #fff; }
    .pag-ellipsis { color: var(--text3); font-size: 13px; padding: 0 4px; }

    .import-modal { display: none; position: fixed; inset: 0; z-index: 999; background: rgba(15,23,42,.45); align-items: center; justify-content: center; }
    .import-modal.open { display: flex; }
    .import-box { background: #fff; border-radius: var(--radius); width: 440px; max-width: 95vw; box-shadow: 0 20px 60px rgba(0,0,0,.18); overflow: hidden; }
    .import-header { display: flex; align-items: center; justify-content: space-between; padding: 18px 22px; border-bottom: 1px solid var(--border); }
    .import-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 800; color: var(--text); }
    .import-close { background: none; border: none; cursor: pointer; color: var(--text3); padding: 4px; border-radius: 6px; }
    .import-close:hover { color: var(--text); background: var(--surface2); }
    .import-body { padding: 22px; }
    .import-body p { font-size: 13px; color: var(--text2); margin-bottom: 16px; line-height: 1.6; }
    .import-body input[type="file"] { width: 100%; border: 2px dashed var(--border2); border-radius: var(--radius-sm); padding: 16px; font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text2); cursor: pointer; background: var(--surface2); }
    .import-footer { display: flex; justify-content: flex-end; gap: 8px; padding: 14px 22px; border-top: 1px solid var(--border); background: var(--surface2); }

    @media (max-width: 640px) {
        .stats-strip { grid-template-columns: 1fr 1fr; }
        .page { padding: 16px; }
        .filter-row input { width: 100%; }
    }
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Mata Pelajaran</h1>
            <p class="page-sub">Kelola master data mata pelajaran — tambah, edit, nonaktifkan, dan hapus</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.mata-pelajaran.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Mata Pelajaran
            </a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Mapel</p>
                <p class="stat-val">{{ $mapel->total() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Aktif</p>
                <p class="stat-val">{{ \App\Models\MataPelajaran::where('is_active', true)->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
            </div>
            <div>
                <p class="stat-label">Nonaktif</p>
                <p class="stat-val">{{ \App\Models\MataPelajaran::where('is_active', false)->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <div>
                <p class="stat-label">Butuh Lab</p>
                <p class="stat-val">{{ \App\Models\MataPelajaran::where('perlu_lab', true)->count() }}</p>
            </div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.mata-pelajaran.index') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau kode mapel...">
                <select name="kelompok">
                    <option value="">Semua Kelompok</option>
                    @foreach($kelompoks as $k)
                        <option value="{{ $k }}" {{ request('kelompok') == $k ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $k)) }}</option>
                    @endforeach
                </select>
                <select name="is_active">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.mata-pelajaran.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Mata Pelajaran
                <span>— menampilkan {{ $mapel->firstItem() ?? 0 }}–{{ $mapel->lastItem() ?? 0 }} dari {{ $mapel->total() }} data</span>
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.mata-pelajaran.export.pdf', request()->query()) }}" class="btn btn-sm btn-del" target="_blank">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.mata-pelajaran.export.excel', request()->query()) }}" class="btn btn-sm btn-outline">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export Excel
                </a>
                <button type="button" class="btn btn-sm btn-green" onclick="document.getElementById('importModal').classList.add('open')">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Import
                </button>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Nama / Kode Mapel</th>
                        <th>Kelompok</th>
                        <th class="center">Jam/Minggu</th>
                        <th class="center">Durasi Sesi</th>
                        <th class="center">Perlu Lab</th>
                        <th class="center">Jadwal</th>
                        <th>Status</th>
                        <th class="center" style="width:230px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mapel as $index => $m)
                    <tr>
                        <td><span class="no-col">{{ $mapel->firstItem() + $index }}</span></td>
                        <td>
                            <div class="mapel-wrap">
                                <p class="mname">{{ $m->nama_mapel }}</p>
                                <p class="mcode">{{ $m->kode_mapel }}</p>
                            </div>
                        </td>
                        <td>
                            @if($m->kelompok)
                                <span class="kelompok-pill">{{ ucfirst(str_replace('_', ' ', $m->kelompok)) }}</span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>
                        <td class="center" style="font-size:13px;font-weight:700;color:var(--text)">{{ $m->jam_per_minggu }} jam</td>
                        <td class="center muted" style="font-size:12.5px">{{ $m->durasi_per_sesi }} menit</td>
                        <td class="center">
                            @if($m->perlu_lab)
                                <span class="perlu-lab-yes">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"/></svg>
                                    Ya
                                </span>
                            @else
                                <span class="perlu-lab-no">—</span>
                            @endif
                        </td>
                        <td class="center" style="font-size:13px;color:var(--text2);font-weight:600">{{ $m->jadwal_pelajaran_count }}</td>
                        <td>
                            @if($m->is_active)
                                <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                            @else
                                <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.mata-pelajaran.show', $m->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('admin.mata-pelajaran.edit', $m->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('admin.mata-pelajaran.toggle-status', $m->id) }}" method="POST" id="toggleForm-{{ $m->id }}">
                                    @csrf @method('PATCH')
                                    <button type="button"
                                        class="btn btn-sm {{ $m->is_active ? 'btn-toggle-on' : 'btn-toggle-off' }}"
                                        onclick="confirmToggle(document.getElementById('toggleForm-{{ $m->id }}'), '{{ addslashes($m->nama_mapel) }}', {{ $m->is_active ? 'true' : 'false' }})">
                                        {{ $m->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.mata-pelajaran.destroy', $m->id) }}" method="POST" id="deleteForm-{{ $m->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('deleteForm-{{ $m->id }}'), '{{ addslashes($m->nama_mapel) }}')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                </div>
                                <p class="empty-title">Mata pelajaran tidak ditemukan</p>
                                <p class="empty-sub">Coba ubah kata kunci pencarian atau reset filter</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mapel->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $mapel->firstItem() }} – {{ $mapel->lastItem() }} dari {{ $mapel->total() }} mata pelajaran</p>
            <div class="pag-btns">
                @if($mapel->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $mapel->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($mapel->getUrlRange(1, $mapel->lastPage()) as $page => $url)
                    @if($page == $mapel->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $mapel->lastPage() || abs($page - $mapel->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $mapel->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($mapel->hasMorePages())
                    <a href="{{ $mapel->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Import Modal --}}
<div class="import-modal" id="importModal">
    <div class="import-box">
        <div class="import-header">
            <p class="import-title">Import Mata Pelajaran</p>
            <button class="import-close" onclick="document.getElementById('importModal').classList.remove('open')">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.mata-pelajaran.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="import-body">
                <p>Upload file Excel (.xlsx, .xls) atau CSV. Pastikan format sesuai template. <a href="{{ route('admin.mata-pelajaran.import.template') }}" style="color:var(--brand);font-weight:600">Download template</a>.</p>
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required>
            </div>
            <div class="import-footer">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('importModal').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-primary">Upload & Import</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif

    function confirmDelete(form, nama) {
        Swal.fire({
            title: 'Hapus Mata Pelajaran?',
            html: `Mata pelajaran <strong>${nama}</strong> akan dihapus permanen.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }

    function confirmToggle(form, nama, isActive) {
        Swal.fire({
            title: `${isActive ? 'Nonaktifkan' : 'Aktifkan'} Mata Pelajaran?`,
            html: `Mata pelajaran <strong>${nama}</strong> akan di${isActive ? 'nonaktifkan' : 'aktifkan'}.`,
            icon: isActive ? 'warning' : 'question', showCancelButton: true,
            confirmButtonColor: '#1f63db', cancelButtonColor: '#64748b',
            confirmButtonText: `Ya, ${isActive ? 'Nonaktifkan' : 'Aktifkan'}!`, cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }

    document.getElementById('importModal').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });
</script>
</x-app-layout>