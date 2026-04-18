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
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}.btn-detail:hover{background:#dcfce7;filter:none}
    .btn-checkout{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}.btn-checkout:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}.btn-del:hover{background:#fee2e2;filter:none}
    .btn-export{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa}.btn-export:hover{background:#ffedd5;filter:none}
    .btn-import{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}.btn-import:hover{background:#dcfce7;filter:none}
    .btn-pdf{background:#fdf4ff;color:#7c3aed;border:1px solid #e9d5ff}.btn-pdf:hover{background:#f3e8ff;filter:none}
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.blue{background:var(--brand-50)}.stat-icon.green{background:#f0fdf4}
    .stat-icon.orange{background:#fff7ed}.stat-icon.purple{background:#faf5ff}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .bertugas-card{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px}
    .bertugas-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--brand-700);margin-bottom:10px;display:flex;align-items:center;gap:6px}
    .bertugas-list{display:flex;flex-wrap:wrap;gap:8px}
    .bertugas-chip{display:inline-flex;align-items:center;gap:8px;background:#fff;border:1px solid var(--brand-100);border-radius:8px;padding:6px 12px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text)}
    .bertugas-dot{width:7px;height:7px;border-radius:50%;background:#22c55e;animation:pulse 1.5s infinite}
    @keyframes pulse{0%,100%{opacity:1}50%{opacity:.4}}
    .bertugas-time{font-size:11.5px;color:var(--text3);font-weight:400}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row input,.filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row input{width:160px}
    .filter-row input:focus,.filter-row select:focus{border-color:var(--brand-500);background:#fff}
    .filter-row input::placeholder{color:var(--text3)}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer}
    .btn-filter:hover{background:var(--brand-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center}
    .btn-reset:hover{background:var(--surface3)}
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px}
    .table-actions{display:flex;gap:8px;flex-wrap:wrap}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    td.muted{color:var(--text3)}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}
    .guru-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .guru-nip{font-size:12px;color:var(--text3);margin-top:1px}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%}
    .badge-masuk{background:#dcfce7;color:#15803d}.badge-masuk .badge-dot{background:#15803d}
    .badge-keluar{background:var(--brand-50);color:var(--brand-700)}.badge-keluar .badge-dot{background:var(--brand-600)}
    .badge-belum{background:#f1f5f9;color:var(--text3)}.badge-belum .badge-dot{background:var(--text3)}
    .badge-pagi{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa}
    .badge-siang{background:#fefce8;color:#a16207;border:1px solid #fde68a}
    .time-col{font-family:'DM Sans',sans-serif;font-size:13px}
    .time-col .time{font-weight:600;color:var(--text)}
    .time-col .dash{color:var(--text3);font-size:11px}
    .action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap}
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
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}
    .modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.4);display:flex;align-items:center;justify-content:center;z-index:999;opacity:0;pointer-events:none;transition:opacity .2s}
    .modal-overlay.show{opacity:1;pointer-events:all}
    .modal-box{background:#fff;border-radius:var(--radius);padding:28px;width:100%;max-width:440px;box-shadow:0 20px 60px rgba(0,0,0,.18)}
    .modal-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:800;color:var(--text);margin-bottom:6px}
    .modal-sub{font-size:13px;color:var(--text3);margin-bottom:20px}
    .modal-footer{display:flex;gap:10px;justify-content:flex-end;margin-top:20px}
    .field{display:flex;flex-direction:column;gap:6px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
    .field input{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none}
    .field input:focus{border-color:var(--brand-500);background:#fff}
    .btn-cancel-modal{background:var(--surface);color:var(--text2);border:1px solid var(--border)}
    @media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr}.page{padding:16px}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Log Piket Guru</h1>
            <p class="page-sub">Pantau dan kelola catatan check-in / check-out guru piket harian</p>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Log</p>
                <p class="stat-val">{{ $logs->total() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Sedang Bertugas</p>
                <p class="stat-val">{{ $sedangBertugas->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div>
                <p class="stat-label">Guru Piket</p>
                <p class="stat-val">{{ $guruPiket->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <p class="stat-label">Log Hari Ini</p>
                <p class="stat-val">{{ \App\Models\LogPiket::whereDate('tanggal', today())->count() }}</p>
            </div>
        </div>
    </div>

    @if($sedangBertugas->count())
    <div class="bertugas-card">
        <p class="bertugas-title">
            <span class="bertugas-dot"></span>
            Sedang Bertugas Sekarang ({{ $sedangBertugas->count() }} guru)
        </p>
        <div class="bertugas-list">
            @foreach($sedangBertugas as $b)
            <div class="bertugas-chip">
                <svg width="13" height="13" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                {{ $b->guru->nama_lengkap ?? '-' }}
                <span class="bertugas-time">masuk {{ \Carbon\Carbon::parse($b->masuk_pada)->format('H:i') }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.log-piket.index') }}">
            <div class="filter-row">
                <select name="guru_id">
                    <option value="">Semua Guru</option>
                    @foreach($guruPiket as $g)
                        <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                    @endforeach
                </select>
                <select name="shift">
                    <option value="">Semua Shift</option>
                    <option value="pagi" {{ request('shift') == 'pagi' ? 'selected' : '' }}>Pagi</option>
                    <option value="siang" {{ request('shift') == 'siang' ? 'selected' : '' }}>Siang</option>
                </select>
                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" title="Dari Tanggal">
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" title="Sampai Tanggal">
                <div class="filter-sep"></div>
                <a href="{{ route('admin.log-piket.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Log Piket
                <span>— menampilkan {{ $logs->firstItem() }}–{{ $logs->lastItem() }} dari {{ $logs->total() }} data</span>
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.log-piket.export-pdf') }}{{ request()->getQueryString() ? '?'.request()->getQueryString() : '' }}" class="btn btn-sm btn-pdf" target="_blank">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.log-piket.export-excel') }}{{ request()->getQueryString() ? '?'.request()->getQueryString() : '' }}" class="btn btn-sm btn-export">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export Excel
                </a>
                <button type="button" class="btn btn-sm btn-import" onclick="document.getElementById('modalImport').classList.add('show')">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Import
                </button>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Guru Piket</th>
                        <th>Tanggal</th>
                        <th>Shift</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Status</th>
                        <th>Dicatat Oleh</th>
                        <th class="center" style="width:180px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $index => $log)
                    <tr>
                        <td><span class="no-col">{{ $logs->firstItem() + $index }}</span></td>
                        <td>
                            <div class="guru-name">{{ $log->guru->nama_lengkap ?? '-' }}</div>
                            <div class="guru-nip">{{ $log->guru->nip ?? '' }}</div>
                        </td>
                        <td style="font-size:13px">{{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d M Y') }}</td>
                        <td>
                            @if($log->shift == 'pagi')
                                <span class="badge badge-pagi">Pagi</span>
                            @elseif($log->shift == 'siang')
                                <span class="badge badge-siang">Siang</span>
                            @else
                                <span style="color:var(--text3);font-size:12.5px">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="time-col">
                                @if($log->masuk_pada)
                                    <span class="time">{{ \Carbon\Carbon::parse($log->masuk_pada)->format('H:i') }}</span>
                                @else
                                    <span class="dash">—</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="time-col">
                                @if($log->keluar_pada)
                                    <span class="time">{{ \Carbon\Carbon::parse($log->keluar_pada)->format('H:i') }}</span>
                                @else
                                    <span class="dash">—</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($log->keluar_pada)
                                <span class="badge badge-keluar"><span class="badge-dot"></span>Selesai</span>
                            @elseif($log->masuk_pada)
                                <span class="badge badge-masuk"><span class="badge-dot"></span>Bertugas</span>
                            @else
                                <span class="badge badge-belum"><span class="badge-dot"></span>Belum Masuk</span>
                            @endif
                        </td>
                        <td class="muted" style="font-size:12.5px">{{ $log->pengguna->name ?? '-' }}</td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.log-piket.show', $log->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                @if($log->masuk_pada && !$log->keluar_pada)
                                <form action="{{ route('admin.log-piket.check-out', $log->id) }}" method="POST" id="coForm-{{ $log->id }}">
                                    @csrf @method('PATCH')
                                    <button type="button" class="btn btn-sm btn-checkout"
                                        onclick="confirmCheckout(document.getElementById('coForm-{{ $log->id }}'), '{{ addslashes($log->guru->nama_lengkap ?? '') }}')">
                                        Check-Out
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('admin.log-piket.destroy', $log->id) }}" method="POST" id="delForm-{{ $log->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delForm-{{ $log->id }}'), '{{ addslashes($log->guru->nama_lengkap ?? '') }}')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                </div>
                                <p class="empty-title">Belum ada log piket</p>
                                <p class="empty-sub">Coba ubah filter atau belum ada data untuk periode ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $logs->firstItem() }} – {{ $logs->lastItem() }} dari {{ $logs->total() }} log</p>
            <div class="pag-btns">
                @if($logs->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $logs->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
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
                    <a href="{{ $logs->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Modal Import --}}
<div class="modal-overlay" id="modalImport">
    <div class="modal-box">
        <p class="modal-title">Import Log Piket</p>
        <p class="modal-sub">Upload file Excel (.xlsx/.xls) sesuai format template. <a href="{{ route('admin.log-piket.import-template') }}" style="color:var(--brand-600);font-weight:600">Download template</a></p>
        <form action="{{ route('admin.log-piket.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="field">
                <label>File Excel <span style="color:var(--brand-600)">*</span></label>
                <input type="file" name="file" accept=".xlsx,.xls" required style="height:auto;padding:8px 12px">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel-modal btn" onclick="document.getElementById('modalImport').classList.remove('show')">Batal</button>
                <button type="submit" class="btn btn-primary" style="background:var(--brand-600);color:#fff">Upload & Import</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
    @endif
    @if(session('error'))
    Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
    @endif
    @if(session('import_errors'))
    Swal.fire({icon:'warning',title:'Import Selesai dengan Peringatan',html:`<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">@foreach(session('import_errors') as $e)<li>{{ $e }}</li>@endforeach</ul>`,confirmButtonColor:'#1f63db'});
    @endif

    function confirmCheckout(form, nama) {
        Swal.fire({
            title:'Konfirmasi Check-Out?',
            text:`Catat waktu keluar untuk "${nama}" sekarang?`,
            icon:'question',showCancelButton:true,
            confirmButtonColor:'#1f63db',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Check-Out!',cancelButtonText:'Batal',
        }).then(r => { if(r.isConfirmed) form.submit(); });
    }

    function confirmDelete(form, nama) {
        Swal.fire({
            title:'Hapus Log Piket?',
            text:`Log piket "${nama}" akan dihapus permanen.`,
            icon:'warning',showCancelButton:true,
            confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal',
        }).then(r => { if(r.isConfirmed) form.submit(); });
    }

    document.getElementById('modalImport').addEventListener('click', function(e) {
        if(e.target === this) this.classList.remove('show');
    });
</script>
</x-app-layout>