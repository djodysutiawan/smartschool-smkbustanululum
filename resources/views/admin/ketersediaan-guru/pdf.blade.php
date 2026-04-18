<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 9px; color: #1e293b; }
    .header { background: #1f63db; color: #fff; padding: 13px 18px; margin-bottom: 14px; border-radius: 6px; }
    .header h1 { font-size: 15px; font-weight: bold; margin-bottom: 2px; }
    .header p  { font-size: 9px; opacity: .85; }
    .stats { display: table; width: 100%; margin-bottom: 12px; border-spacing: 6px 0; }
    .stat  { display: table-cell; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 8px 12px; text-align: center; }
    .stat-val   { font-size: 17px; font-weight: bold; color: #1f63db; }
    .stat-label { font-size: 8px; color: #64748b; margin-top: 2px; text-transform: uppercase; letter-spacing: .04em; }
    table { width: 100%; border-collapse: collapse; font-size: 8.5px; }
    thead th { background: #1f63db; color: #fff; padding: 7px 8px; text-align: left; font-size: 8px; text-transform: uppercase; letter-spacing: .04em; }
    thead th.center { text-align: center; }
    tbody tr:nth-child(even) { background: #f8fafc; }
    td { padding: 6px 8px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    td.center { text-align: center; }
    .badge { display: inline-block; padding: 2px 8px; border-radius: 99px; font-size: 7.5px; font-weight: bold; }
    .badge-tersedia    { background: #dcfce7; color: #15803d; }
    .badge-nontersedia { background: #fee2e2; color: #dc2626; }
    .hari-pill { display: inline-block; padding: 2px 7px; border-radius: 4px; font-size: 7.5px; font-weight: bold; background: #eef6ff; color: #1f63db; }
    .footer { margin-top: 12px; padding-top: 8px; border-top: 1px solid #e2e8f0; display: table; width: 100%; font-size: 8px; color: #94a3b8; }
    .footer-left  { display: table-cell; }
    .footer-right { display: table-cell; text-align: right; }
</style>
</head>
<body>
<div class="header">
    <h1>🕐 Data Ketersediaan Guru</h1>
    <p>Laporan ketersediaan mengajar guru — dicetak {{ now()->format('d F Y, H:i') }} WIB{{ isset($filterGuru) ? ' | Guru: '.$filterGuru : '' }}</p>
</div>
<div class="stats">
    <div class="stat">
        <div class="stat-val">{{ $ketersediaan->count() }}</div>
        <div class="stat-label">Total Slot</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $ketersediaan->where('tersedia', true)->count() }}</div>
        <div class="stat-label">Tersedia</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $ketersediaan->where('tersedia', false)->count() }}</div>
        <div class="stat-label">Tidak Tersedia</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $ketersediaan->unique('guru_id')->count() }}</div>
        <div class="stat-label">Guru Terdaftar</div>
    </div>
</div>
<table>
    <thead>
        <tr>
            <th style="width:22px" class="center">#</th>
            <th>Nama Guru</th>
            <th class="center" style="width:52px">Hari</th>
            <th class="center" style="width:50px">Jam Mulai</th>
            <th class="center" style="width:55px">Jam Selesai</th>
            <th class="center">Ketersediaan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($ketersediaan as $i => $k)
        <tr>
            <td class="center" style="color:#94a3b8;font-weight:bold">{{ $i + 1 }}</td>
            <td style="font-weight:bold">{{ $k->guru?->nama_lengkap ?? '-' }}</td>
            <td class="center">
                <span class="hari-pill">{{ ucfirst($k->hari) }}</span>
            </td>
            <td class="center" style="font-weight:bold">{{ $k->jam_mulai }}</td>
            <td class="center" style="font-weight:bold">{{ $k->jam_selesai }}</td>
            <td class="center">
                <span class="badge badge-{{ $k->tersedia ? 'tersedia' : 'nontersedia' }}">
                    {{ $k->tersedia ? 'Tersedia' : 'Tidak Tersedia' }}
                </span>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;color:#94a3b8;padding:20px">Tidak ada data</td></tr>
        @endforelse
    </tbody>
</table>
<div class="footer">
    <div class="footer-left">Sistem Informasi Sekolah — Dicetak oleh: {{ auth()->user()->name }}</div>
    <div class="footer-right">{{ now()->format('d/m/Y H:i') }}</div>
</div>
</body>
</html>