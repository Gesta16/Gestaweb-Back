<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EstudioHipotiroidismoCongenito;
use Illuminate\Http\Request;

class EstudioHipotiroidismoCongenitoController extends Controller
{
    
    public function index()
    {
        $estudios = EstudioHipotiroidismoCongenito::all();
        return response()->json(['estado' => 'Ok', 'data' => $estudios]);
    }

    
    public function store(Request $request)
    {

        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401); // 401 Unauthorized
        }

        $validatedData = $request->validate([
            'tsh' => 'required|string',
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'fec_resultado' => 'required|date',
            't4_libre' => 'required|string',
            'fec_resultadot4' => 'required|date',
            'eve_confirmado' => 'required|string',
            'fec_primera' => 'required|date',
        ]);

        $validatedData['id_operador'] = auth()->user()->userable_id;

        $estudio = EstudioHipotiroidismoCongenito::create($validatedData);
        return response()->json(['estado' => 'Ok', 'data' => $estudio], 201);
    }

    public function show($id)
    {
        $estudio = EstudioHipotiroidismoCongenito::find($id);
    
        if ($estudio) {
            return response()->json([
                'estado' => 'Ok',
                'data' => $estudio
            ], 200);
        } else {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Estudio de hipotiroidismo congénito no encontrado'
            ], 404);
        }
    }
    
    public function destroy($id)
    {
        $estudio = EstudioHipotiroidismoCongenito::findOrFail($id);
        $estudio->delete();
        return response()->json(['estado' => 'Ok', 'message' => 'Estudio eliminado correctamente']);
    }
}
