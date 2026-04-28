<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --sk-700:#1750c0;--sk-600:#1f63db;--sk-500:#3582f0;--sk-400:#60a5fa;
        --sk-100:#d9ebff;--sk-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 48px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}

    /* Filter */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:13px 18px;margin-bottom:20px}
    .filter-row{display:flex;flex-wrap:wrap;gap:9px;align-items:center}
    .filter-row input,.filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row input:focus,.filter-row select:focus{border-color:var(--sk-500);background:#fff}
    .filter-row input[type=text]{min-width:220px}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--sk-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer}
    .btn-filter:hover{background:var(--sk-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:background .15s}
    .btn-reset:hover{background:var(--surface3)}

    /* Grid materi */
    .materi-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:14px;margin-bottom:20px}

    /* Card */
    .materi-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:box-shadow .2s,transform .2s;display:flex;flex-direction:column}
    .materi-card:hover{box-shadow:0 6px 24px rgba(0,0,0,.08);transform:translateY(-2px)}

    .card-thumb{height:10px;width:100%}
    .ct-file{background:linear-gradient(90deg,#3b82f6,#1d4ed8)}
    .ct-video{background:linear-gradient(90deg,#ef4444,#b91c1c)}
    .ct-link{background:linear-gradient(90deg,#8b5cf6,#6d28d9)}
    .ct-teks{background:linear-gradient(90deg,#10b981,#047857)}

    .card-body{padding:16px;flex:1;display:flex;flex-direction:column}
    .card-mapel{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--sk-600);letter-spacing:.05em;text-transform:uppercase;margin-bottom:6px}
    .card-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text);line-height:1.4;margin-bottom:8px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
    .card-deskripsi{font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text2);line-height:1.5;flex:1;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;margin-bottom:12px}

    .card-meta{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:6px}
    .card-guru{font-family:'DM Sans',sans-serif;font-size:11.5px;color:var(--text3)}
    .card-tgl{font-family:'DM Sans',sans-serif;font-size:11px;color:var(--text3)}

    .badge-jenis{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700}
    .bj-file{background:#eff6ff;color:#1d4ed8}
    .bj-video{background:#fff0f0;color:#b91c1c}
    .bj-link{background:#f5f3ff;color:#6d28d9}
    .bj-teks{background:#f0fdf4;color:#047857}

    .card-footer{padding:11px 16px;border-top:1px solid var(--border);background:var(--surface2)}
    .btn-lihat{display:flex;align-items:center;justify-content:center;gap:6px;width:100%;height:34px;background:var(--sk-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;text-decoration:none;transition:background .15s}
    .btn-lihat:hover{background:var(--sk-700)}

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
    .pag-btn.active{background:var(--sk-600);border-color:var(--sk-600);color:#fff}
    .pag-btn.disabled{opacity:.4;pointer-events:none}
    .pag-ellipsis{color:var(--text3);padding:0 4px;font-size:13px}

    @media(max-width:640px){.page{padding:16px}.materi-grid{grid-template-columns:1fr}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Materi Pelajaran</h1>
            <p class="page-sub">Materi yang tersedia untuk kelas Anda</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('siswa.materi.index') }}">
            <div class="filter-row">
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari judul materi…">

                <select name="mapel_id">
                    <option value="">Semua Mapel</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id }}" {{ request('mapel_id') == $m->id ? 'selected' : '' }}>
                            {{ $m->nama_mapel }}
                        </option>
                    @endforeach
                </select>

                <select name="jenis">
                    <option value="">Semua Jenis</option>
                    @foreach($jenisList as $j)
                        <option value="{{ $j }}" {{ request('jenis') == $j ? 'selected' : '' }}>
                            {{ ucfirst($j) }}
                        </option>
                    @endforeach
                </select>

                <div class="filter-sep"></div>
                <a href="{{ route('siswa.materi.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Cari</button>
            </div>
        </form>
    </div>

    {{-- Grid --}}
    @if($materi->count() > 0)
    <div class="materi-grid">
        @foreach($materi as $m)
        <div class="materi-card">
            <div class="card-thumb ct-{{ $m->jenis }}"></div>
            <div class="card-body">
                <p class="card-mapel">{{ $m->mataPelajaran->nama_mapel ?? '—' }}</p>
                <h3 class="card-judul">{{ $m->judul }}</h3>
                <p class="card-deskripsi">{{ $m->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                <div class="card-meta">
                    <span class="badge-jenis bj-{{ $m->jenis }}">
                        @if($m->jenis === 'file') 📄
                        @elseif($m->jenis === 'video') 🎬
                        @elseif($m->jenis === 'link') 🔗
                        @else 📝
                        @endif
                        {{ ucfirst($m->jenis) }}
                    </span>
                    <span class="card-tgl">{{ $m->dipublikasikan_pada?->format('d M Y') ?? $m->created_at->format('d M Y') }}</span>
                </div>
                <p class="card-guru" style="margin-top:8px">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:3px"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    {{ $m->guru->nama_lengkap ?? '—' }}
                </p>
            </div>
            <div class="card-footer">
                <a href="{{ route('siswa.materi.show', $m) }}" class="btn-lihat">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    Lihat Materi
                </a>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($materi->hasPages())
    <div class="pag-wrap">
        <p class="pag-info">Menampilkan {{ $materi->firstItem() }}–{{ $materi->lastItem() }} dari {{ $materi->total() }} materi</p>
        <div class="pag-btns">
            @if($materi->onFirstPage())
                <span class="pag-btn disabled"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
            @else
                <a href="{{ $materi->previousPageUrl() }}" class="pag-btn"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
            @endif
            @foreach($materi->getUrlRange(1, $materi->lastPage()) as $page => $url)
                @if($page == $materi->currentPage())
                    <span class="pag-btn active">{{ $page }}</span>
                @elseif($page == 1 || $page == $materi->lastPage() || abs($page - $materi->currentPage()) <= 1)
                    <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                @elseif(abs($page - $materi->currentPage()) == 2)
                    <span class="pag-ellipsis">…</span>
                @endif
            @endforeach
            @if($materi->hasMorePages())
                <a href="{{ $materi->nextPageUrl() }}" class="pag-btn"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
            @else
                <span class="pag-btn disabled"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
            @endif
        </div>
    </div>
    @endif

    @else
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </div>
        <p class="empty-title">Belum ada materi tersedia</p>
        <p class="empty-sub">Materi pelajaran akan muncul di sini setelah guru mempublikasikannya</p>
    </div>
    @endif

</div>
</x-app-layout>