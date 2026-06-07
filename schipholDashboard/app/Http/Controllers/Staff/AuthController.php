<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function loginForm()
    {
        if (Auth::guard('staff')->check()) {
            return redirect()->route('staff.dashboard');
        }

        return view('staff.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('staff')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return $this->redirectByRole();
        }

        return back()
            ->withErrors(['email' => 'Ongeldige inloggegevens. Probeer het opnieuw.'])
            ->onlyInput('email');
    }


    public function logout(Request $request)
    {
        Auth::guard('staff')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('staff.login');
    }

    //helperz

    private function redirectByRole(): \Illuminate\Http\RedirectResponse
    {
        $role = Auth::guard('staff')->user()->role;

        return match ($role) {
            'directeur'   => redirect()->route('reports.index'),
            'coordinator' => redirect()->route('flights.manage'),
            default       => redirect()->route('staff.dashboard'),
        };
    }
}
