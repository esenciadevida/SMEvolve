<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Quote Wizard Configuration
    |--------------------------------------------------------------------------
    |
    | Central, configuration-driven definition of the Quote Wizard: session
    | lifetime, option catalogs and the ordered step/question flow. Critical
    | validation is always re-enforced server-side by Laravel.
    |
    */

    'session' => [
        'expires_after_minutes' => (int) env('QUOTE_SESSION_EXPIRES_MINUTES', 4320),
        'max_steps' => 12,
    ],

    'project_types' => [
        ['key' => 'website', 'label' => 'Website'],
        ['key' => 'ecommerce_website', 'label' => 'E-commerce Website'],
        ['key' => 'web_application', 'label' => 'Web Application'],
        ['key' => 'mobile_application', 'label' => 'Mobile Application'],
        ['key' => 'custom_software', 'label' => 'Custom Software'],
        ['key' => 'ui_ux_design', 'label' => 'UI/UX Design'],
        ['key' => 'other', 'label' => 'Other'],
    ],

    'industries' => [
        ['key' => 'technology', 'label' => 'Technology'],
        ['key' => 'retail', 'label' => 'Retail'],
        ['key' => 'healthcare', 'label' => 'Healthcare'],
        ['key' => 'education', 'label' => 'Education'],
        ['key' => 'finance', 'label' => 'Finance'],
        ['key' => 'hospitality', 'label' => 'Hospitality'],
        ['key' => 'real_estate', 'label' => 'Real Estate'],
        ['key' => 'logistics', 'label' => 'Logistics'],
        ['key' => 'professional_services', 'label' => 'Professional Services'],
        ['key' => 'entertainment', 'label' => 'Entertainment'],
        ['key' => 'manufacturing', 'label' => 'Manufacturing'],
        ['key' => 'other', 'label' => 'Other'],
    ],

    'timelines' => [
        ['key' => 'as_soon_as_possible', 'label' => 'As soon as possible'],
        ['key' => 'within_1_month', 'label' => 'Within 1 month'],
        ['key' => 'one_to_three_months', 'label' => '1-3 months'],
        ['key' => 'three_to_six_months', 'label' => '3-6 months'],
        ['key' => 'more_than_6_months', 'label' => 'More than 6 months'],
        ['key' => 'not_sure', 'label' => 'I\'m not sure'],
    ],

    'budget_ranges' => [
        ['key' => 'under_250k', 'label' => 'Under ₦250,000'],
        ['key' => '250k_500k', 'label' => '₦250,000 - ₦500,000'],
        ['key' => '500k_1m', 'label' => '₦500,000 - ₦1,000,000'],
        ['key' => '1m_2_5m', 'label' => '₦1,000,000 - ₦2,500,000'],
        ['key' => 'over_2_5m', 'label' => '₦2,500,000+'],
        ['key' => 'not_sure', 'label' => 'Not sure yet'],
        ['key' => 'prefer_not_to_say', 'label' => 'Prefer not to say'],
    ],

    'existing_assets' => [
        ['key' => 'logo', 'label' => 'Logo'],
        ['key' => 'brand_guidelines', 'label' => 'Brand Guidelines'],
        ['key' => 'website', 'label' => 'Website'],
        ['key' => 'domain', 'label' => 'Domain'],
        ['key' => 'hosting', 'label' => 'Hosting'],
        ['key' => 'content', 'label' => 'Content'],
        ['key' => 'designs_mockups', 'label' => 'Designs / Mockups'],
        ['key' => 'existing_application', 'label' => 'Existing Application'],
        ['key' => 'existing_database', 'label' => 'Existing Database'],
        ['key' => 'nothing_yet', 'label' => 'Nothing yet'],
        ['key' => 'other', 'label' => 'Other'],
    ],

    'project_stages' => [
        ['key' => 'just_an_idea', 'label' => 'Just an idea'],
        ['key' => 'planning', 'label' => 'Planning'],
        ['key' => 'design_started', 'label' => 'Design started'],
        ['key' => 'development_started', 'label' => 'Development started'],
        ['key' => 'existing_product', 'label' => 'Existing product'],
        ['key' => 'redesign_upgrade', 'label' => 'Redesign / upgrade'],
        ['key' => 'migration', 'label' => 'Migration'],
    ],

    'contact_methods' => [
        ['key' => 'email', 'label' => 'Email'],
        ['key' => 'phone', 'label' => 'Phone'],
        ['key' => 'whatsapp', 'label' => 'WhatsApp'],
        ['key' => 'any', 'label' => 'Any'],
    ],

    /*
    | Requirement catalogs keyed by project type. Keys are stable identifiers
    | used across the quote_requirements catalog, wizard options and AI output.
    */
    'features' => [
        'website' => [
            ['key' => 'company_information', 'label' => 'Company Information', 'category' => 'content'],
            ['key' => 'services', 'label' => 'Services', 'category' => 'content'],
            ['key' => 'contact_forms', 'label' => 'Contact Forms', 'category' => 'user_features'],
            ['key' => 'gallery', 'label' => 'Gallery', 'category' => 'content'],
            ['key' => 'blog_articles', 'label' => 'Blog / Articles', 'category' => 'content'],
            ['key' => 'booking', 'label' => 'Booking', 'category' => 'user_features'],
            ['key' => 'online_payments', 'label' => 'Online Payments', 'category' => 'payments'],
            ['key' => 'customer_accounts', 'label' => 'Customer Accounts', 'category' => 'user_features'],
            ['key' => 'maps_location', 'label' => 'Maps / Location', 'category' => 'integrations'],
            ['key' => 'testimonials', 'label' => 'Testimonials', 'category' => 'content'],
            ['key' => 'newsletter', 'label' => 'Newsletter', 'category' => 'communication'],
            ['key' => 'social_media_integration', 'label' => 'Social Media Integration', 'category' => 'integrations'],
            ['key' => 'other', 'label' => 'Other', 'category' => 'other'],
        ],
        'ecommerce_website' => [
            ['key' => 'product_catalogue', 'label' => 'Product Catalogue', 'category' => 'business_features'],
            ['key' => 'shopping_cart', 'label' => 'Shopping Cart', 'category' => 'user_features'],
            ['key' => 'checkout', 'label' => 'Checkout', 'category' => 'payments'],
            ['key' => 'online_payments', 'label' => 'Online Payments', 'category' => 'payments'],
            ['key' => 'customer_accounts', 'label' => 'Customer Accounts', 'category' => 'user_features'],
            ['key' => 'order_management', 'label' => 'Order Management', 'category' => 'administration'],
            ['key' => 'delivery_shipping', 'label' => 'Delivery / Shipping', 'category' => 'business_features'],
            ['key' => 'discounts', 'label' => 'Discounts', 'category' => 'business_features'],
            ['key' => 'inventory_management', 'label' => 'Inventory Management', 'category' => 'administration'],
            ['key' => 'reviews', 'label' => 'Reviews', 'category' => 'content'],
            ['key' => 'wishlist', 'label' => 'Wishlist', 'category' => 'user_features'],
            ['key' => 'product_search', 'label' => 'Product Search', 'category' => 'user_features'],
            ['key' => 'other', 'label' => 'Other', 'category' => 'other'],
        ],
        'web_application' => [
            ['key' => 'user_accounts', 'label' => 'User Accounts', 'category' => 'user_features'],
            ['key' => 'admin_dashboard', 'label' => 'Admin Dashboard', 'category' => 'administration'],
            ['key' => 'payments', 'label' => 'Payments', 'category' => 'payments'],
            ['key' => 'booking', 'label' => 'Booking', 'category' => 'business_features'],
            ['key' => 'messaging', 'label' => 'Messaging', 'category' => 'communication'],
            ['key' => 'notifications', 'label' => 'Notifications', 'category' => 'communication'],
            ['key' => 'reports', 'label' => 'Reports', 'category' => 'analytics'],
            ['key' => 'file_uploads', 'label' => 'File Uploads', 'category' => 'user_features'],
            ['key' => 'search', 'label' => 'Search', 'category' => 'user_features'],
            ['key' => 'role_based_access', 'label' => 'Role-Based Access', 'category' => 'security'],
            ['key' => 'third_party_integrations', 'label' => 'Third-Party Integrations', 'category' => 'integrations'],
            ['key' => 'api_integration', 'label' => 'API Integration', 'category' => 'integrations'],
            ['key' => 'other', 'label' => 'Other', 'category' => 'other'],
        ],
        'mobile_application' => [
            ['key' => 'user_accounts', 'label' => 'User Accounts', 'category' => 'user_features'],
            ['key' => 'push_notifications', 'label' => 'Push Notifications', 'category' => 'communication'],
            ['key' => 'payments', 'label' => 'Payments', 'category' => 'payments'],
            ['key' => 'location_maps', 'label' => 'Location / Maps', 'category' => 'integrations'],
            ['key' => 'messaging', 'label' => 'Messaging', 'category' => 'communication'],
            ['key' => 'camera', 'label' => 'Camera', 'category' => 'user_features'],
            ['key' => 'file_uploads', 'label' => 'File Uploads', 'category' => 'user_features'],
            ['key' => 'social_login', 'label' => 'Social Login', 'category' => 'user_features'],
            ['key' => 'subscriptions', 'label' => 'Subscriptions', 'category' => 'payments'],
            ['key' => 'admin_dashboard', 'label' => 'Admin Dashboard', 'category' => 'administration'],
            ['key' => 'api_integration', 'label' => 'API Integration', 'category' => 'integrations'],
            ['key' => 'other', 'label' => 'Other', 'category' => 'other'],
        ],
        'custom_software' => [
            ['key' => 'user_management', 'label' => 'User Management', 'category' => 'user_features'],
            ['key' => 'admin_dashboard', 'label' => 'Admin Dashboard', 'category' => 'administration'],
            ['key' => 'reports', 'label' => 'Reports', 'category' => 'analytics'],
            ['key' => 'automation', 'label' => 'Automation', 'category' => 'business_features'],
            ['key' => 'payments', 'label' => 'Payments', 'category' => 'payments'],
            ['key' => 'inventory', 'label' => 'Inventory', 'category' => 'business_features'],
            ['key' => 'crm', 'label' => 'CRM', 'category' => 'business_features'],
            ['key' => 'staff_management', 'label' => 'Staff Management', 'category' => 'administration'],
            ['key' => 'notifications', 'label' => 'Notifications', 'category' => 'communication'],
            ['key' => 'integrations', 'label' => 'Integrations', 'category' => 'integrations'],
            ['key' => 'api', 'label' => 'API', 'category' => 'integrations'],
            ['key' => 'other', 'label' => 'Other', 'category' => 'other'],
        ],
        'ui_ux_design' => [
            ['key' => 'website_design', 'label' => 'Website Design', 'category' => 'design'],
            ['key' => 'mobile_app_design', 'label' => 'Mobile App Design', 'category' => 'design'],
            ['key' => 'web_application_design', 'label' => 'Web Application Design', 'category' => 'design'],
            ['key' => 'dashboard_design', 'label' => 'Dashboard Design', 'category' => 'design'],
            ['key' => 'design_system', 'label' => 'Design System', 'category' => 'design'],
            ['key' => 'wireframes', 'label' => 'Wireframes', 'category' => 'design'],
            ['key' => 'prototype', 'label' => 'Prototype', 'category' => 'design'],
            ['key' => 'user_research', 'label' => 'User Research', 'category' => 'research'],
            ['key' => 'usability_review', 'label' => 'Usability Review', 'category' => 'research'],
            ['key' => 'redesign', 'label' => 'Redesign', 'category' => 'design'],
            ['key' => 'other', 'label' => 'Other', 'category' => 'other'],
        ],
        'other' => [],
    ],

    /*
    | Ordered wizard steps. Each step carries a stable key, label, description
    | and the list of questions rendered on it. Conditional questions use the
    | `show_when` array (field + value) and are evaluated server-side.
    */
    'steps' => [
        [
            'key' => 'project_type',
            'label' => 'Project Type',
            'description' => 'What are you looking to build? Select the option that best matches your project.',
            'questions' => [
                [
                    'key' => 'project_type',
                    'type' => 'single_choice',
                    'label' => 'What are you looking to build?',
                    'required' => true,
                    'options_source' => 'project_types',
                ],
                [
                    'key' => 'project_type_other',
                    'type' => 'textarea',
                    'label' => 'Tell us what you have in mind.',
                    'required' => false,
                    'max' => 2000,
                    'show_when' => ['field' => 'project_type', 'value' => 'other'],
                ],
            ],
        ],
        [
            'key' => 'project_description',
            'label' => 'Project Description',
            'description' => 'Tell us about your idea, what you want the product to do, or the problem you want it to solve.',
            'questions' => [
                [
                    'key' => 'project_description',
                    'type' => 'textarea',
                    'label' => 'What would you like us to build?',
                    'required' => true,
                    'max' => 2000,
                    'placeholder' => 'Tell us about your idea, what you want the product to do, or the problem you want it to solve.',
                    'ai_enabled' => 'description',
                ],
            ],
        ],
        [
            'key' => 'business_information',
            'label' => 'Business Information',
            'description' => 'Tell us about your business so we can tailor the proposal.',
            'questions' => [
                [
                    'key' => 'business_name',
                    'type' => 'text',
                    'label' => 'What\'s your business name?',
                    'required' => false,
                    'max' => 160,
                ],
                [
                    'key' => 'industry',
                    'type' => 'single_choice',
                    'label' => 'What industry are you in?',
                    'required' => false,
                    'options_source' => 'industries',
                ],
                [
                    'key' => 'industry_other',
                    'type' => 'text',
                    'label' => 'Please specify your industry.',
                    'required' => false,
                    'max' => 120,
                    'show_when' => ['field' => 'industry', 'value' => 'other'],
                ],
                [
                    'key' => 'business_description',
                    'type' => 'textarea',
                    'label' => 'Tell us briefly about your business.',
                    'required' => false,
                    'max' => 2000,
                ],
            ],
        ],
        [
            'key' => 'project_requirements',
            'label' => 'Project Requirements',
            'description' => 'Select the features you need for your project. Your answers help us understand the scope.',
            'questions' => [
                [
                    'key' => 'required_features',
                    'type' => 'multiple_choice',
                    'label' => 'Which features do you need?',
                    'required' => false,
                    'options_source' => 'features',
                    'ai_enabled' => 'features',
                ],
                [
                    'key' => 'additional_features',
                    'type' => 'textarea',
                    'label' => 'Are there any other features you need?',
                    'required' => false,
                    'max' => 2000,
                ],
            ],
        ],
        [
            'key' => 'existing_assets',
            'label' => 'Existing Assets',
            'description' => 'Do you already have anything we can work with?',
            'questions' => [
                [
                    'key' => 'existing_assets',
                    'type' => 'multiple_choice',
                    'label' => 'Do you already have anything we can work with?',
                    'required' => false,
                    'options_source' => 'existing_assets',
                ],
                [
                    'key' => 'existing_website_url',
                    'type' => 'url',
                    'label' => 'What\'s your current website address?',
                    'required' => false,
                    'max' => 300,
                    'show_when' => ['field' => 'existing_assets', 'contains' => 'website'],
                ],
                [
                    'key' => 'existing_application_description',
                    'type' => 'textarea',
                    'label' => 'Tell us about your existing application.',
                    'required' => false,
                    'max' => 2000,
                    'show_when' => ['field' => 'existing_assets', 'contains' => 'existing_application'],
                ],
                [
                    'key' => 'project_stage',
                    'type' => 'single_choice',
                    'label' => 'What stage is the project currently at?',
                    'required' => false,
                    'options_source' => 'project_stages',
                ],
            ],
        ],
        [
            'key' => 'timeline',
            'label' => 'Timeline',
            'description' => 'When would you like to start? Timeline information is indicative only and is not a delivery commitment.',
            'questions' => [
                [
                    'key' => 'timeline',
                    'type' => 'single_choice',
                    'label' => 'When would you like to start?',
                    'required' => false,
                    'options_source' => 'timelines',
                ],
            ],
        ],
        [
            'key' => 'budget',
            'label' => 'Budget',
            'description' => 'Your budget helps us understand the scope of the project. It does not represent a final quotation.',
            'questions' => [
                [
                    'key' => 'budget_range',
                    'type' => 'single_choice',
                    'label' => 'Do you have a budget range in mind?',
                    'required' => false,
                    'options_source' => 'budget_ranges',
                ],
            ],
        ],
        [
            'key' => 'additional_information',
            'label' => 'Additional Information',
            'description' => 'Is there anything else you\'d like us to know?',
            'questions' => [
                [
                    'key' => 'additional_information',
                    'type' => 'textarea',
                    'label' => 'Is there anything else you\'d like us to know?',
                    'required' => false,
                    'max' => 3000,
                    'placeholder' => 'Special requirements, important deadlines, technical constraints, preferred integrations, reference websites...',
                ],
            ],
        ],
        [
            'key' => 'contact_information',
            'label' => 'Contact Information',
            'description' => 'How can we get in touch with you?',
            'questions' => [
                [
                    'key' => 'full_name',
                    'type' => 'text',
                    'label' => 'What\'s your name?',
                    'required' => true,
                    'max' => 160,
                ],
                [
                    'key' => 'email',
                    'type' => 'email',
                    'label' => 'What\'s your email address?',
                    'required' => true,
                    'max' => 190,
                ],
                [
                    'key' => 'phone',
                    'type' => 'phone',
                    'label' => 'What\'s your phone number?',
                    'required' => true,
                    'max' => 30,
                ],
                [
                    'key' => 'company_name',
                    'type' => 'text',
                    'label' => 'Company / Business Name',
                    'required' => false,
                    'max' => 160,
                ],
                [
                    'key' => 'preferred_contact_method',
                    'type' => 'single_choice',
                    'label' => 'How would you prefer us to contact you?',
                    'required' => false,
                    'options_source' => 'contact_methods',
                ],
            ],
        ],
    ],

    /*
    | Required fields for a submission, used by QuoteReviewService and the
    | submission service when validating that a quote is ready to submit.
    */
    'minimum_submission_fields' => [
        'project_type',
        'project_description',
        'full_name',
        'email',
        'phone',
    ],

    'consent' => [
        'documents' => [
            [
                'consent_type' => 'privacy',
                'document' => 'privacy_policy',
                'document_version' => '1.0',
                'label' => 'I agree that SMEvolve may use the information I provide to respond to my project enquiry.',
                'route' => 'privacy-policy.index',
            ],
        ],
    ],

    'references' => [
        'prefix' => env('QUOTE_REFERENCE_PREFIX', 'SME-'),
        'format' => 'Y-m',
    ],
];
