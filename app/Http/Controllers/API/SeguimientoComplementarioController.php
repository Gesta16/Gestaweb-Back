<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SeguimientoComplementario;
use App\Models\ConsultasUsuario;
use App\Models\ProcesoGestativo;
use Illuminate\Http\Request;

class SeguimientoComplementarioController extends Controller
{
    
    public function index()
    {
        $seguimientos = SeguimientoComplementario::all();
        return response()->json($seguimientos);
    }

    
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401); // 401 Unauthorized
        }
    
        $validatedData = $request->validate([
            'cod_sesiones' => 'required|exists:num_sesiones_curso_paternidad_maternidad,cod_sesiones',
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'num_proceso' => 'required|integer', // Validación para num_proceso
            'fec_nutricion' => 'required|date',
            'fec_ginecologia' => 'required|date',
            'fec_psicologia' => 'required|date',
            'fec_odontologia' => 'required|date',
            'ina_seguimiento' => 'required|string',
            'cau_inasistencia' => 'nullable|string',
            'asistio_nutricionista' => 'required|boolean',
            'asistio_ginecologia' => 'required|boolean',
            'asistio_psicologia' => 'required|boolean',
            'asistio_odontologia' => 'required|boolean'
        ]);
    
        // Verificar que el ProcesoGestativo esté activo
        $procesoGestativo = ProcesoGestativo::where('id_usuario', $validatedData['id_usuario'])
                                            ->where('num_proceso', $validatedData['num_proceso'])
                                            ->where('estado', 1) // O el estado que definas para "activo"
                                            ->first();
    
        if (!$procesoGestativo) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'No se encontró el proceso gestativo activo para el usuario proporcionado.'
            ], 404);
        }
    
        $validatedData['id_operador'] = auth()->user()->userable_id;
        $validatedData['proceso_gestativo_id'] = $procesoGestativo->id;
    
        $seguimiento = SeguimientoComplementario::create($validatedData);
    
        ConsultasUsuario::create([
            'id_usuario' => $validatedData['id_usuario'],
            'fecha' => now(),
            'nombre_consulta' => 'Control Complementario',
        ]);
    
        return response()->json([
            'estado' => 'Ok',
            'mensaje' => 'Seguimiento creado exitosamente',
            'data' => $seguimiento
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
    
        // Obtener el seguimiento correspondiente
        $seguimiento = SeguimientoComplementario::where('id_usuario', $id)
                                                 ->where('proceso_gestativo_id', $procesoGestativo->id)
                                                 ->firstOrFail();
    
        return response()->json([
            'estado' => 'Ok',
            'seguimiento' => $seguimiento
        ], 200);
    }
    

    public function update(Request $request, $id)
    {
        try {
            if (!auth()->check()) {
                return response()->json([
                    'estado' => 'Error',
                    'mensaje' => 'Debes estar autenticado para realizar esta acción'
                ], 401); // 401 Unauthorized
            }

            $validatedData = $request->validate([
                'cod_sesiones' => 'required|exists:num_sesiones_curso_paternidad_maternidad,cod_sesiones',
                'id_usuario' => 'required|integer|exists:usuario,id_usuario',
                'fec_nutricion' => 'required|date',
                'fec_ginecologia' => 'required|date',
                'fec_psicologia' => 'required|date',
                'fec_odontologia' => 'required|date',
                'ina_seguimiento' => 'required|string',
                'cau_inasistencia' => 'nullable|string',
            ]);

            // Validación del campo id_usuario
            if (!isset($validatedData['id_usuario'])) {
                return response()->json([
                    'estado' => 'Error',
                    'mensaje' => 'El campo id_usuario es requerido'
                ], 400); // Bad request
            }

            // Buscar el seguimiento
            $seguimiento = SeguimientoComplementario::where('cod_segcomplementario', $id)
                ->where('id_usuario', $validatedData['id_usuario'])
                ->firstOrFail();

            // Actualizar el registro
            $seguimiento->update($validatedData);

            return response()->json([
                'estado' => 'Ok',
                'mensaje' => 'Seguimiento complementario actualizado correctamente',
                'data' => $seguimiento
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Seguimiento complementario no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Error al actualizar el seguimiento complementario',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        $seguimiento = SeguimientoComplementario::findOrFail($id);
        $seguimiento->delete();
        return response()->json(null, 204);
    }
}
