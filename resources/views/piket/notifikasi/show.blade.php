<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');

    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
        --green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fff0f0;--red-border:#fecaca;
    }

    .page { padding: 28px 28px 56px; max-width: 720px; margin: 0 auto; }
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2; }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; font-family: 'DM Sans', sans-serif; }

    /* ── Buttons ── */
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s, background .15s; white-space: nowrap; line-height: 1; }
    .btn:hover { filter: brightness(.93); }
    .btn-secondary { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-secondary:hover { background: var(--surface3); filter: none; }
    .btn-danger { background: var(--red-bg); color: var(--red); border: 1px solid var(--red-border); }
    .btn-danger:hover { background: #fee2e2; filter: none; }

    /* ── Notif card ── */
    .notif-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; box-shadow: 0 1px 4px rgba(15,23,42,.04); }

    .notif-card-top { padding: 28px 28px 24px; border-bottom: 1px solid var(--border); }

    .notif-icon-big {
        width: 56px; height: 56px; border-radius: 14px;
        background: var(--surface3); border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        font-size: 26px; margin-bottom: 16px;
    }

    .notif-jenis-badge {
        display: inline-flex; padding: 3px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
        margin-bottom: 10px;
    }

    .notif-judul {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 18px;
        font-weight: 800; color: var(--text); line-height: 1.35; margin-bottom: 10px;
    }

    .notif-meta-row {
        display: flex; align-items: center; flex-wrap: wrap; gap: 10px;
        font-size: 12.5px; color: var(--text3); font-family: 'DM Sans', sans-serif;
    }
    .notif-meta-item { display: flex; align-items: center; gap: 5px; }
    .badge-read { display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; }
    .badge-read.sudah { background: var(--green-bg); color: var(--green); border: 1px solid var(--green-border); }
    .badge-read.belum { background: var(--red-bg); color: var(--red); border: 1px solid var(--red-border); }

    /* ── Body ── */
    .notif-card-body { padding: 24px 28px; }

    .notif-pesan {
        font-family: 'DM Sans', sans-serif; font-size: 15px;
        color: var(--text2); line-height: 1.85; white-space: pre-wrap;
        word-break: break-word;
    }

    /* Link tujuan */
    .notif-link-bar {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px; background: var(--brand-50);
        border: 1px solid var(--brand-100); border-radius: var(--radius-sm);
        margin-top: 20px;
    }
    .notif-link-bar svg { flex-shrink: 0; }
    .notif-link-bar a {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px;
        font-weight: 700; color: var(--brand-600); text-decoration: none;
        word-break: break-all;
    }
    .notif-link-bar a:hover { text-decoration: underline; }

    /* ── Actions bar ── */
    .notif-actions-bar {
        display: flex; gap: 8px; flex-wrap: wrap;
        padding: 14px 28px; border-top: 1px solid var(--border);
        background: var(--surface2); align-items: center;
    }
    .actions-spacer { flex: 1; }

    /* ── Nav breadcrumb ── */
    .breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--text3);
        margin-bottom: 16px; flex-wrap: wrap;
    }
    .breadcrumb a { color: var(--brand-600); text-decoration: none; font-weight: 500; }
    .breadcrumb a:hover { text-decoration: underline; }
    .breadcrumb-sep { color: var(--text3); }

    @media (max-width: 640px) {
        .page { padding: 14px 14px 40px; }
        .notif-card-top, .notif-card-body, .notif-actions-bar { padding-left: 16px; padding-right: 16px; }
        .notif-judul { font-size: 16px; }
    }
</style>

<div class="page">

    {{-- ── Breadcrumb ── --}}
    <nav class="breadcrumb" aria-label="Navigasi">
        <a href="{{ route('piket.notifikasi.index') }}">Notifikasi</a>
        <span class="breadcrumb-sep">›</span>
        <span>Detail</span>
    </nav>

    {{-- ── Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Notifikasi</h1>
            <p class="page-sub">{{ $notifikasi->created_at->locale('id')->isoFormat('dddd, D MMMM Y · H:mm') }}</p>
        </div>
        <a href="{{ route('piket.notifikasi.index') }}" class="btn btn-secondary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
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

        {{-- ── Top section ── --}}
        <div class="notif-card-top">
            <div class="notif-icon-big" aria-hidden="true">
                {{ $iconJenis[$notifikasi->jenis] ?? '🔔' }}
            </div>

            <span class="notif-jenis-badge"
                  style="{{ $warnaBadge[$notifikasi->jenis] ?? 'background:var(--surface3);color:var(--text2)' }}">
                {{ ucfirst($notifikasi->jenis) }}
            </span>

            <p class="notif-judul">{{ $notifikasi->judul }}</p>

            <div class="notif-meta-row">
                <span class="notif-meta-item">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                    {{ $notifikasi->created_at->locale('id')->isoFormat('D MMMM Y, H:mm') }}
                </span>
                <span class="notif-meta-item" title="Waktu relatif">
                    · {{ $notifikasi->created_at->locale('id')->diffForHumans() }}
                </span>
                <span class="badge-read {{ $notifikasi->sudah_dibaca ? 'sudah' : 'belum' }}">
                    @if($notifikasi->sudah_dibaca)
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Sudah dibaca
                    @else
                        <svg width="9" height="9" fill="currentColor" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5"/></svg>
                        Belum dibaca
                    @endif
                </span>
                @if($notifikasi->sudah_dibaca && $notifikasi->dibaca_pada)
                <span class="notif-meta-item" style="font-size:11.5px;color:var(--text3)">
                    · Dibaca {{ $notifikasi->dibaca_pada->locale('id')->diffForHumans() }}
                </span>
                @endif
            </div>
        </div>

        {{-- ── Isi pesan ── --}}
        <div class="notif-card-body">
            <p class="notif-pesan">{{ $notifikasi->pesan }}</p>

            {{-- Link tujuan jika ada --}}
            @if($notifikasi->url_tujuan)
            <div class="notif-link-bar">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                    <polyline points="15 3 21 3 21 9"/>
                    <line x1="10" y1="14" x2="21" y2="3"/>
                </svg>
                <a href="{{ $notifikasi->url_tujuan }}" target="_blank" rel="noopener noreferrer">
                    Buka halaman terkait →
                </a>
            </div>
            @endif
        </div>

        {{-- ── Action bar ── --}}
        <div class="notif-actions-bar">
            <a href="{{ route('piket.notifikasi.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali ke Daftar
            </a>

            {{-- Spacer mendorong tombol hapus ke kanan --}}
            <span class="actions-spacer"></span>

            {{-- Hapus — redirect ke index setelah dihapus (sudah ditangani di controller) --}}
            <form method="POST" action="{{ route('piket.notifikasi.destroy', $notifikasi->id) }}"
                onsubmit="return confirm('Hapus notifikasi ini? Tindakan tidak dapat dibatalkan.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6"/><path d="M14 11v6"/>
                    </svg>
                    Hapus Notifikasi
                </button>
            </form>
        </div>

    </div>{{-- /.notif-card --}}

</div>{{-- /.page --}}
</x-app-layout>