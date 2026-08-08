<?php

namespace App\Services\Quote;

use App\Exceptions\Quote\QuoteSubmissionException;
use App\Models\QuoteConsent;
use App\Models\QuoteSession;
use App\Models\QuoteSubmission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuoteSubmissionService
{
    public function __construct(
        private readonly QuoteReviewService $reviewService,
        private readonly QuoteReferenceService $referenceService,
    ) {
    }

    /**
     * Submit a quote session transactionally: creates the submission, the
     * snapshot, records consent and marks the session submitted. Idempotent,
     * a session can only ever produce one submission.
     *
     * @param  array{contact_name: string, contact_email: string, contact_phone?: ?string, preferred_contact_method?: ?string}  $contact
     * @return array{reference: string, submission: QuoteSubmission}
     *
     * @throws QuoteSubmissionException
     */
    public function submit(QuoteSession $session, array $contact): array
    {
        $this->assertSubmittable($session);

        $missing = $this->reviewService->missingFields($session);

        if ($missing !== []) {
            throw QuoteSubmissionException::notReady($missing);
        }

        $snapshot = $this->buildSnapshot($session);

        try {
            $submission = DB::transaction(function () use ($session, $contact, $snapshot) {
                $existing = $session->submission;

                if ($existing !== null) {
                    return $existing;
                }

                $submission = QuoteSubmission::create([
                    'quote_session_id' => $session->id,
                    'reference' => $this->referenceService->generate(),
                    'status' => QuoteSubmission::STATUS_SUBMITTED,
                    'contact_name' => $contact['contact_name'],
                    'contact_email' => $contact['contact_email'],
                    'contact_phone' => $contact['contact_phone'] ?? null,
                    'preferred_contact_method' => $contact['preferred_contact_method'] ?? null,
                    'snapshot' => $snapshot,
                    'submitted_at' => now(),
                ]);

                $this->recordConsents($session, $submission);

                $session->markSubmitted();

                return $submission;
            });
        } catch (QuoteSubmissionException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('[Quote] submission failed', [
                'quote_session_id' => $session->id,
                'error' => $e->getMessage(),
            ]);

            throw new QuoteSubmissionException('We could not submit your request. Please try again.', 0, $e);
        }

        return [
            'reference' => $submission->reference,
            'submission' => $submission,
        ];
    }

    /**
     * Throw when a session cannot be submitted.
     *
     * @throws QuoteSubmissionException
     */
    public function assertSubmittable(QuoteSession $session): void
    {
        if (! $session->isSubmittable()) {
            throw QuoteSubmissionException::alreadySubmitted();
        }

        if ($session->isExpired()) {
            throw new QuoteSubmissionException('This quote session has expired. Please start a new quote.');
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function buildSnapshot(QuoteSession $session): array
    {
        $review = $this->reviewService->build($session);

        return [
            'project_type' => $review['project_type'],
            'project_description' => $review['project_description'],
            'business_name' => $review['business_name'],
            'industry' => $review['industry'],
            'requirements' => $review['requirements'],
            'additional_features' => $review['additional_features'],
            'existing_assets' => $review['existing_assets'],
            'project_stage' => $review['project_stage'],
            'timeline' => $review['timeline'],
            'budget_range' => $review['budget_range'],
            'additional_information' => $review['additional_information'],
            'contact' => [
                'name' => $review['contact_name'],
                'email' => $review['contact_email'],
                'phone' => $review['contact_phone'],
                'company_name' => $review['company_name'],
                'preferred_contact_method' => $review['preferred_contact_method'],
            ],
            'ai' => [
                'recommended_service' => $session->recommended_service,
                'recommended_package' => $session->recommended_package,
                'complexity' => $session->complexity,
                'lead_score' => $session->lead_score,
                'ai_summary' => $session->ai_summary,
            ],
            'submitted_at' => now()->toIso8601String(),
        ];
    }

    /**
     * Record the consent documents the user accepted. Only records accepted
     * consents; acceptance is never inferred.
     */
    private function recordConsents(QuoteSession $session, QuoteSubmission $submission): void
    {
        $documents = config('quote.consent.documents', []);

        foreach ($documents as $document) {
            QuoteConsent::create([
                'quote_session_id' => $session->id,
                'quote_submission_id' => $submission->id,
                'consent_type' => $document['consent_type'] ?? 'privacy',
                'document' => $document['document'],
                'document_version' => $document['document_version'] ?? '1.0',
                'accepted' => true,
                'accepted_at' => now(),
            ]);
        }
    }
}
