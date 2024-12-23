<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vacunacion;
use Illuminate\Support\Facades\Validator;



class VacunacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vacunaciones = Vacunacion::with(['operador', 'usuario', 'biologico'])->get();

        return response()->json([
            'estado' => 'Ok',
            'vacunaciones' => $vacunaciones
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
        // Verificar que el usuario esté autenticado
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'No autenticado'
            ], 401);
        }
    
        // Validación de los datos recibidos
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'cod_biologico' => 'required|exists:biologico,cod_biologico',
            'fec_unocovid' => 'nullable|date',
            'fec_doscovid' => 'nullable|date',
            'fec_refuerzo' => 'nullable|date',
            'fec_influenza' => 'nullable|date',
            'fec_tetanico' => 'nullable|date',
            'fec_dpt' => 'nullable|date',
            'recib_prim_dosis_covid19' => 'required|boolean',
            'recib_segu_dosis_covid19' => 'required|boolean',
            'recib_refu_covid19' => 'required|boolean',
            'recib_dosis_influenza' => 'required|boolean',
            'recib_dosis_tox_tetanico' => 'required|boolean',
            'recib_dosis_dpt_a_celular' => 'required|boolean',
        ]);
    
        // Si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'estado' => 'Error',
                'errores' => $validator->errors()
            ], 422);
        }
    
        // Asignar el id_operador autenticado
        $validatedData = $request->all();
        $validatedData['id_operador'] = auth()->user()->userable_id;
    
        // Crear el registro de vacunación
        $vacunacion = Vacunacion::create($validatedData);
    
        // Retornar la respuesta exitosa
        return response()->json([
            'estado' => 'Ok',
            'mensaje'=>'Vacunación creada exitosamente',
            'vacunacion' => $vacunacion
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
        $vacunacion = Vacunacion::with(['operador', 'usuario', 'biologico'])->where('id_usuario', $id)->firstOrFail();

        if (!$vacunacion) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Vacunación no encontrada'
            ], 404);
        }

        return response()->json([
            'estado' => 'Ok',
            'vacunacion' => $vacunacion
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
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'No autenticado'
            ], 401);
        }
    
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'sometimes|required|exists:usuario,id_usuario',
            'cod_biologico' => 'sometimes|required|exists:biologico,cod_biologico',
            'fec_unocovid' => 'sometimes|nullable|date',
            'fec_doscovid' => 'sometimes|nullable|date',
            'fec_refuerzo' => 'sometimes|nullable|date',
            'fec_influenza' => 'sometimes|nullable|date',
            'fec_tetanico' => 'sometimes|nullable|date',
            'fec_dpt' => 'sometimes|nullable|date',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'estado' => 'Error',
                'errores' => $validator->errors()
            ], 422);
        }
    
        // Buscar la vacunación
        $vacunacion = Vacunacion::where('cod_vacunacion', $id)
                                ->where('id_usuario', $request->id_usuario)
                                ->first();
    
        if (!$vacunacion) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Vacunación no encontrada'
            ], 404);
        }
    
        // Actualizar los datos de la vacunación
        $vacunacion->update($validator->validated());
    
        return response()->json([
            'estado' => 'Ok',
            'mensaje'=>'Vacunación editada exitosamente',
            'vacunacion' => $vacunacion
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
        $vacunacion = Vacunacion::find($id);

        if (!$vacunacion) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Vacunación no encontrada'
            ], 404);
        }

        $vacunacion->delete();

        return response()->json([
            'estado' => 'Ok',
            'mensaje' => 'Vacunación eliminada'
        ]);
    }
}
