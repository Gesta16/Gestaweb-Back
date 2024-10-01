<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DatosRecienNacido;
use Illuminate\Http\Request;

class DatosRecienNacidoController extends Controller
{
   
    public function index()
    {
        $datosRecienNacido = DatosRecienNacido::all();
        return response()->json(['estado' => 'Ok', 'data' => $datosRecienNacido]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'tip_embarazo' => 'required|string',
            'num_nacido' => 'required|integer',
            'sexo' => 'required|string',
            'peso' => 'required|integer',
            'talla' => 'required|integer',
            'pla_canguro' => 'required|string',
            'ips_canguro' => 'nullable|string',
        ]);

        $datosRecienNacido = DatosRecienNacido::create($request->all());
        return response()->json(['estado' => 'Ok', 'data' => $datosRecienNacido], 201);
    }


    public function destroy($id)
    {
        $datosRecienNacido = DatosRecienNacido::find($id);
        
        if (!$datosRecienNacido) {
            return response()->json(['estado' => 'Error', 'mensaje' => 'Registro no encontrado'], 404);
        }

        $datosRecienNacido->delete();
        return response()->json(['estado' => 'Ok', 'mensaje' => 'Registro eliminado correctamente']);
    }
}
