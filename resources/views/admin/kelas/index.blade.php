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
    .page{padding:28px 28px 40px;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px;}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}
    .btn-edit:hover{background:var(--brand-100);filter:none;}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-del:hover{background:#fee2e2;filter:none;}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-detail:hover{background:#dcfce7;filter:none;}
    .btn-pdf{background:#fff5f5;color:#dc2626;border:1px solid #fecaca;}
    .btn-pdf:hover{background:#fee2e2;filter:none;}
    .btn-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-excel:hover{background:#dcfce7;filter:none;}
    .btn-import{background:#fefce8;color:#a16207;border:1px solid #fef08a;}
    .btn-import:hover{background:#fef9c3;filter:none;}
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
    .filter-row input,.filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;}
    .filter-row input{width:210px;}
    .filter-row input:focus,.filter-row select:focus{border-color:var(--brand-500);background:#fff;}
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
    .table-actions{display:flex;gap:8px;align-items:center;}
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
    td.muted{color:var(--text3);}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-aktif{background:#dcfce7;color:#15803d;}.badge-aktif .badge-dot{background:#15803d;}
    .badge-nonaktif{background:#f1f5f9;color:#64748b;}.badge-nonaktif .badge-dot{background:#94a3b8;}
    .kelas-wrap .kname{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text);}
    .kelas-wrap .kcode{font-size:12px;color:var(--text3);margin-top:1px;}
    .kapasitas-bar{width:80px;height:6px;background:var(--surface3);border-radius:99px;overflow:hidden;margin-top:4px;}
    .kapasitas-fill{height:100%;border-radius:99px;}
    .action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap;}
    .empty-state{padding:60px 20px;text-align:center;}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px;}
    .empty-sub{font-size:13px;color:var(--text3);}
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .pag-info{font-size:12.5px;color:var(--text3);}
    .pag-btns{display:flex;gap:4px;align-items:center;}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;text-decoration:none;}
    .pag-btn:hover{background:var(--surface2);}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff;}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none;}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;}
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:1000;align-items:center;justify-content:center;}
    .modal-overlay.open{display:flex;}
    .modal{background:#fff;border-radius:var(--radius);padding:28px;width:440px;max-width:90vw;}
    .modal-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:800;color:var(--text);margin-bottom:4px;}
    .modal-sub{font-size:13px;color:var(--text3);margin-bottom:20px;}
    .modal-field{display:flex;flex-direction:column;gap:6px;margin-bottom:16px;}
    .modal-field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);}
    .modal-field input[type=file]{padding:8px 12px;border:1.5px dashed var(--border2);border-radius:var(--radius-sm);font-size:13px;background:var(--surface2);cursor:pointer;width:100%;}
    .modal-field input[type=file]:focus{outline:none;border-color:var(--brand-500);}
    .modal-hint{font-size:12px;color:var(--text3);}
    .modal-footer{display:flex;gap:8px;justify-content:flex-end;margin-top:20px;}
    @media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr;}.page{padding:16px;}.filter-row input{width:100%;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Data Kelas</h1>
            <p class="page-sub">Kelola rombongan belajar — tambah, edit, dan hapus data kelas</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Kelas
            </a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <div><p class="stat-label">Total Kelas</p><p class="stat-val">{{ $kelas->total() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Aktif</p><p class="stat-val">{{ $kelas->getCollection()->where('status','aktif')->count() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div><p class="stat-label">Total Siswa</p><p class="stat-val">{{ $kelas->getCollection()->sum('siswa_count') }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div><p class="stat-label">Tahun Ajaran</p><p class="stat-val">{{ $tahunAjarans->count() }}</p></div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.kelas.index') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau kode kelas...">
                <select name="tahun_ajaran_id">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach($tahunAjarans as $ta)
                    <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>{{ $ta->tahun }}</option>
                    @endforeach
                </select>
                <select name="tingkat">
                    <option value="">Semua Tingkat</option>
                    @foreach(['X','XI','XII'] as $t)
                    <option value="{{ $t }}" {{ request('tingkat') == $t ? 'selected' : '' }}>Tingkat {{ $t }}</option>
                    @endforeach
                </select>
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.kelas.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">Daftar Kelas
                @if($kelas->total())
                <span>— menampilkan {{ $kelas->firstItem() }}–{{ $kelas->lastItem() }} dari {{ $kelas->total() }} data</span>
                @endif
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.kelas.export.pdf', request()->query()) }}" class="btn btn-sm btn-pdf">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    PDF
                </a>
                <a href="{{ route('admin.kelas.export.excel', request()->query()) }}" class="btn btn-sm btn-excel">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="16" y2="17"/></svg>
                    Excel
                </a>
                <button type="button" class="btn btn-sm btn-import" onclick="document.getElementById('modalImport').classList.add('open')">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                    Import
                </button>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Nama / Kode Kelas</th>
                        <th>Tingkat</th>
                        <th>Tahun Ajaran</th>
                        <th>Wali Kelas</th>
                        <th>Ruang</th>
                        <th>Siswa / Kapasitas</th>
                        <th>Status</th>
                        <th class="center" style="width:180px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $index => $k)
                    <tr>
                        <td><span class="no-col">{{ $kelas->firstItem() + $index }}</span></td>
                        <td>
                            <div class="kelas-wrap">
                                <p class="kname">{{ $k->nama_kelas }}</p>
                                <p class="kcode">{{ $k->kode_kelas }}</p>
                            </div>
                        </td>
                        <td>
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);">{{ $k->tingkat }}</span>
                            @if($k->jurusan)
                            <br><span style="font-size:11.5px;color:var(--text3);">{{ $k->jurusan }}</span>
                            @endif
                        </td>
                        <td class="muted" style="font-size:12.5px;">{{ $k->tahunAjaran->tahun ?? '—' }}</td>
                        <td style="font-size:13px;">{{ $k->waliKelas->nama_lengkap ?? '—' }}</td>
                        <td class="muted" style="font-size:12.5px;">
                            @if($k->ruang)
                                {{ $k->ruang->nama_ruang }}<br>
                                <span style="font-size:11px;">{{ $k->ruang->gedung->nama_gedung ?? '' }}</span>
                            @else —
                            @endif
                        </td>
                        <td>
                            @php
                                $pct = $k->kapasitas_maks > 0 ? min(100, round($k->siswa_count / $k->kapasitas_maks * 100)) : 0;
                                $color = $pct >= 100 ? '#dc2626' : ($pct >= 80 ? '#f97316' : '#22c55e');
                            @endphp
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;">{{ $k->siswa_count }}/{{ $k->kapasitas_maks }}</span>
                            <div class="kapasitas-bar"><div class="kapasitas-fill" style="width:{{ $pct }}%;background:{{ $color }};"></div></div>
                        </td>
                        <td>
                            @if($k->status === 'aktif')
                                <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                            @else
                                <span class="badge badge-nonaktif"><span class="badge-dot"></span>Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.kelas.show', $k->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('admin.kelas.edit', $k->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" id="delForm-{{ $k->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delForm-{{ $k->id }}'), '{{ addslashes($k->nama_kelas) }}')">
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
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                                </div>
                                <p class="empty-title">Belum ada data kelas</p>
                                <p class="empty-sub">Klik "Tambah Kelas" untuk menambahkan data pertama</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kelas->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $kelas->firstItem() }} – {{ $kelas->lastItem() }} dari {{ $kelas->total() }} kelas</p>
            <div class="pag-btns">
                <a href="{{ $kelas->previousPageUrl() ?? '#' }}" class="pag-btn {{ $kelas->onFirstPage() ? 'disabled' : '' }}">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                </a>
                @foreach($kelas->getUrlRange(1, $kelas->lastPage()) as $page => $url)
                    @if($page == $kelas->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $kelas->lastPage() || abs($page - $kelas->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $kelas->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                <a href="{{ $kelas->nextPageUrl() ?? '#' }}" class="pag-btn {{ !$kelas->hasMorePages() ? 'disabled' : '' }}">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="modal-overlay" id="modalImport">
    <div class="modal">
        <p class="modal-title">Import Data Kelas</p>
        <p class="modal-sub">Upload file Excel (.xlsx, .xls) atau CSV untuk mengimpor data kelas secara massal.</p>
        <form action="{{ route('admin.kelas.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-field">
                <label>File Import <span style="color:#1f63db">*</span></label>
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required>
                <span class="modal-hint">Format: .xlsx, .xls, atau .csv. Maksimal 2 MB.</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" style="background:var(--surface2);color:var(--text2);border:1px solid var(--border);"
                    onclick="document.getElementById('modalImport').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Proses Import
                </button>
            </div>
        </form>
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

    document.getElementById('modalImport').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });

    function confirmDelete(form, nama) {
        Swal.fire({
            title: 'Hapus Kelas?',
            text: `Kelas "${nama}" akan dihapus. Pastikan tidak ada siswa di dalamnya.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>