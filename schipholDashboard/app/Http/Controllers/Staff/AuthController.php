<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;

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
        $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required'],
        ]);

        $loginInput = $request->input('login');
        $isEmail = filter_var($loginInput, FILTER_VALIDATE_EMAIL);

        $staffMember = Staff::where('email', $loginInput)
            ->orWhere('employee_id', $loginInput)
            ->first();

        if ($staffMember) {
            // extra restrictie als de gebruiker een coordinator is mag het geen emailadres zijn
            if ($staffMember->isCoordinator() && $isEmail) {
                return back()
                    ->withErrors(['login' => 'Coördinatoren dienen verplicht in te loggen met hun Personeelsnummer (User ID).'])
                    ->onlyInput('login');
            }
        }

        $loginType = $isEmail ? 'email' : 'employee_id';

        $credentials = [
            $loginType => $loginInput,
            'password' => $request->input('password'),
        ];

        if (Auth::guard('staff')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return $this->redirectByRole();
        }

        // standaard foutmelding bij onjuist wachtwoord of onbekende gebruiker
        return back()
            ->withErrors(['login' => 'Ongeldige inloggegevens. Probeer het opnieuw.'])
            ->onlyInput('login');
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
            'directeur'   => redirect()->route('staff.reports.index'),
            'coordinator' => redirect()->route('staff.flights.manage'),
            default       => redirect()->route('staff.dashboard'),
        };
    }
}
