<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=DM+Mono:wght@400;500&display=swap');

    :root {
        --brand-800:#0f3d99;
        --brand-700:#1750c0;
        --brand-600:#1f63db;
        --brand-500:#3582f0;
        --brand-100:#d9ebff;
        --brand-50:#eef6ff;

        --surface:#ffffff;
        --surface2:#f8fafc;
        --surface3:#f1f5f9;
        --border:#e2e8f0;
        --border2:#cbd5e1;

        --text:#0f172a;
        --text2:#334155;
        --text3:#64748b;
        --text4:#94a3b8;

        --green-bg:#f0fdf4; --green-mid:#dcfce7; --green:#15803d; --green-dark:#14532d;
        --yellow-bg:#fefce8; --yellow:#a16207;
        --red-bg:#fff0f0; --red:#dc2626;
        --purple-bg:#fdf4ff; --purple:#7c3aed;
        --orange-bg:#fff7ed; --orange:#c2410c;
        --teal-bg:#f0fdfa; --teal:#0f766e;
        --sky-bg:#f0f9ff; --sky:#0369a1;
        --pink-bg:#fdf2f8; --pink:#be185d;

        --radius:12px;
        --radius-sm:8px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);
        --shadow:0 4px 16px rgba(0,0,0,.07),0 1px 4px rgba(0,0,0,.04);
        --shadow-lg:0 12px 40px rgba(0,0,0,.10),0 4px 12px rgba(0,0,0,.06);
    }

    *{box-sizing:border-box;margin:0;padding:0}
    .db{padding:28px 30px 48px;font-family:'Plus Jakarta Sans',sans-serif}

    /* ── HERO GREETING ──────────────────────────────────────────────────── */
    .hero{
        position:relative;overflow:hidden;
        background:linear-gradient(135deg,#1750c0 0%,#1f63db 45%,#3582f0 100%);
        border-radius:16px;padding:26px 30px;margin-bottom:22px;
        display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;
        box-shadow:0 8px 32px rgba(31,99,219,.35);
    }
    .hero::before{
        content:'';position:absolute;inset:0;
        background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='20'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .hero-left{position:relative}
    .hero-eyebrow{font-size:11.5px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:6px}
    .hero-name{font-size:22px;font-weight:800;color:#fff;line-height:1.2;margin-bottom:4px}
    .hero-date{font-size:13px;color:rgba(255,255,255,.7)}
    .hero-chips{position:relative;display:flex;gap:10px;flex-wrap:wrap;margin-top:14px}
    .hero-chip{
        display:inline-flex;align-items:center;gap:6px;
        background:rgba(255,255,255,.14);backdrop-filter:blur(6px);
        border:1px solid rgba(255,255,255,.2);border-radius:99px;
        padding:5px 12px;font-size:12px;font-weight:700;color:#fff;
    }
    .hero-chip svg{opacity:.8}
    .hero-right{position:relative;text-align:right}
    .hero-time{font-family:'DM Mono',monospace;font-size:32px;font-weight:500;color:#fff;letter-spacing:-.02em;line-height:1}
    .hero-time-sub{font-size:12px;color:rgba(255,255,255,.6);margin-top:4px}

    /* ── STATS GRID ─────────────────────────────────────────────────────── */
    .stats-grid{
        display:grid;
        grid-template-columns:repeat(4,1fr);
        gap:12px;margin-bottom:22px;
    }
    .stat{
        background:var(--surface);border:1px solid var(--border);
        border-radius:var(--radius);padding:16px 18px;
        display:flex;flex-direction:column;gap:10px;
        box-shadow:var(--shadow-sm);transition:box-shadow .2s,transform .2s;
        position:relative;overflow:hidden;
    }
    .stat::after{
        content:'';position:absolute;right:-12px;bottom:-12px;
        width:72px;height:72px;border-radius:50%;opacity:.07;
        background:currentColor;
    }
    .stat:hover{box-shadow:var(--shadow);transform:translateY(-1px)}
    .stat-top{display:flex;align-items:center;justify-content:space-between}
    .stat-icon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-trend{font-size:11px;font-weight:700;padding:2px 8px;border-radius:99px}
    .stat-label{font-size:11px;font-weight:700;letter-spacing:.05em;text-transform:uppercase;color:var(--text4)}
    .stat-value{font-size:28px;font-weight:800;color:var(--text);line-height:1;letter-spacing:-.03em}
    .stat-sub{font-size:11.5px;color:var(--text3);margin-top:2px}

    /* ── ABSENSI BREAKDOWN ──────────────────────────────────────────────── */
    .absensi-strip{
        background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);
        padding:18px 22px;margin-bottom:22px;box-shadow:var(--shadow-sm);
    }
    .absensi-strip-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
    .section-title{font-size:13px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:7px}
    .absensi-bars{display:grid;grid-template-columns:repeat(4,1fr);gap:10px}
    .ab-bar{background:var(--surface2);border-radius:10px;padding:14px;text-align:center;border:1px solid var(--border)}
    .ab-bar-val{font-size:24px;font-weight:800;line-height:1;margin-bottom:4px}
    .ab-bar-label{font-size:11.5px;font-weight:600;color:var(--text3)}
    .ab-bar-pct{font-size:11px;font-weight:700;padding:2px 7px;border-radius:99px;display:inline-flex;margin-top:6px}

    /* ── MAIN LAYOUT ────────────────────────────────────────────────────── */
    .main-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}
    .full-width{grid-column:1/-1}

    /* ── PANEL ──────────────────────────────────────────────────────────── */
    .panel{
        background:var(--surface);border:1px solid var(--border);
        border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-sm);
    }
    .panel-head{
        display:flex;align-items:center;justify-content:space-between;
        padding:14px 18px;border-bottom:1px solid var(--border);background:var(--surface2);
    }
    .panel-body{padding:0}

    .btn{
        display:inline-flex;align-items:center;gap:5px;
        padding:6px 13px;border-radius:7px;
        font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;
        cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap;
    }
    .btn-ghost{background:var(--surface3);color:var(--text2);border:1px solid var(--border)}
    .btn-ghost:hover{background:var(--border);color:var(--text)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-primary:hover{background:var(--brand-700)}
    .btn-danger{background:var(--red-bg);color:var(--red);border:1px solid #fecaca}
    .btn-danger:hover{background:#fecaca}
    .btn-green{background:var(--green-bg);color:var(--green);border:1px solid #bbf7d0}
    .btn-green:hover{background:var(--green-mid)}

    /* ── JADWAL ─────────────────────────────────────────────────────────── */
    .jadwal-row{
        display:flex;align-items:center;gap:12px;
        padding:12px 18px;border-bottom:1px solid #f1f5f9;
        transition:background .12s;
    }
    .jadwal-row:last-child{border-bottom:none}
    .jadwal-row:hover{background:var(--surface2)}
    .jadwal-time-col{
        display:flex;flex-direction:column;align-items:center;
        min-width:52px;
        font-family:'DM Mono',monospace;font-size:11.5px;color:var(--text3);line-height:1.5;
    }
    .jadwal-time-col .start{font-weight:500;color:var(--text2)}
    .jadwal-divider{width:1px;height:10px;background:var(--border2);margin:1px 0}
    .jadwal-dot{
        width:8px;height:8px;border-radius:50%;background:var(--brand-500);
        flex-shrink:0;box-shadow:0 0 0 3px var(--brand-50);
    }
    .jadwal-info{flex:1;min-width:0}
    .jadwal-mapel{font-size:13.5px;font-weight:700;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .jadwal-meta{font-size:11.5px;color:var(--text3);margin-top:2px}
    .jadwal-badge-guru{
        font-size:11px;font-weight:700;
        background:var(--brand-50);color:var(--brand-700);
        border:1px solid var(--brand-100);
        border-radius:99px;padding:2px 9px;white-space:nowrap;
    }

    /* ── PELANGGARAN ─────────────────────────────────────────────────────── */
    .pel-row{
        display:flex;align-items:center;gap:11px;
        padding:11px 18px;border-bottom:1px solid #f1f5f9;transition:background .12s;
    }
    .pel-row:last-child{border-bottom:none}
    .pel-row:hover{background:var(--surface2)}
    .pel-avatar{
        width:34px;height:34px;border-radius:9px;flex-shrink:0;
        background:linear-gradient(135deg,var(--brand-100),var(--brand-50));
        display:flex;align-items:center;justify-content:center;
        font-size:13px;font-weight:800;color:var(--brand-700);
    }
    .pel-info{flex:1;min-width:0}
    .pel-name{font-size:13px;font-weight:700;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .pel-meta{font-size:11.5px;color:var(--text3);margin-top:1px}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-size:11px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%}
    .badge-ringan{background:#fef9c3;color:#a16207} .badge-ringan .badge-dot{background:#a16207}
    .badge-sedang{background:#fff7ed;color:#c2410c} .badge-sedang .badge-dot{background:#c2410c}
    .badge-berat{background:#fee2e2;color:#dc2626}  .badge-berat  .badge-dot{background:#dc2626}
    .badge-default{background:var(--surface3);color:var(--text3)} .badge-default .badge-dot{background:var(--text4)}

    /* ── UJIAN ──────────────────────────────────────────────────────────── */
    .ujian-row{
        display:flex;align-items:center;gap:11px;
        padding:12px 18px;border-bottom:1px solid #f1f5f9;transition:background .12s;
    }
    .ujian-row:last-child{border-bottom:none}
    .ujian-row:hover{background:var(--surface2)}
    .ujian-date-box{
        background:linear-gradient(135deg,var(--brand-600),var(--brand-700));
        border-radius:9px;padding:8px 10px;text-align:center;flex-shrink:0;min-width:44px;
    }
    .ujian-date-box .day{font-size:16px;font-weight:800;color:#fff;line-height:1}
    .ujian-date-box .mon{font-size:10px;font-weight:700;color:rgba(255,255,255,.7);text-transform:uppercase;margin-top:1px}
    .ujian-info{flex:1;min-width:0}
    .ujian-name{font-size:13px;font-weight:700;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .ujian-meta{font-size:11.5px;color:var(--text3);margin-top:2px}
    .badge-live{background:#fee2e2;color:#dc2626;animation:pulse-badge 1.5s infinite} 
    .badge-live .badge-dot{background:#dc2626}
    @keyframes pulse-badge{0%,100%{opacity:1}50%{opacity:.6}}
    .badge-soon{background:var(--brand-50);color:var(--brand-700)} .badge-soon .badge-dot{background:var(--brand-500)}

    /* ── SISWA RAWAN ─────────────────────────────────────────────────────── */
    .rawan-row{
        display:flex;align-items:center;gap:11px;
        padding:11px 18px;border-bottom:1px solid #f1f5f9;transition:background .12s;
    }
    .rawan-row:last-child{border-bottom:none}
    .rawan-row:hover{background:var(--surface2)}
    .rank-badge{
        width:26px;height:26px;border-radius:7px;flex-shrink:0;
        display:flex;align-items:center;justify-content:center;
        font-size:12px;font-weight:800;font-family:'DM Mono',monospace;
    }
    .rank-1{background:#fef9c3;color:#a16207}
    .rank-2{background:#f1f5f9;color:#475569}
    .rank-3{background:#fff7ed;color:#c2410c}
    .rank-n{background:var(--surface3);color:var(--text3)}
    .rawan-bar-wrap{flex:1;height:5px;background:var(--surface3);border-radius:99px;overflow:hidden}
    .rawan-bar{height:100%;border-radius:99px;background:linear-gradient(90deg,#f97316,#dc2626)}
    .rawan-count{font-family:'DM Mono',monospace;font-size:12px;font-weight:500;color:var(--red);min-width:20px;text-align:right}

    /* ── PENGUMUMAN ──────────────────────────────────────────────────────── */
    .peng-row{
        display:flex;align-items:flex-start;gap:11px;
        padding:13px 18px;border-bottom:1px solid #f1f5f9;transition:background .12s;
    }
    .peng-row:last-child{border-bottom:none}
    .peng-row:hover{background:var(--surface2)}
    .peng-pin{flex-shrink:0;margin-top:2px}
    .peng-title{font-size:13px;font-weight:700;color:var(--text);line-height:1.4}
    .peng-meta{font-size:11.5px;color:var(--text3);margin-top:3px}

    /* ── IZIN KELUAR ─────────────────────────────────────────────────────── */
    .izin-summary{
        display:grid;grid-template-columns:1fr 1fr;gap:10px;padding:16px 18px;
    }
    .izin-card{
        border-radius:10px;padding:14px;display:flex;align-items:center;gap:10px;
    }
    .izin-card.menunggu{background:var(--yellow-bg);border:1px solid #fef08a}
    .izin-card.keluar  {background:var(--red-bg);border:1px solid #fecaca}
    .izin-card-icon{width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center}
    .izin-card.menunggu .izin-card-icon{background:#fef08a}
    .izin-card.keluar   .izin-card-icon{background:#fecaca}
    .izin-card-val{font-size:24px;font-weight:800;line-height:1}
    .izin-card.menunggu .izin-card-val{color:var(--yellow)}
    .izin-card.keluar   .izin-card-val{color:var(--red)}
    .izin-card-label{font-size:11.5px;font-weight:600;color:var(--text3);margin-top:1px}

    /* ── TREN CHART ─────────────────────────────────────────────────────── */
    .chart-wrap{padding:16px 18px}
    .chart-legend{display:flex;gap:14px;flex-wrap:wrap;margin-bottom:12px}
    .legend-item{display:flex;align-items:center;gap:5px;font-size:11.5px;font-weight:600;color:var(--text3)}
    .legend-dot{width:8px;height:8px;border-radius:3px;flex-shrink:0}
    .chart-bars{display:flex;align-items:flex-end;gap:6px;height:120px;padding-bottom:24px;position:relative}
    .chart-bars::after{
        content:'';position:absolute;bottom:24px;left:0;right:0;
        border-top:1px dashed var(--border2);
    }
    .bar-group{flex:1;display:flex;align-items:flex-end;gap:2px;position:relative}
    .bar-group::after{
        content:attr(data-label);position:absolute;bottom:-20px;left:50%;transform:translateX(-50%);
        font-size:10px;font-weight:700;color:var(--text4);white-space:nowrap;
        font-family:'DM Mono',monospace;
    }
    .bar-seg{border-radius:3px 3px 0 0;min-height:2px;flex:1;transition:opacity .2s}
    .bar-seg:hover{opacity:.7}
    .bar-hadir{background:#22c55e}
    .bar-izin {background:#60a5fa}
    .bar-sakit{background:#fb923c}
    .bar-alpha{background:#f87171}

    /* ── NILAI KELAS ─────────────────────────────────────────────────────── */
    .nilai-row{
        display:flex;align-items:center;gap:10px;
        padding:11px 18px;border-bottom:1px solid #f1f5f9;
    }
    .nilai-row:last-child{border-bottom:none}
    .nilai-rank{
        font-family:'DM Mono',monospace;font-size:11px;font-weight:500;
        color:var(--text4);min-width:18px;text-align:center;
    }
    .nilai-kelas{font-size:13px;font-weight:700;color:var(--text);flex:1}
    .nilai-bar-wrap{width:80px;height:5px;background:var(--surface3);border-radius:99px;overflow:hidden}
    .nilai-bar{height:100%;border-radius:99px;background:linear-gradient(90deg,var(--brand-500),var(--brand-700))}
    .nilai-score{
        font-family:'DM Mono',monospace;font-size:13px;font-weight:500;
        color:var(--brand-700);min-width:38px;text-align:right;
    }

    /* ── EMPTY ─────────────────────────────────────────────────────────── */
    .empty{padding:30px 18px;text-align:center}
    .empty-icon{font-size:28px;margin-bottom:8px;opacity:.4}
    .empty-text{font-size:13px;color:var(--text4)}

    /* ── TUGAS STAT ─────────────────────────────────────────────────────── */
    .tugas-row{display:flex;align-items:center;justify-content:space-between;padding:14px 18px;border-bottom:1px solid #f1f5f9}
    .tugas-row:last-child{border-bottom:none}
    .tugas-label{font-size:13px;font-weight:600;color:var(--text2)}
    .tugas-val{font-family:'DM Mono',monospace;font-size:18px;font-weight:500;color:var(--text)}

    /* ── RESPONSIVE ─────────────────────────────────────────────────────── */
    @media(max-width:1100px){.stats-grid{grid-template-columns:repeat(2,1fr)}}
    @media(max-width:800px){
        .main-grid{grid-template-columns:1fr}
        .absensi-bars{grid-template-columns:repeat(2,1fr)}
        .stats-grid{grid-template-columns:repeat(2,1fr)}
        .db{padding:16px}
    }
    @media(max-width:520px){.stats-grid{grid-template-columns:1fr}}
</style>

<div class="db">

    {{-- ── HERO ──────────────────────────────────────────────────────── --}}
    <div class="hero">
        <div class="hero-left">
            <p class="hero-eyebrow">Panel Admin</p>
            <p class="hero-name">Selamat datang, {{ $user->name ?? 'Admin' }} 👋</p>
            <p class="hero-date">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
            <div class="hero-chips">
                <span class="hero-chip">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ $jadwalHariIni->count() }} jadwal hari ini
                </span>
                @if($unreadNotifikasi > 0)
                <span class="hero-chip">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    {{ $unreadNotifikasi }} notifikasi baru
                </span>
                @endif
                @if($izinMenunggu > 0)
                <span class="hero-chip">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ $izinMenunggu }} izin menunggu
                </span>
                @endif
            </div>
        </div>
        <div class="hero-right">
            <div class="hero-time" id="clock">--:--</div>
            <div class="hero-time-sub">Waktu sekarang</div>
        </div>
    </div>

    {{-- ── STATS ─────────────────────────────────────────────────────── --}}
    <div class="stats-grid">
        <div class="stat" style="color:var(--brand-600)">
            <div class="stat-top">
                <div class="stat-icon" style="background:var(--brand-50)">
                    <svg width="18" height="18" fill="none" stroke="var(--brand-600)" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <span class="stat-trend" style="background:var(--brand-50);color:var(--brand-600)">Siswa</span>
            </div>
            <div class="stat-label">Total Siswa</div>
            <div class="stat-value">{{ number_format($totalSiswa) }}</div>
            <div class="stat-sub">terdaftar aktif</div>
        </div>

        <div class="stat" style="color:var(--green)">
            <div class="stat-top">
                <div class="stat-icon" style="background:var(--green-bg)">
                    <svg width="18" height="18" fill="none" stroke="var(--green)" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <span class="stat-trend" style="background:var(--green-bg);color:var(--green)">Guru</span>
            </div>
            <div class="stat-label">Total Guru</div>
            <div class="stat-value">{{ $totalGuru }}</div>
            <div class="stat-sub">tenaga pengajar</div>
        </div>

        <div class="stat" style="color:var(--purple)">
            <div class="stat-top">
                <div class="stat-icon" style="background:var(--purple-bg)">
                    <svg width="18" height="18" fill="none" stroke="var(--purple)" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <span class="stat-trend" style="background:var(--purple-bg);color:var(--purple)">Kelas</span>
            </div>
            <div class="stat-label">Total Kelas</div>
            <div class="stat-value">{{ $totalKelas }}</div>
            <div class="stat-sub">rombel aktif</div>
        </div>

        <div class="stat" style="color:var(--orange)">
            <div class="stat-top">
                <div class="stat-icon" style="background:var(--orange-bg)">
                    <svg width="18" height="18" fill="none" stroke="var(--orange)" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
                <span class="stat-trend" style="background:var(--orange-bg);color:var(--orange)">User</span>
            </div>
            <div class="stat-label">Total Pengguna</div>
            <div class="stat-value">{{ $totalUser }}</div>
            <div class="stat-sub">akun sistem</div>
        </div>
    </div>

    {{-- ── ABSENSI HARI INI ──────────────────────────────────────────── --}}
    <div class="absensi-strip">
        <div class="absensi-strip-head">
            <p class="section-title">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                Rekap Absensi Hari Ini
                <span style="font-size:11px;color:var(--text4);font-weight:500;margin-left:4px">
                    · total {{ $totalAbsensiHariIni }} siswa tercatat
                </span>
            </p>
            <a href="{{ route('admin.absensi.index') }}" class="btn btn-ghost">Lihat Detail</a>
        </div>
        <div class="absensi-bars">
            @php
                $pctHadir = $totalAbsensiHariIni > 0 ? round(($absensiHariIni['hadir'] / $totalAbsensiHariIni) * 100) : 0;
                $pctIzin  = $totalAbsensiHariIni > 0 ? round(($absensiHariIni['izin']  / $totalAbsensiHariIni) * 100) : 0;
                $pctSakit = $totalAbsensiHariIni > 0 ? round(($absensiHariIni['sakit'] / $totalAbsensiHariIni) * 100) : 0;
                $pctAlfa  = $totalAbsensiHariIni > 0 ? round(($absensiHariIni['alfa']  / $totalAbsensiHariIni) * 100) : 0;
            @endphp
            <div class="ab-bar">
                <div class="ab-bar-val" style="color:#16a34a">{{ $absensiHariIni['hadir'] }}</div>
                <div class="ab-bar-label">Hadir</div>
                <div class="ab-bar-pct" style="background:#f0fdf4;color:#16a34a">{{ $pctHadir }}%</div>
            </div>
            <div class="ab-bar">
                <div class="ab-bar-val" style="color:var(--brand-600)">{{ $absensiHariIni['izin'] }}</div>
                <div class="ab-bar-label">Izin</div>
                <div class="ab-bar-pct" style="background:var(--brand-50);color:var(--brand-600)">{{ $pctIzin }}%</div>
            </div>
            <div class="ab-bar">
                <div class="ab-bar-val" style="color:#d97706">{{ $absensiHariIni['sakit'] }}</div>
                <div class="ab-bar-label">Sakit</div>
                <div class="ab-bar-pct" style="background:#fffbeb;color:#d97706">{{ $pctSakit }}%</div>
            </div>
            <div class="ab-bar">
                <div class="ab-bar-val" style="color:var(--red)">{{ $absensiHariIni['alfa'] }}</div>
                <div class="ab-bar-label">Alfa</div>
                <div class="ab-bar-pct" style="background:var(--red-bg);color:var(--red)">{{ $pctAlfa }}%</div>
            </div>
        </div>
    </div>

    {{-- ── MAIN GRID ─────────────────────────────────────────────────── --}}
    <div class="main-grid">

        {{-- Jadwal Hari Ini --}}
        <div class="panel">
            <div class="panel-head">
                <p class="section-title">
                    <svg width="13" height="13" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Jadwal Hari Ini
                </p>
                <a href="{{ route('admin.jadwal-pelajaran.index') }}" class="btn btn-ghost">Semua</a>
            </div>
            <div class="panel-body">
                @forelse($jadwalHariIni as $j)
                <div class="jadwal-row">
                    <div class="jadwal-time-col">
                        <span class="start">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}</span>
                        <span class="jadwal-divider" style="width:1px;height:8px;background:var(--border2);display:block;margin:2px auto"></span>
                        <span>{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</span>
                    </div>
                    <div class="jadwal-dot"></div>
                    <div class="jadwal-info">
                        <div class="jadwal-mapel">{{ $j->mataPelajaran->nama_mata_pelajaran ?? '—' }}</div>
                        <div class="jadwal-meta">{{ $j->kelas->nama_kelas ?? '—' }} · {{ $j->ruang->nama_ruang ?? '—' }}</div>
                    </div>
                    @if($j->guru)
                    <span class="jadwal-badge-guru">{{ $j->guru->nama_lengkap }}</span>
                    @endif
                </div>
                @empty
                <div class="empty">
                    <div class="empty-icon">📅</div>
                    <p class="empty-text">Tidak ada jadwal hari ini</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Ujian Aktif & Mendatang --}}
        <div class="panel">
            <div class="panel-head">
                <p class="section-title">
                    <svg width="13" height="13" fill="none" stroke="var(--red)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Ujian
                    @if($ujianAktif->count() > 0)
                        <span style="background:var(--red-bg);color:var(--red);font-size:10.5px;padding:1px 7px;border-radius:99px">
                            {{ $ujianAktif->count() }} live
                        </span>
                    @endif
                </p>
                <a href="{{ route('admin.ujian.index') }}" class="btn btn-ghost">Semua</a>
            </div>
            <div class="panel-body">
                @foreach($ujianAktif as $u)
                <div class="ujian-row">
                    <div class="ujian-date-box" style="background:linear-gradient(135deg,#dc2626,#b91c1c)">
                        <div class="day">{{ \Carbon\Carbon::parse($u->tanggal)->format('d') }}</div>
                        <div class="mon">{{ \Carbon\Carbon::parse($u->tanggal)->locale('id')->isoFormat('MMM') }}</div>
                    </div>
                    <div class="ujian-info">
                        <div class="ujian-name">{{ $u->judul ?? $u->mataPelajaran->nama_mata_pelajaran ?? '—' }}</div>
                        <div class="ujian-meta">
                            {{ \Carbon\Carbon::parse($u->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($u->jam_selesai)->format('H:i') }}
                        </div>
                    </div>
                    <span class="badge badge-live"><span class="badge-dot"></span>LIVE</span>
                </div>
                @endforeach

                @forelse($ujianMendatang as $u)
                <div class="ujian-row">
                    <div class="ujian-date-box">
                        <div class="day">{{ \Carbon\Carbon::parse($u->tanggal)->format('d') }}</div>
                        <div class="mon">{{ \Carbon\Carbon::parse($u->tanggal)->locale('id')->isoFormat('MMM') }}</div>
                    </div>
                    <div class="ujian-info">
                        <div class="ujian-name">{{ $u->judul ?? $u->mataPelajaran->nama_mata_pelajaran ?? '—' }}</div>
                        <div class="ujian-meta">
                            {{ \Carbon\Carbon::parse($u->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($u->jam_selesai)->format('H:i') }}
                        </div>
                    </div>
                    <span class="badge badge-soon"><span class="badge-dot"></span>Mendatang</span>
                </div>
                @empty
                @if($ujianAktif->isEmpty())
                <div class="empty">
                    <div class="empty-icon">📝</div>
                    <p class="empty-text">Tidak ada ujian dalam 7 hari ke depan</p>
                </div>
                @endif
                @endforelse
            </div>
        </div>

        {{-- Pelanggaran Terbaru --}}
        <div class="panel">
            <div class="panel-head">
                <p class="section-title">
                    <svg width="13" height="13" fill="none" stroke="var(--red)" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Pelanggaran Terbaru
                    <span style="background:var(--red-bg);color:var(--red);font-size:10.5px;padding:1px 7px;border-radius:99px">
                        +{{ $pelanggaranHariIni }} hari ini
                    </span>
                </p>
                <a href="{{ route('admin.pelanggaran.index') }}" class="btn btn-ghost">Semua</a>
            </div>
            <div class="panel-body">
                @forelse($pelanggaranTerbaru as $p)
                @php $inisial = strtoupper(substr($p->siswa->nama_lengkap ?? 'S', 0, 1)); @endphp
                <div class="pel-row">
                    <div class="pel-avatar">{{ $inisial }}</div>
                    <div class="pel-info">
                        <div class="pel-name">{{ $p->siswa->nama_lengkap ?? '—' }}</div>
                        <div class="pel-meta">
                            {{ $p->kategori->nama_kategori ?? '—' }} · {{ $p->siswa->kelas->nama_kelas ?? '—' }}
                            · {{ \Carbon\Carbon::parse($p->tanggal)->locale('id')->isoFormat('D MMM') }}
                        </div>
                    </div>
                    @php
                        $poin = $p->poin ?? 0;
                        $cat  = $poin >= 15 ? 'berat' : ($poin >= 8 ? 'sedang' : 'ringan');
                    @endphp
                    <span class="badge badge-{{ $cat }}">
                        <span class="badge-dot"></span>{{ ucfirst($cat) }}
                    </span>
                </div>
                @empty
                <div class="empty">
                    <div class="empty-icon">✅</div>
                    <p class="empty-text">Tidak ada pelanggaran terbaru</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Izin Keluar + Tugas --}}
        <div style="display:flex;flex-direction:column;gap:16px">
            {{-- Izin Keluar --}}
            <div class="panel">
                <div class="panel-head">
                    <p class="section-title">
                        <svg width="13" height="13" fill="none" stroke="var(--orange)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Izin Keluar Siswa
                    </p>
                    <a href="{{ route('admin.izin-keluar-siswa.index') }}" class="btn btn-ghost">Semua</a>
                </div>
                <div class="izin-summary">
                    <div class="izin-card menunggu">
                        <div class="izin-card-icon">
                            <svg width="16" height="16" fill="none" stroke="var(--yellow)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div>
                            <div class="izin-card-val">{{ $izinMenunggu }}</div>
                            <div class="izin-card-label">Menunggu Persetujuan</div>
                        </div>
                    </div>
                    <div class="izin-card keluar">
                        <div class="izin-card-icon">
                            <svg width="16" height="16" fill="none" stroke="var(--red)" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        </div>
                        <div>
                            <div class="izin-card-val">{{ $izinSedangKeluar }}</div>
                            <div class="izin-card-label">Sedang di Luar</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tugas & Pengumpulan --}}
            <div class="panel">
                <div class="panel-head">
                    <p class="section-title">
                        <svg width="13" height="13" fill="none" stroke="var(--yellow)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Tugas & Pengumpulan
                    </p>
                    <a href="{{ route('admin.tugas.index') }}" class="btn btn-ghost">Semua</a>
                </div>
                <div class="panel-body">
                    <div class="tugas-row">
                        <span class="tugas-label">Total Tugas Dipublikasikan</span>
                        <span class="tugas-val">{{ $totalTugas }}</span>
                    </div>
                    <div class="tugas-row">
                        <span class="tugas-label" style="color:var(--red)">Belum Dinilai</span>
                        <span class="tugas-val" style="color:var(--red)">{{ $tugasBelumDinilai }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Siswa Rawan Pelanggaran --}}
        <div class="panel">
            <div class="panel-head">
                <p class="section-title">
                    <svg width="13" height="13" fill="none" stroke="var(--orange)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Siswa Rawan Pelanggaran
                    <span style="font-size:10.5px;color:var(--text4);font-weight:500">tahun ini</span>
                </p>
            </div>
            <div class="panel-body">
                @php $maxPel = $siswaRawanPelanggaran->first()?->total_pelanggaran ?? 1; @endphp
                @forelse($siswaRawanPelanggaran as $i => $s)
                <div class="rawan-row">
                    @php $rankClass = $i === 0 ? 'rank-1' : ($i === 1 ? 'rank-2' : ($i === 2 ? 'rank-3' : 'rank-n')); @endphp
                    <div class="rank-badge {{ $rankClass }}">{{ $i + 1 }}</div>
                    <div style="flex:1;min-width:0">
                        <div style="font-size:13px;font-weight:700;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $s->nama_lengkap }}</div>
                        <div style="font-size:11.5px;color:var(--text3)">{{ $s->kelas->nama_kelas ?? '—' }}</div>
                    </div>
                    <div class="rawan-bar-wrap">
                        <div class="rawan-bar" style="width:{{ min(100, ($s->total_pelanggaran / $maxPel) * 100) }}%"></div>
                    </div>
                    <div class="rawan-count">{{ $s->total_pelanggaran }}x</div>
                </div>
                @empty
                <div class="empty">
                    <div class="empty-icon">🏆</div>
                    <p class="empty-text">Tidak ada data pelanggaran tahun ini</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Rata-rata Nilai per Kelas --}}
        <div class="panel">
            <div class="panel-head">
                <p class="section-title">
                    <svg width="13" height="13" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Rata-rata Nilai per Kelas
                </p>
                <a href="{{ route('admin.nilai.index') }}" class="btn btn-ghost">Semua</a>
            </div>
            <div class="panel-body">
                @forelse($rataRataNilaiPerKelas as $i => $nk)
                <div class="nilai-row">
                    <div class="nilai-rank">#{{ $i + 1 }}</div>
                    <div class="nilai-kelas">{{ $nk->nama_kelas ?? 'Kelas ' . ($i + 1) }}</div>
                    <div class="nilai-bar-wrap">
                        <div class="nilai-bar" style="width:{{ min(100, $nk->rata) }}%"></div>
                    </div>
                    <div class="nilai-score">{{ number_format($nk->rata, 1) }}</div>
                </div>
                @empty
                <div class="empty">
                    <div class="empty-icon">📊</div>
                    <p class="empty-text">Belum ada data nilai</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Tren Absensi 7 Hari --}}
        <div class="panel full-width">
            <div class="panel-head">
                <p class="section-title">
                    <svg width="13" height="13" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Tren Absensi 7 Hari Terakhir
                </p>
                <div style="display:flex;gap:12px;flex-wrap:wrap">
                    <span style="display:flex;align-items:center;gap:5px;font-size:11.5px;font-weight:600;color:var(--text3)"><span style="width:8px;height:8px;border-radius:3px;background:#22c55e;display:inline-block"></span>Hadir</span>
                    <span style="display:flex;align-items:center;gap:5px;font-size:11.5px;font-weight:600;color:var(--text3)"><span style="width:8px;height:8px;border-radius:3px;background:#60a5fa;display:inline-block"></span>Izin</span>
                    <span style="display:flex;align-items:center;gap:5px;font-size:11.5px;font-weight:600;color:var(--text3)"><span style="width:8px;height:8px;border-radius:3px;background:#fb923c;display:inline-block"></span>Sakit</span>
                    <span style="display:flex;align-items:center;gap:5px;font-size:11.5px;font-weight:600;color:var(--text3)"><span style="width:8px;height:8px;border-radius:3px;background:#f87171;display:inline-block"></span>Alfa</span>
                </div>
            </div>
            <div class="chart-wrap">
                @php
                    $days = collect();
                    for ($d = 6; $d >= 0; $d--) {
                        $date = now()->subDays($d)->toDateString();
                        $days->push([
                            'date'  => $date,
                            'label' => \Carbon\Carbon::parse($date)->locale('id')->isoFormat('ddd D'),
                            'data'  => $trenAbsensi[$date] ?? ['hadir'=>0,'izin'=>0,'sakit'=>0,'alpha'=>0],
                        ]);
                    }
                    $maxTotal = $days->map(fn($d) => array_sum($d['data']))->max() ?: 1;
                @endphp
                <div class="chart-bars">
                    @foreach($days as $day)
                    @php
                        $h = $day['data']['hadir'];
                        $i = $day['data']['izin'];
                        $s = $day['data']['sakit'];
                        $a = $day['data']['alpha'];
                        $tot = $h + $i + $s + $a;
                        $scale = 96 / $maxTotal;
                    @endphp
                    <div class="bar-group" data-label="{{ $day['label'] }}"
                         title="{{ $day['label'] }}: Hadir {{ $h }}, Izin {{ $i }}, Sakit {{ $s }}, Alfa {{ $a }}">
                        <div class="bar-seg bar-hadir" style="height:{{ round($h * $scale) }}px"></div>
                        <div class="bar-seg bar-izin"  style="height:{{ round($i * $scale) }}px"></div>
                        <div class="bar-seg bar-sakit" style="height:{{ round($s * $scale) }}px"></div>
                        <div class="bar-seg bar-alpha" style="height:{{ round($a * $scale) }}px"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Pengumuman Aktif --}}
        <div class="panel">
            <div class="panel-head">
                <p class="section-title">
                    <svg width="13" height="13" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Pengumuman Aktif
                </p>
                <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-ghost">Semua</a>
            </div>
            <div class="panel-body">
                @forelse($pengumuman as $p)
                <div class="peng-row">
                    <div class="peng-pin">
                        @if($p->dipinned)
                        <svg width="13" height="13" fill="#f59e0b" viewBox="0 0 24 24"><path d="M12 2l2.4 6.6L21 10l-5.1 4.5 1.6 6.5L12 18l-5.5 3 1.6-6.5L3 10l6.6-1.4z"/></svg>
                        @else
                        <svg width="13" height="13" fill="none" stroke="var(--text4)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        @endif
                    </div>
                    <div>
                        <div class="peng-title">{{ $p->judul }}</div>
                        <div class="peng-meta">
                            {{ \Carbon\Carbon::parse($p->dipublikasikan_pada)->locale('id')->isoFormat('D MMM Y') }}
                            @if($p->kadaluarsa_pada)
                            · Kadaluarsa {{ \Carbon\Carbon::parse($p->kadaluarsa_pada)->locale('id')->isoFormat('D MMM Y') }}
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty">
                    <div class="empty-icon">📢</div>
                    <p class="empty-text">Tidak ada pengumuman aktif</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Notifikasi Terbaru --}}
        <div class="panel">
            <div class="panel-head">
                <p class="section-title">
                    <svg width="13" height="13" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    Notifikasi Terbaru
                    @if($unreadNotifikasi > 0)
                        <span style="background:var(--red-bg);color:var(--red);font-size:10.5px;padding:1px 7px;border-radius:99px">{{ $unreadNotifikasi }} baru</span>
                    @endif
                </p>
            </div>
            <div class="panel-body">
                @forelse($notifikasiTerbaru as $n)
                <div style="
                    display:flex;align-items:flex-start;gap:10px;
                    padding:11px 18px;border-bottom:1px solid #f1f5f9;
                    transition:background .12s;
                    {{ !$n->sudah_dibaca ? 'background:#fafbff;' : '' }}
                " onmouseenter="this.style.background='var(--surface2)'" onmouseleave="this.style.background='{{ !$n->sudah_dibaca ? '#fafbff' : 'transparent' }}'">
                    <div style="
                        width:7px;height:7px;border-radius:50%;margin-top:5px;flex-shrink:0;
                        background:{{ $n->sudah_dibaca ? 'var(--border2)' : 'var(--brand-600)' }};
                    "></div>
                    <div style="flex:1;min-width:0">
                        <div style="font-size:13px;font-weight:{{ $n->sudah_dibaca ? '500' : '700' }};color:var(--text);line-height:1.4">{{ $n->pesan ?? $n->judul ?? '—' }}</div>
                        <div style="font-size:11.5px;color:var(--text4);margin-top:2px">{{ \Carbon\Carbon::parse($n->created_at)->diffForHumans() }}</div>
                    </div>
                </div>
                @empty
                <div class="empty">
                    <div class="empty-icon">🔔</div>
                    <p class="empty-text">Tidak ada notifikasi</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>{{-- /main-grid --}}

</div>

<script>
    // Live clock
    function tick() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2,'0');
        const m = String(now.getMinutes()).padStart(2,'0');
        const el = document.getElementById('clock');
        if (el) el.textContent = h + ':' + m;
    }
    tick();
    setInterval(tick, 10000);
</script>
</x-app-layout>