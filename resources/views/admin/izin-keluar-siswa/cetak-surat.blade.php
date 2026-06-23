<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Surat Izin Keluar — {{ $izin->nomor_surat ?? $izin->id }}</title>
<style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    @page { size: A4; margin: 0; }

    html, body {
        width: 100%;
        background: #fff;
        font-family: 'DejaVu Sans', sans-serif;
        color: #1a1a1a;
        font-size: 11.5px;
        line-height: 1.4;
    }

    .surat { padding: 26px 34px 30px; }

    /* ── KOP ── */
    .kop { display: table; width: 100%; }
    .kop-logo-cell { display: table-cell; width: 64px; vertical-align: middle; }
    .kop-logo { width: 58px; height: 58px; }
    .kop-logo img { width: 58px; height: 58px; object-fit: contain; }
    .kop-teks { display: table-cell; vertical-align: middle; text-align: center; padding: 0 6px; }
    .kop-instansi { font-size: 9px; color: #555; letter-spacing: .2px; }
    .kop-nama { font-size: 19px; font-weight: bold; text-transform: uppercase; letter-spacing: .4px; color: #000; line-height: 1.25; margin-top: 1px; }
    .kop-alamat { font-size: 9px; color: #555; margin-top: 3px; line-height: 1.5; }
    .kop-spacer { display: table-cell; width: 64px; }

    .garis-tebal { border: none; border-top: 3px solid #000; margin: 9px 0 1.5px; }
    .garis-tipis { border: none; border-top: .75px solid #000; margin-bottom: 18px; }

    /* ── JUDUL ── */
    .judul { text-align: center; margin-bottom: 16px; }
    .judul-teks { font-size: 13px; font-weight: bold; text-transform: uppercase; letter-spacing: 1.2px; display: inline-block; padding-bottom: 3px; border-bottom: 1.25px solid #000; }
    .judul-nomor { font-size: 10.5px; color: #444; margin-top: 6px; }

    /* ── PARAGRAF ── */
    .par { font-size: 11.5px; line-height: 1.55; text-align: justify; margin-bottom: 12px; }

    /* ── TABEL DATA (grid bordered) ── */
    .tbl { width: 100%; border-collapse: collapse; margin-bottom: 13px; border: .75px solid #cbd5e1; }
    .tbl-judul td {
        background: #1a1a1a; color: #fff;
        font-size: 9.5px; font-weight: bold; text-transform: uppercase; letter-spacing: .5px;
        padding: 6px 10px;
    }
    .tbl tr.row td { padding: 6px 10px; font-size: 11px; border-top: .75px solid #e2e8f0; vertical-align: top; }
    .tbl tr.row:nth-child(even) td { background: #f8fafc; }
    .td-label { width: 30%; font-weight: bold; color: #333; }
    .td-colon { width: 3%; text-align: center; color: #888; }
    .td-value { width: 67%; }
    .sub-info { font-size: 9.5px; color: #666; margin-top: 2px; }

    .badge {
        display: inline-block;
        font-size: 9px; font-weight: bold; text-transform: uppercase; letter-spacing: .3px;
        padding: 2.5px 9px; border-radius: 3px;
        border: 1px solid #0a52a0; color: #0a52a0;
    }
    .badge.hijau  { border-color: #16a34a; color: #15803d; }
    .badge.kuning { border-color: #b45309; color: #92400e; }

    /* ── KOTAK NOTE ── */
    .kotak { border-left: 3.5px solid #1a1a1a; background: #f8fafc; padding: 9px 13px; margin-bottom: 13px; font-size: 10.5px; line-height: 1.55; }
    .kotak-judul { font-weight: bold; font-size: 9.5px; text-transform: uppercase; margin-bottom: 4px; letter-spacing: .2px; }

    /* ── TTD ── */
    .ttd { display: table; width: 100%; margin-top: 8px; }
    .ttd-col { display: table-cell; width: 50%; text-align: center; vertical-align: top; padding: 0 10px; }
    .ttd-tgl { font-size: 11px; margin-bottom: 1px; }
    .ttd-jabatan { font-size: 11px; font-weight: bold; margin-bottom: 46px; }
    .ttd-nama { font-size: 11px; font-weight: bold; text-decoration: underline; }
    .ttd-nip { font-size: 9.5px; color: #555; margin-top: 2px; }

    .garis-putus { border: none; border-top: .75px dashed #ccc; margin: 16px 0 8px; }
    .catatan { font-size: 8.5px; color: #777; line-height: 1.5; }
    .footer-doc { font-size: 8px; color: #aaa; text-align: center; border-top: .5px solid #eee; padding-top: 6px; margin-top: 9px; }
</style>
</head>
<body>
<div class="surat">

    {{-- ── KOP ── --}}
    <div class="kop">
        <div class="kop-logo-cell">
            <div class="kop-logo">
                @if(!empty($profil->logo) && file_exists(public_path($profil->logo)))
                    <img src="{{ public_path($profil->logo) }}" alt="Logo">
                @endif
            </div>
        </div>
        <div class="kop-teks">
            @if(!empty($profil->nama_yayasan))
                <div class="kop-instansi">{{ $profil->nama_yayasan }}</div>
            @endif
            <div class="kop-nama">{{ $profil->nama_sekolah ?? 'SMK Bustanul Ulum Tamansari' }}</div>
            <div class="kop-alamat">
                {{ $profil->alamat ?? 'Jl. Tamansari, Kota Tasikmalaya, Jawa Barat' }}
                @if(!empty($profil->telepon)) &bull; Telp. {{ $profil->telepon }} @endif
                @if(!empty($profil->email)) &bull; {{ $profil->email }} @endif
                @if(!empty($profil->npsn)) &bull; NPSN: {{ $profil->npsn }} @endif
            </div>
        </div>
        <div class="kop-spacer"></div>
    </div>
    <hr class="garis-tebal">
    <hr class="garis-tipis">

    {{-- ── JUDUL ── --}}
    <div class="judul">
        <div class="judul-teks">Surat Keterangan Izin Keluar</div>
        <div class="judul-nomor">Nomor&nbsp;: <strong>{{ $izin->nomor_surat ?? '-' }}</strong></div>
    </div>

    <p class="par">
        Yang bertanda tangan di bawah ini, Kepala <strong>{{ $profil->nama_sekolah ?? 'SMK Bustanul Ulum Tamansari' }}</strong>,
        menerangkan dengan sesungguhnya bahwa siswa/siswi yang namanya tersebut di bawah ini:
    </p>

    {{-- ── TABEL DATA ── --}}
    <table class="tbl">
        <tr class="tbl-judul"><td colspan="3">Data Siswa &amp; Keterangan Izin</td></tr>

        <tr class="row">
            <td class="td-label">Nama Lengkap</td><td class="td-colon">:</td>
            <td class="td-value"><strong>{{ $izin->siswa->nama_lengkap ?? '-' }}</strong></td>
        </tr>
        <tr class="row">
            <td class="td-label">NIS / NISN</td><td class="td-colon">:</td>
            <td class="td-value">{{ $izin->siswa->nis ?? '-' }}@if(!empty($izin->siswa->nisn)) / {{ $izin->siswa->nisn }}@endif</td>
        </tr>
        <tr class="row">
            <td class="td-label">Kelas</td><td class="td-colon">:</td>
            <td class="td-value">{{ optional($izin->siswa->kelas)->nama_kelas ?? '-' }}</td>
        </tr>
        <tr class="row">
            <td class="td-label">Tahun Ajaran</td><td class="td-colon">:</td>
            <td class="td-value">
                {{ optional($izin->tahunAjaran)->tahun ?? '-' }}
                @if(optional($izin->tahunAjaran)->semester) &ndash; Semester {{ ucfirst($izin->tahunAjaran->semester) }} @endif
            </td>
        </tr>
        <tr class="row">
            <td class="td-label">Tanggal Keluar</td><td class="td-colon">:</td>
            <td class="td-value">{{ $izin->tanggal->translatedFormat('l, d F Y') }}</td>
        </tr>
        <tr class="row">
            <td class="td-label">Jam Keluar</td><td class="td-colon">:</td>
            <td class="td-value">
                <strong>{{ \Carbon\Carbon::parse($izin->jam_keluar)->format('H:i') }} WIB</strong>
                @if($izin->jam_kembali)
                    <div class="sub-info">Rencana kembali: <strong>{{ \Carbon\Carbon::parse($izin->jam_kembali)->format('H:i') }} WIB</strong></div>
                @endif
            </td>
        </tr>
        <tr class="row">
            <td class="td-label">Kategori Izin</td><td class="td-colon">:</td>
            <td class="td-value">{{ $izin->kategori_label ?? '-' }}</td>
        </tr>
        <tr class="row">
            <td class="td-label">Tujuan / Keperluan</td><td class="td-colon">:</td>
            <td class="td-value"><strong>{{ $izin->tujuan }}</strong></td>
        </tr>
        <tr class="row">
            <td class="td-label">Status Izin</td><td class="td-colon">:</td>
            <td class="td-value">
                @if($izin->status === \App\Models\IzinKeluarSiswa::STATUS_SUDAH_KEMBALI)
                    <span class="badge hijau">Sudah Kembali</span>
                    <div class="sub-info">Jam kembali aktual: <strong>{{ \Carbon\Carbon::parse($izin->jam_kembali_aktual)->format('H:i') }} WIB</strong></div>
                @elseif($izin->status === \App\Models\IzinKeluarSiswa::STATUS_DISETUJUI)
                    <span class="badge">Disetujui &mdash; Sedang Keluar</span>
                @else
                    <span class="badge kuning">{{ $izin->status_label ?? $izin->status }}</span>
                @endif
            </td>
        </tr>
    </table>

    @if($izin->keterangan)
    <div class="kotak">
        <div class="kotak-judul">Keterangan Tambahan</div>
        {{ $izin->keterangan }}
    </div>
    @endif

    <div class="kotak">
        <div class="kotak-judul">&#9888; Kepada Yth. Bapak / Ibu Petugas / Aparat Berwenang</div>
        Siswa/siswi tersebut di atas <strong>benar-benar telah mendapat izin resmi</strong>
        dari pihak sekolah untuk meninggalkan lingkungan sekolah pada waktu yang tertera.
        @if(!empty($profil->telepon))
            Verifikasi: <strong>{{ $profil->telepon }}</strong>.
        @endif
    </div>

    <p class="par" style="margin-bottom:6px">
        Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
    </p>

    {{-- ── TTD ── --}}
    <div class="ttd">
        <div class="ttd-col">
            <div class="ttd-tgl">Mengetahui,</div>
            <div class="ttd-jabatan">Petugas Piket</div>
            <div class="ttd-nama">{{ $izin->diprosesOleh->name ?? '( .......................... )' }}</div>
            @if(!empty($izin->diprosesOleh->nip))
                <div class="ttd-nip">NIP/NUPTK: {{ $izin->diprosesOleh->nip }}</div>
            @endif
        </div>
        <div class="ttd-col">
            <div class="ttd-tgl">Tasikmalaya, {{ $izin->diproses_pada ? $izin->diproses_pada->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }},</div>
            <div class="ttd-jabatan">Kepala Sekolah</div>
            <div class="ttd-nama">{{ $profil->nama_kepala_sekolah ?? '( .......................... )' }}</div>
            @if(!empty($profil->nip_kepala_sekolah))
                <div class="ttd-nip">NIP/NUPTK: {{ $profil->nip_kepala_sekolah }}</div>
            @endif
        </div>
    </div>

    <hr class="garis-putus">
    <div class="catatan">
        <strong>Catatan:</strong> Surat ini diterbitkan melalui Sistem Informasi Manajemen Sekolah
        dan hanya berlaku pada tanggal yang tertera. Tidak berlaku apabila dipalsukan atau digunakan di luar ketentuannya.
    </div>
    <div class="footer-doc">
        Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB &bull; {{ $profil->nama_sekolah ?? 'SMK Bustanul Ulum Tamansari' }} &bull; Dokumen resmi
    </div>

</div>
</body>
</html>