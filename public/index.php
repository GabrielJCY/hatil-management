<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run Migrations Automatically (Render Free Plan)
|--------------------------------------------------------------------------
*/
if ($app->environment('production')) {
    try {
        \Artisan::call('migrate', ['--force' => true]);
    } catch (\Exception $e) {
        \Log::error('Error migrando DB: ' . $e->getMessage());
    }

    \Artisan::call('config:cache');
    \Artisan::call('route:cache');
    \Artisan::call('view:cache');
}

$response = $app->handle(Request::capture());
$response->send();

