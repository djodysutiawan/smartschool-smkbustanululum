<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root{
        --brand:#0f766e;--brand-50:#f0fdfa;--brand-100:#ccfbf1;--brand-200:#99f6e4;--brand-600:#0d9488;--brand-700:#0f766e;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:12px;--radius-sm:8px;
        --hadir:#dcfce7;--hadir-text:#15803d;
        --telat:#fff3cd;--telat-text:#a16207;
        --izin:#dbeafe;--izin-text:#1d4ed8;
        --sakit:#fce7f3;--sakit-text:#be185d;
        --alfa:#fee2e2;--alfa-text:#dc2626;
    }
    *{box-sizing:border-box}
    .page{padding:28px 28px 60px;max-width:1400px;margin:0 auto}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:13px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}

    /* Anak selector */
    .anak-selector{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px}
    .anak-chip{display:inline-flex;align-items:center;gap:8px;padding:7px 16px;border-radius:99px;border:1.5px solid var(--border);background:var(--surface);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);text-decoration:none;transition:all .15s}
    .anak-chip:hover{border-color:var(--brand-600);color:var(--brand-700)}
    .anak-chip.active{background:var(--brand-700);border-color:var(--brand-700);color:#fff}
    .anak-avatar{width:22px;height:22px;border-radius:50%;background:var(--brand-100);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:var(--brand-700);flex-shrink:0}
    .anak-chip.active .anak-avatar{background:rgba(255,255,255,.25);color:#fff}

    /* Filter bulan/tahun */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:20px}
    .filter-row{display:flex;align-items:flex-end;gap:12px;flex-wrap:wrap}
    .filter-group{display:flex;flex-direction:column;gap:5px}
    .filter-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .filter-select{height:36px;padding:0 12px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s;min-width:120px}
    .filter-select:focus{border-color:var(--brand-600)}
    .btn-filter{height:36px;padding:0 18px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;background:var(--brand-700);color:#fff;display:inline-flex;align-items:center;gap:6px}
    .btn-filter:hover{filter:brightness(.93)}

    /* Rekap strip */
    .rekap-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .rekap-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;display:flex;align-items:center;gap:14px}
    .rekap-icon{width:44px;height:44px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0}
    .rekap-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase}
    .rekap-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;font-weight:800;line-height:1.1;margin-top:2px}

    /* Calendar grid */
    .section-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .section-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between}
    .section-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px}
    .section-body{padding:20px}

    .cal-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:6px}
    .cal-day-header{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-align:center;padding:4px 0;text-transform:uppercase;letter-spacing:.05em}
    .cal-day-header.weekend{color:#dc2626}
    .cal-day{border-radius:8px;aspect-ratio:1;display:flex;flex-direction:column;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:default;position:relative;transition:transform .1s;border:1.5px solid transparent}
    .cal-day.empty{background:transparent}
    .cal-day.no-data{background:var(--surface2);color:var(--text3);border-color:var(--border)}
    .cal-day.hadir{background:var(--hadir);color:var(--hadir-text);border-color:#bbf7d0}
    .cal-day.telat{background:var(--telat);color:var(--telat-text);border-color:#fde68a}
    .cal-day.izin{background:var(--izin);color:var(--izin-text);border-color:#bfdbfe}
    .cal-day.sakit{background:var(--sakit);color:var(--sakit-text);border-color:#fbcfe8}
    .cal-day.alfa{background:var(--alfa);color:var(--alfa-text);border-color:#fecaca}
    .cal-day.today{box-shadow:0 0 0 2px var(--brand-700)}
    .cal-day:not(.empty):not(.no-data):hover{transform:scale(1.08)}
    .cal-status-dot{width:5px;height:5px;border-radius:50%;background:currentColor;margin-top:2px;opacity:.7}

    /* Legend */
    .legend{display:flex;gap:12px;flex-wrap:wrap;align-items:center}
    .legend-item{display:flex;align-items:center;gap:6px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text2)}
    .legend-dot{width:12px;height:12px;border-radius:3px}

    /* Chart container */
    .chart-wrap{padding:20px;height:260px;position:relative}

    /* Badge inline */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .b-hadir{background:var(--hadir);color:var(--hadir-text)}
    .b-telat{background:var(--telat);color:var(--telat-text)}
    .b-izin{background:var(--izin);color:var(--izin-text)}
    .b-sakit{background:var(--sakit);color:var(--sakit-text)}
    .b-alfa{background:var(--alfa);color:var(--alfa-text)}

    @media(max-width:768px){.rekap-strip{grid-template-columns:1fr 1fr}.page{padding:16px}}
    @media(max-width:480px){.cal-day{font-size:11px}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Rekap Bulanan</h1>
            <p class="page-sub">
                Kehadiran {{ $anak->nama_lengkap }} —
                @php
                    $namaBulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                @endphp
                {{ $namaBulan[$bulan] }} {{ $tahun }}
            </p>
        </div>
        <a href="{{ route('ortu.absensi.riwayat', ['siswa_id' => $anak->id]) }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);background:var(--surface2);color:var(--text2);border:1.5px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;text-decoration:none">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Riwayat Detail
        </a>
    </div>

    {{-- Selector anak --}}
    @if($anakList->count() > 1)
    <div class="anak-selector">
        @foreach($anakList as $a)
        <a href="{{ route('ortu.absensi.rekap', ['siswa_id' => $a->id, 'bulan' => $bulan, 'tahun' => $tahun]) }}"
           class="anak-chip {{ $anak->id === $a->id ? 'active' : '' }}">
            <div class="anak-avatar">{{ strtoupper(substr($a->nama_lengkap, 0, 1)) }}</div>
            {{ $a->nama_lengkap }}
        </a>
        @endforeach
    </div>
    @endif

    {{-- Filter bulan & tahun --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('ortu.absensi.rekap') }}">
            @if(request('siswa_id'))
                <input type="hidden" name="siswa_id" value="{{ request('siswa_id') }}">
            @endif
            <div class="filter-row">
                <div class="filter-group">
                    <label class="filter-label">Bulan</label>
                    <select name="bulan" class="filter-select">
                        @foreach($namaBulan as $num => $nama)
                            @if($num > 0)
                            <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $nama }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Tahun</label>
                    <select name="tahun" class="filter-select">
                        @foreach($tahunList as $t)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-filter">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    Tampilkan
                </button>
            </div>
        </form>
    </div>

    {{-- Rekap angka bulan ini --}}
    <div class="rekap-strip">
        <div class="rekap-card">
            <div class="rekap-icon" style="background:var(--hadir)">✅</div>
            <div>
                <p class="rekap-label">Hadir</p>
                <p class="rekap-val" style="color:var(--hadir-text)">{{ $rekapBulan['hadir'] }}</p>
            </div>
        </div>
        <div class="rekap-card">
            <div class="rekap-icon" style="background:var(--izin)">📋</div>
            <div>
                <p class="rekap-label">Izin</p>
                <p class="rekap-val" style="color:var(--izin-text)">{{ $rekapBulan['izin'] }}</p>
            </div>
        </div>
        <div class="rekap-card">
            <div class="rekap-icon" style="background:var(--sakit)">🤒</div>
            <div>
                <p class="rekap-label">Sakit</p>
                <p class="rekap-val" style="color:var(--sakit-text)">{{ $rekapBulan['sakit'] }}</p>
            </div>
        </div>
        <div class="rekap-card">
            <div class="rekap-icon" style="background:var(--alfa)">❌</div>
            <div>
                <p class="rekap-label">Alfa</p>
                <p class="rekap-val" style="color:var(--alfa-text)">{{ $rekapBulan['alfa'] }}</p>
            </div>
        </div>
    </div>

    {{-- Kalender bulanan --}}
    <div class="section-card">
        <div class="section-header">
            <span class="section-title">
                <svg width="14" height="14" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Kalender Kehadiran — {{ $namaBulan[$bulan] }} {{ $tahun }}
            </span>
            <div class="legend">
                <div class="legend-item"><div class="legend-dot" style="background:var(--hadir);border:1px solid #bbf7d0"></div>Hadir</div>
                <div class="legend-item"><div class="legend-dot" style="background:var(--telat);border:1px solid #fde68a"></div>Telat</div>
                <div class="legend-item"><div class="legend-dot" style="background:var(--izin);border:1px solid #bfdbfe"></div>Izin</div>
                <div class="legend-item"><div class="legend-dot" style="background:var(--sakit);border:1px solid #fbcfe8"></div>Sakit</div>
                <div class="legend-item"><div class="legend-dot" style="background:var(--alfa);border:1px solid #fecaca"></div>Alfa</div>
            </div>
        </div>
        <div class="section-body">
            @php
                $hariHeaders = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
                $firstDay    = \Carbon\Carbon::createFromDate($tahun, $bulan, 1);
                $totalDays   = $firstDay->daysInMonth;
                // dayOfWeek: 0=Sun, 1=Mon, ...6=Sat → kita pakai 0-indexed Sun pertama
                $startOffset = $firstDay->dayOfWeek; // 0=Sun
                $today       = now();
            @endphp
            <div class="cal-grid">
                {{-- Header hari --}}
                @foreach($hariHeaders as $hi => $h)
                <div class="cal-day-header {{ $hi === 0 || $hi === 6 ? 'weekend' : '' }}">{{ $h }}</div>
                @endforeach

                {{-- Offset kosong sebelum hari pertama --}}
                @for($e = 0; $e < $startOffset; $e++)
                <div class="cal-day empty"></div>
                @endfor

                {{-- Hari-hari dalam bulan --}}
                @for($d = 1; $d <= $totalDays; $d++)
                @php
                    $dayStr   = str_pad($d, 2, '0', STR_PAD_LEFT);
                    $absenDay = $absensiList->get($dayStr);
                    $status   = $absenDay?->status ?? null;
                    $isToday  = $today->year == $tahun && $today->month == $bulan && $today->day == $d;
                    $calClass = $status ? $status : 'no-data';
                @endphp
                <div class="cal-day {{ $calClass }} {{ $isToday ? 'today' : '' }}"
                     title="{{ $status ? ucfirst($status) : 'Tidak ada data' }} — {{ $d }} {{ $namaBulan[$bulan] }} {{ $tahun }}">
                    {{ $d }}
                    @if($status)
                    <div class="cal-status-dot"></div>
                    @endif
                </div>
                @endfor
            </div>
        </div>
    </div>

    {{-- Chart tren tahunan --}}
    <div class="section-card">
        <div class="section-header">
            <span class="section-title">
                <svg width="14" height="14" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                Tren Kehadiran Sepanjang {{ $tahun }}
            </span>
        </div>
        <div class="chart-wrap">
            <canvas id="trendChart"></canvas>
        </div>
    </div>

    {{-- Daftar detail hari dalam bulan --}}
    @if($absensiList->isNotEmpty())
    <div class="section-card">
        <div class="section-header">
            <span class="section-title">
                <svg width="14" height="14" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                Detail Absensi {{ $namaBulan[$bulan] }} {{ $tahun }}
            </span>
        </div>
        <div style="overflow-x:auto">
            <table style="width:100%;border-collapse:collapse;font-size:13.5px">
                <thead>
                    <tr style="background:var(--surface2);border-bottom:1px solid var(--border)">
                        <th style="padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase">Tanggal</th>
                        <th style="padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase">Hari</th>
                        <th style="padding:11px 14px;text-align:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase">Status</th>
                        <th style="padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase">Jam Masuk</th>
                        <th style="padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absensiList as $dayStr => $ab)
                    <tr style="border-bottom:1px solid #f1f5f9">
                        <td style="padding:11px 14px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px">
                            {{ $ab->tanggal->translatedFormat('d M Y') }}
                        </td>
                        <td style="padding:11px 14px;color:var(--text3);font-size:12.5px;font-family:'DM Sans',sans-serif">
                            {{ $ab->tanggal->translatedFormat('l') }}
                        </td>
                        <td style="padding:11px 14px;text-align:center">
                            <span class="badge b-{{ $ab->status }}">
                                {{ ucfirst($ab->status) }}
                            </span>
                        </td>
                        <td style="padding:11px 14px;color:var(--text3);font-size:13px;font-family:'DM Sans',sans-serif">
                            {{ $ab->jam_masuk ? \Carbon\Carbon::parse($ab->jam_masuk)->format('H:i') : '—' }}
                        </td>
                        <td style="padding:11px 14px;color:var(--text2);font-size:13px;font-family:'DM Sans',sans-serif;max-width:200px">
                            @if($ab->keterangan)
                                {{ $ab->keterangan }}
                            @elseif($ab->path_surat_izin)
                                <a href="{{ $ab->surat_izin_url }}" target="_blank"
                                   style="color:var(--brand-700);font-weight:700;text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px">
                                    Lihat Surat →
                                </a>
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    var labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    var hadirData = @json(array_column($rekapTahunan, 'hadir'));
    var alfaData  = @json(array_column($rekapTahunan, 'alfa'));

    var ctx = document.getElementById('trendChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Hadir',
                    data: hadirData,
                    backgroundColor: '#dcfce7',
                    borderColor: '#15803d',
                    borderWidth: 1.5,
                    borderRadius: 6,
                },
                {
                    label: 'Alfa',
                    data: alfaData,
                    backgroundColor: '#fee2e2',
                    borderColor: '#dc2626',
                    borderWidth: 1.5,
                    borderRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: { family: "'Plus Jakarta Sans', sans-serif", weight: '700', size: 12 },
                        usePointStyle: true,
                        pointStyle: 'rectRounded',
                        padding: 16,
                    }
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleFont: { family: "'Plus Jakarta Sans', sans-serif", weight: '700' },
                    bodyFont:  { family: "'DM Sans', sans-serif" },
                    padding: 12,
                    cornerRadius: 8,
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { family: "'Plus Jakarta Sans', sans-serif", weight: '600', size: 11 } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        font: { family: "'DM Sans', sans-serif", size: 11 },
                        stepSize: 1,
                        precision: 0
                    }
                }
            }
        }
    });
})();
</script>
</x-app-layout>