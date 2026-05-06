<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'DejaVu Sans', Arial, sans-serif;
        font-size: 9px;
        color: #1e293b;
        background: #fff;
    }

    /* ── Header ─────────────────────────────────────────── */
    .header {
        background: #1f63db;
        color: #fff;
        padding: 14px 20px 12px;
        margin-bottom: 16px;
    }
    .header-title {
        font-size: 15px;
        font-weight: bold;
        margin-bottom: 3px;
        letter-spacing: .02em;
    }
    .header-sub {
        font-size: 8.5px;
        opacity: .85;
    }

    /* ── Stats (gunakan tabel biasa, bukan display:table) ─ */
    .stats-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 14px;
    }
    .stats-table td {
        width: 25%;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 9px 12px;
        text-align: center;
        vertical-align: middle;
    }
    .stats-table td + td {
        border-left: none;
    }
    .stat-val {
        font-size: 17px;
        font-weight: bold;
        color: #1f63db;
        display: block;
    }
    .stat-label {
        font-size: 7.5px;
        color: #64748b;
        margin-top: 3px;
        text-transform: uppercase;
        letter-spacing: .05em;
        display: block;
    }

    /* ── Data Table ──────────────────────────────────────── */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 8.5px;
        margin-bottom: 14px;
    }
    .data-table thead th {
        background: #1f63db;
        color: #fff;
        padding: 7px 8px;
        text-align: left;
        font-size: 8px;
        text-transform: uppercase;
        letter-spacing: .04em;
        border: none;
    }
    .data-table thead th.center {
        text-align: center;
    }
    .data-table tbody tr:nth-child(even) {
        background: #f8fafc;
    }
    .data-table tbody tr:nth-child(odd) {
        background: #ffffff;
    }
    .data-table td {
        padding: 6px 8px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .data-table td.center {
        text-align: center;
    }

    /* ── Badges ──────────────────────────────────────────── */
    .badge {
        display: inline;
        padding: 2px 7px;
        font-size: 7.5px;
        font-weight: bold;
    }
    .badge-aktif    { background: #dcfce7; color: #15803d; }
    .badge-nonaktif { background: #fee2e2; color: #dc2626; }
    .badge-ganjil   { background: #eef6ff; color: #1f63db; }
    .badge-genap    { background: #fdf4ff; color: #7c3aed; }

    .num    { color: #94a3b8; font-weight: bold; }
    .strong { font-weight: bold; }
    .muted  { color: #64748b; }

    /* ── Footer ──────────────────────────────────────────── */
    .footer-table {
        width: 100%;
        border-collapse: collapse;
        border-top: 1px solid #e2e8f0;
        padding-top: 0;
    }
    .footer-table td {
        padding-top: 8px;
        font-size: 8px;
        color: #94a3b8;
        border: none;
    }
    .footer-right { text-align: right; }
</style>
</head>
<body>

{{-- Header --}}
<div class="header">
    <div class="header-title">Data Tahun Ajaran</div>
    <div class="header-sub">Laporan data tahun ajaran &mdash; Dicetak {{ now()->translatedFormat('d F Y, H:i') }} WIB</div>
</div>

{{--
    FIX: Ganti display:table + border-spacing (tidak didukung DomPDF)
    dengan tabel HTML biasa. Hitung di Blade agar tidak ada method call berulang.
--}}
@php
    $total       = $tahunAjaran->count();
    $totalAktif  = $tahunAjaran->where('status', 'aktif')->count();
    $totalGanjil = $tahunAjaran->where('semester', 'ganjil')->count();
    $totalGenap  = $tahunAjaran->where('semester', 'genap')->count();
@endphp

<table class="stats-table">
    <tr>
        <td>
            <span class="stat-val">{{ $total }}</span>
            <span class="stat-label">Total</span>
        </td>
        <td>
            <span class="stat-val">{{ $totalAktif }}</span>
            <span class="stat-label">Aktif</span>
        </td>
        <td>
            <span class="stat-val">{{ $totalGanjil }}</span>
            <span class="stat-label">Sem. Ganjil</span>
        </td>
        <td>
            <span class="stat-val">{{ $totalGenap }}</span>
            <span class="stat-label">Sem. Genap</span>
        </td>
    </tr>
</table>

{{-- Data Table --}}
<table class="data-table">
    <thead>
        <tr>
            <th class="center" style="width:22px">#</th>
            <th style="width:18%">Tahun Ajaran</th>
            <th class="center" style="width:12%">Semester</th>
            <th style="width:14%">Tgl. Mulai</th>
            <th style="width:14%">Tgl. Selesai</th>
            <th class="center" style="width:13%">Status</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($tahunAjaran as $i => $ta)
        <tr>
            <td class="center"><span class="num">{{ $i + 1 }}</span></td>
            <td><span class="strong">{{ $ta->tahun }}</span></td>
            <td class="center">
                <span class="badge badge-{{ $ta->semester }}">{{ ucfirst($ta->semester) }}</span>
            </td>
            <td>{{ $ta->tanggal_mulai?->format('d/m/Y') ?? '-' }}</td>
            <td>{{ $ta->tanggal_selesai?->format('d/m/Y') ?? '-' }}</td>
            <td class="center">
                @if($ta->status === 'aktif')
                    <span class="badge badge-aktif">Aktif</span>
                @else
                    <span class="badge badge-nonaktif">Tidak Aktif</span>
                @endif
            </td>
            <td><span class="muted">{{ $ta->keterangan ?? '-' }}</span></td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align:center;color:#94a3b8;padding:20px 8px;">
                Tidak ada data tahun ajaran.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- Footer --}}
<table class="footer-table">
    <tr>
        <td>Sistem Informasi Sekolah &mdash; Dicetak oleh: {{ auth()->user()->name }}</td>
        <td class="footer-right">{{ now()->format('d/m/Y H:i') }}</td>
    </tr>
</table>

</body>
</html>