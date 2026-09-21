<?php

namespace App\Http\Controllers\Api\V1\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\Auth\AuthRequest;
use App\Http\Resources\Api\v1\Admin\Auth\AuthResource;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

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
}
