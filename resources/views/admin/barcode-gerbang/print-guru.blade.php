<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Barcode — Semua Guru</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800;900&display=swap');

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Outfit', sans-serif;
            background: #f5f3ff;
            color: #0f172a;
        }

        /* ── Toolbar (tidak ikut print) ── */
        .toolbar {
            background: #2d1b69;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            position: sticky;
            top: 0;
            z-index: 99;
        }
        .toolbar-left { display: flex; align-items: center; gap: 12px; }
        .toolbar-title { font-size: 15px; font-weight: 800; color: #fff; }
        .toolbar-sub   { font-size: 12px; color: rgba(255,255,255,.5); margin-top: 2px; }
        .back-link {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 0 14px; height: 36px; border-radius: 8px;
            background: rgba(255,255,255,.1); color: rgba(255,255,255,.8);
            text-decoration: none; font-size: 12.5px; font-weight: 700;
            transition: background .15s;
        }
        .back-link:hover { background: rgba(255,255,255,.2); }
        .toolbar-right { display: flex; align-items: center; gap: 10px; }
        .stat-pill {
            background: rgba(255,255,255,.12); border-radius: 99px;
            padding: 5px 14px; font-size: 12px; font-weight: 700; color: #fff;
        }
        .btn-print {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 0 20px; height: 38px; border-radius: 8px;
            background: #10b981; color: #fff; border: none;
            font-family: 'Outfit', sans-serif; font-size: 13px; font-weight: 800;
            cursor: pointer; transition: background .15s;
        }
        .btn-print:hover { background: #059669; }

        /* ── Grid kartu ── */
        .cards-wrap {
            padding: 24px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
        }

        /* ── Satu kartu barcode ── */
        .barcode-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 14px 12px 12px;
            text-align: center;
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
            break-inside: avoid;
            page-break-inside: avoid;
        }
        .card-accent {
            height: 3px;
            border-radius: 99px;
            background: linear-gradient(90deg,#7c3aed,#a78bfa);
            margin: 0 auto 10px;
            width: 40px;
        }
        .card-tipe {
            font-size: 9px; font-weight: 800; color: #7c3aed;
            text-transform: uppercase; letter-spacing: .1em;
            margin-bottom: 6px;
        }
        .card-nama {
            font-size: 13px; font-weight: 800; color: #0f172a;
            margin-bottom: 2px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .card-nip {
            font-size: 10.5px; color: #94a3b8; margin-bottom: 10px;
        }
        .barcode-box {
            background: #f8fafc;
            border-radius: 8px;
            padding: 8px 6px 4px;
            margin-bottom: 8px;
        }
        .barcode-box svg { width: 100%; height: auto; display: block; }
        .barcode-kode {
            font-size: 8.5px; font-weight: 700; color: #64748b;
            letter-spacing: .05em; margin-top: 4px;
            word-break: break-all;
        }
        .card-validity {
            font-size: 10px; color: #94a3b8;
            padding-top: 8px;
            border-top: 1px solid #f1f5f9;
        }
        .card-validity strong { color: #475569; }

        /* ── Empty state ── */
        .empty-wrap {
            text-align: center; padding: 80px 20px;
        }
        .empty-icon {
            width: 72px; height: 72px; background: #f1f5f9;
            border-radius: 18px; display: flex; align-items: center;
            justify-content: center; margin: 0 auto 16px;
        }
        .empty-title { font-size: 16px; font-weight: 800; color: #334155; margin-bottom: 6px; }
        .empty-sub { font-size: 13px; color: #94a3b8; }

        /* ── Print styles ── */
        @media print {
            body { background: #fff; }
            .toolbar { display: none !important; }
            .cards-wrap {
                padding: 0;
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 8px;
            }
            .barcode-card {
                border: 1px solid #e2e8f0;
                box-shadow: none;
                border-radius: 8px;
                padding: 10px 8px;
            }
        }

        @page {
            margin: 12mm;
            size: A4 portrait;
        }
    </style>
</head>
<body>

    <div class="toolbar">
        <div class="toolbar-left">
            <a href="{{ route('admin.barcode-gerbang.index') }}" class="back-link">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <div>
                <p class="toolbar-title">Cetak Barcode — Semua Guru</p>
                <p class="toolbar-sub">Barcode aktif &amp; berlaku hari ini</p>
            </div>
        </div>
        <div class="toolbar-right">
            <span class="stat-pill">{{ $barcodes->count() }} guru</span>
            <button class="btn-print" onclick="window.print()">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    @if($barcodes->isEmpty())
        <div class="empty-wrap">
            <div class="empty-icon">
                <svg width="32" height="32" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 9V5a2 2 0 0 1 2-2h4M3 15v4a2 2 0 0 0 2 2h4M21 9V5a2 2 0 0 0-2-2h-4M21 15v4a2 2 0 0 1-2 2h-4"/></svg>
            </div>
            <p class="empty-title">Tidak ada barcode guru aktif</p>
            <p class="empty-sub">
                Belum ada guru yang memiliki barcode aktif &amp; berlaku hari ini.<br>
                Silakan generate barcode guru terlebih dahulu dari halaman utama.
            </p>
        </div>
    @else
        <div class="cards-wrap">
            @foreach($barcodes as $barcode)
                <div class="barcode-card">
                    <div class="card-accent"></div>
                    <p class="card-tipe">Guru / Staf</p>
                    <p class="card-nama" title="{{ $barcode->guru->nama_lengkap ?? '—' }}">
                        {{ $barcode->guru->nama_lengkap ?? '—' }}
                    </p>
                    <p class="card-nip">
                        NIP {{ $barcode->guru->nip ?? '—' }}
                        @if($barcode->guru->status_kepegawaian ?? false)
                            · {{ $barcode->guru->status_kepegawaian }}
                        @endif
                    </p>

                    <div class="barcode-box">
                        <svg class="barcode-svg" data-kode="{{ $barcode->kode }}"></svg>
                        <p class="barcode-kode">{{ $barcode->kode }}</p>
                    </div>

                    <p class="card-validity">
                        Berlaku:
                        <strong>{{ $barcode->berlaku_mulai?->format('d M Y') ?? '—' }}</strong>
                        @if($barcode->berlaku_sampai)
                            s/d <strong>{{ $barcode->berlaku_sampai->format('d M Y') }}</strong>
                        @else
                            – <strong>Selamanya</strong>
                        @endif
                    </p>
                </div>
            @endforeach
        </div>
    @endif

    <script>
    document.querySelectorAll('.barcode-svg').forEach(function (svg) {
        var kode = svg.dataset.kode;
        if (!kode) return;
        try {
            JsBarcode(svg, kode, {
                format: 'CODE128',
                width: 1.6,
                height: 50,
                displayValue: false,
                margin: 0,
                lineColor: '#0f172a',
            });
        } catch (e) {
            console.warn('JsBarcode error for', kode, e);
        }
    });
    </script>

</body>
</html>