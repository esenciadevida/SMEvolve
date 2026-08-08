<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminQuoteStatusRequest;
use App\Models\QuoteSubmission;
use App\Services\Admin\AdminAuditService;
use App\Services\Admin\AdminQuoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminQuoteController extends Controller
{
    public function __construct(
        private readonly AdminQuoteService $quoteService,
        private readonly AdminAuditService $auditService,
    ) {}

    public function index(Request $request)
    {
        $this->authorize('admin.quotes.view');

        $filters = [
            'query' => $request->string('q')->trim()->value(),
            'status' => $request->string('status')->trim()->value() ?: null,
            'from' => $request->string('from')->trim()->value() ?: null,
            'to' => $request->string('to')->trim()->value() ?: null,
            'sort' => $request->string('sort')->trim()->value() ?: 'newest',
        ];

        $quotes = $this->quoteService->search($filters);

        return view('admin.quotes.index', [
            'quotes' => $quotes,
            'filters' => $filters,
            'statuses' => $this->quoteService->statusOptions(),
        ]);
    }

    public function show(Request $request, QuoteSubmission $quote)
    {
        $this->authorize('admin.quotes.view');

        $quote->load('quoteSession', 'consents');

        return view('admin.quotes.show', [
            'quote' => $quote,
            'statuses' => $this->quoteService->statusOptions(),
            'canUpdateStatus' => Auth::guard('admin')->user()->hasPermission('quotes.update_status'),
        ]);
    }

    public function updateStatus(AdminQuoteStatusRequest $request, QuoteSubmission $quote)
    {
        $this->authorize('admin.quotes.updateStatus');

        $administrator = Auth::guard('admin')->user();
        $oldStatus = $quote->status;

        $this->quoteService->updateStatus($quote, $request->validated('status'));

        $this->auditService->log(
            'quotes.update_status',
            'quotes',
            (string) $quote->id,
            oldValue: $oldStatus,
            newValue: $quote->status,
            actor: $administrator,
            request: $request,
        );

        return back()->with('status', 'Quote status updated.');
    }
}
