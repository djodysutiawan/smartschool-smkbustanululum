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

    /* Stats — 4 kolom sesuai $statsLP controller */
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;display:flex;align-items:center;gap:10px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}
    .stat-icon.green{background:#f0fdf4;}
    .stat-icon.yellow{background:#fefce8;}
    .stat-icon.purple{background:#faf5ff;}
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
    .filter-grid{display:grid;grid-template-columns:repeat(4,1fr) auto auto;gap:10px;align-items:end;}
    .filter-row-2{display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-top:10px;}
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

    /* Badges status piket — bertugas / selesai / belum */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-bertugas{background:#fef9c3;color:#a16207;}.badge-bertugas .badge-dot{background:#a16207;}
    .badge-selesai{background:#dcfce7;color:#15803d;}.badge-selesai .badge-dot{background:#15803d;}
    .badge-belum{background:#fee2e2;color:#dc2626;}.badge-belum .badge-dot{background:#dc2626;}

    /* Shift pill */
    .shift-pill{display:inline-block;padding:2px 9px;border-radius:5px;font-size:11.5px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;}
    .shift-pagi{background:#f0f9ff;color:#0284c7;border:1px solid #bae6fd;}
    .shift-siang{background:#fffbeb;color:#b45309;border:1px solid #fde68a;}
    .shift-sore{background:#faf5ff;color:#7c3aed;border:1px solid #e9d5ff;}
    .shift-malam{background:#0f172a;color:#e2e8f0;border:1px solid #334155;}
    .shift-default{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}

    /* Duration badge */
    .dur-badge{display:inline-block;padding:2px 8px;border-radius:5px;font-size:11.5px;font-weight:600;font-family:'DM Sans',sans-serif;background:#f1f5f9;color:var(--text2);}

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

    @media(max-width:900px){
        .stats-strip{grid-template-columns:1fr 1fr;}
        .charts-row{grid-template-columns:1fr;}
        .filter-grid{grid-template-columns:1fr 1fr;}
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
            <h1 class="page-title">Laporan Log Piket</h1>
            <p class="page-sub">Rekap kehadiran piket guru — tren, distribusi shift, dan ekspor</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- ══ STAT CARDS — 4 kolom dari $statsLP controller ══ --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="17" height="17" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Log</p>
                <p class="stat-val">{{ number_format($statsLP['total']) }}</p>
                <p class="stat-note">semua data piket</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="17" height="17" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Bulan Ini</p>
                <p class="stat-val">{{ number_format($statsLP['bulan_ini']) }}</p>
                <p class="stat-note">{{ now()->translatedFormat('F Y') }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="17" height="17" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Sedang Bertugas</p>
                <p class="stat-val">{{ number_format($statsLP['bertugas']) }}</p>
                <p class="stat-note">masuk belum keluar hari ini</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="17" height="17" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <p class="stat-label">Selesai Hari Ini</p>
                <p class="stat-val">{{ number_format($statsLP['selesai_hari_ini']) }}</p>
                <p class="stat-note">sudah keluar</p>
            </div>
        </div>
    </div>

    {{-- ══ CHARTS ══
         trendChart  → $trendLabels, $trendLogPiket (14 hari, GROUP BY di controller)
         shiftChart  → $distribusiShift (dari SELECT shift, COUNT(*) GROUP BY shift)
    --}}
    <div class="charts-row">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Tren Log Piket 14 Hari Terakhir</span>
                <span class="card-sub">Jumlah sesi piket per hari</span>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="trendChart"></canvas></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <span class="card-title">Distribusi Shift</span>
                <span class="card-sub">Seluruh data piket (global)</span>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="shiftChart"></canvas></div>
            </div>
        </div>
    </div>

    {{-- ══ FILTER ══
         Sesuai applyLogPiketFilters():
         tanggal_dari, tanggal_sampai, guru_id, shift, status, search
    --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.laporan.log-piket') }}">
            <div class="filter-grid">
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
                    <label>Shift</label>
                    <select name="shift">
                        <option value="">Semua Shift</option>
                        <option value="pagi"  {{ request('shift') === 'pagi'  ? 'selected' : '' }}>Pagi</option>
                        <option value="siang" {{ request('shift') === 'siang' ? 'selected' : '' }}>Siang</option>
                        <option value="sore"  {{ request('shift') === 'sore'  ? 'selected' : '' }}>Sore</option>
                        <option value="malam" {{ request('shift') === 'malam' ? 'selected' : '' }}>Malam</option>
                    </select>
                </div>
                <div class="field">
                    <label>Status</label>
                    <select name="status">
                        <option value="">Semua Status</option>
                        <option value="bertugas" {{ request('status') === 'bertugas' ? 'selected' : '' }}>Sedang Bertugas</option>
                        <option value="selesai"  {{ request('status') === 'selesai'  ? 'selected' : '' }}>Selesai</option>
                        <option value="belum"    {{ request('status') === 'belum'    ? 'selected' : '' }}>Belum Masuk</option>
                    </select>
                </div>
                <div class="field">
                    <label>Cari Nama Guru</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama guru...">
                </div>
                <a href="{{ route('admin.laporan.log-piket') }}" class="btn-reset">Reset</a>
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
            </div>
        </form>
    </div>

    {{-- ══ TABEL ══ --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Data Log Piket
                @if($logs->total() > 0)
                    <span>— {{ $logs->firstItem() }}–{{ $logs->lastItem() }} dari {{ number_format($logs->total()) }} record</span>
                @else
                    <span>— Tidak ada data</span>
                @endif
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.laporan.log-piket.export.pdf', request()->query()) }}"
                   class="btn btn-sm btn-pdf" target="_blank">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.laporan.log-piket.export.excel', request()->query()) }}"
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
                        <th>Guru</th>
                        <th>Tanggal</th>
                        <th>Shift</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th>Dicatat Oleh</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $i => $log)
                    @php
                        // Tentukan status dari masuk_pada & keluar_pada (sesuai controller)
                        if (!$log->masuk_pada) {
                            $statusPiket = 'belum';
                            $statusLabel = 'Belum Masuk';
                        } elseif ($log->masuk_pada && !$log->keluar_pada) {
                            $statusPiket = 'bertugas';
                            $statusLabel = 'Bertugas';
                        } else {
                            $statusPiket = 'selesai';
                            $statusLabel = 'Selesai';
                        }

                        // Hitung durasi jika keluar sudah ada
                        $durasi = null;
                        if ($log->masuk_pada && $log->keluar_pada) {
                            $diff = \Carbon\Carbon::parse($log->masuk_pada)->diff(\Carbon\Carbon::parse($log->keluar_pada));
                            $durasi = $diff->h > 0
                                ? $diff->h . 'j ' . $diff->i . 'm'
                                : $diff->i . ' menit';
                        }

                        // Mapping shift ke class CSS
                        $shiftClass = match(strtolower($log->shift ?? '')) {
                            'pagi'  => 'shift-pagi',
                            'siang' => 'shift-siang',
                            'sore'  => 'shift-sore',
                            'malam' => 'shift-malam',
                            default => 'shift-default',
                        };
                    @endphp
                    <tr>
                        <td><span class="no-col">{{ $logs->firstItem() + $i }}</span></td>

                        {{-- Guru via relasi $log->guru --}}
                        <td>
                            <p style="font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;line-height:1.3;">
                                {{ $log->guru->nama_lengkap ?? '—' }}
                            </p>
                            @if($log->guru->nip ?? false)
                                <p style="font-size:11.5px;color:var(--text3);font-family:'DM Sans',sans-serif;">
                                    NIP: {{ $log->guru->nip }}
                                </p>
                            @endif
                        </td>

                        {{-- Tanggal — cast date di model --}}
                        <td style="font-size:13px;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;white-space:nowrap;">
                            {{ optional($log->tanggal)->format('d M Y') ?? '—' }}
                        </td>

                        {{-- Shift --}}
                        <td>
                            @if($log->shift)
                                <span class="shift-pill {{ $shiftClass }}">{{ ucfirst($log->shift) }}</span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>

                        {{-- Jam masuk — cast datetime di model --}}
                        <td class="muted" style="font-family:'DM Sans',sans-serif;">
                            {{ optional($log->masuk_pada)->format('H:i') ?? '—' }}
                        </td>

                        {{-- Jam keluar --}}
                        <td class="muted" style="font-family:'DM Sans',sans-serif;">
                            {{ optional($log->keluar_pada)->format('H:i') ?? '—' }}
                        </td>

                        {{-- Durasi --}}
                        <td>
                            @if($durasi)
                                <span class="dur-badge">{{ $durasi }}</span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>

                        {{-- Status badge berdasarkan masuk_pada & keluar_pada --}}
                        <td>
                            <span class="badge badge-{{ $statusPiket }}">
                                <span class="badge-dot"></span>{{ $statusLabel }}
                            </span>
                        </td>

                        {{-- Dicatat oleh (relasi pengguna via pengguna_id) --}}
                        <td class="muted" style="font-size:12px;">
                            {{ $log->pengguna->name ?? $log->pengguna->nama_lengkap ?? '—' }}
                        </td>

                        {{-- Catatan / keterangan --}}
                        <td class="muted" style="max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            {{ $log->catatan ?? $log->keterangan ?? '—' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                </div>
                                <p class="empty-title">Tidak ada data log piket</p>
                                <p class="empty-sub">Coba ubah filter atau reset pencarian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($logs->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">
                Menampilkan {{ $logs->firstItem() }} – {{ $logs->lastItem() }}
                dari {{ number_format($logs->total()) }} data
            </p>
            <div class="pag-btns">
                @if($logs->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $logs->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                @foreach($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                    @if($page == $logs->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $logs->lastPage() || abs($page - $logs->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $logs->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                @if($logs->hasMorePages())
                    <a href="{{ $logs->nextPageUrl() }}" class="pag-btn">
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
        Tren 14 hari — $trendLabels, $trendLogPiket
        Dikirim controller via satu GROUP BY query pada LogPiket.
    --}}
    new Chart(document.getElementById('trendChart'), {
        type: 'bar',
        data: {
            labels: @json($trendLabels ?? []),
            datasets: [{
                label: 'Sesi Piket',
                data: @json($trendLogPiket ?? []),
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
                        label: ctx => ` ${ctx.raw} sesi piket`
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
        Distribusi shift — $distribusiShift
        Array dari controller: SELECT shift, COUNT(*) GROUP BY shift → pluck('jumlah','shift')
        Key adalah nama shift (pagi, siang, sore, malam), value adalah jumlah.
    --}}
    @php
        $shiftLabels = array_map(fn($k) => ucfirst($k), array_keys($distribusiShift ?? []));
        $shiftData   = array_values($distribusiShift ?? []);
    @endphp
    new Chart(document.getElementById('shiftChart'), {
        type: 'doughnut',
        data: {
            labels: @json($shiftLabels),
            datasets: [{
                data: @json($shiftData),
                backgroundColor: ['#3b82f6','#f59e0b','#a855f7','#1e293b'],
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
                        label: ctx => ` ${ctx.label}: ${ctx.raw} sesi`
                    }
                }
            }
        }
    });
</script>
</x-app-layout>