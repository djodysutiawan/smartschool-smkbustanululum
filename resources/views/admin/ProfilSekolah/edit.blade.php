@php use Illuminate\Support\Facades\Storage; @endphp
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
        --success:   #15803d;
        --danger:    #dc2626;
    }

    /* ── Layout ───────────────────────────── */
    .page { padding: 28px 28px 60px; }

    .page-header {
        display: flex; align-items: flex-start;
        justify-content: space-between; gap: 16px;
        margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2;
    }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; }

    /* ── Buttons ──────────────────────────── */
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 20px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: filter .15s; white-space: nowrap;
    }
    .btn:hover { filter: brightness(.93); }
    .btn-primary { background: var(--brand-600); color: #fff; }
    .btn-secondary {
        background: var(--surface2); color: var(--text2);
        border: 1px solid var(--border);
    }
    .btn-secondary:hover { background: var(--surface3); filter: none; }

    /* ── Tab Nav ──────────────────────────── */
    .tab-nav {
        display: flex; gap: 2px; flex-wrap: wrap;
        border-bottom: 2px solid var(--border);
        margin-bottom: 20px;
    }
    .tab-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 10px 16px; border: none; background: none; cursor: pointer;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px; font-weight: 600; color: var(--text3);
        border-bottom: 2px solid transparent; margin-bottom: -2px;
        border-radius: 6px 6px 0 0; transition: color .15s;
    }
    .tab-btn:hover { color: var(--text2); background: var(--surface2); }
    .tab-btn.active { color: var(--brand-600); border-bottom-color: var(--brand-600); }
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* ── Section Card ─────────────────────── */
    .section-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 16px;
    }
    .section-head {
        display: flex; align-items: center; gap: 10px;
        padding: 14px 20px; border-bottom: 1px solid var(--border);
        background: var(--surface2);
    }
    .section-icon {
        width: 32px; height: 32px; border-radius: 8px;
        background: var(--brand-50); display: flex;
        align-items: center; justify-content: center; flex-shrink: 0;
    }
    .section-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13.5px; font-weight: 700; color: var(--text);
    }
    .section-sub { font-size: 12px; color: var(--text3); margin-top: 1px; }
    .section-body { padding: 20px; }

    /* ── Form Grid ────────────────────────── */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 16px;
    }
    .form-grid.cols-2 { grid-template-columns: repeat(2, 1fr); }
    .form-grid.cols-3 { grid-template-columns: repeat(3, 1fr); }
    .form-grid.cols-1 { grid-template-columns: 1fr; }
    .col-full { grid-column: 1 / -1; }

    .form-group { display: flex; flex-direction: column; gap: 5px; }
    .form-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px; font-weight: 700; color: var(--text2);
        letter-spacing: .03em; text-transform: uppercase;
    }
    .form-label .req { color: var(--danger); margin-left: 2px; }
    .form-hint { font-size: 11.5px; color: var(--text3); margin-top: 2px; }

    .form-input, .form-select, .form-textarea {
        width: 100%; padding: 9px 12px;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif; font-size: 13.5px;
        color: var(--text); background: var(--surface2);
        outline: none; transition: border-color .15s, background .15s;
        box-sizing: border-box;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: var(--brand-500); background: #fff;
        box-shadow: 0 0 0 3px rgba(53,130,240,.1);
    }
    .form-input::placeholder, .form-textarea::placeholder { color: var(--text3); }
    .form-textarea { resize: vertical; min-height: 90px; line-height: 1.6; }

    .form-error {
        font-size: 11.5px; color: var(--danger); margin-top: 2px;
    }
    .form-input.is-error, .form-select.is-error, .form-textarea.is-error {
        border-color: var(--danger);
    }

    /* ── File Upload ──────────────────────── */
    .upload-wrap {
        border: 1.5px dashed var(--border2); border-radius: var(--radius);
        padding: 16px; display: flex; align-items: center; gap: 14px;
        background: var(--surface2); transition: border-color .15s;
        cursor: pointer;
    }
    .upload-wrap:hover { border-color: var(--brand-500); background: var(--brand-50); }
    .upload-preview {
        width: 64px; height: 64px; border-radius: 8px;
        object-fit: cover; border: 1px solid var(--border);
        background: var(--surface); flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden;
    }
    .upload-preview img { width: 100%; height: 100%; object-fit: cover; }
    .upload-preview-icon { color: var(--text3); }
    .upload-meta { flex: 1; min-width: 0; }
    .upload-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px; font-weight: 700; color: var(--text);
    }
    .upload-sub { font-size: 11.5px; color: var(--text3); margin-top: 2px; }
    .upload-btn {
        display: inline-flex; align-items: center; gap: 5px;
        margin-top: 8px; padding: 5px 12px;
        border: 1px solid var(--border2); border-radius: 6px;
        background: #fff; font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px; font-weight: 600; color: var(--text2);
        cursor: pointer; transition: background .15s;
    }
    .upload-btn:hover { background: var(--surface3); }
    .upload-input { display: none; }

    /* ── Form Actions ─────────────────────── */
    .form-actions {
        display: flex; align-items: center; justify-content: flex-end;
        gap: 10px; padding: 18px 20px;
        border-top: 1px solid var(--border);
        background: var(--surface2); border-radius: 0 0 var(--radius) var(--radius);
    }

    /* ── Alert ────────────────────────────── */
    .alert {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 16px; border-radius: var(--radius);
        font-size: 13.5px; margin-bottom: 16px;
    }
    .alert-error { background: #fff0f0; border: 1px solid #fecaca; color: var(--danger); }
    .alert-error ul { margin: 4px 0 0 16px; padding: 0; }
    .alert-error li { margin-top: 2px; font-size: 12.5px; }

    /* ── Sosmed Row ───────────────────────── */
    .sosmed-row {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 0; border-bottom: 1px solid var(--surface3);
    }
    .sosmed-row:last-child { border-bottom: none; padding-bottom: 0; }
    .sosmed-icon {
        width: 36px; height: 36px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 16px;
    }
    .sosmed-name {
        width: 110px; flex-shrink: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px; font-weight: 700; color: var(--text2);
    }
    .sosmed-input { flex: 1; }

    @media (max-width: 640px) {
        .page { padding: 16px; }
        .form-grid { grid-template-columns: 1fr; }
        .form-grid.cols-2, .form-grid.cols-3 { grid-template-columns: 1fr; }
        .tab-btn { padding: 8px 12px; font-size: 12px; }
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Profil Sekolah</h1>
            <p class="page-sub">Kelola identitas, kontak, sosial media, dan informasi umum sekolah</p>
        </div>
    </div>

    {{-- Error Alert --}}
    @if($errors->any())
    <div class="alert alert-error">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            <strong>Terdapat kesalahan validasi:</strong>
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.profil-sekolah.update') }}"
          enctype="multipart/form-data" id="profilForm">
        @csrf
        @method('PUT')

        {{-- Tab Navigation --}}
        <div class="tab-nav">
            <button type="button" class="tab-btn active" data-tab="identitas">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                Identitas
            </button>
            <button type="button" class="tab-btn" data-tab="alamat">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                Alamat
            </button>
            <button type="button" class="tab-btn" data-tab="kontak">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.27 18a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91A16 16 0 0 0 14 15.91l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                Kontak
            </button>
            <button type="button" class="tab-btn" data-tab="sosmed">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                Sosial Media
            </button>
            <button type="button" class="tab-btn" data-tab="kepsek">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Kepala Sekolah
            </button>
            <button type="button" class="tab-btn" data-tab="teks">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                Visi & Misi
            </button>
            <button type="button" class="tab-btn" data-tab="media">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                Media
            </button>
            <button type="button" class="tab-btn" data-tab="seo">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                SEO
            </button>
        </div>

        {{-- ══════════════════════════════════════════════ --}}
        {{-- TAB: IDENTITAS --}}
        {{-- ══════════════════════════════════════════════ --}}
        <div class="tab-panel active" id="tab-identitas">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-icon">
                        <svg width="16" height="16" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    </div>
                    <div>
                        <p class="section-title">Identitas Sekolah</p>
                        <p class="section-sub">Informasi dasar dan legalitas sekolah</p>
                    </div>
                </div>
                <div class="section-body">
                    <div class="form-grid">
                        <div class="form-group col-full">
                            <label class="form-label">Nama Sekolah <span class="req">*</span></label>
                            <input type="text" name="nama_sekolah" class="form-input @error('nama_sekolah') is-error @enderror"
                                value="{{ old('nama_sekolah', $profil->nama_sekolah === '-' ? '' : $profil->nama_sekolah) }}"
                                placeholder="Contoh: SMA Negeri 1 Bandung">
                            @error('nama_sekolah')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Singkatan</label>
                            <input type="text" name="singkatan" class="form-input @error('singkatan') is-error @enderror"
                                value="{{ old('singkatan', $profil->singkatan) }}"
                                placeholder="Contoh: SMAN 1 BDG">
                            @error('singkatan')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">NPSN</label>
                            <input type="text" name="npsn" class="form-input @error('npsn') is-error @enderror"
                                value="{{ old('npsn', $profil->npsn) }}"
                                placeholder="8 digit NPSN">
                            @error('npsn')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">NSS</label>
                            <input type="text" name="nss" class="form-input @error('nss') is-error @enderror"
                                value="{{ old('nss', $profil->nss) }}"
                                placeholder="Nomor Statistik Sekolah">
                            @error('nss')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Akreditasi</label>
                            <select name="akreditasi" class="form-select @error('akreditasi') is-error @enderror">
                                <option value="">-- Pilih --</option>
                                @foreach(['A','B','C','TT'] as $ak)
                                    <option value="{{ $ak }}" {{ old('akreditasi', $profil->akreditasi) == $ak ? 'selected' : '' }}>
                                        {{ $ak }}
                                    </option>
                                @endforeach
                            </select>
                            @error('akreditasi')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tahun Berdiri</label>
                            <input type="number" name="tahun_berdiri" class="form-input @error('tahun_berdiri') is-error @enderror"
                                value="{{ old('tahun_berdiri', $profil->tahun_berdiri) }}"
                                placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y') }}">
                            @error('tahun_berdiri')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status Sekolah</label>
                            <select name="status_sekolah" class="form-select @error('status_sekolah') is-error @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="negeri"  {{ old('status_sekolah', $profil->status_sekolah) == 'negeri'  ? 'selected' : '' }}>Negeri</option>
                                <option value="swasta"  {{ old('status_sekolah', $profil->status_sekolah) == 'swasta'  ? 'selected' : '' }}>Swasta</option>
                            </select>
                            @error('status_sekolah')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jenjang</label>
                            <select name="jenjang" class="form-select @error('jenjang') is-error @enderror">
                                <option value="">-- Pilih --</option>
                                @foreach(['SD','SMP','SMA','SMK','MA','MTs','MI'] as $j)
                                    <option value="{{ $j }}" {{ old('jenjang', $profil->jenjang) == $j ? 'selected' : '' }}>{{ $j }}</option>
                                @endforeach
                            </select>
                            @error('jenjang')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════ --}}
        {{-- TAB: ALAMAT --}}
        {{-- ══════════════════════════════════════════════ --}}
        <div class="tab-panel" id="tab-alamat">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-icon">
                        <svg width="16" height="16" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                    </div>
                    <div>
                        <p class="section-title">Alamat & Lokasi</p>
                        <p class="section-sub">Lokasi fisik dan koordinat sekolah</p>
                    </div>
                </div>
                <div class="section-body">
                    <div class="form-grid">
                        <div class="form-group col-full">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" class="form-textarea @error('alamat_lengkap') is-error @enderror"
                                placeholder="Jl. Contoh No. 1, RT/RW ...">{{ old('alamat_lengkap', $profil->alamat_lengkap) }}</textarea>
                            @error('alamat_lengkap')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Desa / Kelurahan</label>
                            <input type="text" name="desa_kelurahan" class="form-input"
                                value="{{ old('desa_kelurahan', $profil->desa_kelurahan) }}"
                                placeholder="Nama desa/kelurahan">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-input"
                                value="{{ old('kecamatan', $profil->kecamatan) }}"
                                placeholder="Nama kecamatan">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kabupaten / Kota</label>
                            <input type="text" name="kabupaten_kota" class="form-input"
                                value="{{ old('kabupaten_kota', $profil->kabupaten_kota) }}"
                                placeholder="Nama kabupaten/kota">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="provinsi" class="form-input"
                                value="{{ old('provinsi', $profil->provinsi) }}"
                                placeholder="Nama provinsi">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="kode_pos" class="form-input"
                                value="{{ old('kode_pos', $profil->kode_pos) }}"
                                placeholder="40000">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Latitude</label>
                            <input type="number" name="latitude" class="form-input @error('latitude') is-error @enderror"
                                value="{{ old('latitude', $profil->latitude) }}"
                                placeholder="-6.9175" step="any">
                            @error('latitude')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Longitude</label>
                            <input type="number" name="longitude" class="form-input @error('longitude') is-error @enderror"
                                value="{{ old('longitude', $profil->longitude) }}"
                                placeholder="107.6191" step="any">
                            @error('longitude')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group col-full">
                            <label class="form-label">Embed Google Maps URL</label>
                            <input type="url" name="embed_maps_url" class="form-input @error('embed_maps_url') is-error @enderror"
                                value="{{ old('embed_maps_url', $profil->embed_maps_url) }}"
                                placeholder="https://maps.google.com/maps?...">
                            <p class="form-hint">URL dari tombol "Bagikan → Sematkan peta" di Google Maps</p>
                            @error('embed_maps_url')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════ --}}
        {{-- TAB: KONTAK --}}
        {{-- ══════════════════════════════════════════════ --}}
        <div class="tab-panel" id="tab-kontak">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-icon">
                        <svg width="16" height="16" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.27 18a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91A16 16 0 0 0 14 15.91l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <div>
                        <p class="section-title">Kontak Sekolah</p>
                        <p class="section-sub">Nomor telepon, email, dan website resmi</p>
                    </div>
                </div>
                <div class="section-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="telepon" class="form-input"
                                value="{{ old('telepon', $profil->telepon) }}"
                                placeholder="022-1234567">
                        </div>

                        <div class="form-group">
                            <label class="form-label">WhatsApp</label>
                            <input type="text" name="whatsapp" class="form-input"
                                value="{{ old('whatsapp', $profil->whatsapp) }}"
                                placeholder="628xxxxxxxxxx">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Fax</label>
                            <input type="text" name="fax" class="form-input"
                                value="{{ old('fax', $profil->fax) }}"
                                placeholder="022-7654321">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email Sekolah</label>
                            <input type="email" name="email_sekolah" class="form-input @error('email_sekolah') is-error @enderror"
                                value="{{ old('email_sekolah', $profil->email_sekolah) }}"
                                placeholder="info@sekolah.sch.id">
                            @error('email_sekolah')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group col-full">
                            <label class="form-label">Website Resmi</label>
                            <input type="url" name="website" class="form-input @error('website') is-error @enderror"
                                value="{{ old('website', $profil->website) }}"
                                placeholder="https://www.sekolah.sch.id">
                            @error('website')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════ --}}
        {{-- TAB: SOSIAL MEDIA --}}
        {{-- ══════════════════════════════════════════════ --}}
        <div class="tab-panel" id="tab-sosmed">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-icon">
                        <svg width="16" height="16" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                    </div>
                    <div>
                        <p class="section-title">Media Sosial</p>
                        <p class="section-sub">Link akun sosial media resmi sekolah</p>
                    </div>
                </div>
                <div class="section-body">
                    @php
                        $sosmeds = [
                            ['name'=>'instagram_url',  'label'=>'Instagram',  'color'=>'#e1306c', 'bg'=>'#fdf2f8', 'ph'=>'https://instagram.com/sekolahanda'],
                            ['name'=>'facebook_url',   'label'=>'Facebook',   'color'=>'#1877f2', 'bg'=>'#eff6ff', 'ph'=>'https://facebook.com/sekolahanda'],
                            ['name'=>'youtube_url',    'label'=>'YouTube',    'color'=>'#ff0000', 'bg'=>'#fff5f5', 'ph'=>'https://youtube.com/@sekolahanda'],
                            ['name'=>'tiktok_url',     'label'=>'TikTok',     'color'=>'#010101', 'bg'=>'#f8fafc', 'ph'=>'https://tiktok.com/@sekolahanda'],
                            ['name'=>'twitter_url',    'label'=>'Twitter/X',  'color'=>'#000000', 'bg'=>'#f8fafc', 'ph'=>'https://twitter.com/sekolahanda'],
                            ['name'=>'linkedin_url',   'label'=>'LinkedIn',   'color'=>'#0a66c2', 'bg'=>'#eff6ff', 'ph'=>'https://linkedin.com/school/sekolahanda'],
                            ['name'=>'telegram_url',   'label'=>'Telegram',   'color'=>'#2ca5e0', 'bg'=>'#eff6ff', 'ph'=>'https://t.me/sekolahanda'],
                        ];
                    @endphp

                    @foreach($sosmeds as $sm)
                    <div class="sosmed-row">
                        <div class="sosmed-icon" style="background:{{ $sm['bg'] }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="{{ $sm['color'] }}">
                                @if($sm['name'] === 'instagram_url')
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                @elseif($sm['name'] === 'facebook_url')
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                @elseif($sm['name'] === 'youtube_url')
                                    <path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/>
                                @elseif($sm['name'] === 'tiktok_url')
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                @elseif($sm['name'] === 'twitter_url')
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                @elseif($sm['name'] === 'linkedin_url')
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                @elseif($sm['name'] === 'telegram_url')
                                    <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                                @endif
                            </svg>
                        </div>
                        <span class="sosmed-name">{{ $sm['label'] }}</span>
                        <div class="sosmed-input">
                            <input type="url" name="{{ $sm['name'] }}" class="form-input @error($sm['name']) is-error @enderror"
                                value="{{ old($sm['name'], $profil->{$sm['name']}) }}"
                                placeholder="{{ $sm['ph'] }}">
                            @error($sm['name'])<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════ --}}
        {{-- TAB: KEPALA SEKOLAH --}}
        {{-- ══════════════════════════════════════════════ --}}
        <div class="tab-panel" id="tab-kepsek">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-icon">
                        <svg width="16" height="16" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <p class="section-title">Data Kepala Sekolah</p>
                        <p class="section-sub">Informasi dan sambutan kepala sekolah</p>
                    </div>
                </div>
                <div class="section-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nama Kepala Sekolah</label>
                            <input type="text" name="nama_kepsek" class="form-input"
                                value="{{ old('nama_kepsek', $profil->nama_kepsek) }}"
                                placeholder="Drs. Nama Lengkap, M.Pd">
                        </div>

                        <div class="form-group">
                            <label class="form-label">NIP Kepala Sekolah</label>
                            <input type="text" name="nip_kepsek" class="form-input"
                                value="{{ old('nip_kepsek', $profil->nip_kepsek) }}"
                                placeholder="19XXXXXXXXXXXXXXX">
                        </div>

                        {{-- Foto Kepala Sekolah --}}
                        <div class="form-group col-full">
                            <label class="form-label">Foto Kepala Sekolah</label>
                            <label class="upload-wrap" for="foto_kepsek_input">
                                <div class="upload-preview" id="kepsek-preview">
                                    @if($profil->foto_kepsek_src)
                                        <img src="{{ $profil->foto_kepsek_src }}" id="kepsek-img" alt="Foto Kepsek">
                                    @else
                                        <svg class="upload-preview-icon" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    @endif
                                </div>
                                <div class="upload-meta">
                                    <p class="upload-label">Upload Foto Kepala Sekolah</p>
                                    <p class="upload-sub">JPG, PNG, WebP — maks. 2MB</p>
                                    <span class="upload-btn">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                        Pilih File
                                    </span>
                                </div>
                                <input type="file" id="foto_kepsek_input" name="foto_kepsek"
                                    class="upload-input" accept="image/jpg,image/jpeg,image/png,image/webp"
                                    onchange="previewImage(this,'kepsek-preview','kepsek-img')">
                            </label>
                            <p class="form-hint">— atau isi URL eksternal di bawah ini</p>
                            <input type="url" name="foto_kepsek_url" class="form-input" style="margin-top:8px"
                                value="{{ old('foto_kepsek_url', $profil->foto_kepsek_url) }}"
                                placeholder="https://...url foto kepsek...">
                            @error('foto_kepsek')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group col-full">
                            <label class="form-label">Sambutan Kepala Sekolah</label>
                            <textarea name="sambutan_kepsek" class="form-textarea" style="min-height:140px"
                                placeholder="Tuliskan sambutan kepala sekolah di sini...">{{ old('sambutan_kepsek', $profil->sambutan_kepsek) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════ --}}
        {{-- TAB: VISI & MISI --}}
        {{-- ══════════════════════════════════════════════ --}}
        <div class="tab-panel" id="tab-teks">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-icon">
                        <svg width="16" height="16" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div>
                        <p class="section-title">Visi, Misi & Informasi Umum</p>
                        <p class="section-sub">Teks konten halaman profil sekolah</p>
                    </div>
                </div>
                <div class="section-body">
                    <div class="form-grid cols-1">
                        <div class="form-group">
                            <label class="form-label">Visi Sekolah</label>
                            <textarea name="visi" class="form-textarea" style="min-height:100px"
                                placeholder="Tuliskan visi sekolah...">{{ old('visi', $profil->visi) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Misi Sekolah</label>
                            <textarea name="misi" class="form-textarea" style="min-height:120px"
                                placeholder="Tuliskan misi sekolah (bisa poin-poin)...">{{ old('misi', $profil->misi) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tujuan Sekolah</label>
                            <textarea name="tujuan_sekolah" class="form-textarea" style="min-height:100px"
                                placeholder="Tuliskan tujuan sekolah...">{{ old('tujuan_sekolah', $profil->tujuan_sekolah) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Sejarah Singkat</label>
                            <textarea name="sejarah_singkat" class="form-textarea" style="min-height:130px"
                                placeholder="Ceritakan sejarah pendirian sekolah...">{{ old('sejarah_singkat', $profil->sejarah_singkat) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Deskripsi Singkat</label>
                            <textarea name="deskripsi_singkat" class="form-textarea"
                                placeholder="Deskripsi singkat untuk keperluan SEO / pengantar halaman...">{{ old('deskripsi_singkat', $profil->deskripsi_singkat) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════ --}}
        {{-- TAB: MEDIA --}}
        {{-- ══════════════════════════════════════════════ --}}
        <div class="tab-panel" id="tab-media">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-icon">
                        <svg width="16" height="16" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                    <div>
                        <p class="section-title">Logo, Favicon & Cover</p>
                        <p class="section-sub">Aset visual utama sekolah</p>
                    </div>
                </div>
                <div class="section-body">
                    <div class="form-grid">

                        {{-- Logo --}}
                        <div class="form-group col-full">
                            <label class="form-label">Logo Sekolah</label>
                            <label class="upload-wrap" for="logo_input">
                                <div class="upload-preview" id="logo-preview">
                                    @if($profil->logo_src)
                                        <img src="{{ $profil->logo_src }}" id="logo-img" alt="Logo">
                                    @else
                                        <svg class="upload-preview-icon" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    @endif
                                </div>
                                <div class="upload-meta">
                                    <p class="upload-label">Upload Logo</p>
                                    <p class="upload-sub">JPG, PNG, SVG, WebP — maks. 2MB</p>
                                    <span class="upload-btn">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                        Pilih File
                                    </span>
                                </div>
                                <input type="file" id="logo_input" name="logo" class="upload-input"
                                    accept="image/jpg,image/jpeg,image/png,image/svg+xml,image/webp"
                                    onchange="previewImage(this,'logo-preview','logo-img')">
                            </label>
                            <p class="form-hint">— atau isi URL eksternal</p>
                            <input type="url" name="logo_url" class="form-input" style="margin-top:8px"
                                value="{{ old('logo_url', $profil->logo_url) }}"
                                placeholder="https://...url logo...">
                            @error('logo')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        {{-- Favicon --}}
                        <div class="form-group col-full">
                            <label class="form-label">Favicon</label>
                            <label class="upload-wrap" for="favicon_input">
                                <div class="upload-preview" id="favicon-preview" style="width:48px;height:48px;border-radius:6px">
                                    @if($profil->favicon_path)
                                        <img src="{{ Storage::url($profil->favicon_path) }}" id="favicon-img" alt="Favicon">
                                    @else
                                        <svg class="upload-preview-icon" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                                    @endif
                                </div>
                                <div class="upload-meta">
                                    <p class="upload-label">Upload Favicon</p>
                                    <p class="upload-sub">ICO, PNG, SVG — maks. 512KB</p>
                                    <span class="upload-btn">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                        Pilih File
                                    </span>
                                </div>
                                <input type="file" id="favicon_input" name="favicon" class="upload-input"
                                    accept="image/x-icon,image/png,image/svg+xml"
                                    onchange="previewImage(this,'favicon-preview','favicon-img')">
                            </label>
                            @error('favicon')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        {{-- Cover --}}
                        <div class="form-group col-full">
                            <label class="form-label">Foto Cover / Banner</label>
                            <label class="upload-wrap" for="cover_input" style="flex-direction:column;align-items:stretch;gap:12px">
                                <div style="width:100%;height:120px;border-radius:8px;overflow:hidden;border:1px solid var(--border);background:var(--surface);display:flex;align-items:center;justify-content:center;" id="cover-preview">
                                    @if($profil->cover_src)
                                        <img src="{{ $profil->cover_src }}" id="cover-img" alt="Cover" style="width:100%;height:100%;object-fit:cover">
                                    @else
                                        <svg class="upload-preview-icon" width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    @endif
                                </div>
                                <div style="display:flex;align-items:center;gap:12px">
                                    <div class="upload-meta">
                                        <p class="upload-label">Upload Cover / Banner</p>
                                        <p class="upload-sub">JPG, PNG, WebP — maks. 5MB (landscape 16:9 direkomendasikan)</p>
                                        <span class="upload-btn">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                            Pilih File
                                        </span>
                                    </div>
                                </div>
                                <input type="file" id="cover_input" name="cover" class="upload-input"
                                    accept="image/jpg,image/jpeg,image/png,image/webp"
                                    onchange="previewCover(this)">
                            </label>
                            <p class="form-hint">— atau isi URL eksternal</p>
                            <input type="url" name="cover_url" class="form-input" style="margin-top:8px"
                                value="{{ old('cover_url', $profil->cover_url) }}"
                                placeholder="https://...url cover...">
                            @error('cover')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════ --}}
        {{-- TAB: SEO --}}
        {{-- ══════════════════════════════════════════════ --}}
        <div class="tab-panel" id="tab-seo">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-icon">
                        <svg width="16" height="16" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                    <div>
                        <p class="section-title">Pengaturan SEO</p>
                        <p class="section-sub">Meta tag untuk mesin pencari</p>
                    </div>
                </div>
                <div class="section-body">
                    <div class="form-grid cols-1">
                        <div class="form-group">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-input @error('meta_title') is-error @enderror"
                                value="{{ old('meta_title', $profil->meta_title) }}"
                                placeholder="Judul halaman untuk SEO (maks. 60 karakter)" maxlength="255">
                            <p class="form-hint">Idealnya 50–60 karakter untuk tampil sempurna di Google</p>
                            @error('meta_title')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-textarea"
                                placeholder="Deskripsi singkat halaman (maks. 160 karakter)" maxlength="500">{{ old('meta_description', $profil->meta_description) }}</textarea>
                            <p class="form-hint">Idealnya 120–160 karakter untuk ditampilkan di snippet Google</p>
                            @error('meta_description')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Meta Keywords</label>
                            <textarea name="meta_keywords" class="form-textarea"
                                placeholder="kata kunci, dipisahkan, dengan koma" maxlength="500">{{ old('meta_keywords', $profil->meta_keywords) }}</textarea>
                            <p class="form-hint">Pisahkan setiap kata kunci dengan koma. Contoh: sekolah negeri bandung, sman 1 bandung</p>
                            @error('meta_keywords')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    /* ── Flash Messages ─────────────────────── */
    @if(session('success'))
    Swal.fire({
        icon: 'success', title: 'Berhasil!',
        text: @json(session('success')),
        timer: 2500, showConfirmButton: false,
        toast: true, position: 'top-end'
    });
    @endif
    @if(session('error'))
    Swal.fire({
        icon: 'error', title: 'Gagal!',
        text: @json(session('error')),
        confirmButtonColor: '#1f63db'
    });
    @endif

    /* ── Tab Switching ──────────────────────── */
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.tab;
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('tab-' + target).classList.add('active');
        });
    });

    /* ── Auto-open tab with validation error ── */
    @if($errors->any())
    const errorFields = @json(array_keys($errors->messages()));
    const tabFieldMap = {
        identitas: ['nama_sekolah','singkatan','npsn','nss','akreditasi','tahun_berdiri','status_sekolah','jenjang'],
        alamat:    ['alamat_lengkap','desa_kelurahan','kecamatan','kabupaten_kota','provinsi','kode_pos','latitude','longitude','embed_maps_url'],
        kontak:    ['telepon','whatsapp','fax','email_sekolah','website'],
        sosmed:    ['facebook_url','instagram_url','twitter_url','youtube_url','tiktok_url','linkedin_url','telegram_url'],
        kepsek:    ['nama_kepsek','nip_kepsek','sambutan_kepsek','foto_kepsek','foto_kepsek_url'],
        teks:      ['visi','misi','tujuan_sekolah','sejarah_singkat','deskripsi_singkat'],
        media:     ['logo','logo_url','favicon','cover','cover_url'],
        seo:       ['meta_title','meta_description','meta_keywords'],
    };
    for (const [tab, fields] of Object.entries(tabFieldMap)) {
        if (errorFields.some(f => fields.includes(f))) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            document.querySelector(`[data-tab="${tab}"]`)?.classList.add('active');
            document.getElementById(`tab-${tab}`)?.classList.add('active');
            break;
        }
    }
    @endif

    /* ── Image Preview ──────────────────────── */
    function previewImage(input, previewId, imgId) {
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById(previewId);
            let img = document.getElementById(imgId);
            if (!img) {
                preview.innerHTML = '';
                img = document.createElement('img');
                img.id = imgId;
                img.style.cssText = 'width:100%;height:100%;object-fit:cover';
                preview.appendChild(img);
            }
            img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }

    function previewCover(input) {
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('cover-preview');
            let img = document.getElementById('cover-img');
            if (!img) {
                preview.innerHTML = '';
                img = document.createElement('img');
                img.id = 'cover-img';
                img.style.cssText = 'width:100%;height:100%;object-fit:cover';
                preview.appendChild(img);
            }
            img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>
</x-app-layout>