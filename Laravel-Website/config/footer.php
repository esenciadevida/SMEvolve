<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Footer Configuration
    |--------------------------------------------------------------------------
    |
    | Global footer content. Contact values are read from config('company.contact')
    | so nothing is displayed until it has been confirmed.
    |
    */

    'company' => [
        'tagline' => 'Helping businesses grow through reliable technology.',
        'description' => 'SMEvolve builds modern websites, custom software, mobile applications, AI chatbots, and automation solutions for businesses in Lagos and across Nigeria.',
    ],

    'business_hours' => null,

    'location' => 'Lagos, Nigeria',

    'bottom_links' => [
        ['label' => 'Privacy Policy', 'route' => 'privacy-policy.index'],
        ['label' => 'Terms & Conditions', 'route' => 'terms.index'],
        ['label' => 'Cookie Policy', 'route' => 'cookies.index'],
    ],
];
