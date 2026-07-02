<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    // Login template view load karega
    public function showLogin()
    {
        return view('auth.login');
    }

    // Authenticate and check role alignment
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', 'string']
        ]);

        $remember = $request->has('remember');

        // Check if user exists with matching credentials and role context
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            
            $user = Auth::user();

            // Validate interface context role match database role
            if ($user->role !== $credentials['role']) {
                Auth::logout();
                return back()->withErrors([
                    'email' => "Access denied. Target account is not assigned as a {$credentials['role']}.",
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            // Route dynamic routing base on user scope roles
            if ($user->role === 'mentor') {
                return redirect()->intended('/mentor/dashboard');
            } elseif ($user->role === 'intern') {
                return redirect()->intended('/intern/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our database records.',
        ])->onlyInput('email');
    }

    // Secure logout session destruction
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}