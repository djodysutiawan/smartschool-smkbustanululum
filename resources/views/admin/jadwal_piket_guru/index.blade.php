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
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}.btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}.btn-del:hover{background:#fee2e2;filter:none}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}.btn-detail:hover{background:#dcfce7;filter:none}
    .btn-export{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa}.btn-export:hover{background:#ffedd5;filter:none}
    .btn-import{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}.btn-import:hover{background:#dcfce7;filter:none}
    .btn-pdf{background:#fdf4ff;color:#7c3aed;border:1px solid #e9d5ff}.btn-pdf:hover{background:#f3e8ff;filter:none}
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.blue{background:var(--brand-50)}.stat-icon.green{background:#f0fdf4}
    .stat-icon.orange{background:#fff7ed}.stat-icon.teal{background:#f0fdfa}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .today-card{background:linear-gradient(135deg,var(--brand-600),#4f46e5);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;color:#fff}
    .today-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;opacity:.8;margin-bottom:10px}
    .today-list{display:flex;flex-wrap:wrap;gap:8px}
    .today-chip{background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);border-radius:8px;padding:6px 12px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none}
    .filter-row select:focus{border-color:var(--brand-500);background:#fff}
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
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%}
    .badge-aktif{background:#dcfce7;color:#15803d}.badge-aktif .badge-dot{background:#15803d}
    .badge-nonaktif{background:#fee2e2;color:#dc2626}.badge-nonaktif .badge-dot{background:#dc2626}
    .hari-pill{display:inline-block;padding:2px 9px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700}
    .hari-senin{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
    .hari-selasa{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .hari-rabu{background:#fefce8;color:#a16207;border:1px solid #fde68a}
    .hari-kamis{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa}
    .hari-jumat{background:#fdf4ff;color:#7c3aed;border:1px solid #e9d5ff}
    .hari-sabtu{background:#f0f9ff;color:#0369a1;border:1px solid #bae6fd}
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
            <h1 class="page-title">Jadwal Piket Guru</h1>
            <p class="page-sub">Kelola jadwal rotasi piket guru — tambah, edit, dan nonaktifkan</p>
        </div>
        <a href="{{ route('admin.jadwal-piket-guru.create') }}" class="btn btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Jadwal Piket
        </a>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Jadwal</p>
                <p class="stat-val">{{ $jadwal->total() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Aktif</p>
                <p class="stat-val">{{ $jadwal->where('is_active', true)->count() }}</p>
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
            <div class="stat-icon teal">
                <svg width="18" height="18" fill="none" stroke="#0d9488" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Piket Hari Ini</p>
                <p class="stat-val">{{ count($piketHariIni) }}</p>
            </div>
        </div>
    </div>

    @if(count($piketHariIni) > 0)
    <div class="today-card">
        <p class="today-title">🛡️ Guru Piket Hari Ini</p>
        <div class="today-list">
            @foreach($piketHariIni as $p)
            <div class="today-chip">
                {{ $p->guru->nama_lengkap ?? '-' }}
                <span style="opacity:.7;font-weight:400;margin-left:4px">{{ \Carbon\Carbon::parse($p->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($p->jam_selesai)->format('H:i') }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.jadwal-piket-guru.index') }}">
            <div class="filter-row">
                <select name="tahun_ajaran_id">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach($tahunAjaran as $ta)
                        <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>{{ $ta->tahun }}</option>
                    @endforeach
                </select>
                <select name="guru_id">
                    <option value="">Semua Guru Piket</option>
                    @foreach($guruPiket as $g)
                        <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                    @endforeach
                </select>
                <select name="hari">
                    <option value="">Semua Hari</option>
                    @foreach($hariList as $h)
                        <option value="{{ $h }}" {{ request('hari') == $h ? 'selected' : '' }}>{{ ucfirst($h) }}</option>
                    @endforeach
                </select>
                <select name="is_active">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.jadwal-piket-guru.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Jadwal Piket Guru
                <span>— menampilkan {{ $jadwal->firstItem() }}–{{ $jadwal->lastItem() }} dari {{ $jadwal->total() }} data</span>
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.jadwal-piket-guru.export-pdf') }}{{ request()->getQueryString() ? '?'.request()->getQueryString() : '' }}" class="btn btn-sm btn-pdf" target="_blank">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.jadwal-piket-guru.export-excel') }}{{ request()->getQueryString() ? '?'.request()->getQueryString() : '' }}" class="btn btn-sm btn-export">
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
                        <th>Hari</th>
                        <th>Jam Piket</th>
                        <th>Guru Piket</th>
                        <th>Tahun Ajaran</th>
                        <th>Catatan</th>
                        <th>Status</th>
                        <th class="center" style="width:190px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal as $index => $j)
                    <tr>
                        <td><span class="no-col">{{ $jadwal->firstItem() + $index }}</span></td>
                        <td><span class="hari-pill hari-{{ $j->hari }}">{{ ucfirst($j->hari) }}</span></td>
                        <td class="muted" style="font-size:12.5px;white-space:nowrap">
                            {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                        </td>
                        <td>
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px">{{ $j->guru->nama_lengkap ?? '-' }}</span>
                        </td>
                        <td class="muted" style="font-size:12.5px">{{ $j->tahunAjaran->tahun ?? '-' }}</td>
                        <td class="muted" style="font-size:12.5px;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                            {{ $j->catatan ?? '-' }}
                        </td>
                        <td>
                            @if($j->is_active)
                                <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                            @else
                                <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.jadwal-piket-guru.show', $j->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('admin.jadwal-piket-guru.edit', $j->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('admin.jadwal-piket-guru.destroy', $j->id) }}" method="POST" id="delPG-{{ $j->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delPG-{{ $j->id }}'), '{{ addslashes($j->guru->nama_lengkap ?? '') }}')">
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
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                </div>
                                <p class="empty-title">Jadwal piket tidak ditemukan</p>
                                <p class="empty-sub">Coba ubah filter atau tambah jadwal piket baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($jadwal->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $jadwal->firstItem() }} – {{ $jadwal->lastItem() }} dari {{ $jadwal->total() }} jadwal</p>
            <div class="pag-btns">
                @if($jadwal->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $jadwal->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($jadwal->getUrlRange(1, $jadwal->lastPage()) as $page => $url)
                    @if($page == $jadwal->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $jadwal->lastPage() || abs($page - $jadwal->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $jadwal->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($jadwal->hasMorePages())
                    <a href="{{ $jadwal->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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
        <p class="modal-title">Import Jadwal Piket</p>
        <p class="modal-sub">Upload file Excel (.xlsx/.xls) sesuai format template. <a href="{{ route('admin.jadwal-piket-guru.import-template') }}" style="color:var(--brand-600);font-weight:600">Download template</a></p>
        <form action="{{ route('admin.jadwal-piket-guru.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="field">
                <label>File Excel <span style="color:var(--brand-600)">*</span></label>
                <input type="file" name="file" accept=".xlsx,.xls" required style="height:auto;padding:8px 12px">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel-modal" onclick="document.getElementById('modalImport').classList.remove('show')">Batal</button>
                <button type="submit" class="btn btn-primary">Upload & Import</button>
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

    function confirmDelete(form, nama) {
        Swal.fire({
            title:'Hapus Jadwal Piket?',
            text:`Jadwal piket "${nama}" akan dihapus permanen.`,
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