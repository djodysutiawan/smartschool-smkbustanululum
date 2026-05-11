<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absensi Guru — {{ \Carbon\Carbon::parse($meta['tanggal'])->isoFormat('D MMMM Y') }}</title>
    <style>
        /* ── Reset & Base ─────────────────────────────────────────────────── */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 11px;
            color: #1a1a2e;
            background: #ffffff;
            line-height: 1.5;
        }

        /* ── Layout ───────────────────────────────────────────────────────── */
        .page {
            padding: 28px 32px;
        }

        /* ── Header / Kop Surat ───────────────────────────────────────────── */
        .kop {
            border-bottom: 2.5px solid #1e3a5f;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .kop-inner {
            display: table;
            width: 100%;
        }

        .kop-logo {
            display: table-cell;
            width: 60px;
            vertical-align: middle;
        }

        .kop-logo img {
            width: 52px;
            height: 52px;
        }

        .kop-text {
            display: table-cell;
            vertical-align: middle;
            padding-left: 10px;
        }

        .kop-text .sekolah {
            font-size: 15px;
            font-weight: 700;
            color: #1e3a5f;
            letter-spacing: 0.3px;
        }

        .kop-text .alamat {
            font-size: 9.5px;
            color: #555;
            margin-top: 2px;
        }

        /* ── Judul Dokumen ────────────────────────────────────────────────── */
        .doc-title {
            text-align: center;
            margin-bottom: 14px;
        }

        .doc-title h2 {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1e3a5f;
        }

        .doc-title p {
            font-size: 10.5px;
            color: #444;
            margin-top: 2px;
        }

        /* ── Rekap Statistik ──────────────────────────────────────────────── */
        .rekap-box {
            display: table;
            width: 100%;
            margin-bottom: 16px;
            border-collapse: collapse;
        }

        .rekap-item {
            display: table-cell;
            text-align: center;
            padding: 8px 4px;
            border: 1px solid #dde3ec;
        }

        .rekap-item .angka {
            font-size: 18px;
            font-weight: 700;
            line-height: 1.2;
        }

        .rekap-item .label {
            font-size: 9px;
            color: #666;
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .rekap-item.hadir  .angka { color: #16a34a; }
        .rekap-item.telat  .angka { color: #d97706; }
        .rekap-item.izin   .angka { color: #2563eb; }
        .rekap-item.sakit  .angka { color: #7c3aed; }
        .rekap-item.alfa   .angka { color: #dc2626; }
        .rekap-item.belum  .angka { color: #6b7280; }
        .rekap-item.total  .angka { color: #1e3a5f; }

        .rekap-item.hadir  { background: #f0fdf4; }
        .rekap-item.telat  { background: #fffbeb; }
        .rekap-item.izin   { background: #eff6ff; }
        .rekap-item.sakit  { background: #faf5ff; }
        .rekap-item.alfa   { background: #fef2f2; }
        .rekap-item.belum  { background: #f9fafb; }
        .rekap-item.total  { background: #f0f4ff; }

        /* ── Tabel Utama ──────────────────────────────────────────────────── */
        .section-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1e3a5f;
            border-left: 3px solid #1e3a5f;
            padding-left: 6px;
            margin-bottom: 8px;
        }

        table.main {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        table.main thead tr {
            background-color: #1e3a5f;
            color: #ffffff;
        }

        table.main thead th {
            padding: 7px 8px;
            text-align: left;
            font-size: 9.5px;
            font-weight: 600;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        table.main thead th.center {
            text-align: center;
        }

        table.main tbody tr:nth-child(even) {
            background-color: #f7f9fc;
        }

        table.main tbody tr {
            border-bottom: 1px solid #e8ecf2;
        }

        table.main tbody td {
            padding: 6px 8px;
            font-size: 10px;
            vertical-align: middle;
        }

        table.main tbody td.center {
            text-align: center;
        }

        table.main tbody td.no {
            color: #999;
            font-size: 9px;
            width: 26px;
        }

        /* ── Badge Status ─────────────────────────────────────────────────── */
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-hadir  { background: #dcfce7; color: #15803d; }
        .badge-telat  { background: #fef3c7; color: #b45309; }
        .badge-izin   { background: #dbeafe; color: #1d4ed8; }
        .badge-sakit  { background: #ede9fe; color: #6d28d9; }
        .badge-alfa   { background: #fee2e2; color: #b91c1c; }

        /* ── Badge Metode ─────────────────────────────────────────────────── */
        .badge-manual { background: #f3f4f6; color: #374151; font-size: 8.5px; }
        .badge-qr     { background: #e0f2fe; color: #0369a1; font-size: 8.5px; }

        /* ── Tabel Belum Absen ────────────────────────────────────────────── */
        table.belum {
            width: 100%;
            border-collapse: collapse;
        }

        table.belum thead tr {
            background-color: #6b7280;
            color: #ffffff;
        }

        table.belum thead th {
            padding: 6px 8px;
            text-align: left;
            font-size: 9.5px;
            font-weight: 600;
            text-transform: uppercase;
        }

        table.belum tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }

        table.belum tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        table.belum tbody td {
            padding: 5px 8px;
            font-size: 10px;
        }

        table.belum tbody td.no {
            color: #9ca3af;
            font-size: 9px;
            width: 26px;
        }

        /* ── Empty State ──────────────────────────────────────────────────── */
        .empty-row td {
            text-align: center;
            color: #9ca3af;
            font-style: italic;
            padding: 14px !important;
        }

        /* ── Footer / Tanda Tangan ────────────────────────────────────────── */
        .footer {
            margin-top: 24px;
            display: table;
            width: 100%;
        }

        .footer-left {
            display: table-cell;
            width: 60%;
            vertical-align: top;
        }

        .footer-right {
            display: table-cell;
            width: 40%;
            vertical-align: top;
            text-align: center;
        }

        .footer-meta {
            font-size: 9px;
            color: #6b7280;
            line-height: 1.6;
        }

        .footer-meta span {
            color: #374151;
            font-weight: 600;
        }

        .ttd-label {
            font-size: 10px;
            margin-bottom: 48px;
        }

        .ttd-name {
            font-size: 10px;
            font-weight: 700;
            border-top: 1px solid #374151;
            padding-top: 4px;
            display: inline-block;
            min-width: 160px;
        }

        /* ── Pemisah Halaman ──────────────────────────────────────────────── */
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
<div class="page">

    {{-- ── Kop Surat ──────────────────────────────────────────────────────── --}}
    <div class="kop">
        <div class="kop-inner">
            <div class="kop-logo">
                {{-- Ganti dengan logo sekolah jika ada --}}
                {{-- <img src="{{ public_path('images/logo-sekolah.png') }}" alt="Logo"> --}}
            </div>
            <div class="kop-text">
                <div class="sekolah">{{ config('app.nama_sekolah', 'SMA NEGERI 1') }}</div>
                <div class="alamat">
                    {{ config('app.alamat_sekolah', 'Jl. Pendidikan No. 1, Kota') }}
                    &nbsp;|&nbsp; Telp. {{ config('app.telp_sekolah', '(021) 000-0000') }}
                    &nbsp;|&nbsp; {{ config('app.email_sekolah', 'info@sekolah.sch.id') }}
                </div>
            </div>
        </div>
    </div>

    {{-- ── Judul ───────────────────────────────────────────────────────────── --}}
    <div class="doc-title">
        <h2>Rekap Absensi Guru</h2>
        <p>
            {{ \Carbon\Carbon::parse($meta['tanggal'])->isoFormat('dddd, D MMMM Y') }}
        </p>
    </div>

    {{-- ── Statistik Ringkas ───────────────────────────────────────────────── --}}
    <div class="rekap-box">
        <div class="rekap-item hadir">
            <div class="angka">{{ $rekap['hadir'] }}</div>
            <div class="label">Hadir</div>
        </div>
        <div class="rekap-item telat">
            <div class="angka">{{ $rekap['telat'] }}</div>
            <div class="label">Telat</div>
        </div>
        <div class="rekap-item izin">
            <div class="angka">{{ $rekap['izin'] }}</div>
            <div class="label">Izin</div>
        </div>
        <div class="rekap-item sakit">
            <div class="angka">{{ $rekap['sakit'] }}</div>
            <div class="label">Sakit</div>
        </div>
        <div class="rekap-item alfa">
            <div class="angka">{{ $rekap['alfa'] }}</div>
            <div class="label">Alfa</div>
        </div>
        <div class="rekap-item belum">
            <div class="angka">{{ $rekap['belum'] }}</div>
            <div class="label">Belum Absen</div>
        </div>
        <div class="rekap-item total">
            <div class="angka">{{ $rekap['total'] }}</div>
            <div class="label">Total Guru</div>
        </div>
    </div>

    {{-- ── Tabel Absensi Yang Sudah Tercatat ───────────────────────────────── --}}
    <div class="section-title">Daftar Absensi Tercatat</div>
    <table class="main">
        <thead>
            <tr>
                <th style="width:26px">No</th>
                <th>Nama Guru</th>
                <th>NIP</th>
                <th class="center">Status</th>
                <th class="center">Jam Masuk</th>
                <th class="center">Jam Keluar</th>
                <th class="center">Metode</th>
                <th>Keterangan</th>
                <th>Dicatat Oleh</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensiList as $i => $absensi)
                <tr>
                    <td class="no center">{{ $i + 1 }}</td>
                    <td style="font-weight:600">{{ $absensi->guru?->nama_lengkap ?? '—' }}</td>
                    <td style="font-size:9px; color:#666">{{ $absensi->guru?->nip ?? '—' }}</td>
                    <td class="center">
                        <span class="badge badge-{{ $absensi->status }}">
                            {{ AbsensiGuru::LABEL_STATUS[$absensi->status] ?? $absensi->status }}
                        </span>
                    </td>
                    <td class="center" style="font-family: monospace">
                        {{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') : '—' }}
                    </td>
                    <td class="center" style="font-family: monospace">
                        {{ $absensi->jam_keluar ? \Carbon\Carbon::parse($absensi->jam_keluar)->format('H:i') : '—' }}
                    </td>
                    <td class="center">
                        <span class="badge badge-{{ $absensi->metode ?? 'manual' }}">
                            {{ strtoupper($absensi->metode ?? 'manual') }}
                        </span>
                    </td>
                    <td style="color:#555; font-size:9.5px">
                        {{ $absensi->keterangan ?? '—' }}
                    </td>
                    <td style="font-size:9.5px; color:#555">
                        {{ $absensi->pencatat?->name ?? '—' }}
                    </td>
                </tr>
            @empty
                <tr class="empty-row">
                    <td colspan="9">Belum ada data absensi yang tercatat untuk tanggal ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ── Tabel Guru Yang Belum Absen ─────────────────────────────────────── --}}
    @if($belumAbsen->isNotEmpty())

        {{-- Cek apakah perlu page break agar tabel belum absen tidak terpotong --}}
        @if($absensiList->count() > 20)
            <div class="page-break"></div>
            {{-- Ulangi judul di halaman baru --}}
            <div class="doc-title" style="margin-bottom:12px">
                <h2>Rekap Absensi Guru</h2>
                <p>{{ \Carbon\Carbon::parse($meta['tanggal'])->isoFormat('dddd, D MMMM Y') }} (Lanjutan)</p>
            </div>
        @endif

        <div class="section-title" style="margin-top:4px">
            Guru Belum Absen ({{ $belumAbsen->count() }} orang)
        </div>
        <table class="belum">
            <thead>
                <tr>
                    <th style="width:26px">No</th>
                    <th>Nama Guru</th>
                    <th>NIP</th>
                    <th>Status Kepegawaian</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($belumAbsen as $i => $guru)
                    <tr>
                        <td class="no" style="text-align:center">{{ $i + 1 }}</td>
                        <td style="font-weight:600">{{ $guru->nama_lengkap }}</td>
                        <td style="font-size:9px; color:#666">{{ $guru->nip ?? '—' }}</td>
                        <td style="font-size:9.5px">{{ $guru->label_status_kepegawaian ?? '—' }}</td>
                        <td style="font-size:9px; color:#9ca3af; font-style:italic">Belum tercatat</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- ── Footer & Tanda Tangan ───────────────────────────────────────────── --}}
    <div class="footer">
        <div class="footer-left">
            <div class="footer-meta">
                Dicetak pada&nbsp;: <span>{{ $meta['dicetak_pada'] }}</span><br>
                Dicetak oleh&nbsp;: <span>{{ $meta['dicetak_oleh'] }}</span><br>
                Periode&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span>{{ \Carbon\Carbon::parse($meta['tanggal'])->isoFormat('D MMMM Y') }}</span>
            </div>
        </div>
        <div class="footer-right">
            <div class="ttd-label">Guru Piket,</div>
            <div class="ttd-name">{{ $meta['dicetak_oleh'] }}</div>
        </div>
    </div>

</div>
</body>
</html>