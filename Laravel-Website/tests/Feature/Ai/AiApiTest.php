<?php

namespace Tests\Feature\Ai;

use App\Models\Conversation;
use App\Models\QuoteSession;
use App\Services\AI\AiConfigService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class AiApiTest extends TestCase
{
    use DatabaseTransactions;

    private string $sessionId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sessionId = (string) Str::uuid();

        config()->set('ai.groq.api_key', 'test-key');
        config()->set('ai.assistant.enabled', true);
        config()->set('ai.quote.enabled', true);
        config()->set('ai.enabled', true);
    }

    private function fakeGroq(string $content = 'Hello from SMEvolve AI.'): void
    {
        Http::fake([
            'api.groq.com/*' => Http::response([
                'id' => 'chatcmpl-test',
                'model' => 'llama-3.3-70b-versatile',
                'choices' => [
                    ['message' => ['role' => 'assistant', 'content' => $content]],
                ],
                'usage' => [
                    'prompt_tokens' => 25,
                    'completion_tokens' => 40,
                    'total_tokens' => 65,
                ],
            ], 200),
        ]);
    }

    public function test_status_endpoint_reports_configuration(): void
    {
        $this->getJson(route('ai.api.status'))
            ->assertOk()
            ->assertJsonPath('enabled', true)
            ->assertJsonPath('welcome_message', config('ai.assistant.welcome_message'))
            ->assertJsonStructure(['enabled', 'welcome_message', 'availability_message', 'conversation_uuid']);
    }

    public function test_create_conversation_returns_uuid(): void
    {
        $this->postJson(route('ai.api.conversations.store'), [
            'session_id' => $this->sessionId,
            'channel' => 'website',
        ])
            ->assertCreated()
            ->assertJsonPath('enabled', true)
            ->assertJsonStructure(['conversation' => ['uuid'], 'welcome_message']);

        $this->assertDatabaseHas('conversations', ['session_id' => $this->sessionId]);
    }

    public function test_create_conversation_rejects_invalid_session_id(): void
    {
        $this->postJson(route('ai.api.conversations.store'), ['session_id' => 'not-a-valid-id!!'])
            ->assertStatus(422)
            ->assertJsonValidationErrors('session_id');
    }

    public function test_send_message_persists_reply_and_usage(): void
    {
        $this->fakeGroq('Yes, we build e-commerce websites.');

        $conversation = $this->createConversation();

        $this->postJson(route('ai.api.conversations.messages', $conversation->uuid), [
            'session_id' => $this->sessionId,
            'message' => 'Do you build online stores?',
        ])
            ->assertOk()
            ->assertJsonPath('reply', 'Yes, we build e-commerce websites.')
            ->assertJsonStructure(['reply', 'usage' => ['total_tokens', 'response_time_ms']]);

        $this->assertSame(2, $conversation->messages()->count());
        $this->assertSame('user', $conversation->messages()->first()->role);
        $this->assertSame('assistant', $conversation->messages()->latest('id')->first()->role);

        $this->assertDatabaseHas('ai_usage', [
            'conversation_id' => $conversation->id,
            'status' => 'success',
            'total_tokens' => 65,
        ]);
    }

    public function test_send_message_rejects_wrong_session_owner(): void
    {
        $this->fakeGroq();

        $conversation = $this->createConversation();

        $this->postJson(route('ai.api.conversations.messages', $conversation->uuid), [
            'session_id' => (string) Str::uuid(),
            'message' => 'hello',
        ])
            ->assertNotFound();
    }

    public function test_send_message_validates_input(): void
    {
        $conversation = $this->createConversation();

        $this->postJson(route('ai.api.conversations.messages', $conversation->uuid), [
            'session_id' => $this->sessionId,
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('message');
    }

    public function test_assistant_returns_unavailable_when_disabled(): void
    {
        app(AiConfigService::class)
            ->set('assistant.enabled', false, 'test');

        $this->postJson(route('ai.api.conversations.store'), [
            'session_id' => $this->sessionId,
        ])
            ->assertStatus(503)
            ->assertJsonPath('enabled', false);
    }

    public function test_quote_session_flow_analyzes_and_submits(): void
    {
        $this->fakeGroq(json_encode([
            'project_type' => 'E-commerce website',
            'industry' => 'Retail',
            'requirements' => ['Online store', 'Payment integration'],
            'recommended_service' => 'ecommerce-development',
            'recommended_package' => 'ecommerce',
            'complexity' => 'medium',
            'lead_score' => 78,
            'summary' => 'A retail business needs an online store with payments.',
        ]));

        $create = $this->postJson(route('ai.api.quotes.store'), [
            'session_id' => $this->sessionId,
        ])->assertCreated();

        $uuid = $create->json('quote_session.uuid');

        $this->postJson(route('ai.api.quotes.answers', $uuid), [
            'session_id' => $this->sessionId,
            'question_key' => 'project_description',
            'question' => 'Describe your project',
            'answer' => 'I sell clothes and need an online store',
            'answer_type' => 'text',
        ])->assertOk();

        $this->assertDatabaseHas('quote_answers', ['question_key' => 'project_description']);

        $this->postJson(route('ai.api.quotes.analyze', $uuid), [
            'session_id' => $this->sessionId,
        ])
            ->assertOk()
            ->assertJsonPath('analysis.recommended_service', 'ecommerce-development')
            ->assertJsonPath('analysis.lead_score', 78);

        $this->postJson(route('ai.api.quotes.submit', $uuid), [
            'session_id' => $this->sessionId,
            'contact_name' => 'Ada Lovelace',
            'contact_email' => 'ada@example.com',
            'contact_phone' => '+2348000000000',
        ])
            ->assertOk()
            ->assertJsonPath('ok', true);

        $session = QuoteSession::where('uuid', $uuid)->first();
        $this->assertSame('submitted', $session->status);
        $this->assertSame('ada@example.com', $session->contact_email);
    }

    public function test_quote_session_requires_ownership(): void
    {
        $this->fakeGroq('{}');

        $create = $this->postJson(route('ai.api.quotes.store'), [
            'session_id' => $this->sessionId,
        ])->assertCreated();

        $uuid = $create->json('quote_session.uuid');

        $this->postJson(route('ai.api.quotes.answers', $uuid), [
            'session_id' => (string) Str::uuid(),
            'question_key' => 'project_description',
            'answer' => 'some project',
        ])->assertNotFound();
    }

    public function test_handoff_creates_request_and_returns_contact_options(): void
    {
        $conversation = $this->createConversation();

        $this->postJson(route('ai.api.handoffs'), [
            'session_id' => $this->sessionId,
            'reason' => 'user_requested',
            'message' => 'Please connect me with a person.',
        ])
            ->assertOk()
            ->assertJsonPath('contact.email', config('company.contact.email'))
            ->assertJsonStructure(['message', 'contact' => ['email', 'phone', 'whatsapp']]);

        $this->assertDatabaseHas('ai_handoffs', [
            'conversation_id' => $conversation->id,
            'reason' => 'user_requested',
            'status' => 'requested',
        ]);
    }

    public function test_send_message_rate_limit_is_enforced(): void
    {
        $this->fakeGroq();

        $conversation = $this->createConversation();

        for ($i = 0; $i < 10; $i++) {
            $this->postJson(route('ai.api.conversations.messages', $conversation->uuid), [
                'session_id' => $this->sessionId,
                'message' => "message {$i}",
            ])->assertOk();
        }

        $this->postJson(route('ai.api.conversations.messages', $conversation->uuid), [
            'session_id' => $this->sessionId,
            'message' => 'too many',
        ])->assertStatus(429);
    }

    private function createConversation(): Conversation
    {
        return Conversation::create([
            'session_id' => $this->sessionId,
            'channel' => 'website',
            'status' => Conversation::STATUS_ACTIVE,
            'started_at' => now(),
            'last_message_at' => now(),
            'expires_at' => now()->addDays(30),
        ]);
    }
}
