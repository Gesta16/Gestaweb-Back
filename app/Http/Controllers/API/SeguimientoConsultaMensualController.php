<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SeguimientoConsultaMensual;
use Illuminate\Http\Request;

class SeguimientoConsultaMensualController extends Controller
{
    
    public function index()
    {
        $seguimientos = SeguimientoConsultaMensual::all();
        return response()->json($seguimientos);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'cod_riesgo' => 'required|exists:riesgo,cod_riesgo',
            'cod_controles' => 'required|exists:numero_controles,cod_controles',
            'cod_diagnostico' => 'required|exists:diagnostico_nutricional_mes,cod_diagnostico',
            'cod_medicion' => 'required|exists:forma_medicion_edad_gestacional,cod_medicion',
            'fec_consulta' => 'required|date',
            'edad_gestacional' => 'required|integer',
            'alt_uterina' => 'required|numeric',
            'trim_gestacional' => 'required|integer',
            'peso' => 'required|numeric',
            'talla' => 'required|numeric',
            'imc' => 'required|numeric',
            'ten_arts' => 'required|numeric',
            'ten_artd' => 'required|numeric',
        ]);

        $seguimiento = SeguimientoConsultaMensual::create($request->all());
        return response()->json($seguimiento, 201);
    }

    public function show($id)
    {
        $seguimiento = SeguimientoConsultaMensual::findOrFail($id);
        return response()->json($seguimiento);
    }

    
    public function destroy($id)
    {
        $seguimiento = SeguimientoConsultaMensual::findOrFail($id);
        $seguimiento->delete();
        return response()->json(null, 204);
    }
}
