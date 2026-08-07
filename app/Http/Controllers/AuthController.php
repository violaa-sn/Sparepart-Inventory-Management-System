<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $request->session()->regenerate();

            // Cek apakah akun aktif
            if (!auth()->user()->isActive()) {

                Auth::logout();

                return back()
                    ->with('error', 'Akun Anda telah dinonaktifkan.')
                    ->onlyInput('email');
            }

            return redirect()
                ->intended(route('dashboard'))
                ->with('success', 'Login berhasil.');
        }

        return back()
            ->with('error', 'Email atau password salah.')
            ->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }
}
