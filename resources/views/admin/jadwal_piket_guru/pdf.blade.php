<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Piket Guru</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 11px; color: #0f172a; background: #fff; }
        .header { background: #1f63db; color: #fff; padding: 20px 28px; margin-bottom: 24px; }
        .header-top { display: flex; justify-content: space-between; align-items: flex-start; }
        .school-name { font-size: 16px; font-weight: 700; margin-bottom: 2px; }
        .doc-title { font-size: 13px; opacity: .85; }
        .doc-meta { text-align: right; font-size: 10.5px; opacity: .8; }
        .body { padding: 0 28px 28px; }
        .section-title { font-size: 13px; font-weight: 700; color: #1f63db; border-bottom: 2px solid #1f63db; padding-bottom: 6px; margin-bottom: 14px; }
        .stats-row { display: flex; gap: 12px; margin-bottom: 20px; }
        .stat-box { flex: 1; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 14px; }
        .stat-label { font-size: 9.5px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .04em; }
        .stat-val { font-size: 20px; font-weight: 800; color: #0f172a; margin-top: 2px; }
        table { width: 100%; border-collapse: collapse; font-size: 10.5px; }
        thead tr { background: #1f63db; color: #fff; }
        thead th { padding: 9px 10px; text-align: left; font-weight: 700; font-size: 10px; text-transform: uppercase; letter-spacing: .04em; }
        thead th.center { text-align: center; }
        tbody tr { border-bottom: 1px solid #f1f5f9; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        td { padding: 8px 10px; vertical-align: middle; }
        td.center { text-align: center; }
        .hari-badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-weight: 700; font-size: 10px; }
        .hari-senin { background: #eff6ff; color: #1d4ed8; }
        .hari-selasa { background: #f0fdf4; color: #15803d; }
        .hari-rabu { background: #fefce8; color: #a16207; }
        .hari-kamis { background: #fff7ed; color: #c2410c; }
        .hari-jumat { background: #fdf4ff; color: #7c3aed; }
        .hari-sabtu { background: #f0f9ff; color: #0369a1; }
        .badge-aktif { display: inline-block; padding: 2px 8px; border-radius: 99px; background: #dcfce7; color: #15803d; font-weight: 700; font-size: 9.5px; }
        .badge-nonaktif { display: inline-block; padding: 2px 8px; border-radius: 99px; background: #fee2e2; color: #dc2626; font-weight: 700; font-size: 9.5px; }
        .footer { margin-top: 28px; padding-top: 12px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; font-size: 9.5px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-top">
            <div>
                <p class="school-name">Jadwal Piket Guru</p>
                <p class="doc-title">Daftar Jadwal Rotasi Piket Guru</p>
            </div>
            <div class="doc-meta">
                <p>Dicetak: {{ now()->format('d M Y, H:i') }}</p>
                <p>Total Data: {{ $jadwal->count() }} jadwal</p>
            </div>
        </div>
    </div>

    <div class="body">
        <div class="stats-row">
            <div class="stat-box">
                <p class="stat-label">Total Jadwal</p>
                <p class="stat-val">{{ $jadwal->count() }}</p>
            </div>
            <div class="stat-box">
                <p class="stat-label">Aktif</p>
                <p class="stat-val">{{ $jadwal->where('is_active', true)->count() }}</p>
            </div>
            <div class="stat-box">
                <p class="stat-label">Nonaktif</p>
                <p class="stat-val">{{ $jadwal->where('is_active', false)->count() }}</p>
            </div>
        </div>

        <p class="section-title">Daftar Jadwal Piket</p>
        <table>
            <thead>
                <tr>
                    <th style="width:36px">#</th>
                    <th>Hari</th>
                    <th>Jam Piket</th>
                    <th>Guru Piket</th>
                    <th>NIP</th>
                    <th>Tahun Ajaran</th>
                    <th class="center">Status</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwal as $index => $j)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><span class="hari-badge hari-{{ $j->hari }}">{{ ucfirst($j->hari) }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</td>
                    <td style="font-weight:700">{{ $j->guru->nama_lengkap ?? '-' }}</td>
                    <td style="color:#64748b">{{ $j->guru->nip ?? '-' }}</td>
                    <td>{{ $j->tahunAjaran->tahun ?? '-' }}</td>
                    <td class="center">
                        @if($j->is_active)
                            <span class="badge-aktif">Aktif</span>
                        @else
                            <span class="badge-nonaktif">Nonaktif</span>
                        @endif
                    </td>
                    <td style="color:#64748b;max-width:120px">{{ $j->catatan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:20px;color:#94a3b8">Tidak ada data jadwal piket</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            <span>Dokumen ini digenerate secara otomatis oleh sistem</span>
            <span>{{ now()->format('d M Y, H:i:s') }}</span>
        </div>
    </div>
</body>
</html>