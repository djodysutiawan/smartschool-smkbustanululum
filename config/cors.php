<?php
return [
    'paths' => [
        'api/*',
        'storage/*',    // ← tambah ini
        'sanctum/csrf-cookie',
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],  // atau spesifik: ['http://localhost:3000', 'http://localhost:5000']

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,
];