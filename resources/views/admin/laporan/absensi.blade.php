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

    /* Stats strip — 5 kolom sesuai 5 rekap dari controller */
    .stats-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;display:flex;align-items:center;gap:10px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}
    .stat-icon.green{background:#f0fdf4;}
    .stat-icon.yellow{background:#fefce8;}
    .stat-icon.orange{background:#fff7ed;}
    .stat-icon.red{background:#fff0f0;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .stat-note{font-size:11px;color:var(--text3);margin-top:2px;font-family:'DM Sans',sans-serif;}

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
    .filter-row-2{display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-top:10px;}
    .field{display:flex;flex-direction:column;gap:5px;}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);}
    .field input,.field select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;}
    .field input:focus,.field select:focus{border-color:var(--brand-500);background:#fff;}
    .field input[type=text]{padding:0 12px;}
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

    /* Badges */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-hadir{background:#dcfce7;color:#15803d;}.badge-hadir .badge-dot{background:#15803d;}
    .badge-telat{background:#fef9c3;color:#a16207;}.badge-telat .badge-dot{background:#a16207;}
    .badge-izin{background:#dbeafe;color:#1d4ed8;}.badge-izin .badge-dot{background:#1d4ed8;}
    .badge-sakit{background:#ffedd5;color:#c2410c;}.badge-sakit .badge-dot{background:#c2410c;}
    .badge-alfa{background:#fee2e2;color:#dc2626;}.badge-alfa .badge-dot{background:#dc2626;}

    .metode-pill{display:inline-block;padding:2px 9px;border-radius:5px;font-size:11.5px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;}
    .metode-manual{background:#f0f9ff;color:#0284c7;border:1px solid #bae6fd;}
    .metode-qr{background:#faf5ff;color:#7c3aed;border:1px solid #e9d5ff;}

    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-del:hover{background:#fee2e2;filter:none;}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}

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

    /* Alert filter aktif */
    .filter-notice{display:flex;align-items:center;gap:8px;padding:8px 14px;background:#fffbeb;border:1px solid #fde68a;border-radius:var(--radius-sm);font-size:12.5px;color:#92400e;font-family:'DM Sans',sans-serif;margin-bottom:12px;}
    .filter-notice svg{flex-shrink:0;}

    @media(max-width:900px){
        .stats-strip{grid-template-columns:1fr 1fr 1fr;}
        .charts-row{grid-template-columns:1fr;}
        .filter-grid{grid-template-columns:1fr 1fr;}
        .filter-row-2{grid-template-columns:1fr 1fr;}
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
            <h1 class="page-title">Laporan Absensi</h1>
            <p class="page-sub">Data kehadiran siswa — filter, rekap, dan ekspor per kelas</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.absensi.create') }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Absensi
            </a>
        </div>
    </div>

    {{-- ══ STAT CARDS ══
         Sumber: $rekap dari controller — dihitung berdasarkan filter aktif (bukan hanya hari ini).
         Jika tidak ada filter, menampilkan data seluruh periode.
    --}}
    @if(request()->hasAny(['tanggal_dari','tanggal_sampai','kelas_id','status','metode','search']))
    <div class="filter-notice">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Statistik di bawah dihitung berdasarkan filter yang aktif, bukan keseluruhan data.
    </div>
    @endif

    <div class="stats-strip">
        {{-- Total data (dari paginator) --}}
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="17" height="17" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Data</p>
                <p class="stat-val">{{ number_format($absensi->total()) }}</p>
                <p class="stat-note">record ditemukan</p>
            </div>
        </div>

        {{-- Hadir (hadir + telat) — dari $rekap sesuai filter --}}
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="17" height="17" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Hadir</p>
                <p class="stat-val">{{ number_format($rekap['hadir'] ?? 0) }}</p>
                <p class="stat-note">termasuk telat</p>
            </div>
        </div>

        {{-- Izin --}}
        <div class="stat-card">
            <div class="stat-icon" style="background:#dbeafe;">
                <svg width="17" height="17" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            </div>
            <div>
                <p class="stat-label">Izin</p>
                <p class="stat-val">{{ number_format($rekap['izin'] ?? 0) }}</p>
                <p class="stat-note">dengan surat</p>
            </div>
        </div>

        {{-- Sakit --}}
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="17" height="17" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </div>
            <div>
                <p class="stat-label">Sakit</p>
                <p class="stat-val">{{ number_format($rekap['sakit'] ?? 0) }}</p>
                <p class="stat-note">dengan keterangan</p>
            </div>
        </div>

        {{-- Alfa (tidak hadir tanpa keterangan) --}}
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="17" height="17" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
            </div>
            <div>
                <p class="stat-label">Alfa</p>
                <p class="stat-val">{{ number_format($rekap['alfa'] ?? 0) }}</p>
                <p class="stat-note">tanpa keterangan</p>
            </div>
        </div>
    </div>

    {{-- ══ CHARTS ══
         trendChart  → $trendLabels, $trendHadir, $trendTidak   (14 hari, GROUP BY dari controller)
         statusChart → $statusCount (distribusi global seluruh DB, bukan dari filter)
    --}}
    <div class="charts-row">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Tren Absensi 14 Hari Terakhir</span>
                <span class="card-sub">Hadir vs Tidak Hadir (izin + sakit + alfa)</span>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="trendChart"></canvas></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <span class="card-title">Komposisi Status</span>
                <span class="card-sub">Seluruh data (global)</span>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="statusChart"></canvas></div>
            </div>
        </div>
    </div>

    {{-- ══ FILTER ══
         Filter sesuai applyAbsensiFilters():
         tanggal_dari, tanggal_sampai, kelas_id, status, metode, search
    --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.laporan.absensi') }}">
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
                        @foreach($statusList as $s)
                            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Metode</label>
                    <select name="metode">
                        <option value="">Semua Metode</option>
                        @foreach($metodeList as $m)
                            <option value="{{ $m }}" {{ request('metode') == $m ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $m)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <a href="{{ route('admin.laporan.absensi') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Filter</button>
            </div>
            <div class="filter-row-2">
                <div class="field">
                    <label>Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}">
                </div>
                <div class="field">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="field">
                    <label>Cari Nama / NIS</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama siswa atau NIS...">
                </div>
            </div>
        </form>
    </div>

    {{-- ══ TABEL ══ --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Data Absensi
                @if($absensi->total() > 0)
                    <span>— {{ $absensi->firstItem() }}–{{ $absensi->lastItem() }} dari {{ number_format($absensi->total()) }} record</span>
                @else
                    <span>— Tidak ada data</span>
                @endif
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.laporan.absensi.export.pdf', request()->query()) }}"
                   class="btn btn-sm btn-pdf" target="_blank">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.laporan.absensi.export.excel', request()->query()) }}"
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
                        <th>Jam Masuk</th>
                        <th>Status</th>
                        <th>Metode</th>
                        <th>Dicatat Oleh</th>
                        <th>Keterangan</th>
                        <th class="center" style="width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $i => $a)
                    <tr>
                        <td><span class="no-col">{{ $absensi->firstItem() + $i }}</span></td>

                        {{-- Siswa --}}
                        <td>
                            <p style="font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;line-height:1.3;">
                                {{ $a->siswa->nama_lengkap ?? '—' }}
                            </p>
                            @if($a->siswa->nis ?? false)
                                <p style="font-size:11.5px;color:var(--text3);font-family:'DM Sans',sans-serif;">
                                    NIS: {{ $a->siswa->nis }}
                                </p>
                            @endif
                        </td>

                        {{-- Kelas — dari relasi siswa.kelas --}}
                        <td class="muted">{{ $a->siswa->kelas->nama_kelas ?? '—' }}</td>

                        {{-- Tanggal --}}
                        <td style="font-size:13px;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;white-space:nowrap;">
                            {{ optional($a->tanggal)->format('d M Y') ?? '—' }}
                        </td>

                        {{-- Jam masuk --}}
                        <td class="muted" style="font-family:'DM Sans',sans-serif;">
                            {{ $a->jam_masuk ?? '—' }}
                        </td>

                        {{-- Status badge --}}
                        <td>
                            @php $st = $a->status ?? 'alfa'; @endphp
                            <span class="badge badge-{{ $st }}">
                                <span class="badge-dot"></span>{{ ucfirst($st) }}
                            </span>
                        </td>

                        {{-- Metode --}}
                        <td>
                            @if($a->metode === 'qr_code')
                                <span class="metode-pill metode-qr">QR Code</span>
                            @else
                                <span class="metode-pill metode-manual">Manual</span>
                            @endif
                        </td>

                        {{-- Dicatat oleh (relasi dicatatOleh) --}}
                        <td class="muted" style="font-size:12px;">
                            {{ $a->dicatatOleh->name ?? $a->dicatatOleh->nama_lengkap ?? '—' }}
                        </td>

                        {{-- Keterangan --}}
                        <td class="muted" style="max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            {{ $a->keterangan ?? '—' }}
                        </td>

                        {{-- Aksi --}}
                        <td class="center">
                            <div style="display:flex;gap:4px;justify-content:center;">
                                <a href="{{ route('admin.absensi.show', $a->id) }}"
                                   class="btn btn-sm btn-detail" style="text-decoration:none;">Detail</a>
                                <form action="{{ route('admin.absensi.destroy', $a->id) }}"
                                      method="POST" id="delAbs-{{ $a->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDel(document.getElementById('delAbs-{{ $a->id }}'), '{{ addslashes($a->siswa->nama_lengkap ?? '') }}')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                </div>
                                <p class="empty-title">Tidak ada data absensi</p>
                                <p class="empty-sub">Coba ubah filter atau reset pencarian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($absensi->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">
                Menampilkan {{ $absensi->firstItem() }} – {{ $absensi->lastItem() }}
                dari {{ number_format($absensi->total()) }} data
            </p>
            <div class="pag-btns">
                @if($absensi->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $absensi->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                @foreach($absensi->getUrlRange(1, $absensi->lastPage()) as $page => $url)
                    @if($page == $absensi->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $absensi->lastPage() || abs($page - $absensi->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $absensi->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                @if($absensi->hasMorePages())
                    <a href="{{ $absensi->nextPageUrl() }}" class="pag-btn">
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
    {{-- Flash messages --}}
    @if(session('success'))
        Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
        Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif

    function confirmDel(form, nama) {
        Swal.fire({
            title: 'Hapus Data Absensi?',
            html: `Data absensi siswa <strong>${nama}</strong> akan dihapus permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }

    Chart.defaults.font.family = "'DM Sans', sans-serif";
    Chart.defaults.color = '#94a3b8';

    {{--
        Tren 14 hari — data dari controller via satu GROUP BY query:
        $trendLabels (array tanggal d/m), $trendHadir, $trendTidak
    --}}
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: @json($trendLabels ?? []),
            datasets: [
                {
                    label: 'Hadir',
                    data: @json($trendHadir ?? []),
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34,197,94,.1)',
                    tension: .4,
                    fill: true,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                },
                {
                    label: 'Tidak Hadir',
                    data: @json($trendTidak ?? []),
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
                    labels: { boxWidth: 10, font: { family:"'Plus Jakarta Sans'", weight:'700', size:11 } }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.dataset.label}: ${ctx.raw} siswa`
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
        Komposisi status — dari $statusCount (global seluruh DB, bukan filter aktif).
        Key: hadir, telat, izin, sakit, alfa — semua dijamin ada (default 0) di controller.
    --}}
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Telat', 'Izin', 'Sakit', 'Alfa'],
            datasets: [{
                data: [
                    {{ $statusCount['hadir'] ?? 0 }},
                    {{ $statusCount['telat'] ?? 0 }},
                    {{ $statusCount['izin']  ?? 0 }},
                    {{ $statusCount['sakit'] ?? 0 }},
                    {{ $statusCount['alfa']  ?? 0 }},
                ],
                backgroundColor: ['#22c55e', '#f59e0b', '#3b82f6', '#f97316', '#ef4444'],
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