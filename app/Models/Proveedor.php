<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    use HasFactory;
    
    protected $table = 'Proveedores';
    
    // Configuración para usar 'Proveedor_id' como clave primaria
    protected $primaryKey = 'Proveedor_id'; 
    public $incrementing = true; 
    
    // Campos permitidos para asignación masiva (eliminado 'Contacto')
    protected $fillable = [
        'Nombre', 
        // 'Contacto', <-- ELIMINADO
        'Telefono', 
        'Direccion', 
        'Ciudad', 
        'Pais', 
        'Email',
    ];

    public $timestamps = true; 
    
    // Relación con el modelo Mueble
    public function muebles(): HasMany
    {
        return $this->hasMany(Mueble::class, 'Proveedor_id', 'Proveedor_id');
    }
}