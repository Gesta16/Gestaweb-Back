<?php

namespace App\Http\Controllers\API;

use App\Mail\WelcomeOperadorMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operador;
use App\Models\User;
use App\Models\Ips;


class OperadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if($user->rol->nombre_rol == 'superadmin'){
            $operador = Operador::orderBy('id_operador','desc')->get();
        }else if($user->rol->nombre_rol == 'admin'){
            $operador = Operador::where('cod_ips', $user->userable->cod_ips)->get();
        }else{
            return response()->json(['error' => 'No autorizado']);
        }

        if($operador->isEmpty()){
            return response()->json([
                'estado'=>'Sin datos',
                'mensaje'=>'No se encontraron operadores.'
            ]);
        }

        return [
            'estado'=>'Ok',
            'operador'=>$operador
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
        DB::beginTransaction();
    
        try {
            $authUser = Auth::user();
    
            if (!$authUser) {
                return response()->json([
                    'error' => 'No autorizado. Debes estar autenticado para crear un Operador.'
                ], 401);
            }
    
            // Verificar si la IPS existe
            $ips = Ips::find($request->cod_ips);
            if (!$ips) {
                return response()->json([
                    'error' => 'IPS no encontrada.'
                ], 404);
            }
    
            if ($authUser->rol_id == 1) {
                // Si el usuario autenticado es SuperAdmin, puede crear el operador en cualquier IPS
                if (!$request->cod_ips) {
                    return response()->json([
                        'error' => 'El id de la IPS es requerido para SuperAdmin.'
                    ], 400);
                }
            } elseif ($authUser->rol_id == 2) {
                // Si el usuario autenticado es Admin, solo puede crear operadores en la misma IPS
                $authAdmin = $authUser->userable;
                if (!$authAdmin || $authAdmin->ips->cod_ips !== $request->cod_ips) {
                    return response()->json([
                        'error' => 'No autorizado. Solo puedes crear operadores en la misma IPS.'
                    ], 403);
                }
            } else {
                return response()->json([
                    'error' => 'No autorizado. Rol de usuario no válido.'
                ], 403);
            }
    
            // Crear el operador
            $operador = new Operador();
            $operador->id_operador = $request->id_operador;
            $operador->id_admin = $request->id_admin;
            $operador->cod_ips = $request->cod_ips;
            $operador->nom_operador = $request->nom_operador;
            $operador->ape_operador = $request->ape_operador;
            $operador->tel_operador = $request->tel_operador;
            $operador->email_operador = $request->email_operador;
            $operador->cod_departamento = $request->cod_departamento;
            $operador->cod_municipio = $request->cod_municipio;
            $operador->esp_operador = $request->esp_operador;
            $operador->cod_documento = $request->cod_documento;
            $operador->documento_operador = $request->documento_operador;
    
            if ($operador->save()) {

                $contrasenaGenerada = $this->generarContrasena($operador->nom_operador, $operador->ape_operador);

                $user = new User();
                $user->name = $operador->nom_operador . ' ' . $operador->ape_operador;
                $user->documento = $operador->documento_operador;
                $user->password = bcrypt($contrasenaGenerada); 
                $user->rol_id = 3; // Asignar el rol de operador
    
                // Asociar el operador al User
                $operador->user()->save($user);
    
                // Enviar un correo de bienvenida (opcional)
                Mail::to($operador->email_operador)->send(new WelcomeOperadorMail($operador,  $contrasenaGenerada));
            }
    
            // Si todo salió bien, confirmar la transacción
            DB::commit();
    
            return response()->json(['message' => 'Operador creado correctamente'], 201);
    
        } catch (\Exception $e) {
            // Si algo falla, deshacer la transacción
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
        try {
            $operador = Operador::findOrFail($id);
            return response()->json($operador, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Operador no encontrado',
                'exception_message' => $e->getMessage(),
                'exception_line' => $e->getLine(),
                'exception_file' => $e->getFile(),
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
            $operador = Operador::findOrFail($id);
    
            $operador->id_admin = $request->id_admin ?? $operador->id_admin;
            $operador->cod_ips = $request->cod_ips ?? $operador->cod_ips;
            $operador->nom_operador = $request->nom_operador ?? $operador->nom_operador;
            $operador->ape_operador = $request->ape_operador ?? $operador->ape_operador;
            $operador->tel_operador = $request->tel_operador ?? $operador->tel_operador;
            $operador->email_operador = $request->email_operador ?? $operador->email_operador;
            $operador->cod_departamento = $request->cod_departamento;
            $operador->cod_municipio = $request->cod_municipio;
            $operador->esp_operador = $request->esp_operador ?? $operador->esp_operador;
            $operador->cod_documento = $request->cod_documento ?? $operador->cod_documento;
            $operador->documento_operador = $request->documento_operador ?? $operador->documento_operador;

            if($request->has('password')&& !empty($request->password)){
                $user = $operador->user;
                if($user){
                    $user->password = bcrypt($$request->password);
                    $user->save();
                }
            }
            
            
            if ($operador->save()) {
                return response()->json(['message' => 'Operador actualizado correctamente'], 200);
            }
    
            return response()->json(['error' => 'No se pudo actualizar el Operador'], 400);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Operador no encontrado o error interno',
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
            $operador = Operador::findOrFail($id);
    
            if ($operador->delete() && $operador->user()->delete()) {
                return response()->json(['message' => 'Operador eliminado correctamente'], 200);
            }
    
            return response()->json(['error' => 'No se pudo eliminar el Operador'], 400);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Operador no encontrado o error interno',
                'exception_message' => $e->getMessage(),
                'exception_line' => $e->getLine(),
                'exception_file' => $e->getFile(),
            ], 500);
        }
    }
    
}
