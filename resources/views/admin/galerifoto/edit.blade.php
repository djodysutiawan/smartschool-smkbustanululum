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
.btn-del { background:#fff0f0; color:#dc2626; border:1px solid #fecaca; }
.btn-del:hover { background:#fee2e2; filter:none; }

.form-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; margin-bottom:16px; }
.form-card-header { padding:14px 20px; border-bottom:1px solid var(--border); background:var(--surface2); display:flex; align-items:center; justify-content:space-between; }
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

.toggle-wrap { display:flex; align-items:center; gap:10px; }
.toggle { position:relative; width:40px; height:22px; }
.toggle input { opacity:0; width:0; height:0; }
.toggle-slider { position:absolute; inset:0; background:#cbd5e1; border-radius:99px; cursor:pointer; transition:.2s; }
.toggle-slider:before { content:''; position:absolute; width:16px; height:16px; left:3px; bottom:3px; background:#fff; border-radius:50%; transition:.2s; }
.toggle input:checked + .toggle-slider { background:var(--brand-600); }
.toggle input:checked + .toggle-slider:before { transform:translateX(18px); }
.toggle-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:600; color:var(--text2); }

/* Foto saat ini */
.current-foto { display:flex; gap:16px; align-items:flex-start; padding:14px; background:var(--surface2); border-radius:var(--radius-sm); border:1px solid var(--border); }
.current-foto img { width:120px; height:80px; object-fit:cover; border-radius:8px; border:1px solid var(--border); flex-shrink:0; }
.current-foto-info p { font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; color:var(--text); margin-bottom:4px; }
.current-foto-info span { font-size:12px; color:var(--text3); }

.upload-zone { border:2px dashed var(--border); border-radius:var(--radius-sm); padding:20px 16px; text-align:center; cursor:pointer; transition:border-color .15s; background:var(--surface2); position:relative; }
.upload-zone:hover { border-color:var(--brand-500); background:var(--brand-50); }
.upload-zone input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; }
.upload-zone-text { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:600; color:var(--text2); }
.upload-zone-hint { font-size:12px; color:var(--text3); margin-top:4px; }
.new-preview { display:none; margin-top:10px; }
.new-preview img { max-height:120px; border-radius:6px; border:1px solid var(--border); }

.form-footer { display:flex; justify-content:space-between; align-items:center; padding:16px 20px; border-top:1px solid var(--border); background:var(--surface2); }
.form-footer-right { display:flex; gap:10px; }

@media(max-width:640px) { .page{padding:16px;} .form-row{grid-template-columns:1fr;} .current-foto{flex-direction:column;} }
</style>

<div class="page">
    <div class="breadcrumb">
        <a href="{{ route('admin.galeri.foto.index') }}">Galeri Foto</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <span>Edit Foto</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Foto</h1>
            <p class="page-sub">{{ $galeriFoto->judul }}</p>
        </div>
        <a href="{{ route('admin.galeri.foto.index') }}" class="btn btn-secondary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    {{-- Form hapus — di LUAR form update --}}
    <form action="{{ route('admin.galeri.foto.destroy', $galeriFoto) }}" method="POST" id="deleteForm">
        @csrf @method('DELETE')
    </form>

    <form action="{{ route('admin.galeri.foto.update', $galeriFoto) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        {{-- Foto saat ini --}}
        <div class="form-card">
            <div class="form-card-header">
                <p class="form-card-title">Foto Saat Ini</p>
                <button type="button" class="btn btn-del" style="font-size:12px;padding:5px 12px"
                    onclick="confirmDelete()">Hapus Foto Ini</button>
            </div>
            <div class="form-card-body">
                @if($galeriFoto->foto_path || $galeriFoto->foto_url)
                <div class="current-foto">
                    <img src="{{ $galeriFoto->foto_path ? Storage::url($galeriFoto->foto_path) : $galeriFoto->foto_url }}"
                         alt="{{ $galeriFoto->alt_text ?? $galeriFoto->judul }}">
                    <div class="current-foto-info">
                        <p>{{ $galeriFoto->judul }}</p>
                        <span>{{ $galeriFoto->kategori->nama ?? '—' }}</span><br>
                        @if($galeriFoto->tanggal_foto)
                            <span>{{ \Carbon\Carbon::parse($galeriFoto->tanggal_foto)->isoFormat('D MMMM Y') }}</span>
                        @endif
                    </div>
                </div>
                @endif

                <div class="form-group">
                    <label class="form-label">Ganti dengan foto baru (opsional)</label>
                    <div class="upload-zone">
                        <input type="file" name="foto" id="fotoInput" accept="image/*" onchange="previewNew(this)">
                        <p class="upload-zone-text">Klik untuk pilih foto pengganti</p>
                        <p class="upload-zone-hint">JPG, PNG, WebP — maks. 4 MB</p>
                        <div class="new-preview" id="newPreview">
                            <img id="newPreviewImg" src="" alt="Preview baru">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Atau URL Foto</label>
                    <input type="url" name="foto_url" class="form-control"
                        value="{{ old('foto_url', $galeriFoto->foto_url) }}" placeholder="https://...">
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
                            <option value="">— Pilih —</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id }}"
                                    {{ old('galeri_kategori_id', $galeriFoto->galeri_kategori_id) == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('galeri_kategori_id') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Judul <span style="color:#dc2626">*</span></label>
                        <input type="text" name="judul" class="form-control @error('judul') error @enderror"
                            value="{{ old('judul', $galeriFoto->judul) }}" required>
                        @error('judul') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control">{{ old('keterangan', $galeriFoto->keterangan) }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Alt Text (SEO)</label>
                        <input type="text" name="alt_text" class="form-control"
                            value="{{ old('alt_text', $galeriFoto->alt_text) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sumber / Fotografer</label>
                        <input type="text" name="sumber" class="form-control"
                            value="{{ old('sumber', $galeriFoto->sumber) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Tanggal Foto</label>
                        <input type="date" name="tanggal_foto" class="form-control"
                            value="{{ old('tanggal_foto', $galeriFoto->tanggal_foto?->format('Y-m-d')) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" class="form-control"
                            value="{{ old('urutan', $galeriFoto->urutan) }}" min="0">
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
                        <input type="checkbox" name="is_published" value="1"
                            {{ old('is_published', $galeriFoto->is_published) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="toggle-label">Publikasikan foto ini</span>
                </div>
                <div class="toggle-wrap">
                    <label class="toggle">
                        <input type="checkbox" name="is_featured" value="1"
                            {{ old('is_featured', $galeriFoto->is_featured) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="toggle-label">Tandai sebagai foto unggulan</span>
                </div>
            </div>
            <div class="form-footer">
                <span style="font-size:12px;color:var(--text3);">
                    Diunggah {{ $galeriFoto->created_at->diffForHumans() }}
                </span>
                <div class="form-footer-right">
                    <a href="{{ route('admin.galeri.foto.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Perbarui Foto
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if($errors->any())
Swal.fire({ icon:'error', title:'Periksa form', text:'Terdapat kesalahan pada input.', confirmButtonColor:'#1f63db' });
@endif

function previewNew(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('newPreviewImg').src = e.target.result;
        document.getElementById('newPreview').style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
}

function confirmDelete() {
    Swal.fire({ title:'Hapus Foto?', text:'"{{ addslashes($galeriFoto->judul) }}" akan dihapus permanen.', icon:'warning',
        showCancelButton:true, confirmButtonColor:'#dc2626', cancelButtonColor:'#64748b',
        confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal'
    }).then(r => { if(r.isConfirmed) document.getElementById('deleteForm').submit(); });
}
</script>
</x-app-layout>