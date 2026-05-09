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

    .tab-nav{display:flex;gap:4px;margin-bottom:20px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);padding:4px;width:fit-content;flex-wrap:wrap}
    .tab-link{padding:7px 18px;border-radius:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text3);text-decoration:none;transition:all .15s}
    .tab-link.active{background:var(--surface);color:var(--brand-600);box-shadow:0 1px 3px rgba(0,0,0,.08)}
    .tab-link:hover:not(.active){color:var(--text2)}

    /* Filter */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:20px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row select:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer}
    .btn-filter:hover{background:var(--brand-700)}
    .filter-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text2)}

    /* Summary strip */
    .summary-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:20px}
    .sum-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;position:relative;overflow:hidden}
    .sum-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:4px}
    .sum-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;font-weight:800;color:var(--text);line-height:1}
    .sum-sub{font-size:11px;color:var(--text3);margin-top:4px}
    .sum-bar{position:absolute;bottom:0;left:0;right:0;height:3px;border-radius:0}

    /* Kehadiran meter besar */
    .persen-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:20px 24px;margin-bottom:20px;display:flex;align-items:center;gap:24px;flex-wrap:wrap}
    .persen-circle{width:80px;height:80px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;position:relative}
    .persen-info{}
    .persen-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text);margin-bottom:4px}
    .persen-sub{font-size:12.5px;color:var(--text3)}
    .persen-bar-track{height:8px;background:var(--surface3);border-radius:99px;overflow:hidden;margin-top:8px;width:220px}
    .persen-bar-fill{height:100%;border-radius:99px;transition:width .5s ease}

    /* Rekap per mapel */
    .mapel-section-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text);margin-bottom:12px;display:flex;align-items:center;gap:6px}
    .mapel-table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:20px}
    table{width:100%;border-collapse:collapse}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:10px 16px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    thead th.right{text-align:right}
    tbody tr{border-bottom:1px solid var(--surface3);transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:12px 16px;color:var(--text);vertical-align:middle;font-size:13.5px}
    td.center{text-align:center}
    td.right{text-align:right}

    /* Mini bar dalam tabel */
    .mini-bar-wrap{display:flex;align-items:center;gap:8px}
    .mini-bar-track{flex:1;height:6px;background:var(--surface3);border-radius:99px;overflow:hidden;min-width:60px}
    .mini-bar-fill{height:100%;border-radius:99px}
    .mini-pct{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;min-width:36px;text-align:right}

    /* Badge status kecil */
    .num-badge{display:inline-block;padding:2px 8px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700}
    .num-hadir{background:#dcfce7;color:#15803d}
    .num-izin{background:#eff6ff;color:#1d4ed8}
    .num-sakit{background:#fdf4ff;color:#7c3aed}
    .num-alfa{background:#fee2e2;color:#dc2626}

    /* Empty state */
    .empty-state{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    @media(max-width:900px){.summary-strip{grid-template-columns:repeat(3,1fr)}}
    @media(max-width:600px){.summary-strip{grid-template-columns:1fr 1fr};.page{padding:16px};.tab-nav{width:100%};.tab-link{flex:1;text-align:center;padding:7px 10px};.persen-bar-track{width:140px}}
</style>

<div class="page">
    <h1 class="page-title">Rekap Kehadiran</h1>
    <p class="page-sub">Ringkasan kehadiran per bulan dan per mata pelajaran</p>

    <div class="tab-nav">
        <a href="{{ route('siswa.absensi.scan') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.scan') ? 'active' : '' }}">
            Scan QR
        </a>
        <a href="{{ route('siswa.absensi.jadwal') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.jadwal') ? 'active' : '' }}">
            QR Per Pelajaran
        </a>
        <a href="{{ route('siswa.absensi.riwayat') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.riwayat') ? 'active' : '' }}">
            Riwayat
        </a>
        <a href="{{ route('siswa.absensi.rekap') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.rekap') ? 'active' : '' }}">
            Rekap
        </a>
    </div>

    {{-- Filter bulan & tahun --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('siswa.absensi.rekap') }}">
            <div class="filter-row">
                <span class="filter-label">Periode:</span>

                <select name="bulan">
                    @foreach($bulanList as $b => $namaBulan)
                        <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>{{ $namaBulan }}</option>
                    @endforeach
                </select>

                <select name="tahun">
                    @foreach($tahunList as $t)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                    @if($tahunList->isEmpty())
                        <option value="{{ now()->year }}" selected>{{ now()->year }}</option>
                    @endif
                </select>

                <div class="filter-sep"></div>
                <button type="submit" class="btn-filter">Tampilkan</button>
            </div>
        </form>
    </div>

    @php
        $pct      = $rekap['persen_hadir'];
        $pctColor = $pct >= 80 ? '#15803d' : ($pct >= 60 ? '#ca8a04' : '#dc2626');
        $pctBg    = $pct >= 80 ? '#f0fdf4' : ($pct >= 60 ? '#fefce8' : '#fff5f5');
    @endphp

    {{-- Persentase kehadiran besar --}}
    @if($rekap['total'] > 0)
    <div class="persen-card">
        <div class="persen-circle" style="background:{{ $pctBg }};color:{{ $pctColor }}">
            {{ $pct }}%
        </div>
        <div class="persen-info">
            <p class="persen-title">Tingkat Kehadiran — {{ $bulanList[$bulan] ?? '' }} {{ $tahun }}</p>
            <p class="persen-sub">
                {{ $rekap['hadir'] }} hadir dari {{ $rekap['total'] }} total pertemuan
            </p>
            <div class="persen-bar-track">
                <div class="persen-bar-fill" style="width:{{ $pct }}%;background:{{ $pctColor }}"></div>
            </div>
        </div>
    </div>
    @endif

    {{-- Summary cards --}}
    <div class="summary-strip">
        <div class="sum-card">
            <p class="sum-label">Total</p>
            <p class="sum-val">{{ $rekap['total'] }}</p>
            <p class="sum-sub">pertemuan</p>
            <div class="sum-bar" style="background:var(--border)"></div>
        </div>
        <div class="sum-card">
            <p class="sum-label">Hadir</p>
            <p class="sum-val" style="color:#15803d">{{ $rekap['hadir'] }}</p>
            <p class="sum-sub">termasuk telat</p>
            <div class="sum-bar" style="background:#15803d;width:{{ $rekap['total'] > 0 ? round($rekap['hadir']/$rekap['total']*100) : 0 }}%"></div>
        </div>
        <div class="sum-card">
            <p class="sum-label">Izin</p>
            <p class="sum-val" style="color:#1d4ed8">{{ $rekap['izin'] }}</p>
            <p class="sum-sub">hari izin</p>
            <div class="sum-bar" style="background:#3b82f6;width:{{ $rekap['total'] > 0 ? round($rekap['izin']/$rekap['total']*100) : 0 }}%"></div>
        </div>
        <div class="sum-card">
            <p class="sum-label">Sakit</p>
            <p class="sum-val" style="color:#7c3aed">{{ $rekap['sakit'] }}</p>
            <p class="sum-sub">hari sakit</p>
            <div class="sum-bar" style="background:#a855f7;width:{{ $rekap['total'] > 0 ? round($rekap['sakit']/$rekap['total']*100) : 0 }}%"></div>
        </div>
        <div class="sum-card">
            <p class="sum-label">Alfa</p>
            <p class="sum-val" style="color:#dc2626">{{ $rekap['alfa'] }}</p>
            <p class="sum-sub">tanpa keterangan</p>
            <div class="sum-bar" style="background:#dc2626;width:{{ $rekap['total'] > 0 ? round($rekap['alfa']/$rekap['total']*100) : 0 }}%"></div>
        </div>
    </div>

    {{-- Rekap per mata pelajaran --}}
    <p class="mapel-section-title">
        <svg width="14" height="14" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
        </svg>
        Rekap Per Mata Pelajaran
    </p>

    @if($rekapPerMapel->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                </svg>
            </div>
            <p class="empty-title">Tidak ada data</p>
            <p class="empty-sub">
                Belum ada catatan absensi untuk
                {{ $bulanList[$bulan] ?? '' }} {{ $tahun }}
            </p>
        </div>
    @else
        <div class="mapel-table-card">
            <table>
                <thead>
                    <tr>
                        <th style="width:30px">#</th>
                        <th>Mata Pelajaran</th>
                        <th class="center">Hadir</th>
                        <th class="center">Izin</th>
                        <th class="center">Sakit</th>
                        <th class="center">Alfa</th>
                        <th class="right" style="min-width:160px">Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekapPerMapel as $idx => $item)
                    @php
                        $pctMapel = $item['total'] > 0
                            ? round($item['hadir'] / $item['total'] * 100, 1)
                            : 0;
                        $colorMapel = $pctMapel >= 80 ? '#15803d' : ($pctMapel >= 60 ? '#ca8a04' : '#dc2626');
                    @endphp
                    <tr>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)">
                            {{ $idx + 1 }}
                        </td>
                        <td>
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text)">
                                {{ $item['nama_mapel'] }}
                            </p>
                            <p style="font-size:11.5px;color:var(--text3);margin-top:1px">
                                {{ $item['total'] }} pertemuan
                            </p>
                        </td>
                        <td class="center">
                            <span class="num-badge num-hadir">{{ $item['hadir'] }}</span>
                        </td>
                        <td class="center">
                            @if($item['izin'] > 0)
                                <span class="num-badge num-izin">{{ $item['izin'] }}</span>
                            @else
                                <span style="color:var(--text3)">—</span>
                            @endif
                        </td>
                        <td class="center">
                            @if($item['sakit'] > 0)
                                <span class="num-badge num-sakit">{{ $item['sakit'] }}</span>
                            @else
                                <span style="color:var(--text3)">—</span>
                            @endif
                        </td>
                        <td class="center">
                            @if($item['alfa'] > 0)
                                <span class="num-badge num-alfa">{{ $item['alfa'] }}</span>
                            @else
                                <span style="color:var(--text3)">—</span>
                            @endif
                        </td>
                        <td class="right">
                            <div class="mini-bar-wrap" style="justify-content:flex-end">
                                <div class="mini-bar-track">
                                    <div class="mini-bar-fill" style="width:{{ $pctMapel }}%;background:{{ $colorMapel }}"></div>
                                </div>
                                <span class="mini-pct" style="color:{{ $colorMapel }}">{{ $pctMapel }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Link ke riwayat detail --}}
    <div style="text-align:center;margin-top:8px">
        <a href="{{ route('siswa.absensi.riwayat', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
           style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--brand-600);text-decoration:none">
            Lihat riwayat detail bulan ini →
        </a>
    </div>
</div>
</x-app-layout>