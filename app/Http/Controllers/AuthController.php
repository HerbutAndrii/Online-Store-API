<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'User was created successfully',
            'user' => new UserResource($user)
        ]);
    }

    public function login(LoginRequest $request) {
        $user = User::where('email', $request->email)->first();

        if(! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ]);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'access_token' => $token
        ]);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}
