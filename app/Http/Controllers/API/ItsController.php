<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Its;

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

    public function show($id)
    {
        $it = Its::with(['operador', 'usuario', 'vdrl', 'rpr'])->find($id);
        if (!$it) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Registro no encontrado'
            ], 404);
        }
        return response()->json([
            'estado' => 'Ok',
            'mensaje' => 'Registro encontrado',
            'data' => $it
        ]);
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
            'cod_vdrl' => 'required|integer|exists:prueba_no_treponemica__v_d_r_l,cod_vdrl',
            'cod_rpr' => 'required|integer|exists:prueba_no_treponemica__r_p_r,cod_rpr',
            'eli_vih' => 'required|string',
            'fec_vih' => 'required|date',
            'fec_vdrl' => 'required|date',
            'fec_rpr' => 'required|date',
            'rec_tratamiento' => 'required|string',
            'rec_pareja' => 'required|string',
        ]);
    
        $validatedData['id_operador'] = auth()->user()->userable_id;
    
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
            'id_operador' => 'sometimes|exists:operador,id_operador',
            'id_usuario' => 'sometimes|exists:usuario,id_usuario',
            'cod_vdrl' => 'sometimes|exists:prueba_no_treponemica__v_d_r_l,cod_vdrl',
            'cod_rpr' => 'sometimes|exists:prueba_no_treponemica__r_p_r,cod_rpr',
            'eli_vih' => 'sometimes|string',
            'fec_vih' => 'sometimes|date',
            'fec_vdrl' => 'sometimes|date',
            'fec_rpr' => 'sometimes|date',
            'rec_tratamiento' => 'sometimes|string',
            'rec_pareja' => 'sometimes|string',
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
