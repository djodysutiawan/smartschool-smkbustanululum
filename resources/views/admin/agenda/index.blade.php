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
    .page{padding:28px 28px 48px;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-ghost{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
    .btn-ghost:hover{background:var(--surface3);filter:none;}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px;}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}
    .btn-edit:hover{background:var(--brand-100);filter:none;}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-del:hover{background:#fee2e2;filter:none;}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-detail:hover{background:#dcfce7;filter:none;}

    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}
    .stat-icon.green{background:#f0fdf4;}
    .stat-icon.yellow{background:#fefce8;}
    .stat-icon.purple{background:#fdf4ff;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}

    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center;}
    .filter-row input,.filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;}
    .filter-row input{width:210px;}
    .filter-row input:focus,.filter-row select:focus{border-color:var(--brand-500);background:#fff;}
    .filter-row input::placeholder{color:var(--text3);}
    .filter-sep{flex:1;}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;}
    .btn-filter:hover{background:var(--brand-700);}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;}
    .btn-reset:hover{background:var(--surface3);}

    .view-toggle{display:flex;gap:4px;background:var(--surface2);border:1px solid var(--border);border-radius:8px;padding:3px;}
    .view-btn{padding:5px 10px;border:none;background:none;border-radius:6px;cursor:pointer;color:var(--text3);display:flex;align-items:center;gap:4px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;transition:all .15s;}
    .view-btn.active{background:var(--surface);color:var(--brand-600);box-shadow:0 1px 3px rgba(0,0,0,.08);}

    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px;}
    .table-wrap{overflow-x:auto;}
    table{width:100%;border-collapse:collapse;font-size:13.5px;}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
    thead th.center{text-align:center;}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:#fafbff;}
    td{padding:11px 14px;color:var(--text);vertical-align:middle;}
    td.center{text-align:center;}
    td.muted{color:var(--text3);font-size:12.5px;}

    .agenda-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text);}
    .agenda-meta{font-size:12px;color:var(--text3);margin-top:2px;display:flex;align-items:center;gap:6px;}

    .color-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;display:inline-block;}

    .tipe-pill{display:inline-block;padding:2px 9px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;background:var(--surface2);color:var(--text2);border:1px solid var(--border);}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;border:none;cursor:pointer;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-published{background:#dcfce7;color:#15803d;}
    .badge-published .badge-dot{background:#15803d;}
    .badge-draft{background:#f1f5f9;color:#64748b;}
    .badge-draft .badge-dot{background:#64748b;}

    .action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap;}

    .empty-state{padding:60px 20px;text-align:center;}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px;}
    .empty-sub{font-size:13px;color:var(--text3);}

    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .pag-info{font-size:12.5px;color:var(--text3);}
    .pag-btns{display:flex;gap:4px;align-items:center;}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none;}
    .pag-btn:hover{background:var(--surface2);}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff;}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;}

    /* Card view */
    .card-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:14px;padding:20px;}
    .agenda-card{border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;background:var(--surface);transition:box-shadow .15s;}
    .agenda-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.07);}
    .agenda-card-bar{height:4px;}
    .agenda-card-body{padding:14px 16px;}
    .agenda-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--text);margin-bottom:6px;}
    .agenda-card-date{font-size:12px;color:var(--text3);display:flex;align-items:center;gap:5px;margin-bottom:8px;}
    .agenda-card-footer{display:flex;align-items:center;justify-content:space-between;padding:10px 16px;border-top:1px solid var(--surface3);}

    @media(max-width:768px){.stats-strip{grid-template-columns:1fr 1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Agenda Sekolah</h1>
            <p class="page-sub">Kelola jadwal dan kegiatan sekolah</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.agenda.kalender') }}" class="btn btn-ghost">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Lihat Kalender
            </a>
            <a href="{{ route('admin.agenda.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Agenda
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Agenda</p>
                <p class="stat-val">{{ $agenda->total() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div>
                <p class="stat-label">Published</p>
                <p class="stat-val">{{ \App\Models\AgendaSekolah::where('is_published', true)->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Akan Datang</p>
                <p class="stat-val">{{ \App\Models\AgendaSekolah::where('tanggal_mulai', '>=', now())->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Bulan Ini</p>
                <p class="stat-val">{{ \App\Models\AgendaSekolah::whereMonth('tanggal_mulai', now()->month)->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.agenda.index') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul agenda...">
                <select name="tipe">
                    <option value="">Semua Tipe</option>
                    @foreach(['akademik','olahraga','seni','rapat','libur','ujian','lainnya'] as $t)
                        <option value="{{ $t }}" {{ request('tipe') == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                    @endforeach
                </select>
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft"     {{ request('status') == 'draft'     ? 'selected' : '' }}>Draft</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.agenda.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Agenda
                <span>— {{ $agenda->total() }} data</span>
            </p>
            <div class="view-toggle">
                <button class="view-btn active" id="btnList" onclick="switchView('list')">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    List
                </button>
                <button class="view-btn" id="btnCard" onclick="switchView('card')">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                    Kartu
                </button>
            </div>
        </div>

        {{-- List View --}}
        <div id="viewList">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width:48px">#</th>
                            <th>Judul Agenda</th>
                            <th>Tipe</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Lokasi</th>
                            <th class="center">Status</th>
                            <th class="center" style="width:190px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agenda as $i => $a)
                        <tr>
                            <td class="muted">{{ $agenda->firstItem() + $i }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <span class="color-dot" style="background:{{ $a->warna ?? '#94a3b8' }}"></span>
                                    <div>
                                        <p class="agenda-title">{{ $a->judul }}</p>
                                        @if($a->jam_mulai)
                                        <p class="agenda-meta">
                                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                            {{ \Carbon\Carbon::parse($a->jam_mulai)->format('H:i') }}
                                            @if($a->jam_selesai) – {{ \Carbon\Carbon::parse($a->jam_selesai)->format('H:i') }}@endif
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td><span class="tipe-pill">{{ ucfirst($a->tipe ?? '-') }}</span></td>
                            <td class="muted">{{ \Carbon\Carbon::parse($a->tanggal_mulai)->translatedFormat('d M Y') }}</td>
                            <td class="muted">{{ $a->tanggal_selesai ? \Carbon\Carbon::parse($a->tanggal_selesai)->translatedFormat('d M Y') : '-' }}</td>
                            <td class="muted">{{ $a->lokasi ?? '-' }}</td>
                            <td class="center">
                                <form action="{{ route('admin.agenda.toggle', $a) }}" method="POST" style="display:inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="badge {{ $a->is_published ? 'badge-published' : 'badge-draft' }}">
                                        <span class="badge-dot"></span>
                                        {{ $a->is_published ? 'Published' : 'Draft' }}
                                    </button>
                                </form>
                            </td>
                            <td class="center">
                                <div class="action-group">
                                    <a href="{{ route('admin.agenda.show', $a) }}" class="btn btn-sm btn-detail">Detail</a>
                                    <a href="{{ route('admin.agenda.edit', $a) }}" class="btn btn-sm btn-edit">Edit</a>
                                    <form action="{{ route('admin.agenda.destroy', $a) }}" method="POST" id="delAgenda-{{ $a->id }}">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-del"
                                            onclick="confirmDelete(document.getElementById('delAgenda-{{ $a->id }}'), '{{ addslashes($a->judul) }}')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    </div>
                                    <p class="empty-title">Belum ada agenda</p>
                                    <p class="empty-sub">Klik "Tambah Agenda" untuk membuat jadwal kegiatan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Card View --}}
        <div id="viewCard" style="display:none">
            @forelse($agenda as $a)
            <div style="display:none" class="card-grid-item" data-id="{{ $a->id }}"></div>
            @empty @endforelse
            <div class="card-grid">
                @forelse($agenda as $a)
                <div class="agenda-card">
                    <div class="agenda-card-bar" style="background:{{ $a->warna ?? '#94a3b8' }}"></div>
                    <div class="agenda-card-body">
                        <p class="agenda-card-title">{{ $a->judul }}</p>
                        <p class="agenda-card-date">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ \Carbon\Carbon::parse($a->tanggal_mulai)->translatedFormat('d M Y') }}
                            @if($a->tanggal_selesai && $a->tanggal_selesai != $a->tanggal_mulai)
                                – {{ \Carbon\Carbon::parse($a->tanggal_selesai)->translatedFormat('d M Y') }}
                            @endif
                        </p>
                        @if($a->lokasi)
                        <p class="agenda-card-date">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                            {{ $a->lokasi }}
                        </p>
                        @endif
                        @if($a->tipe)
                        <span class="tipe-pill" style="margin-top:6px;display:inline-block">{{ ucfirst($a->tipe) }}</span>
                        @endif
                    </div>
                    <div class="agenda-card-footer">
                        <span class="badge {{ $a->is_published ? 'badge-published' : 'badge-draft' }}" style="cursor:default">
                            <span class="badge-dot"></span>{{ $a->is_published ? 'Published' : 'Draft' }}
                        </span>
                        <div style="display:flex;gap:4px">
                            <a href="{{ route('admin.agenda.edit', $a) }}" class="btn btn-sm btn-edit">Edit</a>
                            <a href="{{ route('admin.agenda.show', $a) }}" class="btn btn-sm btn-detail">Detail</a>
                        </div>
                    </div>
                </div>
                @empty
                <div style="grid-column:1/-1">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <p class="empty-title">Belum ada agenda</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>

        @if($agenda->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $agenda->firstItem() }}–{{ $agenda->lastItem() }} dari {{ $agenda->total() }}</p>
            <div class="pag-btns">
                @if($agenda->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $agenda->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($agenda->getUrlRange(1, $agenda->lastPage()) as $page => $url)
                    @if($page == $agenda->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $agenda->lastPage() || abs($page - $agenda->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $agenda->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($agenda->hasMorePages())
                    <a href="{{ $agenda->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
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
    @if(session('info'))
    Swal.fire({icon:'info',title:'Info',text:@json(session('info')),confirmButtonColor:'#1f63db'});
    @endif

    function switchView(v) {
        document.getElementById('viewList').style.display = v === 'list' ? 'block' : 'none';
        document.getElementById('viewCard').style.display = v === 'card' ? 'block' : 'none';
        document.getElementById('btnList').classList.toggle('active', v === 'list');
        document.getElementById('btnCard').classList.toggle('active', v === 'card');
        localStorage.setItem('agendaView', v);
    }
    const saved = localStorage.getItem('agendaView');
    if (saved) switchView(saved);

    function confirmDelete(form, nama) {
        Swal.fire({
            title:'Hapus Agenda?',
            text:`"${nama}" akan dihapus permanen.`,
            icon:'warning',showCancelButton:true,
            confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>