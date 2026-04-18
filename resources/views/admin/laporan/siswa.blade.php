<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;--brand-100:#d9ebff;--brand-50:#eef6ff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;}
    *{box-sizing:border-box;}
    .page{padding:28px 28px 40px;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-outline{background:var(--surface);color:var(--brand-600);border:1px solid var(--brand-100);}
    .btn-outline:hover{background:var(--brand-50);filter:none;}
    .btn-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-pdf:hover{background:#fee2e2;filter:none;}
    .btn-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-excel:hover{background:#dcfce7;filter:none;}
    .btn-sm{padding:5px 11px;font-size:11.5px;border-radius:6px;}
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}.stat-icon.green{background:#f0fdf4;}.stat-icon.purple{background:#fdf4ff;}.stat-icon.yellow{background:#fefce8;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center;}
    .filter-row input,.filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;}
    .filter-row input{width:220px;}
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
    .table-actions{display:flex;gap:7px;}
    .table-wrap{overflow-x:auto;}
    table{width:100%;border-collapse:collapse;font-size:13.5px;}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
    thead th.center{text-align:center;}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:#fafbff;}
    td{padding:10px 14px;color:var(--text);vertical-align:middle;}
    td.center{text-align:center;}
    td.muted{color:var(--text3);font-size:12.5px;}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);}
    .avatar-wrap{width:34px;height:34px;border-radius:8px;overflow:hidden;border:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .avatar-wrap img{width:100%;height:100%;object-fit:cover;}
    .avatar-initial{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--brand-600);}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-aktif{background:#dcfce7;color:#15803d;}.badge-aktif .badge-dot{background:#15803d;}
    .badge-tidak_aktif{background:#fee2e2;color:#dc2626;}.badge-tidak_aktif .badge-dot{background:#dc2626;}
    .badge-lulus{background:#dbeafe;color:#1d4ed8;}.badge-lulus .badge-dot{background:#1d4ed8;}
    .badge-pindah{background:#fef9c3;color:#a16207;}.badge-pindah .badge-dot{background:#a16207;}
    .badge-keluar{background:#f1f5f9;color:#64748b;}.badge-keluar .badge-dot{background:#64748b;}
    .jk-badge{display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:800;}
    .jk-l{background:#dbeafe;color:#1d4ed8;}.jk-p{background:#fce7f3;color:#be185d;}
    .poin-bar{display:flex;align-items:center;gap:8px;}
    .poin-track{flex:1;height:6px;background:var(--surface3);border-radius:99px;overflow:hidden;min-width:50px;}
    .poin-fill{height:100%;border-radius:99px;}
    .poin-fill.low{background:#22c55e;}.poin-fill.mid{background:#f97316;}.poin-fill.high{background:#ef4444;}
    .poin-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:800;min-width:24px;}
    .btn-sm-detail{padding:4px 10px;font-size:11.5px;border-radius:6px;background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;text-decoration:none;display:inline-flex;}
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
    @media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Siswa</h1>
            <p class="page-sub">Rekap data siswa beserta informasi kehadiran, nilai, dan pelanggaran</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Siswa
            </a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue"><svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
            <div><p class="stat-label">Total</p><p class="stat-val">{{ $siswa->total() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
            <div><p class="stat-label">Aktif</p><p class="stat-val">{{ $statsS['aktif'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple"><svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M3 20v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/></svg></div>
            <div><p class="stat-label">Laki-laki</p><p class="stat-val">{{ $statsS['laki'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow"><svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M3 20v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/></svg></div>
            <div><p class="stat-label">Perempuan</p><p class="stat-val">{{ $statsS['perempuan'] }}</p></div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.laporan.siswa') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIS, NISN...">
                <select name="kelas_id">
                    <option value="">Semua Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <select name="status">
                    <option value="">Semua Status</option>
                    @foreach(['aktif','tidak_aktif','lulus','pindah','keluar'] as $s)
                        <option value="{{ $s }}" {{ request('status')==$s ? 'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                    @endforeach
                </select>
                <select name="jenis_kelamin">
                    <option value="">Semua JK</option>
                    <option value="L" {{ request('jenis_kelamin')=='L' ? 'selected':'' }}>Laki-laki</option>
                    <option value="P" {{ request('jenis_kelamin')=='P' ? 'selected':'' }}>Perempuan</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.laporan.siswa') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Filter</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">Daftar Siswa <span>— {{ $siswa->total() }} data</span></p>
            <div class="table-actions">
                <a href="{{ route('admin.laporan.siswa.export.pdf', request()->query()) }}" class="btn btn-sm btn-pdf" target="_blank">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.laporan.siswa.export.excel', request()->query()) }}" class="btn btn-sm btn-excel">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                    Export Excel
                </a>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr>
                    <th style="width:48px">#</th>
                    <th style="width:44px">Foto</th>
                    <th>Nama / NIS</th>
                    <th class="center">JK</th>
                    <th>Kelas</th>
                    <th class="center">Kehadiran</th>
                    <th class="center">Poin Pelanggaran</th>
                    <th>Status</th>
                    <th class="center" style="width:90px">Aksi</th>
                </tr></thead>
                <tbody>
                    @forelse($siswa as $index => $s)
                    <tr>
                        <td><span class="no-col">{{ $siswa->firstItem() + $index }}</span></td>
                        <td>
                            <div class="avatar-wrap">
                                @if($s->foto)
                                    <img src="{{ asset('storage/'.$s->foto) }}" alt="{{ $s->nama_lengkap }}">
                                @else
                                    <span class="avatar-initial">{{ strtoupper(substr($s->nama_lengkap,0,1)) }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px">{{ $s->nama_lengkap }}</p>
                            <p style="font-size:11.5px;color:var(--text3)">NIS: {{ $s->nis }}</p>
                        </td>
                        <td class="center"><span class="jk-badge jk-{{ strtolower($s->jenis_kelamin) }}">{{ $s->jenis_kelamin }}</span></td>
                        <td style="font-size:13px;font-weight:600">{{ $s->kelas->nama_kelas ?? '-' }}</td>
                        <td class="center">
                            @php $persen = $s->persentase_kehadiran ?? 0; @endphp
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:13px;color:{{ $persen>=80 ? '#15803d' : ($persen>=60 ? '#c2410c' : '#dc2626') }}">{{ $persen }}%</span>
                        </td>
                        <td class="center">
                            @php $poin = $s->total_poin_pelanggaran ?? 0; @endphp
                            <div class="poin-bar">
                                <div class="poin-track"><div class="poin-fill {{ $poin>=50 ? 'high' : ($poin>=20 ? 'mid' : 'low') }}" style="width:{{ min($poin,100) }}%"></div></div>
                                <span class="poin-num" style="color:{{ $poin>=50 ? '#dc2626' : ($poin>=20 ? '#f97316' : '#22c55e') }}">{{ $poin }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-{{ $s->status }}">
                                <span class="badge-dot"></span>{{ ucfirst(str_replace('_',' ',$s->status)) }}
                            </span>
                        </td>
                        <td class="center">
                            <a href="{{ route('admin.siswa.show', $s->id) }}" class="btn-sm-detail">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9">
                        <div class="empty-state">
                            <div class="empty-icon"><svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                            <p class="empty-title">Tidak ada data siswa</p>
                            <p class="empty-sub">Coba ubah filter atau kata kunci pencarian</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($siswa->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $siswa->firstItem() }}–{{ $siswa->lastItem() }} dari {{ $siswa->total() }} siswa</p>
            <div class="pag-btns">
                @if($siswa->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $siswa->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($siswa->getUrlRange(1,$siswa->lastPage()) as $page => $url)
                    @if($page==$siswa->currentPage()) <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page==1||$page==$siswa->lastPage()||abs($page-$siswa->currentPage())<=1) <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page-$siswa->currentPage())==2) <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($siswa->hasMorePages())
                    <a href="{{ $siswa->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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
    @if(session('success'))Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });@endif
    @if(session('error'))Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });@endif
</script>
</x-app-layout>