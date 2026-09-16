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

    'default_description' => 'SMEvolve helps businesses in Lagos and Nigeria build modern websites, custom software, mobile applications, AI chatbots, and automation solutions designed around their unique goals.',

    'robots' => 'index, follow',

    'og' => [
        'type' => 'website',
        'image' => 'assets/og-default.png',
    ],

    'twitter' => [
        'card' => 'summary_large_image',
        'handle' => null,
    ],

    'sitemap' => [
        /*
        | How long (seconds) the generated sitemap XML is cached before it is
        | rebuilt. Keeps /sitemap.xml lightweight while still reflecting
        | published content changes within the TTL window.
        */
        'cache_ttl' => (int) env('SITEMAP_CACHE_TTL', 3600),

        /*
        | Static public routes included in the sitemap. Route names must be
        | genuinely indexable marketing pages only. Dynamic service and
        | portfolio URLs are appended by the sitemap controller.
        |
        | /quote is intentionally omitted: it is a lead-generation wizard with
        | little search-engine value and no canonical reason to index it.
        */
        'static_routes' => [
            'home',
            'about',
            'services.index',
            'packages',
            'portfolio',
            'faq',
            'contact',
        ],
    ],

    'organization' => [
        'name' => env('APP_NAME', 'SMEvolve'),
        'url' => env('APP_URL', 'https://smevolve.tech'),
        'logo' => null,
        'email' => 'hello@smevolve.tech',
        'phone' => '+2347041252965',
        'social' => [],
    ],
];
