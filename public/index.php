<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Si la app está en mantenimiento, mostrar la página de mantenimiento
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Cargar autoload de Composer
require __DIR__.'/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Ejecutar Migraciones Automáticamente (Render Gratis)
|--------------------------------------------------------------------------
| En Render gratis no hay shell, así que este bloque ejecuta las migraciones
| pendientes al iniciar la aplicación y también limpia los caches.
*/
if ($app->environment('production')) {
    try {
        // Ejecutar migraciones pendientes
        \Artisan::call('migrate', ['--force' => true]);
    } catch (\Exception $e) {
        // Guardar cualquier error en los logs
        \Log::error('Error migrando DB: ' . $e->getMessage());
    }

    // Limpiar y regenerar caches
    \Artisan::call('config:cache');
    \Artisan::call('route:cache');
    \Artisan::call('view:cache');
}

// Manejar la solicitud HTTP y enviar la respuesta
$response = $app->handle(Request::capture());
$response->send();


