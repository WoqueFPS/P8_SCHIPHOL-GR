<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTermsAccepted
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        // Als user ingelogd is EN terms niet geaccepteerd heeft
        if ($user && !$user->terms_accepted) {
            // Sta alleen terms routes toe, redirect alles naar terms
            if (!$request->routeIs('terms') && 
                !$request->routeIs('terms.accept') && 
                !$request->routeIs('terms.reject') &&
                !$request->routeIs('logout')) {
                return redirect()->route('terms');
            }
        }
        
        return $next($request);
    }
}
