<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak QR Guru – {{ \Carbon\Carbon::parse($sesiQrGuru->tanggal)->format('d M Y') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            background: #fff;
            color: #1a1a2e;
            width: 148mm;
            min-height: 210mm;
            padding: 10mm 9mm;
        }

        /* ── Bingkai ── */
        .card {
            border: 2px solid #1a1a2e;
            border-radius: 6px;
            overflow: hidden;
        }

        /* ── Header strip ── */
        .card-header {
            background: #1a1a2e;
            color: #fff;
            text-align: center;
            padding: 10px 12px;
        }
        .card-header .school {
            font-size: 8.5px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            opacity: 0.7;
            margin-bottom: 3px;
        }
        .card-header h1 {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }
        .card-header .sub {
            font-size: 9px;
            opacity: 0.65;
            margin-top: 3px;
        }

        /* ── Body ── */
        .card-body { padding: 12px 15px; }

        /* Info table */
        .info-table {
            display: table;
            width: 100%;
            margin-bottom: 12px;
        }
        .info-row { display: table-row; }
        .info-label, .info-value {
            display: table-cell;
            padding: 4px 0;
            font-size: 9px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        .info-label {
            color: #6b7280;
            width: 36%;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 8px;
            letter-spacing: 0.3px;
        }
        .info-value { font-weight: 700; }

        /* ── QR wrapper ── */
        .qr-wrapper {
            text-align: center;
            padding: 12px 0 8px;
        }
        .qr-wrapper img {
            width: 140px;
            height: 140px;
            border: 3px solid #1a1a2e;
            border-radius: 6px;
            display: block;
            margin: 0 auto 8px;
        }
        .qr-placeholder {
            width: 140px;
            height: 140px;
            border: 3px dashed #ccc;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            color: #aaa;
            font-size: 8px;
            text-align: center;
            line-height: 1.5;
            padding: 10px;
        }
        .qr-code-text {
            font-family: 'DejaVu Sans Mono', monospace;
            font-size: 7px;
            color: #777;
            word-break: break-all;
            padding: 0 8px;
        }

        /* ── Status badge ── */
        .status-row {
            text-align: center;
            margin-top: 10px;
        }
        .badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .badge-aktif    { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .badge-nonaktif { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .badge-kadaluarsa { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }

        /* ── Card footer ── */
        .card-footer {
            background: #f5f6fa;
            border-top: 1px solid #e8e8e8;
            text-align: center;
            padding: 7px 12px;
            font-size: 7.5px;
            color: #888;
        }

        /* ── Instruksi ── */
        .instructions {
            margin-top: 8mm;
            font-size: 8px;
            color: #555;
            line-height: 1.6;
        }
        .instructions ol { padding-left: 13px; }
        .instructions li { margin-bottom: 2px; }
        .instructions strong { color: #1a1a2e; }

        /* ── Khusus Guru badge ── */
        .guru-badge {
            display: inline-block;
            background: #ede9fe;
            color: #5b21b6;
            border: 1px solid #c4b5fd;
            border-radius: 4px;
            padding: 2px 8px;
            font-size: 7.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>

    <div class="card">

        <div class="card-header">
            <div class="school">{{ config('app.name', 'Sistem Absensi') }}</div>
            <h1>Scan QR Absensi Guru</h1>
            <div class="sub">{{ \Carbon\Carbon::parse($sesiQrGuru->tanggal)->translatedFormat('l, d F Y') }}</div>
        </div>

        <div class="card-body">

            <div style="text-align:center;margin-bottom:10px">
                <span class="guru-badge">&#128100; Khusus Guru</span>
            </div>

            <div class="info-table">
                <div class="info-row">
                    <div class="info-label">Tanggal</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($sesiQrGuru->tanggal)->format('d F Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Berlaku Mulai</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($sesiQrGuru->berlaku_mulai)->format('H:i') }} WIB</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Kadaluarsa</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($sesiQrGuru->kadaluarsa_pada)->format('H:i') }} WIB</div>
                </div>
                @if($sesiQrGuru->radius_meter)
                <div class="info-row">
                    <div class="info-label">Radius Lokasi</div>
                    <div class="info-value">{{ $sesiQrGuru->radius_meter }} meter</div>
                </div>
                @endif
                <div class="info-row">
                    <div class="info-label">Dibuat Oleh</div>
                    <div class="info-value">{{ $sesiQrGuru->pembuat->name ?? '—' }}</div>
                </div>
            </div>

            {{-- QR Code --}}
            <div class="qr-wrapper">
                {{--
                    Opsi A — simplesoftwareio/simple-qrcode:
                    {!! QrCode::size(140)->errorCorrection('H')->generate($sesiQrGuru->kode_qr) !!}

                    Opsi B — endroid/qr-code (base64 PNG):
                    @php
                        $qr = \Endroid\QrCode\Builder\Builder::create()
                            ->data($sesiQrGuru->kode_qr)->size(400)->build();
                        $qrBase64 = base64_encode($qr->getString());
                    @endphp
                    <img src="data:image/png;base64,{{ $qrBase64 }}" alt="QR Code">
                --}}
                <div class="qr-placeholder">
                    [QR Code]<br>Integrasikan<br>library QR
                </div>
                <div class="qr-code-text">{{ $sesiQrGuru->kode_qr }}</div>
            </div>

            {{-- Status --}}
            <div class="status-row">
                @if($sesiQrGuru->is_active && now()->lt($sesiQrGuru->kadaluarsa_pada))
                    <span class="badge badge-aktif">&#10003; Sesi Aktif</span>
                @elseif($sesiQrGuru->is_active)
                    <span class="badge badge-kadaluarsa">Kadaluarsa</span>
                @else
                    <span class="badge badge-nonaktif">&#10007; Nonaktif</span>
                @endif
            </div>

        </div>

        <div class="card-footer">
            ID Sesi: {{ $sesiQrGuru->id }} &mdash; {{ config('app.name', 'Sistem Absensi Guru') }}
        </div>
    </div>

    <div class="instructions">
        <strong>Cara Absen:</strong>
        <ol>
            <li>Buka aplikasi absensi di HP.</li>
            <li>Pilih menu <strong>Scan QR Guru</strong>.</li>
            <li>Arahkan kamera ke kode QR di atas.</li>
            @if($sesiQrGuru->radius_meter)
            <li>Pastikan berada dalam radius <strong>{{ $sesiQrGuru->radius_meter }} meter</strong> dari lokasi sekolah.</li>
            @endif
            <li>Absen hanya dapat dilakukan <strong>satu kali</strong> per sesi.</li>
            <li>Sesi berlaku hingga <strong>pukul {{ \Carbon\Carbon::parse($sesiQrGuru->kadaluarsa_pada)->format('H:i') }} WIB</strong>.</li>
        </ol>
    </div>

</body>
</html>