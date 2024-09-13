<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Asumiendo que los usuarios autenticados son clientes
        $user = Auth::user(); // o Auth::guard('clientes')->user() si es un guard específico

        if ($user && $user->hasRole($role)) {
            return $next($request);
        }

        return redirect('/'); // Redirigir si no tiene el rol adecuado
    }
}
