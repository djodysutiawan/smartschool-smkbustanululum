<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Sesi Gerbang — {{ $sesiGerbang->label_tipe }} — {{ $sesiGerbang->tanggal->format('d-m-Y') }}</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'DejaVu Sans', Arial, sans-serif;
        font-size: 10pt;
        color: #1e293b;
        background: #fff;
        line-height: 1.4;
    }

    /* Page layout */
    .page { padding: 28px 32px; }

    /* Header */
    .header { border-bottom: 2px solid #1f63db; padding-bottom: 14px; margin-bottom: 18px; }
    .header-top { display: flex; justify-content: space-between; align-items: flex-start; }
    .header-school { font-size: 13pt; font-weight: bold; color: #0f172a; margin-bottom: 2px; }
    .header-sub { font-size: 9pt; color: #64748b; }
    .header-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 99px;
        font-size: 9pt;
        font-weight: bold;
    }
    .badge-masuk { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .badge-pulang { background: #f0fdfa; color: #0f766e; border: 1px solid #99f6e4; }
    .badge-aktif { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-ditutup { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }

    .doc-title { margin-top: 14px; font-size: 15pt; font-weight: bold; color: #0f172a; }
    .doc-tanggal { font-size: 10pt; color: #64748b; margin-top: 2px; }

    /* Info block */
    .info-block {
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
    }
    .info-section {
        flex: 1;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 10px 14px;
    }
    .info-section-title {
        font-size: 8pt;
        font-weight: bold;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
    }
    .info-row { display: flex; margin-bottom: 4px; }
    .info-label { width: 100px; font-size: 9pt; color: #64748b; flex-shrink: 0; }
    .info-val { font-size: 9pt; font-weight: bold; color: #0f172a; }

    /* Stats */
    .stats-row {
        display: flex;
        gap: 8px;
        margin-bottom: 18px;
    }
    .stat-box {
        flex: 1;
        text-align: center;
        padding: 10px 8px;
        border-radius: 6px;
        border: 1px solid;
    }
    .stat-box.blue  { background: #eff6ff; border-color: #bfdbfe; }
    .stat-box.green { background: #dcfce7; border-color: #bbf7d0; }
    .stat-box.red   { background: #fee2e2; border-color: #fecaca; }
    .stat-box.yellow{ background: #fefce8; border-color: #fde68a; }
    .stat-box.gray  { background: #f1f5f9; border-color: #e2e8f0; }
    .stat-num { font-size: 18pt; font-weight: bold; color: #0f172a; line-height: 1; }
    .stat-lbl { font-size: 8pt; color: #64748b; margin-top: 3px; }
    .stat-box.blue .stat-num  { color: #1d4ed8; }
    .stat-box.green .stat-num { color: #15803d; }
    .stat-box.red .stat-num   { color: #dc2626; }
    .stat-box.yellow .stat-num{ color: #a16207; }

    /* Section heading */
    .section-heading {
        font-size: 10pt;
        font-weight: bold;
        color: #0f172a;
        padding: 7px 0 7px;
        border-bottom: 1.5px solid #e2e8f0;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .section-count { font-size: 9pt; color: #94a3b8; font-weight: normal; }

    /* Table */
    table { width: 100%; border-collapse: collapse; font-size: 9pt; margin-bottom: 20px; }
    thead tr { background: #f1f5f9; }
    th { padding: 7px 10px; text-align: left; font-weight: bold; color: #475569; font-size: 8pt; text-transform: uppercase; letter-spacing: 0.04em; border-bottom: 1.5px solid #e2e8f0; }
    td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; color: #334155; vertical-align: top; }
    tr:last-child td { border-bottom: none; }
    tr:nth-child(even) td { background: #fafafa; }
    .nama-bold { font-weight: bold; color: #0f172a; }
    .kelas-tag { display: inline-block; background: #eff6ff; color: #1d4ed8; padding: 1px 6px; border-radius: 4px; font-size: 8pt; font-weight: bold; }
    .guru-tag  { display: inline-block; background: #faf5ff; color: #7c3aed; padding: 1px 6px; border-radius: 4px; font-size: 8pt; font-weight: bold; }
    .status-normal   { color: #15803d; font-weight: bold; }
    .status-manual   { color: #1f63db; font-weight: bold; }
    .status-koreksi  { color: #a16207; font-weight: bold; }
    .status-duplikat { color: #dc2626; font-weight: bold; }
    .time-mono { font-family: 'Courier New', monospace; font-size: 9pt; }
    .tipe-masuk  { color: #1d4ed8; font-weight: bold; font-size: 8.5pt; }
    .tipe-pulang { color: #0f766e; font-weight: bold; font-size: 8.5pt; }

    /* Catatan */
    .catatan-box {
        background: #fefce8;
        border: 1px solid #fde68a;
        border-radius: 6px;
        padding: 10px 14px;
        font-size: 9pt;
        color: #0f172a;
        margin-bottom: 16px;
        line-height: 1.6;
    }
    .catatan-label { font-size: 8pt; font-weight: bold; color: #a16207; margin-bottom: 4px; }

    /* Footer */
    .footer {
        border-top: 1px solid #e2e8f0;
        padding-top: 12px;
        margin-top: 8px;
        display: flex;
        justify-content: space-between;
        font-size: 8pt;
        color: #94a3b8;
    }
    .ttd-area { margin-top: 28px; display: flex; justify-content: flex-end; }
    .ttd-box { text-align: center; width: 160px; }
    .ttd-label { font-size: 9pt; color: #64748b; margin-bottom: 48px; }
    .ttd-line { border-top: 1px solid #0f172a; padding-top: 4px; font-size: 9pt; font-weight: bold; color: #0f172a; }
    .ttd-title { font-size: 8.5pt; color: #64748b; }

    /* Tidak dikenal row */
    .tidak-dikenal { color: #dc2626; font-style: italic; }

    @page { margin: 0; }
</style>
</head>
<body>
<div class="page">

    {{-- Header --}}
    <div class="header">
        <div class="header-top">
            <div>
                <div class="header-school">Laporan Sesi Gerbang Absensi</div>
                <div class="header-sub">Sistem Informasi Manajemen Sekolah</div>
            </div>
            <div>
                <span class="header-badge {{ $sesiGerbang->tipe === 'masuk' ? 'badge-masuk' : 'badge-pulang' }}">
                    {{ $sesiGerbang->label_tipe }}
                </span>
                &nbsp;
                <span class="header-badge {{ $sesiGerbang->status === 'aktif' ? 'badge-aktif' : 'badge-ditutup' }}">
                    {{ $sesiGerbang->status === 'aktif' ? 'Aktif' : 'Ditutup' }}
                </span>
            </div>
        </div>
        <div class="doc-title">Rekap Absensi Gerbang</div>
        <div class="doc-tanggal">
            {{ $sesiGerbang->tanggal->translatedFormat('l, d F Y') }} ·
            {{ $sesiGerbang->label_tipe }}
        </div>
    </div>

    {{-- Info sesi --}}
    <div class="info-block">
        <div class="info-section">
            <div class="info-section-title">Informasi Sesi</div>
            <div class="info-row"><span class="info-label">Tipe:</span><span class="info-val">{{ $sesiGerbang->label_tipe }}</span></div>
            <div class="info-row"><span class="info-label">Dibuka:</span><span class="info-val">{{ $sesiGerbang->dibuka_pada->format('H:i:s') }} oleh {{ $sesiGerbang->dibukaOleh?->name ?? '—' }}</span></div>
            @if($sesiGerbang->ditutup_pada)
            <div class="info-row"><span class="info-label">Ditutup:</span><span class="info-val">{{ $sesiGerbang->ditutup_pada->format('H:i:s') }} oleh {{ $sesiGerbang->ditutupOleh?->name ?? '—' }}</span></div>
            <div class="info-row"><span class="info-label">Durasi:</span><span class="info-val">{{ $sesiGerbang->dibuka_pada->diffForHumans($sesiGerbang->ditutup_pada, true) }}</span></div>
            @else
            <div class="info-row"><span class="info-label">Status:</span><span class="info-val" style="color:#15803d">Masih Aktif</span></div>
            @endif
        </div>
        <div class="info-section">
            <div class="info-section-title">Dicetak Oleh</div>
            <div class="info-row"><span class="info-label">Nama:</span><span class="info-val">{{ $meta['dicetak_oleh'] }}</span></div>
            <div class="info-row"><span class="info-label">Pada:</span><span class="info-val">{{ $meta['dicetak_pada'] }}</span></div>
        </div>
    </div>

    {{-- Catatan --}}
    @if($sesiGerbang->catatan)
    <div class="catatan-box">
        <div class="catatan-label">Catatan Sesi:</div>
        {{ $sesiGerbang->catatan }}
    </div>
    @endif

    {{-- Statistik --}}
    <div class="stats-row">
        <div class="stat-box blue">
            <div class="stat-num">{{ $statistik['total_scan'] }}</div>
            <div class="stat-lbl">Total Scan</div>
        </div>
        <div class="stat-box green">
            <div class="stat-num">{{ $statistik['scan_valid'] }}</div>
            <div class="stat-lbl">Scan Valid</div>
        </div>
        <div class="stat-box red">
            <div class="stat-num">{{ $statistik['scan_duplikat'] }}</div>
            <div class="stat-lbl">Duplikat</div>
        </div>
        <div class="stat-box yellow">
            <div class="stat-num">{{ $statistik['scan_manual'] }}</div>
            <div class="stat-lbl">Input Manual</div>
        </div>
        <div class="stat-box gray">
            <div class="stat-num">{{ $statistik['tidak_dikenal'] }}</div>
            <div class="stat-lbl">Tidak Dikenal</div>
        </div>
    </div>

    {{-- Tabel Scan --}}
    <div class="section-heading">
        <span>Daftar Scan Valid</span>
        <span class="section-count">{{ $statistik['scan_valid'] }} entri</span>
    </div>

    @if($scanList->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width:28px">#</th>
                <th>Nama</th>
                <th>Kelas / Jabatan</th>
                <th>Tipe</th>
                <th>Waktu Scan</th>
                <th>Status</th>
                <th>Input Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($scanList as $i => $scan)
            @php
                $isSiswa = $scan->siswa_id !== null;
                $namaVal = $scan->siswa?->nama_lengkap ?? $scan->guru?->nama_lengkap ?? '— Tidak Dikenal —';
                $kelasVal = $scan->siswa?->kelas?->nama_kelas ?? null;
                $jabatanVal = $scan->guru ? 'Guru' : null;
                $isUnknown = !$isSiswa && !$scan->guru_id;
            @endphp
            <tr>
                <td style="color:#94a3b8;font-size:8.5pt">{{ $i + 1 }}</td>
                <td>
                    <span class="{{ $isUnknown ? 'tidak-dikenal' : 'nama-bold' }}">{{ $namaVal }}</span>
                    @if($isSiswa && $scan->siswa?->nis)
                    <br><span style="font-size:8pt;color:#94a3b8">NIS: {{ $scan->siswa->nis }}</span>
                    @endif
                </td>
                <td>
                    @if($kelasVal)
                    <span class="kelas-tag">{{ $kelasVal }}</span>
                    @elseif($jabatanVal)
                    <span class="guru-tag">{{ $jabatanVal }}</span>
                    @else
                    <span style="color:#94a3b8;font-size:8.5pt">—</span>
                    @endif
                </td>
                <td>
                    @if($scan->tipe)
                    <span class="{{ $scan->tipe === 'masuk' ? 'tipe-masuk' : 'tipe-pulang' }}">
                        {{ $scan->tipe === 'masuk' ? '→ Masuk' : '← Pulang' }}
                    </span>
                    @else<span style="color:#94a3b8">—</span>@endif
                </td>
                <td><span class="time-mono">{{ $scan->waktu_scan?->format('H:i:s') ?? '—' }}</span></td>
                <td>
                    @php
                        $sc = match($scan->status) {
                            'normal'   => 'status-normal',
                            'manual'   => 'status-manual',
                            'koreksi'  => 'status-koreksi',
                            'duplikat' => 'status-duplikat',
                            default    => '',
                        };
                        $sl = match($scan->status) {
                            'normal'   => 'Normal',
                            'manual'   => 'Manual',
                            'koreksi'  => 'Koreksi',
                            'duplikat' => 'Duplikat',
                            default    => ucfirst($scan->status),
                        };
                    @endphp
                    <span class="{{ $sc }}">{{ $sl }}</span>
                </td>
                <td style="font-size:8.5pt;color:#64748b">{{ $scan->inputOleh?->name ?? 'Sistem' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="padding:20px;text-align:center;color:#94a3b8;font-size:9pt;border:1px solid #e2e8f0;border-radius:6px;margin-bottom:18px">
        Tidak ada data scan valid pada sesi ini.
    </div>
    @endif

    {{-- Tanda Tangan --}}
    <div class="ttd-area">
        <div class="ttd-box">
            <div class="ttd-label">Guru Piket,</div>
            <div class="ttd-line">{{ $sesiGerbang->dibukaOleh?->name ?? '_______________' }}</div>
            <div class="ttd-title">Petugas Piket Gerbang</div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <span>Dicetak oleh: {{ $meta['dicetak_oleh'] }} pada {{ $meta['dicetak_pada'] }}</span>
        <span>Sesi #{{ $sesiGerbang->id }} · {{ $sesiGerbang->tanggal->format('d/m/Y') }}</span>
    </div>

</div>
</body>
</html>