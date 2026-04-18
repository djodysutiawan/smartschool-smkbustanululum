<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Notifikasi</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'DejaVu Sans',Arial,sans-serif;font-size:11px;color:#1e293b;}
        .header{padding:18px 24px 14px;border-bottom:2px solid #1f63db;margin-bottom:16px;}
        .header-top{display:flex;justify-content:space-between;align-items:flex-start;}
        .school-name{font-size:15px;font-weight:700;color:#0f172a;}
        .school-sub{font-size:10px;color:#64748b;margin-top:2px;}
        .doc-title{text-align:right;}
        .doc-title h1{font-size:14px;font-weight:700;color:#1f63db;}
        .doc-title p{font-size:10px;color:#64748b;margin-top:2px;}
        .doc-meta{margin-top:8px;font-size:10px;color:#64748b;}
        .stats-row{display:flex;gap:10px;margin-bottom:14px;}
        .stat-box{flex:1;border:1px solid #e2e8f0;border-radius:6px;padding:8px 10px;text-align:center;}
        .stat-box .val{font-size:17px;font-weight:700;}
        .stat-box .lbl{font-size:9px;color:#64748b;text-transform:uppercase;letter-spacing:.04em;margin-top:2px;}
        .stat-box.blue{border-color:#bfdbfe;background:#eff6ff;}.stat-box.blue .val{color:#1d4ed8;}
        .stat-box.yellow{border-color:#fde68a;background:#fefce8;}.stat-box.yellow .val{color:#a16207;}
        .stat-box.green{border-color:#bbf7d0;background:#f0fdf4;}.stat-box.green .val{color:#15803d;}
        table{width:100%;border-collapse:collapse;}
        thead tr{background:#1f63db;}
        thead th{padding:8px 10px;text-align:left;font-size:10px;font-weight:700;color:#fff;letter-spacing:.04em;text-transform:uppercase;}
        tbody tr:nth-child(even){background:#f8fafc;}
        tbody tr{border-bottom:1px solid #e2e8f0;}
        td{padding:7px 10px;font-size:10.5px;color:#334155;vertical-align:top;}
        .jenis-pill{display:inline-block;padding:1px 7px;border-radius:4px;font-size:9.5px;font-weight:700;}
        .jenis-info{background:#eff6ff;color:#1d4ed8;}.jenis-peringatan{background:#fff7ed;color:#c2410c;}
        .jenis-pelanggaran{background:#ffe4e6;color:#9f1239;}.jenis-tugas{background:#fdf4ff;color:#7c3aed;}
        .jenis-ujian{background:#fff7ed;color:#c2410c;}.jenis-absensi{background:#f0fdf4;color:#15803d;}
        .jenis-nilai{background:#fefce8;color:#a16207;}.jenis-pengumuman{background:#eff6ff;color:#1d4ed8;}
        .badge{display:inline-block;padding:1px 7px;border-radius:99px;font-size:9.5px;font-weight:700;}
        .badge-dibaca{background:#f1f5f9;color:#64748b;}.badge-belum{background:#dbeafe;color:#1d4ed8;}
        .footer{margin-top:20px;padding-top:8px;border-top:1px solid #e2e8f0;display:flex;justify-content:space-between;}
        .footer p{font-size:9.5px;color:#94a3b8;}
    </style>
</head>
<body>

<div class="header">
    <div class="header-top">
        <div>
            <p class="school-name">Sistem Informasi Sekolah</p>
            <p class="school-sub">Laporan Data Notifikasi</p>
        </div>
        <div class="doc-title">
            <h1>Laporan Notifikasi</h1>
            <p>Dicetak: {{ now()->format('d M Y, H:i') }}</p>
        </div>
    </div>
    <p class="doc-meta">Total data: {{ $notifikasis->count() }} notifikasi</p>
</div>

@php
    $total   = $notifikasis->count();
    $dibaca  = $notifikasis->where('sudah_dibaca', true)->count();
    $belum   = $notifikasis->where('sudah_dibaca', false)->count();
@endphp

<div class="stats-row">
    <div class="stat-box blue"><p class="val">{{ $total }}</p><p class="lbl">Total</p></div>
    <div class="stat-box green"><p class="val">{{ $dibaca }}</p><p class="lbl">Sudah Dibaca</p></div>
    <div class="stat-box yellow"><p class="val">{{ $belum }}</p><p class="lbl">Belum Dibaca</p></div>
</div>

<table>
    <thead>
        <tr>
            <th style="width:28px">#</th>
            <th>Judul</th>
            <th>Penerima</th>
            <th>Jenis</th>
            <th>Status</th>
            <th>Waktu</th>
        </tr>
    </thead>
    <tbody>
        @forelse($notifikasis as $i => $n)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>
                <strong>{{ $n->judul }}</strong><br>
                <span style="font-size:10px;color:#64748b">{{ \Illuminate\Support\Str::limit($n->pesan, 60) }}</span>
            </td>
            <td>
                {{ $n->pengguna->name ?? '-' }}<br>
                <span style="font-size:9.5px;color:#94a3b8">{{ $n->pengguna->email ?? '' }}</span>
            </td>
            <td><span class="jenis-pill jenis-{{ $n->jenis }}">{{ ucfirst($n->jenis) }}</span></td>
            <td>
                @if($n->sudah_dibaca)
                    <span class="badge badge-dibaca">Dibaca</span>
                @else
                    <span class="badge badge-belum">Belum</span>
                @endif
            </td>
            <td style="white-space:nowrap">{{ $n->created_at->format('d M Y') }}</td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:20px;color:#94a3b8;font-style:italic">Tidak ada data notifikasi.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    <p>Sistem Informasi Sekolah &copy; {{ date('Y') }}</p>
    <p>Dicetak pada {{ now()->format('d M Y, H:i') }}</p>
</div>
</body>
</html>