<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Laporan Nilai</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1e293b; background: #fff; }
    .header { background: #1f63db; color: #fff; padding: 18px 24px; margin-bottom: 20px; }
    .header h1 { font-size: 18px; font-weight: 700; }
    .header p { font-size: 11px; opacity: .85; margin-top: 3px; }
    .meta { margin: 0 24px 16px; padding-bottom: 12px; border-bottom: 2px solid #e2e8f0; display: flex; justify-content: space-between; }
    .meta-item strong { display: block; font-size: 10px; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 2px; }
    .meta-item span { font-size: 12px; font-weight: 700; }
    .stats-row { display: flex; gap: 12px; margin: 0 24px 16px; }
    .stat-box { flex: 1; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; text-align: center; }
    .stat-box .val { font-size: 18px; font-weight: 700; }
    .stat-box .lbl { font-size: 9.5px; color: #94a3b8; text-transform: uppercase; letter-spacing: .04em; margin-top: 2px; }
    .stat-box.green { border-top: 3px solid #22c55e; } .stat-box.green .val { color: #15803d; }
    .stat-box.blue  { border-top: 3px solid #3b82f6; } .stat-box.blue .val  { color: #1d4ed8; }
    .stat-box.red   { border-top: 3px solid #ef4444; } .stat-box.red .val   { color: #dc2626; }
    .stat-box.orange{ border-top: 3px solid #f97316; } .stat-box.orange .val{ color: #c2410c; }
    .table-wrap { margin: 0 24px; }
    table { width: 100%; border-collapse: collapse; font-size: 10px; }
    thead { background: #1f63db; color: #fff; }
    thead th { padding: 7px 9px; text-align: left; font-weight: 700; font-size: 9.5px; text-transform: uppercase; letter-spacing: .04em; }
    thead th.center { text-align: center; }
    tbody tr { border-bottom: 1px solid #f1f5f9; }
    tbody tr:nth-child(even) { background: #f8fafc; }
    td { padding: 6px 9px; vertical-align: middle; }
    td.center { text-align: center; }
    .badge { display: inline-block; padding: 2px 7px; border-radius: 99px; font-size: 9.5px; font-weight: 700; }
    .badge-A { background: #dcfce7; color: #15803d; }
    .badge-B { background: #dbeafe; color: #1d4ed8; }
    .badge-C { background: #fef9c3; color: #a16207; }
    .badge-D { background: #ffedd5; color: #c2410c; }
    .badge-E { background: #fee2e2; color: #dc2626; }
    .footer { margin: 20px 24px 0; padding-top: 10px; border-top: 1px solid #e2e8f0; font-size: 10px; color: #94a3b8; display: flex; justify-content: space-between; }
    .empty { text-align: center; padding: 40px; color: #94a3b8; }
</style>
</head>
<body>
<div class="header">
    <h1>📊 Laporan Nilai Siswa</h1>
    <p>Dicetak pada: {{ $generated_at }}</p>
</div>

@php
    $rata    = $data->isNotEmpty() ? round($data->avg('nilai_akhir'), 1) : 0;
    $predA   = $data->where('predikat','A')->count();
    $predE   = $data->where('predikat','E')->count();
    $bawahKKM= $data->where('nilai_akhir','<',70)->count();
@endphp

<div class="meta">
    <div class="meta-item"><strong>Total Record</strong><span>{{ $data->count() }} nilai</span></div>
    <div class="meta-item"><strong>Rata-rata Nilai Akhir</strong><span>{{ $rata }}</span></div>
    <div class="meta-item"><strong>Tanggal Cetak</strong><span>{{ $generated_at }}</span></div>
</div>

<div class="stats-row">
    <div class="stat-box green"><div class="val">{{ $predA }}</div><div class="lbl">Predikat A</div></div>
    <div class="stat-box blue"><div class="val">{{ $rata }}</div><div class="lbl">Rata-rata</div></div>
    <div class="stat-box orange"><div class="val">{{ $bawahKKM }}</div><div class="lbl">Bawah KKM</div></div>
    <div class="stat-box red"><div class="val">{{ $predE }}</div><div class="lbl">Predikat E</div></div>
</div>

<div class="table-wrap">
    @if($data->isEmpty())
    <div class="empty">Tidak ada data nilai.</div>
    @else
    <table>
        <thead>
            <tr>
                <th style="width:30px">#</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Tahun Ajaran</th>
                <th class="center">Tugas</th>
                <th class="center">Harian</th>
                <th class="center">UTS</th>
                <th class="center">UAS</th>
                <th class="center">Nilai Akhir</th>
                <th class="center">Predikat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $n)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-weight:700">{{ $n->siswa->nama_lengkap ?? '-' }}</td>
                <td>{{ $n->siswa->nis ?? '-' }}</td>
                <td>{{ $n->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $n->mataPelajaran->nama_mapel ?? '-' }}</td>
                <td>{{ $n->tahunAjaran->tahun ?? '-' }}</td>
                <td class="center">{{ $n->nilai_tugas ?? '-' }}</td>
                <td class="center">{{ $n->nilai_harian ?? '-' }}</td>
                <td class="center">{{ $n->nilai_uts ?? '-' }}</td>
                <td class="center">{{ $n->nilai_uas ?? '-' }}</td>
                <td class="center" style="font-weight:700;color:{{ ($n->nilai_akhir ?? 0) >= 75 ? '#15803d' : (($n->nilai_akhir ?? 0) >= 60 ? '#c2410c' : '#dc2626') }}">
                    {{ $n->nilai_akhir ?? '-' }}
                </td>
                <td class="center">
                    @if($n->predikat)
                        <span class="badge badge-{{ $n->predikat }}">{{ $n->predikat }}</span>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

<div class="footer">
    <span>Laporan Nilai Siswa — {{ config('app.name', 'Sistem Sekolah') }}</span>
    <span>Dicetak: {{ $generated_at }}</span>
</div>
</body>
</html>