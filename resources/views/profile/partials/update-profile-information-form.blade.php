<div class="section-card">
    <div class="section-header">
        <div class="section-icon">
            <svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
        </div>
        <div>
            <p class="section-title">Informasi Profil</p>
            <p class="section-sub">Perbarui nama, email, nomor HP, dan foto profil Anda</p>
        </div>
    </div>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profileForm">
        @csrf @method('patch')

        <div class="section-body">

            {{-- Avatar Upload --}}
            <div class="field" style="margin-bottom:20px">
                <label>Foto Profil</label>
                <div class="avatar-upload-row">
                    @if($user->avatar)
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="avatar-current" id="avatarPreview">
                    @else
                        <div class="avatar-current-placeholder" id="avatarPlaceholder">
                            <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        <img src="" alt="" class="avatar-current" id="avatarPreview" style="display:none">
                    @endif
                    <div>
                        <label for="avatarInput" class="avatar-upload-btn">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            Ganti Foto
                        </label>
                        <input type="file" id="avatarInput" name="avatar" accept="image/jpg,image/jpeg,image/png,image/webp">
                        <p class="field-hint" style="margin-top:6px">JPG, PNG, WebP — maks. 2 MB</p>
                        @error('avatar')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="form-grid">
                <div class="field col-span-2">
                    <label>Nama Lengkap <span class="req">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        placeholder="Masukkan nama lengkap"
                        class="{{ $errors->has('name') ? 'is-invalid' : '' }}" required autofocus>
                    @error('name')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label>Alamat Email <span class="req">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        placeholder="contoh@email.com"
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}" required>
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div style="background:#fefce8;border:1px solid #fde68a;border-radius:6px;padding:10px 12px;margin-top:6px">
                            <p style="font-size:12.5px;color:#a16207">
                                Email Anda belum diverifikasi.
                                <button form="send-verification" style="font-weight:700;text-decoration:underline;background:none;border:none;cursor:pointer;color:#a16207;font-size:12.5px">
                                    Kirim ulang verifikasi
                                </button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p style="font-size:12.5px;color:#15803d;margin-top:4px;font-weight:600">Link verifikasi baru telah dikirim ke email Anda.</p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="field">
                    <label>Nomor HP / WhatsApp</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                        placeholder="cth. 08123456789"
                        class="{{ $errors->has('no_hp') ? 'is-invalid' : '' }}">
                    @error('no_hp')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                {{-- Read-only role info --}}
                <div class="field">
                    <label>Role / Jabatan</label>
                    <input type="text" value="{{ ucfirst(str_replace('_', ' ', $user->role)) }}" disabled
                        style="background:var(--surface3);color:var(--text3);cursor:not-allowed">
                    <span class="field-hint">Role tidak dapat diubah sendiri. Hubungi administrator.</span>
                </div>

                <div class="field">
                    <label>Status Akun</label>
                    <input type="text" value="{{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}" disabled
                        style="background:var(--surface3);color:var(--text3);cursor:not-allowed">
                </div>
            </div>
        </div>

        <div class="section-footer">
            <button type="submit" class="btn btn-primary" id="btnSaveProfile">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

<script>
document.getElementById('avatarInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    if (file.size > 2 * 1024 * 1024) {
        Swal.fire({icon:'warning',title:'File Terlalu Besar',text:'Ukuran foto maksimal 2 MB.',confirmButtonColor:'#1f63db'});
        this.value = ''; return;
    }
    const reader = new FileReader();
    reader.onload = function(ev) {
        const preview = document.getElementById('avatarPreview');
        const placeholder = document.getElementById('avatarPlaceholder');
        preview.src = ev.target.result;
        preview.style.display = 'block';
        if (placeholder) placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
});

document.getElementById('profileForm').addEventListener('submit', function() {
    const btn = document.getElementById('btnSaveProfile');
    btn.disabled = true;
    btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
});
</script>