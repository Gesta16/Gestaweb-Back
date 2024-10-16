<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SeguimientoConsultaMensual;
use App\Models\ConsultasUsuario;
use App\Models\ProcesoGestativo;

use Illuminate\Http\Request;

class SeguimientoConsultaMensualController extends Controller
{
    
    public function index()
    {
        $seguimientos = SeguimientoConsultaMensual::all();
        return response()->json($seguimientos);
    }

    
    public function store(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para realizar esta acción'
            ], 401); // 401 Unauthorized
        }
    
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'cod_riesgo' => 'required|exists:riesgo,cod_riesgo',
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'cod_controles' => 'required|exists:numero_controles,cod_controles',
            'cod_diagnostico' => 'required|exists:diagnostico_nutricional_mes,cod_diagnostico',
            'cod_medicion' => 'required|exists:forma_medicion_edad_gestacional,cod_medicion',
            'fec_consulta' => 'required|date',
            'edad_gestacional' => 'required|integer',
            'alt_uterina' => 'required|numeric',
            'trim_gestacional' => 'required|integer',
            'peso' => 'required|numeric',
            'talla' => 'required|numeric',
            'imc' => 'required|numeric',
            'ten_arts' => 'required|numeric',
            'ten_artd' => 'required|numeric',
            'num_proceso' => 'required|integer', // Añadir validación para num_proceso
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
    
        // Asignar el id_operador y el id del proceso gestativo
        $validatedData['id_operador'] = auth()->user()->userable_id;
        $validatedData['proceso_gestativo_id'] = $procesoGestativo->id;
    
        // Crear el registro de SeguimientoConsultaMensual
        $seguimiento = SeguimientoConsultaMensual::create($validatedData);
    
        // Crear el registro de ConsultasUsuario
        ConsultasUsuario::create([
            'id_usuario' => $validatedData['id_usuario'],
            'fecha' => now(),
            'nombre_consulta' => 'Consulta Mensual', 
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
        $seguimiento = SeguimientoConsultaMensual::where('id_usuario', $id)
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
                'cod_riesgo' => 'required|exists:riesgo,cod_riesgo',
                'id_usuario' => 'required|integer|exists:usuario,id_usuario',
                'cod_controles' => 'required|exists:numero_controles,cod_controles',
                'cod_diagnostico' => 'required|exists:diagnostico_nutricional_mes,cod_diagnostico',
                'cod_medicion' => 'required|exists:forma_medicion_edad_gestacional,cod_medicion',
                'fec_consulta' => 'required|date',
                'edad_gestacional' => 'required|integer',
                'alt_uterina' => 'required|numeric',
                'trim_gestacional' => 'required|integer',
                'peso' => 'required|numeric',
                'talla' => 'required|numeric',
                'imc' => 'required|numeric',
                'ten_arts' => 'required|numeric',
                'ten_artd' => 'required|numeric',
            ]);

            // Validación del campo id_usuario
            if (!isset($validatedData['id_usuario'])) {
                return response()->json([
                    'estado' => 'Error',
                    'mensaje' => 'El campo id_usuario es requerido'
                ], 400); // Bad request
            }

            // Buscar el seguimiento
            $seguimiento = SeguimientoConsultaMensual::where('cod_seguimiento', $id)
                ->where('id_usuario', $validatedData['id_usuario'])
                ->firstOrFail();

            // Actualizar el registro
            $seguimiento->update($validatedData);

            return response()->json([
                'estado' => 'Ok',
                'mensaje' => 'Seguimiento actualizado correctamente',
                'data' => $seguimiento
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Seguimiento no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Error al actualizar el seguimiento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    public function destroy($id)
    {
        $seguimiento = SeguimientoConsultaMensual::findOrFail($id);
        $seguimiento->delete();
        return response()->json(null, 204);
    }
}
