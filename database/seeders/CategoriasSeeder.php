<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🟢 CORRECCIÓN: Usamos firstOrCreate, buscando por el campo 'nombre'
        Categoria::firstOrCreate(
            ['nombre' => 'Salas de Estar'], // Condición de búsqueda
            [
                'descripcion' => 'Sofás, sillones, mesas de centro y accesorios para el salón.',
            ]
        );

        Categoria::firstOrCreate(
            ['nombre' => 'Dormitorios'],
            [
                'descripcion' => 'Camas, colchones, mesitas de noche y cómodas.',
            ]
        );
        
        Categoria::firstOrCreate(
            ['nombre' => 'Comedores'],
            [
                'descripcion' => 'Juegos de mesa y sillas, bufeteras y vitrinas.',
            ]
        );

        Categoria::firstOrCreate(
            ['nombre' => 'Oficina'],
            [
                'descripcion' => 'Escritorios, sillas ergonómicas y estanterías.',
            ]
        );
    }
}