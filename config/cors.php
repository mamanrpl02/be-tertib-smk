<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'http://localhost:3000',
        'http://192.168.137.79:3000',
    ],
    'allowed_headers' => ['*'],
    'supports_credentials' => true,
];
