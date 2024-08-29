<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SuperAdmin;
use App\Models\Admin;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'documento' => 'required',
        ]);

        $documento = $request->input('documento');

        // Buscar al SuperAdmin por el documento
        $superAdmin = SuperAdmin::where('documento_superadmin', $documento)->first();

        // Si no se encuentra un SuperAdmin, buscar un Admin
        if (!$superAdmin) {
            $admin = Admin::where('documento_admin', $documento)->first();

            if (!$admin) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }

            // Obtener el usuario asociado al Admin
            $user = $admin->user;
            $relatedModel = $admin;
        } else {
            // Obtener el usuario asociado al SuperAdmin
            $user = $superAdmin->user;
            $relatedModel = $superAdmin;
        }

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        } 

        // Crear un token para el usuario
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->accessToken;

        return response()->json([
            'user' => $user,
            'related_model' => $relatedModel,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ]);
    }
}
