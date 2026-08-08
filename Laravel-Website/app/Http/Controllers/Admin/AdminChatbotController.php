<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminChatbotUpdateRequest;
use App\Services\Admin\AdminAuditService;
use App\Services\AI\AiConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminChatbotController extends Controller
{
    public function __construct(
        private readonly AiConfigService $aiConfigService,
        private readonly AdminAuditService $auditService,
    ) {}

    public function index(Request $request)
    {
        $this->authorize('admin.chatbot.view');

        return view('admin.chatbot.settings', [
            'enabled' => $this->aiConfigService->assistantEnabled(),
            'welcome_message' => $this->aiConfigService->welcomeMessage(),
            'availability_message' => $this->aiConfigService->availabilityMessage(),
        ]);
    }

    public function update(AdminChatbotUpdateRequest $request)
    {
        $this->authorize('admin.chatbot.update');

        $administrator = Auth::guard('admin')->user();
        $actor = (string) $administrator->id;

        $fields = [
            'assistant.enabled' => $request->boolean('enabled'),
            'assistant.welcome_message' => $request->string('welcome_message')->trim()->value() ?: null,
            'assistant.availability_message' => $request->string('availability_message')->trim()->value() ?: null,
        ];

        foreach ($fields as $key => $value) {
            $old = $this->aiConfigService->get($key);
            $this->aiConfigService->set($key, $value, $actor);

            $this->auditService->log(
                'chatbot.update',
                'ai_configurations',
                $key,
                oldValue: $old,
                newValue: $value,
                actor: $administrator,
                request: $request,
            );
        }

        return redirect()->route('admin.chatbot.index')->with('status', 'Chatbot settings updated successfully.');
    }
}
