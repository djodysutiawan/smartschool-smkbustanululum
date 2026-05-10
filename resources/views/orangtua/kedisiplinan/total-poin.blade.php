<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap');
    :root{
        --brand:#7c3aed;--brand-50:#faf5ff;--brand-100:#ede9fe;--brand-600:#7c3aed;--brand-700:#6d28d9;--brand-800:#5b21b6;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--surface4:#e8edf5;
        --border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:14px;--radius-sm:9px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);
        --shadow:0 4px 16px rgba(0,0,0,.07),0 1px 3px rgba(0,0,0,.04);
        --ringan-bg:#dbeafe;--ringan-text:#1d4ed8;--ringan-border:#bfdbfe;
        --sedang-bg:#fef3c7;--sedang-text:#92400e;--sedang-border:#fde68a;
        --berat-bg:#fee2e2;--berat-text:#dc2626;--berat-border:#fecaca;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    .page{padding:28px 28px 72px;max-width:1440px;margin:0 auto;font-family:'DM Sans',sans-serif}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px;gap:16px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:800;color:var(--text);letter-spacing:-.02em}
    .page-sub{font-size:13px;color:var(--text3);margin-top:4px}

    .anak-selector{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:22px}
    .anak-chip{display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:99px;border:1.5px solid var(--border);background:var(--surface);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);text-decoration:none;transition:all .18s;box-shadow:var(--shadow-sm)}
    .anak-chip:hover{border-color:var(--brand-600);color:var(--brand-700)}
    .anak-chip.active{background:var(--brand-700);border-color:var(--brand-700);color:#fff;box-shadow:0 4px 12px rgba(109,40,217,.35)}
    .anak-avatar{width:24px;height:24px;border-radius:50%;background:var(--brand-100);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:var(--brand-700);flex-shrink:0}
    .anak-chip.active .anak-avatar{background:rgba(255,255,255,.25);color:#fff}

    .nav-tabs{display:flex;gap:2px;background:var(--surface3);padding:4px;border-radius:10px;margin-bottom:22px;width:fit-content}
    .nav-tab{display:inline-flex;align-items:center;gap:7px;padding:8px 16px;border-radius:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);text-decoration:none;transition:all .18s}
    .nav-tab:hover{color:var(--text)}
    .nav-tab.active{background:var(--surface);color:var(--brand-700);box-shadow:var(--shadow-sm);font-weight:700}

    /* Tahun selector */
    .tahun-selector{display:flex;gap:6px;margin-bottom:22px;flex-wrap:wrap;align-items:center}
    .tahun-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-right:4px}
    .tahun-btn{height:34px;padding:0 14px;border-radius:8px;border:1.5px solid var(--border);background:var(--surface);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);text-decoration:none;display:inline-flex;align-items:center;transition:all .15s;box-shadow:var(--shadow-sm)}
    .tahun-btn:hover{border-color:var(--brand-600);color:var(--brand-700)}
    .tahun-btn.active{background:var(--brand-700);border-color:var(--brand-700);color:#fff;box-shadow:0 2px 8px rgba(109,40,217,.25)}

    /* Stats grid */
    .stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:22px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:22px 24px;box-shadow:var(--shadow-sm);position:relative;overflow:hidden}
    .stat-card.hero{background:linear-gradient(140deg,#5b21b6 0%,#7c3aed 45%,#a855f7 100%);border:none;box-shadow:0 8px 32px rgba(109,40,217,.3)}
    .stat-card.hero *{color:#fff !important}
    .stat-deco{position:absolute;right:-20px;bottom:-20px;width:100px;height:100px;border-radius:50%;background:rgba(255,255,255,.07)}
    .stat-icon{width:44px;height:44px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:20px;margin-bottom:14px}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:40px;font-weight:800;color:var(--text);line-height:1;letter-spacing:-.04em}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px}
    .stat-sub{font-size:12.5px;color:var(--text3);margin-top:6px}

    /* Tingkat rekap dalam stat */
    .tingkat-row{display:flex;gap:8px;flex-wrap:wrap;margin-top:14px}
    .tingkat-chip{display:inline-flex;align-items:center;gap:6px;padding:5px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;border:1.5px solid}
    .t-ringan{background:var(--ringan-bg);color:var(--ringan-text);border-color:var(--ringan-border)}
    .t-sedang{background:var(--sedang-bg);color:var(--sedang-text);border-color:var(--sedang-border)}
    .t-berat {background:var(--berat-bg) ;color:var(--berat-text) ;border-color:var(--berat-border)}

    /* Chart card */
    .chart-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:22px 24px;margin-bottom:16px;box-shadow:var(--shadow-sm)}
    .chart-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:8px}
    .chart-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text)}
    .chart-sub{font-size:12.5px;color:var(--text3);margin-top:2px}
    .chart-area{display:flex;align-items:flex-end;gap:6px;height:160px;padding-bottom:28px;position:relative}
    .chart-area::after{content:'';position:absolute;bottom:28px;left:0;right:0;height:1px;background:var(--border);pointer-events:none}
    .bar-wrap{flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;position:relative;cursor:default}
    .bar{width:100%;border-radius:6px 6px 0 0;transition:opacity .15s,filter .15s;min-height:3px;position:relative}
    .bar:hover{filter:brightness(.9)}
    .bar-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:800;color:var(--text3);position:absolute;top:-18px;left:50%;transform:translateX(-50%);white-space:nowrap}
    .bar-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);position:absolute;bottom:-22px;left:50%;transform:translateX(-50%);white-space:nowrap}
    .bar-label.now{color:var(--brand-700)}
    .bar.now{box-shadow:0 0 0 2px var(--brand-100)}

    /* Tabel bulanan */
    .month-table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-sm)}
    .section-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em;display:flex;align-items:center;gap:8px}
    .section-title::after{content:'';flex:1;height:1px;background:var(--border)}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1.5px solid var(--border)}
    thead th{padding:11px 16px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.06em;text-transform:uppercase}
    thead th.right{text-align:right}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid var(--surface3);transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:var(--brand-50)}
    tbody tr.bulan-ini{background:var(--brand-50);font-weight:600}
    td{padding:12px 16px;vertical-align:middle}
    td.right{text-align:right}
    td.center{text-align:center}
    td.muted{color:var(--text3);font-size:12.5px}
    .progress-wrap{width:100%;background:var(--surface3);border-radius:99px;height:6px;overflow:hidden;min-width:80px}
    .progress-bar{height:6px;border-radius:99px;transition:width .3s ease}
    .badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;border:1px solid}
    .b-none{background:var(--surface3);color:var(--text3);border-color:var(--border)}
    .b-low{background:var(--ringan-bg);color:var(--ringan-text);border-color:var(--ringan-border)}
    .b-mid{background:var(--sedang-bg);color:var(--sedang-text);border-color:var(--sedang-border)}
    .b-high{background:var(--berat-bg);color:var(--berat-text);border-color:var(--berat-border)}

    .poin-besar{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text)}
    .poin-nol{color:var(--text3)}

    .tabel-topbar{padding:16px 22px;border-bottom:1px solid var(--border)}

    @media(max-width:900px){.stats-grid{grid-template-columns:1fr 1fr}}
    @media(max-width:600px){.stats-grid{grid-template-columns:1fr}.page{padding:16px 14px}.chart-area{gap:3px}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Total Poin Kedisiplinan</h1>
            <p class="page-sub">Ringkasan dan tren poin pelanggaran per tahun</p>
        </div>
    </div>

    {{-- Nav tabs --}}
    <div class="nav-tabs">
        <a href="{{ route('ortu.kedisiplinan.riwayat', array_filter(['siswa_id' => $anak->id])) }}" class="nav-tab">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Riwayat
        </a>
        <a href="{{ route('ortu.kedisiplinan.total-poin', array_filter(['siswa_id' => $anak->id])) }}" class="nav-tab active">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Total Poin
        </a>
        <a href="{{ route('ortu.kedisiplinan.status', array_filter(['siswa_id' => $anak->id])) }}" class="nav-tab">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
            Status Aktif
        </a>
    </div>

    {{-- Selector anak --}}
    @if($anakList->count() > 1)
    <div class="anak-selector">
        @foreach($anakList as $a)
        <a href="{{ route('ortu.kedisiplinan.total-poin', array_filter(['siswa_id' => $a->id, 'tahun' => $tahun])) }}"
           class="anak-chip {{ $anak->id === $a->id ? 'active' : '' }}">
            <div class="anak-avatar">{{ strtoupper(mb_substr($a->nama_lengkap, 0, 1)) }}</div>
            {{ $a->nama_lengkap }}
            @if($a->kelas)<span style="font-size:11px;opacity:.7">· {{ $a->kelas->nama_kelas }}</span>@endif
        </a>
        @endforeach
    </div>
    @endif

    {{-- Tahun selector --}}
    <div class="tahun-selector">
        <span class="tahun-label">Tahun:</span>
        @foreach($tahunList as $t)
        <a href="{{ route('ortu.kedisiplinan.total-poin', array_filter(['siswa_id' => $anak->id, 'tahun' => $t])) }}"
           class="tahun-btn {{ $tahun == $t ? 'active' : '' }}">{{ $t }}</a>
        @endforeach
    </div>

    {{-- Stats grid --}}
    @php
        $maxPoin    = $trenBulanan->max('poin');
        $bulanNames = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $bulanNow   = now()->month;
    @endphp

    <div class="stats-grid">
        {{-- Hero --}}
        <div class="stat-card hero">
            <div class="stat-deco"></div>
            <p class="stat-label">Total Poin {{ $tahun }}</p>
            <p class="stat-val">{{ $totalPoin }}</p>
            <p class="stat-sub">{{ $anak->nama_lengkap }} · {{ $anak->kelas->nama_kelas ?? '—' }}</p>
        </div>

        {{-- Total kasus --}}
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--surface3)">📋</div>
            <p class="stat-label">Total Kasus</p>
            <p class="stat-val" style="font-size:36px">{{ $totalKasus }}</p>
            <p class="stat-sub">pelanggaran tercatat tahun {{ $tahun }}</p>
        </div>

        {{-- Rekap per tingkat --}}
        <div class="stat-card">
            <p class="stat-label" style="margin-bottom:14px">Rekap Tingkat {{ $tahun }}</p>
            <div class="tingkat-row">
                <span class="tingkat-chip t-berat">
                    Berat <strong>{{ $rekapTingkat['berat']->total ?? 0 }}</strong>
                </span>
                <span class="tingkat-chip t-sedang">
                    Sedang <strong>{{ $rekapTingkat['sedang']->total ?? 0 }}</strong>
                </span>
                <span class="tingkat-chip t-ringan">
                    Ringan <strong>{{ $rekapTingkat['ringan']->total ?? 0 }}</strong>
                </span>
            </div>
            @if($bulanTertinggi && $bulanTertinggi['poin'] > 0)
            <p class="stat-sub" style="margin-top:14px">
                📈 Puncak: <strong>{{ $bulanNames[$bulanTertinggi['bulan'] - 1] }}</strong>
                ({{ $bulanTertinggi['poin'] }} poin)
            </p>
            @endif
        </div>
    </div>

    {{-- Bar chart tren --}}
    <div class="chart-card">
        <div class="chart-header">
            <div>
                <p class="chart-title">Tren Poin Bulanan</p>
                <p class="chart-sub">Akumulasi poin pelanggaran per bulan tahun {{ $tahun }}</p>
            </div>
        </div>
        <div class="chart-area">
            @foreach($trenBulanan as $t)
            @php
                $heightPct = $maxPoin > 0 ? ($t['poin'] / $maxPoin) * 100 : 0;
                $isNow     = ($tahun == now()->year && $t['bulan'] == $bulanNow);
                $barColor  = $t['poin'] === 0 ? 'var(--surface3)'
                    : ($t['poin'] >= 15 ? '#dc2626'
                        : ($t['poin'] >= 8 ? '#f59e0b' : '#6d28d9'));
                $barH      = max($heightPct, $t['poin'] > 0 ? 4 : 2);
            @endphp
            <div class="bar-wrap">
                <div class="bar {{ $isNow ? 'now' : '' }}"
                     style="height:{{ $barH }}%;background:{{ $barColor }};opacity:{{ $isNow ? '1' : '.85' }}">
                    @if($t['poin'] > 0)
                    <span class="bar-val">{{ $t['poin'] }}</span>
                    @endif
                </div>
                <span class="bar-label {{ $isNow ? 'now' : '' }}">{{ $bulanNames[$t['bulan']-1] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Tabel detail per bulan --}}
    <div class="month-table-card">
        <div class="tabel-topbar">
            <p class="section-title">Detail Per Bulan — {{ $tahun }}</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th class="right">Kasus</th>
                    <th class="right">Poin</th>
                    <th>Proporsi</th>
                    <th class="center">Level</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trenBulanan as $t)
                @php
                    $isNow  = ($tahun == now()->year && $t['bulan'] == $bulanNow);
                    $pct    = $totalPoin > 0 ? round(($t['poin'] / $totalPoin) * 100) : 0;
                    $barCol = $t['poin'] === 0 ? 'var(--surface3)'
                        : ($t['poin'] >= 15 ? '#dc2626' : ($t['poin'] >= 8 ? '#f59e0b' : '#6d28d9'));
                    $levelBadge = $t['poin'] === 0 ? 'b-none'
                        : ($t['poin'] >= 15 ? 'b-high' : ($t['poin'] >= 8 ? 'b-mid' : 'b-low'));
                    $levelLabel = $t['poin'] === 0 ? 'Aman'
                        : ($t['poin'] >= 15 ? 'Tinggi' : ($t['poin'] >= 8 ? 'Sedang' : 'Rendah'));
                @endphp
                <tr class="{{ $isNow ? 'bulan-ini' : '' }}">
                    <td>
                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:{{ $isNow ? '800' : '600' }};font-size:13.5px;color:{{ $isNow ? 'var(--brand-700)' : 'var(--text)' }}">
                            {{ $bulanNames[$t['bulan']-1] }}
                            @if($isNow)<span style="font-size:10px;background:var(--brand-100);color:var(--brand-700);padding:2px 7px;border-radius:99px;margin-left:6px;font-weight:700">Ini</span>@endif
                        </span>
                    </td>
                    <td class="right">
                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:{{ $t['total_kasus'] > 0 ? 'var(--text)' : 'var(--text3)' }}">
                            {{ $t['total_kasus'] }}
                        </span>
                    </td>
                    <td class="right">
                        <span class="poin-besar {{ $t['poin'] === 0 ? 'poin-nol' : '' }}">{{ $t['poin'] }}</span>
                    </td>
                    <td style="min-width:120px">
                        @if($t['poin'] > 0)
                        <div style="display:flex;align-items:center;gap:8px">
                            <div class="progress-wrap">
                                <div class="progress-bar" style="width:{{ $pct }}%;background:{{ $barCol }}"></div>
                            </div>
                            <span style="font-size:12px;color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;min-width:28px">{{ $pct }}%</span>
                        </div>
                        @else
                        <span style="font-size:12px;color:var(--text3)">—</span>
                        @endif
                    </td>
                    <td class="center">
                        <span class="badge {{ $levelBadge }}">{{ $levelLabel }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
</x-app-layout>