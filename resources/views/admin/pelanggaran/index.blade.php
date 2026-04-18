<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;--brand-100:#d9ebff;--brand-50:#eef6ff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;}
    .page{padding:28px 28px 40px;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px;}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}.btn-edit:hover{background:var(--brand-100);filter:none;}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}.btn-del:hover{background:#fee2e2;filter:none;}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}.btn-detail:hover{background:#dcfce7;filter:none;}
    .btn-export{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}.btn-export:hover{background:var(--surface3);filter:none;}
    .btn-import{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}.btn-import:hover{background:#dcfce7;filter:none;}
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}.stat-icon.red{background:#fff0f0;}.stat-icon.orange{background:#fff7ed;}.stat-icon.purple{background:#fdf4ff;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center;}
    .filter-row input,.filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;}
    .filter-row input{width:200px;}
    .filter-row input:focus,.filter-row select:focus{border-color:var(--brand-500);background:#fff;}
    .filter-row input::placeholder{color:var(--text3);}
    .filter-sep{flex:1;}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;}
    .btn-filter:hover{background:var(--brand-700);}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;}
    .btn-reset:hover{background:var(--surface3);}
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px;}
    .topbar-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap;}
    .table-wrap{overflow-x:auto;}
    table{width:100%;border-collapse:collapse;font-size:13.5px;}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
    thead th.center{text-align:center;}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:#fafbff;}
    td{padding:10px 14px;color:var(--text);vertical-align:middle;}
    td.center{text-align:center;}
    td.muted{color:var(--text3);}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);}
    .siswa-wrap .sname{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;}
    .siswa-wrap .nis{font-size:12px;color:var(--text3);margin-top:1px;}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-pending{background:#f1f5f9;color:#64748b;}.badge-pending .badge-dot{background:#94a3b8;}
    .badge-diproses{background:#dbeafe;color:#1d4ed8;}.badge-diproses .badge-dot{background:#1d4ed8;}
    .badge-selesai{background:#dcfce7;color:#15803d;}.badge-selesai .badge-dot{background:#15803d;}
    .badge-banding{background:#fef9c3;color:#a16207;}.badge-banding .badge-dot{background:#a16207;}
    .tingkat-ringan{background:#dbeafe;color:#1d4ed8;padding:2px 8px;border-radius:4px;font-size:11.5px;font-weight:700;}
    .tingkat-sedang{background:#fef9c3;color:#a16207;padding:2px 8px;border-radius:4px;font-size:11.5px;font-weight:700;}
    .tingkat-berat{background:#fee2e2;color:#dc2626;padding:2px 8px;border-radius:4px;font-size:11.5px;font-weight:700;}
    .action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap;}
    .empty-state{padding:60px 20px;text-align:center;}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px;}
    .empty-sub{font-size:13px;color:var(--text3);}
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .pag-info{font-size:12.5px;color:var(--text3);}
    .pag-btns{display:flex;gap:4px;align-items:center;}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none;}
    .pag-btn:hover{background:var(--surface2);border-color:var(--border2);}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff;}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;}
    .modal-backdrop{position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:50;display:flex;align-items:center;justify-content:center;padding:20px;}
    .modal-box{background:#fff;border-radius:12px;width:100%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,.18);overflow:hidden;}
    .modal-header{padding:18px 20px 14px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
    .modal-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text);}
    .modal-close{width:28px;height:28px;border:none;background:var(--surface2);border-radius:6px;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text3);}
    .modal-body{padding:20px;}
    .modal-footer{padding:14px 20px;border-top:1px solid var(--border);display:flex;gap:8px;justify-content:flex-end;}
    .m-field{display:flex;flex-direction:column;gap:6px;margin-bottom:12px;}
    .m-field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);}
    .m-field input[type="file"]{padding:8px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-size:13px;background:var(--surface2);width:100%;}
    .m-hint{font-size:12px;color:var(--text3);}
    .btn-cancel-modal{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}.btn-cancel-modal:hover{background:var(--surface3);filter:none;}
    .btn-success{background:#15803d;color:#fff;}
    @media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr;}.page{padding:16px;}.filter-row input{width:100%;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Data Pelanggaran</h1>
            <p class="page-sub">Kelola seluruh catatan pelanggaran siswa — rekam, proses, dan tindak lanjuti</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.pelanggaran.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Catat Pelanggaran
            </a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div><p class="stat-label">Total Kasus</p><p class="stat-val">{{ $stats['total'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div><p class="stat-label">Diproses</p><p class="stat-val">{{ $stats['diproses'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div><p class="stat-label">Bulan Ini</p><p class="stat-val">{{ $stats['bulan_ini'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Selesai</p><p class="stat-val">{{ $stats['selesai'] }}</p></div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.pelanggaran.index') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIS siswa...">
                <select name="kategori_id">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $k)
                    <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
                    <option value="diproses"  {{ request('status') == 'diproses'  ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai"   {{ request('status') == 'selesai'   ? 'selected' : '' }}>Selesai</option>
                    <option value="banding"   {{ request('status') == 'banding'   ? 'selected' : '' }}>Banding</option>
                </select>
                <select name="kelas_id">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kl)
                    <option value="{{ $kl->id }}" {{ request('kelas_id') == $kl->id ? 'selected' : '' }}>{{ $kl->nama_kelas }}</option>
                    @endforeach
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.pelanggaran.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Pelanggaran
                @if($pelanggaran->total())
                <span>— menampilkan {{ $pelanggaran->firstItem() }}–{{ $pelanggaran->lastItem() }} dari {{ $pelanggaran->total() }} data</span>
                @endif
            </p>
            <div class="topbar-actions">
                <a href="{{ route('admin.pelanggaran.export.pdf', request()->query()) }}" class="btn btn-sm btn-export">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.pelanggaran.export.excel', request()->query()) }}" class="btn btn-sm btn-export">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                    Export Excel
                </a>
                <button type="button" class="btn btn-sm btn-import" onclick="document.getElementById('importModal').style.display='flex'">
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
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Kategori</th>
                        <th class="center">Poin</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Dicatat Oleh</th>
                        <th class="center" style="width:180px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggaran as $index => $p)
                    <tr>
                        <td><span class="no-col">{{ $pelanggaran->firstItem() + $index }}</span></td>
                        <td>
                            <div class="siswa-wrap">
                                <p class="sname">{{ $p->siswa->nama_lengkap ?? '—' }}</p>
                                <p class="nis">{{ $p->siswa->nis ?? '' }}</p>
                            </div>
                        </td>
                        <td class="muted" style="font-size:12.5px">{{ $p->siswa->kelas->nama_kelas ?? '—' }}</td>
                        <td>
                            @if($p->kategori)
                            <span style="font-size:13px;font-weight:600;">{{ $p->kategori->nama }}</span><br>
                            <span class="tingkat-{{ $p->kategori->tingkat }}">{{ ucfirst($p->kategori->tingkat) }}</span>
                            @else <span class="muted">—</span>
                            @endif
                        </td>
                        <td class="center">
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:16px;">{{ $p->poin }}</span>
                        </td>
                        <td class="muted" style="font-size:12.5px">{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                        <td>
                            @php $statusMap = ['pending'=>'badge-pending','diproses'=>'badge-diproses','selesai'=>'badge-selesai','banding'=>'badge-banding']; @endphp
                            <span class="badge {{ $statusMap[$p->status] ?? 'badge-pending' }}">
                                <span class="badge-dot"></span>
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td class="muted" style="font-size:12.5px">{{ $p->dicatatOleh->name ?? '—' }}</td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.pelanggaran.show', $p->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('admin.pelanggaran.edit', $p->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('admin.pelanggaran.destroy', $p->id) }}" method="POST" id="delP-{{ $p->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delP-{{ $p->id }}'), '{{ addslashes($p->siswa->nama_lengkap ?? '') }}')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                </div>
                                <p class="empty-title">Belum ada data pelanggaran</p>
                                <p class="empty-sub">Klik "Catat Pelanggaran" untuk menambahkan data pertama</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pelanggaran->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $pelanggaran->firstItem() }} – {{ $pelanggaran->lastItem() }} dari {{ $pelanggaran->total() }} pelanggaran</p>
            <div class="pag-btns">
                @if($pelanggaran->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $pelanggaran->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($pelanggaran->getUrlRange(1, $pelanggaran->lastPage()) as $page => $url)
                    @if($page == $pelanggaran->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $pelanggaran->lastPage() || abs($page - $pelanggaran->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $pelanggaran->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($pelanggaran->hasMorePages())
                    <a href="{{ $pelanggaran->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<div id="importModal" class="modal-backdrop" style="display:none" onclick="if(event.target===this)this.style.display='none'">
    <div class="modal-box">
        <div class="modal-header">
            <span class="modal-title">Import Data Pelanggaran</span>
            <button class="modal-close" onclick="document.getElementById('importModal').style.display='none'">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.pelanggaran.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="m-field">
                    <label>File Excel / CSV <span style="color:#1f63db">*</span></label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required>
                    <span class="m-hint">Format: .xlsx, .xls, atau .csv. Maksimal 2 MB.</span>
                </div>
                <div style="font-size:12px;color:var(--text3);">
                    Belum punya template?
                    <a href="{{ route('admin.pelanggaran.import.template') }}" style="color:var(--brand-600);font-weight:600;text-decoration:none">Download template</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel-modal" onclick="document.getElementById('importModal').style.display='none'">Batal</button>
                <button type="submit" class="btn btn-success">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Import Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });@endif
    @if(session('error'))Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });@endif
    function confirmDelete(form, nama) {
        Swal.fire({
            title:'Hapus Catatan Pelanggaran?',
            html:`Data pelanggaran milik <strong>${nama}</strong> akan dihapus permanen.`,
            icon:'warning', showCancelButton:true,
            confirmButtonColor:'#dc2626', cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal',
        }).then(r => { if(r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>