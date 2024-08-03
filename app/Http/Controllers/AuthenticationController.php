<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    // proses register
    public function register(Request $request) {
        $request->validate([
            'username' => 'required|name|unique',
            'email' => 'required|email|unique',
            'name' => 'required|name',
            'password' => 'required',
            'phone' => ['nullable', 'string', 'max:255'],
        ]);


        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user = User::where('email', $request->email)->first();

        $tokenResult = $user->createToken('authToken')->plainTextToken;


        return response()->json([
            'data' => $user,
            'token' => $tokenResult,
            'token_type' => 'Bearer',
            'message' => 'registrasi berhasil !'
        ], 201);
    }

    // cek current user
    public function current(Request $request) {
        return response()->json(Auth::user());
    }

    // proses logout
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout successful!'
        ]);
    }

}
