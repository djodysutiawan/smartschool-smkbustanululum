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

.modal-overlay { display:none; position:fixed; inset:0; background:rgba(15,23,42,.45); z-index:50; align-items:center; justify-content:center; }
.modal-overlay.open { display:flex; }
.modal { background:#fff; border-radius:14px; width:100%; max-width:500px; box-shadow:0 20px 60px rgba(0,0,0,.18); overflow:hidden; }
.modal-header { display:flex; align-items:center; justify-content:space-between; padding:18px 22px; border-bottom:1px solid var(--border); }
.modal-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:15px; font-weight:800; color:var(--text); }
.modal-close { background:none; border:none; cursor:pointer; color:var(--text3); padding:4px; border-radius:6px; }
.modal-close:hover { background:var(--surface2); color:var(--text); }
.modal-body { padding:20px 22px; display:flex; flex-direction:column; gap:14px; }
.modal-footer { padding:14px 22px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:8px; background:var(--surface2); }
.form-group { display:flex; flex-direction:column; gap:5px; }
.form-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.form-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:12px; font-weight:700; color:var(--text2); }
.form-hint { font-size:11px; color:var(--text3); margin-top:2px; }
.form-control { height:36px; padding:0 12px; border:1px solid var(--border); border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:13px; color:var(--text); background:#fff; outline:none; transition:border-color .15s; width:100%; box-sizing:border-box; }
.form-control:focus { border-color:var(--brand-500); }
textarea.form-control { height:80px; padding:8px 12px; resize:vertical; }

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

.jabatan-name { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:13.5px; color:var(--text); display:flex; align-items:center; gap:8px; }
.jabatan-desc { font-size:12px; color:var(--text3); margin-top:2px; }
.ikon-circle { width:30px; height:30px; border-radius:50%; background:var(--brand-50); display:flex; align-items:center; justify-content:center; font-size:15px; flex-shrink:0; }

.badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:99px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; }
.badge-blue { background:#dbeafe; color:#1d4ed8; }
.badge-gray { background:#f1f5f9; color:#64748b; }

.action-group { display:flex; align-items:center; gap:5px; justify-content:center; }

.empty-state { padding:60px 20px; text-align:center; }
.empty-icon { width:56px; height:56px; background:var(--surface2); border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }
.empty-title { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:15px; color:var(--text); margin-bottom:5px; }
.empty-sub { font-size:13px; color:var(--text3); }

@media(max-width:640px) { .stats-strip { grid-template-columns:1fr; } .page { padding:16px; } .form-row { grid-template-columns:1fr; } }
</style>

<div class="page">
    <div class="breadcrumb">
        <a href="{{ route('admin.jurusan.index') }}">Jurusan</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <a href="{{ route('admin.jurusan.show', $jurusan) }}">{{ $jurusan->singkatan ?? $jurusan->nama }}</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <span>Prospek Kerja</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Prospek Kerja — {{ $jurusan->nama }}</h1>
            <p class="page-sub">Kelola daftar jabatan dan peluang karier lulusan</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.jurusan.show', $jurusan) }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <button class="btn btn-primary" onclick="document.getElementById('modalTambah').classList.add('open')">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Prospek Kerja
            </button>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
            </div>
            <div><p class="stat-label">Total Jabatan</p><p class="stat-val">{{ $prospekKerja->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
            </div>
            <div><p class="stat-label">Bidang Industri</p><p class="stat-val">{{ $prospekKerja->whereNotNull('bidang_industri')->unique('bidang_industri')->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
            </div>
            <div><p class="stat-label">Dengan Ikon</p><p class="stat-val">{{ $prospekKerja->whereNotNull('ikon')->count() }}</p></div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">Daftar Prospek Kerja <span>— {{ $prospekKerja->count() }} jabatan</span></p>
            <span style="font-size:12px; color:var(--text3);">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:middle"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                Drag baris untuk ubah urutan
            </span>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:36px"></th>
                        <th style="width:44px">#</th>
                        <th>Jabatan</th>
                        <th>Bidang Industri</th>
                        <th class="center" style="width:160px">Aksi</th>
                    </tr>
                </thead>
                <tbody id="sortable-body">
                    @forelse($prospekKerja as $i => $p)
                    <tr data-id="{{ $p->id }}">
                        <td>
                            <span class="drag-handle">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                            </span>
                        </td>
                        <td><span class="no-col">{{ $i + 1 }}</span></td>
                        <td>
                            <div class="jabatan-name">
                                @if($p->ikon)
                                    <span class="ikon-circle">{{ $p->ikon }}</span>
                                @endif
                                {{ $p->jabatan }}
                            </div>
                            @if($p->deskripsi)
                                <p class="jabatan-desc">{{ Str::limit($p->deskripsi, 70) }}</p>
                            @endif
                        </td>
                        <td>
                            @if($p->bidang_industri)
                                <span class="badge badge-blue">{{ $p->bidang_industri }}</span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <button class="btn btn-sm btn-edit"
                                    onclick="openEdit({{ $p->id }}, {{ $p->toJson() }})">Edit</button>
                                <form action="{{ route('admin.jurusan.prospek-kerja.destroy', [$jurusan, $p]) }}" method="POST" id="delForm-{{ $p->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delForm-{{ $p->id }}'), '{{ addslashes($p->jabatan) }}')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon"><svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg></div>
                            <p class="empty-title">Belum ada prospek kerja</p>
                            <p class="empty-sub">Tambahkan jabatan dan peluang karier lulusan</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal-overlay" id="modalTambah">
    <div class="modal">
        <div class="modal-header">
            <p class="modal-title">Tambah Prospek Kerja</p>
            <button class="modal-close" onclick="document.getElementById('modalTambah').classList.remove('open')">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.jurusan.prospek-kerja.store', $jurusan) }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Jabatan <span style="color:#dc2626">*</span></label>
                    <input type="text" name="jabatan" class="form-control" placeholder="cth. Web Developer" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Bidang Industri</label>
                        <input type="text" name="bidang_industri" class="form-control" placeholder="cth. Teknologi Informasi">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ikon (emoji)</label>
                        <input type="text" name="ikon" class="form-control" placeholder="cth. 💻" maxlength="50">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" placeholder="Deskripsi singkat prospek kerja ini..."></textarea>
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
            <p class="modal-title">Edit Prospek Kerja</p>
            <button class="modal-close" onclick="document.getElementById('modalEdit').classList.remove('open')">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Jabatan <span style="color:#dc2626">*</span></label>
                    <input type="text" name="jabatan" id="edit_jabatan" class="form-control" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Bidang Industri</label>
                        <input type="text" name="bidang_industri" id="edit_bidang" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ikon (emoji)</label>
                        <input type="text" name="ikon" id="edit_ikon" class="form-control" maxlength="50">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="edit_deskripsi" class="form-control"></textarea>
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
    const url = "{{ route('admin.jurusan.prospek-kerja.update', [$jurusan, '__ID__']) }}".replace('__ID__', id);
    document.getElementById('editForm').action = url;
    document.getElementById('edit_jabatan').value  = data.jabatan          ?? '';
    document.getElementById('edit_bidang').value   = data.bidang_industri  ?? '';
    document.getElementById('edit_ikon').value     = data.ikon             ?? '';
    document.getElementById('edit_deskripsi').value= data.deskripsi        ?? '';
    document.getElementById('modalEdit').classList.add('open');
}

function confirmDelete(form, nama) {
    Swal.fire({ title:'Hapus Prospek Kerja?', text:`"${nama}" akan dihapus permanen.`, icon:'warning',
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
        fetch("{{ route('admin.jurusan.prospek-kerja.reorder', $jurusan) }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ ids })
        });
    }
});
</script>
</x-app-layout>