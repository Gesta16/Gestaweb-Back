<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TamizacionNeonatal;
use Illuminate\Http\Request;
use App\Models\ProcesoGestativo;


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
            'fec_pruetrepo' => 'nullable|date',
            'pruetreponemica' => 'nullable|string',
            'tamiza_aud' => 'nullable|string',
            'tamiza_cardi' => 'nullable|string',
            'tamiza_visual' => 'nullable|string',
            'num_proceso' => 'required|integer', // Agregar num_proceso a la validación
            'reali_prueb_trepo_recien_nacido' => 'required|boolean',
            'reali_tami_auditivo' => 'required|boolean',
            'reali_tami_cardiopatia_congenita' => 'required|boolean',
            'reali_tami_visual' => 'required|boolean',
        ]);

        $validatedData['id_operador'] = auth()->user()->userable_id;

        // Verificar que el ProcesoGestativo esté activo
        $procesoGestativo = ProcesoGestativo::where('id_usuario', $validatedData['id_usuario'])
            ->where('num_proceso', $validatedData['num_proceso'])
            ->first();

        if (!$procesoGestativo) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'No se encontró el proceso gestativo activo para el usuario proporcionado.'
            ], 404);
        }

        // Asignar el id del proceso gestativo a los datos validados
        $validatedData['proceso_gestativo_id'] = $procesoGestativo->id;

        // Crear el registro de TamizacionNeonatal
        $tamizacion = TamizacionNeonatal::create($validatedData);

        return response()->json(['estado' => 'Ok', 'message' => 'Proceso gestativo creado con exito', 'data' => $tamizacion], 201); // 201 Created
    }


    public function show($id, $num_proceso)
    {
        // Verificar que el ProcesoGestativo esté activo
        $procesoGestativo = ProcesoGestativo::where('id_usuario', $id)
            ->where('num_proceso', $num_proceso)
            ->first();

        if (!$procesoGestativo) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'No se encontró el proceso gestativo activo para el usuario proporcionado.'
            ], 404);
        }

        // Obtener los datos de TamizacionNeonatal para el usuario y proceso
        $tamizacion = TamizacionNeonatal::where('id_usuario', $id)
            ->where('proceso_gestativo_id', $procesoGestativo->id)
            ->first();

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

    public function update(Request $request, $id)
    {
        try {
            if (!auth()->check()) {
                return response()->json([
                    'estado' => 'Error',
                    'mensaje' => 'Debes estar autenticado para realizar esta acción'
                ], 401);
            }

            $validatedData = $request->validate([
                'cod_hemoclasifi' => 'required|exists:hemoclasificacion,cod_hemoclasifi',
                'id_usuario' => 'required|integer|exists:usuario,id_usuario',
                'fec_tsh' => 'required|date',
                'resul_tsh' => 'required|string',
                'fec_pruetrepo' => 'nullable|date',
                'pruetreponemica' => 'nullable|string',
                'tamiza_aud' => 'nullable|string',
                'tamiza_cardi' => 'nullable|string',
                'tamiza_visual' => 'nullable|string',
                'reali_prueb_trepo_recien_nacido' => 'sometimes|required|boolean',
                'reali_tami_auditivo' => 'sometimes|required|boolean',
                'reali_tami_cardiopatia_congenita' => 'sometimes|required|boolean',
                'reali_tami_visual' => 'sometimes|required|boolean',
            ]);

            if (!isset($validatedData['id_usuario'])) {
                return response()->json([
                    'estado' => 'Error',
                    'mensaje' => 'El campo id_usuario es requerido'
                ], 400);
            }

            $tamizacion = TamizacionNeonatal::where('cod_tamizacion', $id)
                ->where('id_usuario', $validatedData['id_usuario'])
                ->firstOrFail();

            $tamizacion->update($validatedData);

            return response()->json([
                'estado' => 'Ok',
                'message' => 'Registro actualizado correctamente',
                'data' => $tamizacion
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Registro de tamización neonatal no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Error al actualizar el registro',
                'error' => $e->getMessage()
            ], 500);
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
