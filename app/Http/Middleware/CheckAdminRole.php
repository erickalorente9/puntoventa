<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Verificar si el usuario está autenticado y tiene el rol de 'admin'
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                // Si es admin, dejarlo continuar en las rutas de admin
                return $next($request);
            } else {
                // Si es cliente, redirigirlo al home
                return redirect('/login')->with('error', 'No tienes acceso a esta área.');
            }
        }

        // Si no está autenticado, redirigirlo a la página de login
        return redirect('/login');
    }                 
}