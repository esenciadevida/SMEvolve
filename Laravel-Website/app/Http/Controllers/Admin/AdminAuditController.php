<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminAuditService;
use Illuminate\Http\Request;

class AdminAuditController extends Controller
{
    public function __construct(private readonly AdminAuditService $auditService)
    {
    }

    public function index(Request $request)
    {
        $this->authorize('admin.audit.view');

        $filters = [
            'query' => $request->string('q')->trim()->value() ?: null,
            'action' => $request->string('action')->trim()->value() ?: null,
            'from' => $request->string('from')->trim()->value() ?: null,
            'to' => $request->string('to')->trim()->value() ?: null,
        ];

        $logs = $this->auditService->search($filters);

        return view('admin.audit.index', [
            'logs' => $logs,
            'filters' => $filters,
            'actions' => $this->auditService->distinctActions(),
        ]);
    }
}
