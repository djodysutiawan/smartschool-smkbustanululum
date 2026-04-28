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
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-detail:hover{background:#dcfce7;filter:none}
    .btn-mark{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-mark:hover{background:var(--brand-100);filter:none}

    .stats-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.blue{background:#eff6ff}
    .stat-icon.green{background:#f0fdf4}
    .stat-icon.red{background:#fff0f0}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row select:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s}
    .btn-filter:hover{background:var(--brand-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:background .15s}
    .btn-reset:hover{background:var(--surface3)}

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
    tbody tr.unread{background:#f8fbff}
    tbody tr.unread:hover{background:#f0f7ff}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    td.muted{color:var(--text3)}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-info       {background:#eff6ff;color:#1d4ed8}    .badge-info       .badge-dot{background:#1d4ed8}
    .badge-peringatan {background:#fefce8;color:#a16207}   .badge-peringatan .badge-dot{background:#a16207}
    .badge-pelanggaran{background:#fff0f0;color:#dc2626}   .badge-pelanggaran.badge-dot{background:#dc2626}
    .badge-absensi    {background:#f0fdf4;color:#15803d}   .badge-absensi    .badge-dot{background:#15803d}
    .badge-nilai      {background:#fdf4ff;color:#7c3aed}   .badge-nilai      .badge-dot{background:#7c3aed}
    .badge-pengumuman {background:#fff7ed;color:#c2410c}   .badge-pengumuman .badge-dot{background:#c2410c}
    .badge-tugas      {background:#ecfdf5;color:#065f46}   .badge-tugas      .badge-dot{background:#065f46}
    .badge-ujian      {background:#fef3c7;color:#92400e}   .badge-ujian      .badge-dot{background:#92400e}
    .badge-read       {background:var(--surface3);color:var(--text3)}
    .badge-unread     {background:var(--brand-50);color:var(--brand-700)}

    .two-line .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .two-line .secondary{font-size:12px;color:var(--text3);margin-top:1px}
    .unread-dot{display:inline-block;width:7px;height:7px;background:var(--brand-500);border-radius:50%;margin-right:6px;flex-shrink:0;vertical-align:middle}

    .action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap}
    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px;align-items:center}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2);border-color:var(--border2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}

    @media(max-width:640px){
        .stats-strip{grid-template-columns:1fr 1fr}
        .page{padding:16px}
        .header-actions{width:100%}
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Notifikasi</h1>
            <p class="page-sub">Pantau semua pemberitahuan yang masuk</p>
        </div>
        <div class="header-actions">
            @if($unread > 0)
            <form action="{{ route('guru.notifikasi.mark-all-read') }}" method="POST" style="display:inline">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-mark">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Tandai Semua Dibaca
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            </div>
            <div>
                <p class="stat-label">Total</p>
                <p class="stat-val">{{ $notifikasis->total() }}</p>
                <p class="stat-sub">notifikasi</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><circle cx="18" cy="5" r="3" fill="#dc2626" stroke="none"/></svg>
            </div>
            <div>
                <p class="stat-label">Belum Dibaca</p>
                <p class="stat-val">{{ $unread }}</p>
                <p class="stat-sub">notifikasi</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Sudah Dibaca</p>
                <p class="stat-val">{{ $notifikasis->total() - $unread }}</p>
                <p class="stat-sub">notifikasi</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('guru.notifikasi.index') }}">
            <div class="filter-row">
                <select name="jenis">
                    <option value="">Semua Jenis</option>
                    @foreach($jenisList as $j)
                        <option value="{{ $j }}" {{ request('jenis') == $j ? 'selected' : '' }}>
                            {{ ucfirst($j) }}
                        </option>
                    @endforeach
                </select>
                <select name="sudah_dibaca">
                    <option value="">Semua Status</option>
                    <option value="tidak" {{ request('sudah_dibaca') === 'tidak' ? 'selected' : '' }}>Belum Dibaca</option>
                    <option value="ya"    {{ request('sudah_dibaca') === 'ya'    ? 'selected' : '' }}>Sudah Dibaca</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('guru.notifikasi.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Notifikasi
                @if($notifikasis->total() > 0)
                    <span>— menampilkan {{ $notifikasis->firstItem() }}–{{ $notifikasis->lastItem() }} dari {{ $notifikasis->total() }} data</span>
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
                        <th>Judul &amp; Pesan</th>
                        <th class="center">Jenis</th>
                        <th class="center">Status</th>
                        <th>Waktu</th>
                        <th class="center" style="width:160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifikasis as $index => $n)
                    <tr class="{{ !$n->sudah_dibaca ? 'unread' : '' }}">
                        <td><span class="no-col">{{ $notifikasis->firstItem() + $index }}</span></td>

                        <td>
                            <div class="two-line">
                                <p class="primary">
                                    @if(!$n->sudah_dibaca)<span class="unread-dot"></span>@endif
                                    {{ $n->judul }}
                                </p>
                                <p class="secondary" style="max-width:320px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                                    {{ $n->pesan }}
                                </p>
                            </div>
                        </td>

                        <td class="center">
                            <span class="badge badge-{{ $n->jenis }}">
                                <span class="badge-dot"></span>
                                {{ ucfirst($n->jenis) }}
                            </span>
                        </td>

                        <td class="center">
                            @if($n->sudah_dibaca)
                                <span class="badge badge-read">Dibaca</span>
                            @else
                                <span class="badge badge-unread">Baru</span>
                            @endif
                        </td>

                        <td class="muted" style="font-size:12.5px;white-space:nowrap">
                            {{ $n->created_at->locale('id')->diffForHumans() }}
                            @if($n->sudah_dibaca && $n->dibaca_pada)
                                <br><span style="font-size:11.5px">Dibaca: {{ $n->dibaca_pada->format('d M Y H:i') }}</span>
                            @endif
                        </td>

                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('guru.notifikasi.show', $n->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                @if(!$n->sudah_dibaca)
                                <form action="{{ route('guru.notifikasi.mark-read', $n->id) }}" method="POST" style="display:inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-mark">Baca</button>
                                </form>
                                @endif
                                <form action="{{ route('guru.notifikasi.destroy', $n->id) }}" method="POST"
                                      id="delNotif-{{ $n->id }}" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delNotif-{{ $n->id }}'), {{ Js::from($n->judul) }})">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                                </div>
                                <p class="empty-title">Tidak ada notifikasi</p>
                                <p class="empty-sub">Semua notifikasi akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($notifikasis->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $notifikasis->firstItem() }} – {{ $notifikasis->lastItem() }} dari {{ $notifikasis->total() }}</p>
            <div class="pag-btns">
                @if($notifikasis->onFirstPage())
                    <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $notifikasis->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($notifikasis->getUrlRange(1, $notifikasis->lastPage()) as $page => $url)
                    @if($page == $notifikasis->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $notifikasis->lastPage() || abs($page - $notifikasis->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $notifikasis->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($notifikasis->hasMorePages())
                    <a href="{{ $notifikasis->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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

function confirmDelete(form, judul) {
    Swal.fire({
        title: 'Hapus Notifikasi?',
        html: `Notifikasi <strong>${judul}</strong> akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) form.submit(); });
}
</script>
</x-app-layout>