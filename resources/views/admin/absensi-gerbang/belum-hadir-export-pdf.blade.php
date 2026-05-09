<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Daftar Siswa Belum Hadir — {{ $filter['tanggal'] }}</title>
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
    .header-accent {
        width: 100%;
        height: 5px;
        background: #dc2626;
        border-radius: 3px;
        margin-bottom: 14px;
        display: block;
    }
    .header-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }
    .header-table td {
        vertical-align: top;
    }
    .doc-main-title {
        font-size: 15pt;
        font-weight: bold;
        color: #0f172a;
        letter-spacing: -0.02em;
    }
    .doc-sub-title {
        font-size: 10pt;
        color: #dc2626;
        font-weight: bold;
        margin-top: 2px;
    }
    .doc-meta-line {
        font-size: 8pt;
        color: #64748b;
        margin-top: 3px;
    }
    .header-badge {
        background: #fee2e2;
        border: 1px solid #fecaca;
        border-radius: 6px;
        padding: 8px 14px;
        text-align: center;
        vertical-align: middle;
        width: 120px;
    }
    .header-badge-val {
        font-size: 22pt;
        font-weight: bold;
        color: #dc2626;
        line-height: 1;
    }
    .header-badge-label {
        font-size: 7.5pt;
        color: #b91c1c;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-top: 2px;
    }
    .header-divider {
        border: none;
        border-top: 1.5px solid #e2e8f0;
        margin: 10px 0 14px 0;
    }

    /* ── Info meta table ── */
    .meta-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 14px;
        font-size: 8.5pt;
        background: #fff7ed;
        border: 1px solid #fed7aa;
        border-radius: 6px;
    }
    .meta-table td {
        padding: 5px 12px;
        vertical-align: top;
    }
    .meta-table .label {
        color: #92400e;
        font-weight: bold;
        width: 22%;
        white-space: nowrap;
    }
    .meta-table .sep {
        color: #b45309;
        width: 10px;
    }
    .meta-table .val {
        color: #0f172a;
    }
    .meta-table tr:not(:last-child) td {
        border-bottom: 1px solid #fde68a;
    }

    /* ── Stat boxes ── */
    .stat-row {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 16px;
    }
    .stat-cell {
        padding: 0 6px 0 0;
        vertical-align: top;
    }
    .stat-cell:last-child { padding-right: 0; }
    .stat-box {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 9px 10px;
        text-align: center;
    }
    .stat-val   { font-size: 18pt; font-weight: bold; line-height: 1; color: #0f172a; }
    .stat-label { font-size: 7pt; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; font-weight: bold; margin-top: 3px; }
    .stat-box.red    { background: #fff0f0; border-color: #fecaca; }
    .stat-box.green  { background: #f0fdf4; border-color: #bbf7d0; }
    .stat-box.gray   { background: #f8fafc; border-color: #e2e8f0; }
    .stat-box.blue   { background: #eff6ff; border-color: #bfdbfe; }
    .stat-box.red    .stat-val { color: #dc2626; }
    .stat-box.green  .stat-val { color: #15803d; }
    .stat-box.blue   .stat-val { color: #1d4ed8; }

    /* ── Section title ── */
    .section-title {
        font-size: 8.5pt;
        font-weight: bold;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border-left: 3px solid #dc2626;
        padding-left: 8px;
        margin-bottom: 8px;
        margin-top: 14px;
    }

    /* ── Main table ── */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 8.5pt;
    }
    .data-table thead tr {
        background: #dc2626;
    }
    .data-table thead th {
        color: #fff;
        font-weight: bold;
        padding: 7px 8px;
        text-align: left;
        font-size: 7.5pt;
        letter-spacing: 0.03em;
        white-space: nowrap;
    }
    .data-table thead th.center { text-align: center; }

    .data-table tbody tr { border-bottom: 1px solid #f1f5f9; }
    .data-table tbody tr:nth-child(even) { background: #fef2f2; }
    .data-table tbody tr.kelas-header-row td {
        background: #fee2e2;
        font-weight: bold;
        font-size: 8pt;
        color: #b91c1c;
        padding: 5px 8px;
        letter-spacing: 0.03em;
    }
    .data-table tbody td {
        padding: 6px 8px;
        vertical-align: middle;
        color: #0f172a;
    }
    .data-table tbody td.center { text-align: center; }
    .data-table tbody td.muted  { color: #94a3b8; font-size: 8pt; }
    .data-table .no-col         { color: #94a3b8; font-size: 7.5pt; }
    .data-table .nama-primary   { font-weight: bold; font-size: 8.5pt; }

    /* ── Kolom tanda (untuk absensi manual di sekolah) ── */
    .check-col {
        width: 28px;
        text-align: center;
        border: 1px solid #fecaca;
        height: 14px;
    }

    /* ── Ringkasan per kelas ── */
    .kelas-summary {
        width: 100%;
        border-collapse: collapse;
        margin-top: 14px;
        font-size: 8.5pt;
    }
    .kelas-summary thead tr { background: #7f1d1d; }
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
    .kelas-summary tfoot tr { background: #f1f5f9; border-top: 2px solid #cbd5e1; }
    .kelas-summary tfoot td { padding: 6px 8px; font-weight: bold; font-size: 8.5pt; }
    .kelas-summary tfoot td.center { text-align: center; }

    /* ── Catatan / tindak lanjut ── */
    .note-section {
        margin-top: 16px;
        border: 1px solid #fde68a;
        background: #fffbeb;
        border-radius: 6px;
        padding: 10px 14px;
    }
    .note-title {
        font-size: 8pt;
        font-weight: bold;
        color: #92400e;
        margin-bottom: 5px;
    }
    .note-line {
        border-bottom: 1px dashed #fde68a;
        margin-bottom: 8px;
        padding-bottom: 8px;
        font-size: 8pt;
        color: #a16207;
    }
    .note-line:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }

    /* ── Tanda tangan ── */
    .ttd-section {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
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
    .footer-table { width: 100%; border-collapse: collapse; }
    .footer-table td { font-size: 7.5pt; color: #94a3b8; }
    .footer-table .fl { text-align: left; }
    .footer-table .fr { text-align: right; }
</style>
</head>
<body>
<div class="page">

    {{-- ── Header ── --}}
    <div class="header-accent"></div>
    <table class="header-table">
        <tr>
            <td>
                <div class="doc-main-title">Daftar Siswa Belum Hadir</div>
                <div class="doc-sub-title">{{ \Carbon\Carbon::parse($filter['tanggal'])->isoFormat('dddd, D MMMM Y') }}</div>
                <div class="doc-meta-line">
                    Kelas: {{ $filter['kelas_label'] }}
                    &nbsp;&middot;&nbsp;
                    Dicetak: {{ $filter['dicetak_pada'] }}
                    &nbsp;&middot;&nbsp;
                    Oleh: {{ $filter['dicetak_oleh'] }}
                </div>
            </td>
            <td style="width:130px;text-align:right;vertical-align:top">
                <div class="header-badge">
                    <div class="header-badge-val">{{ $belumHadirList->count() }}</div>
                    <div class="header-badge-label">Belum Hadir</div>
                </div>
            </td>
        </tr>
    </table>
    <hr class="header-divider">

    {{-- ── Meta info ── --}}
    <table class="meta-table">
        <tr>
            <td class="label">Tanggal</td>
            <td class="sep">:</td>
            <td class="val">{{ \Carbon\Carbon::parse($filter['tanggal'])->isoFormat('D MMMM Y') }}</td>
            <td class="label" style="width:22%">Kelas Filter</td>
            <td class="sep">:</td>
            <td class="val">{{ $filter['kelas_label'] }}</td>
        </tr>
        <tr>
            <td class="label">Dicetak Pada</td>
            <td class="sep">:</td>
            <td class="val">{{ $filter['dicetak_pada'] }}</td>
            <td class="label">Dicetak Oleh</td>
            <td class="sep">:</td>
            <td class="val">{{ $filter['dicetak_oleh'] }}</td>
        </tr>
    </table>

    {{-- ── Stat Boxes ── --}}
    @php
        $totalBelum  = $belumHadirList->count();
        $perKelas    = $belumHadirList->groupBy(fn($s) => $s->kelas?->nama_kelas ?? 'Tanpa Kelas')->sortKeys();
        $kelasCount  = $perKelas->count();
    @endphp
    <table class="stat-row">
        <tr>
            <td class="stat-cell" style="width:25%">
                <div class="stat-box red">
                    <div class="stat-val">{{ $totalBelum }}</div>
                    <div class="stat-label">Belum Hadir</div>
                </div>
            </td>
            <td class="stat-cell" style="width:25%">
                <div class="stat-box gray">
                    <div class="stat-val">{{ $kelasCount }}</div>
                    <div class="stat-label">Kelas Terdampak</div>
                </div>
            </td>
            <td class="stat-cell" style="width:25%">
                <div class="stat-box gray">
                    <div class="stat-val">{{ $perKelas->count() > 0 ? round($totalBelum / max($perKelas->count(), 1), 1) : 0 }}</div>
                    <div class="stat-label">Rata-rata / Kelas</div>
                </div>
            </td>
            <td class="stat-cell" style="width:25%">
                <div class="stat-box gray">
                    <div class="stat-val">{{ $perKelas->map->count()->max() ?? 0 }}</div>
                    <div class="stat-label">Terbanyak / Kelas</div>
                </div>
            </td>
        </tr>
    </table>

    {{-- ── Daftar Siswa (dikelompokkan per kelas) ── --}}
    <div class="section-title">Daftar Siswa Belum Hadir — {{ $totalBelum }} Siswa</div>

    @if($belumHadirList->isEmpty())
    <table class="data-table">
        <tbody>
            <tr>
                <td style="text-align:center;padding:24px;color:#94a3b8;font-style:italic">
                    Semua siswa sudah hadir pada tanggal ini.
                </td>
            </tr>
        </tbody>
    </table>
    @else
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:26px">#</th>
                <th>Nama Siswa</th>
                <th style="width:70px">NIS</th>
                <th style="width:80px">Kelas</th>
                <th class="center" style="width:90px">Keterangan</th>
                <th class="center" style="width:26px">✓</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; $prevKelas = null; @endphp
            @foreach($belumHadirList->sortBy(fn($s) => ($s->kelas?->nama_kelas ?? 'zzz') . $s->nama_lengkap) as $siswa)
                @php
                    $namaKelas = $siswa->kelas?->nama_kelas ?? 'Tanpa Kelas';
                    $kelasChanged = $namaKelas !== $prevKelas;
                    $prevKelas = $namaKelas;
                @endphp

                @if($kelasChanged)
                <tr class="kelas-header-row">
                    <td colspan="6">
                        &#9658; {{ $namaKelas }}
                        &nbsp;&mdash;&nbsp;
                        {{ $perKelas->get($namaKelas)?->count() ?? 0 }} siswa belum hadir
                    </td>
                </tr>
                @endif

                <tr>
                    <td><span class="no-col">{{ $no++ }}</span></td>
                    <td><span class="nama-primary">{{ $siswa->nama_lengkap }}</span></td>
                    <td style="font-size:8pt;color:#475569">{{ $siswa->nis }}</td>
                    <td class="muted">{{ $namaKelas }}</td>
                    <td class="center">
                        <table style="width:100%;border-collapse:collapse">
                            <tr>
                                <td style="width:33%;border:1px solid #fecaca;text-align:center;font-size:7pt;padding:2px;color:#b91c1c">S</td>
                                <td style="width:33%;border:1px solid #fecaca;text-align:center;font-size:7pt;padding:2px;color:#b91c1c">I</td>
                                <td style="width:33%;border:1px solid #fecaca;text-align:center;font-size:7pt;padding:2px;color:#b91c1c">A</td>
                            </tr>
                        </table>
                    </td>
                    <td style="text-align:center;border:1px solid #e2e8f0;height:18px"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- ── Ringkasan Per Kelas ── --}}
    @if($perKelas->count() > 1)
    <div class="section-title" style="margin-top:18px">Ringkasan Per Kelas</div>
    <table class="kelas-summary">
        <thead>
            <tr>
                <th style="width:26px">#</th>
                <th>Kelas</th>
                <th class="center">Jml Belum Hadir</th>
                <th class="center">Persentase dari Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($perKelas as $namaKelas => $siswaBelum)
            <tr>
                <td><span class="no-col">{{ $loop->iteration }}</span></td>
                <td style="font-weight:bold">{{ $namaKelas }}</td>
                <td class="center" style="color:#dc2626;font-weight:bold">{{ $siswaBelum->count() }}</td>
                <td class="center" style="color:#475569">
                    {{ $totalBelum > 0 ? round(($siswaBelum->count() / $totalBelum) * 100, 1) : 0 }}%
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="font-weight:bold">TOTAL</td>
                <td class="center" style="color:#dc2626">{{ $totalBelum }}</td>
                <td class="center">100%</td>
            </tr>
        </tfoot>
    </table>
    @endif

    {{-- ── Catatan Tindak Lanjut ── --}}
    <div class="note-section">
        <div class="note-title">&#9888; Tindak Lanjut yang Disarankan</div>
        <div class="note-line">1. Hubungi wali kelas untuk konfirmasi ketidakhadiran masing-masing siswa.</div>
        <div class="note-line">2. Jika siswa hadir namun tidak sempat scan, gunakan fitur Input Manual pada sistem.</div>
        <div class="note-line">3. Siswa yang tidak masuk tanpa keterangan perlu dihubungi oleh guru BK / wali kelas.</div>
    </div>

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
    <table class="footer-table">
        <tr>
            <td class="fl">Daftar Siswa Belum Hadir — {{ $filter['kelas_label'] }} — {{ \Carbon\Carbon::parse($filter['tanggal'])->isoFormat('D MMMM Y') }}</td>
            <td class="fr">Dicetak: {{ $filter['dicetak_pada'] }} · {{ $filter['dicetak_oleh'] }}</td>
        </tr>
    </table>
</div>

</body>
</html>