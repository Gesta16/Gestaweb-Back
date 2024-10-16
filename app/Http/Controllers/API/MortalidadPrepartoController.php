<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MortalidadPreparto;
use Illuminate\Http\Request;
use App\Models\ProcesoGestativo;


class MortalidadPrepartoController extends Controller
{
    
    public function index()
    {
        $mortalidadPreparto = MortalidadPreparto::all();
        return response()->json($mortalidadPreparto);
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
            'cod_mortalidad' => 'required|exists:mortalidad_perinatal,cod_mortalidad',
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'fec_defuncion' => 'required|date',
            'num_proceso' => 'required|integer', // Agregar num_proceso a la validación
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
    
        // Crear el registro de MortalidadPreparto
        $mortalidadPreparto = MortalidadPreparto::create($validatedData);
    
        return response()->json(['estado' => 'Ok', 'data' => $mortalidadPreparto], 201); // 201 Created
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
    
        // Obtener la mortalidad para el usuario y proceso
        $mortalidadPreparto = MortalidadPreparto::where('id_usuario', $id)
                                                 ->where('proceso_gestativo_id', $procesoGestativo->id)
                                                 ->first();
    
        if ($mortalidadPreparto) {
            return response()->json([
                'estado' => 'Ok',
                'mortalidad' => $mortalidadPreparto
            ], 200);
        } else {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Registro de mortalidad no encontrado'
            ], 404);
        }
    }
    

    public function destroy($id)
    {
        $mortalidadPreparto = MortalidadPreparto::findOrFail($id);
        $mortalidadPreparto->delete();
        return response()->json(null, 204);
    }
}
