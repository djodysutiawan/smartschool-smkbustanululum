<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Log Absensi Gerbang — {{ $filter['tanggal'] }}</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 9.5pt;
        color: #0f172a;
        background: #fff;
        line-height: 1.4;
    }

    /* ── Page Layout ── */
    .page {
        padding: 28px 32px 28px 32px;
    }

    /* ── Header ── */
    .header {
        display: block;
        border-bottom: 2.5px solid #1f63db;
        padding-bottom: 12px;
        margin-bottom: 16px;
    }
    .header-top {
        display: block;
        margin-bottom: 6px;
    }
    .school-name {
        font-size: 14pt;
        font-weight: bold;
        color: #0f172a;
        letter-spacing: -0.02em;
    }
    .doc-title {
        font-size: 11pt;
        font-weight: bold;
        color: #1f63db;
        margin-top: 1px;
    }
    .doc-sub {
        font-size: 8.5pt;
        color: #64748b;
        margin-top: 2px;
    }

    /* ── Meta info row ── */
    .meta-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 14px;
    }
    .meta-table td {
        font-size: 8.5pt;
        padding: 3px 8px;
        vertical-align: top;
    }
    .meta-table td:first-child {
        width: 22%;
        color: #64748b;
        font-weight: bold;
    }
    .meta-table td:nth-child(2) {
        width: 3%;
        color: #64748b;
    }
    .meta-table td:nth-child(3) {
        color: #0f172a;
    }

    /* ── Stat boxes ── */
    .stat-row {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 16px;
    }
    .stat-box {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 8px 12px;
        text-align: center;
        width: 16.6%;
    }
    .stat-box-val {
        font-size: 18pt;
        font-weight: bold;
        color: #0f172a;
        line-height: 1;
    }
    .stat-box-label {
        font-size: 7.5pt;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-top: 3px;
        font-weight: bold;
    }
    .stat-box.green  { background: #f0fdf4; border-color: #bbf7d0; }
    .stat-box.blue   { background: #eff6ff; border-color: #bfdbfe; }
    .stat-box.orange { background: #fff7ed; border-color: #fed7aa; }
    .stat-box.purple { background: #faf5ff; border-color: #e9d5ff; }
    .stat-box.red    { background: #fff0f0; border-color: #fecaca; }
    .stat-box.gray   { background: #f8fafc; border-color: #e2e8f0; }
    .stat-box.green  .stat-box-val { color: #15803d; }
    .stat-box.blue   .stat-box-val { color: #1d4ed8; }
    .stat-box.orange .stat-box-val { color: #c2410c; }
    .stat-box.purple .stat-box-val { color: #7c3aed; }
    .stat-box.red    .stat-box-val { color: #dc2626; }

    /* ── Section divider ── */
    .section-title {
        font-size: 9pt;
        font-weight: bold;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border-left: 3px solid #1f63db;
        padding-left: 8px;
        margin-bottom: 8px;
        margin-top: 14px;
    }

    /* ── Data Table ── */
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
        padding: 7px 8px;
        text-align: left;
        font-size: 8pt;
        letter-spacing: 0.02em;
        white-space: nowrap;
    }
    .data-table thead th.center {
        text-align: center;
    }
    .data-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
    }
    .data-table tbody tr:nth-child(even) {
        background: #f8fafc;
    }
    .data-table tbody td {
        padding: 6px 8px;
        vertical-align: middle;
        color: #0f172a;
    }
    .data-table tbody td.center {
        text-align: center;
    }
    .data-table tbody td.muted {
        color: #94a3b8;
        font-size: 8pt;
    }
    .data-table .no-col {
        color: #94a3b8;
        font-size: 8pt;
    }
    .data-table .nama-primary {
        font-weight: bold;
        font-size: 8.5pt;
    }
    .data-table .nama-secondary {
        font-size: 7.5pt;
        color: #94a3b8;
    }

    /* ── Badge ── */
    .badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 99px;
        font-size: 7.5pt;
        font-weight: bold;
        text-align: center;
    }
    .badge-masuk    { background: #dcfce7; color: #15803d; }
    .badge-pulang   { background: #dbeafe; color: #1d4ed8; }
    .badge-normal   { background: #f0fdf4; color: #166534; }
    .badge-duplikat { background: #fefce8; color: #854d0e; }
    .badge-koreksi  { background: #ede9fe; color: #6d28d9; }
    .badge-manual   { background: #fff7ed; color: #c2410c; }
    .badge-unknown  { background: #f1f5f9; color: #64748b; }

    /* ── Empty state ── */
    .empty-state {
        text-align: center;
        padding: 30px 0;
        color: #94a3b8;
        font-size: 9pt;
    }

    /* ── Footer ── */
    .footer {
        position: fixed;
        bottom: 14px;
        left: 32px;
        right: 32px;
        border-top: 1px solid #e2e8f0;
        padding-top: 6px;
        font-size: 7.5pt;
        color: #94a3b8;
    }
    .footer-inner {
        width: 100%;
    }
    .footer-left  { text-align: left;  }
    .footer-right { text-align: right; }

    /* ── Tanda tangan ── */
    .ttd-section {
        margin-top: 30px;
        width: 100%;
        border-collapse: collapse;
    }
    .ttd-box {
        width: 33%;
        text-align: center;
        padding: 0 16px;
        vertical-align: top;
    }
    .ttd-title {
        font-size: 8.5pt;
        color: #475569;
        margin-bottom: 48px;
    }
    .ttd-line {
        border-top: 1px solid #0f172a;
        padding-top: 4px;
        font-size: 8pt;
        font-weight: bold;
        color: #0f172a;
    }
    .ttd-role {
        font-size: 7.5pt;
        color: #64748b;
        margin-top: 1px;
    }
</style>
</head>
<body>
<div class="page">

    {{-- ── Header ── --}}
    <div class="header">
        <div class="header-top">
            <div class="school-name">Log Absensi Gerbang</div>
            <div class="doc-title">Laporan Scan Harian — {{ \Carbon\Carbon::parse($filter['tanggal'])->isoFormat('dddd, D MMMM Y') }}</div>
            @if($filter['kelas_label'])
            <div class="doc-sub">Filter Kelas: {{ $filter['kelas_label'] }}{{ $filter['tipe'] ? ' · Tipe: ' . ucfirst($filter['tipe']) : '' }}</div>
            @else
            <div class="doc-sub">Semua Kelas{{ $filter['tipe'] ? ' · Filter Tipe: ' . ucfirst($filter['tipe']) : '' }}</div>
            @endif
        </div>
    </div>

    {{-- ── Meta Info ── --}}
    <table class="meta-table">
        <tr>
            <td>Tanggal</td><td>:</td><td>{{ \Carbon\Carbon::parse($filter['tanggal'])->isoFormat('D MMMM Y') }}</td>
            <td>&nbsp;&nbsp;</td>
            <td style="width:20%;color:#64748b;font-weight:bold">Dicetak Pada</td><td>:</td><td>{{ $filter['dicetak_pada'] }}</td>
        </tr>
        <tr>
            <td>Total Record</td><td>:</td><td>{{ $scanList->count() }} scan</td>
            <td>&nbsp;&nbsp;</td>
            <td style="width:20%;color:#64748b;font-weight:bold">Dicetak Oleh</td><td>:</td><td>{{ $filter['dicetak_oleh'] }}</td>
        </tr>
    </table>

    {{-- ── Statistik ── --}}
    <table class="stat-row">
        <tr>
            <td class="stat-box green">
                <div class="stat-box-val">{{ $statistik['total_masuk'] }}</div>
                <div class="stat-box-label">Masuk</div>
            </td>
            <td style="width:8px"></td>
            <td class="stat-box blue">
                <div class="stat-box-val">{{ $statistik['total_pulang'] }}</div>
                <div class="stat-box-label">Pulang</div>
            </td>
            <td style="width:8px"></td>
            <td class="stat-box orange">
                <div class="stat-box-val">{{ $statistik['belum_hadir'] }}</div>
                <div class="stat-box-label">Belum Hadir</div>
            </td>
            <td style="width:8px"></td>
            <td class="stat-box purple">
                <div class="stat-box-val">{{ $statistik['scan_manual'] }}</div>
                <div class="stat-box-label">Manual</div>
            </td>
            <td style="width:8px"></td>
            <td class="stat-box red">
                <div class="stat-box-val">{{ $statistik['tidak_dikenal'] }}</div>
                <div class="stat-box-label">Tdk Dikenal</div>
            </td>
            <td style="width:8px"></td>
            <td class="stat-box gray">
                <div class="stat-box-val">{{ $statistik['persentase_hadir'] }}%</div>
                <div class="stat-box-label">Kehadiran</div>
            </td>
        </tr>
    </table>

    {{-- ── Scan Masuk ── --}}
    @php
        $scanMasuk  = $scanList->where('tipe', 'masuk');
        $scanPulang = $scanList->where('tipe', 'pulang');
    @endphp

    @if($scanMasuk->count())
    <div class="section-title">Scan Masuk ({{ $scanMasuk->count() }} record)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:28px">#</th>
                <th style="width:54px">Waktu</th>
                <th>Nama Siswa</th>
                <th style="width:60px">NIS</th>
                <th style="width:70px">Kelas</th>
                <th class="center" style="width:62px">Status</th>
                <th>Kode Scan</th>
                <th>Input Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($scanMasuk->values() as $i => $scan)
            <tr>
                <td class="no-col">{{ $i + 1 }}</td>
                <td style="font-size:8pt;white-space:nowrap">{{ $scan->waktu_scan->format('H:i:s') }}</td>
                <td>
                    @if($scan->siswa)
                        <div class="nama-primary">{{ $scan->siswa->nama_lengkap }}</div>
                    @else
                        <div class="nama-primary muted">— Tidak Dikenal —</div>
                    @endif
                </td>
                <td style="font-size:8pt;color:#475569">{{ $scan->siswa?->nis ?? '—' }}</td>
                <td class="muted">{{ $scan->siswa?->kelas?->nama_kelas ?? '—' }}</td>
                <td class="center">
                    @php $sc = in_array($scan->status, ['normal','duplikat','koreksi','manual']) ? $scan->status : 'unknown'; @endphp
                    <span class="badge badge-{{ $sc }}">{{ $scan->label_status }}</span>
                </td>
                <td style="font-size:7.5pt;color:#94a3b8;font-family:monospace">{{ $scan->kode_scan }}</td>
                <td style="font-size:8pt;color:#475569">{{ $scan->inputOleh?->name ?? ($scan->is_manual ? 'Piket' : 'Alat') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- ── Scan Pulang ── --}}
    @if($scanPulang->count())
    <div class="section-title">Scan Pulang ({{ $scanPulang->count() }} record)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:28px">#</th>
                <th style="width:54px">Waktu</th>
                <th>Nama Siswa</th>
                <th style="width:60px">NIS</th>
                <th style="width:70px">Kelas</th>
                <th class="center" style="width:62px">Status</th>
                <th>Kode Scan</th>
                <th>Input Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($scanPulang->values() as $i => $scan)
            <tr>
                <td class="no-col">{{ $i + 1 }}</td>
                <td style="font-size:8pt;white-space:nowrap">{{ $scan->waktu_scan->format('H:i:s') }}</td>
                <td>
                    @if($scan->siswa)
                        <div class="nama-primary">{{ $scan->siswa->nama_lengkap }}</div>
                    @else
                        <div class="nama-primary muted">— Tidak Dikenal —</div>
                    @endif
                </td>
                <td style="font-size:8pt;color:#475569">{{ $scan->siswa?->nis ?? '—' }}</td>
                <td class="muted">{{ $scan->siswa?->kelas?->nama_kelas ?? '—' }}</td>
                <td class="center">
                    @php $sc = in_array($scan->status, ['normal','duplikat','koreksi','manual']) ? $scan->status : 'unknown'; @endphp
                    <span class="badge badge-{{ $sc }}">{{ $scan->label_status }}</span>
                </td>
                <td style="font-size:7.5pt;color:#94a3b8;font-family:monospace">{{ $scan->kode_scan }}</td>
                <td style="font-size:8pt;color:#475569">{{ $scan->inputOleh?->name ?? ($scan->is_manual ? 'Piket' : 'Alat') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if($scanList->isEmpty())
    <div class="empty-state">Tidak ada data scan untuk tanggal dan filter yang dipilih.</div>
    @endif

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
                <div class="ttd-title">{{ \Carbon\Carbon::parse($filter['tanggal'])->isoFormat('D MMMM Y') }},<br>Petugas Piket</div>
                <div class="ttd-line">___________________________</div>
                <div class="ttd-role">{{ $filter['dicetak_oleh'] }}</div>
            </td>
        </tr>
    </table>

</div>

{{-- ── Footer ── --}}
<div class="footer">
    <table class="footer-inner">
        <tr>
            <td class="footer-left">Log Absensi Gerbang — {{ \Carbon\Carbon::parse($filter['tanggal'])->isoFormat('D MMMM Y') }}</td>
            <td class="footer-right">Dicetak: {{ $filter['dicetak_pada'] }} · Oleh: {{ $filter['dicetak_oleh'] }}</td>
        </tr>
    </table>
</div>

</body>
</html>