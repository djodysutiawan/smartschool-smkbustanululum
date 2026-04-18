<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 9px; color: #1e293b; }
    .header { background: #1f63db; color: #fff; padding: 14px 20px; margin-bottom: 14px; border-radius: 6px; }
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
    .badge { display: inline-block; padding: 2px 7px; border-radius: 99px; font-size: 7.5px; font-weight: bold; }
    .badge-aktif       { background: #dcfce7; color: #15803d; }
    .badge-nonaktif    { background: #fee2e2; color: #dc2626; }
    .badge-normatif    { background: #eef6ff; color: #1f63db; }
    .badge-adaptif     { background: #fdf4ff; color: #7c3aed; }
    .badge-produktif   { background: #f0fdf4; color: #15803d; }
    .badge-muatan      { background: #fef9c3; color: #a16207; }
    .badge-pengembangan{ background: #fff7ed; color: #c2410c; }
    .footer { margin-top: 12px; padding-top: 8px; border-top: 1px solid #e2e8f0; display: table; width: 100%; font-size: 8px; color: #94a3b8; }
    .footer-left  { display: table-cell; }
    .footer-right { display: table-cell; text-align: right; }
</style>
</head>
<body>
<div class="header">
    <h1>📚 Data Mata Pelajaran</h1>
    <p>Laporan data mata pelajaran — dicetak {{ now()->format('d F Y, H:i') }} WIB{{ $filterLabel ? ' | Filter: '.$filterLabel : '' }}</p>
</div>
<div class="stats">
    <div class="stat">
        <div class="stat-val">{{ $mapel->count() }}</div>
        <div class="stat-label">Total Mapel</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $mapel->where('is_active', true)->count() }}</div>
        <div class="stat-label">Aktif</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $mapel->where('perlu_lab', true)->count() }}</div>
        <div class="stat-label">Perlu Lab</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $mapel->sum('jadwal_pelajaran_count') }}</div>
        <div class="stat-label">Total Jadwal</div>
    </div>
</div>
<table>
    <thead>
        <tr>
            <th style="width:22px" class="center">#</th>
            <th style="width:55px">Kode</th>
            <th>Nama Mata Pelajaran</th>
            <th class="center">Kelompok</th>
            <th class="center" style="width:50px">Jam/Mgg</th>
            <th class="center" style="width:55px">Durasi (mnt)</th>
            <th class="center" style="width:35px">Lab</th>
            <th class="center" style="width:45px">Jadwal</th>
            <th class="center">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($mapel as $i => $m)
        @php
            $kelompokMap = [
                'normatif' => 'badge-normatif', 'adaptif' => 'badge-adaptif',
                'produktif' => 'badge-produktif', 'muatan_lokal' => 'badge-muatan',
                'pengembangan_diri' => 'badge-pengembangan',
            ];
            $kelompokClass = $kelompokMap[$m->kelompok ?? ''] ?? 'badge-nonaktif';
        @endphp
        <tr>
            <td class="center" style="color:#94a3b8;font-weight:bold">{{ $i + 1 }}</td>
            <td style="font-weight:bold;color:#1f63db">{{ $m->kode_mapel }}</td>
            <td style="font-weight:bold">{{ $m->nama_mapel }}</td>
            <td class="center">
                @if($m->kelompok)
                    <span class="badge {{ $kelompokClass }}">{{ ucfirst(str_replace('_',' ',$m->kelompok)) }}</span>
                @else
                    <span style="color:#94a3b8">—</span>
                @endif
            </td>
            <td class="center">{{ $m->jam_per_minggu }}</td>
            <td class="center">{{ $m->durasi_per_sesi }}</td>
            <td class="center" style="color:{{ $m->perlu_lab ? '#15803d' : '#94a3b8' }};font-weight:bold">
                {{ $m->perlu_lab ? '✓' : '—' }}
            </td>
            <td class="center">{{ $m->jadwal_pelajaran_count }}</td>
            <td class="center">
                <span class="badge badge-{{ $m->is_active ? 'aktif' : 'nonaktif' }}">
                    {{ $m->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </td>
        </tr>
        @empty
        <tr><td colspan="9" style="text-align:center;color:#94a3b8;padding:20px">Tidak ada data</td></tr>
        @endforelse
    </tbody>
</table>
<div class="footer">
    <div class="footer-left">Sistem Informasi Sekolah — Dicetak oleh: {{ auth()->user()->name }}</div>
    <div class="footer-right">{{ now()->format('d/m/Y H:i') }}</div>
</div>
</body>
</html>