<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --pk-700:#1750c0;--pk-600:#1f63db;--pk-500:#3582f0;--pk-400:#60a5fa;
        --pk-100:#d9ebff;--pk-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 40px;max-width:2000px;margin:0 auto}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3)}
    .btn-primary{background:var(--pk-600);color:#fff}
    .btn-primary:hover{background:var(--pk-700)}

    /* Grid */
    .grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}

    /* Card */
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .card-hd{padding:13px 18px;border-bottom:1px solid var(--border)}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:7px}
    .card-body{padding:18px}

    /* ── QR Scanner ── */
    .scanner-wrap{position:relative;background:#0f172a;border-radius:9px;overflow:hidden;aspect-ratio:1;display:flex;align-items:center;justify-content:center;margin-bottom:13px}
    #qr-video{width:100%;height:100%;object-fit:cover;display:block}
    .scan-overlay{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none}
    .scan-frame{width:62%;aspect-ratio:1;border-radius:12px;box-shadow:0 0 0 9999px rgba(15,23,42,.6);position:relative}

    /* Four corner brackets */
    .scan-frame::before,.scan-frame::after,
    .scan-frame .corner-bl,.scan-frame .corner-tr{content:'';position:absolute;width:22px;height:22px;border-color:var(--pk-400);border-style:solid}
    .scan-frame::before{top:0;left:0;border-width:3px 0 0 3px;border-radius:5px 0 0 0}
    .scan-frame::after{bottom:0;right:0;border-width:0 3px 3px 0;border-radius:0 0 5px 0}
    .scan-frame .corner-bl{bottom:0;left:0;border-width:0 0 3px 3px;border-radius:0 0 0 5px}
    .scan-frame .corner-tr{top:0;right:0;border-width:3px 3px 0 0;border-radius:0 5px 0 0}

    .scan-line{position:absolute;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--pk-400),transparent);animation:scanline 2s ease-in-out infinite}
    @keyframes scanline{0%{top:0;opacity:0}10%{opacity:1}90%{opacity:1}100%{top:100%;opacity:0}}

    .scanner-status{display:flex;align-items:center;justify-content:center;gap:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;color:var(--text3);margin-bottom:10px}
    .status-pulse{width:8px;height:8px;border-radius:50%;background:#94a3b8;flex-shrink:0;transition:background .3s}
    .status-pulse.live{background:#15803d;animation:livepulse 1.4s ease-in-out infinite}
    @keyframes livepulse{0%,100%{opacity:1;box-shadow:0 0 0 0 rgba(21,128,61,.4)}50%{opacity:.7;box-shadow:0 0 0 5px rgba(21,128,61,0)}}

    .btn-manual{display:inline-flex;align-items:center;gap:5px;background:none;border:none;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--pk-600);cursor:pointer;padding:0;transition:color .15s}
    .btn-manual:hover{color:var(--pk-700)}

    /* ── Form ── */
    .field{margin-bottom:14px}
    .field label{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);margin-bottom:5px}
    .field label .req{color:#dc2626}
    .field input,.field select{width:100%;height:40px;padding:0 13px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s,background .15s;box-sizing:border-box}
    .field input:focus,.field select:focus{border-color:var(--pk-500);background:#fff}
    .field input.filled{border-color:#86efac;background:#f0fdf4;color:#15803d;font-weight:600}

    .hint{font-family:'DM Sans',sans-serif;font-size:11.5px;color:var(--text3);margin-top:4px}
    .hint code{background:var(--surface3);padding:1px 5px;border-radius:4px;font-size:11px}

    .btn-submit{width:100%;height:42px;background:var(--pk-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:7px;transition:background .15s}
    .btn-submit:hover{background:var(--pk-700)}
    .btn-submit:disabled{opacity:.45;cursor:not-allowed}

    /* Divider */
    .divider{display:flex;align-items:center;gap:10px;margin:14px 0;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3)}
    .divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border)}

    /* Tips */
    .tips{list-style:none;padding:0;margin:0}
    .tips li{display:flex;align-items:flex-start;gap:8px;padding:6px 0;border-bottom:1px solid #f1f5f9;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text2)}
    .tips li:last-child{border-bottom:none}
    .tips li .arr{color:var(--pk-500);font-weight:700;flex-shrink:0;margin-top:1px}

    /* Alert */
    .alert{display:flex;align-items:flex-start;gap:9px;padding:11px 15px;border-radius:var(--radius-sm);margin-bottom:14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600}
    .a-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d}
    .a-warning{background:#fffbeb;border:1px solid #fde68a;color:#92400e}
    .a-error{background:#fff0f0;border:1px solid #fecaca;color:#dc2626}

    @media(max-width:700px){.grid{grid-template-columns:1fr}.page{padding:16px}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Scan QR Guru</h1>
            <p class="page-sub">Arahkan kamera ke QR code pada kartu identitas guru untuk mencatat kehadiran</p>
        </div>
        <div>
            <a href="{{ route('piket.absensi-guru.dashboard') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Flash --}}
    @foreach(['success' => 'a-success','warning' => 'a-warning','error' => 'a-error'] as $type => $cls)
        @if(session($type))
        <div class="alert {{ $cls }}">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                @if($type === 'success')<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                @else<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                @endif
            </svg>
            {{ session($type) }}
        </div>
        @endif
    @endforeach

    @if($errors->any())
    <div class="alert a-error">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
        <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    </div>
    @endif

    <div class="grid">

        {{-- Scanner Panel --}}
        <div class="card">
            <div class="card-hd">
                <p class="card-title">
                    <svg width="13" height="13" fill="none" stroke="var(--pk-600)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Kamera
                </p>
            </div>
            <div class="card-body">
                <div class="scanner-wrap">
                    <video id="qr-video" playsinline></video>
                    <div class="scan-overlay">
                        <div class="scan-frame">
                            <div class="scan-line"></div>
                            <div class="corner-bl"></div>
                            <div class="corner-tr"></div>
                        </div>
                    </div>
                </div>

                <div class="scanner-status">
                    <span class="status-pulse" id="statusPulse"></span>
                    <span id="statusText">Memulai kamera…</span>
                </div>

                <button type="button" class="btn-manual" onclick="focusManual()">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Kamera tidak tersedia? Input manual
                </button>
            </div>
        </div>

        {{-- Form Panel --}}
        <div class="card">
            <div class="card-hd">
                <p class="card-title">
                    <svg width="13" height="13" fill="none" stroke="var(--pk-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Data Kehadiran
                </p>
            </div>
            <div class="card-body">

                <form action="{{ route('piket.absensi-guru.proses-qr') }}" method="POST" id="qrForm">
                    @csrf

                    <div class="field">
                        <label>Data QR / NIP Guru <span class="req">*</span></label>
                        <input type="text"
                               name="qr_data"
                               id="qrDataInput"
                               value="{{ old('qr_data') }}"
                               placeholder="Scan QR atau ketik NIP guru…"
                               required
                               autocomplete="off"
                               oninput="onInputChange(this)">
                        <p class="hint">Format QR: <code>GURU-{id}</code> &nbsp;atau NIP langsung</p>
                    </div>

                    <div class="field">
                        <label>Status Kehadiran <span class="req">*</span></label>
                        <select name="status" required>
                            <option value="hadir"  {{ old('status','hadir') === 'hadir'  ? 'selected':'' }}>✓ Hadir</option>
                            <option value="telat"  {{ old('status') === 'telat'  ? 'selected':'' }}>⏱ Telat</option>
                            <option value="izin"   {{ old('status') === 'izin'   ? 'selected':'' }}>📋 Izin</option>
                            <option value="sakit"  {{ old('status') === 'sakit'  ? 'selected':'' }}>🏥 Sakit</option>
                            <option value="alfa"   {{ old('status') === 'alfa'   ? 'selected':'' }}>✗ Alfa</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn" {{ old('qr_data') ? '' : 'disabled' }}>
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Catat Absensi
                    </button>
                </form>

                <div class="divider">tips penggunaan</div>

                <ul class="tips">
                    <li><span class="arr">→</span> Arahkan kamera ke QR code pada kartu guru — QR terbaca otomatis</li>
                    <li><span class="arr">→</span> Pastikan pencahayaan ruangan cukup agar QR terbaca dengan jelas</li>
                    <li><span class="arr">→</span> Jika kamera gagal, ketik NIP guru langsung di kolom input</li>
                    <li><span class="arr">→</span> Guru yang sudah absen hari ini tidak dapat dicatat ulang</li>
                </ul>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let scanning    = false;
let alreadyRead = false;
const video       = document.getElementById('qr-video');
const statusPulse = document.getElementById('statusPulse');
const statusText  = document.getElementById('statusText');
const qrInput     = document.getElementById('qrDataInput');
const submitBtn   = document.getElementById('submitBtn');

/* ── Start kamera ── */
async function startCamera() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: { ideal: 'environment' }, width: { ideal: 720 } }
        });
        video.srcObject = stream;
        await video.play();
        scanning = true;
        statusPulse.classList.add('live');
        statusText.textContent = 'Kamera aktif — arahkan ke QR code';
        tick();
    } catch (err) {
        statusText.textContent = 'Kamera tidak tersedia — gunakan input manual';
        console.warn('Camera:', err.message);
    }
}

