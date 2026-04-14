<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartSchool') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: #f1f5f9; color: #0f172a; }

        /* Page header (slot) */
        .page-header {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 28px;
        }
        .page-header h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700; font-size: 17px; color: #0f172a;
        }

        /* Page content wrapper */
        .page-body {
            padding: 24px 28px;
            max-width: 1280px;
        }

        @media (max-width: 768px) {
            .page-header { padding: 14px 16px; }
            .page-body   { padding: 16px; }
        }
    </style>
</head>
<body>

    {{-- Layout shell (sidebar + topbar injected here) --}}
    <div class="layout-shell">

        {{-- Sidebar & topbar --}}
        @include('layouts.navigation')

        {{-- Main content --}}
        <main class="main-wrap">

            {{-- Page header slot --}}
            @isset($header)
                <div class="page-header">
                    {{ $header }}
                </div>
            @endisset

            {{-- Page body --}}
            <div class="page-body">
                {{ $slot }}
            </div>

        </main>
    </div>
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>