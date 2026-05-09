<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --sk-700:#1750c0;--sk-600:#1f63db;--sk-500:#3582f0;--sk-100:#d9ebff;--sk-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 48px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3)}
    .btn-primary{background:var(--sk-600);color:#fff}
    .btn-primary:hover{background:var(--sk-700)}

    /* Layout */
    .layout{display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start}

    /* Main card */
    .main-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .main-header{padding:20px 24px;border-bottom:1px solid var(--border)}
    .back-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
    .breadcrumb{font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text3);display:flex;align-items:center;gap:5px}
    .breadcrumb a{color:var(--text3);text-decoration:none}
    .breadcrumb a:hover{color:var(--sk-600)}

    .mapel-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--sk-600);letter-spacing:.06em;text-transform:uppercase;margin-bottom:8px}
    .materi-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.3;margin-bottom:14px}
    .meta-row{display:flex;flex-wrap:wrap;gap:14px;align-items:center}
    .meta-item{display:flex;align-items:center;gap:5px;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3)}

    .badge-jenis{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .bj-file{background:#eff6ff;color:#1d4ed8}
    .bj-video{background:#fff0f0;color:#b91c1c}
    .bj-link{background:#f5f3ff;color:#6d28d9}
    .bj-teks{background:#f0fdf4;color:#047857}
    .bj-default{background:#f1f5f9;color:#475569}

    /* Content area */
    .content-area{padding:24px}
    .deskripsi-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text2);line-height:1.6}

    /* Konten materi */
    .konten-box{border:1px solid var(--border);border-radius:var(--radius-sm);overflow:hidden}
    .konten-head{padding:11px 16px;background:var(--surface2);border-bottom:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);display:flex;align-items:center;gap:7px}
    .konten-body{padding:20px}

    /* Teks */
    .konten-teks{font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text);line-height:1.8;white-space:pre-wrap}

    /* File/Link button */
    .aksi-file{display:inline-flex;align-items:center;gap:8px;padding:11px 20px;background:var(--sk-600);color:#fff;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;text-decoration:none;transition:background .15s}
    .aksi-file:hover{background:var(--sk-700)}
    .aksi-note{margin-top:10px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text3);word-break:break-all}

    /* Video embed */
    .video-wrap{position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:var(--radius-sm)}
    .video-wrap iframe{position:absolute;top:0;left:0;width:100%;height:100%}

    /* Sidebar */
    .sidebar-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:14px}
    .sc-head{padding:12px 16px;border-bottom:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text)}
    .sc-body{padding:14px 16px}

    /* Info list */
    .info-list{list-style:none;padding:0;margin:0}
    .info-list li{display:flex;justify-content:space-between;align-items:flex-start;gap:10px;padding:7px 0;border-bottom:1px solid #f1f5f9;font-size:12.5px}
    .info-list li:last-child{border-bottom:none}
    .info-key{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text3)}
    .info-val{font-family:'DM Sans',sans-serif;color:var(--text2);text-align:right}

    /* Materi terkait */
    .terkait-item{display:flex;gap:10px;padding:8px 0;border-bottom:1px solid #f1f5f9;text-decoration:none;transition:background .1s}
    .terkait-item:last-child{border-bottom:none}
    .terkait-item:hover .terkait-judul{color:var(--sk-600)}
    .terkait-dot{width:8px;height:8px;border-radius:50%;background:var(--sk-400);flex-shrink:0;margin-top:5px}
    .terkait-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text);line-height:1.4;transition:color .15s}
    .terkait-mapel{font-size:11px;color:var(--text3);font-family:'DM Sans',sans-serif;margin-top:2px}

    .konten-kosong{font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text3);font-style:italic}

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
                            <a href="{{ route('siswa.materi.index') }}">Materi</a>
                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            {{-- FIX: Str::limit aman dari null karena judul required di fillable --}}
                            <span>{{ Str::limit($materi->judul, 40) }}</span>
                        </div>
                        <a href="{{ route('siswa.materi.index') }}" class="btn btn-secondary">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                            Kembali
                        </a>
                    </div>

                    {{-- FIX: optional() untuk semua relasi agar tidak error jika null --}}
                    <p class="mapel-label">{{ optional($materi->mataPelajaran)->nama_mapel ?? '—' }}</p>
                    <h1 class="materi-title">{{ $materi->judul }}</h1>

                    @php
                        $jenisValid = \App\Models\Materi::JENIS_VALID;
                        $jenisCss   = in_array($materi->jenis, $jenisValid) ? $materi->jenis : 'default';
                    @endphp

                    <div class="meta-row">
                        <span class="badge-jenis bj-{{ $jenisCss }}">
                            @switch($materi->jenis)
                                @case('file')  📄 @break
                                @case('video') 🎬 @break
                                @case('link')  🔗 @break
                                @case('teks')  📝 @break
                                @default       📁
                            @endswitch
                            {{ ucfirst($materi->jenis) }}
                        </span>
                        <span class="meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            {{ optional($materi->guru)->nama_lengkap ?? '—' }}
                        </span>
                        <span class="meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ ($materi->dipublikasikan_pada ?? $materi->created_at)?->format('d M Y') ?? '—' }}
                        </span>
                    </div>
                </div>

                <div class="content-area">
                    @if($materi->deskripsi)
                    <div class="deskripsi-box">{{ $materi->deskripsi }}</div>
                    @endif

                    <div class="konten-box">
                        <div class="konten-head">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            Konten Materi
                        </div>
                        <div class="konten-body">

                            @switch($materi->jenis)

                                @case('teks')
                                    {{--
                                        FIX: Gunakan accessor kontenTeksDisplay yang sudah handle
                                        fallback konten_teks → url_eksternal → null.
                                        Jangan langsung pakai url_eksternal di view.
                                    --}}
                                    @if($materi->konten_teks_display)
                                        <div class="konten-teks">{{ $materi->konten_teks_display }}</div>
                                    @else
                                        <p class="konten-kosong">Tidak ada konten teks.</p>
                                    @endif
                                @break

                                @case('link')
                                    @if($materi->url_eksternal)
                                        <a href="{{ $materi->url_eksternal }}" target="_blank" rel="noopener noreferrer" class="aksi-file">
                                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                            Buka Link Materi
                                        </a>
                                        <p class="aksi-note">{{ $materi->url_eksternal }}</p>
                                    @else
                                        <p class="konten-kosong">Link tidak tersedia.</p>
                                    @endif
                                @break

                                @case('video')
                                    {{--
                                        FIX: Gunakan accessor youtube_id dari model — mendukung
                                        format watch?v=, youtu.be/, /shorts/, /embed/, /live/.
                                        Lebih aman daripada regex inline di blade.
                                    --}}
                                    @if($materi->youtube_id)
                                        <div class="video-wrap">
                                            <iframe
                                                src="https://www.youtube-nocookie.com/embed/{{ $materi->youtube_id }}"
                                                frameborder="0"
                                                allowfullscreen
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                loading="lazy"
                                            ></iframe>
                                        </div>
                                    @elseif($materi->path_file)
                                        <video controls style="width:100%;border-radius:8px" preload="metadata">
                                            <source src="{{ asset('storage/' . $materi->path_file) }}">
                                            Browser Anda tidak mendukung pemutaran video.
                                        </video>
                                    @elseif($materi->url_eksternal)
                                        <a href="{{ $materi->url_eksternal }}" target="_blank" rel="noopener noreferrer" class="aksi-file">
                                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                                            Buka Video
                                        </a>
                                    @else
                                        <p class="konten-kosong">Video tidak tersedia.</p>
                                    @endif
                                @break

                                @case('file')
                                    @if($materi->path_file)
                                        <a href="{{ asset('storage/' . $materi->path_file) }}" target="_blank" download class="aksi-file">
                                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                            Unduh File Materi
                                        </a>
                                        <p class="aksi-note">Klik tombol di atas untuk mengunduh file materi</p>
                                    @else
                                        <p class="konten-kosong">File tidak tersedia.</p>
                                    @endif
                                @break

                                @default
                                    <p class="konten-kosong">Jenis materi tidak dikenal.</p>

                            @endswitch

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            {{-- Info --}}
            <div class="sidebar-card">
                <div class="sc-head">Informasi Materi</div>
                <div class="sc-body">
                    <ul class="info-list">
                        <li>
                            <span class="info-key">Mata Pelajaran</span>
                            {{-- FIX: optional() untuk semua relasi di sidebar --}}
                            <span class="info-val">{{ optional($materi->mataPelajaran)->nama_mapel ?? '—' }}</span>
                        </li>
                        <li>
                            <span class="info-key">Guru</span>
                            <span class="info-val">{{ optional($materi->guru)->nama_lengkap ?? '—' }}</span>
                        </li>
                        <li>
                            <span class="info-key">Kelas</span>
                            <span class="info-val">{{ optional($materi->kelas)->nama ?? '—' }}</span>
                        </li>
                        <li>
                            <span class="info-key">Jenis</span>
                            {{-- FIX: pakai accessor label_jenis dari model --}}
                            <span class="info-val">{{ $materi->label_jenis }}</span>
                        </li>
                        <li>
                            <span class="info-key">Dipublikasikan</span>
                            <span class="info-val">
                                {{ ($materi->dipublikasikan_pada ?? $materi->created_at)?->format('d M Y') ?? '—' }}
                            </span>
                        </li>
                        {{-- FIX: cek relasi tahunAjaran ada dan tidak null sebelum render --}}
                        @if($materi->tahunAjaran)
                        <li>
                            <span class="info-key">Tahun Ajaran</span>
                            <span class="info-val">{{ $materi->tahunAjaran->nama ?? '—' }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            {{-- Materi terkait --}}
            @if($materiTerkait->count() > 0)
            <div class="sidebar-card">
                <div class="sc-head">Materi Lainnya</div>
                <div class="sc-body" style="padding-top:8px;padding-bottom:8px">
                    @foreach($materiTerkait as $mt)
                    <a href="{{ route('siswa.materi.show', $mt) }}" class="terkait-item">
                        <div class="terkait-dot"></div>
                        <div>
                            <p class="terkait-judul">{{ $mt->judul }}</p>
                            {{-- FIX: pakai accessor label_jenis yang konsisten --}}
                            <p class="terkait-mapel">
                                {{ $mt->label_jenis }}
                                ·
                                {{ ($mt->dipublikasikan_pada ?? $mt->created_at)?->format('d M Y') ?? '—' }}
                            </p>
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