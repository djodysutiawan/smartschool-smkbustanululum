<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}

    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .detail-header{padding:20px 24px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:flex-start;gap:16px}
    .detail-icon{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .detail-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:17px;font-weight:800;color:var(--text);line-height:1.3}
    .detail-meta{font-size:12.5px;color:var(--text3);margin-top:4px;display:flex;gap:12px;flex-wrap:wrap}
    .detail-body{padding:24px}
    .detail-message{font-family:'DM Sans',sans-serif;font-size:14.5px;color:var(--text2);line-height:1.7;white-space:pre-wrap}

    .info-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px;margin-bottom:16px}
    .info-item{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 16px}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:4px}
    .info-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text)}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-info       {background:#eff6ff;color:#1d4ed8}    .badge-info       .badge-dot{background:#1d4ed8}
    .badge-peringatan {background:#fefce8;color:#a16207}   .badge-peringatan .badge-dot{background:#a16207}
    .badge-pelanggaran{background:#fff0f0;color:#dc2626}   .badge-pelanggaran .badge-dot{background:#dc2626}
    .badge-absensi    {background:#f0fdf4;color:#15803d}   .badge-absensi    .badge-dot{background:#15803d}
    .badge-nilai      {background:#fdf4ff;color:#7c3aed}   .badge-nilai      .badge-dot{background:#7c3aed}
    .badge-pengumuman {background:#fff7ed;color:#c2410c}   .badge-pengumuman .badge-dot{background:#c2410c}
    .badge-tugas      {background:#ecfdf5;color:#065f46}   .badge-tugas      .badge-dot{background:#065f46}
    .badge-ujian      {background:#fef3c7;color:#92400e}   .badge-ujian      .badge-dot{background:#92400e}

    .icon-info{background:#eff6ff} .icon-peringatan{background:#fefce8} .icon-pelanggaran{background:#fff0f0}
    .icon-absensi{background:#f0fdf4} .icon-nilai{background:#fdf4ff} .icon-pengumuman{background:#fff7ed}
    .icon-tugas{background:#ecfdf5} .icon-ujian{background:#fef3c7}

    @media(max-width:640px){.page{padding:16px}.header-actions{width:100%}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Notifikasi</h1>
            <p class="page-sub">Informasi lengkap notifikasi</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.notifikasi.index') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <form action="{{ route('guru.notifikasi.destroy', $notifikasi->id) }}" method="POST" id="delForm" style="display:inline">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del"
                    onclick="confirmDelete()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Info Grid --}}
    <div class="info-grid">
        <div class="info-item">
            <p class="info-label">Jenis</p>
            <span class="badge badge-{{ $notifikasi->jenis }}">
                <span class="badge-dot"></span>{{ ucfirst($notifikasi->jenis) }}
            </span>
        </div>
        <div class="info-item">
            <p class="info-label">Status</p>
            @if($notifikasi->sudah_dibaca)
                <p class="info-val" style="color:#15803d">✓ Sudah Dibaca</p>
            @else
                <p class="info-val" style="color:var(--brand-600)">● Belum Dibaca</p>
            @endif
        </div>
        <div class="info-item">
            <p class="info-label">Diterima</p>
            <p class="info-val" style="font-size:13px">{{ $notifikasi->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</p>
        </div>
        @if($notifikasi->sudah_dibaca && $notifikasi->dibaca_pada)
        <div class="info-item">
            <p class="info-label">Dibaca Pada</p>
            <p class="info-val" style="font-size:13px">{{ $notifikasi->dibaca_pada->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</p>
        </div>
        @endif
    </div>

    {{-- Detail Card --}}
    <div class="detail-card">
        <div class="detail-header">
            <div class="detail-icon icon-{{ $notifikasi->jenis }}">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            </div>
            <div>
                <p class="detail-title">{{ $notifikasi->judul }}</p>
                <div class="detail-meta">
                    <span>{{ $notifikasi->created_at->locale('id')->diffForHumans() }}</span>
                </div>
            </div>
        </div>
        <div class="detail-body">
            <p class="detail-message">{{ $notifikasi->pesan }}</p>

            @if($notifikasi->data)
            <div style="margin-top:20px;padding-top:20px;border-top:1px solid var(--border)">
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:10px">Data Tambahan</p>
                <pre style="background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px;font-size:12.5px;color:var(--text2);overflow-x:auto;white-space:pre-wrap">{{ json_encode($notifikasi->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
            @endif

            @if($notifikasi->url)
            <div style="margin-top:16px">
                <a href="{{ $notifikasi->url }}" class="btn btn-secondary" style="background:var(--brand-50);color:var(--brand-700);border-color:var(--brand-100)">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    Buka Tautan Terkait
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete() {
    Swal.fire({
        title: 'Hapus Notifikasi?',
        html: `Notifikasi ini akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) document.getElementById('delForm').submit(); });
}
</script>
</x-app-layout>