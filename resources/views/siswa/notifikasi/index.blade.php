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

    .page{padding:28px 28px 48px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-mark-all{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);font-size:12.5px;padding:7px 14px}
    .btn-mark-all:hover{background:var(--brand-100);filter:none}

    /* Filter tabs */
    .filter-tabs{display:flex;gap:6px;margin-bottom:20px;flex-wrap:wrap}
    .tab{display:inline-flex;align-items:center;gap:5px;padding:6px 14px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;border:1px solid var(--border);background:var(--surface);color:var(--text2);text-decoration:none;transition:all .15s}
    .tab:hover{background:var(--surface2)}
    .tab.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .tab-count{display:inline-flex;align-items:center;justify-content:center;min-width:18px;height:18px;padding:0 5px;border-radius:99px;font-size:11px;font-weight:800}
    .tab.active .tab-count{background:rgba(255,255,255,.25);color:#fff}
    .tab:not(.active) .tab-count{background:var(--surface3);color:var(--text2)}

    /* Notif list */
    .notif-list{display:flex;flex-direction:column;gap:0;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .notif-item{display:flex;gap:14px;padding:16px 20px;border-bottom:1px solid var(--border);cursor:pointer;text-decoration:none;transition:background .12s;position:relative}
    .notif-item:last-child{border-bottom:none}
    .notif-item:hover{background:#fafbff}
    .notif-item.unread{background:var(--brand-50)}
    .notif-item.unread:hover{background:#e0effe}

    .unread-dot{position:absolute;top:18px;right:18px;width:8px;height:8px;border-radius:50%;background:var(--brand-500)}

    .notif-icon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px}
    .icon-info      {background:#eff6ff}
    .icon-peringatan{background:#fef9c3}
    .icon-nilai     {background:#f0fdf4}
    .icon-absensi   {background:#fff7ed}
    .icon-tugas     {background:#fdf4ff}
    .icon-pengumuman{background:#f0fdf4}

    .notif-body{flex:1;min-width:0}
    .notif-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text);margin-bottom:3px;
        white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .notif-item.unread .notif-judul{color:var(--brand-700)}
    .notif-pesan{font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text2);line-height:1.5;
        display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
    .notif-meta{display:flex;align-items:center;gap:8px;margin-top:5px;flex-wrap:wrap}
    .notif-time{font-size:11.5px;color:var(--text3)}
    .notif-jenis{display:inline-flex;align-items:center;padding:1px 8px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700}
    .jenis-info      {background:#eff6ff;color:#1d4ed8}
    .jenis-peringatan{background:#fef9c3;color:#a16207}
    .jenis-nilai     {background:#dcfce7;color:#15803d}
    .jenis-absensi   {background:#fff7ed;color:#c2410c}
    .jenis-tugas     {background:#fdf4ff;color:#7c3aed}
    .jenis-pengumuman{background:#f0fdf4;color:#15803d}

    /* Topbar */
    .list-topbar{display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .list-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}

    /* Empty state */
    .empty-state{padding:64px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    /* Pagination */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s}
    .pag-btn:hover{background:var(--surface2);border-color:var(--border2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;display:flex;align-items:center}

    @media(max-width:640px){.page{padding:16px}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Notifikasi</h1>
            <p class="page-sub">
                @if($unread > 0)
                    {{ $unread }} notifikasi belum dibaca
                @else
                    Semua notifikasi sudah dibaca
                @endif
            </p>
        </div>
        <div class="header-actions">
            @if($unread > 0)
                <form action="{{ route('siswa.notifikasi.mark-all-read') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-mark-all">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Tandai semua dibaca
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Filter tabs --}}
    <div class="filter-tabs">
        <a href="{{ route('siswa.notifikasi.index') }}"
           class="tab {{ !request('status') ? 'active' : '' }}">
            Semua
            <span class="tab-count">{{ $notifikasis->total() }}</span>
        </a>
        <a href="{{ route('siswa.notifikasi.index', ['status' => 'belum_dibaca']) }}"
           class="tab {{ request('status') === 'belum_dibaca' ? 'active' : '' }}">
            Belum dibaca
            @if($unread > 0)<span class="tab-count">{{ $unread }}</span>@endif
        </a>
        <a href="{{ route('siswa.notifikasi.index', ['status' => 'dibaca']) }}"
           class="tab {{ request('status') === 'dibaca' ? 'active' : '' }}">
            Sudah dibaca
        </a>
    </div>

    {{-- List --}}
    <div class="notif-list">
        <div class="list-topbar">
            <p class="list-info">
                @if($notifikasis->total() > 0)
                    Menampilkan {{ $notifikasis->firstItem() }}–{{ $notifikasis->lastItem() }} dari {{ $notifikasis->total() }}
                @else
                    Tidak ada notifikasi
                @endif
            </p>
        </div>

        @forelse($notifikasis as $n)
        <a href="{{ route('siswa.notifikasi.show', $n->id) }}"
           class="notif-item {{ !$n->sudah_dibaca ? 'unread' : '' }}">

            {{-- Icon berdasarkan jenis --}}
            <div class="notif-icon icon-{{ $n->jenis ?? 'info' }}">
                @switch($n->jenis ?? 'info')
                    @case('peringatan')
                        <svg width="17" height="17" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        @break
                    @case('nilai')
                        <svg width="17" height="17" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        @break
                    @case('absensi')
                        <svg width="17" height="17" fill="none" stroke="#c2410c" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        @break
                    @case('tugas')
                        <svg width="17" height="17" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><line x1="9" y1="12" x2="15" y2="12"/><line x1="9" y1="16" x2="13" y2="16"/></svg>
                        @break
                    @case('pengumuman')
                        <svg width="17" height="17" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        @break
                    @default
                        <svg width="17" height="17" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                @endswitch
            </div>

            <div class="notif-body">
                <p class="notif-judul">{{ $n->judul }}</p>
                <p class="notif-pesan">{{ $n->pesan }}</p>
                <div class="notif-meta">
                    <span class="notif-time">
                        {{ \Carbon\Carbon::parse($n->created_at)->diffForHumans() }}
                    </span>
                    @if($n->jenis)
                        <span class="notif-jenis jenis-{{ $n->jenis }}">{{ ucfirst($n->jenis) }}</span>
                    @endif
                </div>
            </div>

            @if(!$n->sudah_dibaca)
                <div class="unread-dot"></div>
            @endif
        </a>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
            </div>
            <p class="empty-title">Tidak ada notifikasi</p>
            <p class="empty-sub">Semua notifikasi akan muncul di sini</p>
        </div>
        @endforelse

        {{-- Pagination --}}
        @if($notifikasis->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">
                Halaman {{ $notifikasis->currentPage() }} dari {{ $notifikasis->lastPage() }}
            </p>
            <div class="pag-btns">
                @if($notifikasis->onFirstPage())
                    <span class="pag-btn disabled">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $notifikasis->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
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
                    <a href="{{ $notifikasis->nextPageUrl() }}" class="pag-btn">
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