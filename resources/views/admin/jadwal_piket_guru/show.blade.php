<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand)}
    .breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-back{padding:8px 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border)}.btn-back:hover{background:var(--surface3);filter:none}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}.btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}.btn-del:hover{background:#fee2e2;filter:none}
    .btn-toggle{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa}.btn-toggle:hover{background:#ffedd5;filter:none}
    .btn-pdf{background:#fdf4ff;color:#7c3aed;border:1px solid #e9d5ff}.btn-pdf:hover{background:#f3e8ff;filter:none}
    .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .detail-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .detail-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .detail-body{padding:20px}
    .detail-row{display:flex;flex-direction:column;gap:4px;padding:10px 0;border-bottom:1px solid #f8fafc}
    .detail-row:last-child{border-bottom:none}
    .detail-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .detail-val{font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text)}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%}
    .badge-aktif{background:#dcfce7;color:#15803d}.badge-aktif .badge-dot{background:#15803d}
    .badge-nonaktif{background:#fee2e2;color:#dc2626}.badge-nonaktif .badge-dot{background:#dc2626}
    .hari-pill{display:inline-block;padding:3px 12px;border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700}
    .hari-senin{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
    .hari-selasa{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .hari-rabu{background:#fefce8;color:#a16207;border:1px solid #fde68a}
    .hari-kamis{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa}
    .hari-jumat{background:#fdf4ff;color:#7c3aed;border:1px solid #e9d5ff}
    .hari-sabtu{background:#f0f9ff;color:#0369a1;border:1px solid #bae6fd}
    .jam-display{font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;font-weight:800;color:var(--text)}
    .jam-sep{color:var(--text3);margin:0 6px}
    .catatan-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 14px;font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text2);line-height:1.6;margin-top:4px}
    @media(max-width:768px){.detail-grid{grid-template-columns:1fr}.page{padding:16px}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.jadwal-piket-guru.index') }}">Jadwal Piket Guru</a>
        <span class="sep">›</span>
        <span class="current">Detail Jadwal Piket</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Jadwal Piket Guru</h1>
            <p class="page-sub">{{ $jadwalPiketGuru->guru->nama_lengkap ?? '-' }} — {{ ucfirst($jadwalPiketGuru->hari) }}</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <a href="{{ route('admin.jadwal-piket-guru.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.jadwal-piket-guru.export-pdf-single', $jadwalPiketGuru->id) }}" class="btn btn-pdf" target="_blank">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export PDF
            </a>
            <a href="{{ route('admin.jadwal-piket-guru.edit', $jadwalPiketGuru->id) }}" class="btn btn-edit">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.jadwal-piket-guru.toggle-status', $jadwalPiketGuru->id) }}" method="POST" id="toggleForm" style="display:inline">
                @csrf @method('PATCH')
                <button type="button" class="btn btn-toggle" onclick="confirmToggle()">
                    {{ $jadwalPiketGuru->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </form>
            <form action="{{ route('admin.jadwal-piket-guru.destroy', $jadwalPiketGuru->id) }}" method="POST" id="delForm" style="display:inline">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="detail-grid">
        <div class="detail-card">
            <div class="detail-card-header">
                <svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <p class="detail-card-title">Detail Jadwal Piket</p>
            </div>
            <div class="detail-body">
                <div class="detail-row">
                    <span class="detail-label">Hari</span>
                    <span class="detail-val"><span class="hari-pill hari-{{ $jadwalPiketGuru->hari }}">{{ ucfirst($jadwalPiketGuru->hari) }}</span></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Jam Piket</span>
                    <div>
                        <span class="jam-display">{{ \Carbon\Carbon::parse($jadwalPiketGuru->jam_mulai)->format('H:i') }}</span>
                        <span class="jam-sep">–</span>
                        <span class="jam-display">{{ \Carbon\Carbon::parse($jadwalPiketGuru->jam_selesai)->format('H:i') }}</span>
                    </div>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status</span>
                    <span class="detail-val">
                        @if($jadwalPiketGuru->is_active)
                            <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                        @else
                            <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Catatan</span>
                    @if($jadwalPiketGuru->catatan)
                        <div class="catatan-box">{{ $jadwalPiketGuru->catatan }}</div>
                    @else
                        <span class="detail-val" style="color:var(--text3)">Tidak ada catatan</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="detail-card">
            <div class="detail-card-header">
                <svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                <p class="detail-card-title">Informasi Guru & Tahun Ajaran</p>
            </div>
            <div class="detail-body">
                <div class="detail-row">
                    <span class="detail-label">Nama Guru</span>
                    <span class="detail-val" style="font-weight:700">{{ $jadwalPiketGuru->guru->nama_lengkap ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">NIP</span>
                    <span class="detail-val">{{ $jadwalPiketGuru->guru->nip ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tahun Ajaran</span>
                    <span class="detail-val">{{ $jadwalPiketGuru->tahunAjaran->tahun ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Dibuat</span>
                    <span class="detail-val">{{ $jadwalPiketGuru->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Terakhir Diperbarui</span>
                    <span class="detail-val">{{ $jadwalPiketGuru->updated_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>
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

    function confirmDelete() {
        Swal.fire({
            title:'Hapus Jadwal Piket?',
            text:'Jadwal piket ini akan dihapus permanen.',
            icon:'warning',showCancelButton:true,
            confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal',
        }).then(r => { if(r.isConfirmed) document.getElementById('delForm').submit(); });
    }

    function confirmToggle() {
        const aksi = '{{ $jadwalPiketGuru->is_active ? "nonaktifkan" : "aktifkan" }}';
        Swal.fire({
            title:`${aksi.charAt(0).toUpperCase()+aksi.slice(1)} Jadwal?`,
            text:`Jadwal piket ini akan di${aksi}.`,
            icon:'question',showCancelButton:true,
            confirmButtonColor:'#1f63db',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Lanjutkan!',cancelButtonText:'Batal',
        }).then(r => { if(r.isConfirmed) document.getElementById('toggleForm').submit(); });
    }
</script>
</x-app-layout>