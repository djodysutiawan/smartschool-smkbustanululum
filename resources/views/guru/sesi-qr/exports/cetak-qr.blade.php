<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QR Absensi – {{ $sesiQr->kelas->nama_kelas ?? '' }}</title>
<style>
    /* DomPDF A5 portrait – gunakan font safe, hindari Google Fonts */
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'DejaVu Sans', Arial, sans-serif;
        background: #ffffff;
        color: #0f172a;
        font-size: 10pt;
        width: 148mm;
        padding: 0;
    }

    /* Header strip */
    .header {
        background: #1f63db;
        padding: 14px 20px 12px;
        position: relative;
        overflow: hidden;
    }
    .header::after {
        content: '';
        position: absolute;
        right: -20px;
        top: -20px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255,255,255,0.08);
    }
    .header-school {
        font-size: 8pt;
        color: rgba(255,255,255,0.65);
        margin-bottom: 4px;
        letter-spacing: 0.03em;
    }
    .header-title {
        font-size: 15pt;
        font-weight: bold;
        color: #ffffff;
        margin-bottom: 2px;
        line-height: 1.2;
    }
    .header-mapel {
        font-size: 9pt;
        color: rgba(255,255,255,0.75);
    }
    .header-badge {
        display: inline-block;
        margin-top: 8px;
        padding: 2px 10px;
        background: rgba(255,255,255,0.18);
        border-radius: 99px;
        font-size: 7.5pt;
        color: #ffffff;
        border: 1px solid rgba(255,255,255,0.3);
    }

    /* QR area */
    .qr-section {
        text-align: center;
        padding: 20px 20px 12px;
        border-bottom: 1px solid #e2e8f0;
    }
    .qr-label {
        font-size: 7.5pt;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 10px;
        font-weight: bold;
    }
    .qr-wrapper {
        display: inline-block;
        padding: 12px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        background: #f8fafc;
        margin-bottom: 10px;
    }
    .qr-wrapper img {
        display: block;
        width: 120px;
        height: 120px;
    }
    .kode-qr {
        font-family: 'Courier New', monospace;
        font-size: 8.5pt;
        color: #64748b;
        background: #f1f5f9;
        padding: 4px 10px;
        border-radius: 5px;
        display: inline-block;
        border: 1px solid #e2e8f0;
        letter-spacing: 0.05em;
        word-break: break-all;
        max-width: 100%;
    }
    .qr-hint {
        font-size: 8pt;
        color: #94a3b8;
        margin-top: 6px;
    }

    /* Info grid */
    .info-section {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
    }
    .info-section-title {
        font-size: 7.5pt;
        font-weight: bold;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 10px;
    }
    .info-grid {
        width: 100%;
        border-collapse: collapse;
    }
    .info-grid td {
        padding: 4px 0;
        vertical-align: top;
        font-size: 9pt;
    }
    .info-grid td:first-child {
        color: #64748b;
        width: 42%;
        padding-right: 8px;
        font-size: 8.5pt;
    }
    .info-grid td:last-child {
        color: #0f172a;
        font-weight: bold;
    }

    /* Validity banner */
    .validity {
        margin: 0 20px 14px;
        padding: 10px 14px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 7px;
        display: table;
        width: calc(100% - 40px);
    }
    .validity-label {
        font-size: 7.5pt;
        color: #15803d;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: bold;
        margin-bottom: 3px;
    }
    .validity-time {
        font-size: 11pt;
        font-weight: bold;
        color: #15803d;
    }
    .validity-date {
        font-size: 8pt;
        color: #16a34a;
        margin-top: 1px;
    }

    /* Instructions */
    .instructions {
        padding: 10px 20px 14px;
        border-top: 1px solid #f1f5f9;
    }
    .instructions-title {
        font-size: 7.5pt;
        font-weight: bold;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 8px;
    }
    .step {
        display: table;
        width: 100%;
        margin-bottom: 5px;
    }
    .step-num {
        display: table-cell;
        width: 20px;
        height: 20px;
        background: #1f63db;
        color: #ffffff;
        border-radius: 50%;
        font-size: 7.5pt;
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
        padding-top: 3px;
    }
    .step-text {
        display: table-cell;
        font-size: 8.5pt;
        color: #475569;
        vertical-align: middle;
        padding-left: 8px;
        line-height: 1.4;
    }

    /* Footer */
    .footer {
        padding: 8px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: table;
        width: 100%;
    }
    .footer-left {
        display: table-cell;
        font-size: 7pt;
        color: #94a3b8;
        vertical-align: middle;
    }
    .footer-right {
        display: table-cell;
        text-align: right;
        font-size: 7pt;
        color: #94a3b8;
        vertical-align: middle;
    }
