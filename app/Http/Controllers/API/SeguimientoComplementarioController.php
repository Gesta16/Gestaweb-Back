<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SeguimientoComplementario;
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
            'fec_nutricion' => 'required|date',
            'fec_ginecologia' => 'required|date',
            'fec_psicologia' => 'required|date',
            'fec_odontologia' => 'required|date',
            'ina_seguimiento' => 'required|string',
            'cau_inasistencia' => 'nullable|string',
        ]);

        $validatedData['id_operador'] = auth()->user()->userable_id;

        $seguimiento = SeguimientoComplementario::create($validatedData);
        return response()->json($seguimiento, 201);
    }

    public function show($id)
    {
        $seguimiento = SeguimientoComplementario::where('id_usuario', $id)->firstOrFail();

        if ($seguimiento) {
            return response()->json([
                'estado' => 'Ok',
                'seguimiento' => $seguimiento
            ], 200);
        } else {
            return response()->json([
                'error' => 'Seguimiento no encontrado'
            ], 404);
        }
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
