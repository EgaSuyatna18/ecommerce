<?php

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
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
            'isSeller' => \App\Http\Middleware\IsSeller::class,
            'isBuyer' => \App\Http\Middleware\IsBuyer::class,
            'isHasPayment' => \App\Http\Middleware\IsHasPayment::class,
            'isNotHasPayment' => \App\Http\Middleware\IsNotHasPayment::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            '/webhook_midtrans',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
