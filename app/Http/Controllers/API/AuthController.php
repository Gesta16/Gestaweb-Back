<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SuperAdmin;
use App\Models\Admin;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Asegúrate de incluir esta clase

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validar las credenciales proporcionadas
        $request->validate([
            'documento' => 'required',
            'password' => 'required',
        ]);

        $documento = $request->input('documento');
        $password = $request->input('password');

        // Buscar el usuario por documento
        $user = User::where('documento', $documento)->first();

        // Si no se encuentra el usuario
        if (!$user) {
            return response()->json([
                'message' => 'El documento proporcionado no coincide con ningún usuario registrado.',
            ], 404);
        }

        // Verificar si la contraseña es incorrecta
        if (!Hash::check($password, $user->password)) {
            return response()->json([
                'message' => 'La contraseña es incorrecta.',
            ], 401);
        }

        // Verificar si tiene un modelo relacionado (polimórfico)
        $relatedModel = $user->userable;
        if (!$relatedModel) {
            return response()->json([
                'message' => 'Usuario no tiene un modelo relacionado válido.',
            ], 401);
        }

        // Recuperar el valor de autorización del modelo relacionado (usuario)
        $autorizacion = $relatedModel->autorizacion; // Suponiendo que el campo es `autorizacion`

        // Imprimir en la consola el valor de autorizacion (para fines de depuración)
        Log::info('Valor de autorizacion: ' . $autorizacion);

        // Si la autorización es 0, puedes permitirle continuar
        if ($autorizacion == 0) {
            // Imprimir en la consola que está en el estado inicial
            Log::info('El usuario tiene autorización en 0, permitiendo el ingreso.');
        }

        // Si todas las validaciones pasan, generar el token de acceso
        try {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->accessToken;

            return response()->json([
                'user' => $user,
                'role' => $user->rol->nombre_rol,
                'related_model' => $relatedModel,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                'message'=> 'Ingreso exitoso'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al generar el token de acceso. Intente nuevamente más tarde.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
