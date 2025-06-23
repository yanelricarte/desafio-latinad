<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Display extends Model
{
    use HasFactory;

    /**
     * Atributos que se pueden asignar en masa.
     */
    protected $fillable = [
        'name',
        'description',
        'price_per_day',
        'resolution_height',
        'resolution_width',
        'type',
        'user_id'
    ];

    /**
     * Relación: una pantalla pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
