<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 🟢 AGREGAR la columna remember_token (necesaria para el login de Laravel)
            $table->string('remember_token', 100)->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 🟢 ELIMINAR la columna si se revierte la migración
            $table->dropColumn('remember_token');
        });
    }
};