<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        if (auth()->guard('web')->check()) {
            return redirect()->route('home');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $data = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password harus diisi'
        ]);

        // auth check email, password and role
        if (auth()->guard('web')->attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ])) {
            return redirect()->route("home");
        }

        flash('Email atau password salah', 'danger');
        return redirect()->back();
    }

    public function logout()
    {
        auth()->guard('web')->logout();
        return redirect()->route('login');
    }
}
