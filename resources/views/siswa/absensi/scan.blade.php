<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 48px;max-width:2000px}
    .page-header{margin-bottom:24px}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    /* Tab nav */
    .tab-nav{display:flex;gap:4px;margin-bottom:20px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);padding:4px;width:fit-content}
    .tab-link{padding:7px 18px;border-radius:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text3);text-decoration:none;transition:all .15s}
    .tab-link.active{background:var(--surface);color:var(--brand-600);box-shadow:0 1px 3px rgba(0,0,0,.08)}
    .tab-link:hover:not(.active){color:var(--text2)}

    /* Alert */
    .alert{display:flex;align-items:flex-start;gap:10px;padding:13px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-size:13.5px;line-height:1.5}
    .alert-success{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0}
    .alert-warning{background:#fef9c3;color:#a16207;border:1px solid #fde68a}
    .alert-error  {background:#fee2e2;color:#dc2626;border:1px solid #fecaca}
    .alert svg{flex-shrink:0;margin-top:1px}

    /* Status card (sudah absen) */
    .status-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:32px 28px;text-align:center;margin-bottom:16px}
    .status-icon{width:64px;height:64px;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px}
    .status-icon.hadir {background:#dcfce7}
    .status-icon.telat {background:#fef9c3}
    .status-icon.lainnya{background:var(--surface3)}
    .status-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:17px;font-weight:800;color:var(--text);margin-bottom:6px}
    .status-meta{font-size:13px;color:var(--text3);display:flex;flex-wrap:wrap;justify-content:center;gap:12px;margin-top:10px}
    .status-meta span{display:flex;align-items:center;gap:4px}

    /* QR Scanner card */
    .scan-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .scan-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .scan-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .scan-card-body{padding:28px 24px}

    /* QR reader viewport */
    .qr-viewport{position:relative;width:100%;max-width:360px;margin:0 auto 20px;aspect-ratio:1;background:#000;border-radius:12px;overflow:hidden}
    #qr-video{width:100%;height:100%;object-fit:cover}
    .qr-overlay{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none}
    .qr-frame{width:200px;height:200px;position:relative}
    .qr-frame::before,.qr-frame::after,
    .qr-frame-inner::before,.qr-frame-inner::after{
        content:'';position:absolute;width:28px;height:28px;border-color:#fff;border-style:solid;
    }
    .qr-frame::before{top:0;left:0;border-width:3px 0 0 3px;border-radius:4px 0 0 0}
    .qr-frame::after {top:0;right:0;border-width:3px 3px 0 0;border-radius:0 4px 0 0}
    .qr-frame-inner::before{bottom:0;left:0;border-width:0 0 3px 3px;border-radius:0 0 0 4px}
    .qr-frame-inner::after {bottom:0;right:0;border-width:0 3px 3px 0;border-radius:0 0 4px 0}
    .qr-scan-line{position:absolute;left:8px;right:8px;height:2px;background:linear-gradient(90deg,transparent,#3582f0,transparent);animation:scan 2s ease-in-out infinite}
    @keyframes scan{0%{top:8px}100%{top:calc(100% - 10px)}}

    .qr-status-text{text-align:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text3);margin-bottom:20px;min-height:20px}

    /* Manual input */
    .divider{display:flex;align-items:center;gap:10px;margin:20px 0;color:var(--text3);font-size:12px}
    .divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border)}

    .input-group{display:flex;gap:8px}
    .qr-input{flex:1;height:42px;padding:0 14px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text);outline:none;transition:border-color .15s}
    .qr-input:focus{border-color:var(--brand-500);box-shadow:0 0 0 3px var(--brand-50)}
    .btn-submit{height:42px;padding:0 20px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap;transition:background .15s}
    .btn-submit:hover{background:var(--brand-700)}
    .btn-submit:disabled{opacity:.5;cursor:not-allowed}

    .hint-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 14px;margin-top:16px}
    .hint-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:6px}
    .hint-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:5px}
    .hint-list li{font-size:12.5px;color:var(--text2);display:flex;align-items:flex-start;gap:6px}
    .hint-list li::before{content:'→';color:var(--brand-500);font-weight:700;flex-shrink:0;margin-top:1px}

    @media(max-width:640px){.page{padding:16px}.input-group{flex-direction:column}}
</style>

