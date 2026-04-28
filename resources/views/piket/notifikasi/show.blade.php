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
        --green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fff0f0;--red-border:#fecaca;
        --piket-700:#b45309;--piket-100:#fef3c7;--piket-50:#fffbeb;
    }
    .page{padding:28px 28px 48px;max-width:2000px;margin:0 auto}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-red{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}

    /* Notif card */
    .notif-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .notif-card-top{padding:28px 28px 24px;border-bottom:1px solid var(--border)}
    .notif-icon-big{width:56px;height:56px;border-radius:14px;background:var(--surface3);display:flex;align-items:center;justify-content:center;font-size:26px;margin-bottom:16px}
    .notif-jenis-badge{display:inline-flex;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;margin-bottom:10px}
    .notif-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--text);line-height:1.3;margin-bottom:8px}
    .notif-waktu{font-size:12.5px;color:var(--text3);display:flex;align-items:center;gap:6px}

    .notif-card-body{padding:24px 28px}
    .notif-pesan{font-family:'DM Sans',sans-serif;font-size:14.5px;color:var(--text2);line-height:1.8;white-space:pre-wrap}

    /* URL tujuan */
    .notif-link-bar{display:flex;align-items:center;gap:10px;padding:12px 16px;background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm);margin-top:20px}
    .notif-link-bar a{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--brand-600);text-decoration:none}
    .notif-link-bar a:hover{text-decoration:underline}

    /* Actions */
    .notif-actions-bar{display:flex;gap:8px;flex-wrap:wrap;padding:16px 28px;border-top:1px solid var(--border);background:var(--surface2)}

    @media(max-width:640px){.page{padding:16px}.notif-card-top,.notif-card-body,.notif-actions-bar{padding-left:16px;padding-right:16px}}
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Notifikasi</h1>
            <p class="page-sub">{{ $notifikasi->created_at->locale('id')->isoFormat('dddd, D MMMM Y · H:mm') }}</p>
        </div>
        <a href="{{ route('piket.notifikasi.index') }}" class="btn btn-secondary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    @php
        $iconJenis = [
            'info'        => '💬',
            'peringatan'  => '⚠️',
            'pelanggaran' => '🚨',
            'absensi'     => '📅',
            'nilai'       => '📊',
            'pengumuman'  => '📢',
            'tugas'       => '📝',
            'ujian'       => '📋',
        ];
        $warnaBadge = [
            'info'        => 'background:#eff6ff;color:#1d4ed8',
            'peringatan'  => 'background:#fefce8;color:#a16207',
            'pelanggaran' => 'background:#fff0f0;color:#dc2626',
            'absensi'     => 'background:#f0fdf4;color:#15803d',
            'nilai'       => 'background:#fdf4ff;color:#7c3aed',
            'pengumuman'  => 'background:#fff7ed;color:#c2410c',
            'tugas'       => 'background:#f0fdf4;color:#15803d',
            'ujian'       => 'background:#eff6ff;color:#1d4ed8',
        ];
    @endphp

    <div class="notif-card">
        <div class="notif-card-top">
            <div class="notif-icon-big">
                {{ $iconJenis[$notifikasi->jenis] ?? '🔔' }}
            </div>
            <div class="notif-jenis-badge" style="{{ $warnaBadge[$notifikasi->jenis] ?? 'background:var(--surface3);color:var(--text2)' }}">
                {{ ucfirst($notifikasi->jenis) }}
            </div>
            <p class="notif-judul">{{ $notifikasi->judul }}</p>
            <p class="notif-waktu">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ $notifikasi->created_at->locale('id')->isoFormat('D MMMM Y, H:mm') }}
                · {{ $notifikasi->created_at->locale('id')->diffForHumans() }}
                @if($notifikasi->sudah_dibaca)
                    · <span style="color:var(--green);font-weight:700">✓ Sudah dibaca</span>
                @else
                    · <span style="color:var(--red);font-weight:700">Belum dibaca</span>
                @endif
            </p>
        </div>

        <div class="notif-card-body">
            <p class="notif-pesan">{{ $notifikasi->pesan }}</p>

            @if($notifikasi->url_tujuan)
            <div class="notif-link-bar">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                <a href="{{ $notifikasi->url_tujuan }}">Buka halaman terkait →</a>
            </div>
            @endif
        </div>

        <div class="notif-actions-bar">
            <a href="{{ route('piket.notifikasi.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali ke Daftar
            </a>
            <form method="POST" action="{{ route('piket.notifikasi.destroy', $notifikasi->id) }}"
                onsubmit="return confirm('Hapus notifikasi ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-red">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                    Hapus Notifikasi
                </button>
            </form>
        </div>
    </div>

</div>
</x-app-layout>