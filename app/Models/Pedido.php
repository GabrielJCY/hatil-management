<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pedido extends Model
{
    use HasFactory;
    
    protected $table = 'Pedidos';
    protected $primaryKey = 'Pedido_id';
    public $incrementing = true;
    protected $keyType = 'int';

    // IMPORTANTE: Deben ser los nombres exactos de tu tabla SQL
    protected $fillable = [
        'UsuarioC_id',  // Cambiado de Usuario_id a UsuarioC_id para que coincida con tu imagen
        'Fecha_pedido',
        'Total',
        'Estado',
        'Metodo_pago',
        'Direccion_envio',
    ];

    protected $casts = [
        'Fecha_pedido' => 'datetime',
    ];

    /**
     * Relación con la tabla Users única.
     * Aunque la columna se llame UsuarioC_id, apunta al id de Users.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UsuarioC_id', 'id');
    }

    public function pago(): HasOne
    {
        return $this->hasOne(Pago::class, 'Pedido_id', 'Pedido_id');
    }

    public function detalles(): HasMany
    {
        // Usamos el nombre del modelo que creaste: Detalle_Pedido
        return $this->hasMany(Detalle_Pedido::class, 'Pedido_id', 'Pedido_id');
    }
}