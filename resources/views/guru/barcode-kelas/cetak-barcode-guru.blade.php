<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Guru — {{ $guru->nama_lengkap }}</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&family=DM+Sans:wght@400;500&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 40px 20px;
        }
        .no-print {
            text-align: center;
            margin-bottom: 24px;
        }
        .card {
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 18px;
            width: 380px;
            overflow: hidden;
            text-align: center;
        }
        .card-stripe {
            height: 8px;
            background: linear-gradient(90deg, #3582f0, #7c3aed);
        }
        .card-body { padding: 32px 28px 24px; }
        .school-label {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11px; font-weight: 700;
            color: #94a3b8; text-transform: uppercase;
            letter-spacing: .08em; margin-bottom: 20px;
        }
        .avatar {
            width: 68px; height: 68px; border-radius: 18px;
            background: linear-gradient(135deg, #eef6ff, #d9ebff);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 24px; font-weight: 800; color: #1f63db;
        }
        .guru-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 20px; font-weight: 800; color: #0f172a;
            margin-bottom: 4px;
        }
        .guru-nip {
            font-size: 13px; color: #94a3b8; margin-bottom: 6px;
        }
        .guru-role {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 12px;
            background: #eef6ff; color: #1f63db;
            border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11px; font-weight: 700; letter-spacing: .04em;
            text-transform: uppercase; margin-bottom: 24px;
        }
        .divider { height: 1px; background: #f1f5f9; margin-bottom: 22px; }
        .barcode-label {
            font-size: 11px; color: #94a3b8;
            text-transform: uppercase; letter-spacing: .06em;
            margin-bottom: 10px; font-weight: 600;
        }
        .barcode-wrap {
            background: #f8fafc; border: 1px solid #e2e8f0;
            border-radius: 10px; padding: 16px 20px;
            display: inline-block; margin-bottom: 12px;
        }
        .barcode-wrap svg { display: block; }
        .barcode-raw {
            font-family: 'Courier New', monospace;
            font-size: 12px; color: #64748b;
            letter-spacing: .08em; margin-bottom: 20px;
        }
        .usage-note {
            font-size: 12px; color: #94a3b8; line-height: 1.7;
            padding: 12px 16px; background: #f8fafc; border-radius: 8px;
            border: 1px dashed #e2e8f0; margin-bottom: 16px;
            text-align: left;
        }
        .usage-note strong { color: #64748b; }
        .print-date {
            font-size: 10px; color: #cbd5e1; margin-top: 8px;
            padding-top: 12px; border-top: 1px solid #f1f5f9;
        }

        @media print {
            body { background: #fff; padding: 0; }
            .no-print { display: none !important; }
            .card { border: 1.5px solid #e2e8f0; box-shadow: none; border-radius: 14px; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" style="padding:10px 28px;background:#1f63db;color:#fff;border:none;border-radius:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;cursor:pointer;margin-right:8px">
            🖨 Cetak Sekarang
        </button>
        <a href="{{ route('guru.barcode-kelas.index') }}" style="display:inline-block;padding:10px 20px;background:#f1f5f9;color:#475569;border-radius:8px;text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700">
            ← Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-stripe"></div>
        <div class="card-body">
            <div class="school-label">Kartu Identitas Guru</div>

            <div class="avatar">
                {{ strtoupper(substr($guru->nama_lengkap ?? 'G', 0, 2)) }}
            </div>

            <div class="guru-name">{{ $guru->nama_lengkap }}</div>
            @if($guru->nip)
            <div class="guru-nip">NIP: {{ $guru->nip }}</div>
            @endif
            @if($guru->jabatan ?? false)
            <div class="guru-nip" style="margin-bottom:0">{{ $guru->jabatan }}</div>
            @endif
            <div style="margin-top:8px">
                <span class="guru-role">
                    <svg width="9" height="9" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Guru
                </span>
            </div>

            <div class="divider" style="margin-top:20px"></div>

            <div class="barcode-label">Barcode Absensi Piket</div>

            {{-- Barcode menggunakan JsBarcode (SVG), menggantikan DNS1D::getBarcodeHTML() --}}
            <div class="barcode-wrap">
                <svg id="barcode-cetak"></svg>
            </div>
            <div class="barcode-raw">{{ $barcodeGuru }}</div>

            <div class="usage-note">
                <strong>Cara penggunaan:</strong><br>
                Scan barcode ini di <strong>pos piket</strong> setiap hari untuk mencatat kehadiran guru. Nilai barcode bersifat tetap dan tidak pernah berubah.
            </div>

            <div class="print-date">
                Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} · ID: {{ $user->id }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            try {
                JsBarcode('#barcode-cetak', '{{ $barcodeGuru }}', {
                    format      : 'CODE128',
                    width       : 2,
                    height      : 65,
                    displayValue: false,  // nilai teks sudah tampil di .barcode-raw
                    margin      : 0,
                    background  : 'transparent',
                    lineColor   : '#0f172a'
                });
            } catch (e) {
                document.getElementById('barcode-cetak').outerHTML =
                    '<p style="color:#94a3b8;font-size:12px">Barcode tidak dapat ditampilkan</p>';
            }
        });
    </script>
</body>
</html>