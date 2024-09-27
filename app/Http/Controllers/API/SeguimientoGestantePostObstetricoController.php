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
        $request->validate([
            'cod_metodo' => 'required|exists:metodos_anticonceptivos,cod_metodo',
            'con_egreso' => 'required|string',
            'fec_fallecimiento' => 'nullable|date',
            'fec_planificacion' => 'nullable|date',
        ]);

        $seguimiento = SeguimientoGestantePostObstetrico::create($request->all());
        return response()->json($seguimiento, 201); // 201 Created
    }

    
    public function destroy($id)
    {
        $seguimiento = SeguimientoGestantePostObstetrico::findOrFail($id);
        $seguimiento->delete();

        return response()->json(null, 204); 
    }
}
