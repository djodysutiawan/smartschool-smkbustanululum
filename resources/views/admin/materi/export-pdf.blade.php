<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Materi Pelajaran</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 9px; color: #1e293b; background: #fff; }

        .header { padding: 18px 24px 14px; border-bottom: 2px solid #1f63db; margin-bottom: 16px; }
        .header-top { display: flex; align-items: flex-start; justify-content: space-between; }
        .school-name { font-size: 13px; font-weight: 700; color: #1f63db; }
        .doc-title   { font-size: 10px; color: #64748b; margin-top: 2px; }
        .doc-meta p  { font-size: 8.5px; color: #94a3b8; line-height: 1.6; text-align: right; }
        .doc-badge   { display: inline-block; background: #1f63db; color: #fff; font-size: 8px; font-weight: 700; padding: 2px 8px; border-radius: 3px; margin-top: 4px; letter-spacing: .05em; text-transform: uppercase; }

        .summary-strip { display: flex; gap: 10px; margin-bottom: 14px; }
        .summary-box { flex: 1; border: 1px solid #e2e8f0; border-radius: 5px; padding: 8px 12px; background: #f8fafc; }
        .summary-box .s-label { font-size: 7.5px; color: #94a3b8; text-transform: uppercase; letter-spacing: .06em; font-weight: 700; }
        .summary-box .s-val   { font-size: 14px; font-weight: 800; color: #0f172a; margin-top: 1px; }

        table { width: 100%; border-collapse: collapse; font-size: 8px; }
        thead tr { background: #1f63db; }
        thead th { padding: 7px 8px; text-align: left; color: #fff; font-weight: 700; font-size: 7.5px; letter-spacing: .05em; text-transform: uppercase; white-space: nowrap; }
        thead th.center { text-align: center; }
        tbody tr:nth-child(odd)  { background: #fff; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr { border-bottom: 1px solid #e2e8f0; }
        td { padding: 6px 8px; vertical-align: top; line-height: 1.5; }
        td.center { text-align: center; }
        td.muted { color: #64748b; }

        .judul-wrap .jname { font-weight: 700; font-size: 8.5px; color: #0f172a; }
        .judul-wrap .jsub  { font-size: 7.5px; color: #94a3b8; margin-top: 1px; }

        .badge { display: inline-block; padding: 2px 6px; border-radius: 99px; font-size: 7px; font-weight: 700; white-space: nowrap; }
        .badge-pub   { background: #dcfce7; color: #15803d; }
        .badge-draft { background: #f1f5f9;  color: #64748b; }

        .jenis-pill { display: inline-block; padding: 1px 6px; border-radius: 3px; font-size: 7px; font-weight: 700; }
        .jenis-file  { background: #eef6ff; color: #1750c0; }
        .jenis-video { background: #fdf4ff; color: #7c3aed; }
        .jenis-link  { background: #f0fdf4; color: #15803d; }
        .jenis-teks  { background: #fff7ed; color: #c2410c; }

        .no-col { font-size: 8px; font-weight: 700; color: #94a3b8; }

        .footer { margin-top: 16px; padding-top: 10px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .footer p { font-size: 7.5px; color: #94a3b8; }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-top">
            <div>
                <p class="school-name">Sistem Informasi Sekolah</p>
                <p class="doc-title">Laporan Data Materi Pelajaran</p>
            </div>
            <div class="doc-meta">
                <p>Dicetak: {{ now()->format('d M Y, H:i') }}</p>
                <p>Total Data: {{ $materi->count() }} materi</p>
                <span class="doc-badge">Materi &amp; LMS</span>
            </div>
        </div>
    </div>

    <div class="summary-strip">
        <div class="summary-box">
            <p class="s-label">Total</p>
            <p class="s-val">{{ $materi->count() }}</p>
        </div>
        <div class="summary-box">
            <p class="s-label">Dipublikasikan</p>
            <p class="s-val">{{ $materi->where('dipublikasikan', true)->count() }}</p>
        </div>
        <div class="summary-box">
            <p class="s-label">Draft</p>
            <p class="s-val">{{ $materi->where('dipublikasikan', false)->count() }}</p>
        </div>
        <div class="summary-box">
            <p class="s-label">Jenis File</p>
            <p class="s-val">{{ $materi->where('jenis', 'file')->count() }}</p>
        </div>
        <div class="summary-box">
            <p class="s-label">Jenis Video</p>
            <p class="s-val">{{ $materi->where('jenis', 'video')->count() }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="center" style="width:24px">#</th>
                <th style="width:150px">Judul Materi</th>
                <th>Guru</th>
                <th>Mapel</th>
                <th>Kelas</th>
                <th>Tahun Ajaran</th>
                <th class="center">Jenis</th>
                <th class="center">Urutan</th>
                <th>Dipublikasikan Pada</th>
                <th class="center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($materi as $i => $m)
            <tr>
                <td class="center"><span class="no-col">{{ $i + 1 }}</span></td>
                <td>
                    <div class="judul-wrap">
                        <p class="jname">{{ $m->judul }}</p>
                        @if($m->deskripsi)
                            <p class="jsub">{{ \Illuminate\Support\Str::limit($m->deskripsi, 55) }}</p>
                        @endif
                    </div>
                </td>
                <td class="muted">{{ $m->guru->nama_lengkap ?? '-' }}</td>
                <td class="muted">{{ $m->mataPelajaran->nama_mapel ?? '-' }}</td>
                <td class="muted">{{ $m->kelas->nama_kelas ?? '-' }}</td>
                <td class="muted">{{ $m->tahunAjaran->tahun ?? '-' }}</td>
                <td class="center">
                    <span class="jenis-pill jenis-{{ $m->jenis }}">{{ ucfirst($m->jenis) }}</span>
                </td>
                <td class="center muted">{{ $m->urutan ?? '—' }}</td>
                <td class="muted">
                    {{ $m->dipublikasikan_pada ? \Carbon\Carbon::parse($m->dipublikasikan_pada)->format('d M Y') : '—' }}
                </td>
                <td class="center">
                    @if($m->dipublikasikan)
                        <span class="badge badge-pub">Publikasi</span>
                    @else
                        <span class="badge badge-draft">Draft</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align:center;padding:20px;color:#94a3b8;font-style:italic">
                    Tidak ada data materi yang ditemukan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini digenerate otomatis oleh Sistem Informasi Sekolah</p>
        <p>{{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

</body>
</html>