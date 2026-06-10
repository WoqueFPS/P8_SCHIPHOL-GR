<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckStaffRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $staff = Auth::guard('staff')->user();
        if (!$staff){
            abort(403, 'Je bent niet ingelogd.');
        }

        foreach ($roles as $role){
            if ($staff->role === $role){
                return $next($request);
            }
        }

        abort(403, 'Je hebt geen toegang tot deze pagina. Alleen toegankelijk voor: ' . implode(', ', $roles));
    }
}