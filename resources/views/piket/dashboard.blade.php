<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --piket-700:#b45309;--piket-600:#d97706;--piket-500:#f59e0b;
        --piket-100:#fef3c7;--piket-50:#fffbeb;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
        --green-bg:#f0fdf4;--green:#15803d;--green-border:#bbf7d0;
        --red-bg:#fff0f0;--red:#dc2626;--red-border:#fecaca;
        --yellow-bg:#fefce8;--yellow:#a16207;--yellow-border:#fde047;
        --blue-bg:#eff6ff;--blue:#1d4ed8;--blue-border:#bfdbfe;
        --purple-bg:#fdf4ff;--purple:#7c3aed;
        --orange-bg:#fff7ed;--orange:#c2410c;
    }

    .page{padding:28px 28px 48px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:20px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-xs{padding:3px 9px;font-size:11.5px;border-radius:5px;font-weight:700}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-detail:hover{background:#dcfce7;filter:none}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-amber{background:var(--piket-50);color:var(--piket-700);border:1px solid var(--piket-100)}
    .btn-amber:hover{background:var(--piket-100);filter:none}
    .btn-red{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}
    .btn-red:hover{background:#fee2e2;filter:none}
    .btn-green{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}
    .btn-green:hover{background:#dcfce7;filter:none}
    .btn-blue{background:var(--blue-bg);color:var(--blue);border:1px solid var(--blue-border)}

    /* ── Greeting ── */
    .greeting-card{
        background:linear-gradient(135deg,#1e40af 0%,var(--brand-700) 45%,#1750c0 100%);
        border-radius:var(--radius);padding:22px 26px;margin-bottom:20px;
        color:#fff;display:flex;align-items:center;justify-content:space-between;
        flex-wrap:wrap;gap:14px;position:relative;overflow:hidden
    }
    .greeting-card::before{
        content:'';position:absolute;inset:0;
        background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events:none
    }
    .greeting-left{position:relative;z-index:1}
    .greeting-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:17px;font-weight:800;margin-bottom:4px}
    .greeting-sub{font-size:13px;opacity:.82}
    .greeting-right{position:relative;z-index:1;display:flex;gap:10px;flex-wrap:wrap}

    .checkin-pill{display:inline-flex;align-items:center;gap:8px;padding:9px 16px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;backdrop-filter:blur(6px);border:1.5px solid rgba(255,255,255,.25)}
    .checkin-pill.active{background:rgba(16,185,129,.25);color:#ecfdf5}
    .checkin-pill.inactive{background:rgba(255,255,255,.15);color:rgba(255,255,255,.9)}
    .checkin-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0;animation:pulse-dot 2s ease-in-out infinite}
    .checkin-dot.green{background:#34d399}
    .checkin-dot.gray{background:rgba(255,255,255,.6);animation:none}
    @keyframes pulse-dot{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(.85)}}

    .notif-pill{display:inline-flex;align-items:center;gap:8px;padding:9px 16px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;background:rgba(255,255,255,.15);color:#fff;border:1.5px solid rgba(255,255,255,.25);backdrop-filter:blur(6px);text-decoration:none}

    /* ── Stats ── */
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;display:flex;align-items:center;gap:11px;transition:box-shadow .2s,transform .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.07);transform:translateY(-1px)}
    .stat-card.clickable{cursor:pointer;text-decoration:none;color:inherit}
    .stat-icon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.green{background:var(--green-bg)}
    .stat-icon.yellow{background:var(--yellow-bg)}
    .stat-icon.blue{background:var(--blue-bg)}
    .stat-icon.red{background:var(--red-bg)}
    .stat-icon.amber{background:var(--piket-50)}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}
    .stat-badge{display:inline-flex;padding:2px 7px;border-radius:99px;font-size:10.5px;font-weight:700;margin-top:4px}
    .stat-badge.warn{background:#fef3c7;color:#92400e}
    .stat-badge.danger{background:#fee2e2;color:#991b1b}
    .stat-badge.ok{background:#dcfce7;color:#166534}

    /* ── Grid Layout ── */
    .main-grid{display:grid;grid-template-columns:1fr 1fr 320px;gap:16px;margin-bottom:16px;align-items:start}
    .left-col{display:flex;flex-direction:column;gap:16px}
    .mid-col{display:flex;flex-direction:column;gap:16px}
    .right-col{display:flex;flex-direction:column;gap:16px}

    /* ── Panel ── */
    .panel{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .panel-header{display:flex;align-items:center;justify-content:space-between;padding:13px 18px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .panel-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:7px}
    .panel-body{padding:0}
    .empty-inline{padding:28px 18px;text-align:center;font-size:13px;color:var(--text3)}

    /* ── Check-in Panel ── */
    .checkin-panel{background:linear-gradient(135deg,var(--green-bg) 0%,#f0fdf4 100%);border:1.5px solid var(--green-border);border-radius:var(--radius);padding:18px 20px}
    .checkin-panel.not-in{background:var(--surface2);border:1.5px dashed var(--border2)}
    .checkin-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:800;color:var(--text);margin-bottom:3px}
    .checkin-time{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;font-weight:800;color:var(--green);line-height:1;margin:6px 0 2px}
    .checkin-time.inactive{color:var(--text3);font-size:18px}
    .checkin-meta{font-size:12px;color:var(--text2);margin-bottom:12px}
    .checkin-actions{display:flex;gap:8px;flex-wrap:wrap}

    /* ── Modal Overlay ── */
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.5);z-index:400;align-items:center;justify-content:center}
    .modal-overlay.open{display:flex}
    .modal{background:var(--surface);border-radius:var(--radius);width:420px;max-width:calc(100vw - 32px);box-shadow:0 20px 60px rgba(0,0,0,.18);overflow:hidden}
    .modal-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border)}
    .modal-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text)}
    .modal-close{width:28px;height:28px;display:flex;align-items:center;justify-content:center;border:none;background:var(--surface2);border-radius:6px;cursor:pointer;color:var(--text3)}
    .modal-close:hover{background:var(--surface3)}
    .modal-body{padding:20px}
    .modal-footer{display:flex;gap:8px;justify-content:flex-end;padding:14px 20px;border-top:1px solid var(--border);background:var(--surface2)}
    .field{display:flex;flex-direction:column;gap:5px;margin-bottom:14px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);text-transform:uppercase;letter-spacing:.04em}
    .field select,.field input[type=text],.field textarea{width:100%;height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .field select:focus,.field input:focus,.field textarea:focus{border-color:var(--brand-500);background:#fff}
    .field textarea{height:auto;padding:10px 12px;resize:vertical;min-height:72px}

    /* ── Jadwal Piket ── */
    .jadwal-piket-item{display:flex;align-items:center;gap:12px;padding:12px 18px;border-bottom:1px solid #f1f5f9;transition:background .1s}
    .jadwal-piket-item:last-child{border-bottom:none}
    .jadwal-piket-item:hover{background:#fafbff}
    .jadwal-hari{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:800;color:var(--text3);text-transform:uppercase;letter-spacing:.06em;min-width:36px;text-align:center}
    .jadwal-hari.today{color:var(--brand-600)}
    .jadwal-time-block{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:6px;padding:3px 8px;text-align:center;min-width:56px}
    .jadwal-time-block .t{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--brand-700)}
    .jadwal-info-block .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}
    .jadwal-info-block .secondary{font-size:11.5px;color:var(--text3);margin-top:1px}
    .jadwal-active-badge{margin-left:auto;display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:99px;font-size:11px;font-weight:700;background:#dcfce7;color:#166634}

    /* ── Pelanggaran ── */
    .pel-item{display:flex;align-items:flex-start;gap:12px;padding:12px 18px;border-bottom:1px solid #f1f5f9;transition:background .1s}
    .pel-item:last-child{border-bottom:none}
    .pel-item:hover{background:#fafbff}
    .pel-avatar{width:32px;height:32px;border-radius:8px;flex-shrink:0;background:linear-gradient(135deg,var(--red-bg),#fee2e2);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:800;color:var(--red)}
    .pel-info .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}
    .pel-info .secondary{font-size:11.5px;color:var(--text3);margin-top:1px}
    .pel-poin{margin-left:auto;flex-shrink:0;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;color:var(--red);background:var(--red-bg);border:1px solid var(--red-border);border-radius:6px;padding:2px 8px}

    /* ── Izin Keluar ── */
    .izin-item{display:flex;align-items:center;gap:11px;padding:11px 18px;border-bottom:1px solid #f1f5f9;transition:background .1s}
    .izin-item:last-child{border-bottom:none}
    .izin-item:hover{background:#fafbff}
    .izin-avatar{width:30px;height:30px;border-radius:7px;flex-shrink:0;background:var(--piket-50);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:800;color:var(--piket-700)}
    .izin-info .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}
    .izin-info .secondary{font-size:11.5px;color:var(--text3);margin-top:1px}
    .izin-actions{margin-left:auto;display:flex;gap:5px;flex-shrink:0}

    /* ── Notifikasi ── */
    .notif-item{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-bottom:1px solid #f1f5f9;transition:background .1s;text-decoration:none}
    .notif-item:last-child{border-bottom:none}
    .notif-item:hover{background:#fafbff}
    .notif-dot-wrap{padding-top:4px;flex-shrink:0}
    .notif-dot{width:7px;height:7px;border-radius:50%;background:var(--brand-500)}
    .notif-dot.read{background:var(--border2)}
    .notif-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:12.5px;color:var(--text);line-height:1.3}
    .notif-sub{font-size:11.5px;color:var(--text3);margin-top:2px;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
    .notif-time{font-size:11px;color:var(--text3);margin-top:3px}

    /* ── Pengumuman ── */
    .peng-item{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-bottom:1px solid #f1f5f9;transition:background .1s;text-decoration:none}
    .peng-item:last-child{border-bottom:none}
    .peng-item:hover{background:#fafbff}
    .peng-pin{color:var(--piket-600);flex-shrink:0;padding-top:2px}
    .peng-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:12.5px;color:var(--text);line-height:1.3}
    .peng-sub{font-size:11.5px;color:var(--text3);margin-top:2px}

    /* ── Bertugas ── */
    .bertugas-item{display:flex;align-items:center;gap:10px;padding:10px 18px;border-bottom:1px solid #f1f5f9}
    .bertugas-item:last-child{border-bottom:none}
    .bertugas-avatar{width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,var(--brand-100),var(--brand-50));display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:800;color:var(--brand-700);flex-shrink:0}
    .bertugas-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}
    .bertugas-time{font-size:11.5px;color:var(--text3);margin-top:1px}
    .bertugas-live{margin-left:auto;display:flex;align-items:center;gap:4px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--green)}
    .bertugas-live-dot{width:6px;height:6px;border-radius:50%;background:var(--green);animation:pulse-dot 2s ease-in-out infinite}

    /* ── Badge ── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-menunggu{background:var(--yellow-bg);color:var(--piket-700)} .badge-menunggu .badge-dot{background:var(--piket-600)}
    .badge-disetujui{background:var(--blue-bg);color:var(--blue)}       .badge-disetujui .badge-dot{background:var(--blue)}
    .badge-pending  {background:var(--yellow-bg);color:var(--yellow)}   .badge-pending   .badge-dot{background:var(--yellow)}
    .badge-diproses {background:var(--blue-bg);color:var(--blue)}       .badge-diproses  .badge-dot{background:var(--blue)}
    .badge-selesai  {background:var(--green-bg);color:var(--green)}     .badge-selesai   .badge-dot{background:var(--green)}

    /* ── Responsive ── */
    @media(max-width:1200px){
        .main-grid{grid-template-columns:1fr 1fr}
        .right-col{grid-column:1/-1;display:grid;grid-template-columns:1fr 1fr;gap:16px}
    }
    @media(max-width:800px){
        .main-grid{grid-template-columns:1fr}
        .right-col{display:flex;flex-direction:column}
        .stats-strip{grid-template-columns:repeat(2,1fr)}
    }
    @media(max-width:580px){
        .page{padding:16px 14px}
        .stats-strip{grid-template-columns:repeat(2,1fr);gap:9px}
        .greeting-card{padding:16px 18px}
    }
</style>

<div class="page">

    {{-- ══ GREETING ══ --}}
    <div class="greeting-card">
        <div class="greeting-left">
            <p class="greeting-title">
                Selamat datang, {{ $guruAktif->nama_lengkap ?? Auth::user()->name }} 👋
            </p>
            <p class="greeting-sub">
                {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                @if($jadwalHariIni)
                    &middot; Jadwal piket:
                    {{ \Carbon\Carbon::parse($jadwalHariIni->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($jadwalHariIni->jam_selesai)->format('H:i') }}
                @else
                    &middot; Tidak ada jadwal piket hari ini
                @endif
            </p>
        </div>
        <div class="greeting-right">
            @if($logHariIni && $logHariIni->masuk_pada)
                <span class="checkin-pill active">
                    <span class="checkin-dot green"></span>
                    {{ $guruAktif->nama_lengkap ?? 'Guru' }} sedang piket sejak {{ \Carbon\Carbon::parse($logHariIni->masuk_pada)->format('H:i') }}
                </span>
            @else
                <span class="checkin-pill inactive">
                    <span class="checkin-dot gray"></span>
                    Belum ada yang check-in hari ini
                </span>
            @endif

            @if($unreadCount > 0)
                <a href="{{ route('piket.notifikasi.index') }}" class="notif-pill">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    {{ $unreadCount }} notifikasi baru
                </a>
            @endif
        </div>
    </div>

    {{-- ══ STATS ══ --}}
    <div class="stats-strip">

        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="17" height="17" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Guru Piket</p>
                <p class="stat-val">{{ $stats['piket_checkin_hari_ini'] }}</p>
                <p class="stat-sub">check-in hari ini</p>
            </div>
        </div>

        <a href="{{ route('piket.pelanggaran.index') }}" class="stat-card clickable">
            <div class="stat-icon red">
                <svg width="17" height="17" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Pelanggaran</p>
                <p class="stat-val">{{ $stats['pelanggaran_hari_ini'] }}</p>
                <p class="stat-sub">hari ini</p>
                @if($stats['pelanggaran_hari_ini'] > 0)
                    <span class="stat-badge danger">Perlu tindak lanjut</span>
                @endif
            </div>
        </a>

        <a href="{{ route('piket.izin-keluar-siswa.index', ['status' => 'menunggu']) }}" class="stat-card clickable">
            <div class="stat-icon amber">
                <svg width="17" height="17" fill="none" stroke="#b45309" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Izin Menunggu</p>
                <p class="stat-val">{{ $stats['izin_menunggu'] }}</p>
                <p class="stat-sub">perlu diproses</p>
                @if($stats['izin_menunggu'] > 0)
                    <span class="stat-badge warn">Segera proses</span>
                @endif
            </div>
        </a>

        <a href="{{ route('piket.izin-keluar-siswa.index', ['status' => 'disetujui']) }}" class="stat-card clickable">
            <div class="stat-icon blue">
                <svg width="17" height="17" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Sedang Keluar</p>
                <p class="stat-val">{{ $stats['izin_sedang_keluar'] }}</p>
                <p class="stat-sub">siswa belum kembali</p>
                @if($stats['izin_sedang_keluar'] > 0)
                    <span class="stat-badge danger">Pantau</span>
                @endif
            </div>
        </a>

    </div>

    {{-- ══ MAIN GRID ══ --}}
    <div class="main-grid">

        {{-- ── KOLOM KIRI ── --}}
        <div class="left-col">

            {{-- ── Status Check-In ── --}}
            @if($logHariIni && $logHariIni->masuk_pada)
                <div class="checkin-panel">
                    <p class="checkin-title">Sedang Piket: {{ $guruAktif->nama_lengkap ?? '—' }}</p>
                    <p class="checkin-time" id="piket-timer">—</p>
                    <p class="checkin-meta">
                        Masuk: <strong>{{ \Carbon\Carbon::parse($logHariIni->masuk_pada)->format('H:i') }}</strong>
                        @if($logHariIni->keluar_pada)
                            &middot; Keluar: <strong>{{ \Carbon\Carbon::parse($logHariIni->keluar_pada)->format('H:i') }}</strong>
                        @else
                            &middot; Durasi berjalan
                        @endif
                    </p>
                    <div class="checkin-actions">
                        @if(!$logHariIni->keluar_pada)
                            <form method="POST" action="{{ route('piket.log.checkout', $logHariIni->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-red btn-sm">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                        <polyline points="16 17 21 12 16 7"/>
                                        <line x1="21" y1="12" x2="9" y2="12"/>
                                    </svg>
                                    Check-Out Sekarang
                                </button>
                            </form>
                        @else
                            <span class="btn btn-detail btn-sm" style="pointer-events:none;opacity:.7">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                Piket selesai
                            </span>
                        @endif
                        <a href="{{ route('piket.log.checkin') }}" class="btn btn-amber btn-sm">Detail Log</a>
                    </div>
                </div>
            @else
                <div class="checkin-panel not-in">
                    <p class="checkin-title">Check-In Piket</p>
                    <p class="checkin-time inactive">Belum ada yang check-in</p>
                    <p class="checkin-meta">
                        @if($jadwalHariIni)
                            Jadwal: {{ \Carbon\Carbon::parse($jadwalHariIni->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($jadwalHariIni->jam_selesai)->format('H:i') }}
                        @else
                            Tidak ada jadwal piket hari ini
                        @endif
                    </p>
                    <div class="checkin-actions">
                        <button type="button" class="btn btn-primary btn-sm" onclick="openCheckinModal()">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                                <polyline points="10 17 15 12 10 7"/>
                                <line x1="15" y1="12" x2="3" y2="12"/>
                            </svg>
                            Check-In Sekarang
                        </button>
                        <a href="{{ route('piket.log.checkin') }}" class="btn btn-amber btn-sm">Lihat Log</a>
                    </div>
                </div>
            @endif

            {{-- ── Jadwal Piket Mingguan ── --}}
            @php $hariMap = ['senin'=>'Sen','selasa'=>'Sel','rabu'=>'Rab','kamis'=>'Kam','jumat'=>'Jum','sabtu'=>'Sab']; @endphp
            <div class="panel">
                <div class="panel-header">
                    <p class="panel-title">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Jadwal Piket
                        @if($guruAktif)
                            <span style="font-size:11px;color:var(--text3);font-weight:600">— {{ $guruAktif->nama_lengkap }}</span>
                        @endif
                    </p>
                    <a href="{{ route('piket.jadwal.index') }}" class="btn btn-sm btn-detail">Semua</a>
                </div>
                <div class="panel-body">
                    @forelse($jadwalSaya as $j)
                        <div class="jadwal-piket-item">
                            <span class="jadwal-hari {{ $j->hari === $hariIni ? 'today' : '' }}">
                                {{ $hariMap[$j->hari] ?? ucfirst($j->hari) }}
                            </span>
                            <div class="jadwal-time-block">
                                <p class="t">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}</p>
                                <p class="t" style="opacity:.6;font-weight:600">{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</p>
                            </div>
                            <div class="jadwal-info-block">
                                <p class="primary">Piket {{ ucfirst($j->hari) }}</p>
                                <p class="secondary">{{ $j->catatan ?: 'Tidak ada catatan' }}</p>
                            </div>
                            @if($j->hari === $hariIni)
                                <span class="jadwal-active-badge">
                                    <svg width="9" height="9" fill="#166634" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5"/></svg>
                                    Hari ini
                                </span>
                            @endif
                        </div>
                    @empty
                        <p class="empty-inline">
                            @if($guruAktif)
                                Tidak ada jadwal piket aktif untuk {{ $guruAktif->nama_lengkap }}
                            @else
                                Check-in terlebih dahulu untuk melihat jadwal
                            @endif
                        </p>
                    @endforelse
                </div>
            </div>

            {{-- ── Guru Sedang Piket ── --}}
            <div class="panel">
                <div class="panel-header">
                    <p class="panel-title">
                        <svg width="14" height="14" fill="none" stroke="var(--green)" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                        Guru Piket Aktif
                    </p>
                    <span style="font-size:11.5px;color:var(--text3)">{{ $guruSedangPiket->count() }} bertugas</span>
                </div>
                <div class="panel-body">
                    @forelse($guruSedangPiket as $lp)
                        <div class="bertugas-item">
                            <div class="bertugas-avatar">
                                {{ strtoupper(substr($lp->guru->nama_lengkap ?? 'G', 0, 2)) }}
                            </div>
                            <div style="flex:1;min-width:0">
                                <p class="bertugas-name">{{ $lp->guru->nama_lengkap ?? '—' }}</p>
                                <p class="bertugas-time">Masuk: {{ \Carbon\Carbon::parse($lp->masuk_pada)->format('H:i') }}</p>
                            </div>
                            <div class="bertugas-live">
                                <span class="bertugas-live-dot"></span> Live
                            </div>
                        </div>
                    @empty
                        <p class="empty-inline">Tidak ada guru yang sedang piket</p>
                    @endforelse
                </div>
            </div>

        </div>{{-- /left-col --}}

        {{-- ── KOLOM TENGAH ── --}}
        <div class="mid-col">

            {{-- Izin Keluar — Menunggu --}}
            <div class="panel">
                <div class="panel-header">
                    <p class="panel-title">
                        <svg width="14" height="14" fill="none" stroke="var(--piket-600)" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                            <polyline points="10 17 15 12 10 7"/>
                            <line x1="15" y1="12" x2="3" y2="12"/>
                        </svg>
                        Izin Keluar — Menunggu
                        @if($stats['izin_menunggu'] > 0)
                            <span style="background:var(--piket-100);color:var(--piket-700);font-size:11px;padding:1px 7px;border-radius:99px">
                                {{ $stats['izin_menunggu'] }}
                            </span>
                        @endif
                    </p>
                    <a href="{{ route('piket.izin-keluar-siswa.index', ['status' => 'menunggu']) }}" class="btn btn-sm btn-detail">Semua</a>
                </div>
                <div class="panel-body">
                    @forelse($izinMenunggu as $izin)
                        <div class="izin-item">
                            <div class="izin-avatar">
                                {{ strtoupper(substr($izin->siswa->nama_lengkap ?? 'S', 0, 2)) }}
                            </div>
                            <div class="izin-info" style="flex:1;min-width:0">
                                <p class="primary" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                                    {{ $izin->siswa->nama_lengkap ?? '—' }}
                                </p>
                                <p class="secondary">
                                    {{ $izin->siswa->kelas->nama_kelas ?? '—' }}
                                    &middot; {{ \Carbon\Carbon::parse($izin->jam_keluar)->format('H:i') }}
                                    &middot; {{ $izin->kategori_label }}
                                </p>
                            </div>
                            <div class="izin-actions">
                                @if($guruAktif)
                                    <form method="POST" action="{{ route('piket.izin-keluar-siswa.approve', $izin->id) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-xs btn-green"
                                            onclick="return confirm('Setujui izin keluar {{ addslashes($izin->siswa->nama_lengkap ?? '') }}?')">
                                            ✓ Setujui
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('piket.izin-keluar-siswa.show', $izin->id) }}" class="btn btn-xs btn-detail">Lihat</a>
                            </div>
                        </div>
                    @empty
                        <p class="empty-inline">
                            <svg width="28" height="28" fill="none" stroke="var(--text3)" stroke-width="1.4" viewBox="0 0 24 24" style="display:block;margin:0 auto 8px">
                                <circle cx="12" cy="12" r="10"/><polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Tidak ada izin yang menunggu
                        </p>
                    @endforelse
                </div>
            </div>

            {{-- Pelanggaran Hari Ini --}}
            <div class="panel">
                <div class="panel-header">
                    <p class="panel-title">
                        <svg width="14" height="14" fill="none" stroke="var(--red)" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                        Pelanggaran Hari Ini
                    </p>
                    <div style="display:flex;gap:6px;align-items:center">
                        @if($guruAktif)
                            <a href="{{ route('piket.pelanggaran.create') }}" class="btn btn-sm btn-red">+ Input</a>
                        @endif
                        <a href="{{ route('piket.pelanggaran.index') }}" class="btn btn-sm btn-detail">Semua</a>
                    </div>
                </div>
                <div class="panel-body">
                    @forelse($pelanggaranHariIni as $pel)
                        <div class="pel-item">
                            <div class="pel-avatar">
                                {{ strtoupper(substr($pel->siswa->nama_lengkap ?? 'S', 0, 2)) }}
                            </div>
                            <div class="pel-info" style="flex:1;min-width:0">
                                <p class="primary" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                                    {{ $pel->siswa->nama_lengkap ?? '—' }}
                                </p>
                                <p class="secondary">
                                    {{ $pel->kategori->nama ?? '—' }}
                                    &middot; {{ $pel->siswa->kelas->nama_kelas ?? '—' }}
                                </p>
                                <span class="badge badge-{{ $pel->status }}" style="margin-top:3px">
                                    <span class="badge-dot"></span>{{ ucfirst($pel->status) }}
                                </span>
                            </div>
                            <span class="pel-poin">{{ $pel->poin }} poin</span>
                        </div>
                    @empty
                        <p class="empty-inline">
                            <svg width="28" height="28" fill="none" stroke="var(--text3)" stroke-width="1.4" viewBox="0 0 24 24" style="display:block;margin:0 auto 8px">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Tidak ada pelanggaran hari ini
                        </p>
                    @endforelse
                </div>
            </div>

            {{-- Laporan Harian --}}
            {{--
                FIX: Kolom yang dipakai di view disesuaikan dengan $fillable model:
                - kondisi_umum  → TIDAK ADA  → ganti ke catatan_umum / kondisi_sekolah
                - Field preview pakai catatan_umum (ada di $fillable)
            --}}
            <div class="panel">
                <div class="panel-header">
                    <p class="panel-title">
                        <svg width="14" height="14" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                        Laporan Harian
                    </p>
                    <div style="display:flex;gap:6px">
                        @if($guruAktif)
                            <a href="{{ route('piket.laporan.harian') }}" class="btn btn-sm btn-primary">+ Buat</a>
                        @endif
                        <a href="{{ route('piket.laporan.riwayat') }}" class="btn btn-sm btn-detail">Riwayat</a>
                    </div>
                </div>
                <div class="panel-body" style="padding:18px">
                    @if($laporanHariIni)
                        {{--
                            Laporan sudah dibuat.
                            Preview teks: gunakan catatan_umum (ada di $fillable).
                            Fallback ke kondisi_sekolah jika catatan_umum kosong.
                        --}}
                        @php
                            $previewLaporan = $laporanHariIni->catatan_umum
                                ?? $laporanHariIni->kondisi_sekolah
                                ?? '—';
                        @endphp
                        <div style="display:flex;align-items:center;gap:10px;padding:12px 14px;background:var(--green-bg);border:1px solid var(--green-border);border-radius:var(--radius-sm)">
                            <svg width="16" height="16" fill="none" stroke="var(--green)" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            <div style="flex:1">
                                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--green)">
                                    Laporan hari ini sudah dibuat
                                </p>
                                <p style="font-size:11.5px;color:var(--text2);margin-top:2px">
                                    {{ \Illuminate\Support\Str::limit($previewLaporan, 80) }}
                                </p>
                            </div>
                            <a href="{{ route('piket.laporan.show', $laporanHariIni->id) }}" class="btn btn-xs btn-detail">Lihat</a>
                        </div>
                    @elseif($guruAktif)
                        <div style="display:flex;align-items:center;gap:10px;padding:12px 14px;background:var(--piket-50);border:1px dashed var(--piket-100);border-radius:var(--radius-sm)">
                            <svg width="16" height="16" fill="none" stroke="var(--piket-600)" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            <div style="flex:1">
                                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--piket-700)">
                                    Laporan hari ini belum dibuat
                                </p>
                                <p style="font-size:11.5px;color:var(--text2);margin-top:2px">
                                    Buat laporan sebelum piket berakhir
                                </p>
                            </div>
                            <a href="{{ route('piket.laporan.harian') }}" class="btn btn-xs btn-amber">Buat</a>
                        </div>
                    @else
                        <p style="font-size:13px;color:var(--text3);text-align:center;padding:8px 0">
                            Check-in terlebih dahulu untuk membuat laporan
                        </p>
                    @endif
                </div>
            </div>

        </div>{{-- /mid-col --}}

        {{-- ── KOLOM KANAN ── --}}
        <div class="right-col">

            {{-- Notifikasi --}}
            <div class="panel">
                <div class="panel-header">
                    <p class="panel-title">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                        Notifikasi
                        @if($unreadCount > 0)
                            <span style="background:var(--red-bg);color:var(--red);font-size:11px;padding:1px 7px;border-radius:99px;font-weight:800">{{ $unreadCount }}</span>
                        @endif
                    </p>
                    <a href="{{ route('piket.notifikasi.index') }}" class="btn btn-sm btn-detail">Semua</a>
                </div>
                <div class="panel-body">
                    @forelse($notifikasiTerbaru as $notif)
                        <a href="{{ route('piket.notifikasi.show', $notif->id) }}" class="notif-item">
                            <div class="notif-dot-wrap">
                                <span class="notif-dot {{ $notif->sudah_dibaca ? 'read' : '' }}"></span>
                            </div>
                            <div style="flex:1;min-width:0">
                                <p class="notif-title">{{ $notif->judul }}</p>
                                <p class="notif-sub">{{ $notif->pesan }}</p>
                                <p class="notif-time">{{ $notif->created_at->diffForHumans() }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="empty-inline">Tidak ada notifikasi</p>
                    @endforelse
                </div>
            </div>

            {{-- Pengumuman --}}
            <div class="panel">
                <div class="panel-header">
                    <p class="panel-title">
                        <svg width="14" height="14" fill="none" stroke="var(--piket-600)" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        Pengumuman
                    </p>
                    <a href="{{ route('piket.pengumuman.index') }}" class="btn btn-sm btn-detail">Semua</a>
                </div>
                <div class="panel-body">
                    @forelse($pengumuman as $p)
                        <a href="{{ route('piket.pengumuman.show', $p->id) }}" class="peng-item">
                            @if($p->dipinned)
                                <span class="peng-pin">
                                    <svg width="11" height="11" fill="var(--piket-500)" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                </span>
                            @else
                                <span style="width:11px;flex-shrink:0"></span>
                            @endif
                            <div style="flex:1;min-width:0">
                                <p class="peng-title" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $p->judul }}</p>
                                <p class="peng-sub">{{ $p->dipublikasikan_pada->locale('id')->diffForHumans() }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="empty-inline">Tidak ada pengumuman</p>
                    @endforelse
                </div>
            </div>

            {{-- Aksi Cepat --}}
            <div class="panel">
                <div class="panel-header">
                    <p class="panel-title">
                        <svg width="14" height="14" fill="none" stroke="var(--text2)" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M19.07 4.93A10 10 0 1 0 4.93 19.07"/>
                        </svg>
                        Aksi Cepat
                    </p>
                </div>
                <div class="panel-body" style="padding:12px 14px;display:flex;flex-direction:column;gap:8px">
                    <a href="{{ route('piket.pelanggaran.create') }}" class="btn btn-red" style="justify-content:flex-start;width:100%">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Input Pelanggaran Siswa
                    </a>
                    <a href="{{ route('piket.izin-keluar-siswa.create') }}" class="btn btn-amber" style="justify-content:flex-start;width:100%">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                        Buat Izin Keluar Siswa
                    </a>
                    <a href="{{ route('admin.absensi-guru-piket.scan-qr') }}" class="btn btn-blue" style="justify-content:flex-start;width:100%">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="5" height="5"/><rect x="16" y="3" width="5" height="5"/><rect x="3" y="16" width="5" height="5"/><path d="M21 16h-3v3"/><path d="M21 21h-3"/><path d="M16 21v-3"/></svg>
                        Scan QR Absensi Guru
                    </a>
                    <a href="{{ route('admin.absensi-guru-piket.massal.form') }}" class="btn btn-detail" style="justify-content:flex-start;width:100%">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        Absen Massal Guru
                    </a>
                    <a href="{{ route('piket.laporan.harian') }}" class="btn" style="background:var(--purple-bg);color:var(--purple);justify-content:flex-start;width:100%;border:1px solid #e9d5ff">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Buat Laporan Harian
                    </a>
                </div>
            </div>

        </div>{{-- /right-col --}}

    </div>{{-- /main-grid --}}

</div>{{-- /page --}}

{{-- ══ MODAL CHECK-IN ══ --}}
<div class="modal-overlay" id="checkinModal">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Check-In Piket</span>
            <button type="button" class="modal-close" onclick="closeCheckinModal()">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('piket.log.do-checkin') }}">
            @csrf
            <div class="modal-body">
                <div class="field">
                    <label>Nama Guru yang Check-In <span style="color:var(--red)">*</span></label>
                    <select name="guru_id" required id="checkinGuruSelect">
                        <option value="">— Pilih Nama Guru —</option>
                        @php
                            $semuaGuruDashboard = \App\Models\Guru::aktif()->orderBy('nama_lengkap')->get();
                            $hariIniCheckin     = strtolower(\Carbon\Carbon::now()->locale('id')->isoFormat('dddd'));
                            $guruTerjadwalIds   = \App\Models\JadwalPiketGuru::where('hari', $hariIniCheckin)
                                ->where('is_active', true)
                                ->pluck('guru_id')
                                ->toArray();
                        @endphp
                        @if(count($guruTerjadwalIds))
                            <optgroup label="Terjadwal Hari Ini">
                                @foreach($semuaGuruDashboard->whereIn('id', $guruTerjadwalIds) as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama_lengkap }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Guru Lainnya">
                                @foreach($semuaGuruDashboard->whereNotIn('id', $guruTerjadwalIds) as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama_lengkap }}</option>
                                @endforeach
                            </optgroup>
                        @else
                            @foreach($semuaGuruDashboard as $g)
                                <option value="{{ $g->id }}">{{ $g->nama_lengkap }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="field">
                    <label>Shift</label>
                    <select name="shift">
                        <option value="pagi">Pagi (07:00 – 12:00)</option>
                        <option value="siang">Siang (12:00 – 17:00)</option>
                        <option value="sore">Sore (14:00 – 18:00)</option>
                    </select>
                </div>
                <div class="field" style="margin-bottom:0">
                    <label>Catatan (opsional)</label>
                    <textarea name="catatan" placeholder="Catatan tambahan…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm" style="background:var(--surface2);color:var(--text2);border:1px solid var(--border)" onclick="closeCheckinModal()">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Konfirmasi Check-In
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ SCRIPTS ══ --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('warning'))
Swal.fire({ icon:'warning', title:'Perhatian', text:@json(session('warning')), confirmButtonColor:'#1f63db' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif

function openCheckinModal()  { document.getElementById('checkinModal').classList.add('open'); }
function closeCheckinModal() { document.getElementById('checkinModal').classList.remove('open'); }
document.getElementById('checkinModal').addEventListener('click', function(e) {
    if (e.target === this) closeCheckinModal();
});

/* ── Live timer ── */
@if($logHariIni && $logHariIni->masuk_pada && !$logHariIni->keluar_pada)
(function () {
    const masukAt = new Date("{{ \Carbon\Carbon::parse($logHariIni->masuk_pada)->toIso8601String() }}");
    const el      = document.getElementById('piket-timer');
    if (!el) return;
    function pad(n) { return String(n).padStart(2, '0'); }
    function tick() {
        const diff = Math.floor((Date.now() - masukAt.getTime()) / 1000);
        if (diff < 0) { el.textContent = '00:00:00'; return; }
        el.textContent = pad(Math.floor(diff/3600)) + ':' + pad(Math.floor((diff%3600)/60)) + ':' + pad(diff%60);
    }
    tick();
    setInterval(tick, 1000);
}());
@endif
</script>

</x-app-layout>