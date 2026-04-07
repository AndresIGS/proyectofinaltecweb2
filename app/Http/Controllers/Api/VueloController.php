<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vuelo;
use App\Models\Aerolinea;

class VueloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cargar la relación con aerolínea para obtener más información
        $vuelos = Vuelo::with('aerolinea')->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $vuelos
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'aerolinea_id' => 'required|exists:aerolineas,id',
            'origen' => 'required|string|max:100',
            'destino' => 'required|string|max:100',
            'fecha_salida' => 'required|date',
            'fecha_llegada' => 'required|date|after:fecha_salida',
            'precio' => 'required|numeric|min:0',
            'asientos_disponibles' => 'required|integer|min:0'
        ]);

        $vuelo = Vuelo::create($validated);
        
        return response()->json([
            'status' => 'success',
            'data' => $vuelo->load('aerolinea')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vuelo = Vuelo::with('aerolinea')->find($id);
        
        if(!$vuelo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vuelo no encontrado'
            ], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $vuelo
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vuelo = Vuelo::find($id);
        
        if(!$vuelo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vuelo no encontrado'
            ], 404);
        }
        
        // Validar los datos
        $validated = $request->validate([
            'aerolinea_id' => 'sometimes|exists:aerolineas,id',
            'origen' => 'sometimes|string|max:100',
            'destino' => 'sometimes|string|max:100',
            'fecha_salida' => 'sometimes|date',
            'fecha_llegada' => 'sometimes|date|after:fecha_salida',
            'precio' => 'sometimes|numeric|min:0',
            'asientos_disponibles' => 'sometimes|integer|min:0'
        ]);
        
        $vuelo->update($validated);
        
        return response()->json([
            'status' => 'success',
            'data' => $vuelo->load('aerolinea')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vuelo = Vuelo::find($id);
        
        if(!$vuelo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vuelo no encontrado'
            ], 404);
        }
        
        $vuelo->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Vuelo eliminado correctamente'
        ], 200);
    }

}
