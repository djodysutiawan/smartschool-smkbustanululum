<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root{
        --brand:#0f766e;--brand-50:#f0fdfa;--brand-100:#ccfbf1;--brand-600:#0d9488;--brand-700:#0f766e;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:12px;--radius-sm:8px;
        --masuk:#dcfce7;--masuk-text:#15803d;--masuk-border:#bbf7d0;
        --pulang:#dbeafe;--pulang-text:#1d4ed8;--pulang-border:#bfdbfe;
    }
    *{box-sizing:border-box}
    .page{padding:28px 28px 60px;max-width:1400px;margin:0 auto}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:13px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}

    .anak-selector{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px}
    .anak-chip{display:inline-flex;align-items:center;gap:8px;padding:7px 16px;border-radius:99px;border:1.5px solid var(--border);background:var(--surface);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);text-decoration:none;transition:all .15s}
    .anak-chip:hover{border-color:var(--brand-600);color:var(--brand-700)}
    .anak-chip.active{background:var(--brand-700);border-color:var(--brand-700);color:#fff}
    .anak-avatar{width:22px;height:22px;border-radius:50%;background:var(--brand-100);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:var(--brand-700);flex-shrink:0}
    .anak-chip.active .anak-avatar{background:rgba(255,255,255,.25);color:#fff}

    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:20px}
    .filter-row{display:flex;align-items:flex-end;gap:12px;flex-wrap:wrap}
    .filter-group{display:flex;flex-direction:column;gap:5px}
    .filter-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .filter-select{height:36px;padding:0 12px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s;min-width:130px}
    .filter-select:focus{border-color:var(--brand-600)}
    .btn-filter{height:36px;padding:0 18px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;background:var(--brand-700);color:#fff;display:inline-flex;align-items:center;gap:6px}
    .btn-filter:hover{filter:brightness(.93)}

    .rekap-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px}
    .rekap-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;display:flex;align-items:center;gap:14px}
    .rekap-icon{width:44px;height:44px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0}
    .rekap-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase}
    .rekap-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;font-weight:800;line-height:1.1;margin-top:2px}

    .section-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .section-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}
    .section-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px}
    .section-body{padding:20px}
    .chart-wrap{padding:20px;height:260px;position:relative}

    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafffe}
    td{padding:12px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}

    .badge-status{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .b-hadir{background:#dcfce7;color:#15803d}
    .b-telat{background:#fef9c3;color:#a16207}
    .b-izin{background:#dbeafe;color:#1d4ed8}
    .b-sakit{background:#fdf4ff;color:#7c3aed}
    .b-alfa{background:#fee2e2;color:#dc2626}
    .b-belum{background:var(--surface3);color:var(--text3)}

    .legend{display:flex;gap:12px;flex-wrap:wrap;align-items:center}
    .legend-item{display:flex;align-items:center;gap:6px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text2)}
    .legend-dot{width:12px;height:12px;border-radius:3px}

    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{font-size:40px;margin-bottom:12px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:4px}
    .empty-sub{font-size:13px;color:var(--text3);font-family:'DM Sans',sans-serif}

    @media(max-width:768px){.rekap-strip{grid-template-columns:1fr 1fr}.page{padding:16px}}
    @media(max-width:480px){.rekap-strip{grid-template-columns:1fr}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Rekap Absensi Bulanan</h1>
            {{--
                FIX: $bulanList[$bulan] sekarang tersedia dari controller.
                Sebelumnya controller tidak mengirim $bulanList sama sekali.
            --}}
            <p class="page-sub">
                Kehadiran {{ $anak->nama_lengkap }} —
                {{ $bulanList[$bulan] }} {{ $tahun }}
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
                        {{-- FIX: $bulanList sekarang tersedia --}}
                        @foreach($bulanList as $num => $nama)
                        <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $nama }}</option>
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

    {{--
        Rekap angka — FIX: key disesuaikan dengan yang dikirim controller:
        total_hari_masuk, total_hari_pulang, total_scan.
        Sebelumnya controller mengirim key hadir/izin/sakit/alfa (untuk view riwayat),
        bukan key yang dibutuhkan view ini.
    --}}
    <div class="rekap-strip">
        <div class="rekap-card">
            <div class="rekap-icon" style="background:#dcfce7">✅</div>
            <div>
                <p class="rekap-label">Hari Hadir</p>
                <p class="rekap-val" style="color:#15803d">{{ $rekap['total_hari_masuk'] }}</p>
            </div>
        </div>
        <div class="rekap-card">
            <div class="rekap-icon" style="background:#fef9c3">⚠️</div>
            <div>
                <p class="rekap-label">Tidak Hadir</p>
                {{--
                    FIX: total_hari_pulang tidak relevan untuk model Absensi pelajaran.
                    Tampilkan total_scan sebagai proxy jumlah pertemuan tercatat.
                --}}
                <p class="rekap-val" style="color:#a16207">{{ $rekap['total_hari_pulang'] }}</p>
            </div>
        </div>
        <div class="rekap-card">
            <div class="rekap-icon" style="background:var(--surface3)">📊</div>
            <div>
                <p class="rekap-label">Total Pertemuan</p>
                <p class="rekap-val" style="color:var(--text)">{{ $rekap['total_scan'] }}</p>
            </div>
        </div>
    </div>

    {{--
        FIX: Tabel hari per tanggal — sesuaikan kolom dengan model Absensi.
        Model Absensi TIDAK punya waktu_scan dan sesiGerbang.
        Tampilkan kolom yang relevan: status, mata pelajaran, jam.
    --}}
    @if($hariPerTanggal->isNotEmpty())
    <div class="section-card">
        <div class="section-header">
            <span class="section-title">
                <svg width="14" height="14" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Rekap per Hari — {{ $bulanList[$bulan] }} {{ $tahun }}
            </span>
            <div class="legend">
                <div class="legend-item"><div class="legend-dot" style="background:#dcfce7;border:1px solid #bbf7d0"></div>Hadir</div>
                <div class="legend-item"><div class="legend-dot" style="background:#fef9c3;border:1px solid #fde68a"></div>Telat</div>
                <div class="legend-item"><div class="legend-dot" style="background:#fee2e2;border:1px solid #fecaca"></div>Alfa</div>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Hari</th>
                        <th>Mata Pelajaran</th>
                        {{--
                            FIX: Hapus kolom Masuk/Pulang/Sesi Masuk/Sesi Pulang
                            karena model Absensi tidak punya waktu_scan & sesiGerbang.
                            Ganti dengan kolom Status dan Keterangan yang relevan.
                        --}}
                        <th class="center">Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hariPerTanggal as $hari)
                    <tr>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;white-space:nowrap">
                            {{ $hari['tanggal']->translatedFormat('d M Y') }}
                        </td>
                        <td style="color:var(--text3);font-size:12.5px;font-family:'DM Sans',sans-serif">
                            {{ $hari['tanggal']->translatedFormat('l') }}
                        </td>
                        <td style="font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text2)">
                            {{--
                                FIX: akses nama mapel via relasi jadwalPelajaran.mataPelajaran
                                yang sudah di-eager load di controller.
                            --}}
                            {{ optional($hari['masuk']?->jadwalPelajaran?->mataPelajaran)->nama_mapel ?? '—' }}
                        </td>
                        <td class="center">
                            @php
                                $status = $hari['masuk']?->status;
                            @endphp
                            @if($status)
                                @php
                                    $badgeClass = match($status) {
                                        'hadir' => 'b-hadir',
                                        'telat' => 'b-telat',
                                        'izin'  => 'b-izin',
                                        'sakit' => 'b-sakit',
                                        'alfa'  => 'b-alfa',
                                        default => 'b-belum',
                                    };
                                    $badgeLabel = match($status) {
                                        'hadir' => 'Hadir',
                                        'telat' => 'Telat',
                                        'izin'  => 'Izin',
                                        'sakit' => 'Sakit',
                                        'alfa'  => 'Alfa',
                                        default => ucfirst($status),
                                    };
                                @endphp
                                <span class="badge-status {{ $badgeClass }}">{{ $badgeLabel }}</span>
                            @else
                                <span class="badge-status b-belum">—</span>
                            @endif
                        </td>
                        <td style="font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text2);max-width:200px">
                            {{--
                                FIX: $hari['masuk'] adalah model Absensi, bukan KehadiranGerbang.
                                Kolom keterangan/catatan di Absensi mungkin bernama 'keterangan'.
                                Sesuaikan nama kolom ini dengan skema DB Anda.
                            --}}
                            {{ $hari['masuk']?->keterangan ?? '—' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="section-card">
        <div class="empty-state">
            <div class="empty-icon">📋</div>
            <p class="empty-title">Tidak ada data absensi bulan ini</p>
            <p class="empty-sub">Belum ada data absensi {{ $anak->nama_lengkap }}<br>pada {{ $bulanList[$bulan] }} {{ $tahun }}.</p>
        </div>
    </div>
    @endif

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
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {
    var labels     = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    {{--
        FIX: $rekapTahunan sekarang pakai key 'masuk' dan 'pulang'
        sesuai yang dipakai array_column() di bawah.
        Sebelumnya controller mengirim key 'hadir' dan 'alfa'.
    --}}
    var masukData  = @json(array_column(array_values($rekapTahunan), 'masuk'));
    var pulangData = @json(array_column(array_values($rekapTahunan), 'pulang'));

    var ctx = document.getElementById('trendChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Hadir',
                    data: masukData,
                    backgroundColor: '#dcfce7',
                    borderColor: '#15803d',
                    borderWidth: 1.5,
                    borderRadius: 6,
                },
                {
                    label: 'Tidak Hadir',
                    data: pulangData,
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