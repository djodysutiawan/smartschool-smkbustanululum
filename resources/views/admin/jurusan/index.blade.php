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
.header-actions { display:flex; gap:8px; flex-wrap:wrap; }

.btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; border:none; text-decoration:none; transition:filter .15s; white-space:nowrap; }
.btn:hover { filter:brightness(.93); }
.btn-primary { background:var(--brand-600); color:#fff; }
.btn-sm { padding:6px 12px; font-size:12px; border-radius:6px; }
.btn-edit { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
.btn-edit:hover { background:var(--brand-100); filter:none; }
.btn-del { background:#fff0f0; color:#dc2626; border:1px solid #fecaca; }
.btn-del:hover { background:#fee2e2; filter:none; }
.btn-detail { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
.btn-detail:hover { background:#dcfce7; filter:none; }
.btn-secondary { background:var(--surface2); color:var(--text2); border:1px solid var(--border); }
.btn-secondary:hover { background:var(--surface3); filter:none; }
.btn-outline { background:#fff; color:var(--brand-700); border:1px solid var(--brand-100); }
.btn-outline:hover { background:var(--brand-50); filter:none; }

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
.filter-row input, .filter-row select { height:36px; padding:0 12px; border:1px solid var(--border); border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:13px; color:var(--text); background:var(--surface2); outline:none; transition:border-color .15s; }
.filter-row input { width:210px; }
.filter-row input:focus, .filter-row select:focus { border-color:var(--brand-500); background:#fff; }
.filter-row input::placeholder { color:var(--text3); }
.filter-sep { flex:1; }
.btn-filter { height:36px; padding:0 18px; background:var(--brand-600); color:#fff; border:none; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; }
.btn-filter:hover { background:var(--brand-700); }
.btn-reset { height:36px; padding:0 14px; background:var(--surface2); color:var(--text2); border:1px solid var(--border); border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; }
.btn-reset:hover { background:var(--surface3); }

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
td.muted { color:var(--text3); }
.no-col { font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; color:var(--text3); }

.cover-wrap { width:52px; height:36px; border-radius:6px; overflow:hidden; border:1px solid var(--border); background:var(--surface2); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.cover-wrap img { width:100%; height:100%; object-fit:cover; }
.cover-initial { font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:800; color:var(--brand-600); }

.jurusan-wrap .jname { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:13.5px; color:var(--text); }
.jurusan-wrap .jcode { font-size:11.5px; color:var(--text3); margin-top:1px; }

.badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:99px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; white-space:nowrap; }
.badge-dot { width:5px; height:5px; border-radius:50%; }
.badge-published { background:#dcfce7; color:#15803d; }
.badge-published .badge-dot { background:#15803d; }
.badge-draft { background:#f1f5f9; color:#64748b; }
.badge-draft .badge-dot { background:#94a3b8; }
.badge-buka { background:#dbeafe; color:#1d4ed8; }
.badge-buka .badge-dot { background:#1d4ed8; }
.badge-tutup { background:#fff0f0; color:#dc2626; }
.badge-tutup .badge-dot { background:#dc2626; }

.action-group { display:flex; align-items:center; gap:5px; justify-content:center; flex-wrap:wrap; }

.mini-stats { display:flex; gap:10px; }
.mini-stat { display:flex; flex-direction:column; align-items:center; }
.mini-stat-val { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:800; color:var(--text); }
.mini-stat-label { font-size:10px; color:var(--text3); margin-top:1px; }

.empty-state { padding:60px 20px; text-align:center; }
.empty-icon { width:56px; height:56px; background:var(--surface2); border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }
.empty-title { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:15px; color:var(--text); margin-bottom:5px; }
.empty-sub { font-size:13px; color:var(--text3); }

.pag-wrap { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-top:1px solid var(--border); flex-wrap:wrap; gap:10px; }
.pag-info { font-size:12.5px; color:var(--text3); }
.pag-btns { display:flex; gap:4px; align-items:center; }
.pag-btn { height:32px; min-width:32px; padding:0 8px; border-radius:7px; display:flex; align-items:center; justify-content:center; border:1px solid var(--border); background:var(--surface); color:var(--text2); font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; cursor:pointer; transition:all .15s; text-decoration:none; }
.pag-btn:hover { background:var(--surface2); border-color:var(--border2); }
.pag-btn.active { background:var(--brand-600); border-color:var(--brand-600); color:#fff; }
.pag-ellipsis { color:var(--text3); font-size:13px; padding:0 4px; }

.toggle-btn { display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:99px; font-size:11.5px; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif; cursor:pointer; border:none; text-decoration:none; transition:all .15s; }

@media(max-width:640px) { .stats-strip { grid-template-columns:1fr 1fr; } .page { padding:16px; } .filter-row input { width:100%; } }
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Jurusan</h1>
            <p class="page-sub">Kelola data jurusan — tambah, edit, publikasikan, dan atur detail</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.jurusan.export.pdf') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export PDF
            </a>
            <a href="{{ route('admin.jurusan.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Jurusan
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            </div>
            <div><p class="stat-label">Total Jurusan</p><p class="stat-val">{{ $jurusan->total() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Published</p><p class="stat-val">{{ \App\Models\Jurusan::where('is_published',true)->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div><p class="stat-label">Draft</p><p class="stat-val">{{ \App\Models\Jurusan::where('is_published',false)->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div><p class="stat-label">Penerimaan Buka</p><p class="stat-val">{{ \App\Models\Jurusan::where('is_penerimaan_buka',true)->count() }}</p></div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.jurusan.index') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, singkatan, kode...">
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status')=='published'?'selected':'' }}>Published</option>
                    <option value="draft" {{ request('status')=='draft'?'selected':'' }}>Draft</option>
                </select>
                <select name="penerimaan">
                    <option value="">Semua Penerimaan</option>
                    <option value="buka" {{ request('penerimaan')=='buka'?'selected':'' }}>Buka</option>
                    <option value="tutup" {{ request('penerimaan')=='tutup'?'selected':'' }}>Tutup</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.jurusan.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">Daftar Jurusan <span>— {{ $jurusan->total() }} data</span></p>
            <form action="{{ route('admin.jurusan.reorder') }}" method="POST" id="reorderForm" style="display:none">@csrf</form>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th style="width:60px">Cover</th>
                        <th>Nama Jurusan</th>
                        <th>Akreditasi</th>
                        <th class="center">Detail</th>
                        <th class="center">Status</th>
                        <th class="center">Penerimaan</th>
                        <th class="center" style="width:220px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurusan as $index => $j)
                    <tr>
                        <td><span class="no-col">{{ $jurusan->firstItem() + $index }}</span></td>
                        <td>
                            <div class="cover-wrap">
                                @if($j->foto_cover_path)
                                    <img src="{{ Storage::url($j->foto_cover_path) }}" alt="{{ $j->nama }}">
                                @elseif($j->foto_cover_url)
                                    <img src="{{ $j->foto_cover_url }}" alt="{{ $j->nama }}">
                                @else
                                    <span class="cover-initial">{{ strtoupper(substr($j->singkatan ?? $j->nama, 0, 3)) }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="jurusan-wrap">
                                <p class="jname">{{ $j->nama }}</p>
                                <p class="jcode">{{ $j->singkatan }}{{ $j->kode_jurusan ? ' · '.$j->kode_jurusan : '' }}</p>
                            </div>
                        </td>
                        <td class="muted" style="font-size:12.5px">{{ $j->akreditasi ?? '-' }}</td>
                        <td class="center">
                            <div class="mini-stats">
                                <div class="mini-stat"><span class="mini-stat-val">{{ $j->kurikulum->count() }}</span><span class="mini-stat-label">Mapel</span></div>
                                <div class="mini-stat"><span class="mini-stat-val">{{ $j->kompetensi->count() }}</span><span class="mini-stat-label">Kompetensi</span></div>
                                <div class="mini-stat"><span class="mini-stat-val">{{ $j->fasilitas->count() }}</span><span class="mini-stat-label">Fasilitas</span></div>
                            </div>
                        </td>
                        <td class="center">
                            <form action="{{ route('admin.jurusan.toggle-publish', $j->id) }}" method="POST" style="display:inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="toggle-btn {{ $j->is_published ? 'badge-published' : 'badge-draft' }}" title="Klik untuk toggle">
                                    <span class="badge-dot" style="background:{{ $j->is_published ? '#15803d' : '#94a3b8' }}"></span>
                                    {{ $j->is_published ? 'Published' : 'Draft' }}
                                </button>
                            </form>
                        </td>
                        <td class="center">
                            <form action="{{ route('admin.jurusan.toggle-penerimaan', $j->id) }}" method="POST" style="display:inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="toggle-btn {{ $j->is_penerimaan_buka ? 'badge-buka' : 'badge-tutup' }}" title="Klik untuk toggle">
                                    <span class="badge-dot" style="background:{{ $j->is_penerimaan_buka ? '#1d4ed8' : '#dc2626' }}"></span>
                                    {{ $j->is_penerimaan_buka ? 'Buka' : 'Tutup' }}
                                </button>
                            </form>
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.jurusan.show', $j->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('admin.jurusan.edit', $j->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('admin.jurusan.destroy', $j->id) }}" method="POST" id="delForm-{{ $j->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del" onclick="confirmDelete(document.getElementById('delForm-{{ $j->id }}'), '{{ addslashes($j->nama) }}')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8">
                        <div class="empty-state">
                            <div class="empty-icon"><svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/></svg></div>
                            <p class="empty-title">Belum ada jurusan</p>
                            <p class="empty-sub">Mulai dengan menambahkan jurusan pertama</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($jurusan->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $jurusan->firstItem() }}–{{ $jurusan->lastItem() }} dari {{ $jurusan->total() }}</p>
            <div class="pag-btns">
                @if($jurusan->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $jurusan->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($jurusan->getUrlRange(1,$jurusan->lastPage()) as $page => $url)
                    @if($page==$jurusan->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page==1||$page==$jurusan->lastPage()||abs($page-$jurusan->currentPage())<=1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page-$jurusan->currentPage())==2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($jurusan->hasMorePages())
                    <a href="{{ $jurusan->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif
@if(session('info'))
Swal.fire({ icon:'info', title:'Info', text:@json(session('info')), confirmButtonColor:'#1f63db' });
@endif
function confirmDelete(form, nama) {
    Swal.fire({ title:'Hapus Jurusan?', text:`Jurusan "${nama}" akan dihapus permanen beserta semua datanya.`, icon:'warning', showCancelButton:true, confirmButtonColor:'#dc2626', cancelButtonColor:'#64748b', confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal' }).then(r => { if(r.isConfirmed) form.submit(); });
}
</script>
</x-app-layout>