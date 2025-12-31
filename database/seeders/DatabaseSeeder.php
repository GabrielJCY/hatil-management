<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\RolesSeeder;
use Database\Seeders\ProveedoresSeeder;
use Database\Seeders\CategoriasSeeder;
use Database\Seeders\MueblesSeeder;
use Database\Seeders\UsuariosSeeder;
use Database\Seeders\PedidosSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call([
            // 1. Tablas Maestras (sin dependencias)
            RolesSeeder::class,
            ProveedoresSeeder::class,
            CategoriasSeeder::class,
            
            // 2. Tablas con dependencias de Maestras
            // MueblesSeeder también crea los registros de Stock
            MueblesSeeder::class, 
            
            // 3. Tablas de Usuarios (Depende de Roles)
            // UsuariosSeeder crea UsuarioEmp, UsuariosC y los registros en 'users'
            UsuariosSeeder::class,
            
            // 4. Tablas de Transacciones (Depende de todo lo anterior)
            // PedidosSeeder crea Pedidos, Pagos y Detalle_Pedido
            PedidosSeeder::class, 
        ]);
    }
}