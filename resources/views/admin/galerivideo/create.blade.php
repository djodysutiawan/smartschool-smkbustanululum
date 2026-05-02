<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --danger:#dc2626;--radius:10px;--radius-sm:7px;
    }
    .page { padding:28px 28px 40px; }
    .page-header { display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap; }
    .page-title { font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2; }
    .page-sub   { font-size:12.5px;color:var(--text3);margin-top:3px; }
    .header-actions { display:flex;gap:8px; }

    .btn { display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap; }
    .btn:hover { filter:brightness(.93); }
    .btn-primary { background:var(--brand-600);color:#fff; }
    .btn-ghost   { background:var(--surface2);color:var(--text2);border:1px solid var(--border); }
    .btn-ghost:hover { background:var(--surface3);filter:none; }

    .layout { display:grid;grid-template-columns:1fr 310px;gap:20px;align-items:start; }
    .card { background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden; }
    .card + .card { margin-top:16px; }
    .card-header { padding:14px 20px;border-bottom:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px; }
    .card-body { padding:20px; }

    .form-group { margin-bottom:18px; }
    .form-group:last-child { margin-bottom:0; }
    .form-label { display:block;margin-bottom:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2); }
    .form-label .req { color:var(--danger);margin-left:2px; }
    .form-hint { font-size:11.5px;color:var(--text3);margin-top:4px; }
    .form-control { width:100%;padding:9px 12px;box-sizing:border-box;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s; }
    .form-control:focus { border-color:var(--brand-500);background:#fff; }
    .form-control::placeholder { color:var(--text3); }
    .form-control.is-invalid { border-color:var(--danger); }
    textarea.form-control { resize:vertical;min-height:80px; }
    .invalid-feedback { font-size:11.5px;color:var(--danger);margin-top:4px; }

    /* Sumber tabs */
    .sumber-tabs { display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:20px; }
    .sumber-opt input { position:absolute;opacity:0;width:0;height:0; }
    .sumber-opt { position:relative; }
    .sumber-label { display:flex;align-items:center;gap:8px;padding:10px 14px;border:2px solid var(--border);border-radius:var(--radius);cursor:pointer;transition:all .15s; }
    .sumber-label:hover { border-color:#93c5fd;background:var(--brand-50); }
    .sumber-opt input:checked + .sumber-label { border-color:var(--brand-600);background:var(--brand-50); }
    .sumber-icon { width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
    .sumber-icon.yt { background:#fff0f0; }
    .sumber-icon.vi { background:#fdf4ff; }
    .sumber-icon.up { background:var(--brand-50); }
    .sumber-name { font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text); }

    /* URL parse row */
    .url-parse-row { display:flex;gap:8px; }
    .url-parse-row .form-control { flex:1; }
    .btn-parse { height:39px;padding:0 16px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap;flex-shrink:0; }
    .btn-parse:hover { background:var(--brand-700); }
    .btn-parse:disabled { opacity:.5;cursor:not-allowed; }

    /* Video preview */
    .video-preview-wrap { background:#000;border-radius:var(--radius);overflow:hidden;aspect-ratio:16/9;display:flex;align-items:center;justify-content:center;margin-bottom:14px; }
    .video-preview-wrap iframe { width:100%;height:100%;border:none; }
    .video-preview-placeholder { text-align:center;color:#475569; }

    /* Upload area */
    .upload-area { border:2px dashed var(--border2);border-radius:var(--radius);padding:24px;text-align:center;cursor:pointer;transition:all .15s;position:relative; }
    .upload-area:hover { border-color:var(--brand-500);background:var(--brand-50); }
    .upload-area input[type=file] { position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%; }
    .upload-area-icon { color:var(--text3);margin-bottom:8px; }
    .upload-area-text { font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;color:var(--text3); }
    .upload-area-text strong { color:var(--brand-600); }

    /* Thumb preview */
    .thumb-preview-wrap { border:2px dashed var(--border2);border-radius:var(--radius);padding:16px;text-align:center;cursor:pointer;position:relative;transition:all .15s; }
    .thumb-preview-wrap:hover { border-color:var(--brand-500);background:var(--brand-50); }
    .thumb-preview-wrap input[type=file] { position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%; }
    .thumb-preview-wrap img { max-height:110px;border-radius:6px;object-fit:contain; }

    .toggle-wrap { display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border); }
    .toggle-wrap:last-child { border-bottom:none;padding-bottom:0; }
    .toggle-label { font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text); }
    .toggle-sub   { font-size:11.5px;color:var(--text3); }
    .toggle { position:relative;width:40px;height:22px;flex-shrink:0; }
    .toggle input { opacity:0;width:0;height:0; }
    .toggle-slider { position:absolute;inset:0;background:var(--border2);border-radius:99px;cursor:pointer;transition:background .2s; }
    .toggle-slider::before { content:'';position:absolute;width:16px;height:16px;left:3px;top:3px;background:#fff;border-radius:50%;transition:transform .2s; }
    .toggle input:checked + .toggle-slider { background:var(--brand-600); }
    .toggle input:checked + .toggle-slider::before { transform:translateX(18px); }

    .parse-result { background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm);padding:10px 14px;font-size:12.5px;color:var(--brand-700);margin-top:8px;display:none; }

    @media(max-width:900px){.layout{grid-template-columns:1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Video</h1>
            <p class="page-sub">Tambahkan video baru ke galeri — YouTube, Vimeo, atau upload</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.galeri.video.index') }}" class="btn btn-ghost">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('admin.galeri.video.store') }}" method="POST" enctype="multipart/form-data" id="videoForm">
        @csrf
        <div class="layout">

            {{-- Kiri --}}
            <div>
                {{-- Info Utama --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                        Informasi Video
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Judul Video <span class="req">*</span></label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                                value="{{ old('judul') }}" placeholder="Judul video...">
                            @error('judul')<p class="invalid-feedback">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                rows="3" placeholder="Deskripsi singkat video (opsional)...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')<p class="invalid-feedback">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                                <div>
                                    <label class="form-label">Durasi</label>
                                    <input type="text" name="durasi" class="form-control" value="{{ old('durasi') }}" placeholder="Contoh: 3:45">
                                </div>
                                <div>
                                    <label class="form-label">Tanggal Video</label>
                                    <input type="date" name="tanggal_video" class="form-control" value="{{ old('tanggal_video') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sumber Video --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3H6a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 3-3V6a3 3 0 0 0-3-3 3 3 0 0 0-3 3 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 3 3 0 0 0-3-3z"/></svg>
                        Sumber Video <span style="color:var(--danger);margin-left:2px">*</span>
                    </div>
                    <div class="card-body">
                        {{-- Pilih tipe --}}
                        <div class="sumber-tabs">
                            <label class="sumber-opt">
                                <input type="radio" name="tipe_sumber" value="youtube" {{ old('tipe_sumber','youtube') === 'youtube' ? 'checked' : '' }} onchange="switchSumber('youtube')">
                                <span class="sumber-label">
                                    <span class="sumber-icon yt">
                                        <svg width="14" height="14" fill="#dc2626" viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.54C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon fill="#fff" points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>
                                    </span>
                                    <span class="sumber-name">YouTube</span>
                                </span>
                            </label>
                            <label class="sumber-opt">
                                <input type="radio" name="tipe_sumber" value="vimeo" {{ old('tipe_sumber') === 'vimeo' ? 'checked' : '' }} onchange="switchSumber('vimeo')">
                                <span class="sumber-label">
                                    <span class="sumber-icon vi">
                                        <svg width="14" height="14" fill="#7c3aed" viewBox="0 0 24 24"><path d="M23 7.286c-.1 2.184-1.627 5.176-4.58 8.974C15.4 20.208 12.882 22 10.808 22c-1.282 0-2.367-1.183-3.253-3.55L5.63 12.336C5.013 9.97 4.352 8.785 3.646 8.785c-.154 0-.693.325-1.616.972L1 8.538c1.02-.895 2.024-1.79 3.01-2.686C5.39 4.66 6.43 4.02 7.13 3.96c1.665-.16 2.69.977 3.075 3.413.416 2.62.705 4.25.867 4.888.482 2.19.01 3.284-.001 3.284-.46.944-1.15 1.416-2.07 1.416-.714 0-1.392-.357-2.03-1.07.186.726.537 1.289 1.055 1.686.517.398 1.096.594 1.735.585 1.544-.023 3.046-1.19 4.508-3.498 1.461-2.31 2.207-4.074 2.237-5.291.053-2.004-.782-3.02-2.505-3.047-.734-.012-1.498.16-2.29.519.908-2.97 2.643-4.412 5.203-4.325 1.9.063 2.796 1.285 2.686 3.666z"/></svg>
                                    </span>
                                    <span class="sumber-name">Vimeo</span>
                                </span>
                            </label>
                            <label class="sumber-opt">
                                <input type="radio" name="tipe_sumber" value="upload" {{ old('tipe_sumber') === 'upload' ? 'checked' : '' }} onchange="switchSumber('upload')">
                                <span class="sumber-label">
                                    <span class="sumber-icon up">
                                        <svg width="14" height="14" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                                    </span>
                                    <span class="sumber-name">Upload</span>
                                </span>
                            </label>
                        </div>
                        @error('tipe_sumber')<p class="invalid-feedback" style="margin-bottom:12px">{{ $message }}</p>@enderror

                        {{-- Panel YouTube / Vimeo --}}
                        <div id="panel-embed">
                            <div class="form-group">
                                <label class="form-label">URL Video <span class="req">*</span></label>
                                <div class="url-parse-row">
                                    <input type="url" name="video_url" id="videoUrlInput" class="form-control @error('video_url') is-invalid @enderror"
                                        value="{{ old('video_url') }}" placeholder="https://youtube.com/watch?v=...">
                                    <button type="button" class="btn-parse" id="parseBtn" onclick="parseVideoUrl()">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                                        Parse
                                    </button>
                                </div>
                                @error('video_url')<p class="invalid-feedback">{{ $message }}</p>@enderror
                                <div class="parse-result" id="parseResult"></div>
                            </div>

                            {{-- Preview embed --}}
                            <div id="embedPreviewWrap" style="display:none">
                                <div class="video-preview-wrap">
                                    <iframe id="embedPreviewFrame" src="" allowfullscreen></iframe>
                                </div>
                            </div>

                            {{-- Hidden fields --}}
                            <input type="hidden" name="video_embed_id"  id="videoEmbedId"  value="{{ old('video_embed_id') }}">
                            <input type="hidden" name="video_embed_url" id="videoEmbedUrl" value="{{ old('video_embed_url') }}">

                            <div class="form-group" style="margin-bottom:0">
                                <label class="form-label">Sumber / Channel</label>
                                <input type="text" name="sumber" class="form-control" value="{{ old('sumber') }}" placeholder="Nama channel atau sumber">
                            </div>
                        </div>

                        {{-- Panel Upload --}}
                        <div id="panel-upload" style="display:none">
                            <div class="form-group">
                                <label class="form-label">File Video <span class="req">*</span></label>
                                <div class="upload-area">
                                    <input type="file" name="video" id="videoFileInput" accept="video/mp4,video/webm,video/quicktime" onchange="showFileName(this)">
                                    <div class="upload-area-icon">
                                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                                    </div>
                                    <p class="upload-area-text"><strong>Klik untuk upload</strong> atau seret file video</p>
                                    <p class="form-hint" style="margin-top:4px" id="fileNameDisplay">MP4, WEBM, MOV — maks 200 MB</p>
                                </div>
                                @error('video')<p class="invalid-feedback">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group" style="margin-bottom:0">
                                <label class="form-label">Sumber</label>
                                <input type="text" name="sumber" class="form-control" value="{{ old('sumber') }}" placeholder="Nama pembuat / sumber video">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Kanan --}}
            <div>
                {{-- Simpan --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        Simpan
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Simpan Video
                        </button>
                    </div>
                </div>

                {{-- Kategori --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                        Kategori
                    </div>
                    <div class="card-body">
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Kategori <span class="req">*</span></label>
                            <select name="galeri_kategori_id" class="form-control @error('galeri_kategori_id') is-invalid @enderror">
                                <option value="">— Pilih Kategori —</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id }}" {{ old('galeri_kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                @endforeach
                            </select>
                            @error('galeri_kategori_id')<p class="invalid-feedback">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Thumbnail --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        Thumbnail
                    </div>
                    <div class="card-body">
                        <div class="thumb-preview-wrap" id="thumbWrap">
                            <input type="file" name="thumbnail" accept="image/*" onchange="previewThumb(this)">
                            <div id="thumbPlaceholder">
                                <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                <p class="form-hint" style="margin-top:6px"><strong style="color:var(--brand-600)">Klik upload</strong> — opsional jika di-parse otomatis</p>
                            </div>
                            <img id="thumbPreviewImg" src="" alt="" style="display:none">
                        </div>
                        @error('thumbnail')<p class="invalid-feedback">{{ $message }}</p>@enderror
                        <div class="form-group" style="margin-top:12px;margin-bottom:0">
                            <label class="form-label">Atau URL Thumbnail</label>
                            <input type="url" name="thumbnail_url" id="thumbnailUrlInput" class="form-control" value="{{ old('thumbnail_url') }}" placeholder="https://...">
                        </div>
                    </div>
                </div>

                {{-- Opsi --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93A10 10 0 1 0 4.93 19.07"/></svg>
                        Opsi
                    </div>
                    <div class="card-body">
                        <div class="toggle-wrap">
                            <div>
                                <p class="toggle-label">Publish</p>
                                <p class="toggle-sub">Tampilkan video ke publik</p>
                            </div>
                            <label class="toggle">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        <div class="toggle-wrap">
                            <div>
                                <p class="toggle-label">Video Unggulan</p>
                                <p class="toggle-sub">Tampilkan di bagian unggulan</p>
                            </div>
                            <label class="toggle">
                                <input type="hidden" name="is_featured" value="0">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        <div class="toggle-wrap">
                            <div>
                                <p class="toggle-label">Urutan</p>
                            </div>
                            <input type="number" name="urutan" min="0" class="form-control" style="width:70px;text-align:center" value="{{ old('urutan', 0) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('error'))
    Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
    @endif

    // Init panel berdasarkan old value
    switchSumber('{{ old('tipe_sumber','youtube') }}');
    @if(old('video_embed_url'))
        document.getElementById('embedPreviewWrap').style.display = 'block';
        document.getElementById('embedPreviewFrame').src = '{{ old('video_embed_url') }}';
    @endif

    function switchSumber(tipe) {
        document.getElementById('panel-embed').style.display  = (tipe !== 'upload') ? 'block' : 'none';
        document.getElementById('panel-upload').style.display = (tipe === 'upload')  ? 'block' : 'none';
    }

    async function parseVideoUrl() {
        const url = document.getElementById('videoUrlInput').value.trim();
        if (!url) return;
        const btn = document.getElementById('parseBtn');
        btn.disabled = true; btn.textContent = 'Parsing...';
        try {
            const res = await fetch('{{ route('admin.galeri.video.parse-url') }}', {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
                body: JSON.stringify({url})
            });
            const data = await res.json();
            if (data.error) { Swal.fire({icon:'warning',title:'Gagal',text:data.error,confirmButtonColor:'#1f63db'}); return; }

            document.getElementById('videoEmbedId').value  = data.video_embed_id  || '';
            document.getElementById('videoEmbedUrl').value = data.embed_url        || '';
            if (data.thumbnail_url) document.getElementById('thumbnailUrlInput').value = data.thumbnail_url;

            if (data.embed_url) {
                document.getElementById('embedPreviewFrame').src = data.embed_url;
                document.getElementById('embedPreviewWrap').style.display = 'block';
            }
            const resultEl = document.getElementById('parseResult');
            resultEl.textContent = '✓ Video ditemukan' + (data.video_embed_id ? ` — ID: ${data.video_embed_id}` : '');
            resultEl.style.display = 'block';
        } catch(e) {
            Swal.fire({icon:'error',title:'Error',text:'Gagal menghubungi server.',confirmButtonColor:'#1f63db'});
        } finally {
            btn.disabled = false; btn.innerHTML = '<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg> Parse';
        }
    }

    function showFileName(input) {
        if (input.files[0]) document.getElementById('fileNameDisplay').textContent = input.files[0].name;
    }

    function previewThumb(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('thumbPlaceholder').style.display = 'none';
                const img = document.getElementById('thumbPreviewImg');
                img.src = e.target.result; img.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.getElementById('videoUrlInput')?.addEventListener('keydown', e => {
        if (e.key === 'Enter') { e.preventDefault(); parseVideoUrl(); }
    });
</script>
</x-app-layout>