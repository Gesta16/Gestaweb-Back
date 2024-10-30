<?php

namespace App\Http\Controllers\API;

use App\Mail\WelcomeSuperAdminMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\ProcesoGestativo;
use App\Models\User;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = Usuario::orderBy('id_usuario', 'desc')->get();

        return response()->json([
            'estado' => 'Ok',
            'usuarios' => $usuarios
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction(); // Inicia la transacción
    
        try {
            /*$request->validate([
                'id_usuario' => 'required|string|max:255',
                'nom_usuario' => 'required|string|max:255',
                'ape_usuario' => 'required|string|max:255',
                'email_usuario' => 'required|email|max:255|unique:usuarios,email_usuario',
                'tel_usuario' => 'required|string|max:20',
                'cel_usuario' => 'required|string|max:20',
                'dir_usuario' => 'nullable|string|max:255',
                'fec_nacimiento' => 'required|date',
                'edad_usuario' => 'required|integer',
                'cod_documento' => 'required|string|max:20',
                'fec_diag_usuario' => 'nullable|date',
                'fec_ingreso' => 'required|date',
                'cod_depxips' => 'required|string|max:20',
                'cod_departamento' => 'required|string|max:20',
                'cod_ips' => 'required|string|max:20',
                'cod_poblacion' => 'required|string|max:20',
            ]);*/
    
            $authUser = Auth::user();
    
            if (!$authUser) {
                return response()->json([
                    'error' => 'No autorizado. Debes estar autenticado para crear un usuario.'  
                ], 401);
            }
            
            // Crear el Usuario
            $usuario = new Usuario();
            $usuario->id_usuario = $request->id_usuario;
            $usuario->nom_usuario = $request->nom_usuario;
            $usuario->ape_usuario = $request->ape_usuario;
            $usuario->email_usuario = $request->email_usuario;
            $usuario->tel_usuario = $request->tel_usuario;
            $usuario->cel_usuario = $request->cel_usuario;
            $usuario->dir_usuario = $request->dir_usuario;
            $usuario->fec_nacimiento = $request->fec_nacimiento;
            $usuario->edad_usuario = $request->edad_usuario;
            $usuario->cod_documento = $request->cod_documento;
            $usuario->documento_usuario = $request->documento_usuario;
            $usuario->fec_diag_usuario = $request->fec_diag_usuario;
            $usuario->fec_ingreso = $request->fec_ingreso;
            $usuario->cod_departamento = $request->cod_departamento;
            $usuario->cod_municipio = $request->cod_municipio;
            $usuario->cod_ips = $request->cod_ips;
            $usuario->cod_poblacion = $request->cod_poblacion;
    
            if ($usuario->save()) {
                // Generar una contraseña aleatoria
                $contrasenaGenerada = $this->generarContrasena($usuario->nom_usuario, $usuario->ape_usuario);
    
                // Crear el User asociado
                $user = new User();
                $user->name = $usuario->nom_usuario . ' ' . $usuario->ape_usuario;
                $user->documento = $usuario->documento_usuario;
                $user->password = bcrypt($contrasenaGenerada); // Usa la contraseña generada
                $user->rol_id = 4; // Asignar el rol de Usuario
    
                // Asociar el Usuario al User
                $usuario->user()->save($user);
    
                // Enviar email de bienvenida (descomentar si tienes configurado el correo)
                // Mail::to($usuario->email_usuario)->send(new WelcomeUserMail($usuario, $contrasenaGenerada));
            }
    
            DB::commit(); // Confirmar la transacción
    
            return response()->json(['message' => 'Usuario creado correctamente'], 201);
    
        } catch (\Exception $e) {
            DB::rollBack(); // Deshacer la transacción en caso de error
    
            return response()->json([
                'error' => 'Ocurrió un error interno',
                'exception_message' => $e->getMessage(),
                'exception_line' => $e->getLine(),
                'exception_file' => $e->getFile(),
            ], 500);
        }
    }
    
    public function crearProcesoGestativo(Request $request, $usuarioId)
    {
        $authUser = Auth::user();
    
        if (!$authUser) {
            return response()->json([
                'error' => 'No autorizado. Debes estar autenticado.'  
            ], 401);
        }
    
        $usuario = Usuario::findOrFail($usuarioId);
    
        $procesoExistente = $usuario->procesosGestativos()
            ->where('estado', '!=', 0)
            ->exists(); 
    
        if ($procesoExistente) {
            return response()->json([
                'error' => 'No se puede crear otro registro. Existen procesos gestativos anteriores que no están en estado 0.'
            ], 400); 
        }
    
        $numProceso = $usuario->procesosGestativos()->count();
    
        if ($numProceso == 0) {
            $numProceso = 1; 
        } else {
            $numProceso = $usuario->procesosGestativos()->max('num_proceso') + 1;
        }
    
        $procesoGestativo = new ProcesoGestativo();
        $procesoGestativo->id_usuario = $usuarioId;
        $procesoGestativo->estado = true;
        $procesoGestativo->num_proceso = $numProceso;
        $procesoGestativo->save();
    
        return response()->json([
            'message' => 'Proceso gestativo creado con éxito.',
            'proceso_gestativo' => $procesoGestativo,
        ], 201);
    }
    

    public function contarProcesosGestativos($usuarioId)
    {
        $authUser = Auth::user();

        if (!$authUser) {
            return response()->json([
                'error' => 'No autorizado. Debes estar autenticado.'  
            ], 401);
        }

        $usuario = Usuario::findOrFail($usuarioId);

        $numeroDeProcesos = $usuario->procesosGestativos()->count();

        return response()->json([
            'usuario_id' => $usuario->id,
            'numero_de_procesos_gestativos' => $numeroDeProcesos,
        ], 200);
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
        $usuario = Usuario::find($id);
    
        if ($usuario) {
            return response()->json([
                'estado' => 'Ok',
                'usuario' => $usuario
            ], 200);
        } else {
            return response()->json([
                'error' => 'Usuario no encontrado'
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

            $authUser = Auth::user();
    
            if (!$authUser) {
                return response()->json([
                    'error' => 'No autorizado. Debes estar autenticado para crear un usuario.'  
                ], 401);
            }
    
            // Verificar si el usuario autenticado es un Operador
            if ($authUser->rol_id !== 1 && $authUser->rol_id !== 3) {
                return response()->json([
                    'error' => 'No autorizado. Solo un Operador (rol 3) o Administrador (rol 1) puede crear un usuario.'
                ], 403);
            }
            
            $usuario = Usuario::find($id);

            if ($usuario) {
                $usuario->id_usuario = $request->id_usuario;
                $usuario->nom_usuario = $request->nom_usuario;
                $usuario->ape_usuario = $request->ape_usuario;
                $usuario->email_usuario = $request->email_usuario;
                $usuario->tel_usuario = $request->tel_usuario;
                $usuario->cel_usuario = $request->cel_usuario;
                $usuario->dir_usuario = $request->dir_usuario;
                $usuario->fec_nacimiento = $request->fec_nacimiento;
                $usuario->edad_usuario = $request->edad_usuario;
                $usuario->cod_documento = $request->cod_documento;
                $usuario->documento_usuario = $request->documento_usuario;
                $usuario->fec_diag_usuario = $request->fec_diag_usuario;
                $usuario->fec_ingreso = $request->fec_ingreso;
                $usuario->cod_departamento = $request->cod_departamento;
                $usuario->cod_municipio = $request->cod_municipio;
                $usuario->cod_ips = $request->cod_ips;
                $usuario->cod_poblacion = $request->cod_poblacion;

                if ($usuario->save()) {
                    return response()->json(['message' => 'Usuario actualizado correctamente'], 200);
                } else {
                    return response()->json(['error' => 'No se pudo actualizar el usuario'], 500);
                }
            } else {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
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
            // Buscar el usuario utilizando la clave primaria correcta
            $usuario = Usuario::find($id);

            if ($usuario) {
                // Intentar eliminar el usuario
                if ($usuario->delete()) {
                    return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
                } else {
                    return response()->json(['error' => 'No se pudo eliminar el usuario'], 500);
                }
            } else {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }
        } catch (\Exception $e) {
            // Manejo de excepciones y devolución de detalles para depuración
            return response()->json([
                'error' => 'Ocurrió un error interno',
                'exception_message' => $e->getMessage(),
                'exception_line' => $e->getLine(),
                'exception_file' => $e->getFile(),
            ], 500);
        }
    }
}
