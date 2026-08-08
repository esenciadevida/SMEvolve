<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Call To Action Configuration
    |--------------------------------------------------------------------------
    |
    | Page-specific copy for the shared Final CTA component. Pages reference a
    | context key (e.g. `packages`) and the component resolves its content
    | from here, keeping business messaging out of Blade templates.
    |
    */

    'packages' => [
        'label' => 'READY TO BUILD?',
        'heading' => "Let's Find the Right Solution for Your Business",
        'description' => "Whether you've found the right package or need a fully customised solution, we're ready to help. Tell us about your project and we'll recommend the best approach for your business and budget.",
        'primary' => ['label' => 'Start Quote Wizard', 'route' => 'quote'],
        'secondary' => ['label' => 'Talk to an Expert', 'route' => 'contact'],
        'trust' => [
            'Free initial consultation',
            'Tailored recommendations',
            'Transparent project planning',
            'Scalable solutions',
        ],
        'trust_note' => 'No pressure. No obligation. Just a conversation about your project and how we can help.',
    ],

    'faq' => [
        'label' => 'NEED MORE HELP?',
        'heading' => "Let's Discuss Your Project With Our Team",
        'description' => 'Still have questions? Tell us what you need and our team will help you choose the right solution for your business.',
        'primary' => ['label' => 'Start Quote Wizard', 'route' => 'quote'],
        'secondary' => ['label' => 'Contact SMEvolve', 'route' => 'contact'],
        'trust' => [
            'Expert guidance',
            'Free consultation',
            'Tailored recommendations',
            'Transparent process',
        ],
        'trust_note' => 'No pressure. No obligation. Just a conversation about your project and how we can help.',
    ],
];
