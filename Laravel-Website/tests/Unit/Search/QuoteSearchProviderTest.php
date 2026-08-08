<?php

namespace Tests\Unit\Search;

use App\Models\QuoteSession;
use App\Models\QuoteSubmission;
use App\Services\Search\QuoteSearchProvider;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class QuoteSearchProviderTest extends TestCase
{
    use DatabaseTransactions;

    public function test_exact_reference_ranks_before_contains_match(): void
    {
        $this->submission('SME-100', 'Jane Doe');
        $this->submission('X-SME-100-Y', 'Doe Jane');

        $results = (new QuoteSearchProvider())->search('sme-100', 5);

        $this->assertCount(2, $results);
        $this->assertSame('SME-100', $results[0]['title']);
        $this->assertSame('X-SME-100-Y', $results[1]['title']);
    }

    public function test_exact_contact_name_ranks_before_prefix_match(): void
    {
        $this->submission('SME-000001', 'John Smith');
        $this->submission('SME-000002', 'John Smithson');

        $results = (new QuoteSearchProvider())->search('john smith', 5);

        $this->assertSame('SME-000001', $results[0]['title']);
    }

    public function test_prefix_match_ranks_before_contains_match(): void
    {
        $this->submission('SME-000100', 'Jane Doe');
        $this->submission('SME-000200', 'Doe Enterprises');

        $results = (new QuoteSearchProvider())->search('doe', 5);

        $this->assertSame('SME-000200', $results[0]['title']);
        $this->assertSame('SME-000100', $results[1]['title']);
    }

    public function test_search_is_case_insensitive(): void
    {
        $this->submission('sme-2026-000050', 'Casey Test');

        $results = (new QuoteSearchProvider())->search('SME-2026-000050', 5);

        $this->assertCount(1, $results);
        $this->assertSame('sme-2026-000050', $results[0]['title']);
    }

    public function test_per_resource_limit_applies(): void
    {
        for ($i = 0; $i < 8; $i++) {
            $this->submission('SME-00000' . $i, 'Same Name');
        }

        $results = (new QuoteSearchProvider())->search('same name', 5);

        $this->assertCount(5, $results);
    }

    public function test_result_shape_is_normalized(): void
    {
        $submission = $this->submission('SME-2026-000099', 'Jane Doe');

        $results = (new QuoteSearchProvider())->search('jane doe', 1);

        $this->assertCount(1, $results);
        $this->assertSame('quote', $results[0]['type']);
        $this->assertSame($submission->id, $results[0]['id']);
        $this->assertSame('SME-2026-000099', $results[0]['title']);
        $this->assertSame('Jane Doe', $results[0]['subtitle']);
        $this->assertSame(route('admin.quotes.show', $submission), $results[0]['url']);
        $this->assertSame('New', $results[0]['metadata']['status']);
    }

    private function submission(string $reference, string $name): QuoteSubmission
    {
        $session = QuoteSession::create([
            'uuid' => (string) Str::uuid(),
            'session_id' => (string) Str::uuid(),
            'status' => 'submitted',
            'project_type' => 'Website development',
            'business_name' => 'Acme Ltd',
            'started_at' => now(),
            'last_activity_at' => now(),
        ]);

        return QuoteSubmission::create([
            'quote_session_id' => $session->id,
            'reference' => $reference,
            'status' => QuoteSubmission::STATUS_SUBMITTED,
            'contact_name' => $name,
            'contact_email' => 'jane@example.com',
            'contact_phone' => '+27700000000',
            'preferred_contact_method' => 'email',
            'submitted_at' => now(),
        ]);
    }
}
