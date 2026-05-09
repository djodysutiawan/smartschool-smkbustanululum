<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;--brand-100:#d9ebff;--brand-50:#eef6ff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;}
    *{box-sizing:border-box;}
    .page{padding:28px 28px 48px;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-outline{background:var(--surface);color:var(--text2);border:1px solid var(--border);}
    .btn-outline:hover{background:var(--surface2);filter:none;}
    .btn-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-pdf:hover{background:#fee2e2;filter:none;}
    .btn-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-excel:hover{background:#dcfce7;filter:none;}
    .btn-sm{padding:5px 11px;font-size:11.5px;border-radius:6px;}

    /* Stats — 4 kolom sesuai $statsU controller */
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;display:flex;align-items:center;gap:10px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}
    .stat-icon.green{background:#f0fdf4;}
    .stat-icon.yellow{background:#fefce8;}
    .stat-icon.orange{background:#fff7ed;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .stat-note{font-size:11px;color:var(--text3);margin-top:2px;font-family:'DM Sans',sans-serif;}

    /* Charts */
    .charts-row{display:grid;grid-template-columns:1fr 320px;gap:16px;margin-bottom:16px;}
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .card-header{padding:13px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between;}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .card-sub{font-size:11.5px;color:var(--text3);}
    .card-body{padding:16px 20px;}
    .chart-wrap{position:relative;height:220px;}

    /* Filter */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;}
    .filter-grid{display:grid;grid-template-columns:repeat(3,1fr) auto auto;gap:10px;align-items:end;}
    .filter-row-2{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-top:10px;}
    .filter-row-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-top:10px;}
    .field{display:flex;flex-direction:column;gap:5px;}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);}
    .field input,.field select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;}
    .field input:focus,.field select:focus{border-color:var(--brand-500);background:#fff;}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap;}
    .btn-filter:hover{background:var(--brand-700);}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;white-space:nowrap;}
    .btn-reset:hover{background:var(--surface3);}

    /* Table */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:13px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:8px;}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px;}
    .table-actions{display:flex;gap:7px;}
    .table-wrap{overflow-x:auto;}
    table{width:100%;border-collapse:collapse;font-size:13.5px;}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
    thead th.center{text-align:center;}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:#fafbff;}
    td{padding:10px 14px;color:var(--text);vertical-align:middle;}
    td.center{text-align:center;}
    td.muted{color:var(--text3);font-size:12.5px;}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);}

    /* Badge status ujian — sesuai $statsU controller: aktif, selesai */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-aktif{background:#dcfce7;color:#15803d;}.badge-aktif .badge-dot{background:#15803d;}
    .badge-tidak-aktif{background:#f1f5f9;color:#475569;}.badge-tidak-aktif .badge-dot{background:#64748b;}
    .badge-selesai{background:#dbeafe;color:#1d4ed8;}.badge-selesai .badge-dot{background:#1d4ed8;}
    .badge-draft{background:#f1f5f9;color:#475569;}.badge-draft .badge-dot{background:#64748b;}
    .badge-dijadwalkan{background:#fef9c3;color:#a16207;}.badge-dijadwalkan .badge-dot{background:#a16207;}
    .badge-dibatalkan{background:#fee2e2;color:#dc2626;}.badge-dibatalkan .badge-dot{background:#dc2626;}

    /* Tipe ujian pill */
    .tipe-pill{display:inline-block;padding:2px 9px;border-radius:5px;font-size:11.5px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;}
    .tipe-uts{background:#f0f9ff;color:#0284c7;border:1px solid #bae6fd;}
    .tipe-uas{background:#faf5ff;color:#7c3aed;border:1px solid #e9d5ff;}
    .tipe-harian{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .tipe-remedial{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;}
    .tipe-default{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}

    /* Empty & model not found state */
    .empty-state{padding:50px 20px;text-align:center;}
    .empty-icon{width:52px;height:52px;background:var(--surface2);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--text);margin-bottom:4px;}
    .empty-sub{font-size:13px;color:var(--text3);}

    /* Alert info model belum tersedia */
    .alert-warning{display:flex;align-items:flex-start;gap:10px;padding:14px 18px;background:#fffbeb;border:1px solid #fde68a;border-radius:var(--radius);margin-bottom:20px;}
    .alert-warning-icon{flex-shrink:0;margin-top:1px;}
    .alert-warning-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:#92400e;margin-bottom:2px;}
    .alert-warning-sub{font-size:12.5px;color:#a16207;}

    /* Pagination */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:13px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .pag-info{font-size:12.5px;color:var(--text3);}
    .pag-btns{display:flex;gap:4px;}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none;}
    .pag-btn:hover{background:var(--surface2);}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff;}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;display:flex;align-items:center;}

    @media(max-width:900px){
        .stats-strip{grid-template-columns:1fr 1fr;}
        .charts-row{grid-template-columns:1fr;}
        .filter-grid{grid-template-columns:1fr 1fr;}
        .filter-row-2{grid-template-columns:1fr 1fr;}
        .filter-row-3{grid-template-columns:1fr 1fr;}
        .page{padding:16px;}
    }
    @media(max-width:600px){
        .stats-strip{grid-template-columns:1fr 1fr;}
    }
</style>

<div class="page">

    {{-- ══ HEADER ══ --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Ujian</h1>
            <p class="page-sub">Rekap data ujian siswa — tren, distribusi status, dan ekspor</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- ══ GUARD: Model Ujian belum tersedia ══
         Controller mengembalikan $ujians = collect() jika class_exists(Ujian) false.
         Tampilkan pesan informatif agar tidak membingungkan.
    --}}
    @if($ujians instanceof \Illuminate\Support\Collection && $ujians->isEmpty() && $statsU['total'] === 0)
    <div class="alert-warning">
        <div class="alert-warning-icon">
            <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <div>
            <p class="alert-warning-title">Model Ujian Belum Tersedia</p>
            <p class="alert-warning-sub">
                Data ujian belum dapat ditampilkan karena model <code>App\Models\Ujian</code> belum dibuat.
                Buat model beserta migrasinya terlebih dahulu, lalu muat ulang halaman ini.
            </p>
        </div>
    </div>
    @endif

    {{-- ══ STAT CARDS — 4 kolom dari $statsU controller ══ --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="17" height="17" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Ujian</p>
                <p class="stat-val">{{ number_format($statsU['total']) }}</p>
                <p class="stat-note">semua data ujian</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="17" height="17" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Bulan Ini</p>
                <p class="stat-val">{{ number_format($statsU['bulan_ini']) }}</p>
                <p class="stat-note">{{ now()->translatedFormat('F Y') }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="17" height="17" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            <div>
                <p class="stat-label">Aktif</p>
                <p class="stat-val">{{ number_format($statsU['aktif']) }}</p>
                <p class="stat-note">sedang berlangsung</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:#f1f5f9;">
                <svg width="17" height="17" fill="none" stroke="#475569" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
            </div>
            <div>
                <p class="stat-label">Tidak Aktif</p>
                <p class="stat-val">{{ number_format($statsU['tidak_aktif'] ?? 0) }}</p>
                <p class="stat-note">ujian dinonaktifkan</p>
            </div>
        </div>
    </div>

    {{-- ══ CHARTS ══
         trendChart  → $trendLabels, $trendUjian (14 hari, GROUP BY di controller)
         statusChart → distribusi status aktif vs selesai dari $statsU
    --}}
    <div class="charts-row">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Tren Ujian 14 Hari Terakhir</span>
                <span class="card-sub">Berdasarkan tanggal_mulai</span>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="trendChart"></canvas></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <span class="card-title">Komposisi Status</span>
                <span class="card-sub">Seluruh data ujian (global)</span>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="statusChart"></canvas></div>
            </div>
        </div>
    </div>

    {{-- ══ FILTER ══
         Sesuai applyUjianFilters():
         tanggal_dari, tanggal_sampai, kelas_id, mata_pelajaran_id, guru_id, tahun_ajaran_id, status, search
    --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.laporan.ujian') }}">
            <div class="filter-grid">
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
                    <label>Status</label>
                    <select name="status">
                        <option value="">Semua Status</option>
                        <option value="aktif"        {{ request('status') === 'aktif'        ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai"      {{ request('status') === 'selesai'      ? 'selected' : '' }}>Selesai</option>
                        <option value="draft"        {{ request('status') === 'draft'        ? 'selected' : '' }}>Draft</option>
                        <option value="dijadwalkan"  {{ request('status') === 'dijadwalkan'  ? 'selected' : '' }}>Dijadwalkan</option>
                        <option value="dibatalkan"   {{ request('status') === 'dibatalkan'   ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <a href="{{ route('admin.laporan.ujian') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Filter</button>
            </div>
            <div class="filter-row-2">
                <div class="field">
                    <label>Guru</label>
                    <select name="guru_id">
                        <option value="">Semua Guru</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>
                                {{ $g->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Tahun Ajaran</label>
                    <select name="tahun_ajaran_id">
                        <option value="">Semua Tahun Ajaran</option>
                        @foreach($tahunAjaran as $ta)
                            <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                {{ $ta->tahun ?? $ta->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}">
                </div>
                <div class="field">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}">
                </div>
            </div>
            <div class="filter-row-3">
                <div class="field">
                    <label>Cari Judul / Mapel</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Judul ujian atau nama mapel...">
                </div>
            </div>
        </form>
    </div>

    {{-- ══ TABEL ══ --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Data Ujian
                @if($ujians instanceof \Illuminate\Pagination\LengthAwarePaginator && $ujians->total() > 0)
                    <span>— {{ $ujians->firstItem() }}–{{ $ujians->lastItem() }} dari {{ number_format($ujians->total()) }} record</span>
                @else
                    <span>— Tidak ada data</span>
                @endif
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.laporan.ujian.export.pdf', request()->query()) }}"
                   class="btn btn-sm btn-pdf" target="_blank">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.laporan.ujian.export.excel', request()->query()) }}"
                   class="btn btn-sm btn-excel">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M3 15h18M9 3v18"/></svg>
                    Export Excel
                </a>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Judul Ujian</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Guru</th>
                        <th>Tanggal</th>
                        <th>Durasi</th>
                        <th>Tahun Ajaran</th>
                        <th>Tipe</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if($ujians instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        @forelse($ujians as $i => $ujian)
                        @php
                            // is_active (boolean cast di model), bukan kolom 'status'
                            $isAktif    = (bool) $ujian->is_active;
                            $st         = $isAktif ? 'aktif' : 'tidak-aktif';
                            $stLabel    = $isAktif ? 'Aktif' : 'Tidak Aktif';

                            // kolom jenis: ulangan_harian | uts | uas | remedial | quiz
                            $jenis = strtolower($ujian->jenis ?? '');
                            $tipeClass = match($jenis) {
                                'uts'             => 'tipe-uts',
                                'uas'             => 'tipe-uas',
                                'ulangan_harian'  => 'tipe-harian',
                                'remedial'        => 'tipe-remedial',
                                default           => 'tipe-default',
                            };
                            $jenisLabel = match($jenis) {
                                'uts'            => 'UTS',
                                'uas'            => 'UAS',
                                'ulangan_harian' => 'Ulangan',
                                'remedial'       => 'Remedial',
                                'quiz'           => 'Quiz',
                                default          => strtoupper($jenis) ?: '—',
                            };
                        @endphp
                        <tr>
                            <td><span class="no-col">{{ $ujians->firstItem() + $i }}</span></td>

                            {{-- Judul ujian --}}
                            <td>
                                <p style="font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;line-height:1.3;">
                                    {{ $ujian->judul ?? '—' }}
                                </p>
                                @if($ujian->deskripsi ?? false)
                                    <p style="font-size:11.5px;color:var(--text3);font-family:'DM Sans',sans-serif;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                        {{ $ujian->deskripsi }}
                                    </p>
                                @endif
                            </td>

                            {{-- Mata Pelajaran — relasi mataPelajaran --}}
                            <td class="muted">{{ $ujian->mataPelajaran->nama_mapel ?? '—' }}</td>

                            {{-- Kelas — relasi kelas --}}
                            <td class="muted">{{ $ujian->kelas->nama_kelas ?? '—' }}</td>

                            {{-- Guru — relasi guru --}}
                            <td>
                                <p style="font-size:13px;font-family:'Plus Jakarta Sans',sans-serif;">
                                    {{ $ujian->guru->nama_lengkap ?? '—' }}
                                </p>
                            </td>

                            {{-- Tanggal — kolom: tanggal (cast:date), jam_mulai, durasi_menit --}}
                            <td style="font-size:13px;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;white-space:nowrap;">
                                {{ optional($ujian->tanggal)->format('d M Y') ?? '—' }}
                                @if($ujian->jam_mulai)
                                    <br><span style="font-size:11.5px;font-weight:400;color:var(--text3);">{{ \Carbon\Carbon::parse($ujian->jam_mulai)->format('H:i') }}</span>
                                @endif
                            </td>

                            {{-- Durasi — kolom: durasi_menit --}}
                            <td class="muted" style="font-family:'DM Sans',sans-serif;">
                                @if($ujian->durasi_menit)
                                    {{ $ujian->durasi_menit }} menit
                                @else
                                    —
                                @endif
                            </td>

                            {{-- Tahun Ajaran — relasi tahunAjaran --}}
                            <td class="muted">{{ $ujian->tahunAjaran->tahun ?? $ujian->tahunAjaran->nama ?? '—' }}</td>

                            {{-- Jenis ujian — enum: ulangan_harian|uts|uas|remedial|quiz --}}
                            <td>
                                @if($jenis)
                                    <span class="tipe-pill {{ $tipeClass }}">{{ $jenisLabel }}</span>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </td>

                            {{-- Status — dari is_active boolean --}}
                            <td>
                                <span class="badge badge-{{ $st }}">
                                    <span class="badge-dot"></span>{{ $stLabel }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    </div>
                                    <p class="empty-title">Tidak ada data ujian</p>
                                    <p class="empty-sub">Coba ubah filter atau reset pencarian</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    @else
                        {{-- Model belum tersedia → tampilkan empty state --}}
                        <tr>
                            <td colspan="10">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    </div>
                                    <p class="empty-title">Data Belum Tersedia</p>
                                    <p class="empty-sub">Model Ujian belum dibuat. Buat model terlebih dahulu.</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Pagination — hanya render jika $ujians adalah paginator --}}
        @if($ujians instanceof \Illuminate\Pagination\LengthAwarePaginator && $ujians->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">
                Menampilkan {{ $ujians->firstItem() }} – {{ $ujians->lastItem() }}
                dari {{ number_format($ujians->total()) }} data
            </p>
            <div class="pag-btns">
                @if($ujians->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $ujians->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                @foreach($ujians->getUrlRange(1, $ujians->lastPage()) as $page => $url)
                    @if($page == $ujians->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $ujians->lastPage() || abs($page - $ujians->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $ujians->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                @if($ujians->hasMorePages())
                    <a href="{{ $ujians->nextPageUrl() }}" class="pag-btn">
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
        Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
        Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif

    Chart.defaults.font.family = "'DM Sans', sans-serif";
    Chart.defaults.color = '#94a3b8';

    {{--
        Tren 14 hari — $trendLabels, $trendUjian
        Dikirim controller via satu GROUP BY query pada Ujian.tanggal_mulai.
    --}}
    new Chart(document.getElementById('trendChart'), {
        type: 'bar',
        data: {
            labels: @json($trendLabels ?? []),
            datasets: [{
                label: 'Jumlah Ujian',
                data: @json($trendUjian ?? []),
                backgroundColor: 'rgba(31,99,219,.15)',
                borderColor: '#1f63db',
                borderWidth: 2,
                borderRadius: 5,
                hoverBackgroundColor: 'rgba(31,99,219,.3)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.raw} ujian`
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, grid: { color:'#f1f5f9' }, ticks: { stepSize:1 } },
                x: { grid: { display:false } }
            }
        }
    });

    {{--
        Komposisi status — dari $statsU (total, bulan_ini, aktif, selesai).
        Hanya aktif & selesai yang relevan untuk chart distribusi.
        Jika ada status lain di model, tambahkan di sini.
    --}}
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Aktif', 'Tidak Aktif'],
            datasets: [{
                data: [
                    {{ $statsU['aktif']   ?? 0 }},
                    {{ $statsU['tidak_aktif'] ?? max(0, ($statsU['total'] ?? 0) - ($statsU['aktif'] ?? 0)) }},
                ],
                backgroundColor: ['#22c55e', '#94a3b8'],
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    display: true,
                    position: 'right',
                    labels: {
                        boxWidth: 10,
                        padding: 8,
                        font: { family:"'Plus Jakarta Sans'", weight:'700', size:11 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.raw}`
                    }
                }
            }
        }
    });
</script>
</x-app-layout>