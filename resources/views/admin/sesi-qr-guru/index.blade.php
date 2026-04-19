<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand);color:#fff}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}.btn-detail:hover{background:#dcfce7;filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}.btn-del:hover{background:#fee2e2;filter:none}
    .btn-purple{background:#faf5ff;color:#6d28d9;border:1px solid #e9d5ff}.btn-purple:hover{background:#f3e8ff;filter:none}
    .btn-yellow{background:#fef9c3;color:#a16207;border:1px solid #fde68a}.btn-yellow:hover{background:#fef08a;filter:none}
    .btn-outline{background:var(--surface);color:var(--text2);border:1px solid var(--border)}.btn-outline:hover{background:var(--surface2);filter:none}
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
    .b-aktif{background:#dcfce7;color:#15803d}.b-aktif .badge-dot{background:#15803d}
    .b-nonaktif{background:#fee2e2;color:#dc2626}.b-nonaktif .badge-dot{background:#dc2626}
    .b-kadaluarsa{background:#fef9c3;color:#a16207}.b-kadaluarsa .badge-dot{background:#a16207}
    .action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap}
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
    <div class="page-header">
        <div>
            <h1 class="page-title">Sesi QR Guru</h1>
            <p class="page-sub">Kelola sesi QR code untuk absensi guru — buat, cetak, dan nonaktifkan</p>
        </div>
        <a href="{{ route('admin.sesi-qr-guru.create') }}" class="btn btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Buat Sesi QR
        </a>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.sesi-qr-guru.index') }}">
            <div class="filter-row">
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" title="Filter tanggal">
                <select name="is_active">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.sesi-qr-guru.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Sesi QR
                <span>— {{ $sesiList->firstItem() ?? 0 }}–{{ $sesiList->lastItem() ?? 0 }} dari {{ $sesiList->total() }} sesi</span>
            </p>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Tanggal</th>
                        <th>Berlaku Mulai</th>
                        <th>Kadaluarsa</th>
                        <th class="center">Radius</th>
                        <th class="center">Total Scan</th>
                        <th class="center">Berhasil</th>
                        <th>Dibuat Oleh</th>
                        <th class="center">Status</th>
                        <th class="center" style="width:240px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sesiList as $idx => $s)
                    @php
                        $statusBadge = $s->is_active && now()->lt($s->kadaluarsa_pada) ? 'b-aktif' : ($s->is_active ? 'b-kadaluarsa' : 'b-nonaktif');
                        $statusLabel = $s->is_active && now()->lt($s->kadaluarsa_pada) ? 'Aktif' : ($s->is_active ? 'Kadaluarsa' : 'Nonaktif');
                    @endphp
                    <tr>
                        <td><span class="no-col">{{ $sesiList->firstItem() + $idx }}</span></td>
                        <td style="font-weight:600;font-family:'Plus Jakarta Sans',sans-serif">
                            {{ \Carbon\Carbon::parse($s->tanggal)->translatedFormat('d M Y') }}
                        </td>
                        <td class="muted">{{ \Carbon\Carbon::parse($s->berlaku_mulai)->format('H:i') }}</td>
                        <td class="muted">{{ \Carbon\Carbon::parse($s->kadaluarsa_pada)->format('H:i') }}</td>
                        <td class="center muted">{{ $s->radius_meter ? $s->radius_meter.'m' : '—' }}</td>
                        <td class="center" style="font-weight:600">{{ $s->riwayat_scan_count }}</td>
                        <td class="center" style="color:#15803d;font-weight:600">{{ $s->scan_berhasil_count }}</td>
                        <td class="muted">{{ $s->pembuat->name ?? '—' }}</td>
                        <td class="center">
                            <span class="badge {{ $statusBadge }}"><span class="badge-dot"></span>{{ $statusLabel }}</span>
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.sesi-qr-guru.show', $s->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('admin.sesi-qr-guru.cetak-qr', $s->id) }}" class="btn btn-sm btn-purple" target="_blank">Cetak QR</a>
                                @if($s->is_active && now()->lt($s->kadaluarsa_pada))
                                <form action="{{ route('admin.sesi-qr-guru.nonaktifkan', $s->id) }}" method="POST" id="nonaktifForm-{{ $s->id }}">
                                    @csrf
                                    <button type="button" class="btn btn-sm btn-yellow"
                                        onclick="confirmNonaktif(document.getElementById('nonaktifForm-{{ $s->id }}'))">
                                        Nonaktifkan
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('admin.sesi-qr-guru.destroy', $s->id) }}" method="POST" id="delSesiForm-{{ $s->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delSesiForm-{{ $s->id }}'), '{{ \Carbon\Carbon::parse($s->tanggal)->format('d/m/Y') }}')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="10">
                        <div class="empty-state">
                            <p class="empty-title">Belum ada sesi QR</p>
                            <p class="empty-sub">Buat sesi QR baru untuk mengaktifkan absensi via QR code</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sesiList->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $sesiList->firstItem() }}–{{ $sesiList->lastItem() }} dari {{ $sesiList->total() }}</p>
            <div class="pag-btns">
                @if($sesiList->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $sesiList->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($sesiList->getUrlRange(1, $sesiList->lastPage()) as $page => $url)
                    @if($page == $sesiList->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $sesiList->lastPage() || abs($page - $sesiList->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $sesiList->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($sesiList->hasMorePages())
                    <a href="{{ $sesiList->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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
    @if(session('error'))Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});@endif
    function confirmDelete(form, label) {
        Swal.fire({title:'Hapus Sesi QR?',html:`Sesi QR tanggal <strong>${label}</strong> akan dihapus permanen.`,icon:'warning',showCancelButton:true,confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)form.submit()});
    }
    function confirmNonaktif(form) {
        Swal.fire({title:'Nonaktifkan Sesi QR?',text:'Sesi ini tidak akan bisa diaktifkan kembali.',icon:'warning',showCancelButton:true,confirmButtonColor:'#a16207',cancelButtonColor:'#64748b',confirmButtonText:'Ya, Nonaktifkan',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)form.submit()});
    }
</script>
</x-app-layout>