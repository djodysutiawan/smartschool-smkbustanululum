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

.stats-strip { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:20px; }
.stat-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:14px 18px; display:flex; align-items:center; gap:12px; }
.stat-icon { width:38px; height:38px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.stat-icon.blue { background:var(--brand-50); }
.stat-icon.green { background:#f0fdf4; }
.stat-icon.yellow { background:#fefce8; }
.stat-icon.purple { background:#fdf4ff; }
.stat-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:600; color:var(--text3); letter-spacing:.03em; text-transform:uppercase; }
.stat-val { font-family:'Plus Jakarta Sans',sans-serif; font-size:22px; font-weight:800; color:var(--text); line-height:1.1; margin-top:1px; }

/* Modal Tambah */
.modal-overlay { display:none; position:fixed; inset:0; background:rgba(15,23,42,.45); z-index:50; align-items:center; justify-content:center; }
.modal-overlay.open { display:flex; }
.modal { background:#fff; border-radius:14px; width:100%; max-width:520px; box-shadow:0 20px 60px rgba(0,0,0,.18); overflow:hidden; }
.modal-header { display:flex; align-items:center; justify-content:space-between; padding:18px 22px; border-bottom:1px solid var(--border); }
.modal-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:15px; font-weight:800; color:var(--text); }
.modal-close { background:none; border:none; cursor:pointer; color:var(--text3); padding:4px; border-radius:6px; }
.modal-close:hover { background:var(--surface2); color:var(--text); }
.modal-body { padding:20px 22px; display:flex; flex-direction:column; gap:14px; }
.modal-footer { padding:14px 22px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:8px; background:var(--surface2); }
.form-group { display:flex; flex-direction:column; gap:5px; }
.form-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.form-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:12px; font-weight:700; color:var(--text2); }
.form-control { height:36px; padding:0 12px; border:1px solid var(--border); border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:13px; color:var(--text); background:#fff; outline:none; transition:border-color .15s; width:100%; box-sizing:border-box; }
.form-control:focus { border-color:var(--brand-500); }
textarea.form-control { height:72px; padding:8px 12px; resize:vertical; }

/* Table */
.table-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; margin-bottom:20px; }
.table-topbar { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-bottom:1px solid var(--border); }
.table-info { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; color:var(--text); }
.table-info span { font-weight:400; color:var(--text3); margin-left:6px; }
.group-label { padding:10px 20px; background:var(--surface2); border-bottom:1px solid var(--border); font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; color:var(--text3); letter-spacing:.05em; text-transform:uppercase; }
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

.badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:99px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; white-space:nowrap; }
.badge-blue { background:#dbeafe; color:#1d4ed8; }
.badge-green { background:#dcfce7; color:#15803d; }
.badge-yellow { background:#fef9c3; color:#a16207; }
.badge-gray { background:#f1f5f9; color:#64748b; }

.mapel-name { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:13.5px; color:var(--text); }
.mapel-desc { font-size:12px; color:var(--text3); margin-top:2px; }

.action-group { display:flex; align-items:center; gap:5px; justify-content:center; }

.empty-state { padding:60px 20px; text-align:center; }
.empty-icon { width:56px; height:56px; background:var(--surface2); border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }
.empty-title { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:15px; color:var(--text); margin-bottom:5px; }
.empty-sub { font-size:13px; color:var(--text3); }

/* Inline edit form */
.edit-row { display:none; background:#f8fafc; }
.edit-row.open { display:table-row; }
.edit-form-wrap { padding:14px 20px; display:flex; flex-wrap:wrap; gap:10px; align-items:flex-end; }

@media(max-width:640px) { .stats-strip { grid-template-columns:1fr 1fr; } .page { padding:16px; } .form-row { grid-template-columns:1fr; } }
</style>

<div class="page">
    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.jurusan.index') }}">Jurusan</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <a href="{{ route('admin.jurusan.show', $jurusan) }}">{{ $jurusan->singkatan ?? $jurusan->nama }}</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <span>Kurikulum</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Kurikulum — {{ $jurusan->nama }}</h1>
            <p class="page-sub">Kelola mata pelajaran per kelas dan semester</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.jurusan.show', $jurusan) }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <button class="btn btn-primary" onclick="document.getElementById('modalTambah').classList.add('open')">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Mata Pelajaran
            </button>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h10"/></svg>
            </div>
            <div><p class="stat-label">Total Mapel</p><p class="stat-val">{{ $kurikulum->flatten()->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            </div>
            <div><p class="stat-label">Kelas X</p><p class="stat-val">{{ $kurikulum->flatten()->where('kelas', 10)->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            </div>
            <div><p class="stat-label">Kelas XI</p><p class="stat-val">{{ $kurikulum->flatten()->where('kelas', 11)->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            </div>
            <div><p class="stat-label">Kelas XII</p><p class="stat-val">{{ $kurikulum->flatten()->where('kelas', 12)->count() }}</p></div>
        </div>
    </div>

    {{-- Table per group --}}
    @forelse($kurikulum as $groupLabel => $items)
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">{{ $groupLabel }} <span>— {{ $items->count() }} mata pelajaran</span></p>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:44px">#</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelompok</th>
                        <th class="center">Jam/Minggu</th>
                        <th class="center" style="width:160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $i => $k)
                    <tr>
                        <td><span class="no-col">{{ $i + 1 }}</span></td>
                        <td>
                            <p class="mapel-name">{{ $k->nama_mapel }}</p>
                            @if($k->deskripsi)
                                <p class="mapel-desc">{{ Str::limit($k->deskripsi, 60) }}</p>
                            @endif
                        </td>
                        <td>
                            @if($k->kelompok)
                                <span class="badge badge-blue">{{ $k->kelompok }}</span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>
                        <td class="center">
                            @if($k->jam_per_minggu)
                                <span class="badge badge-green">{{ $k->jam_per_minggu }} jam</span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <button class="btn btn-sm btn-edit"
                                    onclick="openEdit({{ $k->id }}, {{ $k->toJson() }})">
                                    Edit
                                </button>
                                <form action="{{ route('admin.jurusan.kurikulum.destroy', [$jurusan, $k]) }}" method="POST" id="delForm-{{ $k->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delForm-{{ $k->id }}'), '{{ addslashes($k->nama_mapel) }}')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @empty
    <div class="table-card">
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h10"/></svg>
            </div>
            <p class="empty-title">Belum ada kurikulum</p>
            <p class="empty-sub">Mulai dengan menambahkan mata pelajaran pertama</p>
        </div>
    </div>
    @endforelse
</div>

{{-- Modal Tambah --}}
<div class="modal-overlay" id="modalTambah">
    <div class="modal">
        <div class="modal-header">
            <p class="modal-title">Tambah Mata Pelajaran</p>
            <button class="modal-close" onclick="document.getElementById('modalTambah').classList.remove('open')">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.jurusan.kurikulum.store', $jurusan) }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Mata Pelajaran <span style="color:#dc2626">*</span></label>
                    <input type="text" name="nama_mapel" class="form-control" placeholder="cth. Pemrograman Web" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Kelas</label>
                        <select name="kelas" class="form-control">
                            <option value="">— Pilih Kelas —</option>
                            <option value="10">X</option>
                            <option value="11">XI</option>
                            <option value="12">XII</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Semester</label>
                        <select name="semester" class="form-control">
                            <option value="">— Pilih —</option>
                            <option value="1">1 (Ganjil)</option>
                            <option value="2">2 (Genap)</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Kelompok</label>
                        <input type="text" name="kelompok" class="form-control" placeholder="cth. Produktif">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jam / Minggu</label>
                        <input type="number" name="jam_per_minggu" class="form-control" placeholder="cth. 4" min="1" max="40">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" placeholder="Deskripsi singkat mata pelajaran..."></textarea>
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
            <p class="modal-title">Edit Mata Pelajaran</p>
            <button class="modal-close" onclick="document.getElementById('modalEdit').classList.remove('open')">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Mata Pelajaran <span style="color:#dc2626">*</span></label>
                    <input type="text" name="nama_mapel" id="edit_nama_mapel" class="form-control" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Kelas</label>
                        <select name="kelas" id="edit_kelas" class="form-control">
                            <option value="">— Pilih Kelas —</option>
                            <option value="10">X</option>
                            <option value="11">XI</option>
                            <option value="12">XII</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Semester</label>
                        <select name="semester" id="edit_semester" class="form-control">
                            <option value="">— Pilih —</option>
                            <option value="1">1 (Ganjil)</option>
                            <option value="2">2 (Genap)</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Kelompok</label>
                        <input type="text" name="kelompok" id="edit_kelompok" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jam / Minggu</label>
                        <input type="number" name="jam_per_minggu" id="edit_jam" class="form-control" min="1" max="40">
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
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif

function openEdit(id, data) {
    const base = "{{ route('admin.jurusan.kurikulum.update', [$jurusan, '__ID__']) }}".replace('__ID__', id);
    document.getElementById('editForm').action = base;
    document.getElementById('edit_nama_mapel').value  = data.nama_mapel  ?? '';
    document.getElementById('edit_kelas').value       = data.kelas        ?? '';
    document.getElementById('edit_semester').value    = data.semester     ?? '';
    document.getElementById('edit_kelompok').value    = data.kelompok     ?? '';
    document.getElementById('edit_jam').value         = data.jam_per_minggu ?? '';
    document.getElementById('edit_deskripsi').value   = data.deskripsi    ?? '';
    document.getElementById('modalEdit').classList.add('open');
}

function confirmDelete(form, nama) {
    Swal.fire({
        title: 'Hapus Mata Pelajaran?',
        text: `"${nama}" akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then(r => { if(r.isConfirmed) form.submit(); });
}

// Tutup modal klik luar
['modalTambah','modalEdit'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
        if(e.target === this) this.classList.remove('open');
    });
});
</script>
</x-app-layout>