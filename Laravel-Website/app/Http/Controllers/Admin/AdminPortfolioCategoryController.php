<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortfolioCategoryStoreRequest;
use App\Http\Requests\Admin\PortfolioCategoryUpdateRequest;
use App\Models\PortfolioCategory;
use App\Services\Admin\AdminAuditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminPortfolioCategoryController extends Controller
{
    public function __construct(
        private readonly AdminAuditService $auditService,
    ) {
    }

    public function index(): View
    {
        $this->authorize('admin.portfolio.view');

        $categories = PortfolioCategory::query()
            ->withCount('projects')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.portfolio.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create(): View
    {
        $this->authorize('admin.portfolio.create');

        return view('admin.portfolio.categories.create');
    }

    public function store(PortfolioCategoryStoreRequest $request): RedirectResponse
    {
        $this->authorize('admin.portfolio.create');

        $category = PortfolioCategory::create([
            'slug' => $request->validated('slug'),
            'name' => $request->validated('name'),
            'icon' => $request->validated('icon'),
            'description' => $request->validated('description'),
            'sort_order' => (int) ($request->validated('sort_order') ?? 0),
            'is_published' => $request->boolean('is_published'),
        ]);

        $this->auditService->log(
            'portfolio_categories.create',
            'portfolio_categories',
            (string) $category->id,
            oldValue: null,
            newValue: ['slug' => $category->slug, 'name' => $category->name],
            actor: Auth::guard('admin')->user(),
            request: $request,
        );

        return redirect()->route('admin.portfolio.categories.index')
            ->with('status', 'Category created successfully.');
    }

    public function edit(PortfolioCategory $portfolio_category): View
    {
        $this->authorize('admin.portfolio.update');

        return view('admin.portfolio.categories.edit', [
            'category' => $portfolio_category,
        ]);
    }

    public function update(PortfolioCategoryUpdateRequest $request, PortfolioCategory $portfolio_category): RedirectResponse
    {
        $this->authorize('admin.portfolio.update');

        $old = ['slug' => $portfolio_category->slug, 'name' => $portfolio_category->name];

        $portfolio_category->update([
            'slug' => $request->validated('slug'),
            'name' => $request->validated('name'),
            'icon' => $request->validated('icon'),
            'description' => $request->validated('description'),
            'sort_order' => (int) ($request->validated('sort_order') ?? 0),
            'is_published' => $request->boolean('is_published'),
        ]);

        $this->auditService->log(
            'portfolio_categories.update',
            'portfolio_categories',
            (string) $portfolio_category->id,
            oldValue: $old,
            newValue: ['slug' => $portfolio_category->slug, 'name' => $portfolio_category->name],
            actor: Auth::guard('admin')->user(),
            request: $request,
        );

        return redirect()->route('admin.portfolio.categories.index')
            ->with('status', 'Category updated successfully.');
    }

    public function destroy(Request $request, PortfolioCategory $portfolio_category): RedirectResponse
    {
        $this->authorize('admin.portfolio.delete');

        $old = ['slug' => $portfolio_category->slug, 'name' => $portfolio_category->name];

        $portfolio_category->delete();

        $this->auditService->log(
            'portfolio_categories.delete',
            'portfolio_categories',
            (string) $portfolio_category->id,
            oldValue: $old,
            newValue: null,
            actor: Auth::guard('admin')->user(),
            request: $request,
        );

        return redirect()->route('admin.portfolio.categories.index')
            ->with('status', 'Category deleted. Projects in this category are now uncategorised.');
    }
}
