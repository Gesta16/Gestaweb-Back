<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LaboratorioInTraparto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProcesoGestativo;


class LaboratorioInTrapartoController extends Controller
{
    // Listar todos los registros
    public function index()
    {
        $laboratorios = LaboratorioInTraparto::all();
        return response()->json(['estado' => 'Ok', 'data' => $laboratorios]);
    }

    // Crear un nuevo registro
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401); // 401 Unauthorized
        }
    
        $validatedData = $request->validate([
            'cod_vdrl' => 'required|integer',
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'pru_sifilis' => 'required|string',
            'fec_sifilis' => 'required|date',
            'fec_vdrl' => 'required|date',
            'rec_sifilis' => 'required|string',
            'fec_tratamiento' => 'required|date',
            'pru_vih' => 'required|string',
            'fec_vih' => 'required|date',
            'num_proceso' => 'required|integer', // Asegúrate de incluir num_proceso
            'reali_prueb_trepo_rapi_sifilis_intra' => 'required|boolean',
            'reali_prueb_no_trepo_vdrl_sifilis_intra' => 'required|boolean',
            'reali_prueb_rapi_vih' => 'required|boolean'
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

        $validatedData['proceso_gestativo_id'] = $procesoGestativo->id;

    
        // Crear el registro de LaboratorioInTraparto
        $laboratorio = LaboratorioInTraparto::create($validatedData);
        
        return response()->json(['estado' => 'Ok', 'data' => $laboratorio], 201);
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
    
        // Obtener el laboratorio para el usuario y proceso
        $laboratorio = LaboratorioInTraparto::where('id_usuario', $id)
                                            ->where('proceso_gestativo_id', $procesoGestativo->id)
                                            ->first();
    
        if ($laboratorio) {
            return response()->json([
                'estado' => 'Ok',
                'data' => $laboratorio
            ], 200);
        } else {
            return response()->json([
                'estado' => 'Error',
                'message' => 'Registro no encontrado'
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
                ], 401); // 401 Unauthorized
            }

            $validatedData = $request->validate([
                'cod_vdrl' => 'required|integer',
                'id_usuario' => 'required|integer|exists:usuario,id_usuario',
                'pru_sifilis' => 'required|string',
                'fec_sifilis' => 'required|date',
                'fec_vdrl' => 'required|date',
                'rec_sifilis' => 'required|string',
                'fec_tratamiento' => 'required|date',
                'pru_vih' => 'required|string',
                'fec_vih' => 'required|date',
            ]);

            if (!isset($validatedData['id_usuario'])) {
                return response()->json([
                    'estado' => 'Error',
                    'mensaje' => 'El campo id_usuario es requerido'
                ], 400);
            }

            $laboratorio = LaboratorioInTraparto::where('cod_intraparto', $id)
                ->where('id_usuario', $validatedData['id_usuario'])
                ->firstOrFail();

            $laboratorio->update($validatedData);

            return response()->json([
                'estado' => 'Ok',
                'mensaje' => 'Registro actualizado correctamente',
                'data' => $laboratorio
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Registro no encontrado'
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
        $laboratorio = LaboratorioInTraparto::find($id);

        if (!$laboratorio) {
            return response()->json(['estado' => 'Error', 'message' => 'Registro no encontrado'], 404);
        }

        $laboratorio->delete();
        return response()->json(['estado' => 'Ok', 'message' => 'Registro eliminado correctamente']);
    }
}
