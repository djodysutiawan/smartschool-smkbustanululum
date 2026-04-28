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

    .page{padding:28px 28px 48px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    /* Search bar */
    .search-bar{margin-bottom:20px}
    .search-form{display:flex;gap:8px;flex-wrap:wrap}
    .search-input{flex:1;min-width:200px;height:38px;padding:0 14px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s}
    .search-input:focus{border-color:var(--brand-500);box-shadow:0 0 0 3px rgba(53,130,240,.1)}
    .btn-search{height:38px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;display:inline-flex;align-items:center;gap:6px}
    .btn-search:hover{background:var(--brand-700)}
    .btn-reset{height:38px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:background .15s}
    .btn-reset:hover{background:var(--surface3)}

    /* Grid kartu pengumuman */
    .pg-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:14px;margin-bottom:20px}
    .pg-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;text-decoration:none;display:block;transition:box-shadow .2s,border-color .2s}
    .pg-card:hover{box-shadow:0 6px 20px rgba(0,0,0,.07);border-color:var(--border2)}
    .pg-card-body{padding:18px 20px}
    .pg-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text);margin-bottom:7px;line-height:1.4}
    .pg-isi{font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2);line-height:1.6;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;margin-bottom:12px}
    .pg-meta{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
    .pg-date{font-size:12px;color:var(--text3);display:flex;align-items:center;gap:4px}
    .pg-new{display:inline-flex;align-items:center;padding:2px 8px;border-radius:99px;background:#dcfce7;color:#15803d;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700}
    .pg-card-footer{padding:10px 20px;border-top:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between}
    .pg-read-more{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--brand-600);display:flex;align-items:center;gap:4px}

    /* Empty state */
    .empty-state{padding:64px 20px;text-align:center;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius)}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    /* Pagination */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 0;flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s}
    .pag-btn:hover{background:var(--surface2);border-color:var(--border2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;display:flex;align-items:center}

    @media(max-width:640px){
        .page{padding:16px}
        .pg-grid{grid-template-columns:1fr}
    }
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Pengumuman</h1>
            <p class="page-sub">Informasi dan pengumuman dari sekolah</p>
        </div>
    </div>

    {{-- Search --}}
    <div class="search-bar">
        <form method="GET" action="{{ route('siswa.pengumuman.index') }}" class="search-form">
            <input type="text" name="cari" class="search-input"
                value="{{ request('cari') }}"
                placeholder="Cari judul pengumuman…">
            <button type="submit" class="btn-search">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Cari
            </button>
            @if(request('cari'))
                <a href="{{ route('siswa.pengumuman.index') }}" class="btn-reset">Reset</a>
            @endif
        </form>
    </div>

    {{-- Grid --}}
    @if($pengumuman->count() > 0)
    <div class="pg-grid">
        @foreach($pengumuman as $p)
        <a href="{{ route('siswa.pengumuman.show', $p->id) }}" class="pg-card">
            <div class="pg-card-body">
                <h2 class="pg-judul">{{ $p->judul }}</h2>
                <p class="pg-isi">{{ strip_tags($p->isi ?? $p->konten ?? '') }}</p>
                <div class="pg-meta">
                    <span class="pg-date">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($p->created_at)->translatedFormat('d F Y') }}
                    </span>
                    @if(\Carbon\Carbon::parse($p->created_at)->gte(now()->subDays(3)))
                        <span class="pg-new">Baru</span>
                    @endif
                </div>
            </div>
            <div class="pg-card-footer">
                <span class="pg-read-more">
                    Baca selengkapnya
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </span>
                <span style="font-size:11.5px;color:var(--text3)">
                    {{ \Carbon\Carbon::parse($p->created_at)->diffForHumans() }}
                </span>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($pengumuman->hasPages())
    <div class="pag-wrap">
        <p class="pag-info">
            Menampilkan {{ $pengumuman->firstItem() }}–{{ $pengumuman->lastItem() }} dari {{ $pengumuman->total() }} pengumuman
        </p>
        <div class="pag-btns">
            @if($pengumuman->onFirstPage())
                <span class="pag-btn disabled">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                </span>
            @else
                <a href="{{ $pengumuman->previousPageUrl() }}" class="pag-btn">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                </a>
            @endif

            @foreach($pengumuman->getUrlRange(1, $pengumuman->lastPage()) as $page => $url)
                @if($page == $pengumuman->currentPage())
                    <span class="pag-btn active">{{ $page }}</span>
                @elseif($page == 1 || $page == $pengumuman->lastPage() || abs($page - $pengumuman->currentPage()) <= 1)
                    <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                @elseif(abs($page - $pengumuman->currentPage()) == 2)
                    <span class="pag-ellipsis">…</span>
                @endif
            @endforeach

            @if($pengumuman->hasMorePages())
                <a href="{{ $pengumuman->nextPageUrl() }}" class="pag-btn">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            @else
                <span class="pag-btn disabled">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </span>
            @endif
        </div>
    </div>
    @endif

    @else
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
        </div>
        <p class="empty-title">
            @if(request('cari'))
                Tidak ada pengumuman untuk "{{ request('cari') }}"
            @else
                Belum ada pengumuman
            @endif
        </p>
        <p class="empty-sub">Pengumuman dari sekolah akan muncul di sini</p>
    </div>
    @endif

</div>
</x-app-layout>