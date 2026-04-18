<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Pelanggaran Siswa</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 10.5px; color: #0f172a; background: #fff; }
    .header { border-bottom: 2px solid #dc2626; padding-bottom: 12px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: flex-end; }
    .header-left h1 { font-size: 16px; font-weight: 700; color: #0f172a; }
    .header-left p { font-size: 10px; color: #64748b; margin-top: 3px; }
    .header-right { text-align: right; font-size: 10px; color: #64748b; }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: #dc2626; }
    thead th { padding: 8px 9px; text-align: left; font-size: 9.5px; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: .04em; }
    thead th.center { text-align: center; }
    tbody tr:nth-child(even) { background: #f8fafc; }
    tbody tr { border-bottom: 1px solid #e2e8f0; }
    td { padding: 7px 9px; font-size: 10px; vertical-align: middle; }
    td.center { text-align: center; }
    .st-pending { background:#f1f5f9;color:#64748b;padding:2px 6px;border-radius:4px;font-weight:700;font-size:9px; }
    .st-diproses { background:#dbeafe;color:#1d4ed8;padding:2px 6px;border-radius:4px;font-weight:700;font-size:9px; }
    .st-selesai { background:#dcfce7;color:#15803d;padding:2px 6px;border-radius:4px;font-weight:700;font-size:9px; }
    .st-banding { background:#fef9c3;color:#a16207;padding:2px 6px;border-radius:4px;font-weight:700;font-size:9px; }
    .tk-ringan { background:#dbeafe;color:#1d4ed8;padding:1px 5px;border-radius:3px;font-size:9px;font-weight:700; }
    .tk-sedang { background:#fef9c3;color:#a16207;padding:1px 5px;border-radius:3px;font-size:9px;font-weight:700; }
    .tk-berat { background:#fee2e2;color:#dc2626;padding:1px 5px;border-radius:3px;font-size:9px;font-weight:700; }
    .footer { margin-top: 20px; padding-top: 10px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; font-size: 9px; color: #94a3b8; }
</style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <h1>Data Pelanggaran Siswa</h1>
            <p>Laporan pelanggaran{{ $filterLabel ? ' — Filter: ' . $filterLabel : '' }}</p>
        </div>
        <div class="header-right">
            <p>Dicetak: {{ now()->format('d M Y, H:i') }}</p>
            <p>Total: {{ $pelanggaran->count() }} kasus</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:28px">No</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Kategori</th>
                <th class="center">Poin</th>
                <th>Tanggal</th>
                <th class="center">Status</th>
                <th>Dicatat Oleh</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pelanggaran as $i => $p)
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td>
                    <strong>{{ $p->siswa->nama_lengkap ?? '—' }}</strong><br>
                    <span style="color:#64748b">{{ $p->siswa->nis ?? '' }}</span>
                </td>
                <td>{{ $p->siswa->kelas->nama_kelas ?? '—' }}</td>
                <td>
                    {{ $p->kategori->nama ?? '—' }}<br>
                    @if($p->kategori)
                    <span class="tk-{{ $p->kategori->tingkat }}">{{ ucfirst($p->kategori->tingkat) }}</span>
                    @endif
                </td>
                <td class="center" style="font-weight:700;">{{ $p->poin }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                <td class="center">
                    <span class="st-{{ $p->status }}">{{ ucfirst($p->status) }}</span>
                </td>
                <td>{{ $p->dicatatOleh->name ?? '—' }}</td>
                <td style="color:#475569;font-size:9px;">{{ \Illuminate\Support\Str::limit($p->deskripsi, 50) }}</td>
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