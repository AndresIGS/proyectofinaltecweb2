<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vuelo;
use App\Models\Aerolinea;

class Aerolineacontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
    $aerolineas = Aerolinea::all();
    
    // Ya no devolvemos view('...'). Devolvemos JSON:
    return response()->json([
        'status' => 'success',
        'data' => $aerolineas
    ], 200); // 200 es el código HTTP para "OK"
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $aerolinea = Aerolinea::create($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $aerolinea
        ], 201); // 201 es el código HTTP para "Created"
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $aerolinea = Aerolinea::findOrFail($id);
        if(!$aerolinea) {
            return response()->json([
                'status' => 'error',
                'message' => 'Aerolínea no encontrada'
            ], 404); // 404 es el código HTTP para "Not Found"
        }
        return response()->json([
            'status' => 'success',
            'data' => $aerolinea
        ], 200); // 200 es el código HTTP para "OK"
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $aerolinea = Aerolinea::findOrFail($id);
        if(!$aerolinea) {
            return response()->json([
                'status' => 'error',
                'message' => 'Aerolínea no encontrada'
            ], 404); // 404 es el código HTTP para "Not Found"
        }
        $aerolinea->update($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $aerolinea
        ], 200); // 200 es el código HTTP para "OK"
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $aerolinea = Aerolinea::findOrFail($id);
        if(!$aerolinea) {
            return response()->json([
                'status' => 'error',
                'message' => 'Aerolínea no encontrada'
            ], 404); // 404 es el código HTTP para "Not Found"
        }
        $aerolinea->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Aerolínea eliminada correctamente'
        ], 200); // 200 es el código HTTP para "OK"
    }
}
