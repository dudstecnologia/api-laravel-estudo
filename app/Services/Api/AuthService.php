<?php

namespace App\Services\Api;

use App\User;
use Throwable;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public static function register($request)
    {
        try {
            $user = User::create($request);

            $token = auth()->login($user);

            return self::respondWithToken($token);
        } catch (Throwable $th) {
            return response(['message' => $th->getMessage()], 401);
        }
    }

    public static function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
