<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaboratorioIIITrimestre;

class LaboratorioIIITrimestreController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401); 
        }

        $laboratorios = LaboratorioIIITrimestre::all();
        return response()->json($laboratorios);
    }

    public function show($id)
    {
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401); 
        }

        $laboratorio = LaboratorioIIITrimestre::findOrFail($id);
        return response()->json($laboratorio);
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401); 
        }

        $validatedData = $request->validate([
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'hemograma' => 'required|string',
            'fec_hemograma' => 'required|date',
            'pru_vih' => 'required|string',
            'fec_vih' => 'required|date',
            'pru_sifilis' => 'required|string',
            'fec_sifilis' => 'required|date',
            'ig_toxoplasma' => 'required|string',
            'fec_toxoplasma' => 'required|date',
            'cul_rectal' => 'required|string',
            'fec_rectal' => 'required|date',
            'fec_biofisico' => 'required|date',
            'edad_gestacional' => 'required|integer|min:0',
            'rie_biopsicosocial' => 'required|string',
        ]);

        $validatedData['id_operador'] = auth()->user()->userable_id;

        $laboratorio = LaboratorioIIITrimestre::create($validatedData);

        return response()->json([
            'estado' => 'Ok',
            'data' => $laboratorio
        ], 201);
    }

    public function update(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401); 
        }

        $laboratorio = LaboratorioIIITrimestre::findOrFail($id);
        $validatedData = $request->validate([
            'id_operador' => 'sometimes|exists:operador,id_operador',
            'id_usuario' => 'sometimes|exists:usuario,id_usuario',
            'hemograma' => 'sometimes|string',
            'fec_hemograma' => 'sometimes|date',
            'pru_vih' => 'sometimes|string',
            'fec_vih' => 'sometimes|date',
            'pru_sifilis' => 'sometimes|string',
            'fec_sifilis' => 'sometimes|date',
            'ig_toxoplasma' => 'sometimes|string',
            'fec_toxoplasma' => 'sometimes|date',
            'cul_rectal' => 'sometimes|string',
            'fec_rectal' => 'sometimes|date',
            'fec_biofisico' => 'sometimes|date',
            'edad_gestacional' => 'sometimes|integer|min:0',
            'rie_biopsicosocial' => 'sometimes|string',
        ]);

        $laboratorio->update($validatedData);
        return response()->json([
            'estado' => 'Ok',
            'data' => $laboratorio
        ]);
    }

    public function destroy($id)
    {
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401); 
        }

        $laboratorio = LaboratorioIIITrimestre::findOrFail($id);
        $laboratorio->delete();
        return response()->json(null, 204);
    }
}
