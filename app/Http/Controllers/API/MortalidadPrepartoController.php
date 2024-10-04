<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MortalidadPreparto;
use Illuminate\Http\Request;

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
        ]);

        $validatedData['id_operador'] = auth()->user()->userable_id;

        $mortalidadPreparto = MortalidadPreparto::create($validatedData);
        return response()->json($mortalidadPreparto, 201);
    }

    public function show($id)
    {
        $mortalidadPreparto = MortalidadPreparto::where('id_usuario', $id)->firstOrFail();
    
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
                'cod_mortalidad' => 'required|exists:mortalidad_perinatal,cod_mortalidad',
                'id_usuario' => 'required|integer|exists:usuario,id_usuario',
                'fec_defuncion' => 'required|date',
            ]);

            if (!isset($validatedData['id_usuario'])) {
                return response()->json([
                    'estado' => 'Error',
                    'mensaje' => 'El campo id_usuario es requerido'
                ], 400); 
            }

            $mortalidadPreparto = MortalidadPreparto::where('cod_mortalpreparto', $id)
                ->where('id_usuario', $validatedData['id_usuario'])
                ->firstOrFail();

            $mortalidadPreparto->update($validatedData);

            return response()->json([
                'estado' => 'Ok',
                'mensaje' => 'Registro actualizado correctamente',
                'data' => $mortalidadPreparto
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Registro de mortalidad no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Error al actualizar el registro',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        $mortalidadPreparto = MortalidadPreparto::findOrFail($id);
        $mortalidadPreparto->delete();
        return response()->json(null, 204);
    }
}
