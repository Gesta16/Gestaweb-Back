<?php

namespace App\Http\Controllers\API;

use App\Mail\WelcomeSuperAdminMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
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
        try {

            $authUser = Auth::user();

            if (!$authUser) {
                return response()->json([
                    'error' => 'No autorizado. Debes estar autenticado para crear un usuario.'  
                ], 401);
            }

            // Verificar si el usuario autenticado es un Operador
            if ($authUser->rol_id !== 3) {
                return response()->json([
                    'error' => 'No autorizado. Solo un Operador pueden crear un usuario.'
                ], 403);
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
            $usuario->fec_diag_usuario = $request->fec_diag_usuario;
            $usuario->fec_ingreso = $request->fec_ingreso;
            $usuario->cod_depxips = $request->cod_depxips;
            $usuario->cod_departamento = $request->cod_departamento;
            $usuario->cod_ips = $request->cod_ips;
            $usuario->cod_poblacion = $request->cod_poblacion;

            if ($usuario->save()) {
                // Generar una contraseña aleatoria
                $contrasenaGenerada = $this->generarContrasena($usuario->nom_usuario, $usuario->ape_usuario);

                // Crear el User asociado
                $user = new User();
                $user->name = $usuario->nom_usuario . ' ' . $usuario->ape_usuario;
                $user->documento = $usuario->cel_usuario;
                $user->password = bcrypt('password'); // Asignar una contraseña por defecto
                $user->rol_id = 4; // Asignar el rol de Usuario

                // Asocia el Usuario al User
                $usuario->user()->save($user);

                // Enviar email de bienvenida (descomentar si tienes configurado el correo)
                // Mail::to($usuario->email_usuario)->send(new WelcomeUserMail($usuario, $contrasenaGenerada));
            }

            return response()->json(['message' => 'Usuario creado correctamente'], 201);

        } catch (\Exception $e) {
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            $usuario = Usuario::find($id);

            if ($usuario) {
                $usuario->nom_usuario = $request->nom_usuario;
                $usuario->ape_usuario = $request->ape_usuario;
                $usuario->email_usuario = $request->email_usuario;
                $usuario->tel_usuario = $request->tel_usuario;
                $usuario->cel_usuario = $request->cel_usuario;
                $usuario->dir_usuario = $request->dir_usuario;
                $usuario->fec_nacimiento = $request->fec_nacimiento;
                $usuario->edad_usuario = $request->edad_usuario;
                $usuario->cod_documento = $request->cod_documento;
                $usuario->fec_diag_usuario = $request->fec_diag_usuario;
                $usuario->fec_ingreso = $request->fec_ingreso;
                $usuario->cod_depxips = $request->cod_depxips;
                $usuario->cod_departamento = $request->cod_departamento;
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
