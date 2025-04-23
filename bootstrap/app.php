<?php

use App\Http\Middleware\EnsureTodayIsWeekend;
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
//        $middleware->append(EnsureTodayIsWeekend::class);

        $middleware->alias([
            'weekend' => EnsureTodayIsWeekend::class
        ]);
//        $middleware->appendToGroup('test', [
//           // Your middlewares
//        ]);

//        $middleware->validateCsrfTokens(except: [
//            'stripe/*',
//            'car'
//        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
