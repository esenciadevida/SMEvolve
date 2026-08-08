<?php

return [
    'services' => [
        ['slug' => 'website-development', 'name' => 'Website Development', 'icon' => 'globe-alt', 'homepage' => true, 'description' => 'Modern, responsive websites designed to showcase your business, attract customers, and improve your online visibility.'],
        ['slug' => 'ecommerce-development', 'name' => 'E-commerce Development', 'icon' => 'shopping-cart', 'homepage' => true, 'description' => 'Secure online stores with customer-friendly shopping experiences and business management features.'],
        ['slug' => 'custom-software', 'name' => 'Custom Software Development', 'icon' => 'rectangle-stack', 'homepage' => true, 'description' => 'Custom applications and business systems created to improve efficiency and solve specific operational challenges.'],
        ['slug' => 'laravel-development', 'name' => 'Laravel Development', 'icon' => 'server', 'homepage' => true, 'description' => 'Secure Laravel applications designed for businesses that need reliable backend systems and custom functionality.'],
        ['slug' => 'wordpress-development', 'name' => 'WordPress Development', 'icon' => 'device-desktop', 'homepage' => true, 'description' => 'Professional WordPress websites optimized for performance, usability, and search visibility.'],
        ['slug' => 'mobile-app-development', 'name' => 'Mobile App Development', 'icon' => 'device-mobile', 'homepage' => true, 'description' => 'Cross-platform mobile applications designed to improve customer engagement and business operations.'],
        ['slug' => 'ai-solutions', 'name' => 'AI Solutions', 'icon' => 'cpu-chip', 'homepage' => true, 'description' => 'AI-powered tools and intelligent solutions that improve productivity, automation, and customer experiences.'],
        ['slug' => 'business-automation', 'name' => 'Business Automation', 'icon' => 'bolt', 'homepage' => true, 'description' => 'Automation solutions that help businesses save time, reduce manual work, and improve efficiency.'],
        ['slug' => 'api-development', 'name' => 'API Development', 'icon' => 'code', 'homepage' => false, 'description' => 'Custom APIs and integrations that connect systems and enable reliable data exchange.'],
        ['slug' => 'website-maintenance', 'name' => 'Website Maintenance', 'icon' => 'lifebuoy', 'homepage' => false, 'description' => 'Ongoing maintenance, security updates, and technical support that keep your website secure, fast, and reliable.'],
    ],

    'contact' => [
        'email' => null,
        'phone' => null,
        'whatsapp' => null,
    ],

    'search' => [
        'min_query_length' => 2,
        'max_query_length' => 120,
        'results_per_resource' => 5,
        'max_results_per_resource' => 10,
        'rate_limit' => 10,
    ],

    'technologies' => [
        [
            'title' => 'Web Development',
            'description' => 'Modern websites and web platforms designed for performance and usability.',
            'icon' => 'code',
            'technologies' => ['Laravel', 'Blade', 'PHP', 'React', 'Next.js', 'Tailwind CSS', 'JavaScript'],
        ],
        [
            'title' => 'Backend & API Development',
            'description' => 'Reliable backend systems and integrations that support business operations.',
            'icon' => 'server',
            'technologies' => ['Laravel', 'FastAPI', 'Python', 'REST APIs', 'Database Systems'],
        ],
        [
            'title' => 'Mobile Application Development',
            'description' => 'Cross-platform mobile solutions for businesses and customers.',
            'icon' => 'device-mobile',
            'technologies' => ['React Native', 'Mobile APIs', 'Cross-platform Development'],
        ],
        [
            'title' => 'Database & Infrastructure',
            'description' => 'Secure and scalable systems designed for reliable performance.',
            'icon' => 'database',
            'technologies' => ['MySQL', 'PostgreSQL', 'Cloud Hosting', 'Server Management'],
        ],
        [
            'title' => 'AI & Automation',
            'description' => 'Intelligent solutions that improve efficiency and business workflows.',
            'icon' => 'sparkles',
            'technologies' => ['AI APIs', 'Automation Workflows', 'AI Assistants', 'Machine Learning Solutions'],
        ],
    ],
];
