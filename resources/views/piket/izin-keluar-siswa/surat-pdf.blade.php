<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Surat Izin Keluar – {{ $izin->nomor_surat }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10.5pt;
            color: #1a1a1a;
            background: #fff;
        }

        .page {
            width: 148mm;
            min-height: 210mm;
            padding: 12mm 15mm 18mm 15mm;
            position: relative;
        }

        /* ── Kop ── */
        .kop {
            border-bottom: 2.5px solid #0f172a;
            padding-bottom: 8px;
            margin-bottom: 10px;
            text-align: center;
        }
        .kop-instansi { font-size: 8.5pt; color: #555; display: block; letter-spacing: .3px; }
        .kop-nama     { font-size: 14.5pt; font-weight: bold; color: #0f172a; display: block; margin-top: 1px; letter-spacing: .4px; }
        .kop-alamat   { font-size: 8pt; color: #666; margin-top: 3px; display: block; }
        .kop-kontak   { font-size: 7.5pt; color: #888; margin-top: 1px; display: block; }

        /* ── Judul ── */
        .judul-wrap  { text-align: center; margin: 10px 0 4px; }
        .judul-title { font-size: 12pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1.5px; display: block; }
        .judul-nomor { font-size: 8.5pt; color: #555; margin-top: 3px; display: block; }
        hr.divider   { border: none; border-top: 1px solid #bbb; margin: 8px 0 10px; }

        /* ── Teks ── */
        .pembuka, .penutup { font-size: 9.5pt; line-height: 1.65; text-align: justify; }
        .pembuka { margin-bottom: 10px; }
        .penutup  { margin-bottom: 14px; }

        /* ── Tabel Data ── */
        .data-tbl           { width: 100%; border-collapse: collapse; margin: 8px 0 10px; font-size: 9.5pt; }
        .data-tbl td        { padding: 3.5px 5px; vertical-align: top; line-height: 1.5; }
        .data-tbl td.col-key  { width: 38mm; color: #444; }
        .data-tbl td.col-sep  { width: 6mm; text-align: center; }
        .data-tbl td.col-val  { font-weight: bold; }
        .data-tbl td.col-val.normal { font-weight: normal; }

        /* ── Badge ── */
        .status-badge         { display: inline-block; padding: 2px 9px; border-radius: 3px; font-size: 8pt; font-weight: bold; letter-spacing: .5px; }
        .status-disetujui     { background: #dcfce7; color: #14532d; border: 1px solid #86efac; }
        .status-sudah_kembali { background: #dbeafe; color: #1e3a8a; border: 1px solid #93c5fd; }

        /* ── TTD — satu blok, rata kanan ── */
        .ttd-wrap    { width: 55mm; margin-left: auto; text-align: center; font-size: 9pt; margin-top: 14px; }
        .ttd-role    { font-size: 8.5pt; color: #555; display: block; margin-bottom: 1px; }
        .ttd-kota    { font-size: 8pt; color: #666; display: block; margin-bottom: 44px; }
        .ttd-nama    { font-weight: bold; border-top: 1px solid #1a1a1a; padding-top: 4px; display: block; font-size: 9pt; }
        .ttd-jabatan { font-size: 7.5pt; color: #555; display: block; margin-top: 2px; }
        .ttd-nip     { font-size: 7pt; color: #777; display: block; margin-top: 1px; }

        /* ── Footer ── */
        .footer {
            position: absolute;
            bottom: 10mm; left: 15mm; right: 15mm;
            border-top: 1px dashed #ccc;
            padding-top: 5px;
            font-size: 7pt; color: #aaa; text-align: center;
        }
    </style>
</head>
<body>
<div class="page">

    {{-- ── Kop Surat ── --}}
    <div class="kop">
        <span class="kop-instansi">PEMERINTAH DAERAH</span>
        <span class="kop-nama">SEKOLAH MENENGAH ATAS NEGERI</span>
        <span class="kop-alamat">Jl. Contoh No. 1, Kota, Provinsi &nbsp;·&nbsp; Telp. (021) 000-0000</span>
        <span class="kop-kontak">Email: info@sekolah.sch.id &nbsp;·&nbsp; Website: www.sekolah.sch.id</span>
    </div>

    {{-- ── Judul ── --}}
    <div class="judul-wrap">
        <span class="judul-title">Surat Izin Keluar Siswa</span>
        <span class="judul-nomor">Nomor: {{ $izin->nomor_surat }}</span>
    </div>
    <hr class="divider">

    {{-- ── Pembuka ── --}}
    <p class="pembuka">
        Yang bertanda tangan di bawah ini, guru piket
        <strong>{{ $guruPiketAktif?->nama_lengkap ?? 'Guru Piket' }}</strong>,
        menerangkan bahwa siswa tersebut di bawah telah mendapat izin untuk meninggalkan lingkungan sekolah:
    </p>

    {{-- ── Data ── --}}
    <table class="data-tbl">
        <tr>
            <td class="col-key">Nama Siswa</td>
            <td class="col-sep">:</td>
            <td class="col-val">{{ $izin->siswa->nama_lengkap ?? '—' }}</td>
        </tr>
        <tr>
            <td class="col-key">Kelas</td>
            <td class="col-sep">:</td>
            <td class="col-val">{{ $izin->siswa->kelas->nama_kelas ?? '—' }}</td>
        </tr>
        <tr>
            <td class="col-key">Tanggal</td>
            <td class="col-sep">:</td>
            <td class="col-val">{{ $izin->tanggal->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="col-key">Kategori Izin</td>
            <td class="col-sep">:</td>
            <td class="col-val">{{ $izin->kategori_label }}</td>
        </tr>
        <tr>
            <td class="col-key">Tujuan / Keperluan</td>
            <td class="col-sep">:</td>
            <td class="col-val">{{ $izin->tujuan }}</td>
        </tr>
        <tr>
            <td class="col-key">Jam Keluar</td>
            <td class="col-sep">:</td>
            <td class="col-val">{{ \Carbon\Carbon::parse($izin->jam_keluar)->format('H:i') }} WIB</td>
        </tr>
        <tr>
            <td class="col-key">Perkiraan Kembali</td>
            <td class="col-sep">:</td>
            <td class="col-val">
                @if($izin->jam_kembali)
                    {{ \Carbon\Carbon::parse($izin->jam_kembali)->format('H:i') }} WIB
                @else
                    —
                @endif
            </td>
        </tr>
        @if($izin->isSudahKembali() && $izin->jam_kembali_aktual)
        <tr>
            <td class="col-key">Kembali Aktual</td>
            <td class="col-sep">:</td>
            <td class="col-val">
                {{ \Carbon\Carbon::parse($izin->jam_kembali_aktual)->format('H:i') }} WIB
                @if($izin->durasi_formatted && $izin->durasi_formatted !== '-')
                    ({{ $izin->durasi_formatted }})
                @endif
            </td>
        </tr>
        @endif
        <tr>
            <td class="col-key">Status</td>
            <td class="col-sep">:</td>
            <td class="col-val">
                <span class="status-badge status-{{ $izin->status }}">
                    {{ strtoupper($izin->status_label) }}
                </span>
            </td>
        </tr>
        @if($izin->keterangan)
        <tr>
            <td class="col-key">Keterangan</td>
            <td class="col-sep">:</td>
            <td class="col-val normal">{{ $izin->keterangan }}</td>
        </tr>
        @endif
        @if($izin->catatan_piket)
        <tr>
            <td class="col-key">Catatan Piket</td>
            <td class="col-sep">:</td>
            <td class="col-val normal">{{ $izin->catatan_piket }}</td>
        </tr>
        @endif
    </table>

    {{-- ── Penutup ── --}}
    <p class="penutup">
        Demikian surat izin ini dibuat untuk dipergunakan sebagaimana mestinya.
        Siswa yang bersangkutan diharapkan kembali ke sekolah tepat waktu sesuai ketentuan yang berlaku.
    </p>

    {{-- ── Tanda Tangan — satu TTD, rata kanan ── --}}
    <div class="ttd-wrap">
        <span class="ttd-role">Guru Piket,</span>
        <span class="ttd-kota">{{ $izin->tanggal->translatedFormat('d F Y') }}</span>
        @if($guruPiketAktif)
            <span class="ttd-nama">{{ $guruPiketAktif->nama_lengkap }}</span>
            @if(!empty($guruPiketAktif->nip))
                <span class="ttd-nip">NIP. {{ $guruPiketAktif->nip }}</span>
            @endif
        @else
            <span class="ttd-nama">( _________________________ )</span>
        @endif
        <span class="ttd-jabatan">Guru Piket</span>
    </div>

    {{-- ── Footer ── --}}
    <div class="footer">
        Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }} WIB
        &nbsp;·&nbsp;
        Surat ini sah tanpa tanda tangan basah apabila dicetak langsung dari sistem
    </div>

</div>
</body>
</html>