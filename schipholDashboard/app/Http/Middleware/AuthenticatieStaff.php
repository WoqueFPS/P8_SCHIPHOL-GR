<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateStaff
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('staff')->check()) {
            return redirect()->route('staff.login')
                ->with('error', 'Je moet ingelogd zijn als medewerker om deze pagina te bekijken.');
        }

        return $next($request);
    }
}
