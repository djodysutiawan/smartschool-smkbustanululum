{{--
    resources/views/admin/pengumuman/export-pdf.blade.php
    Safe: semua tanggal di-parse manual via Carbon::parse() agar tidak error
    meski kolom terbaca sebagai string.
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export Pengumuman</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #0f766e;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }
        .header h1 { font-size: 15px; font-weight: bold; color: #0f766e; }
        .header p  { font-size: 10px; color: #6b7280; margin-top: 2px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }

        thead tr { background-color: #0f766e; color: #fff; }
        thead th {
            padding: 7px 8px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
            white-space: nowrap;
        }

        tbody tr { border-bottom: 1px solid #e5e7eb; }
        tbody tr:nth-child(even) { background-color: #f0fdf9; }
        tbody td { padding: 6px 8px; font-size: 10px; vertical-align: top; }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-published  { background-color: #d1fae5; color: #065f46; }
        .badge-draft      { background-color: #fef3c7; color: #92400e; }
        .badge-pinned     { background-color: #dbeafe; color: #1e40af; }
        .badge-semua      { background-color: #f3e8ff; color: #6b21a8; }
        .badge-guru       { background-color: #dbeafe; color: #1e40af; }
        .badge-siswa      { background-color: #dcfce7; color: #166534; }
        .badge-orang_tua  { background-color: #fce7f3; color: #9d174d; }
        .badge-guru_piket { background-color: #ffedd5; color: #9a3412; }

        .no-data { text-align: center; padding: 30px; color: #9ca3af; font-style: italic; }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <h1>Laporan Pengumuman</h1>
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }} WIB</p>
    </div>

    {{-- META --}}
    <table style="margin-bottom:12px; font-size:10px; color:#6b7280;">
        <tr>
            <td>Total: <strong>{{ $pengumuman->count() }}</strong> pengumuman</td>
            <td style="text-align:right">
                Dipublikasikan: <strong>{{ $pengumuman->filter(fn($p) => !empty($p->dipublikasikan_pada))->count() }}</strong>
                &nbsp;|&nbsp;
                Draft: <strong>{{ $pengumuman->filter(fn($p) => empty($p->dipublikasikan_pada))->count() }}</strong>
            </td>
        </tr>
    </table>

    {{-- TABLE --}}
    @if ($pengumuman->isEmpty())
        <p class="no-data">Tidak ada data pengumuman yang sesuai filter.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width:3%">No</th>
                    <th style="width:28%">Judul</th>
                    <th style="width:11%">Target</th>
                    <th style="width:9%">Status</th>
                    <th style="width:6%">Pinned</th>
                    <th style="width:13%">Dibuat Oleh</th>
                    <th style="width:15%">Dipublikasikan</th>
                    <th style="width:15%">Kadaluarsa</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengumuman as $i => $item)
                    @php
                        $targetLabel = match($item->target_role) {
                            'semua'      => 'Semua',
                            'guru'       => 'Guru',
                            'siswa'      => 'Siswa',
                            'orang_tua'  => 'Orang Tua',
                            'guru_piket' => 'Guru Piket',
                            default      => ucfirst($item->target_role),
                        };

                        // Safe date: Carbon::parse() handle string & Carbon object sekaligus.
                        // empty() mencegah parse('') yang bisa menghasilkan tanggal epoch.
                        $tglPublish = !empty($item->dipublikasikan_pada)
                            ? \Carbon\Carbon::parse($item->dipublikasikan_pada)->format('d/m/Y H:i')
                            : '-';

                        $tglKadaluarsa = !empty($item->kadaluarsa_pada)
                            ? \Carbon\Carbon::parse($item->kadaluarsa_pada)->format('d/m/Y H:i')
                            : '-';
                    @endphp
                    <tr>
                        <td style="text-align:center">{{ $i + 1 }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>
                            <span class="badge badge-{{ $item->target_role }}">
                                {{ $targetLabel }}
                            </span>
                        </td>
                        <td>
                            @if (!empty($item->dipublikasikan_pada))
                                <span class="badge badge-published">Publik</span>
                            @else
                                <span class="badge badge-draft">Draft</span>
                            @endif
                        </td>
                        <td style="text-align:center">
                            @if ($item->dipinned)
                                <span class="badge badge-pinned">Ya</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $item->dibuatOleh?->name ?? '-' }}</td>
                        <td>{{ $tglPublish }}</td>
                        <td>{{ $tglKadaluarsa }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- FOOTER --}}
    <table style="border-top:1px solid #e5e7eb; padding-top:6px; font-size:9px; color:#9ca3af;">
        <tr>
            <td>SmartSchool &mdash; Sistem Informasi Sekolah</td>
            <td style="text-align:right">Dicetak: {{ now()->format('d/m/Y H:i') }}</td>
        </tr>
    </table>

</body>
</html>