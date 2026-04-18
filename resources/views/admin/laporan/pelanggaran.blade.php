<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;--brand-100:#d9ebff;--brand-50:#eef6ff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;}
    *{box-sizing:border-box;}
    .page{padding:28px 28px 40px;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-outline{background:var(--surface);color:var(--brand-600);border:1px solid var(--brand-100);}
    .btn-outline:hover{background:var(--brand-50);filter:none;}
    .btn-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-pdf:hover{background:#fee2e2;filter:none;}
    .btn-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-excel:hover{background:#dcfce7;filter:none;}
    .btn-sm{padding:5px 11px;font-size:11.5px;border-radius:6px;}
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}.stat-icon.red{background:#fff0f0;}.stat-icon.yellow{background:#fefce8;}.stat-icon.green{background:#f0fdf4;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .chart-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;}
    .chart-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:20px;}
    .chart-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);margin-bottom:16px;display:flex;align-items:center;gap:6px;}
    .bar-list{display:flex;flex-direction:column;gap:10px;}
    .bar-item-label{font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text2);margin-bottom:4px;display:flex;justify-content:space-between;}
    .bar-track{height:8px;background:var(--surface3);border-radius:99px;overflow:hidden;}
    .bar-fill{height:100%;border-radius:99px;transition:width .4s;}
    .bar-fill.red{background:#ef4444;}.bar-fill.orange{background:#f97316;}.bar-fill.yellow{background:#eab308;}.bar-fill.blue{background:var(--brand-600);}.bar-fill.green{background:#22c55e;}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center;}
    .filter-row input,.filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;}
    .filter-row input[type="date"]{width:160px;}
    .filter-row input:focus,.filter-row select:focus{border-color:var(--brand-500);background:#fff;}
    .filter-sep{flex:1;}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;}
    .btn-filter:hover{background:var(--brand-700);}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;}
    .btn-reset:hover{background:var(--surface3);}
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:8px;}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px;}
    .table-actions{display:flex;gap:7px;}
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
    td.muted{color:var(--text3);font-size:12.5px;}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-pending{background:#f1f5f9;color:#64748b;}.badge-pending .badge-dot{background:#64748b;}
    .badge-diproses{background:#dbeafe;color:#1d4ed8;}.badge-diproses .badge-dot{background:#1d4ed8;}
    .badge-selesai{background:#dcfce7;color:#15803d;}.badge-selesai .badge-dot{background:#15803d;}
    .badge-banding{background:#fef9c3;color:#a16207;}.badge-banding .badge-dot{background:#a16207;}
    .tingkat-pill{display:inline-block;padding:2px 9px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;}
    .tingkat-ringan{background:#fefce8;color:#a16207;border:1px solid #fde68a;}
    .tingkat-sedang{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;}
    .tingkat-berat{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .poin-val{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:14px;}
    .poin-val.tinggi{color:#dc2626;}.poin-val.sedang-v{color:#c2410c;}.poin-val.rendah{color:#a16207;}
    .btn-sm-detail{padding:4px 10px;font-size:11.5px;border-radius:6px;background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;text-decoration:none;display:inline-flex;}
    .empty-state{padding:60px 20px;text-align:center;}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px;}
    .empty-sub{font-size:13px;color:var(--text3);}
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .pag-info{font-size:12.5px;color:var(--text3);}
    .pag-btns{display:flex;gap:4px;align-items:center;}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none;}
    .pag-btn:hover{background:var(--surface2);}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff;}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;}
    @media(max-width:900px){.chart-grid{grid-template-columns:1fr;}.stats-strip{grid-template-columns:1fr 1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Pelanggaran</h1>
            <p class="page-sub">Rekap data pelanggaran disiplin siswa — filter berdasarkan periode, siswa, dan kategori</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.pelanggaran.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Catat Pelanggaran
            </a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue"><svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg></div>
            <div><p class="stat-label">Total</p><p class="stat-val">{{ $pelanggaran->total() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
            <div><p class="stat-label">Diproses</p><p class="stat-val">{{ $statsP['diproses'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
            <div><p class="stat-label">Selesai</p><p class="stat-val">{{ $statsP['selesai'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow"><svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
            <div><p class="stat-label">Banding</p><p class="stat-val">{{ $statsP['banding'] }}</p></div>
        </div>
    </div>

    <div class="chart-grid">
        <div class="chart-card">
            <p class="chart-title">Pelanggaran per Tingkat</p>
            <div class="bar-list">
                @php
                    $totalChart = max(\App\Models\Pelanggaran::count(), 1);
                    $berat  = \App\Models\Pelanggaran::whereHas('kategori', fn($q) => $q->where('tingkat','berat'))->count();
                    $sedang = \App\Models\Pelanggaran::whereHas('kategori', fn($q) => $q->where('tingkat','sedang'))->count();
                    $ringan = \App\Models\Pelanggaran::whereHas('kategori', fn($q) => $q->where('tingkat','ringan'))->count();
                @endphp
                @foreach([['Berat', $berat, 'red'], ['Sedang', $sedang, 'orange'], ['Ringan', $ringan, 'yellow']] as [$label, $val, $color])
                <div>
                    <div class="bar-item-label"><span>{{ $label }}</span><span style="font-weight:700">{{ $val }}</span></div>
                    <div class="bar-track"><div class="bar-fill {{ $color }}" style="width:{{ $totalChart > 0 ? round($val/$totalChart*100) : 0 }}%"></div></div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="chart-card">
            <p class="chart-title">Status Pelanggaran</p>
            <div class="bar-list">
                @foreach([['Diproses', $statsP['diproses'], 'blue'], ['Selesai', $statsP['selesai'], 'green'], ['Banding', $statsP['banding'], 'yellow']] as [$label, $val, $color])
                <div>
                    <div class="bar-item-label"><span>{{ $label }}</span><span style="font-weight:700">{{ $val }}</span></div>
                    <div class="bar-track"><div class="bar-fill {{ $color }}" style="width:{{ $totalChart > 0 ? round($val/$totalChart*100) : 0 }}%"></div></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.laporan.pelanggaran') }}">
            <div class="filter-row">
                <select name="siswa_id">
                    <option value="">Semua Siswa</option>
                    @foreach($siswas as $s)
                        <option value="{{ $s->id }}" {{ request('siswa_id') == $s->id ? 'selected' : '' }}>{{ $s->nama_lengkap }}</option>
                    @endforeach
                </select>
                <select name="kategori_id">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="pending"   {{ request('status')=='pending'   ? 'selected':'' }}>Pending</option>
                    <option value="diproses"  {{ request('status')=='diproses'  ? 'selected':'' }}>Diproses</option>
                    <option value="selesai"   {{ request('status')=='selesai'   ? 'selected':'' }}>Selesai</option>
                    <option value="banding"   {{ request('status')=='banding'   ? 'selected':'' }}>Banding</option>
                </select>
                <input type="date" name="tanggal_dari"   value="{{ request('tanggal_dari') }}">
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}">
                <div class="filter-sep"></div>
                <a href="{{ route('admin.laporan.pelanggaran') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Filter</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">Daftar Pelanggaran <span>— {{ $pelanggaran->total() }} data</span></p>
            <div class="table-actions">
                <a href="{{ route('admin.laporan.pelanggaran.export.pdf', request()->query()) }}" class="btn btn-sm btn-pdf" target="_blank">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.laporan.pelanggaran.export.excel', request()->query()) }}" class="btn btn-sm btn-excel">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                    Export Excel
                </a>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr>
                    <th style="width:48px">#</th>
                    <th>Siswa</th>
                    <th>Kategori</th>
                    <th class="center">Tingkat</th>
                    <th class="center">Poin</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Dicatat Oleh</th>
                    <th class="center" style="width:90px">Aksi</th>
                </tr></thead>
                <tbody>
                    @forelse($pelanggaran as $index => $p)
                    <tr>
                        <td><span class="no-col">{{ $pelanggaran->firstItem() + $index }}</span></td>
                        <td>
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px">{{ $p->siswa->nama_lengkap ?? '-' }}</p>
                            <p style="font-size:12px;color:var(--text3)">{{ $p->siswa->nis ?? '' }}</p>
                        </td>
                        <td style="font-size:13px;font-weight:600">{{ $p->kategori->nama ?? '-' }}</td>
                        <td class="center">
                            @if($p->kategori)
                                <span class="tingkat-pill tingkat-{{ $p->kategori->tingkat ?? 'ringan' }}">{{ ucfirst($p->kategori->tingkat ?? '-') }}</span>
                            @else
                                <span class="muted">-</span>
                            @endif
                        </td>
                        <td class="center">
                            <span class="poin-val {{ $p->poin >= 50 ? 'tinggi' : ($p->poin >= 20 ? 'sedang-v' : 'rendah') }}">{{ $p->poin }}</span>
                        </td>
                        <td style="max-width:200px;font-size:13px;color:var(--text2)">{{ Str::limit($p->deskripsi, 60) }}</td>
                        <td class="muted">{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                        <td>
                            <span class="badge badge-{{ $p->status }}">
                                <span class="badge-dot"></span>{{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td class="muted">{{ $p->dicatatOleh->name ?? '-' }}</td>
                        <td class="center">
                            <a href="{{ route('admin.pelanggaran.show', $p->id) }}" class="btn-sm-detail">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="10">
                        <div class="empty-state">
                            <div class="empty-icon"><svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg></div>
                            <p class="empty-title">Tidak ada data pelanggaran</p>
                            <p class="empty-sub">Coba ubah filter atau rentang tanggal</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pelanggaran->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $pelanggaran->firstItem() }}–{{ $pelanggaran->lastItem() }} dari {{ $pelanggaran->total() }} data</p>
            <div class="pag-btns">
                @if($pelanggaran->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $pelanggaran->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($pelanggaran->getUrlRange(1,$pelanggaran->lastPage()) as $page => $url)
                    @if($page==$pelanggaran->currentPage()) <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page==1||$page==$pelanggaran->lastPage()||abs($page-$pelanggaran->currentPage())<=1) <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page-$pelanggaran->currentPage())==2) <span class="pag-ellipsis">…</span>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });@endif
    @if(session('error'))Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });@endif
</script>
</x-app-layout><x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;--brand-100:#d9ebff;--brand-50:#eef6ff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;}
    *{box-sizing:border-box;}
    .page{padding:28px 28px 40px;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-outline{background:var(--surface);color:var(--brand-600);border:1px solid var(--brand-100);}
    .btn-outline:hover{background:var(--brand-50);filter:none;}
    .btn-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-pdf:hover{background:#fee2e2;filter:none;}
    .btn-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-excel:hover{background:#dcfce7;filter:none;}
    .btn-sm{padding:5px 11px;font-size:11.5px;border-radius:6px;}
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}.stat-icon.red{background:#fff0f0;}.stat-icon.yellow{background:#fefce8;}.stat-icon.green{background:#f0fdf4;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .chart-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;}
    .chart-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:20px;}
    .chart-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);margin-bottom:16px;display:flex;align-items:center;gap:6px;}
    .bar-list{display:flex;flex-direction:column;gap:10px;}
    .bar-item-label{font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text2);margin-bottom:4px;display:flex;justify-content:space-between;}
    .bar-track{height:8px;background:var(--surface3);border-radius:99px;overflow:hidden;}
    .bar-fill{height:100%;border-radius:99px;transition:width .4s;}
    .bar-fill.red{background:#ef4444;}.bar-fill.orange{background:#f97316;}.bar-fill.yellow{background:#eab308;}.bar-fill.blue{background:var(--brand-600);}.bar-fill.green{background:#22c55e;}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center;}
    .filter-row input,.filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;}
    .filter-row input[type="date"]{width:160px;}
    .filter-row input:focus,.filter-row select:focus{border-color:var(--brand-500);background:#fff;}
    .filter-sep{flex:1;}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;}
    .btn-filter:hover{background:var(--brand-700);}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;}
    .btn-reset:hover{background:var(--surface3);}
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:8px;}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px;}
    .table-actions{display:flex;gap:7px;}
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
    td.muted{color:var(--text3);font-size:12.5px;}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-pending{background:#f1f5f9;color:#64748b;}.badge-pending .badge-dot{background:#64748b;}
    .badge-diproses{background:#dbeafe;color:#1d4ed8;}.badge-diproses .badge-dot{background:#1d4ed8;}
    .badge-selesai{background:#dcfce7;color:#15803d;}.badge-selesai .badge-dot{background:#15803d;}
    .badge-banding{background:#fef9c3;color:#a16207;}.badge-banding .badge-dot{background:#a16207;}
    .tingkat-pill{display:inline-block;padding:2px 9px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;}
    .tingkat-ringan{background:#fefce8;color:#a16207;border:1px solid #fde68a;}
    .tingkat-sedang{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;}
    .tingkat-berat{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .poin-val{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:14px;}
    .poin-val.tinggi{color:#dc2626;}.poin-val.sedang-v{color:#c2410c;}.poin-val.rendah{color:#a16207;}
    .btn-sm-detail{padding:4px 10px;font-size:11.5px;border-radius:6px;background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;text-decoration:none;display:inline-flex;}
    .empty-state{padding:60px 20px;text-align:center;}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px;}
    .empty-sub{font-size:13px;color:var(--text3);}
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .pag-info{font-size:12.5px;color:var(--text3);}
    .pag-btns{display:flex;gap:4px;align-items:center;}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none;}
    .pag-btn:hover{background:var(--surface2);}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff;}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;}
    @media(max-width:900px){.chart-grid{grid-template-columns:1fr;}.stats-strip{grid-template-columns:1fr 1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Pelanggaran</h1>
            <p class="page-sub">Rekap data pelanggaran disiplin siswa — filter berdasarkan periode, siswa, dan kategori</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.pelanggaran.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Catat Pelanggaran
            </a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue"><svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg></div>
            <div><p class="stat-label">Total</p><p class="stat-val">{{ $pelanggaran->total() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
            <div><p class="stat-label">Diproses</p><p class="stat-val">{{ $statsP['diproses'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
            <div><p class="stat-label">Selesai</p><p class="stat-val">{{ $statsP['selesai'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow"><svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
            <div><p class="stat-label">Banding</p><p class="stat-val">{{ $statsP['banding'] }}</p></div>
        </div>
    </div>

    <div class="chart-grid">
        <div class="chart-card">
            <p class="chart-title">Pelanggaran per Tingkat</p>
            <div class="bar-list">
                @php
                    $totalChart = max(\App\Models\Pelanggaran::count(), 1);
                    $berat  = \App\Models\Pelanggaran::whereHas('kategori', fn($q) => $q->where('tingkat','berat'))->count();
                    $sedang = \App\Models\Pelanggaran::whereHas('kategori', fn($q) => $q->where('tingkat','sedang'))->count();
                    $ringan = \App\Models\Pelanggaran::whereHas('kategori', fn($q) => $q->where('tingkat','ringan'))->count();
                @endphp
                @foreach([['Berat', $berat, 'red'], ['Sedang', $sedang, 'orange'], ['Ringan', $ringan, 'yellow']] as [$label, $val, $color])
                <div>
                    <div class="bar-item-label"><span>{{ $label }}</span><span style="font-weight:700">{{ $val }}</span></div>
                    <div class="bar-track"><div class="bar-fill {{ $color }}" style="width:{{ $totalChart > 0 ? round($val/$totalChart*100) : 0 }}%"></div></div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="chart-card">
            <p class="chart-title">Status Pelanggaran</p>
            <div class="bar-list">
                @foreach([['Diproses', $statsP['diproses'], 'blue'], ['Selesai', $statsP['selesai'], 'green'], ['Banding', $statsP['banding'], 'yellow']] as [$label, $val, $color])
                <div>
                    <div class="bar-item-label"><span>{{ $label }}</span><span style="font-weight:700">{{ $val }}</span></div>
                    <div class="bar-track"><div class="bar-fill {{ $color }}" style="width:{{ $totalChart > 0 ? round($val/$totalChart*100) : 0 }}%"></div></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.laporan.pelanggaran') }}">
            <div class="filter-row">
                <select name="siswa_id">
                    <option value="">Semua Siswa</option>
                    @foreach($siswas as $s)
                        <option value="{{ $s->id }}" {{ request('siswa_id') == $s->id ? 'selected' : '' }}>{{ $s->nama_lengkap }}</option>
                    @endforeach
                </select>
                <select name="kategori_id">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="pending"   {{ request('status')=='pending'   ? 'selected':'' }}>Pending</option>
                    <option value="diproses"  {{ request('status')=='diproses'  ? 'selected':'' }}>Diproses</option>
                    <option value="selesai"   {{ request('status')=='selesai'   ? 'selected':'' }}>Selesai</option>
                    <option value="banding"   {{ request('status')=='banding'   ? 'selected':'' }}>Banding</option>
                </select>
                <input type="date" name="tanggal_dari"   value="{{ request('tanggal_dari') }}">
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}">
                <div class="filter-sep"></div>
                <a href="{{ route('admin.laporan.pelanggaran') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Filter</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">Daftar Pelanggaran <span>— {{ $pelanggaran->total() }} data</span></p>
            <div class="table-actions">
                <a href="{{ route('admin.laporan.pelanggaran.export.pdf', request()->query()) }}" class="btn btn-sm btn-pdf" target="_blank">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.laporan.pelanggaran.export.excel', request()->query()) }}" class="btn btn-sm btn-excel">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                    Export Excel
                </a>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr>
                    <th style="width:48px">#</th>
                    <th>Siswa</th>
                    <th>Kategori</th>
                    <th class="center">Tingkat</th>
                    <th class="center">Poin</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Dicatat Oleh</th>
                    <th class="center" style="width:90px">Aksi</th>
                </tr></thead>
                <tbody>
                    @forelse($pelanggaran as $index => $p)
                    <tr>
                        <td><span class="no-col">{{ $pelanggaran->firstItem() + $index }}</span></td>
                        <td>
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px">{{ $p->siswa->nama_lengkap ?? '-' }}</p>
                            <p style="font-size:12px;color:var(--text3)">{{ $p->siswa->nis ?? '' }}</p>
                        </td>
                        <td style="font-size:13px;font-weight:600">{{ $p->kategori->nama ?? '-' }}</td>
                        <td class="center">
                            @if($p->kategori)
                                <span class="tingkat-pill tingkat-{{ $p->kategori->tingkat ?? 'ringan' }}">{{ ucfirst($p->kategori->tingkat ?? '-') }}</span>
                            @else
                                <span class="muted">-</span>
                            @endif
                        </td>
                        <td class="center">
                            <span class="poin-val {{ $p->poin >= 50 ? 'tinggi' : ($p->poin >= 20 ? 'sedang-v' : 'rendah') }}">{{ $p->poin }}</span>
                        </td>
                        <td style="max-width:200px;font-size:13px;color:var(--text2)">{{ Str::limit($p->deskripsi, 60) }}</td>
                        <td class="muted">{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                        <td>
                            <span class="badge badge-{{ $p->status }}">
                                <span class="badge-dot"></span>{{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td class="muted">{{ $p->dicatatOleh->name ?? '-' }}</td>
                        <td class="center">
                            <a href="{{ route('admin.pelanggaran.show', $p->id) }}" class="btn-sm-detail">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="10">
                        <div class="empty-state">
                            <div class="empty-icon"><svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg></div>
                            <p class="empty-title">Tidak ada data pelanggaran</p>
                            <p class="empty-sub">Coba ubah filter atau rentang tanggal</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pelanggaran->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $pelanggaran->firstItem() }}–{{ $pelanggaran->lastItem() }} dari {{ $pelanggaran->total() }} data</p>
            <div class="pag-btns">
                @if($pelanggaran->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $pelanggaran->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($pelanggaran->getUrlRange(1,$pelanggaran->lastPage()) as $page => $url)
                    @if($page==$pelanggaran->currentPage()) <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page==1||$page==$pelanggaran->lastPage()||abs($page-$pelanggaran->currentPage())<=1) <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page-$pelanggaran->currentPage())==2) <span class="pag-ellipsis">…</span>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });@endif
    @if(session('error'))Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });@endif
</script>
</x-app-layout>