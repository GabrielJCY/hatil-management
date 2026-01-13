<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Si la app está en modo mantenimiento
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Cargar autoload de Composer
require __DIR__.'/../vendor/autoload.php';

// Crear instancia de la aplicación Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// Manejar la solicitud HTTP y enviar la respuesta
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
