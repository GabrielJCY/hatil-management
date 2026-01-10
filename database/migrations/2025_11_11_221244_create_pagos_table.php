<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Pagos', function (Blueprint $table) {
            $table->bigIncrements('Pago_id');
            
            $table->unsignedBigInteger('Pedido_id');
            $table->foreign('Pedido_id')->references('Pedido_id')->on('Pedidos');

            $table->decimal('Monto', 10, 2);
            $table->string('Metodo_pago', 50);
            $table->date('Fecha_pago');
            $table->string('Estado', 30);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Pagos');
    }
};