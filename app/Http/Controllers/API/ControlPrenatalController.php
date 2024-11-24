<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ControlPrenatal;
use App\Models\ConsultasUsuario;
use App\Models\ProcesoGestativo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;

class ControlPrenatalController extends Controller
{
    public function index()
    {
        $controles = ControlPrenatal::all();
        return response()->json([
            'estado' => 'Ok',
            'controles' => $controles
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            if (!auth()->check()) {
                return response()->json([
                    'estado' => 'Error',
                    'mensaje' => 'Debes estar autenticado para realizar esta acción'
                ], 401);
            }

            \Log::info('Datos de entrada:', $request->all());

            $validatedData = $request->validate([
                'id_usuario' => 'required|integer|exists:usuario,id_usuario',
                'cod_fracaso' => 'nullable|exists:metodo_fracaso,cod_fracaso',
                'edad_gestacional' => 'required|numeric',
                'trim_ingreso' => 'required|string|max:255',
                'fec_mestruacion' => 'required|date',
                'fec_parto' => 'required|date',
                'emb_planeado' => 'required|boolean',
                'fec_anticonceptivo' => 'required|boolean',
                'fec_consulta' => 'nullable|date',
                'fec_control' => 'nullable|date',
                'ries_reproductivo' => 'required|string|max:255',
                'fac_asesoria' => 'required|date',
                'usu_solicito' => 'required|boolean',
                'fec_terminacion' => 'nullable|date',
                'per_intergenesico' => 'required|boolean',
                'num_proceso' => 'required|integer|',
                'recibio_atencion_preconcep' => 'required|boolean',
                'asis_consul_control_precon' => 'required|boolean',
                'asis_asesoria_ive' => 'nullable|boolean',
                'tuvo_embarazos_antes' => 'required|boolean'

            ]);

            $validatedData['id_operador'] = auth()->user()->userable_id;
            $validatedData['fec_consulta'] = isset($validatedData['fec_consulta']) ? Carbon::parse($validatedData['fec_consulta'])->format('Y-m-d') : null;
            $validatedData['fec_control'] = isset($validatedData['fec_control']) ? Carbon::parse($validatedData['fec_control'])->format('Y-m-d') : null;
            $validatedData['fac_asesoria'] = isset($validatedData['fac_asesoria']) ? Carbon::parse($validatedData['fac_asesoria'])->format('Y-m-d') : null;
            $validatedData['fec_terminacion'] = isset($validatedData['fec_terminacion']) ? Carbon::parse($validatedData['fec_terminacion'])->format('Y-m-d') : null;

            $procesoGestativo = ProcesoGestativo::where('id_usuario', $validatedData['id_usuario'])
                ->where('num_proceso', $validatedData['num_proceso'])
                ->where('estado', 1)
                ->first();

            if (!$procesoGestativo) {
                return response()->json([
                    'estado' => 'Error',
                    'mensaje' => 'No se encontró el proceso gestativo para el usuario proporcionado.'
                ], 404);
            }

            $validatedData['proceso_gestativo_id'] = $procesoGestativo->id;

            $control = ControlPrenatal::create($validatedData);

            ConsultasUsuario::create([
                'id_usuario' => $validatedData['id_usuario'],
                'fecha' => now(),
                'nombre_consulta' => 'Control Prenatal',
            ]);


            return response()->json([
                'estado' => 'Ok',
                'mensaje' => 'Control prenatal creado correctamente',
                'data' => $control
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Error al crear control prenatal:', [
                'mensaje' => $e->getMessage(),
                'input' => $request->all(), // Captura los datos que causaron el error
            ]);

            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Error al crear el control prenatal',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function show($id_usuario, $num_proceso)
    {
        try {

            $procesoGestativo = ProcesoGestativo::where('id_usuario', $id_usuario)
                ->where('num_proceso', $num_proceso)
                ->first();

            if (!$procesoGestativo) {
                return response()->json([
                    'estado' => 'Error',
                    'mensaje' => 'No se encontró el proceso gestativo para el usuario proporcionado.'
                ], 404);
            }

            $control = ControlPrenatal::where('id_usuario', $id_usuario)
                ->where('proceso_gestativo_id', $procesoGestativo->id)
                ->firstOrFail();

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

            if (!auth()->check()) {
                return response()->json([
                    'estado' => 'Error',
                    'mensaje' => 'Debes estar autenticado para realizar esta acción'
                ], 401); // 401 Unauthorized
            }

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

            if (!isset($validatedData['id_usuario'])) {
                return response()->json([
                    'estado' => 'Error',
                    'mensaje' => 'El campo id_usuario es requerido'
                ], 400); // Bad request
            }

            $control = ControlPrenatal::where('cod_control', $cod_control)
                ->where('id_usuario', $validatedData['id_usuario'])
                ->firstOrFail();

            // Actualizar el registro
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
