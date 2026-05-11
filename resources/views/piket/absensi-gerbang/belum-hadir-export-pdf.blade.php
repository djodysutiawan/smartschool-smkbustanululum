<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Siswa Belum Hadir — {{ \Carbon\Carbon::parse($filter['tanggal'])->isoFormat('D MMMM Y') }}</title>
<style>
    /* ── Reset & base ── */
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'DejaVu Sans', Arial, sans-serif;
        font-size: 10px;
        color: #1e293b;
        background: #fff;
        line-height: 1.5;
    }

    /* ── Page wrapper ── */
    .page-wrap {
        padding: 28px 32px 24px;
    }

    /* ── Header ── */
    .doc-header {
        border-bottom: 2.5px solid #1750c0;
        padding-bottom: 14px;
        margin-bottom: 16px;
    }
    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    .school-name {
        font-size: 15px;
        font-weight: 700;
        color: #1750c0;
        letter-spacing: -0.02em;
    }
    .school-sub {
        font-size: 9px;
        color: #64748b;
        margin-top: 2px;
    }
    .doc-meta {
        text-align: right;
        font-size: 8.5px;
        color: #64748b;
        line-height: 1.7;
    }

    .doc-title {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 10px;
    }
    .doc-subtitle {
        font-size: 9px;
        color: #475569;
        margin-top: 3px;
    }

    /* ── Summary row ── */
    .summary-row {
        display: table;
        width: 100%;
        margin-bottom: 16px;
        border-collapse: collapse;
    }
    .summary-cell {
        display: table-cell;
        width: 25%;
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        vertical-align: top;
    }
    .summary-cell:first-child { border-radius: 6px 0 0 6px; }
    .summary-cell:last-child  { border-radius: 0 6px 6px 0; }
    .summary-cell.danger  { background: #fef2f2; border-color: #fecaca; }
    .summary-cell.success { background: #f0fdf4; border-color: #bbf7d0; }
    .summary-cell.info    { background: #eef6ff; border-color: #d9ebff; }
    .summary-cell.neutral { background: #f8fafc; border-color: #e2e8f0; }
    .summary-label { font-size: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #94a3b8; }
    .summary-value { font-size: 20px; font-weight: 700; color: #0f172a; line-height: 1.1; margin-top: 3px; }
    .summary-cell.danger  .summary-value { color: #dc2626; }
    .summary-cell.success .summary-value { color: #15803d; }
    .summary-cell.info    .summary-value { color: #1750c0; }
    .summary-note  { font-size: 8px; color: #94a3b8; margin-top: 3px; }

    /* ── Filter info bar ── */
    .filter-info {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 5px;
        padding: 6px 12px;
        font-size: 8.5px;
        color: #475569;
        margin-bottom: 14px;
    }
    .filter-info strong { color: #0f172a; }

    /* ── Section heading ── */
    .section-head {
        background: #1750c0;
        color: #fff;
        padding: 6px 12px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border-radius: 4px 4px 0 0;
    }

    /* ── Table ── */
    table {
        width: 100%;
        border-collapse: collapse;
    }
    thead th {
        background: #f1f5f9;
        padding: 7px 10px;
        font-size: 8.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
        border-top: 1px solid #e2e8f0;
    }
    thead th:first-child { border-left: 1px solid #e2e8f0; }
    thead th:last-child  { border-right: 1px solid #e2e8f0; }

    tbody tr { border-bottom: 1px solid #f1f5f9; }
    tbody tr:nth-child(even) { background: #f8fafc; }
    tbody tr:last-child { border-bottom: 1px solid #e2e8f0; }

    tbody td {
        padding: 7px 10px;
        font-size: 9.5px;
        color: #334155;
        border-left: 1px solid #e2e8f0;
    }
    tbody td:last-child { border-right: 1px solid #e2e8f0; }

    .td-no { color: #94a3b8; font-size: 8.5px; text-align: center; width: 28px; }
    .td-nama { font-weight: 700; color: #0f172a; }
    .td-nis  { color: #64748b; font-size: 8.5px; }
    .td-kelas { font-weight: 700; color: #1750c0; }
    .td-tanda { text-align: center; color: #94a3b8; font-size: 8px; }

    /* Empty state */
    .empty-row td {
        text-align: center;
        padding: 28px;
        color: #94a3b8;
        font-style: italic;
        border-left: 1px solid #e2e8f0;
        border-right: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
    }

    /* ── Footer ── */
    .doc-footer {
        margin-top: 20px;
        display: table;
        width: 100%;
    }
    .footer-left {
        display: table-cell;
        width: 60%;
        vertical-align: bottom;
        font-size: 8px;
        color: #94a3b8;
    }
    .footer-right {
        display: table-cell;
        width: 40%;
        text-align: right;
        vertical-align: top;
    }
    .ttd-box {
        display: inline-block;
        text-align: center;
        border-top: 1px solid #94a3b8;
        padding-top: 4px;
        margin-top: 56px;
        min-width: 140px;
        font-size: 8.5px;
        color: #334155;
    }
    .ttd-label { font-size: 8px; color: #64748b; margin-bottom: 2px; }

    /* DomPDF: page break helper */
    .page-break { page-break-after: always; }
</style>
</head>
<body>
<div class="page-wrap">

    {{-- ── Document header ── --}}
    <div class="doc-header">
        <div class="header-top">
            <div>
                <p class="school-name">SISTEM INFORMASI SEKOLAH</p>
                <p class="school-sub">Laporan Absensi Gerbang &mdash; Modul Piket</p>
            </div>
            <div class="doc-meta">
                <strong>Dicetak oleh:</strong> {{ $filter['dicetak_oleh'] }}<br>
                <strong>Tanggal cetak:</strong> {{ $filter['dicetak_pada'] }}<br>
                <strong>Halaman:</strong> 1
            </div>
        </div>
        <p class="doc-title">DAFTAR SISWA BELUM HADIR</p>
        <p class="doc-subtitle">
            Tanggal: {{ \Carbon\Carbon::parse($filter['tanggal'])->isoFormat('dddd, D MMMM Y') }}
            &nbsp;&bull;&nbsp;
            Kelas: {{ $filter['kelas_label'] }}
        </p>
    </div>

    {{-- ── Summary ── --}}
    <div class="summary-row">
        <div class="summary-cell danger">
            <p class="summary-label">Belum Hadir</p>
            <p class="summary-value">{{ $belumHadirList->count() }}</p>
            <p class="summary-note">siswa tidak hadir</p>
        </div>
        <div class="summary-cell success">
            <p class="summary-label">Sudah Hadir</p>
            @php
                $totalSiswa   = \App\Models\Siswa::aktif()
                    ->when(!empty($filter['kelas_id']), fn($q) => $q->where('kelas_id', $filter['kelas_id']))
                    ->count();
                $sudahHadir   = max(0, $totalSiswa - $belumHadirList->count());
                $persen       = $totalSiswa > 0 ? round($sudahHadir / $totalSiswa * 100, 1) : 0;
            @endphp
            <p class="summary-value">{{ $sudahHadir }}</p>
            <p class="summary-note">{{ $persen }}% kehadiran</p>
        </div>
        <div class="summary-cell info">
            <p class="summary-label">Total Siswa</p>
            <p class="summary-value">{{ $totalSiswa }}</p>
            <p class="summary-note">siswa aktif terdaftar</p>
        </div>
        <div class="summary-cell neutral">
            <p class="summary-label">Tanggal Laporan</p>
            <p class="summary-value" style="font-size:12px;margin-top:4px">
                {{ \Carbon\Carbon::parse($filter['tanggal'])->isoFormat('D MMM Y') }}
            </p>
            <p class="summary-note">{{ \Carbon\Carbon::parse($filter['tanggal'])->isoFormat('dddd') }}</p>
        </div>
    </div>

    {{-- ── Filter info ── --}}
    <div class="filter-info">
        <strong>Filter:</strong>
        Kelas: <strong>{{ $filter['kelas_label'] }}</strong>
        &nbsp;&bull;&nbsp;
        Tanggal: <strong>{{ \Carbon\Carbon::parse($filter['tanggal'])->isoFormat('D MMMM Y') }}</strong>
        &nbsp;&bull;&nbsp;
        Total ditampilkan: <strong>{{ $belumHadirList->count() }} siswa</strong>
    </div>

    {{-- ── Table ── --}}
    <div class="section-head">Daftar Siswa Belum Hadir</div>
    <table>
        <thead>
            <tr>
                <th style="width:28px;text-align:center">No</th>
                <th>Nama Siswa</th>
                <th style="width:90px">NIS</th>
                <th style="width:80px">Kelas</th>
                <th style="width:80px;text-align:center">Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($belumHadirList as $no => $siswa)
                <tr>
                    <td class="td-no">{{ $no + 1 }}</td>
                    <td class="td-nama">{{ $siswa->nama_lengkap }}</td>
                    <td class="td-nis">{{ $siswa->nis }}</td>
                    <td class="td-kelas">{{ $siswa->kelas?->nama_kelas ?? '—' }}</td>
                    <td class="td-tanda">............</td>
                </tr>
            @empty
                <tr class="empty-row">
                    <td colspan="5">Semua siswa sudah hadir — tidak ada data untuk ditampilkan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ── Footer ── --}}
    <div class="doc-footer">
        <div class="footer-left">
            Dokumen ini dicetak secara otomatis oleh sistem.<br>
            Harap verifikasi data dengan data absensi resmi sekolah.
        </div>
        <div class="footer-right">
            <p class="ttd-label">Mengetahui, Guru Piket</p>
            <div class="ttd-box">
                {{ $filter['dicetak_oleh'] }}<br>
                <span style="color:#94a3b8">NIP. ...............................</span>
            </div>
        </div>
    </div>

</div>
</body>
</html>