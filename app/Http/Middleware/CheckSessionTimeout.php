<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckSessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $idleTimeout = config('session.idle_timeout', 120);

        if (Auth::check() && $idleTimeout > 0) {
            $lastActivity = session('last_activity');

            if ($lastActivity) {
                $lastActivityTime = Carbon::createFromTimestamp($lastActivity);
                $now = Carbon::now();
                $secondsIdle = $now->diffInSeconds($lastActivityTime);
                $minutesIdle = ceil($secondsIdle / 60);

                if ($minutesIdle >= $idleTimeout) {
                    Auth::logout();
                    session()->flush();

                    return redirect()->route('login')
                        ->with('warning', 'Your session has expired due to inactivity. Please login again.');
                }
            }

            // Update last activity timestamp
            $lastUpdate = session('last_update_timestamp', 0);
            $timeSinceUpdate = time() - $lastUpdate;
            if ($timeSinceUpdate >= 300) { // Only update every 5 minutes
                session(['last_activity' => now()->timestamp, 'last_update_timestamp' => time()]);
            }
        }

        return $next($request);
    }
}
