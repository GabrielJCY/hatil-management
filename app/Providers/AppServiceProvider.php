<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation; // ⬅️ 1. Importar la clase Relation
use App\Models\UsuariosC; // ⬅️ 2. Importar el modelo UsuariosC
use App\Models\UsuarioEmp; // ⬅️ 3. Importar el modelo UsuarioEmp

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 4. Configurar el morphMap
        Relation::morphMap([
            'UsuariosC' => UsuariosC::class,
            'UsuarioEmp' => UsuarioEmp::class,
        ]);
    }
}