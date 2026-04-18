<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Laporan Jurnal Mengajar</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'DejaVu Sans',sans-serif;font-size:11px;color:#1e293b;background:#fff;}

.header{padding:20px 28px 16px;border-bottom:2px solid #1f63db;margin-bottom:18px;}
.school-name{font-size:15px;font-weight:700;color:#1f63db;margin-bottom:2px;}
.doc-title{font-size:13px;font-weight:700;color:#0f172a;margin-bottom:2px;}
.doc-meta{font-size:10px;color:#64748b;}

.summary-bar{display:table;width:100%;margin-bottom:18px;padding:0 28px;}
.summary-item{display:table-cell;background:#f8fafc;border:1px solid #e2e8f0;padding:10px 14px;text-align:center;width:25%;}
.summary-item+.summary-item{border-left:none;}
.summary-num{font-size:20px;font-weight:700;color:#1f63db;}
.summary-lbl{font-size:9px;color:#94a3b8;text-transform:uppercase;letter-spacing:.04em;margin-top:2px;}

.content{padding:0 28px 28px;}

table{width:100%;border-collapse:collapse;}
thead tr{background:#1f63db;}
thead th{padding:9px 10px;text-align:left;font-size:10px;font-weight:700;color:#fff;letter-spacing:.04em;text-transform:uppercase;}
thead th.center{text-align:center;}

tbody tr{border-bottom:1px solid #f1f5f9;}
tbody tr:nth-child(even){background:#f8fafc;}
tbody tr:last-child{border-bottom:none;}

td{padding:8px 10px;font-size:10.5px;color:#334155;vertical-align:top;}
td.center{text-align:center;}

.guru-name{font-weight:700;color:#0f172a;margin-bottom:2px;}
.mapel-name{font-size:9.5px;color:#94a3b8;}

.badge{display:inline-block;padding:2px 8px;border-radius:4px;font-size:9.5px;font-weight:700;}
.badge-ceramah{background:#eff6ff;color:#1d4ed8;}
.badge-diskusi{background:#f0fdf4;color:#15803d;}
.badge-praktikum{background:#fdf4ff;color:#7c3aed;}
.badge-demonstrasi{background:#fff7ed;color:#c2410c;}
.badge-proyek{background:#fefce8;color:#a16207;}
.badge-lainnya{background:#f1f5f9;color:#64748b;}

.materi-text{max-width:200px;line-height:1.4;}

.footer{
    position:fixed;
    bottom:0;
    left:0;
    right:0;
    padding:8px 28px;
    border-top:1px solid #e2e8f0;
    display:table;
    width:100%;
    background:#fff;
}

.footer-left{display:table-cell;font-size:9px;color:#94a3b8;}
.footer-right{display:table-cell;text-align:right;font-size:9px;color:#94a3b8;}

.no-data{text-align:center;padding:40px;color:#94a3b8;font-size:12px;}
</style>
</head>

<body>

@php
    use Carbon\Carbon;

    $totalJurnal = $jurnal->count();

    $todayCount = $jurnal->filter(function ($item) {
        return Carbon::parse($item->tanggal)->isToday();
    })->count();

    $totalGuru = $jurnal->pluck('guru_id')->unique()->count();
    $totalKelas = $jurnal->pluck('kelas_id')->unique()->count();
@endphp

<div class="header">
    <p class="school-name">SISTEM INFORMASI SEKOLAH</p>
    <p class="doc-title">Laporan Jurnal Mengajar</p>
    <p class="doc-meta">
        Dicetak pada: {{ now()->translatedFormat('l, d F Y — H:i') }} WIB
        &nbsp;|&nbsp;
        Total: {{ $totalJurnal }} entri
    </p>
</div>

<div class="summary-bar">
    <div class="summary-item">
        <p class="summary-num">{{ $totalJurnal }}</p>
        <p class="summary-lbl">Total Jurnal</p>
    </div>

    <div class="summary-item">
        <p class="summary-num">{{ $todayCount }}</p>
        <p class="summary-lbl">Hari Ini</p>
    </div>

    <div class="summary-item">
        <p class="summary-num">{{ $totalGuru }}</p>
        <p class="summary-lbl">Guru</p>
    </div>

    <div class="summary-item">
        <p class="summary-num">{{ $totalKelas }}</p>
        <p class="summary-lbl">Kelas</p>
    </div>
</div>

<div class="content">
    @if($jurnal->isEmpty())
        <p class="no-data">Tidak ada data jurnal mengajar.</p>
    @else
    <table>
        <thead>
            <tr>
                <th style="width:28px">#</th>
                <th>Guru / Mapel</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Pertemuan</th>
                <th>Materi Ajar</th>
                <th>Metode</th>
                <th class="center">Hadir</th>
                <th class="center">Tdk Hadir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jurnal as $i => $j)
            <tr>
                <td class="center" style="color:#94a3b8;font-weight:700">
                    {{ $i+1 }}
                </td>

                <td>
                    <p class="guru-name">{{ $j->guru->nama_lengkap ?? '—' }}</p>
                    <p class="mapel-name">{{ $j->mataPelajaran->nama_mapel ?? '—' }}</p>
                </td>

                <td>{{ $j->kelas->nama_kelas ?? '—' }}</td>

                <td style="white-space:nowrap">
                    {{ \Carbon\Carbon::parse($j->tanggal)->format('d/m/Y') }}
                </td>

                <td class="center">{{ $j->pertemuan_ke ?? '—' }}</td>

                <td>
                    <p class="materi-text">
                        {{ \Illuminate\Support\Str::limit($j->materi_ajar, 80) }}
                    </p>
                </td>

                <td>
                    @php $m = $j->metode_pembelajaran ?? 'lainnya'; @endphp
                    <span class="badge badge-{{ $m }}">
                        {{ ucfirst($m) }}
                    </span>
                </td>

                <td class="center">{{ $j->jumlah_hadir ?? '—' }}</td>
                <td class="center">{{ $j->jumlah_tidak_hadir ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

<div class="footer">
    <span class="footer-left">
        Sistem Informasi Sekolah &copy; {{ date('Y') }}
    </span>
    <span class="footer-right">
        Halaman <span class="pagenum"></span>
    </span>
</div>

</body>
</html>