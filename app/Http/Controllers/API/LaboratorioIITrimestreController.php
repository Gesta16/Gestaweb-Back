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
            'pru_vih' => 'nullable|string',
            'fec_vih' => 'nullable|date',
            'pru_sifilis' => 'nullable|string',
            'fec_sifilis' => 'nullable|date',
            'pru_oral' => 'required|string',
            'pru_uno' => 'required|string',
            'pru_dos' => 'required|string',
            'fec_prueba' => 'required|date',
            'rep_citologia' => 'nullable|string',
            'fec_citologia' => 'nullable|date',
            'ig_toxoplasma' => 'required|string',
            'fec_toxoplasma' => 'required|date',
            'pru_avidez' => 'nullable|string',
            'fec_avidez' => 'nullable|date',
            'tox_laboratorio' => 'nullable|string',
            'fec_toxoplasmosis' => 'nullable|date',
            'hem_gruesa' => 'nullable|string',
            'fec_hemoparasito' => 'nullable|date',
            'coo_cualitativo' => 'nullable|string',
            'fec_coombs' => 'nullable|date',
            'fec_ecografia' => 'nullable|date',
            'eda_gestacional' => 'nullable|numeric|min:0',
            'rie_biopsicosocial' => 'required|string',
            'reali_prueb_rapi_vih' => 'required|boolean',
            'real_prueb_trep_rap_sifilis' => 'required|boolean',
            'reali_citologia' => 'required|boolean',
            'reali_prueb_avidez_ig_g' => 'required|boolean',
            'reali_prueb_toxoplasmosis_ig_a' => 'required|boolean',
            'reali_prueb_hemoparasito' => 'required|boolean',
            'reali_prueb_coombis_indi_cuanti' => 'required|boolean',
            'reali_eco_obste_detalle_anato' => 'required|boolean',
            'real_igm_toxoplasma_2' => 'required|boolean',
            'real_prueb_oral' => 'required|boolean',
            'real_prueb_oral_1' => 'required|boolean',
            'real_prueb_oral_2' => 'required|boolean'
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
            'mensaje' => 'Laboratorio segundo trimestre creado con exito',
            'data' => $laboratorio
        ], 201);
    }

    public function show($id, $num_proceso)
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
            'pru_vih' => 'sometimes|nullable|string',
            'fec_vih' => 'sometimes|nullable|date',
            'pru_sifilis' => 'sometimes|nullable|string',
            'fec_sifilis' => 'sometimes|nullable|date',
            'pru_oral' => 'sometimes|nullable|string',
            'pru_uno' => 'sometimes|nullable|string',
            'pru_dos' => 'sometimes|nullable|string',
            'fec_prueba' => 'sometimes|nullable|date',
            'rep_citologia' => 'sometimes|nullable|string',
            'fec_citologia' => 'sometimes|nullable|date',
            'ig_toxoplasma' => 'sometimes|required|string',
            'fec_toxoplasma' => 'sometimes|required|date',
            'pru_avidez' => 'sometimes|nullable|string',
            'fec_avidez' => 'sometimes|nullable|date',
            'tox_laboratorio' => 'sometimes|nullable|string',
            'fec_toxoplasmosis' => 'sometimes|nullable|date',
            'hem_gruesa' => 'sometimes|nullable|string',
            'fec_hemoparasito' => 'sometimes|nullable|date',
            'coo_cualitativo' => 'sometimes|nullable|string',
            'fec_coombs' => 'sometimes|nullable|date',
            'fec_ecografia' => 'sometimes|nullable|date',
            'eda_gestacional' => 'sometimes|nullable|numeric|min:0',
            'rie_biopsicosocial' => 'sometimes|required|string',
            'reali_prueb_rapi_vih' => 'sometimes|required|boolean',
            'real_prueb_trep_rap_sifilis' => 'sometimes|required|boolean',
            'reali_citologia' => 'sometimes|required|boolean',
            'reali_prueb_avidez_ig_g' => 'sometimes|required|boolean',
            'reali_prueb_toxoplasmosis_ig_a' => 'sometimes|required|boolean',
            'reali_prueb_hemoparasito' => 'sometimes|required|boolean',
            'reali_prueb_coombis_indi_cuanti' => 'sometimes|required|boolean',
            'reali_eco_obste_detalle_anato' => 'sometimes|required|boolean',
            'real_igm_toxoplasma_2' => 'sometimes|required|boolean',
            'real_prueb_oral' => 'sometimes|required|boolean',
            'real_prueb_oral_1' => 'sometimes|required|boolean',
            'real_prueb_oral_2' => 'sometimes|required|boolean',
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
            'mensaje' => 'Laboratorio 2 trimestre editado con exito',
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
