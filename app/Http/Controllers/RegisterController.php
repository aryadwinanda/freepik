<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        if (auth()->guard('web')->check()) {
            return redirect()->route('home');
        }

        return view('register');
    }

    public function register(Request $request)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi'
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'user'
        ]);

        if ($user) {
            flash('Registrasi berhasil, silahkan login', 'success');
            return redirect()->route('login');
        }
        else {
            flash('Registrasi gagal', 'danger');
        }
    }
}
