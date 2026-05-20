<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'username' => 'required|email',
            'password' => 'required'
        ]);

        $u = User::where('email', $request->get('username'))->first();
        if(!$u){
            return response()->json(['ko' => 'user not found'], 401);
        }

        if(\Hash::check($request->get('password'), $u->password)==FALSE){
            return response()->json(['ko' => 'user not found'], 401);
        }

        $token = $u->createToken('auth_token')->plainTextToken;

        return response()->json(['ok' => 'user found', 'token' => $token], 200);
    }
}
