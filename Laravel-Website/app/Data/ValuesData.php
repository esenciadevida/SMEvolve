<?php

namespace App\Data;

class ValuesData
{
    /**
     * Core company values displayed on the About page.
     *
     * @return array<int, array{title: string, description: string, icon: string}>
     */
    public function all(): array
    {
        return [
            ['title' => 'Business First', 'description' => 'We focus on understanding business goals before recommending technology.', 'icon' => 'target'],
            ['title' => 'Quality', 'description' => 'We build reliable, maintainable, and scalable solutions that stand the test of time.', 'icon' => 'shield-check'],
            ['title' => 'Transparency', 'description' => 'We communicate openly, provide honest recommendations, and keep clients informed throughout every project.', 'icon' => 'chat-bubble-left-right'],
            ['title' => 'Innovation', 'description' => 'We embrace modern technologies and continuous learning to deliver practical solutions.', 'icon' => 'sparkles'],
            ['title' => 'Partnership', 'description' => 'We believe successful projects are built through collaboration, trust, and long-term relationships.', 'icon' => 'heart'],
            ['title' => 'Continuous Improvement', 'description' => 'We constantly refine our processes, technologies, and solutions to deliver better outcomes.', 'icon' => 'rocket-launch'],
        ];
    }
}
