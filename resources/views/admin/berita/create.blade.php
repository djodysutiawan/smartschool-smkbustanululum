<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand-700: #1750c0;
        --brand-600: #1f63db;
        --brand-500: #3582f0;
        --brand-100: #d9ebff;
        --brand-50:  #eef6ff;
        --surface:   #fff;
        --surface2:  #f8fafc;
        --surface3:  #f1f5f9;
        --border:    #e2e8f0;
        --border2:   #cbd5e1;
        --text:      #0f172a;
        --text2:     #475569;
        --text3:     #94a3b8;
        --radius:    10px;
        --radius-sm: 7px;
        --danger:    #dc2626;
    }

    .page { padding: 28px 28px 40px; }

    .page-header {
        display: flex; align-items: flex-start;
        justify-content: space-between; gap: 16px;
        margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2; }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .header-actions { display: flex; gap: 8px; flex-wrap: wrap; }

    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 18px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none; transition: filter .15s; white-space: nowrap;
    }
    .btn:hover { filter: brightness(.93); }
    .btn-primary { background: var(--brand-600); color: #fff; }
    .btn-ghost   { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); filter: none; }

    .layout { display: grid; grid-template-columns: 1fr 320px; gap: 20px; align-items: start; }

    .card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
    }
    .card-header {
        padding: 14px 20px; border-bottom: 1px solid var(--border);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text);
        display: flex; align-items: center; gap: 8px;
    }
    .card-body { padding: 20px; }
    .card + .card { margin-top: 16px; }

    .form-group { margin-bottom: 18px; }
    .form-group:last-child { margin-bottom: 0; }
    .form-label {
        display: block; margin-bottom: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2);
    }
    .form-label .req { color: var(--danger); margin-left: 2px; }
    .form-hint { font-size: 11.5px; color: var(--text3); margin-top: 4px; }

    .form-control {
        width: 100%; padding: 9px 12px; box-sizing: border-box;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text);
        background: var(--surface2); outline: none; transition: border-color .15s;
    }
    .form-control:focus { border-color: var(--brand-500); background: #fff; }
    .form-control::placeholder { color: var(--text3); }
    .form-control.is-invalid { border-color: var(--danger); }
    textarea.form-control { resize: vertical; min-height: 80px; }

    .invalid-feedback { font-size: 11.5px; color: var(--danger); margin-top: 4px; }

    .thumb-preview-wrap {
        border: 2px dashed var(--border2); border-radius: var(--radius);
        padding: 20px; text-align: center; cursor: pointer;
        transition: border-color .15s, background .15s; position: relative;
    }
    .thumb-preview-wrap:hover { border-color: var(--brand-500); background: var(--brand-50); }
    .thumb-preview-wrap input[type=file] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .thumb-preview-wrap img { max-height: 140px; border-radius: 6px; object-fit: contain; }
    .thumb-upload-icon { color: var(--text3); margin-bottom: 8px; }
    .thumb-upload-text { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; color: var(--text3); }
    .thumb-upload-text strong { color: var(--brand-600); }

    .toggle-wrap {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 0; border-bottom: 1px solid var(--border);
    }
    .toggle-wrap:last-child { border-bottom: none; padding-bottom: 0; }
    .toggle-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; color: var(--text); }
    .toggle-sub   { font-size: 11.5px; color: var(--text3); }
    .toggle {
        position: relative; width: 40px; height: 22px; flex-shrink: 0;
    }
    .toggle input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute; inset: 0; background: var(--border2);
        border-radius: 99px; cursor: pointer; transition: background .2s;
    }
    .toggle-slider::before {
        content: ''; position: absolute; width: 16px; height: 16px;
        left: 3px; top: 3px; background: #fff;
        border-radius: 50%; transition: transform .2s;
    }
    .toggle input:checked + .toggle-slider { background: var(--brand-600); }
    .toggle input:checked + .toggle-slider::before { transform: translateX(18px); }

    .tab-bar { display: flex; gap: 0; border-bottom: 1px solid var(--border); }
    .tab-btn {
        padding: 10px 18px; font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px; font-weight: 700; color: var(--text3);
        cursor: pointer; border-bottom: 2px solid transparent; margin-bottom: -1px;
        transition: color .15s, border-color .15s; background: none; border-top: none;
        border-left: none; border-right: none;
    }
    .tab-btn.active { color: var(--brand-600); border-bottom-color: var(--brand-600); }
    .tab-pane { display: none; padding-top: 18px; }
    .tab-pane.active { display: block; }

    @media (max-width: 900px) {
        .layout { grid-template-columns: 1fr; }
        .page { padding: 16px; }
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Tulis Berita Baru</h1>
            <p class="page-sub">Buat artikel baru — akan disimpan sebagai draft</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.berita.index') }}" class="btn btn-ghost">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" id="beritaForm">
        @csrf

        <div class="layout">

            {{-- Kolom Kiri --}}
            <div>

                {{-- Konten Utama --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Konten Berita
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label class="form-label">Judul Berita <span class="req">*</span></label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                                value="{{ old('judul') }}" placeholder="Tulis judul berita yang menarik...">
                            @error('judul')<p class="invalid-feedback">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Ringkasan</label>
                            <textarea name="ringkasan" class="form-control @error('ringkasan') is-invalid @enderror"
                                rows="3" placeholder="Deskripsi singkat berita (opsional, maks 500 karakter)...">{{ old('ringkasan') }}</textarea>
                            @error('ringkasan')<p class="invalid-feedback">{{ $message }}</p>@enderror
                            <p class="form-hint">Ditampilkan di listing dan pratinjau media sosial</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Konten <span class="req">*</span></label>
                            <textarea name="konten" id="konten" class="form-control @error('konten') is-invalid @enderror"
                                rows="14" placeholder="Tulis konten berita di sini...">{{ old('konten') }}</textarea>
                            @error('konten')<p class="invalid-feedback">{{ $message }}</p>@enderror
                        </div>

                    </div>
                </div>

                {{-- SEO & Meta --}}
                <div class="card" style="margin-top:16px">
                    <div class="card-header">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        SEO & Meta
                    </div>

                    {{-- Tabs --}}
                    <div style="padding: 0 20px">
                        <div class="tab-bar">
                            <button type="button" class="tab-btn active" onclick="switchTab('tab-seo', this)">Meta SEO</button>
                            <button type="button" class="tab-btn" onclick="switchTab('tab-extra', this)">Info Tambahan</button>
                        </div>
                    </div>

                    <div style="padding: 0 20px 20px">
                        <div class="tab-pane active" id="tab-seo">
                            <div class="form-group">
                                <label class="form-label">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror"
                                    value="{{ old('meta_title') }}" placeholder="Judul untuk mesin pencari (opsional)">
                                @error('meta_title')<p class="invalid-feedback">{{ $message }}</p>@enderror
                                <p class="form-hint">Jika kosong, judul berita akan digunakan</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" class="form-control @error('meta_description') is-invalid @enderror"
                                    rows="2" placeholder="Deskripsi untuk mesin pencari (opsional, maks 500 karakter)...">{{ old('meta_description') }}</textarea>
                                @error('meta_description')<p class="invalid-feedback">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group" style="margin-bottom:0">
                                <label class="form-label">Tags</label>
                                <input type="text" name="tags" class="form-control @error('tags') is-invalid @enderror"
                                    value="{{ old('tags') }}" placeholder="teknologi, pendidikan, sekolah">
                                @error('tags')<p class="invalid-feedback">{{ $message }}</p>@enderror
                                <p class="form-hint">Pisahkan dengan koma</p>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab-extra">
                            <div class="form-group">
                                <label class="form-label">Nama Penulis</label>
                                <input type="text" name="nama_penulis" class="form-control @error('nama_penulis') is-invalid @enderror"
                                    value="{{ old('nama_penulis') }}" placeholder="Nama penulis (opsional)">
                                @error('nama_penulis')<p class="invalid-feedback">{{ $message }}</p>@enderror
                                <p class="form-hint">Jika kosong, nama akun Anda akan digunakan</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Kolom Kanan --}}
            <div>

                {{-- Publish --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        Publish
                    </div>
                    <div class="card-body">
                        <p style="font-size:12.5px;color:var(--text3);margin-bottom:16px">
                            Berita akan disimpan sebagai <strong style="color:var(--text2)">Draft</strong>. Publish kapan saja dari daftar berita.
                        </p>
                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Simpan Draft
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
                            <label class="form-label">Kategori Berita <span class="req">*</span></label>
                            <select name="berita_kategori_id" class="form-control @error('berita_kategori_id') is-invalid @enderror">
                                <option value="">— Pilih Kategori —</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id }}" {{ old('berita_kategori_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('berita_kategori_id')<p class="invalid-feedback">{{ $message }}</p>@enderror
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
                            <input type="file" name="thumbnail" accept="image/*" id="thumbInput" onchange="previewThumb(this)">
                            <div id="thumbPlaceholder">
                                <div class="thumb-upload-icon">
                                    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                </div>
                                <p class="thumb-upload-text"><strong>Klik untuk upload</strong> atau seret gambar</p>
                                <p class="form-hint" style="margin-top:4px">PNG, JPG, WEBP — maks 2 MB</p>
                            </div>
                            <img id="thumbPreview" src="" alt="" style="display:none">
                        </div>
                        @error('thumbnail')<p class="invalid-feedback">{{ $message }}</p>@enderror

                        <div class="form-group" style="margin-top:14px;margin-bottom:0">
                            <label class="form-label">Atau URL Gambar</label>
                            <input type="url" name="thumbnail_url" class="form-control @error('thumbnail_url') is-invalid @enderror"
                                value="{{ old('thumbnail_url') }}" placeholder="https://...">
                            @error('thumbnail_url')<p class="invalid-feedback">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group" style="margin-top:14px;margin-bottom:0">
                            <label class="form-label">Alt Text Thumbnail</label>
                            <input type="text" name="thumbnail_alt" class="form-control"
                                value="{{ old('thumbnail_alt') }}" placeholder="Deskripsi gambar">
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
                                <p class="toggle-label">Berita Unggulan</p>
                                <p class="toggle-sub">Tampilkan di bagian unggulan</p>
                            </div>
                            <label class="toggle">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        <div class="toggle-wrap">
                            <div>
                                <p class="toggle-label">Izinkan Komentar</p>
                                <p class="toggle-sub">Buka kolom komentar pembaca</p>
                            </div>
                            <label class="toggle">
                                <input type="checkbox" name="allow_comment" value="1" {{ old('allow_comment', true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
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
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif

    function previewThumb(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('thumbPlaceholder').style.display = 'none';
                const img = document.getElementById('thumbPreview');
                img.src = e.target.result;
                img.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function switchTab(id, btn) {
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.getElementById(id).classList.add('active');
        btn.classList.add('active');
    }
</script>
</x-app-layout>