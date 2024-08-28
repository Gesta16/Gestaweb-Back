<?php

namespace App\Http\Controllers\API;

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
        // Validar los datos de entrada
        try {
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
                // Crear el User asociado
                $user = new User();
                $user->name = $usuario->nom_usuario . ' ' . $usuario->ape_usuario;
                $user->documento = $usuario->cel_documento;
                $user->password = bcrypt('password'); // Asignar una contraseña por defecto
                $user->rol_id = 4; // Asignar el rol de Usuario

                // Asocia el Usuario al User
                $usuario->user()->save($user);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
