<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminSearchAutocompleteRequest;
use App\Http\Requests\Admin\AdminSearchRequest;
use App\Services\Search\SearchService;
use Illuminate\Support\Facades\Auth;

class AdminSearchController extends Controller
{
    public function __construct(
        private readonly SearchService $searchService,
    ) {}

    public function index(AdminSearchRequest $request)
    {
        $administrator = Auth::guard('admin')->user();

        $query = trim((string) $request->validated('q'));
        $type = $request->validated('type');
        $limit = (int) config('admin.search_results_per_resource', 5);

        $results = $query !== ''
            ? $this->searchService->search($administrator, $query, $type ? [$type] : [], $limit)
            : [];

        return view('admin.search.index', [
            'query' => $query,
            'activeType' => $type,
            'results' => $results,
            'availableTypes' => $this->searchService->availableResources($administrator),
            'totalResults' => collect($results)->flatten(1)->count(),
            'limit' => $limit,
        ]);
    }

    public function autocomplete(AdminSearchAutocompleteRequest $request)
    {
        $administrator = Auth::guard('admin')->user();

        $query = $request->validated('q');
        $type = $request->validated('type');
        $limit = (int) $request->validated('limit', config('admin.search_results_per_resource', 5));

        $results = $this->searchService->search($administrator, $query, $type ? [$type] : [], $limit);

        return response()->json([
            'query' => $query,
            'results' => $results,
            'total' => collect($results)->flatten(1)->count(),
        ]);
    }
}
