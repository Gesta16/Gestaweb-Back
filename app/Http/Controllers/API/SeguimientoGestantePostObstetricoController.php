<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SeguimientoGestantePostObstetrico;
use Illuminate\Http\Request;

class SeguimientoGestantePostObstetricoController extends Controller
{
    
    public function index()
    {
        $seguimientos = SeguimientoGestantePostObstetrico::all();
        return response()->json($seguimientos);
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
            'cod_metodo' => 'required|exists:metodos_anticonceptivos,cod_metodo',
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'con_egreso' => 'required|string',
            'fec_fallecimiento' => 'nullable|date',
            'fec_planificacion' => 'nullable|date',
        ]);

        $validatedData['id_operador'] = auth()->user()->userable_id;

        $seguimiento = SeguimientoGestantePostObstetrico::create($validatedData);
        return response()->json($seguimiento, 201); // 201 Created
    }

    
    public function destroy($id)
    {
        $seguimiento = SeguimientoGestantePostObstetrico::findOrFail($id);
        $seguimiento->delete();

        return response()->json(null, 204); 
    }
}
