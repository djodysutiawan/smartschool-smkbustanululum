<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 48px;max-width:2000px}
    .breadcrumb{display:flex;align-items:center;gap:6px;margin-bottom:20px;flex-wrap:wrap}
    .breadcrumb a{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--brand-600);text-decoration:none}
    .breadcrumb a:hover{text-decoration:underline}
    .breadcrumb-sep{color:var(--text3);font-size:12px}
    .breadcrumb-cur{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3)}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-danger{background:#fff1f2;color:#dc2626;border:1px solid #fecdd3}
    .btn-danger:hover{background:#ffe4e6;filter:none}

    .notif-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .notif-card-top{padding:24px;border-bottom:1px solid var(--border)}
    .notif-header{display:flex;align-items:flex-start;gap:14px;margin-bottom:16px}
    .notif-icon-big{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .icon-info      {background:#eff6ff}
    .icon-peringatan{background:#fef9c3}
    .icon-nilai     {background:#f0fdf4}
    .icon-absensi   {background:#fff7ed}
    .icon-tugas     {background:#fdf4ff}
    .icon-pengumuman{background:#f0fdf4}

    .notif-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:17px;font-weight:800;color:var(--text);line-height:1.35;margin-bottom:6px}
    .notif-badge-row{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
    .notif-jenis{display:inline-flex;align-items:center;padding:2px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .jenis-info      {background:#eff6ff;color:#1d4ed8}
    .jenis-peringatan{background:#fef9c3;color:#a16207}
    .jenis-nilai     {background:#dcfce7;color:#15803d}
    .jenis-absensi   {background:#fff7ed;color:#c2410c}
    .jenis-tugas     {background:#fdf4ff;color:#7c3aed}
    .jenis-pengumuman{background:#f0fdf4;color:#15803d}
    .notif-time{font-size:12px;color:var(--text3)}

    .notif-body{padding:24px;font-family:'DM Sans',sans-serif;font-size:14.5px;color:var(--text2);line-height:1.75;white-space:pre-line}

    .notif-meta-bar{padding:14px 24px;background:var(--surface2);border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}
    .meta-left{font-size:12px;color:var(--text3)}
    .meta-left strong{color:var(--text2);font-weight:600}
    .footer-actions{display:flex;gap:8px}

    @media(max-width:640px){.page{padding:16px}}
</style>

<div class="page">

    <div class="breadcrumb">
        <a href="{{ route('siswa.notifikasi.index') }}">Notifikasi</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-cur">Detail</span>
    </div>

    <div class="notif-card">
        <div class="notif-card-top">
            <div class="notif-header">
                {{-- Icon --}}
                <div class="notif-icon-big icon-{{ $notifikasi->jenis ?? 'info' }}">
                    @switch($notifikasi->jenis ?? 'info')
                        @case('peringatan')
                            <svg width="22" height="22" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            @break
                        @case('nilai')
                            <svg width="22" height="22" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            @break
                        @case('absensi')
                            <svg width="22" height="22" fill="none" stroke="#c2410c" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            @break
                        @case('tugas')
                            <svg width="22" height="22" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
                            @break
                        @case('pengumuman')
                            <svg width="22" height="22" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            @break
                        @default
                            <svg width="22" height="22" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    @endswitch
                </div>

                <div>
                    <h1 class="notif-title">{{ $notifikasi->judul }}</h1>
                    <div class="notif-badge-row">
                        @if($notifikasi->jenis)
                            <span class="notif-jenis jenis-{{ $notifikasi->jenis }}">{{ ucfirst($notifikasi->jenis) }}</span>
                        @endif
                        <span class="notif-time">
                            {{ \Carbon\Carbon::parse($notifikasi->created_at)->translatedFormat('d F Y, H:i') }}
                            &middot; {{ \Carbon\Carbon::parse($notifikasi->created_at)->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Isi pesan --}}
        <div class="notif-body">{{ $notifikasi->pesan }}</div>

        {{-- Footer --}}
        <div class="notif-meta-bar">
            <div class="meta-left">
                Dibaca:
                @if($notifikasi->sudah_dibaca && $notifikasi->dibaca_pada)
                    <strong>{{ \Carbon\Carbon::parse($notifikasi->dibaca_pada)->translatedFormat('d F Y, H:i') }}</strong>
                @else
                    <strong>Baru saja dibaca</strong>
                @endif
            </div>
            <div class="footer-actions">
                {{-- Hapus --}}
                <form action="{{ route('siswa.notifikasi.destroy', $notifikasi->id) }}" method="POST"
                      onsubmit="return confirm('Hapus notifikasi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6M14 11v6"/>
                        </svg>
                        Hapus
                    </button>
                </form>
                <a href="{{ route('siswa.notifikasi.index') }}" class="btn btn-secondary">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')),
    timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
@endif
</script>
</x-app-layout>