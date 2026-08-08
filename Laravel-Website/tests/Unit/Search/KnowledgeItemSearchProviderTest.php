<?php

namespace Tests\Unit\Search;

use App\Models\Administrator;
use App\Models\KnowledgeItem;
use App\Models\Role;
use App\Services\Search\KnowledgeItemSearchProvider;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class KnowledgeItemSearchProviderTest extends TestCase
{
    use DatabaseTransactions;

    public function test_finds_knowledge_item_by_title(): void
    {
        $this->item('How we price projects', 'published');

        $results = (new KnowledgeItemSearchProvider())->search('how we price projects', 5);

        $this->assertNotEmpty($results);
        $this->assertSame('How we price projects', $results[0]['title']);
    }

    public function test_search_matches_content(): void
    {
        $this->item('Pricing overview', 'published', 'Every quotation is tailored to the project scope.');

        $results = (new KnowledgeItemSearchProvider())->search('project scope', 5);

        $this->assertNotEmpty($results);
        $this->assertSame('Pricing overview', $results[0]['title']);
    }

    public function test_search_excludes_trashed_items(): void
    {
        $item = $this->item('Archived topic', 'published');
        $item->delete();

        $results = (new KnowledgeItemSearchProvider())->search('archived topic', 5);

        $this->assertSame([], $results);
    }

    public function test_result_shape_is_normalized(): void
    {
        $item = $this->item('How we price projects', 'published');

        $results = (new KnowledgeItemSearchProvider())->search('how we price projects', 5);

        $this->assertCount(1, $results);
        $result = $results[0];

        $this->assertSame('knowledge', $result['type']);
        $this->assertSame($item->id, $result['id']);
        $this->assertSame(route('admin.ai.knowledge.index', ['search' => $item->title]), $result['url']);
        $this->assertSame('Published', $result['metadata']['status']);
    }

    public function test_permission_requires_ai_view(): void
    {
        $provider = new KnowledgeItemSearchProvider();

        $this->assertSame('ai.view', $provider->permission());
        $this->assertTrue($provider->canSearch($this->administrator(['ai.view'])));
        $this->assertFalse($provider->canSearch($this->administrator(['dashboard.view'])));
    }

    private function item(string $title, string $status, string $content = 'Knowledge base content.'): KnowledgeItem
    {
        return KnowledgeItem::create([
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'type' => 'knowledge',
            'content' => $content,
            'status' => $status,
            'priority' => 'normal',
            'published_at' => $status === 'published' ? now() : null,
        ]);
    }

    private function administrator(array $permissions): Administrator
    {
        $role = new Role(['permissions' => $permissions]);
        $administrator = new Administrator(['name' => 'Test Admin']);
        $administrator->setRelation('role', $role);

        return $administrator;
    }
}
