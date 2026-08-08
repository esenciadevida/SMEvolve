<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Frequently Asked Questions (Knowledge Center)
    |--------------------------------------------------------------------------
    |
    | Single source of truth for FAQ content across the site. Every FAQ
    | section (Home, Services, Packages, Contact, /faq) reads from this
    | dataset and filters by category, tag, or featured flag.
    |
    | Each item carries a `tag` used as a page-level context key so existing
    | sections can surface a curated subset (e.g. the Contact page shows
    | contact-related questions only), while `category` drives the taxonomy
    | shown on the Knowledge Center (/faq) page.
    |
    */

    'meta' => [
        'title' => 'SMEvolve FAQ | Answers About Services, Pricing & Development',
        'description' => 'Find answers about SMEvolve services, pricing, website development, custom software, AI solutions, project processes, and support options.',
    ],

    /*
    | Categories used by the FAQ Knowledge Center. `all` is the virtual
    | "All Questions" filter and is never assigned to an item.
    |
    */
    'categories' => [
        [
            'id' => 'all',
            'name' => 'All Questions',
            'icon' => 'rectangle-stack',
            'description' => 'Browse every question in the Knowledge Center.',
            'display_order' => 0,
        ],
        [
            'id' => 'general',
            'name' => 'General',
            'icon' => 'sparkles',
            'description' => 'Questions about SMEvolve and how we work together.',
            'display_order' => 1,
        ],
        [
            'id' => 'services',
            'name' => 'Services',
            'icon' => 'code-bracket-square',
            'description' => 'Questions about the digital solutions we build.',
            'display_order' => 2,
        ],
        [
            'id' => 'pricing',
            'name' => 'Pricing',
            'icon' => 'banknotes',
            'description' => 'Questions about cost, packages, and budgeting.',
            'display_order' => 3,
        ],
        [
            'id' => 'development',
            'name' => 'Development Process',
            'icon' => 'clipboard-document-list',
            'description' => 'Questions about how a project moves from first conversation to launch.',
            'display_order' => 4,
        ],
        [
            'id' => 'support',
            'name' => 'Support & Maintenance',
            'icon' => 'lifebuoy',
            'description' => 'Questions about what happens after launch.',
            'display_order' => 5,
        ],
        [
            'id' => 'technical',
            'name' => 'Technical',
            'icon' => 'cpu-chip',
            'description' => 'Questions about technologies, integrations, and security.',
            'display_order' => 6,
        ],
        [
            'id' => 'payments',
            'name' => 'Payments',
            'icon' => 'credit-card',
            'description' => 'Questions about payment methods and how billing works.',
            'display_order' => 7,
        ],
        [
            'id' => 'quote',
            'name' => 'Quote Wizard',
            'icon' => 'document-text',
            'description' => 'Questions about requesting a proposal and next steps.',
            'display_order' => 8,
        ],
        [
            'id' => 'policies',
            'name' => 'Policies',
            'icon' => 'shield-check',
            'description' => 'Questions about ownership, confidentiality, and terms.',
            'display_order' => 9,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | FAQ Items
    |--------------------------------------------------------------------------
    |
    | status: active | draft | archived
    | priority: 1 (most important) to 10 (lowest). Equal priorities sort
    | alphabetically by question.
    |
    */
    'items' => [
        // ----------------------------------------------------------- General
        [
            'id' => 'general-001',
            'tag' => 'general',
            'category' => 'general',
            'question' => 'Who is SMEvolve?',
            'answer' => 'SMEvolve is a digital solutions agency that helps small and medium businesses grow online. We design and build websites, e-commerce platforms, custom software, mobile applications, AI solutions, and automation tools, all tailored to each client\u2019s goals.',
            'tags' => ['smevolve', 'about', 'company', 'agency'],
            'priority' => 1,
            'featured' => true,
            'related_pages' => [
                ['label' => 'Explore Our Services', 'route' => 'services.index'],
                ['label' => 'View Our Work', 'route' => 'portfolio'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'general-002',
            'tag' => 'general',
            'category' => 'general',
            'question' => 'Can you help if I don\u2019t have technical knowledge?',
            'answer' => 'Absolutely. We handle the technical work while guiding you through the process in plain language. You\u2019ll receive clear recommendations, regular progress updates, and an easy handover, so you never need to worry about the underlying technology.',
            'tags' => ['non-technical', 'guidance', 'beginner', 'handover'],
            'priority' => 2,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Contact Our Team', 'route' => 'contact'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'general-003',
            'tag' => 'contact',
            'category' => 'general',
            'question' => 'Do you work with businesses outside Nigeria?',
            'answer' => 'Yes. We work with businesses across Nigeria and internationally, collaborating remotely using modern communication and project management tools. Time zones are never a barrier, we schedule calls and updates around you.',
            'tags' => ['international', 'remote', 'worldwide', 'nigeria'],
            'priority' => 3,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Contact Our Team', 'route' => 'contact'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'general-004',
            'tag' => 'contact',
            'category' => 'general',
            'question' => 'How quickly will I receive a response?',
            'answer' => 'We typically respond within one business day. For urgent enquiries, WhatsApp is usually the fastest way to reach us, during business hours we aim to reply within the hour.',
            'tags' => ['response', 'reply', 'time', 'urgent'],
            'priority' => 4,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Contact Our Team', 'route' => 'contact'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'general-005',
            'tag' => 'contact',
            'category' => 'general',
            'question' => 'Which communication method is fastest?',
            'answer' => 'WhatsApp is usually the fastest way to reach us, followed by email. All enquiry channels are monitored daily, and we respond promptly regardless of how you reach out.',
            'tags' => ['whatsapp', 'email', 'communication', 'contact'],
            'priority' => 5,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Contact Our Team', 'route' => 'contact'],
            ],
            'status' => 'active',
        ],

        // ---------------------------------------------------------- Services
        [
            'id' => 'services-001',
            'tag' => 'general',
            'category' => 'services',
            'question' => 'What services does SMEvolve provide?',
            'answer' => 'SMEvolve builds business websites, e-commerce platforms, custom software, mobile applications, AI solutions, APIs, and business automation tools tailored to your needs. We also provide ongoing support and maintenance to keep your solutions running smoothly.',
            'tags' => ['services', 'websites', 'software', 'mobile', 'ai', 'automation'],
            'priority' => 1,
            'featured' => true,
            'related_pages' => [
                ['label' => 'Explore Our Services', 'route' => 'services.index'],
                ['label' => 'View Packages', 'route' => 'packages'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'services-002',
            'tag' => 'general',
            'category' => 'services',
            'question' => 'Do you build e-commerce websites?',
            'answer' => 'Yes. We build fast, secure online stores with product catalogues, payments, order management, and inventory features. Every store is designed to convert visitors into customers and scale as your sales grow.',
            'tags' => ['e-commerce', 'online store', 'shop', 'payments'],
            'priority' => 2,
            'featured' => false,
            'related_pages' => [
                ['label' => 'View Packages', 'route' => 'packages'],
                ['label' => 'Explore Our Services', 'route' => 'services.index'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'services-003',
            'tag' => 'general',
            'category' => 'services',
            'question' => 'Do you develop mobile applications?',
            'answer' => 'Yes. We develop native and cross-platform mobile apps for iOS and Android, from business tools to customer-facing products. We handle the full journey, concept, design, build, and launch, and connect your app to your existing systems where needed.',
            'tags' => ['mobile', 'app', 'ios', 'android', 'application'],
            'priority' => 3,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Explore Our Services', 'route' => 'services.index'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'services-004',
            'tag' => 'general',
            'category' => 'services',
            'question' => 'Can you build AI solutions for my business?',
            'answer' => 'Yes. We help businesses apply AI practically, from chatbots and intelligent document processing to predictive analytics and workflow automation. We start with your goals and build solutions that deliver measurable results.',
            'tags' => ['ai', 'artificial intelligence', 'chatbot', 'automation'],
            'priority' => 4,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Explore Our Services', 'route' => 'services.index'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'services-005',
            'tag' => 'general',
            'category' => 'services',
            'question' => 'Do you provide business automation services?',
            'answer' => 'Yes. We automate repetitive business processes, such as enquiry handling, invoicing, reporting, and data entry, so your team can focus on higher-value work. Automation can cover a single step or a whole workflow, depending on your needs.',
            'tags' => ['automation', 'workflows', 'efficiency', 'productivity'],
            'priority' => 5,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Explore Our Services', 'route' => 'services.index'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'services-006',
            'tag' => 'general',
            'category' => 'services',
            'question' => 'Can you redesign an existing website or application?',
            'answer' => 'Yes. We can modernize existing websites or software by improving design, functionality, performance, and user experience, while preserving what already works and protecting your investment.',
            'tags' => ['redesign', 'revamp', 'modernise', 'existing website'],
            'priority' => 6,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Explore Our Services', 'route' => 'services.index'],
                ['label' => 'Request a Quote', 'route' => 'quote'],
            ],
            'status' => 'active',
        ],

        // ---------------------------------------------------------- Pricing
        [
            'id' => 'pricing-001',
            'tag' => 'packages',
            'category' => 'pricing',
            'question' => 'How much does a website cost?',
            'answer' => 'Website projects start from our fixed packages, which are designed to be predictable and transparent. The final cost depends on the scope, the number of pages, features, and level of customisation. Use the Quote Wizard or contact us for an exact figure for your project.',
            'tags' => ['cost', 'price', 'website cost', 'packages'],
            'priority' => 1,
            'featured' => true,
            'related_pages' => [
                ['label' => 'View Packages', 'route' => 'packages'],
                ['label' => 'Start Quote Wizard', 'route' => 'quote'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'pricing-002',
            'tag' => 'packages',
            'category' => 'pricing',
            'question' => 'Why don\u2019t all services have fixed prices?',
            'answer' => 'Standard website packages have predictable pricing because their scope is well defined. Custom software, AI, and automation projects are highly tailored, so they require a personalised quotation based on your goals and requirements.',
            'tags' => ['fixed price', 'custom', 'quotation', 'pricing'],
            'priority' => 2,
            'featured' => false,
            'related_pages' => [
                ['label' => 'View Packages', 'route' => 'packages'],
                ['label' => 'Start Quote Wizard', 'route' => 'quote'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'pricing-003',
            'tag' => 'packages',
            'category' => 'pricing',
            'question' => 'Can I customise a website package?',
            'answer' => 'Yes. Packages provide a solid starting point, but we regularly adjust scope and features to match your business. Tell us what you need and we\u2019ll refine the package or recommend a custom solution.',
            'tags' => ['customise', 'packages', 'scope', 'features'],
            'priority' => 3,
            'featured' => false,
            'related_pages' => [
                ['label' => 'View Packages', 'route' => 'packages'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'pricing-004',
            'tag' => 'packages',
            'category' => 'pricing',
            'question' => 'Which package is right for my business?',
            'answer' => 'It depends on your goals, audience, and how much you want to grow online. Complete our Quote Wizard and we\u2019ll recommend the best option based on your requirements, no obligation.',
            'tags' => ['choose package', 'recommendation', 'quote wizard'],
            'priority' => 4,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Start Quote Wizard', 'route' => 'quote'],
                ['label' => 'View Packages', 'route' => 'packages'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'pricing-005',
            'tag' => 'packages',
            'category' => 'pricing',
            'question' => 'Do your packages include hosting and domain registration?',
            'answer' => 'Hosting and domain setup can be arranged as part of your project or managed through our ongoing support plans. We\u2019ll clarify what\u2019s included in your specific proposal.',
            'tags' => ['hosting', 'domain', 'packages', 'setup'],
            'priority' => 5,
            'featured' => false,
            'related_pages' => [
                ['label' => 'View Packages', 'route' => 'packages'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'pricing-006',
            'tag' => 'packages',
            'category' => 'pricing',
            'question' => 'Can I upgrade my package later?',
            'answer' => 'Yes. Our websites are built on scalable foundations, so you can add pages, features, or move to a higher package as your business grows.',
            'tags' => ['upgrade', 'scalable', 'grow', 'packages'],
            'priority' => 6,
            'featured' => false,
            'related_pages' => [
                ['label' => 'View Packages', 'route' => 'packages'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'pricing-007',
            'tag' => 'packages',
            'category' => 'pricing',
            'question' => 'Are there any hidden costs?',
            'answer' => 'No. We provide clear, itemised proposals before work begins, so you always know what\u2019s included and what anything extra will cost. There are no surprise fees.',
            'tags' => ['hidden costs', 'transparent', 'fees', 'pricing'],
            'priority' => 7,
            'featured' => false,
            'related_pages' => [
                ['label' => 'View Packages', 'route' => 'packages'],
            ],
            'status' => 'active',
        ],

        // ------------------------------------------------- Development Process
        [
            'id' => 'development-001',
            'tag' => 'general',
            'category' => 'development',
            'question' => 'How long does a typical project take?',
            'answer' => 'Project timelines vary depending on complexity and requirements. A standard website usually takes 2\u20136 weeks, while larger custom builds take longer. After discussing your project, we\u2019ll provide a clear timeline before development begins.',
            'tags' => ['timeline', 'duration', 'how long', 'weeks'],
            'priority' => 1,
            'featured' => true,
            'related_pages' => [
                ['label' => 'Start Quote Wizard', 'route' => 'quote'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'development-002',
            'tag' => 'general',
            'category' => 'development',
            'question' => 'How does a project start?',
            'answer' => 'Every project starts with a conversation. We learn about your business and goals, recommend the right approach, and share a clear proposal covering scope, timeline, and cost. Once you approve, we plan the build and get started.',
            'tags' => ['start', 'kickoff', 'process', 'discovery'],
            'priority' => 2,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Start Quote Wizard', 'route' => 'quote'],
                ['label' => 'Contact Our Team', 'route' => 'contact'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'development-003',
            'tag' => 'general',
            'category' => 'development',
            'question' => 'What does the development process look like?',
            'answer' => 'Our process follows clear stages: discovery and planning, design, development, testing, and launch. After launch we provide support and maintenance so your solution keeps performing well.',
            'tags' => ['process', 'stages', 'workflow', 'design', 'testing'],
            'priority' => 3,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Explore Our Services', 'route' => 'services.index'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'development-004',
            'tag' => 'general',
            'category' => 'development',
            'question' => 'Will I be able to review progress during the project?',
            'answer' => 'Yes. You\u2019ll receive regular progress updates and have opportunities to review designs and builds before launch. We believe great communication starts with clear, honest updates.',
            'tags' => ['progress', 'updates', 'review', 'communication'],
            'priority' => 4,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Contact Our Team', 'route' => 'contact'],
            ],
            'status' => 'active',
        ],

        // ---------------------------------------------- Support & Maintenance
        [
            'id' => 'support-001',
            'tag' => 'general',
            'category' => 'support',
            'question' => 'Do you provide ongoing support?',
            'answer' => 'Yes. We offer maintenance, updates, and technical support to help keep your solution secure and performing well after launch. Support can be arranged as a one-off or as an ongoing plan.',
            'tags' => ['support', 'maintenance', 'updates', 'care'],
            'priority' => 1,
            'featured' => true,
            'related_pages' => [
                ['label' => 'Contact Our Team', 'route' => 'contact'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'support-002',
            'tag' => 'contact',
            'category' => 'support',
            'question' => 'What does your support plan cover?',
            'answer' => 'Our support plans cover security updates, software updates, bug fixes, backups, and technical assistance. We can also make small content and design changes to keep your solution current.',
            'tags' => ['support plan', 'security', 'updates', 'backups', 'bug fixes'],
            'priority' => 2,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Contact Our Team', 'route' => 'contact'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'support-003',
            'tag' => 'general',
            'category' => 'support',
            'question' => 'Can you update my website after launch?',
            'answer' => 'Yes. We can make content, design, and feature updates after launch, either through a support plan or as one-off requests. We\u2019ll keep your website current as your business evolves.',
            'tags' => ['updates', 'content', 'changes', 'after launch'],
            'priority' => 3,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Contact Our Team', 'route' => 'contact'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'support-004',
            'tag' => 'contact',
            'category' => 'support',
            'question' => 'What happens if something goes wrong after launch?',
            'answer' => 'We monitor the solutions we deliver and respond quickly if anything goes wrong. Support-plan clients get priority assistance, and urgent issues are addressed as fast as possible.',
            'tags' => ['issues', 'downtime', 'errors', 'emergency'],
            'priority' => 4,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Contact Our Team', 'route' => 'contact'],
            ],
            'status' => 'active',
        ],

        // --------------------------------------------------------- Technical
        [
            'id' => 'technical-001',
            'tag' => 'general',
            'category' => 'technical',
            'question' => 'What technologies do you use?',
            'answer' => 'We build on modern, proven technologies, including Laravel for web applications, JavaScript and Tailwind for interfaces, and cloud platforms for hosting and scale. We choose the right tools for each project rather than forcing a one-size-fits-all stack.',
            'tags' => ['technologies', 'stack', 'laravel', 'javascript', 'cloud'],
            'priority' => 1,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Explore Our Services', 'route' => 'services.index'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'technical-002',
            'tag' => 'general',
            'category' => 'technical',
            'question' => 'Will my website work well on mobile devices?',
            'answer' => 'Yes. Every website we build is responsive, meaning it looks and works great on phones, tablets, and desktops. We also optimise for speed, which matters on mobile connections.',
            'tags' => ['mobile', 'responsive', 'speed', 'devices'],
            'priority' => 2,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Explore Our Services', 'route' => 'services.index'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'technical-003',
            'tag' => 'general',
            'category' => 'technical',
            'question' => 'Can you integrate with tools I already use?',
            'answer' => 'Yes. We integrate websites and software with the tools you already rely on, CRMs, payment gateways, email systems, analytics, and more, so everything works together smoothly.',
            'tags' => ['integrations', 'crm', 'payment gateway', 'apis'],
            'priority' => 3,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Explore Our Services', 'route' => 'services.index'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'technical-004',
            'tag' => 'general',
            'category' => 'technical',
            'question' => 'Is my website secure?',
            'answer' => 'Security is built into everything we deliver. We follow secure coding practices, use HTTPS and proper authentication, keep software updated, and include security maintenance options to protect your business.',
            'tags' => ['security', 'secure', 'https', 'protection'],
            'priority' => 4,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Explore Our Services', 'route' => 'services.index'],
            ],
            'status' => 'active',
        ],

        // --------------------------------------------------------- Payments
        [
            'id' => 'payments-001',
            'tag' => 'packages',
            'category' => 'payments',
            'question' => 'What payment methods do you accept?',
            'answer' => 'We accept bank transfers and major digital payment methods available in your region. We\u2019ll confirm the options that work best for you when we prepare your proposal.',
            'tags' => ['payment methods', 'transfer', 'pay', 'how to pay'],
            'priority' => 1,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Contact Our Team', 'route' => 'contact'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'payments-002',
            'tag' => 'packages',
            'category' => 'payments',
            'question' => 'Do you offer payment plans?',
            'answer' => 'Yes. Many projects can be split into staged payments that align with project milestones. This lets you pay as work is delivered rather than all at once.',
            'tags' => ['payment plan', 'instalments', 'milestones', 'stages'],
            'priority' => 2,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Start Quote Wizard', 'route' => 'quote'],
                ['label' => 'View Packages', 'route' => 'packages'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'payments-003',
            'tag' => 'packages',
            'category' => 'payments',
            'question' => 'Do you require a deposit to start?',
            'answer' => 'Yes, we usually require a deposit before development begins. The deposit secures your project slot and covers initial planning, and the remaining balance is tied to agreed milestones.',
            'tags' => ['deposit', 'upfront', 'start', 'milestone'],
            'priority' => 3,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Start Quote Wizard', 'route' => 'quote'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'payments-004',
            'tag' => 'packages',
            'category' => 'payments',
            'question' => 'How is payment structured during a project?',
            'answer' => 'Payments are typically split into clear stages that match the project milestones, for example, discovery, design, development, and launch. Your proposal will spell out exactly what\u2019s due and when.',
            'tags' => ['payment structure', 'milestones', 'invoicing', 'stages'],
            'priority' => 4,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Start Quote Wizard', 'route' => 'quote'],
                ['label' => 'View Packages', 'route' => 'packages'],
            ],
            'status' => 'active',
        ],

        // ------------------------------------------------------- Quote Wizard
        [
            'id' => 'quote-001',
            'tag' => 'general',
            'category' => 'quote',
            'question' => 'How do I get started?',
            'answer' => 'Simply request a free quote or contact us to discuss your project. We\u2019ll learn about your goals, recommend the right solution, and guide you through the next steps.',
            'tags' => ['start', 'begin', 'getting started', 'quote'],
            'priority' => 1,
            'featured' => true,
            'related_pages' => [
                ['label' => 'Start Quote Wizard', 'route' => 'quote'],
                ['label' => 'Contact Our Team', 'route' => 'contact'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'quote-002',
            'tag' => 'packages',
            'category' => 'quote',
            'question' => 'What happens after I request a quote?',
            'answer' => 'We review your requirements and respond within one business day. If needed, we arrange a short consultation to clarify details, then send a clear proposal covering scope, timeline, and cost.',
            'tags' => ['after quote', 'proposal', 'next steps', 'response'],
            'priority' => 2,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Start Quote Wizard', 'route' => 'quote'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'quote-003',
            'tag' => 'contact',
            'category' => 'quote',
            'question' => 'What information should I prepare before requesting a quote?',
            'answer' => 'It helps if you can share a brief description of your project, your goals, and any timelines or budget expectations. If you\u2019re not sure yet, that\u2019s fine too, we\u2019ll guide the conversation.',
            'tags' => ['prepare', 'information', 'requirements', 'budget'],
            'priority' => 3,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Start Quote Wizard', 'route' => 'quote'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'quote-004',
            'tag' => 'general',
            'category' => 'quote',
            'question' => 'Is requesting a quote free and non-binding?',
            'answer' => 'Yes. Requesting a quote is completely free and comes with no obligation. We\u2019re happy to discuss your project and share honest recommendations before you decide anything.',
            'tags' => ['free', 'non-binding', 'no obligation', 'quote'],
            'priority' => 4,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Start Quote Wizard', 'route' => 'quote'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'quote-005',
            'tag' => 'contact',
            'category' => 'quote',
            'question' => 'How quickly will I receive a quote?',
            'answer' => 'We aim to send quotes within one business day of receiving your requirements. Complex projects may take a little longer while we confirm details with you.',
            'tags' => ['quote time', 'how long', 'fast', 'response'],
            'priority' => 5,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Start Quote Wizard', 'route' => 'quote'],
            ],
            'status' => 'active',
        ],

        // --------------------------------------------------------- Policies
        [
            'id' => 'policies-001',
            'tag' => 'general',
            'category' => 'policies',
            'question' => 'Do I own my website and content after launch?',
            'answer' => 'Yes. Once your project is complete and final payment is made, you own your website, content, and code. We can also hand over documentation and accounts so you\u2019re fully in control.',
            'tags' => ['ownership', 'content', 'code', 'handover'],
            'priority' => 1,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Read Our Terms', 'route' => 'terms.index'],
            ],
            'status' => 'active',
        ],
        [
            'id' => 'policies-002',
            'tag' => 'general',
            'category' => 'policies',
            'question' => 'Do you sign non-disclosure agreements (NDAs)?',
            'answer' => 'Yes. We\u2019re happy to sign an NDA before we discuss sensitive project details. We treat your business information with the same care we give our own.',
            'tags' => ['nda', 'confidentiality', 'privacy', 'agreement'],
            'priority' => 2,
            'featured' => false,
            'related_pages' => [
                ['label' => 'Read Our Privacy Policy', 'route' => 'privacy-policy.index'],
                ['label' => 'Read Our Terms', 'route' => 'terms.index'],
            ],
            'status' => 'active',
        ],
    ],
];
