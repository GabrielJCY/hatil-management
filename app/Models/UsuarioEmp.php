<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsuarioEmp extends Model
{
    use HasFactory;
    
    // Nombre de la tabla
    protected $table = 'UsuarioEmp';

    // CLAVE PRIMARIA CRÍTICA: Coincide con tu esquema
    protected $primaryKey = 'UsuarioEmp_id'; 
    public $incrementing = true;
    protected $keyType = 'int';

    // Se eliminó 'Contrasenia' para usar la tabla 'users' como fuente de seguridad.
    protected $fillable = [
       'Nombre', 
       'Apellidos',
       'Carnet',
       'Correo',
       'Telefono',
       'Direccion',
       'Ciudad',
       'Rol_id', 
       'Fecha_Registro',
    ];

    
    public function user(): MorphOne
    {
        // Relación polimórfica hacia la tabla 'users' (el hub de autenticación)
        return $this->morphOne(User::class, 'profile'); 
    }

    
    public function rol(): BelongsTo
    {
        // Relación BelongsTo para obtener los detalles del Rol
        return $this->belongsTo(Rol::class, 'Rol_id', 'Rol_id'); 
    }

    // Accessor para leer el atributo 'Nombre'
    public function getNombreAttribute()
    {
        return $this->attributes['Nombre'] ?? null;
    }
}