<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    return response()->json(['message' => 'Utilisateur cree', 'user' => $user], 201);
}


protected function repondToken($token)
{
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60,
    ]);
}

public function login(Request $request)
{
    $credentials = $request->only('email', 'password');
    if (!$token = auth()->attempt($credentials)) {
        return response()->json(['error' => 'Identifiants invalides'], 401);
    }
    return $this->repondToken($token);
}

public function refresh()
{
    return $this->repondToken(auth()->refresh());
}

public function logout()
{
    auth()->logout();
    return response()->json(['message' => 'Déconnecté avec succès']);
}

public function profile()
{
    return response()->json(auth()->user());
}
}
