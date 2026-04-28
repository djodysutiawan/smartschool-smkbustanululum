<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --piket-700:#b45309;--piket-600:#d97706;--piket-100:#fef3c7;--piket-50:#fffbeb;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
        --green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;
    }
    .page{padding:28px 28px 48px;margin:0 auto}
    .page-inner{display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;max-width:1100px;margin:0 auto}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;max-width:1100px;margin-left:auto;margin-right:auto}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-detail{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}

    /* Main card */
    .main-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .main-card-top{padding:28px 30px 24px;border-bottom:1px solid var(--border)}
    .peng-badges{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px}
    .peng-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .peng-badge.pin{background:var(--piket-50);color:var(--piket-700);border:1px solid var(--piket-100)}
    .peng-badge.semua{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}
    .peng-badge.piket{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .peng-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.35;margin-bottom:14px}
    .peng-meta-row{display:flex;align-items:center;gap:14px;flex-wrap:wrap}
    .peng-meta-item{display:flex;align-items:center;gap:5px;font-size:12.5px;color:var(--text3)}
    .peng-meta-item strong{color:var(--text2);font-weight:600}

    /* Isi konten */
    .main-card-body{padding:28px 30px}
    .peng-isi{font-family:'DM Sans',sans-serif;font-size:14.5px;color:var(--text2);line-height:1.85}
    .peng-isi p{margin-bottom:14px}
    .peng-isi p:last-child{margin-bottom:0}
    .peng-isi h1,.peng-isi h2,.peng-isi h3{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;color:var(--text);margin-bottom:10px;margin-top:20px}
    .peng-isi ul,.peng-isi ol{padding-left:20px;margin-bottom:14px}
    .peng-isi li{margin-bottom:6px}
    .peng-isi strong{color:var(--text);font-weight:700}
    .peng-isi a{color:var(--brand-600);text-decoration:underline}

    .main-card-footer{padding:14px 30px;border-top:1px solid var(--border);background:var(--surface2);display:flex;gap:8px}

    /* Sidebar */
    .sidebar-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:14px}
    .sidebar-card-header{padding:12px 16px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .sidebar-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:800;color:var(--text)}
    .sidebar-item{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-bottom:1px solid #f1f5f9;text-decoration:none;transition:background .1s}
    .sidebar-item:last-child{border-bottom:none}
    .sidebar-item:hover{background:var(--surface2)}
    .sidebar-item-icon{width:30px;height:30px;border-radius:7px;background:var(--surface3);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:14px}
    .sidebar-item-icon.pin{background:var(--piket-50)}
    .sidebar-item-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text);line-height:1.3;margin-bottom:3px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
    .sidebar-item-tanggal{font-size:11px;color:var(--text3)}
    .sidebar-empty{padding:18px 16px;text-align:center;font-size:12.5px;color:var(--text3)}

    @media(max-width:900px){
        .page-inner{grid-template-columns:1fr}
        .page{padding:16px}
        .main-card-top,.main-card-body,.main-card-footer{padding-left:18px;padding-right:18px}
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Pengumuman</h1>
            <p class="page-sub">{{ $pengumuman->dipublikasikan_pada->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
        </div>
        <a href="{{ route('piket.pengumuman.index') }}" class="btn btn-secondary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <div class="page-inner">

        {{-- Konten Utama --}}
        <div>
            <div class="main-card">
                <div class="main-card-top">

                    {{-- Badges --}}
                    <div class="peng-badges">
                        @if($pengumuman->dipinned)
                            <span class="peng-badge pin">
                                <svg width="10" height="10" fill="var(--piket-600)" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                Disematkan
                            </span>
                        @endif
                        <span class="peng-badge {{ $pengumuman->target_role === 'semua' ? 'semua' : 'piket' }}">
                            {{ $pengumuman->target_role === 'semua' ? '👥 Semua' : '🛡️ Guru Piket' }}
                        </span>
                    </div>

                    {{-- Judul --}}
                    <p class="peng-judul">{{ $pengumuman->judul }}</p>

                    {{-- Meta --}}
                    <div class="peng-meta-row">
                        <span class="peng-meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $pengumuman->dipublikasikan_pada->locale('id')->isoFormat('D MMMM Y, H:mm') }}
                        </span>
                        @if($pengumuman->dibuatOleh)
                        <span class="peng-meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                            <strong>{{ $pengumuman->dibuatOleh->name }}</strong>
                        </span>
                        @endif
                        @if($pengumuman->kadaluarsa_pada)
                        <span class="peng-meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Berlaku hingga <strong>{{ $pengumuman->kadaluarsa_pada->locale('id')->isoFormat('D MMM Y') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Isi --}}
                <div class="main-card-body">
                    <div class="peng-isi">
                        {!! nl2br(e($pengumuman->isi)) !!}
                    </div>
                </div>

                <div class="main-card-footer">
                    <a href="{{ route('piket.pengumuman.index') }}" class="btn btn-secondary btn-sm">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            <div class="sidebar-card">
                <div class="sidebar-card-header">
                    <p class="sidebar-card-title">Pengumuman Lainnya</p>
                </div>
                @forelse($pengumumanLain as $lain)
                <a href="{{ route('piket.pengumuman.show', $lain->id) }}" class="sidebar-item">
                    <div class="sidebar-item-icon {{ $lain->dipinned ? 'pin' : '' }}">
                        @if($lain->dipinned)
                            <svg width="13" height="13" fill="var(--piket-600)" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        @else
                            <svg width="13" height="13" fill="none" stroke="var(--text3)" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        @endif
                    </div>
                    <div style="flex:1;min-width:0">
                        <p class="sidebar-item-judul">{{ $lain->judul }}</p>
                        <p class="sidebar-item-tanggal">{{ $lain->dipublikasikan_pada->locale('id')->isoFormat('D MMM Y') }}</p>
                    </div>
                </a>
                @empty
                <p class="sidebar-empty">Tidak ada pengumuman lain</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
</x-app-layout>