<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Smart Floating Action Hub
    |--------------------------------------------------------------------------
    |
    | Configures the global action hub. Action href values that reference
    | 'whatsapp', 'phone' or 'email' are resolved from config('company.contact')
    | and are hidden when the value has not been configured.
    |
    */

    'enabled' => true,

    'label' => 'Get in touch',

    'actions' => [
        [
            'id' => 'whatsapp',
            'label' => 'Chat on WhatsApp',
            'icon' => 'chat-bubble-left-right',
            'href' => 'whatsapp',
        ],
        [
            'id' => 'quote',
            'label' => 'Get a Free Quote',
            'icon' => 'document-text',
            'route' => 'quote',
        ],
        [
            'id' => 'contact',
            'label' => 'Contact Us',
            'icon' => 'envelope',
            'route' => 'contact',
        ],
        [
            'id' => 'phone',
            'label' => 'Call SMEvolve',
            'icon' => 'headset',
            'href' => 'phone',
        ],
        [
            'id' => 'email',
            'label' => 'Email SMEvolve',
            'icon' => 'envelope',
            'href' => 'email',
        ],
        [
            'id' => 'back-to-top',
            'label' => 'Back to Top',
            'icon' => 'arrow-up',
            'action' => 'back-to-top',
        ],
    ],
];
