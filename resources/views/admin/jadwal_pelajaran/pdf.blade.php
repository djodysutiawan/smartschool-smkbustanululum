<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 8px; color: #1e293b; }
    .header { background: #1f63db; color: #fff; padding: 12px 18px; margin-bottom: 12px; border-radius: 6px; }
    .header h1 { font-size: 14px; font-weight: bold; margin-bottom: 2px; }
    .header p  { font-size: 8.5px; opacity: .85; }
    .stats { display: table; width: 100%; margin-bottom: 10px; border-spacing: 5px 0; }
    .stat  { display: table-cell; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 7px 10px; text-align: center; }
    .stat-val   { font-size: 16px; font-weight: bold; color: #1f63db; }
    .stat-label { font-size: 7.5px; color: #64748b; margin-top: 2px; text-transform: uppercase; letter-spacing: .04em; }
    table { width: 100%; border-collapse: collapse; font-size: 7.5px; }
    thead th { background: #1f63db; color: #fff; padding: 6px 7px; text-align: left; font-size: 7px; text-transform: uppercase; letter-spacing: .04em; }
    thead th.center { text-align: center; }
    tbody tr:nth-child(even) { background: #f8fafc; }
    td { padding: 5px 7px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    td.center { text-align: center; }
    .badge { display: inline-block; padding: 1px 6px; border-radius: 99px; font-size: 7px; font-weight: bold; }
    .badge-aktif    { background: #dcfce7; color: #15803d; }
    .badge-nonaktif { background: #fee2e2; color: #dc2626; }
    .hari-pill { display: inline-block; padding: 1px 6px; border-radius: 4px; font-size: 7px; font-weight: bold; background: #eef6ff; color: #1f63db; }
    .footer { margin-top: 10px; padding-top: 6px; border-top: 1px solid #e2e8f0; display: table; width: 100%; font-size: 7.5px; color: #94a3b8; }
    .footer-left  { display: table-cell; }
    .footer-right { display: table-cell; text-align: right; }
</style>
</head>
<body>
<div class="header">
    <h1>📋 Data Jadwal Pelajaran</h1>
    <p>Laporan jadwal pelajaran — dicetak {{ now()->format('d F Y, H:i') }} WIB{{ $filterLabel ? ' | Filter: '.$filterLabel : '' }}</p>
</div>
<div class="stats">
    <div class="stat">
        <div class="stat-val">{{ $jadwal->count() }}</div>
        <div class="stat-label">Total Jadwal</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $jadwal->where('is_active', true)->count() }}</div>
        <div class="stat-label">Aktif</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $jadwal->unique('kelas_id')->count() }}</div>
        <div class="stat-label">Kelas Terlibat</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $jadwal->unique('guru_id')->count() }}</div>
        <div class="stat-label">Guru Mengajar</div>
    </div>
</div>
<table>
    <thead>
        <tr>
            <th style="width:20px" class="center">#</th>
            <th class="center" style="width:38px">Hari</th>
            <th class="center" style="width:60px">Jam</th>
            <th>Kelas</th>
            <th>Mata Pelajaran</th>
            <th>Guru</th>
            <th style="width:40px">Ruang</th>
            <th>Tahun Ajaran</th>
            <th class="center">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($jadwal as $i => $j)
        <tr>
            <td class="center" style="color:#94a3b8;font-weight:bold">{{ $i + 1 }}</td>
            <td class="center">
                <span class="hari-pill">{{ ucfirst($j->hari) }}</span>
            </td>
            <td class="center" style="font-weight:bold">
                {{ $j->jam_mulai }} – {{ $j->jam_selesai }}
            </td>
            <td style="font-weight:bold">{{ $j->kelas?->nama_kelas ?? '-' }}</td>
            <td>
                <div>{{ $j->mataPelajaran?->nama_mapel ?? '-' }}</div>
                <div style="color:#64748b;font-size:6.5px">{{ $j->mataPelajaran?->kode_mapel ?? '' }}</div>
            </td>
            <td>{{ $j->guru?->nama_lengkap ?? '-' }}</td>
            <td style="color:#64748b">{{ $j->ruang?->kode_ruang ?? '-' }}</td>
            <td style="font-size:7px;color:#64748b">{{ $j->tahunAjaran?->label ?? '-' }}</td>
            <td class="center">
                <span class="badge badge-{{ $j->is_active ? 'aktif' : 'nonaktif' }}">
                    {{ $j->is_active ? 'Aktif' : 'Nonaktif' }}
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