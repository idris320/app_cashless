<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('Auth.login');
    }

    // Process login -
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Cari user berdasarkan username menggunakan Model User
        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Login user - PASTIKAN $user adalah instance dari Model User
            Auth::login($user); // <<-- INI YANG PERLU DIPASTIKAN
            $request->session()->regenerate();

            if ($user->role === 'admin') {
                return redirect()->intended('/dashboard')->with('successLogin', 'Selamat Datang');
            }
            
            return redirect()->intended('/wali/dashboard')->with('successLogin', 'Selamat Datang');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username'));
    }

    // Method lainnya juga pastikan menggunakan Model User
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:admin,wali_santri'
        ]);

        // PASTIKAN menggunakan Model User
        $user = User::create([        
            'username' => $validated['username'],
            'email' => $validated['email'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => $validated['role']
        ]);

        Auth::login($user);

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard')->with('success', 'Registrasi berhasil!');
        }
        
        return redirect('/wali/dashboard')->with('success', 'Registrasi berhasil!');
    }

    // Process logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('successLogout', 'Berhasil logout');
    }
}