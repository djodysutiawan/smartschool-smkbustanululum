<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Barcode — {{ $barcodeGerbang->siswa->nama_lengkap ?? '—' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800;900&display=swap');

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Outfit', sans-serif; background: #f1f5f9; color: #0f172a; }

        /* ── Toolbar ── */
        .toolbar {
            background: #0f2044;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .toolbar-title { font-size: 15px; font-weight: 800; color: #fff; }
        .toolbar-sub   { font-size: 12px; color: rgba(255,255,255,.5); margin-top: 2px; }
        .back-link {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 0 14px; height: 36px; border-radius: 8px;
            background: rgba(255,255,255,.1); color: rgba(255,255,255,.8);
            text-decoration: none; font-size: 12.5px; font-weight: 700;
        }
        .back-link:hover { background: rgba(255,255,255,.2); }
        .btn-print {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 0 20px; height: 38px; border-radius: 8px;
            background: #10b981; color: #fff; border: none;
            font-family: 'Outfit', sans-serif; font-size: 13px; font-weight: 800;
            cursor: pointer;
        }
        .btn-print:hover { background: #059669; }

        /* ── Centering wrap ── */
        .center-wrap {
            min-height: calc(100vh - 68px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        /* ── Kartu cetak ── */
        .card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 28px 26px 22px;
            width: 320px;
            text-align: center;
            box-shadow: 0 4px 24px rgba(0,0,0,.08);
        }
        .card-school {
            font-size: 11px; font-weight: 800; color: #2563eb;
            text-transform: uppercase; letter-spacing: .1em;
            margin-bottom: 4px;
        }
        .card-title {
            font-size: 11px; font-weight: 600; color: #94a3b8;
            text-transform: uppercase; letter-spacing: .08em;
            margin-bottom: 16px;
        }
        .divider {
            height: 1px; background: #f1f5f9; margin: 14px 0;
        }
        .siswa-nama {
            font-size: 17px; font-weight: 900; color: #0f172a;
            margin-bottom: 4px;
        }
        .siswa-meta {
            font-size: 12px; color: #64748b;
        }
        .barcode-box {
            background: #f8fafc;
            border-radius: 10px;
            padding: 14px 12px 8px;
            margin: 14px 0;
        }
        .barcode-box svg { width: 100%; height: auto; display: block; }
        .barcode-kode {
            font-size: 9px; font-weight: 700; color: #64748b;
            letter-spacing: .07em; margin-top: 6px;
        }
        .validity-row {
            display: flex; justify-content: space-between;
            font-size: 11px; color: #94a3b8;
            margin-top: 6px;
        }
        .validity-row strong { color: #334155; }
        .status-pill {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px; border-radius: 99px;
            background: #ecfdf5; color: #10b981;
            border: 1px solid #d1fae5;
            font-size: 11px; font-weight: 800;
            margin-top: 12px;
        }
        .status-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: #10b981;
            animation: pulse 1.4s infinite;
        }
        @keyframes pulse { 0%,100%{opacity:1}50%{opacity:.4} }

        /* ── Print styles ── */
        @media print {
            body { background: #fff; }
            .toolbar { display: none !important; }
            .center-wrap {
                min-height: unset;
                padding: 20px;
                align-items: flex-start;
            }
            .card {
                box-shadow: none;
                border: 1.5px solid #e2e8f0;
                border-radius: 12px;
            }
        }

        @page {
            size: A6 portrait;
            margin: 8mm;
        }
    </style>
</head>
<body>

    <div class="toolbar">
        <div style="display:flex;align-items:center;gap:12px">
            <a href="{{ route('admin.barcode-gerbang.show', $barcodeGerbang) }}" class="back-link">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <div>
                <p class="toolbar-title">Cetak Barcode</p>
                <p class="toolbar-sub">{{ $barcodeGerbang->siswa->nama_lengkap ?? '—' }}</p>
            </div>
        </div>
        <button class="btn-print" onclick="window.print()">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
            Cetak / Simpan PDF
        </button>
    </div>

    <div class="center-wrap">
        <div class="card">
            <p class="card-school">Barcode Gerbang Sekolah</p>
            <p class="card-title">Kartu Scan Masuk &amp; Pulang</p>

            <p class="siswa-nama">{{ $barcodeGerbang->siswa->nama_lengkap ?? '—' }}</p>
            <p class="siswa-meta">
                NIS {{ $barcodeGerbang->siswa->nis ?? '—' }}
                &nbsp;·&nbsp;
                {{ $barcodeGerbang->siswa->kelas->nama_kelas ?? '—' }}
            </p>

            <div class="barcode-box">
                <svg id="barcodeSvg"></svg>
                <p class="barcode-kode">{{ $barcodeGerbang->kode }}</p>
            </div>

            <div class="divider"></div>

            <div class="validity-row">
                <span>Berlaku mulai</span>
                <strong>{{ $barcodeGerbang->berlaku_mulai?->format('d M Y') ?? '—' }}</strong>
            </div>
            <div class="validity-row">
                <span>Berlaku sampai</span>
                <strong>{{ $barcodeGerbang->berlaku_sampai?->format('d M Y') ?? 'Selamanya' }}</strong>
            </div>

            @if($barcodeGerbang->keterangan)
                <div class="divider"></div>
                <p style="font-size:11px;color:#94a3b8">{{ $barcodeGerbang->keterangan }}</p>
            @endif

            <div class="status-pill">
                <span class="status-dot"></span>
                Aktif
            </div>
        </div>
    </div>

    <script>
    try {
        JsBarcode('#barcodeSvg', '{{ $barcodeGerbang->kode }}', {
            format: 'CODE128',
            width: 2,
            height: 65,
            displayValue: false,
            margin: 0,
            lineColor: '#0f172a',
        });
    } catch(e) { console.warn('JsBarcode error:', e); }
    </script>

</body>
</html>