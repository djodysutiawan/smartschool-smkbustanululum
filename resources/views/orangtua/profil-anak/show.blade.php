<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand: #1f63db;
        --brand-50: #eef6ff;
        --brand-100: #d9ebff;
        --brand-700: #1750c0;
        --surface: #fff;
        --surface2: #f8fafc;
        --surface3: #f1f5f9;
        --border: #e2e8f0;
        --border2: #cbd5e1;
        --text: #0f172a;
        --text2: #475569;
        --text3: #94a3b8;
        --radius: 12px;
        --radius-sm: 8px;
    }

    * { box-sizing: border-box; }

    .page { padding: 28px 28px 64px; max-width: 1300px; margin: 0 auto; }

    /* Breadcrumb */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text3);
        margin-bottom: 20px;
    }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    /* Hero */
    .profil-hero {
        background: linear-gradient(135deg, #1d58c8 0%, #3b82f6 60%, #60a5fa 100%);
        border-radius: var(--radius);
        padding: 26px 28px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 22px;
        flex-wrap: wrap;
        position: relative;
        overflow: hidden;
    }
    .profil-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }
    .hero-avatar {
        width: 70px;
        height: 70px;
        border-radius: 18px;
        background: rgba(255,255,255,.2);
        border: 2px solid rgba(255,255,255,.35);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 24px;
        font-weight: 800;
        flex-shrink: 0;
        letter-spacing: -.5px;
        position: relative;
    }
    .hero-avatar.perempuan { background: rgba(255,255,255,.25); }
    .hero-name {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 21px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -.3px;
    }
    .hero-sub { font-size: 13px; color: rgba(255,255,255,.7); margin-top: 4px; }
    .hero-chips { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 10px; }
    .hero-chip {
        background: rgba(255,255,255,.2);
        color: #fff;
        border-radius: 99px;
        padding: 4px 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid rgba(255,255,255,.2);
    }
    .btn-back {
        margin-left: auto;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.3);
        color: #fff;
        border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        transition: background .15s;
        position: relative;
        white-space: nowrap;
    }
    .btn-back:hover { background: rgba(255,255,255,.25); }

    /* Stats strip */
    .stats-strip {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }
    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: border-color .15s;
    }
    .stat-card:hover { border-color: var(--border2); }
    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .si-green { background: #f0fdf4; }
    .si-blue  { background: var(--brand-50); }
    .si-yellow{ background: #fef9c3; }
    .si-red   { background: #fff1f2; }
    .stat-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px;
        font-weight: 600;
        color: var(--text3);
        letter-spacing: .04em;
        text-transform: uppercase;
    }
    .stat-val {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 22px;
        font-weight: 800;
        color: var(--text);
        line-height: 1.1;
        margin-top: 2px;
    }

    /* Detail grid */
    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    /* Card */
    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        margin-bottom: 16px;
    }
    .card:last-child { margin-bottom: 0; }
    .card-header {
        padding: 13px 18px;
        border-bottom: 1px solid var(--border);
        background: var(--surface2);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        flex-wrap: wrap;
    }
    .card-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .card-link {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: var(--brand);
        text-decoration: none;
        white-space: nowrap;
    }
    .card-link:hover { text-decoration: underline; }

    /* Info rows */
    .info-body { padding: 16px 20px; display: flex; flex-direction: column; gap: 11px; }
    .info-row { display: flex; align-items: flex-start; gap: 12px; }
    .info-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11.5px;
        font-weight: 700;
        color: var(--text3);
        text-transform: uppercase;
        letter-spacing: .04em;
        min-width: 120px;
        padding-top: 1px;
        flex-shrink: 0;
    }
    .info-val { font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); flex: 1; }

    /* Absensi grid */
    .abs-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; padding: 16px 18px; }
    .abs-box { text-align: center; padding: 12px 6px; border-radius: var(--radius-sm); border: 1px solid var(--border); }
    .abs-val {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 22px;
        font-weight: 800;
        line-height: 1;
    }
    .abs-label {
        font-size: 10px;
        font-weight: 600;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text3);
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-top: 4px;
    }
    .abs-hadir { background: #f0fdf4; border-color: #bbf7d0; } .abs-hadir .abs-val { color: #15803d; }
    .abs-izin  { background: #dbeafe; border-color: #bfdbfe; } .abs-izin .abs-val  { color: #1d4ed8; }
    .abs-sakit { background: #faf5ff; border-color: #e9d5ff; } .abs-sakit .abs-val { color: #6d28d9; }
    .abs-alfa  { background: #fff1f2; border-color: #fecaca; } .abs-alfa .abs-val  { color: #dc2626; }

    /* Table */
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    thead th {
        padding: 10px 14px;
        text-align: left;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10.5px;
        font-weight: 700;
        color: var(--text3);
        letter-spacing: .05em;
        text-transform: uppercase;
        background: var(--surface2);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }
    thead th.center { text-align: center; }
    tbody tr { border-bottom: 1px solid var(--border); }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fafbff; }
    td { padding: 10px 14px; color: var(--text); vertical-align: middle; }
    td.center { text-align: center; }
    td.muted { color: var(--text3); font-size: 12.5px; }

    .predikat {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        border-radius: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px;
        font-weight: 800;
    }
    .pred-A { background: #dcfce7; color: #15803d; }
    .pred-B { background: var(--brand-50); color: var(--brand-700); }
    .pred-C { background: #fef9c3; color: #a16207; }
    .pred-D, .pred-E { background: #fee2e2; color: #dc2626; }

    /* Absensi history items */
    .abs-item {
        display: flex;
        align-items: center;
        padding: 10px 18px;
        border-bottom: 1px solid var(--border);
        gap: 10px;
    }
    .abs-item:last-child { border-bottom: none; }
    .abs-date {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px;
        font-weight: 700;
        color: var(--text2);
        min-width: 72px;
    }

    /* Badge */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .b-hadir  { background: #dcfce7; color: #15803d; } .b-hadir .badge-dot  { background: #15803d; }
    .b-telat  { background: #fef9c3; color: #a16207; } .b-telat .badge-dot  { background: #a16207; }
    .b-izin   { background: #dbeafe; color: #1d4ed8; } .b-izin .badge-dot   { background: #1d4ed8; }
    .b-sakit  { background: #f3e8ff; color: #6d28d9; } .b-sakit .badge-dot  { background: #6d28d9; }
    .b-alfa   { background: #fee2e2; color: #dc2626; } .b-alfa .badge-dot   { background: #dc2626; }

    .abs-jam { font-size: 11.5px; color: var(--text3); margin-left: auto; }

    /* Tugas items */
    .tugas-item {
        display: flex;
        align-items: flex-start;
        padding: 11px 18px;
        border-bottom: 1px solid var(--border);
        gap: 10px;
    }
    .tugas-item:last-child { border-bottom: none; }
    .tugas-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--brand);
        flex-shrink: 0;
        margin-top: 5px;
    }
    .tugas-dot.late { background: #dc2626; }
    .tugas-dot.urgent { background: #ea580c; }
    .tugas-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 13px;
        color: var(--text);
    }
    .tugas-sub { font-size: 11.5px; color: var(--text3); margin-top: 2px; }
    .tugas-badge { margin-left: auto; flex-shrink: 0; padding-top: 1px; }

    /* Pelanggaran items */
    .pel-item {
        display: flex;
        align-items: flex-start;
        padding: 11px 18px;
        border-bottom: 1px solid var(--border);
        gap: 10px;
    }
    .pel-item:last-child { border-bottom: none; }
    .pel-poin {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        background: #fee2e2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        font-weight: 800;
        flex-shrink: 0;
    }
    .pel-desc {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
    }
    .pel-meta { font-size: 11.5px; color: var(--text3); margin-top: 2px; }

    /* Status badges for pelanggaran */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 1px 7px;
        border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10.5px;
        font-weight: 700;
    }
    .s-pending   { background: #fef9c3; color: #a16207; }
    .s-diproses  { background: var(--brand-50); color: var(--brand-700); }
    .s-selesai   { background: #dcfce7; color: #15803d; }
    .s-banding   { background: #f3e8ff; color: #6d28d9; }

    /* Empty state inline */
    .empty-inline { padding: 24px 20px; text-align: center; color: var(--text3); font-size: 13px; }

    /* Divider */
    .divider { height: 1px; background: var(--border); margin: 0; }

    @media (max-width: 960px) {
        .detail-grid { grid-template-columns: 1fr; }
        .stats-strip { grid-template-columns: 1fr 1fr; }
        .page { padding: 16px 16px 48px; }
    }
    @media (max-width: 480px) {
        .abs-grid { grid-template-columns: 1fr 1fr; }
        .stats-strip { grid-template-columns: 1fr 1fr; }
        .profil-hero { padding: 18px; }
        .btn-back { display: none; }
    }
</style>

<div class="page">
    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('ortu.dashboard') }}">Beranda</a>
        <span class="sep">›</span>
        <a href="{{ route('ortu.profil-anak.index') }}">Profil Anak</a>
        <span class="sep">›</span>
        <span class="current">{{ $anak->nama_lengkap }}</span>
    </nav>

    {{-- Hero ─────────────────────────────────────────────────────── --}}
    @php
        $inisial = collect(explode(' ', $anak->nama_lengkap))
            ->map(fn($w) => strtoupper($w[0] ?? ''))
            ->filter()
            ->take(2)
            ->implode('');
        $isPerempuan = $anak->jenis_kelamin !== 'L';
        $namaKelas = $anak->kelas->nama_kelas ?? $anak->kelas->nama ?? '—';
    @endphp

    <div class="profil-hero">
        <div class="hero-avatar {{ $isPerempuan ? 'perempuan' : '' }}">{{ $inisial }}</div>
        <div style="flex: 1; min-width: 0;">
            <p class="hero-name">{{ $anak->nama_lengkap }}</p>
            <p class="hero-sub">
                NIS: {{ $anak->nis ?? '—' }}
                @if($anak->nisn) · NISN: {{ $anak->nisn }} @endif
                @if($anak->pengguna?->email) · {{ $anak->pengguna->email }} @endif
            </p>
            <div class="hero-chips">
                <span class="hero-chip">🏫 {{ $namaKelas }}</span>
                <span class="hero-chip">{{ $isPerempuan ? '👧 Perempuan' : '👦 Laki-laki' }}</span>
                @if($anak->tanggal_lahir)
                    <span class="hero-chip">🎂 {{ $anak->tanggal_lahir->translatedFormat('d M Y') }}</span>
                @endif
            </div>
        </div>
        <a href="{{ route('ortu.profil-anak.index') }}" class="btn-back">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Stats strip ──────────────────────────────────────────────── --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon si-green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Hadir Bulan Ini</p>
                <p class="stat-val" style="color:#15803d">{{ $absensiSummary['hadir'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Rata-rata Nilai</p>
                <p class="stat-val">{{ $rataRataNilai ? number_format($rataRataNilai, 1) : '—' }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Tugas Pending</p>
                <p class="stat-val" style="{{ $tugasBelum->count() > 0 ? 'color:#a16207' : '' }}">
                    {{ $tugasBelum->count() }}
                </p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Poin Pelanggaran</p>
                <p class="stat-val" style="{{ $totalPoinPelanggaran > 0 ? 'color:#dc2626' : '' }}">
                    {{ $totalPoinPelanggaran }}
                </p>
            </div>
        </div>
    </div>

    {{-- Detail Grid ──────────────────────────────────────────────── --}}
    <div class="detail-grid">

        {{-- ══════════════ KOLOM KIRI ══════════════ --}}
        <div>

            {{-- Informasi Pribadi --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                        Informasi Pribadi
                    </span>
                </div>
                <div class="info-body">
                    <div class="info-row">
                        <span class="info-label">Nama Lengkap</span>
                        <span class="info-val" style="font-weight:700">{{ $anak->nama_lengkap }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">NIS</span>
                        <span class="info-val">{{ $anak->nis ?? '—' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">NISN</span>
                        <span class="info-val">{{ $anak->nisn ?? '—' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kelas</span>
                        <span class="info-val">{{ $namaKelas }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jenis Kelamin</span>
                        <span class="info-val">{{ $isPerempuan ? 'Perempuan' : 'Laki-laki' }}</span>
                    </div>
                    @if($anak->tempat_lahir)
                        <div class="info-row">
                            <span class="info-label">Tempat Lahir</span>
                            <span class="info-val">{{ $anak->tempat_lahir }}</span>
                        </div>
                    @endif
                    @if($anak->tanggal_lahir)
                        <div class="info-row">
                            <span class="info-label">Tanggal Lahir</span>
                            {{-- tanggal_lahir sudah di-cast ke date di model Siswa --}}
                            <span class="info-val">{{ $anak->tanggal_lahir->translatedFormat('d F Y') }}</span>
                        </div>
                    @endif
                    @if($anak->alamat)
                        <div class="info-row">
                            <span class="info-label">Alamat</span>
                            <span class="info-val">{{ $anak->alamat }}</span>
                        </div>
                    @endif
                    @if($anak->pengguna?->email)
                        <div class="info-row">
                            <span class="info-label">Email Akun</span>
                            <span class="info-val">{{ $anak->pengguna->email }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Rekap Absensi Bulan Ini --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                            <line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/>
                        </svg>
                        Rekap Absensi {{ now()->translatedFormat('F Y') }}
                    </span>
                    <a href="{{ route('ortu.absensi.rekap') }}" class="card-link">Rekap Lengkap →</a>
                </div>
                <div class="abs-grid">
                    <div class="abs-box abs-hadir">
                        <p class="abs-val">{{ $absensiSummary['hadir'] }}</p>
                        <p class="abs-label">Hadir</p>
                    </div>
                    <div class="abs-box abs-izin">
                        <p class="abs-val">{{ $absensiSummary['izin'] }}</p>
                        <p class="abs-label">Izin</p>
                    </div>
                    <div class="abs-box abs-sakit">
                        <p class="abs-val">{{ $absensiSummary['sakit'] }}</p>
                        <p class="abs-label">Sakit</p>
                    </div>
                    <div class="abs-box abs-alfa">
                        <p class="abs-val">{{ $absensiSummary['alfa'] }}</p>
                        <p class="abs-label">Alfa</p>
                    </div>
                </div>
            </div>

            {{-- Riwayat Absensi Terbaru --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Kehadiran Terbaru
                    </span>
                    <a href="{{ route('ortu.absensi.riwayat') }}" class="card-link">Riwayat Lengkap →</a>
                </div>
                @forelse($absensiTerbaru as $a)
                    @php
                        $bc = match($a->status) {
                            'hadir' => 'b-hadir',
                            'telat' => 'b-telat',
                            'izin'  => 'b-izin',
                            'sakit' => 'b-sakit',
                            'alfa'  => 'b-alfa',
                            default => 'b-hadir',
                        };
                        // tanggal sudah di-cast ke date — langsung pakai Carbon method
                        $tglFormatted = $a->tanggal->translatedFormat('d M Y');
                    @endphp
                    <div class="abs-item">
                        <span class="abs-date">{{ $tglFormatted }}</span>
                        <span class="badge {{ $bc }}">
                            <span class="badge-dot"></span>
                            {{ $a->label_status }}
                        </span>
                        @if($a->jam_masuk)
                            <span class="abs-jam">{{ $a->jam_masuk->format('H:i') }}</span>
                        @endif
                    </div>
                @empty
                    <div class="empty-inline">Belum ada data absensi</div>
                @endforelse
            </div>

        </div>{{-- /kolom kiri --}}

        {{-- ══════════════ KOLOM KANAN ══════════════ --}}
        <div>

            {{-- Nilai Mata Pelajaran --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                        </svg>
                        Nilai Mata Pelajaran
                    </span>
                    <a href="{{ route('ortu.akademik.nilai') }}" class="card-link">Detail →</a>
                </div>
                @if($nilaiList->count())
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <th class="center">Tugas</th>
                                    <th class="center">Harian</th>
                                    <th class="center">UTS</th>
                                    <th class="center">UAS</th>
                                    <th class="center">Akhir</th>
                                    <th class="center">Ket</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nilaiList->take(8) as $n)
                                    <tr>
                                        <td style="font-weight:600; font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px">
                                            {{ $n->mataPelajaran->nama_mapel ?? '—' }}
                                        </td>
                                        <td class="center muted">{{ $n->nilai_tugas !== null ? number_format($n->nilai_tugas, 0) : '—' }}</td>
                                        <td class="center muted">{{ $n->nilai_harian !== null ? number_format($n->nilai_harian, 0) : '—' }}</td>
                                        <td class="center muted">{{ $n->nilai_uts !== null ? number_format($n->nilai_uts, 0) : '—' }}</td>
                                        <td class="center muted">{{ $n->nilai_uas !== null ? number_format($n->nilai_uas, 0) : '—' }}</td>
                                        <td class="center">
                                            <strong>{{ $n->nilai_akhir_formatted }}</strong>
                                        </td>
                                        <td class="center">
                                            @if($n->predikat)
                                                <span class="predikat pred-{{ $n->predikat }}">{{ $n->predikat }}</span>
                                            @else
                                                <span class="muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($nilaiList->count() > 8)
                        <div style="padding:10px 18px; border-top:1px solid var(--border); text-align:center;">
                            <a href="{{ route('ortu.akademik.nilai') }}" class="card-link">
                                Lihat {{ $nilaiList->count() - 8 }} mata pelajaran lainnya →
                            </a>
                        </div>
                    @endif
                @else
                    <div class="empty-inline">Belum ada data nilai</div>
                @endif
            </div>

            {{-- Tugas Belum Dikumpulkan --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Tugas Belum Dikumpulkan
                        @if($tugasBelum->count() > 0)
                            <span style="background:#fef9c3;color:#a16207;border-radius:99px;padding:1px 7px;font-size:10.5px;font-weight:700">
                                {{ $tugasBelum->count() }}
                            </span>
                        @endif
                    </span>
                    <a href="{{ route('ortu.akademik.tugas') }}" class="card-link">Semua →</a>
                </div>
                @forelse($tugasBelum as $t)
                    @php
                        // diffInDays positif = masih ada waktu, negatif = sudah lewat
                        $sisaHari = now()->diffInDays($t->batas_waktu, false);
                        $isUrgent = $sisaHari >= 0 && $sisaHari <= 2;
                    @endphp
                    <div class="tugas-item">
                        <div class="tugas-dot {{ $isUrgent ? 'urgent' : '' }}"></div>
                        <div style="flex:1; min-width:0">
                            <p class="tugas-title" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                {{ $t->judul }}
                            </p>
                            <p class="tugas-sub">
                                {{ $t->mataPelajaran->nama_mapel ?? '—' }}
                                · {{ $t->batas_waktu->translatedFormat('d M Y, H:i') }}
                            </p>
                        </div>
                        @if($isUrgent)
                            <div class="tugas-badge">
                                <span class="badge b-telat">
                                    {{ $sisaHari == 0 ? 'Hari ini' : $sisaHari . 'h lagi' }}
                                </span>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="empty-inline">🎉 Semua tugas sudah dikumpulkan</div>
                @endforelse

                {{-- Tugas terlambat (opsional: tampilkan sebagai peringatan) --}}
                @if($tugasTerlambat->count() > 0)
                    <div style="padding:10px 18px;border-top:1px solid var(--border);background:#fff9f9">
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:#dc2626;margin-bottom:6px">
                            ⚠ Melewati batas waktu ({{ $tugasTerlambat->count() }} tugas)
                        </p>
                        @foreach($tugasTerlambat as $tl)
                            <p style="font-size:12px;color:#ef4444;margin-bottom:3px">
                                {{ $tl->judul }}
                                <span style="color:#fca5a5">· {{ $tl->mataPelajaran->nama_mapel ?? '—' }}</span>
                            </p>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Pelanggaran Tahun Ini --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                        Pelanggaran Tahun Ini
                        @if($totalPoinPelanggaran > 0)
                            <span style="background:#fee2e2;color:#dc2626;border-radius:99px;padding:1px 7px;font-size:10.5px;font-weight:700">
                                {{ $totalPoinPelanggaran }} poin
                            </span>
                        @endif
                    </span>
                    <a href="{{ route('ortu.kedisiplinan.riwayat') }}" class="card-link">Riwayat →</a>
                </div>
                @forelse($pelanggaranList as $p)
                    @php
                        $statusClass = match($p->status) {
                            'pending'    => 's-pending',
                            'diproses'   => 's-diproses',
                            'selesai'    => 's-selesai',
                            'banding'    => 's-banding',
                            default      => 's-pending',
                        };
                        // tanggal sudah di-cast ke date di model Pelanggaran
                        $tglPel = $p->tanggal->translatedFormat('d M Y');
                    @endphp
                    <div class="pel-item">
                        <div class="pel-poin">{{ $p->poin }}</div>
                        <div style="flex:1; min-width:0">
                            <p class="pel-desc">
                                {{ $p->kategori->nama_kategori ?? 'Pelanggaran' }}
                            </p>
                            <p class="pel-meta">
                                {{ $tglPel }}
                                ·
                                <span class="status-badge {{ $statusClass }}">{{ ucfirst($p->status) }}</span>
                            </p>
                            @if($p->deskripsi)
                                <p style="font-size:11.5px;color:var(--text3);margin-top:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                    {{ $p->deskripsi }}
                                </p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-inline">✅ Tidak ada catatan pelanggaran tahun ini</div>
                @endforelse
            </div>

        </div>{{-- /kolom kanan --}}
    </div>{{-- /detail-grid --}}
</div>
</x-app-layout>