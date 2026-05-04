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

    /* Info bar */
    .info-bar{background:#eff6ff;border:1px solid #bfdbfe;border-radius:var(--radius-sm);padding:11px 16px;display:flex;align-items:center;gap:8px;margin-bottom:20px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:#1d4ed8}
    .info-bar svg{flex-shrink:0}

    /* Grid jadwal */
    .jadwal-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:14px}

    /* Card pelajaran */
    .mapel-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .mapel-card-top{padding:14px 16px;border-bottom:1px solid var(--border);display:flex;align-items:flex-start;gap:10px}
    .mapel-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;margin-top:5px}
    .mapel-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text);margin:0 0 4px}
    .mapel-meta{font-size:12px;color:var(--text3);display:flex;gap:10px;flex-wrap:wrap;align-items:center}
    .mapel-meta svg{vertical-align:middle}
    .mapel-card-body{padding:20px 16px;display:flex;flex-direction:column;align-items:center;gap:12px}

    /* Badge */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-aktif{background:#dcfce7;color:#15803d}
    .badge-akan{background:#f1f5f9;color:#64748b}
    .badge-sudah{background:#dcfce7;color:#15803d}
    .badge-telat{background:#fef9c3;color:#a16207}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0;animation:pulse 1.5s infinite}
    @keyframes pulse{0%,100%{opacity:1}50%{opacity:.35}}

    /* QR container */
    .qr-box{width:130px;height:130px;background:#fff;border:1px solid var(--border);border-radius:10px;display:flex;align-items:center;justify-content:center;overflow:hidden;padding:6px}
    .qr-empty{width:130px;height:130px;background:var(--surface2);border:1px solid var(--border);border-radius:10px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px}
    .qr-done {width:130px;height:130px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px}

    .countdown{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;color:var(--text3);display:flex;align-items:center;gap:5px}
    .live-dot{width:6px;height:6px;border-radius:50%;background:#22c55e;animation:pulse 1.5s infinite}

    /* Tombol */
    .btn-primary{width:100%;padding:10px 0;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;text-align:center;display:block;text-decoration:none}
    .btn-primary:hover{background:var(--brand-700)}
    .btn-disabled{width:100%;padding:10px 0;background:var(--surface2);color:var(--text3);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:not-allowed;text-align:center;display:block}

    /* Empty state */
    .empty-state{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    @media(max-width:600px){.page{padding:16px}.jadwal-grid{grid-template-columns:1fr}}
</style>

<div class="page">
    <h1 class="page-title">Absensi Pelajaran</h1>
    <p class="page-sub">Scan QR tiap pelajaran ke alat IoT</p>

    <div class="tab-nav">
        <a href="{{ route('siswa.absensi.scan') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.scan') ? 'active' : '' }}">
            Scan QR Hadir
        </a>
        <a href="{{ route('siswa.absensi.jadwal') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.jadwal') ? 'active' : '' }}">
            QR Per Pelajaran
        </a>
        <a href="{{ route('siswa.absensi.riwayat') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.riwayat') ? 'active' : '' }}">
            Riwayat Kehadiran
        </a>
    </div>

    <div class="info-bar">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        {{ now()->locale('id')->translatedFormat('l, d F Y') }}
        &nbsp;·&nbsp; Kelas {{ $siswa->kelas->nama_kelas ?? '-' }}
        &nbsp;·&nbsp; {{ $jadwalList->count() }} pelajaran hari ini
    </div>

    @if($jadwalList->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <p class="empty-title">Tidak ada jadwal hari ini</p>
            <p class="empty-sub">Tidak ada mata pelajaran terjadwal untuk kelas Anda hari ini</p>
        </div>
    @else
        <div class="jadwal-grid">
            @foreach($jadwalList as $jadwal)
            @php
                $sesi        = $jadwal->sesiQrAktif;
                $absenRecord = $jadwal->sudahAbsen;
                $sudahAbsen  = $absenRecord !== null;
                $warna       = match($loop->index % 5) {
                    0 => '#3582f0', 1 => '#8b5cf6', 2 => '#22c55e',
                    3 => '#f59e0b', default => '#ef4444'
                };
            @endphp
            <div class="mapel-card">
                {{-- Header kartu --}}
                <div class="mapel-card-top">
                    <div class="mapel-dot" style="background:{{ $warna }}"></div>
                    <div style="flex:1;min-width:0">
                        <p class="mapel-name">{{ $jadwal->mataPelajaran->nama_mapel ?? 'Mata Pelajaran' }}</p>
                        <div class="mapel-meta">
                            <span>
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-right:2px">
                                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                                – {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                            </span>
                            @if($jadwal->guru)
                            <span>{{ $jadwal->guru->nama_lengkap }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Status badge --}}
                    @if($sudahAbsen)
                        <span class="badge {{ $absenRecord->status === 'telat' ? 'badge-telat' : 'badge-sudah' }}">
                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            {{ $absenRecord->status === 'telat' ? 'Telat' : 'Hadir' }}
                        </span>
                    @elseif($sesi)
                        <span class="badge badge-aktif">
                            <span class="badge-dot" style="background:#15803d"></span>
                            Aktif
                        </span>
                    @else
                        <span class="badge badge-akan">Belum tersedia</span>
                    @endif
                </div>

                {{-- Body kartu --}}
                <div class="mapel-card-body">

                    {{-- State 1: Sudah absen --}}
                    @if($sudahAbsen)
                        <div class="qr-done">
                            <svg width="32" height="32" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:#15803d">
                                {{ ucfirst($absenRecord->status) }}
                            </span>
                            @if($absenRecord->jam_masuk)
                            <span style="font-size:11.5px;color:#16a34a">
                                {{ \Carbon\Carbon::parse($absenRecord->jam_masuk)->format('H:i') }}
                            </span>
                            @endif
                        </div>
                        <span class="btn-disabled">Sudah tercatat</span>

                    {{-- State 2: Sesi QR aktif → tampilkan QR --}}
                    @elseif($sesi)
                        <div class="qr-box" id="qr-{{ $sesi->id }}"></div>

                        <div class="countdown" id="countdown-{{ $sesi->id }}"
                             data-expire="{{ $sesi->kadaluarsa_pada->toISOString() }}">
                            <span class="live-dot"></span>
                            Kadaluarsa dalam <strong id="timer-{{ $sesi->id }}" style="color:var(--text);margin:0 3px">--:--</strong>
                        </div>

                        <p style="font-size:11.5px;color:var(--text3);text-align:center;margin:0">
                            Arahkan QR ini ke alat IoT di kelas
                        </p>

                        <button class="btn-primary"
                                onclick="perbesar('{{ $sesi->id }}','{{ $sesi->kode_qr }}','{{ $jadwal->mataPelajaran->nama_mapel ?? '' }}')">
                            Tampilkan Layar Penuh
                        </button>

                    {{-- State 3: Belum ada sesi --}}
                    @else
                        <div class="qr-empty">
                            <svg width="28" height="28" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                                <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                            </svg>
                            <span style="font-size:11.5px;color:var(--text3);text-align:center;padding:0 8px">
                                QR belum dibuat guru
                            </span>
                        </div>
                        <span class="btn-disabled">Belum tersedia</span>
                    @endif

                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Modal layar penuh QR --}}
<div id="qr-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.75);z-index:9999;align-items:center;justify-content:center;flex-direction:column;gap:20px">
    <div style="background:#fff;border-radius:16px;padding:32px;text-align:center;max-width:340px;width:90%">
        <p id="modal-mapel" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:#0f172a;margin:0 0 4px"></p>
        <p style="font-size:12px;color:#94a3b8;margin:0 0 20px">Arahkan ke alat IoT absensi</p>
        <div id="modal-qr" style="display:flex;justify-content:center;margin-bottom:16px"></div>
        <p id="modal-timer" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:#1f63db;margin:0 0 20px"></p>
        <button onclick="tutupModal()"
                style="width:100%;padding:11px 0;background:#0f172a;color:#fff;border:none;border-radius:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer">
            Tutup
        </button>
    </div>
</div>

{{-- Library QR --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
(function() {
    // ── Generate QR tiap sesi aktif ────────────────────────────────────────
    var sesiData = {{ Js::from(
        $jadwalList
            ->filter(function($j) { return $j->sesiQrAktif !== null && $j->sudahAbsen === null; })
            ->map(function($j) {
                return [
                    'id'     => $j->sesiQrAktif->id,
                    'kode'   => $j->sesiQrAktif->kode_qr,
                    'expire' => $j->sesiQrAktif->kadaluarsa_pada->toISOString(),
                ];
            })
            ->values()
    ) }};

    sesiData.forEach(function(s) {
        var el = document.getElementById('qr-' + s.id);
        if (el && typeof QRCode !== 'undefined') {
            new QRCode(el, {
                text           : 'SESI-' + s.kode,
                width          : 118,
                height         : 118,
                colorDark      : '#0f172a',
                colorLight     : '#ffffff',
                correctLevel   : QRCode.CorrectLevel.H,
            });
        }
    });

    // ── Countdown timer ────────────────────────────────────────────────────
    function formatSisa(ms) {
        if (ms <= 0) return '00:00';
        var total = Math.floor(ms / 1000);
        var m = Math.floor(total / 60);
        var s = total % 60;
        return String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
    }

    function tick() {
        var now = Date.now();
        sesiData.forEach(function(s) {
            var timerEl = document.getElementById('timer-' + s.id);
            if (!timerEl) return;
            var sisa = new Date(s.expire).getTime() - now;
            timerEl.textContent = formatSisa(sisa);
            if (sisa <= 0) {
                timerEl.style.color = '#dc2626';
                timerEl.closest('.countdown').querySelector('.live-dot').style.background = '#dc2626';
            } else if (sisa < 60000) {
                timerEl.style.color = '#dc2626';
            }
        });
        // Update modal timer juga
        var mt = document.getElementById('modal-timer');
        if (mt && window._modalExpire) {
            var sisa = new Date(window._modalExpire).getTime() - now;
            mt.textContent = 'Kadaluarsa dalam ' + formatSisa(sisa);
            if (sisa <= 0) mt.style.color = '#dc2626';
        }
    }
    setInterval(tick, 1000);
    tick();

    // ── Modal layar penuh ──────────────────────────────────────────────────
    window.perbesar = function(sesiId, kode, namaMapel) {
        var modal    = document.getElementById('qr-modal');
        var modalQr  = document.getElementById('modal-qr');
        var modalMapel = document.getElementById('modal-mapel');

        modalQr.innerHTML = '';
        modalMapel.textContent = namaMapel;

        var s = sesiData.find(function(x){ return String(x.id) === String(sesiId); });
        if (s) window._modalExpire = s.expire;

        if (typeof QRCode !== 'undefined') {
            new QRCode(modalQr, {
                text         : 'SESI-' + kode,
                width        : 220,
                height       : 220,
                colorDark    : '#0f172a',
                colorLight   : '#ffffff',
                correctLevel : QRCode.CorrectLevel.H,
            });
        }

        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };

    window.tutupModal = function() {
        document.getElementById('qr-modal').style.display = 'none';
        document.body.style.overflow = '';
        window._modalExpire = null;
    };

    // Tutup modal klik luar
    document.getElementById('qr-modal').addEventListener('click', function(e) {
        if (e.target === this) window.tutupModal();
    });
})();
</script>
</x-app-layout>