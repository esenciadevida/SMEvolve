<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Content Management Configuration
    |--------------------------------------------------------------------------
    |
    | Registry of admin-manageable content types. Each entry describes the
    | admin interface for that type. Content is stored in the `content_items`
    | table; the public site reads it through App\Services\Content\ContentService,
    | falling back to the original code/config source when the database has not
    | been populated yet (so existing behaviour and tests are preserved).
    |
    | Field reference:
    |   text     -> single-line input (column)
    |   textarea -> multiline input (column)
    |   checkbox -> boolean toggle (data)
    |   select   -> dropdown (column / data)
    |   number   -> numeric input (data)
    |   tags     -> comma-separated list -> array (data)
    |
    */

    'types' => [
        'service' => [
            'label' => 'Services',
            'singular' => 'Service',
            'description' => 'Digital services shown on the Services page and homepage.',
            'fields' => [
                'slug' => ['label' => 'Slug', 'type' => 'text', 'rules' => ['required', 'string', 'max:150', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/']],
                'title' => ['label' => 'Name', 'type' => 'text', 'rules' => ['required', 'string', 'max:100']],
                'description' => ['label' => 'Description', 'type' => 'textarea', 'rules' => ['required', 'string', 'max:1000']],
                'icon' => ['label' => 'Icon', 'type' => 'text', 'rules' => ['nullable', 'string', 'max:50'], 'hint' => 'Icon name from the icon set, e.g. globe-alt.'],
                'homepage' => ['label' => 'Show on homepage', 'type' => 'checkbox', 'data' => true],
            ],
        ],
        'industry' => [
            'label' => 'Industries',
            'singular' => 'Industry',
            'description' => 'Industry cards shown on the homepage.',
            'fields' => [
                'slug' => ['label' => 'Slug', 'type' => 'text', 'rules' => ['nullable', 'string', 'max:150', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/']],
                'title' => ['label' => 'Title', 'type' => 'text', 'rules' => ['required', 'string', 'max:100']],
                'description' => ['label' => 'Description', 'type' => 'textarea', 'rules' => ['required', 'string', 'max:1000']],
                'icon' => ['label' => 'Icon', 'type' => 'text', 'rules' => ['nullable', 'string', 'max:50']],
                'url' => ['label' => 'URL', 'type' => 'text', 'data' => true, 'rules' => ['nullable', 'string', 'max:300']],
                'solutions' => ['label' => 'Solutions', 'type' => 'tags', 'data' => true, 'rules' => ['nullable', 'array']],
            ],
        ],
        'benefit' => [
            'label' => 'Benefits',
            'singular' => 'Benefit',
            'description' => "Benefit cards in the 'Why Choose Us' section.",
            'fields' => [
                'slug' => ['label' => 'Slug', 'type' => 'text', 'rules' => ['nullable', 'string', 'max:150', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/']],
                'title' => ['label' => 'Title', 'type' => 'text', 'rules' => ['required', 'string', 'max:100']],
                'description' => ['label' => 'Description', 'type' => 'textarea', 'rules' => ['required', 'string', 'max:1000']],
                'icon' => ['label' => 'Icon', 'type' => 'text', 'rules' => ['nullable', 'string', 'max:50']],
            ],
        ],
        'value' => [
            'label' => 'Values',
            'singular' => 'Value',
            'description' => 'Company values shown on the About page.',
            'fields' => [
                'slug' => ['label' => 'Slug', 'type' => 'text', 'rules' => ['nullable', 'string', 'max:150', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/']],
                'title' => ['label' => 'Title', 'type' => 'text', 'rules' => ['required', 'string', 'max:100']],
                'description' => ['label' => 'Description', 'type' => 'textarea', 'rules' => ['required', 'string', 'max:1000']],
                'icon' => ['label' => 'Icon', 'type' => 'text', 'rules' => ['nullable', 'string', 'max:50']],
            ],
        ],
        'faq' => [
            'label' => 'FAQs',
            'singular' => 'FAQ',
            'description' => 'Questions shown in the FAQ Knowledge Center and across the site.',
            'fields' => [
                'slug' => ['label' => 'ID', 'type' => 'text', 'rules' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'], 'hint' => 'Unique identifier used for links and search, e.g. general-001.'],
                'title' => ['label' => 'Question', 'type' => 'textarea', 'rules' => ['required', 'string', 'max:500']],
                'description' => ['label' => 'Answer', 'type' => 'textarea', 'rules' => ['required', 'string', 'max:2000']],
                'category' => ['label' => 'Category', 'type' => 'select', 'data' => true, 'options' => 'faq.categories', 'rules' => ['required', 'string']],
                'tag' => ['label' => 'Tag', 'type' => 'select', 'data' => true, 'options' => ['general' => 'General', 'contact' => 'Contact', 'packages' => 'Packages'], 'rules' => ['required', 'string']],
                'priority' => ['label' => 'Priority', 'type' => 'number', 'data' => true, 'rules' => ['required', 'integer', 'min:1', 'max:10']],
                'featured' => ['label' => 'Featured', 'type' => 'checkbox', 'data' => true],
                'status' => ['label' => 'Status', 'type' => 'select', 'data' => true, 'options' => ['active' => 'Active', 'draft' => 'Draft', 'archived' => 'Archived'], 'rules' => ['required', 'in:active,draft,archived']],
                'tags' => ['label' => 'Tags', 'type' => 'tags', 'data' => true, 'rules' => ['nullable', 'array']],
            ],
        ],
        'package' => [
            'label' => 'Packages',
            'singular' => 'Package',
            'description' => 'Website packages shown on the Packages page.',
            'fields' => [
                'slug' => ['label' => 'Slug', 'type' => 'text', 'rules' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/']],
                'title' => ['label' => 'Name', 'type' => 'text', 'rules' => ['required', 'string', 'max:100']],
                'description' => ['label' => 'Description', 'type' => 'textarea', 'rules' => ['required', 'string', 'max:1000']],
                'features' => ['label' => 'Features', 'type' => 'tags', 'data' => true, 'rules' => ['nullable', 'array']],
                'audience' => ['label' => 'Target Audience', 'type' => 'tags', 'data' => true, 'rules' => ['nullable', 'array']],
                'badge' => ['label' => 'Badge', 'type' => 'text', 'data' => true, 'rules' => ['nullable', 'string', 'max:50']],
            ],
        ],
    ],
];
