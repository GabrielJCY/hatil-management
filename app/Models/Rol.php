<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
    use HasFactory;
    
    protected $table = 'Roles'; 

    protected $primaryKey = 'Rol_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Nombre_Rol',
    ];

    /**
     * Relación: Un rol puede tener muchos empleados.
     */
    public function empleados(): HasMany
    {
        return $this->hasMany(UsuarioEmp::class, 'Rol_id', 'Rol_id');
    }

    public function getRouteKeyName(): string
    {
        return 'Rol_id';
    }
}