<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run Migrations Automatically (Render Free Plan)
|--------------------------------------------------------------------------
|
| En Render gratis no podemos usar la consola para ejecutar migraciones.
| Esta sección ejecuta automáticamente las migraciones pendientes al
| iniciar la aplicación, solo recomendable para demos o portafolios.
|
*/
if (app()->environment('production')) {
    try {
        \Artisan::call('migrate', ['--force' => true]);
    } catch (\Exception $e) {
        \Log::error('Error migrando DB: ' . $e->getMessage());
    }
}

// Handle the request and send the response...
$response = $app->handle(Request::capture());
$response->send();
