<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);

    }

    public function register(RegisterUserRequest $request) {
        $data = $request->validated();
        $user = User::create($data);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token
        ]);
    }

    public function updateProfile(Request $request)
    {
       $user = $request->user();

       $validatedData = $request->validate([
        "name" => 'nullable|string|max:255',
        "email" => 'nullable|email|unique:users,email,$user->id',
       ]);
       $user->update($validatedData);
       return new UserResource($user);
    }

    public function changePassword(Request $request) 
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Password lama salah.'],
            ]);
        }

        $user->update([
            'password' => Hash::make($validated['new_password'])
        ]);

        return response()->json([
            'message' => 'Password berhasil diubah.'
        ]);
    }

}