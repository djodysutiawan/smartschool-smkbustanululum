<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root{
    --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
    --brand-100:#d9ebff;--brand-50:#eef6ff;
    --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
    --border:#e2e8f0;--border2:#cbd5e1;
    --text:#0f172a;--text2:#475569;--text3:#94a3b8;
    --radius:10px;--radius-sm:7px;
}
.page{padding:28px 28px 40px;}
.page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
.page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
.page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
.header-actions{display:flex;gap:8px;flex-wrap:wrap;}
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
.btn:hover{filter:brightness(.93);}
.btn-primary{background:var(--brand-600);color:#fff;}
.btn-ghost{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
.btn-ghost:hover{background:var(--surface3);filter:none;}
.btn-sm{padding:6px 12px;font-size:12px;border-radius:6px;}
.btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
.btn-detail:hover{background:#dcfce7;filter:none;}
.btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
.btn-del:hover{background:#fee2e2;filter:none;}
.btn-read{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}
.btn-read:hover{background:var(--brand-100);filter:none;}

.stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
.stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
.stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.stat-icon.blue{background:var(--brand-50);}
.stat-icon.green{background:#f0fdf4;}
.stat-icon.yellow{background:#fefce8;}
.stat-icon.purple{background:#fdf4ff;}
.stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
.stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}

.filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;margin-bottom:16px;}
.filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center;}
.filter-row input,.filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;}
.filter-row input{width:240px;}
.filter-row input:focus,.filter-row select:focus{border-color:var(--brand-500);background:#fff;}
.filter-row input::placeholder{color:var(--text3);}
.filter-sep{flex:1;}
.btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;}
.btn-filter:hover{background:var(--brand-700);}
.btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;}
.btn-reset:hover{background:var(--surface3);}

.table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
.table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:8px;}
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
tbody tr.is-baru{background:#fffbeb;}
tbody tr.is-baru:hover{background:#fef3c7;}
td{padding:10px 14px;color:var(--text);vertical-align:middle;}
td.center{text-align:center;}
td.muted{color:var(--text3);}

.sender-wrap .sname{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text);}
.sender-wrap .semail{font-size:12px;color:var(--text3);margin-top:1px;}
.subject-text{font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px;color:var(--text);}
.subject-preview{font-size:12px;color:var(--text3);margin-top:2px;max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}

.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
.badge-dot{width:5px;height:5px;border-radius:50%;}
.badge-baru{background:#fef3c7;color:#d97706;}
.badge-baru .badge-dot{background:#d97706;}
.badge-dibaca{background:#dcfce7;color:#15803d;}
.badge-dibaca .badge-dot{background:#15803d;}
.badge-dibalas{background:var(--brand-50);color:var(--brand-700);}
.badge-dibalas .badge-dot{background:var(--brand-600);}
.badge-arsip{background:var(--surface3);color:var(--text3);}
.badge-arsip .badge-dot{background:var(--text3);}

.unread-dot{width:8px;height:8px;background:#d97706;border-radius:50%;display:inline-block;flex-shrink:0;}

.action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap;}
.bulk-bar{display:none;align-items:center;gap:10px;padding:10px 20px;background:#fffbeb;border-bottom:1px solid #fde68a;}
.bulk-bar.show{display:flex;}
.bulk-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text2);}

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
@media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr;}.page{padding:16px;}.filter-row input{width:100%;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Pesan Masuk</h1>
            <p class="page-sub">Kelola pesan kontak dari pengunjung website</p>
        </div>
        <div class="header-actions">
            @if($totalBaru > 0)
            <form action="{{ route('admin.kontak-pesan.mark-all-read') }}" method="POST" style="display:contents">
                @csrf
                <button type="submit" class="btn btn-ghost">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Tandai Semua Dibaca
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Pesan</p>
                <p class="stat-val">{{ $pesan->total() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
                <p class="stat-label">Belum Dibaca</p>
                <p class="stat-val">{{ $totalBaru }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Sudah Dibalas</p>
                <p class="stat-val">{{ \App\Models\KontakPesan::where('status','dibalas')->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M5 8h14M5 8a2 2 0 1 0 0-4h14a2 2 0 1 0 0 4M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8"/></svg>
            </div>
            <div>
                <p class="stat-label">Diarsipkan</p>
                <p class="stat-val">{{ \App\Models\KontakPesan::where('status','arsip')->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.kontak-pesan.index') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, subjek...">
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="baru"     {{ request('status') === 'baru'     ? 'selected' : '' }}>Baru</option>
                    <option value="dibaca"   {{ request('status') === 'dibaca'   ? 'selected' : '' }}>Dibaca</option>
                    <option value="dibalas"  {{ request('status') === 'dibalas'  ? 'selected' : '' }}>Dibalas</option>
                    <option value="arsip"    {{ request('status') === 'arsip'    ? 'selected' : '' }}>Arsip</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.kontak-pesan.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Pesan Masuk
                @if($pesan->total() > 0)
                <span>— menampilkan {{ $pesan->firstItem() }}–{{ $pesan->lastItem() }} dari {{ $pesan->total() }} pesan</span>
                @endif
            </p>
            {{-- Bulk delete trigger --}}
            <button type="button" class="btn btn-sm btn-del" id="btnBulkDelete" style="display:none"
                onclick="confirmBulkDelete()">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                Hapus Terpilih (<span id="selectedCount">0</span>)
            </button>
        </div>

        {{-- Bulk delete form (di luar tabel) --}}
        <form method="POST" action="{{ route('admin.kontak-pesan.bulk-delete') }}" id="bulkForm">
            @csrf
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width:40px">
                                <input type="checkbox" id="checkAll" onchange="toggleAll(this)"
                                    style="width:15px;height:15px;cursor:pointer;accent-color:var(--brand-600)">
                            </th>
                            <th>Pengirim</th>
                            <th>Subjek / Pesan</th>
                            <th>Telepon</th>
                            <th class="center">Status</th>
                            <th class="center">Waktu</th>
                            <th class="center" style="width:180px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesan as $p)
                        <tr class="{{ $p->status === 'baru' ? 'is-baru' : '' }}">
                            <td>
                                <input type="checkbox" name="ids[]" value="{{ $p->id }}" class="row-check"
                                    onchange="updateBulkBar()"
                                    style="width:15px;height:15px;cursor:pointer;accent-color:var(--brand-600)">
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:8px;">
                                    @if($p->status === 'baru')
                                        <span class="unread-dot"></span>
                                    @endif
                                    <div class="sender-wrap">
                                        <p class="sname">{{ $p->nama_pengirim }}</p>
                                        <p class="semail">{{ $p->email_pengirim }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="subject-text">{{ $p->subjek ?? '(Tanpa Subjek)' }}</p>
                                <p class="subject-preview">{{ $p->pesan }}</p>
                            </td>
                            <td class="muted" style="font-size:12.5px">{{ $p->no_telepon ?? '-' }}</td>
                            <td class="center">
                                @php
                                    $badgeMap = [
                                        'baru'    => 'badge-baru',
                                        'dibaca'  => 'badge-dibaca',
                                        'dibalas' => 'badge-dibalas',
                                        'arsip'   => 'badge-arsip',
                                    ];
                                    $labelMap = [
                                        'baru'    => 'Baru',
                                        'dibaca'  => 'Dibaca',
                                        'dibalas' => 'Dibalas',
                                        'arsip'   => 'Arsip',
                                    ];
                                @endphp
                                <span class="badge {{ $badgeMap[$p->status] ?? 'badge-dibaca' }}">
                                    <span class="badge-dot"></span>{{ $labelMap[$p->status] ?? $p->status }}
                                </span>
                            </td>
                            <td class="center muted" style="font-size:12px;white-space:nowrap">
                                {{ $p->created_at->diffForHumans() }}
                            </td>
                            <td class="center">
                                <div class="action-group">
                                    <a href="{{ route('admin.kontak-pesan.show', $p->id) }}" class="btn btn-sm btn-detail">Baca</a>

                                    <form action="{{ route('admin.kontak-pesan.destroy', $p->id) }}" method="POST"
                                          id="del-{{ $p->id }}" style="display:contents">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-del"
                                            onclick="confirmDelete({{ $p->id }}, '{{ addslashes($p->nama_pengirim) }}')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                    </div>
                                    <p class="empty-title">Tidak ada pesan</p>
                                    <p class="empty-sub">Belum ada pesan masuk atau tidak sesuai filter</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        {{-- Pagination --}}
        @if($pesan->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $pesan->firstItem() }} – {{ $pesan->lastItem() }} dari {{ $pesan->total() }} pesan</p>
            <div class="pag-btns">
                @if($pesan->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $pesan->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($pesan->getUrlRange(1,$pesan->lastPage()) as $page => $url)
                    @if($page == $pesan->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $pesan->lastPage() || abs($page - $pesan->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $pesan->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($pesan->hasMorePages())
                    <a href="{{ $pesan->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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

function toggleAll(cb) {
    document.querySelectorAll('.row-check').forEach(c => c.checked = cb.checked);
    updateBulkBar();
}

function updateBulkBar() {
    const checked = document.querySelectorAll('.row-check:checked').length;
    const btn = document.getElementById('btnBulkDelete');
    document.getElementById('selectedCount').textContent = checked;
    btn.style.display = checked > 0 ? 'inline-flex' : 'none';
    document.getElementById('checkAll').checked =
        checked === document.querySelectorAll('.row-check').length && checked > 0;
}

function confirmDelete(id, nama) {
    Swal.fire({
        title: 'Hapus Pesan?',
        text: `Pesan dari "${nama}" akan dihapus permanen.`,
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) document.getElementById('del-' + id).submit(); });
}

function confirmBulkDelete() {
    const count = document.querySelectorAll('.row-check:checked').length;
    Swal.fire({
        title: `Hapus ${count} Pesan?`,
        text: 'Pesan yang dipilih akan dihapus permanen.',
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) document.getElementById('bulkForm').submit(); });
}
</script>
</x-app-layout>