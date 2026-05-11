<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@400;500&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green-700:#15803d;--green-600:#16a34a;--green-100:#dcfce7;--green-50:#f0fdf4;
        --red-600:#dc2626;--red-100:#fee2e2;--red-50:#fff0f0;
        --amber-700:#a16207;--amber-100:#fef9c3;
        --radius:10px;--radius-sm:7px;--radius-lg:14px;
    }

    /* ── Layout ── */
    .page{padding:28px 28px 48px;max-width:2000px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    .btn{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s,box-shadow .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.92)}
    .btn-primary{background:var(--brand-600);color:#fff;box-shadow:0 1px 4px rgba(31,99,219,.18)}
    .btn-success{background:var(--green-600);color:#fff;box-shadow:0 1px 4px rgba(22,163,74,.18)}
    .btn-danger{background:var(--red-600);color:#fff;box-shadow:0 1px 4px rgba(220,38,38,.15)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-amber{background:#f59e0b;color:#fff;box-shadow:0 1px 4px rgba(245,158,11,.2)}
    .btn-lg{padding:12px 24px;font-size:14px;border-radius:var(--radius)}
    .btn-sm{padding:5px 12px;font-size:12px;border-radius:6px}
    .btn:disabled{opacity:.55;cursor:not-allowed;filter:none}

    /* ── Grid layout utama ── */
    .main-grid{display:grid;grid-template-columns:1fr 340px;gap:18px;align-items:start}

    /* ── Cards ── */
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-lg);overflow:hidden;margin-bottom:16px}
    .card:last-child{margin-bottom:0}
    .card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .card-body{padding:22px}

    /* ── Status panel besar ── */
    .status-panel{border-radius:var(--radius-lg);padding:28px 24px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:12px;position:relative;overflow:hidden;transition:all .3s}
    .status-panel.aktif{background:linear-gradient(135deg,#f0fdf4 0%,#dcfce7 100%);border:1.5px solid #86efac}
    .status-panel.nonaktif{background:linear-gradient(135deg,#f8fafc 0%,#f1f5f9 100%);border:1.5px solid var(--border2)}

    .status-orb{width:80px;height:80px;border-radius:50%;display:flex;align-items:center;justify-content:center;position:relative;flex-shrink:0}
    .status-orb.aktif{background:var(--green-600);box-shadow:0 0 0 12px rgba(22,163,74,.12),0 0 0 24px rgba(22,163,74,.05)}
    .status-orb.nonaktif{background:var(--surface3);box-shadow:0 0 0 12px rgba(148,163,184,.08)}
    .orb-pulse{position:absolute;inset:0;border-radius:50%;animation:pulse-ring 2s ease-out infinite}
    .orb-pulse::before,.orb-pulse::after{content:'';position:absolute;inset:-8px;border-radius:50%;border:2px solid rgba(22,163,74,.3);animation:expand-ring 2s ease-out infinite}
    .orb-pulse::after{animation-delay:.7s}
    @keyframes pulse-ring{0%,100%{opacity:1}50%{opacity:.6}}
    @keyframes expand-ring{0%{transform:scale(1);opacity:.6}100%{transform:scale(1.5);opacity:0}}

    .status-label-big{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;letter-spacing:-.3px}
    .status-label-big.aktif{color:var(--green-700)}
    .status-label-big.nonaktif{color:var(--text3)}
    .status-desc{font-size:13px;color:var(--text2);max-width:280px}

    .timer-display{font-family:'DM Mono',monospace;font-size:36px;font-weight:500;color:var(--green-700);letter-spacing:2px;background:rgba(22,163,74,.07);border-radius:var(--radius-sm);padding:8px 22px;border:1px solid rgba(22,163,74,.18);min-width:140px;text-align:center}
    .timer-display.warning{color:var(--amber-700);background:var(--amber-100);border-color:#fde68a}
    .timer-display.expired{color:var(--red-600);background:var(--red-50);border-color:#fca5a5}
    .timer-label{font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.06em;text-transform:uppercase;margin-top:-6px}

    /* ── Info rows ── */
    .info-row{display:flex;gap:6px;align-items:center;font-size:12.5px;color:var(--text2)}
    .info-row svg{flex-shrink:0;color:var(--text3)}
    .info-row strong{color:var(--text);font-weight:700}

    /* ── QR Area ── */
    .qr-wrap{display:flex;flex-direction:column;align-items:center;gap:14px}
    .qr-canvas-wrap{position:relative;width:200px;height:200px;border-radius:var(--radius);overflow:hidden;background:#fff;border:3px solid var(--border);box-shadow:0 4px 16px rgba(0,0,0,.08)}
    .qr-canvas-wrap canvas{display:block}
    .qr-overlay{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;background:rgba(248,250,252,.95);gap:8px}
    .qr-placeholder-icon{color:var(--text3)}
    .qr-placeholder-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-align:center;padding:0 12px}
    .qr-uuid{font-family:'DM Mono',monospace;font-size:10px;color:var(--text3);text-align:center;max-width:200px;word-break:break-all;line-height:1.5;padding:4px 8px;background:var(--surface2);border-radius:5px;border:1px solid var(--border)}

    /* ── Action buttons bar ── */
    .action-row{display:flex;gap:8px;flex-wrap:wrap;justify-content:center}

    /* ── Scan list ── */
    .scan-list{display:flex;flex-direction:column;gap:1px}
    .scan-item{display:flex;align-items:center;gap:12px;padding:11px 20px;border-bottom:1px solid #f1f5f9;transition:background .1s}
    .scan-item:last-child{border-bottom:none}
    .scan-item:hover{background:var(--surface2)}
    .scan-avatar{width:34px;height:34px;border-radius:50%;background:var(--brand-50);border:2px solid var(--brand-100);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;color:var(--brand-600);flex-shrink:0}
    .scan-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .scan-nip{font-size:11.5px;color:var(--text3)}
    .scan-time{font-family:'DM Mono',monospace;font-size:12px;color:var(--text3);margin-left:auto;white-space:nowrap}

    .empty-scan{padding:40px 20px;text-align:center}
    .empty-scan-icon{width:48px;height:48px;background:var(--surface2);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 10px}
    .empty-scan p{font-size:13px;color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600}

    /* ── Badge ── */
    .badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-green{background:var(--green-100);color:var(--green-700)}
    .badge-gray{background:var(--surface3);color:var(--text3)}
    .badge-dot{width:6px;height:6px;border-radius:50%}
    .badge-dot.green{background:var(--green-600)}
    .badge-dot.gray{background:var(--text3)}
    .badge-dot.pulse-dot{animation:blink 1.2s ease-in-out infinite}
    @keyframes blink{0%,100%{opacity:1}50%{opacity:.3}}

    /* ── Alert / flash ── */
    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);font-size:13px;margin-bottom:16px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600}
    .alert-success{background:var(--green-50);border:1px solid #86efac;color:var(--green-700)}
    .alert-warning{background:var(--amber-100);border:1px solid #fde68a;color:var(--amber-700)}
    .alert-error{background:var(--red-50);border:1px solid #fca5a5;color:var(--red-600)}

    /* ── Separator ── */
    .divider{height:1px;background:var(--border);margin:4px 0}

    /* ── Polling indicator ── */
    .poll-dot{width:7px;height:7px;border-radius:50%;background:#10b981;display:inline-block;margin-right:4px;animation:blink 2s ease-in-out infinite}

    @media(max-width:860px){
        .main-grid{grid-template-columns:1fr}
        .page{padding:16px}
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Sesi QR Guru</h1>
            <p class="page-sub">Kelola QR code absensi guru — buka, tutup, dan refresh kode</p>
        </div>
        <a href="{{ route('piket.absensi-guru.dashboard') }}" class="btn btn-secondary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('warning'))
    <div class="alert alert-warning">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        {{ session('warning') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="main-grid">

        {{-- ═══ KOLOM KIRI — Status + QR ═══ --}}
        <div>
            {{-- Panel status utama --}}
            <div class="card">
                <div class="card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="5" height="5"/><rect x="16" y="3" width="5" height="5"/><rect x="3" y="16" width="5" height="5"/><path d="M21 16h-3v3"/><path d="M21 21h-3"/><path d="M16 21v-3"/></svg>
                    <span class="card-title">Status Sesi QR</span>
                    @if($sesiAktif)
                        <span class="badge badge-green" style="margin-left:auto">
                            <span class="badge-dot green pulse-dot"></span>Aktif
                        </span>
                    @else
                        <span class="badge badge-gray" style="margin-left:auto">
                            <span class="badge-dot gray"></span>Tidak Aktif
                        </span>
                    @endif
                </div>
                <div class="card-body">

                    @if($sesiAktif)
                    {{-- ── SESI SEDANG AKTIF ── --}}
                    <div class="status-panel aktif" style="margin-bottom:22px">
                        <div class="status-orb aktif">
                            <div class="orb-pulse"></div>
                            <svg width="32" height="32" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="5" height="5"/><rect x="16" y="3" width="5" height="5"/><rect x="3" y="16" width="5" height="5"/><path d="M21 16h-3v3"/><path d="M21 21h-3"/><path d="M16 21v-3"/></svg>
                        </div>
                        <p class="status-label-big aktif">Sesi Sedang Aktif</p>
                        <p class="status-desc">Guru dapat melakukan scan QR untuk mencatat kehadiran</p>

                        {{-- Timer countdown --}}
                        <div id="timerDisplay" class="timer-display">--:--</div>
                        <p class="timer-label">tersisa sebelum kadaluarsa</p>

                        {{-- Info sesi --}}
                        <div style="display:flex;flex-direction:column;gap:6px;width:100%;max-width:320px;margin-top:4px">
                            <div class="info-row">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Dibuka oleh <strong>{{ $sesiAktif->pembuat?->name ?? '—' }}</strong>
                            </div>
                            <div class="info-row">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Dibuka pukul <strong>{{ $sesiAktif->berlaku_mulai?->format('H:i') ?? '—' }}</strong>
                            </div>
                            <div class="info-row">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>
                                Berakhir pukul <strong>{{ $sesiAktif->kadaluarsa_pada?->format('H:i') ?? '—' }}</strong>
                            </div>
                        </div>
                    </div>

                    {{-- QR Code --}}
                    <div class="qr-wrap" style="margin-bottom:22px">
                        <div class="qr-canvas-wrap" id="qrCanvasWrap">
                            <canvas id="qrCanvas" width="200" height="200"></canvas>
                        </div>
                        <p style="font-size:12px;color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;text-align:center">
                            QR ini diperbarui otomatis saat di-refresh.<br>
                            <span style="color:var(--brand-600)">Tunjukkan ke guru untuk di-scan.</span>
                        </p>
                        <div class="qr-uuid" id="qrUuidDisplay">{{ $sesiAktif->kode_qr }}</div>
                    </div>

                    {{-- Hidden input untuk kode_qr JS --}}
                    <input type="hidden" id="kodeQrCurrent" value="{{ $sesiAktif->kode_qr }}">
                    <input type="hidden" id="berakhirPada" value="{{ $sesiAktif->kadaluarsa_pada?->timestamp }}">

                    {{-- Action buttons --}}
                    <div class="action-row">
                        {{-- Refresh QR --}}
                        <form action="{{ route('piket.sesi-qr-guru.refresh') }}" method="POST" id="formRefresh">
                            @csrf
                            <button type="submit" class="btn btn-amber" onclick="return confirmAction(this,'Refresh Kode QR?','Kode QR lama akan langsung tidak valid. Guru yang sedang mengarahkan kamera harus scan ulang.')">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                                Refresh QR
                            </button>
                        </form>
                        {{-- Tutup sesi --}}
                        <form action="{{ route('piket.sesi-qr-guru.tutup') }}" method="POST" id="formTutup">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirmAction(this,'Tutup Sesi QR?','Guru tidak akan bisa scan QR setelah sesi ditutup.')">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                Tutup Sesi
                            </button>
                        </form>
                    </div>

                    @else
                    {{-- ── TIDAK ADA SESI AKTIF ── --}}
                    <div class="status-panel nonaktif" style="margin-bottom:22px">
                        <div class="status-orb nonaktif">
                            <svg width="32" height="32" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="5" height="5"/><rect x="16" y="3" width="5" height="5"/><rect x="3" y="16" width="5" height="5"/><path d="M21 16h-3v3"/><path d="M21 21h-3"/><path d="M16 21v-3"/></svg>
                        </div>
                        <p class="status-label-big nonaktif">Tidak Ada Sesi Aktif</p>
                        <p class="status-desc">Buka sesi QR agar guru dapat melakukan scan kehadiran</p>
                    </div>

                    {{-- QR placeholder --}}
                    <div class="qr-wrap" style="margin-bottom:22px">
                        <div class="qr-canvas-wrap">
                            <div class="qr-overlay">
                                <svg class="qr-placeholder-icon" width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="5" height="5"/><rect x="16" y="3" width="5" height="5"/><rect x="3" y="16" width="5" height="5"/><path d="M21 16h-3v3"/><path d="M21 21h-3"/><path d="M16 21v-3"/></svg>
                                <p class="qr-placeholder-text">QR tersedia<br>saat sesi aktif</p>
                            </div>
                        </div>
                    </div>

                    {{-- Buka sesi --}}
                    <div class="action-row">
                        <form action="{{ route('piket.sesi-qr-guru.buka') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                                Buka Sesi QR Sekarang
                            </button>
                        </form>
                    </div>
                    @endif

                </div>
            </div>

            {{-- Info polling --}}
            @if($sesiAktif)
            <div style="display:flex;align-items:center;gap:6px;padding:8px 4px;font-size:12px;color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600">
                <span class="poll-dot"></span>
                Status diperbarui otomatis setiap 30 detik
            </div>
            @endif
        </div>

        {{-- ═══ KOLOM KANAN — Guru sudah scan hari ini ═══ --}}
        <div>
            <div class="card">
                <div class="card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <span class="card-title">Sudah Scan Hari Ini</span>
                    <span style="margin-left:auto;background:var(--surface3);color:var(--text3);font-size:11px;padding:2px 8px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700" id="scanCount">{{ $sudahScanHariIni->count() }}</span>
                </div>

                @if($sudahScanHariIni->count())
                <div class="scan-list" id="scanList">
                    @foreach($sudahScanHariIni as $absen)
                    <div class="scan-item">
                        <div class="scan-avatar">
                            {{ strtoupper(substr($absen->guru?->nama_lengkap ?? '?', 0, 1)) }}
                        </div>
                        <div style="flex:1;min-width:0">
                            <p class="scan-name">{{ $absen->guru?->nama_lengkap ?? '—' }}</p>
                            <p class="scan-nip">NIP: {{ $absen->guru?->nip ?? '—' }}</p>
                        </div>
                        <div style="text-align:right">
                            <p class="scan-time">{{ $absen->updated_at?->format('H:i') }}</p>
                            @php
                                $statusColor = match($absen->status ?? '') {
                                    'hadir'  => ['bg'=>'#dcfce7','color'=>'#15803d'],
                                    'telat'  => ['bg'=>'#fef9c3','color'=>'#a16207'],
                                    'izin'   => ['bg'=>'#dbeafe','color'=>'#1d4ed8'],
                                    'sakit'  => ['bg'=>'#f3e8ff','color'=>'#7c3aed'],
                                    default  => ['bg'=>'#f1f5f9','color'=>'#64748b'],
                                };
                            @endphp
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;padding:2px 7px;border-radius:99px;background:{{ $statusColor['bg'] }};color:{{ $statusColor['color'] }}">
                                {{ ucfirst($absen->status ?? '—') }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-scan" id="scanListEmpty">
                    <div class="empty-scan-icon">
                        <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    </div>
                    <p>Belum ada guru yang scan hari ini</p>
                </div>
                @endif

                {{-- Footer info --}}
                <div style="padding:10px 20px;border-top:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between">
                    <span style="font-size:11.5px;color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600">
                        Menampilkan 10 scan terbaru via QR
                    </span>
                    <a href="{{ route('piket.absensi-guru.riwayat') }}" style="font-size:11.5px;font-weight:700;color:var(--brand-600);font-family:'Plus Jakarta Sans',sans-serif;text-decoration:none">
                        Lihat semua →
                    </a>
                </div>
            </div>

            {{-- Shortcut ke scan QR manual --}}
            <div class="card">
                <div class="card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="5" height="5"/><rect x="16" y="3" width="5" height="5"/><rect x="3" y="16" width="5" height="5"/><path d="M21 16h-3v3"/><path d="M21 21h-3"/><path d="M16 21v-3"/></svg>
                    <span class="card-title">Scan Manual</span>
                </div>
                <div class="card-body" style="padding:16px 20px">
                    <p style="font-size:12.5px;color:var(--text2);margin-bottom:12px;font-family:'Plus Jakarta Sans',sans-serif">
                        Gunakan scan manual jika guru tidak bisa scan QR sendiri.
                    </p>
                    <a href="{{ route('piket.absensi-guru.scan-qr') }}" class="btn btn-primary btn-sm" style="width:100%;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="5" height="5"/><rect x="16" y="3" width="5" height="5"/><rect x="3" y="16" width="5" height="5"/><path d="M21 16h-3v3"/><path d="M21 21h-3"/><path d="M16 21v-3"/></svg>
                        Buka Halaman Scan QR
                    </a>
                    <div style="height:8px"></div>
                    <a href="{{ route('piket.absensi-guru.massal.form') }}" class="btn btn-secondary btn-sm" style="width:100%;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        Absen Massal Guru
                    </a>
                </div>
            </div>
        </div>

    </div>{{-- /main-grid --}}
</div>

{{-- QR Code library --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ── Konfirmasi aksi destruktif ──────────────────────────────────────────────
function confirmAction(btn, title, text) {
    // Prevent default submit, pakai SweetAlert
    event.preventDefault();
    const form = btn.closest('form');
    Swal.fire({
        title,
        text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) form.submit(); });
    return false;
}

// ── Generate QR dari kode_qr (UUID) ────────────────────────────────────────
const kodeQrEl   = document.getElementById('kodeQrCurrent');
const qrCanvasEl = document.getElementById('qrCanvas');

let qrInstance = null;

function renderQr(kodeQr) {
    if (!qrCanvasEl || !kodeQr) return;
    // Bersihkan canvas
    const ctx = qrCanvasEl.getContext('2d');
    ctx.clearRect(0, 0, 200, 200);

    // QRCode.js render ke canvas
    if (qrInstance) {
        qrInstance.clear();
        qrInstance.makeCode(kodeQr);
    } else {
        qrInstance = new QRCode(qrCanvasEl, {
            text: kodeQr,
            width: 200,
            height: 200,
            colorDark: '#0f172a',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.M,
        });
    }

    const uuidEl = document.getElementById('qrUuidDisplay');
    if (uuidEl) uuidEl.textContent = kodeQr;
}

// ── Countdown timer ─────────────────────────────────────────────────────────
const berakhirPadaEl = document.getElementById('berakhirPada');
const timerDisplayEl = document.getElementById('timerDisplay');

function updateTimer() {
    if (!berakhirPadaEl || !timerDisplayEl) return;

    const berakhirTs  = parseInt(berakhirPadaEl.value, 10) * 1000;
    const sekarang    = Date.now();
    const sisaMs      = berakhirTs - sekarang;

    if (sisaMs <= 0) {
        timerDisplayEl.textContent = '00:00';
        timerDisplayEl.className   = 'timer-display expired';
        return;
    }

    const sisaDetik   = Math.floor(sisaMs / 1000);
    const menit       = Math.floor(sisaDetik / 60);
    const detik       = sisaDetik % 60;
    const formatted   = `${String(menit).padStart(2,'0')}:${String(detik).padStart(2,'0')}`;

    timerDisplayEl.textContent = formatted;
    timerDisplayEl.className   = sisaDetik < 300
        ? (sisaDetik < 60 ? 'timer-display expired' : 'timer-display warning')
        : 'timer-display';
}

// ── Polling status sesi (setiap 30 detik) ───────────────────────────────────
async function pollStatus() {
    try {
        const res  = await fetch('{{ route("piket.sesi-qr-guru.status") }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!res.ok) return;
        const data = await res.json();

        // Jika kode QR berubah (misalnya di-refresh dari device lain), update QR
        if (data.aktif && kodeQrEl && data.kode_qr && data.kode_qr !== kodeQrEl.value) {
            kodeQrEl.value = data.kode_qr;
            renderQr(data.kode_qr);
        }

        // Jika status berubah (aktif ↔ tidak aktif), reload halaman
        const sesiAktifSekarang = {{ $sesiAktif ? 'true' : 'false' }};
        if (data.aktif !== sesiAktifSekarang) {
            window.location.reload();
        }

        // Update timestamp berakhir jika berubah
        if (data.aktif && data.berakhir_dalam !== null && berakhirPadaEl) {
            const barTs = Math.floor(Date.now() / 1000) + data.berakhir_dalam;
            berakhirPadaEl.value = barTs;
        }
    } catch (_) {
        // Gagal polling — abaikan, coba lagi berikutnya
    }
}

// ── Init ─────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    // Render QR awal jika sesi aktif
    if (kodeQrEl) renderQr(kodeQrEl.value);

    // Timer tick setiap detik
    if (timerDisplayEl) {
        updateTimer();
        setInterval(updateTimer, 1000);
    }

    // Polling setiap 30 detik
    setInterval(pollStatus, 30000);
});

// ── Flash SweetAlert ─────────────────────────────────────────────────────────
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:3000,showConfirmButton:false,toast:true,position:'top-end'});
@endif
@if(session('warning'))
Swal.fire({icon:'warning',title:'Perhatian!',text:@json(session('warning')),confirmButtonColor:'#1f63db'});
@endif
@if(session('error'))
Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
@endif
</script>
</x-app-layout>