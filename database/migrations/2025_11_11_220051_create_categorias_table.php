<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Categorias', function (Blueprint $table) {
            $table->bigIncrements('Categoria_id');
            $table->string('Nombre', 50)->unique();
            $table->string('Descripcion', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Categorias');
    }
};