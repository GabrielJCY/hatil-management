<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Proveedores', function (Blueprint $table) {
            $table->bigIncrements('Proveedor_id');
            $table->string('Nombre', 50);
            $table->string('Direccion', 100);
            $table->string('Ciudad', 50);
            $table->string('Pais', 50);
            $table->string('Telefono', 20);
            $table->string('Email', 100)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Proveedores');
    }
};