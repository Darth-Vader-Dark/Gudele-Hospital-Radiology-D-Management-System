<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route as RouteFacade;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            $user = auth()->guard($guard)->user();
            if ($user && auth()->guard($guard)->check()) {
                $roleRoute = $user->role . '.dashboard';
                if (RouteFacade::has($roleRoute)) {
                    return redirect()->route($roleRoute);
                }
                // Fallback to home route or login if the role route is missing
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
