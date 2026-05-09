<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Rekap Kehadiran — {{ $filter['dari'] }} s/d {{ $filter['sampai'] }}</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 9.5pt;
        color: #0f172a;
        background: #fff;
        line-height: 1.4;
    }

    .page {
        padding: 26px 30px 60px 30px;
    }

    /* ── Header ── */
    .header-bar {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }
    .header-bar td {
        vertical-align: middle;
    }
    .header-logo-cell {
        width: 52px;
    }
    .logo-box {
        width: 44px;
        height: 44px;
        background: #1f63db;
        border-radius: 8px;
        text-align: center;
        vertical-align: middle;
        color: #fff;
        font-size: 18pt;
        font-weight: bold;
        line-height: 44px;
    }
    .header-text-cell {
        padding-left: 12px;
    }
    .doc-main-title {
        font-size: 14pt;
        font-weight: bold;
        color: #0f172a;
        letter-spacing: -0.02em;
    }
    .doc-sub-title {
        font-size: 9.5pt;
        color: #1f63db;
        font-weight: bold;
        margin-top: 1px;
    }
    .doc-meta-line {
        font-size: 8pt;
        color: #64748b;
        margin-top: 2px;
    }
    .header-divider {
        border: none;
        border-top: 2.5px solid #1f63db;
        margin: 10px 0 14px 0;
    }

    /* ── Info grid ── */
    .info-grid {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 14px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
    }
    .info-grid td {
        padding: 6px 12px;
        font-size: 8.5pt;
        vertical-align: top;
    }
    .info-grid .label {
        color: #64748b;
        font-weight: bold;
        width: 20%;
        white-space: nowrap;
    }
    .info-grid .sep {
        color: #94a3b8;
        width: 12px;
    }
    .info-grid .val {
        color: #0f172a;
    }
    .info-grid tr:not(:last-child) td {
        border-bottom: 1px solid #e2e8f0;
    }

    /* ── Summary stat boxes ── */
    .stat-row {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 16px;
    }
    .stat-cell {
        padding: 0 5px 0 0;
        vertical-align: top;
    }
    .stat-cell:last-child { padding-right: 0; }
    .stat-box {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 9px 10px;
        text-align: center;
    }
    .stat-val {
        font-size: 17pt;
        font-weight: bold;
        line-height: 1;
        color: #0f172a;
    }
    .stat-label {
        font-size: 7pt;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: bold;
        margin-top: 3px;
    }
    .stat-box.blue   { background: #eff6ff; border-color: #bfdbfe; }
    .stat-box.green  { background: #f0fdf4; border-color: #bbf7d0; }
    .stat-box.orange { background: #fff7ed; border-color: #fed7aa; }
    .stat-box.gray   { background: #f8fafc; border-color: #e2e8f0; }
    .stat-box.blue   .stat-val { color: #1d4ed8; }
    .stat-box.green  .stat-val { color: #15803d; }
    .stat-box.orange .stat-val { color: #c2410c; }

    /* ── Section title ── */
    .section-title {
        font-size: 8.5pt;
        font-weight: bold;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border-left: 3px solid #1f63db;
        padding-left: 8px;
        margin-bottom: 8px;
        margin-top: 14px;
    }

    /* ── Main data table ── */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 8.5pt;
    }
    .data-table thead tr {
        background: #1f63db;
    }
    .data-table thead th {
        color: #fff;
        font-weight: bold;
        padding: 7px 7px;
        text-align: left;
        font-size: 7.5pt;
        letter-spacing: 0.03em;
        white-space: nowrap;
    }
    .data-table thead th.center { text-align: center; }
    .data-table thead th.right  { text-align: right; }

    .data-table tbody tr { border-bottom: 1px solid #f1f5f9; }
    .data-table tbody tr:nth-child(even) { background: #f8fafc; }
    .data-table tbody tr.kelas-header-row td {
        background: #e0f2fe;
        font-weight: bold;
        font-size: 8pt;
        color: #0369a1;
        padding: 5px 7px;
        letter-spacing: 0.03em;
    }

    .data-table tbody td {
        padding: 5px 7px;
        vertical-align: middle;
        color: #0f172a;
    }
    .data-table tbody td.center { text-align: center; }
    .data-table tbody td.right  { text-align: right; }
    .data-table tbody td.muted  { color: #94a3b8; font-size: 8pt; }
    .data-table .no-col         { color: #94a3b8; font-size: 7.5pt; }
    .data-table .nama-primary   { font-weight: bold; font-size: 8.5pt; }
    .data-table .nama-secondary { font-size: 7.5pt; color: #94a3b8; }

    /* ── Progress bar (via table trick for DomPDF) ── */
    .progress-wrap {
        width: 60px;
        height: 6px;
        background: #e2e8f0;
        border-radius: 99px;
        display: inline-block;
        vertical-align: middle;
        overflow: hidden;
    }
    /* DomPDF doesn't support width on inline — use a nested table */
    .progress-fill {
        height: 6px;
        border-radius: 99px;
        background: #1f63db;
        display: block;
    }
    .pct-text {
        font-size: 8pt;
        font-weight: bold;
        vertical-align: middle;
        margin-left: 4px;
        display: inline-block;
    }
    .pct-high   { color: #15803d; }
    .pct-mid    { color: #d97706; }
    .pct-low    { color: #dc2626; }

    /* ── Category badge ── */
    .badge {
        display: inline-block;
        padding: 2px 7px;
        border-radius: 99px;
        font-size: 7.5pt;
        font-weight: bold;
    }
    .badge-green  { background: #dcfce7; color: #15803d; }
    .badge-yellow { background: #fefce8; color: #854d0e; }
    .badge-red    { background: #fee2e2; color: #dc2626; }

    /* ── Rangkuman kelas ── */
    .kelas-summary {
        width: 100%;
        border-collapse: collapse;
        margin-top: 16px;
        font-size: 8.5pt;
    }
    .kelas-summary thead tr {
        background: #0f172a;
    }
    .kelas-summary thead th {
        color: #fff;
        font-weight: bold;
        padding: 6px 8px;
        font-size: 7.5pt;
        text-align: left;
    }
    .kelas-summary thead th.center { text-align: center; }
    .kelas-summary tbody tr { border-bottom: 1px solid #f1f5f9; }
    .kelas-summary tbody tr:nth-child(even) { background: #f8fafc; }
    .kelas-summary tbody td { padding: 5px 8px; vertical-align: middle; }
    .kelas-summary tbody td.center { text-align: center; }
    .kelas-summary tfoot tr {
        background: #f1f5f9;
        border-top: 2px solid #cbd5e1;
    }
    .kelas-summary tfoot td {
        padding: 6px 8px;
        font-weight: bold;
        font-size: 8.5pt;
    }
    .kelas-summary tfoot td.center { text-align: center; }

    /* ── Tanda tangan ── */
    .ttd-section {
        width: 100%;
        border-collapse: collapse;
        margin-top: 32px;
    }
    .ttd-box {
        width: 33%;
        vertical-align: top;
        padding: 0 16px;
        text-align: center;
    }
    .ttd-title   { font-size: 8.5pt; color: #475569; margin-bottom: 46px; }
    .ttd-line    { border-top: 1px solid #0f172a; padding-top: 4px; font-size: 8pt; font-weight: bold; }
    .ttd-role    { font-size: 7.5pt; color: #64748b; margin-top: 1px; }

    /* ── Footer ── */
    .footer {
        position: fixed;
        bottom: 14px;
        left: 30px;
        right: 30px;
        border-top: 1px solid #e2e8f0;
        padding-top: 5px;
    }
    .footer-table {
        width: 100%;
        border-collapse: collapse;
    }
    .footer-table td {
        font-size: 7.5pt;
        color: #94a3b8;
    }
    .footer-table .fl { text-align: left; }
    .footer-table .fr { text-align: right; }

    /* ── Page break ── */
    .page-break { page-break-after: always; }
</style>
</head>
<body>
<div class="page">

    {{-- ── Header ── --}}
    <table class="header-bar">
        <tr>
            <td class="header-logo-cell">
                <div class="logo-box">A</div>
            </td>
            <td class="header-text-cell">
                <div class="doc-main-title">Rekap Kehadiran Siswa</div>
                <div class="doc-sub-title">
                    Periode {{ \Carbon\Carbon::parse($filter['dari'])->isoFormat('D MMMM Y') }}
                    s/d {{ \Carbon\Carbon::parse($filter['sampai'])->isoFormat('D MMMM Y') }}
                </div>
                <div class="doc-meta-line">
                    Tipe: {{ ucfirst($filter['tipe']) }}
                    &nbsp;&middot;&nbsp;
                    Kelas: {{ $filter['kelas_label'] }}
                    &nbsp;&middot;&nbsp;
                    Total Hari Sekolah: {{ $totalHariSekolah }} hari
                </div>
            </td>
        </tr>
    </table>
    <hr class="header-divider">

    {{-- ── Info Grid ── --}}
    <table class="info-grid">
        <tr>
            <td class="label">Periode</td>
            <td class="sep">:</td>
            <td class="val">{{ \Carbon\Carbon::parse($filter['dari'])->isoFormat('D MMMM Y') }} s/d {{ \Carbon\Carbon::parse($filter['sampai'])->isoFormat('D MMMM Y') }}</td>
            <td class="label">Dicetak Pada</td>
            <td class="sep">:</td>
            <td class="val">{{ $filter['dicetak_pada'] }}</td>
        </tr>
        <tr>
            <td class="label">Tipe Rekap</td>
            <td class="sep">:</td>
            <td class="val">{{ ucfirst($filter['tipe']) }}</td>
            <td class="label">Dicetak Oleh</td>
            <td class="sep">:</td>
            <td class="val">{{ $filter['dicetak_oleh'] }}</td>
        </tr>
        <tr>
            <td class="label">Kelas</td>
            <td class="sep">:</td>
            <td class="val">{{ $filter['kelas_label'] }}</td>
            <td class="label">Total Hari Sekolah</td>
            <td class="sep">:</td>
            <td class="val">{{ $totalHariSekolah }} hari efektif</td>
        </tr>
    </table>

    {{-- ── Stat Summary ── --}}
    @php
        $totalSiswa      = $rekapList->count();
        $totalHadirSum   = $rekapList->sum('hari_hadir');
        $totalTidakHadir = $rekapList->sum('hari_tidak_hadir');
        $avgPct          = $totalSiswa > 0 ? round($rekapList->avg('persentase'), 1) : 0;
        $siswaAlpha      = $rekapList->where('persentase', '<', 75)->count();
    @endphp
    <table class="stat-row">
        <tr>
            <td class="stat-cell" style="width:20%">
                <div class="stat-box blue">
                    <div class="stat-val">{{ $totalSiswa }}</div>
                    <div class="stat-label">Total Siswa</div>
                </div>
            </td>
            <td class="stat-cell" style="width:20%">
                <div class="stat-box gray">
                    <div class="stat-val">{{ $totalHariSekolah }}</div>
                    <div class="stat-label">Hari Sekolah</div>
                </div>
            </td>
            <td class="stat-cell" style="width:20%">
                <div class="stat-box green">
                    <div class="stat-val">{{ $avgPct }}%</div>
                    <div class="stat-label">Rata-rata Hadir</div>
                </div>
            </td>
            <td class="stat-cell" style="width:20%">
                <div class="stat-box orange">
                    <div class="stat-val">{{ $siswaAlpha }}</div>
                    <div class="stat-label">Di Bawah 75%</div>
                </div>
            </td>
            <td class="stat-cell" style="width:20%">
                <div class="stat-box gray">
                    <div class="stat-val">{{ $totalTidakHadir }}</div>
                    <div class="stat-label">Total Absen (hari)</div>
                </div>
            </td>
        </tr>
    </table>

    {{-- ── Rekap Per Siswa ── --}}
    <div class="section-title">Rekap Kehadiran Per Siswa ({{ $totalSiswa }} siswa)</div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width:26px">#</th>
                <th>Nama Siswa</th>
                <th style="width:60px">NIS</th>
                <th style="width:70px">Kelas</th>
                <th class="center" style="width:46px">Hadir</th>
                <th class="center" style="width:46px">Tidak</th>
                <th class="center" style="width:46px">Total</th>
                <th class="center" style="width:100px">Persentase</th>
                <th class="center" style="width:60px">Kategori</th>
            </tr>
        </thead>
        <tbody>
            @php $currentKelas = null; $kelasNo = []; @endphp
            @foreach($rekapList->sortBy(fn($s) => ($s->kelas?->nama_kelas ?? 'zzz') . $s->nama_lengkap) as $i => $siswa)
                @php
                    $kelasNama = $siswa->kelas?->nama_kelas ?? 'Tanpa Kelas';
                    if ($kelasNama !== $currentKelas) {
                        $currentKelas = $kelasNama;
                        $siswaPerKelas = $rekapList->filter(fn($s) => ($s->kelas?->nama_kelas ?? 'Tanpa Kelas') === $kelasNama);
                        $avgKelas = $siswaPerKelas->count() > 0 ? round($siswaPerKelas->avg('persentase'), 1) : 0;
                    }
                    $pctClass = $siswa->persentase >= 85 ? 'pct-high' : ($siswa->persentase >= 75 ? 'pct-mid' : 'pct-low');
                    $badgeClass = $siswa->persentase >= 85 ? 'badge-green' : ($siswa->persentase >= 75 ? 'badge-yellow' : 'badge-red');
                    $badgeLabel = $siswa->persentase >= 85 ? 'Baik' : ($siswa->persentase >= 75 ? 'Cukup' : 'Kurang');
                @endphp

                @if($siswa->kelas?->nama_kelas !== null && ($i === 0 || $kelasNama !== $rekapList->sortBy(fn($s)=>($s->kelas?->nama_kelas??'zzz').$s->nama_lengkap)->values()[$i - 1]?->kelas?->nama_kelas))
                <tr class="kelas-header-row">
                    <td colspan="9">&#9658; {{ $kelasNama }}</td>
                </tr>
                @endif

                <tr>
                    <td><span class="no-col">{{ $loop->iteration }}</span></td>
                    <td>
                        <div class="nama-primary">{{ $siswa->nama_lengkap }}</div>
                    </td>
                    <td style="font-size:8pt;color:#475569">{{ $siswa->nis }}</td>
                    <td class="muted">{{ $siswa->kelas?->nama_kelas ?? '—' }}</td>
                    <td class="center" style="font-weight:bold;color:#15803d">{{ $siswa->hari_hadir }}</td>
                    <td class="center" style="color:#dc2626">{{ $siswa->hari_tidak_hadir }}</td>
                    <td class="center" style="color:#475569">{{ $totalHariSekolah }}</td>
                    <td class="center">
                        <span class="pct-text {{ $pctClass }}">{{ $siswa->persentase }}%</span>
                    </td>
                    <td class="center">
                        <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ── Rekap Per Kelas ── --}}
    @php
        $rekapPerKelas = $rekapList->groupBy(fn($s) => $s->kelas?->nama_kelas ?? 'Tanpa Kelas')->sortKeys();
    @endphp

    @if($rekapPerKelas->count() > 1)
    <div class="section-title" style="margin-top:20px">Ringkasan Per Kelas</div>
    <table class="kelas-summary">
        <thead>
            <tr>
                <th style="width:26px">#</th>
                <th>Kelas</th>
                <th class="center">Jml Siswa</th>
                <th class="center">Total Hadir (hari)</th>
                <th class="center">Rata-rata Hadir</th>
                <th class="center">Rata-rata %</th>
                <th class="center">Di Bawah 75%</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekapPerKelas as $namaKelas => $siswaKelas)
            @php
                $jmlSiswa     = $siswaKelas->count();
                $totalHdr     = $siswaKelas->sum('hari_hadir');
                $avgHdr       = $jmlSiswa > 0 ? round($totalHdr / $jmlSiswa, 1) : 0;
                $avgPctKelas  = $jmlSiswa > 0 ? round($siswaKelas->avg('persentase'), 1) : 0;
                $bwh75        = $siswaKelas->where('persentase', '<', 75)->count();
            @endphp
            <tr>
                <td><span class="no-col">{{ $loop->iteration }}</span></td>
                <td style="font-weight:bold">{{ $namaKelas }}</td>
                <td class="center">{{ $jmlSiswa }}</td>
                <td class="center">{{ $totalHdr }}</td>
                <td class="center">{{ $avgHdr }} hari</td>
                <td class="center">
                    @php $pkc = $avgPctKelas >= 85 ? 'pct-high' : ($avgPctKelas >= 75 ? 'pct-mid' : 'pct-low'); @endphp
                    <span class="pct-text {{ $pkc }}">{{ $avgPctKelas }}%</span>
                </td>
                <td class="center" style="{{ $bwh75 > 0 ? 'color:#dc2626;font-weight:bold' : 'color:#15803d' }}">{{ $bwh75 }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="font-weight:bold">TOTAL</td>
                <td class="center">{{ $totalSiswa }}</td>
                <td class="center">{{ $totalHadirSum }}</td>
                <td class="center">{{ $totalHariSekolah > 0 && $totalSiswa > 0 ? round($totalHadirSum / $totalSiswa, 1) : 0 }} hari</td>
                <td class="center"><span class="pct-text {{ $avgPct >= 85 ? 'pct-high' : ($avgPct >= 75 ? 'pct-mid' : 'pct-low') }}">{{ $avgPct }}%</span></td>
                <td class="center" style="{{ $siswaAlpha > 0 ? 'color:#dc2626' : 'color:#15803d' }};font-weight:bold">{{ $siswaAlpha }}</td>
            </tr>
        </tfoot>
    </table>
    @endif

    {{-- ── Keterangan Kategori ── --}}
    <table style="width:100%;border-collapse:collapse;margin-top:14px;font-size:7.5pt">
        <tr>
            <td style="color:#64748b;font-style:italic;padding-right:16px">
                Keterangan Kategori:
            </td>
            <td style="padding-right:12px">
                <span class="badge badge-green">Baik</span>
                <span style="color:#475569;margin-left:4px">≥ 85%</span>
            </td>
            <td style="padding-right:12px">
                <span class="badge badge-yellow">Cukup</span>
                <span style="color:#475569;margin-left:4px">75% – 84%</span>
            </td>
            <td>
                <span class="badge badge-red">Kurang</span>
                <span style="color:#475569;margin-left:4px">&lt; 75%</span>
            </td>
        </tr>
    </table>

    {{-- ── Tanda Tangan ── --}}
    <table class="ttd-section">
        <tr>
            <td class="ttd-box" style="text-align:left;padding-left:0">
                <div class="ttd-title">Mengetahui,<br>Kepala Sekolah</div>
                <div class="ttd-line">___________________________</div>
                <div class="ttd-role">NIP. ____________________</div>
            </td>
            <td class="ttd-box"></td>
            <td class="ttd-box" style="text-align:right;padding-right:0">
                <div class="ttd-title">{{ \Carbon\Carbon::parse($filter['sampai'])->isoFormat('D MMMM Y') }},<br>Petugas Administrasi</div>
                <div class="ttd-line">___________________________</div>
                <div class="ttd-role">{{ $filter['dicetak_oleh'] }}</div>
            </td>
        </tr>
    </table>

</div>

{{-- ── Footer ── --}}
<div class="footer">
    <table class="footer-table">
        <tr>
            <td class="fl">Rekap Kehadiran {{ ucfirst($filter['tipe']) }} — {{ $filter['kelas_label'] }} — Periode {{ \Carbon\Carbon::parse($filter['dari'])->isoFormat('D MMM Y') }} s/d {{ \Carbon\Carbon::parse($filter['sampai'])->isoFormat('D MMM Y') }}</td>
            <td class="fr">Dicetak: {{ $filter['dicetak_pada'] }} · {{ $filter['dicetak_oleh'] }}</td>
        </tr>
    </table>
</div>

</body>
</html>