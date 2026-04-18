<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 9px; color: #1e293b; }
    .header { background: #1f63db; color: #fff; padding: 14px 20px; margin-bottom: 16px; border-radius: 6px; }
    .header h1 { font-size: 16px; font-weight: bold; margin-bottom: 2px; }
    .header p  { font-size: 9px; opacity: .85; }
    .stats { display: table; width: 100%; margin-bottom: 14px; border-spacing: 6px 0; }
    .stat  { display: table-cell; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 8px 12px; text-align: center; }
    .stat-val   { font-size: 18px; font-weight: bold; color: #1f63db; }
    .stat-label { font-size: 8px; color: #64748b; margin-top: 2px; text-transform: uppercase; letter-spacing: .04em; }
    table { width: 100%; border-collapse: collapse; font-size: 8.5px; }
    thead th { background: #1f63db; color: #fff; padding: 7px 8px; text-align: left; font-size: 8px; text-transform: uppercase; letter-spacing: .04em; }
    thead th.center { text-align: center; }
    tbody tr:nth-child(even) { background: #f8fafc; }
    td { padding: 6px 8px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    td.center { text-align: center; }
    .badge { display: inline-block; padding: 2px 8px; border-radius: 99px; font-size: 7.5px; font-weight: bold; }
    .badge-aktif    { background: #dcfce7; color: #15803d; }
    .badge-nonaktif { background: #fee2e2; color: #dc2626; }
    .footer { margin-top: 14px; padding-top: 8px; border-top: 1px solid #e2e8f0; display: table; width: 100%; font-size: 8px; color: #94a3b8; }
    .footer-left  { display: table-cell; }
    .footer-right { display: table-cell; text-align: right; }
</style>
</head>
<body>
<div class="header">
    <h1>🏢 Data Gedung</h1>
    <p>Laporan data gedung — dicetak {{ now()->format('d F Y, H:i') }} WIB</p>
</div>
<div class="stats">
    <div class="stat">
        <div class="stat-val">{{ $gedung->count() }}</div>
        <div class="stat-label">Total Gedung</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $gedung->where('is_active', true)->count() }}</div>
        <div class="stat-label">Aktif</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $gedung->sum('ruang_count') }}</div>
        <div class="stat-label">Total Ruangan</div>
    </div>
</div>
<table>
    <thead>
        <tr>
            <th style="width:24px" class="center">#</th>
            <th style="width:60px">Kode</th>
            <th>Nama Gedung</th>
            <th class="center">Lantai</th>
            <th class="center">Jml Ruang</th>
            <th class="center">Status</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($gedung as $i => $g)
        <tr>
            <td class="center" style="color:#94a3b8;font-weight:bold">{{ $i + 1 }}</td>
            <td style="font-weight:bold;color:#1f63db">{{ $g->kode_gedung }}</td>
            <td style="font-weight:bold">{{ $g->nama_gedung }}</td>
            <td class="center">{{ $g->jumlah_lantai }}</td>
            <td class="center">{{ $g->ruang_count }}</td>
            <td class="center">
                <span class="badge badge-{{ $g->is_active ? 'aktif' : 'nonaktif' }}">
                    {{ $g->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </td>
            <td style="color:#64748b;font-size:8px">{{ \Illuminate\Support\Str::limit($g->deskripsi ?? '-', 50) }}</td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:20px">Tidak ada data</td></tr>
        @endforelse
    </tbody>
</table>
<div class="footer">
    <div class="footer-left">Sistem Informasi Sekolah — Dicetak oleh: {{ auth()->user()->name }}</div>
    <div class="footer-right">{{ now()->format('d/m/Y H:i') }}</div>
</div>
</body>
</html>