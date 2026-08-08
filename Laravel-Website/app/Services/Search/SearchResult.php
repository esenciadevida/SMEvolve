<?php

namespace App\Services\Search;

class SearchResult
{
    /**
     * @param  array<string, mixed>  $metadata
     */
    public function __construct(
        public readonly string $type,
        public readonly int|string $id,
        public readonly string $title,
        public readonly string $subtitle,
        public readonly string $url,
        public readonly array $metadata = [],
    ) {
    }

    /**
     * @return array{type: string, id: int|string, title: string, subtitle: string, url: string, metadata: array<string, mixed>}
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'url' => $this->url,
            'metadata' => $this->metadata,
        ];
    }
}
