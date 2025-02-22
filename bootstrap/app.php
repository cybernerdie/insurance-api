<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Middleware\JsonHeaderMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        using: function () {
            Route::middleware('api')
            ->prefix('api')
            ->name('api.')
            ->group(base_path('routes/api.php'));

            Route::middleware('web')
            ->group(base_path('routes/web.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(append: [
            JsonHeaderMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

    })->create();
