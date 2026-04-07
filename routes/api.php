<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Aerolineacontroller;  
use App\Http\Controllers\Api\Vuelocontroller;
use App\Http\Controllers\Api\Pasajerocontroller;

route ::get('/vuelos',function(){
    return response()->json(['mensaje' => 'hola vuelos']);
});
route::apiResource('aerolinea', Aerolineacontroller::class);
route::apiResource('vuelo', Vuelocontroller::class);
route::apiResource('pasajero', Pasajerocontroller::class);