/* ── Scan loop ── */
function tick() {
    if (!scanning || alreadyRead) return;
    if (video.readyState >= 2) {
        const canvas = Object.assign(document.createElement('canvas'), {
            width: video.videoWidth, height: video.videoHeight
        });
        canvas.getContext('2d').drawImage(video, 0, 0);
        const img  = canvas.getContext('2d').getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(img.data, img.width, img.height, { inversionAttempts: 'dontInvert' });
        if (code?.data) { onScanned(code.data); return; }
    }
    requestAnimationFrame(tick);
}

/* ── QR berhasil dibaca ── */
function onScanned(data) {
    alreadyRead = true;
    scanning    = false;
    statusPulse.classList.remove('live');
    statusPulse.style.background = '#1f63db';
    statusText.textContent = 'QR terbaca: ' + data;

    qrInput.value = data;
    qrInput.classList.add('filled');
    submitBtn.disabled = false;

    // Sinyal audio visual
    document.body.style.outline = '3px solid #1f63db';
    setTimeout(() => document.body.style.outline = '', 600);

    Swal.fire({
        icon: 'success',
        title: 'QR Terbaca!',
        html: `<code style="font-size:13px;background:#f1f5f9;padding:4px 10px;border-radius:6px">${data}</code><br><span style="font-size:13px;color:#64748b;margin-top:6px;display:block">Pilih status lalu klik <strong>Catat Absensi</strong></span>`,
        confirmButtonColor: '#1f63db',
        confirmButtonText: 'Lanjutkan',
    });
}

/* ── Manual input change ── */
function onInputChange(input) {
    const hasVal = input.value.trim() !== '';
    submitBtn.disabled = !hasVal;
    input.classList.toggle('filled', hasVal);
}

/* ── Focus manual input ── */
function focusManual() {
    qrInput.focus();
    qrInput.placeholder = 'Ketik NIP guru atau GURU-{id}…';
    Swal.fire({
        icon: 'info',
        title: 'Input Manual',
        text: 'Ketik NIP guru atau format GURU-{id} pada kolom yang tersedia.',
        timer: 2500,
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
    });
}

/* ── Init ── */
startCamera();

// Jika ada old value, aktifkan tombol
if (qrInput.value.trim()) {
    qrInput.classList.add('filled');
    submitBtn.disabled = false;
}

/* ── Flash messages ── */
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2800,showConfirmButton:false,toast:true,position:'top-end'});
@endif
@if(session('error'))
Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
@endif
@if(session('warning'))
Swal.fire({icon:'warning',title:'Perhatian!',text:@json(session('warning')),confirmButtonColor:'#1f63db'});
@endif
</script>
</x-app-layout>