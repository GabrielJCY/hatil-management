<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UsuariosC;
use App\Models\UsuarioEmp;
use App\Models\Mueble;
use App\Models\Pedido;
use App\Models\Pago;
use App\Models\Detalle_Pedido;

class PedidosSeeder extends Seeder
{
    public function run(): void
    {
        $cliente_auth = User::where('rol_type', UsuariosC::class)->first();
        $empleado_auth = User::where('rol_type', UsuarioEmp::class)->first();

        $cliente_id = $cliente_auth->profile_id;
        $empleado_id = $empleado_auth->profile_id;
        
        $mueble_sofa = Mueble::where('Nombre', 'Sofá Lujo Modular')->first();
        $mueble_cama = Mueble::where('Nombre', 'Cama Matrimonial Élite')->first();

        if (!$cliente_id || !$empleado_id || !$mueble_sofa || !$mueble_cama) {
            $this->command->error('¡FALTAN DEPENDENCIAS!');
            return;
        }

        $subtotal = 0;
        $precio_sofa = $mueble_sofa->Precio;
        $precio_cama = $mueble_cama->Precio;
        
        $subtotal += 1 * $precio_sofa;
        $subtotal += 2 * $precio_cama; 
        
        $pedido = Pedido::create([
            'UsuarioC_id' => $cliente_id, 
            'UsuarioEmp_id' => $empleado_id, 
            'Fecha_pedido' => now(), 
            'Estado' => 'Completado',
            'Total' => $subtotal, 
            'Metodo_pago' => 'Tarjeta de Crédito',
            'Direccion_envio' => 'Av. Test 123, La Paz',
        ]);

   
        $pago = Pago::create([
            'Pedido_id' => $pedido->Pedido_id, 
            'Monto' => $subtotal, 
            'Metodo_pago' => 'Tarjeta de Crédito', 
            'Fecha_pago' => now(), 
            'Estado' => 'Aprobado', 
        ]);
        
       
        Detalle_Pedido::create([
            'Pedido_id' => $pedido->Pedido_id,
            'Pago_id' => $pago->Pago_id, 
            'Mueble_id' => $mueble_sofa->Mueble_id,
            'UsuarioEmp_id' => $empleado_id, 
            'UsuarioC_id' => $cliente_id,   
            'Cantidad' => 1,
            'Precio_Unitario' => $precio_sofa,
        ]);

        Detalle_Pedido::create([
            'Pedido_id' => $pedido->Pedido_id,
            'Pago_id' => $pago->Pago_id, 
            'Mueble_id' => $mueble_cama->Mueble_id,
            'UsuarioEmp_id' => $empleado_id, 
            'UsuarioC_id' => $cliente_id,   
            'Cantidad' => 2,
            'Precio_Unitario' => $precio_cama,
        ]);
        
        $this->command->info('Pedido de: ' . $pedido->Total . ' creado exitosamente!');
    }
}