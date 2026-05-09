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

    /* ── Header ── */
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

    /* ── Stat Cards ── */
    .stats-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;display:flex;align-items:center;gap:10px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}
    .stat-icon.indigo{background:#eef2ff;}
    .stat-icon.green{background:#f0fdf4;}
    .stat-icon.yellow{background:#fefce8;}
    .stat-icon.red{background:#fff0f0;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .stat-note{font-size:11px;color:var(--text3);margin-top:2px;font-family:'DM Sans',sans-serif;}

    /* ── Charts ── */
    .charts-row{display:grid;grid-template-columns:1fr 300px;gap:16px;margin-bottom:16px;}
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .card-header{padding:13px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between;}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .card-sub{font-size:11.5px;color:var(--text3);}
    .card-body{padding:16px 20px;}
    .chart-wrap{position:relative;height:220px;}

    /* ── Filter ── */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;}
    .filter-grid{display:grid;grid-template-columns:repeat(3,1fr) auto auto;gap:10px;align-items:end;}
    .filter-row2{display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:10px;margin-top:10px;}
    .filter-row3{margin-top:10px;}
    .field{display:flex;flex-direction:column;gap:5px;}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);}
    .field input,.field select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;}
    .field input:focus,.field select:focus{border-color:var(--brand-500);background:#fff;}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap;}
    .btn-filter:hover{background:var(--brand-700);}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;white-space:nowrap;}
    .btn-reset:hover{background:var(--surface3);}

    /* ── Table ── */
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

    /* ── Badges status jurnal ── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-disetujui{background:#dcfce7;color:#15803d;}.badge-disetujui .badge-dot{background:#15803d;}
    .badge-menunggu{background:#fef9c3;color:#a16207;}.badge-menunggu .badge-dot{background:#a16207;}
    .badge-ditolak{background:#fee2e2;color:#dc2626;}.badge-ditolak .badge-dot{background:#dc2626;}
    .badge-draft{background:#f1f5f9;color:#64748b;}.badge-draft .badge-dot{background:#64748b;}

    /* ── Mapel pill ── */
    .mapel-pill{display:inline-block;padding:2px 9px;border-radius:5px;font-size:11.5px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;background:var(--brand-50);color:var(--brand-600);border:1px solid var(--brand-100);max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}

    /* ── Pertemuan badge ── */
    .pertemuan-num{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:7px;background:var(--surface2);border:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;color:var(--text2);}

    /* ── Empty state ── */
    .empty-state{padding:50px 20px;text-align:center;}
    .empty-icon{width:52px;height:52px;background:var(--surface2);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--text);margin-bottom:4px;}
    .empty-sub{font-size:13px;color:var(--text3);}

    /* ── Pagination ── */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:13px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .pag-info{font-size:12.5px;color:var(--text3);}
    .pag-btns{display:flex;gap:4px;}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none;}
    .pag-btn:hover{background:var(--surface2);}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff;}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;display:flex;align-items:center;}

    @media(max-width:1024px){.stats-strip{grid-template-columns:repeat(3,1fr);}}
    @media(max-width:900px){
        .stats-strip{grid-template-columns:1fr 1fr;}
        .charts-row{grid-template-columns:1fr;}
        .filter-grid{grid-template-columns:1fr 1fr;}
        .filter-row2{grid-template-columns:1fr 1fr;}
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
            <h1 class="page-title">Laporan Jurnal Mengajar</h1>
            <p class="page-sub">Rekap aktivitas mengajar guru — filter per guru, kelas, mata pelajaran, dan status</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{--
        ══ STAT CARDS ══
        $statsJ dari controller: ['total', 'bulan_ini', 'disetujui', 'menunggu', 'ditolak']
        Semua sudah dihitung via GROUP BY di controller — tidak ada query di view.
    --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="17" height="17" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Jurnal</p>
                <p class="stat-val">{{ number_format($statsJ['total']) }}</p>
                <p class="stat-note">seluruh data</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon indigo">
                <svg width="17" height="17" fill="none" stroke="#4f46e5" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Bulan Ini</p>
                <p class="stat-val">{{ number_format($statsJ['bulan_ini']) }}</p>
                <p class="stat-note">{{ now()->translatedFormat('F Y') }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="17" height="17" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Disetujui</p>
                <p class="stat-val">{{ number_format($statsJ['disetujui']) }}</p>
                <p class="stat-note">sudah diverifikasi</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="17" height="17" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Menunggu</p>
                <p class="stat-val">{{ number_format($statsJ['menunggu']) }}</p>
                <p class="stat-note">perlu review</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="17" height="17" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div>
                <p class="stat-label">Ditolak</p>
                <p class="stat-val">{{ number_format($statsJ['ditolak']) }}</p>
                <p class="stat-note">perlu revisi</p>
            </div>
        </div>
    </div>

    {{--
        ══ CHARTS ══
        trendChart  → $trendLabels, $trendJurnal  (14 hari via GROUP BY DATE(tanggal))
        statusChart → $statsJ (distribusi status global dari seluruh DB)

        CATATAN: $trendJurnal adalah total per hari (1 dataset), bukan breakdown per status.
        Kalau controller dikembangkan kirim per-status, tinggal tambah dataset di sini.
    --}}
    <div class="charts-row">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Tren Jurnal 14 Hari Terakhir</span>
                <span class="card-sub">Jumlah jurnal dicatat per hari</span>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="trendChart"></canvas></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <span class="card-title">Distribusi Status</span>
                <span class="card-sub">Seluruh data (global)</span>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="statusChart"></canvas></div>
            </div>
        </div>
    </div>

    {{--
        ══ FILTER ══
        Sesuai applyJurnalFilters() di controller:
        tanggal_dari, tanggal_sampai, guru_id, kelas_id,
        mata_pelajaran_id, tahun_ajaran_id, status, search
    --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.laporan.jurnal-mengajar') }}">
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
                        @foreach(['disetujui' => 'Disetujui', 'menunggu' => 'Menunggu', 'ditolak' => 'Ditolak', 'draft' => 'Draft'] as $val => $label)
                            <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <a href="{{ route('admin.laporan.jurnal-mengajar') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Filter</button>
            </div>

            <div class="filter-row2">
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
                    {{--
                        Tahun Ajaran — dari $tahunAjaran (collection TahunAjaran).
                        Akses kolom langsung: $t->tahun dan $t->semester (bukan relasi).
                        Label: pakai accessor $t->label jika ada, fallback ke tahun.
                    --}}
                    <label>Tahun Ajaran</label>
                    <select name="tahun_ajaran_id">
                        <option value="">Semua Tahun Ajaran</option>
                        @foreach($tahunAjaran as $t)
                            <option value="{{ $t->id }}" {{ request('tahun_ajaran_id') == $t->id ? 'selected' : '' }}>
                                {{-- Prioritas: accessor label, fallback tahun + semester --}}
                                @if(isset($t->label))
                                    {{ $t->label }}
                                @else
                                    {{ $t->tahun }}{{ $t->semester ? ' — ' . ucfirst($t->semester) : '' }}
                                @endif
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

            <div class="filter-row3">
                <div class="field" style="max-width:420px;">
                    <label>Cari Materi / Nama Guru</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Ketik materi pokok atau nama guru...">
                </div>
            </div>
        </form>
    </div>

    {{-- ══ TABEL ══ --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Data Jurnal Mengajar
                @if($jurnal->total() > 0)
                    <span>— {{ $jurnal->firstItem() }}–{{ $jurnal->lastItem() }} dari {{ number_format($jurnal->total()) }} record</span>
                @else
                    <span>— Tidak ada data</span>
                @endif
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.laporan.jurnal-mengajar.export.pdf', request()->query()) }}"
                   class="btn btn-sm btn-pdf" target="_blank">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.laporan.jurnal-mengajar.export.excel', request()->query()) }}"
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
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Materi Pokok</th>
                        <th class="center">Pertemuan</th>
                        <th>Status</th>
                        <th class="center" style="width:80px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnal as $i => $j)
                    <tr>
                        <td><span class="no-col">{{ $jurnal->firstItem() + $i }}</span></td>

                        {{-- Guru: relasi guru() BelongsTo via guru_id --}}
                        <td>
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;line-height:1.3;">
                                {{ optional($j->guru)->nama_lengkap ?? '—' }}
                            </p>
                            @if(optional($j->guru)->nip)
                                <p style="font-size:11.5px;color:var(--text3);font-family:'DM Sans',sans-serif;">
                                    NIP: {{ $j->guru->nip }}
                                </p>
                            @endif
                        </td>

                        {{-- Mata Pelajaran: relasi mataPelajaran() BelongsTo --}}
                        <td>
                            <span class="mapel-pill" title="{{ optional($j->mataPelajaran)->nama_mapel ?? '' }}">
                                {{ optional($j->mataPelajaran)->nama_mapel ?? '—' }}
                            </span>
                        </td>

                        {{-- Kelas: relasi kelas() BelongsTo --}}
                        <td style="font-size:13px;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;">
                            {{ optional($j->kelas)->nama_kelas ?? '—' }}
                        </td>

                        {{--
                            Tanggal: kolom 'tanggal' di tabel jurnal_mengajar.
                            Pakai Carbon::parse() karena cast di model mungkin tidak ada.
                            TIDAK mengakses relasi apapun di sini.
                        --}}
                        <td class="muted" style="white-space:nowrap;">
                            {{ $j->tanggal ? \Carbon\Carbon::parse($j->tanggal)->format('d M Y') : '—' }}
                        </td>

                        {{-- Materi Pokok: kolom langsung --}}
                        <td style="max-width:200px;font-size:13px;color:var(--text2);">
                            {{ Str::limit($j->materi_pokok ?? '—', 55) }}
                        </td>

                        {{-- Pertemuan ke-: kolom langsung, nullable --}}
                        <td class="center">
                            @if($j->pertemuan_ke ?? false)
                                <span class="pertemuan-num">{{ $j->pertemuan_ke }}</span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>

                        {{--
                            Status: kolom 'status' di tabel jurnal_mengajar.
                            Nilai valid: disetujui, menunggu, ditolak, draft.
                            Guard agar tidak error jika nilai di luar daftar.
                            TIDAK ada relasi tahunAjaran di sini — kolom dihapus dari tabel
                            karena relasi tahunAjaran() belum tentu ada di model JurnalMengajar.
                        --}}
                        <td>
                            @php
                                $validStatus = ['disetujui','menunggu','ditolak','draft'];
                                $stClass = in_array($j->status ?? '', $validStatus) ? $j->status : 'draft';
                                $stLabel = [
                                    'disetujui' => 'Disetujui',
                                    'menunggu'  => 'Menunggu',
                                    'ditolak'   => 'Ditolak',
                                    'draft'     => 'Draft',
                                ];
                            @endphp
                            <span class="badge badge-{{ $stClass }}">
                                <span class="badge-dot"></span>{{ $stLabel[$stClass] ?? ucfirst($j->status ?? 'draft') }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="center">
                            <a href="{{ route('admin.jurnal-mengajar.show', $j->id) }}"
                               class="btn btn-sm"
                               style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;text-decoration:none;">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                </div>
                                <p class="empty-title">Tidak ada data jurnal mengajar</p>
                                <p class="empty-sub">Coba ubah filter atau reset pencarian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Pagination ── --}}
        @if($jurnal->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">
                Menampilkan {{ $jurnal->firstItem() }} – {{ $jurnal->lastItem() }}
                dari {{ number_format($jurnal->total()) }} data
            </p>
            <div class="pag-btns">
                {{-- Prev --}}
                @if($jurnal->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $jurnal->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                {{-- Pages dengan ellipsis --}}
                @php
                    $cur   = $jurnal->currentPage();
                    $last  = $jurnal->lastPage();
                    $ellL  = false;
                    $ellR  = false;
                @endphp
                @foreach($jurnal->getUrlRange(1, $last) as $page => $url)
                    @php
                        $isEdge = ($page === 1 || $page === $last);
                        $isNear = abs($page - $cur) <= 1;
                    @endphp
                    @if($page === $cur)
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($isEdge || $isNear)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(!$ellL && $page < $cur)
                        @php $ellL = true @endphp
                        <span class="pag-ellipsis">…</span>
                    @elseif(!$ellR && $page > $cur)
                        @php $ellR = true @endphp
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($jurnal->hasMorePages())
                    <a href="{{ $jurnal->nextPageUrl() }}" class="pag-btn">
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

    Chart.defaults.font.family = "'DM Sans', sans-serif";
    Chart.defaults.color = '#94a3b8';

    {{--
        Chart 1: Bar vertikal — tren 14 hari.
        Data: $trendLabels (array d/m) dan $trendJurnal (total per hari).
        Kedua array diisi controller via GROUP BY DATE(tanggal), pasti 14 elemen.
        Warna indigo — beda dari halaman absensi (hijau/merah) dan pelanggaran.
    --}}
    new Chart(document.getElementById('trendChart'), {
        type: 'bar',
        data: {
            labels: @json($trendLabels ?? []),
            datasets: [{
                label: 'Jurnal Dicatat',
                data: @json($trendJurnal ?? []),
                backgroundColor: 'rgba(99,102,241,.75)',
                borderColor: '#6366f1',
                borderWidth: 1.5,
                borderRadius: 5,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ` ${ctx.raw} jurnal` } }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

    {{--
        Chart 2: Doughnut — distribusi status global.
        Sumber: $statsJ (semua key dijamin ada di controller).
        draft = total - disetujui - menunggu - ditolak (sisanya, jika ada).
        max(0,...) mencegah angka negatif jika data tidak konsisten.
    --}}
    @php
        $draftCount = max(0,
            ($statsJ['total']     ?? 0)
            - ($statsJ['disetujui'] ?? 0)
            - ($statsJ['menunggu']  ?? 0)
            - ($statsJ['ditolak']   ?? 0)
        );
    @endphp
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Disetujui', 'Menunggu', 'Ditolak', 'Draft'],
            datasets: [{
                data: [
                    {{ $statsJ['disetujui'] ?? 0 }},
                    {{ $statsJ['menunggu']  ?? 0 }},
                    {{ $statsJ['ditolak']   ?? 0 }},
                    {{ $draftCount }},
                ],
                backgroundColor: ['#22c55e', '#eab308', '#ef4444', '#cbd5e1'],
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
                        font: { family: "'Plus Jakarta Sans'", weight: '700', size: 11 }
                    }
                },
                tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.raw}` } }
            }
        }
    });
</script>
</x-app-layout>