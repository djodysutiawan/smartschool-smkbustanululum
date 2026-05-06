<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 9px; color: #1e293b; }
    .header { background: #1f63db; color: #fff; padding: 13px 18px; margin-bottom: 14px; border-radius: 6px; }
    .header h1 { font-size: 15px; font-weight: bold; margin-bottom: 2px; }
    .header p  { font-size: 9px; opacity: .85; }
    .stats { display: table; width: 100%; margin-bottom: 12px; }
    .stat  { display: table-cell; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 8px 12px; text-align: center; }
    .stat + .stat { border-left: none; }
    .stat-val   { font-size: 17px; font-weight: bold; color: #1f63db; }
    .stat-label { font-size: 8px; color: #64748b; margin-top: 2px; text-transform: uppercase; letter-spacing: .04em; }
    table { width: 100%; border-collapse: collapse; font-size: 8.5px; }
    thead th { background: #1f63db; color: #fff; padding: 7px 8px; text-align: left; font-size: 8px; text-transform: uppercase; letter-spacing: .04em; }
    thead th.center { text-align: center; }
    tbody tr:nth-child(even) { background: #f8fafc; }
    td { padding: 6px 8px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    td.center { text-align: center; }
    .badge { display: inline-block; padding: 2px 8px; border-radius: 99px; font-size: 7.5px; font-weight: bold; }
    .badge-tersedia    { background: #dcfce7; color: #15803d; }
    .badge-nontersedia { background: #fee2e2; color: #dc2626; }
    .hari-pill { display: inline-block; padding: 2px 7px; border-radius: 4px; font-size: 7.5px; font-weight: bold; background: #eef6ff; color: #1f63db; }
    .text-muted { color: #94a3b8; font-style: italic; }
    .footer { margin-top: 12px; padding-top: 8px; border-top: 1px solid #e2e8f0; display: table; width: 100%; font-size: 8px; color: #94a3b8; }
    .footer-left  { display: table-cell; }
    .footer-right { display: table-cell; text-align: right; }
</style>
</head>
<body>

<div class="header">
    {{-- FIX: Hapus emoji (tidak didukung DomPDF/DejaVu Sans) --}}
    <h1>Data Ketersediaan Guru</h1>
    <p>
        Laporan ketersediaan mengajar guru &mdash; dicetak {{ now()->translatedFormat('d F Y, H:i') }} WIB
        @if($filterGuru) | Guru: {{ $filterGuru }} @endif
    </p>
</div>

@php
    $totalSlot   = $ketersediaan->count();
    $totalYa     = $ketersediaan->where('tersedia', true)->count();
    $totalTidak  = $ketersediaan->where('tersedia', false)->count();
    $totalGuru   = $ketersediaan->unique('guru_id')->count();
@endphp

<div class="stats">
    <div class="stat">
        <div class="stat-val">{{ $totalSlot }}</div>
        <div class="stat-label">Total Slot</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $totalYa }}</div>
        <div class="stat-label">Tersedia</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $totalTidak }}</div>
        <div class="stat-label">Tidak Tersedia</div>
    </div>
    <div class="stat">
        <div class="stat-val">{{ $totalGuru }}</div>
        <div class="stat-label">Guru Terdaftar</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th style="width:22px" class="center">#</th>
            <th>Nama Guru</th>
            <th class="center" style="width:48px">Hari</th>
            <th class="center" style="width:46px">Mulai</th>
            <th class="center" style="width:46px">Selesai</th>
            <th>Mata Pelajaran</th>
            <th>Jurusan</th>
            <th class="center" style="width:62px">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($ketersediaan as $i => $k)
        <tr>
            <td class="center" style="color:#94a3b8;font-weight:bold">{{ $i + 1 }}</td>
            <td style="font-weight:bold">
                {{ $k->guru?->nama_lengkap ?? '-' }}
                @if($k->guru?->nip)
                    <br><span style="font-weight:normal;color:#94a3b8;font-size:7.5px">{{ $k->guru->nip }}</span>
                @endif
            </td>
            <td class="center">
                <span class="hari-pill">{{ ucfirst($k->hari) }}</span>
            </td>
            {{-- FIX: format jam dengan Carbon agar selalu H:i, bukan raw string --}}
            <td class="center" style="font-weight:bold">
                {{ \Carbon\Carbon::parse($k->jam_mulai)->format('H:i') }}
            </td>
            <td class="center" style="font-weight:bold">
                {{ \Carbon\Carbon::parse($k->jam_selesai)->format('H:i') }}
            </td>
            {{-- FIX: Tambah kolom mapel & jurusan yang sebelumnya tidak ada --}}
            <td>
                @if($k->mataPelajaran)
                    {{ $k->mataPelajaran->nama_mapel }}
                    @if($k->mataPelajaran->scope === 'umum')
                        <span style="color:#1f63db;font-size:7px">(Umum)</span>
                    @endif
                @else
                    <span class="text-muted">Bebas</span>
                @endif
            </td>
            <td>
                {{-- FIX: kolom DB adalah `nama`, bukan `nama_jurusan` --}}
                {{ $k->jurusan?->nama ?? '—' }}
            </td>
            <td class="center">
                <span class="badge badge-{{ $k->tersedia ? 'tersedia' : 'nontersedia' }}">
                    {{ $k->tersedia ? 'Tersedia' : 'Tidak Tersedia' }}
                </span>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align:center;color:#94a3b8;padding:20px">
                Tidak ada data ketersediaan
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    <div class="footer-left">
        Sistem Informasi Sekolah &mdash; Dicetak oleh: {{ auth()->user()->name ?? '-' }}
    </div>
    <div class="footer-right">{{ now()->format('d/m/Y H:i') }}</div>
</div>

</body>
</html>