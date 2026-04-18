<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Data Ujian</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1e293b; background: #fff; }

    .header { padding: 20px 28px 16px; border-bottom: 2px solid #1f63db; margin-bottom: 18px; }
    .school-name { font-size: 15px; font-weight: 700; color: #1f63db; margin-bottom: 2px; }
    .doc-title { font-size: 13px; font-weight: 700; color: #0f172a; margin-bottom: 2px; }
    .doc-meta { font-size: 10px; color: #64748b; }

    .summary-bar { display: table; width: 100%; margin-bottom: 18px; padding: 0 28px; }
    .summary-item { display: table-cell; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; text-align: center; width: 25%; }
    .summary-item + .summary-item { border-left: none; }
    .summary-num { font-size: 20px; font-weight: 700; color: #1f63db; }
    .summary-lbl { font-size: 9px; color: #94a3b8; text-transform: uppercase; letter-spacing: .04em; margin-top: 2px; }

    .content { padding: 0 28px 28px; }

    table { width: 100%; border-collapse: collapse; margin-top: 4px; }
    thead tr { background: #1f63db; }
    thead th { padding: 9px 10px; text-align: left; font-size: 10px; font-weight: 700; color: #fff; letter-spacing: .04em; text-transform: uppercase; }
    thead th.center { text-align: center; }
    tbody tr { border-bottom: 1px solid #f1f5f9; }
    tbody tr:nth-child(even) { background: #f8fafc; }
    tbody tr:last-child { border-bottom: none; }
    td { padding: 8px 10px; font-size: 10.5px; color: #334155; vertical-align: top; }
    td.center { text-align: center; }

    .ujian-title { font-weight: 700; color: #0f172a; margin-bottom: 2px; }
    .ujian-mapel { font-size: 9.5px; color: #94a3b8; }

    .badge { display: inline-block; padding: 2px 8px; border-radius: 99px; font-size: 9.5px; font-weight: 700; }
    .badge-aktif    { background: #dcfce7; color: #15803d; }
    .badge-nonaktif { background: #fee2e2; color: #dc2626; }

    .jenis-pill { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 9.5px; font-weight: 700; }
    .jenis-ulangan_harian { background: #eff6ff; color: #1d4ed8; }
    .jenis-uts      { background: #fdf4ff; color: #7e22ce; }
    .jenis-uas      { background: #fff7ed; color: #c2410c; }
    .jenis-remedial { background: #fef2f2; color: #b91c1c; }
    .jenis-quiz     { background: #f0fdf4; color: #15803d; }

    .footer { position: fixed; bottom: 0; left: 0; right: 0; padding: 8px 28px; border-top: 1px solid #e2e8f0; display: table; width: 100%; background: #fff; }
    .footer-left  { display: table-cell; font-size: 9px; color: #94a3b8; }
    .footer-right { display: table-cell; text-align: right; font-size: 9px; color: #94a3b8; }

    .no-data { text-align: center; padding: 40px; color: #94a3b8; font-size: 12px; }
</style>
</head>
<body>

{{-- ── Header ── --}}
<div class="header">
    <p class="school-name">SISTEM INFORMASI SEKOLAH</p>
    <p class="doc-title">Laporan Data Ujian</p>
    <p class="doc-meta">
        Dicetak pada: {{ now()->translatedFormat('l, d F Y — H:i') }} WIB
        &nbsp;|&nbsp;
        Total: {{ $ujian->count() }} ujian
    </p>
</div>

{{-- ── Summary Bar ── --}}
{{--
    PERBAIKAN:
    - whereDate()  → tidak tersedia di Collection, hanya di Query Builder
    - Gunakan filter() dengan Carbon::parse()->isToday() untuk Collection
    - where() dan whereIn() masih valid di Collection Laravel
--}}
<div class="summary-bar">
    <div class="summary-item">
        <p class="summary-num">{{ $ujian->count() }}</p>
        <p class="summary-lbl">Total Ujian</p>
    </div>
    <div class="summary-item">
        <p class="summary-num">{{ $ujian->where('is_active', true)->count() }}</p>
        <p class="summary-lbl">Aktif</p>
    </div>
    <div class="summary-item">
        <p class="summary-num">{{ $ujian->whereIn('jenis', ['uts', 'uas'])->count() }}</p>
        <p class="summary-lbl">UTS / UAS</p>
    </div>
    <div class="summary-item">
        {{-- filter() digunakan karena whereDate() tidak ada di Collection --}}
        <p class="summary-num">
            {{ $ujian->filter(fn ($u) => \Carbon\Carbon::parse($u->tanggal)->isToday())->count() }}
        </p>
        <p class="summary-lbl">Hari Ini</p>
    </div>
</div>

{{-- ── Tabel ── --}}
<div class="content">
    @if($ujian->isEmpty())
        <p class="no-data">Tidak ada data ujian yang tersedia.</p>
    @else
    <table>
        <thead>
            <tr>
                <th style="width:30px">#</th>
                <th>Judul / Mapel</th>
                <th>Jenis</th>
                <th>Kelas</th>
                <th>Guru Pengawas</th>
                <th>Tanggal</th>
                <th class="center">Durasi</th>
                <th class="center">KKM</th>
                <th class="center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ujian as $i => $u)
            <tr>
                <td class="center" style="color:#94a3b8;font-weight:700">{{ $i + 1 }}</td>
                <td>
                    <p class="ujian-title">{{ $u->judul }}</p>
                    <p class="ujian-mapel">{{ $u->mataPelajaran->nama_mapel ?? '—' }}</p>
                </td>
                <td>
                    <span class="jenis-pill jenis-{{ $u->jenis }}">
                        {{ strtoupper(str_replace('_', ' ', $u->jenis)) }}
                    </span>
                </td>
                <td>{{ $u->kelas->nama_kelas ?? '—' }}</td>
                <td>{{ $u->guru->nama_lengkap ?? '—' }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($u->tanggal)->format('d/m/Y') }}
                    @if($u->jam_mulai)
                        <br>
                        <span style="color:#94a3b8;font-size:9px">
                            {{ \Carbon\Carbon::parse($u->jam_mulai)->format('H:i') }}
                        </span>
                    @endif
                </td>
                <td class="center">{{ $u->durasi_menit }} mnt</td>
                <td class="center">{{ $u->nilai_kkm ?? '—' }}</td>
                <td class="center">
                    <span class="badge {{ $u->is_active ? 'badge-aktif' : 'badge-nonaktif' }}">
                        {{ $u->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

{{-- ── Footer ── --}}
<div class="footer">
    <span class="footer-left">Sistem Informasi Sekolah &copy; {{ date('Y') }}</span>
    <span class="footer-right">Halaman <span class="pagenum"></span></span>
</div>

</body>
</html>