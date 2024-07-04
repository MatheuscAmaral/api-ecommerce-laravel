<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {
        try {
            $users = User::all();    

            return response()->json(['users' => $users]);
        }

        catch (\Exception $e) {
            return response()->json(['message' => 'Operação realizada com sucesso', 'error'=> $e->getCode()]);
        }

    }


    public function verifyIfExists($cpf, $email) {
        $validator = Validator::make(
            compact('cpf', 'email'),
            [
                'cpf' => 'required|min:11|max:11|string|unique:users',
                'email' => 'required|max:150|string|unique:users',
            ], 
            [
                'cpf.unique' => 'Este cpf já foi cadastrado!',
                'cpf.min' => 'O cpf precisa ter no mínimo 11 dígitos!',
                'cpf.max' => 'O cpf pode ter no maxímo 11 dígitos!',
                'email.unique'=> 'Este e-mail já foi cadastrado!',
                'email.max'=> 'O e-mail pode ter no máximo 150 caracteres!',
            ]
        );
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        return response()->json([
            'user' => false
        ]);
    }

    public function show ($id) {
        try {
            $user = User::where([
                "id" => $id
            ])->first();  

            return response()->json([$user], 200);
        }

        catch (\Exception $e) {
            return response()->json(["message"=> "","error"=> $e->getCode()]);
        }
    }

    
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            "email" => "required|string|max:255|unique:users",
            "cpf" => "required|string|min:11|max:11|unique:users",
            "cep" => "required|string|min:8|max:8",
            "rua" => "required|string|max:255",
            "numero" => "required|integer|",
            "bairro" => "required|string|max:50",
            "cidade" => "required|string|max:50",
            "uf" => "required|string|min:2|max:2",
            "status" => "required|integer|min:1|max:1",
            "password" => "required|string|min:6",
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    

        $user = User::create([
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            "cpf" => $request->input('cpf'),
            "cep" => $request->input('cep'),
            "rua" => $request->input('rua'),
            "numero" => $request->input('numero'),
            "bairro" => $request->input('bairro'),
            "cidade" => $request->input('cidade'),
            "uf" => $request->input('uf'),
            'status'=> $request->input('status'),
            "password" => bcrypt($request->input('password')),
        ]);
    
        return response()->json($user);
    }

    // public function destroy ($id) {
    //     $user = User::findOrFail($id);

    //     try {
    //         $user->delete();
    //     }

    //     catch (\Exception $e) {
    //         return response()->json(['errors'=> $e->getMessage()]);
    //     }

    //     return response()->json($user, 200);    
    // }

    public function update (Request $request, $id) {
        $user = User::findOrFail($id);

        try {
            $user->update($request->all());
        }

        catch (\Exception $e) {
            return response()->json(['errors'=> $e->getMessage()]);
        }

        return response()->json($user,200); 
    }
    public function updatePassword(Request $request, $id, $oldPass) {
        $user = User::findOrFail($id);
    
        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado.'], 404);
        }
    
        if (!Hash::check($oldPass, $user->password)) {
            return response()->json(['error' => 'Senha antiga incorreta.'], 401);
        }

        $newPasswordHash = bcrypt($request->input('password'));
    
        if (Hash::check($request->input('password'), $user->password)) {
            return response()->json(["error" => 'A nova senha não pode ser igual à anterior!'], 401);
        }
        
        $user->update([
            'password' => $newPasswordHash
        ]);
    
        return response()->json($user);
    }
    
    
    
}
