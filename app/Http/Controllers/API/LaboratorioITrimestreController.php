<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaboratorioITrimestre;
use App\Models\ConsultasUsuario;
use App\Models\ProcesoGestativo;



class LaboratorioITrimestreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laboratorios = LaboratorioITrimestre::with(['operador', 'usuario', 'hemoclasificacion', 'antibiograma'])->get();
        return response()->json(['estado' => 'Ok', 'data' => $laboratorios]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401);
        }

        // Validar los datos de entrada
        $validatedData = $request->validate([
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'cod_hemoclasifi' => 'required|integer|exists:hemoclasificacion,cod_hemoclasifi',
            'cod_antibiograma' => 'nullable|integer|exists:antibiograma,cod_antibiograma',
            'fec_hemoclasificacion' => 'required|date',
            'hem_laboratorio' => 'nullable|string',
            'fec_hemograma' => 'nullable|date',
            'gli_laboratorio' => 'nullable|integer',
            'fec_glicemia' => 'nullable|date',
            'ant_laboratorio' => 'nullable|string',
            'fec_antigeno' => 'nullable|date',
            'pru_vih' => 'nullable|string',
            'fec_vih' => 'nullable|date',
            'pru_sifilis' => 'nullable|string',
            'fec_sifilis' => 'nullable|date',
            'uro_laboratorio' => 'nullable|string',
            'fec_urocultivo' => 'nullable|date',
            'fec_antibiograma' => 'nullable|date',
            'ig_rubeola' => 'required|string',
            'fec_rubeola' => 'required|date',
            'ig_toxoplasma' => 'required|string',
            'fec_toxoplasma' => 'required|date',
            'igm_toxoplamas' => 'nullable|string',
            'fec_igmtoxoplasma' => 'nullable|date',
            'hem_gruesa' => 'required|string',
            'fec_hemoparasito' => 'required|date',
            'pru_antigenos' => 'nullable|string',
            'fec_antigenos' => 'nullable|date',
            'eli_recombinante' => 'nullable|string',
            'fec_recombinante' => 'nullable|date',
            'coo_cuantitativo' => 'nullable|string',
            'fec_coombs' => 'nullable|date',
            'fec_ecografia' => 'nullable|date',
            'eda_gestacional' => 'nullable|numeric|min:0',
            'rie_biopsicosocial' => 'required|string',
            'real_prueb_rapi_vih' => 'required|boolean',
            'reali_prueb_trepo_rapid_sifilis' => 'required|boolean',
            'realizo_urocultivo' => 'required|boolean',
            'realizo_antibiograma' => 'required|boolean',
            'real_prueb_eliza_anti_total' => 'required|boolean',
            'real_prueb_eliza_anti_recomb' => 'required|boolean',
            'real_prueb_coombis_indi_cuanti' => 'required|boolean',
            'real_eco_obste_tamizaje' => 'required|boolean',
            'real_hemograma' => 'required|boolean',
            'real_glicemia' => 'required|boolean',
            'real_antigenos' => 'required|boolean',
            'real_ig_toxoplasma' => 'required|boolean',
            'real_igm_toxoplasma' => 'required|boolean',
            'real_ig_rubeola' => 'required|boolean',
            'real_hemoparasito' => 'required|boolean',
            'num_proceso' => 'required|integer',

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

        // Crear el registro de LaboratorioITrimestre
        $laboratorio = LaboratorioITrimestre::create($validatedData);

        ConsultasUsuario::create([
            'id_usuario' => $validatedData['id_usuario'],
            'fecha' => now(),
            'nombre_consulta' => 'Laboratorios primer trimestre',
        ]);

        return response()->json(['estado' => 'Ok', 'mensaje' => 'Laboratorio 1 trimestre creado con exito.', 'data' => $laboratorio], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $num_proceso)
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


        $laboratorio = LaboratorioITrimestre::with(['operador', 'usuario', 'hemoclasificacion', 'antibiograma'])
            ->where('id_usuario', $id)
            ->where('proceso_gestativo_id', $procesoGestativo->id)
            ->firstOrFail();

        return response()->json(['estado' => 'Ok', 'data' => $laboratorio]);
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

        // Validar los datos de entrada
        $validatedData = $request->validate([
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'cod_hemoclasifi' => 'required|integer|exists:hemoclasificacion,cod_hemoclasifi',
            'cod_antibiograma' => 'nullable|integer|exists:antibiograma,cod_antibiograma',
            'fec_hemoclasificacion' => 'required|date',
            'hem_laboratorio' => 'required|string',
            'fec_hemograma' => 'required|date',
            'gli_laboratorio' => 'required|integer',
            'fec_glicemia' => 'required|date',
            'ant_laboratorio' => 'required|string',
            'fec_antigeno' => 'required|date',
            'pru_vih' => 'nullable|string',
            'fec_vih' => 'nullable|date',
            'pru_sifilis' => 'nullable|string',
            'fec_sifilis' => 'nullable|date',
            'uro_laboratorio' => 'nullable|string',
            'fec_urocultivo' => 'nullable|date',
            'fec_antibiograma' => 'nullable|date',
            'ig_rubeola' => 'required|string',
            'fec_rubeola' => 'required|date',
            'ig_toxoplasma' => 'required|string',
            'fec_toxoplasma' => 'required|date',
            'igm_toxoplamas' => 'nullable|string',
            'fec_igmtoxoplasma' => 'nullable|date',
            'hem_gruesa' => 'required|string',
            'fec_hemoparasito' => 'required|date',
            'pru_antigenos' => 'nullable|string',
            'fec_antigenos' => 'nullable|date',
            'eli_recombinante' => 'nullable|string',
            'fec_recombinante' => 'nullable|date',
            'coo_cuantitativo' => 'nullable|string',
            'fec_coombs' => 'nullable|date',
            'fec_ecografia' => 'nullable|date',
            'eda_gestacional' => 'nullable|numeric|min:0', // numérico en lugar de entero
            'rie_biopsicosocial' => 'required|string',
            'real_prueb_rapi_vih' => 'required|boolean',
            'reali_prueb_trepo_rapid_sifilis' => 'required|boolean',
            'realizo_urocultivo' => 'required|boolean',
            'realizo_antibiograma' => 'required|boolean',
            'real_prueb_eliza_anti_total' => 'required|boolean',
            'real_prueb_eliza_anti_recomb' => 'required|boolean',
            'real_prueb_coombis_indi_cuanti' => 'required|boolean',
            'real_eco_obste_tamizaje' => 'required|boolean',
            'real_hemograma' => 'required|boolean',
            'real_glicemia' => 'required|boolean',
            'real_antigenos' => 'required|boolean',
            'real_ig_toxoplasma' => 'required|boolean',
            'real_igm_toxoplasma' => 'required|boolean',
            'real_ig_rubeola' => 'required|boolean',
            'real_hemoparasito' => 'required|boolean',
        ]);

        // Buscar el registro por id_usuario
        $laboratorio = LaboratorioITrimestre::where('cod_laboratorio', $id)
            ->where('id_usuario', $validatedData['id_usuario'])
            ->firstOrFail();

        // Actualizar el registro con los datos validados
        $laboratorio->update($validatedData);

        // Respuesta con los datos actualizados
        return response()->json([
            'estado' => 'Ok',
            'mensaje' => 'Laboratorio 1 trimestre editado correctamente',
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
        $laboratorio = LaboratorioITrimestre::findOrFail($id);
        $laboratorio->delete();
        return response()->json(['estado' => 'Ok', 'data' => null]);
    }
}
