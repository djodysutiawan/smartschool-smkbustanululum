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
    .badge { display: inline-block; padding: 2px 8px; border-radius: 99px; font-size: 7.5px; font-weight: bold; }
    .badge-aktif    { background: #dcfce7; color: #15803d; }
    .badge-nonaktif { background: #fee2e2; color: #dc2626; }
    .progress-wrap  { background: #e2e8f0; border-radius: 99px; height: 5px; width: 60px; }
    .progress-bar   { background: #1f63db; border-radius: 99px; height: 5px; }
    .footer { margin-top: 12px; padding-top: 8px; border-top: 1px solid #e2e8f0; display: table; width: 100%; font-size: 8px; color: #94a3b8; }
    .footer-left  { display: table-cell; }
    .footer-right { display: table-cell; text-align: right; }
</style>
</head>
<body>
<div class="header">
    <h1>🏫 Data Kelas</h1>
    <p>Laporan data kelas — dicetak {{ now()->format('d F Y, H:i') }} WIB{{ $filterLabel ? ' | Filter: '.$filterLabel : '' }}</p>
</div>
<div class="stats">
    <div class="stat">
        <div class="stat-val">{{ $kelas->count() }}</div>
        <div class="stat-label">Total Kelas</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $kelas->where('status','aktif')->count() }}</div>
        <div class="stat-label">Aktif</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $kelas->sum('siswa_count') }}</div>
        <div class="stat-label">Total Siswa</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $kelas->where('siswa_count','>=','kapasitas_maks')->count() }}</div>
        <div class="stat-label">Kelas Penuh</div>
    </div>
</div>
<table>
    <thead>
        <tr>
            <th style="width:22px" class="center">#</th>
            <th>Kode / Nama Kelas</th>
            <th class="center" style="width:40px">Tingkat</th>
            <th>Jurusan</th>
            <th>Wali Kelas</th>
            <th>Ruang</th>
            <th>Tahun Ajaran</th>
            <th class="center" style="width:70px">Siswa / Kap.</th>
            <th class="center">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($kelas as $i => $k)
        @php $pct = $k->kapasitas_maks > 0 ? min(100, round(($k->siswa_count / $k->kapasitas_maks) * 100)) : 0; @endphp
        <tr>
            <td class="center" style="color:#94a3b8;font-weight:bold">{{ $i + 1 }}</td>
            <td>
                <div style="font-weight:bold">{{ $k->nama_kelas }}</div>
                <div style="color:#64748b;font-size:7.5px">{{ $k->kode_kelas }}</div>
            </td>
            <td class="center" style="font-weight:bold;color:#1f63db">{{ $k->tingkat }}</td>
            <td style="color:#64748b;font-size:8px">{{ $k->jurusan ?? '-' }}</td>
            <td style="font-size:8px">{{ $k->waliKelas?->nama_lengkap ?? '-' }}</td>
            <td style="color:#64748b;font-size:8px">{{ $k->ruang?->kode_ruang ?? '-' }}</td>
            <td style="font-size:8px">{{ $k->tahunAjaran?->label ?? '-' }}</td>
            <td class="center">
                <div>{{ $k->siswa_count }} / {{ $k->kapasitas_maks }}</div>
                <div class="progress-wrap" style="margin:2px auto 0">
                    <div class="progress-bar" style="width:{{ $pct }}%;background:{{ $pct >= 90 ? '#dc2626' : '#1f63db' }}"></div>
                </div>
            </td>
            <td class="center">
                <span class="badge badge-{{ $k->status === 'aktif' ? 'aktif' : 'nonaktif' }}">{{ ucfirst($k->status) }}</span>
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