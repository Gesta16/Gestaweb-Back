<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RutaPYMS;
use Illuminate\Http\Request;
use App\Models\ProcesoGestativo;
use Illuminate\Support\Facades\Validator;

class RutaPYMSController extends Controller
{
    
    public function index()
    {
        $rutas = RutaPYMS::all();
        return response()->json($rutas);
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
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'fec_bcg' => 'required|date',
            'fec_hepatitis' => 'required|date',
            'fec_seguimiento' => 'required|date',
            'fec_entrega' => 'required|date',
            'num_proceso' => 'required|integer', // Agregar validación para num_proceso
            'aplico_vacuna_bcg' => 'required|boolean',
            'aplico_vacuna_hepatitis' => 'required|boolean',
            'reali_entrega_carnet' => 'required|boolean',
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
    
        // Crear el registro de RutaPYMS
        $ruta = RutaPYMS::create($validatedData);
        
        return response()->json(['estado' => 'Ok', 'data' => $ruta], 201); // 201 Created
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
    
        // Obtener los datos de RutaPYMS para el usuario y proceso
        $ruta = RutaPYMS::where('id_usuario', $id)
                         ->where('proceso_gestativo_id', $procesoGestativo->id)
                         ->first();
    
        if ($ruta) {
            return response()->json([
                'estado' => 'Ok',
                'data' => $ruta
            ], 200);
        } else {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Ruta no encontrada'
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
                'id_usuario' => 'required|integer|exists:usuario,id_usuario',
                'fec_bcg' => 'required|date',
                'fec_hepatitis' => 'required|date',
                'fec_seguimiento' => 'required|date',
                'fec_entrega' => 'required|date',
            ]);

            if (!isset($validatedData['id_usuario'])) {
                return response()->json([
                    'estado' => 'Error',
                    'mensaje' => 'El campo id_usuario es requerido'
                ], 400); // Bad request
            }

            $ruta = RutaPYMS::where('cod_ruta', $id)
                ->where('id_usuario', $validatedData['id_usuario'])
                ->firstOrFail();

            $ruta->update($validatedData);

            return response()->json([
                'estado' => 'Ok',
                'mensaje' => 'Ruta actualizada correctamente',
                'data' => $ruta
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Ruta no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Error al actualizar la ruta',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    
    public function destroy($id)
    {
        $ruta = RutaPYMS::find($id);
        if (!$ruta) {
            return response()->json(['message' => 'Ruta no encontrada'], 404);
        }

        $ruta->delete();
        return response()->json(['message' => 'Ruta eliminada con éxito'], 200);
    }
}
