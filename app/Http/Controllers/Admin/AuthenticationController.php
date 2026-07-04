<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->filled('remember'))) {

            return back()
                ->withErrors([
                    'email' => 'Invalid email or password.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');

        // Agar baad me roles lagane hain to ye use karna:
        /*
        if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin')){
            return redirect()->route('admin.dashboard');
        }

        if(auth()->user()->hasRole('Agent')){
            return redirect()->route('agent.dashboard');
        }

        return redirect('/');
        */
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
