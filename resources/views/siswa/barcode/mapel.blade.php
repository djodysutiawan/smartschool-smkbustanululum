<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Instrument+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');

    :root {
        --s-800:#0f2044;--s-700:#1a3a6b;--s-600:#1d4ed8;--s-500:#2563eb;
        --g-500:#10b981;--g-100:#d1fae5;--g-50:#ecfdf5;
        --a-500:#f59e0b;--a-100:#fef3c7;--a-50:#fffbeb;
        --r-500:#ef4444;--r-100:#fee2e2;
        --border:#e2e8f0;--text:#0f172a;--text2:#334155;--text3:#64748b;--text4:#94a3b8;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --radius:12px;--radius-sm:8px;--radius-xs:6px;
    }
    * { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Instrument Sans',sans-serif; background:var(--s-800); min-height:100vh; }

    /* ── Layout ── */
    .fullscreen {
        min-height:100vh; display:flex; flex-direction:column;
        align-items:center; justify-content:center;
        padding:24px 20px;
        background:radial-gradient(ellipse at top,#1a3a6b 0%,var(--s-800) 60%);
        position:relative;
    }
    .fullscreen::before {
        content:''; position:fixed; top:-80px; right:-80px;
        width:300px; height:300px; border-radius:50%;
        background:rgba(255,255,255,.03); pointer-events:none; z-index:0;
    }
    .fullscreen::after {
        content:''; position:fixed; bottom:-60px; left:-60px;
        width:200px; height:200px; border-radius:50%;
        background:rgba(255,255,255,.025); pointer-events:none; z-index:0;
    }

    /* ── Back & clock ── */
    .back-btn {
        position:fixed; top:20px; left:20px; z-index:10;
        display:inline-flex; align-items:center; gap:7px;
        background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15);
        color:rgba(255,255,255,.8); text-decoration:none;
        font-family:'Outfit',sans-serif; font-size:12.5px; font-weight:700;
        padding:8px 14px; border-radius:var(--radius-sm); transition:all .15s;
    }
    .back-btn:hover { background:rgba(255,255,255,.18); color:#fff; }
    .clock-bar {
        position:fixed; top:20px; right:20px; z-index:10;
    }
    .clock-time {
        font-family:'Outfit',sans-serif; font-size:14px; font-weight:800;
        color:rgba(255,255,255,.7); background:rgba(255,255,255,.08);
        border:1px solid rgba(255,255,255,.1); padding:7px 14px;
        border-radius:var(--radius-sm); letter-spacing:.04em;
    }

    /* ── Sesi aktif banner (atas kartu) ── */
    .sesi-banner {
        width:100%; max-width:400px; margin-bottom:14px;
        position:relative; z-index:1;
        animation:card-in .35s cubic-bezier(.34,1.56,.64,1) both;
    }
    .sesi-banner-item {
        display:flex; align-items:center; gap:10px;
        background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.12);
        border-radius:var(--radius-sm); padding:10px 14px; margin-bottom:8px;
    }
    .sesi-banner-item:last-child { margin-bottom:0; }
    .sesi-dot { width:7px; height:7px; border-radius:50%; background:var(--g-500); animation:pulse-dot 1.4s infinite; flex-shrink:0; }
    @keyframes pulse-dot { 0%,100%{opacity:1}50%{opacity:.4} }
    .sesi-banner-mapel { font-family:'Outfit',sans-serif; font-size:13px; font-weight:700; color:#fff; }
    .sesi-banner-waktu { font-size:11.5px; color:rgba(255,255,255,.5); margin-top:2px; }
    .sesi-countdown-sm {
        margin-left:auto; font-family:'Outfit',sans-serif; font-size:12px; font-weight:800;
        color:var(--g-500); white-space:nowrap;
    }
    .sesi-countdown-sm.expiring { color:var(--a-500); }

    .no-sesi-banner {
        width:100%; max-width:400px; margin-bottom:14px;
        background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1);
        border-radius:var(--radius-sm); padding:12px 16px;
        text-align:center; position:relative; z-index:1;
        animation:card-in .35s cubic-bezier(.34,1.56,.64,1) both;
    }
    .no-sesi-text { font-size:12.5px; color:rgba(255,255,255,.45); }

    /* ── Main card ── */
    .barcode-card {
        background:#fff; border-radius:20px;
        padding:32px 32px 28px; width:100%; max-width:400px;
        box-shadow:0 24px 80px rgba(0,0,0,.4), 0 0 0 1px rgba(255,255,255,.05);
        position:relative; z-index:1; display:flex; flex-direction:column; align-items:center;
        animation:card-in .4s cubic-bezier(.34,1.56,.64,1) both;
    }
    @keyframes card-in {
        from { opacity:0; transform:translateY(24px) scale(.96); }
        to   { opacity:1; transform:translateY(0) scale(1); }
    }

    /* ── Header kartu ── */
    .card-school { width:100%; margin-bottom:20px; text-align:center; }
    .card-school-name {
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:700; color:var(--text3);
    }
    .card-divider { height:1px; background:var(--border); margin:10px 0; }

    /* ── Identitas siswa ── */
    .siswa-identity { width:100%; text-align:center; margin-bottom:20px; }
    .siswa-nama { font-family:'Outfit',sans-serif; font-size:19px; font-weight:900; color:var(--text); line-height:1.2; }
    .siswa-meta { display:flex; align-items:center; justify-content:center; gap:8px; margin-top:8px; flex-wrap:wrap; }
    .siswa-chip {
        font-family:'Outfit',sans-serif; font-size:11.5px; font-weight:700;
        padding:4px 12px; border-radius:99px;
    }
    .siswa-chip.kelas { background:var(--s-600); color:#fff; }
    .siswa-chip.nis { background:var(--surface3); color:var(--text3); }

    /* ── Barcode area ── */
    .barcode-area { width:100%; }
    .barcode-svg-wrap {
        width:100%; border:1.5px solid var(--border); border-radius:var(--radius-sm);
        padding:16px 12px 8px; background:var(--surface2); text-align:center;
    }
    .barcode-svg-wrap svg { width:100%; height:auto; display:block; }
    .barcode-kode {
        font-family:'Outfit',sans-serif; font-size:12.5px; font-weight:700;
        color:var(--text3); text-align:center; margin-top:10px; letter-spacing:.1em;
    }

    /* ── Status ── */
    .status-bar {
        display:flex; align-items:center; justify-content:space-between;
        width:100%; margin-top:18px; padding:10px 14px;
        background:var(--g-50); border:1px solid var(--g-100); border-radius:var(--radius-sm);
    }
    .status-aktif {
        display:flex; align-items:center; gap:6px;
        font-family:'Outfit',sans-serif; font-size:12px; font-weight:700; color:var(--g-500);
    }
    .status-dot { width:7px; height:7px; border-radius:50%; background:var(--g-500); animation:pulse-dot 1.4s infinite; }
    .status-sub { font-size:11.5px; color:var(--text4); }

    /* ── Action ── */
    .action-row { display:flex; gap:8px; width:100%; margin-top:14px; }
    .btn-action {
        flex:1; height:42px; border-radius:var(--radius-sm);
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:700;
        display:inline-flex; align-items:center; justify-content:center; gap:7px;
        cursor:pointer; border:none; text-decoration:none; transition:all .15s;
    }
    .btn-primary { background:var(--s-600); color:#fff; }
    .btn-primary:hover { background:var(--s-700); }
    .btn-secondary { background:var(--surface3); color:var(--text2); }
    .btn-secondary:hover { background:var(--border); }

    /* ── Scan hint ── */
    .scan-hint {
        margin-top:28px; text-align:center; position:relative; z-index:1;
        animation:hint-in .5s .3s both;
    }
    @keyframes hint-in { from{opacity:0} to{opacity:1} }
    .scan-hint p { font-size:12px; color:rgba(255,255,255,.4); }
    .scan-hint strong { color:rgba(255,255,255,.65); }

    /* ── Brightness ── */
    .brightness-bar {
        display:flex; align-items:center; gap:10px;
        margin-top:16px; width:100%; max-width:400px; position:relative; z-index:1;
    }
    .brightness-bar svg { flex-shrink:0; opacity:.5; }
    .brightness-slider {
        flex:1; -webkit-appearance:none; height:4px; border-radius:99px;
        background:rgba(255,255,255,.15); outline:none; cursor:pointer;
    }
    .brightness-slider::-webkit-slider-thumb {
        -webkit-appearance:none; width:16px; height:16px; border-radius:50%;
        background:#fff; cursor:pointer; box-shadow:0 1px 4px rgba(0,0,0,.3);
    }

    @media(max-width:480px) {
        .barcode-card { padding:24px 20px 20px; }
        .siswa-nama { font-size:16px; }
        .back-btn span { display:none; }
    }
</style>

{{-- Back --}}
<a href="{{ route('siswa.barcode.index') }}" class="back-btn">
    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    <span>Kembali</span>
</a>

{{-- Clock --}}
<div class="clock-bar">
    <span class="clock-time" id="live-clock">--:--</span>
</div>

<div class="fullscreen">

    {{-- Sesi mapel aktif --}}
    @if($sesiQrAktif->count() > 0)
        <div class="sesi-banner">
            @foreach($sesiQrAktif as $sesi)
                <div class="sesi-banner-item">
                    <span class="sesi-dot"></span>
                    <div>
                        <p class="sesi-banner-mapel">{{ $sesi->mataPelajaran->nama_mapel ?? '—' }}</p>
                        <p class="sesi-banner-waktu">
                            {{ \Carbon\Carbon::parse($sesi->berlaku_mulai)->format('H:i') }} –
                            {{ \Carbon\Carbon::parse($sesi->kadaluarsa_pada)->format('H:i') }}
                        </p>
                    </div>
                    <div class="sesi-countdown-sm"
                         data-expires="{{ \Carbon\Carbon::parse($sesi->kadaluarsa_pada)->timestamp }}">
                        —
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-sesi-banner">
            <p class="no-sesi-text">Belum ada sesi absensi mapel yang aktif saat ini.<br>Halaman ini auto-refresh tiap 30 detik.</p>
        </div>
    @endif

    {{-- Kartu barcode mapel --}}
    <div class="barcode-card">

        <div class="card-school">
            <p class="card-school-name">{{ config('app.nama_sekolah', 'SMA Negeri 1 Contoh') }}</p>
            <div class="card-divider"></div>
        </div>

        <div class="siswa-identity">
            <h1 class="siswa-nama">{{ $siswa->nama_lengkap }}</h1>
            <div class="siswa-meta">
                <span class="siswa-chip kelas">{{ $siswa->kelas->nama_kelas ?? '—' }}</span>
                @if($siswa->nis)
                    <span class="siswa-chip nis">NIS {{ $siswa->nis }}</span>
                @endif
            </div>
        </div>

        <div class="barcode-area">
            <div class="barcode-svg-wrap">
                <svg id="barcode-mapel-main"></svg>
            </div>
            <p class="barcode-kode">{{ $kodeBarcodeMapel }}</p>
        </div>

        <div class="status-bar">
            <span class="status-aktif">
                <span class="status-dot"></span>
                Barcode Mapel Aktif
            </span>
            <span class="status-sub">Tunjukkan ke alat di kelas</span>
        </div>

        <div class="action-row">
            <a href="{{ route('siswa.barcode.downloadMapel') }}" class="btn-action btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Unduh Kode
            </a>
            <button class="btn-action btn-primary" onclick="window.print()">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Cetak
            </button>
        </div>
    </div>

    <div class="scan-hint">
        <p>Arahkan barcode ke <strong>alat scanner di kelas</strong></p>
        <p style="margin-top:4px">saat guru membuka sesi absensi mata pelajaran</p>
    </div>

    <div class="brightness-bar">
        <svg width="16" height="16" fill="none" stroke="rgba(255,255,255,.5)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        <input type="range" class="brightness-slider" min="30" max="100" value="100" oninput="setBrightness(this.value)">
        <svg width="20" height="20" fill="none" stroke="rgba(255,255,255,.8)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script>
// ── Render barcode mapel ──────────────────────────────────────────────────
try {
    JsBarcode('#barcode-mapel-main', '{{ $kodeBarcodeMapel }}', {
        format: 'CODE128', width: 2.2, height: 90,
        displayValue: false, margin: 0, lineColor: '#0f172a',
    });
} catch(e) { console.warn('JsBarcode error:', e); }

// ── Live clock ────────────────────────────────────────────────────────────
function updateClock() {
    const now = new Date();
    const h = String(now.getHours()).padStart(2,'0');
    const m = String(now.getMinutes()).padStart(2,'0');
    const s = String(now.getSeconds()).padStart(2,'0');
    document.getElementById('live-clock').textContent = `${h}:${m}:${s}`;
}
updateClock();
setInterval(updateClock, 1000);

// ── Countdown sesi mapel ──────────────────────────────────────────────────
function updateCountdowns() {
    document.querySelectorAll('.sesi-countdown-sm[data-expires]').forEach(el => {
        const expires = parseInt(el.dataset.expires, 10) * 1000;
        const diff    = Math.max(0, expires - Date.now());
        if (diff === 0) { el.textContent = 'Habis'; return; }
        const mnt = Math.floor(diff / 60000);
        const sec = Math.floor((diff % 60000) / 1000);
        el.textContent = `${mnt}:${String(sec).padStart(2,'0')}`;
        el.classList.toggle('expiring', mnt < 5);
    });
}
updateCountdowns();
setInterval(updateCountdowns, 1000);

// ── Brightness ────────────────────────────────────────────────────────────
function setBrightness(val) {
    document.querySelector('.barcode-svg-wrap').style.filter = `brightness(${val / 100})`;
}

// ── Wake Lock ─────────────────────────────────────────────────────────────
async function keepAwake() {
    if ('wakeLock' in navigator) {
        try { await navigator.wakeLock.request('screen'); } catch(e) {}
    }
}
keepAwake();
document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'visible') keepAwake();
});

// ── Auto-refresh tiap 30 detik ────────────────────────────────────────────
setInterval(() => window.location.reload(), 30000);
</script>
</x-app-layout>