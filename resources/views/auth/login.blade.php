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
    .f-forgot {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px; font-weight: 600;
        color: #1f63db; text-decoration: none;
        transition: color .15s;
    }
    .f-forgot:hover { color: #1750c0; text-decoration: underline; }

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

    .f-error {
        display: flex; align-items: center; gap: 5px;
        font-size: 12px; color: #dc2626; margin-top: 6px;
    }

    .f-check {
        display: flex; align-items: center; gap: 9px;
        margin-bottom: 22px; cursor: pointer;
    }
    .f-check input[type="checkbox"] {
        width: 16px; height: 16px;
        border-radius: 4px;
        border: 1.5px solid #cbd5e1;
        accent-color: #1f63db;
        cursor: pointer; flex-shrink: 0;
    }
    .f-check span {
        font-family: 'DM Sans', sans-serif;
        font-size: 13.5px; color: #475569;
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
        opacity: .92;
        transform: translateY(-1px);
        box-shadow: 0 6px 24px rgba(31,99,219,.42);
    }
    .btn-submit:active { transform: translateY(0); opacity: 1; }

    .role-strip {
        display: flex; flex-wrap: wrap; gap: 6px;
        justify-content: center;
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid #f1f5f9;
    }
    .r-pill {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10px; font-weight: 700;
        letter-spacing: .05em; text-transform: uppercase;
        padding: 4px 11px; border-radius: 99px;
        line-height: 1;
    }

    .status-ok {
        display: flex; align-items: center; gap: 8px;
        background: #f0fdf4; border: 1px solid #bbf7d0;
        color: #15803d; border-radius: 10px;
        padding: 10px 14px; font-size: 13px;
        margin-bottom: 20px;
        font-family: 'DM Sans', sans-serif;
    }
</style>

@if (session('status'))
    <div class="status-ok">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('status') }}
    </div>
@endif

<!-- Heading -->
<div class="login-head">
    <p class="login-title">Selamat datang 👋</p>
    <p class="login-sub">Masuk ke akun SmartSchool Anda</p>
</div>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email -->
    <div class="f-group">
        <div class="f-row">
            <label for="email" class="f-label">Email / Username</label>
        </div>
        <input
            id="email" type="email" name="email"
            value="{{ old('email') }}"
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

    <!-- Password -->
    <div class="f-group">
        <div class="f-row">
            <label for="password" class="f-label">Password</label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="f-forgot">Lupa password?</a>
            @endif
        </div>
        <input
            id="password" type="password" name="password"
            required autocomplete="current-password"
            class="f-input" placeholder="••••••••"
        >
        @error('password')
            <p class="f-error">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Remember -->
    <label class="f-check">
        <input id="remember_me" type="checkbox" name="remember">
        <span>Ingat saya di perangkat ini</span>
    </label>

    <!-- Submit -->
    <button type="submit" class="btn-submit">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        Masuk ke Sistem
    </button>

    <!-- Role pills -->
    <div class="role-strip">
        <span class="r-pill" style="background:#eef6ff;color:#1750c0;border:1px solid #bfdbfe;">Admin</span>
        <span class="r-pill" style="background:#fdf2f8;color:#9d174d;border:1px solid #fbcfe8;">Guru</span>
        <span class="r-pill" style="background:#fffbeb;color:#92400e;border:1px solid #fde68a;">Guru Piket</span>
        <span class="r-pill" style="background:#f5f3ff;color:#5b21b6;border:1px solid #ddd6fe;">Orang Tua</span>
        <span class="r-pill" style="background:#f0fdf4;color:#14532d;border:1px solid #bbf7d0;">Siswa</span>
    </div>

</form>

</x-guest-layout>