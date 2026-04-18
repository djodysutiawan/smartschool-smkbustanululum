<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Nilai Siswa</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 11px; color: #1e293b; }
        .header { padding: 18px 24px 14px; border-bottom: 2px solid #1f63db; margin-bottom: 16px; }
        .header-top { display: flex; justify-content: space-between; align-items: flex-start; }
        .school-name { font-size: 15px; font-weight: 700; color: #0f172a; }
        .school-sub { font-size: 10px; color: #64748b; margin-top: 2px; }
        .doc-title { text-align: right; }
        .doc-title h1 { font-size: 14px; font-weight: 700; color: #1f63db; }
        .doc-title p { font-size: 10px; color: #64748b; margin-top: 2px; }
        .doc-meta { margin-top: 8px; font-size: 10px; color: #64748b; }
        .stats-row { display: flex; gap: 10px; margin-bottom: 14px; }
        .stat-box { flex: 1; border: 1px solid #e2e8f0; border-radius: 6px; padding: 8px 10px; text-align: center; }
        .stat-box .val { font-size: 17px; font-weight: 700; }
        .stat-box .lbl { font-size: 9px; color: #64748b; text-transform: uppercase; letter-spacing: .04em; margin-top: 2px; }
        .stat-box.blue { border-color: #bfdbfe; background: #eff6ff; } .stat-box.blue .val { color: #1d4ed8; }
        .stat-box.green { border-color: #bbf7d0; background: #f0fdf4; } .stat-box.green .val { color: #15803d; }
        .stat-box.orange { border-color: #fed7aa; background: #fff7ed; } .stat-box.orange .val { color: #c2410c; }
        .stat-box.red { border-color: #fecaca; background: #fff0f0; } .stat-box.red .val { color: #dc2626; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #1f63db; }
        thead th { padding: 8px 10px; text-align: left; font-size: 10px; font-weight: 700; color: #fff; letter-spacing: .04em; text-transform: uppercase; }
        thead th.center { text-align: center; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr { border-bottom: 1px solid #e2e8f0; }
        td { padding: 7px 10px; font-size: 10.5px; color: #334155; vertical-align: middle; }
        td.center { text-align: center; }
        td.bold { font-weight: 700; color: #0f172a; }
        .badge { display: inline-block; padding: 2px 7px; border-radius: 99px; font-size: 9.5px; font-weight: 700; }
        .badge-a { background: #dcfce7; color: #15803d; }
        .badge-b { background: #dbeafe; color: #1d4ed8; }
        .badge-c { background: #fef9c3; color: #a16207; }
        .badge-d { background: #fee2e2; color: #dc2626; }
        .badge-e { background: #ffe4e6; color: #9f1239; }
        .footer { margin-top: 20px; padding-top: 8px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; }
        .footer p { font-size: 9.5px; color: #94a3b8; }
    </style>
</head>
<body>

<div class="header">
    <div class="header-top">
        <div>
            <p class="school-name">Sistem Informasi Sekolah</p>
            <p class="school-sub">Laporan Data Nilai Siswa</p>
        </div>
        <div class="doc-title">
            <h1>Laporan Nilai Siswa</h1>
            <p>Dicetak: {{ now()->format('d M Y, H:i') }}</p>
        </div>
    </div>
    <p class="doc-meta">Total data: {{ $nilai->count() }} nilai</p>
</div>

@php
    $countA     = $nilai->where('predikat', 'A')->count();
    $countB     = $nilai->where('predikat', 'B')->count();
    $countBawah = $nilai->whereIn('predikat', ['D', 'E'])->count();
    $avgAll     = $nilai->whereNotNull('nilai_akhir')->avg('nilai_akhir');
@endphp

<div class="stats-row">
    <div class="stat-box blue"><p class="val">{{ $nilai->count() }}</p><p class="lbl">Total</p></div>
    <div class="stat-box green"><p class="val">{{ $countA }}</p><p class="lbl">Predikat A</p></div>
    <div class="stat-box orange"><p class="val">{{ $countB }}</p><p class="lbl">Predikat B</p></div>
    <div class="stat-box red"><p class="val">{{ $countBawah }}</p><p class="lbl">Di Bawah KKM</p></div>
    <div class="stat-box blue"><p class="val">{{ $avgAll ? number_format($avgAll, 1) : '—' }}</p><p class="lbl">Rata-rata</p></div>
</div>

<table>
    <thead>
        <tr>
            <th style="width:30px">#</th>
            <th>Nama Siswa</th>
            <th>Mata Pelajaran</th>
            <th>Kelas</th>
            <th>Tahun Ajaran</th>
            <th class="center">Tugas</th>
            <th class="center">Harian</th>
            <th class="center">UTS</th>
            <th class="center">UAS</th>
            <th class="center">Akhir</th>
            <th class="center">Predikat</th>
        </tr>
    </thead>
    <tbody>
        @forelse($nilai as $i => $n)
        <tr>
            <td class="center">{{ $i + 1 }}</td>
            <td class="bold">{{ $n->siswa->nama_lengkap ?? '-' }}</td>
            <td>{{ $n->mataPelajaran->nama_mapel ?? '-' }}</td>
            <td>{{ $n->kelas->nama_kelas ?? '-' }}</td>
            <td>{{ $n->tahunAjaran->tahun ?? '-' }}</td>
            <td class="center">{{ $n->nilai_tugas ?? '—' }}</td>
            <td class="center">{{ $n->nilai_harian ?? '—' }}</td>
            <td class="center">{{ $n->nilai_uts ?? '—' }}</td>
            <td class="center">{{ $n->nilai_uas ?? '—' }}</td>
            <td class="center" style="font-weight:700">{{ $n->nilai_akhir !== null ? number_format($n->nilai_akhir, 1) : '—' }}</td>
            <td class="center">
                @if($n->predikat)
                    <span class="badge badge-{{ strtolower($n->predikat) }}">{{ $n->predikat }}</span>
                @else
                    <span style="color:#94a3b8">—</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="11" style="text-align:center;padding:20px;color:#94a3b8;font-style:italic">Tidak ada data nilai.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    <p>Sistem Informasi Sekolah &copy; {{ date('Y') }}</p>
    <p>Dicetak pada {{ now()->format('d M Y, H:i') }}</p>
</div>

</body>
</html>