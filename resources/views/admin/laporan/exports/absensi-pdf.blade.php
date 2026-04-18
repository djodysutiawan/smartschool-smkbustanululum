<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Laporan Absensi</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1e293b; background: #fff; }
    .header { background: #1f63db; color: #fff; padding: 18px 24px; margin-bottom: 20px; }
    .header h1 { font-size: 18px; font-weight: 700; letter-spacing: .02em; }
    .header p { font-size: 11px; opacity: .85; margin-top: 3px; }
    .meta { padding: 0 24px 14px; display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #e2e8f0; margin: 0 24px 16px; padding-bottom: 12px; }
    .meta-item strong { display: block; font-size: 10px; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 2px; }
    .meta-item span { font-size: 12px; font-weight: 700; color: #0f172a; }
    .stats-row { display: flex; gap: 12px; margin: 0 24px 16px; }
    .stat-box { flex: 1; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; text-align: center; }
    .stat-box .val { font-size: 20px; font-weight: 700; }
    .stat-box .lbl { font-size: 9.5px; color: #94a3b8; text-transform: uppercase; letter-spacing: .04em; margin-top: 2px; }
    .stat-box.hadir { border-top: 3px solid #22c55e; } .stat-box.hadir .val { color: #15803d; }
    .stat-box.izin  { border-top: 3px solid #3b82f6; } .stat-box.izin .val  { color: #1d4ed8; }
    .stat-box.sakit { border-top: 3px solid #f97316; } .stat-box.sakit .val { color: #c2410c; }
    .stat-box.alfa  { border-top: 3px solid #ef4444; } .stat-box.alfa .val  { color: #dc2626; }
    .table-wrap { margin: 0 24px; }
    table { width: 100%; border-collapse: collapse; font-size: 10.5px; }
    thead { background: #1f63db; color: #fff; }
    thead th { padding: 8px 10px; text-align: left; font-weight: 700; font-size: 10px; text-transform: uppercase; letter-spacing: .04em; }
    thead th.center { text-align: center; }
    tbody tr { border-bottom: 1px solid #f1f5f9; }
    tbody tr:nth-child(even) { background: #f8fafc; }
    td { padding: 7px 10px; vertical-align: middle; }
    td.center { text-align: center; }
    .badge { display: inline-block; padding: 2px 8px; border-radius: 99px; font-size: 9.5px; font-weight: 700; }
    .badge-hadir { background: #dcfce7; color: #15803d; }
    .badge-telat  { background: #fef9c3; color: #a16207; }
    .badge-izin   { background: #dbeafe; color: #1d4ed8; }
    .badge-sakit  { background: #ffedd5; color: #c2410c; }
    .badge-alfa   { background: #fee2e2; color: #dc2626; }
    .footer { margin: 20px 24px 0; padding-top: 10px; border-top: 1px solid #e2e8f0; font-size: 10px; color: #94a3b8; display: flex; justify-content: space-between; }
    .empty { text-align: center; padding: 40px; color: #94a3b8; }
</style>
</head>
<body>
<div class="header">
    <h1>📋 Laporan Absensi Siswa</h1>
    <p>Dicetak pada: {{ $generated_at }}</p>
</div>

@php
    $hadir = $data->whereIn('status', ['hadir','telat'])->count();
    $izin  = $data->where('status', 'izin')->count();
    $sakit = $data->where('status', 'sakit')->count();
    $alfa  = $data->where('status', 'alfa')->count();
    $total = $data->count();
@endphp

<div class="meta">
    <div class="meta-item"><strong>Total Record</strong><span>{{ $total }} data</span></div>
    <div class="meta-item"><strong>Tanggal Cetak</strong><span>{{ $generated_at }}</span></div>
</div>

<div class="stats-row">
    <div class="stat-box hadir"><div class="val">{{ $hadir }}</div><div class="lbl">Hadir/Telat</div></div>
    <div class="stat-box izin"><div class="val">{{ $izin }}</div><div class="lbl">Izin</div></div>
    <div class="stat-box sakit"><div class="val">{{ $sakit }}</div><div class="lbl">Sakit</div></div>
    <div class="stat-box alfa"><div class="val">{{ $alfa }}</div><div class="lbl">Alfa</div></div>
</div>

<div class="table-wrap">
    @if($data->isEmpty())
    <div class="empty">Tidak ada data absensi.</div>
    @else
    <table>
        <thead>
            <tr>
                <th style="width:36px">#</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th class="center">Status</th>
                <th class="center">Metode</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $a)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-weight:700">{{ $a->siswa->nama_lengkap ?? '-' }}</td>
                <td>{{ $a->siswa->nis ?? '-' }}</td>
                <td>{{ $a->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ optional($a->tanggal)->format('d/m/Y') }}</td>
                <td class="center">{{ $a->jam_masuk ?? '-' }}</td>
                <td class="center">
                    <span class="badge badge-{{ $a->status }}">{{ ucfirst($a->status ?? '-') }}</span>
                </td>
                <td class="center">{{ $a->metode === 'qr_code' ? 'QR Code' : 'Manual' }}</td>
                <td>{{ Str::limit($a->keterangan ?? '-', 40) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

<div class="footer">
    <span>Laporan Absensi Siswa — {{ config('app.name', 'Sistem Sekolah') }}</span>
    <span>Dicetak: {{ $generated_at }}</span>
</div>
</body>
</html>