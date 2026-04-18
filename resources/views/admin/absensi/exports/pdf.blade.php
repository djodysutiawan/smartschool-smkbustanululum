<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Absensi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9px;
            color: #1a1a2e;
            background: #fff;
        }
        .header {
            text-align: center;
            padding: 16px 0 10px;
            border-bottom: 2.5px solid #1a1a2e;
            margin-bottom: 12px;
        }
        .header h1 {
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }
        .header .sub { font-size: 9px; color: #555; margin-top: 4px; }

        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #1a1a2e; color: #fff; }
        thead th {
            padding: 6px 7px;
            text-align: left;
            font-size: 8.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        thead th.center { text-align: center; }

        tbody tr:nth-child(even) { background: #f5f6fa; }
        tbody tr:nth-child(odd)  { background: #fff; }
        tbody td {
            padding: 5px 7px;
            border-bottom: 1px solid #e8e8e8;
            font-size: 8.5px;
            vertical-align: middle;
        }
        tbody td.center { text-align: center; }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 9px;
            font-size: 7.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .b-hadir  { background:#d1fae5; color:#065f46; }
        .b-telat  { background:#fef3c7; color:#92400e; }
        .b-izin   { background:#dbeafe; color:#1e40af; }
        .b-sakit  { background:#ede9fe; color:#5b21b6; }
        .b-alfa   { background:#fee2e2; color:#991b1b; }
        .b-manual { background:#f3f4f6; color:#374151; }
        .b-qr     { background:#ecfdf5; color:#065f46; }

        .summary {
            margin-bottom: 12px;
            font-size: 8.5px;
            color: #444;
        }
        .summary span { font-weight: 700; }

        .footer {
            margin-top: 12px;
            font-size: 8px;
            color: #9ca3af;
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Data Absensi</h1>
        <div class="sub">
            {{ config('app.name', 'Sistem Absensi') }} &mdash;
            Dicetak: {{ now()->format('d F Y, H:i') }} WIB
        </div>
    </div>

    <div class="summary">
        Total data: <span>{{ $absensi->count() }}</span> record absensi
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:3%">No</th>
                <th style="width:14%">Nama Siswa</th>
                <th style="width:9%">NIS</th>
                <th style="width:10%">Kelas</th>
                <th style="width:12%">Mata Pelajaran</th>
                <th style="width:9%" class="center">Tanggal</th>
                <th style="width:7%" class="center">Jam Masuk</th>
                <th style="width:7%" class="center">Jam Keluar</th>
                <th style="width:8%" class="center">Status</th>
                <th style="width:7%" class="center">Metode</th>
                <th style="width:14%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($absensi as $i => $a)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $a->siswa->nama_lengkap ?? '-' }}</td>
                    <td>{{ $a->siswa->nis ?? '-' }}</td>
                    <td>{{ $a->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $a->jadwalPelajaran->mataPelajaran->nama_mapel ?? '-' }}</td>
                    <td class="center">{{ \Carbon\Carbon::parse($a->tanggal)->format('d/m/Y') }}</td>
                    <td class="center">{{ $a->jam_masuk  ?? '-' }}</td>
                    <td class="center">{{ $a->jam_keluar ?? '-' }}</td>
                    <td class="center">
                        <span class="badge b-{{ $a->status }}">
                            {{ ucfirst($a->status) }}
                        </span>
                    </td>
                    <td class="center">
                        @if ($a->metode)
                            <span class="badge b-{{ $a->metode }}">
                                {{ strtoupper($a->metode) }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $a->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align:center; padding:20px; color:#9ca3af;">
                        Tidak ada data absensi.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        {{ config('app.name', 'Sistem Absensi QR') }}
    </div>

</body>
</html>