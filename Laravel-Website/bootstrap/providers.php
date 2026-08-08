<?php

use App\Providers\AdminServiceProvider;
use App\Providers\AiServiceProvider;
use App\Providers\AppServiceProvider;
use App\Providers\SearchServiceProvider;

return [
    AppServiceProvider::class,
    AiServiceProvider::class,
    AdminServiceProvider::class,
    SearchServiceProvider::class,
];
