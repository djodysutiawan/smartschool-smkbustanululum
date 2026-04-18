<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box;}
    .page{padding:28px 28px 40px;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px;}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}
    .btn-edit:hover{background:var(--brand-100);filter:none;}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-del:hover{background:#fee2e2;filter:none;}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-detail:hover{background:#dcfce7;filter:none;}
    .btn-toggle-on{background:#fef9c3;color:#a16207;border:1px solid #fde68a;}
    .btn-toggle-on:hover{background:#fef3c7;filter:none;}
    .btn-toggle-off{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-toggle-off:hover{background:#dcfce7;filter:none;}
    .btn-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-pdf:hover{background:#fee2e2;filter:none;}
    .btn-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-excel:hover{background:#dcfce7;filter:none;}
    .btn-import{background:#fef9c3;color:#a16207;border:1px solid #fde68a;}
    .btn-import:hover{background:#fef3c7;filter:none;}

    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}
    .stat-icon.green{background:#f0fdf4;}
    .stat-icon.purple{background:#fdf4ff;}
    .stat-icon.orange{background:#fff7ed;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}

    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;margin-bottom:14px;}
    .filter-row{display:flex;flex-wrap:wrap;gap:8px;align-items:center;}
    .filter-row input,.filter-row select{height:34px;padding:0 10px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;}
    .filter-row input{width:180px;}
    .filter-row input:focus,.filter-row select:focus{border-color:var(--brand-500);}
    .filter-row input::placeholder{color:var(--text3);}
    .filter-sep{flex:1;}
    .btn-filter{height:34px;padding:0 16px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;}
    .btn-filter:hover{background:var(--brand-700);}
    .btn-reset{height:34px;padding:0 12px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;}
    .btn-reset:hover{background:var(--surface3);}

    .import-modal{display:none;position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:999;align-items:center;justify-content:center;}
    .import-modal.open{display:flex;}
    .import-box{background:#fff;border-radius:12px;padding:24px;width:420px;max-width:95vw;box-shadow:0 20px 60px rgba(0,0,0,.18);}
    .import-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:16px;color:var(--text);margin-bottom:6px;}
    .import-sub{font-size:13px;color:var(--text3);margin-bottom:18px;}
    .import-field{display:flex;flex-direction:column;gap:6px;margin-bottom:16px;}
    .import-field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);}
    .import-field input[type=file]{padding:8px;border:1.5px dashed var(--border2);border-radius:var(--radius-sm);background:var(--surface2);font-size:13px;}
    .import-actions{display:flex;gap:8px;justify-content:flex-end;}
    .btn-modal-cancel{padding:8px 18px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;}
    .btn-modal-submit{padding:8px 20px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;}

    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:12px 18px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:8px;}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px;}
    .table-actions{display:flex;gap:6px;align-items:center;}
    .table-wrap{overflow-x:auto;}
    table{width:100%;border-collapse:collapse;font-size:13.5px;}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    thead th{padding:10px 13px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
    thead th.center{text-align:center;}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:#fafbff;}
    td{padding:10px 13px;color:var(--text);vertical-align:middle;}
    td.center{text-align:center;}
    td.muted{color:var(--text3);}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);}
    .ujian-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text);}
    .ujian-sub{font-size:12px;color:var(--text3);margin-top:1px;}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-aktif{background:#dcfce7;color:#15803d;}.badge-aktif .badge-dot{background:#15803d;}
    .badge-nonaktif{background:#fee2e2;color:#dc2626;}.badge-nonaktif .badge-dot{background:#dc2626;}
    .jenis-pill{display:inline-block;padding:2px 9px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;}
    .jenis-ulangan_harian{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;}
    .jenis-uts{background:#fdf4ff;color:#7e22ce;border:1px solid #e9d5ff;}
    .jenis-uas{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;}
    .jenis-remedial{background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;}
    .jenis-quiz{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .action-group{display:flex;align-items:center;gap:4px;justify-content:center;flex-wrap:wrap;}
    .empty-state{padding:50px 20px;text-align:center;}
    .empty-icon{width:52px;height:52px;background:var(--surface2);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:4px;}
    .empty-sub{font-size:13px;color:var(--text3);}
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:13px 18px;border-top:1px solid var(--border);flex-wrap:wrap;gap:8px;}
    .pag-info{font-size:12.5px;color:var(--text3);}
    .pag-btns{display:flex;gap:4px;align-items:center;}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none;}
    .pag-btn:hover{background:var(--surface2);}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff;}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;}
    @media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr;}.page{padding:16px;}.filter-row input{width:100%;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Data Ujian</h1>
            <p class="page-sub">Kelola ujian — ulangan harian, UTS, UAS, remedial, dan quiz</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.ujian.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Ujian
            </a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            </div>
            <div><p class="stat-label">Total</p><p class="stat-val">{{ $ujian->total() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Aktif</p><p class="stat-val">{{ \App\Models\Ujian::where('is_active',true)->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            </div>
            <div><p class="stat-label">UTS/UAS</p><p class="stat-val">{{ \App\Models\Ujian::whereIn('jenis',['uts','uas'])->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#ea580c" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div><p class="stat-label">Hari Ini</p><p class="stat-val">{{ \App\Models\Ujian::whereDate('tanggal', today())->count() }}</p></div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.ujian.index') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul ujian…">
                <select name="tahun_ajaran_id">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach($tahunAjaran as $ta)
                        <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id')==$ta->id?'selected':'' }}>{{ $ta->tahun }} - {{ ucfirst($ta->semester) }}</option>
                    @endforeach
                </select>
                <select name="kelas_id">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id')==$k->id?'selected':'' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <select name="guru_id">
                    <option value="">Semua Guru</option>
                    @foreach($guruList as $g)
                        <option value="{{ $g->id }}" {{ request('guru_id')==$g->id?'selected':'' }}>{{ $g->nama_lengkap }}</option>
                    @endforeach
                </select>
                <select name="jenis">
                    <option value="">Semua Jenis</option>
                    @foreach($jenisList as $j)
                        <option value="{{ $j }}" {{ request('jenis')==$j?'selected':'' }}>{{ strtoupper(str_replace('_',' ',$j)) }}</option>
                    @endforeach
                </select>
                <select name="is_active">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_active')==='1'?'selected':'' }}>Aktif</option>
                    <option value="0" {{ request('is_active')==='0'?'selected':'' }}>Nonaktif</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.ujian.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">Daftar Ujian <span>— {{ $ujian->total() }} data</span></p>
            <div class="table-actions">
                <a href="{{ route('admin.ujian.export.pdf', request()->query()) }}" class="btn btn-sm btn-pdf" target="_blank">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    PDF
                </a>
                <a href="{{ route('admin.ujian.export.excel', request()->query()) }}" class="btn btn-sm btn-excel">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Excel
                </a>
                <button type="button" class="btn btn-sm btn-import" onclick="document.getElementById('importModal').classList.add('open')">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                    Import
                </button>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:44px">#</th>
                        <th>Judul / Mapel</th>
                        <th>Jenis</th>
                        <th>Kelas</th>
                        <th>Guru</th>
                        <th>Tanggal</th>
                        <th class="center">Durasi</th>
                        <th class="center">KKM</th>
                        <th class="center">Status</th>
                        <th class="center" style="width:210px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ujian as $i => $u)
                    <tr>
                        <td><span class="no-col">{{ $ujian->firstItem()+$i }}</span></td>
                        <td>
                            <p class="ujian-title">{{ $u->judul }}</p>
                            <p class="ujian-sub">{{ $u->mataPelajaran->nama_mapel ?? '-' }}</p>
                        </td>
                        <td>
                            <span class="jenis-pill jenis-{{ $u->jenis }}">{{ strtoupper(str_replace('_',' ',$u->jenis)) }}</span>
                        </td>
                        <td class="muted" style="font-size:12.5px">{{ $u->kelas->nama_kelas ?? '-' }}</td>
                        <td class="muted" style="font-size:12.5px">{{ $u->guru->nama_lengkap ?? '-' }}</td>
                        <td class="muted" style="font-size:12.5px">
                            {{ \Carbon\Carbon::parse($u->tanggal)->format('d M Y') }}<br>
                            <span style="font-size:11.5px">{{ $u->jam_mulai }}</span>
                        </td>
                        <td class="center muted" style="font-size:12.5px">{{ $u->durasi_menit }} mnt</td>
                        <td class="center muted" style="font-size:12.5px">{{ $u->nilai_kkm ?? '-' }}</td>
                        <td class="center">
                            @if($u->is_active)
                                <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                            @else
                                <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.ujian.show',$u->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('admin.ujian.edit',$u->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('admin.ujian.toggle-status',$u->id) }}" method="POST" id="toggleForm-{{ $u->id }}">
                                    @csrf @method('PATCH')
                                    <button type="button" class="btn btn-sm {{ $u->is_active ? 'btn-toggle-on' : 'btn-toggle-off' }}"
                                        onclick="confirmToggle(document.getElementById('toggleForm-{{ $u->id }}'),'{{ addslashes($u->judul) }}',{{ $u->is_active ? 'true' : 'false' }})">
                                        {{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.ujian.destroy',$u->id) }}" method="POST" id="deleteForm-{{ $u->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('deleteForm-{{ $u->id }}'),'{{ addslashes($u->judul) }}')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="10">
                        <div class="empty-state">
                            <div class="empty-icon"><svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></div>
                            <p class="empty-title">Tidak ada data ujian</p>
                            <p class="empty-sub">Coba ubah filter atau tambah ujian baru</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($ujian->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $ujian->firstItem() }} – {{ $ujian->lastItem() }} dari {{ $ujian->total() }} ujian</p>
            <div class="pag-btns">
                @if($ujian->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $ujian->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($ujian->getUrlRange(1,$ujian->lastPage()) as $page => $url)
                    @if($page==$ujian->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page==1||$page==$ujian->lastPage()||abs($page-$ujian->currentPage())<=1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page-$ujian->currentPage())==2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($ujian->hasMorePages())
                    <a href="{{ $ujian->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<div class="import-modal" id="importModal">
    <div class="import-box">
        <p class="import-title">Import Data Ujian</p>
        <p class="import-sub">Upload file Excel (.xlsx / .xls). <a href="{{ route('admin.ujian.import.template') }}" style="color:var(--brand-600);font-weight:600">Download template</a></p>
        <form action="{{ route('admin.ujian.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="import-field">
                <label>File Excel <span style="color:#dc2626">*</span></label>
                <input type="file" name="file" accept=".xlsx,.xls" required>
            </div>
            <div class="import-actions">
                <button type="button" class="btn-modal-cancel" onclick="document.getElementById('importModal').classList.remove('open')">Batal</button>
                <button type="submit" class="btn-modal-submit">Upload & Import</button>
            </div>
        </form>
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

    function confirmDelete(form, nama) {
        Swal.fire({title:'Hapus Ujian?',text:`Ujian "${nama}" akan dihapus.`,icon:'warning',showCancelButton:true,confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)form.submit();});
    }
    function confirmToggle(form, nama, isActive) {
        const action = isActive ? 'Nonaktifkan' : 'Aktifkan';
        Swal.fire({title:`${action} Ujian?`,text:`Ujian "${nama}" akan di${action.toLowerCase()}.`,icon:'question',showCancelButton:true,confirmButtonColor:'#1f63db',cancelButtonColor:'#64748b',confirmButtonText:`Ya, ${action}!`,cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)form.submit();});
    }

    document.getElementById('importModal').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });
</script>
</x-app-layout>