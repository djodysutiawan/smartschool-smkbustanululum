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
    .stats-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}.stat-icon.red{background:#fff0f0;}.stat-icon.orange{background:#fff7ed;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px;}
    .detail-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;}
    .detail-header-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .detail-grid{display:grid;grid-template-columns:1fr 1fr;}
    .detail-item{padding:13px 20px;border-bottom:1px solid var(--border);display:flex;flex-direction:column;gap:4px;}
    .detail-item:nth-child(odd){border-right:1px solid var(--border);}
    .detail-item.full{grid-column:span 2;border-right:none;}
    .detail-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;}
    .detail-value{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);font-weight:500;}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-aktif{background:#dcfce7;color:#15803d;}.badge-aktif .badge-dot{background:#15803d;}
    .badge-nonaktif{background:#f1f5f9;color:#64748b;}.badge-nonaktif .badge-dot{background:#94a3b8;}
    .bobot-badge{display:inline-block;padding:3px 10px;border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;}
    .bobot-ringan{background:#dbeafe;color:#1d4ed8;}
    .bobot-sedang{background:#fef9c3;color:#a16207;}
    .bobot-berat{background:#fee2e2;color:#dc2626;}
    .tabel-pelanggaran{width:100%;border-collapse:collapse;font-size:13px;}
    .tabel-pelanggaran thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    .tabel-pelanggaran thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;}
    .tabel-pelanggaran tbody tr{border-bottom:1px solid #f1f5f9;}
    .tabel-pelanggaran tbody tr:last-child{border-bottom:none;}
    .tabel-pelanggaran td{padding:9px 14px;color:var(--text);}
    @media(max-width:640px){.page{padding:16px;}.stats-strip{grid-template-columns:1fr 1fr;}.detail-grid{grid-template-columns:1fr;}.detail-item:nth-child(odd){border-right:none;}.detail-item.full{grid-column:span 1;}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.kategori-pelanggaran.index') }}">Kategori Pelanggaran</a>
        <span class="sep">›</span>
        <span class="current">{{ $kategoriPelanggaran->nama }}</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $kategoriPelanggaran->nama }}</h1>
            <p class="page-sub">Detail kategori — {{ $kategoriPelanggaran->poin_default }} poin default</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.kategori-pelanggaran.edit', $kategoriPelanggaran->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.kategori-pelanggaran.destroy', $kategoriPelanggaran->id) }}" method="POST" id="delForm">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete(document.getElementById('delForm'), {{ $totalKasus }})">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M9 6V4h6v2"/></svg>
                    Hapus
                </button>
            </form>
            <a href="{{ route('admin.kategori-pelanggaran.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div><p class="stat-label">Total Kasus</p><p class="stat-val">{{ $totalKasus }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div><p class="stat-label">Poin Default</p><p class="stat-val">{{ $kategoriPelanggaran->poin_default }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div><p class="stat-label">Siswa Terdampak</p><p class="stat-val">{{ $siswaUnik }}</p></div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-header">
            <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <p class="detail-header-title">Informasi Kategori</p>
        </div>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">Nama Kategori</span>
                <span class="detail-value" style="font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;">{{ $kategoriPelanggaran->nama }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Tingkat</span>
                <span class="detail-value">
                    @php $cls=['ringan'=>'bobot-ringan','sedang'=>'bobot-sedang','berat'=>'bobot-berat'];@endphp
                    <span class="bobot-badge {{ $cls[$kategoriPelanggaran->tingkat] ?? 'bobot-ringan' }}">{{ ucfirst($kategoriPelanggaran->tingkat) }}</span>
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Poin Default</span>
                <span class="detail-value"><strong style="font-size:18px;font-family:'Plus Jakarta Sans',sans-serif;">{{ $kategoriPelanggaran->poin_default }}</strong> poin</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Batas Poin Maks.</span>
                <span class="detail-value">{{ $kategoriPelanggaran->batas_poin ?? '—' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Warna</span>
                <span class="detail-value" style="display:flex;align-items:center;gap:8px;">
                    <span style="display:inline-block;width:20px;height:20px;border-radius:4px;background:{{ $kategoriPelanggaran->warna_hex }}"></span>
                    {{ $kategoriPelanggaran->warna ?? 'Default' }}
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Status</span>
                <span class="detail-value">
                    @if($kategoriPelanggaran->is_active)
                        <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                    @else
                        <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                    @endif
                </span>
            </div>
            <div class="detail-item full">
                <span class="detail-label">Deskripsi</span>
                <span class="detail-value">{{ $kategoriPelanggaran->deskripsi ?? '—' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Dibuat</span>
                <span class="detail-value" style="color:var(--text3)">{{ $kategoriPelanggaran->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Diperbarui</span>
                <span class="detail-value" style="color:var(--text3)">{{ $kategoriPelanggaran->updated_at->format('d M Y, H:i') }}</span>
            </div>
        </div>
    </div>

    @if($pelanggaranTerbaru->count())
    <div class="detail-card">
        <div class="detail-header">
            <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            <p class="detail-header-title">Pelanggaran Terbaru dengan Kategori Ini</p>
        </div>
        <div style="overflow-x:auto">
            <table class="tabel-pelanggaran">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Poin</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pelanggaranTerbaru as $i => $p)
                    <tr>
                        <td style="color:var(--text3);font-size:12px;">{{ $i + 1 }}</td>
                        <td style="font-weight:600;">{{ $p->siswa->nama_lengkap ?? '—' }}</td>
                        <td style="color:var(--text3);font-size:12.5px;">{{ $p->siswa->kelas->nama_kelas ?? '—' }}</td>
                        <td style="color:var(--text3);font-size:12.5px;">{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                        <td><strong style="font-family:'Plus Jakarta Sans',sans-serif;">{{ $p->poin }}</strong></td>
                        <td style="font-size:12px;color:var(--text3);text-transform:capitalize;">{{ $p->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });@endif
    @if(session('error'))Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });@endif
    function confirmDelete(form, jumlahKasus) {
        if (jumlahKasus > 0) {
            Swal.fire({ icon:'error', title:'Tidak Dapat Dihapus',
                html:`Kategori ini sudah digunakan di <strong>${jumlahKasus} kasus</strong> pelanggaran.`,
                confirmButtonColor:'#1f63db' });
            return;
        }
        Swal.fire({
            title:'Hapus Kategori?', text:'Kategori ini akan dihapus permanen.',
            icon:'warning', showCancelButton:true,
            confirmButtonColor:'#dc2626', cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal',
        }).then(r => { if(r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>