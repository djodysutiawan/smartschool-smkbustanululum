<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Instrument+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');

    :root {
        --s-800:#0f2044;--s-700:#1a3a6b;--s-600:#1d4ed8;--s-500:#2563eb;
        --s-400:#3b82f6;--s-300:#93c5fd;--s-100:#dbeafe;--s-50:#eff6ff;
        --g-500:#10b981;--g-100:#d1fae5;--g-50:#ecfdf5;
        --a-500:#f59e0b;--a-100:#fef3c7;--a-50:#fffbeb;
        --r-500:#ef4444;--r-100:#fee2e2;--r-50:#fff5f5;
        --v-500:#8b5cf6;--v-100:#ede9fe;--v-50:#f5f3ff;
        --p-500:#ec4899;--p-100:#fce7f3;--p-50:#fdf2f8;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#334155;--text3:#64748b;--text4:#94a3b8;
        --radius:12px;--radius-sm:8px;--radius-xs:6px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.07);
        --shadow-md:0 4px 16px rgba(0,0,0,.08);
    }

    .page { padding: 24px 28px 56px; font-family: 'Instrument Sans', sans-serif; }

    /* ── Page header ── */
    .page-header { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:22px; flex-wrap:wrap; }
    .page-title { font-family:'Outfit',sans-serif; font-size:21px; font-weight:800; color:var(--text); }
    .page-sub { font-size:12.5px; color:var(--text4); margin-top:3px; }

    /* ── Day tabs ── */
    .day-tabs { display:flex; gap:6px; margin-bottom:20px; flex-wrap:wrap; }
    .day-tab {
        display:inline-flex; align-items:center; gap:6px;
        padding:8px 16px; border-radius:var(--radius-sm);
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:700;
        cursor:pointer; border:1.5px solid var(--border);
        background:var(--surface); color:var(--text3);
        transition:all .2s; text-decoration:none; white-space:nowrap;
    }
    .day-tab:hover { border-color:var(--s-300); color:var(--s-600); background:var(--s-50); }
    .day-tab.active { background:var(--s-600); border-color:var(--s-600); color:#fff; }
    .day-tab.today { border-color:var(--g-500); }
    .day-tab.today:not(.active) { color:var(--g-500); background:var(--g-50); }
    .day-tab .count {
        width:18px; height:18px; border-radius:99px;
        font-size:10px; font-weight:800;
        display:flex; align-items:center; justify-content:center;
        background:rgba(255,255,255,.25);
    }
    .day-tab:not(.active) .count { background:var(--surface3); color:var(--text3); }

    /* ── Today highlight banner ── */
    .today-banner {
        display:flex; align-items:center; gap:10px;
        background:linear-gradient(135deg,var(--s-800),var(--s-600));
        border-radius:var(--radius); padding:14px 20px; margin-bottom:16px; color:#fff;
    }
    .today-banner-icon { width:36px; height:36px; background:rgba(255,255,255,.15); border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .today-banner-title { font-family:'Outfit',sans-serif; font-size:14px; font-weight:700; }
    .today-banner-sub { font-size:12px; opacity:.75; margin-top:2px; }
    .today-banner-right { margin-left:auto; font-family:'Outfit',sans-serif; font-size:13px; font-weight:700; opacity:.85; }

    /* ── Section header ── */
    .section-hd {
        display:flex; align-items:center; gap:10px;
        margin-bottom:10px; padding:0 2px;
    }
    .section-day-label {
        font-family:'Outfit',sans-serif; font-size:15px; font-weight:800; color:var(--text);
        display:flex; align-items:center; gap:8px;
    }
    .today-chip {
        font-size:10px; font-weight:800; letter-spacing:.05em; text-transform:uppercase;
        background:var(--g-500); color:#fff; padding:2px 8px; border-radius:99px;
    }
    .section-line { flex:1; height:1px; background:var(--border); }

    /* ── Schedule card ── */
    .sch-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; margin-bottom:20px; box-shadow:var(--shadow-sm); }

    /* ── Schedule row ── */
    .sch-row {
        display:grid; grid-template-columns:80px 4px 1fr auto;
        align-items:stretch; gap:0;
        border-bottom:1px solid var(--border);
        transition:background .12s;
        text-decoration:none;
    }
    .sch-row:last-child { border-bottom:none; }
    .sch-row:hover { background:var(--s-50); }
    .sch-row.now { background:linear-gradient(90deg,rgba(37,99,235,.04),transparent); }

    .sch-time {
        padding:16px 14px; display:flex; flex-direction:column;
        align-items:center; justify-content:center;
        border-right:1px solid var(--border);
    }
    .sch-time .jam-mulai { font-family:'Outfit',sans-serif; font-size:14px; font-weight:800; color:var(--text2); }
    .sch-time .jam-selesai { font-size:11px; color:var(--text4); margin-top:2px; }
    .sch-time .durasi { font-size:10.5px; color:var(--text4); margin-top:6px; background:var(--surface3); padding:2px 6px; border-radius:99px; }

    /* color stripe */
    .sch-stripe { width:4px; flex-shrink:0; }

    .sch-body { padding:14px 16px; display:flex; flex-direction:column; justify-content:center; }
    .sch-mapel { font-family:'Outfit',sans-serif; font-size:14.5px; font-weight:700; color:var(--text); margin-bottom:4px; }
    .sch-meta { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
    .sch-guru { font-size:12.5px; color:var(--text3); display:flex; align-items:center; gap:5px; }
    .sch-ruang {
        font-size:11.5px; font-weight:700; font-family:'Outfit',sans-serif;
        background:var(--surface3); color:var(--text3);
        padding:2px 9px; border-radius:99px;
    }

    .sch-right { padding:14px 16px; display:flex; flex-direction:column; align-items:flex-end; justify-content:center; gap:6px; }
    .now-badge {
        display:inline-flex; align-items:center; gap:5px;
        background:var(--g-50); border:1px solid var(--g-100); color:var(--g-500);
        font-family:'Outfit',sans-serif; font-size:11px; font-weight:700;
        padding:3px 9px; border-radius:99px;
    }
    .now-dot { width:6px; height:6px; border-radius:50%; background:var(--g-500); animation:pulse-dot 1.4s ease-in-out infinite; }
    @keyframes pulse-dot { 0%,100%{opacity:1}50%{opacity:.4} }
    .detail-link {
        font-family:'Outfit',sans-serif; font-size:11.5px; font-weight:700;
        color:var(--s-500); text-decoration:none; display:flex; align-items:center; gap:3px;
        opacity:0; transition:opacity .15s;
    }
    .sch-row:hover .detail-link { opacity:1; }

    /* ── Empty day ── */
    .empty-day { padding:36px 20px; text-align:center; }
    .empty-day p { font-size:13px; color:var(--text4); font-family:'Instrument Sans',sans-serif; }

    /* ── Mapel color palette ── */
    /* Warna stripe per mata pelajaran (pakai index % 8) */
    .stripe-0{background:#2563eb}
    .stripe-1{background:#10b981}
    .stripe-2{background:#f59e0b}
    .stripe-3{background:#ef4444}
    .stripe-4{background:#8b5cf6}
    .stripe-5{background:#ec4899}
    .stripe-6{background:#0891b2}
    .stripe-7{background:#65a30d}

    /* ── Summary stats ── */
    .stats-bar { display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap; }
    .stat-pill {
        display:flex; align-items:center; gap:8px;
        background:var(--surface); border:1px solid var(--border);
        border-radius:var(--radius-sm); padding:10px 16px;
        flex:1; min-width:120px;
    }
    .stat-pill-icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .stat-pill-val { font-family:'Outfit',sans-serif; font-size:18px; font-weight:800; color:var(--text); line-height:1; }
    .stat-pill-label { font-size:11.5px; color:var(--text4); margin-top:1px; }

    /* ── Filter bar ── */
    .filter-bar { display:flex; align-items:center; gap:8px; margin-bottom:16px; flex-wrap:wrap; }
    .filter-bar select {
        height:36px; padding:0 12px; border:1px solid var(--border); border-radius:var(--radius-xs);
        font-family:'Instrument Sans',sans-serif; font-size:13px; color:var(--text);
        background:var(--surface); outline:none; transition:border-color .15s;
    }
    .filter-bar select:focus { border-color:var(--s-400); }
    .btn-filter {
        height:36px; padding:0 16px; background:var(--s-600); color:#fff; border:none;
        border-radius:var(--radius-xs); font-family:'Outfit',sans-serif; font-size:13px; font-weight:700;
        cursor:pointer; transition:background .15s;
    }
    .btn-filter:hover { background:var(--s-700); }
    .btn-reset {
        height:36px; padding:0 14px; background:var(--surface2); color:var(--text3);
        border:1px solid var(--border); border-radius:var(--radius-xs);
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:600;
        cursor:pointer; text-decoration:none; display:inline-flex; align-items:center;
    }

    /* ── View mode toggle ── */
    .view-toggle { display:flex; gap:2px; background:var(--surface3); border-radius:var(--radius-xs); padding:3px; }
    .view-btn {
        display:flex; align-items:center; gap:5px; padding:5px 12px;
        border-radius:5px; font-family:'Outfit',sans-serif; font-size:12px; font-weight:700;
        border:none; cursor:pointer; background:transparent; color:var(--text3); transition:all .15s;
    }
    .view-btn.active { background:var(--surface); color:var(--text); box-shadow:var(--shadow-sm); }

    /* ── Weekly grid view ── */
    .week-grid { display:none; }
    .week-grid.show { display:grid; grid-template-columns:repeat(6,1fr); gap:10px; }
    .week-col { }
    .week-col-hd {
        font-family:'Outfit',sans-serif; font-size:12px; font-weight:800; text-align:center;
        padding:8px; border-radius:var(--radius-xs); margin-bottom:6px; text-transform:uppercase; letter-spacing:.04em;
    }
    .week-col-hd.is-today { background:var(--s-600); color:#fff; }
    .week-col-hd:not(.is-today) { background:var(--surface3); color:var(--text3); }
    .week-item {
        border-radius:var(--radius-xs); padding:8px 10px; margin-bottom:5px;
        border-left:3px solid; font-size:12px; cursor:pointer;
        transition:transform .15s, box-shadow .15s; text-decoration:none; display:block;
    }
    .week-item:hover { transform:translateY(-1px); box-shadow:var(--shadow-md); }
    .week-item .wi-jam { font-family:'Outfit',sans-serif; font-size:10.5px; font-weight:700; opacity:.7; margin-bottom:2px; }
    .week-item .wi-mapel { font-family:'Outfit',sans-serif; font-size:12px; font-weight:700; line-height:1.3; }
    .week-item .wi-guru { font-size:10.5px; opacity:.7; margin-top:2px; }

    /* Week item colors */
    .wi-0{background:#eff6ff;border-color:#2563eb;color:#1e40af}
    .wi-1{background:#ecfdf5;border-color:#10b981;color:#065f46}
    .wi-2{background:#fffbeb;border-color:#f59e0b;color:#92400e}
    .wi-3{background:#fff5f5;border-color:#ef4444;color:#991b1b}
    .wi-4{background:#f5f3ff;border-color:#8b5cf6;color:#5b21b6}
    .wi-5{background:#fdf2f8;border-color:#ec4899;color:#9d174d}
    .wi-6{background:#ecfeff;border-color:#0891b2;color:#155e75}
    .wi-7{background:#f7fee7;border-color:#65a30d;color:#3f6212}

    /* List view */
    .list-view { display:block; }
    .list-view.hide { display:none; }

    @media(max-width:900px){ .week-grid.show{grid-template-columns:repeat(3,1fr)} }
    @media(max-width:640px){ .page{padding:14px 14px 48px} .week-grid.show{grid-template-columns:1fr 1fr} .stats-bar{display:grid;grid-template-columns:1fr 1fr} }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Jadwal Pelajaran</h1>
            <p class="page-sub">{{ $siswa->kelas->nama_kelas ?? 'Kelas -' }} &nbsp;·&nbsp; Semester {{ now()->month <= 6 ? 'Genap' : 'Ganjil' }} {{ now()->year }}</p>
        </div>
        <div class="view-toggle">
            <button class="view-btn active" id="btnList" onclick="setView('list')">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                Per Hari
            </button>
            <button class="view-btn" id="btnWeek" onclick="setView('week')">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Mingguan
            </button>
        </div>
    </div>

    {{-- Stats bar --}}
    @php
        $totalMapel  = $jadwal->pluck('mata_pelajaran_id')->unique()->count();
        $totalSesi   = $jadwal->count();
        $totalJam    = $jadwal->sum(fn($j) => \Carbon\Carbon::parse($j->jam_mulai)->diffInMinutes(\Carbon\Carbon::parse($j->jam_selesai)));
        $mapelColors = [];
        $colorIdx    = 0;
        foreach($jadwal->pluck('mataPelajaran.nama','mata_pelajaran_id')->unique() as $id => $nama) {
            $mapelColors[$id] = $colorIdx++ % 8;
        }
    @endphp
    <div class="stats-bar">
        <div class="stat-pill">
            <div class="stat-pill-icon" style="background:var(--s-50)">
                <svg width="16" height="16" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            </div>
            <div>
                <p class="stat-pill-val">{{ $totalMapel }}</p>
                <p class="stat-pill-label">Mata Pelajaran</p>
            </div>
        </div>
        <div class="stat-pill">
            <div class="stat-pill-icon" style="background:var(--g-50)">
                <svg width="16" height="16" fill="none" stroke="var(--g-500)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-pill-val">{{ $totalSesi }}</p>
                <p class="stat-pill-label">Sesi per Minggu</p>
            </div>
        </div>
        <div class="stat-pill">
            <div class="stat-pill-icon" style="background:var(--a-50)">
                <svg width="16" height="16" fill="none" stroke="var(--a-500)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-pill-val">{{ round($totalJam / 60, 1) }}<span style="font-size:12px;font-weight:600">j</span></p>
                <p class="stat-pill-label">Total Jam/Minggu</p>
            </div>
        </div>
        <div class="stat-pill">
            <div class="stat-pill-icon" style="background:var(--v-50)">
                <svg width="16" height="16" fill="none" stroke="var(--v-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div>
                <p class="stat-pill-val">{{ $jadwal->pluck('guru_id')->unique()->count() }}</p>
                <p class="stat-pill-label">Guru Pengajar</p>
            </div>
        </div>
    </div>

    {{-- Today banner --}}
    @if($jadwalHariIni->count() > 0)
    <div class="today-banner">
        <div class="today-banner-icon">
            <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <div>
            <p class="today-banner-title">Hari ini ada {{ $jadwalHariIni->count() }} pelajaran</p>
            <p class="today-banner-sub">{{ ucfirst($hariIni) }}, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>
        </div>
        <div class="today-banner-right">
            @php
                $sedangBerlangsung = $jadwalHariIni->first(fn($j) =>
                    $jamSekarang >= $j->jam_mulai && $jamSekarang <= $j->jam_selesai
                );
            @endphp
            @if($sedangBerlangsung)
                <span style="display:flex;align-items:center;gap:6px">
                    <span class="now-dot"></span>
                    Sedang: {{ $sedangBerlangsung->mataPelajaran->nama ?? '—' }}
                </span>
            @else
                {{ \Carbon\Carbon::now()->format('H:i') }} WIB
            @endif
        </div>
    </div>
    @endif

    {{-- ══ LIST VIEW ══ --}}
    <div class="list-view" id="listView">

        {{-- Day tabs --}}
        <div class="day-tabs">
            <a href="{{ route('siswa.jadwal.index') }}"
               class="day-tab {{ !request('hari') ? 'active' : '' }}">
                Semua
                <span class="count">{{ $totalSesi }}</span>
            </a>
            @foreach($hariList as $hari)
            @php $count = $jadwalPerHari->get($hari, collect())->count(); @endphp
            <a href="{{ route('siswa.jadwal.index', ['hari' => $hari]) }}"
               class="day-tab {{ request('hari') === $hari ? 'active' : '' }} {{ $hari === $hariIni ? 'today' : '' }}">
                {{ ucfirst($hari) }}
                @if($hari === $hariIni) <svg width="8" height="8" fill="var(--g-500)" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg> @endif
                <span class="count">{{ $count }}</span>
            </a>
            @endforeach
        </div>

        {{-- Per-day sections --}}
        @if(request('hari'))
            {{-- Single day --}}
            @php $list = $jadwalPerHari->get(request('hari'), collect()); @endphp
            <div class="section-hd">
                <span class="section-day-label">
                    {{ ucfirst(request('hari')) }}
                    @if(request('hari') === $hariIni) <span class="today-chip">Hari Ini</span> @endif
                </span>
            </div>
            <div class="sch-card">
                @forelse($list as $j)
                @php
                    $mulai   = \Carbon\Carbon::parse($j->jam_mulai);
                    $selesai = \Carbon\Carbon::parse($j->jam_selesai);
                    $durasi  = $mulai->diffInMinutes($selesai);
                    $isNow   = $hariIni === request('hari') && $jamSekarang >= $j->jam_mulai && $jamSekarang <= $j->jam_selesai;
                    $ci      = $mapelColors[$j->mata_pelajaran_id] ?? 0;
                @endphp
                <a href="{{ route('siswa.jadwal.show', $j->id) }}" class="sch-row {{ $isNow ? 'now' : '' }}">
                    <div class="sch-time">
                        <span class="jam-mulai">{{ $mulai->format('H:i') }}</span>
                        <span class="jam-selesai">{{ $selesai->format('H:i') }}</span>
                        <span class="durasi">{{ $durasi }}m</span>
                    </div>
                    <div class="sch-stripe stripe-{{ $ci }}"></div>
                    <div class="sch-body">
                        <p class="sch-mapel">{{ $j->mataPelajaran->nama ?? '—' }}</p>
                        <div class="sch-meta">
                            <span class="sch-guru">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                {{ $j->guru->nama_lengkap ?? '—' }}
                            </span>
                            @if($j->ruang)
                                <span class="sch-ruang">{{ $j->ruang->nama_ruang ?? '' }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="sch-right">
                        @if($isNow)
                            <span class="now-badge"><span class="now-dot"></span>Berlangsung</span>
                        @endif
                        <span class="detail-link">
                            Detail
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                        </span>
                    </div>
                </a>
                @empty
                <div class="empty-day">
                    <svg width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 10px;display:block"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <p>Tidak ada jadwal hari {{ ucfirst(request('hari')) }}</p>
                </div>
                @endforelse
            </div>

        @else
            {{-- All days --}}
            @foreach($hariList as $hari)
            @php $list = $jadwalPerHari->get($hari, collect()); @endphp
            @if($list->count() > 0)
            <div class="section-hd">
                <span class="section-day-label">
                    {{ ucfirst($hari) }}
                    @if($hari === $hariIni) <span class="today-chip">Hari Ini</span> @endif
                </span>
                <div class="section-line"></div>
            </div>
            <div class="sch-card">
                @foreach($list as $j)
                @php
                    $mulai   = \Carbon\Carbon::parse($j->jam_mulai);
                    $selesai = \Carbon\Carbon::parse($j->jam_selesai);
                    $durasi  = $mulai->diffInMinutes($selesai);
                    $isNow   = $hari === $hariIni && $jamSekarang >= $j->jam_mulai && $jamSekarang <= $j->jam_selesai;
                    $ci      = $mapelColors[$j->mata_pelajaran_id] ?? 0;
                @endphp
                <a href="{{ route('siswa.jadwal.show', $j->id) }}" class="sch-row {{ $isNow ? 'now' : '' }}">
                    <div class="sch-time">
                        <span class="jam-mulai">{{ $mulai->format('H:i') }}</span>
                        <span class="jam-selesai">{{ $selesai->format('H:i') }}</span>
                        <span class="durasi">{{ $durasi }}m</span>
                    </div>
                    <div class="sch-stripe stripe-{{ $ci }}"></div>
                    <div class="sch-body">
                        <p class="sch-mapel">{{ $j->mataPelajaran->nama ?? '—' }}</p>
                        <div class="sch-meta">
                            <span class="sch-guru">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                {{ $j->guru->nama_lengkap ?? '—' }}
                            </span>
                            @if($j->ruang)
                                <span class="sch-ruang">{{ $j->ruang->nama_ruang ?? '' }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="sch-right">
                        @if($isNow)
                            <span class="now-badge"><span class="now-dot"></span>Berlangsung</span>
                        @endif
                        <span class="detail-link">
                            Detail <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
            @endforeach

            @if($jadwal->isEmpty())
            <div style="text-align:center;padding:60px 20px">
                <svg width="48" height="48" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px;display:block"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <p style="font-family:'Outfit',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:4px">Jadwal belum tersedia</p>
                <p style="font-size:13px;color:var(--text4)">Jadwal pelajaran untuk kelas Anda belum diinput oleh admin.</p>
            </div>
            @endif
        @endif
    </div>

    {{-- ══ WEEKLY GRID VIEW ══ --}}
    <div class="week-grid" id="weekView">
        @foreach($hariList as $hari)
        @php $list = $jadwalPerHari->get($hari, collect()); @endphp
        <div class="week-col">
            <div class="week-col-hd {{ $hari === $hariIni ? 'is-today' : '' }}">
                {{ strtoupper(substr($hari,0,3)) }}
                @if($hari === $hariIni)
                    <br><span style="font-size:9px;font-weight:600;opacity:.8">Hari Ini</span>
                @endif
            </div>
            @foreach($list as $j)
            @php $ci = $mapelColors[$j->mata_pelajaran_id] ?? 0; @endphp
            <a href="{{ route('siswa.jadwal.show', $j->id) }}" class="week-item wi-{{ $ci }}">
                <p class="wi-jam">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</p>
                <p class="wi-mapel">{{ $j->mataPelajaran->nama ?? '—' }}</p>
                <p class="wi-guru">{{ $j->guru->nama_lengkap ?? '—' }}</p>
            </a>
            @endforeach
            @if($list->isEmpty())
                <div style="padding:12px 8px;text-align:center;font-size:11px;color:var(--text4)">—</div>
            @endif
        </div>
        @endforeach
    </div>

</div>

<script>
function setView(mode) {
    const listView = document.getElementById('listView');
    const weekView = document.getElementById('weekView');
    const btnList  = document.getElementById('btnList');
    const btnWeek  = document.getElementById('btnWeek');

    if (mode === 'list') {
        listView.classList.remove('hide');
        weekView.classList.remove('show');
        btnList.classList.add('active');
        btnWeek.classList.remove('active');
        localStorage.setItem('jadwal_view', 'list');
    } else {
        listView.classList.add('hide');
        weekView.classList.add('show');
        btnList.classList.remove('active');
        btnWeek.classList.add('active');
        localStorage.setItem('jadwal_view', 'week');
    }
}

// Restore last view preference
const savedView = localStorage.getItem('jadwal_view');
if (savedView === 'week') setView('week');

// Auto-scroll to today's section on load
document.addEventListener('DOMContentLoaded', () => {
    const todayChip = document.querySelector('.today-chip');
    if (todayChip && !@json(request()->filled('hari'))) {
        setTimeout(() => {
            todayChip.closest('.section-hd')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 300);
    }
});
</script>
</x-app-layout>