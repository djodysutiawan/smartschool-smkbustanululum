<x-guest-layout>
<style>
    .login-head { margin-bottom: 28px; }
    .login-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800; font-size: 22px; color: #0f172a; line-height: 1.2;
    }
    .login-sub {
        font-family: 'DM Sans', sans-serif;
        font-size: 14px; color: #64748b; margin-top: 5px;
    }

    .f-group { margin-bottom: 18px; }
    .f-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 7px; }
    .f-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px; font-weight: 700;
        letter-spacing: .06em; text-transform: uppercase; color: #475569;
    }
    .f-input {
        width: 100%; height: 44px; padding: 0 14px;
        border: 1.5px solid #e2e8f0; border-radius: 11px;
        font-family: 'DM Sans', sans-serif; font-size: 14px; color: #0f172a;
        background: #f8fafc; outline: none;
        transition: border-color .16s, box-shadow .16s, background .16s;
    }
    .f-input:focus {
        border-color: #3582f0; background: #fff;
        box-shadow: 0 0 0 3px rgba(53,130,240,.12);
    }
    .f-input::placeholder { color: #94a3b8; }
    .f-error {
        display: flex; align-items: center; gap: 5px;
        font-size: 12px; color: #dc2626; margin-top: 6px;
    }

    .pw-wrap { position: relative; }
    .pw-wrap .f-input { padding-right: 44px; }
    .pw-toggle {
        position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: #94a3b8; padding: 4px; line-height: 0;
        transition: color .15s;
    }
    .pw-toggle:hover { color: #475569; }

    .btn-submit {
        width: 100%; height: 46px;
        background: linear-gradient(135deg, #2563eb 0%, #1750c0 100%);
        color: #fff;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700; font-size: 14px;
        border: none; border-radius: 12px; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        box-shadow: 0 4px 16px rgba(31,99,219,.32);
        transition: opacity .16s, transform .16s, box-shadow .16s;
    }
    .btn-submit:hover { opacity: .92; transform: translateY(-1px); box-shadow: 0 6px 24px rgba(31,99,219,.42); }
    .btn-submit:active { transform: translateY(0); opacity: 1; }
    .btn-submit:disabled { opacity: .6; cursor: not-allowed; transform: none; }

    .back-link {
        display: flex; align-items: center; gap: 6px; justify-content: center;
        margin-top: 20px; padding-top: 18px; border-top: 1px solid #f1f5f9;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px; font-weight: 600; color: #64748b;
        text-decoration: none; transition: color .15s;
    }
    .back-link:hover { color: #1f63db; }

    .strength-bar { height: 4px; border-radius: 99px; background: #e2e8f0; margin-top: 8px; overflow: hidden; }
    .strength-fill { height: 100%; border-radius: 99px; width: 0; transition: width .3s, background .3s; }
    .strength-label { font-size: 11px; font-family: 'DM Sans', sans-serif; color: #94a3b8; margin-top: 4px; }

    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="login-head">
    <p class="login-title">Reset Password 🔒</p>
    <p class="login-sub">Buat password baru untuk akun Anda</p>
</div>

<form method="POST" action="{{ route('password.store') }}" id="resetForm">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    {{-- Email --}}
    <div class="f-group">
        <div class="f-row">
            <label for="email" class="f-label">Alamat Email</label>
        </div>
        <input
            id="email" type="email" name="email"
            value="{{ old('email', $request->email) }}"
            required autofocus autocomplete="username"
            class="f-input" placeholder="nama@sekolah.sch.id"
        >
        @error('email')
            <p class="f-error">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Password Baru --}}
    <div class="f-group">
        <div class="f-row">
            <label for="password" class="f-label">Password Baru</label>
        </div>
        <div class="pw-wrap">
            <input
                id="password" type="password" name="password"
                required autocomplete="new-password"
                class="f-input" placeholder="Minimal 8 karakter"
                oninput="checkStrength(this.value)"
            >
            <button type="button" class="pw-toggle" onclick="togglePw('password', this)">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
        </div>
        <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
        <p class="strength-label" id="strengthLabel">Masukkan password untuk melihat kekuatan</p>
        @error('password')
            <p class="f-error">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Konfirmasi Password --}}
    <div class="f-group">
        <div class="f-row">
            <label for="password_confirmation" class="f-label">Konfirmasi Password</label>
        </div>
        <div class="pw-wrap">
            <input
                id="password_confirmation" type="password" name="password_confirmation"
                required autocomplete="new-password"
                class="f-input" placeholder="Ulangi password baru"
            >
            <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation', this)">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
        </div>
        @error('password_confirmation')
            <p class="f-error">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <button type="submit" class="btn-submit" id="btnSubmit">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Simpan Password Baru
    </button>
</form>

<a href="{{ route('login') }}" class="back-link">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Kembali ke halaman login
</a>

<script>
function togglePw(id, btn) {
    const input = document.getElementById(id);
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    btn.innerHTML = isText
        ? '<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>'
        : '<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';
}

function checkStrength(val) {
    const fill = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');
    if (!val) {
        fill.style.width = '0'; fill.style.background = '';
        label.textContent = 'Masukkan password untuk melihat kekuatan';
        return;
    }
    let score = 0;
    if (val.length >= 8)  score++;
    if (val.length >= 12) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const levels = [
        { w: '20%', bg: '#ef4444', text: 'Sangat lemah' },
        { w: '40%', bg: '#f97316', text: 'Lemah' },
        { w: '60%', bg: '#eab308', text: 'Cukup' },
        { w: '80%', bg: '#22c55e', text: 'Kuat' },
        { w: '100%', bg: '#16a34a', text: 'Sangat kuat' },
    ];
    const lv = levels[Math.min(score - 1, 4)] ?? levels[0];
    fill.style.width = lv.w;
    fill.style.background = lv.bg;
    label.textContent = lv.text;
    label.style.color = lv.bg;
}

document.getElementById('resetForm').addEventListener('submit', function () {
    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.innerHTML = '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan...';
});
</script>

</x-guest-layout>