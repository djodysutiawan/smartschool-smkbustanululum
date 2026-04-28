<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Izin Keluar - {{ $izin->nomor_surat ?? 'Draft' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            color: #000;
            background: #fff;
        }

        .page {
            width: 100%;
            padding: 14mm 16mm 12mm 18mm;
        }

        /* ── KOP SURAT (table-based untuk DomPDF) ── */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .kop-table td {
            padding: 0;
            vertical-align: middle;
        }

        .kop-logo-cell {
            width: 60px;
            text-align: center;
            vertical-align: middle;
        }

        .kop-logo-circle {
            width: 54px;
            height: 54px;
            border: 2px solid #333;
            border-radius: 50%;
            text-align: center;
            font-size: 8pt;
            color: #555;
            line-height: 54px;
        }

        .kop-text-cell {
            text-align: center;
            vertical-align: middle;
            padding: 0 4px;
        }

        .kop-instansi {
            font-size: 9pt;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .kop-nama-sekolah {
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .kop-alamat {
            font-size: 8.5pt;
            margin-top: 2px;
        }

        .garis-kop {
            border-top: 3px double #000;
            margin: 7px 0 12px;
        }

        /* ── JUDUL ── */
        .judul-wrapper {
            text-align: center;
            margin-bottom: 10px;
        }

        .judul-surat {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-decoration: underline;
        }

        .nomor-surat {
            font-size: 10.5pt;
            margin-top: 3px;
        }

        /* ── PEMBUKA ── */
        .pembuka {
            margin-bottom: 8px;
            line-height: 1.6;
            font-size: 11pt;
            text-align: justify;
        }

        /* ── TABEL DATA ── */
        .tabel-data {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0 10px;
            font-size: 11pt;
        }

        .tabel-data td {
            padding: 4px 6px;
            vertical-align: top;
        }

        .tabel-data .col-label { width: 36%; }
        .tabel-data .col-sep   { width: 4%; text-align: center; }
        .tabel-data .col-value { width: 60%; }

        .tabel-data tr.alt td {
            background-color: #f5f5f5;
        }

        /* ── KOTAK PESAN ── */
        .kotak-pesan {
            border: 1px solid #555;
            padding: 8px 10px;
            margin: 10px 0;
            font-size: 10.5pt;
            background-color: #fffbe6;
            line-height: 1.65;
        }

        .kotak-pesan-judul {
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 5px;
        }

        /* ── PENUTUP ── */
        .penutup {
            margin: 10px 0 12px;
            line-height: 1.7;
            font-size: 11pt;
            text-align: justify;
        }

        /* ── TANDA TANGAN (table-based) ── */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 8px;
            font-size: 11pt;
        }

        .ttd-space {
            height: 55px;
        }

        .ttd-nama {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 3px;
            font-size: 11pt;
        }

        .ttd-jabatan {
            font-size: 9.5pt;
            margin-top: 1px;
        }

        .ttd-tanggal {
            font-size: 8.5pt;
            color: #555;
            margin-top: 2px;
        }

        /* ── STATUS BADGE ── */
        .badge {
            display: inline;
            padding: 2px 8px;
            font-size: 9pt;
            font-weight: bold;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .badge-disetujui { border: 1.5px solid #1a7a1a; color: #1a7a1a; }
        .badge-menunggu  { border: 1.5px solid #b87800; color: #b87800; }
        .badge-ditolak   { border: 1.5px solid #aa0000; color: #aa0000; }

        /* ── CATATAN BAWAH ── */
        .catatan-bawah {
            margin-top: 14px;
            padding-top: 6px;
            border-top: 1px dashed #777;
            font-size: 8.5pt;
            color: #444;
            line-height: 1.55;
        }

        /* ── FOOTER ── */
        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 7.5pt;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 4px;
        }
    </style>
</head>
<body>
<div class="page">

    {{-- ══ KOP SURAT ══ --}}
    <table class="kop-table">
        <tr>
            <td class="kop-logo-cell">
                <div class="kop-logo-circle">LOGO</div>
            </td>
            <td class="kop-text-cell">
                <div class="kop-instansi">Pemerintah Daerah &mdash; Dinas Pendidikan</div>
                <div class="kop-nama-sekolah">{{ config('app.nama_sekolah', 'SMA Negeri 1 Contoh') }}</div>
                <div class="kop-alamat">
                    {{ config('app.alamat_sekolah', 'Jl. Pendidikan No. 1, Kota Contoh') }}
                    &nbsp;&bull;&nbsp; Telp. {{ config('app.telepon_sekolah', '(021) 123456') }}
                    &nbsp;&bull;&nbsp; NPSN: {{ config('app.npsn_sekolah', '20000000') }}
                </div>
            </td>
        </tr>
    </table>

    <div class="garis-kop"></div>

    {{-- ══ JUDUL ══ --}}
    <div class="judul-wrapper">
        <div class="judul-surat">Surat Keterangan Izin Keluar</div>
        <div class="nomor-surat">
            @if($izin->nomor_surat)
                Nomor&nbsp;:&nbsp;<strong>{{ $izin->nomor_surat }}</strong>
            @else
                <em>Nomor surat belum diterbitkan</em>
            @endif
        </div>
    </div>

    {{-- ══ PEMBUKA ══ --}}
    <div class="pembuka">
        Yang bertanda tangan di bawah ini, Kepala
        <strong>{{ config('app.nama_sekolah', 'SMA Negeri 1 Contoh') }}</strong>,
        menerangkan dengan sesungguhnya bahwa siswa/siswi yang namanya tersebut di bawah ini:
    </div>

    {{-- ══ TABEL DATA ══ --}}
    <table class="tabel-data">
        <tr>
            <td class="col-label">Nama Lengkap</td>
            <td class="col-sep">:</td>
            <td class="col-value"><strong>{{ $izin->siswa->nama_lengkap }}</strong></td>
        </tr>
        <tr class="alt">
            <td class="col-label">NIS / NISN</td>
            <td class="col-sep">:</td>
            <td class="col-value">
                {{ $izin->siswa->nis ?? '-' }}
                @if($izin->siswa->nisn) &nbsp;/&nbsp; {{ $izin->siswa->nisn }} @endif
            </td>
        </tr>
        <tr>
            <td class="col-label">Kelas</td>
            <td class="col-sep">:</td>
            <td class="col-value">{{ $izin->siswa->kelas->nama_kelas ?? '-' }}</td>
        </tr>
        <tr class="alt">
            <td class="col-label">Tahun Ajaran</td>
            <td class="col-sep">:</td>
            <td class="col-value">
                {{ $izin->tahunAjaran->tahun ?? '-' }}
                @if($izin->tahunAjaran)
                    &nbsp;&ndash;&nbsp; Semester {{ $izin->tahunAjaran->semester ?? '' }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="col-label">Tanggal Keluar</td>
            <td class="col-sep">:</td>
            <td class="col-value">
                {{ \Carbon\Carbon::parse($izin->tanggal)->locale('id')->translatedFormat('l, d F Y') }}
            </td>
        </tr>
        <tr class="alt">
            <td class="col-label">Jam Keluar</td>
            <td class="col-sep">:</td>
            <td class="col-value">
                {{ \Carbon\Carbon::parse($izin->jam_keluar)->format('H:i') }} WIB
                @if($izin->jam_kembali)
                    &mdash; Kembali pukul
                    <strong>{{ \Carbon\Carbon::parse($izin->jam_kembali)->format('H:i') }} WIB</strong>
                @endif
            </td>
        </tr>
        <tr>
            <td class="col-label">Kategori Izin</td>
            <td class="col-sep">:</td>
            <td class="col-value">
                {{ \App\Models\IzinKeluarSiswa::KATEGORI_LIST[$izin->kategori] ?? ucfirst($izin->kategori) }}
            </td>
        </tr>
        <tr class="alt">
            <td class="col-label">Tujuan / Keperluan</td>
            <td class="col-sep">:</td>
            <td class="col-value"><strong>{{ $izin->tujuan }}</strong></td>
        </tr>
        @if($izin->keterangan)
        <tr>
            <td class="col-label">Keterangan</td>
            <td class="col-sep">:</td>
            <td class="col-value">{{ $izin->keterangan }}</td>
        </tr>
        @endif
        <tr class="{{ $izin->keterangan ? 'alt' : '' }}">
            <td class="col-label">Status Izin</td>
            <td class="col-sep">:</td>
            <td class="col-value">
                @php
                    $badgeClass = match($izin->status) {
                        \App\Models\IzinKeluarSiswa::STATUS_DISETUJUI => 'badge-disetujui',
                        \App\Models\IzinKeluarSiswa::STATUS_MENUNGGU  => 'badge-menunggu',
                        \App\Models\IzinKeluarSiswa::STATUS_DITOLAK   => 'badge-ditolak',
                        default                                        => 'badge-menunggu',
                    };
                    $statusLabel = \App\Models\IzinKeluarSiswa::STATUS_LIST[$izin->status] ?? ucfirst($izin->status);
                @endphp
                <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
            </td>
        </tr>
    </table>

    {{-- ══ KOTAK PESAN APARAT ══ --}}
    <div class="kotak-pesan">
        <div class="kotak-pesan-judul">&#9888; Kepada Yth. Bapak/Ibu Petugas / Aparat Berwenang</div>
        Siswa/siswi tersebut di atas <strong>benar-benar telah mendapat izin resmi</strong>
        dari pihak sekolah untuk meninggalkan lingkungan sekolah pada waktu yang tertera.
        Apabila terdapat keperluan verifikasi, silakan menghubungi pihak sekolah melalui nomor
        yang tertera pada kop surat ini. Atas perhatian dan kerja samanya kami ucapkan terima kasih.
    </div>

    {{-- ══ PENUTUP ══ --}}
    <div class="penutup">
        Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
    </div>

    {{-- ══ TANDA TANGAN ══ --}}
    <table class="ttd-table">
        <tr>
            <td>
                Mengetahui,<br>Petugas Piket
                <div class="ttd-space"></div>
                <div class="ttd-nama">
                    @if($izin->diprosesOleh)
                        {{ $izin->diprosesOleh->name }}
                    @else
                        (..................................)
                    @endif
                </div>
                <div class="ttd-jabatan">Petugas Piket</div>
                @if($izin->diproses_pada)
                    <div class="ttd-tanggal">
                        {{ \Carbon\Carbon::parse($izin->diproses_pada)->locale('id')->translatedFormat('d F Y, H:i') }} WIB
                    </div>
                @endif
            </td>
            <td>
                {{ \Carbon\Carbon::parse($izin->tanggal)->locale('id')->translatedFormat('d F Y') }},<br>
                Kepala Sekolah
                <div class="ttd-space"></div>
                <div class="ttd-nama">{{ config('app.nama_kepala_sekolah', 'Drs. H. Nama Kepala, M.Pd.') }}</div>
                <div class="ttd-jabatan">NIP. {{ config('app.nip_kepala_sekolah', '19700101 199601 1 001') }}</div>
            </td>
        </tr>
    </table>

    {{-- ══ CATATAN BAWAH ══ --}}
    <div class="catatan-bawah">
        <strong>Catatan:</strong>
        Surat ini diterbitkan secara resmi melalui Sistem Informasi Manajemen Sekolah dan berlaku
        hanya pada tanggal yang tertera. Surat ini <u>tidak berlaku</u> apabila dipalsukan atau
        digunakan di luar ketentuan yang ditetapkan.
        @if($izin->catatan_piket)
            <br><em>Catatan piket: {{ $izin->catatan_piket }}</em>
        @endif
    </div>

    {{-- ══ FOOTER ══ --}}
    <div class="footer">
        Dicetak: {{ now()->locale('id')->translatedFormat('d F Y, H:i') }} WIB
        &nbsp;&bull;&nbsp; {{ config('app.nama_sekolah', 'SMA Negeri 1 Contoh') }}
        &nbsp;&bull;&nbsp; Dokumen resmi, harap dijaga
    </div>

</div>
</body>
</html>