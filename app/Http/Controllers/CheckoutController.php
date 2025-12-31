<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;      
use App\Models\Detalle_Pedido; // Cambiado para coincidir con el nombre de tu modelo
use App\Models\Pago;        
use App\Models\Mueble;      
use App\Models\User;        

class CheckoutController extends Controller
{
    public function index()
    {
        $carrito = $this->buildCarritoData(Session::get('carrito', []));

        if (count($carrito['items']) === 0) {
            return redirect()->route('client.catalogo.index')->with('error', 'Tu carrito está vacío.');
        }

        $user = Auth::user(); 
        return view('checkout.index', compact('carrito', 'user'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }

        $request->validate([
            'direccion_envio' => 'required|string|max:255',
            'metodo_pago' => 'required|in:Transferencia Bancaria,Tarjeta de Crédito,Efectivo',
            'nombre_cliente' => 'required|string|max:100', 
        ]);
        
        $carrito = $this->buildCarritoData(Session::get('carrito', []));

        DB::beginTransaction();

        try {
            // 1. Crear el Pedido
            // Usamos UsuarioC_id porque es el nombre en tu SQL para el cliente
            $pedido = new Pedido();
            $pedido->UsuarioC_id = Auth::id(); 
            $pedido->Fecha_pedido = now(); // Coincide con tu SQL (p minúscula)
            $pedido->Estado = 'Completado'; 
            $pedido->Direccion_envio = $request->input('direccion_envio');
            $pedido->Total = $carrito['total_general'];
            $pedido->Metodo_pago = $request->input('metodo_pago');
            $pedido->save();
            
            // 2. Registrar Detalles
            foreach ($carrito['items'] as $item) {
                $detalle = new Detalle_Pedido();
                $detalle->Pedido_id = $pedido->Pedido_id;
                $detalle->Mueble_id = $item['mueble']->Mueble_id;
                $detalle->Cantidad = $item['cantidad'];
                $detalle->Precio_Unitario = $item['mueble']->Precio;
                // Importante: Tu tabla Detalle_Pedido también pide UsuarioC_id
                $detalle->UsuarioC_id = Auth::id(); 
                $detalle->save();
            }

            // 3. Registrar el Pago
            $pago = new Pago();
            $pago->Pedido_id = $pedido->Pedido_id;
            $pago->Metodo_pago = $request->input('metodo_pago');
            $pago->Monto = $carrito['total_general'];
            $pago->Fecha_pago = now();
            $pago->Estado = 'Completado'; 
            $pago->save();

            DB::commit();

            Session::forget('carrito'); 

            return redirect()->route('client.catalogo.index')->with('status', 'HECHO');

        } catch (\Exception $e) {
            DB::rollBack();
            // Esto te mostrará el error exacto si falla el guardado
            return redirect()->back()->withInput()->with('error', 'Error en base de datos: ' . $e->getMessage());
        }
    }

    private function buildCarritoData($sessionItems)
    {
        $ids = array_keys($sessionItems);
        $muebles = Mueble::whereIn('Mueble_id', $ids)->get()->keyBy('Mueble_id');

        $itemsCompleto = [];
        $subtotalGeneral = 0;
        $costoEnvio = 50.00; 

        foreach ($sessionItems as $id => $data) {
            $mueble = $muebles->get($id);
            if ($mueble) {
                $subtotalItem = $mueble->Precio * $data['cantidad'];
                $subtotalGeneral += $subtotalItem;
                $itemsCompleto[] = [
                    'mueble' => $mueble,
                    'cantidad' => $data['cantidad'],
                    'subtotal' => $subtotalItem,
                ];
            }
        }
        
        return [
            'items' => $itemsCompleto,
            'subtotal_general' => $subtotalGeneral,
            'envio' => $costoEnvio,
            'total_general' => $subtotalGeneral + $costoEnvio,
        ];
    }
}