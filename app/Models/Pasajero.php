<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pasajero extends Model
{
    use SoftDeletes;
    protected $fillable = ['vuelo_id','nombre_completo'];

    public function vuelo()
    {
        return $this->belongsTo(Vuelo::class);
    }
}
