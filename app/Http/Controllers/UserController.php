<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Proses ganti email, username, dan profil
    public function updateProfile(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'username' => 'required|unique:users,username,' . Auth::id(),
            'firstname' => 'required|string|max:100',
            'lastname' => 'nullable|string|max:100',
            'profil' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // validasi contoh untuk upload gambar
        ]);

        $user = Auth::user();

        $user->email = $request->email;
        $user->username = $request->username;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;

        // Handling profile image upload
        if ($request->hasFile('profil')) {
            $profil = $request->file('profil');
            $filename = time() . '.' . $profil->getClientOriginalExtension();
            $path = $profil->storeAs('public/profil', $filename);
            $user->profil = basename($path);
        }

        $user = User::create($request->all());

        return response()->json(['message' => 'Profile has been updated successfully']);
    }

    // Proses ganti password
    public function changePassword(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect']);
        }

        // Memperbarui password langsung tanpa menyimpan melalui $user->save()
        User::where('id', $user->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password has been changed successfully');
    }
}
