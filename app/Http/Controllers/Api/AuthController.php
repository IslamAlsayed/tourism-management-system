<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Api\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['status' => 'error', 'data' => null, 'message' => __('auth.failed')], 401);
        }

        /** @var User $user */
        $user = Auth::user();
        $user->tokens()->where('name', 'api-token')->delete();
        $token = $user->createToken('api-token')->plainTextToken;

        $user->update(['last_login_at' => now(), 'last_login_ip' => $request->ip()]);

        $data = ['user' => new UserResource($user), 'token' => $token];
        return response()->json(['status' => 'success', 'data' => $data, 'message' => __('auth.login_successful')], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status' => 'success', 'data' => null, 'message' => __('auth.logout_successful')], 200);
    }
}
