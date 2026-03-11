<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
       // 1. Always log 500s to the specific file
    $exceptions->reportable(function (Throwable $e) {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/500.log'),
        ])->error('API/Web Error: ' . $e->getMessage());
    });

    // 2. Handle the Response based on request type
    $exceptions->render(function (Throwable $e, Request $request) {
        if (!config('app.debug') && !(config('app.env') == 'production' && config('app.APP_DEV') )) {
            $msg = 'There is an unexpected error, please contact the developer.';

            // If it's an API call (Expect: application/json)
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $msg
                ], 500);
            }

            // If it's a Web call, redirect back with session flash
            return back()->with('error_message', $msg);
        }
    });
    })->create();
