<?php

namespace App\Data\Portfolio;

class ProjectCategories
{
    /**
     * Official portfolio project categories.
     *
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        return [
            [
                'slug' => 'websites',
                'name' => 'Website Development',
                'icon' => 'globe-alt',
                'description' => 'Business websites, corporate sites, landing pages, and informational websites built to establish credibility and support growth.',
                'seoTitle' => 'Websites & Web Design Projects',
                'seoDescription' => 'Explore SMEvolve website projects, business websites, corporate sites, and landing pages built around clear business goals.',
                'order' => 1,
            ],
            [
                'slug' => 'ecommerce',
                'name' => 'E-commerce Development',
                'icon' => 'shopping-cart',
                'description' => 'Online stores and digital commerce platforms designed for a smooth shopping experience and reliable order management.',
                'seoTitle' => 'E-commerce Store Projects',
                'seoDescription' => 'Explore SMEvolve e-commerce projects, online stores built for secure checkout, simple management, and business growth.',
                'order' => 2,
            ],
            [
                'slug' => 'custom-software',
                'name' => 'Custom Software',
                'icon' => 'rectangle-stack',
                'description' => 'Business systems developed specifically for client requirements, from dashboards to full management platforms.',
                'seoTitle' => 'Custom Software Projects',
                'seoDescription' => 'Explore SMEvolve custom software projects, business systems built around your workflows, data, and long-term goals.',
                'order' => 3,
            ],
            [
                'slug' => 'mobile-apps',
                'name' => 'Mobile Applications',
                'icon' => 'device-mobile',
                'description' => 'Native and cross-platform mobile applications designed to improve customer engagement and business operations.',
                'seoTitle' => 'Mobile App Projects',
                'seoDescription' => 'Explore SMEvolve mobile application projects, apps designed for usability, security, and long-term maintainability.',
                'order' => 4,
            ],
            [
                'slug' => 'ai-solutions',
                'name' => 'AI Solutions',
                'icon' => 'cpu-chip',
                'description' => 'Projects that use artificial intelligence to improve business operations or customer experiences.',
                'seoTitle' => 'AI Solution Projects',
                'seoDescription' => 'Explore SMEvolve AI projects, intelligent assistants, knowledge tools, and AI-powered experiences built for real business needs.',
                'order' => 5,
            ],
            [
                'slug' => 'business-automation',
                'name' => 'Business Automation',
                'icon' => 'bolt',
                'description' => 'Workflow automation and process optimisation projects that reduce manual work and improve efficiency.',
                'seoTitle' => 'Business Automation Projects',
                'seoDescription' => 'Explore SMEvolve business automation projects, workflows, approvals, and reporting built to save time and reduce errors.',
                'order' => 6,
            ],
            [
                'slug' => 'api-development',
                'name' => 'API Development',
                'icon' => 'code',
                'description' => 'Projects focused on integrations and software communication, from payment gateways to third-party systems.',
                'seoTitle' => 'API Development & Integration Projects',
                'seoDescription' => 'Explore SMEvolve API projects, integrations and system connections that enable reliable data exchange.',
                'order' => 7,
            ],
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function find(string $slug): ?array
    {
        return collect($this->all())->firstWhere('slug', $slug);
    }
}
