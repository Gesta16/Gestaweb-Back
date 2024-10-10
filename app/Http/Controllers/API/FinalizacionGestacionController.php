<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FinalizacionGestacion;
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
            ], 401); // 401 Unauthorized
        }

        $validatedData = $request->validate([
            'cod_terminacion' => 'required|exists:terminacion_gestacion,cod_terminacion',
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'cod_terminacion' => 'required|integer',
            'fec_evento' => 'required|date',
        ]);

        $validatedData['id_operador'] = auth()->user()->userable_id;

        $finalizacion = FinalizacionGestacion::create($validatedData);
        return response()->json($finalizacion, 201);
    }

    public function show($id)
    {
        $finalizacion = FinalizacionGestacion::where('id_usuario', $id)->firstOrFail();

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
                'cod_terminacion' => 'required|integer',
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
