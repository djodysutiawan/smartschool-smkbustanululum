<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--red:#dc2626;--radius:10px;--radius-sm:7px}
    .page{padding:28px 28px 60px;max-width:900px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand)}.breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}.btn-back:hover{background:var(--surface3);filter:none}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}.btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}.btn-del:hover{background:#fee2e2;filter:none}
    .info-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .info-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .info-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .info-card-body{padding:16px 20px;display:flex;flex-direction:column;gap:14px}
    .info-row{display:flex;align-items:flex-start;gap:12px}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;min-width:150px;padding-top:1px}
    .info-val{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);flex:1}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%}
    .b-hadir{background:#dcfce7;color:#15803d}.b-hadir .badge-dot{background:#15803d}
    .b-telat{background:#fef9c3;color:#a16207}.b-telat .badge-dot{background:#a16207}
    .b-izin{background:#dbeafe;color:#1d4ed8}.b-izin .badge-dot{background:#1d4ed8}
    .b-sakit{background:#f3e8ff;color:#6d28d9}.b-sakit .badge-dot{background:#6d28d9}
    .b-alfa{background:#fee2e2;color:#dc2626}.b-alfa .badge-dot{background:#dc2626}
    .metode-pill{display:inline-block;padding:2px 9px;border-radius:5px;font-size:11.5px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif}
    .m-manual{background:var(--surface3);color:var(--text2)}.m-qr{background:#f0fdf4;color:#15803d}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a><span class="sep">›</span>
        <a href="{{ route('admin.absensi-guru.index') }}">Absensi Guru</a><span class="sep">›</span>
        <span class="current">Detail</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Absensi Guru</h1>
            <p class="page-sub">
                {{ $absensiGuru->guru->nama_lengkap ?? '—' }} —
                {{ \Carbon\Carbon::parse($absensiGuru->tanggal)->translatedFormat('d F Y') }}
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.absensi-guru.edit', $absensiGuru->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.absensi-guru.destroy', $absensiGuru->id) }}" method="POST" id="deleteForm">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del"
                    onclick="Swal.fire({title:'Hapus Data?',text:'Data absensi ini akan dihapus permanen.',icon:'warning',showCancelButton:true,confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)document.getElementById('deleteForm').submit()})">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                    Hapus
                </button>
            </form>
            <a href="{{ route('admin.absensi-guru.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="info-card">
        <div class="info-card-header">
            <svg width="14" height="14" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <span class="info-card-title">Data Absensi</span>
        </div>
        <div class="info-card-body">
            <div class="info-row">
                <span class="info-label">Guru</span>
                <span class="info-val" style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">
                    {{ $absensiGuru->guru->nama_lengkap ?? '—' }}
                    @if($absensiGuru->guru?->nip)
                        <span style="font-weight:400;color:var(--text3);font-size:12px;margin-left:6px">NIP: {{ $absensiGuru->guru->nip }}</span>
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal</span>
                <span class="info-val">{{ \Carbon\Carbon::parse($absensiGuru->tanggal)->translatedFormat('l, d F Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status</span>
                <span class="info-val">
                    @php $bc=['hadir'=>'b-hadir','telat'=>'b-telat','izin'=>'b-izin','sakit'=>'b-sakit','alfa'=>'b-alfa'][$absensiGuru->status]??'b-alfa'; @endphp
                    <span class="badge {{ $bc }}"><span class="badge-dot"></span>{{ ucfirst($absensiGuru->status) }}</span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Metode</span>
                <span class="info-val"><span class="metode-pill m-{{ $absensiGuru->metode }}">{{ ucfirst($absensiGuru->metode) }}</span></span>
            </div>
            <div class="info-row">
                <span class="info-label">Jam Masuk</span>
                <span class="info-val">{{ $absensiGuru->jam_masuk ? \Carbon\Carbon::parse($absensiGuru->jam_masuk)->format('H:i') : '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jam Keluar</span>
                <span class="info-val">{{ $absensiGuru->jam_keluar ? \Carbon\Carbon::parse($absensiGuru->jam_keluar)->format('H:i') : '—' }}</span>
            </div>
            @if($absensiGuru->jadwalPiket)
            <div class="info-row">
                <span class="info-label">Jadwal Piket</span>
                <span class="info-val">{{ ucfirst($absensiGuru->jadwalPiket->hari ?? '—') }}</span>
            </div>
            @endif
            <div class="info-row">
                <span class="info-label">Dicatat Oleh</span>
                <span class="info-val">{{ $absensiGuru->pencatat->name ?? '—' }}</span>
            </div>
            @if($absensiGuru->keterangan)
            <div class="info-row">
                <span class="info-label">Keterangan</span>
                <span class="info-val">{{ $absensiGuru->keterangan }}</span>
            </div>
            @endif
            @if($absensiGuru->path_surat_izin)
            <div class="info-row">
                <span class="info-label">Surat Izin</span>
                <span class="info-val">
                    <a href="{{ asset('storage/'.$absensiGuru->path_surat_izin) }}" target="_blank" style="color:var(--brand);font-weight:600;font-family:'Plus Jakarta Sans',sans-serif">
                        Lihat Dokumen →
                    </a>
                </span>
            </div>
            @endif
            <div class="info-row">
                <span class="info-label">Ditambahkan</span>
                <span class="info-val" style="color:var(--text3)">{{ $absensiGuru->created_at->format('d M Y, H:i') }}</span>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});@endif
    @if(session('error'))Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});@endif
</script>
</x-app-layout>