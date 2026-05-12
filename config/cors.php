<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | 'storage/*' SENGAJA DIHAPUS — file storage di-serve langsung oleh
    | symlink filesystem, tidak melewati Laravel middleware, sehingga cors.php
    | tidak berpengaruh untuk path tersebut.
    |
    | Untuk serve file storage dengan CORS, gunakan route API khusus:
    |   GET /api/file/{path}     → storage/app/public/{path}
    |   GET /api/avatar/{file}   → storage/app/public/avatars/{file}
    |
    */

    // Hanya 'api/*' yang efektif — semua request API melewati Laravel middleware
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // Kosongkan allowed_origins jika pakai allowed_origins_patterns
    'allowed_origins' => [],

    // Izinkan semua port localhost — Flutter Web pakai port acak setiap run
    'allowed_origins_patterns' => [
        '#^http://localhost(:\d+)?$#',
        '#^http://127\.0\.0\.1(:\d+)?$#',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    // Cache preflight response selama 24 jam
    'max_age' => 86400,

    // Harus false jika allowed_origins menggunakan wildcard '*'
    'supports_credentials' => false,

];