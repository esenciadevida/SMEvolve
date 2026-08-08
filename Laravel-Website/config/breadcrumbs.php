<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Breadcrumb Sections
    |--------------------------------------------------------------------------
    |
    | Central definitions for breadcrumb trail sections. Pages reference a
    | section key and pass only the current page label, so trail structure is
    | defined once here instead of inside every Blade template.
    |
    */

    'sections' => [
        'services' => ['label' => 'Services', 'route' => 'services.index'],
        'portfolio' => ['label' => 'Portfolio', 'route' => 'portfolio'],
        'packages' => ['label' => 'Packages', 'route' => 'packages'],
        'faq' => ['label' => 'FAQ', 'route' => 'faq'],
        'contact' => ['label' => 'Contact', 'route' => 'contact'],
        'quote' => ['label' => 'Get a Quote', 'route' => 'quote'],
    ],
];
