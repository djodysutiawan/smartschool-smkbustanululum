<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand:      #1f63db; --brand-h: #3582f0; --brand-50: #eef6ff;
        --brand-100:  #d9ebff; --brand-700: #1750c0;
        --surface:    #fff; --surface2: #f8fafc; --surface3: #f1f5f9;
        --border:     #e2e8f0; --border2: #cbd5e1;
        --text:       #0f172a; --text2: #475569; --text3: #94a3b8;
        --radius:     10px; --radius-sm: 7px;
        --danger:     #dc2626; --danger-50: #fee2e2; --danger-100: #fecaca;
        --success:    #16a34a; --success-50: #f0fdf4; --success-100: #dcfce7;
        --warn:       #d97706; --warn-50: #fffbeb; --warn-100: #fef3c7;
    }

    .page { padding: 28px 28px 60px; max-width: 5000px; margin: 0 auto; }

    .breadcrumb { display: flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600; color: var(--text3); margin-bottom: 20px; }
    .breadcrumb a { color: var(--text3); text-decoration: none; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 20px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }

    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: background .15s; white-space: nowrap; }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { background: var(--brand-h); }
    .btn-ghost { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }

    /* Stats row */
    .stats-row { display: grid; grid-template-columns: repeat(7,1fr); gap: 12px; margin-bottom: 20px; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px 16px; }
    .stat-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .06em; margin-bottom: 5px; }
    .stat-value { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: var(--text); line-height: 1; }
    .stat-sub   { font-size: 11px; color: var(--text3); margin-top: 3px; }

    /* Filter */
    .filter-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); margin-bottom: 20px; overflow: hidden; }
    .filter-header { display: flex; align-items: center; gap: 8px; padding: 11px 16px; border-bottom: 1px solid var(--border); background: var(--surface2); }
    .filter-header-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .07em; }
    .filter-body { padding: 14px 16px; display: grid; grid-template-columns: 1fr 1fr auto; gap: 10px; align-items: end; }
    .f-group { display: flex; flex-direction: column; gap: 5px; }
    .f-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--text2); }
    .f-select { font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text); background: var(--surface2); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 8px 28px 8px 11px; outline: none; width: 100%; appearance: none; background-image: url("data:image/svg+xml,%3Csvg width='11' height='11' fill='none' stroke='%2394a3b8' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; cursor: pointer; }
    .f-select:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(31,99,219,.08); outline: none; }

    /* Charts row */
    .charts-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
    .chart-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .card-header { display: flex; align-items: center; gap: 8px; padding: 13px 16px; border-bottom: 1px solid var(--border); background: var(--surface2); }
    .card-title  { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .07em; }
    .card-body   { padding: 20px; }

    /* Lulus/tidak lulus donut */
    .donut-wrap { display: flex; align-items: center; gap: 24px; }
    .donut-svg  { flex-shrink: 0; }
    .donut-legend { flex: 1; display: flex; flex-direction: column; gap: 10px; }
    .legend-row { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
    .legend-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
    .legend-label { font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text2); flex: 1; }
    .legend-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 800; color: var(--text); }

    /* Grade distribution bars */
    .dist-row { display: flex; flex-direction: column; gap: 10px; }
    .dist-item { display: flex; align-items: center; gap: 10px; }
    .dist-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 800; width: 20px; text-align: center; }
    .dist-bar-wrap { flex: 1; height: 24px; background: var(--surface3); border-radius: 5px; overflow: hidden; border: 1px solid var(--border); }
    .dist-bar { height: 100%; border-radius: 5px; transition: width .5s ease; }
    .dist-count { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--text2); min-width: 36px; text-align: right; }
    .dist-pct { font-size: 11px; color: var(--text3); min-width: 40px; text-align: right; }

    /* Table card */
    .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .table-top { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border-bottom: 1px solid var(--border); background: var(--surface2); flex-wrap: wrap; gap: 8px; }
    .table-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .07em; }
    .table-count { background: var(--brand-50); color: var(--brand-700); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 20px; border: 1px solid var(--brand-100); }

    table { width: 100%; border-collapse: collapse; }
    thead tr { background: var(--surface2); border-bottom: 1px solid var(--border); }
    thead th { padding: 10px 14px; text-align: left; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); white-space: nowrap; }
    thead th.center { text-align: center; }
    tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: var(--surface2); }
    tbody td { padding: 11px 14px; color: var(--text); font-family: 'DM Sans', sans-serif; font-size: 13px; vertical-align: middle; }
    tbody td.center { text-align: center; }

    .student-info { display: flex; align-items: center; gap: 10px; }
    .avatar { width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0; background: var(--brand-50); border: 1px solid var(--brand-100); display: flex; align-items: center; justify-content: center; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 800; color: var(--brand-700); }
    .student-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .student-nisn { font-size: 11.5px; color: var(--text3); }

    .score-cell { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 13px; }
    .score-a { color: var(--success); }
    .score-b { color: var(--brand); }
    .score-c { color: var(--warn); }
    .score-d { color: var(--danger); }

    .badge { display: inline-flex; align-items: center; padding: 3px 9px; border-radius: 20px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; }
    .badge-success { background: var(--success-50); color: var(--success); border: 1px solid var(--success-100); }
    .badge-danger  { background: var(--danger-50);  color: var(--danger);  border: 1px solid var(--danger-100); }

    @media(max-width:1000px) { .stats-row { grid-template-columns: repeat(4,1fr); } .charts-row { grid-template-columns: 1fr; } }
    @media(max-width:640px)  { .stats-row { grid-template-columns: repeat(2,1fr); } .filter-body { grid-template-columns: 1fr; } .page { padding: 16px 16px 40px; } }
