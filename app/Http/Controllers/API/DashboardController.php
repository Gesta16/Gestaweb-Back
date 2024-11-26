<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConsultasUsuario;
use App\Models\Ips;
use App\Models\Admin;
use App\Models\Operador;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{

    public function CalendarioUsuario()
    {
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado para ver el calendario'
            ], 401);
        }

        $idUsuario = auth()->user()->userable_id;

        try {
            $consultas = ConsultasUsuario::where('id_usuario', $idUsuario)
                ->select('fecha', 'nombre_consulta')
                ->get();

            if ($consultas->isEmpty()) {
                return response()->json([
                    'estado' => 'Ok',
                    'mensaje' => 'No se encontraron consultas para el usuario',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'estado' => 'Ok',
                'mensaje' => 'Consultas recuperadas correctamente',
                'data' => $consultas
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al recuperar las consultas del usuario:', [
                'mensaje' => $e->getMessage(),
                'id_usuario' => $idUsuario,
            ]);

            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Error al recuperar las consultas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function contarRegistros()
    {
        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado'
            ], 401);
        }

        $usuario = auth()->user();
        $totalIps = 0;

        if ($usuario && $usuario->userable) {
            $codIps = $usuario->userable->cod_ips;
        }

        if ($usuario->rol_id == 1) {
            $totalIps = Ips::count();
            $totalOperadores = Operador::count();
            $totalAdministradores = Admin::count();
            $totalUsuarios = Usuario::count();
            return response()->json([
                'total_ips' => $totalIps,
                'total_operadores' => $totalOperadores,
                'total_administradores' => $totalAdministradores,
                'total_usuarios' => $totalUsuarios,
            ]);
        } elseif ($usuario->rol_id == 2) {
            $totalOperadores = Operador::where('cod_ips', $codIps)->count();
            $totalAdministradores = Admin::where('cod_ips', $codIps)->count();
            $totalUsuarios = Usuario::where('cod_ips', $codIps)->count();
            return response()->json([
                'total_ips' => $totalIps,
                'total_operadores' => $totalOperadores,
                'total_administradores' => $totalAdministradores,
                'total_usuarios' => $totalUsuarios,
            ]);
        }elseif($usuario->rol_id == 3){
            $totalUsuarios = Usuario::where('cod_ips', $codIps)->count();
            return response()->json([
                'total_usuarios' => $totalUsuarios,
            ]);
        }

       
    }

    public function conteoUsuariosPorIps()
    {

        if (!auth()->check()) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'Debes estar autenticado'
            ], 401);
        }

        $conteoPorIps = Usuario::select('usuario.cod_ips', 'ips.nom_ips', DB::raw('count(*) as total'))
            ->join('ips', 'usuario.cod_ips', '=', 'ips.cod_ips')
            ->groupBy('usuario.cod_ips', 'ips.nom_ips')
            ->get();

        // Retornar los datos en formato JSON
        return response()->json($conteoPorIps);
    }


    public function getProporcionTamizajeSifilis()
    {
        // Proporción del I Trimestre
        $proporcionI = DB::table('laboratorio_i_trimestre')
            ->selectRaw('COUNT(*) as total_gestantes')
            ->selectRaw('SUM(CASE WHEN reali_prueb_trepo_rapid_sifilis = 1 THEN 1 ELSE 0 END) as tamizaje_realizado')
            ->selectRaw('ROUND((SUM(CASE WHEN reali_prueb_trepo_rapid_sifilis = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as proporcion_tamizaje')
            ->first();

        // Proporción del II Trimestre
        $proporcionII = DB::table('laboratorio_ii_trimestre')
            ->selectRaw('COUNT(*) as total_gestantes')
            ->selectRaw('SUM(CASE WHEN real_prueb_trep_rap_sifilis = 1 THEN 1 ELSE 0 END) as tamizaje_realizado')
            ->selectRaw('ROUND((SUM(CASE WHEN real_prueb_trep_rap_sifilis = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as proporcion_tamizaje')
            ->first();

        // Proporción del III Trimestre
        $proporcionIII = DB::table('laboratorio_iii_trimestre')
            ->selectRaw('COUNT(*) as total_gestantes')
            ->selectRaw('SUM(CASE WHEN reali_prueb_trepo_rapi_sifilis = 1 THEN 1 ELSE 0 END) as tamizaje_realizado')
            ->selectRaw('ROUND((SUM(CASE WHEN reali_prueb_trepo_rapi_sifilis = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as proporcion_tamizaje')
            ->first();

        // Compilando los resultados
        $proporciones = [
            'I Trimestre' => $proporcionI,
            'II Trimestre' => $proporcionII,
            'III Trimestre' => $proporcionIII,
        ];

        return response()->json($proporciones);
    }


    public function getCoverageData(Request $request)
    {

        $role = $request->input('role'); // Rol del usuario (admin, operador)
        $cod_ips = $request->input('cod_ips'); // Código de la IPS del usuario

        $query = DB::table('seguimientos_complementarios')
            ->selectRaw('
            SUM(asistio_nutricionista) AS total_Nutrición,
            SUM(asistio_ginecologia) AS total_Ginecología,
            SUM(asistio_psicologia) AS total_Psicología,
            SUM(asistio_odontologia) AS total_Odontología
        ');
        if ($role === 'admin') {
            // Filtrar por IPS del admin
            $query->where('id_admin', $cod_ips);
        } elseif ($role === 'operador') {
            // Filtrar por IPS del operador
            $query->where('id_operador', $cod_ips);
        } elseif ($role === 'superadmin') {
            return $query->first();
        }

        // Obtener los resultados
        $result = $query->first();

        // Retornar los datos en JSON
        return response()->json($result);
    }

    //Tasa de mortalidad neonatal temprana
    public function getNeonatalMortalityRate(Request $request)
    {
        $role = $request->input('role'); // Rol del usuario (admin, operador)
        $cod_ips = $request->input('cod_ips'); // Código de la IPS del usuario

        // Base de la consulta
        $query = DB::table('mortalidad_preparto as mp')
            ->join('mortalidad_perinatal as mpn', 'mp.cod_mortalidad', '=', 'mpn.cod_mortalidad')
            ->selectRaw("
            DATE_FORMAT(mp.fec_defuncion, '%Y-%m') AS mes, 
            COUNT(*) AS total_neonatal_temprana
        ")
            ->where('mpn.cla_muerte', 'Neonatal temprana')
            ->groupBy(DB::raw("DATE_FORMAT(mp.fec_defuncion, '%Y-%m')"));

        // Filtrar según el rol del usuario
        if ($role === 'operador') {
            $query->where('mp.id_operador', $cod_ips);
        } elseif ($role === 'admin') {
            $query->where('mp.id_admin', $cod_ips);
        }

        // Obtener los datos agrupados por mes
        $data = $query->get();

        return response()->json($data);
    }



    //Proporcion de mujeres con consulta a asesoria IVE
    public function getIveProportion(Request $request)
    {
        $role = $request->input('role'); // Rol del usuario (admin, operador, superadmin)
        $cod_ips = $request->input('cod_ips'); // Código de la IPS del usuario

        // Base de la consulta
        $query = DB::table('control_prenatal')
            ->selectRaw("
            DATE_FORMAT(fec_control, '%Y-%m') AS mes, 
            COUNT(*) AS total_mujeres, 
            SUM(asis_asesoria_ive) AS mujeres_asesoria_ive, 
            (SUM(asis_asesoria_ive) / COUNT(*)) * 100 AS proporcion_ive
        ");

        // Filtrar según el rol del usuario
        if ($role === 'operador') {
            $query->where('id_operador', $cod_ips); // Filtrar por operador
        } elseif ($role === 'admin') {
            $query->where('id_admin', $cod_ips); // Filtrar por administrador
        }

        // Agrupar por mes
        $query->groupBy(DB::raw("DATE_FORMAT(fec_control, '%Y-%m')"));

        // Obtener los resultados
        return $query->get();
    }
}
