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
    .guru-header{background:#f1f5f9;border:1px solid #e2e8f0;border-radius:5px;padding:8px 12px;margin-bottom:6px;margin-top:14px;display:table;width:100%}
    .guru-name{display:table-cell;font-weight:bold;font-size:10px;color:#0f172a}
    .guru-summary{display:table-cell;text-align:right;font-size:8px;color:#475569}
    table{width:100%;border-collapse:collapse;font-size:8.5px;margin-bottom:4px}
    thead th{background:#334155;color:#fff;padding:6px 8px;text-align:left;font-size:8px;text-transform:uppercase;letter-spacing:.04em}
    thead th.center{text-align:center}
    tbody tr:nth-child(even){background:#f8fafc}
    td{padding:5px 8px;border-bottom:1px solid #f1f5f9;vertical-align:middle}
    td.center{text-align:center}
    .badge{display:inline-block;padding:2px 7px;border-radius:99px;font-size:7.5px;font-weight:bold}
    .b-hadir{background:#dcfce7;color:#15803d}.b-telat{background:#fef9c3;color:#a16207}
    .b-izin{background:#dbeafe;color:#1d4ed8}.b-sakit{background:#f3e8ff;color:#6d28d9}.b-alfa{background:#fee2e2;color:#dc2626}
    .footer{margin-top:12px;padding-top:8px;border-top:1px solid #e2e8f0;display:table;width:100%;font-size:8px;color:#94a3b8}
    .footer-left{display:table-cell}.footer-right{display:table-cell;text-align:right}
</style>
</head>
<body>
<div class="header">
    <h1>📊 Rekap Absensi Guru</h1>
    <p>
        Periode {{ \Carbon\Carbon::parse($request->tanggal_dari)->format('d/m/Y') }} – {{ \Carbon\Carbon::parse($request->tanggal_sampai)->format('d/m/Y') }}
        {{ $guru ? ' | Guru: '.$guru->nama_lengkap : '' }}
        — dicetak {{ now()->format('d F Y, H:i') }} WIB
    </p>
</div>

@forelse($absensi as $guruId => $records)
@php
    $namaGuru = $records->first()->guru->nama_lengkap ?? '—';
    $nipGuru  = $records->first()->guru->nip ?? '—';
    $totalHadir = $records->whereIn('status',['hadir','telat'])->count();
    $totalIzin  = $records->where('status','izin')->count();
    $totalSakit = $records->where('status','sakit')->count();
    $totalAlfa  = $records->where('status','alfa')->count();
@endphp
<div class="guru-header">
    <div class="guru-name">{{ $namaGuru }} <span style="font-weight:normal;color:#64748b">| NIP: {{ $nipGuru }}</span></div>
    <div class="guru-summary">
        Hadir: <strong>{{ $totalHadir }}</strong> &nbsp;
        Izin: <strong>{{ $totalIzin }}</strong> &nbsp;
        Sakit: <strong>{{ $totalSakit }}</strong> &nbsp;
        Alfa: <strong>{{ $totalAlfa }}</strong>
    </div>
</div>
<table>
    <thead>
        <tr>
            <th style="width:22px" class="center">#</th>
            <th class="center">Tanggal</th>
            <th class="center">Jam Masuk</th>
            <th class="center">Jam Keluar</th>
            <th class="center">Status</th>
            <th class="center">Metode</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $i => $r)
        @php $bc=['hadir'=>'b-hadir','telat'=>'b-telat','izin'=>'b-izin','sakit'=>'b-sakit','alfa'=>'b-alfa'][$r->status]??'b-alfa'; @endphp
        <tr>
            <td class="center" style="color:#94a3b8">{{ $i+1 }}</td>
            <td class="center" style="font-weight:bold">{{ \Carbon\Carbon::parse($r->tanggal)->format('d/m/Y') }}</td>
            <td class="center">{{ $r->jam_masuk ?? '—' }}</td>
            <td class="center">{{ $r->jam_keluar ?? '—' }}</td>
            <td class="center"><span class="badge {{ $bc }}">{{ ucfirst($r->status) }}</span></td>
            <td class="center">{{ ucfirst($r->metode) }}</td>
            <td>{{ $r->keterangan ?? '—' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@empty
<p style="text-align:center;color:#94a3b8;padding:20px">Tidak ada data absensi pada periode ini</p>
@endforelse

<div class="footer">
    <div class="footer-left">Sistem Informasi Sekolah — Dicetak oleh: {{ auth()->user()->name }}</div>
    <div class="footer-right">{{ now()->format('d/m/Y H:i') }}</div>
</div>
</body>
</html>