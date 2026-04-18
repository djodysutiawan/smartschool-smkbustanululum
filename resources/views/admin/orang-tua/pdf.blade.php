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
    .stat  { display: table-cell; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 8px 12px; text-align: center; width: 33.3%; }
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

    .badge-ada  { background: #dcfce7; color: #15803d; display: inline-block; padding: 2px 7px; border-radius: 99px; font-size: 7.5px; font-weight: bold; }
    .badge-tdk  { background: #fef9c3; color: #a16207; display: inline-block; padding: 2px 7px; border-radius: 99px; font-size: 7.5px; font-weight: bold; }

    .footer { margin-top: 14px; padding-top: 8px; border-top: 1px solid #e2e8f0; display: table; width: 100%; font-size: 8px; color: #94a3b8; }
    .footer-left  { display: table-cell; }
    .footer-right { display: table-cell; text-align: right; }
    .nama { font-weight: bold; color: #0f172a; }
    .sub  { color: #64748b; font-size: 8px; }
</style>
</head>
<body>

<div class="header">
    <h1>📋 Data Orang Tua / Wali</h1>
    <p>Laporan data orang tua/wali siswa — dicetak {{ now()->format('d F Y, H:i') }} WIB</p>
    <div class="header-meta">Total: {{ $orangTua->count() }} orang tua</div>
</div>

<div class="stats">
    <div class="stat">
        <div class="stat-val">{{ $orangTua->count() }}</div>
        <div class="stat-label">Total</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $orangTua->filter(fn($o) => $o->siswa->count() > 0)->count() }}</div>
        <div class="stat-label">Punya Anak Terdaftar</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $orangTua->filter(fn($o) => $o->pengguna)->count() }}</div>
        <div class="stat-label">Punya Akun Sistem</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th style="width:22px" class="center">#</th>
            <th>Nama Lengkap</th>
            <th style="width:70px">No. HP</th>
            <th style="width:70px">Email</th>
            <th style="width:70px">Pekerjaan</th>
            <th>Anak Terdaftar</th>
            <th style="width:50px" class="center">Akun</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orangTua as $i => $ot)
        <tr>
            <td class="center" style="color:#94a3b8;font-weight:bold">{{ $i + 1 }}</td>
            <td>
                <div class="nama">{{ $ot->nama_lengkap }}</div>
                @if($ot->alamat)<div class="sub">{{ Str::limit($ot->alamat, 40) }}</div>@endif
            </td>
            <td>{{ $ot->no_hp }}</td>
            <td style="font-size:8px">{{ $ot->email ?? '-' }}</td>
            <td>{{ $ot->pekerjaan ?? '-' }}</td>
            <td>
                @if($ot->siswa->count() > 0)
                    @foreach($ot->siswa as $s)
                        <div>{{ $s->nama_lengkap }} <span style="color:#64748b">({{ $s->kelas->nama_kelas ?? '-' }}, {{ ucfirst(str_replace('_',' ',$s->pivot->hubungan ?? 'orang_tua')) }})</span></div>
                    @endforeach
                @else
                    <span style="color:#94a3b8">—</span>
                @endif
            </td>
            <td class="center">
                @if($ot->pengguna)
                    <span class="badge-ada">✓</span>
                @else
                    <span class="badge-tdk">—</span>
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:20px">Tidak ada data</td></tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    <div class="footer-left">Sistem Informasi Sekolah &mdash; Dicetak oleh: {{ auth()->user()->name }}</div>
    <div class="footer-right">{{ now()->format('d/m/Y H:i') }}</div>
</div>

</body>
</html>