<?php

namespace App\Http\Controllers;

use App\Models\ControlPrenatal;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ControlPrenatalController extends Controller
{
    public function index()
    {
        $controles = ControlPrenatal::all();
        return response()->json([
            'estado' => 'Ok',
            'Controles' => $controles
        ], 200); 
    }

    public function store(Request $request)
    {
        try {
            // $validatedData = $request->validate([
            //     'cod_control' => 'required|integer|unique:control_prenatal,cod_control',
            //     'id_operador' => 'required|integer|exists:operador,id_operador',
            //     'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            //     'cod_fracaso' => 'required|integer|exists:metodo_fracaso,cod_fracaso',
            //     'edad_gestacional' => 'required|numeric',
            //     'trim_ingreso' => 'required|string|max:255',
            //     'fec_mestruacion' => 'required|date',
            //     'fec_parto' => 'required|date',
            //     'emb_planeado' => 'required|boolean',
            //     'fec_anticonceptivo' => 'required|boolean',
            //     'fec_consulta' => 'required|date',
            //     'fec_control' => 'required|date',
            //     'ries_reproductivo' => 'required|string|max:255',
            //     'fac_asesoria' => 'required|date',
            //     'usu_solicito' => 'required|boolean',
            //     'fec_terminacion' => 'required|date',
            //     'per_intergenesico' => 'required|boolean',
            // ]);

            $control = ControlPrenatal::create($validatedData);

            return response()->json([
                'estado' => 'Ok',
                'mensaje' => 'Control prenatal creado correctamente',
                'data' => $control
            ], 201); 
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Error al crear el control prenatal',
                'error' => $e->getMessage()
            ], 500); 
        }
    }

    public function show($cod_control)
    {
        try {
            $control = ControlPrenatal::findOrFail($cod_control);
            return response()->json([
                'estado' => 'Ok',
                'Control' => $control
            ], 200); 
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Control prenatal no encontrado'
            ], 404); 
        }
    }

    public function update(Request $request, $cod_control)
    {
        try {
            // $validatedData = $request->validate([
            //     'id_operador' => 'integer|exists:operador,id_operador',
            //     'id_usuario' => 'integer|exists:usuario,id_usuario',
            //     'cod_fracaso' => 'integer|exists:metodo_fracaso,cod_fracaso',
            //     'edad_gestacional' => 'numeric',
            //     'trim_ingreso' => 'string|max:255',
            //     'fec_mestruacion' => 'date',
            //     'fec_parto' => 'date',
            //     'emb_planeado' => 'boolean',
            //     'fec_anticonceptivo' => 'boolean',
            //     'fec_consulta' => 'date',
            //     'fec_control' => 'date',
            //     'ries_reproductivo' => 'string|max:255',
            //     'fac_asesoria' => 'date',
            //     'usu_solicito' => 'boolean',
            //     'fec_terminacion' => 'date',
            //     'per_intergenesico' => 'boolean',
            // ]);

            $control = ControlPrenatal::findOrFail($cod_control);
            $control->update($validatedData);

            return response()->json([
                'estado' => 'Ok',
                'mensaje' => 'Control prenatal actualizado correctamente',
                'data' => $control
            ], 200); 
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Control prenatal no encontrado'
            ], 404); 
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Error al actualizar el control prenatal',
                'error' => $e->getMessage()
            ], 500); 
        }
    }

    public function destroy($cod_control)
    {
        try {
            $control = ControlPrenatal::findOrFail($cod_control);
            $control->delete();

            return response()->json([
                'estado' => 'Ok',
                'mensaje' => 'Control prenatal eliminado correctamente'
            ], 200); 
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Control prenatal no encontrado'
            ], 404); 
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Error al eliminar el control prenatal',
                'error' => $e->getMessage()
            ], 500); 
        }
    }
}
