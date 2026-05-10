<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Sesi — {{ $sesiQr->mataPelajaran->nama_mapel ?? 'Absensi' }} | {{ $sesiQr->kelas->nama_kelas ?? '' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800;900&family=DM+Sans:wght@400;500&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --green:#15803d;--green-light:#dcfce7;--green-border:#86efac;
            --red:#dc2626;--red-light:#fee2e2;
            --brand:#1f63db;--brand-light:#eff6ff;
            --text:#0f172a;--text2:#475569;--text3:#94a3b8;
            --surface:#fff;--surface2:#f8fafc;--border:#e2e8f0;
        }

        html, body { height: 100%; overflow: hidden; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: #0f172a;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Top bar */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 24px;
            background: rgba(255,255,255,.04);
            border-bottom: 1px solid rgba(255,255,255,.08);
            flex-shrink: 0;
        }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .back-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 14px; background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12); border-radius: 8px;
            color: rgba(255,255,255,.7); font-size: 12.5px;
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
            text-decoration: none; transition: background .15s;
        }
        .back-btn:hover { background: rgba(255,255,255,.14); color: #fff; }
        .topbar-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px; font-weight: 800; color: #fff;
        }
        .topbar-sub { font-size: 12px; color: rgba(255,255,255,.5); margin-top: 1px; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }

        /* Session status badge */
        .status-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 5px 14px; border-radius: 99px;
            font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
        }
        .status-badge.aktif { background: rgba(34,197,94,.15); color: #4ade80; border: 1px solid rgba(34,197,94,.25); }
        .status-badge.expired { background: rgba(239,68,68,.15); color: #f87171; border: 1px solid rgba(239,68,68,.2); }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; }
        .status-dot.aktif { background: #4ade80; animation: pulse 1.5s infinite; }
        .status-dot.expired { background: #f87171; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }

        /* Main content */
        .main {
            flex: 1;
            display: flex;
            gap: 0;
            overflow: hidden;
        }

        /* QR Section */
        .qr-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 32px 24px;
            position: relative;
        }

        .session-label {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px; font-weight: 700; color: rgba(255,255,255,.4);
            text-transform: uppercase; letter-spacing: .08em;
            margin-bottom: 12px;
        }
        .mapel-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 32px; font-weight: 900; color: #fff;
            text-align: center; line-height: 1.1; margin-bottom: 6px;
        }
        .kelas-name {
            font-size: 16px; color: rgba(255,255,255,.5);
            margin-bottom: 28px; text-align: center;
        }

        /* QR Frame */
        .qr-frame {
            background: #fff;
            padding: 24px;
            border-radius: 20px;
            position: relative;
            box-shadow: 0 0 0 6px rgba(255,255,255,.08);
            margin-bottom: 24px;
        }
        .qr-frame.expired {
            filter: grayscale(1) opacity(.5);
        }
        .qr-expired-overlay {
            position: absolute; inset: 0;
            background: rgba(0,0,0,.6);
            border-radius: 20px;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            gap: 8px;
        }
        .qr-expired-overlay.hidden { display: none; }
        .expired-icon { font-size: 40px; }
        .expired-text {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 16px; font-weight: 800; color: #f87171;
        }

        .qr-hint {
            font-size: 14px; color: rgba(255,255,255,.45);
            text-align: center; line-height: 1.6;
            max-width: 300px;
        }

        /* Timer ring */
        .timer-wrap {
            display: flex; flex-direction: column; align-items: center; margin-bottom: 20px;
        }
        .timer-ring { position: relative; width: 80px; height: 80px; }
        .timer-svg { transform: rotate(-90deg); }
        .timer-bg { fill: none; stroke: rgba(255,255,255,.08); stroke-width: 6; }
        .timer-fill { fill: none; stroke-width: 6; stroke-linecap: round; transition: stroke-dashoffset .9s linear; }
        .timer-fill.green { stroke: #4ade80; }
        .timer-fill.yellow { stroke: #fbbf24; }
        .timer-fill.red { stroke: #f87171; }
        .timer-text {
            position: absolute; inset: 0;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }
        .timer-val {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 18px; font-weight: 900; color: #fff; line-height: 1;
        }
        .timer-unit { font-size: 10px; color: rgba(255,255,255,.4); }

        /* Right panel: scan list */
        .scan-panel {
            width: 320px;
            flex-shrink: 0;
            background: rgba(255,255,255,.03);
            border-left: 1px solid rgba(255,255,255,.07);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .scan-panel-head {
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255,255,255,.07);
            flex-shrink: 0;
        }
        .scan-panel-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px; font-weight: 700; color: rgba(255,255,255,.5);
            text-transform: uppercase; letter-spacing: .06em;
        }
        .scan-count-big {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 28px; font-weight: 900; color: #fff; line-height: 1.1;
            margin-top: 4px;
        }
        .scan-count-sub { font-size: 12px; color: rgba(255,255,255,.35); margin-top: 2px; }
        .scan-progress { height: 4px; background: rgba(255,255,255,.08); border-radius: 99px; margin-top: 12px; overflow: hidden; }
        .scan-progress-fill { height: 100%; background: linear-gradient(90deg, #3582f0, #4ade80); border-radius: 99px; transition: width .5s; }

        .scan-list { flex: 1; overflow-y: auto; padding: 10px 0; }
        .scan-list::-webkit-scrollbar { width: 4px; }
        .scan-list::-webkit-scrollbar-track { background: transparent; }
        .scan-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 99px; }

        .scan-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 20px;
            border-bottom: 1px solid rgba(255,255,255,.04);
            animation: slideIn .3s ease;
        }
        @keyframes slideIn { from{opacity:0;transform:translateX(12px)} to{opacity:1;transform:none} }
        .scan-avatar {
            width: 32px; height: 32px; border-radius: 8px;
            background: rgba(53,130,240,.2);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 800;
            color: #93c5fd; flex-shrink: 0;
        }
        .scan-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px; font-weight: 700; color: rgba(255,255,255,.85);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .scan-nis { font-size: 11px; color: rgba(255,255,255,.35); margin-top: 1px; }
        .scan-time { font-size: 11px; color: rgba(255,255,255,.3); margin-left: auto; flex-shrink: 0; }
        .scan-empty {
            padding: 40px 20px; text-align: center;
            font-size: 13px; color: rgba(255,255,255,.25);
        }

        /* Bottom bar */
        .bottombar {
            padding: 12px 24px;
            background: rgba(255,255,255,.03);
            border-top: 1px solid rgba(255,255,255,.06);
            display: flex; align-items: center; justify-content: space-between;
            flex-shrink: 0; flex-wrap: wrap; gap: 10px;
        }
        .bottombar-info { font-size: 12px; color: rgba(255,255,255,.3); display: flex; gap: 16px; flex-wrap: wrap; }
        .bottombar-info span { display: flex; align-items: center; gap: 5px; }
        .nonaktif-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 16px; background: rgba(239,68,68,.12);
            border: 1px solid rgba(239,68,68,.2); border-radius: 8px;
            color: #f87171; font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px; font-weight: 700; cursor: pointer; transition: background .15s;
        }
        .nonaktif-btn:hover { background: rgba(239,68,68,.2); }

        @media (max-width: 768px) {
            .scan-panel { display: none; }
            .mapel-name { font-size: 22px; }
        }
    </style>
</head>
<body>

    {{-- Top bar --}}
    <div class="topbar">
        <div class="topbar-left">
            <a href="{{ route('guru.barcode-kelas.index') }}" class="back-btn">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <div>
                <div class="topbar-title">QR Sesi Absensi</div>
                <div class="topbar-sub">
                    {{ $sesiQr->mataPelajaran->nama_mapel ?? 'Semua Mapel' }} ·
                    {{ $sesiQr->kelas->nama_kelas ?? '—' }} ·
                    {{ \Carbon\Carbon::parse($sesiQr->tanggal)->translatedFormat('l, d M Y') }}
                </div>
            </div>
        </div>
        <div class="topbar-right">
            <div class="timer-wrap">
                <div class="timer-ring">
                    <svg class="timer-svg" viewBox="0 0 80 80" width="80" height="80">
                        <circle class="timer-bg" cx="40" cy="40" r="34"/>
                        <circle class="timer-fill green" id="timerArc" cx="40" cy="40" r="34"
                            stroke-dasharray="{{ 2 * M_PI * 34 }}"
                            stroke-dashoffset="{{ 2 * M_PI * 34 * (1 - min(1, $sisaDetik / max(1, \Carbon\Carbon::parse($sesiQr->berlaku_mulai)->diffInSeconds($sesiQr->kadaluarsa_pada)))) }}"/>
                    </svg>
                    <div class="timer-text">
                        <span class="timer-val" id="timerVal">{{ gmdate('i:s', $sisaDetik) }}</span>
                        <span class="timer-unit">tersisa</span>
                    </div>
                </div>
            </div>
            <div id="statusBadge" class="status-badge {{ $isKadaluarsa ? 'expired' : 'aktif' }}">
                <span class="status-dot {{ $isKadaluarsa ? 'expired' : 'aktif' }}" id="statusDot"></span>
                <span id="statusText">{{ $isKadaluarsa ? 'Kedaluwarsa' : 'Aktif' }}</span>
            </div>
        </div>
    </div>

    {{-- Main --}}
    <div class="main">
        <div class="qr-section">
            <div class="session-label">Scan QR untuk Absensi</div>
            <div class="mapel-name">{{ $sesiQr->mataPelajaran->nama_mapel ?? 'Absensi Kelas' }}</div>
            <div class="kelas-name">
                {{ $sesiQr->kelas->nama_kelas ?? '—' }}
                @if($sesiQr->jadwalPelajaran?->ruang)
                · {{ $sesiQr->jadwalPelajaran->ruang->nama_ruang }}
                @endif
            </div>

            <div class="qr-frame {{ $isKadaluarsa ? 'expired' : '' }}" id="qrFrame">
                {!! QrCode::size(240)->generate($sesiQr->kode_qr) !!}
                <div class="qr-expired-overlay {{ $isKadaluarsa ? '' : 'hidden' }}" id="expiredOverlay">
                    <div class="expired-icon">⛔</div>
                    <div class="expired-text">Sesi Berakhir</div>
                </div>
            </div>

            <p class="qr-hint">
                Arahkan kamera siswa ke QR code di atas<br>
                Berlaku hingga <strong style="color:rgba(255,255,255,.7)">{{ \Carbon\Carbon::parse($sesiQr->kadaluarsa_pada)->format('H:i') }}</strong> ·
                Radius {{ $sesiQr->radius_meter }} meter
            </p>
        </div>

        {{-- Scan panel --}}
        <div class="scan-panel">
            <div class="scan-panel-head">
                <div class="scan-panel-title">Siswa Sudah Hadir</div>
                <div class="scan-count-big" id="scanCount">{{ $sudahScan }}</div>
                <div class="scan-count-sub">dari {{ $totalSiswa }} siswa di kelas</div>
                <div class="scan-progress">
                    <div class="scan-progress-fill" id="scanProgressFill"
                        style="width:{{ $totalSiswa > 0 ? round(($sudahScan / $totalSiswa) * 100) : 0 }}%"></div>
                </div>
            </div>
            <div class="scan-list" id="scanList">
                <div class="scan-empty" id="scanEmpty" {{ $sudahScan > 0 ? 'style=display:none' : '' }}>
                    Belum ada siswa yang scan…
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="bottombar">
        <div class="bottombar-info">
            <span>
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ \Carbon\Carbon::parse($sesiQr->berlaku_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($sesiQr->kadaluarsa_pada)->format('H:i') }}
            </span>
            @if($sesiQr->latitude && $sesiQr->longitude)
            <span>
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/></svg>
                Validasi radius {{ $sesiQr->radius_meter }}m aktif
            </span>
            @endif
            <span>
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                {{ $sesiQr->kode_qr }}
            </span>
        </div>

        @if(!$isKadaluarsa)
        <form action="{{ route('guru.barcode-kelas.nonaktifkan-sesi', $sesiQr) }}" method="POST"
            onsubmit="return confirm('Nonaktifkan sesi ini sekarang?')">
            @csrf @method('PATCH')
            <button type="submit" class="nonaktif-btn">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                Nonaktifkan Sesi
            </button>
        </form>
        @endif
    </div>

<script>
const SISA_AWAL  = {{ $sisaDetik }};
const DURASI_TOTAL = {{ max(1, \Carbon\Carbon::parse($sesiQr->berlaku_mulai)->diffInSeconds($sesiQr->kadaluarsa_pada)) }};
const CIRCUMFERENCE = 2 * Math.PI * 34;
const TOTAL_SISWA = {{ $totalSiswa }};
const POLL_URL = "{{ route('guru.barcode-kelas.status-sesi-ajax', $sesiQr) }}";
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
const IS_EXPIRED_INIT = {{ $isKadaluarsa ? 'true' : 'false' }};

let sisaDetik = SISA_AWAL;
let isExpired = IS_EXPIRED_INIT;
let knownSiswaIds = new Set();

// ── Timer countdown ──────────────────────────────────────────────────────────
const timerVal = document.getElementById('timerVal');
const timerArc = document.getElementById('timerArc');

function updateTimer() {
    if (isExpired || sisaDetik <= 0) {
        timerVal.textContent = '00:00';
        setExpired();
        return;
    }
    const m = String(Math.floor(sisaDetik / 60)).padStart(2, '0');
    const s = String(sisaDetik % 60).padStart(2, '0');
    timerVal.textContent = `${m}:${s}`;

    const ratio = sisaDetik / DURASI_TOTAL;
    timerArc.style.strokeDashoffset = CIRCUMFERENCE * (1 - ratio);

    // Color shift: green → yellow → red
    timerArc.className.baseVal = 'timer-fill ' + (ratio > .4 ? 'green' : ratio > .15 ? 'yellow' : 'red');
    sisaDetik--;
}

updateTimer();
const timerInterval = setInterval(updateTimer, 1000);

function setExpired() {
    isExpired = true;
    clearInterval(timerInterval);
    document.getElementById('statusBadge').className = 'status-badge expired';
    document.getElementById('statusDot').className   = 'status-dot expired';
    document.getElementById('statusText').textContent = 'Kedaluwarsa';
    document.getElementById('qrFrame').classList.add('expired');
    document.getElementById('expiredOverlay').classList.remove('hidden');
}

// ── AJAX polling ─────────────────────────────────────────────────────────────
const scanList    = document.getElementById('scanList');
const scanEmpty   = document.getElementById('scanEmpty');
const scanCountEl = document.getElementById('scanCount');
const scanFillEl  = document.getElementById('scanProgressFill');

function renderSiswa(list) {
    list.forEach(s => {
        if (knownSiswaIds.has(s.siswa_id)) return;
        knownSiswaIds.add(s.siswa_id);
        scanEmpty.style.display = 'none';

        const inisial = (s.nama || '?').split(' ').slice(0, 2).map(w => w[0]).join('').toUpperCase();
        const el = document.createElement('div');
        el.className = 'scan-item';
        el.innerHTML = `
            <div class="scan-avatar">${inisial}</div>
            <div style="flex:1;min-width:0">
                <div class="scan-name">${s.nama}</div>
                <div class="scan-nis">NIS: ${s.nis}</div>
            </div>
            <div class="scan-time">${s.di_scan_pada}</div>
        `;
        scanList.insertBefore(el, scanList.firstChild);
    });
}

async function poll() {
    try {
        const res  = await fetch(POLL_URL, { headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } });
        const data = await res.json();

        if (data.is_kadaluarsa && !isExpired) setExpired();

        // Update countdown from server (truth source)
        if (!isExpired) {
            sisaDetik = data.sisa_waktu;
        }

        // Update count & progress
        const jumlah = data.jumlah_scan;
        scanCountEl.textContent = jumlah;
        const pct = TOTAL_SISWA > 0 ? Math.round((jumlah / TOTAL_SISWA) * 100) : 0;
        scanFillEl.style.width = pct + '%';

        // Render new scans
        if (data.sudah_scan && data.sudah_scan.length > 0) {
            renderSiswa(data.sudah_scan);
        }
    } catch (e) { /* silent fail */ }
}

poll();
const pollInterval = setInterval(poll, 4000);
</script>
</body>
</html>