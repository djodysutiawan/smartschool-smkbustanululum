<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi – {{ $kelas->nama_kelas }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9px;
            color: #1a1a2e;
            background: #fff;
        }

        /* ── Header ── */
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
        .header .sub {
            font-size: 9px;
            color: #555;
            margin-top: 4px;
        }

        /* ── Meta info ── */
        .meta {
            display: table;
            width: 100%;
            margin-bottom: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 3px;
            background: #f9fafb;
        }
        .meta-row { display: table-row; }
        .meta-cell {
            display: table-cell;
            padding: 5px 10px;
            font-size: 8.5px;
            vertical-align: middle;
            border-right: 1px solid #e5e7eb;
        }
        .meta-cell:last-child { border-right: none; }
        .meta-cell .label {
            color: #6b7280;
            font-size: 7.5px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            display: block;
            margin-bottom: 1px;
        }
        .meta-cell .value { font-weight: 700; }

        /* ── Legend / keterangan status ── */
        .legend {
            margin-bottom: 10px;
            font-size: 8px;
        }
        .legend span {
            display: inline-block;
            margin-right: 10px;
        }
        .dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 3px;
            vertical-align: middle;
        }
        .dot-hadir  { background: #10b981; }
        .dot-telat  { background: #f59e0b; }
        .dot-izin   { background: #3b82f6; }
        .dot-sakit  { background: #8b5cf6; }
        .dot-alfa   { background: #ef4444; }
        .dot-kosong { background: #d1d5db; }

        /* ── Tabel ── */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead tr {
            background: #1a1a2e;
            color: #fff;
        }
        thead th {
            padding: 5px 4px;
            text-align: center;
            font-size: 8px;
            font-weight: 600;
        }
        thead th.th-nama {
            text-align: left;
            padding-left: 6px;
            width: 16%;
        }
        thead th.th-nis {
            text-align: left;
            width: 9%;
        }

        /* Sub-header baris hari/tanggal */
        .th-date {
            font-size: 6.5px;
            font-weight: 400;
            opacity: 0.8;
            display: block;
        }

        tbody tr:nth-child(even) { background: #f5f6fa; }
        tbody tr:nth-child(odd)  { background: #fff; }
        tbody td {
            padding: 4px 3px;
            text-align: center;
            border-bottom: 1px solid #eee;
            border-right: 1px solid #eee;
            font-size: 8px;
            vertical-align: middle;
        }
        tbody td.td-nama {
            text-align: left;
            padding-left: 6px;
            font-size: 8.5px;
            border-right: 2px solid #d1d5db;
        }
        tbody td.td-nis {
            text-align: left;
            font-size: 7.5px;
            color: #6b7280;
            border-right: 2px solid #d1d5db;
        }
        tbody td.td-total {
            font-weight: 700;
            background: #f0f4ff;
            border-left: 2px solid #c7d2fe;
            font-size: 8px;
        }

        /* Status cells */
        .s { display: inline-block; width: 14px; height: 14px; border-radius: 2px; line-height: 14px; font-size: 7.5px; font-weight: 700; }
        .s-H { background: #d1fae5; color: #065f46; }
        .s-T { background: #fef3c7; color: #92400e; }
        .s-I { background: #dbeafe; color: #1e40af; }
        .s-S { background: #ede9fe; color: #5b21b6; }
        .s-A { background: #fee2e2; color: #991b1b; }
        .s-  { background: #f3f4f6; color: #9ca3af; }

        /* Kolom total di footer */
        tfoot tr { background: #1a1a2e; color: #fff; }
        tfoot td {
            padding: 5px 3px;
            text-align: center;
            font-size: 7.5px;
            font-weight: 600;
            border-right: 1px solid rgba(255,255,255,0.15);
        }
        tfoot td.td-foot-label {
            text-align: left;
            padding-left: 6px;
            font-size: 8px;
        }

        /* ── Footer halaman ── */
        .footer {
            margin-top: 12px;
            font-size: 7.5px;
            color: #9ca3af;
            display: table;
            width: 100%;
        }
        .footer-left  { display: table-cell; text-align: left; }
        .footer-right { display: table-cell; text-align: right; }
    </style>
</head>
<body>

    {{-- ── Header ── --}}
    <div class="header">
        <h1>Rekap Absensi Siswa</h1>
        <div class="sub">
            {{ config('app.name', 'Sistem Absensi') }} &mdash;
            Dicetak: {{ now()->format('d F Y, H:i') }} WIB
        </div>
    </div>

    {{-- ── Meta info ── --}}
    <div class="meta">
        <div class="meta-row">
            <div class="meta-cell">
                <span class="label">Kelas</span>
                <span class="value">{{ $kelas->nama_kelas }}</span>
            </div>
            <div class="meta-cell">
                <span class="label">Periode</span>
                <span class="value">
                    {{ \Carbon\Carbon::parse($request->tanggal_dari)->format('d M Y') }}
                    s/d
                    {{ \Carbon\Carbon::parse($request->tanggal_sampai)->format('d M Y') }}
                </span>
            </div>
            <div class="meta-cell">
                <span class="label">Total Siswa</span>
                <span class="value">{{ $absensi->count() }} siswa</span>
            </div>
        </div>
    </div>

    {{-- ── Legend ── --}}
    <div class="legend">
        <span><span class="dot dot-hadir"></span>H = Hadir</span>
        <span><span class="dot dot-telat"></span>T = Telat</span>
        <span><span class="dot dot-izin"></span>I = Izin</span>
        <span><span class="dot dot-sakit"></span>S = Sakit</span>
        <span><span class="dot dot-alfa"></span>A = Alfa</span>
        <span><span class="dot dot-kosong"></span>&ndash; = Tidak ada data</span>
    </div>

    {{-- ── Tabel rekap ── --}}
    @php
        // Kumpulkan semua tanggal unik dalam range
        $dari    = \Carbon\Carbon::parse($request->tanggal_dari);
        $sampai  = \Carbon\Carbon::parse($request->tanggal_sampai);
        $dates   = [];
        for ($d = $dari->copy(); $d->lte($sampai); $d->addDay()) {
            $dates[] = $d->format('Y-m-d');
        }

        // Flatten semua absensi per siswa per tanggal
        // $absensi sudah di-groupBy('siswa_id') di controller
        $statusMap = ['hadir' => 'H', 'telat' => 'T', 'izin' => 'I', 'sakit' => 'S', 'alfa' => 'A'];
        $cssMap    = ['H' => 's-H', 'T' => 's-T', 'I' => 's-I', 'S' => 's-S', 'A' => 's-A', '' => 's-'];

        // Hitung total per tanggal (footer)
        $totalPerTanggal = [];
        foreach ($dates as $date) { $totalPerTanggal[$date] = ['H'=>0,'T'=>0,'I'=>0,'S'=>0,'A'=>0]; }
    @endphp

    <table>
        <thead>
            <tr>
                <th class="th-nama">Nama Siswa</th>
                <th class="th-nis">NIS</th>
                @foreach ($dates as $date)
                    <th>
                        {{ \Carbon\Carbon::parse($date)->format('d') }}
                        <span class="th-date">{{ \Carbon\Carbon::parse($date)->isoFormat('ddd') }}</span>
                    </th>
                @endforeach
                <th style="background:#16213e; width:24px;">H</th>
                <th style="background:#16213e; width:24px;">T</th>
                <th style="background:#16213e; width:24px;">I</th>
                <th style="background:#16213e; width:24px;">S</th>
                <th style="background:#b91c1c; width:24px;">A</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($absensi as $siswaId => $records)
                @php
                    $siswa  = $records->first()->siswa;

                    // Index: tanggal => status
                    $byDate = $records->keyBy(fn($r) => \Carbon\Carbon::parse($r->tanggal)->format('Y-m-d'));

                    // Hitung total per siswa
                    $tot = ['H'=>0,'T'=>0,'I'=>0,'S'=>0,'A'=>0];
                @endphp
                <tr>
                    <td class="td-nama">{{ $siswa->nama_lengkap ?? '-' }}</td>
                    <td class="td-nis">{{ $siswa->nis ?? '-' }}</td>

                    @foreach ($dates as $date)
                        @php
                            $rec    = $byDate[$date] ?? null;
                            $raw    = $rec ? ($statusMap[$rec->status] ?? '') : '';
                            $css    = $cssMap[$raw] ?? 's-';
                            if ($raw) {
                                $tot[$raw]++;
                                $totalPerTanggal[$date][$raw]++;
                            }
                        @endphp
                        <td>
                            <span class="s {{ $css }}">{{ $raw ?: '–' }}</span>
                        </td>
                    @endforeach

                    {{-- Total per siswa --}}
                    <td class="td-total" style="color:#065f46">{{ $tot['H'] }}</td>
                    <td class="td-total" style="color:#92400e">{{ $tot['T'] }}</td>
                    <td class="td-total" style="color:#1e40af">{{ $tot['I'] }}</td>
                    <td class="td-total" style="color:#5b21b6">{{ $tot['S'] }}</td>
                    <td class="td-total" style="color:#991b1b">{{ $tot['A'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($dates) + 7 }}" style="text-align:center; padding:20px; color:#9ca3af;">
                        Tidak ada data absensi untuk periode yang dipilih.
                    </td>
                </tr>
            @endforelse
        </tbody>

        @if ($absensi->count() > 0)
        <tfoot>
            <tr>
                <td class="td-foot-label" colspan="2">Total / Hari</td>
                @foreach ($dates as $date)
                    <td style="font-size:6.5px; line-height:1.3">
                        H:{{ $totalPerTanggal[$date]['H'] }}<br>
                        A:{{ $totalPerTanggal[$date]['A'] }}
                    </td>
                @endforeach
                <td colspan="5">&mdash;</td>
            </tr>
        </tfoot>
        @endif
    </table>

    {{-- ── Footer halaman ── --}}
    <div class="footer">
        <div class="footer-left">{{ config('app.name', 'Sistem Absensi QR') }}</div>
        <div class="footer-right">Kelas {{ $kelas->nama_kelas }} &mdash; {{ $dari->format('d/m/Y') }} s/d {{ $sampai->format('d/m/Y') }}</div>
    </div>

</body>
</html>