</style>

<div class="page">

    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.grades.index') }}">Nilai Siswa</a>
        <span class="sep">›</span>
        <span class="current">Monitoring</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Monitoring Nilai</h1>
            <p class="page-sub">Rekap dan analisis nilai siswa per kelas dan mata pelajaran</p>
        </div>
        <a href="{{ route('admin.grades.index') }}" class="btn btn-ghost">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card">
            <p class="stat-label">Total Data</p>
            <p class="stat-value">{{ $stats['total'] }}</p>
            <p class="stat-sub">entri</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Rata Akhir</p>
            <p class="stat-value" style="color:var(--brand)">{{ $stats['avg_akhir'] ?: '—' }}</p>
            <p class="stat-sub">dari 100</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Rata Tugas</p>
            <p class="stat-value" style="color:var(--text2)">{{ $stats['avg_tugas'] ?: '—' }}</p>
            <p class="stat-sub">30% bobot</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Rata UTS</p>
            <p class="stat-value" style="color:var(--text2)">{{ $stats['avg_uts'] ?: '—' }}</p>
            <p class="stat-sub">30% bobot</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Rata UAS</p>
            <p class="stat-value" style="color:var(--text2)">{{ $stats['avg_uas'] ?: '—' }}</p>
            <p class="stat-sub">40% bobot</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Lulus</p>
            <p class="stat-value" style="color:var(--success)">{{ $stats['lulus'] }}</p>
            <p class="stat-sub">≥ 75</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Tidak Lulus</p>
            <p class="stat-value" style="color:var(--danger)">{{ $stats['tidak_lulus'] }}</p>
            <p class="stat-sub">< 75</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <div class="filter-header">
            <svg width="12" height="12" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
            </svg>
            <p class="filter-header-title">Filter Monitoring</p>
        </div>
        <form method="GET" action="{{ route('admin.grades.monitoring') }}">
            <div class="filter-body">
                <div class="f-group">
                    <label class="f-label">Kelas</label>
                    <select name="class_id" class="f-select">
                        <option value="">— Semua Kelas —</option>
                        @foreach($classes as $cls)
                            <option value="{{ $cls->id }}" {{ request('class_id') == $cls->id ? 'selected' : '' }}>
                                {{ $cls->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="f-group">
                    <label class="f-label">Mata Pelajaran</label>
                    <select name="subject_id" class="f-select">
                        <option value="">— Semua Mapel —</option>
                        @foreach($subjects as $s)
                            <option value="{{ $s->id }}" {{ request('subject_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="f-group">
                    <button type="submit" class="btn btn-primary" style="height:37px">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        Terapkan
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Charts --}}
    @php
        $total = $stats['total'];
        $lulus = $stats['lulus'];
        $tkLulus = $stats['tidak_lulus'];

        // Grade distribution
        $gradeA = $grades->where('nilai_akhir', '>=', 90)->count();
        $gradeB = $grades->whereBetween('nilai_akhir', [75, 89.99])->count();
        $gradeC = $grades->whereBetween('nilai_akhir', [60, 74.99])->count();
        $gradeD = $grades->where('nilai_akhir', '<', 60)->count();

        $maxDist = max($gradeA, $gradeB, $gradeC, $gradeD, 1);

        // SVG donut
        $r = 52; $cx = 60; $cy = 60; $circumference = 2 * M_PI * $r;
        $lulusPct  = $total > 0 ? ($lulus / $total) : 0;
        $tkPct     = 1 - $lulusPct;
        $dash1 = $lulusPct * $circumference;
        $dash2 = $circumference - $dash1;
        $dash3 = $tkPct * $circumference;
    @endphp

    <div class="charts-row">
        {{-- Donut: Lulus vs Tidak --}}
        <div class="chart-card">
            <div class="card-header">
                <svg width="12" height="12" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                <p class="card-title">Lulus vs Tidak Lulus</p>
            </div>
            <div class="card-body">
                <div class="donut-wrap">
                    <svg width="120" height="120" class="donut-svg" viewBox="0 0 120 120">
                        <!-- bg -->
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="none" stroke="#f1f5f9" stroke-width="16"/>
                        @if($total > 0)
                        <!-- lulus -->
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="none"
                            stroke="#16a34a" stroke-width="16"
                            stroke-dasharray="{{ round($dash1,2) }} {{ round($dash2,2) }}"
                            stroke-dashoffset="{{ round($circumference * 0.25, 2) }}"
                            stroke-linecap="round"/>
                        <!-- tidak lulus -->
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="none"
                            stroke="#dc2626" stroke-width="16"
                            stroke-dasharray="{{ round($dash3,2) }} {{ round($dash1+ ($circumference - $dash3),2) }}"
                            stroke-dashoffset="{{ round($circumference * 0.25 - $dash1, 2) }}"
                            stroke-linecap="round"/>
                        @endif
                        <text x="{{ $cx }}" y="{{ $cy - 8 }}" text-anchor="middle" font-family="Plus Jakarta Sans" font-size="14" font-weight="800" fill="#0f172a">{{ $total }}</text>
                        <text x="{{ $cx }}" y="{{ $cy + 10 }}" text-anchor="middle" font-family="DM Sans" font-size="10" fill="#94a3b8">total</text>
                    </svg>
                    <div class="donut-legend">
                        <div class="legend-row">
                            <span class="legend-dot" style="background:#16a34a"></span>
                            <span class="legend-label">Lulus (≥75)</span>
                            <span class="legend-val" style="color:#16a34a">{{ $lulus }}</span>
                            <span style="font-size:11.5px; color:var(--text3); min-width:38px; text-align:right">
                                {{ $total > 0 ? round($lulus/$total*100,1) : 0 }}%
                            </span>
                        </div>
                        <div class="legend-row">
                            <span class="legend-dot" style="background:#dc2626"></span>
                            <span class="legend-label">Tidak Lulus (&lt;75)</span>
                            <span class="legend-val" style="color:#dc2626">{{ $tkLulus }}</span>
                            <span style="font-size:11.5px; color:var(--text3); min-width:38px; text-align:right">
                                {{ $total > 0 ? round($tkLulus/$total*100,1) : 0 }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grade Distribution --}}
        <div class="chart-card">
            <div class="card-header">
                <svg width="12" height="12" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                </svg>
                <p class="card-title">Distribusi Predikat</p>
            </div>
            <div class="card-body">
                <div class="dist-row">
                    @php
                        $distItems = [
                            ['label'=>'A','count'=>$gradeA,'range'=>'≥90','color'=>'#16a34a'],
                            ['label'=>'B','count'=>$gradeB,'range'=>'75–89','color'=>'#1f63db'],
                            ['label'=>'C','count'=>$gradeC,'range'=>'60–74','color'=>'#d97706'],
                            ['label'=>'D','count'=>$gradeD,'range'=>'<60','color'=>'#dc2626'],
                        ];
                    @endphp
                    @foreach($distItems as $d)
                    <div class="dist-item">
                        <span class="dist-label" style="color:{{ $d['color'] }}">{{ $d['label'] }}</span>
                        <div class="dist-bar-wrap">
                            <div class="dist-bar" style="width:{{ $maxDist > 0 ? round($d['count']/$maxDist*100) : 0 }}%; background:{{ $d['color'] }}"></div>
                        </div>
                        <span class="dist-count">{{ $d['count'] }}</span>
                        <span class="dist-pct">{{ $total > 0 ? round($d['count']/$total*100,1) : 0 }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Detail table --}}
    <div class="table-card">
        <div class="table-top">
            <div style="display:flex;align-items:center;gap:8px">
                <p class="table-title">Data Lengkap</p>
                <span class="table-count">{{ $grades->count() }} data</span>
            </div>
        </div>

        @if($grades->count())
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Siswa</th>
                    <th>Kelas</th>
                    <th>Mata Pelajaran</th>
                    <th class="center">Tugas</th>
                    <th class="center">UTS</th>
                    <th class="center">UAS</th>
                    <th class="center">Nilai Akhir</th>
                    <th class="center">Predikat</th>
                    <th class="center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades->sortByDesc('nilai_akhir') as $i => $grade)
                @php
                    $na  = $grade->nilai_akhir ?? 0;
                    $cls = $na >= 90 ? 'score-a' : ($na >= 75 ? 'score-b' : ($na >= 60 ? 'score-c' : 'score-d'));
                    $gl  = $na >= 90 ? 'A' : ($na >= 75 ? 'B' : ($na >= 60 ? 'C' : 'D'));
                    $initials = collect(explode(' ', $grade->student->name ?? 'S'))->map(fn($w)=>strtoupper($w[0]))->take(2)->implode('');
                @endphp
                <tr>
                    <td style="color:var(--text3); font-size:12px; font-weight:700">{{ $loop->iteration }}</td>
                    <td>
                        <div class="student-info">
                            <div class="avatar">{{ $initials }}</div>
                            <div>
                                <p class="student-name">{{ $grade->student->name ?? '—' }}</p>
                                <p class="student-nisn">{{ $grade->student->nisn ?? '—' }}</p>
                            </div>
                        </div>
                    </td>
                    <td style="color:var(--text2); font-weight:600">{{ $grade->student->class->nama_kelas ?? '—' }}</td>
                    <td style="color:var(--text2)">{{ $grade->subject->nama_mapel ?? '—' }}</td>
                    <td class="center"><span class="score-cell {{ $grade->nilai_tugas >= 75 ? 'score-b' : 'score-c' }}">{{ $grade->nilai_tugas ?? '—' }}</span></td>
                    <td class="center"><span class="score-cell {{ $grade->nilai_uts >= 75 ? 'score-b' : 'score-c' }}">{{ $grade->nilai_uts ?? '—' }}</span></td>
                    <td class="center"><span class="score-cell {{ $grade->nilai_uas >= 75 ? 'score-b' : 'score-c' }}">{{ $grade->nilai_uas ?? '—' }}</span></td>
                    <td class="center"><span class="score-cell {{ $cls }}" style="font-size:14px">{{ number_format($na, 2) }}</span></td>
                    <td class="center"><span class="score-cell {{ $cls }}" style="font-size:15px">{{ $gl }}</span></td>
                    <td class="center">
                        @if($na >= 75)
                            <span class="badge badge-success">Lulus</span>
                        @else
                            <span class="badge badge-danger">Tidak Lulus</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div style="padding:48px 20px; text-align:center">
            <p style="font-family:'Plus Jakarta Sans',sans-serif; font-size:14px; font-weight:800; color:var(--text); margin-bottom:6px">Belum ada data</p>
            <p style="font-size:13px; color:var(--text3)">Ubah filter untuk menampilkan data nilai.</p>
        </div>
        @endif
    </div>

</div>
</x-app-layout>