<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol; 

class RolesSeeder extends Seeder
{
    
    public function run(): void
    {
        
        
        Rol::firstOrCreate(['Nombre_Rol' => 'Administrador']);
        Rol::firstOrCreate(['Nombre_Rol' => 'Vendedor']);
        Rol::firstOrCreate(['Nombre_Rol' => 'Cliente']);
        
    }
}