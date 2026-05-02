<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php $profil = \App\Models\ProfilSekolah::instance(); @endphp

    <title>{{ config('app.name', 'SmartSchool') }} — {{ $profil->nama_sekolah ?? 'SMK Bustanul Ulum' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet" />

    @if($profil->favicon_path)
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $profil->favicon_path) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; }

        .auth-bg {
            background: linear-gradient(140deg, #0d1f4e 0%, #1750c0 50%, #0a6b4a 100%);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 16px;
        }
        .auth-bg::before {
            content: '';
            position: absolute; inset: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 700px 500px at 80% -5%, rgba(89,163,248,.28) 0%, transparent 70%),
                radial-gradient(ellipse 500px 500px at 5% 95%, rgba(16,185,129,.20) 0%, transparent 65%);
        }
        .auth-bg::after {
            content: '';
            position: absolute; inset: 0; pointer-events: none;
            background-image: radial-gradient(circle, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 44px 44px;
        }

        /* ── Brand ── */
        .brand-block {
            position: relative; z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }

        .live-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(255,255,255,.10);
            border: 1px solid rgba(255,255,255,.18);
            backdrop-filter: blur(12px);
            color: rgba(255,255,255,.85);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 99px;
        }

        @keyframes livePulse {
            0%,100% { box-shadow: 0 0 0 0 rgba(74,222,128,.6); }
            50%      { box-shadow: 0 0 0 6px rgba(74,222,128,0); }
        }
        .dot-pulse {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: #4ade80;
            flex-shrink: 0;
            animation: livePulse 2.2s ease-in-out infinite;
        }

        .brand-logo-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .brand-logo-box {
            width: 56px; height: 56px;
            border-radius: 16px;
            background: rgba(255,255,255,.15);
            border: 1.5px solid rgba(255,255,255,.25);
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }
        .brand-logo-box span {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800; font-size: 24px; color: #fff;
        }
        .brand-logo-box img {
            width: 100%; height: 100%;
            object-fit: contain;
            padding: 6px;
        }
        .brand-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800; font-size: 19px; color: #fff;
            letter-spacing: -.01em; line-height: 1;
        }
        .brand-sub {
            font-family: 'DM Sans', sans-serif;
            font-size: 12.5px; color: rgba(255,255,255,.5); margin-top: 3px;
        }

        /* ── Card ── */
        .auth-card {
            position: relative; z-index: 10;
            width: 100%; max-width: 420px;
            background: #fff;
            border-radius: 20px;
            box-shadow:
                0 1px 2px rgba(0,0,0,.04),
                0 8px 20px rgba(13,31,78,.16),
                0 28px 60px rgba(13,31,78,.20);
            padding: 36px 32px 30px;
        }

        /* ── Footer ── */
        .auth-footer {
            position: relative; z-index: 10;
            margin-top: 20px;
            color: rgba(255,255,255,.3);
            font-family: 'DM Sans', sans-serif;
            font-size: 11px;
            text-align: center;
            line-height: 1.5;
        }

        /* ── Animations ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-1 { animation: fadeUp .55s cubic-bezier(.22,.68,0,1.2) both; }
        .fade-2 { animation: fadeUp .55s .12s cubic-bezier(.22,.68,0,1.2) both; }
        .fade-3 { animation: fadeUp .55s .24s cubic-bezier(.22,.68,0,1.2) both; }
    </style>
</head>
<body class="antialiased">
<div class="auth-bg">

    <!-- Brand header -->
    <div class="brand-block fade-1">
        <span class="live-badge">
            <span class="dot-pulse"></span>
            Platform Aktif · Tahun Ajaran 2025/2026
        </span>
        <a href="{{ url('/') }}" class="brand-logo-wrap">
            <div class="brand-logo-box">
                @if($profil->logo_path)
                    <img src="{{ asset('storage/' . $profil->logo_path) }}"
                         alt="Logo {{ $profil->singkatan ?? 'Sekolah' }}">
                @elseif($profil->logo_url)
                    <img src="{{ $profil->logo_url }}"
                         alt="Logo {{ $profil->singkatan ?? 'Sekolah' }}">
                @else
                    <span>{{ strtoupper(substr($profil->singkatan ?? $profil->nama_sekolah ?? 'S', 0, 1)) }}</span>
                @endif
            </div>
            <div style="text-align:center;">
                <p class="brand-name">SmartSchool</p>
                <p class="brand-sub">{{ $profil->nama_sekolah ?? 'SMK Bustanul Ulum' }}</p>
            </div>
        </a>
    </div>

    <!-- Main card -->
    <div class="auth-card fade-2">
        {{ $slot }}
    </div>

    <!-- Footer -->
    <p class="auth-footer fade-3">
        © {{ date('Y') }} SmartSchool · {{ $profil->nama_sekolah ?? 'SMK Bustanul Ulum' }}
    </p>

</div>
</body>
</html>