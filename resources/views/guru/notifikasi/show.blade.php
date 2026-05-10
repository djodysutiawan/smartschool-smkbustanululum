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

    /* ── Layout ────────────────────────────────────────────────────────────── */
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    /* ── Buttons ───────────────────────────────────────────────────────────── */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}
    .btn-link{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-link:hover{background:var(--brand-100);filter:none}

    /* ── Badges ────────────────────────────────────────────────────────────── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-info        { background:#eff6ff; color:#1d4ed8; }
    .badge-info        .badge-dot { background:#1d4ed8; }
    .badge-peringatan  { background:#fefce8; color:#a16207; }
    .badge-peringatan  .badge-dot { background:#a16207; }
    .badge-nilai       { background:#fdf4ff; color:#7c3aed; }
    .badge-nilai       .badge-dot { background:#7c3aed; }
    .badge-absensi     { background:#f0fdf4; color:#15803d; }
    .badge-absensi     .badge-dot { background:#15803d; }
    .badge-tugas       { background:#ecfdf5; color:#065f46; }
    .badge-tugas       .badge-dot { background:#065f46; }
    .badge-pengumuman  { background:#fff7ed; color:#c2410c; }
    .badge-pengumuman  .badge-dot { background:#c2410c; }

    /* ── Info Grid ─────────────────────────────────────────────────────────── */
    .info-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:12px;margin-bottom:16px}
    .info-item{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 16px}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:6px}
    .info-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text)}

    /* ── Detail Card ───────────────────────────────────────────────────────── */
    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .detail-header{padding:20px 24px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:flex-start;gap:16px}
    .detail-icon{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0}

    /* FIX: Icon per jenis sekarang punya warna stroke yang sesuai badge-nya */
    .detail-icon.icon-info        { background:#eff6ff; color:#1d4ed8; }
    .detail-icon.icon-peringatan  { background:#fefce8; color:#a16207; }
    .detail-icon.icon-nilai       { background:#fdf4ff; color:#7c3aed; }
    .detail-icon.icon-absensi     { background:#f0fdf4; color:#15803d; }
    .detail-icon.icon-tugas       { background:#ecfdf5; color:#065f46; }
    .detail-icon.icon-pengumuman  { background:#fff7ed; color:#c2410c; }

    .detail-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:17px;font-weight:800;color:var(--text);line-height:1.3}
    .detail-meta{font-size:12.5px;color:var(--text3);margin-top:5px;display:flex;gap:12px;flex-wrap:wrap;align-items:center}
    .detail-body{padding:24px}
    .detail-message{font-family:'DM Sans',sans-serif;font-size:14.5px;color:var(--text2);line-height:1.75;white-space:pre-wrap;word-break:break-word}

    /* ── Status indicator ──────────────────────────────────────────────────── */
    .status-read   { color:#15803d; font-weight:700 }
    .status-unread { color:var(--brand-600); font-weight:700 }

    @media(max-width:640px){
        .page{padding:16px}
        .header-actions{width:100%}
        .detail-header{flex-direction:column}
    }
</style>

<div class="page">

    {{-- ── Header ─────────────────────────────────────────────────────────── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Notifikasi</h1>
            <p class="page-sub">Informasi lengkap notifikasi</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.notifikasi.index') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali
            </a>
            {{-- FIX: Redirect setelah destroy ke index (bukan back()) agar tidak
                 mengarah ke route show yang sudah tidak ada → 404. Controller sudah
                 menangani ini, form ini hanya memanggil route yang benar. --}}
            <form action="{{ route('guru.notifikasi.destroy', $notifikasi->id) }}"
                  method="POST" id="delForm" style="display:inline">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6M14 11v6M9 6V4h6v2"/>
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- ── Info Grid ────────────────────────────────────────────────────────── --}}
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
                <p class="info-val status-read">✓ Sudah Dibaca</p>
            @else
                <p class="info-val status-unread">● Belum Dibaca</p>
            @endif
        </div>

        <div class="info-item">
            <p class="info-label">Diterima</p>
            <p class="info-val" style="font-size:13px">
                {{ $notifikasi->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
            </p>
        </div>

        @if($notifikasi->sudah_dibaca && $notifikasi->dibaca_pada)
        <div class="info-item">
            <p class="info-label">Dibaca Pada</p>
            <p class="info-val" style="font-size:13px">
                {{ $notifikasi->dibaca_pada->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
            </p>
        </div>
        @endif

    </div>

    {{-- ── Detail Card ──────────────────────────────────────────────────────── --}}
    <div class="detail-card">
        <div class="detail-header">

            {{-- FIX: Gunakan CSS class untuk warna icon; SVG pakai currentColor --}}
            <div class="detail-icon icon-{{ $notifikasi->jenis }}">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
            </div>

            <div style="flex:1;min-width:0">
                <p class="detail-title">{{ $notifikasi->judul }}</p>
                <div class="detail-meta">
                    <span>{{ $notifikasi->created_at->locale('id')->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <div class="detail-body">
            <p class="detail-message">{{ $notifikasi->pesan }}</p>

            {{-- FIX: Gunakan field yang benar: url_tujuan (bukan ->url yang tidak ada di model) --}}
            @if($notifikasi->url_tujuan)
            <div style="margin-top:20px">
                <a href="{{ $notifikasi->url_tujuan }}" target="_blank" rel="noopener noreferrer"
                   class="btn btn-link">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                        <polyline points="15 3 21 3 21 9"/>
                        <line x1="10" y1="14" x2="21" y2="3"/>
                    </svg>
                    Buka Tautan Terkait
                </a>
            </div>
            @endif
        </div>
    </div>

</div>{{-- /page --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({
    icon: 'success', title: 'Berhasil!',
    text: @json(session('success')),
    timer: 2800, showConfirmButton: false,
    toast: true, position: 'top-end'
});
@endif
@if(session('error'))
Swal.fire({
    icon: 'error', title: 'Gagal!',
    text: @json(session('error')),
    confirmButtonColor: '#1f63db'
});
@endif

function confirmDelete() {
    Swal.fire({
        title: 'Hapus Notifikasi?',
        html: `Notifikasi ini akan dihapus permanen dan tidak bisa dikembalikan.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
    }).then(result => {
        if (result.isConfirmed) {
            document.getElementById('delForm').submit();
        }
    });
}
</script>
</x-app-layout>