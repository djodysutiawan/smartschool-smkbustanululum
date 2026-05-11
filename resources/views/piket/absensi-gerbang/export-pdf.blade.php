<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi Gerbang — {{ \Carbon\Carbon::parse($filter['tanggal'])->isoFormat('D MMMM Y') }}</title>
    <style>
        /* ── Reset & Base ─────────────────────────────────────────────────── */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10.5px;
            color: #1a1a2e;
            background: #fff;
            line-height: 1.5;
        }

        .page { padding: 26px 30px; }

        /* ── Kop Surat ────────────────────────────────────────────────────── */
        .kop {
            border-bottom: 2.5px solid #1e3a5f;
            padding-bottom: 11px;
            margin-bottom: 14px;
        }

        .kop-table { width: 100%; display: table; }

        .kop-logo {
            display: table-cell;
            width: 58px;
            vertical-align: middle;
        }

        .kop-logo img { width: 50px; height: 50px; }

        .kop-text {
            display: table-cell;
            vertical-align: middle;
            padding-left: 10px;
        }

        .kop-text .nama-sekolah {
            font-size: 14.5px;
            font-weight: 700;
            color: #1e3a5f;
            letter-spacing: 0.3px;
        }

        .kop-text .alamat {
            font-size: 9px;
            color: #555;
            margin-top: 2px;
        }

        /* ── Judul ────────────────────────────────────────────────────────── */
        .doc-title {
            text-align: center;
            margin-bottom: 12px;
        }

        .doc-title h2 {
            font-size: 12.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1e3a5f;
        }

        .doc-title .sub {
            font-size: 10px;
            color: #444;
            margin-top: 3px;
        }

        /* ── Info Filter ──────────────────────────────────────────────────── */
        .info-box {
            display: table;
            width: 100%;
            margin-bottom: 13px;
            border: 1px solid #dde3ec;
            border-radius: 3px;
        }

        .info-col {
            display: table-cell;
            width: 50%;
            padding: 7px 10px;
            vertical-align: top;
            font-size: 9.5px;
        }

        .info-col:first-child {
            border-right: 1px solid #dde3ec;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 2px;
        }

        .info-key {
            display: table-cell;
            width: 100px;
            color: #666;
        }

        .info-val {
            display: table-cell;
            font-weight: 600;
            color: #1a1a2e;
        }

        /* ── Statistik ────────────────────────────────────────────────────── */
        .stat-table {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        .stat-cell {
            display: table-cell;
            text-align: center;
            padding: 8px 4px;
            border: 1px solid #dde3ec;
        }

        .stat-cell .angka {
            font-size: 17px;
            font-weight: 700;
            line-height: 1.1;
        }

        .stat-cell .label {
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #666;
            margin-top: 2px;
        }

        /* Warna per kolom statistik */
        .stat-masuk    { background: #eff6ff; }
        .stat-masuk    .angka { color: #2563eb; }
        .stat-pulang   { background: #f5f3ff; }
        .stat-pulang   .angka { color: #7c3aed; }
        .stat-belum    { background: #fef2f2; }
        .stat-belum    .angka { color: #dc2626; }
        .stat-manual   { background: #f9fafb; }
        .stat-manual   .angka { color: #374151; }
        .stat-duplikat { background: #fffbeb; }
        .stat-duplikat .angka { color: #d97706; }
        .stat-unknown  { background: #fff7ed; }
        .stat-unknown  .angka { color: #ea580c; }
        .stat-total    { background: #f0f4ff; }
        .stat-total    .angka { color: #1e3a5f; }
        .stat-persen   { background: #f0fdf4; }
        .stat-persen   .angka { color: #16a34a; font-size: 14px; }

        /* ── Section Title ────────────────────────────────────────────────── */
        .section-title {
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1e3a5f;
            border-left: 3px solid #1e3a5f;
            padding-left: 6px;
            margin-bottom: 7px;
            margin-top: 4px;
        }

        /* ── Tabel Masuk ──────────────────────────────────────────────────── */
        table.scan {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }

        table.scan thead tr {
            color: #fff;
        }

        table.scan thead.masuk-head tr { background: #1d4ed8; }
        table.scan thead.pulang-head tr { background: #6d28d9; }

        table.scan thead th {
            padding: 6px 7px;
            text-align: left;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        table.scan thead th.center { text-align: center; }

        table.scan tbody tr { border-bottom: 1px solid #e8ecf2; }
        table.scan tbody tr:nth-child(even) { background: #f7f9fc; }

        table.scan tbody td {
            padding: 5.5px 7px;
            font-size: 10px;
            vertical-align: middle;
        }

        table.scan tbody td.center { text-align: center; }
        table.scan tbody td.no { color: #aaa; font-size: 9px; width: 24px; }
        table.scan tbody td.mono { font-family: monospace; font-size: 9.5px; }

        /* ── Badge ────────────────────────────────────────────────────────── */
        .badge {
            display: inline-block;
            padding: 1.5px 6px;
            border-radius: 20px;
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.2px;
        }

        /* Tipe scan */
        .badge-masuk  { background: #dbeafe; color: #1d4ed8; }
        .badge-pulang { background: #ede9fe; color: #6d28d9; }

        /* Status */
        .badge-normal  { background: #dcfce7; color: #15803d; }
        .badge-manual  { background: #e0f2fe; color: #0369a1; }
        .badge-koreksi { background: #fef3c7; color: #b45309; }
        .badge-duplikat{ background: #fee2e2; color: #b91c1c; }

        /* Tipe pemilik */
        .badge-siswa { background: #f0fdf4; color: #15803d; font-size: 8px; }
        .badge-guru  { background: #faf5ff; color: #7c3aed; font-size: 8px; }

        /* ── Empty Row ────────────────────────────────────────────────────── */
        .empty td {
            text-align: center;
            color: #9ca3af;
            font-style: italic;
            padding: 12px !important;
        }

        /* ── Footer ───────────────────────────────────────────────────────── */
        .footer {
            display: table;
            width: 100%;
            margin-top: 22px;
        }

        .footer-left {
            display: table-cell;
            width: 55%;
            vertical-align: top;
        }

        .footer-right {
            display: table-cell;
            width: 45%;
            vertical-align: top;
            text-align: center;
        }

        .footer-meta {
            font-size: 9px;
            color: #6b7280;
            line-height: 1.7;
        }

        .footer-meta span { color: #374151; font-weight: 600; }

        .ttd-label { font-size: 10px; margin-bottom: 46px; }

        .ttd-name {
            font-size: 10px;
            font-weight: 700;
            border-top: 1px solid #374151;
            padding-top: 4px;
            display: inline-block;
            min-width: 160px;
        }

        .page-break { page-break-before: always; }
    </style>
</head>
<body>
<div class="page">

    {{-- ── Kop ────────────────────────────────────────────────────────────── --}}
    <div class="kop">
        <div class="kop-table">
            <div class="kop-logo">
                {{-- <img src="{{ public_path('images/logo-sekolah.png') }}" alt="Logo"> --}}
            </div>
            <div class="kop-text">
                <div class="nama-sekolah">{{ config('app.nama_sekolah', 'SMA NEGERI 1') }}</div>
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
        <h2>Log Absensi Gerbang Siswa</h2>
        <div class="sub">
            {{ \Carbon\Carbon::parse($filter['tanggal'])->isoFormat('dddd, D MMMM Y') }}
            @if($filter['tipe'])
                &nbsp;—&nbsp; Tipe: <strong>{{ ucfirst($filter['tipe']) }}</strong>
            @endif
            &nbsp;—&nbsp; Kelas: <strong>{{ $filter['kelas_label'] }}</strong>
        </div>
    </div>

    {{-- ── Info Filter ─────────────────────────────────────────────────────── --}}
    <div class="info-box">
        <div class="info-col">
            <div class="info-row">
                <div class="info-key">Tanggal</div>
                <div class="info-val">: {{ \Carbon\Carbon::parse($filter['tanggal'])->isoFormat('D MMMM Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-key">Filter Tipe</div>
                <div class="info-val">: {{ $filter['tipe'] ? ucfirst($filter['tipe']) : 'Semua' }}</div>
            </div>
            <div class="info-row">
                <div class="info-key">Filter Kelas</div>
                <div class="info-val">: {{ $filter['kelas_label'] }}</div>
            </div>
        </div>
        <div class="info-col">
            <div class="info-row">
                <div class="info-key">Dicetak pada</div>
                <div class="info-val">: {{ $filter['dicetak_pada'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-key">Dicetak oleh</div>
                <div class="info-val">: {{ $filter['dicetak_oleh'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-key">Total record</div>
                <div class="info-val">: {{ $scanList->count() }} scan</div>
            </div>
        </div>
    </div>

    {{-- ── Statistik ───────────────────────────────────────────────────────── --}}
    <div class="stat-table">
        <div class="stat-cell stat-masuk">
            <div class="angka">{{ $statistik['total_masuk'] }}</div>
            <div class="label">Masuk</div>
        </div>
        <div class="stat-cell stat-pulang">
            <div class="angka">{{ $statistik['total_pulang'] }}</div>
            <div class="label">Pulang</div>
        </div>
        <div class="stat-cell stat-belum">
            <div class="angka">{{ $statistik['belum_hadir'] }}</div>
            <div class="label">Belum Hadir</div>
        </div>
        <div class="stat-cell stat-manual">
            <div class="angka">{{ $statistik['scan_manual'] }}</div>
            <div class="label">Manual</div>
        </div>
        <div class="stat-cell stat-duplikat">
            <div class="angka">{{ $statistik['scan_duplikat'] }}</div>
            <div class="label">Duplikat</div>
        </div>
        <div class="stat-cell stat-unknown">
            <div class="angka">{{ $statistik['tidak_dikenal'] }}</div>
            <div class="label">Tdk Dikenal</div>
        </div>
        <div class="stat-cell stat-total">
            <div class="angka">{{ $statistik['total_siswa'] }}</div>
            <div class="label">Total Siswa</div>
        </div>
        <div class="stat-cell stat-persen">
            <div class="angka">{{ $statistik['persentase_hadir'] }}%</div>
            <div class="label">Kehadiran</div>
        </div>
    </div>

    {{-- ── Tabel Scan — pisah per tipe ────────────────────────────────────── --}}
    {{--
        $scanList sudah diurut: orderBy('tipe') → orderBy('waktu_scan')
        Jadi masuk muncul lebih dulu, lalu pulang.
        Kita grup manual dengan filter, bukan groupBy() Eloquent.
    --}}

    @php
        $scanMasuk  = $scanList->where('tipe', 'masuk');
        $scanPulang = $scanList->where('tipe', 'pulang');

        // Jika filter tipe spesifik, hanya tampilkan yang relevan
        $tampilMasuk  = ! $filter['tipe'] || $filter['tipe'] === 'masuk';
        $tampilPulang = ! $filter['tipe'] || $filter['tipe'] === 'pulang';
    @endphp

    {{-- ── Tabel Masuk ──────────────────────────────────────────────────────── --}}
    @if($tampilMasuk)
        <div class="section-title">Scan Masuk ({{ $scanMasuk->count() }} record)</div>
        <table class="scan">
            <thead class="masuk-head">
                <tr>
                    <th style="width:24px">No</th>
                    <th>Nama</th>
                    <th>NIS / NIP</th>
                    <th>Kelas</th>
                    <th class="center">Waktu</th>
                    <th class="center">Status</th>
                    <th class="center">Pemilik</th>
                    <th>Sesi</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($scanMasuk->values() as $i => $scan)
                    <tr>
                        <td class="no center">{{ $i + 1 }}</td>
                        <td style="font-weight:600">
                            {{ $scan->nama_pemilik }}
                            @if($scan->is_manual)
                                <br><span style="font-size:8px; color:#9ca3af; font-weight:normal">input manual</span>
                            @endif
                        </td>
                        <td class="mono" style="color:#555">
                            @if($scan->tipe_pemilik === 'siswa')
                                {{ $scan->siswa?->nis ?? '—' }}
                            @elseif($scan->tipe_pemilik === 'guru')
                                {{ $scan->guru?->nip ?? '—' }}
                            @else
                                <span style="color:#d97706">{{ $scan->kode_scan }}</span>
                            @endif
                        </td>
                        <td>
                            @if($scan->tipe_pemilik === 'siswa')
                                {{ $scan->siswa?->kelas?->nama_kelas ?? '—' }}
                            @elseif($scan->tipe_pemilik === 'guru')
                                <span class="badge badge-guru">Guru</span>
                            @else
                                <span style="color:#9ca3af">—</span>
                            @endif
                        </td>
                        <td class="center mono">{{ $scan->waktu_scan->format('H:i:s') }}</td>
                        <td class="center">
                            <span class="badge badge-{{ $scan->status }}">
                                {{ $scan->label_status }}
                            </span>
                        </td>
                        <td class="center">
                            @if($scan->tipe_pemilik !== 'unknown')
                                <span class="badge badge-{{ $scan->tipe_pemilik }}">
                                    {{ ucfirst($scan->tipe_pemilik) }}
                                </span>
                            @else
                                <span style="color:#9ca3af; font-size:9px">?</span>
                            @endif
                        </td>
                        <td style="font-size:9px; color:#555">
                            {{ $scan->sesiGerbang?->dibuka_pada?->format('H:i') ?? '—' }}
                        </td>
                        <td style="font-size:9px; color:#555">
                            {{ $scan->catatan
                                ? \Illuminate\Support\Str::limit($scan->catatan, 30)
                                : '—' }}
                        </td>
                    </tr>
                @empty
                    <tr class="empty"><td colspan="9">Tidak ada scan masuk pada filter ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    @endif

    {{-- ── Tabel Pulang ─────────────────────────────────────────────────────── --}}
    @if($tampilPulang)

        {{-- Page break jika scan masuk banyak agar tabel pulang tidak terpotong --}}
        @if($tampilMasuk && $scanMasuk->count() > 22)
            <div class="page-break"></div>
            <div class="doc-title" style="margin-bottom:10px">
                <h2>Log Absensi Gerbang Siswa</h2>
                <div class="sub">{{ \Carbon\Carbon::parse($filter['tanggal'])->isoFormat('D MMMM Y') }} — Lanjutan (Scan Pulang)</div>
            </div>
        @endif

        <div class="section-title">Scan Pulang ({{ $scanPulang->count() }} record)</div>
        <table class="scan">
            <thead class="pulang-head">
                <tr>
                    <th style="width:24px">No</th>
                    <th>Nama</th>
                    <th>NIS / NIP</th>
                    <th>Kelas</th>
                    <th class="center">Waktu</th>
                    <th class="center">Status</th>
                    <th class="center">Pemilik</th>
                    <th>Sesi</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($scanPulang->values() as $i => $scan)
                    <tr>
                        <td class="no center">{{ $i + 1 }}</td>
                        <td style="font-weight:600">
                            {{ $scan->nama_pemilik }}
                            @if($scan->is_manual)
                                <br><span style="font-size:8px; color:#9ca3af; font-weight:normal">input manual</span>
                            @endif
                        </td>
                        <td class="mono" style="color:#555">
                            @if($scan->tipe_pemilik === 'siswa')
                                {{ $scan->siswa?->nis ?? '—' }}
                            @elseif($scan->tipe_pemilik === 'guru')
                                {{ $scan->guru?->nip ?? '—' }}
                            @else
                                <span style="color:#d97706">{{ $scan->kode_scan }}</span>
                            @endif
                        </td>
                        <td>
                            @if($scan->tipe_pemilik === 'siswa')
                                {{ $scan->siswa?->kelas?->nama_kelas ?? '—' }}
                            @elseif($scan->tipe_pemilik === 'guru')
                                <span class="badge badge-guru">Guru</span>
                            @else
                                <span style="color:#9ca3af">—</span>
                            @endif
                        </td>
                        <td class="center mono">{{ $scan->waktu_scan->format('H:i:s') }}</td>
                        <td class="center">
                            <span class="badge badge-{{ $scan->status }}">
                                {{ $scan->label_status }}
                            </span>
                        </td>
                        <td class="center">
                            @if($scan->tipe_pemilik !== 'unknown')
                                <span class="badge badge-{{ $scan->tipe_pemilik }}">
                                    {{ ucfirst($scan->tipe_pemilik) }}
                                </span>
                            @else
                                <span style="color:#9ca3af; font-size:9px">?</span>
                            @endif
                        </td>
                        <td style="font-size:9px; color:#555">
                            {{ $scan->sesiGerbang?->dibuka_pada?->format('H:i') ?? '—' }}
                        </td>
                        <td style="font-size:9px; color:#555">
                            {{ $scan->catatan
                                ? \Illuminate\Support\Str::limit($scan->catatan, 30)
                                : '—' }}
                        </td>
                    </tr>
                @empty
                    <tr class="empty"><td colspan="9">Tidak ada scan pulang pada filter ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    @endif

    {{-- ── Footer & Tanda Tangan ───────────────────────────────────────────── --}}
    <div class="footer">
        <div class="footer-left">
            <div class="footer-meta">
                Dicetak pada&nbsp;&nbsp;: <span>{{ $filter['dicetak_pada'] }}</span><br>
                Dicetak oleh&nbsp;&nbsp;: <span>{{ $filter['dicetak_oleh'] }}</span><br>
                Filter tanggal : <span>{{ \Carbon\Carbon::parse($filter['tanggal'])->isoFormat('D MMMM Y') }}</span><br>
                Filter tipe&nbsp;&nbsp;&nbsp;: <span>{{ $filter['tipe'] ? ucfirst($filter['tipe']) : 'Semua' }}</span><br>
                Filter kelas&nbsp;&nbsp;: <span>{{ $filter['kelas_label'] }}</span>
            </div>
        </div>
        <div class="footer-right">
            <div class="ttd-label">Guru Piket,</div>
            <div class="ttd-name">{{ $filter['dicetak_oleh'] }}</div>
        </div>
    </div>

</div>
</body>
</html>