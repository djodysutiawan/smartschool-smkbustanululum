<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

:root {
    --brand-700: #1750c0; --brand-600: #1f63db; --brand-500: #3582f0;
    --brand-100: #d9ebff; --brand-50: #eef6ff;
    --surface: #fff; --surface2: #f8fafc; --surface3: #f1f5f9;
    --border: #e2e8f0;
    --text: #0f172a; --text2: #475569; --text3: #94a3b8;
    --radius: 10px; --radius-sm: 7px;
}

.page { padding: 28px 28px 40px; max-width: 2000px; }
.page-header { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:24px; flex-wrap:wrap; }
.page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:20px; font-weight:800; color:var(--text); }
.page-sub { font-size:12.5px; color:var(--text3); margin-top:3px; }
.breadcrumb { display:flex; align-items:center; gap:6px; font-size:12px; color:var(--text3); margin-bottom:6px; }
.breadcrumb a { color:var(--brand-600); text-decoration:none; }
.header-actions { display:flex; gap:8px; }

.btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; border:none; text-decoration:none; transition:filter .15s; white-space:nowrap; }
.btn:hover { filter:brightness(.93); }
.btn-primary { background:var(--brand-600); color:#fff; }
.btn-secondary { background:var(--surface2); color:var(--text2); border:1px solid var(--border); }
.btn-secondary:hover { background:var(--surface3); filter:none; }

.form-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; margin-bottom:16px; }
.form-card-header { padding:14px 20px; border-bottom:1px solid var(--border); background:var(--surface2); }
.form-card-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:13.5px; font-weight:700; color:var(--text); }
.form-card-body { padding:20px; display:flex; flex-direction:column; gap:16px; }
.form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
.form-group { display:flex; flex-direction:column; gap:5px; }
.form-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:12px; font-weight:700; color:var(--text2); }
.form-hint { font-size:11px; color:var(--text3); margin-top:3px; }
.form-control { height:38px; padding:0 12px; border:1px solid var(--border); border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:13px; color:var(--text); background:#fff; outline:none; transition:border-color .15s; width:100%; box-sizing:border-box; }
.form-control:focus { border-color:var(--brand-500); }
textarea.form-control { height:90px; padding:10px 12px; resize:vertical; }
.form-control.error { border-color:#dc2626; }
.error-msg { font-size:11.5px; color:#dc2626; margin-top:3px; }

/* Toggle switch */
.toggle-wrap { display:flex; align-items:center; gap:10px; }
.toggle { position:relative; width:40px; height:22px; }
.toggle input { opacity:0; width:0; height:0; }
.toggle-slider { position:absolute; inset:0; background:#cbd5e1; border-radius:99px; cursor:pointer; transition:.2s; }
.toggle-slider:before { content:''; position:absolute; width:16px; height:16px; left:3px; bottom:3px; background:#fff; border-radius:50%; transition:.2s; }
.toggle input:checked + .toggle-slider { background:var(--brand-600); }
.toggle input:checked + .toggle-slider:before { transform:translateX(18px); }
.toggle-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:600; color:var(--text2); }

/* Upload zone */
.upload-zone { border:2px dashed var(--border); border-radius:var(--radius-sm); padding:28px 16px; text-align:center; cursor:pointer; transition:border-color .15s; background:var(--surface2); position:relative; }
.upload-zone:hover, .upload-zone.dragover { border-color:var(--brand-500); background:var(--brand-50); }
.upload-zone input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; }
.upload-zone-icon { width:44px; height:44px; background:var(--surface); border:1px solid var(--border); border-radius:10px; display:flex; align-items:center; justify-content:center; margin:0 auto 10px; }
.upload-zone-text { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:600; color:var(--text2); }
.upload-zone-hint { font-size:12px; color:var(--text3); margin-top:4px; }
.preview-wrap { display:none; margin-top:14px; }
.preview-img { max-height:180px; border-radius:8px; border:1px solid var(--border); }

.form-footer { display:flex; justify-content:flex-end; gap:10px; padding:16px 20px; border-top:1px solid var(--border); background:var(--surface2); }

@media(max-width:640px) { .page{padding:16px;} .form-row{grid-template-columns:1fr;} }
</style>

<div class="page">
    <div class="breadcrumb">
        <a href="{{ route('admin.galeri.foto.index') }}">Galeri Foto</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <span>Unggah Foto</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Unggah Foto Baru</h1>
            <p class="page-sub">Tambahkan foto ke galeri sekolah</p>
        </div>
        <a href="{{ route('admin.galeri.foto.index') }}" class="btn btn-secondary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.galeri.foto.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Foto --}}
        <div class="form-card">
            <div class="form-card-header"><p class="form-card-title">File Foto</p></div>
            <div class="form-card-body">
                <div class="upload-zone" id="uploadZone">
                    <input type="file" name="foto" id="fotoInput" accept="image/*" onchange="previewFoto(this)">
                    <div class="upload-zone-icon">
                        <svg width="20" height="20" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                    </div>
                    <p class="upload-zone-text">Klik atau seret foto ke sini</p>
                    <p class="upload-zone-hint">JPG, PNG, WebP — maks. 4 MB</p>
                    <div class="preview-wrap" id="previewWrap">
                        <img id="previewImg" class="preview-img" src="" alt="Preview">
                    </div>
                </div>
                @error('foto') <span class="error-msg">{{ $message }}</span> @enderror

                <div class="form-group">
                    <label class="form-label">Atau gunakan URL Foto</label>
                    <input type="url" name="foto_url" class="form-control @error('foto_url') error @enderror"
                        value="{{ old('foto_url') }}" placeholder="https://example.com/foto.jpg">
                    @error('foto_url') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- Info --}}
        <div class="form-card">
            <div class="form-card-header"><p class="form-card-title">Informasi Foto</p></div>
            <div class="form-card-body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Kategori <span style="color:#dc2626">*</span></label>
                        <select name="galeri_kategori_id" class="form-control @error('galeri_kategori_id') error @enderror" required>
                            <option value="">— Pilih Kategori —</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id }}" {{ old('galeri_kategori_id') == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('galeri_kategori_id') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Judul <span style="color:#dc2626">*</span></label>
                        <input type="text" name="judul" class="form-control @error('judul') error @enderror"
                            value="{{ old('judul') }}" placeholder="Judul foto" required>
                        @error('judul') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control @error('keterangan') error @enderror"
                        placeholder="Keterangan atau deskripsi foto...">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Alt Text (SEO)</label>
                        <input type="text" name="alt_text" class="form-control"
                            value="{{ old('alt_text') }}" placeholder="Deskripsi gambar untuk SEO">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sumber / Fotografer</label>
                        <input type="text" name="sumber" class="form-control"
                            value="{{ old('sumber') }}" placeholder="cth. Dok. Humas Sekolah">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Tanggal Foto</label>
                        <input type="date" name="tanggal_foto" class="form-control"
                            value="{{ old('tanggal_foto') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" class="form-control"
                            value="{{ old('urutan') }}" placeholder="otomatis" min="0">
                    </div>
                </div>
            </div>
        </div>

        {{-- Pengaturan --}}
        <div class="form-card">
            <div class="form-card-header"><p class="form-card-title">Pengaturan Publikasi</p></div>
            <div class="form-card-body">
                <div class="toggle-wrap">
                    <label class="toggle">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="toggle-label">Publikasikan foto ini</span>
                </div>
                <div class="toggle-wrap">
                    <label class="toggle">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="toggle-label">Tandai sebagai foto unggulan</span>
                </div>
            </div>
            <div class="form-footer">
                <a href="{{ route('admin.galeri.foto.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Foto
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if($errors->any())
Swal.fire({ icon:'error', title:'Periksa form', text:'Terdapat kesalahan pada input.', confirmButtonColor:'#1f63db' });
@endif

function previewFoto(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('previewWrap').style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
}

// Drag over style
const zone = document.getElementById('uploadZone');
zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('dragover'); });
zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
zone.addEventListener('drop', () => zone.classList.remove('dragover'));
</script>
</x-app-layout>