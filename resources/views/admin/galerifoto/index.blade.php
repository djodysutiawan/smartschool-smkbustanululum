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
.page-header { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:24px; flex-wrap:wrap; }
.page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:20px; font-weight:800; color:var(--text); }
.page-sub { font-size:12.5px; color:var(--text3); margin-top:3px; }
.header-actions { display:flex; gap:8px; flex-wrap:wrap; }

.btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; border:none; text-decoration:none; transition:filter .15s; white-space:nowrap; }
.btn:hover { filter:brightness(.93); }
.btn-primary { background:var(--brand-600); color:#fff; }
.btn-sm { padding:6px 12px; font-size:12px; border-radius:6px; }
.btn-secondary { background:var(--surface2); color:var(--text2); border:1px solid var(--border); }
.btn-secondary:hover { background:var(--surface3); filter:none; }
.btn-danger { background:#dc2626; color:#fff; }
.btn-del { background:#fff0f0; color:#dc2626; border:1px solid #fecaca; }
.btn-del:hover { background:#fee2e2; filter:none; }
.btn-edit { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
.btn-edit:hover { background:var(--brand-100); filter:none; }

.stats-strip { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:20px; }
.stat-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:14px 18px; display:flex; align-items:center; gap:12px; }
.stat-icon { width:38px; height:38px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.stat-icon.blue { background:var(--brand-50); }
.stat-icon.green { background:#f0fdf4; }
.stat-icon.yellow { background:#fefce8; }
.stat-icon.purple { background:#fdf4ff; }
.stat-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:600; color:var(--text3); letter-spacing:.03em; text-transform:uppercase; }
.stat-val { font-family:'Plus Jakarta Sans',sans-serif; font-size:22px; font-weight:800; color:var(--text); line-height:1.1; margin-top:1px; }

.filter-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:16px 20px; margin-bottom:16px; }
.filter-row { display:flex; flex-wrap:wrap; gap:10px; align-items:center; }
.filter-row select { height:36px; padding:0 12px; border:1px solid var(--border); border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:13px; color:var(--text); background:var(--surface2); outline:none; }
.filter-row select:focus { border-color:var(--brand-500); }
.filter-sep { flex:1; }
.btn-filter { height:36px; padding:0 18px; background:var(--brand-600); color:#fff; border:none; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; }
.btn-reset { height:36px; padding:0 14px; background:var(--surface2); color:var(--text2); border:1px solid var(--border); border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; }

/* Bulk upload card */
.upload-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:18px 20px; margin-bottom:16px; }
.upload-card-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; color:var(--text); margin-bottom:12px; display:flex; align-items:center; gap:6px; }
.upload-row { display:flex; flex-wrap:wrap; gap:10px; align-items:flex-end; }
.upload-row select, .upload-row input[type="file"] { height:36px; padding:0 12px; border:1px solid var(--border); border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:13px; color:var(--text); background:var(--surface2); outline:none; }
.upload-row input[type="file"] { height:auto; padding:5px 12px; }

/* Bulk action bar */
.bulk-bar { display:none; background:var(--brand-50); border:1px solid var(--brand-100); border-radius:var(--radius); padding:10px 16px; margin-bottom:12px; align-items:center; gap:10px; flex-wrap:wrap; }
.bulk-bar.show { display:flex; }
.bulk-bar-info { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; color:var(--brand-700); }

/* Grid foto */
.foto-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:14px; margin-bottom:20px; }
.foto-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; transition:box-shadow .15s; position:relative; }
.foto-card:hover { box-shadow:0 4px 20px rgba(0,0,0,.08); }
.foto-card.selected { border-color:var(--brand-500); box-shadow:0 0 0 2px var(--brand-100); }
.foto-card-check { position:absolute; top:8px; left:8px; z-index:2; }
.foto-card-check input { width:16px; height:16px; cursor:pointer; accent-color:var(--brand-600); }
.foto-img-wrap { aspect-ratio:4/3; overflow:hidden; background:var(--surface2); position:relative; }
.foto-img-wrap img { width:100%; height:100%; object-fit:cover; transition:transform .2s; }
.foto-card:hover .foto-img-wrap img { transform:scale(1.04); }
.foto-img-placeholder { width:100%; height:100%; display:flex; align-items:center; justify-content:center; }
.foto-badges { position:absolute; top:6px; right:6px; display:flex; flex-direction:column; gap:4px; }
.foto-badge { padding:2px 7px; border-radius:99px; font-size:10px; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif; }
.foto-badge-pub { background:#dcfce7; color:#15803d; }
.foto-badge-draft { background:#f1f5f9; color:#64748b; }
.foto-badge-feat { background:#fef9c3; color:#a16207; }
.foto-body { padding:10px 12px; }
.foto-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; color:var(--text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.foto-cat { font-size:11.5px; color:var(--text3); margin-top:2px; }
.foto-actions { display:flex; gap:5px; margin-top:8px; }
.foto-action-btn { flex:1; display:inline-flex; align-items:center; justify-content:center; gap:4px; padding:5px 8px; border-radius:6px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; cursor:pointer; border:none; text-decoration:none; transition:all .15s; }
.foto-action-btn.edit { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
.foto-action-btn.edit:hover { background:var(--brand-100); }
.foto-action-btn.del { background:#fff0f0; color:#dc2626; border:1px solid #fecaca; }
.foto-action-btn.del:hover { background:#fee2e2; }

.empty-state { padding:60px 20px; text-align:center; background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); }
.empty-icon { width:56px; height:56px; background:var(--surface2); border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }
.empty-title { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:15px; color:var(--text); margin-bottom:5px; }
.empty-sub { font-size:13px; color:var(--text3); }

.pag-wrap { display:flex; align-items:center; justify-content:space-between; padding:14px 0; flex-wrap:wrap; gap:10px; }
.pag-info { font-size:12.5px; color:var(--text3); }
.pag-btns { display:flex; gap:4px; align-items:center; }
.pag-btn { height:32px; min-width:32px; padding:0 8px; border-radius:7px; display:flex; align-items:center; justify-content:center; border:1px solid var(--border); background:var(--surface); color:var(--text2); font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; cursor:pointer; text-decoration:none; }
.pag-btn:hover { background:var(--surface2); }
.pag-btn.active { background:var(--brand-600); border-color:var(--brand-600); color:#fff; }
.pag-ellipsis { color:var(--text3); padding:0 4px; }

@media(max-width:640px) { .stats-strip{grid-template-columns:1fr 1fr;} .page{padding:16px;} .foto-grid{grid-template-columns:repeat(2,1fr);} }
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Galeri Foto</h1>
            <p class="page-sub">Kelola foto galeri sekolah — unggah, kategorikan, dan publikasikan</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.galeri.foto.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Unggah Foto
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
            <div><p class="stat-label">Total Foto</p><p class="stat-val">{{ $foto->total() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Published</p><p class="stat-val">{{ \App\Models\GaleriFoto::where('is_published',true)->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div><p class="stat-label">Unggulan</p><p class="stat-val">{{ \App\Models\GaleriFoto::where('is_featured',true)->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
            </div>
            <div><p class="stat-label">Kategori</p><p class="stat-val">{{ $kategori->count() }}</p></div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.galeri.foto.index') }}">
            <div class="filter-row">
                <select name="kategori_id">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama }}
                        </option>
                    @endforeach
                </select>
                <select name="featured">
                    <option value="">Semua Foto</option>
                    <option value="1" {{ request('featured') ? 'selected' : '' }}>Unggulan saja</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.galeri.foto.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- Bulk Upload --}}
    <div class="upload-card">
        <p class="upload-card-title">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
            Unggah Banyak Foto Sekaligus
        </p>
        <form action="{{ route('admin.galeri.foto.bulk-upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="upload-row">
                <select name="galeri_kategori_id" required>
                    <option value="">— Pilih Kategori —</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                    @endforeach
                </select>
                <input type="file" name="foto[]" multiple accept="image/*" required>
                <button type="submit" class="btn btn-primary btn-sm">Unggah Semua</button>
            </div>
        </form>
    </div>

    {{-- Bulk action bar --}}
    <div class="bulk-bar" id="bulkBar">
        <span class="bulk-bar-info"><span id="bulkCount">0</span> foto dipilih</span>
        <form action="{{ route('admin.galeri.foto.bulk-delete') }}" method="POST" id="bulkDeleteForm">
            @csrf
            <div id="bulkIdsContainer"></div>
            <button type="button" class="btn btn-sm btn-danger" onclick="confirmBulkDelete()">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                Hapus yang Dipilih
            </button>
        </form>
        <button class="btn btn-sm btn-secondary" onclick="clearSelection()">Batalkan Pilihan</button>
    </div>

    {{-- Grid --}}
    @if($foto->count())
    <div class="foto-grid" id="fotoGrid">
        @foreach($foto as $f)
        <div class="foto-card" id="card-{{ $f->id }}">
            <div class="foto-card-check">
                <input type="checkbox" value="{{ $f->id }}" onchange="toggleSelect(this, {{ $f->id }})">
            </div>
            <div class="foto-img-wrap">
                @if($f->foto_path)
                    <img src="{{ Storage::url($f->foto_path) }}" alt="{{ $f->alt_text ?? $f->judul }}" loading="lazy">
                @elseif($f->foto_url)
                    <img src="{{ $f->foto_url }}" alt="{{ $f->alt_text ?? $f->judul }}" loading="lazy">
                @else
                    <div class="foto-img-placeholder">
                        <svg width="32" height="32" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                @endif
                <div class="foto-badges">
                    <span class="foto-badge {{ $f->is_published ? 'foto-badge-pub' : 'foto-badge-draft' }}">
                        {{ $f->is_published ? 'Live' : 'Draft' }}
                    </span>
                    @if($f->is_featured)
                        <span class="foto-badge foto-badge-feat">★ Unggulan</span>
                    @endif
                </div>
            </div>
            <div class="foto-body">
                <p class="foto-title" title="{{ $f->judul }}">{{ $f->judul }}</p>
                <p class="foto-cat">{{ $f->kategori->nama ?? '—' }}</p>
                <div class="foto-actions">
                    <a href="{{ route('admin.galeri.foto.edit', $f) }}" class="foto-action-btn edit">Edit</a>
                    <form action="{{ route('admin.galeri.foto.destroy', $f) }}" method="POST" id="del-{{ $f->id }}">
                        @csrf @method('DELETE')
                        <button type="button" class="foto-action-btn del"
                            onclick="confirmDelete(document.getElementById('del-{{ $f->id }}'), '{{ addslashes($f->judul) }}')">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($foto->hasPages())
    <div class="pag-wrap">
        <p class="pag-info">Menampilkan {{ $foto->firstItem() }}–{{ $foto->lastItem() }} dari {{ $foto->total() }}</p>
        <div class="pag-btns">
            @if($foto->onFirstPage())
                <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
            @else
                <a href="{{ $foto->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
            @endif
            @foreach($foto->getUrlRange(1,$foto->lastPage()) as $page => $url)
                @if($page==$foto->currentPage())
                    <span class="pag-btn active">{{ $page }}</span>
                @elseif($page==1||$page==$foto->lastPage()||abs($page-$foto->currentPage())<=1)
                    <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                @elseif(abs($page-$foto->currentPage())==2)
                    <span class="pag-ellipsis">…</span>
                @endif
            @endforeach
            @if($foto->hasMorePages())
                <a href="{{ $foto->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
            @else
                <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
            @endif
        </div>
    </div>
    @endif

    @else
    <div class="empty-state">
        <div class="empty-icon"><svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
        <p class="empty-title">Belum ada foto</p>
        <p class="empty-sub">Mulai unggah foto pertama ke galeri</p>
    </div>
    @endif
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

let selectedIds = new Set();

function toggleSelect(cb, id) {
    if (cb.checked) { selectedIds.add(id); document.getElementById('card-'+id).classList.add('selected'); }
    else { selectedIds.delete(id); document.getElementById('card-'+id).classList.remove('selected'); }
    updateBulkBar();
}

function updateBulkBar() {
    const bar = document.getElementById('bulkBar');
    document.getElementById('bulkCount').textContent = selectedIds.size;
    bar.classList.toggle('show', selectedIds.size > 0);
}

function clearSelection() {
    selectedIds.clear();
    document.querySelectorAll('.foto-card-check input').forEach(cb => { cb.checked = false; });
    document.querySelectorAll('.foto-card').forEach(c => c.classList.remove('selected'));
    updateBulkBar();
}

function confirmBulkDelete() {
    Swal.fire({ title: `Hapus ${selectedIds.size} foto?`, text:'Semua foto yang dipilih akan dihapus permanen.', icon:'warning',
        showCancelButton:true, confirmButtonColor:'#dc2626', cancelButtonColor:'#64748b',
        confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal'
    }).then(r => {
        if (!r.isConfirmed) return;
        const container = document.getElementById('bulkIdsContainer');
        container.innerHTML = '';
        selectedIds.forEach(id => {
            const inp = document.createElement('input');
            inp.type='hidden'; inp.name='ids[]'; inp.value=id;
            container.appendChild(inp);
        });
        document.getElementById('bulkDeleteForm').submit();
    });
}

function confirmDelete(form, nama) {
    Swal.fire({ title:'Hapus Foto?', text:`"${nama}" akan dihapus permanen.`, icon:'warning',
        showCancelButton:true, confirmButtonColor:'#dc2626', cancelButtonColor:'#64748b',
        confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal'
    }).then(r => { if(r.isConfirmed) form.submit(); });
}
</script>
</x-app-layout>