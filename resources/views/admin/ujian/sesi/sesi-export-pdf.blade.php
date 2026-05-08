<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Hasil Ujian — {{ $ujian->judul }}</title>
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: 'DejaVu Sans', Arial, sans-serif;
        font-size: 9pt;
        color: #0f172a;
        background: #fff;
    }

    /* ── HEADER ── */
    .header {
        padding: 14px 20px 12px;
        border-bottom: 2.5px solid #1f63db;
        margin-bottom: 14px;
        display: table;
        width: 100%;
    }
    .header-left { display: table-cell; vertical-align: middle; }
    .header-right { display: table-cell; vertical-align: middle; text-align: right; }
    .doc-title {
        font-size: 15pt;
        font-weight: 700;
        color: #1750c0;
        line-height: 1.2;
    }
    .doc-sub {
        font-size: 8pt;
        color: #64748b;
        margin-top: 2px;
    }
    .school-name {
        font-size: 9pt;
        font-weight: 700;
        color: #0f172a;
    }
    .print-info {
        font-size: 7.5pt;
        color: #94a3b8;
        margin-top: 2px;
    }

    /* ── UJIAN INFO BOX ── */
    .info-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #1f63db;
        border-radius: 5px;
        padding: 10px 14px;
        margin-bottom: 14px;
    }
    .info-box table { width: 100%; }
    .info-box td {
        font-size: 8.5pt;
        color: #475569;
        padding: 2px 0;
        vertical-align: top;
    }
    .info-box td.label {
        font-weight: 700;
        width: 130px;
        color: #94a3b8;
        font-size: 7.5pt;
        text-transform: uppercase;
        letter-spacing: .03em;
    }
    .info-box td.value { color: #0f172a; font-weight: 600; }
    .info-box td.value .jenis-tag {
        display: inline-block;
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        border-radius: 4px;
        padding: 0 6px;
        font-size: 7.5pt;
        font-weight: 700;
    }

    /* ── STATS ── */
    .stats-row {
        display: table;
        width: 100%;
        margin-bottom: 14px;
        border-collapse: separate;
        border-spacing: 5px 0;
    }
    .stat-box {
        display: table-cell;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 5px;
        padding: 8px 12px;
        text-align: center;
        width: 16.66%;
    }
    .stat-label {
        font-size: 7pt;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .stat-val {
        font-size: 16pt;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
        margin-top: 2px;
    }
    .stat-val.green { color: #15803d; }
    .stat-val.red   { color: #dc2626; }
    .stat-val.blue  { color: #1f63db; }

    /* ── TABLE ── */
    .section-title {
        font-size: 9pt;
        font-weight: 700;
        color: #1750c0;
        letter-spacing: .04em;
        text-transform: uppercase;
        margin-bottom: 6px;
        padding-bottom: 5px;
        border-bottom: 1.5px solid #e2e8f0;
    }
    table.data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 8.5pt;
    }
    table.data-table thead tr {
        background: #1f63db;
        color: #fff;
    }
    table.data-table thead th {
        padding: 7px 8px;
        text-align: left;
        font-size: 7.5pt;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        white-space: nowrap;
    }
    table.data-table thead th.center { text-align: center; }
    table.data-table tbody tr { border-bottom: 1px solid #f1f5f9; }
    table.data-table tbody tr:nth-child(even) { background: #f8fafc; }
    table.data-table tbody tr:last-child { border-bottom: none; }
    table.data-table tbody td {
        padding: 6px 8px;
        color: #0f172a;
        vertical-align: middle;
    }
    table.data-table tbody td.center { text-align: center; }
    table.data-table tbody td.muted { color: #64748b; }

    /* ── BADGES ── */
    .badge {
        display: inline-block;
        padding: 1px 7px;
        border-radius: 99px;
        font-size: 7pt;
        font-weight: 700;
        white-space: nowrap;
    }
    .badge-lulus { background: #dcfce7; color: #15803d; }
    .badge-gagal { background: #fee2e2; color: #dc2626; }
    .badge-selesai { background: #dcfce7; color: #15803d; }
    .badge-habis_waktu { background: #fee2e2; color: #dc2626; }
    .badge-berlangsung { background: #dbeafe; color: #1d4ed8; }
    .badge-belum_mulai { background: #f1f5f9; color: #64748b; }
    .badge-pending { background: #fef9c3; color: #a16207; }

    /* ── RANK ── */
    .rank-1 { color: #b45309; font-weight: 800; }
    .rank-2 { color: #64748b; font-weight: 800; }
    .rank-3 { color: #92400e; font-weight: 800; }

    /* ── NILAI BAR ── */
    .nilai-cell { white-space: nowrap; }
    .nilai-bar-bg {
        display: inline-block;
        width: 50px;
        height: 5px;
        background: #e2e8f0;
        border-radius: 99px;
        vertical-align: middle;
        margin-right: 5px;
        overflow: hidden;
    }
    .nilai-bar-fill {
        display: inline-block;
        height: 5px;
        border-radius: 99px;
        vertical-align: top;
    }
    .nilai-text {
        display: inline-block;
        font-weight: 700;
        font-size: 9pt;
        vertical-align: middle;
    }

    /* ── FOOTER ── */
    .footer {
        margin-top: 20px;
        padding-top: 10px;
        border-top: 1px solid #e2e8f0;
        font-size: 7.5pt;
        color: #94a3b8;
        text-align: center;
    }
    .signature-area {
        margin-top: 30px;
        display: table;
        width: 100%;
    }
    .sig-box {
        display: table-cell;
        text-align: center;
        width: 33.33%;
        font-size: 8pt;
        color: #475569;
    }
    .sig-line {
        margin-top: 50px;
        border-top: 1px solid #0f172a;
        padding-top: 4px;
        margin-left: 20px;
        margin-right: 20px;
    }

    @page {
        margin: 14mm 14mm 14mm 14mm;
        size: A4 landscape;
    }
    .page-break { page-break-after: always; }
</style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    <div class="header-left">
        <div class="doc-title">Laporan Hasil Ujian</div>
        <div class="doc-sub">{{ $ujian->judul }}</div>
    </div>
    <div class="header-right">
        <div class="school-name">Sistem Ujian Online</div>
        <div class="print-info">Dicetak: {{ now()->format('d M Y, H:i') }}</div>
    </div>
</div>

{{-- INFO UJIAN --}}
<div class="info-box">
    <table>
        <tr>
            <td>
                <table>
                    <tr>
                        <td class="label">Mata Pelajaran</td>
                        <td class="value">{{ $ujian->mataPelajaran->nama_mapel ?? '-' }}</td>
                        <td style="width:40px;"></td>
                        <td class="label">Guru Pengampu</td>
                        <td class="value">{{ $ujian->guru->nama_lengkap ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Kelas</td>
                        <td class="value">{{ $ujian->kelas->nama_kelas ?? '-' }}</td>
                        <td></td>
                        <td class="label">Tanggal</td>
                        <td class="value">{{ \Carbon\Carbon::parse($ujian->tanggal)->format('d M Y') }}{{ $ujian->jam_mulai ? ', ' . $ujian->jam_mulai : '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Jenis Ujian</td>
                        <td class="value">
                            <span class="jenis-tag">{{ strtoupper(str_replace('_', ' ', $ujian->jenis)) }}</span>
                        </td>
                        <td></td>
                        <td class="label">Durasi / KKM</td>
                        <td class="value">{{ $ujian->durasi_menit }} menit / {{ $ujian->nilai_kkm ?? '—' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

{{-- STATS --}}
@php
    $totalPeserta  = $sesiList->count();
    $lulus         = $sesiList->where('lulus', true)->count();
    $tidakLulus    = $sesiList->where('lulus', false)->count();
    $rataRata      = $sesiList->whereNotNull('nilai_akhir')->avg('nilai_akhir') ?? 0;
    $tertinggi     = $sesiList->max('nilai_akhir') ?? 0;
    $terendah      = $sesiList->whereNotNull('nilai_akhir')->min('nilai_akhir') ?? 0;
@endphp
<div class="stats-row">
    <div class="stat-box">
        <div class="stat-label">Peserta</div>
        <div class="stat-val blue">{{ $totalPeserta }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Lulus</div>
        <div class="stat-val green">{{ $lulus }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Tidak Lulus</div>
        <div class="stat-val red">{{ $tidakLulus }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Rata-rata</div>
        <div class="stat-val {{ round($rataRata) >= ($ujian->nilai_kkm ?? 70) ? 'green' : 'red' }}">
            {{ number_format($rataRata, 1) }}
        </div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Tertinggi</div>
        <div class="stat-val green">{{ number_format($tertinggi, 1) }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Terendah</div>
        <div class="stat-val red">{{ number_format($terendah, 1) }}</div>
    </div>
</div>

{{-- TABEL HASIL --}}
<div class="section-title">Rekap Nilai Siswa</div>

<table class="data-table">
    <thead>
        <tr>
            <th style="width:32px;" class="center">No</th>
            <th style="width:28px;" class="center">Rank</th>
            <th>Nama Siswa</th>
            <th>NIS</th>
            <th class="center">Status Ujian</th>
            <th>Mulai</th>
            <th>Selesai</th>
            <th class="center">Durasi</th>
            <th class="center" style="width:130px;">Nilai Akhir</th>
            <th class="center">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @php $rank = 1; $prevNilai = null; $displayRank = 1; @endphp
        @forelse($sesiList as $i => $sesi)
        @php
            $nilai = $sesi->nilai_akhir;
            if ($prevNilai !== null && $nilai < $prevNilai) { $displayRank = $rank; }
            $barColor = ($nilai ?? 0) >= ($ujian->nilai_kkm ?? 70) ? '#15803d' : '#dc2626';
            $barWidth  = min(100, round(($nilai ?? 0)));
            $durasiMnt = null;
            if ($sesi->mulai_pada && $sesi->selesai_pada) {
                $durasiMnt = \Carbon\Carbon::parse($sesi->mulai_pada)
                    ->diffInMinutes(\Carbon\Carbon::parse($sesi->selesai_pada));
            }
        @endphp
        <tr>
            <td class="center muted">{{ $i + 1 }}</td>
            <td class="center">
                @if(!is_null($nilai))
                    <span class="{{ $displayRank <= 3 ? 'rank-' . $displayRank : '' }}">
                        {{ $displayRank }}
                    </span>
                @else
                    <span class="muted">—</span>
                @endif
            </td>
            <td style="font-weight:600;">{{ $sesi->siswa->nama_lengkap ?? '-' }}</td>
            <td class="muted">{{ $sesi->siswa->nis ?? '-' }}</td>
            <td class="center">
                <span class="badge badge-{{ $sesi->status }}">
                    @switch($sesi->status)
                        @case('selesai') Selesai @break
                        @case('berlangsung') Berlangsung @break
                        @case('habis_waktu') Habis Waktu @break
                        @case('belum_mulai') Belum Mulai @break
                        @default {{ $sesi->status }}
                    @endswitch
                </span>
            </td>
            <td class="muted" style="font-size:7.5pt;">
                {{ $sesi->mulai_pada ? \Carbon\Carbon::parse($sesi->mulai_pada)->format('H:i') : '—' }}
            </td>
            <td class="muted" style="font-size:7.5pt;">
                {{ $sesi->selesai_pada ? \Carbon\Carbon::parse($sesi->selesai_pada)->format('H:i') : '—' }}
            </td>
            <td class="center muted" style="font-size:7.5pt;">
                {{ $durasiMnt !== null ? $durasiMnt . ' mnt' : '—' }}
            </td>
            <td class="center nilai-cell">
                @if(!is_null($nilai))
                    <span class="nilai-bar-bg">
                        <span class="nilai-bar-fill"
                              style="width:{{ $barWidth }}%;background:{{ $barColor }};"></span>
                    </span>
                    <span class="nilai-text" style="color:{{ $barColor }}">
                        {{ number_format($nilai, 1) }}
                    </span>
                @else
                    <span class="badge badge-pending">Menunggu</span>
                @endif
            </td>
            <td class="center">
                @if(!is_null($sesi->lulus))
                    <span class="badge {{ $sesi->lulus ? 'badge-lulus' : 'badge-gagal' }}">
                        {{ $sesi->lulus ? 'Lulus' : 'Tidak Lulus' }}
                    </span>
                @else
                    <span class="muted" style="font-size:7.5pt;">—</span>
                @endif
            </td>
        </tr>
        @php
            $prevNilai = $nilai;
            $rank++;
        @endphp
        @empty
        <tr>
            <td colspan="10" style="text-align:center;padding:20px;color:#94a3b8;">
                Belum ada data sesi pengerjaan.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- SIGNATURE --}}
<div class="signature-area">
    <div class="sig-box">
        <div>Mengetahui,</div>
        <div style="font-weight:700;margin-top:2px;">Kepala Sekolah</div>
        <div class="sig-line">( _____________________ )</div>
    </div>
    <div class="sig-box"></div>
    <div class="sig-box">
        <div>{{ \Carbon\Carbon::parse($ujian->tanggal)->locale('id')->isoFormat('D MMMM Y') }},</div>
        <div style="font-weight:700;margin-top:2px;">Guru Mata Pelajaran</div>
        <div class="sig-line">( {{ $ujian->guru->nama_lengkap ?? '___________________' }} )</div>
    </div>
</div>

{{-- FOOTER --}}
<div class="footer">
    Dokumen ini digenerate secara otomatis oleh Sistem Ujian Online pada {{ now()->format('d M Y H:i:s') }}
    — Halaman <span style="font-weight:700;">1</span>
</div>

</body>
</html>