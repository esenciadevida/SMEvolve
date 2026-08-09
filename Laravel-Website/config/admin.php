<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin Portal Configuration
    |--------------------------------------------------------------------------
    |
    | Central configuration for the SMEvolve Admin Portal: role permission
    | matrix, session behaviour, rate limits and the optional bootstrap admin
    | created by the seeder. Credentials are loaded from the environment only.
    |
    */

    /*
    | Session lifetime in minutes. Administrators are forced to reauthenticate
    | after this period of inactivity.
    */
    'session_lifetime_minutes' => (int) env('ADMIN_SESSION_LIFETIME_MINUTES', 120),

    'login_rate_limit' => (int) env('ADMIN_LOGIN_RATE_LIMIT', 5),

    /*
    | Global administrative search behaviour: minimum query length for the
    | autocomplete endpoint, the per-resource result cap and the autocomplete
    | rate limit.
    */
    'search_min_query_length' => (int) env('ADMIN_SEARCH_MIN_QUERY_LENGTH', 2),
    'search_results_per_resource' => (int) env('ADMIN_SEARCH_RESULTS_PER_RESOURCE', 5),
    'search_rate_limit' => (int) env('ADMIN_SEARCH_RATE_LIMIT', 30),

    /*
    | Editable website settings grouped by admin page. Each entry declares the
    | config key it overrides, the storage type, the validation rules and the
    | accessible label used in the admin interface.
    */
    'settings' => [
        'general' => [
            'company.name' => ['type' => 'string', 'label' => 'Company Name', 'rules' => ['required', 'string', 'max:100']],
            'company.tagline' => ['type' => 'string', 'label' => 'Company Tagline', 'rules' => ['nullable', 'string', 'max:160']],
            'company.description' => ['type' => 'string', 'label' => 'Company Description', 'rules' => ['nullable', 'string', 'max:500']],
            'footer.company.tagline' => ['type' => 'string', 'label' => 'Footer Tagline', 'rules' => ['nullable', 'string', 'max:160']],
            'footer.company.description' => ['type' => 'string', 'label' => 'Footer Description', 'rules' => ['nullable', 'string', 'max:500']],
        ],
        'contact' => [
            'company.contact.email' => ['type' => 'string', 'label' => 'Primary Email', 'rules' => ['nullable', 'email', 'max:190']],
            'company.contact.phone' => ['type' => 'string', 'label' => 'Primary Phone', 'rules' => ['nullable', 'string', 'max:30']],
            'company.contact.whatsapp' => ['type' => 'string', 'label' => 'WhatsApp Link', 'rules' => ['nullable', 'url', 'max:300']],
            'company.address.street' => ['type' => 'string', 'label' => 'Street Address', 'rules' => ['nullable', 'string', 'max:190']],
            'company.address.city' => ['type' => 'string', 'label' => 'City', 'rules' => ['nullable', 'string', 'max:100']],
            'company.address.state' => ['type' => 'string', 'label' => 'State / Province', 'rules' => ['nullable', 'string', 'max:100']],
            'company.address.country' => ['type' => 'string', 'label' => 'Country', 'rules' => ['nullable', 'string', 'max:100']],
        ],
        'business' => [
            'company.hours.summary_string' => ['type' => 'string', 'label' => 'Business Hours Summary', 'rules' => ['nullable', 'string', 'max:190']],
            'company.hours.holiday_notice' => ['type' => 'string', 'label' => 'Holiday Notice', 'rules' => ['nullable', 'string', 'max:300']],
            'company.hours.availability_notice' => ['type' => 'string', 'label' => 'Availability Notice', 'rules' => ['nullable', 'string', 'max:300']],
            'company.service_area.introduction' => ['type' => 'string', 'label' => 'Service Area Introduction', 'rules' => ['nullable', 'string', 'max:500']],
        ],
        'social' => [
            'social_links.platforms' => ['type' => 'json', 'label' => 'Social Links', 'rules' => ['nullable', 'array']],
        ],
    ],

    /*
    | Role permission matrix. These arrays mirror the approved baseline matrix
    | in Documentation/17_Admin_Portal/04_Admin_Roles_and_Permissions.md.
    */
    'roles' => [
        'super_admin' => [
            'dashboard.view',
            'analytics.view',
            'settings.view',
            'settings.update',
            'quotes.view',
            'quotes.search',
            'quotes.update_status',
            'contact.view',
            'portfolio.view',
            'portfolio.create',
            'portfolio.update',
            'portfolio.publish',
            'portfolio.delete',
            'chatbot.view',
            'chatbot.update',
            'ai.view',
            'ai.update',
            'administrators.view',
            'administrators.create',
            'administrators.update',
            'administrators.disable',
            'administrators.change_role',
            'audit.view',
            'profile.update',
            'security.password_update',
        ],
        'admin' => [
            'dashboard.view',
            'analytics.view',
            'settings.view',
            'settings.update',
            'quotes.view',
            'quotes.search',
            'quotes.update_status',
            'contact.view',
            'portfolio.view',
            'portfolio.create',
            'portfolio.update',
            'portfolio.publish',
            'chatbot.view',
            'chatbot.update',
            'ai.view',
            'profile.update',
            'security.password_update',
        ],
        'editor' => [
            'dashboard.view',
            'settings.view',
            'portfolio.view',
            'portfolio.create',
            'portfolio.update',
            'profile.update',
            'security.password_update',
        ],
        'support' => [
            'dashboard.view',
            'quotes.view',
            'quotes.search',
            'quotes.update_status',
            'contact.view',
            'profile.update',
            'security.password_update',
        ],
    ],

    /*
    | Permission groups used to organise the permission editor in the Admin
    | Portal role management screens. Every key must exist in the
    | config/admin_permissions.php registry.
    */
    'permission_groups' => [
        'Dashboard' => ['dashboard.view'],
        'Analytics' => ['analytics.view'],
        'Website Settings' => ['settings.view', 'settings.update'],
        'Portfolio' => ['portfolio.view', 'portfolio.create', 'portfolio.update', 'portfolio.publish', 'portfolio.delete'],
        'Quotes' => ['quotes.view', 'quotes.search', 'quotes.update_status'],
        'Contact' => ['contact.view'],
        'Chatbot' => ['chatbot.view', 'chatbot.update'],
        'AI' => ['ai.view', 'ai.update'],
        'Administrators' => ['administrators.view', 'administrators.create', 'administrators.update', 'administrators.disable', 'administrators.change_role'],
        'Audit' => ['audit.view'],
        'Account' => ['profile.update', 'security.password_update'],
    ],

    /*
    | Optional bootstrap administrator created by AdministratorSeeder. Only
    | created when both values are present in the environment.
    */
    'first_admin' => [
        'name' => env('ADMIN_NAME', 'SMEvolve Administrator'),
        'email' => env('ADMIN_EMAIL'),
        'password' => env('ADMIN_PASSWORD'),
    ],

    /*
    | Approximate IP geolocation for the audit log. Disabled by default; an
    | explicit provider class must be configured before any external lookup is
    | attempted. Never blocks authentication or audit logging.
    */
    'geolocation' => [
        'enabled' => (bool) env('ADMIN_GEOLOCATION_ENABLED', false),
        'provider' => env('ADMIN_GEOLOCATION_PROVIDER'),
        'timeout_seconds' => (int) env('ADMIN_GEOLOCATION_TIMEOUT', 2),
    ],

    /*
    | Anonymous, privacy-conscious server-side page view tracking. Raw IPs are
    | never stored; bot signatures are filtered and per-visitor volume is capped.
    */
    'tracking' => [
        'enabled' => (bool) env('TRACKING_ENABLED', true),
        'exclude_paths' => [
            'admin',
            'api',
            'up',
            'storage',
            '_debugbar',
            'telescope',
            'vendor',
        ],
        'dedupe_seconds' => (int) env('TRACKING_DEDUPE_SECONDS', 60),
        'max_per_minute_per_visitor' => (int) env('TRACKING_MAX_PER_MINUTE_PER_VISITOR', 30),
        'bot_signatures' => [
            'bot', 'crawler', 'spider', 'slurp', 'curl', 'wget', 'headless',
            'python-requests', 'python-urllib', 'go-http-client', 'java/',
            'httpclient', 'okhttp', 'axios', 'postman', 'insomnia', 'scrapy',
            'facebookexternalhit', 'twitterbot', 'whatsapp', 'telegrambot',
            'googlebot', 'bingbot', 'yandex', 'baiduspider', 'duckduckbot',
            'linkedinbot', 'pinterest', 'sogou', 'exabot', 'ahrefsbot',
            'semrushbot', 'mj12bot', 'dotbot', 'uptimerobot', 'pingdom',
            'monitor', 'lighthouse', 'gtmetrix', 'newrelic', 'datadog',
        ],
    ],

    /*
    | Admin security notifications. Events outside the critical list can be
    | disabled per administrator; critical security events are always sent.
    */
    'notifications' => [
        'default_recipients' => array_filter(array_map(
            'trim',
            explode(',', (string) env('ADMIN_NOTIFICATION_EMAILS', ''))
        )),
        'fallback_recipient' => env('ADMIN_NOTIFICATION_FALLBACK_EMAIL', 'hello@smevolve.tech'),
        'channel' => 'email',
        'events' => [
            'security.login_success' => ['label' => 'Successful login', 'description' => 'A successful administrator login.', 'critical' => false],
            'security.login_failed' => ['label' => 'Failed login', 'description' => 'A failed administrator login attempt.', 'critical' => true],
            'security.password_changed' => ['label' => 'Password changed', 'description' => 'An administrator password was changed.', 'critical' => true],
            'security.password_reset' => ['label' => 'Password reset', 'description' => 'An administrator password was reset.', 'critical' => true],
            'administrators.created' => ['label' => 'Administrator created', 'description' => 'A new administrator account was created.', 'critical' => true],
            'administrators.disabled' => ['label' => 'Administrator disabled', 'description' => 'An administrator account was disabled or reactivated.', 'critical' => true],
            'administrators.role_changed' => ['label' => 'Role changed', 'description' => 'An administrator role was changed.', 'critical' => true],
            'business.quote_requested' => ['label' => 'Quote requested', 'description' => 'A new quote request was submitted on the website.', 'critical' => false],
            'business.contact_message' => ['label' => 'Contact message', 'description' => 'A new contact message was submitted on the website.', 'critical' => false],
        ],
    ],
];
