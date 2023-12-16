<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;

class AuthController extends Controller
{
    /**
     * Login the user and generate a token for them.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User logged in successfully',
            'user' => $user,
            'access_token' => $token,
        ]);
    }

    /**
     * Register a new user and generate a token for them.
     */
    public function register(RegistrationRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::create($data);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'user' => $user,
            'access_token' => $token,
        ], 201);
    }

    /**
     * Logout the user and revoke their token.
     */
    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully',
        ]);
    }
}
