<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 9px; color: #1e293b; background: #fff; }

    .header { background: #1f63db; color: #fff; padding: 14px 20px; margin-bottom: 16px; border-radius: 6px; }
    .header h1 { font-size: 16px; font-weight: bold; margin-bottom: 2px; }
    .header p  { font-size: 9px; opacity: .85; }
    .header-meta { float: right; text-align: right; font-size: 8.5px; opacity: .85; margin-top: -34px; }

    .stats { display: table; width: 100%; margin-bottom: 12px; border-spacing: 6px 0; }
    .stat  { display: table-cell; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 8px 12px; text-align: center; width: 25%; }
    .stat-val   { font-size: 18px; font-weight: bold; color: #1f63db; }
    .stat-label { font-size: 8px; color: #64748b; margin-top: 2px; text-transform: uppercase; letter-spacing: .04em; }

    table { width: 100%; border-collapse: collapse; font-size: 8.5px; }
    thead th {
        background: #1f63db; color: #fff;
        padding: 7px 8px; text-align: left;
        font-size: 8px; text-transform: uppercase; letter-spacing: .04em;
    }
    thead th.center { text-align: center; }
    tbody tr:nth-child(even) { background: #f8fafc; }
    td { padding: 6px 8px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    td.center { text-align: center; }

    .badge { display: inline-block; padding: 2px 7px; border-radius: 99px; font-size: 7.5px; font-weight: bold; }
    .badge-aktif    { background: #dcfce7; color: #15803d; }
    .badge-nonaktif { background: #fee2e2; color: #dc2626; }
    .badge-lulus    { background: #e0e7ff; color: #3730a3; }
    .badge-pindah   { background: #fef9c3; color: #a16207; }
    .badge-keluar   { background: #fee2e2; color: #dc2626; }
    .badge-l { background: #eff6ff; color: #1d4ed8; }
    .badge-p { background: #fdf2f8; color: #9d174d; }

    .footer { margin-top: 14px; padding-top: 8px; border-top: 1px solid #e2e8f0; display: table; width: 100%; font-size: 8px; color: #94a3b8; }
    .footer-left  { display: table-cell; }
    .footer-right { display: table-cell; text-align: right; }
    .nama { font-weight: bold; color: #0f172a; }
    .sub  { color: #64748b; font-size: 8px; }
</style>
</head>
<body>

<div class="header">
    <h1>📋 Data Siswa</h1>
    <p>Laporan lengkap data siswa — dicetak {{ now()->format('d F Y, H:i') }} WIB</p>
    <div class="header-meta">
        Total: {{ $siswa->count() }} siswa<br>
        Filter: {{ $filterLabel }}
    </div>
</div>

<div class="stats">
    <div class="stat">
        <div class="stat-val">{{ $siswa->count() }}</div>
        <div class="stat-label">Total</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $siswa->where('status','aktif')->count() }}</div>
        <div class="stat-label">Aktif</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $siswa->where('jenis_kelamin','L')->count() }}</div>
        <div class="stat-label">Laki-laki</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $siswa->where('jenis_kelamin','P')->count() }}</div>
        <div class="stat-label">Perempuan</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th style="width:22px" class="center">#</th>
            <th style="width:60px">NIS</th>
            <th style="width:65px">NISN</th>
            <th>Nama Lengkap</th>
            <th style="width:28px" class="center">JK</th>
            <th style="width:70px">Tgl Lahir</th>
            <th style="width:55px">No. HP</th>
            <th style="width:55px">Kelas</th>
            <th style="width:46px" class="center">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($siswa as $i => $s)
        <tr>
            <td class="center" style="color:#94a3b8;font-weight:bold">{{ $i + 1 }}</td>
            <td>{{ $s->nis }}</td>
            <td style="color:#64748b">{{ $s->nisn ?? '-' }}</td>
            <td>
                <div class="nama">{{ $s->nama_lengkap }}</div>
                @if($s->email)<div class="sub">{{ $s->email }}</div>@endif
            </td>
            <td class="center">
                <span class="badge badge-{{ strtolower($s->jenis_kelamin) }}">{{ $s->jenis_kelamin }}</span>
            </td>
            <td>{{ $s->tanggal_lahir ? $s->tanggal_lahir->format('d/m/Y') : '-' }}</td>
            <td>{{ $s->no_hp ?? '-' }}</td>
            <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
            <td class="center">
                @php
                    $stMap = ['aktif'=>'aktif','tidak_aktif'=>'nonaktif','lulus'=>'lulus','pindah'=>'pindah','keluar'=>'keluar'];
                    $stClass = $stMap[$s->status] ?? 'nonaktif';
                @endphp
                <span class="badge badge-{{ $stClass }}">{{ ucfirst(str_replace('_',' ',$s->status)) }}</span>
            </td>
        </tr>
        @empty
        <tr><td colspan="9" style="text-align:center;color:#94a3b8;padding:20px">Tidak ada data</td></tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    <div class="footer-left">Sistem Informasi Sekolah &mdash; Dicetak oleh: {{ auth()->user()->name }}</div>
    <div class="footer-right">{{ now()->format('d/m/Y H:i') }}</div>
</div>

</body>
</html>