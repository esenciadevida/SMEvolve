<?php

namespace App\Services\AI;

use RuntimeException;

class AIException extends RuntimeException
{
    public static function disabled(): self
    {
        return new self('The AI system is currently disabled.');
    }

    public static function featureDisabled(string $feature): self
    {
        return new self("The {$feature} feature is currently disabled.");
    }

    public static function notConfigured(): self
    {
        return new self('The AI provider is not configured. Please check the environment configuration.');
    }

    public static function emptyResponse(): self
    {
        return new self('The AI provider returned an empty response.');
    }
}
