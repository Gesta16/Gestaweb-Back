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
        $request->validate([
            'cod_mortalidad' => 'required|exists:mortalidad_perinatal,cod_mortalidad',
            'fec_defuncion' => 'required|date',
        ]);

        $mortalidadPreparto = MortalidadPreparto::create($request->all());
        return response()->json($mortalidadPreparto, 201);
    }

   
    public function destroy($id)
    {
        $mortalidadPreparto = MortalidadPreparto::findOrFail($id);
        $mortalidadPreparto->delete();
        return response()->json(null, 204);
    }
}
