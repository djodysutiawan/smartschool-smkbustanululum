<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px}
    .page{padding:28px 28px 60px;max-width:1400px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand)}.breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}.btn-back:hover{background:var(--surface3);filter:none}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row input,.filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none}
    .filter-row input:focus,.filter-row select:focus{border-color:var(--brand-h);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center}
    .btn-reset:hover{background:var(--surface3)}
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    td.muted{color:var(--text3);font-size:12.5px}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%}
    .b-hadir{background:#dcfce7;color:#15803d}.b-hadir .badge-dot{background:#15803d}
    .b-telat{background:#fef9c3;color:#a16207}.b-telat .badge-dot{background:#a16207}
    .b-izin{background:#dbeafe;color:#1d4ed8}.b-izin .badge-dot{background:#1d4ed8}
    .b-sakit{background:#f3e8ff;color:#6d28d9}.b-sakit .badge-dot{background:#6d28d9}
    .b-alfa{background:#fee2e2;color:#dc2626}.b-alfa .badge-dot{background:#dc2626}
    .empty-state{padding:60px 20px;text-align:center}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px;align-items:center}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--brand);border-color:var(--brand);color:#fff}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}
    @media(max-width:640px){.page{padding:16px}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a><span class="sep">›</span>
        <a href="{{ route('admin.absensi-guru-piket.dashboard') }}">Piket Guru</a><span class="sep">›</span>
        <span class="current">Riwayat Saya</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Absensi Saya</h1>
            <p class="page-sub">Data absensi yang dicatat oleh akun Anda</p>
        </div>
        <a href="{{ route('admin.absensi-guru-piket.dashboard') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Dashboard Piket
        </a>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.absensi-guru-piket.riwayat') }}">
            <div class="filter-row">
                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" title="Dari tanggal">
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" title="Sampai tanggal">
                <select name="status">
                    <option value="">Semua Status</option>
                    @foreach($statusList as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.absensi-guru-piket.riwayat') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Riwayat Pencatatan
                <span>— {{ $riwayat->firstItem() ?? 0 }}–{{ $riwayat->lastItem() ?? 0 }} dari {{ $riwayat->total() }} data</span>
            </p>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Nama Guru</th>
                        <th>Tanggal</th>
                        <th class="center">Jam Masuk</th>
                        <th class="center">Jam Keluar</th>
                        <th class="center">Status</th>
                        <th class="center">Metode</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $idx => $r)
                    <tr>
                        <td><span class="no-col">{{ $riwayat->firstItem() + $idx }}</span></td>
                        <td>
                            <div style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px">{{ $r->guru->nama_lengkap ?? '—' }}</div>
                            <div style="font-size:11.5px;color:var(--text3)">{{ $r->guru->nip ?? '—' }}</div>
                        </td>
                        <td style="font-weight:600;font-family:'Plus Jakarta Sans',sans-serif">
                            {{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y') }}
                        </td>
                        <td class="center muted">{{ $r->jam_masuk ?? '—' }}</td>
                        <td class="center muted">{{ $r->jam_keluar ?? '—' }}</td>
                        <td class="center">
                            @php $bc=['hadir'=>'b-hadir','telat'=>'b-telat','izin'=>'b-izin','sakit'=>'b-sakit','alfa'=>'b-alfa'][$r->status]??'b-alfa'; @endphp
                            <span class="badge {{ $bc }}"><span class="badge-dot"></span>{{ ucfirst($r->status) }}</span>
                        </td>
                        <td class="center muted">{{ ucfirst($r->metode) }}</td>
                        <td class="muted">{{ $r->keterangan ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="8">
                        <div class="empty-state">
                            <p class="empty-title">Belum ada riwayat</p>
                            <p class="empty-sub">Belum ada data absensi yang tercatat oleh akun Anda</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($riwayat->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $riwayat->firstItem() }}–{{ $riwayat->lastItem() }} dari {{ $riwayat->total() }}</p>
            <div class="pag-btns">
                @if($riwayat->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $riwayat->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($riwayat->getUrlRange(1, $riwayat->lastPage()) as $page => $url)
                    @if($page == $riwayat->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $riwayat->lastPage() || abs($page - $riwayat->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $riwayat->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($riwayat->hasMorePages())
                    <a href="{{ $riwayat->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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
    @if(session('success'))Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});@endif
</script>
</x-app-layout>