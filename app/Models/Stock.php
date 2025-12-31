<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    use HasFactory;
    
    protected $table = 'Stock';
    protected $primaryKey = 'Stock_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Mueble_id',
        'Cantidad',
    ];

    /**
     * Relación: Un registro de stock pertenece a un mueble.
     */
    public function mueble(): BelongsTo
    {
        return $this->belongsTo(Mueble::class, 'Mueble_id', 'Mueble_id');
    }
}