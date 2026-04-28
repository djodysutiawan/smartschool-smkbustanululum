<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --piket-700:#b45309;--piket-600:#d97706;--piket-100:#fef3c7;--piket-50:#fffbeb;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
        --green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fff0f0;--red-border:#fecaca;
    }
    .page{padding:28px 28px 48px;max-width:2000px;margin:0 auto}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-detail{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}

    /* Search */
    .search-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;margin-bottom:16px}
    .search-row{display:flex;gap:10px;align-items:center}
    .search-input{flex:1;height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none}
    .search-input:focus{border-color:var(--brand-500);background:#fff}
    .btn-search{height:36px;padding:0 16px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer}
    .btn-reset{height:36px;padding:0 12px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center}

    /* Pinned section */
    .pinned-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:800;color:var(--piket-700);letter-spacing:.06em;text-transform:uppercase;margin-bottom:10px;display:flex;align-items:center;gap:6px}

    /* Card */
    .peng-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:10px;transition:box-shadow .2s,transform .2s;text-decoration:none;display:block}
    .peng-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.08);transform:translateY(-1px)}
    .peng-card.pinned{border-color:var(--piket-600);border-width:2px}
    .peng-card-inner{display:flex;align-items:flex-start;gap:14px;padding:16px 18px}
    .peng-pin-icon{width:36px;height:36px;border-radius:9px;background:var(--piket-50);display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .peng-icon{width:36px;height:36px;border-radius:9px;background:var(--surface3);display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .peng-content{flex:1;min-width:0}
    .peng-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text);line-height:1.3;margin-bottom:5px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .peng-card.pinned .peng-judul{color:var(--piket-700)}
    .peng-preview{font-size:12.5px;color:var(--text2);line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;margin-bottom:8px}
    .peng-meta{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
    .peng-tanggal{font-size:11.5px;color:var(--text3)}
    .peng-badge{display:inline-flex;padding:2px 8px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700}
    .peng-badge.pin{background:var(--piket-50);color:var(--piket-700);border:1px solid var(--piket-100)}
    .peng-badge.semua{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}
    .peng-badge.piket{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .peng-arrow{margin-left:auto;color:var(--text3);flex-shrink:0;padding-top:2px}

    /* Empty */
    .empty-state{padding:60px 20px;text-align:center;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius)}
    .empty-icon{width:54px;height:54px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    /* Pagination */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 0;flex-wrap:wrap;gap:8px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px}
    .pag-btn{height:30px;min-width:30px;padding:0 7px;border-radius:6px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;pointer-events:none}

    @media(max-width:640px){.page{padding:16px}.peng-card-inner{flex-direction:column;gap:10px}}
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Pengumuman</h1>
            <p class="page-sub">Informasi dan pengumuman untuk guru piket</p>
        </div>
        <a href="{{ route('piket.dashboard') }}" class="btn btn-secondary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>
    </div>

    {{-- Search --}}
    <div class="search-card">
        <form method="GET" action="{{ route('piket.pengumuman.index') }}">
            <div class="search-row">
                <input type="text" name="search" class="search-input"
                    placeholder="Cari judul atau isi pengumuman…"
                    value="{{ request('search') }}">
                @if(request('search'))
                    <a href="{{ route('piket.pengumuman.index') }}" class="btn-reset">Reset</a>
                @endif
                <button type="submit" class="btn-search">Cari</button>
            </div>
        </form>
    </div>

    {{-- List --}}
    @if($pengumuman->count())

        @php $pinnedCount = $pengumuman->where('dipinned', true)->count(); @endphp
        @if($pinnedCount && !request('search'))
        <p class="pinned-label">
            <svg width="12" height="12" fill="var(--piket-600)" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Disematkan
        </p>
        @endif

        @foreach($pengumuman as $p)
        <a href="{{ route('piket.pengumuman.show', $p->id) }}" class="peng-card {{ $p->dipinned ? 'pinned' : '' }}">
            <div class="peng-card-inner">
                @if($p->dipinned)
                    <div class="peng-pin-icon">
                        <svg width="16" height="16" fill="var(--piket-600)" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                @else
                    <div class="peng-icon">
                        <svg width="16" height="16" fill="none" stroke="var(--text3)" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                @endif
                <div class="peng-content">
                    <p class="peng-judul">{{ $p->judul }}</p>
                    <p class="peng-preview">{{ Str::limit(strip_tags($p->isi), 120) }}</p>
                    <div class="peng-meta">
                        <span class="peng-tanggal">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:2px"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $p->dipublikasikan_pada->locale('id')->isoFormat('D MMMM Y') }}
                        </span>
                        @if($p->dipinned)
                            <span class="peng-badge pin">📌 Disematkan</span>
                        @endif
                        <span class="peng-badge {{ $p->target_role === 'semua' ? 'semua' : 'piket' }}">
                            {{ $p->target_role === 'semua' ? 'Semua' : 'Guru Piket' }}
                        </span>
                        @if($p->dibuatOleh)
                            <span class="peng-tanggal">· {{ $p->dibuatOleh->name }}</span>
                        @endif
                    </div>
                </div>
                <div class="peng-arrow">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </div>
            </div>
        </a>
        @endforeach

        {{-- Pagination --}}
        @if($pengumuman->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $pengumuman->firstItem() }}–{{ $pengumuman->lastItem() }} dari {{ $pengumuman->total() }}</p>
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
                        <span style="color:var(--text3);padding:0 4px;line-height:30px">…</span>
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
        <p class="empty-sub">
            {{ request('search') ? 'Tidak ada pengumuman yang cocok dengan pencarian "'.request('search').'"' : 'Pengumuman akan muncul di sini' }}
        </p>
    </div>
    @endif

</div>
</x-app-layout>