<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 8.5px; color: #1e293b; }
    .header { background: #1f63db; color: #fff; padding: 14px 20px; margin-bottom: 14px; border-radius: 6px; }
    .header h1 { font-size: 15px; font-weight: bold; margin-bottom: 2px; }
    .header p  { font-size: 9px; opacity: .85; }
    .stats { display: table; width: 100%; margin-bottom: 12px; border-spacing: 6px 0; }
    .stat  { display: table-cell; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 8px 12px; text-align: center; }
    .stat-val   { font-size: 17px; font-weight: bold; color: #1f63db; }
    .stat-label { font-size: 7.5px; color: #64748b; margin-top: 2px; text-transform: uppercase; letter-spacing: .04em; }
    table { width: 100%; border-collapse: collapse; font-size: 8px; }
    thead th { background: #1f63db; color: #fff; padding: 6px 7px; text-align: left; font-size: 7.5px; text-transform: uppercase; letter-spacing: .04em; }
    thead th.center { text-align: center; }
    tbody tr:nth-child(even) { background: #f8fafc; }
    td { padding: 5px 7px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    td.center { text-align: center; }
    .badge { display: inline-block; padding: 1px 6px; border-radius: 99px; font-size: 7px; font-weight: bold; }
    .badge-tersedia      { background: #dcfce7; color: #15803d; }
    .badge-tidak-tersedia { background: #fee2e2; color: #dc2626; }
    .badge-perbaikan     { background: #fef9c3; color: #a16207; }
    .check { color: #15803d; font-weight: bold; }
    .cross { color: #94a3b8; }
    .footer { margin-top: 12px; padding-top: 8px; border-top: 1px solid #e2e8f0; display: table; width: 100%; font-size: 8px; color: #94a3b8; }
    .footer-left  { display: table-cell; }
    .footer-right { display: table-cell; text-align: right; }
</style>
</head>
<body>
<div class="header">
    <h1>🚪 Data Ruangan</h1>
    <p>Laporan data ruangan — dicetak {{ now()->format('d F Y, H:i') }} WIB{{ $filterLabel ? ' | Filter: '.$filterLabel : '' }}</p>
</div>
<div class="stats">
    <div class="stat">
        <div class="stat-val">{{ $ruang->count() }}</div>
        <div class="stat-label">Total Ruang</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $ruang->where('status','tersedia')->count() }}</div>
        <div class="stat-label">Tersedia</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $ruang->where('status','tidak_tersedia')->count() }}</div>
        <div class="stat-label">Tidak Tersedia</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $ruang->where('status','perbaikan')->count() }}</div>
        <div class="stat-label">Perbaikan</div>
    </div>
</div>
<table>
    <thead>
        <tr>
            <th style="width:20px" class="center">#</th>
            <th style="width:55px">Kode</th>
            <th>Nama Ruang</th>
            <th style="width:55px">Gedung</th>
            <th class="center" style="width:30px">Lt</th>
            <th>Jenis</th>
            <th class="center" style="width:40px">Kap.</th>
            <th class="center" style="width:20px">PR</th>
            <th class="center" style="width:20px">AC</th>
            <th class="center" style="width:20px">WF</th>
            <th class="center" style="width:20px">PC</th>
            <th class="center">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($ruang as $i => $r)
        <tr>
            <td class="center" style="color:#94a3b8;font-weight:bold">{{ $i + 1 }}</td>
            <td style="font-weight:bold;color:#1f63db">{{ $r->kode_ruang }}</td>
            <td style="font-weight:bold">{{ $r->nama_ruang }}</td>
            <td style="color:#64748b">{{ $r->gedung?->kode_gedung ?? '-' }}</td>
            <td class="center">{{ $r->lantai }}</td>
            <td style="font-size:7.5px">{{ ucfirst(str_replace('_',' ',$r->jenis_ruang)) }}</td>
            <td class="center">{{ $r->kapasitas }}</td>
            <td class="center"><span class="{{ $r->ada_proyektor ? 'check' : 'cross' }}">{{ $r->ada_proyektor ? '✓' : '—' }}</span></td>
            <td class="center"><span class="{{ $r->ada_ac ? 'check' : 'cross' }}">{{ $r->ada_ac ? '✓' : '—' }}</span></td>
            <td class="center"><span class="{{ $r->ada_wifi ? 'check' : 'cross' }}">{{ $r->ada_wifi ? '✓' : '—' }}</span></td>
            <td class="center"><span class="{{ $r->ada_komputer ? 'check' : 'cross' }}">{{ $r->ada_komputer ? '✓' : '—' }}</span></td>
            <td class="center">
                @php $stClass = $r->status === 'tersedia' ? 'tersedia' : ($r->status === 'perbaikan' ? 'perbaikan' : 'tidak-tersedia'); @endphp
                <span class="badge badge-{{ $stClass }}">{{ ucfirst(str_replace('_',' ',$r->status)) }}</span>
            </td>
        </tr>
        @empty
        <tr><td colspan="12" style="text-align:center;color:#94a3b8;padding:20px">Tidak ada data</td></tr>
        @endforelse
    </tbody>
</table>
<div class="footer">
    <div class="footer-left">Sistem Informasi Sekolah — Dicetak oleh: {{ auth()->user()->name }}</div>
    <div class="footer-right">PR=Proyektor, AC=AC, WF=WiFi, PC=Komputer | {{ now()->format('d/m/Y H:i') }}</div>
</div>
</body>
</html>