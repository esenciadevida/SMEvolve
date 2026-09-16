<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Company Configuration
    |--------------------------------------------------------------------------
    |
    | Canonical source for business information across the site (header,
    | footer, floating action hub, and the Contact module). Values that have
    | not been confirmed yet are left null so nothing is displayed until set.
    |
    */

    'name' => env('APP_NAME', 'SMEvolve'),

    'tagline' => 'Helping businesses grow through reliable technology.',

    'description' => 'SMEvolve builds modern websites, custom software, mobile applications, AI chatbots, and automation solutions for businesses in Lagos and across Nigeria.',

    'contact' => [
        'email' => 'hello@smevolve.tech',
        'phone' => '+2347041252965',
        'whatsapp' => null,
    ],

    'address' => [
        'street' => null,
        'city' => null,
        'state' => null,
        'country' => null,
        'formatted' => null,
    ],

    'maps' => [
        'embed_url' => null,
        'directions_url' => null,
    ],

    'hours' => [
        'timezone' => 'Africa/Lagos',
        'timezone_label' => 'West Africa Time (WAT)',
        'summary_string' => 'Mon - Fri: 9:00 AM - 6:00 PM (WAT)',

        'summary' => [
            ['label' => 'Monday - Friday', 'value' => '9:00 AM - 6:00 PM', 'status' => 'open'],
            ['label' => 'Saturday', 'value' => 'By Appointment', 'status' => 'appointment'],
            ['label' => 'Sunday', 'value' => 'Closed', 'status' => 'closed'],
        ],

        'schedule' => [
            'open_days' => [1, 2, 3, 4, 5],
            'open_time' => '09:00',
            'close_time' => '18:00',
        ],

        'holiday_notice' => 'During public holidays, response times may be slightly longer than usual.',

        'availability_notice' => "If you contact us outside business hours, we'll respond as soon as we're back online.",

        'response_times' => [
            'whatsapp' => ['label' => 'WhatsApp', 'value' => 'Usually within 1 hour during business hours.', 'icon' => 'chat-bubble-left-right'],
            'email' => ['label' => 'Email', 'value' => 'Usually within 1 business day.', 'icon' => 'envelope'],
            'phone' => ['label' => 'Phone', 'value' => 'Available during business hours.', 'icon' => 'phone'],
            'quote' => ['label' => 'Quote Requests', 'value' => 'Typically reviewed within one business day.', 'icon' => 'document-text'],
        ],
    ],

    'service_area' => [
        'introduction' => 'SMEvolve provides digital solutions to businesses in Lagos and across Nigeria. We collaborate remotely using modern communication and project management tools.',

        'coverage' => [
            ['title' => 'Lagos, Nigeria', 'description' => 'Serving businesses in Lagos with websites, software, AI, and automation solutions.', 'icon' => 'map-pin'],
            ['title' => 'Across Nigeria', 'description' => 'Working with businesses throughout Nigeria on digital transformation projects.', 'icon' => 'globe-alt'],
            ['title' => 'Remote Collaboration', 'description' => 'Delivering projects remotely using modern tools and clear communication.', 'icon' => 'computer-desktop'],
        ],
    ],

    'form' => [
        'contact_methods' => [
            'email' => 'Email',
            'phone' => 'Phone',
            'whatsapp' => 'WhatsApp',
        ],

        'subject_options' => [
            'general_enquiry' => 'General Enquiry',
            'new_project' => 'New Project',
            'website_development' => 'Website Development',
            'custom_software' => 'Custom Software',
            'mobile_app' => 'Mobile App',
            'ai_solutions' => 'AI Solutions',
            'business_automation' => 'Business Automation',
            'support' => 'Support',
            'partnership' => 'Partnership',
            'other' => 'Other',
        ],

        'budget_options' => [
            'under_500k' => 'Under ₦500,000',
            '500k_1m' => '₦500,000 - ₦1,000,000',
            '1m_5m' => '₦1M - ₦5M',
            'over_5m' => '₦5M+',
            'prefer_not' => 'Prefer not to say',
        ],
    ],

    'trust_indicators' => [
        'Friendly support',
        'Fast response times',
        'No-obligation consultation',
        'Secure communication',
    ],
];
