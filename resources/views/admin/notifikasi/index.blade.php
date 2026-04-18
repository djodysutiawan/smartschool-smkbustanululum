<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;--brand-100:#d9ebff;--brand-50:#eef6ff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;}
    .page{padding:28px 28px 40px;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px;}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}.btn-del:hover{background:#fee2e2;filter:none;}
    .btn-export-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}.btn-export-pdf:hover{background:#fee2e2;filter:none;}
    .btn-export-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}.btn-export-excel:hover{background:#dcfce7;filter:none;}
    .stats-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}.stat-icon.green{background:#f0fdf4;}.stat-icon.yellow{background:#fefce8;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center;}
    .filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;}
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
    .table-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center;}
    .table-wrap{overflow-x:auto;}
    table{width:100%;border-collapse:collapse;font-size:13.5px;}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
    thead th.center{text-align:center;}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:#fafbff;}
    tbody tr.unread{background:#fafbff;}
    td{padding:10px 14px;color:var(--text);vertical-align:middle;}
    td.center{text-align:center;}td.muted{color:var(--text3);font-size:12.5px;}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);}
    .judul-cell{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;}
    .pesan-cell{font-size:12.5px;color:var(--text2);max-width:280px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
    .jenis-pill{display:inline-block;padding:2px 9px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;text-transform:capitalize;}
    .jenis-info{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}
    .jenis-peringatan{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;}
    .jenis-pelanggaran{background:#ffe4e6;color:#9f1239;border:1px solid #fecdd3;}
    .jenis-tugas{background:#fdf4ff;color:#7c3aed;border:1px solid #e9d5ff;}
    .jenis-ujian{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;}
    .jenis-absensi{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .jenis-nilai{background:#fefce8;color:#a16207;border:1px solid #fde68a;}
    .jenis-pengumuman{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;}
    .jenis-sistem{background:var(--surface3);color:var(--text2);border:1px solid var(--border2);}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-dibaca{background:#f1f5f9;color:#64748b;}.badge-dibaca .badge-dot{background:#64748b;}
    .badge-belum{background:#dbeafe;color:#1d4ed8;}.badge-belum .badge-dot{background:#1d4ed8;}
    .cb-select{width:16px;height:16px;accent-color:var(--brand-600);cursor:pointer;}
    .action-group{display:flex;align-items:center;gap:5px;justify-content:center;}
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
            <h1 class="page-title">Notifikasi</h1>
            <p class="page-sub">Kelola dan kirim notifikasi in-app ke pengguna sistem</p>
        </div>
        <a href="{{ route('admin.notifikasi.create') }}" class="btn btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            Kirim Notifikasi
        </a>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            </div>
            <div><p class="stat-label">Total</p><p class="stat-val">{{ $notifikasis->total() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div><p class="stat-label">Belum Dibaca</p><p class="stat-val">{{ \App\Models\Notifikasi::where('sudah_dibaca', false)->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Sudah Dibaca</p><p class="stat-val">{{ \App\Models\Notifikasi::where('sudah_dibaca', true)->count() }}</p></div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.notifikasi.index') }}">
            <div class="filter-row">
                <select name="pengguna_id">
                    <option value="">Semua Pengguna</option>
                    @foreach($pengguna as $p)
                        <option value="{{ $p->id }}" {{ request('pengguna_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
                <select name="jenis">
                    <option value="">Semua Jenis</option>
                    @foreach(['info','peringatan','pelanggaran','absensi','nilai','pengumuman','tugas','ujian'] as $j)
                        <option value="{{ $j }}" {{ request('jenis') == $j ? 'selected' : '' }}>{{ ucfirst($j) }}</option>
                    @endforeach
                </select>
                <select name="sudah_dibaca">
                    <option value="">Semua Status</option>
                    <option value="ya" {{ request('sudah_dibaca') == 'ya' ? 'selected' : '' }}>Sudah Dibaca</option>
                    <option value="tidak" {{ request('sudah_dibaca') == 'tidak' ? 'selected' : '' }}>Belum Dibaca</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.notifikasi.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <form id="bulkForm" action="{{ route('admin.notifikasi.destroy-bulk') }}" method="POST">
        @csrf @method('DELETE')
    </form>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Notifikasi
                @if($notifikasis->total())
                    <span>— menampilkan {{ $notifikasis->firstItem() }}–{{ $notifikasis->lastItem() }} dari {{ $notifikasis->total() }} data</span>
                @endif
            </p>
            <div class="table-actions">
                <button onclick="hapusTerpilih()" class="btn btn-sm btn-del" id="btnBulkDel" style="display:none">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                    Hapus Terpilih (<span id="selCount">0</span>)
                </button>
                <a href="{{ route('admin.notifikasi.export.pdf', request()->query()) }}" class="btn btn-sm btn-export-pdf" target="_blank">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    PDF
                </a>
                <a href="{{ route('admin.notifikasi.export.excel', request()->query()) }}" class="btn btn-sm btn-export-excel">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                    Excel
                </a>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:44px"><input type="checkbox" class="cb-select" id="cbAll" onchange="toggleAll(this)"></th>
                        <th style="width:48px">#</th>
                        <th>Judul / Pesan</th>
                        <th>Penerima</th>
                        <th>Jenis</th>
                        <th>Status Baca</th>
                        <th>Waktu</th>
                        <th class="center" style="width:80px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifikasis as $index => $n)
                    <tr class="{{ !$n->sudah_dibaca ? 'unread' : '' }}">
                        <td><input type="checkbox" class="cb-select cb-item" value="{{ $n->id }}" onchange="updateBulkBtn()"></td>
                        <td><span class="no-col">{{ $notifikasis->firstItem() + $index }}</span></td>
                        <td>
                            <p class="judul-cell">{{ $n->judul }}</p>
                            <p class="pesan-cell">{{ $n->pesan }}</p>
                            @if($n->url_tujuan)
                                <a href="{{ $n->url_tujuan }}" target="_blank" style="font-size:11px;color:var(--brand-600);text-decoration:none">↗ {{ Str::limit($n->url_tujuan, 40) }}</a>
                            @endif
                        </td>
                        <td>
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px">{{ $n->pengguna->name ?? '-' }}</p>
                            <p style="font-size:11.5px;color:var(--text3)">{{ $n->pengguna->email ?? '' }}</p>
                        </td>
                        <td><span class="jenis-pill jenis-{{ $n->jenis }}">{{ ucfirst($n->jenis) }}</span></td>
                        <td>
                            @if($n->sudah_dibaca)
                                <span class="badge badge-dibaca"><span class="badge-dot"></span>Dibaca</span>
                                @if($n->dibaca_pada)
                                    <p style="font-size:11px;color:var(--text3);margin-top:2px">{{ $n->dibaca_pada->format('d M H:i') }}</p>
                                @endif
                            @else
                                <span class="badge badge-belum"><span class="badge-dot"></span>Belum Dibaca</span>
                            @endif
                        </td>
                        <td class="muted">{{ $n->created_at->diffForHumans() }}</td>
                        <td class="center">
                            <div class="action-group">
                                <form action="{{ route('admin.notifikasi.destroy', $n->id) }}" method="POST" id="delNotif-{{ $n->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delNotif-{{ $n->id }}'), '{{ addslashes($n->judul) }}')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8">
                        <div class="empty-state">
                            <div class="empty-icon"><svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div>
                            <p class="empty-title">Belum ada notifikasi</p>
                            <p class="empty-sub">Klik "Kirim Notifikasi" untuk mengirim pesan ke pengguna</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($notifikasis->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $notifikasis->firstItem() }}–{{ $notifikasis->lastItem() }} dari {{ $notifikasis->total() }} notifikasi</p>
            <div class="pag-btns">
                @if($notifikasis->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $notifikasis->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($notifikasis->getUrlRange(1, $notifikasis->lastPage()) as $page => $url)
                    @if($page == $notifikasis->currentPage()) <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $notifikasis->lastPage() || abs($page - $notifikasis->currentPage()) <= 1) <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $notifikasis->currentPage()) == 2) <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($notifikasis->hasMorePages())
                    <a href="{{ $notifikasis->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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

    function confirmDelete(form, judul) {
        Swal.fire({
            title:'Hapus Notifikasi?',
            html:`Notifikasi <strong>"${judul}"</strong> akan dihapus permanen.`,
            icon:'warning',showCancelButton:true,
            confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }

    function toggleAll(cb) {
        document.querySelectorAll('.cb-item').forEach(el => el.checked = cb.checked);
        updateBulkBtn();
    }

    function updateBulkBtn() {
        const checked = document.querySelectorAll('.cb-item:checked');
        document.getElementById('selCount').textContent = checked.length;
        document.getElementById('btnBulkDel').style.display = checked.length > 0 ? 'inline-flex' : 'none';
    }

    function hapusTerpilih() {
        const checked = document.querySelectorAll('.cb-item:checked');
        if (!checked.length) return;
        Swal.fire({
            title:`Hapus ${checked.length} Notifikasi?`,
            text:'Semua notifikasi terpilih akan dihapus secara permanen.',
            icon:'warning',showCancelButton:true,
            confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus Semua!',cancelButtonText:'Batal',
        }).then(r => {
            if (r.isConfirmed) {
                const form = document.getElementById('bulkForm');
                document.querySelectorAll('input[name="ids[]"]').forEach(el => el.remove());
                checked.forEach(el => {
                    const inp = document.createElement('input');
                    inp.type = 'hidden'; inp.name = 'ids[]'; inp.value = el.value;
                    form.appendChild(inp);
                });
                form.submit();
            }
        });
    }
</script>
</x-app-layout>