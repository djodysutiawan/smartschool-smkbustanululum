<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Kategori Pelanggaran</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #0f172a; background: #fff; }
    .header { border-bottom: 2px solid #1f63db; padding-bottom: 12px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: flex-end; }
    .header-left h1 { font-size: 16px; font-weight: 700; color: #0f172a; }
    .header-left p { font-size: 10px; color: #64748b; margin-top: 3px; }
    .header-right { text-align: right; font-size: 10px; color: #64748b; }
    .meta-row { display: flex; gap: 20px; margin-bottom: 14px; font-size: 10px; color: #475569; }
    .meta-item strong { color: #0f172a; }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: #1f63db; }
    thead th { padding: 8px 10px; text-align: left; font-size: 10px; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: .04em; }
    thead th.center { text-align: center; }
    tbody tr:nth-child(even) { background: #f8fafc; }
    tbody tr { border-bottom: 1px solid #e2e8f0; }
    td { padding: 7px 10px; font-size: 10.5px; vertical-align: middle; }
    td.center { text-align: center; }
    .tingkat-ringan { background: #dbeafe; color: #1d4ed8; padding: 2px 7px; border-radius: 4px; font-weight: 700; font-size: 9.5px; }
    .tingkat-sedang { background: #fef9c3; color: #a16207; padding: 2px 7px; border-radius: 4px; font-weight: 700; font-size: 9.5px; }
    .tingkat-berat { background: #fee2e2; color: #dc2626; padding: 2px 7px; border-radius: 4px; font-weight: 700; font-size: 9.5px; }
    .status-aktif { background: #dcfce7; color: #15803d; padding: 2px 7px; border-radius: 4px; font-weight: 700; font-size: 9.5px; }
    .status-nonaktif { background: #f1f5f9; color: #64748b; padding: 2px 7px; border-radius: 4px; font-weight: 700; font-size: 9.5px; }
    .footer { margin-top: 20px; padding-top: 10px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; font-size: 9px; color: #94a3b8; }
</style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <h1>Data Kategori Pelanggaran</h1>
            <p>Laporan kategori pelanggaran siswa{{ $filterLabel ? ' — Filter: ' . $filterLabel : '' }}</p>
        </div>
        <div class="header-right">
            <p>Dicetak: {{ now()->format('d M Y, H:i') }}</p>
            <p>Total: {{ $kategori->count() }} kategori</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:32px">No</th>
                <th>Nama Kategori</th>
                <th>Tingkat</th>
                <th class="center">Poin Default</th>
                <th class="center">Batas Poin</th>
                <th class="center">Jml. Kasus</th>
                <th class="center">Status</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategori as $i => $k)
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td style="font-weight:600;">{{ $k->nama }}</td>
                <td><span class="tingkat-{{ $k->tingkat }}">{{ ucfirst($k->tingkat) }}</span></td>
                <td class="center" style="font-weight:700;">{{ $k->poin_default }}</td>
                <td class="center">{{ $k->batas_poin ?? '—' }}</td>
                <td class="center">{{ $k->pelanggaran_count }}</td>
                <td class="center">
                    @if($k->is_active)
                        <span class="status-aktif">Aktif</span>
                    @else
                        <span class="status-nonaktif">Nonaktif</span>
                    @endif
                </td>
                <td style="color:#64748b;font-size:9.5px;">{{ \Illuminate\Support\Str::limit($k->deskripsi, 60) ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <span>Sistem Informasi Sekolah</span>
        <span>Dicetak oleh: {{ auth()->user()->name ?? 'Admin' }}</span>
    </div>
</body>
</html>