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
        $micronutriente = Micronutriente::find($id);

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
    
    public function destroy($id)
    {
        $micronutriente = Micronutriente::findOrFail($id);
        $micronutriente->delete();
        return response()->json(null, 204);
    }
}
