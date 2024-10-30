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
        } elseif ($usuario->rol_id == 2) {
            $totalOperadores = Operador::where('cod_ips', $codIps)->count();
            $totalAdministradores = Admin::where('cod_ips', $codIps)->count();
            $totalUsuarios = Usuario::where('cod_ips', $codIps)->count();
        }

        return response()->json([
            'total_ips' => $totalIps,
            'total_operadores' => $totalOperadores,
            'total_administradores' => $totalAdministradores,
            'total_usuarios' => $totalUsuarios,
        ]);
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



}
