<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ControlPrenatal;

class ControlPrenatalController extends Controller
{
    public function index()
    {
        $controles = ControlPrenatal::all();
        return [
            'estado'=>'Ok',
            'Controles'=>$controles
        ];
    }

    // Crear un nuevo control prenatal
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'cod_control' => 'required|integer|unique:control_prenatal,cod_control',
            'id_operador' => 'required|integer|exists:operador,id_operador',
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'cod_fracaso' => 'required|integer|exists:metodo_fracaso,cod_fracaso',
            'edad_gestacional' => 'required|numeric',
            'trim_ingreso' => 'required|string|max:255',
            'fec_mestruacion' => 'required|date',
            'fec_parto' => 'required|date',
            'emb_planeado' => 'required|boolean',
            'fec_anticonceptivo' => 'required|boolean',
            'fec_consulta' => 'required|date',
            'fec_control' => 'required|date',
            'ries_reproductivo' => 'required|string|max:255',
            'fac_asesoria' => 'required|date',
            'usu_solicito' => 'required|boolean',
            'fec_terminacion' => 'required|date',
            'per_intergenesico' => 'required|boolean',
        ]);

        // Crear el registro
        $control = ControlPrenatal::create($validatedData);

        return response()->json(['message' => 'Control prenatal creado correctamente', 'data' => $control], 201);
    }

    // Mostrar un control prenatal específico
    public function show($cod_control)
    {
        $control = ControlPrenatal::findOrFail($cod_control);
        return response()->json($control);
    }

    // Actualizar un control prenatal existente
    public function update(Request $request, $cod_control)
    {
        $validatedData = $request->validate([
            'id_operador' => 'integer|exists:operador,id_operador',
            'id_usuario' => 'integer|exists:usuario,id_usuario',
            'cod_fracaso' => 'integer|exists:metodo_fracaso,cod_fracaso',
            'edad_gestacional' => 'numeric',
            'trim_ingreso' => 'string|max:255',
            'fec_mestruacion' => 'date',
            'fec_parto' => 'date',
            'emb_planeado' => 'boolean',
            'fec_anticonceptivo' => 'boolean',
            'fec_consulta' => 'date',
            'fec_control' => 'date',
            'ries_reproductivo' => 'string|max:255',
            'fac_asesoria' => 'date',
            'usu_solicito' => 'boolean',
            'fec_terminacion' => 'date',
            'per_intergenesico' => 'boolean',
        ]);

        $control = ControlPrenatal::findOrFail($cod_control);
        $control->update($validatedData);

        return response()->json(['message' => 'Control prenatal actualizado correctamente', 'data' => $control]);
    }

    public function destroy($cod_control)
    {
        $control = ControlPrenatal::findOrFail($cod_control);
        $control->delete();

        return response()->json(['message' => 'Control prenatal eliminado correctamente']);
    }
}
