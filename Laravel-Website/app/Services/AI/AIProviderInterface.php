<?php

namespace App\Services\AI;

interface AIProviderInterface
{
    /**
     * @param  array<int, array{role: string, content: string}>  $messages
     * @param  array<string, mixed>  $options
     */
    public function generate(array $messages, array $options = []): AIResponse;

    public function isConfigured(): bool;

    public function name(): string;
}
