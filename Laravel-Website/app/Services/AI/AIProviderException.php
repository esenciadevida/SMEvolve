<?php

namespace App\Services\AI;

class AIProviderException extends AIException
{
    public function __construct(
        string $message,
        public readonly ?int $statusCode = null,
        public readonly ?string $errorType = null,
        public readonly ?string $provider = null,
        public readonly ?string $requestId = null,
    ) {
        parent::__construct($message);
    }

    public static function fromResponse(string $message, int $statusCode): self
    {
        return new self($message, statusCode: $statusCode, errorType: 'http_error');
    }

    public static function network(string $message): self
    {
        return new self($message, errorType: 'network_error');
    }

    public static function timeout(string $message): self
    {
        return new self($message, errorType: 'timeout');
    }

    public static function invalidResponse(string $message): self
    {
        return new self($message, errorType: 'invalid_response');
    }
}
