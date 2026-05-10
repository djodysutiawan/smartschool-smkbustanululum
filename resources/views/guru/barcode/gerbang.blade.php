<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Gerbang — {{ $guru->nama_lengkap }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Instrument+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --s-700:#1a3a6b;--s-600:#1d4ed8;--s-500:#2563eb;
            --s-100:#dbeafe;--s-50:#eff6ff;
            --g-500:#10b981;--g-100:#d1fae5;--g-50:#ecfdf5;
            --a-500:#f59e0b;--a-100:#fef3c7;--a-50:#fffbeb;
            --text:#0f172a;--text2:#334155;--text3:#64748b;--text4:#94a3b8;
            --border:#e2e8f0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body {
            height: 100%;
            font-family: 'Instrument Sans', sans-serif;
            background: var(--surface2);
        }

        /* ── Full viewport layout ── */
        .page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
            gap: 18px;
        }

        /* ── Top bar: back + clock ── */
        .topbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 52px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 10;
        }
        .topbar-back {
            display: inline-flex; align-items: center; gap: 6px;
            font-family: 'Outfit', sans-serif; font-size: 13px; font-weight: 700;
            color: var(--text3); text-decoration: none;
            padding: 6px 12px; border-radius: 8px;
            border: 1px solid var(--border); background: var(--surface);
            transition: all .15s;
        }
        .topbar-back:hover { background: var(--surface3); color: var(--text); }
        .topbar-clock {
            font-family: 'Outfit', sans-serif; font-size: 13px;
            font-weight: 600; color: var(--text4);
        }
        .topbar-actions { display: flex; gap: 8px; align-items: center; }
        .btn-sm {
            display: inline-flex; align-items: center; gap: 6px;
            height: 34px; padding: 0 14px; border-radius: 8px;
            font-family: 'Outfit', sans-serif; font-size: 12.5px; font-weight: 700;
            cursor: pointer; border: 1px solid var(--border);
            text-decoration: none; transition: all .15s; white-space: nowrap;
            background: var(--surface); color: var(--text2);
        }
        .btn-sm:hover { background: var(--surface3); }
        .btn-sm.primary { background: var(--s-600); color: #fff; border-color: var(--s-600); }
        .btn-sm.primary:hover { background: var(--s-700); border-color: var(--s-700); }

        /* ── Sesi pill ── */
        .sesi-pill {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 20px; border-radius: 99px;
            font-family: 'Outfit', sans-serif; font-size: 13px; font-weight: 700;
        }
        .sesi-pill.masuk  { background: var(--g-50);     color: var(--g-500); border: 1.5px solid var(--g-100); }
        .sesi-pill.pulang { background: var(--s-50);     color: var(--s-600); border: 1.5px solid var(--s-100); }
        .sesi-pill.none   { background: var(--surface3); color: var(--text4); border: 1.5px solid var(--border); }
        .sesi-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
        .sesi-dot.aktif { background: var(--g-500); animation: blink 1.4s infinite; }
        .sesi-dot.off   { background: var(--text4); }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }

        /* ── Main card ── */
        .bc-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: 0 12px 48px rgba(0,0,0,.10), 0 2px 8px rgba(0,0,0,.05);
            padding: 36px 40px 32px;
            width: 100%;
            max-width: 520px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0;
        }

        /* Avatar + identity */
        .bc-avatar {
            width: 56px; height: 56px; border-radius: 14px;
            background: linear-gradient(135deg, var(--s-600), var(--s-400));
            display: flex; align-items: center; justify-content: center;
            font-family: 'Outfit', sans-serif; font-size: 22px; font-weight: 900;
            color: #fff; margin-bottom: 14px; flex-shrink: 0;
        }
        .bc-nama {
            font-family: 'Outfit', sans-serif;
            font-size: 20px; font-weight: 900;
            color: var(--text); text-align: center;
            margin-bottom: 5px;
        }
        .bc-sub {
            font-size: 13px; color: var(--text4);
            text-align: center; margin-bottom: 28px;
        }

        /* Barcode box */
        .bc-barcode-box {
            width: 100%;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px 16px 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            overflow: hidden;
        }
        .bc-barcode-box svg {
            max-width: 100%;
            height: auto;
            display: block;
        }
        .bc-kode {
            font-family: 'Outfit', sans-serif;
            font-size: 12px; font-weight: 700;
            color: var(--text3); letter-spacing: .12em;
            text-align: center;
        }

        /* Validity row */
        .bc-validity {
            display: flex; align-items: center; gap: 8px;
            background: var(--surface3);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 10px 18px;
        }
        .bc-validity-label {
            font-family: 'Outfit', sans-serif; font-size: 11px;
            font-weight: 700; color: var(--text4);
            text-transform: uppercase; letter-spacing: .06em;
        }
        .bc-validity-val {
            font-family: 'Outfit', sans-serif; font-size: 13px;
            font-weight: 700; color: var(--text2);
        }
        .bc-validity-dot {
            width: 3px; height: 3px; border-radius: 50%;
            background: var(--text4); flex-shrink: 0;
        }

        @media print {
            .topbar { display: none !important; }
            .page { padding: 20px; justify-content: flex-start; }
            .sesi-pill { display: none !important; }
            .bc-card { box-shadow: none; border: 1px solid #ccc; max-width: 100%; }
        }

        @media (max-width: 560px) {
            .bc-card { padding: 24px 18px 22px; border-radius: 16px; }
            .bc-nama { font-size: 17px; }
            .topbar { padding: 0 14px; }
        }
    </style>
</head>
<body>

    {{-- Top bar --}}
    <div class="topbar">
        <a href="{{ route('guru.barcode.index') }}" class="topbar-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali
        </a>

        <span class="topbar-clock" id="clock"></span>

        <div class="topbar-actions">
            <a href="{{ route('guru.barcode.download') }}" class="btn-sm">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Download
            </a>
            <button onclick="window.print()" class="btn-sm primary">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
                Print
            </button>
        </div>
    </div>

    {{-- Main content --}}
    <div class="page" style="padding-top: 80px;">

        {{-- Sesi pill --}}
        @if($sesiGerbangAktif)
            @php $tipe = $sesiGerbangAktif->tipe ?? 'masuk'; @endphp
            <div class="sesi-pill {{ $tipe }}">
                <span class="sesi-dot aktif"></span>
                {{ $tipe === 'pulang' ? '🏠 Jam Pulang — Silakan Scan' : '🏫 Jam Masuk — Silakan Scan' }}
            </div>
        @else
            <div class="sesi-pill none">
                <span class="sesi-dot off"></span>
                Tidak ada sesi gerbang aktif
            </div>
        @endif

        {{-- Card --}}
        <div class="bc-card">

            {{-- Avatar --}}
            <div class="bc-avatar">
                {{ strtoupper(substr($guru->nama_lengkap, 0, 1)) }}
            </div>

            <p class="bc-nama">{{ $guru->nama_lengkap }}</p>
            <p class="bc-sub">
                NIP: {{ $guru->nip ?? '—' }}
                &nbsp;·&nbsp;
                {{ ucfirst($guru->status_kepegawaian ?? 'Guru') }}
            </p>

            {{-- Barcode --}}
            <div class="bc-barcode-box">
                <svg id="barcodeGerbang"></svg>
                <p class="bc-kode">{{ $barcodeGerbang->kode }}</p>
            </div>

            {{-- Validity --}}
            <div class="bc-validity">
                <span class="bc-validity-label">Berlaku</span>
                <span class="bc-validity-dot"></span>
                <span class="bc-validity-val">
                    {{ $barcodeGerbang->berlaku_mulai?->format('d M Y') }}
                    @if($barcodeGerbang->berlaku_sampai)
                        — {{ $barcodeGerbang->berlaku_sampai->format('d M Y') }}
                    @else
                        (tidak terbatas)
                    @endif
                </span>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <script>
        JsBarcode("#barcodeGerbang", "{{ $barcodeGerbang->kode }}", {
            format:       "CODE128",
            width:        2.2,
            height:       90,
            displayValue: false,
            margin:       0,
            lineColor:    "#0f172a",
            background:   "transparent",
        });

        function updateClock() {
            const now = new Date();
            document.getElementById('clock').textContent =
                now.toLocaleDateString('id-ID', {
                    weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
                }) + '  •  ' +
                now.toLocaleTimeString('id-ID', {
                    hour: '2-digit', minute: '2-digit', second: '2-digit'
                });
        }
        updateClock();
        setInterval(updateClock, 1000);
    </script>
</body>
</html>