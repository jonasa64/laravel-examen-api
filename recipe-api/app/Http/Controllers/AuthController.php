<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request){
       $validatedRequest = $request->validate([
           'name' => 'required|string',
           'email' => 'required|unique:users,email' ,
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'name' => $validatedRequest['name'],
            'email' => $validatedRequest['email'],
            'password' => bcrypt($validatedRequest['password'])
        ]);

        $token = $user->createToken('token')->plainTextToken;

        return \Response::json(['token' => $token, 'user' => $user], 201);
    }

    public function login(Request $request){
        $validatedRequest = $request->validate([
            'email' => 'required|email' ,
            'password' => 'required'
        ]);


        $user = User::where('email', $validatedRequest['email'])->first();

        if(!$user || !Hash::check($validatedRequest['password'], $user->password)){
            return \Response::json(['message' => 'Bad creds'], 401);
        }
        $token = $user->createToken('token')->plainTextToken;

        return \Response::json(['token' => $token, 'user' => $user]);

    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return \Response::json(["data" => "you are now logged out"], 200);
    }

}
