<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function index()
    {
        return view('login-siswa');
    }

    public function admin()
    {
        return view('login-admin');
    }

    public function actionLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Hindari session fixation

            $user = Auth::user();


            if ($user->role == 2) {
                return redirect('/siswa'); // redirect ke halaman siswa
            }

            if ($user->role == 1) {
                return redirect('/');
            }

            Auth::logout();
            return back()->withErrors([
                'validate' => 'Role tidak dikenali.',
            ])->onlyInput('username');
        }

        return back()->withErrors([
            'validate' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {


        Auth::logout(); // Logout user

        $request->session()->invalidate(); // Hapus session
        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect('/login'); // Redirect ke halaman login
    }
}
