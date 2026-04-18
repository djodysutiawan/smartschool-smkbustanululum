<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengumpulan Tugas</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 11px; color: #1e293b; background: #fff; }

        .header { padding: 20px 24px 16px; border-bottom: 2px solid #1f63db; margin-bottom: 18px; }
        .header-top { display: flex; justify-content: space-between; align-items: flex-start; }
        .school-name { font-size: 15px; font-weight: 700; color: #0f172a; }
        .school-sub { font-size: 10px; color: #64748b; margin-top: 2px; }
        .doc-title { text-align: right; }
        .doc-title h1 { font-size: 14px; font-weight: 700; color: #1f63db; }
        .doc-title p { font-size: 10px; color: #64748b; margin-top: 2px; }
        .doc-meta { margin-top: 10px; font-size: 10px; color: #64748b; }

        .stats-row { display: flex; gap: 12px; margin-bottom: 16px; padding: 0 4px; }
        .stat-box { flex: 1; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 12px; text-align: center; }
        .stat-box .val { font-size: 18px; font-weight: 700; color: #0f172a; }
        .stat-box .lbl { font-size: 9px; color: #64748b; text-transform: uppercase; letter-spacing: .05em; margin-top: 2px; }
        .stat-box.blue { border-color: #bfdbfe; background: #eff6ff; }
        .stat-box.green { border-color: #bbf7d0; background: #f0fdf4; }
        .stat-box.yellow { border-color: #fde68a; background: #fefce8; }
        .stat-box.red { border-color: #fecaca; background: #fff0f0; }
        .stat-box.blue .val { color: #1d4ed8; }
        .stat-box.green .val { color: #15803d; }
        .stat-box.yellow .val { color: #a16207; }
        .stat-box.red .val { color: #dc2626; }

        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #1f63db; }
        thead th { padding: 8px 10px; text-align: left; font-size: 10px; font-weight: 700; color: #fff; letter-spacing: .04em; text-transform: uppercase; }
        thead th.center { text-align: center; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr { border-bottom: 1px solid #e2e8f0; }
        td { padding: 7px 10px; font-size: 10.5px; color: #334155; vertical-align: middle; }
        td.center { text-align: center; }
        td.bold { font-weight: 700; color: #0f172a; }

        .status-pill { display: inline-block; padding: 2px 8px; border-radius: 99px; font-size: 9.5px; font-weight: 700; }
        .s-sudah_dinilai { background: #dcfce7; color: #15803d; }
        .s-dikumpulkan { background: #dbeafe; color: #1d4ed8; }
        .s-terlambat { background: #fee2e2; color: #dc2626; }
        .s-belum_dikumpulkan { background: #f1f5f9; color: #64748b; }

        .nilai-pill { display: inline-block; padding: 2px 8px; border-radius: 5px; font-size: 10px; font-weight: 700; }
        .n-high { background: #dcfce7; color: #15803d; }
        .n-mid { background: #dbeafe; color: #1d4ed8; }
        .n-low { background: #fee2e2; color: #dc2626; }

        .footer { margin-top: 24px; padding-top: 10px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .footer p { font-size: 9.5px; color: #94a3b8; }
    </style>
</head>
<body>

<div class="header">
    <div class="header-top">
        <div>
            <p class="school-name">Sistem Informasi Sekolah</p>
            <p class="school-sub">Laporan Data Pengumpulan Tugas</p>
        </div>
        <div class="doc-title">
            <h1>Laporan Pengumpulan Tugas</h1>
            <p>Dicetak: {{ now()->format('d M Y, H:i') }}</p>
        </div>
    </div>
    <p class="doc-meta">Total data: {{ $pengumpulan->count() }} pengumpulan</p>
</div>

@php
    $total        = $pengumpulan->count();
    $sudahDinilai = $pengumpulan->where('status', 'sudah_dinilai')->count();
    $menunggu     = $pengumpulan->where('status', 'dikumpulkan')->count();
    $terlambat    = $pengumpulan->where('status', 'terlambat')->count();
    $belum        = $pengumpulan->where('status', 'belum_dikumpulkan')->count();
@endphp

<div class="stats-row">
    <div class="stat-box blue">
        <p class="val">{{ $total }}</p>
        <p class="lbl">Total</p>
    </div>
    <div class="stat-box green">
        <p class="val">{{ $sudahDinilai }}</p>
        <p class="lbl">Sudah Dinilai</p>
    </div>
    <div class="stat-box yellow">
        <p class="val">{{ $menunggu }}</p>
        <p class="lbl">Menunggu</p>
    </div>
    <div class="stat-box red">
        <p class="val">{{ $terlambat }}</p>
        <p class="lbl">Terlambat</p>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th style="width:32px">#</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Judul Tugas</th>
            <th>Mata Pelajaran</th>
            <th>Dikumpulkan</th>
            <th class="center">Status</th>
            <th class="center">Nilai</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pengumpulan as $i => $p)
        <tr>
            <td class="center">{{ $i + 1 }}</td>
            <td class="bold">{{ $p->siswa->nama_lengkap ?? '-' }}</td>
            <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
            <td>{{ \Illuminate\Support\Str::limit($p->tugas->judul ?? '-', 35) }}</td>
            <td>{{ $p->tugas->mataPelajaran->nama_mapel ?? '-' }}</td>
            <td>
                {{ $p->dikumpulkan_pada
                    ? $p->dikumpulkan_pada->format('d M Y, H:i')
                    : ($p->created_at ? $p->created_at->format('d M Y') : '-') }}
            </td>
            <td class="center">
                <span class="status-pill s-{{ $p->status }}">
                    {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                </span>
            </td>
            <td class="center">
                @if($p->nilai !== null)
                    @php
                        $nc = $p->nilai >= 80 ? 'n-high' : ($p->nilai >= 60 ? 'n-mid' : 'n-low');
                    @endphp
                    <span class="nilai-pill {{ $nc }}">{{ $p->nilai }}</span>
                @else
                    <span style="color:#94a3b8">—</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align:center;padding:20px;color:#94a3b8;font-style:italic">
                Tidak ada data pengumpulan.
            </td>
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