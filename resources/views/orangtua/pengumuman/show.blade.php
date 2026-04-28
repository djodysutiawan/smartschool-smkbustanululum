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
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3)}

    .layout{display:grid;grid-template-columns:1fr 280px;gap:20px;align-items:start}

    /* Main card */
    .main-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .main-header{padding:22px 26px;border-bottom:1px solid var(--border)}

    .back-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px}
    .breadcrumb{font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text3);display:flex;align-items:center;gap:5px}
    .breadcrumb a{color:var(--text3);text-decoration:none}
    .breadcrumb a:hover{color:var(--or-600)}

    .badge-row{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:12px}
    .badge{display:inline-flex;align-items:center;gap:3px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .b-pinned{background:#fef9c3;color:#a16207;border:1px solid #fde68a}
    .b-target{background:var(--or-50);color:var(--or-700)}

    .peng-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.35;margin-bottom:14px}
    .meta-row{display:flex;flex-wrap:wrap;gap:14px}
    .meta-item{display:flex;align-items:center;gap:5px;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3)}

    /* Content */
    .content-area{padding:26px}
    .peng-isi{font-family:'DM Sans',sans-serif;font-size:15px;color:var(--text2);line-height:1.85;white-space:pre-wrap}

    /* Lampiran */
    .lampiran-box{margin-top:24px;padding:14px 18px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);display:flex;align-items:center;gap:12px}
    .lampiran-icon{width:38px;height:38px;background:var(--or-50);border:1px solid var(--or-100);border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .lampiran-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)}
    .lampiran-link{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--or-600);text-decoration:none}
    .lampiran-link:hover{text-decoration:underline}

    /* Sidebar */
    .sidebar-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:14px}
    .sc-head{padding:12px 16px;border-bottom:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text)}
    .sc-body{padding:14px 16px}

    .info-list{list-style:none;padding:0;margin:0}
    .info-list li{display:flex;justify-content:space-between;gap:10px;padding:7px 0;border-bottom:1px solid #f1f5f9;font-size:12.5px}
    .info-list li:last-child{border-bottom:none}
    .info-key{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text3)}
    .info-val{font-family:'DM Sans',sans-serif;color:var(--text2);text-align:right}

    /* Terkait */
    .terkait-item{display:flex;gap:10px;padding:8px 0;border-bottom:1px solid #f1f5f9;text-decoration:none;transition:background .1s}
    .terkait-item:last-child{border-bottom:none}
    .terkait-item:hover .terkait-judul{color:var(--or-600)}
    .terkait-dot{width:8px;height:8px;border-radius:50%;background:var(--or-400);flex-shrink:0;margin-top:5px}
    .terkait-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text);line-height:1.4;transition:color .15s}
    .terkait-tgl{font-size:11px;color:var(--text3);font-family:'DM Sans',sans-serif;margin-top:2px}

    @media(max-width:800px){.layout{grid-template-columns:1fr}.page{padding:16px}}
</style>

<div class="page">
    <div class="layout">

        {{-- Main --}}
        <div>
            <div class="main-card">
                <div class="main-header">
                    <div class="back-row">
                        <div class="breadcrumb">
                            <a href="{{ route('ortu.pengumuman.index') }}">Pengumuman</a>
                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            <span>{{ Str::limit($pengumuman->judul, 40) }}</span>
                        </div>
                        <a href="{{ route('ortu.pengumuman.index') }}" class="btn btn-secondary">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                            Kembali
                        </a>
                    </div>

                    <div class="badge-row">
                        @if($pengumuman->dipinned)
                            <span class="badge b-pinned">📌 Disematkan</span>
                        @endif
                        <span class="badge b-target">
                            {{ $pengumuman->target_role === 'semua' ? 'Semua Pengguna' : 'Orang Tua' }}
                        </span>
                    </div>

                    <h1 class="peng-judul">{{ $pengumuman->judul }}</h1>

                    <div class="meta-row">
                        <span class="meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ $pengumuman->dipublikasikan_pada?->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </span>
                        <span class="meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            {{ $pengumuman->dibuatOleh->name ?? 'Admin' }}
                        </span>
                        @if($pengumuman->kadaluarsa_pada)
                        <span class="meta-item" style="color:{{ $pengumuman->kadaluarsa_pada->isPast() ? '#dc2626' : 'var(--text3)' }}">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Berlaku s/d {{ $pengumuman->kadaluarsa_pada->locale('id')->isoFormat('D MMM Y') }}
                        </span>
                        @endif
                    </div>
                </div>

                <div class="content-area">
                    <div class="peng-isi">{{ $pengumuman->isi }}</div>

                    @if($pengumuman->path_lampiran)
                    <div class="lampiran-box">
                        <div class="lampiran-icon">
                            <svg width="18" height="18" fill="none" stroke="var(--or-600)" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        </div>
                        <div>
                            <p class="lampiran-label">Lampiran</p>
                            <a href="{{ $pengumuman->lampiran_url }}" target="_blank" download class="lampiran-link">
                                Unduh Lampiran
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            <div class="sidebar-card">
                <div class="sc-head">Informasi</div>
                <div class="sc-body">
                    <ul class="info-list">
                        <li>
                            <span class="info-key">Diterbitkan</span>
                            <span class="info-val">{{ $pengumuman->dipublikasikan_pada?->locale('id')->isoFormat('D MMM Y') }}</span>
                        </li>
                        <li>
                            <span class="info-key">Target</span>
                            <span class="info-val">{{ $pengumuman->target_role === 'semua' ? 'Semua' : 'Orang Tua' }}</span>
                        </li>
                        @if($pengumuman->kadaluarsa_pada)
                        <li>
                            <span class="info-key">Berlaku s/d</span>
                            <span class="info-val" style="{{ $pengumuman->kadaluarsa_pada->isPast() ? 'color:#dc2626' : '' }}">
                                {{ $pengumuman->kadaluarsa_pada->locale('id')->isoFormat('D MMM Y') }}
                            </span>
                        </li>
                        @endif
                        <li>
                            <span class="info-key">Disematkan</span>
                            <span class="info-val">{{ $pengumuman->dipinned ? '📌 Ya' : 'Tidak' }}</span>
                        </li>
                        <li>
                            <span class="info-key">Dibuat oleh</span>
                            <span class="info-val">{{ $pengumuman->dibuatOleh->name ?? 'Admin' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            @if($terkait->count() > 0)
            <div class="sidebar-card">
                <div class="sc-head">Pengumuman Lainnya</div>
                <div class="sc-body" style="padding-top:8px;padding-bottom:8px">
                    @foreach($terkait as $t)
                    <a href="{{ route('ortu.pengumuman.show', $t) }}" class="terkait-item">
                        <div class="terkait-dot"></div>
                        <div>
                            <p class="terkait-judul">{{ $t->judul }}</p>
                            <p class="terkait-tgl">{{ $t->dipublikasikan_pada?->locale('id')->isoFormat('D MMM Y') }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

    </div>
</div>
</x-app-layout>