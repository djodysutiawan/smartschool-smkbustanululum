<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --or-700:#1750c0;--or-600:#1f63db;--or-500:#3582f0;--or-100:#d9ebff;--or-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 48px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}

    /* Search */
    .search-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:13px 18px;margin-bottom:16px}
    .search-row{display:flex;gap:9px;align-items:center}
    .search-input{flex:1;height:38px;padding:0 14px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .search-input:focus{border-color:var(--or-500);background:#fff}
    .btn-search{height:38px;padding:0 18px;background:var(--or-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px}
    .btn-search:hover{background:var(--or-700)}
    .btn-reset{height:38px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:background .15s}
    .btn-reset:hover{background:var(--surface3)}

    /* Pengumuman list */
    .peng-list{display:flex;flex-direction:column;gap:12px;margin-bottom:20px}

    .peng-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:box-shadow .2s,transform .2s;text-decoration:none;display:block}
    .peng-card:hover{box-shadow:0 6px 24px rgba(0,0,0,.08);transform:translateY(-1px)}
    .peng-card.pinned{border-color:var(--or-100);border-left:3px solid var(--or-600)}

    .peng-inner{padding:18px 20px}
    .peng-top{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:10px;flex-wrap:wrap}
    .peng-badges{display:flex;gap:6px;flex-wrap:wrap}
    .badge{display:inline-flex;align-items:center;gap:3px;padding:3px 9px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700}
    .b-pinned{background:#fef9c3;color:#a16207;border:1px solid #fde68a}
    .b-new{background:#dcfce7;color:#15803d}
    .b-target{background:var(--or-50);color:var(--or-700)}

    .peng-tgl{font-family:'DM Sans',sans-serif;font-size:11.5px;color:var(--text3);white-space:nowrap}
    .peng-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text);line-height:1.4;margin-bottom:8px}
    .peng-card:hover .peng-judul{color:var(--or-600)}
    .peng-isi{font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2);line-height:1.6;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;margin-bottom:12px}
    .peng-meta{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px}
    .peng-author{font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text3);display:flex;align-items:center;gap:5px}
    .peng-link{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--or-600);display:flex;align-items:center;gap:4px}

    /* Empty */
    .empty-state{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:64px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3);font-family:'DM Sans',sans-serif}

    /* Pagination */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif}
    .pag-btns{display:flex;gap:4px}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--or-600);border-color:var(--or-600);color:#fff}
    .pag-btn.disabled{opacity:.4;pointer-events:none}
    .pag-ellipsis{color:var(--text3);padding:0 4px}

    @media(max-width:640px){.page{padding:16px}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Pengumuman</h1>
            <p class="page-sub">Informasi dan pengumuman dari sekolah</p>
        </div>
    </div>

    {{-- Search --}}
    <div class="search-card">
        <form method="GET" action="{{ route('ortu.pengumuman.index') }}">
            <div class="search-row">
                <input type="text" name="cari" class="search-input"
                       value="{{ request('cari') }}"
                       placeholder="Cari judul pengumuman…">
                @if(request('cari'))
                    <a href="{{ route('ortu.pengumuman.index') }}" class="btn-reset">Reset</a>
                @endif
                <button type="submit" class="btn-search">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Cari
                </button>
            </div>
        </form>
    </div>

    {{-- List --}}
    @if($pengumuman->count() > 0)
    <div class="peng-list">
        @foreach($pengumuman as $p)
        <a href="{{ route('ortu.pengumuman.show', $p) }}" class="peng-card {{ $p->dipinned ? 'pinned' : '' }}">
            <div class="peng-inner">
                <div class="peng-top">
                    <div class="peng-badges">
                        @if($p->dipinned)
                            <span class="badge b-pinned">📌 Disematkan</span>
                        @endif
                        @if($p->dipublikasikan_pada && $p->dipublikasikan_pada->isAfter(now()->subDays(3)))
                            <span class="badge b-new">🆕 Baru</span>
                        @endif
                        <span class="badge b-target">
                            {{ $p->target_role === 'semua' ? 'Semua' : 'Orang Tua' }}
                        </span>
                    </div>
                    <span class="peng-tgl">{{ $p->dipublikasikan_pada?->locale('id')->isoFormat('D MMM Y') }}</span>
                </div>
                <h3 class="peng-judul">{{ $p->judul }}</h3>
                <p class="peng-isi">{{ strip_tags($p->isi) }}</p>
                <div class="peng-meta">
                    <span class="peng-author">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        {{ $p->dibuatOleh->name ?? 'Admin' }}
                    </span>
                    <span class="peng-link">
                        Baca Selengkapnya
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($pengumuman->hasPages())
    <div class="pag-wrap">
        <p class="pag-info">Menampilkan {{ $pengumuman->firstItem() }}–{{ $pengumuman->lastItem() }} dari {{ $pengumuman->total() }} pengumuman</p>
        <div class="pag-btns">
            @if($pengumuman->onFirstPage())
                <span class="pag-btn disabled"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
            @else
                <a href="{{ $pengumuman->previousPageUrl() }}" class="pag-btn"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
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
                <a href="{{ $pengumuman->nextPageUrl() }}" class="pag-btn"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
            @else
                <span class="pag-btn disabled"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
            @endif
        </div>
    </div>
    @endif

    @else
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </div>
        <p class="empty-title">Belum ada pengumuman</p>
        <p class="empty-sub">Pengumuman dari sekolah akan muncul di sini</p>
    </div>
    @endif

</div>
</x-app-layout>