<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SeguimientoGestantePostObstetrico;
use Illuminate\Http\Request;
use App\Models\ProcesoGestativo;


class SeguimientoGestantePostObstetricoController extends Controller
{
    
    public function index()
    {
        $seguimientos = SeguimientoGestantePostObstetrico::all();
        return response()->json($seguimientos);
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
            'cod_metodo' => 'required|exists:metodos_anticonceptivos,cod_metodo',
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'con_egreso' => 'required|string',
            'fec_fallecimiento' => 'nullable|date',
            'fec_planificacion' => 'nullable|date',
            'num_proceso' => 'required|integer', // Asegúrate de incluir num_proceso
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
        $validatedData['proceso_gest_id'] = $procesoGestativo->id;
    
        // Crear el registro de SeguimientoGestantePostObstetrico
        $seguimiento = SeguimientoGestantePostObstetrico::create($validatedData);
    
        return response()->json(['estado' => 'Ok', 'data' => $seguimiento], 201); // 201 Created
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
    
        // Obtener el seguimiento para el usuario y proceso
        $seguimiento = SeguimientoGestantePostObstetrico::where('id_usuario', $id)
                                                        ->where('proceso_gest_id', $procesoGestativo->id)
                                                        ->first();
    
        if ($seguimiento) {
            return response()->json([
                'estado' => 'Ok',
                'seguimiento' => $seguimiento
            ], 200);
        } else {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Seguimiento no encontrado'
            ], 404);
        }
    }
    
    
    public function destroy($id)
    {
        $seguimiento = SeguimientoGestantePostObstetrico::findOrFail($id);
        $seguimiento->delete();

        return response()->json(null, 204); 
    }
}
