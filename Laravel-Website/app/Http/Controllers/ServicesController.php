<?php

namespace App\Http\Controllers;

use App\Data\ServicesData;
use Illuminate\View\View;

class ServicesController extends Controller
{
    public function index(ServicesData $data): View
    {
        return view('pages.services.index', [
            'services' => $data->catalog(),
        ]);
    }

    public function show(ServicesData $data, string $service): View
    {
        $service = $data->catalog()->firstWhere('slug', $service);

        abort_unless($service, 404);

        return view('pages.services.show', [
            'service' => $service,
            'relatedServices' => $data->related($service['slug']),
        ]);
    }
}
