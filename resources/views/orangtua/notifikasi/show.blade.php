<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --or-700:#1750c0;--or-600:#1f63db;--or-500:#3582f0;--or-100:#d9ebff;--or-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 48px;max-width:2000px;margin:0 auto}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3)}
    .btn-danger{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-danger:hover{background:#fee2e2}

    .back-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px}
    .breadcrumb{font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text3);display:flex;align-items:center;gap:5px}
    .breadcrumb a{color:var(--text3);text-decoration:none}
    .breadcrumb a:hover{color:var(--or-600)}

    .notif-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .notif-header{padding:22px 24px;border-bottom:1px solid var(--border)}

    .badge-jenis{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;margin-bottom:10px}
    .bj-info{background:#eff6ff;color:#1d4ed8}
    .bj-peringatan{background:#fffbeb;color:#a16207}
    .bj-nilai{background:#f0fdf4;color:#15803d}
    .bj-absensi{background:#f5f3ff;color:#7c3aed}
    .bj-pelanggaran{background:#fee2e2;color:#dc2626}
    .bj-pengumuman{background:#ecfdf5;color:#065f46}

    .notif-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.3;margin-bottom:12px}
    .meta-row{display:flex;flex-wrap:wrap;gap:14px}
    .meta-item{display:flex;align-items:center;gap:5px;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3)}

    .notif-body{padding:24px}
    .pesan-box{font-family:'DM Sans',sans-serif;font-size:15px;color:var(--text2);line-height:1.8;white-space:pre-wrap}

    .url-box{margin-top:20px;padding:14px 18px;background:var(--or-50);border:1px solid var(--or-100);border-radius:var(--radius-sm);display:flex;align-items:center;gap:10px}
    .url-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--or-700)}
    .url-link{font-family:'DM Sans',sans-serif;font-size:13px;color:var(--or-600);text-decoration:none;word-break:break-all}
    .url-link:hover{text-decoration:underline}

    .notif-footer{padding:14px 24px;border-top:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}
    .read-info{font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text3);display:flex;align-items:center;gap:6px}
    .rd-dot{width:7px;height:7px;border-radius:50%;background:#15803d}

    @media(max-width:640px){.page{padding:16px}}
</style>

<div class="page">

    <div class="back-row">
        <div class="breadcrumb">
            <a href="{{ route('ortu.notifikasi.index') }}">Notifikasi</a>
            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            <span>Detail</span>
        </div>
        <div style="display:flex;gap:8px">
            <a href="{{ route('ortu.notifikasi.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <form action="{{ route('ortu.notifikasi.destroy', $notifikasi) }}" method="POST"
                  onsubmit="return confirm('Hapus notifikasi ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="notif-card">
        <div class="notif-header">
            <span class="badge-jenis bj-{{ $notifikasi->jenis }}">{{ ucfirst($notifikasi->jenis) }}</span>
            <h1 class="notif-judul">{{ $notifikasi->judul }}</h1>
            <div class="meta-row">
                <span class="meta-item">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ $notifikasi->created_at->locale('id')->isoFormat('dddd, D MMMM Y · HH:mm') }}
                </span>
                <span class="meta-item">
                    {{ $notifikasi->created_at->diffForHumans() }}
                </span>
            </div>
        </div>

        <div class="notif-body">
            <p class="pesan-box">{{ $notifikasi->pesan }}</p>

            @if($notifikasi->url_tujuan)
            <div class="url-box">
                <svg width="14" height="14" fill="none" stroke="var(--or-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                <div>
                    <p class="url-label">Tautan Terkait</p>
                    <a href="{{ $notifikasi->url_tujuan }}" target="_blank" class="url-link">{{ $notifikasi->url_tujuan }}</a>
                </div>
            </div>
            @endif
        </div>

        <div class="notif-footer">
            <div class="read-info">
                <div class="rd-dot"></div>
                <span>Sudah dibaca
                    @if($notifikasi->dibaca_pada)
                        · {{ $notifikasi->dibaca_pada->locale('id')->isoFormat('D MMM Y, HH:mm') }}
                    @endif
                </span>
            </div>
        </div>
    </div>

</div>
</x-app-layout>