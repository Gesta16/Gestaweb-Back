<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrimeraConsulta;
use App\Models\ConsultasUsuario;
use App\Models\ProcesoGestativo;
use Illuminate\Support\Facades\Log;
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
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401); 
        }
    
        Log::info('Datos de entrada:', $request->all());
    

        $validator = Validator::make($request->all(), [
            'id_operador' => 'sometimes|required|exists:operador,id_operador',
            'id_usuario' => 'sometimes|required|exists:usuario,id_usuario',
            'cod_riesgo' => 'sometimes|required|exists:riesgo,cod_riesgo',
            'cod_dm' => 'sometimes|nullable|exists:tipo_dm,cod_dm',
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
            'fec_lactancia' => 'sometimes|nullable|date',
            'fec_consejeria' => 'sometimes|nullable|date',
            'num_proceso'=>'integer|required',
            'asis_conse_lactancia' => 'required|boolean',
            'asis_conse_pre_vih' => 'required|boolean'
        ]);
    
        if ($validator->fails()) {
            Log::error('Error al crear el registro:', [
                'errores' => $validator->errors(),
                'input' => $request->all(),
            ]);
            return response()->json([
                'estado' => 'Error',
                'errores' => $validator->errors()
            ], 422);
        }
    
        // Validar los datos
        $validatedData = $validator->validated();
        // Asignar el id_operador del usuario autenticado
        $validatedData['id_operador'] = auth()->user()->userable_id;
    
        // Verificar que el proceso gestativo existe
        $procesoGestativo = ProcesoGestativo::where('id_usuario', $validatedData['id_usuario'])
                                    ->where('num_proceso', $validatedData['num_proceso'])
                                    ->where('estado', 1)
                                    ->first();
        
        if (!$procesoGestativo) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'No se encontró el proceso gestativo para el usuario proporcionado.'
            ], 404);
        }
    
        // Asignar el ID del proceso gestativo
        $validatedData['proceso_gestativo_id'] = $procesoGestativo->id;
    
        // Crear el registro de LaboratorioITrimestre
        $primeraConsulta = PrimeraConsulta::create($validatedData);
    
        // Crear el registro de ConsultasUsuario
        ConsultasUsuario::create([
            'id_usuario' => $validatedData['id_usuario'],
            'fecha' => now(), 
            'nombre_consulta' => 'Laboratorios primer trimestre', 
        ]);
    
        return response()->json([
            'estado' => 'Ok',
            'mensaje' => 'Primera consulta creada exitosamente',
            'data' => $primeraConsulta
        ], 201);
    }
    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$num_proceso)
    {
         $procesoGestativo = ProcesoGestativo::where('id_usuario', $id)
                                ->where('num_proceso', $num_proceso)
                                ->first();
    
        if (!$procesoGestativo) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'No se encontró el proceso gestativo para el usuario proporcionado.'
            ], 404);
        }      
            
        $consulta = PrimeraConsulta::with(['operador', 'usuario', 'riesgo', 'tipoDm'])
                                    ->where('id_usuario', $id)
                                    ->where('proceso_gestativo_id',$procesoGestativo->id)
                                    ->firstOrFail();

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

        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401); 
        }

        $consulta = PrimeraConsulta::where('cod_consulta', $id)
                                   ->where('id_usuario', $request->id_usuario)
                                   ->first();
    
        if (!$consulta) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Consulta no encontrada o id_usuario no coincide'
            ], 404);
        }
    
        // Validación de los datos entrantes
        $validator = Validator::make($request->all(), [
            'id_operador' => 'sometimes|required|exists:operador,id_operador',
            'id_usuario' => 'sometimes|required|exists:usuario,id_usuario',
            'cod_riesgo' => 'sometimes|required|exists:riesgo,cod_riesgo',
            'cod_dm' => 'sometimes|nullable|exists:tipo_dm,cod_dm',
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
            'fec_lactancia' => 'sometimes|nullable|date',
            'fec_consejeria' => 'sometimes|nullable|date',
            'asis_conse_lactancia' => 'required|boolean',
            'asis_conse_pre_vih' => 'required|boolean'
        ]);
    
        // Si la validación falla, devuelve un error 422
        if ($validator->fails()) {
            return response()->json([
                'estado' => 'Error',
                'errores' => $validator->errors()
            ], 422);
        }
    
        // Actualizar solo con los datos validados
        $consulta->update($validator->validated());
    
        // Devolver respuesta exitosa con los datos actualizados
        return response()->json([
            'estado' => 'Ok',
            'mensaje' => 'Consulta actualizado correctamente',
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
