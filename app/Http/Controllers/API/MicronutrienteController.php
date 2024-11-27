<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Micronutriente;
use App\Models\ProcesoGestativo;
use Illuminate\Http\Request;

class MicronutrienteController extends Controller
{
    
    public function index()
    {
        $micronutrientes = Micronutriente::all();
        return response()->json($micronutrientes);
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
            'num_proceso' => 'required|integer', // Agregamos la validación para num_proceso
            'aci_folico' => 'required|string',
            'sul_ferroso' => 'required|string',
            'car_calcio' => 'required|string',
            'desparasitacion' => 'required|string',

        ]);
    
        // Verificar que el ProcesoGestativo esté activo
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
    
        $validatedData['id_operador'] = auth()->user()->userable_id;
        $validatedData['proceso_gestativo_id'] = $procesoGestativo->id;

    
        $micronutriente = Micronutriente::create($validatedData);
        return response()->json([
            'estado' => 'Ok',
            'mensaje' => 'Micronutriente creado exitosamente',
            'data' => $micronutriente
        ], 201);
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
    
        // Obtener el micronutriente correspondiente
        $micronutriente = Micronutriente::where('id_usuario', $id)
                                        ->where('proceso_gestativo_id', $procesoGestativo->id)
                                        ->firstOrFail();
    
        return response()->json([
            'estado' => 'Ok',
            'micronutriente' => $micronutriente
        ], 200);
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
                'id_usuario' => 'required|integer|exists:usuario,id_usuario',
                'aci_folico' => 'sometimes|required|string',
                'sul_ferroso' => 'sometimes|required|string',
                'car_calcio' => 'sometimes|required|string',
                'desparasitacion' => 'sometimes|required|string',
            ]);

            // Validación del campo id_usuario
            if (!isset($validatedData['id_usuario'])) {
                return response()->json([
                    'estado' => 'Error',
                    'mensaje' => 'El campo id_usuario es requerido'
                ], 400); // Bad request
            }

            // Buscar el micronutriente
            $micronutriente = Micronutriente::where('cod_micronutriente', $id)
                ->where('id_usuario', $validatedData['id_usuario'])
                ->firstOrFail();

            // Actualizar el registro
            $micronutriente->update($validatedData);

            return response()->json([
                'estado' => 'Ok',
                'mensaje' => 'Micronutriente actualizado correctamente',
                'data' => $micronutriente
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Micronutriente no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Error al actualizar el micronutriente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    public function destroy($id)
    {
        $micronutriente = Micronutriente::findOrFail($id);
        $micronutriente->delete();
        return response()->json(null, 204);
    }
}
