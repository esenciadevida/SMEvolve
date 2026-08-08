<?php

namespace App\Data;

class AboutData
{
    /**
     * Company overview paragraphs.
     *
     * @return array<int, string>
     */
    public function overview(): array
    {
        return [
            'SMEvolve is a technology company focused on solving real business challenges through practical, scalable, and reliable software solutions.',
            "We don't believe in one-size-fits-all products. Every solution is tailored to the way your business works, so the technology supports your goals instead of getting in the way.",
            'From modern websites and e-commerce stores to custom software and business automation, we measure success by the outcomes we create: improved efficiency, stronger online presence, and long-term growth.',
        ];
    }

    /**
     * Our Story narrative paragraphs.
     *
     * @return array<int, string>
     */
    public function story(): array
    {
        return [
            'SMEvolve was built on a simple belief: technology should help businesses grow, simplify operations, and create opportunities, not create unnecessary complexity.',
            "Many businesses struggle not because they lack tools, but because the tools they use don't fit their needs. Off-the-shelf software and generic templates often fall short of what a business actually requires.",
            'SMEvolve exists to bridge that gap. We deliver tailored, practical, and scalable digital solutions that align with real business goals, built for solving challenges, building long-term partnerships, and creating measurable value.',
        ];
    }

    /**
     * Key principles highlighted in the Our Story section.
     *
     * @return array<int, array{statement: string, icon: string}>
     */
    public function principles(): array
    {
        return [
            ['statement' => 'Every business is unique.', 'icon' => 'command-line'],
            ['statement' => 'Listen before building.', 'icon' => 'chat-bubble-left-right'],
            ['statement' => 'Simplicity creates better experiences.', 'icon' => 'sparkles'],
            ['statement' => 'Quality matters more than shortcuts.', 'icon' => 'shield-check'],
            ['statement' => 'Technology should support growth.', 'icon' => 'rocket-launch'],
        ];
    }

    /**
     * Company philosophy pillars for the team section.
     *
     * @return array<int, array{title: string, description: string, icon: string, points: array<int, string>}>
     */
    public function philosophyPillars(): array
    {
        return [
            [
                'title' => 'Collaboration',
                'description' => 'We work closely with clients throughout every project, treating their goals as our own. Great solutions are never built in isolation, they come from shared understanding, honest feedback, and a working relationship that feels like an extension of your own team.',
                'icon' => 'heart',
                'points' => [
                    'We listen first and ask the right questions before we build.',
                    'You stay informed at every stage, no surprises, no guesswork.',
                    'Your business goals guide every decision we make together.',
                ],
            ],
            [
                'title' => 'Continuous Learning',
                'description' => 'Our team grows with every project, applying lessons learned to build better solutions. Technology moves quickly, and we do too, investing in new skills, sharper processes, and proven patterns so your project benefits from everything we have learned.',
                'icon' => 'academic-cap',
                'points' => [
                    'We stay current with modern tools, frameworks, and best practices.',
                    'Every project improves the next through documented lessons.',
                    'We test, refine, and iterate until the result is right.',
                ],
            ],
            [
                'title' => 'Value-Driven',
                'description' => 'Every solution is measured by the value it creates for the business it serves. We judge our work by outcomes, time saved, efficiency gained, revenue protected, rather than how impressive the technology looks on paper.',
                'icon' => 'target',
                'points' => [
                    'We focus on the features that genuinely move your business forward.',
                    'We make pragmatic choices that balance quality, speed, and cost.',
                    'We report on results and impact, not just activity.',
                ],
            ],
        ];
    }

    /**
     * Public team profiles.
     *
     * Empty until real team profiles are published. The team section renders a
     * company philosophy instead of fictional member cards.
     *
     * @return array<int, array{name: string, role: string, bio: string, image: string|null, linkedin: string|null}>
     */
    public function team(): array
    {
        return [];
    }
}
