<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root {
    --brand:      #1f63db;
    --brand-h:    #3582f0;
    --brand-50:   #eef6ff;
    --brand-100:  #d9ebff;
    --brand-700:  #1750c0;
    --surface:    #fff;
    --surface2:   #f8fafc;
    --surface3:   #f1f5f9;
    --border:     #e2e8f0;
    --border2:    #cbd5e1;
    --text:       #0f172a;
    --text2:      #475569;
    --text3:      #94a3b8;
    --red:        #dc2626;
    --red-bg:     #fee2e2;
    --red-border: #fecaca;
    --green:      #15803d;
    --green-bg:   #dcfce7;
    --green-bd:   #bbf7d0;
    --radius:     10px;
    --radius-sm:  7px;
}
.page { padding:28px 28px 60px; max-width:2000px; margin:0 auto; }
.page-header { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:24px; flex-wrap:wrap; }
.page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:20px; font-weight:800; color:var(--text); }
.page-sub { font-size:12.5px; color:var(--text3); margin-top:3px; }
.header-actions { display:flex; gap:8px; flex-wrap:wrap; align-items:center; }
.btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; border:none; text-decoration:none; transition:filter .15s, background .15s; white-space:nowrap; }
.btn-primary { background:var(--brand); color:#fff; }
.btn-primary:hover { filter:brightness(.93); }
.btn-secondary { background:var(--surface2); color:var(--text2); border:1px solid var(--border); }
.btn-secondary:hover { background:var(--surface3); }
.btn-sm { padding:6px 12px; font-size:12px; border-radius:6px; }
.btn-edit   { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
.btn-edit:hover { background:var(--brand-100); filter:none; }
.btn-del    { background:#fff0f0; color:#dc2626; border:1px solid #fecaca; }
.btn-del:hover { background:#fee2e2; filter:none; }
.btn-detail { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
.btn-detail:hover { background:#dcfce7; filter:none; }
.btn-toggle-on  { background:#dcfce7; color:#15803d; border:1px solid #bbf7d0; }
.btn-toggle-on:hover  { background:#bbf7d0; filter:none; }
.btn-toggle-off { background:#fef9c3; color:#a16207; border:1px solid #fde68a; }
.btn-toggle-off:hover { background:#fef08a; filter:none; }
.btn-export { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
.btn-export:hover { background:#dcfce7; filter:none; }
.btn-import { background:#fefce8; color:#a16207; border:1px solid #fde68a; }
.btn-import:hover { background:#fef9c3; filter:none; }
.filter-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:16px 20px; margin-bottom:16px; }
.filter-row { display:flex; flex-wrap:wrap; gap:10px; align-items:center; }
.filter-row select { height:36px; padding:0 12px; border:1px solid var(--border); border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:13px; color:var(--text); background:var(--surface2); outline:none; }
.filter-row select:focus { border-color:var(--brand-h); background:#fff; }
.filter-sep { flex:1; }
.btn-filter { height:36px; padding:0 18px; background:var(--brand); color:#fff; border:none; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; }
.btn-filter:hover { background:var(--brand-700); }
.btn-reset { height:36px; padding:0 14px; background:var(--surface2); color:var(--text2); border:1px solid var(--border); border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; }
.btn-reset:hover { background:var(--surface3); }
.table-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; }
.table-topbar { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-bottom:1px solid var(--border); gap:12px; flex-wrap:wrap; }
.table-info { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; color:var(--text); }
.table-info span { font-weight:400; color:var(--text3); margin-left:6px; }
.topbar-actions { display:flex; gap:8px; align-items:center; flex-wrap:wrap; }
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
td.muted { color:var(--text3); }
.no-col { font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; color:var(--text3); }
.hari-pill { display:inline-block; padding:2px 9px; border-radius:5px; font-family:'Plus Jakarta Sans',sans-serif; font-size:12px; font-weight:700; text-transform:capitalize; }
.hari-senin  { background:#eef2ff; color:#4338ca; border:1px solid #c7d2fe; }
.hari-selasa { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
.hari-rabu   { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
.hari-kamis  { background:#fefce8; color:#a16207; border:1px solid #fde68a; }
.hari-jumat  { background:#fff7ed; color:#c2410c; border:1px solid #fed7aa; }
.hari-sabtu  { background:#fdf4ff; color:#7c3aed; border:1px solid #e9d5ff; }
.badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:99px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; white-space:nowrap; }
.badge-dot { width:5px; height:5px; border-radius:50%; }
.badge-tersedia { background:#dcfce7; color:#15803d; } .badge-tersedia .badge-dot { background:#15803d; }
.badge-tidak    { background:#fee2e2; color:#dc2626; } .badge-tidak .badge-dot { background:#dc2626; }
.action-group { display:flex; align-items:center; gap:5px; justify-content:center; flex-wrap:wrap; }
.empty-state { padding:60px 20px; text-align:center; }
.empty-icon { width:56px; height:56px; background:var(--surface2); border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }
.empty-title { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:15px; color:var(--text); margin-bottom:5px; }
.empty-sub { font-size:13px; color:var(--text3); }
.pag-wrap { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-top:1px solid var(--border); flex-wrap:wrap; gap:10px; }
.pag-info { font-size:12.5px; color:var(--text3); }
.pag-btns { display:flex; gap:4px; align-items:center; }
.pag-btn { height:32px; min-width:32px; padding:0 8px; border-radius:7px; display:flex; align-items:center; justify-content:center; border:1px solid var(--border); background:var(--surface); color:var(--text2); font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; cursor:pointer; transition:all .15s; text-decoration:none; }
.pag-btn:hover { background:var(--surface2); border-color:var(--border2); }
.pag-btn.active { background:var(--brand); border-color:var(--brand); color:#fff; }
.pag-ellipsis { color:var(--text3); font-size:13px; padding:0 4px; }
.modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,.45); display:flex; align-items:center; justify-content:center; z-index:9999; padding:16px; }
.modal-box { background:#fff; border-radius:var(--radius); border:1px solid var(--border); width:100%; max-width:480px; overflow:hidden; }
.modal-header { padding:16px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
.modal-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:15px; font-weight:700; color:var(--text); }
.modal-body { padding:20px; }
.modal-footer { padding:14px 20px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:8px; background:var(--surface2); }
.modal-close { background:none; border:none; cursor:pointer; color:var(--text3); display:flex; padding:4px; }
.modal-close:hover { color:var(--text); }
.upload-zone { border:2px dashed var(--border2); border-radius:var(--radius-sm); padding:24px; text-align:center; cursor:pointer; transition:border-color .15s, background .15s; }
.upload-zone:hover { border-color:var(--brand-h); background:var(--brand-50); }
.upload-zone.dragover { border-color:var(--brand); background:var(--brand-50); }
.upload-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:600; color:var(--text2); margin-top:8px; }
.upload-hint { font-size:12px; color:var(--text3); margin-top:4px; }
.file-selected { font-size:12.5px; color:var(--green); font-family:'DM Sans',sans-serif; margin-top:8px; font-weight:600; }
.info-note { background:var(--brand-50); border:1px solid var(--brand-100); border-radius:var(--radius-sm); padding:10px 14px; font-size:12.5px; color:#1d4ed8; font-family:'DM Sans',sans-serif; margin-top:12px; }
@media (max-width:640px) { .page { padding:16px; } .filter-row select { width:100%; } }
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Ketersediaan Guru</h1>
            <p class="page-sub">Kelola slot waktu ketersediaan guru untuk penjadwalan otomatis</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.ketersediaan-guru.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Slot
            </a>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.ketersediaan-guru.index') }}">
            <div class="filter-row">
                <select name="guru_id">
                    <option value="">Semua Guru</option>
                    @foreach($gurus as $g)
                        <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                    @endforeach
                </select>
                <select name="hari">
                    <option value="">Semua Hari</option>
                    @foreach($hariList as $h)
                        <option value="{{ $h }}" {{ request('hari') == $h ? 'selected' : '' }}>{{ ucfirst($h) }}</option>
                    @endforeach
                </select>
                <select name="tersedia">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('tersedia')==='1' ? 'selected' : '' }}>Tersedia</option>
                    <option value="0" {{ request('tersedia')==='0' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.ketersediaan-guru.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Ketersediaan
                <span>— {{ $ketersediaan->total() }} data</span>
            </p>
            <div class="topbar-actions">
                <a href="{{ route('admin.ketersediaan-guru.export.excel', request()->query()) }}" class="btn btn-sm btn-export">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export Excel
                </a>
                <a href="{{ route('admin.ketersediaan-guru.export.pdf', request()->query()) }}" class="btn btn-sm btn-export" style="background:#fff0f0;color:#dc2626;border-color:#fecaca">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export PDF
                </a>
                <button type="button" class="btn btn-sm btn-import" onclick="document.getElementById('modalImport').style.display='flex'">
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
                        <th>Guru</th>
                        <th>Hari</th>
                        <th class="center">Jam Mulai</th>
                        <th class="center">Jam Selesai</th>
                        <th class="center">Durasi</th>
                        <th>Status</th>
                        <th class="center" style="width:240px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ketersediaan as $index => $k)
                    <tr>
                        <td><span class="no-col">{{ $ketersediaan->firstItem() + $index }}</span></td>
                        <td>
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px">{{ $k->guru->nama_lengkap ?? '-' }}</p>
                            <p style="font-size:12px;color:var(--text3)">{{ $k->guru->nip ?? '-' }}</p>
                        </td>
                        <td><span class="hari-pill hari-{{ $k->hari }}">{{ ucfirst($k->hari) }}</span></td>
                        <td class="center" style="font-family:'DM Sans',sans-serif;font-weight:600">{{ \Carbon\Carbon::parse($k->jam_mulai)->format('H:i') }}</td>
                        <td class="center" style="font-family:'DM Sans',sans-serif;font-weight:600">{{ \Carbon\Carbon::parse($k->jam_selesai)->format('H:i') }}</td>
                        <td class="center muted" style="font-size:12.5px">{{ $k->durasi_menit }} menit</td>
                        <td>
                            @if($k->tersedia)
                                <span class="badge badge-tersedia"><span class="badge-dot"></span>Tersedia</span>
                            @else
                                <span class="badge badge-tidak"><span class="badge-dot"></span>Tidak Tersedia</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.ketersediaan-guru.show', $k->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('admin.ketersediaan-guru.edit', $k->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('admin.ketersediaan-guru.toggle', $k->id) }}" method="POST" id="toggleForm-{{ $k->id }}">
                                    @csrf @method('PATCH')
                                    <button type="button" class="btn btn-sm {{ $k->tersedia ? 'btn-toggle-on' : 'btn-toggle-off' }}"
                                        onclick="confirmToggle(document.getElementById('toggleForm-{{ $k->id }}'), {{ $k->tersedia ? 'true' : 'false' }})">
                                        {{ $k->tersedia ? '✓ Tersedia' : '✗ N/A' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.ketersediaan-guru.destroy', $k->id) }}" method="POST" id="delForm-{{ $k->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delForm-{{ $k->id }}'), '{{ addslashes($k->guru->nama_lengkap ?? '') }}', '{{ ucfirst($k->hari) }}', '{{ \Carbon\Carbon::parse($k->jam_mulai)->format('H:i') }}')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                </div>
                                <p class="empty-title">Belum ada data ketersediaan</p>
                                <p class="empty-sub">Coba ubah filter atau tambah slot ketersediaan baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($ketersediaan->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $ketersediaan->firstItem() }}–{{ $ketersediaan->lastItem() }} dari {{ $ketersediaan->total() }} slot</p>
            <div class="pag-btns">
                @if($ketersediaan->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $ketersediaan->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($ketersediaan->getUrlRange(1, $ketersediaan->lastPage()) as $page => $url)
                    @if($page == $ketersediaan->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $ketersediaan->lastPage() || abs($page - $ketersediaan->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $ketersediaan->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($ketersediaan->hasMorePages())
                    <a href="{{ $ketersediaan->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<div class="modal-overlay" id="modalImport" style="display:none" onclick="if(event.target===this)this.style.display='none'">
    <div class="modal-box">
        <div class="modal-header">
            <p class="modal-title">Import Data Ketersediaan</p>
            <button class="modal-close" onclick="document.getElementById('modalImport').style.display='none'">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.ketersediaan-guru.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="upload-zone" id="uploadZone" onclick="document.getElementById('fileInput').click()">
                    <svg width="32" height="32" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    <p class="upload-label">Klik untuk pilih file</p>
                    <p class="upload-hint">Format: .xlsx, .xls, atau .csv — Maks. 2 MB</p>
                    <p class="file-selected" id="fileNameDisplay" style="display:none"></p>
                </div>
                <input type="file" name="file" id="fileInput" accept=".xlsx,.xls,.csv" style="display:none">
                <div class="info-note">
                    <strong>Format kolom:</strong> guru_id, hari, jam_mulai, jam_selesai, tersedia (1/0). Pastikan guru_id valid dan hari menggunakan huruf kecil (senin, selasa, dst).
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalImport').style.display='none'">Batal</button>
                <button type="submit" class="btn btn-primary" id="btnImport" disabled>
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Proses Import
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

function confirmDelete(form, guru, hari, jam) {
    Swal.fire({
        title: 'Hapus Slot Ketersediaan?',
        html: `Slot <strong>${guru}</strong> — ${hari} pukul ${jam} akan dihapus permanen.`,
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) form.submit(); });
}

function confirmToggle(form, currentlyTersedia) {
    const newStatus = currentlyTersedia ? 'Tidak Tersedia' : 'Tersedia';
    Swal.fire({
        title: 'Ubah Status?',
        text: `Slot akan diubah menjadi "${newStatus}".`,
        icon: 'question', showCancelButton: true,
        confirmButtonColor: '#1f63db', cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Ubah!', cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) form.submit(); });
}

const fileInput = document.getElementById('fileInput');
const fileNameDisplay = document.getElementById('fileNameDisplay');
const btnImport = document.getElementById('btnImport');
const uploadZone = document.getElementById('uploadZone');

fileInput.addEventListener('change', function() {
    if (this.files.length > 0) {
        fileNameDisplay.textContent = this.files[0].name;
        fileNameDisplay.style.display = 'block';
        btnImport.disabled = false;
    } else {
        fileNameDisplay.style.display = 'none';
        btnImport.disabled = true;
    }
});

uploadZone.addEventListener('dragover', e => { e.preventDefault(); uploadZone.classList.add('dragover'); });
uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('dragover'));
uploadZone.addEventListener('drop', e => {
    e.preventDefault();
    uploadZone.classList.remove('dragover');
    const dt = e.dataTransfer;
    if (dt.files.length) {
        fileInput.files = dt.files;
        fileInput.dispatchEvent(new Event('change'));
    }
});
</script>
</x-app-layout>