<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Micronutriente;
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
            'aci_folico' => 'required|string',
            'sul_ferroso' => 'required|string',
            'car_calcio' => 'required|string',
            'desparasitacion' => 'required|string',
        ]);

        $validatedData['id_operador'] = auth()->user()->userable_id;

        $micronutriente = Micronutriente::create($validatedData);
        return response()->json($micronutriente, 201);
    }

    public function show($id)
    {
        $micronutriente = Micronutriente::where('id_usuario', $id)->firstOrFail();

        if ($micronutriente) {
            return response()->json([
                'estado' => 'Ok',
                'micronutriente' => $micronutriente
            ], 200);
        } else {
            return response()->json([
                'error' => 'Micronutriente no encontrado'
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
                'id_usuario' => 'required|integer|exists:usuario,id_usuario',
                'aci_folico' => 'required|string',
                'sul_ferroso' => 'required|string',
                'car_calcio' => 'required|string',
                'desparasitacion' => 'required|string',
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
