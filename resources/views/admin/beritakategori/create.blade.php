<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root {
    --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
    --brand-100:#d9ebff;--brand-50:#eef6ff;
    --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
    --border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
    --radius:10px;--radius-sm:7px;
}
.page { padding:28px 28px 40px; }
.breadcrumb { display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--text3);margin-bottom:20px; }
.breadcrumb a { color:var(--brand-600);text-decoration:none;font-weight:600; }
.page-header { display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap; }
.page-title { font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text); }
.page-sub { font-size:12.5px;color:var(--text3);margin-top:3px; }
.btn { display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap; }
.btn:hover { filter:brightness(.93); }
.btn-primary { background:var(--brand-600);color:#fff; }
.btn-secondary { background:var(--surface2);color:var(--text2);border:1px solid var(--border); }
.btn-secondary:hover { background:var(--surface3);filter:none; }
.form-layout { display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start; }
.form-card { background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden; }
.form-card-header { padding:15px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px; }
.form-card-icon { width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:var(--brand-50);flex-shrink:0; }
.form-card-title { font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text); }
.form-card-body { padding:20px; }
.form-grid { display:grid;gap:16px; }
.form-group { display:flex;flex-direction:column;gap:6px; }
.form-label { font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2); }
.form-label .req { color:#dc2626;margin-left:2px; }
.form-control { width:100%;padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s,background .15s;box-sizing:border-box; }
.form-control:focus { border-color:var(--brand-500);background:#fff;box-shadow:0 0 0 3px rgba(31,99,219,.07); }
.form-control::placeholder { color:var(--text3); }
textarea.form-control { resize:vertical;min-height:100px; }
.form-control-readonly { background:var(--surface3);color:var(--text3);cursor:default; }
.form-hint { font-size:11.5px;color:var(--text3); }
.form-error { font-size:11.5px;color:#dc2626; }
.color-row { display:flex;align-items:center;gap:10px; }
.color-row input[type=color] { width:44px;height:38px;padding:2px;border-radius:var(--radius-sm);border:1px solid var(--border);cursor:pointer;background:var(--surface2); }
.color-text { flex:1;height:38px;border-radius:var(--radius-sm);border:1px solid var(--border);display:flex;align-items:center;padding:0 12px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;transition:background .2s; }
.swatches { display:flex;flex-wrap:wrap;gap:7px;margin-top:8px; }
.swatch { width:26px;height:26px;border-radius:6px;cursor:pointer;border:2px solid transparent;transition:transform .15s,border-color .15s; }
.swatch:hover { transform:scale(1.15); }
.swatch.picked { border-color:#0f172a; }
.toggle-row { display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--border); }
.toggle-row:last-child { border-bottom:none; }
.toggle-label { font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text); }
.toggle-sub { font-size:11.5px;color:var(--text3);margin-top:2px; }
.switch { position:relative;width:40px;height:22px;flex-shrink:0; }
.switch input { opacity:0;width:0;height:0; }
.slider-sw { position:absolute;inset:0;background:#cbd5e1;border-radius:11px;cursor:pointer;transition:.2s; }
.slider-sw:before { position:absolute;content:"";height:16px;width:16px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:.2s; }
input:checked + .slider-sw { background:var(--brand-600); }
input:checked + .slider-sw:before { transform:translateX(18px); }
.info-box { background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm);padding:12px 14px;font-size:12.5px;color:var(--brand-700);line-height:1.6; }
@media(max-width:820px) { .form-layout{grid-template-columns:1fr;} }
@media(max-width:640px) { .page{padding:16px;} }
</style>

<div class="page">
    <div class="breadcrumb">
        <a href="{{ route('admin.berita-kategori.index') }}">Kategori Berita</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <span>Tambah Kategori</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Kategori Berita</h1>
            <p class="page-sub">Buat kategori baru untuk mengelompokkan berita</p>
        </div>
        <a href="{{ route('admin.berita-kategori.index') }}" class="btn btn-secondary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.berita-kategori.store') }}" method="POST">
        @csrf
        <div class="form-layout">

            {{-- Main --}}
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-icon">
                        <svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                    </div>
                    <p class="form-card-title">Informasi Kategori</p>
                </div>
                <div class="form-card-body">
                    <div class="form-grid">

                        {{-- Nama --}}
                        <div class="form-group">
                            <label class="form-label">Nama Kategori <span class="req">*</span></label>
                            <input type="text" name="nama"
                                class="form-control"
                                value="{{ old('nama') }}"
                                placeholder="Contoh: Berita Sekolah"
                                required
                                oninput="syncSlug(this.value)">
                            @error('nama')<span class="form-error">{{ $message }}</span>@enderror
                        </div>

                        {{-- Slug preview --}}
                        <div class="form-group">
                            <label class="form-label">Slug (otomatis)</label>
                            <input type="text" id="slugPreview"
                                class="form-control form-control-readonly"
                                readonly
                                value="{{ old('nama') ? Str::slug(old('nama')) : '' }}"
                                placeholder="nama-kategori">
                            <span class="form-hint">Dibuat otomatis dari nama, digunakan sebagai URL.</span>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="form-group">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3"
                                placeholder="Deskripsi singkat kategori (opsional)...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')<span class="form-error">{{ $message }}</span>@enderror
                        </div>

                        {{-- Warna --}}
                        <div class="form-group">
                            <label class="form-label">Warna Label</label>
                            <div class="color-row">
                                <input type="color" id="colorPicker"
                                    value="{{ old('warna', '#3582f0') }}"
                                    oninput="setColor(this.value)">
                                <div class="color-text" id="colorDisplay"
                                    style="background:{{ old('warna','#3582f0') }}20;color:{{ old('warna','#3582f0') }};">
                                    <span id="colorHexLabel">{{ old('warna','#3582f0') }}</span>
                                </div>
                            </div>
                            <input type="hidden" name="warna" id="colorHidden" value="{{ old('warna','#3582f0') }}">
                            <div class="swatches">
                                @foreach(['#3582f0','#15803d','#dc2626','#a16207','#7c3aed','#0891b2','#c2410c','#be185d','#475569','#0f172a'] as $c)
                                    <span class="swatch {{ old('warna','#3582f0') === $c ? 'picked' : '' }}"
                                        style="background:{{ $c }};"
                                        onclick="setColor('{{ $c }}')"
                                        title="{{ $c }}"></span>
                                @endforeach
                            </div>
                            <span class="form-hint">Warna dipakai sebagai label pada daftar berita.</span>
                        </div>

                        {{-- Urutan --}}
                        <div class="form-group">
                            <label class="form-label">Urutan Tampil</label>
                            <input type="number" name="urutan"
                                class="form-control"
                                value="{{ old('urutan') }}"
                                min="0"
                                placeholder="Kosongkan → otomatis">
                            <span class="form-hint">Angka lebih kecil tampil lebih dulu. Kosongkan untuk otomatis.</span>
                            @error('urutan')<span class="form-error">{{ $message }}</span>@enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div style="display:flex;flex-direction:column;gap:16px;">

                {{-- Pengaturan --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon">
                            <svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93A10 10 0 0 0 4.93 4.93M4.93 19.07A10 10 0 0 0 19.07 19.07"/></svg>
                        </div>
                        <p class="form-card-title">Pengaturan</p>
                    </div>
                    <div class="form-card-body">
                        <div class="toggle-row">
                            <div>
                                <p class="toggle-label">Aktifkan Kategori</p>
                                <p class="toggle-sub">Tampilkan di halaman publik</p>
                            </div>
                            <label class="switch">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" name="is_published" value="1"
                                    {{ old('is_published', true) ? 'checked' : '' }}>
                                <span class="slider-sw"></span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Info --}}
                <div class="info-box">
                    <strong>💡 Tips</strong><br>
                    Slug dibuat otomatis dari nama. Warna dipakai sebagai label berwarna pada daftar berita. Urutan menentukan posisi tampil — kosongkan agar otomatis.
                </div>

                {{-- Tombol --}}
                <div style="display:flex;gap:8px;">
                    <a href="{{ route('admin.berita-kategori.index') }}"
                        class="btn btn-secondary" style="flex:1;justify-content:center;">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary" style="flex:2;justify-content:center;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Kategori
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    function syncSlug(val) {
        const slug = val.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim().replace(/\s+/g, '-').replace(/-+/g, '-');
        document.getElementById('slugPreview').value = slug;
    }

    function setColor(hex) {
        document.getElementById('colorPicker').value       = hex;
        document.getElementById('colorHidden').value       = hex;
        document.getElementById('colorHexLabel').textContent = hex;
        document.getElementById('colorDisplay').style.background = hex + '25';
        document.getElementById('colorDisplay').style.color = hex;
        document.querySelectorAll('.swatch').forEach(s =>
            s.classList.toggle('picked', s.title === hex)
        );
    }

    // Init
    setColor(document.getElementById('colorHidden').value || '#3582f0');
</script>
</x-app-layout>