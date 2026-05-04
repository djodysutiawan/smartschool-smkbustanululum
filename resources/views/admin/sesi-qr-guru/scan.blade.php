<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;--red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;--amber:#a16207;--amber-bg:#fef9c3;--amber-border:#fde68a;--purple:#7c3aed;--purple-bg:#fdf4ff;--purple-border:#e9d5ff;--radius:10px;--radius-sm:7px}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand)}.breadcrumb .sep{color:var(--border)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}.btn-back:hover{background:var(--surface3);filter:none}
    .btn-primary{background:var(--brand);color:#fff}
    .btn-primary:disabled{opacity:.5;cursor:not-allowed;filter:none}

    /* ── Sesi Info Banner ── */
    .sesi-banner{background:linear-gradient(135deg,#1a1a2e 0%,#1f63db 100%);border-radius:var(--radius);padding:18px 22px;margin-bottom:20px;color:#fff;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px}
    .sesi-banner-left h2{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:800;color:#fff}
    .sesi-banner-left p{font-size:12px;color:rgba(255,255,255,.65);margin-top:3px;font-family:'DM Sans',sans-serif}
    .sesi-info-pills{display:flex;gap:10px;flex-wrap:wrap}
    .sesi-pill{background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);border-radius:7px;padding:6px 12px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:#fff;text-align:center}
    .sesi-pill-label{font-size:9px;opacity:.65;text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:2px}

    /* ── Countdown ── */
    .countdown-wrap{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}
    .countdown-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em}
    .countdown-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--brand)}
    .countdown-val.urgent{color:var(--red)}

    /* ── Card ── */
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card-header{padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px}
    .card-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0}
    .card-body{padding:20px}

    /* ── Form fields ── */
    .field{display:flex;flex-direction:column;gap:6px;margin-bottom:14px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
    .field label .req{color:var(--brand);margin-left:2px}
    .field select,.field input{height:42px;padding:0 14px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;box-sizing:border-box}
    .field select:focus,.field input:focus{border-color:var(--brand-h);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1)}
    .field-hint{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;margin-top:-2px}

    /* ── Alert ── */
    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600}
    .alert-warning{background:var(--amber-bg);border:1px solid var(--amber-border);color:var(--amber)}
    .alert-info{background:var(--brand-50);border:1px solid var(--brand-100);color:var(--brand-700)}

    /* ── Result card ── */
    .result-card{border-radius:var(--radius);padding:20px;text-align:center;display:none}
    .result-card.berhasil{background:var(--green-bg);border:2px solid var(--green-border)}
    .result-card.gagal{background:var(--red-bg);border:2px solid var(--red-border)}
    .result-icon{width:56px;height:56px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px}
    .result-card.berhasil .result-icon{background:#dcfce7}
    .result-card.gagal    .result-icon{background:#fee2e2}
    .result-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:17px;font-weight:800;margin-bottom:6px}
    .result-card.berhasil .result-title{color:var(--green)}
    .result-card.gagal    .result-title{color:var(--red)}
    .result-sub{font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2)}

    /* ── Log rows ── */
    .log-row{display:flex;align-items:center;gap:10px;padding:9px 0;border-bottom:1px solid var(--surface3);font-size:12.5px}
    .log-row:last-child{border-bottom:none}
    .log-badge{display:inline-flex;align-items:center;gap:3px;padding:2px 8px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700}
    .log-badge.ok{background:var(--green-bg);color:var(--green)}
    .log-badge.fail{background:var(--red-bg);color:var(--red)}

    @keyframes spin{to{transform:rotate(360deg)}}
    @media(max-width:640px){.page{padding:16px}.sesi-banner{flex-direction:column}}
</style>

