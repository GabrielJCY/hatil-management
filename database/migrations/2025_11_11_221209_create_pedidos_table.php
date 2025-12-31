<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Pedidos', function (Blueprint $table) {
            $table->bigIncrements('Pedido_id'); // Clave Primaria

            // --- FK a USUARIO CLIENTE ---
            $table->unsignedBigInteger('UsuarioC_id');
            // CRÍTICO: Referencia a UsuarioC_id en la tabla UsuariosC
            $table->foreign('UsuarioC_id')->references('UsuarioC_id')->on('UsuariosC'); 

            // --- FK a USUARIO EMPLEADO ---
            $table->unsignedBigInteger('UsuarioEmp_id')->nullable();
            // CRÍTICO: Referencia a UsuarioEmp_id en la tabla UsuarioEmp
            $table->foreign('UsuarioEmp_id')->references('UsuarioEmp_id')->on('UsuarioEmp'); 
            
            $table->date('Fecha_pedido');
            $table->decimal('Total', 10, 2);
            $table->string('Estado', 30)->default('Pendiente');
            $table->string('Metodo_pago', 50);
            $table->string('Direccion_envio', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Pedidos');
    }
};