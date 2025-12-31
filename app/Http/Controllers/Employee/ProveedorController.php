<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Necesario para la validación unique

class ProveedorController extends Controller
{
    /**
     * Muestra una lista de todos los proveedores.
     */
    public function index()
    {
        $proveedores = Proveedor::orderBy('Nombre')->paginate(10);
        return view('employee.proveedores.index', compact('proveedores'));
    }

    /**
     * Muestra el formulario para crear un nuevo proveedor.
     */
    public function create()
    {
        return view('employee.proveedores.create');
    }

    /**
     * Almacena un nuevo proveedor creado en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validación de datos (Sin 'Contacto')
        $request->validate([
            'Nombre' => 'required|string|max:255|unique:Proveedores,Nombre',
            'Telefono' => 'nullable|string|max:20',
            'Direccion' => 'nullable|string|max:255',
            'Ciudad' => 'required|string|max:100',
            'Pais' => 'required|string|max:100',
            'Email' => 'required|email|max:255|unique:Proveedores,Email',
        ]);

        // 2. Creación del proveedor
        Proveedor::create($request->all());

        // 3. Redirección con mensaje de éxito
        return redirect()->route('admin.proveedores.index')
                         ->with('success', 'Proveedor creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un proveedor existente.
     * Se usa la inyección manual del ID para compatibilidad con la ruta personalizada.
     */
    public function edit($Proveedor_id)
    {
        // 1. Buscar el proveedor por su clave primaria
        $proveedor = Proveedor::findOrFail($Proveedor_id);
        
        // 2. Pasar a la vista
        return view('employee.proveedores.edit', compact('proveedor'));
    }

    /**
     * Actualiza el proveedor especificado en la base de datos.
     * Se usa la inyección manual del ID para compatibilidad con la ruta personalizada.
     */
    public function update(Request $request, $Proveedor_id)
    {
        // 1. Buscar el proveedor usando el ID.
        $proveedor = Proveedor::findOrFail($Proveedor_id);
        
        // 2. Validación de datos
        $request->validate([
            // Usamos Rule::unique para que sea más claro y robusto
            'Nombre' => ['required', 'string', 'max:255', 
                        Rule::unique('Proveedores', 'Nombre')->ignore($proveedor->Proveedor_id, 'Proveedor_id')],
            'Telefono' => 'nullable|string|max:20',
            'Direccion' => 'nullable|string|max:255',
            'Ciudad' => 'required|string|max:100',
            'Pais' => 'required|string|max:100',
            'Email' => ['required', 'email', 'max:255', 
                        Rule::unique('Proveedores', 'Email')->ignore($proveedor->Proveedor_id, 'Proveedor_id')],
        ]);

        // 3. Actualización del proveedor
        $proveedor->update($request->all());

        // 4. Redirección con mensaje de éxito
        return redirect()->route('admin.proveedores.index')
                         ->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Elimina el proveedor especificado del almacenamiento.
     */
    public function destroy($Proveedor_id)
    {
        // Buscar el proveedor o fallar (404)
        $proveedor = Proveedor::findOrFail($Proveedor_id);
        
        try {
            $proveedor->delete();
            return redirect()->route('admin.proveedores.index')
                             ->with('success', 'Proveedor eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.proveedores.index')
                             ->with('error', 'Error al eliminar. Asegúrese de que no haya muebles vinculados a este proveedor.');
        }
    }
}