<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#15803d;--green-bg:#dcfce7;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --yellow:#a16207;--yellow-bg:#fefce8;--yellow-border:#fde68a;
        --purple:#7c3aed;--purple-bg:#faf5ff;--purple-border:#e9d5ff;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    .page{padding:28px 28px 48px;font-family:'DM Sans',sans-serif}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    /* Buttons */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap;line-height:1}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-primary:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-detail{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
    .btn-detail:hover{background:#dbeafe;filter:none}
    .btn-qr{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}
    .btn-qr:hover{background:#bbf7d0;filter:none}
    .btn-del{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}
    .btn-del:hover{background:#fecaca;filter:none}
    .btn-nonaktif{background:var(--yellow-bg);color:var(--yellow);border:1px solid var(--yellow-border)}
    .btn-nonaktif:hover{background:#fef9c3;filter:none}
    .btn-print{background:var(--purple-bg);color:var(--purple);border:1px solid var(--purple-border)}
    .btn-print:hover{background:#ede9fe;filter:none}
    /* Tombol buat sesi dinonaktifkan jika ada sesi aktif */
    .btn-primary.blocked{background:#94a3b8;cursor:not-allowed}
    .btn-primary.blocked:hover{filter:none}

    /* Stats */
    .stats-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 18px;display:flex;align-items:center;gap:14px;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .stat-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.blue{background:#eff6ff}
    .stat-icon.green{background:var(--green-bg)}
    .stat-icon.yellow{background:var(--yellow-bg)}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;font-weight:800;color:var(--text);line-height:1.1;margin-top:2px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px;font-family:'DM Sans',sans-serif}

    /* Banner sesi aktif sedang berjalan */
    .sesi-aktif-banner{background:linear-gradient(135deg,#fff7ed 0%,#ffedd5 100%);border:1.5px solid #fed7aa;border-radius:var(--radius);padding:14px 18px;margin-bottom:16px;display:flex;align-items:center;gap:14px}
    .sesi-aktif-banner-dot{width:10px;height:10px;border-radius:50%;background:#ea580c;box-shadow:0 0 0 3px #ffedd5;flex-shrink:0;animation:pulse-orange 1.5s infinite}
    @keyframes pulse-orange{0%,100%{box-shadow:0 0 0 3px #ffedd5}50%{box-shadow:0 0 0 6px #fed7aa}}
    .sesi-aktif-banner-text{flex:1}
    .sesi-aktif-banner-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:#9a3412}
    .sesi-aktif-banner-sub{font-size:12px;color:#c2410c;margin-top:2px;font-family:'DM Sans',sans-serif}
    .btn-goto-aktif{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;background:#ea580c;color:#fff;border:none;border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;text-decoration:none;white-space:nowrap;transition:filter .15s}
    .btn-goto-aktif:hover{filter:brightness(.9)}

    /* Jadwal hari ini banner */
    .jadwal-banner{background:linear-gradient(135deg,#eef6ff 0%,#f0fdf4 100%);border:1px solid var(--brand-100);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px}
    .jadwal-banner-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--brand-600);text-transform:uppercase;letter-spacing:.06em;margin-bottom:12px;display:flex;align-items:center;gap:7px}
    .jadwal-list{display:flex;flex-wrap:wrap;gap:8px}
    .jadwal-chip{display:inline-flex;align-items:center;gap:8px;padding:7px 12px;background:#fff;border:1px solid var(--border);border-radius:8px;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text2)}
    .jadwal-chip-mapel{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text);font-size:12.5px}
    .jadwal-chip-time{font-size:11.5px;color:var(--text3)}
    .jadwal-chip .btn-xs{padding:4px 10px;font-size:11px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;border:none;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:4px}
    .jadwal-chip .btn-xs-primary{background:var(--brand-600);color:#fff}
    .jadwal-chip .btn-xs-success{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}
    .jadwal-chip .btn-xs-gray{background:var(--surface2);color:var(--text3);border:1px solid var(--border);cursor:default}

    /* Filter */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px}
    .filter-row{display:flex;flex-wrap:wrap;gap:8px;align-items:center}
    .filter-row select,.filter-row input[type="date"]{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row select:focus,.filter-row input:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1;min-width:10px}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:6px}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center}

    /* Cards */
    .sesi-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(310px,1fr));gap:14px}
    .sesi-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:box-shadow .2s,transform .2s;display:flex;flex-direction:column}
    .sesi-card:hover{box-shadow:0 6px 24px rgba(0,0,0,.08);transform:translateY(-1px)}
    .sesi-card-top{height:4px}
    .sesi-card-top.aktif{background:linear-gradient(90deg,#22c55e,#4ade80)}
    .sesi-card-top.expired{background:linear-gradient(90deg,#f87171,#fca5a5)}
    .sesi-card-header{padding:14px 16px 10px;display:flex;align-items:flex-start;justify-content:space-between;gap:10px}
    .sesi-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text);line-height:1.3}
    .sesi-card-mapel{font-size:12px;color:var(--text3);margin-top:2px;font-family:'DM Sans',sans-serif}
    /* Label pembuat (admin) */
    .badge-admin{display:inline-flex;align-items:center;gap:4px;padding:2px 7px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:700;color:#15803d;margin-top:4px}
    .sesi-card-body{padding:0 16px 14px;display:flex;flex-direction:column;gap:7px;flex:1}
    .info-row{display:flex;align-items:center;gap:7px;font-size:12.5px;color:var(--text2);font-family:'DM Sans',sans-serif}
    .info-row svg{flex-shrink:0;opacity:.5}
    .kode-qr{font-family:'DM Mono',monospace;font-size:11px;background:var(--surface2);padding:3px 8px;border-radius:5px;color:var(--text2);letter-spacing:.05em;border:1px solid var(--border);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:160px;display:inline-block}
    .scan-bar{margin-top:4px}
    .scan-bar-label{display:flex;justify-content:space-between;font-size:11px;color:var(--text3);margin-bottom:4px;font-family:'DM Sans',sans-serif}
    .scan-bar-track{height:5px;background:var(--surface3);border-radius:99px;overflow:hidden}
    .scan-bar-fill{height:100%;border-radius:99px;background:linear-gradient(90deg,var(--brand-500),#22c55e);transition:width .4s}
    .sesi-card-footer{padding:10px 16px;border-top:1px solid var(--surface3);display:flex;gap:6px;flex-wrap:wrap}

    /* Badge */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-aktif{background:var(--green-bg);color:var(--green)}.badge-aktif .badge-dot{background:var(--green)}
    .badge-expired{background:var(--red-bg);color:var(--red)}.badge-expired .badge-dot{background:var(--red)}

    /* Empty */
    .empty-box{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:64px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3);font-family:'DM Sans',sans-serif}

    /* Pagination */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:16px 0;flex-wrap:wrap;gap:10px;margin-top:4px}
    .pag-info{font-size:12.5px;color:var(--text3);font-family:'DM Sans',sans-serif}
    .pag-btns{display:flex;gap:4px;align-items:center}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}

    /* Alert */
    .alert{padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-size:13px;font-family:'DM Sans',sans-serif;display:flex;align-items:center;gap:8px}
    .alert-success{background:#f0fdf4;border:1px solid var(--green-border);color:#166534}
    .alert-error{background:var(--red-bg);border:1px solid var(--red-border);color:#991b1b}

    /* Section label */
    .section-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.06em;margin-bottom:12px;display:flex;align-items:center;gap:8px}
    .section-label::after{content:'';flex:1;height:1px;background:var(--border)}

    @media(max-width:640px){
        .stats-strip{grid-template-columns:1fr 1fr}
        .page{padding:16px}
        .sesi-grid{grid-template-columns:1fr}
        .filter-sep{display:none}
        .page-header{flex-direction:column}
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Sesi QR Absensi</h1>
            <p class="page-sub">Kelola sesi QR code untuk absensi digital siswa per jadwal pelajaran</p>
        </div>
        <div class="header-actions">
            @if($adaSesiAktif)
            {{-- Ada sesi aktif: tombol buat sesi dikunci, arahkan ke sesi aktif --}}
            <span class="btn btn-primary blocked" title="Ada sesi QR aktif yang sedang berjalan">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Buat Sesi QR
            </span>
            @else
            <a href="{{ route('guru.sesi-qr.create') }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buat Sesi QR
            </a>
            @endif
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Sesi</p>
                <p class="stat-val">{{ $stats['total'] }}</p>
                <p class="stat-sub">semua waktu</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Aktif</p>
                <p class="stat-val">{{ $stats['aktif'] }}</p>
                <p class="stat-sub">sedang berjalan</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Hari Ini</p>
                <p class="stat-val">{{ $stats['hari_ini'] }}</p>
                <p class="stat-sub">{{ ucfirst($hariIni) }}</p>
            </div>
        </div>
    </div>

    {{-- Banner sesi sedang aktif (dari admin maupun guru sendiri) --}}
    @php
        $sesiSedangAktif = $sesiPerJadwal->first(fn($s) => \Carbon\Carbon::parse($s->kadaluarsa_pada)->isFuture());
    @endphp
    @if($sesiSedangAktif)
    <div class="sesi-aktif-banner">
        <div class="sesi-aktif-banner-dot"></div>
        <div class="sesi-aktif-banner-text">
            <p class="sesi-aktif-banner-title">Sesi QR Sedang Berjalan</p>
            <p class="sesi-aktif-banner-sub">
                {{ $sesiSedangAktif->mataPelajaran->nama_mapel ?? '—' }} ·
                {{ $sesiSedangAktif->kelas->nama_kelas ?? '—' }} ·
                Berakhir pukul {{ \Carbon\Carbon::parse($sesiSedangAktif->kadaluarsa_pada)->format('H:i') }}
            </p>
        </div>
        <a href="{{ route('guru.barcode-kelas.show-sesi', $sesiSedangAktif->id) }}" class="btn-goto-aktif">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Tayangkan QR
        </a>
    </div>
    @endif

    {{-- Jadwal hari ini banner --}}
    @if($jadwalHariIni->count() > 0)
    <div class="jadwal-banner">
        <div class="jadwal-banner-title">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Jadwal Hari Ini — {{ ucfirst($hariIni) }}
        </div>
        <div class="jadwal-list">
            @foreach($jadwalHariIni as $jadwal)
            @php $sesiAktif = $sesiPerJadwal[$jadwal->id] ?? null; @endphp
            <div class="jadwal-chip">
                <div>
                    <div class="jadwal-chip-mapel">{{ $jadwal->mataPelajaran->nama_mapel ?? '—' }}</div>
                    <div class="jadwal-chip-time">{{ $jadwal->kelas->nama_kelas ?? '—' }} · {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</div>
                </div>
                @if($sesiAktif)
                    <a href="{{ route('guru.barcode-kelas.show-sesi', $sesiAktif) }}" class="btn-xs btn-xs-success">
                        <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Lihat QR
                    </a>
                @elseif(!$adaSesiAktif)
                    <a href="{{ route('guru.sesi-qr.create', ['jadwal_pelajaran_id' => $jadwal->id]) }}" class="btn-xs btn-xs-primary">
                        <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Buat QR
                    </a>
                @else
                    <span class="btn-xs btn-xs-gray">Terkunci</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Filter --}}
    <div class="filter-card">
        <p class="filter-label">Filter Sesi</p>
        <form method="GET" action="{{ route('guru.sesi-qr.index') }}">
            <div class="filter-row">
                <select name="kelas_id" style="min-width:140px">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}">
                <select name="status" style="min-width:140px">
                    <option value="">Semua Status</option>
                    <option value="aktif"   {{ request('status') === 'aktif'   ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif"{{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('guru.sesi-qr.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Terapkan
                </button>
            </div>
        </form>
    </div>

    {{-- Daftar Sesi --}}
    @if($sesiList->count() > 0)

    <div class="section-label">{{ $sesiList->total() }} Sesi Ditemukan</div>

    <div class="sesi-grid">
        @foreach($sesiList as $s)
        @php
            $isExpired = \Carbon\Carbon::parse($s->kadaluarsa_pada)->isPast() || !$s->is_active;
            $scanCount = $s->riwayatScan->count();
            $totalSiswa = $s->kelas?->siswa()->count() ?? 0;
            $pct = $totalSiswa > 0 ? round(($scanCount / $totalSiswa) * 100) : 0;
            $dibuatOlehAdmin = $s->dibuat_oleh !== Auth::id();
        @endphp
        <div class="sesi-card">
            <div class="sesi-card-top {{ $isExpired ? 'expired' : 'aktif' }}"></div>
            <div class="sesi-card-header">
                <div style="flex:1;min-width:0">
                    <p class="sesi-card-title">{{ $s->kelas->nama_kelas ?? '—' }}</p>
                    <p class="sesi-card-mapel">{{ $s->mataPelajaran->nama_mapel ?? 'Semua Mapel' }}</p>
                    @if($dibuatOlehAdmin)
                    <span class="badge-admin">
                        <svg width="9" height="9" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Dibuat Admin
                    </span>
                    @endif
                </div>
                <span class="badge {{ $isExpired ? 'badge-expired' : 'badge-aktif' }}">
                    <span class="badge-dot"></span>{{ $isExpired ? 'Kedaluwarsa' : 'Aktif' }}
                </span>
            </div>
            <div class="sesi-card-body">
                <div class="info-row">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ \Carbon\Carbon::parse($s->tanggal)->translatedFormat('l, d M Y') }}
                </div>
                <div class="info-row">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ \Carbon\Carbon::parse($s->berlaku_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($s->kadaluarsa_pada)->format('H:i') }}
                    <span style="font-size:11px;color:var(--text3)">({{ \Carbon\Carbon::parse($s->berlaku_mulai)->diffInMinutes($s->kadaluarsa_pada) }} menit)</span>
                </div>
                @if($s->radius_meter)
                <div class="info-row">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/></svg>
                    Radius {{ $s->radius_meter }} meter
                </div>
                @endif
                <div class="info-row">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    <span class="kode-qr">{{ $s->kode_qr ?? '—' }}</span>
                </div>

                {{-- Progress scan --}}
                <div class="scan-bar">
                    <div class="scan-bar-label">
                        <span>{{ $scanCount }} siswa scan</span>
                        <span>{{ $totalSiswa > 0 ? $pct.'%' : '—' }}</span>
                    </div>
                    <div class="scan-bar-track">
                        <div class="scan-bar-fill" style="width:{{ $pct }}%"></div>
                    </div>
                </div>
            </div>
            <div class="sesi-card-footer">
                <a href="{{ route('guru.sesi-qr.show', $s->id) }}" class="btn btn-sm btn-detail">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Detail
                </a>
                @if(!$isExpired)
                <a href="{{ route('guru.barcode-kelas.show-sesi', $s->id) }}" class="btn btn-sm btn-qr">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Tayangkan QR
                </a>
                @endif
                <a href="{{ route('guru.sesi-qr.cetak-qr', $s->id) }}" target="_blank" class="btn btn-sm btn-print">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Cetak
                </a>
                @if(!$isExpired)
                <form action="{{ route('guru.sesi-qr.nonaktifkan', $s->id) }}" method="POST" style="display:inline">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-nonaktif"
                        onclick="return confirm('Nonaktifkan sesi QR ini?')">Nonaktifkan</button>
                </form>
                @endif
                @if(!$dibuatOlehAdmin)
                {{-- Hapus hanya boleh jika guru sendiri yang buat --}}
                <form action="{{ route('guru.sesi-qr.destroy', $s->id) }}" method="POST" id="delForm-{{ $s->id }}" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-sm btn-del"
                        onclick="confirmDel('{{ $s->id }}','{{ $s->kelas->nama_kelas ?? '' }}','{{ \Carbon\Carbon::parse($s->tanggal)->format('d M Y') }}')">
                        Hapus
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($sesiList->hasPages())
    <div class="pag-wrap">
        <p class="pag-info">Menampilkan {{ $sesiList->firstItem() }}–{{ $sesiList->lastItem() }} dari {{ $sesiList->total() }} sesi</p>
        <div class="pag-btns">
            @if($sesiList->onFirstPage())
                <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
            @else
                <a href="{{ $sesiList->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
            @endif
            @foreach($sesiList->getUrlRange(1, $sesiList->lastPage()) as $page => $url)
                @if($page == $sesiList->currentPage())
                    <span class="pag-btn active">{{ $page }}</span>
                @elseif($page == 1 || $page == $sesiList->lastPage() || abs($page - $sesiList->currentPage()) <= 1)
                    <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                @elseif(abs($page - $sesiList->currentPage()) == 2)
                    <span class="pag-ellipsis">…</span>
                @endif
            @endforeach
            @if($sesiList->hasMorePages())
                <a href="{{ $sesiList->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
            @else
                <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
            @endif
        </div>
    </div>
    @endif

    @else
    <div class="empty-box">
        <div class="empty-icon">
            <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        </div>
        <p class="empty-title">Belum ada sesi QR</p>
        <p class="empty-sub" style="margin-bottom:16px">Buat sesi QR pertama untuk mengaktifkan absensi digital</p>
        @if(!$adaSesiAktif)
        <a href="{{ route('guru.sesi-qr.create') }}" class="btn btn-primary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Buat Sesi QR Baru
        </a>
        @endif
    </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDel(id, kelas, tanggal) {
    Swal.fire({
        title: 'Hapus Sesi QR?',
        html: `Sesi kelas <strong>${kelas}</strong> tanggal <strong>${tanggal}</strong> akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) document.getElementById('delForm-' + id).submit(); });
}
</script>
</x-app-layout>