<div class="page">
    <div class="page-header">
        <h1 class="page-title">Absensi</h1>
        <p class="page-sub">Presensi kehadiran harian siswa</p>
    </div>

    <div class="tab-nav">
        <a href="{{ route('siswa.absensi.scan') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.scan') ? 'active' : '' }}">
            Scan QR Hadir
        </a>
        <a href="{{ route('siswa.absensi.riwayat') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.riwayat') ? 'active' : '' }}">
            Riwayat Kehadiran
        </a>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('warning'))
    <div class="alert alert-warning">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
            <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
        </svg>
        {{ session('warning') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Sudah absen hari ini --}}
    @if($absensiHariIni)
    @php
        $st = $absensiHariIni->status;
        $iconClass = in_array($st, ['hadir','telat']) ? ($st === 'telat' ? 'telat' : 'hadir') : 'lainnya';
    @endphp
    <div class="status-card">
        <div class="status-icon {{ $iconClass }}">
            @if(in_array($st, ['hadir','telat']))
                <svg width="28" height="28" fill="none" stroke="{{ $st === 'telat' ? '#a16207' : '#15803d' }}" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            @else
                <svg width="28" height="28" fill="none" stroke="#94a3b8" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            @endif
        </div>
        <p class="status-title">
            @if($st === 'hadir') Anda sudah hadir hari ini ✓
            @elseif($st === 'telat') Anda hadir — tercatat telat
            @else Absensi sudah tercatat: {{ ucfirst($st) }}
            @endif
        </p>
        <p style="font-size:13px;color:var(--text3)">
            {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}
        </p>
        <div class="status-meta">
            @if($absensiHariIni->jam_masuk)
            <span>
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                Jam masuk: <strong>{{ \Carbon\Carbon::parse($absensiHariIni->jam_masuk)->format('H:i') }}</strong>
            </span>
            @endif
            <span>
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                </svg>
                Via: {{ strtoupper($absensiHariIni->metode ?? 'manual') }}
            </span>
        </div>
    </div>
    @endif

    {{-- QR Scanner card (sembunyikan jika sudah hadir/telat) --}}
    @if(! $absensiHariIni || ! in_array($absensiHariIni->status, ['hadir','telat']))
    <div class="scan-card">
        <div class="scan-card-header">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
            </svg>
            <span class="scan-card-title">Scan QR Code Kehadiran</span>
        </div>
        <div class="scan-card-body">

            {{-- Kamera viewer --}}
            <div class="qr-viewport" id="qr-viewport">
                <video id="qr-video" playsinline></video>
                <div class="qr-overlay">
                    <div class="qr-frame">
                        <div class="qr-frame-inner"></div>
                        <div class="qr-scan-line"></div>
                    </div>
                </div>
            </div>
            <p class="qr-status-text" id="qr-status">Menginisialisasi kamera…</p>

            <div class="divider">atau masukkan kode manual</div>

            {{-- Manual input --}}
            <form method="POST" action="{{ route('siswa.absensi.do-scan') }}" id="qr-form">
                @csrf
                <div class="input-group">
                    <input type="text" name="qr_code" id="qr-input" class="qr-input"
                           placeholder="Masukkan kode QR…" autocomplete="off" required>
                    <button type="submit" class="btn-submit">Absen</button>
                </div>
                @error('qr_code')
                    <p style="font-size:12px;color:#dc2626;margin-top:6px">{{ $message }}</p>
                @enderror
            </form>

            <div class="hint-box">
                <p class="hint-title">Petunjuk</p>
                <ul class="hint-list">
                    <li>Arahkan kamera ke QR Code yang ditampilkan guru di kelas</li>
                    <li>Pastikan Anda berada di kelas yang sesuai saat scan</li>
                    <li>Absensi hanya dapat dilakukan satu kali per hari</li>
                    <li>Scan sebelum QR Code kadaluarsa untuk menghindari status telat</li>
                </ul>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- QR Scanner library --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsQR/1.4.0/jsQR.min.js"></script>
<script>
(function () {
    const video     = document.getElementById('qr-video');
    const statusEl  = document.getElementById('qr-status');
    const qrInput   = document.getElementById('qr-input');
    const qrForm    = document.getElementById('qr-form');

    if (!video || !qrForm) return;

    const canvas = document.createElement('canvas');
    const ctx    = canvas.getContext('2d');
    let scanning  = true;
    let stream    = null;

    async function startCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'environment' }
            });
            video.srcObject = stream;
            await video.play();
            statusEl.textContent = 'Arahkan kamera ke QR Code…';
            requestAnimationFrame(tick);
        } catch (err) {
            statusEl.textContent = 'Kamera tidak tersedia. Gunakan input manual.';
            console.warn('Camera error:', err);
        }
    }

    function tick() {
        if (!scanning) return;
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            canvas.width  = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0);
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: 'dontInvert',
            });
            if (code) {
                scanning = false;
                statusEl.textContent = `Kode terdeteksi: ${code.data}`;
                statusEl.style.color = 'var(--brand-600)';
                qrInput.value = code.data;
                // Hentikan kamera lalu submit
                if (stream) stream.getTracks().forEach(t => t.stop());
                setTimeout(() => qrForm.submit(), 500);
                return;
            }
        }
        requestAnimationFrame(tick);
    }

    startCamera();
})();
</script>
</x-app-layout>