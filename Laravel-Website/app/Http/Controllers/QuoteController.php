<?php

namespace App\Http\Controllers;

use App\Exceptions\Quote\InvalidStepException;
use App\Exceptions\Quote\QuoteSubmissionException;
use App\Http\Requests\Quote\QuoteAiActionRequest;
use App\Http\Requests\Quote\StoreQuoteStepRequest;
use App\Http\Requests\Quote\SubmitQuoteWizardRequest;
use App\Models\QuoteSession;
use App\Models\QuoteSubmission;
use App\Services\AI\AIException;
use App\Services\AI\QuoteAiService;
use App\Services\Quote\QuoteReviewService;
use App\Services\Quote\QuoteSubmissionService;
use App\Services\Quote\QuoteWizardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class QuoteController extends Controller
{
    public const CLIENT_COOKIE = 'smevolve_quote_client';

    public function __construct(
        private readonly QuoteWizardService $wizard,
        private readonly QuoteSubmissionService $submissionService,
        private readonly QuoteReviewService $reviewService,
        private readonly QuoteAiService $quoteAiService,
    ) {}

    public function index(Request $request): View
    {
        $sessionId = $this->clientSessionId($request);

        return view('quote.index', [
            'session_id' => $sessionId,
            'steps' => $this->wizard->steps(),
            'total_steps' => $this->wizard->stepCount(),
            'has_active_session' => $this->wizard->latestActiveFor($sessionId) !== null,
        ])
            ->withCookie(cookie(self::CLIENT_COOKIE, $sessionId, 60 * 24 * 30));
    }

    public function start(Request $request): RedirectResponse
    {
        $sessionId = $this->clientSessionId($request);

        $session = $this->wizard->latestActiveFor($sessionId) ?? $this->wizard->start($sessionId);

        return redirect()
            ->route('quote.show', $session->uuid)
            ->withCookie(cookie(self::CLIENT_COOKIE, $sessionId, 60 * 24 * 30));
    }

    public function show(Request $request, QuoteSession $quoteSession): View|RedirectResponse
    {
        $this->authorizeAccess($quoteSession, $this->sessionIdFrom($request));

        $finished = $this->finishedRedirect($quoteSession);

        if ($finished !== null) {
            return $finished;
        }

        $stepKey = $request->query('step');

        if (! is_string($stepKey) || $stepKey === '') {
            $stepKey = $this->stepKeyFor($quoteSession);
        }

        return $this->renderStep($quoteSession, $stepKey);
    }

    public function storeStep(
        Request $request,
        QuoteSession $quoteSession,
        string $stepKey,
        StoreQuoteStepRequest $stepRequest,
    ): RedirectResponse {
        $this->authorizeAccess($quoteSession, $this->sessionIdFrom($request));

        $rules = $this->wizard->validationRulesFor($quoteSession, $stepKey, $request->all());

        $validated = $request->validate($rules);

        try {
            $this->wizard->storeStep($quoteSession, $stepKey, $validated);
        } catch (InvalidStepException $e) {
            abort(404, $e->getMessage());
        }

        if ($stepKey === $this->wizard->lastStep()) {
            return redirect()->route('quote.review', $quoteSession->uuid);
        }

        $next = $this->wizard->nextStep($stepKey);

        if ($next === null) {
            return redirect()->route('quote.review', $quoteSession->uuid);
        }

        return redirect()->route('quote.show', [$quoteSession->uuid, 'step' => $next]);
    }

    public function review(Request $request, QuoteSession $quoteSession): View|RedirectResponse
    {
        $this->authorizeAccess($quoteSession, $this->sessionIdFrom($request));

        $finished = $this->finishedRedirect($quoteSession);

        if ($finished !== null) {
            return $finished;
        }

        return view('quote.review', [
            'session' => $quoteSession,
            'review' => $this->reviewService->build($quoteSession),
            'missing_fields' => $this->reviewService->missingFields($quoteSession),
            'is_ready' => $this->reviewService->isReady($quoteSession),
            'previous_step' => $this->wizard->previousStep($this->wizard->lastStep()),
            'steps' => $this->wizard->steps(),
            'total_steps' => $this->wizard->stepCount(),
            'consent_documents' => config('quote.consent.documents', []),
            'session_id' => (string) $quoteSession->session_id,
        ]);
    }

    public function submit(Request $request, QuoteSession $quoteSession, SubmitQuoteWizardRequest $submitRequest): RedirectResponse
    {
        $this->authorizeAccess($quoteSession, $this->sessionIdFrom($request));

        $review = $this->reviewService->build($quoteSession);

        $contact = [
            'contact_name' => $review['contact_name'] ?? '',
            'contact_email' => $review['contact_email'] ?? '',
            'contact_phone' => $review['contact_phone'] ?? null,
            'preferred_contact_method' => $submitRequest->validated('preferred_contact_method')
                ?? $review['preferred_contact_method']
                ?? null,
        ];

        try {
            $result = $this->submissionService->submit($quoteSession, $contact);
        } catch (QuoteSubmissionException $e) {
            return back()
                ->withErrors(['submit' => $e->getMessage()])
                ->withInput();
        }

        return redirect()->route('quote.confirmation', $result['reference']);
    }

    public function confirmation(string $reference): View
    {
        $submission = QuoteSubmission::with('quoteSession')
            ->where('reference', $reference)
            ->firstOrFail();

        return view('quote.confirmation', [
            'submission' => $submission,
            'reference' => $submission->reference,
            'contact_email' => $submission->contact_email,
        ]);
    }

    public function suggestFeatures(QuoteAiActionRequest $request, QuoteSession $quoteSession): JsonResponse
    {
        $this->authorizeAccess($quoteSession, (string) $request->input('session_id', ''));

        if (! $this->aiAvailable()) {
            return response()->json(['message' => 'AI assistance is currently unavailable.'], 503);
        }

        try {
            $suggestions = $this->quoteAiService->suggestFeatures($quoteSession);
        } catch (AIException $e) {
            return response()->json(['message' => $e->getMessage()], 502);
        }

        return response()->json(['suggestions' => $suggestions]);
    }

    public function improveDescription(QuoteAiActionRequest $request, QuoteSession $quoteSession): JsonResponse
    {
        $this->authorizeAccess($quoteSession, (string) $request->input('session_id', ''));

        if (! $this->aiAvailable()) {
            return response()->json(['message' => 'AI assistance is currently unavailable.'], 503);
        }

        try {
            $result = $this->quoteAiService->improveDescription($quoteSession);
        } catch (AIException $e) {
            return response()->json(['message' => $e->getMessage()], 502);
        }

        return response()->json($result);
    }

    private function renderStep(QuoteSession $quoteSession, string $stepKey): View
    {
        try {
            $data = $this->wizard->step($quoteSession, $stepKey);
        } catch (InvalidStepException) {
            $data = $this->wizard->step($quoteSession, $this->stepKeyFor($quoteSession));
        }

        $data['ai_available'] = $this->aiAvailable();
        $data['session_id'] = (string) $quoteSession->session_id;
        $data['client_cookie'] = self::CLIENT_COOKIE;

        return view('quote.step', $data);
    }

    private function stepKeyFor(QuoteSession $quoteSession): string
    {
        $stepKeys = collect($this->wizard->steps())->pluck('key')->values();

        $position = max(1, min((int) $quoteSession->current_step, $stepKeys->count()));

        return (string) $stepKeys->get($position - 1, $stepKeys->first());
    }

    private function aiAvailable(): bool
    {
        return $this->quoteAiService->isAvailable();
    }

    private function clientSessionId(Request $request): string
    {
        $existing = $request->cookie(self::CLIENT_COOKIE);

        if (is_string($existing) && preg_match('/^[a-f0-9\-]{8,80}$/i', $existing) === 1) {
            return $existing;
        }

        return (string) Str::uuid();
    }

    private function sessionIdFrom(Request $request): string
    {
        $fromInput = $request->input('session_id');

        if (is_string($fromInput) && $fromInput !== '') {
            return $fromInput;
        }

        $fromCookie = $request->cookie(self::CLIENT_COOKIE);

        if (is_string($fromCookie) && $fromCookie !== '') {
            return $fromCookie;
        }

        return '';
    }

    private function authorizeAccess(QuoteSession $quoteSession, string $sessionId): void
    {
        if (! $quoteSession->isOwnedBy($sessionId)) {
            abort(404);
        }
    }

    private function finishedRedirect(QuoteSession $quoteSession): ?RedirectResponse
    {
        if ($quoteSession->isExpired()) {
            return redirect()->route('quote')->with('quote_expired', true);
        }

        if ($quoteSession->status === QuoteSession::STATUS_SUBMITTED && $quoteSession->submission !== null) {
            return redirect()->route('quote.confirmation', $quoteSession->submission->reference);
        }

        return null;
    }
}
