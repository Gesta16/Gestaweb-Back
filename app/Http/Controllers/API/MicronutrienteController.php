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
        $micronutriente = Micronutriente::create($request->all());
        return response()->json($micronutriente, 201);
    }

    
    public function destroy($id)
    {
        $micronutriente = Micronutriente::findOrFail($id);
        $micronutriente->delete();
        return response()->json(null, 204);
    }
}
