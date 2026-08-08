<?php

namespace App\Data;

use Illuminate\Support\Collection;

class ServicesData
{
    /**
     * Full service catalog with rich page content keyed by slug.
     *
     * @return array<string, array<string, mixed>>
     */
    public function all(): array
    {
        return [
            'website-development' => $this->websiteDevelopment(),
            'ecommerce-development' => $this->ecommerceDevelopment(),
            'custom-software' => $this->customSoftware(),
            'laravel-development' => $this->laravelDevelopment(),
            'wordpress-development' => $this->wordpressDevelopment(),
            'mobile-app-development' => $this->mobileAppDevelopment(),
            'ai-solutions' => $this->aiSolutions(),
            'business-automation' => $this->businessAutomation(),
            'api-development' => $this->apiDevelopment(),
            'website-maintenance' => $this->websiteMaintenance(),
        ];
    }

    /**
     * Return the rich content for a single service, or null.
     *
     * @return array<string, mixed>|null
     */
    public function find(string $slug): ?array
    {
        return $this->all()[$slug] ?? null;
    }

    /**
     * Catalog entries (slug, name, icon, homepage, description) merged with rich content.
     *
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    public function catalog(): Collection
    {
        $content = $this->all();

        return collect(app(\App\Services\Content\ContentService::class)->services())
            ->map(fn (array $service) => array_merge($service, $content[$service['slug']] ?? []));
    }

    /**
     * Related services for a given slug, resolved to catalog entries.
     *
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    public function related(string $slug): Collection
    {
        $catalog = $this->catalog()->keyBy('slug');

        return collect($this->find($slug)['related'] ?? [])
            ->map(fn (string $related) => $catalog->get($related))
            ->filter()
            ->values();
    }

    /**
     * @return array<string, mixed>
     */
    private function websiteDevelopment(): array
    {
        return [
            'meta' => [
                'title' => 'Website Development Services',
                'description' => 'Professional website development for growing businesses. Fast, responsive, and SEO-friendly websites built around your business goals.',
            ],
            'hero' => [
                'heading' => 'Professional Website Development for Growing Businesses',
                'supporting' => 'Build a fast, responsive, and professionally designed website that strengthens your brand, attracts customers, and supports your business goals.',
                'primaryCta' => ['label' => 'Get a Free Quote', 'href' => 'quote'],
                'secondaryCta' => ['label' => 'View Our Portfolio', 'href' => 'portfolio'],
                'trust' => ['Custom Design', 'Mobile Responsive', 'SEO-Friendly', 'Built to Grow'],
            ],
            'overview' => [
                'heading' => 'A Website That Works as Hard as Your Business',
                'description' => 'Website Development focuses on designing and building professional, responsive, secure, and high-performing websites that help businesses establish credibility, attract customers, and support long-term growth.',
                'paragraphs' => [
                    'Your website is often the first impression customers have of your business. A slow, outdated, or confusing site can turn visitors away before they ever learn what you offer.',
                    "We build every website around your business objectives rather than relying on generic templates. The result is a digital presence that looks professional, loads quickly, and makes it easy for customers to find you and take action.",
                ],
                'points' => [
                    'A tailored design that reflects your brand and industry.',
                    'Responsive layouts that work on every device.',
                    'Content that is easy to manage and update.',
                    'Structure that supports long-term growth and search visibility.',
                ],
            ],
            'problems' => [
                'heading' => 'Problems We Solve',
                'description' => 'Many businesses lose customers online without knowing exactly why. We solve the common website challenges that hold businesses back.',
                'items' => [
                    ['title' => 'No Online Presence', 'description' => 'Without a professional website, customers cannot find you or verify your credibility online.'],
                    ['title' => 'Outdated Website Design', 'description' => 'An old design makes your business look out of touch and reduces trust with modern buyers.'],
                    ['title' => 'Slow Website Performance', 'description' => 'Slow loading pages frustrate visitors, increase bounce rates, and hurt search rankings.'],
                    ['title' => 'Poor Mobile Experience', 'description' => 'A site that works poorly on phones loses the majority of visitors who browse on mobile.'],
                    ['title' => 'Low Search Visibility', 'description' => 'Without SEO-friendly structure, your website rarely appears when customers search for your services.'],
                    ['title' => 'Difficult Website Management', 'description' => 'When you cannot update your own content, your site quickly becomes outdated and inconsistent.'],
                    ['title' => 'Weak Lead Generation', 'description' => 'A website without clear calls to action and contact points fails to turn visitors into enquiries.'],
                    ['title' => 'Poor User Experience', 'description' => 'Confusing navigation and cluttered layouts drive visitors away before they understand your value.'],
                ],
            ],
            'solution' => [
                'heading' => 'Our Solution',
                'description' => 'SMEvolve delivers websites that are custom designed, mobile responsive, SEO-friendly, secure, fast, and easy to manage, focused on outcomes rather than technical complexity.',
                'points' => [
                    'Custom design tailored to your brand and customers.',
                    'Fast, secure, and reliable performance on every device.',
                    'SEO-ready structure that supports search visibility.',
                    'Easy content management so your site stays current.',
                    'Scalable foundation that grows alongside your business.',
                ],
            ],
            'features' => [
                'heading' => 'Key Features',
                'description' => 'Every website we build includes the features your business needs to look professional and perform.',
                'items' => [
                    ['icon' => 'device-desktop', 'title' => 'Responsive Design', 'description' => 'A layout that adapts perfectly to desktops, tablets, and mobile phones.'],
                    ['icon' => 'swatch', 'title' => 'Modern UI/UX', 'description' => 'Clean, intuitive interfaces designed around how your customers browse.'],
                    ['icon' => 'magnifying-glass', 'title' => 'SEO-Ready Structure', 'description' => 'Technical foundations that help search engines understand and rank your content.'],
                    ['icon' => 'chat-bubble-left-right', 'title' => 'Contact Forms', 'description' => 'Simple, reliable forms that make it easy for customers to reach you.'],
                    ['icon' => 'clipboard-document-list', 'title' => 'Blog Functionality', 'description' => 'Publish articles and updates to support content marketing and engagement.'],
                    ['icon' => 'rectangle-stack', 'title' => 'CMS Integration', 'description' => 'Manage your content without technical knowledge, where applicable.'],
                    ['icon' => 'bolt', 'title' => 'Performance Optimization', 'description' => 'Fast loading times that keep visitors engaged and searching well.'],
                    ['icon' => 'shield-check', 'title' => 'Security Best Practices', 'description' => 'Secure configuration and updates that protect your website and customers.'],
                    ['icon' => 'target', 'title' => 'Analytics Integration', 'description' => 'Track visitor behaviour so you understand what works and what to improve.'],
                    ['icon' => 'globe-alt', 'title' => 'Cross-Browser Compatibility', 'description' => 'Consistent experience across all major browsers and devices.'],
                ],
            ],
            'benefits' => [
                'heading' => 'Business Benefits',
                'description' => 'A professionally built website creates measurable value beyond just looking good.',
                'items' => [
                    ['icon' => 'building-library', 'title' => 'Increased Credibility', 'description' => 'A polished website makes your business appear established and trustworthy.'],
                    ['icon' => 'heart', 'title' => 'Better Customer Experience', 'description' => 'Easy navigation and fast pages keep visitors engaged and satisfied.'],
                    ['icon' => 'magnifying-glass', 'title' => 'Higher Search Visibility', 'description' => 'SEO-friendly structure helps customers find your business online.'],
                    ['icon' => 'briefcase', 'title' => 'Improved Lead Generation', 'description' => 'Clear calls to action convert visitors into enquiries and sales.'],
                    ['icon' => 'clipboard-document-list', 'title' => 'Easier Content Management', 'description' => 'Update your website yourself, quickly and without technical help.'],
                    ['icon' => 'rocket-launch', 'title' => 'Greater Business Growth', 'description' => 'A website that supports your goals helps you reach more customers over time.'],
                    ['icon' => 'arrow-right', 'title' => 'Long-Term Flexibility', 'description' => 'A scalable foundation makes it easy to add features as you grow.'],
                ],
            ],
            'technologies' => [
                'heading' => 'Technologies We Use',
                'description' => 'We select the right technology for each project so your website is fast, secure, and easy to maintain.',
                'items' => ['Laravel', 'WordPress', 'PHP', 'Tailwind CSS', 'Alpine.js', 'MySQL', 'HTML5', 'CSS3', 'JavaScript'],
            ],
            'faqs' => [
                ['question' => 'How long does website development take?', 'answer' => "Timelines vary depending on the size and complexity of the project. After discussing your requirements, we'll provide a clear timeline before development begins."],
                ['question' => 'Will the website work on mobile devices?', 'answer' => 'Yes. Every website we build is fully responsive and tested across mobile phones, tablets, and desktops.'],
                ['question' => 'Can I update the content myself?', 'answer' => 'Yes. Where a CMS is part of your solution, you can manage text, images, and pages yourself without technical assistance.'],
                ['question' => 'Is SEO included?', 'answer' => 'We build with SEO best practices in mind, including clean structure, fast performance, and descriptive content. Ongoing SEO campaigns can be discussed separately if needed.'],
                ['question' => 'Can my website grow as my business grows?', 'answer' => 'Yes. Our websites are built on scalable foundations, so new pages, features, and integrations can be added as your business evolves.'],
                ['question' => 'Do you provide maintenance?', 'answer' => 'Yes. We offer ongoing maintenance plans covering updates, security, backups, and technical support to keep your website reliable.'],
            ],
            'related' => ['website-maintenance', 'wordpress-development', 'laravel-development', 'api-development'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function ecommerceDevelopment(): array
    {
        return [
            'meta' => [
                'title' => 'E-commerce Development Services',
                'description' => 'Custom e-commerce solutions that help you sell online. Secure, scalable online stores with a great shopping experience.',
            ],
            'hero' => [
                'heading' => 'Custom E-commerce Solutions That Help You Sell Online',
                'supporting' => 'Launch a secure, scalable, and easy-to-manage online store designed to provide an excellent shopping experience and support long-term business growth.',
                'primaryCta' => ['label' => 'Get a Free Quote', 'href' => 'quote'],
                'secondaryCta' => ['label' => 'View Our Portfolio', 'href' => 'portfolio'],
                'trust' => ['Secure Checkout', 'Mobile Responsive', 'Easy to Manage', 'Built to Scale'],
            ],
            'overview' => [
                'heading' => 'An Online Store Built for Your Business Model',
                'description' => 'SMEvolve designs and develops secure, scalable, and user-friendly e-commerce platforms that help businesses sell products and services online.',
                'paragraphs' => [
                    'Every online store is tailored to the client\u2019s business model, operational workflow, and future growth plans.',
                    'From product catalogues to checkout and order management, we build e-commerce platforms that make selling online simple for you and your customers.',
                ],
                'points' => [
                    'A store experience tailored to your products and customers.',
                    'Simple product, order, and inventory management.',
                    'Secure payments and smooth checkout flows.',
                    'A platform that scales as your sales grow.',
                ],
            ],
            'problems' => [
                'heading' => 'Problems We Solve',
                'description' => 'Selling online comes with real operational challenges. We solve the issues that hold e-commerce businesses back.',
                'items' => [
                    ['title' => 'No Online Sales Platform', 'description' => 'Without an online store, you miss customers who prefer to buy outside business hours.'],
                    ['title' => 'Poor Customer Shopping Experience', 'description' => 'Confusing layouts and slow pages drive customers away before checkout.'],
                    ['title' => 'Complicated Checkout Processes', 'description' => 'A difficult checkout increases abandoned carts and loses sales.'],
                    ['title' => 'Inventory Management Difficulties', 'description' => 'Manual stock tracking leads to overselling, errors, and wasted time.'],
                    ['title' => 'Slow Website Performance', 'description' => 'Slow pages frustrate shoppers and damage conversion and search rankings.'],
                    ['title' => 'Low Conversion Rates', 'description' => 'Without a conversion-focused design, visitors browse but never buy.'],
                    ['title' => 'Limited Payment Options', 'description' => 'Few payment methods exclude customers and reduce completed orders.'],
                    ['title' => 'Difficulty Managing Orders', 'description' => 'Scattered order handling creates errors and slows down fulfilment.'],
                ],
            ],
            'solution' => [
                'heading' => 'Our Solution',
                'description' => 'SMEvolve develops e-commerce platforms that are secure, mobile responsive, fast, easy to manage, SEO-friendly, scalable, and optimized for conversions.',
                'points' => [
                    'A shopping experience focused on converting visitors into customers.',
                    'Secure payment integration with the options your customers expect.',
                    'Simple product, order, and inventory management tools.',
                    'Mobile-first design that works perfectly on phones.',
                    'A scalable architecture that grows with your sales.',
                ],
            ],
            'features' => [
                'heading' => 'Key Features',
                'description' => 'The features your store needs to run smoothly and sell consistently.',
                'items' => [
                    ['icon' => 'rectangle-stack', 'title' => 'Product Catalogue Management', 'description' => 'Organize products, categories, pricing, and descriptions with ease.'],
                    ['icon' => 'shopping-cart', 'title' => 'Shopping Cart', 'description' => 'A smooth cart experience that keeps customers moving toward checkout.'],
                    ['icon' => 'shield-check', 'title' => 'Secure Checkout', 'description' => 'A reliable, secure checkout process that builds customer confidence.'],
                    ['icon' => 'credit-card', 'title' => 'Online Payment Integration', 'description' => 'Connect the payment gateways your customers expect and trust.'],
                    ['icon' => 'clipboard-document-list', 'title' => 'Order Management', 'description' => 'Track, process, and fulfil orders from one clear dashboard.'],
                    ['icon' => 'user-group', 'title' => 'Customer Accounts', 'description' => 'Let customers save details, track orders, and manage their profile.'],
                    ['icon' => 'database', 'title' => 'Inventory Management', 'description' => 'Keep stock levels accurate and avoid overselling or stockouts.'],
                    ['icon' => 'ticket', 'title' => 'Discount & Coupon Support', 'description' => 'Run promotions and discounts that encourage purchases.'],
                    ['icon' => 'truck', 'title' => 'Shipping Configuration', 'description' => 'Set shipping rules, rates, and methods that fit your business.'],
                    ['icon' => 'envelope', 'title' => 'Email Notifications', 'description' => 'Keep customers informed about orders, shipping, and promotions.'],
                    ['icon' => 'magnifying-glass', 'title' => 'Search & Filtering', 'description' => 'Help customers find products quickly with search and filters.'],
                    ['icon' => 'star', 'title' => 'Product Reviews', 'description' => 'Collect feedback that builds trust and supports buying decisions, where applicable.'],
                ],
            ],
            'benefits' => [
                'heading' => 'Business Benefits',
                'description' => 'A well-built online store delivers results across your whole business.',
                'items' => [
                    ['icon' => 'trending-up', 'title' => 'Increased Online Sales', 'description' => 'A conversion-focused store turns more visitors into paying customers.'],
                    ['icon' => 'heart', 'title' => 'Better Customer Experience', 'description' => 'Fast, easy shopping keeps customers satisfied and coming back.'],
                    ['icon' => 'clipboard-document-list', 'title' => 'Improved Order Management', 'description' => 'Centralized order handling saves time and reduces errors.'],
                    ['icon' => 'arrow-right', 'title' => 'Business Scalability', 'description' => 'Add products, channels, and features as your business grows.'],
                    ['icon' => 'bolt', 'title' => 'Greater Operational Efficiency', 'description' => 'Automated workflows reduce manual effort across your store.'],
                    ['icon' => 'globe-alt', 'title' => 'Stronger Online Presence', 'description' => 'Sell to customers beyond your physical location, around the clock.'],
                    ['icon' => 'user-group', 'title' => 'Higher Customer Retention', 'description' => 'Accounts, orders, and communication keep customers engaged long term.'],
                ],
            ],
            'technologies' => [
                'heading' => 'Technologies We Use',
                'description' => 'We build your store on technology that is reliable, secure, and easy to manage.',
                'items' => ['Laravel', 'WordPress (WooCommerce)', 'MySQL', 'Tailwind CSS', 'Alpine.js', 'PHP', 'JavaScript', 'Payment Gateway APIs'],
            ],
            'faqs' => [
                ['question' => 'Can I sell both physical and digital products?', 'answer' => 'Yes. We can configure your store to handle physical products, digital downloads, and services depending on your business model.'],
                ['question' => 'Which payment gateways can be integrated?', 'answer' => 'We integrate with reputable payment gateways suited to your market. We can discuss the right options for your customers during planning.'],
                ['question' => 'Can I manage products myself?', 'answer' => 'Yes. You will be able to add and update products, pricing, stock, and promotions through a clear admin interface.'],
                ['question' => 'Will the store work on mobile devices?', 'answer' => 'Yes. Your store is fully responsive and tested across mobile phones, tablets, and desktops.'],
                ['question' => 'Can additional features be added later?', 'answer' => 'Yes. Our stores are built on scalable foundations, so new features and integrations can be added as your business evolves.'],
                ['question' => 'Do you provide ongoing maintenance?', 'answer' => 'Yes. We offer maintenance plans that cover updates, security, performance, and technical support for your store.'],
            ],
            'related' => ['website-development', 'api-development', 'business-automation', 'website-maintenance'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function customSoftware(): array
    {
        return [
            'meta' => [
                'title' => 'Custom Software Development Services',
                'description' => 'Custom software built around your business. Secure, scalable applications designed around your workflows and long-term goals.',
            ],
            'hero' => [
                'heading' => 'Custom Software Built Around Your Business',
                'supporting' => 'Every business operates differently. We build secure, scalable, and reliable software tailored to your workflows, helping you improve efficiency, reduce manual work, and support future growth.',
                'primaryCta' => ['label' => 'Get a Free Quote', 'href' => 'quote'],
                'secondaryCta' => ['label' => 'Book a Consultation', 'href' => 'contact'],
                'trust' => ['Built for Your Workflows', 'Secure & Scalable', 'Tailored Functionality', 'Long-Term Support'],
            ],
            'overview' => [
                'heading' => 'Software That Fits How Your Business Actually Works',
                'description' => 'SMEvolve develops custom software solutions designed around each client\u2019s unique business processes, operational requirements, and long-term objectives.',
                'paragraphs' => [
                    'Unlike off-the-shelf software, every solution is built to solve specific business challenges, improve efficiency, and scale as the business grows.',
                    'We start by understanding your operations, then design software that fits your team, your data, and your way of working.',
                ],
                'points' => [
                    'A solution built around your specific processes.',
                    'Systems that connect your existing tools and data.',
                    'Software designed to grow with your business.',
                    'Clear ownership and full control over your solution.',
                ],
            ],
            'problems' => [
                'heading' => 'Problems We Solve',
                'description' => 'Off-the-shelf software often does not match how businesses really operate. We solve the challenges that hold operations back.',
                'items' => [
                    ['title' => 'Using Multiple Disconnected Systems', 'description' => 'Juggling separate tools creates duplicate work, errors, and lost information.'],
                    ['title' => 'Manual Business Processes', 'description' => 'Repetitive manual work consumes time your team could spend on higher-value tasks.'],
                    ['title' => 'Spreadsheet Dependency', 'description' => 'Spreadsheets become unmanageable and error-prone as your data grows.'],
                    ['title' => 'Repetitive Administrative Work', 'description' => 'Routine administrative tasks slow down operations and frustrate staff.'],
                    ['title' => 'Limited Reporting & Insights', 'description' => 'Without proper reporting, you make decisions without a clear picture of your business.'],
                    ['title' => 'Poor Scalability', 'description' => 'Manual and disconnected systems cannot keep up as your business grows.'],
                    ['title' => 'Software That Doesn\u2019t Match Workflows', 'description' => 'Generic software forces your team to adapt to the tool instead of the tool working for you.'],
                    ['title' => 'Difficulty Integrating Systems', 'description' => 'Systems that cannot share data make operations slower and less accurate.'],
                ],
            ],
            'solution' => [
                'heading' => 'Our Solution',
                'description' => 'SMEvolve works closely with clients to understand their operations before designing software that fits their business.',
                'points' => [
                    'Requirement discovery before any code is written.',
                    'Process analysis to target the right problems.',
                    'Scalable architecture that supports future growth.',
                    'Secure development and user-friendly interfaces.',
                    'Software designed for long-term maintainability.',
                ],
            ],
            'features' => [
                'heading' => 'Key Features',
                'description' => 'Custom software can include the functionality your business actually needs, nothing more, nothing missing.',
                'items' => [
                    ['icon' => 'chart-bar', 'title' => 'Custom Dashboards', 'description' => 'A clear view of the data that matters to your business.'],
                    ['icon' => 'user-group', 'title' => 'Role-Based User Management', 'description' => 'Control who can access what across your team.'],
                    ['icon' => 'bolt', 'title' => 'Workflow Automation', 'description' => 'Automate repetitive steps so work moves faster.'],
                    ['icon' => 'chart-pie', 'title' => 'Reporting & Analytics', 'description' => 'Understand performance with reports built around your metrics.'],
                    ['icon' => 'bell', 'title' => 'Notifications', 'description' => 'Keep the right people informed at the right time.'],
                    ['icon' => 'code', 'title' => 'API Integrations', 'description' => 'Connect your software to the other tools you use.'],
                    ['icon' => 'cloud', 'title' => 'Cloud Deployment', 'description' => 'Secure, accessible systems available when you need them.'],
                    ['icon' => 'shield-check', 'title' => 'Secure Authentication', 'description' => 'Protect your data and control access with strong security.'],
                    ['icon' => 'clipboard-document-list', 'title' => 'Audit Logs', 'description' => 'Track activity for accountability and compliance.'],
                    ['icon' => 'database', 'title' => 'Data Management', 'description' => 'Store, organise, and manage your business data reliably.'],
                    ['icon' => 'rectangle-stack', 'title' => 'Multi-User Support', 'description' => 'Teams can collaborate within one connected system.'],
                ],
            ],
            'benefits' => [
                'heading' => 'Business Benefits',
                'description' => 'Custom software creates value you can see in how your team works every day.',
                'items' => [
                    ['icon' => 'bolt', 'title' => 'Increased Productivity', 'description' => 'Teams spend less time on manual work and more time on results.'],
                    ['icon' => 'banknotes', 'title' => 'Reduced Operational Costs', 'description' => 'Efficient processes reduce waste, errors, and duplicated effort.'],
                    ['icon' => 'chart-pie', 'title' => 'Better Decision-Making', 'description' => 'Accurate data and reports support confident decisions.'],
                    ['icon' => 'shield-check', 'title' => 'Fewer Manual Errors', 'description' => 'Automation and validation reduce costly mistakes.'],
                    ['icon' => 'user-group', 'title' => 'Improved Collaboration', 'description' => 'One shared system keeps teams aligned and informed.'],
                    ['icon' => 'arrow-right', 'title' => 'Easier Business Scaling', 'description' => 'Systems grow with you instead of holding you back.'],
                    ['icon' => 'eye', 'title' => 'Greater Operational Visibility', 'description' => 'See what is happening across your business at a glance.'],
                ],
            ],
            'technologies' => [
                'heading' => 'Technologies We Use',
                'description' => 'We use proven, modern technologies to build software that is secure, scalable, and maintainable.',
                'items' => ['Laravel', 'PHP', 'MySQL', 'Tailwind CSS', 'Alpine.js', 'REST APIs', 'JavaScript', 'Cloud Infrastructure'],
            ],
            'faqs' => [
                ['question' => 'What types of software do you build?', 'answer' => 'We build business applications, management systems, internal tools, portals, and other custom software tailored to specific operational needs.'],
                ['question' => 'Can existing systems be integrated?', 'answer' => 'Yes. Custom software can connect with your existing systems through APIs and integrations where supported.'],
                ['question' => 'Will the software grow with my business?', 'answer' => 'Yes. We design with scalability in mind, so your software can handle more users, data, and features over time.'],
                ['question' => 'Who owns the software after development?', 'answer' => 'Your business owns the software and its source code once the project is completed and delivered.'],
                ['question' => 'Can new features be added later?', 'answer' => 'Yes. We build on maintainable foundations, making it straightforward to add features as your needs evolve.'],
                ['question' => 'Do you provide maintenance and support?', 'answer' => 'Yes. We offer maintenance and support plans covering updates, improvements, and technical assistance.'],
            ],
            'related' => ['business-automation', 'api-development', 'laravel-development', 'ai-solutions'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function laravelDevelopment(): array
    {
        return [
            'meta' => [
                'title' => 'Laravel Development Services',
                'description' => 'Professional Laravel development. Secure, scalable, and maintainable web applications built with the Laravel framework.',
            ],
            'hero' => [
                'heading' => 'Professional Laravel Development Services',
                'supporting' => 'Build powerful, secure, and scalable web applications with Laravel. From custom business systems to enterprise platforms, SMEvolve delivers solutions designed for performance, flexibility, and long-term success.',
                'primaryCta' => ['label' => 'Get a Free Quote', 'href' => 'quote'],
                'secondaryCta' => ['label' => 'Book a Consultation', 'href' => 'contact'],
                'trust' => ['Secure by Design', 'Scalable Architecture', 'Clean Code', 'Long-Term Maintainable'],
            ],
            'overview' => [
                'heading' => 'Reliable Web Applications on a Modern Framework',
                'description' => 'SMEvolve develops secure, scalable, and maintainable web applications using the Laravel framework.',
                'paragraphs' => [
                    'Whether building a new application, improving an existing platform, or modernizing legacy software, Laravel provides a strong foundation for reliable business solutions.',
                    'Laravel is one of the most widely used PHP frameworks, offering a mature ecosystem for authentication, APIs, queues, notifications, and more.',
                ],
                'points' => [
                    'Applications built on a proven, modern framework.',
                    'Secure authentication and role-based access control.',
                    'Scalable architecture that supports growth.',
                    'Maintainable code that is easy to extend.',
                ],
            ],
            'problems' => [
                'heading' => 'Problems We Solve',
                'description' => 'Legacy or poorly built applications create real business risk. We solve the issues that slow businesses down.',
                'items' => [
                    ['title' => 'Outdated PHP Applications', 'description' => 'Old codebases become difficult to maintain and hard to extend safely.'],
                    ['title' => 'Poor Application Performance', 'description' => 'Slow applications frustrate users and reduce productivity.'],
                    ['title' => 'Security Concerns', 'description' => 'Vulnerable applications put business data and reputation at risk.'],
                    ['title' => 'Difficult System Maintenance', 'description' => 'Messy code makes every change slow, risky, and expensive.'],
                    ['title' => 'Lack of Scalability', 'description' => 'Systems that cannot handle growth become a bottleneck for your business.'],
                    ['title' => 'Legacy Software Limitations', 'description' => 'Outdated platforms cannot support modern features or integrations.'],
                    ['title' => 'Poor Code Quality', 'description' => 'Low-quality code leads to bugs, technical debt, and costly fixes.'],
                    ['title' => 'Integration Challenges', 'description' => 'Systems that cannot connect with other tools limit your operations.'],
                ],
            ],
            'solution' => [
                'heading' => 'Our Solution',
                'description' => 'SMEvolve develops Laravel applications using modern development practices focused on reliability, security, and maintainability.',
                'points' => [
                    'Clean architecture that is easy to understand and extend.',
                    'Secure authentication and authorization by default.',
                    'Scalable application design that grows with demand.',
                    'Performance optimization at every layer.',
                    'API integration for connecting with other systems.',
                ],
            ],
            'features' => [
                'heading' => 'Key Features',
                'description' => 'Laravel applications can include a wide range of reliable, modern functionality.',
                'items' => [
                    ['icon' => 'rectangle-stack', 'title' => 'Custom Laravel Applications', 'description' => 'Tailored web applications built around your business needs.'],
                    ['icon' => 'code', 'title' => 'RESTful API Development', 'description' => 'Well-structured APIs that connect your systems and applications.'],
                    ['icon' => 'shield-check', 'title' => 'Authentication & Authorization', 'description' => 'Secure access control for users, roles, and permissions.'],
                    ['icon' => 'chart-bar', 'title' => 'Admin Dashboards', 'description' => 'Clear management interfaces for your team.'],
                    ['icon' => 'database', 'title' => 'Database Design', 'description' => 'Well-designed data structures that are efficient and reliable.'],
                    ['icon' => 'cpu-chip', 'title' => 'Queue Processing', 'description' => 'Handle background tasks smoothly without slowing the app.'],
                    ['icon' => 'bell', 'title' => 'Notifications', 'description' => 'Keep users informed through email and in-app notifications.'],
                    ['icon' => 'credit-card', 'title' => 'Payment Integrations', 'description' => 'Connect payment gateways securely where needed.'],
                    ['icon' => 'globe-alt', 'title' => 'Third-Party API Integrations', 'description' => 'Integrate the external services your business depends on.'],
                    ['icon' => 'chart-pie', 'title' => 'Reporting Modules', 'description' => 'Build reports that give your business a clear view.'],
                    ['icon' => 'user-group', 'title' => 'Role-Based Access Control', 'description' => 'Give each user the right level of access.'],
                ],
            ],
            'benefits' => [
                'heading' => 'Business Benefits',
                'description' => 'A well-built Laravel application supports your operations today and tomorrow.',
                'items' => [
                    ['icon' => 'shield-check', 'title' => 'Reliable Business Systems', 'description' => 'Applications your team can depend on every day.'],
                    ['icon' => 'lock-closed', 'title' => 'Improved Security', 'description' => 'Secure foundations protect your data and customers.'],
                    ['icon' => 'bolt', 'title' => 'Better Performance', 'description' => 'Fast, responsive applications that keep work moving.'],
                    ['icon' => 'clipboard-document-list', 'title' => 'Easier Future Development', 'description' => 'Clean code makes adding features faster and safer.'],
                    ['icon' => 'arrow-right', 'title' => 'Scalable Architecture', 'description' => 'Build on a foundation that grows with demand.'],
                    ['icon' => 'banknotes', 'title' => 'Reduced Maintenance Costs', 'description' => 'Quality code reduces bugs and long-term maintenance expense.'],
                    ['icon' => 'bolt', 'title' => 'Improved Operational Efficiency', 'description' => 'Streamlined systems help your team do more in less time.'],
                ],
            ],
            'technologies' => [
                'heading' => 'Technologies We Use',
                'description' => 'We use the Laravel ecosystem and modern tooling to build dependable applications.',
                'items' => ['Laravel', 'PHP', 'MySQL', 'Tailwind CSS', 'Alpine.js', 'JavaScript', 'REST APIs', 'Git', 'Composer', 'Vite'],
            ],
            'faqs' => [
                ['question' => 'Why choose Laravel?', 'answer' => 'Laravel is a mature, widely used framework with strong security, a large ecosystem, and excellent tooling, making it ideal for reliable business applications.'],
                ['question' => 'Can you improve an existing Laravel application?', 'answer' => 'Yes. We can improve, extend, and modernize existing Laravel applications, including refactoring, performance, and security work.'],
                ['question' => 'Can Laravel integrate with other systems?', 'answer' => 'Yes. Laravel supports REST APIs and integrations with third-party services, so your application can connect with the tools you already use.'],
                ['question' => 'Is Laravel suitable for enterprise projects?', 'answer' => 'Yes. Laravel is used for applications of all sizes and supports the scalability, security, and structure enterprise projects require.'],
                ['question' => 'Do you provide ongoing maintenance?', 'answer' => 'Yes. We offer maintenance plans that keep your application updated, secure, and performing well.'],
                ['question' => 'Can additional modules be added later?', 'answer' => 'Yes. Laravel applications are built to be extended, so new modules and features can be added as your business evolves.'],
            ],
            'related' => ['custom-software', 'api-development', 'business-automation', 'website-maintenance'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function wordpressDevelopment(): array
    {
        return [
            'meta' => [
                'title' => 'WordPress Development Services',
                'description' => 'Professional WordPress websites built for business growth. Secure, responsive, and easy to manage with the WordPress platform.',
            ],
            'hero' => [
                'heading' => 'Professional WordPress Websites Built for Business Growth',
                'supporting' => 'Launch a secure, responsive, and easy-to-manage WordPress website designed to strengthen your online presence, attract customers, and grow alongside your business.',
                'primaryCta' => ['label' => 'Get a Free Quote', 'href' => 'quote'],
                'secondaryCta' => ['label' => 'View Our Portfolio', 'href' => 'portfolio'],
                'trust' => ['Easy to Manage', 'Secure Configuration', 'Performance Optimized', 'Built for Growth'],
            ],
            'overview' => [
                'heading' => 'A WordPress Website You Can Actually Manage',
                'description' => 'SMEvolve develops modern, secure, and easy-to-manage WordPress websites tailored to business needs.',
                'paragraphs' => [
                    'Whether you need a corporate website, blog, portfolio, service website, or content-driven platform, we build WordPress solutions that combine flexibility, performance, and professional design.',
                    'We focus on custom design and secure configuration rather than relying on excessive plugins or generic themes, so your website supports your business objectives.',
                ],
                'points' => [
                    'A custom design that reflects your brand.',
                    'Easy content management without technical skills.',
                    'Secure configuration and regular updates.',
                    'A fast, SEO-friendly structure.',
                ],
            ],
            'problems' => [
                'heading' => 'Problems We Solve',
                'description' => 'Many WordPress websites fail on performance, security, or design. We solve the common issues businesses face.',
                'items' => [
                    ['title' => 'Outdated WordPress Websites', 'description' => 'Old versions and themes create security risks and compatibility issues.'],
                    ['title' => 'Slow Loading Pages', 'description' => 'Slow websites frustrate visitors and hurt search rankings.'],
                    ['title' => 'Poor Mobile Experience', 'description' => 'Sites that do not work well on phones lose a large share of visitors.'],
                    ['title' => 'Security Vulnerabilities', 'description' => 'Unpatched plugins and themes leave your website exposed to attacks.'],
                    ['title' => 'Difficult Content Updates', 'description' => 'Complex setups make simple updates frustrating for staff.'],
                    ['title' => 'Poor Search Visibility', 'description' => 'Without SEO-friendly structure, your content rarely gets found.'],
                    ['title' => 'Plugin Conflicts', 'description' => 'Too many plugins cause conflicts, slowdowns, and breakages.'],
                    ['title' => 'Generic Website Designs', 'description' => 'Template websites make your business look identical to competitors.'],
                ],
            ],
            'solution' => [
                'heading' => 'Our Solution',
                'description' => 'SMEvolve builds WordPress websites using modern development practices focused on custom design, performance, and security.',
                'points' => [
                    'Custom design rather than generic themes.',
                    'Responsive layouts that work on every device.',
                    'Secure configuration and careful plugin selection.',
                    'Performance optimization for fast loading.',
                    'SEO-friendly structure and easy content management.',
                ],
            ],
            'features' => [
                'heading' => 'Key Features',
                'description' => 'A professional WordPress website with the features your business needs.',
                'items' => [
                    ['icon' => 'swatch', 'title' => 'Custom WordPress Themes', 'description' => 'A unique design built around your brand.'],
                    ['icon' => 'rectangle-stack', 'title' => 'Content Management System', 'description' => 'Manage pages and content with an easy-to-use editor.'],
                    ['icon' => 'device-mobile', 'title' => 'Responsive Design', 'description' => 'A layout that adapts to every screen size.'],
                    ['icon' => 'chat-bubble-left-right', 'title' => 'Contact Forms', 'description' => 'Reliable forms that make it easy for customers to reach you.'],
                    ['icon' => 'clipboard-document-list', 'title' => 'Blog Functionality', 'description' => 'Publish articles and news to engage your audience.'],
                    ['icon' => 'magnifying-glass', 'title' => 'SEO-Ready Structure', 'description' => 'Technical foundations that support search visibility.'],
                    ['icon' => 'shield-check', 'title' => 'Security Hardening', 'description' => 'Secure configuration that protects your website.'],
                    ['icon' => 'bolt', 'title' => 'Performance Optimization', 'description' => 'Fast loading pages that keep visitors engaged.'],
                    ['icon' => 'chart-bar', 'title' => 'Analytics Integration', 'description' => 'Understand your visitors with analytics.'],
                    ['icon' => 'database', 'title' => 'Backup & Recovery', 'description' => 'Protect your content with reliable backups.'],
                    ['icon' => 'user-group', 'title' => 'User Role Management', 'description' => 'Control who can edit, publish, and manage content.'],
                ],
            ],
            'benefits' => [
                'heading' => 'Business Benefits',
                'description' => 'A well-built WordPress website supports your credibility and your customers.',
                'items' => [
                    ['icon' => 'building-library', 'title' => 'Professional Online Presence', 'description' => 'A polished website that reflects the quality of your business.'],
                    ['icon' => 'clipboard-document-list', 'title' => 'Easier Content Updates', 'description' => 'Update your website yourself, quickly and simply.'],
                    ['icon' => 'heart', 'title' => 'Better Customer Engagement', 'description' => 'Engaging design and content keep visitors interested.'],
                    ['icon' => 'magnifying-glass', 'title' => 'Improved Search Visibility', 'description' => 'SEO-friendly structure helps customers find you.'],
                    ['icon' => 'bolt', 'title' => 'Faster Website Performance', 'description' => 'A fast website keeps visitors and search engines happy.'],
                    ['icon' => 'shield-check', 'title' => 'Lower Maintenance Complexity', 'description' => 'A clean setup is simpler to maintain and safer to run.'],
                    ['icon' => 'arrow-right', 'title' => 'Long-Term Flexibility', 'description' => 'WordPress makes it easy to extend your website over time.'],
                ],
            ],
            'technologies' => [
                'heading' => 'Technologies We Use',
                'description' => 'We use a focused, dependable technology stack for secure and maintainable WordPress websites.',
                'items' => ['WordPress', 'PHP', 'MySQL', 'Tailwind CSS', 'HTML5', 'CSS3', 'JavaScript', 'WooCommerce (where applicable)'],
            ],
            'faqs' => [
                ['question' => 'Why choose WordPress?', 'answer' => 'WordPress is a widely used, flexible platform that is easy to manage and easy to extend, making it a great fit for content-driven business websites.'],
                ['question' => 'Will I be able to update the website myself?', 'answer' => 'Yes. WordPress is designed for easy content management, so you can update pages, posts, and images yourself without technical knowledge.'],
                ['question' => 'Can new features be added later?', 'answer' => 'Yes. WordPress supports plugins and custom development, so new features can be added as your needs grow.'],
                ['question' => 'Can an existing WordPress website be redesigned?', 'answer' => 'Yes. We can redesign and modernize existing WordPress websites, improving design, performance, and usability.'],
                ['question' => 'Is WordPress secure?', 'answer' => 'WordPress is secure when properly configured and maintained. We apply security hardening and keep things updated.'],
                ['question' => 'Do you provide maintenance and updates?', 'answer' => 'Yes. We offer maintenance plans covering updates, security, backups, and technical support.'],
            ],
            'related' => ['website-development', 'website-maintenance', 'ecommerce-development', 'api-development'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function mobileAppDevelopment(): array
    {
        return [
            'meta' => [
                'title' => 'Mobile App Development Services',
                'description' => 'Mobile apps that help your business grow. Cross-platform applications built for usability, security, and long-term success.',
            ],
            'hero' => [
                'heading' => 'Mobile Apps That Help Your Business Grow',
                'supporting' => 'Turn your ideas into powerful mobile applications that improve customer experiences, simplify business operations, and create new opportunities for growth.',
                'primaryCta' => ['label' => 'Get a Free Quote', 'href' => 'quote'],
                'secondaryCta' => ['label' => 'Book a Consultation', 'href' => 'contact'],
                'trust' => ['User-Centered Design', 'Secure Architecture', 'Cross-Platform', 'Scalable & Maintainable'],
            ],
            'overview' => [
                'heading' => 'Applications Designed Around Business Outcomes',
                'description' => 'SMEvolve designs and develops mobile applications that help businesses engage customers, reduce manual work, and deliver digital services on modern smartphones and tablets.',
                'paragraphs' => [
                    'Applications are built with usability, security, scalability, and long-term maintainability in mind.',
                    'We design your app around business outcomes rather than technology alone, so it delivers real value to your customers and your team.',
                ],
                'points' => [
                    'An app designed around your customers and goals.',
                    'Cross-platform reach across modern devices.',
                    'Secure architecture and data handling.',
                    'A solution built to be maintained and scaled.',
                ],
            ],
            'problems' => [
                'heading' => 'Problems We Solve',
                'description' => 'Many businesses struggle to engage customers and deliver services digitally. We solve the challenges that hold them back.',
                'items' => [
                    ['title' => 'Limited Customer Engagement', 'description' => 'Without a mobile presence, you miss opportunities to connect with customers daily.'],
                    ['title' => 'Manual Business Processes', 'description' => 'Routine tasks that could be automated slow your operations down.'],
                    ['title' => 'Lack of Mobile Accessibility', 'description' => 'Customers expect to reach you from their phones, anytime.'],
                    ['title' => 'Poor Customer Experience', 'description' => 'Clunky or missing digital services frustrate customers.'],
                    ['title' => 'Slow Service Delivery', 'description' => 'Manual processes delay responses and delivery of services.'],
                    ['title' => 'Difficulty Reaching Customers', 'description' => 'Without a dedicated channel, communication with customers is scattered.'],
                    ['title' => 'Outdated Digital Services', 'description' => 'Old approaches make your business feel behind the times.'],
                    ['title' => 'Inefficient Communication', 'description' => 'Poor communication channels reduce satisfaction and trust.'],
                ],
            ],
            'solution' => [
                'heading' => 'Our Solution',
                'description' => 'SMEvolve develops mobile applications tailored to each client\u2019s goals, focused on user-centered design and business outcomes.',
                'points' => [
                    'User-centered design that people enjoy using.',
                    'Business-focused functionality that solves real problems.',
                    'Secure architecture that protects user data.',
                    'High performance and smooth experience.',
                    'Scalability and easy maintenance for the long term.',
                ],
            ],
            'features' => [
                'heading' => 'Key Features',
                'description' => 'Mobile applications can include the features that drive engagement and efficiency.',
                'items' => [
                    ['icon' => 'shield-check', 'title' => 'User Authentication', 'description' => 'Secure sign-up and login for your users.'],
                    ['icon' => 'bell', 'title' => 'Push Notifications', 'description' => 'Keep users informed and engaged with timely updates.'],
                    ['icon' => 'wifi', 'title' => 'Offline Capabilities', 'description' => 'Let users access key features even without a connection.'],
                    ['icon' => 'code', 'title' => 'Secure APIs', 'description' => 'Reliable, secure connections between the app and your systems.'],
                    ['icon' => 'credit-card', 'title' => 'Payment Integration', 'description' => 'Accept payments securely within your app.'],
                    ['icon' => 'map', 'title' => 'Maps & Location Services', 'description' => 'Location-aware features that improve the user experience.'],
                    ['icon' => 'photo', 'title' => 'File Uploads', 'description' => 'Let users upload documents, images, and files securely.'],
                    ['icon' => 'bolt', 'title' => 'Real-Time Updates', 'description' => 'Keep content and data current for your users.'],
                    ['icon' => 'user-group', 'title' => 'User Profiles', 'description' => 'Personalized experiences for each user.'],
                    ['icon' => 'chart-bar', 'title' => 'Analytics', 'description' => 'Understand how your app is used and performing.'],
                    ['icon' => 'rectangle-stack', 'title' => 'Admin Dashboard Integration', 'description' => 'Manage your app and its content from a dashboard.'],
                ],
            ],
            'benefits' => [
                'heading' => 'Business Benefits',
                'description' => 'A well-designed mobile app creates real value for your business and your customers.',
                'items' => [
                    ['icon' => 'heart', 'title' => 'Improved Customer Engagement', 'description' => 'Stay connected with customers through a channel they use daily.'],
                    ['icon' => 'bolt', 'title' => 'Better Operational Efficiency', 'description' => 'Digitize processes and reduce manual effort.'],
                    ['icon' => 'device-mobile', 'title' => 'Increased Accessibility', 'description' => 'Make your services available wherever your customers are.'],
                    ['icon' => 'building-library', 'title' => 'Stronger Brand Presence', 'description' => 'Reinforce your brand with a professional mobile experience.'],
                    ['icon' => 'rocket-launch', 'title' => 'Faster Service Delivery', 'description' => 'Deliver services and responses more quickly.'],
                    ['icon' => 'trending-up', 'title' => 'New Revenue Opportunities', 'description' => 'Open new ways to generate value and income.'],
                    ['icon' => 'user-group', 'title' => 'Improved Customer Loyalty', 'description' => 'A great app experience keeps customers coming back.'],
                ],
            ],
            'technologies' => [
                'heading' => 'Technologies We Use',
                'description' => 'We build cross-platform apps with proven mobile technologies and reliable backends.',
                'items' => ['React Native', 'Flutter', 'Laravel APIs', 'Firebase', 'MySQL', 'REST APIs', 'Push Notification Services', 'Cloud Infrastructure'],
            ],
            'faqs' => [
                ['question' => 'Should I build for Android, iOS, or both?', 'answer' => 'It depends on your audience and goals. Cross-platform development lets you reach both platforms efficiently, and we can help you decide what fits best.'],
                ['question' => 'Can the app integrate with my existing system?', 'answer' => 'Yes. Apps connect to your existing systems through APIs, allowing data and features to work together.'],
                ['question' => 'Will the app be scalable?', 'answer' => 'Yes. We build on scalable foundations so your app can handle more users and features over time.'],
                ['question' => 'Can new features be added later?', 'answer' => 'Yes. Our apps are designed to be extended, so new features can be added as your business grows.'],
                ['question' => 'Do you publish apps to the App Store and Google Play?', 'answer' => 'We can support you through the release process for app stores, subject to the requirements of each store.'],
                ['question' => 'Do you provide maintenance and updates?', 'answer' => 'Yes. We offer maintenance and support to keep your app updated, secure, and performing well.'],
            ],
            'related' => ['custom-software', 'api-development', 'business-automation', 'ai-solutions'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function aiSolutions(): array
    {
        return [
            'meta' => [
                'title' => 'AI Solutions for Business',
                'description' => 'Practical AI solutions for modern businesses. Automate routine work, improve customer interactions, and make better use of your data.',
            ],
            'hero' => [
                'heading' => 'Practical AI Solutions for Modern Businesses',
                'supporting' => 'Use Artificial Intelligence to automate routine work, improve customer interactions, and create new growth opportunities through practical, responsible AI solutions.',
                'primaryCta' => ['label' => 'Get a Free Quote', 'href' => 'quote'],
                'secondaryCta' => ['label' => 'Book a Consultation', 'href' => 'contact'],
                'trust' => ['Practical & Responsible', 'Business-Focused', 'Integrates with Your Systems', 'Built to Scale'],
            ],
            'overview' => [
                'heading' => 'AI as a Practical Business Tool',
                'description' => 'SMEvolve helps businesses use Artificial Intelligence to improve productivity, automate repetitive tasks, enhance customer experiences, and make better use of business data.',
                'paragraphs' => [
                    'Our approach focuses on practical AI solutions that deliver measurable business value rather than adopting technology for its own sake.',
                    'We evaluate your business processes first, then recommend AI where it genuinely helps, always with human oversight where appropriate.',
                ],
                'points' => [
                    'AI applied where it delivers real business value.',
                    'Solutions that integrate with your existing systems.',
                    'Responsible implementation with human oversight.',
                    'Scalable approaches that grow with your business.',
                ],
            ],
            'problems' => [
                'heading' => 'Problems We Solve',
                'description' => 'Many businesses waste time on repetitive work that AI can handle. We solve the challenges that drain productivity.',
                'items' => [
                    ['title' => 'Time-Consuming Repetitive Tasks', 'description' => 'Repetitive work consumes hours that could go toward higher-value activities.'],
                    ['title' => 'Slow Customer Support', 'description' => 'Customers wait too long for answers, affecting satisfaction.'],
                    ['title' => 'Manual Document Processing', 'description' => 'Processing documents by hand is slow, costly, and error-prone.'],
                    ['title' => 'Difficulty Finding Business Insights', 'description' => 'Valuable data stays hidden when it is hard to analyze.'],
                    ['title' => 'Inefficient Workflows', 'description' => 'Disconnected, manual steps slow your whole operation.'],
                    ['title' => 'Limited Business Scalability', 'description' => 'Manual processes cannot scale as demand grows.'],
                    ['title' => 'Information Overload', 'description' => 'Too much data makes it hard to find what matters.'],
                    ['title' => 'Repetitive Administrative Work', 'description' => 'Administrative tasks drain time from your team every week.'],
                ],
            ],
            'solution' => [
                'heading' => 'Our Solution',
                'description' => 'SMEvolve evaluates business processes before recommending AI solutions, focusing on practical, responsible implementation.',
                'points' => [
                    'Identify suitable AI use cases based on your goals.',
                    'Responsible AI implementation with human oversight.',
                    'Integration with your existing systems and data.',
                    'Scalable and secure approaches.',
                    'Continuous improvement as your business evolves.',
                ],
            ],
            'features' => [
                'heading' => 'Key Features',
                'description' => 'AI solutions we can build around your specific needs.',
                'items' => [
                    ['icon' => 'chat-bubble-left-right', 'title' => 'AI Chatbots', 'description' => 'Assist customers and answer common questions around the clock.'],
                    ['icon' => 'headset', 'title' => 'Customer Support Assistants', 'description' => 'Support your team by handling routine customer enquiries.'],
                    ['icon' => 'magnifying-glass', 'title' => 'AI-Powered Search', 'description' => 'Help users find information quickly and accurately.'],
                    ['icon' => 'clipboard-document-list', 'title' => 'Intelligent Document Processing', 'description' => 'Extract and process information from documents automatically.'],
                    ['icon' => 'pencil', 'title' => 'Content Generation Assistance', 'description' => 'Support content creation with AI-assisted drafting.'],
                    ['icon' => 'bolt', 'title' => 'Workflow Automation', 'description' => 'Automate routine steps across your business processes.'],
                    ['icon' => 'chart-bar', 'title' => 'Data Analysis Assistance', 'description' => 'Surface insights from your business data more quickly.'],
                    ['icon' => 'academic-cap', 'title' => 'Knowledge Assistants', 'description' => 'Help your team find answers from your own knowledge base.'],
                    ['icon' => 'star', 'title' => 'AI Recommendations', 'description' => 'Deliver personalised suggestions to customers or users.'],
                    ['icon' => 'code', 'title' => 'AI Integration with Business Systems', 'description' => 'Add AI capabilities to the systems you already use.'],
                ],
            ],
            'benefits' => [
                'heading' => 'Business Benefits',
                'description' => 'Practical AI creates benefits your business can measure.',
                'items' => [
                    ['icon' => 'bolt', 'title' => 'Improved Productivity', 'description' => 'Automate routine work so your team focuses on what matters.'],
                    ['icon' => 'rocket-launch', 'title' => 'Faster Customer Support', 'description' => 'Answer customers quickly with AI assistance.'],
                    ['icon' => 'banknotes', 'title' => 'Reduced Operational Costs', 'description' => 'Less manual work means lower operating costs over time.'],
                    ['icon' => 'chart-pie', 'title' => 'Better Decision-Making', 'description' => 'Insights from your data support confident decisions.'],
                    ['icon' => 'user-group', 'title' => 'Improved Employee Efficiency', 'description' => 'Your team spends time on valuable work, not repetition.'],
                    ['icon' => 'heart', 'title' => 'Enhanced Customer Experience', 'description' => 'Fast, helpful interactions improve customer satisfaction.'],
                    ['icon' => 'arrow-right', 'title' => 'Greater Business Scalability', 'description' => 'AI lets you handle more work without scaling headcount.'],
                ],
            ],
            'technologies' => [
                'heading' => 'Technologies We Use',
                'description' => 'We use proven AI services and platforms, applied responsibly to business problems.',
                'items' => ['OpenAI APIs', 'Laravel', 'Python (where appropriate)', 'REST APIs', 'Vector Databases', 'Cloud AI Services', 'MySQL', 'JavaScript'],
            ],
            'faqs' => [
                ['question' => 'How can AI help my business?', 'answer' => 'AI can help with repetitive tasks, customer support, document processing, data insights, and content assistance, freeing your team for higher-value work.'],
                ['question' => 'Is AI suitable for small businesses?', 'answer' => 'Yes. Many practical AI solutions are accessible to small businesses and can be scaled to the size of your operations.'],
                ['question' => 'Can AI integrate with my existing systems?', 'answer' => 'Yes. AI can integrate with your existing software and data through APIs and integrations.'],
                ['question' => 'Will AI replace my employees?', 'answer' => 'We present AI as a tool that supports people, not replaces them. Human oversight and expertise remain important.'],
                ['question' => 'How is business data protected?', 'answer' => 'We follow secure integration practices and treat your data carefully, including how it is used and stored.'],
                ['question' => 'Can AI solutions be expanded over time?', 'answer' => 'Yes. AI solutions can be expanded and improved as your business needs evolve.'],
            ],
            'related' => ['business-automation', 'api-development', 'custom-software', 'mobile-app-development'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function businessAutomation(): array
    {
        return [
            'meta' => [
                'title' => 'Business Automation Services',
                'description' => 'Automate repetitive work and improve business efficiency. Workflow automation, integrations, and systems that let your team focus on what matters.',
            ],
            'hero' => [
                'heading' => 'Automate Repetitive Work and Improve Business Efficiency',
                'supporting' => 'Reduce manual processes, improve accuracy, and free your team to focus on what matters most with automation solutions tailored to your business.',
                'primaryCta' => ['label' => 'Get a Free Quote', 'href' => 'quote'],
                'secondaryCta' => ['label' => 'Book a Consultation', 'href' => 'contact'],
                'trust' => ['Simplify Work', 'Connect Your Systems', 'Improve Accuracy', 'Built Around You'],
            ],
            'overview' => [
                'heading' => 'Automation That Simplifies Work, Not Complicates It',
                'description' => 'SMEvolve helps businesses reduce manual work, eliminate repetitive tasks, and improve operational efficiency through intelligent business automation.',
                'paragraphs' => [
                    'Our solutions reduce manual steps, connect business systems, and let teams focus on higher-value work instead of repetitive administrative tasks.',
                    'We begin by understanding your existing processes before identifying opportunities for automation, so we only automate what genuinely helps.',
                ],
                'points' => [
                    'Automation designed around your real workflows.',
                    'Connected systems that share information automatically.',
                    'Fewer errors and faster processes.',
                    'Solutions that scale with your business.',
                ],
            ],
            'problems' => [
                'heading' => 'Problems We Solve',
                'description' => 'Repetitive manual work quietly drains productivity. We solve the operational challenges that slow businesses down.',
                'items' => [
                    ['title' => 'Repetitive Manual Tasks', 'description' => 'Teams spend hours on work that could be automated.'],
                    ['title' => 'Duplicate Data Entry', 'description' => 'The same information entered multiple times wastes time and causes errors.'],
                    ['title' => 'Slow Approval Processes', 'description' => 'Delays in approvals hold up work and frustrate everyone involved.'],
                    ['title' => 'Human Error', 'description' => 'Manual processes are prone to mistakes that cost time and money.'],
                    ['title' => 'Disconnected Software', 'description' => 'Systems that do not share data force manual handoffs between tools.'],
                    ['title' => 'Time-Consuming Reporting', 'description' => 'Building reports by hand takes time that could be spent analyzing them.'],
                    ['title' => 'Inefficient Workflows', 'description' => 'Workflows with unnecessary steps slow your whole operation.'],
                    ['title' => 'Communication Bottlenecks', 'description' => 'Slow, manual communication delays decisions and delivery.'],
                ],
            ],
            'solution' => [
                'heading' => 'Our Solution',
                'description' => 'SMEvolve begins by understanding existing business processes before identifying opportunities for automation, automation should simplify work, not complicate it.',
                'points' => [
                    'Workflow analysis to find real automation opportunities.',
                    'Process optimization before automating.',
                    'System integration so your tools work together.',
                    'Scalable automation design.',
                    'Continuous improvement after implementation.',
                ],
            ],
            'features' => [
                'heading' => 'Key Features',
                'description' => 'Automation we can implement across your business operations.',
                'items' => [
                    ['icon' => 'bolt', 'title' => 'Workflow Automation', 'description' => 'Automate routine steps in your key business processes.'],
                    ['icon' => 'clipboard-document-list', 'title' => 'Approval Workflows', 'description' => 'Speed up approvals with clear, automated routing.'],
                    ['icon' => 'envelope', 'title' => 'Email Automation', 'description' => 'Send the right messages at the right time automatically.'],
                    ['icon' => 'user-group', 'title' => 'Customer Onboarding Automation', 'description' => 'Streamline how new customers get started with you.'],
                    ['icon' => 'document-text', 'title' => 'Document Generation', 'description' => 'Generate documents automatically from your data.'],
                    ['icon' => 'receipt', 'title' => 'Invoice Processing', 'description' => 'Process invoices faster with less manual effort.'],
                    ['icon' => 'calendar', 'title' => 'Appointment Scheduling', 'description' => 'Automate bookings and reminders for your customers.'],
                    ['icon' => 'database', 'title' => 'Inventory Updates', 'description' => 'Keep stock levels accurate automatically.'],
                    ['icon' => 'user-group', 'title' => 'CRM Integration', 'description' => 'Keep your customer data synced across systems.'],
                    ['icon' => 'chart-bar', 'title' => 'Reporting Automation', 'description' => 'Generate regular reports automatically.'],
                    ['icon' => 'bell', 'title' => 'Notifications & Alerts', 'description' => 'Notify the right people when action is needed.'],
                ],
            ],
            'benefits' => [
                'heading' => 'Business Benefits',
                'description' => 'Automation creates measurable improvements across your operations.',
                'items' => [
                    ['icon' => 'bolt', 'title' => 'Increased Productivity', 'description' => 'Your team spends less time on repetitive work.'],
                    ['icon' => 'banknotes', 'title' => 'Reduced Operational Costs', 'description' => 'Less manual effort lowers your operating costs.'],
                    ['icon' => 'shield-check', 'title' => 'Improved Accuracy', 'description' => 'Automation reduces human errors and rework.'],
                    ['icon' => 'rocket-launch', 'title' => 'Faster Response Times', 'description' => 'Automated steps move work forward immediately.'],
                    ['icon' => 'user-group', 'title' => 'Better Collaboration', 'description' => 'Connected systems keep teams aligned.'],
                    ['icon' => 'rectangle-stack', 'title' => 'Greater Process Consistency', 'description' => 'Every process runs the same way every time.'],
                    ['icon' => 'heart', 'title' => 'Improved Customer Experience', 'description' => 'Faster, smoother service improves customer satisfaction.'],
                    ['icon' => 'arrow-right', 'title' => 'Easier Business Scaling', 'description' => 'Automation lets you grow without adding manual work.'],
                ],
            ],
            'technologies' => [
                'heading' => 'Technologies We Use',
                'description' => 'We use reliable platforms and integrations to build automation that works.',
                'items' => ['Laravel', 'REST APIs', 'AI Services (where appropriate)', 'MySQL', 'Workflow Automation Platforms', 'Cloud Services', 'Email Services', 'Third-Party Integrations'],
            ],
            'faqs' => [
                ['question' => 'What processes can be automated?', 'answer' => 'Common examples include approvals, data entry, reporting, invoicing, scheduling, onboarding, and notifications, but it depends on your specific workflows.'],
                ['question' => 'Can automation integrate with my existing software?', 'answer' => 'Yes. Automation connects with your existing systems through APIs and integrations where supported.'],
                ['question' => 'Will automation replace employees?', 'answer' => 'Automation is designed to remove repetitive work so your team can focus on higher-value tasks. People remain central to the business.'],
                ['question' => 'How secure are automated workflows?', 'answer' => 'We follow secure integration and data handling practices when designing and building automated workflows.'],
                ['question' => 'Can automations be updated later?', 'answer' => 'Yes. Automations can be adjusted and expanded as your processes change.'],
                ['question' => 'How do we identify automation opportunities?', 'answer' => 'We start by reviewing your processes with you to identify repetitive, manual, or error-prone steps where automation delivers the most value.'],
            ],
            'related' => ['ai-solutions', 'api-development', 'custom-software', 'website-maintenance'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function apiDevelopment(): array
    {
        return [
            'meta' => [
                'title' => 'API Development & System Integration',
                'description' => 'Secure API development and system integration. Connect your applications, automate data exchange, and build reliable digital ecosystems.',
            ],
            'hero' => [
                'heading' => 'Secure API Development & System Integration',
                'supporting' => 'Connect your applications, automate data exchange, and build reliable digital ecosystems with custom API development and integration services.',
                'primaryCta' => ['label' => 'Get a Free Quote', 'href' => 'quote'],
                'secondaryCta' => ['label' => 'Book a Consultation', 'href' => 'contact'],
                'trust' => ['Secure by Design', 'Well Documented', 'Reliable Integrations', 'Built to Scale'],
            ],
            'overview' => [
                'heading' => 'Systems That Work Together',
                'description' => 'SMEvolve designs, develops, and integrates secure APIs that allow different software systems to communicate efficiently.',
                'paragraphs' => [
                    'Whether connecting internal applications, third-party platforms, payment gateways, or mobile apps, our API solutions help businesses cut manual steps and improve data flow.',
                    'We plan APIs carefully, document them properly, and build for security, performance, and long-term maintainability.',
                ],
                'points' => [
                    'APIs that connect your systems reliably.',
                    'Secure authentication and data exchange.',
                    'Clear documentation your team can use.',
                    'Integrations built to grow with your business.',
                ],
            ],
            'problems' => [
                'heading' => 'Problems We Solve',
                'description' => 'Disconnected systems and manual data transfer waste time and create errors. We solve the integration challenges businesses face.',
                'items' => [
                    ['title' => 'Disconnected Business Systems', 'description' => 'Systems that do not communicate force manual work between tools.'],
                    ['title' => 'Manual Data Transfer', 'description' => 'Copying data between systems is slow and error-prone.'],
                    ['title' => 'Duplicate Information', 'description' => 'The same data stored in multiple places becomes inconsistent.'],
                    ['title' => 'Poor Software Interoperability', 'description' => 'Systems that cannot share data limit what your business can do.'],
                    ['title' => 'Difficult Third-Party Integrations', 'description' => 'Connecting to external services is complex without experience.'],
                    ['title' => 'Limited Scalability', 'description' => 'Manual handoffs do not scale as your data grows.'],
                    ['title' => 'Inconsistent Data', 'description' => 'Different systems hold different versions of the truth.'],
                    ['title' => 'Slow Business Processes', 'description' => 'Manual data movement slows down critical processes.'],
                ],
            ],
            'solution' => [
                'heading' => 'Our Solution',
                'description' => 'SMEvolve develops APIs using secure, modern, and scalable development practices.',
                'points' => [
                    'API planning before implementation.',
                    'Secure authentication and access control.',
                    'Clear documentation for your team and partners.',
                    'Integration strategy aligned with your goals.',
                    'Performance optimization and reliable error handling.',
                ],
            ],
            'features' => [
                'heading' => 'Key Features',
                'description' => 'API services we design, build, and integrate for your business.',
                'items' => [
                    ['icon' => 'code', 'title' => 'RESTful API Development', 'description' => 'Clean, reliable APIs built to standard practices.'],
                    ['icon' => 'globe-alt', 'title' => 'Third-Party API Integration', 'description' => 'Connect the external services your business depends on.'],
                    ['icon' => 'credit-card', 'title' => 'Payment Gateway Integration', 'description' => 'Process payments securely through trusted gateways.'],
                    ['icon' => 'shield-check', 'title' => 'Authentication & Authorization', 'description' => 'Control access to your APIs securely.'],
                    ['icon' => 'bolt', 'title' => 'Webhooks', 'description' => 'Real-time notifications between your systems.'],
                    ['icon' => 'clipboard-document-list', 'title' => 'API Documentation', 'description' => 'Clear documentation that is easy to work with.'],
                    ['icon' => 'arrow-right', 'title' => 'Versioning', 'description' => 'Manage API changes safely over time.'],
                    ['icon' => 'chart-bar', 'title' => 'Rate Limiting', 'description' => 'Protect your API from overuse and abuse.'],
                    ['icon' => 'lock-closed', 'title' => 'Secure Data Exchange', 'description' => 'Keep data safe while it moves between systems.'],
                    ['icon' => 'device-mobile', 'title' => 'Mobile Application APIs', 'description' => 'Power mobile apps with reliable backend APIs.'],
                    ['icon' => 'building-library', 'title' => 'ERP / CRM Integrations', 'description' => 'Connect your core business platforms.'],
                ],
            ],
            'benefits' => [
                'heading' => 'Business Benefits',
                'description' => 'Connected systems create measurable improvements across your business.',
                'items' => [
                    ['icon' => 'globe-alt', 'title' => 'Better System Connectivity', 'description' => 'Your tools share information automatically.'],
                    ['icon' => 'clipboard-document-list', 'title' => 'Reduced Manual Work', 'description' => 'Less copying data between systems means less effort.'],
                    ['icon' => 'rocket-launch', 'title' => 'Faster Business Processes', 'description' => 'Data flows between systems instantly.'],
                    ['icon' => 'shield-check', 'title' => 'Improved Data Accuracy', 'description' => 'One consistent source of information reduces errors.'],
                    ['icon' => 'arrow-right', 'title' => 'Greater Scalability', 'description' => 'APIs let you add systems and features as you grow.'],
                    ['icon' => 'bolt', 'title' => 'Easier Integration With New Systems', 'description' => 'Future tools can connect without a major rebuild.'],
                    ['icon' => 'trending-up', 'title' => 'Improved Operational Efficiency', 'description' => 'Automated data flow cuts manual work.'],
                ],
            ],
            'technologies' => [
                'heading' => 'Technologies We Use',
                'description' => 'We use dependable, secure technologies to build and integrate APIs.',
                'items' => ['Laravel', 'REST APIs', 'JSON', 'OAuth', 'MySQL', 'PHP', 'JavaScript', 'Cloud Services'],
            ],
            'faqs' => [
                ['question' => 'What is an API?', 'answer' => 'An API (Application Programming Interface) allows different software systems to communicate and share data securely and automatically.'],
                ['question' => 'Can APIs connect my existing software?', 'answer' => 'Yes. APIs can connect the systems you already use, allowing them to share data and work together.'],
                ['question' => 'Are APIs secure?', 'answer' => 'APIs can be built with strong security, including authentication, authorization, and encrypted data exchange. We follow secure development practices.'],
                ['question' => 'Can you integrate third-party services?', 'answer' => 'Yes. We integrate reputable third-party services including payment gateways, communication platforms, and other business tools.'],
                ['question' => 'Can APIs support mobile applications?', 'answer' => 'Yes. APIs are a common way to power mobile applications with reliable backend data and features.'],
                ['question' => 'Do you provide API maintenance?', 'answer' => 'Yes. We offer maintenance and support to keep your APIs secure, reliable, and up to date.'],
            ],
            'related' => ['custom-software', 'laravel-development', 'business-automation', 'ai-solutions'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function websiteMaintenance(): array
    {
        return [
            'meta' => [
                'title' => 'Website Maintenance Services',
                'description' => 'Keep your website secure, fast, and up to date with ongoing maintenance, security updates, backups, and expert technical support.',
            ],
            'hero' => [
                'heading' => 'Keep Your Website Secure, Fast & Up to Date',
                'supporting' => 'Protect your website with ongoing maintenance, security updates, performance improvements, and expert support so you can focus on running your business.',
                'primaryCta' => ['label' => 'Get a Free Quote', 'href' => 'quote'],
                'secondaryCta' => ['label' => 'Contact Us', 'href' => 'contact'],
                'trust' => ['Preventive Care', 'Security Updates', 'Reliable Backups', 'Expert Support'],
            ],
            'overview' => [
                'heading' => 'Maintenance as an Investment in Reliability',
                'description' => 'Launching a website is only the beginning. SMEvolve provides ongoing website maintenance services to help businesses keep their websites secure, up to date, reliable, and performing at their best.',
                'paragraphs' => [
                    'Our maintenance plans are designed to reduce technical risks, improve performance, and ensure your website continues to support your business goals.',
                    'We take a proactive approach rather than waiting for problems to occur, so issues are caught early and downtime is minimised.',
                ],
                'points' => [
                    'Regular updates that keep your website secure.',
                    'Backups that protect your content and data.',
                    'Performance care that keeps pages fast.',
                    'Ongoing technical support when you need it.',
                ],
            ],
            'problems' => [
                'heading' => 'Problems We Solve',
                'description' => 'Websites that are not maintained slowly lose security, speed, and reliability. We solve the risks that build up over time.',
                'items' => [
                    ['title' => 'Outdated Software', 'description' => 'Unupdated software becomes incompatible and insecure over time.'],
                    ['title' => 'Security Vulnerabilities', 'description' => 'Unpatched websites are a target for attacks.'],
                    ['title' => 'Slow Website Performance', 'description' => 'Performance degrades without regular optimisation.'],
                    ['title' => 'Broken Features', 'description' => 'Updates and conflicts can break features without warning.'],
                    ['title' => 'Compatibility Issues', 'description' => 'Browsers and devices evolve, and websites can fall behind.'],
                    ['title' => 'Missing Backups', 'description' => 'Without backups, a single failure can mean losing your website.'],
                    ['title' => 'Downtime', 'description' => 'Unmonitored websites can go down without anyone noticing.'],
                    ['title' => 'Lack of Technical Support', 'description' => 'When problems happen, businesses often have nowhere to turn.'],
                ],
            ],
            'solution' => [
                'heading' => 'Our Solution',
                'description' => 'SMEvolve provides proactive website maintenance rather than waiting for problems to occur.',
                'points' => [
                    'Preventive maintenance that stops issues before they start.',
                    'Regular updates for software, plugins, and dependencies.',
                    'Security monitoring and malware checks.',
                    'Performance optimisation and backup management.',
                    'Ongoing technical support from a real team.',
                ],
            ],
            'features' => [
                'heading' => 'Key Features',
                'description' => 'Ongoing services that keep your website healthy and reliable.',
                'items' => [
                    ['icon' => 'clipboard-document-list', 'title' => 'CMS Updates', 'description' => 'Keep your CMS current and compatible.'],
                    ['icon' => 'rectangle-stack', 'title' => 'Plugin & Dependency Updates', 'description' => 'Update plugins and dependencies safely.'],
                    ['icon' => 'shield-check', 'title' => 'Security Monitoring', 'description' => 'Watch for threats and respond promptly.'],
                    ['icon' => 'magnifying-glass', 'title' => 'Malware Checks', 'description' => 'Scan regularly to detect and remove malware.'],
                    ['icon' => 'database', 'title' => 'Website Backups', 'description' => 'Protect your content with reliable backups.'],
                    ['icon' => 'bolt', 'title' => 'Performance Optimization', 'description' => 'Keep your website fast and efficient.'],
                    ['icon' => 'wrench', 'title' => 'Bug Fixes', 'description' => 'Resolve issues quickly when they appear.'],
                    ['icon' => 'pencil', 'title' => 'Content Updates', 'description' => 'Assist with content updates where applicable.'],
                    ['icon' => 'activity', 'title' => 'Uptime Monitoring', 'description' => 'Know immediately when your website goes down.'],
                    ['icon' => 'link', 'title' => 'Broken Link Checks', 'description' => 'Find and fix broken links that hurt user experience.'],
                    ['icon' => 'chat-bubble-left-right', 'title' => 'Technical Support', 'description' => 'Expert help when you need it.'],
                ],
            ],
            'benefits' => [
                'heading' => 'Business Benefits',
                'description' => 'Ongoing maintenance protects the investment you have made in your website.',
                'items' => [
                    ['icon' => 'shield-check', 'title' => 'Improved Website Security', 'description' => 'Stay protected against threats and attacks.'],
                    ['icon' => 'bolt', 'title' => 'Better Performance', 'description' => 'A fast website keeps visitors and search engines happy.'],
                    ['icon' => 'activity', 'title' => 'Reduced Downtime', 'description' => 'Issues are caught early before they affect visitors.'],
                    ['icon' => 'arrow-right', 'title' => 'Longer Website Lifespan', 'description' => 'Well-maintained websites last longer and work better.'],
                    ['icon' => 'magnifying-glass', 'title' => 'Better Search Engine Performance', 'description' => 'Healthy websites are more likely to rank well.'],
                    ['icon' => 'shield-check', 'title' => 'Lower Risk of Technical Issues', 'description' => 'Preventive care reduces the chance of problems.'],
                    ['icon' => 'heart', 'title' => 'Peace of Mind', 'description' => 'Focus on your business, knowing your website is in good hands.'],
                ],
            ],
            'technologies' => [
                'heading' => 'Technologies We Support',
                'description' => 'We maintain websites built on the technologies your business depends on.',
                'items' => ['Laravel', 'WordPress', 'PHP', 'MySQL', 'Cloud Hosting Platforms', 'Monitoring Services', 'Backup Solutions', 'Security Tools'],
            ],
            'faqs' => [
                ['question' => 'Why is website maintenance important?', 'answer' => 'Regular maintenance keeps your website secure, fast, compatible, and reliable, protecting your business from downtime, attacks, and lost customers.'],
                ['question' => 'How often should a website be updated?', 'answer' => 'Updates depend on your platform and how actively you use it. We recommend a regular schedule and will advise on what fits your website.'],
                ['question' => 'Do you maintain websites built by other companies?', 'answer' => 'Yes. We can take over maintenance for websites built by other companies, subject to an initial review.'],
                ['question' => 'What happens if my website has a problem?', 'answer' => 'If an issue arises, our team investigates and resolves it, keeping you informed throughout.'],
                ['question' => 'Are backups included?', 'answer' => 'Yes. Reliable backups are part of our maintenance approach so your content and data are protected.'],
                ['question' => 'Can maintenance plans be customized?', 'answer' => 'Yes. Plans can be tailored to the size of your website, your platform, and the level of support you need.'],
            ],
            'related' => ['website-development', 'wordpress-development', 'laravel-development', 'business-automation'],
        ];
    }
}
