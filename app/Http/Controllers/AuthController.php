<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            "username" => "required|email",
            "password" => "required"
        ]);

        try{
            $user = User::where("email", $request->email)->first();

            if(!$user || !\Hash::check($request->password, $user->password)){
                return response()->json([
                    "message" => "Invalid credentials"
                ], 401);
            }

            $token = $user->createToken("auth_token")->plainTextToken;

            return response()->json([
                "access_token" => $token,
                "token_type" => "Bearer"
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                "message" => "User not found"
            ], 404);
        }
    }
}
