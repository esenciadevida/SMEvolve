<?php

namespace Tests\Unit\Search;

use App\Services\Content\ContentService;
use App\Services\Search\FaqSearchProvider;
use Tests\TestCase;

class FaqSearchProviderTest extends TestCase
{
    public function test_finds_active_faq_by_question(): void
    {
        $results = (new FaqSearchProvider(app(ContentService::class)))->search('what services does smevolve provide', 5);

        $this->assertNotEmpty($results);
        $this->assertSame('services-001', $results[0]['id']);
        $this->assertSame('faq', $results[0]['type']);
    }

    public function test_faq_result_deep_links_with_question_param(): void
    {
        $results = (new FaqSearchProvider(app(ContentService::class)))->search('what services does smevolve provide', 5);

        $this->assertNotEmpty($results);
        $this->assertSame(route('faq', ['question' => 'services-001']), $results[0]['url']);
    }

    public function test_search_matches_answers_and_tags(): void
    {
        $results = (new FaqSearchProvider(app(ContentService::class)))->search('automation', 10);

        $this->assertNotEmpty($results);
    }

    public function test_excludes_draft_questions(): void
    {
        $items = collect(config('faqs.items', []));
        $draft = $items->first();

        $this->assertNotNull($draft, 'Expected at least one FAQ to mark as draft.');

        config()->set('faqs.items', $items->map(function ($item) use ($draft) {
            return $item['id'] === $draft['id']
                ? [...$item, 'status' => 'draft']
                : $item;
        })->all());

        $results = (new FaqSearchProvider(app(ContentService::class)))->search($draft['question'], 10);

        foreach ($results as $result) {
            $this->assertNotSame($draft['id'], $result['id']);
        }
    }

    public function test_subtitle_is_a_limited_answer_preview(): void
    {
        $results = (new FaqSearchProvider(app(ContentService::class)))->search('what services does smevolve provide', 5);

        $this->assertNotEmpty($results);
        $this->assertNotEmpty($results[0]['subtitle']);
    }
}
