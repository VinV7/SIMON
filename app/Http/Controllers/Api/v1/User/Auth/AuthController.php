<?php

namespace App\Http\Controllers\Api\v1\User\Auth;

// Laravel Imports
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

// Model Imports
use App\Models\User;

// Resource Imports
use App\Http\Resources\Api\v1\User\Auth\AuthResource;

// Request Imports
use App\Http\Requests\Api\V1\User\Auth\AuthRequest;

class AuthController extends Controller
{
    public function authenticate(AuthRequest $request): AuthResource|JsonResponse
    {
        $user = User::where('email', $request->validated('email'))->first();

        if (! $user || ! Hash::check($request->validated('password'), $user->password)) {
            return response()->json([
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        $token = $user->createToken('user-token', ['*'], now()->addDay())->plainTextToken;

        return new AuthResource([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user('employee')->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
