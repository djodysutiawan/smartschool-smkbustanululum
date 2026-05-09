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
    .btn-outline{background:var(--surface);color:var(--text2);border:1px solid var(--border);}
    .btn-outline:hover{background:var(--surface2);filter:none;}
    .btn-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-pdf:hover{background:#fee2e2;filter:none;}
    .btn-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-excel:hover{background:#dcfce7;filter:none;}
    .btn-sm{padding:5px 11px;font-size:11.5px;border-radius:6px;}

    /* Stats — 6 kolom sesuai $statsI: total, bulan_ini, disetujui, ditolak, menunggu, sudah_kembali */
    .stats-strip{display:grid;grid-template-columns:repeat(6,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;display:flex;align-items:center;gap:10px;}
    .stat-icon{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}
    .stat-icon.green{background:#f0fdf4;}
    .stat-icon.yellow{background:#fefce8;}
    .stat-icon.red{background:#fff0f0;}
    .stat-icon.orange{background:#fff7ed;}
    .stat-icon.teal{background:#f0fdfa;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .stat-note{font-size:10.5px;color:var(--text3);margin-top:2px;font-family:'DM Sans',sans-serif;}

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
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:#fafbff;}
    td{padding:10px 14px;color:var(--text);vertical-align:middle;}
    td.muted{color:var(--text3);font-size:12.5px;}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);}

    /* Badge status — sesuai IzinKeluarSiswa::STATUS_* */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-menunggu{background:#fef9c3;color:#a16207;}.badge-menunggu .badge-dot{background:#a16207;}
    .badge-disetujui{background:#dcfce7;color:#15803d;}.badge-disetujui .badge-dot{background:#15803d;}
    .badge-ditolak{background:#fee2e2;color:#dc2626;}.badge-ditolak .badge-dot{background:#dc2626;}
    .badge-sudah_kembali{background:#dbeafe;color:#1d4ed8;}.badge-sudah_kembali .badge-dot{background:#1d4ed8;}

    /* Kategori pill */
    .kat-pill{display:inline-block;padding:2px 9px;border-radius:5px;font-size:11.5px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;background:var(--surface2);color:var(--text2);border:1px solid var(--border);}

    /* Distribusi kategori mini chart */
    .distrib-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:4px;}
    .distrib-item{display:flex;align-items:center;justify-content:space-between;font-size:12px;font-family:'DM Sans',sans-serif;color:var(--text2);}
    .distrib-bar-wrap{flex:1;height:6px;background:var(--surface3);border-radius:3px;margin:0 8px;}
    .distrib-bar{height:6px;border-radius:3px;background:var(--brand-500);}
    .distrib-count{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:12px;color:var(--text);min-width:24px;text-align:right;}

    .empty-state{padding:50px 20px;text-align:center;}
    .empty-icon{width:52px;height:52px;background:var(--surface2);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--text);margin-bottom:4px;}
    .empty-sub{font-size:13px;color:var(--text3);}

    /* Pagination */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:13px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .pag-info{font-size:12.5px;color:var(--text3);}
    .pag-btns{display:flex;gap:4px;}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none;}
    .pag-btn:hover{background:var(--surface2);}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff;}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;display:flex;align-items:center;}

    @media(max-width:1100px){.stats-strip{grid-template-columns:repeat(3,1fr);}}
    @media(max-width:900px){
        .stats-strip{grid-template-columns:1fr 1fr;}
        .charts-row{grid-template-columns:1fr;}
        .filter-grid{grid-template-columns:1fr 1fr;}
        .filter-row-2{grid-template-columns:1fr 1fr;}
        .filter-row-3{grid-template-columns:1fr 1fr;}
        .page{padding:16px;}
    }
</style>

<div class="page">

    {{-- ══ HEADER ══ --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Izin Keluar Siswa</h1>
            <p class="page-sub">Rekap permohonan izin keluar — tren, distribusi kategori, dan ekspor</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- ══ STAT CARDS — 6 kolom dari $statsI controller ══
         Keys: total, bulan_ini, disetujui, ditolak, menunggu, sudah_kembali
    --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="16" height="16" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Total</p>
                <p class="stat-val">{{ number_format($statsI['total']) }}</p>
                <p class="stat-note">semua permohonan</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="16" height="16" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Bulan Ini</p>
                <p class="stat-val">{{ number_format($statsI['bulan_ini']) }}</p>
                <p class="stat-note">{{ now()->translatedFormat('F Y') }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:#fef9c3;">
                <svg width="16" height="16" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
                <p class="stat-label">Menunggu</p>
                <p class="stat-val">{{ number_format($statsI['menunggu']) }}</p>
                <p class="stat-note">perlu diproses</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Disetujui</p>
                <p class="stat-val">{{ number_format($statsI['disetujui']) }}</p>
                <p class="stat-note">izin disetujui</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="16" height="16" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div>
                <p class="stat-label">Ditolak</p>
                <p class="stat-val">{{ number_format($statsI['ditolak']) }}</p>
                <p class="stat-note">izin ditolak</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon teal">
                <svg width="16" height="16" fill="none" stroke="#0d9488" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <div>
                <p class="stat-label">Sudah Kembali</p>
                <p class="stat-val">{{ number_format($statsI['sudah_kembali']) }}</p>
                <p class="stat-note">telah kembali</p>
            </div>
        </div>
    </div>

    {{-- ══ CHARTS ══
         trendChart   → $trendLabels, $trendDisetujui, $trendDitolak (14 hari GROUP BY)
         kategoriChart → $distribusiKategori (array label=>jumlah dari KATEGORI_LIST)
    --}}
    <div class="charts-row">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Tren Izin Keluar 14 Hari Terakhir</span>
                <span class="card-sub">Disetujui vs Ditolak</span>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="trendChart"></canvas></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <span class="card-title">Distribusi Kategori</span>
                <span class="card-sub">Seluruh data (global)</span>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="kategoriChart"></canvas></div>
            </div>
        </div>
    </div>

    {{-- ══ FILTER ══
         Sesuai applyIzinKeluarFilters():
         tanggal_dari, tanggal_sampai, status, kategori, tahun_ajaran_id, kelas_id, search
    --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.laporan.izin-keluar') }}">
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
                    <label>Status</label>
                    <select name="status">
                        <option value="">Semua Status</option>
                        <option value="{{ \App\Models\IzinKeluarSiswa::STATUS_MENUNGGU }}"
                            {{ request('status') === \App\Models\IzinKeluarSiswa::STATUS_MENUNGGU ? 'selected' : '' }}>
                            Menunggu
                        </option>
                        <option value="{{ \App\Models\IzinKeluarSiswa::STATUS_DISETUJUI }}"
                            {{ request('status') === \App\Models\IzinKeluarSiswa::STATUS_DISETUJUI ? 'selected' : '' }}>
                            Disetujui
                        </option>
                        <option value="{{ \App\Models\IzinKeluarSiswa::STATUS_DITOLAK }}"
                            {{ request('status') === \App\Models\IzinKeluarSiswa::STATUS_DITOLAK ? 'selected' : '' }}>
                            Ditolak
                        </option>
                        <option value="{{ \App\Models\IzinKeluarSiswa::STATUS_SUDAH_KEMBALI }}"
                            {{ request('status') === \App\Models\IzinKeluarSiswa::STATUS_SUDAH_KEMBALI ? 'selected' : '' }}>
                            Sudah Kembali
                        </option>
                    </select>
                </div>
                <div class="field">
                    <label>Kategori</label>
                    <select name="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach(\App\Models\IzinKeluarSiswa::KATEGORI_LIST as $key => $label)
                            <option value="{{ $key }}" {{ request('kategori') === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <a href="{{ route('admin.laporan.izin-keluar') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Filter</button>
            </div>
            <div class="filter-row-2">
                <div class="field">
                    <label>Tahun Ajaran</label>
                    <select name="tahun_ajaran_id">
                        <option value="">Semua Tahun Ajaran</option>
                        @foreach($tahunAjarans as $ta)
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
                <div class="field">
                    <label>Cari Nama / No. Surat / Tujuan</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama siswa, nomor surat, tujuan...">
                </div>
            </div>
        </form>
    </div>

    {{-- ══ TABEL ══ --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Data Izin Keluar
                @if($izins->total() > 0)
                    <span>— {{ $izins->firstItem() }}–{{ $izins->lastItem() }} dari {{ number_format($izins->total()) }} record</span>
                @else
                    <span>— Tidak ada data</span>
                @endif
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.laporan.izin-keluar.export.pdf', request()->query()) }}"
                   class="btn btn-sm btn-pdf" target="_blank">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.laporan.izin-keluar.export.excel', request()->query()) }}"
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
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Tujuan</th>
                        <th>Jam Keluar</th>
                        <th>Jam Kembali</th>
                        <th>No. Surat</th>
                        <th>Diproses Oleh</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($izins as $i => $izin)
                    @php
                        $status = $izin->status ?? \App\Models\IzinKeluarSiswa::STATUS_MENUNGGU;
                        // Cari label kategori dari KATEGORI_LIST
                        $katLabel = \App\Models\IzinKeluarSiswa::KATEGORI_LIST[$izin->kategori] ?? ucfirst($izin->kategori ?? '—');
                    @endphp
                    <tr>
                        <td><span class="no-col">{{ $izins->firstItem() + $i }}</span></td>

                        {{-- Siswa — relasi siswa --}}
                        <td>
                            <p style="font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;line-height:1.3;">
                                {{ $izin->siswa->nama_lengkap ?? '—' }}
                            </p>
                            @if($izin->siswa->nis ?? false)
                                <p style="font-size:11.5px;color:var(--text3);font-family:'DM Sans',sans-serif;">
                                    NIS: {{ $izin->siswa->nis }}
                                </p>
                            @endif
                        </td>

                        {{-- Kelas — via siswa.kelas --}}
                        <td class="muted">{{ $izin->siswa->kelas->nama_kelas ?? '—' }}</td>

                        {{-- Tanggal --}}
                        <td style="font-size:13px;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;white-space:nowrap;">
                            {{ optional($izin->tanggal)->format('d M Y') ?? '—' }}
                        </td>

                        {{-- Kategori dari KATEGORI_LIST --}}
                        <td>
                            <span class="kat-pill">{{ $katLabel }}</span>
                        </td>

                        {{-- Tujuan --}}
                        <td class="muted" style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            {{ $izin->tujuan ?? '—' }}
                        </td>

                        {{-- Jam keluar --}}
                        <td class="muted" style="font-family:'DM Sans',sans-serif;white-space:nowrap;">
                            @if($izin->jam_keluar)
                                {{ \Carbon\Carbon::parse($izin->jam_keluar)->format('H:i') }}
                            @else
                                —
                            @endif
                        </td>

                        {{-- Jam kembali — null jika belum kembali --}}
                        <td class="muted" style="font-family:'DM Sans',sans-serif;white-space:nowrap;">
                            @if($izin->jam_kembali)
                                {{ \Carbon\Carbon::parse($izin->jam_kembali)->format('H:i') }}
                            @else
                                <span style="color:#f59e0b;font-weight:600;font-size:11.5px;">Belum</span>
                            @endif
                        </td>

                        {{-- Nomor surat --}}
                        <td class="muted" style="font-size:12px;font-family:'DM Sans',sans-serif;">
                            {{ $izin->nomor_surat ?? '—' }}
                        </td>

                        {{-- Diproses oleh — relasi diprosesOleh --}}
                        <td class="muted" style="font-size:12px;">
                            {{ $izin->diprosesOleh->name ?? $izin->diprosesOleh->nama_lengkap ?? '—' }}
                        </td>

                        {{-- Status badge — dari STATUS_* constants --}}
                        <td>
                            <span class="badge badge-{{ $status }}">
                                <span class="badge-dot"></span>
                                {{ ucwords(str_replace('_', ' ', $status)) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                </div>
                                <p class="empty-title">Tidak ada data izin keluar</p>
                                <p class="empty-sub">Coba ubah filter atau reset pencarian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($izins->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">
                Menampilkan {{ $izins->firstItem() }} – {{ $izins->lastItem() }}
                dari {{ number_format($izins->total()) }} data
            </p>
            <div class="pag-btns">
                @if($izins->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $izins->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                @foreach($izins->getUrlRange(1, $izins->lastPage()) as $page => $url)
                    @if($page == $izins->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $izins->lastPage() || abs($page - $izins->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $izins->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                @if($izins->hasMorePages())
                    <a href="{{ $izins->nextPageUrl() }}" class="pag-btn">
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

    // Tren 14 hari — $trendLabels, $trendDisetujui, $trendDitolak
    // Dikirim controller via satu GROUP BY query SUM(CASE WHEN...) pada IzinKeluarSiswa
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: @json($trendLabels ?? []),
            datasets: [
                {
                    label: 'Disetujui',
                    data: @json($trendDisetujui ?? []),
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34,197,94,.1)',
                    tension: .4,
                    fill: true,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                },
                {
                    label: 'Ditolak',
                    data: @json($trendDitolak ?? []),
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239,68,68,.07)',
                    tension: .4,
                    fill: true,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                },
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: { boxWidth:10, font:{ family:"'Plus Jakarta Sans'", weight:'700', size:11 } }
                },
                tooltip: {
                    callbacks: { label: ctx => ` ${ctx.dataset.label}: ${ctx.raw}` }
                }
            },
            scales: {
                y: { beginAtZero:true, grid:{ color:'#f1f5f9' }, ticks:{ stepSize:1 } },
                x: { grid:{ display:false } }
            }
        }
    });

    // Distribusi kategori — $distribusiKategori
    // Array dari controller: foreach KATEGORI_LIST → IzinKeluarSiswa::where('kategori',$key)->count()
    // Key = label kategori (string), value = jumlah
    @php
        $katLabels = array_keys($distribusiKategori ?? []);
        $katData   = array_values($distribusiKategori ?? []);
        $katColors = ['#3b82f6','#22c55e','#f59e0b','#ef4444','#a855f7','#0d9488','#f97316','#6366f1'];
    @endphp
    new Chart(document.getElementById('kategoriChart'), {
        type: 'doughnut',
        data: {
            labels: @json($katLabels),
            datasets: [{
                data: @json($katData),
                backgroundColor: @json(array_slice($katColors, 0, count($katLabels))),
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
                        font: { family:"'Plus Jakarta Sans'", weight:'700', size:10 }
                    }
                },
                tooltip: {
                    callbacks: { label: ctx => ` ${ctx.label}: ${ctx.raw}` }
                }
            }
        }
    });
</script>
</x-app-layout>