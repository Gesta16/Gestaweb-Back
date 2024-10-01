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
        $request->validate([
            'tsh' => 'required|string',
            'fec_resultado' => 'required|date',
            't4_libre' => 'required|string',
            'fec_resultadot4' => 'required|date',
            'eve_confirmado' => 'required|string',
            'fec_primera' => 'required|date',
        ]);

        $estudio = EstudioHipotiroidismoCongenito::create($request->all());
        return response()->json(['estado' => 'Ok', 'data' => $estudio], 201);
    }

    
    public function destroy($id)
    {
        $estudio = EstudioHipotiroidismoCongenito::findOrFail($id);
        $estudio->delete();
        return response()->json(['estado' => 'Ok', 'message' => 'Estudio eliminado correctamente']);
    }
}
