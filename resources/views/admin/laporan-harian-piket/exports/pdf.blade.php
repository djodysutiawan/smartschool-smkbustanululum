{{-- resources/views/admin/laporan-harian-piket/exports/pdf.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Harian Piket</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1a1a2e; background: #fff; }

        .header { text-align: center; border-bottom: 2.5px solid #1a1a2e; padding-bottom: 10px; margin-bottom: 16px; }
        .header h1 { font-size: 15px; font-weight: 700; letter-spacing: 0.5px; }
        .header p  { font-size: 10px; color: #555; margin-top: 2px; }

        .meta { font-size: 10px; color: #555; margin-bottom: 12px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        thead th {
            background: #1a1a2e;
            color: #fff;
            padding: 6px 8px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
        }
        tbody td { padding: 5px 8px; border-bottom: 1px solid #e5e5e5; font-size: 10px; vertical-align: top; }
        tbody tr:nth-child(even) td { background: #f8f8fb; }

        .badge-hadir  { color: #166534; background: #dcfce7; padding: 1px 5px; border-radius: 3px; }
        .badge-izin   { color: #92400e; background: #fef3c7; padding: 1px 5px; border-radius: 3px; }
        .badge-sakit  { color: #0c4a6e; background: #e0f2fe; padding: 1px 5px; border-radius: 3px; }
        .badge-alfa   { color: #991b1b; background: #fee2e2; padding: 1px 5px; border-radius: 3px; }
        .badge-khusus { color: #7c2d12; background: #ffedd5; padding: 1px 5px; border-radius: 3px; }

        .footer { font-size: 9px; color: #999; text-align: center; margin-top: 20px; border-top: 1px solid #e5e5e5; padding-top: 8px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

<div class="header">
    <h1>LAPORAN HARIAN GURU PIKET</h1>
    {{--
        FIX: isoFormat() membutuhkan locale Carbon di-set secara global dan
        tidak selalu reliable di semua environment. Gunakan translatedFormat()
        atau format() biasa untuk keamanan di DomPDF.
    --}}
    <p>SmartSchool SMK Bustanul Ulum &mdash; Dicetak: {{ now()->translatedFormat('l, d F Y, H:i') }}</p>
</div>

<div class="meta">
    Total laporan: {{ $laporan->count() }} data
</div>

<table>
    <thead>
        <tr>
            <th style="width:4%">#</th>
            <th style="width:12%">Tanggal</th>
            <th style="width:15%">Guru Piket</th>
            <th style="width:8%">Check-In</th>
            <th style="width:8%">Check-Out</th>
            <th style="width:18%">Rekap Absensi</th>
            <th style="width:5%">Pelang.</th>
            <th style="width:15%">Catatan Umum</th>
            <th style="width:15%">Kejadian Khusus</th>
        </tr>
    </thead>
    <tbody>
        @forelse($laporan as $i => $item)
            @php
                $r = $item->rekap_absensi ?? [];

                // FIX: Gunakan $logPiketMap yang sudah di-pre-load di controller
                // dengan key "pengguna_id_tanggal", menggantikan query N+1
                // LogPiket::where()->first() yang sebelumnya dipanggil per baris.
                $logKey = $item->dibuat_oleh . '_' . $item->tanggal->toDateString();
                $log    = $logPiketMap->get($logKey);

                // FIX: $item->pelanggaran_count tersedia karena withCount('pelanggaran')
                // sudah ditambahkan di controller exportPdf().
                // Tidak menggunakan $item->jumlah_pelanggaran yang tidak ada di model.
                $jmlPelanggaran = $item->pelanggaran_count ?? 0;
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                <td>{{ $item->dibuatOleh?->name ?? '—' }}</td>

                {{--
                    FIX: masuk_pada & keluar_pada sudah di-cast datetime (Carbon)
                    di model LogPiket, tidak perlu Carbon::parse().
                    Gunakan nullsafe operator.
                --}}
                <td>{{ $log?->masuk_pada ? $log->masuk_pada->format('H:i') : '—' }}</td>
                <td>{{ $log?->keluar_pada ? $log->keluar_pada->format('H:i') : '—' }}</td>

                <td>
                    <span class="badge-hadir">H:{{ $r['hadir'] ?? 0 }}</span>
                    <span class="badge-izin">I:{{ $r['izin'] ?? 0 }}</span>
                    <span class="badge-sakit">S:{{ $r['sakit'] ?? 0 }}</span>
                    <span class="badge-alfa">A:{{ $r['alfa'] ?? 0 }}</span>
                </td>

                {{-- FIX: gunakan pelanggaran_count, bukan jumlah_pelanggaran --}}
                <td style="text-align:center;">{{ $jmlPelanggaran }}</td>

                <td>{{ Str::limit($item->catatan_umum ?? '—', 80) }}</td>
                <td>
                    @if($item->kejadian_khusus)
                        <span class="badge-khusus">{{ Str::limit($item->kejadian_khusus, 80) }}</span>
                    @else
                        —
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" style="text-align:center;color:#999;padding:20px;">
                    Tidak ada data laporan
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    SmartSchool SMK Bustanul Ulum &bull; Laporan Harian Piket &bull; {{ now()->format('d/m/Y H:i') }}
</div>

</body>
</html>