<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Surat Izin Keluar - {{ $izin->siswa->nama_lengkap ?? '' }}</title>
<style>
    @page { size: A4; margin: 22px 40px; }
    * { box-sizing: border-box; }
    body {
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 12px;
        color: #1a1a1a;
        line-height: 1.4;
    }

    /* ── Kop Surat ── */
    .kop {
        display: table;
        width: 100%;
        border-bottom: 3px solid #000;
        padding-bottom: 8px;
        margin-bottom: 2px;
    }
    .kop-logo {
        display: table-cell;
        width: 80px;
        vertical-align: middle;
    }
    .kop-logo img { width: 72px; height: 72px; object-fit: contain; }
    .kop-text {
        display: table-cell;
        vertical-align: middle;
        text-align: center;
        padding: 0 10px;
    }
    .kop-text .nama-yayasan { font-size: 12px; font-weight: bold; letter-spacing: .3px; margin: 0; }
    .kop-text .nama-sekolah { font-size: 20px; font-weight: bold; letter-spacing: .5px; margin: 2px 0; text-transform: uppercase; }
    .kop-text .alamat { font-size: 10.5px; margin: 0; }
    .kop-text .kontak { font-size: 9.5px; margin: 0; }
    .kop-line2 { border-bottom: 1px solid #000; margin-bottom: 14px; }

    /* ── Judul Surat ── */
    .judul { text-align: center; margin: 12px 0 2px; }
    .judul h1 { font-size: 15px; font-weight: bold; text-decoration: underline; text-transform: uppercase; margin: 0; letter-spacing: .5px; }
    .judul .nomor { font-size: 12px; margin-top: 2px; }

    /* ── Isi ── */
    .isi { margin-top: 14px; text-align: justify; }
    .isi p { margin: 0 0 9px; }

    table.data-siswa { width: 100%; margin: 8px 0 10px; border-collapse: collapse; }
    table.data-siswa td { padding: 2px 0; vertical-align: top; font-size: 12px; }
    table.data-siswa td.label { width: 170px; }
    table.data-siswa td.colon { width: 16px; }

    table.data-izin { width: 100%; margin: 4px 0 10px; border-collapse: collapse; }
    table.data-izin td { padding: 2px 0; vertical-align: top; font-size: 12px; }
    table.data-izin td.label { width: 170px; }
    table.data-izin td.colon { width: 16px; }

    .catatan-box {
        border: 1px solid #555;
        border-radius: 4px;
        padding: 8px 12px;
        font-size: 11px;
        background: #fafafa;
        margin: 4px 0 10px;
    }
    .catatan-box .ket-label { font-weight: bold; font-size: 10px; text-transform: uppercase; letter-spacing: .3px; color: #444; margin-bottom: 3px; }

    /* ── Tanda Tangan ── */
    .ttd-wrap { width: 100%; margin-top: 18px; display: table; }
    .ttd-tempat { text-align: right; margin-bottom: 2px; font-size: 12px; }
    .ttd-row { display: table; width: 100%; margin-top: 4px; }
    .ttd-col { display: table-cell; width: 50%; text-align: center; vertical-align: top; }
    .ttd-jabatan { font-size: 12px; margin-bottom: 2px; }
    .ttd-space { height: 56px; }
    .ttd-nama { font-size: 12px; font-weight: bold; text-decoration: underline; margin: 0; }
    .ttd-nip { font-size: 10.5px; margin-top: 2px; }

    .footer-note {
        margin-top: 16px;
        font-size: 9px;
        color: #777;
        text-align: center;
        border-top: .5px dotted #ccc;
        padding-top: 5px;
    }

    .badge-status {
        display: inline-block;
        font-size: 10px;
        font-weight: bold;
        padding: 1px 8px;
        border: 1px solid #16a34a;
        color: #15803d;
        border-radius: 3px;
        letter-spacing: .3px;
    }
</style>
</head>
<body>

    {{-- ── KOP SURAT ── --}}
    <div class="kop">
        <div class="kop-logo">
            @if(!empty($profil->logo) && file_exists(public_path($profil->logo)))
                <img src="{{ public_path($profil->logo) }}" alt="Logo">
            @endif
        </div>
        <div class="kop-text">
            @if(!empty($profil->nama_yayasan))
                <p class="nama-yayasan">{{ $profil->nama_yayasan }}</p>
            @endif
            <p class="nama-sekolah">{{ $profil->nama_sekolah ?? 'SMK BUSTANUL ULUM TAMANSARI' }}</p>
            <p class="alamat">{{ $profil->alamat ?? 'Jl. Tamansari, Kota Tasikmalaya, Jawa Barat' }}</p>
            <p class="kontak">
                @if(!empty($profil->telepon)) Telp: {{ $profil->telepon }} @endif
                @if(!empty($profil->email)) &nbsp;|&nbsp; Email: {{ $profil->email }} @endif
                @if(!empty($profil->website)) &nbsp;|&nbsp; {{ $profil->website }} @endif
            </p>
        </div>
        <div class="kop-logo"></div>
    </div>
    <div class="kop-line2"></div>

    {{-- ── JUDUL ── --}}
    <div class="judul">
        <h1>Surat Izin Keluar Siswa</h1>
        <p class="nomor">Nomor: {{ $izin->nomor_surat ?? '-' }}</p>
    </div>

    {{-- ── ISI ── --}}
    <div class="isi">
        <p>
            Yang bertanda tangan di bawah ini, Petugas Piket {{ $profil->nama_sekolah ?? 'SMK Bustanul Ulum Tamansari' }},
            dengan ini menerangkan bahwa siswa dengan data sebagai berikut diberikan izin untuk
            meninggalkan lingkungan sekolah pada jam kegiatan belajar:
        </p>

        <table class="data-siswa">
            <tr>
                <td class="label">Nama Siswa</td><td class="colon">:</td>
                <td><strong>{{ $izin->siswa->nama_lengkap ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td class="label">NIS</td><td class="colon">:</td>
                <td>{{ $izin->siswa->nis ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kelas</td><td class="colon">:</td>
                <td>{{ optional($izin->siswa->kelas)->nama_kelas ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tahun Ajaran</td><td class="colon">:</td>
                <td>{{ optional($izin->tahunAjaran)->tahun ?? '-' }} / {{ optional($izin->tahunAjaran)->semester ? ucfirst($izin->tahunAjaran->semester) : '-' }}</td>
            </tr>
        </table>

        <table class="data-izin">
            <tr>
                <td class="label">Hari, Tanggal</td><td class="colon">:</td>
                <td>{{ $izin->tanggal->translatedFormat('l, d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Kategori Izin</td><td class="colon">:</td>
                <td>{{ $izin->kategori_label ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tujuan / Keperluan</td><td class="colon">:</td>
                <td>{{ $izin->tujuan }}</td>
            </tr>
            <tr>
                <td class="label">Jam Keluar</td><td class="colon">:</td>
                <td>{{ \Carbon\Carbon::parse($izin->jam_keluar)->format('H:i') }} WIB</td>
            </tr>
            <tr>
                <td class="label">Estimasi Jam Kembali</td><td class="colon">:</td>
                <td>
                    @if($izin->jam_kembali)
                        {{ \Carbon\Carbon::parse($izin->jam_kembali)->format('H:i') }} WIB
                    @else
                        -
                    @endif
                </td>
            </tr>
            @if($izin->jam_kembali_aktual)
            <tr>
                <td class="label">Jam Kembali Aktual</td><td class="colon">:</td>
                <td>{{ \Carbon\Carbon::parse($izin->jam_kembali_aktual)->format('H:i') }} WIB &nbsp; <span class="badge-status">SUDAH KEMBALI</span></td>
            </tr>
            @endif
        </table>

        @if($izin->keterangan)
        <div class="catatan-box">
            <p class="ket-label">Keterangan Tambahan</p>
            <p style="margin:0">{{ $izin->keterangan }}</p>
        </div>
        @endif

        <p>
            Demikian surat izin ini dibuat untuk dipergunakan sebagaimana mestinya. Orang tua/wali
            siswa dan pihak terkait dimohon untuk turut mengawasi kepulangan siswa sesuai jam yang
            telah ditentukan di atas.
        </p>
    </div>

    {{-- ── TANDA TANGAN ── --}}
    <div class="ttd-wrap">
        <p class="ttd-tempat">
            Tasikmalaya, {{ $izin->diproses_pada ? $izin->diproses_pada->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
        </p>

        <div class="ttd-row">
            <div class="ttd-col">
                <p class="ttd-jabatan">Petugas Piket</p>
                <div class="ttd-space"></div>
                <p class="ttd-nama">{{ $izin->diprosesOleh->name ?? '...........................' }}</p>
                <p class="ttd-nip">NIP/NUPTK: {{ $izin->diprosesOleh->nip ?? '-' }}</p>
            </div>
            <div class="ttd-col">
                <p class="ttd-jabatan">Kepala Sekolah</p>
                <div class="ttd-space"></div>
                <p class="ttd-nama">{{ $profil->nama_kepala_sekolah ?? '...........................' }}</p>
                <p class="ttd-nip">NIP/NUPTK: {{ $profil->nip_kepala_sekolah ?? '-' }}</p>
            </div>
        </div>
    </div>

    <p class="footer-note">
        Surat ini digenerate otomatis oleh Sistem Informasi Piket {{ $profil->nama_sekolah ?? 'SMK Bustanul Ulum Tamansari' }}
        pada {{ now()->translatedFormat('d F Y, H:i') }} WIB.
    </p>

</body>
</html>