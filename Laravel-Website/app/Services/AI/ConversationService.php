<?php

namespace App\Services\AI;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ConversationService
{
    public function start(string $sessionId, string $channel = 'website', ?string $visitorId = null): Conversation
    {
        return Conversation::create([
            'session_id' => $sessionId,
            'channel' => $channel,
            'visitor_id' => $visitorId,
            'status' => Conversation::STATUS_ACTIVE,
            'started_at' => now(),
            'last_message_at' => now(),
            'expires_at' => now()->addDays((int) config('ai.limits.conversation_retention_days', 30)),
        ]);
    }

    public function findForSession(string $uuid, string $sessionId): ?Conversation
    {
        $conversation = Conversation::where('uuid', $uuid)->first();

        if ($conversation === null || ! $conversation->isOwnedBy($sessionId)) {
            return null;
        }

        return $conversation->isAccessible() ? $conversation : null;
    }

    public function latestForSession(string $sessionId): ?Conversation
    {
        return Conversation::where('session_id', $sessionId)
            ->orderByDesc('id')
            ->first();
    }

    /**
     * @return Collection<int, array{role: string, content: string}>
     */
    public function contextMessages(Conversation $conversation, int $limit = 15): Collection
    {
        return $conversation->messages()
            ->whereIn('role', [Message::ROLE_USER, Message::ROLE_ASSISTANT])
            ->orderByDesc('id')
            ->limit($limit)
            ->get()
            ->reverse()
            ->map(fn (Message $message) => [
                'role' => $message->role,
                'content' => $message->content,
            ]);
    }

    public function appendMessage(
        Conversation $conversation,
        string $role,
        string $content,
        array $attributes = []
    ): Message {
        return $conversation->messages()->create([
            'role' => $role,
            'content' => $content,
            ...$attributes,
        ]);
    }

    public function markActive(Conversation $conversation): void
    {
        $conversation->forceFill([
            'status' => Conversation::STATUS_ACTIVE,
            'last_message_at' => now(),
        ])->save();
    }

    public function complete(Conversation $conversation): void
    {
        $conversation->forceFill([
            'status' => Conversation::STATUS_COMPLETED,
            'completed_at' => now(),
        ])->save();
    }

    public function requestCount(Conversation $conversation): int
    {
        return $conversation->messages()
            ->where('role', Message::ROLE_USER)
            ->count();
    }

    public function newSessionId(): string
    {
        return Str::uuid()->toString();
    }
}
