<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Guru</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10.5pt;
            color: #0f172a;
            background: #fff;
        }

        .page { padding: 12mm 14mm 10mm; }

        /* ── KOP ── */
        .kop-table { width: 100%; border-collapse: collapse; margin-bottom: 0; }
        .kop-table td { padding: 0; vertical-align: middle; }
        .kop-logo-cell { width: 58px; text-align: center; vertical-align: middle; }
        .kop-logo-circle {
            width: 52px; height: 52px;
            border: 2px solid #334155;
            border-radius: 50%;
            text-align: center;
            font-size: 7.5pt;
            color: #64748b;
            line-height: 52px;
        }
        .kop-text-cell { text-align: center; vertical-align: middle; padding: 0 6px; }
        .kop-instansi { font-size: 8.5pt; text-transform: uppercase; letter-spacing: 0.3px; color: #475569; }
        .kop-nama { font-size: 14pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .kop-alamat { font-size: 8pt; margin-top: 2px; color: #475569; }
        .garis-kop { border-top: 3px double #0f172a; margin: 7px 0 10px; }

        /* ── JUDUL ── */
        .judul-section { text-align: center; margin-bottom: 12px; }
        .judul { font-size: 12pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1.5px; text-decoration: underline; }
        .subjudul { font-size: 9pt; color: #475569; margin-top: 3px; }

        /* ── REKAP STRIP ── */
        .rekap-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        .rekap-table td { width: 25%; padding: 7px 10px; border: 1px solid #e2e8f0; text-align: center; }
        .rekap-label { font-size: 8pt; color: #64748b; font-weight: normal; text-transform: uppercase; letter-spacing: 0.04em; }
        .rekap-val { font-size: 16pt; font-weight: bold; margin-top: 1px; }
        .rekap-val.blue  { color: #1f63db; }
        .rekap-val.green { color: #15803d; }
        .rekap-val.sky   { color: #0284c7; }
        .rekap-val.pink  { color: #db2777; }

        /* ── META FILTER ── */
        .meta-row { font-size: 8.5pt; color: #64748b; margin-bottom: 10px; }
        .meta-row span { margin-right: 18px; }
        .meta-row strong { color: #0f172a; }

        /* ── TABLE ── */
        .data-table { width: 100%; border-collapse: collapse; font-size: 9.5pt; }
        .data-table thead tr { background: #f1f5f9; }
        .data-table thead th {
            padding: 6px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 8.5pt;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border: 1px solid #e2e8f0;
            white-space: nowrap;
            color: #475569;
        }
        .data-table thead th.center { text-align: center; }
        .data-table tbody tr { border-bottom: 1px solid #f1f5f9; }
        .data-table tbody tr.alt { background: #f8fafc; }
        .data-table tbody td {
            padding: 6px 8px;
            border: 1px solid #e2e8f0;
            vertical-align: middle;
        }
        .data-table tbody td.center { text-align: center; }
        .data-table tbody td.muted { color: #64748b; font-size: 9pt; }

        /* ── BADGES ── */
        .badge {
            display: inline;
            padding: 2px 8px;
            border-radius: 99px;
            font-size: 8.5pt;
            font-weight: bold;
        }
        .badge-aktif    { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-nonaktif { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
        .badge-cuti     { background: #fef9c3; color: #a16207; border: 1px solid #fde68a; }
        .badge-pensiun  { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }

        .jk-l { color: #0284c7; font-weight: bold; }
        .jk-p { color: #db2777; font-weight: bold; }

        /* ── FOOTER ── */
        .footer {
            margin-top: 14px;
            padding-top: 6px;
            border-top: 1px dashed #94a3b8;
            font-size: 8pt;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="page">

    {{-- KOP --}}
    <table class="kop-table">
        <tr>
            <td class="kop-logo-cell">
                <div class="kop-logo-circle">LOGO</div>
            </td>
            <td class="kop-text-cell">
                <div class="kop-instansi">Pemerintah Daerah &mdash; Dinas Pendidikan</div>
                <div class="kop-nama">{{ config('app.nama_sekolah', 'SMA Negeri 1 Contoh') }}</div>
                <div class="kop-alamat">
                    {{ config('app.alamat_sekolah', 'Jl. Pendidikan No. 1, Kota Contoh') }}
                    &nbsp;&bull;&nbsp; Telp. {{ config('app.telepon_sekolah', '(021) 123456') }}
                    &nbsp;&bull;&nbsp; NPSN: {{ config('app.npsn_sekolah', '20000000') }}
                </div>
            </td>
        </tr>
    </table>
    <div class="garis-kop"></div>

    {{-- JUDUL --}}
    <div class="judul-section">
        <div class="judul">Laporan Data Guru</div>
        <div class="subjudul">Dicetak pada {{ $generated_at }}</div>
    </div>

    {{-- REKAP --}}
    <table class="rekap-table">
        <tr>
            <td>
                <div class="rekap-label">Total Guru</div>
                <div class="rekap-val blue">{{ $data->count() }}</div>
            </td>
            <td>
                <div class="rekap-label">Guru Aktif</div>
                <div class="rekap-val green">{{ $data->where('status', 'aktif')->count() }}</div>
            </td>
            <td>
                <div class="rekap-label">Laki-laki</div>
                <div class="rekap-val sky">{{ $data->where('jenis_kelamin', 'L')->count() }}</div>
            </td>
            <td>
                <div class="rekap-label">Perempuan</div>
                <div class="rekap-val pink">{{ $data->where('jenis_kelamin', 'P')->count() }}</div>
            </td>
        </tr>
    </table>

    {{-- META --}}
    <div class="meta-row">
        <span>Total data: <strong>{{ $data->count() }} guru</strong></span>
        <span>Dicetak: <strong>{{ $generated_at }}</strong></span>
    </div>

    {{-- TABEL DATA --}}
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:32px" class="center">#</th>
                <th>Nama Guru</th>
                <th>NIP</th>
                <th>Jenis Kelamin</th>
                <th>Jabatan</th>
                <th>Email / Akun</th>
                <th class="center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $g)
            <tr class="{{ $i % 2 === 1 ? 'alt' : '' }}">
                <td class="center muted">{{ $i + 1 }}</td>
                <td>
                    <strong>{{ $g->nama_lengkap }}</strong>
                </td>
                <td class="muted" style="font-family: monospace;">{{ $g->nip ?? '—' }}</td>
                <td class="center">
                    @if($g->jenis_kelamin === 'L')
                        <span class="jk-l">♂ L</span>
                    @elseif($g->jenis_kelamin === 'P')
                        <span class="jk-p">♀ P</span>
                    @else
                        —
                    @endif
                </td>
                <td class="muted">{{ $g->jabatan ?? '—' }}</td>
                <td class="muted" style="font-size:8.5pt;">
                    {{ $g->pengguna->email ?? '—' }}
                </td>
                <td class="center">
                    @php
                        $st = $g->status ?? 'aktif';
                        $stLabel = match($st) {
                            'aktif'    => 'Aktif',
                            'nonaktif' => 'Non-Aktif',
                            'cuti'     => 'Cuti',
                            'pensiun'  => 'Pensiun',
                            default    => ucfirst($st),
                        };
                    @endphp
                    <span class="badge badge-{{ $st }}">{{ $stLabel }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:20px;color:#94a3b8;font-style:italic;">
                    Tidak ada data guru.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        {{ config('app.nama_sekolah', 'SMA Negeri 1 Contoh') }}
        &nbsp;&bull;&nbsp; Laporan Data Guru
        &nbsp;&bull;&nbsp; Dicetak: {{ $generated_at }}
        &nbsp;&bull;&nbsp; Dokumen resmi, harap dijaga
    </div>

</div>
</body>
</html>