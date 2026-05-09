<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 48px}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;margin-bottom:20px}

    /* Tab nav */
    .tab-nav{display:flex;gap:4px;margin-bottom:20px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);padding:4px;width:fit-content;flex-wrap:wrap}
    .tab-link{padding:7px 18px;border-radius:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text3);text-decoration:none;transition:all .15s}
    .tab-link.active{background:var(--surface);color:var(--brand-600);box-shadow:0 1px 3px rgba(0,0,0,.08)}
    .tab-link:hover:not(.active){color:var(--text2)}

    /* Alert */
    .alert{display:flex;align-items:flex-start;gap:10px;padding:13px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-size:13.5px;line-height:1.5}
    .alert svg{flex-shrink:0;margin-top:1px}
    .alert-success{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0}
    .alert-warning{background:#fef9c3;color:#a16207;border:1px solid #fde68a}
    .alert-error{background:#fee2e2;color:#dc2626;border:1px solid #fecaca}

    /* Summary strip */
    .summary-strip{display:flex;gap:12px;margin-bottom:16px;flex-wrap:wrap}
    .summary-pill{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;border:1px solid var(--border);background:var(--surface);box-shadow:0 1px 3px rgba(0,0,0,.07)}
    .summary-pill .dot{width:8px;height:8px;border-radius:50%}

    /* Absensi hari ini */
    .absensi-hari-ini{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px;box-shadow:0 1px 3px rgba(0,0,0,.07)}
    .absensi-header{display:flex;align-items:center;gap:10px;padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .absensi-header-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .absensi-count-badge{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;background:var(--brand-600);color:#fff;padding:2px 8px;border-radius:99px;margin-left:auto}
    .mapel-row{display:flex;align-items:center;gap:14px;padding:13px 20px;border-bottom:1px solid var(--border)}
    .mapel-row:last-child{border-bottom:none}
    .mapel-dot{width:9px;height:9px;border-radius:50%;flex-shrink:0}
    .mapel-info{flex:1;min-width:0}
    .mapel-nama{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .mapel-meta{font-size:11.5px;color:var(--text3);margin-top:2px;display:flex;gap:8px;align-items:center;flex-wrap:wrap}
    .mapel-right{display:flex;flex-direction:column;align-items:flex-end;gap:4px;flex-shrink:0}
    .mapel-jam{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text2)}
    .status-badge{display:inline-flex;align-items:center;gap:3px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:99px}
    .badge-hadir{background:#f0fdf4;color:#15803d;border:1px solid #dcfce7}
    .badge-telat{background:#fefce8;color:#a16207;border:1px solid #fef9c3}
    .badge-izin{background:#eff6ff;color:#1d4ed8;border:1px solid #dbeafe}
    .badge-sakit{background:#fdf4ff;color:#7e22ce;border:1px solid #f3e8ff}
    .badge-alfa{background:#fff5f5;color:#dc2626;border:1px solid #fee2e2}

    /* Scan card */
    .scan-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px;box-shadow:0 1px 3px rgba(0,0,0,.07)}
    .scan-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .scan-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .scan-card-body{padding:24px}

    /* QR viewport */
    .qr-viewport{position:relative;width:100%;max-width:320px;margin:0 auto 16px;aspect-ratio:1;background:#111;border-radius:12px;overflow:hidden}
    #qr-video{width:100%;height:100%;object-fit:cover;display:block}
    .qr-placeholder{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;background:#1a1a2e;color:rgba(255,255,255,.5);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;text-align:center;padding:16px}
    .qr-overlay{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none}
    .qr-frame{width:180px;height:180px;position:relative}
    .qr-frame::before,.qr-frame::after,.qr-frame-inner::before,.qr-frame-inner::after{content:'';position:absolute;width:24px;height:24px;border-color:#fff;border-style:solid}
    .qr-frame::before{top:0;left:0;border-width:3px 0 0 3px;border-radius:4px 0 0 0}
    .qr-frame::after{top:0;right:0;border-width:3px 3px 0 0;border-radius:0 4px 0 0}
    .qr-frame-inner::before{bottom:0;left:0;border-width:0 0 3px 3px;border-radius:0 0 0 4px}
    .qr-frame-inner::after{bottom:0;right:0;border-width:0 3px 3px 0;border-radius:0 0 4px 0}
    .qr-scan-line{position:absolute;left:10px;right:10px;height:2px;background:linear-gradient(90deg,transparent,var(--brand-500),transparent);animation:scan 2s ease-in-out infinite}
    @keyframes scan{0%{top:10px}100%{top:calc(100% - 12px)}}

    .qr-status-text{text-align:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text3);margin-bottom:16px;min-height:20px}
    .qr-status-text.detected{color:var(--brand-600)}
    .qr-status-text.error{color:#dc2626}

    /* Divider */
    .divider{display:flex;align-items:center;gap:10px;margin:18px 0;color:var(--text3);font-size:12px}
    .divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border)}

    /* Input & button */
    .input-group{display:flex;gap:8px}
    .qr-input{flex:1;height:42px;padding:0 14px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s,box-shadow .15s}
    .qr-input:focus{border-color:var(--brand-500);box-shadow:0 0 0 3px var(--brand-50)}
    .btn-submit{height:42px;padding:0 20px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s}
    .btn-submit:hover{background:var(--brand-700)}
    .btn-submit:disabled{opacity:.5;cursor:not-allowed}

    /* Hint */
    .hint-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 14px;margin-top:16px}
    .hint-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:6px}
    .hint-list{list-style:none;display:flex;flex-direction:column;gap:5px}
    .hint-list li{font-size:12.5px;color:var(--text2);display:flex;align-items:flex-start;gap:6px}
    .hint-list li::before{content:'→';color:var(--brand-500);font-weight:700;flex-shrink:0}

    @media(max-width:640px){.page{padding:14px 14px 56px}.input-group{flex-direction:column}.tab-nav{width:100%}.tab-link{flex:1;text-align:center;padding:7px 10px}}
</style>

<div class="page">
    <h1 class="page-title">Absensi Kelas</h1>
    <p class="page-sub">Presensi kehadiran per mata pelajaran via scan QR</p>

    {{-- Tab nav — konsisten 4 tab di semua view absensi --}}
    <div class="tab-nav">
        <a href="{{ route('siswa.absensi.scan') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.scan') ? 'active' : '' }}">
            Scan QR
        </a>
        <a href="{{ route('siswa.absensi.jadwal') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.jadwal') ? 'active' : '' }}">
            QR Per Pelajaran
        </a>
        <a href="{{ route('siswa.absensi.riwayat') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.riwayat') ? 'active' : '' }}">
            Riwayat
        </a>
        <a href="{{ route('siswa.absensi.rekap') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.rekap') ? 'active' : '' }}">
            Rekap
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
                <circle cx="12" cy="12" r="10"/>
                <line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    @php
        /*
         * $absensiHariIni adalah Collection (->get()), bukan single model.
         * Semua akses harus via iterasi atau collection method, BUKAN ->status langsung.
         */
        $totalAbsensi = $absensiHariIni->count();
        $hitungStatus = [
            'hadir' => $absensiHariIni->where('status', 'hadir')->count(),
            'telat' => $absensiHariIni->where('status', 'telat')->count(),
            'izin'  => $absensiHariIni->where('status', 'izin')->count(),
            'sakit' => $absensiHariIni->where('status', 'sakit')->count(),
            'alfa'  => $absensiHariIni->where('status', 'alfa')->count(),
        ];
    @endphp

    {{-- Ringkasan absensi hari ini --}}
    @if($totalAbsensi > 0)
        <div class="summary-strip">
            @if($hitungStatus['hadir'] > 0)
                <span class="summary-pill">
                    <span class="dot" style="background:#16a34a"></span>
                    {{ $hitungStatus['hadir'] }} Hadir
                </span>
            @endif
            @if($hitungStatus['telat'] > 0)
                <span class="summary-pill">
                    <span class="dot" style="background:#ca8a04"></span>
                    {{ $hitungStatus['telat'] }} Telat
                </span>
            @endif
            @if($hitungStatus['izin'] > 0)
                <span class="summary-pill" style="color:#1d4ed8">
                    <span class="dot" style="background:#3b82f6"></span>
                    {{ $hitungStatus['izin'] }} Izin
                </span>
            @endif
            @if($hitungStatus['sakit'] > 0)
                <span class="summary-pill" style="color:#7e22ce">
                    <span class="dot" style="background:#a855f7"></span>
                    {{ $hitungStatus['sakit'] }} Sakit
                </span>
            @endif
            @if($hitungStatus['alfa'] > 0)
                <span class="summary-pill" style="color:#dc2626">
                    <span class="dot" style="background:#dc2626"></span>
                    {{ $hitungStatus['alfa'] }} Alfa
                </span>
            @endif
        </div>

        <div class="absensi-hari-ini">
            <div class="absensi-header">
                <svg width="14" height="14" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span class="absensi-header-title">Absensi Hari Ini</span>
                <span class="absensi-count-badge">{{ $totalAbsensi }} mapel</span>
            </div>

            @foreach($absensiHariIni as $absen)
                @php
                    $st        = $absen->status ?? 'alfa';
                    $namaMapel = $absen->jadwalPelajaran?->mataPelajaran?->nama_mapel
                                 ?? $absen->kelas?->nama_kelas
                                 ?? 'Mata Pelajaran';
                    $dotColors = [
                        'hadir' => '#16a34a',
                        'telat' => '#ca8a04',
                        'izin'  => '#3b82f6',
                        'sakit' => '#a855f7',
                        'alfa'  => '#dc2626',
                    ];
                    $dotColor = $dotColors[$st] ?? '#94a3b8';
                @endphp
                <div class="mapel-row">
                    <span class="mapel-dot" style="background:{{ $dotColor }}"></span>
                    <div class="mapel-info">
                        <p class="mapel-nama">{{ $namaMapel }}</p>
                        <div class="mapel-meta">
                            <span>{{ strtoupper($absen->metode ?? 'manual') }}</span>
                            @if($absen->jadwalPelajaran)
                                <span>·</span>
                                <span>
                                    {{ \Carbon\Carbon::parse($absen->jadwalPelajaran->jam_mulai)->format('H:i') }}
                                    –
                                    {{ \Carbon\Carbon::parse($absen->jadwalPelajaran->jam_selesai)->format('H:i') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="mapel-right">
                        @if($absen->jam_masuk)
                            <span class="mapel-jam">
                                {{ \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') }}
                            </span>
                        @endif
                        <span class="status-badge badge-{{ $st }}">{{ ucfirst($st) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Scanner card --}}
    <div class="scan-card">
        <div class="scan-card-header">
            <svg width="14" height="14" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
            </svg>
            <span class="scan-card-title">Scan QR Code Kehadiran</span>
            @if($totalAbsensi > 0)
                <span style="margin-left:auto;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3)">
                    Sudah {{ $totalAbsensi }} mapel hari ini
                </span>
            @endif
        </div>
        <div class="scan-card-body">

            <div class="qr-viewport">
                <video id="qr-video" playsinline></video>
                <div class="qr-placeholder" id="qr-placeholder">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                        <circle cx="12" cy="13" r="4"/>
                    </svg>
                    Memuat kamera…
                </div>
                <div class="qr-overlay">
                    <div class="qr-frame">
                        <div class="qr-frame-inner"></div>
                        <div class="qr-scan-line" id="scan-line"></div>
                    </div>
                </div>
            </div>
            <p class="qr-status-text" id="qr-status">Menginisialisasi kamera…</p>

            <div class="divider">atau masukkan kode manual</div>

            {{--
                PENTING: field name HARUS 'kode_qr' sesuai yang di-validate
                di controller doScan(). Sebelumnya mungkin 'qr_code' → gagal validasi.
            --}}
            <form method="POST" action="{{ route('siswa.absensi.do-scan') }}" id="qr-form">
                @csrf
                <div class="input-group">
                    <input
                        type="text"
                        name="kode_qr"
                        id="qr-input"
                        class="qr-input"
                        placeholder="Masukkan kode QR (misal: ABC123 atau SESI-ABC123)"
                        autocomplete="off"
                        spellcheck="false"
                        required
                    >
                    <button type="submit" class="btn-submit" id="qr-submit">Absen</button>
                </div>
                @error('kode_qr')
                    <p style="font-size:12px;color:#dc2626;margin-top:6px">{{ $message }}</p>
                @enderror
            </form>

            <div class="hint-box">
                <p class="hint-title">Petunjuk</p>
                <ul class="hint-list">
                    <li>Arahkan kamera ke QR Code yang ditampilkan guru di proyektor</li>
                    <li>Absensi per mata pelajaran — scan ulang untuk setiap mapel baru</li>
                    <li>QR Code punya batas waktu; scan sebelum kadaluarsa agar tidak telat</li>
                    <li>Jika kamera tidak muncul, gunakan input kode manual di atas</li>
                </ul>
            </div>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jsQR/1.4.0/jsQR.min.js"></script>
<script>
(function () {
    var video       = document.getElementById('qr-video');
    var placeholder = document.getElementById('qr-placeholder');
    var scanLine    = document.getElementById('scan-line');
    var statusEl    = document.getElementById('qr-status');
    var qrInput     = document.getElementById('qr-input');
    var qrForm      = document.getElementById('qr-form');
    var submitBtn   = document.getElementById('qr-submit');

    if (!video || !qrForm) return;

    var canvas   = document.createElement('canvas');
    var ctx      = canvas.getContext('2d');
    var scanning  = true;
    var stream    = null;
    var submitted = false;

    function setStatus(msg, type) {
        statusEl.textContent = msg;
        statusEl.className   = 'qr-status-text' + (type ? ' ' + type : '');
    }

    async function startCamera() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            placeholder.textContent = 'Browser tidak mendukung akses kamera.';
            setStatus('Gunakan input manual di bawah.', 'error');
            return;
        }
        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: { ideal: 'environment' }, width: { ideal: 1280 } }
            });
            video.srcObject = stream;
            await video.play();
            placeholder.style.display = 'none';
            if (scanLine) scanLine.style.display = 'block';
            setStatus('Arahkan kamera ke QR Code…');
            requestAnimationFrame(tick);
        } catch (err) {
            var msg = err.name === 'NotAllowedError'
                ? 'Izin kamera ditolak. Gunakan input manual.'
                : 'Kamera tidak tersedia. Gunakan input manual.';
            placeholder.innerHTML = '<span style="font-size:28px">📷</span>' + msg;
            setStatus(msg, 'error');
        }
    }

    function tick() {
        if (!scanning || submitted) return;
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            canvas.width  = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0);
            var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            var code = typeof jsQR !== 'undefined'
                ? jsQR(imageData.data, imageData.width, imageData.height, { inversionAttempts: 'dontInvert' })
                : null;
            if (code && code.data) {
                scanning  = false;
                submitted = true;
                setStatus('Kode terdeteksi: ' + code.data, 'detected');
                qrInput.value         = code.data;
                submitBtn.disabled    = true;
                submitBtn.textContent = 'Memproses…';
                if (stream) stream.getTracks().forEach(function(t){ t.stop(); });
                setTimeout(function(){ qrForm.submit(); }, 600);
                return;
            }
        }
        requestAnimationFrame(tick);
    }

    window.addEventListener('beforeunload', function() {
        if (stream) stream.getTracks().forEach(function(t){ t.stop(); });
    });

    startCamera();
})();
</script>
</x-app-layout>