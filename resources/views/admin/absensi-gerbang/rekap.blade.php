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
    .breadcrumb{display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--text3);margin-bottom:6px;flex-wrap:wrap}
    .breadcrumb a{color:var(--text3);text-decoration:none;transition:color .15s}
    .breadcrumb a:hover{color:var(--text2)}
    .breadcrumb-sep{color:var(--border2)}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}

    .dropdown{position:relative;display:inline-flex}
    .dropdown-menu{display:none;position:absolute;top:calc(100% + 6px);right:0;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);box-shadow:0 8px 28px rgba(0,0,0,.1);min-width:200px;z-index:200;overflow:hidden}
    .dropdown.open .dropdown-menu{display:block}
    .dropdown-item{display:flex;align-items:center;gap:8px;padding:9px 14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text2);text-decoration:none;background:none;border:none;width:100%;cursor:pointer;transition:background .12s;text-align:left}
    .dropdown-item:hover{background:var(--surface2);color:var(--text)}

    .summary-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .sum-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px}
    .sum-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .sum-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;font-weight:800;color:var(--text);line-height:1.1;margin-top:4px}
    .sum-sub{font-size:12px;color:var(--text3);margin-top:2px}
    .sum-card.highlight{background:var(--brand-600);border-color:var(--brand-600)}
    .sum-card.highlight .sum-label{color:rgba(255,255,255,.7)}
    .sum-card.highlight .sum-val{color:#fff}
    .sum-card.highlight .sum-sub{color:rgba(255,255,255,.6)}

    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row input[type=date],.filter-row input[type=text]{height:36px;padding:0 10px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none}
    .filter-row input[type=date]{width:148px}
    .filter-row input[type=text]{min-width:180px}
    .filter-row select:focus,.filter-row input:focus{border-color:var(--brand-500);background:#fff}
    .filter-group{display:flex;align-items:center;gap:6px}
    .filter-group-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s}
    .btn-filter:hover{background:var(--brand-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:background .15s}
    .btn-reset:hover{background:var(--surface3)}

    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    thead th.right{text-align:right}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    td.right{text-align:right}
    td.muted{color:var(--text3)}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}

    .siswa-cell{display:flex;align-items:center;gap:10px}
    .avatar-sm{width:32px;height:32px;border-radius:8px;background:var(--brand-50);border:1.5px solid var(--brand-100);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:12px;color:var(--brand-700)}
    .two-line .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .two-line .secondary{font-size:12px;color:var(--text3);margin-top:1px}

    /* Progress bar kehadiran */
    .progress-wrap{display:flex;align-items:center;gap:8px;min-width:140px}
    .progress-bar{flex:1;height:6px;background:var(--surface3);border-radius:99px;overflow:hidden}
    .progress-fill{height:100%;border-radius:99px;transition:width .3s}
    .progress-fill.high  {background:#22c55e}
    .progress-fill.mid   {background:#f59e0b}
    .progress-fill.low   {background:#ef4444}
    .progress-pct{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;min-width:36px;text-align:right}
    .progress-pct.high{color:#15803d}
    .progress-pct.mid  {color:#b45309}
    .progress-pct.low  {color:#dc2626}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;white-space:nowrap}

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

    .tipe-toggle{display:flex;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:3px;gap:2px}
    .tipe-btn{padding:5px 14px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;border:none;background:transparent;color:var(--text3);transition:all .15s}
    .tipe-btn.active{background:var(--surface);color:var(--text);box-shadow:0 1px 3px rgba(0,0,0,.08)}

    @media(max-width:900px){.summary-strip{grid-template-columns:1fr 1fr}}
    @media(max-width:640px){.summary-strip{grid-template-columns:1fr};.page{padding:16px}}
</style>

<div class="page">

    {{-- ── Header ──────────────────────────────────────────────────────── --}}
    <div class="page-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.absensi-gerbang.index') }}">Log Absensi Gerbang</a>
                <span class="breadcrumb-sep">/</span>
                <span>Rekap Kehadiran</span>
            </div>
            <h1 class="page-title">Rekap Kehadiran Siswa</h1>
            <p class="page-sub">
                Periode {{ \Carbon\Carbon::parse($dari)->isoFormat('D MMM Y') }}
                — {{ \Carbon\Carbon::parse($sampai)->isoFormat('D MMM Y') }}
                &middot; {{ $totalHariSekolah }} hari sekolah
            </p>
        </div>
        <div class="header-actions">
            <div class="dropdown" id="exportDropdown">
                <button type="button" class="btn btn-secondary" onclick="toggleDropdown('exportDropdown')">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="dropdown-menu">
                    <a href="{{ route('admin.absensi-gerbang.rekap.export.pdf', request()->query()) }}" class="dropdown-item">
                        <svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Export PDF
                    </a>
                    <a href="{{ route('admin.absensi-gerbang.rekap.export.excel', request()->query()) }}" class="dropdown-item">
                        <svg width="14" height="14" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Export Excel
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Summary ──────────────────────────────────────────────────────── --}}
    @php
        $totalSiswa      = $rekapList->total();
        $rataHadir       = $totalSiswa > 0 ? round($rekapList->getCollection()->avg('hari_hadir'), 1) : 0;
        $rataPersen      = $totalSiswa > 0 ? round($rekapList->getCollection()->avg('persentase'), 1) : 0;
        $dibawah75       = $rekapList->getCollection()->where('persentase', '<', 75)->count();
    @endphp
    <div class="summary-strip">
        <div class="sum-card highlight">
            <p class="sum-label">Total Hari Sekolah</p>
            <p class="sum-val">{{ $totalHariSekolah }}</p>
            <p class="sum-sub">hari efektif pada periode ini</p>
        </div>
        <div class="sum-card">
            <p class="sum-label">Rata-rata Kehadiran</p>
            <p class="sum-val">{{ $rataPersen }}%</p>
            <p class="sum-sub">{{ $rataHadir }} hari rata-rata per siswa</p>
        </div>
        <div class="sum-card">
            <p class="sum-label">Jumlah Siswa</p>
            <p class="sum-val">{{ $rekapList->total() }}</p>
            <p class="sum-sub">siswa aktif pada filter ini</p>
        </div>
        <div class="sum-card">
            <p class="sum-label">Kehadiran &lt; 75%</p>
            <p class="sum-val" style="{{ $dibawah75 > 0 ? 'color:#dc2626' : '' }}">{{ $dibawah75 }}</p>
            <p class="sum-sub">siswa perlu perhatian khusus</p>
        </div>
    </div>

    {{-- ── Filter ───────────────────────────────────────────────────────── --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.absensi-gerbang.rekap') }}" id="filterForm">
            <div class="filter-row">
                <div class="filter-group">
                    <span class="filter-group-label">Dari</span>
                    <input type="date" name="dari" value="{{ $dari }}" onchange="this.form.submit()">
                </div>
                <div class="filter-group">
                    <span class="filter-group-label">Sampai</span>
                    <input type="date" name="sampai" value="{{ $sampai }}" onchange="this.form.submit()">
                </div>

                {{-- Tipe toggle (disimpan sebagai hidden, dikontrol JS) --}}
                <input type="hidden" name="tipe" id="inputTipe" value="{{ $tipe }}">
                <div class="tipe-toggle">
                    <button type="button" class="tipe-btn {{ $tipe === 'masuk' ? 'active' : '' }}"
                            onclick="setTipe('masuk')">Masuk</button>
                    <button type="button" class="tipe-btn {{ $tipe === 'pulang' ? 'active' : '' }}"
                            onclick="setTipe('pulang')">Pulang</button>
                </div>

                <select name="kelas_id" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" @selected(request('kelas_id') == $k->id)>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>

                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama / NIS…">
                <div class="filter-sep"></div>

                @if(request()->hasAny(['kelas_id','cari']) || $dari !== now()->startOfMonth()->toDateString() || $sampai !== now()->toDateString() || $tipe !== 'masuk')
                    <a href="{{ route('admin.absensi-gerbang.rekap') }}" class="btn-reset">Reset</a>
                @endif
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- ── Table ────────────────────────────────────────────────────────── --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Rekap Kehadiran
                @if($rekapList->total() > 0)
                    <span>— {{ $rekapList->firstItem() }}–{{ $rekapList->lastItem() }} dari {{ $rekapList->total() }} siswa</span>
                @else
                    <span>— tidak ada data</span>
                @endif
            </p>
            <div style="display:flex;align-items:center;gap:8px">
                <span style="display:flex;align-items:center;gap:5px;font-size:12px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;color:var(--text3)">
                    <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#22c55e"></span>≥75%
                </span>
                <span style="display:flex;align-items:center;gap:5px;font-size:12px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;color:var(--text3)">
                    <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#f59e0b"></span>50–74%
                </span>
                <span style="display:flex;align-items:center;gap:5px;font-size:12px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;color:var(--text3)">
                    <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#ef4444"></span>&lt;50%
                </span>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th class="center">Hadir</th>
                        <th class="center">Tidak Hadir</th>
                        <th class="center">Total Hari</th>
                        <th style="min-width:180px">Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekapList as $index => $siswa)
                    @php
                        $pct   = $siswa->persentase;
                        $tier  = $pct >= 75 ? 'high' : ($pct >= 50 ? 'mid' : 'low');
                    @endphp
                    <tr>
                        <td><span class="no-col">{{ $rekapList->firstItem() + $index }}</span></td>
                        <td>
                            <div class="siswa-cell">
                                <div class="avatar-sm">{{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}</div>
                                <div class="two-line">
                                    <p class="primary">{{ $siswa->nama_lengkap }}</p>
                                    <p class="secondary">NIS: {{ $siswa->nis }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="muted" style="font-size:12.5px">{{ $siswa->kelas?->nama_kelas ?? '—' }}</td>
                        <td class="center">
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:15px;color:#15803d">
                                {{ $siswa->hari_hadir }}
                            </span>
                        </td>
                        <td class="center">
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:{{ $siswa->hari_tidak_hadir > 0 ? '#dc2626' : 'var(--text3)' }}">
                                {{ $siswa->hari_tidak_hadir }}
                            </span>
                        </td>
                        <td class="center" style="color:var(--text3);font-size:13px">
                            {{ $totalHariSekolah }}
                        </td>
                        <td>
                            <div class="progress-wrap">
                                <div class="progress-bar">
                                    <div class="progress-fill {{ $tier }}" style="width:{{ min($pct, 100) }}%"></div>
                                </div>
                                <span class="progress-pct {{ $tier }}">{{ $pct }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                                </div>
                                <p class="empty-title">Belum ada data rekap</p>
                                <p class="empty-sub">Coba ubah filter periode atau kelas</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($rekapList->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $rekapList->firstItem() }}–{{ $rekapList->lastItem() }} dari {{ $rekapList->total() }} siswa</p>
            <div class="pag-btns">
                @if($rekapList->onFirstPage())
                    <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $rekapList->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif

                @php
                    $current   = $rekapList->currentPage();
                    $last      = $rekapList->lastPage();
                    $showLeft  = false;
                    $showRight = false;
                @endphp
                @foreach($rekapList->getUrlRange(1, $last) as $page => $url)
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

                @if($rekapList->hasMorePages())
                    <a href="{{ $rekapList->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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

    function toggleDropdown(id) {
        const el = document.getElementById(id);
        const isOpen = el.classList.contains('open');
        document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
        if (!isOpen) el.classList.add('open');
    }
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
    });

    function setTipe(val) {
        document.getElementById('inputTipe').value = val;
        document.querySelectorAll('.tipe-btn').forEach(b => b.classList.remove('active'));
        event.currentTarget.classList.add('active');
        document.getElementById('filterForm').submit();
    }
</script>
</x-app-layout>