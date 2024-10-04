<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EstudioHipotiroidismoCongenito;
use Illuminate\Http\Request;

class EstudioHipotiroidismoCongenitoController extends Controller
{
    
    public function index()
    {
        $estudios = EstudioHipotiroidismoCongenito::all();
        return response()->json(['estado' => 'Ok', 'data' => $estudios]);
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
            'tsh' => 'required|string',
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'fec_resultado' => 'required|date',
            't4_libre' => 'required|string',
            'fec_resultadot4' => 'required|date',
            'eve_confirmado' => 'required|string',
            'fec_primera' => 'required|date',
        ]);

        $validatedData['id_operador'] = auth()->user()->userable_id;

        $estudio = EstudioHipotiroidismoCongenito::create($validatedData);
        return response()->json(['estado' => 'Ok', 'data' => $estudio], 201);
    }

    public function show($id)
    {
        $estudio = EstudioHipotiroidismoCongenito::where('id_usuario', $id)->firstOrFail();
    
        if ($estudio) {
            return response()->json([
                'estado' => 'Ok',
                'data' => $estudio
            ], 200);
        } else {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Estudio de hipotiroidismo congénito no encontrado'
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
                'tsh' => 'required|string',
                'id_usuario' => 'required|integer|exists:usuario,id_usuario',
                'fec_resultado' => 'required|date',
                't4_libre' => 'required|string',
                'fec_resultadot4' => 'required|date',
                'eve_confirmado' => 'required|string',
                'fec_primera' => 'required|date',
            ]);

            if (!isset($validatedData['id_usuario'])) {
                return response()->json([
                    'estado' => 'Error',
                    'mensaje' => 'El campo id_usuario es requerido'
                ], 400); 
            }

            $estudio = EstudioHipotiroidismoCongenito::where('cod_estudio', $id)
                ->where('id_usuario', $validatedData['id_usuario'])
                ->firstOrFail();

            $estudio->update($validatedData);

            return response()->json([
                'estado' => 'Ok',
                'mensaje' => 'Estudio actualizado correctamente',
                'data' => $estudio
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Estudio de hipotiroidismo congénito no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Error al actualizar el estudio',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    public function destroy($id)
    {
        $estudio = EstudioHipotiroidismoCongenito::findOrFail($id);
        $estudio->delete();
        return response()->json(['estado' => 'Ok', 'message' => 'Estudio eliminado correctamente']);
    }
}
