<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        // Validasi input (opsional tapi sangat disarankan)
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Login berhasil
            return redirect()->intended('dashboard');
        }

        // Login gagal
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->withInput();
    }
}
