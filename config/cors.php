<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    | Mengizinkan Flutter Web (Chrome) mengakses API Laravel via localhost.
    | Untuk production, ganti allowed_origins dengan domain yang spesifik.
    */

    'paths' => [
        'api/*',
        'storage/*',
        'sanctum/csrf-cookie',
    ],

    'allowed_methods' => ['*'],

    // ✅ Izinkan akses dari Flutter Web (localhost) dan IP LAN (untuk testing)
    'allowed_origins' => [
        'http://localhost',
        'http://localhost:8000',
        'http://localhost:5000',
        'http://localhost:3000',
        'http://127.0.0.1',
        'http://127.0.0.1:8000',
        'http://10.222.161.71',   // IP LAN server Laravel
    ],

    'allowed_origins_patterns' => [
        // ✅ Izinkan semua port localhost untuk Flutter Web dev
        '#^http://localhost(:\d+)?$#',
        '#^http://127\.0\.0\.1(:\d+)?$#',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 86400, // ✅ cache preflight 1 hari agar tidak terlalu banyak OPTIONS request

    'supports_credentials' => false,

];