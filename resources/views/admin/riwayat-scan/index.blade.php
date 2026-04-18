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
    .page{padding:28px 28px 40px;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px;}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}.btn-detail:hover{background:#dcfce7;filter:none;}
    .btn-export-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}.btn-export-pdf:hover{background:#fee2e2;filter:none;}
    .btn-export-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}.btn-export-excel:hover{background:#dcfce7;filter:none;}
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}
    .stat-icon.green{background:#f0fdf4;}
    .stat-icon.red{background:#fff0f0;}
    .stat-icon.purple{background:#fdf4ff;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center;}
    .filter-row input,.filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;}
    .filter-row input{width:160px;}
    .filter-row input[type=date]{width:150px;}
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
    .siswa-wrap .sname{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text);}
    .siswa-wrap .nis{font-size:12px;color:var(--text3);margin-top:1px;}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-berhasil{background:#dcfce7;color:#15803d;}.badge-berhasil .badge-dot{background:#15803d;}
    .badge-gagal_kadaluarsa{background:#fef9c3;color:#a16207;}.badge-gagal_kadaluarsa .badge-dot{background:#a16207;}
    .badge-gagal_lokasi{background:#fee2e2;color:#dc2626;}.badge-gagal_lokasi .badge-dot{background:#dc2626;}
    .badge-gagal_duplikat{background:#fdf4ff;color:#7c3aed;}.badge-gagal_duplikat .badge-dot{background:#7c3aed;}
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
    @media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr;}.page{padding:16px;}.filter-row input{width:100%;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Scan QR</h1>
            <p class="page-sub">Log seluruh aktivitas scan QR Code siswa beserta hasil pemindaian</p>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3h-3zM17 17h3v3h-3z"/></svg>
            </div>
            <div><p class="stat-label">Total Semua</p><p class="stat-val">{{ \App\Models\RiwayatScanQr::count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Berhasil</p><p class="stat-val">{{ \App\Models\RiwayatScanQr::where('hasil','berhasil')->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
            </div>
            <div><p class="stat-label">Gagal</p><p class="stat-val">{{ \App\Models\RiwayatScanQr::where('hasil','!=','berhasil')->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div><p class="stat-label">Scan Hari Ini</p><p class="stat-val">{{ \App\Models\RiwayatScanQr::whereDate('dipindai_pada', today())->count() }}</p></div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.riwayat-scan.index') }}">
            <div class="filter-row">
                <select name="sesi_qr_id">
                    <option value="">Semua Sesi QR</option>
                    @foreach($sesiQrs as $sesi)
                    <option value="{{ $sesi->id }}" {{ request('sesi_qr_id') == $sesi->id ? 'selected' : '' }}>
                        {{ $sesi->kelas->nama_kelas ?? '-' }} — #{{ $sesi->id }}
                    </option>
                    @endforeach
                </select>
                <select name="siswa_id">
                    <option value="">Semua Siswa</option>
                    @foreach($siswas as $siswa)
                    <option value="{{ $siswa->id }}" {{ request('siswa_id') == $siswa->id ? 'selected' : '' }}>
                        {{ $siswa->nama_lengkap }}
                    </option>
                    @endforeach
                </select>
                <select name="hasil">
                    <option value="">Semua Hasil</option>
                    @foreach($hasilList as $h)
                    <option value="{{ $h }}" {{ request('hasil') === $h ? 'selected' : '' }}>
                        @switch($h)
                            @case('berhasil') Berhasil @break
                            @case('gagal_kadaluarsa') Gagal – Kadaluarsa @break
                            @case('gagal_lokasi') Gagal – Lokasi @break
                            @case('gagal_duplikat') Gagal – Duplikat @break
                            @default {{ ucfirst($h) }}
                        @endswitch
                    </option>
                    @endforeach
                </select>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" title="Filter Tanggal Tepat">
                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" title="Dari Tanggal">
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" title="Sampai Tanggal">
                <div class="filter-sep"></div>
                <a href="{{ route('admin.riwayat-scan.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">Riwayat Scan
                @if($riwayats->total())
                <span>— menampilkan {{ $riwayats->firstItem() }}–{{ $riwayats->lastItem() }} dari {{ $riwayats->total() }} data</span>
                @endif
            </p>
            <div class="topbar-actions">
                <a href="{{ route('admin.riwayat-scan.export.pdf', request()->query()) }}" class="btn btn-sm btn-export-pdf">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    PDF
                </a>
                <a href="{{ route('admin.riwayat-scan.export.excel', request()->query()) }}" class="btn btn-sm btn-export-excel">
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
                        <th>Siswa</th>
                        <th>Sesi QR / Kelas</th>
                        <th>Hasil</th>
                        <th>Dipindai Pada</th>
                        <th>IP Address</th>
                        <th>Lokasi (Lat, Lon)</th>
                        <th class="center" style="width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayats as $index => $r)
                    <tr>
                        <td><span class="no-col">{{ $riwayats->firstItem() + $index }}</span></td>
                        <td>
                            <div class="siswa-wrap">
                                <p class="sname">{{ $r->siswa->nama_lengkap ?? '—' }}</p>
                                <p class="nis">{{ $r->siswa->nis ?? '' }}</p>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:600;color:var(--text)">{{ $r->sesiQr->kelas->nama_kelas ?? '—' }}</div>
                            <div style="font-size:12px;color:var(--text3)">Sesi #{{ $r->sesi_qr_id }}</div>
                        </td>
                        <td>
                            <span class="badge badge-{{ $r->hasil }}">
                                <span class="badge-dot"></span>
                                @switch($r->hasil)
                                    @case('berhasil') Berhasil @break
                                    @case('gagal_kadaluarsa') Gagal – Kadaluarsa @break
                                    @case('gagal_lokasi') Gagal – Lokasi @break
                                    @case('gagal_duplikat') Gagal – Duplikat @break
                                    @default {{ ucfirst($r->hasil ?? '-') }}
                                @endswitch
                            </span>
                        </td>
                        <td>
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;">
                                {{ $r->dipindai_pada?->format('H:i:s') ?? '—' }}
                            </span>
                            <div style="font-size:11.5px;color:var(--text3)">{{ $r->dipindai_pada?->format('d M Y') ?? '' }}</div>
                        </td>
                        <td class="muted" style="font-size:12.5px;">{{ $r->ip_address ?? '—' }}</td>
                        <td class="muted" style="font-size:12px;">
                            @if($r->latitude && $r->longitude)
                                {{ number_format($r->latitude, 5) }}, {{ number_format($r->longitude, 5) }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.riwayat-scan.show', $r->id) }}" class="btn btn-sm btn-detail">Detail</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                                </div>
                                <p class="empty-title">Belum ada riwayat scan</p>
                                <p class="empty-sub">Data scan QR akan muncul di sini secara otomatis</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($riwayats->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $riwayats->firstItem() }} – {{ $riwayats->lastItem() }} dari {{ $riwayats->total() }} scan</p>
            <div class="pag-btns">
                @if($riwayats->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $riwayats->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($riwayats->getUrlRange(1, $riwayats->lastPage()) as $page => $url)
                    @if($page == $riwayats->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $riwayats->lastPage() || abs($page - $riwayats->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $riwayats->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($riwayats->hasMorePages())
                    <a href="{{ $riwayats->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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
</script>
</x-app-layout>