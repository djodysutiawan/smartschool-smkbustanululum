<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#15803d;--green-bg:#dcfce7;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --yellow:#a16207;--yellow-bg:#fefce8;--yellow-border:#fde68a;
        --purple:#7c3aed;--purple-bg:#faf5ff;--purple-border:#e9d5ff;
        --teal:#0f766e;--teal-bg:#f0fdfa;--teal-border:#99f6e4;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    .page{padding:28px 28px 48px;font-family:'DM Sans',sans-serif}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap;line-height:1}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-detail{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
    .btn-detail:hover{background:#dbeafe;filter:none}
    .btn-del{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}
    .btn-del:hover{background:#fecaca;filter:none}
    .btn-pdf{background:var(--purple-bg);color:var(--purple);border:1px solid var(--purple-border)}
    .btn-pdf:hover{background:#ede9fe;filter:none}

    .alert{padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-size:13px;display:flex;align-items:center;gap:8px}
    .alert-success{background:#f0fdf4;border:1px solid var(--green-border);color:#166534}
    .alert-error{background:var(--red-bg);border:1px solid var(--red-border);color:#991b1b}
    .alert-info{background:var(--brand-50);border:1px solid var(--brand-100);color:var(--brand-700)}

    /* Sesi Aktif Banner */
    .aktif-banner{background:linear-gradient(135deg,#f0fdf4 0%,#ecfdf5 100%);border:1.5px solid var(--green-border);border-radius:var(--radius);padding:16px 20px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap}
    .aktif-banner-left{display:flex;align-items:center;gap:14px}
    .aktif-dot{width:10px;height:10px;border-radius:50%;background:var(--green);box-shadow:0 0 0 3px rgba(21,128,61,.2);animation:pulse 1.5s infinite}
    @keyframes pulse{0%,100%{box-shadow:0 0 0 3px rgba(21,128,61,.2)}50%{box-shadow:0 0 0 6px rgba(21,128,61,.08)}}
    .aktif-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--green)}
    .aktif-meta{font-size:12px;color:var(--text2);margin-top:2px}
    .aktif-chips{display:flex;gap:8px;flex-wrap:wrap}
    .aktif-chip{display:inline-flex;align-items:center;gap:6px;padding:5px 12px;background:#fff;border:1px solid var(--green-border);border-radius:7px;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text2)}
    .aktif-chip-tipe{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text);font-size:12.5px}
    .tipe-masuk{color:var(--brand-600)}
    .tipe-pulang{color:var(--teal)}

    /* Filter */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px}
    .filter-row{display:flex;flex-wrap:wrap;gap:8px;align-items:center}
    .filter-row select,.filter-row input[type=date]{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row select:focus,.filter-row input:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1;min-width:10px}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:6px}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center}

    /* Section label */
    .section-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.06em;margin-bottom:12px;display:flex;align-items:center;gap:8px}
    .section-label::after{content:'';flex:1;height:1px;background:var(--border)}

    /* Table */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .sesi-table{width:100%;border-collapse:collapse}
    .sesi-table th{padding:10px 18px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid var(--border);background:var(--surface2);white-space:nowrap}
    .sesi-table td{padding:13px 18px;border-bottom:1px solid var(--surface3);font-size:13px;color:var(--text2);vertical-align:middle}
    .sesi-table tr:last-child td{border-bottom:none}
    .sesi-table tr:hover td{background:var(--surface2)}

    /* Tipe badge */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-masuk{background:var(--brand-50);color:var(--brand-600)}.badge-masuk .badge-dot{background:var(--brand-500)}
    .badge-pulang{background:var(--teal-bg);color:var(--teal)}.badge-pulang .badge-dot{background:var(--teal)}
    .badge-aktif{background:var(--green-bg);color:var(--green)}.badge-aktif .badge-dot{background:var(--green);animation:pulse 1.5s infinite}
    .badge-ditutup{background:var(--surface3);color:var(--text3)}.badge-ditutup .badge-dot{background:var(--text3)}

    .dibuka-oleh{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text);font-size:13px}
    .time-range{font-size:11.5px;color:var(--text3);margin-top:2px}
    .scan-count{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text)}
    .scan-label{font-size:11px;color:var(--text3)}
    .action-cell{display:flex;gap:6px;flex-wrap:wrap}

    /* Pagination */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:16px 0;flex-wrap:wrap;gap:10px;margin-top:4px}
    .pag-info{font-size:12.5px;color:var(--text3);font-family:'DM Sans',sans-serif}
    .pag-btns{display:flex;gap:4px;align-items:center}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}

    /* Empty */
    .empty-box{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:64px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    @media(max-width:900px){.sesi-table thead{display:none}.sesi-table tr{display:block;border-bottom:1px solid var(--border);padding:12px 0}.sesi-table td{display:flex;justify-content:space-between;border:none;padding:4px 16px}}
    @media(max-width:640px){.page{padding:16px}.filter-sep{display:none}}
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Sesi Gerbang</h1>
            <p class="page-sub">Semua sesi buka/tutup gerbang absensi siswa — termasuk sesi piket lain</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('piket.sesi-gerbang.create') }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buka Sesi Baru
            </a>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Sesi Aktif Banner --}}
    @if($sesiAktif && $sesiAktif->count() > 0)
    <div class="aktif-banner">
        <div class="aktif-banner-left">
            <div class="aktif-dot"></div>
            <div>
                <div class="aktif-label">{{ $sesiAktif->count() }} Sesi Sedang Aktif</div>
                <div class="aktif-meta">Gerbang terbuka — scanner sedang beroperasi</div>
            </div>
        </div>
        <div class="aktif-chips">
            @foreach($sesiAktif as $sa)
            <a href="{{ route('piket.sesi-gerbang.show', $sa) }}" class="aktif-chip">
                <span class="aktif-chip-tipe {{ $sa->tipe === 'masuk' ? 'tipe-masuk' : 'tipe-pulang' }}">
                    {{ $sa->label_tipe }}
                </span>
                · Dibuka {{ $sa->dibuka_pada->format('H:i') }}
                · <span style="color:var(--brand-600);font-weight:700">Lihat →</span>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Filter --}}
    <div class="filter-card">
        <p class="filter-label">Filter Sesi</p>
        <form method="GET" action="{{ route('piket.sesi-gerbang.index') }}">
            <div class="filter-row">
                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari', now()->subWeek()->toDateString()) }}" style="min-width:140px">
                <span style="font-size:12px;color:var(--text3)">s/d</span>
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" style="min-width:140px">
                <select name="tipe" style="min-width:140px">
                    <option value="">Semua Tipe</option>
                    <option value="masuk"  {{ request('tipe') === 'masuk'  ? 'selected' : '' }}>Masuk Pagi</option>
                    <option value="pulang" {{ request('tipe') === 'pulang' ? 'selected' : '' }}>Pulang Sore</option>
                </select>
                <select name="status" style="min-width:140px">
                    <option value="">Semua Status</option>
                    <option value="aktif"   {{ request('status') === 'aktif'   ? 'selected' : '' }}>Aktif</option>
                    <option value="ditutup" {{ request('status') === 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('piket.sesi-gerbang.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Terapkan
                </button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    @if($sesiList->count() > 0)

    <div class="section-label">{{ $sesiList->total() }} Sesi Ditemukan</div>

    <div class="table-card">
        <table class="sesi-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Tipe</th>
                    <th>Waktu Buka</th>
                    <th>Waktu Tutup</th>
                    <th>Scan Valid</th>
                    <th>Dibuka Oleh</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sesiList as $s)
                <tr>
                    <td>
                        <div style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text);font-size:13px">
                            {{ $s->tanggal->translatedFormat('d M Y') }}
                        </div>
                        <div style="font-size:11px;color:var(--text3)">{{ $s->tanggal->translatedFormat('l') }}</div>
                    </td>
                    <td>
                        <span class="badge {{ $s->tipe === 'masuk' ? 'badge-masuk' : 'badge-pulang' }}">
                            <span class="badge-dot"></span>
                            {{ $s->label_tipe }}
                        </span>
                    </td>
                    <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text);font-size:13px">
                        {{ $s->dibuka_pada->format('H:i') }}
                    </td>
                    <td>
                        @if($s->ditutup_pada)
                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text);font-size:13px">{{ $s->ditutup_pada->format('H:i') }}</span>
                        @else
                        <span style="font-size:12px;color:var(--text3)">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="scan-count">{{ number_format($s->jumlah_scan) }}</div>
                        <div class="scan-label">scan valid</div>
                    </td>
                    <td>
                        <div class="dibuka-oleh">{{ $s->dibukaOleh?->name ?? '—' }}</div>
                        @if($s->catatan)
                        <div style="font-size:11.5px;color:var(--text3);margin-top:2px;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap" title="{{ $s->catatan }}">
                            {{ $s->catatan }}
                        </div>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $s->status === 'aktif' ? 'badge-aktif' : 'badge-ditutup' }}">
                            <span class="badge-dot"></span>
                            {{ $s->status === 'aktif' ? 'Aktif' : 'Ditutup' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-cell">
                            <a href="{{ route('piket.sesi-gerbang.show', $s) }}" class="btn btn-sm btn-detail">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                Detail
                            </a>
                            <a href="{{ route('piket.sesi-gerbang.export-pdf', $s) }}" class="btn btn-sm btn-pdf" target="_blank">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                PDF
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($sesiList->hasPages())
    <div class="pag-wrap">
        <p class="pag-info">Menampilkan {{ $sesiList->firstItem() }}–{{ $sesiList->lastItem() }} dari {{ $sesiList->total() }} sesi</p>
        <div class="pag-btns">
            @if($sesiList->onFirstPage())
                <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
            @else
                <a href="{{ $sesiList->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
            @endif
            @foreach($sesiList->getUrlRange(1, $sesiList->lastPage()) as $page => $url)
                @if($page == $sesiList->currentPage())
                    <span class="pag-btn active">{{ $page }}</span>
                @elseif($page == 1 || $page == $sesiList->lastPage() || abs($page - $sesiList->currentPage()) <= 1)
                    <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                @elseif(abs($page - $sesiList->currentPage()) == 2)
                    <span class="pag-ellipsis">…</span>
                @endif
            @endforeach
            @if($sesiList->hasMorePages())
                <a href="{{ $sesiList->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
            @else
                <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
            @endif
        </div>
    </div>
    @endif

    @else
    <div class="empty-box">
        <div class="empty-icon">
            <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        </div>
        <p class="empty-title">Belum ada sesi gerbang</p>
        <p class="empty-sub" style="margin-bottom:16px">Buka sesi baru untuk mulai mencatat absensi siswa di gerbang</p>
        <a href="{{ route('piket.sesi-gerbang.create') }}" class="btn btn-primary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Buka Sesi Pertama
        </a>
    </div>
    @endif

</div>
</x-app-layout>