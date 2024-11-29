<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            return response()->json([
                'user' => $user,
                'message' => 'Login successful'
            ]);
        }

        return response()->json([
            'message' => 'Identifiants incorrects'
        ], 401);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logged out successfully']);
    }

    // Route de test pour vérifier si l'utilisateur est authentifié
    public function user()
    {
        return response()->json(Auth::user());
    }
}