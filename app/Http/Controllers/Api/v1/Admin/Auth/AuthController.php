<?php

namespace App\Http\Controllers\Api\V1\Admin\Auth;

// Laravel Imports
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

// Model Imports
use App\Models\Admin;

// Request Imports
use App\Http\Requests\Api\V1\Admin\Auth\AuthRequest;

// Resource Imports
use App\Http\Resources\Api\v1\Admin\Auth\AuthResource;

// Controller Imports 
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function authenticate(AuthRequest $request): AuthResource|JsonResponse
    {
        $admin = Admin::where('email', $request->validated('email'))->first();

        if (! $admin || ! Hash::check($request->validated('password'), $admin->password)) {
            return response()->json([
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        $token = $admin->createToken('admin-token', ['*'], now()->addDay())->plainTextToken;

        return new AuthResource([
            'admin' => $admin,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user('admin')->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
