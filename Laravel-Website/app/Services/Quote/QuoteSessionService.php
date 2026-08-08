<?php

namespace App\Services\Quote;

use App\Models\Conversation;
use App\Models\QuoteSession;
use App\Services\AI\ConversationService;
use Illuminate\Support\Str;

class QuoteSessionService
{
    public function __construct(private readonly ConversationService $conversationService) {}

    /**
     * Create a new quote session, backed by a conversation record.
     */
    public function create(?string $sessionId = null): QuoteSession
    {
        $sessionId = $sessionId ?: (string) Str::uuid();

        $conversation = $this->conversationService->start($sessionId, 'quote');

        $session = QuoteSession::create([
            'conversation_id' => $conversation->id,
            'session_id' => $sessionId,
            'status' => QuoteSession::STATUS_STARTED,
            'current_step' => 1,
            'started_at' => now(),
            'last_activity_at' => now(),
            'expires_at' => now()->addMinutes((int) config('quote.session.expires_after_minutes', 4320)),
        ]);

        return $session;
    }

    /**
     * Find a session by its public UUID, including required relationships.
     */
    public function findByPublicId(string $uuid): ?QuoteSession
    {
        return QuoteSession::with(['answers', 'submission', 'sessionRequirements.quoteRequirement'])
            ->where('uuid', $uuid)
            ->first();
    }

    /**
     * The most recent active session for a client, so a returning visitor can
     * continue where they left off instead of accumulating new sessions.
     */
    public function latestActiveFor(string $sessionId): ?QuoteSession
    {
        return QuoteSession::with(['answers', 'submission', 'sessionRequirements.quoteRequirement'])
            ->where('session_id', $sessionId)
            ->whereNotIn('status', [
                QuoteSession::STATUS_SUBMITTED,
                QuoteSession::STATUS_ABANDONED,
                QuoteSession::STATUS_EXPIRED,
            ])
            ->latest('id')
            ->first();
    }

    public function touch(QuoteSession $session): void
    {
        $session->touchActivity();
    }

    public function markReview(QuoteSession $session): void
    {
        $session->markReview();
    }

    public function markSubmitted(QuoteSession $session): void
    {
        $session->markSubmitted();
    }

    /**
     * Ensure any expired sessions are marked expired before use.
     */
    public function refreshExpiry(QuoteSession $session): QuoteSession
    {
        if ($session->isExpired() && $session->status !== QuoteSession::STATUS_EXPIRED) {
            $session->markExpired();
        }

        return $session;
    }

    /**
     * Touch the conversation to keep it active.
     */
    public function touchConversation(QuoteSession $session): void
    {
        if ($session->conversation_id !== null) {
            $conversation = Conversation::find($session->conversation_id);
            if ($conversation !== null) {
                $this->conversationService->markActive($conversation);
            }
        }
    }
}
