<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 48px}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;margin-bottom:20px}

    /* Tab nav */
    .tab-nav{display:flex;gap:4px;margin-bottom:20px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);padding:4px;width:fit-content}
    .tab-link{padding:7px 18px;border-radius:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text3);text-decoration:none;transition:all .15s}
    .tab-link.active{background:var(--surface);color:var(--brand-600);box-shadow:0 1px 3px rgba(0,0,0,.08)}
    .tab-link:hover:not(.active){color:var(--text2)}

    /* Summary strip */
    .summary-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:20px}
    .sum-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px}
    .sum-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:4px}
    .sum-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1}
    .sum-sub{font-size:11px;color:var(--text3);margin-top:2px}

    /* Kehadiran meter */
    .persen-bar-wrap{margin-top:8px}
    .persen-bar-track{height:5px;background:var(--surface3);border-radius:99px;overflow:hidden;margin-top:4px}
    .persen-bar-fill{height:100%;border-radius:99px}

    /* Filter */
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

    /* Table */
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

    /* Badge status */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-hadir {background:#dcfce7;color:#15803d} .badge-hadir  .badge-dot{background:#15803d}
    .badge-telat {background:#fef9c3;color:#a16207} .badge-telat  .badge-dot{background:#a16207}
    .badge-izin  {background:#eff6ff;color:#1d4ed8} .badge-izin   .badge-dot{background:#1d4ed8}
    .badge-sakit {background:#fdf4ff;color:#7c3aed} .badge-sakit  .badge-dot{background:#7c3aed}
    .badge-alfa  {background:#fee2e2;color:#dc2626} .badge-alfa   .badge-dot{background:#dc2626}

    /* Metode pill */
    .metode-pill{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;background:var(--surface3);color:var(--text3)}

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

    @media(max-width:900px){.summary-strip{grid-template-columns:repeat(3,1fr)}}
    @media(max-width:600px){.summary-strip{grid-template-columns:1fr 1fr};.page{padding:16px}}
</style>

<div class="page">
    <h1 class="page-title">Riwayat Kehadiran</h1>
    <p class="page-sub">Catatan absensi harian Anda</p>

    <div class="tab-nav">
        <a href="{{ route('siswa.absensi.scan') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.scan') ? 'active' : '' }}">
            Scan QR Hadir
        </a>
        <a href="{{ route('siswa.absensi.riwayat') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.riwayat') ? 'active' : '' }}">
            Riwayat Kehadiran
        </a>
    </div>

    {{-- Summary strip --}}
    @php
        $pct = $rekap['persen_hadir'];
        $pctColor = $pct >= 80 ? '#15803d' : ($pct >= 60 ? '#a16207' : '#dc2626');
    @endphp
    <div class="summary-strip">
        <div class="sum-card">
            <p class="sum-label">Total</p>
            <p class="sum-val">{{ $rekap['total'] }}</p>
            <p class="sum-sub">hari tercatat</p>
        </div>
        <div class="sum-card">
            <p class="sum-label">Hadir</p>
            <p class="sum-val" style="color:#15803d">{{ $rekap['hadir'] }}</p>
            <div class="persen-bar-wrap">
                <p style="font-size:11px;color:#15803d;font-weight:700">{{ $pct }}%</p>
                <div class="persen-bar-track">
                    <div class="persen-bar-fill" style="width:{{ $pct }}%;background:{{ $pctColor }}"></div>
                </div>
            </div>
        </div>
        <div class="sum-card">
            <p class="sum-label">Izin</p>
            <p class="sum-val" style="color:#1d4ed8">{{ $rekap['izin'] }}</p>
            <p class="sum-sub">hari izin</p>
        </div>
        <div class="sum-card">
            <p class="sum-label">Sakit</p>
            <p class="sum-val" style="color:#7c3aed">{{ $rekap['sakit'] }}</p>
            <p class="sum-sub">hari sakit</p>
        </div>
        <div class="sum-card">
            <p class="sum-label">Alfa</p>
            <p class="sum-val" style="color:#dc2626">{{ $rekap['alfa'] }}</p>
            <p class="sum-sub">tidak keterangan</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('siswa.absensi.riwayat') }}">
            <div class="filter-row">
                <select name="status">
                    <option value="">Semua Status</option>
                    @foreach($statusList as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>

                <select name="bulan">
                    <option value="">Semua Bulan</option>
                    @foreach(range(1,12) as $b)
                        <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>

                <select name="tahun">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunList as $t)
                        <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>

                <input type="date" name="tanggal_dari"   value="{{ request('tanggal_dari') }}"   title="Dari tanggal">
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" title="Sampai tanggal">

                <div class="filter-sep"></div>
                <a href="{{ route('siswa.absensi.riwayat') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Riwayat Absensi
                @if($absensi->total() > 0)
                    <span>— {{ $absensi->firstItem() }}–{{ $absensi->lastItem() }} dari {{ $absensi->total() }} data</span>
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
                        <th>Tanggal</th>
                        <th class="center">Status</th>
                        <th class="center">Jam Masuk</th>
                        <th>Metode</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $i => $a)
                    <tr>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)">
                            {{ $absensi->firstItem() + $i }}
                        </td>

                        <td>
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)">
                                {{ $a->tanggal->translatedFormat('d F Y') }}
                            </p>
                            <p style="font-size:11.5px;color:var(--text3);margin-top:1px">
                                {{ $a->tanggal->translatedFormat('l') }}
                            </p>
                        </td>

                        <td class="center">
                            <span class="badge badge-{{ $a->status }}">
                                <span class="badge-dot"></span>
                                {{ ucfirst($a->status) }}
                            </span>
                        </td>

                        <td class="center" style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px">
                            {{ $a->jam_masuk ? \Carbon\Carbon::parse($a->jam_masuk)->format('H:i') : '—' }}
                        </td>

                        <td>
                            <span class="metode-pill">
                                {{ strtoupper($a->metode ?? 'manual') }}
                            </span>
                        </td>

                        <td style="font-size:12.5px;color:var(--text2);max-width:200px">
                            <p style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                                {{ $a->keterangan ?? '—' }}
                            </p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                    </svg>
                                </div>
                                <p class="empty-title">Tidak ada data absensi</p>
                                <p class="empty-sub">
                                    @if(request()->hasAny(['status','bulan','tahun','tanggal_dari','tanggal_sampai']))
                                        Coba ubah filter pencarian
                                    @else
                                        Belum ada catatan absensi
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
        @if($absensi->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">
                Menampilkan {{ $absensi->firstItem() }} – {{ $absensi->lastItem() }}
                dari {{ $absensi->total() }} catatan
            </p>
            <div class="pag-btns">
                @if($absensi->onFirstPage())
                    <span class="pag-btn disabled">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $absensi->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
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
                    <a href="{{ $absensi->nextPageUrl() }}" class="pag-btn">
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