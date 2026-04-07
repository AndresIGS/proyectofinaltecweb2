<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aerolinea extends Model
{
    use SoftDeletes; // Inyectamos el poder de no borrar datos reales

    protected $fillable = ['nombre'];

    public function vuelos()
    {
        return $this->hasMany(Vuelo::class);
    }
}
