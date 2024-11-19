<?php

namespace App\Http\Controllers\API;

use App\Mail\WelcomeSuperAdminMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\WelcomeAdminMail;
use Illuminate\Http\Request;
use App\Models\Ips;
use App\Models\User;
use App\Models\Admin;


class IpsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Ips = Ips::orderBy('cod_ips','desc')->get();

        return [
            'estado'=>'Ok',
            'ips'=>$Ips
        ];    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $authUser = Auth::user();
    
            if (!$authUser) {
                return response()->json([
                    'error' => 'No autorizado. Debes estar autenticado para crear una Ips.'
                ], 401);
            }
    
            // Verificar si el usuario autenticado es un SuperAdmin
            if ($authUser->rol_id !== 1) {
                return response()->json([
                    'error' => 'No autorizado. Solo SuperAdmin pueden crear Ips.'
                ], 403);
            }
    
            // Iniciar la transacción
            DB::beginTransaction();
    
            // Crear la IPS
            $ips = new Ips();
            $ips->cod_ips = $request->cod_ips;
            $ips->cod_regimen = $request->cod_regimen;
            $ips->cod_departamento = $request->cod_departamento;
            $ips->cod_municipio = $request->cod_municipio;
            $ips->nom_ips = $request->nom_ips;
            $ips->dir_ips = $request->dir_ips;
            $ips->tel_ips = $request->tel_ips;
            $ips->email_ips = $request->email_ips;
            $ips->nit_ips = $request->nit_ips;
    
            if (!$ips->save()) {
                throw new \Exception('No se pudo crear la IPS');
            }
    
            // Crear el admin
            $admin = new Admin();
            $admin->cod_ips = $ips->cod_ips; // Asociar el admin a la IPS recién creada
            $admin->nom_admin = $request->nom_ips;
            $admin->ape_admin = ' ';
            $admin->cod_documento = 10;
            $admin->cod_departamento = $request->cod_departamento;
            $admin->cod_municipio = $request->cod_municipio;
            $admin->email_admin = $request->email_ips;
            $admin->tel_admin = $request->tel_ips;
            $admin->documento_admin = $request->nit_ips;
    
            if (!$admin->save()) {
                throw new \Exception('No se pudo crear el administrador');
            }
    
            // Generar una contraseña aleatoria
            $contrasenaGenerada = $this->generarContrasena($admin->nom_admin, $admin->ape_admin);
    
            // Crear el User asociado al admin
            $user = new User();
            $user->name = $admin->nom_admin;
            $user->documento = $admin->documento_admin;
            $user->password = bcrypt($contrasenaGenerada);
            $user->rol_id = 2; // Asignar el rol de admin
    
            // Asociar el admin al User
            if (!$admin->user()->save($user)) {
                throw new \Exception('No se pudo crear el usuario');
            }
    
            // Enviar email de bienvenida
            Mail::to($admin->email_admin)->send(new WelcomeAdminMail($admin, $contrasenaGenerada));
    
            // Si todas las operaciones fueron exitosas, confirmar la transacción
            DB::commit();
    
            return response()->json(['message' => 'IPS y admin creados correctamente'], 201);
    
        } catch (\Exception $e) {
            // Si ocurre un error, revertir la transacción
            DB::rollBack();
    
            return response()->json([
                'error' => 'Ocurrió un error interno',
                'exception_message' => $e->getMessage(),
                'exception_line' => $e->getLine(),
                'exception_file' => $e->getFile(),
            ], 500);
        }
    }
    

    function generarContrasena($nombre, $apellido)
    {
        // Obtener las iniciales del nombre y apellido
        $inicialNombre = strtoupper(substr($nombre, 0, 4)); // Primera letra del nombre en mayúscula

        // Generar un número aleatorio de 4 dígitos
        $numeroAleatorio = rand(1000, 9999);

        // Combinar las iniciales y el número aleatorio
        $contrasena = $inicialNombre  . $numeroAleatorio;

        return $contrasena;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ips = Ips::find($id);
    
        if ($ips) {
            return response()->json([
                'estado' => 'Ok',
                'ips' => $ips
            ], 200);
        } else {
            return response()->json([
                'error' => 'IPS no encontrada'
            ], 404);
        }
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
        try {
            $ips = Ips::find($id);

            if ($ips) {
                $ips->cod_regimen = $request->cod_regimen;
                $ips->nom_ips = $request->nom_ips;
                $ips->cod_departamento = $request->cod_departamento;
                $ips->cod_municipio = $request->cod_municipio;
                $ips->dir_ips = $request->dir_ips;
                $ips->tel_ips = $request->tel_ips;
                $ips->email_ips = $request->email_ips;
                $ips->nit_ips = $request->nit_ips;
                
                if ($ips->save()) {
                        return response()->json(['message' => 'IPS actualizada correctamente'], 200);
                    } else {
                        return response()->json(['error' => 'No se pudo actualizar la IPS'], 500);
                }
            } else {
                return response()->json(['error' => 'IPS no encontrada'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error interno',
                'exception_message' => $e->getMessage(),
                'exception_line' => $e->getLine(),
                'exception_file' => $e->getFile(),
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $ips = Ips::find($id);

            if ($ips) {
                if ($ips->delete()) {
                    return response()->json(['message' => 'IPS eliminada correctamente'], 200);
                } else {
                    return response()->json(['error' => 'No se pudo eliminar la IPS'], 500);
                }
            } else {
                return response()->json(['error' => 'IPS no encontrada'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error interno',
                'exception_message' => $e->getMessage(),
                'exception_line' => $e->getLine(),
                'exception_file' => $e->getFile(),
            ], 500);
        }
    }

}
