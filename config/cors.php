<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:5173', // Vite default port
        'http://127.0.0.1:5173',
        'http://localhost:5174', // Active Vite fallback port
        'http://127.0.0.1:5174',
        'http://localhost:3000',
        'http://localhost:8000',
        'http://127.0.0.1:8000',
        'https://baznascentralize.vercel.app',
    ],

    'allowed_origins_patterns' => [
        '#^http://(localhost|127\.0\.0\.1):\d+$#', // Matches any dynamic localhost/127.0.0.1 development port
        '#^https://.*\.vercel\.app$#', // Matches any vercel subdomains
    ],

    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization', 'Accept'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
