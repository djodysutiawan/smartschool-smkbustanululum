<x-guest-layout>

<style>
    .ss-wrap { width: 100%; }

    .ss-brand {
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 32px;
    }
    .ss-brand-icon {
        width: 38px; height: 38px; border-radius: 10px;
        background: #1d4ed8;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .ss-brand-name {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 17px; font-weight: 800;
        color: #0f172a; letter-spacing: -.02em;
    }
    .ss-brand-name span { color: #1d4ed8; }

    .ss-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 23px; font-weight: 800;
        color: #0f172a; line-height: 1.25;
        margin-bottom: 6px;
    }
    .ss-sub {
        font-family: 'DM Sans', sans-serif;
        font-size: 14px; color: #64748b;
        margin-bottom: 28px;
    }

    .ss-alert-ok {
        display: flex; align-items: center; gap: 9px;
        background: #f0fdf4; border: 1px solid #bbf7d0;
        color: #166534; border-radius: 10px;
        padding: 10px 14px; font-size: 13px;
        margin-bottom: 20px;
        font-family: 'DM Sans', sans-serif;
    }

    .ss-fg { margin-bottom: 16px; }

    .ss-row {
        display: flex; align-items: center;
        justify-content: space-between;
        margin-bottom: 6px;
    }
    .ss-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px; font-weight: 700;
        letter-spacing: .065em; text-transform: uppercase;
        color: #475569;
    }
    .ss-forgot {
        font-family: 'DM Sans', sans-serif;
        font-size: 12px; font-weight: 500;
        color: #1d4ed8; text-decoration: none;
    }
    .ss-forgot:hover { text-decoration: underline; }

    .ss-input-wrap { position: relative; }
    .ss-input-icon {
        position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; pointer-events: none;
        display: flex; align-items: center;
    }
    .ss-input {
        width: 100%; height: 44px;
        padding: 0 14px 0 40px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px; color: #0f172a;
        background: #f8fafc;
        outline: none;
        box-sizing: border-box;
        transition: border-color .15s, background .15s, box-shadow .15s;
    }
    .ss-input:focus {
        border-color: #1d4ed8;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(29,78,216,.1);
    }
    .ss-input::placeholder { color: #94a3b8; }

    .ss-input-eye {
        position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
        background: none; border: none; padding: 0;
        cursor: pointer; color: #94a3b8;
        display: flex; align-items: center;
        transition: color .15s;
    }
    .ss-input-eye:hover { color: #475569; }

    .ss-err {
        display: flex; align-items: center; gap: 5px;
        font-family: 'DM Sans', sans-serif;
        font-size: 12px; color: #dc2626; margin-top: 5px;
    }

    .ss-hint {
        font-family: 'DM Sans', sans-serif;
        font-size: 11.5px; color: #94a3b8;
        margin-top: 5px;
    }

    .ss-check {
        display: flex; align-items: center; gap: 9px;
        margin-bottom: 20px; cursor: pointer;
    }
    .ss-check input[type="checkbox"] {
        width: 16px; height: 16px;
        border-radius: 4px;
        accent-color: #1d4ed8;
        cursor: pointer; flex-shrink: 0;
    }
    .ss-check span {
        font-family: 'DM Sans', sans-serif;
        font-size: 13px; color: #475569;
        user-select: none;
    }

    .ss-btn {
        width: 100%; height: 46px;
        background: #1d4ed8;
        color: #fff;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700; font-size: 14px;
        letter-spacing: .01em;
        border: none; border-radius: 10px;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: background .15s, transform .15s;
    }
    .ss-btn:hover { background: #1e40af; }
    .ss-btn:active { transform: scale(.99); }

    .ss-divider {
        display: flex; align-items: center; gap: 12px;
        margin: 22px 0 16px;
    }
    .ss-divider hr {
        flex: 1; border: none;
        border-top: 1px solid #f1f5f9; margin: 0;
    }
    .ss-divider span {
        font-family: 'DM Sans', sans-serif;
        font-size: 11px; color: #cbd5e1;
        white-space: nowrap;
    }

    .ss-roles {
        display: flex; flex-wrap: wrap; gap: 6px;
        justify-content: center;
    }
    .ss-pill {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10px; font-weight: 700;
        letter-spacing: .05em; text-transform: uppercase;
        padding: 4px 11px; border-radius: 99px; line-height: 1;
    }
</style>

<div class="ss-wrap">

    {{-- Heading --}}
    <p class="ss-title">Selamat datang 👋</p>
    <p class="ss-sub">Masuk ke akun SmartSchool Anda</p>

    {{-- Status session --}}
    @if (session('status'))
        <div class="ss-alert-ok">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Identifier --}}
        <div class="ss-fg">
            <div class="ss-row">
                <label for="identifier" class="ss-label">Email / NIS / NIP</label>
            </div>
            <div class="ss-input-wrap">
                <span class="ss-input-icon">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </span>
                <input
                    id="identifier"
                    type="text"
                    name="identifier"
                    value="{{ old('identifier') }}"
                    required autofocus autocomplete="username"
                    class="ss-input"
                    placeholder="Email, NIS siswa, atau NIP guru"
                >
            </div>
            <p class="ss-hint">Contoh: nama@sekolah.sch.id &nbsp;·&nbsp; 12345 (NIS) &nbsp;·&nbsp; 19800101 (NIP)</p>
            @error('identifier')
                <p class="ss-err">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="ss-fg">
            <div class="ss-row">
                <label for="password" class="ss-label">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="ss-forgot">Lupa password?</a>
                @endif
            </div>
            <div class="ss-input-wrap">
                <span class="ss-input-icon">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </span>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required autocomplete="current-password"
                    class="ss-input"
                    placeholder="••••••••"
                >
                <button type="button" class="ss-input-eye" onclick="togglePassword()" aria-label="Tampilkan password">
                    <svg id="eye-icon" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="ss-err">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Remember me --}}
        <label class="ss-check">
            <input id="remember_me" type="checkbox" name="remember">
            <span>Ingat saya di perangkat ini</span>
        </label>

        {{-- Submit --}}
        <button type="submit" class="ss-btn">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                <polyline points="10 17 15 12 10 7"/>
                <line x1="15" y1="12" x2="3" y2="12"/>
            </svg>
            Masuk ke Sistem
        </button>

        {{-- Role pills --}}
        <div class="ss-divider">
            <hr><span>Sistem digunakan oleh</span><hr>
        </div>
        <div class="ss-roles">
            <span class="ss-pill" style="background:#eff6ff;color:#1e40af;border:1px solid #bfdbfe;">Admin</span>
            <span class="ss-pill" style="background:#fdf2f8;color:#9d174d;border:1px solid #fbcfe8;">Guru</span>
            <span class="ss-pill" style="background:#fffbeb;color:#92400e;border:1px solid #fde68a;">Guru Piket</span>
            <span class="ss-pill" style="background:#f5f3ff;color:#5b21b6;border:1px solid #ddd6fe;">Orang Tua</span>
            <span class="ss-pill" style="background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;">Siswa</span>
        </div>

    </form>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eye-icon');
    const show  = input.type === 'password';
    input.type  = show ? 'text' : 'password';
    icon.innerHTML = show
        ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>'
        : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
}
</script>

</x-guest-layout>