</style>
</head>
<body>

{{-- Header --}}
<div class="header">
    <p class="header-school">SISTEM ABSENSI DIGITAL</p>
    <p class="header-title">{{ $sesiQr->kelas->nama_kelas ?? '—' }}</p>
    <p class="header-mapel">{{ $sesiQr->mataPelajaran->nama_mapel ?? 'Semua Mata Pelajaran' }}</p>
    <span class="header-badge">QR ABSENSI SISWA</span>
</div>

{{-- QR Code --}}
<div class="qr-section">
    <p class="qr-label">Scan QR Code untuk absensi</p>
    <div class="qr-wrapper">
        {{--
            Render QR via Google Charts API atau library QR yang tersedia.
            Ganti URL di bawah sesuai implementasi project Anda.
            Contoh dengan simple-qrcode atau endroid/qr-code:
        --}}
        @php
            $qrData  = $sesiQr->kode_qr ?? ('SESI-' . $sesiQr->id);
            $qrUrl   = 'https://api.qrserver.com/v1/create-qr-code/?size=240x240&data=' . urlencode($qrData);
        @endphp
        <img src="{{ $qrUrl }}" alt="QR Code {{ $sesiQr->kode_qr }}" width="120" height="120">
    </div>
    <p class="kode-qr">{{ $sesiQr->kode_qr ?? '—' }}</p>
    <p class="qr-hint">Arahkan kamera aplikasi absensi ke QR di atas</p>
</div>

{{-- Validity --}}
<div style="padding:14px 20px 0">
    <div class="validity">
        <p class="validity-label">Berlaku Pukul</p>
        <p class="validity-time">
            {{ \Carbon\Carbon::parse($sesiQr->berlaku_mulai)->format('H:i') }}
            &ndash;
            {{ \Carbon\Carbon::parse($sesiQr->kadaluarsa_pada)->format('H:i') }}
            <span style="font-size:8pt;font-weight:normal;color:#16a34a">
                ({{ \Carbon\Carbon::parse($sesiQr->berlaku_mulai)->diffInMinutes($sesiQr->kadaluarsa_pada) }} menit)
            </span>
        </p>
        <p class="validity-date">{{ \Carbon\Carbon::parse($sesiQr->tanggal)->translatedFormat('l, d F Y') }}</p>
    </div>
</div>

{{-- Info --}}
<div class="info-section">
    <p class="info-section-title">Informasi Sesi</p>
    <table class="info-grid">
        <tr>
            <td>Kelas</td>
            <td>{{ $sesiQr->kelas->nama_kelas ?? '—' }}</td>
        </tr>
        <tr>
            <td>Mata Pelajaran</td>
            <td>{{ $sesiQr->mataPelajaran->nama_mapel ?? '—' }}</td>
        </tr>
        @if($sesiQr->jadwalPelajaran?->ruang)
        <tr>
            <td>Ruang</td>
            <td>{{ $sesiQr->jadwalPelajaran->ruang->nama_ruang }}</td>
        </tr>
        @endif
        <tr>
            <td>Dibuat Oleh</td>
            <td>{{ auth()->user()->name ?? '—' }}</td>
        </tr>
        @if($sesiQr->radius_meter)
        <tr>
            <td>Batas Radius</td>
            <td>{{ $sesiQr->radius_meter }} meter dari titik kelas</td>
        </tr>
        @endif
    </table>
</div>

{{-- Steps --}}
<div class="instructions">
    <p class="instructions-title">Cara Absensi</p>
    <div class="step">
        <div class="step-num">1</div>
        <div class="step-text">Buka aplikasi absensi di smartphone</div>
    </div>
    <div class="step">
        <div class="step-num">2</div>
        <div class="step-text">Pilih menu Scan QR &amp; arahkan kamera ke kode di atas</div>
    </div>
    <div class="step">
        <div class="step-num">3</div>
        <div class="step-text">Pastikan berada dalam jangkauan radius {{ $sesiQr->radius_meter ?? 100 }} meter dari kelas</div>
    </div>
    <div class="step">
        <div class="step-num">4</div>
        <div class="step-text">Absensi berhasil jika muncul konfirmasi di layar</div>
    </div>
</div>

{{-- Footer --}}
<div class="footer">
    <div class="footer-left">Dicetak: {{ now()->format('d/m/Y H:i') }}</div>
    <div class="footer-right">ID Sesi: {{ $sesiQr->id }}</div>
</div>

</body>
</html>