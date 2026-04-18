<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand: #1f63db; --brand-50: #eef6ff; --brand-100: #d9ebff; --brand-700: #1750c0;
        --surface: #fff; --surface2: #f8fafc; --surface3: #f1f5f9;
        --border: #e2e8f0; --border2: #cbd5e1;
        --text: #0f172a; --text2: #475569; --text3: #94a3b8;
        --radius: 10px; --radius-sm: 7px;
    }
    .page { padding: 28px 28px 60px; max-width: 2000px; margin: 0 auto; }
    .breadcrumb { display: flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600; color: var(--text3); margin-bottom: 20px; }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .header-actions { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s; white-space: nowrap; }
    .btn:hover { filter: brightness(.93); }
    .btn-back { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-back:hover { background: var(--surface3); filter: none; }
    .btn-edit { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover { background: var(--brand-100); filter: none; }
    .btn-del { background: #fff0f0; color: #dc2626; border: 1px solid #fecaca; }
    .btn-del:hover { background: #fee2e2; filter: none; }
    .btn-toggle { background: #fef9c3; color: #a16207; border: 1px solid #fde68a; }
    .btn-toggle:hover { background: #fef08a; filter: none; }
    .btn-export { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-export:hover { background: var(--surface3); filter: none; }

    .stats-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; margin-bottom: 16px; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px 18px; display: flex; align-items: center; gap: 12px; }
    .stat-icon { width: 38px; height: 38px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .stat-icon.blue { background: var(--brand-50); }
    .stat-icon.green { background: #f0fdf4; }
    .stat-icon.orange { background: #fff7ed; }
    .stat-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 600; color: var(--text3); letter-spacing: .03em; text-transform: uppercase; }
    .stat-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: var(--text); line-height: 1.1; margin-top: 1px; }

    .info-grid { display: grid; grid-template-columns: 360px 1fr; gap: 16px; margin-bottom: 16px; }
    .info-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .info-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); background: var(--surface2); display: flex; align-items: center; gap: 8px; }
    .info-card-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .info-card-body { padding: 16px 20px; display: flex; flex-direction: column; gap: 14px; }
    .info-row { display: flex; align-items: flex-start; gap: 12px; }
    .info-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .04em; min-width: 130px; padding-top: 1px; }
    .info-val { font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); flex: 1; }

    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-aktif { background: #dcfce7; color: #15803d; }
    .badge-aktif .badge-dot { background: #15803d; }
    .badge-nonaktif { background: #fee2e2; color: #dc2626; }
    .badge-nonaktif .badge-dot { background: #dc2626; }

    .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .table-topbar { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 10px; }
    .table-info { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .table-info span { font-weight: 400; color: var(--text3); margin-left: 6px; }
    .topbar-actions { display: flex; gap: 8px; }
    table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    thead tr { background: var(--surface2); border-bottom: 1px solid var(--border); }
    thead th { padding: 11px 14px; text-align: left; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); letter-spacing: .05em; text-transform: uppercase; }
    thead th.center { text-align: center; }
    tbody tr { border-bottom: 1px solid #f1f5f9; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fafbff; }
    td { padding: 10px 14px; color: var(--text); vertical-align: middle; }
    td.center { text-align: center; }
    td.muted { color: var(--text3); font-size: 12.5px; }
    .status-tersedia { display: inline-block; padding: 2px 9px; border-radius: 5px; font-size: 12px; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif; background: #dcfce7; color: #15803d; }
    .status-dipakai { background: #fee2e2; color: #dc2626; display: inline-block; padding: 2px 9px; border-radius: 5px; font-size: 12px; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif; }
    .status-perbaikan { background: #fef9c3; color: #a16207; display: inline-block; padding: 2px 9px; border-radius: 5px; font-size: 12px; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif; }
    .empty-state { padding: 40px 20px; text-align: center; }
    .empty-sub { font-size: 13px; color: var(--text3); }
    @media (max-width: 900px) { .info-grid { grid-template-columns: 1fr; } .stats-row { grid-template-columns: 1fr 1fr; } .page { padding: 16px; } }
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.gedung.index') }}">Data Gedung</a>
        <span class="sep">›</span>
        <span class="current">{{ $gedung->nama_gedung }}</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $gedung->nama_gedung }}</h1>
            <p class="page-sub">Kode: {{ $gedung->kode_gedung }} · {{ $gedung->jumlah_lantai }} lantai</p>
        </div>
        <div class="header-actions">
            <form action="{{ route('admin.gedung.toggle-status', $gedung->id) }}" method="POST" id="toggleForm">
                @csrf @method('PATCH')
                <button type="button" class="btn btn-toggle"
                    onclick="confirmToggle(document.getElementById('toggleForm'), '{{ addslashes($gedung->nama_gedung) }}', {{ $gedung->is_active ? 'true' : 'false' }})">
                    {{ $gedung->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </form>
            <a href="{{ route('admin.gedung.edit', $gedung->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.gedung.destroy', $gedung->id) }}" method="POST" id="deleteForm">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del"
                    onclick="confirmDelete(document.getElementById('deleteForm'), '{{ addslashes($gedung->nama_gedung) }}', {{ $stats['total_ruang'] }})">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                    Hapus
                </button>
            </form>
            <a href="{{ route('admin.gedung.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Ruang</p>
                <p class="stat-val">{{ $stats['total_ruang'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Ruang Tersedia</p>
                <p class="stat-val">{{ $stats['ruang_tersedia'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
                <p class="stat-label">Ruang Terpakai</p>
                <p class="stat-val">{{ $stats['ruang_terpakai'] }}</p>
            </div>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-card">
            <div class="info-card-header">
                <svg width="14" height="14" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                <span class="info-card-title">Detail Gedung</span>
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label">Nama Gedung</span>
                    <span class="info-val" style="font-weight:700;font-family:'Plus Jakarta Sans',sans-serif">{{ $gedung->nama_gedung }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kode Gedung</span>
                    <span class="info-val">{{ $gedung->kode_gedung }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jumlah Lantai</span>
                    <span class="info-val">{{ $gedung->jumlah_lantai }} lantai</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-val">
                        @if($gedung->is_active)
                            <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                        @else
                            <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                        @endif
                    </span>
                </div>
                @if($gedung->deskripsi)
                <div class="info-row">
                    <span class="info-label">Deskripsi</span>
                    <span class="info-val">{{ $gedung->deskripsi }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Dibuat</span>
                    <span class="info-val" style="color:var(--text3)">{{ $gedung->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Diperbarui</span>
                    <span class="info-val" style="color:var(--text3)">{{ $gedung->updated_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="table-topbar">
                <p class="table-info">
                    Daftar Ruangan
                    <span>— {{ $gedung->ruang->count() }} ruang</span>
                </p>
                <div class="topbar-actions">
                    <a href="{{ route('admin.gedung.export.pdf', ['id' => $gedung->id]) }}" class="btn btn-export" style="font-size:12px;padding:6px 12px;border-radius:6px">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Export PDF
                    </a>
                    <a href="{{ route('admin.gedung.export.excel', ['id' => $gedung->id]) }}" class="btn btn-export" style="font-size:12px;padding:6px 12px;border-radius:6px">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                        Export Excel
                    </a>
                </div>
            </div>
            @if($gedung->ruang->count())
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama / Kode</th>
                        <th class="center">Lantai</th>
                        <th>Jenis</th>
                        <th class="center">Kapasitas</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gedung->ruang as $i => $r)
                    <tr>
                        <td class="muted">{{ $i + 1 }}</td>
                        <td>
                            <p style="font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px">{{ $r->nama_ruang }}</p>
                            <p style="font-size:11.5px;color:var(--text3)">{{ $r->kode_ruang }}</p>
                        </td>
                        <td class="center muted">{{ $r->lantai }}</td>
                        <td style="font-size:12.5px;text-transform:capitalize">{{ str_replace('_', ' ', $r->jenis_ruang) }}</td>
                        <td class="center muted">{{ $r->kapasitas }}</td>
                        <td>
                            @if($r->status === 'tersedia')
                                <span class="status-tersedia">Tersedia</span>
                            @elseif($r->status === 'dipakai')
                                <span class="status-dipakai">Dipakai</span>
                            @else
                                <span class="status-perbaikan">Perbaikan</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <p class="empty-sub">Belum ada ruangan yang terdaftar di gedung ini</p>
            </div>
            @endif
        </div>
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

    function confirmDelete(form, nama, ruangCount) {
        if (ruangCount > 0) {
            Swal.fire({
                icon:'error', title:'Tidak Dapat Dihapus',
                html:`Gedung <strong>${nama}</strong> masih memiliki <strong>${ruangCount} ruangan</strong>. Hapus semua ruangan terlebih dahulu.`,
                confirmButtonColor:'#1f63db',
            });
            return;
        }
        Swal.fire({
            title:'Hapus Gedung?',
            html:`Gedung <strong>${nama}</strong> akan dihapus permanen dan tidak dapat dikembalikan.`,
            icon:'warning', showCancelButton:true,
            confirmButtonColor:'#dc2626', cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }

    function confirmToggle(form, nama, isActive) {
        Swal.fire({
            title:`${isActive ? 'Nonaktifkan' : 'Aktifkan'} Gedung?`,
            html:`Gedung <strong>${nama}</strong> akan di${isActive ? 'nonaktifkan' : 'aktifkan'}.`,
            icon:'question', showCancelButton:true,
            confirmButtonColor:'#1f63db', cancelButtonColor:'#64748b',
            confirmButtonText:`Ya, ${isActive ? 'Nonaktifkan' : 'Aktifkan'}!`, cancelButtonText:'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>