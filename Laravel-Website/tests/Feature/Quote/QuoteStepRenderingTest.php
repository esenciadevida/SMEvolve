<?php

namespace Tests\Feature\Quote;

use App\Models\QuoteSession;
use App\Services\Quote\QuoteSessionService;
use Database\Seeders\QuoteRequirementSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class QuoteStepRenderingTest extends TestCase
{
    use DatabaseTransactions;

    private string $sessionId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sessionId = (string) Str::uuid();

        $this->seed(QuoteRequirementSeeder::class);
    }

    public function test_contact_information_step_renders_all_input_fields(): void
    {
        $html = $this->getStepHtml('contact_information');

        // Regression guard: Blade leaves <x-...> tags containing @if(...) in their
        // attributes uncompiled, which printed the tag literally and hid the inputs.
        $this->assertStringNotContainsString('<x-forms.', $html);
        $this->assertStringNotContainsString('<x-', $html, 'An uncompiled Blade component tag was printed to the page.');

        foreach (['full_name', 'email', 'phone', 'company_name', 'preferred_contact_method'] as $field) {
            $this->assertStringContainsString(
                'name="'.$field.'"',
                $html,
                "The {$field} field is missing from the Contact Information step."
            );
        }

        $this->assertStringContainsString('inputmode="tel"', $html);
        $this->assertStringContainsString('inputmode="email"', $html);
        $this->assertMatchesRegularExpression('/<input[^>]*name="full_name"[^>]*required/', $html);
        $this->assertMatchesRegularExpression('/<input[^>]*name="email"[^>]*required/', $html);
        $this->assertMatchesRegularExpression('/<input[^>]*name="phone"[^>]*required/', $html);
    }

    public function test_text_steps_render_their_input_fields(): void
    {
        $html = $this->getStepHtml('project_description');

        $this->assertStringNotContainsString('<x-forms.', $html);
        $this->assertStringContainsString('name="project_description"', $html);
        $this->assertMatchesRegularExpression('/<(textarea|input)[^>]*name="project_description"/', $html);
    }

    private function getStepHtml(string $stepKey): string
    {
        $session = app(QuoteSessionService::class)->create($this->sessionId);

        $response = $this->get(route('quote.show', [
            'quoteSession' => $session->uuid,
            'step' => $stepKey,
            'session_id' => $this->sessionId,
        ]));

        $response->assertOk();

        return $response->getContent();
    }
}
