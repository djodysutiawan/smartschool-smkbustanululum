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
    .header-actions { display: flex; gap: 8px; }

    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: filter .15s; white-space: nowrap;
    }
    .btn:hover { filter: brightness(.93); }
    .btn-back   { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); padding: 8px 14px; }
    .btn-back:hover { background: var(--surface3); filter: none; }
    .btn-detail { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-detail:hover { background: var(--brand-100); filter: none; }
    .btn-cancel { background: var(--surface); color: var(--text2); border: 1px solid var(--border); }
    .btn-cancel:hover { background: var(--surface3); filter: none; }
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
    .field label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2); }
    .field label .req { color: var(--brand); margin-left: 2px; }
    .field input,
    .field select {
        height: 38px; padding: 0 12px;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif; font-size: 13.5px;
        color: var(--text); background: var(--surface2); width: 100%;
        outline: none; transition: border-color .15s;
    }
    .field input:focus, .field select:focus {
        border-color: var(--brand-h); background: #fff;
        box-shadow: 0 0 0 3px rgba(53,130,240,.1);
    }
    .field input::placeholder { color: var(--text3); }
    .field input.is-invalid, .field select.is-invalid { border-color: var(--red); background: #fff8f8; }
    .field-error { font-size: 12px; color: var(--red); font-family: 'DM Sans', sans-serif; margin-top: -2px; }
    .field-hint  { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; margin-top: -2px; }

    /* Toggle */
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

    /* Avatar */
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
    .avatar-filesize { font-size: 11.5px; color: var(--text3); background: var(--surface3); border-radius: 4px; padding: 1px 6px; display: none; }
    .btn-remove-avatar {
        display: none; align-items: center; gap: 4px;
        background: none; border: none; cursor: pointer; color: var(--red);
        font-size: 11.5px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
        padding: 2px 6px; border-radius: 4px; transition: background .15s;
    }
    .btn-remove-avatar:hover { background: var(--red-bg); }

    .current-avatar-note {
        font-size: 11.5px; color: var(--text3);
        font-family: 'DM Sans', sans-serif; margin-top: 6px;
        display: flex; align-items: center; gap: 5px;
    }
    .current-avatar-note svg { flex-shrink: 0; }

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
        <a href="{{ route('admin.users.show', $user->id) }}">{{ $user->name }}</a>
        <span class="sep">›</span>
        <span class="current">Edit</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Pengguna</h1>
            <p class="page-sub">Perbarui data akun — {{ $user->name }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-detail">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                Lihat Detail
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
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

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" id="userForm">
        @csrf @method('PUT')
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
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            placeholder="cth. Ahmad Fauzi"
                            class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                        @error('name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Email <span class="req">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            placeholder="cth. pengguna@sekolah.sch.id"
                            class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>No. HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                            placeholder="cth. 08123456789" inputmode="numeric"
                            class="{{ $errors->has('no_hp') ? 'is-invalid' : '' }}">
                        @error('no_hp')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Role <span class="req">*</span></label>
                        <select name="role" class="{{ $errors->has('role') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Role —</option>
                            @foreach($roles as $r)
                                <option value="{{ $r }}" {{ old('role', $user->role) == $r ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $r)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field col-span-2" style="justify-content:flex-start">
                        <label>Status Aktif</label>
                        <div class="toggle-row" style="margin-top:8px">
                            <label class="toggle-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" id="isActiveToggle"
                                    {{ old('is_active', $user->is_active ? '1' : '0') == '1' ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label" id="toggleLabel">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                        </div>
                        <span class="field-hint">Nonaktifkan untuk mencegah pengguna login ke sistem</span>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            {{-- ═══ 2. AVATAR ═══ --}}
            <div class="avatar-section">
                <div class="avatar-preview-wrap" id="previewWrap">
                    @if($user->avatar)
                        <img id="previewImage" src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}">
                        <div class="avatar-placeholder" id="avatarPlaceholder" style="display:none">
                    @else
                        <img id="previewImage" src="" alt="" style="display:none">
                        <div class="avatar-placeholder" id="avatarPlaceholder">
                    @endif
                        <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24">
                            <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                        </svg>
                        <span>Preview</span>
                    </div>
                </div>
                <div class="avatar-meta">
                    <p class="avatar-label">Avatar / Foto Profil</p>
                    <p class="avatar-hint">Format JPG / PNG, maks. 2 MB. Biarkan kosong untuk tidak mengubah foto.</p>
                    <div class="avatar-input-wrap">
                        <input type="file" name="avatar" id="avatarInput" accept="image/jpg,image/jpeg,image/png">
                        <div class="btn-upload">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            Ganti Foto
                        </div>
                    </div>
                    <div class="avatar-file-info">
                        <span class="avatar-filename" id="avatarFilename">Belum ada file baru dipilih</span>
                        <span class="avatar-filesize" id="avatarFilesize"></span>
                        <button type="button" class="btn-remove-avatar" id="btnRemoveAvatar" onclick="removeAvatar()">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            Batal
                        </button>
                    </div>
                    @if($user->avatar)
                    <div class="current-avatar-note">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Foto saat ini akan diganti jika Anda memilih file baru
                    </div>
                    @endif
                    @error('avatar')<span class="field-error" style="margin-top:4px;display:block">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Footer --}}
            <div class="form-footer">
                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Perubahan
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

    document.getElementById('isActiveToggle').addEventListener('change', function() {
        document.getElementById('toggleLabel').textContent = this.checked ? 'Aktif' : 'Nonaktif';
    });

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
        @if($user->avatar)
            document.getElementById('previewImage').src = '{{ asset("storage/".$user->avatar) }}';
            document.getElementById('previewImage').style.display = 'block';
            document.getElementById('avatarPlaceholder').style.display = 'none';
        @else
            document.getElementById('previewImage').style.display = 'none';
            document.getElementById('previewImage').src = '';
            document.getElementById('avatarPlaceholder').style.display = 'flex';
        @endif
        document.getElementById('avatarFilename').textContent = 'Belum ada file baru dipilih';
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