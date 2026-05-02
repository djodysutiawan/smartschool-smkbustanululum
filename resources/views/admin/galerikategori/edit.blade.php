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
    .header-actions { display:flex;gap:8px;flex-wrap:wrap; }

    .btn { display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap; }
    .btn:hover { filter:brightness(.93); }
    .btn-primary { background:var(--brand-600);color:#fff; }
    .btn-ghost   { background:var(--surface2);color:var(--text2);border:1px solid var(--border); }
    .btn-ghost:hover { background:var(--surface3);filter:none; }
    .btn-del     { background:#fff0f0;color:var(--danger);border:1px solid #fecaca; }
    .btn-del:hover { background:#fee2e2;filter:none; }

    .layout { display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start; }

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

    .slug-display {
        display:flex;align-items:center;gap:8px;padding:9px 12px;
        background:var(--surface3);border:1px solid var(--border);border-radius:var(--radius-sm);
        font-family:monospace;font-size:13px;color:var(--text2);
    }
    .slug-display span { color:var(--text3); }

    .tipe-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:8px; }
    .tipe-option { position:relative; }
    .tipe-option input { position:absolute;opacity:0;width:0;height:0; }
    .tipe-label { display:flex;flex-direction:column;align-items:center;gap:6px;padding:14px 10px;border:2px solid var(--border);border-radius:var(--radius);cursor:pointer;transition:all .15s;text-align:center; }
    .tipe-label:hover { border-color:var(--brand-300,#93c5fd);background:var(--brand-50); }
    .tipe-option input:checked + .tipe-label { border-color:var(--brand-600);background:var(--brand-50); }
    .tipe-icon { width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center; }
    .tipe-icon.foto  { background:#dbeafe; }
    .tipe-icon.video { background:#ede9fe; }
    .tipe-icon.semua { background:#dcfce7; }
    .tipe-name { font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text); }
    .tipe-desc { font-size:11px;color:var(--text3); }

    .thumb-current { margin-bottom:12px;border-radius:var(--radius);overflow:hidden;border:1px solid var(--border); }
    .thumb-current img { width:100%;max-height:120px;object-fit:cover;display:block; }
    .thumb-current-label { padding:6px 10px;background:var(--surface2);font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;color:var(--text3);display:flex;align-items:center;justify-content:space-between; }
    .thumb-current-label button { background:none;border:none;color:var(--danger);font-size:11.5px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;cursor:pointer;padding:0; }

    .thumb-preview-wrap { border:2px dashed var(--border2);border-radius:var(--radius);padding:20px;text-align:center;cursor:pointer;transition:border-color .15s,background .15s;position:relative; }
    .thumb-preview-wrap:hover { border-color:var(--brand-500);background:var(--brand-50); }
    .thumb-preview-wrap input[type=file] { position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%; }
    .thumb-preview-wrap img { max-height:120px;border-radius:6px;object-fit:contain; }
    .thumb-upload-icon { color:var(--text3);margin-bottom:8px; }
    .thumb-upload-text { font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;color:var(--text3); }
    .thumb-upload-text strong { color:var(--brand-600); }

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

    .info-row { display:flex;align-items:center;justify-content:space-between;padding:6px 0;border-bottom:1px solid var(--border); }
    .info-row:last-child { border-bottom:none; }
    .info-key { font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;color:var(--text3); }
    .info-val { font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text); }

    @media(max-width:900px){.layout{grid-template-columns:1fr;}.page{padding:16px;}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Kategori Galeri</h1>
            <p class="page-sub">Perbarui informasi kategori — <strong>{{ $galeriKategori->nama }}</strong></p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.galeri.kategori.index') }}" class="btn btn-ghost">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('admin.galeri.kategori.update', $galeriKategori->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
        @csrf
        @method('PUT')

        <div class="layout">

            {{-- Kiri --}}
            <div>
                <div class="card">
                    <div class="card-header">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                        Informasi Kategori
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label class="form-label">Nama Kategori <span class="req">*</span></label>
                            <input type="text" name="nama" id="namaInput" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $galeriKategori->nama) }}" placeholder="Nama kategori" oninput="updateSlugPreview(this.value)">
                            @error('nama')<p class="invalid-feedback">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Slug (otomatis)</label>
                            <div class="slug-display">
                                <span>/galeri/</span>
                                <span id="slugPreview">{{ $galeriKategori->slug }}</span>
                            </div>
                            <p class="form-hint">Slug diperbarui otomatis saat menyimpan</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                rows="3" placeholder="Deskripsi singkat kategori...">{{ old('deskripsi', $galeriKategori->deskripsi) }}</textarea>
                            @error('deskripsi')<p class="invalid-feedback">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Tipe Konten <span class="req">*</span></label>
                            <div class="tipe-grid">
                                <label class="tipe-option">
                                    <input type="radio" name="tipe" value="foto" {{ old('tipe', $galeriKategori->tipe) === 'foto' ? 'checked' : '' }}>
                                    <span class="tipe-label">
                                        <span class="tipe-icon foto">
                                            <svg width="16" height="16" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                        </span>
                                        <span class="tipe-name">Foto</span>
                                        <span class="tipe-desc">Hanya foto</span>
                                    </span>
                                </label>
                                <label class="tipe-option">
                                    <input type="radio" name="tipe" value="video" {{ old('tipe', $galeriKategori->tipe) === 'video' ? 'checked' : '' }}>
                                    <span class="tipe-label">
                                        <span class="tipe-icon video">
                                            <svg width="16" height="16" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                                        </span>
                                        <span class="tipe-name">Video</span>
                                        <span class="tipe-desc">Hanya video</span>
                                    </span>
                                </label>
                                <label class="tipe-option">
                                    <input type="radio" name="tipe" value="semua" {{ old('tipe', $galeriKategori->tipe) === 'semua' ? 'checked' : '' }}>
                                    <span class="tipe-label">
                                        <span class="tipe-icon semua">
                                            <svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                                        </span>
                                        <span class="tipe-name">Semua</span>
                                        <span class="tipe-desc">Foto & video</span>
                                    </span>
                                </label>
                            </div>
                            @error('tipe')<p class="invalid-feedback">{{ $message }}</p>@enderror
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
                        Simpan Perubahan
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Perbarui Kategori
                        </button>
                    </div>
                </div>

                {{-- Info --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Info
                    </div>
                    <div class="card-body">
                        <div class="info-row">
                            <span class="info-key">Foto</span>
                            <span class="info-val">{{ $galeriKategori->foto_count ?? $galeriKategori->foto()->count() }} item</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">Video</span>
                            <span class="info-val">{{ $galeriKategori->video_count ?? $galeriKategori->video()->count() }} item</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">Dibuat</span>
                            <span class="info-val">{{ $galeriKategori->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">Diperbarui</span>
                            <span class="info-val">{{ $galeriKategori->updated_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Urutan --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M5 9l4-4 4 4M5 15l4 4 4-4M9 5v14"/></svg>
                        Urutan Tampil
                    </div>
                    <div class="card-body">
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Nomor Urutan</label>
                            <input type="number" name="urutan" min="0" class="form-control @error('urutan') is-invalid @enderror"
                                value="{{ old('urutan', $galeriKategori->urutan) }}">
                            @error('urutan')<p class="invalid-feedback">{{ $message }}</p>@enderror
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

                        {{-- Thumbnail saat ini --}}
                        @if($galeriKategori->thumbnail_path || $galeriKategori->thumbnail_url)
                        <div class="thumb-current" id="currentThumbWrap">
                            <img src="{{ $galeriKategori->thumbnail_path ? asset('storage/'.$galeriKategori->thumbnail_path) : $galeriKategori->thumbnail_url }}"
                                alt="{{ $galeriKategori->nama }}">
                            <div class="thumb-current-label">
                                <span>Thumbnail saat ini</span>
                                <button type="button" onclick="removeCurrentThumb()">✕ Hapus</button>
                            </div>
                        </div>
                        @endif

                        <div class="thumb-preview-wrap" id="thumbUploadWrap" style="{{ ($galeriKategori->thumbnail_path || $galeriKategori->thumbnail_url) ? 'display:none' : '' }}">
                            <input type="file" name="thumbnail" accept="image/*" onchange="previewThumb(this)">
                            <div id="thumbPlaceholder">
                                <div class="thumb-upload-icon">
                                    <svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                </div>
                                <p class="thumb-upload-text"><strong>Klik untuk upload</strong> gambar baru</p>
                                <p class="form-hint" style="margin-top:4px">PNG, JPG, WEBP — maks 2 MB</p>
                            </div>
                            <img id="thumbPreview" src="" alt="" style="display:none">
                        </div>
                        @error('thumbnail')<p class="invalid-feedback">{{ $message }}</p>@enderror

                        <div class="form-group" style="margin-top:14px;margin-bottom:0">
                            <label class="form-label">Atau URL Gambar</label>
                            <input type="url" name="thumbnail_url" class="form-control @error('thumbnail_url') is-invalid @enderror"
                                value="{{ old('thumbnail_url', $galeriKategori->thumbnail_url) }}" placeholder="https://...">
                            @error('thumbnail_url')<p class="invalid-feedback">{{ $message }}</p>@enderror
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
                        <div class="toggle-wrap" style="border-bottom:none;padding-bottom:0">
                            <div>
                                <p class="toggle-label">Tampilkan Kategori</p>
                                <p class="toggle-sub">Kategori aktif dan terlihat publik</p>
                            </div>
                            <label class="toggle">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $galeriKategori->is_published) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Hapus --}}
                <div class="card" style="border-color:#fecaca">
                    <div class="card-header" style="background:#fff0f0;border-bottom-color:#fecaca;color:#dc2626">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                        Zona Bahaya
                    </div>
                    <div class="card-body">
                        <p style="font-size:12.5px;color:var(--text3);margin-bottom:12px">
                            Hapus kategori ini secara permanen. Pastikan tidak ada foto/video di dalamnya.
                        </p>
                        <button type="button" class="btn btn-del" style="width:100%;justify-content:center"
                            onclick="confirmDelete()">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                            Hapus Kategori
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>

    {{-- Form hapus di LUAR form edit --}}
    <form action="{{ route('admin.galeri.kategori.destroy', $galeriKategori->id) }}" method="POST" id="deleteForm">
        @csrf @method('DELETE')
    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
    @endif
    @if(session('error'))
    Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
    @endif

    function updateSlugPreview(val) {
        const slug = val.toLowerCase().replace(/[^a-z0-9\s-]/g,'').trim().replace(/\s+/g,'-');
        document.getElementById('slugPreview').textContent = slug || '...';
    }

    function removeCurrentThumb() {
        document.getElementById('currentThumbWrap')?.remove();
        document.getElementById('thumbUploadWrap').style.display = 'block';
    }

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

    function confirmDelete() {
        Swal.fire({
            title: 'Hapus Kategori?',
            html: `Kategori <strong>{{ addslashes($galeriKategori->nama) }}</strong> akan dihapus permanen.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('deleteForm').submit(); });
    }
</script>
</x-app-layout>