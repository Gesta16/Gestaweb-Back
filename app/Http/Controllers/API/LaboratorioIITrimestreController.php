<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConsultasUsuario;
use App\Models\LaboratorioIITrimestre;
use Illuminate\Support\Facades\Validator;
use App\Models\ProcesoGestativo;




class LaboratorioIITrimestreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laboratorios = LaboratorioIITrimestre::with(['operador', 'usuario'])->get();

        return response()->json([
            'estado' => 'Ok',
            'data' => $laboratorios
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
    
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'num_proceso' => 'required|integer',
            'pru_vih' => 'required|string',
            'fec_vih' => 'required|date',
            'pru_sifilis' => 'required|string',
            'fec_sifilis' => 'required|date',
            'pru_oral' => 'required|string',
            'pru_uno' => 'required|string',
            'pru_dos' => 'required|string',
            'fec_prueba' => 'required|date',
            'rep_citologia' => 'required|string',
            'fec_citologia' => 'required|date',
            'ig_toxoplasma' => 'required|string',
            'fec_toxoplasma' => 'required|date',
            'pru_avidez' => 'required|string',
            'fec_avidez' => 'required|date',
            'tox_laboratorio' => 'required|string',
            'fec_toxoplasmosis' => 'required|date',
            'hem_gruesa' => 'required|string',
            'fec_hemoparasito' => 'required|date',
            'coo_cualitativo' => 'required|string',
            'fec_coombs' => 'required|date',
            'fec_ecografia' => 'required|date',
            'eda_gestacional' => 'required|numeric|min:0',
            'rie_biopsicosocial' => 'required|string',
            'reali_prueb_rapi_vih' => 'required|boolean',
            'reali_prueb_trepo_rap_sifilis' => 'required|boolean',
            'reali_citologia' => 'required|boolean',
            'reali_prueb_avidez_igg' => 'required|boolean',
            'reali_prueb_toxopla_iga' => 'required|boolean',
            'reali_prueb_hemoparasito' => 'required|boolean',
            'reali_prueb_coombis_indi_cuanti' => 'required|boolean',
            'reali_eco_obste_deta_anatomico' => 'required|boolean',
        ]);
    
        // Verificar que el ProcesoGestativo esté activo
        $procesoGestativo = ProcesoGestativo::where('id_usuario', $validatedData['id_usuario'])
                                            ->where('num_proceso', $validatedData['num_proceso'])
                                            ->where('estado', 1)
                                            ->first();
    
        if (!$procesoGestativo) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'No se encontró el proceso gestativo activo para el usuario proporcionado.'
            ], 404);
        }
    
        // Asignar el id_operador y el id del proceso gestativo
        $validatedData['id_operador'] = auth()->user()->userable_id;
        $validatedData['proceso_gestativo_id'] = $procesoGestativo->id;
    
        // Crear el registro de LaboratorioIITrimestre
        $laboratorio = LaboratorioIITrimestre::create($validatedData);
    
        // Crear el registro de ConsultasUsuario
        ConsultasUsuario::create([
            'id_usuario' => $validatedData['id_usuario'],
            'fecha' => now(),
            'nombre_consulta' => 'Laboratorios segundo trimestre', 
        ]);
    
        return response()->json([
            'estado' => 'Ok',
            'data' => $laboratorio
        ], 201);
    }
    
    public function show($id,$num_proceso)
    {
        // Verificar que el ProcesoGestativo esté activo
        $procesoGestativo = ProcesoGestativo::where('id_usuario', $id)
                                            ->where('num_proceso', $num_proceso)
                                            ->first();
    
        if (!$procesoGestativo) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'No se encontró el proceso gestativo activo para el usuario proporcionado.'
            ], 404);
        }
    
        // Obtener el registro de LaboratorioIITrimestre con relaciones
        $laboratorio = LaboratorioIITrimestre::with(['operador', 'usuario'])
                                             ->where('id_usuario', $id)
                                             ->where('proceso_gestativo_id', $procesoGestativo->id)
                                             ->firstOrFail();
    
        return response()->json([
            'estado' => 'Ok',
            'data' => $laboratorio
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
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401); 
        }
    
        // Buscar el registro a actualizar
        $laboratorio = LaboratorioIITrimestre::find($id);
    
        if (!$laboratorio) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Registro no encontrado'
            ], 404);
        }
    
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'id_usuario' => 'sometimes|required|integer|exists:usuario,id_usuario',
            'pru_vih' => 'sometimes|required|string',
            'fec_vih' => 'sometimes|required|date',
            'pru_sifilis' => 'sometimes|required|string',
            'fec_sifilis' => 'sometimes|required|date',
            'pru_oral' => 'sometimes|required|string',
            'pru_uno' => 'sometimes|required|string',
            'pru_dos' => 'sometimes|required|string',
            'fec_prueba' => 'sometimes|required|date',
            'rep_citologia' => 'sometimes|required|string',
            'fec_citologia' => 'sometimes|required|date',
            'ig_toxoplasma' => 'sometimes|required|string',
            'fec_toxoplasma' => 'sometimes|required|date',
            'pru_avidez' => 'sometimes|required|string',
            'fec_avidez' => 'sometimes|required|date',
            'tox_laboratorio' => 'sometimes|required|string',
            'fec_toxoplasmosis' => 'sometimes|required|date',
            'hem_gruesa' => 'sometimes|required|string',
            'fec_hemoparasito' => 'sometimes|required|date',
            'coo_cualitativo' => 'sometimes|required|string',
            'fec_coombs' => 'sometimes|required|date',
            'fec_ecografia' => 'sometimes|required|date',
            'eda_gestacional' => 'sometimes|required|numeric|min:0',
            'rie_biopsicosocial' => 'sometimes|required|string',
        ]);
    
        // Asignar el id_operador del usuario autenticado si no se envía uno nuevo
        if (!array_key_exists('id_operador', $validatedData)) {
            $validatedData['id_operador'] = auth()->user()->userable_id;
        }
    
        // Actualizar el registro de LaboratorioIITrimestre
        $laboratorio = LaboratorioIITrimestre::where('cod_doslaboratorio', $id)
                                            ->where('id_usuario', $validatedData['id_usuario'])
                                             ->firstOrFail();

        $laboratorio->update($validatedData);

    
        return response()->json([
            'estado' => 'Ok',
            'data' => $laboratorio
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
        $laboratorio = LaboratorioIITrimestre::find($id);

        if (!$laboratorio) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Registro no encontrado'
            ], 404);
        }

        $laboratorio->delete();

        return response()->json([
            'estado' => 'Ok',
            'mensaje' => 'Registro eliminado correctamente'
        ]);
    }
    
}
