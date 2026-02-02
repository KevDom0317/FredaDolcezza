<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect('/login');
        }

        // 2. Verificar si el usuario es admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'No tienes permiso para acceder.');
        }

        // 3. Todo bien, continúa
        return $next($request);
    }
}
