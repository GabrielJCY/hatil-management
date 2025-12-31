<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Relation;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'carnet', 
        'profile_id', 
        'rol_type',  // Aquí se guardará 'admin', 'employee' o 'client'
    ];

    /**
     * Atributos que deben estar ocultos en la serialización.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atributos que deben ser convertidos a tipos específicos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación Polimórfica: Permite que el usuario tenga un perfil asociado.
     */
    public function profile(): MorphTo
    {
        // rol_type almacena el tipo (ej: admin) y profile_id el ID en la tabla destino.
        return $this->morphTo(null, 'rol_type', 'profile_id');
    }

    /**
     * EL MAPEO (CRÍTICO): 
     * Esto hace que Laravel entienda que si en la DB dice 'admin', 
     * debe buscar en el modelo Employee.
     */
    public static function boot()
    {
        parent::boot();

        Relation::morphMap([
            'admin'    => \App\Models\Employee::class,
            'employee' => \App\Models\Employee::class,
            'client'   => \App\Models\Client::class,
        ]);
    }
}