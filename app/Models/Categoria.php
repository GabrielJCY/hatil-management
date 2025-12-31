<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    use HasFactory;
    
    protected $table = 'Categorias';
    protected $primaryKey = 'Categoria_id'; 
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Nombre',
        'Descripcion',
    ];

    
    public function muebles(): HasMany
    {
        return $this->hasMany(Mueble::class, 'Categoria_id', 'Categoria_id');
    }
}