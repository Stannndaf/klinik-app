<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php', // ← TAMBAHKAN INI
    commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
    health: '/up',
)
    ->withMiddleware(function (Middleware $middleware) {

    $middleware->redirectGuestsTo(function () {
        return route('login');
    });

    $middleware->redirectUsersTo(function ($request) {

        if (auth()->check()) {

            $user = auth()->user();

            if ($user->role === 'admin') {
                return route('admin.dashboard');
            }

            if ($user->role === 'patient') {
                return route('patient.dashboard');
            }
        }

        return '/';
    });

    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
