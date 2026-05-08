<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak QR Guru — {{ \Carbon\Carbon::parse($sesiQrGuru->tanggal)->format('d M Y') }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        *{margin:0;padding:0;box-sizing:border-box}
        body{
            font-family:'Plus Jakarta Sans',sans-serif;
            background:#f1f5f9;
            color:#0f172a;
            min-height:100vh;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            padding:32px 16px;
        }
        .card{
            background:#fff;
            border:1.5px solid #e2e8f0;
            border-radius:20px;
            padding:36px 40px;
            text-align:center;
            max-width:440px;
            width:100%;
            box-shadow:0 8px 40px rgba(0,0,0,.10);
        }

        /* Header */
        .school-name{
            font-size:11.5px;font-weight:700;color:#94a3b8;
            letter-spacing:.1em;text-transform:uppercase;margin-bottom:6px;
        }
        .title{font-size:22px;font-weight:800;color:#0f172a;margin-bottom:4px}
        .subtitle{font-size:13px;color:#64748b;margin-bottom:24px}

        /* Badge */
        .badge{
            display:inline-flex;align-items:center;gap:6px;
            padding:5px 14px;border-radius:99px;
            font-size:12px;font-weight:700;
            margin-bottom:20px;
        }
        .badge-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0}
        .badge-aktif    {background:#dcfce7;color:#15803d;border:1.5px solid #86efac}
        .badge-aktif    .badge-dot{background:#15803d}
        .badge-kadaluarsa{background:#fef3c7;color:#92400e;border:1.5px solid #fde68a}
        .badge-kadaluarsa .badge-dot{background:#d97706}
        .badge-nonaktif {background:#fee2e2;color:#991b1b;border:1.5px solid #fca5a5}
        .badge-nonaktif .badge-dot{background:#dc2626}

        /* QR */
        .qr-wrap{
            display:inline-block;
            padding:16px;
            border:1.5px solid #e2e8f0;
            border-radius:14px;
            margin-bottom:24px;
            background:#fff;
        }
        .qr-wrap svg{display:block;width:220px;height:220px}

        /* Meta */
        .meta-row{
            display:flex;
            gap:12px;
            margin-bottom:10px;
        }
        .meta-item{
            flex:1;
            text-align:left;
            background:#f8fafc;
            border-radius:10px;
            padding:11px 14px;
        }
        .meta-item.full{flex:unset;width:100%}
        .meta-label{
            font-size:10px;font-weight:700;color:#94a3b8;
            letter-spacing:.06em;text-transform:uppercase;
            margin-bottom:3px;
        }
        .meta-val{font-size:13px;font-weight:700;color:#0f172a}

        /* Divider */
        .divider{border:none;border-top:1px dashed #e2e8f0;margin:16px 0}

        .valid-range{font-size:12.5px;color:#64748b;margin-bottom:5px}
        .valid-range strong{color:#0f172a}
        .kode{font-size:8.5px;color:#cbd5e1;word-break:break-all;margin-top:5px;font-family:monospace}
        .url-hint{font-size:11px;color:#94a3b8;margin-top:10px;line-height:1.5}

        /* Buttons */
        .btn-row{margin-top:24px;display:flex;gap:10px;justify-content:center}
        .btn-print{
            padding:11px 28px;background:#1f63db;color:#fff;
            border:none;border-radius:9px;font-family:inherit;
            font-size:14px;font-weight:700;cursor:pointer;
            display:inline-flex;align-items:center;gap:7px;
        }
        .btn-print:hover{background:#1750c0}
        .btn-close{
            padding:11px 24px;background:#f1f5f9;color:#475569;
            border:1.5px solid #e2e8f0;border-radius:9px;font-family:inherit;
            font-size:14px;font-weight:600;cursor:pointer;
        }
        .btn-close:hover{background:#e2e8f0}

        @media print{
            body{background:#fff;padding:0}
            .no-print{display:none!important}
            .card{border:none;box-shadow:none;padding:20px}
        }
    </style>
</head>
<body>
    <div class="card">

        <p class="school-name">{{ config('app.name', 'Sistem Absensi') }}</p>
        <h1 class="title">QR Code Absensi Guru</h1>
        <p class="subtitle">Scan untuk mencatat kehadiran guru</p>

        {{-- Badge status --}}
        @if($sesiQrGuru->is_active && now()->lt($sesiQrGuru->kadaluarsa_pada))
            <div><span class="badge badge-aktif"><span class="badge-dot"></span>Sesi Aktif</span></div>
        @elseif(now()->gte($sesiQrGuru->kadaluarsa_pada))
            <div><span class="badge badge-kadaluarsa"><span class="badge-dot"></span>Kadaluarsa</span></div>
        @else
            <div><span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span></div>
        @endif

        {{-- QR Code --}}
        <div class="qr-wrap">
            {!! QrCode::format('svg')->size(220)->errorCorrection('H')->margin(1)->generate($sesiQrGuru->kode_qr) !!}
        </div>

        {{-- Meta: Tanggal & Dibuat Oleh --}}
        <div class="meta-row">
            <div class="meta-item">
                <p class="meta-label">Tanggal</p>
                <p class="meta-val">{{ \Carbon\Carbon::parse($sesiQrGuru->tanggal)->translatedFormat('l, d F Y') }}</p>
            </div>
            @if($sesiQrGuru->pembuat)
            <div class="meta-item">
                <p class="meta-label">Dibuat Oleh</p>
                <p class="meta-val">{{ $sesiQrGuru->pembuat->name }}</p>
            </div>
            @endif
        </div>

        {{-- Meta: Radius (jika ada) --}}
        @if($sesiQrGuru->radius_meter)
        <div class="meta-row">
            <div class="meta-item" style="width:100%">
                <p class="meta-label">Radius Lokasi</p>
                <p class="meta-val">{{ $sesiQrGuru->radius_meter }} meter</p>
            </div>
        </div>
        @endif

        <hr class="divider">

        <p class="valid-range">
            ⏱ Berlaku:
            <strong>{{ \Carbon\Carbon::parse($sesiQrGuru->berlaku_mulai)->format('H:i') }}</strong>
            —
            <strong>{{ \Carbon\Carbon::parse($sesiQrGuru->kadaluarsa_pada)->format('H:i') }}</strong>
            WIB
        </p>
        <p class="kode">{{ $sesiQrGuru->kode_qr }}</p>
        <p class="url-hint">Scan QR di atas menggunakan kamera HP atau aplikasi absensi</p>

    </div>

    <div class="btn-row no-print">
        <button class="btn-print" onclick="window.print()">
            🖨 Cetak
        </button>
        <button class="btn-close" onclick="window.close()">
            Tutup
        </button>
    </div>
</body>
</html>