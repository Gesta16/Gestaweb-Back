<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaboratorioITrimestre;

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
    'cod_antibiograma' => 'required|integer|exists:antibiograma,cod_antibiograma',
    'fec_hemoclasificacion' => 'required|date',
    'hem_laboratorio' => 'required|string',
    'fec_hemograma' => 'required|date',
    'gli_laboratorio' => 'required|integer',
    'fec_glicemia' => 'required|date',
    'ant_laboratorio' => 'required|string',
    'fec_antigeno' => 'required|date',
    'pru_vih' => 'required|string',
    'fec_vih' => 'required|date',
    'pru_sifilis' => 'required|string',
    'fec_sifilis' => 'required|date',
    'uro_laboratorio' => 'required|string',
    'fec_urocultivo' => 'required|date',
    'fec_antibiograma' => 'required|date',
    'ig_rubeola' => 'required|string',
    'fec_rubeola' => 'required|date',
    'ig_toxoplasma' => 'required|string',
    'fec_toxoplasma' => 'required|date',
    'hem_gruesa' => 'required|string',
    'fec_hemoparasito' => 'required|date',
    'pru_antigenos' => 'required|string',
    'fec_antigenos' => 'required|date',
    'eli_recombinante' => 'required|string',
    'fec_recombinante' => 'required|date',
    'coo_cuantitativo' => 'required|string',
    'fec_coombs' => 'required|date',
    'fec_ecografia' => 'required|date',
    'eda_gestacional' => 'required|numeric|min:0', // Cambia a numeric
    'rie_biopsicosocial' => 'required|string',
]);


    // Asignar el id_operador del usuario autenticado
    $validatedData['id_operador'] = auth()->user()->userable_id;

    // Crear el registro de LaboratorioITrimestre
    $laboratorio = LaboratorioITrimestre::create($validatedData);

    return response()->json(['estado' => 'Ok', 'data' => $laboratorio], 201);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $laboratorio = LaboratorioITrimestre::with(['operador', 'usuario', 'hemoclasificacion', 'antibiograma'])
            ->where('id_usuario', $id)->firstOrFail();
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
            'cod_antibiograma' => 'required|integer|exists:antibiograma,cod_antibiograma',
            'fec_hemoclasificacion' => 'required|date',
            'hem_laboratorio' => 'required|string',
            'fec_hemograma' => 'required|date',
            'gli_laboratorio' => 'required|integer',
            'fec_glicemia' => 'required|date',
            'ant_laboratorio' => 'required|string',
            'fec_antigeno' => 'required|date',
            'pru_vih' => 'required|string',
            'fec_vih' => 'required|date',
            'pru_sifilis' => 'required|string',
            'fec_sifilis' => 'required|date',
            'uro_laboratorio' => 'required|string',
            'fec_urocultivo' => 'required|date',
            'fec_antibiograma' => 'required|date',
            'ig_rubeola' => 'required|string',
            'fec_rubeola' => 'required|date',
            'ig_toxoplasma' => 'required|string',
            'fec_toxoplasma' => 'required|date',
            'hem_gruesa' => 'required|string',
            'fec_hemoparasito' => 'required|date',
            'pru_antigenos' => 'required|string',
            'fec_antigenos' => 'required|date',
            'eli_recombinante' => 'required|string',
            'fec_recombinante' => 'required|date',
            'coo_cuantitativo' => 'required|string',
            'fec_coombs' => 'required|date',
            'fec_ecografia' => 'required|date',
            'eda_gestacional' => 'required|numeric|min:0', // numérico en lugar de entero
            'rie_biopsicosocial' => 'required|string',
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
