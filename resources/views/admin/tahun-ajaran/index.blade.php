<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;
        --yellow:#a16207;--yellow-bg:#fefce8;--yellow-border:#fde68a;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box;}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto;}

    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand);color:#fff;}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px;}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}
    .btn-edit:hover{background:var(--brand-100);filter:none;}
    .btn-del{background:#fff0f0;color:var(--red);border:1px solid var(--red-border);}
    .btn-del:hover{background:var(--red-bg);filter:none;}
    .btn-detail{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border);}
    .btn-detail:hover{background:#dcfce7;filter:none;}
    .btn-aktif{background:var(--yellow-bg);color:var(--yellow);border:1px solid var(--yellow-border);}
    .btn-aktif:hover{background:#fef9c3;filter:none;}
    .btn-pdf{background:#fff0f0;color:var(--red);border:1px solid var(--red-border);}
    .btn-pdf:hover{background:var(--red-bg);filter:none;}
    .btn-excel{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border);}
    .btn-excel:hover{background:#dcfce7;filter:none;}
    .btn-import{background:var(--yellow-bg);color:var(--yellow);border:1px solid var(--yellow-border);}
    .btn-import:hover{background:#fef9c3;filter:none;}

    .stats-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}
    .stat-icon.green{background:var(--green-bg);}
    .stat-icon.gray{background:var(--surface3);}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .stat-val-sm{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text);line-height:1.3;margin-top:1px;}

    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center;}
    .filter-row input,.filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;}
    .filter-row input{min-width:200px;}
    .filter-row input:focus,.filter-row select:focus{border-color:var(--brand-h);background:#fff;}
    .filter-row input::placeholder{color:var(--text3);}
    .filter-sep{flex:1;}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:6px;}
    .btn-filter:hover{background:var(--brand-700);}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;}
    .btn-reset:hover{background:var(--surface3);}

    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);gap:12px;flex-wrap:wrap;}
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
    tbody tr.aktif-row{background:#f0fdf4;}
    tbody tr.aktif-row:hover{background:#dcfce7;}
    td{padding:10px 14px;color:var(--text);vertical-align:middle;}
    td.center{text-align:center;}
    td.muted{color:var(--text3);}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-aktif{background:#dcfce7;color:var(--green);}
    .badge-aktif .badge-dot{background:var(--green);}
    .badge-nonaktif{background:var(--surface3);color:#64748b;}
    .badge-nonaktif .badge-dot{background:#94a3b8;}
    .pill{display:inline-block;padding:2px 9px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;}
    .pill-ganjil{background:#eef2ff;color:#4338ca;border:1px solid #c7d2fe;}
    .pill-genap{background:#fdf4ff;color:#7c3aed;border:1px solid #e9d5ff;}
    .tag-aktif{display:inline-block;background:var(--brand);color:#fff;font-size:9.5px;font-weight:800;padding:1px 6px;border-radius:4px;margin-left:5px;font-family:'Plus Jakarta Sans',sans-serif;letter-spacing:.03em;vertical-align:middle;}

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
    .pag-btn.active{background:var(--brand);border-color:var(--brand);color:#fff;}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;}

    .modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:999;display:flex;align-items:center;justify-content:center;padding:20px;}
    .modal-box{background:#fff;border-radius:12px;padding:28px;width:100%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,.2);}
    .modal-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:800;color:var(--text);margin-bottom:6px;}
    .modal-sub{font-size:13px;color:var(--text2);margin-bottom:20px;line-height:1.6;}
    .modal-footer{display:flex;justify-content:flex-end;gap:8px;}
    .btn-modal-cancel{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
    .btn-modal-submit{background:var(--brand);color:#fff;}

    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;}
    .alert-success{background:#f0fdf4;color:var(--green);border:1px solid var(--green-border);}
    .alert-error{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border);}

    @media(max-width:640px){
        .stats-strip{grid-template-columns:1fr 1fr;}
        .page{padding:16px;}
        .filter-row input{min-width:100%;width:100%;}
    }
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Tahun Ajaran</h1>
            <p class="page-sub">Kelola data tahun ajaran dan semester — tambah, edit, aktifkan, dan hapus</p>
        </div>
        <a href="{{ route('admin.tahun-ajaran.create') }}" class="btn btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Tahun Ajaran
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Total</p>
                <p class="stat-val">{{ $stats['total'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Aktif Sekarang</p>
                <p class="stat-val-sm">{{ $aktif ? $aktif->label : '—' }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon gray">
                <svg width="18" height="18" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            </div>
            <div>
                <p class="stat-label">Tidak Aktif</p>
                <p class="stat-val">{{ $stats['tidak_aktif'] }}</p>
            </div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.tahun-ajaran.index') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tahun ajaran...">
                <select name="semester">
                    <option value="">Semua Semester</option>
                    <option value="ganjil" {{ request('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="genap"  {{ request('semester') == 'genap'  ? 'selected' : '' }}>Genap</option>
                </select>
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="aktif"       {{ request('status') == 'aktif'       ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Terapkan
                </button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Tahun Ajaran
                @if($tahunAjaran->total())
                <span>— {{ $tahunAjaran->firstItem() }}–{{ $tahunAjaran->lastItem() }} dari {{ $tahunAjaran->total() }} data</span>
                @endif
            </p>
            <div class="topbar-actions">
                <a href="{{ route('admin.tahun-ajaran.export-pdf') }}" class="btn btn-sm btn-pdf">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    PDF
                </a>
                <a href="{{ route('admin.tahun-ajaran.export-excel') }}" class="btn btn-sm btn-excel">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="16" y2="17"/></svg>
                    Excel
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
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th style="max-width:160px">Keterangan</th>
                        <th class="center" style="width:220px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tahunAjaran as $index => $ta)
                    <tr class="{{ $ta->status === 'aktif' ? 'aktif-row' : '' }}">
                        <td><span class="no-col">{{ $tahunAjaran->firstItem() + $index }}</span></td>
                        <td>
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;">{{ $ta->tahun }}</span>
                            @if($ta->status === 'aktif')
                            <span class="tag-aktif">AKTIF</span>
                            @endif
                        </td>
                        <td>
                            <span class="pill pill-{{ $ta->semester }}">{{ ucfirst($ta->semester) }}</span>
                        </td>
                        <td class="muted" style="font-size:12.5px;">{{ $ta->tanggal_mulai->format('d M Y') }}</td>
                        <td class="muted" style="font-size:12.5px;">{{ $ta->tanggal_selesai->format('d M Y') }}</td>
                        <td class="muted" style="font-size:12.5px;">{{ $ta->durasi }}</td>
                        <td>
                            @if($ta->status === 'aktif')
                                <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                            @else
                                <span class="badge badge-nonaktif"><span class="badge-dot"></span>Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="muted" style="font-size:12.5px;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $ta->keterangan }}">
                            {{ $ta->keterangan ?? '—' }}
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.tahun-ajaran.show', $ta->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('admin.tahun-ajaran.edit', $ta->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                @if($ta->status !== 'aktif')
                                <form action="{{ route('admin.tahun-ajaran.aktifkan', $ta->id) }}" method="POST" id="aktifForm-{{ $ta->id }}">
                                    @csrf @method('PATCH')
                                    <button type="button" class="btn btn-sm btn-aktif"
                                        onclick="confirmAktifkan(document.getElementById('aktifForm-{{ $ta->id }}'), '{{ addslashes($ta->tahun) }}')">
                                        Aktifkan
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('admin.tahun-ajaran.destroy', $ta->id) }}" method="POST" id="delForm-{{ $ta->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delForm-{{ $ta->id }}'), '{{ addslashes($ta->tahun) }}')">
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
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                </div>
                                <p class="empty-title">Belum ada data tahun ajaran</p>
                                <p class="empty-sub">Klik "Tambah Tahun Ajaran" untuk menambahkan data pertama</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tahunAjaran->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $tahunAjaran->firstItem() }}–{{ $tahunAjaran->lastItem() }} dari {{ $tahunAjaran->total() }} data</p>
            <div class="pag-btns">
                @if($tahunAjaran->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $tahunAjaran->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($tahunAjaran->getUrlRange(1, $tahunAjaran->lastPage()) as $page => $url)
                    @if($page == $tahunAjaran->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $tahunAjaran->lastPage() || abs($page - $tahunAjaran->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $tahunAjaran->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($tahunAjaran->hasMorePages())
                    <a href="{{ $tahunAjaran->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Modal Import --}}
<div class="modal-overlay" id="modalImport" style="display:none" onclick="if(event.target===this)this.style.display='none'">
    <div class="modal-box">
        <p class="modal-title">Import Data Tahun Ajaran</p>
        <p class="modal-sub">Unggah file Excel (.xlsx / .xls) atau CSV. Pastikan format kolom sesuai template.</p>
        <form action="{{ route('admin.tahun-ajaran.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:#475569;display:block;margin-bottom:6px;">
                    File Import <span style="color:#dc2626">*</span>
                </label>
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                    style="width:100%;padding:8px 12px;border:1px solid #e2e8f0;border-radius:7px;font-family:'DM Sans',sans-serif;font-size:13px;background:#f8fafc;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-modal-cancel" onclick="document.getElementById('modalImport').style.display='none'">Batal</button>
                <button type="submit" class="btn btn-modal-submit">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Import Sekarang
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
    @if(session('warning'))
    Swal.fire({ icon:'warning', title:'Perhatian', text:@json(session('warning')), confirmButtonColor:'#1f63db' });
    @endif

    function confirmDelete(form, nama) {
        Swal.fire({
            title: 'Hapus Tahun Ajaran?',
            text: `Data "${nama}" akan dihapus permanen dan tidak dapat dikembalikan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }

    function confirmAktifkan(form, nama) {
        Swal.fire({
            title: 'Aktifkan Tahun Ajaran?',
            text: `"${nama}" akan dijadikan tahun ajaran aktif. Tahun ajaran lain akan dinonaktifkan secara otomatis.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1f63db',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Aktifkan!',
            cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>