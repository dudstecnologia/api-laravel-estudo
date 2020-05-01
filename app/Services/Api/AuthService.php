<?php

namespace App\Services\Api;

use App\User;
use Throwable;

class AuthService
{
    public static function register($request)
    {
        try {
            $user = User::create($request);

            $token = auth()->login($user);

            return self::respondWithToken($token);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 401);
        }
    }

    public function login($request)
    {
        if (!$token = auth()->attempt($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return self::respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Deslogado com sucesso']);
    }

    public function refresh()
    {
        return self::respondWithToken(auth()->refresh());
    }

    public function user()
    {
        return response()->json(auth()->user());
    }

    protected static function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
