<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'DejaVu Sans',Arial,sans-serif;font-size:9px;color:#1e293b}
    .header{background:#1f63db;color:#fff;padding:14px 20px;margin-bottom:14px;border-radius:6px}
    .header h1{font-size:15px;font-weight:bold;margin-bottom:2px}
    .header p{font-size:9px;opacity:.85}
    table{width:100%;border-collapse:collapse;font-size:8.5px}
    thead th{background:#1f63db;color:#fff;padding:7px 8px;text-align:left;font-size:8px;text-transform:uppercase;letter-spacing:.04em}
    thead th.center{text-align:center}
    tbody tr:nth-child(even){background:#f8fafc}
    td{padding:6px 8px;border-bottom:1px solid #f1f5f9;vertical-align:middle}
    td.center{text-align:center}
    .badge{display:inline-block;padding:2px 7px;border-radius:99px;font-size:7.5px;font-weight:bold}
    .b-hadir{background:#dcfce7;color:#15803d}
    .b-telat{background:#fef9c3;color:#a16207}
    .b-izin{background:#dbeafe;color:#1d4ed8}
    .b-sakit{background:#f3e8ff;color:#6d28d9}
    .b-alfa{background:#fee2e2;color:#dc2626}
    .footer{margin-top:12px;padding-top:8px;border-top:1px solid #e2e8f0;display:table;width:100%;font-size:8px;color:#94a3b8}
    .footer-left{display:table-cell}
    .footer-right{display:table-cell;text-align:right}
</style>
</head>
<body>
<div class="header">
    <h1>📋 Data Absensi Guru</h1>
    <p>Laporan absensi guru — dicetak {{ now()->format('d F Y, H:i') }} WIB</p>
</div>

<table>
    <thead>
        <tr>
            <th style="width:22px" class="center">#</th>
            <th>Nama Guru</th>
            <th>NIP</th>
            <th class="center">Tanggal</th>
            <th class="center">Jam Masuk</th>
            <th class="center">Jam Keluar</th>
            <th class="center">Status</th>
            <th class="center">Metode</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($absensi as $i => $a)
        @php $bc=['hadir'=>'b-hadir','telat'=>'b-telat','izin'=>'b-izin','sakit'=>'b-sakit','alfa'=>'b-alfa'][$a->status]??'b-alfa'; @endphp
        <tr>
            <td class="center" style="color:#94a3b8;font-weight:bold">{{ $i + 1 }}</td>
            <td style="font-weight:bold">{{ $a->guru->nama_lengkap ?? '—' }}</td>
            <td style="color:#64748b">{{ $a->guru->nip ?? '—' }}</td>
            <td class="center">{{ \Carbon\Carbon::parse($a->tanggal)->format('d/m/Y') }}</td>
            <td class="center">{{ $a->jam_masuk ?? '—' }}</td>
            <td class="center">{{ $a->jam_keluar ?? '—' }}</td>
            <td class="center"><span class="badge {{ $bc }}">{{ ucfirst($a->status) }}</span></td>
            <td class="center">{{ ucfirst($a->metode) }}</td>
            <td>{{ $a->keterangan ?? '—' }}</td>
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