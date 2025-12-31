<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Detalle_Pedido', function (Blueprint $table) {
            $table->bigIncrements('Detalle_id');
            
            // --- FK a PEDIDOS (CORRECTA) ---
            $table->unsignedBigInteger('Pedido_id');
            $table->foreign('Pedido_id')->references('Pedido_id')->on('Pedidos'); 
            
            // --- FK a PAGOS (CORRECTA) ---
            $table->unsignedBigInteger('Pago_id')->nullable();
            $table->foreign('Pago_id')->references('Pago_id')->on('Pagos');
            
            // --- FK a MUEBLES (CORRECTA) ---
            $table->unsignedBigInteger('Mueble_id');
            $table->foreign('Mueble_id')->references('Mueble_id')->on('Muebles'); 
            
            // --- FK a EMPLEADO (CRÍTICA: CORREGIDA) ---
            $table->unsignedBigInteger('UsuarioEmp_id')->nullable();
            $table->foreign('UsuarioEmp_id')->references('UsuarioEmp_id')->on('UsuarioEmp'); 
            
            // --- FK a CLIENTE (CRÍTICA: CORREGIDA) ---
            $table->unsignedBigInteger('UsuarioC_id');
            $table->foreign('UsuarioC_id')->references('UsuarioC_id')->on('UsuariosC'); 
            
            $table->integer('Cantidad')->default(1);
            $table->decimal('Precio_Unitario', 10, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Detalle_Pedido');
    }
};