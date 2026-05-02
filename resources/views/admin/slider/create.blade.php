<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root{--brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;--brand-100:#d9ebff;--brand-50:#eef6ff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;--danger:#dc2626;}
.page{padding:28px 28px 40px;}
.page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
.page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
.page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
.btn:hover{filter:brightness(.93);}
.btn-primary{background:var(--brand-600);color:#fff;}
.btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
.btn-back:hover{background:var(--surface3);filter:none;}
.form-grid{display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start;}
.card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
.card-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;}
.card-header-icon{width:32px;height:32px;border-radius:8px;background:var(--brand-50);display:flex;align-items:center;justify-content:center;}
.card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text);}
.card-body{padding:20px;}
.form-group{margin-bottom:18px;}
.form-group:last-child{margin-bottom:0;}
.form-label{display:block;margin-bottom:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);}
.form-label .req{color:var(--danger);margin-left:2px;}
.form-label .opt{font-weight:500;color:var(--text3);font-size:11px;margin-left:4px;text-transform:uppercase;letter-spacing:.04em;}
.form-control{width:100%;height:40px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s,background .15s;box-sizing:border-box;}
.form-control:focus{border-color:var(--brand-500);background:#fff;}
.form-control::placeholder{color:var(--text3);}
.form-control.is-invalid{border-color:var(--danger);}
textarea.form-control{height:auto;padding:10px 12px;resize:vertical;min-height:80px;}
.form-hint{font-size:11.5px;color:var(--text3);margin-top:5px;}
.form-error{font-size:12px;color:var(--danger);margin-top:4px;font-weight:600;}
.tab-group{display:flex;gap:0;margin-bottom:12px;border:1px solid var(--border);border-radius:var(--radius-sm);overflow:hidden;}
.tab-btn{flex:1;padding:8px;text-align:center;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);background:var(--surface2);border:none;transition:all .15s;}
.tab-btn.active{background:var(--brand-600);color:#fff;}
.tab-pane{display:none;}
.tab-pane.active{display:block;}
.img-preview-wrap{width:100%;aspect-ratio:16/7;border-radius:var(--radius-sm);border:2px dashed var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:center;overflow:hidden;position:relative;margin-bottom:12px;transition:border-color .15s;}
.img-preview-wrap:hover{border-color:var(--brand-500);}
.img-preview-wrap img{width:100%;height:100%;object-fit:cover;}
.img-placeholder{text-align:center;color:var(--text3);}
.img-placeholder p{font-size:12px;font-weight:600;}
.img-placeholder small{font-size:11px;}
.file-input-wrap{position:relative;}
.file-input-wrap input[type="file"]{position:absolute;inset:0;opacity:0;cursor:pointer;z-index:2;}
.file-input-btn{display:flex;align-items:center;justify-content:center;gap:6px;width:100%;padding:9px;border-radius:var(--radius-sm);background:var(--surface2);border:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);cursor:pointer;transition:all .15s;}
.file-input-btn:hover{background:var(--brand-50);border-color:var(--brand-100);color:var(--brand-700);}
.toggle-row{display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--surface3);}
.toggle-row:last-child{border-bottom:none;padding-bottom:0;}
.toggle-row:first-child{padding-top:0;}
.toggle-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
.toggle-sub{font-size:11.5px;color:var(--text3);margin-top:2px;}
.switch{position:relative;width:40px;height:22px;flex-shrink:0;}
.switch input{opacity:0;width:0;height:0;}
.slider-sw{position:absolute;inset:0;background:var(--border2);border-radius:99px;cursor:pointer;transition:.2s;}
.slider-sw:before{content:'';position:absolute;width:16px;height:16px;left:3px;bottom:3px;background:white;border-radius:50%;transition:.2s;}
.switch input:checked + .slider-sw{background:var(--brand-600);}
.switch input:checked + .slider-sw:before{transform:translateX(18px);}
.form-divider{border:none;border-top:1px solid var(--surface3);margin:16px 0;}
.action-bar{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 20px;border-top:1px solid var(--border);background:var(--surface2);}
@media(max-width:900px){.form-grid{grid-template-columns:1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Slider Baru</h1>
            <p class="page-sub">Isi informasi slider yang akan tampil di beranda</p>
        </div>
        <a href="{{ route('admin.slider.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('admin.slider.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-grid">

            {{-- Kiri --}}
            <div>
                <div class="card" style="margin-bottom:20px;">
                    <div class="card-header">
                        <div class="card-header-icon">
                            <svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </div>
                        <p class="card-title">Informasi Konten</p>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Judul Slider <span class="req">*</span></label>
                            <input type="text" name="judul"
                                class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}"
                                value="{{ old('judul') }}"
                                placeholder="Contoh: Selamat Datang di SMAN 1 Bandung" required>
                            @error('judul') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Subjudul <span class="opt">opsional</span></label>
                            <textarea name="subjudul" class="form-control {{ $errors->has('subjudul') ? 'is-invalid' : '' }}"
                                placeholder="Deskripsi singkat di bawah judul...">{{ old('subjudul') }}</textarea>
                            @error('subjudul') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <hr class="form-divider">

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                            <div class="form-group">
                                <label class="form-label">Label Tombol <span class="opt">opsional</span></label>
                                <input type="text" name="tombol_label" class="form-control"
                                    value="{{ old('tombol_label') }}" placeholder="Lihat Selengkapnya">
                                @error('tombol_label') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">URL Tombol <span class="opt">opsional</span></label>
                                <input type="url" name="tombol_url" class="form-control"
                                    value="{{ old('tombol_url') }}" placeholder="https://...">
                                @error('tombol_url') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-header-icon">
                            <svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </div>
                        <p class="card-title">Foto Slider</p>
                    </div>
                    <div class="card-body">
                        <div class="tab-group">
                            <button type="button" class="tab-btn active" onclick="switchTab('upload', this)">Upload File</button>
                            <button type="button" class="tab-btn" onclick="switchTab('url', this)">URL Gambar</button>
                        </div>

                        <div class="tab-pane active" id="tab-upload">
                            <div class="img-preview-wrap">
                                <img id="previewImg" src="" alt="" style="display:none">
                                <div class="img-placeholder" id="previewPlaceholder">
                                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    <p>Preview foto akan muncul di sini</p>
                                    <small>Rasio ideal: 16:7 (misal 1600×700 px)</small>
                                </div>
                            </div>
                            <div class="file-input-wrap">
                                {{-- field name: foto (sesuai controller) --}}
                                <input type="file" name="foto" accept="image/*" onchange="previewFoto(this)">
                                <div class="file-input-btn">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    Pilih Foto
                                </div>
                            </div>
                            <p class="form-hint">Maks. 3 MB. Format: JPG, PNG, WEBP.</p>
                            @error('foto') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div class="tab-pane" id="tab-url">
                            <input type="url" name="foto_url" class="form-control"
                                value="{{ old('foto_url') }}" placeholder="https://example.com/gambar.jpg"
                                oninput="previewFromUrl(this.value)">
                            <p class="form-hint">Masukkan URL gambar eksternal.</p>
                            @error('foto_url') <p class="form-error">{{ $message }}</p> @enderror
                            <div class="img-preview-wrap" id="urlPreviewWrap" style="margin-top:12px;display:none;">
                                <img id="urlPreviewImg" src="" alt="">
                            </div>
                        </div>

                        <hr class="form-divider">
                        <div class="form-group">
                            <label class="form-label">Alt Text Foto <span class="opt">opsional</span></label>
                            <input type="text" name="foto_alt" class="form-control"
                                value="{{ old('foto_alt') }}" placeholder="Deskripsi gambar untuk aksesibilitas">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kanan --}}
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-icon">
                            <svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        </div>
                        <p class="card-title">Pengaturan</p>
                    </div>
                    <div class="card-body">
                        <div class="toggle-row">
                            <div>
                                <p class="toggle-label">Publikasikan</p>
                                <p class="toggle-sub">Tampilkan slider di beranda</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="is_published" value="1" checked>
                                <span class="slider-sw"></span>
                            </label>
                        </div>

                        <div class="toggle-row" style="padding-top:16px;">
                            <div>
                                <p class="toggle-label" style="font-size:12.5px;">Urutan Tampil</p>
                                <p class="toggle-sub">Angka lebih kecil = tampil lebih dulu</p>
                            </div>
                        </div>
                        <input type="number" name="urutan" class="form-control" min="0"
                            value="{{ old('urutan', 0) }}" placeholder="0">
                        <p class="form-hint" style="margin-top:5px;">Atur posisi slider di antara slider lainnya.</p>
                    </div>
                    <div class="action-bar">
                        <a href="{{ route('admin.slider.index') }}" class="btn btn-back">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            Simpan Slider
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
@endif

function switchTab(tab, btn) {
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');
    btn.classList.add('active');
}
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('previewImg').style.display = 'block';
            document.getElementById('previewPlaceholder').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function previewFromUrl(url) {
    const wrap = document.getElementById('urlPreviewWrap');
    document.getElementById('urlPreviewImg').src = url;
    wrap.style.display = url ? 'flex' : 'none';
}
</script>
</x-app-layout>
