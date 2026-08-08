<?php

use App\Http\Middleware\AdminAuthenticate;
use App\Http\Middleware\EnsureAdminAuthenticated;
use App\Http\Middleware\EnsureAdminHasPermission;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'ai.admin' => EnsureAdminAuthenticated::class,
            'admin.auth' => AdminAuthenticate::class,
            'admin.permission' => EnsureAdminHasPermission::class,
        ]);

        $middleware->web(append: [
            SecurityHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
