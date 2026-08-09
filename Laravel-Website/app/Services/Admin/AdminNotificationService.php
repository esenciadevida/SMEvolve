<?php

namespace App\Services\Admin;

use App\Mail\SecurityAlert;
use App\Models\Administrator;
use App\Models\AdminNotification;
use App\Models\AdminNotificationPreference;
use Illuminate\Support\Facades\Mail;

/**
 * Records and sends administrator security notifications. Critical events are
 * always delivered regardless of per-administrator preferences. A delivery
 * failure is recorded on the notification row and reported, but never blocks
 * the underlying administrative action.
 */
class AdminNotificationService
{
    /**
     * The event catalogue, keyed by event name.
     *
     * @return array<string, array{label: string, description: string, critical: bool}>
     */
    public function events(): array
    {
        return config('admin.notifications.events', []);
    }

    public function channel(): string
    {
        return (string) config('admin.notifications.channel', 'email');
    }

    public function isCritical(string $event): bool
    {
        return (bool) ($this->events()[$event]['critical'] ?? false);
    }

    /**
     * Whether a notification for the given event was recorded within the
     * trailing window. Used to debounce alert emails during repeated attacks;
     * the underlying events remain fully audit-logged.
     */
    public function hasRecent(string $event, int $minutes = 15): bool
    {
        return AdminNotification::query()
            ->where('event', $event)
            ->where('created_at', '>=', now()->subMinutes($minutes))
            ->exists();
    }

    /**
     * Merge stored preferences with the defaults for an administrator.
     *
     * @return array<string, bool>
     */
    public function preferencesFor(Administrator $administrator): array
    {
        $stored = AdminNotificationPreference::query()
            ->where('administrator_id', $administrator->id)
            ->where('channel', $this->channel())
            ->pluck('enabled', 'event')
            ->all();

        $preferences = [];

        foreach (array_keys($this->events()) as $event) {
            $preferences[$event] = $this->isCritical($event) || (bool) ($stored[$event] ?? true);
        }

        return $preferences;
    }

    /**
     * @param  array<string, bool>  $enabledEvents
     */
    public function savePreferences(Administrator $administrator, array $enabledEvents): void
    {
        $channel = $this->channel();

        foreach (array_keys($this->events()) as $event) {
            $enabled = $this->isCritical($event) ? true : (bool) ($enabledEvents[$event] ?? true);

            AdminNotificationPreference::updateOrCreate(
                ['administrator_id' => $administrator->id, 'event' => $event, 'channel' => $channel],
                ['enabled' => $enabled],
            );
        }
    }

    /**
     * @param  array<int, Administrator>|null  $recipients  Explicit recipients; otherwise resolved automatically.
     * @param  list<string>  $messageLines
     * @param  array<int, array{label: string, value: string}>  $details
     */
    public function notify(
        string $event,
        string $subject,
        array $messageLines = [],
        ?array $recipients = null,
        ?string $actionUrl = null,
        ?string $actionText = null,
        array $details = [],
    ): void {
        if (! isset($this->events()[$event])) {
            return;
        }

        foreach ($this->resolveRecipients($recipients) as $administrator) {
            if (! $this->isCritical($event) && ! $this->preferencesFor($administrator)[$event]) {
                continue;
            }

            $notification = AdminNotification::create([
                'administrator_id' => $administrator->id,
                'event' => $event,
                'channel' => $this->channel(),
                'subject' => mb_substr($subject, 0, 190),
                'body' => $this->renderBody($messageLines, $details),
                'status' => AdminNotification::STATUS_PENDING,
            ]);

            try {
                Mail::to($administrator->email)
                    ->send(new SecurityAlert(
                        event: $event,
                        subjectLine: $subject,
                        messageLines: $messageLines,
                        actionUrl: $actionUrl,
                        actionText: $actionText,
                        details: $details,
                    ));

                $notification->update([
                    'status' => AdminNotification::STATUS_SENT,
                    'sent_at' => now(),
                ]);
            } catch (\Throwable $e) {
                $notification->update([
                    'status' => AdminNotification::STATUS_FAILED,
                    'error' => mb_substr($e->getMessage(), 0, 1000),
                ]);

                report($e);
            }
        }
    }

    /**
     * Resolve the recipients for an event: explicit list when provided,
     * otherwise configured default addresses, otherwise all active super
     * administrators, otherwise the fallback address.
     *
     * @param  array<int, Administrator>|null  $recipients
     * @return array<int, Administrator>
     */
    private function resolveRecipients(?array $recipients): array
    {
        if ($recipients !== null && $recipients !== []) {
            return array_values(array_filter($recipients));
        }

        $byEmail = Administrator::query()
            ->whereIn('email', config('admin.notifications.default_recipients', []))
            ->get();

        if ($byEmail->isNotEmpty()) {
            return $byEmail->all();
        }

        $superAdmins = Administrator::query()
            ->where('is_active', true)
            ->whereHas('role', fn ($query) => $query->where('name', 'super_admin'))
            ->get();

        if ($superAdmins->isNotEmpty()) {
            return $superAdmins->all();
        }

        $fallback = config('admin.notifications.fallback_recipient');

        if (is_string($fallback) && $fallback !== '') {
            $placeholder = new Administrator;
            $placeholder->forceFill(['id' => null, 'email' => $fallback]);

            return [$placeholder];
        }

        return [];
    }

    /**
     * @param  list<string>  $messageLines
     * @param  array<int, array{label: string, value: string}>  $details
     */
    private function renderBody(array $messageLines, array $details): string
    {
        $body = implode("\n", $messageLines);

        if ($details === []) {
            return $body;
        }

        $rows = array_map(
            fn ($detail) => $detail['label'].': '.$detail['value'],
            $details
        );

        return $body === '' ? implode("\n", $rows) : $body."\n".implode("\n", $rows);
    }
}
