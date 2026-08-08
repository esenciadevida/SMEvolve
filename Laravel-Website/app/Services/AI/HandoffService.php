<?php

namespace App\Services\AI;

use App\Models\AiHandoff;
use App\Models\Conversation;
use App\Models\QuoteSession;
use Illuminate\Support\Arr;

class HandoffService
{
    public function request(
        Conversation $conversation,
        string $reason,
        array $metadata = [],
        ?QuoteSession $quoteSession = null
    ): AiHandoff {
        $reason = in_array($reason, AiHandoff::REASONS, true) ? $reason : 'user_requested';

        return AiHandoff::create([
            'conversation_id' => $conversation->id,
            'quote_session_id' => $quoteSession?->id,
            'reason' => $reason,
            'status' => AiHandoff::STATUS_REQUESTED,
            'requested_at' => now(),
            'metadata' => $metadata,
        ]);
    }

    /**
     * Contact options surfaced to the visitor when a human handoff is needed.
     *
     * @return array<string, mixed>
     */
    public function contactOptions(): array
    {
        $contact = config('company.contact', []);

        return [
            'email' => $contact['email'] ?? null,
            'phone' => $contact['phone'] ?? null,
            'whatsapp' => $contact['whatsapp'] ?? null,
            'contact_url' => route('contact'),
            'quote_url' => route('quote'),
        ];
    }

    public function openRequests(int $limit = 10): array
    {
        return AiHandoff::query()
            ->with(['conversation:id,uuid,status'])
            ->whereIn('status', [AiHandoff::STATUS_REQUESTED, AiHandoff::STATUS_IN_PROGRESS])
            ->orderByDesc('id')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function resolve(AiHandoff $handoff): AiHandoff
    {
        $handoff->forceFill([
            'status' => AiHandoff::STATUS_RESOLVED,
            'resolved_at' => now(),
        ])->save();

        return $handoff;
    }

    /**
     * @param  array<string, mixed>  $metadata
     */
    public function mergeMetadata(AiHandoff $handoff, array $metadata): AiHandoff
    {
        $handoff->forceFill([
            'metadata' => Arr::merge($handoff->metadata ?? [], $metadata),
        ])->save();

        return $handoff;
    }
}
