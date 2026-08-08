<?php

namespace App\Http\Controllers\Ai\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ai\Admin\StorePromptVersionRequest;
use App\Models\AiPrompt;
use App\Models\AiPromptVersion;
use App\Services\AI\AiAuditService;
use App\Services\AI\PromptService;
use Illuminate\Http\Request;

class AdminPromptController extends Controller
{
    public function __construct(
        private readonly PromptService $promptService,
        private readonly AiAuditService $auditService,
    ) {}

    public function index()
    {
        $prompts = AiPrompt::with(['activeVersion', 'versions' => fn ($q) => $q->orderByDesc('version')])
            ->orderBy('key')
            ->get();

        return view('admin.ai.prompts', ['prompts' => $prompts]);
    }

    public function storeVersion(StorePromptVersionRequest $request, AiPrompt $prompt)
    {
        $versionExists = $prompt->versions()->where('version', $request->validated('version'))->exists();

        if ($versionExists) {
            return back()->withErrors(['version' => 'That version number already exists for this prompt.']);
        }

        $version = $prompt->versions()->create([
            'version' => $request->validated('version'),
            'content' => $request->validated('content'),
            'status' => 'draft',
            'created_by' => 'admin',
        ]);

        $this->auditService->log(
            'prompt.version.create',
            'ai_prompt_versions',
            (string) $version->id,
            newValue: ['prompt' => $prompt->key, 'version' => $version->version],
            request: $request,
        );

        if ($request->boolean('activate')) {
            $this->activateVersion($request, $prompt, $version);
        }

        return back()->with('status', 'Prompt version created.');
    }

    public function activateVersion(Request $request, AiPrompt $prompt, AiPromptVersion $version)
    {
        $previous = $prompt->active_version_id;

        $prompt->versions()->where('id', '!=', $version->id)->update(['status' => 'archived']);

        $version->forceFill([
            'status' => 'active',
            'activated_by' => 'admin',
            'activated_at' => now(),
        ])->save();

        $prompt->forceFill(['active_version_id' => $version->id])->save();

        $this->auditService->log(
            'prompt.version.activate',
            'ai_prompts',
            $prompt->key,
            oldValue: $previous,
            newValue: $version->id,
            request: $request,
        );

        return back()->with('status', 'Prompt version activated.');
    }
}
