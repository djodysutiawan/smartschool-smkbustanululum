<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand:      #1f63db;
        --brand-h:    #3582f0;
        --brand-50:   #eef6ff;
        --brand-100:  #d9ebff;
        --brand-700:  #1750c0;
        --surface:    #fff;
        --surface2:   #f8fafc;
        --surface3:   #f1f5f9;
        --border:     #e2e8f0;
        --border2:    #cbd5e1;
        --text:       #0f172a;
        --text2:      #475569;
        --text3:      #94a3b8;
        --red:        #dc2626;
        --red-bg:     #fee2e2;
        --red-border: #fecaca;
        --radius:     10px;
        --radius-sm:  7px;
    }

    .page { padding: 28px 28px 60px; max-width: 2000px; margin: 0 auto; }
    .breadcrumb { display: flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600; color: var(--text3); margin-bottom: 20px; }
    .breadcrumb a { color: var(--text3); text-decoration: none; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    .page-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; }

    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 20px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s; white-space: nowrap; }
    .btn-back    { padding: 8px 14px; font-size: 13px; background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-back:hover { background: var(--surface3); }
    .btn-cancel  { background: var(--surface); color: var(--text2); border: 1px solid var(--border); }
    .btn-cancel:hover { background: var(--surface3); }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { filter: brightness(.93); }
    .btn-primary:disabled { opacity: .6; cursor: not-allowed; filter: none; }
    .btn-show    { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-show:hover { background: var(--brand-100); }

    .alert { display: flex; align-items: flex-start; gap: 10px; padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px; font-size: 13.5px; background: var(--red-bg); color: var(--red); border: 1px solid var(--red-border); }

    .form-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; margin-bottom: 16px; }
    .form-section { padding: 20px 24px 24px; }
    .section-divider { border: none; border-top: 1px solid var(--border); margin: 0; }

    .section-label { display: flex; align-items: center; gap: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); letter-spacing: .07em; text-transform: uppercase; margin-bottom: 16px; }
    .section-label-line { flex: 1; height: 1px; background: var(--border); }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
    .col-span-2 { grid-column: span 2; }
    .col-span-3 { grid-column: span 3; }

    .field { display: flex; flex-direction: column; gap: 6px; }
    .field label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2); }
    .field label .req { color: var(--brand); margin-left: 2px; }
    .field input, .field select, .field textarea { height: 38px; padding: 0 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); background: var(--surface2); width: 100%; outline: none; transition: border-color .15s, background .15s; }
    .field textarea { height: auto; padding: 10px 12px; resize: vertical; }
    .field input:focus, .field select:focus, .field textarea:focus { border-color: var(--brand-h); background: #fff; box-shadow: 0 0 0 3px rgba(53,130,240,.1); }
    .field input::placeholder, .field textarea::placeholder { color: var(--text3); }
    .field input.is-invalid, .field select.is-invalid, .field textarea.is-invalid { border-color: var(--red); background: #fff8f8; }
    .field-error { font-size: 12px; color: var(--red); font-family: 'DM Sans', sans-serif; margin-top: -2px; }
    .field-hint  { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; margin-top: -2px; }

    /* Foto upload */
    .foto-section { display: flex; align-items: flex-start; gap: 20px; padding: 20px 24px 24px; }
    .foto-preview-wrap { width: 100px; height: 100px; flex-shrink: 0; border-radius: 14px; overflow: hidden; border: 1.5px dashed var(--border2); background: var(--surface2); display: flex; align-items: center; justify-content: center; position: relative; }
    .foto-preview-wrap img { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; }
    .foto-placeholder { display: flex; flex-direction: column; align-items: center; gap: 4px; }
    .foto-placeholder span { font-size: 10px; color: var(--text3); font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; }
    .foto-meta .foto-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
    .foto-meta .foto-hint { font-size: 12px; color: var(--text3); margin-bottom: 10px; }
    .foto-input-wrap { position: relative; display: inline-block; }
    .foto-input-wrap input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .btn-upload { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: var(--radius-sm); background: var(--surface2); color: var(--text2); border: 1px solid var(--border); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; cursor: pointer; }
    .foto-file-info { display: flex; align-items: center; gap: 8px; margin-top: 8px; }
    .foto-filename { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; }
    .foto-filesize { font-size: 11.5px; color: var(--text3); background: var(--surface3); border-radius: 4px; padding: 1px 6px; display: none; }
    .btn-remove-foto { display: none; align-items: center; gap: 4px; background: none; border: none; cursor: pointer; color: var(--red); font-size: 11.5px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; padding: 2px 6px; border-radius: 4px; }
    .btn-remove-foto:hover { background: var(--red-bg); }

    /* Tanggal keluar */
    .keluar-field { display: none; }
    .keluar-field.show { display: flex; }

    .form-footer { display: flex; align-items: center; justify-content: flex-end; gap: 10px; padding: 16px 24px; background: var(--surface2); border-top: 1px solid var(--border); }

    @media (max-width: 680px) {
        .page { padding: 16px 16px 40px; }
        .form-grid, .form-grid-3 { grid-template-columns: 1fr; }
        .col-span-2, .col-span-3 { grid-column: span 1; }
        .foto-section { flex-direction: column; }
    }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.siswa.index') }}">Data Siswa</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.siswa.show', $siswa->id) }}">{{ $siswa->nama_lengkap }}</a>
        <span class="sep">›</span>
        <span class="current">Edit</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Data Siswa</h1>
            <p class="page-sub">Perbarui data siswa: <strong>{{ $siswa->nama_lengkap }}</strong></p>
        </div>
        <div style="display:flex;gap:8px">
            <a href="{{ route('admin.siswa.show', $siswa->id) }}" class="btn btn-show">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Lihat Detail
            </a>
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-back">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="alert">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>
                <strong style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">Terdapat {{ $errors->count() }} kesalahan:</strong>
                <ul style="margin:6px 0 0 16px;display:flex;flex-direction:column;gap:2px">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
        @csrf @method('PUT')

        {{-- ═══ 1. DATA IDENTITAS ═══ --}}
        <div class="form-card">
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    Data Identitas Siswa
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Nama Lengkap <span class="req">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" class="{{ $errors->has('nama_lengkap') ? 'is-invalid' : '' }}">
                        @error('nama_lengkap')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>NIS <span class="req">*</span></label>
                        <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" class="{{ $errors->has('nis') ? 'is-invalid' : '' }}">
                        @error('nis')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>NISN</label>
                        <input type="text" name="nisn" value="{{ old('nisn', $siswa->nisn) }}" class="{{ $errors->has('nisn') ? 'is-invalid' : '' }}">
                        @error('nisn')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Jenis Kelamin <span class="req">*</span></label>
                        <select name="jenis_kelamin" class="{{ $errors->has('jenis_kelamin') ? 'is-invalid' : '' }}">
                            <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                    </div>
                    <div class="field">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ? date('Y-m-d', strtotime($siswa->tanggal_lahir)) : '') }}" class="{{ $errors->has('tanggal_lahir') ? 'is-invalid' : '' }}">
                        @error('tanggal_lahir')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Agama</label>
                        <select name="agama">
                            <option value="">— Pilih —</option>
                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                                <option value="{{ $ag }}" {{ old('agama', $siswa->agama) == $ag ? 'selected' : '' }}>{{ $ag }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>No. HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $siswa->no_hp) }}" inputmode="numeric">
                    </div>
                    <div class="field">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $siswa->email) }}" class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field col-span-2">
                        <label>Alamat</label>
                        <textarea name="alamat" rows="2">{{ old('alamat', $siswa->alamat) }}</textarea>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            {{-- ═══ 2. KELAS ═══ --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                    Penempatan Kelas
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Kelas <span class="req">*</span></label>
                        <select name="kelas_id" class="{{ $errors->has('kelas_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Kelas —</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }} ({{ $k->tahunAjaran->tahun ?? '' }})
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tahun Ajaran <span class="req">*</span></label>
                        <select name="tahun_ajaran_id" class="{{ $errors->has('tahun_ajaran_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih —</option>
                            @foreach($tahunAjarans as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id', $siswa->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun }} - {{ ucfirst($ta->semester) }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Status <span class="req">*</span></label>
                        <select name="status" id="statusSelect" class="{{ $errors->has('status') ? 'is-invalid' : '' }}">
                            @foreach(['aktif','tidak_aktif','lulus','pindah','keluar'] as $st)
                                <option value="{{ $st }}" {{ old('status', $siswa->status) == $st ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_',' ',$st)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $siswa->tanggal_masuk ? date('Y-m-d', strtotime($siswa->tanggal_masuk)) : '') }}">
                    </div>
                    <div class="field keluar-field {{ in_array(old('status', $siswa->status), ['lulus','pindah','keluar']) ? 'show' : '' }}" id="keluarField">
                        <label>Tanggal Keluar</label>
                        <input type="date" name="tanggal_keluar" value="{{ old('tanggal_keluar', $siswa->tanggal_keluar ? date('Y-m-d', strtotime($siswa->tanggal_keluar)) : '') }}">
                        @error('tanggal_keluar')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            {{-- ═══ 3. DATA ORANG TUA ═══ --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Data Orang Tua / Wali
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid-3">
                    <div class="field"><label>Nama Ayah</label><input type="text" name="nama_ayah" value="{{ old('nama_ayah', $siswa->nama_ayah) }}"></div>
                    <div class="field"><label>Pekerjaan Ayah</label><input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) }}"></div>
                    <div class="field"><label>No. HP Ayah</label><input type="text" name="no_hp_ayah" value="{{ old('no_hp_ayah', $siswa->no_hp_ayah) }}" inputmode="numeric"></div>

                    <div class="field"><label>Nama Ibu</label><input type="text" name="nama_ibu" value="{{ old('nama_ibu', $siswa->nama_ibu) }}"></div>
                    <div class="field"><label>Pekerjaan Ibu</label><input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) }}"></div>
                    <div class="field"><label>No. HP Ibu</label><input type="text" name="no_hp_ibu" value="{{ old('no_hp_ibu', $siswa->no_hp_ibu) }}" inputmode="numeric"></div>

                    <div class="field"><label>Nama Wali</label><input type="text" name="nama_wali" value="{{ old('nama_wali', $siswa->nama_wali) }}"></div>
                    <div class="field"><label>Hubungan Wali</label><input type="text" name="hubungan_wali" value="{{ old('hubungan_wali', $siswa->hubungan_wali) }}"></div>
                    <div class="field"><label>No. HP Wali</label><input type="text" name="no_hp_wali" value="{{ old('no_hp_wali', $siswa->no_hp_wali) }}" inputmode="numeric"></div>
                </div>
            </div>

            <hr class="section-divider">

            {{-- ═══ 4. FOTO ═══ --}}
            <div class="foto-section">
                <div class="foto-preview-wrap">
                    @if($siswa->foto)
                        <img id="previewImage" src="{{ asset('storage/'.$siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}">
                        <div class="foto-placeholder" id="fotoPlaceholder" style="display:none">
                            <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                            <span>Preview</span>
                        </div>
                    @else
                        <img id="previewImage" src="" alt="" style="display:none">
                        <div class="foto-placeholder" id="fotoPlaceholder">
                            <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                            <span>Preview</span>
                        </div>
                    @endif
                </div>
                <div class="foto-meta">
                    <p class="foto-label">Foto Siswa</p>
                    <p class="foto-hint">
                        @if($siswa->foto) Foto saat ini akan diganti jika Anda memilih file baru. @else Format JPG / PNG, maks. 2 MB. @endif
                    </p>
                    <div class="foto-input-wrap">
                        <input type="file" name="foto" id="fotoInput" accept="image/jpg,image/jpeg,image/png">
                        <div class="btn-upload">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            {{ $siswa->foto ? 'Ganti Foto' : 'Pilih File' }}
                        </div>
                    </div>
                    <div class="foto-file-info">
                        <span class="foto-filename" id="fotoFilename">{{ $siswa->foto ? 'Foto saat ini tersimpan' : 'Belum ada file dipilih' }}</span>
                        <span class="foto-filesize" id="fotoFilesize"></span>
                        <button type="button" class="btn-remove-foto" id="btnRemoveFoto" onclick="removeFoto()" style="{{ $siswa->foto ? 'display:inline-flex' : 'display:none' }}">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            Hapus
                        </button>
                    </div>
                    @error('foto')<span class="field-error" style="margin-top:4px;display:block">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.siswa.show', $siswa->id) }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Perbarui Data
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif
    @if($errors->any())
    Swal.fire({
        icon:'error', title:'Terdapat {{ $errors->count() }} Kesalahan',
        html:`<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`,
        confirmButtonColor:'#1f63db',
    });
    @endif

    // Tampilkan tanggal keluar jika status lulus/pindah/keluar
    document.getElementById('statusSelect').addEventListener('change', function() {
        const needsDate = ['lulus','pindah','keluar'].includes(this.value);
        document.getElementById('keluarField').classList.toggle('show', needsDate);
    });

    // Foto preview
    document.getElementById('fotoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({ icon:'warning', title:'File Terlalu Besar', text:'Ukuran file melebihi 2 MB.', confirmButtonColor:'#1f63db' });
            this.value = ''; return;
        }
        document.getElementById('previewImage').src = URL.createObjectURL(file);
        document.getElementById('previewImage').style.display = 'block';
        document.getElementById('fotoPlaceholder').style.display = 'none';
        document.getElementById('fotoFilename').textContent = file.name;
        document.getElementById('fotoFilename').style.color = 'var(--text2)';
        document.getElementById('fotoFilesize').textContent = (file.size / (1024*1024)).toFixed(2) + ' MB';
        document.getElementById('fotoFilesize').style.display = 'inline';
        document.getElementById('btnRemoveFoto').style.display = 'inline-flex';
    });
    function removeFoto() {
        document.getElementById('fotoInput').value = '';
        document.getElementById('previewImage').style.display = 'none';
        document.getElementById('previewImage').src = '';
        document.getElementById('fotoPlaceholder').style.display = 'flex';
        document.getElementById('fotoFilename').textContent = 'Belum ada file dipilih';
        document.getElementById('fotoFilename').style.color = '';
        document.getElementById('fotoFilesize').style.display = 'none';
        document.getElementById('btnRemoveFoto').style.display = 'none';
    }

    document.getElementById('editForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>