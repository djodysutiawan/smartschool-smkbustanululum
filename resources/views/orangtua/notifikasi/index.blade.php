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
    .header-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap}
    .btn-primary{background:var(--or-600);color:#fff}
    .btn-primary:hover{background:var(--or-700)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3)}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}

    /* Filter */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:13px 18px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:9px;align-items:center}
    .filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row select:focus{border-color:var(--or-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--or-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer}
    .btn-filter:hover{background:var(--or-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:background .15s}
    .btn-reset:hover{background:var(--surface3)}

    /* Unread banner */
    .unread-banner{display:flex;align-items:center;justify-content:space-between;gap:12px;background:var(--or-50);border:1px solid var(--or-100);border-radius:var(--radius-sm);padding:11px 16px;margin-bottom:16px;flex-wrap:wrap}
    .unread-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--or-700)}

    /* Notif list */
    .notif-list{display:flex;flex-direction:column;gap:0;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}

    .notif-item{display:flex;align-items:flex-start;gap:14px;padding:15px 18px;border-bottom:1px solid #f1f5f9;text-decoration:none;transition:background .1s;position:relative}
    .notif-item:last-child{border-bottom:none}
    .notif-item:hover{background:#fafbff}
    .notif-item.unread{background:#fafeff}
    .notif-item.unread::before{content:'';position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--or-600);border-radius:2px 0 0 2px}

    .notif-icon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:16px}
    .ni-info{background:#eff6ff}
    .ni-peringatan{background:#fffbeb}
    .ni-nilai{background:#f0fdf4}
    .ni-absensi{background:#f5f3ff}
    .ni-pelanggaran{background:#fff0f0}
    .ni-pengumuman{background:#ecfdf5}

    .notif-content{flex:1;min-width:0}
    .notif-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text);margin-bottom:3px;display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden}
    .notif-item.unread .notif-judul{color:var(--or-700)}
    .notif-pesan{font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text2);display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;line-height:1.5}
    .notif-meta{display:flex;align-items:center;gap:10px;margin-top:6px;flex-wrap:wrap}
    .notif-time{font-family:'DM Sans',sans-serif;font-size:11.5px;color:var(--text3)}
    .badge-jenis{display:inline-flex;padding:2px 8px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700}
    .bj-info{background:#eff6ff;color:#1d4ed8}
    .bj-peringatan{background:#fffbeb;color:#a16207}
    .bj-nilai{background:#f0fdf4;color:#15803d}
    .bj-absensi{background:#f5f3ff;color:#7c3aed}
    .bj-pelanggaran{background:#fee2e2;color:#dc2626}
    .bj-pengumuman{background:#ecfdf5;color:#065f46}

    .notif-actions{display:flex;flex-direction:column;gap:5px;flex-shrink:0;align-items:flex-end}

    /* Alert */
    .alert{display:flex;align-items:flex-start;gap:9px;padding:11px 15px;border-radius:var(--radius-sm);margin-bottom:14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600}
    .a-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d}

    /* Empty */
    .empty-state{padding:64px 20px;text-align:center}
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
            <h1 class="page-title">Notifikasi</h1>
            <p class="page-sub">Informasi dan pemberitahuan untuk Anda</p>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="alert a-success">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Unread banner --}}
    @if($unread > 0)
    <div class="unread-banner">
        <span class="unread-text">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:4px"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            {{ $unread }} notifikasi belum dibaca
        </span>
        <form action="{{ route('ortu.notifikasi.mark-all-read') }}" method="POST">
            @csrf @method('PATCH')
            <button type="submit" class="btn btn-primary btn-sm">Tandai Semua Dibaca</button>
        </form>
    </div>
    @endif

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('ortu.notifikasi.index') }}">
            <div class="filter-row">
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="belum" {{ request('status') === 'belum' ? 'selected' : '' }}>Belum Dibaca</option>
                    <option value="dibaca" {{ request('status') === 'dibaca' ? 'selected' : '' }}>Sudah Dibaca</option>
                </select>
                <select name="jenis">
                    <option value="">Semua Jenis</option>
                    @foreach($jenisList as $j)
                        <option value="{{ $j }}" {{ request('jenis') === $j ? 'selected' : '' }}>{{ ucfirst($j) }}</option>
                    @endforeach
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('ortu.notifikasi.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- List --}}
    @if($notifikasis->count() > 0)
    <div class="notif-list">
        @foreach($notifikasis as $n)
        @php
            $icons = [
                'info'        => ['🔵', 'ni-info'],
                'peringatan'  => ['⚠️', 'ni-peringatan'],
                'nilai'       => ['📊', 'ni-nilai'],
                'absensi'     => ['📋', 'ni-absensi'],
                'pelanggaran' => ['⚡', 'ni-pelanggaran'],
                'pengumuman'  => ['📢', 'ni-pengumuman'],
            ];
            [$ikon, $iconClass] = $icons[$n->jenis] ?? ['🔔', 'ni-info'];
        @endphp
        <div class="notif-item {{ !$n->sudah_dibaca ? 'unread' : '' }}">
            <div class="notif-icon {{ $iconClass }}">{{ $ikon }}</div>
            <div class="notif-content">
                <a href="{{ route('ortu.notifikasi.show', $n) }}" style="text-decoration:none">
                    <p class="notif-judul">{{ $n->judul }}</p>
                    <p class="notif-pesan">{{ $n->pesan }}</p>
                </a>
                <div class="notif-meta">
                    <span class="badge-jenis bj-{{ $n->jenis }}">{{ ucfirst($n->jenis) }}</span>
                    <span class="notif-time">{{ $n->created_at->diffForHumans() }}</span>
                    @if($n->sudah_dibaca)
                        <span style="font-family:'DM Sans',sans-serif;font-size:11px;color:var(--text3)">
                            Dibaca {{ $n->dibaca_pada?->diffForHumans() }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="notif-actions">
                @if(!$n->sudah_dibaca)
                <form action="{{ route('ortu.notifikasi.mark-read', $n) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-secondary btn-sm" title="Tandai dibaca">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </button>
                </form>
                @endif
                <form action="{{ route('ortu.notifikasi.destroy', $n) }}" method="POST"
                      onsubmit="return confirm('Hapus notifikasi ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm" style="background:#fff0f0;color:#dc2626;border:1px solid #fecaca" title="Hapus">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($notifikasis->hasPages())
    <div class="pag-wrap">
        <p class="pag-info">Menampilkan {{ $notifikasis->firstItem() }}–{{ $notifikasis->lastItem() }} dari {{ $notifikasis->total() }}</p>
        <div class="pag-btns">
            @if($notifikasis->onFirstPage())
                <span class="pag-btn disabled"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
            @else
                <a href="{{ $notifikasis->previousPageUrl() }}" class="pag-btn"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
            @endif
            @foreach($notifikasis->getUrlRange(1, $notifikasis->lastPage()) as $page => $url)
                @if($page == $notifikasis->currentPage())
                    <span class="pag-btn active">{{ $page }}</span>
                @elseif($page == 1 || $page == $notifikasis->lastPage() || abs($page - $notifikasis->currentPage()) <= 1)
                    <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                @elseif(abs($page - $notifikasis->currentPage()) == 2)
                    <span class="pag-ellipsis">…</span>
                @endif
            @endforeach
            @if($notifikasis->hasMorePages())
                <a href="{{ $notifikasis->nextPageUrl() }}" class="pag-btn"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
            @else
                <span class="pag-btn disabled"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
            @endif
        </div>
    </div>
    @endif

    @else
    <div class="notif-list">
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            </div>
            <p class="empty-title">Tidak ada notifikasi</p>
            <p class="empty-sub">Notifikasi akan muncul di sini ketika ada pemberitahuan baru</p>
        </div>
    </div>
    @endif

</div>
</x-app-layout>