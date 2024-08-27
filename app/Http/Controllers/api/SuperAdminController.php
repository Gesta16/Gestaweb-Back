<?php

namespace App\Http\Controllers\api;

use App\Mail\WelcomeSuperAdminMail;
use Illuminate\Support\Facades\Mail;
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
        $superAdmin = SuperAdmin::orderBy('id_superadmin','desc')->get();

        return [
            'estado'=>'Ok',
            'superAdmin'=>$superAdmin
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
        // Crear el SuperAdmin
        $superAdmin = new SuperAdmin();
        $superAdmin->nom_superadmin = $request->nom_superadmin;
        $superAdmin->ape_superadmin = $request->ape_superadmin;
        $superAdmin->email_superadmin = $request->email_superadmin;
        $superAdmin->tel_superadmin = $request->tel_superadmin;
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

            // Asocia el SuperAdmin al User
            $superAdmin->user()->save($user);

            Mail::to($superAdmin->email_superadmin)->send(new WelcomeSuperAdminMail($superAdmin, $contrasenaGenerada));

        }

        return response()->json(['message' => 'SuperAdmin creado correctamente'], 201);

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

            // Eliminar el SuperAdmin y el User asociado
            if ($superAdmin->user()->delete() && $superAdmin->delete()) {
                return response()->json(['message' => 'SuperAdmin eliminado correctamente'], 200);
            }

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error al eliminar el SuperAdmin',
                'exception_message' => $e->getMessage(),
            ], 500);
        }
    }
}
