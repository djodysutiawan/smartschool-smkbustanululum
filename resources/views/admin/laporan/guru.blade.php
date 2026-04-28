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
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;display:flex;align-items:center;gap:10px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}
    .stat-icon.green{background:#f0fdf4;}
    .stat-icon.sky{background:#f0f9ff;}
    .stat-icon.pink{background:#fdf2f8;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .charts-row{display:grid;grid-template-columns:1fr 300px;gap:16px;margin-bottom:16px;}
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .card-header{padding:13px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between;}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .card-body{padding:16px 20px;}
    .chart-wrap{position:relative;height:220px;}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;}
    .filter-grid{display:grid;grid-template-columns:2fr 1fr 1fr auto auto;gap:10px;align-items:end;}
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
    .avatar{width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;flex-shrink:0;background:var(--brand-50);color:var(--brand-600);}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-aktif{background:#dcfce7;color:#15803d;}.badge-aktif .badge-dot{background:#15803d;}
    .badge-nonaktif{background:#f1f5f9;color:#64748b;}.badge-nonaktif .badge-dot{background:#64748b;}
    .badge-cuti{background:#fef9c3;color:#a16207;}.badge-cuti .badge-dot{background:#a16207;}
    .badge-pensiun{background:#fee2e2;color:#dc2626;}.badge-pensiun .badge-dot{background:#dc2626;}
    .jk-pill{display:inline-block;padding:2px 9px;border-radius:5px;font-size:11.5px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;}
    .jk-l{background:#f0f9ff;color:#0284c7;border:1px solid #bae6fd;}
    .jk-p{background:#fdf2f8;color:#db2777;border:1px solid #fbcfe8;}
    .akun-pill{display:inline-flex;align-items:center;gap:5px;font-size:12px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;}
    .akun-dot{width:6px;height:6px;border-radius:50%;flex-shrink:0;}
    .akun-dot.on{background:#22c55e;}
    .akun-dot.off{background:#cbd5e1;}
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
    @media(max-width:900px){.stats-strip{grid-template-columns:1fr 1fr;}.charts-row{grid-template-columns:1fr;}.filter-grid{grid-template-columns:1fr 1fr;}.page{padding:16px;}}
</style>

<div class="page">

    {{-- ══ HEADER ══ --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Guru</h1>
            <p class="page-sub">Data seluruh guru — filter, rekap, dan ekspor laporan</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- ══ STAT CARDS ══ --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="17" height="17" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Guru</p>
                <p class="stat-val">{{ number_format($statsG['total']) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="17" height="17" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Guru Aktif</p>
                <p class="stat-val">{{ number_format($statsG['aktif']) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon sky">
                <svg width="17" height="17" fill="none" stroke="#0284c7" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div>
                <p class="stat-label">Laki-laki</p>
                <p class="stat-val">{{ number_format($statsG['laki']) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pink">
                <svg width="17" height="17" fill="none" stroke="#db2777" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div>
                <p class="stat-label">Perempuan</p>
                <p class="stat-val">{{ number_format($statsG['perempuan']) }}</p>
            </div>
        </div>
    </div>

    {{-- ══ CHARTS ══ --}}
    <div class="charts-row">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Distribusi Status Guru</span>
                <span style="font-size:11.5px;color:var(--text3);">Aktif vs Non-Aktif</span>
            </div>
            <div class="card-body"><div class="chart-wrap"><canvas id="statusChart"></canvas></div></div>
        </div>
        <div class="card">
            <div class="card-header">
                <span class="card-title">Jenis Kelamin</span>
                <span style="font-size:11.5px;color:var(--text3);">Komposisi</span>
            </div>
            <div class="card-body"><div class="chart-wrap"><canvas id="jkChart"></canvas></div></div>
        </div>
    </div>

    {{-- ══ FILTER ══ --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.laporan.guru') }}">
            <div class="filter-grid">
                <div class="field">
                    <label>Cari Nama / NIP</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama lengkap atau NIP...">
                </div>
                <div class="field">
                    <label>Status</label>
                    <select name="status">
                        <option value="">Semua Status</option>
                        <option value="aktif"    {{ request('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                        <option value="cuti"     {{ request('status') === 'cuti'     ? 'selected' : '' }}>Cuti</option>
                        <option value="pensiun"  {{ request('status') === 'pensiun'  ? 'selected' : '' }}>Pensiun</option>
                    </select>
                </div>
                <div class="field">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin">
                        <option value="">Semua</option>
                        <option value="L" {{ request('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ request('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <a href="{{ route('admin.laporan.guru') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Filter</button>
            </div>
        </form>
    </div>

    {{-- ══ TABEL ══ --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Data Guru
                <span>— {{ $guru->firstItem() ?? 0 }}–{{ $guru->lastItem() ?? 0 }} dari {{ $guru->total() }} record</span>
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.laporan.guru.export.pdf', request()->query()) }}" class="btn btn-sm btn-pdf" target="_blank">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.laporan.guru.export.excel', request()->query()) }}" class="btn btn-sm btn-excel">
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
                        <th>Nama Guru</th>
                        <th>NIP</th>
                        <th>Jenis Kelamin</th>
                        <th>Jabatan</th>
                        <th>Akun</th>
                        <th>Status</th>
                        <th class="center" style="width:80px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guru as $i => $g)
                    <tr>
                        <td><span class="no-col">{{ $guru->firstItem() + $i }}</span></td>

                        {{-- Nama --}}
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div class="avatar">{{ strtoupper(substr($g->nama_lengkap, 0, 1)) }}</div>
                                <div>
                                    <p style="font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;line-height:1.3;">{{ $g->nama_lengkap }}</p>
                                    @if($g->nip ?? false)
                                        <p style="font-size:11.5px;color:var(--text3);font-family:'DM Sans',sans-serif;">{{ $g->nip }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- NIP --}}
                        <td class="muted" style="font-family:'DM Sans',sans-serif;">{{ $g->nip ?? '—' }}</td>

                        {{-- Jenis Kelamin --}}
                        <td>
                            @if($g->jenis_kelamin === 'L')
                                <span class="jk-pill jk-l">♂ Laki-laki</span>
                            @elseif($g->jenis_kelamin === 'P')
                                <span class="jk-pill jk-p">♀ Perempuan</span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>

                        {{-- Jabatan --}}
                        <td class="muted">{{ $g->jabatan ?? '—' }}</td>

                        {{-- Akun --}}
                        <td>
                            @if($g->pengguna)
                                <div class="akun-pill">
                                    <span class="akun-dot on"></span>
                                    <span style="color:#15803d;">Terdaftar</span>
                                </div>
                                <p style="font-size:11.5px;color:var(--text3);margin-top:2px;">{{ $g->pengguna->email }}</p>
                            @else
                                <div class="akun-pill">
                                    <span class="akun-dot off"></span>
                                    <span style="color:var(--text3);">Belum ada akun</span>
                                </div>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td>
                            @php
                                $st = $g->status ?? 'aktif';
                                $stLabel = match($st) {
                                    'aktif'    => 'Aktif',
                                    'nonaktif' => 'Non-Aktif',
                                    'cuti'     => 'Cuti',
                                    'pensiun'  => 'Pensiun',
                                    default    => ucfirst($st),
                                };
                            @endphp
                            <span class="badge badge-{{ $st }}">
                                <span class="badge-dot"></span>{{ $stLabel }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="center">
                            <a href="{{ route('admin.guru.show', $g->id) }}"
                               class="btn btn-sm"
                               style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;text-decoration:none;">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                </div>
                                <p class="empty-title">Tidak ada data guru</p>
                                <p class="empty-sub">Coba ubah filter atau reset pencarian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($guru->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $guru->firstItem() }} – {{ $guru->lastItem() }} dari {{ $guru->total() }} data</p>
            <div class="pag-btns">
                @if($guru->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $guru->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                @foreach($guru->getUrlRange(1, $guru->lastPage()) as $page => $url)
                    @if($page == $guru->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $guru->lastPage() || abs($page - $guru->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $guru->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                @if($guru->hasMorePages())
                    <a href="{{ $guru->nextPageUrl() }}" class="pag-btn">
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

    // Chart status guru
    new Chart(document.getElementById('statusChart'), {
        type: 'bar',
        data: {
            labels: ['Aktif', 'Non-Aktif', 'Cuti', 'Pensiun'],
            datasets: [{
                data: [
                    {{ $statsG['aktif'] }},
                    {{ $statsG['total'] - $statsG['aktif'] }},
                    0, 0
                ],
                backgroundColor: ['#22c55e', '#94a3b8', '#f59e0b', '#ef4444'],
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ` ${ctx.raw} guru` } }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

    // Chart jenis kelamin
    new Chart(document.getElementById('jkChart'), {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [{{ $statsG['laki'] }}, {{ $statsG['perempuan'] }}],
                backgroundColor: ['#0ea5e9', '#ec4899'],
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: { boxWidth: 10, padding: 10, font: { family: "'Plus Jakarta Sans'", weight: '700', size: 11 } }
                }
            }
        }
    });
</script>
</x-app-layout>