<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaboratorioIIITrimestre;
use App\Models\ConsultasUsuario;
use App\Models\ProcesoGestativo;


class LaboratorioIIITrimestreController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401); 
        }

        $laboratorios = LaboratorioIIITrimestre::all();
        return response()->json($laboratorios);
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
    
        // Obtener el registro de LaboratorioIIITrimestre con relaciones
        $laboratorio = LaboratorioIIITrimestre::where('id_usuario', $id)
                                              ->where('proceso_gestativo_id', $procesoGestativo->id)
                                              ->firstOrFail();
    
        return response()->json([
            'estado' => 'Ok',
            'data' => $laboratorio
        ]);
    }
    
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
            'hemograma' => 'required|string',
            'fec_hemograma' => 'required|date',
            'pru_vih' => 'required|string',
            'fec_vih' => 'required|date',
            'pru_sifilis' => 'required|string',
            'fec_sifilis' => 'required|date',
            'ig_toxoplasma' => 'required|string',
            'fec_toxoplasma' => 'required|date',
            'cul_rectal' => 'required|string',
            'fec_rectal' => 'required|date',
            'fec_biofisico' => 'required|date',
            'edad_gestacional' => 'required|integer|min:0',
            'rie_biopsicosocial' => 'required|string',
            'num_proceso' => 'required|integer', // Asegurarse de incluir num_proceso
            'reali_prueb_rapi_vih' => 'required|boolean',
            'reali_prueb_trepo_rap_sifilis' => 'required|boolean',
            'reali_prueb_igm_toxoplasma' => 'required|boolean',
            'reali_prueba_cul_rect_vagi' => 'required|boolean',
            'reali_prueb_perfil_biofisico' => 'required|boolean'
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
    
        // Crear el registro de LaboratorioIIITrimestre
        $laboratorio = LaboratorioIIITrimestre::create($validatedData);
    
        // Crear el registro de ConsultasUsuario
        ConsultasUsuario::create([
            'id_usuario' => $validatedData['id_usuario'],
            'fecha' => now(),
            'nombre_consulta' => 'Laboratorios tercer semestre', 
        ]);
    
        return response()->json([
            'estado' => 'Ok',
            'data' => $laboratorio
        ], 201);
    }
    

    public function update(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401); 
        }

        $laboratorio = LaboratorioIIITrimestre::findOrFail($id);
        $validatedData = $request->validate([
            'id_usuario' => 'sometimes|exists:usuario,id_usuario',
            'hemograma' => 'sometimes|string',
            'fec_hemograma' => 'sometimes|date',
            'pru_vih' => 'sometimes|string',
            'fec_vih' => 'sometimes|date',
            'pru_sifilis' => 'sometimes|string',
            'fec_sifilis' => 'sometimes|date',
            'ig_toxoplasma' => 'sometimes|string',
            'fec_toxoplasma' => 'sometimes|date',
            'cul_rectal' => 'sometimes|string',
            'fec_rectal' => 'sometimes|date',
            'fec_biofisico' => 'sometimes|date',
            'edad_gestacional' => 'sometimes|integer|min:0',
            'rie_biopsicosocial' => 'sometimes|string',
        ]);

        $laboratorio= LaboratorioIIITrimestre::where('cod_treslaboratorio', $id)
                                             ->where('id_usuario', $validatedData['id_usuario'])
                                             ->firstOrFail();

        $laboratorio->update($validatedData);

        return response()->json([
            'estado' => 'Ok',
            'data' => $laboratorio
        ]);
    }

    public function destroy($id)
    {
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401); 
        }

        $laboratorio = LaboratorioIIITrimestre::findOrFail($id);
        $laboratorio->delete();
        return response()->json(null, 204);
    }
}
