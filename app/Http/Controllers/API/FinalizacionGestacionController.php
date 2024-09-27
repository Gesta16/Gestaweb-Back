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
        $request->validate([
            'cod_terminacion' => 'required|exists:terminacion_gestacion,cod_terminacion',
            'fec_evento' => 'required|date',
        ]);

        $finalizacion = FinalizacionGestacion::create($request->all());
        return response()->json($finalizacion, 201);
    }

    
    public function destroy($id)
    {
        $finalizacion = FinalizacionGestacion::findOrFail($id);
        $finalizacion->delete();

        return response()->json(null, 204); 
    }
}
