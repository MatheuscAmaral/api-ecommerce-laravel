<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserAdm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdmController extends Controller
{

    public function index() {
        $users = UserAdm::all();

        return response()->json($users);   
    }

    public function show ($id)  {
        $user = UserAdm::where([
           "id" => $id
        ])->first();

        return response()->json($user);
    }

    public function login(Request $request)
    {
        $compactData = $request->only('user', 'password');
    
        $validator = Validator::make($compactData, [
            'user' => 'required|string',
            'password' => 'required|string|min:6'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
    
        $user = UserAdm::where('user', $request->input('user'))->first();
    
        if (!$user || !password_verify($request->input('password'), $user->password)) {
            return response()->json(['message' => 'Credenciais inválidas']);
        }
    
        return response()->json(['user' => $user]);
    }

    public function store (Request $request) {
        $user = new UserAdm;

        $verifyUser = UserAdm::where([
            'user' => $request->input('user')
        ])->first();

        if($verifyUser) {
            return response()->json(["message" => "O nome de usuário já existe!"]);
        }

        try {
            $user->user = $request->input('user');
            $user->password = bcrypt($request->input('password'));
            $user->nivel = $request->input('nivel');
            $user->status = $request->input('status');

            $user->save();
            return response()->json($user);
        }

        catch (\Exception $e) {
            return response()->json(['message'=> $e->getMessage()]);
        }
    }

    public function destroy ($id) {
        $user = UserAdm::findOrFail($id);

        $user->delete();

        return response()->json($user);
    }

    public function update (Request $request, $id) {
        $user = UserAdm::findOrFail($id);

        $user->update($request->all());

        return response()->json($user); 
    }
}
