<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrimeraConsulta;
use Illuminate\Support\Facades\Validator;

class PrimeraConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consultas = PrimeraConsulta::with(['operador', 'usuario', 'riesgo', 'tipoDm'])->get();

        return response()->json([
            'estado' => 'Ok',
            'consultas' => $consultas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_operador' => 'required|exists:operador,id_operador',
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'cod_riesgo' => 'required|exists:riesgo,cod_riesgo',
            'cod_dm' => 'required|exists:tipo_dm,cod_dm',
            'peso_previo' => 'required|integer|min:0',
            'tal_consulta' => 'required|numeric|min:0|max:999.99',
            'imc_consulta' => 'required|integer|min:0',
            'diag_nutricional' => 'required|string|max:255',
            'hta' => 'required|integer|in:0,1',
            'dm' => 'required|integer|in:0,1',
            'fact_riesgo' => 'required|string|max:255',
            'expo_violencia' => 'required|string|max:255',
            'ries_depresion' => 'required|string|max:255',
            'for_gestacion' => 'required|integer|min:0',
            'for_parto' => 'required|integer|min:0',
            'for_cesarea' => 'required|integer|min:0',
            'for_aborto' => 'required|integer|min:0',
            'fec_lactancia' => 'required|date',
            'fec_consejeria' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'estado' => 'Error',
                'errores' => $validator->errors()
            ], 422);
        }

        $consulta = PrimeraConsulta::create($request->all());

        return response()->json([
            'estado' => 'Ok',
            'consulta' => $consulta
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $consulta = PrimeraConsulta::with(['operador', 'usuario', 'riesgo', 'tipoDm'])->find($id);

        if (!$consulta) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Consulta no encontrada'
            ], 404);
        }

        return response()->json([
            'estado' => 'Ok',
            'consulta' => $consulta
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $consulta = PrimeraConsulta::find($id);

        if (!$consulta) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Consulta no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'id_operador' => 'sometimes|required|exists:operador,id_operador',
            'id_usuario' => 'sometimes|required|exists:usuario,id_usuario',
            'cod_riesgo' => 'sometimes|required|exists:riesgo,cod_riesgo',
            'cod_dm' => 'sometimes|required|exists:tipo_dm,cod_dm',
            'peso_previo' => 'sometimes|required|integer|min:0',
            'tal_consulta' => 'sometimes|required|numeric|min:0|max:999.99',
            'imc_consulta' => 'sometimes|required|integer|min:0',
            'diag_nutricional' => 'sometimes|required|string|max:255',
            'hta' => 'sometimes|required|integer|in:0,1',
            'dm' => 'sometimes|required|integer|in:0,1',
            'fact_riesgo' => 'sometimes|required|string|max:255',
            'expo_violencia' => 'sometimes|required|string|max:255',
            'ries_depresion' => 'sometimes|required|string|max:255',
            'for_gestacion' => 'sometimes|required|integer|min:0',
            'for_parto' => 'sometimes|required|integer|min:0',
            'for_cesarea' => 'sometimes|required|integer|min:0',
            'for_aborto' => 'sometimes|required|integer|min:0',
            'fec_lactancia' => 'sometimes|required|date',
            'fec_consejeria' => 'sometimes|required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'estado' => 'Error',
                'errores' => $validator->errors()
            ], 422);
        }

        $consulta->update($request->all());

        return response()->json([
            'estado' => 'Ok',
            'consulta' => $consulta
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $consulta = PrimeraConsulta::find($id);

        if (!$consulta) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Consulta no encontrada'
            ], 404);
        }

        $consulta->delete();

        return response()->json([
            'estado' => 'Ok',
            'mensaje' => 'Consulta eliminada'
        ]);
    }
}
