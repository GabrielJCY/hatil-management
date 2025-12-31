<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mueble;
use App\Models\Proveedor;
use App\Models\Categoria;
// NOTA: La línea 'use Illuminate\Database\Eloquent\Relations\HasOne;' ha sido eliminada

class MueblesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. OBTENER CLAVES FORÁNEAS NECESARIAS
        $proveedor = Proveedor::first();
        $categoriaSala = Categoria::where('Nombre', 'Salas de Estar')->first();
        $categoriaDormitorio = Categoria::where('Nombre', 'Dormitorios')->first();

        if (!$proveedor || !$categoriaSala || !$categoriaDormitorio) {
            $this->command->error('¡FALTAN DEPENDENCIAS! Asegúrate de ejecutar ProveedoresSeeder y CategoriasSeeder primero.');
            return;
        }

        // 2. CREAR EL MUEBLE (Sofá) y su STOCK
        $mueble_sofa = Mueble::create([
            'Nombre' => 'Sofá Lujo Modular',
            'Descripcion' => 'Sofá de diseño moderno con reposacabezas ajustables.',
            'Proveedor_id' => $proveedor->Proveedor_id,
            'Precio' => 6500.00,
            'Categoria_id' => $categoriaSala->Categoria_id,
            'Material' => 'Cuero Sintético',
            'Color' => 'Gris',
            'Dimensiones' => '3.0m x 2.0m',
            'Imagen' => 'url/imagen_sofa_lujo.jpg',
            'Estado' => 'Disponible',
        ]);
        
        // CRÍTICO: Crea el registro en la tabla Stock
        $mueble_sofa->inventario()->create([
            'Cantidad' => 25, 
        ]);


        // 3. CREAR EL MUEBLE (Cama) y su STOCK
        $mueble_cama = Mueble::create([
            'Nombre' => 'Cama Matrimonial Élite',
            'Descripcion' => 'Cama con base de somier integrado y acabados en madera de roble.',
            'Proveedor_id' => $proveedor->Proveedor_id,
            'Precio' => 3800.00,
            'Categoria_id' => $categoriaDormitorio->Categoria_id,
            'Material' => 'Madera de Roble',
            'Color' => 'Café Oscuro',
            'Dimensiones' => '2.0m x 1.6m',
            'Imagen' => 'url/imagen_cama.jpg',
            'Estado' => 'Disponible',
        ]);
        
        // CRÍTICO: Crea el registro en la tabla Stock
        $mueble_cama->inventario()->create([
            'Cantidad' => 40,
        ]);
    }
}