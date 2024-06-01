<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
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

    // proses logout
    public function logout(Request $request) {
        // Invalidate the user's current access token
        $request->user()->currentAccessToken()->delete();

        // Use Laravel's built-in logout to invalidate session and other data
        Auth::logout();

        return response()->json([
            'message' => 'Logout successful!'
        ]);
    }

}
