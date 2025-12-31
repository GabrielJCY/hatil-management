<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('carnet')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('password');
            
            // --- CAMPOS DE LA RELACIÓN POLIMÓRFICA (CRÍTICOS) ---
            // profile_id: Contiene el ID de la fila en la tabla de perfil (UsuarioEmp_id o UsuarioC_id)
            $table->unsignedBigInteger('profile_id')->nullable(); 
            
            // rol_type: Contiene la CLASE del modelo al que apunta (App\Models\UsuarioEmp o App\Models\UsuariosC)
            $table->string('rol_type')->nullable(); 
            
            $table->timestamps();
        });
    }
    // ... (función down)
};