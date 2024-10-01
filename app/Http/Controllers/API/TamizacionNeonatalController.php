<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TamizacionNeonatal;
use Illuminate\Http\Request;

class TamizacionNeonatalController extends Controller
{
    
    public function index()
    {
        $tamizaciones = TamizacionNeonatal::all();
        return response()->json(['estado' => 'Ok', 'data' => $tamizaciones]);
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
            'cod_hemoclasifi' => 'required|exists:hemoclasificacion,cod_hemoclasifi',
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'fec_tsh' => 'required|date',
            'resul_tsh' => 'required|string',
            'fec_pruetrepo' => 'required|date',
            'pruetreponemica' => 'required|string',
            'tamiza_aud' => 'required|string',
            'tamiza_cardi' => 'required|string',
            'tamiza_visual' => 'required|string',
        ]);

        $validatedData['id_operador'] = auth()->user()->userable_id;

        $tamizacion = TamizacionNeonatal::create($validatedData);
        return response()->json(['estado' => 'Ok', 'data' => $tamizacion], 201);
    }

    public function show($id)
    {
        $tamizacion = TamizacionNeonatal::find($id);
    
        if ($tamizacion) {
            return response()->json([
                'estado' => 'Ok',
                'data' => $tamizacion
            ], 200);
        } else {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Registro de tamización neonatal no encontrado'
            ], 404);
        }
    }
    
    public function destroy($id)
    {
        $tamizacion = TamizacionNeonatal::find($id);

        if (!$tamizacion) {
            return response()->json(['estado' => 'Error', 'mensaje' => 'Registro no encontrado'], 404);
        }

        $tamizacion->delete();
        return response()->json(['estado' => 'Ok', 'mensaje' => 'Registro eliminado correctamente']);
    }
}
