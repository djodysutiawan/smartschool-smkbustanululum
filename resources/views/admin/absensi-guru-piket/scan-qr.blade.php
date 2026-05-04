<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand)}.breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}.btn-back:hover{background:var(--surface3);filter:none}
    .sesi-info{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius);padding:14px 20px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}
    .sesi-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--brand-700)}
    .sesi-detail{font-size:12px;color:var(--brand-700);opacity:.8;margin-top:2px}
    .scanner-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .scanner-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .scanner-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .scanner-body{padding:24px 20px;display:flex;flex-direction:column;align-items:center;gap:16px}
    #video-container{position:relative;width:100%;max-width:400px;border-radius:var(--radius);overflow:hidden;background:#000;aspect-ratio:1}
    #qr-video{width:100%;height:100%;object-fit:cover;display:block}
    .scan-overlay{position:absolute;inset:0;display:flex;align-items:center;justify-content:center}
    .scan-frame{width:60%;height:60%;border:3px solid var(--brand);border-radius:12px;box-shadow:0 0 0 99px rgba(0,0,0,.35)}
    .scan-status{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2)}
    #scan-result{min-height:50px;width:100%;max-width:400px}
    .result-success{background:#dcfce7;border:1px solid #bbf7d0;border-radius:var(--radius-sm);padding:14px 18px;font-family:'Plus Jakarta Sans',sans-serif}
    .result-success .r-title{font-weight:700;color:#15803d;font-size:14px}
    .result-success .r-sub{font-size:12.5px;color:#15803d;opacity:.8;margin-top:4px}
    .result-error{background:#fee2e2;border:1px solid #fecaca;border-radius:var(--radius-sm);padding:14px 18px;font-family:'Plus Jakarta Sans',sans-serif}
    .result-error .r-title{font-weight:700;color:#dc2626;font-size:14px}
    .result-error .r-sub{font-size:12.5px;color:#dc2626;opacity:.8;margin-top:4px}
    .manual-section{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .manual-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .manual-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .manual-body{padding:20px}
    .field{display:flex;flex-direction:column;gap:6px;margin-bottom:12px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
    .field select{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;width:100%;box-sizing:border-box}
    .field select:focus{border-color:var(--brand-h);background:#fff}
    .btn-scan-manual{width:100%;height:42px;background:var(--brand);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px}
    .btn-scan-manual:hover{filter:brightness(.93)}
    .btn-scan-manual:disabled{opacity:.6;cursor:not-allowed;filter:none}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a><span class="sep">›</span>
        <a href="{{ route('admin.absensi-guru-piket.dashboard') }}">Piket Guru</a><span class="sep">›</span>
        <span class="current">Scan QR</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Scanner QR Guru</h1>
            <p class="page-sub">{{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}</p>
        </div>
        <a href="{{ route('admin.absensi-guru-piket.dashboard') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <div class="sesi-info">
        <div>
            <p class="sesi-title">✅ Sesi QR Aktif</p>
            <p class="sesi-detail">
                Berlaku: {{ \Carbon\Carbon::parse($sesiAktif->berlaku_mulai)->format('H:i') }} –
                {{ \Carbon\Carbon::parse($sesiAktif->kadaluarsa_pada)->format('H:i') }} WIB
                @if($sesiAktif->radius_meter) | Radius: {{ $sesiAktif->radius_meter }}m @endif
            </p>
        </div>
    </div>

    <div class="scanner-card">
        <div class="scanner-header">
            <svg width="14" height="14" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><line x1="14" y1="14" x2="14.01" y2="14"/></svg>
            <span class="scanner-title">Scan QR Code Guru</span>
        </div>
        <div class="scanner-body">
            <div id="video-container">
                <video id="qr-video" autoplay muted playsinline></video>
                <div class="scan-overlay"><div class="scan-frame"></div></div>
            </div>
            <p class="scan-status" id="scan-status">Menginisialisasi kamera…</p>
            <div id="scan-result"></div>
        </div>
    </div>

    <div class="manual-section">
        <div class="manual-header">
            <p class="manual-title">Input Manual (Jika Kamera Tidak Tersedia)</p>
        </div>
        <div class="manual-body">
            <div class="field">
                <label>Pilih Guru</label>
                <select id="guruSelect">
                    <option value="">— Pilih Guru —</option>
                    @foreach(\App\Models\Guru::aktif()->orderBy('nama_lengkap')->get() as $g)
                        <option value="{{ $g->id }}">{{ $g->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>
            <button type="button" class="btn-scan-manual" id="btnManual" onclick="prosesManual()">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Catat Absensi
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
<script>
    const KODE_QR   = @json($sesiAktif->kode_qr);
    const CSRF      = '{{ csrf_token() }}';
    const PROSES_URL= '{{ route("admin.sesi-qr-guru.proses-qr") }}';

    const video      = document.getElementById('qr-video');
    const statusEl   = document.getElementById('scan-status');
    const resultEl   = document.getElementById('scan-result');
    const canvas     = document.createElement('canvas');
    const ctx        = canvas.getContext('2d');
    let scanning     = true;

    async function startCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
            video.srcObject = stream;
            video.onloadedmetadata = () => {
                video.play();
                statusEl.textContent = 'Arahkan kamera ke QR code guru…';
                requestAnimationFrame(tick);
            };
        } catch (e) {
            statusEl.textContent = 'Kamera tidak tersedia. Gunakan input manual di bawah.';
        }
    }

    function tick() {
        if (!scanning) return;
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            canvas.width  = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const code    = jsQR(imgData.data, imgData.width, imgData.height);
            if (code) {
                scanning = false;
                statusEl.textContent = 'QR terdeteksi! Memproses…';
                kirimAbsensi(code.data, null);
                return;
            }
        }
        requestAnimationFrame(tick);
    }

    async function kirimAbsensi(kodeQr, guruId) {
        const body = { kode_qr: kodeQr };
        if (guruId) body.guru_id = guruId;

        try {
            const resp = await fetch(PROSES_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify(body)
            });
            const data = await resp.json();

            if (data.berhasil) {
                resultEl.innerHTML = `<div class="result-success"><p class="r-title">✅ Absensi Berhasil</p><p class="r-sub">${data.nama_guru} — ${data.waktu_scan}</p></div>`;
                statusEl.textContent = 'Berhasil! Scanner siap untuk guru berikutnya…';
                setTimeout(() => { scanning = true; resultEl.innerHTML = ''; requestAnimationFrame(tick); }, 4000);
            } else {
                resultEl.innerHTML = `<div class="result-error"><p class="r-title">❌ Gagal</p><p class="r-sub">${data.pesan}</p></div>`;
                statusEl.textContent = 'Scan ulang untuk mencoba lagi…';
                setTimeout(() => { scanning = true; resultEl.innerHTML = ''; requestAnimationFrame(tick); }, 4000);
            }
        } catch (e) {
            resultEl.innerHTML = `<div class="result-error"><p class="r-title">❌ Error Koneksi</p><p class="r-sub">Gagal menghubungi server</p></div>`;
            setTimeout(() => { scanning = true; resultEl.innerHTML = ''; requestAnimationFrame(tick); }, 4000);
        }
    }

    async function prosesManual() {
        const guruId = document.getElementById('guruSelect').value;
        if (!guruId) { alert('Pilih guru terlebih dahulu'); return; }
        const btn = document.getElementById('btnManual');
        btn.disabled = true;
        btn.textContent = 'Memproses…';
        await kirimAbsensi(KODE_QR, guruId);
        btn.disabled = false;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg> Catat Absensi`;
    }

    startCamera();
</script>
</x-app-layout>