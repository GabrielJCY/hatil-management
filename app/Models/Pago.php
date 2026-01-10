<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    use HasFactory;
    
    protected $table = 'pagos'; 
    
    protected $primaryKey = 'Pago_id';
    
    public $incrementing = true;
    
    protected $keyType = 'int';

    protected $fillable = [
        'Pedido_id',
        'Monto',
        'Metodo_Pago',
        'Fecha_pago',
        'Estado',
    ];

    protected $casts = [
        'Fecha_pago' => 'datetime',
    ];

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'Pedido_id', 'Pedido_id');
    }

}