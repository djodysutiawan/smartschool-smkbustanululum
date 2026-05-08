<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
        --green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fff0f0;--red-border:#fecaca;
        --yellow:#a16207;--yellow-bg:#fef9c3;--yellow-border:#fde68a;
        --purple:#7c3aed;--purple-bg:#fdf4ff;--purple-border:#e9d5ff;
        --orange:#c2410c;--orange-bg:#fff7ed;--orange-border:#fed7aa;
    }

    /* ── RESET & BASE ── */
    * { box-sizing: border-box; }
    .page { padding: 28px 28px 40px; }

    /* ── BREADCRUMB ── */
    .breadcrumb { display:flex; align-items:center; gap:6px; margin-bottom:16px; font-size:12.5px; color:var(--text3); }
    .breadcrumb a { color:var(--text3); text-decoration:none; transition:color .15s; }
    .breadcrumb a:hover { color:var(--brand-600); }
    .breadcrumb-sep { color:var(--border2); }
    .breadcrumb-cur { color:var(--text2); font-weight:600; }

    /* ── PAGE HEADER ── */
    .page-header { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:24px; flex-wrap:wrap; }
    .page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:20px; font-weight:800; color:var(--text); line-height:1.2; }
    .page-sub { font-size:12.5px; color:var(--text3); margin-top:3px; }
    .header-actions { display:flex; gap:8px; flex-wrap:wrap; align-items:center; }

    /* ── BUTTONS ── */
    .btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; border:none; text-decoration:none; transition:filter .15s; white-space:nowrap; }
    .btn:hover { filter:brightness(.93); }
    .btn-sm { padding:6px 12px; font-size:12px; border-radius:6px; }
    .btn-detail { background:var(--green-bg); color:var(--green); border:1px solid var(--green-border); }
    .btn-detail:hover { background:#dcfce7; filter:none; }
    .btn-pdf { background:var(--red-bg); color:var(--red); border:1px solid var(--red-border); }
    .btn-pdf:hover { background:#fee2e2; filter:none; }
    .btn-excel { background:var(--green-bg); color:var(--green); border:1px solid var(--green-border); }
    .btn-excel:hover { background:#dcfce7; filter:none; }
    .btn-back { background:var(--surface2); color:var(--text2); border:1px solid var(--border); }
    .btn-back:hover { background:var(--surface3); filter:none; }

    /* ── UJIAN BANNER ── */
    .ujian-banner { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:18px 22px; margin-bottom:20px; display:flex; align-items:center; gap:18px; flex-wrap:wrap; }
    .ujian-banner-icon { width:48px; height:48px; background:var(--brand-50); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .ujian-banner-info { flex:1; min-width:0; }
    .ujian-banner-title { font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:16px; color:var(--text); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .ujian-banner-meta { display:flex; gap:14px; flex-wrap:wrap; margin-top:6px; }
    .meta-item { display:flex; align-items:center; gap:5px; font-size:12px; color:var(--text3); }
    .meta-item svg { flex-shrink:0; }
    .meta-item strong { color:var(--text2); font-weight:700; }

    /* ── JENIS PILL ─ pakai dash, bukan underscore ── */
    .jenis-pill { display:inline-block; padding:2px 9px; border-radius:5px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; }
    .jenis-ulangan-harian { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }
    .jenis-uts            { background:var(--purple-bg); color:var(--purple); border:1px solid var(--purple-border); }
    .jenis-uas            { background:var(--orange-bg); color:var(--orange); border:1px solid var(--orange-border); }
    .jenis-remedial       { background:var(--red-bg); color:var(--red); border:1px solid var(--red-border); }
    .jenis-quiz           { background:var(--green-bg); color:var(--green); border:1px solid var(--green-border); }

    /* ── LIVE BADGE ── */
    .live-badge { display:flex; align-items:center; gap:7px; background:var(--brand-50); border:1px solid var(--brand-100); border-radius:8px; padding:8px 14px; white-space:nowrap; }
    .live-badge-text { font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; color:var(--brand-700); }
    .live-dot { display:inline-block; width:7px; height:7px; border-radius:50%; background:var(--brand-600); flex-shrink:0; animation:blink 1.4s ease-in-out infinite; }
    @keyframes blink { 0%,100%{opacity:1;transform:scale(1);} 50%{opacity:.45;transform:scale(.75);} }

    /* ── STATS ── */
    .stats-strip { display:grid; grid-template-columns:repeat(6,1fr); gap:12px; margin-bottom:20px; }
    .stat-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:14px 16px; }
    .stat-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:700; color:var(--text3); letter-spacing:.04em; text-transform:uppercase; margin-bottom:4px; }
    .stat-val { font-family:'Plus Jakarta Sans',sans-serif; font-size:22px; font-weight:800; color:var(--text); line-height:1; }
    .stat-val.c-green  { color:var(--green); }
    .stat-val.c-red    { color:var(--red); }
    .stat-val.c-blue   { color:var(--brand-600); }
    .stat-val.c-yellow { color:var(--yellow); }

    /* ── TABLE CARD ── */
    .table-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; }
    .table-topbar { display:flex; align-items:center; justify-content:space-between; padding:12px 18px; border-bottom:1px solid var(--border); flex-wrap:wrap; gap:8px; }
    .table-info { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; color:var(--text); }
    .table-info span { font-weight:400; color:var(--text3); margin-left:6px; }
    .table-actions { display:flex; gap:6px; align-items:center; }
    .table-wrap { overflow-x:auto; }

    /* ── TABLE ── */
    table { width:100%; border-collapse:collapse; font-size:13px; }
    thead tr { background:var(--surface2); border-bottom:1px solid var(--border); }
    thead th { padding:10px 13px; text-align:left; font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:700; color:var(--text3); letter-spacing:.05em; text-transform:uppercase; white-space:nowrap; }
    thead th.center { text-align:center; }
    tbody tr { border-bottom:1px solid #f1f5f9; transition:background .1s; }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:#fafbff; }
    td { padding:10px 13px; color:var(--text); vertical-align:middle; }
    td.center { text-align:center; }
    td.muted { color:var(--text3); font-size:12.5px; }
    .no-col { font-family:'Plus Jakarta Sans',sans-serif; font-size:12px; font-weight:700; color:var(--text3); }
    .siswa-name { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:13.5px; color:var(--text); }
    .siswa-sub { font-size:12px; color:var(--text3); margin-top:1px; }

    /* ── BADGE STATUS ─ semua pakai dash ── */
    .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:99px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; white-space:nowrap; }
    .badge-dot { width:5px; height:5px; border-radius:50%; flex-shrink:0; }

    .badge-selesai     { background:var(--green-bg);  color:var(--green);      }
    .badge-selesai     .badge-dot { background:var(--green);      }
    .badge-berlangsung { background:var(--brand-50);  color:var(--brand-700);  }
    .badge-berlangsung .badge-dot { background:var(--brand-600); }
    /* habis_waktu → class: badge-habis-waktu */
    .badge-habis-waktu { background:var(--red-bg);    color:var(--red);        }
    .badge-habis-waktu .badge-dot { background:var(--red);        }
    /* belum_mulai → class: badge-belum-mulai */
    .badge-belum-mulai { background:var(--surface2);  color:var(--text3);      }
    .badge-belum-mulai .badge-dot { background:var(--text3);      }

    .badge-lulus  { background:var(--green-bg); color:var(--green); }
    .badge-gagal  { background:var(--red-bg);   color:var(--red);   }

    /* ── NILAI BAR ── */
    .nilai-wrap { display:flex; align-items:center; gap:8px; min-width:110px; }
    .nilai-bar-bg { flex:1; height:5px; background:var(--surface3); border-radius:99px; overflow:hidden; min-width:50px; }
    .nilai-bar-fill { height:100%; border-radius:99px; }
    .nilai-text { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:13px; min-width:36px; text-align:right; }

    /* ── ACTIONS ── */
    .action-group { display:flex; align-items:center; gap:4px; justify-content:center; }

    /* ── PAGINATION ── */
    .pag-wrap { display:flex; align-items:center; justify-content:space-between; padding:13px 18px; border-top:1px solid var(--border); flex-wrap:wrap; gap:8px; }
    .pag-info { font-size:12.5px; color:var(--text3); }
    .pag-btns { display:flex; gap:4px; align-items:center; }
    .pag-btn { height:32px; min-width:32px; padding:0 8px; border-radius:7px; display:flex; align-items:center; justify-content:center; border:1px solid var(--border); background:var(--surface); color:var(--text2); font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; cursor:pointer; transition:all .15s; text-decoration:none; }
    .pag-btn:hover { background:var(--surface2); }
    .pag-btn.active { background:var(--brand-600); border-color:var(--brand-600); color:#fff; }
    .pag-ellipsis { color:var(--text3); font-size:13px; padding:0 4px; }

    /* ── EMPTY STATE ── */
    .empty-state { padding:50px 20px; text-align:center; }
    .empty-icon { width:52px; height:52px; background:var(--surface2); border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px; }
    .empty-title { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:15px; color:var(--text); margin-bottom:4px; }
    .empty-sub { font-size:13px; color:var(--text3); }

    /* ── RESPONSIVE ── */
    @media(max-width:1024px) { .stats-strip { grid-template-columns:repeat(3,1fr); } }
    @media(max-width:640px)  { .stats-strip { grid-template-columns:1fr 1fr; } .page { padding:16px; } }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.ujian.index') }}">Ujian</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.ujian.show', $ujian) }}">{{ Str::limit($ujian->judul, 40) }}</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-cur">Monitor Sesi Siswa</span>
    </div>

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Monitor Sesi Ujian</h1>
            <p class="page-sub">Pantau progress dan hasil pengerjaan siswa secara real-time</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.ujian.sesi.export.pdf', $ujian) }}"
               class="btn btn-sm btn-pdf" target="_blank">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
                Export PDF
            </a>
            <a href="{{ route('admin.ujian.sesi.export.excel', $ujian) }}"
               class="btn btn-sm btn-excel">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
                Export Excel
            </a>
            <a href="{{ route('admin.ujian.show', $ujian) }}" class="btn btn-sm btn-back">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Ujian Info Banner --}}
    <div class="ujian-banner">
        <div class="ujian-banner-icon">
            <svg width="22" height="22" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <path d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
        </div>

        <div class="ujian-banner-info">
            <div class="ujian-banner-title">{{ $ujian->judul }}</div>
            <div class="ujian-banner-meta">
                <span class="meta-item">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                    {{ $ujian->mataPelajaran->nama_mapel ?? '-' }}
                </span>
                <span class="meta-item">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    </svg>
                    {{ $ujian->kelas->nama_kelas ?? '-' }}
                </span>
                <span class="meta-item">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                    {{ $ujian->durasi_menit }} menit
                </span>
                <span class="meta-item">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    {{ \Carbon\Carbon::parse($ujian->tanggal)->format('d M Y') }}
                    @if($ujian->jam_mulai) · {{ $ujian->jam_mulai }} @endif
                </span>
                <span class="meta-item">
                    KKM: <strong>{{ $ujian->nilai_kkm ?? '—' }}</strong>
                </span>
            </div>
        </div>

        {{-- Jenis pill — ganti underscore → dash supaya CSS match --}}
        <span class="jenis-pill jenis-{{ str_replace('_', '-', $ujian->jenis) }}">
            {{ strtoupper(str_replace('_', ' ', $ujian->jenis)) }}
        </span>

        @if($stats['sedang_berlangsung'] > 0)
        <div class="live-badge">
            <span class="live-dot"></span>
            <span class="live-badge-text">{{ $stats['sedang_berlangsung'] }} sedang berlangsung</span>
        </div>
        @endif
    </div>

    {{-- Stats Strip --}}
    <div class="stats-strip">
        <div class="stat-card">
            <p class="stat-label">Total Peserta</p>
            <p class="stat-val c-blue">{{ $stats['total_peserta'] }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Sudah Selesai</p>
            <p class="stat-val c-green">{{ $stats['sudah_selesai'] }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Berlangsung</p>
            <p class="stat-val c-blue">{{ $stats['sedang_berlangsung'] }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Rata-rata Nilai</p>
            <p class="stat-val {{ $stats['rata_nilai'] >= ($ujian->nilai_kkm ?? 70) ? 'c-green' : 'c-red' }}">
                {{ number_format($stats['rata_nilai'], 1) }}
            </p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Lulus</p>
            <p class="stat-val c-green">{{ $stats['lulus'] }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Tidak Lulus</p>
            <p class="stat-val c-red">{{ $stats['tidak_lulus'] }}</p>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Sesi Pengerjaan
                <span>— {{ $sesiList->total() }} sesi</span>
            </p>
            <div class="table-actions">
                <button onclick="location.reload()" class="btn btn-sm btn-back" title="Refresh">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                    </svg>
                    Refresh
                </button>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:44px">#</th>
                        <th>Siswa</th>
                        <th class="center">Status</th>
                        <th>Mulai Pada</th>
                        <th>Selesai Pada</th>
                        <th class="center">Durasi</th>
                        <th class="center" style="width:160px">Nilai Akhir</th>
                        <th class="center">Keterangan</th>
                        <th class="center" style="width:90px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sesiList as $i => $sesi)
                    @php
                        $barColor = ($sesi->nilai_akhir ?? 0) >= ($ujian->nilai_kkm ?? 70)
                            ? '#15803d' : '#dc2626';
                        $durasiMenit = null;
                        if ($sesi->mulai_pada && $sesi->selesai_pada) {
                            $durasiMenit = \Carbon\Carbon::parse($sesi->mulai_pada)
                                ->diffInMinutes(\Carbon\Carbon::parse($sesi->selesai_pada));
                        }
                        /* mapping status ke class yang valid (tanpa underscore) */
                        $statusClass = match($sesi->status) {
                            'habis_waktu'  => 'badge-habis-waktu',
                            'belum_mulai'  => 'badge-belum-mulai',
                            default        => 'badge-' . $sesi->status,
                        };
                        $statusLabel = match($sesi->status) {
                            'selesai'      => 'Selesai',
                            'berlangsung'  => 'Berlangsung',
                            'habis_waktu'  => 'Habis Waktu',
                            'belum_mulai'  => 'Belum Mulai',
                            default        => ucfirst($sesi->status),
                        };
                    @endphp
                    <tr>
                        {{-- No --}}
                        <td><span class="no-col">{{ $sesiList->firstItem() + $i }}</span></td>

                        {{-- Siswa --}}
                        <td>
                            <p class="siswa-name">{{ $sesi->siswa->nama_lengkap ?? '-' }}</p>
                            <p class="siswa-sub">
                                {{ $sesi->siswa->nis ?? '' }}
                                @if($sesi->siswa?->kelas) · {{ $sesi->siswa->kelas->nama_kelas }} @endif
                            </p>
                        </td>

                        {{-- Status --}}
                        <td class="center">
                            <span class="badge {{ $statusClass }}">
                                <span class="badge-dot"></span>
                                {{ $statusLabel }}
                            </span>
                        </td>

                        {{-- Mulai --}}
                        <td class="muted">
                            @if($sesi->mulai_pada)
                                {{ \Carbon\Carbon::parse($sesi->mulai_pada)->format('d M Y') }}<br>
                                <span style="font-size:11.5px">
                                    {{ \Carbon\Carbon::parse($sesi->mulai_pada)->format('H:i:s') }}
                                </span>
                            @else
                                —
                            @endif
                        </td>

                        {{-- Selesai --}}
                        <td class="muted">
                            @if($sesi->selesai_pada)
                                {{ \Carbon\Carbon::parse($sesi->selesai_pada)->format('d M Y') }}<br>
                                <span style="font-size:11.5px">
                                    {{ \Carbon\Carbon::parse($sesi->selesai_pada)->format('H:i:s') }}
                                </span>
                            @elseif($sesi->status === 'berlangsung')
                                <span style="color:var(--brand-600);font-weight:600;font-size:12px">
                                    Sedang berjalan…
                                </span>
                            @else
                                —
                            @endif
                        </td>

                        {{-- Durasi --}}
                        <td class="center muted">
                            @if($durasiMenit !== null)
                                {{ $durasiMenit }} mnt
                            @elseif($sesi->status === 'berlangsung' && $sesi->mulai_pada)
                                {{ \Carbon\Carbon::parse($sesi->mulai_pada)->diffInMinutes(now()) }} mnt
                            @else
                                —
                            @endif
                        </td>

                        {{-- Nilai --}}
                        <td class="center">
                            @if(!is_null($sesi->nilai_akhir))
                            <div class="nilai-wrap">
                                <div class="nilai-bar-bg">
                                    <div class="nilai-bar-fill"
                                         style="width:{{ min(100, $sesi->nilai_akhir) }}%;background:{{ $barColor }}">
                                    </div>
                                </div>
                                <span class="nilai-text" style="color:{{ $barColor }}">
                                    {{ number_format($sesi->nilai_akhir, 1) }}
                                </span>
                            </div>
                            @else
                                <span style="color:var(--text3);font-size:12.5px">—</span>
                            @endif
                        </td>

                        {{-- Keterangan --}}
                        <td class="center">
                            @if(in_array($sesi->status, ['selesai', 'habis_waktu']))
                                @if(!is_null($sesi->lulus))
                                    <span class="badge {{ $sesi->lulus ? 'badge-lulus' : 'badge-gagal' }}">
                                        {{ $sesi->lulus ? 'Lulus' : 'Tidak Lulus' }}
                                    </span>
                                @else
                                    <span style="color:var(--yellow);font-size:11.5px;font-weight:600;">
                                        Menunggu koreksi essay
                                    </span>
                                @endif
                            @else
                                <span style="color:var(--text3);font-size:12px">—</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.ujian.sesi.show-admin', [$ujian, $sesi]) }}"
                                   class="btn btn-sm btn-detail">
                                    Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                </div>
                                <p class="empty-title">Belum ada siswa yang mengikuti ujian ini</p>
                                <p class="empty-sub">Data akan muncul saat siswa mulai mengerjakan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($sesiList->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">
                Menampilkan {{ $sesiList->firstItem() }}–{{ $sesiList->lastItem() }}
                dari {{ $sesiList->total() }} sesi
            </p>
            <div class="pag-btns">
                @if($sesiList->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $sesiList->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
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
                    <a href="{{ $sesiList->nextPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </span>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif

    // Auto-refresh setiap 30 detik jika ada sesi berlangsung
    @if($stats['sedang_berlangsung'] > 0)
    setTimeout(() => location.reload(), 30000);
    @endif
</script>
</x-app-layout>