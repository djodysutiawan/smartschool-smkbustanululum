<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Laporan Pelanggaran</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1e293b; background: #fff; }
    .header { background: #dc2626; color: #fff; padding: 18px 24px; margin-bottom: 20px; }
    .header h1 { font-size: 18px; font-weight: 700; }
    .header p { font-size: 11px; opacity: .85; margin-top: 3px; }
    .meta { margin: 0 24px 16px; padding-bottom: 12px; border-bottom: 2px solid #e2e8f0; display: flex; justify-content: space-between; }
    .meta-item strong { display: block; font-size: 10px; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 2px; }
    .meta-item span { font-size: 12px; font-weight: 700; }
    .stats-row { display: flex; gap: 12px; margin: 0 24px 16px; }
    .stat-box { flex: 1; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; text-align: center; }
    .stat-box .val { font-size: 18px; font-weight: 700; }
    .stat-box .lbl { font-size: 9.5px; color: #94a3b8; text-transform: uppercase; letter-spacing: .04em; margin-top: 2px; }
    .stat-box.red   { border-top: 3px solid #ef4444; } .stat-box.red .val   { color: #dc2626; }
    .stat-box.orange{ border-top: 3px solid #f97316; } .stat-box.orange .val{ color: #c2410c; }
    .stat-box.yellow{ border-top: 3px solid #eab308; } .stat-box.yellow .val{ color: #a16207; }
    .stat-box.green { border-top: 3px solid #22c55e; } .stat-box.green .val { color: #15803d; }
    .table-wrap { margin: 0 24px; }
    table { width: 100%; border-collapse: collapse; font-size: 10px; }
    thead { background: #dc2626; color: #fff; }
    thead th { padding: 7px 9px; text-align: left; font-weight: 700; font-size: 9.5px; text-transform: uppercase; letter-spacing: .04em; }
    thead th.center { text-align: center; }
    tbody tr { border-bottom: 1px solid #f1f5f9; }
    tbody tr:nth-child(even) { background: #fff5f5; }
    td { padding: 6px 9px; vertical-align: middle; }
    td.center { text-align: center; }
    .badge { display: inline-block; padding: 2px 7px; border-radius: 99px; font-size: 9.5px; font-weight: 700; }
    .badge-pending   { background: #f1f5f9; color: #64748b; }
    .badge-diproses  { background: #dbeafe; color: #1d4ed8; }
    .badge-selesai   { background: #dcfce7; color: #15803d; }
    .badge-banding   { background: #fef9c3; color: #a16207; }
    .tingkat-pill { display: inline-block; padding: 2px 6px; border-radius: 4px; font-size: 9.5px; font-weight: 700; }
    .tingkat-ringan { background: #fefce8; color: #a16207; }
    .tingkat-sedang { background: #fff7ed; color: #c2410c; }
    .tingkat-berat  { background: #fff0f0; color: #dc2626; }
    .footer { margin: 20px 24px 0; padding-top: 10px; border-top: 1px solid #e2e8f0; font-size: 10px; color: #94a3b8; display: flex; justify-content: space-between; }
    .empty { text-align: center; padding: 40px; color: #94a3b8; }
</style>
</head>
<body>
<div class="header">
    <h1>⚠️ Laporan Pelanggaran Siswa</h1>
    <p>Dicetak pada: {{ $generated_at }}</p>
</div>

@php
    $total    = $data->count();
    $berat    = $data->filter(fn($p) => optional($p->kategori)->tingkat === 'berat')->count();
    $sedang   = $data->filter(fn($p) => optional($p->kategori)->tingkat === 'sedang')->count();
    $selesai  = $data->where('status','selesai')->count();
    $diproses = $data->where('status','diproses')->count();
    $totalPoin= $data->sum('poin');
@endphp

<div class="meta">
    <div class="meta-item"><strong>Total Pelanggaran</strong><span>{{ $total }} kasus</span></div>
    <div class="meta-item"><strong>Total Poin</strong><span>{{ $totalPoin }} poin</span></div>
    <div class="meta-item"><strong>Tanggal Cetak</strong><span>{{ $generated_at }}</span></div>
</div>

<div class="stats-row">
    <div class="stat-box red"><div class="val">{{ $berat }}</div><div class="lbl">Pelanggaran Berat</div></div>
    <div class="stat-box orange"><div class="val">{{ $sedang }}</div><div class="lbl">Pelanggaran Sedang</div></div>
    <div class="stat-box yellow"><div class="val">{{ $diproses }}</div><div class="lbl">Diproses</div></div>
    <div class="stat-box green"><div class="val">{{ $selesai }}</div><div class="lbl">Selesai</div></div>
</div>

<div class="table-wrap">
    @if($data->isEmpty())
    <div class="empty">Tidak ada data pelanggaran.</div>
    @else
    <table>
        <thead>
            <tr>
                <th style="width:30px">#</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Kelas</th>
                <th>Kategori</th>
                <th class="center">Tingkat</th>
                <th class="center">Poin</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
                <th class="center">Status</th>
                <th>Dicatat Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-weight:700">{{ $p->siswa->nama_lengkap ?? '-' }}</td>
                <td>{{ $p->siswa->nis ?? '-' }}</td>
                <td>{{ optional($p->siswa)->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $p->kategori->nama ?? '-' }}</td>
                <td class="center">
                    @php $tingkat = $p->kategori->tingkat ?? 'ringan'; @endphp
                    <span class="tingkat-pill tingkat-{{ $tingkat }}">{{ ucfirst($tingkat) }}</span>
                </td>
                <td class="center" style="font-weight:700;color:{{ $p->poin >= 50 ? '#dc2626' : ($p->poin >= 20 ? '#c2410c' : '#a16207') }}">{{ $p->poin }}</td>
                <td>{{ Str::limit($p->deskripsi, 40) }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                <td class="center">
                    <span class="badge badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span>
                </td>
                <td>{{ optional($p->dicatatOleh)->name ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

<div class="footer">
    <span>Laporan Pelanggaran Siswa — {{ config('app.name', 'Sistem Sekolah') }}</span>
    <span>Dicetak: {{ $generated_at }}</span>
</div>
</body>
</html>