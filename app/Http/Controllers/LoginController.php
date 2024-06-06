<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    function index()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('autentikasi.login.index');
    }

    function store(Request $request)
    {
        $request->validate([
            'username'     => 'required|string',
            'password'  => 'required|string'
        ]);

        $data = [
            'username'     => $request->username,
            'password'     => $request->password,
        ];

        if (Auth::attempt($data)) {
            return redirect()->route('dashboard')->with('message', 'Anda berhasil login');
        } else {
            return redirect()->route('login')->withInput()->with('warning', 'username atau password tidak valid !');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('message', 'Anda berhasil Logout !');
    }

}
