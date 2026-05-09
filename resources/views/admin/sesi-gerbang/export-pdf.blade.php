<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'DejaVu Sans', Arial, sans-serif;
        font-size: 10px;
        color: #0f172a;
        background: #fff;
    }

    /* ── Header ── */
    .header {
        padding: 18px 24px 14px;
        border-bottom: 2px solid #1f63db;
        margin-bottom: 14px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    .header-left .school-name {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: .01em;
    }
    .header-left .doc-title {
        font-size: 11px;
        font-weight: 700;
        color: #1f63db;
        margin-top: 3px;
        text-transform: uppercase;
        letter-spacing: .06em;
    }
    .header-right {
        text-align: right;
        font-size: 9px;
        color: #64748b;
        line-height: 1.7;
    }

    /* ── Filter info bar ── */
    .filter-bar {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 8px 14px;
        margin: 0 24px 14px;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    .filter-item { font-size: 9.5px; color: #475569; }
    .filter-item strong { color: #0f172a; }

    /* ── Summary boxes ── */
    .summary-row {
        display: flex;
        gap: 10px;
        margin: 0 24px 14px;
    }
    .summary-box {
        flex: 1;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 10px 14px;
        text-align: center;
    }
    .summary-box .s-label { font-size: 8.5px; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; }
    .summary-box .s-val   { font-size: 16px; font-weight: 700; color: #0f172a; margin-top: 2px; }

    /* ── Table ── */
    .table-wrap { margin: 0 24px; }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: #1f63db; }
    thead th {
        padding: 7px 8px;
        text-align: left;
        font-size: 8.5px;
        font-weight: 700;
        color: #fff;
        letter-spacing: .05em;
        text-transform: uppercase;
        white-space: nowrap;
    }
    thead th.center { text-align: center; }
    tbody tr { border-bottom: 1px solid #f1f5f9; }
    tbody tr:nth-child(even) { background: #f8fafc; }
    tbody tr.row-aktif { background: #ecfdf5; }
    td {
        padding: 6px 8px;
        font-size: 9.5px;
        color: #0f172a;
        vertical-align: middle;
    }
    td.center { text-align: center; }
    td.muted   { color: #94a3b8; }

    /* ── Badge ── */
    .badge {
        display: inline-block;
        padding: 2px 7px;
        border-radius: 99px;
        font-size: 8.5px;
        font-weight: 700;
    }
    .badge-aktif   { background: #dcfce7; color: #15803d; }
    .badge-ditutup { background: #f1f5f9; color: #475569; }
    .badge-masuk   { background: #dbeafe; color: #1d4ed8; }
    .badge-pulang  { background: #ede9fe; color: #6d28d9; }

    /* ── Footer ── */
    .footer {
        position: fixed;
        bottom: 12px;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 8.5px;
        color: #94a3b8;
        border-top: 1px solid #e2e8f0;
        padding-top: 6px;
        margin: 0 24px;
    }
    .page-num:before { content: 'Halaman ' counter(page) ' dari ' counter(pages); }
</style>
</head>
<body>

{{-- Header --}}
<div class="header">
    <div class="header-left">
        <p class="school-name">Sistem Absensi Gerbang</p>
        <p class="doc-title">Laporan Daftar Sesi Gerbang</p>
    </div>
    <div class="header-right">
        <p>Dicetak: {{ $filter['dicetak_pada'] }}</p>
        <p>Oleh: {{ $filter['dicetak_oleh'] }}</p>
    </div>
</div>

{{-- Filter info --}}
<div class="filter-bar">
    <div class="filter-item">
        <strong>Dari Tanggal:</strong>
        {{ $filter['tanggal_dari'] ? \Carbon\Carbon::parse($filter['tanggal_dari'])->isoFormat('D MMM Y') : 'Semua' }}
    </div>
    <div class="filter-item">
        <strong>Sampai Tanggal:</strong>
        {{ $filter['tanggal_sampai'] ? \Carbon\Carbon::parse($filter['tanggal_sampai'])->isoFormat('D MMM Y') : 'Semua' }}
    </div>
    <div class="filter-item">
        <strong>Tipe:</strong>
        {{ $filter['tipe'] ? ucfirst($filter['tipe']) : 'Semua' }}
    </div>
    <div class="filter-item">
        <strong>Status:</strong>
        {{ $filter['status'] ? ucfirst($filter['status']) : 'Semua' }}
    </div>
    <div class="filter-item">
        <strong>Total Data:</strong>
        {{ $sesiList->count() }} sesi
    </div>
</div>

{{-- Summary boxes --}}
@php
    $totalAktif   = $sesiList->where('status','aktif')->count();
    $totalDitutup = $sesiList->where('status','ditutup')->count();
    $totalMasuk   = $sesiList->where('tipe','masuk')->count();
    $totalPulang  = $sesiList->where('tipe','pulang')->count();
    $totalScan    = $sesiList->sum('jumlah_scan');
@endphp
<div class="summary-row">
    <div class="summary-box">
        <p class="s-label">Total Sesi</p>
        <p class="s-val">{{ $sesiList->count() }}</p>
    </div>
    <div class="summary-box">
        <p class="s-label">Aktif</p>
        <p class="s-val" style="color:#15803d">{{ $totalAktif }}</p>
    </div>
    <div class="summary-box">
        <p class="s-label">Ditutup</p>
        <p class="s-val" style="color:#475569">{{ $totalDitutup }}</p>
    </div>
    <div class="summary-box">
        <p class="s-label">Sesi Masuk</p>
        <p class="s-val" style="color:#1d4ed8">{{ $totalMasuk }}</p>
    </div>
    <div class="summary-box">
        <p class="s-label">Sesi Pulang</p>
        <p class="s-val" style="color:#7c3aed">{{ $totalPulang }}</p>
    </div>
    <div class="summary-box">
        <p class="s-label">Total Scan</p>
        <p class="s-val">{{ $totalScan }}</p>
    </div>
</div>

{{-- Table --}}
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th style="width:28px">#</th>
                <th>Tanggal</th>
                <th class="center">Tipe</th>
                <th class="center">Status</th>
                <th>Dibuka Pukul</th>
                <th>Ditutup Pukul</th>
                <th>Durasi</th>
                <th>Dibuka Oleh</th>
                <th class="center">Jml Scan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sesiList as $i => $sesi)
            <tr class="{{ $sesi->status === 'aktif' ? 'row-aktif' : '' }}">
                <td style="color:#94a3b8;font-weight:700">{{ $i + 1 }}</td>

                <td>
                    <span style="font-weight:700">{{ \Carbon\Carbon::parse($sesi->tanggal)->isoFormat('D MMM Y') }}</span>
                    <br><span style="color:#94a3b8;font-size:8.5px">{{ \Carbon\Carbon::parse($sesi->tanggal)->isoFormat('dddd') }}</span>
                </td>

                <td class="center">
                    <span class="badge badge-{{ $sesi->tipe }}">{{ $sesi->label_tipe }}</span>
                </td>

                <td class="center">
                    <span class="badge badge-{{ $sesi->status }}">{{ ucfirst($sesi->status) }}</span>
                </td>

                <td style="font-variant-numeric:tabular-nums;font-weight:600">
                    {{ $sesi->dibuka_pada->format('H:i') }}
                </td>

                <td style="font-variant-numeric:tabular-nums;font-weight:600">
                    @if($sesi->ditutup_pada)
                        {{ $sesi->ditutup_pada->format('H:i') }}
                    @else
                        <span class="muted">—</span>
                    @endif
                </td>

                <td>
                    @if($sesi->ditutup_pada)
                        @php
                            $menit = $sesi->dibuka_pada->diffInMinutes($sesi->ditutup_pada);
                            $jam   = intdiv($menit, 60);
                            $sisa  = $menit % 60;
                        @endphp
                        {{ $jam > 0 ? $jam.'j ' : '' }}{{ $sisa }}m
                    @elseif($sesi->status === 'aktif')
                        <span style="color:#059669;font-weight:700">Berjalan</span>
                    @else
                        <span class="muted">—</span>
                    @endif
                </td>

                <td>{{ $sesi->dibukaOleh?->name ?? '—' }}</td>

                <td class="center" style="font-weight:700">{{ $sesi->jumlah_scan }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center;padding:20px;color:#94a3b8">
                    Tidak ada data sesi
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="footer">
    Laporan Sesi Gerbang &mdash; Dicetak {{ $filter['dicetak_pada'] }} oleh {{ $filter['dicetak_oleh'] }}
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <span class="page-num"></span>
</div>

</body>
</html>