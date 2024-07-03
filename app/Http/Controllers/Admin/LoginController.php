<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (auth()->guard('web')->check()) {
            return redirect()->route('admin.home.index');
        }

        return view('admin.login');
    }

    public function login()
    {
        $data = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password harus diisi'
        ]);

        if (auth()->guard('web')->attempt($data)) {
            return redirect()->route('admin.home.index');
        }

        flash('Email atau password salah', 'danger');
    }

    // logout
    public function logout()
    {
        auth()->guard('web')->logout();
        return redirect()->route('admin.login');
    }
}
