<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Kelas — {{ $kelas->nama_kelas }}</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&family=DM+Sans:wght@400;500&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px;
        }
        .card {
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            width: 400px;
            overflow: hidden;
            text-align: center;
        }
        .card-stripe {
            height: 8px;
            background: linear-gradient(90deg, #3582f0, #22c55e);
        }
        .card-body { padding: 36px 32px 28px; }
        .school-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 18px;
        }
        .icon-circle {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: #eef6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
        }
        .kelas-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .kelas-sub {
            font-size: 13px;
            color: #94a3b8;
            margin-bottom: 28px;
        }
        .barcode-wrap {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            display: inline-block;
            margin-bottom: 16px;
        }
        .barcode-wrap svg { display: block; }
        .barcode-code {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #64748b;
            letter-spacing: .08em;
            margin-bottom: 20px;
        }
        .divider { height: 1px; background: #f1f5f9; margin-bottom: 16px; }
        .footer-note { font-size: 11px; color: #94a3b8; line-height: 1.7; }
        .footer-note strong { color: #64748b; }
        .print-date { font-size: 10px; color: #cbd5e1; margin-top: 12px; }

        @media print {
            body { padding: 0; background: #fff; }
            .card { border: 1.5px solid #e2e8f0; box-shadow: none; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div>
        <div class="no-print" style="text-align:center;margin-bottom:20px">
            <button onclick="window.print()" style="padding:10px 28px;background:#1f63db;color:#fff;border:none;border-radius:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;cursor:pointer">
                🖨 Cetak Sekarang
            </button>
            <a href="{{ route('guru.barcode-kelas.show', $kelas) }}" style="display:inline-block;margin-left:10px;padding:10px 20px;background:#f1f5f9;color:#475569;border-radius:8px;text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700">
                ← Kembali
            </a>
        </div>

        <div class="card">
            <div class="card-stripe"></div>
            <div class="card-body">
                <div class="school-name">Barcode Identitas Kelas</div>

                <div class="icon-circle">
                    <svg width="28" height="28" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>

                <div class="kelas-name">{{ $kelas->nama_kelas }}</div>
                <div class="kelas-sub">
                    {{ $kelas->jurusan->nama_jurusan ?? 'Kelas' }}
                    @if($kelas->tingkat) · Tingkat {{ $kelas->tingkat }} @endif
                </div>

                {{-- Barcode menggunakan JsBarcode (SVG), menggantikan DNS1D::getBarcodeHTML() --}}
                <div class="barcode-wrap">
                    <svg id="barcode-kelas"></svg>
                </div>

                <div class="barcode-code">{{ $barcodeKelas }}</div>

                <div class="divider"></div>

                <div class="footer-note">
                    Scan barcode ini untuk absensi digital siswa<br>
                    Guru: <strong>{{ $guru->nama_lengkap }}</strong>
                </div>
                <div class="print-date">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }}</div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            try {
                JsBarcode('#barcode-kelas', '{{ $barcodeKelas }}', {
                    format      : 'CODE128',
                    width       : 2,
                    height      : 70,
                    displayValue: false,  // nilai teks sudah tampil di .barcode-code
                    margin      : 0,
                    background  : 'transparent',
                    lineColor   : '#0f172a'
                });
            } catch (e) {
                document.getElementById('barcode-kelas').outerHTML =
                    '<p style="color:#94a3b8;font-size:12px">Barcode tidak dapat ditampilkan</p>';
            }
        });
    </script>
</body>
</html>