<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proveedor;

class ProveedoresSeeder extends Seeder
{
   
    public function run(): void
    {
       
        
        Proveedor::firstOrCreate(
            ['email' => 'contacto@maderasdelsur.com'], 
            [
                'nombre' => 'Maderas del Sur S.A.',
                'direccion' => 'Calle 23, Zona Sur',
                'ciudad' => 'La Paz',
                'pais' => 'Bolivia',
                'telefono' => '2456789',
            ]
        );

        Proveedor::firstOrCreate(
            ['email' => 'ventas@tapicesmodernos.com'], 
            [
                'nombre' => 'Tapices Modernos LTDA',
                'direccion' => 'Av. El Alto 105',
                'ciudad' => 'El Alto',
                'pais' => 'Bolivia',
                'telefono' => '2887654',
            ]
        );
        
        
}
}
