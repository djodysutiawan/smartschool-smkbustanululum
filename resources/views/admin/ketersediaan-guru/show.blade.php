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
.btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; border:none; text-decoration:none; transition:filter .15s, background .15s; white-space:nowrap; }
.btn-back  { background:var(--surface2); color:var(--text2); border:1px solid var(--border); }
.btn-back:hover { background:var(--surface3); }
.btn-edit  { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
.btn-edit:hover { background:var(--brand-100); filter:none; }
.btn-del   { background:#fff0f0; color:#dc2626; border:1px solid #fecaca; }
.btn-del:hover { background:#fee2e2; filter:none; }
.btn-toggle { background:#fefce8; color:#a16207; border:1px solid #fde68a; }
.btn-toggle:hover { background:#fef9c3; filter:none; }
.detail-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
.card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; }
.card-header { padding:14px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:8px; }
.card-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; color:var(--text); }
.info-grid { display:grid; grid-template-columns:1fr 1fr; }
.info-item { padding:14px 20px; border-bottom:1px solid var(--surface3); }
.info-item:nth-child(odd) { border-right:1px solid var(--surface3); }
.info-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:700; color:var(--text3); text-transform:uppercase; letter-spacing:.05em; margin-bottom:5px; }
.info-value { font-family:'DM Sans',sans-serif; font-size:14px; color:var(--text); font-weight:500; }
.badge { display:inline-flex; align-items:center; gap:4px; padding:4px 12px; border-radius:99px; font-family:'Plus Jakarta Sans',sans-serif; font-size:12px; font-weight:700; white-space:nowrap; }
.badge-dot { width:6px; height:6px; border-radius:50%; }
.badge-tersedia { background:#dcfce7; color:#15803d; } .badge-tersedia .badge-dot { background:#15803d; }
.badge-tidak    { background:#fee2e2; color:#dc2626; } .badge-tidak .badge-dot { background:#dc2626; }
.hari-pill { display:inline-block; padding:4px 14px; border-radius:7px; font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:800; text-transform:capitalize; }
.hari-senin  { background:#eef2ff; color:#4338ca; border:1px solid #c7d2fe; }
.hari-selasa { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
.hari-rabu   { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
.hari-kamis  { background:#fefce8; color:#a16207; border:1px solid #fde68a; }
.hari-jumat  { background:#fff7ed; color:#c2410c; border:1px solid #fed7aa; }
.hari-sabtu  { background:#fdf4ff; color:#7c3aed; border:1px solid #e9d5ff; }
.time-display { display:flex; align-items:center; gap:16px; padding:20px; }
.time-block { text-align:center; flex:1; }
.time-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:700; color:var(--text3); text-transform:uppercase; letter-spacing:.05em; margin-bottom:6px; }
.time-val { font-family:'Plus Jakarta Sans',sans-serif; font-size:32px; font-weight:800; color:var(--text); }
.time-sep { font-size:24px; color:var(--border2); font-weight:300; }
.duration-box { background:var(--brand-50); border:1px solid var(--brand-100); border-radius:var(--radius-sm); padding:10px 16px; margin:0 20px 20px; text-align:center; }
.duration-val { font-family:'Plus Jakarta Sans',sans-serif; font-size:16px; font-weight:800; color:var(--brand); }
.duration-label { font-size:11.5px; color:#3b82f6; margin-top:2px; }
@media (max-width:768px) { .detail-grid { grid-template-columns:1fr; } .page { padding:16px; } }
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ketersediaan-guru.index') }}">Ketersediaan Guru</a>
        <span class="sep">›</span>
        <span class="current">Detail Slot</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Slot Ketersediaan</h1>
            <p class="page-sub">{{ $ketersediaanGuru->guru->nama_lengkap ?? '-' }} — {{ ucfirst($ketersediaanGuru->hari) }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.ketersediaan-guru.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <form action="{{ route('admin.ketersediaan-guru.toggle', $ketersediaanGuru->id) }}" method="POST" id="toggleForm">
                @csrf @method('PATCH')
                <button type="button" class="btn btn-toggle" onclick="confirmToggle()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14M7 23l-4-4 4-4"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                    Toggle Status
                </button>
            </form>
            <a href="{{ route('admin.ketersediaan-guru.edit', $ketersediaanGuru->id) }}" class="btn btn-edit">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.ketersediaan-guru.destroy', $ketersediaanGuru->id) }}" method="POST" id="delForm">
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
                    <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <p class="card-title">Informasi Slot</p>
                </div>
                <div class="info-grid">
                    <div class="info-item" style="grid-column:span 2">
                        <p class="info-label">Guru</p>
                        <p class="info-value" style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:16px">{{ $ketersediaanGuru->guru->nama_lengkap ?? '-' }}</p>
                        @if($ketersediaanGuru->guru?->nip)
                            <p style="font-size:12px;color:var(--text3);margin-top:2px">NIP: {{ $ketersediaanGuru->guru->nip }}</p>
                        @endif
                    </div>
                    <div class="info-item">
                        <p class="info-label">Hari</p>
                        <p class="info-value"><span class="hari-pill hari-{{ $ketersediaanGuru->hari }}">{{ ucfirst($ketersediaanGuru->hari) }}</span></p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">Status</p>
                        <p class="info-value">
                            @if($ketersediaanGuru->tersedia)
                                <span class="badge badge-tersedia"><span class="badge-dot"></span>Tersedia</span>
                            @else
                                <span class="badge badge-tidak"><span class="badge-dot"></span>Tidak Tersedia</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="time-display">
                    <div class="time-block">
                        <p class="time-label">Mulai</p>
                        <p class="time-val">{{ \Carbon\Carbon::parse($ketersediaanGuru->jam_mulai)->format('H:i') }}</p>
                    </div>
                    <span class="time-sep">→</span>
                    <div class="time-block">
                        <p class="time-label">Selesai</p>
                        <p class="time-val">{{ \Carbon\Carbon::parse($ketersediaanGuru->jam_selesai)->format('H:i') }}</p>
                    </div>
                </div>
                <div class="duration-box">
                    <p class="duration-val">{{ $ketersediaanGuru->durasi_menit }} menit</p>
                    <p class="duration-label">Total durasi slot</p>
                </div>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:20px">
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    <p class="card-title">Profil Guru</p>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <p class="info-label">Nama</p>
                        <p class="info-value">{{ $ketersediaanGuru->guru->nama_lengkap ?? '-' }}</p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">NIP</p>
                        <p class="info-value">{{ $ketersediaanGuru->guru->nip ?? '-' }}</p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">Status Kepegawaian</p>
                        <p class="info-value" style="text-transform:uppercase">{{ $ketersediaanGuru->guru->status_kepegawaian ?? '-' }}</p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">Status Guru</p>
                        <p class="info-value" style="text-transform:capitalize">{{ $ketersediaanGuru->guru->status ?? '-' }}</p>
                    </div>
                    <div class="info-item" style="grid-column:span 2;border-bottom:none">
                        <a href="{{ route('admin.ketersediaan-guru.by-guru', $ketersediaanGuru->guru_id) }}"
                            style="display:inline-flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--brand);text-decoration:none">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Lihat Semua Ketersediaan Guru Ini
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <p class="card-title">Informasi Sistem</p>
                </div>
                <div class="info-grid">
                    <div class="info-item" style="border-bottom:none">
                        <p class="info-label">Dibuat</p>
                        <p class="info-value">{{ $ketersediaanGuru->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="info-item" style="border-bottom:none">
                        <p class="info-label">Diperbarui</p>
                        <p class="info-value">{{ $ketersediaanGuru->updated_at->format('d M Y H:i') }}</p>
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

function confirmToggle() {
    const current = {{ $ketersediaanGuru->tersedia ? 'true' : 'false' }};
    const newStatus = current ? 'Tidak Tersedia' : 'Tersedia';
    Swal.fire({
        title: 'Ubah Status Slot?',
        text: `Status akan diubah menjadi "${newStatus}".`,
        icon: 'question', showCancelButton: true,
        confirmButtonColor: '#1f63db', cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Ubah!', cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) document.getElementById('toggleForm').submit(); });
}

function confirmDelete() {
    Swal.fire({
        title: 'Hapus Slot?',
        html: `Slot <strong>{{ $ketersediaanGuru->guru->nama_lengkap ?? '' }}</strong> — {{ ucfirst($ketersediaanGuru->hari) }} pukul {{ \Carbon\Carbon::parse($ketersediaanGuru->jam_mulai)->format('H:i') }} akan dihapus permanen.`,
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) document.getElementById('delForm').submit(); });
}
</script>
</x-app-layout>