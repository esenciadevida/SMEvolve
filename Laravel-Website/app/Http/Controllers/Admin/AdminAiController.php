<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAiUpdateRequest;
use App\Services\Admin\AdminAuditService;
use App\Services\AI\AiConfigService;
use App\Services\AI\AIProviderInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAiController extends Controller
{
    public function __construct(
        private readonly AiConfigService $aiConfigService,
        private readonly AIProviderInterface $provider,
        private readonly AdminAuditService $auditService,
    ) {}

    public function settings(Request $request)
    {
        $this->authorize('admin.ai.view');

        return view('admin.ai.settings', [
            'enabled' => (bool) config('ai.enabled'),
            'model' => (string) config('ai.groq.model'),
            'max_output_tokens' => (int) config('ai.groq.max_output_tokens'),
            'temperature' => (float) config('ai.groq.temperature'),
            'approved_models' => config('ai.groq.approved_models', []),
            'canUpdate' => Auth::guard('admin')->user()->hasPermission('ai.update'),
        ]);
    }

    public function update(AdminAiUpdateRequest $request)
    {
        $this->authorize('admin.ai.update');

        $administrator = Auth::guard('admin')->user();
        $actor = (string) $administrator->id;

        $fields = [
            'enabled' => $request->boolean('enabled'),
            'groq.model' => $request->string('model')->trim()->value() ?: null,
            'groq.max_output_tokens' => $request->integer('max_output_tokens'),
            'groq.temperature' => (float) $request->input('temperature'),
        ];

        foreach ($fields as $key => $value) {
            $old = $this->aiConfigService->get($key);
            $this->aiConfigService->set($key, $value, $actor);

            $this->auditService->log(
                'ai.update',
                'ai_configurations',
                $key,
                oldValue: $old,
                newValue: $value,
                actor: $administrator,
                request: $request,
            );
        }

        return redirect()->route('admin.ai.settings')->with('status', 'AI settings updated successfully.');
    }

    public function status(Request $request)
    {
        $this->authorize('admin.ai.view');

        $configured = $this->provider->isConfigured();

        return view('admin.ai.status', [
            'provider' => $this->provider->name(),
            'model' => (string) config('ai.groq.model'),
            'configured' => $configured,
            'aiEnabled' => (bool) config('ai.enabled'),
            'assistantEnabled' => $this->aiConfigService->assistantEnabled(),
            'quoteEnabled' => $this->aiConfigService->quoteEnabled(),
            'lastCheckAt' => now(),
        ]);
    }
}
