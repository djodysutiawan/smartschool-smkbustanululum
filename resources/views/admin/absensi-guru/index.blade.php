<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --red:#dc2626;--radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand);color:#fff}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-detail:hover{background:#dcfce7;filter:none}
    .btn-outline{background:var(--surface);color:var(--text2);border:1px solid var(--border)}
    .btn-outline:hover{background:var(--surface2);filter:none}
    .btn-green{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-green:hover{background:#dcfce7;filter:none}
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.green{background:#f0fdf4}.stat-icon.yellow{background:#fef9c3}.stat-icon.blue{background:#eff6ff}.stat-icon.red{background:#fff0f0}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row input,.filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row input{width:180px}
    .filter-row input:focus,.filter-row select:focus{border-color:var(--brand-h);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center}
    .btn-reset:hover{background:var(--surface3)}
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px}
    .table-actions{display:flex;gap:8px;flex-wrap:wrap}
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
    .guru-wrap .gname{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .guru-wrap .gnip{font-size:11.5px;color:var(--text3);margin-top:1px}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%}
    .b-hadir{background:#dcfce7;color:#15803d}.b-hadir .badge-dot{background:#15803d}
    .b-telat{background:#fef9c3;color:#a16207}.b-telat .badge-dot{background:#a16207}
    .b-izin{background:#dbeafe;color:#1d4ed8}.b-izin .badge-dot{background:#1d4ed8}
    .b-sakit{background:#f3e8ff;color:#6d28d9}.b-sakit .badge-dot{background:#6d28d9}
    .b-alfa{background:#fee2e2;color:#dc2626}.b-alfa .badge-dot{background:#dc2626}
    .metode-pill{display:inline-block;padding:2px 8px;border-radius:5px;font-size:11px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif}
    .m-manual{background:var(--surface3);color:var(--text2)}.m-qr{background:#f0fdf4;color:#15803d}
    .action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap}
    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px;align-items:center}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--brand);border-color:var(--brand);color:#fff}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}
    @media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr}.page{padding:16px}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Absensi Guru</h1>
            <p class="page-sub">Kelola data kehadiran guru — tambah, edit, dan pantau absensi harian</p>
        </div>
        <a href="{{ route('admin.absensi-guru.create') }}" class="btn btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Absensi
        </a>
    </div>

    {{-- Rekap hari ini --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Hadir Hari Ini</p><p class="stat-val">{{ $rekap['hadir'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div><p class="stat-label">Izin Hari Ini</p><p class="stat-val">{{ $rekap['izin'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            </div>
            <div><p class="stat-label">Sakit Hari Ini</p><p class="stat-val">{{ $rekap['sakit'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
            </div>
            <div><p class="stat-label">Alfa Hari Ini</p><p class="stat-val">{{ $rekap['alfa'] }}</p></div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.absensi-guru.index') }}">
            <div class="filter-row">
                <select name="guru_id">
                    <option value="">Semua Guru</option>
                    @foreach($guruList as $g)
                        <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                    @endforeach
                </select>
                <select name="status">
                    <option value="">Semua Status</option>
                    @foreach($statusList as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <select name="metode">
                    <option value="">Semua Metode</option>
                    @foreach($metodeList as $m)
                        <option value="{{ $m }}" {{ request('metode') == $m ? 'selected' : '' }}>{{ ucfirst($m) }}</option>
                    @endforeach
                </select>
                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" title="Dari tanggal">
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" title="Sampai tanggal">
                <div class="filter-sep"></div>
                <a href="{{ route('admin.absensi-guru.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Absensi Guru
                <span>— {{ $absensi->firstItem() ?? 0 }}–{{ $absensi->lastItem() ?? 0 }} dari {{ $absensi->total() }} data</span>
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.absensi-guru.export.pdf', request()->query()) }}" class="btn btn-sm btn-del" target="_blank">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    PDF
                </a>
                <a href="{{ route('admin.absensi-guru.rekap') }}" class="btn btn-sm btn-outline">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Rekap per Guru
                </a>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Guru</th>
                        <th>Tanggal</th>
                        <th class="center">Jam Masuk</th>
                        <th class="center">Jam Keluar</th>
                        <th class="center">Status</th>
                        <th class="center">Metode</th>
                        <th>Dicatat Oleh</th>
                        <th class="center" style="width:160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $idx => $a)
                    <tr>
                        <td><span class="no-col">{{ $absensi->firstItem() + $idx }}</span></td>
                        <td>
                            <div class="guru-wrap">
                                <p class="gname">{{ $a->guru->nama_lengkap ?? '—' }}</p>
                                <p class="gnip">{{ $a->guru->nip ?? '—' }}</p>
                            </div>
                        </td>
                        <td style="font-weight:600;font-family:'Plus Jakarta Sans',sans-serif">
                            {{ \Carbon\Carbon::parse($a->tanggal)->translatedFormat('d M Y') }}
                        </td>
                        <td class="center muted">{{ $a->jam_masuk ?? '—' }}</td>
                        <td class="center muted">{{ $a->jam_keluar ?? '—' }}</td>
                        <td class="center">
                            @php $bc = ['hadir'=>'b-hadir','telat'=>'b-telat','izin'=>'b-izin','sakit'=>'b-sakit','alfa'=>'b-alfa'][$a->status] ?? 'b-alfa'; @endphp
                            <span class="badge {{ $bc }}"><span class="badge-dot"></span>{{ ucfirst($a->status) }}</span>
                        </td>
                        <td class="center">
                            <span class="metode-pill m-{{ $a->metode }}">{{ ucfirst($a->metode) }}</span>
                        </td>
                        <td class="muted">{{ $a->pencatat->name ?? '—' }}</td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.absensi-guru.show', $a->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('admin.absensi-guru.edit', $a->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('admin.absensi-guru.destroy', $a->id) }}" method="POST" id="del-{{ $a->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('del-{{ $a->id }}'), '{{ \Carbon\Carbon::parse($a->tanggal)->format('d/m/Y') }} – {{ addslashes($a->guru->nama_lengkap ?? '') }}')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9">
                        <div class="empty-state">
                            <div class="empty-icon"><svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                            <p class="empty-title">Belum ada data absensi</p>
                            <p class="empty-sub">Tambahkan absensi atau ubah filter pencarian</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($absensi->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $absensi->firstItem() }}–{{ $absensi->lastItem() }} dari {{ $absensi->total() }}</p>
            <div class="pag-btns">
                @if($absensi->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $absensi->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($absensi->getUrlRange(1, $absensi->lastPage()) as $page => $url)
                    @if($page == $absensi->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $absensi->lastPage() || abs($page - $absensi->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $absensi->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($absensi->hasMorePages())
                    <a href="{{ $absensi->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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
    function confirmDelete(form, label) {
        Swal.fire({
            title:'Hapus Data Absensi?',html:`Data absensi <strong>${label}</strong> akan dihapus permanen.`,
            icon:'warning',showCancelButton:true,confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal'
        }).then(r=>{if(r.isConfirmed)form.submit()});
    }
</script>
</x-app-layout>