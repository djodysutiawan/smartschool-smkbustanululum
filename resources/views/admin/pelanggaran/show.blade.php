<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;}
    .page{padding:28px 28px 60px;max-width:2000px;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand);}
    .breadcrumb .sep{color:var(--border2);}.breadcrumb .current{color:var(--text2);}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}.btn-back:hover{background:var(--surface3);filter:none;}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}.btn-edit:hover{background:var(--brand-100);filter:none;}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}.btn-del:hover{background:#fee2e2;filter:none;}
    .btn-selesai{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}.btn-selesai:hover{background:#dcfce7;filter:none;}
    .btn-batalkan{background:#fef9c3;color:#a16207;border:1px solid #fde68a;}.btn-batalkan:hover{background:#fef08a;filter:none;}
    .layout-2col{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px;}
    .detail-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;}
    .detail-header-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .detail-item{padding:13px 20px;border-bottom:1px solid var(--border);display:flex;flex-direction:column;gap:4px;}
    .detail-item:last-child{border-bottom:none;}
    .detail-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;}
    .detail-value{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);font-weight:500;}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-pending{background:#f1f5f9;color:#64748b;}.badge-pending .badge-dot{background:#94a3b8;}
    .badge-diproses{background:#dbeafe;color:#1d4ed8;}.badge-diproses .badge-dot{background:#1d4ed8;}
    .badge-selesai{background:#dcfce7;color:#15803d;}.badge-selesai .badge-dot{background:#15803d;}
    .badge-banding{background:#fef9c3;color:#a16207;}.badge-banding .badge-dot{background:#a16207;}
    .tingkat-ringan{background:#dbeafe;color:#1d4ed8;padding:2px 8px;border-radius:4px;font-size:12px;font-weight:700;}
    .tingkat-sedang{background:#fef9c3;color:#a16207;padding:2px 8px;border-radius:4px;font-size:12px;font-weight:700;}
    .tingkat-berat{background:#fee2e2;color:#dc2626;padding:2px 8px;border-radius:4px;font-size:12px;font-weight:700;}
    .poin-big-card{background:linear-gradient(135deg,#dc2626,#ef4444);color:#fff;border-radius:var(--radius);padding:20px;text-align:center;margin-bottom:16px;}
    .poin-number{font-family:'Plus Jakarta Sans',sans-serif;font-size:48px;font-weight:800;line-height:1;}
    .poin-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;opacity:.85;margin-top:4px;}
    @media(max-width:768px){.layout-2col{grid-template-columns:1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.pelanggaran.index') }}">Data Pelanggaran</a>
        <span class="sep">›</span>
        <span class="current">Detail #{{ $pelanggaran->id }}</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Pelanggaran</h1>
            <p class="page-sub">{{ $pelanggaran->siswa->nama_lengkap ?? '—' }} — {{ \Carbon\Carbon::parse($pelanggaran->tanggal)->format('d F Y') }}</p>
        </div>
        <div class="header-actions">
            @if($pelanggaran->status === 'diproses')
            <form action="{{ route('admin.pelanggaran.selesaikan', $pelanggaran->id) }}" method="POST" id="selesaiForm">
                @csrf @method('PATCH')
                <input type="hidden" name="tindakan" value="{{ $pelanggaran->tindakan }}">
                <button type="button" class="btn btn-selesai" onclick="confirmSelesaikan(document.getElementById('selesaiForm'))">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Selesaikan
                </button>
            </form>
            @endif
            @if(!in_array($pelanggaran->status, ['selesai','banding']))
            <form action="{{ route('admin.pelanggaran.batalkan', $pelanggaran->id) }}" method="POST" id="batalForm">
                @csrf @method('PATCH')
                <button type="button" class="btn btn-batalkan" onclick="confirmBatalkan(document.getElementById('batalForm'))">
                    Batalkan
                </button>
            </form>
            @endif
            <a href="{{ route('admin.pelanggaran.edit', $pelanggaran->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.pelanggaran.destroy', $pelanggaran->id) }}" method="POST" id="delForm">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete(document.getElementById('delForm'))">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                    Hapus
                </button>
            </form>
            <a href="{{ route('admin.pelanggaran.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="layout-2col">
        <div>
            <div class="poin-big-card">
                <p class="poin-number">{{ $pelanggaran->poin }}</p>
                <p class="poin-label">POIN PELANGGARAN</p>
            </div>

            <div class="detail-card">
                <div class="detail-header">
                    <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    <p class="detail-header-title">Informasi Siswa</p>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Nama Siswa</span>
                    <span class="detail-value" style="font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;">{{ $pelanggaran->siswa->nama_lengkap ?? '—' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">NIS</span>
                    <span class="detail-value">{{ $pelanggaran->siswa->nis ?? '—' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Kelas</span>
                    <span class="detail-value">{{ $pelanggaran->siswa->kelas->nama_kelas ?? '—' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Total Poin Siswa</span>
                    <span class="detail-value"><strong style="font-size:16px;font-family:'Plus Jakarta Sans',sans-serif;color:#dc2626;">{{ $totalPoinSiswa }}</strong> poin</span>
                </div>
            </div>
        </div>

        <div>
            <div class="detail-card">
                <div class="detail-header">
                    <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
                    <p class="detail-header-title">Detail Pelanggaran</p>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Kategori</span>
                    <span class="detail-value">
                        @if($pelanggaran->kategori)
                        {{ $pelanggaran->kategori->nama }}<br>
                        <span class="tingkat-{{ $pelanggaran->kategori->tingkat }}">{{ ucfirst($pelanggaran->kategori->tingkat) }}</span>
                        @else —
                        @endif
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Tanggal</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->format('d F Y') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Status</span>
                    <span class="detail-value">
                        @php $statusMap = ['pending'=>'badge-pending','diproses'=>'badge-diproses','selesai'=>'badge-selesai','banding'=>'badge-banding']; @endphp
                        <span class="badge {{ $statusMap[$pelanggaran->status] ?? 'badge-pending' }}">
                            <span class="badge-dot"></span>
                            {{ ucfirst($pelanggaran->status) }}
                        </span>
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Dicatat Oleh</span>
                    <span class="detail-value">{{ $pelanggaran->dicatatOleh->name ?? '—' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Deskripsi</span>
                    <span class="detail-value" style="white-space:pre-line;line-height:1.6;">{{ $pelanggaran->deskripsi ?? '—' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Tindakan</span>
                    <span class="detail-value" style="white-space:pre-line;line-height:1.6;">{{ $pelanggaran->tindakan ?? '—' }}</span>
                </div>
                @if($pelanggaran->diselesaikan_pada)
                <div class="detail-item">
                    <span class="detail-label">Diselesaikan Pada</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($pelanggaran->diselesaikan_pada)->format('d F Y, H:i') }}</span>
                </div>
                @endif
                <div class="detail-item">
                    <span class="detail-label">Dicatat Pada</span>
                    <span class="detail-value" style="color:var(--text3)">{{ $pelanggaran->created_at->format('d F Y, H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });@endif
    @if(session('error'))Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });@endif

    function confirmDelete(form) {
        Swal.fire({
            title:'Hapus Catatan Pelanggaran?', text:'Data pelanggaran ini akan dihapus permanen.',
            icon:'warning', showCancelButton:true,
            confirmButtonColor:'#dc2626', cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal',
        }).then(r => { if(r.isConfirmed) form.submit(); });
    }

    function confirmSelesaikan(form) {
        Swal.fire({
            title:'Selesaikan Pelanggaran?', text:'Status akan diubah menjadi Selesai.',
            icon:'question', showCancelButton:true,
            confirmButtonColor:'#15803d', cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Selesaikan!', cancelButtonText:'Batal',
        }).then(r => { if(r.isConfirmed) form.submit(); });
    }

    function confirmBatalkan(form) {
        Swal.fire({
            title:'Batalkan Pelanggaran?', text:'Pelanggaran ini akan ditandai sebagai dibatalkan.',
            icon:'warning', showCancelButton:true,
            confirmButtonColor:'#a16207', cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Batalkan!', cancelButtonText:'Tidak',
        }).then(r => { if(r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>