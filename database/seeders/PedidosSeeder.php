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
        // 1. OBTENER DEPENDENCIAS
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
        
        // Calcular el total ANTES de crear el Pedido/Pago
        $subtotal += 1 * $precio_sofa;
        $subtotal += 2 * $precio_cama; 
        
        // 2. CREAR EL PEDIDO (Tabla Pedidos)
        $pedido = Pedido::create([
            'UsuarioC_id' => $cliente_id, 
            'UsuarioEmp_id' => $empleado_id, 
            'Fecha_pedido' => now(), 
            'Estado' => 'Completado',
            'Total' => $subtotal, // Usamos el total calculado
            'Metodo_pago' => 'Tarjeta de Crédito',
            'Direccion_envio' => 'Av. Test 123, La Paz',
        ]);

        // 3. REGISTRAR EL PAGO (Tabla Pagos)
        // *** CORREGIDO: 'Monto' según tu lista de columnas ***
        $pago = Pago::create([
            'Pedido_id' => $pedido->Pedido_id, 
            'Monto' => $subtotal, // ⬅️ ¡CORREGIDO! Usando 'Monto'
            'Metodo_pago' => 'Tarjeta de Crédito', 
            'Fecha_pago' => now(), // Usando 'Fecha_pago' (asumimos minúscula)
            'Estado' => 'Aprobado', // ⬅️ ¡AGREGADO! Columna 'Estado' en la tabla Pagos, asumimos valor 'Aprobado'.
        ]);
        
        // 4. AÑADIR DETALLES DEL PEDIDO (Tabla Detalle_Pedido)
        
        // Detalle 1: Sofá
        Detalle_Pedido::create([
            'Pedido_id' => $pedido->Pedido_id,
            'Pago_id' => $pago->Pago_id, 
            'Mueble_id' => $mueble_sofa->Mueble_id,
            'UsuarioEmp_id' => $empleado_id, 
            'UsuarioC_id' => $cliente_id,   
            'Cantidad' => 1,
            'Precio_Unitario' => $precio_sofa,
            // 'Subtotal' ELIMINADO
        ]);

        // Detalle 2: Cama
        Detalle_Pedido::create([
            'Pedido_id' => $pedido->Pedido_id,
            'Pago_id' => $pago->Pago_id, 
            'Mueble_id' => $mueble_cama->Mueble_id,
            'UsuarioEmp_id' => $empleado_id, 
            'UsuarioC_id' => $cliente_id,   
            'Cantidad' => 2,
            'Precio_Unitario' => $precio_cama,
            // 'Subtotal' ELIMINADO
        ]);
        
        $this->command->info('Pedido de: ' . $pedido->Total . ' creado exitosamente!');
    }
}