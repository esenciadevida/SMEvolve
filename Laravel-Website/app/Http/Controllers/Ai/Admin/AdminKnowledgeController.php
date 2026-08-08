<?php

namespace App\Http\Controllers\Ai\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ai\Admin\StoreKnowledgeRequest;
use App\Models\KnowledgeItem;
use App\Services\AI\AiAuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminKnowledgeController extends Controller
{
    public function __construct(private readonly AiAuditService $auditService) {}

    public function index(Request $request)
    {
        $query = KnowledgeItem::query()
            ->withTrashed()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->input('search');
                $q->where(fn ($w) => $w->where('title', 'like', "%{$search}%")->orWhere('content', 'like', "%{$search}%"));
            })
            ->orderByDesc('id');

        return view('admin.ai.knowledge', [
            'items' => $query->paginate(20)->withQueryString(),
            'statusFilter' => $request->input('status'),
            'search' => $request->input('search'),
        ]);
    }

    public function store(StoreKnowledgeRequest $request)
    {
        $data = $request->validated();

        $keywords = array_values(array_filter(array_map(
            fn ($keyword) => trim($keyword),
            explode(',', (string) ($data['keywords_input'] ?? ''))
        )));

        $item = KnowledgeItem::create([
            'type' => $data['type'],
            'title' => $data['title'],
            'slug' => $data['slug'] ?? Str::slug($data['title']),
            'content' => $data['content'],
            'status' => $data['status'],
            'priority' => $data['priority'] ?? 'normal',
            'metadata' => ['keywords' => $keywords],
            'created_by' => 'admin',
            'published_at' => $data['status'] === 'published' ? now() : null,
        ]);

        $this->auditService->log(
            'knowledge.create',
            'knowledge_items',
            (string) $item->id,
            newValue: ['title' => $item->title, 'type' => $item->type],
            request: $request,
        );

        return redirect()->route('admin.ai.knowledge.index')->with('status', 'Knowledge item created.');
    }

    public function destroy(Request $request, KnowledgeItem $knowledgeItem)
    {
        $this->auditService->log(
            'knowledge.delete',
            'knowledge_items',
            (string) $knowledgeItem->id,
            oldValue: ['title' => $knowledgeItem->title],
            request: $request,
        );

        $knowledgeItem->delete();

        return back()->with('status', 'Knowledge item deleted.');
    }
}
