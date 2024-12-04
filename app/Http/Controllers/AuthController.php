<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Afișarea formularului de înregistrare
    public function register()
    {
        return view('auth.register');
    }

    // 2. Procesarea datelor din formularul de înregistrare
    public function storeRegister(RegisterRequest $request)
    {
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Contul a fost creat cu succes!');
    }

    // 3. Afișarea formularului de autentificare
    public function login()
    {
        return view('auth.login');
    }

    // 4. Procesarea datelor din formularul de autentificare
    public function storeLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')->with('success', 'Autentificare reușită!');
        }

        return back()->withErrors([
            'email' => 'Datele introduse nu sunt corecte.',
        ]);
    }

    // 5. Deconectarea utilizatorului
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Te-ai deconectat cu succes!');
    }
}
