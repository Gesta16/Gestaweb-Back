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
        $validator = Validator::make($request->all(), [
            'fec_bcg' => 'required|date',
            'fec_hepatitis' => 'required|date',
            'fec_seguimiento' => 'required|date',
            'fec_entrega' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $ruta = RutaPYMS::create($request->all());
        return response()->json($ruta, 201);
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
