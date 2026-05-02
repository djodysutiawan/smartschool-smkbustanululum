<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

:root {
    --brand-700: #1750c0; --brand-600: #1f63db; --brand-500: #3582f0;
    --brand-100: #d9ebff; --brand-50:  #eef6ff;
    --surface:   #fff;    --surface2:  #f8fafc;  --surface3:  #f1f5f9;
    --border:    #e2e8f0; --border2:   #cbd5e1;
    --text:      #0f172a; --text2:     #475569;   --text3:     #94a3b8;
    --radius:    10px;    --radius-sm: 7px;
}

.page { padding: 28px 28px 40px; }

.page-header {
    display: flex; align-items: flex-start;
    justify-content: space-between; gap: 16px;
    margin-bottom: 24px; flex-wrap: wrap;
}
.page-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2;
}
.page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
.header-actions { display: flex; gap: 8px; flex-wrap: wrap; }

.btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border-radius: var(--radius-sm);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 700;
    cursor: pointer; border: none; text-decoration: none;
    transition: filter .15s; white-space: nowrap;
}
.btn:hover { filter: brightness(.93); }
.btn-primary  { background: var(--brand-600); color: #fff; }
.btn-sm       { padding: 5px 11px; font-size: 12px; border-radius: 6px; }
.btn-edit     { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
.btn-edit:hover  { background: var(--brand-100); filter: none; }
.btn-del      { background: #fff0f0; color: #dc2626; border: 1px solid #fecaca; }
.btn-del:hover   { background: #fee2e2; filter: none; }
.btn-secondary{ background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
.btn-secondary:hover { background: var(--surface3); filter: none; }

/* Stats */
.stats-strip { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; margin-bottom: 20px; }
.stat-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 14px 18px;
    display: flex; align-items: center; gap: 12px;
}
.stat-icon {
    width: 38px; height: 38px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.stat-icon.blue   { background: var(--brand-50); }
.stat-icon.green  { background: #f0fdf4; }
.stat-icon.yellow { background: #fefce8; }
.stat-label {
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px;
    font-weight: 600; color: var(--text3); letter-spacing: .03em; text-transform: uppercase;
}
.stat-val {
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px;
    font-weight: 800; color: var(--text); line-height: 1.1; margin-top: 1px;
}

/* Table */
.table-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius); overflow: hidden;
}
.table-topbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 20px; border-bottom: 1px solid var(--border);
}
.table-info {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 700; color: var(--text);
}
.table-info span { font-weight: 400; color: var(--text3); margin-left: 6px; }
.table-wrap { overflow-x: auto; }

table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
thead tr { background: var(--surface2); border-bottom: 1px solid var(--border); }
thead th {
    padding: 11px 14px; text-align: left;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 11.5px; font-weight: 700; color: var(--text3);
    letter-spacing: .05em; text-transform: uppercase; white-space: nowrap;
}
thead th.center { text-align: center; }
tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .1s; }
tbody tr:last-child { border-bottom: none; }
tbody tr:hover { background: #fafbff; }
td { padding: 11px 14px; color: var(--text); vertical-align: middle; }
td.center { text-align: center; }
td.muted { color: var(--text3); font-size: 12.5px; }
.no-col { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text3); }

/* Color swatch */
.color-swatch {
    width: 24px; height: 24px; border-radius: 6px;
    border: 1px solid rgba(0,0,0,.08); display: inline-block; vertical-align: middle;
}

/* Nama */
.kat-name {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700; font-size: 13.5px; color: var(--text);
}
.kat-slug { font-size: 11.5px; color: var(--text3); margin-top: 2px; }

/* Badge */
.badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 10px; border-radius: 99px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 11.5px; font-weight: 700; white-space: nowrap;
    cursor: pointer; border: none;
}
.badge-dot { width: 5px; height: 5px; border-radius: 50%; }
.badge-aktif    { background: #dcfce7; color: #15803d; }
.badge-aktif    .badge-dot { background: #15803d; }
.badge-nonaktif { background: #f1f5f9; color: #64748b; }
.badge-nonaktif .badge-dot { background: #94a3b8; }

/* Berita count pill */
.count-pill {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 28px; height: 22px; padding: 0 8px;
    background: var(--brand-50); color: var(--brand-700);
    border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12px; font-weight: 800;
}

.action-group { display: flex; align-items: center; gap: 5px; justify-content: center; }

.empty-state { padding: 60px 20px; text-align: center; }
.empty-icon {
    width: 56px; height: 56px; background: var(--surface2);
    border-radius: 14px; display: flex; align-items: center;
    justify-content: center; margin: 0 auto 14px;
}
.empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 15px; color: var(--text); margin-bottom: 5px; }
.empty-sub { font-size: 13px; color: var(--text3); }

/* Pagination */
.pag-wrap {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 20px; border-top: 1px solid var(--border);
    flex-wrap: wrap; gap: 10px;
}
.pag-info { font-size: 12.5px; color: var(--text3); }
.pag-btns { display: flex; gap: 4px; align-items: center; }
.pag-btn {
    height: 32px; min-width: 32px; padding: 0 8px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    border: 1px solid var(--border); background: var(--surface);
    color: var(--text2); font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12.5px; font-weight: 700; cursor: pointer;
    transition: all .15s; text-decoration: none;
}
.pag-btn:hover  { background: var(--surface2); border-color: var(--border2); }
.pag-btn.active { background: var(--brand-600); border-color: var(--brand-600); color: #fff; }
.pag-ellipsis   { color: var(--text3); font-size: 13px; padding: 0 4px; }

@media (max-width: 640px) {
    .stats-strip { grid-template-columns: 1fr 1fr; }
    .page { padding: 16px; }
}
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Kategori Berita</h1>
            <p class="page-sub">Kelola kategori untuk pengelompokan berita — tambah, edit, dan atur urutan</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.berita-kategori.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Kategori
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Kategori</p>
                <p class="stat-val">{{ $kategori->total() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Aktif</p>
                <p class="stat-val">{{ \App\Models\BeritaKategori::where('is_published', true)->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
                <p class="stat-label">Nonaktif</p>
                <p class="stat-val">{{ \App\Models\BeritaKategori::where('is_published', false)->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Kategori
                <span>— menampilkan {{ $kategori->firstItem() }}–{{ $kategori->lastItem() }} dari {{ $kategori->total() }} data</span>
            </p>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th style="width:56px" class="center">Warna</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th class="center">Berita</th>
                        <th class="center">Urutan</th>
                        <th class="center">Status</th>
                        <th class="center" style="width:160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $index => $k)
                    <tr>
                        <td><span class="no-col">{{ $kategori->firstItem() + $index }}</span></td>

                        <td class="center">
                            @if($k->warna)
                                <span class="color-swatch" style="background: {{ $k->warna }};"></span>
                            @else
                                <span style="color:var(--text3);font-size:12px;">—</span>
                            @endif
                        </td>

                        <td>
                            <div>
                                <p class="kat-name">{{ $k->nama }}</p>
                                <p class="kat-slug">{{ $k->slug }}</p>
                            </div>
                        </td>

                        <td class="muted" style="max-width:220px;">
                            {{ $k->deskripsi ? Str::limit($k->deskripsi, 70) : '—' }}
                        </td>

                        <td class="center">
                            <span class="count-pill">{{ $k->berita_count }}</span>
                        </td>

                        <td class="center">
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text2);">{{ $k->urutan ?? '—' }}</span>
                        </td>

                        <td class="center">
                            <form action="{{ route('admin.berita-kategori.toggle', $k->id) }}" method="POST" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="badge {{ $k->is_published ? 'badge-aktif' : 'badge-nonaktif' }}" title="Klik untuk toggle status">
                                    <span class="badge-dot"></span>
                                    {{ $k->is_published ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>

                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.berita-kategori.edit', $k->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('admin.berita-kategori.destroy', $k->id) }}" method="POST" id="delForm-{{ $k->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delForm-{{ $k->id }}'), '{{ addslashes($k->nama) }}', {{ $k->berita_count }})">
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
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                                </div>
                                <p class="empty-title">Belum ada kategori</p>
                                <p class="empty-sub">Mulai dengan menambahkan kategori berita pertama</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($kategori->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $kategori->firstItem() }} – {{ $kategori->lastItem() }} dari {{ $kategori->total() }} kategori</p>
            <div class="pag-btns">
                @if($kategori->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $kategori->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                @foreach($kategori->getUrlRange(1, $kategori->lastPage()) as $page => $url)
                    @if($page == $kategori->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $kategori->lastPage() || abs($page - $kategori->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $kategori->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                @if($kategori->hasMorePages())
                    <a href="{{ $kategori->nextPageUrl() }}" class="pag-btn">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif

    function confirmDelete(form, nama, jumlahBerita) {
        if (jumlahBerita > 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak Bisa Dihapus',
                html: `Kategori <strong>"${nama}"</strong> masih memiliki <strong>${jumlahBerita} berita</strong>.<br>Pindahkan atau hapus berita terlebih dahulu.`,
                confirmButtonColor: '#1f63db',
                confirmButtonText: 'Mengerti',
            });
            return;
        }
        Swal.fire({
            title: 'Hapus Kategori?',
            html: `Kategori <strong>"${nama}"</strong> akan dihapus permanen.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>