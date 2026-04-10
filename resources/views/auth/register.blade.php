<x-guest-layout>

<style>
    .reg-head { margin-bottom: 26px; }
    .reg-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800; font-size: 22px; color: #0f172a; line-height: 1.2;
    }
    .reg-sub {
        font-family: 'DM Sans', sans-serif;
        font-size: 14px; color: #64748b; margin-top: 5px;
    }

    .f-group { margin-bottom: 16px; }

    .f-row {
        display: flex; align-items: center;
        justify-content: space-between;
        margin-bottom: 7px;
    }
    .f-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px; font-weight: 700;
        letter-spacing: .06em; text-transform: uppercase;
        color: #475569;
    }

    .f-input {
        width: 100%;
        height: 44px;
        padding: 0 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 11px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px; color: #0f172a;
        background: #f8fafc;
        outline: none;
        transition: border-color .16s, box-shadow .16s, background .16s;
    }
    .f-input:focus {
        border-color: #3582f0;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(53,130,240,.12);
    }
    .f-input::placeholder { color: #94a3b8; }

    .f-hint {
        font-family: 'DM Sans', sans-serif;
        font-size: 11.5px; color: #94a3b8; margin-top: 5px;
    }

    .f-error {
        display: flex; align-items: center; gap: 5px;
        font-size: 12px; color: #dc2626; margin-top: 6px;
        font-family: 'DM Sans', sans-serif;
    }

    .divider {
        height: 1px; background: #f1f5f9;
        margin: 20px 0;
    }

    .btn-submit {
        width: 100%; height: 46px;
        background: linear-gradient(135deg, #2563eb 0%, #1750c0 100%);
        color: #fff;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700; font-size: 14px;
        letter-spacing: .01em;
        border: none; border-radius: 12px;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        box-shadow: 0 4px 16px rgba(31,99,219,.32);
        transition: opacity .16s, transform .16s, box-shadow .16s;
    }
    .btn-submit:hover {
        opacity: .92; transform: translateY(-1px);
        box-shadow: 0 6px 24px rgba(31,99,219,.42);
    }
    .btn-submit:active { transform: translateY(0); opacity: 1; }

    .login-link-wrap {
        display: flex; align-items: center; justify-content: center;
        gap: 6px; margin-top: 18px;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px; color: #64748b;
    }
    .login-link {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px; font-weight: 700;
        color: #1f63db; text-decoration: none;
        transition: color .15s;
    }
    .login-link:hover { color: #1750c0; text-decoration: underline; }
</style>

<!-- Heading -->
<div class="reg-head">
    <p class="reg-title">Buat akun baru ✨</p>
    <p class="reg-sub">Daftarkan diri Anda ke SmartSchool</p>
</div>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div class="f-group">
        <div class="f-row">
            <label for="name" class="f-label">Nama Lengkap</label>
        </div>
        <input
            id="name" type="text" name="name"
            value="{{ old('name') }}"
            required autofocus autocomplete="name"
            class="f-input" placeholder="Masukkan nama lengkap Anda"
        >
        @error('name')
            <p class="f-error">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Email -->
    <div class="f-group">
        <div class="f-row">
            <label for="email" class="f-label">Alamat Email</label>
        </div>
        <input
            id="email" type="email" name="email"
            value="{{ old('email') }}"
            required autocomplete="username"
            class="f-input" placeholder="nama@sekolah.sch.id"
        >
        @error('email')
            <p class="f-error">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Password -->
    <div class="f-group">
        <div class="f-row">
            <label for="password" class="f-label">Password</label>
        </div>
        <input
            id="password" type="password" name="password"
            required autocomplete="new-password"
            class="f-input" placeholder="Min. 8 karakter"
        >
        <p class="f-hint">Gunakan kombinasi huruf, angka, dan simbol.</p>
        @error('password')
            <p class="f-error">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="f-group">
        <div class="f-row">
            <label for="password_confirmation" class="f-label">Konfirmasi Password</label>
        </div>
        <input
            id="password_confirmation" type="password"
            name="password_confirmation"
            required autocomplete="new-password"
            class="f-input" placeholder="Ulangi password Anda"
        >
        @error('password_confirmation')
            <p class="f-error">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="divider"></div>

    <!-- Submit -->
    <button type="submit" class="btn-submit">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
        Daftar Sekarang
    </button>

    <!-- Login link -->
    <div class="login-link-wrap">
        <span>Sudah punya akun?</span>
        <a href="{{ route('login') }}" class="login-link">Masuk di sini →</a>
    </div>

</form>

</x-guest-layout>