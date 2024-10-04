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
    
    public function destroy($id)
    {
        $finalizacion = FinalizacionGestacion::findOrFail($id);
        $finalizacion->delete();

        return response()->json(null, 204); 
    }
}
