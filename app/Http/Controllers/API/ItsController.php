<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Its;
use App\Models\ProcesoGestativo;


class ItsController extends Controller
{
    public function index()
    {
        $its = Its::with(['operador', 'usuario', 'vdrl', 'rpr'])->get();
        return response()->json([
            'estado' => 'Ok',
            'mensaje' => 'Registros obtenidos exitosamente',
            'data' => $its
        ]);
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
    
        // Obtener el registro de ITS con relaciones
        $it = Its::with(['operador', 'usuario', 'vdrl', 'rpr'])
                  ->where('id_usuario', $id)
                  ->where('proceso_gestativo_id', $procesoGestativo->id)
                  ->firstOrFail();
    
        return response()->json([
            'estado' => 'Ok',
            'mensaje' => 'Registro encontrado',
            'data' => $it
        ]);
    }
    
    public function store(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401); 
        }
    
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'cod_vdrl' => 'required|integer|exists:prueba_no_treponemica__v_d_r_l,cod_vdrl',
            'cod_rpr' => 'nullable|integer|exists:prueba_no_treponemica__r_p_r,cod_rpr',
            'eli_vih' => 'nullable|string',
            'fec_vih' => 'nullable|date',
            'fec_vdrl' => 'nullable|date',
            'fec_rpr' => 'nullable|date',
            'rec_tratamiento' => 'nullable|string',
            'rec_pareja' => 'nullable|string',
            'num_proceso' => 'required|integer', // Asegúrate de incluir num_proceso
            'reali_prueb_elisa_vih' => 'required|boolean',
            'reali_prueb_no_trepo_vdrl_sifilis' => 'required|boolean',
            'reali_prueb_no_trepo_rpr_sifilis' => 'required|boolean',
        ]);
    
        $procesoGestativo = ProcesoGestativo::where('id_usuario', $validatedData['id_usuario'])
                                            ->where('num_proceso', $validatedData['num_proceso'])
                                            ->where('estado', 1) // O el estado que definas para "activo"
                                            ->first();
    
        if (!$procesoGestativo) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'No se encontró el proceso gestativo activo para el usuario proporcionado.'
            ], 404);
        }
    
        // Asignar el id_operador y el id del proceso gestativo
        $validatedData['id_operador'] = auth()->user()->userable_id;
        $validatedData['proceso_gestativo_id'] = $procesoGestativo->id;
    
        // Crear el registro de ITS
        $its = Its::create($validatedData);
    
        return response()->json([
            'estado' => 'Ok',
            'mensaje' => 'Registro de ITS creado exitosamente',
            'data' => $its
        ], 201);
    }
    

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'id_usuario' => 'sometimes|exists:usuario,id_usuario',
            'cod_vdrl' => 'sometimes|exists:prueba_no_treponemica__v_d_r_l,cod_vdrl',
            'cod_rpr' => 'sometimes|nullable|exists:prueba_no_treponemica__r_p_r,cod_rpr',
            'eli_vih' => 'sometimes|nullable|string',
            'fec_vih' => 'sometimes|nullable|date',
            'fec_vdrl' => 'sometimes|nullable|date',
            'fec_rpr' => 'sometimes|nullable|date',
            'rec_tratamiento' => 'sometimes|nullable|string',
            'rec_pareja' => 'sometimes|nullable|string',
            'reali_prueb_elisa_vih' => 'sometimes|required|boolean',
            'reali_prueb_no_trepo_vdrl_sifilis' => 'sometimes|required|boolean',
            'reali_prueb_no_trepo_rpr_sifilis' => 'sometimes|required|boolean',
        ]);
    
        $it = Its::find($id);
        if (!$it) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Registro no encontrado'
            ], 404);
        }
    
        if (!isset($data['id_operador'])) {
            $data['id_operador'] = auth()->user()->userable_id;
        }
    
        $it = Its::where('cod_its', $id)
                  ->where('id_usuario', $data['id_usuario'])
                  ->firstOrFail();
        
        $it->update($data);


        return response()->json([
            'estado' => 'Ok',
            'mensaje' => 'Registro de ITS actualizado exitosamente',
            'data' => $it
        ]);
    }
    

    public function destroy($id)
    {
        // Eliminar un registro de ITS
        $it = Its::find($id);
        if (!$it) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Registro no encontrado'
            ], 404);
        }
        $it->delete();
        return response()->json([
            'estado' => 'Ok',
            'mensaje' => 'Registro eliminado exitosamente'
        ]);
    }
}
