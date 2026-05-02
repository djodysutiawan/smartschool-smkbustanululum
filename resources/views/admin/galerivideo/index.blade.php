<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --red:#dc2626;--red-bg:#fff0f0;--red-border:#fecaca;
        --green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;
        --amber:#a16207;--amber-bg:#fefce8;--amber-border:#fde68a;
        --radius:10px;--radius-sm:7px;
    }
    .page { padding:28px 28px 40px; }
    .page-header { display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap; }
    .page-title { font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2; }
    .page-sub { font-size:12.5px;color:var(--text3);margin-top:3px; }
    .header-actions { display:flex;gap:8px;flex-wrap:wrap; }

    .btn { display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap; }
    .btn:hover { filter:brightness(.93); }
    .btn-primary { background:var(--brand-600);color:#fff; }
    .btn-ghost   { background:var(--surface2);color:var(--text2);border:1px solid var(--border); }
    .btn-ghost:hover { background:var(--surface3);filter:none; }
    .btn-sm      { padding:6px 12px;font-size:12px;border-radius:6px; }
    .btn-edit    { background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100); }
    .btn-edit:hover { background:var(--brand-100);filter:none; }
    .btn-del     { background:var(--red-bg);color:var(--red);border:1px solid var(--red-border); }
    .btn-del:hover { background:#fee2e2;filter:none; }
    .btn-on      { background:var(--green-bg);color:var(--green);border:1px solid var(--green-border); }
    .btn-on:hover { background:#dcfce7;filter:none; }
    .btn-off     { background:var(--amber-bg);color:var(--amber);border:1px solid var(--amber-border); }
    .btn-off:hover { background:#fef9c3;filter:none; }
    .btn-purple  { background:#fdf4ff;color:#7c3aed;border:1px solid #e9d5ff; }
    .btn-purple:hover { background:#f3e8ff;filter:none; }

    .stats-strip { display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px; }
    .stat-card { background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px; }
    .stat-icon { width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
    .stat-icon.blue   { background:var(--brand-50); }
    .stat-icon.green  { background:var(--green-bg); }
    .stat-icon.red    { background:#fff0f0; }
    .stat-icon.purple { background:#fdf4ff; }
    .stat-label { font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase; }
    .stat-val   { font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px; }

    .filter-card { background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px; }
    .filter-row { display:flex;flex-wrap:wrap;gap:10px;align-items:center; }
    .filter-row input,.filter-row select { height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s; }
    .filter-row input { width:200px; }
    .filter-row input:focus,.filter-row select:focus { border-color:var(--brand-500);background:#fff; }
    .filter-row input::placeholder { color:var(--text3); }
    .filter-sep { flex:1; }
    .btn-filter { height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer; }
    .btn-filter:hover { background:var(--brand-700); }
    .btn-reset { height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center; }
    .btn-reset:hover { background:var(--surface3); }

    .table-card { background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden; }
    .table-topbar { display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:8px; }
    .table-info { font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text); }
    .table-info span { font-weight:400;color:var(--text3);margin-left:6px; }
    .table-wrap { overflow-x:auto; }
    table { width:100%;border-collapse:collapse;font-size:13.5px; }
    thead tr { background:var(--surface2);border-bottom:1px solid var(--border); }
    thead th { padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap; }
    thead th.center { text-align:center; }
    tbody tr { border-bottom:1px solid #f1f5f9;transition:background .1s; }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:#fafbff; }
    td { padding:10px 14px;color:var(--text);vertical-align:middle; }
    td.center { text-align:center; }
    td.muted { color:var(--text3); }
    .no-col { font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3); }

    .thumb-wrap { width:64px;height:42px;border-radius:6px;overflow:hidden;border:1px solid var(--border);background:#000;display:flex;align-items:center;justify-content:center;flex-shrink:0;position:relative; }
    .thumb-wrap img { width:100%;height:100%;object-fit:cover;opacity:.9; }
    .play-icon { position:absolute;width:20px;height:20px;background:rgba(0,0,0,.55);border-radius:50%;display:flex;align-items:center;justify-content:center; }

    .video-wrap .vjudul { font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text);display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden; }
    .video-wrap .vmeta  { font-size:11.5px;color:var(--text3);margin-top:2px;display:flex;align-items:center;gap:6px; }

    .badge { display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap; }
    .badge-dot { width:5px;height:5px;border-radius:50%; }
    .badge-published { background:var(--green-bg);color:var(--green); } .badge-published .badge-dot { background:var(--green); }
    .badge-draft     { background:var(--surface3);color:var(--text3); } .badge-draft .badge-dot     { background:var(--text3); }
    .badge-featured  { background:var(--amber-bg);color:var(--amber); }

    .sumber-pill { display:inline-block;padding:2px 9px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700; }
    .sumber-youtube { background:#fff0f0;color:#dc2626;border:1px solid #fecaca; }
    .sumber-vimeo   { background:#fdf4ff;color:#7c3aed;border:1px solid #e9d5ff; }
    .sumber-upload  { background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100); }

    .kat-pill { display:inline-block;padding:2px 9px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;background:var(--surface2);color:var(--text2);border:1px solid var(--border); }

    .action-group { display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap; }
    .empty-state { padding:60px 20px;text-align:center; }
    .empty-icon { width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px; }
    .empty-title { font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px; }
    .empty-sub { font-size:13px;color:var(--text3); }

    .pag-wrap { display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px; }
    .pag-info { font-size:12.5px;color:var(--text3); }
    .pag-btns { display:flex;gap:4px;align-items:center; }
    .pag-btn { height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none; }
    .pag-btn:hover { background:var(--surface2);border-color:var(--border2); }
    .pag-btn.active { background:var(--brand-600);border-color:var(--brand-600);color:#fff; }
    .pag-ellipsis { color:var(--text3);font-size:13px;padding:0 4px; }
    @media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr;}.page{padding:16px;}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Galeri Video</h1>
            <p class="page-sub">Kelola video galeri sekolah — YouTube, Vimeo, atau upload langsung</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.galeri.video.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Video
            </a>
        </div>
    </div>

    {{-- Stats --}}
    @php
        $totalVideo   = \App\Models\GaleriVideo::count();
        $published    = \App\Models\GaleriVideo::where('is_published', true)->count();
        $featured     = \App\Models\GaleriVideo::where('is_featured', true)->count();
        $youtubeCount = \App\Models\GaleriVideo::where('tipe_sumber', 'youtube')->count();
    @endphp
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
            </div>
            <div><p class="stat-label">Total Video</p><p class="stat-val">{{ $totalVideo }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Published</p><p class="stat-val">{{ $published }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.54C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>
            </div>
            <div><p class="stat-label">YouTube</p><p class="stat-val">{{ $youtubeCount }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div><p class="stat-label">Unggulan</p><p class="stat-val">{{ $featured }}</p></div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.galeri.video.index') }}">
            <div class="filter-row">
                <select name="kategori_id">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
                <select name="tipe_sumber">
                    <option value="">Semua Sumber</option>
                    <option value="youtube" {{ request('tipe_sumber') === 'youtube' ? 'selected' : '' }}>YouTube</option>
                    <option value="vimeo"   {{ request('tipe_sumber') === 'vimeo'   ? 'selected' : '' }}>Vimeo</option>
                    <option value="upload"  {{ request('tipe_sumber') === 'upload'  ? 'selected' : '' }}>Upload</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.galeri.video.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Video
                <span>— {{ $video->firstItem() }}–{{ $video->lastItem() }} dari {{ $video->total() }} data</span>
            </p>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th style="width:72px">Thumb</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th class="center">Sumber</th>
                        <th class="center">Status</th>
                        <th class="center" style="width:230px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($video as $i => $v)
                    <tr>
                        <td><span class="no-col">{{ $video->firstItem() + $i }}</span></td>
                        <td>
                            <div class="thumb-wrap">
                                @if($v->thumbnail_path)
                                    <img src="{{ asset('storage/'.$v->thumbnail_path) }}" alt="{{ $v->judul }}">
                                @elseif($v->thumbnail_url)
                                    <img src="{{ $v->thumbnail_url }}" alt="{{ $v->judul }}">
                                @else
                                    <svg width="18" height="18" fill="none" stroke="#475569" stroke-width="1.5" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                                @endif
                                <div class="play-icon">
                                    <svg width="8" height="8" fill="#fff" viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                </div>
                            </div>
                        </td>
                        <td style="max-width:250px">
                            <div class="video-wrap">
                                <p class="vjudul">{{ $v->judul }}</p>
                                <div class="vmeta">
                                    @if($v->durasi)<span>{{ $v->durasi }}</span>@endif
                                    @if($v->tanggal_video)<span>· {{ \Carbon\Carbon::parse($v->tanggal_video)->format('d M Y') }}</span>@endif
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($v->kategori)
                                <span class="kat-pill">{{ $v->kategori->nama }}</span>
                            @else<span class="muted">—</span>@endif
                        </td>
                        <td class="center">
                            <span class="sumber-pill sumber-{{ $v->tipe_sumber }}">{{ ucfirst($v->tipe_sumber) }}</span>
                        </td>
                        <td class="center">
                            <div style="display:flex;gap:5px;flex-wrap:wrap;align-items:center;justify-content:center">
                                @if($v->is_published)
                                    <span class="badge badge-published"><span class="badge-dot"></span>Published</span>
                                @else
                                    <span class="badge badge-draft"><span class="badge-dot"></span>Draft</span>
                                @endif
                                @if($v->is_featured)
                                    <span class="badge badge-featured">★ Unggulan</span>
                                @endif
                            </div>
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <form action="{{ route('admin.galeri.video.toggle', $v->id) }}" method="POST" style="display:contents">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm {{ $v->is_published ? 'btn-off' : 'btn-on' }}" type="submit">
                                        {{ $v->is_published ? 'Unpublish' : 'Publish' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.galeri.video.featured', $v->id) }}" method="POST" style="display:contents">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-purple" type="submit" title="{{ $v->is_featured ? 'Hapus unggulan' : 'Jadikan unggulan' }}">
                                        {{ $v->is_featured ? '★' : '☆' }}
                                    </button>
                                </form>
                                <a href="{{ route('admin.galeri.video.edit', $v->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                <button type="button" class="btn btn-sm btn-del"
                                    onclick="confirmDelete({{ $v->id }}, '{{ addslashes($v->judul) }}')">Hapus</button>
                                <form action="{{ route('admin.galeri.video.destroy', $v->id) }}" method="POST" id="del-{{ $v->id }}" style="display:none">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                            </div>
                            <p class="empty-title">Belum ada video</p>
                            <p class="empty-sub">Tambahkan video pertama ke galeri</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($video->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $video->firstItem() }}–{{ $video->lastItem() }} dari {{ $video->total() }} video</p>
            <div class="pag-btns">
                @if($video->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $video->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($video->getUrlRange(1,$video->lastPage()) as $page => $url)
                    @if($page == $video->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $video->lastPage() || abs($page - $video->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $video->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($video->hasMorePages())
                    <a href="{{ $video->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
    @endif
    @if(session('error'))
    Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
    @endif
    @if(session('info'))
    Swal.fire({icon:'info',title:'Info',text:@json(session('info')),confirmButtonColor:'#1f63db'});
    @endif

    function confirmDelete(id, judul) {
        Swal.fire({
            title:'Hapus Video?',
            text:`"${judul}" akan dihapus permanen.`,
            icon:'warning',showCancelButton:true,
            confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal',
        }).then(r => { if(r.isConfirmed) document.getElementById('del-'+id).submit(); });
    }
</script>
</x-app-layout>