<?php

namespace App\Http\Controllers;

use App\Http\Requests\Public\PublicSearchAutocompleteRequest;
use App\Http\Requests\Public\PublicSearchRequest;
use App\Services\Search\PublicSearchService;

class SearchController extends Controller
{
    public function __construct(
        private readonly PublicSearchService $searchService,
    ) {
    }

    public function index(PublicSearchRequest $request)
    {
        $query = trim((string) $request->validated('q'));
        $type = $request->validated('type');
        $limit = (int) config('website.search.results_per_resource', 5);

        $results = $query !== ''
            ? $this->searchService->search($query, $type ? [$type] : [], $limit)
            : [];

        return view('pages.search', [
            'query' => $query,
            'activeType' => $type,
            'results' => $results,
            'availableTypes' => $this->searchService->availableResources(),
            'totalResults' => $this->searchService->total($results),
            'limit' => $limit,
        ]);
    }

    public function autocomplete(PublicSearchAutocompleteRequest $request)
    {
        $query = $request->validated('q');
        $type = $request->validated('type');
        $limit = (int) $request->validated('limit', config('website.search.results_per_resource', 5));

        $results = $this->searchService->search($query, $type ? [$type] : [], $limit);

        return response()->json([
            'query' => $query,
            'results' => $results,
            'total' => $this->searchService->total($results),
        ]);
    }
}
