<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Packages Configuration
    |--------------------------------------------------------------------------
    |
    | Single source of truth for the Packages page. Business data (packages,
    | pricing philosophy, comparison matrix, custom solutions, and FAQ
    | wiring) lives here so page layout and components stay reusable.
    |
    */

    'meta' => [
        'title' => 'SMEvolve Packages | Website & Custom Software Solutions',
        'description' => "Explore SMEvolve's website packages and custom software solutions. Compare our services, understand our pricing approach, and request a tailored quote for your project.",
        'og_title' => 'SMEvolve Packages',
        'og_description' => 'Explore website packages and tailored software solutions built for growing businesses.',
    ],

    'hero' => [
        'eyebrow' => 'PACKAGES & PRICING',
        'heading' => 'Flexible Packages for Every Stage of Your Business',
        'description' => 'From professional websites to fully customised software and AI-powered business solutions, SMEvolve offers flexible packages and tailored services designed to help your business grow. Explore our options and let us recommend the best fit for your goals.',
        'primary' => ['label' => 'Request a Free Quote', 'route' => 'quote'],
        'secondary' => ['label' => 'Compare Packages', 'href' => '#compare'],
        'trust' => [
            'Transparent Pricing',
            'Tailored Solutions',
            'Free Consultation',
            'No Hidden Costs',
        ],
        'notice' => 'Some services have transparent package pricing, while larger software, AI, and automation projects receive a personalised quotation based on your requirements.',
    ],

    'philosophy' => [
        'label' => 'OUR PRICING APPROACH',
        'heading' => 'Transparent Pricing. Tailored Solutions.',
        'description' => "Every business is unique, and every project has different requirements. That's why SMEvolve offers both standard packages for common projects and customised quotations for solutions requiring deeper planning, integration, or advanced functionality.",
        'models' => [
            'standard' => [
                'title' => 'Standard Packages',
                'icon' => 'shopping-bag',
                'description' => 'Predictable scope and pricing for common website projects.',
                'suitable_for' => ['Business Websites', 'Portfolio Websites', 'Landing Pages', 'Starter Solutions'],
                'characteristics' => ['Fixed scope', 'Predictable pricing', 'Faster delivery', 'Ideal for small businesses'],
            ],
            'custom' => [
                'title' => 'Custom Solutions',
                'icon' => 'wrench',
                'description' => 'Tailored quotations for projects that need deeper planning.',
                'suitable_for' => ['Business Systems', 'Enterprise Platforms', 'AI Solutions', 'Business Automation', 'Mobile Applications', 'API Integrations'],
                'characteristics' => ['Custom scope', 'Tailored quotation', 'Flexible architecture', 'Scalable implementation'],
            ],
        ],
        'factors' => [
            'heading' => 'Factors That Influence Pricing',
            'description' => 'Every project is priced on its own requirements. The most common factors that shape a quotation include:',
            'items' => [
                'Project scope',
                'Number of pages',
                'Required features',
                'Integrations',
                'User roles',
                'Design complexity',
                'Timeline',
                'Third-party services',
                'Maintenance requirements',
            ],
        ],
        'why_quote' => [
            'heading' => 'Why Some Projects Require a Quote',
            'description' => 'Large software projects are highly customised and cannot be accurately priced without understanding your goals, business processes, and technical requirements. A tailored proposal ensures accurate pricing and realistic delivery expectations.',
        ],
        'recommendation' => [
            'title' => 'Not sure which option is right for you?',
            'description' => "Complete our Quote Wizard and we'll recommend the best solution based on your requirements.",
            'cta' => ['label' => 'Start Quote Wizard', 'route' => 'quote'],
        ],
        'trust' => [
            'Transparent communication',
            'No hidden fees',
            'Scalable solutions',
            'Tailored recommendations',
        ],
    ],

    'website_packages' => [
        'label' => 'WEBSITE PACKAGES',
        'heading' => 'Professional Websites Built for Business Growth',
        'description' => 'Choose from our professionally designed website packages or request a customised solution tailored to your unique business requirements.',
        'cta' => ['label' => 'Request Quote', 'route' => 'quote'],
        'items' => [
            [
                'slug' => 'starter',
                'name' => 'Starter Website',
                'description' => 'A professional single-page presence to establish your brand online quickly and affordably.',
                'target_audience' => ['Individuals', 'Freelancers', 'Personal Brands'],
                'features' => ['Responsive Design', 'Contact Form', 'Basic SEO', 'SSL Support', 'Google Maps', 'Social Links'],
                'starting_price' => null,
                'badge' => null,
                'cta' => ['label' => 'Request Quote', 'route' => 'quote'],
            ],
            [
                'slug' => 'business',
                'name' => 'Business Website',
                'description' => 'A multi-page website with the features growing businesses need to attract and convert customers.',
                'target_audience' => ['SMEs', 'Growing Businesses', 'Professional Services'],
                'features' => ['Additional Pages', 'Blog Ready', 'Enhanced SEO', 'Testimonials', 'Gallery', 'Analytics Integration'],
                'starting_price' => null,
                'badge' => 'Most Popular',
                'cta' => ['label' => 'Request Quote', 'route' => 'quote'],
            ],
            [
                'slug' => 'professional',
                'name' => 'Professional Website',
                'description' => 'A feature-rich corporate website that presents your services, team, and expertise with confidence.',
                'target_audience' => ['Established Companies', 'Organisations', 'Multi-service Businesses'],
                'features' => ['Advanced UI/UX', 'Service Catalogue', 'Team Profiles', 'FAQ', 'Advanced Contact Options', 'Performance Optimisation'],
                'starting_price' => null,
                'badge' => null,
                'cta' => ['label' => 'Request Quote', 'route' => 'quote'],
            ],
            [
                'slug' => 'ecommerce',
                'name' => 'E-Commerce Website',
                'description' => 'A secure online store designed to sell products, manage inventory, and grow revenue.',
                'target_audience' => ['Online Stores', 'Retail Businesses', 'Product-based Companies'],
                'features' => ['Product Catalogue', 'Shopping Cart', 'Checkout', 'Payment Gateway Integration', 'Inventory Support', 'Order Management'],
                'starting_price' => null,
                'badge' => null,
                'cta' => ['label' => 'Request Quote', 'route' => 'quote'],
            ],
        ],
        'recommended' => 'business',
    ],

    'custom_solutions' => [
        'label' => 'CUSTOM SOLUTIONS',
        'heading' => 'Need Something Built Specifically for Your Business?',
        'description' => "Some projects are too unique for standard packages. If your business requires custom software, AI integration, business automation, or enterprise platforms, we'll work with you to understand your requirements and prepare a tailored proposal.",
        'services' => [
            [
                'slug' => 'custom-software-development',
                'name' => 'Custom Software Development',
                'icon' => 'rectangle-stack',
                'description' => 'Business systems and applications designed around your exact operational workflows.',
                'examples' => ['Business Management Systems', 'Internal Dashboards', 'ERP Solutions', 'CRM Platforms'],
            ],
            [
                'slug' => 'ai-solutions',
                'name' => 'AI Solutions',
                'icon' => 'cpu-chip',
                'description' => 'Intelligent tools that improve productivity, automate work, and enhance customer experiences.',
                'examples' => ['AI Chatbots', 'Workflow Automation', 'AI Assistants', 'Document Processing', 'Intelligent Search'],
            ],
            [
                'slug' => 'business-automation',
                'name' => 'Business Automation',
                'icon' => 'bolt',
                'description' => 'Automation that saves time and removes repetitive manual work from your daily operations.',
                'examples' => ['Workflow Automation', 'Approval Systems', 'Data Processing', 'Reporting Dashboards'],
            ],
            [
                'slug' => 'mobile-applications',
                'name' => 'Mobile Applications',
                'icon' => 'device-mobile',
                'description' => 'Native and cross-platform apps that engage customers and support business operations.',
                'examples' => ['Android Applications', 'iOS Applications', 'Cross-platform Apps', 'Customer Portals'],
            ],
            [
                'slug' => 'api-development-integration',
                'name' => 'API Development & Integration',
                'icon' => 'code',
                'description' => 'Custom APIs and integrations that connect your systems and enable reliable data exchange.',
                'examples' => ['Payment Gateways', 'Third-party APIs', 'Internal Integrations', 'Cloud Services'],
            ],
            [
                'slug' => 'enterprise-platforms',
                'name' => 'Enterprise Platforms',
                'icon' => 'server',
                'description' => 'Multi-user platforms built to serve teams, customers, and partners at scale.',
                'examples' => ['Multi-user Systems', 'Client Portals', 'Learning Platforms', 'Membership Systems'],
            ],
        ],
        'cta' => ['label' => 'Request Custom Quote', 'route' => 'quote'],
        'discovery' => [
            'heading' => 'A Simple, Structured Discovery Process',
            'description' => 'Every custom project begins the same way, with understanding your business. This structured process prepares you for the Quote Wizard.',
            'steps' => [
                ['step' => 1, 'title' => 'Discovery Call', 'description' => 'We discuss your goals, challenges, and initial requirements.', 'icon' => 'chat-bubble-left-right'],
                ['step' => 2, 'title' => 'Requirement Analysis', 'description' => 'We explore your business processes, integrations, and technical needs in detail.', 'icon' => 'clipboard-document-list'],
                ['step' => 3, 'title' => 'Proposal & Estimate', 'description' => 'You receive a clear proposal covering scope, timeline, and cost.', 'icon' => 'document-text'],
                ['step' => 4, 'title' => 'Project Kickoff', 'description' => 'We start with a structured plan and keep you informed throughout delivery.', 'icon' => 'rocket-launch'],
            ],
        ],
        'panel' => 'Every custom project begins with understanding your business objectives before recommending technology or estimating cost.',
        'primary' => ['label' => 'Start Quote Wizard', 'route' => 'quote'],
        'secondary' => ['label' => 'Talk to an Expert', 'route' => 'contact'],
        'trust' => [
            'Tailored Recommendations',
            'Transparent Scope',
            'Scalable Architecture',
            'Future-Proof Solutions',
        ],
    ],

    'comparison' => [
        'label' => 'COMPARE PACKAGES',
        'heading' => 'Find the Package That Fits Your Business',
        'description' => 'Compare our standard website packages side by side. If your requirements go beyond these options, our team can prepare a customised solution.',
        'cta' => ['label' => 'Request Quote', 'route' => 'quote'],
        'feature_rows' => [
            ['label' => 'Ideal For', 'values' => ['starter' => 'Individuals & freelancers', 'business' => 'SMEs & growing businesses', 'professional' => 'Established companies', 'ecommerce' => 'Online stores & retailers']],
            ['label' => 'Number of Pages', 'values' => ['starter' => 'Up to 5', 'business' => 'Up to 10', 'professional' => '15+', 'ecommerce' => '15+']],
            ['label' => 'Responsive Design', 'values' => ['starter' => true, 'business' => true, 'professional' => true, 'ecommerce' => true]],
            ['label' => 'Contact Forms', 'values' => ['starter' => true, 'business' => true, 'professional' => true, 'ecommerce' => true]],
            ['label' => 'Basic SEO', 'values' => ['starter' => true, 'business' => true, 'professional' => true, 'ecommerce' => true]],
            ['label' => 'Advanced SEO', 'values' => ['starter' => false, 'business' => true, 'professional' => true, 'ecommerce' => false]],
            ['label' => 'Blog Ready', 'values' => ['starter' => false, 'business' => true, 'professional' => true, 'ecommerce' => 'optional']],
            ['label' => 'Image Gallery', 'values' => ['starter' => false, 'business' => true, 'professional' => true, 'ecommerce' => true]],
            ['label' => 'Testimonials', 'values' => ['starter' => false, 'business' => true, 'professional' => true, 'ecommerce' => true]],
            ['label' => 'Team Profiles', 'values' => ['starter' => false, 'business' => false, 'professional' => true, 'ecommerce' => 'optional']],
            ['label' => 'Analytics Integration', 'values' => ['starter' => false, 'business' => true, 'professional' => true, 'ecommerce' => true]],
            ['label' => 'CMS', 'values' => ['starter' => 'Basic', 'business' => 'Basic', 'professional' => 'Advanced', 'ecommerce' => 'Advanced']],
            ['label' => 'E-Commerce Features', 'values' => ['starter' => false, 'business' => false, 'professional' => false, 'ecommerce' => true]],
            ['label' => 'Payment Gateway Support', 'values' => ['starter' => false, 'business' => false, 'professional' => false, 'ecommerce' => true]],
            ['label' => 'Performance Optimisation', 'values' => ['starter' => false, 'business' => false, 'professional' => true, 'ecommerce' => true]],
            ['label' => 'Security Best Practices', 'values' => ['starter' => true, 'business' => true, 'professional' => true, 'ecommerce' => true]],
            ['label' => 'Technical Support', 'values' => ['starter' => 'Standard', 'business' => 'Standard', 'professional' => 'Priority', 'ecommerce' => 'Priority']],
            ['label' => 'Maintenance Options', 'values' => ['starter' => 'optional', 'business' => 'optional', 'professional' => true, 'ecommerce' => true]],
            ['label' => 'Starting Price', 'values' => ['starter' => 'Custom Quote', 'business' => 'Custom Quote', 'professional' => 'Custom Quote', 'ecommerce' => 'Custom Quote']],
        ],
    ],

    'faqs' => [
        'label' => 'PRICING QUESTIONS',
        'heading' => 'Frequently Asked Questions About Our Packages',
        'description' => "We've answered the questions we hear most often about our packages and pricing. If you need additional guidance, our team is happy to help.",
        'intro' => 'Quick answers about how our packages work, what to expect, and how pricing is determined.',
        'tag' => 'packages',
        'take' => 6,
        'view_all' => ['label' => 'View All FAQs', 'route' => 'faq'],
        'contact' => ['label' => 'Still Have Questions?', 'route' => 'contact'],
    ],
];
