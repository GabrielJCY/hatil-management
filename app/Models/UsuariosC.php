<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class UsuariosC extends Model
{
    use HasFactory;
    
    protected $table = 'UsuariosC';

    protected $primaryKey = 'UsuarioC_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
       'Nombre',
       'Apellidos',
       'Carnet',
       'Correo',
       'Telefono',
       'Direccion',
    ];
    
    
    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'profile');
    }
    
    public function getNombreAttribute()
    {
        return $this->attributes['Nombre'] ?? null;
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'UsuarioC_id', 'UsuarioC_id');
    }
}