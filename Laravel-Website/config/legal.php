<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Legal Documents
    |--------------------------------------------------------------------------
    |
    | Single source of truth for every legal page on the website. Each document
    | is rendered through one shared page template and the reusable components
    | under components/legal/, only the content here differs between pages.
    |
    | Future documents (Refund Policy, AI Policy, Data Processing Agreement,
    | Subscription Terms, Client Agreement) can be added by extending the
    | `documents` array, defining a route, and registering footer links.
    |
    | Content is rendered as escaped text only. Never place raw HTML in this
    | configuration; future CMS-driven content should be sanitised before it
    | reaches the view layer.
    |
    */

    'documents' => [

        /*
        |--------------------------------------------------------------------------
        | Privacy Policy
        |--------------------------------------------------------------------------
        */

        'privacy-policy' => [
            'key' => 'privacy-policy',
            'route' => 'privacy-policy.index',
            'title' => 'Privacy Policy',
            'version' => '1.0',
            'effective_date' => '2025-01-01',
            'updated_date' => '2026-08-07',
            'status' => 'active',

            'meta' => [
                'title' => 'Privacy Policy | SMEvolve',
                'description' => 'Learn how SMEvolve collects, uses, and protects personal information through our website and services.',
            ],

            'hero' => [
                'description' => 'Learn how SMEvolve collects, uses, and protects the information you share with us.',
            ],

            'cta' => [
                'label' => 'QUESTIONS ABOUT YOUR PRIVACY?',
                'heading' => 'Questions About Your Privacy?',
                'description' => "If you have questions about how we handle your information, or you'd like to exercise your privacy rights, our team is here to help.",
                'primary' => ['label' => 'Contact SMEvolve', 'route' => 'contact'],
                'secondary' => ['label' => 'Start Quote Wizard', 'route' => 'quote'],
                'trust' => [
                    'Your data stays confidential',
                    'Clear, plain-language policies',
                    'No-obligation conversation',
                ],
                'trust_note' => 'We treat every enquiry with care and respect for your privacy.',
            ],

            'sections' => [
                [
                    'id' => 'introduction',
                    'heading' => 'Introduction',
                    'paragraphs' => [
                        'SMEvolve respects your privacy and is committed to protecting the personal information you share with us. This Privacy Policy explains what information we collect, why we collect it, how we use it, and the choices you have.',
                        'Please read this policy carefully. By using the SMEvolve website and contacting us, you agree to the practices described here. If you do not agree with any part of this policy, you may choose not to use our services.',
                    ],
                ],
                [
                    'id' => 'information-we-collect',
                    'heading' => 'Information We Collect',
                    'body' => 'We collect information in two main ways: information you provide directly, and information collected automatically when you visit our website.',
                    'subsections' => [
                        [
                            'heading' => 'Information Provided Directly',
                            'body' => 'When you contact us or use our website, you may provide information such as:',
                            'bullets' => [
                                'Your name',
                                'Email address',
                                'Phone number',
                                'Company information',
                                'Project details submitted through our forms',
                            ],
                        ],
                        [
                            'heading' => 'Automatically Collected Information',
                            'body' => 'When you visit our website, certain technical information may be collected automatically, including:',
                            'bullets' => [
                                'Browser information',
                                'Device information',
                                'IP address',
                                'Website usage data',
                                'Cookies and similar technologies',
                            ],
                        ],
                    ],
                ],
                [
                    'id' => 'how-we-use-information',
                    'heading' => 'How We Use Information',
                    'body' => 'Information we collect may be used for the following purposes:',
                    'bullets' => [
                        'Responding to enquiries',
                        'Preparing project proposals and quotations',
                        'Improving our services',
                        'Communicating with users about their projects',
                        'Website analytics and performance monitoring',
                        'Security monitoring and abuse prevention',
                    ],
                ],
                [
                    'id' => 'quote-wizard-data',
                    'heading' => 'Quote Wizard Data',
                    'body' => 'Information submitted through the Quote Wizard may include:',
                    'bullets' => [
                        'Business details',
                        'Project requirements',
                        'Budget information',
                        'Timeline expectations',
                    ],
                    'paragraphs' => [
                        'This information is used to prepare suitable recommendations and proposals for your project. We treat quote submissions as business enquiries and only use the details to understand your needs.',
                    ],
                ],
                [
                    'id' => 'contact-form-data',
                    'heading' => 'Contact Form Data',
                    'body' => 'Information submitted through our contact forms is used only for:',
                    'bullets' => [
                        'Responding to your enquiry',
                        'Providing the information you requested',
                        'Continuing business discussions you have initiated',
                    ],
                ],
                [
                    'id' => 'cookies-and-tracking',
                    'heading' => 'Cookies & Tracking',
                    'paragraphs' => [
                        'SMEvolve may use cookies and similar technologies for website functionality, analytics, performance improvements, and user experience enhancements.',
                        'You can learn more about how we use cookies, what categories of cookies we use, and how to manage them in our Cookie Policy.',
                    ],
                    'links' => [
                        ['label' => 'Read the Cookie Policy', 'route' => 'cookies.index'],
                    ],
                ],
                [
                    'id' => 'third-party-services',
                    'heading' => 'Third-Party Services',
                    'body' => 'We may use third-party providers to support our website and business operations. Potential services include:',
                    'bullets' => [
                        'Analytics platforms',
                        'Email providers',
                        'Hosting providers',
                        'Payment providers (future)',
                    ],
                    'paragraphs' => [
                        'Third-party providers process information according to their own privacy policies and are responsible for their handling of your data.',
                    ],
                ],
                [
                    'id' => 'data-protection',
                    'heading' => 'Data Protection',
                    'body' => 'We apply reasonable technical and organisational measures to protect your information, including:',
                    'bullets' => [
                        'Secure hosting',
                        'Access control',
                        'Input validation',
                        'Secure communication',
                        'Regular maintenance',
                    ],
                    'paragraphs' => [
                        'No method of transmission or storage is completely secure. While we work to protect your information, we cannot guarantee absolute security.',
                    ],
                ],
                [
                    'id' => 'user-rights',
                    'heading' => 'User Rights',
                    'body' => 'Depending on your location and applicable law, you may have the right to:',
                    'bullets' => [
                        'Request information about the data we hold about you',
                        'Request corrections to inaccurate information',
                        'Request deletion of your information where applicable',
                        'Withdraw communication preferences at any time',
                    ],
                ],
                [
                    'id' => 'data-retention',
                    'heading' => 'Data Retention',
                    'body' => 'We retain information only for as long as necessary for:',
                    'bullets' => [
                        'Business communication',
                        'Legal obligations',
                        'Service delivery',
                    ],
                    'paragraphs' => [
                        'When information is no longer needed, we take reasonable steps to delete or anonymise it.',
                    ],
                ],
                [
                    'id' => 'childrens-privacy',
                    'heading' => "Children's Privacy",
                    'paragraphs' => [
                        'SMEvolve services are intended for businesses and users capable of entering professional agreements. We do not knowingly collect personal information from children.',
                    ],
                ],
                [
                    'id' => 'policy-updates',
                    'heading' => 'Policy Updates',
                    'paragraphs' => [
                        'This Privacy Policy may change as our services evolve. When we update this policy, we will revise the "Last Updated" date shown at the top of this page.',
                        'We encourage you to review this page periodically to stay informed about how we protect your information.',
                    ],
                ],
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Terms & Conditions
        |--------------------------------------------------------------------------
        */

        'terms' => [
            'key' => 'terms',
            'route' => 'terms.index',
            'title' => 'Terms & Conditions',
            'version' => '1.0',
            'effective_date' => '2025-01-01',
            'updated_date' => '2026-08-07',
            'status' => 'active',

            'meta' => [
                'title' => 'Terms & Conditions | SMEvolve',
                'description' => 'Read the terms and conditions that guide the use of SMEvolve services and website.',
            ],

            'hero' => [
                'description' => 'Understand the terms that guide your use of SMEvolve services and website.',
            ],

            'cta' => [
                'label' => 'READY TO WORK WITH SMEVOLVE?',
                'heading' => 'Ready To Work With SMEvolve?',
                'description' => "We'd love to learn about your project and show you how we can help. Request a free, no-obligation quote today.",
                'primary' => ['label' => 'Request A Quote', 'route' => 'quote'],
                'secondary' => ['label' => 'Contact Our Team', 'route' => 'contact'],
                'trust' => [
                    'Free initial consultation',
                    'Clear project agreements',
                    'Transparent pricing',
                ],
                'trust_note' => 'No pressure. No obligation. Just a conversation about your project.',
            ],

            'sections' => [
                [
                    'id' => 'introduction',
                    'heading' => 'Introduction',
                    'paragraphs' => [
                        'These Terms & Conditions govern your use of the SMEvolve website and your engagement with our services. By using this website or requesting our services, you agree to be bound by these terms.',
                        'Please read these terms carefully before using the website or entering into any agreement with SMEvolve.',
                    ],
                ],
                [
                    'id' => 'website-usage',
                    'heading' => 'Website Usage',
                    'body' => 'When using the SMEvolve website, you agree to:',
                    'bullets' => [
                        'Use the website lawfully and in accordance with these terms',
                        'Avoid activities that could harm the website or other users',
                        'Not attempt to gain unauthorised access to the website or its systems',
                        'Not misuse website content or copy it for commercial purposes without permission',
                    ],
                ],
                [
                    'id' => 'services',
                    'heading' => 'Services',
                    'body' => 'SMEvolve provides technology solutions including:',
                    'bullets' => [
                        'Website Development',
                        'Software Development',
                        'AI Solutions',
                        'Automation',
                        'Digital Services',
                    ],
                    'paragraphs' => [
                        'All services are delivered subject to the requirements agreed for each individual project.',
                    ],
                ],
                [
                    'id' => 'quotations',
                    'heading' => 'Quotations',
                    'body' => 'Quotations provided by SMEvolve:',
                    'bullets' => [
                        'Are based on the project information you provide',
                        'May change if project requirements change',
                        'Are valid for a defined period stated in the quotation',
                    ],
                ],
                [
                    'id' => 'project-agreements',
                    'heading' => 'Project Agreements',
                    'body' => 'Before starting any project, we recommend that the following are confirmed and agreed in writing:',
                    'bullets' => [
                        'Project scope',
                        'Deliverables',
                        'Timelines',
                        'Payment terms',
                    ],
                    'paragraphs' => [
                        'A formal project agreement will outline the specific responsibilities of both SMEvolve and the client.',
                    ],
                ],
                [
                    'id' => 'payments',
                    'heading' => 'Payments',
                    'body' => 'Payment terms may include any of the following, depending on the project agreement:',
                    'bullets' => [
                        'Deposits',
                        'Milestone payments',
                        'Final payments',
                    ],
                    'paragraphs' => [
                        'The specific payment schedule for your project is defined in the agreed project agreement.',
                    ],
                ],
                [
                    'id' => 'project-delivery',
                    'heading' => 'Project Delivery',
                    'body' => 'SMEvolve aims to:',
                    'bullets' => [
                        'Deliver the agreed work',
                        'Communicate progress clearly',
                        'Maintain quality standards',
                    ],
                    'paragraphs' => [
                        'Project timelines may change due to requirement changes, client delays, or external dependencies. We will communicate any changes to the agreed timeline as early as possible.',
                    ],
                ],
                [
                    'id' => 'client-responsibilities',
                    'heading' => 'Client Responsibilities',
                    'body' => 'To ensure successful project delivery, clients are expected to provide:',
                    'bullets' => [
                        'Accurate information',
                        'Required content and materials',
                        'Timely feedback',
                        'Necessary approvals',
                    ],
                ],
                [
                    'id' => 'intellectual-property',
                    'heading' => 'Intellectual Property',
                    'paragraphs' => [
                        'Ownership of completed project work transfers according to the terms of the project agreement, subject to payment completion and any applicable third-party licences.',
                        'SMEvolve retains the rights to reusable frameworks, tools, development methods, and internal systems used in the delivery of projects.',
                    ],
                ],
                [
                    'id' => 'third-party-services',
                    'heading' => 'Third-Party Services',
                    'body' => 'Projects may rely on third-party services such as:',
                    'bullets' => [
                        'Hosting providers',
                        'Payment providers',
                        'APIs',
                        'External software',
                    ],
                    'paragraphs' => [
                        'Third-party services are governed by their own terms and conditions, for which SMEvolve is not responsible.',
                    ],
                ],
                [
                    'id' => 'website-content',
                    'heading' => 'Website Content',
                    'body' => 'The information on this website may include service descriptions, pricing information, and technical information. SMEvolve may update website content without notice.',
                ],
                [
                    'id' => 'limitation-of-liability',
                    'heading' => 'Limitation of Liability',
                    'body' => 'SMEvolve provides services professionally but cannot guarantee:',
                    'bullets' => [
                        'Continuous website availability',
                        'Third-party platform performance',
                        'External service availability',
                    ],
                    'paragraphs' => [
                        'To the maximum extent permitted by law, SMEvolve shall not be liable for indirect, incidental, or consequential damages arising from use of the website or our services.',
                    ],
                ],
                [
                    'id' => 'policy-updates',
                    'heading' => 'Policy Updates',
                    'paragraphs' => [
                        'These terms may change as our services evolve, as business requirements change, or as legal requirements change. When we update these terms, we will revise the "Last Updated" date shown at the top of this page.',
                    ],
                ],
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Cookie Policy
        |--------------------------------------------------------------------------
        */

        'cookies' => [
            'key' => 'cookies',
            'route' => 'cookies.index',
            'title' => 'Cookie Policy',
            'version' => '1.0',
            'effective_date' => '2025-01-01',
            'updated_date' => '2026-08-07',
            'status' => 'active',

            'meta' => [
                'title' => 'Cookie Policy | SMEvolve',
                'description' => 'Learn how SMEvolve uses cookies and similar technologies to improve website functionality and user experience.',
            ],

            'hero' => [
                'description' => 'Learn how SMEvolve uses cookies and similar technologies to improve your experience.',
            ],

            'cta' => [
                'label' => 'HAVE QUESTIONS ABOUT YOUR PRIVACY?',
                'heading' => 'Have Questions About Your Privacy?',
                'description' => "If you'd like to know more about how we use cookies and your data, our team is happy to help.",
                'primary' => ['label' => 'Contact SMEvolve', 'route' => 'contact'],
                'secondary' => ['label' => 'Read Privacy Policy', 'route' => 'privacy-policy.index'],
                'trust' => [
                    'Transparent tracking practices',
                    'Your data stays confidential',
                    'Quick answers from our team',
                ],
                'trust_note' => 'We keep our privacy practices clear and easy to understand.',
            ],

            'sections' => [
                [
                    'id' => 'introduction',
                    'heading' => 'Introduction',
                    'paragraphs' => [
                        'SMEvolve uses cookies and similar technologies to improve website functionality, understand how visitors use our website, and enhance the user experience.',
                        'This Cookie Policy explains what cookies are, how we use them, and how you can manage your preferences.',
                    ],
                ],
                [
                    'id' => 'what-are-cookies',
                    'heading' => 'What Are Cookies?',
                    'paragraphs' => [
                        'Cookies are small text files stored on your device when you visit a website. They help websites remember information about your visit, such as your preferences and usage patterns.',
                    ],
                ],
                [
                    'id' => 'why-we-use-cookies',
                    'heading' => 'Why We Use Cookies',
                    'body' => 'Cookies may help us with:',
                    'bullets' => [
                        'Website functionality',
                        'Security',
                        'Performance',
                        'Analytics',
                        'User experience improvement',
                    ],
                ],
                [
                    'id' => 'types-of-cookies',
                    'heading' => 'Types of Cookies',
                    'body' => 'We organise the cookies we use into the following categories.',
                    'subsections' => [
                        [
                            'heading' => 'Essential Cookies',
                            'body' => 'These cookies are required for the website to operate. They support session management, security features, and form functionality. Essential cookies cannot usually be disabled.',
                        ],
                        [
                            'heading' => 'Performance Cookies',
                            'body' => 'These cookies help us understand how visitors use the website, including analytics and page performance monitoring.',
                        ],
                        [
                            'heading' => 'Functional Cookies',
                            'body' => 'These cookies remember user preferences, such as theme preference and language preference.',
                        ],
                        [
                            'heading' => 'Marketing Cookies',
                            'body' => 'These cookies are reserved for future use. They would be used to measure campaigns and improve marketing, including advertising analytics and conversion tracking.',
                        ],
                    ],
                ],
                [
                    'id' => 'third-party-cookies',
                    'heading' => 'Third-Party Cookies',
                    'paragraphs' => [
                        'Third-party services may place cookies depending on the integrations used on the website. Examples include analytics providers, embedded content, and payment services.',
                        'These third-party providers place cookies and process data according to their own policies. We encourage you to review the policies of any third-party services you use.',
                    ],
                ],
                [
                    'id' => 'cookie-management',
                    'heading' => 'Cookie Management',
                    'body' => 'You can manage cookies through your browser by:',
                    'bullets' => [
                        'Adjusting browser settings',
                        'Disabling cookies',
                        'Clearing existing cookies',
                    ],
                    'paragraphs' => [
                        'Please note that disabling essential cookies may affect how the website functions.',
                    ],
                ],
                [
                    'id' => 'cookie-duration',
                    'heading' => 'Cookie Duration',
                    'body' => 'Cookies may be either of the following types depending on their purpose.',
                    'subsections' => [
                        [
                            'heading' => 'Session Cookies',
                            'body' => 'Session cookies are deleted after you close your browser.',
                        ],
                        [
                            'heading' => 'Persistent Cookies',
                            'body' => 'Persistent cookies remain on your device until they expire or until you delete them manually.',
                        ],
                    ],
                ],
                [
                    'id' => 'future-cookie-consent',
                    'heading' => 'Future Cookie Consent System',
                    'paragraphs' => [
                        'Our architecture is designed to support a future cookie consent system, including a cookie banner, preference management, consent logging, and category controls.',
                        'When this system is introduced, this page will be updated to explain how to manage your consent preferences directly on the website.',
                    ],
                ],
                [
                    'id' => 'policy-updates',
                    'heading' => 'Policy Updates',
                    'paragraphs' => [
                        'This Cookie Policy may change as we introduce new analytics platforms, marketing tools, or tracking technologies. When we update this policy, we will revise the "Last Updated" date shown at the top of this page.',
                    ],
                ],
            ],
        ],
    ],
];
