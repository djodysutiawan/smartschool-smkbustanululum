<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tugas</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 9px; color: #1e293b; background: #fff; }

        .header { padding: 18px 24px 14px; border-bottom: 2px solid #1f63db; margin-bottom: 16px; }
        .header-top { display: flex; align-items: flex-start; justify-content: space-between; }
        .school-name { font-size: 13px; font-weight: 700; color: #1f63db; letter-spacing: .02em; }
        .doc-title { font-size: 10px; color: #64748b; margin-top: 2px; }
        .doc-meta { text-align: right; }
        .doc-meta p { font-size: 8.5px; color: #94a3b8; line-height: 1.6; }
        .doc-badge { display: inline-block; background: #1f63db; color: #fff; font-size: 8px; font-weight: 700; padding: 2px 8px; border-radius: 3px; margin-top: 4px; letter-spacing: .05em; text-transform: uppercase; }

        .summary-strip { display: flex; gap: 10px; margin-bottom: 14px; padding: 0 4px; }
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
        .badge-publish  { background: #dcfce7; color: #15803d; }
        .badge-draft    { background: #f1f5f9;  color: #64748b; }

        .jenis-pill { display: inline-block; padding: 1px 6px; border-radius: 3px; font-size: 7px; font-weight: 700; }
        .jenis-file  { background: #eef6ff; color: #1750c0; }
        .jenis-teks  { background: #f0fdf4; color: #15803d; }
        .jenis-link  { background: #fdf4ff; color: #7c3aed; }
        .jenis-foto  { background: #fff7ed; color: #c2410c; }

        .deadline-lewat { color: #dc2626; font-weight: 700; }

        .no-col { font-size: 8px; font-weight: 700; color: #94a3b8; }

        .footer { margin-top: 16px; padding-top: 10px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .footer p { font-size: 7.5px; color: #94a3b8; }
        .footer .page-num { font-size: 7.5px; color: #94a3b8; }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-top">
            <div>
                <p class="school-name">Sistem Informasi Sekolah</p>
                <p class="doc-title">Laporan Data Tugas Pembelajaran</p>
            </div>
            <div class="doc-meta">
                <p>Dicetak: {{ now()->format('d M Y, H:i') }}</p>
                <p>Total Data: {{ $tugas->count() }} tugas</p>
                <span class="doc-badge">Tugas &amp; LMS</span>
            </div>
        </div>
    </div>

    <div class="summary-strip">
        <div class="summary-box">
            <p class="s-label">Total</p>
            <p class="s-val">{{ $tugas->count() }}</p>
        </div>
        <div class="summary-box">
            <p class="s-label">Dipublikasikan</p>
            <p class="s-val">{{ $tugas->where('dipublikasikan', true)->count() }}</p>
        </div>
        <div class="summary-box">
            <p class="s-label">Draft</p>
            <p class="s-val">{{ $tugas->where('dipublikasikan', false)->count() }}</p>
        </div>
        <div class="summary-box">
            <p class="s-label">Sudah Lewat Deadline</p>
            <p class="s-val">{{ $tugas->filter(fn($t) => now()->gt($t->batas_waktu))->count() }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="center" style="width:26px">#</th>
                <th style="width:160px">Judul Tugas</th>
                <th>Guru</th>
                <th>Mapel</th>
                <th>Kelas</th>
                <th>Tahun Ajaran</th>
                <th class="center">Jenis</th>
                <th>Batas Waktu</th>
                <th class="center">Nilai Maks</th>
                <th class="center">Terlambat</th>
                <th class="center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tugas as $i => $t)
            <tr>
                <td class="center"><span class="no-col">{{ $i + 1 }}</span></td>
                <td>
                    <div class="judul-wrap">
                        <p class="jname">{{ $t->judul }}</p>
                        @if($t->deskripsi)
                            <p class="jsub">{{ \Illuminate\Support\Str::limit($t->deskripsi, 60) }}</p>
                        @endif
                    </div>
                </td>
                <td class="muted">{{ $t->guru->nama_lengkap ?? '-' }}</td>
                <td class="muted">{{ $t->mataPelajaran->nama_mapel ?? '-' }}</td>
                <td class="muted">{{ $t->kelas->nama_kelas ?? '-' }}</td>
                <td class="muted">{{ $t->tahunAjaran->tahun ?? '-' }}</td>
                <td class="center">
                    <span class="jenis-pill jenis-{{ $t->jenis_pengumpulan }}">{{ ucfirst($t->jenis_pengumpulan) }}</span>
                </td>
                <td>
                    <span class="{{ now()->gt($t->batas_waktu) ? 'deadline-lewat' : '' }}">
                        {{ \Carbon\Carbon::parse($t->batas_waktu)->format('d M Y') }}
                    </span>
                    <br><span style="color:#94a3b8;font-size:7px">{{ \Carbon\Carbon::parse($t->batas_waktu)->format('H:i') }}</span>
                </td>
                <td class="center muted">{{ $t->nilai_maksimal ?? 100 }}</td>
                <td class="center muted">{{ $t->izinkan_terlambat ? 'Ya' : 'Tidak' }}</td>
                <td class="center">
                    @if($t->dipublikasikan)
                        <span class="badge badge-publish">Publikasi</span>
                    @else
                        <span class="badge badge-draft">Draft</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="11" style="text-align:center;padding:20px;color:#94a3b8;font-style:italic">
                    Tidak ada data tugas yang ditemukan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini digenerate otomatis oleh Sistem Informasi Sekolah</p>
        <p class="page-num">{{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

</body>
</html>