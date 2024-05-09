<?php

namespace App\Http\Controllers\Api;

class AuthController extends Controller
{
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['success' => false,'message' => 'Incorrect login or password!'], 401);
        }

        return response()->json(['success' => true, 'token' => $token]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['success' => true]);
    }

    public function refresh()
    {

        $token = auth()->refresh();

        return response()->json(['success' => true, 'token' => $token]);
    }
}
