<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request)    
    {
        $data = $request->validated();
        FacadesAuth::attempt($data);

        $user = FacadesAuth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(\Illuminate\Http\Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);

    }

    public function register(RegisterUserRequest $request) {
        $data = $request->validated();
        $user = User::create($data);
        // $user ->assignRole('admin');
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token
        ]);
    }

}