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
        --radius:10px;--radius-sm:7px;--radius-lg:14px;
    }
    .page { padding:28px 28px 40px; }
    .page-header { display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap; }
    .page-title { font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2; }
    .page-sub { font-size:12.5px;color:var(--text3);margin-top:3px; }
    .header-actions { display:flex;gap:8px;flex-wrap:wrap; }

    .btn { display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap; }
    .btn:hover { filter:brightness(.93); }
    .btn-primary  { background:var(--brand-600);color:#fff; }
    .btn-sm       { padding:6px 12px;font-size:12px;border-radius:6px; }
    .btn-edit     { background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100); }
    .btn-edit:hover { background:var(--brand-100);filter:none; }
    .btn-del      { background:var(--red-bg);color:var(--red);border:1px solid var(--red-border); }
    .btn-del:hover { background:#fee2e2;filter:none; }
    .btn-on       { background:var(--green-bg);color:var(--green);border:1px solid var(--green-border); }
    .btn-on:hover { background:#dcfce7;filter:none; }
    .btn-off      { background:var(--amber-bg);color:var(--amber);border:1px solid var(--amber-border); }
    .btn-off:hover { background:#fef9c3;filter:none; }

    .stats-strip { display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px; }
    .stat-card { background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px; }
    .stat-icon { width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
    .stat-icon.blue   { background:var(--brand-50); }
    .stat-icon.green  { background:var(--green-bg); }
    .stat-icon.yellow { background:var(--amber-bg); }
    .stat-icon.purple { background:#fdf4ff; }
    .stat-label { font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase; }
    .stat-val   { font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px; }

    .filter-card { background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px; }
    .filter-row { display:flex;flex-wrap:wrap;gap:10px;align-items:center; }
    .filter-row select { height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s; }
    .filter-row select:focus { border-color:var(--brand-500);background:#fff; }
    .filter-sep { flex:1; }
    .btn-filter { height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer; }
    .btn-filter:hover { background:var(--brand-700); }
    .btn-reset { height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center; }
    .btn-reset:hover { background:var(--surface3); }

    .table-card { background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden; }
    .table-topbar { display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border); }
    .table-info { font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text); }
    .table-info span { font-weight:400;color:var(--text3);margin-left:6px; }
    .drag-hint { font-size:12px;color:var(--text3);display:flex;align-items:center;gap:5px; }
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

    .drag-handle { cursor:grab;color:var(--text3);padding:4px;border-radius:4px;display:inline-flex;align-items:center;transition:color .15s; }
    .drag-handle:hover { color:var(--brand-600); }
    .drag-handle:active { cursor:grabbing; }

    .no-col { font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3); }
    .urutan-badge { display:inline-flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:6px;background:var(--surface2);border:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2); }

    .thumb-wrap { width:44px;height:36px;border-radius:6px;overflow:hidden;border:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:center;flex-shrink:0; }
    .thumb-wrap img { width:100%;height:100%;object-fit:cover; }

    .kat-name { font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text); }
    .kat-slug { font-size:11.5px;color:var(--text3);margin-top:2px;font-family:monospace; }

    .badge { display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap; }
    .badge-dot { width:5px;height:5px;border-radius:50%; }
    .badge-published { background:var(--green-bg);color:var(--green); } .badge-published .badge-dot { background:var(--green); }
    .badge-draft     { background:var(--surface3);color:var(--text3); } .badge-draft .badge-dot     { background:var(--text3); }

    .tipe-pill { display:inline-block;padding:2px 9px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700; }
    .tipe-foto  { background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100); }
    .tipe-video { background:#fdf4ff;color:#7c3aed;border:1px solid #e9d5ff; }
    .tipe-semua { background:var(--green-bg);color:var(--green);border:1px solid var(--green-border); }

    .count-wrap { display:flex;flex-direction:column;gap:2px; }
    .count-item { font-size:12px;color:var(--text2);display:flex;align-items:center;gap:4px; }
    .count-num  { font-family:'Plus Jakarta Sans',sans-serif;font-weight:700; }

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
            <h1 class="page-title">Kategori Galeri</h1>
            <p class="page-sub">Kelola kategori untuk foto dan video galeri sekolah</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.galeri.kategori.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Kategori
            </a>
        </div>
    </div>

    {{-- Stats --}}
    @php
        $totalKat   = \App\Models\GaleriKategori::count();
        $published  = \App\Models\GaleriKategori::where('is_published',true)->count();
        $katFoto    = \App\Models\GaleriKategori::where('tipe','foto')->orWhere('tipe','semua')->count();
        $katVideo   = \App\Models\GaleriKategori::where('tipe','video')->orWhere('tipe','semua')->count();
    @endphp
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
            </div>
            <div><p class="stat-label">Total Kategori</p><p class="stat-val">{{ $totalKat }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Aktif</p><p class="stat-val">{{ $published }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
            <div><p class="stat-label">Kat. Foto</p><p class="stat-val">{{ $katFoto }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
            </div>
            <div><p class="stat-label">Kat. Video</p><p class="stat-val">{{ $katVideo }}</p></div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.galeri.kategori.index') }}">
            <div class="filter-row">
                <select name="tipe">
                    <option value="">Semua Tipe</option>
                    <option value="foto"  {{ request('tipe')==='foto'  ? 'selected':'' }}>Foto</option>
                    <option value="video" {{ request('tipe')==='video' ? 'selected':'' }}>Video</option>
                    <option value="semua" {{ request('tipe')==='semua' ? 'selected':'' }}>Semua</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.galeri.kategori.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Kategori
                <span>— menampilkan {{ $kategori->firstItem() }}–{{ $kategori->lastItem() }} dari {{ $kategori->total() }} data</span>
            </p>
            <p class="drag-hint">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 9l4-4 4 4M5 15l4 4 4-4M9 5v14"/></svg>
                Drag untuk ubah urutan
            </p>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:36px"></th>
                        <th style="width:44px" class="center">#</th>
                        <th style="width:52px">Thumb</th>
                        <th>Nama / Slug</th>
                        <th class="center">Tipe</th>
                        <th class="center">Konten</th>
                        <th class="center">Urutan</th>
                        <th class="center">Status</th>
                        <th class="center" style="width:180px">Aksi</th>
                    </tr>
                </thead>
                <tbody id="sortable-tbody">
                    @forelse($kategori as $i => $kat)
                    <tr data-id="{{ $kat->id }}">
                        <td>
                            <span class="drag-handle" title="Drag untuk ubah urutan">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><circle cx="9" cy="5" r="1.2"/><circle cx="9" cy="12" r="1.2"/><circle cx="9" cy="19" r="1.2"/><circle cx="15" cy="5" r="1.2"/><circle cx="15" cy="12" r="1.2"/><circle cx="15" cy="19" r="1.2"/></svg>
                            </span>
                        </td>
                        <td class="center"><span class="no-col">{{ $kategori->firstItem() + $i }}</span></td>
                        <td>
                            <div class="thumb-wrap">
                                @if($kat->thumbnail_path)
                                    <img src="{{ asset('storage/'.$kat->thumbnail_path) }}" alt="{{ $kat->nama }}">
                                @elseif($kat->thumbnail_url)
                                    <img src="{{ $kat->thumbnail_url }}" alt="{{ $kat->nama }}">
                                @else
                                    <svg width="16" height="16" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                @endif
                            </div>
                        </td>
                        <td>
                            <p class="kat-name">{{ $kat->nama }}</p>
                            <p class="kat-slug">/{{ $kat->slug }}</p>
                        </td>
                        <td class="center">
                            <span class="tipe-pill tipe-{{ $kat->tipe }}">{{ ucfirst($kat->tipe) }}</span>
                        </td>
                        <td class="center">
                            <div class="count-wrap">
                                <div class="count-item">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    <span class="count-num">{{ $kat->foto_count ?? 0 }}</span> foto
                                </div>
                                <div class="count-item">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                                    <span class="count-num">{{ $kat->video_count ?? 0 }}</span> video
                                </div>
                            </div>
                        </td>
                        <td class="center"><span class="urutan-badge">{{ $kat->urutan }}</span></td>
                        <td class="center">
                            @if($kat->is_published)
                                <span class="badge badge-published"><span class="badge-dot"></span>Aktif</span>
                            @else
                                <span class="badge badge-draft"><span class="badge-dot"></span>Nonaktif</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <form action="{{ route('admin.galeri.kategori.toggle', $kat->id) }}" method="POST" style="display:contents">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $kat->is_published ? 'btn-off' : 'btn-on' }}">
                                        {{ $kat->is_published ? 'Nonaktif' : 'Aktifkan' }}
                                    </button>
                                </form>
                                <a href="{{ route('admin.galeri.kategori.edit', $kat->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('admin.galeri.kategori.destroy', $kat->id) }}"
                                      method="POST" id="del-{{ $kat->id }}" style="display:contents">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete({{ $kat->id }}, '{{ addslashes($kat->nama) }}')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                                </div>
                                <p class="empty-title">Belum ada kategori galeri</p>
                                <p class="empty-sub">Tambahkan kategori pertama untuk mulai mengorganisir galeri</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kategori->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $kategori->firstItem() }}–{{ $kategori->lastItem() }} dari {{ $kategori->total() }} kategori</p>
            <div class="pag-btns">
                @if($kategori->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $kategori->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($kategori->getUrlRange(1,$kategori->lastPage()) as $page => $url)
                    @if($page == $kategori->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $kategori->lastPage() || abs($page - $kategori->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $kategori->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($kategori->hasMorePages())
                    <a href="{{ $kategori->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
@endif
@if(session('error'))
Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
@endif

function confirmDelete(id, nama) {
    Swal.fire({
        title:'Hapus Kategori?',
        text:`Kategori "${nama}" akan dihapus. Pastikan tidak ada foto/video di dalamnya.`,
        icon:'warning',showCancelButton:true,
        confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
        confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal',
    }).then(r => { if(r.isConfirmed) document.getElementById('del-'+id).submit(); });
}

Sortable.create(document.getElementById('sortable-tbody'), {
    handle:'.drag-handle', animation:150,
    onEnd() {
        const ids = [...document.querySelectorAll('#sortable-tbody tr[data-id]')].map(tr => tr.dataset.id);
        fetch('{{ route('admin.galeri.kategori.reorder') }}', {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
            body: JSON.stringify({ids})
        }).then(r => r.json()).then(d => {
            if(d.success) Swal.fire({icon:'success',title:'Urutan disimpan!',timer:1500,showConfirmButton:false,toast:true,position:'top-end'});
        });
    }
});
</script>
</x-app-layout>