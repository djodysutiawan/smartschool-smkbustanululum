<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700: #1750c0; --brand-600: #1f63db; --brand-500: #3582f0;
        --brand-100: #d9ebff; --brand-50:  #eef6ff;
        --surface: #fff; --surface2: #f8fafc; --surface3: #f1f5f9;
        --border: #e2e8f0; --border2: #cbd5e1;
        --text: #0f172a; --text2: #475569; --text3: #94a3b8;
        --radius: 10px; --radius-sm: 7px;
    }
    .page { padding: 28px 28px 40px; }
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2; }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .header-actions { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s; white-space: nowrap; }
    .btn:hover { filter: brightness(.93); }
    .btn-primary { background: var(--brand-600); color: #fff; }
    .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 6px; }
    .btn-edit   { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover { background: var(--brand-100); filter: none; }
    .btn-del    { background: #fff0f0; color: #dc2626; border: 1px solid #fecaca; }
    .btn-del:hover { background: #fee2e2; filter: none; }
    .btn-detail { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .btn-detail:hover { background: #dcfce7; filter: none; }
    .btn-restore { background: #fefce8; color: #a16207; border: 1px solid #fde68a; }
    .btn-restore:hover { background: #fef9c3; filter: none; }
    .btn-pdf    { background: #fff5f5; color: #dc2626; border: 1px solid #fecaca; }
    .btn-pdf:hover { background: #fee2e2; filter: none; }
    .btn-excel  { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .btn-excel:hover { background: #dcfce7; filter: none; }
    .btn-import { background: #fefce8; color: #a16207; border: 1px solid #fde68a; }
    .btn-import:hover { background: #fef9c3; filter: none; }

    .stats-strip { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px 18px; display: flex; align-items: center; gap: 12px; }
    .stat-icon { width: 38px; height: 38px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .stat-icon.blue   { background: var(--brand-50); } .stat-icon.green  { background: #f0fdf4; }
    .stat-icon.purple { background: #fdf4ff; }        .stat-icon.pink   { background: #fff1f2; }
    .stat-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 600; color: var(--text3); letter-spacing: .03em; text-transform: uppercase; }
    .stat-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: var(--text); line-height: 1.1; margin-top: 1px; }

    .filter-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 16px 20px; margin-bottom: 16px; }
    .filter-row { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
    .filter-row input, .filter-row select { height: 36px; padding: 0 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text); background: var(--surface2); outline: none; transition: border-color .15s; }
    .filter-row input { width: 210px; }
    .filter-row input:focus, .filter-row select:focus { border-color: var(--brand-500); background: #fff; }
    .filter-row input::placeholder { color: var(--text3); }
    .filter-sep { flex: 1; }
    .btn-filter { height: 36px; padding: 0 18px; background: var(--brand-600); color: #fff; border: none; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; }
    .btn-filter:hover { background: var(--brand-700); }
    .btn-reset { height: 36px; padding: 0 14px; background: var(--surface2); color: var(--text2); border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; }
    .btn-reset:hover { background: var(--surface3); }

    .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .table-topbar { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--border); gap: 8px; flex-wrap: wrap; }
    .table-info { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .table-info span { font-weight: 400; color: var(--text3); margin-left: 6px; }
    .table-actions { display: flex; gap: 6px; flex-wrap: wrap; }
    .table-wrap { overflow-x: auto; }

    table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    thead tr { background: var(--surface2); border-bottom: 1px solid var(--border); }
    thead th { padding: 11px 14px; text-align: left; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); letter-spacing: .05em; text-transform: uppercase; white-space: nowrap; }
    thead th.center { text-align: center; }
    tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .1s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fafbff; }
    tbody tr.is-trashed { opacity: .65; background: #fffbf0; }
    td { padding: 10px 14px; color: var(--text); vertical-align: middle; }
    td.center { text-align: center; }
    td.muted { color: var(--text3); }

    .no-col { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text3); }
    .avatar-wrap { width: 36px; height: 36px; border-radius: 8px; overflow: hidden; border: 1px solid var(--border); background: var(--surface2); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .avatar-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-initial { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 800; color: var(--brand-600); }
    .student-wrap .sname { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 13.5px; color: var(--text); }
    .student-wrap .snis  { font-size: 12px; color: var(--text3); margin-top: 1px; }

    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; white-space: nowrap; }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-aktif    { background: #dcfce7; color: #15803d; } .badge-aktif .badge-dot    { background: #15803d; }
    .badge-nonaktif { background: #fee2e2; color: #dc2626; } .badge-nonaktif .badge-dot { background: #dc2626; }
    .badge-lulus    { background: #e0e7ff; color: #3730a3; } .badge-lulus .badge-dot    { background: #3730a3; }
    .badge-pindah   { background: #fef9c3; color: #a16207; } .badge-pindah .badge-dot   { background: #a16207; }
    .badge-keluar   { background: #fee2e2; color: #dc2626; } .badge-keluar .badge-dot   { background: #dc2626; }
    .badge-terhapus { background: #fef9c3; color: #a16207; } .badge-terhapus .badge-dot { background: #a16207; }
    .jk-pill { display: inline-block; padding: 2px 9px; border-radius: 5px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; }
    .jk-l { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .jk-p { background: #fdf2f8; color: #9d174d; border: 1px solid #fbcfe8; }

    .action-group { display: flex; align-items: center; gap: 5px; justify-content: center; flex-wrap: wrap; }
    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-icon { width: 56px; height: 56px; background: var(--surface2); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
    .empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 15px; color: var(--text); margin-bottom: 5px; }
    .empty-sub { font-size: 13px; color: var(--text3); }

    .pag-wrap { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-top: 1px solid var(--border); flex-wrap: wrap; gap: 10px; }
    .pag-info { font-size: 12.5px; color: var(--text3); }
    .pag-btns { display: flex; gap: 4px; align-items: center; }
    .pag-btn { height: 32px; min-width: 32px; padding: 0 8px; border-radius: 7px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border); background: var(--surface); color: var(--text2); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; cursor: pointer; transition: all .15s; text-decoration: none; }
    .pag-btn:hover { background: var(--surface2); border-color: var(--border2); }
    .pag-btn.active { background: var(--brand-600); border-color: var(--brand-600); color: #fff; }
    .pag-ellipsis { color: var(--text3); font-size: 13px; padding: 0 4px; }

    /* Modal */
    .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 1000; display: flex; align-items: center; justify-content: center; opacity: 0; pointer-events: none; transition: opacity .2s; }
    .modal-overlay.open { opacity: 1; pointer-events: all; }
    .modal { background: #fff; border-radius: 12px; width: 100%; max-width: 440px; padding: 28px; box-shadow: 0 20px 60px rgba(0,0,0,.2); transform: translateY(12px); transition: transform .2s; }
    .modal-overlay.open .modal { transform: translateY(0); }
    .modal-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-weight: 800; color: var(--text); margin-bottom: 4px; }
    .modal-sub { font-size: 12.5px; color: var(--text3); margin-bottom: 20px; }
    .modal-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2); margin-bottom: 6px; display: block; }
    .modal-file-hint { font-size: 11.5px; color: var(--text3); margin-top: 5px; }
    .modal-footer { display: flex; gap: 8px; justify-content: flex-end; margin-top: 20px; }
    .modal-cancel { padding: 8px 16px; background: var(--surface2); color: var(--text2); border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; }
    .modal-submit { padding: 8px 18px; background: var(--brand-600); color: #fff; border: none; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; }
    .template-link { font-size: 12px; color: var(--brand-600); text-decoration: underline; margin-top: 8px; display: inline-block; }

    @media (max-width: 640px) {
        .stats-strip { grid-template-columns: 1fr 1fr; }
        .page { padding: 16px; }
        .filter-row input { width: 100%; }
    }
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Data Siswa</h1>
            <p class="page-sub">Kelola data siswa — tambah, edit, pindah kelas, export, dan import</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Siswa
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue"><svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
            <div><p class="stat-label">Total</p><p class="stat-val">{{ $stats['total'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
            <div><p class="stat-label">Aktif</p><p class="stat-val">{{ $stats['aktif'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple"><svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M6 20v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/></svg></div>
            <div><p class="stat-label">Laki-laki</p><p class="stat-val">{{ $stats['laki'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pink"><svg width="18" height="18" fill="none" stroke="#be185d" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M6 20v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/></svg></div>
            <div><p class="stat-label">Perempuan</p><p class="stat-val">{{ $stats['perempuan'] }}</p></div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.siswa.index') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIS, NISN...">
                <select name="kelas_id">
                    <option value="">Semua Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <select name="tahun_ajaran_id">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach($tahunAjarans as $ta)
                        <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>{{ $ta->tahun }} - {{ ucfirst($ta->semester) }}</option>
                    @endforeach
                </select>
                <select name="status">
                    <option value="">Semua Status</option>
                    @foreach(['aktif','tidak_aktif','lulus','pindah','keluar'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                    @endforeach
                </select>
                <select name="jenis_kelamin">
                    <option value="">Semua JK</option>
                    <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('admin.siswa.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Siswa
                <span>— {{ $siswa->firstItem() }}–{{ $siswa->lastItem() }} dari {{ $siswa->total() }} data</span>
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.siswa.export.pdf', request()->query()) }}" class="btn btn-sm btn-pdf" target="_blank">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    PDF
                </a>
                <a href="{{ route('admin.siswa.export.excel', request()->query()) }}" class="btn btn-sm btn-excel">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Excel
                </a>
                <button type="button" class="btn btn-sm btn-import" onclick="openModal('importModal')">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                    Import
                </button>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th style="width:52px">Foto</th>
                        <th>Nama / NIS</th>
                        <th>Kelas</th>
                        <th class="center">JK</th>
                        <th>No. HP</th>
                        <th>Status</th>
                        <th class="center" style="width:210px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $s)
                    <tr class="{{ $s->trashed() ? 'is-trashed' : '' }}">
                        <td><span class="no-col">{{ $siswa->firstItem() + $index }}</span></td>
                        <td>
                            <div class="avatar-wrap">
                                @if($s->foto)
                                    <img src="{{ asset('storage/'.$s->foto) }}" alt="{{ $s->nama_lengkap }}">
                                @else
                                    <span class="avatar-initial">{{ strtoupper(substr($s->nama_lengkap, 0, 1)) }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="student-wrap">
                                <p class="sname">{{ $s->nama_lengkap }}</p>
                                <p class="snis">NIS: {{ $s->nis }}{{ $s->nisn ? ' · NISN: '.$s->nisn : '' }}</p>
                            </div>
                        </td>
                        <td class="muted" style="font-size:12.5px">{{ $s->kelas->nama_kelas ?? '-' }}</td>
                        <td class="center">
                            <span class="jk-pill jk-{{ strtolower($s->jenis_kelamin) }}">{{ $s->jenis_kelamin }}</span>
                        </td>
                        <td class="muted" style="font-size:12.5px">{{ $s->no_hp ?? '-' }}</td>
                        <td>
                            @if($s->trashed())
                                <span class="badge badge-terhapus"><span class="badge-dot"></span>Terhapus</span>
                            @elseif($s->status == 'aktif')
                                <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                            @elseif($s->status == 'lulus')
                                <span class="badge badge-lulus"><span class="badge-dot"></span>Lulus</span>
                            @elseif($s->status == 'pindah')
                                <span class="badge badge-pindah"><span class="badge-dot"></span>Pindah</span>
                            @elseif($s->status == 'keluar')
                                <span class="badge badge-keluar"><span class="badge-dot"></span>Keluar</span>
                            @else
                                <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-group">
                                @if($s->trashed())
                                    <form action="{{ route('admin.siswa.restore', $s->id) }}" method="POST" id="restoreForm-{{ $s->id }}">
                                        @csrf
                                        <button type="button" class="btn btn-sm btn-restore"
                                            onclick="confirmRestore(document.getElementById('restoreForm-{{ $s->id }}'), '{{ addslashes($s->nama_lengkap) }}')">
                                            Pulihkan
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('admin.siswa.show', $s->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                    <a href="{{ route('admin.siswa.edit', $s->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                    <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST" id="deleteForm-{{ $s->id }}">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-del"
                                            onclick="confirmDelete(document.getElementById('deleteForm-{{ $s->id }}'), '{{ addslashes($s->nama_lengkap) }}')">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon"><svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                                <p class="empty-title">Data siswa tidak ditemukan</p>
                                <p class="empty-sub">Coba ubah kata kunci pencarian atau reset filter</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($siswa->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $siswa->firstItem() }} – {{ $siswa->lastItem() }} dari {{ $siswa->total() }} siswa</p>
            <div class="pag-btns">
                @if($siswa->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $siswa->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($siswa->getUrlRange(1, $siswa->lastPage()) as $page => $url)
                    @if($page == $siswa->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $siswa->lastPage() || abs($page - $siswa->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $siswa->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
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

{{-- Import Modal --}}
<div class="modal-overlay" id="importModal" onclick="closeModalOnOverlay(event, 'importModal')">
    <div class="modal">
        <p class="modal-title">Import Data Siswa</p>
        <p class="modal-sub">Upload file Excel. Siswa dengan NIS yang sudah ada akan dilewati. Kolom <strong>kelas</strong> harus sesuai nama kelas di sistem.</p>
        <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label class="modal-label">Pilih File</label>
            <input type="file" name="file" accept=".xlsx,.xls,.csv" style="width:100%;border:1.5px solid #e2e8f0;border-radius:7px;padding:8px 12px;font-size:13px;background:#f8fafc;box-sizing:border-box;" required>
            <p class="modal-file-hint">Format: .xlsx, .xls, .csv — Maks. 5MB</p>
            <a href="{{ route('admin.siswa.export.excel', ['template' => 1]) }}" class="template-link">⬇ Download template import</a>
            <div class="modal-footer">
                <button type="button" class="modal-cancel" onclick="closeModal('importModal')">Batal</button>
                <button type="submit" class="modal-submit">Import Sekarang</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('warning'))
    Swal.fire({ icon:'warning', title:'Perhatian', text:@json(session('warning')), confirmButtonColor:'#1f63db' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif

    function confirmDelete(form, nama) {
        Swal.fire({ title:'Hapus Siswa?', text:`Data "${nama}" akan dihapus (bisa dipulihkan).`, icon:'warning', showCancelButton:true, confirmButtonColor:'#dc2626', cancelButtonColor:'#64748b', confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal' }).then(r => { if(r.isConfirmed) form.submit(); });
    }
    function confirmRestore(form, nama) {
        Swal.fire({ title:'Pulihkan Siswa?', text:`Data "${nama}" akan dipulihkan kembali.`, icon:'question', showCancelButton:true, confirmButtonColor:'#1f63db', cancelButtonColor:'#64748b', confirmButtonText:'Ya, Pulihkan!', cancelButtonText:'Batal' }).then(r => { if(r.isConfirmed) form.submit(); });
    }
    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }
    function closeModalOnOverlay(e, id) { if(e.target === document.getElementById(id)) closeModal(id); }
    document.addEventListener('keydown', e => { if(e.key === 'Escape') document.querySelectorAll('.modal-overlay.open').forEach(m => m.classList.remove('open')); });
</script>
</x-app-layout>