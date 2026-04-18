<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand: #1f63db; --brand-h: #3582f0; --brand-50: #eef6ff; --brand-100: #d9ebff; --brand-700: #1750c0;
        --surface: #fff; --surface2: #f8fafc; --surface3: #f1f5f9;
        --border: #e2e8f0; --border2: #cbd5e1;
        --text: #0f172a; --text2: #475569; --text3: #94a3b8;
        --red: #dc2626; --red-bg: #fee2e2; --red-border: #fecaca;
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
    .btn-activate { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .btn-activate:hover { background: #dcfce7; filter: none; }
    .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 6px; }
    .btn-outline { background: var(--surface); color: var(--text2); border: 1px solid var(--border); }
    .btn-outline:hover { background: var(--surface2); filter: none; }

    .stats-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; margin-bottom: 16px; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px 18px; display: flex; align-items: center; gap: 12px; }
    .stat-icon { width: 38px; height: 38px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .stat-icon.blue { background: var(--brand-50); }
    .stat-icon.green { background: #f0fdf4; }
    .stat-icon.purple { background: #faf5ff; }
    .stat-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 600; color: var(--text3); letter-spacing: .03em; text-transform: uppercase; }
    .stat-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: var(--text); line-height: 1.1; margin-top: 1px; }

    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; white-space: nowrap; }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-aktif { background: #dcfce7; color: #15803d; }
    .badge-aktif .badge-dot { background: #15803d; }
    .badge-nonaktif { background: #fee2e2; color: #dc2626; }
    .badge-nonaktif .badge-dot { background: #dc2626; }
    .kelompok-pill { display: inline-block; padding: 2px 9px; border-radius: 5px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }

    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
    .info-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .info-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); background: var(--surface2); display: flex; align-items: center; gap: 8px; }
    .info-card-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .info-card-count { font-size: 11.5px; color: var(--text3); margin-left: auto; }
    .info-card-body { padding: 16px 20px; display: flex; flex-direction: column; gap: 14px; }
    .info-row { display: flex; align-items: flex-start; gap: 12px; }
    .info-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .04em; min-width: 140px; padding-top: 1px; }
    .info-val { font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); flex: 1; }

    .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .table-topbar { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 10px; }
    .table-info { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .table-info span { font-weight: 400; color: var(--text3); margin-left: 6px; }
    table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    thead tr { background: var(--surface2); border-bottom: 1px solid var(--border); }
    thead th { padding: 11px 14px; text-align: left; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); letter-spacing: .05em; text-transform: uppercase; white-space: nowrap; }
    tbody tr { border-bottom: 1px solid #f1f5f9; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fafbff; }
    td { padding: 10px 14px; color: var(--text); vertical-align: middle; }
    td.muted { color: var(--text3); font-size: 12.5px; }
    .empty-state { padding: 40px 20px; text-align: center; }
    .empty-sub { font-size: 13px; color: var(--text3); }

    @media (max-width: 768px) {
        .info-grid { grid-template-columns: 1fr; }
        .stats-row { grid-template-columns: 1fr 1fr; }
        .page { padding: 16px; }
    }
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.mata-pelajaran.index') }}">Mata Pelajaran</a>
        <span class="sep">›</span>
        <span class="current">{{ $mataPelajaran->nama_mapel }}</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $mataPelajaran->nama_mapel }}</h1>
            <p class="page-sub">
                Kode: {{ $mataPelajaran->kode_mapel }}
                @if($mataPelajaran->kelompok) · Kelompok: <span class="kelompok-pill">{{ ucfirst(str_replace('_', ' ', $mataPelajaran->kelompok)) }}</span>@endif
            </p>
        </div>
        <div class="header-actions">
            <form action="{{ route('admin.mata-pelajaran.toggle-status', $mataPelajaran->id) }}" method="POST" id="toggleForm">
                @csrf @method('PATCH')
                <button type="button" class="btn {{ $mataPelajaran->is_active ? 'btn-toggle' : 'btn-activate' }}"
                    onclick="confirmToggle(document.getElementById('toggleForm'), '{{ addslashes($mataPelajaran->nama_mapel) }}', {{ $mataPelajaran->is_active ? 'true' : 'false' }})">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    {{ $mataPelajaran->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </form>
            <a href="{{ route('admin.mata-pelajaran.edit', $mataPelajaran->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.mata-pelajaran.destroy', $mataPelajaran->id) }}" method="POST" id="deleteForm">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del"
                    onclick="confirmDelete(document.getElementById('deleteForm'), '{{ addslashes($mataPelajaran->nama_mapel) }}')">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    Hapus
                </button>
            </form>
            <a href="{{ route('admin.mata-pelajaran.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Jam/Minggu</p>
                <p class="stat-val">{{ $mataPelajaran->jam_per_minggu }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Durasi Sesi</p>
                <p class="stat-val">{{ $mataPelajaran->durasi_per_sesi }}<span style="font-size:14px;font-weight:600"> mnt</span></p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div>
                <p class="stat-label">Guru Pengampu</p>
                <p class="stat-val">{{ $guruPengampu->count() }}</p>
            </div>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-card">
            <div class="info-card-header">
                <svg width="14" height="14" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                <span class="info-card-title">Detail Mata Pelajaran</span>
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label">Nama Mapel</span>
                    <span class="info-val" style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">{{ $mataPelajaran->nama_mapel }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kode Mapel</span>
                    <span class="info-val">{{ $mataPelajaran->kode_mapel }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kelompok</span>
                    <span class="info-val">
                        @if($mataPelajaran->kelompok)
                            <span class="kelompok-pill">{{ ucfirst(str_replace('_', ' ', $mataPelajaran->kelompok)) }}</span>
                        @else
                            <span style="color:var(--text3)">—</span>
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jam Per Minggu</span>
                    <span class="info-val">{{ $mataPelajaran->jam_per_minggu }} jam</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Durasi Sesi</span>
                    <span class="info-val">{{ $mataPelajaran->durasi_per_sesi }} menit</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total/Minggu</span>
                    <span class="info-val">{{ $mataPelajaran->total_menit_per_minggu }} menit</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Perlu Lab</span>
                    <span class="info-val">{{ $mataPelajaran->perlu_lab ? '✓ Ya' : '— Tidak' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-val">
                        @if($mataPelajaran->is_active)
                            <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                        @else
                            <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                        @endif
                    </span>
                </div>
                @if($mataPelajaran->keterangan)
                <div class="info-row">
                    <span class="info-label">Keterangan</span>
                    <span class="info-val">{{ $mataPelajaran->keterangan }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Ditambahkan</span>
                    <span class="info-val" style="color:var(--text3)">{{ $mataPelajaran->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        <div class="info-card">
            <div class="info-card-header">
                <svg width="14" height="14" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                <span class="info-card-title">Guru Pengampu</span>
                <span class="info-card-count">{{ $guruPengampu->count() }} guru</span>
            </div>
            @if($guruPengampu->count())
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Guru</th>
                        <th>NIP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guruPengampu as $i => $g)
                    <tr>
                        <td class="muted">{{ $i + 1 }}</td>
                        <td style="font-weight:600;font-family:'Plus Jakarta Sans',sans-serif">{{ $g->nama_lengkap }}</td>
                        <td class="muted">{{ $g->nip ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <p class="empty-sub">Belum ada guru pengampu untuk mata pelajaran ini</p>
            </div>
            @endif
        </div>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Jadwal Pelajaran
                <span>— {{ $mataPelajaran->jadwalPelajaran->count() }} jadwal terdaftar</span>
            </p>
        </div>
        @if($mataPelajaran->jadwalPelajaran->count())
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kelas</th>
                    <th>Guru</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mataPelajaran->jadwalPelajaran as $i => $j)
                <tr>
                    <td class="muted">{{ $i + 1 }}</td>
                    <td style="font-weight:600;font-family:'Plus Jakarta Sans',sans-serif">{{ $j->kelas->nama_kelas ?? '—' }}</td>
                    <td>{{ $j->guru->nama_lengkap ?? '—' }}</td>
                    <td>{{ ucfirst($j->hari ?? '—') }}</td>
                    <td class="muted">{{ $j->jam_mulai ?? '—' }}</td>
                    <td class="muted">{{ $j->jam_selesai ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <p class="empty-sub">Belum ada jadwal pelajaran untuk mata pelajaran ini</p>
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
            title: 'Hapus Mata Pelajaran?',
            html: `Mata pelajaran <strong>${nama}</strong> akan dihapus permanen.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }

    function confirmToggle(form, nama, isActive) {
        Swal.fire({
            title: `${isActive ? 'Nonaktifkan' : 'Aktifkan'} Mata Pelajaran?`,
            html: `Mata pelajaran <strong>${nama}</strong> akan di${isActive ? 'nonaktifkan' : 'aktifkan'}.`,
            icon: 'question', showCancelButton: true,
            confirmButtonColor: '#1f63db', cancelButtonColor: '#64748b',
            confirmButtonText: `Ya, ${isActive ? 'Nonaktifkan' : 'Aktifkan'}!`, cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>