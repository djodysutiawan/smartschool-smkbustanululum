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
.page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:20px; font-weight:800; color:var(--text); line-height:1.2; }
.page-sub { font-size:12.5px; color:var(--text3); margin-top:3px; }
.breadcrumb { display:flex; align-items:center; gap:6px; font-size:12px; color:var(--text3); margin-bottom:6px; }
.breadcrumb a { color:var(--brand-600); text-decoration:none; }
.breadcrumb a:hover { text-decoration:underline; }
.header-actions { display:flex; gap:8px; flex-wrap:wrap; }

.btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; border:none; text-decoration:none; transition:filter .15s; white-space:nowrap; }
.btn:hover { filter:brightness(.93); }
.btn-primary { background:var(--brand-600); color:#fff; }
.btn-sm { padding:6px 12px; font-size:12px; border-radius:6px; }
.btn-edit { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
.btn-edit:hover { background:var(--brand-100); filter:none; }
.btn-del { background:#fff0f0; color:#dc2626; border:1px solid #fecaca; }
.btn-del:hover { background:#fee2e2; filter:none; }
.btn-secondary { background:var(--surface2); color:var(--text2); border:1px solid var(--border); }
.btn-secondary:hover { background:var(--surface3); filter:none; }

.stats-strip { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:20px; }
.stat-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:14px 18px; display:flex; align-items:center; gap:12px; }
.stat-icon { width:38px; height:38px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.stat-icon.blue { background:var(--brand-50); }
.stat-icon.green { background:#f0fdf4; }
.stat-icon.yellow { background:#fefce8; }
.stat-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:600; color:var(--text3); letter-spacing:.03em; text-transform:uppercase; }
.stat-val { font-family:'Plus Jakarta Sans',sans-serif; font-size:22px; font-weight:800; color:var(--text); line-height:1.1; margin-top:1px; }

.modal-overlay { display:none; position:fixed; inset:0; background:rgba(15,23,42,.45); z-index:50; align-items:center; justify-content:center; padding:16px; }
.modal-overlay.open { display:flex; }
.modal { background:#fff; border-radius:14px; width:100%; max-width:520px; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,.18); }
.modal-header { display:flex; align-items:center; justify-content:space-between; padding:18px 22px; border-bottom:1px solid var(--border); position:sticky; top:0; background:#fff; z-index:1; }
.modal-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:15px; font-weight:800; color:var(--text); }
.modal-close { background:none; border:none; cursor:pointer; color:var(--text3); padding:4px; border-radius:6px; }
.modal-close:hover { background:var(--surface2); color:var(--text); }
.modal-body { padding:20px 22px; display:flex; flex-direction:column; gap:14px; }
.modal-footer { padding:14px 22px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:8px; background:var(--surface2); position:sticky; bottom:0; }
.form-group { display:flex; flex-direction:column; gap:5px; }
.form-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.form-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:12px; font-weight:700; color:var(--text2); }
.form-hint { font-size:11px; color:var(--text3); margin-top:2px; }
.form-control { height:36px; padding:0 12px; border:1px solid var(--border); border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:13px; color:var(--text); background:#fff; outline:none; transition:border-color .15s; width:100%; box-sizing:border-box; }
.form-control:focus { border-color:var(--brand-500); }
textarea.form-control { height:72px; padding:8px 12px; resize:vertical; }
input[type="file"].form-control { height:auto; padding:6px 12px; }

/* Upload area */
.upload-area { border:2px dashed var(--border2); border-radius:var(--radius-sm); padding:18px; text-align:center; cursor:pointer; transition:border-color .15s; background:var(--surface2); }
.upload-area:hover { border-color:var(--brand-500); }
.upload-area p { font-size:12.5px; color:var(--text3); margin-top:6px; }
.upload-area strong { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; color:var(--text2); }

.table-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; }
.table-topbar { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-bottom:1px solid var(--border); }
.table-info { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; color:var(--text); }
.table-info span { font-weight:400; color:var(--text3); margin-left:6px; }
.table-wrap { overflow-x:auto; }
table { width:100%; border-collapse:collapse; font-size:13.5px; }
thead tr { background:var(--surface2); border-bottom:1px solid var(--border); }
thead th { padding:11px 14px; text-align:left; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; color:var(--text3); letter-spacing:.05em; text-transform:uppercase; white-space:nowrap; }
thead th.center { text-align:center; }
tbody tr { border-bottom:1px solid #f1f5f9; transition:background .1s; }
tbody tr:last-child { border-bottom:none; }
tbody tr:hover { background:#fafbff; }
td { padding:10px 14px; color:var(--text); vertical-align:middle; }
td.center { text-align:center; }
td.muted { color:var(--text3); font-size:12.5px; }
.no-col { font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; color:var(--text3); }
.drag-handle { color:var(--text3); cursor:grab; }

.foto-thumb { width:52px; height:38px; border-radius:6px; overflow:hidden; border:1px solid var(--border); background:var(--surface2); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.foto-thumb img { width:100%; height:100%; object-fit:cover; }
.foto-initial { font-size:11px; font-weight:800; color:var(--brand-600); font-family:'Plus Jakarta Sans',sans-serif; }

.fasilitas-name { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:13.5px; color:var(--text); }
.fasilitas-desc { font-size:12px; color:var(--text3); margin-top:2px; }

.badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:99px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; }
.badge-blue { background:#dbeafe; color:#1d4ed8; }

.action-group { display:flex; align-items:center; gap:5px; justify-content:center; }

.empty-state { padding:60px 20px; text-align:center; }
.empty-icon { width:56px; height:56px; background:var(--surface2); border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }
.empty-title { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:15px; color:var(--text); margin-bottom:5px; }
.empty-sub { font-size:13px; color:var(--text3); }

.pag-wrap { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-top:1px solid var(--border); flex-wrap:wrap; gap:10px; }
.pag-info { font-size:12.5px; color:var(--text3); }
.pag-btns { display:flex; gap:4px; align-items:center; }
.pag-btn { height:32px; min-width:32px; padding:0 8px; border-radius:7px; display:flex; align-items:center; justify-content:center; border:1px solid var(--border); background:var(--surface); color:var(--text2); font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; cursor:pointer; transition:all .15s; text-decoration:none; }
.pag-btn:hover { background:var(--surface2); }
.pag-btn.active { background:var(--brand-600); border-color:var(--brand-600); color:#fff; }
.pag-ellipsis { color:var(--text3); font-size:13px; padding:0 4px; }

@media(max-width:640px) { .stats-strip { grid-template-columns:1fr; } .page { padding:16px; } .form-row { grid-template-columns:1fr; } }
</style>

<div class="page">
    <div class="breadcrumb">
        <a href="{{ route('admin.jurusan.index') }}">Jurusan</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <a href="{{ route('admin.jurusan.show', $jurusan) }}">{{ $jurusan->singkatan ?? $jurusan->nama }}</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <span>Fasilitas</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Fasilitas — {{ $jurusan->nama }}</h1>
            <p class="page-sub">Kelola daftar fasilitas dan sarana pendukung jurusan</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.jurusan.show', $jurusan) }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <button class="btn btn-primary" onclick="document.getElementById('modalTambah').classList.add('open')">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Fasilitas
            </button>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <div><p class="stat-label">Total Fasilitas</p><p class="stat-val">{{ $fasilitas->total() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
            <div><p class="stat-label">Dengan Foto</p><p class="stat-val">{{ $fasilitas->getCollection()->filter(fn($f) => $f->foto_path || $f->foto_url)->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </div>
            <div><p class="stat-label">Total Unit</p><p class="stat-val">{{ $fasilitas->getCollection()->sum('jumlah') }}</p></div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">Daftar Fasilitas <span>— {{ $fasilitas->total() }} data</span></p>
            <span style="font-size:12px; color:var(--text3);">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:middle"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                Drag untuk ubah urutan
            </span>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:36px"></th>
                        <th style="width:44px">#</th>
                        <th style="width:64px">Foto</th>
                        <th>Nama Fasilitas</th>
                        <th class="center">Jumlah</th>
                        <th class="center" style="width:160px">Aksi</th>
                    </tr>
                </thead>
                <tbody id="sortable-body">
                    @forelse($fasilitas as $i => $f)
                    <tr data-id="{{ $f->id }}">
                        <td>
                            <span class="drag-handle">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                            </span>
                        </td>
                        <td><span class="no-col">{{ $fasilitas->firstItem() + $i }}</span></td>
                        <td>
                            <div class="foto-thumb">
                                @if($f->foto_path)
                                    <img src="{{ Storage::url($f->foto_path) }}" alt="{{ $f->nama_fasilitas }}">
                                @elseif($f->foto_url)
                                    <img src="{{ $f->foto_url }}" alt="{{ $f->nama_fasilitas }}">
                                @else
                                    <span class="foto-initial">{{ strtoupper(substr($f->nama_fasilitas, 0, 2)) }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <p class="fasilitas-name">{{ $f->nama_fasilitas }}</p>
                            @if($f->deskripsi)
                                <p class="fasilitas-desc">{{ Str::limit($f->deskripsi, 60) }}</p>
                            @endif
                        </td>
                        <td class="center">
                            @if($f->jumlah !== null)
                                <span class="badge badge-blue">{{ $f->jumlah }} unit</span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <button class="btn btn-sm btn-edit"
                                    onclick="openEdit({{ $f->id }}, {{ $f->toJson() }})">Edit</button>
                                <form action="{{ route('admin.jurusan.fasilitas.destroy', [$jurusan, $f]) }}" method="POST" id="delForm-{{ $f->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delForm-{{ $f->id }}'), '{{ addslashes($f->nama_fasilitas) }}')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6">
                        <div class="empty-state">
                            <div class="empty-icon"><svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg></div>
                            <p class="empty-title">Belum ada fasilitas</p>
                            <p class="empty-sub">Tambahkan fasilitas dan sarana pendukung jurusan</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($fasilitas->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $fasilitas->firstItem() }}–{{ $fasilitas->lastItem() }} dari {{ $fasilitas->total() }}</p>
            <div class="pag-btns">
                @if($fasilitas->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $fasilitas->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($fasilitas->getUrlRange(1,$fasilitas->lastPage()) as $page => $url)
                    @if($page==$fasilitas->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page==1||$page==$fasilitas->lastPage()||abs($page-$fasilitas->currentPage())<=1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page-$fasilitas->currentPage())==2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($fasilitas->hasMorePages())
                    <a href="{{ $fasilitas->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal-overlay" id="modalTambah">
    <div class="modal">
        <div class="modal-header">
            <p class="modal-title">Tambah Fasilitas</p>
            <button class="modal-close" onclick="document.getElementById('modalTambah').classList.remove('open')">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.jurusan.fasilitas.store', $jurusan) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Fasilitas <span style="color:#dc2626">*</span></label>
                    <input type="text" name="nama_fasilitas" class="form-control" placeholder="cth. Lab Komputer" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Jumlah Unit</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="cth. 30" min="0">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" class="form-control" placeholder="otomatis" min="0">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" placeholder="Deskripsi singkat fasilitas..."></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    <span class="form-hint">Atau isi URL foto di bawah</span>
                </div>
                <div class="form-group">
                    <label class="form-label">URL Foto</label>
                    <input type="url" name="foto_url" class="form-control" placeholder="https://...">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalTambah').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <div class="modal-header">
            <p class="modal-title">Edit Fasilitas</p>
            <button class="modal-close" onclick="document.getElementById('modalEdit').classList.remove('open')">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Fasilitas <span style="color:#dc2626">*</span></label>
                    <input type="text" name="nama_fasilitas" id="edit_nama" class="form-control" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Jumlah Unit</label>
                        <input type="number" name="jumlah" id="edit_jumlah" class="form-control" min="0">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" id="edit_urutan" class="form-control" min="0">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="edit_deskripsi" class="form-control"></textarea>
                </div>
                <div id="edit_foto_preview" style="display:none; margin-bottom:4px;">
                    <img id="edit_foto_img" src="" style="height:60px; border-radius:6px; border:1px solid var(--border);">
                </div>
                <div class="form-group">
                    <label class="form-label">Ganti Foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>
                <div class="form-group">
                    <label class="form-label">URL Foto</label>
                    <input type="url" name="foto_url" id="edit_foto_url" class="form-control" placeholder="https://...">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalEdit').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif

function openEdit(id, data) {
    const url = "{{ route('admin.jurusan.fasilitas.update', [$jurusan, '__ID__']) }}".replace('__ID__', id);
    document.getElementById('editForm').action = url;
    document.getElementById('edit_nama').value     = data.nama_fasilitas ?? '';
    document.getElementById('edit_jumlah').value   = data.jumlah          ?? '';
    document.getElementById('edit_urutan').value   = data.urutan           ?? '';
    document.getElementById('edit_deskripsi').value= data.deskripsi        ?? '';
    document.getElementById('edit_foto_url').value = data.foto_url         ?? '';

    const preview = document.getElementById('edit_foto_preview');
    const img     = document.getElementById('edit_foto_img');
    const src     = data.foto_path ? '/storage/' + data.foto_path : (data.foto_url ?? '');
    if (src) { img.src = src; preview.style.display = 'block'; }
    else { preview.style.display = 'none'; }

    document.getElementById('modalEdit').classList.add('open');
}

function confirmDelete(form, nama) {
    Swal.fire({ title:'Hapus Fasilitas?', text:`"${nama}" akan dihapus permanen.`, icon:'warning',
        showCancelButton:true, confirmButtonColor:'#dc2626', cancelButtonColor:'#64748b',
        confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal'
    }).then(r => { if(r.isConfirmed) form.submit(); });
}

['modalTambah','modalEdit'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
        if(e.target === this) this.classList.remove('open');
    });
});

Sortable.create(document.getElementById('sortable-body'), {
    handle: '.drag-handle', animation: 150,
    onEnd() {
        const ids = [...document.querySelectorAll('#sortable-body tr[data-id]')].map(r => r.dataset.id);
        fetch("{{ route('admin.jurusan.fasilitas.reorder', $jurusan) }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ ids })
        });
    }
});
</script>
</x-app-layout>