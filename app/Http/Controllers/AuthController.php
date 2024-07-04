<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('cpf', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::where('cpf', $request->cpf)->first();

            if($user->status == 0) {
                return response()->json(["message" => "Usuário inativo, contate o suporte!"]);
            }

            return response()->json(["user" => $user]);
        } else {
            return response()->json(['message' => 'Usuário ou senha incorretos!'], 401);
        }
    }
}
