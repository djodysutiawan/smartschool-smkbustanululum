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

    .pg-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}

    .pg-header{padding:28px 32px;border-bottom:1px solid var(--border)}
    .pg-meta-top{display:flex;align-items:center;gap:8px;margin-bottom:14px;flex-wrap:wrap}
    .pg-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;background:var(--brand-50);color:var(--brand-700)}
    .pg-new{background:#dcfce7;color:#15803d}
    .pg-date{font-size:12.5px;color:var(--text3);display:flex;align-items:center;gap:4px}
    .pg-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.35}

    .pg-body{padding:28px 32px;font-family:'DM Sans',sans-serif;font-size:15px;color:var(--text2);line-height:1.8}
    /* Prose styling jika isi adalah HTML */
    .pg-body h1,.pg-body h2,.pg-body h3{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;color:var(--text);margin:20px 0 10px}
    .pg-body h1{font-size:20px}
    .pg-body h2{font-size:17px}
    .pg-body h3{font-size:15px}
    .pg-body p{margin-bottom:12px}
    .pg-body ul,.pg-body ol{padding-left:20px;margin-bottom:12px}
    .pg-body li{margin-bottom:4px}
    .pg-body strong{font-weight:700;color:var(--text)}
    .pg-body a{color:var(--brand-600);text-decoration:underline}
    .pg-body blockquote{border-left:3px solid var(--brand-100);padding:10px 16px;background:var(--brand-50);border-radius:0 6px 6px 0;margin:14px 0;color:var(--text2)}

    .pg-footer{padding:16px 32px;border-top:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}
    .pg-footer-meta{font-size:12px;color:var(--text3)}
    .pg-footer-meta strong{color:var(--text2)}

    @media(max-width:640px){
        .page{padding:16px}
        .pg-header,.pg-body,.pg-footer{padding-left:18px;padding-right:18px}
        .pg-title{font-size:18px}
    }
</style>

<div class="page">

    <div class="breadcrumb">
        <a href="{{ route('siswa.pengumuman.index') }}">Pengumuman</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-cur">Detail</span>
    </div>

    <div class="pg-card">

        <div class="pg-header">
            <div class="pg-meta-top">
                <span class="pg-badge">
                    <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    Pengumuman
                </span>
                @if(\Carbon\Carbon::parse($pengumuman->created_at)->gte(now()->subDays(3)))
                    <span class="pg-badge pg-new">Baru</span>
                @endif
                <span class="pg-date">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    {{ \Carbon\Carbon::parse($pengumuman->created_at)->translatedFormat('l, d F Y') }}
                </span>
            </div>
            <h1 class="pg-title">{{ $pengumuman->judul }}</h1>
        </div>

        <div class="pg-body">
            {{--
                Jika kolom isi/konten berisi HTML (dari rich text editor), gunakan {!! !!}
                Jika plain text, gunakan {{ }} dengan nl2br
            --}}
            @if($pengumuman->isi)
                {!! nl2br(e($pengumuman->isi)) !!}
            @else
                <p style="color:var(--text3);font-style:italic">Tidak ada isi pengumuman.</p>
            @endif
        </div>

        <div class="pg-footer">
            <div class="pg-footer-meta">
                Diterbitkan
                <strong>{{ \Carbon\Carbon::parse($pengumuman->created_at)->translatedFormat('d F Y, H:i') }}</strong>
                &middot;
                {{ \Carbon\Carbon::parse($pengumuman->created_at)->diffForHumans() }}
            </div>
            <a href="{{ route('siswa.pengumuman.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

</div>
</x-app-layout>