<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email_usuario' => 'required|string|email',
        ]);

        $email = $request->input('email_usuario');


        $user = Usuario::where('email_usuario', $email)->first();


        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }


        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->accessToken;


        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ]);
    }
}
