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
        $request->validate([
            'cod_hemoclasifi' => 'required|exists:hemoclasificacion,cod_hemoclasifi',
            'fec_tsh' => 'required|date',
            'resul_tsh' => 'required|string',
            'fec_pruetrepo' => 'required|date',
            'pruetreponemica' => 'required|string',
            'tamiza_aud' => 'required|string',
            'tamiza_cardi' => 'required|string',
            'tamiza_visual' => 'required|string',
        ]);

        $tamizacion = TamizacionNeonatal::create($request->all());
        return response()->json(['estado' => 'Ok', 'data' => $tamizacion], 201);
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
