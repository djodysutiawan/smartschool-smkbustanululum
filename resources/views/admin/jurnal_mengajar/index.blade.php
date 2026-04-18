<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;--brand-100:#d9ebff;--brand-50:#eef6ff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;}
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
    .btn-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-pdf:hover{background:#fee2e2;filter:none;}
    .btn-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-excel:hover{background:#dcfce7;filter:none;}
    .btn-import{background:#fef9c3;color:#a16207;border:1px solid #fde68a;}
    .btn-import:hover{background:#fef3c7;filter:none;}
    .btn-verif{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-verif:hover{background:#dcfce7;filter:none;}

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
    .filter-row input:focus,.filter-row select:focus{border-color:var(--brand-500);}
    .filter-sep{flex:1;}
    .btn-filter{height:34px;padding:0 16px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;}
    .btn-reset{height:34px;padding:0 12px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;}
    .btn-reset:hover{background:var(--surface3);}

    .import-modal{display:none;position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:999;align-items:center;justify-content:center;}
    .import-modal.open{display:flex;}
    .import-box{background:#fff;border-radius:12px;padding:24px;width:420px;max-width:95vw;box-shadow:0 20px 60px rgba(0,0,0,.18);}
    .import-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:16px;color:var(--text);margin-bottom:4px;}
    .import-sub{font-size:13px;color:var(--text3);margin-bottom:16px;}
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
    .two-line .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text);}
    .two-line .secondary{font-size:12px;color:var(--text3);margin-top:1px;}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-ceramah{background:#eff6ff;color:#1d4ed8;}.badge-ceramah .badge-dot{background:#1d4ed8;}
    .badge-diskusi{background:#f0fdf4;color:#15803d;}.badge-diskusi .badge-dot{background:#15803d;}
    .badge-praktikum{background:#fdf4ff;color:#7c3aed;}.badge-praktikum .badge-dot{background:#7c3aed;}
    .badge-demonstrasi{background:#fff7ed;color:#c2410c;}.badge-demonstrasi .badge-dot{background:#c2410c;}
    .badge-proyek{background:#fefce8;color:#a16207;}.badge-proyek .badge-dot{background:#a16207;}
    .badge-lainnya{background:var(--surface3);color:var(--text2);}.badge-lainnya .badge-dot{background:var(--text3);}
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
    @media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Jurnal Mengajar</h1>
            <p class="page-sub">Rekap harian aktivitas mengajar guru di kelas</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.jurnal-mengajar.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Jurnal
            </a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div><p class="stat-label">Total Jurnal</p><p class="stat-val">{{ $jurnal->total() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div><p class="stat-label">Hari Ini</p><p class="stat-val">{{ \App\Models\JurnalMengajar::whereDate('tanggal', today())->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div><p class="stat-label">Guru Aktif</p><p class="stat-val">{{ $guruList->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            </div>
            <div><p class="stat-label">Bulan Ini</p><p class="stat-val">{{ \App\Models\JurnalMengajar::whereMonth('tanggal', now()->month)->count() }}</p></div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.jurnal-mengajar.index') }}">
            <div class="filter-row">
                <select name="guru_id">
                    <option value="">Semua Guru</option>
                    @foreach($guruList as $g)
                        <option value="{{ $g->id }}" {{ request('guru_id')==$g->id?'selected':'' }}>{{ $g->nama_lengkap }}</option>
                    @endforeach
                </select>
                <select name="kelas_id">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id')==$k->id?'selected':'' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <select name="mata_pelajaran_id">
                    <option value="">Semua Mapel</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id }}" {{ request('mata_pelajaran_id')==$m->id?'selected':'' }}>{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>
                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" style="width:148px">
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" style="width:148px">
                <div class="filter-sep"></div>
                <a href="{{ route('admin.jurnal-mengajar.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">Daftar Jurnal Mengajar <span>— {{ $jurnal->total() }} data</span></p>
            <div class="table-actions">
                <a href="{{ route('admin.jurnal-mengajar.export.pdf', request()->query()) }}" class="btn btn-sm btn-pdf" target="_blank">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    PDF
                </a>
                <a href="{{ route('admin.jurnal-mengajar.export.excel', request()->query()) }}" class="btn btn-sm btn-excel">
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
                        <th>Guru / Mapel</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Materi Ajar</th>
                        <th>Metode</th>
                        <th class="center">Hadir</th>
                        <th class="center" style="width:200px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnal as $i => $j)
                    <tr>
                        <td><span class="no-col">{{ $jurnal->firstItem()+$i }}</span></td>
                        <td>
                            <div class="two-line">
                                <p class="primary">{{ $j->guru->nama_lengkap ?? '—' }}</p>
                                <p class="secondary">{{ $j->mataPelajaran->nama_mapel ?? '—' }}</p>
                            </div>
                        </td>
                        <td class="muted" style="font-size:12.5px">{{ $j->kelas->nama_kelas ?? '—' }}</td>
                        <td>
                            <div class="two-line">
                                <p class="primary">{{ \Carbon\Carbon::parse($j->tanggal)->format('d M Y') }}</p>
                                @if($j->pertemuan_ke)<p class="secondary">Pertemuan ke-{{ $j->pertemuan_ke }}</p>@endif
                            </div>
                        </td>
                        <td style="max-width:200px">
                            <p style="font-size:13px;color:var(--text);line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">{{ $j->materi_ajar }}</p>
                        </td>
                        <td>
                            @php $metode = $j->metode_pembelajaran ?? 'lainnya'; @endphp
                            <span class="badge badge-{{ $metode }}"><span class="badge-dot"></span>{{ ucfirst($metode) }}</span>
                        </td>
                        <td class="center">
                            @if($j->jumlah_hadir !== null)
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px">{{ $j->jumlah_hadir }}</span>
                                @if($j->jumlah_tidak_hadir)<span style="font-size:12px;color:var(--text3)"> / {{ $j->jumlah_tidak_hadir }}α</span>@endif
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.jurnal-mengajar.show',$j->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('admin.jurnal-mengajar.edit',$j->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                @if(!$j->sudah_diverifikasi)
                                <form action="{{ route('admin.jurnal-mengajar.verifikasi',$j->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-verif">Verifikasi</button>
                                </form>
                                @endif
                                <form action="{{ route('admin.jurnal-mengajar.destroy',$j->id) }}" method="POST" id="delJ-{{ $j->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delJ-{{ $j->id }}'),'{{ addslashes($j->guru->nama_lengkap ?? '') }}')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8">
                        <div class="empty-state">
                            <div class="empty-icon"><svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                            <p class="empty-title">Belum ada jurnal mengajar</p>
                            <p class="empty-sub">Coba ubah filter atau tambah jurnal baru</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($jurnal->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $jurnal->firstItem() }} – {{ $jurnal->lastItem() }} dari {{ $jurnal->total() }} jurnal</p>
            <div class="pag-btns">
                @if($jurnal->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $jurnal->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($jurnal->getUrlRange(1,$jurnal->lastPage()) as $page => $url)
                    @if($page==$jurnal->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page==1||$page==$jurnal->lastPage()||abs($page-$jurnal->currentPage())<=1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page-$jurnal->currentPage())==2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($jurnal->hasMorePages())
                    <a href="{{ $jurnal->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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
        <p class="import-title">Import Jurnal Mengajar</p>
        <p class="import-sub">Upload file Excel (.xlsx / .xls). <a href="{{ route('admin.jurnal-mengajar.import.template') }}" style="color:var(--brand-600);font-weight:600">Download template</a></p>
        <form action="{{ route('admin.jurnal-mengajar.import') }}" method="POST" enctype="multipart/form-data">
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
    function confirmDelete(form,nama){
        Swal.fire({title:'Hapus Jurnal?',text:`Jurnal milik "${nama}" akan dihapus permanen.`,icon:'warning',showCancelButton:true,confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)form.submit();});
    }
    document.getElementById('importModal').addEventListener('click',function(e){if(e.target===this)this.classList.remove('open');});
</script>
</x-app-layout>