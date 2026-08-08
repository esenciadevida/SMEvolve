<?php

namespace App\Http\Controllers;

use App\Data\Portfolio\PortfolioData;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(PortfolioData $data): View
    {
        return view('pages.portfolio.index', [
            'categories' => $data->categories(),
            'featured' => $data->featured(),
            'projects' => $data->catalog(),
        ]);
    }

    public function category(PortfolioData $data, string $category): View
    {
        $category = $data->category($category);

        abort_unless($category, 404);

        return view('pages.portfolio.category', [
            'category' => $category,
            'categories' => $data->categories(),
            'projects' => $data->byCategory($category['slug']),
        ]);
    }

    public function show(PortfolioData $data, string $slug): View
    {
        $project = $data->find($slug);

        abort_unless($project, 404);

        return view('pages.portfolio.show', [
            'project' => $project,
            'relatedProjects' => $data->related($slug),
            'prevProject' => $data->prev($slug),
            'nextProject' => $data->next($slug),
            'relatedServices' => $data->relatedServices($project),
        ]);
    }
}
