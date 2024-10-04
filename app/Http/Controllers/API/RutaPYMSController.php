<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RutaPYMS;
use Illuminate\Http\Request;
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
        ]);

        $validatedData['id_operador'] = auth()->user()->userable_id;

        $ruta = RutaPYMS::create($validatedData);
        return response()->json($ruta, 201);
    }

    public function show($id)
    {
        $ruta = RutaPYMS::where('id_usuario', $id)->firstOrFail();
    
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
