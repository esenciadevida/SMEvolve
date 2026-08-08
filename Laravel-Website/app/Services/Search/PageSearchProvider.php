<?php

namespace App\Services\Search;

use Illuminate\Support\Collection;

class PageSearchProvider extends AbstractInMemorySearchProvider
{
    public function __construct()
    {
        parent::__construct('pages', 'Pages');
    }

    protected function searchRecords(string $query, int $limit): Collection
    {
        return $this->rank(collect($this->pages()), $query, ['title', 'description', 'keywords'], 'title');
    }

    protected function normalizeResult(mixed $record): ?SearchResult
    {
        if (! is_array($record) || empty($record['route'])) {
            return null;
        }

        return new SearchResult(
            type: 'page',
            id: $record['route'],
            title: $record['title'],
            subtitle: $record['description'] ?? '',
            url: route($record['route']),
            metadata: [
                'icon' => $record['icon'] ?? 'document-text',
            ],
        );
    }

    /**
     * @return array<int, array{title: string, route: string, description: string, keywords: string, icon: string}>
     */
    private function pages(): array
    {
        return [
            [
                'title' => 'Home',
                'route' => 'home',
                'description' => 'SMEvolve helps small and medium businesses grow online with websites, e-commerce, software, mobile apps, and AI solutions.',
                'keywords' => 'smevolve home digital agency solutions',
                'icon' => 'home',
            ],
            [
                'title' => 'About Us',
                'route' => 'about',
                'description' => 'Learn about SMEvolve and the team behind our websites, software, and digital solutions.',
                'keywords' => 'about company team agency',
                'icon' => 'user-group',
            ],
            [
                'title' => 'Services',
                'route' => 'services.index',
                'description' => 'Explore our services: website development, e-commerce, custom software, mobile apps, AI, and automation.',
                'keywords' => 'services development software',
                'icon' => 'globe-alt',
            ],
            [
                'title' => 'Packages',
                'route' => 'packages',
                'description' => 'Transparent website packages and custom solution pricing for growing businesses.',
                'keywords' => 'packages pricing plans cost',
                'icon' => 'shopping-bag',
            ],
            [
                'title' => 'Portfolio',
                'route' => 'portfolio',
                'description' => 'Browse recent SMEvolve projects and how we build for real business needs.',
                'keywords' => 'portfolio projects work case studies',
                'icon' => 'photo',
            ],
            [
                'title' => 'FAQ',
                'route' => 'faq',
                'description' => 'Find answers to questions about services, pricing, development, support, and more.',
                'keywords' => 'faq help answers questions',
                'icon' => 'lifebuoy',
            ],
            [
                'title' => 'Contact',
                'route' => 'contact',
                'description' => 'Get in touch with the SMEvolve team to discuss your next project.',
                'keywords' => 'contact reach us phone email',
                'icon' => 'chat-bubble-left-right',
            ],
            [
                'title' => 'Get a Free Quote',
                'route' => 'quote',
                'description' => 'Request a free, no-obligation quote for your project.',
                'keywords' => 'quote proposal estimate wizard',
                'icon' => 'document-text',
            ],
            [
                'title' => 'Privacy Policy',
                'route' => 'privacy-policy.index',
                'description' => 'How SMEvolve collects, uses, and protects your information.',
                'keywords' => 'privacy policy data',
                'icon' => 'shield-check',
            ],
            [
                'title' => 'Terms & Conditions',
                'route' => 'terms.index',
                'description' => 'The terms governing use of the SMEvolve website and services.',
                'keywords' => 'terms conditions',
                'icon' => 'document-text',
            ],
            [
                'title' => 'Cookie Policy',
                'route' => 'cookies.index',
                'description' => 'How SMEvolve uses cookies and similar technologies.',
                'keywords' => 'cookies policy',
                'icon' => 'document-text',
            ],
        ];
    }
}
