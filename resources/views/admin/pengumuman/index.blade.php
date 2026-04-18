<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;--brand-100:#d9ebll;--brand-50:#eef6ff;--brand-100:#d9ebff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;}
    .page{padding:28px 28px 40px;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px;}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}.btn-edit:hover{background:var(--brand-100);filter:none;}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}.btn-del:hover{background:#fee2e2;filter:none;}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}.btn-detail:hover{background:#dcfce7;filter:none;}
    .btn-publish{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}.btn-publish:hover{background:#dcfce7;filter:none;}
    .btn-export-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}.btn-export-pdf:hover{background:#fee2e2;filter:none;}
    .btn-export-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}.btn-export-excel:hover{background:#dcfce7;filter:none;}
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}.stat-icon.green{background:#f0fdf4;}.stat-icon.gray{background:var(--surface3);}.stat-icon.orange{background:#fff7ed;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center;}
    .filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;}
    .filter-row select:focus{border-color:var(--brand-500);background:#fff;}
    .filter-sep{flex:1;}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;}
    .btn-filter:hover{background:var(--brand-700);}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;}
    .btn-reset:hover{background:var(--surface3);}
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px;}
    .table-actions{display:flex;gap:8px;flex-wrap:wrap;}
    .table-wrap{overflow-x:auto;}
    table{width:100%;border-collapse:collapse;font-size:13.5px;}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
    thead th.center{text-align:center;}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:#fafbff;}
    td{padding:10px 14px;color:var(--text);vertical-align:middle;}
    td.center{text-align:center;}td.muted{color:var(--text3);}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);}
    .judul-text{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text);}
    .judul-meta{font-size:12px;color:var(--text3);margin-top:2px;}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-published{background:#dcfce7;color:#15803d;}.badge-published .badge-dot{background:#15803d;}
    .badge-draft{background:#f1f5f9;color:#64748b;}.badge-draft .badge-dot{background:#94a3b8;}
    .badge-pinned{background:#fef9c3;color:#a16207;border:1px solid #fde68a;}
    .role-pill{display:inline-block;padding:2px 9px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;}
    .role-semua{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;}
    .role-admin{background:#eef2ff;color:#4338ca;border:1px solid #c7d2fe;}
    .role-guru{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}
    .role-siswa{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .role-orang_tua{background:#fdf4ff;color:#7c3aed;border:1px solid #e9d5ff;}
    .role-guru_piket{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;}
    .lampiran-badge{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:5px;background:#f1f5f9;color:#475569;font-size:11.5px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;}
    .action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap;}
    .empty-state{padding:60px 20px;text-align:center;}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px;}
    .empty-sub{font-size:13px;color:var(--text3);}
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .pag-info{font-size:12.5px;color:var(--text3);}
    .pag-btns{display:flex;gap:4px;align-items:center;}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none;}
    .pag-btn:hover{background:var(--surface2);border-color:var(--border2);}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff;}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;}
    @media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Pengumuman</h1>
            <p class="page-sub">Kelola pengumuman broadcast kepada seluruh atau sebagian pengguna</p>
        </div>
        <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Buat Pengumuman
        </a>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div><p class="stat-label">Total</p><p class="stat-val">{{ $pengumuman->total() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Dipublikasikan</p><p class="stat-val">{{ $pengumuman->getCollection()->whereNotNull('dipublikasikan_pada')->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon gray">
                <svg width="18" height="18" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
            <div><p class="stat-label">Draft</p><p class="stat-val">{{ $pengumuman->getCollection()->whereNull('dipublikasikan_pada')->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div><p class="stat-label">Bulan Ini</p><p class="stat-val">{{ $pengumuman->getCollection()->filter(fn($p) => $p->created_at->isCurrentMonth())->count() }}</p></div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.pengumuman.index') }}">
            <div class="filter-row">
                <select name="target_role">
                    <option value="">Semua Target</option>
                    @foreach(['semua','guru','siswa','orang_tua','guru_piket'] as $r)
                        <option value="{{ $r }}" {{ request('target_role') == $r ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$r)) }}</option>
                    @endforeach
                </select>
                <select name="status_publikasi">
                    <option value="">Semua Status</option>
                    <option value="dipublikasikan" {{ request('status_publikasi') == 'dipublikasikan' ? 'selected' : '' }}>Dipublikasikan</option>
                    <option value="draft" {{ request('status_publikasi') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.pengumuman.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Pengumuman
                @if($pengumuman->total())
                    <span>— menampilkan {{ $pengumuman->firstItem() }}–{{ $pengumuman->lastItem() }} dari {{ $pengumuman->total() }} data</span>
                @endif
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.pengumuman.export.pdf', request()->query()) }}" class="btn btn-sm btn-export-pdf" target="_blank">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    PDF
                </a>
                <a href="{{ route('admin.pengumuman.export.excel', request()->query()) }}" class="btn btn-sm btn-export-excel">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                    Excel
                </a>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Judul</th>
                        <th>Target</th>
                        <th>Lampiran</th>
                        <th>Dibuat Oleh</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="center" style="width:220px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengumuman as $index => $p)
                    <tr>
                        <td><span class="no-col">{{ $pengumuman->firstItem() + $index }}</span></td>
                        <td>
                            <div class="judul-text">{{ Str::limit($p->judul, 60) }}</div>
                            <div class="judul-meta">{{ Str::limit(strip_tags($p->isi), 80) }}</div>
                            @if($p->dipinned)
                                <span class="badge badge-pinned" style="margin-top:3px">📌 Dipinned</span>
                            @endif
                        </td>
                        <td>
                            <span class="role-pill role-{{ $p->target_role }}">
                                {{ ucfirst(str_replace('_',' ',$p->target_role)) }}
                            </span>
                        </td>
                        <td>
                            @if($p->path_lampiran)
                                <a href="{{ asset('storage/'.$p->path_lampiran) }}" target="_blank" class="lampiran-badge">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                                    Ada
                                </a>
                            @else
                                <span class="muted" style="font-size:12px">—</span>
                            @endif
                        </td>
                        <td class="muted" style="font-size:12.5px">{{ $p->dibuatOleh->name ?? '—' }}</td>
                        <td class="muted" style="font-size:12px;white-space:nowrap">
                            {{ $p->dipublikasikan_pada
                                ? \Carbon\Carbon::parse($p->dipublikasikan_pada)->format('d M Y')
                                : $p->created_at->format('d M Y') }}
                        </td>
                        <td>
                            @if($p->dipublikasikan_pada)
                                <span class="badge badge-published"><span class="badge-dot"></span>Publik</span>
                            @else
                                <span class="badge badge-draft"><span class="badge-dot"></span>Draft</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.pengumuman.show', $p->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                @if(!$p->dipublikasikan_pada)
                                    <form action="{{ route('admin.pengumuman.publish', $p->id) }}" method="POST" id="pubForm-{{ $p->id }}">
                                        @csrf @method('PATCH')
                                        <button type="button" class="btn btn-sm btn-publish"
                                            onclick="confirmPublish(document.getElementById('pubForm-{{ $p->id }}'), '{{ addslashes($p->judul) }}')">
                                            Publish
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.pengumuman.edit', $p->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('admin.pengumuman.destroy', $p->id) }}" method="POST" id="delForm-{{ $p->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delForm-{{ $p->id }}'), '{{ addslashes($p->judul) }}')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8">
                        <div class="empty-state">
                            <div class="empty-icon"><svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
                            <p class="empty-title">Belum ada pengumuman</p>
                            <p class="empty-sub">Buat pengumuman baru untuk disiarkan ke pengguna</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengumuman->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $pengumuman->firstItem() }} – {{ $pengumuman->lastItem() }} dari {{ $pengumuman->total() }} pengumuman</p>
            <div class="pag-btns">
                @if($pengumuman->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $pengumuman->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($pengumuman->getUrlRange(1, $pengumuman->lastPage()) as $page => $url)
                    @if($page == $pengumuman->currentPage()) <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $pengumuman->lastPage() || abs($page - $pengumuman->currentPage()) <= 1) <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $pengumuman->currentPage()) == 2) <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($pengumuman->hasMorePages())
                    <a href="{{ $pengumuman->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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

    function confirmPublish(form, judul) {
        Swal.fire({
            title:'Publikasikan Pengumuman?',
            html:`Pengumuman <strong>"${judul}"</strong> akan langsung dikirim ke seluruh target pengguna.`,
            icon:'question',showCancelButton:true,
            confirmButtonColor:'#15803d',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Publikasikan!',cancelButtonText:'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }

    function confirmDelete(form, judul) {
        Swal.fire({
            title:'Hapus Pengumuman?',
            html:`Pengumuman <strong>"${judul}"</strong> akan dihapus permanen beserta lampirannya.`,
            icon:'warning',showCancelButton:true,
            confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>