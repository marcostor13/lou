<?php

namespace Lou\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $role = explode(';', $role);
        
        if (! $request->user()->authorizeRoles($role)) {
            abort(403, 'No tiene permiso para ingresar a esta página');
        }
    return $next($request);
    }
}
