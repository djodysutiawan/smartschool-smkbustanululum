<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Scan QR</title>
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
            letter-spacing: 0.3px;
        }
        .badge-berhasil        { background: #d1fae5; color: #065f46; }
        .badge-gagal_kadaluarsa { background: #fef3c7; color: #92400e; }
        .badge-gagal_lokasi    { background: #fee2e2; color: #991b1b; }
        .badge-gagal_duplikat  { background: #ede9fe; color: #5b21b6; }
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
        <h1>Laporan Riwayat Scan QR</h1>
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>

    <div class="summary">
        Total data: <span>{{ $riwayats->count() }}</span> riwayat scan
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:3%">No</th>
                <th style="width:12%">Siswa</th>
                <th style="width:10%">NIS</th>
                <th style="width:13%">Kelas</th>
                <th style="width:14%">Mata Pelajaran</th>
                <th style="width:14%">Sesi / Tanggal</th>
                <th style="width:10%">Hasil</th>
                <th style="width:14%">Dipindai Pada</th>
                <th style="width:10%">IP Address</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($riwayats as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $r->siswa->nama_lengkap ?? '-' }}</td>
                    <td>{{ $r->siswa->nis ?? '-' }}</td>
                    <td>{{ $r->sesiQr->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $r->sesiQr->mataPelajaran->nama_mapel ?? '-' }}</td>
                    <td>
                        @if ($r->sesiQr)
                            {{ optional($r->sesiQr->tanggal)->format('d/m/Y') ?? '-' }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @php
                            $badgeClass = 'badge-' . $r->hasil;
                            $labelMap = [
                                'berhasil'         => 'Berhasil',
                                'gagal_kadaluarsa' => 'Kadaluarsa',
                                'gagal_lokasi'     => 'Lokasi',
                                'gagal_duplikat'   => 'Duplikat',
                            ];
                        @endphp
                        <span class="badge {{ $badgeClass }}">
                            {{ $labelMap[$r->hasil] ?? $r->hasil }}
                        </span>
                    </td>
                    <td>{{ $r->dipindai_pada ? $r->dipindai_pada->format('d/m/Y H:i:s') : '-' }}</td>
                    <td>{{ $r->ip_address ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding:20px; color:#888;">
                        Tidak ada data riwayat scan.
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