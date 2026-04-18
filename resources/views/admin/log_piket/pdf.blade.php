<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Piket Guru</title>
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
        .badge-masuk { display: inline-block; padding: 2px 8px; border-radius: 99px; background: #dcfce7; color: #15803d; font-weight: 700; font-size: 9.5px; }
        .badge-selesai { display: inline-block; padding: 2px 8px; border-radius: 99px; background: #eef6ff; color: #1750c0; font-weight: 700; font-size: 9.5px; }
        .badge-belum { display: inline-block; padding: 2px 8px; border-radius: 99px; background: #f1f5f9; color: #64748b; font-weight: 700; font-size: 9.5px; }
        .badge-pagi { display: inline-block; padding: 2px 8px; border-radius: 4px; background: #fff7ed; color: #c2410c; font-weight: 700; font-size: 9.5px; }
        .badge-siang { display: inline-block; padding: 2px 8px; border-radius: 4px; background: #fefce8; color: #a16207; font-weight: 700; font-size: 9.5px; }
        .footer { margin-top: 28px; padding-top: 12px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; font-size: 9.5px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-top">
            <div>
                <p class="school-name">Log Piket Guru</p>
                <p class="doc-title">Catatan Check-In / Check-Out Guru Piket</p>
            </div>
            <div class="doc-meta">
                <p>Dicetak: {{ now()->format('d M Y, H:i') }}</p>
                <p>Total Data: {{ $logs->count() }} log</p>
            </div>
        </div>
    </div>

    <div class="body">
        <div class="stats-row">
            <div class="stat-box">
                <p class="stat-label">Total Log</p>
                <p class="stat-val">{{ $logs->count() }}</p>
            </div>
            <div class="stat-box">
                <p class="stat-label">Selesai</p>
                <p class="stat-val">{{ $logs->filter(fn($l) => $l->keluar_pada)->count() }}</p>
            </div>
            <div class="stat-box">
                <p class="stat-label">Bertugas</p>
                <p class="stat-val">{{ $logs->filter(fn($l) => $l->masuk_pada && !$l->keluar_pada)->count() }}</p>
            </div>
            <div class="stat-box">
                <p class="stat-label">Belum Masuk</p>
                <p class="stat-val">{{ $logs->filter(fn($l) => !$l->masuk_pada)->count() }}</p>
            </div>
        </div>

        <p class="section-title">Daftar Log Piket</p>
        <table>
            <thead>
                <tr>
                    <th style="width:36px">#</th>
                    <th>Guru Piket</th>
                    <th>Tanggal</th>
                    <th class="center">Shift</th>
                    <th class="center">Masuk</th>
                    <th class="center">Keluar</th>
                    <th class="center">Durasi</th>
                    <th class="center">Status</th>
                    <th>Dicatat Oleh</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $index => $log)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div style="font-weight:700">{{ $log->guru->nama_lengkap ?? '-' }}</div>
                        <div style="color:#64748b;font-size:9px">{{ $log->guru->nip ?? '' }}</div>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($log->tanggal)->format('d M Y') }}</td>
                    <td class="center">
                        @if($log->shift == 'pagi')
                            <span class="badge-pagi">Pagi</span>
                        @elseif($log->shift == 'siang')
                            <span class="badge-siang">Siang</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="center" style="font-weight:600">{{ $log->masuk_pada ? \Carbon\Carbon::parse($log->masuk_pada)->format('H:i') : '—' }}</td>
                    <td class="center" style="font-weight:600">{{ $log->keluar_pada ? \Carbon\Carbon::parse($log->keluar_pada)->format('H:i') : '—' }}</td>
                    <td class="center">
                        @if($log->masuk_pada && $log->keluar_pada)
                            @php $durasi = \Carbon\Carbon::parse($log->masuk_pada)->diff(\Carbon\Carbon::parse($log->keluar_pada)); @endphp
                            {{ $durasi->h }}j {{ $durasi->i }}m
                        @else
                            —
                        @endif
                    </td>
                    <td class="center">
                        @if($log->keluar_pada)
                            <span class="badge-selesai">Selesai</span>
                        @elseif($log->masuk_pada)
                            <span class="badge-masuk">Bertugas</span>
                        @else
                            <span class="badge-belum">Belum Masuk</span>
                        @endif
                    </td>
                    <td style="color:#64748b">{{ $log->pengguna->name ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:20px;color:#94a3b8">Tidak ada data log piket</td>
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