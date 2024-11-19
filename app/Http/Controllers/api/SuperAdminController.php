<?php

namespace App\Http\Controllers\API;

use App\Mail\WelcomeSuperAdminMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuperAdmin;
use App\Models\User;


class SuperAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $superAdmin = SuperAdmin::orderBy('id_superadmin', 'desc')->get();

        return [
            'estado' => 'Ok',
            'superAdmin' => $superAdmin
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
        DB::beginTransaction();  // Inicia una transacción para garantizar que todo se complete o se deshaga

        try {
            /*$request->validate([
                'nom_superadmin' => 'required|string|max:255',
                'ape_superadmin' => 'required|string|max:255',
                'email_superadmin' => 'required|email|max:255|unique:superadmin,email_superadmin',
                'tel_superadmin' => 'required|string|max:20',
                'documento_superadmin' => 'required|string|max:20|unique:superadmin,documento_superadmin',
            ]);*/

            $authUser = Auth::user();

            if (!$authUser) {
                return response()->json([
                    'error' => 'No autorizado. Debes estar autenticado para crear un SuperAdmin.'
                ], 401);
            }

            // Verificar si el usuario autenticado es un SuperAdmin
            if ($authUser->rol_id !== 1) {
                return response()->json([
                    'error' => 'No autorizado. Solo un SuperAdmin puede crear otros SuperAdmins.'
                ], 403);
            }

            // Crear el SuperAdmin
            $superAdmin = new SuperAdmin();
            $superAdmin->nom_superadmin = $request->nom_superadmin;
            $superAdmin->ape_superadmin = $request->ape_superadmin;
            $superAdmin->email_superadmin = $request->email_superadmin;
            $superAdmin->tel_superadmin = $request->tel_superadmin;
            $superAdmin->cod_documento = $request->cod_documento;
            $superAdmin->documento_superadmin = $request->documento_superadmin;

            if ($superAdmin->save()) {
                // Generar una contraseña aleatoria
                $contrasenaGenerada = $this->generarContrasena($superAdmin->nom_superadmin, $superAdmin->ape_superadmin);

                // Crear el User asociado
                $user = new User();
                $user->name = $superAdmin->nom_superadmin . ' ' . $superAdmin->ape_superadmin;
                $user->documento = $superAdmin->documento_superadmin;
                $user->password = bcrypt($contrasenaGenerada);
                $user->rol_id = 1; // Asignar el rol de SuperAdmin

                // Asociar el SuperAdmin al User
                $superAdmin->user()->save($user);

                // Enviar un correo de bienvenida con la contraseña generada (opcional)
                Mail::to($superAdmin->email_superadmin)->send(new WelcomeSuperAdminMail($superAdmin, $contrasenaGenerada));
            }

            // Confirmar la transacción si todo salió bien
            DB::commit();

            return response()->json(['message' => 'SuperAdmin creado correctamente'], 201);
        } catch (\Exception $e) {
            // Deshacer la transacción si ocurre un error
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
    public function show($id_superadmin)
    {
        try {
            $superAdmin = SuperAdmin::findOrFail($id_superadmin);

            return response()->json([
                'estado' => 'Ok',
                'superAdmin' => $superAdmin
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'SuperAdmin no encontrado',
                'exception_message' => $e->getMessage(),
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
    public function update(Request $request, $id_superadmin)
    {
        try {
            $superAdmin = SuperAdmin::findOrFail($id_superadmin);

            $superAdmin->nom_superadmin = $request->nom_superadmin ?? $superAdmin->nom_superadmin;
            $superAdmin->ape_superadmin = $request->ape_superadmin ?? $superAdmin->ape_superadmin;
            $superAdmin->email_superadmin = $request->email_superadmin ?? $superAdmin->email_superadmin;
            $superAdmin->tel_superadmin = $request->tel_superadmin ?? $superAdmin->tel_superadmin;
            $superAdmin->cod_documento = $request->cod_documento ?? $superAdmin->cod_documento;
            $superAdmin->documento_superadmin = $request->documento_superadmin ?? $superAdmin->documento_superadmin;

            if ($superAdmin->save()) {
                return response()->json(['message' => 'SuperAdmin actualizado correctamente'], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error al actualizar el SuperAdmin',
                'exception_message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_superadmin)
    {
        try {
            $superAdmin = SuperAdmin::findOrFail($id_superadmin);

            // Actualizar el estado del User asociado
            $user = $superAdmin->user;
            if ($user) {
                $user->estado = 0; // Desactivar el usuario
                $user->save();

                return response()->json(['message' => 'SuperAdmin desactivado correctamente'], 200);
            } else {
                return response()->json(['error' => 'Usuario asociado no encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error al desactivar el SuperAdmin',
                'exception_message' => $e->getMessage(),
            ], 500);
        }
    }
}
