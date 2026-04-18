<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand-700: #1750c0;
        --brand-600: #1f63db;
        --brand-500: #3582f0;
        --brand-100: #d9ebff;
        --brand-50:  #eef6ff;
        --surface:   #fff;
        --surface2:  #f8fafc;
        --surface3:  #f1f5f9;
        --border:    #e2e8f0;
        --border2:   #cbd5e1;
        --text:      #0f172a;
        --text2:     #475569;
        --text3:     #94a3b8;
        --radius:    10px;
        --radius-sm: 7px;
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
    .btn-primary { background: var(--brand-600); color: #fff; }
    .btn-sm      { padding: 6px 12px; font-size: 12px; border-radius: 6px; }
    .btn-edit    { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover { background: var(--brand-100); filter: none; }
    .btn-del     { background: #fff0f0; color: #dc2626; border: 1px solid #fecaca; }
    .btn-del:hover { background: #fee2e2; filter: none; }
    .btn-detail  { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .btn-detail:hover { background: #dcfce7; filter: none; }
    .btn-restore { background: #fefce8; color: #a16207; border: 1px solid #fde68a; }
    .btn-restore:hover { background: #fef9c3; filter: none; }
    .btn-danger  { background: #fff0f0; color: #dc2626; border: 1px solid #fecaca; }
    .btn-danger:hover { background: #fee2e2; filter: none; }

    .stats-strip {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 12px; margin-bottom: 20px;
    }
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
    .stat-icon.red    { background: #fff0f0; }
    .stat-icon.yellow { background: #fefce8; }
    .stat-label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px;
        font-weight: 600; color: var(--text3);
        letter-spacing: .03em; text-transform: uppercase;
    }
    .stat-val {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px;
        font-weight: 800; color: var(--text); line-height: 1.1; margin-top: 1px;
    }

    .filter-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 16px 20px; margin-bottom: 16px;
    }
    .filter-row { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
    .filter-row input,
    .filter-row select {
        height: 36px; padding: 0 12px;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif; font-size: 13px;
        color: var(--text); background: var(--surface2); outline: none;
        transition: border-color .15s;
    }
    .filter-row input  { width: 210px; }
    .filter-row input:focus,
    .filter-row select:focus { border-color: var(--brand-500); background: #fff; }
    .filter-row input::placeholder { color: var(--text3); }
    .filter-sep { flex: 1; }
    .btn-filter {
        height: 36px; padding: 0 18px;
        background: var(--brand-600); color: #fff; border: none;
        border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px; font-weight: 700; cursor: pointer;
    }
    .btn-filter:hover { background: var(--brand-700); }
    .btn-reset {
        height: 36px; padding: 0 14px;
        background: var(--surface2); color: var(--text2);
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px; font-weight: 600; cursor: pointer;
        text-decoration: none; display: inline-flex; align-items: center;
    }
    .btn-reset:hover { background: var(--surface3); }

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
    tbody tr.is-trashed { opacity: .65; background: #fffbf0; }
    td { padding: 10px 14px; color: var(--text); vertical-align: middle; }
    td.center { text-align: center; }
    td.muted { color: var(--text3); }

    .no-col {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px; font-weight: 700; color: var(--text3);
    }

    .avatar-wrap {
        width: 36px; height: 36px; border-radius: 8px; overflow: hidden;
        border: 1px solid var(--border); background: var(--surface2);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .avatar-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-initial {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px; font-weight: 800; color: var(--brand-600);
    }

    .user-wrap .uname {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700; font-size: 13.5px; color: var(--text);
    }
    .user-wrap .uemail { font-size: 12px; color: var(--text3); margin-top: 1px; }

    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11.5px; font-weight: 700; white-space: nowrap;
    }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-aktif    { background: #dcfce7; color: #15803d; }
    .badge-aktif    .badge-dot { background: #15803d; }
    .badge-nonaktif { background: #fee2e2; color: #dc2626; }
    .badge-nonaktif .badge-dot { background: #dc2626; }
    .badge-terhapus { background: #fef9c3; color: #a16207; }
    .badge-terhapus .badge-dot { background: #a16207; }

    .role-pill {
        display: inline-block; padding: 2px 9px;
        border-radius: 5px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px; font-weight: 700;
    }
    .role-admin       { background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; }
    .role-guru        { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .role-siswa       { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .role-orang_tua   { background: #fdf4ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .role-guru_piket  { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }

    .action-group {
        display: flex; align-items: center;
        gap: 5px; justify-content: center; flex-wrap: wrap;
    }

    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-icon {
        width: 56px; height: 56px; background: var(--surface2);
        border-radius: 14px; display: flex; align-items: center;
        justify-content: center; margin: 0 auto 14px;
    }
    .empty-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700; font-size: 15px; color: var(--text); margin-bottom: 5px;
    }
    .empty-sub { font-size: 13px; color: var(--text3); }

    .pag-wrap {
        display: flex; align-items: center; justify-content: space-between;
        padding: 14px 20px; border-top: 1px solid var(--border);
        flex-wrap: wrap; gap: 10px;
    }
    .pag-info { font-size: 12.5px; color: var(--text3); }
    .pag-btns { display: flex; gap: 4px; align-items: center; }
    .pag-btn {
        height: 32px; min-width: 32px; padding: 0 8px;
        border-radius: 7px; display: flex; align-items: center; justify-content: center;
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
        .filter-row input { width: 100%; }
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Pengguna</h1>
            <p class="page-sub">Kelola akun pengguna sistem — tambah, edit, nonaktifkan, dan hapus</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Pengguna
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <p class="stat-label">Total</p>
                <p class="stat-val">{{ $stats['total'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Aktif</p>
                <p class="stat-val">{{ $stats['aktif'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
            </div>
            <div>
                <p class="stat-label">Nonaktif</p>
                <p class="stat-val">{{ $stats['nonaktif'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
            </div>
            <div>
                <p class="stat-label">Terhapus</p>
                <p class="stat-val">{{ $stats['terhapus'] }}</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.users.index') }}">
            <div class="filter-row">
                <input type="text" name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama atau email...">

                <select name="role">
                    <option value="">Semua Role</option>
                    @foreach(['admin','guru','siswa','orang_tua','guru_piket'] as $r)
                        <option value="{{ $r }}" {{ request('role') == $r ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $r)) }}
                        </option>
                    @endforeach
                </select>

                <select name="is_active">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <div class="filter-sep"></div>

                <a href="{{ route('admin.users.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan Filter</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Pengguna
                <span>— menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} data</span>
            </p>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th style="width:52px">Avatar</th>
                        <th>Nama / Email</th>
                        <th>Role</th>
                        <th>No. HP</th>
                        <th>Status</th>
                        <th class="center" style="width:210px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $u)
                    <tr class="{{ $u->trashed() ? 'is-trashed' : '' }}">
                        <td><span class="no-col">{{ $users->firstItem() + $index }}</span></td>

                        <td>
                            <div class="avatar-wrap">
                                @if($u->avatar)
                                    <img src="{{ asset('storage/'.$u->avatar) }}" alt="{{ $u->name }}">
                                @else
                                    <span class="avatar-initial">{{ strtoupper(substr($u->name, 0, 1)) }}</span>
                                @endif
                            </div>
                        </td>

                        <td>
                            <div class="user-wrap">
                                <p class="uname">{{ $u->name }}</p>
                                <p class="uemail">{{ $u->email }}</p>
                            </div>
                        </td>

                        <td>
                            <span class="role-pill role-{{ $u->role }}">
                                {{ ucfirst(str_replace('_', ' ', $u->role)) }}
                            </span>
                        </td>

                        <td class="muted" style="font-size:12.5px">{{ $u->no_hp ?? '-' }}</td>

                        <td>
                            @if($u->trashed())
                                <span class="badge badge-terhapus">
                                    <span class="badge-dot"></span>Terhapus
                                </span>
                            @elseif($u->is_active)
                                <span class="badge badge-aktif">
                                    <span class="badge-dot"></span>Aktif
                                </span>
                            @else
                                <span class="badge badge-nonaktif">
                                    <span class="badge-dot"></span>Nonaktif
                                </span>
                            @endif
                        </td>

                        <td class="center">
                            <div class="action-group">
                                @if($u->trashed())
                                    {{-- Restore --}}
                                    <form action="{{ route('admin.users.restore', $u->id) }}" method="POST" id="restoreForm-{{ $u->id }}">
                                        @csrf
                                        <button type="button" class="btn btn-sm btn-restore"
                                            onclick="confirmRestore(document.getElementById('restoreForm-{{ $u->id }}'), '{{ addslashes($u->name) }}')">
                                            Pulihkan
                                        </button>
                                    </form>
                                    {{-- Force Delete --}}
                                    <form action="{{ route('admin.users.force-delete', $u->id) }}" method="POST" id="forceForm-{{ $u->id }}">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmForceDelete(document.getElementById('forceForm-{{ $u->id }}'), '{{ addslashes($u->name) }}')">
                                            Hapus Permanen
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('admin.users.show', $u->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                    <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" id="deleteForm-{{ $u->id }}">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-del"
                                            onclick="confirmDelete(document.getElementById('deleteForm-{{ $u->id }}'), '{{ addslashes($u->name) }}')">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                </div>
                                <p class="empty-title">Pengguna tidak ditemukan</p>
                                <p class="empty-sub">Coba ubah kata kunci pencarian atau reset filter</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $users->firstItem() }} – {{ $users->lastItem() }} dari {{ $users->total() }} pengguna</p>
            <div class="pag-btns">
                @if($users->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $users->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                    @if($page == $users->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $users->lastPage() || abs($page - $users->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $users->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                @if($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="pag-btn">
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

    function confirmDelete(form, nama) {
        Swal.fire({
            title: 'Hapus Pengguna?',
            text: `Akun "${nama}" akan dihapus (bisa dipulihkan).`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
    function confirmRestore(form, nama) {
        Swal.fire({
            title: 'Pulihkan Pengguna?',
            text: `Akun "${nama}" akan dipulihkan kembali.`,
            icon: 'question', showCancelButton: true,
            confirmButtonColor: '#1f63db', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Pulihkan!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
    function confirmForceDelete(form, nama) {
        Swal.fire({
            title: 'Hapus Permanen?',
            html: `Akun <strong>${nama}</strong> akan dihapus <strong>permanen</strong> dan tidak bisa dipulihkan.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Hapus Permanen', cancelButtonText: 'Batal',
            input: 'checkbox',
            inputPlaceholder: 'Saya memahami tindakan ini tidak bisa dibatalkan',
            preConfirm: (checked) => {
                if (!checked) Swal.showValidationMessage('Centang konfirmasi terlebih dahulu');
            }
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>