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
    }

    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-warn{background:#fffbeb;color:#a16207;border:1px solid #fde68a}
    .btn-warn:hover{background:#fef9c3;filter:none}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-detail:hover{background:#dcfce7;filter:none}

    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.green{background:#f0fdf4}
    .stat-icon.orange{background:#fff7ed}
    .stat-icon.blue{background:#eff6ff}
    .stat-icon.gray{background:var(--surface2)}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row input[type=date],.filter-row input[type=text]{height:36px;padding:0 10px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none}
    .filter-row input[type=date]{width:148px}
    .filter-row input[type=text]{min-width:180px}
    .filter-row select:focus,.filter-row input:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s}
    .btn-filter:hover{background:var(--brand-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:background .15s}
    .btn-reset:hover{background:var(--surface3)}

    .alert-banner{display:flex;align-items:center;gap:12px;padding:12px 18px;border-radius:var(--radius);border:1px solid #fde68a;background:#fffbeb;margin-bottom:16px}
    .alert-banner p{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:#92400e}
    .alert-banner span{font-size:12px;font-weight:400;color:#a16207;margin-top:1px;display:block}

    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:8px}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    td.muted{color:var(--text3)}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}
    .two-line .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .two-line .secondary{font-size:12px;color:var(--text3);margin-top:1px}
    .action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-orange{background:#fff7ed;color:#c2410c} .badge-orange .badge-dot{background:#c2410c}

    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px;align-items:center}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2);border-color:var(--border2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}

    .progress-bar-wrap{background:var(--surface3);border-radius:99px;height:6px;width:80px;overflow:hidden;display:inline-block;vertical-align:middle}
    .progress-bar{height:100%;border-radius:99px;background:var(--brand-500);transition:width .3s}

    @media(max-width:900px){.stats-strip{grid-template-columns:1fr 1fr}}
    @media(max-width:640px){.page{padding:16px};.header-actions{width:100%}}
</style>

<div class="page">

    {{-- ── Header ──────────────────────────────────────────────────────── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Siswa Belum Hadir</h1>
            <p class="page-sub">Daftar siswa yang belum scan masuk — {{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM Y') }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.absensi-gerbang.belum-hadir.export.pdf', request()->query()) }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export PDF
            </a>
            <a href="{{ route('admin.absensi-gerbang.input-manual') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Input Manual
            </a>
            <a href="{{ route('admin.absensi-gerbang.index') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali ke Log
            </a>
        </div>
    </div>

    {{-- ── Statistik ────────────────────────────────────────────────────── --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon gray">
                <svg width="18" height="18" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Siswa</p>
                <p class="stat-val">{{ $statistik['total_siswa'] }}</p>
                <p class="stat-sub">siswa aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Sudah Hadir</p>
                <p class="stat-val">{{ $statistik['sudah_hadir'] }}</p>
                <p class="stat-sub">sudah scan masuk</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/><line x1="17" y1="11" x2="22" y2="11"/></svg>
            </div>
            <div>
                <p class="stat-label">Belum Hadir</p>
                <p class="stat-val">{{ $statistik['belum_hadir'] }}</p>
                <p class="stat-sub">belum scan masuk</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            </div>
            <div>
                <p class="stat-label">Kehadiran</p>
                <p class="stat-val">{{ $statistik['persentase'] }}%</p>
                <p class="stat-sub">tingkat hadir hari ini</p>
            </div>
        </div>
    </div>

    {{-- ── Alert jika banyak belum hadir ──────────────────────────────── --}}
    @if($statistik['belum_hadir'] > 0)
    <div class="alert-banner">
        <svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        <div>
            <p>{{ $statistik['belum_hadir'] }} siswa belum tercatat hadir hari ini</p>
            <span>Gunakan fitur Input Manual jika siswa hadir namun lupa/tidak bisa scan</span>
        </div>
    </div>
    @endif

    {{-- ── Filter ───────────────────────────────────────────────────────── --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.absensi-gerbang.belum-hadir') }}">
            <div class="filter-row">
                <input type="date" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()">
                <select name="kelas_id" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" @selected(request('kelas_id') == $k->id)>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama / NIS…">
                <div class="filter-sep"></div>
                @if(request()->hasAny(['kelas_id','cari']) || request('tanggal') !== now()->toDateString())
                    <a href="{{ route('admin.absensi-gerbang.belum-hadir') }}" class="btn-reset">Reset</a>
                @endif
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- ── Tabel ────────────────────────────────────────────────────────── --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Belum Hadir
                @if($belumHadirList->total() > 0)
                    <span>— menampilkan {{ $belumHadirList->firstItem() }}–{{ $belumHadirList->lastItem() }} dari {{ $belumHadirList->total() }} siswa</span>
                @else
                    <span>— semua siswa sudah hadir 🎉</span>
                @endif
            </p>
            @if($belumHadirList->total() > 0)
            <a href="{{ route('admin.absensi-gerbang.belum-hadir.export.pdf', request()->query()) }}"
               class="btn btn-sm btn-secondary" style="gap:5px">
                <svg width="12" height="12" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export PDF
            </a>
            @endif
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th class="center">Status</th>
                        <th class="center" style="width:140px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($belumHadirList as $index => $siswa)
                    <tr>
                        <td><span class="no-col">{{ $belumHadirList->firstItem() + $index }}</span></td>
                        <td>
                            <div class="two-line">
                                <p class="primary">{{ $siswa->nama_lengkap }}</p>
                                <p class="secondary">{{ $siswa->kelas?->nama_kelas ?? '—' }}</p>
                            </div>
                        </td>
                        <td style="font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2)">{{ $siswa->nis }}</td>
                        <td class="muted" style="font-size:12.5px">{{ $siswa->kelas?->nama_kelas ?? '—' }}</td>
                        <td class="center">
                            <span class="badge badge-orange">
                                <span class="badge-dot"></span>
                                Belum Hadir
                            </span>
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.absensi-gerbang.input-manual') }}?siswa_id={{ $siswa->id }}"
                                   class="btn btn-sm btn-warn">
                                    Input Manual
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                </div>
                                <p class="empty-title">Semua siswa sudah hadir!</p>
                                <p class="empty-sub">Tidak ada siswa yang belum tercatat scan masuk pada tanggal ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($belumHadirList->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $belumHadirList->firstItem() }}–{{ $belumHadirList->lastItem() }} dari {{ $belumHadirList->total() }} siswa</p>
            <div class="pag-btns">
                @if($belumHadirList->onFirstPage())
                    <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $belumHadirList->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif

                @php
                    $current  = $belumHadirList->currentPage();
                    $last     = $belumHadirList->lastPage();
                    $showLeft = false;
                    $showRight = false;
                @endphp

                @foreach($belumHadirList->getUrlRange(1, $last) as $page => $url)
                    @php
                        $nearCurrent = abs($page - $current) <= 1;
                        $isEdge      = $page === 1 || $page === $last;
                        $show        = $isEdge || $nearCurrent;
                    @endphp
                    @if($show)
                        @if($page === $current)
                            <span class="pag-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                        @endif
                        @php $showLeft = false; $showRight = false; @endphp
                    @else
                        @if($page < $current && !$showLeft)
                            <span class="pag-ellipsis">…</span>
                            @php $showLeft = true; @endphp
                        @elseif($page > $current && !$showRight)
                            <span class="pag-ellipsis">…</span>
                            @php $showRight = true; @endphp
                        @endif
                    @endif
                @endforeach

                @if($belumHadirList->hasMorePages())
                    <a href="{{ $belumHadirList->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif
</script>
</x-app-layout>