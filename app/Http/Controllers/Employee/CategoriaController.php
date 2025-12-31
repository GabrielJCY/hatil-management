<?php
namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Validation\Rule; 

class CategoriaController extends Controller
{
    
    
    public function index(Request $request)
    {
        $categorias = Categoria::orderBy('Nombre');
        
        $searchTerm = $request->search; 

        if ($searchTerm) {
            $searchTermLike = '%' . $searchTerm . '%';
            
            $categorias->where(function ($query) use ($searchTermLike) {
                $query->where('Nombre', 'like', $searchTermLike)
                      ->orWhere('Descripcion', 'like', $searchTermLike);
            });
        }
        
        $categorias = $categorias->paginate(10); 
        
        if ($searchTerm) {
            $categorias->appends(['search' => $searchTerm]);
        }
        
        return view('employee.categorias.index', compact('categorias'));
    }

    
 
    public function create()
    {
        return view('employee.categorias.create');
    }

    
 
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:Categorias,Nombre',
            'descripcion' => 'required|string|max:500',
        ]);
        
        Categoria::create([
            'Nombre' => $request->nombre,
            'Descripcion' => $request->descripcion,
        ]);

        return redirect()->route('admin.categorias.index')
                         ->with('success', '¡Categoría creada exitosamente!');
    }

   
   
    public function show(Categoria $categoria)
    {
        return redirect()->route('admin.categorias.index');
    }

    
    public function edit(Categoria $categoria)
    {
        return view('employee.categorias.edit', compact('categoria'));
    }

    
 
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('Categorias', 'Nombre')->ignore($categoria->Categoria_id, 'Categoria_id'),
            ],
            'descripcion' => 'required|string|max:500',
        ]);

        
        $categoria->update([
            'Nombre' => $request->nombre,
            'Descripcion' => $request->descripcion,
        ]);

        return redirect()->route('admin.categorias.index')
                         ->with('success', '¡Categoría actualizada exitosamente!');
    }

    
    public function destroy(Categoria $categoria)
    {
        try {
            $categoria->delete();
            return redirect()->route('admin.categorias.index')
                             ->with('success', '¡Categoría eliminada exitosamente!');
                             
        } catch (\Exception $e) {
            return redirect()->route('admin.categorias.index')
                             ->with('error', 'Error: No se puede eliminar la categoría porque tiene muebles asociados.');
        }
    }
}