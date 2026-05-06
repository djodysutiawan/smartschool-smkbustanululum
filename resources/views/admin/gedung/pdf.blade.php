<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 9px; color: #1e293b; }

    .header { background: #1f63db; color: #fff; padding: 14px 20px; margin-bottom: 16px; }
    .header h1 { font-size: 15px; font-weight: bold; margin-bottom: 2px; }
    .header p  { font-size: 8.5px; opacity: .85; }

    {{-- Stats pakai table layout — DomPDF tidak support flexbox/grid --}}
    .stats-table { width: 100%; border-collapse: separate; border-spacing: 6px 0; margin-bottom: 14px; }
    .stats-table td { background: #f8fafc; border: 1px solid #e2e8f0; padding: 8px 12px; text-align: center; width: 33.33%; }
    .stat-val   { font-size: 18px; font-weight: bold; color: #1f63db; }
    .stat-label { font-size: 8px; color: #64748b; margin-top: 2px; text-transform: uppercase; letter-spacing: .04em; }

    .filter-bar { background: #f1f5f9; border: 1px solid #e2e8f0; padding: 5px 10px; margin-bottom: 12px; font-size: 8px; color: #475569; }

    table.data { width: 100%; border-collapse: collapse; font-size: 8.5px; }
    table.data thead th { background: #1f63db; color: #fff; padding: 7px 8px; text-align: left; font-size: 8px; text-transform: uppercase; letter-spacing: .04em; }
    table.data thead th.center { text-align: center; }
    table.data tbody tr:nth-child(even) { background: #f8fafc; }
    table.data td { padding: 6px 8px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    table.data td.center { text-align: center; }

    .badge { display: inline-block; padding: 2px 8px; border-radius: 3px; font-size: 7.5px; font-weight: bold; }
    .badge-aktif    { background: #dcfce7; color: #15803d; }
    .badge-nonaktif { background: #fee2e2; color: #dc2626; }

    {{-- Footer pakai table layout --}}
    .footer-table { width: 100%; border-collapse: collapse; margin-top: 14px; padding-top: 8px; border-top: 1px solid #e2e8f0; font-size: 8px; color: #94a3b8; }
    .footer-table td { padding: 0; }
    .footer-table .right { text-align: right; }
</style>
</head>
<body>

{{-- HEADER — tanpa emoji karena DejaVu Sans tidak support semua emoji --}}
<div class="header">
    <h1>Data Gedung</h1>
    <p>Laporan data gedung &mdash; dicetak {{ now()->isoFormat('D MMMM Y, HH:mm') }} WIB</p>
</div>

{{-- STATS — pakai <table> bukan div dengan display:table (lebih aman di DomPDF) --}}
{{--
    FIX: $gedung adalah Collection hasil ->get(), bukan Eloquent Builder.
    Gunakan ->filter() / ->sum() pada Collection, BUKAN ->where() builder method
    karena withCount() sudah di-resolve ke atribut 'ruang_count' di Collection.
--}}
<table class="stats-table">
    <tr>
        <td>
            <div class="stat-val">{{ $gedung->count() }}</div>
            <div class="stat-label">Total Gedung</div>
        </td>
        <td>
            {{-- FIX: Collection->filter() bukan ->where() untuk boolean cast --}}
            <div class="stat-val">{{ $gedung->filter(fn($g) => $g->is_active)->count() }}</div>
            <div class="stat-label">Aktif</div>
        </td>
        <td>
            {{-- FIX: ruang_count adalah atribut dari withCount, bukan relasi --}}
            <div class="stat-val">{{ $gedung->sum('ruang_count') }}</div>
            <div class="stat-label">Total Ruangan</div>
        </td>
    </tr>
</table>

{{-- Filter label — hanya tampil jika ada filter aktif --}}
@if($filterLabel)
<div class="filter-bar">Filter aktif: {{ $filterLabel }}</div>
@endif

{{-- TABEL DATA --}}
<table class="data">
    <thead>
        <tr>
            <th style="width:24px" class="center">#</th>
            <th style="width:60px">Kode</th>
            <th>Nama Gedung</th>
            <th class="center" style="width:40px">Lantai</th>
            <th class="center" style="width:50px">Jml Ruang</th>
            <th class="center" style="width:55px">Status</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($gedung as $i => $g)
        <tr>
            <td class="center" style="color:#94a3b8;font-weight:bold">{{ $i + 1 }}</td>
            <td style="font-weight:bold;color:#1f63db">{{ $g->kode_gedung }}</td>
            <td style="font-weight:bold">{{ $g->nama_gedung }}</td>
            <td class="center">{{ $g->jumlah_lantai }}</td>
            <td class="center">{{ $g->ruang_count }}</td>
            <td class="center">
                <span class="badge badge-{{ $g->is_active ? 'aktif' : 'nonaktif' }}">
                    {{ $g->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </td>
            <td style="color:#64748b;font-size:8px">
                {{ \Illuminate\Support\Str::limit($g->deskripsi ?? '-', 50) }}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align:center;color:#94a3b8;padding:20px">
                Tidak ada data gedung
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- FOOTER --}}
<table class="footer-table">
    <tr>
        <td>Sistem Informasi Sekolah &mdash; Dicetak oleh: {{ auth()->user()->name }}</td>
        <td class="right">{{ now()->format('d/m/Y H:i') }}</td>
    </tr>
</table>

</body>
</html>