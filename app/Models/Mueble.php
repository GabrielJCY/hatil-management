<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Mueble extends Model
{
    use HasFactory;
    
    protected $table = 'Muebles';
    protected $primaryKey = 'Mueble_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Nombre',
        'Descripcion',
        'Proveedor_id',
        'Precio',
        'Categoria_id',
        'Material',
        'Color',
        'Dimensiones',
        'Imagen',
        'Estado',
    ];


    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['Nombre'],
        );
    }
    
    protected function descripcion(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['Descripcion'],
        );
    }

    protected function precio(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['Precio'],
        );
    }
    
    protected function imagen(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['Imagen'],
        );
    }

    protected function estado(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['Estado'],
        );
    }

    
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'Proveedor_id', 'Proveedor_id');
    }

    
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'Categoria_id', 'Categoria_id');
    }

    public function inventario(): HasOne
    {
        return $this->hasOne(Stock::class, 'Mueble_id', 'Mueble_id');
    }

    public function detallesPedido(): HasMany
    {
        return $this->hasMany(Detalle_Pedido::class, 'Mueble_id', 'Mueble_id');
    }
}