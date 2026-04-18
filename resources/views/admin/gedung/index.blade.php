<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700: #1750c0; --brand-600: #1f63db; --brand-500: #3582f0; --brand-100: #d9ebff; --brand-50: #eef6ff;
        --surface: #fff; --surface2: #f8fafc; --surface3: #f1f5f9;
        --border: #e2e8f0; --border2: #cbd5e1;
        --text: #0f172a; --text2: #475569; --text3: #94a3b8;
        --radius: 10px; --radius-sm: 7px;
    }
    .page { padding: 28px 28px 40px; }
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2; }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .header-actions { display: flex; gap: 8px; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s; white-space: nowrap; }
    .btn:hover { filter: brightness(.93); }
    .btn-primary { background: var(--brand-600); color: #fff; }
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
    .btn-export { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); height: 36px; padding: 0 14px; font-size: 13px; }
    .btn-export:hover { background: var(--surface3); filter: none; }
    .btn-import { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; height: 36px; padding: 0 14px; font-size: 13px; }
    .btn-import:hover { background: #dcfce7; filter: none; }

    .stats-strip { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px 18px; display: flex; align-items: center; gap: 12px; }
    .stat-icon { width: 38px; height: 38px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .stat-icon.blue { background: var(--brand-50); }
    .stat-icon.green { background: #f0fdf4; }
    .stat-icon.red { background: #fff0f0; }
    .stat-icon.orange { background: #fff7ed; }
    .stat-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 600; color: var(--text3); letter-spacing: .03em; text-transform: uppercase; }
    .stat-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: var(--text); line-height: 1.1; margin-top: 1px; }

    .filter-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 16px 20px; margin-bottom: 16px; }
    .filter-row { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
    .filter-row input, .filter-row select { height: 36px; padding: 0 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text); background: var(--surface2); outline: none; transition: border-color .15s; }
    .filter-row input { width: 210px; }
    .filter-row input:focus, .filter-row select:focus { border-color: var(--brand-500); background: #fff; }
    .filter-row input::placeholder { color: var(--text3); }
    .filter-sep { flex: 1; }
    .btn-filter { height: 36px; padding: 0 18px; background: var(--brand-600); color: #fff; border: none; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; }
    .btn-filter:hover { background: var(--brand-700); }
    .btn-reset { height: 36px; padding: 0 14px; background: var(--surface2); color: var(--text2); border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; }
    .btn-reset:hover { background: var(--surface3); }

    .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .table-topbar { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 10px; }
    .table-info { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .table-info span { font-weight: 400; color: var(--text3); margin-left: 6px; }
    .topbar-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
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
    .gedung-wrap .gname { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 13.5px; color: var(--text); }
    .gedung-wrap .gcode { font-size: 11.5px; color: var(--text3); margin-top: 1px; font-family: 'DM Sans', sans-serif; }
    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; white-space: nowrap; }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-aktif { background: #dcfce7; color: #15803d; }
    .badge-aktif .badge-dot { background: #15803d; }
    .badge-nonaktif { background: #fee2e2; color: #dc2626; }
    .badge-nonaktif .badge-dot { background: #dc2626; }
    .ruang-count { display: inline-flex; align-items: center; gap: 5px; font-size: 13px; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--brand-700); }
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
    .pag-btn.active { background: var(--brand-600); border-color: var(--brand-600); color: #fff; }
    .pag-ellipsis { color: var(--text3); font-size: 13px; padding: 0 4px; }

    .modal-backdrop { position: fixed; inset: 0; background: rgba(15,23,42,.45); z-index: 50; display: flex; align-items: center; justify-content: center; padding: 20px; }
    .modal-box { background: #fff; border-radius: 12px; width: 100%; max-width: 420px; box-shadow: 0 20px 60px rgba(0,0,0,.18); overflow: hidden; }
    .modal-header { padding: 18px 20px 14px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
    .modal-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 800; color: var(--text); }
    .modal-close { width: 28px; height: 28px; border: none; background: var(--surface2); border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--text3); }
    .modal-body { padding: 20px; }
    .modal-footer { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; gap: 8px; justify-content: flex-end; }
    .field { display: flex; flex-direction: column; gap: 6px; margin-bottom: 14px; }
    .field label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2); }
    .field input[type="file"] { padding: 8px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13px; background: var(--surface2); width: 100%; }
    .field-hint { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; }
    .btn-cancel-modal { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-cancel-modal:hover { background: var(--surface3); filter: none; }
    .btn-success { background: #15803d; color: #fff; }
    .btn-success:hover { filter: brightness(.9); }

    @media (max-width: 640px) { .stats-strip { grid-template-columns: 1fr 1fr; } .page { padding: 16px; } }
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Data Gedung</h1>
            <p class="page-sub">Kelola data gedung sekolah — tambah, edit, nonaktifkan, dan hapus</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.gedung.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Gedung
            </a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Gedung</p>
                <p class="stat-val">{{ \App\Models\Gedung::count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Aktif</p>
                <p class="stat-val">{{ \App\Models\Gedung::where('is_active', true)->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
            </div>
            <div>
                <p class="stat-label">Nonaktif</p>
                <p class="stat-val">{{ \App\Models\Gedung::where('is_active', false)->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Ruang</p>
                <p class="stat-val">{{ \App\Models\Gedung::withCount('ruang')->get()->sum('ruang_count') }}</p>
            </div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.gedung.index') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau kode gedung...">
                <select name="is_active">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.gedung.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Gedung
                <span>— menampilkan {{ $gedung->firstItem() }}–{{ $gedung->lastItem() }} dari {{ $gedung->total() }} data</span>
            </p>
            <div class="topbar-actions">
                <a href="{{ route('admin.gedung.export.pdf', request()->query()) }}" class="btn btn-sm btn-export">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.gedung.export.excel', request()->query()) }}" class="btn btn-sm btn-export">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                    Export Excel
                </a>
                <button type="button" class="btn btn-sm btn-import" onclick="document.getElementById('importModal').style.display='flex'">
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
                        <th>Nama / Kode Gedung</th>
                        <th class="center">Jumlah Lantai</th>
                        <th class="center">Total Ruang</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th class="center" style="width:220px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gedung as $index => $g)
                    <tr>
                        <td><span class="no-col">{{ $gedung->firstItem() + $index }}</span></td>
                        <td>
                            <div class="gedung-wrap">
                                <p class="gname">{{ $g->nama_gedung }}</p>
                                <p class="gcode">{{ $g->kode_gedung }}</p>
                            </div>
                        </td>
                        <td class="center" style="font-size:13px;font-weight:700;color:var(--text)">{{ $g->jumlah_lantai }} lantai</td>
                        <td class="center">
                            <span class="ruang-count">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/></svg>
                                {{ $g->ruang_count }}
                            </span>
                        </td>
                        <td class="muted" style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                            {{ $g->deskripsi ? \Illuminate\Support\Str::limit($g->deskripsi, 50) : '—' }}
                        </td>
                        <td>
                            @if($g->is_active)
                                <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                            @else
                                <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.gedung.show', $g->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('admin.gedung.edit', $g->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('admin.gedung.toggle-status', $g->id) }}" method="POST" id="toggleForm-{{ $g->id }}">
                                    @csrf @method('PATCH')
                                    <button type="button"
                                        class="btn btn-sm {{ $g->is_active ? 'btn-toggle-on' : 'btn-toggle-off' }}"
                                        onclick="confirmToggle(document.getElementById('toggleForm-{{ $g->id }}'), '{{ addslashes($g->nama_gedung) }}', {{ $g->is_active ? 'true' : 'false' }})">
                                        {{ $g->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.gedung.destroy', $g->id) }}" method="POST" id="deleteForm-{{ $g->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('deleteForm-{{ $g->id }}'), '{{ addslashes($g->nama_gedung) }}', {{ $g->ruang_count }})">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                </div>
                                <p class="empty-title">Gedung tidak ditemukan</p>
                                <p class="empty-sub">Coba ubah kata kunci pencarian atau reset filter</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($gedung->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $gedung->firstItem() }} – {{ $gedung->lastItem() }} dari {{ $gedung->total() }} gedung</p>
            <div class="pag-btns">
                @if($gedung->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $gedung->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($gedung->getUrlRange(1, $gedung->lastPage()) as $page => $url)
                    @if($page == $gedung->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $gedung->lastPage() || abs($page - $gedung->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $gedung->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($gedung->hasMorePages())
                    <a href="{{ $gedung->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Import Modal --}}
<div id="importModal" class="modal-backdrop" style="display:none" onclick="if(event.target===this)this.style.display='none'">
    <div class="modal-box">
        <div class="modal-header">
            <span class="modal-title">Import Data Gedung</span>
            <button class="modal-close" onclick="document.getElementById('importModal').style.display='none'">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.gedung.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="field">
                    <label>File Excel / CSV <span style="color:#1f63db">*</span></label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required>
                    <span class="field-hint">Format: .xlsx, .xls, atau .csv. Maksimal 2 MB.</span>
                </div>
                <div class="field-hint" style="margin-top:4px">
                    Belum punya template?
                    <a href="{{ route('admin.gedung.import.template') }}" style="color:var(--brand-600);font-weight:600;text-decoration:none">Download template</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel-modal" onclick="document.getElementById('importModal').style.display='none'">Batal</button>
                <button type="submit" class="btn btn-success">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Import Sekarang
                </button>
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

    function confirmDelete(form, nama, ruangCount) {
        if (ruangCount > 0) {
            Swal.fire({
                icon:'error', title:'Tidak Dapat Dihapus',
                html:`Gedung <strong>${nama}</strong> masih memiliki <strong>${ruangCount} ruangan</strong>. Hapus semua ruangan terlebih dahulu.`,
                confirmButtonColor:'#1f63db',
            });
            return;
        }
        Swal.fire({
            title:'Hapus Gedung?',
            html:`Gedung <strong>${nama}</strong> akan dihapus permanen.`,
            icon:'warning', showCancelButton:true,
            confirmButtonColor:'#dc2626', cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }

    function confirmToggle(form, nama, isActive) {
        Swal.fire({
            title:`${isActive ? 'Nonaktifkan' : 'Aktifkan'} Gedung?`,
            html:`Gedung <strong>${nama}</strong> akan di${isActive ? 'nonaktifkan' : 'aktifkan'}.`,
            icon:'question', showCancelButton:true,
            confirmButtonColor:'#1f63db', cancelButtonColor:'#64748b',
            confirmButtonText:`Ya, ${isActive ? 'Nonaktifkan' : 'Aktifkan'}!`, cancelButtonText:'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>