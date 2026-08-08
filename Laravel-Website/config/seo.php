<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Global SEO Configuration
    |--------------------------------------------------------------------------
    |
    | Shared metadata and schema used across every public page.
    |
    */

    'site_name' => env('APP_NAME', 'SMEvolve'),

    'url' => env('APP_URL', 'https://smevolve.tech'),

    'default_description' => 'SMEvolve helps businesses build modern websites, custom software, mobile applications, and automation solutions designed around their unique goals.',

    'robots' => 'index, follow',

    'og' => [
        'type' => 'website',
        'image' => 'assets/og-default.png',
    ],

    'twitter' => [
        'card' => 'summary_large_image',
        'handle' => null,
    ],

    'organization' => [
        'name' => env('APP_NAME', 'SMEvolve'),
        'url' => env('APP_URL', 'https://smevolve.tech'),
        'logo' => null,
        'email' => null,
        'phone' => null,
        'social' => [],
    ],
];
