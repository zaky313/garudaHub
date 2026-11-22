<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|string|min:8|max:72|confirmed',
            // admin tidak boleh dipilih sendiri saat mendaftar
            'role'     => ['required', Rule::in(['klien', 'developer'])],
        ]);

        // Password di-hash bcrypt otomatis lewat casts 'hashed' di model User
        $user = User::create($data);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('projects.index')
            ->with('success', 'Pendaftaran berhasil.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        // Ganti ID sesi setelah login (cegah session fixation)
        $request->session()->regenerate();

        return redirect()->intended(route('projects.index'))
            ->with('success', 'Selamat datang kembali.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah keluar.');
    }
}