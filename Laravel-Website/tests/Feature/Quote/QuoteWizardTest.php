<?php

namespace Tests\Feature\Quote;

use App\Http\Controllers\QuoteController;
use App\Models\QuoteSession;
use App\Models\QuoteSubmission;
use App\Services\Quote\QuoteSessionService;
use Database\Seeders\QuoteRequirementSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class QuoteWizardTest extends TestCase
{
    use DatabaseTransactions;

    private string $sessionId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sessionId = (string) Str::uuid();

        $this->seed(QuoteRequirementSeeder::class);

        config()->set('ai.enabled', true);
        config()->set('ai.assistant.enabled', true);
        config()->set('ai.quote.enabled', true);
        config()->set('ai.quote_feature_suggestions.enabled', true);
        config()->set('ai.quote_description_assistance.enabled', true);
        config()->set('ai.groq.api_key', 'test-key');
    }

    public function test_quote_index_page_loads(): void
    {
        $this->get(route('quote'))
            ->assertOk()
            ->assertSee('Start My Free Quote');
    }

    public function test_start_creates_a_quote_session(): void
    {
        $response = $this->withCookie(QuoteController::CLIENT_COOKIE, $this->sessionId)
            ->post(route('quote.start'));

        $response->assertRedirect();

        $this->assertDatabaseHas('quote_sessions', [
            'session_id' => $this->sessionId,
            'status' => QuoteSession::STATUS_STARTED,
        ]);
    }

    public function test_full_wizard_flow_ends_at_review(): void
    {
        $session = $this->createSession();

        $this->get(route('quote.show', ['quoteSession' => $session->uuid, 'session_id' => $this->sessionId]))
            ->assertOk();

        $flow = [
            'project_type' => ['project_type' => 'ecommerce_website'],
            'project_description' => ['project_description' => 'An online store to sell fashion products across Nigeria.'],
            'business_information' => [
                'business_name' => 'Adire House',
                'industry' => 'retail',
                'business_description' => 'We sell handmade fashion.',
            ],
            'project_requirements' => [
                'required_features' => ['product_catalogue', 'shopping_cart', 'checkout'],
                'additional_features' => 'Instagram feed integration',
            ],
            'existing_assets' => [
                'existing_assets' => ['logo', 'website'],
                'existing_website_url' => 'https://adirehouse.example.com',
                'project_stage' => 'planning',
            ],
            'timeline' => ['timeline' => 'within_1_month'],
            'budget' => ['budget_range' => '500k_1m'],
            'additional_information' => ['additional_information' => 'We need it ready before the end of the year.'],
            'contact_information' => [
                'full_name' => 'Ada Lovelace',
                'email' => 'ada@example.com',
                'phone' => '+2348000000000',
                'preferred_contact_method' => 'whatsapp',
            ],
        ];

        $stepKeys = collect(config('quote.steps', []))->pluck('key')->values();

        foreach ($flow as $stepKey => $payload) {
            $response = $this->postStep($session, $stepKey, $payload);
            $response->assertRedirect();

            if ($stepKey === 'contact_information') {
                $this->assertStringEndsWith(
                    '/quote/'.$session->uuid.'/review',
                    $response->headers->get('Location')
                );
            } else {
                $next = $stepKeys[$stepKeys->search($stepKey) + 1];
                $this->assertStringEndsWith(
                    '/quote/'.$session->uuid.'?step='.$next,
                    $response->headers->get('Location')
                );
            }
        }

        $this->assertDatabaseHas('quote_answers', ['quote_session_id' => $session->id, 'question_key' => 'project_type']);
        $this->assertDatabaseHas('quote_answers', ['quote_session_id' => $session->id, 'question_key' => 'project_description']);
        $this->assertDatabaseHas('quote_answers', ['quote_session_id' => $session->id, 'question_key' => 'email']);

        $session->refresh();
        $this->assertSame(QuoteSession::STATUS_REVIEW, $session->status);

        $this->get(route('quote.review', ['quoteSession' => $session->uuid, 'session_id' => $this->sessionId]))
            ->assertOk()
            ->assertSee('Ada Lovelace')
            ->assertSee('E-commerce Website');

        $confirmed = $session->sessionRequirements()
            ->whereIn('status', ['confirmed', 'selected'])
            ->with('quoteRequirement')
            ->get()
            ->pluck('quoteRequirement.key')
            ->all();

        $this->assertContains('product_catalogue', $confirmed);
        $this->assertContains('shopping_cart', $confirmed);
        $this->assertContains('checkout', $confirmed);
    }

    public function test_conditional_questions_are_hidden_when_condition_not_met(): void
    {
        $session = $this->createSession();

        $this->postStep($session, 'project_type', ['project_type' => 'website']);
        $this->postStep($session, 'existing_assets', [
            'existing_assets' => ['logo'],
            'project_stage' => 'planning',
        ])->assertRedirect();

        $this->assertDatabaseMissing('quote_answers', [
            'quote_session_id' => $session->id,
            'question_key' => 'existing_website_url',
        ]);
        $this->assertDatabaseHas('quote_answers', [
            'quote_session_id' => $session->id,
            'question_key' => 'project_stage',
        ]);
    }

    public function test_validation_rejects_invalid_options(): void
    {
        $session = $this->createSession();

        $this->postStep($session, 'project_type', ['project_type' => 'not_a_real_type'])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors('project_type');

        $this->postStep($session, 'contact_information', [
            'full_name' => 'Ada Lovelace',
            'email' => 'not-an-email',
            'phone' => 'abc',
        ])->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['email', 'phone']);
    }

    public function test_session_requires_ownership(): void
    {
        $session = $this->createSession();

        $this->get(route('quote.show', ['quoteSession' => $session->uuid, 'session_id' => (string) Str::uuid()]))
            ->assertNotFound();
    }

    public function test_step_store_requires_valid_session_id(): void
    {
        $session = $this->createSession();

        $this->post(route('quote.step.store', ['quoteSession' => $session->uuid, 'stepKey' => 'project_type']), [
            'project_type' => 'website',
        ])->assertSessionHasErrors('session_id');
    }

    public function test_submission_creates_submission_and_consents(): void
    {
        $session = $this->completeSession();

        $this->post(route('quote.submit', $session->uuid), [
            'session_id' => $this->sessionId,
            'preferred_contact_method' => 'whatsapp',
        ])->assertRedirect();

        $session->refresh();
        $this->assertSame(QuoteSession::STATUS_SUBMITTED, $session->status);
        $this->assertSame('ada@example.com', $session->contact_email);

        $submission = QuoteSubmission::where('quote_session_id', $session->id)->firstOrFail();
        $this->assertStringStartsWith('SME-', $submission->reference);
        $this->assertSame('ada@example.com', $submission->contact_email);
        $this->assertSame('whatsapp', $submission->preferred_contact_method);

        $this->assertDatabaseHas('quote_consents', [
            'quote_session_id' => $session->id,
            'quote_submission_id' => $submission->id,
            'consent_type' => 'privacy',
            'accepted' => true,
        ]);

        $this->get(route('quote.confirmation', $submission->reference))
            ->assertOk()
            ->assertSee($submission->reference);
    }

    public function test_submitted_session_redirects_to_confirmation(): void
    {
        $session = $this->completeSession();

        $this->post(route('quote.submit', $session->uuid), [
            'session_id' => $this->sessionId,
        ])->assertRedirect();

        $this->get(route('quote.show', ['quoteSession' => $session->uuid, 'session_id' => $this->sessionId]))
            ->assertRedirect(route('quote.confirmation', $session->submission->reference));
    }

    public function test_suggest_features_returns_suggestions(): void
    {
        $this->fakeGroq(json_encode([
            'suggestions' => [
                ['key' => 'reviews', 'reason' => 'Social proof helps shoppers trust your store.'],
                ['key' => 'wishlist', 'reason' => 'Lets shoppers save items for later.'],
            ],
        ]));

        $session = $this->createSession();

        $this->postJson(route('quote.ai.suggest-features', $session->uuid), [
            'session_id' => $this->sessionId,
        ])->assertOk()
            ->assertJsonStructure(['suggestions' => [['key', 'reason']]])
            ->assertJsonPath('suggestions.0.key', 'reviews');

        $this->assertDatabaseHas('quote_ai_interactions', [
            'quote_session_id' => $session->id,
            'operation' => 'feature_suggestions',
            'status' => 'completed',
        ]);
    }

    public function test_improve_description_returns_improved_text(): void
    {
        $this->fakeGroq(json_encode([
            'description' => 'A modern online store for handmade fashion, with secure checkout.',
            'questions' => ['Which payment gateways do your customers prefer?'],
        ]));

        $session = $this->createSession();

        $this->postJson(route('quote.ai.improve-description', $session->uuid), [
            'session_id' => $this->sessionId,
        ])->assertOk()
            ->assertJsonStructure(['description', 'questions'])
            ->assertJsonPath('description', 'A modern online store for handmade fashion, with secure checkout.');
    }

    public function test_ai_endpoints_reject_missing_session_id(): void
    {
        $session = $this->createSession();

        $this->postJson(route('quote.ai.suggest-features', $session->uuid))
            ->assertStatus(422)
            ->assertJsonValidationErrors('session_id');

        $this->postJson(route('quote.ai.improve-description', $session->uuid))
            ->assertStatus(422)
            ->assertJsonValidationErrors('session_id');
    }

    public function test_ai_endpoints_require_ownership(): void
    {
        $this->fakeGroq('{}');

        $session = $this->createSession();

        $this->postJson(route('quote.ai.suggest-features', $session->uuid), [
            'session_id' => (string) Str::uuid(),
        ])->assertNotFound();
    }

    public function test_ai_endpoints_return_503_when_ai_disabled(): void
    {
        config()->set('ai.enabled', false);

        $session = $this->createSession();

        $this->postJson(route('quote.ai.suggest-features', $session->uuid), [
            'session_id' => $this->sessionId,
        ])->assertStatus(503);

        $this->postJson(route('quote.ai.improve-description', $session->uuid), [
            'session_id' => $this->sessionId,
        ])->assertStatus(503);
    }

    private function createSession(): QuoteSession
    {
        return app(QuoteSessionService::class)->create($this->sessionId);
    }

    private function completeSession(): QuoteSession
    {
        $session = $this->createSession();

        $this->postStep($session, 'project_type', ['project_type' => 'ecommerce_website']);
        $this->postStep($session, 'project_description', ['project_description' => 'An online store to sell fashion products.']);
        $this->postStep($session, 'business_information', ['industry' => 'retail']);
        $this->postStep($session, 'project_requirements', [
            'required_features' => ['product_catalogue', 'checkout'],
        ]);
        $this->postStep($session, 'existing_assets', ['project_stage' => 'planning']);
        $this->postStep($session, 'timeline', ['timeline' => 'within_1_month']);
        $this->postStep($session, 'budget', ['budget_range' => '500k_1m']);
        $this->postStep($session, 'additional_information', []);
        $this->postStep($session, 'contact_information', [
            'full_name' => 'Ada Lovelace',
            'email' => 'ada@example.com',
            'phone' => '+2348000000000',
        ]);

        return $session;
    }

    private function postStep(QuoteSession $session, string $stepKey, array $data): TestResponse
    {
        return $this->post(
            route('quote.step.store', ['quoteSession' => $session->uuid, 'stepKey' => $stepKey]),
            array_merge(['session_id' => $this->sessionId], $data)
        );
    }

    private function fakeGroq(string $content): void
    {
        Http::fake([
            'api.groq.com/*' => Http::response([
                'id' => 'chatcmpl-quote-test',
                'model' => 'llama-3.3-70b-versatile',
                'choices' => [
                    ['message' => ['role' => 'assistant', 'content' => $content]],
                ],
                'usage' => [
                    'prompt_tokens' => 10,
                    'completion_tokens' => 20,
                    'total_tokens' => 30,
                ],
            ], 200),
        ]);
    }
}
