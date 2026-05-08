{{-- resources/views/admin/sesi-qr/cetak-qr.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak QR — {{ $sesiQr->kelas->nama_kelas ?? '' }} — {{ $sesiQr->tanggal->format('d M Y') }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Plus Jakarta Sans',sans-serif;background:#fff;color:#0f172a;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:32px}
        .card{background:#fff;border:2px solid #e2e8f0;border-radius:16px;padding:40px 48px;text-align:center;max-width:480px;width:100%;box-shadow:0 8px 32px rgba(0,0,0,.08)}
        .school-name{font-size:13px;font-weight:700;color:#64748b;letter-spacing:.06em;text-transform:uppercase;margin-bottom:4px}
        .title{font-size:22px;font-weight:800;color:#0f172a;margin-bottom:2px}
        .subtitle{font-size:14px;color:#475569;margin-bottom:28px}
        .qr-wrap{display:inline-block;padding:18px;border:2px solid #e2e8f0;border-radius:12px;margin-bottom:20px;background:#fff}
        .qr-wrap svg{display:block;width:240px;height:240px}
        .meta-row{display:flex;justify-content:space-between;gap:16px;margin-bottom:12px;padding:12px 16px;background:#f8fafc;border-radius:10px}
        .meta-item{text-align:left}
        .meta-label{font-size:10.5px;font-weight:700;color:#94a3b8;letter-spacing:.05em;text-transform:uppercase;margin-bottom:2px}
        .meta-val{font-size:13.5px;font-weight:700;color:#0f172a}
        .divider{border:none;border-top:1px dashed #e2e8f0;margin:16px 0}
        .valid-range{font-size:12px;color:#64748b;margin-bottom:6px}
        .kode{font-size:9px;color:#cbd5e1;word-break:break-all;margin-top:4px}
        .url-hint{font-size:11px;color:#94a3b8;margin-top:12px}
        .badge-aktif{display:inline-flex;align-items:center;gap:5px;background:#dcfce7;color:#15803d;border-radius:99px;padding:4px 12px;font-size:12px;font-weight:700;margin-bottom:20px}
        .badge-dot{width:6px;height:6px;border-radius:50%;background:#15803d}
        @media print{
            body{padding:0}
            .no-print{display:none!important}
            .card{border:none;box-shadow:none;padding:24px}
        }
    </style>
</head>
<body>
    <div class="card">
        <p class="school-name">Absensi Digital</p>
        <h1 class="title">QR Code Absensi</h1>
        <p class="subtitle">Scan untuk mencatat kehadiran</p>

        @if($sesiQr->isValid())
        <span class="badge-aktif"><span class="badge-dot"></span>Sesi Aktif</span>
        @endif

        <div class="qr-wrap">
            {!! QrCode::format('svg')->size(240)->errorCorrection('H')->generate($sesiQr->kode_qr) !!}
        </div>

        <div class="meta-row">
            <div class="meta-item">
                <p class="meta-label">Kelas</p>
                <p class="meta-val">{{ $sesiQr->kelas->nama_kelas ?? '—' }}</p>
            </div>
            <div class="meta-item">
                <p class="meta-label">Mata Pelajaran</p>
                <p class="meta-val">{{ $sesiQr->mataPelajaran->nama_mapel ?? '—' }}</p>
            </div>
        </div>

        <div class="meta-row">
            <div class="meta-item">
                <p class="meta-label">Tanggal</p>
                <p class="meta-val">{{ $sesiQr->tanggal->isoFormat('dddd, D MMMM Y') }}</p>
            </div>
            @if($sesiQr->guru)
            <div class="meta-item">
                <p class="meta-label">Guru</p>
                <p class="meta-val">{{ $sesiQr->guru->nama_lengkap }}</p>
            </div>
            @endif
        </div>

        <hr class="divider">
        <p class="valid-range">
            ⏱ Berlaku: <strong>{{ $sesiQr->berlaku_mulai->format('H:i') }}</strong>
            — <strong>{{ $sesiQr->kadaluarsa_pada->format('H:i') }}</strong>
        </p>
        <p class="kode">{{ $sesiQr->kode_qr }}</p>
        <p class="url-hint">Scan QR di atas menggunakan kamera HP atau aplikasi absensi</p>
    </div>

    <div class="no-print" style="margin-top:24px;display:flex;gap:12px">
        <button onclick="window.print()"
            style="padding:10px 24px;background:#1f63db;color:#fff;border:none;border-radius:8px;font-family:inherit;font-size:14px;font-weight:700;cursor:pointer">
            🖨 Cetak
        </button>
        <button onclick="window.close()"
            style="padding:10px 24px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;border-radius:8px;font-family:inherit;font-size:14px;font-weight:600;cursor:pointer">
            Tutup
        </button>
    </div>
</body>
</html>