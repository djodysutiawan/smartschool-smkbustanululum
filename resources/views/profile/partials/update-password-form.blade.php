<div class="section-card">
    <div class="section-header">
        <div class="section-icon">
            <svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </div>
        <div>
            <p class="section-title">Ubah Password</p>
            <p class="section-sub">Pastikan password Anda panjang dan sulit ditebak</p>
        </div>
    </div>

    <form method="post" action="{{ route('password.update') }}" id="passwordForm">
        @csrf @method('put')

        <div class="section-body">
            <div class="form-grid">
                <div class="field col-span-2">
                    <label>Password Saat Ini <span class="req">*</span></label>
                    <div style="position:relative">
                        <input type="password" id="current_password" name="current_password"
                            placeholder="Masukkan password saat ini"
                            class="{{ $errors->updatePassword->has('current_password') ? 'is-invalid' : '' }}"
                            autocomplete="current-password" style="padding-right:44px">
                        <button type="button" onclick="togglePwd('current_password', this)"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text3)">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @if($errors->updatePassword->has('current_password'))
                        <span class="field-error">{{ $errors->updatePassword->first('current_password') }}</span>
                    @endif
                </div>

                <div class="field">
                    <label>Password Baru <span class="req">*</span></label>
                    <div style="position:relative">
                        <input type="password" id="new_password" name="password"
                            placeholder="Min. 8 karakter"
                            class="{{ $errors->updatePassword->has('password') ? 'is-invalid' : '' }}"
                            autocomplete="new-password" style="padding-right:44px"
                            oninput="checkStrength(this.value)">
                        <button type="button" onclick="togglePwd('new_password', this)"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text3)">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <div class="strength-bar"><div class="strength-fill" id="strengthFill" style="width:0%"></div></div>
                    <span class="field-hint" id="strengthText"></span>
                    @if($errors->updatePassword->has('password'))
                        <span class="field-error">{{ $errors->updatePassword->first('password') }}</span>
                    @endif
                </div>

                <div class="field">
                    <label>Konfirmasi Password Baru <span class="req">*</span></label>
                    <div style="position:relative">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Ulangi password baru"
                            class="{{ $errors->updatePassword->has('password_confirmation') ? 'is-invalid' : '' }}"
                            autocomplete="new-password" style="padding-right:44px">
                        <button type="button" onclick="togglePwd('password_confirmation', this)"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text3)">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @if($errors->updatePassword->has('password_confirmation'))
                        <span class="field-error">{{ $errors->updatePassword->first('password_confirmation') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="section-footer">
            <button type="submit" class="btn btn-primary" id="btnSavePwd">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Perbarui Password
            </button>
        </div>
    </form>
</div>

<script>
function togglePwd(id, btn) {
    const inp = document.getElementById(id);
    if (inp.type === 'password') {
        inp.type = 'text';
        btn.innerHTML = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`;
    } else {
        inp.type = 'password';
        btn.innerHTML = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
    }
}

function checkStrength(val) {
    const fill = document.getElementById('strengthFill');
    const text = document.getElementById('strengthText');
    if (!val) { fill.style.width = '0%'; text.textContent = ''; return; }
    let score = 0;
    if (val.length >= 8) score++;
    if (val.length >= 12) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const levels = [
        { pct:'20%', bg:'#ef4444', label:'Sangat Lemah' },
        { pct:'40%', bg:'#f97316', label:'Lemah' },
        { pct:'60%', bg:'#eab308', label:'Cukup' },
        { pct:'80%', bg:'#22c55e', label:'Kuat' },
        { pct:'100%',bg:'#15803d', label:'Sangat Kuat' },
    ];
    const lv = levels[Math.min(score - 1, 4)] || levels[0];
    fill.style.width = lv.pct;
    fill.style.background = lv.bg;
    text.textContent = lv.label;
    text.style.color = lv.bg;
}

document.getElementById('passwordForm').addEventListener('submit', function(e) {
    const curr = document.getElementById('current_password').value;
    const nw   = document.getElementById('new_password').value;
    const conf = document.getElementById('password_confirmation').value;
    if (!curr || !nw || !conf) return;
    if (nw !== conf) {
        e.preventDefault();
        Swal.fire({icon:'warning',title:'Password Tidak Cocok',text:'Password baru dan konfirmasi tidak sama.',confirmButtonColor:'#1f63db'});
        return;
    }
    const btn = document.getElementById('btnSavePwd');
    btn.disabled = true;
    btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Memperbarui…`;
});
</script>