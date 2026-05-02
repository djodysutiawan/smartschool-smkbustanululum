<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand-700: #1750c0;
        --brand-600: #1f63db;
        --brand-500: #3582f0;
        --brand-100: #d9ebff;
        --brand-50:  #eef6ff;
        --surface:   #fff;
        --surface2:  #f8fafc;
        --surface3:  #f1f5f9;
        --border:    #e2e8f0;
        --border2:   #cbd5e1;
        --text:      #0f172a;
        --text2:     #475569;
        --text3:     #94a3b8;
        --radius:    10px;
        --radius-sm: 7px;
    }

    .page { padding: 28px 28px 40px; }

    .page-header {
        display: flex; align-items: flex-start;
        justify-content: space-between; gap: 16px;
        margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2;
    }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .header-actions { display: flex; gap: 8px; flex-wrap: wrap; }

    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: filter .15s; white-space: nowrap;
    }
    .btn:hover { filter: brightness(.93); }
    .btn-primary { background: var(--brand-600); color: #fff; }
    .btn-sm      { padding: 6px 12px; font-size: 12px; border-radius: 6px; }
    .btn-edit    { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover { background: var(--brand-100); filter: none; }
    .btn-del     { background: #fff0f0; color: #dc2626; border: 1px solid #fecaca; }
    .btn-del:hover { background: #fee2e2; filter: none; }
    .btn-detail  { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .btn-detail:hover { background: #dcfce7; filter: none; }
    .btn-warn    { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }
    .btn-warn:hover { background: #ffedd5; filter: none; }
    .btn-ghost   { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); filter: none; }

    .stats-strip {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 12px; margin-bottom: 20px;
    }
    .stat-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 14px 18px;
        display: flex; align-items: center; gap: 12px;
    }
    .stat-icon {
        width: 38px; height: 38px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .stat-icon.blue   { background: var(--brand-50); }
    .stat-icon.green  { background: #f0fdf4; }
    .stat-icon.yellow { background: #fefce8; }
    .stat-icon.purple { background: #fdf4ff; }
    .stat-label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px;
        font-weight: 600; color: var(--text3);
        letter-spacing: .03em; text-transform: uppercase;
    }
    .stat-val {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px;
        font-weight: 800; color: var(--text); line-height: 1.1; margin-top: 1px;
    }

    .filter-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 16px 20px; margin-bottom: 16px;
    }
    .filter-row { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
    .filter-row input,
    .filter-row select {
        height: 36px; padding: 0 12px;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif; font-size: 13px;
        color: var(--text); background: var(--surface2); outline: none;
        transition: border-color .15s;
    }
    .filter-row input  { width: 210px; }
    .filter-row input:focus,
    .filter-row select:focus { border-color: var(--brand-500); background: #fff; }
    .filter-row input::placeholder { color: var(--text3); }
    .filter-sep { flex: 1; }
    .btn-filter {
        height: 36px; padding: 0 18px;
        background: var(--brand-600); color: #fff; border: none;
        border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px; font-weight: 700; cursor: pointer;
    }
    .btn-filter:hover { background: var(--brand-700); }
    .btn-reset {
        height: 36px; padding: 0 14px;
        background: var(--surface2); color: var(--text2);
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px; font-weight: 600; cursor: pointer;
        text-decoration: none; display: inline-flex; align-items: center;
    }
    .btn-reset:hover { background: var(--surface3); }

    .table-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
    }
    .table-topbar {
        display: flex; align-items: center; justify-content: space-between;
        padding: 14px 20px; border-bottom: 1px solid var(--border);
        flex-wrap: wrap; gap: 8px;
    }
    .table-info {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px; font-weight: 700; color: var(--text);
    }
    .table-info span { font-weight: 400; color: var(--text3); margin-left: 6px; }
    .table-wrap { overflow-x: auto; }

    table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    thead tr { background: var(--surface2); border-bottom: 1px solid var(--border); }
    thead th {
        padding: 11px 14px; text-align: left;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11.5px; font-weight: 700; color: var(--text3);
        letter-spacing: .05em; text-transform: uppercase; white-space: nowrap;
    }
    thead th.center { text-align: center; }
    tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .1s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fafbff; }
    td { padding: 10px 14px; color: var(--text); vertical-align: middle; }
    td.center { text-align: center; }
    td.muted { color: var(--text3); }

    .no-col {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px; font-weight: 700; color: var(--text3);
    }

    .thumb-wrap {
        width: 52px; height: 38px; border-radius: 6px; overflow: hidden;
        border: 1px solid var(--border); background: var(--surface2);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .thumb-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .thumb-placeholder {
        color: var(--text3);
    }

    .berita-wrap .bjudul {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700; font-size: 13.5px; color: var(--text);
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .berita-wrap .bslug { font-size: 11.5px; color: var(--text3); margin-top: 2px; }

    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11.5px; font-weight: 700; white-space: nowrap;
    }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-published { background: #dcfce7; color: #15803d; }
    .badge-published .badge-dot { background: #15803d; }
    .badge-draft     { background: #f1f5f9; color: #475569; }
    .badge-draft     .badge-dot { background: #94a3b8; }
    .badge-featured  { background: #fefce8; color: #a16207; }

    .kategori-pill {
        display: inline-block; padding: 2px 9px;
        border-radius: 5px; font-size: 12px; font-weight: 700;
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100);
    }

    .action-group {
        display: flex; align-items: center;
        gap: 5px; justify-content: center; flex-wrap: wrap;
    }

    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-icon {
        width: 56px; height: 56px; background: var(--surface2);
        border-radius: 14px; display: flex; align-items: center;
        justify-content: center; margin: 0 auto 14px;
    }
    .empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 15px; color: var(--text); margin-bottom: 5px; }
    .empty-sub { font-size: 13px; color: var(--text3); }

    .pag-wrap {
        display: flex; align-items: center; justify-content: space-between;
        padding: 14px 20px; border-top: 1px solid var(--border);
        flex-wrap: wrap; gap: 10px;
    }
    .pag-info { font-size: 12.5px; color: var(--text3); }
    .pag-btns { display: flex; gap: 4px; align-items: center; }
    .pag-btn {
        height: 32px; min-width: 32px; padding: 0 8px;
        border-radius: 7px; display: flex; align-items: center; justify-content: center;
        border: 1px solid var(--border); background: var(--surface);
        color: var(--text2); font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px; font-weight: 700; cursor: pointer;
        transition: all .15s; text-decoration: none;
    }
    .pag-btn:hover  { background: var(--surface2); border-color: var(--border2); }
    .pag-btn.active { background: var(--brand-600); border-color: var(--brand-600); color: #fff; }
    .pag-ellipsis   { color: var(--text3); font-size: 13px; padding: 0 4px; }

    @media (max-width: 640px) {
        .stats-strip { grid-template-columns: 1fr 1fr; }
        .page { padding: 16px; }
        .filter-row input { width: 100%; }
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Berita</h1>
            <p class="page-sub">Kelola artikel dan berita publik — tulis, publish, dan atur konten</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tulis Berita
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 0-2 2zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8M15 18h-5M10 6h8v4h-8z"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Berita</p>
                <p class="stat-val">{{ $berita->total() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Published</p>
                <p class="stat-val">{{ $berita->getCollection()->where('status','published')->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            </div>
            <div>
                <p class="stat-label">Draft</p>
                <p class="stat-val">{{ $berita->getCollection()->where('status','draft')->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div>
                <p class="stat-label">Unggulan</p>
                <p class="stat-val">{{ $berita->getCollection()->where('is_featured', true)->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.berita.index') }}">
            <div class="filter-row">
                <input type="text" name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari judul berita...">

                <select name="kategori_id">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>

                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft"     {{ request('status') == 'draft'     ? 'selected' : '' }}>Draft</option>
                </select>

                <div class="filter-sep"></div>

                <a href="{{ route('admin.berita.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Berita
                <span>— menampilkan {{ $berita->firstItem() }}–{{ $berita->lastItem() }} dari {{ $berita->total() }} data</span>
            </p>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th style="width:60px">Thumb</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th class="center" style="width:220px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($berita as $index => $b)
                    <tr>
                        <td><span class="no-col">{{ $berita->firstItem() + $index }}</span></td>

                        <td>
                            <div class="thumb-wrap">
                                @if($b->thumbnail_path)
                                    <img src="{{ asset('storage/'.$b->thumbnail_path) }}" alt="{{ $b->judul }}">
                                @elseif($b->thumbnail_url)
                                    <img src="{{ $b->thumbnail_url }}" alt="{{ $b->judul }}">
                                @else
                                    <svg class="thumb-placeholder" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                @endif
                            </div>
                        </td>

                        <td style="max-width:260px">
                            <div class="berita-wrap">
                                <p class="bjudul">{{ $b->judul }}</p>
                                <p class="bslug">/{{ $b->slug }}</p>
                            </div>
                        </td>

                        <td>
                            @if($b->kategori)
                                <span class="kategori-pill">{{ $b->kategori->nama }}</span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>

                        <td>
                            <div style="display:flex;gap:5px;flex-wrap:wrap;align-items:center">
                                @if($b->status === 'published')
                                    <span class="badge badge-published">
                                        <span class="badge-dot"></span>Published
                                    </span>
                                @else
                                    <span class="badge badge-draft">
                                        <span class="badge-dot"></span>Draft
                                    </span>
                                @endif
                                @if($b->is_featured)
                                    <span class="badge badge-featured">★ Unggulan</span>
                                @endif
                            </div>
                        </td>

                        <td class="muted" style="font-size:12.5px;white-space:nowrap">
                            {{ $b->published_at ? $b->published_at->format('d M Y') : $b->created_at->format('d M Y') }}
                        </td>

                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.berita.show', $b->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('admin.berita.edit', $b->id) }}" class="btn btn-sm btn-edit">Edit</a>

                                @if($b->status === 'draft')
                                    <form action="{{ route('admin.berita.publish', $b->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button class="btn btn-sm btn-ghost" type="submit">Publish</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.berita.unpublish', $b->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button class="btn btn-sm btn-warn" type="submit">Unpublish</button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.berita.destroy', $b->id) }}" method="POST" id="delForm-{{ $b->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delForm-{{ $b->id }}'), '{{ addslashes($b->judul) }}')">
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
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 0-2 2zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/></svg>
                                </div>
                                <p class="empty-title">Belum ada berita</p>
                                <p class="empty-sub">Mulai tulis berita pertama Anda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($berita->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $berita->firstItem() }} – {{ $berita->lastItem() }} dari {{ $berita->total() }} berita</p>
            <div class="pag-btns">
                @if($berita->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $berita->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                @foreach($berita->getUrlRange(1, $berita->lastPage()) as $page => $url)
                    @if($page == $berita->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $berita->lastPage() || abs($page - $berita->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $berita->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                @if($berita->hasMorePages())
                    <a href="{{ $berita->nextPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </span>
                @endif
            </div>
        </div>
        @endif
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
    @if(session('info'))
    Swal.fire({ icon:'info', title:'Info', text:@json(session('info')), confirmButtonColor:'#1f63db' });
    @endif

    function confirmDelete(form, judul) {
        Swal.fire({
            title: 'Hapus Berita?',
            text: `"${judul}" akan dihapus.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>