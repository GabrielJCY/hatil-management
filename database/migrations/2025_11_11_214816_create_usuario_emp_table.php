<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('UsuarioEmp', function (Blueprint $table) {
            
            $table->bigIncrements('UsuarioEmp_id'); // Clave Primaria Personalizada
            
            $table->string('Nombre', 50)->nullable();
            $table->string('Apellidos', 50)->nullable();
            $table->string('Carnet', 20)->nullable();
            $table->string('Correo', 100)->unique(); 
            $table->string('Telefono', 20)->nullable();
            $table->string('Direccion', 100)->nullable();
            $table->string('Ciudad', 50)->nullable();

            // Clave Foránea a Roles (Correcta)
            $table->unsignedBigInteger('Rol_id'); 
            $table->foreign('Rol_id')->references('Rol_id')->on('Roles');

            // $table->string('Contrasenia', 100); <--- ¡COLUMNA ELIMINADA!

            $table->date('Fecha_Registro')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('UsuarioEmp');
    }
};