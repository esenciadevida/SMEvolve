<?php

return [
    'main' => [
        ['label' => 'Home', 'route' => 'home', 'order' => 10, 'active' => ['home']],
        ['label' => 'About', 'route' => 'about', 'order' => 20, 'active' => ['about']],
        ['label' => 'Services', 'route' => 'services.index', 'order' => 30, 'active' => ['services.index', 'services.show'], 'children' => true],
        ['label' => 'Packages', 'route' => 'packages', 'order' => 40, 'active' => ['packages']],
        ['label' => 'Portfolio', 'route' => 'portfolio', 'order' => 50, 'active' => ['portfolio', 'portfolio.show', 'portfolio.category']],
        ['label' => 'FAQ', 'route' => 'faq', 'order' => 65, 'active' => ['faq']],
        ['label' => 'Contact', 'route' => 'contact', 'order' => 70, 'active' => ['contact']],
    ],

    'footer' => [
        'company' => [
            ['label' => 'About', 'route' => 'about'],
            ['label' => 'Portfolio', 'route' => 'portfolio'],
            ['label' => 'Contact', 'route' => 'contact'],
            ['label' => 'Get a Quote', 'route' => 'quote'],
        ],
        'services' => [
            ['label' => 'Website Development', 'route' => 'services.show', 'params' => ['service' => 'website-development']],
            ['label' => 'E-commerce Development', 'route' => 'services.show', 'params' => ['service' => 'ecommerce-development']],
            ['label' => 'Custom Software', 'route' => 'services.show', 'params' => ['service' => 'custom-software']],
            ['label' => 'Laravel Development', 'route' => 'services.show', 'params' => ['service' => 'laravel-development']],
            ['label' => 'WordPress Development', 'route' => 'services.show', 'params' => ['service' => 'wordpress-development']],
            ['label' => 'Mobile Apps', 'route' => 'services.show', 'params' => ['service' => 'mobile-app-development']],
            ['label' => 'AI Solutions', 'route' => 'services.show', 'params' => ['service' => 'ai-solutions']],
            ['label' => 'Business Automation', 'route' => 'services.show', 'params' => ['service' => 'business-automation']],
            ['label' => 'API Development', 'route' => 'services.show', 'params' => ['service' => 'api-development']],
            ['label' => 'Website Maintenance', 'route' => 'services.show', 'params' => ['service' => 'website-maintenance']],
        ],
        'resources' => [
            ['label' => 'FAQ', 'route' => 'faq'],
            ['label' => 'Privacy Policy', 'route' => 'privacy-policy.index'],
            ['label' => 'Terms & Conditions', 'route' => 'terms.index'],
            ['label' => 'Cookie Policy', 'route' => 'cookies.index'],
        ],
    ],
];
