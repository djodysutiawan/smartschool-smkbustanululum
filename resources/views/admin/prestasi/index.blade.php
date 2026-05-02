<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root{
    --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
    --brand-100:#d9ebff;--brand-50:#eef6ff;
    --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
    --border:#e2e8f0;--border2:#cbd5e1;
    --text:#0f172a;--text2:#475569;--text3:#94a3b8;
    --radius:10px;--radius-sm:7px;--danger:#dc2626;
}
.page{padding:28px 28px 40px}
.page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
.page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
.page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
.header-actions{display:flex;gap:8px;flex-wrap:wrap}

.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
.btn:hover{filter:brightness(.93)}
.btn-primary{background:var(--brand-600);color:#fff}
.btn-outline{background:var(--surface);color:var(--text2);border:1px solid var(--border)}
.btn-outline:hover{background:var(--surface2);filter:none}
.btn-sm{padding:6px 12px;font-size:12px;border-radius:6px}
.btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
.btn-edit:hover{background:var(--brand-100);filter:none}
.btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
.btn-del:hover{background:#fee2e2;filter:none}
.btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
.btn-detail:hover{background:#dcfce7;filter:none}
.btn-toggle-on{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
.btn-toggle-on:hover{background:#dcfce7;filter:none}
.btn-toggle-off{background:#fef9c3;color:#a16207;border:1px solid #fde68a}
.btn-toggle-off:hover{background:#fef08a;filter:none}
.btn-star-on{background:#fef9c3;color:#a16207;border:1px solid #fde68a}
.btn-star-on:hover{background:#fef08a;filter:none}
.btn-star-off{background:var(--surface2);color:var(--text3);border:1px solid var(--border)}
.btn-star-off:hover{background:var(--surface3);filter:none}

.stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
.stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px}
.stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.stat-icon.blue{background:var(--brand-50)}.stat-icon.green{background:#f0fdf4}.stat-icon.yellow{background:#fefce8}.stat-icon.purple{background:#faf5ff}
.stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase}
.stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}

.filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px}
.filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
.filter-row input,.filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
.filter-row input{width:200px}
.filter-row input:focus,.filter-row select:focus{border-color:var(--brand-500);background:#fff}
.filter-row input::placeholder{color:var(--text3)}
.filter-sep{flex:1}
.btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer}
.btn-filter:hover{background:var(--brand-700)}
.btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center}
.btn-reset:hover{background:var(--surface3)}
.filter-check-label{display:inline-flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);cursor:pointer}

.table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
.table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border)}
.table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
.table-info span{font-weight:400;color:var(--text3);margin-left:6px}
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

.prestasi-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
.prestasi-sub{font-size:12px;color:var(--text3);margin-top:2px}

.thumb-wrap{width:64px;height:44px;border-radius:7px;overflow:hidden;border:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:center;flex-shrink:0}
.thumb-wrap img{width:100%;height:100%;object-fit:cover}

.tingkat-pill{display:inline-block;padding:2px 9px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
.tingkat-sekolah{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
.tingkat-kecamatan{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
.tingkat-kabupaten{background:#faf5ff;color:#7c3aed;border:1px solid #e9d5ff}
.tingkat-provinsi{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa}
.tingkat-nasional{background:#fef9c3;color:#a16207;border:1px solid #fde68a}
.tingkat-internasional{background:#fdf2f8;color:#be185d;border:1px solid #fbcfe8}

.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
.badge-dot{width:5px;height:5px;border-radius:50%}
.badge-published{background:#dcfce7;color:#15803d}.badge-published .badge-dot{background:#15803d}
.badge-draft{background:#fee2e2;color:#dc2626}.badge-draft .badge-dot{background:#dc2626}

.star-icon{color:#f59e0b;font-size:14px}

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
@media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr}.page{padding:16px}.filter-row input{width:100%}}
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Prestasi</h1>
            <p class="page-sub">Kelola data prestasi siswa, guru, dan sekolah</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.prestasi.export.excel') }}" class="btn btn-outline">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export Excel
            </a>
            <a href="{{ route('admin.prestasi.export.pdf') }}" class="btn btn-outline">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export PDF
            </a>
            <a href="{{ route('admin.prestasi.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Prestasi
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
            </div>
            <div><p class="stat-label">Total</p><p class="stat-val">{{ $prestasi->total() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Dipublikasi</p><p class="stat-val">{{ $prestasi->getCollection()->where('is_published',true)->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div><p class="stat-label">Unggulan</p><p class="stat-val">{{ $prestasi->getCollection()->where('is_featured',true)->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-8 2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/></svg>
            </div>
            <div><p class="stat-label">Nasional+</p>
                <p class="stat-val">{{ $prestasi->getCollection()->whereIn('tingkat',['nasional','internasional'])->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.prestasi.index') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul prestasi...">

                <select name="tingkat">
                    <option value="">Semua Tingkat</option>
                    @foreach($tingkats as $t)
                        <option value="{{ $t }}" {{ request('tingkat') == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                    @endforeach
                </select>

                <select name="jurusan_id">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusan as $j)
                        <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                    @endforeach
                </select>

                <select name="tahun">
                    <option value="">Semua Tahun</option>
                    @for($y = date('Y'); $y >= 2015; $y--)
                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>

                <label class="filter-check-label">
                    <input type="checkbox" name="featured" value="1" {{ request('featured') ? 'checked' : '' }}
                        style="width:auto;height:auto;accent-color:var(--brand-600)">
                    Unggulan saja
                </label>

                <div class="filter-sep"></div>
                <a href="{{ route('admin.prestasi.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">Daftar Prestasi
                <span>— menampilkan {{ $prestasi->firstItem() }}–{{ $prestasi->lastItem() }} dari {{ $prestasi->total() }} data</span>
            </p>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th style="width:72px">Foto</th>
                        <th>Judul / Event</th>
                        <th>Tingkat</th>
                        <th>Penerima</th>
                        <th>Tahun</th>
                        <th class="center">Status</th>
                        <th class="center">Unggulan</th>
                        <th class="center" style="width:200px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestasi as $i => $p)
                    <tr>
                        <td><span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)">{{ $prestasi->firstItem() + $i }}</span></td>
                        <td>
                            <div class="thumb-wrap">
                                @if($p->foto_path)
                                    <img src="{{ asset('storage/'.$p->foto_path) }}" alt="{{ $p->judul }}">
                                @elseif($p->foto_url)
                                    <img src="{{ $p->foto_url }}" alt="{{ $p->judul }}">
                                @else
                                    <span style="font-size:20px">🏆</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <p class="prestasi-title">{{ $p->judul }}</p>
                            @if($p->nama_event)
                                <p class="prestasi-sub">{{ $p->nama_event }}</p>
                            @endif
                        </td>
                        <td><span class="tingkat-pill tingkat-{{ $p->tingkat }}">{{ ucfirst($p->tingkat) }}</span></td>
                        <td>
                            @if($p->nama_penerima)
                                <span style="font-size:13px;font-weight:600;color:var(--text)">{{ $p->nama_penerima }}</span>
                                @if($p->tipe_penerima)
                                    <br><span style="font-size:11px;color:var(--text3)">{{ ucfirst($p->tipe_penerima) }}</span>
                                @endif
                            @else
                                <span class="muted" style="font-size:12px">—</span>
                            @endif
                        </td>
                        <td class="muted" style="font-size:13px">{{ $p->tahun ?? ($p->tanggal ? \Carbon\Carbon::parse($p->tanggal)->format('Y') : '—') }}</td>
                        <td class="center">
                            @if($p->is_published)
                                <span class="badge badge-published"><span class="badge-dot"></span>Tayang</span>
                            @else
                                <span class="badge badge-draft"><span class="badge-dot"></span>Draft</span>
                            @endif
                        </td>
                        <td class="center">
                            <form action="{{ route('admin.prestasi.featured', $p->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $p->is_featured ? 'btn-star-on' : 'btn-star-off' }}" title="{{ $p->is_featured ? 'Hapus unggulan' : 'Jadikan unggulan' }}">
                                    @if($p->is_featured)
                                        <svg width="13" height="13" fill="#a16207" stroke="#a16207" stroke-width="1.5" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                        Unggulan
                                    @else
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                        Biasa
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.prestasi.show', $p->id) }}" class="btn btn-sm btn-detail">Detail</a>

                                <form action="{{ route('admin.prestasi.toggle', $p->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $p->is_published ? 'btn-toggle-on' : 'btn-toggle-off' }}">
                                        {{ $p->is_published ? 'Nonaktif' : 'Aktifkan' }}
                                    </button>
                                </form>

                                <a href="{{ route('admin.prestasi.edit', $p->id) }}" class="btn btn-sm btn-edit">Edit</a>

                                <form action="{{ route('admin.prestasi.destroy', $p->id) }}" method="POST" id="del-{{ $p->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('del-{{ $p->id }}'), '{{ addslashes($p->judul) }}')">
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
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                                </div>
                                <p class="empty-title">Belum ada data prestasi</p>
                                <p class="empty-sub">Klik "Tambah Prestasi" untuk menambahkan data baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($prestasi->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $prestasi->firstItem() }} – {{ $prestasi->lastItem() }} dari {{ $prestasi->total() }} prestasi</p>
            <div class="pag-btns">
                @if($prestasi->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $prestasi->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($prestasi->getUrlRange(1, $prestasi->lastPage()) as $page => $url)
                    @if($page == $prestasi->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $prestasi->lastPage() || abs($page - $prestasi->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $prestasi->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($prestasi->hasMorePages())
                    <a href="{{ $prestasi->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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

    function confirmDelete(form, judul) {
        Swal.fire({
            title:'Hapus Prestasi?',
            text:`Data "${judul}" akan dihapus permanen.`,
            icon:'warning',showCancelButton:true,
            confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal',
        }).then(r => { if(r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>