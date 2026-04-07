<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasajero;
use App\Models\Vuelo;
use App\Models\Reserva;

class PasajeroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cargar las reservas del pasajero
        $pasajeros = Pasajero::with('reservas.vuelo')->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $pasajeros
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|unique:pasajeros,email',
            'telefono' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'nullable|date',
            'pasaporte' => 'nullable|string|unique:pasajeros,pasaporte|max:20'
        ]);
        
        $pasajero = Pasajero::create($validated);
        
        return response()->json([
            'status' => 'success',
            'data' => $pasajero
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pasajero = Pasajero::with('reservas.vuelo.aerolinea')->find($id);
        
        if(!$pasajero) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pasajero no encontrado'
            ], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $pasajero
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pasajero = Pasajero::find($id);
        
        if(!$pasajero) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pasajero no encontrado'
            ], 404);
        }
        
        // Validar los datos
        $validated = $request->validate([
            'nombre' => 'sometimes|string|max:100',
            'apellido' => 'sometimes|string|max:100',
            'email' => 'sometimes|email|unique:pasajeros,email,' . $id,
            'telefono' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'nullable|date',
            'pasaporte' => 'nullable|string|unique:pasajeros,pasaporte,' . $id . '|max:20'
        ]);
        
        $pasajero->update($validated);
        
        return response()->json([
            'status' => 'success',
            'data' => $pasajero
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pasajero = Pasajero::find($id);
        
        if(!$pasajero) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pasajero no encontrado'
            ], 404);
        }
        
        // Verificar si tiene reservas activas
        if($pasajero->reservas()->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se puede eliminar el pasajero porque tiene reservas asociadas'
            ], 400);
        }
        
        $pasajero->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Pasajero eliminado correctamente'
        ], 200);
    }
    
    /**
     * Get flights for a specific passenger
     */
    public function getVuelos(string $id)
    {
        $pasajero = Pasajero::with('reservas.vuelo.aerolinea')->find($id);
        
        if(!$pasajero) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pasajero no encontrado'
            ], 404);
        }
        
        $vuelos = $pasajero->reservas->map(function($reserva) {
            return $reserva->vuelo;
        });
        
        return response()->json([
            'status' => 'success',
            'data' => $vuelos
        ], 200);
    }
}