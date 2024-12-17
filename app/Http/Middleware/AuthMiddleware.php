<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * Ce middleware empêchera les utilisateurs non authentifiés d'accéder à certaines routes comme la route '/me '
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
    if (!Auth::guard($guards)->check()) {
        abort(401, 'You are not allowed to access this resource');
    }
    return $next($request);
    }
}
