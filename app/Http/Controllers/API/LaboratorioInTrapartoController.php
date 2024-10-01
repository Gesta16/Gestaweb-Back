<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LaboratorioInTraparto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LaboratorioInTrapartoController extends Controller
{
    // Listar todos los registros
    public function index()
    {
        $laboratorios = LaboratorioInTraparto::all();
        return response()->json(['estado' => 'Ok', 'data' => $laboratorios]);
    }

    // Crear un nuevo registro
    public function store(Request $request)
    {

        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401); // 401 Unauthorized
        }

        $validatedData = $request->validate([
            'cod_vdrl' => 'required|integer',
            'pru_sifilis' => 'required|string',
            'fec_sifilis' => 'required|date',
            'fec_vdrl' => 'required|date',
            'rec_sifilis' => 'required|string',
            'fec_tratamiento' => 'required|date',
            'pru_vih' => 'required|string',
            'fec_vih' => 'required|date',
        ]);

        $validatedData['id_operador'] = auth()->user()->userable_id;

        $laboratorio = LaboratorioInTraparto::create($validatedData->all());
        return response()->json(['estado' => 'Ok', 'data' => $laboratorio], 201);
    }

    // Eliminar un registro
    public function destroy($id)
    {
        $laboratorio = LaboratorioInTraparto::find($id);

        if (!$laboratorio) {
            return response()->json(['estado' => 'Error', 'message' => 'Registro no encontrado'], 404);
        }

        $laboratorio->delete();
        return response()->json(['estado' => 'Ok', 'message' => 'Registro eliminado correctamente']);
    }
}
