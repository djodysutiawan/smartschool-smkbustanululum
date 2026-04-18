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
    tbody tr:hover { background: #eef6ff; }
    td { padding: 6px 8px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    td.center { text-align: center; }

    .badge { display: inline-block; padding: 2px 7px; border-radius: 99px; font-size: 7.5px; font-weight: bold; }
    .badge-aktif    { background: #dcfce7; color: #15803d; }
    .badge-cuti     { background: #fef9c3; color: #a16207; }
    .badge-nonaktif { background: #fee2e2; color: #dc2626; }
    .badge-pns      { background: #eef2ff; color: #4338ca; }
    .badge-honorer  { background: #eef6ff; color: #1f63db; }
    .badge-kontrak  { background: #fff7ed; color: #c2410c; }
    .badge-cpns     { background: #f0fdf4; color: #15803d; }
    .badge-piket    { background: #fdf4ff; color: #7c3aed; }

    .footer { margin-top: 14px; padding-top: 8px; border-top: 1px solid #e2e8f0; display: table; width: 100%; font-size: 8px; color: #94a3b8; }
    .footer-left  { display: table-cell; }
    .footer-right { display: table-cell; text-align: right; }

    .no-col { color: #94a3b8; font-weight: bold; }
    .nama   { font-weight: bold; color: #0f172a; }
    .sub    { color: #64748b; font-size: 8px; }
</style>
</head>
<body>

<div class="header">
    <h1>📋 Data Guru</h1>
    <p>Laporan lengkap data guru — dicetak {{ now()->format('d F Y, H:i') }} WIB</p>
    <div class="header-meta">
        Total: {{ $guru->count() }} guru<br>
        Filter: {{ $filterLabel }}
    </div>
</div>

{{-- Stats --}}
<div class="stats">
    <div class="stat">
        <div class="stat-val">{{ $guru->count() }}</div>
        <div class="stat-label">Total</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $guru->where('status','aktif')->count() }}</div>
        <div class="stat-label">Aktif</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $guru->where('adalah_guru_piket',true)->count() }}</div>
        <div class="stat-label">Guru Piket</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $guru->where('status_kepegawaian','pns')->count() }}</div>
        <div class="stat-label">PNS</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th style="width:22px" class="center">#</th>
            <th style="width:80px">NIP</th>
            <th>Nama Lengkap</th>
            <th style="width:32px" class="center">JK</th>
            <th>No. HP</th>
            <th>Pendidikan</th>
            <th style="width:55px" class="center">Kepegawaian</th>
            <th style="width:50px" class="center">Piket</th>
            <th style="width:46px" class="center">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($guru as $i => $g)
        <tr>
            <td class="center no-col">{{ $i + 1 }}</td>
            <td style="font-size:8px">{{ $g->nip ?? '-' }}</td>
            <td>
                <div class="nama">{{ $g->nama_lengkap }}</div>
                @if($g->email)<div class="sub">{{ $g->email }}</div>@endif
            </td>
            <td class="center">{{ $g->jenis_kelamin === 'L' ? 'L' : 'P' }}</td>
            <td>{{ $g->no_hp ?? '-' }}</td>
            <td>
                <span style="font-weight:bold">{{ strtoupper($g->pendidikan_terakhir ?? '-') }}</span>
                @if($g->jurusan_pendidikan)<div class="sub">{{ $g->jurusan_pendidikan }}</div>@endif
            </td>
            <td class="center">
                <span class="badge badge-{{ $g->status_kepegawaian }}">{{ strtoupper($g->status_kepegawaian) }}</span>
            </td>
            <td class="center">
                @if($g->adalah_guru_piket)
                    <span class="badge badge-piket">Piket</span>
                @else
                    <span style="color:#94a3b8">—</span>
                @endif
            </td>
            <td class="center">
                <span class="badge badge-{{ $g->status === 'tidak_aktif' ? 'nonaktif' : $g->status }}">
                    {{ ucfirst(str_replace('_',' ',$g->status)) }}
                </span>
            </td>
        </tr>
        @empty
        <tr><td colspan="9" style="text-align:center;color:#94a3b8;padding:20px">Tidak ada data</td></tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    <div class="footer-left">Sistem Informasi Sekolah &mdash; Dicetak oleh: {{ auth()->user()->name }}</div>
    <div class="footer-right">Halaman <span style="font-weight:bold">1</span> — {{ now()->format('d/m/Y H:i') }}</div>
</div>

</body>
</html>