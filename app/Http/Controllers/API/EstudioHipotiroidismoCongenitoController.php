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
            'fec_resultado' => 'required|date',
            't4_libre' => 'required|string',
            'fec_resultadot4' => 'required|date',
            'eve_confirmado' => 'required|string',
            'fec_primera' => 'required|date',
        ]);

        $validatedData['id_operador'] = auth()->user()->userable_id;

        $estudio = EstudioHipotiroidismoCongenito::create($validatedData->all());
        return response()->json(['estado' => 'Ok', 'data' => $estudio], 201);
    }

    
    public function destroy($id)
    {
        $estudio = EstudioHipotiroidismoCongenito::findOrFail($id);
        $estudio->delete();
        return response()->json(['estado' => 'Ok', 'message' => 'Estudio eliminado correctamente']);
    }
}
