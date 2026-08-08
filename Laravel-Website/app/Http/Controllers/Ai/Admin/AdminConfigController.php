<?php

namespace App\Http\Controllers\Ai\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ai\Admin\AdminUpdateConfigRequest;
use App\Services\AI\AiAuditService;
use App\Services\AI\AiConfigService;

class AdminConfigController extends Controller
{
    public function __construct(
        private readonly AiConfigService $configService,
        private readonly AiAuditService $auditService,
    ) {
    }

    public function index()
    {
        $values = array_merge([
            'assistant.enabled' => (bool) config('ai.assistant.enabled'),
            'quote.enabled' => (bool) config('ai.quote.enabled'),
            'assistant.welcome_message' => (string) config('ai.assistant.welcome_message'),
            'assistant.availability_message' => (string) config('ai.assistant.availability_message'),
        ], $this->configService->allPublic());

        return view('admin.ai.config', [
            'values' => $values,
            'assistantEnabled' => $this->configService->assistantEnabled(),
            'quoteEnabled' => $this->configService->quoteEnabled(),
        ]);
    }

    public function update(AdminUpdateConfigRequest $request)
    {
        $values = $request->validated('values');
        $actor = (string) $request->session()->get(config('ai.admin.session_key'), 'admin');

        foreach ($values as $key => $value) {
            $key = (string) $key;
            $old = $this->configService->get($key);
            $this->configService->set($key, $value, $actor);

            $this->auditService->log(
                'config.update',
                'ai_configurations',
                $key,
                oldValue: $old,
                newValue: $value,
                request: $request,
            );
        }

        return back()->with('status', 'Configuration updated.');
    }
}
