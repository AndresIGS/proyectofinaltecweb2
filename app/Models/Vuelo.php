<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Vuelo extends Model
{

    use SoftDeletes; // Inyectamos el poder de no borrar datos reales

    protected $fillable = ['aerolinea_id', 'destino'];

    public function aerolinea() 
    {
        return $this->belongsTo(Aerolinea::class);
    }

    public function pasajeros() 
    {
        return $this->hasMany(Pasajero::class);
    }
}

