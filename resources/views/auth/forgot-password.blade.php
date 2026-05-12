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
    .btn-submit:hover {
        opacity: .92; transform: translateY(-1px);
        box-shadow: 0 6px 24px rgba(31,99,219,.42);
    }
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

    .status-ok {
        display: flex; align-items: center; gap: 8px;
        background: #f0fdf4; border: 1px solid #bbf7d0;
        color: #15803d; border-radius: 10px;
        padding: 10px 14px; font-size: 13px; margin-bottom: 20px;
        font-family: 'DM Sans', sans-serif;
    }

    .info-box {
        display: flex; align-items: flex-start; gap: 10px;
        background: #eff6ff; border: 1px solid #bfdbfe;
        color: #1e40af; border-radius: 10px;
        padding: 12px 14px; font-size: 13px; margin-bottom: 22px;
        font-family: 'DM Sans', sans-serif; line-height: 1.5;
    }
</style>

@if (session('status'))
    <div class="status-ok">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('status') }}
    </div>
@endif

<div class="login-head">
    <p class="login-title">Lupa Password? 🔑</p>
    <p class="login-sub">Kami akan kirimkan link reset ke email Anda</p>
</div>

<div class="info-box">
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    Masukkan alamat email akun Anda. Jika terdaftar, kami akan mengirimkan link untuk membuat password baru.
</div>

<form method="POST" action="{{ route('password.email') }}" id="forgotForm">
    @csrf

    <div class="f-group">
        <div class="f-row">
            <label for="email" class="f-label">Alamat Email</label>
        </div>
        <input
            id="email" type="email" name="email"
            value="{{ old('email') }}"
            required autofocus autocomplete="email"
            class="f-input" placeholder="nama@sekolah.sch.id"
        >
        @error('email')
            <p class="f-error">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <button type="submit" class="btn-submit" id="btnSubmit">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
        Kirim Link Reset Password
    </button>
</form>

<a href="{{ route('login') }}" class="back-link">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Kembali ke halaman login
</a>

<script>
document.getElementById('forgotForm').addEventListener('submit', function () {
    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.innerHTML = '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Mengirim...';
});
</script>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>

</x-guest-layout>