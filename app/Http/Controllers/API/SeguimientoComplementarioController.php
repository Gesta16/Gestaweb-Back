<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SeguimientoComplementario;
use Illuminate\Http\Request;

class SeguimientoComplementarioController extends Controller
{
    
    public function index()
    {
        $seguimientos = SeguimientoComplementario::all();
        return response()->json($seguimientos);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'cod_sesiones' => 'required|exists:num_sesiones_curso_paternidad_maternidad,cod_sesiones',
            'fec_nutricion' => 'required|date',
            'fec_ginecologia' => 'required|date',
            'fec_psicologia' => 'required|date',
            'fec_odontologia' => 'required|date',
            'ina_seguimiento' => 'required|string',
            'cau_inasistencia' => 'nullable|string',
        ]);

        $seguimiento = SeguimientoComplementario::create($request->all());
        return response()->json($seguimiento, 201);
    }

    
    public function destroy($id)
    {
        $seguimiento = SeguimientoComplementario::findOrFail($id);
        $seguimiento->delete();
        return response()->json(null, 204);
    }
}
