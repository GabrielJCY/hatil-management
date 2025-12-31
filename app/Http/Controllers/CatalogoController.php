<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mueble;      
use App\Models\Categoria;  

class CatalogoController extends Controller
{
   
    public function index(Request $request)
    {
        $categorias = Categoria::all();

        $query = Mueble::query();

        if ($request->filled('categoria')) {
            $query->where('Categoria_id', $request->input('categoria'));
        }

        if ($request->filled('min_precio')) {
            $query->where('Precio', '>=', $request->input('min_precio'));
        }

        if ($request->filled('max_precio')) {
            $query->where('Precio', '<=', $request->input('max_precio'));
        }

       
        $muebles = $query->paginate(9); 

        return view('catalogo.index', [
            'muebles' => $muebles,
            'categorias' => $categorias,
        ]);
    }

 
    public function show(Mueble $mueble)
    {
        
        return view('catalogo.show', [
            'mueble' => $mueble,
        ]);
    }
}