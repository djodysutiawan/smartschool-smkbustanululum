<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Laporan Data Siswa</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1e293b; background: #fff; }
    .header { background: #7c3aed; color: #fff; padding: 18px 24px; margin-bottom: 20px; }
    .header h1 { font-size: 18px; font-weight: 700; }
    .header p { font-size: 11px; opacity: .85; margin-top: 3px; }
    .meta { margin: 0 24px 16px; padding-bottom: 12px; border-bottom: 2px solid #e2e8f0; display: flex; justify-content: space-between; }
    .meta-item strong { display: block; font-size: 10px; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 2px; }
    .meta-item span { font-size: 12px; font-weight: 700; }
    .stats-row { display: flex; gap: 12px; margin: 0 24px 16px; }
    .stat-box { flex: 1; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; text-align: center; }
    .stat-box .val { font-size: 18px; font-weight: 700; }
    .stat-box .lbl { font-size: 9.5px; color: #94a3b8; text-transform: uppercase; letter-spacing: .04em; margin-top: 2px; }
    .stat-box.total  { border-top: 3px solid #7c3aed; } .stat-box.total .val  { color: #7c3aed; }
    .stat-box.aktif  { border-top: 3px solid #22c55e; } .stat-box.aktif .val  { color: #15803d; }
    .stat-box.laki   { border-top: 3px solid #3b82f6; } .stat-box.laki .val   { color: #1d4ed8; }
    .stat-box.peremp { border-top: 3px solid #ec4899; } .stat-box.peremp .val { color: #be185d; }
    .table-wrap { margin: 0 24px; }
    table { width: 100%; border-collapse: collapse; font-size: 10px; }
    thead { background: #7c3aed; color: #fff; }
    thead th { padding: 7px 9px; text-align: left; font-weight: 700; font-size: 9.5px; text-transform: uppercase; letter-spacing: .04em; }
    thead th.center { text-align: center; }
    tbody tr { border-bottom: 1px solid #f1f5f9; }
    tbody tr:nth-child(even) { background: #faf5ff; }
    td { padding: 6px 9px; vertical-align: middle; }
    td.center { text-align: center; }
    .badge { display: inline-block; padding: 2px 7px; border-radius: 99px; font-size: 9.5px; font-weight: 700; }
    .badge-aktif      { background: #dcfce7; color: #15803d; }
    .badge-tidak_aktif{ background: #fee2e2; color: #dc2626; }
    .badge-lulus      { background: #dbeafe; color: #1d4ed8; }
    .badge-pindah     { background: #fef9c3; color: #a16207; }
    .badge-keluar     { background: #f1f5f9; color: #64748b; }
    .jk-l { color: #1d4ed8; font-weight: 700; }
    .jk-p { color: #be185d; font-weight: 700; }
    .footer { margin: 20px 24px 0; padding-top: 10px; border-top: 1px solid #e2e8f0; font-size: 10px; color: #94a3b8; display: flex; justify-content: space-between; }
    .empty { text-align: center; padding: 40px; color: #94a3b8; }
</style>
</head>
<body>
<div class="header">
    <h1>👥 Laporan Data Siswa</h1>
    <p>Dicetak pada: {{ $generated_at }}</p>
</div>

@php
    $total    = $data->count();
    $aktif    = $data->where('status','aktif')->count();
    $laki     = $data->where('jenis_kelamin','L')->count();
    $perempuan= $data->where('jenis_kelamin','P')->count();
@endphp

<div class="meta">
    <div class="meta-item"><strong>Total Siswa</strong><span>{{ $total }} siswa</span></div>
    <div class="meta-item"><strong>Status Aktif</strong><span>{{ $aktif }} siswa</span></div>
    <div class="meta-item"><strong>Tanggal Cetak</strong><span>{{ $generated_at }}</span></div>
</div>

<div class="stats-row">
    <div class="stat-box total"><div class="val">{{ $total }}</div><div class="lbl">Total Siswa</div></div>
    <div class="stat-box aktif"><div class="val">{{ $aktif }}</div><div class="lbl">Aktif</div></div>
    <div class="stat-box laki"><div class="val">{{ $laki }}</div><div class="lbl">Laki-laki</div></div>
    <div class="stat-box peremp"><div class="val">{{ $perempuan }}</div><div class="lbl">Perempuan</div></div>
</div>

<div class="table-wrap">
    @if($data->isEmpty())
    <div class="empty">Tidak ada data siswa.</div>
    @else
    <table>
        <thead>
            <tr>
                <th style="width:30px">#</th>
                <th>Nama Lengkap</th>
                <th>NIS</th>
                <th>NISN</th>
                <th class="center">JK</th>
                <th>Kelas</th>
                <th>Tempat, Tgl Lahir</th>
                <th>No HP</th>
                <th class="center">Kehadiran</th>
                <th class="center">Poin Pel.</th>
                <th class="center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $s)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-weight:700">{{ $s->nama_lengkap }}</td>
                <td>{{ $s->nis }}</td>
                <td>{{ $s->nisn ?? '-' }}</td>
                <td class="center"><span class="jk-{{ strtolower($s->jenis_kelamin) }}">{{ $s->jenis_kelamin }}</span></td>
                <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $s->tempat_lahir ?? '-' }}, {{ optional($s->tanggal_lahir)->format('d/m/Y') ?? '-' }}</td>
                <td>{{ $s->no_hp ?? '-' }}</td>
                <td class="center" style="font-weight:700;color:{{ ($s->persentase_kehadiran ?? 0) >= 80 ? '#15803d' : '#dc2626' }}">
                    {{ $s->persentase_kehadiran ?? 0 }}%
                </td>
                <td class="center" style="font-weight:700;color:{{ ($s->total_poin_pelanggaran ?? 0) >= 50 ? '#dc2626' : '#15803d' }}">
                    {{ $s->total_poin_pelanggaran ?? 0 }}
                </td>
                <td class="center">
                    <span class="badge badge-{{ $s->status }}">{{ ucfirst(str_replace('_',' ',$s->status)) }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

<div class="footer">
    <span>Laporan Data Siswa — {{ config('app.name', 'Sistem Sekolah') }}</span>
    <span>Dicetak: {{ $generated_at }}</span>
</div>
</body>
</html>