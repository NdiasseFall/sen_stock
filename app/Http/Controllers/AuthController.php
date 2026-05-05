<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'prenom' => 'required | string | max:255',
            'nom' => 'required | string | max:255',
            'email' => 'required | email | unique:users,email',
            'password' => 'required | string ',
            'role' => 'required | string'
        ]);

        // Vérification si l'email existe déjà
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'error' => 'Cet email est déjà utilisé'
            ], 409); // 409 = Conflict
        }

        $user = User::create([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        return response()->json(['success' => 'Inscription avec success'], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);


        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Email or password is wrong'], 401);
        }

        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion établie',
            'token' => $token
        ], 200);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Déconnexion réussie'], 200);
    }
}
