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
        
        // 1. Saltamos la protección CSRF para evitar el error 419
        $middleware->validateCsrfTokens(except: [
            'login',
            'logout',
            'register',
        ]);

        // 2. 🛑 AGREGA ESTO: Asegura que la sesión sea persistente 
        // Ayuda a que Laravel no "olvide" al usuario al saltar de una página a otra en XAMPP.
        $middleware->statefulApi();

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();