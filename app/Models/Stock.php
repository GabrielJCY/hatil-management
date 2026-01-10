<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    
    protected $table = 'Stock';
    protected $primaryKey = 'Stock_id';
    
    protected $fillable = ['Mueble_id', 'Cantidad'];
    
   
    public function mueble()
    {
        return $this->belongsTo(Mueble::class, 'Mueble_id', 'Mueble_id');
    }
}