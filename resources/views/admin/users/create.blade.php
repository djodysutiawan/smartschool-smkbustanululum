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
        --radius:     10px;
        --radius-sm:  7px;
    }

    .page { padding: 28px 28px 60px; max-width: 2000px; margin: 0 auto; }

    .breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600;
        color: var(--text3); margin-bottom: 20px;
    }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }

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

    .alert {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px;
        font-size: 13.5px; background: var(--red-bg); color: var(--red); border: 1px solid var(--red-border);
    }

    .form-card   { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .form-section { padding: 20px 24px 24px; }
    .section-divider { border: none; border-top: 1px solid var(--border); margin: 0; }

    .section-label {
        display: flex; align-items: center; gap: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
        color: var(--text3); letter-spacing: .07em; text-transform: uppercase; margin-bottom: 16px;
    }
    .section-label-line { flex: 1; height: 1px; background: var(--border); }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .col-span-2 { grid-column: span 2; }

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
    .field input:focus, .field select:focus, .field textarea:focus {
        border-color: var(--brand-h); background: #fff;
        box-shadow: 0 0 0 3px rgba(53,130,240,.1);
    }
    .field input::placeholder, .field textarea::placeholder { color: var(--text3); }
    .field input.is-invalid,
    .field select.is-invalid,
    .field textarea.is-invalid { border-color: var(--red); background: #fff8f8; }
    .field-error { font-size: 12px; color: var(--red); font-family: 'DM Sans', sans-serif; margin-top: -2px; }
    .field-hint  { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; margin-top: -2px; }

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

    /* Avatar upload */
    .avatar-section { display: flex; align-items: flex-start; gap: 20px; padding: 20px 24px 24px; }
    .avatar-preview-wrap {
        width: 100px; height: 100px; flex-shrink: 0;
        border-radius: 14px; overflow: hidden;
        border: 1.5px dashed var(--border2); background: var(--surface2);
        display: flex; align-items: center; justify-content: center;
        position: relative; transition: border-color .15s;
    }
    .avatar-preview-wrap:hover { border-color: var(--brand-h); }
    .avatar-preview-wrap img   { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; }
    .avatar-placeholder        { display: flex; flex-direction: column; align-items: center; gap: 4px; }
    .avatar-placeholder svg    { opacity: .4; }
    .avatar-placeholder span   { font-size: 10px; color: var(--text3); font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; }
    .avatar-meta .avatar-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
    .avatar-meta .avatar-hint  { font-size: 12px; color: var(--text3); margin-bottom: 10px; }
    .avatar-input-wrap         { position: relative; display: inline-block; }
    .avatar-input-wrap input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .btn-upload {
        display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px;
        border-radius: var(--radius-sm); background: var(--surface2); color: var(--text2);
        border: 1px solid var(--border); font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px; font-weight: 700; cursor: pointer; transition: background .15s;
    }
    .btn-upload:hover { background: var(--surface3); }
    .avatar-file-info { display: flex; align-items: center; gap: 8px; margin-top: 8px; }
    .avatar-filename { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; }
    .avatar-filesize { font-size: 11.5px; color: var(--text3); font-family: 'DM Sans', sans-serif; background: var(--surface3); border-radius: 4px; padding: 1px 6px; display: none; }
    .btn-remove-avatar {
        display: none; align-items: center; gap: 4px;
        background: none; border: none; cursor: pointer; color: var(--red);
        font-size: 11.5px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
        padding: 2px 6px; border-radius: 4px; transition: background .15s;
    }
    .btn-remove-avatar:hover { background: var(--red-bg); }

    /* Toggle switch */
    .toggle-row { display: flex; align-items: center; gap: 12px; }
    .toggle-switch { position: relative; display: inline-block; width: 42px; height: 24px; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute; inset: 0; border-radius: 99px;
        background: var(--border2); cursor: pointer; transition: background .2s;
    }
    .toggle-slider::before {
        content: ''; position: absolute; width: 18px; height: 18px;
        left: 3px; top: 3px; background: #fff; border-radius: 50%;
        transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2);
    }
    .toggle-switch input:checked + .toggle-slider { background: var(--brand); }
    .toggle-switch input:checked + .toggle-slider::before { transform: translateX(18px); }
    .toggle-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; color: var(--text2); }

    .form-footer {
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
        padding: 16px 24px; background: var(--surface2); border-top: 1px solid var(--border);
    }

    @media (max-width: 680px) {
        .page { padding: 16px 16px 40px; }
        .form-grid { grid-template-columns: 1fr; }
        .col-span-2 { grid-column: span 1; }
        .avatar-section { flex-direction: column; }
    }

    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="page">

    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.users.index') }}">Manajemen Pengguna</a>
        <span class="sep">›</span>
        <span class="current">Tambah Pengguna</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Pengguna Baru</h1>
            <p class="page-sub">Isi semua data dengan benar, lalu klik Simpan Data</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
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

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" id="userForm">
        @csrf
        <div class="form-card">

            {{-- ═══ 1. INFORMASI AKUN ═══ --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    Informasi Akun
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Nama Lengkap <span class="req">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            placeholder="cth. Ahmad Fauzi"
                            class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                        @error('name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Email <span class="req">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            placeholder="cth. pengguna@sekolah.sch.id"
                            class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Password <span class="req">*</span></label>
                        <div class="pw-wrap">
                            <input type="password" name="password" id="pwInput"
                                placeholder="Minimal 8 karakter, huruf besar & angka"
                                class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                                oninput="checkStrength(this.value)">
                            <button type="button" class="pw-toggle" onclick="togglePw()">
                                <svg id="eyeShow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg id="eyeHide" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                        <div id="pwStrength" style="display:none;margin-top:6px">
                            <div class="pw-strength-bar"><div class="pw-strength-fill" id="pwStrengthFill"></div></div>
                            <span class="pw-strength-text" id="pwStrengthText"></span>
                        </div>
                        @error('password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>No. HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                            placeholder="cth. 08123456789" inputmode="numeric"
                            class="{{ $errors->has('no_hp') ? 'is-invalid' : '' }}">
                        @error('no_hp')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Role <span class="req">*</span></label>
                        <select name="role" class="{{ $errors->has('role') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Role —</option>
                            @foreach($roles as $r)
                                <option value="{{ $r }}" {{ old('role') == $r ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $r)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field" style="justify-content:flex-end;padding-bottom:4px">
                        <label>Status Aktif</label>
                        <div class="toggle-row" style="margin-top:8px">
                            <label class="toggle-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" id="isActiveToggle"
                                    {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label" id="toggleLabel">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            {{-- ═══ 2. AVATAR ═══ --}}
            <div class="avatar-section">
                <div class="avatar-preview-wrap" id="previewWrap">
                    <div class="avatar-placeholder" id="avatarPlaceholder">
                        <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24">
                            <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                        </svg>
                        <span>Preview</span>
                    </div>
                    <img id="previewImage" src="" alt="" style="display:none">
                </div>
                <div class="avatar-meta">
                    <p class="avatar-label">Avatar / Foto Profil</p>
                    <p class="avatar-hint">Format JPG / PNG, maks. 2 MB.</p>
                    <div class="avatar-input-wrap">
                        <input type="file" name="avatar" id="avatarInput" accept="image/jpg,image/jpeg,image/png">
                        <div class="btn-upload">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            Pilih File
                        </div>
                    </div>
                    <div class="avatar-file-info">
                        <span class="avatar-filename" id="avatarFilename">Belum ada file dipilih</span>
                        <span class="avatar-filesize" id="avatarFilesize"></span>
                        <button type="button" class="btn-remove-avatar" id="btnRemoveAvatar" onclick="removeAvatar()">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            Hapus
                        </button>
                    </div>
                    @error('avatar')<span class="field-error" style="margin-top:4px;display:block">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Footer --}}
            <div class="form-footer">
                <a href="{{ route('admin.users.index') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Data
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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

    function togglePw() {
        const i = document.getElementById('pwInput');
        const isT = i.type === 'text';
        i.type = isT ? 'password' : 'text';
        document.getElementById('eyeShow').style.display = isT ? 'block' : 'none';
        document.getElementById('eyeHide').style.display = isT ? 'none'  : 'block';
    }
    function checkStrength(val) {
        const w = document.getElementById('pwStrength');
        if (!val) { w.style.display = 'none'; return; }
        w.style.display = 'block';
        let s = 0;
        if (val.length >= 8) s++; if (val.length >= 12) s++;
        if (/[A-Z]/.test(val)) s++; if (/[0-9]/.test(val)) s++;
        if (/[^A-Za-z0-9]/.test(val)) s++;
        const lvls = [
            {pct:'20%',color:'#ef4444',label:'Sangat lemah'},
            {pct:'40%',color:'#f97316',label:'Lemah'},
            {pct:'60%',color:'#eab308',label:'Cukup'},
            {pct:'80%',color:'#22c55e',label:'Kuat'},
            {pct:'100%',color:'#15803d',label:'Sangat kuat'},
        ];
        const l = lvls[Math.min(s - 1, 4)] ?? lvls[0];
        document.getElementById('pwStrengthFill').style.width = l.pct;
        document.getElementById('pwStrengthFill').style.background = l.color;
        document.getElementById('pwStrengthText').textContent = l.label;
        document.getElementById('pwStrengthText').style.color = l.color;
    }

    // Toggle label update
    document.getElementById('isActiveToggle').addEventListener('change', function() {
        document.getElementById('toggleLabel').textContent = this.checked ? 'Aktif' : 'Nonaktif';
    });

    // Avatar preview
    document.getElementById('avatarInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({ icon:'warning', title:'File Terlalu Besar', text:'Ukuran file melebihi 2 MB.', confirmButtonColor:'#1f63db' });
            this.value = ''; return;
        }
        document.getElementById('previewImage').src = URL.createObjectURL(file);
        document.getElementById('previewImage').style.display = 'block';
        document.getElementById('avatarPlaceholder').style.display = 'none';
        document.getElementById('avatarFilename').textContent = file.name;
        document.getElementById('avatarFilename').style.color = 'var(--text2)';
        document.getElementById('avatarFilesize').textContent = (file.size / (1024*1024)).toFixed(2) + ' MB';
        document.getElementById('avatarFilesize').style.display = 'inline';
        document.getElementById('btnRemoveAvatar').style.display = 'inline-flex';
    });
    function removeAvatar() {
        document.getElementById('avatarInput').value = '';
        document.getElementById('previewImage').style.display = 'none';
        document.getElementById('previewImage').src = '';
        document.getElementById('avatarPlaceholder').style.display = 'flex';
        document.getElementById('avatarFilename').textContent = 'Belum ada file dipilih';
        document.getElementById('avatarFilename').style.color = '';
        document.getElementById('avatarFilesize').style.display = 'none';
        document.getElementById('btnRemoveAvatar').style.display = 'none';
    }

    document.getElementById('userForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>