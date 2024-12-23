<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laratrust\Models\LaratrustRole;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|array', // Mengizinkan array untuk role
            'role.*' => 'string|exists:roles,name', // Validasi setiap role harus ada di tabel roles
        ]);

        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Menyinkronkan role menggunakan Laratrust
        $user->syncRoles($request->role); // Menggunakan syncRoles untuk menyinkronkan role

        // Login pengguna
        Auth::login($user);

        // Mengembalikan respons JSON
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Pendaftaran berhasil. Silakan login.'
        ]);
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Coba login
        if (Auth::attempt($request->only('email', 'password'))) {
            // Jika berhasil, kembalikan respons JSON
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Login berhasil.',
            ]);
        }

        // Jika gagal, kembalikan respons JSON dengan kesalahan
        return response()->json([
            'success' => false,
            'code' => 401,
            'message' => 'The provided credentials do not match our records.',
        ], 401);
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login'); // Ganti dengan rute yang sesuai
    }
}
