<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Absensi — {{ $sesiQr->kelas->nama_kelas ?? '' }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            background: #ffffff;
            color: #0f172a;
            width: 148mm;
            min-height: 210mm;
            padding: 12mm 14mm;
        }

        .header {
            text-align: center;
            margin-bottom: 6mm;
            padding-bottom: 5mm;
            border-bottom: 2px solid #1f63db;
        }

        .school-name {
            font-size: 13pt;
            font-weight: 800;
            color: #1f63db;
            letter-spacing: .03em;
            margin-bottom: 1mm;
        }

        .doc-title {
            font-size: 10pt;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .info-section {
            margin-bottom: 6mm;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }

        .info-table td {
            padding: 2.5mm 0;
            vertical-align: top;
        }

        .info-table td:first-child {
            width: 38mm;
            color: #64748b;
            font-weight: 700;
        }

        .info-table td:nth-child(2) {
            width: 6mm;
            color: #94a3b8;
            text-align: center;
        }

        .info-table td:last-child {
            font-weight: 700;
            color: #0f172a;
        }

        .qr-section {
            text-align: center;
            margin: 6mm 0;
        }

        .qr-wrapper {
            display: inline-block;
            padding: 6mm;
            border: 2px solid #e2e8f0;
            border-radius: 4mm;
            background: #f8fafc;
        }

        .qr-placeholder {
            width: 50mm;
            height: 50mm;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8pt;
            color: #94a3b8;
            margin: 0 auto;
        }

        .kode-text {
            margin-top: 4mm;
            font-size: 18pt;
            font-weight: 800;
            letter-spacing: .12em;
            color: #1f63db;
            font-family: 'DejaVu Sans Mono', monospace;
        }

        .kode-label {
            font-size: 8pt;
            color: #94a3b8;
            margin-top: 1mm;
        }

        .status-badge {
            display: inline-block;
            padding: 2mm 5mm;
            border-radius: 99mm;
            font-size: 9pt;
            font-weight: 800;
            margin-top: 3mm;
        }

        .status-aktif    { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .status-expired  { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }

        .instructions {
            margin-top: 6mm;
            padding: 4mm 5mm;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 3mm;
            font-size: 8.5pt;
            color: #1e40af;
        }

        .instructions-title {
            font-weight: 800;
            margin-bottom: 2mm;
            font-size: 9pt;
        }

        .instructions ol {
            padding-left: 5mm;
        }

        .instructions li {
            margin-bottom: 1.5mm;
            line-height: 1.5;
        }

        .time-section {
            margin-top: 5mm;
            padding: 3.5mm 5mm;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 3mm;
            font-size: 8.5pt;
        }

        .time-row {
            display: flex;
            justify-content: space-between;
            padding: 1.5mm 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .time-row:last-child { border-bottom: none; }

        .time-label { color: #64748b; font-weight: 700; }
        .time-val   { color: #0f172a; font-weight: 800; }

        .footer {
            margin-top: 7mm;
            padding-top: 4mm;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 7.5pt;
            color: #94a3b8;
        }

        .signature-area {
            display: flex;
            justify-content: space-between;
            margin-top: 8mm;
            font-size: 8.5pt;
        }

        .signature-box {
            text-align: center;
            width: 42%;
        }

        .signature-line {
            height: 12mm;
            border-bottom: 1px solid #0f172a;
            margin-bottom: 2mm;
        }

        .signature-label {
            font-size: 8pt;
            color: #475569;
        }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <p class="school-name">Sistem Absensi Digital</p>
        <p class="doc-title">QR Code Absensi Kelas</p>
    </div>

    {{-- Info Sesi --}}
    <div class="info-section">
        <table class="info-table">
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>{{ $sesiQr->kelas->nama_kelas ?? '—' }}</td>
            </tr>
            <tr>
                <td>Mata Pelajaran</td>
                <td>:</td>
                <td>{{ $sesiQr->mataPelajaran->nama_mapel ?? 'Semua Mata Pelajaran' }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($sesiQr->tanggal)->translatedFormat('l, d F Y') }}</td>
            </tr>
            @if($sesiQr->radius_meter)
            <tr>
                <td>Radius Lokasi</td>
                <td>:</td>
                <td>{{ $sesiQr->radius_meter }} meter</td>
            </tr>
            @endif
        </table>
    </div>

    {{-- QR Section --}}
    <div class="qr-section">
        <div class="qr-wrapper">
            {{--
                Catatan: Pada implementasi sebenarnya, gunakan library QR code seperti
                simplesoftwareio/simple-qrcode untuk generate QR code image.
                Contoh: {!! QrCode::size(160)->generate($sesiQr->kode_qr) !!}
                atau gunakan base64 image dari model.
            --}}
            <div class="qr-placeholder">
                [QR CODE]<br>{{ $sesiQr->kode_qr }}
            </div>
        </div>

        <p class="kode-text">{{ $sesiQr->kode_qr ?? '—' }}</p>
        <p class="kode-label">Kode QR Absensi</p>

        @php $isExpired = \Carbon\Carbon::parse($sesiQr->kadaluarsa_pada)->isPast() || !$sesiQr->is_active; @endphp
        <span class="status-badge {{ $isExpired ? 'status-expired' : 'status-aktif' }}">
            {{ $isExpired ? '⚠ Sesi Kedaluwarsa' : '✓ Sesi Aktif' }}
        </span>
    </div>

    {{-- Waktu Berlaku --}}
    <div class="time-section">
        <div class="time-row">
            <span class="time-label">Berlaku Mulai</span>
            <span class="time-val">{{ \Carbon\Carbon::parse($sesiQr->berlaku_mulai)->format('H:i') }} WIB</span>
        </div>
        <div class="time-row">
            <span class="time-label">Berakhir Pukul</span>
            <span class="time-val">{{ \Carbon\Carbon::parse($sesiQr->kadaluarsa_pada)->format('H:i') }} WIB</span>
        </div>
    </div>

    {{-- Petunjuk --}}
    <div class="instructions">
        <p class="instructions-title">📋 Cara Menggunakan</p>
        <ol>
            <li>Buka aplikasi absensi di smartphone Anda</li>
            <li>Pilih menu "Scan QR" atau "Absensi QR"</li>
            <li>Arahkan kamera ke QR code di atas</li>
            <li>Atau masukkan kode <strong>{{ $sesiQr->kode_qr }}</strong> secara manual</li>
            <li>Absensi hanya berlaku pada jam yang tertera</li>
        </ol>
    </div>

    {{-- Tanda Tangan --}}
    <div class="signature-area">
        <div class="signature-box">
            <div class="signature-line"></div>
            <p class="signature-label">Guru Pengajar</p>
        </div>
        <div class="signature-box">
            <div class="signature-line"></div>
            <p class="signature-label">Wali Kelas</p>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>Dicetak pada {{ \Carbon\Carbon::now()->format('d M Y, H:i') }} · Sesi ID: {{ $sesiQr->id }}</p>
        <p style="margin-top:1mm">Dokumen ini digenerate otomatis oleh sistem</p>
    </div>
</body>
</html>