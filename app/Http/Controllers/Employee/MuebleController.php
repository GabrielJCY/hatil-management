<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mueble;
use App\Models\Categoria; 
use App\Models\Proveedor;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Database\QueryException;

class MuebleController extends Controller
{
    public function index(Request $request)
    {
        $muebles = Mueble::with('categoria', 'proveedor'); 

        $searchTerm = $request->search; 

        if ($searchTerm) {
            $searchTermLike = '%' . $searchTerm . '%';
            
            $muebles->where(function ($query) use ($searchTermLike) {
                $query->where('Nombre', 'like', $searchTermLike)
                      ->orWhere('Descripcion', 'like', $searchTermLike)
                      ->orWhere('Material', 'like', $searchTermLike)
                      ->orWhere('Color', 'like', $searchTermLike);
            });
        }
        
        $muebles = $muebles->latest()->paginate(10); 
        
        if ($searchTerm) {
            $muebles = $muebles->appends(['search' => $searchTerm]);
        }
        
        return view('employee.muebles.index', compact('muebles'));
    }

    public function create()
    {
        $categorias = Categoria::all(); 
        $proveedores = Proveedor::all();

        return view('employee.muebles.create', compact('categorias', 'proveedores'));
    }

    public function store(Request $request)
    {
        // Ajustamos la validación para evitar el truncado antes de llegar a la DB
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'descripcion'  => 'required|string|max:2000', // Límite razonable
            'proveedor_id' => 'required|exists:Proveedores,Proveedor_id', 
            'precio'       => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:Categorias,Categoria_id',
            'material'     => 'required|string|max:100',
            'color'        => 'required|string|max:50',
            'dimensiones'  => 'required|string|max:255',
            'estado'       => 'required|string|max:50',
            'imagen'       => 'required|image|mimes:jpeg,png,jpg,gif,jfif|max:4096', 
        ]);

        try {
            // Guardamos la imagen
            $ruta_relativa = $request->file('imagen')->store('muebles', 'public');
            
            Mueble::create([
                'Nombre'       => $request->nombre,
                'Descripcion'  => $request->descripcion,
                'Proveedor_id' => $request->proveedor_id, 
                'Precio'       => $request->precio,
                'Categoria_id' => $request->categoria_id,
                'Material'     => $request->material, 
                'Color'        => $request->color,    
                'Dimensiones'  => $request->dimensiones, 
                'Estado'       => $request->estado,    
                'Imagen'       => $ruta_relativa,
            ]);

            return redirect()->route('admin.muebles.index')
                             ->with('success', '¡Mueble creado y cargado exitosamente!');

        } catch (QueryException $e) {
            // Si hay error de truncado u otro de SQL, borramos la imagen recién subida para no dejar basura
            if (isset($ruta_relativa)) {
                Storage::disk('public')->delete($ruta_relativa);
            }

            // Si el error es específicamente de truncado (String or binary data would be truncated)
            if (str_contains($e->getMessage(), 'truncated')) {
                return redirect()->back()
                                 ->withInput()
                                 ->with('error', 'Error: La descripción o algún campo es demasiado largo para la base de datos.');
            }

            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Ocurrió un error al guardar: ' . $e->getMessage());
        }
    }

    public function edit(Mueble $mueble) 
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();

        return view('employee.muebles.edit', compact('mueble', 'categorias', 'proveedores'));
    }

    public function update(Request $request, Mueble $mueble) 
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'descripcion'  => 'required|string|max:2000',
            'proveedor_id' => 'required|exists:Proveedores,Proveedor_id', 
            'precio'       => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:Categorias,Categoria_id',
            'material'     => 'required|string|max:100',
            'color'        => 'required|string|max:50',
            'dimensiones'  => 'required|string|max:255',
            'estado'       => 'required|string|max:50',
            'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,gif,jfif|max:4096', 
        ]);

        try {
            $data = [
                'Nombre'       => $request->nombre,
                'Descripcion'  => $request->descripcion,
                'Proveedor_id' => $request->proveedor_id,
                'Precio'       => $request->precio,
                'Categoria_id' => $request->categoria_id,
                'Material'     => $request->material,
                'Color'        => $request->color,
                'Dimensiones'  => $request->dimensiones,
                'Estado'       => $request->estado,
            ];

            if ($request->hasFile('imagen')) {
                if ($mueble->Imagen) {
                    Storage::disk('public')->delete($mueble->Imagen);
                }
                
                $ruta_relativa = $request->file('imagen')->store('muebles', 'public');
                $data['Imagen'] = $ruta_relativa;
            }

            $mueble->update($data);

            return redirect()->route('admin.muebles.index')
                             ->with('success', '¡Mueble actualizado exitosamente!');

        } catch (QueryException $e) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Error al actualizar: Asegúrese de que los textos no sean demasiado largos.');
        }
    }

    public function destroy(Mueble $mueble) 
    {
        try {
            $imagen_a_borrar = $mueble->Imagen;

            $mueble->delete();

            if ($imagen_a_borrar) {
                Storage::disk('public')->delete($imagen_a_borrar);
            }

            return redirect()->route('admin.muebles.index')
                             ->with('success', '¡Mueble eliminado exitosamente!');

        } catch (QueryException $e) {
            return redirect()->route('admin.muebles.index')
                             ->with('error', 'No se puede eliminar este mueble porque tiene registros asociados.');
        }
    }
}