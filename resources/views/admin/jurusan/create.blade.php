<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root {
    --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
    --brand-100:#d9ebff;--brand-50:#eef6ff;
    --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
    --border:#e2e8f0;--border2:#cbd5e1;
    --text:#0f172a;--text2:#475569;--text3:#94a3b8;
    --radius:10px;--radius-sm:7px;
}
.page { padding:28px 28px 40px; }
.page-header { display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap; }
.page-title { font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2; }
.page-sub { font-size:12.5px;color:var(--text3);margin-top:3px; }
.breadcrumb { display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--text3);margin-bottom:20px; }
.breadcrumb a { color:var(--brand-600);text-decoration:none;font-weight:600; }
.breadcrumb a:hover { text-decoration:underline; }
.btn { display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap; }
.btn:hover { filter:brightness(.93); }
.btn-primary { background:var(--brand-600);color:#fff; }
.btn-secondary { background:var(--surface2);color:var(--text2);border:1px solid var(--border); }
.btn-secondary:hover { background:var(--surface3);filter:none; }

.form-layout { display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start; }
.form-card { background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden; }
.form-card-header { padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px; }
.form-card-title { font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text); }
.form-card-icon { width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:var(--brand-50); }
.form-card-body { padding:20px; }
.form-grid { display:grid;gap:16px; }
.form-grid-2 { grid-template-columns:1fr 1fr; }
.form-group { display:flex;flex-direction:column;gap:6px; }
.form-label { font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2); }
.form-label .req { color:#dc2626;margin-left:2px; }
.form-control { width:100%;padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s,background .15s;box-sizing:border-box; }
.form-control:focus { border-color:var(--brand-500);background:#fff;box-shadow:0 0 0 3px rgba(31,99,219,.07); }
.form-control::placeholder { color:var(--text3); }
textarea.form-control { resize:vertical;min-height:90px; }
.form-hint { font-size:11.5px;color:var(--text3); }
.form-error { font-size:11.5px;color:#dc2626; }

.upload-zone { border:2px dashed var(--border2);border-radius:var(--radius);padding:20px;text-align:center;cursor:pointer;transition:all .2s;position:relative; }
.upload-zone:hover { border-color:var(--brand-500);background:var(--brand-50); }
.upload-zone input[type=file] { position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%; }
.upload-zone-icon { width:36px;height:36px;border-radius:9px;background:var(--surface2);display:flex;align-items:center;justify-content:center;margin:0 auto 8px; }
.upload-zone-text { font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text2); }
.upload-zone-hint { font-size:11px;color:var(--text3);margin-top:3px; }
.preview-img { width:100%;border-radius:var(--radius-sm);margin-top:10px;max-height:120px;object-fit:cover; }

.toggle-switch { display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--border); }
.toggle-switch:last-child { border-bottom:none; }
.toggle-label { font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text); }
.toggle-sub { font-size:11.5px;color:var(--text3);margin-top:2px; }
.switch { position:relative;width:40px;height:22px;flex-shrink:0; }
.switch input { opacity:0;width:0;height:0; }
.slider-sw { position:absolute;inset:0;background:#cbd5e1;border-radius:11px;cursor:pointer;transition:.2s; }
.slider-sw:before { position:absolute;content:"";height:16px;width:16px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:.2s; }
input:checked + .slider-sw { background:var(--brand-600); }
input:checked + .slider-sw:before { transform:translateX(18px); }

.sidebar-section { margin-bottom:16px; }
.sidebar-section:last-child { margin-bottom:0; }

@media(max-width:900px) { .form-layout { grid-template-columns:1fr; } .form-grid-2 { grid-template-columns:1fr; } }
@media(max-width:640px) { .page { padding:16px; } }
</style>

<div class="page">
    <div class="breadcrumb">
        <a href="{{ route('admin.jurusan.index') }}">Jurusan</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <span>Tambah Jurusan</span>
    </div>
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Jurusan</h1>
            <p class="page-sub">Isi data jurusan baru untuk ditambahkan ke sistem</p>
        </div>
        <a href="{{ route('admin.jurusan.index') }}" class="btn btn-secondary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.jurusan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-layout">
            {{-- Main --}}
            <div style="display:flex;flex-direction:column;gap:20px;">

                {{-- Informasi Dasar --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon"><svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/></svg></div>
                        <p class="form-card-title">Informasi Dasar</p>
                    </div>
                    <div class="form-card-body">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Nama Jurusan <span class="req">*</span></label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="cth. Teknik Komputer dan Jaringan" required>
                                @error('nama')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-grid form-grid-2">
                                <div class="form-group">
                                    <label class="form-label">Singkatan</label>
                                    <input type="text" name="singkatan" class="form-control" value="{{ old('singkatan') }}" placeholder="cth. TKJ">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Kode Jurusan</label>
                                    <input type="text" name="kode_jurusan" class="form-control" value="{{ old('kode_jurusan') }}" placeholder="cth. TKJ-01">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Bidang Keahlian</label>
                                <input type="text" name="bidang_keahlian" class="form-control" value="{{ old('bidang_keahlian') }}" placeholder="cth. Teknologi Informasi dan Komunikasi">
                            </div>
                            <div class="form-grid form-grid-2">
                                <div class="form-group">
                                    <label class="form-label">Program Keahlian</label>
                                    <input type="text" name="program_keahlian" class="form-control" value="{{ old('program_keahlian') }}" placeholder="cth. Teknik Komputer">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Kompetensi Keahlian</label>
                                    <input type="text" name="kompetensi_keahlian" class="form-control" value="{{ old('kompetensi_keahlian') }}" placeholder="cth. Teknik Komputer dan Jaringan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Deskripsi Singkat</label>
                                <textarea name="deskripsi_singkat" class="form-control" rows="2" placeholder="cth. Jurusan TKJ mempelajari instalasi jaringan, keamanan sistem, dan pemrograman dasar...">{{ old('deskripsi_singkat') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Deskripsi Lengkap</label>
                                <textarea name="deskripsi_lengkap" class="form-control" rows="4" placeholder="cth. Jurusan Teknik Komputer dan Jaringan (TKJ) membekali siswa dengan kemampuan...">{{ old('deskripsi_lengkap') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tujuan Jurusan</label>
                                <textarea name="tujuan_jurusan" class="form-control" rows="3" placeholder="cth. Tujuan dan visi jurusan...">{{ old('tujuan_jurusan') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Detail Akademik --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon"><svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></div>
                        <p class="form-card-title">Detail Akademik</p>
                    </div>
                    <div class="form-card-body">
                        <div class="form-grid form-grid-2">
                            <div class="form-group">
                                <label class="form-label">Lama Belajar (Tahun)</label>
                                <input type="number" name="lama_belajar" class="form-control" value="{{ old('lama_belajar', 3) }}" min="1" max="6">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Akreditasi</label>
                                <input type="text" name="akreditasi" class="form-control" value="{{ old('akreditasi') }}" placeholder="A / B / C">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kapasitas per Kelas</label>
                                <input type="number" name="kapasitas_per_kelas" class="form-control" value="{{ old('kapasitas_per_kelas', 50) }}" min="1">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jumlah Kelas Aktif</label>
                                <input type="number" name="jumlah_kelas_aktif" class="form-control" value="{{ old('jumlah_kelas_aktif') }}" min="0">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Total Siswa</label>
                                <input type="number" name="total_siswa" class="form-control" value="{{ old('total_siswa') }}" min="0">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Urutan Tampil</label>
                                <input type="number" name="urutan" class="form-control" value="{{ old('urutan') }}" min="0">
                                <span class="form-hint">Kosongkan untuk otomatis</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kepala Jurusan --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon"><svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                        <p class="form-card-title">Kepala Jurusan</p>
                    </div>
                    <div class="form-card-body">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Nama Kepala Jurusan</label>
                                <input type="text" name="nama_kajur" class="form-control" value="{{ old('nama_kajur') }}" placeholder="cth. Budi Santoso, S.Kom">
                            </div>
                            <div class="form-grid form-grid-2">
                                <div class="form-group">
                                    <label class="form-label">Foto Kepala Jurusan</label>
                                    <div class="upload-zone">
                                        <input type="file" name="foto_kajur" accept="image/*" onchange="previewImg(this,'prevKajur')">
                                        <div class="upload-zone-icon"><svg width="16" height="16" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg></div>
                                        <p class="upload-zone-text">Upload Foto</p>
                                        <p class="upload-zone-hint">JPG, PNG, WEBP maks 2MB</p>
                                    </div>
                                    <img id="prevKajur" class="preview-img" style="display:none">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">atau URL Foto</label>
                                    <input type="url" name="foto_kajur_url" class="form-control" value="{{ old('foto_kajur_url') }}" placeholder="https://...">
                                    <span class="form-hint">Dipakai jika tidak upload file</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div style="display:flex;flex-direction:column;gap:16px;">

                {{-- Cover & Logo --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon"><svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
                        <p class="form-card-title">Foto & Logo</p>
                    </div>
                    <div class="form-card-body">
                        <div class="sidebar-section">
                            <p class="form-label" style="margin-bottom:8px;">Foto Cover</p>
                            <div class="upload-zone">
                                <input type="file" name="foto_cover" accept="image/*" onchange="previewImg(this,'prevCover')">
                                <div class="upload-zone-icon"><svg width="16" height="16" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
                                <p class="upload-zone-text">Upload Foto Cover</p>
                                <p class="upload-zone-hint">JPG, PNG, WEBP maks 3MB</p>
                            </div>
                            <img id="prevCover" class="preview-img" style="display:none">
                            <div class="form-group" style="margin-top:10px;">
                                <label class="form-label">atau URL Cover</label>
                                <input type="url" name="foto_cover_url" class="form-control" value="{{ old('foto_cover_url') }}" placeholder="https://...">
                            </div>
                        </div>
                        <div class="sidebar-section">
                            <p class="form-label" style="margin-bottom:8px;">Logo Jurusan</p>
                            <div class="upload-zone">
                                <input type="file" name="logo" accept="image/*" onchange="previewImg(this,'prevLogo')">
                                <div class="upload-zone-icon"><svg width="16" height="16" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg></div>
                                <p class="upload-zone-text">Upload Logo</p>
                                <p class="upload-zone-hint">JPG, PNG, WEBP, SVG maks 1MB</p>
                            </div>
                            <img id="prevLogo" class="preview-img" style="display:none">
                            <div class="form-group" style="margin-top:10px;">
                                <label class="form-label">atau URL Logo</label>
                                <input type="url" name="logo_url" class="form-control" value="{{ old('logo_url') }}" placeholder="https://...">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pengaturan --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon"><svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93A10 10 0 0 0 4.93 4.93M4.93 19.07A10 10 0 0 0 19.07 19.07"/></svg></div>
                        <p class="form-card-title">Pengaturan</p>
                    </div>
                    <div class="form-card-body">
                        <div class="toggle-switch">
                            <div>
                                <p class="toggle-label">Publikasikan</p>
                                <p class="toggle-sub">Tampilkan di halaman publik</p>
                            </div>
                            <label class="switch">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published',1) ? 'checked' : '' }}>
                                <span class="slider-sw"></span>
                            </label>
                        </div>
                        <div class="toggle-switch">
                            <div>
                                <p class="toggle-label">Penerimaan Buka</p>
                                <p class="toggle-sub">Buka pendaftaran jurusan ini</p>
                            </div>
                            <label class="switch">
                                <input type="hidden" name="is_penerimaan_buka" value="0">
                                <input type="checkbox" name="is_penerimaan_buka" value="1" {{ old('is_penerimaan_buka') ? 'checked' : '' }}>
                                <span class="slider-sw"></span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div style="display:flex;gap:8px;">
                    <a href="{{ route('admin.jurusan.index') }}" class="btn btn-secondary" style="flex:1;justify-content:center;">Batal</a>
                    <button type="submit" class="btn btn-primary" style="flex:2;justify-content:center;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Jurusan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewImg(input, id) {
    const img = document.getElementById(id);
    if (input.files && input.files[0]) {
        const r = new FileReader();
        r.onload = e => { img.src = e.target.result; img.style.display = 'block'; };
        r.readAsDataURL(input.files[0]);
    }
}
</script>
</x-app-layout>