<div class="page">

    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.sesi-qr-guru.index') }}">Sesi QR Guru</a>
        <span class="sep">›</span>
        <span class="current">Scan Absensi</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Scan QR Absensi Guru</h1>
            <p class="page-sub">Pilih guru dan proses scan QR untuk mencatat absensi</p>
        </div>
        <a href="{{ route('admin.sesi-qr-guru.index') }}" class="btn btn-back">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    {{-- Sesi Banner --}}
    <div class="sesi-banner">
        <div class="sesi-banner-left">
            <h2>Sesi QR Aktif — #{{ $sesiQrGuru->id }}</h2>
            <p>{{ \Carbon\Carbon::parse($sesiQrGuru->tanggal)->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="sesi-info-pills">
            <div class="sesi-pill">
                <span class="sesi-pill-label">Berlaku Mulai</span>
                {{ \Carbon\Carbon::parse($sesiQrGuru->berlaku_mulai)->format('H:i') }} WIB
            </div>
            <div class="sesi-pill">
                <span class="sesi-pill-label">Kadaluarsa</span>
                {{ \Carbon\Carbon::parse($sesiQrGuru->kadaluarsa_pada)->format('H:i') }} WIB
            </div>
            @if($sesiQrGuru->radius_meter)
            <div class="sesi-pill">
                <span class="sesi-pill-label">Radius</span>
                {{ $sesiQrGuru->radius_meter }}m
            </div>
            @endif
        </div>
    </div>

    {{-- Countdown Timer --}}
    <div class="countdown-wrap">
        <div>
            <p class="countdown-label">Waktu Tersisa</p>
            <p class="countdown-val" id="countdown">--:--</p>
        </div>
        <div style="text-align:right">
            <p style="font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text3)">Sesi otomatis berakhir pada</p>
            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text)">
                {{ \Carbon\Carbon::parse($sesiQrGuru->kadaluarsa_pada)->format('H:i:s') }} WIB
            </p>
        </div>
    </div>

    {{-- Alert jika GPS dibutuhkan --}}
    @if($sesiQrGuru->radius_meter)
    <div class="alert alert-warning">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        Sesi ini membatasi radius {{ $sesiQrGuru->radius_meter }}m dari sekolah. GPS akan diminta saat proses scan.
    </div>
    @endif

    <div class="alert alert-info">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Pilih nama guru yang ingin dicatat absensinya. Setiap guru hanya dapat scan satu kali per sesi.
    </div>

    {{-- Form Scan --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">
                <span class="card-dot" style="background:var(--brand)"></span>
                Form Absensi Guru
            </span>
        </div>
        <div class="card-body">

            {{-- Result area (ditampilkan setelah proses) --}}
            <div class="result-card berhasil" id="resultBerhasil">
                <div class="result-icon">
                    <svg width="28" height="28" fill="none" stroke="#15803d" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <p class="result-title">Absensi Berhasil Dicatat!</p>
                <p class="result-sub" id="resultMsg">—</p>
                <button type="button" onclick="resetForm()"
                    style="margin-top:14px;padding:9px 20px;background:var(--green);color:#fff;border:none;border-radius:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer">
                    Scan Berikutnya
                </button>
            </div>

            <div class="result-card gagal" id="resultGagal">
                <div class="result-icon">
                    <svg width="28" height="28" fill="none" stroke="#dc2626" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                </div>
                <p class="result-title">Scan Gagal</p>
                <p class="result-sub" id="resultErrMsg">—</p>
                <button type="button" onclick="resetForm()"
                    style="margin-top:14px;padding:9px 20px;background:var(--red);color:#fff;border:none;border-radius:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer">
                    Coba Lagi
                </button>
            </div>

            {{-- Form fields --}}
            <div id="scanForm">
                <div class="field">
                    <label for="guruSelect">Nama Guru <span class="req">*</span></label>
                    <select id="guruSelect">
                        <option value="">— Pilih Guru —</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id }}">{{ $g->nama_lengkap }}{{ $g->nip ? ' — '.$g->nip : '' }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="gpsInfo" style="display:none" class="alert alert-info" style="margin-bottom:14px">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span id="gpsText">Mendapatkan lokasi GPS…</span>
                </div>

                <button type="button" id="btnScan" onclick="prosesAbsensi()" class="btn btn-primary"
                    style="width:100%;justify-content:center;height:44px;font-size:14px">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><line x1="14" y1="14" x2="21" y2="14"/><line x1="14" y1="18" x2="21" y2="18"/><line x1="14" y1="21" x2="14" y2="14"/></svg>
                    Proses Absensi
                </button>
            </div>
        </div>
    </div>

    {{-- Log sesi berjalan --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">
                <span class="card-dot" style="background:#15803d"></span>
                Log Absensi Sesi Ini
            </span>
            <span id="logCount" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:var(--text3)">0 absensi</span>
        </div>
        <div class="card-body" style="padding:0 0 4px">
            <div id="logList" style="padding:0 18px">
                <p style="text-align:center;padding:24px;color:var(--text3);font-size:13px;font-family:'DM Sans',sans-serif">
                    Belum ada absensi dicatat pada sesi ini
                </p>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    /* ── Config ── */
    const KODE_QR       = @json($sesiQrGuru->kode_qr);
    const KADALUARSA    = new Date(@json(\Carbon\Carbon::parse($sesiQrGuru->kadaluarsa_pada)->toIso8601String()));
    const RADIUS_METER  = @json($sesiQrGuru->radius_meter);
    const PROSES_URL    = "{{ route('admin.sesi-qr-guru.proses-qr') }}";
    const CSRF          = "{{ csrf_token() }}";

    /* ── Countdown ── */
    const countdownEl = document.getElementById('countdown');
    function updateCountdown() {
        const diff = KADALUARSA - Date.now();
        if (diff <= 0) {
            countdownEl.textContent = 'Sesi Berakhir';
            countdownEl.classList.add('urgent');
            document.getElementById('btnScan').disabled = true;
            return;
        }
        const h = Math.floor(diff / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);
        countdownEl.textContent = (h ? h + ':' : '') + String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
        if (diff < 300000) countdownEl.classList.add('urgent'); // < 5 menit
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);

    /* ── State log ── */
    const log = [];
    function addLog(namaGuru, berhasil, pesan) {
        const now = new Date().toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit',second:'2-digit'});
        log.unshift({ namaGuru, berhasil, pesan, waktu: now });

        const logList = document.getElementById('logList');
        document.getElementById('logCount').textContent = log.length + ' absensi';
        logList.innerHTML = log.map(l => `
            <div class="log-row">
                <span class="log-badge ${l.berhasil ? 'ok' : 'fail'}">${l.berhasil ? '✓' : '✗'}</span>
                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;flex:1">${l.namaGuru}</span>
                <span style="color:var(--text3);font-size:11.5px">${l.waktu}</span>
            </div>
        `).join('');
    }

    /* ── GPS helper ── */
    function getPosition() {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) return resolve({ lat: null, lng: null });
            navigator.geolocation.getCurrentPosition(
                p => resolve({ lat: p.coords.latitude, lng: p.coords.longitude }),
                _  => resolve({ lat: null, lng: null }),
                { timeout: 8000 }
            );
        });
    }

    /* ── Proses absensi ── */
    async function prosesAbsensi() {
        const select = document.getElementById('guruSelect');
        const guruId = select.value;

        if (!guruId) {
            Swal.fire({ icon:'warning', title:'Pilih Guru', text:'Pilih nama guru terlebih dahulu.', confirmButtonColor:'#1f63db' });
            return;
        }

        const btn = document.getElementById('btnScan');
        btn.disabled = true;
        btn.innerHTML = `<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Memproses…`;

        /* GPS jika radius aktif */
        let lat = null, lng = null;
        if (RADIUS_METER) {
            document.getElementById('gpsInfo').style.display = 'flex';
            document.getElementById('gpsText').textContent = 'Mendapatkan lokasi GPS…';
            const pos = await getPosition();
            lat = pos.lat; lng = pos.lng;
            document.getElementById('gpsText').textContent = lat
                ? `Lokasi ditemukan: ${lat.toFixed(5)}, ${lng.toFixed(5)}`
                : 'GPS tidak tersedia — scan tetap diproses tanpa validasi lokasi.';
        }

        try {
            const resp = await fetch(PROSES_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    kode_qr:  KODE_QR,
                    guru_id:  guruId,
                    latitude: lat,
                    longitude: lng,
                }),
            });
            const data = await resp.json();

            document.getElementById('scanForm').style.display = 'none';
            const namaGuru = select.options[select.selectedIndex].text.split(' — ')[0];

            if (data.berhasil) {
                document.getElementById('resultBerhasil').style.display = 'block';
                document.getElementById('resultMsg').textContent = `${namaGuru} · ${data.waktu_scan}`;
                addLog(namaGuru, true, data.pesan);
            } else {
                document.getElementById('resultGagal').style.display = 'block';
                document.getElementById('resultErrMsg').textContent = data.pesan || 'Terjadi kesalahan.';
                addLog(namaGuru, false, data.pesan);
            }
        } catch (err) {
            Swal.fire({ icon:'error', title:'Error Jaringan', text:'Gagal menghubungi server. Periksa koneksi internet.', confirmButtonColor:'#1f63db' });
            btn.disabled = false;
            btn.innerHTML = `<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg> Proses Absensi`;
        }
    }

    /* ── Reset form untuk scan berikutnya ── */
    function resetForm() {
        document.getElementById('resultBerhasil').style.display = 'none';
        document.getElementById('resultGagal').style.display    = 'none';
        document.getElementById('scanForm').style.display       = 'block';
        document.getElementById('guruSelect').value             = '';
        document.getElementById('gpsInfo').style.display        = 'none';

        const btn = document.getElementById('btnScan');
        btn.disabled = false;
        btn.innerHTML = `<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><line x1="14" y1="14" x2="21" y2="14"/><line x1="14" y1="18" x2="21" y2="18"/><line x1="14" y1="21" x2="14" y2="14"/></svg> Proses Absensi`;
    }

    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text: @json(session('error')), confirmButtonColor:'#1f63db' });
    @endif
</script>
</x-app-layout>