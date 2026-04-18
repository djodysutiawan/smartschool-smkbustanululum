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
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px;}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}
    .btn-edit:hover{background:var(--brand-100);filter:none;}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-detail:hover{background:#dcfce7;filter:none;}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-del:hover{background:#fee2e2;filter:none;}
    .btn-export-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-export-pdf:hover{background:#fee2e2;filter:none;}
    .btn-export-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-export-excel:hover{background:#dcfce7;filter:none;}
    .btn-import{background:#fefce8;color:#a16207;border:1px solid #fde68a;}
    .btn-import:hover{background:#fef9c3;filter:none;}
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}.stat-icon.green{background:#f0fdf4;}.stat-icon.orange{background:#fff7ed;}.stat-icon.purple{background:#fdf4ff;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .rapor-card{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;display:flex;align-items:center;gap:14px;flex-wrap:wrap;}
    .rapor-icon{width:42px;height:42px;background:var(--brand-600);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .rapor-text p:first-child{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:800;color:var(--brand-700);}
    .rapor-text p:last-child{font-size:12px;color:var(--brand-600);margin-top:2px;}
    .rapor-form{display:flex;gap:8px;align-items:center;margin-left:auto;flex-wrap:wrap;}
    .rapor-form select{height:36px;padding:0 12px;border:1px solid var(--brand-100);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:#fff;outline:none;}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center;}
    .filter-row input,.filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;}
    .filter-row input{width:200px;}.filter-row input:focus,.filter-row select:focus{border-color:var(--brand-500);background:#fff;}
    .filter-row input::placeholder{color:var(--text3);}
    .filter-sep{flex:1;}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;}
    .btn-filter:hover{background:var(--brand-700);}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;}
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
    .student-wrap .sname{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text);}
    .student-wrap .ssub{font-size:12px;color:var(--text3);margin-top:1px;}
    .nilai-num{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:14px;}
    .badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-a{background:#dcfce7;color:#15803d;}.badge-b{background:#dbeafe;color:#1d4ed8;}.badge-c{background:#fef9c3;color:#a16207;}.badge-d{background:#fee2e2;color:#dc2626;}.badge-e{background:#ffe4e6;color:#9f1239;}
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
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:999;align-items:center;justify-content:center;}
    .modal-overlay.open{display:flex;}
    .modal{background:#fff;border-radius:var(--radius);width:100%;max-width:420px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.2);}
    .modal-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
    .modal-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text);}
    .modal-close{background:none;border:none;cursor:pointer;color:var(--text3);padding:2px;}
    .modal-body{padding:20px;}
    .modal-footer{padding:14px 20px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;gap:8px;}
    .field{display:flex;flex-direction:column;gap:6px;margin-bottom:14px;}
    .field:last-child{margin-bottom:0;}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);}
    .field label .req{color:var(--brand-600);margin-left:2px;}
    .field input[type=file]{height:auto;padding:8px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;background:var(--surface2);width:100%;outline:none;}
    .field-hint{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;}
    @media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr;}.page{padding:16px;}.filter-row input{width:100%;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Nilai Siswa</h1>
            <p class="page-sub">Kelola data nilai — tugas, harian, UTS, UAS, dan rapor</p>
        </div>
        <a href="{{ route('admin.nilai.create') }}" class="btn btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Nilai
        </a>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            </div>
            <div><p class="stat-label">Total Nilai</p><p class="stat-val">{{ $nilai->total() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div><p class="stat-label">Predikat A</p><p class="stat-val">{{ \App\Models\Nilai::where('predikat','A')->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#ea580c" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div><p class="stat-label">Di Bawah KKM</p><p class="stat-val">{{ \App\Models\Nilai::whereIn('predikat',['D','E'])->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div><p class="stat-label">Siswa Dinilai</p><p class="stat-val">{{ \App\Models\Nilai::distinct('siswa_id')->count('siswa_id') }}</p></div>
        </div>
    </div>

    <div class="rapor-card">
        <div class="rapor-icon">
            <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        </div>
        <div class="rapor-text">
            <p>Cetak Rapor Kelas</p>
            <p>Lihat rekap nilai seluruh siswa per kelas dan tahun ajaran</p>
        </div>
        <form action="{{ route('admin.nilai.rapor-kelas') }}" method="GET" class="rapor-form">
            <select name="kelas_id" required>
                <option value="">Pilih Kelas</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
            <select name="tahun_ajaran_id" required>
                <option value="">Pilih Tahun Ajaran</option>
                @foreach($tahunAjaran as $ta)
                    <option value="{{ $ta->id }}">{{ $ta->tahun }} - {{ ucfirst($ta->semester) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary" style="padding:8px 16px;font-size:13px">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                Lihat Rapor
            </button>
        </form>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.nilai.index') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa...">
                <select name="tahun_ajaran_id">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach($tahunAjaran as $ta)
                        <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id')==$ta->id?'selected':'' }}>{{ $ta->tahun }} - {{ ucfirst($ta->semester) }}</option>
                    @endforeach
                </select>
                <select name="kelas_id">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id')==$k->id?'selected':'' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <select name="mata_pelajaran_id">
                    <option value="">Semua Mapel</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id }}" {{ request('mata_pelajaran_id')==$m->id?'selected':'' }}>{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>
                <select name="predikat">
                    <option value="">Semua Predikat</option>
                    @foreach($predikatList as $p)
                        <option value="{{ $p }}" {{ request('predikat')==$p?'selected':'' }}>{{ $p }}</option>
                    @endforeach
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.nilai.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Nilai
                @if($nilai->total())
                    <span>— menampilkan {{ $nilai->firstItem() }}–{{ $nilai->lastItem() }} dari {{ $nilai->total() }} data</span>
                @endif
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.nilai.export.pdf', request()->query()) }}" class="btn btn-sm btn-export-pdf" target="_blank">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    PDF
                </a>
                <a href="{{ route('admin.nilai.export.excel', request()->query()) }}" class="btn btn-sm btn-export-excel">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                    Excel
                </a>
                <a href="{{ route('admin.nilai.import.template') }}" class="btn btn-sm btn-import">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Template
                </a>
                <button type="button" class="btn btn-sm btn-import" onclick="document.getElementById('modalImport').classList.add('open')">
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
                        <th>Siswa</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th class="center">Tugas</th>
                        <th class="center">Harian</th>
                        <th class="center">UTS</th>
                        <th class="center">UAS</th>
                        <th class="center">Nilai Akhir</th>
                        <th class="center">Predikat</th>
                        <th class="center" style="width:170px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilai as $i => $n)
                    <tr>
                        <td><span class="no-col">{{ $nilai->firstItem() + $i }}</span></td>
                        <td>
                            <div class="student-wrap">
                                <p class="sname">{{ $n->siswa->nama_lengkap ?? '-' }}</p>
                                <p class="ssub">{{ $n->tahunAjaran->tahun ?? '' }}</p>
                            </div>
                        </td>
                        <td class="muted" style="font-size:12.5px">{{ $n->mataPelajaran->nama_mapel ?? '-' }}</td>
                        <td class="muted" style="font-size:12.5px">{{ $n->kelas->nama_kelas ?? '-' }}</td>
                        <td class="center muted" style="font-size:13px">{{ $n->nilai_tugas ?? '—' }}</td>
                        <td class="center muted" style="font-size:13px">{{ $n->nilai_harian ?? '—' }}</td>
                        <td class="center muted" style="font-size:13px">{{ $n->nilai_uts ?? '—' }}</td>
                        <td class="center muted" style="font-size:13px">{{ $n->nilai_uas ?? '—' }}</td>
                        <td class="center">
                            @if($n->nilai_akhir !== null)
                                <span class="nilai-num" style="color:{{ $n->predikat==='A'?'#15803d':($n->predikat==='B'?'#2563eb':($n->predikat==='C'?'#d97706':'#dc2626')) }}">
                                    {{ number_format($n->nilai_akhir, 1) }}
                                </span>
                            @else
                                <span style="color:var(--text3)">—</span>
                            @endif
                        </td>
                        <td class="center">
                            @if($n->predikat)
                                <span class="badge badge-{{ strtolower($n->predikat) }}">{{ $n->predikat }}</span>
                            @else
                                <span style="color:var(--text3);font-size:12.5px">—</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.nilai.show', $n->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('admin.nilai.edit', $n->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('admin.nilai.destroy', $n->id) }}" method="POST" id="delNilai-{{ $n->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delNilai-{{ $n->id }}'), '{{ addslashes($n->siswa->nama_lengkap ?? '') }}')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="11">
                        <div class="empty-state">
                            <div class="empty-icon"><svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></div>
                            <p class="empty-title">Tidak ada data nilai</p>
                            <p class="empty-sub">Coba ubah filter atau tambah nilai baru</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($nilai->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $nilai->firstItem() }} – {{ $nilai->lastItem() }} dari {{ $nilai->total() }} nilai</p>
            <div class="pag-btns">
                @if($nilai->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $nilai->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($nilai->getUrlRange(1, $nilai->lastPage()) as $page => $url)
                    @if($page == $nilai->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $nilai->lastPage() || abs($page - $nilai->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $nilai->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($nilai->hasMorePages())
                    <a href="{{ $nilai->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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
    <div class="modal">
        <div class="modal-header">
            <p class="modal-title">Import Data Nilai</p>
            <button class="modal-close" onclick="document.getElementById('modalImport').classList.remove('open')">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.nilai.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="field">
                    <label>File Excel <span class="req">*</span></label>
                    <input type="file" name="file" accept=".xlsx,.xls" required>
                    <span class="field-hint">Format: .xlsx atau .xls, maksimal 5MB. <a href="{{ route('admin.nilai.import.template') }}" style="color:var(--brand-600);font-weight:700">Unduh template</a></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" style="background:var(--surface2);color:var(--text2);border:1px solid var(--border)" onclick="document.getElementById('modalImport').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Import Sekarang
                </button>
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

    function confirmDelete(form, nama) {
        Swal.fire({
            title: 'Hapus Nilai?',
            text: `Nilai milik "${nama}" akan dihapus permanen.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }

    document.getElementById('modalImport').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });
</script>
</x-app-layout>