<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Detalle_Pedido extends Model
{
    use HasFactory;
    
    protected $table = 'Detalle_Pedido';
    protected $primaryKey = 'Detalle_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Pedido_id',
        'Pago_id',
        'Mueble_id',
        'UsuarioC_id', // ¡AÑADE ESTO! Aunque sea un User único, tu SQL tiene esta columna.
        'Cantidad',
        'Precio_Unitario',
    ];

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'Pedido_id', 'Pedido_id');
    }

    public function mueble(): BelongsTo
    {
        return $this->belongsTo(Mueble::class, 'Mueble_id', 'Mueble_id');
    }
}