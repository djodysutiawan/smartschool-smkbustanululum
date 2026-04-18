<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;--brand-100:#d9ebff;--brand-50:#eef6ff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;}
    .page{padding:28px 28px 40px;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px;}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}.btn-detail:hover{background:#dcfce7;filter:none;}
    .btn-nonaktif{background:#fefce8;color:#a16207;border:1px solid #fde68a;}.btn-nonaktif:hover{background:#fef9c3;filter:none;}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}.btn-del:hover{background:#fee2e2;filter:none;}
    .btn-export-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}.btn-export-pdf:hover{background:#fee2e2;filter:none;}
    .btn-export-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}.btn-export-excel:hover{background:#dcfce7;filter:none;}
    .stats-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}
    .stat-icon.green{background:#f0fdf4;}
    .stat-icon.yellow{background:#fefce8;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;margin-bottom:16px;}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center;}
    .filter-row select,.filter-row input[type=date]{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;}
    .filter-row select:focus,.filter-row input:focus{border-color:var(--brand-500);background:#fff;}
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
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-aktif{background:#dcfce7;color:#15803d;}.badge-aktif .badge-dot{background:#15803d;}
    .badge-nonaktif{background:#fee2e2;color:#dc2626;}.badge-nonaktif .badge-dot{background:#dc2626;}
    .badge-kadaluarsa{background:#fef9c3;color:#a16207;}.badge-kadaluarsa .badge-dot{background:#a16207;}
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
    @media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Sesi QR Code Absensi</h1>
            <p class="page-sub">Buat dan kelola sesi QR untuk absensi siswa via scan</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.sesi-qr.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buat Sesi QR
            </a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h.01M14 17h.01M17 14h.01M17 17h.01M20 14h.01M20 17h.01M20 20h.01M17 20h.01M14 20h.01"/></svg>
            </div>
            <div><p class="stat-label">Total Sesi</p><p class="stat-val">{{ $sesiQrs->total() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Sesi Aktif</p>
                <p class="stat-val">{{ \App\Models\SesiQr::where('is_active', true)->where('berlaku_mulai', '<=', now())->where('kadaluarsa_pada', '>=', now())->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
                <p class="stat-label">Kadaluarsa / Nonaktif</p>
                <p class="stat-val">{{ \App\Models\SesiQr::where(fn($q) => $q->where('is_active', false)->orWhere('kadaluarsa_pada', '<', now()))->count() }}</p>
            </div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.sesi-qr.index') }}">
            <div class="filter-row">
                <select name="kelas_id">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" title="Filter Tanggal">
                <select name="is_active">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.sesi-qr.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Sesi QR
                @if($sesiQrs->total())
                <span>— {{ $sesiQrs->firstItem() }}–{{ $sesiQrs->lastItem() }} dari {{ $sesiQrs->total() }} sesi</span>
                @endif
            </p>
            <div class="topbar-actions">
                <a href="{{ route('admin.sesi-qr.export.pdf', request()->query()) }}" class="btn btn-sm btn-export-pdf">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    PDF
                </a>
                <a href="{{ route('admin.sesi-qr.export.excel', request()->query()) }}" class="btn btn-sm btn-export-excel">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                    Excel
                </a>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Tanggal</th>
                        <th>Berlaku</th>
                        <th>Kadaluarsa</th>
                        <th>Radius (m)</th>
                        <th>Status</th>
                        <th>Dibuat Oleh</th>
                        <th class="center" style="width:210px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sesiQrs as $i => $sq)
                    @php
                        $now        = \Carbon\Carbon::now();
                        $aktif      = $sq->is_active && $now->between($sq->berlaku_mulai, $sq->kadaluarsa_pada);
                        $kadaluarsa = $now->gt($sq->kadaluarsa_pada);
                    @endphp
                    <tr>
                        <td><span class="no-col">{{ $sesiQrs->firstItem() + $i }}</span></td>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px">{{ $sq->kelas->nama_kelas ?? '—' }}</td>
                        <td style="font-size:13px;color:var(--text2)">{{ $sq->mataPelajaran->nama_mapel ?? '—' }}</td>
                        <td style="font-size:12.5px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600">
                            {{ \Carbon\Carbon::parse($sq->tanggal)->isoFormat('D MMM Y') }}
                        </td>
                        <td class="muted" style="font-size:12px">{{ \Carbon\Carbon::parse($sq->berlaku_mulai)->format('H:i') }}</td>
                        <td class="muted" style="font-size:12px">{{ \Carbon\Carbon::parse($sq->kadaluarsa_pada)->format('H:i') }}</td>
                        <td class="muted" style="font-size:12.5px;text-align:center">{{ $sq->radius_meter ?? '—' }}</td>
                        <td>
                            @if(!$sq->is_active)
                                <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                            @elseif($kadaluarsa)
                                <span class="badge badge-kadaluarsa"><span class="badge-dot"></span>Kadaluarsa</span>
                            @elseif($aktif)
                                <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                            @else
                                <span class="badge" style="background:var(--surface3);color:var(--text3)">Menunggu</span>
                            @endif
                        </td>
                        <td class="muted" style="font-size:12px">{{ $sq->dibuatOleh->name ?? '—' }}</td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.sesi-qr.show', $sq->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('admin.sesi-qr.cetak-qr', $sq->id) }}" class="btn btn-sm" style="background:var(--brand-50);color:var(--brand-600);border:1px solid var(--brand-100);" target="_blank">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                                    Cetak
                                </a>
                                @if($sq->is_active && !$kadaluarsa)
                                <form action="{{ route('admin.sesi-qr.nonaktifkan', $sq->id) }}" method="POST" id="nonaktifForm-{{ $sq->id }}">
                                    @csrf @method('PATCH')
                                    <button type="button" class="btn btn-sm btn-nonaktif"
                                        onclick="confirmNonaktif(document.getElementById('nonaktifForm-{{ $sq->id }}'))">
                                        Nonaktifkan
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('admin.sesi-qr.destroy', $sq->id) }}" method="POST" id="delForm-{{ $sq->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delForm-{{ $sq->id }}'))">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                                </div>
                                <p class="empty-title">Belum ada sesi QR</p>
                                <p class="empty-sub">Buat sesi QR baru untuk memulai absensi via scan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sesiQrs->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $sesiQrs->firstItem() }} – {{ $sesiQrs->lastItem() }} dari {{ $sesiQrs->total() }} sesi</p>
            <div class="pag-btns">
                @if($sesiQrs->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $sesiQrs->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($sesiQrs->getUrlRange(1, $sesiQrs->lastPage()) as $page => $url)
                    @if($page == $sesiQrs->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $sesiQrs->lastPage() || abs($page - $sesiQrs->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $sesiQrs->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($sesiQrs->hasMorePages())
                    <a href="{{ $sesiQrs->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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
    Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
    @endif
    @if(session('error'))
    Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
    @endif
    function confirmNonaktif(form) {
        Swal.fire({title:'Nonaktifkan Sesi QR?',text:'Sesi ini tidak dapat digunakan lagi untuk scan.',icon:'warning',showCancelButton:true,confirmButtonColor:'#a16207',cancelButtonColor:'#64748b',confirmButtonText:'Ya, Nonaktifkan!',cancelButtonText:'Batal'})
            .then(r => { if (r.isConfirmed) form.submit(); });
    }
    function confirmDelete(form) {
        Swal.fire({title:'Hapus Sesi QR?',text:'Data sesi QR ini akan dihapus permanen.',icon:'warning',showCancelButton:true,confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal'})
            .then(r => { if (r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>