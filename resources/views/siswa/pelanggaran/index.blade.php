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

    .page{padding:28px 28px 48px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    /* ── Summary strip ── */
    .summary-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .sum-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px}
    .sum-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .sum-icon.red   {background:#fee2e2}
    .sum-icon.yellow{background:#fef9c3}
    .sum-icon.blue  {background:#eff6ff}
    .sum-icon.green {background:#dcfce7}
    .sum-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .sum-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .sum-sub{font-size:11px;color:var(--text3);margin-top:1px}

    /* ── Poin meter card ── */
    .poin-meter{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:18px 22px;margin-bottom:20px}
    .poin-meter-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;flex-wrap:wrap;gap:8px}
    .poin-meter-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .poin-meter-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800}
    .poin-bar-track{height:10px;background:var(--surface3);border-radius:99px;overflow:hidden}
    .poin-bar-fill{height:100%;border-radius:99px;transition:width .6s cubic-bezier(.4,0,.2,1)}
    .poin-meter-hint{font-size:11.5px;color:var(--text3);margin-top:6px}

    /* ── Filter ── */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select,.filter-row input[type=date]{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row input[type=date]{width:148px}
    .filter-row select:focus,.filter-row input:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer}
    .btn-filter:hover{background:var(--brand-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center}
    .btn-reset:hover{background:var(--surface3)}

    /* ── Table ── */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:5px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    td.muted{color:var(--text3)}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-pending  {background:#fef9c3;color:#a16207}   .badge-pending  .badge-dot{background:#a16207}
    .badge-diproses {background:#eff6ff;color:#1d4ed8}   .badge-diproses .badge-dot{background:#1d4ed8}
    .badge-selesai  {background:#dcfce7;color:#15803d}   .badge-selesai  .badge-dot{background:#15803d}
    .badge-banding  {background:#fdf4ff;color:#7c3aed}   .badge-banding  .badge-dot{background:#7c3aed}

    .poin-pill{display:inline-flex;align-items:center;justify-content:center;min-width:34px;height:24px;padding:0 8px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800}
    .poin-low  {background:#dcfce7;color:#15803d}
    .poin-mid  {background:#fef9c3;color:#a16207}
    .poin-high {background:#fee2e2;color:#dc2626}

    .btn-detail{display:inline-flex;align-items:center;gap:4px;padding:5px 11px;border-radius:6px;background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;text-decoration:none;transition:background .15s}
    .btn-detail:hover{background:#dcfce7}

    /* Empty */
    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    /* Pagination */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;display:flex;align-items:center}

    @media(max-width:768px){
        .summary-strip{grid-template-columns:1fr 1fr}
        .page{padding:16px}
    }
    @media(max-width:480px){
        .summary-strip{grid-template-columns:1fr}
    }
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Kedisiplinan Saya</h1>
            <p class="page-sub">Catatan pelanggaran dan rekap poin kedisiplinan Anda</p>
        </div>
    </div>

    {{-- ── Summary strip ── --}}
    <div class="summary-strip">
        <div class="sum-card">
            <div class="sum-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </div>
            <div>
                <p class="sum-label">Total Catatan</p>
                <p class="sum-val">{{ $totalCatatan }}</p>
                <p class="sum-sub">semua waktu</p>
            </div>
        </div>

        <div class="sum-card">
            <div class="sum-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div>
                <p class="sum-label">Pending</p>
                <p class="sum-val">{{ $rekapStatus['pending'] ?? 0 }}</p>
                <p class="sum-sub">menunggu tindak lanjut</p>
            </div>
        </div>

        <div class="sum-card">
            <div class="sum-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <div>
                <p class="sum-label">Diproses</p>
                <p class="sum-val">{{ $rekapStatus['diproses'] ?? 0 }}</p>
                <p class="sum-sub">sedang ditindaklanjuti</p>
            </div>
        </div>

        <div class="sum-card">
            <div class="sum-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div>
                <p class="sum-label">Selesai</p>
                <p class="sum-val">{{ $rekapStatus['selesai'] ?? 0 }}</p>
                <p class="sum-sub">sudah diselesaikan</p>
            </div>
        </div>
    </div>

    {{-- ── Poin meter ── --}}
    @php
        $maxPoin   = 100;
        $poinPct   = min(100, ($totalPoin / $maxPoin) * 100);
        $poinColor = $totalPoin <= 30 ? '#15803d' : ($totalPoin <= 60 ? '#a16207' : '#dc2626');
        $poinLabel = $totalPoin <= 30 ? 'Baik' : ($totalPoin <= 60 ? 'Perlu Perhatian' : 'Kritis');
    @endphp
    <div class="poin-meter">
        <div class="poin-meter-top">
            <p class="poin-meter-label">
                Akumulasi Poin Pelanggaran Tahun {{ now()->year }}
            </p>
            <span class="poin-meter-val" style="color:{{ $poinColor }}">
                {{ $totalPoin }} / {{ $maxPoin }} poin — {{ $poinLabel }}
            </span>
        </div>
        <div class="poin-bar-track">
            <div class="poin-bar-fill" style="width:{{ $poinPct }}%;background:{{ $poinColor }}"></div>
        </div>
        <p class="poin-meter-hint">
            Semakin banyak poin pelanggaran, semakin berat sanksi yang akan diberikan.
        </p>
    </div>

    {{-- ── Filter ── --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('siswa.pelanggaran.index') }}">
            <div class="filter-row">
                <select name="kategori_id">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama }}
                        </option>
                    @endforeach
                </select>

                <select name="status">
                    <option value="">Semua Status</option>
                    @foreach($statusList as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>

                <input type="date" name="tanggal_dari"   value="{{ request('tanggal_dari') }}" title="Dari tanggal">
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" title="Sampai tanggal">

                <div class="filter-sep"></div>
                <a href="{{ route('siswa.pelanggaran.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- ── Table ── --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Riwayat Pelanggaran Saya
                @if($pelanggaran->total() > 0)
                    <span>— {{ $pelanggaran->firstItem() }}–{{ $pelanggaran->lastItem() }} dari {{ $pelanggaran->total() }} data</span>
                @else
                    <span>— tidak ada data</span>
                @endif
            </p>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:44px">#</th>
                        <th>Kategori</th>
                        <th class="center">Poin</th>
                        <th>Tanggal</th>
                        <th class="center">Status</th>
                        <th>Deskripsi</th>
                        <th class="center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggaran as $i => $p)
                    <tr>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)">
                            {{ $pelanggaran->firstItem() + $i }}
                        </td>

                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)">
                            {{ $p->kategori->nama ?? '—' }}
                        </td>

                        <td class="center">
                            @php $pc = $p->poin <= 10 ? 'poin-low' : ($p->poin <= 30 ? 'poin-mid' : 'poin-high') @endphp
                            <span class="poin-pill {{ $pc }}">{{ $p->poin }}</span>
                        </td>

                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px">
                            {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}
                        </td>

                        <td class="center">
                            <span class="badge badge-{{ $p->status }}">
                                <span class="badge-dot"></span>
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>

                        <td style="font-size:12.5px;color:var(--text2);max-width:200px">
                            <p style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                                {{ $p->deskripsi ?? '—' }}
                            </p>
                        </td>

                        <td class="center">
                            <a href="{{ route('siswa.pelanggaran.show', $p->id) }}" class="btn-detail">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                    </svg>
                                </div>
                                <p class="empty-title">Tidak ada catatan pelanggaran</p>
                                <p class="empty-sub">
                                    @if(request()->hasAny(['kategori_id','status','tanggal_dari','tanggal_sampai']))
                                        Coba ubah filter pencarian
                                    @else
                                        Pertahankan kedisiplinan Anda!
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pelanggaran->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">
                Menampilkan {{ $pelanggaran->firstItem() }} – {{ $pelanggaran->lastItem() }}
                dari {{ $pelanggaran->total() }} catatan
            </p>
            <div class="pag-btns">
                @if($pelanggaran->onFirstPage())
                    <span class="pag-btn disabled">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $pelanggaran->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                @foreach($pelanggaran->getUrlRange(1, $pelanggaran->lastPage()) as $page => $url)
                    @if($page == $pelanggaran->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $pelanggaran->lastPage() || abs($page - $pelanggaran->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $pelanggaran->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                @if($pelanggaran->hasMorePages())
                    <a href="{{ $pelanggaran->nextPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                @else
                    <span class="pag-btn disabled">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
</x-app-layout>