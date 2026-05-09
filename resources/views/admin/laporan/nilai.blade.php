<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box;}
    .page{padding:28px 28px 48px;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-outline{background:var(--surface);color:var(--text2);border:1px solid var(--border);}
    .btn-outline:hover{background:var(--surface2);filter:none;}
    .btn-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-pdf:hover{background:#fee2e2;filter:none;}
    .btn-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-excel:hover{background:#dcfce7;filter:none;}
    .btn-sm{padding:5px 11px;font-size:11.5px;border-radius:6px;}
    .stats-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;display:flex;align-items:center;gap:10px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}
    .stat-icon.green{background:#f0fdf4;}
    .stat-icon.purple{background:#faf5ff;}
    .stat-icon.orange{background:#fff7ed;}
    .stat-icon.red{background:#fff0f0;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .charts-row-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:16px;}
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .card-header{padding:13px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between;gap:8px;}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .card-sub{font-size:11.5px;color:var(--text3);}
    .card-body{padding:16px 20px;}
    .chart-wrap{position:relative;height:200px;}
    .chart-wrap-lg{position:relative;height:220px;}
    .kkm-note{font-size:11px;color:var(--text3);margin-top:6px;}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;}
    .filter-grid{display:grid;grid-template-columns:repeat(4,1fr) auto auto;gap:10px;align-items:end;}
    .filter-search-row{display:grid;grid-template-columns:1fr;gap:10px;margin-top:10px;}
    .field{display:flex;flex-direction:column;gap:5px;}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);}
    .field input,.field select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;}
    .field input:focus,.field select:focus{border-color:var(--brand-500);background:#fff;}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap;}
    .btn-filter:hover{background:var(--brand-700);}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;white-space:nowrap;}
    .btn-reset:hover{background:var(--surface3);}
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:13px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:8px;}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px;}
    .table-actions{display:flex;gap:7px;}
    .table-wrap{overflow-x:auto;}
    table{width:100%;border-collapse:collapse;font-size:13px;}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
    thead th.center{text-align:center;}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:#fafbff;}
    td{padding:9px 14px;color:var(--text);vertical-align:middle;}
    td.center{text-align:center;}
    td.muted{color:var(--text3);font-size:12.5px;}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);}
    .badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-A{background:#dcfce7;color:#15803d;}
    .badge-B{background:#dbeafe;color:#1d4ed8;}
    .badge-C{background:#fef9c3;color:#a16207;}
    .badge-D{background:#ffedd5;color:#c2410c;}
    .badge-E{background:#fee2e2;color:#dc2626;}
    .nilai-cell{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:14px;}
    .nilai-tinggi{color:#15803d;}
    .nilai-sedang{color:#d97706;}
    .nilai-rendah{color:#dc2626;}
    .btn-sm-detail{padding:4px 10px;font-size:11.5px;border-radius:6px;background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;text-decoration:none;display:inline-flex;}
    .btn-sm-edit{padding:4px 10px;font-size:11.5px;border-radius:6px;background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;text-decoration:none;display:inline-flex;}
    .btn-sm-del{padding:4px 10px;font-size:11.5px;border-radius:6px;background:#fff0f0;color:#dc2626;border:1px solid #fecaca;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;cursor:pointer;}
    .empty-state{padding:50px 20px;text-align:center;}
    .empty-icon{width:52px;height:52px;background:var(--surface2);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--text);margin-bottom:4px;}
    .empty-sub{font-size:13px;color:var(--text3);}
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:13px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .pag-info{font-size:12.5px;color:var(--text3);}
    .pag-btns{display:flex;gap:4px;}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none;}
    .pag-btn:hover{background:var(--surface2);}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff;}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;display:flex;align-items:center;}
    @media(max-width:1100px){.stats-strip{grid-template-columns:repeat(3,1fr);}.charts-row-3{grid-template-columns:1fr 1fr;}}
    @media(max-width:900px){.stats-strip{grid-template-columns:1fr 1fr;}.filter-grid{grid-template-columns:1fr 1fr;}.charts-row-3{grid-template-columns:1fr;}.page{padding:16px;}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">&#128202; Laporan Nilai</h1>
            <p class="page-sub">Data nilai siswa &mdash; tugas, harian, UTS, UAS, dan rekap akhir per kelas &amp; mata pelajaran</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.laporan.nilai.export.pdf', request()->query()) }}" class="btn btn-pdf" target="_blank">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export PDF
            </a>
            <a href="{{ route('admin.laporan.nilai.export.excel', request()->query()) }}" class="btn btn-excel">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                Export Excel
            </a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="17" height="17" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Record</p>
                <p class="stat-val">{{ number_format($nilai->total()) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="17" height="17" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
            <div>
                <p class="stat-label">Rata-rata Nilai</p>
                <p class="stat-val">{{ number_format($stats['rata_nilai'], 1) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="17" height="17" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
            </div>
            <div>
                <p class="stat-label">Predikat A</p>
                <p class="stat-val">{{ number_format($stats['predikat_A']) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="17" height="17" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div>
                <p class="stat-label">Di Bawah KKM</p>
                <p class="stat-val">{{ number_format($stats['bawah_kkm']) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="17" height="17" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
                <p class="stat-label">Predikat E</p>
                <p class="stat-val">{{ number_format($stats['predikat_E']) }}</p>
            </div>
        </div>
    </div>

    <div class="charts-row-3">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Distribusi Predikat</span>
                <span class="card-sub">Seluruh data</span>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="chartPredikat"></canvas></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <span class="card-title">Rata-rata Komponen</span>
                <span class="card-sub">Skala 0&ndash;100</span>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="chartKomponen"></canvas></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <span class="card-title">Rentang Nilai Akhir</span>
                <span class="card-sub">Distribusi skor</span>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="chartRentang"></canvas></div>
            </div>
        </div>
    </div>

    @php
        $rataMapel = $nilai->getCollection()
            ->groupBy(fn($n) => $n->mataPelajaran->nama_mapel ?? 'Unknown')
            ->map(fn($rows) => round($rows->avg('nilai_akhir'), 1))
            ->sortByDesc(fn($v) => $v)
            ->take(8);
    @endphp
    <div class="card" style="margin-bottom:16px;">
        <div class="card-header">
            <span class="card-title">Rata-rata Nilai per Mata Pelajaran</span>
            <span class="card-sub">8 mapel teratas &middot; KKM 70</span>
        </div>
        <div class="card-body">
            <div class="chart-wrap-lg"><canvas id="chartMapel"></canvas></div>
            <p class="kkm-note">&#9888; Garis merah putus-putus = batas KKM (70)</p>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.laporan.nilai') }}">
            <div class="filter-grid">
                <div class="field">
                    <label>Tahun Ajaran</label>
                    <select name="tahun_ajaran_id">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunAjaran as $ta)
                            <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                {{ $ta->tahun }} &ndash; {{ ucfirst($ta->semester) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Kelas</label>
                    <select name="kelas_id">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Mata Pelajaran</label>
                    <select name="mata_pelajaran_id">
                        <option value="">Semua Mapel</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id }}" {{ request('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Predikat</label>
                    <select name="predikat">
                        <option value="">Semua</option>
                        @foreach($predikatList as $p)
                            <option value="{{ $p }}" {{ request('predikat') == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <a href="{{ route('admin.laporan.nilai') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Filter</button>
            </div>
            <div class="filter-search-row">
                <div class="field">
                    <label>Cari Siswa / NIS</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama atau NIS siswa…">
                </div>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Data Nilai
                <span>&mdash; {{ $nilai->firstItem() ?? 0 }}&ndash;{{ $nilai->lastItem() ?? 0 }} dari {{ $nilai->total() }} record</span>
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.laporan.nilai.export.pdf', request()->query()) }}" class="btn btn-sm btn-pdf" target="_blank">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    PDF
                </a>
                <a href="{{ route('admin.laporan.nilai.export.excel', request()->query()) }}" class="btn btn-sm btn-excel">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                    Excel
                </a>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Siswa</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Guru</th>
                        <th>Tahun Ajaran</th>
                        <th class="center">Tugas</th>
                        <th class="center">Harian</th>
                        <th class="center">UTS</th>
                        <th class="center">UAS</th>
                        <th class="center">Nilai Akhir</th>
                        <th class="center">Predikat</th>
                        <th class="center" style="width:130px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilai as $i => $n)
                    <tr>
                        <td><span class="no-col">{{ ($nilai->firstItem() ?? 0) + $i }}</span></td>
                        <td>
                            <p style="font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;">{{ $n->siswa->nama_lengkap ?? '—' }}</p>
                            <p style="font-size:11px;color:var(--text3);">NIS: {{ $n->siswa->nis ?? '—' }}</p>
                        </td>
                        <td>
                            <p style="font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;">{{ $n->mataPelajaran->nama_mapel ?? '—' }}</p>
                            <p style="font-size:11px;color:var(--text3);">{{ $n->mataPelajaran->kode_mapel ?? '' }}</p>
                        </td>
                        <td class="muted">{{ $n->kelas->nama_kelas ?? ($n->siswa->kelas->nama_kelas ?? '—') }}</td>
                        <td class="muted" style="font-size:12px;">{{ $n->guru->nama_lengkap ?? '—' }}</td>
                        <td class="muted" style="font-size:12px;">
                            @if($n->tahunAjaran)
                                {{ $n->tahunAjaran->tahun }}
                                <span style="font-size:11px;color:var(--text3);">({{ ucfirst($n->tahunAjaran->semester) }})</span>
                            @else
                                &mdash;
                            @endif
                        </td>
                        <td class="center" style="font-size:12.5px;font-weight:600;">{{ $n->nilai_tugas  !== null ? $n->nilai_tugas  : '—' }}</td>
                        <td class="center" style="font-size:12.5px;font-weight:600;">{{ $n->nilai_harian !== null ? $n->nilai_harian : '—' }}</td>
                        <td class="center" style="font-size:12.5px;font-weight:600;">{{ $n->nilai_uts    !== null ? $n->nilai_uts    : '—' }}</td>
                        <td class="center" style="font-size:12.5px;font-weight:600;">{{ $n->nilai_uas    !== null ? $n->nilai_uas    : '—' }}</td>
                        <td class="center">
                            @php
                                $na      = (float)($n->nilai_akhir ?? 0);
                                $naClass = $na >= 75 ? 'nilai-tinggi' : ($na >= 60 ? 'nilai-sedang' : 'nilai-rendah');
                            @endphp
                            <span class="nilai-cell {{ $naClass }}">{{ $n->nilai_akhir !== null ? $n->nilai_akhir : '—' }}</span>
                        </td>
                        <td class="center">
                            @if($n->predikat && in_array($n->predikat, ['A','B','C','D','E']))
                                <span class="badge badge-{{ $n->predikat }}">{{ $n->predikat }}</span>
                            @elseif($n->predikat)
                                <span class="badge" style="background:var(--surface3);color:var(--text2);">{{ $n->predikat }}</span>
                            @else
                                <span class="muted">&mdash;</span>
                            @endif
                        </td>
                        <td class="center">
                            <div style="display:flex;gap:4px;justify-content:center;">
                                <a href="{{ route('admin.nilai.show', $n->id) }}" class="btn-sm-detail">Detail</a>
                                <a href="{{ route('admin.nilai.edit',  $n->id) }}" class="btn-sm-edit">Edit</a>
                                <form action="{{ route('admin.nilai.destroy', $n->id) }}" method="POST" id="delForm-{{ $n->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-sm-del"
                                        onclick="confirmDel('{{ $n->id }}','{{ addslashes($n->siswa->nama_lengkap ?? '') }}','{{ addslashes($n->mataPelajaran->nama_mapel ?? '') }}')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
                                </div>
                                <p class="empty-title">Tidak ada data nilai</p>
                                <p class="empty-sub">Coba ubah filter atau reset pencarian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($nilai->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $nilai->firstItem() ?? 0 }}&ndash;{{ $nilai->lastItem() ?? 0 }} dari {{ $nilai->total() }} nilai</p>
            <div class="pag-btns">
                @if($nilai->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $nilai->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif
                @php $cur = $nilai->currentPage(); $last = $nilai->lastPage(); $ellL = false; $ellR = false; @endphp
                @foreach($nilai->getUrlRange(1, $last) as $page => $url)
                    @php $near = abs($page - $cur) <= 1; $edge = $page == 1 || $page == $last; @endphp
                    @if($page == $cur)
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($edge || $near)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(!$ellL && $page < $cur)
                        @php $ellL = true @endphp
                        <span class="pag-ellipsis">&hellip;</span>
                    @elseif(!$ellR && $page > $cur)
                        @php $ellR = true @endphp
                        <span class="pag-ellipsis">&hellip;</span>
                    @endif
                @endforeach
                @if($nilai->hasMorePages())
                    <a href="{{ $nilai->nextPageUrl() }}" class="pag-btn">
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text: @json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text: @json(session('error')), confirmButtonColor:'#1f63db' });
@endif

function confirmDel(id, siswa, mapel) {
    Swal.fire({
        title: 'Hapus Data Nilai?',
        html: 'Nilai <b>' + siswa + '</b> untuk mapel <b>' + mapel + '</b> akan dihapus permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then(function(r) { if (r.isConfirmed) document.getElementById('delForm-' + id).submit(); });
}

Chart.defaults.font.family = "'DM Sans', sans-serif";
Chart.defaults.color = '#94a3b8';

var predikatData = @json($predikatData);
new Chart(document.getElementById('chartPredikat'), {
    type: 'bar',
    data: {
        labels: Object.keys(predikatData),
        datasets: [{
            label: 'Jumlah Siswa',
            data: Object.values(predikatData),
            backgroundColor: ['#22c55e','#3b82f6','#f59e0b','#f97316','#ef4444'],
            borderRadius: 6,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { stepSize: 1 } },
            x: { grid: { display: false } }
        }
    }
});

var komponenData = @json($komponenData);
new Chart(document.getElementById('chartKomponen'), {
    type: 'radar',
    data: {
        labels: Object.keys(komponenData),
        datasets: [{
            label: 'Rata-rata',
            data: Object.values(komponenData),
            borderColor: '#1f63db',
            backgroundColor: 'rgba(31,99,219,.15)',
            pointBackgroundColor: '#1f63db',
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            r: {
                beginAtZero: true,
                max: 100,
                ticks: { stepSize: 20, font: { size: 10 } },
                grid: { color: '#f1f5f9' },
                pointLabels: { font: { family: "'Plus Jakarta Sans'", weight: '700', size: 12 } }
            }
        },
        plugins: { legend: { display: false } }
    }
});

var rentangData = @json($rentangData);
new Chart(document.getElementById('chartRentang'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(rentangData),
        datasets: [{
            data: Object.values(rentangData),
            backgroundColor: ['#22c55e','#84cc16','#f59e0b','#f97316','#ef4444'],
            borderWidth: 2,
            borderColor: '#fff',
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '55%',
        plugins: {
            legend: {
                display: true,
                position: 'right',
                labels: { boxWidth: 10, padding: 8, font: { family: "'Plus Jakarta Sans'", weight: '700', size: 11 } }
            }
        }
    }
});

var mapelLabels = @json($rataMapel->keys()->values());
var mapelValues = @json($rataMapel->values()->values());
var mapelColors = mapelValues.map(function(v) {
    return v >= 75 ? 'rgba(34,197,94,.8)' : v >= 60 ? 'rgba(245,158,11,.8)' : 'rgba(239,68,68,.8)';
});

new Chart(document.getElementById('chartMapel'), {
    type: 'bar',
    data: {
        labels: mapelLabels,
        datasets: [
            {
                label: 'Rata-rata Nilai',
                data: mapelValues,
                backgroundColor: mapelColors,
                borderRadius: 5,
                borderSkipped: false,
                barThickness: 22
            },
            {
                label: 'KKM (70)',
                data: mapelLabels.map(function() { return 70; }),
                type: 'line',
                borderColor: '#ef4444',
                borderDash: [5, 4],
                borderWidth: 1.5,
                pointRadius: 0,
                fill: false,
                tension: 0
            }
        ]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                labels: { boxWidth: 14, font: { family: "'Plus Jakarta Sans'", weight: '700', size: 11 } }
            },
            tooltip: {
                callbacks: {
                    label: function(ctx) {
                        return ctx.datasetIndex === 0 ? ' Rata-rata: ' + ctx.raw : ' KKM: ' + ctx.raw;
                    }
                }
            }
        },
        scales: {
            x: { beginAtZero: true, max: 100, grid: { color: '#f1f5f9' }, ticks: { stepSize: 10 } },
            y: { grid: { display: false } }
        }
    }
});
</script>
</x-app-layout>