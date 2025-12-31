<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Muebles', function (Blueprint $table) {
            
            $table->bigIncrements('Mueble_id');
            $table->string('Nombre', 50);
            $table->string('Descripcion', 200)->nullable();
            
            $table->unsignedBigInteger('Proveedor_id');
            $table->foreign('Proveedor_id')->references('Proveedor_id')->on('Proveedores');
            
            $table->decimal('Precio', 10, 2); 
            
            $table->unsignedBigInteger('Categoria_id');
            $table->foreign('Categoria_id')->references('Categoria_id')->on('Categorias');
            
            $table->string('Material', 50)->nullable();
            $table->string('Color', 30)->nullable();
            $table->string('Dimensiones', 50)->nullable();
            $table->string('Imagen', 200)->nullable();
            $table->string('Estado', 30)->default('Activo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Muebles');
    }
};