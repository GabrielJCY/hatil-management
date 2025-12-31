<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mueble; 
use Illuminate\Support\Facades\Session;

class CarritoController extends Controller
{
    public function index()
    {
        $items = Session::get('carrito', []);
        $carrito = $this->buildCarritoData($items);

        return view('carrito.index', compact('carrito'));
    }

    public function add(Mueble $mueble, Request $request)
    {
        $id = $mueble->Mueble_id;
        $carrito = Session::get('carrito', []);
        
        $cantidad = $request->input('cantidad', 1);

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] += $cantidad;
        } else {
            $carrito[$id] = [
                "id" => $id,
                "cantidad" => $cantidad,
            ];
        }

        Session::put('carrito', $carrito);

        // SUGERENCIA: Redirigir de vuelta al catálogo con un mensaje 
        // o al carrito si quieres que el cliente vea su compra de inmediato.
        return redirect()->route('client.carrito.index')->with('success', 'Mueble añadido al carrito.');
    }

    public function update(Mueble $mueble, Request $request)
    {
        $id = $mueble->Mueble_id;
        $cantidad = $request->input('cantidad');

        if ($cantidad <= 0) {
            return $this->remove($mueble);
        }

        $carrito = Session::get('carrito', []);
        
        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] = $cantidad;
            Session::put('carrito', $carrito);
            // CORREGIDO: cliente -> client
            return redirect()->route('client.carrito.index')->with('success', 'Cantidad actualizada.');
        }

        return redirect()->route('client.carrito.index');
    }

    public function remove(Mueble $mueble)
    {
        $id = $mueble->Mueble_id;
        $carrito = Session::get('carrito', []);

        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            Session::put('carrito', $carrito);
        }
        
        // CORREGIDO: cliente -> client
        return redirect()->route('client.carrito.index')->with('success', 'Mueble eliminado del carrito.');
    }

    private function buildCarritoData($sessionItems)
    {
        $ids = array_keys($sessionItems);
        
        // Obtenemos los muebles y cargamos la relación Stock para validar cantidades si fuera necesario
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
            'envio' => $subtotalGeneral > 0 ? $costoEnvio : 0, // No cobrar envío si está vacío
            'total_general' => $subtotalGeneral > 0 ? ($subtotalGeneral + $costoEnvio) : 0,
        ];
    }
}