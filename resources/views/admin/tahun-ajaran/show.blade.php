<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;
        --yellow:#a16207;--yellow-bg:#fefce8;--yellow-border:#fde68a;
        --purple:#7c3aed;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box;}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;}
    .breadcrumb a{color:var(--text3);text-decoration:none;transition:color .15s;}
    .breadcrumb a:hover{color:var(--brand);}
    .breadcrumb .sep{color:var(--border2);}
    .breadcrumb .current{color:var(--text2);}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
    .btn-back:hover{background:var(--surface3);filter:none;}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}
    .btn-edit:hover{background:var(--brand-100);filter:none;}
    .btn-del{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border);}
    .btn-del:hover{background:#fecaca;filter:none;}
    .btn-aktif{background:var(--yellow-bg);color:var(--yellow);border:1px solid var(--yellow-border);}
    .btn-aktif:hover{background:#fef9c3;filter:none;}
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}
    .stat-icon.purple{background:#fdf4ff;}
    .stat-icon.green{background:var(--green-bg);}
    .stat-icon.orange{background:#fff7ed;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px;}
    .detail-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;}
    .detail-header-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .detail-grid{display:grid;grid-template-columns:1fr 1fr;}
    .detail-item{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;flex-direction:column;gap:4px;}
    .detail-item:nth-child(odd){border-right:1px solid var(--border);}
    .detail-item.full{grid-column:span 2;border-right:none;}
    .detail-item:last-child{border-bottom:none;}
    .detail-item:nth-last-child(2):nth-child(odd){border-bottom:none;}
    .detail-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;}
    .detail-value{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);font-weight:500;}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-aktif{background:#dcfce7;color:var(--green);}.badge-aktif .badge-dot{background:var(--green);}
    .badge-nonaktif{background:var(--surface3);color:#64748b;}.badge-nonaktif .badge-dot{background:#94a3b8;}
    .pill{display:inline-block;padding:2px 9px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;}
    .pill-ganjil{background:#eef2ff;color:#4338ca;border:1px solid #c7d2fe;}
    .pill-genap{background:#fdf4ff;color:var(--purple);border:1px solid #e9d5ff;}
    .tag-aktif{display:inline-block;background:var(--brand);color:#fff;font-size:10px;font-weight:800;padding:2px 8px;border-radius:5px;margin-left:6px;font-family:'Plus Jakarta Sans',sans-serif;vertical-align:middle;}
    .alert-success{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;background:var(--green-bg);color:var(--green);border:1px solid var(--green-border);}
    .alert-error{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;background:var(--red-bg);color:var(--red);border:1px solid var(--red-border);}
    @media(max-width:768px){
        .stats-strip{grid-template-columns:1fr 1fr;}
        .page{padding:16px;}
        .detail-grid{grid-template-columns:1fr;}
        .detail-item:nth-child(odd){border-right:none;}
        .detail-item.full{grid-column:span 1;}
    }
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.tahun-ajaran.index') }}">Tahun Ajaran</a>
        <span class="sep">›</span>
        <span class="current">{{ $tahunAjaran->tahun }}</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">
                {{ $tahunAjaran->tahun }}
                @if($tahunAjaran->isAktif())
                <span class="tag-aktif">AKTIF</span>
                @endif
            </h1>
            <p class="page-sub">Detail tahun ajaran — Semester {{ ucfirst($tahunAjaran->semester) }}</p>
        </div>
        <div class="header-actions">
            @if(!$tahunAjaran->isAktif())
            <form action="{{ route('admin.tahun-ajaran.aktifkan', $tahunAjaran->id) }}" method="POST" id="aktifForm">
                @csrf @method('PATCH')
                <button type="button" class="btn btn-aktif"
                    onclick="confirmAktifkan(document.getElementById('aktifForm'), '{{ addslashes($tahunAjaran->tahun) }}')">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Aktifkan
                </button>
            </form>
            @endif
            <a href="{{ route('admin.tahun-ajaran.edit', $tahunAjaran->id) }}" class="btn btn-edit">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            @if(!$tahunAjaran->isAktif())
            <form action="{{ route('admin.tahun-ajaran.destroy', $tahunAjaran->id) }}" method="POST" id="delForm">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del"
                    onclick="confirmDelete(document.getElementById('delForm'), '{{ addslashes($tahunAjaran->tahun) }}')">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    Hapus
                </button>
            </form>
            @endif
            <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert-success">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert-error">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Kelas</p>
                <p class="stat-val">{{ $stats['total_kelas'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Jadwal</p>
                <p class="stat-val">{{ $stats['total_jadwal'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Nilai</p>
                <p class="stat-val">{{ $stats['total_nilai'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#ea580c" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Siswa</p>
                <p class="stat-val">{{ $stats['total_siswa'] }}</p>
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-header">
            <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <p class="detail-header-title">Informasi Lengkap</p>
        </div>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">Tahun Ajaran</span>
                <span class="detail-value" style="font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;">{{ $tahunAjaran->tahun }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Semester</span>
                <span class="detail-value">
                    <span class="pill pill-{{ $tahunAjaran->semester }}">{{ ucfirst($tahunAjaran->semester) }}</span>
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Tanggal Mulai</span>
                <span class="detail-value">{{ $tahunAjaran->tanggal_mulai->translatedFormat('d F Y') }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Tanggal Selesai</span>
                <span class="detail-value">{{ $tahunAjaran->tanggal_selesai->translatedFormat('d F Y') }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Durasi</span>
                <span class="detail-value">{{ $tahunAjaran->durasi }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Status</span>
                <span class="detail-value">
                    @if($tahunAjaran->isAktif())
                        <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                    @else
                        <span class="badge badge-nonaktif"><span class="badge-dot"></span>Tidak Aktif</span>
                    @endif
                </span>
            </div>
            <div class="detail-item full">
                <span class="detail-label">Keterangan</span>
                <span class="detail-value">{{ $tahunAjaran->keterangan ?? '—' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Dibuat</span>
                <span class="detail-value">{{ $tahunAjaran->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Terakhir Diperbarui</span>
                <span class="detail-value">{{ $tahunAjaran->updated_at->format('d M Y, H:i') }}</span>
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

    function confirmAktifkan(form, nama) {
        Swal.fire({
            title: 'Aktifkan Tahun Ajaran?',
            text: `"${nama}" akan dijadikan tahun ajaran aktif. Tahun ajaran lain akan dinonaktifkan secara otomatis.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1f63db',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Aktifkan!',
            cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }

    function confirmDelete(form, nama) {
        Swal.fire({
            title: 'Hapus Tahun Ajaran?',
            text: `Data "${nama}" akan dihapus permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>