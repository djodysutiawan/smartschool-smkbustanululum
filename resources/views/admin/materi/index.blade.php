<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700: #1750c0; --brand-600: #1f63db; --brand-500: #3582f0;
        --brand-100: #d9ebff; --brand-50: #eef6ff;
        --surface: #fff; --surface2: #f8fafc; --surface3: #f1f5f9;
        --border: #e2e8f0; --border2: #cbd5e1;
        --text: #0f172a; --text2: #475569; --text3: #94a3b8;
        --radius: 10px; --radius-sm: 7px;
    }
    .page { padding: 28px 28px 40px; }
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2; }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s; white-space: nowrap; }
    .btn-primary { background: var(--brand-600); color: #fff; }
    .btn-primary:hover { filter: brightness(.93); }
    .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 6px; }
    .btn-detail    { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .btn-detail:hover    { background: #dcfce7; }
    .btn-edit      { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover      { background: var(--brand-100); }
    .btn-del       { background: #fff0f0; color: #dc2626; border: 1px solid #fecaca; }
    .btn-del:hover       { background: #fee2e2; }
    .btn-restore   { background: #fefce8; color: #a16207; border: 1px solid #fde68a; }
    .btn-restore:hover   { background: #fef9c3; }
    .btn-publish   { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .btn-publish:hover   { background: #dcfce7; }
    .btn-unpublish { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }
    .btn-unpublish:hover { background: #ffedd5; }
    .btn-pdf    { background: #fff0f0; color: #dc2626; border: 1px solid #fecaca; }
    .btn-pdf:hover    { background: #fee2e2; }
    .btn-excel  { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .btn-excel:hover  { background: #dcfce7; }
    .btn-import { background: #fefce8; color: #a16207; border: 1px solid #fde68a; }
    .btn-import:hover { background: #fef9c3; }

    .stats-strip { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px 18px; display: flex; align-items: center; gap: 12px; }
    .stat-icon { width: 38px; height: 38px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .stat-icon.blue   { background: var(--brand-50); }
    .stat-icon.green  { background: #f0fdf4; }
    .stat-icon.orange { background: #fff7ed; }
    .stat-icon.yellow { background: #fefce8; }
    .stat-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 600; color: var(--text3); letter-spacing: .03em; text-transform: uppercase; }
    .stat-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: var(--text); line-height: 1.1; margin-top: 1px; }

    .filter-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 16px 20px; margin-bottom: 16px; }
    .filter-row  { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
    .filter-row input, .filter-row select { height: 36px; padding: 0 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text); background: var(--surface2); outline: none; transition: border-color .15s; }
    .filter-row input { width: 200px; }
    .filter-row input:focus, .filter-row select:focus { border-color: var(--brand-500); background: #fff; }
    .filter-row input::placeholder { color: var(--text3); }
    .filter-sep { flex: 1; }
    .btn-filter { height: 36px; padding: 0 18px; background: var(--brand-600); color: #fff; border: none; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; }
    .btn-filter:hover { background: var(--brand-700); }
    .btn-reset  { height: 36px; padding: 0 14px; background: var(--surface2); color: var(--text2); border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; }
    .btn-reset:hover { background: var(--surface3); }

    .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .table-topbar { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 10px; }
    .table-info { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .table-info span { font-weight: 400; color: var(--text3); margin-left: 6px; }
    .table-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
    .table-wrap { overflow-x: auto; }

    table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    thead tr { background: var(--surface2); border-bottom: 1px solid var(--border); }
    thead th { padding: 11px 14px; text-align: left; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); letter-spacing: .05em; text-transform: uppercase; white-space: nowrap; }
    thead th.center { text-align: center; }
    tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .1s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fafbff; }
    tbody tr.is-trashed { opacity: .65; background: #fffbf0; }
    td { padding: 10px 14px; color: var(--text); vertical-align: middle; }
    td.center { text-align: center; }
    td.muted { color: var(--text3); }
    .no-col { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text3); }

    .thumbnail-wrap { width: 44px; height: 44px; border-radius: 8px; overflow: hidden; border: 1px solid var(--border); background: var(--surface2); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .thumbnail-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .materi-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 13.5px; color: var(--text); }
    .materi-meta  { font-size: 12px; color: var(--text3); margin-top: 2px; }

    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; white-space: nowrap; }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-pub      { background: #dcfce7; color: #15803d; } .badge-pub .badge-dot      { background: #15803d; }
    .badge-draft    { background: #f1f5f9;  color: var(--text3); } .badge-draft .badge-dot    { background: var(--text3); }
    .badge-terhapus { background: #fef9c3; color: #a16207;  } .badge-terhapus .badge-dot { background: #a16207; }

    .jenis-pill { display: inline-block; padding: 2px 9px; border-radius: 5px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; }
    .jenis-file  { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .jenis-video { background: #fdf4ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .jenis-link  { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .jenis-teks  { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }

    .action-group { display: flex; align-items: center; gap: 5px; justify-content: center; flex-wrap: wrap; }

    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-icon  { width: 56px; height: 56px; background: var(--surface2); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
    .empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 15px; color: var(--text); margin-bottom: 5px; }
    .empty-sub   { font-size: 13px; color: var(--text3); }

    .pag-wrap { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-top: 1px solid var(--border); flex-wrap: wrap; gap: 10px; }
    .pag-info { font-size: 12.5px; color: var(--text3); }
    .pag-btns { display: flex; gap: 4px; align-items: center; }
    .pag-btn  { height: 32px; min-width: 32px; padding: 0 8px; border-radius: 7px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border); background: var(--surface); color: var(--text2); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; cursor: pointer; transition: all .15s; text-decoration: none; }
    .pag-btn:hover  { background: var(--surface2); border-color: var(--border2); }
    .pag-btn.active { background: var(--brand-600); border-color: var(--brand-600); color: #fff; }
    .pag-ellipsis   { color: var(--text3); font-size: 13px; padding: 0 4px; }

    .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 999; display: none; align-items: center; justify-content: center; }
    .modal-overlay.open { display: flex; }
    .modal-box { background: #fff; border-radius: 12px; padding: 28px; width: 420px; max-width: 95vw; box-shadow: 0 20px 60px rgba(0,0,0,.18); }
    .modal-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-weight: 800; color: var(--text); margin-bottom: 6px; }
    .modal-sub   { font-size: 13px; color: var(--text3); margin-bottom: 20px; }
    .modal-field { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
    .modal-field label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2); }
    .modal-field input[type=file] { border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 8px 12px; font-size: 13px; background: var(--surface2); width: 100%; }
    .modal-footer { display: flex; justify-content: flex-end; gap: 8px; margin-top: 20px; }
    .btn-cancel { background: var(--surface); color: var(--text2); border: 1px solid var(--border); }
    .btn-cancel:hover { background: var(--surface3); }

    @media (max-width: 640px) { .stats-strip { grid-template-columns: 1fr 1fr; } .page { padding: 16px; } }
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Materi Pelajaran</h1>
            <p class="page-sub">Kelola materi pembelajaran — unggah, publikasikan, dan hapus</p>
        </div>
        <a href="{{ route('admin.materi.create') }}" class="btn btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Materi
        </a>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            </div>
            <div><p class="stat-label">Total Materi</p><p class="stat-val">{{ $materi->total() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 8 12 12 14 14"/></svg>
            </div>
            <div><p class="stat-label">Dipublikasikan</p><p class="stat-val">{{ \App\Models\Materi::where('dipublikasikan', true)->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div><p class="stat-label">Draft</p><p class="stat-val">{{ \App\Models\Materi::where('dipublikasikan', false)->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
            </div>
            <div><p class="stat-label">Terhapus</p><p class="stat-val">{{ \App\Models\Materi::onlyTrashed()->count() }}</p></div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.materi.index') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul materi...">
                <select name="guru_id">
                    <option value="">Semua Guru</option>
                    @foreach($guruList as $g)
                        <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                    @endforeach
                </select>
                <select name="kelas_id">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <select name="mata_pelajaran_id">
                    <option value="">Semua Mapel</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id }}" {{ request('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>
                <select name="dipublikasikan">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('dipublikasikan') === '1' ? 'selected' : '' }}>Dipublikasikan</option>
                    <option value="0" {{ request('dipublikasikan') === '0' ? 'selected' : '' }}>Draft</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.materi.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Materi
                <span>— menampilkan {{ $materi->firstItem() ?? 0 }}–{{ $materi->lastItem() ?? 0 }} dari {{ $materi->total() }} data</span>
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.materi.export.pdf', request()->query()) }}" class="btn btn-sm btn-pdf">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    PDF
                </a>
                <a href="{{ route('admin.materi.export.excel', request()->query()) }}" class="btn btn-sm btn-excel">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                    Excel
                </a>
                <button type="button" class="btn btn-sm btn-import" onclick="document.getElementById('importModal').classList.add('open')">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                    Import
                </button>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th style="width:52px">Thumb</th>
                        <th>Judul / Guru</th>
                        <th>Kelas & Mapel</th>
                        <th>Jenis</th>
                        <th class="center">Urutan</th>
                        <th>Status</th>
                        <th class="center" style="width:240px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materi as $index => $m)
                    <tr class="{{ $m->trashed() ? 'is-trashed' : '' }}">
                        <td><span class="no-col">{{ $materi->firstItem() + $index }}</span></td>
                        <td>
                            <div class="thumbnail-wrap">
                                @if($m->thumbnail)
                                    <img src="{{ asset('storage/'.$m->thumbnail) }}" alt="">
                                @else
                                    <svg width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="materi-title">{{ Str::limit($m->judul, 45) }}</div>
                            <div class="materi-meta">{{ $m->guru->nama_lengkap ?? '-' }}</div>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:600;color:var(--text)">{{ $m->kelas->nama_kelas ?? '-' }}</div>
                            <div style="font-size:12px;color:var(--text3)">{{ $m->mataPelajaran->nama_mapel ?? '-' }}</div>
                        </td>
                        <td><span class="jenis-pill jenis-{{ $m->jenis }}">{{ ucfirst($m->jenis) }}</span></td>
                        <td class="center" style="font-size:13px;font-weight:700;color:var(--text3)">{{ $m->urutan ?? '—' }}</td>
                        <td>
                            @if($m->trashed())
                                <span class="badge badge-terhapus"><span class="badge-dot"></span>Terhapus</span>
                            @elseif($m->dipublikasikan)
                                <span class="badge badge-pub"><span class="badge-dot"></span>Publikasi</span>
                            @else
                                <span class="badge badge-draft"><span class="badge-dot"></span>Draft</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-group">
                                @if($m->trashed())
                                    <form action="{{ route('admin.materi.restore', $m->id) }}" method="POST" id="restoreForm-{{ $m->id }}">
                                        @csrf
                                        <button type="button" class="btn btn-sm btn-restore"
                                            onclick="confirmRestore(document.getElementById('restoreForm-{{ $m->id }}'), '{{ addslashes($m->judul) }}')">
                                            Pulihkan
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('admin.materi.show', $m->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                    <a href="{{ route('admin.materi.edit', $m->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                    <form action="{{ route('admin.materi.toggle-publish', $m->id) }}" method="POST" id="pubForm-{{ $m->id }}">
                                        @csrf @method('PATCH')
                                        @if($m->dipublikasikan)
                                            <button type="button" class="btn btn-sm btn-unpublish"
                                                onclick="confirmUnpublish(document.getElementById('pubForm-{{ $m->id }}'), '{{ addslashes($m->judul) }}')">Draft</button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-publish"
                                                onclick="confirmPublish(document.getElementById('pubForm-{{ $m->id }}'), '{{ addslashes($m->judul) }}')">Publish</button>
                                        @endif
                                    </form>
                                    <form action="{{ route('admin.materi.destroy', $m->id) }}" method="POST" id="delForm-{{ $m->id }}">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-del"
                                            onclick="confirmDelete(document.getElementById('delForm-{{ $m->id }}'), '{{ addslashes($m->judul) }}')">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                </div>
                                <p class="empty-title">Materi tidak ditemukan</p>
                                <p class="empty-sub">Coba ubah filter atau tambah materi baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($materi->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $materi->firstItem() }} – {{ $materi->lastItem() }} dari {{ $materi->total() }} materi</p>
            <div class="pag-btns">
                @if($materi->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $materi->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($materi->getUrlRange(1, $materi->lastPage()) as $page => $url)
                    @if($page == $materi->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $materi->lastPage() || abs($page - $materi->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $materi->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($materi->hasMorePages())
                    <a href="{{ $materi->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Import Modal --}}
<div class="modal-overlay" id="importModal">
    <div class="modal-box">
        <p class="modal-title">Import Data Materi</p>
        <p class="modal-sub">Upload file Excel (.xlsx / .xls). <a href="{{ route('admin.materi.import.template') }}" style="color:var(--brand-600);font-weight:600">Download template</a> terlebih dahulu.</p>
        <form action="{{ route('admin.materi.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-field">
                <label>File Excel <span style="color:#dc2626">*</span></label>
                <input type="file" name="file" accept=".xlsx,.xls" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" onclick="document.getElementById('importModal').classList.remove('open')">Batal</button>
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

    function confirmDelete(form, judul) {
        Swal.fire({ title:'Hapus Materi?', text:`"${judul}" akan dihapus (bisa dipulihkan).`, icon:'warning', showCancelButton:true, confirmButtonColor:'#dc2626', cancelButtonColor:'#64748b', confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal' })
        .then(r => { if (r.isConfirmed) form.submit(); });
    }
    function confirmRestore(form, judul) {
        Swal.fire({ title:'Pulihkan Materi?', text:`"${judul}" akan dipulihkan kembali.`, icon:'question', showCancelButton:true, confirmButtonColor:'#1f63db', cancelButtonColor:'#64748b', confirmButtonText:'Ya, Pulihkan!', cancelButtonText:'Batal' })
        .then(r => { if (r.isConfirmed) form.submit(); });
    }
    function confirmPublish(form, judul) {
        Swal.fire({ title:'Publikasikan Materi?', text:`"${judul}" akan dapat diakses siswa.`, icon:'question', showCancelButton:true, confirmButtonColor:'#15803d', cancelButtonColor:'#64748b', confirmButtonText:'Ya, Publikasikan!', cancelButtonText:'Batal' })
        .then(r => { if (r.isConfirmed) form.submit(); });
    }
    function confirmUnpublish(form, judul) {
        Swal.fire({ title:'Sembunyikan Materi?', text:`"${judul}" akan dikembalikan ke draft.`, icon:'warning', showCancelButton:true, confirmButtonColor:'#c2410c', cancelButtonColor:'#64748b', confirmButtonText:'Ya, Sembunyikan!', cancelButtonText:'Batal' })
        .then(r => { if (r.isConfirmed) form.submit(); });
    }
    document.getElementById('importModal').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });
</script>
</x-app-layout>