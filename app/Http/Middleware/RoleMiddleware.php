<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
{
    if (!auth()->check()) {
        return redirect('/login');
    }

    if (!in_array(auth()->user()->role, $roles)) {
        abort(403);
    }

    if (auth()->user()->status != 'active') {
        Auth::logout();

        return redirect('/login')
            ->with('error','Your account has been suspended.');
    }

    return $next($request);
}
}
