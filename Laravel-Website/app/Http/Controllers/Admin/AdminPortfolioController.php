<?php

namespace App\Http\Controllers\Admin;

use App\Data\ServicesData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortfolioProjectStoreRequest;
use App\Http\Requests\Admin\PortfolioProjectUpdateRequest;
use App\Models\PortfolioCategory;
use App\Models\PortfolioProject;
use App\Services\Admin\AdminAuditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminPortfolioController extends Controller
{
    public function __construct(
        private readonly AdminAuditService $auditService,
    ) {}

    public function index(Request $request): View
    {
        $this->authorize('admin.portfolio.view');

        $projects = PortfolioProject::query()
            ->with('category')
            ->when($request->string('q')->trim()->value(), function ($query, string $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('title', 'like', "%{$term}%")
                        ->orWhere('slug', 'like', "%{$term}%");
                });
            })
            ->when($request->string('category')->trim()->value(), fn ($query, string $slug) => $query->whereHas('category', fn ($q) => $q->where('slug', $slug)))
            ->when($request->string('published')->trim()->value(), fn ($query, string $value) => $query->where('is_published', $value === 'yes'))
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(25)
            ->withQueryString();

        return view('admin.portfolio.index', [
            'projects' => $projects,
            'categories' => PortfolioCategory::orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        $this->authorize('admin.portfolio.create');

        return view('admin.portfolio.create', $this->formData());
    }

    public function store(PortfolioProjectStoreRequest $request): RedirectResponse
    {
        $this->authorize('admin.portfolio.create');

        $payload = $this->payload($request);
        $project = PortfolioProject::create($payload);

        $this->audit($request, 'portfolio.create', $project, null, $payload);

        return redirect()->route('admin.portfolio.index')
            ->with('status', 'Project created successfully.');
    }

    public function edit(PortfolioProject $portfolio_project): View
    {
        $this->authorize('admin.portfolio.update');

        return view('admin.portfolio.edit', [
            'project' => $portfolio_project,
            ...$this->formData(),
        ]);
    }

    public function update(PortfolioProjectUpdateRequest $request, PortfolioProject $portfolio_project): RedirectResponse
    {
        $this->authorize('admin.portfolio.update');

        $payload = $this->payload($request);
        $old = $portfolio_project->toArray();

        $portfolio_project->update($payload);

        $this->deleteReplacedUploads($old, $payload);

        $this->audit($request, 'portfolio.update', $portfolio_project, $old, $portfolio_project->fresh()->toArray());

        return redirect()->route('admin.portfolio.index')
            ->with('status', 'Project updated successfully.');
    }

    public function destroy(Request $request, PortfolioProject $portfolio_project): RedirectResponse
    {
        $this->authorize('admin.portfolio.delete');

        $old = $portfolio_project->only('slug', 'title');
        $project = $portfolio_project;
        $portfolio_project->delete();

        $this->deleteProjectUploads($project);

        $this->auditService->log(
            'portfolio.delete',
            'portfolio_projects',
            (string) $portfolio_project->id,
            oldValue: $old,
            newValue: null,
            actor: Auth::guard('admin')->user(),
            request: $request,
        );

        return redirect()->route('admin.portfolio.index')
            ->with('status', 'Project deleted.');
    }

    public function togglePublish(Request $request, PortfolioProject $portfolio_project): RedirectResponse
    {
        $this->authorize('admin.portfolio.publish');

        $old = $portfolio_project->is_published;
        $portfolio_project->update(['is_published' => ! $old]);

        $this->auditService->log(
            'portfolio.publish',
            'portfolio_projects',
            (string) $portfolio_project->id,
            oldValue: $old,
            newValue: ! $old,
            actor: Auth::guard('admin')->user(),
            request: $request,
        );

        return back()->with('status', $old ? 'Project unpublished.' : 'Project published.');
    }

    /**
     * Normalised payload for create/update, including decoded JSON fields and
     * service names resolved from the selected service slugs.
     *
     * @return array<string, mixed>
     */
    private function payload(PortfolioProjectStoreRequest $request): array
    {
        $validated = $request->validated();

        $services = app(ServicesData::class)->catalog()->keyBy('slug');

        $servicesSlugs = collect($validated['services_slugs'] ?? [])
            ->map(fn (string $slug) => trim($slug))
            ->filter()
            ->unique()
            ->values()
            ->all();

        return [
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'portfolio_category_id' => $validated['portfolio_category_id'] ?? null,
            'status' => $validated['status'],
            'featured' => $request->boolean('featured'),
            'is_published' => $request->boolean('is_published'),
            'image' => $this->resolveMainImage($request, $validated),
            'industry' => $validated['industry'] ?? null,
            'project_type' => $validated['project_type'] ?? null,
            'summary' => $validated['summary'] ?? null,
            'short_description' => $validated['short_description'],
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'services' => collect($servicesSlugs)->map(fn (string $slug) => $services->get($slug)['name'] ?? $slug)->all(),
            'services_slugs' => $servicesSlugs,
            'technologies' => collect(explode(',', (string) ($validated['technologies'] ?? '')))
                ->map(fn (string $value) => trim($value))
                ->filter()
                ->values()
                ->all(),
            'gallery' => $this->normalizeGalleryRows($request, $validated['gallery'] ?? null),
            'challenge' => $this->normalizeHeadingSection($validated['challenge'] ?? null),
            'solution' => $this->normalizeHeadingSection($validated['solution'] ?? null),
            'features' => $this->normalizeRows($validated['features'] ?? null, ['icon', 'title', 'description']),
            'outcome' => $this->normalizeHeadingSection($validated['outcome'] ?? null),
            'meta' => $this->normalizeMeta($validated['meta'] ?? null),
        ];
    }

    /**
     * Normalise a heading, description and one-point-per-line textarea into the
     * array shape the public project page renders. Returns null when empty.
     *
     * @param  array<string, mixed>|null  $value
     * @return array{heading: string, description: string, points: list<string>}|null
     */
    private function normalizeHeadingSection(?array $value): ?array
    {
        if ($value === null) {
            return null;
        }

        $heading = trim((string) ($value['heading'] ?? ''));
        $description = trim((string) ($value['description'] ?? ''));
        $points = $this->linesToArray((string) ($value['points'] ?? ''));

        if ($heading === '' && $description === '' && $points === []) {
            return null;
        }

        return [
            'heading' => $heading,
            'description' => $description,
            'points' => $points,
        ];
    }

    /**
     * Main project image: an uploaded file wins over a pasted URL.
     *
     * @param  array<string, mixed>  $validated
     */
    private function resolveMainImage(PortfolioProjectStoreRequest $request, array $validated): ?string
    {
        if ($request->hasFile('image_upload')) {
            return $this->storeUpload($request->file('image_upload'));
        }

        return $validated['image'] ?? null;
    }

    /**
     * Store an uploaded image under /upload/portfolio and return its public URL.
     */
    private function storeUpload(UploadedFile $file): string
    {
        $path = $file->store('portfolio', 'web_uploads');

        return asset('upload/'.$path);
    }

    /**
     * Gallery rows; an uploaded file on a row overrides the row's Image URL.
     *
     * @param  array<string, mixed>|null  $value
     * @return list<array<string, string>>|null
     */
    private function normalizeGalleryRows(PortfolioProjectStoreRequest $request, ?array $value): ?array
    {
        if ($value === null) {
            return null;
        }

        $rows = [];

        foreach ($value as $index => $row) {
            if (! is_array($row)) {
                continue;
            }

            if ($request->hasFile("gallery.{$index}.image_upload")) {
                $row['image'] = $this->storeUpload($request->file("gallery.{$index}.image_upload"));
            }

            $item = [];

            foreach (['label', 'type', 'image'] as $field) {
                $item[$field] = isset($row[$field]) ? trim((string) $row[$field]) : '';
            }

            if (array_filter($item, static fn (string $value) => $value !== '') === []) {
                continue;
            }

            $rows[] = $item;
        }

        return $rows === [] ? null : $rows;
    }

    /**
     * Remove our own uploaded files that are no longer referenced after an
     * update (replaced image or a gallery row removed/overwritten). External
     * URLs are never touched.
     *
     * @param  array<string, mixed>  $old
     * @param  array<string, mixed>  $payload
     */
    private function deleteReplacedUploads(array $old, array $payload): void
    {
        $oldImage = $old['image'] ?? null;
        $newImage = $payload['image'] ?? null;

        if (is_string($oldImage) && $oldImage !== $newImage) {
            $this->deleteUpload($oldImage);
        }

        $oldGallery = collect($old['gallery'] ?? [])->pluck('image')->filter();
        $newGallery = collect($payload['gallery'] ?? [])->pluck('image')->filter();

        foreach ($oldGallery as $oldUrl) {
            if (! $newGallery->contains($oldUrl)) {
                $this->deleteUpload($oldUrl);
            }
        }
    }

    /**
     * Remove every uploaded file owned by a project (called when it is deleted).
     */
    private function deleteProjectUploads(PortfolioProject $project): void
    {
        $this->deleteUpload($project->image);

        foreach ($project->gallery ?? [] as $row) {
            $this->deleteUpload($row['image'] ?? null);
        }
    }

    /**
     * Delete a file we manage, honouring a strict path prefix so external URLs
     * and unrelated files are never touched.
     */
    private function deleteUpload(?string $url): void
    {
        if (! is_string($url) || $url === '') {
            return;
        }

        $path = parse_url($url, PHP_URL_PATH);

        if (! is_string($path) || ! str_starts_with($path, '/upload/portfolio/')) {
            return;
        }

        $relative = ltrim(substr($path, strlen('/upload/')), '/');

        Storage::disk('web_uploads')->delete($relative);
    }

    /**
     * Normalise a list of rows (features) into the array shape the
     * public project page renders, dropping empty rows. Returns null when no
     * rows remain.
     *
     * @param  array<string, mixed>|null  $value
     * @param  list<string>  $fields
     * @return list<array<string, string>>|null
     */
    private function normalizeRows(?array $value, array $fields): ?array
    {
        if ($value === null) {
            return null;
        }

        $rows = [];

        foreach ($value as $row) {
            if (! is_array($row)) {
                continue;
            }

            $item = [];

            foreach ($fields as $field) {
                $item[$field] = isset($row[$field]) ? trim((string) $row[$field]) : '';
            }

            if (array_filter($item, static fn (string $value) => $value !== '') === []) {
                continue;
            }

            $rows[] = $item;
        }

        return $rows === [] ? null : $rows;
    }

    /**
     * @param  array<string, mixed>|null  $value
     * @return array{title: string, description: string}|null
     */
    private function normalizeMeta(?array $value): ?array
    {
        if ($value === null) {
            return null;
        }

        $title = trim((string) ($value['title'] ?? ''));
        $description = trim((string) ($value['description'] ?? ''));

        if ($title === '' && $description === '') {
            return null;
        }

        return [
            'title' => $title,
            'description' => $description,
        ];
    }

    /**
     * Split a one-point-per-line textarea into a trimmed list.
     *
     * @return list<string>
     */
    private function linesToArray(string $value): array
    {
        $lines = preg_split('/\r\n|\r|\n/', $value);

        if ($lines === false) {
            return [];
        }

        return array_values(array_filter(
            array_map(static fn (string $line) => trim($line), $lines),
            static fn (string $line) => $line !== '',
        ));
    }

    private function audit(Request $request, string $action, PortfolioProject $project, ?array $old, array $new): void
    {
        $this->auditService->log(
            $action,
            'portfolio_projects',
            (string) $project->id,
            oldValue: $old !== null ? ['slug' => $old['slug'], 'title' => $old['title']] : null,
            newValue: ['slug' => $project->slug, 'title' => $project->title],
            actor: Auth::guard('admin')->user(),
            request: $request,
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(): array
    {
        return [
            'categories' => PortfolioCategory::orderBy('sort_order')->orderBy('name')->get(),
            'services' => app(ServicesData::class)->catalog(),
        ];
    }
}
