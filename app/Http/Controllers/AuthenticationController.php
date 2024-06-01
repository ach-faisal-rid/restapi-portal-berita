<?php

namespace App\Http\Controllers;
use Hash;
use App\Models\User;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    // proses login
    public function login(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('user login')->plainTextToken;
        return response()->json([
            'message' => 'Login successful!',
            'access_token' => $token,
        ]);
    }

}
