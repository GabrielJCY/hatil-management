<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mueble; 
use App\Models\Stock; // 🟢 ¡Importante! Necesitamos el modelo Stock
use Illuminate\Validation\Rule; 


class StockController extends Controller
{
    /**
     * Muestra la lista de muebles con su stock.
     */
    public function index()
    {
        // Se usa paginate(10) para manejar grandes cantidades de datos.
        $muebles = Mueble::with('inventario') 
                         ->orderBy('Nombre')
                         ->paginate(10); 

        return view('employee.stock.index', compact('muebles'));
    }

    
    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function destroy(string $id) {}
    

    /**
     * Muestra el formulario para editar el stock de un mueble.
     * Si el registro de Stock no existe, lo crea automáticamente con Cantidad = 0.
     * @param  int  $id (Mueble_id)
     */
    public function edit(string $id)
    {
        $mueble = Mueble::with('inventario')->findOrFail($id);
        
        // 🟢 CORRECCIÓN CLAVE: Si no hay inventario, lo creamos 🟢
        if (!$mueble->inventario) {
            
            // Creamos la entrada de stock faltante con cantidad inicial cero (0)
            Stock::create([
                'Mueble_id' => $mueble->Mueble_id,
                'Cantidad' => 0, 
            ]);
            
            // Recargamos la relación 'inventario' en el modelo $mueble
            $mueble->load('inventario');
            
            // Opcional: Podrías añadir un mensaje de éxito si deseas notificar que se creó la entrada:
            // session()->flash('info', 'Se ha creado automáticamente un registro de stock inicial (Cantidad: 0) para este mueble.');
        }

        return view('employee.stock.edit', compact('mueble'));
    }

    /**
     * Actualiza la cantidad de stock del mueble.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id (Mueble_id)
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            // La cantidad debe ser requerida, un número entero y no negativa.
            'Cantidad' => ['required', 'integer', 'min:0'], 
        ]);

        $mueble = Mueble::findOrFail($id);

        // Usamos el método update() de la relación 'inventario'
        $mueble->inventario()->update([
            'Cantidad' => $request->Cantidad
        ]);

        return redirect()->route('admin.stock.index')
                         ->with('success', 'El stock del mueble "' . $mueble->Nombre . '" ha sido actualizado correctamente.');
    }
}