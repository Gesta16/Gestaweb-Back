<?php

namespace App\Http\Controllers\API;

use App\Mail\WelcomeSuperAdminMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Ips;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Admin = Admin::orderBy('id_admin','desc')->get();

        return [
            'estado'=>'Ok',
            'admin'=>$Admin
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
                    'error' => 'No autorizado. Debes estar autenticado para crear un Admin.'
                ], 401);
            }
    
            // Verificar si la IPS existe
            $newAdminIps = Ips::find($request->cod_ips);
            if (!$newAdminIps) {
                return response()->json([
                    'error' => 'IPS no encontrada.'
                ], 404);
            }
    
            // Verificar si el usuario autenticado es un SuperAdmin
            if ($authUser->rol_id !== 1) {
                $authAdmin = $authUser->userable; // Obtén el admin asociado al usuario autenticado
                if (!$authAdmin) {
                    return response()->json([
                        'error' => 'No se pudo encontrar el admin asociado al usuario autenticado.'
                    ], 404);
                }
    
                $authIps = $authAdmin->ips; // Obtén la IPS del admin autenticado
    
                // Verificar si la IPS del nuevo admin coincide con la IPS del admin autenticado
                if ($authIps->cod_ips !== $newAdminIps->cod_ips) {
                    return response()->json([
                        'error' => 'No autorizado. El admin solo puede crear otros admins en la misma IPS.'
                    ], 403);
                }
            }
    
            // Ahora que todas las validaciones han pasado, usamos una transacción
            DB::beginTransaction();
    
            // Crear el admin
            $Admin = new Admin();
            $Admin->cod_ips = $request->cod_ips;
            $Admin->nom_admin = $request->nom_admin;
            $Admin->ape_admin = $request->ape_admin;
            $Admin->email_admin = $request->email_admin;
            $Admin->tel_admin = $request->tel_admin;
            $Admin->cod_documento = $request->cod_documento;
            $Admin->documento_admin = $request->documento_admin;
    
            if ($Admin->save()) {
                // Generar una contraseña aleatoria
                $contrasenaGenerada = $this->generarContrasena($Admin->nom_admin, $Admin->ape_admin);
    
                // Crear el User asociado
                $user = new User();
                $user->name = $Admin->nom_admin . ' ' . $Admin->ape_admin;
                $user->documento = $Admin->documento_admin;
                $user->password = bcrypt($contrasenaGenerada);
                $user->rol_id = 2; // Asignar el rol de admin
    
                // Asocia el admin al User
                $Admin->user()->save($user);
    
                // Enviar el correo solo si todo lo anterior fue exitoso
                Mail::to($Admin->email_admin)->send(new WelcomeSuperAdminMail($Admin, $contrasenaGenerada));
            }
    
            // Si todo fue bien, confirmamos la transacción
            DB::commit();
    
            return response()->json(['message' => 'Admin creado correctamente'], 201);
    
        } catch (\Exception $e) {
            // Si algo falla, revertimos la transacción
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
        $inicialApellido = strtoupper(substr($apellido, 0, 1)); // Primera letra del apellido en mayúscula

        // Generar un número aleatorio de 4 dígitos
        $numeroAleatorio = rand(1000, 9999);

        // Combinar las iniciales y el número aleatorio
        $contrasena = $inicialNombre . $inicialApellido . $numeroAleatorio;

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
        try {
            $admin = Admin::find($id);
    
            if ($admin) {
                return response()->json([
                    'estado' => 'Ok',
                    'admin' => $admin
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Admin no encontrado'
                ], 404);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $admin = Admin::find($id);
    
            if ($admin) {
                // Actualizar todos los campos de una vez
                $admin->update($request->all());
    
                return response()->json([
                    'message' => 'Admin actualizado correctamente',
                    'admin' => $admin
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Admin no encontrado'
                ], 404);
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
            $admin = Admin::find($id);
    
            if ($admin) {
                // Eliminar el admin
                if ($admin->delete() && $admin->user()->delete()) {
                    return response()->json([
                        'message' => 'Admin eliminado correctamente'
                    ], 200);
                } else {
                    return response()->json([
                        'error' => 'No se pudo eliminar el admin'
                    ], 500);
                }
            } else {
                return response()->json([
                    'error' => 'Admin no encontrado'
                ], 404);
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
