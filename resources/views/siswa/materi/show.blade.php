<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Lora:ital,wght@0,400;0,500;1,400&display=swap');

    :root {
        --blue-700:#1750c0;--blue-600:#1f63db;--blue-500:#3582f0;
        --blue-100:#dbeafe;--blue-50:#eff6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#334155;--text3:#64748b;--text4:#94a3b8;
        --radius:12px;--radius-sm:8px;--radius-xs:6px;
        --shadow:0 1px 3px rgba(0,0,0,.07),0 1px 2px rgba(0,0,0,.05);
        --shadow-md:0 4px 12px rgba(0,0,0,.08),0 2px 4px rgba(0,0,0,.04);
    }

    *, *::before, *::after { box-sizing: border-box; }

    .mk-page {
        padding: 28px 24px 64px;
        max-width: 1160px;
        margin: 0 auto;
    }

    /* ── Breadcrumb & back ── */
    .mk-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 12px;
        flex-wrap: wrap;
    }
    .mk-breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px;
        color: var(--text4);
    }
    .mk-breadcrumb a {
        color: var(--text3);
        text-decoration: none;
        transition: color .15s;
    }
    .mk-breadcrumb a:hover { color: var(--blue-600); }
    .mk-breadcrumb svg { opacity: .5; flex-shrink: 0; }
    .mk-breadcrumb .crumb-current {
        color: var(--text2);
        font-weight: 600;
        max-width: 220px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .mk-back {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 14px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xs);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text3);
        text-decoration: none;
        transition: all .15s;
        box-shadow: var(--shadow);
    }
    .mk-back:hover { background: var(--surface3); color: var(--text2); }

    /* ── Layout ── */
    .mk-layout {
        display: grid;
        grid-template-columns: 1fr 284px;
        gap: 20px;
        align-items: start;
    }

    /* ── Main card ── */
    .mk-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    /* ── Header ── */
    .mk-header {
        padding: 22px 24px 18px;
        border-bottom: 1px solid var(--border);
    }
    .mk-mapel-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        background: var(--blue-50);
        color: var(--blue-700);
        border: 1px solid var(--blue-100);
        border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        margin-bottom: 12px;
    }
    .mk-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 21px;
        font-weight: 800;
        color: var(--text);
        line-height: 1.35;
        margin: 0 0 14px;
    }

    .mk-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px 18px;
        align-items: center;
    }
    .mk-meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        color: var(--text3);
    }
    .mk-meta-item svg { flex-shrink: 0; opacity: .7; }

    /* Jenis badge */
    .mk-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11.5px;
        font-weight: 700;
        border: 1px solid;
    }
    .mk-badge-file   { background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe; }
    .mk-badge-video  { background:#fff1f2; color:#be123c; border-color:#fecdd3; }
    .mk-badge-link   { background:#f5f3ff; color:#6d28d9; border-color:#ddd6fe; }
    .mk-badge-teks   { background:#f0fdf4; color:#15803d; border-color:#bbf7d0; }
    .mk-badge-default{ background:#f8fafc; color:#475569; border-color:#e2e8f0; }

    /* ── Deskripsi ── */
    .mk-body { padding: 22px 24px; }
    .mk-desc {
        background: var(--surface2);
        border-left: 3px solid var(--blue-500);
        border-radius: 0 var(--radius-xs) var(--radius-xs) 0;
        padding: 13px 16px;
        margin-bottom: 20px;
        font-family: 'Lora', serif;
        font-size: 13.5px;
        color: var(--text2);
        line-height: 1.75;
        font-style: italic;
    }

    /* ── Konten box ── */
    .mk-konten {
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        overflow: hidden;
    }
    .mk-konten-head {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 10px 15px;
        background: var(--surface2);
        border-bottom: 1px solid var(--border);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: var(--text3);
        letter-spacing: .03em;
        text-transform: uppercase;
    }
    .mk-konten-body { padding: 22px; }

    /* Teks konten */
    .mk-teks {
        font-family: 'Lora', serif;
        font-size: 14.5px;
        color: var(--text);
        line-height: 1.9;
        white-space: pre-wrap;
    }

    /* Video */
    .mk-video-wrap {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        border-radius: var(--radius-xs);
        background: #000;
    }
    .mk-video-wrap iframe,
    .mk-video-wrap video {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        border: none;
        border-radius: var(--radius-xs);
    }

    /* Link / File action */
    .mk-action-group {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    .mk-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 12px 22px;
        border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all .15s;
        box-shadow: var(--shadow);
    }
    .mk-btn-download {
        background: var(--blue-600);
        color: #fff;
    }
    .mk-btn-download:hover {
        background: var(--blue-700);
        box-shadow: var(--shadow-md);
        transform: translateY(-1px);
    }
    .mk-btn-link {
        background: var(--surface);
        color: var(--blue-600);
        border: 1.5px solid var(--blue-500);
    }
    .mk-btn-link:hover {
        background: var(--blue-50);
    }

    .mk-action-meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .mk-action-filename {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        font-weight: 600;
        color: var(--text3);
    }
    .mk-action-url {
        font-family: monospace;
        font-size: 11.5px;
        color: var(--text4);
        word-break: break-all;
        max-width: 480px;
    }

    .mk-kosong {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        color: var(--text4);
        font-style: italic;
        text-align: center;
        padding: 16px 0;
    }

    /* ── Sidebar ── */
    .mk-sidebar-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 14px;
    }
    .mk-sc-head {
        padding: 11px 16px;
        border-bottom: 1px solid var(--border);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: var(--text3);
        letter-spacing: .04em;
        text-transform: uppercase;
        background: var(--surface2);
    }
    .mk-sc-body { padding: 14px 16px; }

    /* Info list */
    .mk-info-list {
        list-style: none;
        padding: 0; margin: 0;
    }
    .mk-info-list li {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        padding: 7px 0;
        border-bottom: 1px solid var(--surface3);
        font-size: 12.5px;
    }
    .mk-info-list li:last-child { border-bottom: none; }
    .mk-info-key {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        color: var(--text4);
        flex-shrink: 0;
    }
    .mk-info-val {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text2);
        text-align: right;
        font-weight: 500;
    }

    /* Download sidebar shortcut */
    .mk-dl-shortcut {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 14px;
        background: var(--blue-50);
        border: 1px solid var(--blue-100);
        border-radius: var(--radius-xs);
        text-decoration: none;
        transition: all .15s;
        margin-top: 4px;
    }
    .mk-dl-shortcut:hover {
        background: var(--blue-100);
        border-color: var(--blue-500);
    }
    .mk-dl-shortcut-icon {
        width: 32px; height: 32px;
        background: var(--blue-600);
        border-radius: var(--radius-xs);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        color: #fff;
    }
    .mk-dl-shortcut-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px;
        font-weight: 700;
        color: var(--blue-700);
    }
    .mk-dl-shortcut-sub {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px;
        color: var(--text4);
        margin-top: 1px;
    }

    /* Materi terkait */
    .mk-terkait-item {
        display: flex;
        gap: 10px;
        padding: 9px 0;
        border-bottom: 1px solid var(--surface3);
        text-decoration: none;
        transition: background .1s;
    }
    .mk-terkait-item:last-child { border-bottom: none; }
    .mk-terkait-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--blue-500);
        flex-shrink: 0;
        margin-top: 6px;
    }
    .mk-terkait-judul {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px;
        font-weight: 700;
        color: var(--text);
        line-height: 1.45;
        transition: color .15s;
    }
    .mk-terkait-item:hover .mk-terkait-judul { color: var(--blue-600); }
    .mk-terkait-sub {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px;
        color: var(--text4);
        margin-top: 2px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    @media (max-width: 840px) {
        .mk-layout { grid-template-columns: 1fr; }
        .mk-page { padding: 16px 14px 48px; }
        .mk-title { font-size: 18px; }
    }
</style>

<div class="mk-page">

    {{-- Top bar: breadcrumb + tombol kembali --}}
    <div class="mk-topbar">
        <nav class="mk-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('siswa.materi.index') }}">Materi</a>
            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
            <span class="crumb-current">{{ Str::limit($materi->judul, 40) }}</span>
        </nav>
        <a href="{{ route('siswa.materi.index') }}" class="mk-back">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <div class="mk-layout">

        {{-- ═══ Main ═══ --}}
        <main>
            <article class="mk-card">

                {{-- Header --}}
                <header class="mk-header">
                    <div class="mk-mapel-tag">
                        <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        {{ optional($materi->mataPelajaran)->nama_mapel ?? 'Mata Pelajaran' }}
                    </div>

                    <h1 class="mk-title">{{ $materi->judul }}</h1>

                    @php
                        $jenisValid = \App\Models\Materi::JENIS_VALID;
                        $jenisCss   = in_array($materi->jenis, $jenisValid, true) ? $materi->jenis : 'default';
                        $jenisIcon  = match($materi->jenis) {
                            'file'  => '<svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>',
                            'video' => '<svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>',
                            'link'  => '<svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>',
                            'teks'  => '<svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>',
                            default => '<svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>',
                        };
                    @endphp

                    <div class="mk-meta">
                        <span class="mk-badge mk-badge-{{ $jenisCss }}">
                            {!! $jenisIcon !!}
                            {{ ucfirst($materi->jenis) }}
                        </span>

                        @if(optional($materi->guru)->nama_lengkap)
                        <span class="mk-meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            {{ $materi->guru->nama_lengkap }}
                        </span>
                        @endif

                        <span class="mk-meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ ($materi->dipublikasikan_pada ?? $materi->created_at)?->translatedFormat('d F Y') ?? '—' }}
                        </span>
                    </div>
                </header>

                {{-- Body --}}
                <div class="mk-body">

                    @if($materi->deskripsi)
                    <blockquote class="mk-desc">{{ $materi->deskripsi }}</blockquote>
                    @endif

                    <div class="mk-konten">
                        <div class="mk-konten-head">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            Konten Materi
                        </div>
                        <div class="mk-konten-body">

                            @switch($materi->jenis)

                                {{-- ── TEKS ── --}}
                                @case('teks')
                                    @if($materi->konten_teks_display ?? $materi->konten_teks)
                                        <div class="mk-teks">{{ $materi->konten_teks_display ?? $materi->konten_teks }}</div>
                                    @else
                                        <p class="mk-kosong">Tidak ada konten teks.</p>
                                    @endif
                                @break

                                {{-- ── LINK ── --}}
                                @case('link')
                                    @if($materi->url_eksternal)
                                        <div class="mk-action-group">
                                            <a href="{{ $materi->url_eksternal }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="mk-action-btn mk-btn-link">
                                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                                Buka Link Materi
                                            </a>
                                            <div class="mk-action-meta">
                                                <span class="mk-action-url">{{ $materi->url_eksternal }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <p class="mk-kosong">Link tidak tersedia.</p>
                                    @endif
                                @break

                                {{-- ── VIDEO ── --}}
                                @case('video')
                                    @if($materi->youtube_id ?? false)
                                        <div class="mk-video-wrap">
                                            <iframe
                                                src="https://www.youtube-nocookie.com/embed/{{ $materi->youtube_id }}"
                                                frameborder="0"
                                                allowfullscreen
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                loading="lazy"
                                                title="{{ $materi->judul }}"
                                            ></iframe>
                                        </div>
                                    @elseif($materi->path_file)
                                        <div class="mk-video-wrap">
                                            <video controls preload="metadata" style="border-radius:8px">
                                                <source src="{{ asset('storage/' . $materi->path_file) }}">
                                                Browser Anda tidak mendukung pemutaran video.
                                            </video>
                                        </div>
                                    @elseif($materi->url_eksternal)
                                        <div class="mk-action-group">
                                            <a href="{{ $materi->url_eksternal }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="mk-action-btn mk-btn-link">
                                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                                                Buka Video
                                            </a>
                                        </div>
                                    @else
                                        <p class="mk-kosong">Video tidak tersedia.</p>
                                    @endif
                                @break

                                {{-- ── FILE — tombol unduh lewat route download() ── --}}
                                @case('file')
                                    @if($materi->path_file)
                                        @php
                                            $ekstensi = strtoupper(pathinfo($materi->path_file, PATHINFO_EXTENSION));
                                        @endphp
                                        <div class="mk-action-group">
                                            {{--
                                                Gunakan route siswa.materi.download (bukan asset storage langsung).
                                                Ini memastikan auth check dijalankan dan file di-stream
                                                dengan nama yang bersih oleh MateriController::download().
                                            --}}
                                            <a href="{{ route('siswa.materi.download', $materi) }}"
                                               class="mk-action-btn mk-btn-download">
                                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                                Unduh File Materi
                                            </a>
                                            <div class="mk-action-meta">
                                                @if($ekstensi)
                                                <span class="mk-action-filename">Format: {{ $ekstensi }}</span>
                                                @endif
                                                <span class="mk-action-url">{{ basename($materi->path_file) }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <p class="mk-kosong">File tidak tersedia.</p>
                                    @endif
                                @break

                                @default
                                    <p class="mk-kosong">Jenis materi tidak dikenal.</p>

                            @endswitch

                        </div>
                    </div>
                </div>

            </article>
        </main>

        {{-- ═══ Sidebar ═══ --}}
        <aside>

            {{-- Info materi --}}
            <div class="mk-sidebar-card">
                <div class="mk-sc-head">Informasi</div>
                <div class="mk-sc-body">
                    <ul class="mk-info-list">
                        <li>
                            <span class="mk-info-key">Mapel</span>
                            <span class="mk-info-val">{{ optional($materi->mataPelajaran)->nama_mapel ?? '—' }}</span>
                        </li>
                        <li>
                            <span class="mk-info-key">Guru</span>
                            <span class="mk-info-val">{{ optional($materi->guru)->nama_lengkap ?? '—' }}</span>
                        </li>
                        <li>
                            <span class="mk-info-key">Kelas</span>
                            <span class="mk-info-val">{{ optional($materi->kelas)->nama ?? '—' }}</span>
                        </li>
                        <li>
                            <span class="mk-info-key">Jenis</span>
                            <span class="mk-info-val">{{ $materi->label_jenis ?? ucfirst($materi->jenis) }}</span>
                        </li>
                        <li>
                            <span class="mk-info-key">Publikasi</span>
                            <span class="mk-info-val">
                                {{ ($materi->dipublikasikan_pada ?? $materi->created_at)?->translatedFormat('d M Y') ?? '—' }}
                            </span>
                        </li>
                        @if($materi->tahunAjaran)
                        <li>
                            <span class="mk-info-key">T. Ajaran</span>
                            <span class="mk-info-val">{{ $materi->tahunAjaran->nama ?? '—' }}</span>
                        </li>
                        @endif
                    </ul>

                    {{-- Shortcut download di sidebar — hanya tampil untuk jenis file --}}
                    @if($materi->jenis === 'file' && $materi->path_file)
                    <a href="{{ route('siswa.materi.download', $materi) }}"
                       class="mk-dl-shortcut">
                        <span class="mk-dl-shortcut-icon" aria-hidden="true">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        </span>
                        <div>
                            <div class="mk-dl-shortcut-label">Unduh File</div>
                            <div class="mk-dl-shortcut-sub">
                                {{ strtoupper(pathinfo($materi->path_file, PATHINFO_EXTENSION)) ?: 'File' }}
                                · {{ basename($materi->path_file) }}
                            </div>
                        </div>
                    </a>
                    @endif
                </div>
            </div>

            {{-- Materi terkait --}}
            @if($materiTerkait->isNotEmpty())
            <div class="mk-sidebar-card">
                <div class="mk-sc-head">Materi Lainnya</div>
                <div class="mk-sc-body" style="padding-top:8px;padding-bottom:8px">
                    @foreach($materiTerkait as $mt)
                    <a href="{{ route('siswa.materi.show', $mt) }}" class="mk-terkait-item">
                        <div class="mk-terkait-dot"></div>
                        <div>
                            <p class="mk-terkait-judul">{{ $mt->judul }}</p>
                            <p class="mk-terkait-sub">
                                <span>{{ $mt->label_jenis ?? ucfirst($mt->jenis) }}</span>
                                <span>·</span>
                                <span>{{ ($mt->dipublikasikan_pada ?? $mt->created_at)?->translatedFormat('d M Y') ?? '—' }}</span>
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </aside>

    </div>
</div>
</x-app-layout>