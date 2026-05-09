<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Instrument+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');

    :root {
        --s-800:#0f2044;--s-700:#1a3a6b;--s-600:#1d4ed8;--s-500:#2563eb;
        --s-400:#3b82f6;--s-300:#93c5fd;--s-100:#dbeafe;--s-50:#eff6ff;
        --g-500:#10b981;--g-400:#34d399;--g-100:#d1fae5;--g-50:#ecfdf5;
        --a-500:#f59e0b;--a-100:#fef3c7;--a-50:#fffbeb;
        --r-500:#ef4444;--r-100:#fee2e2;--r-50:#fff5f5;
        --v-500:#8b5cf6;--v-100:#ede9fe;--v-50:#f5f3ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#334155;--text3:#64748b;--text4:#94a3b8;
        --radius:12px;--radius-sm:8px;--radius-xs:6px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.07);
        --shadow-md:0 4px 16px rgba(0,0,0,.08);
    }

    * { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Instrument Sans', sans-serif; }

    .page { padding:24px 28px 64px; max-width:2000px; }

    /* ── Back link ── */
    .back-link {
        display:inline-flex; align-items:center; gap:6px;
        font-family:'Outfit',sans-serif; font-size:12.5px; font-weight:700;
        color:var(--text3); text-decoration:none; margin-bottom:20px; transition:color .15s;
    }
    .back-link:hover { color:var(--text); }

    /* ── Hero banner ── */
    .hero {
        border-radius:var(--radius); padding:28px 28px 24px;
        margin-bottom:20px; position:relative; overflow:hidden;
    }
    .hero.masuk  { background:linear-gradient(135deg, var(--s-800) 0%, var(--s-700) 60%, #1e3a8a 100%); }
    .hero.pulang { background:linear-gradient(135deg, #064e3b 0%, #065f46 60%, #047857 100%); }
    .hero.lainnya { background:linear-gradient(135deg, #3b0764 0%, #4c1d95 60%, #5b21b6 100%); }

    .hero::before {
        content:''; position:absolute; top:-50px; right:-50px;
        width:200px; height:200px; border-radius:50%;
        background:rgba(255,255,255,.05); pointer-events:none;
    }
    .hero::after {
        content:''; position:absolute; bottom:-40px; left:-30px;
        width:150px; height:150px; border-radius:50%;
        background:rgba(255,255,255,.04); pointer-events:none;
    }
    .hero-top {
        display:flex; align-items:flex-start; justify-content:space-between;
        gap:12px; position:relative; z-index:1;
    }
    .hero-tipe-badge {
        display:inline-flex; align-items:center; gap:7px;
        background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.2);
        color:#fff; font-family:'Outfit',sans-serif; font-size:12px; font-weight:700;
        padding:5px 12px; border-radius:99px; text-transform:uppercase; letter-spacing:.06em;
    }
    .hero-tipe-dot { width:7px; height:7px; border-radius:50%; background:rgba(255,255,255,.8); }
    .hero-status-badge {
        font-family:'Outfit',sans-serif; font-size:11px; font-weight:700;
        padding:4px 11px; border-radius:99px; text-transform:uppercase; letter-spacing:.04em;
    }
    .badge-normal   { background:rgba(16,185,129,.25);  color:#6ee7b7;  border:1px solid rgba(16,185,129,.3); }
    .badge-manual   { background:rgba(245,158,11,.25);  color:#fcd34d;  border:1px solid rgba(245,158,11,.3); }
    .badge-koreksi  { background:rgba(139,92,246,.25);  color:#c4b5fd;  border:1px solid rgba(139,92,246,.3); }
    .badge-duplikat { background:rgba(239,68,68,.25);   color:#fca5a5;  border:1px solid rgba(239,68,68,.3); }
    .hero-time { position:relative; z-index:1; margin-top:20px; }
    .hero-jam {
        font-family:'Outfit',sans-serif; font-size:52px; font-weight:900;
        color:#fff; line-height:1; letter-spacing:-.02em;
    }
    .hero-jam sup { font-size:20px; font-weight:700; opacity:.6; vertical-align:super; margin-left:2px; }
    .hero-tanggal { font-size:14px; color:rgba(255,255,255,.65); margin-top:8px; }

    /* ── Detail card ── */
    .detail-card {
        background:var(--surface); border:1px solid var(--border);
        border-radius:var(--radius); box-shadow:var(--shadow-sm);
        overflow:hidden; margin-bottom:16px;
    }
    .detail-card-header {
        display:flex; align-items:center; gap:10px;
        padding:14px 20px; border-bottom:1px solid var(--border); background:var(--surface2);
    }
    .detail-card-title {
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:700; color:var(--text2);
    }

    /* ── Row list ── */
    .row-list { display:flex; flex-direction:column; }
    .row-item {
        display:flex; align-items:center; justify-content:space-between;
        padding:14px 20px; border-bottom:1px solid var(--border); gap:16px;
    }
    .row-item:last-child { border-bottom:none; }
    .row-label {
        display:flex; align-items:center; gap:8px;
        font-size:13px; color:var(--text3); min-width:140px; flex-shrink:0;
    }
    .row-label svg { flex-shrink:0; color:var(--text4); }
    .row-val {
        font-family:'Outfit',sans-serif; font-size:13.5px; font-weight:700;
        color:var(--text); text-align:right;
    }
    .row-val.mono {
        font-family:'Instrument Sans', monospace; font-size:12px;
        font-weight:600; color:var(--text3);
    }

    /* ── Chips ── */
    .chip {
        display:inline-flex; align-items:center; gap:5px;
        font-family:'Outfit',sans-serif; font-size:12px; font-weight:700;
        padding:4px 10px; border-radius:99px;
    }
    .chip-masuk  { background:var(--s-50); color:var(--s-600); border:1px solid var(--s-100); }
    .chip-pulang { background:var(--g-50); color:var(--g-500); border:1px solid var(--g-100); }
    .chip-metode-barcode { background:var(--s-50);  color:var(--s-600); border:1px solid var(--s-100); }
    .chip-metode-manual  { background:var(--a-50);  color:#92400e;      border:1px solid var(--a-100); }
    .chip-metode-koreksi { background:var(--v-50);  color:var(--v-500); border:1px solid var(--v-100); }
    /* FIX: chip status via class tunggal — tidak lagi pakai inline style campuran */
    .chip-status-normal   { background:var(--g-50);  color:var(--g-500);  border:1px solid var(--g-100); }
    .chip-status-manual   { background:var(--a-50);  color:#92400e;       border:1px solid var(--a-100); }
    .chip-status-koreksi  { background:var(--v-50);  color:var(--v-500);  border:1px solid var(--v-100); }
    .chip-status-duplikat { background:var(--r-50);  color:var(--r-500);  border:1px solid var(--r-100); }

    /* ── Sesi gerbang ── */
    .sesi-box {
        background:var(--surface2); border:1px solid var(--border);
        border-radius:var(--radius-sm); padding:14px 16px;
        display:flex; align-items:center; gap:14px;
    }
    .sesi-icon {
        width:40px; height:40px; border-radius:10px; flex-shrink:0;
        background:var(--s-50); display:flex; align-items:center; justify-content:center;
    }
    .sesi-info-label {
        font-size:11px; font-weight:700; color:var(--text4);
        text-transform:uppercase; letter-spacing:.06em; margin-bottom:3px;
    }
    .sesi-info-val { font-family:'Outfit',sans-serif; font-size:13.5px; font-weight:700; color:var(--text2); }
    .sesi-info-sub { font-size:12px; color:var(--text4); margin-top:2px; }

    /* ── Notice ── */
    .notice {
        display:flex; align-items:flex-start; gap:10px;
        padding:12px 16px; border-radius:var(--radius-sm);
        font-size:12.5px; line-height:1.6; margin-bottom:4px;
    }
    .notice svg { flex-shrink:0; margin-top:1px; }
    .notice-info    { background:var(--s-50);  border:1px solid var(--s-100);  color:var(--s-700); }
    .notice-warning { background:var(--a-50);  border:1px solid var(--a-100);  color:#92400e; }
    .notice-danger  { background:var(--r-50);  border:1px solid var(--r-100);  color:#991b1b; }

    /* ── Actions ── */
    .action-row { display:flex; gap:10px; margin-top:20px; flex-wrap:wrap; }
    .btn {
        display:inline-flex; align-items:center; gap:7px;
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:700;
        padding:10px 20px; border-radius:var(--radius-sm);
        text-decoration:none; border:none; cursor:pointer; transition:all .15s;
    }
    .btn-primary   { background:var(--s-600); color:#fff; }
    .btn-primary:hover { background:var(--s-700); }
    .btn-secondary { background:var(--surface); color:var(--text2); border:1px solid var(--border); }
    .btn-secondary:hover { background:var(--surface3); }

    @media(max-width:640px) {
        .page { padding:14px 14px 56px; }
        .hero-jam { font-size:40px; }
        .row-item { flex-wrap:wrap; }
        .row-val { text-align:left; }
    }
</style>

<div class="page">

    {{-- ── BACK LINK ── --}}
    {{--
        FIX: Komentar Blade TIDAK boleh berada di dalam blok @php ... @endphp —
        akan menyebabkan parse error. Logika @php dipindahkan murni ke PHP,
        komentar dipindahkan ke luar blok @php sebagai komentar Blade.
    --}}
    @php
        $fromParam  = request('from');
        $backRoute  = $fromParam === 'status-hari-ini'
            ? route('siswa.absensi-gerbang.status-hari-ini')
            : route('siswa.absensi-gerbang.riwayat');
        $backLabel  = $fromParam === 'status-hari-ini'
            ? 'Status Hari Ini'
            : 'Riwayat Absensi Gerbang';
    @endphp
    <a href="{{ $backRoute }}" class="back-link">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <polyline points="15 18 9 12 15 6"/>
        </svg>
        {{ $backLabel }}
    </a>

    {{-- ── HERO BANNER ── --}}
    {{--
        FIX: Semua variabel @php dibersihkan dari komentar Blade {{-- --}} di dalamnya.
        FIX: tanggal diambil dari tanggal_scan (sudah di-cast date) jika tersedia,
             fallback ke waktu_scan — hindari parse(null) → epoch 1970.
        FIX: $siswa->kelas dipakai di view ini, sudah di-loadMissing controller.
    --}}
    @php
        $tipe      = $absensiGerbang->tipe   ?? 'masuk';
        $metode    = $absensiGerbang->metode ?? 'barcode';
        $status    = $absensiGerbang->status ?? 'normal';

        $heroClass = match($tipe) {
            'pulang' => 'pulang',
            'masuk'  => 'masuk',
            default  => 'lainnya',
        };

        $badgeClass = match($status) {
            'manual'   => 'badge-manual',
            'koreksi'  => 'badge-koreksi',
            'duplikat' => 'badge-duplikat',
            default    => 'badge-normal',
        };

        $badgeLabel = match($status) {
            'manual'   => 'Manual',
            'koreksi'  => 'Koreksi',
            'duplikat' => 'Duplikat',
            default    => 'Valid',
        };

        // waktu_scan sudah di-cast datetime — pastikan tetap Carbon
        $waktu = $absensiGerbang->waktu_scan instanceof \Carbon\Carbon
            ? $absensiGerbang->waktu_scan
            : \Carbon\Carbon::parse($absensiGerbang->waktu_scan);

        // tanggal_scan di-cast date (Carbon\CarbonInterface), fallback ke waktu_scan
        if (! is_null($absensiGerbang->tanggal_scan)) {
            $tanggal = $absensiGerbang->tanggal_scan instanceof \Carbon\Carbon
                ? $absensiGerbang->tanggal_scan
                : \Carbon\Carbon::parse($absensiGerbang->tanggal_scan);
        } else {
            $tanggal = $waktu->copy()->startOfDay();
        }

        $metodeLabel = match($metode) {
            'barcode' => 'Scan Barcode',
            'manual'  => 'Input Manual',
            'koreksi' => 'Koreksi Admin',
            default   => ucfirst($metode),
        };

        // chip status — gunakan class CSS tunggal (tidak mix inline style)
        $chipStatusClass = match($status) {
            'manual'   => 'chip-status-manual',
            'koreksi'  => 'chip-status-koreksi',
            'duplikat' => 'chip-status-duplikat',
            default    => 'chip-status-normal',
        };
    @endphp

    <div class="hero {{ $heroClass }}">
        <div class="hero-top">
            <span class="hero-tipe-badge">
                <span class="hero-tipe-dot"></span>
                @if($tipe === 'masuk')
                    Scan Masuk
                @elseif($tipe === 'pulang')
                    Scan Pulang
                @else
                    {{ ucfirst($tipe) }}
                @endif
            </span>
            <span class="hero-status-badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
        </div>
        <div class="hero-time">
            <p class="hero-jam">
                {{ $waktu->format('H:i') }}<sup>{{ $waktu->format('s') }}</sup>
            </p>
            <p class="hero-tanggal">
                {{ $tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </p>
        </div>
    </div>

    {{-- ── INFORMASI SCAN ── --}}
    <div class="detail-card">
        <div class="detail-card-header">
            <svg width="14" height="14" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span class="detail-card-title">Informasi Scan</span>
        </div>
        <div class="row-list">

            {{-- Nama Siswa --}}
            <div class="row-item">
                <span class="row-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Nama Siswa
                </span>
                {{-- FIX: $siswa dijamin ada karena dikirim controller dan sudah di-loadMissing --}}
                <span class="row-val">{{ $siswa->nama_lengkap }}</span>
            </div>

            {{-- Kelas --}}
            <div class="row-item">
                <span class="row-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    </svg>
                    Kelas
                </span>
                <span class="row-val">{{ $siswa->kelas->nama_kelas ?? '—' }}</span>
            </div>

            {{-- Tanggal --}}
            <div class="row-item">
                <span class="row-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                    </svg>
                    Tanggal
                </span>
                <span class="row-val">{{ $tanggal->locale('id')->isoFormat('D MMMM Y') }}</span>
            </div>

            {{-- Waktu Scan --}}
            <div class="row-item">
                <span class="row-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    Waktu Scan
                </span>
                <span class="row-val">{{ $waktu->format('H:i:s') }} WIB</span>
            </div>

            {{-- Tipe --}}
            <div class="row-item">
                <span class="row-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <polyline points="17 1 21 5 17 9"/>
                        <path d="M3 11V9a4 4 0 0 1 4-4h14"/>
                        <polyline points="7 23 3 19 7 15"/>
                        <path d="M21 13v2a4 4 0 0 1-4 4H3"/>
                    </svg>
                    Tipe
                </span>
                <span class="row-val">
                    <span class="chip chip-{{ $tipe }}">
                        @if($tipe === 'masuk')
                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <line x1="12" y1="19" x2="12" y2="5"/>
                                <polyline points="5 12 12 5 19 12"/>
                            </svg>
                            Masuk
                        @else
                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <polyline points="19 12 12 19 5 12"/>
                            </svg>
                            Pulang
                        @endif
                    </span>
                </span>
            </div>

            {{-- Metode --}}
            <div class="row-item">
                <span class="row-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M3 9V5a2 2 0 0 1 2-2h4M3 15v4a2 2 0 0 0 2 2h4M21 9V5a2 2 0 0 0-2-2h-4M21 15v4a2 2 0 0 1-2 2h-4"/>
                    </svg>
                    Metode
                </span>
                <span class="row-val">
                    <span class="chip chip-metode-{{ $metode }}">{{ $metodeLabel }}</span>
                </span>
            </div>

            {{-- Status --}}
            {{-- FIX: Sebelumnya @elseif memakai class + inline style campuran yang
                 berpotensi broken jika salah quote. Sekarang pakai class CSS terpisah. --}}
            <div class="row-item">
                <span class="row-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    Status
                </span>
                <span class="row-val">
                    <span class="chip {{ $chipStatusClass }}">{{ $badgeLabel }}</span>
                </span>
            </div>

            {{-- Keterangan (opsional) --}}
            {{-- FIX: gunakan $absensiGerbang->catatan karena kolom di model adalah 'catatan',
                 bukan 'keterangan'. Sesuaikan jika nama kolom berbeda. --}}
            @if(filled($absensiGerbang->catatan ?? null))
                <div class="row-item">
                    <span class="row-label">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        Keterangan
                    </span>
                    <span class="row-val" style="max-width:300px;font-family:'Instrument Sans',sans-serif;font-size:13px;font-weight:500;text-align:right">
                        {{ $absensiGerbang->catatan }}
                    </span>
                </div>
            @endif

            {{-- ID Record --}}
            <div class="row-item">
                <span class="row-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <rect x="5" y="2" width="14" height="20" rx="2"/>
                        <line x1="12" y1="18" x2="12.01" y2="18"/>
                    </svg>
                    ID Record
                </span>
                <span class="row-val mono">#{{ $absensiGerbang->id }}</span>
            </div>

        </div>
    </div>

    {{-- ── SESI GERBANG ── --}}
    @if($absensiGerbang->sesiGerbang)
        @php
            $sesiMulai = $absensiGerbang->sesiGerbang->dibuka_pada  ?? null;
            $sesiTutup = $absensiGerbang->sesiGerbang->ditutup_pada ?? null;
        @endphp
        <div class="detail-card">
            <div class="detail-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                <span class="detail-card-title">Sesi Gerbang</span>
            </div>
            <div style="padding:16px 20px">
                <div class="sesi-box">
                    <div class="sesi-icon">
                        <svg width="20" height="20" fill="none" stroke="var(--s-500)" stroke-width="1.8" viewBox="0 0 24 24">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </div>
                    <div>
                        <p class="sesi-info-label">Nama Sesi</p>
                        <p class="sesi-info-val">{{ $absensiGerbang->sesiGerbang->nama ?? 'Sesi Gerbang' }}</p>
                        @if(filled($sesiMulai))
                            @php
                                // FIX: parse null-safe — $sesiMulai sudah dicek filled() di atas
                                $sesiMulaiCarbon = $sesiMulai instanceof \Carbon\Carbon
                                    ? $sesiMulai : \Carbon\Carbon::parse($sesiMulai);
                            @endphp
                            <p class="sesi-info-sub">
                                {{ $sesiMulaiCarbon->format('H:i') }}
                                @if(filled($sesiTutup))
                                    @php
                                        $sesiTutupCarbon = $sesiTutup instanceof \Carbon\Carbon
                                            ? $sesiTutup : \Carbon\Carbon::parse($sesiTutup);
                                    @endphp
                                    – {{ $sesiTutupCarbon->format('H:i') }}
                                @endif
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ── NOTICE ── --}}
    {{--
        FIX: Sebelumnya status 'duplikat' jatuh ke @else dan tampil notice "valid".
        Kini setiap status punya cabang tersendiri yang akurat.
    --}}
    @if($status === 'duplikat')
        <div class="notice notice-danger">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>
                Scan ini terdeteksi sebagai <strong>duplikat</strong> — sudah ada scan
                {{ $tipe }} sebelumnya di hari yang sama. Record ini <strong>tidak dihitung</strong>
                dalam rekap kehadiran Anda. Jika ada kekeliruan, hubungi petugas piket atau tata usaha.
            </span>
        </div>

    @elseif($status === 'manual')
        <div class="notice notice-warning">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>
                Scan ini dicatat secara <strong>manual oleh petugas</strong>, bukan melalui scan barcode.
                Jika ada pertanyaan, hubungi petugas piket atau tata usaha sekolah.
            </span>
        </div>

    @elseif($status === 'koreksi')
        <div class="notice notice-warning">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>
                Scan ini telah dikoreksi oleh <strong>admin</strong>. Data yang ditampilkan adalah
                hasil koreksi terakhir. Jika ada pertanyaan, hubungi tata usaha sekolah.
            </span>
        </div>

    @else
        {{-- status normal --}}
        <div class="notice notice-info">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>
                Scan {{ $tipe }} ini tercatat <strong>valid</strong> dan sudah masuk ke rekap kehadiran Anda.
            </span>
        </div>
    @endif

    {{-- ── ACTIONS ── --}}
    <div class="action-row">
        <a href="{{ route('siswa.absensi-gerbang.riwayat') }}" class="btn btn-secondary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali ke Riwayat
        </a>
        <a href="{{ route('siswa.absensi-gerbang.status-hari-ini') }}" class="btn btn-primary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
            </svg>
            Status Hari Ini
        </a>
    </div>

</div>
</x-app-layout>