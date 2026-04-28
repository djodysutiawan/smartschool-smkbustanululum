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
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-detail:hover{background:#dcfce7;filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}
    .btn-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-pdf:hover{background:#fee2e2;filter:none}

    /* Stats */
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.blue{background:#eff6ff} .stat-icon.green{background:#f0fdf4}
    .stat-icon.yellow{background:#fefce8} .stat-icon.purple{background:#fdf4ff}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    /* Filter */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end}
    .filter-field{display:flex;flex-direction:column;gap:4px}
    .filter-field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text2)}
    .filter-field select,.filter-field input[type=date]{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-field select:focus,.filter-field input:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer}
    .btn-filter:hover{background:var(--brand-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center}
    .btn-reset:hover{background:var(--surface3)}

    /* Table */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:8px}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    td.muted{color:var(--text3)}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}
    .two-line .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .two-line .secondary{font-size:12px;color:var(--text3);margin-top:1px}

    /* Badge */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-today{background:var(--brand-50);color:var(--brand-700)}
    .badge-hadir{background:#dcfce7;color:#15803d}
    .badge-izin {background:#dbeafe;color:#1d4ed8}
    .badge-sakit{background:#f3e8ff;color:#7c3aed}
    .badge-alfa {background:#fee2e2;color:#dc2626}
    .badge-ada  {background:#fef9c3;color:#a16207}
    .badge-num  {background:#fee2e2;color:#dc2626;font-size:13px;padding:2px 10px}

    /* Rekap absensi inline */
    .rekap-pills{display:flex;gap:4px;flex-wrap:wrap}

    /* Action group */
    .action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap}

    /* Empty */
    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    /* Pagination */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px;align-items:center}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}

    @media(max-width:768px){.stats-strip{grid-template-columns:1fr 1fr}.page{padding:16px}}
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Harian Piket</h1>
            <p class="page-sub">Rekap seluruh laporan harian dari semua guru piket</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.laporan-harian-piket.export-pdf', request()->query()) }}" class="btn btn-pdf">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export PDF
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Laporan</p>
                <p class="stat-val">{{ $stats['total'] }}</p>
                <p class="stat-sub">semua waktu</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Hari Ini</p>
                <p class="stat-val">{{ $stats['hari_ini'] }}</p>
                <p class="stat-sub">laporan masuk</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Bulan Ini</p>
                <p class="stat-val">{{ $stats['bulan_ini'] }}</p>
                <p class="stat-sub">{{ now()->locale('id')->isoFormat('MMMM Y') }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <p class="stat-label">Guru Piket</p>
                <p class="stat-val">{{ $stats['total_piket'] }}</p>
                <p class="stat-sub">terdaftar</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.laporan-harian-piket.index') }}">
            <div class="filter-row">
                <div class="filter-field">
                    <label>Guru Piket</label>
                    <select name="dibuat_oleh" style="min-width:200px">
                        <option value="">— Semua Guru Piket —</option>
                        @foreach($guruPiketList as $user)
                            <option value="{{ $user->id }}" {{ request('dibuat_oleh') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-field">
                    <label>Tanggal Dari</label>
                    <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}">
                </div>
                <div class="filter-field">
                    <label>Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.laporan-harian-piket.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Laporan
                @if($laporan->total() > 0)
                    <span>— menampilkan {{ $laporan->firstItem() }}–{{ $laporan->lastItem() }} dari {{ $laporan->total() }} data</span>
                @else
                    <span>— tidak ada data</span>
                @endif
            </p>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Tanggal</th>
                        <th>Guru Piket</th>
                        <th class="center">Pelanggaran</th>
                        <th>Rekap Absensi</th>
                        <th>Catatan Umum</th>
                        <th class="center">Kejadian Khusus</th>
                        <th class="center" style="width:140px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $index => $item)
                    @php $rekap = $item->rekap_absensi ?? []; @endphp
                    <tr>
                        <td><span class="no-col">{{ $laporan->firstItem() + $index }}</span></td>

                        <td>
                            <div class="two-line">
                                <p class="primary">{{ $item->tanggal->format('d M Y') }}</p>
                                <p class="secondary">{{ $item->tanggal->locale('id')->dayName }}</p>
                            </div>
                            @if($item->tanggal->isToday())
                                <span class="badge badge-today" style="margin-top:4px">Hari ini</span>
                            @endif
                        </td>

                        <td>
                            <div class="two-line">
                                <p class="primary">{{ $item->dibuatOleh?->name ?? '—' }}</p>
                                <p class="secondary">{{ $item->dibuatOleh?->email ?? '' }}</p>
                            </div>
                        </td>

                        <td class="center">
                            <span class="badge badge-num">{{ $item->jumlah_pelanggaran }}</span>
                        </td>

                        <td>
                            @if(!empty($rekap))
                            <div class="rekap-pills">
                                <span class="badge badge-hadir">H: {{ $rekap['hadir'] ?? 0 }}</span>
                                <span class="badge badge-izin">I: {{ $rekap['izin'] ?? 0 }}</span>
                                <span class="badge badge-sakit">S: {{ $rekap['sakit'] ?? 0 }}</span>
                                <span class="badge badge-alfa">A: {{ $rekap['alfa'] ?? 0 }}</span>
                            </div>
                            @else
                                <span class="muted" style="font-size:12px;color:var(--text3)">—</span>
                            @endif
                        </td>

                        <td style="max-width:180px">
                            <p style="font-size:12.5px;color:var(--text2);display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                                {{ $item->catatan_umum ? Str::limit($item->catatan_umum, 70) : '—' }}
                            </p>
                        </td>

                        <td class="center">
                            @if($item->kejadian_khusus)
                                <span class="badge badge-ada">
                                    <span class="badge-dot" style="background:#a16207"></span>Ada
                                </span>
                            @else
                                <span style="font-size:12px;color:var(--text3)">—</span>
                            @endif
                        </td>

                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.laporan-harian-piket.show', $item) }}" class="btn btn-sm btn-detail">Detail</a>
                                <form action="{{ route('admin.laporan-harian-piket.destroy', $item) }}" method="POST"
                                      id="del-{{ $item->id }}" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('del-{{ $item->id }}'), {{ Js::from($item->tanggal->format('d M Y')) }}, {{ Js::from($item->dibuatOleh?->name ?? '') }})">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                </div>
                                <p class="empty-title">Belum ada laporan harian piket</p>
                                <p class="empty-sub">Laporan akan muncul setelah guru piket mengisi laporan harian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($laporan->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $laporan->firstItem() }} – {{ $laporan->lastItem() }} dari {{ $laporan->total() }}</p>
            <div class="pag-btns">
                @if($laporan->onFirstPage())
                    <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $laporan->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($laporan->getUrlRange(1, $laporan->lastPage()) as $page => $url)
                    @if($page == $laporan->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $laporan->lastPage() || abs($page - $laporan->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $laporan->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($laporan->hasMorePages())
                    <a href="{{ $laporan->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif

function confirmDelete(form, tanggal, nama) {
    Swal.fire({
        title: 'Hapus Laporan?',
        html: `Laporan <strong>${nama}</strong> tanggal <strong>${tanggal}</strong> akan dihapus permanen.`,
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) form.submit(); });
}
</script>
</x-app-layout>