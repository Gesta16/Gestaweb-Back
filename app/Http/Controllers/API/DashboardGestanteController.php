<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RutaPYMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardGestanteController extends Controller
{
    public function getEdadGestacional()
    {

        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Verificar si el usuario tiene el rol 'gestante' (rol 4)
        $user = auth()->user();

        if ($user->rol->id !== 4) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        // Obtener el modelo Usuario relacionado
        $usuario = $user->userable;

        // Obtener la edad gestacional inicial desde la tabla control_prenatal
        $controlPrenatal = $usuario->controlesPrenatales()->latest('created_at')->first();

        if (!$controlPrenatal) {
            return response()->json(['error' => 'No hay datos'], 404);
        }

        $edadGestacionalInicial = $controlPrenatal->edad_gestacional;

        // Obtener los seguimientos mensuales
        $seguimientos = $usuario->seguimientos()
            ->select('fec_consulta', 'edad_gestacional')
            ->orderBy('fec_consulta', 'asc')
            ->get();


        // Formatear los datos de respuesta
        $seguimientosData = $seguimientos->map(function ($seguimiento) {
            return [
                'fecha_consulta' => $seguimiento->fec_consulta,
                'edad_gestacional' => $seguimiento->edad_gestacional,
            ];
        });

        // Respuesta consolidada
        return response()->json([
            'edad_gestacional_inicial' => $edadGestacionalInicial,
            'seguimientos' => $seguimientosData,
        ]);
    }

    public function getControlesPrenatales()
    {

        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Verificar si el usuario tiene el rol 'gestante' (rol 4)
        $user = auth()->user();

        if ($user->rol->id !== 4) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        // Obtener el modelo Usuario relacionado
        $usuario = $user->userable;

        //Conteo de controles prenatales
        $conteoControles = $usuario->controlesPrenatales()->count;

        return response()->json($conteoControles, 200);
    }

    public function getSesionesCurso()
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Verificar si el usuario tiene el rol 'gestante' (rol 4)
        $user = auth()->user();

        if ($user->rol->id !== 4) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        $usuario = $user->userable;

        $seguimientosComplementarios = $usuario->seguimientosComplementarios();

        // Recorrer los seguimientos para obtener el número de sesiones
        $sesionesData = $seguimientosComplementarios->map(function ($seguimiento) {
            return [
                'cod_sesiones' => $seguimiento->cod_sesiones,
                'num_sesiones' => $seguimiento->sesiones ? $seguimiento->sesiones->num_sesiones : null,
            ];
        });

        return response()->json([
            'sesiones' => $sesionesData,
        ]);
    }


    public function getFechaProbableParto()
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Verificar si el usuario tiene el rol 'gestante' (rol 4)
        $user = auth()->user();

        if ($user->rol->id !== 4) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        $usuario = $user->userable;

        $fechaProbableParto = $usuario->controlesPrenatales()->fec_parto;

        return response()->json($fechaProbableParto, 200);
    }

    public function getControlPesoGestante()
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Verificar si el usuario tiene el rol 'gestante' (rol 4)
        $user = auth()->user();

        if ($user->rol->id !== 4) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        $usuario = $user->userable;

        $peso = $usuario->seguimientos();

        $pesoData = $peso->map(function ($data) {
            return [
                'peso' => $data->peso,
                'fecha' => $data->created_at
            ];
        });

        return response()->json([
            'peso' => $pesoData,
        ]);
    }

    public function getControlPresion()
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Verificar si el usuario tiene el rol 'gestante' (rol 4)
        $user = auth()->user();

        if ($user->rol->id !== 4) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        $usuario = $user->userable;

        $tension = $usuario->seguimientos();

        $tensionData = $tension->map(function ($data) {
            return [
                'tension_sis' => $data->ten_arts,
                'tension_dia' => $data->ten_artd,
                'fecha' => $data->created_at
            ];
        });

        return response()->json([
            'tension' => $tensionData
        ]);
    }

    public function getVacunasGestante()
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Verificar si el usuario tiene el rol 'gestante' (rol 4)
        $user = auth()->user();

        if ($user->rol->id !== 4) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        // Obtener el modelo Usuario relacionado
        $usuario = $user->userable;

        // Obtener las vacunas del usuario
        $vacunacion = $usuario->vacunaciones()->first();

        if (!$vacunacion) {
            return response()->json(['error' => 'No vaccination records found'], 404);
        }

        // Crear un arreglo con las vacunas y su estado
        $vacunas = [
            'Primera Dosis COVID-19' => $vacunacion->recib_prim_dosis_covid19,
            'Segunda Dosis COVID-19' => $vacunacion->recib_segu_dosis_covid19,
            'Refuerzo COVID-19' => $vacunacion->recib_refu_covid19,
            'Influenza' => $vacunacion->recib_dosis_influenza,
            'Toxoide Tetánico' => $vacunacion->recib_dosis_tox_tetanico,
            'DPT Acelular' => $vacunacion->recib_dosis_dpt_a_celular,
        ];

        return response()->json(['vacunas' => $vacunas]);
    }


    public function getVacunacionBebe()
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene el rol apropiado
        if ($user->rol->id !== 4) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        // Obtener el modelo Usuario relacionado
        $usuario = $user->userable;

        $rutaVacunacion = RutaPYMS::where('id_usuario', $usuario->id_usuario)->first();


        // Seleccionar las vacunas del bebé
        $vacunasBebe = [
            'BCG' => [
                'aplicada' => $rutaVacunacion->aplico_vacuna_bcg,
                'fecha' => $rutaVacunacion->fec_bcg,
            ],
            'Hepatitis B' => [
                'aplicada' => $rutaVacunacion->aplico_vacuna_hepatitis,
                'fecha' => $rutaVacunacion->fec_hepatitis,
            ],
            'Carnet Entregado' => [
                'realizado' => $rutaVacunacion->reali_entrega_carnet,
                'fecha_entrega' => $rutaVacunacion->fec_entrega,
            ],
        ];

        // Devolver los datos en JSON
        return response()->json($vacunasBebe);
    }

    public function getExamenesITrimestre()
    {

        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene el rol apropiado
        if ($user->rol->id !== 4) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        // Obtener el modelo Usuario relacionado
        $usuario = $user->userable;


        $laboratoriosIData = [
            'completos' => $usuario->laboratorios()->whereNotNull('fecha_resultado')->get()->pluck('nombre'),
            'incompletos' => $usuario->laboratorios()->whereNull('fecha_resultado')->get()->pluck('nombre')
        ];

        return response()->json($laboratoriosIData);
    }
}
