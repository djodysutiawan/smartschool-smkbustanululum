<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}', confirmButtonColor: '#1f63db' });
    @endif
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Terdapat {{ $errors->count() }} Kesalahan',
            html: `<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>`,
            confirmButtonColor: '#1f63db',
        });
    @endif
</script>

<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand:      #1f63db;
        --brand-h:    #3582f0;
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
        --green:      #15803d;
        --radius:     10px;
        --radius-sm:  7px;
    }

    /* ── Layout ── */
    .page { padding: 28px 28px 60px; max-width: 2000px; margin: 0 auto; }

    /* ── Breadcrumb ── */
    .breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600;
        color: var(--text3); margin-bottom: 20px;
    }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    /* ── Page header ── */
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }

    /* ── Buttons ── */
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 20px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: filter .15s, background .15s; white-space: nowrap;
    }
    .btn-back    { padding: 8px 14px; font-size: 13px; background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-back:hover { background: var(--surface3); }
    .btn-cancel  { background: var(--surface); color: var(--text2); border: 1px solid var(--border); }
    .btn-cancel:hover { background: var(--surface3); }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { filter: brightness(.93); }
    .btn-primary:disabled { opacity: .6; cursor: not-allowed; filter: none; }

    /* ── Alert ── */
    .alert {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px;
        font-size: 13.5px; background: var(--red-bg); color: var(--red); border: 1px solid var(--red-border);
    }
    .alert svg { flex-shrink: 0; margin-top: 1px; }

    /* ── Form card ── */
    .form-card   { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .form-section { padding: 20px 24px 24px; }
    .section-divider { border: none; border-top: 1px solid var(--border); margin: 0; }

    .section-label {
        display: flex; align-items: center; gap: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
        color: var(--text3); letter-spacing: .07em; text-transform: uppercase; margin-bottom: 16px;
    }
    .section-label-line { flex: 1; height: 1px; background: var(--border); }

    /* ── Grids ── */
    .form-grid         { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-grid.cols-3  { grid-template-columns: 1fr 1fr 1fr; }
    .col-span-2        { grid-column: span 2; }
    .col-span-3        { grid-column: span 3; }

    /* ── Fields ── */
    .field { display: flex; flex-direction: column; gap: 6px; }
    .field label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px;
        font-weight: 700; color: var(--text2);
    }
    .field label .req { color: var(--brand); margin-left: 2px; }
    .field input,
    .field select,
    .field textarea {
        height: 38px; padding: 0 12px;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif; font-size: 13.5px;
        color: var(--text); background: var(--surface2); width: 100%;
        outline: none; transition: border-color .15s, background .15s;
    }
    .field textarea { height: auto; padding: 10px 12px; resize: vertical; }
    .field input:focus,
    .field select:focus,
    .field textarea:focus {
        border-color: var(--brand-h); background: #fff;
        box-shadow: 0 0 0 3px rgba(53,130,240,.1);
    }
    .field input::placeholder,
    .field textarea::placeholder { color: var(--text3); }
    .field input.is-invalid,
    .field select.is-invalid,
    .field textarea.is-invalid { border-color: var(--red); background: #fff8f8; }
    .field-error { font-size: 12px; color: var(--red); font-family: 'DM Sans', sans-serif; margin-top: -2px; }
    .field-hint  { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; margin-top: -2px; }

    /* ── Password ── */
    .pw-wrap { position: relative; }
    .pw-wrap input { padding-right: 40px; }
    .pw-toggle {
        position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer; color: var(--text3);
        display: flex; align-items: center; transition: color .15s;
    }
    .pw-toggle:hover { color: var(--text2); }
    .pw-strength-bar  { height: 4px; border-radius: 99px; background: var(--border); overflow: hidden; margin-bottom: 4px; }
    .pw-strength-fill { height: 100%; width: 0; border-radius: 99px; transition: width .3s, background .3s; }
    .pw-strength-text { font-size: 11.5px; font-family: 'DM Sans', sans-serif; color: var(--text3); }

    /* ── Photo upload ── */
    .foto-section { display: flex; align-items: flex-start; gap: 20px; padding: 20px 24px 24px; }
    .foto-preview-wrap {
        width: 100px; height: 100px; flex-shrink: 0;
        border-radius: 14px; overflow: hidden;
        border: 1.5px dashed var(--border2); background: var(--surface2);
        display: flex; align-items: center; justify-content: center;
        position: relative; transition: border-color .15s;
    }
    .foto-preview-wrap:hover { border-color: var(--brand-h); }
    .foto-preview-wrap img   { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; }
    .foto-placeholder        { display: flex; flex-direction: column; align-items: center; gap: 4px; }
    .foto-placeholder svg    { opacity: .4; }
    .foto-placeholder span   { font-size: 10px; color: var(--text3); font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; }
    .foto-meta .foto-label   { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
    .foto-meta .foto-hint    { font-size: 12px; color: var(--text3); margin-bottom: 10px; }
    .foto-input-wrap         { position: relative; display: inline-block; }
    .foto-input-wrap input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .btn-upload {
        display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px;
        border-radius: var(--radius-sm); background: var(--surface2); color: var(--text2);
        border: 1px solid var(--border); font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px; font-weight: 700; cursor: pointer; transition: background .15s;
    }
    .btn-upload:hover { background: var(--surface3); }
    .foto-file-info { display: flex; align-items: center; gap: 8px; margin-top: 8px; }
    .foto-filename { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; }
    .foto-filesize {
        font-size: 11.5px; color: var(--text3); font-family: 'DM Sans', sans-serif;
        background: var(--surface3); border-radius: 4px; padding: 1px 6px; display: none;
    }
    .btn-remove-foto {
        display: none; align-items: center; gap: 4px;
        background: none; border: none; cursor: pointer; color: var(--red);
        font-size: 11.5px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
        padding: 2px 6px; border-radius: 4px; transition: background .15s;
    }
    .btn-remove-foto:hover { background: var(--red-bg); }

    /* ── Form footer ── */
    .form-footer {
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
        padding: 16px 24px; background: var(--surface2); border-top: 1px solid var(--border);
    }

    /* ── Sub-section heading ── */
    .sub-label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
        color: var(--text3); text-transform: uppercase; letter-spacing: .06em; margin: 0 0 10px;
    }
    .sub-label-note { font-weight: 400; text-transform: none; letter-spacing: 0; }

    /* ── Responsive ── */
    @media (max-width: 680px) {
        .page { padding: 16px 16px 40px; }
        .form-grid,
        .form-grid.cols-3 { grid-template-columns: 1fr; }
        .col-span-2,
        .col-span-3 { grid-column: span 1; }
        .foto-section { flex-direction: column; }
    }

    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.students.index') }}">Manajemen Siswa</a>
        <span class="sep">›</span>
        <span class="current">Tambah Siswa</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Siswa Baru</h1>
            <p class="page-sub">Isi semua data dengan benar, lalu klik Simpan Data</p>
        </div>
        <a href="{{ route('admin.students.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    {{-- Inline alerts (fallback jika SweetAlert gagal) --}}
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
                <strong style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">
                    Terdapat {{ $errors->count() }} kesalahan:
                </strong>
                <ul style="margin:6px 0 0 16px;display:flex;flex-direction:column;gap:2px">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data" id="studentForm">
        @csrf
        <div class="form-card">

            {{-- ═══ 1. AKUN LOGIN ═══ --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    Akun Login
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Nama User <span class="req">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            placeholder="cth. Ahmad Fauzi"
                            class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                        @error('name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Email <span class="req">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            placeholder="cth. siswa@smk.sch.id"
                            class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field col-span-2">
                        <label>Password <span class="req">*</span></label>
                        <div class="pw-wrap">
                            <input type="password" name="password" id="pwInput"
                                placeholder="Minimal 8 karakter"
                                class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                                oninput="checkStrength(this.value)">
                            <button type="button" class="pw-toggle" onclick="togglePw()">
                                <svg id="eyeShow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                                <svg id="eyeHide" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                    <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                            </button>
                        </div>
                        <div id="pwStrength" style="display:none;margin-top:6px">
                            <div class="pw-strength-bar"><div class="pw-strength-fill" id="pwStrengthFill"></div></div>
                            <span class="pw-strength-text" id="pwStrengthText"></span>
                        </div>
                        <span class="field-hint">Password akan digunakan siswa untuk login ke sistem</span>
                        @error('password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            {{-- ═══ 2. IDENTITAS SISWA ═══ --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="18" rx="2"/><path d="M8 10h8M8 14h5"/></svg>
                    Identitas Siswa
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>NIS <span class="req">*</span></label>
                        <input type="text" name="nis" value="{{ old('nis') }}"
                            placeholder="cth. 2024001"
                            class="{{ $errors->has('nis') ? 'is-invalid' : '' }}">
                        @error('nis')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>NISN <span class="req">*</span></label>
                        <input type="text" name="nisn" id="nisnInput" value="{{ old('nisn') }}"
                            placeholder="cth. 0012345678" maxlength="10" inputmode="numeric"
                            class="{{ $errors->has('nisn') ? 'is-invalid' : '' }}">
                        <span class="field-hint">10 digit angka sesuai Dapodik</span>
                        @error('nisn')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field col-span-2">
                        <label>Nama Lengkap <span class="req">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                            placeholder="cth. Ahmad Fauzi Ramadhan"
                            class="{{ $errors->has('nama_lengkap') ? 'is-invalid' : '' }}">
                        @error('nama_lengkap')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Jenis Kelamin <span class="req">*</span></label>
                        <select name="jenis_kelamin" class="{{ $errors->has('jenis_kelamin') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih —</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Agama</label>
                        <select name="agama" class="{{ $errors->has('agama') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih —</option>
                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                                <option value="{{ $ag }}" {{ old('agama') == $ag ? 'selected' : '' }}>{{ $ag }}</option>
                            @endforeach
                        </select>
                        @error('agama')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                            placeholder="cth. Bandung"
                            class="{{ $errors->has('tempat_lahir') ? 'is-invalid' : '' }}">
                        @error('tempat_lahir')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                            class="{{ $errors->has('tanggal_lahir') ? 'is-invalid' : '' }}">
                        @error('tanggal_lahir')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>No. HP Siswa</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                            placeholder="cth. 08123456789" inputmode="numeric"
                            class="{{ $errors->has('no_hp') ? 'is-invalid' : '' }}">
                        @error('no_hp')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field col-span-2">
                        <label>Alamat</label>
                        <textarea name="alamat" rows="2" placeholder="Jl. Merdeka No. 1, Bandung"
                            class="{{ $errors->has('alamat') ? 'is-invalid' : '' }}">{{ old('alamat') }}</textarea>
                        @error('alamat')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            {{-- ═══ 3. DATA AKADEMIK ═══ --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3.33 1.67 8.67 1.67 12 0v-5"/></svg>
                    Data Akademik
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Kelas</label>
                        <select name="class_id" class="{{ $errors->has('class_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Kelas —</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" {{ old('class_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tahun Ajaran</label>
                        <select name="academic_year_id" class="{{ $errors->has('academic_year_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Tahun Ajaran —</option>
                            @foreach($years as $y)
                                <option value="{{ $y->id }}" {{ old('academic_year_id') == $y->id ? 'selected' : '' }}>
                                    {{ $y->tahun }}
                                </option>
                            @endforeach
                        </select>
                        @error('academic_year_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field col-span-2">
                        <label>Status</label>
                        <select name="status" style="max-width:240px">
                            <option value="aktif"  {{ old('status', 'aktif') == 'aktif'  ? 'selected' : '' }}>Aktif</option>
                            <option value="lulus"  {{ old('status')          == 'lulus'  ? 'selected' : '' }}>Lulus</option>
                            <option value="pindah" {{ old('status')          == 'pindah' ? 'selected' : '' }}>Pindah</option>
                        </select>
                        @error('status')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            {{-- ═══ 4. DATA ORANG TUA & WALI ═══ --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Data Orang Tua &amp; Wali
                    <span class="section-label-line"></span>
                </p>

                {{-- Ayah --}}
                <p class="sub-label">Ayah</p>
                <div class="form-grid cols-3" style="margin-bottom:20px">
                    <div class="field">
                        <label>Nama Ayah</label>
                        <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}"
                            placeholder="cth. Budi Santoso"
                            class="{{ $errors->has('nama_ayah') ? 'is-invalid' : '' }}">
                        @error('nama_ayah')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}"
                            placeholder="cth. Wiraswasta"
                            class="{{ $errors->has('pekerjaan_ayah') ? 'is-invalid' : '' }}">
                        @error('pekerjaan_ayah')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>No. HP Ayah</label>
                        <input type="text" name="no_hp_ayah" value="{{ old('no_hp_ayah') }}"
                            placeholder="cth. 08123456789" inputmode="numeric"
                            class="{{ $errors->has('no_hp_ayah') ? 'is-invalid' : '' }}">
                        @error('no_hp_ayah')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                {{-- Ibu --}}
                <p class="sub-label">Ibu</p>
                <div class="form-grid cols-3" style="margin-bottom:20px">
                    <div class="field">
                        <label>Nama Ibu</label>
                        <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}"
                            placeholder="cth. Siti Rahayu"
                            class="{{ $errors->has('nama_ibu') ? 'is-invalid' : '' }}">
                        @error('nama_ibu')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}"
                            placeholder="cth. Ibu Rumah Tangga"
                            class="{{ $errors->has('pekerjaan_ibu') ? 'is-invalid' : '' }}">
                        @error('pekerjaan_ibu')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>No. HP Ibu</label>
                        <input type="text" name="no_hp_ibu" value="{{ old('no_hp_ibu') }}"
                            placeholder="cth. 08123456789" inputmode="numeric"
                            class="{{ $errors->has('no_hp_ibu') ? 'is-invalid' : '' }}">
                        @error('no_hp_ibu')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                {{-- Wali --}}
                <p class="sub-label">Wali <span class="sub-label-note">(isi jika berbeda dengan orang tua)</span></p>
                <div class="form-grid cols-3">
                    <div class="field">
                        <label>Nama Wali</label>
                        <input type="text" name="nama_wali" value="{{ old('nama_wali') }}"
                            placeholder="cth. Rudi Hartono"
                            class="{{ $errors->has('nama_wali') ? 'is-invalid' : '' }}">
                        @error('nama_wali')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Pekerjaan Wali</label>
                        <input type="text" name="pekerjaan_wali" value="{{ old('pekerjaan_wali') }}"
                            placeholder="cth. PNS"
                            class="{{ $errors->has('pekerjaan_wali') ? 'is-invalid' : '' }}">
                        @error('pekerjaan_wali')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>No. HP Wali</label>
                        <input type="text" name="no_hp_wali" value="{{ old('no_hp_wali') }}"
                            placeholder="cth. 08123456789" inputmode="numeric"
                            class="{{ $errors->has('no_hp_wali') ? 'is-invalid' : '' }}">
                        @error('no_hp_wali')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            {{-- ═══ 5. FOTO ═══ --}}
            <div class="foto-section">
                <div class="foto-preview-wrap" id="previewWrap">
                    <div class="foto-placeholder" id="fotoPlaceholder">
                        <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="3"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <span>Preview</span>
                    </div>
                    <img id="previewImage" src="" alt="" style="display:none">
                </div>
                <div class="foto-meta">
                    <p class="foto-label">Foto Siswa</p>
                    <p class="foto-hint">Format JPG / PNG, maks. 5 MB. Otomatis dipotong 300 × 300 px.</p>
                    <div class="foto-input-wrap">
                        <input type="file" name="foto" id="fotoInput" accept="image/jpg,image/jpeg,image/png">
                        <div class="btn-upload">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="17 8 12 3 7 8"/>
                                <line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                            Pilih Foto
                        </div>
                    </div>
                    <div class="foto-file-info">
                        <span class="foto-filename" id="fotoFilename">Belum ada file dipilih</span>
                        <span class="foto-filesize" id="fotoFilesize"></span>
                        <button type="button" class="btn-remove-foto" id="btnRemoveFoto" onclick="removeFoto()">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                            Hapus
                        </button>
                    </div>
                    @error('foto')<span class="field-error" style="margin-top:4px;display:block">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- ═══ FOOTER ═══ --}}
            <div class="form-footer">
                <a href="{{ route('admin.students.index') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Simpan Data
                </button>
            </div>

        </div>{{-- /.form-card --}}
    </form>

</div>{{-- /.page --}}

<script>
    /* ── Password toggle ── */
    function togglePw() {
        const input = document.getElementById('pwInput');
        const isText = input.type === 'text';
        input.type = isText ? 'password' : 'text';
        document.getElementById('eyeShow').style.display = isText ? 'block' : 'none';
        document.getElementById('eyeHide').style.display = isText ? 'none'  : 'block';
    }

    /* ── Password strength ── */
    function checkStrength(val) {
        const wrapper = document.getElementById('pwStrength');
        if (!val) { wrapper.style.display = 'none'; return; }
        wrapper.style.display = 'block';

        let score = 0;
        if (val.length >= 8)            score++;
        if (val.length >= 12)           score++;
        if (/[A-Z]/.test(val))          score++;
        if (/[0-9]/.test(val))          score++;
        if (/[^A-Za-z0-9]/.test(val))   score++;

        const levels = [
            { pct: '20%',  color: '#ef4444', label: 'Sangat lemah' },
            { pct: '40%',  color: '#f97316', label: 'Lemah' },
            { pct: '60%',  color: '#eab308', label: 'Cukup' },
            { pct: '80%',  color: '#22c55e', label: 'Kuat' },
            { pct: '100%', color: '#15803d', label: 'Sangat kuat' },
        ];
        const lvl = levels[Math.min(score - 1, 4)] ?? levels[0];
        const fill = document.getElementById('pwStrengthFill');
        const text = document.getElementById('pwStrengthText');
        fill.style.width      = lvl.pct;
        fill.style.background = lvl.color;
        text.textContent      = lvl.label;
        text.style.color      = lvl.color;
    }

    /* ── NISN: angka saja ── */
    document.getElementById('nisnInput').addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 10);
    });

    /* ── Foto preview ── */
    document.getElementById('fotoInput').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file melebihi 5 MB. Silakan pilih file lain.');
            this.value = '';
            return;
        }

        document.getElementById('previewImage').src              = URL.createObjectURL(file);
        document.getElementById('previewImage').style.display    = 'block';
        document.getElementById('fotoPlaceholder').style.display = 'none';
        document.getElementById('fotoFilename').textContent      = file.name;
        document.getElementById('fotoFilename').style.color      = 'var(--text2)';
        document.getElementById('fotoFilesize').textContent      = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
        document.getElementById('fotoFilesize').style.display    = 'inline';
        document.getElementById('btnRemoveFoto').style.display   = 'inline-flex';
    });

    function removeFoto() {
        document.getElementById('fotoInput').value                = '';
        document.getElementById('previewImage').style.display     = 'none';
        document.getElementById('previewImage').src               = '';
        document.getElementById('fotoPlaceholder').style.display  = 'flex';
        document.getElementById('fotoFilename').textContent       = 'Belum ada file dipilih';
        document.getElementById('fotoFilename').style.color       = '';
        document.getElementById('fotoFilesize').style.display     = 'none';
        document.getElementById('btnRemoveFoto').style.display    = 'none';
    }

    /* ── Disable submit saat proses ── */
    document.getElementById('studentForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled  = true;
        btn.innerHTML = `
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                 style="animation:spin .7s linear infinite">
                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
            </svg>
            Menyimpan…`;
    });
</script>

</x-app-layout>