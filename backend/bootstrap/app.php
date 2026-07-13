<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\FlareClient\Api;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Explicitly prepend HandleCors so preflight OPTIONS requests are
        // answered with CORS headers before the request ever reaches the
        // router. Without this, an OPTIONS preflight to a path with no
        // registered OPTIONS route (apiResource only registers
        // GET/POST/PUT/PATCH/DELETE) 404s before any CORS header can be
        // attached — which is exactly what showed up as "404" on the
        // preflight + "CORS error" on the real request in devtools.
        $middleware->prepend(\Illuminate\Http\Middleware\HandleCors::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
