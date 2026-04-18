<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand:    #1f63db;
        --brand-50: #eef6ff;
        --brand-100:#d9ebff;
        --brand-700:#1750c0;
        --surface:  #fff;
        --surface2: #f8fafc;
        --surface3: #f1f5f9;
        --border:   #e2e8f0;
        --border2:  #cbd5e1;
        --text:     #0f172a;
        --text2:    #475569;
        --text3:    #94a3b8;
        --radius:   10px;
        --radius-sm:7px;
    }

    .page { padding:28px 28px 60px; max-width:2000px; margin:0 auto; }
    .breadcrumb { display:flex; align-items:center; gap:6px; font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:600; color:var(--text3); margin-bottom:20px; }
    .breadcrumb a { color:var(--text3); text-decoration:none; transition:color .15s; }
    .breadcrumb a:hover { color:var(--brand); }
    .breadcrumb .sep { color:var(--border2); }
    .breadcrumb .current { color:var(--text2); }

    .page-header { display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:24px; flex-wrap:wrap; }
    .page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:20px; font-weight:800; color:var(--text); }
    .page-sub { font-size:12.5px; color:var(--text3); margin-top:3px; }
    .header-actions { display:flex; gap:8px; flex-wrap:wrap; }

    .btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; border:none; text-decoration:none; transition:filter .15s; white-space:nowrap; }
    .btn-back  { background:var(--surface2); color:var(--text2); border:1px solid var(--border); }
    .btn-back:hover { background:var(--surface3); }
    .btn-edit  { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
    .btn-edit:hover { background:var(--brand-100); filter:none; }
    .btn-del   { background:#fff0f0; color:#dc2626; border:1px solid #fecaca; }
    .btn-del:hover { background:#fee2e2; filter:none; }

    .detail-grid { display:grid; grid-template-columns:2fr 1fr; gap:20px; }

    .card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; }
    .card-header { padding:14px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:8px; }
    .card-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; color:var(--text); }
    .card-body { padding:20px; }

    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:0; }
    .info-item { padding:12px 16px; border-bottom:1px solid var(--surface3); }
    .info-item:nth-child(odd) { border-right:1px solid var(--surface3); }
    .info-item:last-child, .info-item:nth-last-child(2):nth-child(odd) { border-bottom:none; }
    .info-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:700; color:var(--text3); text-transform:uppercase; letter-spacing:.05em; margin-bottom:4px; }
    .info-value { font-family:'DM Sans',sans-serif; font-size:14px; color:var(--text); font-weight:500; }

    .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:99px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; white-space:nowrap; }
    .badge-dot { width:5px; height:5px; border-radius:50%; }
    .badge-tersedia      { background:#dcfce7; color:#15803d; } .badge-tersedia .badge-dot      { background:#15803d; }
    .badge-tidak_tersedia{ background:#fef3c7; color:#92400e; } .badge-tidak_tersedia .badge-dot { background:#d97706; }
    .badge-perbaikan     { background:#fee2e2; color:#dc2626; } .badge-perbaikan .badge-dot     { background:#dc2626; }

    .jenis-pill { display:inline-block; padding:2px 9px; border-radius:5px; font-family:'Plus Jakarta Sans',sans-serif; font-size:12px; font-weight:700; }
    .jenis-kelas                 { background:#eef2ff; color:#4338ca; border:1px solid #c7d2fe; }
    .jenis-laboratorium_komputer { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
    .jenis-laboratorium_ipa      { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
    .jenis-laboratorium_bahasa   { background:#fdf4ff; color:#7c3aed; border:1px solid #e9d5ff; }
    .jenis-aula                  { background:#fff7ed; color:#c2410c; border:1px solid #fed7aa; }
    .jenis-perpustakaan          { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
    .jenis-ruang_praktik         { background:#fefce8; color:#92400e; border:1px solid #fde68a; }
    .jenis-lainnya               { background:var(--surface3); color:var(--text2); border:1px solid var(--border2); }

    .fas-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; padding:16px 20px; }
    .fas-card { display:flex; align-items:center; gap:10px; padding:12px 14px; border-radius:var(--radius-sm); border:1.5px solid var(--border); }
    .fas-card.on { border-color:#bfdbfe; background:#eff6ff; }
    .fas-icon-lg { width:34px; height:34px; border-radius:8px; display:flex; align-items:center; justify-content:center; background:var(--surface3); flex-shrink:0; }
    .fas-card.on .fas-icon-lg { background:#dbeafe; }
    .fas-card.on .fas-icon-lg svg { stroke:#1d4ed8; }
    .fas-name { font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; color:var(--text2); }
    .fas-card.on .fas-name { color:var(--brand); }
    .fas-status { font-size:11px; color:var(--text3); margin-top:1px; }
    .fas-card.on .fas-status { color:#3b82f6; }

    .empty-state { padding:40px 20px; text-align:center; }
    .empty-title { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:14px; color:var(--text); margin-bottom:4px; }
    .empty-sub { font-size:12.5px; color:var(--text3); }

    table { width:100%; border-collapse:collapse; font-size:13px; }
    thead tr { background:var(--surface2); }
    thead th { padding:9px 14px; text-align:left; font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:700; color:var(--text3); letter-spacing:.05em; text-transform:uppercase; }
    tbody tr { border-top:1px solid var(--border); }
    tbody tr:hover { background:#fafbff; }
    td { padding:9px 14px; color:var(--text); }

    @media (max-width:900px) {
        .detail-grid { grid-template-columns:1fr; }
        .page { padding:16px; }
    }
</style>

<div class="page">

    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ruang.index') }}">Manajemen Ruang</a>
        <span class="sep">›</span>
        <span class="current">{{ $ruang->nama_ruang }}</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $ruang->nama_ruang }}</h1>
            <p class="page-sub">Detail informasi ruang — {{ $ruang->kode_ruang }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.ruang.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.ruang.edit', $ruang->id) }}" class="btn btn-edit">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.ruang.destroy', $ruang->id) }}" method="POST" id="delForm">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="detail-grid">
        <div style="display:flex;flex-direction:column;gap:20px">

            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                    <p class="card-title">Informasi Ruang</p>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <p class="info-label">Kode Ruang</p>
                        <p class="info-value" style="font-weight:700;font-family:'Plus Jakarta Sans',sans-serif">{{ $ruang->kode_ruang }}</p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">Nama Ruang</p>
                        <p class="info-value">{{ $ruang->nama_ruang }}</p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">Gedung</p>
                        <p class="info-value">{{ $ruang->gedung->nama_gedung ?? '-' }}</p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">Lantai</p>
                        <p class="info-value">Lantai {{ $ruang->lantai }}</p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">Jenis Ruang</p>
                        <p class="info-value">
                            <span class="jenis-pill jenis-{{ $ruang->jenis_ruang }}">{{ ucfirst(str_replace('_',' ',$ruang->jenis_ruang)) }}</span>
                        </p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">Kapasitas</p>
                        <p class="info-value">{{ $ruang->kapasitas }} orang</p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">Status</p>
                        <p class="info-value">
                            <span class="badge badge-{{ $ruang->status }}">
                                <span class="badge-dot"></span>{{ ucfirst(str_replace('_',' ',$ruang->status)) }}
                            </span>
                        </p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">Keterangan</p>
                        <p class="info-value">{{ $ruang->keterangan ?: '-' }}</p>
                    </div>
                    @if($ruang->fasilitas_lain)
                    <div class="info-item" style="grid-column:span 2;border-bottom:none">
                        <p class="info-label">Fasilitas Lain</p>
                        <p class="info-value">{{ $ruang->fasilitas_lain }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <p class="card-title">Kelas yang Menggunakan Ruang Ini</p>
                </div>
                @if($ruang->kelas && $ruang->kelas->count())
                <table>
                    <thead><tr>
                        <th>Nama Kelas</th>
                        <th>Tingkat</th>
                        <th>Tahun Ajaran</th>
                        <th>Wali Kelas</th>
                    </tr></thead>
                    <tbody>
                        @foreach($ruang->kelas as $k)
                        <tr>
                            <td style="font-weight:700;font-family:'Plus Jakarta Sans',sans-serif">{{ $k->nama_kelas }}</td>
                            <td>{{ $k->tingkat }}</td>
                            <td>{{ $k->tahunAjaran->tahun ?? '-' }}</td>
                            <td>{{ $k->waliKelas->nama_lengkap ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <p class="empty-title">Belum ada kelas</p>
                    <p class="empty-sub">Ruang ini belum digunakan oleh kelas manapun</p>
                </div>
                @endif
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:20px">

            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    <p class="card-title">Fasilitas</p>
                </div>
                <div class="fas-grid">
                    @foreach([
                        ['ada_proyektor','Proyektor','<rect x="2" y="7" width="20" height="13" rx="2"/><path d="M12 3v4M8 3h8"/>'],
                        ['ada_ac','AC','<path d="M12 2v20M2 12h20M4.93 4.93l14.14 14.14M19.07 4.93 4.93 19.07"/>'],
                        ['ada_wifi','WiFi','<path d="M5 12.55a11 11 0 0 1 14.08 0M1.42 9a16 16 0 0 1 21.16 0M8.53 16.11a6 6 0 0 1 6.95 0"/><circle cx="12" cy="20" r="1" fill="currentColor"/>'],
                        ['ada_komputer','Komputer','<rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>'],
                    ] as [$field, $label, $svgPath])
                    <div class="fas-card {{ $ruang->$field ? 'on' : '' }}">
                        <div class="fas-icon-lg">
                            <svg width="16" height="16" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">{!! $svgPath !!}</svg>
                        </div>
                        <div>
                            <p class="fas-name">{{ $label }}</p>
                            <p class="fas-status">{{ $ruang->$field ? 'Tersedia' : 'Tidak ada' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <p class="card-title">Informasi Sistem</p>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <p class="info-label">Dibuat</p>
                        <p class="info-value">{{ $ruang->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">Diperbarui</p>
                        <p class="info-value">{{ $ruang->updated_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
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

    function confirmDelete() {
        Swal.fire({
            title: 'Hapus Ruang?',
            html: `Ruang <strong>{{ $ruang->nama_ruang }}</strong> akan dihapus permanen.<br>Pastikan ruang tidak sedang digunakan kelas atau jadwal.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('delForm').submit(); });
    }
</script>
</x-app-layout>