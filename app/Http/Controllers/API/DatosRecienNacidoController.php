<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DatosRecienNacido;
use Illuminate\Http\Request;
use App\Models\ProcesoGestativo;


class DatosRecienNacidoController extends Controller
{
   
    public function index()
    {
        $datosRecienNacido = DatosRecienNacido::all();
        return response()->json(['estado' => 'Ok', 'data' => $datosRecienNacido]);
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
            'tip_embarazo' => 'required|string',
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'num_nacido' => 'required|integer',
            'sexo' => 'required|string',
            'peso' => 'required|integer',
            'talla' => 'required|integer',
            'pla_canguro' => 'required|string',
            'ips_canguro' => 'nullable|string',
            'num_proceso' => 'required|integer', // Agregar num_proceso a la validación
        ]);
    
        $validatedData['id_operador'] = auth()->user()->userable_id;
    
        // Verificar que el ProcesoGestativo esté activo
        $procesoGestativo = ProcesoGestativo::where('id_usuario', $validatedData['id_usuario'])
                                            ->where('num_proceso', $validatedData['num_proceso'])
                                            ->first();
    
        if (!$procesoGestativo) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'No se encontró el proceso gestativo activo para el usuario proporcionado.'
            ], 404);
        }
    
        // Asignar el id del proceso gestativo a los datos validados
        $validatedData['proceso_gestativo_id'] = $procesoGestativo->id;
    
        // Crear el registro de DatosRecienNacido
        $datosRecienNacido = DatosRecienNacido::create($validatedData);
    
        return response()->json(['estado' => 'Ok', 'data' => $datosRecienNacido], 201); // 201 Created
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
    
        // Obtener los datos del recién nacido para el usuario y proceso
        $datosRecienNacido = DatosRecienNacido::where('id_usuario', $id)
                                              ->where('proceso_gestativo_id', $procesoGestativo->id)
                                              ->first();
    
        if ($datosRecienNacido) {
            return response()->json([
                'estado' => 'Ok',
                'data' => $datosRecienNacido
            ], 200);
        } else {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Registro de recién nacido no encontrado'
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
                ], 401); 
            }

            $validatedData = $request->validate([
                'tip_embarazo' => 'required|string',
                'id_usuario' => 'required|integer|exists:usuario,id_usuario',
                'num_nacido' => 'required|integer',
                'sexo' => 'required|string',
                'peso' => 'required|integer',
                'talla' => 'required|integer',
                'pla_canguro' => 'required|string',
                'ips_canguro' => 'nullable|string',
            ]);

            if (!isset($validatedData['id_usuario'])) {
                return response()->json([
                    'estado' => 'Error',
                    'mensaje' => 'El campo id_usuario es requerido'
                ], 400); 
            }

            $datosRecienNacido = DatosRecienNacido::where('cod_recien', $id)
                ->where('id_usuario', $validatedData['id_usuario'])
                ->firstOrFail();

            $datosRecienNacido->update($validatedData);

            return response()->json([
                'estado' => 'Ok',
                'mensaje' => 'Registro actualizado correctamente',
                'data' => $datosRecienNacido
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Registro de recién nacido no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Error al actualizar el registro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    
    public function destroy($id)
    {
        $datosRecienNacido = DatosRecienNacido::find($id);
        
        if (!$datosRecienNacido) {
            return response()->json(['estado' => 'Error', 'mensaje' => 'Registro no encontrado'], 404);
        }

        $datosRecienNacido->delete();
        return response()->json(['estado' => 'Ok', 'mensaje' => 'Registro eliminado correctamente']);
    }
}
