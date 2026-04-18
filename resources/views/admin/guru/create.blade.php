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

    .page { padding: 28px 28px 60px; max-width: 1100px; margin: 0 auto; }
    .breadcrumb { display: flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600; color: var(--text3); margin-bottom: 20px; }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }
    .page-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s; white-space: nowrap; }
    .btn:hover { filter: brightness(.93); }
    .btn-back { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-back:hover { background: var(--surface3); filter: none; }
    .btn-cancel { background: var(--surface); color: var(--text2); border: 1px solid var(--border); }
    .btn-cancel:hover { background: var(--surface3); filter: none; }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:disabled { opacity: .6; cursor: not-allowed; filter: none; }
    .alert { display: flex; align-items: flex-start; gap: 10px; padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px; font-size: 13.5px; background: var(--red-bg); color: var(--red); border: 1px solid var(--red-border); }
    .form-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
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
    .field label .req { color: var(--red); margin-left: 2px; }
    .field input, .field select, .field textarea { padding: 0 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); background: var(--surface2); width: 100%; outline: none; transition: border-color .15s; }
    .field input, .field select { height: 38px; }
    .field textarea { padding: 10px 12px; resize: vertical; min-height: 80px; }
    .field input:focus, .field select:focus, .field textarea:focus { border-color: var(--brand-h); background: #fff; box-shadow: 0 0 0 3px rgba(53,130,240,.1); }
    .field input::placeholder, .field textarea::placeholder { color: var(--text3); }
    .field input.is-invalid, .field select.is-invalid, .field textarea.is-invalid { border-color: var(--red); background: #fff8f8; }
    .field-error { font-size: 12px; color: var(--red); }
    .field-hint { font-size: 12px; color: var(--text3); }
    .akun-toggle-area { background: var(--surface2); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 14px 16px; margin-bottom: 16px; }
    .toggle-row { display: flex; align-items: center; gap: 12px; }
    .toggle-switch { position: relative; display: inline-block; width: 42px; height: 24px; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider { position: absolute; inset: 0; border-radius: 99px; background: var(--border2); cursor: pointer; transition: background .2s; }
    .toggle-slider::before { content: ''; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2); }
    .toggle-switch input:checked + .toggle-slider { background: var(--brand); }
    .toggle-switch input:checked + .toggle-slider::before { transform: translateX(18px); }
    .toggle-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; color: var(--text2); }
    .foto-section { display: flex; align-items: flex-start; gap: 20px; padding: 20px 24px 24px; }
    .foto-preview-wrap { width: 100px; height: 100px; flex-shrink: 0; border-radius: 14px; overflow: hidden; border: 1.5px dashed var(--border2); background: var(--surface2); display: flex; align-items: center; justify-content: center; position: relative; }
    .foto-preview-wrap img { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; }
    .foto-placeholder { display: flex; flex-direction: column; align-items: center; gap: 4px; }
    .foto-placeholder svg { opacity: .4; }
    .foto-placeholder span { font-size: 10px; color: var(--text3); font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; }
    .foto-meta .foto-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
    .foto-meta .foto-hint { font-size: 12px; color: var(--text3); margin-bottom: 10px; }
    .foto-input-wrap { position: relative; display: inline-block; }
    .foto-input-wrap input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .btn-upload { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: var(--radius-sm); background: var(--surface2); color: var(--text2); border: 1px solid var(--border); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; cursor: pointer; }
    .foto-file-info { display: flex; align-items: center; gap: 8px; margin-top: 8px; }
    .foto-filename { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; }
    .btn-remove-foto { display: none; align-items: center; gap: 4px; background: none; border: none; cursor: pointer; color: var(--red); font-size: 11.5px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; padding: 2px 6px; border-radius: 4px; }
    .btn-remove-foto:hover { background: var(--red-bg); }
    .form-footer { display: flex; align-items: center; justify-content: flex-end; gap: 10px; padding: 16px 24px; background: var(--surface2); border-top: 1px solid var(--border); }
    @media (max-width: 720px) {
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
        <a href="{{ route('admin.guru.index') }}">Data Guru</a>
        <span class="sep">›</span>
        <span class="current">Tambah Guru</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Guru</h1>
            <p class="page-sub">Isi formulir berikut untuk menambahkan data guru baru</p>
        </div>
        <a href="{{ route('admin.guru.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

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

    <form action="{{ route('admin.guru.store') }}" method="POST" enctype="multipart/form-data" id="guruForm">
        @csrf
        <input type="hidden" name="buat_akun_baru" id="hiddenBuatAkun" value="{{ old('buat_akun_baru', '0') }}">

        <div class="form-card">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Akun Pengguna
                    <span class="section-label-line"></span>
                </p>

                <div class="akun-toggle-area">
                    <div class="toggle-row">
                        <label class="toggle-switch">
                            <input type="checkbox" id="buatAkunBaru" onchange="toggleAkunBaru(this)"
                                {{ old('buat_akun_baru', '0') == '1' ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <div>
                            <p class="toggle-label">Buat Akun Baru</p>
                            <p style="font-size:12px;color:var(--text3);margin-top:2px">Aktifkan untuk membuat akun login baru, atau pilih user existing di bawah</p>
                        </div>
                    </div>
                </div>

                <div id="akunBaruSection" style="{{ old('buat_akun_baru','0') == '1' ? 'display:grid' : 'display:none' }}" class="form-grid">
                    <div class="field">
                        <label>Nama Akun <span class="req">*</span></label>
                        <input type="text" name="user_name" value="{{ old('user_name') }}"
                            placeholder="cth. Ahmad Fauzi"
                            class="{{ $errors->has('user_name') ? 'is-invalid' : '' }}">
                        @error('user_name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Email Akun <span class="req">*</span></label>
                        <input type="email" name="user_email" value="{{ old('user_email') }}"
                            placeholder="cth. guru@sekolah.sch.id"
                            class="{{ $errors->has('user_email') ? 'is-invalid' : '' }}">
                        @error('user_email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field col-span-2">
                        <label>Kata Sandi <span class="req">*</span></label>
                        <input type="password" name="user_password"
                            placeholder="Minimal 8 karakter"
                            class="{{ $errors->has('user_password') ? 'is-invalid' : '' }}">
                        @error('user_password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div id="userExistingSection" style="{{ old('buat_akun_baru','0') == '1' ? 'display:none' : '' }}">
                    <div class="field">
                        <label>Pilih User Existing</label>
                        <select name="pengguna_id" class="{{ $errors->has('pengguna_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih akun user (role: guru) —</option>
                            @foreach($availableUsers as $u)
                                <option value="{{ $u->id }}" {{ old('pengguna_id') == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }} — {{ $u->email }}
                                </option>
                            @endforeach
                        </select>
                        @error('pengguna_id')<span class="field-error">{{ $message }}</span>@enderror
                        <span class="field-hint">Hanya akun dengan role "guru" yang belum terhubung ke profil guru yang ditampilkan</span>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="18" rx="2"/><path d="M8 10h8M8 14h5"/></svg>
                    Data Pribadi
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field col-span-2">
                        <label>Nama Lengkap <span class="req">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                            placeholder="cth. Dr. Ahmad Fauzi, M.Pd."
                            class="{{ $errors->has('nama_lengkap') ? 'is-invalid' : '' }}">
                        @error('nama_lengkap')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>NIP</label>
                        <input type="text" name="nip" value="{{ old('nip') }}"
                            placeholder="cth. 198501012010011001"
                            class="{{ $errors->has('nip') ? 'is-invalid' : '' }}">
                        @error('nip')<span class="field-error">{{ $message }}</span>@enderror
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
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="cth. Bandung">
                    </div>
                    <div class="field">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                    </div>
                    <div class="field">
                        <label>No. HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="cth. 08123456789" inputmode="numeric">
                    </div>
                    <div class="field">
                        <label>Email Pribadi</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="cth. ahmad@gmail.com">
                    </div>
                    <div class="field col-span-2">
                        <label>Alamat</label>
                        <textarea name="alamat" placeholder="Alamat lengkap...">{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    Pendidikan
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid-3">
                    <div class="field">
                        <label>Pendidikan Terakhir</label>
                        <select name="pendidikan_terakhir">
                            <option value="">— Pilih —</option>
                            @foreach(['SMA/SMK','D3','S1','S2','S3'] as $p)
                                <option value="{{ $p }}" {{ old('pendidikan_terakhir') == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Jurusan</label>
                        <input type="text" name="jurusan_pendidikan" value="{{ old('jurusan_pendidikan') }}" placeholder="cth. Pendidikan Matematika">
                    </div>
                    <div class="field">
                        <label>Tahun Lulus</label>
                        <input type="number" name="tahun_lulus" value="{{ old('tahun_lulus') }}" placeholder="cth. 2010" min="1980" max="{{ date('Y') }}">
                    </div>
                    <div class="field col-span-3">
                        <label>Universitas / Institusi</label>
                        <input type="text" name="universitas" value="{{ old('universitas') }}" placeholder="cth. Universitas Pendidikan Indonesia">
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    Kepegawaian
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Status Kepegawaian <span class="req">*</span></label>
                        <select name="status_kepegawaian" class="{{ $errors->has('status_kepegawaian') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih —</option>
                            <option value="pns"    {{ old('status_kepegawaian') == 'pns'    ? 'selected' : '' }}>PNS</option>
                            <option value="p3k"    {{ old('status_kepegawaian') == 'p3k'    ? 'selected' : '' }}>P3K</option>
                            <option value="honorer"{{ old('status_kepegawaian') == 'honorer'? 'selected' : '' }}>Honorer</option>
                            <option value="gtty"   {{ old('status_kepegawaian') == 'gtty'   ? 'selected' : '' }}>GTTY</option>
                        </select>
                        @error('status_kepegawaian')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}">
                    </div>
                    <div class="field">
                        <label>Status <span class="req">*</span></label>
                        <select name="status" class="{{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih —</option>
                            <option value="aktif"       {{ old('status','aktif') == 'aktif'       ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ old('status')         == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="cuti"        {{ old('status')         == 'cuti'        ? 'selected' : '' }}>Cuti</option>
                        </select>
                        @error('status')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field" style="justify-content:flex-start">
                        <label>Guru Piket</label>
                        <div style="display:flex;align-items:center;gap:12px;margin-top:8px">
                            <label class="toggle-switch">
                                <input type="hidden" name="adalah_guru_piket" value="0">
                                <input type="checkbox" name="adalah_guru_piket" value="1"
                                    {{ old('adalah_guru_piket') ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2)">Guru bertugas piket</span>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <div class="foto-section">
                <div class="foto-preview-wrap">
                    <img id="previewImage" src="" alt="" style="display:none">
                    <div class="foto-placeholder" id="fotoPlaceholder">
                        <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        <span>Preview</span>
                    </div>
                </div>
                <div class="foto-meta">
                    <p class="foto-label">Foto Profil Guru</p>
                    <p class="foto-hint">Format JPG / PNG, maks. 2 MB. Opsional.</p>
                    <div class="foto-input-wrap">
                        <input type="file" name="foto" id="fotoInput" accept="image/jpg,image/jpeg,image/png">
                        <div class="btn-upload">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            Pilih Foto
                        </div>
                    </div>
                    <div class="foto-file-info">
                        <span class="foto-filename" id="fotoFilename">Belum ada file dipilih</span>
                        <button type="button" class="btn-remove-foto" id="btnRemoveFoto" onclick="removeFoto()">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            Batal
                        </button>
                    </div>
                    @error('foto')<span class="field-error" style="margin-top:4px;display:block">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.guru.index') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Data Guru
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Terdapat {{ $errors->count() }} Kesalahan',
        html: `<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`,
        confirmButtonColor: '#1f63db',
    });
    @endif

    function toggleAkunBaru(el) {
        document.getElementById('hiddenBuatAkun').value = el.checked ? '1' : '0';
        document.getElementById('akunBaruSection').style.display = el.checked ? 'grid' : 'none';
        document.getElementById('userExistingSection').style.display = el.checked ? 'none' : 'block';
    }

    document.getElementById('fotoInput').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({ icon: 'warning', title: 'File Terlalu Besar', text: 'Ukuran file melebihi 2 MB.', confirmButtonColor: '#1f63db' });
            this.value = '';
            return;
        }
        document.getElementById('previewImage').src = URL.createObjectURL(file);
        document.getElementById('previewImage').style.display = 'block';
        document.getElementById('fotoPlaceholder').style.display = 'none';
        document.getElementById('fotoFilename').textContent = file.name;
        document.getElementById('fotoFilename').style.color = 'var(--text2)';
        document.getElementById('btnRemoveFoto').style.display = 'inline-flex';
    });

    function removeFoto() {
        document.getElementById('fotoInput').value = '';
        document.getElementById('previewImage').style.display = 'none';
        document.getElementById('previewImage').src = '';
        document.getElementById('fotoPlaceholder').style.display = 'flex';
        document.getElementById('fotoFilename').textContent = 'Belum ada file dipilih';
        document.getElementById('fotoFilename').style.color = '';
        document.getElementById('btnRemoveFoto').style.display = 'none';
    }

    document.getElementById('guruForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>