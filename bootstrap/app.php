<?php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\EnsureAdminIsAuthenticated;
use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->encryptCookies(except: []);

        $middleware->web(append: [
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->alias([
            'auth.admin' => EnsureAdminIsAuthenticated::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
