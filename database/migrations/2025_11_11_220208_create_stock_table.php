<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Stock', function (Blueprint $table) {
            $table->bigIncrements('Stock_id');
            
            $table->unsignedBigInteger('Mueble_id');
            $table->foreign('Mueble_id')->references('Mueble_id')->on('Muebles')->onDelete('cascade'); // Si el mueble se va, el stock se elimina
            
            $table->integer('Cantidad');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Stock');
    }
};