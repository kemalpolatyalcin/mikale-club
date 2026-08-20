<?php

use App\Http\Middleware\AdvancedIpRateLimiter;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(AdvancedIpRateLimiter::class);
        $middleware->alias([
            'ip.throttle' => AdvancedIpRateLimiter::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
    })->create();
