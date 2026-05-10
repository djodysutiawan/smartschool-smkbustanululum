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

    /* ── Badges ────────────────────────────────────────────────────────────── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-semua { background:#eff6ff; color:#1d4ed8; }
    .badge-semua .badge-dot { background:#1d4ed8; }
    .badge-guru  { background:#f0fdf4; color:#15803d; }
    .badge-guru  .badge-dot { background:#15803d; }
    .badge-siswa { background:#fdf4ff; color:#7c3aed; }
    .badge-siswa .badge-dot { background:#7c3aed; }

    /* ── Info Grid ─────────────────────────────────────────────────────────── */
    .info-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:12px;margin-bottom:16px}
    .info-item{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 16px}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:6px}
    .info-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text)}

    /* ── Detail Card ───────────────────────────────────────────────────────── */
    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .detail-header{padding:20px 24px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .detail-headline{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.35;margin-bottom:10px}
    .detail-meta{display:flex;gap:16px;flex-wrap:wrap;align-items:center;font-size:12.5px;color:var(--text3)}
    .detail-meta-item{display:flex;align-items:center;gap:5px}
    .detail-body{padding:28px 24px}

    /* ── Prose ─────────────────────────────────────────────────────────────── */
    .prose{font-family:'DM Sans',sans-serif;font-size:14.5px;color:var(--text2);line-height:1.75}
    .prose p{margin-bottom:12px}
    .prose p:last-child{margin-bottom:0}
    .prose strong{font-weight:700;color:var(--text)}
    .prose ul,.prose ol{margin:8px 0 12px 20px}
    .prose li{margin-bottom:4px}
    .prose h1,.prose h2,.prose h3{font-family:'Plus Jakarta Sans',sans-serif;color:var(--text);font-weight:700;margin:20px 0 8px}
    .prose a{color:var(--brand-600);text-decoration:underline}

    /* ── Lampiran ──────────────────────────────────────────────────────────── */
    .lampiran-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text2);text-decoration:none;transition:background .15s}
    .lampiran-btn:hover{background:var(--surface3)}

    /* ── Kadaluarsa warning ────────────────────────────────────────────────── */
    .expired-notice{display:flex;align-items:center;gap:10px;padding:12px 16px;background:#fff0f0;border:1px solid #fecaca;border-radius:var(--radius-sm);margin-bottom:16px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:#dc2626}

    @media(max-width:640px){
        .page{padding:16px}
        .header-actions{width:100%}
    }
</style>

<div class="page">

    {{-- ── Header ─────────────────────────────────────────────────────────── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Pengumuman</h1>
            <p class="page-sub">Informasi lengkap pengumuman sekolah</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.pengumuman.index') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- ── Info Grid ────────────────────────────────────────────────────────── --}}
    <div class="info-grid">

        <div class="info-item">
            <p class="info-label">Target</p>
            <span class="badge badge-{{ $pengumuman->target_role }}">
                <span class="badge-dot"></span>{{ ucfirst($pengumuman->target_role) }}
            </span>
        </div>

        <div class="info-item">
            <p class="info-label">Dipublikasikan</p>
            <p class="info-val" style="font-size:13px">
                {{ $pengumuman->dipublikasikan_pada
                    ? $pengumuman->dipublikasikan_pada->locale('id')->isoFormat('D MMMM Y, HH:mm')
                    : '—' }}
            </p>
        </div>

        <div class="info-item">
            <p class="info-label">Kadaluarsa</p>
            {{-- FIX: Gunakan accessor $pengumuman->kadaluarsa (dari model) untuk konsistensi --}}
            @if($pengumuman->kadaluarsa_pada)
                <p class="info-val" style="font-size:13px; {{ $pengumuman->kadaluarsa ? 'color:#dc2626' : '' }}">
                    {{ $pengumuman->kadaluarsa_pada->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
                </p>
            @else
                <p class="info-val" style="font-size:13px;color:#15803d">Tidak Kadaluarsa</p>
            @endif
        </div>

        @if($pengumuman->dibuatOleh)
        <div class="info-item">
            <p class="info-label">Dibuat Oleh</p>
            <p class="info-val" style="font-size:13px">{{ $pengumuman->dibuatOleh->name }}</p>
        </div>
        @endif

    </div>

    {{-- ── Detail Card ──────────────────────────────────────────────────────── --}}
    <div class="detail-card">
        <div class="detail-header">
            <h2 class="detail-headline">{{ $pengumuman->judul }}</h2>
            <div class="detail-meta">
                <span class="detail-meta-item">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    {{ $pengumuman->dipublikasikan_pada?->locale('id')->diffForHumans() ?? '—' }}
                </span>
                @if($pengumuman->dibuatOleh)
                <span class="detail-meta-item">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    {{ $pengumuman->dibuatOleh->name }}
                </span>
                @endif
            </div>
        </div>

        <div class="detail-body">

            {{-- ── Isi Pengumuman ──────────────────────────────────────────── --}}
            <div class="prose">
                {{--
                    FIX: Pilih satu pendekatan rendering sesuai sumber data:

                    A) Jika $pengumuman->isi adalah PLAIN TEXT (disimpan sebagai teks biasa):
                       Gunakan nl2br(e()) agar XSS-safe dan baris baru dirender.
                       {!! nl2br(e($pengumuman->isi)) !!}

                    B) Jika $pengumuman->isi adalah HTML dari rich text editor (TipTap, Quill, dll):
                       Gunakan langsung — HTML sudah di-sanitasi saat disimpan (server-side).
                       {!! $pengumuman->isi !!}

                    Kode di bawah mengikuti pendekatan A (plain text) sebagai default aman.
                    Ganti ke B jika field isi menyimpan HTML dari editor.
                --}}
                {!! nl2br(e($pengumuman->isi)) !!}
            </div>

            {{-- ── Lampiran ─────────────────────────────────────────────────── --}}
            {{--
                FIX: Gunakan accessor lampiran_url dari model (getLampiranUrlAttribute)
                daripada Storage::url($pengumuman->lampiran).

                Masalah di kode lama:
                  1. $pengumuman->lampiran → field tidak ada, harusnya path_lampiran
                  2. Storage::url() perlu facade import; accessor model lebih bersih.
            --}}
            @if($pengumuman->lampiran_url)
            <div style="margin-top:24px;padding-top:20px;border-top:1px solid var(--border)">
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:10px">
                    Lampiran
                </p>
                <a href="{{ $pengumuman->lampiran_url }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="lampiran-btn">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    Unduh Lampiran
                </a>
            </div>
            @endif

        </div>
    </div>

</div>{{-- /page --}}
</x-app-layout>