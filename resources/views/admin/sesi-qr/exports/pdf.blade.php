<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Sesi QR</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #1a1a2e;
            background: #fff;
        }
        .header {
            text-align: center;
            padding: 18px 0 10px;
            border-bottom: 2px solid #1a1a2e;
            margin-bottom: 14px;
        }
        .header h1 {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .header p {
            font-size: 9px;
            color: #555;
            margin-top: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead tr {
            background: #1a1a2e;
            color: #fff;
        }
        thead th {
            padding: 7px 8px;
            text-align: left;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        tbody tr:nth-child(even) { background: #f5f6fa; }
        tbody tr:nth-child(odd)  { background: #ffffff; }
        tbody td {
            padding: 6px 8px;
            border-bottom: 1px solid #e8e8e8;
            font-size: 9px;
            vertical-align: middle;
        }
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-aktif   { background: #d1fae5; color: #065f46; }
        .badge-nonaktif { background: #fee2e2; color: #991b1b; }
        .kode-qr {
            font-family: 'DejaVu Sans Mono', monospace;
            font-size: 7.5px;
            color: #555;
            word-break: break-all;
        }
        .footer {
            margin-top: 14px;
            font-size: 8px;
            color: #888;
            text-align: right;
        }
        .summary {
            margin-bottom: 12px;
            font-size: 9px;
            color: #444;
        }
        .summary span { font-weight: 700; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Daftar Sesi QR</h1>
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>

    <div class="summary">
        Total data: <span>{{ $sesiQrs->count() }}</span> sesi QR
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:3%">No</th>
                <th style="width:12%">Kelas</th>
                <th style="width:12%">Mata Pelajaran</th>
                <th style="width:9%">Tanggal</th>
                <th style="width:11%">Berlaku Mulai</th>
                <th style="width:11%">Kadaluarsa</th>
                <th style="width:7%">Radius (m)</th>
                <th style="width:7%">Status</th>
                <th style="width:14%">Dibuat Oleh</th>
                <th style="width:14%">Kode QR</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sesiQrs as $i => $s)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $s->mataPelajaran->nama_mapel ?? '-' }}</td>
                    <td>{{ optional($s->tanggal)->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ optional($s->berlaku_mulai)->format('d/m/Y H:i') ?? '-' }}</td>
                    <td>{{ optional($s->kadaluarsa_pada)->format('d/m/Y H:i') ?? '-' }}</td>
                    <td style="text-align:center">{{ $s->radius_meter ?? '-' }}</td>
                    <td>
                        @if ($s->is_active)
                            <span class="badge badge-aktif">Aktif</span>
                        @else
                            <span class="badge badge-nonaktif">Nonaktif</span>
                        @endif
                    </td>
                    <td>{{ $s->dibuatOleh->name ?? '-' }}</td>
                    <td class="kode-qr">{{ Str::limit($s->kode_qr, 28, '…') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="text-align:center; padding:20px; color:#888;">
                        Tidak ada data sesi QR.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Sistem Absensi QR &mdash; {{ config('app.name', 'Sekolah') }}
    </div>
</body>
</html>