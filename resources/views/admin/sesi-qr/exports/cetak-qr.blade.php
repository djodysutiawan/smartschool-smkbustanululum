<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak QR – {{ $sesiQr->kelas->nama_kelas ?? 'Sesi' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            background: #fff;
            color: #1a1a2e;
            width: 148mm;
            min-height: 210mm;
            padding: 12mm 10mm;
        }
        .card {
            border: 2px solid #1a1a2e;
            border-radius: 6px;
            overflow: hidden;
        }
        .card-header {
            background: #1a1a2e;
            color: #fff;
            text-align: center;
            padding: 10px 12px;
        }
        .card-header .school {
            font-size: 9px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            opacity: 0.75;
            margin-bottom: 3px;
        }
        .card-header h1 {
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .card-body {
            padding: 14px 16px;
        }
        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .info-row { display: table-row; }
        .info-label, .info-value {
            display: table-cell;
            padding: 4px 0;
            font-size: 9.5px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        .info-label {
            color: #666;
            width: 38%;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 8.5px;
            letter-spacing: 0.3px;
        }
        .info-value { font-weight: 700; }
        .qr-wrapper {
            text-align: center;
            padding: 14px 0 10px;
        }
        .qr-wrapper img {
            width: 150px;
            height: 150px;
            border: 3px solid #1a1a2e;
            border-radius: 4px;
            display: block;
            margin: 0 auto 8px;
            padding: 4px;
            background: #fff;
        }
        .qr-code-text {
            font-family: 'DejaVu Sans Mono', monospace;
            font-size: 7.5px;
            color: #777;
            word-break: break-all;
            padding: 0 10px;
            margin-top: 6px;
        }
        .status-row {
            text-align: center;
            margin-top: 12px;
        }
        .badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-aktif    { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .badge-nonaktif { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .card-footer {
            background: #f5f6fa;
            border-top: 1px solid #e8e8e8;
            text-align: center;
            padding: 7px 12px;
            font-size: 8px;
            color: #888;
        }
        .instructions {
            margin-top: 10mm;
            font-size: 8.5px;
            color: #555;
            line-height: 1.6;
        }
        .instructions ol { padding-left: 14px; }
        .instructions li { margin-bottom: 2px; }
        .instructions strong { color: #1a1a2e; }
    </style>
</head>
<body>

    <div class="card">

        <div class="card-header">
            <div class="school">{{ config('app.name', 'Sistem Absensi') }}</div>
            <h1>Scan QR Absensi</h1>
        </div>

        <div class="card-body">

            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Kelas</div>
                    <div class="info-value">{{ $sesiQr->kelas->nama_kelas ?? '-' }}</div>
                </div>
                @if($sesiQr->mataPelajaran)
                <div class="info-row">
                    <div class="info-label">Mata Pelajaran</div>
                    <div class="info-value">{{ $sesiQr->mataPelajaran->nama_mapel }}</div>
                </div>
                @endif
                <div class="info-row">
                    <div class="info-label">Tanggal</div>
                    <div class="info-value">{{ optional($sesiQr->tanggal)->format('d F Y') ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Berlaku Mulai</div>
                    <div class="info-value">{{ optional($sesiQr->berlaku_mulai)->format('H:i') ?? '-' }} WIB</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Kadaluarsa</div>
                    <div class="info-value">{{ optional($sesiQr->kadaluarsa_pada)->format('H:i') ?? '-' }} WIB</div>
                </div>
                @if($sesiQr->radius_meter)
                <div class="info-row">
                    <div class="info-label">Radius Lokasi</div>
                    <div class="info-value">{{ $sesiQr->radius_meter }} meter</div>
                </div>
                @endif
            </div>

            <div class="qr-wrapper">
                <img src="data:{{ $qrMime }};base64,{{ $qrBase64 }}"
                    alt="QR Code Absensi"
                    width="150"
                    height="150">
                <div class="qr-code-text">{{ $sesiQr->kode_qr }}</div>
            </div>

            <div class="status-row">
                @if($sesiQr->is_active)
                    <span class="badge badge-aktif">&#10003; Sesi Aktif</span>
                @else
                    <span class="badge badge-nonaktif">&#10007; Sesi Nonaktif</span>
                @endif
            </div>

        </div>

        <div class="card-footer">
            ID Sesi: {{ $sesiQr->id }} &mdash; {{ config('app.name', 'Sistem Absensi QR') }}
        </div>

    </div>

    <div class="instructions">
        <strong>Cara Absen:</strong>
        <ol>
            <li>Buka aplikasi absensi di HP siswa.</li>
            <li>Pilih menu <strong>Scan QR</strong>.</li>
            <li>Arahkan kamera ke kode QR di atas.</li>
            <li>Pastikan berada dalam radius <strong>{{ $sesiQr->radius_meter ?? '—' }} meter</strong> dari lokasi kelas.</li>
            <li>Absen hanya dapat dilakukan <strong>satu kali</strong> per sesi.</li>
        </ol>
    </div>

</body>
</html>