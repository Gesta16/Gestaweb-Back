<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FinalizacionGestacion;
use App\Models\ConsultasUsuario;
use App\Models\ProcesoGestativo;
use Illuminate\Http\Request;

class FinalizacionGestacionController extends Controller
{
    
    public function index()
    {
        $finalizaciones = FinalizacionGestacion::all();
        return response()->json($finalizaciones);
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
            'cod_terminacion' => 'required|exists:terminacion_gestacion,cod_terminacion',
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'fec_evento' => 'required|date',
            'num_proceso' => 'required|integer',
        ]);
    
        $validatedData['id_operador'] = auth()->user()->userable_id;
    
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
    
        $finalizacion = FinalizacionGestacion::create($validatedData);
    
        $procesoGestativo->update(['estado' => false]);
    
        ConsultasUsuario::create([
            'id_usuario' => $validatedData['id_usuario'],
            'fecha' => now(),
            'nombre_consulta' => 'Finalización de Gestación',
        ]);
    
        return response()->json([
            'estado' => 'Éxito',
            'mensaje' => 'Finalización de gestación registrada y proceso actualizado.',
            'data' => $finalizacion
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
    
        // Obtener la finalización de gestación para el usuario y proceso
        $finalizacion = FinalizacionGestacion::where('id_usuario', $id)
                                              ->where('proceso_gestativo_id', $procesoGestativo->id)
                                              ->first();
    
        if ($finalizacion) {
            return response()->json([
                'estado' => 'Ok',
                'finalizacion' => $finalizacion
            ], 200);
        } else {
            return response()->json([
                'error' => 'Finalización de gestación no encontrada'
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
                'cod_terminacion' => 'required|exists:terminacion_gestacion,cod_terminacion',
                'id_usuario' => 'required|integer|exists:usuario,id_usuario',
                'fec_evento' => 'required|date',
            ]);

            // Validación del campo id_usuario
            if (!isset($validatedData['id_usuario'])) {
                return response()->json([
                    'estado' => 'Error',
                    'mensaje' => 'El campo id_usuario es requerido'
                ], 400); // Bad request
            }

            // Buscar la finalización de gestación
            $finalizacion = FinalizacionGestacion::where('cod_finalizacion', $id)
                ->where('id_usuario', $validatedData['id_usuario'])
                ->firstOrFail();

            // Actualizar el registro
            $finalizacion->update($validatedData);

            return response()->json([
                'estado' => 'Ok',
                'mensaje' => 'Finalización de gestación actualizada correctamente',
                'data' => $finalizacion
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Finalización de gestación no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Error al actualizar la finalización de gestación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    public function destroy($id)
    {
        $finalizacion = FinalizacionGestacion::findOrFail($id);
        $finalizacion->delete();

        return response()->json(null, 204); 
    }
}
