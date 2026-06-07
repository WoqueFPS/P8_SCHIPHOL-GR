<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TermsController extends Controller
{
    public function showTerms(Request $request)
    {
        if (!$request->session()->has('pending_registration')) {
            return redirect()->route('register');
        }

        return view('auth.terms');
    }

    public function acceptTerms(Request $request)
    {
        $request->validate([
            'agree' => 'required|accepted',
        ]);

        $userData = $request->session()->get('pending_registration');

        if (!$userData) {
            return redirect()->route('register')->withErrors(['error' => 'Registratie sessie verlopen.']);
        }

        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => $userData['password'],
            'is_active' => true,
            'terms_accepted_at' => now(),
        ]);

        $request->session()->forget('pending_registration');

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/dashboard');
    }

    public function rejectTerms(Request $request)
    {
        // geen account gemaakt
        $request->session()->forget('pending_registration');

        return redirect('/')->with('info', 'Registratie geannuleerd.');
    }
}