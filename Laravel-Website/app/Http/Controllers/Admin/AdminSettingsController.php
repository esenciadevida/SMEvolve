<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminSettingsRequest;
use App\Models\Administrator;
use App\Services\Admin\AdminAuditService;
use App\Services\Admin\SiteSettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSettingsController extends Controller
{
    private const GROUPS = ['general', 'contact', 'business', 'social'];

    public function __construct(
        private readonly SiteSettingsService $settingsService,
        private readonly AdminAuditService $auditService,
    ) {}

    public function index(Request $request, string $group)
    {
        $this->authorizeGroup($group);

        $definitions = config("admin.settings.{$group}", []);

        $values = [];
        foreach (array_keys($definitions) as $key) {
            $values[$key] = config($key);
        }

        return view("admin.website.{$group}", [
            'group' => $group,
            'definitions' => $definitions,
            'values' => $values,
        ]);
    }

    public function update(AdminSettingsRequest $request, string $group)
    {
        $this->authorizeGroup($group);
        $this->authorize('admin.settings.update');

        $administrator = Auth::guard('admin')->user();

        if ($group === 'social') {
            $changed = $this->saveSocialLinks($request, $administrator);

            return redirect()->route('admin.settings.index', ['group' => 'social'])
                ->with('status', $changed ? 'Social links updated successfully.' : 'No changes were made.');
        }

        $definitions = config("admin.settings.{$group}", []);

        foreach ($definitions as $key => $definition) {
            $newValue = $request->has($key) ? $request->input($key) : null;
            $oldValue = config($key);

            if ($this->normalize($oldValue) === $this->normalize($newValue)) {
                continue;
            }

            $this->settingsService->set($key, $newValue, (string) $administrator->id);

            $this->auditService->log(
                'settings.update',
                'site_settings',
                $key,
                oldValue: $oldValue,
                newValue: $newValue,
                actor: $administrator,
                request: $request,
            );
        }

        return redirect()->route('admin.settings.index', ['group' => $group])
            ->with('status', 'Settings saved successfully.');
    }

    private function saveSocialLinks(Request $request, Administrator $administrator): bool
    {
        $current = collect(config('social_links.platforms', []));
        $submitted = collect($request->input('platforms', []))->mapWithKeys(function ($platform) {
            $platform = is_array($platform) ? $platform : [];
            $key = (string) ($platform['platform'] ?? '');

            return [$key => $platform];
        });

        $platforms = $current->map(function ($platform) use ($submitted) {
            $key = (string) ($platform['platform'] ?? '');
            $incoming = $submitted->get($key, []);
            $href = trim((string) ($incoming['href'] ?? ''));

            return array_merge($platform, [
                'href' => $href !== '' ? $href : null,
                'enabled' => (bool) ($incoming['enabled'] ?? false) && $href !== '',
            ]);
        })->values()->all();

        if ($this->sameSocialLinks(
            $this->settingsService->get('social_links.platforms', config('social_links.platforms')),
            $platforms
        )) {
            return false;
        }

        $old = config('social_links.platforms');
        $this->settingsService->set('social_links.platforms', $platforms, (string) $administrator->id);

        $this->auditService->log(
            'settings.update',
            'site_settings',
            'social_links.platforms',
            oldValue: $old,
            newValue: $platforms,
            actor: $administrator,
            request: $request,
        );

        return true;
    }

    /**
     * Compare only the fields that matter for social links (platform, href and
     * enabled state) so that saving an unchanged form does not create a new
     * site_settings audit entry or a redundant database write.
     */
    private function sameSocialLinks(mixed $old, array $new): bool
    {
        return json_encode($this->normalizeSocialLinks($old)) === json_encode($this->normalizeSocialLinks($new));
    }

    private function normalizeSocialLinks(mixed $value): array
    {
        $platforms = is_array($value) ? $value : [];

        return collect($platforms)->map(function ($platform) {
            $platform = is_array($platform) ? $platform : [];
            $href = trim((string) ($platform['href'] ?? ''));

            return [
                'platform' => (string) ($platform['platform'] ?? ''),
                'href' => $href !== '' ? $href : null,
                'enabled' => (bool) ($platform['enabled'] ?? false),
            ];
        })->values()->all();
    }

    private function authorizeGroup(string $group): void
    {
        if (! in_array($group, self::GROUPS, true)) {
            abort(404);
        }

        $this->authorize('admin.settings.view');
    }

    private function normalize(mixed $value): mixed
    {
        if (is_array($value)) {
            return $value;
        }

        if ($value === null) {
            return null;
        }

        $normalized = trim((string) $value);

        return $normalized === '' ? null : $normalized;
    }
}
