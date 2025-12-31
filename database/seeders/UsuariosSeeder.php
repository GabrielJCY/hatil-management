<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Rol;
use App\Models\UsuarioEmp;
use App\Models\UsuariosC;
use App\Models\User;

class UsuariosSeeder extends Seeder
{
    
    public function run(): void
    {
        $rolAdmin = Rol::where('Nombre_Rol', 'Administrador')->first();
        $rolVendedor = Rol::where('Nombre_Rol', 'Vendedor')->first();
        
        if (!$rolAdmin || !$rolVendedor) {
            $this->command->error('¡FALTAN ROLES! Asegúrate de ejecutar RolesSeeder primero.');
            return;
        }

  
        $empleado_perfil = UsuarioEmp::firstOrCreate(
            ['Correo' => 'admin@hatil.com'],
            [
                'Nombre' => 'Admin', 
                'Apellidos' => 'Sistema', 
                'Telefono' => '70000000', 
                'Direccion' => 'Oficina Central', 
                'Ciudad' => 'La Paz',
                'Rol_id' => $rolAdmin->Rol_id, 
                'Fecha_Registro' => now(),
                'Carnet' => '9999999',
            ]
        );


        
        User::firstOrCreate(
            ['email' => 'admin@hatil.com'],
            [
                'name' => 'Admin Sistema', 
                'carnet' => '9999999', 
                'password' => Hash::make('password'),
                'profile_id' => $empleado_perfil->UsuarioEmp_id, 
                'rol_type' => UsuarioEmp::class, 
            ]
        );
        
        
        $cliente_perfil = UsuariosC::firstOrCreate(
            ['Correo' => 'maria.perez@cliente.com'],
            [
                'Nombre' => 'Maria', 
                'Apellidos' => 'Perez', 
                'Telefono' => '65432109', 
                'Direccion' => 'Av. Test 123', 
                'Carnet' => '1122334', 
            ]
        );
        
        
        User::firstOrCreate(
            ['email' => 'maria.perez@cliente.com'],
            [
                'name' => 'Maria Perez', 
                'carnet' => '1122334', 
                'password' => Hash::make('password'),
                'profile_id' => $cliente_perfil->UsuarioC_id, 
                'rol_type' => UsuariosC::class, 
            ]
        );
    }
}