<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol; // Asegúrate de que este modelo exista

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🟢 CORRECCIÓN: Usamos firstOrCreate para evitar errores de duplicidad.
        // Si el rol ya existe, no hace nada; si no existe, lo crea.
        
        Rol::firstOrCreate(['Nombre_Rol' => 'Administrador']);
        Rol::firstOrCreate(['Nombre_Rol' => 'Vendedor']);
        Rol::firstOrCreate(['Nombre_Rol' => 'Cliente']);
        
    }
}