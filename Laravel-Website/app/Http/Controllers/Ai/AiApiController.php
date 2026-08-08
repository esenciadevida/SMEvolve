<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ai\CreateConversationRequest;
use App\Http\Requests\Ai\CreateQuoteSessionRequest;
use App\Http\Requests\Ai\RequestHandoffRequest;
use App\Http\Requests\Ai\SendMessageRequest;
use App\Http\Requests\Ai\StoreQuoteAnswerRequest;
use App\Http\Requests\Ai\SubmitQuoteRequest;
use App\Models\Conversation;
use App\Models\QuoteSession;
use App\Services\AI\AiConfigService;
use App\Services\AI\AIException;
use App\Services\AI\AiService;
use App\Services\AI\ConversationService;
use App\Services\AI\HandoffService;
use App\Services\AI\QuoteAiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiApiController extends Controller
{
    public function __construct(
        private readonly AiConfigService $configService,
        private readonly ConversationService $conversationService,
        private readonly AiService $aiService,
        private readonly QuoteAiService $quoteAiService,
        private readonly HandoffService $handoffService,
    ) {}

    public function status(Request $request): JsonResponse
    {
        $sessionId = $request->input('session_id');

        $conversation = null;
        if (is_string($sessionId) && $sessionId !== '') {
            $conversation = $this->conversationService->latestForSession($sessionId);
        }

        return response()->json([
            'enabled' => $this->configService->assistantEnabled(),
            'welcome_message' => $this->configService->welcomeMessage(),
            'availability_message' => $this->configService->availabilityMessage(),
            'conversation_uuid' => $conversation?->uuid,
        ]);
    }

    public function storeConversation(CreateConversationRequest $request): JsonResponse
    {
        if (! $this->configService->assistantEnabled()) {
            return response()->json([
                'message' => $this->configService->availabilityMessage(),
                'enabled' => false,
            ], 503);
        }

        $conversation = $this->conversationService->start(
            $request->validated('session_id'),
            (string) $request->validated('channel', 'website'),
        );

        return response()->json([
            'conversation' => [
                'uuid' => $conversation->uuid,
            ],
            'welcome_message' => $this->configService->welcomeMessage(),
            'enabled' => true,
        ], 201);
    }

    public function sendMessage(SendMessageRequest $request, Conversation $conversation): JsonResponse
    {
        $sessionId = $request->validated('session_id');

        if (! $this->conversationService->findForSession($conversation->uuid, $sessionId)) {
            return response()->json(['message' => 'Conversation not found.'], 404);
        }

        if (! $this->configService->assistantEnabled()) {
            return response()->json([
                'message' => $this->configService->availabilityMessage(),
                'enabled' => false,
            ], 503);
        }

        if ($this->conversationService->requestCount($conversation) >= (int) config('ai.limits.max_requests_per_session')) {
            return response()->json(['message' => 'This conversation has reached its limit. Please start a new chat.'], 429);
        }

        try {
            $result = $this->aiService->chat($conversation, (string) $request->validated('message'));
        } catch (AIException $e) {
            return response()->json(['message' => $e->getMessage()], 502);
        }

        return response()->json([
            'conversation' => ['uuid' => $conversation->uuid],
            'reply' => $result['content'],
            'usage' => [
                'total_tokens' => $result['usage']->total_tokens,
                'response_time_ms' => $result['usage']->response_time_ms,
            ],
        ]);
    }

    public function storeQuoteSession(CreateQuoteSessionRequest $request): JsonResponse
    {
        if (! $this->configService->quoteEnabled()) {
            return response()->json(['message' => 'The Quote Wizard is currently unavailable.'], 503);
        }

        $sessionId = $request->validated('session_id');

        $conversation = $this->conversationService->start($sessionId, 'quote');

        $quoteSession = QuoteSession::create([
            'conversation_id' => $conversation->id,
            'session_id' => $sessionId,
            'status' => QuoteSession::STATUS_STARTED,
            'current_step' => 1,
            'started_at' => now(),
        ]);

        return response()->json([
            'quote_session' => ['uuid' => $quoteSession->uuid],
        ], 201);
    }

    public function storeQuoteAnswer(StoreQuoteAnswerRequest $request, QuoteSession $quoteSession): JsonResponse
    {
        if (! $quoteSession->isOwnedBy($request->validated('session_id'))) {
            return response()->json(['message' => 'Quote session not found.'], 404);
        }

        $data = $request->validated();

        $quoteSession->answers()->updateOrCreate(
            ['question_key' => $data['question_key']],
            [
                'question' => $data['question'] ?? null,
                'answer' => $data['answer'],
                'answer_type' => $data['answer_type'] ?? 'text',
                'source' => 'user',
                'confirmed_at' => now(),
            ]
        );

        $quoteSession->forceFill([
            'status' => QuoteSession::STATUS_IN_PROGRESS,
            'current_step' => max(1, $quoteSession->answers()->count() + 1),
        ])->save();

        return response()->json(['ok' => true]);
    }

    public function analyzeQuote(Request $request, QuoteSession $quoteSession): JsonResponse
    {
        $sessionId = (string) $request->input('session_id');

        if (! $quoteSession->isOwnedBy($sessionId)) {
            return response()->json(['message' => 'Quote session not found.'], 404);
        }

        if (! $this->configService->quoteEnabled()) {
            return response()->json(['message' => 'The Quote Wizard is currently unavailable.'], 503);
        }

        if ($quoteSession->answers()->count() === 0) {
            return response()->json(['message' => 'No answers recorded yet.'], 422);
        }

        try {
            $analysis = $this->quoteAiService->analyze($quoteSession);
        } catch (AIException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json([
            'quote_session' => ['uuid' => $quoteSession->uuid],
            'analysis' => $analysis,
        ]);
    }

    public function submitQuote(SubmitQuoteRequest $request, QuoteSession $quoteSession): JsonResponse
    {
        if (! $quoteSession->isOwnedBy($request->validated('session_id'))) {
            return response()->json(['message' => 'Quote session not found.'], 404);
        }

        if ($quoteSession->status === QuoteSession::STATUS_SUBMITTED) {
            return response()->json(['message' => 'This quote has already been submitted.'], 422);
        }

        $quoteSession->forceFill([
            'status' => QuoteSession::STATUS_SUBMITTED,
            'submitted_at' => now(),
            'contact_name' => $request->validated('contact_name'),
            'contact_email' => $request->validated('contact_email'),
            'contact_phone' => $request->validated('contact_phone'),
        ])->save();

        return response()->json(['ok' => true, 'message' => 'Thank you! Your request has been received.']);
    }

    public function requestHandoff(RequestHandoffRequest $request, ?Conversation $conversation = null): JsonResponse
    {
        $sessionId = $request->validated('session_id');
        $message = $request->validated('message');

        $target = $conversation;
        if ($target === null) {
            $target = $this->conversationService->latestForSession($sessionId);
        }

        if ($target === null || ! $target->isOwnedBy($sessionId)) {
            return response()->json(['message' => 'Conversation not found.'], 404);
        }

        if (is_string($message) && $message !== '') {
            $this->conversationService->appendMessage($target, 'user', $message, ['status' => 'stored']);
        }

        $this->handoffService->request($target, $request->validated('reason'), [
            'visitor_message' => $message,
        ]);

        return response()->json([
            'message' => 'Thanks, the SMEvolve team will get back to you. In the meantime you can reach us directly.',
            'contact' => $this->handoffService->contactOptions(),
        ]);
    }
}
